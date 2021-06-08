<?php

namespace App\Admin\Controllers;

use App\Admin\Charts\DashBoard;
use App\Admin\Charts\PayoutRateCard;
use App\Admin\Charts\PopularGoodsCard;
use App\Admin\Charts\SalesCard;
use App\Admin\Charts\SuccessOrderCard;
use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class HomeController extends Controller
{

    public function index(Content $content)
    {
        return $content
            ->header(admin_trans('dujiaoka.dashboard'))
            ->description(admin_trans('dujiaoka.dashboard_description'))
            ->body(function (Row $row) {
                $row->column(6, function (Column $column) {
                    $column->row(self::title());
                    $column->row(new DashBoard());
                });

                $row->column(6, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(6, new SuccessOrderCard());
                        $row->column(6, new PayoutRateCard());
                    });

                    $column->row(new SalesCard());
                });
            });
    }

    public static function title()
    {
        return view('admin.dashboard.title');
    }
}
