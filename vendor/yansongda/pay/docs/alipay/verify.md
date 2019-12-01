# 说明

| 方法名 | 参数 | 返回值 |
| :---: | :---: | :---: |
| verify | 无 | Collection |

使用的加密方式为支付宝官方推荐的 **RSA2**，目前只支持这一种加密方式，且没有支持其他加密方式的计划。

# 使用方法

```PHP
$result = $alipay->verify();
// 是的，你没有看错，就是这么简单！

// return $alipay->success()->send(); // laravel 框架直接 return $alipay->success();
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



