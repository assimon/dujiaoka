<?php

namespace App\Http\Controllers\Pay;

use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Exception\UnexpectedValueException;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeCheckoutController extends PayController
{   
    public function gateway(string $payway, string $orderSN)
    {
        try{
            $this->loadGateWay($orderSN, $payway);
            \Stripe\Stripe::setApiKey($this->payGateway->merchant_id);
            $price = Currency::convert()
                ->from('CNY')
                ->to('HKD')
                ->amount($this->order->actual_price)
                ->round(2)
                ->get();
            $TotalAmount = $price * 100;
            $data = [
                'success_url'         => url('detail-order-sn', ['orderSN' => $this->order->order_sn]),
                'cancel_url'          => url('/'),
                'client_reference_id' => $this->order->order_sn,
                'line_items' => [[
                    'price_data' => [
                        'currency'     => 'HKD',
                        'product_data' => [
                            'name' => $this->order->order_sn
                        ],
                        'unit_amount'  => $TotalAmount 
                    ],
                    'quantity'   => 1
                ]],
                'mode'                => 'payment',
                'customer_email'      => $this->order->email
            ]; 
            $session = Session::create($data);
                return redirect()->away($session->url);//可以使用自定义域名
        }catch (\Exception $e) {
            return $this->err(__('dujiaoka.prompt.abnormal_payment_channel') . $e->getMessage());
        }
    }
    //webhook地址:https://shop.liner77.xyz/pay/stripecheckout/webhook  自行替换域名 
    //侦听的事件: 'checkout.session.completed' 'checkout.session.async_payment_succeeded'
    public function webhook(Request $request)
    {   
        $payload = file_get_contents('php://input');
        $data = json_decode($payload, true);
        if(!$this->orderService->detailOrderSN($data['data']['object']['client_reference_id'])){
            return 'order error';
        }
        $order = $this->orderService->detailOrderSN($data['data']['object']['client_reference_id']);
        if(!$this->payService->detail($order->pay_id)){
            return 'order error';
        }
        $payGateway = $this->payService->detail($order->pay_id);
        $endpoint_secret = $payGateway->merchant_pem;
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        try{
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        }catch(UnexpectedValueException $e) {
            http_response_code(400);
            exit();
        }catch(SignatureVerificationException $e) {
            http_response_code(400);
            exit();
        }
        switch($event->type){
            case 'checkout.session.completed':
                $session = $event->data->object;
                if ($session->payment_status == 'paid') {
                    $this->orderProcessService->completedOrder($session->client_reference_id,$order->actual_price,$session->payment_intent);
                }
                break;
            case 'checkout.session.async_payment_succeeded':
                $session = $event->data->object;
                    $this->orderProcessService->completedOrder($session->client_reference_id,$order->actual_price,$session->payment_intent);
                break;
        }
        http_response_code(200);
        exit();
    }
}