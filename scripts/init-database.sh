#!/bin/bash
# 数据库初始化脚本
# 用途：导入 install.sql 并验证数据库表

set -e

GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m'

MYSQL_CONTAINER="dujiaoka-mysql"
MYSQL_USER="root"
MYSQL_PASSWORD="root123456"
MYSQL_DATABASE="dujiaoka"

echo -e "${YELLOW}================================================${NC}"
echo -e "${YELLOW}  数据库初始化脚本${NC}"
echo -e "${YELLOW}================================================${NC}"
echo ""

# 检查容器是否运行
echo -e "${YELLOW}步骤1: 检查MySQL容器状态...${NC}"
if ! docker ps | grep -q "$MYSQL_CONTAINER"; then
    echo -e "${RED}错误: MySQL容器未运行${NC}"
    echo "请先启动容器: docker-compose up -d"
    exit 1
fi
echo -e "${GREEN}✓ MySQL容器运行中${NC}"
echo ""

# 导入 install.sql
echo -e "${YELLOW}步骤2: 导入 install.sql...${NC}"
if [ ! -f "database/sql/install.sql" ]; then
    echo -e "${RED}错误: database/sql/install.sql 文件不存在${NC}"
    exit 1
fi

docker exec -i $MYSQL_CONTAINER mysql -u$MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE < database/sql/install.sql
echo -e "${GREEN}✓ install.sql 导入完成${NC}"
echo ""

# 导入 aff 菜单
echo -e "${YELLOW}步骤3: 导入推广码菜单...${NC}"
docker exec -i $MYSQL_CONTAINER mysql -u$MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE < database/sql/migrate_affiliate_menu.sql
echo -e "${GREEN}✓ 推广码菜单导入完成${NC}"
echo ""

# 验证表数量
echo -e "${YELLOW}步骤4: 验证数据库表...${NC}"
FINAL_COUNT=$(docker exec -i $MYSQL_CONTAINER mysql -u$MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE -sN -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$MYSQL_DATABASE';")
echo "数据库表数量: $FINAL_COUNT"
echo ""

# 清除 Laravel 缓存
echo -e "${YELLOW}步骤5: 清除Laravel缓存...${NC}"
docker exec dujiaoka php artisan config:clear
docker exec dujiaoka php artisan cache:clear
docker exec dujiaoka php artisan view:clear
echo -e "${GREEN}✓ 缓存清除完成${NC}"
echo ""

echo -e "${GREEN}================================================${NC}"
echo -e "${GREEN}  数据库初始化成功！${NC}"
echo -e "${GREEN}================================================${NC}"
echo ""
echo "下一步："
echo "1. 访问 http://localhost:8080/admin"
echo "2. 默认账号: admin"
echo "3. 默认密码: admin"
echo ""
echo "推广码管理菜单位置: 优惠管理 → 推广码管理"
