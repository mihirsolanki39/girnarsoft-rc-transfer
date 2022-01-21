<?php 
defined('PAYMENT_MODE_CUSTOMER') OR define('PAYMENT_MODE_CUSTOMER', [
	'1' => 'Cheque',
	'2' => 'Online',
	'3' => 'Cash',
	'4' => 'DD',
]);

defined('PAYMENT_BY') OR define('PAYMENT_BY', [
	'1' => 'Customer',
	'2' => 'Inhouse',
	'3' => 'Abc/BCSPL',
]);

defined('CancelReasonInsurance') OR define('CancelReasonInsurance', [
	'0' => 'Select Reason For Cancelling The Policy',
	'1' => 'Add ons missing in issued policy',
	'2' => 'Cancelled by insurer',
	'3' => 'Other',
	'4' => 'Duplicate Entry',
]);

defined('CancelReasonLoan') OR define('CancelReasonLoan', [
	'0' => 'Select Cancel Reason',
	'1' => 'Not Loanable Customer',
	'2' => 'Customer Backout',
	'3' => 'Incomplete Documentation',
	'4' => 'Duplicate Entry',
	'5' => 'Test Entry',
	'6' => 'Documents Not Received',
	'7' => 'Invalid Phone Number',
	'8' => 'Customer Not Interested',
	'9' => 'No Answer/Not Connected',
]);
const dateStart ='2020/01/28';
const CASES_FUNNEL = array('new_cases' =>'Cases Added','quote_shared_case' =>'Quote Shared','issued_cases' =>'Policy Issued');
const Payout_CASES = array("payout_case"=>"To Pay","payout_receive_case"=>"To Recieve");

const LOAN_CARDS = array("Work In Progress"=>"1","Pending Activities Cases" =>"2","Payout Pending Cases"=>"3","Cases Funnel"=>"4","Trend Chart"=>"5","Disbursal Amount"=>"6");
const IN_PROGRESS_TAB = array('active_cases' =>'Active Cases','policies_pending' =>'Policies Pending','payment_pending' =>'Payment Pending','document_pending' =>'Document Pending');
const LOAN_IN_PROGRESS_TAB = array('active_cases' =>'Active Cases','awaiting_login' =>'Awaiting Login','awaiting_decision' =>'Awaiting Decision','awaiting_disbursal' =>'Awaiting Disbursal');
const LOAN_PROGRESS_URL = array('active_cases' =>'loanListing/1','awaiting_login' =>'loanListing/2','awaiting_decision' =>'loanListing/3','awaiting_disbursal' =>'loanListing/4');
const LOAN_CASES_FUNNEL = array('new_cases' =>'Cases Added','filed' =>'filed','approved' =>'Approved','disbursed' =>'Disbursed');
const PENDING_ACTIVITIES_CASES = array("document_upload"=>"Document Upload","loan_payment"=>"Loan Payment");
const LOAN_PENDING_URL =  array('document_upload' =>'loanListing/5','loan_payment' =>'loanListing/6');
const LOAN_PAYOUT_CASES_URL = array("payout_case"=>"loanPayout/3");

const INSURANCE_CARDS = array("Work In Progress"=>"1","Renewals" =>"2","Payout Pending Cases"=>"3","Cases Funnel"=>"4","Trend Chart"=>"5","OD Amount"=>"6");
const RENEWAL_COUNT = array('renewal_cases' =>'Renewals Cases','today_follow' =>'Today Follow Up','policy_expired_daywise' =>'Policy Expired In Next 7 Days','policy_expired' =>'Policy Expired');
const PROGRESS_URL = array('active_cases' =>'insListing/1','policies_pending' =>'insListing/2','payment_pending' =>'insListing/3','document_pending' =>'insListing/5');
const RENEWAL_URL = array('renewal_cases' =>'renewlisting/1','today_follow' =>'renewlisting/2','policy_expired_daywise' =>'renewlisting/3','policy_expired' =>'renewlisting/4');
const INS_DOC_TYPE ='3';
const PAYOUT_CASES_URL = array("payout_case"=>"insurancePayout/3","payout_receive_case"=>"payoutFromCompanies/3");

const RC_CARDS = array("Pending Activities"=>"2","Bank Limit Left" =>"2","Delay( > 15 Days)"=>"3");
const RC_PENDING_TAB =  array('pending_rc_cases' =>'Pending RC Cases','in_progress_rc' =>'In Process RC Cases');
const RC_PENDING_URL =  array('pending_rc_cases' =>'rcListing/1','in_progress_rc' =>'rcListing/2');
const RC_DELAY_URL =  array('pending_rc_cases' =>'rcListing/7','in_progress_rc' =>'rcListing/8');

const DO_CARDS = array("Pending Cases"=>"2","Balance" =>"3","Cases Trend"=>"5");	
const DO_PENDING_CASES = array('loan_pending' =>'Loan Pending','payment_pending' =>'Payment Pending');
const DO_PROGRESS_URL = array('loan_pending' =>'orderListing/1','payment_pending' =>'orderListing/2');
const DO_SHOWROOM_CASES = array('showroom_balance' =>'Showroom Balance','customer_balance' =>'Customer Balance');

const STOCK_CARDS = array("Stock Status"=>"2");	
const STOCK_STATUS_CASES = array('active_case' =>'Active Cases','age_45_days' =>'age > 45 Days');
const STOCK_STATUS_URL = array('active_case' =>'inventoryListing/1','age_45_days' =>'inventoryListing/2');

const LEAD_CARDS = array("Monthly Lead Dashboard"=>"1");	
const LEAD_STATUS_CASES = array('lead_added' =>'Lead Added','walkdone' =>'Walk-In Done','conversion' =>'Conversion','pending' =>'Pending');
const LEAD_STATUS_URL = array('lead_added' =>'lead/getLeads/currleadadd','walkdone' =>'getdashboardlistpage/walkin','conversion'=>'getdashboardlistpage/conversion','pending'=>'lead/getLeads/pending');

$config = [];
