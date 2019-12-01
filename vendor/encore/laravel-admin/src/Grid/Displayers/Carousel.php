<?php

namespace Encore\Admin\Grid\Displayers;

use Encore\Admin\Widgets\Carousel as CarouselWidget;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Storage;

class Carousel extends AbstractDisplayer
{
    public function display(int $width = 300, int $height = 200, $server = '')
    {
        if ($this->value instanceof Arrayable) {
            $this->value = $this->value->toArray();
        }

        $this->value = array_values($this->value);

        if (empty($this->value)) {
            return '';
        }

        $images = collect((array) $this->value)->filter()->map(function ($path) use ($server) {
            if (url()->isValidUrl($path) || strpos($path, 'data:image') === 0) {
                $image = $path;
            } elseif ($server) {
                $image = rtrim($server, '/').'/'.ltrim($path, '/');
            } else {
                $image = Storage::disk(config('admin.upload.disk'))->url($path);
            }

            $caption = '';

            return compact('image', 'caption');
        });

        $id = sprintf('carousel-%s-%s', $this->column->getName(), $this->getKey());

        return (new CarouselWidget($images))->width($width)->height($height)->id($id);
    }
}
