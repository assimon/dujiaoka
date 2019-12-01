<div class="box">
    @if(isset($title))
        <div class="box-header with-border">
            <h3 class="box-title"> {{ $title }}</h3>
        </div>
    @endif

    <div class="box-header with-border">
        <div class="pull-right">
            {!! $grid->renderExportButton() !!}
            {!! $grid->renderCreateButton() !!}
        </div>
        <span>
            {!! $grid->renderHeaderTools() !!}
        </span>
    </div>

    {!! $grid->renderFilter() !!}

    <div class="box-body table-responsive no-padding">
        <ul class="mailbox-attachments clearfix">
            @foreach($grid->rows() as $row)
                <li>
                    <span class="mailbox-attachment-icon has-img">
                        <img src="{!! isset($server) ? $server . '/' . $row->column($image_column) : \Illuminate\Support\Facades\Storage::disk(config('admin.upload.disk'))->url($row->column($image_column)) !!}" alt="Attachment">
                    </span>
                    <div class="mailbox-attachment-info">
                        <a href="#" class="mailbox-attachment-name" style="word-break:break-all;">
                            <i class="fa fa-camera"></i>&nbsp;&nbsp;
                            {!! isset($text_column) ? $row->column($text_column) : '' !!}
                        </a>
                        <span class="mailbox-attachment-size">
                          <input type="checkbox" class="grid-item" data-id="{{ $row->id() }}" />
                            <span class="pull-right">
                                {!! $row->column(\Encore\Admin\Grid\Column::ACTION_COLUMN_NAME) !!}
                                <a href="{!! isset($server) ? $server . '/' . $row->column($image_column) : \Illuminate\Support\Facades\Storage::disk(config('admin.upload.disk'))->url($row->column($image_column)) !!}" target="_blank" download="custom-filename.jpg">
                                    <i class="fa fa-cloud-download"></i>
                                </a>
                            </span>
                        </span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="box-footer clearfix">
        {!! $grid->paginator() !!}
    </div>
    <!-- /.box-body -->
</div>