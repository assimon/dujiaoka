<?php

namespace App\Http\Controllers\Pay;


use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

class PaypalPayController extends PayController
{

    const Currency = 'USD'; //货币单位

    public function gateway(string $payway, string $orderSN)
    {
        try {
            // 加载网关
            $this->loadGateWay($orderSN, $payway);
            
            // 检查并清理凭证
            $clientId = trim($this->payGateway->merchant_key);
            $clientSecret = trim($this->payGateway->merchant_pem);

            // 验证凭证
            if (empty($clientId) || empty($clientSecret)) {
                throw new \Exception('PayPal credentials are not properly configured');
            }

            // 初始化 PayPal API Context
            $paypal = new ApiContext(
                new OAuthTokenCredential($clientId, $clientSecret)
            );
            
            $paypal->setConfig([
                'mode' => 'live',
                'log.LogEnabled' => true,
                'log.FileName' => storage_path('logs/paypal.log'),
                'log.LogLevel' => 'DEBUG'
            ]);

            // 直接使用原始金额
            $total = number_format($this->order->actual_price, 2, '.', '');

            Log::info('PayPal payment amount', [
                'amount' => $total,
                'currency' => self::Currency
            ]);

            // 建立支付信息
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            // 设置金额
            $amount = new Amount();
            $amount->setCurrency(self::Currency)
                  ->setTotal(strval($total));

            // 设置交易
            $transaction = new Transaction();
            $transaction->setAmount($amount)
                       ->setDescription($this->order->title)
                       ->setInvoiceNumber($this->order->order_sn);

            // 设置重定向 URL
            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl(route('paypal-return', ['success' => 'ok', 'orderSN' => $this->order->order_sn]))
                        ->setCancelUrl(route('paypal-return', ['success' => 'no', 'orderSN' => $this->order->order_sn]));

            // 创建支付
            $payment = new Payment();
            $payment->setIntent('sale')
                   ->setPayer($payer)
                   ->setRedirectUrls($redirectUrls)
                   ->setTransactions([$transaction]);

            try {
                $result = $payment->create($paypal);
                Log::info('PayPal payment created', [
                    'payment_id' => $result->getId(),
                    'amount' => $total,
                    'currency' => self::Currency
                ]);
                return redirect($result->getApprovalLink());
            } catch (PayPalConnectionException $ex) {
                Log::error('PayPal API Error', [
                    'error_data' => json_decode($ex->getData(), true),
                    'error_message' => $ex->getMessage()
                ]);
                throw $ex;
            }

        } catch (\Exception $e) {
            Log::error('PayPal Payment Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->err($e->getMessage());
        }
    }

    /**
     * PayPal 回調處理
     */
    public function returnUrl(Request $request)
    {
        $success = $request->input('success');
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');
        $orderSN = $request->input('orderSN');

        Log::info('PayPal return callback received', [
            'success' => $success,
            'paymentId' => $paymentId,
            'payerId' => $payerId,
            'orderSN' => $orderSN,
            'all_params' => $request->all()
        ]);

        // 如果是取消支付或參數不完整，直接跳轉回訂單頁面
        if ($success == 'no' || empty($paymentId) || empty($payerId)) {
            return redirect(url('detail-order-sn', ['orderSN' => $orderSN]));
        }

        $order = $this->orderService->detailOrderSN($orderSN);
        if (!$order) {
            return 'error';
        }
        $payGateway = $this->payService->detail($order->pay_id);
        if (!$payGateway) {
            return 'error';
        }
        if($payGateway->pay_handleroute != '/pay/paypal'){
            return 'error';
        }
        $paypal = new ApiContext(
            new OAuthTokenCredential(
                $payGateway->merchant_key,
                $payGateway->merchant_pem
            )
        );
        $paypal->setConfig(['mode' => 'live']);
        $payment = Payment::get($paymentId, $paypal);
        $execute = new PaymentExecution();
        $execute->setPayerId($payerId);
        try {
            $payment->execute($execute, $paypal);
            $this->orderProcessService->completedOrder($orderSN, $order->actual_price, $paymentId);
            Log::info("paypal支付成功", ['支付成功，支付ID【' . $paymentId . '】,支付人ID【' . $payerId . '】']);
        } catch (\Exception $e) {
            Log::error("paypal支付失败", ['支付失败，支付ID【' . $paymentId . '】,支付人ID【' . $payerId . '】']);
        }
        return redirect(url('detail-order-sn', ['orderSN' => $orderSN]));
    }


    /**
     * 异步通知
     * TODO: 暂未实现，但是好像只实现同步回调即可。这个可以放在后面实现
     */
    public function notifyUrl(Request $request)
    {
        //获取回调结果
        $json_data = $this->get_JsonData();
        if(!empty($json_data)){
            Log::debug("paypal notify info:\r\n" . json_encode($json_data));
        }else{
            Log::debug("paypal notify fail:参加为空");
        }

    }

    private function get_JsonData()
    {
        $json = file_get_contents('php://input');
        if ($json) {
            $json = str_replace("'", '', $json);
            $json = json_decode($json,true);
        }
        return $json;
    }

}
