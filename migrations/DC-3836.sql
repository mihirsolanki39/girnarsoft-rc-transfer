CREATE TABLE `crm_quote_source` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crm_quote_source`
--

INSERT INTO `crm_quote_source` (`id`, `name`, `status`) VALUES
(1, 'Inhouse', '1'),
(2, 'GirnarSoft', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crm_quote_source`
--
ALTER TABLE `crm_quote_source`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crm_quote_source`
--
ALTER TABLE `crm_quote_source`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `crm_insurance_additional_cover` ADD `status` ENUM('0','1') NOT NULL DEFAULT '1' AFTER `priority`;
UPDATE `crm_insurance_additional_cover` SET `status` = '0' WHERE `crm_insurance_additional_cover`.`id` = 8;
UPDATE `crm_insurance_additional_cover` SET `status` = '0' WHERE `crm_insurance_additional_cover`.`id` = 9;
UPDATE `crm_insurance_additional_cover` SET `status` = '0' WHERE `crm_insurance_additional_cover`.`id` = 10;

ALTER TABLE `crm_insurance_quotes` ADD `qsource` INT(5) NOT NULL AFTER `ftype`;
ALTER TABLE `crm_insurance_quotes` ADD `pass_cover` VARCHAR(20) NOT NULL AFTER `paid_driver`;
ALTER TABLE `crm_insurance_quotes_addon` ADD `totadd_on` VARCHAR(20) NOT NULL AFTER `add_on_perc`;

INSERT INTO `crm_prev_policy_insurer` (`id`, `prev_policy_insurer_slug`, `prev_policy_insurer_name`, `short_name`, `logo`, `date_added`, `date_updated`, `status`) VALUES (NULL, '27', 'Edelweiss Tokio', 'Edelweiss Tokio', 'logo_27.png', '2017-08-29 12:02:24', '2018-02-18 06:00:02', '1');
INSERT INTO `crm_prev_policy_insurer` (`id`, `prev_policy_insurer_slug`, `prev_policy_insurer_name`, `short_name`, `logo`, `date_added`, `date_updated`, `status`) VALUES (NULL, '28', 'Cholamandalam MS', 'Cholamandalam MS', 'logo_28.png', '2017-08-29 12:02:24', '2018-02-18 06:00:02', '1');
UPDATE `crm_prev_policy_insurer` SET `status` = '1' WHERE `crm_prev_policy_insurer`.`id` = 13;
UPDATE `crm_prev_policy_insurer` SET `status` = '1' WHERE `crm_prev_policy_insurer`.`id` = 22;
UPDATE `crm_prev_policy_insurer` SET `logo` = 'logo_13.png' WHERE `crm_prev_policy_insurer`.`id` = 13;
UPDATE `crm_prev_policy_insurer` SET `logo` = 'logo_22.png' WHERE `crm_prev_policy_insurer`.`id` = 22;
UPDATE `crm_prev_policy_insurer` SET `short_name` = 'L & T Insurance' WHERE `crm_prev_policy_insurer`.`id` =13;
UPDATE  `crm_prev_policy_insurer` SET `short_name` = 'Magma HDI' WHERE `crm_prev_policy_insurer`.`id` =22;
ALTER TABLE `crm_insurance_customer_details` ADD `pay_remark` TEXT NOT NULL AFTER `reasonId` ;
ALTER TABLE `crm_insurance_customer_details` ADD `pay_in_remark` TEXT NOT NULL AFTER `pay_remark` ;