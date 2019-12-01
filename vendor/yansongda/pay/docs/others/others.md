# guzzle 自定义配置

> v2.5.0-beta 及以上支持

SDK 依赖 guzzle 作 http 的请求客户端。所以如果有特殊配置需求，可直接在 config 中传入一下配置项来启用自定义配置。

```php
'http' => [
    'timeout' => 5.0,
    'connect_timeout' => 5.0,
    // ...
],
```

更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)

如果不传入任何配置项，SDK 默认的配置规则为：

```php
'http' => [
    'timeout' => 5.0,
    'connect_timeout' => 5.0,
],
```

# 支持的模式

| 支付 | 模式 | 说明 |
| :---: | :---: | :---: |
| alipay | dev | 沙箱模式 |
| wechat | dev | 沙箱模式 |
| wechat | hk | 东南亚节点 |
| wechat | service | 服务商模式 |

## 沙箱模式

支付宝及微信均提供了沙箱测试模式，如果需要启动，请 config 中传入下列参数。

```php
['mode' => 'dev']
```

### 关于微信沙箱模式

微信沙箱模式已经全面支持，无需手动调用 `getsignkey` 方法，SDK 已经完全支持。关于测试用例，请参考 [官方文档](https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=23_1)

## 微信服务商模式

> 版本要求: version >= 2.1.0

config 配置参数如下。

```php
$config = [
    'appid' => 'wxb3fxxxxxxxxxxx', // APP APPID
    'app_id' => 'wxb3fxxxxxxxxxxx', // 公众号 APPID
    'miniapp_id' => 'wxb3fxxxxxxxxxxx', // 小程序 APPID
    'sub_appid' => 'wxb3fxxxxxxxxxxx', // 子商户 APP APPID
    'sub_app_id' => 'wxb3fxxxxxxxxxxx', // 子商户 公众号 APPID
    'sub_miniapp_id' => 'wxb3fxxxxxxxxxxx', // 子商户 小程序 APPID
    'mch_id' => '146xxxxxx', // 商户号
    'sub_mch_id' => '146xxxxxx', // 子商户商户号
    'key' => '4e538260xxxxxxxxxxxxxxxxxxxxxx', // 主商户 key
    'notify_url' => 'http://yanda.net.cn/notify.php',
    'cert_client' => './cert/apiclient_cert.pem', // optional，退款等情况时用到
    'cert_key' => './cert/apiclient_key.pem',// optional，退款等情况时用到
    'log' => [ // optional
        'file' => './logs/wechat.log',
        'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
        'type' => 'single', // optional, 可选 daily， daily 时将按时间自动划分文件.
        'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
    ],
    'mode' => 'service',
]
```

**说明：** 处于服务商模式下的时候，`appid`、`app_id`、`miniapp_id` 均为**主商户**的信息，`sub_` 开头的为**子服务商**的信息

详细请参考 [https://github.com/yansongda/pay/pull/82](https://github.com/yansongda/pay/pull/82)
