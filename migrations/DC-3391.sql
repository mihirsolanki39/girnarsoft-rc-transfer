ALTER TABLE `crm_buy_lead_customer` 
ADD COLUMN `central_customer_id` INT(11) NULL AFTER `active`;


ALTER TABLE `crm_used_car_other_fields` 
ADD COLUMN `remove_reason_id` INT(4) NULL AFTER `refurbdetail`;

UPDATE `stock_removal_reason` SET `status`='0' WHERE `id`='1';
UPDATE `stock_removal_reason` SET `status`='0' WHERE `id`='2';
UPDATE `stock_removal_reason` SET `status`='0' WHERE `id`='3';


#UPDATE `crm_role` SET `team_id`='7' WHERE `id`='19';
INSERT INTO `crm_role` (`role_name`, `team_id`, `status`, `created_date`, `updated_date`, `created_by`, `updated_by`) VALUES ('Accountant', '7', '1', '2018-10-30 12:31:38', '2018-10-30 12:31:38', '69', '0');


ALTER TABLE `crm_used_car_sale_case_info` 
ADD COLUMN `car_id` INT(11) NULL AFTER `ldm_id`;

############

CREATE TABLE `crm_uc_sales_transactions` (
  `id` INT(11) NOT NULL,
  `case_id` INT(11) NULL,
  `uc_sales_exe_id` INT(11) NULL,
  `trnx_status` ENUM('1', '2') NULL,
  `new_insurance_req` ENUM('0', '1') NULL,
  `insurance_case_id` INT(11) NULL,
  `loan_req` ENUM('0', '1') NULL,
  `loan_case_id` INT(11) NULL,
  `base_vehicle_price` VARCHAR(45) NULL,
  `tcs` VARCHAR(45) NULL,
  `amount` VARCHAR(45) NULL,
  `actual_amount` VARCHAR(45) NULL,
  `advance_payment` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));

ALTER TABLE `crm_uc_sales_transactions` 
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `uc_sales_case_id` `uc_sales_case_id` INT(11) UNSIGNED NULL DEFAULT NULL ;

ALTER TABLE `crm_uc_sales_transactions` 
CHANGE COLUMN `case_id` `uc_sales_case_id` INT(11) NULL DEFAULT NULL ;

ALTER TABLE `crm_uc_sales_transactions` 
ADD COLUMN `additional_accessories` VARCHAR(255) NULL AFTER `advance_payment`;

ALTER TABLE `crm_uc_sales_transactions` 
ADD COLUMN `rto_charges` VARCHAR(45) NULL AFTER `tcs`;

ALTER TABLE `crm_uc_sales_transactions` 
ADD COLUMN `created_date` DATETIME NULL AFTER `additional_accessories`,
ADD COLUMN `updated_date` DATETIME NULL AFTER `created_date`;

ALTER TABLE `crm_uc_sales_transactions` 
ADD COLUMN `loan_amount` VARCHAR(45) NULL AFTER `updated_date`,
ADD COLUMN `bank_id` INT(11) NULL AFTER `loan_amount`,
ADD COLUMN `roi` VARCHAR(45) NULL AFTER `bank_id`,
ADD COLUMN `tenure` VARCHAR(45) NULL AFTER `roi`,
ADD COLUMN `valuaton_charges` VARCHAR(45) NULL AFTER `tenure`,
ADD COLUMN `hypothecation` VARCHAR(45) NULL AFTER `valuaton_charges`,
ADD COLUMN `processing_fee` VARCHAR(45) NULL AFTER `hypothecation`;
ADD COLUMN `insurance_charges` VARCHAR(45) NULL AFTER `processing_fee`;


CREATE TABLE `crm_uc_sales_booking` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `uc_sales_case_id` VARCHAR(45) NULL,
  `booking_date` DATETIME NULL,
  `date_of_delivery` DATETIME NULL,
  `booking_amount` VARCHAR(45) NULL,
  `booking_form_no` VARCHAR(45) NULL,
  `instrument_type` ENUM('cash', 'cheque', 'dd', 'online') NULL,
  `instrument_no` VARCHAR(45) NULL,
  `instrument_date` DATETIME NULL,
  `bank_id` INT(11) NULL,
  `favouring` VARCHAR(45) NULL,
  `payment_date` VARCHAR(45) NULL,
  `receipt_no` VARCHAR(45) NULL,
  `created_date` DATETIME NULL,
  `updated_date` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));

CREATE TABLE `crm_uc_sales_payment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `uc_sales_case_id` INT(11) NULL,
  `sold_on` DATETIME NULL,
  `sold_invoice_no` VARCHAR(45) NULL,
  `sold_invoice_date` DATETIME NULL,
  `instrument_type` ENUM('cash', 'cheque', 'dd', 'online') NULL,
  `amount` VARCHAR(45) NULL,
  `instrument_no` VARCHAR(45) NULL,
  `instrument_date` DATETIME NULL,
  `favouring` VARCHAR(45) NULL,
  `bank_id` INT(4) NULL,
  `payment_date` DATETIME NULL,
  `created_date` DATETIME NULL,
  `updated_date` DATETIME NULL,
  `status` ENUM('0', '1') NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));
ALTER TABLE `crm_uc_sales_payment` 
ADD COLUMN `is_advance_payment` ENUM('0', '1') NOT NULL DEFAULT '0' AFTER `payment_date`;

ALTER TABLE `crm_uc_sales_payment` 
ADD COLUMN `updated_by` INT(11) NULL AFTER `updated_date`;


CREATE TABLE `crm_uc_sales_delivery` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `is_delivered` ENUM('0', '1') NULL DEFAULT '0',
  `delivery_date` DATETIME NULL,
  `created_date` DATETIME NULL,
  `updated_date` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));
ALTER TABLE `crm_uc_sales_delivery` 
ADD COLUMN `uc_sales_case_id` INT(11) NULL AFTER `id`;

ALTER TABLE `crm_uc_sales_delivery` 
ADD COLUMN `gate_pass_no` VARCHAR(50) NULL AFTER `delivery_date`;

ALTER TABLE `crm_used_car_sale_case_info` 
ADD COLUMN `is_vehicle_images_uploaded` ENUM('0', '1') NULL DEFAULT '0' AFTER `buyer_type`,
ADD COLUMN `is_buyer_docs_uploaded` ENUM('0', '1') NULL DEFAULT '0' AFTER `is_vehicle_images_uploaded`;

ALTER TABLE `crm_used_car_sale_case_info` 
ADD COLUMN `insurance_customer_id` INT(11) NULL AFTER `is_buyer_docs_uploaded`;
ADD COLUMN `insurance_case_id` INT(11) NULL AFTER `insurance_customer_id`;

ALTER TABLE `crm_used_car_sale_case_info` 
ADD COLUMN `loan_customer_id` INT(11) NULL AFTER `insurance_case_id`,
ADD COLUMN `loan_case_Id` INT(11) NULL AFTER `loan_customer_id`;


CREATE TABLE `crm_document_checklist` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `doc_type` VARCHAR(45) NULL,
  `case_id` INT(11) NULL,
  `tag_id` INT(11) NULL,
  `status` ENUM('1', '2', '3') NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));




















