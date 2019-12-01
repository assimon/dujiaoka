<?php

namespace Encore\Admin\Grid\Column;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Model;

class RangeFilter extends Filter
{
    /**
     * @var string
     */
    protected $type;

    /**
     * RangeFilter constructor.
     *
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
        $this->class = [
            'start' => uniqid('column-filter-start-'),
            'end'   => uniqid('column-filter-end-'),
        ];
    }

    /**
     * Add a binding to the query.
     *
     * @param mixed $value
     * @param Model $model
     */
    public function addBinding($value, Model $model)
    {
        $value = array_filter((array) $value);

        if (empty($value)) {
            return;
        }

        if (!isset($value['start'])) {
            return $model->where($this->getColumnName(), '<', $value['end']);
        } elseif (!isset($value['end'])) {
            return $model->where($this->getColumnName(), '>', $value['start']);
        } else {
            return $model->whereBetween($this->getColumnName(), array_values($value));
        }
    }

    protected function addScript()
    {
        $options = [
            'locale'           => config('app.locale'),
            'allowInputToggle' => true,
        ];

        if ($this->type == 'date') {
            $options['format'] = 'YYYY-MM-DD';
        } elseif ($this->type == 'time') {
            $options['format'] = 'HH:mm:ss';
        } elseif ($this->type == 'datetime') {
            $options['format'] = 'YYYY-MM-DD HH:mm:ss';
        } else {
            return;
        }

        $options = json_encode($options);

        Admin::script("$('.{$this->class['start']},.{$this->class['end']}').datetimepicker($options);");
    }

    /**
     * Render this filter.
     *
     * @return string
     */
    public function render()
    {
        $script = <<<'SCRIPT'
$('.dropdown-menu input').click(function(e) {
    e.stopPropagation();
});
SCRIPT;

        Admin::script($script);

        $this->addScript();

        $value = $this->getFilterValue(['start' => '', 'end' => '']);
        $active = empty(array_filter($value)) ? '' : 'text-yellow';

        return <<<EOT
<span class="dropdown">
<form action="{$this->getFormAction()}" pjax-container style="display: inline-block;">
    <a href="javascript:void(0);" class="dropdown-toggle {$active}" data-toggle="dropdown">
        <i class="fa fa-filter"></i>
    </a>
    <ul class="dropdown-menu" role="menu" style="padding: 10px;box-shadow: 0 2px 3px 0 rgba(0,0,0,.2);left: -70px;border-radius: 0;">
        <li>
            <input type="text" class="form-control input-sm {$this->class['start']}" name="{$this->getColumnName()}[start]" value="{$value['start']}" autocomplete="off"/>
        </li>
        <li style="margin: 5px;"></li>
        <li>
            <input type="text" class="form-control input-sm {$this->class['start']}" name="{$this->getColumnName()}[end]"  value="{$value['end']}" autocomplete="off"/>
        </li>
        <li class="divider"></li>
        <li class="text-right">
            <button class="btn btn-sm btn-primary btn-flat column-filter-submit pull-left" data-loading-text="{$this->trans('search')}..."><i class="fa fa-search"></i>&nbsp;&nbsp;{$this->trans('search')}</button>
            <button class="btn btn-sm btn-default btn-flat column-filter-all" data-loading-text="..."><i class="fa fa-undo"></i></button>
        </li>
    </ul>
    </form>
</span>
EOT;
    }
}
