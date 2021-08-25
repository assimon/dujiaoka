@extends('layui.layouts.default')
@section('content')

    <div class="layui-row">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">

            <div class="layui-card cardcon">
                <div class="layui-card-header">{{ __('order.fields.order_detail') }}</div>

                @foreach($orders as $order)
                <div class="layui-card-body info-box">
                    <div class="layui-row order-list">

                            <div class="layui-col-md4">
                                <ul class="info-ui">
                                    <li>
                                        <strong>{{ __('order.fields.order_sn') }}:</strong>
                                        {{ $order['order_sn'] }}
                                    </li>
                                    <li>
                                        <strong>{{ __('order.fields.title') }}:</strong>
                                       {{ $order['title'] }}
                                    </li>
                                    <li><strong>{{ __('order.fields.buy_amount') }}:</strong> {{ $order['buy_amount'] }}</li>
                                    <li><strong>{{ __('order.fields.order_created') }}:</strong> {{ $order['created_at'] }}
                                    </li>
                                    <li><strong>{{ __('order.fields.email') }}:</strong> {{ $order['email'] }}</li>
                                </ul>
                            </div>
                            <div class="layui-col-md4">
                                <ul class="info-ui">
                                    <li><strong>{{ __('order.fields.type') }}:</strong>
                                        @if($order['type'] == \App\Models\Order::AUTOMATIC_DELIVERY)
                                            <span class="layui-badge layui-bg-green">{{ __('goods.fields.automatic_delivery') }}</span>
                                        @else
                                            <span class="layui-badge layui-bg-orange">{{ __('goods.fields.manual_processing') }}</span>
                                        @endif
                                    </li>
                                    <li><strong>{{ __('order.fields.actual_price') }}:</strong>  <span class="layui-badge layui-bg-blue">{{ $order['actual_price'] }}</span></li>
                                    <li><strong>{{ __('order.fields.status') }}:</strong> <!----> <!---->

                                            @switch($order['status'])
                                                @case(\App\Models\Order::STATUS_EXPIRED)
                                                    <span class="layui-badge layui-bg-cyan">{{ __('order.fields.status_expired') }}</span>
                                                    @break
                                                @case(\App\Models\Order::STATUS_WAIT_PAY)
                                                    <span class="layui-badge layui-bg-blue">{{ __('order.fields.status_wait_pay') }}</span>
                                                    @break
                                                @case(\App\Models\Order::STATUS_PENDING)
                                                    <span class="layui-badge layui-bg-green">{{ __('order.fields.status_pending') }}</span>
                                                 @break
                                                @case(\App\Models\Order::STATUS_PROCESSING)
                                                    <span class="layui-badge layui-bg-green">{{ __('order.fields.status_processing') }}</span>
                                                @break
                                                @case(\App\Models\Order::STATUS_COMPLETED)
                                                    <span class="layui-badge layui-bg-green">{{ __('order.fields.status_completed') }}</span>
                                                @break
                                                @case(\App\Models\Order::STATUS_FAILURE)
                                                    <span class="layui-badge layui-bg-black">{{ __('order.fields.status_failure') }}</span>
                                                    @break
                                                @case(\App\Models\Order::STATUS_ABNORMAL)
                                                    <span class="layui-badge layui-bg-black">{{ __('order.fields.status_abnormal') }}</span>
                                                @break
                                            @endswitch
                                    </li>
                                    <li><strong>{{ __('dujiaoka.payment_method') }}:</strong> {{ $order['pay']['pay_name'] ?? ''  }}</li>
                                </ul>
                            </div>
                            <div class="layui-col-md4">
                                <div class="order-info">
                                    {{ str_replace(PHP_EOL, '<br/>', $order['info']) }}
                                </div>
                                <button type="button"  class="layui-btn layui-btn-normal" data-clipboard-text="{{str_replace(PHP_EOL, '<br/>', $order['info'])}}" style="width: 100%">{{ __('dujiaoka.copy_text') }}</button>
                            </div>
                        </div>
                </div>
            @endforeach



            </div>

        </div>
    </div>


@stop

@section('tpljs')
    <script>

        layui.use('layer', function(){
            var layer = layui.layer //获得layer模块
            var clipboard = new ClipboardJS('.layui-btn');
            clipboard.on('success', function(e) {
                layer.msg("{{ __('dujiaoka.prompt.copy_text_success') }}");

            });
            clipboard.on('error', function(e) {
                layer.msg("{{ __('dujiaoka.prompt.copy_text_failed') }}");
            });
        });

    </script>
@stop
