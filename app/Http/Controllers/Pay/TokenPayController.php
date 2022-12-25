<?php
/**
 * The file was created by LightCountry.
 *
 * @author    https://github.com/LightCountry
 * @copyright https://github.com/LightCountry
 * @link      https://github.com/LightCountry/TokenPay
 */

namespace App\Http\Controllers\Pay;


use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class TokenPayController extends PayController
{
    public function gateway(string $payway, string $orderSN)
    {
        try {
            // 加载网关
            $this->loadGateWay($orderSN, $payway);
            //构造要请求的参数数组，无需改动
            $parameter = [
                "ActualAmount" => (float)$this->order->actual_price,//原价
                "OutOrderId" => $this->order->order_sn, 
                "OrderUserKey" => $this->order->email, 
                "Currency" => $this->payGateway->merchant_id,
                'RedirectUrl' => route('tokenpay-return', ['order_id' => $this->order->order_sn]),
                'NotifyUrl' => url($this->payGateway->pay_handleroute . '/notify_url'),
            ];
            $parameter['Signature'] = $this->VerifySign($parameter, $this->payGateway->merchant_key);
            $client = new Client([
				'headers' => [ 'Content-Type' => 'application/json' ]
			]);
            $response = $client->post($this->payGateway->merchant_pem.'/CreateOrder', ['body' =>  json_encode($parameter)]);
            $body = json_decode($response->getBody()->getContents(), true);
            if (!isset($body['success']) || $body['success'] != true) {
                return $this->err(__('dujiaoka.prompt.abnormal_payment_channel') . $body['message']);
            }
            return redirect()->away($body['data']);
        } catch (RuleValidationException $exception) {
        } catch (GuzzleException $exception) {
            return $this->err($exception->getMessage());
        }
    }

    private function VerifySign(array $parameter, string $signKey)
    {
        ksort($parameter);
        reset($parameter); //内部指针指向数组中的第一个元素
        $sign = '';
        $urls = '';
        foreach ($parameter as $key => $val) {
            if ($key != 'Signature') {
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
        $order = $this->orderService->detailOrderSN($data['OutOrderId']);
        if (!$order) {
            return 'fail';
        }
        $payGateway = $this->payService->detail($order->pay_id);
        if (!$payGateway) {
            return 'fail';
        }
        if($payGateway->pay_handleroute != 'pay/tokenpay'){
            return 'fail';
        }
        //合法的数据
		$signature = $this->VerifySign($data, $payGateway->merchant_key);
        if ($data['Signature'] != $signature) { //不合法的数据
            return 'fail';  //返回失败 继续补单
        } else {
            //合法的数据
            //业务处理
            $this->orderProcessService->completedOrder($data['OutOrderId'], $data['ActualAmount'], $data['Id']);
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
