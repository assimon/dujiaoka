@extends('choice.layouts.default')
@section('content')
    <div class="layui-row ">
        <div class="layui-col-md8 layui-col-md-offset2 layui-col-sm12">
            <div class="layui-card cardcon">
                <div class="layui-card-header">文章中心</div>
                <div class="layui-card-body">
                    <ul>
                        @foreach($pages as $page)
                            <li>
                                <h2>
                                    <a href="/pages/{{$page['tag']}}.html">{{$page['title']}}</a>
                                </h2>
                                <div class="">
                                    <span>{{$page['updated_at']}}</span>
                                </div>
                            </li>
                            <hr>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop

@section('tpljs')
    <script>

    </script>
@stop

