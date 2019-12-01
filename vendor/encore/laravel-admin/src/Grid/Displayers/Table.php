<?php

namespace Encore\Admin\Grid\Displayers;

use Illuminate\Support\Arr;

class Table extends AbstractDisplayer
{
    public function display($titles = [])
    {
        if (empty($this->value)) {
            return '';
        }

        if (empty($titles)) {
            $titles = array_keys($this->value[0]);
        }

        if (Arr::isAssoc($titles)) {
            $columns = array_keys($titles);
        } else {
            $titles = array_combine($titles, $titles);
            $columns = $titles;
        }

        $data = array_map(function ($item) use ($columns) {
            $sorted = [];

            $arr = Arr::only($item, $columns);

            foreach ($columns as $column) {
                if (array_key_exists($column, $arr)) {
                    $sorted[$column] = $arr[$column];
                }
            }

            return $sorted;
        }, $this->value);

        $variables = [
            'titles' => $titles,
            'data'   => $data,
        ];

        return view('admin::grid.displayer.table', $variables)->render();
    }
}
