#!/bin/bash

# ============================================
# 环境检查脚本
# 功能：检查 PHP、MySQL、Redis、Composer 等环境
# ============================================

# 颜色定义
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# 错误计数器
ERROR_COUNT=0

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
    ((ERROR_COUNT++))
}

# 打印警告信息
print_warning() {
    echo -e "${YELLOW}⚠${NC} $1"
}

# 打印信息
print_info() {
    echo -e "${BLUE}ℹ${NC} $1"
}

# 检查命令是否存在
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# 检查 PHP
check_php() {
    print_info "检查 PHP..."

    if ! command_exists php; then
        print_error "PHP 未安装"
        echo "  请运行: brew install shivammathur/php/php@7.4"
        return
    fi

    # 获取 PHP 版本
    PHP_VERSION=$(php -r "echo PHP_VERSION;")
    PHP_MAJOR=$(php -r "echo PHP_MAJOR_VERSION;")
    PHP_MINOR=$(php -r "echo PHP_MINOR_VERSION;")

    print_success "PHP 版本: $PHP_VERSION"

    # 检查版本是否符合要求 (7.4 或 8.0)
    if [[ "$PHP_MAJOR" -eq 7 && "$PHP_MINOR" -ge 4 ]] || [[ "$PHP_MAJOR" -eq 8 && "$PHP_MINOR" -eq 0 ]]; then
        print_success "PHP 版本符合要求 (7.4+ 或 8.0)"
    else
        print_warning "建议使用 PHP 7.4 或 8.0"
    fi

    # 检查必需扩展
    print_info "检查 PHP 扩展..."
    REQUIRED_EXTENSIONS=("fileinfo" "redis" "pdo_mysql" "openssl" "mbstring" "tokenizer" "xml" "ctype" "json" "bcmath")

    for ext in "${REQUIRED_EXTENSIONS[@]}"; do
        if php -m | grep -q "^$ext$"; then
            print_success "扩展 $ext 已安装"
        else
            print_error "扩展 $ext 未安装"
        fi
    done

    # 检查必需函数
    print_info "检查 PHP 函数..."
    REQUIRED_FUNCTIONS=("putenv" "proc_open" "pcntl_signal" "pcntl_alarm")

    for func in "${REQUIRED_FUNCTIONS[@]}"; do
        if php -r "exit(function_exists('$func') ? 0 : 1);" 2>/dev/null; then
            print_success "函数 $func 可用"
        else
            print_error "函数 $func 被禁用或不存在"
        fi
    done
}

# 检查 Composer
check_composer() {
    print_info "检查 Composer..."

    if ! command_exists composer; then
        print_error "Composer 未安装"
        echo "  请运行: brew install composer"
        return
    fi

    COMPOSER_VERSION=$(composer --version 2>/dev/null | grep -oE '[0-9]+\.[0-9]+\.[0-9]+' | head -1)
    print_success "Composer 版本: $COMPOSER_VERSION"
}

# 检查 MySQL
check_mysql() {
    print_info "检查 MySQL..."

    if ! command_exists mysql; then
        print_error "MySQL 客户端未安装"
        echo "  请运行: brew install mysql-client && brew link mysql-client --force"
        return
    fi

    # 检查 Docker 容器中的 MySQL
    if command_exists docker; then
        # 检查 dujiaoka-mysql 容器
        if docker ps --format '{{.Names}}' | grep -q '^dujiaoka-mysql$'; then
            print_success "MySQL 服务运行中 (Docker: dujiaoka-mysql, 端口 3307)"

            # 尝试连接测试 (使用 Docker 容器的端口)
            if mysql -h 127.0.0.1 -P 3307 -udujiaoka -pdujiaoka123456 -e "SELECT 1;" >/dev/null 2>&1; then
                print_success "MySQL 连接正常 (127.0.0.1:3307)"
            else
                print_warning "MySQL 连接失败，请检查容器状态"
            fi
            return
        fi

        # 检查通用 mysql 容器
        if docker ps --format '{{.Names}}' | grep -q '^mysql$'; then
            print_success "MySQL 服务运行中 (Docker: mysql, 端口 3306)"

            # 尝试连接测试
            if mysql -h 127.0.0.1 -P 3306 -uroot -e "SELECT 1;" >/dev/null 2>&1; then
                print_success "MySQL 连接正常 (127.0.0.1:3306)"
            else
                print_warning "MySQL 连接需要密码或有其他问题"
            fi
            return
        fi
    fi

    # 检查 Brew 服务中的 MySQL
    if brew services list | grep mysql | grep -q started; then
        print_success "MySQL 服务运行中 (Brew)"

        # 尝试连接测试
        if mysql -uroot -e "SELECT 1;" >/dev/null 2>&1; then
            print_success "MySQL 连接正常"
        else
            print_warning "MySQL 连接需要密码或有其他问题"
        fi
    else
        print_warning "MySQL 服务未运行"
        echo "  提示: 可使用 Docker 或 brew services start mysql"
    fi
}

# 检查 Redis
check_redis() {
    print_info "检查 Redis..."

    if ! command_exists redis-cli; then
        print_error "Redis 客户端未安装"
        echo "  请运行: brew install redis"
        return
    fi

    # 检查 Docker 容器中的 Redis
    if command_exists docker; then
        # 检查 dujiaoka-redis 容器
        if docker ps --format '{{.Names}}' | grep -q '^dujiaoka-redis$'; then
            print_success "Redis 服务运行中 (Docker: dujiaoka-redis, 端口 6380)"

            # 尝试 PING 测试 (使用 Docker 容器的端口)
            if redis-cli -h 127.0.0.1 -p 6380 ping >/dev/null 2>&1; then
                print_success "Redis 连接正常 (127.0.0.1:6380)"
            else
                print_warning "Redis 连接失败，请检查容器状态"
            fi
            return
        fi

        # 检查通用 redis 容器
        if docker ps --format '{{.Names}}' | grep -q '^redis$'; then
            print_success "Redis 服务运行中 (Docker: redis, 端口 6379)"

            # 尝试 PING 测试
            if redis-cli -h 127.0.0.1 -p 6379 ping >/dev/null 2>&1; then
                print_success "Redis 连接正常 (127.0.0.1:6379)"
            else
                print_warning "Redis 连接失败，请检查容器状态"
            fi
            return
        fi
    fi

    # 检查 Brew 服务中的 Redis
    if brew services list | grep redis | grep -q started; then
        print_success "Redis 服务运行中 (Brew)"

        # 尝试 PING 测试
        if redis-cli ping >/dev/null 2>&1; then
            print_success "Redis 连接正常"
        else
            print_warning "Redis 连接失败"
        fi
    else
        print_warning "Redis 服务未运行"
        echo "  提示: 可使用 Docker 或 brew services start redis"
    fi
}

# 主函数
main() {
    echo ""
    print_separator
    echo -e "${BLUE}🔍 开始环境检查...${NC}"
    print_separator
    echo ""

    check_php
    echo ""

    check_composer
    echo ""

    check_mysql
    echo ""

    check_redis
    echo ""

    print_separator

    # 输出总结
    if [ $ERROR_COUNT -eq 0 ]; then
        echo -e "${GREEN}✅ 环境检查通过！所有依赖项都已就绪。${NC}"
        print_separator
        return 0
    else
        echo -e "${RED}❌ 发现 $ERROR_COUNT 个错误，请先解决上述问题。${NC}"
        print_separator
        return 1
    fi
}

# 执行主函数
main
