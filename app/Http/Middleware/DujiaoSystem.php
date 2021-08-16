<?php

namespace App\Http\Middleware;

use Closure;
use Dcat\Admin\AdminServiceProvider;

class DujiaoSystem
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
        // 检测https
        if ($request->getScheme() == 'https') {
            $httpsConfig = [
                'https' => true
            ];
            config([
                'admin'  =>  array_merge(config('admin'), $httpsConfig)
            ]);
            (new AdminServiceProvider(app()))->register();
        }
        return $next($request);
    }
}
