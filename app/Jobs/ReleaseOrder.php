<?php

namespace App\Jobs;

use App\Models\Coupons;
use App\Models\Products;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class ReleaseOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务最大尝试次数。
     *
     * @var int
     */
    public $tries = 1;

    /**
     * 任务可以执行的最大秒数 (超时时间)。
     *
     * @var int
     */
    public $timeout = 20;

    private $orderId;

    private $stock;

    private $productId;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($orderId, $stock, $productId)
    {
        $this->orderId = $orderId;
        $this->stock = $stock;
        $this->productId = $productId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orderCache = Redis::hget('PENDING_ORDERS_LIST', $this->orderId);
        if ($orderCache) {
            // 已经过期 释放库存
            $res = Products::where('id', '=', $this->productId)->increment('in_stock', $this->stock);
            $orderCache = json_decode($orderCache, true);
            // 如果存在优惠券，就将优惠券次数+1
            if (isset($orderCache['coupon_id'])) {
                Coupons::where('id', '=', $orderCache['coupon_id'])->increment('ret', 1);
                if ($orderCache['coupon_type'] == 1) {
                    Coupons::where('id', '=', $orderCache['coupon_id'])->update(['is_status' => 1]);
                }
            }
            Redis::hdel('PENDING_ORDERS_LIST', $this->orderId);
        }
    }
}
