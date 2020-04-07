<?php

namespace App\Admin\Controllers;


use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use App\Admin\Forms\Setting;

class SettingController extends Controller
{
    /**
     * 系统设置
     */
    public function setting(Content $content)
    {
        return $content->body(new Setting());
    }

}
