<?php

namespace Encore\Admin\Grid\Displayers;

use Encore\Admin\Admin;

class Orderable extends AbstractDisplayer
{
    public function display()
    {
        if (!trait_exists('\Spatie\EloquentSortable\SortableTrait')) {
            throw new \Exception('To use orderable grid, please install package [spatie/eloquent-sortable] first.');
        }

        Admin::script($this->script());

        return <<<EOT

<div class="btn-group">
    <button type="button" class="btn btn-xs btn-info {$this->grid->getGridRowName()}-orderable" data-id="{$this->getKey()}" data-direction="1">
        <i class="fa fa-caret-up fa-fw"></i>
    </button>
    <button type="button" class="btn btn-xs btn-default {$this->grid->getGridRowName()}-orderable" data-id="{$this->getKey()}" data-direction="0">
        <i class="fa fa-caret-down fa-fw"></i>
    </button>
</div>

EOT;
    }

    protected function script()
    {
        return <<<EOT

$('.{$this->grid->getGridRowName()}-orderable').on('click', function() {

    var key = $(this).data('id');
    var direction = $(this).data('direction');

    $.post('{$this->getResource()}/' + key, {_method:'PUT', _token:LA.token, _orderable:direction}, function(data){
        if (data.status) {
            $.pjax.reload('#pjax-container');
            toastr.success(data.message);
        }
    });

});
EOT;
    }
}
