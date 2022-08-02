<!DOCTYPE html>
<html lang="{{ str_replace('_','-',strtolower(app()->getLocale())) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{ isset($page_title) ? $page_title : '' }} | {{ dujiaoka_config_get('title') }}</title>
    <meta name="keywords" content="{{ $gd_keywords }}">
    <meta name="description" content="{{ $gd_description }}">
    <meta property="og:type" content="article">
    <meta property="og:image" content="{{ $picture }}">
    <meta property="og:title" content="{{ isset($page_title) ? $page_title : '' }}">
    <meta property="og:description" content="{{ $gd_description }}">    
    <meta property="og:release_date" content="{{ $updated_at }}">
    <link rel="stylesheet" href="/assets/luna/layui/css/layui.css">
    <link rel="stylesheet" href="/assets/luna/main.css">
    <link rel="shortcut icon" href="/assets/style/favicon.ico" />
    @if(\request()->getScheme() == "https")
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
</head>
@yield('content')
@include('luna.layouts._script')
@section('js')
@show
</html>
