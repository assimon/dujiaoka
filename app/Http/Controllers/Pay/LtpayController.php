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
                'time_expire' => '2m',
            ];
            // 将生成的签名添加到$config中
            $config['sign'] = $this->sign($config, $this->payGateway->merchant_pem);
            $config['return_url'] = url('detail-order-sn', ['orderSN' => $this->order->order_sn]);
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
                        $code = $result['code'];
                        if ($code == 1){
                            return;
                        }
                        $data = $result['data'];
                        $result['qr_code'] = $data['QRcode_url'];
                        $result['payname'] =$this->payGateway->pay_name;
                        $result['actual_price'] = (float)$this->order->actual_price;
                        $result['orderid'] = $this->order->order_sn;
                        return $this->render('static_pages/qrpay', $result, __('dujiaoka.scan_qrcode_to_pay'));
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
        $data = $request->post();
        $order = $this->orderService->detailOrderSN($data['pay_id']);
        if (!$order) {
            return 'fail';
        }
        $payGateway = $this->payService->detail($order->pay_id);
        if (!$payGateway) {
            return 'fail';
        }
        if($payGateway->pay_handleroute != '/pay/ltpay'){
            return 'fail';
        }
        try{
            // 验证签名
            $total_fee = (float)$data->total_fee;
            $this->orderProcessService->completedOrder($data->out_trade_no, $total_fee, $data->order_no);
            return 'success';
        } catch (\Exception $exception) {
            return 'fail';
        }
        /*if (!$data['pay_no'] || md5($query . $payGateway->merchant_pem ) != $data['sign']) { //不合法的数据
            return 'fail';  //返回失败 继续补单
        } else { //合法的数据
            //业务处理
            $this->orderProcessService->completedOrder($data['pay_id'], $data['money'], $data['pay_id']);
            return 'success';
        }*/
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
