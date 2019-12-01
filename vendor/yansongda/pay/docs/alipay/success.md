# 说明

| 方法名 | 参数 | 返回值 |
| :---: | :---: | :---: |
| success | 无 | Response |

# 使用方法

```PHP
// $result = $alipay->verify();

return $alipay->success()->send(); // laravel 框架直接 return $alipay->success();
```

## 订单配置参数

无

# 返回值

返回 Response 类型，可以通过`return $response->send();` 进行返回；如果在 laravel 框架中，可直接 `return $response;`

# 异常

* Yansongda\Pay\Exceptions\InvalidGatewayException ，表示使用了除本 SDK 支持的支付网关。
* Yansongda\Pay\Exceptions\InvalidSignException ，表示验签失败。
* Yansongda\Pay\Exceptions\InvalidConfigException ，表示缺少配置参数，如，`ali_public_key`, `private_key` 等。
* Yansongda\Pay\Exceptions\GatewayException ，表示支付宝/微信服务器返回的数据非正常结果，例如，参数错误，对账单不存在等。



