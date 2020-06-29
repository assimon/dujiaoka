@include('layui.layouts._header')
@section('notice')

@show

<div class="sh-main">
    @yield('content')
</div>

@include('layui.layouts._footer')
@section('tpljs')

@show
