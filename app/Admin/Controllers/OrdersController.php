<?php

namespace App\Admin\Controllers;

use App\Api\Helpers\Api\User;
use App\Models\Commodity;
use App\Models\Orders;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OrdersController extends Controller
{

    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('订单列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('订单详情')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑订单')
            ->body($this->form()->edit($id));
    }



    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Orders);
        $grid->model()->orderBy('created_at', 'desc');
        $grid->id('ID');
        $grid->oid('订单号');
        $grid->ord_name('订单名称');
        $grid->column('commodity.pd_name', '商品名称');
        $grid->pd_money('商品单价');
        $grid->ord_countmoney('订单总价');
        $grid->ord_num('购买数量');
        $grid->search_pwd('查询密码');
        $grid->rcg_account('充值账号');
        $grid->pay_ord('第三方支付号');
        $grid->column('payconfig.pay_name','支付方式');
        $grid->ord_status('订单状态')->display(function ($ord_status){
            switch ($ord_status) {
                case 1:
                    return '<span class="badge bg-yellow">待处理</span>';
                case 2:
                    return '<span class="badge bg-blue">已处理</span>';
                case 3:
                    return '<span class="badge bg-green">处理成功</span>';
                case 4:
                    return '<span class="badge bg-red">处理失败</span>';
            }
        });
        $grid->created_at('订单创建时间');
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        $grid->filter(function($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->equal('oid', '订单id');
            $filter->equal('rcg_account', '充值账号');
            $pdlisy = Commodity::all(['id', 'pd_name']);
            $commod = [];
            foreach ($pdlisy as $val)
            {
                $commod[$val['id']] = $val['pd_name'];
            }
            $filter->equal('pd_id', '所属商品')->select($commod);
            // 在这里添加字段过滤器
            $filter->equal('ord_status', '订单状态')->select([1 => '待处理', 2 => '已处理', 3 => '已完成', 4 => '处理失败']);
            $filter->date('created_at', '订单日期');

        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Orders::findOrFail($id));


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Orders);

        $form->display('oid', '订单号');
        $form->display('ord_name', '订单名称');
        $form->display('commodity.pd_name', '所属商品');
        $form->display('pd_money', '商品单价');
        $form->display('ord_countmoney', '订单总价');
        $form->display('ord_num', '购买数量');
        $form->textarea('search_pwd', '查询密码');
        $form->textarea('rcg_account', '充值账号');
        $form->textarea('ord_info', '订单详情');
        $form->display('pay_ord', '第三方支付平台id');
        $form->display('payconfig.pay_name', '支付方式');
        $form->select('ord_status', '订单状态')->options([1 => '待处理', 2 => '已处理', 3 => '已完成', 4 => '处理失败']);
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
