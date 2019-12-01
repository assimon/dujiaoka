<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Form\Field;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Select extends Field
{
    /**
     * @var array
     */
    protected static $css = [
        '/vendor/laravel-admin/AdminLTE/plugins/select2/select2.min.css',
    ];

    /**
     * @var array
     */
    protected static $js = [
        '/vendor/laravel-admin/AdminLTE/plugins/select2/select2.full.min.js',
    ];

    /**
     * @var array
     */
    protected $groups = [];

    /**
     * @var array
     */
    protected $config = [];

    /**
     * Set options.
     *
     * @param array|callable|string $options
     *
     * @return $this|mixed
     */
    public function options($options = [])
    {
        // remote options
        if (is_string($options)) {
            // reload selected
            if (class_exists($options) && in_array(Model::class, class_parents($options))) {
                return $this->model(...func_get_args());
            }

            return $this->loadRemoteOptions(...func_get_args());
        }

        if ($options instanceof Arrayable) {
            $options = $options->toArray();
        }

        if (is_callable($options)) {
            $this->options = $options;
        } else {
            $this->options = (array) $options;
        }

        return $this;
    }

    /**
     * @param array $groups
     */

    /**
     * Set option groups.
     *
     * eg: $group = [
     *        [
     *        'label' => 'xxxx',
     *        'options' => [
     *            1 => 'foo',
     *            2 => 'bar',
     *            ...
     *        ],
     *        ...
     *     ]
     *
     * @param array $groups
     *
     * @return $this
     */
    public function groups(array $groups)
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * Load options for other select on change.
     *
     * @param string $field
     * @param string $sourceUrl
     * @param string $idField
     * @param string $textField
     *
     * @return $this
     */
    public function load($field, $sourceUrl, $idField = 'id', $textField = 'text', bool $allowClear = true)
    {
        if (Str::contains($field, '.')) {
            $field = $this->formatName($field);
            $class = str_replace(['[', ']'], '_', $field);
        } else {
            $class = $field;
        }

        $placeholder = json_encode([
            'id'   => '',
            'text' => trans('admin.choose'),
        ]);

        $strAllowClear = var_export($allowClear, true);

        $script = <<<EOT
$(document).off('change', "{$this->getElementClassSelector()}");
$(document).on('change', "{$this->getElementClassSelector()}", function () {
    var target = $(this).closest('.fields-group').find(".$class");
    $.get("$sourceUrl",{q : this.value}, function (data) {
        target.find("option").remove();
        $(target).select2({
            placeholder: $placeholder,
            allowClear: $strAllowClear,
            data: $.map(data, function (d) {
                d.id = d.$idField;
                d.text = d.$textField;
                return d;
            })
        }).trigger('change');
    });
});
EOT;

        Admin::script($script);

        return $this;
    }

    /**
     * Load options for other selects on change.
     *
     * @param array  $fields
     * @param array  $sourceUrls
     * @param string $idField
     * @param string $textField
     *
     * @return $this
     */
    public function loads($fields = [], $sourceUrls = [], $idField = 'id', $textField = 'text', bool $allowClear = true)
    {
        $fieldsStr = implode('.', $fields);
        $urlsStr = implode('^', $sourceUrls);

        $placeholder = json_encode([
            'id'   => '',
            'text' => trans('admin.choose'),
        ]);

        $strAllowClear = var_export($allowClear, true);

        $script = <<<EOT
var fields = '$fieldsStr'.split('.');
var urls = '$urlsStr'.split('^');

var refreshOptions = function(url, target) {
    $.get(url).then(function(data) {
        target.find("option").remove();
        $(target).select2({
            placeholder: $placeholder,
            allowClear: $strAllowClear,        
            data: $.map(data, function (d) {
                d.id = d.$idField;
                d.text = d.$textField;
                return d;
            })
        }).trigger('change');
    });
};

$(document).off('change', "{$this->getElementClassSelector()}");
$(document).on('change', "{$this->getElementClassSelector()}", function () {
    var _this = this;
    var promises = [];

    fields.forEach(function(field, index){
        var target = $(_this).closest('.fields-group').find('.' + fields[index]);
        promises.push(refreshOptions(urls[index] + "?q="+ _this.value, target));
    });
});
EOT;

        Admin::script($script);

        return $this;
    }

    /**
     * Load options from current selected resource(s).
     *
     * @param string $model
     * @param string $idField
     * @param string $textField
     *
     * @return $this
     */
    public function model($model, $idField = 'id', $textField = 'name')
    {
        if (!class_exists($model)
            || !in_array(Model::class, class_parents($model))
        ) {
            throw new \InvalidArgumentException("[$model] must be a valid model class");
        }

        $this->options = function ($value) use ($model, $idField, $textField) {
            if (empty($value)) {
                return [];
            }

            $resources = [];

            if (is_array($value)) {
                if (Arr::isAssoc($value)) {
                    $resources[] = Arr::get($value, $idField);
                } else {
                    $resources = array_column($value, $idField);
                }
            } else {
                $resources[] = $value;
            }

            return $model::find($resources)->pluck($textField, $idField)->toArray();
        };

        return $this;
    }

    /**
     * Load options from remote.
     *
     * @param string $url
     * @param array  $parameters
     * @param array  $options
     *
     * @return $this
     */
    protected function loadRemoteOptions($url, $parameters = [], $options = [])
    {
        $ajaxOptions = [
            'url' => $url.'?'.http_build_query($parameters),
        ];
        $configs = array_merge([
            'allowClear'         => true,
            'placeholder'        => [
                'id'        => '',
                'text'      => trans('admin.choose'),
            ],
        ], $this->config);

        $configs = json_encode($configs);
        $configs = substr($configs, 1, strlen($configs) - 2);

        $ajaxOptions = json_encode(array_merge($ajaxOptions, $options));

        $this->script = <<<EOT

$.ajax($ajaxOptions).done(function(data) {

  $("{$this->getElementClassSelector()}").each(function(index, element) {
      $(element).select2({
        data: data,
        $configs
      });
      var value = $(element).data('value') + '';
      if (value) {
        value = value.split(',');
        $(element).select2('val', value);
      }
  });
});

EOT;

        return $this;
    }

    /**
     * Load options from ajax results.
     *
     * @param string $url
     * @param $idField
     * @param $textField
     *
     * @return $this
     */
    public function ajax($url, $idField = 'id', $textField = 'text')
    {
        $configs = array_merge([
            'allowClear'         => true,
            'placeholder'        => $this->label,
            'minimumInputLength' => 1,
        ], $this->config);

        $configs = json_encode($configs);
        $configs = substr($configs, 1, strlen($configs) - 2);

        $this->script = <<<EOT

$("{$this->getElementClassSelector()}").select2({
  ajax: {
    url: "$url",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        q: params.term,
        page: params.page
      };
    },
    processResults: function (data, params) {
      params.page = params.page || 1;

      return {
        results: $.map(data.data, function (d) {
                   d.id = d.$idField;
                   d.text = d.$textField;
                   return d;
                }),
        pagination: {
          more: data.next_page_url
        }
      };
    },
    cache: true
  },
  $configs,
  escapeMarkup: function (markup) {
      return markup;
  }
});

EOT;

        return $this;
    }

    /**
     * Set config for select2.
     *
     * all configurations see https://select2.org/configuration/options-api
     *
     * @param string $key
     * @param mixed  $val
     *
     * @return $this
     */
    public function config($key, $val)
    {
        $this->config[$key] = $val;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function readOnly()
    {
        //移除特定字段名称,增加MultipleSelect的修订
        //没有特定字段名可以使多个readonly的JS代码片段被Admin::script的array_unique精简代码
        $script = <<<'EOT'
$("form select").on("select2:opening", function (e) {
    if($(this).attr('readonly') || $(this).is(':hidden')){
    e.preventDefault();
    }
});
$(document).ready(function(){
    $('select').each(function(){
        if($(this).is('[readonly]')){
            $(this).closest('.form-group').find('span.select2-selection__choice__remove').first().remove();
            $(this).closest('.form-group').find('li.select2-search').first().remove();
            $(this).closest('.form-group').find('span.select2-selection__clear').first().remove();
        }
    });
});
EOT;
        Admin::script($script);

        return parent::readOnly();
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $configs = array_merge([
            'allowClear'  => true,
            'placeholder' => [
                'id'   => '',
                'text' => $this->label,
            ],
        ], $this->config);

        $configs = json_encode($configs);

        if (empty($this->script)) {
            $this->script = "$(\"{$this->getElementClassSelector()}\").select2($configs);";
        }

        if ($this->options instanceof \Closure) {
            if ($this->form) {
                $this->options = $this->options->bindTo($this->form->model());
            }

            $this->options(call_user_func($this->options, $this->value, $this));
        }

        $this->options = array_filter($this->options, 'strlen');

        $this->addVariables([
            'options' => $this->options,
            'groups'  => $this->groups,
        ]);

        $this->attribute('data-value', implode(',', (array) $this->value()));

        return parent::render();
    }
}
