<?php
/**
 * The file was created by Assimon.
 *
 * @author    assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link      http://utf8.hk/
 */

namespace App\Service;

use App\Exceptions\RuleValidationException;
use App\Jobs\ApiHook;
use App\Jobs\MailSend;
use App\Jobs\OrderExpired;
use App\Jobs\ServerJiang;
use App\Jobs\TelegramPush;
use App\Models\BaseModel;
use App\Models\Coupon;
use App\Models\Goods;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 订单处理层
 *
 * Class OrderProcessService
 * @package App\Service
 * @author: Assimon
 * @email: Ashang@utf8.hk
 * @blog: https://utf8.hk
 * Date: 2021/5/30
 */
class OrderProcessService
{

    const PENDING_CACHE_KEY = 'PENDING_ORDERS_LIST';

    /**
     * 优惠码服务层
     * @var \App\Service\CouponService
     */
    private $couponService;

    /**
     * 订单服务层
     * @var \App\Service\OrderService
     */
    private $orderService;

    /**
     * 卡密服务层
     * @var \App\Service\CarmisService
     */
    private $carmisService;

    /**
     * 邮件服务层
     * @var \App\Service\EmailtplService
     */
    private $emailtplService;

    /**
     * 商品服务层.
     * @var \App\Service\GoodsService
     */
    private $goodsService;

    /**
     * 商品
     * @var Goods
     */
    private $goods;

    /**
     * 优惠码
     * @var Coupon;
     */
    private $coupon;

    /**
     * 其他输入框
     * @var string
     */
    private $otherIpt;

    /**
     * 购买数量
     * @var int
     */
    private $buyAmount;

    /**
     * 购买邮箱
     * @var string
     */
    private $email;

    /**
     * 查询密码
     * @var string
     */
    private $searchPwd;

    /**
     * 下单id
     * @var string
     */
    private $buyIP;

    /**
     * 支付方式
     * @var int
     */
    private $payID;

    public function __construct()
    {
        $this->couponService = app('Service\CouponService');
        $this->orderService = app('Service\OrderService');
        $this->carmisService = app('Service\CarmisService');
        $this->emailtplService = app('Service\EmailtplService');
        $this->goodsService = app('Service\GoodsService');

    }

    /**
     * 设置支付方式
     * @param int $payID
     */
    public function setPayID(int $payID): void
    {
        $this->payID = $payID;
    }



    /**
     * 下单ip
     * @param mixed $buyIP
     */
    public function setBuyIP($buyIP): void
    {
        $this->buyIP = $buyIP;
    }

    /**
     * 设置查询密码
     * @param mixed $searchPwd
     */
    public function setSearchPwd($searchPwd): void
    {
        $this->searchPwd = $searchPwd;
    }

    /**
     * 设置购买数量
     * @param mixed $buyAmount
     */
    public function setBuyAmount($buyAmount): void
    {
        $this->buyAmount = $buyAmount;
    }

    /**
     * 设置下单邮箱
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * 设置商品
     *
     * @param Goods $goods
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function setGoods(Goods $goods)
    {
        $this->goods = $goods;
    }

    /**
     * 设置优惠码.
     *
     * @param ?Coupon $coupon
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function setCoupon(?Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * 其他输入框设置.
     *
     * @param ?string $otherIpt
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function setOtherIpt(?string $otherIpt)
    {
        $this->otherIpt = $otherIpt;
    }

    /**
     * 计算优惠码价格
     *
     * @return float
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    private function calculateTheCouponPrice(): float
    {
        $couponPrice = 0;
        // 优惠码优惠价格
        if ($this->coupon) {
            $couponPrice =  $this->coupon->discount;
        }
        return $couponPrice;
    }

    /**
     * 计算批发优惠
     * @return float
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    private function calculateTheWholesalePrice(): float
    {
        $wholesalePrice = 0; // 优惠单价
        $wholesaleTotalPrice = 0; // 优惠总价
        if ($this->goods->wholesale_price_cnf) {
            $formatWholesalePrice = format_wholesale_price($this->goods->wholesale_price_cnf);
            foreach ($formatWholesalePrice as $item) {
                if ($this->buyAmount >= $item['number']) {
                    $wholesalePrice = $item['price'];
                }
            }
        }
        if ($wholesalePrice > 0 ) {
            $totalPrice = $this->calculateTheTotalPrice(); // 实际原总价
            $newTotalPrice = bcmul($wholesalePrice, $this->buyAmount, 2); // 批发价优惠后的总价
            $wholesaleTotalPrice = bcsub($totalPrice, $newTotalPrice, 2); // 批发总优惠
        }
        return $wholesaleTotalPrice;
    }

    /**
     * 订单总价
     * @return float
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    private function calculateTheTotalPrice(): float
    {
        $price = $this->goods->actual_price;
        return bcmul($price, $this->buyAmount, 2);
    }

    /**
     * 计算实际需要支付的价格
     *
     * @param float $totalPrice 总价
     * @param float $couponPrice 优惠码优惠价
     * @param float $wholesalePrice 批发优惠
     * @return float
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    private function calculateTheActualPrice(float $totalPrice, float $couponPrice, float $wholesalePrice): float
    {
        $actualPrice = bcsub($totalPrice, $couponPrice, 2);
        $actualPrice = bcsub($actualPrice, $wholesalePrice, 2);
        if ($actualPrice <= 0) {
            $actualPrice = 0;
        }
        return $actualPrice;
    }

    /**
     * 创建订单.
     * @return Order
     * @throws RuleValidationException
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function createOrder(): Order
    {
        try {
            $order = new Order();
            // 生成订单号
            $order->order_sn = Str::random(16);
            // 设置商品
            $order->goods_id = $this->goods->id;
            // 标题
            $order->title = $this->goods->gd_name . 'x' . $this->buyAmount;
            // 订单类型
            $order->type = $this->goods->type;
            // 查询密码
            $order->search_pwd = $this->searchPwd;
            // 邮箱
            $order->email = $this->email;
            // 支付方式.
            $order->pay_id = $this->payID;
            // 商品单价
            $order->goods_price = $this->goods->actual_price;
            // 购买数量
            $order->buy_amount = $this->buyAmount;
            // 订单详情
            $order->info = $this->otherIpt;
            // ip地址
            $order->buy_ip = $this->buyIP;
            // 优惠码优惠价格
            $order->coupon_discount_price = $this->calculateTheCouponPrice();
            if ($this->coupon) {
                $order->coupon_id = $this->coupon->id;
            }
            // 批发价
            $order->wholesale_discount_price = $this->calculateTheWholesalePrice();
            // 订单总价
            $order->total_price = $this->calculateTheTotalPrice();
            // 订单实际需要支付价格
            $order->actual_price = $this->calculateTheActualPrice(
                $this->calculateTheTotalPrice(),
                $this->calculateTheCouponPrice(),
                $this->calculateTheWholesalePrice()
            );
            // 保存订单
            $order->save();
            // 如果有用到优惠券
            if ($this->coupon) {
                // 设置优惠码已经使用
                $this->couponService->used($this->coupon->coupon);
                // 使用次数-1
                $this->couponService->retDecr($this->coupon->coupon);
            }
            // 将订单加入队列 x分钟后过期
            $expiredOrderDate = dujiaoka_config_get('order_expire_time', 5);
            OrderExpired::dispatch($order->order_sn)->delay(Carbon::now()->addMinutes($expiredOrderDate));
            return $order;
        } catch (\Exception $exception) {
            throw new RuleValidationException($exception->getMessage());
        }

    }


    /**
     * 订单成功方法
     *
     * @param string $orderSN 订单号
     * @param float $actualPrice 实际支付金额
     * @param string $tradeNo 第三方订单号
     * @return Order
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function completedOrder(string $orderSN, float $actualPrice, string $tradeNo = '')
    {
        DB::beginTransaction();
        try {
            // 得到订单详情
            $order = $this->orderService->detailOrderSN($orderSN);
            if (!$order) {
                throw new \Exception(__('dujiaoka.prompt.order_does_not_exist'));
            }
            // 订单已经处理
            if ($order->status == Order::STATUS_COMPLETED) {
                throw new \Exception(__('dujiaoka.prompt.order_status_completed'));
            }
            $bccomp = bccomp($order->actual_price, $actualPrice, 2);
            // 金额不一致
            if ($bccomp != 0) {
                throw new \Exception(__('dujiaoka.prompt.order_inconsistent_amounts'));
            }
            $order->actual_price = $actualPrice;
            $order->trade_no = $tradeNo;
            // 区分订单类型
            // 自动发货
            if ($order->type == Order::AUTOMATIC_DELIVERY) {
                $completedOrder = $this->processAuto($order);
            } else {
                $completedOrder = $this->processManual($order);
            }
            // 销量加上
            $this->goodsService->salesVolumeIncr($order->goods_id, $order->buy_amount);
            DB::commit();
            // 如果开启了server酱
            if (dujiaoka_config_get('is_open_server_jiang', 0) == BaseModel::STATUS_OPEN) {
                ServerJiang::dispatch($order);
            }
            // 如果开启了TG推送
            if (dujiaoka_config_get('is_open_telegram_push', 0) == BaseModel::STATUS_OPEN) {
                TelegramPush::dispatch($order);
            }
            // 回调事件
            ApiHook::dispatch($order);
            return $completedOrder;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new RuleValidationException($exception->getMessage());
        }
    }

    /**
     * 手动处理的订单.
     *
     * @param Order $order 订单
     * @return Order 订单
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function processManual(Order $order)
    {
        // 设置订单为待处理
        $order->status = Order::STATUS_PENDING;
        // 保存订单
        $order->save();
        // 商品库存减去
        $this->goodsService->inStockDecr($order->goods_id, $order->buy_amount);
        // 邮件数据
        $mailData = [
            'created_at' => $order->create_at,
            'product_name' => $order->goods->gd_name,
            'webname' => dujiaoka_config_get('text_logo', '独角数卡'),
            'weburl' => config('app.url') ?? 'http://dujiaoka.com',
            'ord_info' => str_replace(PHP_EOL, '<br/>', $order->info),
            'ord_title' => $order->title,
            'order_id' => $order->order_sn,
            'buy_amount' => $order->buy_amount,
            'ord_price' => $order->actual_price,
            'created_at' => $order->created_at,
        ];
        $tpl = $this->emailtplService->detailByToken('manual_send_manage_mail');
        $mailBody = replace_mail_tpl($tpl, $mailData);
        $manageMail = dujiaoka_config_get('manage_email', '');
        // 邮件发送
        MailSend::dispatch($manageMail, $mailBody['tpl_name'], $mailBody['tpl_content']);
        return $order;
    }

    /**
     * 处理自动发货.
     *
     * @param Order $order 订单
     * @return Order 订单
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function processAuto(Order $order): Order
    {
        // 获得卡密
        $carmis = $this->carmisService->withGoodsByAmountAndStatusUnsold($order->goods_id, $order->buy_amount);
        // 实际可使用的库存已经少于购买数量了
        if (count($carmis) != $order->buy_amount) {
            $order->info = __('dujiaoka.prompt.order_carmis_insufficient_quantity_available');
            $order->status = Order::STATUS_ABNORMAL;
            $order->save();
            return $order;
        }
        $carmisInfo = array_column($carmis, 'carmi');
        $ids = array_column($carmis, 'id');
        $order->info = implode(PHP_EOL, $carmisInfo);
        $order->status = Order::STATUS_COMPLETED;
        $order->save();
        // 将卡密设置为已售出
        $this->carmisService->soldByIDS($ids);
        // 邮件数据
        $mailData = [
            'created_at' => $order->create_at,
            'product_name' => $order->goods->gd_name,
            'webname' => dujiaoka_config_get('text_logo', '独角数卡'),
            'weburl' => config('app.url') ?? 'http://dujiaoka.com',
            'ord_info' => implode('<br/>', $carmisInfo),
            'ord_title' => $order->title,
            'order_id' => $order->order_sn,
            'buy_amount' => $order->buy_amount,
            'ord_price' => $order->actual_price,
        ];
        $tpl = $this->emailtplService->detailByToken('card_send_user_email');
        $mailBody = replace_mail_tpl($tpl, $mailData);
        // 邮件发送
        MailSend::dispatch($order->email, $mailBody['tpl_name'], $mailBody['tpl_content']);
        return $order;
    }

}
