<!DOCTYPE html>
<html lang="{{ str_replace('_','-',strtolower(app()->getLocale())) }}">
@include('unicorn.layouts._header')
<body>
@if(dujiaoka_config_get('is_open_google_translate') == \App\Models\BaseModel::STATUS_OPEN)
    @include('unicorn.layouts.google_translate')
@endif
@include('unicorn.layouts._nav')
@yield('content')
@include('unicorn.layouts._footer')
@include('unicorn.layouts._script')
@section('js')
@show
</body>
</html>
