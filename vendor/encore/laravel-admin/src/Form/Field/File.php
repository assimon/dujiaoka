<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Form\Field;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File extends Field
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

        if ($this->validator) {
            return $this->validator->call($this, $input);
        }

        /*
         * If has original value, means the form is in edit mode,
         * then remove required rule from rules.
         */
        if ($this->original()) {
            $this->removeRule('required');
        }

        /*
         * Make input data validatable if the column data is `null`.
         */
        if (Arr::has($input, $this->column) && is_null(Arr::get($input, $this->column))) {
            $input[$this->column] = '';
        }

        $rules = $attributes = [];

        if (!$fieldRules = $this->getRules()) {
            return false;
        }

        $rules[$this->column] = $fieldRules;
        $attributes[$this->column] = $this->label;

        return \validator($input, $rules, $this->getValidationMessages(), $attributes);
    }

    /**
     * Prepare for saving.
     *
     * @param UploadedFile|array $file
     *
     * @return mixed|string
     */
    public function prepare($file)
    {
        if (request()->has(static::FILE_DELETE_FLAG)) {
            return $this->destroy();
        }

        $this->name = $this->getStoreName($file);

        return $this->uploadAndDeleteOriginal($file);
    }

    /**
     * Upload file and delete original file.
     *
     * @param UploadedFile $file
     *
     * @return mixed
     */
    protected function uploadAndDeleteOriginal(UploadedFile $file)
    {
        $this->renameIfExists($file);

        $path = null;

        if (!is_null($this->storagePermission)) {
            $path = $this->storage->putFileAs($this->getDirectory(), $file, $this->name, $this->storagePermission);
        } else {
            $path = $this->storage->putFileAs($this->getDirectory(), $file, $this->name);
        }

        $this->destroy();

        return $path;
    }

    /**
     * Preview html for file-upload plugin.
     *
     * @return string
     */
    protected function preview()
    {
        return $this->objectUrl($this->value);
    }

    /**
     * Initialize the caption.
     *
     * @param string $caption
     *
     * @return string
     */
    protected function initialCaption($caption)
    {
        return basename($caption);
    }

    /**
     * @return array
     */
    protected function initialPreviewConfig()
    {
        $config = ['caption' => basename($this->value), 'key' => 0];

        $config = array_merge($config, $this->guessPreviewType($this->value));

        return [$config];
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
    }

    /**
     * Render file upload field.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        $this->options(['overwriteInitial' => true, 'msgPlaceholder' => trans('admin.choose_file')]);

        $this->setupDefaultOptions();

        if (!empty($this->value)) {
            $this->attribute('data-initial-preview', $this->preview());
            $this->attribute('data-initial-caption', $this->initialCaption($this->value));

            $this->setupPreviewOptions();
            /*
             * If has original value, means the form is in edit mode,
             * then remove required rule from rules.
             */
            unset($this->attributes['required']);
        }

        $options = json_encode_options($this->options);

        $this->setupScripts($options);

        return parent::render();
    }
}
