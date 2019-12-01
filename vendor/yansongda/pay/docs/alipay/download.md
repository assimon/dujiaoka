# 说明

| 方法名 | 参数 | 返回值 |
| :---: | :---: | :---: |
| download | string/array $bill | string |

> 对账单下载功能在 v2.2.0 及以上版本可用

# 使用方法

## 例子

```PHP
$bill = [
    'bill_date' => '2016-04-05',    // 2016-04
    'bill_type' => 'trade'
];

// $bill = '2016-04-05';

$url = $alipay->download($bill);
```

## 订单配置参数

所有订单配置参数和官方无任何差别，兼容所有功能，所有参数请参考[这里](https://docs.open.alipay.com/api_15/alipay.data.dataservice.bill.downloadurl.query)，查看「请求参数」一栏。

# 返回值

返回 string 类型。直接返回账单下载链接。

# 异常

* Yansongda\Pay\Exceptions\InvalidGatewayException ，表示使用了除本 SDK 支持的支付网关。
* Yansongda\Pay\Exceptions\InvalidSignException ，表示验签失败。
* Yansongda\Pay\Exceptions\InvalidConfigException ，表示缺少配置参数，如，`ali_public_key`, `private_key` 等。
* Yansongda\Pay\Exceptions\GatewayException ，表示支付宝/微信服务器返回的数据非正常结果，例如，参数错误，对账单不存在等。



