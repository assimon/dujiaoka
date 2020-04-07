<?php

namespace App\Admin\Forms;

use App\Models\Coupons;
use App\Models\Products;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CreateCoupons extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '优惠码生成';

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
        if ($data['c_type'] == 2) {
            $coupon['product_id'] = $data['product_id'];
            $coupon['c_type'] = $data['c_type'];
            $coupon['discount'] = $data['discount'];
            $coupon['card'] = Str::random(16);
            $coupon['ret'] = $data['ret'];
            $coupon['created_at'] = date('Y-m-d H:i');
        } else {
            for ($i=0; $i < $data['number']; $i++) {
                $coupon[$i]['product_id'] = $data['product_id'];
                $coupon[$i]['c_type'] = 1;
                $coupon[$i]['discount'] = $data['discount'];
                $coupon[$i]['card'] = Str::random(16);
                $coupon[$i]['ret'] = 1;
                $coupon[$i]['created_at'] = date('Y-m-d H:i');
            }
        }
        $posts = Coupons::insert($coupon);
        if (!$posts) {
            admin_error('提醒', '数据处理成功失败.');
        }
        admin_success('提醒', '生成优惠券成功');

        return redirect(config('admin.route.prefix') . '/coupons');
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        // 加载所有卡密商品
        $commodity = Products::all(['id', 'pd_name'])->toArray();
        $commodClass = [];
        foreach ($commodity as $val)
        {
            $commodClass[$val['id']] = $val['pd_name'];
        }
        $this->select('product_id', __('Product id'))->options($commodClass)->rules('required',['请选择商品'])->default(key($commodClass));
        $this->radio('c_type', __('C type'))->options([1 => '一次性使用', 2 => '重复使用'])->default(1);
        $this->currency('discount', __('Discount'))->rules('required|numeric', ['required' => '优惠金额不能为空','numeric' => '请正确填写金额，整数或小数'])->default(1);
        $this->text('ret', __('Ret'))->default(1)->help('当类型为一次性时，系统默认可用次数为1');
        $this->text('number', __('Number'))->default(1)->help('当类型为重复使用时，系统只创建一张');
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
