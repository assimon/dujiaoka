#!/bin/bash

#######################################
# 独角数卡 Docker 一键部署脚本
# 作者: Claude
# 日期: 2026-01-10
#######################################

set -e  # 遇到错误立即退出

# 颜色定义
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# 日志函数
log_info() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

log_warn() {
    echo -e "${YELLOW}[WARN]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# 配置变量
PROJECT_DIR="$(pwd)"
DATA_DIR="$(pwd)/data"
DOMAIN="pay.xxx.cn"
DB_NAME="dujiaoka"
DB_USER="dujiaoka"
DB_PASSWORD="dujiaoka123456"
DB_ROOT_PASSWORD="root123456"

echo "========================================"
echo "   独角数卡 Docker 一键部署脚本"
echo "========================================"
echo ""

# 检查是否在项目目录中
if [ ! -f "docker-compose.yml" ]; then
    log_error "请在项目根目录下运行此脚本！"
    exit 1
fi

# 步骤 1: 检查 Docker 和 Docker Compose
log_info "检查 Docker 环境..."
if ! command -v docker &> /dev/null; then
    log_error "Docker 未安装，请先安装 Docker！"
    exit 1
fi

if ! command -v docker-compose &> /dev/null; then
    log_error "Docker Compose 未安装，请先安装 Docker Compose！"
    exit 1
fi

log_info "Docker 版本: $(docker --version)"
log_info "Docker Compose 版本: $(docker-compose --version)"

# 步骤 2: 提示用户输入配置
echo ""
log_warn "请确认以下配置信息（按回车使用默认值）："
read -p "域名 [${DOMAIN}]: " input_domain
DOMAIN=${input_domain:-$DOMAIN}

read -p "数据库名 [${DB_NAME}]: " input_db_name
DB_NAME=${input_db_name:-$DB_NAME}

read -p "数据库用户 [${DB_USER}]: " input_db_user
DB_USER=${input_db_user:-$DB_USER}

read -p "数据库密码 [${DB_PASSWORD}]: " input_db_password
DB_PASSWORD=${input_db_password:-$DB_PASSWORD}

echo ""
log_info "配置确认："
log_info "域名: ${DOMAIN}"
log_info "数据库: ${DB_NAME}"
log_info "数据库用户: ${DB_USER}"
log_info "数据库密码: ${DB_PASSWORD}"
echo ""

read -p "是否继续部署？(y/n): " confirm
if [[ ! $confirm =~ ^[Yy]$ ]]; then
    log_warn "部署已取消"
    exit 0
fi

# 步骤 3: 创建 Docker Compose 环境变量文件
log_info "创建 Docker Compose 环境变量文件..."
cat > .env.docker <<EOF
# Docker Compose 环境变量配置
# 数据存储目录，所有持久化数据都将存储在此目录下
DATA_DIR=${DATA_DIR}
EOF
log_info ".env.docker 文件已创建"

# 步骤 4: 更新应用配置文件
log_info "配置应用环境变量..."
if [ -f ".env" ]; then
    # 备份原配置
    cp .env .env.backup.$(date +%Y%m%d_%H%M%S)
    log_info "原配置已备份"

    # 检测操作系统，设置 sed 的 -i 选项（macOS 需要空字符串参数）
    SED_INPLACE="-i"
    if [[ "$OSTYPE" == "darwin"* ]]; then
        SED_INPLACE="-i ''"
    fi

    # 更新配置
    sed -i '' "s|^APP_URL=.*|APP_URL=https://${DOMAIN}|g" .env
    sed -i '' "s|^DB_HOST=.*|DB_HOST=mysql|g" .env
    sed -i '' "s|^DB_PORT=.*|DB_PORT=3306|g" .env
    sed -i '' "s|^DB_DATABASE=.*|DB_DATABASE=${DB_NAME}|g" .env
    sed -i '' "s|^DB_USERNAME=.*|DB_USERNAME=${DB_USER}|g" .env
    sed -i '' "s|^DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD}|g" .env
    sed -i '' "s|^REDIS_HOST=.*|REDIS_HOST=redis|g" .env
    sed -i '' "s|^REDIS_PORT=.*|REDIS_PORT=6379|g" .env

    log_info ".env 文件已更新"
else
    log_error ".env 文件不存在！"
    exit 1
fi

# 步骤 5: 创建必要的数据目录
log_info "创建数据目录..."
mkdir -p ${DATA_DIR}/dujiaoka/public/uploads/{images,files}
mkdir -p ${DATA_DIR}/dujiaoka/{mysql,redis}
chmod -R 777 ${DATA_DIR}/dujiaoka/public/uploads
log_info "数据目录已创建"

# 步骤 6: 复制配置文件到数据目录
log_info "复制配置文件..."
cp .env ${DATA_DIR}/dujiaoka/.env
log_info "配置文件已复制"

# 步骤 7: 停止并清理旧容器（如果存在）
log_info "检查旧容器..."
if docker ps -a | grep -q "dujiaoka"; then
    log_warn "发现旧容器，正在停止并删除..."
    docker-compose --env-file .env.docker down
    log_info "旧容器已清理"
fi

# 步骤 8: 启动 Docker Compose 服务
log_info "启动 Docker Compose 服务..."
log_warn "首次启动需要构建镜像，可能需要几分钟时间，请耐心等待..."
docker-compose --env-file .env.docker up -d --build

# 步骤 9: 等待服务启动
log_info "等待服务启动..."
sleep 10

# 步骤 10: 检查容器状态
log_info "检查容器状态..."
docker-compose --env-file .env.docker ps

# 检查容器是否都在运行
if ! docker ps | grep -q "dujiaoka"; then
    log_error "Web 容器启动失败！"
    log_info "查看日志: docker-compose --env-file .env.docker logs web"
    exit 1
fi

if ! docker ps | grep -q "dujiaoka-mysql"; then
    log_error "MySQL 容器启动失败！"
    log_info "查看日志: docker-compose --env-file .env.docker logs mysql"
    exit 1
fi

if ! docker ps | grep -q "dujiaoka-redis"; then
    log_error "Redis 容器启动失败！"
    log_info "查看日志: docker-compose --env-file .env.docker logs redis"
    exit 1
fi

log_info "所有容器启动成功！"

# 步骤 11: 配置 Caddy HTTPS（可选）
echo ""
read -p "是否配置 Caddy HTTPS？(y/n): " setup_caddy
if [[ $setup_caddy =~ ^[Yy]$ ]]; then
    if command -v caddy &> /dev/null; then
        log_info "配置 Caddy HTTPS..."

        # 创建日志目录
        mkdir -p /var/log/caddy
        chown -R caddy:caddy /var/log/caddy 2>/dev/null || true

        # 备份原配置
        if [ -f "/etc/caddy/Caddyfile" ]; then
            cp /etc/caddy/Caddyfile /etc/caddy/Caddyfile.backup.$(date +%Y%m%d_%H%M%S)
            log_info "Caddy 原配置已备份"
        fi

        # 写入新配置
        cat > /etc/caddy/Caddyfile <<EOF
# ${DOMAIN} - 反向代理到 8080
${DOMAIN} {
        reverse_proxy localhost:8080 {
                header_up X-Forwarded-Proto {scheme}
                header_up X-Forwarded-Host {host}
        }

        log {
                output file /var/log/caddy/${DOMAIN}.log
        }
}
EOF

        # 验证配置
        if caddy validate --config /etc/caddy/Caddyfile; then
            log_info "Caddy 配置验证成功"

            # 格式化配置
            caddy fmt --overwrite /etc/caddy/Caddyfile

            # 重载 Caddy
            systemctl reload caddy
            log_info "Caddy 已重载，HTTPS 配置完成"

            # 等待证书获取
            sleep 5
            log_info "正在获取 SSL 证书，请稍候..."
            sleep 10
        else
            log_error "Caddy 配置验证失败！"
        fi
    else
        log_warn "Caddy 未安装，跳过 HTTPS 配置"
    fi
fi

# 部署完成
echo ""
echo "========================================"
log_info "部署完成！"
echo "========================================"
echo ""
log_info "访问信息："
log_info "前台地址: https://${DOMAIN}"
log_info "后台地址: https://${DOMAIN}/admin"
log_info "默认账号: admin"
log_info "默认密码: admin"
echo ""
log_info "数据库信息："
log_info "主机: localhost:3307 (外部) / mysql:3306 (容器内)"
log_info "数据库: ${DB_NAME}"
log_info "用户名: ${DB_USER}"
log_info "密码: ${DB_PASSWORD}"
log_info "Root 密码: ${DB_ROOT_PASSWORD}"
echo ""
log_info "Redis 信息："
log_info "主机: localhost:6380 (外部) / redis:6379 (容器内)"
echo ""
log_info "数据存储位置："
log_info "${DATA_DIR}/dujiaoka/"
echo ""
log_info "常用命令："
log_info "查看容器状态: docker-compose --env-file .env.docker ps"
log_info "查看日志: docker-compose --env-file .env.docker logs -f"
log_info "停止服务: docker-compose --env-file .env.docker down"
log_info "重启服务: docker-compose --env-file .env.docker restart"
echo ""
log_warn "重要提醒："
log_warn "1. 请立即登录后台修改默认密码！"
log_warn "2. 首次访问可能需要完成安装向导"
log_warn "3. 确保域名 DNS 已正确解析到本服务器"
echo "========================================"
