# 配置管理

这个工具将配置数据存在数据库中，然后在能在Laravel中能像普通配置一样使用

![wx20170810-100226](https://user-images.githubusercontent.com/1479100/29151322-0879681a-7db3-11e7-8005-03310686c884.png)

## 安装

```
$ composer require laravel-admin-ext/config

$ php artisan migrate
```

打开`app/Providers/AppServiceProvider.php`, 在`boot`方法中添加`Config::load();`:

```php
<?php

namespace App\Providers;

use Encore\Admin\Config\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Config::load();  // 加上这一行
    }
}
```

最后运行命令导入菜单和权限（也可以手动添加）

```
$ php artisan admin:import config
```

然后打开`http://localhost/admin/config`访问.

## 使用

打开`http://localhost/admin/config`，添加一项配置，填写`Name`、`Value`、和`Description`, `Name`是配置的`key`,`Description`是选填的配置注释

最后在程序中使用`config($key)`来获取配置，注意，配置的`Name`不要和`config`目录中的已存在的配置冲突，不然会覆盖掉系统的配置

