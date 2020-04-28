@extends('choice.layouts.default')
@section('content')

    <div class="layui-row">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">

            <div class="layui-card cardcon">
                <div class="layui-card-header">确认订单</div>

                <div class="layui-card-body">
                    <div class="product-info">
                        <p style="color: #1E9FFF;font-size: 20px;font-weight: 500; text-align: center" >注意：{{ config('app.order_expire_date') }}分钟内未完成支付订单将作废！</p>
                    </div>
                    <table class="layui-table" lay-skin="" >
                        <colgroup>
                            <col width="100">
                            <col width="150">
                        </colgroup>
                        <tbody>
                        <tr>
                            <td>订单编号：</td>
                            <td>{{ $order_id }}</td>
                        </tr>
                        <tr>
                            <td>商品名称：</td>
                            <td>
                                <span class="layui-badge layui-bg-blue">
                                    {{ $pd_name }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>商品单价：</td>
                            <td>
                                <span class="layui-badge layui-bg-orange">
                                    {{ $product_price }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>购买数量：</td>
                            <td>x {{ $buy_amount }}</td>
                        </tr>
                        @if(isset($coupon_code))
                        <tr>
                            <td>优惠码：</td>
                            <td><span class="layui-badge layui-bg-orange">{{ $coupon_code }}</span></td>
                        </tr>
                        <tr>
                            <td>优惠金额：</td>
                            <td> <span class="layui-badge layui-bg-green">{{ $discount }}</span></td>
                        </tr>
                        @endif
                        <tr>
                            <td>实际需要支付：</td>
                            <td><span class="layui-badge layui-bg-red">{{ $actual_price }}</span></td>
                        </tr>
                        <tr>
                            <td>邮箱：</td>
                            <td>{{ $account }}</td>
                        </tr>
                        @if($other_ipu)
                        <tr>
                            <td>订单资料:</td>
                            <td><p>{{ $other_ipu }}</p></td>
                        </tr>
                        @endif
                        <tr>
                            <td>支付方式：</td>
                            <td>{{ \App\Models\Pays::find($pay_way)->pay_name }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <p class="errpanl" style="text-align: center"><a href="{{ url(\App\Models\Pays::find($pay_way)->pay_handleroute, ['payway' => $pay_way, 'oid' => $order_id]) }}" class="layui-btn layui-btn-sm">立即支付</a></p>

                </div>



            </div>

        </div>
    </div>


@stop

@section('tpljs')
    <script>

    </script>
@stop
