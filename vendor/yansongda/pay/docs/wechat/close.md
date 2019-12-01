# 说明

| 方法名 | 参数 | 返回值 |
| :---: | :---: | :---: |
| close | string/array $order | Collection |

# 使用方法

## 例子

```PHP
$order = [
    'out_trade_no' => '1514027114',
];

// $order = '1514027114';

$result = $wechat->close($order);
```

## 订单配置参数

所有订单配置参数和官方无任何差别，兼容所有功能，所有参数请参考[这里](https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_3)，查看「请求参数」一栏。

### APP/小程序订单关闭

如果您需要关闭 `APP/小程序` 的订单，请传入参数：`['type' => 'app']`/`['type' => 'miniapp']`

# 返回值

返回 Collection 类型，可以通过 `$collection->xxx` 得到服务器返回的数据。

# 异常

* Yansongda\Pay\Exceptions\InvalidGatewayException ，表示使用了除本 SDK 支持的支付网关。
* Yansongda\Pay\Exceptions\InvalidSignException ，表示验签失败。
* Yansongda\Pay\Exceptions\InvalidConfigException ，表示缺少配置参数，如，`ali_public_key`, `private_key` 等。
* Yansongda\Pay\Exceptions\GatewayException ，表示支付宝/微信服务器返回的数据非正常结果，例如，参数错误，对账单不存在等。



