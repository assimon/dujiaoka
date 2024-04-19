<!DOCTYPE html>
<html lang="{{ str_replace('_','-',strtolower(app()->getLocale())) }}">
@include('unicorn.layouts._header') 
<body>
@include('unicorn.layouts._nav')
@yield('content')
@include('unicorn.layouts._footer')
</body>
@include('unicorn.layouts._script')
@section('js')
@show
</html>

