<?php
namespace App\Http\Controllers\Pay;


use App\Models\Pays;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Yansongda\Pay\Pay;

class WepayController extends PayController
{

    public function gateway($payway, $oid)
    {
        $check = $this->checkOrder($payway, $oid);
        if($check !== true) {
            return $this->error($check);
        }
        $config = [
            'app_id' => $this->payInfo['merchant_id'],
            'mch_id' => $this->payInfo['merchant_key'],
            'key' => $this->payInfo['merchant_pem'],
            'notify_url' => site_url().$this->payInfo['pay_handleroute'].'/notify_url',
            'return_url' => site_url().'searchOrderById?order_id='.$this->orderInfo['order_id'],
            'http' => [ // optional
                'timeout' => 10.0,
                'connect_timeout' => 10.0,
            ],
        ];
        $order = [
            'out_trade_no' => $this->orderInfo['order_id'],
            'total_fee' => (float)$this->orderInfo['actual_price'] * 100,
            'body' => '在线支付 - '. $this->orderInfo['product_name']
        ];
        switch ($this->payInfo['pay_check']){
            case 'wescan':
                try{
                    $result = Pay::wechat($config)->scan($order)->toArray();
                    $result['qr_code'] = $result['code_url'];
                    $result['payname'] = $this->payInfo['pay_name'];
                    $result['actual_price'] = $this->orderInfo['actual_price'];
                    $result['orderid'] = $this->orderInfo['order_id'];
                    return $this->view('static_pages/qrpay', $result);
                } catch (\Exception $e) {
                    return $this->error('支付通道异常~ '.$e->getMessage());
                }
                break;

        }
    }

    /**
     * 异步通知
     */
    public function notifyUrl()
    {
        $xml = file_get_contents('php://input');
        $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $oid = $arr['out_trade_no'];
        $cacheord = json_decode(Redis::hget('PENDING_ORDERS_LIST', $oid), true);
        if (!$cacheord) {
            return 'error';
        }
        //Log::debug(json_encode($cacheord));
        $payInfo = Pays::where('id', $cacheord['pay_way'])->first();
        $config = [
            'app_id' => $payInfo['merchant_id'],
            'mch_id' => $payInfo['merchant_key'],
            'key' => $payInfo['merchant_pem'],
        ];
        // Log::debug(json_encode($config));
        $pay = Pay::wechat($config);
        try{
            // 验证签名
            $result = $pay->verify();
            $total_fee = $result->total_fee / 100;
            $this->successOrder($result->out_trade_no, $result->transaction_id, $total_fee);
            return 'success';
        } catch (\Exception $exception) {
            return 'fail';
        }
    }

}
