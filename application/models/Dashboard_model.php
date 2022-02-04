<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * model : Crm_dealers
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
class Dashboard_model extends CI_Model
{
	public function getInsuranceDashboard($empId = '')
	{
		$this->db->select("COUNT(distinct CASE WHEN icd.last_updated_status IN('1','2','3','4','5','6') AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) active_cases, COUNT(distinct CASE WHEN (icd.last_updated_status IN('5') AND `icd`.`renew_flag` = '0') THEN icd.id ELSE null END ) policies_pending, COUNT(distinct CASE WHEN icd.last_updated_status IN('6') AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) payment_pending,
        COUNT(distinct CASE WHEN (icd.upload_ins_doc_flag != '1' OR icd.left_menu_status !=" . INSURANCE_LEFT_SIDE_MENU['UPLOAD_DOCS'] . ") AND icd.last_updated_status IN(6,9) AND cd.current_policy_no != '0' AND cd.current_policy_no is not null AND cd.current_policy_no !='' AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) document_pending");
		$this->db->from('crm_insurance_case_details as icd');
		$this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id', 'inner');
		$this->db->join('crm_customers as cc', 'cc.id=cd.crm_customer_id', 'inner');
		$this->db->join('crm_insurance_update_status as us', 'us.statusId=icd.last_updated_status', 'left');
		$this->db->where('cc.mobile>', '0');
		if ($empId != '') {
			$this->db->where('icd.assign_to', $empId);
		}
		$query = $this->db->get();
		$result = $query->result_array();
		return  $result;
	}
	
	public function getPendingDocCount($empId = '')
	{
		$this->db->select("COUNT(distinct CASE WHEN  `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) document_pending");
		$this->db->from('crm_insurance_case_details as icd');
		$this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id', 'inner');
		$this->db->join('crm_customers as cc', 'cc.id=cd.crm_customer_id', 'inner');
		$this->db->join('loan_doc_pendency_mapping as ldpm', 'ldpm.case_id=icd.id AND doc_type = ' . INS_DOC_TYPE, 'inner');
		$this->db->where('cc.mobile>', '0');
		if ($empId != '') {
			$this->db->where('icd.assign_to', $empId);
		}
		$query = $this->db->get();
		$result = $query->row_array();
		return  $result['document_pending'];
	}
	public function getInsurn($empId = '')
	{
		$this->db->select('count(icd.id) as counter');
		$this->db->from('crm_insurance_case_details as icd');
		$this->db->join('crm_insurance_customer_details as cd', 'cd.id = icd.customer_id', 'inner');
		$this->db->join('crm_customers as cc', 'cc.id = `cd`.`crm_customer_id`', 'inner');
		$this->db->where('icd.renew_flag', '1');
		$this->db->where("`cc`.`mobile` > '0'");

		if ($empId != '') {
			$this->db->where('icd.assign_to', $empId);
		}
		$query = $this->db->get();
		$result = $query->row_array();
		return  $result['counter'];
	}
	public function getCaseWiseCount($empId = "")
	{
		$start = date("Y-m-d", strtotime(date('Y-m-01') . " -5 months"));
		$end = date("Y-m-d");
		$where = "DATE(icd.created_date)  >='" . $start . "' and DATE(icd.created_date) <='" . $end . "'";
		$where_quote = "DATE(icd.quote_add_date)  >='" . $start . "' and DATE(icd.quote_add_date) <='" . $end . "'";
		$where_issue = "DATE(cd.current_issue_date)  >='" . $start . "' and DATE(cd.current_issue_date) <='" . $end . "'";

		$this->db->select("COUNT(distinct CASE WHEN `icd`.`renew_flag` = '0' AND $where THEN icd.id ELSE null END ) new_cases, COUNT(distinct CASE WHEN (icd.last_updated_status IN ( 2, 3, 4, 5, 6, 9 ) AND $where_quote AND `icd`.`renew_flag` = '0') THEN icd.id ELSE null END ) quote_shared_case, COUNT(distinct CASE WHEN icd.last_updated_status IN(6,9) AND cd.current_policy_no != '0' AND cd.current_policy_no is not null AND cd.current_policy_no !='' AND $where_issue AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) issued_cases");
		$this->db->from('crm_insurance_case_details as icd');
		$this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id', 'inner');
		$this->db->join('crm_customers as cc', 'cc.id=cd.crm_customer_id', 'inner');
		$this->db->join('crm_insurance_update_status as us', 'us.statusId=icd.last_updated_status', 'left');
		$this->db->where('cc.mobile>', '0');
		if ($empId != '') {
			$this->db->where('icd.assign_to', $empId);
		}
		$query = $this->db->get();
		$result = $query->row_array();
		foreach (CASES_FUNNEL as $k => $case) {
			$response[] = "['$case', $result[$k]]";
		}
		// echo $this->db->last_query();die;
		return  $response;
	}
	public function getPayoutCaseCount($empId = "")
	{
		$start_date = date('Y-m-d', strtotime(dateStart));
		$this->db->select("COUNT(distinct CASE WHEN cpm.payout_id is null AND `icd`.`renew_flag` = '0' AND icd.source = 'dealer' AND cd.current_policy_type in (1,3) THEN icd.id ELSE null END ) payout_case,COUNT(distinct CASE WHEN (cipd.status ='1' || cipd.id is  null )AND DATE(cd.current_issue_date) >= '$start_date' AND icd.policy_status = '1' AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) payout_receive_case");
		$this->db->from('crm_insurance_case_details as icd');
		$this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id', 'inner');
		$this->db->join('crm_customers as cc', 'cc.id=cd.crm_customer_id', 'inner');
		$this->db->join('crm_insurance_update_status as us', 'us.statusId=icd.last_updated_status', 'left');
		$this->db->join('crm_insurance_case_payout_mapping as cpm', 'cpm.sr_no=icd.id AND cpm.status=1', 'left');
		$this->db->join('crm_insurance_payout_details as cipd', 'cipd.policy_no=cd.current_policy_no', 'left');
		$this->db->where('cc.mobile>', '0');
		$this->db->where("cd.current_policy_no != '0'");
		$this->db->where("cd.current_policy_no is not null");
		$this->db->where("cd.current_policy_no != ''");
		$this->db->where_in("us.statusId", array(6, 9));
		if ($empId != '') {
			$this->db->where('icd.assign_to', $empId);
		}
		$query = $this->db->get();
		$result = $query->row_array();
		return  $result;
	}
	public function getRenewalCount($empId = "")
	{
		$data = array();
		$dt = date("Y-m-d");
		$expired_7days = date("Y-m-d", strtotime("$dt +7 day"));
		$wheres1 = "(MONTH(cd.previous_due_date) > '" . date('m') . "' or (MONTH(cd.previous_due_date)='" . date('m') . "'  AND DAY(cd.previous_due_date) >= '" . date('d') . "'))";
		$wheres2 = "(MONTH(cd.previous_due_date) < '" . date('m') . "' or (MONTH(cd.previous_due_date)='" . date('m') . "'  AND DAY(cd.previous_due_date) < '" . date('d') . "'))";
		$wheres3 = "DATE(cd.previous_due_date) >='" . date("Y-m-d") . "' AND DATE(cd.previous_due_date) <='" . $expired_7days . "'";

		$this->db->select("count(DISTINCT(CASE WHEN ((icd.follow_up_date != '0000-00-00 00:00:00' AND date(icd.follow_up_date) = CURDATE() and $wheres1 or (Year(cd.previous_due_date) = YEAR(CURDATE()) and ((date(icd.follow_up_date)= CURDATE()) or (icd.follow_up_date ='0000-00-00 00:00:00')))) AND icd.follow_status != 5) THEN icd.id ELSE null END)) as today_follow, 
            count(DISTINCT(icd.id)) as renewal_cases, 
            count(DISTINCT(CASE WHEN ( $wheres2 AND icd.follow_status != 5) THEN icd.id ELSE null END)) as policy_expired,  
            count(DISTINCT(CASE WHEN ( $wheres3 AND icd.follow_status != 5) THEN icd.id ELSE null END)) as policy_expired_daywise ");

		$this->db->from('crm_insurance_case_details as icd');
		$this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id', 'inner');
		$this->db->join('crm_customers as lc', 'lc.id=cd.crm_customer_id', 'inner');
		if ($empId != '') {
			$this->db->where('icd.assign_to', $empId);
		}
		$this->db->where('lc.mobile>', '0');
		$this->db->where('icd.renew_flag', '1');
		$this->db->order_by('icd.last_updated_date', 'DESC');
		$query = $this->db->get();
		$data =  $query->row_array();
		// echo $this->db->last_query();die;
		return $data;
	}
	public function getODAMountTrend($empId = "")
	{
		$where['0'] = "MONTH(cd.current_issue_date) =" . date('m') . " and YEAR(cd.current_issue_date) =" . date('Y');
		$months = array();
		$months[] = date('M');
		for ($i = 1; $i < 6; $i++) {
			$months[$i] = date("M", strtotime(date('Y-m-01') . " -$i months"));
			$year = date("Y", strtotime(date('Y-m-01') . " -$i months"));
			$month = date("m", strtotime(date('Y-m-01') . " -$i months"));
			$where[$i] = "MONTH(cd.current_issue_date) =" . $month . " and YEAR(cd.current_issue_date) =" . $year;
		}
		$this->db->select("sum(DISTINCT(CASE WHEN ($where[5]) THEN iq.own_damage ELSE null END)) as count1,
                sum(DISTINCT(CASE WHEN ($where[4]) THEN iq.own_damage ELSE null END)) as count2,
                sum(DISTINCT(CASE WHEN ($where[3]) THEN iq.own_damage ELSE null END)) as count3,
                sum(DISTINCT(CASE WHEN ($where[2]) THEN iq.own_damage ELSE null END)) as count4,
                sum(DISTINCT(CASE WHEN ($where[1]) THEN iq.own_damage ELSE null END)) as count5,
                sum(DISTINCT(CASE WHEN ($where[0]) THEN iq.own_damage ELSE null END)) as count6");
		$this->db->from('crm_insurance_case_details as icd');
		$this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id', 'inner');
		$this->db->join('crm_customers as lc', 'lc.id=cd.crm_customer_id and lc.mobile> 0', 'inner');
		$this->db->join('crm_prev_policy_insurer as pp', 'pp.prev_policy_insurer_slug=cd.current_insurance_company', 'left');
		$this->db->join('crm_insurance_quotes as iq', 'iq.case_id=icd.id and iq.flag="1"', 'left');
		$this->db->where('icd.renew_flag', '0');
		$this->db->where("cd.current_policy_no != '0'");
		$this->db->where("cd.current_policy_no is not null");
		$this->db->where("cd.current_policy_no !=''");
		$this->db->where_in("icd.last_updated_status", array(6, 9));
		if ($empId != '') {
			$this->db->where('icd.assign_to', $empId);
		}
		$this->db->order_by('icd.last_updated_date', 'DESC');
		$query = $this->db->get();
		$results =  $query->row_array();
		$leads['counts'] = array();
		foreach ($results as $counts) {
			$leads['counts'][] = !empty($counts) ? $counts : "0";
		}
		$leads['months'] =  array_reverse($months);
		return $leads;
	}

	public function getCaseWiseTrend($empId = "")
	{
		$where['0'] = "MONTH(icd.created_date) =" . date('m') . " and YEAR(icd.created_date) =" . date('Y');
		$where_quote[0] = "MONTH(icd.quote_add_date) =" . date('m') . " and YEAR(icd.quote_add_date) =" . date('Y');
		$where_issued[0] = "MONTH(cd.current_issue_date) =" . date('m') . " and YEAR(cd.current_issue_date) =" . date('Y');
		$months = array();
		$months[] = date('M');
		for ($i = 1; $i < 6; $i++) {
			$months[$i] = date("M", strtotime(date('Y-m-01') . " -$i months"));
			$year = date("Y", strtotime(date('Y-m-01') . " -$i months"));
			$month = date("m", strtotime(date('Y-m-01') . " -$i months"));
			$where[$i] = "MONTH(icd.created_date) =" . $month . " and YEAR(icd.created_date) =" . $year;
			$where_quote[$i] = "MONTH(icd.quote_add_date) =" . $month . " and YEAR(icd.quote_add_date) =" . $year;
			$where_issued[$i] = "MONTH(cd.current_issue_date) =" . $month . " and YEAR(cd.current_issue_date) =" . $year;
		}
		$issued_condition = "icd.last_updated_status IN(6,9) AND cd.current_policy_no != '0' AND cd.current_policy_no is not null AND cd.current_policy_no !=''";
		$this->db->select("COUNT(distinct CASE WHEN $where[5] AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) new_cases1,
            COUNT(distinct CASE WHEN $where[4] AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) new_cases2,
            COUNT(distinct CASE WHEN $where[3] AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) new_cases3,
            COUNT(distinct CASE WHEN $where[2] AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) new_cases4,
            COUNT(distinct CASE WHEN $where[1] AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) new_cases5,
            COUNT(distinct CASE WHEN $where[0] AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) new_cases6,
            COUNT(distinct CASE WHEN $where_quote[5] AND icd.last_updated_status IN ( 2, 3, 4, 5, 6, 9 ) AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) quote_shared1,
            COUNT(distinct CASE WHEN $where_quote[4] AND icd.last_updated_status IN ( 2, 3, 4, 5, 6, 9 ) AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) quote_shared2,
            COUNT(distinct CASE WHEN $where_quote[3] AND icd.last_updated_status IN ( 2, 3, 4, 5, 6, 9 ) AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) quote_shared3,
            COUNT(distinct CASE WHEN $where_quote[2] AND icd.last_updated_status IN ( 2, 3, 4, 5, 6, 9 ) AND  `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) quote_shared4,
            COUNT(distinct CASE WHEN $where_quote[1] AND icd.last_updated_status IN ( 2, 3, 4, 5, 6, 9 ) AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) quote_shared5,
            COUNT(distinct CASE WHEN $where_quote[0] AND icd.last_updated_status IN ( 2, 3, 4, 5, 6, 9 ) AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) quote_shared6,
            COUNT(distinct CASE WHEN $where_issued[5] AND $issued_condition AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) issued1,
            COUNT(distinct CASE WHEN $where_issued[4] AND $issued_condition AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) issued2,
            COUNT(distinct CASE WHEN $where_issued[3] AND $issued_condition AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) issued3,
            COUNT(distinct CASE WHEN $where_issued[2] AND $issued_condition AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) issued4,
            COUNT(distinct CASE WHEN $where_issued[1] AND $issued_condition AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) issued5,
            COUNT(distinct CASE WHEN $where_issued[0] AND $issued_condition AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) issued6");
		$this->db->from('crm_insurance_case_details as icd');
		$this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id', 'inner');
		$this->db->join('crm_customers as cc', 'cc.id=cd.crm_customer_id', 'inner');
		$this->db->join('crm_insurance_update_status as us', 'us.statusId=icd.last_updated_status', 'left');
		$this->db->where('cc.mobile>', '0');
		if ($empId != '') {
			$this->db->where('icd.assign_to', $empId);
		}
		$query = $this->db->get();
		$result = $query->row_array();
		// echo "<pre>";print_r($result);die;
		$i = $j = 1;
		foreach ($result as $key => $counts) {
			if ($key == 'new_cases' . $i) {
				$leads['new_case']['counts'][] = $counts;
			} else if ($key == 'issued' . $j) {
				$leads['issued']['counts'][] = $counts;
				$j++;
			} else {
				$leads['quote_shared']['counts'][] = $counts;
			}
			$i++;
		}
		$leads['months'] = array_reverse($months);
		return $leads;
	}
	public function getInProgressCount($empId = '')
	{
		$this->db->select('COUNT(distinct CASE WHEN lcc.loan_approval_status IN(1,2,3,4,5,7,8,10) THEN lcc.id ELSE null END ) active_cases,COUNT(distinct CASE WHEN lcc.loan_approval_status IN(10,7) THEN lcc.id ELSE null END )awaiting_login,COUNT(distinct CASE WHEN lmt.id IN(1) and lcc.loan_approval_status In (1) THEN lcc.id ELSE null END )awaiting_decision,COUNT(distinct CASE WHEN lmt.id IN(2) and lcc.loan_approval_status in(2) THEN lcc.id ELSE null END ) awaiting_disbursal');
		$this->db->from('loan_customer_info as lci');
		$this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id', 'left');
		$this->db->join('loan_file_login_mapping as lem', 'lcc.customer_loan_id=lem.case_id and lem.status="1"', 'left');
		$this->db->join('loan_file_login_tags as lmt', 'lem.tag_flag=lmt.id', 'left');
		$this->db->where('lcc.customer_loan_id>"1"');
		if ($empId != '') {
			$this->db->where('lci.assign_case_to', $empId);
		}
		$query = $this->db->get();
		$result = $query->row_array();
		return  $result;
	}
	public function getLoanCaseWiseCount($empId = "")
	{
		$start = date("Y-m-d", strtotime(date('Y-m-01') . " -5 months"));
		$end = date("Y-m-d");
		$where = "DATE(lcc.created_date)  >='" . $start . "' and DATE(lcc.created_date) <='" . $end . "'";
		$where_file = "DATE(lem.file_login_date)  >='" . $start . "' and DATE(lem.file_login_date) <='" . $end . "'";
		$where_approved = "DATE(lem.approved_date)  >='" . $start . "' and DATE(lem.approved_date) <='" . $end . "'";
		$where_disbursed = "DATE(lem.disbursed_date)  >='" . $start . "' and DATE(lem.disbursed_date) <='" . $end . "'";

		$this->db->select("COUNT(distinct CASE WHEN lcc.customer_loan_id > '1' AND $where THEN lcc.id ELSE null END ) new_cases, COUNT(distinct CASE WHEN (lcc.loan_approval_status Not IN (3,5,6,7,10,9 ) AND $where_file) THEN lcc.id ELSE null END ) filed, COUNT(distinct CASE WHEN lcc.loan_approval_status Not IN (1,3,5,6,7,10,9) AND $where_approved THEN lcc.id ELSE null END ) approved, COUNT(distinct CASE WHEN lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 ) AND $where_disbursed THEN lcc.id ELSE null END ) disbursed");
		$this->db->from('loan_customer_info as lci');
		$this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id', 'inner');
		$this->db->join('loan_file_login_mapping as lem', 'lcc.customer_loan_id=lem.case_id and lem.status="1" AND (lem.tag_flag=lcc.loan_approval_status OR lcc.loan_approval_status > 4)', 'left');
		$this->db->where('lcc.customer_loan_id>"1"');
		if ($empId != '') {
			$this->db->where('lci.assign_case_to', $empId);
		}
		$query = $this->db->get();
		$result = $query->row_array();
		foreach (LOAN_CASES_FUNNEL as $k => $case) {
			$response[] = "['$case', $result[$k]]";
		}
		return  $response;
	}
	public function getLoanPendingCaseCount($empId = "")
	{
		$this->db->select("COUNT(distinct CASE WHEN (lcc.loan_approval_status IN (4,8)) THEN lcc.id ELSE null END ) loan_payment, COUNT(distinct CASE WHEN lcc.loan_approval_status Not IN ('11,3,6,9') AND (lcc.upload_login_doc_flag != '1' || lcc.upload_dis_doc_flag != '1' || (lcc.upload_post_doc_flag != '1' && lcc.loan_for = 2)) THEN lcc.id ELSE null END ) document_upload");
		$this->db->from('loan_customer_info as lci');
		$this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id', 'inner');
		$this->db->where('lcc.customer_loan_id>"1"');
		if ($empId != '') {
			$this->db->where('lci.assign_case_to', $empId);
		}
		$query = $this->db->get();
		$result = $query->row_array();
		//echo $this->db->last_query();die;
		return  $result;
	}
	public function getLoanPayoutCaseCount($empId = "")
	{
		$this->db->select("COUNT(distinct CASE WHEN cpm.payout_id is null THEN lcc.id ELSE null END ) payout_case");
		$this->db->from('loan_customer_info as lci');
		$this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id', 'inner');
		$this->db->join('loan_file_login_mapping as lem', 'lcc.customer_loan_id=lem.case_id and lem.status="1"', 'left');
		$this->db->join('crm_case_payout_mapping as cpm', 'cpm.case_id=lcc.customer_loan_id AND cpm.status=1', 'left');
		$this->db->where('lcc.customer_loan_id>"1"');
		$this->db->where('lem.tag_flag', '4');
		$this->db->where('lcc.loan_approval_status not in (9,6)');
		$this->db->where('lci.source_type', 1);
		if ($empId != '') {
			$this->db->where('lci.assign_case_to', $empId);
		}
		$query = $this->db->get();
		$result = $query->row_array();
		return  $result;
	}
	public function getLoanCaseWiseTrend($empId = "")
	{
		$where['0'] = "MONTH(lcc.created_date) =" . date('m') . " and YEAR(lcc.created_date) =" . date('Y');
		$where_file['0'] = "MONTH(lem.file_login_date) =" . date('m') . " and YEAR( lem.file_login_date) =" . date('Y');
		$where_approved['0'] = "MONTH(lem.approved_date) =" . date('m') . " and YEAR(lem.approved_date) =" . date('Y');
		$where_disbursed["0"] = "MONTH(lem.disbursed_date) =" . date('m') . " and YEAR(lem.disbursed_date) =" . date('Y');
		$months = array();
		$months[] = date('M');
		for ($i = 1; $i < 6; $i++) {
			$months[$i] = date("M", strtotime(date('Y-m-01') . " -$i months"));
			$year = date("Y", strtotime(date('Y-m-01') . " -$i months"));
			$month = date("m", strtotime(date('Y-m-01') . " -$i months"));
			$where[$i] = "MONTH(lcc.created_date) =" . $month . " and YEAR(lcc.created_date) =" . $year;
			$where_file[$i] = "MONTH(lem.file_login_date) =" . $month . " and YEAR(lem.file_login_date) =" . $year;
			$where_approved[$i] = "MONTH(lem.approved_date) =" . $month . " and YEAR(lem.approved_date) =" . $year;
			$where_disbursed[$i] = "MONTH(lem.disbursed_date) =" . $month . " and YEAR(lem.disbursed_date) =" . $year;
		}
		$this->db->select("COUNT(distinct CASE WHEN $where[5] AND lcc.customer_loan_id > '1' THEN lcc.id ELSE null END ) new_cases1,
            COUNT(distinct CASE WHEN $where[4] AND lcc.customer_loan_id > '1' THEN lcc.id ELSE null END ) new_cases2,
            COUNT(distinct CASE WHEN $where[3] AND lcc.customer_loan_id > '1'THEN lcc.id ELSE null END ) new_cases3,
            COUNT(distinct CASE WHEN $where[2] AND lcc.customer_loan_id > '1'THEN lcc.id ELSE null END ) new_cases4,
            COUNT(distinct CASE WHEN $where[1] AND lcc.customer_loan_id > '1'THEN lcc.id ELSE null END ) new_cases5,
            COUNT(distinct CASE WHEN $where[0] AND lcc.customer_loan_id > '1'THEN lcc.id ELSE null END ) new_cases6,
            COUNT(distinct CASE WHEN $where_file[5] AND lcc.loan_approval_status Not IN (3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) filed1,
            COUNT(distinct CASE WHEN $where_file[4] AND lcc.loan_approval_status Not IN (3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) filed2,
            COUNT(distinct CASE WHEN $where_file[3] AND lcc.loan_approval_status Not IN (3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) filed3,
            COUNT(distinct CASE WHEN $where_file[2] AND lcc.loan_approval_status Not IN (3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) filed4,
            COUNT(distinct CASE WHEN $where_file[1] AND lcc.loan_approval_status Not IN (3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) filed5,
            COUNT(distinct CASE WHEN $where_file[0] AND lcc.loan_approval_status Not IN (3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) filed6,
            COUNT(distinct CASE WHEN $where_approved[5] AND lcc.loan_approval_status Not IN (1,3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) approved1,
            COUNT(distinct CASE WHEN $where_approved[4] AND lcc.loan_approval_status Not IN (1,3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) approved2,
            COUNT(distinct CASE WHEN $where_approved[3] AND lcc.loan_approval_status Not IN (1,3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) approved3,
            COUNT(distinct CASE WHEN $where_approved[2] AND lcc.loan_approval_status Not IN (1,3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) approved4,
            COUNT(distinct CASE WHEN $where_approved[1] AND lcc.loan_approval_status Not IN (1,3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) approved5,
            COUNT(distinct CASE WHEN $where_approved[0] AND lcc.loan_approval_status Not IN (1,3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) approved6,
            COUNT(distinct CASE WHEN $where_disbursed[5] AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) disbursed1,
            COUNT(distinct CASE WHEN $where_disbursed[4] AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) disbursed2,
            COUNT(distinct CASE WHEN $where_disbursed[3] AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) disbursed3,
            COUNT(distinct CASE WHEN $where_disbursed[2] AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) disbursed4,
            COUNT(distinct CASE WHEN $where_disbursed[1] AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) disbursed5,
            COUNT(distinct CASE WHEN $where_disbursed[0] AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 ) THEN lcc.id ELSE null END ) disbursed6");
		$this->db->from('loan_customer_info as lci');
		$this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id', 'inner');
		$this->db->join('loan_file_login_mapping as lem', 'lcc.customer_loan_id=lem.case_id and lem.status="1" AND (lem.tag_flag=lcc.loan_approval_status OR lcc.loan_approval_status > 4)', 'left');
		$this->db->where('lcc.customer_loan_id>"1"');
		if ($empId != '') {
			$this->db->where('lci.assign_case_to', $empId);
		}
		$query = $this->db->get();
		$result = $query->row_array();
		$i = $j = $k = 1;
		foreach ($result as $key => $counts) {
			if ($key == 'new_cases' . $i) {
				$leads['new_case']['counts'][] = $counts;
			} else if ($key == 'filed' . $j) {
				$leads['filed']['counts'][] = $counts;
				$j++;
			} else if ($key == 'approved' . $k) {
				$leads['approved']['counts'][] = $counts;
				$k++;
			} else {
				$leads['disbursed']['counts'][] = $counts;
			}
			$i++;
		}
		$leads['months'] = array_reverse($months);
		return $leads;
	}

	public function getDisbursedAMountTrend($empId = "")
	{
		$where['0'] = "MONTH(lem.disbursed_date) =" . date('m') . " and YEAR(lem.disbursed_date) =" . date('Y');
		$months = array();
		$months[] = date('M');
		for ($i = 1; $i < 6; $i++) {
			$months[$i] = date("M", strtotime(date('Y-m-01') . " -$i months"));
			$year = date("Y", strtotime(date('Y-m-01') . " -$i months"));
			$month = date("m", strtotime(date('Y-m-01') . " -$i months"));
			$where[$i] = "MONTH(lem.disbursed_date) =" . $month . " and YEAR(lem.disbursed_date) =" . $year;
		}
		$this->db->select("sum(DISTINCT(CASE WHEN ($where[5] AND loan_for = 1 AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 )) THEN lem.gross_net_amount ELSE null END)) as new_count1,
                sum(DISTINCT(CASE WHEN ($where[4] AND loan_for = 1 AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 )) THEN lem.gross_net_amount ELSE null END)) as new_count2,
                sum(DISTINCT(CASE WHEN ($where[3] AND loan_for = 1 AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 )) THEN lem.gross_net_amount ELSE null END)) as new_count3,
                sum(DISTINCT(CASE WHEN ($where[2] AND loan_for = 1 AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 )) THEN lem.gross_net_amount ELSE null END)) as new_count4,
                sum(DISTINCT(CASE WHEN ($where[1] AND loan_for = 1 AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 )) THEN lem.gross_net_amount ELSE null END)) as new_count5,
                sum(DISTINCT(CASE WHEN ($where[0] AND loan_for = 1 AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 )) THEN lem.gross_net_amount ELSE null END)) as new_count6,
                sum(DISTINCT(CASE WHEN ($where[5] AND loan_for = 2 AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 )) THEN lem.gross_net_amount ELSE null END)) as used_count1,
                sum(DISTINCT(CASE WHEN ($where[4] AND loan_for = 2 AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 )) THEN lem.gross_net_amount ELSE null END)) as used_count2,
                sum(DISTINCT(CASE WHEN ($where[3] AND loan_for = 2 AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 )) THEN lem.gross_net_amount ELSE null END)) as used_count3,
                sum(DISTINCT(CASE WHEN ($where[2] AND loan_for = 2 AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 )) THEN lem.gross_net_amount ELSE null END)) as used_count4,
                sum(DISTINCT(CASE WHEN ($where[1] AND loan_for = 2 AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 )) THEN lem.gross_net_amount ELSE null END)) as used_count5,
                sum(DISTINCT(CASE WHEN ($where[0] AND loan_for = 2 AND lcc.loan_approval_status Not IN (1,2,3,5,6,7,10,9 )) THEN lem.gross_net_amount ELSE null END)) as used_count6");
		$this->db->from('loan_customer_info as lci');
		$this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id', 'inner');
		$this->db->join('loan_file_login_mapping as lem', 'lcc.customer_loan_id=lem.case_id and lem.status="1" AND (lem.tag_flag=lcc.loan_approval_status OR lcc.loan_approval_status > 4)', 'left');
		$this->db->where('lcc.customer_loan_id>"1"');
		if ($empId != '') {
			$this->db->where('lci.assign_case_to', $empId);
		}
		$query = $this->db->get();
		$results =  $query->row_array();
		$i = 1;
		foreach ($results as $key => $counts) {
			if ($key == 'new_count' . $i) {
				$leads['average'][$i] = $results['new_count' . $i] + $results['used_count' . $i];
				$leads['new']['counts'][] = !empty($counts) ? $counts : "0";
			} else {
				$leads['used']['counts'][] = !empty($counts) ? $counts : "0";
			}
			$i++;
		}
		$leads['months'] =  array_reverse($months);
		// echo "<pre>";print_r($leads);die;
		return $leads;
	}

	public function getPermissions($type)
	{
		$this->db->select('cd.card_id');
		$this->db->from('crm_dashboard as cd');
		$this->db->where('cd.module_id', $type);
		$this->db->where('cd.role_id', $this->session->userdata['userinfo']['role_id']);
		$this->db->where('cd.team_id', $this->session->userdata['userinfo']['team_id']);
		$this->db->where('cd.status', '1');
		$query = $this->db->get();
		$result = $query->result_array();
		$response = array();
		foreach ($result as $res) {
			$response[] =  $res['card_id'];
		}
		return $response;
	}
	public function getDoCount($empId = '')
	{
		/*$this->db->select("COUNT(distinct CASE WHEN (fd.loan_taken_from='1' and fd.loan_filled='2' and fd.application_no='') THEN fd.id ELSE null END ) loan_pending,COUNT(distinct CASE WHEN (fd.last_updated_status='1') THEN fd.id ELSE null END ) payment_pending"); */
		$this->db->select("COUNT(distinct CASE WHEN (fd.loan_taken='1' and fd.loan_taken_from='1' and fd.loan_filled='2'  and fd.application_no='') THEN fd.id ELSE null END ) loan_pending,COUNT(distinct CASE WHEN (fd.do_updated_status='1') THEN fd.id ELSE null END ) payment_pending");

		$this->db->from('crm_finance_delivery as fd');
		$this->db->where('fd.status', '1');
		$this->db->where('fd.cancel_id', 0);
		if ($empId != '') {
			$this->db->where('fd.deliverySales', $empId);
		}
		$query = $this->db->get();
		$result = $query->result_array();
		return  $result;
	}



	public function getDoCaseWiseTrend()
	{
		$dataArray = array();
		for ($i = 0; $i < 6; $i++) {
			$months[$i] = date("M", strtotime(date('Y-m-01') . " -$i months"));
			$year   = date("Y", strtotime(date('Y-m-01') . " -$i months"));
			$month  = date("m", strtotime(date('Y-m-01') . " -$i months"));
			$where = " MONTH(do_date) =" . $month . " and YEAR(do_date) =" . $year;
			$this->db->select("COUNT(id) as totallead");
			$this->db->from('crm_finance_delivery');
			$this->db->where($where);
			$this->db->where('cancel_id', 0);
			$this->db->where('status', '1');
			$query = $this->db->get();
			$result = $query->row_array();
			$dataArray[$i] = $result['totallead'];
		}

		$doCasedata['new_case']['counts'] = array_reverse($dataArray);
		$doCasedata['months'] = array_reverse($months);
		return $doCasedata;
	}

	public function getDoBalance()
	{
		$this->db->select('id,customer_balance,showroom_balance');
		$this->db->from('crm_finance_delivery');
		$this->db->where('cancel_id', 0);
		$this->db->where('status', '1');
		/*$this->db->where('customer_balance!=','');
        $this->db->where('customer_balance!=',0);
        $this->db->or_where('showroom_balance!=','');
        $this->db->where('showroom_balance!=',0);*/
		$query  = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function getRCPending($empId)
	{
		$this->db->select("COUNT(distinct CASE WHEN irc.rc_status IN('1') THEN irc.id ELSE null END ) pending_rc_cases, COUNT(distinct CASE WHEN irc.rc_status IN('2') THEN irc.id ELSE null END ) in_progress_rc");
		$this->db->from('crm_rc_listing as rc');
		$this->db->join('crm_rc_info as irc', 'irc.rc_id=rc.id', 'inner');
		//$this->db->where('cd.status', '1');
		if ($empId != '') {
			$this->db->where('irc.rto_agent', $empId);
		}
		$query = $this->db->get();
		$result = $query->row_array();
		return  $result;
	}
	public function getRCDelay($empId)
	{
		$new_date = date("Y-m-d", strtotime(date('Y-m-d') . " -15 days"));
		$this->db->select("COUNT(distinct CASE WHEN irc.rc_status IN('1') AND Date(irc.created_date) < '" . $new_date . "' THEN irc.id ELSE null END ) pending_rc_cases, COUNT(distinct CASE WHEN irc.rc_status IN('2') AND Date(created_date) < '" . $new_date . "' THEN irc.id ELSE null END ) in_progress_rc");
		$this->db->from('crm_rc_listing as rc');
		$this->db->join('crm_rc_info as irc', 'irc.rc_id=rc.id', 'inner');
		//$this->db->where('cd.status', '1');
		if ($empId != '') {
			$this->db->where('irc.rto_agent', $empId);
		}
		$query = $this->db->get();
		$result = $query->row_array();
		return  $result;
	}
	public function getTotalBankLimit($emp_id = '')
	{
		$col = 'b.amount_limit,bl.bank_name,bl.id as bank_id';
		if (!empty($emp_id)) {
			$col = 'b.amount_limit as bank_limit,bl.bank_name,bl.id as bank_id,em.emp_limit as amount_limit, em.emp_id';
		}
		$this->db->select($col);
		$this->db->from('crm_banks as b');
		$this->db->join('crm_bank_list as bl', 'bl.id=b.bank_id', 'inner');
		if (!empty($emp_id)) {
			$this->db->join('bank_employee_limit_mapping as em', 'bl.id=em.bank_id', 'inner');
			$this->db->where('em.status', '1');
			$this->db->where('em.emp_id', $emp_id);
		}
		$this->db->where('bl.status', '1');
		$this->db->where('b.status', '1');
		$query = $this->db->get();
		$result = $query->result_array();
		$respons = array();
		foreach ($result as $key => $value) {
			$respons['bank_name'][] = $value['bank_name'];
			$respons['amount_limit'][$i] = $value['amount_limit'];
			$respons['usedAmount'][] = $this->Loan_customer_info->getUsedAmount($value['bank_id']);
			$respons['leftAmount'][] = (int)$respons['amount_limit'][$i] - (int)(!empty($respons['usedAmount'][$i]) ? $respons['usedAmount'][$i] : 0);
			$i++;
		}
		return $respons;
	}
	public function getAllowedModule()
	{
		$team  = $this->session->userdata['userinfo']['team_id'];
		$this->db->select("hr.parent_module_id, hrm.team_id");
		$this->db->from('crm_header_role as hr');
		$this->db->join('crm_header_role_mapping as hrm', 'hr.id=hrm.menu_id', 'inner');
		if ($this->session->userdata['userinfo']['dealer_id'] == 49) {
			$this->db->where('hr.parent_module_id in ( 1, 2, 6, 10 )');
		} else {
			$this->db->where('hr.parent_module_id in ( 1, 2, 4, 5, 6, 10 )');
		}
		$this->db->where('hr.parent_id', '0');
		$this->db->where('hrm.team_id', $team);
		$this->db->where('hrm.role_id', $this->session->userdata['userinfo']['role_id']);
		$this->db->where('hrm.status', '1');
		$this->db->group_by('hr.parent_module_id');
		$query = $this->db->get();
		// echo $this->db->last_query();
		$result = $query->result_array();
		foreach ($result as $mod) {
			$allowed_module[] = $mod['parent_module_id'];
		}
		return $allowed_module;
	}
}
