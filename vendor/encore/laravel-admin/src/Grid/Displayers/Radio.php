<?php

namespace Encore\Admin\Grid\Displayers;

use Encore\Admin\Admin;

class Radio extends AbstractDisplayer
{
    public function display($options = [])
    {
        if ($options instanceof \Closure) {
            $options = $options->call($this, $this->row);
        }

        $radios = '';
        $name = $this->column->getName();

        foreach ($options as $value => $label) {
            $checked = ($value == $this->value) ? 'checked' : '';
            $radios .= <<<EOT
<div class="radio">
    <label>
        <input type="radio" name="grid-radio-$name" value="{$value}" $checked />{$label}
    </label>
</div>
EOT;
        }

        Admin::script($this->script());

        return <<<EOT
<form class="form-group grid-radio-$name" style="text-align: left" data-key="{$this->getKey()}">
    $radios
    <button type="submit" class="btn btn-info btn-xs pull-left">
        <i class="fa fa-save"></i>&nbsp;{$this->trans('save')}
    </button>
    <button type="reset" class="btn btn-warning btn-xs pull-left" style="margin-left:10px;">
        <i class="fa fa-trash"></i>&nbsp;{$this->trans('reset')}
    </button>
</form>
EOT;
    }

    protected function script()
    {
        $name = $this->column->getName();

        return <<<EOT

$('form.grid-radio-$name').on('submit', function () {
    var value = $(this).find('input:radio:checked').val();

    $.ajax({
        url: "{$this->getResource()}/" + $(this).data('key'),
        type: "POST",
        data: {
            $name: value,
            _token: LA.token,
            _method: 'PUT'
        },
        success: function (data) {
            toastr.success(data.message);
        }
    });

    return false;
});

EOT;
    }
}
