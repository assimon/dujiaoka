<select class="form-control {{ $class }}" name="{{$name}}[]" multiple style="width: 100%;">
    <option></option>
    @foreach($options as $select => $option)
        <option value="{{$select}}" {{ in_array((string)$select, request($name, []))  ?'selected':'' }}>{{$option}}</option>
    @endforeach
</select>