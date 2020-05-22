<?php
/**
 * VpayController.php
 * V免签
 * Author iLay1678
 * Created on 2020/5/1 11:59
 */

namespace App\Http\Controllers\Pay;


use App\Models\Pays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class VpayController extends PayController
{


    public function gateway($payway, $oid)
    {

        $check = $this->checkOrder($payway, $oid);
        if ($check !== true) {
            return $this->error($check);
        }
        //构造要请求的参数数组，无需改动
        $parameter = array(
            "payId" => date('YmdHis') . rand(1, 65535),//平台ID号
            "price" => (float)$this->orderInfo['actual_price'],//原价
            'param' => $this->orderInfo['order_id'],
            'returnUrl' => site_url() . $this->payInfo['pay_handleroute'] . '/return_url?order_id=' . $this->orderInfo['order_id'],
            'notifyUrl' => site_url() . $this->payInfo['pay_handleroute'] . '/notify_url',
            "isHtml" => 1,
        );
        switch ($this->payInfo['pay_check']) {
            case 'vzfb':
                $parameter['type'] = 2;
                break;
            case 'vwx':
            default:
                $parameter['type'] = 1;
                break;
        }
        $parameter['sign'] = md5($parameter['payId'] . $parameter['param'] . $parameter['type'] . $parameter['price'] . $this->payInfo['merchant_id']);
        //$result = file_get_contents(self::PAY_URI.'createOrder?'.http_build_query($result));
        $payurl = $this->payInfo['merchant_pem'] . 'createOrder?' . http_build_query($parameter); //支付页面
        return redirect()->away($payurl);
    }


    public function notifyUrl(Request $request)
    {
        $data = $request->all();
        $cacheord = json_decode(Redis::hget('PENDING_ORDERS_LIST', $data['param']), true);
        if (!$cacheord) {
            return 'fail';
        }
        $payInfo = Pays::where('id', $cacheord['pay_way'])->first();
        $key = $payInfo['merchant_id'];//通讯密钥
        $payId = $data['payId'];//商户订单号
        $param = $data['param'];//创建订单的时候传入的参数
        $type = $data['type'];//支付方式 ：微信支付为1 支付宝支付为2
        $price = $data['price'];//订单金额
        $reallyPrice = $data['reallyPrice'];//实际支付金额
        $sign = $data['sign'];//校验签名，计算方式 = md5(payId + param + type + price + reallyPrice + 通讯密钥)
//开始校验签名
        $_sign = md5($payId . $param . $type . $price . $reallyPrice . $key);

        $query = create_link_string($data);
        if ($_sign != $sign) { //不合法的数据
            return 'fail';  //返回失败 继续补单
        } else { //合法的数据
            //业务处理
            $this->successOrder($param, $payId, $price);
            return 'success';
        }

    }

    public function returnUrl(Request $request)
    {
        $oid = $request->get('order_id');
        sleep(1);
        return redirect(site_url() . 'searchOrderById?order_id=' . $oid);
    }
}
