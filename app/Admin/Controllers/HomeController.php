<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderStatistics;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Echarts\Echarts;
use Encore\Admin\Widgets\Box;
use Illuminate\Support\Arr;

class HomeController extends Controller
{

    public function index(Content $content)
    {
        // 一周前的日期
        $daytime = date("Y-m-d", strtotime("-1 week"));
        // 查询最新7天数据
        $orderSta = OrderStatistics::where('count_day', '>', $daytime)->orderBy('count_day', 'asc')->take(7)->get()->toArray();
        // bindData
        $head = [
            'count_day' => '日期',
            'count_ord' => '当日总订单数',
            'count_pd' => '当日售出商品数',
            'count_money' => '当日总收入',
        ];
        $echarts = (new Echarts('近七日', '销售数据'))
            ->setData($orderSta)
            ->bindLegend($head);

        return $content
            ->header('首页')
            ->description('控制中心...')
            ->row(self::title())
            ->body(new Box('销售数据', $echarts))
            ->row(function (Row $row) {
                $row->column(4, function (Column $column) {
                    $column->append(self::environment());
                });
            });
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function title()
    {
        return view('admin.dashboard.title');
    }

    public static function environment()
    {
        $envs = [
            ['name' => 'PHP 版本', 'value' => 'PHP/' . PHP_VERSION],
            ['name' => 'Laravel内核版本', 'value' => app()->version()],
            ['name' => 'CGI', 'value' => php_sapi_name()],
            ['name' => '服务器名称', 'value' => php_uname()],
            ['name' => '网页服务器', 'value' => Arr::get($_SERVER, 'SERVER_SOFTWARE')],

            ['name' => '缓存配置', 'value' => config('cache.default')],
            ['name' => 'Session 配置', 'value' => config('session.driver')],
            ['name' => '消息队列配置', 'value' => config('queue.default')],

            ['name' => '时区	', 'value' => config('app.timezone')],
            ['name' => 'Locale', 'value' => config('app.locale')],
            ['name' => 'Env', 'value' => config('app.env')],
            ['name' => 'URL', 'value' => config('app.url')],
        ];
        return view('admin.dashboard.environment', compact('envs'));
    }

}
