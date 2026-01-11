# 推广码系统 - 快速开始指南

## 一、环境配置（5分钟）

### 方式一：使用自动化脚本（推荐）

```bash
# 运行自动配置脚本
bash setup-affiliate-debug.sh
```

脚本会自动完成：
- ✅ 检查并配置数据库连接
- ✅ 运行数据库迁移
- ✅ 导入管理菜单
- ✅ 清除缓存

### 方式二：手动配置

<details>
<summary>点击展开手动步骤</summary>

#### 1. 配置数据库

编辑 `.env` 文件：

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dujiaoka_dev        # 修改这里
DB_USERNAME=root                 # 修改这里
DB_PASSWORD=your_password        # 修改这里
```

#### 2. 创建数据库

```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS dujiaoka_dev CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

#### 3. 运行迁移

```bash
php artisan migrate --path=database/migrations/2026_01_11_000001_create_affiliate_codes_tables.php
```

#### 4. 导入菜单

```bash
mysql -u root -p dujiaoka_dev < database/sql/add_affiliate_code_menu.sql
```

#### 5. 清除缓存

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

</details>

---

## 二、启动开发服务器

```bash
php artisan serve
```

访问：http://localhost:8000

---

## 三、创建测试数据（3分钟）

### 1. 登录管理后台

访问：http://localhost:8000/admin

### 2. 创建测试优惠码

进入：**优惠码管理** → **Coupon**

创建 3 个优惠码：

| 优惠码 | 优惠金额 | 关联商品 | 状态 |
|--------|---------|---------|------|
| DISCOUNT5 | 5元 | 商品ID=3 | 启用 |
| SUMMER20 | 20元 | 商品ID=3 | 启用 |
| VIP50 | 50元 | 商品ID=3 | 启用 |

### 3. 创建推广码

进入：**优惠码管理** → **Affiliate_Code**

点击**新增**：
- **推广码**：自动生成（无需填写）
- **关联优惠码**：多选 `DISCOUNT5`、`SUMMER20`、`VIP50`
- **是否启用**：✅ 启用
- **备注**：测试推广码

点击**提交**，系统自动生成推广码，例如：`aB3dE5Fg`

---

## 四、功能测试

### 测试 1：URL 推广码捕获

1. 访问：http://localhost:8000/?aff=aB3dE5Fg
2. 打开浏览器控制台（F12）
3. 查看 Console 输出：
   ```
   [Affiliate] 推广码已保存: aB3dE5Fg
   ```
4. 查看 Application → Local Storage → `affCode`

**预期**：✅ localStorage 中存储了推广码

---

### 测试 2：购买页面自动填充

1. 访问：http://localhost:8000/buy/3（不带 aff 参数）
2. 打开浏览器控制台
3. 观察优惠码输入框

**预期**：
- ✅ 优惠码输入框自动填充：`VIP50`（优惠金额最大的）
- ✅ 显示绿色提示：「✓ 已自动应用推广优惠码」
- ✅ 控制台输出：
  ```
  [Affiliate] 检测到推广码: aB3dE5Fg
  [Affiliate] 优惠码已自动填充: VIP50 优惠金额: 50
  ```

---

### 测试 3：API 接口测试

使用便捷脚本：

```bash
bash test-affiliate-api.sh aB3dE5Fg 3
```

或手动测试：

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

---

### 测试 4：完成订单并验证统计

1. 在购买页面填写必填信息（邮箱、数量等）
2. 选择支付方式
3. 提交订单
4. 完成支付（或模拟支付成功）
5. 返回管理后台 → **Affiliate_Code**

**预期**：
- ✅ 订单价格正确应用了 50 元优惠
- ✅ 推广码 `aB3dE5Fg` 的「使用次数」从 0 变为 1
- ✅ 优惠码 `VIP50` 的使用次数也 +1

---

## 五、常见问题

### Q1: 优惠码没有自动填充？

**排查步骤**：
1. 检查 localStorage 中是否有 `affCode`
2. 检查浏览器控制台是否有错误
3. 检查推广码是否启用：
   ```bash
   php artisan tinker --execute="App\Models\AffiliateCode::where('code', 'aB3dE5Fg')->first();"
   ```
4. 检查关联的优惠码是否适用于当前商品

### Q2: API 返回 500 错误？

**排查步骤**：
1. 查看 Laravel 日志：
   ```bash
   tail -f storage/logs/laravel.log
   ```
2. 检查服务是否已注册：
   ```bash
   php artisan tinker --execute="dd(app()->bound('Service\\AffiliateCodeService'));"
   ```
3. 清除缓存后重试

### Q3: 使用次数没有增加？

**排查步骤**：
1. 检查订单是否创建成功
2. 查看日志中是否有 `[Affiliate]` 相关警告
3. 检查隐藏字段 `affiliate_code` 是否有值：
   ```javascript
   // 在购买页面控制台执行
   console.log($('#affiliate_code_hidden').val());
   ```

---

## 六、工具脚本

### 1. 环境配置脚本

```bash
bash setup-affiliate-debug.sh
```

### 2. API 测试脚本

```bash
bash test-affiliate-api.sh <推广码> <商品ID>
```

### 3. 数据库查询

```bash
# 查看所有推广码
php artisan tinker --execute="App\Models\AffiliateCode::with('coupons')->get();"

# 查看推广码使用统计
php artisan tinker --execute="
App\Models\AffiliateCode::select('code', 'use_count', 'is_open')->get()->each(function(\$aff) {
    echo \$aff->code . ' | 使用次数: ' . \$aff->use_count . ' | 状态: ' . (\$aff->is_open ? '启用' : '禁用') . PHP_EOL;
});
"
```

---

## 七、完整测试场景

详细测试指南请查看：

📄 **[推广码系统测试指南](docs/affiliate-system-testing-guide.md)**

包含 12 个完整测试场景：
- 场景 1: 管理员创建推广码（多优惠码关联）
- 场景 2: 全局推广码捕获
- 场景 3: 购买页面自动填充（多优惠码场景）
- 场景 4: 用户手动修改优惠码
- 场景 5: 完成订单并验证统计
- 场景 6: 推广码无效或禁用
- 场景 7: 优惠码不适用于当前商品
- 场景 8: 直接访问购买页面（带 aff 参数）
- 场景 9: 管理后台编辑推广码
- 场景 10: 推广码禁用测试
- 场景 11: 一键复制推广码
- 场景 12: 推广码详情页

---

## 八、API 文档

完整 API 文档请查看：

📄 **[推广码 API 接口文档](docs/api/affiliate-api.md)**

包含：
- 接口详情（请求/响应格式）
- 业务逻辑说明
- 请求示例（cURL、Fetch、jQuery、Axios）
- 前端集成步骤
- 错误处理建议

---

## 九、调试技巧

### 查看实时日志

```bash
tail -f storage/logs/laravel.log | grep -i affiliate
```

### 启用 SQL 查询日志

在 `app/Providers/AppServiceProvider.php` 的 `boot()` 方法中添加：

```php
\DB::listen(function($query) {
    if (strpos($query->sql, 'affiliate') !== false) {
        \Log::info('SQL: ' . $query->sql, ['bindings' => $query->bindings]);
    }
});
```

### 查看路由

```bash
php artisan route:list | grep affiliate
```

---

## 十、下一步

完成基础测试后，可以：

1. **测试边界情况**：多优惠码场景、不适用商品、无效推广码
2. **性能测试**：测试 API 响应时间（目标 < 500ms）
3. **浏览器兼容性**：在 Chrome、Firefox、Safari、Edge 中测试
4. **多主题适配**：如果使用了 hyper 或 unicorn 主题，需要做相应修改
5. **生产部署**：参考 `docs/LOCAL_DEBUG_GUIDE.md` 的生产环境建议

---

## 需要帮助？

- 📖 详细调试指南：[docs/LOCAL_DEBUG_GUIDE.md](docs/LOCAL_DEBUG_GUIDE.md)
- 🧪 测试指南：[docs/affiliate-system-testing-guide.md](docs/affiliate-system-testing-guide.md)
- 📡 API 文档：[docs/api/affiliate-api.md](docs/api/affiliate-api.md)
- 📋 任务清单：[.spec-workflow/specs/affiliate-code-system/tasks.md](.spec-workflow/specs/affiliate-code-system/tasks.md)

祝调试顺利！🚀
