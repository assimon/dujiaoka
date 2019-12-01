<?php

namespace Encore\Admin\Grid\Displayers;

use Encore\Admin\Facades\Admin;

/**
 * Class QRCode.
 */
class QRCode extends AbstractDisplayer
{
    protected function addScript()
    {
        $script = <<<'SCRIPT'
$('.grid-column-qrcode').popover({
    html: true,
    trigger: 'focus'
});
SCRIPT;

        Admin::script($script);
    }

    public function display($formatter = null, $width = 150, $height = 150)
    {
        $this->addScript();

        $content = $this->getColumn()->getOriginal();

        if ($formatter instanceof \Closure) {
            $content = call_user_func($formatter, $content, $this->row);
        }

        $img = sprintf(
            "<img src='https://api.qrserver.com/v1/create-qr-code/?size=%sx%s&data=%s' style='height:%spx;width:%spx;'/>",
            $width, $height, $content, $height, $width
        );

        return <<<HTML
<a href="javascript:void(0);" class="grid-column-qrcode text-muted" data-content="{$img}" data-toggle='popover' tabindex='0'>
    <i class="fa fa-qrcode"></i>
</a>&nbsp;{$this->getValue()}
HTML;
    }
}
