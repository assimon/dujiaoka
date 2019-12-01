<?php

use Encore\Admin\Widgets\Echarts\Http\Controllers\EchartsController;

Route::get('echarts', EchartsController::class.'@index');