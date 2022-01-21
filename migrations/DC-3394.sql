UPDATE `crm_insurance_renew_follow_status` SET `statusId` = '4' WHERE `crm_insurance_renew_follow_status`.`id` = 5;

ALTER TABLE `crm_insurance_case_details` CHANGE `follow_status` `follow_status` TINYINT(4) NOT NULL COMMENT '1=New,2=Follow up,3=Quote Shared,4=Payment Pending,5=Closed';
ALTER TABLE `crm_insurance_additional_cover` ADD `txtflag` ENUM('0','1') NOT NULL AFTER `labelName`;
ALTER TABLE `crm_insurance_additional_cover` ADD `priority` TINYINT(4) NOT NULL AFTER `txtflag`;
ALTER TABLE `crm_insurance_quotes_addon` ADD `add_on` VARCHAR(20) NOT NULL AFTER `non_electrical_accessories_txt`;
INSERT INTO `crm`.`crm_insurance_additional_cover` (`id`, `coverName`, `labelName`, `txtflag`, `priority`) VALUES ('', 'zero_dp', 'Zero Dp', '0', '0');
ALTER TABLE `crm_insurance_case_details` CHANGE `renew_flag` `renew_flag` ENUM('0','1','2') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0';
ALTER TABLE `crm_insurance_quotes_addon` ADD `zero_dep` ENUM('0','1') NOT NULL AFTER `non_electrical_accessories_txt`;
UPDATE `crm`.`crm_insurance_additional_cover` SET `coverName` = 'zero_dep', `labelName` = 'Zero Dep' WHERE `crm_insurance_additional_cover`.`id` = 13;
ALTER TABLE `crm_insurance_quotes_filter` DROP `road_side_assistance`, DROP `road_side_assistance_txt`, DROP `invoice_cover`, DROP `invoice_cover_txt`, DROP `consumables`, DROP `consumables_txt`, DROP `key_replacement`, DROP `key_replacement_txt`, DROP `ncb_protection_cover`, DROP `ncb_protection_cover_txt`, DROP `engine_cover_box`, DROP `engine_cover_box_txt`, DROP `tyre_secure`, DROP `tyre_secure_txt`, DROP `driver_cover`, DROP `driver_cover_txt`, DROP `personal_acc_cover`, DROP `personal_acc_cover_txt`, DROP `passenger_cover`, DROP `passenger_cover_txt`, DROP `electrical_accessories`, DROP `electrical_accessories_txt`, DROP `non_electrical_accessories`, DROP `non_electrical_accessories_txt`;

ALTER TABLE `crm_insurance_customer_details` ADD `in_payment_date` DATE NULL DEFAULT NULL AFTER `reasonId`;
ALTER TABLE `crm_insurance_customer_details` ADD `in_favouring_to` VARCHAR(100) NOT NULL AFTER `in_payment_date`;
ALTER TABLE `crm_insurance_customer_details` ADD `in_amount` VARCHAR(50) NOT NULL AFTER `in_favouring_to`;
ALTER TABLE `crm_insurance_customer_details` ADD `in_payment_mode` TINYINT(4) NOT NULL AFTER `in_amount`;
ALTER TABLE `crm_insurance_customer_details` ADD `in_cheque_no` VARCHAR(50) NOT NULL AFTER `in_payment_mode`;
ALTER TABLE `crm_insurance_customer_details` ADD `in_bank_name` INT(5) NOT NULL AFTER `in_cheque_no`;
ALTER TABLE `crm_insurance_customer_details` ADD `in_drawn_on` DATE NULL DEFAULT NULL AFTER `in_bank_name`;
ALTER TABLE `crm_insurance_customer_details` ADD `receipt_no` VARCHAR(50) NOT NULL AFTER `in_drawn_on`;
ALTER TABLE `crm_insurance_case_details` CHANGE `renew_flag` `renew_flag` ENUM( '0', '1', '2' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0';
ALTER TABLE `crm_insurance_quotes` ADD `sms` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `is_latest` ;

Table:-
crm_ins_renew_history_track
crm_insurance_renew_close_reason
crm_insurance_renew_follow_status
crm_central_stock
crm_insurance_quotes
crm_insurance_quotes_addon
crm_insurance_additional_cover
crm_insurance_zone
crm_insurance_prem_calc
crm_insurance_quotes_filter
orp_actual_price
