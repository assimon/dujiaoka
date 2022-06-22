<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ApiHook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务最大尝试次数。
     *
     * @var int
     */
    public $tries = 2;

    /**
     * 任务运行的超时时间。
     *
     * @var int
     */
    public $timeout = 30;

    /**
     * @var Order
     */
    private $order;

    /**
     * 商品服务层.
     * @var \App\Service\PayService
     */
    private $goodsService;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->goodsService = app('Service\GoodsService');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $goodInfo = $this->goodsService->detail($this->order->goods_id);
        // 判断是否有配置支付回调
        if(empty($goodInfo->api_hook)){
            return;
        }
        $postdata = [
            'title' => $this->order->title,
            'order_sn' => $this->order->order_sn,
            'email' => $this->order->email,
            'actual_price' => $this->order->actual_price,
            'order_info' => $this->order->info,
            'good_id' => $goodInfo->id,
            'gd_name' => $goodInfo->gd_name

        ];

        
        $opts = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/json',
                'content' => json_encode($postdata,JSON_UNESCAPED_UNICODE)
            ]
        ];
        $context  = stream_context_create($opts);
        file_get_contents($goodInfo->api_hook, false, $context);
    }
}
