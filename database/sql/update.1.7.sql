-- ----------------------------
-- 查询密码开关和优惠码开关
-- ----------------------------
ALTER TABLE `webset` ADD `isopen_coupon` INT(1) NOT NULL DEFAULT '1' AFTER `verify_code`, ADD `isopen_searchpwd` INT(1) NOT NULL DEFAULT '1' AFTER `isopen_coupon`;
