<!DOCTYPE html>
<html lang="{{ str_replace('_','-',strtolower(app()->getLocale())) }}">
<body>
@include('unicorn.layouts._header')
@include('unicorn.layouts._nav')
@yield('content')
@include('unicorn.layouts._footer')
</body>
@include('unicorn.layouts._script')
@section('js')
@show
</html>

