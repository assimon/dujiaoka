<?php

namespace Encore\Admin\Grid\Displayers;

class Modal extends AbstractDisplayer
{
    public function display($callback = null)
    {
        if (func_num_args() == 2) {
            list($title, $callback) = func_get_args();
        } elseif (func_num_args() == 1) {
            $title = $this->trans('title');
        }

        $callback = $callback->bindTo($this->row);

        $html = call_user_func_array($callback, [$this->row]);

        $key = $this->getKey().'-'.str_replace('.', '_', $this->getColumn()->getName());

        return <<<EOT
<span class="grid-expand" data-toggle="modal" data-target="#grid-modal-{$key}">
   <a href="javascript:void(0)"><i class="fa fa-clone"></i>&nbsp;&nbsp;{$this->value}</a>
</span>

<div class="modal" id="grid-modal-{$key}" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{$title}</h4>
      </div>
      <div class="modal-body">
        {$html}
      </div>
    </div>
  </div>
</div>

EOT;
    }
}
