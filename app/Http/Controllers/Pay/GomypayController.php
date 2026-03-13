<?php
namespace App\Http\Controllers\Pay;

use App\Http\Controllers\PayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PayGateway;

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

            $price = explode('.', $this->order->actual_price)[0];  // 只取整數部分
            $orderNo = $this->order->order_sn;
            $customerId = $this->merchantKey;
            $returnUrl = route('gomypay-return', ['order_id' => $this->order->order_sn]);
            $callbackUrl = route('gomypay-notify', ['order_id' => $this->order->order_sn]);
            
            // 修正 strCheck 計算方式，使用 + 號連接
            $stringToHash = implode('+', [
                $orderNo,
                $customerId,
                $price,
                $this->merchantPem
            ]);
            $strCheck = md5($stringToHash);

            $name = $this->order->name;
            $phone = $this->order->phone;
            $email = $this->order->email;

            // 記錄所有表單變數和 strCheck 計算過程
            Log::info('Gomypay gateway form data:', [
                'Send_Type' => '4',
                'Pay_Mode_No' => '2',
                'CustomerId' => $customerId,
                'Order_No' => $orderNo,
                'Amount' => $price,
                'Buyer_Name' => $name,
                'Buyer_Telm' => $phone,
                'Buyer_Mail' => $email,
                'Buyer_Memo' => '無',
                'Callback_Url' => $callbackUrl,
                'strCheck' => $strCheck,
                'strCheck_calculation' => [
                    'string_to_hash' => $stringToHash,
                    'components' => [
                        'orderNo' => $orderNo,
                        'customerId' => $customerId,
                        'price' => $price,
                        'merchantPem' => $this->merchantPem
                    ]
                ],
                'returnUrl' => $returnUrl
            ]);

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
                    <input type=\"hidden\" name=\"str_check\" value=\"".$strCheck."\">
                </form>
                <script>
                document.getElementById('gomypayForm').submit();
                </script>
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
        try {
            // 接收所有必要的欄位並確保去除空白
            $data = [
                'Send_Type' => trim($request->input('Send_Type', '')),    // 長度1，固定為4
                'result' => trim($request->input('result', '')),          // 長度1，0失敗1成功
                'ret_msg' => trim($request->input('ret_msg', '')),        // 最大長度100
                'OrderID' => trim($request->input('OrderID', '')),        // 長度19
                'e_money' => trim($request->input('e_money', '')),        // 最大長度10
                'PayAmount' => trim($request->input('PayAmount', '')),    // 最大長度10
                'e_date' => trim($request->input('e_date', '')),          // 長度8 (yyyyMMdd)
                'e_time' => trim($request->input('e_time', '')),          // 長度8 (HH:mm:ss)
                'e_orderno' => trim($request->input('e_orderno', '')),    // 最大長度25
                'e_payaccount' => trim($request->input('e_payaccount', '')), // 長度16
                'e_PayInfo' => trim($request->input('e_PayInfo', '')),    // 長度9
                'str_check' => trim($request->input('str_check', ''))     // 長度32
            ];

            // 記錄所有接收到的數據
            Log::info('Gomypay notify received:', $data);

            // 檢查所有必要的欄位是否存在
            foreach ($data as $key => $value) {
                if (empty($value)) {
                    Log::error('Gomypay notify: Missing or empty parameter', ['parameter' => $key]);
                    return 'error';
                }
            }

            // 驗證 Send_Type 是否正確
            if ($data['Send_Type'] !== '4') {
                Log::error('Gomypay notify: Invalid Send_Type', ['Send_Type' => $data['Send_Type']]);
                return 'error';
            }

            // 驗證交易結果
            if ($data['result'] !== '1') {
                Log::error('Gomypay notify: Transaction failed', ['result' => $data['result']]);
                return 'error';
            }

            // 處理訂單
            $order = $this->orderService->detailOrderSN($data['e_orderno']);
            if (!$order) {
                Log::error('Gomypay notify: Order not found', ['e_orderno' => $data['e_orderno']]);
                return 'error';
            }

            // 更新訂單狀態
            try {
                $this->orderProcessService->completedOrder(
                    $data['e_orderno'], 
                    $data['PayAmount'], 
                    $data['OrderID']
                );
                Log::info('Gomypay notify: Order processed successfully', ['e_orderno' => $data['e_orderno']]);
                return 'success';
            } catch (\Exception $e) {
                Log::error('Gomypay notify: Order processing failed', [
                    'error' => $e->getMessage(),
                    'e_orderno' => $data['e_orderno']
                ]);
                return 'error';
            }

        } catch (\Exception $e) {
            Log::error('Gomypay notify error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 'error';
        }
    }

    public function returnUrl(Request $request)
    {
        $orderSN   = trim($request->input('e_orderno'));
        sleep(2);
        return redirect(url('detail-order-sn', ['orderSN' => $orderSN]))->with('success', '交易成功');
    }
}
