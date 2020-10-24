<?php
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
    // paypal
    Route::get('paypal/{payway}/{oid}','PaypalPayController@gateway');
    Route::get('paypal/return_url','PaypalPayController@returnUrl');
    Route::post('paypal/notify_url','PaypalPayController@notifyUrl');
    // Mugglepay
    Route::get('mugglepay/{payway}/{oid}','MugglepayController@gateway');
    Route::post('mugglepay/notify_url','MugglepayController@notifyUrl');
    // V免签
    Route::get('vpay/{payway}/{oid}','VpayController@gateway');
    Route::get('vpay/notify_url','VpayController@notifyUrl');
    Route::get('vpay/return_url','VpayController@returnUrl');
});
