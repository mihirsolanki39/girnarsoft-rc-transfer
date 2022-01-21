INSERT INTO `crm_team_type` (`team_name`, `status`, `created_date`, `updated_date`, `created_by`) VALUES ('All', '1', '2019-05-07 12:34:02', '2019-05-07 12:34:02', '0');
INSERT INTO `crm_role` (`role_name`, `team_id`, `status`, `created_date`, `updated_date`, `created_by`, `updated_by`) VALUES ('Manager', '8', '1', '2019-05-08 12:31:38', '2019-05-08 12:31:38', '69', '0');


ALTER TABLE `crm_usedcar_purchase_caseinfo` 
ADD COLUMN `closed_by` INT(11) NULL AFTER `tradetype`;

ALTER TABLE `crm_usedcar_purchase_caseinfo` 
ADD COLUMN `is_case_details_completed` ENUM('0', '1') NULL DEFAULT '0' AFTER `closed_by`;



ALTER TABLE `crm_used_car_sale_case_info` 
ADD COLUMN `source_name` VARCHAR(45) NULL AFTER `is_delivery_details_completed`;
ALTER TABLE `crm_used_car_sale_case_info` 
CHANGE COLUMN `source_name` `source_id` INT(4) NULL ,
ADD COLUMN `source_category_id` INT(4) NULL AFTER `is_delivery_details_completed`;




