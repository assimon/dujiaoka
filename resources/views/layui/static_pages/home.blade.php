@extends('layui.layouts.default')
@section('notice')
    @include('layui.layouts._notice')
@endsection
@section('content')
    @foreach($classifys as $classify)

        <div class="layui-row">
            <div class="layui-col-md8 layui-col-md-offset2 layui-col-xs12">
                <div class="layui-card cardcon">
                    <div class="layui-card-header">{{ $classify['name'] }}：</div>
                    <div class="layui-card-body">
                        <div class="layui-row" >
                            <table class="layui-table" lay-even lay-skin="nob">
                                <colgroup>
                                    <col width="300">
                                    <col width="100">
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                </colgroup>
                                <thead>
                                <tr>
                                    <th>{{ __('system.product_name') }}</th>
                                    <th>{{ __('system.product_class') }}</th>
                                    <th>{{ __('system.price') }}</th>
                                    <th>{{ __('system.in_stock') }}</th>
                                    <th>{{ __('system.wholesale_discount') }}</th>
                                    <th>{{ __('system.place_an_order') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($classify['products'] as $product)
                                    <tr>
                                        <td>{{ $product['pd_name'] }}</td>
                                        <td>
                                            @if($product['pd_type'] == 1)
                                                <span style="color: #5FB878">{{ __('system.automatic_delivery') }}</span>
                                            @else
                                                <span style="color: #FF5722">{{ __('system.charge') }}</span>
                                            @endif
                                        </td>
                                        <td><b class="product-box-price">￥{{ $product['actual_price'] }}</b></td>
                                        <td>{{ $product['in_stock'] }}</td>
                                        <td>@if($product['wholesale_price'])
                                                <span class="layui-badge layui-bg-orange">{{ __('system.discount') }}</span>
                                            @else
                                                <span class="layui-badge">{{ __('system.not') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($product['in_stock'] > 0)
                                            <a href="{{ url("/buy/{$product['id']}") }}" class="layui-btn layui-btn-radius layui-btn-primary layui-btn-sm">
                                                {{ __('system.buy') }}<i class="layui-icon layui-icon-cart-simple"></i>
                                            </a>
                                            @else
                                                <a href="#" class="layui-btn layui-btn-radius layui-btn-disabled layui-btn-sm">
                                                    {{ __('system.buy') }}<i class="layui-icon layui-icon-cart-simple"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@stop

