# 独角数卡 Docker 一键部署文档

## 快速开始

### 一键部署

```bash
cd /root/dujiaoka
./deploy.sh
```

按照提示输入配置信息即可完成部署。

## 部署前准备

### 1. 系统要求

- 操作系统: Linux (Ubuntu/Debian/CentOS)
- Docker 版本: >= 20.10
- Docker Compose 版本: >= 1.29
- (可选) Caddy 用于 HTTPS

### 2. 安装 Docker

如果尚未安装 Docker，请先安装：

```bash
# Ubuntu/Debian
curl -fsSL https://get.docker.com | sh
systemctl start docker
systemctl enable docker

# 安装 Docker Compose
apt install docker-compose -y
```

### 3. 域名解析

确保你的域名已经正确解析到服务器的公网 IP：

```bash
# 检查域名解析
ping pay.codesome.cn
```

### 4. 安装 Caddy (可选，用于 HTTPS)

```bash
# Ubuntu/Debian
apt install caddy -y
systemctl enable caddy
```

## 部署步骤

### 方式一：交互式部署（推荐）

```bash
cd /root/dujiaoka
./deploy.sh
```

脚本会提示你输入以下信息：
- 域名（默认: pay.codesome.cn）
- 数据库名（默认: dujiaoka）
- 数据库用户（默认: dujiaoka）
- 数据库密码（默认: dujiaoka123456）
- 是否配置 Caddy HTTPS

### 方式二：修改脚本后直接运行

编辑 `deploy.sh` 文件，修改以下变量：

```bash
DOMAIN="your-domain.com"
DB_NAME="dujiaoka"
DB_USER="dujiaoka"
DB_PASSWORD="your-password"
```

然后运行：

```bash
./deploy.sh
```

## 部署后配置

### 1. 访问系统

- 前台地址: https://pay.codesome.cn
- 后台地址: https://pay.codesome.cn/admin
- 默认账号: `admin`
- 默认密码: `admin`

### 2. 修改默认密码

⚠️ **重要**: 首次登录后立即修改默认密码！

### 3. 完成安装向导

如果是首次部署，访问前台时会进入安装向导，按照提示完成配置。

## 服务管理

### 查看服务状态

```bash
cd /root/dujiaoka
docker-compose --env-file .env.docker ps
```

### 查看日志

```bash
# 查看所有服务日志
docker-compose --env-file .env.docker logs -f

# 查看 Web 服务日志
docker-compose --env-file .env.docker logs -f web

# 查看 MySQL 日志
docker-compose --env-file .env.docker logs -f mysql

# 查看 Redis 日志
docker-compose --env-file .env.docker logs -f redis
```

### 重启服务

```bash
# 重启所有服务
docker-compose --env-file .env.docker restart

# 重启单个服务
docker-compose --env-file .env.docker restart web
docker-compose --env-file .env.docker restart mysql
docker-compose --env-file .env.docker restart redis
```

### 停止服务

```bash
docker-compose --env-file .env.docker stop
```

### 启动服务

```bash
docker-compose --env-file .env.docker start
```

### 完全删除服务（包括数据）

```bash
# ⚠️ 警告：会删除所有数据！
docker-compose --env-file .env.docker down -v
```

## 数据备份

### 备份数据库

```bash
# 导出数据库
docker exec dujiaoka-mysql mysqldump -u root -proot123456 dujiaoka > backup_$(date +%Y%m%d).sql

# 或使用以下命令
docker-compose --env-file .env.docker exec mysql mysqldump -u root -proot123456 dujiaoka > backup_$(date +%Y%m%d).sql
```

### 恢复数据库

```bash
# 恢复数据库
docker exec -i dujiaoka-mysql mysql -u root -proot123456 dujiaoka < backup.sql
```

### 备份文件

```bash
# 备份上传文件
tar -czf uploads_backup_$(date +%Y%m%d).tar.gz /root/dujiaoka/data/dujiaoka/public/uploads

# 备份完整数据目录
tar -czf data_backup_$(date +%Y%m%d).tar.gz /root/dujiaoka/data
```

## 配置文件说明

### .env.docker

Docker Compose 的环境变量文件，定义数据存储路径：

```bash
DATA_DIR=/root/dujiaoka/data
```

### .env

应用程序的配置文件，包含：
- 应用配置（APP_URL, APP_KEY 等）
- 数据库配置（DB_HOST, DB_DATABASE 等）
- Redis 配置（REDIS_HOST, REDIS_PORT）
- 其他业务配置

### docker-compose.yml

Docker Compose 配置文件，定义了三个服务：
- `web`: PHP-Nginx 应用容器
- `mysql`: MariaDB 数据库容器
- `redis`: Redis 缓存容器

### Caddyfile

Caddy 反向代理配置，提供 HTTPS 支持。

## 端口说明

### 容器端口映射

| 服务 | 容器端口 | 主机端口 | 说明 |
|------|---------|---------|------|
| Web | 80 | 8080 | HTTP 服务 |
| Web | 9000 | 9000 | PHP-FPM |
| MySQL | 3306 | 3307 | 数据库 |
| Redis | 6379 | 6380 | 缓存 |

### 防火墙配置

如果使用 Caddy HTTPS，需要开放以下端口：

```bash
# 开放 80 和 443 端口（Let's Encrypt 证书验证和 HTTPS）
ufw allow 80/tcp
ufw allow 443/tcp

# 如果需要直接访问容器端口
ufw allow 8080/tcp
```

## 故障排查

### 容器无法启动

```bash
# 查看详细日志
docker-compose --env-file .env.docker logs

# 检查端口占用
netstat -tunlp | grep -E '8080|3307|6380'

# 重新构建并启动
docker-compose --env-file .env.docker up -d --build --force-recreate
```

### 数据库连接失败

```bash
# 进入 Web 容器测试连接
docker exec -it dujiaoka bash
ping mysql
telnet mysql 3306

# 检查数据库容器状态
docker-compose --env-file .env.docker logs mysql
```

### HTTPS 证书获取失败

```bash
# 查看 Caddy 日志
journalctl -u caddy -f

# 手动测试证书获取
caddy validate --config /etc/caddy/Caddyfile

# 确保域名解析正确
nslookup pay.codesome.cn
```

### 权限问题

```bash
# 修复上传目录权限
chmod -R 777 /root/dujiaoka/data/dujiaoka/public/uploads

# 修复日志目录权限
chown -R caddy:caddy /var/log/caddy
```

## 更新升级

### 更新应用代码

```bash
cd /root/dujiaoka
git pull
docker-compose --env-file .env.docker restart web
```

### 更新 Docker 镜像

```bash
docker-compose --env-file .env.docker pull
docker-compose --env-file .env.docker up -d
```

## 性能优化

### 启用 Redis 缓存

确保 `.env` 文件中：

```bash
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
```

### 启用 opcache

在 Dockerfile 中已默认安装 opcache 扩展。

### 数据库优化

编辑 `docker-compose.yml`，在 MySQL 服务的 `command` 中添加优化参数。

## 安全建议

1. ✅ 修改默认账号密码
2. ✅ 使用强密码
3. ✅ 定期备份数据
4. ✅ 启用 HTTPS
5. ✅ 关闭 DEBUG 模式（生产环境设置 `APP_DEBUG=false`）
6. ✅ 限制数据库外部访问（生产环境不要暴露 3307 端口）
7. ✅ 定期更新系统和应用

## 常见问题

### Q1: 如何更改域名？

修改 `.env` 文件中的 `APP_URL`，同时更新 Caddy 配置：

```bash
# 修改配置
vim /root/dujiaoka/data/dujiaoka/.env
vim /etc/caddy/Caddyfile

# 重启服务
docker-compose --env-file .env.docker restart web
systemctl reload caddy
```

### Q2: 如何重置管理员密码？

进入容器执行重置命令：

```bash
docker exec -it dujiaoka php artisan admin:reset-password
```

### Q3: 如何清理缓存？

```bash
docker exec -it dujiaoka php artisan cache:clear
docker exec -it dujiaoka php artisan config:clear
docker exec -it dujiaoka php artisan route:clear
docker exec -it dujiaoka php artisan view:clear
```

## 联系支持

- GitHub: https://github.com/assimon/dujiaoka
- Telegram: https://t.me/dujiaoka
- Wiki: https://github.com/assimon/dujiaoka/wiki

## 许可证

MIT License
