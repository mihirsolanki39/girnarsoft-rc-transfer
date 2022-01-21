ALTER TABLE `crm_buy_lead_dealer_mapper` 
ADD COLUMN `added_by` INT(11) NULL AFTER `user_id`;


INSERT INTO `crm_header_role_mapping` (`menu_id`, `role_id`, `team_id`, `status`) VALUES ('13', '21', '7', '1');
INSERT INTO `crm_header_role_mapping` (`menu_id`, `role_id`, `team_id`, `status`) VALUES ('14', '21', '7', '1');
INSERT INTO `crm_header_role_mapping` (`menu_id`, `role_id`, `team_id`, `status`) VALUES ('15', '21', '7', '1');



INSERT INTO `crm_right_management` (`module`, `status`, `created_on`) VALUES ('dashboardDetails', '1', '2019-01-11 04:55:49');


INSERT INTO `crm_right_management_mapping` (`module_id`, `role_id`, `team_id`, `add_permission`, `edit_permission`, `view_permission`, `status`, `created_on`) VALUES ('34', '21', '7', '1', '1', '1', '1', '2018-12-12 05:13:09');
INSERT INTO `crm_right_management_mapping` (`module_id`, `role_id`, `team_id`, `add_permission`, `edit_permission`, `view_permission`, `status`, `created_on`) VALUES ('34', '17', '7', '1', '1', '1', '1', '2018-12-12 05:13:09');




