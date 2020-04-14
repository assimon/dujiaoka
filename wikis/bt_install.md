## 前景概要
`正式上线后一定要将.env配置里面的APP_DEBUG设置为false`   
`正式上线后一定要将.env配置里面的APP_DEBUG设置为false`   
`正式上线后一定要将.env配置里面的APP_DEBUG设置为false`   
接下来又到了最无脑的宝塔安装时间！   
准备好了奥，奥利给！  

首先： 
你需要一台内存`512M`或以上为最佳的vps或云服务器  
其次 你的服务器操作系统要为 `linux` 内核，我可不管你是什么`centos`党还是`ubuntu`党  

什么？ 没有？ 那请点击浏览器右上角的X号!

## 视频教程(强烈建议食用)
`搭配观看` 
```
链接：https://pan.baidu.com/s/1ivPgtkVWK2CFaPvuZnp15g 
提取码：9h9e
```

## 宝塔安装

直接自己去看吧: [bt.cn](https://bt.cn).    
如果宝塔都不会玩我建议你放弃~

## 必装环境

接下来我们安装一下下图六个软件：    
![必装软件](https://i.loli.net/2020/04/07/hfMmUcFVWqB5JQo.png)  
最好是编译安装哦，性能更好。

## PHP环境确认 

### 一、 接下来我们按照步骤删除一下php的禁用函数    
（ps:宝塔默认会禁用一些php的函数，导致artisan命令无法正确运行）

点击【软件商店】->【PHP设置】->【禁用函数列表】 
将以下函数删除！！   
`putenv`，`proc_open`，`pcntl_signal`，`pcntl_alarm`   

![禁用函数列表.png](https://i.loli.net/2020/04/07/eusZzGJxprmTHAW.png)    

### 二、 我们再装一下必要的两个扩展    

点击【软件商店】->【PHP设置】->【安装扩展】   
安装以下三个扩展：   
`fileinfo`、`redis`、`opcache(可选安装)`  

![安装扩展.png](https://i.loli.net/2020/04/07/bytNw5zoXVeh4nA.png)   


## 新建一个网站

### 一、在宝塔里新建一个网站用于运行本项目
![新建一个网站.png](https://i.loli.net/2020/04/07/IUmzMecBGwyDEj3.png)    

### 二、上传我们的项目代码
请选择xxx_build.tar.gz压缩包  
独角数卡发行版本下载地址：[独角数卡各发行版本](https://github.com/assimon/dujiaoka/releases)    

### 三、设置项目伪静态和运行目录
解压项目代码后，我们点击网站的`设置`     
设置运行目录： 
![设置网站运行目录.png](https://i.loli.net/2020/04/07/WpmtZUl2OubkSc5.png)
设置伪静态：  
![伪静态.png](https://i.loli.net/2020/04/07/UfKW75FbYMht9S6.png)

## 编辑项目配置并导入SQL

### 一、进入网站根目录，将`.env.example`重命名为 `.env`

### 二、编辑`.env`文件设置数据库连接信息   
```
# 数据库配置
DB_CONNECTION=mysql
DB_HOST=数据库地址
DB_PORT=数据库端口
DB_DATABASE=数据库
DB_USERNAME=数据库登录用户
DB_PASSWORD=数据库密码
```
其他一些`项目的名称`，`发信服务`也可以一并修改！  
不认识的、不知道干什么的配置不要瞎改！！    

### 三、导入sql文件

进入服务器终端，`cd 到你的项目根目录`，执行以下命令导入sql:
```
/www/server/php/72/bin/php artisan dujiao install
```
(我这里是php7.2，目录就是php72,根据自己实际来)   
执行完成以后你就可以访问一下你的域名，看网站是否能跟正常访问！

## 配置Supervisor
Supervisor是我们用来管理laravel队列进程的工具。      
没有它的话你的程序执行会异常！！！   

进入宝塔控制面板：
步骤：【软件商店】->【Supervisor设置】->【添加守护进程】 
如图： 
![supervisor配置.png](https://i.loli.net/2020/04/07/sf3JctX1b7BNWUT.png)  

名称：随意，如dujiao   
启动用户: 选择www  
运行目录: 一般选网站根目录   
启动文件: /www/server/php/你php版本/bin/php (我这里是php7.2，目录就是php72,根据自己实际来)    
启动参数: 网站根目录 + `/artisan queue:work` 

保存即可!   

## 教程结束
