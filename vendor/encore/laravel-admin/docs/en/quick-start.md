# Quick start

We use `users` table come with `Laravel` for example,the structure of table is:
```sql
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
```
And the model for this table is `App\User.php`

You can follow these steps to setup `CRUD` interfaces of table `users`:

## Add controller

Use the following command to create a controller for `App\User` model

```php
php artisan admin:make UserController --model=App\\User

// under windows use:
php artisan admin:make UserController --model=App\User
```
The above command will create the controller in `app/Admin/Controllers/UserController.php`.

## Add route

Add a route in `app/Admin/routes.php`：
```
$router->resource('demo/users', UserController::class);
```

## Add left menu item

Open `http://localhost:8000/admin/auth/menu`, add menu link and refresh the page, then you can find a link item in left menu bar.

> Where `uri` fills in the path part that does not contain the prefix of the route, such as the full path `http://localhost:8000/admin/demo/users`, just input `demo/users`, If you want to add an external link, just fill in the full url, such as `http://laravel-admin.org/`.

### Menu translations

append menu titles in menu_titles index at your language files.
For example 'Work Units' title:

in resources/lang/es/admin.php
```php
...
// lowercase and replace spaces with _
'menu_titles' => [
    'work_units' => 'Unidades de trabajo'
],
```

## Build grid and form

The rest needs to be done is open `app/Admin/Contollers/UserController.php`, find `form()` and `grid()` method and write few lines of code with `model-grid` and `model-form`,for more detail, please read [model-grid](/en/model-grid.md) and [model-form](/en/model-form.md).
