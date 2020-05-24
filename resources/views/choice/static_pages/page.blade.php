@extends('choice.layouts.default')
@section('content')
    <div class="layui-row ">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">
            <div class="layui-card cardcon">
                <div class="layui-card-body">
                    <h2>{{ $title }}</h2>
                    <hr>
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
