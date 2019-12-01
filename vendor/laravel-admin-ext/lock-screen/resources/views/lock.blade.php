<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('admin.title')}} | Lockscreen</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/font-awesome/css/font-awesome.min.css") }}">
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/dist/css/AdminLTE.min.css") }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition lockscreen">

<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
        <a href="#">{{config('admin.name')}}</a>
    </div>
    <!-- User name -->
    <div class="lockscreen-name">{{ Admin::user()->name }}</div>

    <!-- START LOCK SCREEN ITEM -->
    <div class="lockscreen-item">
        <!-- lockscreen image -->
        <div class="lockscreen-image">
            <img src="{{ Admin::user()->avatar }}" alt="User Image">
        </div>
        <!-- /.lockscreen-image -->
        <!-- lockscreen credentials (contains the form) -->
        <form class="lockscreen-credentials" method="post" action="{{ route('laravel-admin-unlock') }}">
            <div class="input-group">

                <input type="password" class="form-control" {{ old('password') ? 'style=color:red;' : '' }} placeholder="{{ trans('admin.password') }}" name="password" value="{{ old('password') }}"/>

                {{ csrf_field() }}

                <div class="input-group-btn">
                    <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
                </div>
            </div>
        </form>
        <!-- /.lockscreen credentials -->
    </div>

    <div class="text-center">
        <a href="{{ admin_base_path('auth/logout') }}">{{ trans('admin.logout') }}</a>
    </div>
</div>
<!-- /.center -->

<script src="{{ admin_asset("/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js")}} "></script>
<script src="{{ admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js")}}"></script>

<script>
    $(function () {
        $('input').focus();
    });
</script>

</body>
</html>
