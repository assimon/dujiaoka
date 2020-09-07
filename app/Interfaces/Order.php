<?php


namespace App\Interfaces;


use App\Exceptions\AppException;
use App\Jobs\ReleaseOrder;
use App\Models\Coupons;
use App\Models\Products;
use Carbon\Carbon;
use Facades\App\Services\OrderService;
use Facades\App\Services\ProductsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Order
{


    protected $orderInfo = [];

    protected $product = [];

    public function __construct(array $order, array $product)
    {
        $this->orderInfo = $order;
        $this->product = $product;
    }


    /**
     * 缓存订单..
     */
    public function cacheOrder() : string
    {
        // 将订单信息载入缓存，等待支付
        Redis::hset('PENDING_ORDERS_LIST', $this->orderInfo['order_id'], json_encode($this->orderInfo));
        // 开始事务
        DB::beginTransaction();
        // 减去数据库库存
        $deStock = Products::where(['id' => $this->product['id'], 'in_stock' => $this->product['in_stock']])->decrement('in_stock', $this->orderInfo['buy_amount']);
        if (isset($this->orderInfo['coupon_code'])) {
            // 将优惠券设置为已经使用 且次数-1
            $inCoupon = Coupons::where('card', '=', $this->orderInfo['coupon_code'])->update(['is_status' => 2]);
            $inCouponNum =  Coupons::where(['card' => $this->orderInfo['coupon_code']])->decrement('ret', 1);
        } else {
            $inCoupon = true;
            $inCouponNum = true;
        }
        if (!$deStock || !$inCoupon || !$inCouponNum) {
            Redis::hdel('PENDING_ORDERS_LIST', $this->orderInfo['order_id']);
            DB::rollBack();
            throw new AppException(__('prompt.order_post_error'));
        }
        DB::commit();
        // 设置订单cookie
        OrderService::queueCookie($this->orderInfo['order_id']);
        // 将过期释放的订单载入队列 x分钟后释放
        ReleaseOrder::dispatch($this->orderInfo['order_id'],  $this->orderInfo['buy_amount'], $this->product['id'])->delay(Carbon::now()->addMinutes(config('app.order_expire_date')));
        return $this->orderInfo['order_id'];
    }

    /**
     * 设置优惠券.
     * @param Coupons $coupon
     */
    public function setCoupon(Coupons $coupon)
    {
        $this->orderInfo = OrderService::processCoupon($coupon, $this->product['id'], $this->orderInfo);
    }

    /**
     * 计算总价格
     */
    public function calculateThePrice()
    {
        // 如果存在批发价
        if (!empty($this->product['wholesale_price'])) {
            $this->orderInfo['actual_price'] = OrderService::getWholesalePrice(
                ProductsService::formatWholesalePrice($this->product['wholesale_price']),
                $this->orderInfo['actual_price'],
                $this->orderInfo['buy_amount']
            );
        } else {
            $this->orderInfo['actual_price'] = number_format(($this->orderInfo['actual_price'] * $this->orderInfo['buy_amount']), 2, '.', '');
        }
    }

    /***
     * 代充表单格式化.
     * @param array $requestData
     * @throws AppException
     */
    public function formatChargeInput(array $requestData)
    {
        $otherIpuAll =  ProductsService::formatChargeInput($this->product['other_ipu']);
        foreach ($otherIpuAll as $value) {
            if ($value['rule'] && empty($data[$value['field']])) {
                throw new AppException("{$value['desc']}" . __('prompt.charge_not_null'));
            }
            $this->orderInfo['other_ipu'] .= $value['desc'].':'.$requestData[$value['field']].PHP_EOL;
        }
    }

}
