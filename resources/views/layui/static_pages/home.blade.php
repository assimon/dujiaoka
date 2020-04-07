@extends('layui.layouts.default')
@section('notice')
    @include('layui.layouts._notice')
    @endsection
@section('content')
    @foreach($classifys as $classify)

    <div class="layui-row">
        <div class="layui-col-md6 layui-col-md-offset3 layui-col-sm12">
            <div class="layui-card cardcon">
                <div class="layui-card-header">{{ $classify['name'] }}：</div>
                <div class="layui-card-body">

                    <table class="layui-table" lay-even lay-skin="nob">
                        <colgroup>
                            <col width="150">
                            <col width="50">
                            <col width="50">
                            <col width="50">
                            <col width="80">
                            <col width="80">
                        </colgroup>
                        <thead>
                        <tr>
                            <th>商品名称</th>
                            <th>销量</th>
                            <th>单价</th>
                            <th>库存</th>
                            <th>商品类型</th>
                            <th style="text-align: center !important;">操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($classify['products'] as $product)
                            <tr>
                                <td>{{ $product['pd_name'] }}</td>
                                <td>{{ $product['sales_volume'] }}</td>
                                <td>{{ $product['actual_price'] }}￥</td>
                                <td>{{ $product['in_stock'] }}</td>
                                <td>
                                    @if($product['pd_type'] == 1)
                                        <button class="layui-btn layui-btn-xs">自动发货</button>
                                        @else
                                        <button class="layui-btn layui-btn-xs layui-btn-warm">代充</button>
                                    @endif
                                </td>
                                <td align="center">
                                    @if($product['in_stock'] > 0)
                                        <a href="{{ url("/buy/{$product['id']}") }}" class="layui-btn  layui-btn-sm layui-btn-normal">购买<i class="layui-icon layui-icon-cart"></i></a>
                                    @else
                                        <a href="#" class="layui-btn  layui-btn-sm layui-btn-disabled">购买<i class="layui-icon layui-icon-cart"></i></a>
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

    @endforeach

@stop
@section('tpljs')
    <script>
        //注意：导航 依赖 element 模块，否则无法进行功能性操作
        layui.use('element', function(){
            var element = layui.element;

            //…
        });

    </script>
@stop
