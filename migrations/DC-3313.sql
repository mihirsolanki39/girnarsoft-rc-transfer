ALTER TABLE `crm_used_car_other_fields` 
ADD COLUMN `seller_type` ENUM('1', '2') NULL AFTER `customer_id`;

ALTER TABLE `sell_customer` ADD `crm_customer_id` INT NOT NULL AFTER `dcleadid`;
ALTER TABLE `crm_used_car` 
ADD COLUMN `insurer_id` INT(11) NULL AFTER `insurance_exp_month`,
ADD COLUMN `insurance_policy_no` VARCHAR(50) NULL AFTER `insurer_id`;

ALTER TABLE `usedcar_payment_details` ADD `expected_price` VARCHAR(50) NOT NULL AFTER `updated_at`;
ALTER TABLE `loan_customer_case` ADD `mm` INT NOT NULL AFTER `versionId`, ADD `myear` INT NOT NULL AFTER `mm`;
ALTER TABLE  `crm_central_stock` ADD  `mm` INT NOT NULL AFTER  `version_id` ,
ADD  `myear` INT NOT NULL AFTER  `mm` ,
ADD  `km` VARCHAR( 20 ) NOT NULL AFTER  `myear` ;

ALTER TABLE `crm_insurance_case_details` ADD `renew_flag` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `policy_issued_date`;

ALTER TABLE  `crm_customers` DROP  `city_id` ,
DROP  `location_id` ,
DROP  `gaadi_verified` ,
DROP  `opt_verified` ,
DROP  `is_finance` ,
DROP  `lead_score` ,
DROP  `date_time` ,
DROP  `updated_date` ,
DROP  `active` ;

ALTER TABLE  `crm_customers` ADD  `module` VARCHAR( 30 ) NOT NULL AFTER  `mobile` ,
ADD  `created_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER  `module` ,
ADD  `status` ENUM(  '0',  '1' ) NOT NULL DEFAULT  '1' AFTER  `created_date` ;

