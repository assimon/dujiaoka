<?php

namespace App\Admin\Controllers;

use App\Models\Pays;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PaysController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '支付配置';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Pays());

        $grid->column('id', __('Id'));
        $grid->column('pay_name', __('Pay name'));
        $grid->column('pay_check', __('Pay check'));
        $grid->column('pay_method', __('Pay method'))->editable('select', ['scan' => '扫码', 'dump' => '跳转']);
        $grid->column('merchant_id', __('Merchant id'));
        $grid->column('merchant_key', __('Merchant key'))->limit(20);
        $grid->column('merchant_pem', __('Merchant pem'))->limit(20);
        $grid->column('pay_handleroute', __('Pay handleroute'));
        $grid->column('pay_status', __('Pay status'))->editable('select', [1 => '启用', 2 => '停用']);
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        $grid->filter(function($filter) {
            $filter->like('pay_name', __('Pay name'));
            // 在这里添加字段过滤器
            $filter->equal('pay_check',__('Pay check'));
            $filter->equal('pay_status', __('Pay status'))->select([1 => '启用', 2 => '停用']);
        });
        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Pays());

        $form->text('pay_name', __('Pay name'))->required();
        $form->text('pay_check', __('Pay check'))->required();
        $form->select('pay_method', __('Pay method'))->options(['scan' => '扫码', 'dump' => '跳转'])->default('dump')->help('不懂勿改');
        $form->text('merchant_id', __('Merchant id'))->required();
        $form->textarea('merchant_key', __('Merchant key'))->help("没有可以不填");
        $form->textarea('merchant_pem', __('Merchant pem'))->required();
        $form->text('pay_handleroute', __('Pay handleroute'))->required()->help("不懂勿改");
        $form->radio('pay_status', __('Pay status'))->options([1 => '启用', 2 => '停用'])->default(1);
        $form->footer(function ($footer) {
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
        });
        $form->tools(function (Form\Tools $tools) {
            // 去掉`查看`按钮
            $tools->disableView();
        });
        return $form;
    }
}
