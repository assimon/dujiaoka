<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * 推广码模型
 *
 * 推广码系统的核心数据模型，支持直接折扣功能。
 * 推广码用于通过 URL 参数（?aff=xxx）自动应用折扣，提升用户体验和转化率。
 *
 * @property int $id 主键ID
 * @property string $code 推广码（8位字母+数字，自动生成，唯一）
 * @property int $is_open 是否启用（1启用 0禁用）
 * @property int $discount_type 折扣类型（1固定金额 2百分比）
 * @property float $discount_value 折扣值
 * @property string $remark 备注说明
 * @property int $use_count 使用次数统计
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property \Illuminate\Support\Carbon $deleted_at 删除时间
 */
class AffiliateCode extends BaseModel
{
    use SoftDeletes;

    /**
     * 折扣类型：固定金额减免
     */
    const DISCOUNT_TYPE_FIXED = 1;

    /**
     * 折扣类型：百分比折扣
     */
    const DISCOUNT_TYPE_PERCENTAGE = 2;

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
        'code',
        'is_open',
        'discount_type',
        'discount_value',
        'remark',
        'use_count',
    ];

    /**
     * 字段类型转换
     *
     * @var array
     */
    protected $casts = [
        'is_open' => 'integer',
        'discount_type' => 'integer',
        'discount_value' => 'float',
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
     * 计算折扣金额
     *
     * @param float $totalPrice 商品总价
     * @return float 折扣金额
     */
    public function calculateDiscount(float $totalPrice): float
    {
        if ($this->discount_type === self::DISCOUNT_TYPE_FIXED) {
            // 固定金额减免，不能超过总价
            return min($this->discount_value, $totalPrice);
        } else {
            // 百分比折扣
            return bcmul($totalPrice, $this->discount_value / 100, 2);
        }
    }

    /**
     * 获取折扣类型映射
     *
     * @return array
     */
    public static function getDiscountTypeMap(): array
    {
        return [
            self::DISCOUNT_TYPE_FIXED => '固定金额减免',
            self::DISCOUNT_TYPE_PERCENTAGE => '百分比折扣',
        ];
    }

    /**
     * 获取启用状态的推广码查询构造器
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
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
     */
    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }
}
