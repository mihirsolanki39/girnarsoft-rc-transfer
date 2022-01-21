ALTER TABLE `crm_finance_delivery` ADD `do_updated_status` ENUM( '1', '2' ) NOT NULL DEFAULT '1' AFTER `last_updated_status` ;

ALTER TABLE `crm_finance_delivery` ADD `created_by` INT NOT NULL AFTER `cancel_id` ;
ALTER TABLE `crm_finance_delivery` ADD `created_on` DATETIME NOT NULL AFTER `created_by` ;
ALTER TABLE `crm_finance_delivery` ADD `updated_by` INT NOT NULL AFTER `created_on` ;

ALTER TABLE `crm_finance_delivery` ADD `updated_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `updated_by` ;