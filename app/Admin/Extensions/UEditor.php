<?php
namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

class UEditor extends Field
{
    // 定义视图
    protected $view = 'admin.form.ueditor';

    protected static $css = [];

    protected static $js = [
        '/vendor/ueditor/ueditor.config.js',
        '/vendor/ueditor/ueditor.all.min.js',
        '/vendor/ueditor/lang/zh-cn/zh-cn.js',
    ];

    public function render()
    {
        $this->script = <<<EOT
        window.UEDITOR_CONFIG.serverUrl = '/ueditor/server';
        UE.delEditor("{$this->id}");
        var ue = UE.getEditor('{$this->id}', {
            // 自定义工具栏
            toolbars: [
                ['fullscreen', 'source', 'undo', 'redo', 'bold', 'italic', 
                'underline','fontborder', 'backcolor', 'fontsize', 'fontfamily', 
                'justifyleft', 'justifyright','justifycenter', 'justifyjustify', 
                'strikethrough','superscript', 'subscript', 'removeformat',
                'formatmatch','autotypeset', 'blockquote', 'pasteplain', '|',
                'forecolor', 'backcolor','insertorderedlist', 'insertunorderedlist', 
                'selectall', 'cleardoc', 'link', 'unlink','emotion','insertimage','simpleupload', 'help']
            ],
            initialFrameHeight:400,
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode: false,
            wordCount: false,
            imagePopup: false,
            autotypeset: {indent: true, imageBlockLine: 'center'}
        });
        ue.ready(function () {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
EOT;
        return parent::render();
    }
}

