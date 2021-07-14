<!DOCTYPE html>
    <html lang="{{ str_replace('_','-',strtolower(app()->getLocale())) }}">
    <head>
        <meta charset="utf-8" />
        <title>{{ isset($page_title) ? $page_title : '' }} | {{ dujiaoka_config_get('title') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="Keywords" content="{{ dujiaoka_config_get('keywords') }}">
        <meta name="Description" content="{{ dujiaoka_config_get('description') }}">
        @if(\request()->getScheme() == "https")
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        @endif
        <!-- App favicon -->
        <link rel="shortcut icon" href="/favicon.ico">
        <!-- third party css -->
        <link href="/assets/hyper/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <link href="/assets/hyper/css/hyper-loading.css" rel="stylesheet" type="text/css" />
        <!-- third party css end -->
        <!-- App css -->
        <link href="/assets/hyper/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/hyper/css/app-creative.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <style>
            body {
                background-color: #fafafa;
            }
            .home-page-title-right {
                float: right;
                margin-top: 20px;
            }
            .close-jq-toast-single {
                background: #3b5d52!important;
            }
            .row-list .row {
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                flex-wrap: wrap;
            }
            .row-list .row > [class*='col-'] {
                display: flex;
                flex-direction: column;
            }
            .box {
                display: block;
                padding-top: 32px;
                color: #3c4655;
                background-color: #fff;
                border-radius: .25rem;
                box-shadow: 0 0 35px 0 rgb(154 161 171 / 15%);
                margin-bottom: 24px;
                transition: all .5s;
            }
            .box:hover {
                color: #3c4655;
                background-color: #f5f5f5;
                box-shadow: 0 3px 6px 0 rgb(0 0 0 / 12%);
                -webkit-box-shadow: 0 3px 6px 0 rgb(0 0 0 / 12%);
            }
            @media (max-width: 767px) {
                .box {
                    padding-top: 32px;
                    padding-bottom: 14px;
                    padding-left: 12px;
                    padding-right: 12px;
                }
                .img-box {
                    margin-bottom: 12px;
                }
                .shop-img {
                    max-width: 88px;
                }
            }
            @media (min-width: 768px) {
                .box {
                    padding-top: 32px;
                    padding-bottom: 14px;
                    padding-left: 24px;
                    padding-right: 24px;
                }
                .img-box {
                    margin-bottom: 12px;
                }
                .shop-img {
                    max-width: 100px;
                }
            }
            @media (min-width: 1200px) {
                .box {
                    padding-top: 32px;
                    padding-bottom: 14px;
                    padding-left: 20px;
                    padding-right: 20px;
                }
                .img-box {
                    margin-bottom: 24px;
                }
                .shop-img {
                    max-width: 120px;
                }
            }
            .custom-control-label {
            	line-height: 24px;
            }
            @media screen and (min-width: 767px) {
                .sp-height {
                    position: relative;
	                overflow: hidden;
                    width: 100%;
                }
                .scrollbar {
	                overflow-x: hidden;
	                overflow-y: auto;
	                scrollbar-width: none; /* Firefox */
	                -ms-overflow-style: none; /* IE 10+ */
                }
                .scrollbar::-webkit-scrollbar {
                    display: none; /* Chrome Safari */
                }
            }
            .info {
                font-size: 16px;
                font-weight: 700;
                display: inline-block;
                color: #000;
                margin-left: 10px;
                vertical-align: middle;
            }
            .kami-info{
                height: 170px;
                overflow-wrap: break-word;
                overflow: auto;
                border: 1px solid #ccc;
                margin-bottom: 2px;
                font-size: 14px;
            }
            .img-box {
                width: 100%;
                text-align: center;
            }
            .img-badge {
                position: absolute;
                top: 6px;
                right: 18px;
            }
            .shop-name {
                font-size: 14px;
            }
            .shop-price {
                font-size: 16px;
                font-weight: 500;
                color: #d0021b;
            }
            .hyper-badge {
                font-size: 12px;
                color: #fff;
                background-color: #f9bc0d;
                padding-left: 6px;
                padding-right: 6px;
                padding-top: 3px;
                padding-bottom: 3px;
                border-radius: 2px;
                margin-left: 4px;
            }
            .shop-center {
                display: flex;
                align-items: center;
            }
            /* buy.blade.php */

            @media (max-width: 767px) {
                .buy-img img {
                    max-width: 150px;
                }
                .buy-img {
                    margin-bottom: 12px;
                }
            }
            @media (min-width: 768px) {
                .buy-form {
                    display: grid;
                    grid-template-rows: auto auto;
                    grid-template-columns: 225px auto;
                }
                .buy-img img {
                    max-width: 180px;
                }
                .buy-type {
                    max-width: 90%;
                }
            }
            @media (min-width: 1200px) {
                .buy-form {
                    display: grid;
                    grid-template-rows: auto auto;
                    grid-template-columns: 375px auto;
                }
                .buy-img img {
                    max-width: 200px;
                }
                .buy-type {
                    max-width: 70%;
                }
            }

            .buy-img {
                display: flex;
                grid-row-start: 1;
                grid-column-end: 2;
                grid-row-end: 3;
                justify-content: center;
                align-items: center;
            }
            .buy-type {
                grid-row-start: 2;
                grid-column-end: 3;
            }

            .buy-group {
                position: relative;
                line-height: 36px;
                padding-left: 94px;
            }

            .buy-title {
                position: absolute;
                left: 0;
                font-weight: 600;
            }
            .buy-product img {
                max-width:100%;
                height: auto;
                border-radius: 5px;
                cursor: pointer;
            }
            .geetest_holder.geetest_wind {
                width: 100%!important;
                min-width: 100%!important;
            }
        </style>
    </head>

    <body class="loading" data-layout="topnav">
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    <div class="navbar-custom topnav-navbar">
                        <div class="container">
                            <!-- LOGO -->
                            <a href="/" class="topnav-logo" style="float: none;">
                                <img src="{{ picture_ulr(dujiaoka_config_get('img_logo')) }}" height="48">
                                <div class="info">{{ dujiaoka_config_get('text_logo') }}</div>
                            </a>
                            <ul class="list-unstyled topbar-right-menu float-right mb-0">
                                <li class="notification-list">
                                    <a class="nav-link right-bar-toggle" href="{{ url('order-search') }}">
                                        <i class="noti-icon mdi mdi-magnify search-icon"></i>
                                        {{ __('hyper.order_search') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end Topbar -->
