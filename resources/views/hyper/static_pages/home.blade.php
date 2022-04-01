@extends('hyper.layouts.default')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <div class="app-search">
                    <div class="position-relative">
                        <input type="text" class="form-control" id="search" placeholder="{{ __('hyper.home_search_box') }}">
                        <span class="uil-search"></span>
                    </div>
                </div>
            </div>
            <h4 class="page-title">
                <button type="button" class="btn btn-outline-primary ml-1" id="notice-open">
                    <i class="uil-comment-alt-notes me-1"></i>
                    {{-- 公告 --}}
                    {{ __('hyper.notice_announcement') }}
                </button>
            </h4>
        </div>
    </div>
</div>
<div class="nav nav-list">
    <a href="#group-all" class="tab-link active" data-bs-toggle="tab" aria-expanded="false" role="tab" data-toggle="tab">
        <span class="tab-title">
        {{-- 全部 --}}
        {{ __('hyper.home_whole') }}
        </span>
        <div class="img-checkmark">
            <img src="/assets/hyper/images/check.png">
        </div>
    </a>
    @foreach($data as  $index => $group)
    <a href="#group-{{ $group['id'] }}" class="tab-link" data-bs-toggle="tab" aria-expanded="false" role="tab" data-toggle="tab">
        <span class="tab-title">
            {{ $group['gp_name'] }}
        </span>
        <div class="img-checkmark">
            <img src="/assets/hyper/images/check.png">
        </div>
    </a>
    @endforeach
</div>
<div class="tab-content">
    <div class="tab-pane active" id="group-all">
        <div class="hyper-wrapper">
            @foreach($data as $group)
                @foreach($group['goods'] as $goods)
                    @if($goods['in_stock'] > 0)
                    <a href="{{ url("/buy/{$goods['id']}") }}" class="home-card category">
                    @else
                    <a href="javascript:void(0);" onclick="sell_out_tip()" class="home-card category ribbon-box">
                        <div class="ribbon-two ribbon-two-primary">
                            {{-- 缺货 --}}
                            <span>{{ __('hyper.home_out_of_stock') }}</span>
                        </div>
                    @endif
                        <img class="home-img" src="/assets/hyper/images/loading.gif" data-src="{{ picture_ulr($goods['picture']) }}">
                        <div class="flex">
                            <p class="name">
                                {{ $goods['gd_name'] }}
                            </p>
                            <div class="price">
                                {{ __('hyper.global_currency') }}<b>{{ $goods['actual_price'] }}</b>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endforeach
        </div>
    </div>
    @foreach($data as  $index => $group)
        <div class="tab-pane" id="group-{{ $group['id'] }}">
            <div class="hyper-wrapper">
                @foreach($group['goods'] as $goods)
                    @if($goods['in_stock'] > 0)
                    <a href="{{ url("/buy/{$goods['id']}") }}" class="home-card category">
                    @else
                    <a href="javascript:void(0);" onclick="sell_out_tip()" class="home-card category ribbon-box">
                        <div class="ribbon-two ribbon-two-primary">
                            {{-- 售罄 --}}
                            <span>{{ __('hyper.home_sell_out') }}</span>
                        </div>
                    @endif
                        <img class="home-img" src="/assets/hyper/images/loading.gif" data-src="{{ picture_ulr($goods['picture']) }}">
                        <div class="flex">
                            <p class="name">
                                {{ $goods['gd_name'] }}
                            </p>
                            <div class="price">
                                {{ __('hyper.global_currency') }}<b>{{ $goods['actual_price'] }}</b>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
<div class="modal fade" id="notice-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myCenterModalLabel">{{ __('hyper.notice_announcement') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                {!! dujiaoka_config_get('notice') !!}
            </div>
        </div>
    </div>
</div>
@stop 
@section('js')
<script>
    $('#notice-open').click(function() {
        $('#notice-modal').modal();
    });
    $("#search").on("input",function(e){
        var txt = $("#search").val();
        if($.trim(txt)!="") {
            $(".category").hide().filter(":contains('"+txt+"')").show();
        } else {
            $(".category").show();
        }
    });
    function sell_out_tip() {
        $.NotificationApp.send("{{ __('hyper.home_tip') }}","{{ __('hyper.home_sell_out_tip') }}","top-center","rgba(0,0,0,0.2)","info");
    }
</script>
@stop