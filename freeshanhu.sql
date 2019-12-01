/*
 Navicat MySQL Data Transfer

 Source Server         : laravdocker
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : mysql:3306
 Source Schema         : freeshanhu

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 01/12/2019 16:31:47
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_config
-- ----------------------------
DROP TABLE IF EXISTS `admin_config`;
CREATE TABLE `admin_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `unadconf` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_config
-- ----------------------------
BEGIN;
INSERT INTO `admin_config` VALUES (1, 'MANAGE_EMAIL', '这里填写你的邮箱接收邮件通知', '管理员接收邮箱', '2019-03-18 03:07:02', '2019-12-01 16:29:54');
INSERT INTO `admin_config` VALUES (2, 'PENDING_ORDERS_LIST', 'PENDING_ORDERS_LIST', '待支付订单缓存集合（勿删，勿改）', '2019-03-18 05:37:21', '2019-03-18 05:37:21');
INSERT INTO `admin_config` VALUES (3, 'INVENTORY_RELEASE_LIST', 'INVENTORY_RELEASE_LIST', '释放的库存队列（勿删，勿改）', '2019-03-18 05:48:45', '2019-03-18 05:48:51');
INSERT INTO `admin_config` VALUES (6, 'SYS_NAME', '珊瑚发卡系统 - 专业的个人卡密一站式销售系统', '网站名称', '2019-06-27 05:03:14', '2019-07-16 11:46:36');
INSERT INTO `admin_config` VALUES (7, 'SYS_DESCRIBE', '匠心之作，安全稳定。', '网站描述', '2019-06-27 06:54:13', '2019-07-16 11:46:27');
INSERT INTO `admin_config` VALUES (8, 'SYS_ICP', '沪ICP-100000', 'ICP备案信息', '2019-06-27 06:54:44', '2019-09-26 13:01:43');
INSERT INTO `admin_config` VALUES (9, 'SYS_INDEX_TIPS', '请使用正版程序保障您的资金安全', '首页提示信息', '2019-06-27 07:03:02', '2019-06-27 07:03:02');
INSERT INTO `admin_config` VALUES (10, 'SYS_TOP_TIPS', '本站数据均为测试数据，请进行小额测试。\r\n售价498元包更新！\r\n后台测试/购买联系QQ：53331323。\r\n<a target=\"_blank\" href=\"http://wpa.qq.com/msgrd?v=3&uin=53331323&site=qq&menu=yes\"><img border=\"0\" src=\"http://wpa.qq.com/pa?p=2:53331323:51\" alt=\"点击联系客服\" /></a>', '首页顶部公共', '2019-06-27 07:03:41', '2019-09-26 18:46:28');
INSERT INTO `admin_config` VALUES (21, 'ORDERS_SUCCESS_LIST', 'ORDERS_SUCCESS_LIST', '成功的订单缓存（勿删勿改）', '2019-07-08 21:39:14', '2019-07-08 21:39:14');
INSERT INTO `admin_config` VALUES (22, 'mail.driver', 'smtp', '邮件协议', '2019-07-09 15:07:06', '2019-07-09 15:09:41');
INSERT INTO `admin_config` VALUES (23, 'mail.host', 'smtp.mailgun.org', '邮件SMTP地址', '2019-07-09 15:07:28', '2019-07-13 19:37:53');
INSERT INTO `admin_config` VALUES (24, 'mail.port', '465', '邮件端口', '2019-07-09 15:07:50', '2019-07-13 19:19:25');
INSERT INTO `admin_config` VALUES (25, 'mail.username', 'server@mail.shanhufk.com', '邮件登录用户', '2019-07-09 15:08:11', '2019-07-13 19:39:44');
INSERT INTO `admin_config` VALUES (26, 'mail.password', '123321', '邮件认证密码', '2019-07-09 15:11:18', '2019-12-01 16:30:16');
INSERT INTO `admin_config` VALUES (27, 'mail.from.address', 'server@mail.shanhufk.com', '发送者地址', '2019-07-09 15:12:33', '2019-07-13 19:39:50');
INSERT INTO `admin_config` VALUES (28, 'mail.from.name', '珊瑚发卡', '邮件发送者名称', '2019-07-09 15:13:11', '2019-07-09 15:13:21');
INSERT INTO `admin_config` VALUES (30, 'mail.encryption', 'ssl', '发件连接协议', '2019-07-13 19:31:52', '2019-07-13 19:31:52');
COMMIT;

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
BEGIN;
INSERT INTO `admin_menu` VALUES (1, 0, 1, '首页', 'fa-bar-chart', '/', NULL, NULL, '2019-03-08 13:22:48');
INSERT INTO `admin_menu` VALUES (2, 0, 2, '后台管理', 'fa-tasks', NULL, NULL, NULL, '2019-03-08 13:23:00');
INSERT INTO `admin_menu` VALUES (3, 2, 3, '后台用户', 'fa-users', 'auth/users', NULL, NULL, '2019-03-08 13:23:19');
INSERT INTO `admin_menu` VALUES (4, 2, 4, '角色', 'fa-user', 'auth/roles', NULL, NULL, '2019-03-08 13:23:42');
INSERT INTO `admin_menu` VALUES (5, 2, 5, '权限', 'fa-ban', 'auth/permissions', NULL, NULL, '2019-03-08 13:23:53');
INSERT INTO `admin_menu` VALUES (6, 2, 6, '菜单', 'fa-bars', 'auth/menu', NULL, NULL, '2019-03-08 13:24:06');
INSERT INTO `admin_menu` VALUES (7, 2, 7, '操作日志', 'fa-history', 'auth/logs', NULL, NULL, '2019-03-08 13:24:18');
INSERT INTO `admin_menu` VALUES (14, 21, 25, '其他配置', 'fa-toggle-on', 'config', NULL, '2019-03-08 13:28:05', '2019-07-03 23:09:07');
INSERT INTO `admin_menu` VALUES (15, 0, 16, '商品管理', 'fa-shopping-cart', NULL, NULL, '2019-03-09 11:36:59', '2019-07-03 23:09:07');
INSERT INTO `admin_menu` VALUES (16, 15, 17, '商品分类管理', 'fa-shopping-basket', '/classify', NULL, '2019-03-09 11:37:54', '2019-07-03 23:09:07');
INSERT INTO `admin_menu` VALUES (17, 15, 18, '商品列表', 'fa-shopping-bag', '/commodity', NULL, '2019-03-09 13:13:54', '2019-07-03 23:09:07');
INSERT INTO `admin_menu` VALUES (18, 0, 19, '卡密管理', 'fa-credit-card-alt', NULL, NULL, '2019-03-09 15:41:02', '2019-07-03 23:09:07');
INSERT INTO `admin_menu` VALUES (19, 18, 20, '卡密列表', 'fa-credit-card', '/cardlist', NULL, '2019-03-09 15:41:19', '2019-07-03 23:09:07');
INSERT INTO `admin_menu` VALUES (20, 18, 21, '导入卡密', 'fa-circle-o-notch', 'importcard', NULL, '2019-03-09 16:27:55', '2019-07-03 23:09:07');
INSERT INTO `admin_menu` VALUES (21, 0, 22, '配置', 'fa-gears', NULL, NULL, '2019-03-11 00:27:18', '2019-07-03 23:09:07');
INSERT INTO `admin_menu` VALUES (22, 21, 23, '支付配置', 'fa-credit-card', '/payconfig', NULL, '2019-03-11 00:28:42', '2019-07-03 23:09:07');
INSERT INTO `admin_menu` VALUES (23, 0, 13, '订单', 'fa-list-ol', NULL, NULL, '2019-03-11 00:32:08', '2019-03-11 00:33:08');
INSERT INTO `admin_menu` VALUES (24, 23, 14, '订单列表', 'fa-list-ul', '/orders', NULL, '2019-03-11 00:32:56', '2019-03-11 00:33:08');
INSERT INTO `admin_menu` VALUES (25, 21, 24, '邮件模板', 'fa-envelope', '/emailtpl', NULL, '2019-03-11 13:18:21', '2019-07-03 23:09:07');
INSERT INTO `admin_menu` VALUES (26, 23, 15, '订单统计', 'fa-bar-chart', '/orderstatistics', NULL, '2019-03-11 14:56:00', '2019-07-03 23:09:06');
COMMIT;

-- ----------------------------
-- Table structure for admin_operation_log
-- ----------------------------
DROP TABLE IF EXISTS `admin_operation_log`;
CREATE TABLE `admin_operation_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `admin_operation_log_user_id_index` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `http_path` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `admin_permissions_name_unique` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_permissions
-- ----------------------------
BEGIN;
INSERT INTO `admin_permissions` VALUES (1, 'All permission', '*', '', '*', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (2, 'Dashboard', 'dashboard', 'GET', '/', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (3, 'Login', 'auth.login', '', '/auth/login\r\n/auth/logout', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (4, 'User setting', 'auth.setting', 'GET,PUT', '/auth/setting', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (5, 'Auth management', 'auth.management', '', '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (6, 'Admin helpers', 'ext.helpers', NULL, '/helpers/*', '2019-03-08 13:22:12', '2019-03-08 13:22:12');
INSERT INTO `admin_permissions` VALUES (7, 'Admin Config', 'ext.config', NULL, '/config*', '2019-03-08 13:28:05', '2019-03-08 13:28:05');
INSERT INTO `admin_permissions` VALUES (8, 'gust', 'gust', 'GET', '/orders*\r\n/orderstatistics*\r\n/classify*\r\n/commodity*\r\n/cardlist*\r\n/emailtpl*\r\n/payconfig/index\r\n/auth/logout\r\n/importcard\r\n/', '2019-07-09 16:15:20', '2019-07-24 12:51:44');
INSERT INTO `admin_permissions` VALUES (9, 'Media manager', 'ext.media-manager', NULL, '/media*', '2019-07-11 13:04:00', '2019-07-11 13:04:00');
COMMIT;

-- ----------------------------
-- Table structure for admin_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_menu`;
CREATE TABLE `admin_role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_menu
-- ----------------------------
BEGIN;
INSERT INTO `admin_role_menu` VALUES (1, 2, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for admin_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_permissions`;
CREATE TABLE `admin_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_permissions
-- ----------------------------
BEGIN;
INSERT INTO `admin_role_permissions` VALUES (1, 1, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for admin_role_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_users`;
CREATE TABLE `admin_role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_users_role_id_user_id_index` (`role_id`,`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_users
-- ----------------------------
BEGIN;
INSERT INTO `admin_role_users` VALUES (1, 1, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `admin_roles_name_unique` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
BEGIN;
INSERT INTO `admin_roles` VALUES (1, 'Administrator', 'administrator', '2019-03-08 13:15:53', '2019-03-08 13:15:53');
COMMIT;

-- ----------------------------
-- Table structure for admin_user_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_permissions`;
CREATE TABLE `admin_user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `admin_users_username_unique` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
BEGIN;
INSERT INTO `admin_users` VALUES (1, 'admin', '$2y$10$FVwbPHpFvMVIocsCD3YD8uA/LHaR41QOiTq8o3vTYrj8x74ObHyNy', '总管理', 'images/loading_logo.png', 'f9THVNVDTdjV6nF5k7v1DtLRnPxLU9bGptaIPGO8WsG6onO7bFPMY14SyAfP', '2019-03-08 13:15:53', '2019-12-01 16:25:48');
COMMIT;

-- ----------------------------
-- Table structure for cardlist
-- ----------------------------
DROP TABLE IF EXISTS `cardlist`;
CREATE TABLE `cardlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `card_pd` int(11) NOT NULL COMMENT '卡密所属商品',
  `card_info` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '卡密详情',
  `cd_status` int(11) NOT NULL DEFAULT '1' COMMENT '卡密状态 1未出售  2已售出',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for classify
-- ----------------------------
DROP TABLE IF EXISTS `classify`;
CREATE TABLE `classify` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分类名称',
  `ico` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图标',
  `ord` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `c_status` int(11) NOT NULL DEFAULT '1' COMMENT '状态 1启用 2禁用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for commodity
-- ----------------------------
DROP TABLE IF EXISTS `commodity`;
CREATE TABLE `commodity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pd_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品名称',
  `actual_price` decimal(8,2) NOT NULL COMMENT '实际价格',
  `in_stock` int(11) DEFAULT '0' COMMENT '库存',
  `sales_volume` int(11) DEFAULT '0' COMMENT '销量',
  `product_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '商品图片',
  `pd_ord` int(11) DEFAULT '0' COMMENT '商品排序',
  `pd_info` text COLLATE utf8mb4_unicode_ci COMMENT '商品描述',
  `pd_status` int(11) NOT NULL COMMENT '1上架  2下架',
  `pd_type` int(11) NOT NULL COMMENT '商品所属分类',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for emailtpl
-- ----------------------------
DROP TABLE IF EXISTS `emailtpl`;
CREATE TABLE `emailtpl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tpl_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮件标题',
  `tpl_content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮件内容',
  `tpl_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮件标识',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of emailtpl
-- ----------------------------
BEGIN;
INSERT INTO `emailtpl` VALUES (1, '您在{sitename}购买的商品已发货', '<p><b>尊敬的用户您好：</b><br></p><p><b><br></b></p><p>您在：【{sitename}】 购买的商品：{ord_name} 已发货。<br></p><p>订单号：{oid}<br></p><p>数量：{ord_num}<br></p><p>金额：{ord_countmoney}<br></p><p>时间：<span style=\"\"><span style=\"\">{created_at}</span></span><br></p><p>订单详情：</p><hr><p>{ord_info}</p><hr><p>感谢您的惠顾，祝您生活愉快！<br></p><p style=\"margin-left: 40px;\"><b>来自{sitename} -{siteurl}</b></p>', 'card_send_mail', '2019-03-11 13:26:27', '2019-07-08 01:03:07');
COMMIT;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2016_01_04_173148_create_admin_tables', 1);
INSERT INTO `migrations` VALUES (4, '2017_07_17_040159_create_config_table', 2);
INSERT INTO `migrations` VALUES (5, '2019_03_09_113436_create_classify_table', 3);
INSERT INTO `migrations` VALUES (6, '2019_03_09_123724_create_commodity_table', 4);
INSERT INTO `migrations` VALUES (7, '2019_03_09_153850_create_cardlist_table', 5);
INSERT INTO `migrations` VALUES (8, '2019_03_11_001609_create_orders_table', 6);
INSERT INTO `migrations` VALUES (9, '2019_03_11_002421_create_payconfig_table', 7);
INSERT INTO `migrations` VALUES (10, '2019_03_11_131550_create_emailtpl_table', 8);
INSERT INTO `migrations` VALUES (11, '2019_03_11_145458_create_order_statistics_table', 9);
COMMIT;

-- ----------------------------
-- Table structure for order_statistics
-- ----------------------------
DROP TABLE IF EXISTS `order_statistics`;
CREATE TABLE `order_statistics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `count_ord` int(11) DEFAULT NULL COMMENT '当日总订单数',
  `count_pd` int(11) DEFAULT NULL COMMENT '当日售出总商品数',
  `count_money` decimal(8,2) DEFAULT NULL COMMENT '当日总收入',
  `count_day` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '日期',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单id',
  `pd_id` int(11) NOT NULL COMMENT '商品id',
  `pd_money` decimal(8,2) DEFAULT NULL COMMENT '商品单价',
  `ord_countmoney` decimal(8,2) DEFAULT NULL COMMENT '订单总价',
  `ord_num` int(11) NOT NULL COMMENT '购买个数',
  `ord_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单名称',
  `search_pwd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '查询密码',
  `rcg_account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '充值账号 卡密为邮箱  代充为账号',
  `ord_info` text COLLATE utf8mb4_unicode_ci COMMENT '订单详情',
  `pay_ord` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '第三方支付平台id',
  `pay_type` int(11) NOT NULL COMMENT '支付方式',
  `ord_status` int(11) NOT NULL DEFAULT '1' COMMENT '1待处理 2已处理 3已完成  4处理失败',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `unq_oid` (`oid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`(191)) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for payconfig
-- ----------------------------
DROP TABLE IF EXISTS `payconfig`;
CREATE TABLE `payconfig` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pay_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '支付名称',
  `pay_check` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支付标识',
  `pay_method` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dump' COMMENT '支付方式 scan  dump',
  `merchant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '商户id',
  `merchant_key` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户key',
  `merchant_pem` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户秘钥',
  `pay_handleroute` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '支付处理路由',
  `pay_status` int(11) NOT NULL DEFAULT '1' COMMENT '是否启用 1是 2否',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of payconfig
-- ----------------------------
BEGIN;
INSERT INTO `payconfig` VALUES (1, '支付宝当面付', 'zfbf2f', 'scan', '商户id', '没有就填商户id', '商户密钥', '/pay/alipay', 1, '2019-03-11 13:04:52', '2019-12-01 16:29:29');
INSERT INTO `payconfig` VALUES (2, '支付宝pc', 'aliweb', 'dump', '商户id', '没有就填商户id', '商户密钥', '/pay/alipay', 1, '2019-07-08 21:25:27', '2019-12-01 16:29:14');
INSERT INTO `payconfig` VALUES (3, '码支付QQ', 'mqq', 'dump', '商户id', '没有就填商户id', '商户密钥', '/pay/mapay', 1, '2019-07-11 17:05:27', '2019-12-01 16:28:42');
INSERT INTO `payconfig` VALUES (4, '码支付支付宝', 'mzfb', 'dump', '商户id', '没有就填商户id', '商户密钥', '/pay/mapay', 1, '2019-07-11 17:06:02', '2019-12-01 16:28:03');
INSERT INTO `payconfig` VALUES (5, '码支付微信', 'mwx', 'dump', '商户id', '没有就填商户id', '商户密钥', '/pay/mapay', 1, '2019-07-11 17:06:23', '2019-12-01 16:28:15');
INSERT INTO `payconfig` VALUES (8, '微信扫码', 'wescan', 'scan', '商户id', '没有就填商户id', '商户密钥', '/pay/wepay', 1, '2019-07-12 15:50:20', '2019-12-01 16:28:30');
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `users_email_unique` (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
