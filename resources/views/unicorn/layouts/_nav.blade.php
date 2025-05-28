<!-- header start -->
<header class="header sticky-top">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="header-left clearfix">
                    <div class="logo text-center  d-none d-md-block">
                        <a href="/">
                            <img src="{{ picture_ulr(dujiaoka_config_get('img_logo')) }}" alt="Logo">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="header-right clearfix">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="container-fluid">
                            <a class="navbar-brand" href="/">{{ dujiaoka_config_get('text_logo') }}</a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarColor" aria-controls="navbarColor" aria-expanded="false"
                                    aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarColor">
                                <ul class="navbar-nav me-auto">
                                    <li class="nav-item">
                                        <a class="nav-link @if(\Illuminate\Support\Facades\Request::path() == '/') active @endif " href="/">{{__('dujiaoka.home_page')}}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if(\Illuminate\Support\Facades\Request::url() == url('order-search')) active @endif" href="{{ url('order-search') }}">{{ __('dujiaoka.order_search') }}</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ali-icon">&#xe790;</i> {{ __('dujiaoka.language') }}
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                                            <li><a class="dropdown-item" href="{{ url('cn') }}">简体中文</a></li>
                                            <li><a class="dropdown-item" href="{{ url('tw') }}">繁體中文</a></li>
                                            <li><a class="dropdown-item" href="{{ url('en') }}">English</a></li>
                                            <li><a class="dropdown-item" href="{{ url('th') }}">แบบไทย</a></li>
                                            <li><a class="dropdown-item" href="{{ url('vn') }}">Tiếng Việt</a></li>         
                                        </ul>
                                    </li>
                                </ul>
                                @if(\Illuminate\Support\Facades\Request::path() == '/')
                                    <form class="d-flex">
                                        <input class="form-control form-control-sm me-sm-2" id="searchText" type="text" placeholder="{{ __('dujiaoka.search_goods_name') }}">
                                        <button class="btn btn-secondary my-2 my-sm-0" type="button" id="searchBtn">
                                            <i class="ali-icon">&#xe65c;</i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header end -->
