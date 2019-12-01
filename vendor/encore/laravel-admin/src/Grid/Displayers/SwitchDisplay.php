<?php

namespace Encore\Admin\Grid\Displayers;

use Encore\Admin\Admin;
use Illuminate\Support\Arr;

class SwitchDisplay extends AbstractDisplayer
{
    protected $states = [
        'on'  => ['value' => 1, 'text' => 'ON', 'color' => 'primary'],
        'off' => ['value' => 0, 'text' => 'OFF', 'color' => 'default'],
    ];

    protected function updateStates($states)
    {
        foreach (Arr::dot($states) as $key => $state) {
            Arr::set($this->states, $key, $state);
        }
    }

    public function display($states = [])
    {
        $this->updateStates($states);

        $name = $this->column->getName();

        $class = 'grid-switch-'.str_replace('.', '-', $name);

        $keys = collect(explode('.', $name));
        if ($keys->isEmpty()) {
            $key = $name;
        } else {
            $key = $keys->shift().$keys->reduce(function ($carry, $val) {
                return $carry."[$val]";
            });
        }

        $script = <<<EOT

$('.$class').bootstrapSwitch({
    size:'mini',
    onText: '{$this->states['on']['text']}',
    offText: '{$this->states['off']['text']}',
    onColor: '{$this->states['on']['color']}',
    offColor: '{$this->states['off']['color']}',
    onSwitchChange: function(event, state){

        $(this).val(state ? 'on' : 'off');

        var pk = $(this).data('key');
        var value = $(this).val();
        var _status = true;

        $.ajax({
            url: "{$this->grid->resource()}/" + pk,
            type: "POST",
            async:false,
            data: {
                "$key": value,
                _token: LA.token,
                _method: 'PUT'
            },
            success: function (data) {
                if (data.status)
                    toastr.success(data.message);
                else
                    toastr.warning(data.message);
            },
            complete:function(xhr,status) {
                if (status == 'success')
                    _status = xhr.responseJSON.status;
            }
        });
        
        return _status;
    }
});

EOT;

        Admin::script($script);

        $key = $this->row->{$this->grid->getKeyName()};

        $checked = $this->states['on']['value'] == $this->value ? 'checked' : '';

        return <<<EOT
        <input type="checkbox" class="$class" $checked data-key="$key" />
EOT;
    }
}
