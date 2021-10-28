@extends('luna.layouts.default')

@section('notice')
    @include('luna.layouts._notice')
@endsection

@section('content')
    <body>
    @include('luna.layouts._nav')

    <div class="main">
        <div class="layui-row">
            <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">
                <div class="main-box">
                    <div class="title">
                        <svg t="1602925747464" class="icon" viewBox="0 0 1024 1024"
                             version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1270"
                             data-spm-anchor-id="a313x.7781069.0.i4" width="20" height="20">
                            <path
                                d="M619.52 578.56V808.96h194.56V660.48h-133.12v-81.92h215.04V849.92l-40.96 40.96h-276.48l-40.96-40.96V578.56z"
                                fill="#00EAFF" p-id="1271" data-spm-anchor-id="a313x.7781069.0.i0" class=""></path>
                            <path
                                d="M619.52 512V215.04h194.56v172.032h-133.12v81.92h174.08l40.96-40.96V174.08l-40.96-40.96h-276.48l-40.96 40.96v337.92z"
                                fill="#3C8CE7" p-id="1272" data-spm-anchor-id="a313x.7781069.0.i6" class=""></path>
                            <path
                                d="M445.44 890.88h-276.48l-40.96-40.96V619.52l40.96-40.96h174.08v81.92h-133.12V808.96h194.56V215.04h-194.56v172.032h133.12v81.92h-174.08l-40.96-40.96V174.08l40.96-40.96h276.48l40.96 40.96v675.84z"
                                fill="#3C8CE7" p-id="1273" data-spm-anchor-id="a313x.7781069.0.i3" class=""></path>
                        </svg>
                        <span>{{ __('luna.home_choice_cate') }}</span>
                    </div>
                    <div class="cate">

                    </div>
                    <div class="goods">
                        <p class="title-2">
                            <svg t="1602925988984" class="icon" viewBox="0 0 1024 1024"
                                 version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1945" width="17" height="17">
                                <path
                                    d="M803.84 883.712h-163.84v-81.92h133.12l118.784-393.216-178.176 95.232-55.296-15.36L512 240.64 365.568 488.448l-55.296 15.36-178.176-95.232 118.784 393.216h133.12v81.92h-163.84l-38.912-28.672L25.6 336.896l58.368-47.104 230.4 122.88 162.816-272.384h69.632l162.816 272.384 230.4-122.88 58.368 47.104-155.648 518.144z"
                                    fill="#3C8CE7" p-id="1946" data-spm-anchor-id="a313x.7781069.0.i17" class=""></path>
                                <path
                                    d="M305.152 620.544h61.44v61.44h-61.44zM481.28 620.544h61.44v61.44h-61.44zM657.408 620.544h61.44v61.44h-61.44z"
                                    fill="#00EAFF" p-id="1947" data-spm-anchor-id="a313x.7781069.0.i14" class=""></path>
                            </svg>
                            <span>{{ __('luna.home_choice_goods') }}</span>
                        </p>
                        <div class="goods-list"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('luna.layouts._footer')

    <div class="query-m">
        <a href="{{ url('order-search') }}">
            <svg t="1602926403006" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"
                 p-id="3391" width="30" height="30">
                <path d="M320.512 428.032h382.976v61.44H320.512zM320.512 616.448h320.512v61.44H320.512z" fill="#ffffff"
                      p-id="3392" data-spm-anchor-id="a313x.7781069.0.i38" class="selected"></path>
                <path
                    d="M802.816 937.984H221.184l-40.96-40.96V126.976l40.96-40.96h346.112l26.624 10.24 137.216 117.76 98.304 79.872 15.36 31.744v571.392l-41.984 40.96z m-540.672-81.92h500.736V345.088L677.888 276.48 550.912 167.936H262.144v688.128z"
                    fill="#ffffff" p-id="3393" data-spm-anchor-id="a313x.7781069.0.i37" class="selected"></path>
            </svg>
            <span>{{ __('luna.order_search_m') }}</span>
        </a>
    </div>

    </body>
    <script id="cateTpl" type="text/html">
        <div class="cate-box" data-key="<< d.key >>">
            <p><< d.gp_name >></p>
            <div>{{ __('luna.goods_num') }}：<< d.goods.length >></div>
        </div>
    </script>
    <script id="goodsTpl" type="text/html">
        <a href="<<# if(d.in_stock > 0){ >>/buy/<< d.id >><<#  } else { >>javascript:void(0);<<# }; >>"
           class="goods-box" style="<<# if(d.in_stock <= 0){ >>cursor:not-allowed;<<# }; >>">
            <<# if(d.picture){ >>
            <div class="picture"><img src="{{ picture_ulr('',true) }}<< d.picture >>" alt=""></div>
            <<# }; >>
            <div class="msg">
                <div class="goods-name"><< d.gd_name >></div>
                <div class="goods-price">
                    ￥<< d.actual_price >>
                        <<# layui.each(d.wholesale_price_arr, function(index, item){ >>
                        <div>{{ __('luna.goods_disc_1') }}<< item[0] >>{{ __('luna.goods_disc_2') }}<< item[1]
                            >>{{ __('luna.goods_disc_3') }}</div>
                        <<# }); >>
                </div>
                <div class="goods-num">
                    <div><p style="width: << d.proportion >>%;"></p></div>
                    <span>{{ __('luna.goods_surplus') }}<< d.in_stock>>{{ __('luna.goods_unit') }}</span>
                </div>
            </div>
        </a>
    </script>

    <script>
        let title    = "{{ __('dujiaoka.site_announcement') }}",
            goodsMsg = {!! json_encode($data) !!};
    </script>
@endsection

