<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AffiliateCode;
use App\Models\AffiliateCode as AffiliateCodeModel;
use App\Models\Order;
use App\Service\AffiliateCodeService;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;

/**
 * 推广码管理控制器
 *
 * 提供推广码的 CRUD 管理界面：
 * - 列表页：显示推广码、折扣类型、折扣值、使用次数、状态
 * - 创建页：自动生成推广码，设置折扣类型和折扣值
 * - 编辑页：推广码只读，可修改折扣设置和状态
 * - 详情页：查看推广码完整信息
 * - 统计页：查看推广码的使用统计
 */
class AffiliateCodeController extends AdminController
{
    /**
     * 列表页
     *
     * 显示所有推广码及其折扣信息
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AffiliateCode(), function (Grid $grid) {
            // 按 ID 降序排序
            $grid->model()->orderBy('id', 'DESC');

            // ID 列（可排序）
            $grid->column('id')->sortable();

            // 推广码列（可复制）
            $grid->column('code', '推广码')->copyable();

            // 推广链接列（完整URL，可复制）
            $grid->column('aff_link', '推广链接')->display(function () {
                $baseUrl = rtrim(config('app.url'), '/');
                return $baseUrl . '?aff=' . $this->code;
            })->copyable()->width(280);

            // 折扣类型列
            $grid->column('discount_type', '折扣类型')->display(function ($type) {
                $map = AffiliateCodeModel::getDiscountTypeMap();
                return $map[$type] ?? '未知';
            });

            // 折扣值列
            $grid->column('discount_value', '折扣值')->display(function () {
                if ($this->discount_type == AffiliateCodeModel::DISCOUNT_TYPE_FIXED) {
                    return $this->discount_value . ' 元';
                } else {
                    return $this->discount_value . ' %';
                }
            });

            // 使用次数列
            $grid->column('use_count', '使用次数');

            // 状态列（开关按钮）
            $grid->column('is_open', '是否启用')->switch();

            // 备注列
            $grid->column('remark', '备注')->limit(30);

            // 创建时间列
            $grid->column('created_at', '创建时间');

            // 操作列
            $grid->actions(function ($actions) {
                // 添加查看统计按钮
                $actions->append('<a href="' . admin_url('affiliate-code/' . $actions->getKey() . '/stats') . '" class="btn btn-sm btn-outline-info" style="margin-right: 5px;"><i class="feather icon-bar-chart-2"></i> 统计</a>');
            });

            // 过滤器
            $grid->filter(function (Grid\Filter $filter) {
                // 根据 ID 精确搜索
                $filter->equal('id');

                // 根据推广码模糊搜索
                $filter->like('code', '推广码');

                // 根据折扣类型搜索
                $filter->equal('discount_type', '折扣类型')
                       ->select(AffiliateCodeModel::getDiscountTypeMap());
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
        return Show::make($id, new AffiliateCode(), function (Show $show) {
            $show->field('id', 'ID');

            $show->field('code', '推广码');

            // 折扣类型
            $show->field('discount_type', '折扣类型')->as(function ($type) {
                $map = AffiliateCodeModel::getDiscountTypeMap();
                return $map[$type] ?? '未知';
            });

            // 折扣值
            $show->field('discount_value', '折扣值')->as(function () {
                if ($this->discount_type == AffiliateCodeModel::DISCOUNT_TYPE_FIXED) {
                    return $this->discount_value . ' 元';
                } else {
                    return $this->discount_value . ' %';
                }
            });

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
     * 创建：自动生成推广码，设置折扣类型和折扣值
     * 编辑：推广码只读，可修改折扣设置和状态
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

            // 折扣类型（单选）
            $form->radio('discount_type', '折扣类型')
                 ->options(AffiliateCodeModel::getDiscountTypeMap())
                 ->default(AffiliateCodeModel::DISCOUNT_TYPE_FIXED)
                 ->required()
                 ->help('固定金额：直接减免指定金额；百分比：按总价的百分比减免');

            // 折扣值
            $form->decimal('discount_value', '折扣值')
                 ->default(0)
                 ->required()
                 ->help('固定金额填写元数（如 10 表示减 10 元），百分比填写数值（如 10 表示打 9 折）');

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

            // 保存前钩子
            $form->saving(function (Form $form) {
                // 创建模式：自动生成推广码
                if (!$form->isEditing()) {
                    try {
                        $affiliateService = app(AffiliateCodeService::class);
                        $form->code = $affiliateService->generateUniqueCode();
                    } catch (\Exception $e) {
                        return $form->response()->error('生成推广码失败：' . $e->getMessage());
                    }
                }

                // 验证折扣值
                if ($form->discount_value <= 0) {
                    return $form->response()->error('折扣值必须大于 0');
                }

                if ($form->discount_type == AffiliateCodeModel::DISCOUNT_TYPE_PERCENTAGE
                    && $form->discount_value > 100) {
                    return $form->response()->error('百分比折扣不能超过 100%');
                }
            });
        });
    }

    /**
     * 统计页面
     *
     * 显示推广码的使用统计信息，支持筛选查询
     *
     * @param Content $content
     * @param int $id 推广码ID
     * @return Content
     */
    public function stats(Content $content, $id)
    {
        $affiliateCode = AffiliateCodeModel::findOrFail($id);

        // 获取筛选参数
        $request = request();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $orderSn = $request->input('order_sn');
        $goodsId = $request->input('goods_id');

        // 构建查询（只统计已支付的订单，过滤掉待支付和已过期的）
        $query = Order::query()
            ->where('affiliate_code_id', $id)
            ->where('status', '>', Order::STATUS_WAIT_PAY)
            ->with('goods');

        // 日期范围筛选
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // 订单号搜索
        if ($orderSn) {
            $query->where('order_sn', 'like', '%' . $orderSn . '%');
        }

        // 商品筛选
        if ($goodsId) {
            $query->where('goods_id', $goodsId);
        }

        // 执行查询
        $orders = $query->orderBy('created_at', 'DESC')->get();

        // 统计数据（基于筛选结果）
        $stats = [
            'order_count' => $orders->count(),
            'total_amount' => $orders->sum('actual_price'),
            'discount_amount' => $orders->sum('affiliate_discount_price'),
            'goods_list' => $orders->pluck('goods.gd_name')->filter()->unique()->values()->toArray(),
        ];

        // 获取该推广码关联的所有商品（用于下拉筛选，只统计已支付订单）
        $allGoodsIds = Order::where('affiliate_code_id', $id)
            ->where('status', '>', Order::STATUS_WAIT_PAY)
            ->distinct()
            ->pluck('goods_id');
        $goodsList = \App\Models\Goods::whereIn('id', $allGoodsIds)
            ->pluck('gd_name', 'id')
            ->toArray();

        // 筛选条件（用于视图回显）
        $filters = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'order_sn' => $orderSn,
            'goods_id' => $goodsId,
        ];

        return $content
            ->header('推广码统计')
            ->description('推广码：' . $affiliateCode->code)
            ->body(view('admin.affiliate_stats', compact('affiliateCode', 'orders', 'stats', 'filters', 'goodsList')));
    }
}
