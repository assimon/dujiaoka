<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Commodity;
use Illuminate\Support\Facades\Redis;

class CleanUpStock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务最大尝试次数。
     *
     * @var int
     */
    public $tries = 5;

    /**
     * 任务运行的超时时间。
     *
     * @var int
     */
    public $timeout = 30;

    private $oid;
    private $stock;
    private $cid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($oid, $stock, $cid)
    {
        $this->oid = $oid;
        $this->stock = $stock;
        $this->cid = $cid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (Redis::hget(config('PENDING_ORDERS_LIST'), $this->oid)) {
            // 已经过期 释放库存
            $res = Commodity::where('id', '=', $this->cid)->increment('in_stock', $this->stock);
            Redis::hdel(config('PENDING_ORDERS_LIST'), $this->oid);
        }
        return ;
    }
}
