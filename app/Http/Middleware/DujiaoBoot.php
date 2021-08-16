<?php

namespace App\Http\Middleware;

use App\Models\BaseModel;
use Closure;
use Germey\Geetest\GeetestServiceProvider;

class DujiaoBoot
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
        // 安装检查
        $installLock = base_path() . DIRECTORY_SEPARATOR . 'install.lock';
        if (!file_exists($installLock)) {
            return redirect(url('install'));
        }
        // 浏览器检测
        $userAgent = $request->header('user-agent');
        $nowUri = site_url() . $request->path();
        $tplPath = 'common/notencent';
        if (
            (strpos($userAgent, 'QQ/')
            ||
            strpos($userAgent, 'MicroMessenger') !== false)
            &&
            dujiaoka_config_get('is_open_anti_red', BaseModel::STATUS_OPEN) == BaseModel::STATUS_OPEN
        ) {
            return response()->view($tplPath, ['nowUri' => $nowUri]);
        }
        // 语言检测
        $lang = dujiaoka_config_get('language', 'zh_CN');
        app()->setLocale($lang);
        // 极验
        $geetest = dujiaoka_config_get('is_open_geetest', BaseModel::STATUS_CLOSE);
        if ($geetest == BaseModel::STATUS_OPEN) {
            $geetestConfig = [
                'key' => dujiaoka_config_get('geetest_key'),
                'id' => dujiaoka_config_get('geetest_id'),
                'lang' => $lang
            ];
            // 覆盖 配置
            config([
                'geetest'  =>  array_merge(config('mail'), $geetestConfig)
            ]);
            // 重新注册服务
            (new GeetestServiceProvider(app()))->register();
        }
        return $next($request);
    }
}
