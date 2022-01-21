/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  gauravtayal
 * Created: 16 Sep, 2019
 */

ALTER TABLE `crm_refurb_details` ADD `sent_km` DOUBLE NULL DEFAULT NULL AFTER `actual_amt` ;

ALTER TABLE `crm_refurb_details` ADD `return_km` DOUBLE NULL DEFAULT NULL AFTER `sent_km` ;

ALTER TABLE `crm_refurb_details` CHANGE `sent_to_refurb` `sent_to_refurb` DATETIME NOT NULL ;

ALTER TABLE `crm_refurb_details` CHANGE `estimated_date` `estimated_date` DATETIME NOT NULL ;

ALTER TABLE `crm_workshop_detail_carids` CHANGE `workshop_detail_id` `workshop_detail_id` VARCHAR( 20 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'workshop payment id ';