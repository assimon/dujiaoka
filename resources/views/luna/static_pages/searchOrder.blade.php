@extends('luna.layouts.default')

@section('content')
    <body>
    @include('luna.layouts._nav')
    <style>
        .layui-table td, .layui-table th {
            padding: 9px 5px;
        }
    </style>
    <div class="main">
        <div class="layui-row">
            <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">
                <div class="main-box">

                    <div class="pay-title">
                        <svg style="margin-bottom: -6px;" t="1603120404646" class="icon" viewBox="0 0 1024 1024"
                             version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1611" width="27" height="27">
                            <path d="M320.512 428.032h382.976v61.44H320.512zM320.512 616.448h320.512v61.44H320.512z"
                                  fill="#00EAFF" p-id="1612" data-spm-anchor-id="a313x.7781069.0.i3"
                                  class="selected"></path>
                            <path
                                d="M802.816 937.984H221.184l-40.96-40.96V126.976l40.96-40.96h346.112l26.624 10.24 137.216 117.76 98.304 79.872 15.36 31.744v571.392l-41.984 40.96z m-540.672-81.92h500.736V345.088L677.888 276.48 550.912 167.936H262.144v688.128z"
                                fill="#3C8CE7" p-id="1613" data-spm-anchor-id="a313x.7781069.0.i0" class=""></path>
                        </svg>
                        {{ __('system.order_search') }}
                    </div>
                    <div class="layui-card-body">
                        <p style="color: #3C8CE7;font-size: 18px;font-weight: 700; text-align: center;margin: 20px 0">
                            {{ __('system.query_tips') }}
                        </p>
                        <div class="layui-tab">
                            <ul class="layui-tab-title">
                                <li class="layui-this">{{ __('system.order_search_by_number') }}</li>
                                <li>{{ __('system.order_search_by_email') }}</li>
                                <li>{{ __('system.order_search_by_ie') }}</li>
                            </ul>
                            <div class="layui-tab-content" style="text-align: center">
                                <!-- 订单号查询 -->
                                <div class="layui-tab-item layui-show">
                                    <form class="layui-form" action="{{ url('searchOrderById') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="entry">
                                            <span class="l-msg">{{ __('system.order_number') }}:</span>
                                            <label class="input">
                                                <input type="text" name="order_id" required="" lay-verify="required"
                                                       placeholder="{{ __('prompt.set_order_number') }}"
                                                       autocomplete="off">
                                            </label>
                                        </div>
                                        <div class="btn">
                                            <button lay-submit lay-filter="orderByid">
                                                {{ __('system.search_now') }}
                                            </button>
                                        </div>
                                    </form>

                                </div>

                                <!-- 邮箱查询 -->
                                <div class="layui-tab-item">
                                    <form class="layui-form" action="{{ url('searchOrderByAccount') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="entry">
                                            <span class="l-msg">{{ __('system.email') }}:</span>
                                            <label class="input">
                                                <input type="email" name="account" required lay-verify="required"
                                                       placeholder="{{ __('prompt.set_email') }}" autocomplete="off">
                                            </label>
                                        </div>
                                        @if(config('webset.isopen_searchpwd') == 1)
                                            <div class="entry">
                                                <span class="l-msg">{{ __('system.search_password') }}:</span>
                                                <label class="input">
                                                    <input type="password" name="search_pwd"
                                                           required lay-verify="required"
                                                           placeholder="{{ __('prompt.get_search_password') }}"
                                                           autocomplete="off">
                                                </label>
                                            </div>
                                        @endif
                                        <div class="btn">
                                            <button lay-submit lay-filter="orderByAccount">
                                                {{ __('system.search_now') }}
                                            </button>
                                        </div>

                                    </form>
                                </div>

                                <!-- 浏览器缓存 -->
                                <div class="layui-tab-item">
                                    <form class="layui-form" action="{{ url('searchOrderByBrowser') }}">
                                        {{ csrf_field() }}
                                        <div class="btn">
                                            <button lay-submit lay-filter="searchOrderByBrowser">
                                                {{ __('system.search_now') }}
                                            </button>
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
    @include('luna.layouts._footer')
    </body>
@endsection

@section('js')
    <script>
        layui.use(['element', 'form'], function () {
            var element = layui.element;
            var form = layui.form;
            //监听提交
            form.on('submit(orderByid)', function (data) {
                return true;
            });
            //监听提交
            form.on('submit(orderByAccount)', function (data) {
                return true;
            });
            //监听提交
            form.on('submit(searchOrderByBrowser)', function (data) {
                return true;
            });
        });
    </script>
@endsection
