<?php


namespace App\Services;


use App\Exceptions\AppException;
use App\Jobs\ReleaseOrder;
use App\Jobs\SendMails;
use App\Jobs\ServerJiang;
use App\Models\Cards;
use App\Models\Coupons;
use App\Models\Orders;
use App\Models\Emailtpls;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class OrderService
{

    /**
     * 订单详情
     * @var
     */
    private $orderInfo;

    /**
     * 商品详情
     * @var
     */
    protected $product;

    /**
     * 商品服务层.
     * @var ProductService
     */
    private $productService;

    /**
     * 优惠券服务层
     * @var
     */
    private $couponService;

    /**
     * 卡密服务层.
     * @var
     */
    private $cardsService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->couponService = new CouponService();
        $this->cardsService = new CardsService();
    }

    /**
     * 设置订单详情.
     * @param $order
     */
    public function setOrderInfo($order)
    {
        $this->orderInfo = $order;
    }

    /**
     * 设置商品详情.
     * @param  $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * 设置优惠券.
     * @param $coupon
     */
    public function setCoupon($coupon)
    {
        $this->orderInfo = $this->processCoupon($coupon, $this->product['id'], $this->orderInfo);
    }

    /**
     * 获取订单详情.
     * @param string $orderId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function orderById(string $orderId)
    {
        return Orders::query()->where('order_id', $orderId)->first();
    }

    /**
     * 根据账户信息查询订单
     * @param string $account 账户.
     * @param string $searchPwd 密码
     * @return array|\Illuminate\Database\Concerns\BuildsQueries[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function searchOrderByAccount(string $account, string $searchPwd)
    {
        return Orders::query()
            ->where('account', $account)
            ->when($searchPwd, function ($query) use ($searchPwd) {
                $query->where('search_pwd', $searchPwd);
            })
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
    }

    /**
     * 订单id集合获取订单.
     * @param array $orderIds
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function ordersByIds(array $orderIds)
    {
        return Orders::query()
            ->whereIn('order_id', $orderIds)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    /**
     * 缓存订单..
     */
    public function cacheOrder() : string
    {
        try {
            // 开始事务
            DB::beginTransaction();
            // 将订单信息载入缓存，等待支付
            Redis::hset('PENDING_ORDERS_LIST', $this->orderInfo['order_id'], json_encode($this->orderInfo));
            // 减去数据库库存
            $deStock = $this->productService->stockDecr($this->product['id'], $this->orderInfo['buy_amount']);
            if (isset($this->orderInfo['coupon_code'])) {
                // 将优惠券设置为已经使用 且次数-1
                $inCoupon = $this->couponService->used($this->orderInfo['coupon_code']);
                $inCouponNum =  $this->couponService->numberDecr($this->orderInfo['coupon_code']);
            } else {
                $inCoupon = true;
                $inCouponNum = true;
            }
            if (!$deStock || !$inCoupon || !$inCouponNum) {
                throw new \Exception(__('prompt.order_post_error'));
            }
            DB::commit();
            // 设置订单cookie
            $this->queueCookie($this->orderInfo['order_id']);
            ReleaseOrder::dispatch($this->orderInfo['order_id'],  $this->orderInfo['buy_amount'], $this->product['id'])->delay(Carbon::now()->addMinutes(config('app.order_expire_date')));
            return $this->orderInfo['order_id'];
        } catch (\Exception $exception) {
            Redis::hdel('PENDING_ORDERS_LIST', $this->orderInfo['order_id']);
            DB::rollBack();
            throw new AppException($exception->getMessage());
        }
    }

    /**
     * 订单完成方法
     * @param $outTradeNo
     * @param $tradeNo
     * @param $totalAmount
     */
    public function successOrder(string $outTradeNo, string $tradeNo, float $totalAmount) : void
    {

        // 判断缓存里是否已经没有订单了，没有说明已经处理了
        $orderInfo = json_decode(Redis::hget('PENDING_ORDERS_LIST', $outTradeNo), true);
        if (empty($orderInfo)) throw new AppException("订单不存在:{$outTradeNo}");
        // 判断金额是否一致
        $cacheTamount = (float)$orderInfo['actual_price'];
        if ($cacheTamount != $totalAmount) {
            Log::debug("异常订单！实际付款与订单总金额不一致！$totalAmount");
            if (empty($orderInfo)) throw new AppException("异常订单！实际付款与订单总金额不一致！:{$outTradeNo}");
        }
        $order = [
            'order_id' => $orderInfo['order_id'],
            'product_id' => $orderInfo['product_id'],
            'coupon_id' => $orderInfo['coupon_id'] ?? 0,
            'ord_class' => $orderInfo['pd_type'],
            'product_price' => $orderInfo['product_price'],
            'ord_price' => $totalAmount,
            'buy_amount' => $orderInfo['buy_amount'],
            'ord_title' => $orderInfo['product_name'] . 'x' . $orderInfo['buy_amount'],
            'search_pwd' => $orderInfo['search_pwd'],
            'account' => $orderInfo['account'],
            'pay_ord' => $tradeNo,
            'pay_way' => $orderInfo['pay_way'],
            'buy_ip' => $orderInfo['buy_ip'],
            'ord_info' => ''
        ];
        // 区分订单类型
        if ($orderInfo['pd_type'] == 1) {
            //  卡密商品 查询出待发货的卡密到邮件队列
            $cardList = $this->cardsService->cardByProduct($orderInfo['product_id'], $orderInfo['buy_amount']);
            if (empty($cardList) || count($cardList) != $orderInfo['buy_amount']) {
                $order['ord_info'] = '发卡异常请联系管理员核查!';
            } else {
                $cardUpdate = [];
                foreach ($cardList as $value) {
                    $cardUpdate[] = $value['id'];
                    $order['ord_info'] .= $value['card_info'].PHP_EOL;
                }
                // 批量更新
                Cards::query()->whereIn('id', $cardUpdate)->update(['card_status' => 2]);
                $order['ord_status'] = 3;
            }
        } else {
            $order['ord_info'] = $orderInfo['other_ipu'];
            $order['ord_status'] = 1;
        }
        Orders::query()->create($order);
        // 将订单信息载入待发送邮件队列
        $order['created_at'] = date('Y-m-d H:i:s');
        $order['product_name'] = $orderInfo['product_name'];
        $order['webname'] = config('webset.text_logo');
        $order['weburl'] = env('APP_URL');
        // 这里格式化一下把换行改成<br/>方便邮件
        $order['ord_info'] = str_replace(PHP_EOL, '<br/>', $order['ord_info']);
        // 判断订单类型
        if ($orderInfo['pd_type'] == 1) {
            // 发送邮箱给用户
            $mailtpl = Emailtpls::query()->where('tpl_token', 'card_send_user_email')->first()->toArray();
            $to = $orderInfo['account'];
        } else {
            $mailtpl = Emailtpls::query()->where('tpl_token', 'manual_send_manage_mail')->first()->toArray();
            $to = config('webset.manage_email');
        }
        $mailtipsInfo = replace_mail_tpl($mailtpl, $order);
        if (!empty($to)) SendMails::dispatch($to, $mailtipsInfo['tpl_content'], $mailtipsInfo['tpl_name']);
        // 如果开启了server酱推送
        if (config('webset.isopen_serverj') == 1) {
            ServerJiang::dispatch($order);
        }
        // 商品销量+
        Products::query()->where('id', $order['product_id'])->increment('sales_volume', $order['buy_amount']);
        Redis::hdel('PENDING_ORDERS_LIST', $outTradeNo);
        //载入成功缓存
        Redis::hset('ORDERS_SUCCESS_LIST', $orderInfo['order_id'], 'success');
    }


    /**
     * 计算总价格
     */
    public function calculateThePrice()
    {
        // 如果存在批发价
        if (!empty($this->product['wholesale_price'])) {
            $this->orderInfo['actual_price'] = $this->getWholesalePrice(
                $this->productService->formatWholesalePrice($this->product['wholesale_price']),
                $this->orderInfo['actual_price'],
                $this->orderInfo['buy_amount']
            );
        } else {
            $this->orderInfo['actual_price'] = number_format(($this->orderInfo['actual_price'] * $this->orderInfo['buy_amount']), 2, '.', '');
        }
    }



    /**
     * 获取批发价格.
     * @param array $wholesalePriceArr 批发价匹配数组.
     * @param float $actualPrice 原始价格.
     * @param int $orderNumber 购买数量.
     * @return float 批发后的总价.
     */
    public function getWholesalePrice(array $wholesalePriceArr, float $actualPrice, int $orderNumber) : float
    {
        $wholesalePrice = $actualPrice * $orderNumber;
        foreach ($wholesalePriceArr as $wholesale) {
            if ($orderNumber >= $wholesale['number']) {
                $wholesalePrice = $wholesale['price'] * $orderNumber;
            }
        }
        return number_format($wholesalePrice, 2, '.', '');
    }


    /**
     * 处理优惠券逻辑.
     * @param Coupons $coupon 优惠码.
     * @param int $pid 商品id.
     * @param array $cacheOrder 订单缓存数组.
     * @return  array $cacheOrder 处理好的订单.
     * @throws AppException
     */
    public function processCoupon(Coupons $coupon, int $pid, array $cacheOrder) : array
    {
        // 判断类型  如果是一次性的话  先判断使用没有
        if ($coupon['c_type'] == 1 && $coupon['is_status'] == 2) {
            throw new AppException(__('prompt.coupon_already_used'));
        }
        if ($coupon['c_type'] == 2 && $coupon['ret'] <= 0) {
            throw new AppException(__('prompt.coupon_no_more'));
        }
        if ($cacheOrder['actual_price'] <= $coupon['discount']) {
            throw new AppException(__('prompt.coupon_price_error'));
        }
        $couponProcess = [
            'coupon_type' => $coupon['c_type'],
            'coupon_id' => $coupon['id'],
            'coupon_code' => $coupon['card'],
            'discount' =>  number_format($coupon['discount'], 2, '.', ''),
            'actual_price' => number_format(($cacheOrder['actual_price'] - $coupon['discount']), 2, '.', '')
        ];
        return array_merge($cacheOrder, $couponProcess);
    }

    /***
     * 代充表单格式化.
     * @param array $requestData
     * @throws AppException
     */
    public function formatChargeInput(array $requestData)
    {
        $otherIpuAll =  $this->productService->formatChargeInput($this->product['other_ipu']);
        foreach ($otherIpuAll as $value) {
            if ($value['rule'] && empty($requestData[$value['field']])) {
                throw new AppException("{$value['desc']}" . __('prompt.charge_not_null'));
            }
            $this->orderInfo['other_ipu'] .= $value['desc'].':'.$requestData[$value['field']].PHP_EOL;
        }
    }

    /**
     * 设置订单cookie.
     * @param string $orderId 订单号.
     */
    public function queueCookie(string $orderId) : void
    {
        // 设置订单cookie
        $cookies = Cookie::get('orders');
        if (empty($cookies)) {
            Cookie::queue('orders', json_encode([$orderId]));
        } else {
            $cookies = json_decode($cookies, true);
            array_push($cookies, $orderId);
            Cookie::queue('orders', json_encode($cookies));
        }
    }

}
