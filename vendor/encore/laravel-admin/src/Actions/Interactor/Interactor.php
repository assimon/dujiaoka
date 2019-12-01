<?php

namespace Encore\Admin\Actions\Interactor;

use Encore\Admin\Actions\Action;

abstract class Interactor
{
    /**
     * @var Action
     */
    protected $action;

    /**
     * @var array
     */
    public static $elements = [
        'success', 'error', 'warning', 'info', 'question', 'confirm',
        'text', 'email', 'integer', 'ip', 'url', 'password', 'mobile',
        'textarea', 'select', 'multipleSelect', 'checkbox', 'radio',
        'file', 'image', 'date', 'datetime', 'time', 'hidden',
    ];

    /**
     * Dialog constructor.
     *
     * @param Action $action
     */
    public function __construct(Action $action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    abstract public function addScript();
}
