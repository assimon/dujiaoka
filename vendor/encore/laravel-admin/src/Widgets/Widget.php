<?php

namespace Encore\Admin\Widgets;

use Illuminate\Support\Fluent;

abstract class Widget extends Fluent
{
    /**
     * @var string
     */
    protected $view;

    /**
     * @return mixed
     */
    abstract public function render();

    /**
     * Set view of widget.
     *
     * @param string $view
     */
    public function view($view)
    {
        $this->view = $view;
    }

    /**
     * Build an HTML attribute string from an array.
     *
     * @return string
     */
    public function formatAttributes()
    {
        $html = [];
        foreach ((array) $this->getAttributes() as $key => $value) {
            $element = $this->attributeElement($key, $value);
            if (!is_null($element)) {
                $html[] = $element;
            }
        }

        return count($html) > 0 ? ' '.implode(' ', $html) : '';
    }

    /**
     * Build a single attribute element.
     *
     * @param string $key
     * @param string $value
     *
     * @return string
     */
    protected function attributeElement($key, $value)
    {
        if (is_numeric($key)) {
            $key = $value;
        }
        if (!is_null($value)) {
            return $key.'="'.htmlentities($value, ENT_QUOTES, 'UTF-8').'"';
        }
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->render();
    }
}
