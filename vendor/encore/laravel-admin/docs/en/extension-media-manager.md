# Media manager

This tool for manage local files

![wx20170809-170104](https://user-images.githubusercontent.com/1479100/29113762-99886c32-7d24-11e7-922d-5981a5849c7a.png)

## Installation

```
$ composer require laravel-admin-ext/media-manager -vvv

$ php artisan admin:import media-manager
```

## Configuration

Open  `config/admin.php` specify the disk you want to manage

```php

    'extensions' => [

        'media-manager' => [
            'disk' => 'public'   // Points to the disk set in config/filesystem.php
        ],
    ],

```

`disk` is the local disk you configured in `config/filesystem.php`, visit by access `http://localhost/admin/media`.

Note If you want to preview the picture in the disk, you must set the access url in the disk configuration:


`config/filesystem.php`：
```php

    'disks' => [

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',    // set url
            'visibility' => 'public',
        ],
        
        ...
    ]
```

