<?php
/**
 * The file was created by Assimon.
 *
 * @author    assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link      http://utf8.hk/
 */

namespace App\Service;


use App\Models\Carmis;

class CarmisService
{

    /**
     * 通过商品查询一些数量未使用的卡密
     *
     * @param int $goodsID 商品id
     * @param int $byAmount 数量
     * @return array|null
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function withGoodsByAmountAndStatusUnsold(int $goodsID, int $byAmount)
    {
        $carmis = Carmis::query()
            ->where('goods_id', $goodsID)
            ->where('status', Carmis::STATUS_UNSOLD)
            ->take($byAmount)
            ->get();
        return $carmis ? $carmis->toArray() : null;
    }

    /**
     * 通过id集合设置卡密已售出
     *
     * @param array $ids 卡密id集合
     * @return bool
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function soldByIDS(array $ids): bool
    {
        return Carmis::query()->whereIn('id', $ids)->update(['status' => Carmis::STATUS_SOLD]);
    }

}
