<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Dependencies</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>

    <!-- /.box-header -->
    <div class="box-body dependencies">
        <div class="table-responsive">
            <table class="table table-striped">
                @foreach($dependencies as $dependency => $version)
                <tr>
                    <td width="240px">{{ $dependency }}</td>
                    <td><span class="label label-primary">{{ $version }}</span></td>
                </tr>
                @endforeach
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
</div>