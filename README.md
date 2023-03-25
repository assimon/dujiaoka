![](https://files.mdnice.com/user/39773/dc2143d7-422a-4fe3-8bcb-692e8c6cbd9a.png)

<p align="center">
<img alt="GitHub" src="https://img.shields.io/github/license/outtimes/dujiaoka?style=for-the-badge">
<img alt="GitHub tag (latest by date)" src="https://img.shields.io/github/v/tag/outtimes/dujiaoka?label=version&style=for-the-badge">
<img alt="PHP Version" src="https://img.shields.io/static/v1?label=PHP&message=7.4&style=for-the-badge">
<img alt="Telegram" src="https://img.shields.io/static/v1?label=Telegram&logo=Telegram&message=@dujiaoka&style=for-the-badge&color=blue&&link=https://t.me/dujiaoka">
</p>

## :bulb:版本介绍
这是一份基于[独角数卡](https://github.com/assimon/dujiaoka)在[dc53741](https://github.com/assimon/dujiaoka/commit/dc53741e275007b8c81c43319ee657ef011bad93)基础上修改的版本。此版本在部分功能上与原版有所修改，故请以本仓库的Wiki/Issues得到的反馈为准。

以下是目前几个比较重要的更改：
- 补充插件表结构
- Unicorn模板支持深色模式，优化样式，显示销量，支持极验验证
- 新增支付宝WAP支付，微信小程序支付[（开发参考）](https://github.com/outtimes/dujiaoka/wiki/微信小程序支付开发说明)
- 优先全站HTTPS
- 支持手动补单
- 优惠券支持系数优惠/固定金额优惠

## :open_book:关于此项目

- 程序框架使用 [Laravel](https://github.com/laravel/laravel)
- 后台系统框架 [Dcat Admin](http://www.dcatadmin.com)
- 部分支付系统集成 [yansongda/Pay](https://github.com/yansongda/pay)
- 区块链代币支付系统集成 [Tokenpay](https://github.com/LightCountry/TokenPay)

### 项目原版作者：
- [Assimon](https://github.com/assimon)

#### 核心贡献者：
- [iLay1678](https://github.com/iLay1678)

#### 模板贡献者：
- [Julyssn](https://github.com/Julyssn) 模板`luna`作者
- [bimoe](https://github.com/bimoe) 模板`hyper`作者

鸣谢以上开源项目及贡献者，排名不分先后。

## :thinking:为什么选择独角数卡

- 基于`Laravel`框架开发，优雅且带来安全稳定的系统架构。
- 简洁优雅的`系统模板`，能自行上手客制化。
- 支持`多国语言扩展`，能自行将独角数卡翻译到目标语言。
- 代码*全开源*，所有信息均安全存储在您的服务器上。
- `5K+`的用户的选择，众多资深使用者为你答疑解惑（不是一定）。

## :wink:在开始之前你需要知道

- 本程序有一定的上手安装难度，请具备Linux服务器相关的基础知识，跟随Wiki一步一步安装基本不会出现问题。
- 本程序不支持虚拟主机，未在Windows服务器上进行测试，请直接使用Linux服务器完成搭建。
- 本程序*暂不支持*PHP8，请使用PHP7.4及以上的版本
- 提问，没人回答？买别人的时间。

## :speech_balloon:使用交流
- 原作者的[Telegram群组](https://t.me/dujiaoka)
- 原作者的[Telegram官方频道](https://t.me/dujiaoshuka)

## :eye_speech_bubble:相关推荐
- [两米商店 2MStore](https://buy.2m.pub) ，也可视为前台演示站。
> 以下为原作者推荐
> - （美国免备案vps，配置2核2G仅需`20.98$`≈`145RMB`一年/支持支付宝付款）[👉🏻点我直达](https://my.racknerd.com/aff.php?aff=2745&pid=681)

## :open_mouth:快速预览
【官方`Unicorn`模板首页】
![首页](https://files.mdnice.com/user/39773/7669cf85-4e93-4572-a1b8-f11170c50b90.png)

【`hyper`模板】  
![](https://files.mdnice.com/user/39773/5f649d68-a1ce-4911-accb-2b7467e8fa4f.png)

【`luna`模板】 
![](https://files.mdnice.com/user/39773/10ffe97d-fb17-4f69-bb4e-e82f9befdc3d.png)

## :compass:相关教程
> 以下为原作者提供
- [Linux环境安装](https://github.com/assimon/dujiaoka/wiki/linux_install)
- [2.x版本宝塔安装教程](https://github.com/assimon/dujiaoka/wiki/2.x_bt_install)
- [1.x版本宝塔环境安装](https://github.com/assimon/dujiaoka/wiki/1.x_bt_install)
- [常见问题锦集-你遇到的问题大部分能在这里找到解决！！](https://github.com/assimon/dujiaoka/wiki/problems)
- [系统升级](https://github.com/assimon/dujiaoka/wiki/update)
- [各支付对应后台配置](https://github.com/assimon/dujiaoka/wiki/problems#各支付对应配置)
- [视频教程及工具集合](https://pan.dujiaoka.com)

## :bank:支持的支付接口
- [x] 支付宝当面付、PC网站、手机网站
- [x] 微信Native、H5、小程序
- [x] Payjs
- [x] 码支付(QQ/支付宝/微信)
- [x] [Paypal支付(默认美元)](https://www.paypal.com)
- [x] V免签支付
- [x] 全网易支付支持(通用彩虹版)
- [x] [stripe](https://stripe.com/)

## :earth_asia:PHP环境要求

星号(\*)为*必须*执行的要求，其他为建议内容

- **\*安装`fileinfo`扩展**
- **\*安装`redis`扩展**
- **\*终端需支持`php-cli`，测试`php -v`(版本必须一致)**
- **\*需要开启的函数：`putenv`，`proc_open`，`pcntl_signal`，`pcntl_alarm`**
- 安装`opcache`扩展

## :cop:默认管理信息（请务必安装完后修改）

- 后台路径 `/admin`
- 默认管理员账号 `admin`
- 默认管理员密码 `admin`

## :eyes:免责声明

独角数卡是一款用于学习PHP搭建自动化销售系统的程序案例，仅供学习交流使用。
严禁用于用于任何违反`中华人民共和国(含台湾省)`或`使用者所在地区`法律法规的用途。      
因为作者即本人仅完成代码的开发和开源活动`(开源即任何人都可以下载使用)`，从未参与用户的任何运营和盈利活动。    
且不知晓用户后续将`程序源代码`用于何种用途，故用户使用过程中所带来的任何法律责任即由用户自己承担。      

## :raised_hands:License

独角数卡 DJK Inc [MIT license](https://opensource.org/licenses/MIT).
