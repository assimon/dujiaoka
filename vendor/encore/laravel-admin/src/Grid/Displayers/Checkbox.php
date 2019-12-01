<?php

namespace Encore\Admin\Grid\Displayers;

use Encore\Admin\Admin;
use Illuminate\Contracts\Support\Arrayable;

class Checkbox extends AbstractDisplayer
{
    public function display($options = [])
    {
        if ($options instanceof \Closure) {
            $options = $options->call($this, $this->row);
        }

        $radios = '';
        $name = $this->column->getName();

        if (is_string($this->value)) {
            $this->value = explode(',', $this->value);
        }

        if ($this->value instanceof Arrayable) {
            $this->value = $this->value->toArray();
        }

        foreach ($options as $value => $label) {
            $checked = in_array($value, $this->value) ? 'checked' : '';
            $radios .= <<<EOT
<div class="checkbox">
    <label>
        <input type="checkbox" name="grid-checkbox-{$name}[]" value="{$value}" $checked />{$label}
    </label>
</div>
EOT;
        }

        Admin::script($this->script());

        return <<<EOT
<form class="form-group grid-checkbox-$name" style="text-align:left;" data-key="{$this->getKey()}">
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

$('form.grid-checkbox-$name').on('submit', function () {
    var values = $(this).find('input:checkbox:checked').map(function (_, el) {
        return $(el).val();
    }).get();

    var data = {
        $name: values,
        _token: LA.token,
        _method: 'PUT'
    };
    
    $.ajax({
        url: "{$this->getResource()}/" + $(this).data('key'),
        type: "POST",
        contentType: 'application/json;charset=utf-8',
        data: JSON.stringify(data),
        success: function (data) {
            toastr.success(data.message);
        }
    });

    return false;
});

EOT;
    }
}
