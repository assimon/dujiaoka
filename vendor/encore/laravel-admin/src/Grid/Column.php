<?php

namespace Encore\Admin\Grid;

use Carbon\Carbon;
use Closure;
use Encore\Admin\Actions\RowAction;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\AbstractDisplayer;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class Column.
 *
 * @method $this editable()
 * @method $this switch ($states = [])
 * @method $this switchGroup($columns = [], $states = [])
 * @method $this select($options = [])
 * @method $this image($server = '', $width = 200, $height = 200)
 * @method $this label($style = 'success')
 * @method $this button($style = null)
 * @method $this link($href = '', $target = '_blank')
 * @method $this badge($style = 'red')
 * @method $this progress($style = 'primary', $size = 'sm', $max = 100)
 * @method $this radio($options = [])
 * @method $this checkbox($options = [])
 * @method $this orderable($column, $label = '')
 * @method $this table($titles = [])
 * @method $this expand($callback = null)
 * @method $this modal($callback = null)
 * @method $this carousel(int $width = 300, int $height = 200, $server = '')
 * @method $this downloadable($server = '')
 * @method $this copyable()
 * @method $this qrcode($formatter = null, $width = 150, $height = 150)
 * @method $this prefix($prefix, $delimiter = '&nbsp;')
 * @method $this suffix($suffix, $delimiter = '&nbsp;')
 * @method $this secret($dotCount = 6)
 */
class Column
{
    use Column\HasHeader;

    const SELECT_COLUMN_NAME = '__row_selector__';

    const ACTION_COLUMN_NAME = '__actions__';

    /**
     * @var Grid
     */
    protected $grid;

    /**
     * Name of column.
     *
     * @var string
     */
    protected $name;

    /**
     * Label of column.
     *
     * @var string
     */
    protected $label;

    /**
     * Original value of column.
     *
     * @var mixed
     */
    protected $original;

    /**
     * Attributes of column.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Relation name.
     *
     * @var bool
     */
    protected $relation = false;

    /**
     * Relation column.
     *
     * @var string
     */
    protected $relationColumn;

    /**
     * Original grid data.
     *
     * @var Collection
     */
    protected static $originalGridModels;

    /**
     * @var []Closure
     */
    protected $displayCallbacks = [];

    /**
     * Displayers for grid column.
     *
     * @var array
     */
    public static $displayers = [
        'editable'    => Displayers\Editable::class,
        'switch'      => Displayers\SwitchDisplay::class,
        'switchGroup' => Displayers\SwitchGroup::class,
        'select'      => Displayers\Select::class,
        'image'       => Displayers\Image::class,
        'label'       => Displayers\Label::class,
        'button'      => Displayers\Button::class,
        'link'        => Displayers\Link::class,
        'badge'       => Displayers\Badge::class,
        'progressBar' => Displayers\ProgressBar::class,
        'progress'    => Displayers\ProgressBar::class,
        'radio'       => Displayers\Radio::class,
        'checkbox'    => Displayers\Checkbox::class,
        'orderable'   => Displayers\Orderable::class,
        'table'       => Displayers\Table::class,
        'expand'      => Displayers\Expand::class,
        'modal'       => Displayers\Modal::class,
        'carousel'    => Displayers\Carousel::class,
        'downloadable'=> Displayers\Downloadable::class,
        'copyable'    => Displayers\Copyable::class,
        'qrcode'      => Displayers\QRCode::class,
        'prefix'      => Displayers\Prefix::class,
        'suffix'      => Displayers\Suffix::class,
        'secret'      => Displayers\Secret::class,
    ];

    /**
     * Defined columns.
     *
     * @var array
     */
    public static $defined = [];

    /**
     * @var array
     */
    protected static $htmlAttributes = [];

    /**
     * @var array
     */
    protected static $rowAttributes = [];

    /**
     * @var Model
     */
    protected static $model;

    /**
     * @var bool
     */
    protected $searchable = false;

    /**
     * @param string $name
     * @param string $label
     */
    public function __construct($name, $label)
    {
        $this->name = $name;

        $this->label = $this->formatLabel($label);

        $this->initAttributes();
    }

    /**
     * Initialize column attributes.
     */
    protected function initAttributes()
    {
        $name = str_replace('.', '-', $this->name);

        $this->setAttributes(['class' => "column-{$name}"]);
    }

    /**
     * Extend column displayer.
     *
     * @param $name
     * @param $displayer
     */
    public static function extend($name, $displayer)
    {
        static::$displayers[$name] = $displayer;
    }

    /**
     * Define a column globally.
     *
     * @param string $name
     * @param mixed  $definition
     */
    public static function define($name, $definition)
    {
        static::$defined[$name] = $definition;
    }

    /**
     * Set grid instance for column.
     *
     * @param Grid $grid
     */
    public function setGrid(Grid $grid)
    {
        $this->grid = $grid;

        $this->setModel($grid->model()->eloquent());
    }

    /**
     * Set model for column.
     *
     * @param $model
     */
    public function setModel($model)
    {
        if (is_null(static::$model) && ($model instanceof BaseModel)) {
            static::$model = $model->newInstance();
        }
    }

    /**
     * Set original data for column.
     *
     * @param Collection $collection
     */
    public static function setOriginalGridModels(Collection $collection)
    {
        static::$originalGridModels = $collection;
    }

    /**
     * Set column attributes.
     *
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttributes($attributes = [], $key = null)
    {
        if ($key) {
            static::$rowAttributes[$this->name][$key] = array_merge(
                Arr::get(static::$rowAttributes, "{$this->name}.{$key}", []),
                $attributes
            );

            return $this;
        }

        static::$htmlAttributes[$this->name] = array_merge(
            Arr::get(static::$htmlAttributes, $this->name, []),
            $attributes
        );

        return $this;
    }

    /**
     * Get column attributes.
     *
     * @param string $name
     *
     * @return mixed
     */
    public static function getAttributes($name, $key = null)
    {
        $rowAttributes = [];

        if ($key && Arr::has(static::$rowAttributes, "{$name}.{$key}")) {
            $rowAttributes = Arr::get(static::$rowAttributes, "{$name}.{$key}", []);
        }

        $columnAttributes = Arr::get(static::$htmlAttributes, $name, []);

        return array_merge($rowAttributes, $columnAttributes);
    }

    /**
     * Format attributes to html.
     *
     * @return string
     */
    public function formatHtmlAttributes()
    {
        $attrArr = [];
        foreach (static::getAttributes($this->name) as $name => $val) {
            $attrArr[] = "$name=\"$val\"";
        }

        return implode(' ', $attrArr);
    }

    /**
     * Set style of this column.
     *
     * @param string $style
     *
     * @return $this
     */
    public function style($style)
    {
        return $this->setAttributes(compact('style'));
    }

    /**
     * Set the width of column.
     *
     * @param int $width
     *
     * @return $this
     */
    public function width(int $width)
    {
        return $this->style("width: {$width}px;");
    }

    /**
     * Set the color of column.
     *
     * @param string $color
     *
     * @return $this
     */
    public function color($color)
    {
        return $this->style("color:$color;");
    }

    /**
     * Get original column value.
     *
     * @return mixed
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * Get name of this column.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        $name = str_replace('.', '-', $this->getName());

        return "column-{$name}";
    }

    /**
     * Format label.
     *
     * @param $label
     *
     * @return mixed
     */
    protected function formatLabel($label)
    {
        if ($label) {
            return $label;
        }

        $label = ucfirst($this->name);

        return __(str_replace(['.', '_'], ' ', $label));
    }

    /**
     * Get label of the column.
     *
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set relation.
     *
     * @param string $relation
     * @param string $relationColumn
     *
     * @return $this
     */
    public function setRelation($relation, $relationColumn = null)
    {
        $this->relation = $relation;
        $this->relationColumn = $relationColumn;

        return $this;
    }

    /**
     * If this column is relation column.
     *
     * @return bool
     */
    protected function isRelation()
    {
        return (bool) $this->relation;
    }

    /**
     * Mark this column as sortable.
     *
     * @param null|string $cast
     *
     * @return Column|string
     */
    public function sortable($cast = null)
    {
        return $this->addSorter($cast);
    }

    /**
     * Set cast name for sortable.
     *
     * @return $this
     *
     * @deprecated Use `$column->sortable($cast)` instead.
     */
    public function cast($cast)
    {
        $this->cast = $cast;

        return $this;
    }

    /**
     * Set help message for column.
     *
     * @param string $help
     *
     * @return $this|string
     */
    public function help($help = '')
    {
        return $this->addHelp($help);
    }

    /**
     * Set column filter.
     *
     * @param mixed|null $builder
     *
     * @return $this
     */
    public function filter($builder = null)
    {
        return $this->addFilter(...func_get_args());
    }

    /**
     * Set column as searchable.
     *
     * @return $this
     */
    public function searchable()
    {
        $this->searchable = true;

        $name = $this->getName();
        $query = request()->query();

        $this->prefix(function ($_, $original) use ($name, $query) {
            Arr::set($query, $name, $original);

            $url = request()->fullUrlWithQuery($query);

            return "<a href=\"{$url}\"><i class=\"fa fa-search\"></i></a>";
        }, '&nbsp;&nbsp;');

        return $this;
    }

    /**
     * Bind search query to grid model.
     *
     * @param Model $model
     */
    public function bindSearchQuery(Model $model)
    {
        if (!$this->searchable || !request()->has($this->getName())) {
            return;
        }

        $model->where($this->getName(), request($this->getName()));
    }

    /**
     * Add a display callback.
     *
     * @param Closure $callback
     *
     * @return $this
     */
    public function display(Closure $callback)
    {
        $this->displayCallbacks[] = $callback;

        return $this;
    }

    /**
     * Display using display abstract.
     *
     * @param string $abstract
     * @param array  $arguments
     *
     * @return $this
     */
    public function displayUsing($abstract, $arguments = [])
    {
        $grid = $this->grid;

        $column = $this;

        return $this->display(function ($value) use ($grid, $column, $abstract, $arguments) {
            /** @var AbstractDisplayer $displayer */
            $displayer = new $abstract($value, $grid, $column, $this);

            return $displayer->display(...$arguments);
        });
    }

    /**
     * Display column using array value map.
     *
     * @param array $values
     * @param null  $default
     *
     * @return $this
     */
    public function using(array $values, $default = null)
    {
        return $this->display(function ($value) use ($values, $default) {
            if (is_null($value)) {
                return $default;
            }

            return Arr::get($values, $value, $default);
        });
    }

    /**
     * Replace output value with giving map.
     *
     * @param array $replacements
     *
     * @return $this
     */
    public function replace(array $replacements)
    {
        return $this->display(function ($value) use ($replacements) {
            if (isset($replacements[$value])) {
                return $replacements[$value];
            }

            return $value;
        });
    }

    /**
     * Render this column with the given view.
     *
     * @param string $view
     *
     * @return $this
     */
    public function view($view)
    {
        return $this->display(function ($value) use ($view) {
            $model = $this;

            return view($view, compact('model', 'value'))->render();
        });
    }

    /**
     * Hide this column by default.
     *
     * @return $this
     */
    public function hide()
    {
        $this->grid->hideColumns($this->getName());

        return $this;
    }

    /**
     * Add column to total-row.
     *
     * @param null $display
     *
     * @return $this
     */
    public function totalRow($display = null)
    {
        $this->grid->addTotalRow($this->name, $display);

        return $this;
    }

    /**
     * Convert file size to a human readable format like `100mb`.
     *
     * @return $this
     */
    public function filesize()
    {
        return $this->display(function ($value) {
            return file_size($value);
        });
    }

    /**
     * Display the fields in the email format as gavatar.
     *
     * @param int $size
     *
     * @return $this
     */
    public function gravatar($size = 30)
    {
        return $this->display(function ($value) use ($size) {
            $src = sprintf(
                'https://www.gravatar.com/avatar/%s?s=%d',
                md5(strtolower($value)),
                $size
            );

            return "<img src='$src' class='img img-circle'/>";
        });
    }

    /**
     * Display field as a loading icon.
     *
     * @param array $values
     * @param array $others
     *
     * @return $this
     */
    public function loading($values = [], $others = [])
    {
        return $this->display(function ($value) use ($values, $others) {
            $values = (array) $values;

            if (in_array($value, $values)) {
                return '<i class="fa fa-refresh fa-spin text-primary"></i>';
            }

            return Arr::get($others, $value, $value);
        });
    }

    /**
     * Display column as an font-awesome icon based on it's value.
     *
     * @param array  $setting
     * @param string $default
     *
     * @return $this
     */
    public function icon(array $setting, $default = '')
    {
        return $this->display(function ($value) use ($setting, $default) {
            $fa = '';

            if (isset($setting[$value])) {
                $fa = $setting[$value];
            } elseif ($default) {
                $fa = $default;
            }

            return "<i class=\"fa fa-{$fa}\"></i>";
        });
    }

    /**
     * Return a human readable format time.
     *
     * @param null $locale
     *
     * @return $this
     */
    public function diffForHumans($locale = null)
    {
        if ($locale) {
            Carbon::setLocale($locale);
        }

        return $this->display(function ($value) {
            return Carbon::parse($value)->diffForHumans();
        });
    }

    /**
     * Returns a string formatted according to the given format string.
     *
     * @param string $format
     *
     * @return $this
     */
    public function date($format)
    {
        return $this->display(function ($value) use ($format) {
            return date($format, strtotime($value));
        });
    }

    /**
     * Display column as boolean , `✓` for true, and `✗` for false.
     *
     * @param array $map
     * @param bool  $default
     *
     * @return $this
     */
    public function bool(array $map = [], $default = false)
    {
        return $this->display(function ($value) use ($map, $default) {
            $bool = empty($map) ? boolval($value) : Arr::get($map, $value, $default);

            return $bool ? '<i class="fa fa-check text-green"></i>' : '<i class="fa fa-close text-red"></i>';
        });
    }

    /**
     * Display column using a grid row action.
     *
     * @param string $action
     *
     * @return $this
     */
    public function action($action)
    {
        if (!is_subclass_of($action, RowAction::class)) {
            throw new \InvalidArgumentException("Action class [$action] must be sub-class of [Encore\Admin\Actions\GridAction]");
        }

        $grid = $this->grid;

        return $this->display(function ($_, $column) use ($action, $grid) {
            /** @var RowAction $action */
            $action = new $action();

            return $action
                ->asColumn()
                ->setGrid($grid)
                ->setColumn($column)
                ->setRow($this);
        });
    }

    /**
     * Add a `dot` before column text.
     *
     * @param array  $options
     * @param string $default
     *
     * @return $this
     */
    public function dot($options = [], $default = '')
    {
        return $this->prefix(function ($_, $original) use ($options, $default) {
            if (is_null($original)) {
                $style = $default;
            } else {
                $style = Arr::get($options, $original);
            }

            return "<span class=\"label-{$style}\" style='width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;'></span>";
        }, '&nbsp;&nbsp;');
    }

    /**
     * If has display callbacks.
     *
     * @return bool
     */
    protected function hasDisplayCallbacks()
    {
        return !empty($this->displayCallbacks);
    }

    /**
     * Call all of the "display" callbacks column.
     *
     * @param mixed $value
     * @param int   $key
     *
     * @return mixed
     */
    protected function callDisplayCallbacks($value, $key)
    {
        foreach ($this->displayCallbacks as $callback) {
            $previous = $value;

            $callback = $this->bindOriginalRowModel($callback, $key);
            $value = call_user_func_array($callback, [$value, $this]);

            if (($value instanceof static) &&
                ($last = array_pop($this->displayCallbacks))
            ) {
                $last = $this->bindOriginalRowModel($last, $key);
                $value = call_user_func($last, $previous);
            }
        }

        return $value;
    }

    /**
     * Set original grid data to column.
     *
     * @param Closure $callback
     * @param int     $key
     *
     * @return Closure
     */
    protected function bindOriginalRowModel(Closure $callback, $key)
    {
        $rowModel = static::$originalGridModels[$key];

        return $callback->bindTo($rowModel);
    }

    /**
     * Fill all data to every column.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function fill(array $data)
    {
        foreach ($data as $key => &$row) {
            $this->original = $value = Arr::get($row, $this->name);

            $value = $this->htmlEntityEncode($value);

            Arr::set($row, $this->name, $value);

            if ($this->isDefinedColumn()) {
                $this->useDefinedColumn();
            }

            if ($this->hasDisplayCallbacks()) {
                $value = $this->callDisplayCallbacks($this->original, $key);
                Arr::set($row, $this->name, $value);
            }
        }

        return $data;
    }

    /**
     * If current column is a defined column.
     *
     * @return bool
     */
    protected function isDefinedColumn()
    {
        return array_key_exists($this->name, static::$defined);
    }

    /**
     * Use a defined column.
     *
     * @throws \Exception
     */
    protected function useDefinedColumn()
    {
        // clear all display callbacks.
        $this->displayCallbacks = [];

        $class = static::$defined[$this->name];

        if ($class instanceof Closure) {
            $this->display($class);

            return;
        }

        if (!class_exists($class) || !is_subclass_of($class, AbstractDisplayer::class)) {
            throw new \Exception("Invalid column definition [$class]");
        }

        $grid = $this->grid;
        $column = $this;

        $this->display(function ($value) use ($grid, $column, $class) {
            /** @var AbstractDisplayer $definition */
            $definition = new $class($value, $grid, $column, $this);

            return $definition->display();
        });
    }

    /**
     * Convert characters to HTML entities recursively.
     *
     * @param array|string $item
     *
     * @return mixed
     */
    protected function htmlEntityEncode($item)
    {
        if (is_array($item)) {
            array_walk_recursive($item, function (&$value) {
                $value = htmlentities($value);
            });
        } else {
            $item = htmlentities($item);
        }

        return $item;
    }

    /**
     * Find a displayer to display column.
     *
     * @param string $abstract
     * @param array  $arguments
     *
     * @return $this
     */
    protected function resolveDisplayer($abstract, $arguments)
    {
        if (array_key_exists($abstract, static::$displayers)) {
            return $this->callBuiltinDisplayer(static::$displayers[$abstract], $arguments);
        }

        return $this->callSupportDisplayer($abstract, $arguments);
    }

    /**
     * Call Illuminate/Support displayer.
     *
     * @param string $abstract
     * @param array  $arguments
     *
     * @return $this
     */
    protected function callSupportDisplayer($abstract, $arguments)
    {
        return $this->display(function ($value) use ($abstract, $arguments) {
            if (is_array($value) || $value instanceof Arrayable) {
                return call_user_func_array([collect($value), $abstract], $arguments);
            }

            if (is_string($value)) {
                return call_user_func_array([Str::class, $abstract], array_merge([$value], $arguments));
            }

            return $value;
        });
    }

    /**
     * Call Builtin displayer.
     *
     * @param string $abstract
     * @param array  $arguments
     *
     * @return $this
     */
    protected function callBuiltinDisplayer($abstract, $arguments)
    {
        if ($abstract instanceof Closure) {
            return $this->display(function ($value) use ($abstract, $arguments) {
                return $abstract->call($this, ...array_merge([$value], $arguments));
            });
        }

        if (class_exists($abstract) && is_subclass_of($abstract, AbstractDisplayer::class)) {
            $grid = $this->grid;
            $column = $this;

            return $this->display(function ($value) use ($abstract, $grid, $column, $arguments) {
                /** @var AbstractDisplayer $displayer */
                $displayer = new $abstract($value, $grid, $column, $this);

                return $displayer->display(...$arguments);
            });
        }

        return $this;
    }

    /**
     * Passes through all unknown calls to builtin displayer or supported displayer.
     *
     * Allow fluent calls on the Column object.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return $this
     */
    public function __call($method, $arguments)
    {
        if ($this->isRelation() && !$this->relationColumn) {
            $this->name = "{$this->relation}.$method";
            $this->label = $this->formatLabel($arguments[0] ?? null);

            $this->relationColumn = $method;

            return $this;
        }

        return $this->resolveDisplayer($method, $arguments);
    }
}
