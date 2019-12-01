<?php

namespace Encore\Admin\Config;

use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ConfigController
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('其他配置')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Edit interface.
     *
     * @param int     $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('其他配置')
            ->description('编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('其他配置')
            ->description('创建')
            ->body($this->form());
    }

    public function show($id, Content $content)
    {
        return $content
            ->header('其他配置')
            ->description('详情')
            ->body(Admin::show(ConfigModel::findOrFail($id), function (Show $show) {
                $show->id();
                $show->name('配置标识');
                $show->value('值');
                $show->description('描述');
                $show->created_at('创建时间');
                $show->updated_at('更新时间');
            }));
    }

    public function grid()
    {
        $grid = new Grid(new ConfigModel());

        $grid->id('ID')->sortable();
        $grid->name('配置标识')->display(function ($name) {
            return "<a tabindex=\"0\" class=\"btn btn-xs btn-twitter\" role=\"button\" data-toggle=\"popover\" data-html=true title=\"Usage\" data-content=\"<code>config('$name');</code>\">$name</a>";
        });
        $grid->value('值');
        $grid->description('描述');

        $grid->created_at('创建时间');
        $grid->updated_at('更新');

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->like('name');
            $filter->like('value');
        });

        return $grid;
    }

    public function form()
    {
        $form = new Form(new ConfigModel());

        $form->display('id', 'ID');
        $form->text('name', '配置标识')->rules('required');
        $form->textarea('value', '值')->rules('required');
        $form->textarea('description', '描述');


        return $form;
    }
}
