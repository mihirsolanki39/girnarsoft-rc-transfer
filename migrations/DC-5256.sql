ALTER TABLE `crm_rc_info` ADD `rto_work` VARCHAR(50) NOT NULL DEFAULT '0' AFTER `bank_id_loan` ;

ALTER TABLE `crm_rc_info` ADD `rto_charges` VARCHAR(50) NULL DEFAULT NULL AFTER `rto_work` ;

ALTER TABLE `crm_insurance_case_details` CHANGE `updated_date` `updated_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;