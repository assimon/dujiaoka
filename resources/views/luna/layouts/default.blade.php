<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('luna.layouts._header')
@yield('content')
@include('luna.layouts._script')
@section('js')
@show
</html>
