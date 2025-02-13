<?php

namespace App\Http\Controllers\Pay;

use App\Http\Controllers\PayController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Service\OrderProcessService;

// 引入 P99Pay 相關文件
require_once(base_path('p99pay/Common.php'));

class P99payController extends PayController
{
    private $merchantKey;  // 交易密鑰1 (TripleDES-KEY)
    private $merchantPem;  // 交易密鑰2 (TripleDES-IV)
    private $merchantId;   // 商家服務代碼 (CID)
    private $password;     // 交易密碼
    private $dev = false;   // 開發模式

    public function __construct(OrderProcessService $orderProcessService)
    {
        parent::__construct($orderProcessService);
    }

    /**
     * 支付入口
     */
    public function gateway(string $payway, string $orderSN)
    {
        try {
            $this->loadGateWay($orderSN, $payway);

            if (!$this->payGateway || !$this->order) {
                return redirect()->back()->with('error', '支付初始化失敗');
            }

            // 根據開發模式設定相應的參數
            if ($this->dev) {
                $this->merchantKey = 'U1BHcHl4MlRVMVQ4d056Q2c1bElnaXBj';
                $this->merchantPem = 'UmRRVHZ3S0Q=';
                $this->merchantId = 'C001430000143';
                $this->password = 'k2sWbsonDe';
                $apiUrl = 'https://api-stage.p99pay.com/v1';
            } else {
                $this->merchantKey = $this->payGateway['merchant_key'];
                $this->merchantPem = $this->payGateway['merchant_pem'];
                $this->merchantId = $this->payGateway['merchant_id'];
                $this->password = $this->payGateway['merchant_password'];
                $apiUrl = 'https://api.p99pay.com/v1';
            }

            // 創建 Trans 對象
            $trans = new \Trans(null);
            
            // 設置交易參數
            $trans->nodes["MSG_TYPE"] = "0100";           // 交易訊息代碼
            $trans->nodes["PCODE"] = "300000";            // 一般交易請使用 300000
            $trans->nodes["CID"] = $this->merchantId;     // 商家服務代碼
            $trans->nodes["COID"] = $orderSN;             // 商家訂單編號
            $trans->nodes["CUID"] = "USD";                // 幣別
            $trans->nodes["PAID"] = "COPKWP01";           // 付款代收業者代碼
            $trans->nodes["AMOUNT"] = $this->order->actual_price; // 交易金額
            $trans->nodes["RETURN_URL"] = route('p99pay.returnUrl', ['orderSN' => $orderSN]); // 商家接收交易結果網址
            $trans->nodes["ORDER_TYPE"] = "M";            // 指定付款代收業者
            $trans->nodes["PRODUCT_NAME"] = $this->order->title; // 商品名稱
            $trans->nodes["PRODUCT_ID"] = $this->order->goods_id; // 商品ID
            $trans->nodes["USER_ACCTID"] = $this->order->email; // 玩家帳號(這裡用email)
            $trans->nodes["MEMO"] = "";                   // 交易備註

            // 取得 ERQC
            $erqc = $trans->GetERQC($this->password,$this->merchantKey, $this->merchantPem);
            $trans->nodes["ERQC"] = $erqc;

            // 取得送出之交易資料
            $data = $trans->GetSendData();

            Log::info('P99Pay payment request:', [
                'orderSN' => $orderSN,
                'amount' => $trans->nodes["AMOUNT"],
                'dev_mode' => $this->dev,
                'data' => $trans->nodes
            ]);

            // 產生表單
            $html = '<!DOCTYPE html>
            <html>
            <head>
                <title>P99Pay Transaction</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            </head>
            <body>
                <form id="p99pay-form" action="' . $apiUrl . '" method="post">
                    <input type="hidden" name="data" value="' . $data . '">
                </form>
                <script>document.getElementById("p99pay-form").submit();</script>
            </body>
            </html>';

            return response($html);

        } catch (\Exception $e) {
            Log::error('P99Pay gateway error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', '支付發起失敗');
        }
    }

    /**
     * 接收支付結果通知
     */
    public function notifyUrl(Request $request)
    {
        
    }

    /**
     * 支付完成返回商戶
     */
    public function returnUrl(Request $request, $orderSN = null)
    {
        try {
            Log::info('P99Pay return URL accessed', [
                'orderSN' => $orderSN,
                'method' => $request->method(),
                'all_params' => $request->all()
            ]);

            if (!$request->has('data')) {
                throw new \Exception('Missing data parameter');
            }

            $rawData = $request->input('data');
            $data = json_decode(base64_decode($rawData), true);
            
            Log::info('P99Pay return data decoded:', $data);

            // 使用 P99Pay 返回的訂單號
            $orderSN = $data['COID'];

            // 載入訂單和支付網關
            $this->loadGateWay($orderSN, 'P99');
            if (!$this->payGateway || !$this->order) {
                throw new \Exception('Failed to load order gateway');
            }

            // 設置支付參數
            if ($this->dev) {
                $this->merchantKey = 'U1BHcHl4MlRVMVQ4d056Q2c1bElnaXBj';
                $this->merchantPem = 'UmRRVHZ3S0Q=';
                $this->merchantId = 'C001430000143';
                $this->password = 'k2sWbsonDe';
            } else {
                $this->merchantKey = $this->payGateway['merchant_key'];
                $this->merchantPem = $this->payGateway['merchant_pem'];
                $this->merchantId = $this->payGateway['merchant_id'];
                $this->password = $this->payGateway['merchant_password'];
            }

            // 驗證 ERPC
            if (!$this->verifyERPC($data)) {
                throw new \Exception('Invalid ERPC');
            }

            // 檢查交易狀態
            if ($data['PAY_STATUS'] === 'S' && $data['RCODE'] === '0000') {
                // 處理訂單完成
                $this->orderProcessService->completedOrder(
                    $orderSN,           // 訂單號
                    (float)$data['AMOUNT'], // 支付金額
                    $data['RRN']        // 交易號
                );

                Log::info('P99Pay payment successful', [
                    'orderSN' => $orderSN,
                    'amount' => $data['AMOUNT'],
                    'trade_no' => $data['RRN']
                ]);

                return redirect(url('detail-order-sn', ['orderSN' => $orderSN]))
                    ->with('success', '支付成功');
            }

            // 處理失敗狀態
            $errorMsg = $data['RMSG_CHI'] ?? '支付失敗';
            Log::warning('P99Pay payment failed', [
                'orderSN' => $orderSN,
                'status' => $data['PAY_STATUS'],
                'rcode' => $data['RCODE'],
                'message' => $errorMsg
            ]);

            return redirect(url('detail-order-sn', ['orderSN' => $orderSN]))
                ->with('error', $errorMsg);

        } catch (\Exception $e) {
            Log::error('P99Pay return processing error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect('/')->with('error', '處理支付返回失敗');
        }
    }

    /**
     * 驗證 P99 交易驗證資料壓碼 ERPC
     */
    private function verifyERPC($data)
    {
        // 設置支付參數
        if ($this->dev) {
            $this->merchantKey = 'U1BHcHl4MlRVMVQ4d056Q2c1bElnaXBj';
            $this->merchantPem = 'UmRRVHZ3S0Q=';
            $this->merchantId = 'C001430000143';
            $this->password = 'k2sWbsonDe';
        } else {
            // 確保已經載入了支付網關
            if (!$this->payGateway) {
                throw new \Exception('Payment gateway not loaded');
            }
            $this->merchantKey = $this->payGateway['merchant_key'];
            $this->merchantPem = $this->payGateway['merchant_pem'];
            $this->merchantId = $this->payGateway['merchant_id'];
            $this->password = $this->payGateway['merchant_password'];
        }

        // 將接收到的數據轉換為 base64 編碼的 JSON 字符串
        $jsonData = base64_encode(json_encode($data));
        
        // 創建 Trans 對象
        $trans = new \Trans($jsonData);
        
        // 使用 Trans 類的 GetERPC 方法進行驗證
        $erpc = $trans->GetERPC($this->merchantKey, $this->merchantPem);
        
        Log::info('P99Pay ERPC verify:', [
            'erpc' => $erpc,
            'received_erpc' => $data['ERPC'],
            'dev_mode' => $this->dev,
            'merchant_id' => $this->merchantId
        ]);
        
        return $erpc === $data['ERPC'];
    }
}
