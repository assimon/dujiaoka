<div class="input-group input-group-sm">
    @foreach($options as $option => $label)

        {!! $inline ? '<span class="icheck">' : '<div class="checkbox icheck">' !!}

        <label @if($inline)class="checkbox-inline"@endif>
            <input type="checkbox" class="{{$id}}" name="{{$name}}[]" value="{{$option}}" class="minimal" {{ in_array((string)$option, request($name, is_null($value) ? [] : $value)) ? 'checked' : '' }} />&nbsp;{{$label}}&nbsp;&nbsp;
        </label>

        {!! $inline ? '</span>' :  '</div>' !!}

    @endforeach
</div>