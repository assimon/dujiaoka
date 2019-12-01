# 说明

**请先熟悉 支付宝支付 开发文档！**

使用的加密方式为支付宝官方推荐的 **RSA2**，目前只支持这一种加密方式，且没有支持其他加密方式的计划。

# QuickReference

```php
use Yansongda\Pay\Pay;

$config = [
    'app_id' => '2016082000295641',
    'notify_url' => 'http://yansongda.cn/notify.php',
    'return_url' => 'http://yansongda.cn/return.php',
    'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuWJKrQ6SWvS6niI+4vEVZiYfjkCfLQfoFI2nCp9ZLDS42QtiL4Ccyx8scgc3nhVwmVRte8f57TFvGhvJD0upT4O5O/lRxmTjechXAorirVdAODpOu0mFfQV9y/T9o9hHnU+VmO5spoVb3umqpq6D/Pt8p25Yk852/w01VTIczrXC4QlrbOEe3sr1E9auoC7rgYjjCO6lZUIDjX/oBmNXZxhRDrYx4Yf5X7y8FRBFvygIE2FgxV4Yw+SL3QAa2m5MLcbusJpxOml9YVQfP8iSurx41PvvXUMo49JG3BDVernaCYXQCoUJv9fJwbnfZd7J5YByC+5KM4sblJTq7bXZWQIDAQAB',
    'private_key' => 'MIIEpAIBAAKCAQEAs6+F2leOgOrvj9jTeDhb5q46GewOjqLBlGSs/bVL4Z3fMr3p+Q1Tux/6uogeVi/eHd84xvQdfpZ87A1SfoWnEGH5z15yorccxSOwWUI+q8gz51IWqjgZxhWKe31BxNZ+prnQpyeMBtE25fXp5nQZ/pftgePyUUvUZRcAUisswntobDQKbwx28VCXw5XB2A+lvYEvxmMv/QexYjwKK4M54j435TuC3UctZbnuynSPpOmCu45ZhEYXd4YMsGMdZE5/077ZU1aU7wx/gk07PiHImEOCDkzqsFo0Buc/knGcdOiUDvm2hn2y1XvwjyFOThsqCsQYi4JmwZdRa8kvOf57nwIDAQABAoIBAQCw5QCqln4VTrTvcW+msB1ReX57nJgsNfDLbV2dG8mLYQemBa9833DqDK6iynTLNq69y88ylose33o2TVtEccGp8Dqluv6yUAED14G6LexS43KtrXPgugAtsXE253ZDGUNwUggnN1i0MW2RcMqHdQ9ORDWvJUCeZj/AEafgPN8AyiLrZeL07jJz/uaRfAuNqkImCVIarKUX3HBCjl9TpuoMjcMhz/MsOmQ0agtCatO1eoH1sqv5Odvxb1i59c8Hvq/mGEXyRuoiDo05SE6IyXYXr84/Nf2xvVNHNQA6kTckj8shSi+HGM4mO1Y4Pbb7XcnxNkT0Inn6oJMSiy56P+CpAoGBAO1O+5FE1ZuVGuLb48cY+0lHCD+nhSBd66B5FrxgPYCkFOQWR7pWyfNDBlmO3SSooQ8TQXA25blrkDxzOAEGX57EPiipXr/hy5e+WNoukpy09rsO1TMsvC+v0FXLvZ+TIAkqfnYBgaT56ku7yZ8aFGMwdCPL7WJYAwUIcZX8wZ3dAoGBAMHWplAqhe4bfkGOEEpfs6VvEQxCqYMYVyR65K0rI1LiDZn6Ij8fdVtwMjGKFSZZTspmsqnbbuCE/VTyDzF4NpAxdm3cBtZACv1Lpu2Om+aTzhK2PI6WTDVTKAJBYegXaahBCqVbSxieR62IWtmOMjggTtAKWZ1P5LQcRwdkaB2rAoGAWnAPT318Kp7YcDx8whOzMGnxqtCc24jvk2iSUZgb2Dqv+3zCOTF6JUsV0Guxu5bISoZ8GdfSFKf5gBAo97sGFeuUBMsHYPkcLehM1FmLZk1Q+ljcx3P1A/ds3kWXLolTXCrlpvNMBSN5NwOKAyhdPK/qkvnUrfX8sJ5XK2H4J8ECgYAGIZ0HIiE0Y+g9eJnpUFelXvsCEUW9YNK4065SD/BBGedmPHRC3OLgbo8X5A9BNEf6vP7fwpIiRfKhcjqqzOuk6fueA/yvYD04v+Da2MzzoS8+hkcqF3T3pta4I4tORRdRfCUzD80zTSZlRc/h286Y2eTETd+By1onnFFe2X01mwKBgQDaxo4PBcLL2OyVT5DoXiIdTCJ8KNZL9+kV1aiBuOWxnRgkDjPngslzNa1bK+klGgJNYDbQqohKNn1HeFX3mYNfCUpuSnD2Yag53Dd/1DLO+NxzwvTu4D6DCUnMMMBVaF42ig31Bs0jI3JQZVqeeFzSET8fkoFopJf3G6UXlrIEAQ==',
    'log' => [ // optional
        'file' => './logs/alipay.log',
        'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
        'type' => 'single', // optional, 可选 daily.
        'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
    ],
    'http' => [ // optional
        'timeout' => 5.0,
        'connect_timeout' => 5.0,
        // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
    ],
    // 'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
];

// 支付
$order = [
    'out_trade_no' => time(),
    'total_amount' => '1',
    'subject' => 'test subject - 测试',
];

$alipay = Pay::alipay($config)->web($order);

return $alipay->send();// laravel 框架中请直接 `return $alipay`

// 退款
$order = [
    'out_trade_no' => '1514027114',
    'refund_amount' => '0.01',
];

$result = Pay::alipay($config)->refund($order); // 返回 `Yansongda\Supports\Collection` 实例，可以通过 `$result->xxx` 访问服务器返回的数据。


// 查询
$result = Pay::alipay($config)->find('out_trade_no_123456'); // 返回 `Yansongda\Supports\Collection` 实例，可以通过 `$result->xxx` 访问服务器返回的数据。


// 取消
$result = Pay::alipay($config)->cancel('out_trade_no_123456'); // 返回 `Yansongda\Supports\Collection` 实例，可以通过 `$result->xxx` 访问服务器返回的数据。


// 关闭
$result = Pay::alipay($config)->close('out_trade_no_123456'); // 返回 `Yansongda\Supports\Collection` 实例，可以通过 `$result->xxx` 访问服务器返回的数据。


// 验证服务器数据
$alipay = Pay::alipay($config)

// 是的，验签就这么简单！
$data = $alipay->verify(); // 返回 `Yansongda\Supports\Collection` 实例，可以通过 `$data->xxx` 访问服务器返回的数据。

$alipay->success()->send(); // 向支付宝服务器确认接收到的数据。laravel 框架中请直接 `return $alipay->success()`
```

# 注意

后续文档中，如果没有特别说明， `$alipay` 均代表`Pay::alipay($config)`

