#!/bin/bash

# 推广码系统 - 生产环境部署脚本
# 使用方法：bash deploy-affiliate-production.sh
# 功能：零停机部署，自动备份，失败自动回滚

set -e

# 颜色定义
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m'

# 时间戳
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

# 备份目录
BACKUP_DIR="../backups"
mkdir -p "$BACKUP_DIR"

# 日志文件
LOG_FILE="deploy_${TIMESTAMP}.log"

# 日志函数
log() {
    echo -e "$1" | tee -a "$LOG_FILE"
}

log_success() {
    log "${GREEN}✓ $1${NC}"
}

log_warning() {
    log "${YELLOW}⚠ $1${NC}"
}

log_error() {
    log "${RED}✗ $1${NC}"
}

log_info() {
    log "${BLUE}ℹ $1${NC}"
}

# 错误处理
handle_error() {
    log_error "部署失败！错误发生在: $1"
    log_warning "开始回滚..."
    rollback
    exit 1
}

trap 'handle_error "$BASH_COMMAND"' ERR

# 回滚函数
rollback() {
    log_info "正在回滚..."

    # 如果开启了维护模式，先关闭
    php artisan up 2>/dev/null || true

    # 恢复数据库
    if [ -f "$BACKUP_DIR/db_backup_${TIMESTAMP}.sql" ]; then
        log_info "恢复数据库..."
        mysql -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" < "$BACKUP_DIR/db_backup_${TIMESTAMP}.sql"
        log_success "数据库已恢复"
    fi

    # 恢复代码（如果有 Git）
    if [ -d ".git" ]; then
        log_info "恢复代码..."
        git reset --hard HEAD 2>/dev/null || true
    fi

    # 清除缓存
    php artisan cache:clear 2>/dev/null || true
    php artisan config:clear 2>/dev/null || true
    php artisan route:clear 2>/dev/null || true

    log_error "回滚完成，系统已恢复到部署前状态"
}

# ===================================
# 开始部署
# ===================================

log "========================================="
log "  推广码系统 - 生产环境部署"
log "  时间: $(date '+%Y-%m-%d %H:%M:%S')"
log "========================================="
echo ""

# ===================================
# 1. 环境检查
# ===================================

log_info "【步骤 1/10】环境检查"

# 检查是否在项目根目录
if [ ! -f "artisan" ]; then
    log_error "错误: 请在项目根目录执行此脚本"
    exit 1
fi

# 检查 PHP 版本
PHP_VERSION=$(php -r "echo PHP_VERSION;")
log_info "PHP 版本: $PHP_VERSION"

# 检查 Laravel 版本
LARAVEL_VERSION=$(php artisan --version | grep -oP '\d+\.\d+\.\d+' || echo "unknown")
log_info "Laravel 版本: $LARAVEL_VERSION"

# 读取数据库配置
DB_DATABASE=$(grep "^DB_DATABASE=" .env | cut -d '=' -f2)
DB_USERNAME=$(grep "^DB_USERNAME=" .env | cut -d '=' -f2)
DB_PASSWORD=$(grep "^DB_PASSWORD=" .env | cut -d '=' -f2)

if [ -z "$DB_DATABASE" ] || [ -z "$DB_USERNAME" ]; then
    log_error "数据库配置不完整，请检查 .env 文件"
    exit 1
fi

log_info "数据库: $DB_DATABASE"

# 测试数据库连接
log_info "测试数据库连接..."
if ! php artisan db:monitor --databases=mysql > /dev/null 2>&1; then
    log_error "数据库连接失败，请检查配置"
    exit 1
fi
log_success "数据库连接正常"

echo ""

# ===================================
# 2. 部署确认
# ===================================

log_info "【步骤 2/10】部署确认"

log_warning "此操作将部署推广码功能到生产环境"
log_info "操作包括："
log_info "  • 备份数据库"
log_info "  • 创建新表（affiliate_codes, affiliate_codes_coupons）"
log_info "  • 添加管理菜单"
log_info "  • 清除缓存"
echo ""

read -p "确认继续部署？[y/N]: " confirm
if [ "$confirm" != "y" ] && [ "$confirm" != "Y" ]; then
    log_warning "部署已取消"
    exit 0
fi

echo ""

# ===================================
# 3. 数据库备份
# ===================================

log_info "【步骤 3/10】数据库备份"

BACKUP_FILE="$BACKUP_DIR/db_backup_${TIMESTAMP}.sql"
log_info "备份文件: $BACKUP_FILE"

mysqldump -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" > "$BACKUP_FILE"

BACKUP_SIZE=$(du -h "$BACKUP_FILE" | cut -f1)
log_success "数据库备份完成 (大小: $BACKUP_SIZE)"

echo ""

# ===================================
# 4. 代码备份（如果使用 Git）
# ===================================

log_info "【步骤 4/10】代码备份"

if [ -d ".git" ]; then
    CURRENT_COMMIT=$(git rev-parse HEAD)
    CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD)
    log_info "当前分支: $CURRENT_BRANCH"
    log_info "当前提交: $CURRENT_COMMIT"

    # 创建备份标签
    git tag "backup-before-affiliate-${TIMESTAMP}" 2>/dev/null || true
    log_success "已创建备份标签: backup-before-affiliate-${TIMESTAMP}"
else
    # 如果不使用 Git，创建文件备份
    BACKUP_TAR="$BACKUP_DIR/code_backup_${TIMESTAMP}.tar.gz"
    log_info "创建代码备份..."
    tar -czf "$BACKUP_TAR" --exclude='vendor' --exclude='node_modules' --exclude='storage/logs' .
    log_success "代码备份完成: $BACKUP_TAR"
fi

echo ""

# ===================================
# 5. 检查必要文件
# ===================================

log_info "【步骤 5/10】检查部署文件"

REQUIRED_FILES=(
    "database/migrations/2026_01_11_000001_create_affiliate_codes_tables.php"
    "database/sql/add_affiliate_code_menu.sql"
    "app/Models/AffiliateCode.php"
    "app/Service/AffiliateCodeService.php"
    "app/Http/Controllers/Api/AffiliateController.php"
    "app/Admin/Repositories/AffiliateCode.php"
    "app/Admin/Controllers/AffiliateCodeController.php"
)

MISSING_FILES=0
for file in "${REQUIRED_FILES[@]}"; do
    if [ ! -f "$file" ]; then
        log_error "缺少文件: $file"
        MISSING_FILES=$((MISSING_FILES + 1))
    else
        log_success "✓ $file"
    fi
done

if [ $MISSING_FILES -gt 0 ]; then
    log_error "缺少 $MISSING_FILES 个必要文件，请先上传完整代码"
    exit 1
fi

log_success "所有必要文件已就绪"

echo ""

# ===================================
# 6. 开启维护模式（可选）
# ===================================

log_info "【步骤 6/10】维护模式"

read -p "是否开启维护模式？（建议首次部署开启）[y/N]: " maintenance
if [ "$maintenance" = "y" ] || [ "$maintenance" = "Y" ]; then
    php artisan down --message="系统升级中，预计5分钟" --retry=60
    log_warning "维护模式已开启"
    MAINTENANCE_ENABLED=true
else
    log_info "跳过维护模式，继续零停机部署"
    MAINTENANCE_ENABLED=false
fi

echo ""

# ===================================
# 7. 数据库迁移
# ===================================

log_info "【步骤 7/10】数据库迁移"

# 检查表是否已存在
TABLE_EXISTS=$(php artisan tinker --execute="echo Schema::hasTable('affiliate_codes') ? 'yes' : 'no';" 2>/dev/null | tail -1)

if [ "$TABLE_EXISTS" = "yes" ]; then
    log_warning "推广码表已存在，跳过迁移"
else
    log_info "执行数据库迁移..."
    php artisan migrate --path=database/migrations/2026_01_11_000001_create_affiliate_codes_tables.php --force
    log_success "数据库迁移完成"

    # 验证表创建
    TABLE_EXISTS=$(php artisan tinker --execute="echo Schema::hasTable('affiliate_codes') ? 'yes' : 'no';" 2>/dev/null | tail -1)
    if [ "$TABLE_EXISTS" != "yes" ]; then
        log_error "表创建失败"
        exit 1
    fi
    log_success "表创建验证成功"
fi

echo ""

# ===================================
# 8. 导入管理菜单
# ===================================

log_info "【步骤 8/10】导入管理菜单"

# 检查菜单是否已存在
MENU_EXISTS=$(mysql -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -se "SELECT COUNT(*) FROM admin_menu WHERE uri='/affiliate-code';" 2>/dev/null || echo "0")

if [ "$MENU_EXISTS" -gt "0" ]; then
    log_warning "管理菜单已存在，跳过导入"
else
    log_info "导入管理菜单..."
    mysql -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" < database/sql/add_affiliate_code_menu.sql
    log_success "管理菜单导入完成"
fi

echo ""

# ===================================
# 9. 清除缓存
# ===================================

log_info "【步骤 9/10】清除缓存"

log_info "清除配置缓存..."
php artisan config:clear
log_success "配置缓存已清除"

log_info "清除路由缓存..."
php artisan route:clear
log_success "路由缓存已清除"

log_info "清除视图缓存..."
php artisan view:clear
log_success "视图缓存已清除"

log_info "清除应用缓存..."
php artisan cache:clear
log_success "应用缓存已清除"

log_info "重新生成优化文件..."
php artisan config:cache
php artisan route:cache
log_success "优化文件已生成"

# 如果使用 Opcache，提示重启 PHP-FPM
log_warning "建议重启 PHP-FPM 以清除 OPcache："
log_warning "  sudo systemctl restart php-fpm"
log_warning "  或: sudo service php7.4-fpm restart"

echo ""

# ===================================
# 10. 关闭维护模式
# ===================================

log_info "【步骤 10/10】关闭维护模式"

if [ "$MAINTENANCE_ENABLED" = true ]; then
    php artisan up
    log_success "维护模式已关闭"
else
    log_info "未开启维护模式，跳过"
fi

echo ""

# ===================================
# 部署验证
# ===================================

log_info "========================================="
log_info "  部署验证"
log_info "========================================="
echo ""

# 验证路由
log_info "验证路由注册..."
ROUTE_COUNT=$(php artisan route:list | grep -c affiliate || echo "0")
if [ "$ROUTE_COUNT" -gt "0" ]; then
    log_success "路由已注册 (共 $ROUTE_COUNT 个)"
else
    log_error "路由未注册"
    exit 1
fi

# 验证服务
log_info "验证服务注册..."
SERVICE_BOUND=$(php artisan tinker --execute="echo app()->bound('Service\\AffiliateCodeService') ? 'yes' : 'no';" 2>/dev/null | tail -1)
if [ "$SERVICE_BOUND" = "yes" ]; then
    log_success "服务已注册"
else
    log_error "服务未注册"
    exit 1
fi

echo ""

# ===================================
# 部署完成
# ===================================

log "========================================="
log_success "  部署成功完成！"
log "========================================="
echo ""

log_info "部署摘要："
log_info "  • 备份文件: $BACKUP_FILE"
log_info "  • 日志文件: $LOG_FILE"
log_info "  • 新增表: affiliate_codes, affiliate_codes_coupons"
log_info "  • 新增路由: $ROUTE_COUNT 个"
echo ""

log_info "接下来的步骤："
log_info "  1. 测试管理后台: https://your-domain.com/admin"
log_info "     路径: 优惠码管理 → Affiliate_Code"
echo ""
log_info "  2. 创建测试推广码并验证功能"
echo ""
log_info "  3. 测试 API 接口:"
log_info "     curl \"https://your-domain.com/api/affiliate/coupon?aff=<code>&goods_id=<id>\""
echo ""
log_info "  4. 监控日志:"
log_info "     tail -f storage/logs/laravel.log | grep -i affiliate"
echo ""

log_warning "重要提醒："
log_warning "  • 建议重启 PHP-FPM: sudo systemctl restart php-fpm"
log_warning "  • 完成功能测试后再通知用户使用"
log_warning "  • 保留备份文件至少 7 天"
echo ""

log_info "详细文档："
log_info "  📖 部署指南: PRODUCTION_DEPLOYMENT.md"
log_info "  🧪 测试指南: docs/affiliate-system-testing-guide.md"
log_info "  📡 API 文档: docs/api/affiliate-api.md"
echo ""

log "========================================="
log_success "祝业务蒸蒸日上！🚀"
log "========================================="
