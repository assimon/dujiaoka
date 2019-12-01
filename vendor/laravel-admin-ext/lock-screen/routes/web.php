<?php

use Encore\Admin\LockScreen\Http\Controllers\LockScreenController;

Route::get('auth/lock', LockScreenController::class.'@lock')->name('laravel-admin-lock');
Route::post('auth/unlock', LockScreenController::class.'@unlock')->name('laravel-admin-unlock');