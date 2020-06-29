<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\CreateCoupons;
use App\Models\Coupons;
use App\Models\Products;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class CouponsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '优惠码';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Coupons());
        $grid->model()->orderBy('created_at', 'desc');
        $grid->column('id', __('Id'));
        $grid->column('product.pd_name', __('Product id'));
        $grid->column('c_type', __('C type'))->display(function ($c_type, $column){
            switch ($c_type) {
                case 1:
                    return '<span class="badge bg-green">一次性使用</span>';
                case 2:
                    return '<span class="badge bg-blue">重复使用</span>';
            }
        });
        $grid->column('discount', __('Discount'));
        $grid->column('is_status', __('Is status'))->display(function ($is_status, $column){
            switch ($is_status) {
                case 1:
                    return '<span class="badge bg-green">未使用</span>';
                case 2:
                    return '<span class="badge bg-red">已使用</span>';
            }
        });
        $grid->column('card', __('Card'))->copyable();
        $grid->column('ret', __('Ret'));
        $grid->column('created_at', __('Created at'));
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableView();
            // 去掉编辑
            $actions->disableEdit();
        });
        $grid->filter(function($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->equal('card', '优惠券码');
            $pdlisy = Products::where('pd_type', 1)->get(['id', 'pd_name'])->toArray();
            $commod = [];
            foreach ($pdlisy as $val)
            {
                $commod[$val['id']] = $val['pd_name'];
            }
            $filter->equal('product_id', __('Product id'))->select($commod);
            // 在这里添加字段过滤器
            $filter->equal('is_status', __('Is status'))->select([1 => '未使用', 2 => '已使用']);
            $filter->equal('c_type',__('C type'))->select([1 => '一次性使用', 2 => '重复使用']);
        });

        return $grid;
    }

    /**
     * 执行生成
     * @param Content $content
     * @return Content
     */
    public function createCoupons(Content $content)
    {
        $content->body(new CreateCoupons());
        return $content;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Coupons());
        $form->number('product_id', __('Product id'));
        $form->number('c_type', __('C type'))->default(1);
        $form->decimal('discount', __('Discount'));
        $form->number('is_status', __('Is status'))->default(1);
        $form->text('card', __('Card'));
        $form->number('ret', __('Ret'));

        return $form;
    }


}
