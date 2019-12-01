<?php

namespace Encore\Admin;

use Encore\Admin\Show\Divider;
use Encore\Admin\Show\Field;
use Encore\Admin\Show\Panel;
use Encore\Admin\Show\Relation;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\Relation as EloquentRelation;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Show implements Renderable
{
    /**
     * The Eloquent model to show.
     *
     * @var Model
     */
    protected $model;

    /**
     * Show panel builder.
     *
     * @var callable
     */
    protected $builder;

    /**
     * Resource path for this show page.
     *
     * @var string
     */
    protected $resource;

    /**
     * Fields to be show.
     *
     * @var Collection
     */
    protected $fields;

    /**
     * Relations to be show.
     *
     * @var Collection
     */
    protected $relations;

    /**
     * @var Panel
     */
    protected $panel;

    /**
     * Extended fields.
     *
     * @var array
     */
    public static $extendedFields = [];

    /**
     * @var \Closure
     */
    protected static $initCallback;

    /**
     * Show constructor.
     *
     * @param Model $model
     * @param mixed $builder
     */
    public function __construct($model, $builder = null)
    {
        $this->model = $model;
        $this->builder = $builder;

        $this->initPanel();
        $this->initContents();

        if (static::$initCallback instanceof \Closure) {
            call_user_func(static::$initCallback, $this);
        }
    }

    /**
     * Initialize with user pre-defined default disables, etc.
     *
     * @param \Closure $callback
     */
    public static function init(\Closure $callback = null)
    {
        static::$initCallback = $callback;
    }

    /**
     * Register custom field.
     *
     * @param string $abstract
     * @param string $class
     *
     * @return void
     */
    public static function extend($abstract, $class)
    {
        static::$extendedFields[$abstract] = $class;
    }

    /**
     * Initialize the contents to show.
     */
    protected function initContents()
    {
        $this->fields = new Collection();
        $this->relations = new Collection();
    }

    /**
     * Initialize panel.
     */
    protected function initPanel()
    {
        $this->panel = new Panel($this);
    }

    /**
     * Get panel instance.
     *
     * @return Panel
     */
    public function panel()
    {
        return $this->panel;
    }

    /**
     * Add a model field to show.
     *
     * @param string $name
     * @param string $label
     *
     * @return Field
     */
    public function field($name, $label = '')
    {
        return $this->addField($name, $label);
    }

    /**
     * Add multiple fields.
     *
     * @param array $fields
     *
     * @return $this
     */
    public function fields(array $fields = [])
    {
        if (!Arr::isAssoc($fields)) {
            $fields = array_combine($fields, $fields);
        }

        foreach ($fields as $field => $label) {
            $this->field($field, $label);
        }

        return $this;
    }

    /**
     * Show all fields.
     *
     * @return Show
     */
    public function all()
    {
        $fields = array_keys($this->model->getAttributes());

        return $this->fields($fields);
    }

    /**
     * Add a relation to show.
     *
     * @param string          $name
     * @param string|\Closure $label
     * @param null|\Closure   $builder
     *
     * @return Relation
     */
    public function relation($name, $label, $builder = null)
    {
        if (is_null($builder)) {
            $builder = $label;
            $label = '';
        }

        return $this->addRelation($name, $builder, $label);
    }

    /**
     * Add a model field to show.
     *
     * @param string $name
     * @param string $label
     *
     * @return Field
     */
    protected function addField($name, $label = '')
    {
        $field = new Field($name, $label);

        $field->setParent($this);

        $this->overwriteExistingField($name);

        return tap($field, function ($field) {
            $this->fields->push($field);
        });
    }

    /**
     * Add a relation panel to show.
     *
     * @param string   $name
     * @param \Closure $builder
     * @param string   $label
     *
     * @return Relation
     */
    protected function addRelation($name, $builder, $label = '')
    {
        $relation = new Relation($name, $builder, $label);

        $relation->setParent($this);

        $this->overwriteExistingRelation($name);

        return tap($relation, function ($relation) {
            $this->relations->push($relation);
        });
    }

    /**
     * Overwrite existing field.
     *
     * @param string $name
     */
    protected function overwriteExistingField($name)
    {
        if ($this->fields->isEmpty()) {
            return;
        }

        $this->fields = $this->fields->filter(
            function (Field $field) use ($name) {
                return $field->getName() != $name;
            }
        );
    }

    /**
     * Overwrite existing relation.
     *
     * @param string $name
     */
    protected function overwriteExistingRelation($name)
    {
        if ($this->relations->isEmpty()) {
            return;
        }

        $this->relations = $this->relations->filter(
            function (Relation $relation) use ($name) {
                return $relation->getName() != $name;
            }
        );
    }

    /**
     * Show a divider.
     */
    public function divider()
    {
        $this->fields->push(new Divider());
    }

    /**
     * Set resource path.
     *
     * @param string $resource
     *
     * @return $this
     */
    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource path.
     *
     * @return string
     */
    public function getResourcePath()
    {
        if (empty($this->resource)) {
            $path = request()->path();

            $segments = explode('/', $path);
            array_pop($segments);

            $this->resource = implode('/', $segments);
        }

        return url($this->resource);
    }

    /**
     * Set field and label width in fields.
     *
     * @param int $fieldWidth
     * @param int $labelWidth
     *
     * @return $this
     */
    public function setWidth($fieldWidth = 8, $labelWidth = 2)
    {
        collect($this->fields)->each(function ($field) use ($fieldWidth, $labelWidth) {
            $field->each->setWidth($fieldWidth, $labelWidth);
        });

        return $this;
    }

    /**
     * Set the model instance.
     *
     * @param Model $model
     *
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the model instance being queried.
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Add field and relation dynamically.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return bool|mixed
     */
    public function __call($method, $arguments = [])
    {
        $label = isset($arguments[0]) ? $arguments[0] : ucfirst($method);

        if ($field = $this->handleGetMutatorField($method, $label)) {
            return $field;
        }

        if ($field = $this->handleRelationField($method, $arguments)) {
            return $field;
        }

        return $this->addField($method, $label);
    }

    /**
     * Handle the get mutator field.
     *
     * @param string $method
     * @param string $label
     *
     * @return bool|Field
     */
    protected function handleGetMutatorField($method, $label)
    {
        if (is_null($this->model)) {
            return false;
        }

        if ($this->model->hasGetMutator($method)) {
            return $this->addField($method, $label);
        }

        return false;
    }

    /**
     * Handle relation field.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return $this|bool|Relation|Field
     */
    protected function handleRelationField($method, $arguments)
    {
        if (!method_exists($this->model, $method)) {
            return false;
        }

        if (!($relation = $this->model->$method()) instanceof EloquentRelation) {
            return false;
        }

        if ($relation    instanceof HasOne
            || $relation instanceof BelongsTo
            || $relation instanceof MorphOne
        ) {
            $this->model->with($method);

            if (count($arguments) == 1 && $arguments[0] instanceof \Closure) {
                return $this->addRelation($method, $arguments[0]);
            }

            if (count($arguments) == 2 && $arguments[1] instanceof \Closure) {
                return $this->addRelation($method, $arguments[1], $arguments[0]);
            }

            return $this->addField($method, Arr::get($arguments, 0))->setRelation(Str::snake($method));
        }

        if ($relation    instanceof HasMany
            || $relation instanceof MorphMany
            || $relation instanceof BelongsToMany
            || $relation instanceof HasManyThrough
        ) {
            if (empty($arguments) || (count($arguments) == 1 && is_string($arguments[0]))) {
                return $this->showRelationAsField($method, $arguments[0] ?? '');
            }

            $this->model->with($method);

            if (count($arguments) == 1 && is_callable($arguments[0])) {
                return $this->addRelation($method, $arguments[0]);
            } elseif (count($arguments) == 2 && is_callable($arguments[1])) {
                return $this->addRelation($method, $arguments[1], $arguments[0]);
            }

            throw new \InvalidArgumentException('Invalid eloquent relation');
        }

        return false;
    }

    /**
     * @param string $relation
     * @param string $label
     *
     * @return Field
     */
    protected function showRelationAsField($relation = '', $label = '')
    {
        return $this->addField($relation, $label);
    }

    /**
     * Handle model field.
     *
     * @param string $method
     * @param string $label
     *
     * @return bool|Field
     */
    protected function handleModelField($method, $label)
    {
        if (in_array($method, $this->model->getAttributes())) {
            return $this->addField($method, $label);
        }

        return false;
    }

    /**
     * Render the show panels.
     *
     * @return string
     */
    public function render()
    {
        if (is_callable($this->builder)) {
            call_user_func($this->builder, $this);
        }

        if ($this->fields->isEmpty()) {
            $this->all();
        }

        if (is_array($this->builder)) {
            $this->fields($this->builder);
        }

        $this->fields->each->setValue($this->model);
        $this->relations->each->setModel($this->model);

        $data = [
            'panel'     => $this->panel->fill($this->fields),
            'relations' => $this->relations,
        ];

        return view('admin::show', $data)->render();
    }
}
