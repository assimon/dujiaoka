<?php

namespace Encore\Admin\Grid\Displayers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class Badge extends AbstractDisplayer
{
    public function display($style = 'red')
    {
        if ($this->value instanceof Arrayable) {
            $this->value = $this->value->toArray();
        }

        return collect((array) $this->value)->map(function ($name) use ($style) {
            if (is_array($style)) {
                $style = Arr::get($style, $this->getColumn()->getOriginal(), 'red');
            }

            return "<span class='badge bg-{$style}'>$name</span>";
        })->implode('&nbsp;');
    }
}
