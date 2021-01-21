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
        if (isset($request->img_logo) && $request->img_logo->isValid()) {
            $path = $request->img_logo->store('images','admin');
            $data['img_logo'] = 'uploads/' . $path;
        }
        unset($data['s']);
        Webset::where('id', 1)->update($data);
        admin_success('成功', '保存网站设置成功');
        return redirect(config('admin.route.prefix') . '/setting');
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->text('title', __('Sys title'))->rules('required');
        $this->image('img_logo', __('Sys img logo'))->help('网站 Logo');
        $this->text('text_logo', __('Sys text logo'))->rules('required');
        $this->text('keywords', __('Sys keywords'))->rules('required');
        $this->textarea('description', __('Sys description'))->rules('required');
        $this->select('tpl_sign', __('Sys templates'))->options(config('dujiao.templates'))->rules('required');
        $this->email('manage_email', __('Sys manage email'))->rules('required')->help("用于接收待处理订单提醒");
        $this->select('langs', __('Sys Langs'))->options(config('dujiao.language'))->rules('required')->help('默认为简体中文 zh-CN，不会翻译语言包不要改');
        $this->radio('verify_code', __('Verify Code'))->options([1 => '开启', 2 => '关闭'])->default(1);
        $this->radio('isopen_searchpwd', __('Is open searchpwd'))->options([1 => '开启', 2 => '关闭'])->default(1);
        $this->radio('isopen_serverj', __('Is open serverj'))->options([1 => '开启', 2 => '关闭'])->default(1);
        $this->text('serverj_token', __('Serverj token'));
        $this->UEditor('notice', __('Sys notice'));
        $this->textarea('footer', __('Sys footer'))->help('可填写统计代码或 ICP 备案信息');

    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        $webset = Webset::query()->where('id', 1)->first();
        $webset->img_logo = url($webset->img_logo);
        return $webset->toArray();
    }

}
