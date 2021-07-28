<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\BatchRestore;
use App\Admin\Actions\Post\Restore;
use App\Admin\Repositories\Order;
use App\Models\Coupon;
use App\Models\Goods;
use App\Models\Pay;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Models\Order as OrderModel;

class OrderController extends AdminController
{


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Order(['goods', 'coupon', 'pay']), function (Grid $grid) {
            $grid->model()->orderBy('id', 'DESC');
            $grid->column('id')->sortable();
            $grid->column('order_sn')->copyable();
            $grid->column('title');
            $grid->column('type')->using(OrderModel::getTypeMap())
                ->label([
                    OrderModel::AUTOMATIC_DELIVERY => Admin::color()->success(),
                    OrderModel::MANUAL_PROCESSING => Admin::color()->info(),
                ]);
            $grid->column('email')->copyable();
            $grid->column('goods.gd_name', admin_trans('order.fields.goods_id'));
            $grid->column('goods_price');
            $grid->column('buy_amount');
            $grid->column('total_price');
            $grid->column('coupon.coupon', admin_trans('order.fields.coupon_id'));
            $grid->column('coupon_discount_price');
            $grid->column('wholesale_discount_price');
            $grid->column('actual_price');
            $grid->column('pay.pay_name', admin_trans('order.fields.pay_id'));
            $grid->column('buy_ip');
            $grid->column('search_pwd')->copyable();
            $grid->column('trade_no')->copyable();
            $grid->column('status')
                ->select(OrderModel::getStatusMap());
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->disableCreateButton();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('order_sn');
                $filter->like('title');
                $filter->equal('status')->select(OrderModel::getStatusMap());
                $filter->equal('email');
                $filter->equal('trade_no');
                $filter->equal('type')->select(OrderModel::getTypeMap());
                $filter->equal('goods_id')->select(Goods::query()->pluck('gd_name', 'id'));
                $filter->equal('coupon_id')->select(Coupon::query()->pluck('coupon', 'id'));
                $filter->equal('pay_id')->select(Pay::query()->pluck('pay_name', 'id'));
                $filter->whereBetween('created_at', function ($q) {
                    $start = $this->input['start'] ?? null;
                    $end = $this->input['end'] ?? null;
                    $q->where('created_at', '>=', $start)
                        ->where('created_at', '<=', $end);
                })->datetime();
                $filter->scope(admin_trans('dujiaoka.trashed'))->onlyTrashed();
            });
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == admin_trans('dujiaoka.trashed')) {
                    $actions->append(new Restore(OrderModel::class));
                }
            });
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == admin_trans('dujiaoka.trashed')) {
                    $batch->add(new BatchRestore(OrderModel::class));
                }
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
        return Show::make($id, new Order(['goods', 'coupon', 'pay']), function (Show $show) {
            $show->field('id');
            $show->field('order_sn');
            $show->field('title');
            $show->field('email');
            $show->field('goods.gd_name', admin_trans('order.fields.goods_id'));
            $show->field('goods_price');
            $show->field('buy_amount');
            $show->field('coupon.coupon', admin_trans('order.fields.coupon_id'));
            $show->field('coupon_discount_price');
            $show->field('wholesale_discount_price');
            $show->field('total_price');
            $show->field('actual_price');
            $show->field('buy_ip');
            $show->field('info')->unescape()->as(function ($info) {
                return  "<textarea class=\"form-control field_wholesale_price_cnf _normal_\"  rows=\"10\" cols=\"30\">" . $info . "</textarea>";
            });
            $show->field('pay.pay_name', admin_trans('order.fields.pay_id'));
            $show->field('status')->using(OrderModel::getStatusMap());
            $show->field('search_pwd');
            $show->field('trade_no');
            $show->field('type')->using(OrderModel::getTypeMap());
            $show->field('created_at');
            $show->field('updated_at');
            $show->disableEditButton();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Order(['goods', 'coupon', 'pay']), function (Form $form) {
            $form->display('id');
            $form->display('order_sn');
            $form->text('title');
            $form->display('goods.gd_name', admin_trans('order.fields.goods_id'));
            $form->display('goods_price');
            $form->display('buy_amount');
            $form->display('coupon.coupon', admin_trans('order.fields.coupon_id'));
            $form->display('coupon_discount_price');
            $form->display('wholesale_discount_price');
            $form->display('total_price');
            $form->display('actual_price');
            $form->display('email');
            $form->textarea('info');
            $form->display('buy_ip');
            $form->display('pay.pay_name', admin_trans('order.fields.pay_id'));
            $form->radio('status')->options(OrderModel::getStatusMap());
            $form->text('search_pwd');
            $form->display('trade_no');
            $form->radio('type')->options(OrderModel::getTypeMap())->disable();
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
