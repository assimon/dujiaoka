<?php

namespace Encore\Admin\Grid\Column;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Model;

class InputFilter extends Filter
{
    /**
     * @var string
     */
    protected $type;

    /**
     * InputFilter constructor.
     *
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
        $this->class = uniqid('column-filter-');
    }

    /**
     * Add a binding to the query.
     *
     * @param string     $value
     * @param Model|null $model
     */
    public function addBinding($value, Model $model)
    {
        if (empty($value)) {
            return;
        }

        if ($this->type == 'like') {
            $model->where($this->getColumnName(), 'like', "%{$value}%");

            return;
        }

        if (in_array($this->type, ['date', 'time'])) {
            $method = 'where'.ucfirst($this->type);
            $model->{$method}($this->getColumnName(), $value);

            return;
        }

        $model->where($this->getColumnName(), $value);
    }

    /**
     * Add script to page.
     *
     * @return void
     */
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

        Admin::script("$('.{$this->class}').datetimepicker($options);");
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

        $value = $this->getFilterValue();

        $active = empty($value) ? '' : 'text-yellow';

        return <<<EOT
<span class="dropdown">
    <form action="{$this->getFormAction()}" pjax-container style="display: inline-block;">
    <a href="javascript:void(0);" class="dropdown-toggle {$active}" data-toggle="dropdown">
        <i class="fa fa-filter"></i>
    </a>
    <ul class="dropdown-menu" role="menu" style="padding: 10px;box-shadow: 0 2px 3px 0 rgba(0,0,0,.2);left: -70px;border-radius: 0;">
        <li>
            <input type="text" name="{$this->getColumnName()}" value="{$this->getFilterValue()}" class="form-control input-sm {$this->class}" autocomplete="off"/>
        </li>
        <li class="divider"></li>
        <li class="text-right">
            <button class="btn btn-sm btn-flat btn-primary column-filter-submit pull-left" data-loading-text="{$this->trans('search')}..."><i class="fa fa-search"></i>&nbsp;&nbsp;{$this->trans('search')}</button>
            <button class="btn btn-sm btn-flat btn-default column-filter-all" data-loading-text="..."><i class="fa fa-undo"></i></button>
        </li>
    </ul>
    </form>
</span>
EOT;
    }
}
