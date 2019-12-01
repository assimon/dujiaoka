@foreach($css as $c)
    <link rel="stylesheet" href="{{ admin_asset("$c") }}">
@endforeach