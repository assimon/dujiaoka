<?php

namespace App\Admin\Controllers;

use App\Models\Pages;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
class PagesController extends AdminController
{

    protected $title = '文章';

    protected function grid()
    {
        $grid = new Grid(new Pages);

        $grid->column('title', __('Page title'));
        //$grid->column('content', __('内容'))->label();
        $grid->column('tag', __('Page link'))->display(function ($tag) {
            return url("pages/$tag.html");
        })->link();
        $grid->column('status', __('Page status'))->editable('select', [1 => '启用', 2 => '关闭']);
        $grid->created_at(trans('admin.created_at'));
        $grid->updated_at(trans('admin.updated_at'));

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
        $form = new Form(new Pages);


        $form->text('title', __('Page title'))->required();;
        $form->UEditor('content', __('Page content'))->required();
        $form->text('tag', __('Page tag'))->required()->help('页面链接为：'.url("").'/pages/标识.html');
        $form->radio('status', __('Page status'))->options([1=> '启用', 2=> '关闭'])
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
