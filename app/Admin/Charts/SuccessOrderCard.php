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
use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SuccessOrderCard extends Line
{

    /**
     * 初始化卡片内容
     *
     * @return void
     */
    protected function init()
    {
        parent::init();

        $this->title(admin_trans('dujiaoka.status_completed_number'));
        $this->dropdown([
            'seven' => admin_trans('dujiaoka.last_seven_days'),
            'today' => admin_trans('dujiaoka.last_today'),
            'month' => admin_trans('dujiaoka.last_month'),
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
            case 'today':
                $startTime = Carbon::today();
                break;
            default:
                $startTime =  Carbon::now()->subDays(7);
        }
        // 分组查询
        $orderGroup = Order::query()
            ->where('created_at', '>=', $startTime)
            ->where('created_at', '<=', $endTime)
            ->where('status', Order::STATUS_COMPLETED)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(id) as num'))
            ->groupBy('date')
            ->pluck('num')
            ->toArray();
        $successCount = array_sum($orderGroup);
        // 卡片内容
        $this->withContent($successCount);
        // 图表数据
        $this->withChart($orderGroup);
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     *
     * @return $this
     */
    public function withChart(array $data)
    {
        return $this->chart([
            'series' => [
                [
                    'name' => $this->title,
                    'data' => $data,
                ],
            ],
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-lg-1">{$content}</h2>
    <span class="mb-0 mr-1 text-80">{$this->title}</span>
</div>
HTML
        );
    }

}
