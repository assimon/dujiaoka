@extends('unicorn.layouts.default')
@section('content')
    <!-- main start -->
    <section class="main-container">
        <div class="container">
            <div class="good-card">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-12">
                        <div class="card m-3">
                            <div class="card-body p-2 text-center">
                                <h3 class="card-title text-primary ali-icon">&#xe832;{{ __('dujiaoka.confirm_order') }}</h3>
                            </div>
                            <div class="card card-body p-3 border-0">
                                <div class="mx-auto">
                                    <h5>
                                        <small class="text-muted">{{ __('order.fields.order_sn') }}：{{ $order_sn }}</small>
                                    </h5>
                                    <div class="mb-1">
                                        <label>{{ __('order.fields.title') }}：</label><span>{{ $title }}</span>
                                    </div>
                                    <div class="mb-1"><label>{{ __('order.fields.goods_price') }}：</label><span> {{ $goods_price }}</span></div>
                                    <div class="mb-1"><label>{{ __('order.fields.buy_amount') }}：</label><span>{{ $buy_amount }}</span></div>
                                    <div class="mb-1"><label>{{ __('order.fields.email') }}：</label><span>{{ $email }}</span></div>
                                    <div class="mb-1">
                                        <label>{{ __('order.fields.type') }}：</label>
                                        @if($type == \App\Models\Order::AUTOMATIC_DELIVERY)
                                            <span class="badge bg-success">{{ __('goods.fields.automatic_delivery') }}</span>
                                        @else
                                            <span class="badge bg-warning">{{ __('goods.fields.manual_processing') }}</span>
                                        @endif
                                    </div>
                                    @if(!empty($coupon))
                                        <div class="mb-1"><label>{{ __('order.fields.coupon_id') }}：</label><span>{{ $coupon['coupon'] }}</span></div>
                                        <div class="mb-1"><label>{{ __('order.fields.coupon_discount_price') }}：</label><span>{{ __('dujiaoka.money_symbol') }}{{ $coupon_discount_price }}</span></div>
                                    @endif
                                    @if($wholesale_discount_price > 0 )
                                        <div class="mb-1"><label>{{ __('order.fields.wholesale_discount_price') }}：</label><span>{{ __('dujiaoka.money_symbol') }}{{ $wholesale_discount_price }}</span></div>
                                    @endif
                                    @if(!empty($info))
                                        <div class="mb-1"><label>{{ __('dujiaoka.order_information') }}：</label><p>{{ $info }}</p></div>
                                    @endif
                                    <div class="mb-1"><label>{{ __('order.fields.actual_price') }}：</label><span>{{ __('dujiaoka.money_symbol') }}{{ $actual_price }}</span></div>
                                    <div class="mb-1"><label>{{ __('dujiaoka.payment_method') }}：</label><span>{{ $pay['pay_name'] }}</span></div>
                                    <div class="mb-1"><label>{{ __('order.fields.order_created') }}：</label><span>{{ $created_at }}</span></div>

                                    <div class="pay-now text-center mt-3">
                                        <a href="{{ url('pay-gateway', ['handle' => urlencode($pay['pay_handleroute']),'payway' => $pay['pay_check'], 'orderSN' => $order_sn]) }}" type="button" class="btn btn-dark"><i class="ali-icon">&#xe673;</i>
                                            {{ __('dujiaoka.pay_immediately') }}
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- main end -->
@stop
@section('js')
@stop
