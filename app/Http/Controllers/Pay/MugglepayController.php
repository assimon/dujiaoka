<?php
namespace App\Http\Controllers\Pay;

use App\Exceptions\AppException;
use App\Models\Pays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class MugglepayController extends PayController
{

    public function gateway($payway, $oid)
    {
        $this->checkOrder($payway, $oid);
        //构造要请求的参数数组，无需改动
        switch ($this->payInfo['pay_check']) {
            case 'mgcoin':
            default:
                try {
                    $arr['price_amount'] =  $this->orderInfo['actual_price'];
                    $arr['price_currency'] = 'CNY';
                    $arr['merchant_order_id'] = $this->orderInfo['order_id'];
                    $arr['title'] =  $this->orderInfo['product_name'];
                    $arr['description'] =  $this->orderInfo['product_name'];
                    $arr['token'] = md5($this->orderInfo['order_id']. 'CNY'.$this->payInfo['merchant_id']);
                    $arr['callback_url'] = site_url() . $this->payInfo['pay_handleroute'] . '/notify_url';
                    $arr['cancel_url'] = site_url();
                    $arr['success_url'] = site_url()  . 'searchOrderById/'.$this->orderInfo['order_id'];
                    $accesstoken = $this->payInfo['merchant_id'];
                    $curl = curl_init();
                    curl_setopt_array($curl, array(CURLOPT_URL => "https://api.mugglepay.com/v1/orders", CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 0, CURLOPT_FOLLOWLOCATION => true, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => http_build_query($arr), CURLOPT_HTTPHEADER => array("token:$accesstoken", "Content-Type: application/x-www-form-urlencoded")));
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $payment_url = json_decode($response, true)['payment_url'];
                    return redirect()->away($payment_url);
                } catch (\Exception $e) {
                    throw new AppException(__('prompt.abnormal_payment_channel') . $e->getMessage());
                }
                break;
        }
    }

    public function notifyUrl(Request $request)
    {
        $data = json_decode(file_get_contents('php://input'),true);
        $cacheord = json_decode(Redis::hget('PENDING_ORDERS_LIST', $data['merchant_order_id']), true);
        if (!$cacheord) {
            return 'fail';
        }
        $payInfo = Pays::where('id', $cacheord['pay_way'])->first();
        if (!$data['token'] || $data['token'] != md5($data['merchant_order_id']. 'CNY'.$payInfo['merchant_id'])) {
            //不合法的数据
            return 'fail';
            //返回失败 继续补单
        } else {
            //合法的数据
            //业务处理
            $this->successOrder($data['merchant_order_id'], $data['order_id'], $data['pay_amount']);
            return "{\"status\": 200}";
        }
    }

}
