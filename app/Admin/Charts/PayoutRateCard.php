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
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Donut;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PayoutRateCard extends Donut
{

    protected $labels;

    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $this->labels = [admin_trans('dujiaoka.payment_successful_number'), admin_trans('dujiaoka.unpaid_number')];
        $color = Admin::color();
        $colors = [$color->primary(), $color->alpha('blue2', 0.5)];

        $this->title(admin_trans('dujiaoka.payment_chart'));
        $this->chartLabels($this->labels);
        // 设置图表颜色
        $this->chartColors($colors);
        $this->dropdown([
            'seven' => admin_trans('dujiaoka.last_seven_days'),
            'today' => admin_trans('dujiaoka.last_today'),
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
                $startTime = Carbon::today();
                break;
            default:
                $startTime =  Carbon::now()->subDays(7);
        }
        // 成功的数量
        $success = Order::query()
            ->where('created_at', '>=', $startTime)
            ->where('created_at', '<=', $endTime)
            ->where('status', '>', Order::STATUS_WAIT_PAY)
            ->count();
        // 待支付的数量
        $unpaid = Order::query()
            ->where('created_at', '>=', $startTime)
            ->where('created_at', '<=', $endTime)
            ->where('status', '<=', Order::STATUS_WAIT_PAY)
            ->count();
        $this->withContent($success, $unpaid);
        // 图表数据
        $this->withChart([$success, $unpaid]);
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
            'series' => $data
        ]);
    }

    /**
     * 设置卡片头部内容.
     *
     * @param mixed $success
     * @param mixed $unpaid
     *
     * @return $this
     */
    protected function withContent($success, $unpaid)
    {
        $blue = Admin::color()->alpha('blue2', 0.5);

        $style = 'margin-bottom: 8px';
        $labelWidth = 120;

        return $this->content(
            <<<HTML
<div class="d-flex pl-1 pr-1 pt-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle text-primary"></i> {$this->labels[0]}
    </div>
    <div>{$success}</div>
</div>
<div class="d-flex pl-1 pr-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle" style="color: $blue"></i> {$this->labels[1]}
    </div>
    <div>{$unpaid}</div>
</div>
HTML
        );
    }

}
