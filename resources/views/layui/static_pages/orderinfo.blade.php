@extends('layui.layouts.default')
@section('content')

    <div class="layui-row">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">

            <div class="layui-card cardcon">
                <div class="layui-card-header">{{ __('system.order_details') }}</div>

                @foreach($orders as $order)
                <div class="layui-card-body info-box">
                    <div class="layui-row order-list">

                            <div class="layui-col-md4">
                                <ul class="info-ui">
                                    <li>
                                        <strong>{{ __('system.order_number') }}:</strong>
                                        {{ $order['order_id'] }}
                                    </li>
                                    <li>
                                        <strong>{{ __('system.order_title') }}:</strong>
                                       {{ $order['ord_title'] }}
                                    </li>
                                    <li><strong>{{ __('system.number_of_orders') }}:</strong> {{ $order['buy_amount'] }}</li>
                                    <li><strong>{{ __('system.order_time') }}:</strong> {{ $order['created_at'] }}
                                    </li>
                                    <li><strong>{{ __('system.email') }}:</strong> {{ $order['account'] }}</li>
                                </ul>
                            </div>
                            <div class="layui-col-md4">
                                <ul class="info-ui">
                                    <li><strong>{{ __('system.order_class') }}:</strong>
                                        @if($order['ord_class'] == 1)
                                            <span class="layui-badge layui-bg-green">{{ __('system.automatic_delivery') }}</span>
                                        @else
                                            <span class="layui-badge layui-bg-orange">{{ __('system.charge') }}</span>
                                        @endif
                                    </li>
                                    <li><strong>{{ __('system.total_order_price') }}:</strong> <span class="layui-badge layui-bg-blue">{{ $order['ord_price'] }}</span></li>
                                    <li><strong>{{ __('system.order_status') }}:</strong> <!----> <!---->

                                            @switch($order['ord_status'])
                                                @case(1)
                                                    <span class="layui-badge">{{ __('system.order_pending') }}</span>
                                                    @break
                                                @case(2)
                                                    <span class="layui-badge layui-bg-blue">{{ __('system.order_processed') }}</span>
                                                    @break
                                                @case(3)
                                                    <span class="layui-badge layui-bg-green">{{ __('system.order_completed') }}</span>
                                                 @break
                                                @case(4)
                                                    <span class="layui-badge layui-bg-black">{{ __('system.order_failed') }}</span>
                                                    @break
                                            @endswitch
                                    </li>
                                    <li><strong>{{ __('system.payment_method') }}:</strong> {{ \App\Models\Pays::find($order['pay_way'])->pay_name }}</li>
                                </ul>
                            </div>
                            <div class="layui-col-md4">
                                <div class="order-info">
                                    {!! str_replace(PHP_EOL, '<br/>', $order['ord_info']) !!}
                                </div>
                                <button type="button" class="layui-btn layui-btn-normal" data-clipboard-text="{{ $order['ord_info'] }}" style="width: 100%">{{ __('system.order_copy') }}</button>
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
                layer.msg("{{ __('prompt.copy_success') }}");

            });
            clipboard.on('error', function(e) {
                layer.msg("{{ __('prompt.copy_failed') }}");
            });
        });

    </script>
@stop
