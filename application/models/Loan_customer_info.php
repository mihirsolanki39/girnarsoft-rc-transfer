<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * model : Crm_dealers
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
class Loan_customer_info extends CI_Model 
{

    public function saveUpdateCustomerInfo($leadData, $updateId = '') {
       // echo '<pre>';print_r($updateId);die;
        if (empty($updateId)) {
            $leadData['created_date']=date('Y-m-d H:i:s');
            $this->db->trans_start();
            $this->db->insert('loan_customer_info', $leadData);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
        } else {
            $this->db->where('id', $updateId);
            $this->db->update('loan_customer_info', $leadData);
            //echo $this->db->last_query();die;
            $result = $updateId;
        }
        //echo $this->db->last_query(); exit;
        return $result;
    }
    
    public function saveUpdateCustomerOtherInfo($leadData, $updateId = ''){
       if (empty($updateId)) {
            $this->db->trans_start();
            $this->db->insert('loan_customer_academic', $leadData);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
        } else {
            $this->db->where('customer_id', $updateId);
            $this->db->update('loan_customer_academic', $leadData);
            //echo $this->db->last_query();die;
            return $updateId;
        }
        return $result; 
    }
    public function getCustomerOtherInfo($customer_id){
       $this->db->select('*');
       $this->db->from('loan_customer_academic');
       $this->db->where('customer_id', $customer_id);
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     

    }
        

    public function getCustomerInfoByCustomerId($customer_id="",$flag="",$case_id=""){
        
       $this->db->select('lci.*,lcc.*,ca.customer_id as cust_id,mv.db_version as version_name,mm.make as make_name,mm.model as model_name,ca.employment_type,ca.employer_name,ca.employee_doj,ca.totalexp,ca.gross_mon_income,
        ca.is_notice_period,ca.bus_applicant_type,ca.bus_industry_type,ca.bus_business_name,ca.bus_off_set_up,
        ca.bus_start_business_mon,ca.bus_start_business_year,ca.bus_itr_income1,ca.bus_itr_income2,ca.pro_off_set_up,
        ca.pro_itr_income1,ca.pro_itr_income2,ca.pro_industry_type,ca.pro_start_date_mon,ca.pro_start_date_year,
        ca.oth_type,ca.oth_customer_own,ca.oth_customer_taken_loan,ca.created_on,lem.file_loan_amount as loan_amt,lem.file_roi as roi,lem.file_tenure as tenor,lem.bank_id as financer,c.bank_name as financer_name,ref.ref_name_one as ref_name_one,lem.tag_flag,lem.valuation_status as valuationstatus,lem.cpv_status as cpvstatus,lmt.file_tag,postdel.invoice_no,paydel.instrument_type');
       $this->db->from('loan_customer_info as lci');
       $this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id','inner');
       $this->db->join(MODEL_VERSION.' as mv', 'lcc.versionId=mv.db_version_id','left');
       $this->db->join(MAKE_MODEL.' as mm', 'mv.model_id = mm.id','left');
       $this->db->join('loan_customer_academic as ca', 'ca.customer_id = lci.customer_id','left');
       $this->db->join('loan_file_login_mapping as lem','lcc.customer_loan_id=lem.case_id and lem.status="1"','left');
       $this->db->join('loan_file_login_tags as lmt','lem.tag_flag=lmt.id','left');
       $this->db->join('crm_bank_list as c','lem.bank_id=c.id','left');
       $this->db->join('loan_customer_reference_info as ref', 'lcc.customer_loan_id = ref.customer_case_id','left');
       $this->db->join('loan_post_delivery_details as postdel', 'postdel.case_id = ref.customer_case_id','left');
       $this->db->join('loan_payment_details as paydel', 'paydel.case_id = ref.customer_case_id','left');
       if($customer_id>0){
          $this->db->where('lci.customer_id', $customer_id);
        }
        if($case_id>0){
          $this->db->where('lcc.customer_loan_id', $case_id);
        }
       $this->db->order_by('lmt.priority','asc');
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     

    }
    public function getCustomerInfo($customer_id){
       $this->db->select('*');
       $this->db->from('loan_customer_info');
       $this->db->where('customer_id', $customer_id);
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;    
    }
    
    public function getCustomerByCustInfo($customer_id){
       $this->db->select('*');
       $this->db->from('loan_customer_info');
       $this->db->where('customer_id', $customer_id);
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     

    }
    public function getCustomerMobileNumber($id){
       $this->db->select('mobile');
       $this->db->from('crm_customers');
       $this->db->where('id', $id);
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result; 
    }
     public function getCaseInfoByCustomerId($customer_id='',$case_id=''){
       $this->db->select('lci.*,lcc.*');
       $this->db->from('loan_customer_info as lci');
       $this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id','left');
       if(!empty($customer_id)){
       $this->db->where('lci.customer_id', $customer_id);
       }
       if(!empty($case_id))
       {
        $this->db->where('lcc.customer_loan_id', $case_id);
       }  
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     
    }
    
    public function getLoanDashboard($empId=''){
        $this->db->select('COUNT(distinct CASE WHEN lcc.loan_approval_status IN(1,2,3,4,5,7,8,10,11) THEN lcc.id ELSE null END ) ActiveCases,COUNT(distinct CASE WHEN lcc.loan_approval_status IN(10,7) THEN lcc.id ELSE null END )AwaitLoginCount,COUNT(distinct CASE WHEN lmt.id IN(1) and lcc.loan_approval_status In (1) THEN lcc.id ELSE null END )AwaitDecisionCount,COUNT(distinct CASE WHEN lmt.id IN(2) and lcc.loan_approval_status in(2) THEN lcc.id ELSE null END ) DisbursedCount'); 
       $this->db->from('loan_customer_info as lci');
       $this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lci.id','left');
       $this->db->join('loan_customer_academic as ca', 'ca.customer_id = lci.customer_id','left');
       $this->db->join(MODEL_VERSION.' as mv', 'lcc.versionId=mv.db_version_id','LEFT');
       $this->db->join(MAKE_MODEL.' as mm', 'mv.model_id = mm.id','LEFT');
       $this->db->join('loan_file_login_mapping as lem','lcc.customer_loan_id=lem.case_id and lem.status="1"','left');
       $this->db->join('loan_file_login_tags as lmt','lem.tag_flag=lmt.id','left');
       $this->db->join('crm_bank_list as c','lem.bank_id=c.id','left');
       $this->db->join('loan_customer_reference_info as ref', 'lcc.customer_loan_id = ref.customer_case_id','left');
       $this->db->join('loan_post_delivery_details as postdel', 'postdel.case_id = ref.customer_case_id','left');
       $this->db->join('loan_payment_details as paydel', 'paydel.case_id = ref.customer_case_id','left');
       $this->db->join('crm_customers as cblm','cblm.id=lci.customer_id','inner');
       $this->db->join(CITY_LIST.' as cl','cl.city_id=lci.residence_city','LEFT');
       $this->db->join('crm_customer_bank_info as cbin','cbin.case_id=lcc.customer_loan_id','left');
       $this->db->where('lcc.customer_loan_id>"1"');
        if($empId!='')
        {
          $this->db->where('lci.assign_case_to', $empId);
        }
        $query = $this->db->get();
       //  echo $this->db->last_query();die;
        $result = $query->result_array();
       // echo "<pre>";print_R($result);die;
        return  $result; 
    }
    public function getEmployeeIdByCustomerId($customerId){
        $this->db->select('lcc.created_by'); 
        $this->db->from('loan_customer_case as lcc');
        $this->db->join('loan_customer_info as lci', 'lci.id=lcc.customer_loan_id','inner');
        $this->db->where('lci.customer_id', $customerId);
        $query = $this->db->get();
        $result = $query->result_array();
        return  $result;
        
    }
    public function getInsurn($empId='')
   {

        $this->db->select('count(icd.id) as counter');
        $this->db->from('crm_insurance_case_details as icd');
        $this->db->join('crm_insurance_customer_details as cd', 'cd.id = icd.customer_id','inner');
        $this->db->join('crm_customers as cc', 'cc.id = `cd`.`crm_customer_id`','inner');
        $this->db->where('icd.renew_flag','1');
        $this->db->where("`cc`.`mobile` > '0'");
        
        if($empId!=''){
            $this->db->where('icd.assign_to', $empId);
            }
        $query = $this->db->get();
        $result = $query->row_array();
        //echo $str = $this->db->last_query();die;
        return  $result['counter']; 
     }
    public function getTotalBankLimit($emp_id='')
    {
        $col = 'b.amount_limit,bl.bank_name,bl.id as bank_id';
        if(!empty($emp_id))
        {
          $col = 'b.amount_limit as bank_limit,bl.bank_name,bl.id as bank_id,em.emp_limit as amount_limit, em.emp_id'; 
        }
        $this->db->select($col); 
        $this->db->from('crm_banks as b');
        $this->db->join('crm_bank_list as bl', 'bl.id=b.bank_id','inner');
        if(!empty($emp_id))
        {
            $this->db->join('bank_employee_limit_mapping as em', 'bl.id=em.bank_id','inner');
            $this->db->where('em.status','1');
            $this->db->where('em.emp_id',$emp_id);
        }
        $this->db->where('bl.status','1');
        $this->db->where('b.status','1');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        return $result = $query->result_array();
    }
    public function getUsedAmount($bank_id,$emp_id='')
    {
        $this->db->select('sum(lm.disbursed_amount) as used'); 
        $this->db->from('loan_file_login_mapping as lm');
        $this->db->join('loan_customer_case as lc', 'lc.customer_loan_id=lm.case_id','inner');
        if(!empty($emp_id))
        {
           $this->db->join('loan_customer_info as li', 'li.id=lc.customer_loan_id','inner');
          // $this->db->where('li.status','1');
           $this->db->where('li.meet_the_customer',$emp_id);
        }
        $this->db->where('lm.bank_id',$bank_id);
        $this->db->where('lm.rc_status!=','2');
        $this->db->where('lm.status','1');
        $this->db->where('lm.tag_flag','4');
        $this->db->where('lc.loan_for','2');
        $query = $this->db->get();
        $result = $query->result_array();

        return $result[0]['used'];
    }
    public function getBankLimitByEmployeeId($assignId=''){
        $data=[];
        if($assignId==''){
            $bankData=$this->getBanklimit();
        }else{
        $bankData=$this->getBankByEmployeeId($assignId);
        }
        
        $i=0;
        if(!empty($bankData)){
            foreach($bankData as $bk=>$bv){
                $mappedData=$this->getBankMappingByEmployeeId($assignId,$bv['bank_id']);
                //print_r($mappedData);
                if(!empty($mappedData)){
                    $appLoanAmt=0;
                    $empLimit=0;
                    foreach($mappedData as $mdata){
                        if($mdata['bank_id']=$bv['bank_id']){
                            $appLoanAmt +=$mdata['approved_loan_amt'];
                        }
                    }
                    $empLimit=$bv['emp_limit'];
                    $emp_bank_limit= $empLimit-$appLoanAmt;
                    $data[$i]['emp_bank_limit']=($emp_bank_limit > 0) ? $emp_bank_limit : 0;
                }
                $data[$i]['id']=$bv['id'];
                $data[$i]['emp_limit']=$bv['emp_limit'];
                $data[$i]['bank_name']=$bv['bank_name'];
                $i++;
            }
        }
        
        return  $data;
        
    }
    public function getBankMappingByEmployeeId($assignId='',$bankId=''){
      $this->db->select('lm.*'); 
        $this->db->from('loan_file_login_mapping as lm');
        $this->db->join('loan_customer_info as ci', 'ci.id=lm.case_id','inner');
        $this->db->where('lm.status', '1');
        $this->db->where('lm.tag_flag', '4');
        if($assignId!=''){
        $this->db->where('ci.assign_case_to', $assignId);
        }
        if($bankId!=''){
        $this->db->where('lm.bank_id', $bankId);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $result = $query->result_array();
        return  $result;  
    }
    
    
    public function getBankByEmployeeId($assignId=''){
        $this->db->select('lm.id,lm.bank_id,lm.emp_limit,lm.emp_id,b.bank_name,b.id as bank_id'); 
        $this->db->from('bank_employee_limit_mapping as lm');
        $this->db->join('crm_bank_list as b', 'b.id=lm.bank_id','inner');
        $this->db->where('lm.status', '1');
        if($assignId!=''){
        $this->db->where('lm.emp_id', $assignId);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $result = $query->result_array();
        return  $result;
        
    }
    
    public function getBanklimit(){
        $this->db->select('cb.id,cb.bank_id,cb.amount_limit as emp_limit,b.bank_name'); 
        $this->db->from('crm_banks as cb');
        $this->db->join('crm_bank_list as b', 'b.id=cb.bank_id','inner');
        $this->db->where('cb.status', '1');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $result = $query->result_array();
        return  $result;
        
    }
    
    public function getInsuranceDashboard($empId=''){
        $this->db->select("COUNT(distinct CASE WHEN icd.last_updated_status IN('1','2','3','4','5','6') AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) ActiveCases, COUNT(distinct CASE WHEN (icd.last_updated_status IN('5') AND `icd`.`renew_flag` = '0') THEN icd.id ELSE null END ) PoliciesPendingCases, COUNT(distinct CASE WHEN icd.last_updated_status IN('6') AND `icd`.`renew_flag` = '0' THEN icd.id ELSE null END ) PayPendingCases");
        $this->db->from('crm_insurance_case_details as icd');
        $this->db->join('crm_insurance_customer_details as cd','cd.id=icd.customer_id','inner');
        $this->db->join('crm_customers as cc', 'cc.id=cd.crm_customer_id','inner');
        $this->db->join('crm_insurance_update_status as us', 'us.statusId=icd.last_updated_status','left');
        $this->db->where('cc.mobile>','0');
        if($empId!=''){
        $this->db->where('icd.assign_to', $empId);
        }
        $query = $this->db->get();
      
        $result = $query->result_array();
        return  $result;
    }
    
    public function getDcDashboard($empId=''){
        $this->db->select("COUNT(distinct CASE WHEN (fd.loan_taken_from='1' and fd.loan_filled='2' and fd.application_no='') THEN fd.id ELSE null END ) FlaggedCases,COUNT(distinct CASE WHEN (fd.last_updated_status='1') THEN fd.id ELSE null END ) Paymentpending"); 
        $this->db->from('crm_finance_delivery as fd');
        $this->db->join('crm_finance_receipt as fr', 'fr.orderId=fd.id','left');
        $this->db->where('fd.status', '1');
        if($empId!=''){
        $this->db->where('fd.deliverySales', $empId);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $result = $query->result_array();
        return  $result; 
    }

    
    public function getRcDashboard($empId=''){
        $this->db->select("COUNT(distinct CASE WHEN irc.rc_status IN('1') THEN irc.id ELSE null END ) PendingCases, COUNT(distinct CASE WHEN irc.rc_status IN('2') THEN irc.id ELSE null END ) InProcessCases"); 
        $this->db->from('crm_rc_listing as rc');
        $this->db->join('crm_rc_info as irc','irc.rc_id=rc.id','inner');
        //$this->db->where('cd.status', '1');
        if($empId!=''){
        //$this->db->where('irc.updated_by', $empId);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $result = $query->result_array();
        return  $result; 
    }

    public function updateMasterCustomerDetails($data,$id="")
    {
      if (empty($id)) {
            $this->db->trans_start();
            $this->db->insert('crm_customer_personnel_details', $data);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
        } else {
            $this->db->where('customer_id', $id);
            $this->db->update('crm_customer_personnel_details', $data);
            //echo $this->db->last_query();die;
            $result = $id;
        }
        //echo $this->db->last_query();die;
        return $result; 
    }

    public function getMasterCustomerDetails($customer_id)
    {
      //echo $customer_id; exit;
      $query = $this->db->get_where('crm_customer_personnel_details',array('customer_id'=>$customer_id));
      $result = $query->result_array();
      //echo  $this->db->last_query(); exit;
      return $result;
    }


    public function getCustomerInfoByCaseID($case_id)
    {
       $this->db->select('lci.*,lcc.*');
       $this->db->from('loan_customer_info as lci');
       $this->db->join('loan_customer_case as lcc','lcc.customer_loan_id=lci.id','inner');
       $this->db->where('lci.id', $case_id);
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;  
    }

    public function saveCustomerBankInfo($data,$id="")
    {
      if (empty($id)) {
            $this->db->trans_start();
            $this->db->insert('crm_customer_bank_info', $data);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
        } else {
            $this->db->where('id', $id);
            $this->db->update('crm_customer_bank_info', $data);
            $result = $id;
        }
        //echo $this->db->last_query();die;
        return $result; 
    }
    public function checkRefIdForRC($loan_sr_no,$tag='',$flag= "")
    {
       $this->db->select('lflm.*');
       $this->db->from('loan_file_login_mapping as lflm');
       
       $this->db->join('loan_customer_case as lcc', 'lcc.customer_loan_id=lflm.case_id','left');
       $this->db->where('lcc.id', $loan_sr_no);
       if($tag!='')
       {
         $this->db->where('tag_flag', $tag);
       }
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     
    }
    public function checkRefId($refId,$tag='',$id= "",$flag='')
    {
       $this->db->select('*');
       $this->db->from('loan_file_login_mapping');
       if(empty($flag))
       $this->db->where('ref_id', $refId);
       else
        $this->db->where('loanno', $refId);
       if(!empty($id))
       {
           $this->db->where('id not in('.$id.')');
       }
       if($tag!='')
       {
         $this->db->where('tag_flag', $tag);
       }
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     
    }

    public function crmDisbursalDistribution($data,$id='')
    {
      if (empty($id)) {
            $data['created_on'] = date("Y-m-d h:i:s");
            $this->db->trans_start();
            $this->db->insert('crm_disbursal_distribution', $data);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
        } else {
            $this->db->where('case_id', $id);
            $this->db->update('crm_disbursal_distribution', $data);
            $result = $id;
        }
       // echo $this->db->last_query();die;
        return $result;

    }

    public function checkCrmDisbursalDistribution($case_id)
    {
      $this->db->select('*');
       $this->db->from('crm_disbursal_distribution');
       $this->db->where('case_id', $case_id);
       $query = $this->db->get();
       //echo $this->db->last_query();die;
       $result = $query->result_array();

       return  $result;   

    }

    public function getCsvDetailsByCaseID($case_id)
    {
       $this->db->select('*');
       $this->db->from('loan_file_login_mapping');  
       $this->db->where('case_id', $case_id);
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;  
    }

    public function crmEmpAmountLog($data)
    {
        $this->db->trans_start();
        $this->db->insert('crm_emp_amount_log', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $result = $insert_id;
    }

    public function getRemainingLimitByBankEmp($emp_id,$bank_id)
    {
        $usedAmount = 0;
        $this->db->select('lm.disbursed_amount as used'); 
        $this->db->from('loan_file_login_mapping as lm');
        $this->db->join('loan_customer_case as lc', 'lc.customer_loan_id=lm.case_id','inner');
        $this->db->join('loan_customer_info as li','li.id=lc.customer_loan_id','inner');
        $this->db->join('bank_employee_limit_mapping as em', 'em.emp_id=li.meet_the_customer','inner');
        $this->db->where('lm.bank_id',$bank_id);
        $this->db->where('em.emp_id',$emp_id);
        $this->db->where('lm.status','1');
        $this->db->where('lm.tag_flag','4');
        $this->db->where('lc.loan_for','2');
        $this->db->where('em.status','1');
        $this->db->group_by('lm.id');
        $query = $this->db->get();
        $result = $query->result_array();
        foreach ($result as $key => $value) {
          $usedAmount = (int)$value['used']+(int)$usedAmount;
        }
        //echo $this->db->last_query(); exit;
        //return $result[0]['used'];
        return $usedAmount;
    }

    public function getAssignedLimitByBankEmp($emp_id,$bank_id)
    {
        $this->db->select('em.emp_limit'); 
        $this->db->from('bank_employee_limit_mapping as em');
        $this->db->join('loan_customer_info as lc', 'lc.meet_the_customer=em.emp_id','inner');
       // $this->db->where('lc.status','1');
        $this->db->where('em.status','1');
        $this->db->where('em.bank_id',$bank_id);
        $this->db->where('em.emp_id',$emp_id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['emp_limit'];
    }
    
    public function getdashboardLeads($requestParams){
        $monfirstDate = date('Y-m-01');
        $todayDate     = date('Y-m-d');
        $whereleadAdded         ="  AND    DATE(ldm.ldm_created_date) >= '$monfirstDate' AND  DATE(ldm.ldm_created_date) <= '$todayDate'";
        $this->db->select("sum(CASE WHEN (DATE(ldm.ldm_created_date) > '0000-00-00') THEN 1 ELSE 0 END) AS LeadAdded,
        sum(CASE WHEN (ldm.ldm_status_id='9') THEN 1 ELSE 0 END) AS walkdone,
        sum(CASE WHEN (ldm.ldm_status_id='12') THEN 1 ELSE 0 END) AS converted,
        sum(CASE WHEN (ldm.ldm_status_id='12') THEN 1 ELSE 0 END) AS pending"); 
        $this->db->from('crm_buy_lead_dealer_mapper as ldm');
        $this->db->join('crm_buy_lead_customer as lc', 'lc.id=ldm.ldm_customer_id','left');
        $this->db->join('crm_buy_lead_customer_preferences as lcp', 'lcp.lcp_lead_dealer_mapper_id = ldm.ldm_id AND lcp.lcp_is_latest=1 AND lcp.lcp_active=1','left');
        $this->db->join('crm_buy_customer_status AS cs', 'cs.id=ldm.ldm_status_id','left');
        $this->db->join('ublms_locations as loc', 'ldm.ldm_location_id = loc.location_id','left');
        $this->db->where('ldm.ldm_dealer_id', $requestParams['ucdid']);
        $this->db->where('ldm.ldm_dealer_id>','0');
        $this->db->where('lc.mobile>','0');
        //$this->db->where($whereleadAdded);
        $this->db->group_by(array('ldm.ldm_id'));
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $result = $query->result_array();
        return  $result;      
     }


    public function getMobileCustomerDetails($customer_id)
    {
        $this->db->select('*');
        $this->db->from('crm_customers as cb');
       // $this->db->join('crm_buy_lead_dealer_mapper as lm', 'cb.id=lm.ldm_customer_id','inner');
        $this->db->where('cb.id',$customer_id);
        $query = $this->db->get();
        $result = $query->result_array();
        //echo $this->db->last_query(); exit;

        return $result;
    }

    public function insertCustomersMobile($data)
    {
        $this->db->trans_start();
        $this->db->insert('crm_customers', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        $result = $insert_id;
        //echo $this->db->last_query();die;
        return $result; 
    }

    public function getCustomersMobile($mobile='',$id='')
    {
        $this->db->select('*');
        $this->db->from('crm_customers');
        if(!empty($mobile))
        {
          $this->db->where('mobile', $mobile);
        }
        if(!empty($id))
        {
          $this->db->where('id', $id);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return  $result; 

    }

    public function saveUpdateCoapplicantDetails($data,$id='')
    {
      if (empty($id)) {
            $this->db->trans_start();
            $this->db->insert('loan_coapplicant_detail', $data);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
        } else {
            $this->db->where('id', $id);
            $this->db->update('loan_coapplicant_detail', $data);
            $result = $id;
        }
        //echo $this->db->last_query();die;
        return $result; 
    }

    public function saveUpdateGuarantorDetails($data,$id='')
    {
      if (empty($id)) {
            $this->db->trans_start();
            $this->db->insert('loan_guarantor_detail', $data);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
        } else {
            $this->db->where('id', $id);
            $this->db->update('loan_guarantor_detail', $data);
            $result = $id;
        }
        //echo $this->db->last_query();die;
        return $result; 
    }
}
