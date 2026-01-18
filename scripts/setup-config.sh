#!/bin/bash

# ============================================
# 配置设置脚本
# 功能：设置 .env 配置、生成应用密钥、创建软链接
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

# 设置 .env 文件
setup_env() {
    print_info "设置 .env 配置文件..."

    # 检查 .env 是否已存在
    if [ -f "$PROJECT_ROOT/.env" ]; then
        print_warning ".env 文件已存在"
        read -p "是否覆盖现有的 .env 文件？(y/N): " -n 1 -r
        echo
        if [[ ! $REPLY =~ ^[Yy]$ ]]; then
            print_info "跳过 .env 文件设置"
            return 0
        fi
    fi

    # 检查 .env.example 是否存在
    if [ ! -f "$PROJECT_ROOT/.env.example" ]; then
        print_error ".env.example 文件不存在"
        return 1
    fi

    # 复制 .env.example 到 .env
    cp "$PROJECT_ROOT/.env.example" "$PROJECT_ROOT/.env"

    if [ $? -eq 0 ]; then
        print_success ".env 文件创建成功"

        # 提示用户修改数据库配置
        print_info "请根据您的环境修改以下配置："
        echo "  - DB_HOST (数据库主机)"
        echo "  - DB_PORT (数据库端口)"
        echo "  - DB_DATABASE (数据库名)"
        echo "  - DB_USERNAME (数据库用户名)"
        echo "  - DB_PASSWORD (数据库密码)"
        echo "  - REDIS_HOST (Redis 主机)"
        echo "  - REDIS_PORT (Redis 端口)"
    else
        print_error ".env 文件创建失败"
        return 1
    fi
}

# 生成应用密钥
generate_app_key() {
    print_info "生成应用密钥..."

    # 检查 .env 是否存在
    if [ ! -f "$PROJECT_ROOT/.env" ]; then
        print_error ".env 文件不存在，请先运行 setup_env"
        return 1
    fi

    # 检查是否已有应用密钥
    if grep -q "APP_KEY=base64:" "$PROJECT_ROOT/.env"; then
        print_warning "应用密钥已存在"
        read -p "是否重新生成应用密钥？(y/N): " -n 1 -r
        echo
        if [[ ! $REPLY =~ ^[Yy]$ ]]; then
            print_info "跳过应用密钥生成"
            return 0
        fi
    fi

    # 生成密钥
    cd "$PROJECT_ROOT"
    php artisan key:generate

    if [ $? -eq 0 ]; then
        print_success "应用密钥生成成功"
    else
        print_error "应用密钥生成失败"
        return 1
    fi
}

# 创建存储软链接
create_storage_link() {
    print_info "创建存储目录软链接..."

    # 检查软链接是否已存在
    if [ -L "$PROJECT_ROOT/public/storage" ]; then
        print_warning "存储软链接已存在"
        return 0
    fi

    # 创建软链接
    cd "$PROJECT_ROOT"
    php artisan storage:link

    if [ $? -eq 0 ]; then
        print_success "存储软链接创建成功"
    else
        print_error "存储软链接创建失败"
        return 1
    fi
}

# 设置目录权限
set_permissions() {
    print_info "设置目录权限..."

    # 设置 storage 目录权限
    if [ -d "$PROJECT_ROOT/storage" ]; then
        chmod -R 777 "$PROJECT_ROOT/storage"
        print_success "storage 目录权限设置完成"
    else
        print_warning "storage 目录不存在"
    fi

    # 设置 bootstrap/cache 目录权限
    if [ -d "$PROJECT_ROOT/bootstrap/cache" ]; then
        chmod -R 777 "$PROJECT_ROOT/bootstrap/cache"
        print_success "bootstrap/cache 目录权限设置完成"
    else
        print_warning "bootstrap/cache 目录不存在"
    fi

    # 设置 public/uploads 目录权限（如果存在）
    if [ -d "$PROJECT_ROOT/public/uploads" ]; then
        chmod -R 777 "$PROJECT_ROOT/public/uploads"
        print_success "public/uploads 目录权限设置完成"
    else
        # 创建 uploads 目录
        mkdir -p "$PROJECT_ROOT/public/uploads"
        chmod -R 777 "$PROJECT_ROOT/public/uploads"
        print_success "public/uploads 目录创建并设置权限完成"
    fi
}

# 清除缓存
clear_cache() {
    print_info "清除应用缓存..."

    cd "$PROJECT_ROOT"
    php artisan optimize:clear >/dev/null 2>&1

    if [ $? -eq 0 ]; then
        print_success "缓存清除成功"
    else
        print_warning "缓存清除失败（可能是首次运行）"
    fi
}

# 主函数
main() {
    echo ""
    print_separator
    echo -e "${BLUE}⚙️  开始配置设置...${NC}"
    print_separator
    echo ""

    # 执行各个步骤
    setup_env
    if [ $? -ne 0 ]; then
        print_error "配置设置失败"
        return 1
    fi
    echo ""

    generate_app_key
    echo ""

    create_storage_link
    echo ""

    set_permissions
    echo ""

    clear_cache
    echo ""

    print_separator
    echo -e "${GREEN}✅ 配置设置完成！${NC}"
    print_separator

    return 0
}

# 执行主函数
main
