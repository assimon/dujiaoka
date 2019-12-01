<div class="grid-dropdown-actions dropdown">
    <a href="#" style="padding: 0 10px;" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-ellipsis-v"></i>
    </a>
    <ul class="dropdown-menu" style="min-width: 70px !important;box-shadow: 0 2px 3px 0 rgba(0,0,0,.2);border-radius:0;left: -65px;top: 5px;">

        @foreach($default as $action)
        <li>{!! $action->render() !!}</li>
        @endforeach

        @if(!empty($custom))

            @if(!empty($default))
                <li class="divider"></li>
            @endif

            @foreach($custom as $action)
            <li>{!! $action->render() !!}</li>
            @endforeach
        @endif
    </ul>
</div>