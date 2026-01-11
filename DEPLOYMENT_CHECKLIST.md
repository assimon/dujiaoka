# 推广码系统 - 生产部署检查清单

## 📋 部署前检查（15分钟）

### 1. 备份

- [ ] 备份数据库
  ```bash
  mysqldump -u user -p database > backup_$(date +%Y%m%d).sql
  ```
- [ ] 备份代码（Git tag 或文件备份）
  ```bash
  git tag v1.0.0-before-affiliate
  ```
- [ ] 记录当前系统状态

### 2. 环境检查

- [ ] PHP 版本 >= 7.2
- [ ] Laravel 正常运行
- [ ] 数据库连接正常
- [ ] 磁盘空间充足（至少 1GB）

### 3. 代码准备

- [ ] 所有新增文件已上传（9个文件）
- [ ] 所有修改文件已更新（5个文件）
- [ ] 迁移文件存在
- [ ] SQL 文件存在

---

## 🚀 部署步骤（10分钟）

### 方式一：自动部署（推荐）

```bash
bash deploy-affiliate-production.sh
```

✅ 脚本自动完成所有步骤，包括备份、迁移、验证

### 方式二：手动部署

- [ ] **步骤 1**: 开启维护模式（可选）
  ```bash
  php artisan down --message="系统升级中" --retry=60
  ```

- [ ] **步骤 2**: 上传代码文件

- [ ] **步骤 3**: 执行数据库迁移
  ```bash
  php artisan migrate --path=database/migrations/2026_01_11_000001_create_affiliate_codes_tables.php
  ```

- [ ] **步骤 4**: 导入管理菜单
  ```bash
  mysql -u user -p database < database/sql/add_affiliate_code_menu.sql
  ```

- [ ] **步骤 5**: 清除缓存
  ```bash
  php artisan cache:clear
  php artisan config:clear
  php artisan route:clear
  php artisan view:clear
  ```

- [ ] **步骤 6**: 重新生成缓存
  ```bash
  php artisan config:cache
  php artisan route:cache
  ```

- [ ] **步骤 7**: 重启 PHP-FPM（建议）
  ```bash
  sudo systemctl restart php-fpm
  ```

- [ ] **步骤 8**: 关闭维护模式
  ```bash
  php artisan up
  ```

---

## ✅ 部署验证（5分钟）

### 1. 后端验证

- [ ] 路由已注册
  ```bash
  php artisan route:list | grep affiliate
  ```
  预期：看到 8 条路由（7个后台 + 1个API）

- [ ] 服务已注册
  ```bash
  php artisan tinker --execute="dd(app()->bound('Service\\AffiliateCodeService'));"
  ```
  预期：返回 `true`

- [ ] 表已创建
  ```bash
  mysql -u user -p database -e "SHOW TABLES LIKE 'affiliate%';"
  ```
  预期：看到 2 个表

- [ ] 菜单已导入
  ```bash
  mysql -u user -p database -e "SELECT * FROM admin_menu WHERE uri='/affiliate-code';"
  ```
  预期：返回 1 条记录

### 2. 功能验证

- [ ] 访问管理后台：`https://your-domain.com/admin`
- [ ] 找到菜单：**优惠码管理** → **Affiliate_Code**
- [ ] 创建测试推广码（关联现有优惠码）
- [ ] 推广码自动生成（8位字符）
- [ ] 保存成功

### 3. 前端验证

- [ ] 访问推广链接：`https://your-domain.com/?aff=<code>`
- [ ] 打开浏览器控制台
- [ ] 查看控制台输出：`[Affiliate] 推广码已保存: xxx`
- [ ] 查看 localStorage：存在 `affCode` 键

### 4. API 验证

- [ ] 测试 API 接口
  ```bash
  curl "https://your-domain.com/api/affiliate/coupon?aff=<code>&goods_id=3"
  ```
  预期：返回 JSON，包含 `success`, `coupon_code`, `discount`

### 5. 完整流程验证

- [ ] 使用推广链接访问
- [ ] 进入购买页面
- [ ] 优惠码自动填充
- [ ] 完成测试订单（小金额）
- [ ] 检查推广码使用次数 +1
- [ ] 检查优惠码使用次数 +1

### 6. 现有功能验证

- [ ] 正常下单流程未受影响
- [ ] 不使用推广码也能正常购买
- [ ] 手动输入优惠码正常
- [ ] 支付流程正常
- [ ] 订单查询正常

---

## 🔍 监控检查（部署后24小时）

### 实时监控

```bash
# 监控推广码相关日志
tail -f storage/logs/laravel.log | grep -i affiliate

# 监控错误日志
tail -f storage/logs/laravel.log | grep -i error
```

### 数据检查

- [ ] 推广码创建数量正常
- [ ] API 调用无异常
- [ ] 订单创建未受影响
- [ ] 使用次数统计正常

### 性能检查

- [ ] API 响应时间 < 500ms
  ```bash
  curl -w "time_total: %{time_total}s\n" \
    "https://your-domain.com/api/affiliate/coupon?aff=test&goods_id=3"
  ```
- [ ] 数据库查询效率正常
- [ ] 服务器负载正常

---

## 🚨 回滚方案（如遇严重问题）

### 快速回滚步骤

1. [ ] 开启维护模式
   ```bash
   php artisan down
   ```

2. [ ] 删除新增的表
   ```bash
   mysql -u user -p database -e "
   DROP TABLE IF EXISTS affiliate_codes_coupons;
   DROP TABLE IF EXISTS affiliate_codes;
   DELETE FROM admin_menu WHERE uri='/affiliate-code';
   "
   ```

3. [ ] 恢复代码
   ```bash
   git reset --hard <之前的commit>
   ```

4. [ ] 清除缓存
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   ```

5. [ ] 关闭维护模式
   ```bash
   php artisan up
   ```

**注意**：回滚不会影响现有订单和优惠码数据

---

## 📊 成功标准

部署成功的标志：

✅ 所有验证项通过
✅ 可以创建推广码
✅ 推广链接可以捕获
✅ 购买页面可以自动填充
✅ API 接口返回正确
✅ 订单统计正常
✅ 现有功能未受影响
✅ 日志无错误
✅ 性能无明显下降

---

## 📞 问题排查

### 常见问题快速定位

| 问题 | 检查命令 | 解决方案 |
|------|---------|---------|
| 路由 404 | `php artisan route:list \| grep affiliate` | `php artisan route:cache` |
| 服务未注册 | `app()->bound('Service\\AffiliateCodeService')` | 检查 AppServiceProvider.php |
| 前端没反应 | 浏览器控制台查看错误 | `php artisan view:clear` |
| API 500 错误 | 查看 `storage/logs/laravel.log` | 检查服务注册和数据库 |
| 使用次数不增加 | 查看日志中的 `[Affiliate]` | 检查 OrderController.php |

---

## 📝 部署记录

**部署日期**：____________________

**部署人员**：____________________

**部署耗时**：____________________

**备份位置**：____________________

**问题记录**：

-

**改进建议**：

-

---

## 📚 相关文档

- 📖 **详细部署指南**：`PRODUCTION_DEPLOYMENT.md`
- 🚀 **快速开始**：`QUICK_START.md`
- 🧪 **测试指南**：`docs/affiliate-system-testing-guide.md`
- 📡 **API 文档**：`docs/api/affiliate-api.md`
- 🔧 **本地调试**：`docs/LOCAL_DEBUG_GUIDE.md`

---

**部署检查清单 v1.0** | 最后更新：2026-01-11
