# 支持的支付方法

微信支付目前支持 9 种支付方法，对应的支付 method 如下：

| method | 说明 | 参数 | 返回值 |
| :---: | :---: | :---: | :---: |
| mp | 公众号支付 | array $order | Collection |
| wap | 手机网站支付 | array $order | Response |
| app | APP 支付 | array $order | JsonResponse |
| pos | 刷卡支付 | array $order | Collection |
| scan | 扫码支付 | array $order | Collection |
| transfer | 账户转账 | array $order | Collection |
| miniapp | 小程序支付 | array $order | Collection |
| redpack | 普通红包 | array $order | Collection |
| groupRedpack | 裂变红包 | array $order | Collection |

# 使用方法

## 一、公众号支付

### 例子

```PHP
$order = [
    'out_trade_no' => time(),
    'body' => 'subject-测试',
    'total_fee' => '1',
    'openid' => 'onkVf1FjWS5SBxxxxxxxx',
];

$result = Pay::wechat($config)->mp($order);
// 返回 Collection 实例。包含了调用 JSAPI 的所有参数，如appId，timeStamp，nonceStr，package，signType，paySign 等；
// 可直接通过 $result->appId, $result->timeStamp 获取相关值。
// 后续调用不在本文档讨论范围内，请自行参考官方文档。
```

### 订单配置参数

**所有订单配置中，客观参数均不用配置，扩展包已经为大家自动处理了，比如，**`trade_type`，`appid`** **，** **`sign`, `spbill_create_ip` **等参数，大家只需传入订单类主观参数即可。**

所有订单配置参数和官方无任何差别，兼容所有功能，所有参数请参考[这里](https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_1)，查看「请求参数」一栏。

## 二、手机网站支付

### 例子

```PHP
$order = [
    'out_trade_no' => time(),
    'body' => 'subject-测试',
    'total_fee' => '1',
];

return $wechat->wap($order)->send(); // laravel 框架中请直接 return $wechat->wap($order)
```

### 订单配置参数

**所有订单配置中，客观参数均不用配置，扩展包已经为大家自动处理了，比如，**`trade_type`，`appid`** **，** **`sign`, `spbill_create_ip` **等参数，大家只需传入订单类主观参数即可。**

所有订单配置参数和官方无任何差别，兼容所有功能，所有参数请参考[这里](https://pay.weixin.qq.com/wiki/doc/api/H5.php?chapter=9_20&index=1)，查看「请求参数」一栏。

## 三、APP 支付

### 例子

```PHP
$order = [
    'out_trade_no' => time(),
    'body' => 'subject-测试',
    'total_fee' => '1',
];

// 将返回 json 格式，供后续 APP 调用，调用方式不在本文档讨论范围内，请参考官方文档。
return $wechat->app($order)->send(); // laravel 框架中请直接 return $wechat->app($order)
```

### 订单配置参数

**所有订单配置中，客观参数均不用配置，扩展包已经为大家自动处理了，比如，**`trade_type`，`appid`** **，** **`sign`, `spbill_create_ip` **等参数，大家只需传入订单类主观参数即可。**

所有订单配置参数和官方无任何差别，兼容所有功能，所有参数请参考[这里](https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_1)，查看「请求参数」一栏。

## 四、刷卡支付

### 例子

```PHP
$order = [
    'out_trade_no' => time(),
    'body' => 'subject-测试',
    'total_fee'      => '1',
    'auth_code' => '1354804793001231564897',
];

$result = $wechat->pos($order);
```

### 订单配置参数

**所有订单配置中，客观参数均不用配置，扩展包已经为大家自动处理了，比如，**`trade_type`，`appid`** **，** **`sign`, `spbill_create_ip` **等参数，大家只需传入订单类主观参数即可。**

所有订单配置参数和官方无任何差别，兼容所有功能，所有参数请参考[这里](https://pay.weixin.qq.com/wiki/doc/api/micropay.php?chapter=9_10&index=1)，查看「请求参数」一栏。

## 五、扫码支付

### 例子

```PHP
$order = [
    'out_trade_no' => time(),
    'body' => 'subject-测试',
    'total_fee'      => '1',
];

// 扫码支付使用 模式二
$result = $wechat->scan($order);
// 二维码内容： $qr = $result->code_url;
```

### 订单配置参数

**所有订单配置中，客观参数均不用配置，扩展包已经为大家自动处理了，比如，**`trade_type`，`appid`** **，** **`sign`, `spbill_create_ip` **等参数，大家只需传入订单类主观参数即可。**

所有订单配置参数和官方无任何差别，兼容所有功能，所有参数请参考[这里](https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_1)，查看「请求参数」一栏。

## 六、账户转账

### 例子

```PHP
$order = [
    'partner_trade_no' => '',              //商户订单号
    'openid' => '',                        //收款人的openid
    'check_name' => 'NO_CHECK',            //NO_CHECK：不校验真实姓名\FORCE_CHECK：强校验真实姓名
    // 're_user_name'=>'张三',              //check_name为 FORCE_CHECK 校验实名的时候必须提交
    'amount' => '1',                       //企业付款金额，单位为分
    'desc' => '帐户提现',                  //付款说明
];

$result = $wechat->transfer($order);
```

### 订单配置参数

**所有订单配置中，客观参数均不用配置，扩展包已经为大家自动处理了，比如，**`trade_type`，`appid`** **，** **`sign`, `spbill_create_ip` **等参数，大家只需传入订单类主观参数即可。**

所有订单配置参数和官方无任何差别，兼容所有功能，所有参数请参考[这里](https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=14_2)，查看「请求参数」一栏。

### 使用 APP/小程序 账号转账

如果您需要通过 `APP/小程序` 的商户账号appid进行转账，请传入参数：`['type' => 'app']`/`['type' => 'miniapp']`

### ！注意！

如果您在队列中使用，请自行传参 `spbill_create_ip`。

## 七、小程序

### 例子

```PHP
$order = [
    'out_trade_no' => time(),
    'body' => 'subject-测试',
    'total_fee' => '1',
    'openid' => 'onkVf1FjWS5SBxxxxxxxx',
];

$result = $wechat->miniapp($order);
// 返回 Collection 实例。包含了调用 JSAPI 的所有参数，如appId，timeStamp，nonceStr，package，signType，paySign 等；
// 可直接通过 $result->appId, $result->timeStamp 获取相关值。
// 后续调用不在本文档讨论范围内，请自行参考官方文档。
```

### 订单配置参数

**所有订单配置中，客观参数均不用配置，扩展包已经为大家自动处理了，比如，**`trade_type`，`appid`** **，** **`sign`, `spbill_create_ip` **等参数，大家只需传入订单类主观参数即可。**

所有订单配置参数和官方无任何差别，兼容所有功能，所有参数请参考[这里](https://pay.weixin.qq.com/wiki/doc/api/wxa/wxa_api.php?chapter=9_1)，查看「请求参数」一栏。

## 八、普通红包

### 例子

```PHP
$order = [
    'mch_billno' => '商户订单号',
    'send_name' => '商户名称',
    'total_amount' => '1',
    're_openid' => '用户openid',
    'total_num' => '1',
    'wishing' => '祝福语',
    'act_name' => '活动名称',
    'remark' => '备注',
];

$result = $wechat->redpack($order);
```

### 订单配置参数

**所有订单配置中，客观参数均不用配置，扩展包已经为大家自动处理了，比如，**`trade_type`，`appid`** **，** **`sign`, `spbill_create_ip` **等参数，大家只需传入订单类主观参数即可。**

所有订单配置参数和官方无任何差别，兼容所有功能，所有参数请参考[这里](https://pay.weixin.qq.com/wiki/doc/api/tools/cash_coupon.php?chapter=13_4&index=3)，查看「请求参数」一栏。

### ！注意！

如果您在队列中使用，请自行传参 `client_ip`。

## 九、裂变红包

### 例子

```PHP
$order = [
    'mch_billno' => '商户订单号',
    'send_name' => '商户名称',
    'total_amount' => '1',
    're_openid' => '用户openid',
    'total_num' => '3',
    'wishing' => '祝福语',
    'act_name' => '活动名称',
    'remark' => '备注',
];

$result = $wechat->groupRedpack($order);
```

### 订单配置参数

**所有订单配置中，客观参数均不用配置，扩展包已经为大家自动处理了，比如，**`trade_type`，`appid`** **，** **`sign`, `spbill_create_ip` **等参数，大家只需传入订单类主观参数即可。**

所有订单配置参数和官方无任何差别，兼容所有功能，所有参数请参考[这里](https://pay.weixin.qq.com/wiki/doc/api/tools/cash_coupon.php?chapter=13_5&index=4)，查看「请求参数」一栏。

# 返回值

**各支付方法返回值请参考「支持的支付方法」一节。**

返回只会返回两种类型 `Symfony\Component\HttpFoundation\Response` 或 `Yansongda\Supports\Collection`

* 返回 Response 类型时，可以通过 `return $response->send()` 直接进行返回（laravel 框架中使用请直接`return $response` ）
* 返回 Collection 类型时，可以通过 `$collection->xxx` 得到服务器返回的数据。 

# 异常

* Yansongda\Pay\Exceptions\InvalidGatewayException ，表示使用了除本 SDK 支持的支付网关。
* Yansongda\Pay\Exceptions\InvalidSignException ，表示验签失败。
* Yansongda\Pay\Exceptions\InvalidConfigException ，表示缺少配置参数，如，`ali_public_key`, `private_key` 等。
* Yansongda\Pay\Exceptions\GatewayException ，表示支付宝/微信服务器返回的数据非正常结果，例如，参数错误，对账单不存在等。



