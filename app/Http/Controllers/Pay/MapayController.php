<?php
namespace App\Http\Controllers\Pay;


use App\Models\Pays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class MapayController extends PayController
{

    const PAY_URI = 'https://codepay.fateqq.com/creat_order/?';

    public function gateway($payway, $oid)
    {
        $this->checkOrder($payway, $oid);
        //构造要请求的参数数组，无需改动
        $parameter = array(
            "id" => (int)$this->payInfo['merchant_id'],//平台ID号
            "price" => (float)$this->orderInfo['actual_price'],//原价
            "pay_id" => $this->orderInfo['order_id'], //可以是用户ID,站内商户订单号,用户名
            "param" => $this->payInfo['pay_check'],//自定义参数
            "act" => 0,//是否开启认证版的免挂机功能
            "outTime" => 120,//二维码超时设置
            "page" => 1,//付款页面展示方式
            'return_url' => site_url().'searchOrderById?order_id='.$this->orderInfo['order_id'],
            'notify_url' => site_url().$this->payInfo['pay_handleroute'].'/notify_url',
            "pay_type" => 0,//支付宝使用官方接口
            "chart" => 'utf-8'//字符编码方式
            //其他业务参数根据在线开发文档，添加参数.文档地址:https://codepay.fateqq.com/apiword/
            //如"参数名"=>"参数值"
        );
        switch ($this->payInfo['pay_check']){
            case 'mqq':
                $parameter['type'] = 2;
                break;
            case 'mzfb':
                $parameter['type'] = 1;
                break;
            case 'mwx':
            default:
                $parameter['type'] = 3;
                break;
        }
        $quri = mzf_md5_signquery($parameter, $this->payInfo['merchant_pem']);
        $payurl = self::PAY_URI.$quri; //支付页面
        return redirect()->away($payurl);
    }


    public function notifyUrl(Request $request)
    {
        $data = $request->post();
        $cacheord = json_decode(Redis::hget('PENDING_ORDERS_LIST', $data['pay_id']), true);
        if (!$cacheord) {
            return 'fail';
        }
        $payInfo = Pays::where('id', $cacheord['pay_way'])->first();
        $query = create_link_string($data);
        if (!$data['pay_no'] || md5($query.$payInfo['merchant_pem']) != $data['sign']) { //不合法的数据
            return 'fail';  //返回失败 继续补单
        } else { //合法的数据
            //业务处理
            $this->successOrder($data['pay_id'], $data['pay_no'], $data['money']);
            return 'success';
        }

    }


}


