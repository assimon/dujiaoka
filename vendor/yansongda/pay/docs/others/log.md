# 日志系统

SDK 自带日志系统，如果需要指定日志文件或日志级别，请 config 中传入下列参数。如果不传入，默认为 `warning` 级别，日志路径在 `sys_get_temp_dir().'/logs/yansongda.pay.log' `

```php
'log' => [
    'file' => './logs/pay.log', // 请注意权限
    'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
    'type' => 'single', // optional, 可选 daily， daily 时将按时间自动划分文件.
    'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
],
```

## 使用日志功能

> 使用日志功能前，请先确认已经使用过支付等功能进行了初始化！

```php
use Yansongda\Pay\Log;

Log::debug('Paying...', $order->all());
```
