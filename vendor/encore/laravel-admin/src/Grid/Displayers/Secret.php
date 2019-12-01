<?php

namespace Encore\Admin\Grid\Displayers;

use Encore\Admin\Facades\Admin;

class Secret extends AbstractDisplayer
{
    public function display($dotCount = 6)
    {
        $this->addScript();

        $dots = str_repeat('*', $dotCount);

        return <<<HTML
<span class="secret-wrapper">
    <i class="fa fa-eye" style="cursor: pointer;"></i>
    &nbsp;
    <span class="secret-placeholder" style="vertical-align: middle;">{$dots}</span>
    <span class="secret-content" style="display: none;">{$this->getValue()}</span>
</span>
HTML;
    }

    protected function addScript()
    {
        $script = <<<'SCRIPT'
$('.secret-wrapper i').click(function () {
    $(this).toggleClass('fa-eye fa-eye-slash').parent().find('.secret-placeholder,.secret-content').toggle();
});
SCRIPT;

        Admin::script($script);
    }
}
