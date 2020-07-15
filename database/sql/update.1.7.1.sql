-- ----------------------------
-- 删除系统配置字段.
-- ----------------------------
ALTER TABLE `webset` DROP `isopen_coupon`;
-- ----------------------------
-- 增加商品表字段.
-- ----------------------------
ALTER TABLE `products` ADD `isopen_coupon` INT(1) NOT NULL DEFAULT '1' AFTER `pd_class`;
