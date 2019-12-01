<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Admin;
use Encore\Admin\Form\Field;
use Illuminate\Support\Arr;

class ListField extends Field
{
    /**
     * Max list size.
     *
     * @var int
     */
    protected $max;

    /**
     * Minimum list size.
     *
     * @var int
     */
    protected $min = 0;

    /**
     * @var array
     */
    protected $value = [''];

    /**
     * Set Max list size.
     *
     * @param int $size
     *
     * @return $this
     */
    public function max(int $size)
    {
        $this->max = $size;

        return $this;
    }

    /**
     * Set Minimum list size.
     *
     * @param int $size
     *
     * @return $this
     */
    public function min(int $size)
    {
        $this->min = $size;

        return $this;
    }

    /**
     * Fill data to the field.
     *
     * @param array $data
     *
     * @return void
     */
    public function fill($data)
    {
        $this->data = $data;

        $this->value = Arr::get($data, $this->column, $this->value);

        $this->formatValue();
    }

    /**
     * {@inheritdoc}
     */
    public function getValidator(array $input)
    {
        if ($this->validator) {
            return $this->validator->call($this, $input);
        }

        if (!is_string($this->column)) {
            return false;
        }

        $rules = $attributes = [];

        if (!$fieldRules = $this->getRules()) {
            return false;
        }

        if (!Arr::has($input, $this->column)) {
            return false;
        }

        $rules["{$this->column}.values.*"] = $fieldRules;
        $attributes["{$this->column}.values.*"] = __('Value');

        $rules["{$this->column}.values"][] = 'array';

        if (!is_null($this->max)) {
            $rules["{$this->column}.values"][] = "max:$this->max";
        }

        if (!is_null($this->min)) {
            $rules["{$this->column}.values"][] = "min:$this->min";
        }

        $attributes["{$this->column}.values"] = $this->label;

        return validator($input, $rules, $this->getValidationMessages(), $attributes);
    }

    /**
     * {@inheritdoc}
     */
    protected function setupScript()
    {
        $this->script = <<<SCRIPT

$('.{$this->column}-add').on('click', function () {
    var tpl = $('template.{$this->column}-tpl').html();
    $('tbody.list-{$this->column}-table').append(tpl);
});

$('tbody').on('click', '.{$this->column}-remove', function () {
    $(this).closest('tr').remove();
});

SCRIPT;
    }

    /**
     * {@inheritdoc}
     */
    public function prepare($value)
    {
        return array_values($value['values']);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $this->setupScript();

        Admin::style('td .form-group {margin-bottom: 0 !important;}');

        return parent::render();
    }
}
