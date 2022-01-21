ALTER TABLE `crm_usedcar_purchase_caseinfo` 
ADD COLUMN `liquid_mode` ENUM('1', '2') NULL DEFAULT '1' AFTER `is_case_details_completed`;

