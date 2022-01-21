INSERT INTO `crm_insurance_additional_cover` (`id`, `coverName`, `labelName`, `txtflag`, `priority`) VALUES ('14', 'loss_of_personal_belonging', 'Loss of personal belonging', '1', '1');
INSERT INTO `crm_insurance_additional_cover` (`id`, `coverName`, `labelName`, `txtflag`, `priority`) VALUES ('15', 'emergency_transport_hotel_premium', 'Emergency transport hotel premium', '1', '1');
ALTER TABLE `crm_insurance_quotes_addon` ADD `loss_of_personal_belonging` ENUM('0','1') NOT NULL AFTER `non_electrical_accessories_txt`;
ALTER TABLE `crm_insurance_quotes_addon` ADD `loss_of_personal_belonging_txt` VARCHAR(20) NOT NULL AFTER `loss_of_personal_belonging`;
ALTER TABLE `crm_insurance_quotes_addon` ADD `emergency_transport_hotel_premium` ENUM('0','1') NOT NULL AFTER `loss_of_personal_belonging_txt`;
ALTER TABLE `crm_insurance_quotes_addon` ADD `emergency_transport_hotel_premium_txt` VARCHAR(20) NOT NULL AFTER `emergency_transport_hotel_premium`;
ALTER TABLE `crm_insurance_customer_details` ADD `subvention_amt` VARCHAR(50) NOT NULL AFTER `amount`;
ALTER TABLE `crm_insurance_customer_details` ADD `in_subvention_amt` VARCHAR(50) NOT NULL AFTER `in_amount`;