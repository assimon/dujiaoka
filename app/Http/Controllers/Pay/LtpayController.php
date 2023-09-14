<?php
/**
 * LtpayController.php
 * 蓝兔支付-微信
 * Author littlecow
 * Created on 2023-09-14 10:08:32
 */
namespace App\Http\Controllers\Pay;


use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use Illuminate\Http\Request;

class LtpayController extends PayController
{

    public function gateway(string $payway, string $orderSN)
    {
        try {
            // 加载网关
            $this->loadGateWay($orderSN, $payway);
            $config = [
                'mch_id' => $this->payGateway->merchant_id,
                'out_trade_no' => $this->order->order_sn,
                'total_fee' => (float)$this->order->actual_price,
                'body' => $this->order->order_sn,
                'timestamp' => time(),
                'notify_url' => url($this->payGateway->pay_handleroute . '/notify_url'),
            ];
            // 将生成的签名添加到$config中
            $config['sign'] = $this->sign($config, $this->payGateway->merchant_pem);
            $config['time_expire'] = '5m';
            switch ($payway){
                case 'ltwxnative':
                    try{
                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL => "https://api.ltzf.cn/api/wxpay/native",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => http_build_query($config),
                            CURLOPT_HTTPHEADER => [
                                "content-type: application/x-www-form-urlencoded"
                            ],
                        ]);
                        $result = curl_exec($curl);
                        $resultArray = json_decode($result, true);
                        $code = $resultArray['code'];
                        if ($code == 1){
                            return;
                        }
                        $data = $resultArray['data'];
                        $resultArray['qr_code'] = $data['code_url'];
                        $resultArray['payname'] =$this->payGateway->pay_name;
                        $resultArray['actual_price'] = (float)$this->order->actual_price;
                        $resultArray['orderid'] = $this->order->order_sn;
                        return $this->render('static_pages/qrpay', $resultArray, __('dujiaoka.scan_qrcode_to_pay'));
                    } catch (\Exception $e) {
                        throw new RuleValidationException(__('dujiaoka.prompt.abnormal_payment_channel') . $e->getMessage());
                    }
                    break;
            }
        } catch (RuleValidationException $exception) {
            return $this->err($exception->getMessage());
        }
    }

    /**
     * 异步通知
     */
    public function notifyUrl(Request $request)
    {
        $data = $request->all();
        $code = $data['code'];
        if ($code) {
            return 'FAIL';
        }
        $order = $this->orderService->detailOrderSN($data['out_trade_no']);
        if (!$order) {
            return 'FAIL';
        }
        $payGateway = $this->payService->detail($order->pay_id);
        if (!$payGateway) {
            return 'FAIL';
        }
        if($payGateway->pay_handleroute != 'pay/ltpay'){
            return 'FAIL';
        }
        try{
            $total_fee = (float)$data['total_fee'];
            $this->orderProcessService->completedOrder($data['out_trade_no'], $total_fee, $data['order_no']);
            return 'SUCCESS';
        } catch (\Exception $exception) {
            return 'FAIL';
        }
    }

    /**
     * 获取sign
     * @param array $data
     * @param $key
     * @return string
     */
    function sign(array $data, $key) {
        ksort($data);
        $sign = strtoupper(md5(urldecode(http_build_query($data)) . '&key=' . $key));
        return $sign;
    }

}
