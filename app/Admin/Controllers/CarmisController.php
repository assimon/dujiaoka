<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\BatchRestore;
use App\Admin\Actions\Post\Restore;
use App\Admin\Forms\ImportCarmis;
use App\Admin\Repositories\Carmis;
use App\Models\Goods;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Models\Carmis as CarmisModel;
use Dcat\Admin\Widgets\Card;

class CarmisController extends AdminController
{


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Carmis(['goods']), function (Grid $grid) {
            $grid->model()->orderBy('id', 'DESC');
            $grid->column('id')->sortable();
            $grid->column('goods.gd_name', admin_trans('carmis.fields.goods_id'));
            $grid->column('status')->select(CarmisModel::getStatusMap());
            $grid->column('is_loop')->display(function($v){return $v==1?admin_trans('carmis.fields.yes'):"";});
            $grid->column('carmi')->limit(20);
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('goods_id')->select(
                    Goods::query()->where('type', Goods::AUTOMATIC_DELIVERY)->pluck('gd_name', 'id')
                );
                $filter->equal('status')->select(CarmisModel::getStatusMap());
                $filter->scope(admin_trans('dujiaoka.trashed'))->onlyTrashed();
            });
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == admin_trans('dujiaoka.trashed')) {
                    $actions->append(new Restore(CarmisModel::class));
                }
            });
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == admin_trans('dujiaoka.trashed')) {
                    $batch->add(new BatchRestore(CarmisModel::class));
                }
            });
            $grid->export()->titles(['goods.gd_name' => admin_trans('carmis.fields.goods_id'), 'carmi' => admin_trans('carmis.fields.carmi'), 'created_at' => admin_trans('admin.created_at')]);
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Carmis(['goods']), function (Show $show) {
            $show->field('id');
            $show->field('goods.gd_name', admin_trans('carmis.fields.goods_id'));
            $show->field('status')->as(function ($type) {
                if ($type == CarmisModel::STATUS_UNSOLD) {
                    return admin_trans('carmis.fields.status_unsold');
                } else {
                    return admin_trans('carmis.fields.status_sold');
                }
            });
			$show->field('is_loop')->as(function ($v) {return $v==1?admin_trans('carmis.fields.yes'):"";});
            $show->field('carmi');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Carmis(), function (Form $form) {
            $form->display('id');
            $form->select('goods_id')->options(
                Goods::query()->where('type', Goods::AUTOMATIC_DELIVERY)->pluck('gd_name', 'id')
            )->required();
            $form->radio('status')
                ->options(CarmisModel::getStatusMap())
                ->default(CarmisModel::STATUS_UNSOLD);
            $form->switch('is_loop')->default(false);
            $form->textarea('carmi')->required();
            $form->display('created_at');
            $form->display('updated_at');
        });
    }

    /**
     * 导入卡密
     *
     * @param Content $content
     * @return Content
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function importCarmis(Content $content)
    {
        return $content
            ->title(admin_trans('carmis.fields.import_carmis'))
            ->body(new Card(new ImportCarmis()));
    }
}
