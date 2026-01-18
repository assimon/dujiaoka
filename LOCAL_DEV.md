# 独角数卡 - 本地 PHP 开发环境配置文档

## 🎯 目标
在 macOS 上搭建本地 PHP 开发环境，运行独角数卡项目

---

## 一、环境要求

| 组件 | 版本要求 | 说明 |
|------|----------|------|
| PHP | 7.4 (推荐) 或 8.0 | 需安装扩展 |
| MySQL | >= 5.6 | 或 MariaDB |
| Redis | 任意版本 | 缓存和队列 |
| Composer | 最新版 | PHP 包管理器 |
| Node.js | 可选 | 前端资源编译 |

### PHP 必需扩展
- `fileinfo` - 文件类型检测
- `redis` - Redis 连接
- `pdo_mysql` - MySQL 连接
- `openssl` - 加密支持
- `mbstring` - 多字节字符串
- `tokenizer` - 代码解析
- `xml` - XML 处理
- `ctype` - 字符类型检测
- `json` - JSON 处理
- `bcmath` - 高精度数学运算

### PHP 必需开启的函数
- `putenv`
- `proc_open`
- `pcntl_signal`
- `pcntl_alarm`

---

## 二、macOS 环境安装

### 2.1 使用 Homebrew 安装

```bash
# 安装 Homebrew（如未安装）
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# 安装 PHP 7.4
brew tap shivammathur/php
brew install shivammathur/php/php@7.4

# 链接 PHP 7.4
brew link php@7.4 --force

# 验证 PHP 版本
php -v

# 安装 MySQL
brew install mysql
brew services start mysql

# 安装 Redis
brew install redis
brew services start redis

# 安装 Composer
brew install composer
```

### 2.2 安装 PHP 扩展

```bash
# 安装 redis 扩展
pecl install redis

# 验证扩展
php -m | grep -E "redis|fileinfo|pdo_mysql"
```

### 2.3 配置 PHP

编辑 PHP 配置文件（通常在 `/opt/homebrew/etc/php/7.4/php.ini`）：

```ini
; 确保以下函数未被禁用
disable_functions =
; 如果有禁用函数，移除: putenv, proc_open, pcntl_signal, pcntl_alarm

; 启用扩展
extension=redis
extension=fileinfo
```

---

## 三、数据库配置

### 3.1 创建数据库

```bash
# 登录 MySQL
mysql -u root

# 创建数据库和用户
CREATE DATABASE dujiaoka CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'dujiaoka'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON dujiaoka.* TO 'dujiaoka'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3.2 导入初始数据

```bash
# 导入数据库结构和初始数据
mysql -u dujiaoka -p dujiaoka < database/sql/install.sql
```
⏺ 脚本执行成功！让我验证数据库初始化结果：

⏺ Bash(docker exec dujiaoka-mysql mysql -udujiaoka -pdujiaoka123456 dujiaoka -e "SHOW TABLES;" 2>/dev/null)
  ⎿  Tables_in_dujiaoka
     admin_menu
     admin_permission_menu
     … +17 lines (ctrl+o to expand)

⏺ Bash(docker exec dujiaoka-mysql mysql -udujiaoka -pdujiaoka123456 dujiaoka -e "SELECT COUNT(*) as table_count FROM
      INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='duji…)
  ⎿  table_count
     19

⏺ Bash(docker exec dujiaoka-mysql mysql -udujiaoka -pdujiaoka123456 dujiaoka -e "SELECT COUNT(*) as menu_count FROM admin_menu;" 2>/dev/null)
  ⎿  menu_count
     22

⏺ ✅ 任务完成！

  已成功创建并测试了 Docker MySQL 数据库初始化脚本。

  📝 执行结果

  数据库初始化成功：
  - ✅ 数据库名：dujiaoka
  - ✅ 数据表数量：19 个表
  - ✅ 初始菜单数据：22 条记录
  - ✅ 用户名：dujiaoka
  - ✅ 密码：dujiaoka123456
  - ✅ 字符集：utf8mb4

  📋 已创建的表

  admin_menu, admin_permission_menu, admin_permissions,
  admin_role_menu, admin_role_permissions, admin_role_users,
  admin_roles, admin_settings, admin_users, carmis,
  coupons, coupons_goods, emailtpls, failed_jobs, goods,
  goods_group, migrations, orders, pays

  🚀 脚本使用方法

  位置： init-docker-mysql.sh

  # 运行脚本
  ./init-docker-mysql.sh

  🔌 数据库连接方式

  容器内连接：
  docker exec -it dujiaoka-mysql mysql -udujiaoka -pdujiaoka123456 dujiaoka

  宿主机连接（端口 3307）：
  mysql -h 127.0.0.1 -P 3307 -udujiaoka -pdujiaoka123456 dujiaoka

  ✨ 脚本特性

  1. 智能检查 - 自动检测 Docker、容器、SQL 文件
  2. 安全提示 - 重建数据库前会确认
  3. 彩色输出 - 清晰的成功/错误/警告提示
  4. 自动验证 - 导入后自动验证表数量和连接
  5. 幂等性 - 可安全重复执行

  数据库已就绪，您现在可以启动 Web 应用进行开发了！


---

## 四、项目配置

### 4.1 安装 PHP 依赖

```bash
cd /Users/mac/git/person/dujiaoka

# 安装依赖
composer install
```

### 4.2 配置环境变量

```bash
# 复制环境配置模板
cp .env.example .env
```

编辑 `.env` 文件：

```env
# 应用配置
APP_NAME=独角数卡
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# 数据库配置
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dujiaoka
DB_USERNAME=dujiaoka
DB_PASSWORD=your_password

# Redis 配置
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# 缓存配置（开发环境可用 file）
CACHE_DRIVER=redis

# 队列配置（开发环境可用 sync）
QUEUE_CONNECTION=sync

# 后台语言
DUJIAO_ADMIN_LANGUAGE=zh_CN

# 后台路径
ADMIN_ROUTE_PREFIX=admin

# HTTPS 配置（本地开发关闭）
ADMIN_HTTPS=false
```

### 4.3 生成应用密钥

```bash
php artisan key:generate
```

### 4.4 创建存储目录软链接

```bash
php artisan storage:link
```

### 4.5 设置目录权限

```bash
chmod -R 777 storage
chmod -R 777 bootstrap/cache
chmod -R 777 public/uploads
```

---

## 五、启动开发服务器

### 5.1 启动 PHP 内置服务器

```bash
php artisan serve
```

访问地址：
- 前台: http://localhost:8000
- 后台: http://localhost:8000/admin

### 5.2 默认管理员账号

- 用户名: `admin`
- 密码: `admin`

---

## 六、队列处理（可选）

如果需要测试异步任务（如邮件发送、订单处理）：

```bash
# 方式一：同步模式（开发推荐）
# 在 .env 中设置 QUEUE_CONNECTION=sync

# 方式二：异步模式
# 在 .env 中设置 QUEUE_CONNECTION=redis
# 然后运行队列监听
php artisan queue:work
```

---

## 七、常用开发命令

```bash
# 启动开发服务器
php artisan serve

# 清除所有缓存
php artisan optimize:clear

# 清除配置缓存
php artisan config:clear

# 清除路由缓存
php artisan route:clear

# 清除视图缓存
php artisan view:clear

# 运行数据库迁移
php artisan migrate

# 回滚迁移
php artisan migrate:rollback

# 查看路由列表
php artisan route:list

# 进入 Tinker 交互式命令行
php artisan tinker

# 运行队列任务
php artisan queue:work

# 监听队列（开发模式，代码变更自动重启）
php artisan queue:listen
```

---

## 八、前端资源编译（可选）

如果需要修改前端样式或脚本：

```bash
# 安装 Node.js 依赖
npm install

# 开发模式编译
npm run dev

# 监听文件变化自动编译
npm run watch

# 生产模式编译
npm run prod
```

---

## 九、常见问题排查

### 9.1 500 错误

```bash
# 检查日志
tail -f storage/logs/laravel.log

# 清除缓存
php artisan optimize:clear
```

### 9.2 数据库连接失败

```bash
# 检查 MySQL 服务状态
brew services list

# 重启 MySQL
brew services restart mysql

# 测试连接
mysql -u dujiaoka -p -h 127.0.0.1 dujiaoka
```

### 9.3 Redis 连接失败

```bash
# 检查 Redis 服务状态
brew services list

# 重启 Redis
brew services restart redis

# 测试连接
redis-cli ping
```

### 9.4 权限问题

```bash
chmod -R 777 storage
chmod -R 777 bootstrap/cache
```

### 9.5 Composer 安装失败

```bash
# 清除 Composer 缓存
composer clear-cache

# 忽略平台要求安装
composer install --ignore-platform-reqs
```

---

## 十、验证清单

- [ ] PHP 版本正确 (`php -v` 显示 7.4.x)
- [ ] 必需扩展已安装 (`php -m | grep redis`)
- [ ] MySQL 服务运行中
- [ ] Redis 服务运行中
- [ ] 数据库已创建并导入数据
- [ ] `.env` 配置正确
- [ ] 应用密钥已生成
- [ ] 目录权限已设置
- [ ] 可访问 http://localhost:8000
- [ ] 可登录后台 http://localhost:8000/admin

---

## 十一、快速启动脚本

创建 `dev-start.sh`：

```bash
#!/bin/bash

echo "🚀 启动独角数卡开发环境..."

# 检查服务
echo "📦 检查 MySQL..."
brew services start mysql 2>/dev/null

echo "📦 检查 Redis..."
brew services start redis 2>/dev/null

# 清除缓存
echo "🧹 清除缓存..."
php artisan optimize:clear

# 启动服务器
echo "🌐 启动开发服务器..."
echo "前台: http://localhost:8000"
echo "后台: http://localhost:8000/admin"
echo ""
php artisan serve
```

使用方式：

```bash
chmod +x dev-start.sh
./dev-start.sh
```
