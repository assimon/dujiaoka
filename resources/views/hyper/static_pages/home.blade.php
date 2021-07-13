@extends('hyper.layouts.default')
@section('notice')
    @include('hyper.layouts._notice')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="home-page-title-right">
                    <div class="app-search">
                        <div class="position-relative">
                            <input type="text" class="form-control" id="search" placeholder="{{ __('hyper.home_search_box') }}">
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
@foreach($data as $group)
    <div class="category">
        <div class="row">
            <div class="col-md-12">
                <h3>
                    {{-- 分类名称 --}}
                    <span class="badge badge-info">{{ $group['gp_name'] }}</span>
                </h3>
            </div>
        </div>
        <div class="row">
            @foreach($group['goods'] as $goods)
                <div class="col-6 col-md-6 col-lg-3 product">
                    @if($goods['in_stock'] > 0)
                        <a class="box" href="{{ url("/buy/{$goods['id']}") }}">
                            @else

                                <a class="box ribbon-box" href="javascript:void(0);">
                                    <div class="ribbon-two ribbon-two-danger"><span>{{ __('hyper.home_sell_out') }}</span></div>
                                    @endif
                                    <div class="img-badge">
                            <span class="badge badge-outline-primary">
                                @if($goods['type'] == \App\Models\Goods::AUTOMATIC_DELIVERY)
                                    {{-- 自动发货 --}}
                                    {{ __('hyper.home_automatic_delivery') }}
                                @else
                                    {{-- 人工发货 --}}
                                    {{ __('hyper.home_charge') }}
                                @endif
                            </span>
                                    </div>
                                    <div class="img-box">
                                        <img src="{{ picture_ulr($goods['picture']) }}" class="shop-img">
                                    </div>
                                    <div class="shop-type">
                                        {{-- 商品名称 --}}
                                        <p class="shop-name text-truncate">{{ $goods['gd_name'] }}</p>
                                        <div class="shop-center">
                                            {{-- 价格 --}}
                                            <span class="shop-price">{{ __('hyper.global_currency') }}{{ $goods['actual_price'] }}</span>
                                            @if($goods['wholesale_price_cnf'])
                                                {{-- 折扣 --}}
                                                <span class="hyper-badge" style="margin-left: auto;">{{ __('hyper.home_discount') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                </div> <!-- end col -->
            @endforeach
        </div>
    </div>
@endforeach


<script src="/assets/style/js/jquery-3.4.1.min.js"></script>
<script>
    $("#search").on("input",function(e){
        var search_content = $("#search").val();
        //var search_content = search_content.toLowerCase();
        if($.trim(search_content)!="") {
            console.log($.trim(search_content));
            $(".category").hide().filter(":contains('"+search_content+"')").show();
            $(".product").hide().filter(":contains('"+search_content+"')").show();
        } else {
            $(".category").show();
            $(".product").show();
        }
    });
</script>
@stop
