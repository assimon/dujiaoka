<?php

namespace App\Admin\Controllers;

use App\Models\Classifys;
use App\Models\Products;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Products());
        $grid->model()->orderBy('ord', 'desc');
        $grid->column('id', __('Id'));
        $grid->column('pd_name', __('Pd name'))->label();
        $grid->column('pd_picture', __('Pd picture'))->image();
        $grid->column('classify.name', __('Pd class'));
        $grid->column('pd_type', __('Pd type'))->editable('select', [1 => '自动发货', 2 => '人工发货']);
        $grid->column('cost_price', __('Cost price'))->editable();
        $grid->column('actual_price', __('Actual price'))->editable();
        $grid->column('in_stock', __('In stock'));
        $grid->column('sales_volume', __('Sales volume'));
        $grid->column('ord', __('Ord'))->editable();
        $grid->column('pd_status', __('Pd status'))->editable('select', [1 => '上架', 2 => '下架']);
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $classifys = Classifys::where('c_status', 1)->get(['id', 'name']);
        $dataArr = [];
        foreach ($classifys as $classify) {
            $dataArr[$classify['id']] = $classify['name'];
        }
        $grid->filter(function($filter) use ($dataArr){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->equal('id', __('Id'));
            // 在这里添加字段过滤器
            $filter->like('pd_name', __('Pd name'));
            $filter->equal('pd_class', '商品分类')->select($dataArr);
            // 范围过滤器，调用模型的`onlyTrashed`方法，查询出被软删除的数据。
            $filter->scope('trashed', '回收站')->onlyTrashed();
        });
        $grid->actions(function ($actions) {
            $actions->disableView();
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
        $form = new Form(new Products());
        $form->text('pd_name', __('Pd name'))->required();
        $classifys = Classifys::where('c_status', 1)->get(['id', 'name']);
        $dataArr = [];
        foreach ($classifys as $classify) {
            $dataArr[$classify['id']] = $classify['name'];
        }
        $form->select('pd_class', __('Pd class'))->options($dataArr)->required();
        $form->currency('cost_price', __('Cost price'))->rules('required|numeric', ['required' => '不能为空','numeric' => '请填写正确的金额，整数或小数']);
        $form->currency('actual_price', __('Actual price'))->rules('required|numeric', ['required' => '不能为空','numeric' => '请填写正确的金额，整数或小数']);
        $form->image('pd_picture', __('Pd picture'))->uniqueName()->help('可以为空，为空则为默认图片');
        $form->textarea('wholesale_price', __('Wholesale price'))->help('例如：填写 5=3 表示客户购买 5 件或以上时，每件价格为 3 元。一行一个');
        $form->number('in_stock', __('In stock'))->help('（如商品为自动发货类型请不要填写库存，系统会自动识别）')->default(0);
        $form->number('sales_volume', __('Sales volume'))->default(0);
        $form->number('ord', __('Ord'))->default(1);
        $form->UEditor('buy_prompt', __('Buy prompt'));
        $form->UEditor('pd_info', __('Pd info'));
        $form->radio('pd_type', __('Pd type'))->options([1=> '自动发货', 2=> '人工发货'])
            ->rules('required',['请选择类型'])
            ->default(1);
        $form->radio('isopen_coupon', __('Is open coupon'))->options([1 => '是', 2 => '否'])->default(1);
        $form->textarea('other_ipu', __('Other ipu'))->help('例如：填写 qqpwd=QQ 密码=true 表示产品详情页会新增一个 qqpwd 输入框，客户可在其中输入 QQ 密码，true 为必填，false 为选填（仅对人工发货类商品有效，一行一个）');
        $form->radio('pd_status', __('Pd status'))
            ->options([1=> '上架', 2=> '下架'])
            ->rules('required',['请选择状态'])
            ->default(1);
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
