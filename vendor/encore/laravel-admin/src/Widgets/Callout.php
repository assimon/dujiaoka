<?php

namespace Encore\Admin\Widgets;

use Illuminate\Contracts\Support\Renderable;

class Callout extends Widget implements Renderable
{
    /**
     * @var string
     */
    protected $view = 'admin::widgets.callout';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $content = '';

    /**
     * @var string
     */
    protected $style = 'danger';

    /**
     * Callout constructor.
     *
     * @param string $content
     * @param string $title
     * @param string $style
     */
    public function __construct($content, $title = '', $style = 'danger')
    {
        $this->content = (string) $content;

        $this->title = $title;

        $this->style($style);
    }

    /**
     * Add style to Callout.
     *
     * @param string $style
     *
     * @return $this
     */
    public function style($style = 'info')
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @return array
     */
    protected function variables()
    {
        $this->class("callout callout-{$this->style}");

        return [
            'title'      => $this->title,
            'content'    => $this->content,
            'attributes' => $this->formatAttributes(),
        ];
    }

    /**
     * Render Callout.
     *
     * @return string
     */
    public function render()
    {
        return view($this->view, $this->variables())->render();
    }
}
