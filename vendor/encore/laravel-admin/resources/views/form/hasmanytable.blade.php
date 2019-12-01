<style>
    td .form-group {
        margin-bottom: 0 !important;
    }
</style>

<div class="row">
    <div class="{{$viewClass['label']}}"><h4 class="pull-right">{{ $label }}</h4></div>
    <div class="{{$viewClass['field']}}">
        <div id="has-many-{{$column}}" style="margin-top: 15px;">
            <table class="table table-has-many has-many-{{$column}}">
                <thead>
                <tr>
                    @foreach($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach

                    <th class="hidden"></th>

                    @if($options['allowDelete'])
                        <th></th>
                    @endif
                </tr>
                </thead>
                <tbody class="has-many-{{$column}}-forms">
                @foreach($forms as $pk => $form)
                    <tr class="has-many-{{$column}}-form fields-group">

                        <?php $hidden = ''; ?>

                        @foreach($form->fields() as $field)

                            @if (is_a($field, \Encore\Admin\Form\Field\Hidden::class))
                                <?php $hidden .= $field->render(); ?>
                                @continue
                            @endif

                            <td>{!! $field->setLabelClass(['hidden'])->setWidth(12, 0)->render() !!}</td>
                        @endforeach

                        <td class="hidden">{!! $hidden !!}</td>

                        @if($options['allowDelete'])
                            <td class="form-group">
                                <div>
                                    <div class="remove btn btn-warning btn-sm pull-right"><i class="fa fa-trash">&nbsp;</i>{{ trans('admin.remove') }}</div>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>

            <template class="{{$column}}-tpl">
                <tr class="has-many-{{$column}}-form fields-group">

                    {!! $template !!}

                    <td class="form-group">
                        <div>
                            <div class="remove btn btn-warning btn-sm pull-right"><i class="fa fa-trash">&nbsp;</i>{{ trans('admin.remove') }}</div>
                        </div>
                    </td>
                </tr>
            </template>

            @if($options['allowCreate'])
                <div class="form-group">
                    <div class="{{$viewClass['field']}}">
                        <div class="add btn btn-success btn-sm"><i class="fa fa-save"></i>&nbsp;{{ trans('admin.new') }}</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<hr style="margin-top: 0px;">

