<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pay;

use App\Http\Controllers\PayController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

final class MeowpayController extends PayController
{
    public function gateway(string $payway, string $orderSN)
    {
        try {
            $this->loadGateWay($orderSN, $payway);
            $app_id = $this->payGateway->merchant_id;
            $currency_type = 'CNY';
            $amount = bcmul($this->order->actual_price, '100', 0);
            $return_url = null;
            $notify_url = null;
            // 需要自定义通知|返回地址请删除下两行
            // 自定义通知地址请在 Meowpay APP 信息 https://meowpay.org/app/list 中设置
            $notify_url = url(
                $this->payGateway->pay_handleroute . '/notify_url'
            );
            $return_url = route(
                'meowpay-return',
                ['order_id' => $this->order->order_sn]
            );
            $js_rq_data = [
                'jsonrpc' => '2.0',
                'id' => '0',
                'method' => 'create_payment',
                'params' => [
                    'app_id' => $app_id,
                    'trade_no' => $this->order->order_sn,
                    'amount' => (int) $amount,
                    'currency_type' => $currency_type,
                    'notify_url' => $notify_url,
                    'return_url' => $return_url,
                ],
            ];
            $client = new Client();
            $res = $client->request(
                'POST',
                'https://api.meowpay.org/json_rpc/',
                ['json' => $js_rq_data],
            );
            $res_data = json_decode($res->getBody()->getContents(), true);
            return redirect()->away(
                $res_data['result']['payment_info']['pay_link']
            );
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

        if ($payGateway->pay_handleroute !== '/pay/meowpay') {
            return 'error';
        }

        $payment_id = $params->{'payment_id'};
        $merchant_id = $this->payService->detail(
            $order->pay_id
        )->merchant_id;

        if ($app_id !== $merchant_id) {
            return 'fail';
        }

        $order = $this->orderService->detailOrderSN($orderSN);
        $this->orderProcessService->completedOrder(
            $trade_no,
            (float) $order->actual_price,
            $payment_id,
        );
        return json_encode([
            'jsonrpc' => '2.0',
            'id' => $r->{'id'},
            'result' => ['status' => 'Done'],
        ]);
    }

    public function returnUrl(Request $request)
    {
        return redirect(url(
            'detail-order-sn',
            ['orderSN' => $request->get('order_id')]
        ));
    }
}
