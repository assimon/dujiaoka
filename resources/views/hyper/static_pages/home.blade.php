@extends('hyper.layouts.default')
@section('notice')
    @include('hyper.layouts._notice')
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right d-none d-lg-block">
                <div class="app-search">
                    <div class="position-relative">
                        <input type="text" class="form-control" id="search_pc" placeholder="{{ __('hyper.home_search_box') }}">
                        <span class="mdi mdi-magnify"></span>
                    </div>
                </div>
            </div>
            {{-- 主页 --}}
            <h4 class="page-title">{{ __('hyper.home_title') }}</h4>
        </div>
    </div>
</div>
@section('notice')
@show
<div class="row d-lg-none">
    <div class="col-12">
        <div class="app-search">
            <div class="position-relative">
                <input type="text" class="form-control" id="search_sj" placeholder="{{ __('hyper.home_search_box') }}">
                <span class="mdi mdi-magnify"></span>
            </div>
        </div>
    </div>
</div>
<div class="d-none d-md-block">
    @foreach($classifys as $classify)
    <div class="row category-pc">
        <div class="col-md-12">
            <h3>
                {{-- 分类名称 --}}
                <span class="badge badge-info">{{ $classify['name'] }}</span>
            </h3>
        </div>
        <div class="col-md-12">
            <div class="card pl-1 pr-1">
                <table class="table table-centered mb-0">
                    <thead>
                        <tr>
                            {{-- 名称 --}}
                            <th width="40%">{{ __('hyper.home_product_name') }}</th>
                            {{-- 类型 --}}
                            <th width="10%">{{ __('hyper.home_product_class') }}</th>
                            {{-- 库存 --}}
                            <th width="10%">{{ __('hyper.home_in_stock') }}</th>
                            {{-- 价格 --}}
                            <th width="10%">{{ __('hyper.home_price') }}</th>
                            {{-- 操作 --}}
                            <th width="10%" class="text-center">{{ __('hyper.home_place_an_order') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classify['products'] as $product)
                        <tr class="product-pc">
                            <td class="d-none">{{ $classify['name'] }}-{{ $product['pd_name'] }}</td>
                            <td>
                                {{-- 商品名称 --}}
                                @if($product['in_stock'] > 0)
                                <a href="{{ url("/buy/{$product['id']}") }}" class="text-body">{{ $product['pd_name'] }}</a>
                                @else
                                <div class="text-body" style="cursor: no-drop;">{{ $product['pd_name'] }}</div>
                                @endif
                                @if($product['wholesale_price'])
                                    {{-- 折扣 --}}
                                    <span class="badge badge-outline-warning">{{ __('hyper.home_discount') }}</span>
                                   @endif
                            </td>
                            <td>
                                @if($product['pd_type'] == 1)
                                    {{-- 自动发货 --}}
                                    <span class="badge badge-outline-primary">{{ __('hyper.home_automatic_delivery') }}</span>
                                @else
                                    {{-- 人工发货 --}}
                                    <span class="badge badge-outline-danger">{{ __('hyper.home_charge') }}</span>
                                @endif
                            </td>
                            {{-- 库存 --}}
                            <td>{{ $product['in_stock'] }}</td>
                            {{-- 价格 --}}
                            <td>¥<b>{{ $product['actual_price'] }}</b></td>
                            <td class="text-center">
                                @if($product['in_stock'] > 0)
                                    {{-- 购买 --}}
                                    <a class="btn btn-outline-primary" href="{{ url("/buy/{$product['id']}") }}">{{ __('hyper.home_buy') }}</a>
                                @else
                                    {{-- 售罄 --}}
                                    <a class="btn btn-outline-secondary disabled" href="javascript:void(0);">{{ __('hyper.home_sell_out') }}</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="d-block d-md-none">
    @foreach($classifys as $classify)
    <div class="row category-sj">
        <div class="col-md-12">
            <h3>
                {{-- 分类名称 --}}
                <span class="badge badge-info">{{ $classify['name'] }}</span>
            </h3>
        </div>
        @foreach($classify['products'] as $product)
        <div class="col-md-3 col-sm-6 product-sj">
            <span class="d-none">{{ $classify['name'] }}-{{ $product['pd_name'] }}</span>
            @if($product['in_stock'] > 0)
            <a class="box" href="{{ url("/buy/{$product['id']}") }}">
                <div class="card">
            @else
            <a class="box" href="javascript:void(0);">
                <div class="card border-danger border">
            @endif
                    <div class="card-body">
                        {{-- 商品名称 --}}
                        <h4 class="card-title">{{ $product['pd_name'] }}</h4>
                        <p>
                            @if($product['pd_type'] == 1)
                                {{-- 自动发货 --}}
                                <span class="badge badge-outline-primary">{{ __('hyper.home_automatic_delivery') }}</span>
                            @else
                                {{-- 人工发货 --}}
                                <span class="badge badge-outline-danger">{{ __('hyper.home_charge') }}</span>
                            @endif
                            @if($product['wholesale_price'])
                                {{-- 折扣 --}}
                                <span class="badge badge-outline-warning">{{ __('hyper.home_discount') }}</span>
                            @endif
                        </p>
                        {{-- 库存 --}}
                        <div class="float-right">{{ __('hyper.home_in_stock') }}({{ $product['in_stock'] }})</div>
                        <p class="card-text">
                            {{-- 价格 --}}
                            <span>¥<b>{{ $product['actual_price'] }}</b><span>
                        </p>
                    </div>
                </div>
            </a>
        </div> <!-- end col -->
        @endforeach
    </div> <!-- end row-->
    @endforeach
</div>
<script src="/assets/style/js/jquery-3.4.1.min.js"></script>
<script>
    $("#search_pc").on("input",function(e){
        var txt_pc = $("#search_pc").val();
        if($.trim(txt_pc)!="") {
            $(".category-pc").hide().filter(":contains('"+txt_pc+"')").show();
            $(".product-pc").hide().filter(":contains('"+txt_pc+"')").show();
        } else {
            $(".category-pc").show();
            $(".product-pc").show();
        }
    });
    $("#search_sj").on("input",function(e){
        var txt_sj = $("#search_sj").val();
        if($.trim(txt_sj)!="") {
            $(".category-sj").hide().filter(":contains('"+txt_sj+"')").show();
            $(".product-sj").hide().filter(":contains('"+txt_sj+"')").show();
        } else {
            $(".category-sj").show();
            $(".product-sj").show();
        }
    });
</script>
@stop