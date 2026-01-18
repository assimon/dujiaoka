<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * 推广码模型
 *
 * 推广码系统的核心数据模型，管理推广码与优惠码的多对多关联关系。
 * 推广码用于通过 URL 参数（?aff=xxx）自动应用优惠码，提升用户体验和转化率。
 *
 * @property int $id 主键ID
 * @property string $code 推广码（8位字母+数字，自动生成，唯一）
 * @property int $is_open 是否启用（1启用 0禁用）
 * @property string $remark 备注说明
 * @property int $use_count 使用次数统计
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property \Illuminate\Support\Carbon $deleted_at 删除时间
 *
 * @author assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link http://utf8.hk/
 */
class AffiliateCode extends BaseModel
{
    use SoftDeletes;

    /**
     * 数据表名称
     *
     * @var string
     */
    protected $table = 'affiliate_codes';

    /**
     * 可批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'code',       // 推广码
        'is_open',    // 是否启用
        'remark',     // 备注说明
        'use_count',  // 使用次数统计
    ];

    /**
     * 字段类型转换
     *
     * @var array
     */
    protected $casts = [
        'is_open' => 'integer',
        'use_count' => 'integer',
    ];

    /**
     * 模型启动方法
     * 注册模型事件监听器
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // 创建前自动生成唯一推广码
        static::creating(function ($model) {
            if (empty($model->code)) {
                $model->code = self::generateUniqueCode();
            }
        });
    }

    /**
     * 生成唯一的推广码
     *
     * @return string 8位随机字符串
     */
    protected static function generateUniqueCode(): string
    {
        $maxRetries = 5;
        $retryCount = 0;

        while ($retryCount < $maxRetries) {
            $code = Str::random(8);
            if (!self::where('code', $code)->exists()) {
                return $code;
            }
            $retryCount++;
        }

        // 如果重试失败，使用时间戳确保唯一性
        return Str::random(4) . substr(time(), -4);
    }

    /**
     * 关联优惠码（多对多关系）
     *
     * 一个推广码可以关联多个优惠码。
     * 当用户通过推广链接访问时，系统会从关联的优惠码中选择优惠金额最大的自动应用。
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * @author assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link http://utf8.hk/
     */
    public function coupons()
    {
        return $this->belongsToMany(
            Coupon::class,                  // 关联的模型
            'affiliate_codes_coupons',      // 中间表名称
            'affiliate_code_id',            // 本模型在中间表的外键
            'coupon_id'                     // 关联模型在中间表的外键
        );
    }

    /**
     * 获取启用状态的推广码查询构造器
     *
     * 用于过滤出所有启用状态（is_open = 1）的推广码
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     *
     * @author assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link http://utf8.hk/
     */
    public function scopeOpen($query)
    {
        return $query->where('is_open', self::STATUS_OPEN);
    }

    /**
     * 根据推广码字符串查询
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $code 推广码
     * @return \Illuminate\Database\Eloquent\Builder
     *
     * @author assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link http://utf8.hk/
     */
    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }
}
