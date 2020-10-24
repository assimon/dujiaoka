<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2019-03-18
 * Time: 17:34
 */

namespace App\Http\Controllers\Pay;


use App\Exceptions\AppException;
use App\Http\Controllers\Controller;

use App\Jobs\SendMails;
use App\Jobs\ServerJiang;
use App\Models\Cards;
use App\Models\Emailtpls;
use App\Models\Orders;
use App\Models\Pays;
use App\Models\Products;
use App\Services\OrderService;
use App\Services\PaysService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;


class PayController extends Controller
{

    /**
     * @var 订单详情
     */
    protected $orderInfo;

    /**
     * @var 支付详情
     */
    protected $payInfo;

    /**
     * 支付服务层
     * @var
     */
    protected $paysService;

    /**
     * 订单服务层
     * @var OrderService
     */
    protected $orderService;

    public function __construct(PaysService $paysService, OrderService $orderService)
    {
        $this->paysService = $paysService;
        $this->orderService = $orderService;
    }

    /**
     * 检查订单
     * @param $oid
     * @param $payway
     */
    protected function checkOrder(string $payway, string $oid) : void
    {
        // 判断订单是否存在
        $this->orderInfo = json_decode(Redis::hget('PENDING_ORDERS_LIST', $oid), true);
        if (empty($this->orderInfo)) throw new AppException('订单不存在或已支付');
        // 判断支付方式是否存在
        $this->payInfo = $this->paysService->payInfoById($payway);
        if (empty($this->payInfo)) throw new AppException('支付方式不存在或未启用');
    }



}
