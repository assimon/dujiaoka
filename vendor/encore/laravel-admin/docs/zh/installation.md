# 安装

> 当前版本(1.5)需要安装`PHP 7+`和`Laravel 5.5`, 如果你使用更早的版本，请参考文档: [1.4](http://laravel-admin.org/docs/v1.4/#/zh/) 

首先确保安装好了`laravel`，并且数据库连接设置正确。

```
composer require encore/laravel-admin "1.5.*"
```

然后运行下面的命令来发布资源：

```
php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
```

在该命令会生成配置文件`config/admin.php`，可以在里面修改安装的地址、数据库连接、以及表名，建议都是用默认配置不修改。

然后运行下面的命令完成安装：
```
php artisan admin:install
```

启动服务后，在浏览器打开 `http://localhost/admin/` ,使用用户名 `admin` 和密码 `admin`登陆.

## 生成的文件

安装完成之后,会在项目目录中生成以下的文件:

### 配置文件

安装完成之后，`laravel-admin`所有的配置都在`config/admin.php`文件中。

### 后台项目文件
安装完成之后，后台的安装目录为`app/Admin`，之后大部分的后台开发编码工作都是在这个目录下进行。

```
app/Admin
├── Controllers
│   ├── ExampleController.php
│   └── HomeController.php
├── bootstrap.php
└── routes.php
```

`app/Admin/routes.php`文件用来配置后台路由。

`app/Admin/bootstrap.php` 是`laravel-admin`的启动文件, 使用方法请参考文件里面的注释.

`app/Admin/Controllers`目录用来存放后台控制器文件，该目录下的`HomeController.php`文件是后台首页的显示控制器，`ExampleController.php`为实例文件。

### 静态文件

后台所需的前端静态文件在`/public/vendor/laravel-admin`目录下.