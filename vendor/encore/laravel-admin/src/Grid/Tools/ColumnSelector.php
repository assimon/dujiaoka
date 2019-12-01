<?php

namespace Encore\Admin\Grid\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid;
use Illuminate\Support\Collection;

class ColumnSelector extends AbstractTool
{
    const SELECT_COLUMN_NAME = '_columns_';

    /**
     * @var Grid
     */
    protected $grid;

    /**
     * @var array
     */
    protected static $ignoredColumns = [
        Grid\Column::SELECT_COLUMN_NAME,
        Grid\Column::ACTION_COLUMN_NAME,
    ];

    /**
     * Create a new Export button instance.
     *
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function render()
    {
        if (!$this->grid->showColumnSelector()) {
            return '';
        }

        $show = $this->grid->visibleColumnNames();

        $lists = $this->getGridColumns()->map(function ($label, $key) use ($show) {
            if (empty($show)) {
                $checked = 'checked';
            } else {
                $checked = in_array($key, $show) ? 'checked' : '';
            }

            return <<<HTML
<li class="checkbox icheck" style="margin: 0;">
    <label style="width: 100%;padding: 3px;">
        <input type="checkbox" class="column-select-item" value="{$key}" {$checked}/>&nbsp;&nbsp;&nbsp;{$label}
    </label>
</li>
HTML;
        })->implode("\r\n");

        $btns = [
            'all'    => __('admin.all'),
            'submit' => __('admin.submit'),
        ];

        $this->setupScript();

        return <<<EOT

<div class="dropdown pull-right column-selector" style="margin-right: 10px">
    <button type="button" class="btn btn-sm btn-instagram dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-table"></i>
        &nbsp;
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu" style="padding: 10px;height: auto;max-height: 500px;overflow-x: hidden;">
        <li>
            <ul style='padding: 0;'>
                {$lists}
            </ul>
        </li>
        <li class="divider"></li>
        <li class="text-right">
            <button class="btn btn-sm btn-default column-select-all">{$btns['all']}</button>&nbsp;&nbsp;
            <button class="btn btn-sm btn-primary column-select-submit">{$btns['submit']}</button>
        </li>
    </ul>
</div>
EOT;
    }

    /**
     * @return Collection
     */
    protected function getGridColumns()
    {
        return $this->grid->columns()->map(function (Grid\Column $column) {
            $name = $column->getName();

            if ($this->isColumnIgnored($name)) {
                return;
            }

            return [$name => $column->getLabel()];
        })->filter()->collapse();
    }

    /**
     * Is column ignored in column selector.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function isColumnIgnored($name)
    {
        return in_array($name, static::$ignoredColumns);
    }

    /**
     * Ignore a column to display in column selector.
     *
     * @param string|array $name
     */
    public static function ignore($name)
    {
        static::$ignoredColumns = array_merge(static::$ignoredColumns, (array) $name);
    }

    /**
     * Setup script.
     */
    protected function setupScript()
    {
        $defaults = json_encode($this->grid->getDefaultVisibleColumnNames());

        $script = <<<SCRIPT

$('.column-select-submit').on('click', function () {
    
    var defaults = $defaults;
    var selected = [];
    
    $('.column-select-item:checked').each(function () {
        selected.push($(this).val());
    });

    if (selected.length == 0) {
        return;
    }

    var url = new URL(location);
    
    if (selected.sort().toString() == defaults.sort().toString()) {
        url.searchParams.delete('_columns_');
    } else {
        url.searchParams.set('_columns_', selected.join());
    }

    $.pjax({container:'#pjax-container', url: url.toString()});
});

$('.column-select-all').on('click', function () {
    $('.column-select-item').iCheck('check');
    return false;
});

$('.column-select-item').iCheck({
    checkboxClass:'icheckbox_minimal-blue'
});

SCRIPT;

        Admin::script($script);
    }
}
