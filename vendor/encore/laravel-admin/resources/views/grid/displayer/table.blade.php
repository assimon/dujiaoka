<table class="table table-hover" style="margin-bottom: 0;">
    <thead>
    <tr>
        @foreach($titles as $column => $title)
        <th>{{ $title }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($data as $datum)
    <tr>
        @foreach($datum as $key => $value)
            <td>{{ $value }}</td>
        @endforeach
    </tr>
    @endforeach
    </tbody>
</table>