<div class="background"></div>
<div class="header" style="">
    <div class="layui-row">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">
            <div class="header-box">
                <a href="/">
                    <img src="{{ picture_ulr(dujiaoka_config_get('img_logo')) }}" alt="">
                    <div class="info">{{ dujiaoka_config_get('text_logo') }}</div>
                </a>
                <div class="query layui-hide-xs">
                    <a href="{{ url('order-search') }}">
                        <svg t="1602923269232" class="icon" viewBox="0 0 1024 1024" version="1.1"
                             xmlns="http://www.w3.org/2000/svg" p-id="4816" width="20" height="20">
                            <path d="M965.6 447.2 752 447.2c-14.4 0-26.4-12-26.4-26.4 0-14.4 12-26.4 26.4-26.4l213.6 0c14.4 0 26.4 12 26.4 26.4C992.8 435.2 980.8 447.2 965.6 447.2zM965.6 233.6 699.2 233.6c-14.4 0-26.4-12-26.4-26.4 0-14.4 12-26.4 26.4-26.4l267.2 0c14.4 0 26.4 12 26.4 26.4C992.8 221.6 980.8 233.6 965.6 233.6zM606.4 623.2l156.8 156.8c21.6 21.6 21.6 56.8 0 78.4-21.6 21.6-56.8 21.6-78.4 0L528 701.6c-16-16-20-39.2-12-59.2-51.2 44-117.6 72-190.4 72-162.4 0-293.6-131.2-293.6-293.6s131.2-293.6 293.6-293.6 293.6 131.2 293.6 293.6c0 72.8-28 139.2-72 190.4C567.2 603.2 590.4 607.2 606.4 623.2zM324.8 233.6c-103.2 0-187.2 84-187.2 187.2s84 187.2 187.2 187.2S512 523.2 512 420 428 233.6 324.8 233.6zM805.6 607.2l160 0c14.4 0 26.4 12 26.4 26.4 0 14.4-12 26.4-26.4 26.4l-160 0c-14.4 0-26.4-12-26.4-26.4C779.2 619.2 791.2 607.2 805.6 607.2z"
                                  p-id="4817" fill="#ffffff"></path>
                        </svg>
                        <span>{{ __('dujiaoka.order_search') }}</span>
                    </a>
                </div>
                @yield('notice')
            </div>
        </div>
    </div>
</div>
