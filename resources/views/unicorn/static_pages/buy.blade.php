@extends('unicorn.layouts.seo')
@section('content')
    <!-- main start -->
    <section class="main-container">
        <div class="container">
            <div class="good-card">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8">
                        <div class="card mt-3">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src="{{ picture_ulr($picture) }}"
                                         class="card-img-top p-5" alt="{{ $gd_name }}">
                                    @if($type == \App\Models\Goods::AUTOMATIC_DELIVERY)
                                        <h6><small class="badge bg-success  position-absolute top-0 start-0">
                                                <i class="ali-icon">&#xe7db;</i>
                                                {{ __('goods.fields.automatic_delivery') }}</small>

                                        </h6>
                                    @else
                                        <h6>
                                            <small class="badge bg-warning  position-absolute top-0 start-0">
                                                <i class="ali-icon">&#xe7db;</i>
                                                {{ __('goods.fields.manual_processing') }}
                                            </small>
                                        </h6>
                                    @endif

                                </div>
                                <div class="col-md-8">
                                    <div class="card-body p-4">
                                        <h3 class="card-title">{{ $gd_name }}</h3>
                                        <h6>
                                            <small class="text-muted">{{__('goods.fields.in_stock')}}：{{ $in_stock }}</small>
                                        </h6>
                                        @if($buy_limit_num > 0)
                                            <h6><small class="badge bg-danger">
                                                    {{__('dujiaoka.purchase_limit')}}({{ $buy_limit_num }})</small>
                                            </h6>
                                        @endif
                                        @if(!empty($wholesale_price_cnf) && is_array($wholesale_price_cnf))
                                            <div class="sale">
                                                @foreach($wholesale_price_cnf as $ws)
                                                    <span class="badge bg-dark mt-1 mb-1">
                                                     <i class="ali-icon">&#xe77d;</i>
                                                    {{ __('dujiaoka.by_amount') }}{{ $ws['number'] }}{{ __('dujiaoka.or_the_above') }},{{ __('dujiaoka.each') }}：{{ $ws['price']  }}{{ __('dujiaoka.money_symbol') }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="buy-form mt-3">
                                            <form  action="{{ url('create-order') }}" method="post">
                                                {{ csrf_field() }}
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <h6>{{ __('dujiaoka.price') }}：{{ __('dujiaoka.money_symbol') }} {{ $actual_price }}</h6>
                                                    </div>
                                                    <div class="col-12 gomypay-notice" style="display: none;">
                                                        <div class="alert alert-danger" role="alert">
                                                            {{ __('dujiaoka.gomypay.order_number_notice') }}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-md-6">
                                                        <input type="hidden" name="gid" value="{{ $id }}">
                                                        <label for="email" class=" col-form-label">{{ __('dujiaoka.email') }}:</label>
                                                        <input type="email" class="form-control form-control-sm"
                                                               name="email" id="email" required placeholder="{{ __('dujiaoka.email') }}">
                                                    </div>
                                                    <div class="col-xs-12 col-md-4">
                                                        <label for="shop-number"
                                                               class="col-form-label">{{ __('dujiaoka.by_amount') }}:</label>
                                                        <input type="number" class="form-control form-control-sm"
                                                               id="shop-number" name="by_amount" placeholder="" min="1" value="1">
                                                    </div>
                                                    @if(isset($open_coupon))
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="coupon" class="col-form-label">{{ __('dujiaoka.coupon_code') }}:</label>
                                                            <input type="text"
                                                                   class=" control form-control form-control-sm"
                                                                   id="coupon" name="coupon_code"   placeholder="" value="" >
                                                        </div>
                                                    @endif
                                                    @if(dujiaoka_config_get('is_open_search_pwd') == \App\Models\Goods::STATUS_OPEN)
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="search_pwd" class="col-form-label">{{ __('dujiaoka.search_password') }}:</label>
                                                            <input type="text"
                                                                   class=" control form-control form-control-sm"
                                                                   id="search_pwd" name="search_pwd" required  placeholder="" value="" >
                                                        </div>
                                                    @endif

                                                    @if(dujiaoka_config_get('is_open_img_code') == \App\Models\Goods::STATUS_OPEN)
                                                        <div class="col-12 col-md-6">
                                                            <label for="verifyCode" class=" col-form-label">{{ __('dujiaoka.img_verify_code') }}:</label>
                                                            <div class="input-group">
                                                                <input type="text" name="img_verify_code" class="form-control form-control-sm"
                                                                       id="verifyCode" required placeholder="">
                                                                <img style="margin-left: 10px;" src="{{ captcha_src('buy') . time() }}"
                                                                     height="33px" alt="{{ __('dujiaoka.img_verify_code') }}"  onclick="refresh()" id="imageCode">
                                                                <script>
                                                                    function refresh(){
                                                                        $('#imageCode').attr('src','{{ captcha_src('buy') }}'+Math.random());
                                                                    }
                                                                </script>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="form-group row">
                                                    @if($type == \App\Models\Goods::MANUAL_PROCESSING && is_array($other_ipu))
                                                        @foreach($other_ipu as $ipu)
                                                            <div class="col-xs-12 col-md-6">
                                                                <label for="{{ $ipu['field'] }}" class="col-form-label">{{ $ipu['desc'] }}:</label>
                                                                <input type="text"
                                                                       class=" control form-control form-control-sm"
                                                                       id="{{ $ipu['field'] }}" name="{{ $ipu['field'] }}"  @if($ipu['rule'] !== false) required @endif placeholder="{{ $ipu['placeholder'] }}">
                                                            </div>
                                                        @endforeach

                                                    @endif
                                                        <div class="col-12">
                                                            <fieldset>
                                                                <label for="coupon" class="col-form-label">{{ __('dujiaoka.payment_method') }}：</label>
                                                                @foreach($payways as $index => $way)
                                                                    <div class="form-check form-check-inline">
                                                                        <label class="form-check-label">
                                                                            <input type="radio" class="form-check-input"
                                                                                   name="payway" value="{{ $way['id'] }}" @if($index == 0) checked="checked" @endif>
                                                                            {{ $way['pay_name'] }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach

                                                            </fieldset>
                                                        </div>
                                                    <div class="col-12 mt-2">
                                                        <button type="submit" id="submit" class="btn btn-outline-primary"> <i
                                                                class="ali-icon">&#xe7d8;</i> {{ __('dujiaoka.order_now') }}</button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row justify-content-center">
                    <div class="col-12 col-md-8">
                        <div class="card mt-3 mb-3">
                            <div class="card-header">
                                <h5>{{ __('goods.fields.description') }}</h5>
                            </div>
                            <div class="card-body">
                                {!! $description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- main end -->
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('goods.fields.buy_prompt') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! $buy_prompt !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('dujiaoka.close') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
@stop
@section('js')
<script src="/assets/unicorn/js/bootstrap-input-spinner.js"></script>
<script>
    // 在最開始就定義 myModal
    var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
    
    @if(!empty($buy_prompt))
    $(function(){
        myModal.show()
    });
    @endif
    
    $("input[type='number']").inputSpinner();
    
    // 监听支付方式选择
    $('input[name="payway"]').change(function() {
        var selectedPayway = $(this).val();
        
        // 先移除之前可能添加的字段和提示
        $('.gomypay-fields').remove();
        $('.gomypay-notice').hide();
        
        // 发送 AJAX 请求到后端
        $.ajax({
            url: '{{ url("check-payway") }}',
            method: 'POST',
            data: {
                payway: selectedPayway,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // 先移除之前可能添加的字段和提示
                $('.gomypay-fields').remove();
                $('.gomypay-notice').hide();
                
                if (response.success && response.pay_check === 'gomypay') {
                    // 顯示訂單編號提示
                    $('.gomypay-notice').show();
                    
                    // 在 email 输入框后面添加名字和手机号码字段
                    var additionalFields = `
                        <div class="col-xs-12 col-md-6 gomypay-fields">
                            <label for="name" class="col-form-label">{{ __('dujiaoka.gomypay.name') }}:</label>
                            <input type="text" 
                                   class="form-control form-control-sm"
                                   name="name" 
                                   id="name" 
                                   required 
                                   placeholder="{{ __('dujiaoka.gomypay.please_input_name') }}">
                        </div>
                        <div class="col-xs-12 col-md-6 gomypay-fields">
                            <label for="phone" class="col-form-label">{{ __('dujiaoka.gomypay.phone') }}:</label>
                            <input type="tel" 
                                   class="form-control form-control-sm"
                                   name="phone" 
                                   id="phone" 
                                   required 
                                   placeholder="{{ __('dujiaoka.gomypay.please_input_phone') }}">
                        </div>
                    `;
                    
                    // 将新字段插入到 email 字段后面
                    $(additionalFields).insertAfter('#email').closest('.col-xs-12.col-md-6');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error checking payway:', error);
            }
        });
    });

    $('#submit').click(function(){
        // 檢查是否存在手機號碼輸入框（即是否為 gomypay 支付）
        if ($('#phone').length > 0) {
            var phoneNumber = $('#phone').val();
            var phoneRegex = /^[0][9]\d{8}$/;
            
            if (!phoneRegex.test(phoneNumber)) {
                $(".modal-body").html("{{ __('dujiaoka.gomypay.phone_format_error') }}")
                myModal.show()
                return false;
            }
        }

        if($("input[name='by_amount']").val() > {{ $in_stock }}){
            {{-- 数量不允许大于库存 --}}
            $(".modal-body").html("{{ __('dujiaoka.prompt.inventory_shortage') }}")
            myModal.show()
            return false;
        }
        @if($buy_limit_num > 0)
        if($("input[name='by_amount']").val() > {{ $buy_limit_num }}){
            {{-- 已超过限购数量 --}}
            $(".modal-body").html("{{ __('dujiaoka.prompt.purchase_limit_exceeded') }}")
            myModal.show()
            return false;
        }
        @endif
    });
</script>

@stop
