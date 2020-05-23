<?php

namespace App\Admin\Controllers;

use App\Models\Classifys;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;


class ClassifysController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品分类';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Classifys());
        $grid->model()->orderBy('ord', 'desc');
        $grid->column('id', __('Id'));
        $grid->column('name', __('Class Name'));
        /*$grid->column('icon', __('Icon'))->display(function ($icon){
            return '<i class="fa '.$icon.'"></i>';
        });*/
        $grid->column('ord', __('Ord'));
        $grid->column('c_status', __('C status'))->editable('select', [1=> '启用', 2=> '禁用']);
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
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
        $form = new Form(new Classifys());

        $form->text('name', __('Class Name'))->rules('required',['不能为空']);
        // $form->text('icon', __('Icon'));
        $form->number('ord', __('Ord'))->default(1);
        $form->radio('c_status', __('C status'))
            ->options([1=> '启用', 2=> '禁用'])
            ->rules('required',['请选择状态'])
            ->default(1);
        $form->text('passwd', __('C password'));
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
