<?php

namespace Encore\Admin\Grid\Filter\Layout;

use Encore\Admin\Grid\Filter\AbstractFilter;
use Illuminate\Support\Collection;

class Column
{
    /**
     * @var Collection
     */
    protected $filters;

    /**
     * @var int
     */
    protected $width;

    /**
     * Column constructor.
     *
     * @param int $width
     */
    public function __construct($width = 12)
    {
        $this->width = $width;
        $this->filters = new Collection();
    }

    /**
     * Add a filter to this column.
     *
     * @param AbstractFilter $filter
     */
    public function addFilter(AbstractFilter $filter)
    {
        $this->filters->push($filter);
    }

    /**
     * Get all filters in this column.
     *
     * @return Collection
     */
    public function filters()
    {
        return $this->filters;
    }

    /**
     * Set column width.
     *
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * Get column width.
     *
     * @return int
     */
    public function width()
    {
        return $this->width;
    }

    /**
     * Remove filter from column by id.
     */
    public function removeFilterByID($id)
    {
        $this->filters = $this->filters->reject(function (AbstractFilter $filter) use ($id) {
            return $filter->getId() == $id;
        });
    }
}
