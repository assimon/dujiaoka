<?php

namespace Encore\Admin\Actions;

use Encore\Admin\Grid;
use Illuminate\Http\Request;

/**
 * Class GridAction.
 *
 * @method retrieveModel(Request $request)
 */
abstract class GridAction extends Action
{
    /**
     * @var Grid
     */
    protected $parent;

    /**
     * @var string
     */
    public $selectorPrefix = '.grid-action-';

    /**
     * @param Grid $grid
     *
     * @return $this
     */
    public function setGrid(Grid $grid)
    {
        $this->parent = $grid;

        return $this;
    }

    /**
     * Get url path of current resource.
     *
     * @return string
     */
    public function getResource()
    {
        return $this->parent->resource();
    }

    /**
     * @return mixed
     */
    protected function getModelClass()
    {
        $model = $this->parent->model()->getOriginalModel();

        return str_replace('\\', '_', get_class($model));
    }

    /**
     * @return array
     */
    public function parameters()
    {
        return ['_model' => $this->getModelClass()];
    }
}
