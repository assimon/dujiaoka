<?php

namespace App\Http\Controllers\Pay;

use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use Illuminate\Http\Request;
use Yansongda\Pay\Pay;

class AlipayController extends PayController
{

    /**
     * 支付宝支付网关
     *
     * @param string $payway
     * @param string $orderSN
     */
    public function gateway(string $payway, string $orderSN)
    {
        try {
            // 加载网关
            $this->loadGateWay($orderSN, $payway);
            $config = [
                'app_id' => $this->payGateway->merchant_id,
                'ali_public_key' => $this->payGateway->merchant_key,
                'private_key' => $this->payGateway->merchant_pem,
                'notify_url' => url($this->payGateway->pay_handleroute . '/notify_url'),
                'return_url' => url('detail-order-sn', ['orderSN' => $this->order->order_sn]),
                'http' => [ // optional
                    'timeout' => 10.0,
                    'connect_timeout' => 10.0,
                ],
            ];
            $order = [
                'out_trade_no' => $this->order->order_sn,
                'total_amount' => (float)$this->order->actual_price,
                'subject' => $this->order->title
            ];
            switch ($payway){
                case 'zfbf2f':
                case 'alipayscan':
                    try{
                        $result = Pay::alipay($config)->scan($order)->toArray();
                        $result['payname'] = $this->payGateway->pay_name;
                        $result['actual_price'] = (float)$this->order->actual_price;
                        $result['orderid'] = $this->order->order_sn;
                        $result['jump_payuri'] = $result['qr_code'];
                        return $this->render('static_pages/qrpay', $result, __('dujiaoka.scan_qrcode_to_pay'));
                    } catch (\Exception $e) {
                        return $this->err(__('dujiaoka.prompt.abnormal_payment_channel') . $e->getMessage());
                    }
                case 'aliweb':
                    try{
                        $result = Pay::alipay($config)->web($order);
                        return $result;
                    } catch (\Exception $e) {
                        return $this->err(__('dujiaoka.prompt.abnormal_payment_channel') . $e->getMessage());
                    }
            }
        } catch (RuleValidationException $exception) {
            return $this->err($exception->getMessage());
        }
    }


    /**
     * 异步通知
     */
    public function notifyUrl(Request $request)
    {
        $orderSN = $request->input('out_trade_no');
        $order = $this->orderService->detailOrderSN($orderSN);
        if (!$order) {
            return 'error';
        }
        $payGateway = $this->payService->detail($order->pay_id);
        if (!$payGateway) {
            return 'error';
        }
        $config = [
            'app_id' => $payGateway->merchant_id,
            'ali_public_key' => $payGateway->merchant_key,
            'private_key' => $payGateway->merchant_pem,
        ];
        $pay = Pay::alipay($config);
        try{
            // 验证签名
            $result = $pay->verify();
            if ($result->trade_status == 'TRADE_SUCCESS' || $result->trade_status == 'TRADE_FINISHED') {
                $this->orderProcessService->completedOrder($result->out_trade_no, $result->total_amount, $result->trade_no);
            }
            return 'success';
        } catch (\Exception $exception) {
            return 'fail';
        }
    }



}
