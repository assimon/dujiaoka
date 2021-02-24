<?php


namespace App\Services;


use App\Models\Coupons;

class CouponService
{

    /**
     * 根据优惠码和商品获得优惠码详情
     * @param int $productId
     * @param string $coupon
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function couponByProduct(int $productId, string $coupon)
    {
        return Coupons::query()->where(['card' => $coupon, 'product_id' => $productId])->first();
    }

    /**
     * 设置优惠码已使用
     * @param string $coupon
     * @return int
     */
    public function used(string $coupon)
    {
        return Coupons::query()
            ->where('card',  $coupon)
            ->update(['is_status' => 2]);
    }

    /**
     * 设置优惠码-1
     * @param string $coupon
     */
    public function numberDecr(string $coupon)
    {
        return Coupons::query()
            ->where('card',  $coupon)
            ->decrement('ret', 1);
    }

}
