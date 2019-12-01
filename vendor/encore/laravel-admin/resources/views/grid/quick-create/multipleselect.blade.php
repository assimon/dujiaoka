<style>
    .quick-create .select2-selection--multiple {
        padding: 0 !important;
        height: 30px !important;
        width: 200px !important;
        min-height: 30px !important;
    }
</style>

<div class="input-group input-group-sm">
    <select class="form-control {{$class}}" style="width: 100%;" name="{{$name}}" {!! $attributes !!} multiple data-placeholder="{{ $label }}">

        <option value=""></option>
        @foreach($options as $select => $option)
            <option value="{{$select}}" {{ $select == old($column, $value) ?'selected':'' }}>{{$option}}</option>
        @endforeach
    </select>
</div>

