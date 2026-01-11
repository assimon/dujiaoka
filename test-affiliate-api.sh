#!/bin/bash

# 推广码 API 快速测试脚本
# 使用方法：bash test-affiliate-api.sh <推广码> <商品ID>

set -e

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m'

# 默认参数
AFF_CODE=${1:-""}
GOODS_ID=${2:-3}
BASE_URL="http://localhost:8000"

echo "========================================="
echo "  推广码 API 快速测试"
echo "========================================="
echo ""

if [ -z "$AFF_CODE" ]; then
    echo -e "${YELLOW}请输入推广码:${NC}"
    read -p "> " AFF_CODE
    echo ""
fi

if [ -z "$AFF_CODE" ]; then
    echo -e "${RED}错误: 推广码不能为空${NC}"
    exit 1
fi

echo "测试参数："
echo "  推广码: $AFF_CODE"
echo "  商品ID: $GOODS_ID"
echo "  API地址: $BASE_URL/api/affiliate/coupon"
echo ""

# 测试 1: 成功获取优惠码
echo -e "${BLUE}=========================================${NC}"
echo -e "${BLUE}测试 1: 获取推广码对应的优惠码${NC}"
echo -e "${BLUE}=========================================${NC}"
echo ""
echo "请求："
echo "  GET $BASE_URL/api/affiliate/coupon?aff=$AFF_CODE&goods_id=$GOODS_ID"
echo ""
echo "响应："

RESPONSE=$(curl -s "$BASE_URL/api/affiliate/coupon?aff=$AFF_CODE&goods_id=$GOODS_ID")
echo "$RESPONSE" | python3 -m json.tool 2>/dev/null || echo "$RESPONSE"

SUCCESS=$(echo "$RESPONSE" | grep -o '"success"[[:space:]]*:[[:space:]]*true' || echo "")

if [ -n "$SUCCESS" ]; then
    echo ""
    echo -e "${GREEN}✓ 测试通过${NC}"

    COUPON_CODE=$(echo "$RESPONSE" | grep -o '"coupon_code"[[:space:]]*:[[:space:]]*"[^"]*"' | cut -d'"' -f4)
    DISCOUNT=$(echo "$RESPONSE" | grep -o '"discount"[[:space:]]*:[[:space:]]*[0-9.]*' | grep -o '[0-9.]*')

    if [ -n "$COUPON_CODE" ]; then
        echo "  优惠码: $COUPON_CODE"
        echo "  优惠金额: $DISCOUNT 元"
    fi
else
    echo ""
    echo -e "${RED}✗ 测试失败${NC}"
fi

echo ""

# 测试 2: 缺少必填参数
echo -e "${BLUE}=========================================${NC}"
echo -e "${BLUE}测试 2: 缺少必填参数 (goods_id)${NC}"
echo -e "${BLUE}=========================================${NC}"
echo ""
echo "请求："
echo "  GET $BASE_URL/api/affiliate/coupon?aff=$AFF_CODE"
echo ""
echo "响应："

RESPONSE2=$(curl -s "$BASE_URL/api/affiliate/coupon?aff=$AFF_CODE")
echo "$RESPONSE2" | python3 -m json.tool 2>/dev/null || echo "$RESPONSE2"

ERROR_MSG=$(echo "$RESPONSE2" | grep -o 'goods_id' || echo "")

if [ -n "$ERROR_MSG" ]; then
    echo ""
    echo -e "${GREEN}✓ 测试通过 (正确返回参数错误)${NC}"
else
    echo ""
    echo -e "${RED}✗ 测试失败 (应该返回参数错误)${NC}"
fi

echo ""

# 测试 3: 无效推广码
echo -e "${BLUE}=========================================${NC}"
echo -e "${BLUE}测试 3: 无效推广码${NC}"
echo -e "${BLUE}=========================================${NC}"
echo ""
echo "请求："
echo "  GET $BASE_URL/api/affiliate/coupon?aff=invalid999&goods_id=$GOODS_ID"
echo ""
echo "响应："

RESPONSE3=$(curl -s "$BASE_URL/api/affiliate/coupon?aff=invalid999&goods_id=$GOODS_ID")
echo "$RESPONSE3" | python3 -m json.tool 2>/dev/null || echo "$RESPONSE3"

FAIL_SUCCESS=$(echo "$RESPONSE3" | grep -o '"success"[[:space:]]*:[[:space:]]*false' || echo "")

if [ -n "$FAIL_SUCCESS" ]; then
    echo ""
    echo -e "${GREEN}✓ 测试通过 (正确返回推广码无效)${NC}"
else
    echo ""
    echo -e "${RED}✗ 测试失败 (应该返回 success: false)${NC}"
fi

echo ""

# 测试 4: 数据库查询
echo -e "${BLUE}=========================================${NC}"
echo -e "${BLUE}测试 4: 查询推广码数据${NC}"
echo -e "${BLUE}=========================================${NC}"
echo ""

php artisan tinker --execute="
\$aff = App\Models\AffiliateCode::where('code', '$AFF_CODE')->with('coupons')->first();
if (\$aff) {
    echo '推广码: ' . \$aff->code . PHP_EOL;
    echo '状态: ' . (\$aff->is_open ? '启用' : '禁用') . PHP_EOL;
    echo '使用次数: ' . \$aff->use_count . PHP_EOL;
    echo '关联优惠码: ' . PHP_EOL;
    foreach (\$aff->coupons as \$coupon) {
        echo '  - ' . \$coupon->coupon . ' (' . \$coupon->discount . '元)' . PHP_EOL;
    }
} else {
    echo '推广码不存在' . PHP_EOL;
}
"

echo ""
echo "========================================="
echo -e "${GREEN}测试完成！${NC}"
echo "========================================="
echo ""
echo "提示："
echo "  • 如果测试 1 失败，请检查推广码是否存在且已启用"
echo "  • 如果测试 1 失败，请检查关联的优惠码是否适用于商品 $GOODS_ID"
echo "  • 详细日志请查看 storage/logs/laravel.log"
echo ""
