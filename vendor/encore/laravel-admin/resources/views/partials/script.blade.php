<script data-exec-on-popstate>

    $(function () {
        @foreach($script as $s)
            {!! $s !!}
        @endforeach
    });
</script>