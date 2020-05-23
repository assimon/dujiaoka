<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('classifys', ClassifysController::class);
    $router->resource('products', ProductsController::class);
    $router->resource('orders', OrdersController::class);
    $router->resource('coupons', CouponsController::class);
    $router->resource('pays', PaysController::class);
    $router->resource('emailtpls', EmailtplsController::class);
    $router->resource('cards', CardsController::class);
    $router->get('setting', 'SettingController@setting');
    $router->resource('pages', PagesController::class);
    $router->get('createcoupons', 'CouponsController@createCoupons');
    $router->get('importcards', 'CardsController@importCards');
});
