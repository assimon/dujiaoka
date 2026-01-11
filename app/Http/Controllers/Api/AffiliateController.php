<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 推广码 API 控制器
 *
 * 提供推广码相关的公开 API 接口，供前端页面调用。
 * 主要功能：根据推广码和商品ID查询最优优惠码。
 *
 * @author assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link http://utf8.hk/
 */
class AffiliateController extends Controller
{
    /**
     * 根据推广码获取优惠码
     *
     * API 端点：GET /api/affiliate/coupon
     *
     * 请求参数：
     * - aff: string (required) 推广码
     * - goods_id: integer (required) 商品ID
     *
     * 成功响应示例：
     * {
     *   "success": true,
     *   "coupon_code": "SUMMER20",
     *   "discount": 10.00,
     *   "message": "已自动应用优惠金额最大的优惠码"
     * }
     *
     * 失败响应示例：
     * {
     *   "success": false,
     *   "message": "推广码无效或不适用于当前商品"
     * }
     *
     * @param Request $request HTTP 请求对象
     * @return JsonResponse JSON 响应
     *
     * @author assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link http://utf8.hk/
     */
    public function getCouponCode(Request $request): JsonResponse
    {
        // 1. 验证必填参数
        $validator = \Validator::make($request->all(), [
            'aff' => 'required|string|max:100',
            'goods_id' => 'required|integer|min:1',
        ], [
            'aff.required' => '推广码参数 aff 不能为空',
            'aff.string' => '推广码参数 aff 必须是字符串',
            'aff.max' => '推广码参数 aff 长度不能超过100个字符',
            'goods_id.required' => '商品ID参数 goods_id 不能为空',
            'goods_id.integer' => '商品ID参数 goods_id 必须是整数',
            'goods_id.min' => '商品ID参数 goods_id 必须大于0',
        ]);

        // 参数验证失败，返回 400 错误
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        // 2. 获取验证后的参数
        $affCode = $request->input('aff');
        $goodsId = $request->input('goods_id');

        try {
            // 3. 调用 AffiliateCodeService 获取最优优惠码
            /** @var \App\Service\AffiliateCodeService $affiliateService */
            $affiliateService = app('Service\AffiliateCodeService');
            $bestCoupon = $affiliateService->getBestCouponByAffiliateCode($affCode, $goodsId);

            // 4. 根据结果返回响应
            if ($bestCoupon) {
                // 找到了适用的优惠码
                return response()->json([
                    'success' => true,
                    'coupon_code' => $bestCoupon->coupon,
                    'discount' => (float) $bestCoupon->discount,
                    'message' => '已自动应用优惠金额最大的优惠码',
                ]);
            } else {
                // 推广码无效或不适用于当前商品
                return response()->json([
                    'success' => false,
                    'message' => '推广码无效或不适用于当前商品',
                ]);
            }
        } catch (\Exception $e) {
            // 5. 异常处理
            // 记录错误日志（实际生产环境中应该使用 Log 门面）
            \Log::error('[AffiliateController] 获取优惠码失败', [
                'aff' => $affCode,
                'goods_id' => $goodsId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // 返回通用错误信息（不暴露内部错误细节）
            return response()->json([
                'success' => false,
                'message' => '系统错误，请稍后重试',
            ], 500);
        }
    }
}
