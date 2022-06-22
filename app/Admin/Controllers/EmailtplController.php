<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\BatchRestore;
use App\Admin\Actions\Post\Restore;
use App\Admin\Repositories\Emailtpl;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Models\Emailtpl as EmailTplModel;

class EmailtplController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Emailtpl(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('tpl_name');
            $grid->column('tpl_token');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->disableViewButton();
            $grid->disableDeleteButton();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('tpl_name');
                $filter->like('tpl_token');
            });
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == admin_trans('dujiaoka.trashed')) {
                    $actions->append(new Restore(EmailTplModel::class));
                }
            });
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == admin_trans('dujiaoka.trashed')) {
                    $batch->add(new BatchRestore(EmailTplModel::class));
                }
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Emailtpl(), function (Show $show) {
            $show->field('id');
            $show->field('tpl_name');
            $show->field('tpl_content');
            $show->field('tpl_token');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Emailtpl(), function (Form $form) {
            $form->display('id');
            $form->text('tpl_name')->required();
            $form->editor('tpl_content')->required();
            if ($form->isCreating()) {
                $form->text('tpl_token')->required();
            } else {
                $form->text('tpl_token')->disable();
            }
            $form->display('created_at');
            $form->display('updated_at');
            $form->disableViewButton();
            $form->disableDeleteButton();
            $form->footer(function ($footer) {
                // 去掉`查看`checkbox
                $footer->disableViewCheck();
            });
        });
    }
}
