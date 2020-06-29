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
        $this->text('langs', __('Sys Langs'))->help('默认为中文zh-CN,不会翻译语言包不要改');
        $this->UEditor('notice', __('Sys notice'));
        $this->text('email_driver', __('Mail driver'))->help('一般为smtp');
        $this->text('mail_host', __('Mail host'));
        $this->text('mail_port', __('Mail port'));
        $this->text('mail_username', __('Mail username'));
        $this->text('mail_password', __('Mail password'));
        $this->text('mail_encryption', __('Mail encryption'))->help('ssl或者tls');
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
