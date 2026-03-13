<?php

namespace App\Http\Controllers\Pay;

use App\Http\Controllers\PayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Service\OrderProcessService;

class RmpayController extends PayController
{
    protected $orderProcessService;
    protected $order;
    protected $payInfo;
    protected $merchantId;
    protected $merchantKey;
    protected $apiUrl;
    protected $dev = true;

    // 在這裡定義您希望硬編碼的值
    const HARDCODED_MERCHANT_ID = 'Maple';
    const HARDCODED_MERCHANT_KEY = 'x900w3IrTM3CX18w';

    public function __construct(OrderProcessService $orderProcessService)
    {
        parent::__construct($orderProcessService);
        $this->orderProcessService = $orderProcessService;
    }

    public function loadGateWay($orderSN, $payway)
    {
        parent::loadGateWay($orderSN, $payway);

        // **使用硬編碼的商戶ID和密鑰**
        $this->merchantId = self::HARDCODED_MERCHANT_ID;
        $this->merchantKey = self::HARDCODED_MERCHANT_KEY;

        Log::info('RMPay 使用硬編碼的商戶配置', [
            'merchant_id' => $this->merchantId,
            'merchant_key' => '***' . substr($this->merchantKey, -4) // 日誌中部分隱藏密鑰
        ]);

        // 根據環境設置API地址
        $this->apiUrl = $this->dev
            ? 'https://b.rmpay.supply/pay' // 測試環境API地址
            : 'https://b.rmpay.supply/pay'; // 正式環境API地址

        Log::info('RMPay 支付網關加載成功 (使用硬編碼配置)', [
            'orderSN' => $orderSN,
            'payway' => $payway,
            'merchantId' => $this->merchantId,
            'apiUrl' => $this->apiUrl,
            'dev_mode' => $this->dev
        ]);
    }

    public function gateway($payway, $orderSN)
    {
        try {
            $this->loadGateWay($orderSN, $payway);
            
            if (!$this->order) {
                Log::error('RMPay 訂單加載失敗', ['orderSN' => $orderSN]);
                throw new \Exception('訂單加載失敗，無法繼續支付');
            }

            $requestData = [
                'uid'        => $this->merchantId,
                'orderid'    => $orderSN,
                'channel'    => $this->getChannelByPayway($payway),
                'notify_url' => url('/pay/rmpay/notify_url'),
                'return_url' => url('/pay/rmpay/return_url'),
                'amount'     => number_format($this->order->actual_price, 2, '.', ''),
                'userip'     => request()->ip(),
                'timestamp'  => time(),
                'custom'     => $orderSN,
            ];

            $requestData['sign'] = $this->generateSign($requestData);

            Log::info('RMPay 支付請求發起', ['url' => $this->apiUrl, 'data' => $requestData]);

            $response = $this->sendRequest($this->apiUrl, $requestData);

            Log::info('RMPay 支付請求響應', ['response' => $response]);

            if (isset($response['status']) && $response['status'] == 10000 && isset($response['result']['payurl'])) {
                return redirect()->away($response['result']['payurl']);
            } else {
                $errorMessage = $response['msg'] ?? '未知錯誤';
                Log::error('RMPay 支付請求失敗', ['orderSN' => $orderSN, 'response' => $response]);
                throw new \Exception("支付請求失敗: " . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('RMPay Gateway 處理異常', [
                'orderSN' => $orderSN,
                'message' => $e->getMessage(),
            ]);
            return $this->err('支付發起失敗：' . $e->getMessage());
        }
    }

    public function notifyUrl(Request $request)
    {
        $notificationData = $request->all();
        Log::info('RMPay 接收到異步回調通知 (原始數據)', $notificationData);

        try {
            // 1. 基本驗證：檢查簽名、狀態和 result 字段是否存在於頂層
            if (!isset($notificationData['status']) || empty($notificationData['sign']) || !isset($notificationData['result'])) {
                throw new \Exception('回調參數不完整 (缺少顶层 status, sign, 或 result)');
            }
            
            // 2. 驗證簽名
            $receivedSign = $notificationData['sign'];
            $dataToVerify = $notificationData; // 複製一份用於驗簽，避免修改原始數據影響日誌
            unset($dataToVerify['sign']); // 簽名本身不參與簽名計算

            // 確保使用正確的商戶密鑰 (與支付請求時一致，這裡使用硬編碼的值)
            $this->merchantKey = self::HARDCODED_MERCHANT_KEY;

            if ($this->generateSign($dataToVerify) !== $receivedSign) {
                // 注意：generateSign 應能處理 $dataToVerify 中 result 字段是字符串的情況
                Log::error('RMPay 簽名驗證失敗', [
                    'received_sign' => $receivedSign,
                    'calculated_sign_data' => $dataToVerify,
                    'key_used_for_calc' => '***' . substr($this->merchantKey, -4)
                ]);
                throw new \Exception('簽名驗證失敗');
            }

            Log::info('RMPay 簽名驗證成功');

            // 3. 解析 result 字段中的 JSON 字符串
            if (!is_string($notificationData['result'])) {
                throw new \Exception('回調 result 字段類型非字符串');
            }
            $resultData = json_decode($notificationData['result'], true);
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($resultData)) {
                Log::error('RMPay 回調 result 字段JSON解析失敗', ['result_string' => $notificationData['result'], 'error' => json_last_error_msg()]);
                throw new \Exception('回調 result 字段JSON解析失敗: ' . json_last_error_msg());
            }

            Log::info('RMPay 解析後的 result 數據', $resultData);

            // 4. 從解析後的 $resultData 中提取業務所需參數
            $orderSN = $resultData['orderid'] ?? null;
            $transactionId = $resultData['transactionid'] ?? null;
            $paidAmount = isset($resultData['amount']) ? (float)$resultData['amount'] : null;
            // $realAmount = isset($resultData['real_amount']) ? (float)$resultData['real_amount'] : null; // 如果需要用到實際到賬金額

            // 檢查從 result 中解析出的關鍵業務數據是否完整
            if (empty($orderSN) || $paidAmount === null) {
                throw new \Exception('解析後的 result 數據不完整 (缺少 orderid 或 amount)');
            }

            // 5. 根據頂層 status 處理業務邏輯
            if ($notificationData['status'] == 10000) { // 支付成功狀態
                // 調用訂單處理服務完成訂單
                // 注意：completedOrder 方法內部應有防止重複處理的機制
                $this->orderProcessService->completedOrder(
                    $orderSN,
                    $paidAmount,
                    $transactionId ?? ('RMPAY_' . $orderSN) // 如果沒有 transactionid，可以生成一個
                );

                Log::info('RMPay 訂單支付成功並處理完成', [
                    'orderSN' => $orderSN,
                    'paid_amount' => $paidAmount,
                    'trade_no' => $transactionId
                ]);
            } else {
                // 處理其他狀態 (例如支付失敗或處理中)
                Log::warning('RMPay 回調通知狀態非成功', [
                    'orderSN' => $orderSN,
                    'top_level_status' => $notificationData['status'],
                    'result_data' => $resultData
                ]);
                // 根據業務需求決定是否需要更新訂單狀態或做其他處理
            }

            // 向上游支付平台返回 'success'，表示通知已成功處理
            return 'success';

        } catch (\Exception $e) {
            Log::error('RMPay NotifyUrl 處理異常', [
                'message' => $e->getMessage(),
                'raw_notification_data' => $notificationData, // 記錄原始通知數據以便排查
                // 'trace' => $e->getTraceAsString() // 生產環境中可以考慮記錄完整堆棧信息
            ]);
            // 返回 'fail'，支付平台可能會根據其策略重試通知
            return 'fail';
        }
    }

    public function returnUrl(Request $request)
    {
        // 嘗試從 'orderid' 參數獲取，如果沒有，則嘗試從 'custom' 參數獲取
        $orderSN = trim($request->input('orderid', $request->input('custom', '')));
        Log::info('RMPay 同步跳轉', ['orderSN' => $orderSN, 'params' => $request->all()]);

        sleep(2); // 建議保留，等待異步通知可能先到達並處理

        if (!empty($orderSN)) {
            return redirect(url('detail-order-sn', ['orderSN' => $orderSN]));
        } else {
            Log::warning('RMPay returnUrl 未獲取到訂單號');
            // 如果還是獲取不到，可以跳轉到一個通用的支付結果頁或首頁
            return redirect('/')->with('warning', '未能識別您的訂單信息，請查詢您的訂單狀態。');
        }
    }

    private function generateSign($data)
    {
        unset($data['sign']);

        ksort($data);

        $stringToSign = "";
        foreach ($data as $key => $value) {
            $stringValue = strval($value);
            $stringToSign .= "{$key}={$stringValue}&";
        }

        // **確保這裡使用的是正確的 merchantKey (硬編碼的或從配置讀取的)**
        $stringToSign .= "key=" . $this->merchantKey;

        Log::debug('RMPay 待簽名字符串', ['string' => $stringToSign, 'key_used' => '***' . substr($this->merchantKey, -4)]);

        $signature = strtoupper(md5($stringToSign));
        Log::debug('RMPay 生成簽名', ['signature' => $signature]);

        return $signature;
    }

    private function getChannelByPayway($payway)
    {
        $channels = [
            'rmpay_bank_transfer' => '908',
            'rmpay_qrcode'        => '909',
        ];

        $channel = $channels[$payway] ?? '909';
        Log::info('RMPay 獲取支付渠道', ['payway' => $payway, 'channel' => $channel]);
        return $channel;
    }

    private function sendRequest($url, $data, $timeout = 10)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($curlError) {
            Log::error('RMPay CURL請求錯誤', ['url' => $url, 'error' => $curlError]);
            throw new \Exception('支付接口請求失敗: ' . $curlError);
        }

        if ($httpCode != 200) {
            Log::error('RMPay 接口HTTP狀態碼非200', ['url' => $url, 'http_code' => $httpCode, 'response' => $response]);
            throw new \Exception('支付接口通訊異常，HTTP狀態碼: ' . $httpCode);
        }

        $decodedResponse = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('RMPay 接口返回JSON解碼失敗', ['url' => $url, 'response' => $response]);
            throw new \Exception('支付接口返回數據格式錯誤');
        }

        return $decodedResponse;
    }
}
