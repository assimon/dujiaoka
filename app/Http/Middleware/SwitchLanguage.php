<?php

namespace App\Http\Middleware;

use Closure;

class SwitchLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $langs = config('webset.langs') ?? 'zh-CN';//这里配置语言种类
        app()->setLocale($langs);
        return $next($request);
    }
}
