#!/bin/bash

# ============================================
# 依赖安装脚本
# 功能：安装 Composer 依赖
# ============================================

# 颜色定义
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# 项目根目录
PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"

# 打印分隔线
print_separator() {
    echo -e "${BLUE}================================================${NC}"
}

# 打印成功信息
print_success() {
    echo -e "${GREEN}✓${NC} $1"
}

# 打印错误信息
print_error() {
    echo -e "${RED}✗${NC} $1"
}

# 打印警告信息
print_warning() {
    echo -e "${YELLOW}⚠${NC} $1"
}

# 打印信息
print_info() {
    echo -e "${BLUE}ℹ${NC} $1"
}

# 检查 composer 是否安装
check_composer() {
    if ! command -v composer >/dev/null 2>&1; then
        print_error "Composer 未安装"
        echo "  请运行: brew install composer"
        return 1
    fi
    return 0
}

# 安装 Composer 依赖
install_composer_deps() {
    print_info "安装 Composer 依赖..."

    # 检查 composer.json 是否存在
    if [ ! -f "$PROJECT_ROOT/composer.json" ]; then
        print_error "composer.json 文件不存在"
        return 1
    fi

    # 检查 vendor 目录是否已存在
    if [ -d "$PROJECT_ROOT/vendor" ]; then
        print_warning "vendor 目录已存在"
        read -p "是否重新安装依赖？(y/N): " -n 1 -r
        echo
        if [[ ! $REPLY =~ ^[Yy]$ ]]; then
            print_info "跳过依赖安装"
            return 0
        fi
    fi

    # 执行 composer install
    cd "$PROJECT_ROOT"

    print_info "正在执行 composer install，这可能需要几分钟..."
    composer install --no-interaction --prefer-dist --optimize-autoloader

    if [ $? -eq 0 ]; then
        print_success "Composer 依赖安装成功"
        return 0
    else
        print_error "Composer 依赖安装失败"
        print_warning "尝试使用 --ignore-platform-reqs 选项..."

        # 如果失败，尝试忽略平台要求
        composer install --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs

        if [ $? -eq 0 ]; then
            print_success "Composer 依赖安装成功（已忽略平台要求）"
            print_warning "某些依赖可能与您的 PHP 版本不完全匹配，请注意测试"
            return 0
        else
            print_error "Composer 依赖安装失败"
            return 1
        fi
    fi
}

# 检查已安装的依赖
check_installed_packages() {
    print_info "检查已安装的核心依赖..."

    cd "$PROJECT_ROOT"

    # 核心依赖包列表
    CORE_PACKAGES=("laravel/framework" "encore/laravel-admin")

    for package in "${CORE_PACKAGES[@]}"; do
        if composer show "$package" >/dev/null 2>&1; then
            VERSION=$(composer show "$package" 2>/dev/null | grep 'versions' | awk '{print $3}')
            print_success "$package $VERSION"
        else
            print_warning "$package 未安装"
        fi
    done
}

# 优化自动加载
optimize_autoload() {
    print_info "优化自动加载..."

    cd "$PROJECT_ROOT"
    composer dump-autoload --optimize >/dev/null 2>&1

    if [ $? -eq 0 ]; then
        print_success "自动加载优化完成"
    else
        print_warning "自动加载优化失败"
    fi
}

# 创建必要的目录
create_directories() {
    print_info "创建必要的目录..."

    # 需要创建的目录列表
    DIRS=(
        "$PROJECT_ROOT/storage/app/public"
        "$PROJECT_ROOT/storage/framework/cache"
        "$PROJECT_ROOT/storage/framework/sessions"
        "$PROJECT_ROOT/storage/framework/views"
        "$PROJECT_ROOT/storage/logs"
        "$PROJECT_ROOT/bootstrap/cache"
        "$PROJECT_ROOT/public/uploads"
    )

    for dir in "${DIRS[@]}"; do
        if [ ! -d "$dir" ]; then
            mkdir -p "$dir"
            print_success "创建目录: ${dir#$PROJECT_ROOT/}"
        fi
    done
}

# 主函数
main() {
    echo ""
    print_separator
    echo -e "${BLUE}📦 开始安装依赖...${NC}"
    print_separator
    echo ""

    # 检查 Composer 是否安装
    check_composer
    if [ $? -ne 0 ]; then
        return 1
    fi
    echo ""

    # 安装 Composer 依赖
    install_composer_deps
    if [ $? -ne 0 ]; then
        print_error "依赖安装失败"
        return 1
    fi
    echo ""

    # 检查已安装的依赖
    check_installed_packages
    echo ""

    # 优化自动加载
    optimize_autoload
    echo ""

    # 创建必要的目录
    create_directories
    echo ""

    print_separator
    echo -e "${GREEN}✅ 依赖安装完成！${NC}"
    print_separator

    return 0
}

# 执行主函数
main
