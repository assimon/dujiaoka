<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Form\Field;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MultipleFile extends Field
{
    use UploadField;

    /**
     * Css.
     *
     * @var array
     */
    protected static $css = [
        '/vendor/laravel-admin/bootstrap-fileinput/css/fileinput.min.css?v=4.5.2',
    ];

    /**
     * Js.
     *
     * @var array
     */
    protected static $js = [
        '/vendor/laravel-admin/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js',
        '/vendor/laravel-admin/bootstrap-fileinput/js/fileinput.min.js?v=4.5.2',
        '/vendor/laravel-admin/bootstrap-fileinput/js/plugins/sortable.min.js?v=4.5.2',
    ];

    /**
     * Create a new File instance.
     *
     * @param string $column
     * @param array  $arguments
     */
    public function __construct($column, $arguments = [])
    {
        $this->initStorage();

        parent::__construct($column, $arguments);
    }

    /**
     * Default directory for file to upload.
     *
     * @return mixed
     */
    public function defaultDirectory()
    {
        return config('admin.upload.directory.file');
    }

    /**
     * {@inheritdoc}
     */
    public function getValidator(array $input)
    {
        if (request()->has(static::FILE_DELETE_FLAG)) {
            return false;
        }

        if (request()->has(static::FILE_SORT_FLAG)) {
            return false;
        }

        if ($this->validator) {
            return $this->validator->call($this, $input);
        }

        $attributes = [];

        if (!$fieldRules = $this->getRules()) {
            return false;
        }

        $attributes[$this->column] = $this->label;

        list($rules, $input) = $this->hydrateFiles(Arr::get($input, $this->column, []));

        return \validator($input, $rules, $this->getValidationMessages(), $attributes);
    }

    /**
     * Hydrate the files array.
     *
     * @param array $value
     *
     * @return array
     */
    protected function hydrateFiles(array $value)
    {
        if (empty($value)) {
            return [[$this->column => $this->getRules()], []];
        }

        $rules = $input = [];

        foreach ($value as $key => $file) {
            $rules[$this->column.$key] = $this->getRules();
            $input[$this->column.$key] = $file;
        }

        return [$rules, $input];
    }

    /**
     * Sort files.
     *
     * @param string $order
     *
     * @return array
     */
    protected function sortFiles($order)
    {
        $order = explode(',', $order);

        $new = [];
        $original = $this->original();

        foreach ($order as $item) {
            $new[] = Arr::get($original, $item);
        }

        return $new;
    }

    /**
     * Prepare for saving.
     *
     * @param UploadedFile|array $files
     *
     * @return mixed|string
     */
    public function prepare($files)
    {
        if (request()->has(static::FILE_DELETE_FLAG)) {
            return $this->destroy(request(static::FILE_DELETE_FLAG));
        }

        if (is_string($files) && request()->has(static::FILE_SORT_FLAG)) {
            return $this->sortFiles($files);
        }

        $targets = array_map([$this, 'prepareForeach'], $files);

        return array_merge($this->original(), $targets);
    }

    /**
     * @return array|mixed
     */
    public function original()
    {
        if (empty($this->original)) {
            return [];
        }

        return $this->original;
    }

    /**
     * Prepare for each file.
     *
     * @param UploadedFile $file
     *
     * @return mixed|string
     */
    protected function prepareForeach(UploadedFile $file = null)
    {
        $this->name = $this->getStoreName($file);

        return tap($this->upload($file), function () {
            $this->name = null;
        });
    }

    /**
     * Preview html for file-upload plugin.
     *
     * @return array
     */
    protected function preview()
    {
        $files = $this->value ?: [];

        return array_values(array_map([$this, 'objectUrl'], $files));
    }

    /**
     * Initialize the caption.
     *
     * @param array $caption
     *
     * @return string
     */
    protected function initialCaption($caption)
    {
        if (empty($caption)) {
            return '';
        }

        $caption = array_map('basename', $caption);

        return implode(',', $caption);
    }

    /**
     * @return array
     */
    protected function initialPreviewConfig()
    {
        $files = $this->value ?: [];

        $config = [];

        foreach ($files as $index => $file) {
            $preview = array_merge([
                'caption' => basename($file),
                'key'     => $index,
            ], $this->guessPreviewType($file));

            $config[] = $preview;
        }

        return $config;
    }

    /**
     * Allow to sort files.
     *
     * @return $this
     */
    public function sortable()
    {
        $this->fileActionSettings['showDrag'] = true;

        return $this;
    }

    /**
     * @param string $options
     */
    protected function setupScripts($options)
    {
        $this->script = <<<EOT
$("input{$this->getElementClassSelector()}").fileinput({$options});
EOT;

        if ($this->fileActionSettings['showRemove']) {
            $text = [
                'title'   => trans('admin.delete_confirm'),
                'confirm' => trans('admin.confirm'),
                'cancel'  => trans('admin.cancel'),
            ];

            $this->script .= <<<EOT
$("input{$this->getElementClassSelector()}").on('filebeforedelete', function() {
    
    return new Promise(function(resolve, reject) {
    
        var remove = resolve;
    
        swal({
            title: "{$text['title']}",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "{$text['confirm']}",
            showLoaderOnConfirm: true,
            cancelButtonText: "{$text['cancel']}",
            preConfirm: function() {
                return new Promise(function(resolve) {
                    resolve(remove());
                });
            }
        });
    });
});
EOT;
        }

        if ($this->fileActionSettings['showDrag']) {
            $this->addVariables([
                'sortable'  => true,
                'sort_flag' => static::FILE_SORT_FLAG,
            ]);

            $this->script .= <<<EOT
$("input{$this->getElementClassSelector()}").on('filesorted', function(event, params) {
    
    var order = [];
    
    params.stack.forEach(function (item) {
        order.push(item.key);
    });
    
    $("input{$this->getElementClassSelector()}_sort").val(order);
});
EOT;
        }
    }

    /**
     * Render file upload field.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        $this->attribute('multiple', true);

        $this->setupDefaultOptions();

        if (!empty($this->value)) {
            $this->options(['initialPreview' => $this->preview()]);
            $this->setupPreviewOptions();
        }

        $options = json_encode($this->options);

        $this->setupScripts($options);

        return parent::render();
    }

    /**
     * Destroy original files.
     *
     * @param string $key
     *
     * @return array.
     */
    public function destroy($key)
    {
        $files = $this->original ?: [];

        $file = Arr::get($files, $key);

        if (!$this->retainable && $this->storage->exists($file)) {
            $this->storage->delete($file);
        }

        unset($files[$key]);

        return $files;
    }
}
