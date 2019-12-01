# 说明

**请先熟悉 微信支付 开发文档！**

# QuickReference

```php
use Yansongda\Pay\Pay;

$config = [
    'appid' => 'wxb3fxxxxxxxxxxx', // APP APPID
    'app_id' => 'wxb3fxxxxxxxxxxx', // 公众号 APPID
    'miniapp_id' => 'wxb3fxxxxxxxxxxx', // 小程序 APPID
    'mch_id' => '145776xxxx',
    'key' => 'mF2suE9sU6Mk1CxxxxIxxxxx',
    'notify_url' => 'http://yanda.net.cn',
    'cert_client' => './cert/apiclient_cert.pem', // optional, 退款，红包等情况时需要用到
    'cert_key' => './cert/apiclient_key.pem',// optional, 退款，红包等情况时需要用到
    'log' => [ // optional
        'file' => './logs/wechat.log',
        'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
        'type' => 'single', // optional, 可选 daily.
        'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
    ],
    'http' => [ // optional
        'timeout' => 5.0,
        'connect_timeout' => 5.0,
        // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
    ],
    // 'mode' => 'dev',
];

// 支付
$order = [
    'out_trade_no' => time(),
    'body' => 'subject-测试',
    'total_fee'      => '1',
    'openid' => 'onkVf1FjWS5SBxxxxxxxx',
];

$result = Pay::wechat($config)->mp($order);

// 退款
$order = [
    'out_trade_no' => '1514192025',
    'out_refund_no' => time(),
    'total_fee' => '1',
    'refund_fee' => '1',
    'refund_desc' => '测试退款haha',
];

$result = Pay::wechat($config)->refund($order); // 返回 `Yansongda\Supports\Collection` 实例，可以通过 `$result->xxx` 访问服务器返回的数据。


// 查询
$result = Pay::wechat($config)->find('out_trade_no_123456'); // 返回 `Yansongda\Supports\Collection` 实例，可以通过 `$result->xxx` 访问服务器返回的数据。


// 取消
微信未提供取消订单接口，访问此接口将抛出 `GatewayException` 异常。


// 关闭
$result = Pay::wechat($config)->close('out_trade_no_123456'); // 返回 `Yansongda\Supports\Collection` 实例，可以通过 `$result->xxx` 访问服务器返回的数据。


// 验证服务器数据
$wechat = Pay::wechat($config)

// 是的，验签就这么简单！
$data = $wechat->verify(); // 返回 `Yansongda\Supports\Collection` 实例，可以通过 `$data->xxx` 访问服务器返回的数据。

$wechat->success()->send(); // 向微信服务器确认接收到的数据。laravel 框架中请直接 `return $wechat->success()`
```

# 注意

后续文档中，如果没有特别说明， `$wechat` 均代表`Pay::wechat($config)`

服务商的参数略有不同，请参考[微信服务商](../others/others.md#微信服务商模式)
