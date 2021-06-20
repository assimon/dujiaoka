@extends('layui.layouts.default')
@section('content')

    <div class="layui-row">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">

            <div class="layui-card cardcon">
                <div class="layui-card-header">{{ __('dujiaoka.scan_qrcode_to_pay') }}</div>

                <div class="layui-card-body">
                    <div class="product-info">
                        <p style="color: #1E9FFF;font-size: 20px;font-weight: 500; text-align: center" >{{ __('dujiaoka.payment_method') }}：[{{ $payname }}], {{ __('dujiaoka.pay_order_expiration_date_prompt', ['min' => dujiaoka_config_get('order_expire_time', 5)]) }}</p>
                    </div>
                    <div style="text-align: center; width: 100%;">
                    <p class="product-pay-price">{{ __('dujiaoka.amount_to_be_paid') }}: {{ $actual_price }}</p>
                    <img  src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(200)->generate($qr_code)) !!}">
                    </div>
                    @if(Agent::isMobile() && isset($jump_payuri))
                        <p class="errpanl" style="text-align: center"><a href="{{ $jump_payuri }}" class="layui-btn layui-btn-warm layui-btn-sm">{{ __('dujiaoka.open_the_app_to_pay') }}</a></p>
                    @endif
                </div>



            </div>

        </div>
    </div>


@stop

@section('tpljs')
    <script>
        layui.use(['layer'], function(){
            var getting = {
                url:'{{ url('check-order-status', ['orderSN' => $orderid]) }}',
                dataType:'json',
                success:function(res) {
                    if (res.code == 400001) {
                        window.clearTimeout(timer);
                        layer.alert("{{ __('dujiaoka.prompt.order_is_expired') }}", {
                            icon: 2
                        }, function(){
                            window.location.href = '/'
                        });
                    }
                    if (res.code == 200) {
                        window.clearTimeout(timer);
                        layer.alert("{{ __('dujiaoka.prompt.payment_successful') }}", {
                            icon: 1,
                            closeBtn:0
                        }, function(){
                            window.location.href = "{{ url('detail-order-sn', ['orderSN' => $orderid]) }}"
                        });
                    }
                }

            };
            var timer = window.setInterval(function(){$.ajax(getting)},5000);
        })

    </script>
@stop
