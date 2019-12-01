<div {!! $attributes !!}>
    @if($title || $tools)
        <div class="box-header with-border">
            <h3 class="box-title">{{ $title }}</h3>
            <div class="box-tools pull-right">
                @foreach($tools as $tool)
                    {!! $tool !!}
                @endforeach
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
    @endif
    <div class="box-body" style="display: block;">
        {!! $content !!}
    </div><!-- /.box-body -->
    @if($footer)
        <div class="box-footer">
            {!! $footer !!}
        </div><!-- /.box-footer-->
    @endif
</div>
{{-- 由于widget box 有可能会用于expand，加载完页面后还没有对应的html，导致script失败，故只能和html写在一起。 --}}
<script>
    {!! $script !!}
</script>