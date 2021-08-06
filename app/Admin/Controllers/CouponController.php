<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\BatchRestore;
use App\Admin\Actions\Post\Restore;
use App\Admin\Repositories\Coupon;
use App\Models\Goods;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Models\Coupon as CouponModel;

class CouponController extends AdminController
{

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Coupon(['goods']), function (Grid $grid) {
            $grid->model()->orderBy('id', 'DESC');
            $grid->column('id')->sortable();
            $grid->column('discount');
            $grid->column('is_use')->select(CouponModel::getStatusUseMap());
            $grid->column('is_open')->switch();
            $grid->column('coupon')->copyable();
            $grid->column('ret');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == admin_trans('dujiaoka.trashed')) {
                    $actions->append(new Restore(CouponModel::class));
                }
            });
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == admin_trans('dujiaoka.trashed')) {
                    $batch->add(new BatchRestore(CouponModel::class));
                }
            });
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('goods.goods_id', admin_trans('coupon.fields.goods_id'))->select(
                    Goods::query()->pluck('gd_name', 'id')
                );
                $filter->scope(admin_trans('dujiaoka.trashed'))->onlyTrashed();
            });
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
        return Show::make($id, new Coupon(), function (Show $show) {
            $show->field('id');
            $show->field('discount');
            $show->field('is_use')->as(function ($isUse) {
                if ($isUse == CouponModel::STATUS_UNUSED) {
                    return admin_trans('coupon.fields.status_unused');
                } else {
                    return admin_trans('coupon.fields.status_use');
                }
            });
            $show->field('is_open')->as(function ($isOPen) {
                if ($isOPen == CouponModel::STATUS_OPEN) {
                    return admin_trans('dujiaoka.status_open');
                } else {
                    return admin_trans('dujiaoka.status_close');
                }
            });
            $show->field('coupon');
            $show->field('ret');
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
        return Form::make(Coupon::with('goods'), function (Form $form) {
            $form->display('id');
            $form->multipleSelect('goods', admin_trans('coupon.fields.goods_id'))
                ->options(Goods::all()->pluck('gd_name', 'id'))
                ->customFormat(function ($v) {
                    if (! $v) {
                        return [];
                    }
                    // 从数据库中查出的二维数组中转化成ID
                    return array_column($v, 'id');
                });
            $form->currency('discount')->default(0)->required();
            $form->text('coupon')->required();
            $form->number('ret')->default(1);
            $form->radio('is_use')->options(CouponModel::getStatusUseMap())->default(CouponModel::STATUS_UNUSED);
            $form->switch('is_open')->default(CouponModel::STATUS_OPEN);
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
