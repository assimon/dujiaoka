<?php

namespace App\Admin\Controllers;

use App\Api\Helpers\Api\User;
use App\Models\CardList;
use App\Models\Classify;
use App\Models\Commodity;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CommodityController extends Controller
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
            ->header('商品管理')
            ->description('列表')
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
            ->header('商品')
            ->description('编辑')
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
            ->header('商品')
            ->description('创建商品')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Commodity);
        $grid->model()->orderBy('pd_ord', 'desc');
        // 加载所有分类
        $classify = Classify::all(['id', 'name'])->toArray();
        $checkClass = [];
        foreach ($classify as $val)
        {
            $checkClass[$val['id']] = $val['name'];
        }
        $grid->id('ID');
        $grid->column('classify.name', '商品所属分类');
        $grid->pd_name('商品名称');
        $grid->actual_price('售价');
        $grid->in_stock('库存');
        $grid->sales_volume('销量');
        $grid->product_picture('商品图片')->image();
        $grid->pd_ord('商品排序')->sortable();
        $grid->pd_status('状态')->editable('select', [1 => '上架中', 2 => '已下架']);
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        $grid->filter(function($filter) use ($checkClass){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->equal('id', '商品id');
            // 在这里添加字段过滤器
            $filter->like('pd_name', '商品名称');
            $filter->equal('pd_type', '商品分类')->select($checkClass);
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
        $show = new Show(Commodity::findOrFail($id));

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
        $form = new Form(new Commodity);
        // 加载所有分类
        $classify = Classify::all(['id', 'name'])->toArray();
        $checkClass = [];
        foreach ($classify as $val)
        {
            $checkClass[$val['id']] = $val['name'];
        }
        $form->select('pd_type', '商品分类')->options($checkClass)->rules('required',['请选择分类']);
        $form->model()->orderBy('pd_ord', 'desc');
        $form->select('pd_status', '商品状态')->options([1 => '上架', 2 => '下架'])->rules('required',['请选择商品状态']);
        $form->text('pd_name', '商品名称')->rules('required', ['商品名称不能为空']);
        $form->text('actual_price', '售价')->rules('required|numeric', ['required' => '售价不能为空','numeric' => '请正确填写金额,整数或小数']);
        $form->text('in_stock', '库存')->help('(卡密商品请不要填写库存，服务器自行识别)')->default(0);
        $form->text('sales_volume', '销量')->default(0);
        $form->image('product_picture', '商品图片')->uniqueName();
        $form->text('pd_ord', '排序')->default(0);
        $form->ueditor('pd_info', '商品描述');
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
