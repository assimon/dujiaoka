<?php
namespace App\Http\Controllers\Pay;

use App\Models\Pays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class YipayController extends PayController
{

    public function gateway($payway, $oid)
    {
        $this->checkOrder($payway, $oid);
        //组装支付参数
        $parameter = [
            'pid' =>  $this->payInfo['merchant_id'],
            'type' => $this->payInfo['pay_check'],
            'out_trade_no' => $this->orderInfo['order_id'],
            'return_url' => site_url().'searchOrderById?order_id='.$this->orderInfo['order_id'],
            'notify_url' => site_url().$this->payInfo['pay_handleroute'].'/notify_url',
            'name'   => '在线支付-' . $this->orderInfo['order_id'],
            'money'  => (float)$this->orderInfo['actual_price'],
            'sign' =>$this->payInfo['merchant_pem'],
            'sign_type' =>'MD5'
        ];
        ksort($parameter); //重新排序$data数组
        reset($parameter); //内部指针指向数组中的第一个元素
        $sign = '';
        foreach ($parameter as $key => $val) {
            if ($key == "sign" || $key == "sign_type" || $val == "") continue;
            if ($key != 'sign') {
                if ($sign != '') {
                    $sign .= "&";
                }
                $sign .= "$key=$val"; //拼接为url参数形式
            }
        }

        $sign = md5($sign . $this->payInfo['merchant_pem']);//密码追加进入开始MD5签名
        $parameter['sign'] = $sign;
        //待请求参数数组
        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='" . $this->payInfo['merchant_key'] . "' method='get'>";

        foreach($parameter as $key => $val) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' value=''></form>";
        $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
        return $sHtml;
    }

    public function notifyUrl(Request $request)
    {
        $data = $request->all();
        $cacheord = json_decode(Redis::hget('PENDING_ORDERS_LIST', $data['out_trade_no']), true);
        if (!$cacheord) {
            return 'fail';
        }
        $payInfo = Pays::where('id', $cacheord['pay_way'])->first()->toArray();
        ksort($data); //重新排序$data数组
        reset($data); //内部指针指向数组中的第一个元素
        $sign = '';
        foreach ($data as $key => $val) {
            if ($key == "sign" || $key == "sign_type" || $val == "") continue;
            if ($key != 'sign') {
                if ($sign != '') {
                    $sign .= "&";
                }
                $sign .= "$key=$val"; //拼接为url参数形式
            }
        }

        if (!$data['trade_no'] || md5($sign.$payInfo['merchant_pem']) != $data['sign']) { //不合法的数据
            return 'fail';  //返回失败 继续补单
        } else { //合法的数据
            //业务处理
            $this->orderService->successOrder($data['out_trade_no'], $data['trade_no'], $data['money']);
            return 'success';
        }
    }
}
