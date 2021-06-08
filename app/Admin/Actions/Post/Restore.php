<?php
/**
 * The file was created by Assimon.
 *
 * @author    assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link      http://utf8.hk/
 */

namespace App\Admin\Actions\Post;


use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;

class Restore extends RowAction
{

    protected $title;

    protected $model;

    // 注意构造方法的参数必须要有默认值
    public function __construct(string $model = null)
    {
        $this->title = admin_trans('dujiaoka.restore');
        $this->model = $model;
    }

    public function handle(Request $request)
    {
        $key = $this->getKey();
        $model = $request->get('model');

        $model::withTrashed()->findOrFail($key)->restore();

        return $this->response()->success(admin_trans('dujiaoka.restored'))->refresh();
    }

    public function confirm()
    {
        return [admin_trans('dujiaoka.are_you_restore_sure')];
    }

    public function parameters()
    {
        return [
            'model' => $this->model,
        ];
    }

}
