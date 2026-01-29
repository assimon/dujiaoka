<!DOCTYPE html>
<html lang="{{ str_replace('_','-',strtolower(app()->getLocale())) }}">
@include('luna.layouts._header')
@yield('content')
@include('luna.layouts._script')
@section('js')
@show
</html>
