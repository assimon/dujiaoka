<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$routesDir = ['common'];

foreach ($routesDir as $dir) {
    // 加载所有分类路由
    foreach (glob(__DIR__ . '/' . $dir . '/*.php') as $routerFile) {
        require_once $routerFile;
    }
}
