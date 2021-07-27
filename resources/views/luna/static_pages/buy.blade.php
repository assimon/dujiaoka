@extends('luna.layouts.default')

@section('notice')
    @include('luna.layouts._notice')
@endsection

@section('content')
    <body>
    @include('luna.layouts._nav')

    <div class="main">
        <div class="layui-row">
            <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">
                <div class="main-box">
                    <div class="title" style="border-bottom: 1px solid #f7f7f7;padding-bottom: 5px">
                        <svg t="1602931755138" class="icon" viewBox="0 0 1024 1024" version="1.1"
                             xmlns="http://www.w3.org/2000/svg" p-id="4748" width="20" height="20">
                            <path
                                d="M904.192 908.288H119.808l-40.96-45.056 81.92-711.68 40.96-35.84h142.336v81.92H237.568l-71.68 628.736h692.224l-71.68-628.736H680.96v-81.92h141.312l40.96 35.84 81.92 711.68z"
                                fill="#3C8CE7" p-id="4749" data-spm-anchor-id="a313x.7781069.0.i65" class=""></path>
                            <path
                                d="M516.096 422.912c-104.448 0-151.552-73.728-161.792-112.64l59.392-15.36c2.048 7.168 20.48 66.56 102.4 66.56 78.848 0 91.136-57.344 92.16-63.488l60.416 10.24c-5.12 38.912-46.08 114.688-152.576 114.688z"
                                fill="#00EAFF" p-id="4750" data-spm-anchor-id="a313x.7781069.0.i68"
                                class="selected"></path>
                        </svg>
                        <span>{{ __('luna.buy_goods_msg') }}</span>
                    </div>
                    <div class="layui-col-md4 layui-col-sm12">
                        <div class="goods-img">
                            <img class="viewer-pictures"
                                 src="{{ picture_ulr($picture) }}"
                                 data-original="{{ picture_ulr($picture) }}"
                                 alt="">
                        </div>
                    </div>
                    <form class="layui-form layui-form-pane" action="{{ url('create-order') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="gid" value="{{ $id }}">
                        <div class="layui-col-md8 layui-col-sm12">
                            <div class="goods-msg">
                                <div class="goods-name">
                                    <svg style="vertical-align: middle;" t="1602941112468" class="icon"
                                         viewBox="0 0 1024 1024"
                                         version="1.1"
                                         xmlns="http://www.w3.org/2000/svg" p-id="1512" width="25" height="25"
                                         data-spm-anchor-id="a313x.7781069.0.i14">
                                        <path
                                            d="M727.04 750.592h-68.608v-81.92H686.08V249.856L512 99.328 337.92 253.952v414.72h28.672v81.92H296.96l-40.96-40.96V235.52l13.312-30.72 215.04-190.464h54.272l215.04 186.368 14.336 30.72v478.208z"
                                            fill="#3C8CE7" p-id="1513" data-spm-anchor-id="a313x.7781069.0.i12"
                                            class=""></path>
                                        <path
                                            d="M869.376 638.976l-147.456-18.432-35.84-40.96V350.208l69.632-28.672 147.456 147.456 12.288 28.672v99.328l-46.08 41.984zM768 543.744l65.536 8.192v-35.84L768 449.536v94.208zM154.624 638.976l-46.08-40.96v-99.328l12.288-28.672 147.456-147.456 69.632 28.672v229.376l-35.84 40.96-147.456 17.408z m35.84-123.904v35.84L256 542.72v-94.208l-65.536 66.56z"
                                            fill="#3C8CE7" p-id="1514" data-spm-anchor-id="a313x.7781069.0.i15"
                                            class=""></path>
                                        <path
                                            d="M512 465.92m-67.584 0a67.584 67.584 0 1 0 135.168 0 67.584 67.584 0 1 0-135.168 0Z"
                                            fill="#3C8CE7" p-id="1515" data-spm-anchor-id="a313x.7781069.0.i16"
                                            class=""></path>
                                        <path
                                            d="M479.232 660.48h58.368v233.472h-58.368zM391.168 723.968h58.368v157.696h-58.368zM461.824 922.624h58.368v88.064h-58.368zM574.464 748.544h58.368v188.416h-58.368z"
                                            fill="#00EAFF" p-id="1516" data-spm-anchor-id="a313x.7781069.0.i17"
                                            class="selected"></path>
                                    </svg>
                                    <span>
                                        {{ $gd_name }}
                                        @if($type == \App\Models\Goods::AUTOMATIC_DELIVERY)
                                            <span
                                                class="small-tips tips-green">{{ __('goods.fields.automatic_delivery') }}</span>
                                        @else
                                            <span
                                                class="small-tips tips-yellow">{{ __('goods.fields.manual_processing') }}</span>
                                        @endif
                                        <span class="small-tips tips-blue">{{__('goods.fields.in_stock')}}({{ $in_stock }})</span>
                                        @if($buy_limit_num > 0)
                                            <span class="small-tips tips-red"> {{__('dujiaoka.purchase_limit')}}({{ $buy_limit_num }})</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="price">
                                    <span class="price-sign">￥</span>
                                    <span class="price-num">{{ $actual_price }}</span>
                                    @if((int)$retail_price)
                                        <span class="price-c">[<del>￥{{ $retail_price }}</del>]</span>
                                    @endif
                                </div>

                                @if(!empty($wholesale_price_cnf) && is_array($wholesale_price_cnf))
                                    <div class="sale">
                                        @foreach($wholesale_price_cnf as $ws)
                                            <span class="small-tips tips-pink">
                                            {{ __('luna.goods_disc_1') }}{{ $ws['number'] }}{{ __('luna.goods_disc_2') }}{{ $ws['price']  }}{{ __('luna.goods_disc_3') }}
                                        </span>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="entry notSelection">
                                    <span class="l-msg">{{ __('luna.buy_num') }}：</span>
                                    <label class="input">
                                        <span class="sub">
                                            <svg t="1602946172380" class="icon" viewBox="0 0 1025 1024" version="1.1"
                                                 xmlns="http://www.w3.org/2000/svg" p-id="1676" width="25" height="25"><path
                                                    d="M874.971429 149.942857C776.228571 54.857143 648.228571 0 512.914286 0S245.942857 54.857143 150.857143 149.942857c-201.142857 201.142857-201.142857 522.971429 0 724.114286C245.942857 969.142857 377.6 1024 512.914286 1024s266.971429-54.857143 362.057143-149.942857c201.142857-201.142857 201.142857-522.971429 0-724.114286m-51.2 672.914286C739.657143 906.971429 629.942857 950.857143 512.914286 950.857143s-226.742857-43.885714-310.857143-128c-171.885714-171.885714-171.885714-449.828571 0-621.714286C286.171429 117.028571 395.885714 73.142857 512.914286 73.142857s226.742857 43.885714 310.857143 128c171.885714 171.885714 171.885714 449.828571 0 621.714286"
                                                    p-id="1677" fill="#8a8a8a"></path><path
                                                    d="M772.571429 475.428571H253.257143c-21.942857 0-36.571429 14.628571-36.571429 36.571429 0 10.971429 3.657143 18.285714 10.971429 25.6s14.628571 10.971429 25.6 10.971429H768.914286c21.942857 0 36.571429-14.628571 36.571428-36.571429s-14.628571-36.571429-32.914285-36.571429"
                                                    p-id="1678" fill="#8a8a8a"></path></svg>
                                        </span>
                                        <input class="pay-num" name="by_amount" id="orderNumber"
                                               required lay-verify="required|order_number"
                                               type="number" value="1">
                                        <span class="add">
                                            <svg t="1602946147946" class="icon" viewBox="0 0 1025 1024" version="1.1"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 p-id="12364" width="25" height="25"><path
                                                    d="M874.971429 149.942857C776.228571 54.857143 648.228571 0 512.914286 0S245.942857 54.857143 150.857143 149.942857c-201.142857 201.142857-201.142857 522.971429 0 724.114286C245.942857 969.142857 377.6 1024 512.914286 1024s266.971429-54.857143 362.057143-149.942857c201.142857-201.142857 201.142857-522.971429 0-724.114286m-51.2 672.914286C739.657143 906.971429 629.942857 950.857143 512.914286 950.857143s-226.742857-43.885714-310.857143-128c-171.885714-171.885714-171.885714-449.828571 0-621.714286C286.171429 117.028571 395.885714 73.142857 512.914286 73.142857s226.742857 43.885714 310.857143 128c171.885714 171.885714 171.885714 449.828571 0 621.714286"
                                                    p-id="12365" fill="#8a8a8a"></path><path
                                                    d="M549.485714 475.428571V288.914286c0-21.942857-14.628571-36.571429-36.571428-36.571429s-36.571429 14.628571-36.571429 36.571429V475.428571H289.828571c-21.942857 0-36.571429 14.628571-36.571428 36.571429 0 10.971429 3.657143 18.285714 10.971428 25.6s14.628571 10.971429 25.6 10.971429H476.342857v186.514285c0 10.971429 3.657143 18.285714 10.971429 25.6 7.314286 7.314286 14.628571 10.971429 25.6 10.971429 21.942857 0 36.571429-14.628571 36.571428-36.571429V548.571429h186.514286c21.942857 0 36.571429-14.628571 36.571429-36.571429s-14.628571-36.571429-36.571429-36.571429H549.485714z"
                                                    p-id="12366" fill="#8a8a8a"></path>
                                            </svg>
                                        </span>
                                    </label>
                                </div>
                                <div class="entry">
                                    <span class="l-msg">{{ __('luna.buy_email') }}：</span>
                                    <label class="input">
                                        <input type="text" name="email"
                                               required lay-verify="required|email"
                                               placeholder="{{ __('luna.buy_email_tips') }}">
                                    </label>
                                </div>
                                @if(isset($open_coupon))
                                    <div class="entry">
                                        <span class="l-msg">{{ __('luna.buy_disc') }}：</span>
                                        <label class="input">
                                            <input type="text" name="coupon_code"
                                                   placeholder="{{ __('luna.buy_disc_tips') }}">
                                        </label>
                                    </div>
                                @endif


                                @if($type == \App\Models\Goods::MANUAL_PROCESSING && is_array($other_ipu))
                                    @foreach($other_ipu as $ipu)
                                        @php
                                            preg_match_all('/(.*?)\[(.*?)\]/m', $ipu['desc'], $matches, PREG_SET_ORDER, 0);

                                            $str = $matches[0][2] ?? '';
                                            if($str){
                                                $name = $matches[0][1] ?? '';
                                                $option = explode('|',$str);
                                            }else{
                                                $option = [];
                                            }

                                        @endphp
                                        @if(count($option))
                                            <style>
                                                .layui-form-select {
                                                    width: 300px;
                                                    display: inline-block;
                                                }

                                                .layui-form-pane .layui-input {
                                                    border-radius: 4px;
                                                    height: 37px;
                                                    width: 312px;
                                                }

                                                .layui-form-select .layui-edge {
                                                    right: 0px;
                                                }

                                                @media (max-width: 768px) {
                                                    .layui-form-select {
                                                        width: calc(100% - 83px);
                                                    }

                                                    .layui-form-pane .layui-input {
                                                        width: 100%;
                                                    }

                                                    .layui-form-select .layui-edge {
                                                        right: 10px;
                                                    }
                                                }
                                            </style>
                                            <div class="entry">
                                                <span class="l-msg">{{ $name }}：</span>
                                                <label class="input">
                                                    <select class="layui-bg-blue" name="{{ $ipu['field'] }}"
                                                            @if($ipu['rule'] !== false) required
                                                            lay-verify="required" @endif>
                                                        @foreach($option as $opt)
                                                            <option value="{{ $opt }}">{{ $opt }}</option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
                                        @else
                                            <div class="entry">
                                                <span class="l-msg">{{ $ipu['desc'] }}：</span>
                                                <label class="input">
                                                    <input type="text" name="{{ $ipu['field'] }}"
                                                           @if($ipu['rule'] !== false) required lay-verify="required"
                                                           @endif
                                                           placeholder="{{ $ipu['desc'] }}">
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                @if(dujiaoka_config_get('is_open_search_pwd') == \App\Models\Goods::STATUS_OPEN)
                                    <div class="entry">
                                        <span class="l-msg">{{ __('luna.buy_pass') }}：</span>
                                        <label class="input">
                                            <input type="text" name="search_pwd" value=""
                                                   required lay-verify="required"
                                                   placeholder="{{ __('luna.buy_pass_tips') }}">
                                        </label>
                                    </div>
                                @endif
                                @if(dujiaoka_config_get('is_open_img_code') == \App\Models\Goods::STATUS_OPEN)
                                    <div class="entry code">
                                        <span class="l-msg">{{ __('luna.buy_code') }}：</span>
                                        <label class="input">
                                            <input type="text" name="img_verify_code" value="" required
                                                   lay-verify="required" placeholder="{{ __('luna.buy_code_tips') }}">
                                        </label>
                                        <img class="captcha-img" onclick="refresh()"
                                             src="{{ captcha_src('buy') . time() }}"
                                             alt="">
                                        <script>
                                            function refresh() {
                                                $('img[class="captcha-img"]').attr('src', '{{ captcha_src('buy') }}' + Math.random());
                                            }
                                        </script>
                                    </div>
                                @endif
                                @if(dujiaoka_config_get('is_open_geetest') == \App\Models\Goods::STATUS_OPEN)
                                    <div class="entry code">
                                        <span class="l-msg">{{ __('dujiaoka.behavior_verification') }}：</span>
                                        <span id="geetest-captcha"></span>
                                        <span id="wait-geetest-captcha"
                                              class="show">{{ __('luna.buy_loading_verification') }}</span>
                                    </div>
                                @endif
                                <div class="pay notSelection">
                                    <input type="hidden" name="payway" lay-verify="payway"
                                           value="{{ $payways[0]['id'] ?? 0 }}">
                                    @foreach($payways as $key => $way)
                                        <div class="pay-type @if($key == 0) pay-select @endif"
                                             data-type="{{ $way['pay_check'] }}" data-id="{{ $way['id'] }}"
                                             data-name="{{ $way['pay_name'] }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-sm12 buy" style="text-align: center">
                            <button lay-submit lay-filter="postOrder">
                                <span>{{ __('dujiaoka.order_now') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="main">
        <div class="layui-row">
            <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">
                <div class="main-box">
                    <div class="title" style="border-bottom: 1px solid #f7f7f7;padding-bottom: 5px">
                        <svg t="1602951214662" class="icon" viewBox="0 0 1024 1024" version="1.1"
                             xmlns="http://www.w3.org/2000/svg" p-id="1513" width="20" height="20">
                            <path
                                d="M791.552 1002.496L513.024 875.52l-91.136 45.056-35.84-73.728 107.52-53.248 35.84-1.024L766.976 901.12V242.688H257.024v559.104h-81.92V201.728l40.96-40.96h591.872l40.96 40.96v762.88z"
                                fill="#3C8CE7" p-id="1514" data-spm-anchor-id="a313x.7781069.0.i7"
                                class="selected"></path>
                            <path d="M481.28 21.504h61.44v309.248h-61.44z" fill="#00EAFF" p-id="1515"
                                  data-spm-anchor-id="a313x.7781069.0.i8" class=""></path>
                            <path
                                d="M512 518.144c-63.488 0-114.688-51.2-114.688-114.688 0-63.488 51.2-114.688 114.688-114.688s114.688 51.2 114.688 114.688c0 63.488-51.2 114.688-114.688 114.688z m0-167.936c-29.696 0-53.248 23.552-53.248 53.248 0 29.696 23.552 53.248 53.248 53.248s53.248-23.552 53.248-53.248c0-29.696-23.552-53.248-53.248-53.248z"
                                fill="#3C8CE7" p-id="1516" data-spm-anchor-id="a313x.7781069.0.i11"
                                class="selected"></path>
                        </svg>
                        <span>{{ __('goods.fields.description') }}</span>
                    </div>
                    <div class="intro">
                        {!! $description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="query-m">
        <a href="{{ url('order-search') }}">
            <svg t="1602926403006" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"
                 p-id="3391" width="30" height="30">
                <path d="M320.512 428.032h382.976v61.44H320.512zM320.512 616.448h320.512v61.44H320.512z" fill="#ffffff"
                      p-id="3392" data-spm-anchor-id="a313x.7781069.0.i38" class="selected"></path>
                <path
                    d="M802.816 937.984H221.184l-40.96-40.96V126.976l40.96-40.96h346.112l26.624 10.24 137.216 117.76 98.304 79.872 15.36 31.744v571.392l-41.984 40.96z m-540.672-81.92h500.736V345.088L677.888 276.48 550.912 167.936H262.144v688.128z"
                    fill="#ffffff" p-id="3393" data-spm-anchor-id="a313x.7781069.0.i37" class="selected"></path>
            </svg>
            <span>{{ __('luna.order_search_m') }}</span>
        </a>
    </div>

    <div class="order-m">
        <div
            onclick="window.showQrcode('data:image/png;base64,{!! base64_encode(QrCode::format("png")->size(300)->generate(Request::url())) !!}')">
            <svg t="1602927606509" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"
                 p-id="4167" width="35" height="35">
                <path
                    d="M146.432 336.896h-81.92V106.496l40.96-40.96h231.424v81.92H146.432zM336.896 958.464H105.472l-40.96-40.96V687.104h81.92v189.44h190.464zM956.416 336.896h-81.92V147.456H684.032v-81.92h231.424l40.96 40.96zM915.456 958.464H613.376v-81.92h261.12V659.456h81.92v258.048z"
                    fill="#ffffff" p-id="4168" data-spm-anchor-id="a313x.7781069.0.i59" class="selected"></path>
                <path
                    d="M326.656 334.848h61.44v98.304h-61.44zM415.744 575.488h61.44v133.12h-61.44zM265.216 575.488h61.44v114.688h-61.44zM566.272 575.488h61.44v98.304h-61.44zM706.56 575.488h61.44v154.624h-61.44zM477.184 297.984h61.44v135.168h-61.44zM627.712 329.728h61.44v103.424h-61.44z"
                    fill="#ffffff" p-id="4169" data-spm-anchor-id="a313x.7781069.0.i58" class="selected"></path>
                <path d="M10.24 473.088h1003.52v61.44H10.24z" fill="#ffffff" p-id="4170"
                      data-spm-anchor-id="a313x.7781069.0.i57" class="selected"></path>
            </svg>
            <span>{{ __('luna.buy_order_m') }}</span>
        </div>
    </div>

    @include('luna.layouts._footer')
    <div class="buy-prompt" hidden>
        {!! $buy_prompt !!}
    </div>
    </body>
    <script>let stock = {{ $in_stock }}, limitNum = {{$buy_limit_num}};</script>
@endsection
@section('js')
    <script src="https://cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
    <script src="https://static.geetest.com/static/tools/gt.js"></script>
    <link rel="stylesheet" href="/assets/luna/js/viewerjs/viewer.min.css">
    <script src="/assets/luna/js/viewerjs/viewer.min.js"></script>
    <script>
        var buyPrompt = $(".buy-prompt").html();
        if ($.trim(buyPrompt)) window.tipsMsg("{{ __('goods.fields.buy_prompt') }}", buyPrompt);
        gtWidth = window.clientWidth <= 767 ? '100%' : '312px';
        layui.use(['form'], function () {
            var form = layui.form;
            form.verify({
                order_number: function (value, item) {
                    if (value == 0) return "{{ __('dujiaoka.prompt.by_amount_not_null') }}"
                    if (value > stock) return "{{ __('dujiaoka.prompt.inventory_shortage') }}"
                }
            })
            @if(dujiaoka_config_get('is_open_geetest') == \App\Models\Goods::STATUS_OPEN )
                !function (url) {
                var handlerEmbed = function (captchaObj) {
                    form.on('submit(postOrder)', function (data) {
                        var validate = captchaObj.getValidate();
                        if (!validate) {
                            layer.msg('请正确完成行为验证', {
                                icon: 5
                            });
                            return false;
                        }
                        return true;
                    });


                    captchaObj.onReady(function () {
                        $("#wait-geetest-captcha")[0].className = "hide";
                    });

                    captchaObj.appendTo("#geetest-captcha");
                };
                $.ajax({
                    url     : url + "?t=" + (new Date()).getTime(),
                    type    : "get",
                    dataType: "json",
                    success : function (data) {
                        initGeetest({
                            width      : gtWidth,
                            gt         : data.gt,
                            challenge  : data.challenge,
                            product    : "popup",
                            offline    : !data.success,
                            new_captcha: data.new_captcha,
                            lang       : 'zh-cn',
                            http       : 'http' + '://'
                        }, handlerEmbed);
                    }
                });
            }('/check-geetest');
            @endif
            form.on('submit(postOrder)', function (data) {
                if (data.field.payway == null) {
                    layer.msg("{{ __('dujiaoka.prompt.please_select_mode_of_payment') }}", {
                        icon: 5
                    })
                    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
                }
                return true;
            });
            new Viewer(document.querySelector('.viewer-pictures'), {
                url    : 'data-original',
                toolbar: false,
                navbar : false,
                title  : false,
            });
        });

    </script>
@endsection
