<?php

namespace Encore\Admin\Grid\Column;

use Encore\Admin\Grid\Column;
use Encore\Admin\Grid\Model;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Arr;

class Filter implements Renderable
{
    /**
     * @var string|array
     */
    protected $class;

    /**
     * @var Column
     */
    protected $parent;

    /**
     * @param Column $column
     */
    public function setParent(Column $column)
    {
        $this->parent = $column;
    }

    /**
     * Get column name.
     *
     * @return string
     */
    public function getColumnName()
    {
        return $this->parent->getName();
    }

    /**
     * Get filter value of this column.
     *
     * @param string $default
     *
     * @return array|\Illuminate\Http\Request|string
     */
    public function getFilterValue($default = '')
    {
        return request($this->getColumnName(), $default);
    }

    /**
     * Get form action url.
     *
     * @return string
     */
    public function getFormAction()
    {
        $request = request();

        $query = $request->query();
        Arr::forget($query, [$this->getColumnName(), '_pjax']);

        $question = $request->getBaseUrl().$request->getPathInfo() == '/' ? '/?' : '?';

        return count($request->query()) > 0
            ? $request->url().$question.http_build_query($query)
            : $request->fullUrl();
    }

    /**
     * @param string $key
     *
     * @return array|null|string
     */
    protected function trans($key)
    {
        return __("admin.{$key}");
    }

    /**
     * Add a query binding.
     *
     * @param mixed $value
     * @param Model $model
     */
    public function addBinding($value, Model $model)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        //
    }
}
