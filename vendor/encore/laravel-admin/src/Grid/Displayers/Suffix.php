<?php

namespace Encore\Admin\Grid\Displayers;

class Suffix extends AbstractDisplayer
{
    public function display($suffix = null, $delimiter = '&nbsp;')
    {
        if ($suffix instanceof \Closure) {
            $suffix = $suffix->call($this->row, $this->getValue());
        }

        return <<<HTML
{$this->getValue()}{$delimiter}{$suffix}
HTML;
    }
}
