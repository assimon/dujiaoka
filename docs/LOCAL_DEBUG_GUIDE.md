# 推广码系统本地调试指南

本指南将帮助您在本地环境中设置和调试推广码系统。

## 📋 前置要求

### 1. 环境要求
- **PHP**: >= 7.3
- **MySQL**: >= 5.7 或 MariaDB >= 10.2
- **Composer**: 最新版
- **Node.js**: >= 12.x (可选，用于前端资源编译)
- **Redis**: >= 5.0 (可选，用于缓存和队列)

### 2. 检查 PHP 扩展
```bash
php -m | grep -E "pdo|mysql|mbstring|json|openssl|fileinfo|curl"
```

必需的扩展：
- ✅ PDO
- ✅ pdo_mysql
- ✅ mbstring
- ✅ json
- ✅ openssl
- ✅ fileinfo
- ✅ curl

---

## 🔧 步骤 1：配置数据库

### 1.1 创建数据库

```bash
# 登录 MySQL
mysql -u root -p

# 创建数据库
CREATE DATABASE dujiaoka_dev CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# 创建用户（可选，建议使用）
CREATE USER 'dujiaoka_user'@'localhost' IDENTIFIED BY 'your_password';

# 授权
GRANT ALL PRIVILEGES ON dujiaoka_dev.* TO 'dujiaoka_user'@'localhost';

# 刷新权限
FLUSH PRIVILEGES;

# 退出
EXIT;
```

### 1.2 配置 .env 文件

编辑 `.env` 文件，填写数据库配置：

```bash
# 数据库配置
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dujiaoka_dev
DB_USERNAME=dujiaoka_user
DB_PASSWORD=your_password
```

**重要配置项**：

```bash
# 应用配置
APP_NAME=独角数卡
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# 缓存配置（本地调试建议使用 file）
CACHE_DRIVER=file

# 队列配置（本地调试建议使用 sync）
QUEUE_CONNECTION=sync

# 后台语言
DUJIAO_ADMIN_LANGUAGE=zh_CN

# 后台登录地址
ADMIN_ROUTE_PREFIX=/admin

# HTTPS 配置（本地调试设为 false）
ADMIN_HTTPS=false
```

### 1.3 测试数据库连接

```bash
php artisan tinker

# 在 tinker 中执行
DB::connection()->getPdo();

# 如果成功，会返回 PDO 对象
# 如果失败，会显示错误信息
```

---

## 🚀 步骤 2：初始化项目

### 2.1 安装依赖

```bash
# 安装 Composer 依赖
composer install

# 如果遇到权限问题
composer install --no-scripts
```

### 2.2 生成应用密钥（如果需要）

```bash
php artisan key:generate
```

### 2.3 导入基础数据库结构

```bash
# 方式1：如果项目有安装页面
# 访问 http://localhost:8000/install 进行安装

# 方式2：手动导入 SQL
mysql -u dujiaoka_user -p dujiaoka_dev < database/sql/install.sql
```

### 2.4 执行推广码系统迁移

```bash
# 创建推广码相关表
php artisan migrate --path=database/migrations/2026_01_11_000001_create_affiliate_codes_tables.php

# 添加管理菜单
mysql -u dujiaoka_user -p dujiaoka_dev < database/sql/add_affiliate_code_menu.sql
```

### 2.5 清除缓存

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

---

## 🌐 步骤 3：启动开发服务器

### 3.1 启动 PHP 内置服务器

```bash
# 在项目根目录
php artisan serve

# 或指定端口
php artisan serve --port=8000
```

**访问地址**：
- 前台：http://localhost:8000
- 后台：http://localhost:8000/admin

### 3.2 使用 Valet（Mac 用户推荐）

```bash
# 如果已安装 Laravel Valet
cd /Users/mac/git/person/dujiaoka
valet link dujiaoka

# 访问地址
# http://dujiaoka.test
```

### 3.3 使用 Docker（可选）

如果项目有 docker-compose.yml：

```bash
docker-compose up -d
```

---

## 🔍 步骤 4：验证安装

### 4.1 检查路由

```bash
# 查看所有路由
php artisan route:list | grep affiliate

# 应该看到：
# GET|HEAD  | api/affiliate/coupon       | ...
# GET|HEAD  | admin/affiliate-code       | ...
# POST      | admin/affiliate-code       | ...
# ...
```

### 4.2 检查数据库表

```bash
mysql -u dujiaoka_user -p dujiaoka_dev -e "SHOW TABLES LIKE 'affiliate%';"

# 应该看到：
# affiliate_codes
# affiliate_codes_coupons
```

### 4.3 检查管理菜单

```bash
mysql -u dujiaoka_user -p dujiaoka_dev -e "SELECT * FROM admin_menu WHERE title='Affiliate_Code';"

# 应该有一条记录
```

---

## 🧪 步骤 5：创建测试数据

### 5.1 登录管理后台

访问：http://localhost:8000/admin

**默认账号**（如果是新安装）：
- 用户名：admin
- 密码：admin（请查看安装时设置的密码）

### 5.2 创建测试商品

1. 进入"商品管理" → "商品"
2. 创建一个测试商品（ID 会是 1、2、3...）
3. 记录商品 ID，例如：`3`

### 5.3 创建测试优惠码

进入"优惠码管理" → "优惠码"，创建以下测试优惠码：

| 优惠码 | 优惠金额 | 关联商品 | 状态 |
|--------|---------|---------|------|
| DISCOUNT5 | 5.00 | 商品 ID 3 | 启用 |
| SUMMER20 | 20.00 | 商品 ID 3 | 启用 |
| VIP50 | 50.00 | 商品 ID 3 | 启用 |

### 5.4 创建测试推广码

1. 进入"优惠码管理" → "Affiliate_Code"
2. 点击"新增"
3. **不要填写推广码**（系统自动生成）
4. 多选关联优惠码：选择 `DISCOUNT5`、`SUMMER20`、`VIP50`
5. 填写备注："本地测试推广码"
6. 点击"提交"

**记录生成的推广码**，例如：`aB3dE5Fg`

---

## 🐛 步骤 6：开始调试

### 6.1 启用详细日志

编辑 `.env`：
```bash
APP_DEBUG=true
LOG_LEVEL=debug
```

### 6.2 打开浏览器控制台

- Chrome/Edge：按 `F12` 或 `Cmd+Option+I` (Mac)
- Firefox：按 `F12` 或 `Cmd+Option+K` (Mac)
- Safari：开发 → 显示 JavaScript 控制台

### 6.3 测试场景 1：全局捕获

**访问**：
```
http://localhost:8000/?aff=aB3dE5Fg
```

**预期结果**：
- ✅ 控制台显示：`[Affiliate] 推广码已保存: aB3dE5Fg`
- ✅ Application → Local Storage → `affCode` 值为 `aB3dE5Fg`

**调试技巧**：
```javascript
// 在控制台查看 localStorage
console.log(localStorage.getItem('affCode'));

// 手动设置（用于测试）
localStorage.setItem('affCode', 'aB3dE5Fg');

// 清除（用于重新测试）
localStorage.removeItem('affCode');
```

### 6.4 测试场景 2：API 接口

**方式 1：浏览器直接访问**
```
http://localhost:8000/api/affiliate/coupon?aff=aB3dE5Fg&goods_id=3
```

**方式 2：使用 cURL**
```bash
curl "http://localhost:8000/api/affiliate/coupon?aff=aB3dE5Fg&goods_id=3"
```

**预期响应**：
```json
{
  "success": true,
  "coupon_code": "VIP50",
  "discount": 50.00,
  "message": "已自动应用优惠金额最大的优惠码"
}
```

**调试技巧**：
```bash
# 查看详细的 HTTP 请求和响应
curl -v "http://localhost:8000/api/affiliate/coupon?aff=aB3dE5Fg&goods_id=3"

# 格式化 JSON 输出
curl "http://localhost:8000/api/affiliate/coupon?aff=aB3dE5Fg&goods_id=3" | jq .
```

### 6.5 测试场景 3：购买页面自动填充

**访问**：
```
http://localhost:8000/buy/3
```

**观察**：
1. 打开控制台
2. 观察 AJAX 请求
3. 观察优惠码输入框

**预期结果**：
- ✅ 控制台显示：`[Affiliate] 检测到推广码: aB3dE5Fg`
- ✅ 控制台显示：`[Affiliate] 优惠码已自动填充: VIP50 优惠金额: 50`
- ✅ 优惠码输入框自动填充为 `VIP50`
- ✅ 显示绿色提示："✓ 已自动应用推广优惠码"

**调试技巧**：
```javascript
// 在控制台查看 Network 标签
// 找到 /api/affiliate/coupon 请求
// 查看 Request Headers、Response

// 查看输入框值
console.log($('#coupon_code_input').val());

// 查看隐藏字段
console.log($('#affiliate_code_hidden').val());
```

### 6.6 测试场景 4：完整订单流程

1. 在购买页面填写必要信息
2. 选择支付方式
3. 提交订单
4. 查看管理后台 → 推广码管理 → 使用次数是否 +1

**调试技巧**：
```bash
# 查看 Laravel 日志
tail -f storage/logs/laravel.log

# 查看推广码使用次数
mysql -u dujiaoka_user -p dujiaoka_dev -e "SELECT code, use_count FROM affiliate_codes WHERE code='aB3dE5Fg';"
```

---

## 🔧 常用调试命令

### Laravel Tinker（交互式调试）

```bash
php artisan tinker

# 测试服务
$service = app('Service\AffiliateCodeService');
$service->generateUniqueCode();

# 查询推广码
$code = \App\Models\AffiliateCode::where('code', 'aB3dE5Fg')->first();
$code->coupons;

# 测试 API
$service->getBestCouponByAffiliateCode('aB3dE5Fg', 3);
```

### 数据库查询

```bash
# 查看推广码
mysql -u dujiaoka_user -p dujiaoka_dev -e "SELECT * FROM affiliate_codes;"

# 查看关联关系
mysql -u dujiaoka_user -p dujiaoka_dev -e "SELECT * FROM affiliate_codes_coupons;"

# 查看优惠码
mysql -u dujiaoka_user -p dujiaoka_dev -e "SELECT id, coupon, discount FROM coupons WHERE is_open=1;"
```

### 日志查看

```bash
# 实时查看日志
tail -f storage/logs/laravel.log

# 查看推广码相关日志
grep "\[Affiliate\]" storage/logs/laravel.log

# 清空日志（谨慎使用）
> storage/logs/laravel.log
```

---

## 🐞 常见问题排查

### 问题 1：无法访问管理后台

**症状**：访问 `/admin` 返回 404

**排查**：
```bash
# 检查路由
php artisan route:list | grep admin

# 检查 .env 配置
cat .env | grep ADMIN_ROUTE_PREFIX

# 清除缓存
php artisan config:clear
php artisan route:clear
```

### 问题 2：推广码没有自动生成

**症状**：创建推广码时 code 字段为空

**排查**：
```bash
# 检查服务是否注册
php artisan tinker
app('Service\AffiliateCodeService');

# 查看错误日志
tail -f storage/logs/laravel.log
```

**解决方案**：
- 确保 `AppServiceProvider` 中已注册服务
- 运行 `composer dump-autoload`

### 问题 3：优惠码没有自动填充

**症状**：购买页面没有自动填充优惠码

**排查步骤**：
1. **检查 localStorage**：
   ```javascript
   console.log(localStorage.getItem('affCode'));
   ```

2. **检查 AJAX 请求**：
   - 打开 Network 标签
   - 查找 `/api/affiliate/coupon` 请求
   - 查看状态码和响应

3. **检查控制台错误**：
   - 是否有 JavaScript 错误
   - 是否有 AJAX 错误

4. **检查推广码状态**：
   ```sql
   SELECT * FROM affiliate_codes WHERE code='aB3dE5Fg';
   ```

### 问题 4：数据库连接失败

**症状**：SQLSTATE[HY000] [2002] Connection refused

**排查**：
```bash
# 检查 MySQL 是否运行
ps aux | grep mysql

# 或
brew services list | grep mysql  # Mac
sudo systemctl status mysql       # Linux

# 测试连接
mysql -u dujiaoka_user -p -h 127.0.0.1

# 检查 .env 配置
cat .env | grep DB_
```

### 问题 5：Class not found

**症状**：Class 'App\Service\AffiliateCodeService' not found

**解决方案**：
```bash
# 重新生成 autoload 文件
composer dump-autoload

# 清除缓存
php artisan config:clear
php artisan cache:clear
```

### 问题 6：使用次数没有增加

**症状**：订单创建成功但 use_count 没有 +1

**排查**：
```bash
# 查看 Laravel 日志
grep "\[Affiliate\]" storage/logs/laravel.log

# 检查隐藏字段是否提交
# 在 OrderController 中添加调试输出
dd($request->input('affiliate_code'));
```

---

## 📊 性能调试

### 启用 Query Log

在 `AppServiceProvider::boot()` 中添加：

```php
if (config('app.debug')) {
    DB::listen(function ($query) {
        \Log::info('SQL Query:', [
            'sql' => $query->sql,
            'bindings' => $query->bindings,
            'time' => $query->time,
        ]);
    });
}
```

### 使用 Laravel Debugbar

```bash
composer require barryvdh/laravel-debugbar --dev

# 清除缓存
php artisan config:clear
```

---

## 🎯 快速测试脚本

创建 `test_affiliate.sh`：

```bash
#!/bin/bash

# 测试推广码 API
echo "=== 测试推广码 API ==="
curl -s "http://localhost:8000/api/affiliate/coupon?aff=aB3dE5Fg&goods_id=3" | jq .

echo -e "\n=== 测试无效推广码 ==="
curl -s "http://localhost:8000/api/affiliate/coupon?aff=invalid999&goods_id=3" | jq .

echo -e "\n=== 测试缺少参数 ==="
curl -s "http://localhost:8000/api/affiliate/coupon?aff=aB3dE5Fg" | jq .

echo -e "\n=== 查询推广码使用次数 ==="
mysql -u dujiaoka_user -p'your_password' dujiaoka_dev -e "SELECT code, use_count, is_open FROM affiliate_codes WHERE code='aB3dE5Fg';"
```

运行：
```bash
chmod +x test_affiliate.sh
./test_affiliate.sh
```

---

## 📱 移动端调试

### iOS Safari

1. 在 Mac 上：Safari → 开发 → [你的 iPhone]
2. 访问移动端页面
3. 查看控制台输出

### Android Chrome

1. 在 Chrome 访问：`chrome://inspect`
2. 连接 Android 设备
3. 选择页面进行调试

### 移动端模拟

Chrome DevTools：
1. 按 `F12` 打开开发者工具
2. 点击设备工具栏图标（Ctrl+Shift+M）
3. 选择设备类型

---

## 🔒 安全提示

### 本地调试建议

1. **不要使用生产数据库**
2. **不要在 .env 中硬编码敏感信息**
3. **定期备份本地数据库**
4. **不要提交 .env 到版本控制**

### 数据库备份

```bash
# 备份
mysqldump -u dujiaoka_user -p dujiaoka_dev > backup_$(date +%Y%m%d).sql

# 恢复
mysql -u dujiaoka_user -p dujiaoka_dev < backup_20260111.sql
```

---

## 📚 相关文档

- **测试指南**：`docs/affiliate-system-testing-guide.md`
- **API 文档**：`docs/api/affiliate-api.md`
- **需求文档**：`.spec-workflow/specs/affiliate-code-system/requirements.md`

---

## 🎉 调试完成检查清单

完成本地调试后，确认以下检查项：

- [ ] 数据库连接成功
- [ ] 推广码表创建成功
- [ ] 管理菜单显示正常
- [ ] 可以创建推广码（自动生成）
- [ ] API 接口返回正确
- [ ] 全局捕获脚本工作正常
- [ ] 购买页面自动填充正常
- [ ] 用户可以手动修改优惠码
- [ ] 订单统计正常工作
- [ ] 日志记录正常

---

**调试愉快！** 🚀 如有问题，请查看日志文件或提交 Issue。
