# 文件管理

文件管理是一个对本地文件的可视化管理的工具

![wx20170809-170104](https://user-images.githubusercontent.com/1479100/29113762-99886c32-7d24-11e7-922d-5981a5849c7a.png)

## 安装

```
$ composer require laravel-admin-ext/media-manager -vvv

$ php artisan admin:import media-manager
```

## 配置

打开`config/admin.php`指定你要管理的disk

```php

    'extensions' => [

        'media-manager' => [
            'disk' => 'public'   // 指向config/filesystem.php中设置的disk
        ],
    ],

```

`disk`为`config/filesystem.php`中设置的本地disk，然后打开`http://localhost/admin/media`访问.

注意如果要预览disk中的图片，必须在disk中设置访问url前缀： 


`config/filesystem.php`：
```php

    'disks' => [

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',    // 设置文件访问url
            'visibility' => 'public',
        ],
        
        ...
    ]
```

