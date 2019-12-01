# Configuration management

This tool will store the configuration data in the database

![wx20170810-100226](https://user-images.githubusercontent.com/1479100/29151322-0879681a-7db3-11e7-8005-03310686c884.png)

## Installation

```
$ composer require laravel-admin-ext/config

$ php artisan migrate
```

Open `app/Providers/AppServiceProvider.php`, and call the `Config::load()` method within the `boot` method:

```php
<?php

namespace App\Providers;

use Encore\Admin\Config\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Config::load();  // Add this
    }
}
```

Then run the command to import menus and permissions (which can also be added manually)

```
$ php artisan admin:import config
```

Open `http://localhost/admin/config`.

## Usage

After add config in the panel, use `config($key)` to get value you configured.