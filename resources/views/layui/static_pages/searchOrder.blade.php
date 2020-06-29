@extends('layui.layouts.default')
@section('content')

    <div class="layui-row">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">

            <div class="layui-card cardcon">
                <div class="layui-card-header">{{ __('system.order_search') }}</div>

                <div class="layui-card-body">
                    <div class="layui-tab">
                        <ul class="layui-tab-title">
                            <li class="layui-this">{{ __('system.order_search_by_number') }}</li>
                            <li>{{ __('system.order_search_by_email') }}</li>
                            <li>{{ __('system.order_search_by_ie') }}</li>
                        </ul>
                        <div class="layui-tab-content">
                            <div class="product-info">
                                <p style="color: #1E9FFF;font-size: 20px;font-weight: 500; text-align: center" >{{ __('system.query_tips') }}</p>
                            </div>
                            <!-- 订单号查询 -->
                            <div class="layui-tab-item layui-show">
                                <form class="layui-form" action="{{ url('searchOrderById') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">{{ __('system.order_number') }}</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="order_id" required  lay-verify="required" placeholder="{{ __('system.set_order_number') }}" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <div class="layui-input-block">
                                            <button class="layui-btn" lay-submit lay-filter="orderByid">{{ __('system.search_now') }}</button>
                                            <button type="reset" class="layui-btn layui-btn-primary">{{ __('system.reset_order') }}</button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                            <!-- 邮箱查询 -->
                            <div class="layui-tab-item">
                                <form class="layui-form" action="{{ url('searchOrderByAccount') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">{{ __('system.email') }}</label>
                                        <div class="layui-input-block">
                                            <input type="email" name="account" required  lay-verify="required" placeholder="{{ __('prompt.set_email') }}" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">{{ __('system.search_password') }}</label>
                                        <div class="layui-input-block">
                                            <input type="password" name="search_pwd" required  lay-verify="required" placeholder="{{ __('prompt.get_search_password') }}" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <div class="layui-input-block">
                                            <button class="layui-btn" lay-submit lay-filter="orderByAccount">{{ __('system.search_now') }}</button>
                                            <button type="reset" class="layui-btn layui-btn-primary">{{ __('system.reset_order') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- 浏览器缓存 -->
                            <div class="layui-tab-item">
                                <form class="layui-form" action="{{ url('searchOrderByBrowser') }}">
                                    {{ csrf_field() }}
                                    <div class="layui-form-item">
                                        <div class="layui-input-block">
                                            <button class="layui-btn" lay-submit lay-filter="searchOrderByBrowser">
                                                {{ __('system.search_now') }}</button>
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


@stop

@section('tpljs')
    <script>
        layui.use(['element', 'form'], function(){
            var element = layui.element;
            var form = layui.form;
            //监听提交
            form.on('submit(orderByid)', function(data){
                return true;
            });
            //监听提交
            form.on('submit(orderByAccount)', function(data){
                return true;
            });
            //监听提交
            form.on('submit(searchOrderByBrowser)', function(data){
                return true;
            });
        });
    </script>
@stop
