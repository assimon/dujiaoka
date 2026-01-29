@extends('unicorn.layouts.default')
@section('content')
    <!-- main start -->
    <section class="main-container">
        <div class="container">
            <div class="good-card">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-12">
                        <div class="card m-3">
                            <div class="card-body p-4">
                                <h3 class="card-title">{{ __('dujiaoka.order_search') }}</h3>
                                <h6>
                                    <small class="text-muted">{{ __('dujiaoka.prompt.search_order_browser_tips') }}</small>
                                </h6>
                                <div class="buy-form mt-3">
                                    <ul class="nav nav-pills mb-3">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#order_search_by_sn">{{ __('dujiaoka.order_search_by_sn') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#order_search_by_email">{{ __('dujiaoka.order_search_by_email') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#order_search_by_browser">{{ __('dujiaoka.order_search_by_browser') }}</a>
                                        </li>

                                    </ul>
                                    <div id="searchTabContent" class="tab-content">
                                        <div class="tab-pane fade active show" id="order_search_by_sn">
                                            <form action="{{ url('search-order-by-sn') }}" method="post" >
                                                {{ csrf_field() }}
                                                <div class="form-group row">
                                                    <div class="col-12 col-md-8">
                                                        <label for="orderSN" class="col-form-label">{{ __('order.fields.order_sn') }}:</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                               id="orderSN"  name="order_sn" required placeholder="{{ __('order.fields.order_sn') }}">
                                                    </div>
                                                    <div class="col-12 mt-3">
                                                        <button type="submit" class="btn btn-outline-primary">
                                                            <i class="ali-icon">&#xe65c;</i> {{ __('dujiaoka.search_now') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="order_search_by_email">
                                            <form  action="{{ url('search-order-by-email') }}" method="post">
                                                {{ csrf_field() }}
                                                <div class="form-group row">
                                                    <div class="col-12 col-md-8">
                                                        <label for="email" class="col-form-label">{{ __('order.fields.email') }}:</label>
                                                        <input type="email" class="form-control form-control-sm"
                                                               id="email" name="email" required placeholder="">
                                                    </div>
                                                    @if(dujiaoka_config_get('is_open_search_pwd', \App\Models\BaseModel::STATUS_CLOSE) == \App\Models\BaseModel::STATUS_OPEN)
                                                        <div class="col-12 col-md-8">
                                                            <label for="searchPwd" class="col-form-label">{{ __('order.fields.search_pwd') }}:</label>
                                                            <input type="password" class="form-control form-control-sm"
                                                                   id="searchPwd" name="search_pwd" required placeholder="">
                                                        </div>
                                                    @endif
                                                    <div class="col-12 mt-3">
                                                        <button type="submit" class="btn btn-outline-primary">
                                                            <i class="ali-icon">&#xe65c;</i> {{ __('dujiaoka.search_now') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="order_search_by_browser">
                                            <form  action="{{ url('search-order-by-browser') }}"  method="post">
                                                {{ csrf_field() }}
                                                <div class="form-group row">
                                                    <div class="col-12 mt-3">
                                                        <button type="submit" class="btn btn-outline-primary">
                                                            <i class="ali-icon">&#xe65c;</i> {{ __('dujiaoka.search_now') }}</button>
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
            </div>
        </div>
    </section>
    <!-- main end -->
@stop
@section('js')
@stop
