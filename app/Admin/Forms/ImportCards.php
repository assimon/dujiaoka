<?php

namespace App\Admin\Forms;

use App\Models\Cards;
use App\Models\Products;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImportCards extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '导入卡密';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'product_id' => 'required',
            'card_info' => 'required',
        );
        $messages = ['product_id.required' => '请选择商品', 'card_info.required' => '请输入卡密内容'];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return admin_error('提醒', $validator->errors()->first());
        } else {
            $cardList = explode(PHP_EOL, $data['card_info']);
            $kamiList = [];
            foreach ($cardList as $key => $v) {
                if($v != ""){
                    $kamiList[$key]['card_info'] = delete_html($v);
                    $kamiList[$key]['product_id'] = $data['product_id'];
                    $kamiList[$key]['created_at'] = date('Y-m-d H:i:s');
                }
            }
            if($data['checkm'] == 2 ){
                $kamiList = assoc_unique($kamiList, 'card_info');
            }
            $posts = Cards::insert($kamiList);
            if (!$posts) {
                return admin_error('提醒', '导入失败，请检查格式');
            }
        }
        // 增加库存
        Products::where('id', '=', $data['product_id'])->increment('in_stock', count($kamiList));
        admin_success('提醒', '操作成功本次共导入:'.count($kamiList).'条卡密');

        return redirect(config('admin.route.prefix') . '/cards');
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $commodity = Products::where('pd_type', 1)->get(['id', 'pd_name'])->toArray();
        $commodClass = [];
        foreach ($commodity as $val)
        {
            $commodClass[$val['id']] = $val['pd_name'];
        }
        $this->select('product_id', __('Product id'))->options($commodClass)->rules('required',['请选择商品'])->default(key($commodClass));
        $this->textarea('card_info', __('Card info'))->rules('required',['请输入卡密内容'])->rows(20)->help('一行一个，回车分隔');
        $this->radio('checkm', '是否去掉重复卡密')->options([1 => '否', 2 => '是'])->default(1);
        return $this;
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
        ];
    }
}
