CREATE TABLE IF NOT EXISTS `crm_net_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `loan_amount` varchar(50) NOT NULL,
  `loan_short` varchar(50) NOT NULL,
  `processing_fee` bigint(11) NOT NULL,
  `counter_emi` int(11) NOT NULL,
  `total_emi` varchar(50) NOT NULL,
  `disburse_emi` varchar(50) NOT NULL,
  `insuranace` bigint(11) NOT NULL,
  `rc_trans_by` enum('1','2') NOT NULL DEFAULT '1',
  `rc_trans_price` bigint(11) NOT NULL,
  `other_adjustment` bigint(11) NOT NULL,
  `payout` varchar(20) NOT NULL,
  `remark` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;