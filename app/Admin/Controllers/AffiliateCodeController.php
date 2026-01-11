<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AffiliateCode;
use App\Models\AffiliateCode as AffiliateCodeModel;
use App\Models\Coupon;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

/**
 * 推广码管理控制器
 *
 * 提供推广码的 CRUD 管理界面：
 * - 列表页：显示推广码、关联优惠码、使用次数、状态
 * - 创建页：自动生成推广码，多选关联优惠码
 * - 编辑页：推广码只读，可修改关联优惠码和状态
 * - 详情页：查看推广码完整信息
 *
 * @author assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link http://utf8.hk/
 */
class AffiliateCodeController extends AdminController
{
    /**
     * 列表页
     *
     * 显示所有推广码及其关联信息
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AffiliateCode(['coupons']), function (Grid $grid) {
            // 按 ID 降序排序
            $grid->model()->orderBy('id', 'DESC');

            // ID 列（可排序）
            $grid->column('id')->sortable();

            // 推广码列（可复制）
            $grid->column('code', '推广码')->copyable();

            // 关联优惠码列（显示所有关联的优惠码，用逗号分隔）
            $grid->column('coupons', '关联优惠码')->display(function ($coupons) {
                if (empty($coupons)) {
                    return '<span style="color: #999;">无</span>';
                }
                // 提取优惠码字符串并用逗号分隔
                $couponCodes = array_column($coupons, 'coupon');
                return implode(', ', $couponCodes);
            });

            // 使用次数列
            $grid->column('use_count', '使用次数');

            // 状态列（开关按钮）
            $grid->column('is_open', '是否启用')->switch();

            // 备注列
            $grid->column('remark', '备注')->limit(30);

            // 创建时间列
            $grid->column('created_at', '创建时间');

            // 过滤器
            $grid->filter(function (Grid\Filter $filter) {
                // 根据 ID 精确搜索
                $filter->equal('id');

                // 根据推广码模糊搜索
                $filter->like('code', '推广码');

                // 根据关联的优惠码 ID 搜索
                $filter->where('coupon_id', function ($query) {
                    $couponId = $this->input;
                    $query->whereHas('coupons', function ($q) use ($couponId) {
                        $q->where('coupon_id', $couponId);
                    });
                }, '关联优惠码')->select(
                    Coupon::query()->where('is_open', Coupon::STATUS_OPEN)->pluck('coupon', 'id')
                );
            });

            // 禁用批量删除
            $grid->disableBatchDelete();
        });
    }

    /**
     * 详情页
     *
     * 显示单个推广码的详细信息
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new AffiliateCode(['coupons']), function (Show $show) {
            $show->field('id', 'ID');

            $show->field('code', '推广码');

            // 关联的优惠码列表
            $show->field('coupons', '关联优惠码')->as(function ($coupons) {
                if (empty($coupons)) {
                    return '无';
                }
                // 格式化显示：优惠码 (优惠金额)
                $list = [];
                foreach ($coupons as $coupon) {
                    $list[] = $coupon['coupon'] . ' (' . $coupon['discount'] . '元)';
                }
                return implode('<br>', $list);
            })->unescape();

            $show->field('use_count', '使用次数');

            $show->field('is_open', '是否启用')->as(function ($isOpen) {
                return $isOpen == AffiliateCodeModel::STATUS_OPEN
                    ? '<span style="color: green;">启用</span>'
                    : '<span style="color: red;">禁用</span>';
            })->unescape();

            $show->field('remark', '备注');

            $show->field('created_at', '创建时间');

            $show->field('updated_at', '更新时间');
        });
    }

    /**
     * 表单页（创建和编辑）
     *
     * 创建：自动生成推广码，选择关联优惠码
     * 编辑：推广码只读，可修改关联优惠码和状态
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new AffiliateCode(), function (Form $form) {
            $form->display('id', 'ID');

            // 推广码字段
            if ($form->isEditing()) {
                // 编辑时：显示推广码但设为只读
                $form->display('code', '推广码')
                     ->help('推广码在创建后不可修改');
            }
            // 创建时：不显示 code 字段（将在 saving hook 中自动生成）

            // 关联优惠码（多选）
            $form->multipleSelect('coupons', '关联优惠码')
                 ->options(Coupon::query()
                     ->where('is_open', Coupon::STATUS_OPEN)
                     ->pluck('coupon', 'id'))
                 ->required()
                 ->help('可选择多个优惠码，购买时系统会自动应用优惠金额最大的那个')
                 ->customFormat(function ($v) {
                     if (!$v) {
                         return [];
                     }
                     // 从数据库中查出的二维数组转化成 ID 数组
                     return array_column($v, 'id');
                 });

            // 备注字段
            $form->textarea('remark', '备注')
                 ->rows(3)
                 ->help('可以记录推广码用途、推广渠道等信息');

            // 启用状态开关
            $form->switch('is_open', '是否启用')
                 ->default(AffiliateCodeModel::STATUS_OPEN);

            // 使用次数（仅编辑时显示，不可修改）
            if ($form->isEditing()) {
                $form->display('use_count', '使用次数')
                     ->help('此字段由系统自动统计，不可手动修改');
            }

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');

            // 保存前钩子：创建时自动生成推广码
            $form->saving(function (Form $form) {
                if (!$form->isEditing()) {
                    // 创建模式：调用服务生成唯一推广码
                    try {
                        $affiliateService = app('Service\AffiliateCodeService');
                        $form->code = $affiliateService->generateUniqueCode();
                    } catch (\Exception $e) {
                        // 生成失败，返回错误
                        return $form->response()->error('生成推广码失败：' . $e->getMessage());
                    }
                }
            });
        });
    }
}
