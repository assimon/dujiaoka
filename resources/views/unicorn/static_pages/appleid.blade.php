@extends('unicorn.layouts.default')
@section('content')
<section class="appleid-page">
    <h2 class="text-center">🍎 {{ __('dujiaoka.page-title.appleid') }}</h2>
    <div class="card p-4 shadow-sm">
        <form action="{{ url('appleid/retrieve') }}" method="post">
            @csrf
            <div class="mb-3">
                <label>选择 Apple ID 地区</label>
                <input type="text" name="region" class="form-control" placeholder="JP, US, icloud, yahoo 等">
            </div>
            <div class="mb-3">
                <label>接收邮箱</label>
                <input type="email" name="email" class="form-control" placeholder="请输入接收邮箱">
            </div>
            <small class="text-danger">没有邮箱？输入后即可获取账号</small>
            <button type="submit" class="btn btn-success w-100 mt-3">领取 Apple ID</button>
        </form>
    </div>

    <div class="accordion mt-5" id="faq">
        <!-- 根据需要添加常见问题项 -->
    </div>
</section>
@endsection
