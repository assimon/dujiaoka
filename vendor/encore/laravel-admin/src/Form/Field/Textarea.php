<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Form\Field;

class Textarea extends Field
{
    /**
     * Default rows of textarea.
     *
     * @var int
     */
    protected $rows = 5;

    /**
     * Set rows of textarea.
     *
     * @param int $rows
     *
     * @return $this
     */
    public function rows($rows = 5)
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        if (is_array($this->value)) {
            $this->value = json_encode($this->value, JSON_PRETTY_PRINT);
        }

        return parent::render()->with(['rows' => $this->rows]);
    }
}
