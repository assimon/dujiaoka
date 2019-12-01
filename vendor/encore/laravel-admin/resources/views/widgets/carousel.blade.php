<div {!! $attributes !!} style='padding: 5px;border: 1px solid #f4f4f4;background-color:white;width:{{ $width }}px;'>
    <ol class="carousel-indicators">

        @foreach($items as $key => $item)
        <li data-target="#{!! $id !!}" data-slide-to="{{$key}}" class="{{ $key == 0 ? 'active' : '' }}"></li>
        @endforeach

    </ol>
    <div class="carousel-inner">

        @foreach($items as $key => $item)
        <div class="item {{ $key == 0 ? 'active' : '' }}">
            <img src="{{ url($item['image']) }}" alt="{{$item['caption']}}" style='max-width:{{ $width }}px;max-height:{{ $height }}px;display: block;margin-left: auto;margin-right: auto;'>
            <div class="carousel-caption">
                {{$item['caption']}}
            </div>
        </div>
        @endforeach

    </div>
    <a class="left carousel-control" href="#{!! $id !!}" data-slide="prev">
        <span class="fa fa-angle-left"></span>
    </a>
    <a class="right carousel-control" href="#{!! $id !!}" data-slide="next">
        <span class="fa fa-angle-right"></span>
    </a>
</div>
