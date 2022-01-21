ALTER TABLE `crm_uc_sales_payment` 
ADD COLUMN `remarks` VARCHAR(255) NULL AFTER `status`;


ALTER TABLE `crm_used_car_sale_case_info` 
ADD COLUMN `is_buyer_details_completed` ENUM('0', '1') NULL DEFAULT '0' AFTER `loan_case_Id`,
ADD COLUMN `is_tranx_details_completed` ENUM('0', '1') NULL DEFAULT '0' AFTER `is_buyer_details_completed`,
ADD COLUMN `is_booking_details_completed` ENUM('0', '1') NULL DEFAULT '0' AFTER `is_tranx_details_completed`,
ADD COLUMN `is_payment_details_completed` ENUM('0', '1') NULL DEFAULT '0' AFTER `is_booking_details_completed`,
ADD COLUMN `is_delivery_details_completed` ENUM('0', '1') NULL DEFAULT '0' AFTER `is_payment_details_completed`;



ALTER TABLE `crm_uc_sales_delivery` 
ADD COLUMN `sold_invoice_no` VARCHAR(45) NULL AFTER `updated_date`,
ADD COLUMN `sold_invoice_date` DATETIME NULL AFTER `sold_invoice_no`;



