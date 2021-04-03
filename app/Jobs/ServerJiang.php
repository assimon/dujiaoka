<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ServerJiang implements ShouldQueue
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


    private $order = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $postdata = http_build_query([
            'text' => "新订单通知:{$this->order['ord_title']}",
            'desp' => "
- 订单名称：{$this->order['ord_title']}
- 订单号：{$this->order['order_id']}
- 充值账户：{$this->order['account']}
- 金额：{$this->order['ord_price']}
            "
        ]);

        $opts = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            ]
        ];
        $context  = stream_context_create($opts);
        $res = file_get_contents('https://sctapi.ftqq.com/'.config('webset.serverj_token').'.send', false, $context);
        Log::info($res);
    }
}
