CREATE TABLE `crm_lead_assign_rule` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `dealer_id` INT(11) NOT NULL,
  `rule_type` ENUM('2', '1') NULL DEFAULT '1',
  `created_date` DATETIME NULL,
  `updated_date` DATETIME NULL,
  `status` ENUM('0', '1') NULL DEFAULT '1',
  PRIMARY KEY (`id`, `dealer_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));

CREATE TABLE `crm_lead_assign_rule_mapping` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `rule_id` INT(11) NULL,
  `user_id` INT(11) NULL,
  `rule_valid_from` VARCHAR(50) NULL,
  `rule_valid_to` VARCHAR(50) NULL,
  `created_date` DATETIME NULL,
  `updated_date` DATETIME NULL,
  `status` ENUM('0', '1') NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));


CREATE TABLE `crm_car_price_segment` (
  `id` INT(4) NOT NULL AUTO_INCREMENT,
  `min_price` VARCHAR(50) NULL,
  `max_price` VARCHAR(50) NULL,
  `dealer_id` INT(11) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));

ALTER TABLE `crm_buy_lead_dealer_mapper` 
ADD COLUMN `updated_by` INT(11) NULL AFTER `added_by`,
ADD COLUMN `assigned_to` INT(11) NULL AFTER `updated_by`;


CREATE TABLE `crm_dc_sync_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `reference_log_id` int(11) DEFAULT NULL,
  `dealer_id` int(11) DEFAULT NULL,
  `source` varchar(45) DEFAULT NULL,
  `sync_module` varchar(50) DEFAULT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `reference_lead_id` int(11) DEFAULT NULL,
  `api_url` varchar(100) DEFAULT NULL,
  `request` text,
  `response` text,
  `status` enum('T','F') DEFAULT NULL,
  `added_by` varchar(45) DEFAULT NULL,
  `sent_time` datetime DEFAULT NULL,
  `response_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE `crm_dc_sync_log` 
ADD COLUMN `stock_id` INT(11) NULL AFTER `sync_module`;


ALTER TABLE `crm_buy_lead_dealer_mapper` 
ADD COLUMN `syncd_with_dc` ENUM('0', '1') NULL DEFAULT '0' AFTER `assigned_to`;


#####################################################
update  `crm_user` set dealer_id=69 where dealer_id=49;
update  `crm_used_car` set dealer_id=69 where dealer_id=49;
update  `crm_buy_lead_dealer_mapper` set ldm_dealer_id=69 where ldm_dealer_id=49;
update  `crm_buy_lead_history_track` set dealer_id=69 where dealer_id=49;
update  `crm_buy_lead_addedit_log` set dealer_id=69 where dealer_id=49;

update  `crm_admin_dealers` set dealer_id=6359 where dealer_id=69;
update  `crm_user` set dealer_id=6359 where dealer_id=69;
update  `crm_used_car` set dealer_id=6359 where dealer_id=69;
update  `crm_buy_lead_dealer_mapper` set ldm_dealer_id=6359 where ldm_dealer_id=69;
update  `crm_buy_lead_history_track` set dealer_id=6359 where dealer_id=69;
update  `crm_buy_lead_addedit_log` set dealer_id=6359 where dealer_id=69;







