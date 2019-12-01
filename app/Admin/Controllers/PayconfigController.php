<?php

namespace App\Admin\Controllers;

use App\Api\Helpers\Api\User;
use App\Models\Payconfig;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PayconfigController extends Controller
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
            ->header('支付配置')
            ->description('支付列表')
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
            ->header('Detail')
            ->description('description')
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
            ->header('编辑配置')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('新加支付选项')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Payconfig);

        $grid->id('ID');
        $grid->pay_name('支付名称');
        $grid->pay_check('支付标识');
        $grid->pay_method('操作方式')->editable('select', ['scan' => '扫码', 'dump' => '跳转']);
        $grid->merchant_id('商户id');
        $grid->merchant_key('商户key')->limit(20);
        $grid->merchant_pem('商户秘钥')->limit(20);
        $grid->pay_handleroute('支付处理路由');
        $grid->pay_status('是否启用')->editable('select', [1 => '是', 2 => '否']);
        $grid->created_at('创建时间');
        $grid->actions(function ($actions) {
            $actions->disableView();
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
        $show = new Show(Payconfig::findOrFail($id));

        $show->id('ID');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Payconfig);
        $form->text('pay_name', '支付名称');
        $form->text('pay_check', '支付标识')->help('非专业人士勿改勿动');
        $form->select('pay_method', '操作方式')->options(['scan' => '扫码', 'dump' => '跳转'])->rules('required',['请选择跳转方式'])->default('dump');
        $form->text('merchant_id', '商户id')->rules('required',['请输入商户id']);
        $form->textarea('merchant_key', '商户key')->rows(10);
        $form->textarea('merchant_pem', '商户秘钥')->rows(10)->rules('required',['请输入商户秘钥']);
        $form->text('pay_handleroute', '支付处理路由');
        $form->select('pay_status', '是否启用')->options([1 => '是', 2 => '否'])->rules('required',['请选择是否启用'])->default(1);
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
