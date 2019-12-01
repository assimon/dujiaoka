<?php

namespace Encore\Admin\Form\Field;

class Password extends Text
{
    public function render()
    {
        $this->prepend('<i class="fa fa-eye-slash fa-fw"></i>')
            ->defaultAttribute('type', 'password');

        return parent::render();
    }
}
