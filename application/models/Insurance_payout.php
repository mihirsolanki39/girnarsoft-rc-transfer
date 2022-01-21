<?php

/** 
 * model : Crm_insurance Payout
 * Dealer control all Payout related operations.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Insurance_payout extends CI_Model {

    
    /* get payout data */
    
    function changeDateformat($date) {
        if ($date != '') {
            $date_array = explode('/', date($date));
            $date = trim($date_array[2]) . '-' . trim($date_array[1]) . '-' . trim($date_array[0]);
            // $date=date('Y-m-d',strtotime($date));  
        }
        return $date;
    }    
    public function getPayoutAllCaseInfo($params) {
        $rpp = 10;
        $perPageRecord = $rpp == 0 ? 10 : $rpp;
        $pageNo = (isset($params['pages']) && $params['pages'] != '') ? $params['pages'] : '1';
        $startLimit = ($pageNo - 1) * $perPageRecord;

        if ($params['is_count'] == 0) {
            $this->db->select('icd.id as sno,icd.cc,cd.id as customer_id,cd.customer_nominee_ref_name,'
                    . 'cd.customer_name,cd.buyer_type,cd.customer_company_name,lc.mobile,icd.regNo,icd.ins_category,cd.isexpired,'
                    . 'icd.source,icd.follow_status,cs.status_name,icd.make_year,icd.last_updated_date,icd.created_date,'
                    . 'cd.current_due_date,icd.assign_to,mm.make as makeName,mm.model as modelName,mv.db_version as versionName, '
                    . 'cd.current_policy_no,cd.previous_policy_no,cd.previous_due_date,ci.prev_policy_insurer_name,ci.short_name,'
                    . 'iq.idv as insidv,cd.od_amt,iq.own_damage,cd.idv,iq.totpremium as totalpremium,cd.current_issue_date,ust.status as updateStatus,'
                    . 'u.name as employeeName,d.organization as dealerName, c.city_name as customer_city_name,cd.customer_nominee_ref_name,'
                    . 'cpm.payout_id, cpm.sr_no as caseId,cpm.date_time as payout_date,ido.road_side_assistance,ido.road_side_assistance_txt,
                    ido.loss_of_personal_belonging,ido.driver_cover,ido.personal_acc_cover,ido.passenger_cover,ido.anti_theft,ido.add_on,
                    ido.loss_of_personal_belonging_txt,ido.emergency_transport_hotel_premium_txt,ido.driver_cover_txt,ido.passenger_cover_txt,ido.anti_theft_txt,ido.personal_acc_cover_txt');
        } else if ($params['is_count'] == 1) {
            $this->db->select('icd.id as sno');
        }
        $this->db->from('crm_insurance_case_details as icd');
        $this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id','inner');
        $this->db->join('crm_customers as lc', 'lc.id=cd.crm_customer_id','inner');
        $this->db->join('city_list as c', 'c.city_id=cd.customer_city_id','left');
        $this->db->join('crm_insurance_customer_status AS cs', 'cs.id=icd.follow_status','left');
        $this->db->join('model_version as mv', 'mv.db_version_id=icd.variantId','left');
        $this->db->join('make_model as mm', 'mm.id=mv.model_id','left');
        $this->db->join('crm_dealers as d', 'd.id=icd.dealer_id and d.status="1"','left');
        $this->db->join('crm_user as u', 'u.id=icd.assign_to and u.status="1"','left');
        $this->db->join('crm_insurance_quotes as iq', 'iq.case_id=icd.id and iq.flag="1"','left');
        $this->db->join('crm_prev_policy_insurer as ci', 'iq.insurance_company=ci.prev_policy_insurer_slug','left');
        $this->db->join('crm_insurance_update_status as ust', 'ust.statusId=icd.last_updated_status','left');
        $this->db->join('crm_insurance_quotes_addon as ido', 'ido.quote_id=iq.id','left');
        $this->db->join('crm_insurance_case_payout_mapping as cpm', 'cpm.sr_no=icd.id AND cpm.status=1', 'left');
        $this->db->where('lc.mobile>','0');
        $this->db->where("cd.current_policy_no != '0'");
        $this->db->where("cd.current_policy_no is not null");
        $this->db->where("cd.current_policy_no !=''");
        $this->db->where('icd.source = "dealer"');
        $this->db->where_in("cd.current_policy_type",array(1,3));
        $this->db->where_in("ust.statusId",array(6,9));
        $this->db = $this->getSearchQuery($params, $this->db);
        $this->db->group_by('icd.id');
        $this->db->order_by('icd.id', 'desc');
        //$this->db->order_by('lmt.priority', 'desc');
        if ($params['is_count'] == 0) {
            if (isset($params['pages'])) {
                $this->db->offset((int) ($startLimit));
            }
            if (!empty($perPageRecord)) {
                $this->db->limit((int) $perPageRecord);
            }
        }
        $query = $this->db->get();
        // echo $this->db->last_query();die;
        $result = $query->result_array();
        if ($params['is_count'] == 1) {
            $result = count($result);
        }
   // echo "<pre>";print_r($result);die;
        return $result;
    }
     public function saveInsurancePartPayment($data) {
            $this->db->trans_start();
            $result = $this->db->insert_batch('crm_insurance_part_payment', $data);
            $this->db->trans_complete();
            return $result;
     }
        public function getSearchQuery($requestParams, $select) {
         $select=$this->db;
        if (isset($requestParams['insdashId']) && $requestParams['insdashId'] != '') {
            if($requestParams['insdashId']=='1'){
            $select->where("icd.last_updated_status IN('1','2','3','4','5','6')");
            }
            if($requestParams['insdashId']=='2'){
            $select->where(" icd.last_updated_status IN('5')");
            }
            if($requestParams['insdashId']=='3'){
            $select->where(" icd.last_updated_status IN('6')");
            }
            if($requestParams['insdashId']=='4')
            {
              $wherer = "DATE_FORMAT( cd.current_due_date,  '%Y-%m' ) BETWEEN DATE_FORMAT( DATE_SUB( DATE( NOW( ) ) , INTERVAL 90 DAY ) ,  '%Y-%m' ) 
              AND DATE_FORMAT( DATE_ADD( DATE( NOW( ) ) , INTERVAL 30 DAY ) ,  '%Y-%m' ) AND YEAR( cd.current_due_date ) < YEAR( NOW( ) ) ";
              $select->where($wherer);
            }
            if($requestParams['insdashId']=='5')
            {
              $select->where('cpm.payout_id is null');
            }
        }
        if (isset($requestParams['searchby']) && $requestParams['searchby'] == 'searchdealer') {
            
                $select->where("d.id='" . $requestParams['keywordbyd'] . "'");
        }
        if (isset($requestParams['searchby']) && $requestParams['searchby'] == 'searchinsurance') {
            
                $select->where("iq.insurance_company='" . $requestParams['keywordbyIns'] . "'");
        }
        if (isset($requestParams['searchby']) && $requestParams['searchby'] == 'searchsl') {
            
                $select->where("icd.id='" . $requestParams['keywordsl'] . "'");
        }

        ########## added by Masawwar Ali start ###############
         if (isset($requestParams['searchby']) && $requestParams['searchby'] == 'searchreg') {
             
                $select->where('icd.regNo', $requestParams['keyword']);
        }
        if (isset($requestParams['searchby']) && $requestParams['searchby'] == 'searchmobile') {
             
                $select->where('lc.mobile', $requestParams['keyword']);
        }
         if (isset($requestParams['searchby']) && $requestParams['searchby'] == 'searchcustname') {
            $select->where("(cd.customer_name like '%" . trim($requestParams['keyword']) . "%' or cd.customer_company_name like '%". trim($requestParams['keyword']) . "%' or lc.mobile like '%" . trim($requestParams['keyword']). "%' or icd.regNo like '%" .trim($requestParams['keyword']). "%')");
         }
        ######## added by Masawwar Ali ends  ################
        if (isset($requestParams['ins_source']) && $requestParams['ins_source'] != '') {
            
                $select->where("icd.source='" . $requestParams['ins_source'] . "'");
        }
        if (isset($requestParams['ins_category']) && $requestParams['ins_category'] != '') {
            
                $select->where("icd.ins_category='" . $requestParams['ins_category'] . "'");
        }
        if (isset($requestParams['ins_policy']) && $requestParams['ins_policy'] != '') {
            
                $select->where("cd.current_policy_type='" . $requestParams['ins_policy'] . "'");
        }
        if (isset($requestParams['dealtby']) && $requestParams['dealtby'] != '') {
            
                $select->where("icd.assign_to='" . $requestParams['dealtby'] . "'");
        }
        if ((!empty($requestParams['payout_status']))) {
            if ($requestParams['payout_status'] == '1') {
                $select->where('cpm.payout_id is null');
            }
            if ($requestParams['payout_status'] == '2') {
                $select->where('cpm.payout_id is not null');
            }
        }

         if ((!empty($requestParams['payout_status_new']))) {
            if ($requestParams['payout_status_new'] == '1') {
                $select->where('(cipd.status ="1" OR cipd.id is  null )');
            }
            if ($requestParams['payout_status_new'] == '2') {
                $select->where('cipd.status ="2"');
               // $select->where('cpm.payout_id is not null');
            }
             if ($requestParams['payout_status_new'] == '3') {
                $select->where('cipd.status ="3"');
               // $select->where('cpm.payout_id is null');
            }
        }

        
        if(isset($requestParams['searchdate']) && $requestParams['searchdate'] == 'createdate'){
            if (isset($requestParams['createStartDate']) && $requestParams['createStartDate'] != '') {
                $select->where("DATE(icd.created_date) >=" ,$this->changeDateformat($requestParams['createStartDate']));
            }
            if (isset($requestParams['createEndDate']) && $requestParams['createEndDate'] != '') {
                $select->where("DATE(icd.created_date) <=",$this->changeDateformat($requestParams['createEndDate']));
            }
        }
        if(isset($requestParams['searchdate']) && $requestParams['searchdate'] == 'issuedate'){
                $select->where("icd.policy_status='1'");
            if (isset($requestParams['createStartDate']) && $requestParams['createStartDate'] != '') {
                $select->where("DATE(cd.current_issue_date) >=" ,$this->changeDateformat($requestParams['createStartDate']));
            }
            if (isset($requestParams['createEndDate']) && $requestParams['createEndDate'] != '') {
                $select->where("DATE(cd.current_issue_date) <=",$this->changeDateformat($requestParams['createEndDate']));
            }
        }
      return $select;
    }

    public function savePayout($data, $updateId = "") {
        if (empty($updateId)) {
            $this->db->trans_start();
            $this->db->insert('crm_insurance_payout', $data);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
        } else {
            $this->db->where('id', $updateId);
            $this->db->update('crm_insurance_payout', $data);
            $result = $updateId;
        }
        return $result;
    }
    public function savePayoutCaseMapping($mapping_data,$id = "") {
        $return = 0;
        if (!empty($mapping_data) && empty($id)) {
            $res = $this->db->insert_batch('crm_insurance_case_payout_mapping', $mapping_data);
            $this->db->trans_complete();
            $result = $res;
            if ($this->db->affected_rows() > 0)
                $return = 1;
        }else if(!empty($id)){
            $this->db->trans_start();
            $this->db->where('sr_no', $id);
            $res = $this->db->update('crm_insurance_case_payout_mapping', $mapping_data);
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
                 . 'cp.instrument_date,cp.instrument_no,cp.bank_name,cp.pay_remark'
        );
        } else if ($params['is_count'] == 1) {
            $this->db->select('cp.id as payment_id');
        }
        $this->db->from('crm_insurance_payout as cp');
        $this->db->join('crm_dealers as crmd', 'crmd.id=cp.dealer_id', 'inner');
        $this->db->join('crm_insurance_case_payout_mapping as cpm', 'cpm.payout_id=cp.id', 'left');
        $this->db->join('crm_insurance_case_details as icd', 'icd.id=cpm.sr_no', 'left');
        //$this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id','inner');
        //$this->db->join('crm_customers as lc', 'lc.id=cd.crm_customer_id','inner');
        
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
        $result = $query->result_array();
        if ($param['is_count'] == 1) {
            $result = count($result);
        }
        return $result; 
    }
    
    public function getPayoutSearchQuery($param, $select) {
        if (!empty($param['searchby'])) {
            if (!empty($param['searchby']) && $param['searchby'] == "searchdealer" && !empty($param['keywordbyd'])) {
                $select->where('cp.dealer_id', $param['keywordbyd']);
            }
            if ($param['searchby'] == 'searchsl' && !empty($param['keywordsl'])) {
                $select->where('icd.id', $param['keywordsl']);
            }
            if ($param['searchby'] == 'searchpayout' && !empty($param['keyword'])) {
                $select->where('cp.id', $param['keyword']);
            }
            if ($param['searchby'] == 'searchInstrument' && !empty($param['keyword'])) {
                $select->where('cp.instrument_no', $param['keyword']);
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
       $this->db->from('crm_insurance_payout as cp');
       $this->db->where('cp.id',$id);

        $query = $this->db->get();
        $result = $query->row_array();
        return $result; 
    }
    
    public function getClearanceDataDealerWiseData($id){
        $this->db->select('SUM(cpp.amount) as inhouse_paid_amt,cpp.customer_id');
        $this->db->from('crm_insurance_part_payment cpp');
        $this->db->join('crm_insurance_case_details as icd','icd.customer_id=cpp.customer_id','inner');
        $this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id','inner');
        $this->db->where('cpp.entry_type IN(4)');
        $this->db->where("cd.current_policy_no != '0'");
        $this->db->where("cd.current_policy_no is not null");
        $this->db->where('icd.source = "dealer"');
        $this->db->where_in("cd.current_policy_type",array(1,3));
        $this->db->where_in("icd.last_updated_status",array(6,9));
        $this->db->where('icd.dealer_id', $id);
        $this->db->group_by('customer_id');
        $query = $this->db->get();
        $result = $query->result_array();
        $suventaion = array();
        foreach($result as $res){
          $suventaion[$res['customer_id']] =    $res['inhouse_paid_amt'];
        }
        return  $suventaion; 
    }
    public function getInhousePaymentDealerWise($id){
        $this->db->select('SUM(cpp.amount) as inhouse_paid_amt,cpp.customer_id');
        $this->db->from('crm_insurance_part_payment cpp');
        $this->db->join('crm_insurance_case_details as icd','icd.customer_id=cpp.customer_id','inner');
        $this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id','inner');
        $this->db->where('cpp.entry_type IN(2)');
        $this->db->where("cd.current_policy_no != '0'");
        $this->db->where("cd.current_policy_no is not null");
        $this->db->where('icd.source = "dealer"');
        $this->db->where_in("cd.current_policy_type",array(1,3));
        $this->db->where_in("icd.last_updated_status",array(6,9));
        $this->db->where('icd.dealer_id', $id);
        $this->db->group_by('customer_id');
        $query = $this->db->get();
        $result = $query->result_array();
        $suventaion = array();
        foreach($result as $res){
          $suventaion[$res['customer_id']] =    $res['inhouse_paid_amt'];
        }
        return  $suventaion; 
    }
    
    
    public function getPayoutCaseDealerWiseData($params) {
        if(!empty($params['edit_id']))
            $or = "OR cpm.payout_id =". $params['edit_id'];
        else
        {
            $or = "OR cpm.status =0";            
        }
        $this->db->select('icd.id as sno,icd.cc,icd.id as caseId,cd.id as customer_id,cd.buyer_type,cd.customer_company_name,cd.customer_name,lc.mobile,icd.regNo,icd.ins_category,cd.isexpired,'
                . 'icd.source,icd.follow_status,cs.status_name,icd.make_year,icd.last_updated_date,icd.created_date,cd.current_due_date,icd.assign_to,mm.make as makeName,mm.model as modelName,'
                . 'mv.db_version as versionName, cd.current_policy_no,cd.previous_policy_no,cd.previous_due_date,ci.prev_policy_insurer_name,ci.short_name,iq.idv as insidv,cd.od_amt,cd.idv,'
                . 'iq.totpremium as totalpremium,cd.current_issue_date,iq.own_damage,u.name as employeeName,d.organization as dealerName, iq.qsource as source_id,cicp.payout_percentage,'
                . 'ido.road_side_assistance,ido.road_side_assistance_txt,ido.loss_of_personal_belonging,ido.driver_cover,ido.personal_acc_cover,ido.passenger_cover,ido.anti_theft,ido.add_on,'
                . 'ido.loss_of_personal_belonging_txt,ido.emergency_transport_hotel_premium_txt,ido.driver_cover_txt,ido.passenger_cover_txt,ido.anti_theft_txt,ido.personal_acc_cover_txt,'
                . 'cpm.payout as final_payout,cpm.payment_amount,cpm.is_settled,cpm.due_amount,cipd.payout_amount, cipd.percentage, cipd.addon_amount'
        );
        $this->db->from('crm_insurance_case_details as icd');
        $this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id','inner');
        $this->db->join('crm_customers as lc', 'lc.id=cd.crm_customer_id','inner');
        $this->db->join('city_list as c', 'c.city_id=cd.customer_city_id','left');
        $this->db->join('crm_insurance_customer_status AS cs', 'cs.id=icd.follow_status','left');
        $this->db->join('model_version as mv', 'mv.db_version_id=icd.variantId','left');
        $this->db->join('make_model as mm', 'mm.id=mv.model_id','left');
        $this->db->join('crm_dealers as d', 'd.id=icd.dealer_id and d.status="1"','left');
        $this->db->join('crm_user as u', 'u.id=icd.assign_to and u.status="1"','left');
        $this->db->join('crm_insurance_quotes as iq', 'iq.case_id=icd.id and iq.flag="1"','left');
        $this->db->join('crm_prev_policy_insurer as ci', 'iq.insurance_company=ci.prev_policy_insurer_slug','left');
        $this->db->join('crm_insurance_update_status as ust', 'ust.statusId=icd.last_updated_status','left');
        $this->db->join('crm_insurance_company_percentage as cicp', 'cicp.ref_id=iq.insurance_company and type = 1','left');
        $this->db->join('crm_insurance_quotes_addon as ido', 'ido.quote_id=iq.id','left');
        $this->db->join('crm_insurance_case_payout_mapping as cpm', "cpm.sr_no=icd.id and cpm.status = 1", 'left');
        $this->db->join('crm_insurance_payout_details as cipd', "cipd.case_id=icd.id ", 'left');
        $this->db->where('lc.mobile>','0');
        $this->db->where("cd.current_policy_no != '0'");
        $this->db->where("cd.current_policy_no is not null");
        $this->db->where("cd.current_policy_no != ''");
        $this->db->where('icd.source = "dealer"');
        $this->db->where_in("cd.current_policy_type",array(1,3));
        $this->db->where_in("ust.statusId",array(6,9));
        if(!empty($params['makedealerSearch'])){
           $this->db->where('icd.dealer_id', $params['makedealerSearch']);
        }
         if(!empty($params['createStartDate']) && !empty($params['createEndDate'])){                
            if (isset($params['createStartDate']) && $params['createStartDate'] != '') {
                $this->db->where("DATE(cd.current_issue_date) >=" ,date('Y-m-d', strtotime($params['createStartDate'])));
            }
            if (isset($params['createEndDate']) && $params['createEndDate'] != '') {
                $this->db->where("DATE(cd.current_issue_date) <=",date('Y-m-d', strtotime($params['createEndDate'])));
            }
        }
       
        $this->db->where("(cpm.payout_id is null ".$or.")");        
        $this->db->group_by(array('icd.id'));
        $this->db->order_by('icd.last_updated_date','DESC');        
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    public function getData($tablename,$select=[],$condition=[]){
        $this->db->select($select);
        $this->db->from($tablename);
        if($condition!=""){
          $this->db->where($condition);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        $quotes = array();
        foreach($result as $res){
           $quotes[$res['id']] = $res['name'];
        }
        return $quotes;
        
    }
    
    public function getPayoutCaseIDs($id,$flag=""){
       $this->db->select('sr_no');
       $this->db->from('crm_insurance_case_payout_mapping as cpm');
       $this->db->where('cpm.payout_id',$id);
       if($flag != 1)
            $this->db->where('cpm.status',"1");
        $query = $this->db->get();
        $result = $query->result_array();
        $new = array();
        foreach($result as $res){
           $new[] =  $res['sr_no'];
        }
          return $new; 
    }
      public function addPayoutHistoryUpdateLog($data)
    {
        $this->db->insert('insurance_payout_history_update_log', $data);
        $insert_id = $this->db->insert_id();
        return $result = $insert_id;
    }
    public function addPayoutHistory($data)
    {
        $this->db->insert('insurance_payout_history_log', $data);
        $insert_id = $this->db->insert_id();
        return $result = $insert_id;
    }
    public function getPayoutdetailsCaseIDs($id){
       $this->db->select('*');
       $this->db->from('crm_insurance_case_payout_mapping as cpm');
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
       if(!empty($id)){
             $this->db->where('id', $id);
       }
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     

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


    public function getPayoutAllOthersCaseInfo($params) {

         $rpp = 10;
        $perPageRecord = $rpp == 0 ? 10 : $rpp;
        $pageNo = (isset($params['pages']) && $params['pages'] != '') ? $params['pages'] : '1';
        $startLimit = ($pageNo - 1) * $perPageRecord;

         if ($params['is_count'] == 0){ 
            $this->db->select('icd.id as sno,icd.cc,icd.id as caseId,cd.id as customer_id,cd.customer_nominee_ref_name,'
                    . 'cd.customer_name,cd.customer_company_name,lc.mobile,icd.regNo,icd.ins_category,cd.isexpired,'
                    . 'icd.source,icd.follow_status,cs.status_name,icd.make_year,icd.last_updated_date,icd.created_date,'
                    . 'cd.current_due_date,icd.assign_to,mm.make as makeName,mm.model as modelName,mv.db_version as versionName, '
                    . 'cd.current_policy_no,cd.previous_policy_no,cd.previous_due_date,ci.prev_policy_insurer_name,ci.short_name,'
                    . 'iq.idv as insidv,cd.od_amt,cd.idv,iq.totpremium as totalpremium,cd.current_issue_date,'
                    . 'u.name as employeeName,d.organization as dealerName, c.city_name as customer_city_name,cd.customer_nominee_ref_name, ust.status as policy_status,cicp.payout_percentage,ido.road_side_assistance,ido.road_side_assistance_txt,ido.loss_of_personal_belonging,ido.driver_cover,ido.personal_acc_cover,ido.passenger_cover,ido.anti_theft,ido.add_on,'
                . 'ido.loss_of_personal_belonging_txt,ido.emergency_transport_hotel_premium_txt,ido.driver_cover_txt,ido.passenger_cover_txt,ido.anti_theft_txt,ido.personal_acc_cover_txt,iq.qsource as source_id,iq.qsource as source_id,ciup.payout_amount as payout_from_company, ciup.payout as payout_perc_from_company,ciup.comment as settleComment,ciup.difference as settlediffrence, cipd.payout_amount as actual_payout_amount, cipd.addon_amount as addOns, cipd.own_damage,cipd.id as cipdid, cipd.status as insStatus, ciup.created_on as comment_create_date');

         }else if ($params['is_count'] == 1) {
            $this->db->select('icd.id as sno');
        }
        $this->db->from('crm_insurance_case_details as icd');
        $this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id','inner');
        $this->db->join('crm_customers as lc', 'lc.id=cd.crm_customer_id','inner');
        $this->db->join('city_list as c', 'c.city_id=cd.customer_city_id','left');
        $this->db->join('crm_insurance_customer_status AS cs', 'cs.id=icd.follow_status','left');
        $this->db->join('model_version as mv', 'mv.db_version_id=icd.variantId','left');
        $this->db->join('make_model as mm', 'mm.id=mv.model_id','left');
        $this->db->join('crm_dealers as d', 'd.id=icd.dealer_id and d.status="1"','left');
        $this->db->join('crm_user as u', 'u.id=icd.assign_to and u.status="1"','left');
        $this->db->join('crm_insurance_quotes as iq', 'iq.case_id=icd.id and iq.flag="1"','left');
        $this->db->join('crm_prev_policy_insurer as ci', 'iq.insurance_company=ci.prev_policy_insurer_slug','left');
        $this->db->join('crm_insurance_update_status as ust', 'ust.statusId=icd.last_updated_status','left');
         $this->db->join('crm_insurance_company_percentage as cicp', 'cicp.ref_id=iq.insurance_company and type = 1','left');
        $this->db->join('crm_insurance_quotes_addon as ido', 'ido.quote_id=iq.id','left');
        $this->db->join('crm_insurance_uploaded_payout as ciup', 'ciup.policy_number=cd.current_policy_no','left');
        $this->db->join('crm_insurance_payout_details as cipd', 'cipd.policy_no=cd.current_policy_no','left');
        // $this->db->join('crm_insurance_case_payout_mapping as cpm', 'cpm.sr_no=icd.id and cpm.status = 1', 'left');
        $this->db->where('lc.mobile>','0');
        $this->db->where("cd.current_policy_no != '0'");
        $this->db->where("cd.current_policy_no is not null");
        $this->db->where("cd.current_policy_no is not null");
        $this->db->where_in("ust.statusId",array(6,9)); 
        $this->db->where('icd.policy_status','1');
        $this->db = $this->getSearchQuery($params, $this->db);
        $this->db->group_by('icd.id');
        $this->db->order_by('cipd.status', 'ASC');

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
    //  echo "<pre>";print_r($result);die;
        return $result;
    }
    public function getconditionalData($id){
        $this->db->select('cicd.id,ciup.policy_number');
        $this->db->from('crm_insurance_customer_details as cicd'); 
        $this->db->join('crm_insurance_uploaded_payout  as ciup', 'ciup.policy_number=cicd.current_policy_no', 'left');
        $this->db->where("cicd.current_policy_no",$id);       
        $query = $this->db->get();
        $result = $query->result_array();
        return current($result);
    }

   /* public function fetchconditionalData($tbl,$column='',$con=''){
            $this->db->select($column);
            $this->db->from('crm_insurance_customer_details as cicd'); 
            $this->db->join('crm_insurance_uploaded_payout  as ciup', 'ciup.policy_number=cicd.current_policy_no', 'left');
            $this->db->where("cicd.current_policy_no",$id);       
            $query = $this->db->get();
            $result = $query->result_array();
            return current($result);
    }*/

    public function getPayoutDetails($tbl,$column,$con){
        $this->db->select($column);
        $this->db->from($tbl); 
        $this->db->where($con);       
        $query = $this->db->get();
        $result = $query->result_array();
        return current($result);
           
    }

    public function updateconditionalData($tbl,$data,$con){
            $this->db->where($con);
          return   $this->db->update($tbl, $data);
            //$result = $updateId;
            //return $result;
    }

   

    public function getCaseInfoById($id = '') {
        //print_r($params);
        $this->db->select('cd.customer_name,icd.regNo,cd.isexpired, cd.buyer_type, cd.customer_company_name, '
                . 'cd.current_due_date,mm.make as makeName,mm.model as modelName,'
                . 'mv.db_version as versionName, cd.current_policy_no,ci.short_name,iq.idv as insidv,'
                . 'iq.totpremium as totalpremium,cd.current_issue_date,iq.own_damage,d.organization as dealerName,'
                . 'cpm.payout as final_payout,cpm.payment_amount,cpm.due_amount,ido.road_side_assistance,ido.road_side_assistance_txt,
                    ido.loss_of_personal_belonging,ido.driver_cover,ido.personal_acc_cover,ido.passenger_cover,ido.anti_theft,ido.add_on,
                    ido.loss_of_personal_belonging_txt,ido.emergency_transport_hotel_premium_txt,ido.driver_cover_txt,ido.passenger_cover_txt,ido.anti_theft_txt,ido.personal_acc_cover_txt, cm.name as salesExecutive'
        );
        $this->db->from('crm_insurance_case_details as icd');
        $this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id','inner');
        $this->db->join('model_version as mv', 'mv.db_version_id=icd.variantId','left');
        $this->db->join('make_model as mm', 'mm.id=mv.model_id','left');
        $this->db->join('crm_dealers as d', 'd.id=icd.dealer_id and d.status="1"','left');
        $this->db->join('crm_insurance_quotes as iq', 'iq.case_id=icd.id and iq.flag="1"','left');
        $this->db->join('crm_prev_policy_insurer as ci', 'iq.insurance_company=ci.prev_policy_insurer_slug','left');
        $this->db->join('crm_insurance_update_status as ust', 'ust.statusId=icd.last_updated_status','left');
        $this->db->join('crm_insurance_case_payout_mapping as cpm', "cpm.sr_no=icd.id and cpm.status = 1", 'left');
       // $this->db->join('crm_insurance_payout_details as cipd', "cipd.case_id=icd.id ", 'left');
        $this->db->join('crm_insurance_quotes_addon as ido', 'ido.quote_id=iq.id','left');
        $this->db->join('crm_user as cm', 'cm.id=icd.sales_id','left');

        $this->db->where("cd.current_policy_no != '0'");
        $this->db->where("cd.current_policy_no is not null");
        $this->db->where('icd.source = "dealer"');
        $this->db->where_in("cd.current_policy_type",array(1,3));
        $this->db->where_in("ust.statusId",array(6,9));
       
        if(!empty($id))
           $this->db->where('cpm.payout_id', $id);
        else
           $this->db->where("cpm.payout_id is null");
        $this->db->where("cd.current_policy_type IN('1','3')");         
        $this->db->group_by(array('icd.id'));
        $this->db->order_by('icd.last_updated_date','DESC');        
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    /* end */
   
}
