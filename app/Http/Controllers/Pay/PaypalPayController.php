<?php

namespace App\Http\Controllers\Pay;


use App\Exceptions\AppException;
use App\Http\Controllers\PayController;
use App\Models\Pays;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
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
use Illuminate\Support\Facades\Log;

class PaypalPayController extends PayController
{

    public function gateway($payway, $oid)
    {
        $this->checkOrder($payway, $oid);
        // paypal id
        $clientId = $this->payInfo['merchant_id'];
        // paypal 密钥
        $clientSecret = $this->payInfo['merchant_pem'];
        $acceptUrl = site_url(). $this->payInfo['pay_handleroute'] . '/return_url?order_id='.$this->orderInfo['order_id'];
        $currency = 'USD';
        $paypal = new ApiContext(
            new OAuthTokenCredential(
                $clientId,
                $clientSecret
            )
        );
        // 正式环境还是沙箱
        if (!config('app.paypal_sandebox')) {
            $paypal->setConfig(
                ['mode' => 'live']
            );
        }
        $product = $this->orderInfo['product_name'];
        try {
            $price = number_format($this->getUsdCurrency($this->orderInfo['actual_price']), 2, '.', '');
        } catch (\Exception $exception) {
            throw new AppException($exception->getMessage());
        }
        $shipping = 0;
        $total = $price + $shipping;//总价
        $description = $this->orderInfo['product_name'];

        $payer = (new Payer())->setPaymentMethod('paypal');
        $item = (new Item())->setName($product)->setCurrency($currency)->setQuantity(1)->setPrice($price);

        $itemList = (new ItemList())->setItems([$item]);

        $details = (new Details())->setShipping($shipping)->setSubtotal($price);

        $amount = (new Amount())->setCurrency($currency)->setTotal($total)->setDetails($details);

        $transaction = (new Transaction())->setAmount($amount)->setItemList($itemList)->setDescription($description)->setInvoiceNumber($this->orderInfo['order_id']);
        $redirectUrls = (new RedirectUrls())->setReturnUrl($acceptUrl)->setCancelUrl($acceptUrl);

        $payment = (new Payment())->setIntent('sale')->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions([$transaction]);
        try {
            $payment->create($paypal);
        } catch (PayPalConnectionException $e) {
            throw new AppException(__('prompt.abnormal_payment_channel') . $e->getData());
        }
        $approvalUrl = $payment->getApprovalLink();
        return redirect($approvalUrl);
    }

    /**
     *paypal 同步回调
     */
    public function returnUrl(Request $request)
    {
        $oid = $request->get('order_id');
        $paymentId = $request->get('paymentId');
        $payerId = $request->get('PayerID');
        $cacheord = json_decode(Redis::hget('PENDING_ORDERS_LIST', $oid), true);
        if (!$cacheord) {
            return 'error';
        }
        $payInfo = Pays::where('id', $cacheord['pay_way'])->first()->toArray();
        $paypal = new ApiContext(
            new OAuthTokenCredential(
                $payInfo['merchant_id'],
                $payInfo['merchant_pem']
            )
        );
        // 正式环境还是沙箱
        if (!config('app.paypal_sandebox')) {
            $paypal->setConfig(
                ['mode' => 'live']
            );
        }
        $payment = Payment::get($paymentId, $paypal);
        $execute = new PaymentExecution();
        $execute->setPayerId($payerId);
        try{
            $result = $payment->execute($execute, $paypal);
            $payData = $result->toArray();
            if ($payData['payer']['status'] == "VERIFIED" && $payData['transactions'][0]['amount']['currency'] == "USD") {
                $this->orderService->successOrder($oid, $paymentId, $cacheord['actual_price']);
                return redirect(site_url().'searchOrderById?order_id='.$oid);
            }
        } catch(\Exception $e) {
            throw new AppException(__('prompt.abnormal_payment_channel') . $e->getMessage());
        }
    }


    /**
     * 异步通知
     */
    public function notifyUrl(Request $request)
    {
        $data = $request->post();
        if (!isset($data['resource']['transactions'])) return;
        $oid = $data['resource']['transactions'][0]['invoice_number'];
        $paymentId = $data['resource']['id'];
        $payerId =$data['resource']['payer']['payer_info']['payer_id'];
        $cacheord = json_decode(Redis::hget('PENDING_ORDERS_LIST', $oid), true);
        if (!$cacheord) {
            return 'error';
        }
        $payInfo = Pays::where('id', $cacheord['pay_way'])->first()->toArray();
        $paypal = new ApiContext(
            new OAuthTokenCredential(
                $payInfo['merchant_id'],
                $payInfo['merchant_pem']
            )
        );
        // 正式环境还是沙箱
        if (!config('app.paypal_sandebox')) {
            $paypal->setConfig(
                ['mode' => 'live']
            );
        }
        $payment = Payment::get($paymentId, $paypal);
        $execute = new PaymentExecution();
        $execute->setPayerId($payerId);
        try{
            $result = $payment->execute($execute, $paypal);
            $payData = $result->toArray();
            if ($payData['payer']['status'] == "VERIFIED" && $payData['transactions'][0]['amount']['currency'] == "USD") {
                $this->orderService->successOrder($oid, $paymentId, $cacheord['actual_price']);
            }
        } catch(\Exception $e) {
           Log::info('paypal异常：' . $e->getMessage());
        }

    }

    /**
     * 根据RMB获取美元
     * @param $cny
     * @return float|int
     * @throws \Exception
     */
    public function getUsdCurrency($cny)
    {
        $client = new Client();
        $res = $client->get('https://m.cmbchina.com/api/rate/getfxrate');
        $fxrate = json_decode($res->getBody(), true);
        if (!isset($fxrate['data'])) {
            throw new \Exception('汇率接口异常');
        }
        $dfFxrate = 0.13;
        foreach ($fxrate['data'] as $item) {
            if ($item['ZCcyNbr'] == "美元") {
                $dfFxrate = 100 / $item['ZRtcOfr'];
                break;
            }
        }
        return $cny * $dfFxrate;
    }


}
