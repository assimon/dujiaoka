@extends('choice.layouts.default')

@section('content')

        <div class="layui-row">
            <div class="layui-col-md8 layui-col-md-offset2 layui-col-xs12">
                <div class="layui-card cardcon">
                    <div class="layui-card-header"><span style="color: red">{{ $title }}：</span></div>
                    <div class="layui-card-body">
                        <p class="product-info" style="text-align: center">
                            <span class="product-price">{{ $content }}</span>
                        </p>
                        <p class="errpanl" style="text-align: center">
                            @if(!$url)
                                <a href="javascript:history.back(-1);"  class="layui-btn layui-btn-sm">返回</a>
                            @else
                                <a href="{{ $url }}"  class="layui-btn layui-btn-sm">返回</a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
@stop
