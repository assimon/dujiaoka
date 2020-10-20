@extends('luna.layouts.default')

@section('content')
    <body>
    @include('luna.layouts._nav')
    <style>
        .layui-table td, .layui-table th {
            padding: 9px 5px;
        }
    </style>
    <div class="main">
        <div class="layui-row">
            <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">
                <div class="main-box">
                    <div class="pay-title">
                        <svg style="margin-bottom: -6px;" t="1603120404646" class="icon" viewBox="0 0 1024 1024"
                             version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1611" width="27" height="27">
                            <path d="M320.512 428.032h382.976v61.44H320.512zM320.512 616.448h320.512v61.44H320.512z"
                                  fill="#00EAFF" p-id="1612" data-spm-anchor-id="a313x.7781069.0.i3"
                                  class="selected"></path>
                            <path
                                d="M802.816 937.984H221.184l-40.96-40.96V126.976l40.96-40.96h346.112l26.624 10.24 137.216 117.76 98.304 79.872 15.36 31.744v571.392l-41.984 40.96z m-540.672-81.92h500.736V345.088L677.888 276.48 550.912 167.936H262.144v688.128z"
                                fill="#3C8CE7" p-id="1613" data-spm-anchor-id="a313x.7781069.0.i0" class=""></path>
                        </svg>
                        {{ __('system.confirm_order') }}
                    </div>

                    <div class="layui-card-body">
                        <div class="product-info">
                            <p style="color: #3C8CE7 ;font-size: 18px;font-weight: 700; text-align: center;margin: 20px 0">
                                {{ __('system.note') }}：{{ config('app.order_expire_date') }} {{ __('system.prompt_to_cancel_order') }}！
                            </p>
                        </div>
                        <table class="layui-table" lay-skin="nob">
                            <colgroup>
                                <col width="50%">
                                <col width="50%">
                            </colgroup>
                            <tbody>
                            <tr>
                                <td style="text-align: right">{{ __('system.order_number') }}：</td>
                                <td>{{ $order_id }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: right">{{ __('system.product_name') }}：</td>
                                <td>
                                    <span class="small-tips tips-green noML">{{ $pd_name }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right">{{ __('system.commodity_price') }}：</td>
                                <td>
                                <span class="small-tips tips-green noML">
                                    ￥{{ $product_price }}
                                </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right">{{ __('system.purchase_quantity') }}：</td>
                                <td><span class="small-tips tips-green noML">x {{ $buy_amount }}</span></td>
                            </tr>
                            @if(isset($coupon_code))
                                <tr>
                                    <td style="text-align: right">{{ __('system.promo_code') }}：</td>
                                    <td><span class="small-tips tips-green noML">{{ $coupon_code }}</span></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">{{ __('system.discounted_price') }}：</td>
                                    <td><span class="small-tips tips-green noML">{{ $discount }}</span></td>
                                </tr>
                            @endif
                            <tr>
                                <td style="text-align: right">{{ __('system.actual_payment') }}：</td>
                                <td>
                                    <span class="small-tips tips-green noML">￥{{ $actual_price }}</span>
                                </td>

                            </tr>
                            <tr>
                                <td style="text-align: right">{{ __('system.email') }}：</td>
                                <td>{{ $account }}</td>
                            </tr>
                            @if($other_ipu)
                                <tr>
                                    <td style="text-align: right">{{ __('system.order_information') }}:</td>
                                    <td><p>{{ $other_ipu }}</p></td>
                                </tr>
                            @endif
                            <tr>
                                <td style="text-align: right">{{ __('system.payment_method') }}：</td>
                                <td>{{ \App\Models\Pays::find($pay_way)->pay_name }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <p class="btn" style="text-align: center">
                            <a href="{{ url(\App\Models\Pays::find($pay_way)->pay_handleroute, ['payway' => $pay_way, 'oid' => $order_id]) }}">{{ __('system.pay_immediately') }}</a>
                        </p>

                    </div>


                </div>
            </div>
        </div>
    </div>

    @include('luna.layouts._footer')

    <div class="query-m">
        <a href="{{ url('searchOrder') }}">
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


