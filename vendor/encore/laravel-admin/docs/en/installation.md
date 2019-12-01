# Installation

> This package requires PHP 7+ and Laravel 5.5, for old versions please refer to [1.4](http://laravel-admin.org/docs/v1.4/#/)

First, install laravel, and make sure that the database connection settings are correct.

Then install require this package with command:
```
composer require encore/laravel-admin "1.5.*"
```

Publish assets and config with command：
```
php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
```

After runnung previous command you can find config file in `config/admin.php`, in this file you can change default install directory (```/app/Admin```), db connection or table names.

At last run following command to finish install:
```
php artisan admin:install
```

To check that all is working, run `php artisan serve` and open `http://localhost/admin/` in browser, use username `admin` and password `admin` to login.

## Generated files

After the installation is complete, the following files are generated in the project directory:

### Configuration file

After the installation is complete, all configurations are in the `config/admin.php` file.

### Admin files

After install,you can find directory`app/Admin`,and then most of our develop work is under this directory.

```
app/Admin
├── Controllers
│   ├── ExampleController.php
│   └── HomeController.php
├── bootstrap.php
└── routes.php
```

`app/Admin/routes.php` is used to define routes.

`app/Admin/bootstrap.php` is bootstrapper for laravel-admin, for usage examples see comments inside it.

The `app/Admin/Controllers` directory is used to store all the controllers.
The `HomeController.php` file under this directory is used to handle home request of admin.
The `ExampleController.php` file is a controller example.

### Static assets

The front-end static files are in the `/public/packages/admin` directory.
