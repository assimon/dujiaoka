<?php

namespace App\Service;

use App\Models\AffiliateCode;
use App\Models\Coupon;
use Illuminate\Support\Str;

/**
 * 推广码业务服务
 *
 * 负责推广码的核心业务逻辑：
 * 1. 生成唯一的推广码
 * 2. 根据推广码和商品ID查询最优优惠码（优惠金额最大且适用）
 * 3. 统计推广码使用次数
 *
 * @author assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link http://utf8.hk/
 */
class AffiliateCodeService
{
    /**
     * 生成唯一的推广码
     *
     * 生成规则：
     * - 8位字母+数字的随机字符串
     * - 确保在数据库中唯一
     * - 最多重试5次，如果仍然冲突则抛出异常
     *
     * @return string 唯一的推广码
     * @throws \Exception 如果5次重试都失败
     *
     * @author assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link http://utf8.hk/
     */
    public function generateUniqueCode(): string
    {
        $maxRetries = 5; // 最大重试次数
        $retryCount = 0;

        while ($retryCount < $maxRetries) {
            // 生成8位随机字母+数字字符串
            $code = Str::random(8);

            // 检查是否已存在
            $exists = AffiliateCode::where('code', $code)->exists();

            if (!$exists) {
                // 不存在，返回这个唯一的推广码
                return $code;
            }

            // 存在冲突，重试
            $retryCount++;
        }

        // 5次都失败，抛出异常
        throw new \Exception('生成唯一推广码失败：已重试' . $maxRetries . '次仍然冲突');
    }

    /**
     * 根据推广码和商品ID获取最优优惠码
     *
     * 业务逻辑：
     * 1. 查询启用状态的推广码
     * 2. 预加载所有关联的优惠码
     * 3. 过滤出启用且适用于指定商品的优惠码
     * 4. 按优惠金额（discount）降序排序
     * 5. 返回优惠金额最大的那个优惠码
     *
     * @param string $affCode 推广码
     * @param int $goodsId 商品ID
     * @return Coupon|null 优惠金额最大的优惠码对象，不存在则返回null
     *
     * @author assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link http://utf8.hk/
     */
    public function getBestCouponByAffiliateCode(string $affCode, int $goodsId): ?Coupon
    {
        // 1. 查询启用状态的推广码，并预加载关联的优惠码
        $affiliateCode = AffiliateCode::query()
            ->where('code', $affCode)
            ->where('is_open', AffiliateCode::STATUS_OPEN)
            ->with(['coupons' => function ($query) use ($goodsId) {
                // 预加载时只获取启用的优惠码，并关联商品信息
                $query->where('is_open', Coupon::STATUS_OPEN)
                      ->with('goods');
            }])
            ->first();

        // 推广码不存在或未启用
        if (!$affiliateCode) {
            return null;
        }

        // 2. 获取所有关联的优惠码
        $coupons = $affiliateCode->coupons;

        // 没有关联任何优惠码
        if ($coupons->isEmpty()) {
            return null;
        }

        // 3. 过滤出适用于当前商品的优惠码
        $applicableCoupons = $coupons->filter(function ($coupon) use ($goodsId) {
            // 检查优惠码是否关联了指定的商品
            return $coupon->goods->contains('id', $goodsId);
        });

        // 没有适用于当前商品的优惠码
        if ($applicableCoupons->isEmpty()) {
            return null;
        }

        // 4. 按优惠金额（discount）降序排序，返回优惠金额最大的那个
        $bestCoupon = $applicableCoupons->sortByDesc('discount')->first();

        return $bestCoupon;
    }

    /**
     * 增加推广码使用次数
     *
     * 当订单使用推广码成功创建时，调用此方法统计使用次数
     *
     * @param string $code 推广码
     * @return bool 是否成功
     *
     * @author assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link http://utf8.hk/
     */
    public function incrementUseCount(string $code): bool
    {
        // 将指定推广码的 use_count 字段 +1
        $affected = AffiliateCode::query()
            ->where('code', $code)
            ->increment('use_count', 1);

        // 返回是否成功（受影响行数 > 0）
        return $affected > 0;
    }
}
