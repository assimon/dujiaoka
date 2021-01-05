<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 模板渲染.
     * @param string $tpl
     * @param array $data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function view($tpl = "", $data = [])
    {
        $tpl = config('webset.tpl_sign') . '/' .$tpl;
        return view($tpl, $data);
    }

    /**
     * 错误模板渲染.
     * @param string $content
     * @param string $url
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function error($content = "content", $url = "")
    {
        $tpl = config('webset.tpl_sign') . '/errors/error';
        return view($tpl, ['title' => __('prompt.error_title'), 'content' => $content, 'url' => $url]);
    }

}
