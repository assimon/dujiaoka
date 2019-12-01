<?php

namespace Encore\Admin\Grid\Filter\Presenter;

use Encore\Admin\Admin;

class Text extends Presenter
{
    /**
     * @var string
     */
    protected $placeholder = '';

    /**
     * @var string
     */
    protected $icon = 'pencil';

    /**
     * @var string
     */
    protected $type = 'text';

    /**
     * Text constructor.
     *
     * @param string $placeholder
     */
    public function __construct($placeholder = '')
    {
        $this->placeholder($placeholder);
    }

    /**
     * Get variables for field template.
     *
     * @return array
     */
    public function variables() : array
    {
        return [
            'placeholder' => $this->placeholder,
            'icon'        => $this->icon,
            'type'        => $this->type,
            'group'       => $this->filter->group,
        ];
    }

    /**
     * Set input placeholder.
     *
     * @param string $placeholder
     *
     * @return $this
     */
    public function placeholder($placeholder = '') : self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * @return Text
     */
    public function url() : self
    {
        return $this->inputmask(['alias' => 'url'], 'internet-explorer');
    }

    /**
     * @return Text
     */
    public function email() : self
    {
        return $this->inputmask(['alias' => 'email'], 'envelope');
    }

    /**
     * @return Text
     */
    public function integer() : self
    {
        return $this->inputmask(['alias' => 'integer']);
    }

    /**
     * @param array $options
     *
     * @see https://github.com/RobinHerbots/Inputmask/blob/4.x/README_numeric.md
     *
     * @return Text
     */
    public function decimal($options = []) : self
    {
        return $this->inputmask(array_merge($options, ['alias' => 'decimal']));
    }

    /**
     * @param array $options
     *
     * @see https://github.com/RobinHerbots/Inputmask/blob/4.x/README_numeric.md
     *
     * @return Text
     */
    public function currency($options = []) : self
    {
        return $this->inputmask(array_merge($options, [
            'alias'              => 'currency',
            'prefix'             => '',
            'removeMaskOnSubmit' => true,
        ]));
    }

    /**
     * @param array $options
     *
     * @see https://github.com/RobinHerbots/Inputmask/blob/4.x/README_numeric.md
     *
     * @return Text
     */
    public function percentage($options = [])
    {
        $options = array_merge(['alias' => 'percentage'], $options);

        return $this->inputmask($options);
    }

    /**
     * @return Text
     */
    public function ip() : self
    {
        return $this->inputmask(['alias' => 'ip'], 'laptop');
    }

    /**
     * @return Text
     */
    public function mac() : self
    {
        return $this->inputmask(['alias' => 'mac'], 'laptop');
    }

    /**
     * @param string $mask
     *
     * @return Text
     */
    public function mobile($mask = '19999999999') : self
    {
        return $this->inputmask(compact('mask'), 'phone');
    }

    /**
     * @param array  $options
     * @param string $icon
     *
     * @return $this
     */
    public function inputmask($options = [], $icon = 'pencil') : self
    {
        $options = json_encode($options);

        Admin::script("$('#filter-box input.{$this->filter->getId()}').inputmask($options);");

        $this->icon = $icon;

        return $this;
    }
}
