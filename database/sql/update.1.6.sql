-- ----------------------------
-- 更新系统设置表sql
-- ----------------------------
ALTER TABLE `webset` ADD `langs` VARCHAR(50) NULL AFTER `manage_email`, ADD `verify_code` INT(1) NULL DEFAULT '1' AFTER `langs`;

