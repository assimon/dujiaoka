<?php
namespace App\Http\Controllers\Pay;

use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use Illuminate\Http\Request;

class MugglepayController extends PayController
{

    public function gateway(string $payway, string $orderSN)
    {
        try {
            // 加载网关
            $this->loadGateWay($orderSN, $payway);
            //构造要请求的参数数组，无需改动
            switch ($payway) {
                case 'mgcoin':
                default:
                    try {
                        $arr['price_amount'] =  (float)$this->order->actual_price;
                        $arr['price_currency'] = 'CNY';
                        $arr['merchant_order_id'] = $this->order->order_sn;
                        $arr['title'] =  $this->order->title;
                        $arr['description'] =  $this->order->title;
                        $arr['token'] = md5($this->order->order_sn . 'CNY' . $this->payGateway->merchant_id);
                        $arr['callback_url'] = url($this->payGateway->pay_handleroute . '/notify_url');
                        $arr['cancel_url'] = site_url();
                        $arr['success_url'] = url('detail-order-sn', ['orderSN' => $this->order->order_sn]);
                        $accesstoken = $this->payGateway->merchant_id;
                        $curl = curl_init();
                        curl_setopt_array($curl, array(CURLOPT_URL => "https://api.mugglepay.com/v1/orders", CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 0, CURLOPT_FOLLOWLOCATION => true, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => http_build_query($arr), CURLOPT_HTTPHEADER => array("token:$accesstoken", "Content-Type: application/x-www-form-urlencoded")));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        $payment_url = json_decode($response, true)['payment_url'];
                        return redirect()->away($payment_url);
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
        $data = json_decode(file_get_contents('php://input'),true);
        $order = $this->orderService->detailOrderSN($data['merchant_order_id']);
        if (!$order) {
            return 'fail';
        }
        $payGateway = $this->payService->detail($order->pay_id);
        if (!$payGateway) {
            return 'fail';
        }

        if (!$data['token'] || $data['token'] != md5($data['merchant_order_id']. 'CNY' . $payGateway->merchant_id)) {
            //不合法的数据
            return 'fail';
            //返回失败 继续补单
        } else {
            //合法的数据
            //业务处理
            $this->orderProcessService->completedOrder($data['merchant_order_id'], $data['pay_amount'], $data['order_id']);
            return "{\"status\": 200}";
        }
    }

}
