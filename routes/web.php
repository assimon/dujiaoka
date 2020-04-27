<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Route::get('buy/{product}', 'HomeController@buy');
Route::get('bill/{orderid}', 'HomeController@bill');
Route::post('postOrder', 'HomeController@postOrder');
Route::get('getOrderStatus/{orderid}', 'OrdersController@getOrderStatus');
Route::get('searchOrder', 'OrdersController@searchOrder');
Route::match(['get', 'post'], 'searchOrderById/{oid?}', 'OrdersController@searchOrderById');
Route::post('searchOrderByAccount', 'OrdersController@searchOrderByAccount');
Route::get('searchOrderByBrowser', 'OrdersController@searchOrderByBrowser');

// 支付相关
Route::group(['prefix'=>'pay','namespace' => 'Pay'],function(){
    // 支付宝
    Route::get('alipay/{payway}/{oid}','AlipayController@gateway');
    Route::post('alipay/notify_url','AlipayController@notifyUrl');
    // 微信
    Route::get('wepay/{payway}/{oid}','WepayController@gateway');
    Route::post('wepay/notify_url','WepayController@notifyUrl');
    // 码支付
    Route::get('mapay/{payway}/{oid}','MapayController@gateway');
    Route::post('mapay/notify_url','MapayController@notifyUrl');
    // Paysapi
    Route::get('paysapi/{payway}/{oid}','PaysapiController@gateway');
    Route::post('paysapi/notify_url','PaysapiController@notifyUrl');
    // payjs
    Route::get('payjs/{payway}/{oid}','PayjsController@gateway');
    Route::post('payjs/notify_url','PayjsController@notifyUrl');
    // 易支付
    Route::get('yipay/{payway}/{oid}','YipayController@gateway');
    Route::get('yipay/notify_url','YipayController@notifyUrl');
    Route::get('yipay/return_url','YipayController@returnUrl');
    // paypal
    Route::get('paypal/{payway}/{oid}','PaypalPayController@gateway');
    Route::get('paypal/return_url','PaypalPayController@returnUrl');
    Route::post('paypal/notify_url','PaypalPayController@notifyUrl');
    // Mugglepay
    Route::get('mugglepay/{payway}/{oid}','MugglepayController@gateway');
    Route::post('mugglepay/notify_url','MugglepayController@notifyUrl');
});
