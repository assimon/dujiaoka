<?php

namespace App\Http\Controllers\Pay;


use App\Models\Pays;
use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
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
        $check = $this->checkOrder($payway, $oid);
        if($check !== true) {
            return $this->error($check);
        }
        // paypal id
        $clientId = $this->payInfo['merchant_id'];
        // paypal 密钥
        $clientSecret = $this->payInfo['merchant_pem'];
        $acceptUrl = site_url().'searchOrderById?order_id='.$this->orderInfo['order_id'];
        $currency = 'USD';
        $paypal = new ApiContext(
            new OAuthTokenCredential(
                $clientId,
                $clientSecret
            )
        );
        $product = $this->orderInfo['product_name'];
        $price = (float)$this->orderInfo['actual_price'];
        $shipping = 0;
        $total = $price + $shipping;//总价
        $description = $this->orderInfo['product_name'];

        $payer = (new Payer())->setPaymentMethod('paypal');
        $item = (new Item())->setName($product)->setCurrency($currency)->setQuantity($this->orderInfo['buy_amount'])->setPrice($price);

        $itemList = (new ItemList())->setItems([$item]);

        $details = (new Details())->setShipping($shipping)->setSubtotal($price);

        $amount = (new Amount())->setCurrency($currency)->setTotal($total)->setDetails($details);

        $transaction = (new Transaction())->setAmount($amount)->setItemList($itemList)->setDescription($description)->setInvoiceNumber($this->orderInfo['order_id']);
        $redirectUrls = (new RedirectUrls())->setReturnUrl($acceptUrl)->setCancelUrl($acceptUrl);

        $payment = (new Payment())->setIntent('sale')->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions([$transaction]);
        try {
            $payment->create($paypal);
        } catch (PayPalConnectionException $e) {
            return $this->error('支付通道异常~ '.$e->getData());
        }
        $approvalUrl = $payment->getApprovalLink();
        return redirect($approvalUrl);
    }


    /**
     * 异步通知
     */
    public function notifyUrl(Request $request)
    {
        $data = $request->post();
        $content = file_get_contents("php://input");
        Log::info(json_encode($data));
        Log::info(json_encode($content));

    }



}
