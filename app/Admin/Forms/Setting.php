<?php

namespace App\Admin\Forms;

use App\Models\Webset;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class Setting extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '网站设置';

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
        $webset = Webset::where('id', 1)->update($data);
        admin_success('成功', '保存网站设置成功');
        return redirect(config('admin.route.prefix') . '/setting');
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->text('title', __('Sys title'))->rules('required');
        $this->text('text_logo', __('Sys text logo'))->rules('required');
        $this->text('keywords', __('Sys keywords'))->rules('required');
        $this->textarea('description', __('Sys description'))->rules('required');
        $this->email('manage_email', __('Sys manage email'))->rules('required')->help("用于接收待处理订单提示");
        $this->UEditor('layerad',__('Sys pop notice'));
        $this->UEditor('notice', __('Sys notice'));
        $this->textarea('footer', __('Sys footer'))->help('可以填写一些统计代码或者icp备案信息');
        //$this->radio('instock', __('Sys in stock monitor'))->options([1 => '开启', 2 => '关闭'])->default(1);

    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        $webset = Webset::where('id', 1)->first();
        return $webset->toArray();
    }
}
