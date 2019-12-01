<?php

namespace Encore\Admin\Actions\Interactor;

use Encore\Admin\Admin;

class Dialog extends Interactor
{
    /**
     * @var bool
     */
    protected $uploadFile = false;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @param string $title
     * @param string $text
     * @param array  $options
     *
     * @return Dialog
     */
    public function success($title, $text = '', $options = [])
    {
        return $this->addSettings($title, __FUNCTION__, $text, $options);
    }

    /**
     * @param string $title
     * @param string $text
     * @param array  $options
     *
     * @return Dialog
     */
    public function error($title, $text = '', $options = [])
    {
        return $this->addSettings($title, __FUNCTION__, $text, $options);
    }

    /**
     * @param string $title
     * @param string $text
     * @param array  $options
     *
     * @return $this
     */
    public function warning($title, $text = '', $options = [])
    {
        return $this->addSettings($title, __FUNCTION__, $text, $options);
    }

    /**
     * @param string $title
     * @param string $text
     * @param array  $options
     *
     * @return Dialog
     */
    public function info($title, $text = '', $options = [])
    {
        return $this->addSettings($title, __FUNCTION__, $text, $options);
    }

    /**
     * @param string $title
     * @param string $text
     * @param array  $options
     *
     * @return Dialog
     */
    public function question($title, $text = '', $options = [])
    {
        return $this->addSettings($title, __FUNCTION__, $text, $options);
    }

    /**
     * @param string $title
     * @param string $text
     * @param array  $options
     *
     * @return Dialog
     */
    public function confirm($title, $text = '', $options = [])
    {
        return $this->addSettings($title, 'question', $text, $options);
    }

    /**
     * @param string $title
     * @param string $type
     * @param string $text
     * @param array  $options
     *
     * @return $this
     */
    protected function addSettings($title, $type, $text = '', $options = [])
    {
        $this->settings = array_merge(
            compact('title', 'text', 'type'),
            $options
        );

        return $this;
    }

    /**
     * @return array
     */
    protected function defaultSettings()
    {
        $trans = [
            'cancel' => trans('admin.cancel'),
            'submit' => trans('admin.submit'),
        ];

        return [
            'type'                => 'question',
            'showCancelButton'    => true,
            'showLoaderOnConfirm' => true,
            'confirmButtonText'   => $trans['submit'],
            'cancelButtonText'    => $trans['cancel'],
        ];
    }

    /**
     * @return string
     */
    protected function formatSettings()
    {
        if (empty($this->settings)) {
            return '';
        }

        $settings = array_merge($this->defaultSettings(), $this->settings);

        return trim(substr(json_encode($settings, JSON_PRETTY_PRINT), 1, -1));
    }

    /**
     * @return void
     */
    public function addScript()
    {
        $parameters = json_encode($this->action->parameters());

        $script = <<<SCRIPT

(function ($) {
    $('{$this->action->selector($this->action->selectorPrefix)}').off('{$this->action->event}').on('{$this->action->event}', function() {
        var data = $(this).data();
        var target = $(this);
        Object.assign(data, {$parameters});
        {$this->action->actionScript()}
        {$this->buildActionPromise()}
        {$this->action->handleActionPromise()}
    });
})(jQuery);

SCRIPT;

        Admin::script($script);
    }

    /**
     * @return string
     */
    protected function buildActionPromise()
    {
        call_user_func([$this->action, 'dialog']);

        $route = $this->action->getHandleRoute();
        $settings = $this->formatSettings();
        $calledClass = $this->action->getCalledClass();

        if ($this->uploadFile) {
            return $this->buildUploadFileActionPromise($settings, $calledClass, $route);
        }

        return <<<PROMISE
        var process = $.admin.swal({
            {$settings},
            preConfirm: function(input) {
                return new Promise(function(resolve, reject) {
                    Object.assign(data, {
                        _token: $.admin.token,
                        _action: '$calledClass',
                        _input: input,
                    });

                    $.ajax({
                        method: '{$this->action->getMethod()}',
                        url: '$route',
                        data: data,
                        success: function (data) {
                            resolve(data);
                        },
                        error:function(request){
                            reject(request);
                        }
                    });
                });
            }
        }).then(function(result) {
            if (typeof result.dismiss !== 'undefined') {
                return Promise.reject();
            }
            
            if (typeof result.status === "boolean") {
                var response = result;
            } else {
                var response = result.value;
            }

            return [response, target];
        });
PROMISE;
    }

    /**
     * @param string $settings
     * @param string $calledClass
     * @param string $route
     *
     * @return string
     */
    protected function buildUploadFileActionPromise($settings, $calledClass, $route)
    {
        return <<<PROMISE
var process = $.admin.swal({
    {$settings}
}).then(function (file) {
    return new Promise(function (resolve) {
        var data = {
            _token: $.admin.token,
            _action: '$calledClass',
        };

        var formData = new FormData();
        for ( var key in data ) {
            formData.append(key, data[key]);
        }

        formData.append('_input', file.value, file.value.name);

        $.ajax({
            url: '{$route}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            success: function (data) {
                resolve([response, target]);
            },
            error:function(request){
                reject(request);
            }
        });
    });
})
PROMISE;
    }
}
