# 说明

| 方法名 | 参数 | 返回值 |
| :---: | :---: | :---: |
| verify | 无 | Collection |

# 使用方法

## 支付异步通知验证

```PHP
$result = $wechat->verify();
// 是的，你没有看错，就是这么简单！

// return $wechat->success()->send(); // laravel 框架直接 return $wechat->success();
```

## 退款异步通知验证

> v2.4.0 及以上可用

```PHP
$result = $wechat->verify(null, true);
// 是的，你没有看错，就是这么简单！

// return $wechat->success()->send(); // laravel 框架直接 return $wechat->success();
```

## 订单配置参数

无

# 返回值

返回 Collection 类型，可以通过 `$collection->xxx` 得到服务器返回的数据。

# 异常

* Yansongda\Pay\Exceptions\InvalidGatewayException ，表示使用了除本 SDK 支持的支付网关。
* Yansongda\Pay\Exceptions\InvalidSignException ，表示验签失败。
* Yansongda\Pay\Exceptions\InvalidConfigException ，表示缺少配置参数，如，`ali_public_key`, `private_key` 等。
* Yansongda\Pay\Exceptions\GatewayException ，表示支付宝/微信服务器返回的数据非正常结果，例如，参数错误，对账单不存在等。



