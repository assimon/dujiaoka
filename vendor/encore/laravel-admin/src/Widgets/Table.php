<?php

namespace Encore\Admin\Widgets;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Arr;

class Table extends Widget implements Renderable
{
    /**
     * @var string
     */
    protected $view = 'admin::widgets.table';

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var array
     */
    protected $rows = [];

    /**
     * @var array
     */
    protected $style = [];

    /**
     * Table constructor.
     *
     * @param array $headers
     * @param array $rows
     * @param array $style
     */
    public function __construct($headers = [], $rows = [], $style = [])
    {
        $this->setHeaders($headers);
        $this->setRows($rows);
        $this->setStyle($style);

        $this->class('table '.implode(' ', $this->style));
    }

    /**
     * Set table headers.
     *
     * @param array $headers
     *
     * @return $this
     */
    public function setHeaders($headers = [])
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Set table rows.
     *
     * @param array $rows
     *
     * @return $this
     */
    public function setRows($rows = [])
    {
        if (Arr::isAssoc($rows)) {
            foreach ($rows as $key => $item) {
                $this->rows[] = [$key, $item];
            }

            return $this;
        }

        $this->rows = $rows;

        return $this;
    }

    /**
     * Set table style.
     *
     * @param array $style
     *
     * @return $this
     */
    public function setStyle($style = [])
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Render the table.
     *
     * @return string
     */
    public function render()
    {
        $vars = [
            'headers'    => $this->headers,
            'rows'       => $this->rows,
            'style'      => $this->style,
            'attributes' => $this->formatAttributes(),
        ];

        return view($this->view, $vars)->render();
    }
}
