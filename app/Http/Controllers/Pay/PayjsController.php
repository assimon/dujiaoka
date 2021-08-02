<?php
namespace App\Http\Controllers\Pay;

use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use Illuminate\Http\Request;
use Xhat\Payjs\Facades\Payjs;


class PayjsController extends PayController
{

    public function gateway(string $payway, string $orderSN)
    {
        try {
            // 加载网关
            $this->loadGateWay($orderSN, $payway);
            // 构造订单基础信息
            $data = [
                'body' => $this->order->title,                                // 订单标题
                'total_fee' => bcmul($this->order->actual_price, 100, 0),    // 订单金额
                'out_trade_no' => $this->order->order_sn,                           // 订单号
                'notify_url' => url($this->payGateway->pay_handleroute . '/notify_url'),
            ];
            config(['payjs.mchid' => $this->payGateway->merchant_id, 'payjs.key' => $this->payGateway->merchant_pem]);
            switch ($payway){
                case 'payjswescan':
                    try{
                        $payres = Payjs::native($data);
                        if ($payres['return_code'] != 1) {
                            throw new RuleValidationException($payres['return_msg']);
                        }
                        $result['payname'] = $this->payGateway->pay_name;
                        $result['actual_price'] = (float)$this->order->actual_price;
                        $result['orderid'] = $this->order->order_sn;
                        $result['qr_code'] = $payres['code_url'];
                        return $this->render('static_pages/qrpay', $result, __('dujiaoka.scan_qrcode_to_pay'));
                    } catch (\Exception $e) {
                        throw new RuleValidationException(__('dujiaoka.prompt.abnormal_payment_channel') . $e->getMessage());
                    }
                    break;
            }
        } catch (RuleValidationException $exception) {
            return $this->err($exception->getMessage());
        }
    }


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
        config(['payjs.mchid' => $payGateway->merchant_id, 'payjs.key' => $payGateway->merchant_pem]);
        $notify_info = Payjs::notify();
        $totalFee = bcdiv($notify_info['total_fee'], 100, 2);
        $this->orderProcessService->completedOrder($notify_info['out_trade_no'], $totalFee, $notify_info['payjs_order_id']);
        return 'success';
    }

}
