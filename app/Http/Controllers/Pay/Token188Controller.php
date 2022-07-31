<?php
namespace App\Http\Controllers\Pay;

use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use Illuminate\Http\Request;

class Token188Controller extends PayController
{

    public function gateway(string $payway, string $orderSN)
    {
        try {
            // 加载网关
            $this->loadGateWay($orderSN, $payway);
            $params = [
                'merchantId' => $this->payGateway->merchant_id,
                'outTradeNo' => $this->order->order_sn,
                'subject' => $this->order->order_sn,
                'totalAmount' => (float)$this->order->actual_price,
                'attach' => (float)$this->order->actual_price,
                'body' => $this->order->order_sn,
                'coinName' => 'USDT-TRC20',
                'notifyUrl' => url($this->payGateway->pay_handleroute . '/notify_url'),
                'callBackUrl'=>url('detail-order-sn', ['orderSN' => $this->order->order_sn]),
                'timestamp' => $this->msectime(),
                'nonceStr' => $this->getNonceStr(16)
            ];
            //echo $params['totalAmount'];
            $mysign = self::GetSign($this->payGateway->merchant_pem, $params);
            // 网关连接
            $ret_raw = self::_curlPost('https://api.token188.com/utg/pay/address', $params,$mysign,1);
            
    		
            $ret = @json_decode($ret_raw, true);

            if($ret['rst']=='300'){
                print_r($ret);
            }else{
                header("Location: ".$ret['data']['paymentUrl']);
            }
            
            
        } catch (RuleValidationException $exception) {
            return $this->err($exception->getMessage());
        }
    }


    public function notifyUrl(Request $request)
    {

        
        $content = file_get_contents('php://input');
		$json_param = json_decode($content, true); //convert JSON into array
        if(!empty($json_param)){
        
            $order = $this->orderService->detailOrderSN($json_param['outTradeNo']);
            if (!$order) {
                return 'fail';
            }
            $payGateway = $this->payService->detail($order->pay_id);
            if (!$payGateway) {
                return 'fail';
            }
            
            $coinPay_sign = $json_param['sign'];
    		unset($json_param['sign']);
    		unset($json_param['notifyId']);
    		$sign = self::GetSign($payGateway->merchant_pem, $json_param);
    		if ($sign !== $coinPay_sign) {
    			echo json_encode(['status' => 400]);
    			return false;
    		}
    		
    		$json_param['sign'] = $sign;
    		// check request format
    		if ($json_param['merchantId']!=$payGateway->merchant_id) {
    			echo json_encode(['status' => 401]);
    			return false;
    		}
    
            $this->orderProcessService->completedOrder($json_param['outTradeNo'], ($json_param['originalAmount']), $json_param['tradeNo']);
            echo 'success';
            die();
        }else{
            echo 'fail';
            die();
        }
    }


    public function GetSign($secret, $params)
    {
        $p=ksort($params);
        reset($params);

		if ($p) {
			$str = '';
			foreach ($params as $k => $val) {
				$str .= $k . '=' .  $val . '&';
			}
			$strs = rtrim($str, '&');
		}
		$strs .='&key='.$secret;

        $signature = md5($strs);

        //$params['sign'] = base64_encode($signature);
        return $signature;
    }
    public function msectime() {
		list($msec, $sec) = explode(' ', microtime());
		$msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
		return $msectime;
    }
    /**
     * 返回随机字符串
     * @param int $length
     * @return string
     */
    public static function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function _curlPost($url,$params=false,$signature,$ispost=0){
        
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300); //设置超时
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array('token:'.$signature)
        );
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
