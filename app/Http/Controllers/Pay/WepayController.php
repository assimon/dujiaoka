<?php
namespace App\Http\Controllers\Pay;


use App\Models\Payconfig;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Yansongda\Pay\Pay;

class WepayController extends PayController
{

    public function gateway($id, $oid, $pay_pay_check)
    {
        $check = $this->checkOrder($id, $oid, $pay_pay_check);
        if($check !== true) {
            return $this->failed($check);
        }
        $config = [
            'app_id' => $this->payInfo['merchant_id'],
            'mch_id' => $this->payInfo['merchant_key'],
            'key' => $this->payInfo['merchant_pem'],
            'notify_url' => site_url().'pay/wepay/notify_url',
            'return_url' => site_url().'/#/orderQuery?key='.$this->orderInfo['oid'],
            'http' => [ // optional
                'timeout' => 10.0,
                'connect_timeout' => 10.0,
            ],
        ];
        $order = [
            'out_trade_no' => $this->orderInfo['oid'],
            'total_fee' => (float)$this->orderInfo['actual_price'] * 100,
            'body' => '在线支付 - '. $this->orderInfo['rcg_account']
        ];
        switch ($pay_pay_check){
            case 'wescan':
                try{
                    $result = Pay::wechat($config)->scan($order);
                    return $this->success(['type' => 'scan', 'url' => $result->code_url]);
                } catch (\Exception $e) {
                    return $this->failed('支付通道异常~ '.$e->getMessage());
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
        $cacheord = json_decode(Redis::hget(config('PENDING_ORDERS_LIST'), $oid), true);
        if (!$cacheord) {
            return 'error';
        }
        //Log::debug(json_encode($cacheord));
        $payInfo = Payconfig::where(['id' => $cacheord['pay_id'], 'pay_check' => $cacheord['pay_check']])->first();
        $config = [
            'app_id' => $payInfo['merchant_id'],
            'mch_id' => $payInfo['merchant_key'],
            'key' => $payInfo['merchant_pem'],
            'notify_url' => url()->previous().'/pay/wepay/notify_url',
            'return_url' => config('H5_URL').'/#/orderQuery?key='.$oid,
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
            Log::debug('notify'.$exception->getMessage(), $result->all());
            return 'fail';
        }
    }

}