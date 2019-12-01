<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Encore\Admin\Config\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if (class_exists(Config::class)) {
            Config::load();
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
