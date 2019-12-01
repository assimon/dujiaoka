<div class="input-group input-group-sm">
    @foreach($options as $option => $label)

        {!! $inline ? '<span class="icheck">' : '<div class="radio icheck">'  !!}

            <label @if($inline)class="radio-inline"@endif>
                <input type="radio" class="{{$id}}" name="{{$name}}" value="{{$option}}" class="minimal" {{ ((string)$option === request($name, is_null($value) ? '' : $value)) ? 'checked' : '' }} />&nbsp;{{$label}}&nbsp;&nbsp;
            </label>

        {!! $inline ? '</span>' :  '</div>' !!}

    @endforeach
</div>