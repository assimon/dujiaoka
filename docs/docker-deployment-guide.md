# Docker 环境下 aff 菜单部署指南

## 环境信息

**容器配置**:
- Web 容器: `dujiaoka`
- MySQL 容器: `dujiaoka-mysql`
- Redis 容器: `dujiaoka-redis`

**数据库配置**:
- 用户名: `root` / `dujiaoka`
- 密码: `root123456` / `dujiaoka123456`
- 数据库名: `dujiaoka`
- 外部端口: `3307` (映射到容器内 3306)

**Web 访问**:
- 前台: http://localhost:8080
- 后台: http://localhost:8080/admin

---

## 🚀 快速部署（推荐）

### 方法一：使用一键部署脚本

```bash
# 执行自动化部署脚本
./scripts/deploy-aff-menu.sh
```

这个脚本会自动完成：
1. ✅ 检查容器状态
2. ✅ 备份现有菜单数据
3. ✅ 执行菜单迁移 SQL
4. ✅ 清除 Laravel 缓存
5. ✅ 验证菜单是否生效

---

### 方法二：手动执行命令

```bash
# 1. 备份数据库（可选但推荐）
docker exec dujiaoka-mysql mysqldump -uroot -proot123456 dujiaoka admin_menu > backup_admin_menu.sql

# 2. 执行迁移 SQL
docker exec -i dujiaoka-mysql mysql -uroot -proot123456 dujiaoka < database/sql/migrate_affiliate_menu.sql

# 3. 清除 Laravel 缓存
docker exec dujiaoka php artisan config:clear
docker exec dujiaoka php artisan cache:clear
docker exec dujiaoka php artisan view:clear

# 4. 验证菜单
docker exec -i dujiaoka-mysql mysql -uroot -proot123456 dujiaoka -e "SELECT id, parent_id, title, uri FROM admin_menu WHERE uri = '/affiliate-code';"
```

---

## 📋 详细操作步骤

### 步骤 1: 检查容器状态

```bash
docker ps --filter "name=dujiaoka"
```

**期望输出**:
```
NAMES            IMAGE            STATUS
dujiaoka         dujiaoka-web     Up X hours
dujiaoka-mysql   mariadb:10.6     Up X hours
dujiaoka-redis   redis:6-alpine   Up X hours
```

如果容器未运行：
```bash
docker-compose up -d
```

---

### 步骤 2: 备份数据库

```bash
# 备份整个数据库
docker exec dujiaoka-mysql mysqldump -uroot -proot123456 dujiaoka > backup_full_$(date +%Y%m%d).sql

# 仅备份 admin_menu 表
docker exec dujiaoka-mysql mysqldump -uroot -proot123456 dujiaoka admin_menu > backup_admin_menu_$(date +%Y%m%d).sql
```

---

### 步骤 3: 执行菜单迁移

#### 选项 A: 使用 SQL 文件（推荐）

```bash
docker exec -i dujiaoka-mysql mysql -uroot -proot123456 dujiaoka < database/sql/migrate_affiliate_menu.sql
```

#### 选项 B: 交互式执行

```bash
# 进入 MySQL 容器
docker exec -it dujiaoka-mysql mysql -uroot -proot123456 dujiaoka

# 在 MySQL 提示符下执行：
DELETE FROM admin_menu WHERE id = 26 OR (parent_id = 18 AND uri = '/affiliate-code');

INSERT INTO admin_menu (id, parent_id, `order`, title, icon, uri, extension, `show`, created_at, updated_at)
VALUES (26, 18, 17, 'Affiliate_Code', 'fa-share-alt', '/affiliate-code', '', 1, NOW(), NOW());

SELECT * FROM admin_menu WHERE uri = '/affiliate-code'\G

exit;
```

#### 选项 C: 一行命令执行

```bash
docker exec -i dujiaoka-mysql mysql -uroot -proot123456 dujiaoka <<EOF
DELETE FROM admin_menu WHERE id = 26 OR (parent_id = 18 AND uri = '/affiliate-code');
INSERT INTO admin_menu (id, parent_id, \`order\`, title, icon, uri, extension, \`show\`, created_at, updated_at)
VALUES (26, 18, 17, 'Affiliate_Code', 'fa-share-alt', '/affiliate-code', '', 1, NOW(), NOW());
SELECT id, parent_id, title, uri FROM admin_menu WHERE uri = '/affiliate-code';
EOF
```

---

### 步骤 4: 清除 Laravel 缓存

```bash
# 清除配置缓存
docker exec dujiaoka php artisan config:clear

# 清除应用缓存
docker exec dujiaoka php artisan cache:clear

# 清除视图缓存
docker exec dujiaoka php artisan view:clear

# 一行执行所有清除命令
docker exec dujiaoka sh -c "php artisan config:clear && php artisan cache:clear && php artisan view:clear"
```

---

### 步骤 5: 验证部署结果

#### 验证数据库

```bash
# 查询菜单记录
docker exec -i dujiaoka-mysql mysql -uroot -proot123456 dujiaoka -e "SELECT id, parent_id, \`order\`, title, uri, created_at FROM admin_menu WHERE uri = '/affiliate-code';"
```

**期望输出**:
```
+----+-----------+-------+---------------+-----------------+---------------------+
| id | parent_id | order | title         | uri             | created_at          |
+----+-----------+-------+---------------+-----------------+---------------------+
| 26 |        18 |    17 | Affiliate_Code| /affiliate-code | 2026-01-16 12:00:00 |
+----+-----------+-------+---------------+-----------------+---------------------+
```

#### 验证路由

```bash
docker exec dujiaoka php artisan route:list | grep affiliate-code
```

**期望输出**:
```
GET|HEAD   admin/affiliate-code                 dcat.admin.affiliate-code.index
POST       admin/affiliate-code                 dcat.admin.affiliate-code.store
GET|HEAD   admin/affiliate-code/create          dcat.admin.affiliate-code.create
...（共7条路由）
```

#### 验证翻译文件

```bash
docker exec dujiaoka grep -r "affiliate_code" resources/lang/*/menu.php
```

**期望输出**:
```
resources/lang/en/menu.php:        'affiliate_code'=> 'Affiliate Code',
resources/lang/zh_CN/menu.php:        'affiliate_code'=> '推广码管理',
resources/lang/zh_TW/menu.php:        'affiliate_code'=> '推廣碼管理',
```

---

### 步骤 6: 浏览器验证

1. 访问后台: http://localhost:8080/admin
2. 登录管理员账号
3. 查看左侧菜单栏
4. 找到：**优惠管理 → 推广码管理**
5. 点击进入推广码管理页面
6. 验证 CRUD 功能：
   - ✅ 列表显示正常
   - ✅ 可以创建新推广码
   - ✅ 可以编辑推广码
   - ✅ 可以关联优惠码
   - ✅ 使用次数统计显示

---

## 🔧 常用 Docker 命令

### 容器管理

```bash
# 查看所有容器状态
docker-compose ps

# 启动所有容器
docker-compose up -d

# 停止所有容器
docker-compose down

# 重启 Web 容器
docker-compose restart web

# 查看 Web 容器日志
docker-compose logs -f web

# 查看 MySQL 容器日志
docker-compose logs -f mysql
```

### 进入容器

```bash
# 进入 Web 容器 (bash)
docker exec -it dujiaoka bash

# 进入 MySQL 容器 (bash)
docker exec -it dujiaoka-mysql bash

# 进入 MySQL 命令行
docker exec -it dujiaoka-mysql mysql -uroot -proot123456 dujiaoka

# 进入 Redis 命令行
docker exec -it dujiaoka-redis redis-cli
```

### Laravel 命令

```bash
# 清除所有缓存
docker exec dujiaoka php artisan optimize:clear

# 查看路由列表
docker exec dujiaoka php artisan route:list

# 查看配置
docker exec dujiaoka php artisan config:show

# 执行数据库迁移
docker exec dujiaoka php artisan migrate

# 查看 Laravel 版本
docker exec dujiaoka php artisan --version
```

### 数据库操作

```bash
# 导出整个数据库
docker exec dujiaoka-mysql mysqldump -uroot -proot123456 dujiaoka > backup.sql

# 导入数据库
docker exec -i dujiaoka-mysql mysql -uroot -proot123456 dujiaoka < backup.sql

# 查询数据
docker exec -i dujiaoka-mysql mysql -uroot -proot123456 dujiaoka -e "SELECT * FROM admin_menu;"

# 执行 SQL 文件
docker exec -i dujiaoka-mysql mysql -uroot -proot123456 dujiaoka < your_script.sql
```

---

## 🐛 故障排查

### 问题 1: 容器未运行

```bash
# 查看容器状态
docker ps -a | grep dujiaoka

# 查看容器日志
docker-compose logs web
docker-compose logs mysql

# 重启容器
docker-compose restart
```

### 问题 2: 菜单未显示

```bash
# 1. 确认菜单已插入数据库
docker exec -i dujiaoka-mysql mysql -uroot -proot123456 dujiaoka -e "SELECT * FROM admin_menu WHERE uri = '/affiliate-code'\G"

# 2. 清除所有缓存
docker exec dujiaoka php artisan optimize:clear

# 3. 重启 Web 容器
docker-compose restart web

# 4. 检查浏览器缓存（Ctrl+Shift+R 强制刷新）
```

### 问题 3: 权限问题

```bash
# 检查文件权限
docker exec dujiaoka ls -la resources/lang/zh_CN/menu.php

# 修复权限（如需要）
docker exec dujiaoka chown -R www-data:www-data resources/lang/
```

### 问题 4: MySQL 连接失败

```bash
# 测试 MySQL 连接
docker exec dujiaoka-mysql mysql -uroot -proot123456 -e "SHOW DATABASES;"

# 检查 .env 配置
docker exec dujiaoka cat .env | grep DB_

# 重启 MySQL 容器
docker-compose restart mysql
```

### 问题 5: 菜单显示但无法访问

```bash
# 检查权限表
docker exec -i dujiaoka-mysql mysql -uroot -proot123456 dujiaoka -e "SELECT * FROM admin_role_menu WHERE menu_id = 26;"

# 如果没有记录，手动添加权限（role_id=1 是管理员）
docker exec -i dujiaoka-mysql mysql -uroot -proot123456 dujiaoka -e "INSERT INTO admin_role_menu (role_id, menu_id) VALUES (1, 26);"
```

---

## 🔄 回滚方案

### 方法一：使用备份恢复

```bash
# 恢复备份的菜单表
docker exec -i dujiaoka-mysql mysql -uroot -proot123456 dujiaoka < backup_admin_menu.sql

# 清除缓存
docker exec dujiaoka php artisan cache:clear
```

### 方法二：手动删除菜单

```bash
docker exec -i dujiaoka-mysql mysql -uroot -proot123456 dujiaoka -e "DELETE FROM admin_menu WHERE id = 26 AND uri = '/affiliate-code';"

docker exec dujiaoka php artisan cache:clear
```

---

## 📊 部署检查清单

部署前：
- [ ] 确认 Docker 容器正常运行
- [ ] 备份数据库
- [ ] 确认有数据库操作权限

部署中：
- [ ] 执行菜单迁移 SQL
- [ ] 清除 Laravel 缓存
- [ ] 验证数据库记录

部署后：
- [ ] 数据库查询验证
- [ ] 路由列表验证
- [ ] 翻译文件验证
- [ ] 浏览器访问验证
- [ ] CRUD 功能测试

---

## 📞 技术支持

如遇问题，请提供以下信息：

```bash
# 1. 容器状态
docker ps --filter "name=dujiaoka"

# 2. 容器日志
docker-compose logs --tail=100 web

# 3. 数据库记录
docker exec -i dujiaoka-mysql mysql -uroot -proot123456 dujiaoka -e "SELECT * FROM admin_menu WHERE uri = '/affiliate-code'\G"

# 4. Laravel 日志
docker exec dujiaoka tail -50 storage/logs/laravel.log
```

---

## 相关文档

- [aff菜单修复完整说明](./aff-menu-fix.md)
- [推广系统测试指南](./affiliate-system-testing-guide.md)
- [本地调试指南](./LOCAL_DEBUG_GUIDE.md)
