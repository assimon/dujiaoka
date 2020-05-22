<?php

namespace App\Admin\Controllers;

use App\Models\Orders;
use App\Models\Products;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Jobs\SendMails;
use App\Models\Emailtpls;

class OrdersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */

    protected $title = '订单';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Orders());
        $grid->model()->orderBy('created_at', 'desc');
        $grid->column('order_id', __('Order id'))->copyable();
        $grid->column('ord_title', __('Ord title'));
        $grid->column('product.pd_name', __('Product id'));
        $grid->column('coupon.card', __('Coupon id'));
        $grid->column('ord_class', __('Ord class'))->using([1 => '自动发卡', 2 => '代充']);
        $grid->column('product_price', __('Product price'))->label('warning');
        $grid->column('buy_amount', __('Buy amount'))->label('info');
        $grid->column('ord_price', __('Ord price'))->label('success');
        $grid->column('account', __('Account'))->copyable();
        $grid->column('pay.pay_name', __('Pay way'));
        $grid->column('ord_status', __('Ord status'))->editable('select', [1 => '待处理', 2 => '已处理', 3 => '已完成', 4 => '处理失败']);
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        $grid->disableCreateButton();
        $grid->filter(function ($filter) {
            // 范围过滤器，调用模型的`onlyTrashed`方法，查询出被软删除的数据。
            $filter->scope('trashed', '回收站')->onlyTrashed();
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->equal('order_id', '订单id');
            $filter->equal('account', '充值账号');
            $pdlisy = Products::get(['id', 'pd_name'])->toArray();
            $commod = [];
            foreach ($pdlisy as $val) {
                $commod[$val['id']] = $val['pd_name'];
            }
            $filter->equal('product_id', '所属商品')->select($commod);
            // 在这里添加字段过滤器
            $filter->equal('ord_status', '订单状态')->select([1 => '待处理', 2 => '已处理', 3 => '已完成', 4 => '处理失败']);
            $filter->equal('ord_class', '订单类型')->select([1 => '卡密', 2 => '代充']);
            $filter->date('created_at', '订单日期');
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
        $form = new Form(new Orders());

        $form->display('order_id', __('Order id'));
        $form->display('ord_title', __('Ord title'));
        $form->display('product.pd_name', __('Product id'));
        $form->display('coupon.card', __('Coupon id'));
        $form->radio('ord_class', __('Ord class'))->options([1 => '自动发卡', 2 => '代充'])->disable();
        $form->display('product_price', __('Product price'))->default(0.00);
        $form->display('ord_price', __('Ord price'))->default(0.00);
        $form->display('buy_amount', __('Buy amount'));
        $form->textarea('search_pwd', __('Search pwd'))->disable();
        $form->textarea('account', __('Account'))->disable();
        $form->textarea('ord_info', __('Ord info'));
        $form->display('pay_ord', __('Pay ord'));
        $form->display('pay.pay_name', __('Pay way'));
        $form->ip('buy_ip', __('Buy ip'));
        $form->radio('ord_status', __('Ord status'))->options([1 => '待处理', 2 => '已处理', 3 => '已完成', 4 => '处理失败']);
        $form->footer(function ($footer) {
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
            $footer->disableCreatingCheck();
        });
        $form->tools(function (Form\Tools $tools) {
            // 去掉`查看`按钮
            $tools->disableView();
        });

        //保存后回调
        $form->saved(function (Form $form) {
            //订单处理完成，发送通知邮件
            if ($form->model()->ord_status == 3) {
                $order['ord_title'] = $form->model()->ord_title;
                $order['order_id'] = $form->model()->order_id;
                $order['buy_amount'] = $form->model()->buy_amount;
                $order['ord_price'] = $form->model()->ord_price;
                $order['created_at'] = $form->model()->updated_at;
                $order['product_name'] = $form->model()->product['pd_name'];
                $order['webname'] = config('webset.text_logo');
                $order['weburl'] = getenv('APP_URL');
                // 这里格式化一下把换行改成<br/>方便邮件
                $order['ord_info'] = str_replace(PHP_EOL, '<br/>', $form->model()->ord_info);

                $mailtpl = Emailtpls::where('tpl_token', 'finish_send_user_email')->first()->toArray();
                $to = $form->model()->account;
                $mailtipsInfo = replace_mail_tpl($mailtpl, $order);
                if (!empty($to)) SendMails::dispatch($to, $mailtipsInfo['tpl_content'], $mailtipsInfo['tpl_name']);
            }

        });

        return $form;
    }
}
