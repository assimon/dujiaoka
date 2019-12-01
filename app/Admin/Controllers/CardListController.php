<?php

namespace App\Admin\Controllers;

use App\Api\Helpers\Api\User;
use App\Models\CardList;
use App\Http\Controllers\Controller;
use App\Models\Commodity;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Form;
use Illuminate\Support\Facades\Validator;

class CardListController extends Controller
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
            ->header('卡密管理')
            ->description('卡密列表')
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
            ->header('编辑卡密')
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
            ->header('添加卡密')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CardList);
        $grid->model()->orderBy('created_at', 'desc');
        // 加载所有卡密商品
        $commodity = Commodity::all(['id', 'pd_name'])->toArray();
        $commodClass = [];
        foreach ($commodity as $val)
        {
            $commodClass[$val['id']] = $val['pd_name'];
        }
        $grid->id('ID');
        $grid->column('commodity.pd_name', '商品名称');
        $grid->card_info('卡密内容')->limit(10);
        $grid->cd_status('状态')->editable('select', [1 => '未售出', 2 => '已售出']);
        $grid->created_at('创建时间');
        $grid->updated_at('修改时间');
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        $grid->filter(function($filter) use ($commodClass){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->equal('id', '卡密id');
            // 在这里添加字段过滤器
            $filter->like('card_info', '卡密内容');
            $filter->equal('card_pd', '所属商品')->select($commodClass);
            $filter->equal('cd_status', '状态')->select([1 => '未售出', 2 => '已售出']);


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
        $show = new Show(CardList::findOrFail($id));

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
        $form = new Form(new CardList);

        // 加载所有卡密商品
        $commodity = Commodity::all(['id', 'pd_name'])->toArray();
        $commodClass = [];
        foreach ($commodity as $val)
        {
            $commodClass[$val['id']] = $val['pd_name'];
        }
        $form->select('card_pd', '所属商品')->options($commodClass)->rules('required',['请选择商品']);
        $form->textarea('card_info', '卡密内容')->rules('required',['请输入卡密内容']);
        $form->select('cd_status', '卡密状态')->options([1 => '待出售', 2 => '已售出'])->rules('required',['请选择卡密状态'])->default(1);
        // $form->display('ID');
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


    public function importcard(Content $content)
    {
        //添加请求
        if (request()->isMethod('post')) {
            $data = request()->post();
            $rules = array(
                'card_pd' => 'required',
                'card_info' => 'required',
            );
            $messages = ['card_pd.required' => '请选择商品', 'card_info.required' => '请输入卡密内容'];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return $content->body($this->importCardForm())->withError('提醒', '商品或卡密列表不能为空，请检查');
            } else {
                $cardList = explode(PHP_EOL, $data['card_info']);
                $kamiList = [];
                foreach ($cardList as $key => $v) {
                    if($v != ""){
                        $kamiList[$key]['card_info'] = delete_html($v);
                        $kamiList[$key]['card_pd'] = $data['card_pd'];
                        $kamiList[$key]['created_at'] = date('Y-m-d H:i:s');
                    }
                }
                if($data['checkm'] == 2 ){
                    $kamiList = assoc_unique($kamiList, 'card_info');
                }
                $card = new CardList();
                $posts = CardList::insert($kamiList);
                if (!$posts) {
                    return $content->body($this->importCardForm())->withError('提醒', '导入失败，请检查格式');
                }
                // 增加库存
                Commodity::where('id', '=', $data['card_pd'])->increment('in_stock', count($kamiList));
                return $content->body($this->importCardForm())->withSuccess('提醒', '操作成功本次共导入:'.count($kamiList).'条卡密');
            }

        }
        $content->header('导入卡密')
            ->description('批量导入')
            ->body($this->importCardForm());
        return $content;

    }

    protected function importCardForm()
    {

        $form = new \Encore\Admin\Widgets\Form();
        $form->action('importcard');
        // 加载所有卡密商品
        $commodity = Commodity::all(['id', 'pd_name'])->toArray();
        $commodClass = [];
        foreach ($commodity as $val)
        {
            $commodClass[$val['id']] = $val['pd_name'];
        }
        $form->select('card_pd', '所属商品')->options($commodClass)->rules('required',['请选择商品'])->default(key($commodClass));
        $form->textarea('card_info', '卡密内容(一行一条，注意规范)')->rules('required',['请输入卡密内容'])->rows(20);
        $form->radio('checkm', '是否去掉重复卡密')->options([1 => '否', 2 => '是'])->default(1);
        return $form;
    }

}
