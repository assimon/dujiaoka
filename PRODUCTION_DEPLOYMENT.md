# 推广码系统 - 生产环境部署指南

## ⚠️ 部署前必读

本次更新为**功能新增**，不会影响现有功能：
- ✅ 不修改现有数据库表
- ✅ 不修改现有业务逻辑（除订单统计部分为可选功能）
- ✅ 向后兼容，不会破坏现有订单流程
- ✅ 推广码功能独立，可选启用

**部署风险**：⭐ 低风险（仅新增功能，不影响核心业务）

---

## 一、部署前准备（15分钟）

### 1. 备份数据库

```bash
# 备份整个数据库
mysqldump -u your_user -p your_database > backup_$(date +%Y%m%d_%H%M%S).sql

# 或仅备份关键表
mysqldump -u your_user -p your_database \
  orders coupons goods > backup_critical_$(date +%Y%m%d_%H%M%S).sql
```

### 2. 备份代码

```bash
# 在生产服务器上
cd /path/to/dujiaoka
tar -czf ../dujiaoka_backup_$(date +%Y%m%d_%H%M%S).tar.gz .

# 或使用 Git tag
git tag v1.0.0-before-affiliate
git push origin v1.0.0-before-affiliate
```

### 3. 检查生产环境状态

```bash
# 检查 PHP 版本（需要 >= 7.2）
php -v

# 检查 Laravel 版本
php artisan --version

# 检查数据库连接
php artisan db:monitor --databases=mysql

# 检查磁盘空间
df -h

# 检查正在运行的进程
ps aux | grep php
```

---

## 二、部署步骤（零停机部署）

### 方式一：使用部署脚本（推荐）

我为您创建了自动化部署脚本（见下方），执行：

```bash
bash deploy-affiliate-production.sh
```

### 方式二：手动部署

#### 步骤 1：上传代码文件

将以下文件上传到生产服务器：

**新增文件**（9个）：
```bash
database/migrations/2026_01_11_000001_create_affiliate_codes_tables.php
database/sql/add_affiliate_code_menu.sql
app/Models/AffiliateCode.php
app/Service/AffiliateCodeService.php
app/Http/Controllers/Api/AffiliateController.php
app/Admin/Repositories/AffiliateCode.php
app/Admin/Controllers/AffiliateCodeController.php
```

**修改文件**（5个）：
```bash
app/Providers/AppServiceProvider.php
routes/common/web.php
app/Admin/routes.php
resources/views/luna/layouts/_script.blade.php
resources/views/luna/static_pages/buy.blade.php
app/Http/Controllers/Home/OrderController.php  # 可选：推广码统计功能
```

**上传方式**：
- Git pull（推荐）
- FTP/SFTP
- rsync

#### 步骤 2：开启维护模式（可选）

```bash
# 如果担心部署期间有问题，可以开启维护模式
php artisan down --message="系统升级中，预计5分钟" --retry=60

# 或允许特定IP访问（您的IP）
php artisan down --allow=YOUR_IP_ADDRESS
```

#### 步骤 3：执行数据库迁移

```bash
# 先检查迁移文件是否存在
ls -la database/migrations/2026_01_11_000001_create_affiliate_codes_tables.php

# 执行迁移（仅创建新表，不影响现有表）
php artisan migrate --path=database/migrations/2026_01_11_000001_create_affiliate_codes_tables.php

# 确认表已创建
php artisan tinker --execute="
echo 'affiliate_codes 表: ' . (Schema::hasTable('affiliate_codes') ? '✓ 已创建' : '✗ 不存在') . PHP_EOL;
echo 'affiliate_codes_coupons 表: ' . (Schema::hasTable('affiliate_codes_coupons') ? '✓ 已创建' : '✗ 不存在') . PHP_EOL;
"
```

#### 步骤 4：导入管理菜单

```bash
# 检查菜单是否已存在
mysql -u your_user -p your_database -e "SELECT * FROM admin_menu WHERE uri='/affiliate-code';"

# 如果不存在，导入菜单
mysql -u your_user -p your_database < database/sql/add_affiliate_code_menu.sql

# 确认导入成功
mysql -u your_user -p your_database -e "SELECT id, title, uri FROM admin_menu WHERE uri='/affiliate-code';"
```

#### 步骤 5：安装依赖（如有新增）

```bash
# 检查是否有新依赖
composer install --no-dev --optimize-autoloader

# 如果使用了 Redis
php artisan config:cache
```

#### 步骤 6：清除缓存

```bash
# 清除所有缓存
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 重新生成优化文件
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 如果使用了 OPcache，重启 PHP-FPM
sudo systemctl restart php-fpm
# 或
sudo service php7.4-fpm restart
```

#### 步骤 7：关闭维护模式

```bash
php artisan up
```

#### 步骤 8：验证部署

```bash
# 检查路由是否注册
php artisan route:list | grep affiliate

# 检查服务是否注册
php artisan tinker --execute="dd(app()->bound('Service\\AffiliateCodeService'));"

# 测试 API 接口（替换为您的域名）
curl "https://your-domain.com/api/affiliate/coupon?aff=test&goods_id=3"
```

---

## 三、生产环境测试（5分钟）

### 1. 后台管理测试

1. 登录管理后台：`https://your-domain.com/admin`
2. 检查菜单：**优惠码管理** → **Affiliate_Code**
3. 创建测试推广码：
   - 关联现有的优惠码
   - 验证推广码自动生成
   - 验证可以保存成功

### 2. 前端功能测试

1. 访问推广链接：`https://your-domain.com/?aff=<推广码>`
2. 打开浏览器控制台，查看是否有日志：
   ```
   [Affiliate] 推广码已保存: xxx
   ```
3. 访问购买页面：`https://your-domain.com/buy/<商品ID>`
4. 检查优惠码是否自动填充

### 3. API 接口测试

```bash
# 测试成功响应
curl "https://your-domain.com/api/affiliate/coupon?aff=<推广码>&goods_id=<商品ID>"

# 预期输出
# {"success":true,"coupon_code":"xxx","discount":50.00,"message":"已自动应用优惠金额最大的优惠码"}
```

### 4. 完整流程测试

1. 使用推广链接访问
2. 进入购买页面，确认优惠码自动填充
3. 完成一笔测试订单（小金额）
4. 检查推广码使用次数是否 +1

---

## 四、回滚方案（如遇问题）

### 快速回滚步骤

```bash
# 1. 开启维护模式
php artisan down

# 2. 回滚代码
git reset --hard <之前的commit>
# 或恢复备份
cd ..
tar -xzf dujiaoka_backup_<timestamp>.tar.gz -C dujiaoka/

# 3. 回滚数据库（仅删除新增的表）
mysql -u your_user -p your_database -e "
DROP TABLE IF EXISTS affiliate_codes_coupons;
DROP TABLE IF EXISTS affiliate_codes;
DELETE FROM admin_menu WHERE uri='/affiliate-code';
"

# 4. 清除缓存
cd dujiaoka
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# 5. 关闭维护模式
php artisan up
```

**重要**：回滚不会影响现有订单和优惠码数据。

---

## 五、性能优化建议

### 1. 数据库索引（已包含在迁移中）

```sql
-- 已创建的索引
-- affiliate_codes.code (UNIQUE)
-- affiliate_codes_coupons.affiliate_code_id
-- affiliate_codes_coupons.coupon_id
-- affiliate_codes_coupons.(affiliate_code_id, coupon_id) UNIQUE
```

### 2. 缓存优化（可选）

如果推广码访问量大，可以添加缓存：

```php
// 在 AffiliateCodeService.php 的 getBestCouponByAffiliateCode 方法中
$cacheKey = "affiliate_coupon_{$affCode}_{$goodsId}";
return Cache::remember($cacheKey, 3600, function() use ($affCode, $goodsId) {
    // 原有逻辑
});
```

### 3. 日志优化

生产环境建议将推广码相关日志级别调整为 `info`：

```php
// 在 OrderController.php 中
\Log::info('[Affiliate] 推广码统计', [...]);  // 改为 info
```

---

## 六、监控建议

### 1. 错误监控

关注以下日志关键词：

```bash
# 实时监控推广码相关日志
tail -f storage/logs/laravel.log | grep -i affiliate

# 查看错误日志
tail -f storage/logs/laravel.log | grep -i error | grep -i affiliate
```

### 2. 性能监控

监控 API 响应时间：

```bash
# 使用 curl 测试响应时间
curl -w "@-" -o /dev/null -s "https://your-domain.com/api/affiliate/coupon?aff=test&goods_id=3" <<'EOF'
time_namelookup:  %{time_namelookup}s\n
time_connect:  %{time_connect}s\n
time_appconnect:  %{time_appconnect}s\n
time_pretransfer:  %{time_pretransfer}s\n
time_starttransfer:  %{time_starttransfer}s\n
time_total:  %{time_total}s\n
EOF
```

目标：`time_total` < 0.5s

### 3. 数据监控

定期检查推广码使用情况：

```bash
php artisan tinker --execute="
echo '推广码统计：' . PHP_EOL;
echo '总数：' . App\Models\AffiliateCode::count() . PHP_EOL;
echo '启用：' . App\Models\AffiliateCode::where('is_open', 1)->count() . PHP_EOL;
echo '已使用：' . App\Models\AffiliateCode::where('use_count', '>', 0)->count() . PHP_EOL;
echo '总使用次数：' . App\Models\AffiliateCode::sum('use_count') . PHP_EOL;
"
```

---

## 七、常见问题处理

### 问题 1：迁移失败 - 表已存在

```bash
# 检查表是否已存在
mysql -u your_user -p your_database -e "SHOW TABLES LIKE 'affiliate%';"

# 如果已存在且是测试数据，可以删除后重新迁移
mysql -u your_user -p your_database -e "
DROP TABLE IF EXISTS affiliate_codes_coupons;
DROP TABLE IF EXISTS affiliate_codes;
"

# 重新迁移
php artisan migrate --path=database/migrations/2026_01_11_000001_create_affiliate_codes_tables.php
```

### 问题 2：菜单已存在

```bash
# 删除重复菜单
mysql -u your_user -p your_database -e "
DELETE FROM admin_menu WHERE uri='/affiliate-code';
"

# 重新导入
mysql -u your_user -p your_database < database/sql/add_affiliate_code_menu.sql
```

### 问题 3：前端没有反应

```bash
# 清除浏览器缓存
# 检查 _script.blade.php 是否更新
grep -n "affCode" resources/views/luna/layouts/_script.blade.php

# 清除服务器缓存
php artisan view:clear
php artisan cache:clear

# 重启 PHP-FPM（如果使用）
sudo systemctl restart php-fpm
```

### 问题 4：API 返回 404

```bash
# 检查路由文件是否更新
grep -n "affiliate" routes/common/web.php

# 清除路由缓存
php artisan route:clear
php artisan route:cache

# 检查路由列表
php artisan route:list | grep affiliate
```

### 问题 5：服务未注册

```bash
# 检查 AppServiceProvider.php 是否更新
grep -n "AffiliateCodeService" app/Providers/AppServiceProvider.php

# 清除配置缓存
php artisan config:clear
php artisan cache:clear

# 重启 PHP-FPM
sudo systemctl restart php-fpm
```

---

## 八、部署检查清单

部署完成后，逐项检查：

- [ ] 数据库已备份
- [ ] 代码已备份
- [ ] 数据库迁移执行成功
- [ ] 管理菜单导入成功
- [ ] 所有缓存已清除
- [ ] 路由已注册（`php artisan route:list | grep affiliate`）
- [ ] 服务已注册（`app()->bound('Service\\AffiliateCodeService')`）
- [ ] 后台可以访问推广码管理页面
- [ ] 可以创建推广码
- [ ] 前端可以捕获推广码（控制台有日志）
- [ ] 购买页面可以自动填充优惠码
- [ ] API 接口返回正确（`curl` 测试）
- [ ] 完成测试订单，使用次数 +1
- [ ] 现有功能未受影响（下单、支付、查询等）
- [ ] 日志中无错误信息

---

## 九、上线通知（可选）

如果需要通知用户新功能：

### 管理员通知

```
【系统升级通知】

尊敬的管理员：

系统已成功部署"推广码"功能，现在可以：

1. 创建推广链接分享给用户
2. 推广码自动关联优惠码
3. 实时统计推广效果

使用方法：
- 进入后台 → 优惠码管理 → Affiliate_Code
- 创建推广码并关联优惠码
- 分享推广链接：https://your-domain.com/?aff=<推广码>

详细文档：https://your-domain.com/docs/affiliate-guide
```

### 用户通知（可选）

```
【新功能上线】

现在可以使用推广链接享受专属优惠！

使用方法：
1. 通过推广链接访问网站
2. 进入商品购买页面
3. 系统自动应用最优优惠码

更多详情请咨询客服。
```

---

## 十、后续维护

### 定期检查（每周）

```bash
# 检查推广码使用情况
php artisan tinker --execute="
App\Models\AffiliateCode::where('use_count', '>', 0)
    ->orderBy('use_count', 'desc')
    ->take(10)
    ->get(['code', 'use_count', 'remark'])
    ->each(function(\$aff) {
        echo \$aff->code . ' | ' . \$aff->use_count . ' 次 | ' . \$aff->remark . PHP_EOL;
    });
"
```

### 性能优化（每月）

```bash
# 检查推广码表大小
mysql -u your_user -p your_database -e "
SELECT
    table_name AS 'Table',
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'Size (MB)'
FROM information_schema.TABLES
WHERE table_schema = 'your_database'
AND table_name IN ('affiliate_codes', 'affiliate_codes_coupons');
"
```

### 数据清理（按需）

```bash
# 清理已删除的推广码（软删除）
php artisan tinker --execute="
App\Models\AffiliateCode::onlyTrashed()->forceDelete();
echo '已清理软删除数据' . PHP_EOL;
"
```

---

## 需要帮助？

- 📞 部署遇到问题：查看本文档「常见问题处理」章节
- 📖 功能测试：参考 `docs/affiliate-system-testing-guide.md`
- 📡 API 文档：参考 `docs/api/affiliate-api.md`
- 🔧 本地调试：参考 `docs/LOCAL_DEBUG_GUIDE.md`

---

**部署完成！祝业务蒸蒸日上！** 🚀
