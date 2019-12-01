<div class="form-group {!! !$errors->has($errorKey) ?: 'has-error' !!}">
    <label for="{{$id}}" class="col-sm-2 control-label">{{$label}}</label>
    <div class="col-sm-8">
        @include('admin::form.error')
        <textarea type='text/plain' id="{{$id}}" name="{{$name}}" placeholder="{{ $placeholder }}" {!! $attributes !!}  class='ueditor'>{!! old($column, $value) !!}</textarea>
        @include('admin::form.help-block')
    </div>
</div>
