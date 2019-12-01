<?php

namespace Encore\James;

use Encore\Admin\Admin;
use Encore\Admin\Extension;
use Illuminate\Support\Facades\Route;

class James extends Extension
{
    public static function boot(){
        static::registerRoutes();
        Admin::extend('login-captcha', __CLASS__);
    }

    protected static function registerRoutes(){
        parent::routes(function ($router) {
            $router->get('auth/login', 'Encore\James\JamesController@getLogin');
            $router->post('auth/login', 'Encore\James\JamesController@postLogin');
        });
    }

}