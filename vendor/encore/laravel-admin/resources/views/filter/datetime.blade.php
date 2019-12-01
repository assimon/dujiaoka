<div class="input-group input-group-sm">
    @if($group)
        <div class="input-group-btn">
            <input type="hidden" name="{{ $id }}_group" class="{{ $group_name }}-operation" value="0"/>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="min-width: 32px;">
                <span class="{{ $group_name }}-label">{{ $default['label'] }}</span>
                &nbsp;&nbsp;
                <span class="fa fa-caret-down"></span>
            </button>
            <ul class="dropdown-menu {{ $group_name }}">
                @foreach($group as $index => $item)
                    <li><a href="#" data-index="{{ $index }}"> {{ $item['label'] }} </a></li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
    </div>
    <input class="form-control" id="{{$id}}" placeholder="{{$label}}" name="{{$name}}" value="{{ request($name, $value) }}">
</div>