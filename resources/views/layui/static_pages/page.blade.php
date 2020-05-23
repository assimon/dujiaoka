@extends('layui.layouts.default')
@section('content')
    <div class="layui-row ">
        <!-- PC -->
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">
            <div class="layui-card cardcon">
                <div class="layui-card-header">{{ $title }}</div>
                <div class="layui-card-body">
                    {!! $content !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('tpljs')
    <script>

    </script>
@stop
