## 前景概要
`正式上线后一定要将.env配置里面的APP_DEBUG设置为false`   
`正式上线后一定要将.env配置里面的APP_DEBUG设置为false`   
`正式上线后一定要将.env配置里面的APP_DEBUG设置为false`   

请根据自己的linux发行版本替换命令。  
本教程默认你已经掌握linux基本知识和操作。  
本教程默认你已经安装好了所有`基本环境要求`

## 下载代码

1. 下载项目代码
使用git下载：

```
yum install git

git clone https://github.com/assimon/dujiaoka.git
```

2. 如不使用git下载，也可以下载代码发行包手动上传至网站目录

发行版本下载：[https://github.com/assimon/dujiaoka/releases](https://github.com/assimon/dujiaoka/releases).

## 确认php-cli环境

在终端下执行命令：
```
php -v
```
正确返回类似以下：
```
PHP 7.3.16-1+ubuntu16.04.1+deb.sury.org+1 (cli) (built: Mar 20 2020 13:51:21) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.3.16, Copyright (c) 1998-2018 Zend Technologies
    with Zend OPcache v7.3.16-1+ubuntu16.04.1+deb.sury.org+1, Copyright (c) 1999-2018, by Zend Technologies
    with Xdebug v2.9.3, Copyright (c) 2002-2020, by Derick Rethans
```

确保你的终端环境支持`php-cli`

确保你的php环境`没有禁用`以下函数：
```
putenv
proc_open
pcntl_signal
pcntl_alarm
```
否则会导致composer或php artisan命令无法正确执行！

## 修改项目配置文件

在根目录下执行:
```
copy .env.example .env
```
修改为你自己的配置信息
```
vi .env
```
`wq`保存  

请确保`.env`里面的配置能够正确连接上mysql和redis

## 导入sql

根目录下执行：
```
php artisan dujiao install
```

## 配置Nginx伪静态
```
location / {  
	try_files $uri $uri/ /index.php$is_args$query_string;  
}  
```
设置网站运行目录为`/public`,根据自身实际目录配置
```
    root /www/wwwroot/dujiaoka/public;
```

## 配置Supervisor

参考资料：[使用 Supervisor 管理 Laravel 队列进程](https://learnku.com/laravel/t/3592/using-supervisor-to-manage-laravel-queue-processes).
