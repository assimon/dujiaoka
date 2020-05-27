<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2019-03-18
 * Time: 17:34
 */

namespace App\Http\Controllers\Pay;


use App\Http\Controllers\Controller;

use App\Jobs\SendMails;
use App\Models\Cards;
use App\Models\Emailtpls;
use App\Models\Orders;
use App\Models\Pays;
use App\Models\Products;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;


class PayController extends Controller
{

    /**
     * @var 订单详情
     */
    protected $orderInfo;

    /**
     * @var 支付详情
     */
    protected $payInfo;

    /**
     * 检查订单
     * @param $oid
     * @param $payway
     */
    protected function checkOrder($payway, $oid)
    {
        // 判断订单是否存在
        $this->orderInfo = json_decode(Redis::hget('PENDING_ORDERS_LIST', $oid), true);
        if (empty($this->orderInfo)) {
            return '订单不存在或已支付';
        }
        // 判断支付方式是否存在
        $this->payInfo = Pays::where(['id' => $payway,  'pay_status' => 1])->first();
        if (empty($this->payInfo)) {
            return '支付方式不存在或未启用';
        }
        return true;
    }

    /**
     * 订单完成方法
     * @param $out_trade_no
     * @param $trade_no
     * @param $total_amount
     */
    protected function successOrder($out_trade_no, $trade_no, $total_amount)
    {

        // 判断缓存里是否已经没有订单了，没有说明已经处理了
        $orderInfo = json_decode(Redis::hget('PENDING_ORDERS_LIST', $out_trade_no), true);
        if (empty($orderInfo)) return true;
        // 判断金额是否一致
        $cacheTamount = (float)$orderInfo['actual_price'];
        if ($cacheTamount != $total_amount) {
            Log::debug('异常订单！实际付款与订单总金额不一致！'.$out_trade_no);
            return false;
        }
        $order = [
            'order_id' => $orderInfo['order_id'],
            'product_id' => $orderInfo['product_id'],
            'coupon_id' => $orderInfo['coupon_id'] ?? 0,
            'ord_class' => $orderInfo['pd_type'],
            'product_price' => $orderInfo['product_price'],
            'ord_price' => $total_amount,
            'buy_amount' => $orderInfo['buy_amount'],
            'ord_title' => $orderInfo['product_name'] . 'x' . $orderInfo['buy_amount'],
            'search_pwd' => $orderInfo['search_pwd'],
            'account' => $orderInfo['account'],
            'pay_ord' => $trade_no,
            'pay_way' => $orderInfo['pay_way'],
            'buy_ip' => $orderInfo['buy_ip'],
            'ord_info' => ''
        ];
        // 区分订单类型
        if ($orderInfo['pd_type'] == 1) {
            //  卡密商品 查询出待发货的卡密到邮件队列
            $cardList = Cards::where(['product_id' => $orderInfo['product_id'], 'card_status' => 1])->take($orderInfo['buy_amount'])->get();
            if (empty($cardList) || count($cardList) != $orderInfo['buy_amount']) {
                $order['ord_info'] = '发卡异常请联系管理员核查!';
            } else {
                $cardUpdate = [];
                foreach ($cardList as $value) {
                    $cardUpdate[] = $value['id'];
                    $order['ord_info'] .= $value['card_info'].PHP_EOL;
                }
                // 批量更新
                Cards::whereIn('id', $cardUpdate)->update(['card_status' => 2]);
                $order['ord_status'] = 3;
            }
        } else {
            $order['ord_info'] = $orderInfo['other_ipu'];
            $order['ord_status'] = 1;
        }
        Orders::create($order);
        // 将订单信息载入待发送邮件队列
        $order['created_at'] = date('Y-m-d H:i:s');
        $order['product_name'] = $orderInfo['product_name'];
        $order['webname'] = config('webset.text_logo');
        $order['weburl'] = getenv('APP_URL');
        // 这里格式化一下把换行改成<br/>方便邮件
        $order['ord_info'] = str_replace(PHP_EOL, '<br/>', $order['ord_info']);
        //库存预警
        $pd=Products::where('id',$orderInfo['product_id'])->get()->first();
        if($pd['stock_alert'] != 0 && $pd['in_stock'] < $pd['stock_alert']){
            $product['webname'] = config('webset.text_logo');
            $product['weburl'] = getenv('APP_URL');
            $product['product_name']=$orderInfo['product_name'];
            $product['stock_alert']=$pd['stock_alert'];
            $product['in_stock']=$pd['in_stock'];
            $mailtpl = Emailtpls::where('tpl_token', 'manual_send_stock_alert_mail')->first()->toArray();
            $to = config('webset.manage_email');
            $mailtipsInfo = replace_mail_tpl($mailtpl, $product);
            if (!empty($to)) SendMails::dispatch($to, $mailtipsInfo['tpl_content'], $mailtipsInfo['tpl_name']);
        }
        // 判断订单类型
        if ($orderInfo['pd_type'] == 1) {
            // 发送邮箱给用户
            $mailtpl = Emailtpls::where('tpl_token', 'card_send_user_email')->first()->toArray();
            $to = $orderInfo['account'];
        }elseif ($orderInfo['pd_type'] == 2) {
            // 发送邮箱给用户
            $mailtpl = Emailtpls::where('tpl_token', 'wait_send_user_email')->first()->toArray();
            $to = $orderInfo['account'];
            //发邮件给管理员
            $mailtpl1 = Emailtpls::where('tpl_token', 'manual_send_manage_mail')->first()->toArray();
            $to1 = config('webset.manage_email');
            $mailtipsInfo1 = replace_mail_tpl($mailtpl1, $order);
            if (!empty($to1)) SendMails::dispatch($to1, $mailtipsInfo1['tpl_content'], $mailtipsInfo1['tpl_name']);
         }
        $mailtipsInfo = replace_mail_tpl($mailtpl, $order);
        if (!empty($to)) SendMails::dispatch($to, $mailtipsInfo['tpl_content'], $mailtipsInfo['tpl_name']);
        // 商品销量+
        Products::where('id', $order['product_id'])->increment('sales_volume', $order['buy_amount']);
        Redis::hdel('PENDING_ORDERS_LIST', $out_trade_no);
        //载入成功缓存
        Redis::hset('ORDERS_SUCCESS_LIST', $orderInfo['order_id'], 'success');
    }

}
