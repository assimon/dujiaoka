@extends('unicorn.layouts.default')

@section('content')
    <div class="page-wrapper">
        <!-- main start -->
        <section class="main-container">
            <div class="container">
                <div class="good-card">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-12">
                            <div class="card m-3 border-0">
                                <div class="card-body p-4">
                                    <h3 class="card-title ali-icon">&#xe651; {{ $title }}： </h3>
                                    <h6>
                                        <small class="text-muted">似乎遇到了一点问题~</small>
                                    </h6>
                                    <div class="err-message text-center p-3">
                                        <h5>
                                            {{ $content }}
                                        </h5>
                                    </div>
                                    <div class="col-12 mt-3 text-center">
                                        @if(!$url)
                                            <a href="javascript:history.back(-1);"  class="btn btn-outline-dark">{{ __('dujiaoka.callback') }}</a>
                                        @else
                                            <a href="{{ $url }}"  class="btn btn-outline-dark">{{ __('dujiaoka.callback') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- main end -->
        </div>
@stop
