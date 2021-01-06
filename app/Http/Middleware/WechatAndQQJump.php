<?php

namespace App\Http\Middleware;

use Closure;

class WechatAndQQJump
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
        $userAgent = $request->header('user-agent');
        $nowUri = site_url() . $request->path();
        $tplPath = 'common/wechatqqjump';
        if (
            strpos($userAgent, 'QQ/')
            ||
            strpos($userAgent, 'MicroMessenger') !== false
        ) {
            return response()->view($tplPath, ['nowUri' => $nowUri]);
        }
        return $next($request);
    }
}
