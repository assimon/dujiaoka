<?php

namespace Xhat\Payjs;

class Payjs
{
    private $mchid;
    private $key;
    private $api_url_native;
    private $api_url_cashier;
    private $api_url_refund;
    private $api_url_close;
    private $api_url_check;
    private $api_url_user;
    private $api_url_info;
    private $api_url_bank;

    public function __construct()
    {
        $this->mchid = config('payjs.mchid');
        $this->key   = config('payjs.key');
        $api_url     = config('payjs.api_url');

        $this->api_url_native  = $api_url . 'native';
        $this->api_url_cashier = $api_url . 'cashier';
        $this->api_url_refund  = $api_url . 'refund';
        $this->api_url_close   = $api_url . 'close';
        $this->api_url_check   = $api_url . 'check';
        $this->api_url_user    = $api_url . 'user';
        $this->api_url_info    = $api_url . 'info';
        $this->api_url_bank    = $api_url . 'bank';
        $this->api_url_jsapi   = $api_url . 'jsapi';
        $this->api_url_facepay = $api_url . 'facepay';
    }

    // 扫码支付
    public function native(array $data)
    {
        $this->url = $this->api_url_native;
        return $this->post($data);
    }

    // 收银台模式
    public function cashier(array $data)
    {
        $this->url = $this->api_url_cashier;
        $data      = $this->sign($data);
        $url       = $this->url . '?' . http_build_query($data);
        return $url;
    }

    // JASAPI
    public function jsapi(array $data)
    {
        $this->url = $this->api_url_jsapi;
        return $this->post($data);
    }

    // 退款
    public function refund($payjs_order_id)
    {
        $this->url = $this->api_url_refund;
        $data      = ['payjs_order_id' => $payjs_order_id];
        return $this->post($data);
    }

    // 人脸支付
    public function facepay(array $data)
    {
        $this->url = $this->api_url_facepay;
        return $this->post($data);
    }

    // 关闭订单
    public function close($payjs_order_id)
    {
        $this->url = $this->api_url_close;
        $data      = ['payjs_order_id' => $payjs_order_id];
        return $this->post($data);
    }

    // 检查订单
    public function check($payjs_order_id)
    {
        $this->url = $this->api_url_check;
        $data      = ['payjs_order_id' => $payjs_order_id];
        return $this->post($data);
    }

    // 用户资料
    public function user($openid)
    {
        $this->url = $this->api_url_user;
        $data      = ['openid' => $openid];
        return $this->post($data);
    }

    // 商户资料
    public function info()
    {
        $this->url = $this->api_url_info;
        $data      = [];
        return $this->post($data);
    }

    // 银行资料
    public function bank($name)
    {
        $this->url = $this->api_url_bank;
        $data      = ['bank' => $name];
        return $this->post($data);
    }

    // 异步通知接收
    public function notify()
    {
        $data = request()->all();
        if ($this->checkSign($data) === true) {
            return $data;
        } else {
            return '验签失败';
        }
    }

    // 数据签名
    public function sign(array $data)
    {
        $data['mchid'] = $this->mchid;
        $data = array_filter($data);
        ksort($data);
        $data['sign'] = strtoupper(md5(urldecode(http_build_query($data) . '&key=' . $this->key)));
        return $data;
    }

    // 校验数据签名
    public function checkSign($data)
    {
        $in_sign = $data['sign'];
        unset($data['sign']);
        $data = array_filter($data);
        ksort($data);
        $sign = strtoupper(md5(urldecode(http_build_query($data) . '&key=' . $this->key)));
        return $in_sign == $sign ? true : false;
    }

    // 数据发送
    public function post($data)
    {
        $data   = $this->sign($data);
        $client = new \GuzzleHttp\Client([
            'header'      => ['User-Agent' => 'PAYJS Larevel Http Client'],
            'timeout'     => 10,
            'http_errors' => false,
            'defaults'    => ['verify' => false],
        ]);

        $rst = $client->request('POST', $this->url, ['form_params' => $data]);
        return json_decode($rst->getBody()->getContents(), true);
    }

}