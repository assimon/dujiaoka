<?php

namespace Encore\Admin\Form;

use Encore\Admin\Form;
use Illuminate\Contracts\Support\Renderable;

class Row implements Renderable
{
    /**
     * Callback for add field to current row.s.
     *
     * @var \Closure
     */
    protected $callback;

    /**
     * Parent form.
     *
     * @var Form
     */
    protected $form;

    /**
     * Fields in this row.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Default field width for appended field.
     *
     * @var int
     */
    protected $defaultFieldWidth = 12;

    /**
     * Row constructor.
     *
     * @param \Closure $callback
     * @param Form     $form
     */
    public function __construct(\Closure $callback, Form $form)
    {
        $this->callback = $callback;

        $this->form = $form;

        call_user_func($this->callback, $this);
    }

    /**
     * Get fields of this row.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set width for a incomming field.
     *
     * @param int $width
     *
     * @return $this
     */
    public function width($width = 12)
    {
        $this->defaultFieldWidth = $width;

        return $this;
    }

    /**
     * Render the row.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view('admin::form.row', ['fields' => $this->fields]);
    }

    /**
     * Add field.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return Field|void
     */
    public function __call($method, $arguments)
    {
        $field = $this->form->__call($method, $arguments);

        $field->disableHorizontal();

        $this->fields[] = [
            'width'   => $this->defaultFieldWidth,
            'element' => $field,
        ];

        return $field;
    }
}
