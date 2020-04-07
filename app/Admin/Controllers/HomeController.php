<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Echarts\Echarts;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index(Content $content)
    {
        $orders = Orders::where('created_at','<', Carbon::now())
            ->where('created_at','>', Carbon::today()->subDays(7))
            ->select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT("id") as order_num'),
                DB::raw('SUM(ord_price) as ord_price'),
            ])
            ->groupBy('date')
            ->get();
        $head = [
            'date' => '日期',
            'order_num' => '当日订单总数',
            'ord_price' => '当日总销售额',
        ];
        $echarts = (new Echarts('近七日', '销售数据'))
            ->setSeriesType('bar')
            ->setData($orders->toArray())
            ->bindLegend($head);
        return $content
            ->title('控制台首页')
            ->description('welcome to manager...')
            ->row(self::title())
            ->body(new Box('销售数据', $echarts))
            ->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    $column->append(self::environment());
                });
            });
    }


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
