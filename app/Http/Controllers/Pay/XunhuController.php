<?php

namespace App\Http\Controllers\Pay;

use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use App\Models\Order;

class XunhuController extends PayController
{
    /**
     *  虎皮椒v3支付网关
     * @return void
     */
    public function gateway(string $payway, string $orderSN)
    {
        try {
            //加载网关
            $this->loadGateWay($orderSN, $payway);
            $config = [
                'version' => '1.1',
                'appid' => $this->payGateway->merchant_id,
                'trade_order_id' => $this->order->order_sn,
                'total_fee' => (float)$this->order->actual_price,
                'title' => $this->order->order_sn,
                'time' => time(),
                'notify_url' => url($this->payGateway->pay_handleroute . '/notify_url'),
                'return_url' => url('detail-order-sn', ['orderSN' => $this->order->order_sn]),
                'nonce_str' => $this->getNonceStr(),
            ];
            $config['hash'] = $this->getSign($config, $this->payGateway->merchant_key);
            $client = new \GuzzleHttp\Client();
            $response = $client->post($this->payGateway->merchant_pem, [
                'json' => $config
            ]);
            $res = json_decode($response->getBody()->getContents(), true);
            if($res['errcode'] == 0){
                return redirect()->away($res['url']);
            } else {
                return $this->err(__('dujiaoka.prompt.abnormal_payment_channel') . $res['errmsg']);
            }

        } catch (RuleValidationException $e) {
            return $this->err($e->getMessage());
        }

    }

    //get nonce_str
    public function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    //hash
    public function getSign($data, $key)
    {
        ksort($data);
        $string = '';
        foreach ($data as $k => $v) {
            $string .= $k . '=' . $v . '&';
        }
        $string = rtrim($string, '&');
        $string = $string . $key;
        return md5($string);
    }

    //notify_url
    public function notifyUrl(Request $request)
    {
        //验证签名
        $data = $request->all();
        $sign = $data['hash'];
        unset($data['hash']);
        $hash = $this->getSign($data, $this->payGateway->merchant_key);
        if ($sign != $hash) {
            return 'fail';
        }
        //验证订单
        $order = Order::where('order_sn', $data['trade_order_id'])->first();
        if (!$order) {
            return 'fail';
        }
        //验证金额
        if ($order->actual_price != $data['total_fee']) {
            return 'fail';
        }
        $this->orderProcessService->completedOrder($order);
        return 'success';
    }

    //return_url
    public function returnUrl(Request $request)
    {
        $oid = $request->get('trade_order_id');
        // 异步通知还没到就跳转了，所以这里休眠2秒
        sleep(2);
        return redirect(url('detail-order-sn', ['orderSN' => $oid]));
    }
}
