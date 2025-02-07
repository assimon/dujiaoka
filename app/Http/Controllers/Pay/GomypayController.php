<?php
namespace App\Http\Controllers\Pay;

use App\Http\Controllers\PayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GomypayController extends PayController
{
    private $merchantPem;
    private $merchantKey;

    const PAY_URI = 'https://n.gomypay.asia/TestShuntClass.aspx';

    public function gateway(string $payway, string $orderSN)
    {
        try {
            $this->loadGateWay($orderSN, $payway);

            if (!$this->payGateway) {
                Log::error('Gomypay gateway error: payGateway not loaded');
                return 'error';
            }

            // Initialize merchantPem and merchantKey after loading the gateway
            $this->merchantPem = $this->payGateway->merchant_pem;
            $this->merchantKey = $this->payGateway->merchant_key;

            $price = (float)$this->order->actual_price;
            $orderNo = $this->order->order_sn;
            $customerId = $this->merchantKey;
            $returnUrl = route('gomypay-return', ['order_id' => $this->order->order_sn]);
            $callbackUrl = route('gomypay-notify', ['order_id' => $this->order->order_sn]);
            $strCheck = md5($orderNo . $customerId . $price . $this->merchantPem);
            $name = $this->order->name;
            $phone = $this->order->phone;
            $email = $this->order->email;
            $html = "
                <html><head>
                    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
                    <title>Redirecting to Gomypay...</title>
                </head>
                <body>
                <form id=\"gomypayForm\" action=\"".self::PAY_URI."\" method=\"post\">
                    <input type=\"hidden\" name=\"Send_Type\" value=\"4\">
                    <input type=\"hidden\" name=\"Pay_Mode_No\" value=\"2\">
                    <input type=\"hidden\" name=\"CustomerId\" value=\"".$customerId."\">
                    <input type=\"hidden\" name=\"Order_No\" value=\"".$orderNo."\">
                    <input type=\"hidden\" name=\"Amount\" value=\"".$price."\">
                    <input type=\"hidden\" name=\"Buyer_Name\" value=\"".$name."\">
                    <input type=\"hidden\" name=\"Buyer_Telm\" value=\"".$phone."\">
                    <input type=\"hidden\" name=\"Buyer_Mail\" value=\"".$email."\">
                    <input type=\"hidden\" name=\"Buyer_Memo\" value=\"無\">
                    <input type=\"hidden\" name=\"Callback_Url\" value=\"".$callbackUrl."\">
                </form>
                <script>document.getElementById('gomypayForm').submit();</script>
                </body></html>
            ";

            return $html;
        } catch (\Exception $e) {
            Log::error('Gomypay gateway error: ' . $e->getMessage());
            return 'error';
        }
    }

    public function notifyUrl(Request $request)
    {
        $data = $request->post();
        $order = $this->orderService->detailOrderSN($data['orderid']);
        if (!$order) {
            return 'error';
        }
        $payGateway = $this->payService->detail($order->pay_id);
        if (!$payGateway) {
            return 'error';
        }
        if($payGateway->pay_handleroute != '/pay/gomypay'){
            return 'error';
        }
        $temps = md5($data['orderid'] . $data['orderuid'] . $data['paysapi_id'] . $data['price'] . $data['realprice'] . $payGateway->merchant_pem);
        if ($temps != $data['key']){
            return 'fail';
        }else{
            $this->orderProcessService->completedOrder($data['orderid'], $data['price'], $data['paysapi_id']);
            return 'success';
        }
    }

    public function returnUrl(Request $request)
    {
        $orderSN   = trim($request->input('e_orderno'));
        sleep(2);
        return redirect(url('detail-order-sn', ['orderSN' => $orderSN]))->with('success', '交易成功');
    }
}
