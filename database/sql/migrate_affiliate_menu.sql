-- 推广码菜单迁移脚本（用于现有部署环境）
-- 执行日期: 2026-01-16
-- 用途: 为已部署的系统添加aff推广码菜单
-- 使用方法: mysql -u 用户名 -p 数据库名 < database/sql/migrate_affiliate_menu.sql

-- 清理可能存在的旧记录（防止重复）
DELETE FROM `admin_menu` WHERE id = 26 OR (parent_id = 18 AND uri = 'affiliate-code') OR (parent_id = 18 AND uri = '/affiliate-code');

-- 添加推广码菜单
INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `extension`, `show`, `created_at`, `updated_at`)
VALUES (26, 18, 17, 'Affiliate_Code', 'fa-share-alt', 'affiliate-code', '', 1, NOW(), NOW());

-- 验证插入结果
SELECT id, parent_id, `order`, title, uri, created_at FROM `admin_menu` WHERE uri = 'affiliate-code';
