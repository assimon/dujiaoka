<?php
/**
 * The file was created by Assimon.
 *
 * @author    assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link      http://utf8.hk/
 */

namespace App\Admin\Charts;


use App\Models\Order;
use Dcat\Admin\Widgets\Metrics\RadialBar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashBoard extends RadialBar
{

    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $this->title(admin_trans('dujiaoka.sales_data'));
        $this->height(400);
        $this->chartHeight(300);
        $this->chartLabels(admin_trans('dujiaoka.order_success_rate'));
        $this->dropdown([
            'today' => admin_trans('dujiaoka.last_today'),
            'seven' => admin_trans('dujiaoka.last_seven_days'),
            'month' => admin_trans('dujiaoka.last_month'),
            'year' => admin_trans('dujiaoka.last_year'),
        ]);
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        $endTime = Carbon::now();
        switch ($request->get('option')) {
            case 'seven':
                $startTime = Carbon::now()->subDays(7);
                break;
            case 'month':
                $startTime = Carbon::now()->subDays(30);
                break;
            case 'year':
                $startTime = Carbon::now()->subDays(365);
                break;
            case 'today':
            default:
                $startTime = Carbon::today();
        }
        // 分组查询
        $orderGroup = Order::query()
            ->where('created_at', '>=', $startTime)
            ->where('created_at', '<=', $endTime)
            ->select('status', DB::raw('count(id) as num'))
            ->groupBy('status')
            ->pluck('num', 'status')
            ->toArray();
        $pending = $orderGroup[Order::STATUS_PENDING] ?? 0;
        $processing = $orderGroup[Order::STATUS_PROCESSING] ?? 0;
        $completed = $orderGroup[Order::STATUS_COMPLETED] ?? 0;
        $failure = $orderGroup[Order::STATUS_FAILURE] ?? 0;
        $abnormal = $orderGroup[Order::STATUS_ABNORMAL] ?? 0;
        $orderCount = array_sum($orderGroup);
        if ($orderCount == 0) {
            $successRate = 0;
        } else {
            $rate = bcdiv($completed, $orderCount, 2);
            $successRate = bcmul($rate, 100);
        }
        // 订单数
        $this->withOrderCount($orderCount);
        // 卡片底部
        $this->withFooter($pending, $processing, $completed, $failure, $abnormal);
        // 图表数据
        $this->withChart($successRate);
    }

    /**
     * 订单总数
     *
     * @param $count
     * @return DashBoard
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function withOrderCount($count)
    {
        $title = admin_trans('dujiaoka.order_count_number');
        return $this->content(
            <<<HTML
<div class="d-flex flex-column flex-wrap text-center">
    <h1 class="font-lg-2 mt-2 mb-0">{$count}</h1>
    <small>{$title}</small>
</div>
HTML
        );
    }

    /**
     * 成交率.
     *
     * @param int $data
     *
     * @return $this
     */
    public function withChart(int $data)
    {
        return $this->chart([
            'series' => [$data],
        ]);
    }

    /**
     * @param $pending
     * @param $processing
     * @param $completed
     * @param $failure
     * @param $abnormal
     * @return DashBoard
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function withFooter($pending, $processing, $completed, $failure, $abnormal)
    {
        $statusPendingTitle = admin_trans('dujiaoka.status_pending_number');
        $statusProcessingNumber = admin_trans('dujiaoka.status_processing_number');
        $statusCompletedNumber = admin_trans('dujiaoka.status_completed_number');
        $statusFailureNumber = admin_trans('dujiaoka.status_failure_number');
        $statusAbnormalNumber = admin_trans('dujiaoka.status_abnormal_number');
        return $this->footer(
            <<<HTML
<div class="d-flex justify-content-between p-1" style="padding-top: 0!important;">
    <div class="text-center">
        <p>{$statusPendingTitle}</p>
        <span class="font-lg-1">{$pending}</span>
    </div>
    <div class="text-center">
        <p>{$statusProcessingNumber}</p>
        <span class="font-lg-1">{$processing}</span>
    </div>
    <div class="text-center">
        <p>{$statusCompletedNumber}</p>
        <span class="font-lg-1">{$completed}</span>
    </div>
    <div class="text-center">
        <p>{$statusFailureNumber}</p>
        <span class="font-lg-1">{$failure}</span>
    </div>
    <div class="text-center">
        <p>{$statusAbnormalNumber}</p>
        <span class="font-lg-1">{$abnormal}</span>
    </div>
</div>
HTML
        );
    }
}
