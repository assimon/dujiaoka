# aff推广码管理菜单修复文档

## 问题说明

### 现象
后台管理界面看不到"推广码管理"菜单入口

### 根本原因
1. `database/sql/install.sql` 中缺少菜单记录（当前最后ID=25是Email_Test）
2. 多语言翻译文件中缺少 `affiliate_code` 的翻译配置

### 功能完成度
aff推广码功能的核心代码已完整实现：
- ✅ 数据库表（affiliate_codes, affiliate_codes_coupons）
- ✅ 模型和服务（AffiliateCode, AffiliateCodeService）
- ✅ API接口（/api/affiliate/coupon）
- ✅ 管理后台控制器（AffiliateCodeController）
- ✅ 前端捕获脚本（localStorage存储）
- ✅ 购买页面自动应用逻辑
- ✅ 订单统计集成
- ❌ 管理后台菜单配置（本次修复）

---

## 修复方案

### 1. 修改 install.sql

**文件**: `database/sql/install.sql`

**位置**: 第47行之后（在 Email_Test 记录后）

**添加内容**:
```sql
INSERT INTO `admin_menu` VALUES (26, 18, 17, 'Affiliate_Code', 'fa-share-alt', '/affiliate-code', '', 1, '2026-01-11 12:00:00', '2026-01-11 12:00:00');
```

**字段说明**:
- `26` - 菜单ID（递增，Email_Test是25）
- `18` - parent_id（优惠管理Coupon_Manage的ID）
- `17` - order（显示顺序，在Coupon的16之后）
- `'Affiliate_Code'` - 菜单标题key（对应多语言文件）
- `'fa-share-alt'` - Font Awesome图标（分享/推广图标）
- `'/affiliate-code'` - 路由URI（对应AffiliateCodeController）
- `''` - extension（扩展，为空）
- `1` - show（是否显示，1=显示）
- 时间戳 - created_at 和 updated_at

---

### 2. 添加中文简体翻译

**文件**: `resources/lang/zh_CN/menu.php`

**位置**: 在 `'coupon'` 键值对之后添加

**添加内容**:
```php
        'affiliate_code'=> '推广码管理',
```

**完整context**:
```php
        'coupon_manage' => '优惠管理',
        'coupon'        => '优惠码列表',
        'affiliate_code'=> '推广码管理',  // 新增
        'configuration' => '配置',
```

---

### 3. 添加中文繁体翻译

**文件**: `resources/lang/zh_TW/menu.php`

**位置**: 在 `'coupon'` 键值对之后添加

**添加内容**:
```php
        'affiliate_code'=> '推廣碼管理',
```

**完整context**:
```php
        'coupon_manage' => '折扣管理',
        'coupon'        => '折扣碼清單',
        'affiliate_code'=> '推廣碼管理',  // 新增
        'configuration' => '配置',
```

---

### 4. 创建英文翻译文件

**文件**: `resources/lang/en/menu.php`（新建文件）

**完整内容**:
```php
<?php

return [
    'titles' => [
        'index'         => 'Home',
        'admin'         => 'System',
        'users'         => 'Users',
        'roles'         => 'Roles',
        'permission'    => 'Permission',
        'menu'          => 'Menu',
        'extensions'    => 'Extensions',

        'goods_manage'  => 'Goods Management',
        'goods'         => 'Goods',
        'goods_group'   => 'Goods Group',
        'carmis_manage' => 'Card Management',
        'carmis'        => 'Cards',
        'import_carmis' => 'Import Cards',
        'coupon_manage' => 'Coupon Management',
        'coupon'        => 'Coupon List',
        'affiliate_code'=> 'Affiliate Code',
        'configuration' => 'Configuration',
        'email_template_configuration' => 'Email Template Configuration',
        'pay_configuration'  => 'Payment Configuration',
        'order_manage' => 'Sales Data',
        'order'        => 'Order List',
        'system_setting' => 'System Settings',
        'email_test' => 'Email Test'
    ],
];
```

---

### 5. 创建生产环境迁移SQL

**文件**: `database/sql/migrate_affiliate_menu.sql`（新建文件）

**用途**: 为已部署的生产环境添加菜单，无需重新执行install.sql

**完整内容**:
```sql
-- 推广码菜单迁移脚本（用于现有部署环境）
-- 执行日期: 2026-01-16
-- 用途: 为已部署的系统添加aff推广码菜单

-- 清理可能存在的旧记录（防止重复）
DELETE FROM `admin_menu` WHERE id = 26 OR (parent_id = 18 AND uri = '/affiliate-code');

-- 添加推广码菜单
INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `extension`, `show`, `created_at`, `updated_at`)
VALUES (26, 18, 17, 'Affiliate_Code', 'fa-share-alt', '/affiliate-code', '', 1, NOW(), NOW());

-- 验证插入结果
SELECT id, parent_id, title, uri, created_at FROM `admin_menu` WHERE uri = '/affiliate-code';
```

---

## 使用说明

### 新部署环境
新环境执行 `install.sql` 会自动包含推广码菜单，无需额外操作。

### 已部署环境（生产环境）

#### 步骤1: 备份数据库
```bash
mysqldump -u 用户名 -p 数据库名 admin_menu > admin_menu_backup.sql
```

#### 步骤2: 执行迁移SQL
```bash
mysql -u 用户名 -p 数据库名 < database/sql/migrate_affiliate_menu.sql
```

#### 步骤3: 更新代码
```bash
git pull origin feat/aff
# 或者手动更新多语言文件
```

#### 步骤4: 清除Laravel缓存
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

#### 步骤5: 验证菜单显示
1. 访问后台：`https://your-domain.com/admin`
2. 查看左侧菜单：**优惠管理 → 推广码管理**
3. 点击进入：`https://your-domain.com/admin/affiliate-code`
4. 验证CRUD功能正常

---

## 验证检查清单

### 代码层验证
```bash
# 验证install.sql包含新菜单
grep "Affiliate_Code" database/sql/install.sql
# 期望输出: INSERT INTO `admin_menu` VALUES (26, 18, 17, 'Affiliate_Code'...

# 验证多语言文件
grep "affiliate_code" resources/lang/*/menu.php
# 期望输出:
# resources/lang/zh_CN/menu.php:        'affiliate_code'=> '推广码管理',
# resources/lang/zh_TW/menu.php:        'affiliate_code'=> '推廣碼管理',
# resources/lang/en/menu.php:        'affiliate_code'=> 'Affiliate Code',

# 验证路由存在
php artisan route:list | grep affiliate-code
# 期望输出: GET|HEAD|POST|PUT|PATCH|DELETE  admin/affiliate-code
```

### 数据库层验证
```sql
-- 查询菜单记录
SELECT id, parent_id, `order`, title, uri, created_at
FROM admin_menu
WHERE uri = '/affiliate-code';

-- 期望结果:
-- id: 26
-- parent_id: 18
-- order: 17
-- title: Affiliate_Code
-- uri: /affiliate-code
```

### 功能验证
- [ ] 后台菜单栏显示"推广码管理"
- [ ] 点击菜单可进入列表页
- [ ] 列表页显示推广码数据（如有）
- [ ] 可以创建新推广码
- [ ] 可以编辑现有推广码
- [ ] 可以关联优惠码
- [ ] 使用次数统计正常显示

---

## 菜单架构

```
优惠管理 (Coupon_Manage, ID=18)
├── 优惠码列表 (Coupon, ID=17, order=16)
└── 推广码管理 (Affiliate_Code, ID=26, order=17) ← 新增
```

---

## 菜单显示原理

系统使用以下流程显示菜单标题：

```
1. 读取 admin_menu 表的 title 字段
   例: 'Affiliate_Code'

2. 根据用户当前语言获取对应翻译文件
   中文: resources/lang/zh_CN/menu.php
   繁体: resources/lang/zh_TW/menu.php
   英文: resources/lang/en/menu.php

3. 查找 titles 数组中的键（转小写+下划线）
   'Affiliate_Code' -> 'affiliate_code'

4. 显示对应的翻译值
   中文: '推广码管理'
   繁体: '推廣碼管理'
   英文: 'Affiliate Code'
```

**关键**: 数据库中的 `title` 字段必须与多语言文件中的 key 能够对应（不区分大小写，下划线转换）

---

## 注意事项

1. **ID冲突**: 如果生产环境已有ID=26的其他菜单，需要调整ID值
2. **权限配置**: 如果菜单显示但无法访问，需检查 `admin_role_menu` 表的权限配置
3. **缓存清除**: 修改配置文件后必须清除Laravel缓存才能生效
4. **时间戳格式**: install.sql使用固定时间戳，迁移SQL使用NOW()函数
5. **多语言一致性**: 确保三个语言文件都包含 `affiliate_code` 键

---

## 回滚方案

### 数据库回滚
```sql
DELETE FROM `admin_menu` WHERE id = 26 AND uri = '/affiliate-code';
```

### 代码回滚
```bash
# 从install.sql移除第48行菜单记录
# 从zh_CN/menu.php移除 affiliate_code 行
# 从zh_TW/menu.php移除 affiliate_code 行
# 删除 en/menu.php 文件
# 删除 migrate_affiliate_menu.sql 文件
```

---

## 技术参考

### 相关文件
- `app/Admin/Controllers/AffiliateCodeController.php` - 管理后台控制器
- `app/Admin/Repositories/AffiliateCode.php` - 数据仓库
- `app/Admin/routes.php` - 管理后台路由定义
- `app/Models/AffiliateCode.php` - 推广码模型
- `app/Service/AffiliateCodeService.php` - 推广码业务服务
- `database/migrations/2026_01_11_000001_create_affiliate_codes_tables.php` - 数据库迁移

### API端点
- `GET /api/affiliate/coupon?aff=xxx&goods_id=1` - 根据推广码获取最优优惠码

### 前端集成
- `resources/views/luna/layouts/_script.blade.php` - 全局推广码捕获脚本
- `resources/views/luna/static_pages/buy.blade.php` - 购买页面自动应用逻辑

---

## 修复日期
2026-01-16

## 修复版本
feat/aff 分支

## 维护人员
Claude Code
