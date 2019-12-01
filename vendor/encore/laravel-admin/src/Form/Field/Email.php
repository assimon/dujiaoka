<?php

namespace Encore\Admin\Form\Field;

class Email extends Text
{
    protected $rules = 'nullable|email';

    public function render()
    {
        $this->prepend('<i class="fa fa-envelope fa-fw"></i>')
            ->defaultAttribute('type', 'email');

        return parent::render();
    }
}
