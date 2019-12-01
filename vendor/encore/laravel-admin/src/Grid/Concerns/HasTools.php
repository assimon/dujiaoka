<?php

namespace Encore\Admin\Grid\Concerns;

use Closure;
use Encore\Admin\Grid\Tools;

trait HasTools
{
    use HasQuickSearch;

    /**
     * Header tools.
     *
     * @var Tools
     */
    public $tools;

    /**
     * Setup grid tools.
     *
     * @return $this
     */
    protected function initTools()
    {
        $this->tools = new Tools($this);

        return $this;
    }

    /**
     * Disable header tools.
     *
     * @return $this
     */
    public function disableTools(bool $disable = true)
    {
        return $this->option('show_tools', !$disable);
    }

    /**
     * Setup grid tools.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public function tools(Closure $callback)
    {
        call_user_func($callback, $this->tools);
    }

    /**
     * Render custom tools.
     *
     * @return string
     */
    public function renderHeaderTools()
    {
        return $this->tools->render();
    }

    /**
     * If grid show header tools.
     *
     * @return bool
     */
    public function showTools()
    {
        return $this->option('show_tools');
    }
}
