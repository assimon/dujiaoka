<?php

Route::group(['middleware' => ['switch.language'], 'namespace' => 'Home'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('buy/{product}', 'HomeController@buy');
    Route::get('bill/{orderid}', 'OrderController@bill');
    Route::post('postOrder', 'OrderController@createOrder');
    Route::get('getOrderStatus/{orderid}', 'OrderController@getOrderStatus');
    Route::get('searchOrder', 'OrderController@searchOrder');
    Route::match(['get', 'post'], 'searchOrderById/{oid?}', 'OrderController@searchOrderById');
    Route::post('searchOrderByAccount', 'OrderController@searchOrderByAccount');
    Route::get('searchOrderByBrowser', 'OrderController@searchOrderByBrowser');
});
