<?php

namespace Encore\Admin\Show;

use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Relation extends Field
{
    /**
     * Relation name.
     *
     * @var string
     */
    protected $name;

    /**
     * Relation panel builder.
     *
     * @var callable
     */
    protected $builder;

    /**
     * Relation panel title.
     *
     * @var string
     */
    protected $title;

    /**
     * Parent model.
     *
     * @var Model
     */
    protected $model;

    /**
     * Relation constructor.
     *
     * @param string   $name
     * @param callable $builder
     * @param string   $title
     */
    public function __construct($name, $builder, $title = '')
    {
        $this->name = $name;
        $this->builder = $builder;
        $this->title = $this->formatLabel($title);
    }

    /**
     * Set parent model for relation.
     *
     * @param Model $model
     *
     * @return $this
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get null renderable instance.
     *
     * @return Renderable|__anonymous@1539
     */
    protected function getNullRenderable()
    {
        return new class() implements Renderable {
            public function render()
            {
            }
        };
    }

    /**
     * Render this relation panel.
     *
     * @return string
     */
    public function render()
    {
        $relation = $this->model->{$this->name}();

        $renderable = $this->getNullRenderable();

        if ($relation    instanceof HasOne
            || $relation instanceof BelongsTo
            || $relation instanceof MorphOne
        ) {
            $model = $this->model->{$this->name};

            if (!$model instanceof Model) {
                $model = $relation->getRelated();
            }

            $renderable = new Show($model, $this->builder);

            $renderable->panel()->title($this->title);
        }

        if ($relation    instanceof HasMany
            || $relation instanceof MorphMany
            || $relation instanceof BelongsToMany
            || $relation instanceof HasManyThrough
        ) {
            $renderable = new Grid($relation->getRelated(), $this->builder);

            $renderable->setName($this->name)
                ->setTitle($this->title)
                ->setRelation($relation);
        }

        return $renderable->render();
    }
}
