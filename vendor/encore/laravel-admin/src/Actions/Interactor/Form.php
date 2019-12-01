<?php

namespace Encore\Admin\Actions\Interactor;

use Encore\Admin\Actions\RowAction;
use Encore\Admin\Admin;
use Encore\Admin\Form\Field;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Symfony\Component\DomCrawler\Crawler;

class Form extends Interactor
{
    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var string
     */
    protected $modalId;

    /**
     * @param string $label
     *
     * @return array
     */
    protected function formatLabel($label)
    {
        return array_filter((array) $label);
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\Text
     */
    public function text($column, $label = '')
    {
        $field = new Field\Text($column, $this->formatLabel($label));

        $this->addField($field);

        return $field;
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\Text
     */
    public function email($column, $label = '')
    {
        $field = new Field\Email($column, $this->formatLabel($label));

        $this->addField($field)->setView('admin::actions.form.text');

        return $field->inputmask(['alias' => 'email']);
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\Text
     */
    public function integer($column, $label = '')
    {
        return $this->text($column, $label)
            ->width('200px')
            ->inputmask(['alias' => 'integer']);
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\Text
     */
    public function ip($column, $label = '')
    {
        return $this->text($column, $label)
            ->width('200px')
            ->inputmask(['alias' => 'ip']);
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\Text
     */
    public function url($column, $label = '')
    {
        return $this->text($column, $label)
            ->inputmask(['alias' => 'url'])
            ->width('200px');
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\Text
     */
    public function password($column, $label = '')
    {
        return $this->text($column, $label)
            ->attribute('type', 'password');
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\Text
     */
    public function mobile($column, $label = '')
    {
        return $this->text($column, $label)
            ->inputmask(['mask' => '99999999999'])
            ->width('100px');
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\Textarea
     */
    public function textarea($column, $label = '')
    {
        $field = new Field\Textarea($column, $this->formatLabel($label));

        $this->addField($field);

        return $field;
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\Select
     */
    public function select($column, $label = '')
    {
        $field = new Field\Select($column, $this->formatLabel($label));

        $this->addField($field);

        return $field;
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\MultipleSelect
     */
    public function multipleSelect($column, $label = '')
    {
        $field = new Field\MultipleSelect($column, $this->formatLabel($label));

        $this->addField($field);

        return $field;
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\Checkbox
     */
    public function checkbox($column, $label = '')
    {
        $field = new Field\Checkbox($column, $this->formatLabel($label));

        $this->addField($field);

        return $field;
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\Radio
     */
    public function radio($column, $label = '')
    {
        $field = new Field\Radio($column, $this->formatLabel($label));

        $this->addField($field);

        return $field;
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\File
     */
    public function file($column, $label = '')
    {
        $field = new Field\File($column, $this->formatLabel($label));

        $this->addField($field);

        return $field;
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\Image
     */
    public function image($column, $label = '')
    {
        $field = new Field\Image($column, $this->formatLabel($label));

        $this->addField($field)->setView('admin::actions.form.file');

        return $field;
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\Date
     */
    public function date($column, $label = '')
    {
        $field = new Field\Date($column, $this->formatLabel($label));

        $this->addField($field);

        return $field;
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\Date
     */
    public function datetime($column, $label = '')
    {
        return $this->date($column, $label)->format('YYYY-MM-DD HH:mm:ss');
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\Date
     */
    public function time($column, $label = '')
    {
        return $this->date($column, $label)->format('HH:mm:ss');
    }

    /**
     * @param string $column
     * @param string $label
     *
     * @return Field\Hidden
     */
    public function hidden($column, $label = '')
    {
        $field = new Field\Hidden($column, $this->formatLabel($label));

        $this->addField($field);

        return $field;
    }

    /**
     * @param string $content
     * @param string $selector
     *
     * @return string
     */
    public function addElementAttr($content, $selector)
    {
        $crawler = new Crawler($content);

        $node = $crawler->filter($selector)->getNode(0);
        $node->setAttribute('modal', $this->getModalId());

        return $crawler->children()->html();
    }

    /**
     * @param Field $field
     *
     * @return Field
     */
    protected function addField(Field $field)
    {
        $elementClass = array_merge(['action'], $field->getElementClass());

        $field->addElementClass($elementClass);

        $field->setView($this->resolveView(get_class($field)));

        array_push($this->fields, $field);

        return $field;
    }

    /**
     * @param Request $request
     *
     * @throws ValidationException
     * @throws \Exception
     *
     * @return void
     */
    public function validate(Request $request)
    {
        if ($this->action instanceof RowAction) {
            call_user_func([$this->action, 'form'], $this->action->getRow());
        } else {
            call_user_func([$this->action, 'form']);
        }

        $failedValidators = [];

        /** @var Field $field */
        foreach ($this->fields as $field) {
            if (!$validator = $field->getValidator($request->all())) {
                continue;
            }

            if (($validator instanceof Validator) && !$validator->passes()) {
                $failedValidators[] = $validator;
            }
        }

        $message = $this->mergeValidationMessages($failedValidators);

        if ($message->any()) {
            throw ValidationException::withMessages($message->toArray());
        }
    }

    /**
     * Merge validation messages from input validators.
     *
     * @param \Illuminate\Validation\Validator[] $validators
     *
     * @return MessageBag
     */
    protected function mergeValidationMessages($validators)
    {
        $messageBag = new MessageBag();

        foreach ($validators as $validator) {
            $messageBag = $messageBag->merge($validator->messages());
        }

        return $messageBag;
    }

    /**
     * @param string $class
     *
     * @return string
     */
    protected function resolveView($class)
    {
        $path = explode('\\', $class);

        $name = strtolower(array_pop($path));

        return "admin::actions.form.{$name}";
    }

    /**
     * @return void
     */
    public function addModalHtml()
    {
        $data = [
            'fields'   => $this->fields,
            'title'    => $this->action->name(),
            'modal_id' => $this->getModalId(),
        ];

        $modal = view('admin::actions.form.modal', $data)->render();

        Admin::html($modal);
    }

    /**
     * @return string
     */
    public function getModalId()
    {
        if (!$this->modalId) {
            if ($this->action instanceof RowAction) {
                $this->modalId = uniqid('row-action-modal-').mt_rand(1000, 9999);
            } else {
                $this->modalId = strtolower(str_replace('\\', '-', get_class($this->action)));
            }
        }

        return $this->modalId;
    }

    /**
     * @return void
     */
    public function addScript()
    {
        $this->action->attribute('modal', $this->getModalId());

        $parameters = json_encode($this->action->parameters());

        $script = <<<SCRIPT

(function ($) {
    $('{$this->action->selector($this->action->selectorPrefix)}').off('{$this->action->event}').on('{$this->action->event}', function() {
        var data = $(this).data();
        var target = $(this);
        var modalId = $(this).attr('modal');
        Object.assign(data, {$parameters});
        {$this->action->actionScript()}
        $('#'+modalId).modal('show');
        $('#'+modalId+' form').off('submit').on('submit', function (e) {
            e.preventDefault();
            var form = this;
            {$this->buildActionPromise()}
            {$this->action->handleActionPromise()}
        });
    });
})(jQuery);

SCRIPT;

        Admin::script($script);
    }

    /**
     * @throws \Exception
     *
     * @return string
     */
    protected function buildActionPromise()
    {
        if ($this->action instanceof RowAction) {
            call_user_func([$this->action, 'form'], $this->action->getRow());
        } else {
            call_user_func([$this->action, 'form']);
        }

        $this->addModalHtml();

        return <<<SCRIPT
            var process = new Promise(function (resolve,reject) {
                Object.assign(data, {
                    _token: $.admin.token,
                    _action: '{$this->action->getCalledClass()}',
                });
                
                var formData = new FormData(form);
                for (var key in data) {
                    formData.append(key, data[key]);
                }
                
                $.ajax({
                    method: '{$this->action->getMethod()}',
                    url: '{$this->action->getHandleRoute()}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        resolve([data, target]);
                        if (data.status === true) {
                            $('#'+modalId).modal('hide');
                        }
                    },
                    error:function(request){
                        reject(request);
                    }
                });
            });
SCRIPT;
    }
}
