<?php

namespace Encore\Admin\Form\Field;

class Mobile extends Text
{
    protected static $js = [
        '/vendor/laravel-admin/AdminLTE/plugins/input-mask/jquery.inputmask.bundle.min.js',
    ];

    /**
     * @see https://github.com/RobinHerbots/Inputmask#options
     *
     * @var array
     */
    protected $options = [
        'mask' => '99999999999',
    ];

    public function render()
    {
        $this->inputmask($this->options);

        $this->prepend('<i class="fa fa-phone fa-fw"></i>')
            ->defaultAttribute('style', 'width: 150px');

        return parent::render();
    }
}
