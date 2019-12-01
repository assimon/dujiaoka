<?php

namespace App\Admin\Controllers;

use App\Api\Helpers\Api\User;
use App\Models\OrderStatistics;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OrderStatisticsController extends Controller
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
            ->header('订单统计')
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
            ->header('Edit')
            ->description('description')
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
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OrderStatistics);
        $grid->model()->orderBy('count_day', 'desc');
        $grid->id('ID');
        $grid->count_ord('当日总订单数');
        $grid->count_pd('当日售出总商品数');
        $grid->count_money('当日总收入');
        $grid->count_day('日期');
        $grid->disableCreateButton();
        $grid->disableActions();
        $grid->filter(function($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->date('count_day', '日期');

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
        $show = new Show(OrderStatistics::findOrFail($id));

        $show->id('ID');


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new OrderStatistics);

        $form->display('ID');
        $form->display('Created at');
        $form->display('Updated at');

        return $form;
    }
}
