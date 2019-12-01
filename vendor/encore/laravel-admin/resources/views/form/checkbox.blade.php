<div class="{{$viewClass['form-group']}} {!! !$errors->has($column) ?: 'has-error' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}" id="{{$id}}">

        @if($canCheckAll)
            <span class="icheck">
            <label class="checkbox-inline">
                <input type="checkbox" class="{{ $checkAllClass }}"/>&nbsp;{{ __('admin.all') }}
            </label>
            </span>
            <hr style="margin-top: 10px;margin-bottom: 0;">
        @endif

        @include('admin::form.error')

        @foreach($options as $option => $label)

            {!! $inline ? '<span class="icheck">' : '<div class="checkbox icheck">' !!}

                <label @if($inline)class="checkbox-inline"@endif>
                    <input type="checkbox" name="{{$name}}[]" value="{{$option}}" class="{{$class}}" {{ false !== array_search($option, array_filter(old($column, $value ?? []))) || ($value === null && in_array($option, $checked)) ?'checked':'' }} {!! $attributes !!} />&nbsp;{{$label}}&nbsp;&nbsp;
                </label>

            {!! $inline ? '</span>' :  '</div>' !!}

        @endforeach

        <input type="hidden" name="{{$name}}[]">

        @include('admin::form.help-block')

    </div>
</div>
