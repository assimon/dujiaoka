@extends('layui.layouts.default')
@section('content')
    <div class="layui-row">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">

            <div class="layui-card cardcon">
                <div class="layui-card-header">{{ __('dujiaoka.order_search') }}</div>

                <div class="layui-card-body">
                    <div class="layui-tab">
                        <ul class="layui-tab-title">
                            <li class="layui-this">{{ __('dujiaoka.order_search_by_sn') }}</li>
                            <li>{{ __('dujiaoka.order_search_by_email') }}</li>
                            <li>{{ __('dujiaoka.order_search_by_browser') }}</li>
                        </ul>
                        <div class="layui-tab-content">
                            <div class="product-info">
                                <p style="color: #1E9FFF;font-size: 20px;font-weight: 500; text-align: center" >{{ __('dujiaoka.prompt.search_order_browser_tips') }}</p>
                            </div>
                            <!-- 订单号查询 -->
                            <div class="layui-tab-item layui-show">
                                <form class="layui-form" action="{{ url('search-order-by-sn') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">{{ __('order.fields.order_sn') }}</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="order_sn" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <div class="layui-input-block">
                                            <button class="layui-btn" lay-submit lay-filter="orderBySN">{{ __('dujiaoka.search_now') }}</button>
                                            <button type="reset" class="layui-btn layui-btn-primary">{{ __('dujiaoka.reset') }}</button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                            <!-- 邮箱查询 -->
                            <div class="layui-tab-item">
                                <form class="layui-form" action="{{ url('search-order-by-email') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">{{ __('order.fields.email') }}</label>
                                        <div class="layui-input-block">
                                            <input type="email" name="email" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    @if(dujiaoka_config_get('is_open_search_pwd', \App\Models\BaseModel::STATUS_CLOSE) == \App\Models\BaseModel::STATUS_OPEN)
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">{{ __('order.fields.search_pwd') }}</label>
                                        <div class="layui-input-block">
                                            <input type="password" name="search_pwd" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    @endif
                                    <div class="layui-form-item">
                                        <div class="layui-input-block">
                                            <button class="layui-btn" lay-submit lay-filter="orderByEmail">{{ __('dujiaoka.search_now') }}</button>
                                            <button type="reset" class="layui-btn layui-btn-primary">{{ __('dujiaoka.reset') }}</button>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <!-- 浏览器缓存 -->
                            <div class="layui-tab-item">
                                <form class="layui-form" action="{{ url('search-order-by-browser') }}"  method="post">
                                    {{ csrf_field() }}
                                    <div class="layui-form-item">
                                        <div class="layui-input-block">
                                            <button class="layui-btn" lay-submit lay-filter="orderByBrowser">
                                                {{ __('dujiaoka.search_now') }}</button>
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
            form.on('submit(orderBySN)', function(data){
                return true;
            });
            //监听提交
            form.on('submit(orderByEmail)', function(data){
                return true;
            });
            //监听提交
            form.on('submit(orderByBrowser)', function(data){
                return true;
            });
        });
    </script>
@stop
