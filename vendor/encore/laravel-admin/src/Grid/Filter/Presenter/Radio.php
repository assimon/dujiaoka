<?php

namespace Encore\Admin\Grid\Filter\Presenter;

use Encore\Admin\Facades\Admin;
use Illuminate\Contracts\Support\Arrayable;

class Radio extends Presenter
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * Display inline.
     *
     * @var bool
     */
    protected $inline = true;

    /**
     * Radio constructor.
     *
     * @param array $options
     */
    public function __construct($options = [])
    {
        if ($options instanceof Arrayable) {
            $options = $options->toArray();
        }

        $this->options = (array) $options;

        return $this;
    }

    /**
     * Draw stacked radios.
     *
     * @return $this
     */
    public function stacked() : self
    {
        $this->inline = false;

        return $this;
    }

    protected function prepare()
    {
        $script = "$('.{$this->filter->getId()}').iCheck({radioClass:'iradio_minimal-blue'});";

        Admin::script($script);
    }

    /**
     * @return array
     */
    public function variables() : array
    {
        $this->prepare();

        return [
            'options' => $this->options,
            'inline'  => $this->inline,
        ];
    }
}
