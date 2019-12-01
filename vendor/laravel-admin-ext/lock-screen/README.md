Lock screen
======

Add a lock screen page to laravel-admin.

## Screenshots

![wx20181114-232541](https://user-images.githubusercontent.com/1479100/48492459-c720f680-e864-11e8-934a-932d287479c4.png)

## Installation & Configuration

```bash
composer require laravel-admin-ext/lock-screen
```

Then add a middleware `admin.lock` to routes configuration in `config/admin.php`

```php

    'route' => [

        'prefix' => 'demo',

        'namespace'     => 'App\\Admin\\Controllers',

        // add middleware `admin.lock` into this array.
        'middleware'    => ['web', 'admin', 'admin.lock'],
    ],

```

## Usage

After installation and configuration, open the admin page, you will find a link in the upper right corner of the page with a lock icon, click it to redirect to the lock screen page,
You need to enter your login password to return to unlock the page.

## Donate

如果觉得这个项目帮你节约了时间，不妨支持一下;)

![-1](https://cloud.githubusercontent.com/assets/1479100/23287423/45c68202-fa78-11e6-8125-3e365101a313.jpg)

License
------------
Licensed under [The MIT License (MIT)](LICENSE).
