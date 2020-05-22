<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class Copycards extends BatchAction
{
    protected $selector = '.copycards';

    public function handle(Collection $collection, Request $request)
    {

        $number = $request->all()['num'];;
        for ($i = 1; $i <= $number; $i++) {
            foreach ($collection as $model) {
                $model->replicate()->save();
            }
        }
        return $this->response()->success('成功复制' . count($collection) * $number . '条卡密')->refresh();
    }

    public function form()
    {
        $this->text('num', '复制次数')->rules('required|numeric');
    }

    public function html()
    {
        return "<a class='copycards btn btn-sm btn-twitter'><i class='fa fa-copy'></i>批量复制</a>";
    }
}
