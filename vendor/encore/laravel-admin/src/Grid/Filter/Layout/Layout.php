<?php

namespace Encore\Admin\Grid\Filter\Layout;

use Encore\Admin\Grid\Filter;
use Illuminate\Support\Collection;

class Layout
{
    /**
     * @var Collection
     */
    protected $columns;

    /**
     * @var Column
     */
    protected $current;

    /**
     * @var Filter
     */
    protected $parent;

    /**
     * Layout constructor.
     *
     * @param Filter $filter
     */
    public function __construct(Filter $filter)
    {
        $this->parent = $filter;

        $this->current = new Column();

        $this->columns = new Collection();
    }

    /**
     * Add a filter to layout column.
     *
     * @param Filter\AbstractFilter $filter
     */
    public function addFilter(Filter\AbstractFilter $filter)
    {
        $this->current->addFilter($filter);
    }

    /**
     * Add a new column in layout.
     *
     * @param int      $width
     * @param \Closure $closure
     */
    public function column($width, \Closure $closure)
    {
        if ($this->columns->isEmpty()) {
            $column = $this->current;

            $column->setWidth($width);
        } else {
            $column = new Column($width);

            $this->current = $column;
        }

        $this->columns->push($column);

        $closure($this->parent);
    }

    /**
     * Get all columns in filter layout.
     *
     * @return Collection
     */
    public function columns()
    {
        if ($this->columns->isEmpty()) {
            $this->columns->push($this->current);
        }

        return $this->columns;
    }

    /**
     * Remove the default ID filter of the default(first) column.
     */
    public function removeDefaultIDFilter()
    {
        $this->columns()
            ->first()
            ->filters()
            ->shift();
    }
}
