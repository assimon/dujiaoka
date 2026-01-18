<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 推广码系统数据库迁移
 *
 * 创建推广码表，支持直接折扣功能
 */
class CreateAffiliateCodesTables extends Migration
{
    /**
     * 执行迁移
     * 创建推广码表
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

            // 折扣类型：1=固定金额减免, 2=百分比折扣
            $table->tinyInteger('discount_type')
                  ->default(1)
                  ->comment('折扣类型 1固定金额 2百分比');

            // 折扣值：固定金额(元) 或 百分比(如 10 表示 10%)
            $table->decimal('discount_value', 10, 2)
                  ->default(0.00)
                  ->comment('折扣值');

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
    }

    /**
     * 回滚迁移
     * 删除推广码表
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affiliate_codes');
    }
}
