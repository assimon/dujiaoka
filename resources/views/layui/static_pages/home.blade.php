@extends('layui.layouts.default')
@section('notice')
    @include('layui.layouts._notice')
@endsection
@section('content')
    @foreach($data as $group)
        <div class="layui-row">
            <div class="layui-col-md8 layui-col-md-offset2 layui-col-xs12">
                <div class="layui-card cardcon">
                    <div class="layui-card-header">{{ $group['gp_name'] }}：</div>
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
                                    <th>{{ __('goods.fields.gd_name') }}</th>
                                    <th>{{ __('goods.fields.group_id') }}</th>
                                    <th>{{ __('dujiaoka.price') }}</th>
                                    <th>{{ __('goods.fields.in_stock') }}</th>
                                    <th>{{ __('dujiaoka.wholesale_discount') }}</th>
                                    <th>{{ __('dujiaoka.order_now') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($group['goods'] as $goods)
                                    <tr>
                                        <td>{{ $goods['gd_name'] }}</td>
                                        <td>
                                            @if($goods['type'] == \App\Models\Goods::AUTOMATIC_DELIVERY)
                                                <span style="color: #5FB878">{{ __('goods.fields.automatic_delivery') }}</span>
                                            @else
                                                <span style="color: #FF5722">{{ __('goods.fields.manual_processing') }}</span>
                                            @endif
                                        </td>
                                        <td><b class="product-box-price">{{ __('dujiaoka.money_symbol') }}{{ $goods['actual_price'] }}</b></td>
                                        <td>{{ $goods['in_stock'] }}</td>
                                        <td>@if($goods['wholesale_price_cnf'])
                                                <span class="layui-badge layui-bg-orange">{{ __('dujiaoka.discount') }}</span>
                                            @else
                                                <span class="layui-badge">{{ __('dujiaoka.not') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($goods['in_stock'] > 0)
                                            <a href="{{ url("/buy/{$goods['id']}") }}" class="layui-btn layui-btn-radius layui-btn-primary layui-btn-sm">
                                                {{ __('dujiaoka.order_now') }}<i class="layui-icon layui-icon-cart-simple"></i>
                                            </a>
                                            @else
                                                <a href="#" class="layui-btn layui-btn-radius layui-btn-disabled layui-btn-sm">
                                                    {{ __('dujiaoka.order_now') }}<i class="layui-icon layui-icon-cart-simple"></i>
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

