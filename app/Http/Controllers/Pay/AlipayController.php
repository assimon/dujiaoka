<?php

namespace App\Http\Controllers\Pay;


use Illuminate\Http\Request;
use Yansongda\Pay\Pay;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Models\Payconfig;

class AlipayController extends PayController
{

    /**
     * 支付宝支付网关
     * @param $id
     * @param $oid
     * @param $pay_pay_check
     */
    public function gateway($id, $oid, $pay_pay_check)
    {
        $check = $this->checkOrder($id, $oid, $pay_pay_check);
        if($check !== true) {
            return $this->failed($check);
        }
        $config = [
            'app_id' => $this->payInfo['merchant_id'],
            'ali_public_key' => $this->payInfo['merchant_key'],
            'private_key' => $this->payInfo['merchant_pem'],
            'notify_url' => site_url().'pay/alipay/notify_url',
            'return_url' => site_url().'/#/orderQuery?key='.$this->orderInfo['oid'],
            'http' => [ // optional
                'timeout' => 10.0,
                'connect_timeout' => 10.0,
            ],
        ];
        $order = [
            'out_trade_no' => $this->orderInfo['oid'],
            'total_amount' => (float)$this->orderInfo['actual_price'],
            'subject' => '在线支付 - '. $this->orderInfo['rcg_account']
        ];
        switch ($pay_pay_check){
            case 'zfbf2f':
            case 'alipayscan':
                try{
                    $result = Pay::alipay($config)->scan($order);
                    return $this->success(['type' => 'scan', 'url' => $result->qr_code]);
                } catch (\Exception $e) {
                    return $this->failed('支付通道异常~ '.$e->getMessage());
                }
                break;
            case 'aliweb':
                try{
                    $result = Pay::alipay($config)->web($order);
                    return $result;
                } catch (\Exception $e) {
                    return $this->failed('支付通道异常~');
                }
                break;

        }
    }


    /**
     * 异步通知
     */
    public function notifyUrl(Request $request)
    {
        $oid = $request->post('out_trade_no');
        Log::debug($oid);
        Log::info('所有数据',$request->post());
        $cacheord = json_decode(Redis::hget(config('PENDING_ORDERS_LIST'), $oid), true);
        if (!$cacheord) {
            return 'error';
        }
        //Log::debug(json_encode($cacheord));
        $payInfo = Payconfig::where(['id' => $cacheord['pay_id'], 'pay_check' => $cacheord['pay_check']])->first();
        $config = [
            'app_id' => $payInfo['merchant_id'],
            'ali_public_key' => $payInfo['merchant_key'],
            'private_key' => $payInfo['merchant_pem'],
            'notify_url' => site_url().'pay/alipay/notify_url',
            'return_url' => config('H5_URL').'/#/orderQuery?key='.$oid,
        ];
        $pay = Pay::alipay($config);
        try{
            // 验证签名
            $result = $pay->verify();
            if ($result->trade_status == 'TRADE_SUCCESS' || $result->trade_status == 'TRADE_FINISHED') {
                $this->successOrder($result->out_trade_no, $result->trade_no, $result->total_amount);
            }
            return 'success';
        } catch (\Exception $exception) {
            Log::debug('notify'.$exception->getMessage(), $request->post());
            return 'fail';
        }
    }



}