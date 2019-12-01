<div {!! $attributes !!} >
    @if(isset($title))
    <h4>{{ $title }}</h4>
    @endif
    {!! $content !!}
</div>