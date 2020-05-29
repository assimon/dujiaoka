/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : 127.0.0.1:3306
 Source Schema         : dujiaoka

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 28/04/2020 18:31:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_config
-- ----------------------------
DROP TABLE IF EXISTS `admin_config`;
CREATE TABLE `admin_config`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_config_name_unique`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;



-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `permission` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES (1, 0, 1, '首页', 'fa-bar-chart', '/', NULL, NULL, '2020-04-03 16:08:50');
INSERT INTO `admin_menu` VALUES (2, 0, 2, '后台管理', 'fa-tasks', NULL, NULL, NULL, '2020-04-03 16:09:22');
INSERT INTO `admin_menu` VALUES (3, 2, 3, '管理员', 'fa-users', 'auth/users', NULL, NULL, '2020-04-03 16:09:31');
INSERT INTO `admin_menu` VALUES (4, 2, 4, '角色', 'fa-user', 'auth/roles', NULL, NULL, '2020-04-03 16:09:55');
INSERT INTO `admin_menu` VALUES (5, 2, 5, '权限', 'fa-ban', 'auth/permissions', NULL, NULL, '2020-04-03 16:10:03');
INSERT INTO `admin_menu` VALUES (6, 2, 6, '菜单', 'fa-bars', 'auth/menu', NULL, NULL, '2020-04-03 16:10:12');
INSERT INTO `admin_menu` VALUES (7, 2, 7, '操作日志', 'fa-history', 'auth/logs', NULL, NULL, '2020-04-03 16:10:20');
INSERT INTO `admin_menu` VALUES (8, 0, 8, '销售数据', 'fa-area-chart', NULL, NULL, '2020-04-03 16:12:23', '2020-04-03 16:12:30');
INSERT INTO `admin_menu` VALUES (9, 8, 9, '订单列表', 'fa-heart', '/orders', NULL, '2020-04-03 16:13:43', '2020-04-03 17:01:47');
INSERT INTO `admin_menu` VALUES (10, 0, 10, '商品管理', 'fa-shopping-cart', NULL, NULL, '2020-04-03 17:00:39', '2020-04-03 17:01:47');
INSERT INTO `admin_menu` VALUES (11, 10, 12, '商品列表', 'fa-shopping-basket', '/products', NULL, '2020-04-03 17:01:08', '2020-04-03 17:01:47');
INSERT INTO `admin_menu` VALUES (12, 10, 11, '商品分类', 'fa-align-justify', '/classifys', NULL, '2020-04-03 17:01:34', '2020-04-03 17:01:47');
INSERT INTO `admin_menu` VALUES (13, 0, 16, '优惠管理', 'fa-heart', NULL, NULL, '2020-04-03 18:56:40', '2020-04-03 23:59:32');
INSERT INTO `admin_menu` VALUES (14, 13, 17, '优惠码列表', 'fa-barcode', '/coupons', NULL, '2020-04-03 18:57:51', '2020-04-03 23:59:32');
INSERT INTO `admin_menu` VALUES (15, 13, 18, '生成优惠码', 'fa-plus-square', '/createcoupons', NULL, '2020-04-03 19:12:41', '2020-04-03 23:59:32');
INSERT INTO `admin_menu` VALUES (16, 0, 19, '配置', 'fa-gears', NULL, NULL, '2020-04-03 21:32:33', '2020-04-03 23:59:33');
INSERT INTO `admin_menu` VALUES (17, 16, 22, '支付网关', 'fa-bars', '/pays', NULL, '2020-04-03 21:32:48', '2020-04-03 23:59:33');
INSERT INTO `admin_menu` VALUES (18, 16, 21, '邮件模板配置', 'fa-envelope', '/emailtpls', NULL, '2020-04-03 22:18:12', '2020-04-03 23:59:33');
INSERT INTO `admin_menu` VALUES (19, 16, 20, '系统配置', 'fa-gear', '/setting', NULL, '2020-04-03 22:48:30', '2020-04-03 23:59:33');
INSERT INTO `admin_menu` VALUES (20, 16, 23, '核心配置', 'fa-toggle-on', 'config', NULL, '2020-04-03 23:29:39', '2020-04-04 01:07:43');
INSERT INTO `admin_menu` VALUES (21, 0, 13, '卡密管理', 'fa-credit-card-alt', NULL, NULL, '2020-04-03 23:44:19', '2020-04-03 23:45:22');
INSERT INTO `admin_menu` VALUES (22, 21, 14, '卡密列表', 'fa-credit-card', '/cards', NULL, '2020-04-03 23:45:40', '2020-04-03 23:46:14');
INSERT INTO `admin_menu` VALUES (23, 21, 15, '导入卡密', 'fa-arrow-circle-right', '/importcards', NULL, '2020-04-03 23:59:18', '2020-04-03 23:59:32');
INSERT INTO `admin_menu` VALUES (24, 0, 19, '文章管理', 'fa-pencil', '/pages', NULL, '2020-05-23 21:18:43', '2020-05-23 21:18:59');
-- ----------------------------
-- Table structure for admin_operation_log
-- ----------------------------
DROP TABLE IF EXISTS `admin_operation_log`;
CREATE TABLE `admin_operation_log`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `admin_operation_log_user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 749 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `http_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_permissions_name_unique`(`name`) USING BTREE,
  UNIQUE INDEX `admin_permissions_slug_unique`(`slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_permissions
-- ----------------------------
INSERT INTO `admin_permissions` VALUES (1, 'All permission', '*', '', '*', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (2, 'Dashboard', 'dashboard', 'GET', '/', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (3, 'Login', 'auth.login', '', '/auth/login\r\n/auth/logout', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (4, 'User setting', 'auth.setting', 'GET,PUT', '/auth/setting', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (5, 'Auth management', 'auth.management', '', '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (6, 'Admin Config', 'ext.config', '', '/config*', '2020-04-03 23:29:39', '2020-04-03 23:29:39');

-- ----------------------------
-- Table structure for admin_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_menu`;
CREATE TABLE `admin_role_menu`  (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  INDEX `admin_role_menu_role_id_menu_id_index`(`role_id`, `menu_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_role_menu
-- ----------------------------
INSERT INTO `admin_role_menu` VALUES (1, 2, NULL, NULL);

-- ----------------------------
-- Table structure for admin_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_permissions`;
CREATE TABLE `admin_role_permissions`  (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  INDEX `admin_role_permissions_role_id_permission_id_index`(`role_id`, `permission_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_role_permissions
-- ----------------------------
INSERT INTO `admin_role_permissions` VALUES (1, 1, NULL, NULL);

-- ----------------------------
-- Table structure for admin_role_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_users`;
CREATE TABLE `admin_role_users`  (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  INDEX `admin_role_users_role_id_user_id_index`(`role_id`, `user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_role_users
-- ----------------------------
INSERT INTO `admin_role_users` VALUES (1, 1, NULL, NULL);

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_roles_name_unique`(`name`) USING BTREE,
  UNIQUE INDEX `admin_roles_slug_unique`(`slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
INSERT INTO `admin_roles` VALUES (1, 'Administrator', 'administrator', '2020-04-03 15:33:22', '2020-04-03 15:33:22');

-- ----------------------------
-- Table structure for admin_user_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_permissions`;
CREATE TABLE `admin_user_permissions`  (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  INDEX `admin_user_permissions_user_id_permission_id_index`(`user_id`, `permission_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_users_username_unique`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES (1, 'admin', '$2y$10$EVen1Tc6I925ejmZq58P7eg/K8wzCi0kMyM.WaGF0a5FyrQqnx8Z6', 'Administrator', NULL, 'd78UGJM4AZQ03LIaqhpLQzZR2ZlG6taW5gi5p6ifUJBSOpztky29aOjPGcyQ', '2020-04-03 15:33:22', '2020-04-03 15:33:22');

-- ----------------------------
-- Table structure for cards
-- ----------------------------
DROP TABLE IF EXISTS `cards`;
CREATE TABLE `cards`  (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `product_id` int(200) NOT NULL,
  `card_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `card_status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 533 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for classifys
-- ----------------------------
DROP TABLE IF EXISTS `classifys`;
CREATE TABLE `classifys`  (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ord` int(50) NOT NULL DEFAULT 1,
  `passwd` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `c_status` int(1) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for coupons
-- ----------------------------
DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(20) NOT NULL COMMENT '所属商品',
  `c_type` int(1) NOT NULL DEFAULT 1 COMMENT '1为一次性使用 2为重复使用',
  `discount` decimal(10, 2) NOT NULL COMMENT '优惠金额',
  `is_status` int(11) NOT NULL DEFAULT 1 COMMENT '是否已经使用1正常  2已使用',
  `card` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '优惠券内容',
  `ret` int(11) NOT NULL COMMENT '剩余可用次数',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uqcard`(`card`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for emailtpls
-- ----------------------------
DROP TABLE IF EXISTS `emailtpls`;
CREATE TABLE `emailtpls`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tpl_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮件标题',
  `tpl_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮件内容',
  `tpl_token` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮件标识',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `mail_token`(`tpl_token`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of emailtpls
-- ----------------------------
INSERT INTO `emailtpls` VALUES (2, '【{webname}】感谢您的购买，请查收您的收据', '<!DOCTYPE html>\n<html\n    style=\"font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\n<head>\n    <meta name=\"viewport\" content=\"width=device-width\"/>\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>\n    <title>Billing e.g. invoices and receipts</title>\n\n    <style type=\"text/css\">\n        img {\n            max-width: 100%;\n        }\n\n        body {\n            -webkit-font-smoothing: antialiased;\n            -webkit-text-size-adjust: none;\n            width: 100% !important;\n            height: 100%;\n            line-height: 1.6em;\n        }\n\n        body {\n            background-color: #f6f6f6;\n        }\n\n        @media only screen and (max-width: 640px) {\n            body {\n                padding: 0 !important;\n            }\n\n            h1 {\n                font-weight: 800 !important;\n                margin: 20px 0 5px !important;\n            }\n\n            h2 {\n                font-weight: 800 !important;\n                margin: 20px 0 5px !important;\n            }\n\n            h3 {\n                font-weight: 800 !important;\n                margin: 20px 0 5px !important;\n            }\n\n            h4 {\n                font-weight: 800 !important;\n                margin: 20px 0 5px !important;\n            }\n\n            h1 {\n                font-size: 22px !important;\n            }\n\n            h2 {\n                font-size: 18px !important;\n            }\n\n            h3 {\n                font-size: 16px !important;\n            }\n\n            .container {\n                padding: 0 !important;\n                width: 100% !important;\n            }\n\n            .content {\n                padding: 0 !important;\n            }\n\n            .content-wrap {\n                padding: 10px !important;\n            }\n\n            .invoice {\n                width: 100% !important;\n            }\n        }\n    </style>\n</head>\n\n<body itemscope itemtype=\"http://schema.org/EmailMessage\"\n      style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;\"\n      bgcolor=\"#f6f6f6\">\n\n<table class=\"body-wrap\"\n       style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;\"\n       bgcolor=\"#f6f6f6\">\n    <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\n        <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;\"\n            valign=\"top\"></td>\n        <td class=\"container\" width=\"600\"\n            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;\"\n            valign=\"top\">\n            <div class=\"content\"\n                 style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;\">\n                <table class=\"main\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"\n                       style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;\"\n                       bgcolor=\"#fff\">\n                    <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\n                        <td class=\"content-wrap aligncenter\"\n                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 20px;\"\n                            align=\"center\" valign=\"top\">\n                            <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"\n                                   style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\n                                    <td class=\"content-block\"\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;\"\n                                        valign=\"top\">\n                                        <h1 class=\"aligncenter\"\n                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 32px; color: #000; line-height: 1.2em; font-weight: 500; text-align: center; margin: 40px 0 0;\"\n                                            align=\"center\"> {ord_title} </h1>\n                                    </td>\n                                </tr>\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\n                                    <td class=\"content-block\"\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;\"\n                                        valign=\"top\">\n                                        <h2 class=\"aligncenter\"\n                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 24px; color: #000; line-height: 1.2em; font-weight: 400; text-align: center; margin: 40px 0 0;\"\n                                            align=\"center\">感谢您的订单.</h2>\n                                    </td>\n                                </tr>\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\n                                    <td class=\"content-block aligncenter\"\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\n                                        align=\"center\" valign=\"top\">\n                                        <table class=\"invoice\"\n                                               style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; text-align: left; width: 80%; margin: 40px auto;\">\n                                            <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\n                                                <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;\" valign=\"top\">\n                                                    订单号: {order_id}<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\"/>\n                                                    {created_at}<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\"/>\n                                                    以下是您的卡密信息：<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\"/>\n                                                    {ord_info}\n                                                </td>\n                                            </tr>\n                                            <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\n                                                <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;\"\n                                                    valign=\"top\">\n                                                    <table class=\"invoice-items\" cellpadding=\"0\" cellspacing=\"0\"\n                                                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; margin: 0;\">\n                                                        <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\n                                                            <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;\"\n                                                                valign=\"top\">{product_name}\n                                                            </td>\n                                                            <td class=\"alignright\"\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;\"\n                                                                align=\"right\" valign=\"top\">x {buy_amount}\n                                                            </td>\n                                                        </tr>\n\n                                                        <tr class=\"total\"\n                                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\n                                                            <td class=\"alignright\" width=\"80%\"\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;\"\n                                                                align=\"right\" valign=\"top\">总价\n                                                            </td>\n                                                            <td class=\"alignright\"\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;\"\n                                                                align=\"right\" valign=\"top\">{ord_price} ￥\n                                                            </td>\n                                                        </tr>\n                                                    </table>\n                                                </td>\n                                            </tr>\n                                        </table>\n                                    </td>\n                                </tr>\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\n                                    <td class=\"content-block aligncenter\"\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\n                                        align=\"center\" valign=\"top\">\n                                        <a href=\"{weburl}\"\n                                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #348eda; text-decoration: underline; margin: 0;\">{webname}</a>\n                                    </td>\n                                </tr>\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\n                                    <td class=\"content-block aligncenter\"\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\n                                        align=\"center\" valign=\"top\">\n                                        {webname} Inc. {created_at}\n                                    </td>\n                                </tr>\n                            </table>\n                        </td>\n                    </tr>\n                </table>\n                <div class=\"footer\"\n                     style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;\">\n                    <table width=\"100%\"\n                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\n                        <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\n\n                        </tr>\n                    </table>\n                </div>\n            </div>\n        </td>\n        <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;\"\n            valign=\"top\"></td>\n    </tr>\n</table>\n</body>\n</html>', 'card_send_user_email', '2020-04-06 21:27:56', '2020-04-06 21:29:16');
INSERT INTO `emailtpls` VALUES (3, '【{webname}】新订单等待处理!', '<p><span style=\"\">尊敬的管理员：</span></p><p><span style=\"\">客户购买的商品：<span style=\"\"><span style=\"\">【{product_name}】</span></span> 已支付成功，请及时处理。</span></p><p>订单号：{order_id}<br></p><p>数量：{buy_amount}<br></p><p>金额：{ord_price}<br></p><p>时间：<span style=\"\">{created_at}</span><br></p><hr><p>{ord_info}</p><hr><p style=\"margin-left: 40px;\"><b>来自{webname} -{weburl}</b></p>', 'manual_send_manage_mail', '2020-04-06 21:32:03', '2020-04-06 21:32:18');
INSERT INTO `emailtpls` VALUES (4, '【{webname}】已收到您的订单，我们会尽快处理', '<!DOCTYPE html>\r\n<html\r\n    style=\"font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<head>\r\n    <meta name=\"viewport\" content=\"width=device-width\"/>\r\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>\r\n    <title>Billing e.g. invoices and receipts</title>\r\n\r\n    <style type=\"text/css\">\r\n        img {\r\n            max-width: 100%;\r\n        }\r\n\r\n        body {\r\n            -webkit-font-smoothing: antialiased;\r\n            -webkit-text-size-adjust: none;\r\n            width: 100% !important;\r\n            height: 100%;\r\n            line-height: 1.6em;\r\n        }\r\n\r\n        body {\r\n            background-color: #f6f6f6;\r\n        }\r\n\r\n        @media only screen and (max-width: 640px) {\r\n            body {\r\n                padding: 0 !important;\r\n            }\r\n\r\n            h1 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h2 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h3 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h4 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h1 {\r\n                font-size: 22px !important;\r\n            }\r\n\r\n            h2 {\r\n                font-size: 18px !important;\r\n            }\r\n\r\n            h3 {\r\n                font-size: 16px !important;\r\n            }\r\n\r\n            .container {\r\n                padding: 0 !important;\r\n                width: 100% !important;\r\n            }\r\n\r\n            .content {\r\n                padding: 0 !important;\r\n            }\r\n\r\n            .content-wrap {\r\n                padding: 10px !important;\r\n            }\r\n\r\n            .invoice {\r\n                width: 100% !important;\r\n            }\r\n        }\r\n    </style>\r\n</head>\r\n\r\n<body itemscope itemtype=\"http://schema.org/EmailMessage\"\r\n      style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;\"\r\n      bgcolor=\"#f6f6f6\">\r\n\r\n<table class=\"body-wrap\"\r\n       style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;\"\r\n       bgcolor=\"#f6f6f6\">\r\n    <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n        <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;\"\r\n            valign=\"top\"></td>\r\n        <td class=\"container\" width=\"600\"\r\n            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;\"\r\n            valign=\"top\">\r\n            <div class=\"content\"\r\n                 style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;\">\r\n                <table class=\"main\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"\r\n                       style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;\"\r\n                       bgcolor=\"#fff\">\r\n                    <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                        <td class=\"content-wrap aligncenter\"\r\n                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 20px;\"\r\n                            align=\"center\" valign=\"top\">\r\n                            <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"\r\n                                   style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;\"\r\n                                        valign=\"top\">\r\n                                        <h1 class=\"aligncenter\"\r\n                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 32px; color: #000; line-height: 1.2em; font-weight: 500; text-align: center; margin: 40px 0 0;\"\r\n                                            align=\"center\"> {ord_title} </h1>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;\"\r\n                                        valign=\"top\">\r\n                                        <h2 class=\"aligncenter\"\r\n                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 24px; color: #000; line-height: 1.2em; font-weight: 400; text-align: center; margin: 40px 0 0;\"\r\n                                            align=\"center\">我们正快马加鞭地处理此订单.</h2>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block aligncenter\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\r\n                                        align=\"center\" valign=\"top\">\r\n                                        <table class=\"invoice\"\r\n                                               style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; text-align: left; width: 80%; margin: 40px auto;\">\r\n                                            <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;\" valign=\"top\">\r\n                                                    订单号: {order_id}<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\"/>\r\n                                                    {created_at}<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\"/>\r\n                                                    以下是您的充值信息：<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\"/>\r\n                                                    {ord_info}\r\n                                                </td>\r\n                                            </tr>\r\n                                            <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;\"\r\n                                                    valign=\"top\">\r\n                                                    <table class=\"invoice-items\" cellpadding=\"0\" cellspacing=\"0\"\r\n                                                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; margin: 0;\">\r\n                                                        <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                            <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;\"\r\n                                                                valign=\"top\">{product_name}\r\n                                                            </td>\r\n                                                            <td class=\"alignright\"\r\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;\"\r\n                                                                align=\"right\" valign=\"top\">x {buy_amount}\r\n                                                            </td>\r\n                                                        </tr>\r\n\r\n                                                        <tr class=\"total\"\r\n                                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                            <td class=\"alignright\" width=\"80%\"\r\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;\"\r\n                                                                align=\"right\" valign=\"top\">总价\r\n                                                            </td>\r\n                                                            <td class=\"alignright\"\r\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;\"\r\n                                                                align=\"right\" valign=\"top\">{ord_price} ￥\r\n                                                            </td>\r\n                                                        </tr>\r\n                                                    </table>\r\n                                                </td>\r\n                                            </tr>\r\n                                        </table>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block aligncenter\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\r\n                                        align=\"center\" valign=\"top\">\r\n                                        <a href=\"{weburl}\"\r\n                                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #348eda; text-decoration: underline; margin: 0;\">{webname}</a>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block aligncenter\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\r\n                                        align=\"center\" valign=\"top\">\r\n                                        {webname} Inc. {created_at}\r\n                                    </td>\r\n                                </tr>\r\n                            </table>\r\n                        </td>\r\n                    </tr>\r\n                </table>\r\n                <div class=\"footer\"\r\n                     style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;\">\r\n                    <table width=\"100%\"\r\n                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                        <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n\r\n                        </tr>\r\n                    </table>\r\n                </div>\r\n            </div>\r\n        </td>\r\n        <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;\"\r\n            valign=\"top\"></td>\r\n    </tr>\r\n</table>\r\n</body>\r\n</html>', 'wait_send_user_email', '2020-04-24 21:03:55', '2020-04-24 21:16:44');
INSERT INTO `emailtpls` VALUES (5, '【{webname}】订单已完成', '<!DOCTYPE html>\r\n<html\r\n    style=\"font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<head>\r\n    <meta name=\"viewport\" content=\"width=device-width\"/>\r\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>\r\n    <title>Billing e.g. invoices and receipts</title>\r\n\r\n    <style type=\"text/css\">\r\n        img {\r\n            max-width: 100%;\r\n        }\r\n\r\n        body {\r\n            -webkit-font-smoothing: antialiased;\r\n            -webkit-text-size-adjust: none;\r\n            width: 100% !important;\r\n            height: 100%;\r\n            line-height: 1.6em;\r\n        }\r\n\r\n        body {\r\n            background-color: #f6f6f6;\r\n        }\r\n\r\n        @media only screen and (max-width: 640px) {\r\n            body {\r\n                padding: 0 !important;\r\n            }\r\n\r\n            h1 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h2 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h3 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h4 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h1 {\r\n                font-size: 22px !important;\r\n            }\r\n\r\n            h2 {\r\n                font-size: 18px !important;\r\n            }\r\n\r\n            h3 {\r\n                font-size: 16px !important;\r\n            }\r\n\r\n            .container {\r\n                padding: 0 !important;\r\n                width: 100% !important;\r\n            }\r\n\r\n            .content {\r\n                padding: 0 !important;\r\n            }\r\n\r\n            .content-wrap {\r\n                padding: 10px !important;\r\n            }\r\n\r\n            .invoice {\r\n                width: 100% !important;\r\n            }\r\n        }\r\n    </style>\r\n</head>\r\n\r\n<body itemscope itemtype=\"http://schema.org/EmailMessage\"\r\n      style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;\"\r\n      bgcolor=\"#f6f6f6\">\r\n\r\n<table class=\"body-wrap\"\r\n       style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;\"\r\n       bgcolor=\"#f6f6f6\">\r\n    <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n        <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;\"\r\n            valign=\"top\"></td>\r\n        <td class=\"container\" width=\"600\"\r\n            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;\"\r\n            valign=\"top\">\r\n            <div class=\"content\"\r\n                 style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;\">\r\n                <table class=\"main\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"\r\n                       style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;\"\r\n                       bgcolor=\"#fff\">\r\n                    <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                        <td class=\"content-wrap aligncenter\"\r\n                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 20px;\"\r\n                            align=\"center\" valign=\"top\">\r\n                            <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"\r\n                                   style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;\"\r\n                                        valign=\"top\">\r\n                                        <h1 class=\"aligncenter\"\r\n                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 32px; color: #000; line-height: 1.2em; font-weight: 500; text-align: center; margin: 40px 0 0;\"\r\n                                            align=\"center\"> {ord_title} </h1>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;\"\r\n                                        valign=\"top\">\r\n                                        <h2 class=\"aligncenter\"\r\n                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 24px; color: #000; line-height: 1.2em; font-weight: 400; text-align: center; margin: 40px 0 0;\"\r\n                                            align=\"center\">订单处理完毕.</h2>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block aligncenter\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\r\n                                        align=\"center\" valign=\"top\">\r\n                                        <table class=\"invoice\"\r\n                                               style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; text-align: left; width: 80%; margin: 40px auto;\">\r\n                                            <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;\" valign=\"top\">\r\n                                                    订单号: {order_id}<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\"/>\r\n                                                    {created_at}<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\"/>\r\n                                                    以下是您的充值信息：<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\"/>\r\n                                                    {ord_info}\r\n                                                </td>\r\n                                            </tr>\r\n                                            <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;\"\r\n                                                    valign=\"top\">\r\n                                                    <table class=\"invoice-items\" cellpadding=\"0\" cellspacing=\"0\"\r\n                                                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; margin: 0;\">\r\n                                                        <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                            <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;\"\r\n                                                                valign=\"top\">{product_name}\r\n                                                            </td>\r\n                                                            <td class=\"alignright\"\r\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;\"\r\n                                                                align=\"right\" valign=\"top\">x {buy_amount}\r\n                                                            </td>\r\n                                                        </tr>\r\n\r\n                                                        <tr class=\"total\"\r\n                                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                            <td class=\"alignright\" width=\"80%\"\r\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;\"\r\n                                                                align=\"right\" valign=\"top\">总价\r\n                                                            </td>\r\n                                                            <td class=\"alignright\"\r\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;\"\r\n                                                                align=\"right\" valign=\"top\">{ord_price} ￥\r\n                                                            </td>\r\n                                                        </tr>\r\n                                                    </table>\r\n                                                </td>\r\n                                            </tr>\r\n                                        </table>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block aligncenter\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\r\n                                        align=\"center\" valign=\"top\">\r\n                                        <a href=\"{weburl}\"\r\n                                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #348eda; text-decoration: underline; margin: 0;\">{webname}</a>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block aligncenter\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\r\n                                        align=\"center\" valign=\"top\">\r\n                                        {webname} Inc. {created_at}\r\n                                    </td>\r\n                                </tr>\r\n                            </table>\r\n                        </td>\r\n                    </tr>\r\n                </table>\r\n                <div class=\"footer\"\r\n                     style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;\">\r\n                    <table width=\"100%\"\r\n                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                        <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n\r\n                        </tr>\r\n                    </table>\r\n                </div>\r\n            </div>\r\n        </td>\r\n        <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;\"\r\n            valign=\"top\"></td>\r\n    </tr>\r\n</table>\r\n</body>\r\n</html>', 'finish_send_user_email', '2020-04-24 21:08:49', '2020-04-24 21:08:49');
INSERT INTO `emailtpls` VALUES (6, '【{webname}】商品库存预警!', '<p><span style=\"\">尊敬的管理员：</span></p><p><span style=\"\">商品：<span style=\"\"><span style=\"\">【{product_name}】</span></span> 库存已不足</span><span style=\"\"><span style=\"\">【{stock_alert}】</span></span> ，剩余库存<span style=\"\"><span style=\"\">【{in_stock}】</span></span>，请及时添加上货。<p style=\"margin-left: 40px;\"><b>来自{webname} -{weburl}</b></p>', 'manual_send_stock_alert_mail', '2020-05-27 02:10:43', '2020-05-27 02:52:33');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2016_01_04_173148_create_admin_tables', 1);
INSERT INTO `migrations` VALUES (4, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (5, '2017_07_17_040159_create_config_table', 2);

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '订单号',
  `product_id` int(100) NOT NULL COMMENT '关联所属商品',
  `coupon_id` int(100) NULL DEFAULT 0 COMMENT '优惠券id',
  `ord_class` int(1) NOT NULL DEFAULT 1 COMMENT '1自动发卡 2代充',
  `product_price` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '商品单价',
  `ord_price` decimal(10, 2) NULL DEFAULT 0.00,
  `buy_amount` int(10) NULL DEFAULT NULL COMMENT '购买数量',
  `ord_title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '订单名称',
  `search_pwd` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '查询密码',
  `account` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '充值账号',
  `ord_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '订单详情',
  `pay_ord` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '第三发支付id',
  `pay_way` int(20) NULL DEFAULT NULL COMMENT '第三方支付方式',
  `buy_ip` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '购买者ip地址',
  `ord_status` int(1) NULL DEFAULT 1 COMMENT '1待处理 2已处理 3已完成  4处理失败',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `orderid`(`order_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 73 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for pages
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '标题',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '内容',
  `status` int(1) NOT NULL COMMENT '状态1自动发卡 2代充	',
  `tag` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '标识',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES (1, '关于', '<p>关于</p>', 1, 'about', '2020-05-23 21:21:28', '2020-05-23 21:21:28');

-- ----------------------------
-- Table structure for pays
-- ----------------------------
DROP TABLE IF EXISTS `pays`;
CREATE TABLE `pays`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pay_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '支付名称',
  `pay_check` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '支付标识',
  `pay_method` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dump' COMMENT '支付方式 scan  dump',
  `merchant_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '商户id',
  `merchant_key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '商户key',
  `merchant_pem` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户秘钥',
  `pay_handleroute` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '支付处理路由',
  `pay_status` int(11) NOT NULL DEFAULT 1 COMMENT '是否启用 1是 2否',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_payck`(`pay_check`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pays
-- ----------------------------
INSERT INTO `pays` VALUES (1, '支付宝当面付', 'zfbf2f', 'scan', '商户号', '', '密钥', '/pay/alipay', 2, '2019-03-11 05:04:52', '2020-04-15 10:02:02');
INSERT INTO `pays` VALUES (2, '支付宝网页', 'aliweb', 'dump', '商户号', '', '密钥', '/pay/alipay', 2, '2019-07-08 13:25:27', '2020-04-23 11:23:00');
INSERT INTO `pays` VALUES (3, '码支付QQ[未开放]', 'mqq', 'dump', '商户号', '', '密钥', '/pay/mapay', 2, '2019-07-11 09:05:27', '2020-04-15 10:02:13');
INSERT INTO `pays` VALUES (4, '码支付支付宝[未开放]', 'mzfb', 'dump', '商户号', '', '密钥', '/pay/mapay', 2, '2019-07-11 09:06:02', '2020-04-15 10:02:17');
INSERT INTO `pays` VALUES (5, '码支付微信[未开放]', 'mwx', 'dump', '商户号', '', '密钥', '/pay/mapay', 2, '2019-07-11 09:06:23', '2020-04-15 10:02:19');
INSERT INTO `pays` VALUES (6, 'Paysapi支付宝', 'pszfb', 'dump', '商户号', '', '密钥', '/pay/paysapi', 2, '2019-07-11 09:31:12', '2020-04-15 10:02:22');
INSERT INTO `pays` VALUES (7, 'Paysapi微信', 'pswx', 'dump', '商户号', '', '密钥', '/pay/paysapi', 2, '2019-07-11 09:31:43', '2020-04-15 10:02:24');
INSERT INTO `pays` VALUES (8, '微信扫码', 'wescan', 'scan', '商户号', '', '密钥', '/pay/wepay', 2, '2019-07-12 07:50:20', '2020-04-23 01:00:17');
INSERT INTO `pays` VALUES (11, 'Payjs微信扫码', 'payjswescan', 'dump', '商户号', '', '密钥', '/pay/payjs', 2, '2019-07-25 07:28:42', '2020-04-16 13:36:31');
INSERT INTO `pays` VALUES (14, '易支付-支付宝', 'alipay', 'dump', '商户号', NULL, '密钥', '/pay/yipay', 1, '2020-01-10 15:22:56', '2020-04-23 11:23:12');
INSERT INTO `pays` VALUES (15, '易支付-支付宝', 'wxpay', 'dump', '商户号', NULL, '密钥', '/pay/yipay', 1, '2020-04-28 18:27:23', '2020-04-23 13:33:55');
INSERT INTO `pays` VALUES (16, '易支付-支付宝', 'qqpay', 'dump', '商户号', NULL, '密钥', '/pay/yipay', 1, '2020-04-28 18:27:27', '2020-04-24 19:09:58');
INSERT INTO `pays` VALUES (17, 'Paypal', 'paypal', 'dump', '商户号', '', '密钥', '/pay/paypal', 2, '2020-04-28 18:27:30', '2020-04-15 10:02:48');
INSERT INTO `pays` VALUES (27, '麻瓜宝数字货币', 'mgcoin', 'dump', '商户号', NULL, '密钥', '/pay/mugglepay', 2, '2020-04-19 09:50:14', '2020-04-19 10:28:55');
INSERT INTO `pays` VALUES (28, 'V免签支付宝', 'vzfb', 'dump', 'v免签通讯密钥', NULL, 'V免签地址 例如 https://vpay.qq.com/    结尾必须有/', 'pay/vpay', 1, '2020-05-01 13:15:56', '2020-05-01 13:18:29');
INSERT INTO `pays` VALUES (29, 'V免签微信', 'vwx', 'dump', 'V免签通讯密钥', NULL, 'V免签地址 例如 https://vpay.qq.com/    结尾必须有/', 'pay/vpay', 1, '2020-05-01 13:17:28', '2020-05-01 13:18:38');
-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `pd_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '商品名称',
  `cost_price` decimal(10, 2) NOT NULL,
  `actual_price` decimal(10, 2) NOT NULL COMMENT '实际售价',
  `wholesale_price` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `in_stock` int(50) NULL DEFAULT 0,
  `stock_alert` int(11) NOT NULL DEFAULT 0 COMMENT '库存预警',
  `sales_volume` int(50) NULL DEFAULT 0,
  `pd_picture` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '商品图片',
  `ord` int(100) NULL DEFAULT 0 COMMENT '排序',
  `buy_prompt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '购买提示',
  `pd_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商品详情',
  `passwd` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `pd_type` int(1) NOT NULL DEFAULT 1 COMMENT '1自动发卡 2代充',
  `other_ipu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `pd_status` int(1) NOT NULL DEFAULT 1,
  `pd_class` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for webset
-- ----------------------------
DROP TABLE IF EXISTS `webset`;
CREATE TABLE `webset`  (
  `id` int(1) NOT NULL,
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `text_logo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `keywords` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `notice` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `layerad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `footer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `instock` int(1) NULL DEFAULT 1,
  `manage_email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of webset
-- ----------------------------
INSERT INTO `webset` VALUES (1, '独角数卡 - 一站式自动售货方案', '独角数卡', '独角数卡', '独角数卡', '', '我是首页弹窗', NULL, 1, 'admin@admin.com', NULL, '2020-04-28 17:18:51');

SET FOREIGN_KEY_CHECKS = 1;
