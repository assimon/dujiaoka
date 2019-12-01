<?php

namespace Encore\Admin\Widgets;

use Illuminate\Contracts\Support\Renderable;

class Alert extends Widget implements Renderable
{
    /**
     * @var string
     */
    protected $view = 'admin::widgets.alert';

    /**
     * @var string|\Symfony\Component\Translation\TranslatorInterface
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
     * @var string
     */
    protected $icon = 'ban';

    /**
     * Alert constructor.
     *
     * @param mixed  $content
     * @param string $title
     * @param string $style
     */
    public function __construct($content, $title = '', $style = 'danger')
    {
        $this->content = (string) $content;

        $this->title = $title ?: trans('admin.alert');

        $this->style($style);
    }

    /**
     * Add style.
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
     * Add icon.
     *
     * @param string $icon
     *
     * @return $this
     */
    public function icon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return array
     */
    protected function variables()
    {
        $this->class("alert alert-{$this->style} alert-dismissable");

        return [
            'title'      => $this->title,
            'content'    => $this->content,
            'icon'       => $this->icon,
            'attributes' => $this->formatAttributes(),
        ];
    }

    /**
     * Render alter.
     *
     * @return string
     */
    public function render()
    {
        return view($this->view, $this->variables())->render();
    }
}
