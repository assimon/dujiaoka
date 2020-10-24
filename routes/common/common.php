<?php

Route::group(['middleware' => ['switch.language'], 'namespace' => 'Home'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('buy/{product}', 'HomeController@buy');
    Route::get('bill/{orderid}', 'OrderController@bill');
    Route::post('postOrder', 'OrderController@createOrder');
    Route::get('getOrderStatus/{orderid}', 'OrdersController@getOrderStatus');
    Route::get('searchOrder', 'OrdersController@searchOrder');
    Route::match(['get', 'post'], 'searchOrderById/{oid?}', 'OrdersController@searchOrderById');
    Route::post('searchOrderByAccount', 'OrdersController@searchOrderByAccount');
    Route::get('searchOrderByBrowser', 'OrdersController@searchOrderByBrowser');
});
