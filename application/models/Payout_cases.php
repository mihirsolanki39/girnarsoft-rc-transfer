<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payout_cases extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getPayoutAllCaseInfo($params) {
        $rpp = 10;
        $perPageRecord = $rpp == 0 ? 10 : $rpp;
        $pageNo = (isset($params['pages']) && $params['pages'] != '') ? $params['pages'] : '1';
        $startLimit = ($pageNo - 1) * $perPageRecord;

        if ($params['is_count'] == 0) {
            $this->db->select('lcc.reg_year,lcc.regno,lcc.id as sr_no,lci.customer_id,lci.Buyer_Type,lci.name,lci.email,lci.source_type,'
                    . 'lci.dealer_id,lci.meet_the_customer,lci.dealt_by,lci.assign_case_to,lci.residence_address,'
                    . 'lcc.customer_loan_id,lcc.loan_for,lcc.loan_type,lcc.loan_approval_status,'
                    . 'lcc.makeId,lcc.modelId,lcc.versionId,lcc.regno,lcc.tag_status,lcc.created_date,lcc.updated_date,'
                    . 'lcc.upload_login_doc_flag,lcc.upload_docs_created_at,lcc.upload_login_update_date,'
                    . 'lcc.upload_dis_doc_flag,lcc.upload_dis_created_date,lcc.upload_disburse_doc_update,lcc.cancel_id,'
                    . 'lcc.cancel_date,lcc.last_updated_date,lcc.reopen_date,ca.customer_id as cust_id,'
                    . 'mv.db_version as version_name,mm.make as make_name,mm.model as model_name,'
                    . 'lem.file_loan_amount as loan_amt,lem.file_roi as roi,lem.file_tenure as tenor,'
                    . 'lem.bank_id as financer,c.bank_name as financer_name,ref.ref_name_one as ref_name_one,'
                    . 'lem.tag_flag,lem.valuation_status as valuationstatus,lem.cpv_status as cpvstatus,'
                    . 'lmt.file_tag,postdel.invoice_no,paydel.instrument_type,cblm.mobile as customer_mobile,'
                    . 'cblm.created_date as customer_created_on,cl.city_name as customer_city,lmt.priority,'
                    . 'lem.disbursed_amount,lem.disbursed_tenure,lem.disbursed_roi,lem.file_loan_amount,lem.file_tenure,'
                    . 'lem.file_roi,lem.valuation_status,lem.cpv_status,lem.approved_loan_amt,lem.approved_tenure,'
                    . 'lem.approved_roi,lem.approved_emi,lem.ref_id,lem.file_login_date,lem.approved_date,lem.rejected_date,'
                    . 'lem.disbursed_date,cbin.bank_branch as bnkIf,crmd.organization,crmu.name as assigned_to,'
                    . 'cpm.payout_id,cpm.date_time as payout_date,cpm.payout_id,'
                    . 'lflt.file_tag,lci.meet_the_customer,crmus.name as sales_executive');
        } else if ($params['is_count'] == 1) {
            $this->db->select('lcc.id as sr_no');
        }
        $this->db->from('loan_customer_info as lci');
        $this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id', 'left');
        $this->db->join('loan_customer_academic as ca', 'ca.customer_id = lci.customer_id', 'left');
        $this->db->join('model_version as mv', 'lcc.versionId=mv.db_version_id', 'left');
        $this->db->join('make_model as mm', 'mv.model_id = mm.id', 'left');
        $this->db->join('loan_file_login_mapping as lem', 'lcc.customer_loan_id=lem.case_id and lem.status="1"', 'left');
        $this->db->join('loan_file_login_tags as lmt', 'lem.tag_flag=lmt.id', 'left');
        $this->db->join('crm_bank_list as c', 'lem.bank_id=c.id', 'left');
        $this->db->join('loan_customer_reference_info as ref', 'lcc.customer_loan_id = ref.customer_case_id', 'left');
        $this->db->join('loan_post_delivery_details as postdel', 'postdel.case_id = ref.customer_case_id', 'left');
        $this->db->join('loan_payment_details as paydel', 'paydel.case_id = ref.customer_case_id', 'left');
        $this->db->join('crm_customers as cblm', 'cblm.id=lci.customer_id', 'inner');
        $this->db->join('city_list as cl', 'cl.city_id=lci.residence_city', 'left');
        $this->db->join('crm_customer_bank_info as cbin', 'cbin.case_id=lcc.customer_loan_id', 'left');
        $this->db->join('loan_file_login_tags as lflt', 'lflt.id=lcc.loan_approval_status', 'left');
        $this->db->join('crm_dealers as crmd', 'crmd.id=lci.dealer_id', 'left');
        $this->db->join('crm_user as crmu', 'crmu.id=lci.assign_case_to  AND crmu.status = "1"', 'left');
        $this->db->join('crm_user as crmus', 'crmus.id=lci.meet_the_customer  AND crmu.status = "1"', 'left');
        $this->db->join('crm_case_payout_mapping as cpm', 'cpm.case_id=lcc.customer_loan_id AND cpm.status=1', 'left');

        $this->db->where('lcc.customer_loan_id>"1"');
        $this->db->where('lem.tag_flag', '4');
        $this->db->where('lcc.loan_approval_status not in (9,6)');
        $this->db->where('lci.source_type', 1);
        $this->db = $this->getSearchQuery($params, $this->db);
        $this->db->group_by('lcc.customer_loan_id');
        $this->db->order_by('lcc.last_updated_date', 'desc');
        $this->db->order_by('lmt.priority', 'desc');
        if ($params['is_count'] == 0) {
            if (isset($params['pages'])) {
                $this->db->offset((int) ($startLimit));
            }
            if (!empty($perPageRecord)) {
                $this->db->limit((int) $perPageRecord);
            }
        }
        $query = $this->db->get();
        $result = $query->result_array();
        if ($params['is_count'] == 1) {
            $result = count($result);
        }
        return $result;
    }

    public function getSearchQuery($param, $select) {
        if ((!empty($param['searchbyvaldealer'])) && (!empty($param['searchby']))) {
            if ($param['searchby'] == 'searchdealer') {
                $searchByDealer = 'lci.dealer_id';
                $select->where($searchByDealer, $param['searchbyvaldealer']);
            }            
        }
        if ((!empty($param['searchbyvalbank'])) && (!empty($param['searchby']))) {
            if ($param['searchby'] == 'searchbank') {
                $searchByDealer = 'lem.bank_id';
                $select->where($searchByDealer, $param['searchbyvalbank']);
                $select->where('lem.status', '1');
            }
        }
        if ((!empty($param['searchby'])) && (!empty($param['searchbyval'])) && $param['searchby'] != 'searchdealer') {
            if ($param['searchby'] == 'searchmobile') {
                $select->where('cblm.mobile', $param['searchbyval']);
            }
            if ($param['searchby'] == 'searchcase') {
                $select->where('lem.ref_id', $param['searchbyval']);
            }
            if ($param['searchby'] == 'searchserialno') {
                $select->where('lcc.id', $param['searchbyval']);
            }

            if ($param['searchby'] == 'searchreg') {
                $select->where('lcc.regno', $param['searchbyval']);
            }

            if ($param['searchby'] == 'searchcustname') {
                $select->where('lci.name like "%' . $param['searchbyval'] . '%"');
            }
            if ($param['searchby'] == 'searchpayout') {
                $select->where('cpm.payout_id', $param['searchbyval']);
            }
        }
        if ((!empty($param['loan_status']))) {

            if ($param['loan_status'] == '4') {
                $select->where('lem.tag_flag', '4');
                $select->where('lcc.loan_approval_status', '4');
            }
            if ($param['loan_status'] == '8') {
                $select->where('lcc.loan_approval_status', '8');
            }
        }
        if ((!empty($param['payout_status']))) {
            if ($param['payout_status'] == '1' || $param['tab'] == 3) {
                $select->where('cpm.payout_id is null');
            }
            if ($param['payout_status'] == '2') {
                $select->where('cpm.payout_id is not null');
            }
        }
        if (!empty($param['searchdate'])) {
            //echo $searchdate; exit;
            if ($param['searchdate'] == 'disdocdate') {
                $searchedDate = 'lem.disbursed_date';
            }
            if ($param['searchdate'] == 'rejectdate') {
                $searchedDate = 'lem.rejected_date';
            }
            if ($param['searchdate'] == 'approvedate') {
                $searchedDate = 'lem.approved_date';
            }
            if ($param['searchdate'] == 'fileddate') {
                $searchedDate = 'lem.file_login_date';
            }
            if ($param['searchdate'] == 'casedate') {
                $searchedDate = 'lcc.created_date';
            }
            if (!empty($param['daterange_to'])) {
                $to = date('Y-m-d', strtotime($param['daterange_to']));
                $where = "DATE(" . $searchedDate . ")";
                $select->where($where . '>=', $to);
            }
            if (!empty($param['daterange_from'])) {
                $from = date('Y-m-d', strtotime($param['daterange_from']));
                $where = "DATE(" . $searchedDate . ")";
                $select->where($where . '<=', $from);
            }
        }
        if (!empty($param['status'])) {
            $stat = explode('_', $param['status']);
            $select->where('lcc.loan_type', $stat[1]);
            $select->where('lcc.loan_for', $stat[0]);
        }
        if (!empty($param['assignedto'])) {
            $select->where('lci.assign_case_to', $param['assignedto']);
        }
        return $select;
    }

    public function getPayoutCaseDealerWise($params) {
        if(!empty($params['editid']))
            $or = "OR cpm.payout_id =". $params['editid'];
        else
        {
            $or = "OR cpm.status =0";            
        }
        $this->db->select('lcc.reg_year,lcc.regno,lcc.id as sr_no,lcc.customer_loan_id,lci.name,lci.email,lcc.makeId,lcc.modelId,lcc.versionId,'
                . 'lcc.regno,mv.db_version as version_name,mm.make as make_name,mm.model as model_name,'
                . 'lem.bank_id as financer,c.bank_name as financer_name,cblm.mobile as customer_mobile,'
                . 'lem.approved_loan_amt,lem.file_loan_amount as loan_amt,lem.disbursed_amount,lem.approved_tenure,lcc.loan_for,lcc.loan_type,'
                . 'lem.approved_roi,cdd.total_emi as approved_emi,lem.disbursed_date,crmd.organization,'
                . 'cdd.payout,ri.pending_from,ri.rc_status,cpm.payout_id,cnp.payout as net_payout,cpm.payout as final_payout,cdd.loan_amount'
        );

        $this->db->from('loan_customer_info as lci');
        $this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id', 'left');
        $this->db->join('model_version as mv', 'lcc.versionId=mv.db_version_id', 'left');
        $this->db->join('make_model as mm', 'mv.model_id = mm.id', 'left');
        $this->db->join('loan_file_login_mapping as lem', 'lcc.customer_loan_id=lem.case_id and lem.status="1"', 'left');
        $this->db->join('loan_file_login_tags as lmt', 'lem.tag_flag=lmt.id', 'left');
        $this->db->join('crm_bank_list as c', 'lem.bank_id=c.id', 'left');
        $this->db->join('crm_customers as cblm', 'cblm.id=lci.customer_id', 'inner');
        $this->db->join('loan_file_login_tags as lflt', 'lflt.id=lcc.loan_approval_status', 'left');
        $this->db->join('crm_dealers as crmd', 'crmd.id=lci.dealer_id', 'left');
        $this->db->join('crm_user as crmu', 'crmu.id=lci.assign_case_to  AND crmu.status = "1"', 'left');
        $this->db->join('crm_disbursal_distribution as cdd', 'cdd.case_id = lcc.customer_loan_id', 'left');
        $this->db->join('crm_rc_listing as rc', 'rc.loan_sno = lcc.id', 'left');
        $this->db->join('crm_rc_info as ri', 'ri.rc_id = rc.id', 'left');
        $this->db->join('crm_case_payout_mapping as cpm', "cpm.case_id=lcc.customer_loan_id", 'left');
        $this->db->join('crm_net_payment as cnp', 'cnp.case_id=lcc.customer_loan_id', 'left');
        $this->db->where('lcc.customer_loan_id>"1"');
           $this->db->where("(cpm.payout_id is null ".$or.")");
        $this->db->where('lem.tag_flag', '4');
        $this->db->where('lci.source_type', 1);
        $this->db->where('lcc.loan_approval_status not in (9,6)');
        $this->db->where('crmd.id', $params['dealer_id']);
        if (!empty($params['case_type_id'])) {
            $stat = explode('_', $params['case_type_id']);
            $this->db->where('lcc.loan_type', $stat[1]);
            $this->db->where('lcc.loan_for', $stat[0]);
        }
        $this->db->group_by('lcc.customer_loan_id');
        if(!empty($params['editid'])){
            $this->db->order_by('cpm.update_date', 'desc');
        }else{
            $this->db->order_by('lcc.last_updated_date', 'desc');
            $this->db->order_by('lmt.priority', 'desc');
        }
        $query = $this->db->get();
       // echo $this->db->last_query();die;
        $result = $query->result_array();
        return $result;
    }

    public function savePayout($data, $updateId = "") {
        if (empty($updateId)) {
            $this->db->trans_start();
            $this->db->insert('crm_payout', $data);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
        } else {
            $this->db->where('id', $updateId);
            $this->db->update('crm_payout', $data);
            $result = $updateId;
        }

        //echo $this->db->last_query(); exit;
        return $result;
    }

    public function savePayoutCaseMapping($mapping_data,$id = "") {
        $return = 0;
        if (!empty($mapping_data) && empty($id)) {
            $this->db->trans_start();
            $res = $this->db->insert_batch('crm_case_payout_mapping', $mapping_data);
            $this->db->trans_complete();
            $result = $res;
            if ($this->db->affected_rows() > 0)
                $return = 1;
        }else if(!empty($id)){
            $this->db->trans_start();
            $this->db->where('case_id', $id);
            $res = $this->db->update('crm_case_payout_mapping', $mapping_data);
            $this->db->trans_complete();
            $result = $res;
            if ($this->db->affected_rows() > 0)
                $return = 1;
        }
        return $return;
    }
    
    public function getPayoutHistory($param){
        $rpp = 10;
        $perPageRecord = $rpp == 0 ? 10 : $rpp;
        $pageNo = (isset($param['pages']) && $param['pages'] != '') ? $param['pages'] : '1';
        $startLimit = ($pageNo - 1) * $perPageRecord;
        
        if ($params['is_count'] == 0) {
         $this->db->select('cp.id as payment_id,cp.payment_date,cpm.id as payid,crmd.organization,cp.amount,cp.date_time,cp.payment_mode,'
                 . 'cp.instrument_date,cp.instrument_no,cp.bank_name,cp.pay_remark,cp.tds_amount,cp.gst_amount,cp.pdd_charge_total'
        );
        } else if ($params['is_count'] == 1) {
            $this->db->select('cp.id as payment_id');
        }
        $this->db->from('crm_payout as cp');
        $this->db->join('crm_dealers as crmd', 'crmd.id=cp.dealer_id', 'inner');
        $this->db->join('crm_case_payout_mapping as cpm', 'cpm.payout_id=cp.id', 'left');
        $this->db->join('loan_customer_case as lcc', 'lcc.id=cpm.sr_no', 'left');
        $this->db = $this->getPayoutSearchQuery($param, $this->db);
        $this->db->group_by('cp.id');
        $this->db->order_by('cp.update_date', 'desc');
      //  echo $param['pages'];
        if ($param['is_count'] == 0) {
            if (isset($param['pages'])) {
            //    echo "Asas";die;
                $this->db->offset((int) ($startLimit));
            }
            if (!empty($perPageRecord)) {
                $this->db->limit((int) $perPageRecord);
            }
        }

        $query = $this->db->get();
        // echo $this->db->last_query();die;
        $result = $query->result_array();
        if ($param['is_count'] == 1) {
            $result = count($result);
        }
        return $result; 
    }
    
    public function getPayoutSearchQuery($param, $select) {
        if (!empty($param['searchby']) && $param['searchby'] == "searchdealer") {
           $select->where('cp.dealer_id', $param['searchbyvaldealer']);
        }
        if ((!empty($param['searchby'])) && (!empty($param['searchbyval'])) && $param['searchby'] != 'searchdealer') {
            if (!empty($param['searchby']) && $param['searchby'] == "searchdealer") {
                $select->where('cp.dealer_id', $param['searchbyvaldealer']);
            }
            if ($param['searchby'] == 'searchserialno') {
                $select->where('lcc.id', $param['searchbyval']);
            }
            if ($param['searchby'] == 'searchpayout') {
                $select->where('cp.id', $param['searchbyval']);
            }
            if ($param['searchby'] == 'searchInstrument') {
                $select->where('cp.instrument_no', $param['searchbyval']);
            }
        }
        if (!empty($param['daterange_to'])) {
            $to = date('Y-m-d', strtotime($param['daterange_to']));
            $where = "DATE(cp.date_time)";
            $select->where($where . '>=', $to);
        }
        if (!empty($param['daterange_from'])) {
            $from = date('Y-m-d', strtotime($param['daterange_from']));
            $where = "DATE(cp.date_time)";
            $select->where($where . '<=', $from);
        }

        return $select;
    }
    
    public function getPaymentDetails($id){
       $this->db->select('*');
       $this->db->from('crm_payout as cp');
       $this->db->where('cp.id',$id);

        $query = $this->db->get();
       //echo $this->db->last_query();die;
        $result = $query->row_array();
        return $result; 
    }
    
    public function getPayoutCaseIDs($id,$flag=""){
        //echo "aaaa";die;
       $this->db->select('case_id');
       $this->db->from('crm_case_payout_mapping as cpm');
       $this->db->where('cpm.payout_id',$id);
       if($flag != 1)
            $this->db->where('cpm.status',"1");
        $query = $this->db->get();
        $result = $query->result_array();
        $new = array();
        foreach($result as $res){
           $new[] =  $res['case_id'];
        }
          return $new; 
    }
      public function addPayoutHistoryUpdateLog($data)
    {
        $this->db->insert('payout_history_update_log', $data);
        $insert_id = $this->db->insert_id();
        return $result = $insert_id;
    }
    public function addPayoutHistory($data)
    {
        $this->db->insert('payout_history_log', $data);
        $insert_id = $this->db->insert_id();
        return $result = $insert_id;
    }
    public function getPayoutdetailsCaseIDs($id){
       $this->db->select('*');
       $this->db->from('crm_case_payout_mapping as cpm');
       $this->db->where('cpm.status',"1");
       $this->db->where('cpm.case_id',$id);
       $query = $this->db->get();
       $result = $query->row_array();       
       return $result; 
    }
    public function getDealers($id="",$type='0',$flag='',$status=''){
       $this->db->select('id,owner_name as name,dealership_email as email,organization,payment_favoring');
       $this->db->from('crm_dealers');       
       if(empty($status)){
             $this->db->where('status', '1');
       }
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     

    }
    
    public function getCaseInfoById($id){
        $this->db->select('lcc.reg_year,lcc.regno,lcc.id as sr_no,lcc.customer_loan_id,lci.name,lci.email,lcc.makeId,lcc.modelId,lcc.versionId,'
                . 'lcc.regno,mv.db_version as version_name,mm.make as make_name,mm.model as model_name,lem.ref_id,'
                . 'lem.bank_id as financer,c.bank_name as financer_name,cblm.mobile as customer_mobile,'
                . 'lem.approved_loan_amt,lem.file_loan_amount as loan_amt,lem.disbursed_amount,lem.approved_tenure,lcc.loan_for,lcc.loan_type,'
                . 'lem.approved_roi,cdd.total_emi as approved_emi,lem.disbursed_date,crmd.organization,cdd.loan_amount,'
                . 'cdd.payout,ri.pending_from,ri.rc_status,cpm.payout_id,cnp.payout as net_payout,cpm.payout as final_payout,cpm.payment_amount'
        );

        $this->db->from('loan_customer_info as lci');
        $this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id', 'left');
        $this->db->join('model_version as mv', 'lcc.versionId=mv.db_version_id', 'left');
        $this->db->join('make_model as mm', 'mv.model_id = mm.id', 'left');
        $this->db->join('loan_file_login_mapping as lem', 'lcc.customer_loan_id=lem.case_id and lem.status="1"', 'left');
        $this->db->join('loan_file_login_tags as lmt', 'lem.tag_flag=lmt.id', 'left');
        $this->db->join('crm_bank_list as c', 'lem.bank_id=c.id', 'left');
        $this->db->join('crm_customers as cblm', 'cblm.id=lci.customer_id', 'inner');
        $this->db->join('loan_file_login_tags as lflt', 'lflt.id=lcc.loan_approval_status', 'left');
        $this->db->join('crm_dealers as crmd', 'crmd.id=lci.dealer_id', 'left');
        $this->db->join('crm_user as crmu', 'crmu.id=lci.assign_case_to  AND crmu.status = "1"', 'left');
        $this->db->join('crm_disbursal_distribution as cdd', 'cdd.case_id = lcc.customer_loan_id', 'left');
        $this->db->join('crm_rc_listing as rc', 'rc.loan_sno = lcc.id', 'left');
        $this->db->join('crm_rc_info as ri', 'ri.rc_id = rc.id', 'left');
        $this->db->join('crm_case_payout_mapping as cpm', "cpm.case_id=lcc.customer_loan_id", 'left');
        $this->db->join('crm_net_payment as cnp', 'cnp.case_id=lcc.customer_loan_id', 'left');
        $this->db->where('lcc.customer_loan_id>"1"');
        $this->db->where("cpm.payout_id",$id);
        $this->db->where('lem.tag_flag', '4');
        $this->db->where('lci.source_type', 1);
        $this->db->where('lcc.loan_approval_status not in (9,6)');       
        $this->db->group_by('lcc.customer_loan_id');
        $this->db->order_by('cpm.update_date', 'desc');
       
        $query = $this->db->get();
       // echo $this->db->last_query();die;
        $result = $query->result_array();
        return $result;
    }
    public function getPayoutInfoById($id){
        $this->db->select('cp.*,crmd.organization,ccbl.bank_name as customer_bank,crmu.name');
        $this->db->from('crm_payout as cp'); 
        $this->db->join('crm_dealers as crmd', 'crmd.id=cp.dealer_id', 'left');
         $this->db->join('crm_user as crmu', 'crmu.id=crmd.user_id AND crmu.status = "1"', 'left');
        $this->db->join('crm_customer_banklist as ccbl', 'ccbl.bank_id=cp.bank_id', 'left');
        $this->db->where("cp.id",$id);
       
        $query = $this->db->get();
       // echo $this->db->last_query();die;
        $result = $query->row_array();
        return $result;
    }

}
