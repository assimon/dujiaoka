# 珊瑚发卡 - 安装教程

------

请仔细阅读安装说明教程，大部分问题都是因为没有仔细阅读安装教程导致系统无法正常运行。无论什么时候当你使用一件产品的时候请先阅读它的”说明书“  
本教程基于[宝塔服务器管理软件Linux](https://www.bt.cn/)，如果你具有一定的运维经验，可参考本教程搭建自己的运行环境。

## 前言.

开发架构: vue + laravel-admin
laravel内核版本：5.5+
开发初衷：自上代`云尚发卡`维护期过后，由于内核的古老即框架的安全问题被迫放弃。新版`珊瑚发卡`采用全新的`laralvel`框架开发，程序安全性及健壮性更好。能为用户资产提供更好的保障！    
`珊瑚发卡`专注于搭建用户自己的卡密一站式自动发货体系。  

预览demo: [demo网站][3]

官方网站：[珊瑚发卡官网][1]

交流QQ群：568679748 （为防止部分灌水及广告加入，已设置5元入群费用）

视频教程：[https://share.weiyun.com/5YsenZt][2]

鸣谢：`Laravel`、`Laravel-admin`等优秀开源项目

## 一 环境准备篇
- [x] 一台linux内核的vps或云服务器（不支持windows及虚拟主机）
- [x] php版本 > 7.0(推荐使用7.2)
- [x] Mysql版本 5.7
- [x] Redis5.0+
- [x] nginx 1.16或以上
- [x] Supervisor进程管理



------

## 二 环境安装

当完成第一步所有软件时，我们还需要对一些软件进行配置。

1. 安装php的fileinfo扩展


2. 删除部分禁用函数（本发卡基于laravel内核开发，一些函数禁用会导致定时任务无法正常启动！）
需要删除的函数：putenv，proc_open，symlink


------

## 三 软件安装篇

1. 新建一个网站

2. 上传程序至网站根目录并解压

3. 点击网站设置，配置文件
规则为：

```
index index.html index.php;
set $fe_root_path '/var/www/shanhufree/public/dist';
set $rd_root_path '/var/www/shanhufree/public';
root $fe_root_path;
 location /vendor/ {
        root  $rd_root_path;
    }
      location /storage/ {
        root  $rd_root_path;
    }
    location ~ \.php$ {
	  root          $rd_root_path;
       try_files    $uri =404;
       fastcgi_index  /index.php;
       fastcgi_pass   unix:/tmp/php-cgi-72.sock;
       include fastcgi_params;
       fastcgi_split_path_info       ^(.+\.php)(/.+)$;
       fastcgi_param PATH_INFO       $fastcgi_path_info;
       fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
       fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
```


`$fe_root_path` 和 `$rd_root_path` 这两个变量里面的目录`请按照自己的实际网站根目录填写`，不要照抄我的示例，`不改成你自己的目录是运行不起来的！`    


## 其他：

后台登录地址：/shmanage  默认账号密码都是:admin

队列监听命令：`/artisan queue:work --queue=emails,orderclean`

软连接创建命令：` sudo -u www php artisan storage:link`

队列重启命令：` sudo -u www php artisan queue:restart`

调试完成后请将根目录.env文件里面`APP_DEBUG=true`改为`APP_DEBUG=false`   

LOGO图片及前端静态资源在根目录：`public/dist/static`

## 声明：

本程序仅做免费交流使用，任何人用于任何违法国家法律法规的用途均与项目作者无关！


  [1]: http://www.shanhufk.com
  [2]: https://share.weiyun.com/5YsenZt
  [3]: https://free.shanhufk.com