/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  gauravtayal
 * Created: 7 Nov, 2019
 */

ALTER TABLE `crm_used_car` ADD `min_selling_price` BIGINT( 20 ) NOT NULL AFTER `car_price` ;


ALTER TABLE `crm_used_car_other_fields` ADD `commission` BIGINT NULL AFTER `listing_price` ,
ADD `insurance` BIGINT NULL AFTER `commission` ,
ADD `rent` BIGINT NULL AFTER `insurance` ,
ADD `refurb_cost` BIGINT NULL AFTER `rent` ,
ADD `misc_exp` BIGINT NULL AFTER `refurb_cost` ;


INSERT INTO `dealercrmbeta`.`crm_role` (
`id` ,
`role_name` ,
`team_id` ,
`status` ,
`created_date` ,
`updated_date` ,
`created_by` ,
`updated_by`
)
VALUES (
NULL , 'Senior Manager', '7', '1', '2018-12-18 04:20:32', '2019-01-03 16:03:40', '69', '0'
);


INSERT INTO `dealercrmbeta`.`crm_role` (
`id` ,
`role_name` ,
`team_id` ,
`status` ,
`created_date` ,
`updated_date` ,
`created_by` ,
`updated_by`
)
VALUES (
NULL , 'Mr X', '7', '0', '2018-12-18 04:20:32', '2019-01-03 16:03:40', '69', '0'
);

ALTER TABLE `crm_used_car` CHANGE `reg_date` `reg_date` DATE NOT NULL ;
