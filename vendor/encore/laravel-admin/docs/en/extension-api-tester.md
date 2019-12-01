# Laravel API tester

`api-tester` is an API testing tool developed for `laravel` that helps you test your laravel API like `postman`.

![wx20170809-164424](https://user-images.githubusercontent.com/1479100/29112946-1e32971c-7d22-11e7-8cc0-5b7ad25d084e.png)

## Installation

```shell
$ composer require laravel-admin-ext/api-tester -vvv

$ php artisan vendor:publish --tag=api-tester

```
And then run the following command to import menus and permissions (which can also be added manually)

```shell
$ php artisan admin:import api-tester
```

Then you can find the entry link in the admin menu, `http://localhost/admin/api-tester`.

## Usage

Open `routes/api.php` try to add an api:

```php
Route::get('test', function () {
    return 'hello world';
});
```

Open the `api-tester` page, you can see `api/test` on the left, select it and click the `Send` button to send request to the api

### Login as

`Login as` Fill in the user id you want to log in, you can log in as the user to request the API, add the following API:

```php
use Illuminate\Http\Request;

Route::middleware('auth:api')->get('user', function (Request $request) {
    return $request->user();
});
```
Fill in the user ID in `Login as` input , then request the api and will respond with the user's model

### Parameters

Used to set the request parameters for api , the type can be a string or file, add the following API:

```php
use Illuminate\Http\Request;

Route::get('parameters', function (Request $request) {
    return $request->all();
});
```

Fill in the parameters send request and you can see the results