<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends BaseModel
{

    use SoftDeletes;

    protected $table = 'coupons';

    /**
     * 一次性使用
     */
    const TYPE_ONE_TIME = 1;

    /**
     * 重复使用
     */
    const TYPE_REPEAT = 2;

    /**
     * 未使用
     */
    const STATUS_UNUSED = 1;

    /**
     * 已使用
     */
    const STATUS_USE = 2;

    /**
     * 关联商品
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function goods()
    {
        return $this->belongsToMany(Goods::class, 'coupons_goods', 'coupons_id', 'goods_id');
    }


    public static function getStatusUseMap()
    {
        return [
            self::STATUS_USE => admin_trans('coupon.fields.status_use'),
            self::STATUS_UNUSED => admin_trans('coupon.fields.status_unused'),
        ];
    }


}
