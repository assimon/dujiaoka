<?php

namespace Encore\Admin\LockScreen;

use Encore\Admin\Extension;

class LockScreen extends Extension
{
    const LOCK_KEY = 'laravel-admin-lock';

    public $name = 'lock-screen';

    public $views = __DIR__.'/../resources/views';

    public static function link()
    {
        $url = route('laravel-admin-lock');

        return <<<HTML
<li>
    <a href="{$url}">
      <i class="fa fa-lock"></i>
    </a>
</li>
HTML;

    }
}