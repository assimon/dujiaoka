<?php

namespace Encore\Admin\Grid\Tools;

use Encore\Admin\Admin;
use Illuminate\Support\Collection;

class BatchActions extends AbstractTool
{
    /**
     * @var Collection
     */
    protected $actions;

    /**
     * @var bool
     */
    protected $enableDelete = true;

    /**
     * @var bool
     */
    private $isHoldSelectAllCheckbox = false;

    /**
     * BatchActions constructor.
     */
    public function __construct()
    {
        $this->actions = new Collection();

        $this->appendDefaultAction();
    }

    /**
     * Append default action(batch delete action).
     *
     * return void
     */
    protected function appendDefaultAction()
    {
        $this->add(new BatchDelete(trans('admin.batch_delete')));
    }

    /**
     * Disable delete.
     *
     * @return $this
     */
    public function disableDelete(bool $disable = true)
    {
        $this->enableDelete = !$disable;

        return $this;
    }

    /**
     * Disable delete And Hode SelectAll Checkbox.
     *
     * @return $this
     */
    public function disableDeleteAndHodeSelectAll()
    {
        $this->enableDelete = false;

        $this->isHoldSelectAllCheckbox = true;

        return $this;
    }

    /**
     * Add a batch action.
     *
     * @param $title
     * @param BatchAction|null $action
     *
     * @return $this
     */
    public function add($title, BatchAction $action = null)
    {
        $id = $this->actions->count();

        if (func_num_args() == 1) {
            $action = $title;
        } elseif (func_num_args() == 2) {
            $action->setTitle($title);
        }

        if (method_exists($action, 'setId')) {
            $action->setId($id);
        }

        $this->actions->push($action);

        return $this;
    }

    /**
     * Setup scripts of batch actions.
     *
     * @return void
     */
    protected function setUpScripts()
    {
        Admin::script($this->script());

        foreach ($this->actions as $action) {
            $action->setGrid($this->grid);

            if (method_exists($action, 'script')) {
                Admin::script($action->script());
            }
        }
    }

    /**
     * Scripts of BatchActions button groups.
     *
     * @return string
     */
    protected function script()
    {
        $allName = $this->grid->getSelectAllName();
        $rowName = $this->grid->getGridRowName();

        $selected = trans('admin.grid_items_selected');

        return <<<EOT

$('.{$allName}').iCheck({checkboxClass:'icheckbox_minimal-blue'});

$('.{$allName}').on('ifChanged', function(event) {
    if (this.checked) {
        $('.{$rowName}-checkbox').iCheck('check');
    } else {
        $('.{$rowName}-checkbox').iCheck('uncheck');
    }
}).on('ifClicked', function () {
    if (this.checked) {
        $.admin.grid.selects = {};
    } else {
        $('.{$rowName}-checkbox').each(function () {
            var id = $(this).data('id');
            $.admin.grid.select(id);
        });
    }

    var selected = $.admin.grid.selected().length;
    
    if (selected > 0) {
        $('.{$allName}-btn').show();
    } else {
        $('.{$allName}-btn').hide();
    }
    
    $('.{$allName}-btn .selected').html("{$selected}".replace('{n}', selected));
});

EOT;
    }

    /**
     * Render BatchActions button groups.
     *
     * @return string
     */
    public function render()
    {
        if (!$this->enableDelete) {
            $this->actions->shift();
        }

        $this->setUpScripts();

        $data = [
            'actions'                 => $this->actions,
            'selectAllName'           => $this->grid->getSelectAllName(),
            'isHoldSelectAllCheckbox' => $this->isHoldSelectAllCheckbox,
        ];

        return view('admin::grid.batch-actions', $data)->render();
    }
}
