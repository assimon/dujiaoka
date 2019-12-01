<tfoot>
    <tr>
        @foreach($columns as $column)
            <td class="{{ $column['class'] }}">{!! $column['value'] !!}</td>
        @endforeach
    </tr>
</tfoot>


