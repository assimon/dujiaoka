<?php

namespace Encore\Admin\Widgets;

use Illuminate\Contracts\Support\Renderable;

class Carousel extends Widget implements Renderable
{
    /**
     * @var string
     */
    protected $view = 'admin::widgets.carousel';

    /**
     * @var array
     */
    protected $items;

    /**
     * @var string
     */
    protected $title = 'Carousel';

    /**
     * Carousel constructor.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        $this->items = $items;

        $this->id('carousel-'.uniqid());
        $this->class('carousel slide');
        $this->offsetSet('data-ride', 'carousel');
    }

    /**
     * Set title.
     *
     * @param string $title
     */
    public function title($title)
    {
        $this->title = $title;
    }

    /**
     * Render Carousel.
     *
     * @return string
     */
    public function render()
    {
        $variables = [
            'items'      => $this->items,
            'title'      => $this->title,
            'attributes' => $this->formatAttributes(),
            'id'         => $this->id,
            'width'      => $this->width ?: 300,
            'height'     => $this->height ?: 200,
        ];

        return view($this->view, $variables)->render();
    }
}
