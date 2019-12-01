<style>
    .quick-create .select2-selection--single {
        padding: 3px 12px !important;
        height: 30px !important;
        width: 150px !important;
    }
</style>

<div class="input-group input-group-sm">
    <select class="form-control {{$class}}" style="width: 100%;" name="{{$name}}" {!! $attributes !!} >

        <option value=""></option>
        @foreach($options as $select => $option)
            <option value="{{$select}}" {{ $select == old($column, $value) ?'selected':'' }}>{{$option}}</option>
        @endforeach
    </select>
</div>

