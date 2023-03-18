<?php

namespace App\Models;

use App\Events\OrderUpdated;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends BaseModel
{

    use SoftDeletes;

    protected $table = 'orders';

    /**
     * 待支付
     */
    const STATUS_WAIT_PAY = 1;

    /**
     * 待处理
     */
    const STATUS_PENDING = 2;

    /**
     * 处理中
     */
    const STATUS_PROCESSING = 3;

    /**
     * 已完成
     */
    const STATUS_COMPLETED = 4;

    /**
     * 失败
     */
    const STATUS_FAILURE = 5;

    /**
     * 过期
     */
    const STATUS_EXPIRED = -1;

    /**
     * 异常
     */
    const STATUS_ABNORMAL = 6;

    /**
     * 优惠券未回退
     */
    const COUPON_BACK_WAIT = 0;

    /**
     * 优惠券已回退
     */
    const COUPON_BACK_OK = 1;

    protected $dispatchesEvents = [
        'updated' => OrderUpdated::class
    ];


    /**
     * 状态映射
     *
     * @return array
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public static function getStatusMap()
    {
        return [
            self::STATUS_WAIT_PAY => admin_trans('order.fields.status_wait_pay'),
            self::STATUS_PENDING => admin_trans('order.fields.status_pending'),
            self::STATUS_PROCESSING => admin_trans('order.fields.status_processing'),
            self::STATUS_COMPLETED => admin_trans('order.fields.status_completed'),
            self::STATUS_FAILURE => admin_trans('order.fields.status_failure'),
            self::STATUS_ABNORMAL => admin_trans('order.fields.status_abnormal'),
            self::STATUS_EXPIRED => admin_trans('order.fields.status_expired')
        ];
    }

    /**
     * 类型映射
     *
     * @return array
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public static function getTypeMap()
    {
        return [
            self::AUTOMATIC_DELIVERY => admin_trans('goods.fields.automatic_delivery'),
            self::MANUAL_PROCESSING => admin_trans('goods.fields.manual_processing')
        ];
    }

    /**
     * 关联商品
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class, 'goods_id');
    }

    /**
     * 关联优惠券
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    /**
     * 关联支付
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function pay()
    {
        return $this->belongsTo(Pay::class, 'pay_id');
    }

    /**
     * 订单状态更新时处理
     *
     * @param Order $order
     * @return mixed
     *
     * @author    outtime<i@treeo.cn>
     * @copyright outtime<i@treeo.cn>
     * @link      https://outti.me
     */
    public function setStatusAttribute($value){
        // 如果订单状态不是待支付，或者状态不是已完成，直接返回
        if($this->status != Order::STATUS_WAIT_PAY || intval($value) != Order::STATUS_COMPLETED){
            $this->attributes['status'] = $value;
            return;
        }
        // 如果订单类型不是自动发货，直接返回
        if(!empty($this->info) || $this->type != Order::AUTOMATIC_DELIVERY){
            $this->attributes['status'] = $value;
            return;
        }
        // 手动补单进行发货处理
        if($value == Order::STATUS_COMPLETED)
            app('Service\OrderProcessService')->completedOrder($this->order_sn, $this->actual_price);
    }
}
