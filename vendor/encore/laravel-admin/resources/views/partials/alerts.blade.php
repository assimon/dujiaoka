@if($error = session()->get('error'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i>{{ \Illuminate\Support\Arr::get($error->get('title'), 0) }}</h4>
        <p>{!!  \Illuminate\Support\Arr::get($error->get('message'), 0) !!}</p>
    </div>
@elseif ($errors = session()->get('errors'))
    @if ($errors->hasBag('error'))
      <div class="alert alert-danger alert-dismissable">

        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        @foreach($errors->getBag("error")->toArray() as $message)
            <p>{!!  \Illuminate\Support\Arr::get($message, 0) !!}</p>
        @endforeach
      </div>
    @endif
@endif

@if($success = session()->get('success'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i>{{ \Illuminate\Support\Arr::get($success->get('title'), 0) }}</h4>
        <p>{!!  \Illuminate\Support\Arr::get($success->get('message'), 0) !!}</p>
    </div>
@endif

@if($info = session()->get('info'))
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-info"></i>{{ \Illuminate\Support\Arr::get($info->get('title'), 0) }}</h4>
        <p>{!!  \Illuminate\Support\Arr::get($info->get('message'), 0) !!}</p>
    </div>
@endif

@if($warning = session()->get('warning'))
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i>{{ \Illuminate\Support\Arr::get($warning->get('title'), 0) }}</h4>
        <p>{!!  \Illuminate\Support\Arr::get($warning->get('message'), 0) !!}</p>
    </div>
@endif