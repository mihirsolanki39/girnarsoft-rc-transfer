<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * model : Loan_customer_case
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
class Loan_customer_case extends CI_Model
{

	public function saveUpdateCaseInfo($caseInfo, $updateId = '', $flag = "")
	{
		if (empty($updateId)) {
			$caseInfo['created_date'] = date('Y-m-d H:i:s');
			$this->db->trans_start();
			$this->db->insert('loan_customer_case', $caseInfo);
			$insert_id = $this->db->insert_id();
			$this->db->trans_complete();
			$result = $insert_id;
		} else {
			if ($flag == '1') {
				$this->db->where('customer_loan_id', $updateId);
			} else {
				$this->db->where('id', $updateId);
			}
			$this->db->update('loan_customer_case', $caseInfo);
			$result = $updateId;
		}
		//echo $this->db->last_query(); exit;
		return $result;
	}


	public function getCaseId($customer_id)
	{
		$this->db->select('id,customer_loan_id,loan_approval_status');
		$this->db->from('loan_customer_case');
		$this->db->where('customer_loan_id', $customer_id);
		$query = $this->db->get();
		$result = $query->result_array();
		return  $result;
	}

	public function saveCaseFileLogin($caseInfo, $updateId = '')
	{
		if (empty($updateId)) {
			$this->db->insert('loan_file_login_mapping', $caseInfo);
			$insert_id = $this->db->insert_id();
			$result = $insert_id;
		} else {
			$this->db->where('id', $updateId);
			$this->db->update('loan_file_login_mapping', $caseInfo);
			$result = $updateId;
		}
		//echo $this->db->last_query(); exit; 
		return $result;
	}

	public function getCaseIdFromFile($id)
	{
		$this->db->select('*');
		$this->db->from('loan_file_login_mapping');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$result = $query->result_array();
		return  $result;
	}

	public function selectLoanPartpayment($id = '', $type = '', $flag = '', $casesId = '', $flg = '')
	{
		$this->db->select('*');
		$this->db->from('crm_loan_part_payment');
		if ((!empty($id)) && (empty($flag))) {
			$this->db->where('id', $id);
		}
		if ((!empty($id)) && (!empty($flag))) {
			$this->db->where('id not in (' . $id . ')');
		}
		if (!empty($type))
			$this->db->where('entry_type', $type);
		if ($casesId != '') {
			$this->db->where('case_id ', $casesId);
		}
		if (!empty($flg)) {
			$this->db->order_by("id", "desc");
			$this->db->limit('1', '0');
		}
		$query = $this->db->get();
		$result = $query->result_array();
		return  $result;
	}

	public function addLoanPartpayment($caseInfo, $updateId = '')
	{
		if (empty($updateId)) {
			$this->db->insert('crm_loan_part_payment', $caseInfo);
			$insert_id = $this->db->insert_id();
			$result = $insert_id;
		} else {
			$this->db->where('id', $updateId);
			$this->db->update('crm_loan_part_payment', $caseInfo);
			$result = $updateId;
		}
		//echo $this->db->last_query(); exit; 
		return $result;
	}

	public function getLoanInfoByCustomerId($case_id, $file_tag = 0, $limit = '', $disFlag = 0, $flag = 0, $sms = 0)
	{
		$sc = '';
		if ($sms == 1) {
			$sc = ',cs.bank_id as sms_bank,cs.sms_send_for';
		}
		$this->db->select('lm.*,lt.file_tag,c.logo as financer_logo,c.bank_name' . $sc);
		$this->db->from('loan_file_login_mapping as lm');
		$this->db->join('loan_file_login_tags as lt', 'lt.id=lm.tag_flag', 'left');
		$this->db->join('crm_bank_list as c', 'c.id=lm.bank_id', 'left');
		if ($sms == 1) {
			$this->db->join('crm_loan_sms_log as cs', 'cs.case_id=lm.case_id', 'left');
			$this->db->where_in('cs.sms_send_for', array('1', '6'));
		}
		$this->db->where('lm.case_id', $case_id);
		$this->db->where('lm.status', '1');
		$this->db->where('lt.show_id', '1');
		if ($flag == 0) {
			if ($file_tag > 0) {
				$file_tag = array('2', '4');
				$this->db->where_in('lm.tag_flag', $file_tag);
			}
			if ($limit > 0) {
				$this->db->limit(1);
			}
			if ($disFlag > 0) {
				$this->db->where('lm.valuation_status>', '0');
				$this->db->where_not_in('lm.cpv_status', array('0', '2'));
			}
		}
		if ($flag == '1') {
			if ($file_tag == '4') {
				$file_tag = array('4');
				$this->db->where_in('lm.tag_flag', $file_tag);
			}
		}
		$query = $this->db->get();
		$result = $query->result_array();
		// echo $this->db->last_query(); exit;
		return  $result;
	}

	public function deleteCaseFileLogin($case_id)
	{
		$this->db->where('id', $case_id);
		$this->db->update('loan_file_login_mapping', array('status' => '0', 'tag_flag' => '0'));
		return  $case_id;
	}

	public function checkIfExists($bank_id = '', $case_id = '', $id = '', $ids = [])
	{
		$this->db->select('*');
		$this->db->from('loan_file_login_mapping');
		if (!empty($bank_id)) {
			$this->db->where('bank_id', $bank_id);
		}
		if (!empty($case_id)) {
			$this->db->where('case_id', $case_id);
		}
		if (!empty($id)) {
			$this->db->where('id', $id);
		}
		$this->db->where('status', '1');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	public function getRejectList($parent_id = '', $id = "", $flag = '')
	{
		if ($parent_id > 0) {
			$this->db->where(array('parent_id' => $parent_id, 'status' => '1'));
		} else if ((empty($parent_id)) && (empty($flag))) {
			$this->db->where(array('status' => '1', 'parent_id' => '0'));
		}
		if (!empty($id)) {
			$this->db->where(array('status' => '1', 'id' => $id));
		}
		$this->db->from('loan_reject_type_reason');
		$query  = $this->db->get();
		$result = $query->result_array();
		// echo $this->db->last_query(); exit;
		return $result;
	}

	public function addLoanHistory($data)
	{
		$this->db->insert('loan_history_log', $data);
		$insert_id = $this->db->insert_id();
		return $result = $insert_id;
	}

	public function getLoanHistory($caseId)
	{
		$this->db->where(array('status' => '1', 'case_id' => $caseId, 'action' => 'Add'));
		$this->db->from('loan_history_log');
		$this->db->order_by('id', 'desc');
		$query  = $this->db->get();
		$result = $query->result_array();
		return $result;
	}


	public function addLoanHistoryUpdateLog($data)
	{
		$this->db->insert('loan_history_update_log', $data);
		$insert_id = $this->db->insert_id();
		return $result = $insert_id;
	}


	public function getLoanInfoById($id)
	{
		$this->db->select('lm.*,lt.file_tag');
		$this->db->from('loan_file_login_mapping as lm');
		$this->db->join('loan_file_login_tags as lt', 'lt.id=lm.tag_flag', 'left');
		$this->db->where('lm.id', $id);
		$query = $this->db->get();
		$result = $query->result_array();
		// echo $this->db->last_query(); exit;
		return  $result;
	}

	public function loanAmountHistoryLog($prev, $new, $case_id)
	{
		$data = [];
		$data['previous_data'] = serialize($prev);
		$data['new_data'] = serialize($new);
		$data['case_id'] = serialize($case_id);
		$this->db->insert('loan_amount_update_log', $data);
		$insert_id = $this->db->insert_id();
		return $result = $insert_id;
	}

	public function checkLoanAmount($emp_id, $bank_id)
	{
		$this->db->where(array('ebm.bank_id' => $bank_id, 'ebm.emp_id' => $emp_id, 'ebm.status' => '1'));
		$this->db->from('bank_employee_limit_mapping as ebm');
		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query();die;
		return $result;
	}

	public function getCaseInfoByCaseId($case_id, $flag = "")
	{

		$this->db->select('lci.*,lcc.*,lcc.id as loan_srno,ca.customer_id as cust_id,mv.db_version as version_name,mm.make as make_name,mm.model as model_name,ca.employment_type,ca.employer_name,ca.employee_doj,ca.totalexp,ca.gross_mon_income,

        ca.is_notice_period,ca.bus_applicant_type,ca.bus_industry_type,ca.bus_business_name,ca.bus_off_set_up,
        ca.bus_start_business_mon,ca.bus_start_business_year,ca.bus_itr_income1,ca.bus_itr_income2,ca.pro_off_set_up,
        ca.pro_itr_income1,ca.pro_itr_income2,ca.pro_industry_type,ca.pro_start_date_mon,ca.pro_start_date_year,
        ca.oth_type,ca.oth_customer_own,ca.oth_customer_taken_loan,ca.created_on,lem.file_loan_amount as loan_amt,lem.file_roi as roi,lem.file_tenure as tenor,lem.bank_id as financer,c.bank_name as financer_name,ref.ref_name_one as ref_name_one,lem.tag_flag,lem.valuation_status as valuationstatus,lem.cpv_status as cpvstatus,lmt.file_tag,postdel.invoice_no,postdel.rc_engine_no,paydel.instrument_type,bnkinfor.id as cust_bnk_id,bnkinfor.bank_id as custbank,bnkinfor.bank_branch as custbranch,bnkinfor.account_no as custacc,bnkinfor.ifci_code  as custifci,bnkinfor.account_type as account_type,bnkinfor.case_id,
        bnkinfor.bank_id_two as custbanktwo,bnkinfor.bank_branch_two as custbranchtwo,bnkinfor.account_no_two as custacctwo,bnkinfor.ifci_code_two  as custifcitwo,bnkinfor.account_type_two as account_type_two,bnkinfor.case_id,
       cdd.loan_amount, cdd.gps_disburse,cdd.gross_loan,cdd.extend_warranty,cdd.counter_emi,cdd.total_emi,cdd.disburse_emi,cdd.existing_loan,cdd.existing_account_no  ,cdd.loan_short,cdd.first_emi,cdd.remark as remark ,cdd.loan_disburse,cdd.motor_disburse,cdd.fee_disburse ,cdd.payout,cdd.other_disburse,cdd.existing_disburse,cdd.  processing_disburse,cdd.rc_disburse,cdd.buyer_type as rc_by,cdd.total_amount,lem.ref_id,lem.approved_loan_amt,lem.approved_tenure,lem.approved_roi,lem.disbursed_amount,lem.disbursed_tenure,lem.disbursed_roi,lem.disbursed_date,rto.id as rto_id,rto.state as rto_state,rto.Registration_Index as reg_index,rto.Place_of_Registration as regplace,lem.id as fileLoginId,lem.gross_net_amount,ref.ref_address_one,ref.ref_phone_one,ref.ref_relationship_one,ref.ref_name_two,ref.ref_address_two,ref.ref_phone_two,ref. ref_relationship_two,lem.loanno,cdd.loan_credit_protect,cdd.health_insurance,lcdd.id as coapplicant_id,lgd.id as guarantor_id');

		$this->db->from('loan_customer_info as lci');
		$this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id', 'left');
		$this->db->join('loan_customer_academic as ca', 'ca.customer_info_id = lcc.customer_loan_id', 'left');
		$this->db->join('model_version as mv', 'lcc.versionId=mv.db_version_id', 'left');
		$this->db->join('make_model as mm', 'mv.model_id = mm.id', 'left');
		$this->db->join('loan_file_login_mapping as lem', 'lcc.customer_loan_id=lem.case_id and lem.status="1" and (lem.tag_flag=lcc.loan_approval_status OR lcc.loan_approval_status >= 4)', 'left');
		$this->db->join('loan_file_login_tags as lmt', 'lem.tag_flag=lmt.id', 'left');
		$this->db->join('crm_bank_list as c', 'lem.bank_id=c.id', 'left');
		$this->db->join('loan_customer_reference_info as ref', 'lcc.customer_loan_id = ref.customer_case_id', 'left');
		$this->db->join('loan_post_delivery_details as postdel', 'postdel.case_id = ref.customer_case_id', 'left');
		$this->db->join('loan_payment_details as paydel', 'paydel.case_id = ref.customer_case_id', 'left');
		$this->db->join('crm_customer_bank_info as bnkinfor', 'bnkinfor.case_id = lcc.customer_loan_id', 'left');
		$this->db->join('crm_disbursal_distribution as cdd', 'cdd.case_id = lcc.customer_loan_id', 'left');
		$this->db->join('rto_city as rto', 'rto.id = lcc.rto_id', 'left');

		$this->db->join('loan_coapplicant_detail as lcdd', 'lcdd.case_id = lcc.customer_loan_id', 'left');
		$this->db->join('loan_guarantor_detail as lgd', 'lgd.case_id = lcc.customer_loan_id', 'left');


		$this->db->where('lcc.customer_loan_id', $case_id);
		//  $this->db->where('lem.status','1');
		if ($flag >= '1') {
			$this->db->where('lem.id', $flag);
		}
		$this->db->order_by('lmt.priority', 'asc');

		$query = $this->db->get();
		//echo $this->db->last_query();die;
		$result = $query->result_array();
		//echo "<pre>";print_r($result);die;
		return  $result;
	}

	public function checkOverAllLimitByEmpId($empId, $bank_id)
	{
		$this->db->where('lci.assign_case_to', $empId);
		$this->db->from('loan_customer_info as lci');
		$this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id', 'left');
		$this->db->join('loan_customer_academic as ca', 'ca.customer_id = lci.customer_id', 'left');
		$this->db->join('model_version as mv', 'lcc.versionId=mv.db_version_id', 'left');
		$this->db->join('make_model as mm', 'mv.model_id = mm.id', 'left');
		$this->db->join('loan_file_login_mapping as lem', 'lcc.customer_loan_id=lem.case_id and lem.status="1"', 'left');
		$this->db->join('loan_file_login_tags as lmt', 'lem.tag_flag=lmt.id', 'left');
		$this->db->join('crm_bank_list as c', 'lem.bank_id=c.id', 'left');
		$query = $this->db->get();
		$result = $query->result_array();
		return  $result;
	}

	public function getcaseInfoByCustomerLoanId()
	{
		$query = $this->db->query('select loan_customer_case.customer_loan_id,temp.file_tag,temp.tag_flag from loan_customer_case inner join (
                          select loan_file_login_mapping.case_id,loan_file_login_mapping.tag_flag,loan_file_login_tags.* from loan_file_login_mapping
                          left join  loan_file_login_tags on loan_file_login_tags.id = loan_file_login_mapping.tag_flag
                          where priority = (select min(loan_file_login_tags.priority) from loan_file_login_mapping
                          left join  loan_file_login_tags on loan_file_login_tags.id = loan_file_login_mapping.tag_flag
                          )) temp on temp.case_id = loan_customer_case.customer_loan_id');
		$data = $query->result_array();
		$result = array();
		foreach ($data as $val) {
			$result[$val['customer_loan_id']] = array('file_tag' => $val['file_tag'], 'tag_flag' => $val['tag_flag']);
		}
		return $result;
	}

	public function getAllCaseInfo($params)
	{
		$rpp = 10;
		$perPageRecord = $rpp == 0 ? 10 : $rpp;
		$pageNo = (isset($params['page']) && $params['page'] != '') ? $params['page'] : '1';
		$startLimit = ($pageNo - 1) * $perPageRecord;
		if ($params['is_count'] == 0) {
			$this->db->select('lcc.reg_year,lcc.id as sr_no,lci.customer_id,lci.Buyer_Type,lci.name,lci.email,lcc.loan_type,'
				. 'lci.source_type,lci.dealer_id,lci.meet_the_customer,lci.dealt_by,lci.assign_case_to,lci.residence_address,'
				. 'lcc.customer_loan_id,lcc.loan_for,lcc.loan_type,lcc.loan_approval_status,lcc.makeId,lcc.modelId,lcc.versionId,'
				. 'lcc.regno,lcc.tag_status,lcc.created_date,lcc.updated_date,lcc.upload_login_doc_flag,lcc.upload_docs_created_at,'
				. 'lcc.upload_login_update_date,lcc.upload_dis_doc_flag,lcc.upload_dis_created_date,lcc.upload_disburse_doc_update,'
				. 'lcc.cancel_id,lcc.cancel_date,lcc.last_updated_date,lcc.reopen_date,ca.customer_id as cust_id,mv.db_version as version_name,'
				. 'mm.make as make_name,mm.model as model_name,lem.file_loan_amount as loan_amt,lem.file_roi as roi,lem.file_tenure as tenor,'
				. 'lem.bank_id as financer,c.bank_name as financer_name,ref.ref_name_one as ref_name_one,lem.tag_flag,lem.valuation_status as valuationstatus,'
				. 'lem.cpv_status as cpvstatus,lmt.file_tag,postdel.invoice_no,paydel.instrument_type,cblm.mobile as customer_mobile,'
				. 'cblm.created_date as customer_created_on,cl.city_name as customer_city,lmt.priority,lem.disbursed_amount,lem.disbursed_tenure,lem.disbursed_roi,'
				. 'lem.file_loan_amount,lem.file_tenure,lem.file_roi,lem.valuation_status,lem.cpv_status,lem.approved_loan_amt,lem.approved_tenure,lem.approved_roi,'
				. 'lem.approved_emi,lem.ref_id,lem.file_login_date,lem.approved_date,lem.rejected_date,lem.disbursed_date,cbin.bank_branch as bnkIf,lci.meet_the_customer,'
				. 'cusr.name as sales_exe,crmd.organization as dealer_detail,crmu.name as assigned_to,lcc.myear,(SELECT count(*) FROM loan_doc_pendency_mapping as dpm WHERE dpm.case_id = lci.id AND dpm.status = "1" ) as pendency,lcd.id as coapplicant_id,lgd.id as guarantor_id,lci.guaranter_case,lci.co_applicant,lem.loanno,cddg.counter_emi,cddg.disburse_emi');
		} else
			$this->db->select('lcc.id as sr_no');

		$this->db->from('loan_customer_info as lci');
		$this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id', 'inner');
		$this->db->join('crm_customers as cblm', 'cblm.id=lci.customer_id', 'inner');
		$this->db->join('crm_user as cusr', 'cusr.id=lci.meet_the_customer', 'LEFT');
		$this->db->join('crm_user as crmu', 'crmu.id=lci.assign_case_to', 'LEFT');
		$this->db->join('loan_customer_academic as ca', 'ca.customer_id = lci.customer_id', 'left');
		$this->db->join('loan_file_login_mapping as lem', 'lcc.customer_loan_id=lem.case_id and lem.status="1" AND (lem.tag_flag=lcc.loan_approval_status OR lcc.loan_approval_status > 4)', 'left');
		$this->db->join('loan_file_login_tags as lmt', 'lem.tag_flag=lmt.id', 'left');
		if ($params['is_count'] == 0) {
			$this->db->join('model_version as mv', 'lcc.versionId=mv.db_version_id', 'left');
			$this->db->join('make_model as mm', 'mv.model_id = mm.id', 'left');
			$this->db->join('crm_bank_list as c', 'lem.bank_id=c.id', 'left');
			$this->db->join('loan_customer_reference_info as ref', 'lcc.customer_loan_id = ref.customer_case_id', 'left');
			$this->db->join('loan_post_delivery_details as postdel', 'postdel.case_id = ref.customer_case_id', 'left');
			$this->db->join('loan_payment_details as paydel', 'paydel.case_id = ref.customer_case_id', 'left');
			$this->db->join('city_list as cl', 'cl.city_id=lci.residence_city', 'left');
			$this->db->join('crm_dealers as crmd', 'crmd.id=lci.dealer_id', 'left');
			$this->db->join('crm_customer_bank_info as cbin', 'cbin.case_id=lcc.customer_loan_id', 'left');
			$this->db->join('loan_coapplicant_detail as lcd', 'lcd.case_id=lcc.customer_loan_id', 'left');
			$this->db->join('loan_guarantor_detail as lgd', 'lgd.case_id=lcc.customer_loan_id', 'left');
			$this->db->join('crm_disbursal_distribution as cddg', 'cddg.case_id=lcc.customer_loan_id', 'left');
		}
		$this->db->where('lcc.customer_loan_id>"1"');
		$this->getSearchQuery($params);
		$this->db->group_by('lcc.customer_loan_id');
		$this->db->order_by('lcc.last_updated_date', 'desc');
		$this->db->order_by('lmt.priority', 'asc');
		if (($params['is_count'] == 0) && (empty($params['export']))) {
			if (isset($params['page'])) {
				$this->db->offset((int) ($startLimit));
			}
			if (!empty($perPageRecord)) {
				$this->db->limit((int) $perPageRecord);
			}
		}
		$query = $this->db->get();
		$result = $query->result_array();

		if ($params['is_count'] == 1) {
			//    echo $this->db->last_query();die;
			$result = count($result);
		}
		return  $result;
	}
	function getSearchQuery($params)
	{
		if (!empty($params['dashboard'])) {
			if ($params['dashboard'] == '1') {
				$this->db->where_not_in('lcc.loan_approval_status', ['6', '9', '11']);
			}
			if ($params['dashboard'] == '2') {
				$this->db->where('lcc.loan_approval_status in (10,7)');
			}
			if ($params['dashboard'] == '3') {
				$this->db->where('lem.cpv_status!=0');
				$this->db->where('lem.valuation_status!=0');
				$this->db->where('lcc.loan_approval_status', '1');
				$this->db->where('lem.tag_flag not in (2,3,4)');
			}
			if ($params['dashboard'] == '4') {
				$this->db->where('lem.tag_flag', '2');
				$this->db->where('lcc.loan_approval_status', '2');
			}
			if ($params['dashboard'] == '5') {
				$this->db->where_not_in('lcc.loan_approval_status', ['11,3,6,9']);
				$this->db->where('(lcc.upload_login_doc_flag != "1" OR lcc.upload_dis_doc_flag != "1" OR (lcc.upload_post_doc_flag != "1" && lcc.loan_for = 2))');
			}
			if ($params['dashboard'] == '6') {
				$this->db->where('lcc.loan_approval_status in (4,8)');
			}
		}

		if ((!empty($params['searchbyvaldealer'])) && (!empty($params['searchby']))) {
			if ($params['searchby'] == 'searchdealer') {
				$searchByDealer = 'lci.dealer_id';
			}
			$this->db->where($searchByDealer, $params['searchbyvaldealer']);
		}
		if ((!empty($params['searchbyvalbank'])) && (!empty($params['searchby']))) {
			if ($params['searchby'] == 'searchbank') {
				$searchByDealer = 'lem.bank_id';
			}
			$this->db->where($searchByDealer, $params['searchbyvalbank']);
			$this->db->where('lem.status', '1');
		}
		if ((!empty($params['searchbyval'])) && (!empty($params['searchby'])) && $params['searchby'] != 'searchdealer') {
			if ($params['searchby'] == 'searchmobile') {
				$this->db->where('cblm.mobile', $params['searchbyval']);
			}
			if ($params['searchby'] == 'searchcase') {
				$this->db->where('lem.ref_id', $params['searchbyval']);
			}
			if ($params['searchby'] == 'searchcaseloan') {
				$this->db->where('lem.loanno', $params['searchbyval']);
			}
			if ($params['searchby'] == 'searchserialno') {
				$this->db->where('lcc.id', $params['searchbyval']);
			}
			if ($params['searchby'] == 'searchreg') {
				$this->db->where('lcc.regno', $params['searchbyval']);
			}
			if ($params['searchby'] == 'searchcustname') {
				$this->db->where('lci.name like "%' . $params['searchbyval'] . '%"');
			}
		}
		if ((!empty($params['loan_status']))) {
			if ($params['loan_status'] == '5') {
				$where = '(lcc.loan_approval_status="5")';
				$this->db->where($where);
			}
			if ($params['loan_status'] == '7') {
				$this->db->where('lcc.loan_approval_status', '7');
			}
			if ($params['loan_status'] == '1') {
				$this->db->where('lem.tag_flag', '1');
				$this->db->where('lcc.loan_approval_status', '1');
				$this->db->where('lcc.cancel_id', '0');
			}
			if ($params['loan_status'] == '2') {
				$this->db->where('lem.tag_flag', '2');
				$this->db->where('lcc.loan_approval_status', '2');
				$this->db->where('lcc.cancel_id', '0');
			}
			if ($params['loan_status'] == '3') {
				$this->db->where('lem.tag_flag', '3');
				$this->db->where('lcc.loan_approval_status', '3');
				$this->db->where('lcc.cancel_id', '0');
			}
			if ($params['loan_status'] == '4') {
				$this->db->where('lem.tag_flag', '4');
				$this->db->where('lcc.loan_approval_status', '4');
				$this->db->where('lcc.cancel_id', '0');
			}
			if ($params['loan_status'] == '8') {
				$this->db->where('lcc.loan_approval_status', '8');
				$this->db->where('lcc.cancel_id', '0');
				//$this->db->where('lem.tag_flag','4');
			}
			if ($params['loan_status'] == '9') {
				// $tagIds = array('6');
				$this->db->where('lcc.loan_approval_status', '9');
			}
			if ($params['loan_status'] == '6') {
				$this->db->where('lcc.loan_approval_status', '6');
			}
			if ($params['loan_status'] == '10') {
				$this->db->where('lcc.loan_approval_status', '10');
				$this->db->where('lcc.cancel_id', '0');
			}
			if ($params['loan_status'] == '11') {
				$this->db->where('lcc.loan_approval_status', '11');
				//$this->db->where('lcc.cancel_id','0');
			}
		}
		if (!empty($params['loan_source'])) {
			$this->db->where('lci.source_type', $params['loan_source']);
		}

		if (!empty($params['searchdate'])) {
			//echo $params['searchdate']; exit;
			if ($params['searchdate'] == 'disdocdate') {
				$searchedDate = 'lem.disbursed_date';
			}
			if ($params['searchdate'] == 'rejectdate') {
				$searchedDate = 'lem.rejected_date';
			}
			if ($params['searchdate'] == 'approvedate') {
				$searchedDate = 'lem.approved_date';
			}
			if ($params['searchdate'] == 'fileddate') {
				$searchedDate = 'lem.file_login_date';
			}
			if ($params['searchdate'] == 'casedate') {
				$searchedDate = 'lcc.created_date';
			}
			if (!empty($params['daterange_to'])) {
				$to = date('Y-m-d', strtotime($params['daterange_to']));
				$where = "DATE(" . $searchedDate . ")";
				$this->db->where($where . '>=', $to);
			}
			if (!empty($params['daterange_from'])) {
				$from = date('Y-m-d', strtotime($params['daterange_from']));
				$where = "DATE(" . $searchedDate . ")";
				$this->db->where($where . '<=', $from);
			}
		}
		if (!empty($params['status'])) {
			$stat = explode('_', $params['status']);
			$this->db->where('lcc.loan_type', $stat[1]);
			$this->db->where('lcc.loan_for', $stat[0]);
		}
		if (!empty($params['assignedto'])) {
			$this->db->where('lci.assign_case_to', $params['assignedto']);
		}
		$teamn = !empty($this->session->userdata['userinfo']['team_name']) ? $this->session->userdata['userinfo']['team_name'] : '';
		if (($teamn == 'Sales') && ($params['role_name'] == 'Executive')) {
			$this->db->where('lci.meet_the_customer', $params['user_id']);
		}
		if (($params['role_name'] == 'New Car') || ($params['role_name'] == 'Used Car') || ($params['role_name'] == 'Refinance')) {
			$this->db->where('lci.assign_case_to', $params['user_id']);
		}
	}
	public function getAllCaseInfoCount($searchbyval = "", $searchbyvaldealer = "", $searchby = "", $loan_source = "", $loan_status = "", $searchdate = "", $daterange_to = "", $daterange_from = "", $status = "", $assignedto = "", $pages = "", $dashboard = "", $role_name = "", $emp_id = "", $searchbyvalbank = "")
	{

		$this->db->select('lcc.id as sr_no');
		$this->db->from('loan_customer_info as lci');
		$this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id', 'left');
		$this->db->join('loan_customer_academic as ca', 'ca.customer_id = lci.customer_id', 'left');
		$this->db->join('model_version as mv', 'lcc.versionId=mv.db_version_id', 'left');
		$this->db->join('make_model as mm', 'mv.model_id = mm.id', 'left');
		$this->db->join('loan_file_login_mapping as lem', 'lcc.customer_loan_id=lem.case_id and lem.status="1" and (lem.tag_flag=lcc.loan_approval_status OR lcc.loan_approval_status > 4)', 'left');
		$this->db->join('loan_file_login_tags as lmt', 'lem.tag_flag=lmt.id', 'left');
		$this->db->join('crm_bank_list as c', 'lem.bank_id=c.id', 'left');
		$this->db->join('loan_customer_reference_info as ref', 'lcc.customer_loan_id = ref.customer_case_id', 'left');
		$this->db->join('loan_post_delivery_details as postdel', 'postdel.case_id = ref.customer_case_id', 'left');
		$this->db->join('loan_payment_details as paydel', 'paydel.case_id = ref.customer_case_id', 'left');
		$this->db->join('crm_customers as cblm', 'cblm.id=lci.customer_id', 'inner');
		$this->db->join('city_list as cl', 'cl.city_id=lci.residence_city', 'left');
		$this->db->join('crm_customer_bank_info as cbin', 'cbin.case_id=lcc.customer_loan_id', 'left');
		$this->db->where('lcc.customer_loan_id>"1"');
		if (!empty($dashboard)) {
			if ($dashboard == '1') {
				//$taf = [];
				$taf = ['6', '9'];
				$this->db->where_not_in('lcc.loan_approval_status', $taf);
			}
			if ($dashboard == '2') {
				$this->db->where('lcc.loan_approval_status in (10,7)');
			}
			if ($dashboard == '3') {
				$this->db->where('lem.cpv_status!=0');
				$this->db->where('lem.valuation_status!=0');
				$this->db->where('lcc.loan_approval_status', '1');
				$this->db->where('lem.tag_flag not in (2,3,4)');
			}
			if ($dashboard == '4') {
				$this->db->where('lem.tag_flag', '2');
				$this->db->where('lcc.loan_approval_status', '2');
			}
		}

		if ((!empty($searchbyvaldealer)) && (!empty($searchby))) {
			if ($searchby == 'searchdealer') {
				$searchByDealer = 'lci.dealer_id';
			}
			$this->db->where($searchByDealer, $searchbyvaldealer);
		}
		if ((!empty($searchbyvalbank)) && (!empty($searchby))) {
			if ($searchby == 'searchbank') {
				$searchByDealer = 'lem.bank_id';
			}
			$this->db->where($searchByDealer, $searchbyvalbank);
			$this->db->where('lem.status', '1');
		}
		if ((!empty($searchbyval)) && (!empty($searchby)) && $searchby != 'searchdealer') {
			if ($searchby == 'searchmobile') {
				// $searchByInd ='cblm.mobile';
				$this->db->where('cblm.mobile', $searchbyval);
			}
			if ($searchby == 'searchcase') {
				$this->db->where('lem.ref_id', $searchbyval);
			}
			if ($searchby == 'searchcaseloan') {
				$this->db->where('lem.loanno', $searchbyval);
			}
			if ($searchby == 'searchserialno') {
				//$searchByInd ='lem.ref_id';
				$this->db->where('lcc.id', $searchbyval);
			}

			if ($searchby == 'searchreg') {
				// $searchByInd =;  
				$this->db->where('lcc.regno', $searchbyval);
			}

			if ($searchby == 'searchcustname') {
				$this->db->where('lci.name like "%' . $searchbyval . '%"');
			}
		}
		if ((!empty($loan_status))) {
			if ($loan_status == '5') {
				$where = '(lcc.loan_approval_status="5")';
				$this->db->where($where);
				$this->db->where('lcc.cancel_id', '0');
				//$this->db->or_where('lcc.loan_approval_status','5');
			}
			if ($loan_status == '7') {
				$this->db->where('lcc.loan_approval_status', '7');
				$this->db->where('lcc.cancel_id', '0');
				//$this->db->where('lem.tag_flag','5');
			}
			/* if($loan_status=='3')
          {
            $this->db->where('cbin.bank_branch!=','');
            $this->db->where('lem.tag_flag','5');
          }*/
			if ($loan_status == '1') {
				$this->db->where('lem.tag_flag', '1');
				$this->db->where('lcc.loan_approval_status', '1');
				$this->db->where('lcc.cancel_id', '0');
			}
			if ($loan_status == '2') {
				$this->db->where('lem.tag_flag', '2');
				$this->db->where('lcc.loan_approval_status', '2');
				$this->db->where('lcc.cancel_id', '0');
			}
			if ($loan_status == '3') {
				$this->db->where('lem.tag_flag', '3');
				$this->db->where('lcc.loan_approval_status', '3');
				$this->db->where('lcc.cancel_id', '0');
			}
			if ($loan_status == '4') {
				$this->db->where('lem.tag_flag', '4');
				$this->db->where('lcc.loan_approval_status', '4');
				$this->db->where('lcc.cancel_id', '0');
			}
			if ($loan_status == '8') {
				$this->db->where('lcc.loan_approval_status', '8');
				$this->db->where('lcc.cancel_id', '0');
				//$this->db->where('lem.tag_flag','4');
			}
			if ($loan_status == '9') {
				// $tagIds = array('6');
				$this->db->where('lcc.loan_approval_status', '9');
			}
			if ($loan_status == '6') {
				$this->db->where('lcc.loan_approval_status', '6');
			}
			if ($loan_status == '10') {
				$this->db->where('lcc.loan_approval_status', '10');
				$this->db->where('lcc.cancel_id', '0');
			}
			if ($loan_status == '11') {
				$this->db->where('lcc.loan_approval_status', '11');
				//$this->db->where('lcc.cancel_id','0');
			}
		}
		if (!empty($loan_source)) {
			$this->db->where('lci.source_type', $loan_source);
		}

		if (!empty($searchdate)) {
			if ($searchdate == 'disdocdate') {
				$searchedDate = 'lem.disbursed_date';
			}
			if ($searchdate == 'rejectdate') {
				$searchedDate = 'lem.rejected_date';
			}
			if ($searchdate == 'approvedate') {
				$searchedDate = 'lem.approved_date';
			}
			if ($searchdate == 'fileddate') {
				$searchedDate = 'lem.file_login_date';
			}
			if ($searchdate == 'casedate') {
				$searchedDate = 'lcc.created_date';
			}
			// echo $daterange_to . ',' . $daterange_from; exit;
			if (!empty($daterange_to)) {
				$to = date('Y-m-d', strtotime($daterange_to));
				$where = "DATE(" . $searchedDate . ")";
				$this->db->where($where . '>=', $to);
			}
			if (!empty($daterange_from)) {
				$from = date('Y-m-d', strtotime($daterange_from));
				$where = "DATE(" . $searchedDate . ")";
				// $this->db->where($where.'<=',$from);
				$this->db->where($where . '<=', $from);
			}
		}

		if (!empty($status)) {
			$stat = explode('_', $status);
			$this->db->where('lcc.loan_type', $stat[1]);
			$this->db->where('lcc.loan_for', $stat[0]);
		}
		if (!empty($assignedto)) {
			$this->db->where('lci.assign_case_to', $assignedto);
		}
		$teamn = !empty($this->session->userdata['userinfo']['team_name']) ? $this->session->userdata['userinfo']['team_name'] : '';
		if (($teamn == 'Sales') && ($role_name == 'Executive')) {
			$this->db->where('lci.meet_the_customer', $emp_id);
		}
		if (($role_name == 'New Car') || ($role_name == 'Used Car') || ($role_name == 'Refinance') || ($role_name == 'Sales')) {
			$this->db->where('lci.assign_case_to', $emp_id);
			//$where = "cbin.case_id is  NOT NULL";
			//$this->db->where($where);
			//$this->db->where('1','')
		}
		$this->db->group_by('lcc.customer_loan_id');
		$query = $this->db->get();
		$result = $query->result_array();
		// echo $this->db->last_query(); exit;
		return  count($result);
	}
	public function getFileTagName($tagId)
	{
		$query = $this->db->get_where('loan_file_login_tags', array('id' => $tagId));
		$result = $query->result_array();
		return  $result;
	}
	public function saveUpdateOrderInfo($orderInfo, $updateId = '')
	{
		if (empty($updateId)) {
			$this->db->trans_start();
			$orderInfo['do_updated_status'] = '1';
			$this->db->insert('crm_finance_delivery', $orderInfo);
			$insert_id = $this->db->insert_id();
			$this->db->trans_complete();
			$result = $insert_id;
		} else {
			$this->db->where('id', $updateId);
			$this->db->update('crm_finance_delivery', $orderInfo);
			$result = $updateId;
		}
		//echo $this->db->last_query(); exit;
		return $result;
	}
	public function saveUpdateReceiptInfo($receiptInfo, $updateId = '')
	{
		//echo $updateId;die;
		if (empty($updateId)) {
			$this->db->trans_start();
			$this->db->insert('crm_finance_receipt', $receiptInfo);
			$insert_id = $this->db->insert_id();
			$this->db->trans_complete();
			$result = $insert_id;
		} else {
			$this->db->where('id', $updateId);
			$this->db->update('crm_finance_receipt', $receiptInfo);
			$result = $updateId;
		}
		return $result;
	}

	public function getDeliveryOrderInfo($orderId, $flag = '')
	{
		if (!empty($orderId)) {
			$this->db->select('fd.dealer_id,fd.margin_money_inhouse,fd.include_margin_money_cus,fd.include_margin_money_in,fd.include_dis_shared,fd.deliverySource,fd.deliveryTeam,fd.deliverySales,fd.do_date,fd.loan_taken,fd.application_no,fd.do_no,fd.do_amt,fd.do_amt_word,fd.showroomName,fd.showroomAddress,fd.kind_attn,fd.showroom_disc,fd.scheme_disc,fd.delivery_date,fd.delivery_date,fd.loan_taken_from,fd.do_insu_premium, fd.do_external_warranty, fd.show_ex_disc, fd.show_loyalty, fd.show_corporate,'
				. 'fd.dis_ex_disc, fd.dis_loyalty, fd.dis_corporate, fd.exp_payment_date,fd.customer_mobile_no,fd.customer_name,fd.customer_address,fd.make,fd.model,fd.variant,fd.color,fd.reg_req,fd.hp_to,fd.booking_date,fd.status,fd.add_date,fd.update_date,fd.last_updated_status,fd.last_updated_date,'
				. 'fr.paymentType,fr.paymentBy,fr.intrumentType,fr.instrumentNo,fr.creditAmt,fr.creditDate,fr.favouring,fr.drawnOn,fr.receiptDate,fr.createdDate,fd.hp_to,'
				. 'mm.make as makeName,mm.model as modelName,mv.db_version as versionName,d.organization,d.organization as dealerName,u.name as employeeName,'
				. 'fd.id as orderId,fd.loan_filled,fd.booking_done,fd.booking_slip_no,fd.new_car_price,fd.insurance,fd.do_status,fd.gross_do_amt,fd.ex_show,fd.tcs,fd.epc,fd.road_tax,fd.showroom_discount,fd.scheme,fd.total_showroom_discount,fd.total_dis_amount,fd.loan_amt,fd.dedu_loan,fd.margin_money,fd.net_do_amt,fd.sameas,fd.sameasloan,fd.dshowroom_dis,fd.dscheme_dis,cdp.entry_type,cdp.id as ppid,cdp.bank_id as pbank_id,cdp.payment_by,cdp.case_id,cdp.payment_date,cdp.payment_mode,cdp.favouring_to,cdp.amount,cdp.instrument_no,cdp.instrument_date,cdp.bank_name,cdp.pay_remark,cdp.created_by,fd.reg_type,fd.insu_premium,fd.cancel_id,doca.other_reason,dor.reason,mmp.make as parentmakeName,mmp.model as parentmodelName, dd.organization as dealerOrganiser, lem.disbursed_roi, lem.disbursed_tenure, lem.disbursed_amount, cdd.disburse_emi, c.bank_name as financer_name, fd.do_updated_status');

			$this->db->from('crm_finance_delivery as fd');
			$this->db->join('crm_finance_receipt as fr', 'fr.orderId=fd.id', 'left');
			$this->db->join('crm_do_part_payment as cdp', 'cdp.case_id=fd.id', 'left');
			$this->db->join('do_cancel_other_reason as doca', 'doca.do_id=fd.id', 'left');
			$this->db->join('do_cancel_reason as dor', 'dor.id=fd.cancel_id', 'left');
			$this->db->join('model_version as mv', 'mv.db_version_id=fd.variant', 'left');
			$this->db->join('make_model as mm', 'mm.id=mv.model_id', 'left');
			$this->db->join('make_model as mmp', 'mmp.id=mm.parent_model_id', 'left');
			$this->db->join('crm_dealers as d', 'd.id=fd.showroomName and d.status="1"', 'left');
			$this->db->join('crm_dealers as dd', 'dd.id=fd.dealer_id and dd.status="1"', 'left');
			$this->db->join('crm_user as u', 'u.id=fd.deliveryTeam and u.status="1"', 'left');
			$this->db->join('loan_file_login_mapping as lem', 'lem.case_id=fd.id and lem.status="1"', 'left');
			$this->db->join('crm_disbursal_distribution as cdd', 'cdd.case_id = lem.case_id', 'left');
			$this->db->join('crm_bank_list as c', 'c.id=fd.hp_to', 'left');
			$this->db->where('fd.id', $orderId);
			if ($flag == 'group') {
				$this->db->group_by('fd.id');
			}
			$query = $this->db->get();
			//echo $this->db->last_query(); exit;
			return $result = $query->result_array();
		} else {
			return false;
		}
	}

	public function getReceiptInfo($orderId)
	{
		if (!empty($orderId)) {
			$this->db->select('fr.id,fd.deliverySource,fd.deliverySales,fd.do_date,fd.loan_taken,fd.application_no,fd.do_no,fd.do_amt,fd.do_amt_word,fd.showroomName,fd.showroomAddress,fd.kind_attn,fd.showroom_disc,fd.scheme_disc,fd.delivery_date,fd.delivery_date,'
				. 'fd.exp_payment_date,fd.customer_mobile_no,fd.customer_name,fd.customer_address,fd.make,fd.model,fd.variant,fd.color,fd.reg_req,fd.hp_to,fd.booking_date,fd.status,fd.add_date,fd.update_date,fd.last_updated_status,fd.last_updated_date,'
				. 'fr.paymentType,fr.intrumentType,fr.instrumentNo,fr.creditAmt,fr.creditDate,fr.favouring,fr.drawnOn,fr.receiptDate,fr.createdDate,fd.hp_to,'
				. 'mm.make as makeName,mm.model as modelName,mv.db_version as versionName,d.organization,d.owner_name as dealerName,u.name as employeeName,fr.payment_remark,'
				. 'fd.id as orderId,fr.paymentBy,fr.amount,fr.receipt_no');
			$this->db->from('crm_finance_delivery as fd');
			$this->db->join('crm_finance_receipt as fr', 'fr.orderId=fd.id', 'left');
			$this->db->join('model_version as mv', 'mv.db_version_id=fd.variant', 'left');
			$this->db->join('make_model as mm', 'mm.id=mv.model_id', 'left');
			$this->db->join('crm_dealers as d', 'd.id=fd.showroomName and d.status="1"', 'left');
			$this->db->join('crm_user as u', 'u.id=fd.deliverySales and u.status="1"', 'left');
			$this->db->where('fd.id', $orderId);
			$query = $this->db->get();
			//echo $this->db->last_query(); exit;
			$result = $query->result_array();
			return $result;
		} else {
			return false;
		}
	}
	public function getReceiptIdfromOrder($orderId)
	{
		$this->db->select('fr.*');
		$this->db->from('crm_finance_receipt as fr');
		$this->db->where('orderId', $orderId);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$result = $query->result_array();
		return $result;
	}

	public function getBanklist()
	{
		$this->db->select('b.*');
		$this->db->from('crm_bank_list as b');
		$this->db->where('b.status', '1');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$result = $query->result_array();
		return $result;
	}
	public function getOrderListingCount($requestParams, $dealerId)
	{
		/*$requestParams['rpp']=5;
        $responseData = array();
        $daysCount = 30;
        $perPageRecord = $requestParams['rpp'] == 0 ? 5 : $requestParams['rpp'];
        $pageNo = (isset($requestParams['page']) && $requestParams['page'] != '') ? $requestParams['page'] : '1';
        $startLimit = ($pageNo - 1) * $perPageRecord;
        //echo "<pre>";print_r($requestParams);exit;*/
		$requestParams['dealerID'] = $dealerId;
		$getleads = $this->getOrderleadsQuery($requestParams, '', '', '', '1');

		$totalRecords = count($this->getOrderleadsQuery($requestParams, '', '', '', '1'));
		$totalRecords = count($getleads);
		$leads = array();
		if (!empty($getleads)) {
			$i = 0;
			foreach ($getleads as $key => $val) {
				$leads[$i]['orderId'] = $val['orderId'];
				$leads[$i]['deliverySource'] = $val['deliverySource'];
				$leads[$i]['deliverySales'] = $val['deliverySales'];
				$leads[$i]['do_date'] = ($val['do_date'] != '0000-00-00') ? date("d F ,Y", strtotime($val['do_date'])) : '';
				$leads[$i]['loan_taken'] = $val['loan_taken'];
				$leads[$i]['application_no'] = $val['application_no'];
				$leads[$i]['do_no'] = $val['do_no'];
				$leads[$i]['do_amt'] = indian_currency_form($val['do_amt']);
				$leads[$i]['do_amt_word'] = $val['do_amt_word'];
				$leads[$i]['showroomName'] = $val['showroomName'];
				$leads[$i]['showroomAddress'] = $val['showroomAddress'];
				$leads[$i]['kind_attn'] = $val['kind_attn'];
				$leads[$i]['showroom_disc'] = $val['showroom_disc'];
				$leads[$i]['scheme_disc'] = $val['scheme_disc'];
				$leads[$i]['delivery_date'] = ($val['delivery_date'] != '0000-00-00') ? date("d F, Y", strtotime($val['delivery_date'])) : '';
				$leads[$i]['exp_payment_date'] = ($val['exp_payment_date'] != '0000-00-00') ? date("d F, Y", strtotime($val['exp_payment_date'])) : '';
				$leads[$i]['customer_mobile_no'] = $val['customer_mobile_no'];
				$name = ucwords(strtolower(preg_replace("/[^a-zA-Z\s]/", "", $val['customer_name'])));
				$leads[$i]['customer_name'] = $name;
				$leads[$i]['customer_address'] = $val['customer_address'];
				$leads[$i]['color'] = $val['color'];
				$leads[$i]['reg_req'] = $val['reg_req'];
				$leads[$i]['hp_to'] = $val['hp_to'];
				$leads[$i]['dostatus'] = $val['dostatus'];
				$leads[$i]['financer_name'] = $val['financer_name'];
				$leads[$i]['booking_date'] = ($val['booking_date'] != '0000-00-00') ? date("d F , Y", strtotime($val['booking_date'])) : '';
				$leads[$i]['add_date'] = ($val['add_date'] != '0000-00-00') ? date("d F , Y", strtotime($val['add_date'])) : '';
				$leads[$i]['paymentType'] = $val['paymentType'];
				$leads[$i]['intrumentType'] = $val['intrumentType'];
				$leads[$i]['instrumentNo'] = $val['instrumentNo'];
				$leads[$i]['creditAmt'] = $val['creditAmt'];
				$leads[$i]['creditDate'] = ($val['creditDate'] != '0000-00-00') ? date("d F , Y", strtotime($val['creditDate'])) : '';
				$leads[$i]['favouring'] = $val['favouring'];
				$leads[$i]['drawnOn'] = $val['drawnOn'];
				$leads[$i]['receiptDate'] = ($val['receiptDate'] != '0000-00-00') ? date("d F , Y", strtotime($val['receiptDate'])) : '';
				$leads[$i]['paystatus'] = $val['paystatus'];
				$leads[$i]['makeName'] = $val['makeName'];
				$leads[$i]['modelName'] = $val['modelName'];
				$leads[$i]['versionName'] = $val['versionName'];
				$leads[$i]['dealerName'] = $val['dealerName'];
				$leads[$i]['employeeName'] = $val['employeeName'];
				$leads[$i]['last_updated_date'] = ($val['last_updated_date'] != '0000-00-00') ? date("d F, Y", strtotime($val['last_updated_date'])) : '';
				$leads[$i]['last_updated_status'] = $val['last_updated_status'];
				$leads[$i]['dealerID'] = $dealerId;
				$leads[$i]['loan_filled'] = $val['loan_filled'];
				$i++;
			}
		}
		//$lastRecord = $pageNo * $perPageRecord;
		// $nextRecords = true;
		/*  if ($lastRecord >= $totalRecords) {
            $nextRecords = false;
        }*/

		if (isset($requestParams['leadID']) && $requestParams['leadID'] > 0) {
			return array('status' => 'T', 'leads' => $leads);
		}
		$responseData['error'] = "";
		$responseData['msg'] = "username and password matched!!";
		$responseData['status'] = "T";
		//if ($pageNo == '1') {
		//$responseData['budget_list'] = $this->crm_customers_preferences->getbudgetList();
		//$responseData['budget_list']='';
		// }
		$responseData['leads'] = $leads;
		// $responseData['pageNumber'] = $pageNo;

		//$responseData['totalRecords'] = $totalRecords;
		//  $responseData['hasNext'] = $nextRecords;

		//  $responseData['hasNext'] = $nextRecords;
		//  $responseData['pageSize'] = $perPageRecord;
		// $responseData['days_count'] = $daysCount;

		return $responseData;
	}

	public function getOrderListing($requestParams, $dealerId, $page, $limit)
	{
		$responseData = array();
		$daysCount = 30;
		$perPageRecord = $limit == 0 ? 1 : $limit;
		$pageNo = (isset($page) && $page != '') ? $page : '1';
		$startLimit = ($pageNo - 1) * $perPageRecord;
		/* $perPageRecord = $requestParams['rpp'] == 0 ? 10 : $requestParams['rpp'];
        $pageNo = (isset($requestParams['page']) && $requestParams['page'] != '') ? $requestParams['page'] : '1';
        $startLimit = ($pageNo - 1) * $perPageRecord;*/
		$requestParams['dealerID'] = $dealerId;
		$getleads = $this->getOrderleadsQuery($requestParams, $perPageRecord, $pageNo, $startLimit);
		$totalRecords = count($this->getOrderleadsQuery($requestParams, $perPageRecord, $pageNo, $startLimit, '1'));
		$totalRecords = count($getleads);
		$leads = array();
		if (!empty($getleads)) {
			$i = 0;
			foreach ($getleads as $key => $val) {
				$leads[$i]['parent_makeName'] = $val['parentmakeName'];
				$leads[$i]['parent_modelName'] = $val['parentmodelName'];
				$leads[$i]['orderId'] = $val['orderId'];
				$leads[$i]['deliverySource'] = $val['deliverySource'];
				$leads[$i]['deliverySales'] = $val['deliverySales'];
				$leads[$i]['do_date'] = ($val['do_date'] != '0000-00-00') ? date("d M ,Y", strtotime($val['do_date'])) : '';
				$leads[$i]['loan_taken'] = $val['loan_taken'];
				$leads[$i]['application_no'] = $val['application_no'];
				$leads[$i]['do_no'] = $val['do_no'];
				$leads[$i]['do_amt'] = indian_currency_form($val['do_amt']);
				$leads[$i]['do_amt_word'] = $val['do_amt_word'];
				$leads[$i]['showroomName'] = $val['showroomName'];
				$leads[$i]['showroomAddress'] = $val['showroomAddress'];
				$leads[$i]['kind_attn'] = $val['kind_attn'];
				$leads[$i]['showroom_disc'] = $val['showroom_disc'];
				$leads[$i]['scheme_disc'] = $val['scheme_disc'];
				$leads[$i]['delivery_date'] = ($val['delivery_date'] != '0000-00-00') ? date("d M, Y", strtotime($val['delivery_date'])) : '';
				$leads[$i]['exp_payment_date'] = ($val['exp_payment_date'] != '0000-00-00') ? date("d M, Y", strtotime($val['exp_payment_date'])) : '';
				$leads[$i]['customer_mobile_no'] = $val['customer_mobile_no'];
				$name = ucwords(strtolower(preg_replace("/[^a-zA-Z\s]/", "", $val['customer_name'])));
				$leads[$i]['customer_name'] = $name;
				$leads[$i]['customer_address'] = $val['customer_address'];
				$leads[$i]['color'] = $val['color'];
				$leads[$i]['reg_req'] = $val['reg_req'];
				$leads[$i]['hp_to'] = $val['hp_to'];
				$leads[$i]['dostatus'] = $val['dostatus'];
				//$leads[$i]['financer_name']=$val['financer_name'];
				$leads[$i]['booking_date'] = ($val['booking_date'] != '0000-00-00') ? date("d M , Y", strtotime($val['booking_date'])) : '';
				$leads[$i]['add_date'] = ($val['add_date'] != '0000-00-00') ? date("d M , Y", strtotime($val['add_date'])) : '';
				$leads[$i]['paymentType'] = $val['paymentType'];
				$leads[$i]['intrumentType'] = $val['intrumentType'];
				$leads[$i]['instrumentNo'] = $val['instrumentNo'];
				$leads[$i]['creditAmt'] = $val['creditAmt'];
				$leads[$i]['creditDate'] = ($val['creditDate'] != '0000-00-00') ? date("d M , Y", strtotime($val['creditDate'])) : '';
				$leads[$i]['favouring'] = $val['favouring'];
				$leads[$i]['drawnOn'] = $val['drawnOn'];
				$leads[$i]['receiptDate'] = ($val['receiptDate'] != '0000-00-00') ? date("d M , Y", strtotime($val['receiptDate'])) : '';
				$leads[$i]['paystatus'] = $val['paystatus'];
				$leads[$i]['parent_makeName'] = $val['parentmakeName'];
				$leads[$i]['parent_modelName'] = $val['parentmodelName'];
				$leads[$i]['makeName'] = $val['makeName'];
				$leads[$i]['modelName'] = $val['modelName'];
				$leads[$i]['versionName'] = $val['versionName'];
				$leads[$i]['dealerName'] = $val['dealerName'];
				$leads[$i]['employeeName'] = $val['employeeName'];
				$leads[$i]['dealer_name'] = $val['dealer_name'];
				$leads[$i]['sales_exe'] = $val['sales_exe'];
				$leads[$i]['loan_taken_from'] = $val['loan_taken_from'];
				$leads[$i]['source'] = (!empty($val['deliverySource']) && ($val['deliverySource'] == '1')) ? 'Dealer' : 'Inhouse';
				$leads[$i]['last_updated_date'] = ($val['last_updated_date'] != '0000-00-00') ? date("d M, Y", strtotime($val['last_updated_date'])) : '';
				$leads[$i]['last_updated_status'] = $val['last_updated_status'];
				$leads[$i]['dealerID'] = $dealerId;
				$leads[$i]['loan_filled'] = $val['loan_filled'];
				$leads[$i]['cancel_id'] = $val['cancel_id'];
				$leads[$i]['reason'] = $val['reason'];
				$leads[$i]['other_reason'] = $val['other_reason'];
				$leads[$i]['insurance'] = $val['insurance'];
				$leads[$i]['gross_do_amt'] = $val['gross_do_amt'];
				$leads[$i]['insu_premium'] = $val['insu_premium'];
				$leads[$i]['do_updated_status'] = $val['do_updated_status'];
				if (($val['application_no'] != "") && ($val['loan_filled'] == 1)) {
					$financerdata['financerDetail'] = current($this->getloanInfoByRefid($val['application_no'], 1, ''));
					// echo "<pre>";print_r($loandata['loanDetail']);die;
					$leads[$i]['financer_name'] = $financerdata['financerDetail']['financer_name'];
				} else {
					$financerdata['financerDetail'] =  current($this->getloanInfoByRefid('', 1, 1, $val['orderId']));
					if ($val['loan_taken_from'] == '2')
						$leads[$i]['financer_name'] = $financerdata['financerDetail']['financer_name'];
					else
						$leads[$i]['financer_name']  = !empty($val['financer_name']) ? $val['financer_name'] : 'NA';
				}
				if (isset($requestParams['export']) && $requestParams['export'] == 'export') {
					$leads[$i]['payment_1'] = $this->selectDoPartpayment('', '1', '', $val['orderId']);
					$leads[$i]['payment_2'] = $this->selectDoPartpayment('', '', '', $val['orderId']);
					if ($val['application_no'] != "") {
						$leads[$i]['loanDetail'] = current($this->getloanInfoByCaseId($val['application_no'], 1));
					}
				}
				$i++;
			}
		}
		$lastRecord = $pageNo * $perPageRecord;
		$nextRecords = true;
		if ($lastRecord >= $totalRecords) {
			$nextRecords = false;
		}

		if (isset($requestParams['leadID']) && $requestParams['leadID'] > 0) {
			return array('status' => 'T', 'leads' => $leads);
		}
		$responseData['error'] = "";
		$responseData['msg'] = "username and password matched!!";
		$responseData['status'] = "T";
		if ($pageNo == '1') {
			//$responseData['budget_list'] = $this->crm_customers_preferences->getbudgetList();
			//$responseData['budget_list']='';
		}
		$responseData['leads'] = $leads;
		$responseData['pageNumber'] = $pageNo;

		$responseData['totalRecords'] = $totalRecords;
		$responseData['hasNext'] = $nextRecords;

		$responseData['hasNext'] = $nextRecords;
		$responseData['pageSize'] = $perPageRecord;
		$responseData['days_count'] = $daysCount;

		return $responseData;
	}

	public function getOrderleadsQuery($requestParams, $perPageRecord, $pageNo, $startLimit, $flag = '')
	{
		$lastdaydate = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 7));
		$lastdaydate90 = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 90));
		$this->db->select('fd.*,fr.*,fd.id as orderId,fd.status as dostatus,fr.status as paystatus,mm.make as makeName,mm.model as modelName,mmp.make as parentmakeName,mmp.model as parentmodelName,mv.db_version as versionName,d.organization as dealerName,u.name as employeeName,c.bank_name as financer_name,ds.organization as dealer_name,us.name as sales_exe,doca.other_reason,dor.reason,doca.updated_date');
		$this->db->from('crm_finance_delivery as fd');
		$this->db->join('crm_finance_receipt as fr', 'fr.orderId=fd.id', 'left');
		$this->db->join('do_cancel_reason as dor', 'dor.id=fd.cancel_id', 'left');
		$this->db->join('do_cancel_other_reason as doca', 'doca.do_id=fd.id', 'left');
		$this->db->join('model_version as mv', 'mv.db_version_id=fd.variant', 'left');
		$this->db->join('make_model as mm', 'mm.id=mv.model_id', 'left');
		$this->db->join('make_model as mmp', 'mmp.id=mm.parent_model_id', 'left');
		$this->db->join('crm_dealers as d', 'd.id=fd.showroomName and d.status="1"', 'left');
		$this->db->join('crm_dealers as ds', 'ds.id=fd.dealer_id and ds.status="1"', 'left');
		$this->db->join('crm_user as u', 'u.id=fd.deliverySales and u.status="1"', 'left');
		$this->db->join('crm_user as us', 'us.id=fd.deliveryTeam and us.status="1"', 'left');
		$this->db->join('crm_bank_list as c', 'fd.hp_to=c.id', 'left');
		$this->db->where('fd.status', '1');
		$this->db->where('fd.cancel_id', 0);
		$teamn = !empty($this->session->userdata['userinfo']['team_name']) ? $this->session->userdata['userinfo']['team_name'] : '';
		$rolen = !empty($this->session->userdata['userinfo']['role_name']) ? $this->session->userdata['userinfo']['role_name'] : '';
		if ((!empty($requestParams['userId']) && $requestParams['userId'] > 0 && $requestParams['userId'] != '1') && (($teamn == 'Delivery' || $teamn == 'Sales') && ($rolen != 'Lead') && ($teamn == 'Delivery' && $rolen != 'Executive'))) {
			$this->db->where('fd.deliveryTeam', $requestParams['userId']);
		}
		$this->DoGetLeadsFilter($requestParams);
		$this->db->group_by(array('fd.id'));
		$this->db->order_by('fd.id', 'DESC');
		if (isset($requestParams['type']) && $requestParams['type'] != '' && $requestParams['sorting'] == '1') {
			//$this->db->sortingTabwise($requestParams);
		}

		if (empty($requestParams['export']) && $requestParams['export'] != 'export') {
			if (empty($flag)) {
				if (isset($requestParams['page'])) {
					$this->db->offset((int) ($startLimit));
				}
				if (!empty($perPageRecord)) {
					$this->db->limit((int) $perPageRecord);
				}
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return  $query->result_array();
	}
	public function DoGetLeadsFilter($requestParams)
	{
		$select = $this->db;
		if (isset($requestParams['dodashId']) && $requestParams['dodashId'] != '') {
			if ($requestParams['dodashId'] == '1') {
				$select->where("fd.loan_taken='1' and fd.loan_taken_from='1' and fd.loan_filled='2' and fd.application_no=''");
			}
			if ($requestParams['dodashId'] == '2') {
				//$select->where("fd.last_updated_status='1'");
				$select->where("fd.do_updated_status='1'");
			}
			if ($requestParams['dodashId'] == '4') {
				$select->where('fd.cancel_id=', 0);
				$select->where('fd.showroom_balance!=', '');
				$select->where('fd.showroom_balance!=', 0);
			}

			if ($requestParams['dodashId'] == '5') {
				$select->where('fd.cancel_id=', 0);
				$select->where('fd.customer_balance!=', '');
				$select->where('fd.customer_balance!=', 0);
			}
		}
		if (isset($requestParams['keyword']) && $requestParams['keyword'] != '') {
			if ((isset($requestParams['searchby'])) && ($requestParams['searchby'] == 'searchcustname')) {
				$select->where("(fd.customer_name like '%" . trim($requestParams['keyword']) . "%')");
			}
			if ((isset($requestParams['searchby'])) && ($requestParams['searchby'] == 'searchmobile')) {
				$select->where("(fd.customer_mobile_no like '%" . trim($requestParams['keyword']) . "%')");
			}
			if ((isset($requestParams['searchby'])) && ($requestParams['searchby'] == 'doid')) {
				$select->where("(fd.id like '%" . trim($requestParams['keyword']) . "%')");
			}

			// $select->where("(fd.customer_name like '%" . trim($requestParams['keyword']) . "%' or fd.customer_mobile_no like '%" . trim($requestParams['keyword']). "%' or fd.id like '%" .trim($requestParams['keyword']). "%')");
		}
		if ((isset($requestParams['searchby'])) && ($requestParams['searchby'] == 'searchdealername') && (isset($requestParams['keywordbyd']))) {
			$select->where('fd.dealer_id', trim($requestParams['keywordbyd']));
			$select->where('fd.deliverySource', '1');
		}
		if (isset($requestParams['showroom']) && $requestParams['showroom'] != '') {

			$select->where("d.id='" . $requestParams['showroom'] . "'");
		}
		if (isset($requestParams['salesex']) && $requestParams['salesex'] != '') {

			$select->where("us.id='" . $requestParams['salesex'] . "'");
		}
		if (isset($requestParams['doStatus']) && $requestParams['doStatus'] != '') {
			if ($requestParams['doStatus'] == '1') {
				$select->where("fd.last_updated_status='1'");
				$select->where("fd.cancel_id ='0'");
			} elseif ($requestParams['doStatus'] == '2') {
				//$select->where("fd.last_updated_status='2'"); 
				$select->where("fd.do_updated_status='2'");
				$select->where("fd.cancel_id ='0'");
			}
			/* elseif($requestParams['doStatus']=='3'){
                  $select->where("fd.cancel_id >'0'");  
                }*/
		}

		if (isset($requestParams['searchdate']) && $requestParams['searchdate'] == 'deliverydate') {
			if (isset($requestParams['createStartDate']) && $requestParams['createStartDate'] != '') {
				$select->where("DATE(fd.delivery_date) >=", $this->changeDateformat($requestParams['createStartDate']));
			}
			if (isset($requestParams['createEndDate']) && $requestParams['createEndDate'] != '') {
				$select->where("DATE(fd.delivery_date) <=", $this->changeDateformat($requestParams['createEndDate']));
			}
		}
		if (isset($requestParams['searchdate']) && $requestParams['searchdate'] == 'dodate') {
			/*if (isset($requestParams['createStartDate']) && $requestParams['createStartDate'] != '') {
                $select->where("DATE(fd.add_date) >=" ,$this->changeDateformat($requestParams['createStartDate']));
            }
            if (isset($requestParams['createEndDate']) && $requestParams['createEndDate'] != '') {
                $select->where("DATE(fd.add_date) <=",$this->changeDateformat($requestParams['createEndDate']));
            }*/
			if (isset($requestParams['createStartDate']) && $requestParams['createStartDate'] != '') {
				$select->where("DATE(fd.do_date) >=", $this->changeDateformat($requestParams['createStartDate']));
			}
			if (isset($requestParams['createEndDate']) && $requestParams['createEndDate'] != '') {
				$select->where("DATE(fd.do_date) <=", $this->changeDateformat($requestParams['createEndDate']));
			}
		}
		if (isset($requestParams['searchdate']) && $requestParams['searchdate'] == 'receiptdate') {
			if (isset($requestParams['createStartDate']) && $requestParams['createStartDate'] != '') {
				$select->where("DATE(fr.createdDate) >=", $this->changeDateformat($requestParams['createStartDate']));
			}
			if (isset($requestParams['createEndDate']) && $requestParams['createEndDate'] != '') {
				$select->where("DATE(fr.createdDate) <=", $this->changeDateformat($requestParams['createEndDate']));
			}
		}
	}

	public function getloanInfoByCaseId($ref_id, $flag = "")
	{
		$this->db->select('lci.*,lcc.*,lc.mobile as cus_mobile,ca.customer_id as cust_id,mv.db_version as version_name,mm.make as make_name,mm.model as model_name,lem.bank_id as financer,c.bank_name as financer_name,lem.tag_flag,lmt.file_tag,ou.dealer_id as showroomId,d.organization as showroomName,ou.outlet_address,lem.file_loan_amount as file_amount,lem.approved_loan_amt,lem.disbursed_amount,lem.gross_net_amount,cdd.loan_amount, cdd.fee_disburse, cdd.other_disburse, cdd.total_emi,cdd.existing_disburse');
		$this->db->from('loan_customer_info as lci');
		$this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id', 'left');
		$this->db->join('crm_customers as lc', 'lc.id=lci.customer_id', 'left');
		$this->db->join('loan_customer_academic as ca', 'ca.customer_info_id = lcc.customer_loan_id', 'left');
		$this->db->join('crm_disbursal_distribution as cdd', 'cdd.case_id = lcc.customer_loan_id', 'left');
		$this->db->join('model_version as mv', 'lcc.versionId=mv.db_version_id', 'left');
		$this->db->join('make_model as mm', 'mv.model_id = mm.id', 'left');
		$this->db->join('loan_file_login_mapping as lem', 'lcc.customer_loan_id=lem.case_id and lem.status="1"', 'left');
		$this->db->join('loan_file_login_tags as lmt', 'lem.tag_flag=lmt.id', 'left');
		$this->db->join('crm_bank_list as c', 'lem.bank_id=c.id', 'left');
		$this->db->join('crm_dealers as d', 'd.id=lci.dealer_id', 'left');
		$this->db->join('crm_outlet as ou', 'ou.dealer_id=lci.dealer_id', 'left');
		$this->db->where('lem.ref_id', $ref_id);
		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query();die;
		return  $result;
	}

	public function getbookingInfoByslipno($booking_slip_no, $flag = "")
	{
		$this->db->select('ab.source,ab.dealer_id,d.organization as dealerName,u.name as execName,ab.emp_id,ab.booking_amount,ab.amount_paid_to,ab.showroom_id,dd.organization as showroomName,ab.customer_mobile,ab.customer_name,ab.customer_address,ab.make_id,ab.model_id,ab.version_id,ab.color,mv.db_version as version_name,mm.make as make_name,mm.model as model_name,ab.color as colorId,c.name as colorName,ou.outlet_address,ab.kind_attn');
		$this->db->from('crm_adv_booking as ab');
		$this->db->join('crm_dealers as d', 'd.id=ab.dealer_id', 'left');
		$this->db->join('crm_dealers as dd', 'dd.id=ab.showroom_id', 'left');
		$this->db->join('crm_outlet as ou', 'ou.dealer_id=ab.showroom_id', 'left');
		$this->db->join('crm_user as u', 'u.id=ab.emp_id', 'left');
		$this->db->join('model_version as mv', 'ab.version_id=mv.db_version_id', 'left');
		$this->db->join('make_model as mm', 'mv.model_id = mm.id', 'left');
		$this->db->join('colors as c', 'c.id=ab.color', 'left');
		$this->db->where('ab.booking_slip_no', $booking_slip_no);
		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query();die;
		return  $result;
	}

	public function getOrderDetailspdf($orderId)
	{
		$this->db->select('fd.deliverySource,fd.showroomAddress,fd.id,mmp.make as parentmakeName,mmp.model as parentmodelName,us.name as dName,u.name as salesName,fd.add_date,fd.application_no,fd.kind_attn,fd.customer_name,fd.customer_address,fd.loan_taken,fd.loan_filled,'
			. 'b.bank_name,mv.db_version as version_name,mm.make as make_name,mm.model as model_name,fd.do_no,fd.do_amt,fd.do_amt_word,'
			. 'fd.delivery_date,fd.exp_payment_date,fd.showroomName,fd.insurance,d.organization,dd.organization as dealerName,d.owner_mobile,fd.color,fd.showroom_disc,fd.scheme_disc,fd.ex_show,fd.tcs,fd.epc,fd.road_tax,fd.gross_do_amt,fd.showroom_discount,fd.scheme,fd.total_showroom_discount,fd.dshowroom_dis,fd.dscheme_dis,fd.total_dis_amount,fd.loan_amt,fd.dedu_loan,fd.margin_money,fd.net_do_amt,fd.do_date,fd.reg_type,fd.do_insu_premium, fd.do_external_warranty, cdd.fee_disburse, cdd.other_disburse, cdd.total_emi,cdd.existing_disburse, fd.margin_money_inhouse, fd.loan_taken_from');
		$this->db->from('crm_finance_delivery as fd');
		$this->db->join('model_version as mv', 'mv.db_version_id=fd.variant', 'left');
		$this->db->join('make_model as mm', 'mm.id=mv.model_id', 'left');
		$this->db->join('make_model as mmp', 'mmp.id=mm.parent_model_id', 'left');
		$this->db->join('crm_dealers as d', 'd.id=fd.showroomName and d.status="1"', 'left');
		$this->db->join('crm_dealers as dd', 'dd.id=fd.dealer_id and dd.status="1"', 'left');
		$this->db->join('crm_user as u', 'u.id=fd.deliverySales and u.status="1"', 'left');
		$this->db->join('crm_user as us', 'us.id=fd.deliveryTeam and us.status="1"', 'left');
		$this->db->join('crm_bank_list as b', 'b.id=fd.hp_to and b.status="1"', 'left');
		$this->db->join('loan_file_login_mapping as lflm', 'lflm.ref_id=fd.application_no', 'left');
		$this->db->join('crm_disbursal_distribution as cdd', 'cdd.case_id=lflm.case_id', 'left');



		$this->db->where('fd.id', $orderId);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $result = $query->result_array();
	}
	public function changeDateformat($date)
	{
		if ($date != '') {
			$date_array = explode('/', date($date));
			$date = trim($date_array[2]) . '-' . trim($date_array[1]) . '-' . trim($date_array[0]);
			// $date=date('Y-m-d',strtotime($date));  
		}
		return $date;
	}

	public function fileLoginTags()
	{
		$this->db->select('*');
		$this->db->from('loan_file_login_tags');
		$this->db->where('status', '1');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function getRto($id = '', $reg = '')
	{
		$this->db->select('*');
		$this->db->from('rto_city');
		if ($id > '0') {
			$this->db->where('id', $id);
		}
		if (!empty($reg)) {
			$this->db->like('Registration_Index', $reg, 'both');
		}
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function getRtoState($id = '', $reg = '')
	{
		$this->db->select('*');
		$this->db->from('rto_state');
		if ($id > '0') {
			$this->db->where('rto_id', $id);
		}
		if (!empty($reg)) {
			$this->db->like('rto_code', $reg, 'both');
		}
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function getRtoCentralCity($cntid)
	{
		$this->db->select('r.*,c.city_name as city,c.city_id');
		$this->db->from('rto_state as r');
		$this->db->join('city_list as c', 'c.central_city_id=r.central_city_id', 'left');
		if ($cntid > '0') {
			$this->db->where('r.rto_id', $cntid);
		}
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $result = $query->result_array();
	}

	public function getCityList($state_id)
	{
		$this->db->select('city_id,city_name,central_city_id');
		$this->db->from('city_list');
		$this->db->where('state_id', $state_id);
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function insertSmsLog($mobile, $smsText, $case_id, $bank_id, $smsType, $smsReason, $updated_id = '', $status = '0')
	{
		$caseInfo = [];
		if ($updated_id == '') {
			$caseInfo['case_id'] = (!empty($case_id) ? $case_id : '');
			$caseInfo['mobile'] = (!empty($mobile) ? $mobile : '');
			$caseInfo['sms_content'] = (!empty($smsText) ? $smsText : '');
			$caseInfo['bank_id'] = (!empty($bank_id) ? $bank_id : '');
			$caseInfo['sms_send_for'] = (!empty($smsType) ? $smsType : '');
			$caseInfo['sms_reason'] = (!empty($smsReason) ? $smsReason : '');
			$this->db->trans_start();
			$this->db->insert('crm_loan_sms_log', $caseInfo);
			$insert_id = $this->db->insert_id();
			$this->db->trans_complete();
			$result = $insert_id;
		} else {
			$this->db->where('id', $updated_id);
			$caseInfo['sms_status'] = $status;
			$this->db->update('crm_loan_sms_log', $caseInfo);
			$result = $updated_id;
		}
		//echo $this->db->last_query(); exit;
		return $result;
	}

	public function getSmsSent($case_id, $tag = '', $flag = '')
	{
		$this->db->select('*');
		$this->db->from('crm_loan_sms_log');
		$this->db->where('case_id', $case_id);
		if ((!empty($tag)) && (empty($flag))) {
			$this->db->where('sms_send_for', $tag);
		}
		if ((!empty($tag)) && (!empty($flag))) {
			$tags = explode(',', $tag);
			$this->db->where_in('sms_send_for', $tags);
		}
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function getCrmResidenceRelations()
	{
		$this->db->select('*');
		$this->db->from('crm_residence_relations');
		$this->db->where('show_list', '1');
		$this->db->where('status', '1');
		$query = $this->db->get();
		return $result = $query->result_array();
	}

	public function usedcarsalesid($id)
	{
		$this->db->select('usc.*,ldm.ldm_customer_id as customer_id,usc.id as case_id');
		$this->db->from('crm_used_car_sale_case_info as usc');
		$this->db->join('crm_buy_lead_dealer_mapper as ldm', 'usc.ldm_id=ldm.ldm_id', 'left');
		$this->db->where('usc.id', $id);
		$this->db->where('usc.status', '1');
		$query  = $this->db->get();
		$result = $query->row_array();
		return $result;
	}

	public function addLoanNetpayment($caseInfo, $updateId = '', $rc_id)
	{
		try {
			$result = "";
			if (!empty($rc_id)) {
				$rc_info = array("pending_from" => $caseInfo['rc_trans_by']);
				$this->db->where('rc_id', $rc_id);
				$res = $this->db->update('crm_rc_info', $rc_info);
			}
			if (empty($updateId)) {
				$this->db->insert('crm_net_payment', $caseInfo);
				$insert_id = $this->db->insert_id();
				$result = $insert_id;
			} else {
				$this->db->where('id', $updateId);
				$this->db->update('crm_net_payment', $caseInfo);
				$result = $updateId;
			}

			return $result;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	public function getPaymentInfoByCaseId($case_id)
	{
		$this->db->select('*');
		$this->db->from('crm_net_payment');
		$this->db->where('case_id', $case_id);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result[0];
	}

	public function checkduplicateCase($engineNo, $chasisNo, $loanId = false, $daycheck = false)
	{
		$this->db->select('lc.id as caseid');
		$this->db->from('loan_customer_case as lc');
		$this->db->where('lc.engine_number', $engineNo);
		$this->db->where('lc.chassis_number', $chasisNo);
		if ($daycheck) {
			$this->db->where('lc.created_date >= CURDATE() - INTERVAL ' . $daycheck . ' DAY  ');
			$this->db->where('lc.cancel_id=0');
		}
		if ($loanId)
			$this->db->where('lc.id NOT IN(' . $loanId . ')');
		$query = $this->db->get();
		// echo $this->db->last_query();die;
		$res = $query->result_array();
		if (!empty($res[0]['caseid'])) {
			if ($loanId) {
				$caseids =  array_reduce($res, function (&$new, $entry) {
					$new[] = $entry['caseid'];
					return $new;
				});
				return implode(',', $caseids);
			} else return true;
		} else {
			return false;
		}
		return $res;
	}

	public function updatePaymentInfoByCaseId($PaymentInfo, $case_id)
	{
		$laon_amount = $PaymentInfo['loan_amount'];
		$net_payment_short = !empty($PaymentInfo['loan_short']) ? $PaymentInfo['loan_short'] : "0";
		$net_processing_fee = !empty($PaymentInfo['processing_fee']) ? $PaymentInfo['processing_fee'] : "0";
		$net_total_emi = !empty($PaymentInfo['total_emi']) ? $PaymentInfo['total_emi'] : "0";
		$net_insurance = !empty($PaymentInfo['insuranace']) ? $PaymentInfo['insuranace'] : "0";
		$rc_trans_price = !empty($PaymentInfo['rc_trans_price']) ? $PaymentInfo['rc_trans_price'] : "0";
		$other_adjustment = !empty($PaymentInfo['other_adjustment']) ? $PaymentInfo['other_adjustment'] : "0";
		$total_loan = $laon_amount + $net_payment_short;
		$total_deduction = $net_processing_fee + $net_total_emi + $net_insurance + $rc_trans_price + $other_adjustment;
		//   echo $net_processing_fee ."++". $net_total_emi ."+++". $net_insurance ."++". $rc_trans_price ."+++". $other_adjustment;

		$net_payable_amount = $total_loan - $total_deduction;

		if ($PaymentInfo['net_amount'] === $net_payable_amount) {
			$caseInfo = array('net_amount' => $net_payable_amount);
			$this->db->where('case_id', $updateId);
			$this->db->update('crm_net_payment', $caseInfo);
		}
		return $net_payable_amount;
	}

	public function getClearanceamount($case_id)
	{
		$this->db->select('sum(amount) as sum_amount');
		$this->db->from('crm_loan_part_payment');
		$this->db->where('entry_type', 2);
		$this->db->where('case_id ', $case_id);
		$query = $this->db->get();
		$result = $query->row_array();
		return  $result['sum_amount'];
	}

	public function getOutstandingAmount($case_id)
	{
		$left_amount = $net_payable_amount = $net_clearance_amount = 0;
		$PaymentInfo = $this->getPaymentInfoByCaseId($case_id);
		$left_amount = $net_payable_amount = $PaymentInfo['net_amount'];

		$net_payable_amount = $this->updatePaymentInfoByCaseId($PaymentInfo, $case_id);

		$net_clearance_amount = $this->getClearanceamount($case_id);
		if ($net_payable_amount > 0 && $net_clearance_amount >= 0)
			$left_amount = $net_payable_amount - $net_clearance_amount;

		if ($left_amount == 0 && $net_payable_amount > 0)
			$left_amount = 1;
		else
			$left_amount = 0;

		return $left_amount;
	}

	public function getDealerAdmin()
	{
		$this->db->select('loan_bank_limit');
		$this->db->from('crm_admin_dealers');
		$this->db->where('dealer_id', DEALER_ID);
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		$result = $query->row_array();
		//  echo "<pre>+++++";print_r($result);die;
		return  $result['loan_bank_limit'];
	}
	public function getExShowprice($versionId)
	{
		$this->db->select('o.ex_showroom');
		$this->db->from('technical_specifications as t');
		$this->db->join('orp_price_actual as o', 't.id=o.technical_specification_id', 'inner');
		$this->db->where('t.version_id', $versionId);
		$query  = $this->db->get();
		$result = $query->row_array();
		return $result;
	}

	public function doShowroomDiscount($receiptInfo, $updateId = '')
	{
		if (empty($updateId)) {
			$this->db->trans_start();
			$this->db->insert('do_showroom_discount', $receiptInfo);
			$insert_id = $this->db->insert_id();
			$this->db->trans_complete();
			$result = $insert_id;
		} else {
			$this->db->where('id', $updateId);
			$this->db->update('do_showroom_discount', $receiptInfo);
			$result = $updateId;
		}
		return $result;
	}
	public function doDiscountShared($receiptInfo, $updateId = '')
	{
		if (empty($updateId)) {
			$this->db->trans_start();
			$this->db->insert('do_discount_shared', $receiptInfo);
			$insert_id = $this->db->insert_id();
			$this->db->trans_complete();
			$result = $insert_id;
		} else {
			$this->db->where('id', $updateId);
			$this->db->update('do_discount_shared', $receiptInfo);
			$result = $updateId;
		}
		return $result;
	}
	public function doPriceBreakup($receiptInfo, $updateId = '')
	{
		if (empty($updateId)) {
			$this->db->trans_start();
			$this->db->insert('do_price_breakup', $receiptInfo);
			$insert_id = $this->db->insert_id();
			$this->db->trans_complete();
			$result = $insert_id;
		} else {
			$this->db->where('id', $updateId);
			$this->db->update('do_price_breakup', $receiptInfo);
			$result = $updateId;
		}
		// echo $this->db->last_query(); exit;
		return $result;
	}

	public function selectPriceBreakup($do_id)
	{
		$this->db->select('*');
		$this->db->from('do_price_breakup');
		$this->db->where('status', '1');
		$this->db->where('do_id', $do_id);
		$query = $this->db->get();
		return $result = $query->result_array();
	}
	public function selectDiscountShared($do_id)
	{
		$this->db->select('*');
		$this->db->from('do_discount_shared');
		$this->db->where('status', '1');
		if (!empty($do_id)) {
			$this->db->where('do_id', $do_id);
		}
		$query = $this->db->get();
		return $result = $query->result_array();
	}
	public function selectShowroomDiscount($do_id)
	{
		$this->db->select('*');
		$this->db->from('do_showroom_discount');
		$this->db->where('status', '1');
		if (!empty($do_id)) {
			$this->db->where('do_id', $do_id);
		}
		$query = $this->db->get();
		return $result = $query->result_array();
	}
	public function selectDoPartpayment($id = '', $type = '', $flag = '', $case_id)
	{
		$this->db->select('*');
		$this->db->from('crm_do_part_payment');
		if (!empty($id))
			$this->db->where('id', $id);
		if (!empty($type))
			$this->db->where('entry_type', $type);
		if ($flag == '1') {
			$this->db->where('created_by not in (1)');
		}
		$this->db->where('case_id', $case_id);
		$query = $this->db->get();
		$result = $query->result_array();
		//  echo $this->db->last_query(); exit;
		return  $result;
	}

	public function addDoPartpayment($caseInfo, $updateId = '')
	{
		if (empty($updateId)) {
			$this->db->insert('crm_do_part_payment', $caseInfo);
			$insert_id = $this->db->insert_id();
			$result = $insert_id;
		} else {
			$this->db->where('id', $updateId);
			$this->db->update('crm_do_part_payment', $caseInfo);
			$result = $updateId;
		}
		//echo $this->db->last_query(); exit; 
		return $result;
	}

	public function doCancelReason($id = '')
	{
		$this->db->select('*');
		$this->db->from('do_cancel_reason');
		if (!empty($id))
			$this->db->where('id', $id);
		$this->db->where('status', '1');
		$query = $this->db->get();
		$result = $query->result_array();
		return  $result;
	}

	public function updateDoCancelReason($do_id, $cancel_id, $othertext = '', $id = '')
	{
		$doInfo = [];
		$doInfo['cancel_id'] = $cancel_id;
		$this->db->where('id', $do_id);
		$this->db->update('crm_finance_delivery', $doInfo);
		if (($cancel_id == '1') && (empty($id))) {
			$docancel = [];
			$docancel['do_id'] = $do_id;
			$docancel['other_reason'] = $othertext;
			$this->db->insert('do_cancel_other_reason', $docancel);
			$insert_id = $this->db->insert_id();
			// $result = $insert_id;
		} else if (($cancel_id == '1') && (!empty($id))) {
			$doInfo = [];
			$doInfo['cancel_id'] = $othertext;
			$this->db->where('do_id', $do_id);
			$this->db->update('do_cancel_other_reason', $doInfo);
		}

		// echo $this->db->last_query(); exit;
		return $do_id;
	}
	function  getMappingInfoByCaseId($case_id, $id)
	{
		$this->db->select('*');
		$this->db->from('loan_file_login_mapping');
		$this->db->where('case_id', $case_id);
		$this->db->where('status', '1');
		$this->db->where('tag_flag != 3');
		$this->db->where('id !=' . $id);
		$query = $this->db->get();
		$result = $query->result_array();
		return  $result;
	}
	public function getFileTags()
	{
		$this->db->select('id,file_tag');
		$this->db->from('loan_file_login_tags');
		$this->db->where('status', '1');
		$query = $this->db->get();
		$result = $query->result();
		$status = array();
		foreach ($result as $res) {
			$status[$res->id] =  $res->file_tag;
		}
		return  $status;
	}
	public function getStateDetails($state)
	{
		$this->db->select('*');
		$this->db->from('state_list');
		$this->db->where('state_list_name', $state);
		$query = $this->db->get();
		$result = $query->result_array();
		return  $result;
	}


	public function getOrderleadsDataByid($orderId, $flag = '')
	{
		if (!empty($orderId)) {
			$this->db->select('fd.dealer_id,fd.margin_money_inhouse,fd.include_margin_money_cus,fd.include_margin_money_in,fd.include_dis_shared,fd.deliverySource,fd.deliveryTeam,fd.deliverySales,fd.do_date,fd.loan_taken,fd.application_no,fd.do_no,fd.do_amt,fd.do_amt_word,fd.showroomName,fd.showroomAddress,fd.kind_attn,fd.showroom_disc,fd.scheme_disc,fd.delivery_date,fd.delivery_date,fd.loan_taken_from,'
				. 'fd.exp_payment_date,fd.customer_mobile_no,fd.customer_name,fd.customer_address,fd.make,fd.model,fd.variant,fd.color,fd.reg_req,fd.hp_to,fd.booking_date,fd.status,fd.add_date,fd.update_date,fd.last_updated_status,fd.last_updated_date,'
				. 'fr.paymentType,fr.paymentBy,fr.intrumentType,fr.instrumentNo,fr.creditAmt,fr.creditDate,fr.favouring,fr.drawnOn,fr.receiptDate,fr.createdDate,fd.hp_to,'
				. 'mm.make as makeName,mm.model as modelName,mv.db_version as versionName,d.organization,d.organization as dealerName,u.name as employeeName,'
				. 'fd.id as orderId,fd.loan_filled,fd.booking_done,fd.booking_slip_no,fd.new_car_price,fd.insurance,fd.do_status,fd.gross_do_amt,fd.ex_show,fd.tcs,fd.epc,fd.road_tax,fd.showroom_discount,fd.scheme,fd.total_showroom_discount,fd.total_dis_amount,fd.loan_amt,fd.dedu_loan,fd.margin_money,fd.net_do_amt,fd.sameas,fd.sameasloan,fd.dshowroom_dis,fd.dscheme_dis,cdp.entry_type,cdp.id as ppid,cdp.bank_id as pbank_id,cdp.payment_by,cdp.case_id,cdp.payment_date,cdp.payment_mode,cdp.favouring_to,cdp.amount,cdp.instrument_no,cdp.instrument_date,cdp.bank_name,cdp.pay_remark,cdp.created_by,fd.reg_type,fd.insu_premium,fd.cancel_id,doca.other_reason,dor.reason,mmp.make as parentmakeName,mmp.model as parentmodelName');

			$this->db->from('crm_finance_delivery as fd');
			$this->db->join('crm_finance_receipt as fr', 'fr.orderId=fd.id', 'left');
			$this->db->join('crm_do_part_payment as cdp', 'cdp.case_id=fd.id', 'left');
			$this->db->join('do_cancel_other_reason as doca', 'doca.do_id=fd.id', 'left');
			$this->db->join('do_cancel_reason as dor', 'dor.id=fd.cancel_id', 'left');
			$this->db->join('model_version as mv', 'mv.db_version_id=fd.variant', 'left');
			$this->db->join('make_model as mm', 'mm.id=mv.model_id', 'left');
			$this->db->join('make_model as mmp', 'mmp.id=mm.parent_model_id', 'left');
			$this->db->join('crm_dealers as d', 'd.id=fd.showroomName and d.status="1"', 'left');
			$this->db->join('crm_user as u', 'u.id=fd.deliveryTeam and u.status="1"', 'left');
			$this->db->where('fd.id', $orderId);
			if ($flag == 'group') {
				$this->db->group_by('fd.id');
			}
			$query = $this->db->get();
			//echo $this->db->last_query(); exit;
			return $result = $query->result_array();
		} else {
			return false;
		}
	}


	public function getloanInfoByRefid($ref_id = '', $flag = "", $bankflag = '', $orderId = '')
	{
		if (empty($bankflag)) {
			$this->db->select('lem.bank_id as financer,c.bank_name as financer_name,cdd.loan_amount, cdd.disburse_emi, lem.disbursed_roi, lem.disbursed_tenure, lem.disbursed_amount, lem.file_loan_amount, lem.file_tenure,lem.file_roi,lem.approved_loan_amt,lem.approved_tenure,lem.approved_roi,lem.approved_emi');
			$this->db->from('loan_file_login_mapping as lem');
			$this->db->join('crm_disbursal_distribution as cdd', 'cdd.case_id = lem.case_id', 'left');
			$this->db->join('crm_bank_list as c', 'lem.bank_id=c.id', 'left');
			$this->db->where('lem.ref_id', $ref_id);
			$this->db->where('lem.status', "1");
		} else {
			$this->db->select('c.bank_name as financer_name,c.bank_id as financer');
			$this->db->from('crm_finance_delivery as do');
			$this->db->join('crm_customer_banklist as c', 'do.hp_to=c.bank_id', 'left');
			$this->db->where('do.id', $orderId);
		}
		$query = $this->db->get();
		$result = $query->result_array();
		return  $result;
	}

	public function sumofDoPartpayment($flag = '', $case_id, $paymentby = '', $type = '')
	{
		//$this->db->select('*');
		$this->db->select('sum(amount) as sum_amount');
		$this->db->from('crm_do_part_payment');
		if (!empty($type))
			$this->db->where('entry_type', $type);
		if ($flag == '1') {
			$this->db->where('created_by not in (1)');
		}
		if (!empty($paymentby)) {
			$this->db->where('payment_by', $paymentby);
		}
		$this->db->where('case_id', $case_id);
		// $this->db->or_where('lcc.loan_approval_status','5');
		$query = $this->db->get();
		$result = $query->result_array();
		//  echo $this->db->last_query(); exit;
		return  $result;
	}

	public function getData($tbl, $column, $con, $con1 = '', $con2 = '')
	{
		$this->db->select($column);
		$this->db->from($tbl);
		$this->db->where($con);
		if ($con1 != '' && $con2 != '') {
			$this->db->or_where($con1);
			$this->db->where($con2);
			$query = $this->db->get();
			$result = $query->result();
			return  $result;
		}
		$query = $this->db->get();
		$result = $query->row_array();
		return  $result;
	}
	public function getBankWiseLoanHistoryReport($flag = '', $bank_id)
	{
		$where = '';
		$this->db->select("COUNT(distinct CASE WHEN (l.activity like '%Loan Expected%') THEN l.id ELSE null END ) Added,COUNT(distinct CASE WHEN (l.activity like '%Filed%') THEN l.id ELSE null END ) Filed,
          COUNT(distinct CASE WHEN (l.activity like '%Approved%') THEN l.id ELSE null END ) Approved,
          COUNT(distinct CASE WHEN (l.activity like '%Disbursed%') THEN l.id ELSE null END ) Disbursed");
		$this->db->where(array('l.status' => '1', 'l.action' => 'Add', 'l.bank_id' => $bank_id, 'date(l.updated_at)' => date('Y-m-d')));
		if ($flag == '1') {
			$where = " lcc.loan_for in ('1','2') and lcc.loan_type='Purchase'";
			$this->db->where($where);
		}
		if ($flag == '2') {
			$where = " lcc.loan_for in ('2') and lcc.loan_type not in ('Purchase')";
			$this->db->where($where);
		}
		$this->db->from('loan_history_log as l');
		$this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=l.case_id', 'left');
		$this->db->order_by('l.id', 'desc');
		$query  = $this->db->get();
		//  echo  $this->db->last_query(); exit;
		$result = $query->result_array();
		return $result;
	}



	public function getEmpWiseLoanHistoryReport($flag = '', $emp)
	{
		$where = '';
		$this->db->select("COUNT(distinct CASE WHEN (l.activity like '%Loan Expected%') THEN l.id ELSE null END ) Added,COUNT(distinct CASE WHEN (l.activity like '%Filed%') THEN l.id ELSE null END ) Filed,
          COUNT(distinct CASE WHEN (l.activity like '%Approved%') THEN l.id ELSE null END ) Approved,
          COUNT(distinct CASE WHEN (l.activity like '%Disbursed%') THEN l.id ELSE null END ) Disbursed");
		$this->db->where(array('l.status' => '1', 'l.action' => 'Add', 'l.created_by' => $emp, 'date(l.updated_at)' => date('Y-m-d')));
		if ($flag == '1') {
			$where = " lcc.loan_for in ('1','2') and lcc.loan_type='Purchase'";
			$this->db->where($where);
		}
		if ($flag == '2') {
			$where = " lcc.loan_for in ('2') and lcc.loan_type not in ('Purchase')";
			$this->db->where($where);
		}
		$this->db->from('loan_history_log as l');
		$this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=l.case_id', 'left');
		$this->db->order_by('l.id', 'desc');
		$query  = $this->db->get();
		//  echo  $this->db->last_query(); exit;
		$result = $query->result_array();
		return $result;
	}

	public function getCoapplicantDataByCaseId($caseId)
	{
		$this->db->select('*');
		$this->db->from('loan_coapplicant_detail');
		$this->db->where('case_id', $caseId);
		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query(); exit;
		return  $result;
	}

	public function getGuarantorDataByCaseId($caseId)
	{
		$this->db->select('*');
		$this->db->from('loan_guarantor_detail');
		$this->db->where('case_id', $caseId);
		$query = $this->db->get();
		$result = $query->result_array();
		//  echo $this->db->last_query(); exit;
		return  $result;
	}
}
