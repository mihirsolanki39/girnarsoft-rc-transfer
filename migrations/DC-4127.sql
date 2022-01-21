
ALTER TABLE `crm_finance_delivery` ADD `margin_money_inhouse` VARCHAR(50) NOT NULL AFTER `margin_money`;

ALTER TABLE `crm_finance_delivery` ADD `include_margin_money_cus` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '1=>checked,0=>non_checked' AFTER `sameas`;

ALTER TABLE `crm_finance_delivery` ADD `include_margin_money_in` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `include_margin_money_cus`;

ALTER TABLE `crm_finance_delivery` ADD `include_dis_shared` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `include_margin_money_in`;