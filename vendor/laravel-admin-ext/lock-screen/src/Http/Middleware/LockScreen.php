<?php

namespace Encore\Admin\LockScreen\Http\Middleware;

use Encore\Admin\LockScreen\LockScreen as Extension;
use Illuminate\Http\Request;

class LockScreen
{
    protected $except = [
        'auth/login',
        'auth/logout',
        'auth/lock',
        'auth/unlock',
    ];

    public function handle(Request $request, \Closure $next)
    {
        if ($this->shouldPassThrough($request)) {
            return $next($request);
        }

        if ($request->session()->has(Extension::LOCK_KEY)) {
            return redirect()->route('laravel-admin-lock');
        }

        return $next($request);
    }

    protected function shouldPassThrough(Request $request)
    {
        foreach ($this->except as $except) {
            $except = trim(admin_base_path($except), '/');

            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }
}