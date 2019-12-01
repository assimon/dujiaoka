<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

<label for="{{$id}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <input type="hidden" name="{{$name}}"/>

        <select class="form-control {{$class}}" style="width: 100%;" name="{{$name}}" {!! $attributes !!} >
            @if($groups)
                @foreach($groups as $group)
                    <optgroup label="{{ $group['label'] }}">
                        @foreach($group['options'] as $select => $option)
                            <option value="{{$select}}" {{ $select == old($column, $value) ?'selected':'' }}>{{$option}}</option>
                        @endforeach
                    </optgroup>
                @endforeach
             @else
                <option value=""></option>
                @foreach($options as $select => $option)
                    <option value="{{$select}}" {{ $select == old($column, $value) ?'selected':'' }}>{{$option}}</option>
                @endforeach
            @endif
        </select>

        @include('admin::form.help-block')

    </div>
</div>
