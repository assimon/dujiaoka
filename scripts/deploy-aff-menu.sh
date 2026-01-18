#!/bin/bash
# aff推广码菜单部署脚本（Docker环境）
# 用途：在Docker环境中部署推广码管理菜单

set -e  # 遇到错误立即退出

echo "================================================"
echo "  aff推广码管理菜单部署脚本（Docker版）"
echo "================================================"
echo ""

# 颜色定义
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# 容器名称
WEB_CONTAINER="dujiaoka"
MYSQL_CONTAINER="dujiaoka-mysql"
MYSQL_USER="root"
MYSQL_PASSWORD="root123456"
MYSQL_DATABASE="dujiaoka"

echo -e "${YELLOW}步骤1: 检查Docker容器状态...${NC}"
if ! docker ps | grep -q "$WEB_CONTAINER"; then
    echo -e "${RED}错误: Web容器 $WEB_CONTAINER 未运行${NC}"
    exit 1
fi

if ! docker ps | grep -q "$MYSQL_CONTAINER"; then
    echo -e "${RED}错误: MySQL容器 $MYSQL_CONTAINER 未运行${NC}"
    exit 1
fi
echo -e "${GREEN}✓ 容器状态正常${NC}"
echo ""

echo -e "${YELLOW}步骤2: 备份现有菜单数据...${NC}"
docker exec $MYSQL_CONTAINER mysqldump -u$MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE admin_menu > backup_admin_menu_$(date +%Y%m%d_%H%M%S).sql
echo -e "${GREEN}✓ 备份完成${NC}"
echo ""

echo -e "${YELLOW}步骤3: 执行菜单迁移SQL...${NC}"
docker exec -i $MYSQL_CONTAINER mysql -u$MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE <<EOF
-- 清理可能存在的旧记录
DELETE FROM admin_menu WHERE id = 26 OR (parent_id = 18 AND uri = '/affiliate-code');

-- 添加推广码菜单
INSERT INTO admin_menu (id, parent_id, \`order\`, title, icon, uri, extension, \`show\`, created_at, updated_at)
VALUES (26, 18, 17, 'Affiliate_Code', 'fa-share-alt', '/affiliate-code', '', 1, NOW(), NOW());

-- 验证插入
SELECT id, parent_id, title, uri, created_at FROM admin_menu WHERE uri = '/affiliate-code';
EOF
echo -e "${GREEN}✓ 菜单迁移完成${NC}"
echo ""

echo -e "${YELLOW}步骤4: 清除Laravel缓存...${NC}"
docker exec $WEB_CONTAINER php artisan config:clear
docker exec $WEB_CONTAINER php artisan cache:clear
docker exec $WEB_CONTAINER php artisan view:clear
echo -e "${GREEN}✓ 缓存清除完成${NC}"
echo ""

echo -e "${YELLOW}步骤5: 验证菜单是否生效...${NC}"
MENU_COUNT=$(docker exec -i $MYSQL_CONTAINER mysql -u$MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE -sN -e "SELECT COUNT(*) FROM admin_menu WHERE uri = '/affiliate-code';")

if [ "$MENU_COUNT" -eq "1" ]; then
    echo -e "${GREEN}✓ 菜单验证成功！${NC}"
    echo ""
    echo -e "${GREEN}================================================${NC}"
    echo -e "${GREEN}  部署成功！${NC}"
    echo -e "${GREEN}================================================${NC}"
    echo ""
    echo "请访问后台验证："
    echo "1. 访问 http://localhost:8080/admin"
    echo "2. 查看菜单：优惠管理 → 推广码管理"
    echo "3. 点击进入验证CRUD功能"
    echo ""
    echo "备份文件位置: backup_admin_menu_*.sql"
else
    echo -e "${RED}✗ 菜单验证失败，请检查数据库${NC}"
    exit 1
fi
