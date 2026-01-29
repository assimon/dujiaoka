@extends('unicorn.layouts.default')
@section('content')
    <!-- main start -->
    <section class="main-container">
        <div class="container">
            <div class="good-card">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-12">
                        <div class="card m-3">
                            <div class="card-body p-4 text-center">
                                <h3 class="card-title text-primary">{{ __('dujiaoka.scan_qrcode_to_pay') }}</h3>
                                <h6>
                                    <small class="text-muted">{{ __('dujiaoka.payment_method') }}：[{{ $payname }}], {{ __('dujiaoka.pay_order_expiration_date_prompt', ['min' => dujiaoka_config_get('order_expire_time', 5)]) }}</small>
                                </h6>
                                <div class="err-messagep-3">
                                    <img src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(200)->generate($qr_code)) !!}" alt="{{ __('dujiaoka.scan_qrcode_to_pay') }}" srcset="">
                                </div>
                                <h6>
                                    <small class="text-warning">{{ __('dujiaoka.amount_to_be_paid') }}: {{ $actual_price }}</small>
                                </h6>
                                @if(Agent::isMobile() && isset($jump_payuri))
                                    <a href="{{ $jump_payuri }}" type="button" class="btn btn-dark">
                                        {{ __('dujiaoka.open_the_app_to_pay') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- main end -->
@stop
@section('js')
    <script>
        var getting = {
            url:'{{ url('check-order-status', ['orderSN' => $orderid]) }}',
            dataType:'json',
            success:function(res) {
                if (res.code == 400001) {
                    window.clearTimeout(timer);
                    alert("{{ __('dujiaoka.prompt.order_is_expired') }}")
                    setTimeout("window.location.href ='/'",3000);
                }
                if (res.code == 200) {
                    window.clearTimeout(timer);
                    alert("{{ __('dujiaoka.prompt.payment_successful') }}")
                    setTimeout("window.location.href ='{{ url('detail-order-sn', ['orderSN' => $orderid]) }}'",3000);
                }
            }
        };
        var timer = window.setInterval(function(){$.ajax(getting)},5000);
    </script>

@stop
