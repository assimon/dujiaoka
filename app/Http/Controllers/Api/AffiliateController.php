<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AffiliateCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 推广码 API 控制器
 *
 * 提供推广码相关的公开 API 接口，供前端页面调用。
 * 主要功能：根据推广码查询折扣信息。
 */
class AffiliateController extends Controller
{
    /**
     * 根据推广码获取折扣信息
     *
     * API 端点：GET /api/affiliate/discount
     *
     * 请求参数：
     * - aff: string (required) 推广码
     * - total_price: float (optional) 订单总价，用于预计算折扣金额
     *
     * 成功响应示例：
     * {
     *   "success": true,
     *   "discount_type": 1,
     *   "discount_type_text": "固定金额减免",
     *   "discount_value": 10.00,
     *   "estimated_discount": 10.00,
     *   "message": "推广码有效"
     * }
     *
     * 失败响应示例：
     * {
     *   "success": false,
     *   "message": "推广码无效或已禁用"
     * }
     *
     * @param Request $request HTTP 请求对象
     * @return JsonResponse JSON 响应
     */
    public function getDiscountInfo(Request $request): JsonResponse
    {
        // 1. 验证必填参数
        $validator = \Validator::make($request->all(), [
            'aff' => 'required|string|max:100',
            'total_price' => 'nullable|numeric|min:0',
        ], [
            'aff.required' => '推广码参数 aff 不能为空',
            'aff.string' => '推广码参数 aff 必须是字符串',
            'aff.max' => '推广码参数 aff 长度不能超过100个字符',
            'total_price.numeric' => '总价参数 total_price 必须是数字',
            'total_price.min' => '总价参数 total_price 不能小于0',
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
        $totalPrice = $request->input('total_price', 0);

        try {
            // 3. 调用 AffiliateCodeService 获取折扣信息
            /** @var \App\Service\AffiliateCodeService $affiliateService */
            $affiliateService = app('Service\AffiliateCodeService');
            $affiliateCode = $affiliateService->getAffiliateCodeInfo($affCode);

            // 4. 根据结果返回响应
            if ($affiliateCode) {
                $response = [
                    'success' => true,
                    'discount_type' => $affiliateCode->discount_type,
                    'discount_type_text' => AffiliateCode::getDiscountTypeMap()[$affiliateCode->discount_type],
                    'discount_value' => (float) $affiliateCode->discount_value,
                    'message' => '推广码有效',
                ];

                // 如果提供了总价，计算预估折扣金额
                if ($totalPrice > 0) {
                    $response['estimated_discount'] = $affiliateCode->calculateDiscount($totalPrice);
                }

                return response()->json($response);
            } else {
                // 推广码无效或已禁用
                return response()->json([
                    'success' => false,
                    'message' => '推广码无效或已禁用',
                ]);
            }
        } catch (\Exception $e) {
            // 5. 异常处理
            \Log::error('[AffiliateController] 获取折扣信息失败', [
                'aff' => $affCode,
                'error' => $e->getMessage(),
            ]);

            // 返回通用错误信息（不暴露内部错误细节）
            return response()->json([
                'success' => false,
                'message' => '系统错误，请稍后重试',
            ], 500);
        }
    }
}
