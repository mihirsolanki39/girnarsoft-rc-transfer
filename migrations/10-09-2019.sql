/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  gauravtayal
 * Created: 10 Sep, 2019
 */

ALTER TABLE `crm_used_car_miscellaneous` ADD `honda_id` INT( 11 ) NOT NULL DEFAULT '0' AFTER `ford_id` ,
ADD `dealercrm_id` INT( 11 ) NOT NULL DEFAULT '0' AFTER `honda_id` ;

ALTER TABLE `crm_used_car_miscellaneous` ADD `secondaryid` INT( 1 ) NULL DEFAULT '0',
ADD `encrypt_id_cardekho` VARCHAR( 100 ) NULL DEFAULT NULL ,
ADD `encrypt_id_gaadi` VARCHAR( 100 ) NULL DEFAULT NULL ,
ADD `stock_type` ENUM( 'stock_car', 'customer_car', '', '' ) NOT NULL ,
ADD `market_price` VARCHAR( 50 ) NULL DEFAULT NULL ;

ALTER TABLE `crm_used_car_miscellaneous` CHANGE `stock_type` `stock_type` ENUM( 'stock_car', 'customer_car', '0', '' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0';

ALTER TABLE `used_car_miscellaneous` CHANGE `stock_type` `stock_type` ENUM( 'stock_car', 'customer_car', '0', '' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0';

