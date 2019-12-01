<?php

namespace Encore\Admin\Widgets\Echarts;

use Encore\Admin\Admin;
use Illuminate\Support\ServiceProvider;

class EchartsServiceProvider extends ServiceProvider
{

    /**
     * {@inheritdoc}
     */
    public function boot(Echarts $extension)
    {
        if (!Echarts::boot()) {
            return;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'echarts');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {

            $this->publishes(
                [$assets => public_path('vendor/laravel-admin-ext/echarts')],
                'echarts'
            );

            $this->publishes([$extension->config => config_path('echarts.php')], 'echarts');

            $this->publishes([$extension->views => resource_path('views/vendor/admin/echarts')], 'echarts-view');
        }


        $this->app->booted(function () {
            Echarts::routes(__DIR__ . '/../routes/web.php');
        });

        Admin::booting(function () {
            Admin::headerJs('vendor/laravel-admin-ext/echarts/echarts.min.js');
            Admin::headerJs('vendor/laravel-admin-ext/echarts/draw.js');
        });
    }
}