<?php

namespace App\Http\Controllers\Pay;


use App\Models\Pays;
use Illuminate\Http\Request;
use Yansongda\Pay\Pay;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class AlipayController extends PayController
{

    /**
     * 支付宝支付网关
     * @param $id
     * @param $oid
     * @param $pay_pay_check
     */
    public function gateway($payway, $oid)
    {
        $check = $this->checkOrder($payway, $oid);
        if($check !== true) {
            return $this->error($check);
        }
        $config = [
            'app_id' => $this->payInfo['merchant_id'],
            'ali_public_key' => $this->payInfo['merchant_key'],
            'private_key' => $this->payInfo['merchant_pem'],
            'notify_url' => site_url().$this->payInfo['pay_handleroute'].'/notify_url',
            'return_url' => site_url().'searchOrderById?order_id='.$this->orderInfo['order_id'],
            'http' => [ // optional
                'timeout' => 10.0,
                'connect_timeout' => 10.0,
            ],
        ];
        $order = [
            'out_trade_no' => $this->orderInfo['order_id'],
            'total_amount' => (float)$this->orderInfo['actual_price'],
            'subject' => '在线支付 - '. $this->orderInfo['product_name']
        ];
        switch ($this->payInfo['pay_check']){
            case 'zfbf2f':
            case 'alipayscan':
                try{
                    $result = Pay::alipay($config)->scan($order)->toArray();
                    $result['payname'] = $this->payInfo['pay_name'];
                    $result['actual_price'] = $this->orderInfo['actual_price'];
                    $result['orderid'] = $this->orderInfo['order_id'];
                    $result['jump_payuri'] = $result['qr_code'];
                    return $this->view('static_pages/qrpay', $result);
                } catch (\Exception $e) {
                    return $this->error('支付通道异常~ '.$e->getMessage());
                }
                break;
            case 'aliweb':
                try{
                    $result = Pay::alipay($config)->web($order);
                    return $result;
                } catch (\Exception $e) {
                    return $this->error('支付通道异常~');
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
        $cacheord = json_decode(Redis::hget('PENDING_ORDERS_LIST', $oid), true);
        if (!$cacheord) {
            return 'error';
        }

        $payInfo = Pays::where('id', $cacheord['pay_way'])->first()->toArray();
        $config = [
            'app_id' => $payInfo['merchant_id'],
            'ali_public_key' => $payInfo['merchant_key'],
            'private_key' => $payInfo['merchant_pem'],
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
            return 'fail';
        }
    }



}
