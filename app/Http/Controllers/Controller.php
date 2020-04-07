<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected function view($tpl = "", $data = [])
    {
        $tpl = config('app.shtemplate') . '/' .$tpl;
        return view($tpl, $data);
    }

    protected function error($content = "content", $url = "")
    {
        $tpl = config('app.shtemplate') . '/errors/error';
        return view($tpl, ['title' => '(╥╯^╰╥)出错啦~', 'content' => $content, 'url' => $url]);
    }
}
