<?php

namespace App\Http\Controllers\Pay;

use App\Http\Controllers\PayController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Service\OrderProcessService;
use Illuminate\Support\Facades\DB;


class EcpayController extends PayController
{
    private $merchantPem;
    private $merchantKey;
    private $merchantId;
    private $action;
    protected $orderProcessService;
    // 直接在程式中設定開發者模式
    private $dev = 0;  // true = 測試環境, false = 正式環境

    public function __construct(OrderProcessService $orderProcessService)
    {
        parent::__construct($orderProcessService);
    }

    public function gateway(string $payway, string $orderSN)
    {
        try {
            $this->loadGateWay($orderSN, $payway);

            if (!$this->payGateway || !$this->order) {
                Log::error('ECPay gateway error: Required data not loaded', [
                    'orderSN' => $orderSN,
                    'payway' => $payway
                ]);
                return redirect()->back()->with('error', '支付初始化失敗');
            }

            // 根據開發模式設定相應的參數
            if ($this->dev) {
                // 測試環境參數
                $this->merchantKey = 'pwFHCqoQZGmho4w6';
                $this->merchantPem = 'EkRm7iFT261dpevs';
                $this->merchantId = '3002607';
                $this->action = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';
            } else {
                // 正式環境參數
                $this->merchantKey = $this->payGateway['merchant_key'];
                $this->merchantPem = $this->payGateway['merchant_pem'];
                $this->merchantId = $this->payGateway['merchant_id'];
                $this->action = 'https://payment.ecpay.com.tw/Cashier/AioCheckOut/V5';
            }

            // 準備訂單資料
            $data = [
                'MerchantID' => $this->merchantId,
                'MerchantTradeNo' => $orderSN,
                'MerchantTradeDate' => date('Y/m/d H:i:s'),
                'PaymentType' => 'aio',
                'TotalAmount' => (int)$this->order->actual_price,
                'TradeDesc' => '商品購買',
                'ItemName' => '商品一批',
                'ReturnURL' => route('ecpay.notify'),
                'OrderResultURL' => route('ecpay.return'),
                'ClientBackURL' => url('detail-order-sn', ['orderSN' => $orderSN]),
                'ChoosePayment' => 'ALL',
                'IgnorePayment' => 'Alipay#Credit#WebATM#BARCODE#BNPL#ECPAY',
                'EncryptType' => 1,
            ];

            $data['CheckMacValue'] = $this->generateCheckMacValue($data);

            Log::info('ECPay payment request:', [
                'orderSN' => $orderSN,
                'amount' => $data['TotalAmount'],
                'dev_mode' => $this->dev
            ]);

            $html = '<form id="ecpay-form" method="post" action="' . $this->action . '">';
            foreach ($data as $key => $value) {
                $html .= '<input type="hidden" name="' . $key . '" value="' . $value . '">';
            }
            $html .= '</form>';
            $html .= '<script>document.getElementById("ecpay-form").submit();</script>';

            return response($html);

        } catch (\Exception $e) {
            Log::error('ECPay gateway error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', '支付發起失敗');
        }
    }

    public function notifyUrl(Request $request)
    {
        $data = $request->all();
        Log::info('ECPay notify received:', $data);

        try {
            // 不需要重新設置，因為已經在構造函數中設置了
            // $checkMacValue = $data['CheckMacValue'];
            // unset($data['CheckMacValue']);
            
            // if ($this->generateCheckMacValue($data) !== $checkMacValue) {
            //     throw new \Exception('Invalid CheckMacValue');
            // }

            if ($data['RtnCode'] == '1') {
                $orderSN = $data['MerchantTradeNo'];
                
                // 載入訂單
                $this->loadGateWay($orderSN, 'ecpay');
                if (!$this->order) {
                    return response('訂單不存在');
                }

                // 檢查是否為模擬付款
                if (isset($data['SimulatePaid']) && $data['SimulatePaid'] == 1) {
                    Log::info('ECPay simulate payment received:', [
                        'orderSN' => $orderSN,
                        'amount' => $data['TradeAmt']
                    ]);
                    // return '1|OK';  // 模擬付款直接返回成功
                }

                try {
                    // 使用 completedOrder 處理訂單
                    $this->orderProcessService->completedOrder(
                        $orderSN,           // 訂單號
                        (float)$data['TradeAmt'], // 支付金額
                        $data['TradeNo']    // 交易號
                    );

                    Log::info('ECPay payment successful', [
                        'orderSN' => $orderSN,
                        'amount' => $data['TradeAmt'],
                        'trade_no' => $data['TradeNo']
                    ]);
                } catch (\Exception $e) {
                    throw $e;
                }
            }

            return '1|OK';
            
        } catch (\Exception $e) {
            Log::error('ECPay notify processing error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return '0|Error';
        }
    }

    public function returnUrl(Request $request)
    {
        $orderSN   = trim($request->input('MerchantTradeNo'));
        sleep(2);
        return redirect(url('detail-order-sn', ['orderSN' => $orderSN]));
    }

    private function generateCheckMacValue($data)
    {
        ksort($data);
        
        $str = '';
        foreach ($data as $key => $value) {
            if ($value === '' || $value === null) {
                $value = '';
            }
            $str .= "{$key}={$value}&";
        }
        
        $str = "HashKey={$this->merchantKey}&{$str}HashIV={$this->merchantPem}";
        $str = urlencode($str);
        $str = strtolower($str);
        
        $str = str_replace('%2d', '-', $str);
        $str = str_replace('%5f', '_', $str);
        $str = str_replace('%2e', '.', $str);
        $str = str_replace('%21', '!', $str);
        $str = str_replace('%2a', '*', $str);
        $str = str_replace('%28', '(', $str);
        $str = str_replace('%29', ')', $str);
        $str = str_replace('%20', '+', $str);
        
        return strtoupper(hash('sha256', $str));
    }

}
