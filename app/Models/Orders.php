<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{

    use SoftDeletes;

    protected $fillable = ['order_id', 'product_id', 'coupon_id', 'ord_class', 'product_price', 'ord_price', 'buy_amount', 'ord_title', 'search_pwd', 'account', 'ord_info', 'pay_ord', 'pay_way', 'buy_ip', 'ord_status'];//开启白名单字段


    /**
     * 关联商品表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    /**
     * 关联优惠券.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(Coupons::class, 'coupon_id');
    }

    /**
     * 关联支付方式
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pay()
    {
        return $this->belongsTo(Pays::class, 'pay_way');
    }

    /**
     * 格式化批发价
     * @param $cacheOrder
     * @param $product
     */
    public static function wholesalePrice($cacheOrder = [], $product = [], $data = [])
    {
        $wholesaleAll = explode(PHP_EOL, $product['wholesale_price']);
        $actual_price = $cacheOrder['actual_price'] * $data['order_number'];
        foreach ($wholesaleAll as $wholesale) {
            $wholesaleInfo = explode('=', delete_html($wholesale));
            $wnum = $wholesaleInfo[0];
            $wmoney = $wholesaleInfo[1];
            if ($data['order_number'] >= $wnum) {
                $actual_price = $wmoney * $data['order_number'];
            }
        }
        return $actual_price;
    }

}
