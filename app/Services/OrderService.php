<?php


namespace App\Services;


use App\Exceptions\AppException;
use App\Models\Coupons;

class OrderService
{

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

}
