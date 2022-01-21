ALTER TABLE `crm_insurance_quotes` ADD `quote_date` DATE NOT NULL AFTER `status` ;ALTER TABLE `crm_insurance_quotes` ADD `quote_date` DATE NOT NULL AFTER `status` ;

ALTER TABLE `crm_insurance_quotes` ADD `idv_2` varchar( 10 ) NULL DEFAULT NULL AFTER `idv` ;

ALTER TABLE `crm_insurance_quotes` ADD `idv_3` varchar( 10 ) NULL DEFAULT NULL AFTER `idv_2`;

ALTER TABLE `crm_insurance_case_details` ADD `ncb_transfer` ENUM( '1', '2' ) NOT NULL DEFAULT '2' COMMENT '"1"=>Yes,"2"=>N0' AFTER `left_menu_status` ;

ALTER TABLE `crm_insurance_case_details` CHANGE `assign_to` `assign_to` INT( 11 ) NOT NULL COMMENT 'employee=1, executive=2';