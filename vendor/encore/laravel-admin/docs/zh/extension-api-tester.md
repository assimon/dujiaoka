# Laravel API测试

`api-tester`是专门针对`laravel`开发的API测试工具，能够帮助你像`postman`一样测试你的laravel API。

![wx20170809-164424](https://user-images.githubusercontent.com/1479100/29112946-1e32971c-7d22-11e7-8cc0-5b7ad25d084e.png)

## 安装

```shell
$ composer require laravel-admin-ext/api-tester -vvv

$ php artisan vendor:publish --tag=api-tester

```
然后运行下面的命令导入菜单和权限（也可以手动添加）

```shell
$ php artisan admin:import api-tester
```

然后就能在后台的左侧菜单找到入口链接，`http://localhost/admin/api-tester`。

## 使用

打开`routes/api.php`试着添加一个api:

```php
Route::get('test', function () {
    return 'hello world';
});
```

打开`api-tester`页面，就能在左侧看到`api/test`, 选择它然后点击右侧的`Send`，就能请求这个API，下面会输出请求结果, 

### Login as

`Login as`填写你要登陆的用户的id, 就可以以这个用户的身份登陆来请求API，加入下面的API：

```php
use Illuminate\Http\Request;

Route::middleware('auth:api')->get('user', function (Request $request) {
    return $request->user();
});
```
`Login as`填写用户ID，请求接口后就能返回这个用户的模型

### Parameters

用来填写接口的请求参数，类型可以是字符串或者文件, 添加下面的API：

```php
use Illuminate\Http\Request;

Route::get('parameters', function (Request $request) {
    return $request->all();
});
```

然后填写参数可以看到效果