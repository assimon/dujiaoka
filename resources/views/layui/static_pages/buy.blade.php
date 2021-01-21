@extends('layui.layouts.default')
@section('notice')
    @include('layui.layouts._notice')
@endsection
@section('content')

    <div class="layui-row">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">

            <div class="layui-card cardcon">
                <div class="layui-card-header">{{ __('system.place_an_order') }}</div>

                <div class="layui-card-body">
                    <div class="layui-row">
                        <div class="layui-col-md3 layui-hide-xs">
                            <div class="layui-card">
                                <div class="layui-card-body">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('admin')->url($pd_picture ?? 'images/default.jpg') }}" width="100%" height="100%">
                                </div>
                                <div class="layui-card-body">
                                    <img src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(200)->generate(Request::url())) !!}" width="100%" height="100%">
                                    <p style="text-align: center">{{ __('system.mobile_phone_purchase') }}</p>

                                </div>
                            </div>
                        </div>


                        <!-- 商品详细区 -->
                        <div class="layui-col-md8  layui-col-xs12" >
                            <div class="layui-card">
                                <div class="layui-card-header">
                                    <span style="font-size: 16px;">{{ $pd_name }}</span>
                                    @if($pd_type == 1)
                                        <span class="layui-badge layui-bg-green">{{ __('system.automatic_delivery') }}</span>
                                    @else
                                        <span class="layui-badge layui-bg-orange">{{ __('system.charge') }}</span>
                                    @endif
                                    <span class="layui-badge layui-bg-blue"> {{__('system.in_stock')}}({{ $in_stock }})</span>
                                </div>
                                <div class="layui-card-body">
                                    <form class="layui-form layui-form-pane" action="{{ url('postOrder') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="product-info">
                                            <span style="color:#6c6c6c">¥</span>
                                            <span class="product-price">{{ $actual_price }}</span>
                                            <span class="product-price-cost-price">¥{{ $cost_price }}</span>
                                        </div>

                                        @if(!empty($wholesale_price) && is_array($wholesale_price))
                                            <div class="product-info">
                                                <span style="color:#F40;font-size: 18px;font-weight: 400"><i class="layui-icon layui-icon-praise"></i> {{ __('system.wholesale_discount') }}</span>
                                                @foreach($wholesale_price as $ws)
                                                    <p class="ws-price">{{ __('system.purchase_quantity') }} {{ $ws['number'] }} {{__('system.the_above')}}{{ __('system.each') }} <span class="layui-badge layui-bg-orange">¥{{ $ws['price'] }}</span></p>
                                                @endforeach

                                            </div>

                                        @endif

                                        <div class="layui-form-item">
                                            <label class="layui-form-label">{{ __('system.email') }}</label>
                                            <div class="layui-input-block">
                                                <input type="hidden" name="pid" value="{{ $id }}">
                                                <input type="email" name="account" value="" required lay-verify="required|email" placeholder="{{ __('system.email') }}" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">{{ __('system.quantity') }}</label>
                                            <div class="layui-input-inline">
                                                <input type="number" name="order_number" required lay-verify="required|order_number" placeholder="" value="1" autocomplete="off" class="layui-input">
                                            </div>

                                        </div>
                                            @if($pd_type == 2 && is_array($other_ipu))
                                                @foreach($other_ipu as $ipu)
                                                    <div class="layui-form-item">
                                                        <label class="layui-form-label">{{ $ipu['desc'] }}</label>
                                                        <div class="layui-input-block">
                                                            <input type="text" name="{{ $ipu['field'] }}" @if($ipu['rule'] !== false) required lay-verify="required" @endif placeholder="{{ $ipu['desc'] }}" value="" autocomplete="off" class="layui-input">
                                                        </div>
                                                    </div>
                                                @endforeach

                                            @endif

                                        <div class="layui-form-item">
                                            <label class="layui-form-label">{{ __('system.payment_method') }}</label>
                                            <div class="layui-input-block">
                                                @foreach($payways as $way)
                                                <input type="radio"  lay-verify="payway" name="payway" value="{{ $way['id'] }}" title="{{ $way['pay_name'] }}">
                                                @endforeach
                                            </div>
                                        </div>
                                        @if(config('webset.isopen_searchpwd') == 1)
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">{{ __('system.search_password') }}</label>
                                            <div class="layui-input-block">
                                                <input type="password" name="search_pwd" value="" required lay-verify="required" placeholder="{{ __('prompt.set_search_password') }}" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                        @endif
                                        @if(config('webset.verify_code') == 1)
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">{{ __('system.verify_code') }}</label>
                                            <div class="layui-input-inline">
                                                <input type="text" name="verify_img" value="" required lay-verify="required" placeholder="{{ __('system.verify_code') }}" autocomplete="off" class="layui-input">
                                            </div>
                                            <div class="buy-captcha">
                                                <img class="captcha-img" src="{{ captcha_src('buy') }}" onclick="refresh()">
                                            </div>
                                            <script>
                                                function refresh(){
                                                    $('img[class="captcha-img"]').attr('src','{{ captcha_src('buy') }}'+Math.random());
                                                }
                                            </script>
                                        </div>
                                        @endif
                                        @if(config('app.shgeetest'))
                                        <div class="layui-form-item" style="position: relative;">
                                            <label for="L_vercode" class="layui-form-label">{{ __('system.behavior_verification') }}</label>
                                            <div class="layui-input-inline">
                                                <input type="text" style="cursor:pointer" readonly=""
                                                       class="layui-input" id="GeetestCaptcha"
                                                       placeholder="{{ __('system.click_to_behavior_verification') }}">
                                            </div>
                                        </div>
                                        <div class="layui-hide">{!! Geetest::render('popup') !!}</div>
                                        <script>$('#GeetestCaptcha').click(function () {
                                                $('.geetest_radar_btn').click();
                                            })</script>
                                        @endif
                                        @if($isopen_coupon == 1)
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">{{ __('system.promo_code') }}</label>
                                            <div class="layui-input-block">
                                                <input type="text" name="coupon_code" placeholder="{{ __('prompt.have_promo_code') }}" value="" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                        @endif
                                        <div class="layui-form-item">
                                            <div class="layui-input-block">
                                                <button class="layui-btn" lay-submit lay-filter="postOrder">{{ __('system.order_now') }}</button>
                                                <button type="reset" class="layui-btn layui-btn-primary">{{ __('system.reset_order') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>



            </div>

        </div>
    </div>

    <div class="layui-row">

        <!-- 介绍区 -->
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-xs12" >
            <div class="layui-card cardcon">
                <div class="layui-card-header">{{ __('system.product_desciption') }}</div>
                <div class="layui-card-body">
                    <div class="product-content">
                        {!! $pd_info !!}
                    </div>

                </div>
            </div>
        </div>

    </div>
@stop

@section('tpljs')
    <script>
        var instock = {{ $in_stock }}
        layui.use(['form', 'layer'], function(){
            var form = layui.form;
            var layer = layui.layer //获得layer模块
            form.verify({
                order_number: function (value, item) {
                    if (value == 0) return "{{ __('prompt.purchase_quantity_not_null') }}"
                    if (value > instock) return "{{ __('prompt.inventory_shortage') }}"
                },
            })
            form.on('submit(postOrder)', function(data){
                if (data.field.payway == null) {
                    layer.alert("{{ __('prompt.please_select_mode_of_payment') }}", {
                        icon: 2
                    })
                    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
                }
                return true;
            });
            @if(!empty($buy_prompt))
            layer.open({
                type: 1,
                shade: false,
                skin: 'layui-layer-lan', //加上边框
                area: ['60%', '50%'], //宽高
                title: "{{ __('prompt.purchase_tips') }}",
                content: '<div class="buy-prompt">{!! $buy_prompt !!}<div>'
            });
            @endif

        });


    </script>
    @stop
