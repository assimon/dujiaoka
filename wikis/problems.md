## 导航

- [PHP终端环境对应不上](#PHP终端环境对应不上)
- [后台管理密码忘记了](#后台管理密码忘记了)
- [邮件服务](#邮件服务)
- [修改后台登录地址](#修改后台登录地址)
- [易支付配置](#易支付配置)
- [后台主题配置](#后台主题配置)



## PHP终端环境对应不上
服务器终端下执行以下命令将宝塔php版本设置为系统php-cli版本 
```
ln -sf /www/server/php/73/bin/php /usr/bin/php
```
根据自己宝塔安装的php版本执行，不要照抄，这里是/php/73，你如果是php7.2的话就是/php/72

## 后台管理密码忘记了
服务器终端下`cd 网站根目录`, 执行以下命令重置管理员密码：    
```
php artisan admin:reset-password
```

## 邮件服务
编辑根目录下`.env`配置，配置邮件服务     
```
# 邮件服务配置
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=server@emails.dujiaoka.com
MAIL_FROM_NAME=独角发卡
MAIL_ENCRYPTION=null
```
如果不能发送邮件，就请尝试更换一下端口：`587` `465` `22`,挨个试试！  

记得改了`.env邮件配置`要去重启一下`Supervisor`的进程服务，否则不会生效！   
![重启进程](https://i.loli.net/2020/04/08/jGDBz6L12rHguni.png)  


## 修改后台登录地址
编辑项目根目录下`.env`里面的 `ADMIN_ROUTE_PREFIX`即可

## 易支付配置
市面上98%易支付都是彩虹的程序，独角数卡已经集成通用支付方式，但是由于请求支付地址不一样   
需要大家手动去改一下你使用的易支付的支付请求地址：   
网站根目录下`app\Http\Controllers\Pay\YipayController.php`第`11`行代码    


## 后台主题配置
编辑项目根目录下`.env`里面的 `ADMIN_SKIN`即可
