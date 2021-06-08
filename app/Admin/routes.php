<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resource('goods', 'GoodsController');
    $router->resource('goods-group', 'GoodsGroupController');
    $router->resource('carmis', 'CarmisController');
    $router->resource('coupon', 'CouponController');
    $router->resource('emailtpl', 'EmailtplController');
    $router->resource('pay', 'PayController');
    $router->resource('order', 'OrderController');
    $router->get('import-carmis', 'CarmisController@importCarmis');
    $router->get('system-setting', 'SystemSettingController@systemSetting');
});
