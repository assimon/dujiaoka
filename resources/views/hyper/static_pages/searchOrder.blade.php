@extends('hyper.layouts.default')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                {{-- 查询订单 --}}
                <h4 class="page-title">{{ __('hyper.searchOrder_title') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ __('hyper.searchOrder_query_tips') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-body">
                <div class="tab-pane show active" id="bordered-tabs-preview">
                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#dingdanhao" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                {{-- 订单 --}}
                                <span>{{ __('hyper.searchOrder_order_search_by_number') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#youxiang" data-toggle="tab" aria-expanded="true" class="nav-link">
                                {{-- 邮箱 --}}
                                <span>{{ __('hyper.searchOrder_order_search_by_email') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#liulanqi" data-toggle="tab" aria-expanded="false" class="nav-link">
                                {{-- 缓存 --}}
                                <span>{{ __('hyper.searchOrder_order_search_by_ie') }}</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="dingdanhao">
                            <form class="needs-validation" action="{{ url('search-order-by-sn') }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group mb-3">
                                    {{-- 订单编号 --}}
                                    <label for="validationCustom01">{{ __('hyper.searchOrder_order_number') }}</label>
                                    <input type="text" class="form-control" name="order_sn" required  placeholder="{{ __('hyper.searchOrder_input_order_number') }}">
                                </div>
                                <div class="form-group mb-3">
                                    {{-- 立即查询 --}}
                                    <button class="btn btn-primary" type="submit">{{ __('hyper.searchOrder_search_now') }}</button>
                                    {{-- 重置 --}}
                                    <button type="reset" class="btn btn-primary">{{ __('hyper.searchOrder_reset_order') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="youxiang">
                            <form class="needs-validation" action="{{ url('search-order-by-email') }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group mb-3">
                                    {{-- 邮箱 --}}
                                    <label for="validationCustom01">{{ __('hyper.searchOrder_email') }}</label>
                                    <input type="email" class="form-control" name="email" required  placeholder="{{ __('hyper.searchOrder_input_email') }}">
                                </div>
                                @if(dujiaoka_config_get('is_open_search_pwd', \App\Models\BaseModel::STATUS_CLOSE) == \App\Models\BaseModel::STATUS_OPEN)
                                    <div class="form-group mb-3">
                                        {{-- 查询密码 --}}
                                        <label for="validationCustom01">{{ __('hyper.searchOrder_search_password') }}</label>
                                        <input type="password" class="form-control" name="search_pwd" required  placeholder="{{ __('hyper.searchOrder_input_query_password') }}">
                                    </div>
                                @endif
                                <div class="form-group mb-3">
                                    {{-- 立即查询 --}}
                                    <button class="btn btn-primary" type="submit">{{ __('hyper.searchOrder_search_now') }}</button>
                                    {{-- 重置 --}}
                                    <button type="reset" class="btn btn-primary">{{ __('hyper.searchOrder_reset_order') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="liulanqi">
                            <form class="needs-validation" action="{{ url('search-order-by-browser') }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group mb-3">
                                    {{-- 立即查询 --}}
                                    <button class="btn btn-primary" type="submit">{{ __('hyper.searchOrder_search_now') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
