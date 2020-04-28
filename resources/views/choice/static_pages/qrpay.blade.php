@extends('choice.layouts.default')
@section('content')

    <div class="layui-row">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">

            <div class="layui-card cardcon">
                <div class="layui-card-header">扫码支付</div>

                <div class="layui-card-body">
                    <div class="product-info">
                        <p style="color: #1E9FFF;font-size: 20px;font-weight: 500; text-align: center" >支付方式：[{{ $payname }}], 请打开APP扫码支付！有效期{{ config('app.order_expire_date') }}分钟</p>
                    </div>
                    <div style="text-align: center; width: 100%; border: #1E9FFF solid 1px;">
                    <p class="product-pay-price">支付金额: {{ $actual_price }}</p>
                    <img  src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(200)->generate($qr_code)) !!}">
                    </div>
                    @if(Agent::isMobile() && strstr($jump_payuri, 'qr.alipay.com'))
                       <p class="errpanl" style="text-align: center"><a href='' id='toalipay' class="layui-btn layui-btn-warm layui-btn-sm">打开支付宝支付</a></p>
                  <script>var schemeurl = 'alipays://platformapi/startapp?appId=20000067&url='+encodeURIComponent('{{ $jump_payuri }}');
                document.getElementById("toalipay").href=schemeurl;</script>
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
                        layer.alert('订单已超时，为您返回首页', {
                            icon: 2
                        }, function(){
                            window.location.href = '/'
                        });

                    }
                    if (res.code == 200) {
                        window.clearTimeout(timer);
                        layer.alert('支付成功', {
                            icon: 1
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
