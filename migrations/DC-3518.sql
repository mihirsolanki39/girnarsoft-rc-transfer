ALTER TABLE `crm_insurance_case_details` ADD `reg_date` DATE NOT NULL AFTER `reg_year`;
UPDATE `crm`.`crm_prev_policy_insurer` SET `status` = '0' WHERE `crm_prev_policy_insurer`.`id` = 24;
INSERT INTO `crm`.`crm_prev_policy_insurer` (`id`, `prev_policy_insurer_slug`, `prev_policy_insurer_name`, `short_name`, `logo`, `date_added`, `date_updated`, `status`) VALUES (NULL, '25', 'ACKO', 'Acko', 'logo_25.png', '2017-08-29 12:02:24', '2018-02-18 06:00:02', '1');
INSERT INTO `crm`.`crm_prev_policy_insurer` (`id`, `prev_policy_insurer_slug`, `prev_policy_insurer_name`, `short_name`, `logo`, `date_added`, `date_updated`, `status`) VALUES (NULL, '26', 'COCO', 'Coco', 'logo_26.png', '2017-08-29 12:02:24', '2018-02-18 06:00:02', '1');
ALTER TABLE `crm_insurance_quotes_addon` ADD `add_on_perc` VARCHAR(20) NOT NULL AFTER `add_on`;
ALTER TABLE `crm_insurance_customer_details` ADD `current_loan_taken` ENUM('1','2') NOT NULL AFTER `current_ins_duration`;
ALTER TABLE `crm_insurance_customer_details` ADD `current_hp_to` INT(5) NOT NULL AFTER `current_loan_taken`;
ALTER TABLE `crm_insurance_customer_details` CHANGE `current_loan_taken` `current_loan_taken` ENUM('0','1','2') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0';
ALTER TABLE `crm_insurance_payment_reason` ADD `type` ENUM('1','2') NOT NULL AFTER `reason`;
INSERT INTO `crm`.`crm_insurance_payment_reason` (`id`, `reasonId`, `reason`, `type`) VALUES (NULL, '4', 'New car deal', '2');
INSERT INTO `crm`.`crm_insurance_payment_reason` (`id`, `reasonId`, `reason`, `type`) VALUES (NULL, '5', 'Used car deal', '2');
ALTER TABLE `crm_insurance_customer_details` ADD `sisreasonId` INT(4) NOT NULL AFTER `reasonId`;
ALTER TABLE `crm_insurance_customer_details` ADD `in_instrument_no` VARCHAR(50) NOT NULL AFTER `in_cheque_no`;
ALTER TABLE `crm_insurance_customer_details` ADD `in_instrument_date` DATE NOT NULL AFTER `in_instrument_no`;
ALTER TABLE `crm_insurance_customer_details` ADD `receipt_date` DATE NOT NULL AFTER `receipt_no`;
ALTER TABLE `crm_insurance_customer_details` ADD `instrument_no` VARCHAR(50) NOT NULL AFTER `cheque_no`;
ALTER TABLE `crm_insurance_customer_details` ADD `instrument_date` DATE NOT NULL AFTER `instrument_no`;
ALTER TABLE `crm_insurance_customer_details` ADD `cpayment_by` TINYINT(4) NOT NULL AFTER `payment_by`;