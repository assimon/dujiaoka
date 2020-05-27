<p align="center"><img src="https://i.loli.net/2020/04/07/nAzjDJlX7oc5qEw.png" width="400"></p>

<p align="center">
<a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/license-MIT-blue" alt="license MIT"></a>
<a href="https://github.com/assimon/dujiaoka/releases/tag/v1.5"><img src="https://img.shields.io/badge/pod-v1.5-red" alt="version v1.5"></a>
<a href="https://shang.qq.com/wpa/qunwpa?idkey=37b6b06f7c941dae20dcd5784088905d6461064d7f33478692f0c4215546cee0"><img src="https://img.shields.io/badge/QQ%E7%BE%A4-568679748-green" alt="QQ群：568679748"></a>
</p>

## 从原版更换为修改版
将本项目所有文件直接覆盖原有文件，在网站根目录下执行`php artisan dujiao update` 即可无缝切换到修改版

## 修改说明
- [x] 增加choice模板,该模板具有以下特色功能：
  - 下拉式分类选择和商品选择
  - 分类密码
  - 商品密码 
- [x] 商品库存预警
- [x] 代充订单用户邮件提醒
- [x] 首页弹窗
- [x] 分类搜索和商品搜索
- [x] 文章中心
- [x] 对接[v免签](https://github.com/szvone/vmqphp)
- [x] 易支付增加同步回调

## 独角数卡

开源式站长自动化售货解决方案、高效、稳定、快速！

demo地址：[http://dujiaoka.com](http://dujiaoka.com)

- 框架来自：[laravel/framework](https://github.com/laravel/laravel).
- 后台管理系统：[laravel-admin](https://laravel-admin.org/).
- 前端ui [layui](https://www.layui.com/).     

核心贡献者：
- [iLay1678](https://github.com/iLay1678)

鸣谢以上开源项目及贡献者，排名不分先后.

## 界面尝鲜

![首页.png](https://i.loli.net/2020/04/07/dZwvKfnNGgkHSli.png)   
![后台.png](https://i.loli.net/2020/04/07/ZcYLqN4d2fuAI7X.png)    



## 支付接口已集成
- [x] 支付宝当面付
- [x] 支付宝PC支付
- [x] 支付宝手机支付
- [x] [payjs微信扫码](http://payjs.cn).
- [x] [Paysapi(支付宝/微信)](https://www.paysapi.com/).
- [x] [码支付(QQ/支付宝/微信)](https://codepay.fateqq.com/)
- [x] 微信企业扫码支付 
- [x] Paypal支付(默认美元) 
- [x] 麻瓜宝数字货币支付     
- [x] 全网易支付支持(针对彩虹版) 
 

## 基本环境要求

- (PHP + PHPCLI) version >= 7.0
- Nginx version >= 1.16
- MYSQL version >= 5.6
- Redis (高性能缓存服务)
- Supervisor (一个python编写的进程管理服务)
- Composer (PHP包管理器)
- Linux/Win (Win下未测试，建议直接Linux)

## PHP环境要求

星号(*)为必须执行的要求，其他为建议内容

- **\*安装`fileinfo`扩展**
- **\*安装`redis`扩展**
- **\*终端需支持`php-cli`，测试`php -v`(版本必须一致)**
- **\*需要开启的函数：`putenv`，`proc_open`，`pcntl_signal`，`pcntl_alarm`**
- 安装`opcache`扩展


## 安装篇

- [Linux环境安装](/wikis/linux_install.md)   
- [宝塔环境安装](/wikis/bt_install.md)
- [常见问题锦集](/wikis/problems.md)

## 默认后台

- 后台路径 `/admin`   
- 默认管理员账号 `admin`
- 默认管理员密码 `admin`

## 声明

本项目仅供开发学习使用，任何人用于任何用途均与项目作者无关！

## License

独角数卡 DJK Inc [MIT license](https://opensource.org/licenses/MIT).
