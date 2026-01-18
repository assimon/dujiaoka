#!/bin/bash

# ============================================
# 独角数卡 - 项目初始化主脚本
# 功能：一键初始化开发环境
# ============================================

# 颜色定义
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
MAGENTA='\033[0;35m'
NC='\033[0m' # No Color

# 项目根目录
PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
SCRIPTS_DIR="$PROJECT_ROOT/scripts"

# 打印横幅
print_banner() {
    echo ""
    echo -e "${CYAN}╔════════════════════════════════════════════╗${NC}"
    echo -e "${CYAN}║                                            ║${NC}"
    echo -e "${CYAN}║      ${MAGENTA}独角数卡 - 项目初始化脚本${CYAN}          ║${NC}"
    echo -e "${CYAN}║                                            ║${NC}"
    echo -e "${CYAN}║      ${BLUE}Dujiaoka Project Initialization${CYAN}     ║${NC}"
    echo -e "${CYAN}║                                            ║${NC}"
    echo -e "${CYAN}╚════════════════════════════════════════════╝${NC}"
    echo ""
}

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

# 打印步骤标题
print_step() {
    echo ""
    echo -e "${MAGENTA}▶ $1${NC}"
    print_separator
}

# 检查脚本文件是否存在
check_scripts() {
    print_info "检查初始化脚本..."

    REQUIRED_SCRIPTS=(
        "$SCRIPTS_DIR/check-env.sh"
        "$SCRIPTS_DIR/setup-config.sh"
        "$SCRIPTS_DIR/install-deps.sh"
        "$SCRIPTS_DIR/init-database.sh"
    )

    for script in "${REQUIRED_SCRIPTS[@]}"; do
        if [ ! -f "$script" ]; then
            print_error "脚本文件不存在: $script"
            return 1
        fi
    done

    print_success "所有脚本文件就绪"
    return 0
}

# 显示初始化步骤
show_steps() {
    echo ""
    print_info "即将执行以下步骤："
    echo ""
    echo "  1️⃣  环境检查 - 验证 PHP、MySQL、Redis、Composer"
    echo "  2️⃣  依赖安装 - 安装 Composer 包和创建必要目录"
    echo "  3️⃣  配置设置 - 设置 .env 文件和应用密钥"
    echo "  4️⃣  数据库初始化 - 创建数据库并导入数据"
    echo ""
}

# 确认执行
confirm_execution() {
    read -p "是否继续执行项目初始化？(Y/n): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Nn]$ ]]; then
        print_warning "用户取消初始化"
        return 1
    fi
    return 0
}

# 执行环境检查
run_env_check() {
    print_step "步骤 1/4: 环境检查"

    bash "$SCRIPTS_DIR/check-env.sh"
    local exit_code=$?

    if [ $exit_code -ne 0 ]; then
        print_error "环境检查失败，请先解决上述问题"
        return 1
    fi

    return 0
}

# 执行依赖安装
run_install_deps() {
    print_step "步骤 2/4: 安装依赖"

    bash "$SCRIPTS_DIR/install-deps.sh"
    local exit_code=$?

    if [ $exit_code -ne 0 ]; then
        print_error "依赖安装失败"
        return 1
    fi

    return 0
}

# 执行配置设置
run_setup_config() {
    print_step "步骤 3/4: 配置设置"

    bash "$SCRIPTS_DIR/setup-config.sh"
    local exit_code=$?

    if [ $exit_code -ne 0 ]; then
        print_error "配置设置失败"
        return 1
    fi

    return 0
}

# 执行数据库初始化
run_init_database() {
    print_step "步骤 4/4: 数据库初始化"

    bash "$SCRIPTS_DIR/init-database.sh"
    local exit_code=$?

    if [ $exit_code -ne 0 ]; then
        print_error "数据库初始化失败"
        return 1
    fi

    return 0
}

# 显示完成信息
show_completion() {
    echo ""
    print_separator
    echo -e "${GREEN}🎉 项目初始化完成！${NC}"
    print_separator
    echo ""

    print_info "下一步操作："
    echo ""
    echo "  1. 启动开发服务器："
    echo "     ${CYAN}php artisan serve${NC}"
    echo ""
    echo "  2. 访问应用："
    echo "     前台: ${CYAN}http://localhost:8000${NC}"
    echo "     后台: ${CYAN}http://localhost:8000/admin${NC}"
    echo ""
    echo "  3. 默认管理员账号："
    echo "     用户名: ${CYAN}admin${NC}"
    echo "     密码: ${CYAN}admin${NC}"
    echo ""
    print_warning "请在首次登录后立即修改默认密码！"
    echo ""

    print_info "其他有用的命令："
    echo "  清除缓存: ${CYAN}php artisan optimize:clear${NC}"
    echo "  查看路由: ${CYAN}php artisan route:list${NC}"
    echo "  运行队列: ${CYAN}php artisan queue:work${NC}"
    echo ""

    print_separator
}

# 显示失败信息
show_failure() {
    echo ""
    print_separator
    echo -e "${RED}❌ 项目初始化失败${NC}"
    print_separator
    echo ""

    print_info "故障排查："
    echo "  1. 查看上方错误信息"
    echo "  2. 检查环境配置是否正确"
    echo "  3. 确保 MySQL 和 Redis 服务运行中"
    echo "  4. 查看日志文件: ${CYAN}storage/logs/laravel.log${NC}"
    echo ""

    print_info "手动执行各个步骤："
    echo "  环境检查: ${CYAN}bash scripts/check-env.sh${NC}"
    echo "  安装依赖: ${CYAN}bash scripts/install-deps.sh${NC}"
    echo "  配置设置: ${CYAN}bash scripts/setup-config.sh${NC}"
    echo "  数据库初始化: ${CYAN}bash scripts/init-database.sh${NC}"
    echo ""

    print_separator
}

# 主函数
main() {
    # 显示横幅
    print_banner

    # 检查脚本文件
    check_scripts
    if [ $? -ne 0 ]; then
        exit 1
    fi

    # 显示步骤
    show_steps

    # 确认执行
    confirm_execution
    if [ $? -ne 0 ]; then
        exit 0
    fi

    echo ""
    print_separator
    echo -e "${BLUE}开始初始化项目...${NC}"
    print_separator

    # 执行各个步骤
    run_env_check || { show_failure; exit 1; }
    run_install_deps || { show_failure; exit 1; }
    run_setup_config || { show_failure; exit 1; }
    run_init_database || { show_failure; exit 1; }

    # 显示完成信息
    show_completion

    exit 0
}

# 执行主函数
main
