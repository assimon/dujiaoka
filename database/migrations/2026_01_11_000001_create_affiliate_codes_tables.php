<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 推广码系统数据库迁移
 *
 * 创建两张表：
 * 1. affiliate_codes - 推广码主表
 * 2. affiliate_codes_coupons - 推广码与优惠码的多对多关联表
 */
class CreateAffiliateCodesTables extends Migration
{
    /**
     * 执行迁移
     * 创建推广码相关表
     *
     * @return void
     */
    public function up()
    {
        // 创建推广码主表
        Schema::create('affiliate_codes', function (Blueprint $table) {
            $table->increments('id')->comment('主键ID');

            // 推广码字段（系统自动生成，8位字母+数字）
            $table->string('code', 100)
                  ->unique('uk_code')
                  ->comment('推广码（自动生成，唯一）');

            // 状态字段
            $table->tinyInteger('is_open')
                  ->default(1)
                  ->comment('是否启用 1启用 0禁用');

            // 备注字段
            $table->string('remark', 255)
                  ->nullable()
                  ->comment('备注说明');

            // 使用统计字段
            $table->integer('use_count')
                  ->default(0)
                  ->comment('使用次数统计');

            // 时间戳字段
            $table->timestamps();

            // 软删除字段
            $table->softDeletes();

            // 表注释
            $table->comment = '推广码表';
        });

        // 创建推广码与优惠码关联表（多对多）
        Schema::create('affiliate_codes_coupons', function (Blueprint $table) {
            $table->increments('id')->comment('主键ID');

            // 推广码ID
            $table->integer('affiliate_code_id')
                  ->unsigned()
                  ->comment('推广码ID');

            // 优惠码ID
            $table->integer('coupon_id')
                  ->unsigned()
                  ->comment('优惠码ID');

            // 时间戳字段
            $table->timestamps();

            // 索引
            $table->index('affiliate_code_id', 'idx_affiliate_code_id');
            $table->index('coupon_id', 'idx_coupon_id');

            // 唯一索引：防止重复关联
            $table->unique(
                ['affiliate_code_id', 'coupon_id'],
                'uk_affiliate_coupon'
            );

            // 表注释
            $table->comment = '推广码与优惠码关联表';
        });
    }

    /**
     * 回滚迁移
     * 删除推广码相关表
     *
     * @return void
     */
    public function down()
    {
        // 按创建顺序的反序删除表（先删除关联表，再删除主表）
        Schema::dropIfExists('affiliate_codes_coupons');
        Schema::dropIfExists('affiliate_codes');
    }
}
