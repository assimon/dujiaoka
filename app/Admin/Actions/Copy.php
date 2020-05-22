<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Copy extends RowAction
{
    public $name = '复制';

    public function handle(Model $model, Request $request)
    {
        $number = $request->all()['num'];;
        for ($i = 1; $i <= $number; $i++) {
            $model->replicate()->save();
        }

        return $this->response()->success('已复制' . $number . '条卡密')->refresh();
    }

    public function form()
    {
        $this->text('num', '复制条数')->rules('required|numeric');
    }
}
