ALTER TABLE `crm_rc_info` ADD `in_process_date` DATE NOT NULL AFTER `status` ;

ALTER TABLE `loan_history_log` ADD `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;

ALTER TABLE `crm_insurance_inq_history` CHANGE `updated_date` `updated_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `crm_finance_delivery` ADD `customer_balance` VARCHAR( 100 ) NOT NULL COMMENT 'for dashboard purpose' AFTER `cancel_id` ;

ALTER TABLE `crm_finance_delivery` ADD `showroom_balance` VARCHAR( 100 ) NOT NULL COMMENT 'for dashboard purpose' AFTER `customer_balance` ;

