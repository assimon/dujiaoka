<?php

namespace Encore\Admin\Grid\Exporters;

use Encore\Admin\Grid;

abstract class AbstractExporter implements ExporterInterface
{
    /**
     * @var \Encore\Admin\Grid
     */
    protected $grid;

    /**
     * @var int
     */
    protected $page;

    /**
     * Create a new exporter instance.
     *
     * @param $grid
     */
    public function __construct(Grid $grid = null)
    {
        if ($grid) {
            $this->setGrid($grid);
        }
    }

    /**
     * Set grid for exporter.
     *
     * @param Grid $grid
     *
     * @return $this
     */
    public function setGrid(Grid $grid)
    {
        $this->grid = $grid;

        return $this;
    }

    /**
     * Get table of grid.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->grid->model()->eloquent()->getTable();
    }

    /**
     * Get data with export query.
     *
     * @param bool $toArray
     *
     * @return array|\Illuminate\Support\Collection|mixed
     */
    public function getData($toArray = true)
    {
        return $this->grid->getFilter()->execute($toArray);
    }

    /**
     * @param callable $callback
     * @param int      $count
     *
     * @return bool
     */
    public function chunk(callable $callback, $count = 100)
    {
        return $this->grid->getFilter()->chunk($callback, $count);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCollection()
    {
        return collect($this->getData());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getQuery()
    {
        $model = $this->grid->getFilter()->getModel();

        $queryBuilder = $model->getQueryBuilder();

        // Export data of giving page number.
        if ($this->page) {
            $keyName = $this->grid->getKeyName();
            $perPage = request($model->getPerPageName(), $model->getPerPage());

            $scope = (clone $queryBuilder)
                ->select([$keyName])
                ->setEagerLoads([])
                ->forPage($this->page, $perPage)->get();

            $queryBuilder->whereIn($keyName, $scope->pluck($keyName));
        }

        return $queryBuilder;
    }

    /**
     * Export data with scope.
     *
     * @param string $scope
     *
     * @return $this
     */
    public function withScope($scope)
    {
        if ($scope == Grid\Exporter::SCOPE_ALL) {
            return $this;
        }

        list($scope, $args) = explode(':', $scope);

        if ($scope == Grid\Exporter::SCOPE_CURRENT_PAGE) {
            $this->grid->model()->usePaginate(true);
            $this->page = $args ?: 1;
        }

        if ($scope == Grid\Exporter::SCOPE_SELECTED_ROWS) {
            $selected = explode(',', $args);
            $this->grid->model()->whereIn($this->grid->getKeyName(), $selected);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function export();
}
