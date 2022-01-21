CREATE TABLE `crm_payout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_id` int(11) NOT NULL,
  `dealer_id` int(11) NOT NULL,
  `prime_dealer_id` int(11) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_mode` tinyint(4) NOT NULL,
  `favouring_to` varchar(100) DEFAULT NULL,
  `amount` varchar(50) NOT NULL,
  `instrument_no` varchar(50) NOT NULL,
  `instrument_date` date NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `pay_remark` text NOT NULL,
  `tds_type` tinyint(4) NOT NULL,
  `tds_amount` varchar(50) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `crm_case_payout_mapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payout_id` int(11) NOT NULL,
  `dealer_id` int(10) NOT NULL,
  `sr_no` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `payout` varchar(50) NOT NULL,
  `payment_amount` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '"0"=>inactive,"1"=>active',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `payout_history_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dealer_id` int(11) NOT NULL,
  `bank_details` varchar(50) NOT NULL,
  `bank_id` int(20) NOT NULL,
  `payout_id` int(10) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` enum('Add','Update') NOT NULL DEFAULT 'Add',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `payout_history_update_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `updated_data` longtext NOT NULL,
  `payout_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(4) NOT NULL,
  `action` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0-add, 1-update',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `crm_payout` ADD `gst_type` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '\"1\"=>No,\"2\"=>Yes' AFTER `tds_amount`;

ALTER TABLE `crm_payout` ADD `gst_amount` VARCHAR(50) NULL DEFAULT NULL AFTER `gst_type`;

ALTER TABLE `crm_payout` ADD `total_amount` VARCHAR(50) NULL DEFAULT NULL AFTER `gst_amount`;

ALTER TABLE `crm_payout` ADD `gst_excluded_amount` VARCHAR(50) NOT NULL DEFAULT '0' AFTER `tds_amount`;