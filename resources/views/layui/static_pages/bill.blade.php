@extends('layui.layouts.default')
@section('content')

    <div class="layui-row">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">

            <div class="layui-card cardcon">
                <div class="layui-card-header">{{ __('dujiaoka.confirm_order') }}</div>

                <div class="layui-card-body">
                    <div class="product-info">
                        <p style="color: #1E9FFF;font-size: 20px;font-weight: 500; text-align: center" >{{ __('dujiaoka.warning_title') }}{{ __('dujiaoka.date_to_expired_order', ['min' => dujiaoka_config_get('order_expire_time', 5)]) }}</p>
                    </div>
                    <table class="layui-table" lay-skin="" >
                        <colgroup>
                            <col width="100">
                            <col width="150">
                        </colgroup>
                        <tbody>
                        <tr>
                            <td>{{ __('order.fields.order_sn') }}：</td>
                            <td>{{ $order_sn }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('order.fields.title') }}：</td>
                            <td>
                                <span class="layui-badge layui-bg-blue">
                                    {{ $title }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('order.fields.goods_price') }}：</td>
                            <td>
                                <span class="layui-badge layui-bg-orange">
                                    {{ $goods_price }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('order.fields.buy_amount') }}：</td>
                            <td>x {{ $buy_amount }}</td>
                        </tr>
                        @if(!empty($coupon))
                        <tr>
                            <td>{{ __('order.fields.coupon_id') }}：</td>
                            <td><span class="layui-badge layui-bg-orange">{{ $coupon['coupon'] }}</span></td>
                        </tr>
                        <tr>
                            <td>{{ __('order.fields.coupon_discount_price') }}：</td>
                            <td> <span class="layui-badge layui-bg-green">{{ __('dujiaoka.money_symbol') }}{{ $coupon_discount_price }}</span></td>
                        </tr>
                        @endif
                        @if($wholesale_discount_price > 0 )
                            <tr>
                                <td>{{ __('order.fields.wholesale_discount_price') }}：</td>
                                <td> <span class="layui-badge layui-bg-green">{{ __('dujiaoka.money_symbol') }}{{ $wholesale_discount_price }}</span></td>
                            </tr>
                        @endif
                        <tr>
                            <td>{{ __('order.fields.actual_price') }}：</td>
                            <td><span class="layui-badge layui-bg-red">{{ __('dujiaoka.money_symbol') }}{{ $actual_price }}</span></td>
                        </tr>
                        <tr>
                            <td>{{ __('dujiaoka.email') }}：</td>
                            <td>{{ $email }}</td>
                        </tr>
                        @if(!empty($info))
                        <tr>
                            <td>{{ __('dujiaoka.order_information') }}:</td>
                            <td><p>{{ $info }}</p></td>
                        </tr>
                        @endif
                        <tr>
                            <td>{{ __('dujiaoka.payment_method') }}：</td>
                            <td>{{ $pay['pay_name'] }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <p class="errpanl" style="text-align: center"><a href="{{ url('pay-gateway', ['handle' => urlencode($pay['pay_handleroute']),'payway' => $pay['pay_check'], 'orderSN' => $order_sn]) }}" class="layui-btn layui-btn-sm">{{ __('dujiaoka.pay_immediately') }}</a></p>

                </div>

            </div>

        </div>
    </div>


@stop

@section('tpljs')
    <script>

    </script>
@stop
