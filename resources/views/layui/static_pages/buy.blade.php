@extends('layui.layouts.default')
@section('notice')
    @include('layui.layouts._notice')
@endsection
@section('content')

    <div class="layui-row">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">

            <div class="layui-card cardcon">
                <div class="layui-card-header">下单</div>

                <div class="layui-card-body">
                    <div class="layui-row">
                        <div class="layui-col-md3 layui-hide-xs">
                            <div class="layui-card">
                                <div class="layui-card-body">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('admin')->url($pd_picture) }}" width="100%" height="100%">
                                </div>
                                <div class="layui-card-body">
                                    <img src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(200)->generate(Request::url())) !!}" width="100%" height="100%">
                                    <p style="text-align: center">手机扫码购买</p>

                                </div>
                            </div>
                        </div>


                        <!-- 商品详细区 -->
                        <div class="layui-col-md8  layui-col-xs12" >
                            <div class="layui-card">
                                <div class="layui-card-header">
                                    <span style="font-size: 16px;">{{ $pd_name }}</span>
                                    @if($pd_type == 1)
                                        <span class="layui-badge layui-bg-green">自动发货</span>
                                    @else
                                        <span class="layui-badge layui-bg-orange">代充</span>
                                    @endif
                                    <span class="layui-badge layui-bg-blue">库存({{ $in_stock }})</span>
                                </div>
                                <div class="layui-card-body">
                                    <form class="layui-form layui-form-pane" action="{{ url('postOrder') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="product-info">
                                            <span style="color:#6c6c6c">价格：</span>
                                            <span class="product-price">¥ {{ $actual_price }}</span>
                                            <span class="product-price-cost-price">¥ {{ $cost_price }}</span>
                                        </div>

                                        @if(!empty($wholesale_price) && is_array($wholesale_price))
                                            <div class="product-info">
                                                <span style="color:#F40;font-size: 18px;font-weight: 400"><i class="layui-icon layui-icon-praise"></i>批发优惠：</span>
                                                @foreach($wholesale_price as $ws)
                                                    <p class="ws-price">购买数量{{ $ws['number'] }} 个或以上,每个： <span class="layui-badge layui-bg-orange">{{ $ws['price']  }}￥</span></p>
                                                @endforeach

                                            </div>

                                        @endif

                                        <div class="layui-form-item">
                                            <label class="layui-form-label">邮箱</label>
                                            <div class="layui-input-block">
                                                <input type="hidden" name="pid" value="{{ $id }}">
                                                <input type="email" name="account" value=""  required lay-verify="required|email" placeholder="接收卡密或通知" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">数量</label>
                                            <div class="layui-input-inline">
                                                <input type="number" name="order_number" required  lay-verify="required|order_number" placeholder="" value="1" autocomplete="off" class="layui-input">
                                            </div>

                                        </div>
                                            @if(!empty($other_ipu) && is_array($other_ipu))
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
                                            <label class="layui-form-label">支付方式</label>
                                            <div class="layui-input-block">
                                                @foreach($payways as $way)
                                                <input type="radio"  lay-verify="payway" name="payway" value="{{ $way['id'] }}" title="{{ $way['pay_name'] }}">
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">查询密码</label>
                                            <div class="layui-input-block">
                                                <input type="password" name="search_pwd" value=""  required lay-verify="required" placeholder="为防止撞库攻击，请设置一个查询订单的密码" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>

                                        <div class="layui-form-item">
                                            <label class="layui-form-label">验证码</label>
                                            <div class="layui-input-inline">
                                                <input type="text" name="verify_img" value=""  required lay-verify="required" placeholder="验证码" autocomplete="off" class="layui-input">
                                            </div>
                                            <div class="buy-captcha">
                                                <img class="captcha-img"  src="{{ captcha_src('buy') }}" onclick="refresh()">
                                            </div>
                                            <script>
                                                function refresh(){
                                                    $('img[class="captcha-img"]').attr('src','{{ captcha_src('buy') }}'+Math.random());
                                                }
                                            </script>
                                        </div>

                                        <div class="layui-form-item">
                                            <label class="layui-form-label">优惠码</label>
                                            <div class="layui-input-block">
                                                <input type="text" name="coupon_code"   placeholder="您有优惠码吗？" value="" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>

                                        <div class="layui-form-item">
                                            <div class="layui-input-block">
                                                <button class="layui-btn" lay-submit lay-filter="postOrder">立即下单</button>
                                                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
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
                <div class="layui-card-header">商品介绍</div>
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
                    if (value == 0) return '购买数量不能为0'
                    if (value > instock) return '购买数量大于库存'
                },
            })
            form.on('submit(postOrder)', function(data){
                if (data.field.payway == null) {
                    layer.alert('请选择支付方式', {
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
                title: '购买提示',
                content: '<div class="buy-prompt">{!! $buy_prompt !!}<div>'
            });
            @endif

        });


    </script>
    @stop
