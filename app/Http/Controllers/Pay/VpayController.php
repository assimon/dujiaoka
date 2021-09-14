<?php
/**
 * VpayController.php
 * V免签
 * Author iLay1678
 * Created on 2020/5/1 11:59
 */

namespace App\Http\Controllers\Pay;

use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use Illuminate\Http\Request;

class VpayController extends PayController
{


    public function gateway(string $payway, string $orderSN)
    {
        try {
            // 加载网关
            $this->loadGateWay($orderSN, $payway);

            //构造要请求的参数数组，无需改动
            $parameter = array(
                "payId" => date('YmdHis') . rand(1, 65535),//平台ID号
                "price" => (float)$this->order->actual_price,//原价
                'param' => $this->order->order_sn,
                'returnUrl' => route('vpay-return', ['order_id' => $this->order->order_sn]),
                'notifyUrl' => url($this->payGateway->pay_handleroute . '/notify_url'),
                "isHtml" => 1,
            );
            switch ($payway) {
                case 'vzfb':
                    $parameter['type'] = 2;
                    break;
                case 'vwx':
                default:
                    $parameter['type'] = 1;
                    break;
            }
            $parameter['sign'] = md5($parameter['payId'] . $parameter['param'] . $parameter['type'] . $parameter['price'] . $this->payGateway->merchant_id);
            $payurl = $this->payGateway->merchant_pem . 'createOrder?' . http_build_query($parameter); //支付页面
            return redirect()->away($payurl);
        } catch (RuleValidationException $exception) {
            return $this->err($exception->getMessage());
        }
    }


    public function notifyUrl(Request $request)
    {
        $data = $request->all();
        $order = $this->orderService->detailOrderSN($data['param']);
        if (!$order) {
            return 'fail';
        }
        $payGateway = $this->payService->detail($order->pay_id);
        if (!$payGateway) {
            return 'fail';
        }

        $key = $payGateway->merchant_id;//通讯密钥
        $payId = $data['payId'];//商户订单号
        $param = $data['param'];//创建订单的时候传入的参数
        $type = $data['type'];//支付方式 ：微信支付为1 支付宝支付为2
        $price = $data['price'];//订单金额
        $reallyPrice = $data['reallyPrice'];//实际支付金额
        $sign = $data['sign'];//校验签名，计算方式 = md5(payId + param + type + price + reallyPrice + 通讯密钥)
        //开始校验签名
        $_sign = md5($payId . $param . $type . $price . $reallyPrice . $key);
        if ($_sign != $sign) { //不合法的数据
            return 'fail';  //返回失败 继续补单
        } else { //合法的数据
            //业务处理
            $this->orderProcessService->completedOrder($param, $price, $payId);
            return 'success';
        }
    }

    public function returnUrl(Request $request)
    {
        $oid = $request->get('order_id');
        // 异步通知还没到就跳转了，所以这里休眠2秒
        sleep(2);
        return redirect(url('detail-order-sn', ['orderSN' => $oid]));
    }

}
