<?php

namespace Encore\Admin\Show;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractField implements Renderable
{
    /**
     * Field value.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Current field model.
     *
     * @var Model
     */
    protected $model;

    /**
     * If this field show with a border.
     *
     * @var bool
     */
    public $border = true;

    /**
     * If this field show escaped contents.
     *
     * @var bool
     */
    public $escape = true;

    /**
     * @param mixed $value
     *
     * @return AbstractField $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param Model $model
     *
     * @return AbstractField $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return mixed
     */
    abstract public function render();
}
