@extends('luna.layouts.default')

@section('content')
    <body>
    @include('luna.layouts._nav')

    <div class="main">
        <div class="layui-row">
            <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">
                <div class="main-box">

                    <div class="pay-title">
                        <svg style="margin-bottom: -6px;" t="1603122535052" class="icon" viewBox="0 0 1024 1024"
                             version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1949" width="27" height="27">
                            <path
                                d="M146.432 336.896h-81.92V106.496l40.96-40.96h231.424v81.92H146.432zM336.896 958.464H105.472l-40.96-40.96V687.104h81.92v189.44h190.464zM956.416 336.896h-81.92V147.456H684.032v-81.92h231.424l40.96 40.96zM915.456 958.464H613.376v-81.92h261.12V659.456h81.92v258.048z"
                                fill="#3C8CE7" p-id="1950" data-spm-anchor-id="a313x.7781069.0.i11"
                                class="selected"></path>
                            <path
                                d="M326.656 334.848h61.44v98.304h-61.44zM415.744 575.488h61.44v133.12h-61.44zM265.216 575.488h61.44v114.688h-61.44zM566.272 575.488h61.44v98.304h-61.44zM706.56 575.488h61.44v154.624h-61.44zM477.184 297.984h61.44v135.168h-61.44zM627.712 329.728h61.44v103.424h-61.44z"
                                fill="#00EAFF" p-id="1951" data-spm-anchor-id="a313x.7781069.0.i9" class=""></path>
                            <path d="M10.24 473.088h1003.52v61.44H10.24z" fill="#3C8CE7" p-id="1952"
                                  data-spm-anchor-id="a313x.7781069.0.i12" class="selected"></path>
                        </svg>
                        {{ __('dujiaoka.scan_qrcode_to_pay') }}
                    </div>

                    <div class="layui-card-body">
                        <div class="product-info">
                            <p style="color: #3C8CE7 ;font-size: 18px;font-weight: 700; text-align: center;margin: 20px 0">
                                {{ __('dujiaoka.payment_method') }}：[{{ $payname }}
                                ], {{ __('dujiaoka.pay_order_expiration_date_prompt', ['min' => dujiaoka_config_get('order_expire_time', 5)]) }}
                            </p>
                        </div>

                        <div
                            style="text-align: center; border: 3px solid #3C8CE7 ;border-radius: 10px;width: 300px;margin: 0 auto;padding-top: 10px">
                            <p class="product-pay-price" style="font-size: 16px;color: #737373;">
                                {{ __('dujiaoka.amount_to_be_paid') }}
                                : {{ __('dujiaoka.money_symbol') }}{{ $actual_price }}
                            </p>
                            <img
                                src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(200)->generate($qr_code)) !!}"
                                alt="">
                            @if(Agent::isMobile() && isset($jump_payuri))
                                <p class="btn" style="margin-bottom: 20px"><a
                                        href="{{ $jump_payuri }}">{{ __('dujiaoka.open_the_app_to_pay') }}</a></p>
                            @endif
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('luna.layouts._footer')

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
    </body>
@endsection


@section('js')
    <script>
        var getting = {
            url     : '{{ url('check-order-status', ['orderSN' => $orderid]) }}',
            dataType: 'json',
            success : function (res) {
                if (res.code === 400001) {
                    window.clearTimeout(timer);
                    layer.alert("{{ __('dujiaoka.prompt.order_is_expired') }}", {
                        icon: 2
                    }, function () {
                        window.location.href = '/'
                    });

                }
                if (res.code === 200) {
                    window.clearTimeout(timer);
                    layer.alert("{{ __('dujiaoka.prompt.payment_successful') }}", {
                        icon    : 1,
                        closeBtn: 0
                    }, function () {
                        window.location.href = "{{ url('detail-order-sn', ['orderSN' => $orderid]) }}"
                    });
                }
            }

        };
        var timer = window.setInterval(function () {
            $.ajax(getting)
        }, 5000);
    </script>
@endsection
