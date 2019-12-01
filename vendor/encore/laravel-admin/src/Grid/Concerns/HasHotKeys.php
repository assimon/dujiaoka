<?php

namespace Encore\Admin\Grid\Concerns;

use Encore\Admin\Admin;

trait HasHotKeys
{
    protected function addHotKeyScript()
    {
        $filterID = $this->getFilter()->getFilterID();

        $refreshMessage = __('admin.refresh_succeeded');

        $script = <<<SCRIPT

$(document).off('keydown').keydown(function(e) {
    var tag = e.target.tagName.toLowerCase();
    
    if (tag == 'input' || tag == 'textarea') {
        return;
    }

    var \$box = $("#{$this->tableID}").closest('.box');
    var \$current_page = \$box.find('.pagination .page-item.active');

    switch(e.which) {
        case 82: // `r` for reload
            $.admin.reload();
            $.admin.toastr.success('{$refreshMessage}', '', {positionClass:"toast-top-center"});
            break;
        case 83: // `s` for search
            \$box.find('input.grid-quick-search').trigger('focus');
            break; 
        case 70: // `f` for open filter
            \$box.find('#{$filterID}').toggleClass('hide');
            break;
        case 67: // `c` go to create page 
            \$box.find('.grid-create-btn>a').trigger('click');
            break; 
        case 37: // `left` for go to prev page
            \$current_page.prev().find('a').trigger('click');
            break;
        case 39: // `right` for go to next page
            \$current_page.next().find('a').trigger('click');
            break;
        default: return;
    }
    e.preventDefault();
});

SCRIPT;

        Admin::script($script);
    }

    public function enableHotKeys()
    {
        $this->addHotKeyScript();

        return $this;
    }
}
