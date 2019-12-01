<?php

namespace Encore\Admin\Grid\Filter;

use Illuminate\Support\Arr;

class Gt extends AbstractFilter
{
    /**
     * {@inheritdoc}
     */
    protected $view = 'admin::filter.gt';

    /**
     * Get condition of this filter.
     *
     * @param array $inputs
     *
     * @return array|mixed|void
     */
    public function condition($inputs)
    {
        $value = Arr::get($inputs, $this->column);

        if (is_null($value)) {
            return;
        }

        $this->value = $value;

        return $this->buildCondition($this->column, '>=', $this->value);
    }
}
