@extends('hyper.layouts.default')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            {{-- 订单详情 --}}
            <h4 class="page-title">{{ __('hyper.orderinfo_title') }}</h4>
        </div>
    </div>
</div>
@foreach($orders as $order)
<h2>
    <span class="badge badge-info"># {{ $order['order_sn'] }}</span>
</h2>
<div class="row-list">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-body">
                <div class="mx-auto">
                    {{-- 订单名称 --}}
                    <div class="mb-1"><label>{{ __('hyper.orderinfo_order_title') }}：</label><span>{{ $order['title'] }}</span></div>
                    {{-- 下单数量 --}}
                    <div class="mb-1"><label>{{ __('hyper.orderinfo_number_of_orders') }}：</label><span>{{ $order['buy_amount'] }}</span></div>
                    {{-- 下单时间 --}}
                    <div class="mb-1"><label>{{ __('hyper.orderinfo_order_time') }}：</label><span>{{ $order['created_at'] }}</span></div>
                    {{-- 付款邮箱 --}}
                    <div class="mb-1"><label>{{ __('hyper.orderinfo_email') }}：</label><span>{{ $order['email'] }}</span></div>
                    <div class="mb-1">
                        {{-- 订单类型 --}}
                        <label>{{ __('hyper.orderinfo_order_class') }}：</label>
                        <span>
                            @if($order['type'] == \App\Models\Order::AUTOMATIC_DELIVERY)
                                {{-- 自动发货 --}}
                                {{ __('hyper.orderinfo_automatic_delivery') }}
                            @else
                                {{-- 人工发货 --}}
                                {{ __('hyper.orderinfo_charge') }}
                            @endif
                        </span>
                    </div>
                    <div class="mb-1">
                        {{-- 订单总价 --}}
                        <label>{{ __('hyper.orderinfo_total_order_price') }}：</label>
                        <span>{{ $order['actual_price'] }}</span>
                    </div>
                    <div class="mb-1">
                        {{-- 订单状态 --}}
                        <label>{{ __('hyper.orderinfo_order_status') }}：</label>
                        <span>
                            @switch($order['status'])
                                @case(\App\Models\Order::STATUS_EXPIRED)
                                    {{-- 已过期 --}}
                                    {{ __('hyper.orderinfo_status_expired') }}
                                @break
                                @case(\App\Models\Order::STATUS_WAIT_PAY)
                                    {{-- 待支付 --}}
                                    {{ __('hyper.orderinfo_status_wait_pay') }}
                                @break
                                @case(\App\Models\Order::STATUS_PENDING)
                                    {{-- 待处理 --}}
                                    {{ __('hyper.orderinfo_status_pending') }}
                                @break
                                @case(\App\Models\Order::STATUS_PROCESSING)
                                    {{-- 已处理 --}}
                                    {{ __('hyper.orderinfo_status_processed') }}
                                @break
                                @case(\App\Models\Order::STATUS_COMPLETED)
                                    {{-- 已完成 --}}
                                    {{ __('hyper.orderinfo_status_completed') }}
                                @break
                                @case(\App\Models\Order::STATUS_FAILURE)
                                    {{-- 已失败 --}}
                                    {{ __('hyper.orderinfo_status_failed') }}
                                @break
                                @case(\App\Models\Order::STATUS_FAILURE)
                                    {{-- 状态异常 --}}
                                    {{ __('hyper.orderinfo_status_abnormal') }}
                                @break
                            @endswitch
                        </span>
                    </div>
                    <div class="mb-1">
                        {{-- 支付方式 --}}
                        <label>{{ __('hyper.orderinfo_payment_method') }}：</label>
                        <span>{{ $order['pay']['pay_name'] ?? ''  }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-body">
                <h5 class="card-title">{{ __('hyper.orderinfo_carmi') }}</h5>
                <div class="kami-info">
                    {{$order['info']}}
                </div>
                <button class="btn btn-info kami-btn" data-clipboard-text="{{$order['info']}}">{{ __('hyper.orderinfo_copy_carmi') }}</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@if(!count($orders))
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="text-center">
                <h1 class="text-error mt-4">error</h1>
                <h4 class="text-uppercase text-danger mt-3">{{ __('hyper.orderinfo_order_information') }}</h4>
                <a class="btn btn-info mt-3" href="javascript:history.back(-1);"><i class="mdi mdi-reply"></i> {{ __('hyper.error_back_btn') }}</a>
            </div> <!-- end /.text-center-->
        </div> <!-- end col-->
    </div>
@endif
@stop

@section('tpljs')
<script src="/assets/hyper/js/clipboard.min.js"></script>
<script>
    var clipboard = new ClipboardJS('.kami-btn');
    clipboard.on('success', function(e){
        $.NotificationApp.send("{{ __('hyper.orderinfo_tips') }}","{{ __('hyper.orderinfo_copy_success') }}","bottom-right","rgba(0,0,0,0.2)","info");
    });
    clipboard.on('error', function(e){
        $.NotificationApp.send("{{ __('hyper.orderinfo_tips') }}","{{ __('hyper.orderinfo_copy_error') }}","bottom-right","rgba(0,0,0,0.2)","error");
    });
</script>
@stop
