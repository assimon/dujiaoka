@extends('unicorn.layouts.default')
@section('content')
    <div class="notice" >
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="jumbotron jumbotron-fluid p-1">
                                <div class="container">
                                    <h4 class="">{{ __('dujiaoka.site_announcement') }}：</h4>
                                    <p class="lead">{!! dujiaoka_config_get('notice') !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- main start -->
    <section class="main-container">
        <!-- category start -->
        <div class="category">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">
                                <span style="vertical-align: inherit;">
                                    {{ __('dujiaoka.equipment.what_do_you_need_today') }}
                                </span>
                        </h3>
                        <div class="separator"></div>
                        <p class="lead text-center">
                                <span style="vertical-align: inherit;">
                                    {{ __('dujiaoka.equipment.self_promotion') }}
                                </span>
                        </p>
                    </div>
                    <div class="col-md-12">
                        <div class="category-menus">
                                <ul class="nav nav-pills  justify-content-center">
                                    <li class="nav-item">
                                        <a href="#group-all" data-bs-toggle="tab" class="btn btn-outline-secondary active">{{ __('dujiaoka.group_all') }}</a>
                                    </li>
                                    @foreach($data as  $index => $group)
                                        <li class="nav-item">
                                            <a href="#group-{{ $group['id'] }}" data-bs-toggle="tab" class="btn btn-outline-secondary">{{ $group['gp_name'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!-- category end -->
        <!-- goods start -->
        <div class="goods">
            <div class="container">
                <div class="goods-list mb-5">
                    <div id="goodsTabContent" class="tab-content">

                        <div class="tab-pane fade active show" id="group-all">
                            <div class="row row-cols-2 row-cols-md-5 g-4">
                                @foreach($data as  $index => $group)
                                    @foreach($group['goods'] as $goods)
                                        <div class="col">
                                            <div class="card position-relative">
                                                @if($goods['type'] == \App\Models\Goods::AUTOMATIC_DELIVERY)
                                                    <span class="badge bg-success position-absolute top-0 start-0">
                                            <i class="ali-icon">&#xe7db;</i>
                                            {{ __('goods.fields.automatic_delivery') }}
                                        </span>
                                                @else
                                                    <span class="badge bg-warning position-absolute top-0 start-0">
                                                        <i class="ali-icon">&#xe74b;</i>
                                                        {{ __('goods.fields.manual_processing') }}
                                                    </span>
                                                @endif
                                                <img src="{{ picture_ulr($goods['picture']) }}" class="card-img-top" alt="{{ $goods['gd_name'] }}">
                                                <div class="card-body">

                                                    <h6 class="card-title text-truncate">
                                                        {{ $goods['gd_name'] }}
                                                    </h6>

                                                    <button type="button" class="btn btn-sm btn-outline-success">
                                                        <i class="ali-icon">&#xe703;</i>
                                                        <strong>{{ $goods['actual_price'] }}</strong>
                                                    </button>
                                                    @if($goods['wholesale_price_cnf'])
                                                        <button type="button" class="btn btn-sm btn-outline-warning">
                                                            <i class="ali-icon">&#xe77d;</i>
                                                            {{ __('dujiaoka.home_discount') }}
                                                        </button>
                                                    @endif
                                                    <h6 class="mt-2"><small class="text-muted">{{__('goods.fields.in_stock')}}：{{ $goods['in_stock'] }}</small></h6>
                                                    <a href="{{ url("/buy/{$goods['id']}") }}" class="btn btn-primary fr">
                                                        <i class="ali-icon">&#xe7d8;</i>
                                                        {{ __('dujiaoka.order_now') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                 @endforeach
                            </div>
                        </div>



                        @foreach($data as  $index => $group)
                            <div class="tab-pane fade" id="group-{{ $group['id'] }}">
                                <div class="row row-cols-2 row-cols-md-5 g-4">
                                    @foreach($group['goods'] as $goods)
                                        <div class="col">
                                            <div class="card position-relative">
                                                @if($goods['type'] == \App\Models\Goods::AUTOMATIC_DELIVERY)
                                                    <span class="badge bg-success position-absolute top-0 start-0">
                                            <i class="ali-icon">&#xe7db;</i>
                                            {{ __('goods.fields.automatic_delivery') }}
                                        </span>
                                                @else
                                                    <span class="badge bg-warning position-absolute top-0 start-0">
                                        <i class="ali-icon">&#xe74b;</i>
                                        {{ __('goods.fields.manual_processing') }}
                                    </span>
                                                @endif
                                                <img src="{{ picture_ulr($goods['picture']) }}" class="card-img-top" alt="{{ $goods['gd_name'] }}">
                                                <div class="card-body">

                                                    <h6 class="card-title text-truncate">
                                                        {{ $goods['gd_name'] }}
                                                    </h6>

                                                        <button type="button" class="btn btn-sm btn-outline-success">
                                                            <i class="ali-icon">&#xe703;</i>
                                                            <strong>{{ $goods['actual_price'] }}</strong>
                                                        </button>
                                                        @if($goods['wholesale_price_cnf'])
                                                            <button type="button" class="btn btn-sm btn-outline-warning">
                                                                <i class="ali-icon">&#xe77d;</i>
                                                                {{ __('dujiaoka.home_discount') }}
                                                            </button>
                                                        @endif
                                                    <h6 class="mt-2"><small class="text-muted">{{__('goods.fields.in_stock')}}：{{ $goods['in_stock'] }}</small></h6>
                                                    <a href="{{ url("/buy/{$goods['id']}") }}" class="btn btn-primary fr">
                                                        <i class="ali-icon">&#xe7d8;</i>
                                                        {{ __('dujiaoka.order_now') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
        <!-- goods end -->

    </section>
    <!-- main end -->

@stop

@section('js')
    <script>
        $("#searchBtn").on("click",function(e){
            var search_content = $("#searchText").val();
            //var search_content = search_content.toLowerCase();
            if($.trim(search_content)!="") {
                console.log($.trim(search_content));
                $(".col").hide().filter(":contains('"+search_content+"')").show();
            } else {
                $(".col").show();
            }
        });
    </script>
@stop
