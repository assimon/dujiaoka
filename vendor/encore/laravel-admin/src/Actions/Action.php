<?php

namespace Encore\Admin\Actions;

use Encore\Admin\Admin;
use Encore\Admin\Form\Field;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

/**
 * @method $this success($title, $text = '', $options = [])
 * @method $this error($title, $text = '', $options = [])
 * @method $this warning($title, $text = '', $options = [])
 * @method $this info($title, $text = '', $options = [])
 * @method $this question($title, $text = '', $options = [])
 * @method $this confirm($title, $text = '', $options = [])
 * @method Field\Text           text($column, $label = '')
 * @method Field\Email          email($column, $label = '')
 * @method Field\Integer        integer($column, $label = '')
 * @method Field\Ip             ip($column, $label = '')
 * @method Field\Url            url($column, $label = '')
 * @method Field\Password       password($column, $label = '')
 * @method Field\Mobile         mobile($column, $label = '')
 * @method Field\Textarea       textarea($column, $label = '')
 * @method Field\Select         select($column, $label = '')
 * @method Field\MultipleSelect multipleSelect($column, $label = '')
 * @method Field\Checkbox       checkbox($column, $label = '')
 * @method Field\Radio          radio($column, $label = '')
 * @method Field\File           file($column, $label = '')
 * @method Field\Image          image($column, $label = '')
 * @method Field\Date           date($column, $label = '')
 * @method Field\Datetime       datetime($column, $label = '')
 * @method Field\Time           time($column, $label = '')
 * @method Field\Hidden         hidden($column, $label = '')
 */
abstract class Action implements Renderable
{
    use Authorizable;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var string
     */
    protected $selector;

    /**
     * @var string
     */
    public $event = 'click';

    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var string
     */
    public $selectorPrefix = '.action-';

    /**
     * @var Interactor\Interactor
     */
    protected $interactor;

    /**
     * @var array
     */
    protected static $selectors = [];

    /**
     * @var string
     */
    public $name;

    /**
     * Action constructor.
     */
    public function __construct()
    {
        $this->initInteractor();
    }

    /**
     * @throws \Exception
     */
    protected function initInteractor()
    {
        if ($hasForm = method_exists($this, 'form')) {
            $this->interactor = new Interactor\Form($this);
        }

        if ($hasDialog = method_exists($this, 'dialog')) {
            $this->interactor = new Interactor\Dialog($this);
        }

        if ($hasForm && $hasDialog) {
            throw new \Exception('Can only define one of the methods in `form` and `dialog`');
        }
    }

    /**
     * Get batch action title.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @param string $prefix
     *
     * @return mixed|string
     */
    public function selector($prefix)
    {
        if (is_null($this->selector)) {
            return static::makeSelector(get_called_class(), $prefix);
        }

        return $this->selector;
    }

    /**
     * @param string $class
     * @param string $prefix
     *
     * @return string
     */
    public static function makeSelector($class, $prefix)
    {
        if (!isset(static::$selectors[$class])) {
            static::$selectors[$class] = uniqid($prefix).mt_rand(1000, 9999);
        }

        return static::$selectors[$class];
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function attribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Format the field attributes.
     *
     * @return string
     */
    protected function formatAttributes()
    {
        $html = [];

        foreach ($this->attributes as $name => $value) {
            $html[] = $name.'="'.e($value).'"';
        }

        return implode(' ', $html);
    }

    /**
     * @return string
     */
    protected function getElementClass()
    {
        return ltrim($this->selector($this->selectorPrefix), '.');
    }

    /**
     * @return Response
     */
    public function response()
    {
        if (is_null($this->response)) {
            $this->response = new Response();
        }

        if (method_exists($this, 'dialog')) {
            $this->response->swal();
        } else {
            $this->response->toastr();
        }

        return $this->response;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getCalledClass()
    {
        return str_replace('\\', '_', get_called_class());
    }

    /**
     * @return string
     */
    public function getHandleRoute()
    {
        return admin_url('_handle_action_');
    }

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return '';
    }

    /**
     * @return array
     */
    public function parameters()
    {
        return [];
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function validate(Request $request)
    {
        if ($this->interactor instanceof Interactor\Form) {
            $this->interactor->validate($request);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    protected function addScript()
    {
        if (!is_null($this->interactor)) {
            return $this->interactor->addScript();
        }

        $parameters = json_encode($this->parameters());

        $script = <<<SCRIPT

(function ($) {
    $('{$this->selector($this->selectorPrefix)}').off('{$this->event}').on('{$this->event}', function() {
        var data = $(this).data();
        var target = $(this);
        Object.assign(data, {$parameters});
        {$this->actionScript()}
        {$this->buildActionPromise()}
        {$this->handleActionPromise()}
    });
})(jQuery);

SCRIPT;

        Admin::script($script);
    }

    /**
     * @return string
     */
    public function actionScript()
    {
        return '';
    }

    /**
     * @return string
     */
    protected function buildActionPromise()
    {
        return <<<SCRIPT
        var process = new Promise(function (resolve,reject) {
            
            Object.assign(data, {
                _token: $.admin.token,
                _action: '{$this->getCalledClass()}',
            });
        
            $.ajax({
                method: '{$this->method}',
                url: '{$this->getHandleRoute()}',
                data: data,
                success: function (data) {
                    resolve([data, target]);
                },
                error:function(request){
                    reject(request);
                }
            });
        });

SCRIPT;
    }

    /**
     * @return string
     */
    public function handleActionPromise()
    {
        $resolve = <<<'SCRIPT'
var actionResolver = function (data) {

            var response = data[0];
            var target   = data[1];
                
            if (typeof response !== 'object') {
                return $.admin.swal({type: 'error', title: 'Oops!'});
            }
            
            var then = function (then) {
                if (then.action == 'refresh') {
                    $.admin.reload();
                }
                
                if (then.action == 'download') {
                    window.open(then.value, '_blank');
                }
                
                if (then.action == 'redirect') {
                    $.admin.redirect(then.value);
                }
                
                if (then.action == 'location') {
                    window.location = then.value;
                }
            };
            
            if (typeof response.html === 'string') {
                target.html(response.html);
            }

            if (typeof response.swal === 'object') {
                $.admin.swal(response.swal);
            }
            
            if (typeof response.toastr === 'object' && response.toastr.type) {
                $.admin.toastr[response.toastr.type](response.toastr.content, '', response.toastr.options);
            }
            
            if (response.then) {
              then(response.then);
            }
        };
        
        var actionCatcher = function (request) {
            if (request && typeof request.responseJSON === 'object') {
                $.admin.toastr.error(request.responseJSON.message, '', {positionClass:"toast-bottom-center", timeOut: 10000}).css("width","500px")
            }
        };
SCRIPT;

        Admin::script($resolve);

        return <<<'SCRIPT'
process.then(actionResolver).catch(actionCatcher);
SCRIPT;
    }

    /**
     * @param string $method
     * @param array  $arguments
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function __call($method, $arguments = [])
    {
        if (in_array($method, Interactor\Interactor::$elements)) {
            return $this->interactor->{$method}(...$arguments);
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }

    /**
     * @return string
     */
    public function html()
    {
    }

    /**
     * @return mixed
     */
    public function render()
    {
        $this->addScript();

        $content = $this->html();

        if ($content && $this->interactor instanceof Interactor\Form) {
            return $this->interactor->addElementAttr($content, $this->selector);
        }

        return $this->html();
    }
}
