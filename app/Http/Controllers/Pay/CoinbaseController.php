<?php
namespace App\Http\Controllers\Pay;

use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use Illuminate\Http\Request;

class CoinbaseController extends PayController
{

    public function gateway(string $payway, string $orderSN)
    {
        try {
            // 加载网关
            $this->loadGateWay($orderSN, $payway);
            //构造要请求的参数数组，无需改动
            switch ($payway) {
                case 'coinbase':
                default:
                    try {
                        $createOrderUrl="https://api.commerce.coinbase.com/charges";
                        $price_amount = sprintf('%.2f', (float)$this->order->actual_price);// 只取小数点后两位
                        $fees = (double)$this->payGateway->merchant_id;//手续费费率  比如 0.05
                        if($fees>0.00)
                        {
                            $price_amount =(double)$price_amount * (1.00+$fees);// 价格 * （1 + 0.05）
                        }


                        $redirect_url = url('detail-order-sn', ['orderSN' => $this->order->order_sn]);  //同步地址
                        $cancel_url = url('detail-order-sn', ['orderSN' => $this->order->order_sn]);  //同步地址
                        $config = [
                            'name'=>$this->order->title,
                            'description'=>$this->order->title.'需付款'.$price_amount.'元',
                            'pricing_type' => 'fixed_price',
                            'local_price' => [
                                'amount' =>  $price_amount,
                                'currency' => 'CNY'
                            ],
                            'metadata' => [
                                'customer_id' =>  $this->order->order_sn,
                                'customer_name' => $this->order->title
                            ],
                            'redirect_url' =>$redirect_url,
                            'cancel_url'=> $cancel_url
                        ];
                        $header = array();
                        $header[] = 'Content-Type:application/json';
                        $header[] = 'X-CC-Api-Key:'.$this->payGateway->merchant_key; //APP key
                        $header[] = 'X-CC-Version: 2018-03-22';

                        $ch = curl_init(); //使用curl请求
                        curl_setopt($ch, CURLOPT_URL, $createOrderUrl);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($config));
                        $coinbase_json = curl_exec($ch);
                        curl_close($ch);

                        $coinbase_date=json_decode($coinbase_json,true);
                        if(is_array($coinbase_date))
                        {
                            $payment_url = $coinbase_date['data']['hosted_url'];
                        }
                        else
                        {
                            return 'fail|Coinbase支付接口请求失败';
                        }
                        return redirect()->away($payment_url);
                    } catch (\Exception $e) {
                        throw new RuleValidationException(__('dujiaoka.prompt.abnormal_payment_channel') . $e->getMessage());
                    }
                    break;
            }
        } catch (RuleValidationException $exception) {
            return $this->err($exception->getMessage());
        }
    }

    public function notifyUrl(Request $request)
    {
        $payload = file_get_contents( 'php://input' );
        $sig    = $_SERVER['HTTP_X_CC_WEBHOOK_SIGNATURE'];
		$data       = json_decode( $payload, true );
		$event_data = $data['event']['data'];
		$order = $this->orderService->detailOrderSN($event_data['metadata']['customer_id']);//
		if (!$order) {
			return 'fail';
		}
		$payGateway = $this->payService->detail($order->pay_id);
		if (!$payGateway) {
			return 'fail';
		}
		$secret = $payGateway->merchant_pem;//共享密钥
		$sig2 = hash_hmac( 'sha256', $payload, $secret );
        $result_str=array("confirmed","resolved");//返回的结果字符串数组
		if (!empty( $payload ) && ($sig === $sig2))
		{

			foreach ($event_data['payments'] as $payment) {
				//if ((strtolower($payment['status']) === 'confirmed')||(strtolower($payment['status']) === 'resolved')) {
                if(in_array(strtolower($payment['status']),$result_str)){
					$return_pay_amount = $payment['value']['local']['amount'];
					$return_currency=$payment['value']['local']['currency'];
					$return_status=strtolower($payment['status']);
				}
			}
            if($return_currency !== 'CNY')
			{
				return 'error|Notify: Wrong currency:'.$return_currency;
			}

			$bccomp = bccomp($order->actual_price, $return_pay_amount, 2); //如果订单金额 大于 实际支付金额 返回1，抛出异常
            if ($bccomp == 1) {
                throw new \Exception(__('Coinbase付款金额不足'));
            }
            $return_merchant_order_id = $event_data['metadata']['customer_id'];//卡网订单号
            $tradeid = $event_data['code'];//Coinbase订单号
            //if($return_status === 'confirmed'||$return_status === 'resolved')
            if(in_array(strtolower($payment['status']),$result_str)) {
                $this->orderProcessService->completedOrder($return_merchant_order_id, $order->actual_price, $tradeid);// 卡网订单号，订单金额（不能传入支付金额，否则抛出订单金额不一致异常），收款平台订单号
                return "{\"status\": 200}";
            } else {
                //不合法的数据
                return 'fail';
                //返回失败 继续补单
            }

        } else {
            //不合法的数据
            return 'fail|wrong sig';
            //返回失败 继续补单
        }


    }


}
