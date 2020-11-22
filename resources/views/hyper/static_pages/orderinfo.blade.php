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
    <span class="badge badge-info"># {{ $order['order_id'] }}</span>
</h2>
<div class="row-list">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-body">
                <div class="mx-auto">
                    {{-- 订单名称 --}}
                    <div class="mb-1"><label>{{ __('hyper.orderinfo_order_title') }}：</label><span>{{ $order['ord_title'] }}</span></div>
                    {{-- 下单数量 --}}
                    <div class="mb-1"><label>{{ __('hyper.orderinfo_number_of_orders') }}：</label><span>{{ $order['buy_amount'] }}</span></div>
                    {{-- 下单时间 --}}
                    <div class="mb-1"><label>{{ __('hyper.orderinfo_order_time') }}：</label><span>{{ $order['created_at'] }}</span></div>
                    {{-- 付款邮箱 --}}
                    <div class="mb-1"><label>{{ __('hyper.orderinfo_email') }}：</label><span>{{ $order['account'] }}</span></div>
                    <div class="mb-1">
                        {{-- 订单类型 --}}
                        <label>{{ __('hyper.orderinfo_order_class') }}：</label>
                        <span>
                            @if($order['ord_class'] == 1)
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
                        <span>{{ $order['ord_price'] }}</span>
                    </div>
                    <div class="mb-1">
                        {{-- 订单状态 --}}
                        <label>{{ __('hyper.orderinfo_order_status') }}：</label>
                        <span>
                            @switch($order['ord_status'])
                                @case(1)
                                    {{-- 待处理 --}}
                                    {{ __('hyper.orderinfo_order_pending') }}
                                @break
                                @case(2)
                                    {{-- 已处理 --}}
                                    {{ __('hyper.orderinfo_order_processed') }}
                                @break
                                @case(3)
                                    {{-- 已完成 --}}
                                    {{ __('hyper.orderinfo_order_completed') }}
                                @break
                                @case(4)
                                    {{-- 已失败 --}}
                                    {{ __('hyper.orderinfo_order_failed') }}
                                @break
                            @endswitch
                        </span>
                    </div>
                    <div class="mb-1">
                        {{-- 支付方式 --}}
                        <label>{{ __('hyper.orderinfo_payment_method') }}：</label>
                        <span>{{ \App\Models\Pays::find($order['pay_way'])->pay_name }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-body">
                <h5 class="card-title">{{ __('hyper.orderinfo_carmi') }}</h5>
                <div class="kami-info">
                    {!! str_replace(PHP_EOL, '<br/>', $order['ord_info']) !!}
                </div>
                <button class="btn btn-info kami-btn" data-clipboard-text="{{ $order['ord_info'] }}">{{ __('hyper.orderinfo_copy_carmi') }}</button>
            </div>
        </div>
    </div>
</div>
@endforeach
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