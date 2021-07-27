@extends('layui.layouts.default')
@section('notice')
    @include('layui.layouts._notice')
@endsection
@section('content')

    <div class="layui-row">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">

            <div class="layui-card cardcon">
                <div class="layui-card-header">{{ __('dujiaoka.order_now') }}</div>

                <div class="layui-card-body">
                    <div class="layui-row">
                        <div class="layui-col-md3 layui-hide-xs">
                            <div class="layui-card">
                                <div class="layui-card-body">
                                    <img src="{{ picture_ulr($picture) }}" width="100%" height="100%">
                                </div>
                                <div class="layui-card-body">
                                    <img src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(200)->generate(Request::url())) !!}" width="100%" height="100%">
                                    <p style="text-align: center">{{ __('dujiaoka.share_qr') }}</p>

                                </div>
                            </div>
                        </div>
                        <!-- 商品详细区 -->
                        <div class="layui-col-md8  layui-col-xs12" >
                            <div class="layui-card">
                                <div class="layui-card-header">
                                    <span style="font-size: 16px;">{{ $gd_name }}</span>
                                    @if($type == \App\Models\Goods::AUTOMATIC_DELIVERY)
                                        <span class="layui-badge layui-bg-green">{{ __('goods.fields.automatic_delivery') }}</span>
                                    @else
                                        <span class="layui-badge layui-bg-orange">{{ __('goods.fields.manual_processing') }}</span>
                                    @endif
                                    <span class="layui-badge layui-bg-blue"> {{__('goods.fields.in_stock')}}({{ $in_stock }})</span>
                                    @if($buy_limit_num > 0)
                                    <span class="layui-badge layui-bg-red"> {{__('dujiaoka.purchase_limit')}}({{ $buy_limit_num }})</span>
                                    @endif
                                </div>
                                <div class="layui-card-body">
                                    <form class="layui-form layui-form-pane" action="{{ url('create-order') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="product-info">
                                            <span style="color:#6c6c6c">{{ __('dujiaoka.price') }}：</span>
                                            <span class="product-price">{{ __('dujiaoka.money_symbol') }} {{ $actual_price }}</span>
                                            <span class="product-price-cost-price">{{ __('dujiaoka.money_symbol') }} {{ $retail_price }}</span>
                                        </div>

                                        @if(!empty($wholesale_price_cnf) && is_array($wholesale_price_cnf))
                                            <div class="product-info">
                                                <span style="color:#F40;font-size: 18px;font-weight: 400"><i class="layui-icon layui-icon-praise"></i>{{ __('dujiaoka.wholesale_discount') }}：</span>
                                                @foreach($wholesale_price_cnf as $ws)
                                                    <p class="ws-price">{{ __('dujiaoka.by_amount') }}{{ $ws['number'] }} {{ __('dujiaoka.or_the_above') }},{{ __('dujiaoka.each') }}： <span class="layui-badge layui-bg-orange">{{ $ws['price']  }}{{ __('dujiaoka.money_symbol') }}</span></p>
                                                @endforeach

                                            </div>

                                        @endif

                                        <div class="layui-form-item">
                                            <label class="layui-form-label">{{ __('dujiaoka.email') }}</label>
                                            <div class="layui-input-block">
                                                <input type="hidden" name="gid" value="{{ $id }}">
                                                <input type="email" name="email" value=""  required lay-verify="required|email" placeholder="{{ __('dujiaoka.email') }}"  class="layui-input">
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">{{ __('dujiaoka.by_amount') }}</label>
                                            <div class="layui-input-inline">
                                                <input type="number" name="by_amount" required  lay-verify="required|by_amount" placeholder="" value="1"  class="layui-input">
                                            </div>

                                        </div>
                                            @if($type == \App\Models\Goods::MANUAL_PROCESSING && is_array($other_ipu))
                                                @foreach($other_ipu as $ipu)
                                                    <div class="layui-form-item">
                                                        <label class="layui-form-label">{{ $ipu['desc'] }}</label>
                                                        <div class="layui-input-block">
                                                            <input type="text" name="{{ $ipu['field'] }}" @if($ipu['rule'] !== false) required lay-verify="required" @endif placeholder="{{ $ipu['desc'] }}" value=""  class="layui-input">
                                                        </div>
                                                    </div>
                                                @endforeach

                                            @endif

                                        <div class="layui-form-item">
                                            <label class="layui-form-label">{{ __('dujiaoka.payment_method') }}</label>
                                            <div class="layui-input-block">
                                                @foreach($payways as $way)
                                                <input type="radio"  lay-verify="payway" name="payway" value="{{ $way['id'] }}" title="{{ $way['pay_name'] }}">
                                                @endforeach
                                            </div>
                                        </div>
                                        @if(dujiaoka_config_get('is_open_search_pwd') == \App\Models\Goods::STATUS_OPEN)
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">{{ __('dujiaoka.search_password') }}</label>
                                            <div class="layui-input-block">
                                                <input type="password" name="search_pwd" value=""  required lay-verify="required" placeholder=""  class="layui-input">
                                            </div>
                                        </div>
                                        @endif
                                        @if(dujiaoka_config_get('is_open_img_code') == \App\Models\Goods::STATUS_OPEN)
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">{{ __('dujiaoka.img_verify_code') }}</label>
                                            <div class="layui-input-inline">
                                                <input type="text" name="img_verify_code" value=""  required lay-verify="required" placeholder=""  class="layui-input">
                                            </div>
                                            <div class="buy-captcha">
                                                <img class="captcha-img"  src="{{ captcha_src('buy') . time() }}" onclick="refresh()">
                                            </div>
                                            <script>
                                                function refresh(){
                                                    $('img[class="captcha-img"]').attr('src','{{ captcha_src('buy') }}'+Math.random());
                                                }
                                            </script>
                                        </div>
                                        @endif
										@if(dujiaoka_config_get('is_open_geetest') == \App\Models\Goods::STATUS_OPEN )
                                        <div class="layui-form-item" style="position: relative;">
                                            <label for="L_vercode" class="layui-form-label">{{ __('dujiaoka.behavior_verification') }}</label>
                                            <div class="layui-input-inline">
                                                <input type="text" style="cursor:pointer" readonly=""
                                                       class="layui-input" id="GeetestCaptcha"
                                                       placeholder="{{ __('dujiaoka.click_to_behavior_verification') }}">
                                            </div>
                                        </div>
                                        <div class="layui-hide">{!! Geetest::render('popup') !!}</div>
                                        <script>$('#GeetestCaptcha').click(function () {
                                                $('.geetest_radar_btn').click();
                                            })</script>
                                        @endif

                                        @if(isset($open_coupon))
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">{{ __('dujiaoka.coupon_code') }}</label>
                                            <div class="layui-input-block">
                                                <input type="text" name="coupon_code"   placeholder="" value=""  class="layui-input">
                                            </div>
                                        </div>
                                        @endif
                                        <div class="layui-form-item">
                                            <div class="layui-input-block">
                                                <button class="layui-btn" lay-submit lay-filter="postOrder">{{ __('dujiaoka.order_now') }}</button>
                                                <button type="reset" class="layui-btn layui-btn-primary">{{ __('dujiaoka.reset') }}</button>
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
                <div class="layui-card-header">{{ __('goods.fields.description') }}</div>
                <div class="layui-card-body">
                    <div class="product-content">
                        {!! $description !!}
                    </div>

                </div>
            </div>
        </div>

    </div>
    <div class="buy-prompt" hidden>
        {!! $buy_prompt !!}
    </div>
@stop

@section('tpljs')
    <script>
        var buyPrompt = $(".buy-prompt").html()
        var instock = {{ $in_stock }}
        layui.use(['form', 'layer'], function(){
            var form = layui.form;
            var layer = layui.layer //获得layer模块
            form.verify({
                by_amount: function (value, item) {
                    if (value == 0) return "{{ __('dujiaoka.prompt.by_amount_not_null') }}"
                    if (value > instock) return "{{ __('dujiaoka.prompt.inventory_shortage') }}"
                },
            })
            form.on('submit(postOrder)', function(data){
                if (data.field.payway == null) {
                    layer.alert("{{ __('dujiaoka.prompt.please_select_mode_of_payment') }}", {
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
                title: "{{ __('goods.fields.buy_prompt') }}",
                content: buyPrompt
            });
            @endif

        });


    </script>
    @stop
