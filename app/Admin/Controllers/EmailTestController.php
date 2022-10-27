<?php
/**
 * The file was created by Assimon.
 *
 * @author    ZhangYiQiu<me@zhangyiqiu.net>
 * @copyright ZhangYiQiu<me@zhangyiqiu.net>
 * @link      http://zhangyiqiu.net/
 */

namespace App\Admin\Controllers;


use App\Admin\Forms\EmailTest;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;

class EmailTestController extends AdminController
{

    /**
     * 系统设置
     *
     * @param Content $content
     * @return Content
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function emailTest(Content $content)
    {
        return $content
            ->title(admin_trans('menu.titles.email_test'))
            ->body(new Card(new EmailTest()));
    }

}
