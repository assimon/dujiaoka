<?php

namespace Encore\Admin\Actions;

use Illuminate\Support\Arr;

class Toastr
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @param string $type
     * @param string $content
     *
     * @return $this
     */
    public function show($type, $content = '')
    {
        $this->type = $type;
        $this->content = $content;

        return $this;
    }

    /**
     * @param $option
     * @param $value
     *
     * @return $this
     */
    protected function options($option, $value)
    {
        Arr::set($this->options, $option, $value);

        return $this;
    }

    /**
     * @param $position
     *
     * @return Toastr
     */
    protected function position($position)
    {
        return $this->options('positionClass', $position);
    }

    /**
     * @return Toastr
     */
    public function topCenter()
    {
        return $this->position('toast-top-center');
    }

    /**
     * @return Toastr
     */
    public function topLeft()
    {
        return $this->position('toast-top-left');
    }

    /**
     * @return Toastr
     */
    public function topRight()
    {
        return $this->position('toast-top-right');
    }

    /**
     * @return Toastr
     */
    public function bottomLeft()
    {
        return $this->position('toast-bottom-left');
    }

    /**
     * @return Toastr
     */
    public function bottomCenter()
    {
        return $this->position('toast-bottom-center');
    }

    /**
     * @return Toastr
     */
    public function bottomRight()
    {
        return $this->position('toast-bottom-right');
    }

    /**
     * @return Toastr
     */
    public function topFullWidth()
    {
        return $this->position('toast-top-full-width');
    }

    /**
     * @return Toastr
     */
    public function bottomFullWidth()
    {
        return $this->position('toast-bottom-full-width');
    }

    /**
     * @return Toastr
     */
    public function timeout($timeout = 5000)
    {
        return $this->options('timeOut', $timeout);
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        if (!isset($this->options['positionClass'])) {
            $this->topCenter();
        }

        return [
            'toastr' => [
                'type'    => $this->type,
                'content' => $this->content,
                'options' => $this->options,
            ],
        ];
    }
}
