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

Route::get('/', function () {
    return '欢迎使用珊瑚数卡系统！www.shanhusk.com';
});
Route::group(['prefix'=>'api','namespace' => 'Api'],function(){
    Route::get('getClassifyAll', 'IndexController@getClassifyAll');
    Route::get('getSysInfo', 'IndexController@getSysInfo');
    Route::get('getCommodityAllByClassId/{cid}/{p?}', 'IndexController@getCommodityAllByClassId');
    Route::get('getCommodityInfoByClassId/{cid}', 'IndexController@getCommodityInfoByClassId');
    Route::post('postOrders', 'IndexController@postOrders');
    Route::any('searchOrder', 'IndexController@searchOrder');
    Route::get('getOrderStatus/{oid}', 'IndexController@getOrderStatus');
});


// 支付相关
Route::group(['prefix'=>'pay','namespace' => 'Pay'],function(){
    // 支付宝
    Route::get('alipay/{id}/{oid}/{pay_check}','AlipayController@gateway');
    Route::post('alipay/notify_url','AlipayController@notifyUrl');
    // 微信
    Route::get('wepay/{id}/{oid}/{pay_check}','WepayController@gateway');
    Route::post('wepay/notify_url','WepayController@notifyUrl');
    // 码支付
    Route::get('mapay/{id}/{oid}/{pay_check}','MapayController@gateway');
    Route::post('mapay/notify_url','MapayController@notifyUrl');
});

