@extends('layui.layouts.default')
@section('content')

    <div class="layui-row">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">

            <div class="layui-card cardcon">
                <div class="layui-card-header">{{ __('system.scan_code_to_pay') }}</div>

                <div class="layui-card-body">
                    <div class="product-info">
                        <p style="color: #1E9FFF;font-size: 20px;font-weight: 500; text-align: center" >{{ __('system.payment_method') }}：[{{ $payname }}], {{ __('system.order_expiration_date') }}{{ config('app.order_expire_date') }}{{ __('system.expiration_date') }}</p>
                    </div>
                    <div style="text-align: center; width: 100%; border: #1E9FFF solid 1px;">
                    <p class="product-pay-price">{{ __('system.actual_payment') }}: {{ $actual_price }}</p>
                    <img  src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(200)->generate($qr_code)) !!}">
                    </div>
                    @if(Agent::isMobile() && isset($jump_payuri))
                        <p class="errpanl" style="text-align: center"><a href="{{ $jump_payuri }}" class="layui-btn layui-btn-warm layui-btn-sm">{{ __('system.open_app_to_pay') }}</a></p>
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
                url:'{{ url('/getOrderStatus', ['oid' => $orderid]) }}',
                dataType:'json',
                success:function(res) {
                    if (res.code == 400001) {
                        window.clearTimeout(timer);
                        layer.alert("{{ __('prompt.order_pay_timeout') }}", {
                            icon: 2
                        }, function(){
                            window.location.href = '/'
                        });

                    }
                    if (res.code == 200) {
                        window.clearTimeout(timer);
                        layer.alert("{{ __('prompt.payment_successful') }}", {
                            icon: 1,
                            closeBtn:0
                        }, function(){
                            window.location.href = "{{ url('searchOrderById', ['order_id' => $orderid]) }}"
                        });
                    }
                }

            };
            var timer = window.setInterval(function(){$.ajax(getting)},5000);
        })

    </script>
@stop
