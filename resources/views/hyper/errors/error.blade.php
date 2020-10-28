@extends('hyper.layouts.default')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">{{ __('hyper.error_error') }}</h4>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-4">
		<div class="text-center">
			<h1 class="text-error mt-4">error</h1>
            <h4 class="text-uppercase text-danger mt-3">{{ $content }}</h4>
            @if(!$url)
                <a class="btn btn-info mt-3" href="javascript:history.back(-1);"><i class="mdi mdi-reply"></i> {{ __('hyper.error_back_btn') }}</a>
			@else
                <a class="btn btn-info mt-3" href="{{ $url }}"><i class="mdi mdi-reply"></i> {{ __('hyper.error_back_btn') }}</a>
            @endif
        </div> <!-- end /.text-center-->
    </div> <!-- end col-->
</div>
@stop