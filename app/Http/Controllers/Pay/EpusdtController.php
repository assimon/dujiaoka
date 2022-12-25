<?php
/**
 * The file was created by Assimon.
 *
 * @author    assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link      http://utf8.hk/
 */

namespace App\Http\Controllers\Pay;


use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class EpusdtController extends PayController
{
    public function gateway(string $payway, string $orderSN)
    {
        try {
            // 加载网关
            $this->loadGateWay($orderSN, $payway);
            //构造要请求的参数数组，无需改动
            $parameter = [
                "amount" => (float)$this->order->actual_price,//原价
                "order_id" => $this->order->order_sn, //可以是用户ID,站内商户订单号,用户名
                'redirect_url' => route('epusdt-return', ['order_id' => $this->order->order_sn]),
                'notify_url' => url($this->payGateway->pay_handleroute . '/notify_url'),
            ];
            $parameter['signature'] = $this->epusdtSign($parameter, $this->payGateway->merchant_id);
            $client = new Client([
                'headers' => [ 'Content-Type' => 'application/json' ]
            ]);
            $response = $client->post($this->payGateway->merchant_pem, ['body' => json_encode($parameter)]);
            $body = json_decode($response->getBody()->getContents(), true);
            if (!isset($body['status_code']) || $body['status_code'] != 200) {
                return $this->err(__('dujiaoka.prompt.abnormal_payment_channel') . $body['message']);
            }
            return redirect()->away($body['data']['payment_url']);
        } catch (RuleValidationException $exception) {
        } catch (GuzzleException $exception) {
            return $this->err($exception->getMessage());
        }
    }


    private function epusdtSign(array $parameter, string $signKey)
    {
        ksort($parameter);
        reset($parameter); //内部指针指向数组中的第一个元素
        $sign = '';
        $urls = '';
        foreach ($parameter as $key => $val) {
            if ($val == '') continue;
            if ($key != 'signature') {
                if ($sign != '') {
                    $sign .= "&";
                    $urls .= "&";
                }
                $sign .= "$key=$val"; //拼接为url参数形式
                $urls .= "$key=" . urlencode($val); //拼接为url参数形式
            }
        }
        $sign = md5($sign . $signKey);//密码追加进入开始MD5签名
        return $sign;
    }

    public function notifyUrl(Request $request)
    {
        $data = $request->all();
        $order = $this->orderService->detailOrderSN($data['order_id']);
        if (!$order) {
            return 'fail';
        }
        $payGateway = $this->payService->detail($order->pay_id);
        if (!$payGateway) {
            return 'fail';
        }
        if($payGateway->pay_handleroute != 'pay/epusdt'){
            return 'fail';
        }
        $signature = $this->epusdtSign($data, $payGateway->merchant_id);
        if ($data['signature'] != $signature) { //不合法的数据
            return 'fail';  //返回失败 继续补单
        } else {
            //合法的数据
            //业务处理
            $this->orderProcessService->completedOrder($data['order_id'], $data['amount'], $data['trade_id']);
            return 'ok';
        }
    }

    public function returnUrl(Request $request)
    {
        $oid = $request->get('order_id');
        // 异步通知还没到就跳转了，所以这里休眠2秒
        sleep(2);
        return redirect(url('detail-order-sn', ['orderSN' => $oid]));
    }

}
