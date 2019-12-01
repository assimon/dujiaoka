<?php

namespace Encore\Admin\Layout;

use Encore\Admin\Grid;
use Illuminate\Contracts\Support\Renderable;

class Column implements Buildable
{
    /**
     * grid system prefix width.
     *
     * @var array
     */
    protected $width = [];

    /**
     * @var array
     */
    protected $contents = [];

    /**
     * Column constructor.
     *
     * @param $content
     * @param int $width
     */
    public function __construct($content, $width = 12)
    {
        if ($content instanceof \Closure) {
            call_user_func($content, $this);
        } else {
            $this->append($content);
        }

        ///// set width.
        // if null, or $this->width is empty array, set as "md" => "12"
        if (is_null($width) || (is_array($width) && count($width) === 0)) {
            $this->width['md'] = 12;
        }
        // $this->width is number(old version), set as "md" => $width
        elseif (is_numeric($width)) {
            $this->width['md'] = $width;
        } else {
            $this->width = $width;
        }
    }

    /**
     * Append content to column.
     *
     * @param $content
     *
     * @return $this
     */
    public function append($content)
    {
        $this->contents[] = $content;

        return $this;
    }

    /**
     * Add a row for column.
     *
     * @param $content
     *
     * @return Column
     */
    public function row($content)
    {
        if (!$content instanceof \Closure) {
            $row = new Row($content);
        } else {
            $row = new Row();

            call_user_func($content, $row);
        }

        ob_start();

        $row->build();

        $contents = ob_get_contents();

        ob_end_clean();

        return $this->append($contents);
    }

    /**
     * Build column html.
     */
    public function build()
    {
        $this->startColumn();

        foreach ($this->contents as $content) {
            if ($content instanceof Renderable || $content instanceof Grid) {
                echo $content->render();
            } else {
                echo (string) $content;
            }
        }

        $this->endColumn();
    }

    /**
     * Start column.
     */
    protected function startColumn()
    {
        // get class name using width array
        $classnName = collect($this->width)->map(function ($value, $key) {
            return "col-$key-$value";
        })->implode(' ');

        echo "<div class=\"{$classnName}\">";
    }

    /**
     * End column.
     */
    protected function endColumn()
    {
        echo '</div>';
    }
}
