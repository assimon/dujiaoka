#!/bin/bash

################################################################################
# Docker MySQL 数据库初始化脚本
#
# 功能：
#   1. 检查 Docker 环境和 MySQL 容器状态
#   2. 创建 dujiaoka 数据库和用户
#   3. 导入初始数据（database/sql/install.sql）
#   4. 验证初始化结果
#
# 使用方法：
#   chmod +x init-docker-mysql.sh
#   ./init-docker-mysql.sh
#
################################################################################

# ============================================================================
# 配置变量
# ============================================================================
CONTAINER_NAME="dujiaoka-mysql"
MYSQL_ROOT_PASSWORD="root123456"
DB_NAME="dujiaoka"
DB_USER="dujiaoka"
DB_PASSWORD="dujiaoka123456"
SQL_FILE="database/sql/install.sql"
DB_CHARSET="utf8mb4"
DB_COLLATE="utf8mb4_unicode_ci"

# ============================================================================
# 颜色定义
# ============================================================================
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# ============================================================================
# 工具函数
# ============================================================================

# 打印成功信息
print_success() {
    echo -e "${GREEN}[✓]${NC} $1"
}

# 打印错误信息
print_error() {
    echo -e "${RED}[✗]${NC} $1"
}

# 打印警告信息
print_warning() {
    echo -e "${YELLOW}[!]${NC} $1"
}

# 打印信息
print_info() {
    echo -e "${BLUE}[i]${NC} $1"
}

# 打印分隔线
print_separator() {
    echo "========================================"
}

# ============================================================================
# 环境检查函数
# ============================================================================

# 检查 Docker 是否运行
check_docker() {
    print_info "检查 Docker 环境..."

    if ! command -v docker &> /dev/null; then
        print_error "Docker 未安装，请先安装 Docker"
        exit 1
    fi

    if ! docker info &> /dev/null; then
        print_error "Docker 未运行，请先启动 Docker"
        exit 1
    fi

    print_success "Docker 环境正常"
}

# 检查 MySQL 容器是否运行
check_container() {
    print_info "检查 MySQL 容器状态..."

    if ! docker ps --format '{{.Names}}' | grep -q "^${CONTAINER_NAME}$"; then
        print_error "MySQL 容器 '${CONTAINER_NAME}' 未运行"
        print_info "提示：使用 'docker-compose up -d mysql' 启动容器"
        exit 1
    fi

    print_success "MySQL 容器运行正常"
}

# 检查 SQL 文件是否存在
check_sql_file() {
    print_info "检查 SQL 初始化文件..."

    if [ ! -f "${SQL_FILE}" ]; then
        print_error "SQL 文件不存在: ${SQL_FILE}"
        exit 1
    fi

    print_success "SQL 文件检查通过"
}

# 测试数据库连接
test_connection() {
    print_info "测试数据库连接..."

    if ! docker exec "${CONTAINER_NAME}" mysql -uroot -p"${MYSQL_ROOT_PASSWORD}" -e "SELECT 1;" &> /dev/null; then
        print_error "无法连接到 MySQL，请检查 root 密码是否正确"
        exit 1
    fi

    print_success "数据库连接正常"
}

# ============================================================================
# 数据库初始化函数
# ============================================================================

# 创建数据库
create_database() {
    print_info "创建数据库 '${DB_NAME}'..."

    # 检查数据库是否已存在
    DB_EXISTS=$(docker exec "${CONTAINER_NAME}" mysql -uroot -p"${MYSQL_ROOT_PASSWORD}" \
        -e "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME='${DB_NAME}';" \
        -sN 2>/dev/null)

    if [ -n "${DB_EXISTS}" ]; then
        print_warning "数据库 '${DB_NAME}' 已存在"

        # 询问是否继续
        read -p "是否删除并重新创建数据库？(y/N): " -n 1 -r
        echo
        if [[ ! $REPLY =~ ^[Yy]$ ]]; then
            print_info "跳过数据库创建，继续后续步骤..."
            return 0
        fi

        # 删除现有数据库
        print_info "删除现有数据库..."
        docker exec "${CONTAINER_NAME}" mysql -uroot -p"${MYSQL_ROOT_PASSWORD}" \
            -e "DROP DATABASE ${DB_NAME};" 2>/dev/null
    fi

    # 创建数据库
    docker exec "${CONTAINER_NAME}" mysql -uroot -p"${MYSQL_ROOT_PASSWORD}" <<-EOSQL
        CREATE DATABASE IF NOT EXISTS ${DB_NAME}
        CHARACTER SET ${DB_CHARSET}
        COLLATE ${DB_COLLATE};
EOSQL

    if [ $? -eq 0 ]; then
        print_success "数据库创建成功"
    else
        print_error "数据库创建失败"
        exit 1
    fi
}

# 创建用户并授权
create_user() {
    print_info "创建用户 '${DB_USER}' 并授权..."

    docker exec "${CONTAINER_NAME}" mysql -uroot -p"${MYSQL_ROOT_PASSWORD}" <<-EOSQL
        -- 删除旧用户（如果存在）
        DROP USER IF EXISTS '${DB_USER}'@'%';
        DROP USER IF EXISTS '${DB_USER}'@'localhost';

        -- 创建新用户
        CREATE USER '${DB_USER}'@'%' IDENTIFIED BY '${DB_PASSWORD}';
        CREATE USER '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASSWORD}';

        -- 授予所有权限
        GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'%';
        GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'localhost';

        -- 刷新权限
        FLUSH PRIVILEGES;
EOSQL

    if [ $? -eq 0 ]; then
        print_success "用户创建和授权成功"
    else
        print_error "用户创建失败"
        exit 1
    fi
}

# ============================================================================
# 数据导入函数
# ============================================================================

# 导入 SQL 数据
import_sql() {
    print_info "导入数据库结构和初始数据..."

    # 复制 SQL 文件到容器
    print_info "复制 SQL 文件到容器..."
    docker cp "${SQL_FILE}" "${CONTAINER_NAME}:/tmp/install.sql"

    if [ $? -ne 0 ]; then
        print_error "SQL 文件复制失败"
        exit 1
    fi

    # 执行 SQL 导入
    print_info "执行 SQL 导入（可能需要几秒钟）..."
    docker exec "${CONTAINER_NAME}" mysql -uroot -p"${MYSQL_ROOT_PASSWORD}" "${DB_NAME}" \
        < "${SQL_FILE}" 2>/dev/null

    if [ $? -eq 0 ]; then
        print_success "数据导入成功"
    else
        print_error "数据导入失败"

        # 清理临时文件
        docker exec "${CONTAINER_NAME}" rm -f /tmp/install.sql
        exit 1
    fi

    # 清理容器内的临时文件
    print_info "清理临时文件..."
    docker exec "${CONTAINER_NAME}" rm -f /tmp/install.sql
}

# ============================================================================
# 验证函数
# ============================================================================

# 验证数据库初始化
verify_database() {
    print_info "验证数据库初始化..."

    # 检查数据库是否存在
    DB_EXISTS=$(docker exec "${CONTAINER_NAME}" mysql -uroot -p"${MYSQL_ROOT_PASSWORD}" \
        -e "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME='${DB_NAME}';" \
        -sN 2>/dev/null)

    if [ -z "${DB_EXISTS}" ]; then
        print_error "数据库验证失败：数据库不存在"
        return 1
    fi

    # 统计表数量
    TABLE_COUNT=$(docker exec "${CONTAINER_NAME}" mysql -uroot -p"${MYSQL_ROOT_PASSWORD}" \
        -e "SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='${DB_NAME}';" \
        -sN 2>/dev/null)

    if [ -z "${TABLE_COUNT}" ] || [ "${TABLE_COUNT}" -eq 0 ]; then
        print_error "数据库验证失败：未发现任何表"
        return 1
    fi

    # 测试用户连接
    if ! docker exec "${CONTAINER_NAME}" mysql -u"${DB_USER}" -p"${DB_PASSWORD}" "${DB_NAME}" \
        -e "SELECT 1;" &> /dev/null; then
        print_error "用户连接测试失败"
        return 1
    fi

    print_success "数据库验证通过"

    # 显示表列表
    print_info "数据库表列表（前 10 个）："
    docker exec "${CONTAINER_NAME}" mysql -u"${DB_USER}" -p"${DB_PASSWORD}" "${DB_NAME}" \
        -e "SHOW TABLES LIMIT 10;" 2>/dev/null | tail -n +2

    return 0
}

# ============================================================================
# 主流程
# ============================================================================

main() {
    echo ""
    print_separator
    echo -e "${BLUE}Docker MySQL 数据库初始化脚本${NC}"
    print_separator
    echo ""

    # 第 1 步：环境检查
    check_docker
    check_container
    check_sql_file
    test_connection
    echo ""

    # 第 2 步：数据库初始化
    create_database
    create_user
    echo ""

    # 第 3 步：导入数据
    import_sql
    echo ""

    # 第 4 步：验证
    if verify_database; then
        echo ""
        print_separator
        print_success "数据库初始化完成！"
        print_separator
        echo ""
        echo -e "数据库信息："
        echo -e "  数据库名: ${GREEN}${DB_NAME}${NC}"
        echo -e "  用户名:   ${GREEN}${DB_USER}${NC}"
        echo -e "  密码:     ${GREEN}${DB_PASSWORD}${NC}"
        echo -e "  字符集:   ${GREEN}${DB_CHARSET}${NC}"
        echo ""
        echo -e "连接命令："
        echo -e "  容器内:   ${YELLOW}docker exec -it ${CONTAINER_NAME} mysql -u${DB_USER} -p${DB_PASSWORD} ${DB_NAME}${NC}"
        echo -e "  宿主机:   ${YELLOW}mysql -h 127.0.0.1 -P 3307 -u${DB_USER} -p${DB_PASSWORD} ${DB_NAME}${NC}"
        echo ""
        print_separator
        exit 0
    else
        echo ""
        print_error "数据库初始化失败，请检查错误信息"
        exit 1
    fi
}

# 执行主流程
main
