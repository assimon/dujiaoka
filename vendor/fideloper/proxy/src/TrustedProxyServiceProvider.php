<?php

namespace Fideloper\Proxy;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class TrustedProxyServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $source = realpath(__DIR__.'/../config/trustedproxy.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('trustedproxy.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('trustedproxy');
        }

        $this->mergeConfigFrom($source, 'trustedproxy');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
