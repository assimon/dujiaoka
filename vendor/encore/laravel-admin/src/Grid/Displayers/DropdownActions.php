<?php

namespace Encore\Admin\Grid\Displayers;

use Encore\Admin\Actions\RowAction;
use Encore\Admin\Admin;
use Encore\Admin\Grid\Actions\Delete;
use Encore\Admin\Grid\Actions\Edit;
use Encore\Admin\Grid\Actions\Show;

class DropdownActions extends Actions
{
    /**
     * @var array
     */
    protected $custom = [];

    /**
     * @var array
     */
    protected $default = [];

    /**
     * @var array
     */
    protected $defaultClass = [Edit::class, Show::class, Delete::class];

    /**
     * Add JS script into pages.
     *
     * @return void.
     */
    protected function addScript()
    {
        $script = <<<'SCRIPT'
$(function() {
  $('.table-responsive').on('shown.bs.dropdown', function(e) {
    var t = $(this),
      m = $(e.target).find('.dropdown-menu'),
      tb = t.offset().top + t.height(),
      mb = m.offset().top + m.outerHeight(true),
      d = 20; // Space for shadow + scrollbar.   
    if (t[0].scrollWidth > t.innerWidth()) {
      if (mb + d > tb) {
        t.css('padding-bottom', ((mb + d) - tb));
      }
    } else {
      t.css('overflow', 'visible');
    }
  }).on('hidden.bs.dropdown', function() {
    $(this).css({
      'padding-bottom': '',
      'overflow': ''
    });
  });
});
SCRIPT;

        Admin::script($script);
    }

    /**
     * @param RowAction $action
     *
     * @return $this
     */
    public function add(RowAction $action)
    {
        $this->prepareAction($action);

        array_push($this->custom, $action);

        return $this;
    }

    /**
     * Prepend default `edit` `view` `delete` actions.
     */
    protected function prependDefaultActions()
    {
        foreach ($this->defaultClass as $class) {
            /** @var RowAction $action */
            $action = new $class();

            $this->prepareAction($action);

            array_push($this->default, $action);
        }
    }

    /**
     * @param RowAction $action
     */
    protected function prepareAction(RowAction $action)
    {
        $action->setGrid($this->grid)
            ->setColumn($this->column)
            ->setRow($this->row);
    }

    /**
     * Disable view action.
     *
     * @param bool $disable
     *
     * @return $this
     */
    public function disableView(bool $disable = true)
    {
        if ($disable) {
            array_delete($this->defaultClass, Show::class);
        } elseif (!in_array(Show::class, $this->defaultClass)) {
            array_push($this->defaultClass, Show::class);
        }

        return $this;
    }

    /**
     * Disable delete.
     *
     * @param bool $disable
     *
     * @return $this.
     */
    public function disableDelete(bool $disable = true)
    {
        if ($disable) {
            array_delete($this->defaultClass, Delete::class);
        } elseif (!in_array(Delete::class, $this->defaultClass)) {
            array_push($this->defaultClass, Delete::class);
        }

        return $this;
    }

    /**
     * Disable edit.
     *
     * @param bool $disable
     *
     * @return $this
     */
    public function disableEdit(bool $disable = true)
    {
        if ($disable) {
            array_delete($this->defaultClass, Edit::class);
        } elseif (!in_array(Edit::class, $this->defaultClass)) {
            array_push($this->defaultClass, Edit::class);
        }

        return $this;
    }

    /**
     * @param null|\Closure $callback
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function display($callback = null)
    {
        $this->addScript();

        if ($callback instanceof \Closure) {
            $callback->call($this, $this);
        }

        $this->prependDefaultActions();

        $actions = [
            'default' => $this->default,
            'custom'  => $this->custom,
        ];

        return view('admin::grid.dropdown-actions', $actions);
    }
}
