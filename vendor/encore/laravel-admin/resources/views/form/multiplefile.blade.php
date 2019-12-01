<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <input type="file" class="{{$class}}" name="{{$name}}[]" {!! $attributes !!} />
        @isset($sortable)
        <input type="hidden" class="{{$class}}_sort" name="{{ $sort_flag."[$name]" }}"/>
        @endisset

        @include('admin::form.help-block')

    </div>
</div>
