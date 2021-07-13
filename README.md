<p align="center"><img src="https://i.loli.net/2020/04/07/nAzjDJlX7oc5qEw.png" width="400"></p>

<p align="center">
<a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/license-MIT-blue" alt="license MIT"></a>
<a href="https://github.com/assimon/dujiaoka/releases/tag/2.0.0.beta"><img src="https://img.shields.io/badge/version-2.0.0.beta-red" alt="version 2.0.0.beta"></a>
<a href="https://www.php.net/releases/7_4_0.php"><img src="https://img.shields.io/badge/PHP-7.4-lightgrey" alt="php74"></a>
<a href="https://shang.qq.com/wpa/qunwpa?idkey=37b6b06f7c941dae20dcd5784088905d6461064d7f33478692f0c4215546cee0"><img src="https://img.shields.io/badge/QQ%E7%BE%A4-568679748-green" alt="QQ群：568679748"></a>
</p>

## 独角数卡

开源式站长自动化售货解决方案、高效、稳定、快速！

demo地址：[http://dujiaoka.com](http://dujiaoka.com)

- 框架来自：[laravel/framework](https://github.com/laravel/laravel).
- 后台管理系统：[laravel-admin](https://laravel-admin.org/).
- 前端ui [layui](https://www.layui.com/).

核心贡献者：
- [iLay1678](https://github.com/iLay1678)

模板贡献者：
- [Julyssn](https://github.com/Julyssn) 模板`luna`作者
- [bimoe](https://github.com/bimoe) 模板`hyper`作者

鸣谢以上开源项目及贡献者，排名不分先后.

## 系统优势

采用业界流行的`laravel`框架，安全及稳定性提升。    
支持`自定义前端模板`功能   
支持`国际化多语言包`（需自行翻译）  
代码全部开源，所有扩展包采用composer加载，代码所有内容可溯源！     
长期技术更新支持！

## 写在前面
本程序有一定的上手难度（对于小白而言），需要您对linux服务器有基本的认识和操作度   
且本程序不支持虚拟主机，大概率也不支持windows服务器！  
如果您连宝塔、phpstudy、AppNode等一键可视化服务器面板也未曾使用或听说过，那么我大概率劝您放弃本程序！  
如果您觉得部署有难度，建议仔细阅读（仔细！）宝塔视频安装篇教程，里面有保姆级的安装流程和视频教程！   
认真观看部署教程我可以保证您98%可能性能部署成功！  
勤动手，多思考，善研究！

## 使用交流     
QQ群：568679748 （需付费，管理较严）    
Telegram: [https://t.me/dujiaoka](https://t.me/dujiaoka) (免费，管理相对宽松)


## 界面尝鲜
【layui模板】
![首页.png](https://i.loli.net/2020/08/04/lZOBGXtsHxIUi6W.png)   
![后台.png](https://i.loli.net/2020/04/07/ZcYLqN4d2fuAI7X.png)

【luna模板】 
![首页.png](https://i.loli.net/2020/10/24/ElKwJFsQy4a9fZi.png)
![订单页.png](https://i.loli.net/2020/10/24/jG5Mw137HrzOlFA.png)

【hyper模板】  
![首页.png](https://i.loli.net/2021/01/06/nHCSV5PdJIzT6Gy.png)

## 支付接口已集成
- [x] 支付宝当面付
- [x] 支付宝PC支付
- [x] 支付宝手机支付
- [x] [payjs微信扫码](http://payjs.cn).
- [x] [Paysapi(支付宝/微信)](https://www.paysapi.com/).
- [x] 码支付(QQ/支付宝/微信)
- [x] 微信企业扫码支付
- [x] [Paypal支付(默认美元)](https://www.paypal.com)
- [x] [麻瓜宝数字货币支付](https://mugglepay.com/)
- [x] V免签支付
- [x] 全网易支付支持(通用彩虹版)
- [x] [stripe](https://stripe.com/)

## 基本环境要求

- (PHP + PHPCLI) version = 7.4
- Nginx version >= 1.16
- MYSQL version >= 5.6
- Redis (高性能缓存服务)
- Supervisor (一个python编写的进程管理服务)
- Composer (PHP包管理器)
- Linux (Win下未测试，建议直接Linux)

## PHP环境要求

星号(*)为必须执行的要求，其他为建议内容

- **\*安装`fileinfo`扩展**
- **\*安装`redis`扩展**
- **\*终端需支持`php-cli`，测试`php -v`(版本必须一致)**
- **\*需要开启的函数：`putenv`，`proc_open`，`pcntl_signal`，`pcntl_alarm`**
- 安装`opcache`扩展


## 安装篇

- [Linux环境安装](https://github.com/assimon/dujiaoka/wiki/linux_install)
- [1.x版本宝塔环境安装](https://github.com/assimon/dujiaoka/wiki/1.x_bt_install)
- [2.x版本宝塔安装教程](https://github.com/assimon/dujiaoka/wiki/2.x_bt_install)
- [常见问题锦集-你遇到的问题大部分能在这里找到解决！！](https://github.com/assimon/dujiaoka/wiki/problems)
- [系统升级](https://github.com/assimon/dujiaoka/wiki/update)
- [各支付对应后台配置](https://github.com/assimon/dujiaoka/wiki/problems#各支付对应配置)


## 默认后台

- 后台路径 `/admin`
- 默认管理员账号 `admin`
- 默认管理员密码 `admin`

## 免责声明

本项目仅供开发学习使用，任何人用于任何用途均与项目作者无关！

## 恰饭时间到
- [稳定建站免备案vps点我直达](https://www.kvmla.pro/aff.php?aff=2761)
<p align="center"  width="400">
<a href="https://www.kvmla.pro/aff.php?aff=2761"><img src="https://i.loli.net/2020/07/10/FZRSU1NemgM6zXJ.png" alt="kvmla.com"></a>
</p>

## Thanks

Thanks JetBrains for the free open source license

<a href="https://www.jetbrains.com/?from=gev" target="_blank">
	<img src="https://i.loli.net/2021/02/08/2aejB8rwNmQR7FG.png" width = "260" align=center />
</a>


## License

独角数卡 DJK Inc [MIT license](https://opensource.org/licenses/MIT).
