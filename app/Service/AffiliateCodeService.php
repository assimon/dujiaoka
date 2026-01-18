<?php

namespace App\Service;

use App\Models\AffiliateCode;
use Illuminate\Support\Str;

/**
 * 推广码业务服务
 *
 * 负责推广码的核心业务逻辑：
 * 1. 生成唯一的推广码
 * 2. 获取推广码折扣信息
 * 3. 计算推广码折扣金额
 * 4. 统计推广码使用次数
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
     */
    public function generateUniqueCode(): string
    {
        $maxRetries = 5;
        $retryCount = 0;

        while ($retryCount < $maxRetries) {
            // 生成8位随机字母+数字字符串
            $code = Str::random(8);

            // 检查是否已存在
            $exists = AffiliateCode::where('code', $code)->exists();

            if (!$exists) {
                return $code;
            }

            $retryCount++;
        }

        // 5次都失败，抛出异常
        throw new \Exception('生成唯一推广码失败：已重试' . $maxRetries . '次仍然冲突');
    }

    /**
     * 根据推广码获取折扣信息
     *
     * @param string $affCode 推广码
     * @return AffiliateCode|null 推广码对象（包含折扣信息）
     */
    public function getAffiliateCodeInfo(string $affCode): ?AffiliateCode
    {
        return AffiliateCode::query()
            ->where('code', $affCode)
            ->where('is_open', AffiliateCode::STATUS_OPEN)
            ->first();
    }

    /**
     * 计算推广码折扣金额
     *
     * @param string $affCode 推广码
     * @param float $totalPrice 订单总价
     * @return array ['affiliate_code' => AffiliateCode|null, 'discount_price' => float]
     */
    public function calculateDiscount(string $affCode, float $totalPrice): array
    {
        $affiliateCode = $this->getAffiliateCodeInfo($affCode);

        if (!$affiliateCode) {
            return [
                'affiliate_code' => null,
                'discount_price' => 0.00,
            ];
        }

        $discountPrice = $affiliateCode->calculateDiscount($totalPrice);

        return [
            'affiliate_code' => $affiliateCode,
            'discount_price' => $discountPrice,
        ];
    }

    /**
     * 增加推广码使用次数
     *
     * 当订单使用推广码成功创建时，调用此方法统计使用次数
     *
     * @param string $code 推广码
     * @return bool 是否成功
     */
    public function incrementUseCount(string $code): bool
    {
        $affected = AffiliateCode::query()
            ->where('code', $code)
            ->increment('use_count', 1);

        return $affected > 0;
    }
}
