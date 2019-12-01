<?php

namespace Encore\Admin\Grid;

use Encore\Admin\Actions\GridAction;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Tools\AbstractTool;
use Encore\Admin\Grid\Tools\BatchActions;
use Encore\Admin\Grid\Tools\FilterButton;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;

class Tools implements Renderable
{
    /**
     * Parent grid.
     *
     * @var Grid
     */
    protected $grid;

    /**
     * Collection of tools.
     *
     * @var Collection
     */
    protected $tools;

    /**
     * Create a new Tools instance.
     *
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;

        $this->tools = new Collection();

        $this->appendDefaultTools();
    }

    /**
     * Append default tools.
     */
    protected function appendDefaultTools()
    {
        $this->append(new BatchActions())
            ->append(new FilterButton());
    }

    /**
     * Append tools.
     *
     * @param AbstractTool|string $tool
     *
     * @return $this
     */
    public function append($tool)
    {
        if ($tool instanceof GridAction) {
            $tool->setGrid($this->grid);
        }

        $this->tools->push($tool);

        return $this;
    }

    /**
     * Prepend a tool.
     *
     * @param AbstractTool|string $tool
     *
     * @return $this
     */
    public function prepend($tool)
    {
        $this->tools->prepend($tool);

        return $this;
    }

    /**
     * Disable filter button.
     *
     * @return void
     */
    public function disableFilterButton(bool $disable = true)
    {
        $this->tools = $this->tools->map(function ($tool) use ($disable) {
            if ($tool instanceof FilterButton) {
                return $tool->disable($disable);
            }

            return $tool;
        });
    }

    /**
     * Disable refresh button.
     *
     * @return void
     *
     * @deprecated
     */
    public function disableRefreshButton(bool $disable = true)
    {
        //
    }

    /**
     * Disable batch actions.
     *
     * @return void
     */
    public function disableBatchActions(bool $disable = true)
    {
        $this->tools = $this->tools->map(function ($tool) use ($disable) {
            if ($tool instanceof BatchActions) {
                return $tool->disable($disable);
            }

            return $tool;
        });
    }

    /**
     * @param \Closure $closure
     */
    public function batch(\Closure $closure)
    {
        call_user_func($closure, $this->tools->first(function ($tool) {
            return $tool instanceof BatchActions;
        }));
    }

    /**
     * Render header tools bar.
     *
     * @return string
     */
    public function render()
    {
        return $this->tools->map(function ($tool) {
            if ($tool instanceof AbstractTool) {
                if (!$tool->allowed()) {
                    return '';
                }

                return $tool->setGrid($this->grid)->render();
            }

            if ($tool instanceof Renderable) {
                return $tool->render();
            }

            if ($tool instanceof Htmlable) {
                return $tool->toHtml();
            }

            return (string) $tool;
        })->implode(' ');
    }
}
