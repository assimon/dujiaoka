<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderExpired implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务最大尝试次数。
     *
     * @var int
     */
    public $tries = 3;

    /**
     * 任务可以执行的最大秒数 (超时时间)。
     *
     * @var int
     */
    public $timeout = 20;

    /**
     * 订单号
     * @var string
     */
    private $orderSN;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $orderSN)
    {
        $this->orderSN = $orderSN;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 如果x分钟后还没支付就算过期
        $order = app('Service\OrderService')->detailOrderSN($this->orderSN);
        if ($order && $order->status == Order::STATUS_WAIT_PAY) {
            app('Service\OrderService')->expiredOrderSN($this->orderSN);
            // 回退优惠券
            CouponBack::dispatch($order);
        }
    }
}
