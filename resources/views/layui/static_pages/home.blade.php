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
                           @foreach($classify['products'] as $product)
                           <div class="layui-col-md3 layui-col-xs6 product-box">
                               <a href="{{ url("/buy/{$product['id']}") }}">
                                   <div class="layui-card product-panl">
                                       <div class="layui-card-body product-img">
                                           <img src="{{ $product['pd_picture'] }}" width="100%" height="100%">
                                       </div>
                                       <div class="product-box-info">
                                           <div class="product-title">
                                               {{ $product['pd_name'] }}
                                           </div>
                                           <div class="product-class">
                                               @if($product['pd_type'] == 1)
                                                   <span class="layui-badge layui-bg-green">自动发货</span>
                                               @else
                                                   <span class="layui-badge">代充</span>
                                               @endif
                                                   @if($product['wholesale_price'])
                                                     <span class="layui-badge layui-bg-orange">折扣</span>
                                                   @endif
                                           </div>
                                           <div class="">
                                               <div class="product-box-price" ><b>￥{{ $product['actual_price'] }}</b></div>
                                               <div class="product-volume">库存({{ $product['in_stock'] }})</div>
                                           </div>
                                       </div>

                                   </div>
                               </a>
                           </div>
                           @endforeach




                       </div>

                    </div>
                </div>
            </div>
        </div>
    @endforeach

@stop

