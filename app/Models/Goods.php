<?php

namespace App\Models;


use App\Events\GoodsDeleted;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends BaseModel
{

    use SoftDeletes;

    protected $table = 'goods';

    protected $dispatchesEvents = [
        'deleted' => GoodsDeleted::class
    ];

    /**
     * 关联分类
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function group()
    {
        return $this->belongsTo(GoodsGroup::class, 'group_id');
    }

    /**
     * 关联优惠券
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function coupon()
    {
        return $this->belongsToMany(Coupon::class, 'coupons_goods', 'goods_id', 'coupons_id');
    }

    /**
     * 关联卡密
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function carmis()
    {
        return $this->hasMany(Carmis::class, 'goods_id');
    }

    /**
     * 库存读取器,将自动发货的库存更改为未出售卡密的数量
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function getInStockAttribute()
    {
        if (isset($this->attributes['carmis_count'])
            &&
            $this->attributes['type'] == self::AUTOMATIC_DELIVERY
        ) {
           $this->attributes['in_stock'] = $this->attributes['carmis_count'];
        }
        return $this->attributes['in_stock'];
    }

    /**
     * 获取组建映射
     *
     * @return array
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public static function getGoodsTypeMap()
    {
        return [
            self::AUTOMATIC_DELIVERY => admin_trans('goods.fields.automatic_delivery'),
            self::MANUAL_PROCESSING => admin_trans('goods.fields.manual_processing')
        ];
    }

}
