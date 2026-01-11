-- 添加推广码管理菜单
-- Parent: Coupon_Manage (id=18)
-- Order: 17 (在 Coupon 之后)

INSERT INTO `admin_menu` (`parent_id`, `order`, `title`, `icon`, `uri`, `extension`, `show`, `created_at`, `updated_at`)
VALUES (18, 17, 'Affiliate_Code', 'fa-share-alt', '/affiliate-code', '', 1, NOW(), NOW());

-- 说明：
-- parent_id = 18: 父菜单为"优惠码管理"（Coupon_Manage）
-- order = 17: 显示顺序为 17，在 Coupon (order=16) 之后
-- title = 'Affiliate_Code': 菜单标题（多语言 key）
-- icon = 'fa-share-alt': Font Awesome 图标（分享图标）
-- uri = '/affiliate-code': 路由 URI，对应管理后台路由
-- show = 1: 显示菜单
