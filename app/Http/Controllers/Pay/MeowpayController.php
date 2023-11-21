<?php

namespace App\Http\Controllers\Pay;

use App\Http\Controllers\PayController;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;

class MeowpayController extends PayController
{
    public function gateway(string $payway, string $orderSN)
    {
        try {
            $this->loadGateWay($orderSN, $payway);
            $app_id = $this->payGateway->merchant_id;
            $currency_type = "CNY";
            $amount = bcmul($this->order->actual_price, 100, 0);
            $return_url = route('meowpay-return', ['order_id' => $this->order->order_sn]);
            $notify_url = null;
            // 需要自定义通知地址请删除下行，自定义通知地址请在 Meowpay APP 信息设置 https://meowpay.org/app/list
            $notify_url = url($this->payGateway->pay_handleroute . '/notify_url');
            $meowpay = new Payment($app_id, (string) $this->order->order_sn, $currency_type, (int)$amount, $return_url, $notify_url);
            $pay_link = $meowpay->get_pay_link();
            return redirect()->away($pay_link);
        } catch (GuzzleException $exception) {
            return $this->err($exception->getMessage());
        }
    }
    public function notifyUrl(Request $request)
    {
        $r = (object) $request->all();
        $params = (object) $r->{'params'};
        $app_id = $params->{'app_id'};
        $trade_no = $params->{'trade_no'};
        $orderSN = $trade_no;
        $order = $this->orderService->detailOrderSN($orderSN);
        if (!$order) {
            return 'error';
        }
        $payGateway = $this->payService->detail($order->pay_id);
        if (!$payGateway) {
            return 'error';
        }
        if ($payGateway->pay_handleroute != '/pay/meowpay') {
            return 'fail';
        }
        $payment_id = $params->{'payment_id'};
        $payGateway = $this->payService->detail($order->pay_id);
        $merchant_id = $payGateway->merchant_id;
        if ($app_id == $merchant_id) {
            $order = $this->orderService->detailOrderSN($orderSN);
            $this->orderProcessService->completedOrder($trade_no, $order->actual_price, $payment_id);
            return json_encode([
                'jsonrpc' => '2.0', 'id' => $r->{'id'}, 'result' => ['status' => 'Done']
            ]);
        }
        return 'fail';
    }
    public function returnUrl(Request $request)
    {
        return redirect(url('detail-order-sn', ['orderSN' => $request->get('order_id')]));
    }
}


function post_request($url, $data)
{
    $headerArray = array("Content-Type: application/json", "charset='utf-8'", "Accept:application/json");
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYSTATUS, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArray);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

final class Payment
{
    var $url = "https://api.meowpay.org/json_rpc/";
    var $app_id;
    var $trade_no;
    var $amount;
    var $currency_type;
    var $return_url;
    var $notify_url;

    function __construct(
        string $app_id,
        string $trade_no,
        string $currency_type = null,
        int $amount,
        string $return_url = null,
        string $notify_url = null
    ) {
        $this->app_id = $app_id;
        $this->trade_no = $trade_no;
        $this->amount = $amount;
        $this->currency_type = $currency_type;
        $this->return_url = $return_url;
        $this->notify_url = $notify_url;
    }
    function get_pay_link($url = null, $method = "create_payment")
    {
        if ($url === null) {
            $url = $this->url;
        };
        $js_rq_data = [];
        $js_rq_data['jsonrpc'] = '2.0';
        $js_rq_data['id'] = '0';
        $js_rq_data['method'] = $method;
        $js_rq_data['params']['app_id'] = $this->app_id;
        $js_rq_data['params']['trade_no'] = $this->trade_no;
        $js_rq_data['params']['amount'] = $this->amount;
        $js_rq_data['params']['currency_type'] = $this->currency_type;
        $js_rq_data['params']['return_url'] = $this->return_url;
        $js_rq_data['params']['notify_url'] = $this->notify_url;
        $rq = json_encode($js_rq_data, JSON_PARTIAL_OUTPUT_ON_ERROR);
        $response = post_request($url, $rq);
        return $response['result']['payment_info']['pay_link'];
    }
}
