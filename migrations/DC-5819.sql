ALTER TABLE `crm_insurance_payout_details` ADD `policy_issued` ENUM( '1', '2' ) NOT NULL AFTER `policy_no` ;

ALTER TABLE `crm_insurance_uploaded_payout`
  DROP `updated_by`,
  DROP `updated_on`;