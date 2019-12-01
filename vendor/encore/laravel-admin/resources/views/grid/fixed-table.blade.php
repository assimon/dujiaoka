<div class="box">
    @if(isset($title))
    <div class="box-header with-border">
        <h3 class="box-title"> {{ $title }}</h3>
    </div>
    @endif

    @if ( $grid->showTools() || $grid->showExportBtn() || $grid->showCreateBtn() )
    <div class="box-header with-border">
        <div class="pull-right">
            {!! $grid->renderColumnSelector() !!}
            {!! $grid->renderExportButton() !!}
            {!! $grid->renderCreateButton() !!}
        </div>
        @if ( $grid->showTools() )
        <div class="pull-left">
            {!! $grid->renderHeaderTools() !!}
        </div>
        @endif
    </div>
    @endif

    {!! $grid->renderFilter() !!}

    {!! $grid->renderHeader() !!}

    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <div class="tables-container">
            <div class="table-wrap table-main">
                <table class="table " id="{{ $grid->tableID }}">
                    <thead>
                        <tr>
                            @foreach($grid->visibleColumns() as $column)
                            <th {!! $column->formatHtmlAttributes() !!}>{{$column->getLabel()}}{!! $column->renderHeader() !!}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($grid->rows() as $row)
                        <tr {!! $row->getRowAttributes() !!}>
                            @foreach($grid->visibleColumnNames() as $name)
                            <td {!! $row->getColumnAttributes($name) !!} class="column-{!! $name !!}">
                                {!! $row->column($name) !!}
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>

                    {!! $grid->renderTotalRow() !!}

                </table>
            </div>

            @if($grid->leftVisibleColumns()->isNotEmpty())
            <div class="table-wrap table-fixed table-fixed-left">
                <table class="table ">
                    <thead>
                    <tr>
                        @foreach($grid->leftVisibleColumns() as $column)
                            <th {!! $column->formatHtmlAttributes() !!}>{{$column->getLabel()}}{!! $column->renderHeader() !!}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($grid->rows() as $row)
                        <tr {!! $row->getRowAttributes() !!}>
                            @foreach($grid->leftVisibleColumns() as $column)
                                @php
                                    $name = $column->getName()
                                @endphp
                                <td {!! $row->getColumnAttributes($name) !!} class="column-{!! $name !!}">
                                    {!! $row->column($name) !!}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>

                    {!! $grid->renderTotalRow($grid->leftVisibleColumns()) !!}

                </table>
            </div>
            @endif

            @if($grid->rightVisibleColumns()->isNotEmpty())
            <div class="table-wrap table-fixed table-fixed-right">
                <table class="table ">
                    <thead>
                    <tr>
                        @foreach($grid->rightVisibleColumns() as $column)
                            <th {!! $column->formatHtmlAttributes() !!}>{{$column->getLabel()}}{!! $column->renderHeader() !!}</th>
                        @endforeach
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($grid->rows() as $row)
                        <tr {!! $row->getRowAttributes() !!}>
                            @foreach($grid->rightVisibleColumns() as $column)
                                @php
                                $name = $column->getName()
                                @endphp
                                <td {!! $row->getColumnAttributes($name) !!} class="column-{!! $name !!}">
                                    {!! $row->column($name) !!}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>

                    {!! $grid->renderTotalRow($grid->rightVisibleColumns()) !!}

                </table>
            </div>
            @endif
        </div>
    </div>

    {!! $grid->renderFooter() !!}

    <div class="box-footer clearfix">
        {!! $grid->paginator() !!}
    </div>
    <!-- /.box-body -->
</div>
