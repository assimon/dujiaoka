<!DOCTYPE html>
<html lang="{{ str_replace('_','-',strtolower(app()->getLocale())) }}">
@include('hyper.layouts._header')
<body data-layout="topnav">
    <div class="wrapper">
        <div class="content-page">
            <div class="content">
                @include('hyper.layouts._nav')
                <div class="container">
                    @yield('content')
                </div>
            </div><!-- content -->
            @include('hyper.layouts._footer')
        </div><!-- content-page -->
    </div><!-- wrapper -->
    @include('hyper.layouts._script')
    @section('js')
    @show
</body>
</html>