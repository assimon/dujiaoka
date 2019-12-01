<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resource('classify', ClassifyController::class);
    $router->resource('commodity', CommodityController::class);
    $router->resource('cardlist', CardListController::class);
    $router->resource('orders', OrdersController::class);
    $router->resource('payconfig', PayconfigController::class);
    $router->resource('orderstatistics', OrderStatisticsController::class);
    $router->resource('emailtpl', EmailtplControoler::class);
    $router->get('importcard', 'CardListController@importcard');
    $router->post('importcard', 'CardListController@importcard');

});
