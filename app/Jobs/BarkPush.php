<?php

namespace App\Jobs;

use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\BaseModel;


class BarkPush implements ShouldQueue
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
        $client = new Client();
        $apiUrl = dujiaoka_config_get('bark_server') .'/'. dujiaoka_config_get('bark_token');
		$params = [
			"title" => __('dujiaoka.prompt.new_order_push').'('.$this->order->actual_price.'元)',
			"body" => __('order.fields.order_id') .': '.$this->order->id."\n"
				. __('order.fields.order_sn') .': '.$this->order->order_sn."\n"
				. __('order.fields.pay_id') .': '.$this->order->pay->pay_name."\n"
				. __('order.fields.title') .': '.$this->order->title."\n"
				. __('order.fields.actual_price') .': '.$this->order->actual_price."\n"
				. __('order.fields.email') .': '.$this->order->email."\n"
				. __('goods.fields.gd_name') .': '.$goodInfo->gd_name."\n"
				. __('goods.fields.in_stock') .': '.$goodInfo->in_stock."\n"
				. __('order.fields.order_created') .': '.$this->order->created_at,
			"icon"=>url('assets/common/images/default.jpg'),
			"level"=>"timeSensitive",
			"group"=>dujiaoka_config_get('text_logo', '独角数卡')
		];
		if (dujiaoka_config_get('is_open_bark_push_url', 0) == BaseModel::STATUS_OPEN) {
			$params["url"] = url('detail-order-sn/'.$this->order->order_sn);
		}
        $client->post($apiUrl,['form_params' => $params, 'verify' => false]);
    }
}
