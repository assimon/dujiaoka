<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <select class="form-control {{$class}}" style="width: 100%;" name="{{$name}}[]" multiple="multiple" data-placeholder="{{ $placeholder }}" {!! $attributes !!} >

            @foreach($options as $key => $option)
                <option value="{{ $keyAsValue ? $key : $option}}" {{ in_array($option, $value) ? 'selected' : '' }}>{{$option}}</option>
            @endforeach

        </select>
        <input type="hidden" name="{{$name}}[]" />

        @include('admin::form.help-block')

    </div>
</div>
