ALTER TABLE `crm_insurance_quotes_filter` ADD `ncb_discount_prev` INT( 5 ) NOT NULL AFTER `ncb_discount`;

INSERT INTO `dealercrmstaging`.`crm_insurance_additional_cover` (
`id` ,
`coverName` ,
`labelName` ,
`txtflag` ,
`priority` ,
`status`
)
VALUES (
'16', 'Anti Theft', 'Anti Theft', '1', '1', '1'
);


ALTER TABLE `crm_insurance_quotes_addon` ADD `anti_theft` enum('0','1' ) NOT NULL ;
ALTER TABLE `crm_insurance_quotes_addon` ADD `anti_theft_txt` VARCHAR( 20 ) NOT NULL ;

ALTER TABLE `crm_insurance_quotes_filter` ADD `policy_type` TINYINT(4) NOT NULL DEFAULT '0' AFTER `ncb_discount_prev`;

ALTER TABLE `crm_insurance_quotes` ADD `status` ENUM( '0', '1' ) NOT NULL DEFAULT '1';
