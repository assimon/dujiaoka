@extends('hyper.layouts.default')
@section('notice')
    @include('hyper.layouts._notice')
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            {{-- 产品详细信息 --}}
            <h4 class="page-title">{{ __('hyper.buy_title') }}</h4>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-body sp-height">
                <form id="buy-form" action="{{ url('postOrder') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        {{-- 商品名称 --}}
                        <h3>
                            {{ $pd_name }}
                        </h3>
                    </div>
                    <div class="form-group">
                        @if($pd_type == 1)
                            {{-- 自动发货 --}}
                            <h4><span class="badge badge-outline-primary">{{ __('hyper.buy_automatic_delivery') }}</span></h4>
                        @else
                            {{-- 人工发货 --}}
                            <h4><span class="badge badge-outline-danger">{{ __('hyper.buy_charge') }}</span></h4>
                        @endif
                    </div>
                    <div class="form-group">
                        <h3>
                            {{-- 价格 --}}
                            <span>¥{{ $actual_price }}</span>
                            {{-- 原价 --}}
                            <small><del>¥{{ $cost_price }}</del></small>
                        </h3>
                    </div>
                    <div class="form-group">
                        @if(!empty($wholesale_price) && is_array($wholesale_price))
                        <div class="alert alert-dark bg-white text-dark mb-0" role="alert">
                            {{-- 批发优惠 --}}
                             <h5>{{ __('hyper.buy_wholesale_discount') }}</h5>
                            @foreach($wholesale_price as $ws)
                                {{-- 购买数量 xxx 个或以上，每个 xxx 元 --}}
                                <p>{{ __('hyper.buy_purchase_quantity') }} {{ $ws['number'] }} {{__('hyper.buy_the_above')}}{{ __('hyper.buy_each') }} ¥{{ $ws['price'] }}</span></p>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {{-- 电子邮箱 --}}
                            <label class="col-form-label">{{ __('hyper.buy_email') }}</label>
                            <input type="hidden" name="pid" value="{{ $id }}">
                            {{-- 接收卡密或通知 --}}
                            <input type="email" name="account" class="form-control" placeholder="{{ __('hyper.buy_input_account') }}">
                        </div>
                        <div class="form-group col-md-6">
                            {{-- 购买数量 --}}
                            <label class="col-form-label">{{ __('hyper.buy_purchase_quantity') }}</label>
                            <div class="input-group">
                                <input type="number" name="order_number" min="1" value="1" class="form-control mr-1" placeholder="">
                                <div class="input-group-append">
                                    {{-- 库存 --}}
                                    <span style="line-height:44px">{{ __('hyper.buy_in_stock') }}({{ $in_stock }})</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        @if(config('webset.isopen_searchpwd') == 1)
                        <div class="form-group col-md-6">
                            {{-- 查询密码 --}}
                            <label class="col-form-label">{{ __('hyper.buy_search_password') }}</label>
                            {{-- 查询订单密码 --}}
                            <input type="text" name="search_pwd" value="" class="form-control" placeholder="{{ __('hyper.buy_input_search_password') }}">
                        </div>
                        @endif
                        @if($isopen_coupon == 1)
                        <div class="form-group col-md-6">
                            {{-- 优惠码 --}}
                            <label class="col-form-label">{{ __('hyper.buy_promo_code') }}</label>
                            {{-- 您有优惠码吗？ --}}
                            <input type="text" name="coupon_code" class="form-control" placeholder="{{ __('hyper.buy_input_promo_code') }}">
                        </div>
                        @endif
                    </div>
                    @if(!empty($other_ipu) && is_array($other_ipu))
                        @foreach($other_ipu as $ipu)
                        <div class="form-group">
                            <label class="col-form-label">{{ $ipu['desc'] }}</label>
                            <input type="text" name="{{ $ipu['field'] }}" class="form-control" placeholder="">
                        </div>
                        @endforeach
                    @endif
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {{-- 支付方式 --}}
                            <label class="col-form-label">{{ __('hyper.buy_payment_method') }}</label>
                            <select class="form-control" name="payway">
                                <option value="0">{{ __('hyper.buy_select_payment_method') }}</option>
                                @foreach($payways as $way)
                                <option value="{{ $way['id'] }}">{{ $way['pay_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(config('app.shgeetest'))
                        {{-- 极验证 --}}
                        <div class="form-group col-md-6">
                            {{-- 行为验证 --}}
                            <label class="col-form-label">{{ __('hyper.buy_behavior_verification') }}</label>
                            {!! Geetest::render('popup') !!}
                        </div>
                        @endif
                        @if(config('webset.verify_code') == 1)
                        {{-- 图形验证码 --}}
                        <div class="form-group col-md-6">
                            <label class="col-form-label">{{ __('hyper.buy_verify_code') }}</label>
                            <div class="input-group">
                                <input type="text" name="verify_img" value="" class="form-control" placeholder="{{ __('hyper.buy_verify_code') }}">
                                <div class="input-group-append">
                                    <div class="buy-captcha">
                                        <img class="captcha-img"  src="{{ captcha_src('buy') }}" onclick="refresh()" style="cursor: pointer;height: 44px;">
                                    </div>
                                </div>
                            </div>
                            <script>
                                function refresh(){
                                    $('img[class="captcha-img"]').attr('src','{{ captcha_src('buy') }}'+Math.random());
                                }
                            </script>
                        </div>
                        @endif
                    </div>
                    <div class="mt-4 text-center">
                        {{-- 提交订单 --}}
                        <button type="submit" class="btn btn-danger" id="submit">
                            <i class="mdi mdi-truck-fast mr-1"></i>
                            {{ __('hyper.buy_order_now') }}
                        </button>
                    </div>
                </form>
            </div> <!-- end card-->
        </div>
        <div class="col-md-6">
            <div class="card card-body buy-product xq-height">
                {{-- 商品详情 --}}
                <h5 class="card-title">{{ __('hyper.buy_product_desciption') }}</h5>
                <div class="scrollbar">
                    {!! $pd_info !!}
                </div>
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>

<div class="modal fade" id="buy_prompt" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                {{-- 购买提示 --}}
                <h5 class="modal-title" id="myCenterModalLabel">{{ __('prompt.purchase_tips') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                {!! $buy_prompt !!}
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="img-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: none;">
        <img id="img-zoom" style="border-radius: 5px;">
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop
@section('tpljs')
<script>
    $(function() {
        var sp_height = $('.sp-height').height(),screen_width = $(window).width();
        if(screen_width > '767') {
            $('.xq-height').height(sp_height);
        }
    });
    $('#submit').click(function(){
        if($("input[name='account']").val() == ''){
            $.NotificationApp.send("{{ __('hyper.buy_warning') }}","{{ __('hyper.buy_email_cannot_be_empty') }}","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
        if($("input[name='order_number']").val() == 0){
            $.NotificationApp.send("{{ __('hyper.buy_warning') }}","{{ __('hyper.buy_quantity_cannot_be_z') }}","bottom-right","rgba(0,0,0,0.2)","info");
            return false;
        }
        if($("input[name='order_number']").val() > {{ $in_stock }}){
            $.NotificationApp.send("{{ __('hyper.buy_warning') }}","{{ __('hyper.buy_quantity_exceeds_limit') }}","bottom-right","rgba(0,0,0,0.2)","info");
            return false;
        }
        @if(config('webset.isopen_searchpwd') == 1)
        if($("input[name='search_pwd']").val() == 0){
            $.NotificationApp.send("{{ __('hyper.buy_warning') }}","{{ __('hyper.buy_query_pwd_is_not_empty') }}","bottom-right","rgba(0,0,0,0.2)","info");
            return false;
        }
        @endif
        if($("select[name='payway']>option:selected").attr('value') == '0'){
            $.NotificationApp.send("{{ __('hyper.buy_warning') }}","{{ __('hyper.buy_no_payment_method') }}","bottom-right","rgba(0,0,0,0.2)","info");
            return false;
        }
        @if(config('webset.verify_code') == 1)
        if($("input[name='verify_img']").val() == ''){
            $.NotificationApp.send("{{ __('hyper.buy_warning') }}","{{ __('hyper.buy_code_is_not_empty') }}","bottom-right","rgba(0,0,0,0.2)","info");
            return false;
        }
        @endif
    });
    @if(!empty($buy_prompt))
    $('#buy_prompt').modal();
    @endif
    $(function() {
        //点击图片放大
        $("#img-zoom").click(function(){
            $('#img-modal').modal("hide");
        });
        $("#img-dialog").click(function(){
            $('#img-modal').modal("hide");
        });
        $(".buy-product img").each(function(i){
            var src = $(this).attr("src");
            $(this).click(function () {
                $("#img-zoom").attr("src", src);
                var oImg = $(this);
                var img = new Image();
                img.src = $(oImg).attr("src");
                var realWidth = img.width;
                var realHeight = img.height;
                var ww = $(window).width();
                var hh = $(window).height();
                $("#img-content").css({"top":0,"left":0,"height":"auto"});
                $("#img-zoom").css({"height":"auto"});
                $("#img-zoom").css({"margin-left":"auto"});
                $("#img-zoom").css({"margin-right":"auto"});
                if((realWidth+20)>ww){
                    $("#img-content").css({"width":"100%"});
                    $("#img-zoom").css({"width":"100%"});
                }else{
                    $("#img-content").css({"width":realWidth+20, "height":realHeight+20});
                    $("#img-zoom").css({"width":realWidth, "height":realHeight});
                }
                if((hh-realHeight-40)>0){
                    $("#img-content").css({"top":(hh-realHeight-40)/2});
                }
                if((ww-realWidth-20)>0){
                    $("#img-content").css({"left":(ww-realWidth-20)/2});
                }
                $('#img-modal').modal();
            });
        });
    });
</script>
@stop