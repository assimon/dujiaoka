@extends('choice.layouts.default')
@section('content')

    <div class="layui-row">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">

            <div class="layui-card cardcon">
                <div class="layui-card-header">订单详情</div>

                @foreach($orders as $order)
                <div class="layui-card-body info-box">
                    <div class="layui-row order-list">

                            <div class="layui-col-md4">
                                <ul class="info-ui">
                                    <li>
                                        <strong>订单号:</strong>
                                        {{ $order['order_id'] }}
                                    </li>
                                    <li>
                                        <strong>订单名称:</strong>
                                       {{ $order['ord_title'] }}
                                    </li>
                                    <li><strong>下单数量:</strong> {{ $order['buy_amount'] }}</li>
                                    <li><strong>下单时间:</strong> {{ $order['created_at'] }}
                                    </li>
                                    <li><strong>付款邮箱:</strong> {{ $order['account'] }}</li>
                                </ul>
                            </div>
                            <div class="layui-col-md4">
                                <ul class="info-ui">
                                    <li><strong>订单类型:</strong>
                                        @if($order['ord_class'] == 1)
                                            <span class="layui-badge layui-bg-green">自动发货</span>
                                        @else
                                            <span class="layui-badge layui-bg-orange">代充</span>
                                        @endif
                                    </li>
                                    <li><strong>订单总价:</strong>  <span class="layui-badge layui-bg-blue">{{ $order['ord_price'] }}</span></li>
                                    <li><strong> 状态:</strong> <!----> <!---->

                                            @switch($order['ord_status'])
                                                @case(1)
                                                    <span class="layui-badge">待处理</span>
                                                    @break
                                                @case(2)
                                                    <span class="layui-badge layui-bg-blue">已处理</span>
                                                    @break
                                                @case(3)
                                                    <span class="layui-badge layui-bg-green">已完成</span>
                                                 @break
                                                @case(4)
                                                    <span class="layui-badge layui-bg-black">已失败</span>
                                                    @break
                                            @endswitch
                                    </li>
                                    <li><strong>支付方式:</strong> {{ \App\Models\Pays::find($order['pay_way'])->pay_name }}</li>
                                </ul>
                            </div>
                            <div class="layui-col-md4">
                                <div class="order-info">
                                    {!! str_replace(PHP_EOL, '<br/>', $order['ord_info']) !!}
                                </div>
                                <button type="button"  class="layui-btn layui-btn-normal" data-clipboard-text="{{ $order['ord_info'] }}" style="width: 100%">复制</button>
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
                layer.msg('复制成功');

            });
            clipboard.on('error', function(e) {
                layer.msg('复制失败');
            });
        });

    </script>
@stop
