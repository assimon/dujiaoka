## 写在前面

- 此教程专为有洁癖的宝宝们准备。不使用任何一键安装脚本。面板党可以退散了！！
- 本人测试环境是 Debian 11 其他的没测试。
## 手动安装lnmp
- 更新源

```bash  
apt update  
apt upgrade
``` 

- 安装Nginx
```bash
apt install nginx
```
- 安装Mariadb
```bash
apt install mariadb-server
```
- 配置Mariadb
```bash
mysql_secure_installation
```
根据提示操作即可。
- 创建数据库
```bash
mariadb
```
之后会显示
```bash
Welcome to the MariaDB monitor.  Commands end with ; or \g.
Your MariaDB connection id is 74
Server version: 10.3.15-MariaDB-1 Debian 10
Copyright (c) 2000, 2018, Oracle, MariaDB Corporation Ab and others.
Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.
MariaDB [(none)]> 
```
接下来输入命令 
```sql
CREATE DATABASE [这里替换为数据库名] ;
GRANT ALL ON [这里替换为数据库名].* TO '[这里替换为用户名]'@'localhost' IDENTIFIED BY '[这里替换为密码]' WITH GRANT OPTION;
FLUSH PRIVILEGES;
EXIT
```
- 安装PHP7.4
```bash
apt install php php-fpm php-mysql php-gd php-zip php-opcache php-curl php-mbstring php-intl php-dom php-bcmath php-redis php-fileinfo
```
- 安装redis
```bash
apt install redis
```
- 启用函数
`nano /etc/php/7.4/fpm/php.ini`,`ctrl+w` 搜索 `putenv`，`proc_open`，`pcntl_signal`，`pcntl_alarm` 在`disable_functions` 一行 有就去掉。
之后 `/etc/init.d/php7.4-fpm reload` 

## 下载源代码
```bash
cd /var/www/dujiaoka
apt install git
git clone https://github.com/assimon/dujiaoka.git 
chmod 777 -R /var/www/dujiaoka
```
## 配置 nginx
- 假设你的域名是：`domain.com`
- 假设你的网站目录是：`/home/wwwroot/dujiaoka`
- 配置文件的存放目录是：`/usr/local/nginx/conf/vhost`
- 按下文教程配置时，注意修改演示配置中的域名和目录

```bash
nano /etc/nginx/sites-enabled/dujiaoka 
```
你可以参考我的配置文件
```bash
server
    {
        listen 80;
	listen [::]:80;
        server_name domain.com ;
        return 301 https://$server_name$request_uri;
    }

server
    {
        listen 443 ssl http2;
	listen [::]:443 ssl http2;
        server_name domain.com ;
        index index.html index.htm index.php default.html default.htm default.php;
        root  /var/www/dujiaoka/public;
        ssl_certificate /etc/nginx/sslcert/cert.crt;
        ssl_certificate_key /etc/nginx/sslcert/key.key;
        # openssl dhparam -out /usr/local/nginx/conf/ssl/dhparam.pem 2048
        #ssl_dhparam /usr/local/nginx/conf/ssl/dhparam.pem;

        location / {
    try_files $uri $uri/ /index.php?$query_string;
}
        #error_page   404   /404.html;

        # Deny access to PHP files in specific directory
        #location ~ /(wp-content|uploads|wp-includes|images)/.*\.php$ { deny all; }

        location ~ [^/]\.php(/|$)
        {
          
            fastcgi_pass  unix:/var/run/php/php7.4-fpm.sock;
           
            include snippets/fastcgi-php.conf;
        }


        location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$
        {
            expires      30d;
        }

        location ~ .*\.(js|css)?$
        {
            expires      12h;
        }

        location ~ /.well-known {
            allow all;
        }

        location ~ /\.
        {
            deny all;
        }

        access_log off;
    }

```
在 `/etc/nginx/sslcert/` 上传你的https证书 之后 `nginx -t` 没有报错就重启nginx `/etc/init.d/nginx restart`

## composer 安装
```bash
cd /var/www/dujiaoka
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
mv composer.phar /usr/local/bin/composer
adduser user
su user
composer install
composer update
su
```
## 访问安装页面
访问你的域名，进行安装
- MySQL 数据库名：`dujiaoka`
- MySQl 密码：`你设置的密码`
- Redis 密码：`无需填写`
- 网站URL：你的域名，如 `https://domain.com`

##编辑配置文件

编辑 `/var/www/dujiaoka/.env`
- 将 `APP_DEBUG=true` 改为 `APP_DEBUG=false`
- 另起一行，添加 `ADMIN_HTTPS=true`
- 尝试登入后台。如果提示 `0 error` ，刷新页面即可

## 配置 Supervisor
先安装
```bash
apt install supervisor
```
创建配置文件
```bash
nano /etc/supervisor/conf.d/dujiaoka.conf
```
写入配置文件

- 注意修改网站目录
```bash
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/wwwroot/dujiaoka/artisan queue:work
autostart=true
autorestart=true
user=www
numprocs=1
redirect_stderr=true
stdout_logfile=/home/wwwlogs/worker.log
```
启动
```bash
supervisorctl reread
supervisorctl update
supervisorctl start laravel-worker:*
```
## 参考来源
https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mariadb-php-lemp-stack-on-debian-10
https://github.com/assimon/dujiaoka/wiki/2.x_linux_install
