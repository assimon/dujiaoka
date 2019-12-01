<?php

namespace App\Admin\Controllers;

use App\Api\Helpers\Api\User;
use App\Models\Classify;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ClassifyController extends Controller
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
            ->header('商品分类')
            ->description('列表')
            ->body($this->grid());
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
            ->header('商品分类')
            ->description('编辑商品')
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
            ->header('商品分类')
            ->description('创建分类')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Classify);
        $grid->model()->orderBy('ord', 'desc');
        $grid->id('ID');
        $grid->name('分类名称');
        $grid->ico('图标')->display(function ($ico){
            return '<i class="fa '.$ico.'"></i>';
        });
        $grid->column('ord','排序(数值越大排序越靠前)')->sortable();
        $status = [1=> '启用', 2=> '禁用'];
        $grid->c_status('状态')->editable('select', $status);
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
        $show = new Show(Classify::findOrFail($id));

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
        $form = new Form(new Classify);
        $form->text('name', '分类名称')->rules('required',['名称不能为空']);
        $form->icon('ico', '图标');
        $form->text('ord', '排序')->default(1);
        $status = [1=> '启用', 2=> '禁用'];
        $form->select('c_status', '状态')->options($status)->rules('required',['请选择状态'])->default(1);
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
