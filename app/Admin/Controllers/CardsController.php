<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\ImportCards;
use App\Models\Cards;
use App\Models\Products;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Admin\Actions\Copycards;
use App\Admin\Actions\Copy;

class CardsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '卡密';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Cards());
        $grid->model()->orderBy('created_at', 'desc');
        // 加载所有卡密商品
        $commodity = Products::where('pd_type', 1)->get(['id', 'pd_name']);
        $commodClass = [];
        foreach ($commodity as $val) {
            $commodClass[$val['id']] = $val['pd_name'];
        }
        $grid->column('id', __('Id'));
        $grid->column('product.pd_name', __('Product id'));
        $grid->column('card_info', __('Card info'))->limit(20)->copyable();
        $grid->column('card_status', __('Card status'))->editable('select', [1 => '未售出', 2 => '已售出']);
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->filter(function ($filter) use ($commodClass) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->equal('id', '卡密id');
            // 在这里添加字段过滤器
            $filter->like('card_info', '卡密内容');
            $filter->equal('product_id', '所属商品')->select($commodClass);
            $filter->equal('card_status', '状态')->select([1 => '未售出', 2 => '已售出']);


        });

        $grid->actions(function ($actions) {
            $actions->add(new Copy);
            $actions->disableView();
        });
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(new Copycards());
        });
        return $grid;
    }

    public function importCards(Content $content)
    {
        return $content->body(new ImportCards());
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Cards());
        // 加载所有卡密商品
        $commodity = Products::where('pd_type', 1)->get(['id', 'pd_name']);
        $commodClass = [];
        foreach ($commodity as $val) {
            $commodClass[$val['id']] = $val['pd_name'];
        }
        $form->select('product_id', __('Product id'))->options($commodClass)->rules('required', ['请选择商品']);
        $form->textarea('card_info', __('Card info'));
        $form->radio('card_status', __('Card status'))->options([1 => '待出售', 2 => '已售出'])->default(1);
        $form->footer(function ($footer) {
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
        });
        $form->tools(function (Form\Tools $tools) {
            // 去掉`查看`按钮
            $tools->disableView();
        });


        $form->saving(function (Form $form) {
            $this->product_id = $form->model()->product_id;
        });
        $form->saved(function (Form $form) {
            $product_id = $form->model()->product_id;
            $this->instock = Cards::where('product_id', $this->product_id)->where('card_status', 1)->count();
            Products::where('id', $this->product_id)->update(['in_stock' => $this->instock]);
            $instock = Cards::where('product_id', $product_id)->where('card_status', 1)->count();
            Products::where('id', $product_id)->update(['in_stock' => $instock]);
        });
        return $form;
    }
}
