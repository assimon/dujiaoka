<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2019-03-18
 * Time: 17:34
 */

namespace App\Http\Controllers\Pay;


use App\Api\Helpers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Models\CardList;
use App\Models\Orders;
use App\Models\OrderStatistics;
use App\Models\Payconfig;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Models\Commodity;


class PayController extends Controller
{

    use ApiResponse;

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
     * @param $id
     * @param $oid
     * @param $pay_pay_check
     */
    protected function checkOrder($id, $oid, $pay_pay_check)
    {
        // 判断订单是否存在
        $this->orderInfo = json_decode(Redis::hget(config('PENDING_ORDERS_LIST'), $oid), true);
        if (empty($this->orderInfo)) {
            return '订单不存在或已支付';
        }
        // 判断支付方式是否存在
        $this->payInfo = Payconfig::where(['id' => $id, 'pay_check' => $pay_pay_check, 'pay_status' => 1])->first();
        if (empty($this->payInfo)) {
            return '支付方式不存在或未启用';
        }
        $this->orderInfo['pay_id'] = $id;
        $this->orderInfo['pay_check'] = $pay_pay_check;
        Redis::hset(config('PENDING_ORDERS_LIST'), $oid, json_encode($this->orderInfo));
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
        $orderInfo = json_decode(Redis::hget(config('PENDING_ORDERS_LIST'), $out_trade_no), true);
        if (empty($orderInfo)) return true;
        // 判断金额是否一致
        $cacheTamount = (float)$orderInfo['actual_price'];
        if ($cacheTamount != $total_amount) {
            Log::debug('异常订单！实际付款与订单总金额不一致！'.$out_trade_no);
            return false;
        }
        $order = [
            'oid' => $orderInfo['oid'],
            'pd_id' => $orderInfo['pid'],
            'pd_money' => $orderInfo['actual_price'],
            'ord_countmoney' => $total_amount,
            'ord_num' => $orderInfo['ord_num'],
            'ord_name' => $orderInfo['pname'] . 'x' . $orderInfo['ord_num'],
            'search_pwd' => $orderInfo['search_pwd'],
            'rcg_account' => $orderInfo['rcg_account'],
            'pay_ord' => $trade_no,
            'pay_type' => $orderInfo['pay_id'],
            'ord_info' => ''
        ];
        //  卡密商品 查询出待发货的卡密到邮件队列
        $cardList = CardList::where(['card_pd' => $orderInfo['pid'], 'cd_status' => 1])->limit($orderInfo['ord_num'])->get();
        $cardUpdate = [];
        foreach ($cardList as $value) {
            $cardUpdate[] = ['id' => $value['id'], 'cd_status' => 2];
            $order['ord_info'] .= $value['card_info'].PHP_EOL;
        }
        // 批量更新
        app(CardList::class)->updateBatch($cardUpdate);
        $order['ord_status'] = 3;
        $order['created_at'] = date('Y-m-d H:i:s');
        Orders::create($order);
        // 这里格式化一下把换行改成<br/>方便邮件
        $order['ord_info'] = str_replace(PHP_EOL, '<br/>', $order['ord_info']);
        // 将订单信息载入待发送邮件队列
        SendEmail::dispatch($order)->onQueue('emails');
        // 商品销量+
        Commodity::where('id', '=', $order['pd_id'])->increment('sales_volume', $order['ord_num']);
        // 订单统计
        $orderSta = OrderStatistics::where('count_day', '=', date('Y-m-d', time()))->first();
        if (empty($orderSta)) {
            $orderStaData = [
                'count_ord' => $order['ord_num'],
                'count_money' => $total_amount,
                'count_pd' => $order['ord_num'],
                'count_day' => date('Y-m-d', time())
            ];
            OrderStatistics::create($orderStaData);
        } else {
            OrderStatistics::where('count_day', '=', date('Y-m-d', time()))->increment('count_ord', 1);
            OrderStatistics::where('count_day', '=', date('Y-m-d', time()))->increment('count_money', $total_amount);
            OrderStatistics::where('count_day', '=', date('Y-m-d', time()))->increment('count_pd', $order['ord_num']);
        }
        Redis::hdel(config('PENDING_ORDERS_LIST'), $out_trade_no);
        //载入成功缓存
        Redis::hset(config('ORDERS_SUCCESS_LIST'), $orderInfo['oid'], 'success');
    }

}