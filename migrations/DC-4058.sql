CREATE TABLE`crm_stock_tally_log` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `car_id` INT(11) NULL,
  `status` ENUM('0', '1', '2', '3', '4', '5','6') NULL COMMENT '1=>in 2 => out 3 =>other 4 =>refurb 5=>delivered 6=>removed',
  `assigned_to` VARCHAR(50) NULL,
  `created_date` DATETIME NULL,
  `updated_date` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));
ALTER TABLE `crm_stock_tally_log` 
ADD COLUMN `archived` ENUM('0', '1') NULL DEFAULT '0' AFTER `assigned_to`;
ALTER TABLE `crm_stock_tally_log` 
ADD COLUMN `reco_car_id` INT(11) NULL AFTER `id`;



CREATE TABLE `crm_stock_keys_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dealer_id` int(11) DEFAULT NULL,
  `keys_in` int(11) DEFAULT NULL,
  `keys_out` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
);

CREATE TABLE `crm_reco_stock` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `dealer_id` INT(11) NULL,
  `version_id` INT(11) NULL,
  `make_year` VARCHAR(45) NULL,
  `reg_no` VARCHAR(45) NULL,
  `status` ENUM('1', '2', '3') NULL COMMENT '1=>active 2=>removed 3 =>sold',
  `created_date` DATETIME NULL,
  `updated_date` DATETIME NULL,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  PRIMARY KEY (`id`));








