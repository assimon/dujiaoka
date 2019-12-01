<p align="center">
    <img src="https://payjs.cn/static/images/logo.png" width=80 />
</p>
<h2 align="center">PAYJS Wechat Payment Laravel Package</h2>
<p align="center">
  
   <a href="https://packagist.org/packages/xhat/payjs-laravel">
      <img src="https://poser.pugx.org/xhat/payjs-laravel/v/stable.png" alt="Latest Stable Version">
  </a> 
  
  <a href="https://packagist.org/packages/xhat/payjs-laravel">
      <img src="https://poser.pugx.org/xhat/payjs-laravel/downloads.png" alt="Total Downloads">
  </a> 
  
  <a href="https://packagist.org/packages/xhat/payjs-laravel">
    <img src="https://poser.pugx.org/xhat/payjs-laravel/license.png" alt="License">
  </a>
</p>

## 简介
本项目是基于 PAYJS 的 API 开发的 Laravel Package，可直接用于生产环境

PAYJS 针对个人主体提供微信支付接入能力，是经过检验的正规、安全、可靠的微信支付个人开发接口

其它版本: [PAYJS 通用开发包](https://github.com/xhat/payjs)


## 安装

通过 Composer 安装

```bash
$ composer require xhat/payjs-laravel
```

## 使用方法

### 一、发布并修改配置文件

- 发布配置文件
```shell
php artisan vendor:publish --provider="Xhat\Payjs\PayjsServiceProvider"
```
- 编辑配置文件 `config/payjs.php` 配置商户号和通信密钥
```php
return [
    'mchid' => '', // 填写商户号
    'key'   => '', // 填写通信KEY
];
```

### 二、在业务中使用

首先在业务模块中引入门面

```php
use Xhat\Payjs\Facades\Payjs;
```

- 扫码支付

```php
// 构造订单基础信息
$data = [
    'body' => '订单测试',                                // 订单标题
    'total_fee' => 2,                                   // 订单标题
    'out_trade_no' => time(),                           // 订单号
    'attach' => 'test_order_attach',                    // 订单附加信息(可选参数)
    'notify_url' => 'https://www.baidu.com/notify',     // 异步通知地址(可选参数)
];
return Payjs::native($data);
```

- 收银台模式支付（直接在微信浏览器打开）

```php
// 构造订单基础信息
$data = [
    'body' => '订单测试',                                    // 订单标题
    'total_fee' => 2,                                       // 订单金额
    'out_trade_no' => time(),                               // 订单号
    'attach' => 'test_order_attach',                        // 订单附加信息(可选参数)
    'notify_url' => 'https://www.baidu.com/notify',         // 异步通知地址(可选参数)
    'callback_url' => 'https://www.baidu.com/callback',     // 支付后前端跳转地址(可选参数)
];
$url = Payjs::cashier($data);
return redirect($url);
```

- JSAPI模式支付

```php
// 构造订单基础信息
$data = [
    'body' => '订单测试',                                    // 订单标题
    'total_fee' => 2,                                       // 订单金额
    'out_trade_no' => time(),                               // 订单号
    'attach' => 'test_order_attach',                        // 订单附加信息(可选参数)
    'openid' => 'xxxxxxxxxxxxxxxxx',                        // 订单附加信息(可选参数)
    'notify_url' => 'https://www.baidu.com/notify',         // 异步通知地址(可选参数)
];
return Payjs::jsapi($data);
```

- 查询订单

```php
// 根据订单号查询订单状态
$payjs_order_id = '****************';
return Payjs::check($payjs_order_id);
```

- 关闭订单

```php
// 根据订单号关闭订单
$payjs_order_id = '****************';
return Payjs::close($payjs_order_id);
```

- 退款

```php
// 根据订单号退款
$payjs_order_id = '****************';
return Payjs::refund($payjs_order_id);
```

- 获取商户资料


```php
// 返回商户基础信息
return Payjs::info();
```

- 获取用户资料

```php
// 根据订单信息中的 OPENID 查询用户资料
$openid = '***************';
return Payjs::user($openid);
```

- 查询银行名称

```php
// 根据订单信息中的银行编码查询银行中文名称
$bank = '***************';
return Payjs::bank($bank);
```

- 接收异步通知

```php
// 接收异步通知,无需关注验签动作,已自动处理
$notify_info = Payjs::notify();
Log::info($notify_info);
```

## 更新日志
Version 1.4
修正空值参数的过滤问题

## 安全相关
如果您在使用过程中发现各种 bug，请积极反馈，我会尽早修复

