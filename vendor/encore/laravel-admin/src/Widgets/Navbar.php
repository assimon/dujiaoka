<?php

namespace Encore\Admin\Widgets;

use Encore\Admin\Widgets\Navbar\RefreshButton;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;

class Navbar implements Renderable
{
    /**
     * @var array
     */
    protected $elements = [];

    /**
     * Navbar constructor.
     */
    public function __construct()
    {
        $this->elements = [
            'left'  => collect(),
            'right' => collect(),
        ];
    }

    /**
     * @param $element
     *
     * @return $this
     */
    public function left($element)
    {
        $this->elements['left']->push($element);

        return $this;
    }

    /**
     * @param $element
     *
     * @return $this
     */
    public function right($element)
    {
        $this->elements['right']->push($element);

        return $this;
    }

    /**
     * @param $element
     *
     * @return Navbar
     *
     * @deprecated
     */
    public function add($element)
    {
        return $this->right($element);
    }

    /**
     * @param string $part
     *
     * @return mixed
     */
    public function render($part = 'right')
    {
        if ($part == 'right') {
            $this->right(new RefreshButton());
        }

        if (!isset($this->elements[$part]) || $this->elements[$part]->isEmpty()) {
            return '';
        }

        return $this->elements[$part]->map(function ($element) {
            if ($element instanceof Htmlable) {
                return $element->toHtml();
            }

            if ($element instanceof Renderable) {
                return $element->render();
            }

            return (string) $element;
        })->implode('');
    }
}
