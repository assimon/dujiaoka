<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{ config('webset.title') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="Keywords" content="{{ config('webset.keywords') }}">
        <meta name="Description" content="{{ config('webset.description') }}">
        @if(\request()->server()['REQUEST_SCHEME'] == "https")
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
              color: #3c4655;
            }
            .box:hover {
              color: #3c4655;
            }
            .custom-control-label {
            	line-height: 24px;
            }
            .buy-product img {
                max-width:100%;
                border-radius: 5px;
                cursor: pointer;
            }
            .form-control {
                height: 44px!important;
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
                .info {
                    font-size: 16px;
                    font-weight: 700;
                    color: #fff;
                    display: inline-block;
                    margin-left: 10px;
                    vertical-align: middle;
                }
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
                    <div class="navbar-custom topnav-navbar topnav-navbar-dark">
                        <div class="container">
                            <!-- LOGO -->
                            <a href="/" class="topnav-logo">
                                    <img src="/uploads/images/default.jpg height="48">
                                    <div class="info">{{ config('webset.text_logo') }}</div>
                            </a>
                            <ul class="list-unstyled topbar-right-menu float-right mb-0">
                                <li class="notification-list">
                                    <a class="nav-link right-bar-toggle" href="{{ url('searchOrder') }}">
                                        <i class="dripicons-search noti-icon"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end Topbar -->