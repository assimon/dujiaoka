#!/bin/bash

# 推广码系统本地调试环境配置脚本
# 使用方法：bash setup-affiliate-debug.sh

set -e

echo "========================================="
echo "  推广码系统 - 本地调试环境配置"
echo "========================================="
echo ""

# 颜色定义
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# 检查 .env 文件
if [ ! -f .env ]; then
    echo -e "${RED}错误: .env 文件不存在${NC}"
    exit 1
fi

# 读取当前数据库配置
DB_DATABASE=$(grep "^DB_DATABASE=" .env | cut -d '=' -f2)
DB_USERNAME=$(grep "^DB_USERNAME=" .env | cut -d '=' -f2)
DB_PASSWORD=$(grep "^DB_PASSWORD=" .env | cut -d '=' -f2)

echo "当前数据库配置："
echo "  数据库名: ${DB_DATABASE:-<未配置>}"
echo "  用户名: ${DB_USERNAME:-<未配置>}"
echo "  密码: ${DB_PASSWORD:-<未配置>}"
echo ""

# 如果数据库配置为空，提示用户配置
if [ -z "$DB_DATABASE" ] || [ -z "$DB_USERNAME" ]; then
    echo -e "${YELLOW}检测到数据库配置为空，请按提示输入：${NC}"
    echo ""

    read -p "数据库名 (推荐: dujiaoka_dev): " input_db
    DB_DATABASE=${input_db:-dujiaoka_dev}

    read -p "数据库用户名 (默认: root): " input_user
    DB_USERNAME=${input_user:-root}

    read -sp "数据库密码: " input_pass
    DB_PASSWORD=$input_pass
    echo ""
    echo ""

    # 更新 .env 文件
    echo -e "${YELLOW}正在更新 .env 文件...${NC}"
    sed -i.bak "s/^DB_DATABASE=.*/DB_DATABASE=$DB_DATABASE/" .env
    sed -i.bak "s/^DB_USERNAME=.*/DB_USERNAME=$DB_USERNAME/" .env
    sed -i.bak "s/^DB_PASSWORD=.*/DB_PASSWORD=$DB_PASSWORD/" .env
    echo -e "${GREEN}✓ .env 文件已更新${NC}"
    echo ""
fi

# 测试数据库连接
echo -e "${YELLOW}正在测试数据库连接...${NC}"
php artisan db:monitor --databases=mysql > /dev/null 2>&1 || {
    echo -e "${RED}✗ 数据库连接失败！${NC}"
    echo ""
    echo "请检查："
    echo "  1. MySQL 服务是否已启动"
    echo "  2. 数据库 '$DB_DATABASE' 是否已创建"
    echo "  3. 用户名和密码是否正确"
    echo ""
    echo "创建数据库命令："
    echo "  mysql -u $DB_USERNAME -p -e \"CREATE DATABASE IF NOT EXISTS $DB_DATABASE CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\""
    echo ""
    exit 1
}
echo -e "${GREEN}✓ 数据库连接成功${NC}"
echo ""

# 检查推广码表是否已存在
echo -e "${YELLOW}正在检查推广码表是否存在...${NC}"
TABLE_EXISTS=$(php artisan tinker --execute="echo \Illuminate\Support\Facades\Schema::hasTable('affiliate_codes') ? 'yes' : 'no';" 2>/dev/null | tail -1)

if [ "$TABLE_EXISTS" = "yes" ]; then
    echo -e "${GREEN}✓ 推广码表已存在${NC}"
    echo ""
    read -p "是否重新运行迁移？(会清空现有数据) [y/N]: " confirm
    if [ "$confirm" = "y" ] || [ "$confirm" = "Y" ]; then
        echo -e "${YELLOW}正在回滚并重新运行迁移...${NC}"
        php artisan migrate:rollback --path=database/migrations/2026_01_11_000001_create_affiliate_codes_tables.php
        php artisan migrate --path=database/migrations/2026_01_11_000001_create_affiliate_codes_tables.php
        echo -e "${GREEN}✓ 迁移完成${NC}"
    fi
else
    echo -e "${YELLOW}正在运行数据库迁移...${NC}"
    php artisan migrate --path=database/migrations/2026_01_11_000001_create_affiliate_codes_tables.php
    echo -e "${GREEN}✓ 数据库迁移完成${NC}"
fi
echo ""

# 导入菜单
echo -e "${YELLOW}正在检查管理菜单...${NC}"
MENU_EXISTS=$(mysql -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -se "SELECT COUNT(*) FROM admin_menu WHERE uri='/affiliate-code';" 2>/dev/null || echo "0")

if [ "$MENU_EXISTS" -gt "0" ]; then
    echo -e "${GREEN}✓ 管理菜单已存在${NC}"
else
    echo -e "${YELLOW}正在导入管理菜单...${NC}"
    mysql -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" < database/sql/add_affiliate_code_menu.sql
    echo -e "${GREEN}✓ 管理菜单导入完成${NC}"
fi
echo ""

# 清除缓存
echo -e "${YELLOW}正在清除缓存...${NC}"
php artisan config:clear > /dev/null
php artisan cache:clear > /dev/null
php artisan route:clear > /dev/null
echo -e "${GREEN}✓ 缓存已清除${NC}"
echo ""

# 显示测试信息
echo "========================================="
echo -e "${GREEN}  环境配置完成！${NC}"
echo "========================================="
echo ""
echo "接下来的步骤："
echo ""
echo "1. 启动开发服务器："
echo "   ${YELLOW}php artisan serve${NC}"
echo ""
echo "2. 访问管理后台创建测试数据："
echo "   地址: http://localhost:8000/admin"
echo "   路径: 优惠码管理 → Affiliate_Code"
echo ""
echo "3. 创建测试优惠码："
echo "   • 在\"优惠码管理\"中创建 3 个优惠码"
echo "   • 例如: DISCOUNT5(5元), SUMMER20(20元), VIP50(50元)"
echo "   • 都关联到同一个商品 (如商品ID=3)"
echo ""
echo "4. 创建推广码："
echo "   • 进入\"Affiliate_Code\"菜单"
echo "   • 点击\"新增\""
echo "   • 多选关联刚才创建的优惠码"
echo "   • 推广码会自动生成 (如: aB3dE5Fg)"
echo ""
echo "5. 测试推广链接："
echo "   访问: ${YELLOW}http://localhost:8000/buy/3?aff=<推广码>${NC}"
echo "   打开浏览器控制台查看日志"
echo ""
echo "详细测试步骤请查看:"
echo "  📄 docs/affiliate-system-testing-guide.md"
echo "  📄 docs/api/affiliate-api.md"
echo ""
echo "========================================="
