<?php

namespace Encore\Admin\Grid\Concerns;

use Encore\Admin\Grid\Tools\QuickCreate;

trait HasQuickCreate
{
    protected $hasQuickCreate = false;

    /**
     * @var QuickCreate
     */
    protected $quickCreate;

    /**
     * @param \Closure $closure
     *
     * @return $this
     */
    public function quickCreate(\Closure $closure)
    {
        $this->quickCreate = new QuickCreate($this);

        call_user_func($closure, $this->quickCreate);

        return $this;
    }

    /**
     * Indicates grid has quick-create.
     *
     * @return bool
     */
    public function hasQuickCreate()
    {
        return !is_null($this->quickCreate);
    }

    /**
     * Render quick-create form.
     *
     * @return array|string
     */
    public function renderQuickCreate()
    {
        $columnCount = $this->visibleColumns()->count();

        return $this->quickCreate->render($columnCount);
    }
}
