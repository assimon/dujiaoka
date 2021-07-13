@extends('hyper.layouts.default')
@section('content')
<div class="row">
    <div class="col-12 offset-md-3">
        <div class="page-title-box">
            {{-- 扫码支付 --}}
            <h4 class="page-title">{{ __('hyper.qrpay_title') }}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card border-primary border">
            <div class="card-body">
                <h5 class="card-title text-primary text-center">{{ __('hyper.qrpay_order_expiration_date') }} {{ dujiaoka_config_get('order_expire_time', 5) }} {{ __('hyper.qrpay_expiration_date') }}</h5>
                <div class="text-center">
                    <img src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(200)->generate($qr_code)) !!}">
                </div>
                {{-- 订单金额 --}}
                <p class="card-text text-center">{{ __('hyper.qrpay_actual_payment') }}: {{ $actual_price }}</p>
                @if(Agent::isMobile() && isset($jump_payuri))
                    <p class="errpanl" style="text-align: center"><a href="{{ $jump_payuri }}" class="">{{ __('hyper.qrpay_open_app_to_pay') }}</a></p>
                @endif
            </div> <!-- end card-body-->
        </div>
    </div>
</div>


@stop

@section('tpljs')
    <script>
        var getting = {
            url:'{{ url('check-order-status', ['orderSN' => $orderid]) }}',
            dataType:'json',
            success:function(res) {
                if (res.code == 400001) {
                    window.clearTimeout(timer);
                    $.NotificationApp.send("{{ __('hyper.qrpay_notice') }}","{{ __('hyper.order_pay_timeout') }}","bottom-right","rgba(0,0,0,0.2)","warning");
                    setTimeout("window.location.href ='/'",3000);
                }
                if (res.code == 200) {
                    window.clearTimeout(timer);
                    $.NotificationApp.send("{{ __('hyper.qrpay_notice') }}","{{ __('hyper.payment_successful') }}","bottom-right","rgba(0,0,0,0.2)","success");
                    setTimeout("window.location.href ='{{ url('detail-order-sn', ['orderSN' => $orderid]) }}'",3000);
                }
            }
        };
        var timer = window.setInterval(function(){$.ajax(getting)},5000);
    </script>
@stop
