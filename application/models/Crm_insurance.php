<?php

/** 
 * model : Crm_insurance
 * User Class to control all insurance related operations.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_insurance extends CI_Model {

    public $activity_mapping = array('status' => '1', 'comment' => '2', 'followup' => '3');
    public $zone_A_arr = array('8','125','129','227','336','344','471','660');
    
    public function __construct() {
        parent::__construct();
        $this->dateTime=date('Y-m-d H:i:s');
    }
    
    public function addInsuranceCase($userInfo, $updateId = '',$left_menu='',$flag = ''){
        $addCustomerInfo=[];
        $customerPersInfo=[];
        $addCaseInfo=[];
        $createdById= $this->session->userdata['userinfo']['id'];
        $customerLeadId=$this->getcustomerLeadId($userInfo['customer_mobile']);
        
        $customerPersInfo['customer_name']=$userInfo['customer_name'];
        $customerPersInfo['created_on']=date('Y-m-d H:i:s');
        $customerPersInfo['created_by_module']='Insurance';
        $customerPersInfo['last_updated_by_module']='Insurance';
         
        if(!empty($customerLeadId)){
            $leadCustomerId=$customerLeadId['leadId'];
            $customerLeadId=$this->getcustomerDetailsByLeadId($leadCustomerId);
            if(empty($customerLeadId)){
                $customerPersInfo['customer_id']=$leadCustomerId;
                $customerLeadId=$this->addNewPersonalCustomer($customerPersInfo);
            }
        }else{
            $newLead['mobile']=$userInfo['customer_mobile'];
            $leadCustomerId=$this->addNewleadCustomer($newLead);
            $customerPersInfo['customer_id']=$leadCustomerId;
            $customerLeadId=$this->addNewPersonalCustomer($customerPersInfo);
        }
        //echo $leadCustomerId;
        //echo $leadCustomerId;
        //print_r($userInfo);exit;
        
        if (empty($updateId)) {
            if($userInfo['buyer_type']=='1'){
            $addCustomerInfo['customer_name']=$userInfo['customer_name'];
            }elseif($userInfo['buyer_type']=='2'){
            $addCustomerInfo['customer_company_name']=$userInfo['customer_company_name'];  
            }
            $addCustomerInfo['crm_customer_id']=$leadCustomerId;
            $addCustomerInfo['buyer_type']=$userInfo['buyer_type'];
            $addCustomerInfo['mi_funding']=$userInfo['mi_funding'];
            $addCustomerInfo['customer_email']= $userInfo['customer_email'];
            $addCustomerInfo['status']='1';
            $addCustomerInfo['isexpired']=$userInfo['isexpired'];
            $addCustomerInfo['created_date']=date('Y-m-d H:i:s');
            $addCustomerInfo['created_by']=$createdById;
            $addCustomerInfo['customer_nominee_ref_name'] = $userInfo['reference_customer_name'];
            $addCustomerInfo['customer_nominee_ref_phone'] = $userInfo['reference_customer_mobile'];
          //  $addCustomerInfo['reference_name']=$userInfo['reference_name'];
            $customerId=$this->addInsuranceCustomer($addCustomerInfo);
            $addCaseInfo['ins_category']=$userInfo['ins_category'];
            $addCaseInfo['source']=$userInfo['source'];
            if($userInfo['source']=='dealer'){
            $addCaseInfo['dealer_id']=$userInfo['dealerName'];
            $addCaseInfo['sales_id']=$userInfo['sales_exec'];
            }
            $addCaseInfo['last_updated_date']=date('Y-m-d H:i:s');
            $addCaseInfo['last_updated_status']='1';
            $addCaseInfo['assign_to']=$userInfo['assign_to'];   
            $addCaseInfo['customer_id']=$customerId;
            $addCaseInfo['is_latest']='1';
            $addCaseInfo['created_by']=$createdById;
            $addCaseInfo['created_date']=date('Y-m-d H:i:s');
            $addCaseInfo['ncb_transfer']=$userInfo['ncb_trans'];
            $addCaseInfo['left_menu_status'] = INSURANCE_LEFT_SIDE_MENU['CASE_DETAILS'];
            $this->db->insert('crm_insurance_case_details', $addCaseInfo);
            $insert_id = $this->db->insert_id();
            return $customerId;
        } else {
            if($userInfo['buyer_type']=='1'){
            $addCustomerInfo['customer_name']=$userInfo['customer_name'];
            }elseif($userInfo['buyer_type']=='2'){
            $addCustomerInfo['customer_company_name']=$userInfo['customer_company_name'];  
            }
            $addCustomerInfo['mi_funding']=$userInfo['mi_funding'];
            $addCustomerInfo['crm_customer_id']=$leadCustomerId;
            $addCustomerInfo['isexpired']=$userInfo['isexpired'];
            $addCustomerInfo['buyer_type']=$userInfo['buyer_type'];
            $addCustomerInfo['customer_email']= $userInfo['customer_email'];
            $addCustomerInfo['status']='1';
            $addCustomerInfo['updated_date']=date('Y-m-d');
            $addCustomerInfo['updated_by']=$createdById;
            $addCustomerInfo['customer_nominee_ref_name'] = $userInfo['reference_customer_name'];
            $addCustomerInfo['customer_nominee_ref_phone'] = $userInfo['reference_customer_mobile'];
           // $addCustomerInfo['reference_name']=$userInfo['reference_name'];
            $updateId=$this->addInsuranceCustomer($addCustomerInfo,$updateId);
            $addCaseInfo['ins_category']=$userInfo['ins_category'];
            $addCaseInfo['source']=$userInfo['source'];
            if($userInfo['source']=='dealer'){
            $addCaseInfo['dealer_id']=$userInfo['dealerName'];
            $addCaseInfo['sales_id']=$userInfo['sales_exec'];
            }
            $addCaseInfo['assign_to']=$userInfo['assign_to'];
            $addCaseInfo['is_latest']='1';
            $addCaseInfo['updated_by']=$createdById;
            $addCaseInfo['updated_date']=date('Y-m-d H:i:s');
            $addCaseInfo['last_updated_date']=date('Y-m-d H:i:s');
            $addCaseInfo['customer_id']=$updateId;
            $addCaseInfo['ncb_transfer']=$userInfo['ncb_trans'];
            if(!empty($userInfo['left_menu_status'])){
            $addCaseInfo['left_menu_status'] = $userInfo['left_menu_status'];    
            } 
            $this->db->where('customer_id', $updateId);
            $this->db->where('is_latest', '1');
            $this->db->update('crm_insurance_case_details', $addCaseInfo);
            return $updateId;
        }
        
        //return $result;
    }
    
    public function addInsHistory($data)
    {
        $this->db->insert('insurance_history_log', $data);
        $insert_id = $this->db->insert_id();
        return $result = $insert_id;
    }

    public function addInsHistoryUpdateLog($data)
    {
        $this->db->insert('insurance_history_update_log', $data);
        $insert_id = $this->db->insert_id();
        return $result = $insert_id;
    }
    
    public function updateInsuranceCase($addCaseInfo,$updateId){
            $this->db->where('customer_id', $updateId);
            $this->db->update('crm_insurance_case_details', $addCaseInfo);
           //echo $this->db->last_query(); exit;
           return $updateId;
    }
    
    public function updateInsuranceCaseById($addCaseInfo,$updateId){
            $this->db->where('id', $updateId);
            $this->db->update('crm_insurance_case_details', $addCaseInfo);
            return $updateId;
    }
    
    public function addInsuranceCustomer($userInfo, $updateId = ''){
        //print_r($userInfo);exit;
        if (empty($updateId)) {
            $this->db->insert('crm_insurance_customer_details', $userInfo);
            $insert_id = $this->db->insert_id();
            $result= $insert_id;
        } else {
            $this->db->where('id', $updateId);
            $this->db->update('crm_insurance_customer_details', $userInfo);
            //echo $this->db->last_query();die;
            return $updateId;
        }
           //echo $this->db->last_query();die;
        return $result;
    }
    
     public function addInsuranceCases($userInfo, $updateId = ''){
        //print_r($userInfo);exit;
        if (empty($updateId)) {
            $userInfo['created_date']=date('Y-m-d H:i:s');
            $userInfo['left_menu_status'] = INSURANCE_LEFT_SIDE_MENU['CASE_DETAILS'];
            $this->db->insert('crm_insurance_case_details', $userInfo);
            $insert_id = $this->db->insert_id();
            $result= $insert_id;
        } else {
            $this->db->where('id', $updateId);
            $this->db->update('crm_insurance_case_details', $userInfo);
            //echo $this->db->last_query();die;
            return $updateId;
        }
        return $result;
    }

    public function getCaseDetails($caseid='',$engineno='',$chassisno=''){
        $da = date('Y-m-d');
        $da1 =  date('Y-m-d', strtotime(date('Y-m-d')) - 60*60*24*30);
        $this->db->select('cd.id,cd.customer_id,cd.ins_category,icd.buyer_type,icd.customer_status,icd.inception_date,cd.engineNo,cd.chasisNo,icd.premium');
        $this->db->from('crm_insurance_case_details as cd');
        $this->db->join('crm_insurance_customer_details  as icd', 'cd.customer_id = icd.id','inner');
        if(!empty($caseid)){
            $this->db->where_in('cd.id', $caseid);
            $this->db->where_in('cd.renew_flag', '0');
        }
        if(!empty($engineno)){
            $this->db->where('cd.engineNo', $engineno);
            $this->db->where('icd.inception_date<=',$da);
            $this->db->where('icd.inception_date>=',$da1);
            $this->db->where('icd.mi_funding','1');
        }
        if(!empty($chassisno)){
            $this->db->where('cd.chasisNo', $chassisno);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $result = $query->result_array();
        return $result;
    }
    
    public function getCaseDetailsByCustomerId($customerId){
        $this->db->select('cd.id,cd.left_menu_status,cd.ins_category,icd.buyer_type,icd.customer_status,cd.last_updated_status,icd.isexpired,icd.customer_company_name,icd.customer_name,cd.zone,cd.cc,icd.premium,cd.follow_status,cd.renew_flag');
        $this->db->from('crm_insurance_case_details as cd');
        $this->db->join('crm_insurance_customer_details  as icd', 'cd.customer_id = icd.id','inner');
        $this->db->where_in('cd.customer_id', $customerId);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $result = $query->result_array();
        return $result;
    }
    
    public function getcustomerLeadId($mobile){
        $this->db->select('lc.id as leadId');
        $this->db->from('crm_customers as lc');
        $this->db->where('lc.mobile', $mobile);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $result = $query->row_array();
    }
    
    public function getcustomerDetailsByLeadId($id){
        $this->db->select('pd.customer_id as leadId');
        $this->db->from('crm_customer_personnel_details as pd');
        $this->db->where('pd.customer_id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $result = $query->row_array();
    }
    
    public function addNewPersonalCustomer($data){
       $this->db->insert('crm_customer_personnel_details', $data);
        $insert_id = $this->db->insert_id();
        //echo $this->db->last_query();die;
        return $result= $insert_id; 
    }
    
    public function getcustomerLeadIdById($id){
        $this->db->select('cd.crm_customer_id as leadId');
        $this->db->from('crm_insurance_customer_details as cd');
        $this->db->where('cd.id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $result = $query->row_array();
    }
    
    public function addNewleadCustomer($userInfo){
        $this->db->insert('crm_customers', $userInfo);
        $insert_id = $this->db->insert_id();
        //echo $this->db->last_query();die;
        return $result= $insert_id;
    }
    
    public function getCustomerInfo($customer_id='',$partPaymentId='',$flag =""){
       $this->load->model('Crm_insurance_part_payment');

       $this->db->select('cd.*,cd.id as cust_id,lc.*,icd.*,mm.make as makeName,mm.model as modelName,mv.db_version as versionName,pi.prev_policy_insurer_name as previnsurerName,pi.short_name,ci.short_name as curr_short_name,mv.uc_fuel_type,iq.totpremium as totalpremium,iq.own_damage,iq.insurance_company as new_ins_company,'
               . 'ccmp.short_name as current_accepted_company,icd.id as sno,icd.ncb_transfer,'
               .  'ido.road_side_assistance,ido.road_side_assistance_txt,ido.loss_of_personal_belonging,ido.driver_cover,ido.personal_acc_cover,ido.passenger_cover,ido.anti_theft,ido.add_on,'
                . 'ido.loss_of_personal_belonging_txt,ido.emergency_transport_hotel_premium_txt,ido.driver_cover_txt,ido.passenger_cover_txt,ido.anti_theft_txt,ido.personal_acc_cover_txt,iq.qsource as source_id');
       $this->db->from('crm_insurance_customer_details cd');
       $this->db->join('crm_customers lc','cd.crm_customer_id=lc.id','left');
       $this->db->join('crm_insurance_case_details icd','icd.customer_id=cd.id','left');
       $this->db->join('model_version as mv', 'mv.db_version_id=icd.variantId','left');
       $this->db->join('make_model as mm', 'mm.id=mv.model_id','left');
       $this->db->join('crm_prev_policy_insurer as pi', 'pi.prev_policy_insurer_slug=cd.previous_insurance_company','left');
       $this->db->join('crm_prev_policy_insurer as ci', 'ci.prev_policy_insurer_slug=cd.current_insurance_company','left');
       $this->db->join('crm_insurance_quotes as iq', 'iq.customer_id=cd.id and iq.flag="1"','left');
       $this->db->join('crm_prev_policy_insurer as ccmp', 'iq.insurance_company=ccmp.prev_policy_insurer_slug','left');
       $this->db->join('crm_insurance_quotes_addon as ido', 'ido.quote_id=iq.id','left');
       if(!empty($customer_id))
        $this->db->where('cd.id', $customer_id);

       $query = $this->db->get();
       $result = $query->result_array();
      // echo "<pre>";print_r($result);die;
       if(!empty($result)){
            $partpayments = $this->Crm_insurance_part_payment->getCustomerPartPayment($customer_id);
            $PaymentDetails = $this->Crm_insurance_part_payment->getCustomerPaymentDetails($customer_id,$partPaymentId,$flag);
            $data = current($result);
            $data['customerPartPayments'] =  $partpayments; 
            $data['PartPaymentDetails']   =  $PaymentDetails;
            return [$data];
       }
       return  $result;     

    }

    public function getCustomerInfoMigrartion(){
       $this->load->model('Crm_insurance_part_payment');

       $this->db->select('cd.*,cd.id as cust_id,lc.*,icd.*,mm.make as makeName,mm.model as modelName,mv.db_version as versionName,pi.prev_policy_insurer_name as previnsurerName,pi.short_name,ci.short_name as curr_short_name,mv.uc_fuel_type,iq.totpremium as totalpremium');
       $this->db->from('crm_insurance_customer_details cd');
       $this->db->join('crm_customers lc','cd.crm_customer_id=lc.id','left');
       $this->db->join('crm_insurance_case_details icd','icd.customer_id=cd.id','left');
       $this->db->join('model_version as mv', 'mv.db_version_id=icd.variantId','left');
       $this->db->join('make_model as mm', 'mm.id=mv.model_id','left');
       $this->db->join('crm_prev_policy_insurer as pi', 'pi.prev_policy_insurer_slug=cd.previous_insurance_company','left');
       $this->db->join('crm_prev_policy_insurer as ci', 'ci.prev_policy_insurer_slug=cd.current_insurance_company','left');
       $this->db->join('crm_insurance_quotes as iq', 'iq.customer_id=cd.id and iq.flag="1"','left');
       $query = $this->db->get();
       $result = $query->result_array();
        
       return  $result;     

    }
    public function getInsurance($requestParams, $dealerId,$userId,$flag='',$con='')
    {
        $responseData = array();
        $getleads=$this->getInsleadsQuery($requestParams,2);
        //$totalRecords = count($this->getInsleadsQuery($requestParams, $perPageRecord, $pageNo, $startLimit,'1'));
        $totalRecords = count($getleads);
        $leads = array();
        if (!empty($getleads)) {
            $i = 0;
            foreach ($getleads as $key => $val) {
                    $leads[$i]['sno']=$val['sno'];
                $leads[$i]['caseId']=$val['caseId'];
                $leads[$i]['customer_id']=$val['customer_id'];
                $leads[$i]['dealerID'] = $dealerId;
                $leads[$i]['emailID'] = (stripos($val['customer_email'], "null") == true ? '' : $val['customer_email']);
                //$leads[$i]['changetime'] = $val['created_date'];
                $name = ucwords(strtolower(preg_replace("/[^a-zA-Z\s]/", "", $val['customer_name'])));
                $leads[$i]['customer_name'] = (stripos($name, "null") == true ? '' : $name);
                $leads[$i]['customer_company_name'] = $val['customer_company_name'];
                $leads[$i]['customer_mobile'] =$val['mobile'];
                $leads[$i]['city_name']=ucwords(strtolower(preg_replace("/[^a-zA-Z\s]/", "", $val['city_name'])));
                $leads[$i]['customer_nominee_ref_name']=ucwords(strtolower(preg_replace("/[^a-zA-Z\s]/", "", $val['customer_nominee_ref_name'])));
                $leads[$i]['mi_funding'] = $val['mi_funding'];
                $leads[$i]['customer_company_name'] = $val['customer_company_name'];
                $leads[$i]['number'] = preg_replace("/[^0-9]/", "", $val['mobile']);
                $leads[$i]['mmv'] = $val['makeName']."-".$val['modelName']."-".$val['versionName'];
                $leads[$i]['make'] = $val['makeName'];
                $leads[$i]['model'] = $val['modelName'];
                $leads[$i]['version'] = $val['versionName'];
                $leads[$i]['regNo'] =$val['regNo'];
                $leads[$i]['ins_category'] =$val['ins_category'];
                $leads[$i]['isexpired'] =$val['isexpired'];
                $leads[$i]['dealerName'] =$val['dealerName'];
                $leads[$i]['source'] =  ucfirst(strtolower($val['source']));
                $leads[$i]['lead_status_id'] = $val['follow_status'];
                $leads[$i]['lead_status'] = $val['status_name'];
                $leads[$i]['make_year'] = $val['make_year'];
                $leads[$i]['leadCreatedDate'] = ($val['addDate']!='0000-00-00') ? date("d M, Y",strtotime($val['addDate'])) : '';
                $leads[$i]['last_updated_date'] = ($val['last_updated_date']!='0000-00-00 00:00:00') ? date("d M, Y",strtotime($val['last_updated_date'])) : '';
                $leads[$i]['created_date'] = ($val['created_date']!='') ? date("d M, Y",strtotime($val['created_date'])) : '';
                $leads[$i]['make_year'] = $val['make_year'];
                $leads[$i]['insurer_name']=$val['short_name'];
                $leads[$i]['due_date'] = ( ($val['current_due_date']!='0000-00-00') && (!empty($val['current_due_date'])) ) ? date("d M, Y",strtotime($val['current_due_date'])) : '';
                $leads[$i]['assign_to'] = $val['assign_to'];
                $leads[$i]['employeeName'] = $val['employeeName'];
                $leads[$i]['current_policy_no'] = $val['current_policy_no'];
                $leads[$i]['previous_policy_no'] = $val['previous_policy_no'];
                $leads[$i]['previous_due_date'] = ($val['previous_due_date']!='0000-00-00') ? date("d M, Y",strtotime($val['previous_due_date'])) : '';
                $leads[$i]['follow_up_date']=$val['follow_date'];
                //$leads[$i]['comment']=$val['comment'];
                $leads[$i]['quote_add_date']=($val['quote_add_date']!='0000-00-00 00:00:00') ? date("d M,Y",strtotime($val['quote_add_date'])):'';
                $leads[$i]['payment_date']=($val['payment_date']!='0000-00-00' && !empty($val['payment_date']) ) ? date("d M, Y",strtotime($val['payment_date'])):'';
                $leads[$i]['upload_ins_doc_flag']=$val['upload_ins_doc_flag'];
                $leads[$i]['od_amt']= $val['od_amt'] ;
                $idv = !empty($val['idv'])?$this->IND_money_format($val['idv']):"";
                $leads[$i]['idv']= !empty($val['insidv'])? $this->IND_money_format($val['insidv']) : $idv ;
                $leads[$i]['current_insurance_company']=$val['current_insurance_company'];
                $leads[$i]['previous_insurance_company']=$val['previous_insurance_company'];
                $leads[$i]['inspection_add_date']=($val['inspection_add_date']!='0000-00-00 00:00:00') ? date("d M, Y",strtotime($val['inspection_add_date'])) : '';
                $leads[$i]['customer_address']=$val['customer_address'];
                $leads[$i]['ins_approval_status']=$val['ins_approval_status'];
                $leads[$i]['quote_shared_status']=$val['quote_shared_status'];
                $leads[$i]['inspection_status']=$val['inspection_status'];
                $leads[$i]['policy_status']=$val['policy_status'];
                $leads[$i]['updateStatus']=$val['updateStatus'];
                $leads[$i]['buyer_type'] = $val['buyer_type'];
                $leads[$i]['payment_by'] = $val['payment_by'];
                $leads[$i]['short_name'] = $val['short_name'];
                $leads[$i]['totalpremium'] = !empty($val['totalpremium'])? $this->IND_money_format($val['totalpremium']) : '' ;
                $leads[$i]['cc']         = $val['cc'];
                $leads[$i]['current_issue_date']         = ($val['current_issue_date']!='0000-00-00' && !empty($val['current_issue_date'])) ? date("d M, Y",strtotime($val['current_issue_date'])) : '';
                $leads[$i]['in_payment_mode']            = $val['in_payment_mode'];
                $leads[$i]['in_payment_date']            = ($val['in_payment_date']!='0000-00-00 00:00:00' && !empty($val['in_payment_date'])) ? date("d M, Y",strtotime($val['in_payment_date'])) : '';
                $leads[$i]['payment_mode']               = $val['payment_mode'];
                $leads[$i]['premium']                    = !empty($val['totalpremium'])?$leads[$i]['totalpremium']:$val['premium'];
                $leads[$i]['assignedto_name']            = $val['assignedto_name'];
                $leads[$i]['insurance_category_name']    = $val['insurance_category_name'];
                $leads[$i]['prev_policy_insurer_name']   = $val['prev_policy_insurer_name'];
                $leads[$i]['own_damage']                 = !empty($val['own_damage'])? $this->IND_money_format($val['own_damage']) : '' ;
                $leads[$i]['prev_company_short_name']    = $val['prev_company_short_name'];
                $leads[$i]['prev_company_full_name']     = $val['prev_company_full_name'];
                //$leads[$i]['sname'] = $val['sname'];
                //$inspArr = $this->getInspectedCompany($val['customer_id']);
                $leads[$i]['inspect_ins_name']=(!empty($val['inspect_ins_name']))?$val['inspect_ins_name'] : '';
                $leads[$i]['insurance_company']=(!empty($val['insurance_company']))?$val['insurance_company'] : '';
                $leads[$i]['current_policy_type'] = (!empty($val['current_policy_type']))?$val['current_policy_type']:'';
                $leads[$i]['inception_date']= ( ($val['inception_date']!='0000-00-00') && (!empty($val['inception_date'])) ) ? date("d M, Y",strtotime($val['inception_date'])) : '';
                 $leads[$i]['road_side_assistance']=(!empty($val['road_side_assistance']))?$val['road_side_assistance'] : '';
                $leads[$i]['road_side_assistance_txt']=(!empty($val['road_side_assistance_txt']))?$val['road_side_assistance_txt'] : '';
                $leads[$i]['loss_of_personal_belonging']=(!empty($val['loss_of_personal_belonging']))?$val['loss_of_personal_belonging'] : '';
                $leads[$i]['driver_cover']=(!empty($val['driver_cover']))?$val['driver_cover'] : '';
                $leads[$i]['personal_acc_cover']=(!empty($val['personal_acc_cover']))?$val['personal_acc_cover'] : '';
                $leads[$i]['passenger_cover']=(!empty($val['passenger_cover']))?$val['passenger_cover'] : '';
                $leads[$i]['anti_theft']=(!empty($val['anti_theft']))?$val['anti_theft'] : '';
                $leads[$i]['add_on']=(!empty($val['add_on']))?$val['add_on'] : '';
                 $leads[$i]['loss_of_personal_belonging_txt']=(!empty($val['loss_of_personal_belonging_txt']))?$val['loss_of_personal_belonging_txt'] : '';
                $leads[$i]['emergency_transport_hotel_premium_txt']=(!empty($val['emergency_transport_hotel_premium_txt']))?$val['emergency_transport_hotel_premium_txt'] : '';
                $leads[$i]['driver_cover_txt']=(!empty($val['driver_cover_txt']))?$val['driver_cover_txt'] : '';
                $leads[$i]['passenger_cover_txt']=(!empty($val['passenger_cover_txt']))?$val['passenger_cover_txt'] : '';
                $leads[$i]['anti_theft_txt']=(!empty($val['anti_theft_txt']))?$val['anti_theft_txt'] : '';
                $leads[$i]['personal_acc_cover_txt']=(!empty($val['personal_acc_cover_txt']))?$val['personal_acc_cover_txt'] : '';
                if($flag=='1')
                {
                    $mode = '';
                    $cmode = '';
                    if(isset($requestParams['export']) && !empty($requestParams['export'])){
                    $re = $this->getPartPay($val['customer_id'],"",1);
                        $leads[$i]['npayment'] = $re['npayment'];
                        $leads[$i]['cpayment'] = $re['cpayment'];
                    }else{
                    $re = $this->getPartPay($val['customer_id'],1);
                    $leads[$i]['npayment_mode']=(!empty($re['npayment_mode']))?$re['npayment_mode'] : '';
                    $leads[$i]['npayment_date']=($re['npayment_date']!='0000-00-00' && !empty($re['npayment_date'])) ? date("d M, Y",strtotime($re['npayment_date'])) : '';
                    $leads[$i]['cpayment_mode']=(!empty($re['cpayment_mode']))?$re['cpayment_mode']: '';
                    $leads[$i]['cpayment_date']=($re['cpayment_date']!='0000-00-00' && !empty($re['cpayment_date'])) ? date("d M, Y",strtotime($re['cpayment_date'])) : '';
                    }
                }
                
                $i++;
            }
        }  
        return $leads;
    }

    
    public function getCustomerPaymentDetails($customer_id,$partpaymentId='')
    {
       $this->db->select('SUM(amount) as total_amount_paid,SUM(subvention_amt) as total_subvention, iq.totpremium as totalpremium');
       $this->db->from('crm_insurance_part_payment cpp');
       $this->db->join('crm_insurance_quotes as iq', 'iq.customer_id=cpp.customer_id and iq.flag="1"','left');
       $this->db->where('cpp.customer_id', $customer_id);
       $this->db->where('cpp.entry_type IN(1,2,3)');
       if(!empty($partpaymentId))
       $this->db->where('cpp.id NOT IN('.$partpaymentId.')');
       $query = $this->db->get();
       $result = $query->result_array();
       // echo $this->db->last_query();die;
       return $result; 
    }
    
    public function getCustomerPartPayment($customer_id,$partpaymentId='')
    {
       $this->db->select('cpp.*,cb.bank_name as bankname,pr.reason');
       $this->db->from('crm_insurance_part_payment cpp');
       $this->db->join('crm_customer_banklist as cb','cb.bank_id=cpp.bank_name','left');
       $this->db->join('crm_insurance_payment_reason as pr','cpp.reasonId=pr.reasonId','left');
       $this->db->where('cpp.customer_id', $customer_id);

       if(!empty($partpaymentId)){
        $this->db->where('cpp.id', $partpaymentId);
       }
       
       $query = $this->db->get();
       $result = $query->result_array();

       $partPayments = [];
       if(!empty($result)){
        foreach ($result as $key => $partPayment) {
            $partPayments[$partPayment['entry_type']][] = $partPayment;
        }
       }
       // echo $this->db->last_query();die;
       return  $partPayments; 
    }

    public function getPartPay($customer_id,$limit = "",$isExport = 0)
    {
           $data = [];
             $this->db->select('*');
             $this->db->from('crm_insurance_part_payment');
             $this->db->where_in('entry_type',array('1','2','3'));
             $this->db->where('customer_id',$customer_id);
             $this->db->order_by('id','DESC');
             if(!empty($limit)){
             $this->db->limit('1');    
             }
             
             $query = $this->db->get();
             $paymtn =  $query->result_array();
             //echo $this->db->last_query();
             $this->db->select('*');
             $this->db->from('crm_insurance_part_payment');
             $this->db->where('entry_type','4');
             $this->db->where('customer_id',$customer_id);
             $this->db->order_by('id','DESC');
             if(!empty($limit)){
             $this->db->limit('1');
             }
             $query = $this->db->get();
             $paymtc =  $query->result_array();
            // echo $this->db->last_query(); exit;
             
             if(!empty($paymtn))
             {
                $mode  = '';
                
                if($isExport){
                    foreach($paymtn as $x => $val){
                       if((!empty($val['payment_mode'])) && ($val['payment_mode']=='1'))
                    {
                        $mode = 'Cheque';
                    }
                    if((!empty($val['payment_mode']))&& ($val['payment_mode']=='2'))
                    {
                        $mode = 'Online';
                    }
                    if((!empty($val['payment_mode']))&& ($val['payment_mode']=='3'))
                    {
                        $mode = 'Cash';
                    }
                    if((!empty($val['payment_mode']))&& ($val['payment_mode']=='4'))
                    {
                        $mode = 'DD';
                    }
                    $data['npayment'][$x]['mode'] =  $mode;
                    $data['npayment'][$x]['date'] = $val['payment_date'];
                    $data['npayment'][$x]['amount'] = $val['amount'];
                    $data['npayment'][$x]['instrument_no'] = $val['instrument_no'];
                    $data['npayment'][$x]['payment_by'] = $val['payment_by'];
                    
                    }
                }else{
                
                
                if((!empty($paymtn[0]['payment_mode'])) && ($paymtn[0]['payment_mode']=='1'))
                    {
                        $mode = 'Cheque';
                    }
                    if((!empty($paymtn[0]['payment_mode']))&& ($paymtn[0]['payment_mode']=='2'))
                    {
                        $mode = 'Online';
                    }
                    if((!empty($paymtn[0]['payment_mode']))&& ($paymtn[0]['payment_mode']=='3'))
                    {
                        $mode = 'Cash';
                    }
                    if((!empty($paymtn[0]['payment_mode']))&& ($paymtn[0]['payment_mode']=='4'))
                    {
                        $mode = 'DD';
                    }
                  
                $data['npayment_mode'] =  $mode;
                $data['npayment_date'] = $paymtn[0]['payment_date'];
                }
             }
             if(!empty($paymtc))
             {
                $cmode  = '';
                if($isExport){
                   foreach($paymtc as $y => $v){
                       if((!empty($v['payment_mode'])) && ($v['payment_mode']=='1'))
                    {
                        $cmode = 'Cheque';
                    }
                    if((!empty($v['payment_mode']))&& ($v['payment_mode']=='2'))
                    {
                        $cmode = 'Online';
                    }
                    if((!empty($v['payment_mode']))&& ($v['payment_mode']=='3'))
                    {
                        $cmode = 'Cash';
                    }
                    if((!empty($v['payment_mode']))&& ($v['payment_mode']=='4'))
                    {
                        $cmode = 'DD';
                    }
                    $data['cpayment'][$y]['mode'] = $cmode;
                    $data['cpayment'][$y]['date'] = $v['payment_date'];
                    $data['cpayment'][$y]['amount'] = $v['amount'];
                    $data['cpayment'][$y]['instrument_no'] = $v['instrument_no'];
                    $data['cpayment'][$y]['payment_by'] = $v['payment_by'];
                    
                    } 
                }else{
                  if((!empty($paymtc[0]['payment_mode']))&& ($paymtc[0]['payment_mode']=='1'))
                    {
                        $cmode = 'Cheque';
                    }
                    if((!empty($paymtc[0]['payment_mode']))&& ($paymtc[0]['payment_mode']=='2'))
                    {
                        $cmode = 'Online';
                    }
                    if((!empty($paymtc[0]['payment_mode']))&& ($paymtc[0]['payment_mode']=='3'))
                    {
                        $cmode = 'Cash';
                    }
                    if((!empty($paymtc[0]['payment_mode']))&& ($paymtc[0]['payment_mode']=='4'))
                    {
                        $cmode = 'DD';
                    }
                $data['cpayment_mode'] = $cmode;
                $data['cpayment_date'] = $paymtn[0]['payment_date'];
                }
                
                    }

             return $data;
    }
    
     public function getInsleadsQuery($requestParams, $flag = ""){
        $requestParams['rpp']=10;
        $daysCount = 30;
        $perPageRecord = $requestParams['rpp'] == 0 ? 1 : $requestParams['rpp'];
        $pageNo = (isset($requestParams['page']) && $requestParams['page'] != '') ? $requestParams['page'] : '1';
        $startLimit = ($pageNo - 1) * $perPageRecord;
              
        $lastdaydate = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 7));
        $lastdaydate90 = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 90));
        if($flag == 1 || $flag == 2){
        $this->db->select('icd.id as sno,icd.cc,icd.id as caseId,cd.id as customer_id,cd.customer_nominee_ref_name,cd.customer_name,cd.customer_company_name,lc.mobile,icd.regNo,icd.ins_category,cd.isexpired,icd.source,icd.follow_status,cs.status_name,icd.make_year,icd.last_updated_date,icd.created_date,cd.current_due_date,icd.assign_to, (CASE WHEN cd.in_payment_mode = "1" THEN "Cheque" WHEN cd.in_payment_mode = "2" THEN "Online" ELSE "--" END) as in_payment_mode, (CASE WHEN cd.payment_mode = "1" THEN "Cheque" WHEN cd.payment_mode = "2" THEN "Online" WHEN cd.payment_mode = "3" THEN "CASH" WHEN cd.payment_mode = "4" THEN "DD" ELSE "--" END) as payment_mode,
         (CASE WHEN ins_category = "1" THEN "New Car" WHEN ins_category = "2" THEN "Used Car Purchase" WHEN ins_category = "3" THEN "Renewal" WHEN ins_category = "4" THEN "Policy Already Expired" END) AS insurance_category_name ,cd.current_policy_no,cd.previous_policy_no,cd.previous_due_date,icd.follow_up_date as follow_date,icd.quote_add_date,cd.payment_date,icd.upload_ins_doc_flag,cd.od_amt,cd.idv,cd.current_insurance_company,pp.short_name,cd.previous_insurance_company,icd.inspection_add_date,cd.customer_address,icd.ins_approval_status,icd.quote_shared_status,icd.inspection_status,icd.policy_status,cd.buyer_type,cd.payment_by,c.city_name,cs.id as lead_status_id,
         icd.follow_up_date as follow_date,mm.make as makeName,mm.model as modelName,mv.db_version as versionName,d.organization as dealerName,u.name as employeeName,icd.created_date as addDate,ust.status as updateStatus,pp.short_name as inspect_ins_name,ppins.short_name as prev_company_short_name,ppins.prev_policy_insurer_name as prev_company_full_name,cd.current_issue_date,cd.premium,iq.totpremium as totalpremium,cd.in_payment_date,u.name as assignedto_name,
         pp.prev_policy_insurer_name,iq.own_damage,cd.is_payment_completed,iq.idv as insidv,ci.short_name as insurance_company,cd.inception_date,cd.mi_funding,(CASE WHEN cd.current_policy_type = "1" THEN "Comprehensive" WHEN cd.current_policy_type = "2" THEN "Third Party" ELSE " " END) as current_policy_type,
         ido.road_side_assistance,ido.road_side_assistance_txt,ido.loss_of_personal_belonging,ido.driver_cover,ido.personal_acc_cover,ido.passenger_cover,ido.anti_theft,ido.add_on,
         ido.loss_of_personal_belonging_txt,ido.emergency_transport_hotel_premium_txt,ido.driver_cover_txt,ido.passenger_cover_txt,ido.anti_theft_txt,ido.personal_acc_cover_txt');
        }else{
          $this->db->select('icd.id as sno');  
        }
        $this->db->from('crm_insurance_case_details as icd');
        $this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id','inner');
        $this->db->join('crm_customers as lc', 'lc.id=cd.crm_customer_id and lc.mobile> 0','inner');
        $this->db->join('crm_prev_policy_insurer as pp', 'pp.prev_policy_insurer_slug=cd.current_insurance_company','left');
        if($flag == 1 || $flag == 2){   
            $this->db->join('city_list as c', 'c.city_id=cd.customer_city_id','left');
            $this->db->join('crm_prev_policy_insurer as ppins', 'ppins.prev_policy_insurer_slug=cd.previous_insurance_company','left');
            $this->db->join('crm_insurance_customer_status AS cs', 'cs.id=icd.follow_status','left');
            $this->db->join('model_version as mv', 'mv.db_version_id=icd.variantId','left');
            $this->db->join('make_model as mm', 'mm.id=mv.model_id','left');
            
            if($flag == 2){
                $this->db->join('crm_insurance_part_payment as ipp1', 'icd.customer_id=ipp1.customer_id and ipp1.entry_type in (1,3,2)','left');
                $this->db->join('crm_insurance_part_payment as ipp2', 'icd.customer_id=ipp2.customer_id and ipp2.entry_type in (4)','left');
            }            
        }
        $this->db->join('crm_insurance_update_status as ust', 'ust.statusId=icd.last_updated_status','left');          
        $this->db->join('crm_dealers as d', 'd.id=icd.dealer_id and d.status="1"','left');
        $this->db->join('crm_user as u', 'u.id=icd.assign_to and u.status="1"','left');
        $this->db->join('crm_insurance_quotes as iq', 'iq.case_id=icd.id and iq.flag="1"','left');
        $this->db->join('crm_prev_policy_insurer as ci', 'iq.insurance_company=ci.prev_policy_insurer_slug','left');
        $this->db->join('crm_insurance_quotes_addon as ido', 'ido.quote_id=iq.id','left');
       // $this->db->join('crm_insurance_inspection as ins', 'pp.prev_policy_insurer_slug=ins.inspect_company and ins.is_latest="1" and ins.inspect_status="1"','left');
              
        $teamn = !empty($this->session->userdata['userinfo']['team_name'])?$this->session->userdata['userinfo']['team_name']:'';
        $rolen = !empty($this->session->userdata['userinfo']['role_name'])?$this->session->userdata['userinfo']['role_name']:'';
        if(($teamn=='Sales') && ($rolen=='Executive')){
          $this->db->where('icd.sales_id',$requestParams['userId']);  
        }
        if((!empty($requestParams['userId']) && $requestParams['userId'] > 0 && $requestParams['userId']!='1') && (($teamn=='Insurance' && $teamn !='Sales') && ($rolen!='Lead'))){
            $this->db->where('icd.assign_to',$requestParams['userId']); 
        }
        $this->db->where('icd.renew_flag','0');
        $this->InsGetLeadsFilter($requestParams);
        $this->db->group_by(array('icd.id'));
        $this->db->order_by('icd.last_updated_date','DESC');
        if($flag == 1){
            if (isset($requestParams['page'])){
              $this->db->offset((int) ($startLimit));
            }
            if (!empty($perPageRecord)){
               $this->db->limit((int) $perPageRecord);
            }
        } 
        $query = $this->db->get();
        $leads =  $query->result_array();
        return  $leads;
    }
    public function InsGetLeadsFilter($requestParams) {
       // echo $requestParams['ins_policy'];die;
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
            if($requestParams['insdashId']=='5'){
                $select->where("icd.last_updated_status IN(6,9)");
                $select->where("(icd.upload_ins_doc_flag != '1' OR icd.left_menu_status !=".INSURANCE_LEFT_SIDE_MENU['UPLOAD_DOCS'].")");            
                $select->where("cd.current_policy_no != '0' AND cd.current_policy_no is not null AND cd.current_policy_no !=''");
            }
        }
        if (isset($requestParams['keyword']) && $requestParams['keyword'] != '') {
            $select->where("(cd.customer_name like '%" . trim($requestParams['keyword']) . "%' or cd.customer_company_name like '%". trim($requestParams['keyword']) . "%' or lc.mobile like '%" . trim($requestParams['keyword']). "%' or icd.regNo like '%" .trim($requestParams['keyword']). "%')");
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
        if (isset($requestParams['ins_status']) && $requestParams['ins_status'] != '') {
            
            if($requestParams['ins_status']=='1'){    
            $select->where("ust.statusId='1'");
            }
            if($requestParams['ins_status']=='2'){    
            $select->where("ust.statusId=2");
            }
            if($requestParams['ins_status']=='3'){    
            $select->where("ust.statusId=3");
            }
            if($requestParams['ins_status']=='4'){    
            $select->where("ust.statusId=4");
            }
            if($requestParams['ins_status']=='5'){    
            $select->where("ust.statusId=5");
            }
            if($requestParams['ins_status']=='6'){    
            $select->where("ust.statusId=6");
            }
            if($requestParams['ins_status']=='7'){    
            $select->where("ust.statusId=7");
            }
            if($requestParams['ins_status']=='8'){    
            $select->where("ust.statusId=8");
            }
            if($requestParams['ins_status']=='9'){    
            $select->where("(ust.statusId=9 OR (ust.statusId=9 AND cd.current_policy_no is not null))");
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
        if(isset($requestParams['searchdate']) && $requestParams['searchdate'] == 'quoteshared'){
            if (isset($requestParams['createStartDate']) && $requestParams['createStartDate'] != '') {
                $select->where("DATE(icd.quote_add_date) >=" ,$this->changeDateformat($requestParams['createStartDate']));
            }
            if (isset($requestParams['createEndDate']) && $requestParams['createEndDate'] != '') {
                $select->where("DATE(icd.quote_add_date) <=",$this->changeDateformat($requestParams['createEndDate']));
            }
        }
        if(isset($requestParams['searchdate']) && $requestParams['searchdate'] == 'inspectiondate'){
            if (isset($requestParams['createStartDate']) && $requestParams['createStartDate'] != '') {
                $select->where("DATE(icd.inspection_add_date) >=" ,$this->changeDateformat($requestParams['createStartDate']));
            }
            if (isset($requestParams['createEndDate']) && $requestParams['createEndDate'] != '') {
                $select->where("DATE(icd.inspection_add_date) <=",$this->changeDateformat($requestParams['createEndDate']));
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
        if(isset($requestParams['searchdate']) && $requestParams['searchdate'] == 'canceldate'){
                $select->where("icd.cancel_id!='0'");
                 $select->where("icd.last_updated_status='7'");
            if (isset($requestParams['createStartDate']) && $requestParams['createStartDate'] != '') {
                $select->where("DATE(icd.cancel_date) >=" ,$this->changeDateformat($requestParams['createStartDate']));
            }
            if (isset($requestParams['createEndDate']) && $requestParams['createEndDate'] != '') {
                $select->where("DATE(icd.cancel_date) <=",$this->changeDateformat($requestParams['createEndDate']));
            }
        }
        if(isset($requestParams['searchdate']) && $requestParams['searchdate'] == 'closeddate'){
            $select->where("icd.cancel_id!='0'");
                 $select->where("icd.last_updated_status='8'");
            if (isset($requestParams['createStartDate']) && $requestParams['createStartDate'] != '') {
                $select->where("DATE(icd.cancel_date) >=" ,$this->changeDateformat($requestParams['createStartDate']));
            }
            if (isset($requestParams['createEndDate']) && $requestParams['createEndDate'] != '') {
                $select->where("DATE(icd.cancel_date) <=",$this->changeDateformat($requestParams['createEndDate']));
            }
        }
        if(isset($requestParams['searchdate']) && $requestParams['searchdate'] == 'inceptiondate'){
            if (isset($requestParams['createStartDate']) && $requestParams['createStartDate'] != '') {
                $select->where("DATE(cd.inception_date) >=" ,$this->changeDateformat($requestParams['createStartDate']));
            }
            if (isset($requestParams['createEndDate']) && $requestParams['createEndDate'] != '') {
                $select->where("DATE(cd.inception_date) <=",$this->changeDateformat($requestParams['createEndDate']));
            }
        }
        if (isset($requestParams['ins_status']) && $requestParams['ins_status'] == 'noaction') {
            $select->where("icd.follow_status = '1'");
        }
        if (isset($requestParams['ins_status']) && $requestParams['ins_status'] == 'interested') {
            $select->where("icd.follow_status = '2'");
        }
        if (isset($requestParams['ins_status']) && $requestParams['ins_status'] == 'policypunched') {
            $select->where("icd.follow_status = '3'");
        }
        if (isset($requestParams['ins_status']) && $requestParams['ins_status'] == 'closed') {
            $select->where("icd.follow_status = '4'");
        }

    }    
    
    function leadTabCounts($request,$dealerId) {
        $data = array();
        
        $this->db->select("sum(CASE WHEN (icd.follow_status = '1') THEN 1 ELSE 0 END) AS followup,sum(CASE WHEN (icd.follow_status='2') THEN 1 ELSE 0 END) as Interested,sum(CASE WHEN (icd.follow_status='3') THEN 1 ELSE 0 END) as policyPunched,sum(CASE WHEN (icd.follow_status='4') THEN 1 ELSE 0 END) AS closed");
        $this->db->from('crm_insurance_case_details as icd');
        $this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id','inner');
        $this->db->join('crm_customers as lc', 'lc.id=cd.crm_customer_id','inner');
        $this->db->join('city_list as c', 'c.city_id=cd.customer_city_id','left');
        $this->db->join('crm_prev_policy_insurer as pp', 'pp.prev_policy_insurer_slug=cd.current_insurance_company','left');
        $this->db->join('crm_insurance_customer_status AS cs', 'cs.id=icd.follow_status','left');
        //$this->db->where("icd.dealer_id", $request['ucdid']);
        //$this->db->where("icd.dealer_id", $dealerId);
        //$this->db->where("icd.dealer_id>", '0');
        $this->db->where("lc.mobile>", '0');
        $this->InsGetLeadsFilter($request);
        //$this->db->group_by("icd.id");
       
        $query = $this->db->get();
        $data =  current($query->result_array());
       echo $str = $this->db->last_query();
        return $data;
    }
    public function getInspectedCompany($customerId){
      $this->db->select('pp.short_name as company_name');
            $this->db->from('crm_insurance_inspection ins');
            $this->db->join('crm_prev_policy_insurer as pp', 'pp.prev_policy_insurer_slug=ins.inspect_company','inner');
            $this->db->where('ins.customer_id', $customerId);
            $this->db->where('ins.inspect_status', '1');
            $this->db->where('ins.is_latest', '1');
            $this->db->where('ins.priority', '1');
            $this->db->order_by('ins.updated_on','DESC');
            $this->db->limit(1);
            $query = $this->db->get();
            //echo $str = $this->db->last_query();
            $data =  $query->result_array();
            return $data;
    }
    public function getCustomerDetail($data)
    {
        return current($this->select(
            function (Select $select) use ($data) {
                $select->columns(["*"]);
                $select->where(['mobile' => $data['mobile'],'dealer_id' => $data['dealer_id']]);
                
               //echo str_replace('"', '', $select->getSqlString()); exit;
            }
        )->toArray());
    }
    
    public function checkExistingHistory($activityId, $status, $leadId,$history_type)
    {
        //ini_set('display_errors', 2);
        //error_reporting(E_ALL);
        if($activityId=='3'){
            $status= date('Y-m-d', strtotime($status));
            $this->db->select('*');
            $this->db->from('crm_insurance_inq_history');
            $this->db->where('customer_id', $leadId);
            $this->db->where('activity', $activityId);
            $this->db->where('history_type', $history_type);
            $this->db->where(" date_format(created_date, '%Y-%m-%d') = '$status'");
            $query = $this->db->get();
            $currentStatus =  current($query->result_array());
            
        }else if($activityId=='2'){
            //echo $history_type;die;
            $currentDate= date('Y-m-d', strtotime(date('Y-m-d')));
            $this->db->select('*');
            $this->db->from('crm_insurance_inq_history');
            $this->db->where('customer_id', $leadId);
            $this->db->where('activity', $activityId);
            $this->db->where('history_type', $history_type);
            $this->db->where('activity_text', $status);
            $this->db->where(" date_format(created_date, '%Y-%m-%d') = '$currentDate'");
            $query = $this->db->get();
            //echo $this->db->last_query();die;
            $currentStatus =  current($query->result_array());
            
            
        if($currentStatus){
           $activity_text          = $currentStatus['activity_text'];
            //echo strtolower($status)."==". strtolower($activity_text);exit;
                if(strtolower($status)== strtolower($activity_text)){
                    $currentStatus= true;
                }
                else {
                    $currentStatus=false;
                }
            }
       // p($currentStatus);
        }else {
            $this->db->select('*');
            $this->db->from('crm_insurance_inq_history');
            $this->db->where('customer_id', $leadId);
            $this->db->where('activity', $activityId);
            $this->db->where('history_type', $history_type);
            $this->db->where('activity_text', $status);
            $this->db->where(" date_format(created_date, '%Y-%m-%d') = '$currentDate'");
            $query = $this->db->get();
            $currentStatus =  current($query->result_array());
            
            if($currentStatus){
           $activity_text          = $currentStatus['activity_text'];
            //echo strtolower($status)."==". strtolower($activity_text);exit;
                if(strtolower($status)== strtolower($activity_text)){
                    $currentStatus= true;
                }
                else {
                    $currentStatus=false;
                }
            }

        }
        if($currentStatus)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function getInshistory($customerId,$limit){
       $this->db->select('h.*,pp.short_name,u.name');
       $this->db->from('crm_insurance_inq_history as h');
       $this->db->join('crm_prev_policy_insurer as pp', 'pp.prev_policy_insurer_slug=h.company_id','left');
       $this->db->join('crm_user as u','u.id=h.user_id','left');
       $this->db->where('customer_id', $customerId);
        if(intval($limit)>0){
            $this->db->limit((int) $limit);
        }
        $this->db->order_by('created_date', 'DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $historyData=$query->result_array();
    }
    
    public function getInsQuotesHisDetail($customerId,$limit='',$sms='')
    {
        $this->db->select('*');
            $this->db->from('crm_insurance_quotes as q');
            $this->db->join('crm_prev_policy_insurer as pp', 'pp.prev_policy_insurer_slug=q.insurance_company','inner');
            $this->db->where('customer_id', $customerId);
            $this->db->where('is_latest', '1');
            if(intval($limit)>0){
                $this->db->limit((int) $limit);
            }
            if($sms > 0){
             //$this->db->where('q.sms', '1');   
            }
            $this->db->order_by('updated_on', 'DESC');
            $query = $this->db->get();
            //echo $this->db->last_query();die;
            return $historyData=$query->result_array();
        
    }
    public function getInsInspectionDetail($customerId,$limit='',$sms='')
    {
        $this->db->select('*');
            $this->db->from('crm_insurance_inspection as i');
            $this->db->join('crm_prev_policy_insurer as pp', 'pp.prev_policy_insurer_slug=i.inspect_company','inner');
            $this->db->where('customer_id', $customerId);
            $this->db->where('is_latest', '1');
            if(intval($limit)>0){
                $this->db->limit((int) $limit);
            }
            if(intval($sms)>0){
                $this->db->where('i.sms', '1');
            }
            $this->db->order_by('updated_on', 'DESC');
            $query = $this->db->get();
            //echo $this->db->last_query();die;
            return $historyData=$query->result_array();
        
    }
    public function getInsOtherHisDetail($customerId,$limit='')
    {
        $where_au = " ((cancel_id > '0') OR  (ins_approval_status > '0') OR (policy_status > '0'))" ;
        $this->db->select('icd.policy_status,icd.cancel_id,icd.ins_approval_status,icd.last_updated_date,icd.policy_issued_date,icd.cancel_date,pp.short_name');
            $this->db->from('crm_insurance_case_details as icd');
            $this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id','inner');
            $this->db->join('crm_prev_policy_insurer as pp', 'pp.prev_policy_insurer_slug=cd.current_insurance_company','left');
            $this->db->where('customer_id', $customerId);
            $this->db->where($where_au);
            //$this->db->where("cancel_id > '0'");
            //$this->db->where("reopen_date <> '0000-00-00 00:00:00'");
            if(intval($limit)>0){
                $this->db->limit((int) $limit);
            }
            $this->db->order_by('last_updated_date', 'DESC');
            $query = $this->db->get();
            //echo $this->db->last_query();
            return $historyData=$query->result_array();
        
    }
    
    public function getLeadHistory($lead_id, $total = '',$leadtype=''){
        $returnArray  = array();
        $total=intval($total);
        $limit        = ($total) ? "$total " : '';
        $source='';
        
        $historyData=$this->getHistoryDetail($lead_id,'','yes',$limit,$leadtype);
        if(!empty($historyData))
        {
            $response = [];
            $j        = 0;
            foreach($historyData as $key => $value)
            {
                $response[$j]['datetime'] = $value['created_date'];
                if($value['created_date']!=''){
              $historyOtherData=$this->getHistoryDetail($value['customer_id'],$value['combination_id'],'','',$leadtype);
                $i                          = 1;
                if(!empty($historyOtherData))
                {
                    foreach($historyOtherData as $k => $value)
                    {
                        //$response[$value['combination_id']]['datetime'] = $value->dateTime;
                        $keyvalue                  = array_search($value['activity'], $this->activity_mapping); // $key = 2;
                        $response[$j][$keyvalue] = $this->getActivityData($value,$leadtype);
                       //echo $keyvalue."=".$value;exit;
                        $i ++;
                    }
                }
              $j++;
            }
            }
        }
        else
        {
            return [];
        }
        //echo $i;die;
        //p($response);
        return $response;
    }
            
    public function getActivityData($data,$leadtype)
    {
        $data = (array) $data;
       if($data['activity'] == $this->activity_mapping['followup'])
        {
            $response['follow_up'] = $data['activity_text'];
        }
        else if($data['activity'] == $this->activity_mapping['comment'])
        {
            $response['comment_text'] = $data['activity_text'];
        }
        else if($data['activity'] == $this->activity_mapping['status'])
        {
            if($leadtype=='insurance'){
                $Status=$this->getStatus('0',$data['activity_text']);
            }else{
                $Status=$this->getStatus('1',$data['activity_text']);
            }
            $response['status_text'] = $Status[0]['name'];
        }
       return $response;
    } 
    public function getHistoryDetail($leadId,$comid,$groupby='',$limit='',$history_type)
    {
        $this->db->select('*');
            $this->db->from('crm_insurance_inq_history');
            $this->db->where('customer_id', $leadId);
            $this->db->where('history_type', $history_type);
            $this->db->where_in('activity', array('1','2'));
            if($groupby!='yes'){
                    $this->db->where('combination_id', $comid);
                }else{
                    $this->db->group_by(array('combination_id'));
                }
                if(intval($limit)>0){
                $this->db->limit((int) $limit);
                }
                $this->db->order_by('created_date', 'DESC');
            $query = $this->db->get();
            //echo $this->db->last_query();die;
            return $historyData=$query->result_array();
        
    }
    public function getStatus($type=0,$statusId=0)
    {
            $this->db->select('*');
            $this->db->from('inq_dealer_inquiry_status');
            $this->db->where('type', $type);
            if(intval($statusId)>0){
                    $select->where('id' , $statusId);
                }
            $query = $this->db->get();
            return $query->result_array();
    }
    
    public function saveInsurancehistory($historyInfo, $updateId = ''){
        //print_r($userInfo);exit;
        if (empty($updateId)) {
            $this->db->insert('crm_insurance_inq_history', $historyInfo);
            $insert_id = $this->db->insert_id();
            $result= $insert_id;
        } else {
            $this->db->where('id', $updateId);
            $this->db->update('crm_insurance_inq_history', $historyInfo);
            //echo $this->db->last_query();die;
            return $updateId;
        }
        return $result;
    }
    
    public function alreadyExistInsurancehistory($params){
        $this->db->select('h.id');
        $this->db->from('crm_insurance_inq_history h');
        $this->db->where('h.activity_text', $params['activity_text']);
        $this->db->where('h.customer_id', $params['customer_id']);
        $this->db->where('h.company_id', $params['company_id']);
        $this->db->where('h.history_type', 'insurance');
        $this->db->where('h.source', $params['source']);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $query->result_array();
    }
    
    public function getloanleadDetailsById($id){
        $this->db->select('*');
        $this->db->from('loan_customer_info ci');
        $this->db->where('ci.customer_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getCustomerDetailsById($id){
        $this->db->select('*');
        $this->db->from('crm_customer_personnel_details pd');
        $this->db->where('pd.customer_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function updatePersonalCustomerDetails($data,$customerLeadId){
       if(!empty($customerLeadId)){ 
       $this->db->where('customer_id', $customerLeadId);
       $this->db->update('crm_customer_personnel_details', $data);
       return $customerLeadId;
       }
    }
    public function addInsuranceQuotes($data,$customerId=''){
       if(!empty($customerId)){ 
         $this->db->where('customer_id', $customerId);
         $result=$this->db->update('crm_insurance_quotes', $data);  
       } else {
         $this->db->insert('crm_insurance_quotes', $data);
         $insert_id = $this->db->insert_id();
         $result= $insert_id;  
       }
       return $result;
    }
    public function updateInsuranceQuotes($data,$customerId){
      if(!empty($customerId)){ 
         $this->db->where('customer_id', $customerId);
         $result=$this->db->update('crm_insurance_quotes', $data);  
       }  
    }
    public function checkExistsQuotes($customerId){
        $this->db->select('q.id');
        $this->db->from('crm_insurance_quotes q');
        $this->db->where('q.customer_id', $customerId);
        $query = $this->db->get();
        return $query->result_array(); 
    }
    public function checkalreadyExistsQuotes($params){
        $this->db->select('q.id');
        $this->db->from('crm_insurance_quotes q');
        $this->db->where('q.case_id', $params['case_id']);
        $this->db->where('q.customer_id', $params['customer_id']);
        $this->db->where('q.insurance_company', $params['insurance_company']);
        $this->db->where('q.idv', $params['idv']);
        $this->db->where('q.premium', $params['premium']);
        $this->db->where('q.duration', $params['duration']);
        $this->db->where('q.logo', $params['logo']);
        $query = $this->db->get();
        return $query->result_array(); 
    }
    public function getQuotesList($caseId,$sms='',$flag=''){
        $this->db->select('q.*,qa.*,q.id as quote_id,qs.name as qsource');
        $this->db->from('crm_insurance_quotes q');
        //$this->db->join('crm_insurance_quotes_filter qf','q.customer_id=qf.customer_id','inner');
        $this->db->join('crm_insurance_quotes_addon qa','q.id=qa.quote_id','left');
        $this->db->join('crm_quote_source qs','qs.id=q.qsource','left');
        $this->db->where('q.is_latest', '1');
        if($sms!=''){
         $this->db->where('q.sms', '1');   
        }
        if($flag!=''){
         $this->db->where('q.flag', '1');   
        }
        $this->db->where('q.case_id', $caseId);
        $query = $this->db->get();
        return $query->result_array();  
    }
    public function getPayReason($type){
        $this->db->select('*');
        $this->db->from('crm_insurance_payment_reason p');
        $this->db->where('p.type', $type);
        $query = $this->db->get();
        return $query->result_array();  
    }
    
    public function checkExistsInspect($customerId){
        $this->db->select('q.id');
        $this->db->from('crm_insurance_inspection q');
        $this->db->where('q.customer_id', $customerId);
        $query = $this->db->get();
        return $query->result_array(); 
    }
    public function updateInspection($data,$customerId){
      if(!empty($customerId)){ 
         $this->db->where('customer_id', $customerId);
         $result=$this->db->update('crm_insurance_inspection', $data);  
       }  
    }
    public function updateInspectionById($Id){
      if(!empty($Id)){
         $data['is_latest']='0'; 
         $this->db->where('id', $Id);
         $result=$this->db->update('crm_insurance_inspection', $data);
         return true;
       }  
    }
    public function updateQuotesById($Id){
      if(!empty($Id)){
         $data['is_latest']='0'; 
         $this->db->where('id', $Id);
         $result=$this->db->update('crm_insurance_quotes', $data);
         return true;
       }  
    }
    
    public function getInspectionList($customerId){
        $this->db->select('*');
        $this->db->from('crm_insurance_inspection q');
        $this->db->where('q.is_latest', '1');
        $this->db->where('q.customer_id', $customerId);
        $query = $this->db->get();
        return $query->result_array();  
    }
    public function addInspectionData($data,$customerId=''){
       if(!empty($customerId)){ 
         $this->db->where('customer_id', $customerId);
         $result=$this->db->update('crm_insurance_inspection', $data);  
        } else {
         $this->db->insert('crm_insurance_inspection', $data);
         $insert_id = $this->db->insert_id();
         $result= $insert_id;  
       }
       return $result;
    }
    
    function changeDateformat($date) {
        if ($date != '') {
            $date_array = explode('/', date($date));
            $date = trim($date_array[2]) . '-' . trim($date_array[1]) . '-' . trim($date_array[0]);
            // $date=date('Y-m-d',strtotime($date));  
        }
        return $date;
    }
    function getlastStatusId($customerId){
        $this->db->select('icd.last_updated_status as lastStatus');
        $this->db->from('crm_insurance_case_details icd');
        $this->db->where('icd.customer_id', $customerId);
        //echo $this->db->last_query();die;
        $query = $this->db->get();
        return $query->result_array();
    }
    function getUserRole($roleId,$module){
        if($roleId > 0){
        $this->db->select('rm.module,rmp.add_permission,rmp.edit_permission,rmp.view_permission,r.role_name');
        $this->db->from('crm_right_management rm');
        $this->db->join('crm_right_management_mapping as rmp', 'rm.id=rmp.module_id','inner');
        $this->db->join('crm_role as r', 'r.id=rmp.role_id','left');
        $this->db->where('rm.module',$module);
        $this->db->where('rm.status', '1');
        $this->db->where('rmp.status', '1');
        $this->db->where('rmp.role_id', $roleId);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $query->result_array();
        }else{
            $permission=[];
            $permission[0]['add_permission']='0';
            $permission[0]['edit_permission']='0';
            $permission[0]['view_permission']='0';
            $permission[0]['role_name']='admin';
         return $permission;
        }
    }
    public function getInsInsurer($id)
    {
        $this->db->select('*');
            $this->db->from('crm_prev_policy_insurer as pp');
            $this->db->where('pp.prev_policy_insurer_slug', $id);
            $query = $this->db->get();
            //echo $this->db->last_query();die;
            return $historyData=$query->result_array();
        
    }
    function INS_money_format($number){        
        $money = floor($number);
        $length = strlen($money);
        $delimiter = '';
        $money = strrev($money);
        for($i=0;$i<$length;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
                $delimiter .=',';
            }
            $delimiter .=$money[$i];
        }
        $result = strrev($delimiter);
        return $result;
    }
    public function getsmsQuotes($customerId,$link=''){
        $smatext='';
        $organization = ORGANIZATION;
        $custInfo=current($this->getCustomerInfo($customerId));
        if(!empty($custInfo) && ($custInfo['buyer_type']=='1'))
        {
            $customerName=$custInfo['customer_name'];
            $customerMobile=$custInfo['mobile'];
        }else if(!empty($custInfo) && ($custInfo['buyer_type']=='2')){
            $customerName=$custInfo['customer_company_name'];
            $customerMobile=$custInfo['mobile'];
        }
        $leadMobile=$this->getleadMobile('Insurance');
        $leadMobiles=(!empty($leadMobile)) ? $leadMobile['mobile']:'';
        $smatext.='Hi '.$customerName.','. PHP_EOL;
        $smatext.='Please find quotes for your car by following insurer(s):'. PHP_EOL;
        $sms='1';
        $sQuotes=$this->getInsQuotesHisDetail($customerId,'',$sms);
       /* echo "<pre>";
        print_r($sQuotes);
        exit;
        */
        $i=1;
        foreach($sQuotes as $key=>$val){
             $smatext.=$i.'. '.$val['short_name']." (1 year policy)". PHP_EOL;
             $smatext.='IDV :'.$this->INS_money_format($val['idv']). PHP_EOL;
             $smatext.='Premium :'.$this->INS_money_format($val['totpremium']). PHP_EOL;
             $i++;
        }
        //$clickhere = '<a href="'.$link.'">Click here</a>';
        $smatext.='Click here'. PHP_EOL;
        $smatext.=$link. PHP_EOL;
        $smatext.=' to see the details of each Quotes.';
        $smatext.='Please call on '.$leadMobiles.' and get your car insurance renewed instantly'. PHP_EOL;
        $smatext.='-Team '.$organization.' '. PHP_EOL;
        //echo  $smatext; exit;
        $result=$this->SMS_INS($customerMobile,$smatext,'USDCAR');
        $smsdata=array();
        $smsdata['mobile']=$customerMobile;
        $smsdata['sms']=$smatext;
        $smsdata['source']='1';
        $smsdata['flag']=(!empty($result) && ($result=='1')) ? '1' : '0';
        $smsdata['smsDate']=date('Y-m-d h:i:s');
        $this->addSmsData($smsdata);
        return $result;
    }
    
    public function getsmsInspection($customerId){
        $smatext='';
        $custInfo=current($this->getCustomerInfo($customerId));
        if(!empty($custInfo) && ($custInfo['buyer_type']=='1'))
        {
            $customerName=$custInfo['customer_name'];
            $customerMobile=$custInfo['mobile'];
        }else if(!empty($custInfo) && ($custInfo['buyer_type']=='2')){
            $customerName=$custInfo['customer_company_name'];
            $customerMobile=$custInfo['mobile'];
        }
        $leadMobile=$this->getleadMobile('Insurance');
        $leadMobiles=(!empty($leadMobile)) ? $leadMobile['mobile']:'';
        $smatext.='Hi '.$customerName.','. PHP_EOL;
        $smatext.='As per your request, vehicle inspection has been scheduled for following insurer(s):'. PHP_EOL;
        $sms='1';
        $sQuotes=$this->getInsInspectionDetail($customerId,'',$sms);
        $i=1;
        $qarr=array();
        foreach($sQuotes as $key=>$val){
             $smatext.=$i.'. '.$val['short_name']. PHP_EOL;
             $qarr[]=$val['short_name'];
        }
        $arr1 = join(",",$qarr);
        $lastitem=end($qarr);
        $lastlen=strlen($lastitem);
        $newStr = rtrim(substr($arr1,0, -$lastlen),",");
        if($newStr){
         $smatext.=$newStr.' and ';   
        }
        $smatext.=$lastitem.' team will shortly get in touch with you for inspection procedure.'. PHP_EOL;
        $smatext.='Please call on '.$leadMobiles.' and get your car insurance renewed instantly'. PHP_EOL;
        $smatext.='-Team Bir Motors'. PHP_EOL;
        $result='';
        //$result=$this->SMS_INS($customerMobile,$smatext,'USDCAR');
        $smsdata=array();
        $smsdata['mobile']=$customerMobile;
        $smsdata['sms']=$smatext;
        $smsdata['source']='2';
        $smsdata['flag']=(!empty($result) && ($result=='1')) ? '1' : '0';
        $smsdata['smsDate']=date('Y-m-d h:i:s');
        //$this->addSmsData($smsdata);
        return $result;
    }
    
    function SMS_INS($mobile_sms, $smsText, $source) {
        $sms_data = array();
        //$sms_data['mobile']     = $mobile_sms;
        $sms_data['mobile']   = $mobile_sms;
        $sms_data['message']    = $smsText;
        $sms_data['source']     = 'USDCAR';
        $sms_data['priority']   = 5;
        $sms_data['NDNC']       = 1;
        $sms_data['sender']     = 'USDCAR';
        $sms_data['send_via']   = 'PINNACLE';

        $url                    = SMS_URL;
        $datas                  = $sms_data;
        $fields_string          = '';
        foreach ($datas as $keys => $values) {
            $fields_string .= $keys . '=' . $values . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    public function getleadMobile($type){
        $this->db->select('u.name,ad.organization,ad.mobile,r.role_name');
        $this->db->from('crm_user u');
        $this->db->join('crm_admin_dealers as ad', 'ad.dealer_id=u.dealer_id','inner');
        $this->db->join('crm_team_type as t', 'u.team_id=t.id','inner');
        $this->db->join('crm_role as r', 'u.role_id=r.id','inner');
        $this->db->where('t.team_name', $type);
        $this->db->where('u.status', '1');
        $this->db->where('t.status', '1');
        $this->db->where('r.status', '1');
        //echo $this->db->last_query();die;
        $query = $this->db->get();
        $result=$query->result_array();
        if($result){
            $userDetails=array();
            foreach($result as $ku=>$vu){
            if($vu['role_name']=='Lead'){
                $userDetails['role']=$vu['role_name'];
                $userDetails['mobile']=$vu['mobile'];
            }else if($vu['role_name']=='Executive'){
                $userDetails['role']=$vu['role_name'];
                $userDetails['mobile']=$vu['mobile'];
            }
            }
        }
        return $userDetails;
    }
    
    public function addSmsData($data){
        $this->db->insert('crm_insurance_sms', $data);
         $insert_id = $this->db->insert_id();
         $result= $insert_id;  
       return $result;
    }
    
    public function getmakeId($make)
    {
        $this->db->select('*');
            $this->db->from('car_make as m');
            $this->db->where('m.id', $make);
            $query = $this->db->get();
            //echo $this->db->last_query();die;
             $makearr=$query->result_array();
            return $makearr[0]['id'] ? $makearr[0]['id'] :'';
        
    }
    
    public function getmakeById($makeId)
    {
        $this->db->select('*');
            $this->db->from('car_make as m');
            $this->db->where('m.id', $makeId);
            $query = $this->db->get();
            //echo $this->db->last_query();die;
             $makearr=$query->result_array();
            return $makearr[0]['make'] ? $makearr[0]['make'] :'';
        
    }
    public function getSalesId($dealerId){
            $this->db->select('e.id,e.name,d.id as dealerId');
            $this->db->from('crm_user as e');
            $this->db->join('crm_dealers as d','d.user_id=e.id','inner'); 
            $this->db->where('e.status', '1');
            $this->db->where('d.status', '1');
            //$this->db->where('d.id', $dealerId);
            $this->db->group_by('e.id');
            $query = $this->db->get();
            //echo $this->db->last_query();die;
             $edata=$query->result_array();
            return $edata;
    }
   public function getZonefromRegNo($regNo){
       if($regNo!=''){
           $regNo=trim($regNo);
           $regNo = str_replace(' ', '', $regNo);
           $regno= preg_replace('/[^A-Za-z0-9]/', '', $regNo);
           $regnum=strlen($regno);
           $regno4 = substr($regno,0,4);
           $regno5 = substr($regno,0,5);
           $regno6 = substr($regno,0,6);
           $regno7 = substr($regno,0,7);
           $regno8 = substr($regno,0,8);
           $regno9 = substr($regno,0,9);
           $regnoka=substr($regno,0,2);
           $cityId='';
           $zone='';
           if(strlen($regno4)>=4){
            $cityid=$this->getCityfromRto($regno4);
            if(!empty($cityid)){ 
             $cityId=$cityid;
             }
            }
            if(strlen($regno5)>=5){
            $cityid=$this->getCityfromRto($regno5);
            if(!empty($cityid)){ 
             $cityId=$cityid;
             }
            }
            if(strlen($regno6)>=6){
            $cityid=$this->getCityfromRto($regno6);
            if(!empty($cityid)){ 
             $cityId=$cityid;
             }
            }
            if(strlen($regno7)>=7){
            $cityid=$this->getCityfromRto($regno7);
            if(!empty($cityid)){ 
             $cityId=$cityid;
             }
            }
            if(strlen($regno8)>=8){
            $cityid=$this->getCityfromRto($regno8);
            if(!empty($cityid)){ 
             $cityId=$cityid;
             }
            }
            if(strlen($regno9)>=9){
            $cityid=$this->getCityfromRto($regno9);
            if(!empty($cityid)){ 
             $cityId=$cityid;
             }
            }
            if(in_array($cityId,$this->zone_A_arr)){
                $zone='1';
            }else{
                $zone='2';
            }
       }
       return $zone;
       
   }
   public function getZonefromCity($cityId){
       if(in_array($cityId,$this->zone_A_arr)){
                $zone='1';
            }else{
                $zone='2';
            }
       return $zone;      
   }
   public function getCityfromRto($regNo){
            $this->db->select('*');
            $this->db->from('crm_insurance_zone as e');
            $this->db->where('e.Registration_Index', $regNo);
            $query = $this->db->get();
            //echo $this->db->last_query();die;
            $data=$query->result_array();
            $cityid=(isset($data[0]['cityid'])) ? $data[0]['cityid']:'';
            return $cityid;
    }
    public function getZoneCityList(){
            $this->db->select('*');
            $this->db->from('crm_insurance_zone as e');
            $query = $this->db->get();
            //echo $this->db->last_query();die;
            $data=$query->result_array();
    }
    
    public function getCarAge($mm,$myear){
        if(!empty($mm) && !empty($myear)){
            if($mm < '10'){
            $date1=$myear."-0".$mm."-".'01';
            }else{
             $date1=$myear."-".$mm."-".'01';   
            }
            $date2=date('Y-m-d');
            $diff=abs(strtotime($date2) - strtotime($date1));
            $years = floor($diff / (365*60*60*24));
            if($years==0){
               $years=1; 
            }
            return $years;
        }
    }
    public function getCarCC($variantId){
        $this->db->select('*');
        $this->db->from('model_version as mv');
        $this->db->where('mv.db_version_id', $variantId);
        $query = $this->db->get();
        $data=$query->result_array();
        $cc=(isset($data[0]['Displacement']) && ($data[0]['Displacement']!='0')) ? $data[0]['Displacement']:'990';
        return $cc;
    }
    public function addFilterQuotesData($data)
    {
        if(isset($data['customer_id'])){
           $this->db->select('qf.customer_id');
            $this->db->from('crm_insurance_quotes_filter as qf');
            $this->db->where('qf.customer_id', $data['customer_id']);
            $query = $this->db->get();
            $res=$query->result_array();
            $customer_id=(isset($res[0]['customer_id'])) ? $res[0]['customer_id']:0; 
        }
        if($customer_id > 0){
         $this->db->where('customer_id', $customer_id);
         $this->db->update('crm_insurance_quotes_filter', $data);
         $result= 'True';
        }else{
        $this->db->insert('crm_insurance_quotes_filter', $data);
         $insert_id = $this->db->insert_id();
         $result= 'True';  
        }
        return $result;
    }
    public function getadditionalCover($notIN=''){
        $this->db->select('ac.*');
            $this->db->from('crm_insurance_additional_cover as ac');
            $this->db->where_in('ac.id NOT', $notIN);
            $this->db->where('ac.status', '1');
            $this->db->order_by('priority','DESC');
            $query = $this->db->get();
            return $query->result_array();
    }
    public function getFilterQuotesData($customerId,$flag =""){
        if($flag == 1){
          $this->db->select('qf.*,cd.current_policy_type as policy_type_customer');
        } else {
           $this->db->select('qf.*');
        }
        $this->db->from('crm_insurance_quotes_filter as qf');
        if($flag == 1)
             $this->db->join('crm_insurance_customer_details as cd','cd.id = qf.customer_id','inner');
        $this->db->where('qf.customer_id', $customerId);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getZoneCcAge($customerId){
        $this->db->select('cd.ins_category,cd.zone,cd.car_age,cd.cc');
        $this->db->from('crm_insurance_case_details as cd');
        $this->db->where('cd.customer_id', $customerId);
        $query = $this->db->get(); 
        return $query->result_array();
    }
    public function getCalculatePremium($data){
        if(!empty($data[0]['zone']) && !empty($data[0]['car_age']) && !empty($data[0]['cc'])){
            if($data[0]['car_age'] <='5'){
              $car_age='1';  
            }elseif($data[0]['car_age'] > '5' && $data[0]['car_age'] <= '10'){
               $car_age='2'; 
            }elseif($data[0]['car_age'] > '10' && $data[0]['car_age'] <= '15'){
               $car_age='3'; 
            }else{
                $car_age='3';
            }
            if($data[0]['cc'] <='1000'){
              $cc='1';  
            }elseif(($data[0]['cc'] > '1000') && ($data[0]['cc'] <= '1500')){
              $cc='2';  
            }elseif($data[0]['cc'] > '1500'){
              $cc='3';  
            }
            if(!empty($data[0]['ins_category']) && $data[0]['ins_category']=='1'){
                $cat='1';
                $duration=!empty($data[0]['duration'])?$data[0]['duration']:'';
            }else{
                $cat='2';
            }
            $zone=$data[0]['zone'];
            $this->db->select('p.*');
            $this->db->from('crm_insurance_prem_calc as p');
            $this->db->where('p.zone', $zone);
            $this->db->where('p.cc', $cc);
            $this->db->where('p.age', $car_age);
            $this->db->where('p.cat', $cat);
            if(!empty($data[0]['ins_category']) && $data[0]['ins_category']=='1'){
            $this->db->where('p.duration', $duration);
            }
            $query = $this->db->get();
            //echo $this->db->last_query(); exit;
            return $query->result_array();
        }
    }
    public function getaddonData($data){
        if(!empty($data)){
            $addOn=[];
            $addOn['road_side_assistance']=!empty($data['road_side_assistance']) ? $data['road_side_assistance']:'';
            $addOn['road_side_assistance_txt']=!empty($data['road_side_assistance_txt']) ? str_replace(",","",$data['road_side_assistance_txt']):'0';
            $addOn['electrical_accessories']=!empty($data['electrical_accessories']) ? $data['electrical_accessories']:'';
            $addOn['electrical_accessories_txt']=!empty($data['electrical_accessories_txt']) ? str_replace(",","",$data['electrical_accessories_txt']):'0';
            $addOn['non_electrical_accessories']=!empty($data['non_electrical_accessories']) ? $data['non_electrical_accessories']:'';
            $addOn['non_electrical_accessories_txt']=!empty($data['non_electrical_accessories_txt']) ? str_replace(",","",$data['non_electrical_accessories_txt']):'0';
            $addOn['anti_theft']=!empty($data['anti_theft']) ? str_replace(",","",$data['anti_theft']):'';
            $addOn['anti_theft_txt']=!empty($data['anti_theft_txt']) ? str_replace(",","",$data['anti_theft_txt']):'0';

            if(isset($data['pass_cover']) && ($data['pass_cover']!='')){
              $addOn['passenger_cover']='1';
              $addOn['passenger_cover_txt']= str_replace(",","",$data['pass_cover']);  
            }elseif(isset($data['passenger_cover_txt']) && ($data['passenger_cover_txt']!='')){
              $addOn['passenger_cover']='1';
              $addOn['passenger_cover_txt']= str_replace(",","",$data['passenger_cover_txt']);  
            }else{
              $addOn['passenger_cover']='';
              $addOn['passenger_cover_txt']= '';
            }
            
            if(isset($data['per_acc_cover']) && ($data['per_acc_cover']!='')){
              $addOn['personal_acc_cover']='1';
              $addOn['personal_acc_cover_txt']= str_replace(",","",$data['per_acc_cover']);  
            }else if(isset($data['personal_acc_cover_txt']) && ($data['personal_acc_cover_txt']!='')){
             $addOn['personal_acc_cover']='1';
              $addOn['personal_acc_cover_txt']= str_replace(",","",$data['personal_acc_cover_txt']);   
            }else{
              $addOn['personal_acc_cover']='';
              $addOn['personal_acc_cover_txt']= '';
            }
            if(isset($data['paid_driver']) && ($data['paid_driver']!='')){
              $addOn['driver_cover']='1';
              $addOn['driver_cover_txt']= str_replace(",","",$data['paid_driver']);  
            }else{
              $addOn['driver_cover']='';
              $addOn['driver_cover_txt']= '';
            }
            $addOn['loss_of_personal_belonging']=!empty($data['loss_of_personal_belonging']) ? $data['loss_of_personal_belonging']:'';
            $addOn['loss_of_personal_belonging_txt']=!empty($data['loss_of_personal_belonging_txt']) ? str_replace(",","",$data['loss_of_personal_belonging_txt']):'0';
            $addOn['emergency_transport_hotel_premium']=!empty($data['emergency_transport_hotel_premium']) ? $data['emergency_transport_hotel_premium']:'';
            $addOn['emergency_transport_hotel_premium_txt']=!empty($data['emergency_transport_hotel_premium_txt']) ? str_replace(",","",$data['emergency_transport_hotel_premium_txt']):'0';
            $addOn['invoice_cover']=!empty($data['invoice_cover']) ? $data['invoice_cover']:'';
            //$addOn['invoice_cover_txt']=!empty($data['invoice_cover_txt']) ? $data['invoice_cover_txt']:'';
            $addOn['consumables']=!empty($data['consumables']) ? $data['consumables']:'';
            //$addOn['consumables_txt']=!empty($data['consumables_txt']) ? $data['consumables_txt']:'';
            $addOn['engine_cover_box']=!empty($data['engine_cover_box']) ? $data['engine_cover_box']:'';
            //$addOn['engine_cover_box_txt']=!empty($data['engine_cover_box_txt']) ? $data['engine_cover_box_txt']:'';
            $addOn['key_replacement']=!empty($data['key_replacement']) ? $data['key_replacement']:'';
            //$addOn['key_replacement_txt']=!empty($data['key_replacement_txt']) ? $data['key_replacement_txt']:'';
            $addOn['ncb_protection_cover']=!empty($data['ncb_protection_cover']) ? $data['ncb_protection_cover']:'';
            //$addOn['ncb_protection_cover_txt']=!empty($data['ncb_protection_cover_txt']) ? $data['ncb_protection_cover_txt']:'';
            $addOn['tyre_secure']=!empty($data['tyre_secure']) ? $data['tyre_secure']:'';
            $addOn['add_on']=!empty($data['add_on_txt']) ? $data['add_on_txt']:'0';
            $addOn['totadd_on']=!empty($data['totadd_on']) ? $data['totadd_on']:'0';
            $addOn['add_on_perc']=!empty($data['add_on_perc']) ? $data['add_on_perc']:'0';
            $addOn['zero_dep']=!empty($data['zero_dep']) ? $data['zero_dep']:'0';
            $addOn['status']='1';
            return $addOn;
        }
    }
    public function setFinalQuotesData($customerId,$qarr,$flag=''){
    
        $is_subtract =  isset($qarr['is_subtract'])?$qarr['is_subtract']:'0';
        $zero_dep=0;
        $response=0;
        if($flag=='1'){
            $ftype=!empty($qarr['ftype']) ? $qarr['ftype']:'';
            $inscat=!empty($qarr['inscat']) ? $qarr['inscat']:'';    
            $case_id=$qarr['case_id'];
            $idv=!empty($qarr['idv']) ? $qarr['idv']:'';
            $od_disc=!empty($qarr['od_disc_perc']) ? $qarr['od_disc_perc']:'';
            $zone=!empty($qarr['zone']) ? $qarr['zone']:'';
            $cc=!empty($qarr['cc']) ? $qarr['cc']:'';
            //$zero_dep=!empty($qarr['zero_dep_new']) ? $qarr['zero_dep_new']:'';
            $insurerId=!empty($qarr['insurance_company']) ? $qarr['insurance_company']:'';
            $imageName=!empty($qarr['logo']) ? $qarr['logo']:'';
            $quote_id=!empty($qarr['qid']) ? $qarr['qid']:'';
            $qsource=!empty($qarr['qsource']) ? $qarr['qsource']:0;
        }else{
            if(!empty($qarr)){
                $inscat=!empty($qarr['inscat']) ? $qarr['inscat']:'';
                $case_id=$qarr['case_id'];
                $ftype=!empty($qarr['ftype']) ? $qarr['ftype']:'';
                $qsource=!empty($qarr['qsource']) ? $qarr['qsource']:'';
                $idv=!empty($qarr['idv']) ? $qarr['idv']:'';
                $od_disc=!empty($qarr['od_disc']) ? $qarr['od_disc']:'';
                 //$zero_dep=!empty($qarr['zero_dep']) ? strclean($qarr['zero_dep']):'';
                $zone=!empty($qarr['zone']) ? $qarr['zone']:'';
                $cc=!empty($qarr['cc']) ? $qarr['cc']:'';
                $ins_detail=$qarr['ins_detail'];
                $imgs=explode("#",$ins_detail);
                $insurerId=!empty($imgs[0]) ? $imgs[0]:'';
                $imageName=!empty($imgs[1]) ? $imgs[1]:'';
                $quote_id=!empty($qarr['quote_id']) ? $qarr['quote_id']:'';
            }
        }
        $zoneData=$this->getZoneCcAge($customerId);
        $filterData=$this->getFilterQuotesData($customerId,1);
        if($inscat=='1'){
            $zoneData[0]['duration']=$filterData[0]['duration'];
            $zoneData[0]['car_age']='1';
        }
        if(!empty($zone)){
          $zoneData[0]['zone']= $zone; 
        }
        if(!empty($zoneData)){
            $cdata=$this->getCalculatePremium($zoneData);
        }
        
        if(!empty($cdata)){
            $quotes=array();
            $addOns=array();
            $odPremium=0;
            $thirdParty=0;
            $addOns=0;
            $electrical=0;
            $nonelectrical=0;
            $addOn=0;
            $idv=str_replace(",", "", $idv);
            $quotes['qsource']=$qsource;
            $quotes['customer_id']=$customerId;
            $quotes['case_id']=$case_id;
            $quotes['zone']=$zone;
            $quotes['cc']=$cc;
            $quotes['idv']=$idv;
            $quotes['od_disc_perc']=$od_disc;
            $quotes['insurance_company']=$insurerId;
            $quotes['logo']=$imageName;
            $quotes['ftype']=$ftype;
            $quotes['is_latest']='1';
            
            if($inscat=='1'){
                if(!empty($filterData[0]['duration']) && $filterData[0]['duration']=='1'){
                 $basicOwnDamage=(int)$idv*($cdata[0]['normal_rate']/100);//basic Own damage   
                }else{
                $basicOwnDamage=(2.57)*(int)$idv*($cdata[0]['normal_rate']/100);//basic Own damage
                }
            }else{
                $basicOwnDamage=(int)$idv*((float)$cdata[0]['normal_rate']/100);//basic Own damage
                $basicOwnDamage=round($basicOwnDamage);
            }
            if(!empty($ftype) && ($ftype=='2')){
              $basicOwnDamage=(!empty($qarr['basic_od_amt'])) ? str_replace(",","",$qarr['basic_od_amt']):'0';    
            }else{
              $basicOwnDamage=round((int)$basicOwnDamage);
            }
            if(empty($basicOwnDamage)){
              $basicOwnDamage=(!empty($qarr['basic_own_damage'])) ? str_replace(",","",$qarr['basic_own_damage']):'0';    
            }
            $quotes['basic_own_damage']=$basicOwnDamage;
            if(!empty($ftype) && ($ftype=='2')){
                $odDiscount=(!empty($qarr['od_discount'])) ? round((int) str_replace(",","",$qarr['od_discount'])):0;   
            }else{
                $odDiscount=(!empty($od_disc))? round((int)$basicOwnDamage*((int)$od_disc/100)):0;// own damage discount
            }
            $quotes['od_discount']=$odDiscount;
            if(!empty($ftype) && ($ftype=='2')){
                $electrical=(!empty($qarr['electrical_accessories_txt'])) ? str_replace(",","",$qarr['electrical_accessories_txt']):'0';//eletrical
                $qarr['electrical_accessories']=(!empty(str_replace(",","",$qarr['electrical_accessories_txt']))) ? '1':'0';
                $quotes['electrical']=round($electrical);    
            }else{
            if(!empty($qarr['electrical_accessories']) && ($qarr['electrical_accessories']=='1')){
                $electrical=(!empty($qarr['electrical_accessories_txt'])) ? str_replace(",","",$qarr['electrical_accessories_txt'])*(4/100):'0';//eletrical
                $quotes['electrical']=round($electrical);
            }
            }
            if(!empty($ftype) && ($ftype=='2')){
                $nonelectrical=(!empty($qarr['non_electrical_accessories_txt'])) ? str_replace(",","",$qarr['non_electrical_accessories_txt']):'0';//non electrical
                $qarr['non_electrical_accessories']=(!empty($qarr['non_electrical_accessories_txt'])) ? '1':'0';
                $quotes['non_electrical']=round($nonelectrical);    
            }else{
                if(!empty($qarr['non_electrical_accessories']) && ($qarr['non_electrical_accessories']=='1')){
                    $nonelectrical=(!empty($qarr['non_electrical_accessories_txt'])) ? str_replace(",","",$qarr['non_electrical_accessories_txt'])*(4/100):'0';//non electrical
                    $quotes['non_electrical']=round($nonelectrical);
                }
            }
            $ncbtotal=((int)$basicOwnDamage-(int)$odDiscount);
            if(!empty($ftype) && ($ftype=='2')){
                if(!empty($qarr['ncb_discount']))
                    $ncb_val = $qarr['ncb_discount'];
                else if(!empty($qarr['ncb']))
                    $ncb_val = $qarr['ncb'];
                $ncbtotal=(!empty($ncb_val)) ? str_replace(",","",$ncb_val):'0';//ncb discount    
            }else{
            $ncbtotal=(int)$ncbtotal*((int)$filterData[0]['ncb_discount']/100);//ncb discount
            }
            $ncbtotal=round($ncbtotal);
            $quotes['ncb']= $ncbtotal;
            $ownDamage=(int)$basicOwnDamage-(int)$odDiscount;
            $subownDamage=(int)$ownDamage+(int)$electrical+(int)$nonelectrical;
            $finalownDamage=(int)$subownDamage-(int)$ncbtotal;            
            $quotes['own_damage']=round($finalownDamage);
            if(!empty($ftype) && ($ftype=='2')){
            $basicThirdParty=(int)$cdata[0]['basic_third_party'];
            $quotes['basic_third_party']=(int)$basicThirdParty;
            $personalAccCover=(!empty($qarr['per_acc_cover'])) ? str_replace(",","",$qarr['per_acc_cover']):'0'; // personal accident cover
          
            if(empty($personalAccCover))
            {
                $personalAccCover=(!empty($qarr['personal_acc_cover_txt'])) ? str_replace(",","",$qarr['personal_acc_cover_txt']):'0'; 
            }
            $quotes['personal_acc_cover']=(int)$personalAccCover;
            $paidDriver=(!empty($qarr['paid_driver'])) ? str_replace(",","",$qarr['paid_driver']):'0'; // paid driver
            $quotes['paid_driver']=(int)$paidDriver;
            $passengerCover=(!empty($qarr['pass_cover'])) ? str_replace(",","",$qarr['pass_cover']):'0'; // personal accident cover
            $quotes['pass_cover']=(int)$passengerCover;
            $thirdParty=(int)$basicThirdParty+(int)$personalAccCover+(int)$paidDriver+(int)$passengerCover; // third party   
            $quotes['third_party']=$thirdParty;
            }else{
            if($inscat=='1'){
            $basicThirdParty=(int)$cdata[0]['basic_third_party'];//basic third party
            $quotes['basic_third_party']=(int)$basicThirdParty;
            $personalAccCover=(!empty($qarr['per_acc_cover'])) ? str_replace(",","",$qarr['per_acc_cover']):'0'; // personal accident cover
           if(empty($personalAccCover))
            {
                $personalAccCover=(!empty($qarr['personal_acc_cover_txt'])) ? str_replace(",","",$qarr['personal_acc_cover_txt']):'0'; 
            }
            $quotes['personal_acc_cover']=(int)$personalAccCover;
            $paidDriver=(!empty($qarr['paid_driver'])) ? str_replace(",","",$qarr['paid_driver']):'0'; // paid driver
            $quotes['paid_driver']=(int)$paidDriver;
            $passengerCover=(!empty($qarr['pass_cover'])) ? str_replace(",","",$qarr['pass_cover']):'0'; // personal accident cover
            $quotes['pass_cover']=(int)$passengerCover;
           // echo "aa"+$basicThirdParty."++".$personalAccCover."++".$paidDriver."++".$passengerCover;die;
            
            $thirdParty=(int)$basicThirdParty+(int)$personalAccCover+(int)$paidDriver+(int)$passengerCover; // third party    
            $quotes['third_party']=$thirdParty;
            }else{
            $basicThirdParty=(int)$cdata[0]['basic_third_party'];//basic third party
            $quotes['basic_third_party']=(int)$basicThirdParty;
            $personalAccCover=(!empty($qarr['per_acc_cover'])) ? str_replace(",","",$qarr['per_acc_cover']):'0'; // personal accident cover
            if(empty($personalAccCover))
            {
                $personalAccCover=(!empty($qarr['personal_acc_cover_txt'])) ? str_replace(",","",$qarr['personal_acc_cover_txt']):'0'; 
            }
            $quotes['personal_acc_cover']=(int)$personalAccCover;
            $paidDriver=(!empty($qarr['paid_driver'])) ? str_replace(",","",$qarr['paid_driver']):'0'; // paid driver
            $quotes['paid_driver']=(int)$paidDriver;
            $passengerCover=(!empty($qarr['pass_cover'])) ? str_replace(",","",$qarr['pass_cover']):'0'; // personal accident cover
            $quotes['pass_cover']=(int)$passengerCover;
            $thirdParty=(int)$basicThirdParty+(int)$personalAccCover+(int)$paidDriver+(int)$passengerCover; // third party
            $quotes['third_party']=$thirdParty;
            }
            }
            if(!empty($qarr['anti_theft']) && ($qarr['anti_theft']=='1') && $ftype=='1'){ 
                $is_subtract = 1;
            }
            if(!empty($qarr['road_side_assistance']) && ($qarr['road_side_assistance']=='1')){
                 $is_subtract = 0;
                $addOn=(!empty($qarr['road_side_assistance_txt'])) ? (int)str_replace(",","",$qarr['road_side_assistance_txt']):'0';
            }
            if(!empty($qarr['invoice_cover']) && ($qarr['invoice_cover']=='1')){
                 $is_subtract = 0;
                //$addOn+=(int)$filterData[0]['invoice_cover_txt'];
            }
            if(!empty($qarr['loss_of_personal_belonging']) && ($qarr['loss_of_personal_belonging']=='1')){
                 $is_subtract = 0;
                $addOn+=(!empty($qarr['loss_of_personal_belonging_txt'])) ? (int)str_replace(",","",$qarr['loss_of_personal_belonging_txt']):'0';
            }
            if(!empty($qarr['emergency_transport_hotel_premium']) && ($qarr['emergency_transport_hotel_premium']=='1')){
                $is_subtract = 0;
                $addOn+=(!empty($qarr['emergency_transport_hotel_premium_txt'])) ? (int)str_replace(",","",$qarr['emergency_transport_hotel_premium_txt']):'0';
            }
            
            if(!empty($qarr['anti_theft']) && ($qarr['anti_theft']=='1')){           
              $addOn= (int)$addOn - (int) str_replace(",","",$qarr['anti_theft_txt']); 
            }
            $bundleAddOn=0;
            if(!empty($qarr['add_on_perc'])){
                $bundleAddOn=round((int)$idv*(float)$qarr['add_on_perc']/100);
                $addOn+=round((int)$idv*(float)$qarr['add_on_perc']/100);
                $qarr['add_on_perc']=!empty($qarr['add_on_perc']) ? $qarr['add_on_perc']:0;
                $qarr['add_on_txt']=$bundleAddOn;
            }
            if(!empty($qarr['add_on_txt']) && $qarr['add_on_perc']==''){
                $bundleAddOn=round((float)str_replace(',','',$qarr['add_on_txt']));
                $addOn+=round((float)str_replace(',','',$qarr['add_on_txt']));
                $qarr['add_on_txt']=$bundleAddOn;
                $add_on_perc=0;
                $add_on_perc=!empty($qarr['add_on_txt']) ? (float)(str_replace(',','',$qarr['add_on_txt'])/$idv):0;
                $add_on_perc_new=(!empty($add_on_perc)) ? number_format((float)$add_on_perc*100,2,'.', ''): 0;
                $qarr['add_on_perc']=$add_on_perc_new;
            }
            if($filterData[0]['policy_type_customer'] == 3)
                $thirdParty = 0;
            
          // echo $finalownDamage."+++".$thirdParty."++++".$addOn;
            if(!empty($ftype) && ($ftype=='2') && $is_subtract == 1){
                $totgst_sum=(int)$finalownDamage+(int)$thirdParty-(int)$addOn;
            }else{
                $totgst_sum=(int)$finalownDamage+(int)$thirdParty+(int)$addOn;
            }
            $totgst=round((int)$totgst_sum*(18/100));
            $quotes['gst']=$totgst;
            $totpremium= round((int)$totgst_sum+(int)$totgst);
            $quotes['totpremium']=(int)$totpremium;   
            $quotes['idv_2'] = isset($qarr['midv2'])?$qarr['midv2']:"";
            $quotes['idv_3'] = isset($qarr['midv3'])?$qarr['midv3']:"";
            $quotes['quote_date']=$qarr['quote_date'];    
            $addOns=$this->getaddonData($qarr);
            $response=$this->addquotes($customerId,$quotes,$addOns,$quote_id);
        }
        return $response;
    }
        
    public function addquotes($customerId,$quotes,$addOns,$quote_id){
        $chktrue=false;
        if(isset($customerId)){
           $this->db->select('q.id,q.customer_id');
            $this->db->from('crm_insurance_quotes as q');
            $this->db->where('q.customer_id', $customerId);
            if($quote_id!=''){
             $this->db->where('q.id', $quote_id);   
            }
            $query = $this->db->get();
            $res=$query->result_array();
            $quotesid=(isset($res[0]['id'])) ? $res[0]['id']:0; 
        }
        if($quote_id > 0){
          $quotes['updated_on']=$this->dateTime;  
          $this->db->where('id', $quotesid);
          $this->db->where('customer_id', $customerId);
          $this->db->update('crm_insurance_quotes', $quotes);
        //echo $this->db->last_query(); exit;
          $insert_id=$quotesid;
        }else{
         $chktrue=$this->checkduplicate($quotes);
         if($chktrue==false){
         $quotes['added_on']=$this->dateTime; 
         $this->db->insert('crm_insurance_quotes', $quotes);
         //echo $this->db->last_query();die;
         $insert_id = $this->db->insert_id();
         }
        }
        if($insert_id > 0){
            $this->db->select('qa.id');
            $this->db->from('crm_insurance_quotes_addon as qa');
            $this->db->where('qa.quote_id', $insert_id);
            $query = $this->db->get();
            $res=$query->result_array();
            $addonId=(isset($res[0]['id'])) ? $res[0]['id']:0;  
        }
        if($addonId > 0){
          $this->db->where('id', $addonId);
          $this->db->update('crm_insurance_quotes_addon', $addOns);
          $insertid=$quotesid;  
        }else{
          $addOns['quote_id']=$insert_id;
          $this->db->insert('crm_insurance_quotes_addon', $addOns);
          $insertid = $this->db->insert_id();   
        }
        return (!empty($insertid)) ? true:false;
    }
    public function checkduplicate($quotes){
      $this->db->select('q.id');  
      $this->db->from('crm_insurance_quotes q');
      $this->db->where('q.customer_id', $quotes['customer_id']);
      $this->db->where('q.case_id', $quotes['case_id']);
      $this->db->where('q.zone', $quotes['zone']);
      $this->db->where('q.cc', $quotes['cc']);
      $this->db->where('q.idv', $quotes['idv']);
      $this->db->where('q.od_disc_perc', $quotes['od_disc_perc']);
      $this->db->where('q.insurance_company', $quotes['insurance_company']);
      $this->db->where('q.is_latest', $quotes['is_latest']);
      $query = $this->db->get();
      //echo $this->db->last_query();die;
      $data=$query->result_array();
      if(!empty($data)){
         return true; 
      }else{
         return false; 
      }
      
    }
    
    public function getQuotesListByQuoteId($quoteId){
        $this->db->select('q.*,qa.*,qf.claim_taken,cd.policy_type as policy_type_customer,qf.ncb_discount,pi.short_name,qa.zero_dep,q.personal_acc_cover as pcover,q.paid_driver as pdriver,q.basic_third_party');
        $this->db->from('crm_insurance_quotes q');
        $this->db->join('crm_insurance_quotes_filter qf','q.customer_id=qf.customer_id','inner');
        $this->db->join('crm_insurance_customer_details cd','cd.id=qf.customer_id','inner');
        $this->db->join('crm_insurance_quotes_addon as qa', 'qa.quote_id=q.id','left');
        $this->db->join('crm_prev_policy_insurer as pi', 'pi.prev_policy_insurer_slug=q.insurance_company','left');
        $this->db->where('q.is_latest', '1');
        $this->db->where('q.id', $quoteId);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();  
    }
    
     public function getQuotesListByCaseId($caseId){
        $this->db->select('q.*,qf.*,qa.*,pi.short_name,qa.zero_dep,q.personal_acc_cover as pcover,q.paid_driver as pdriver');
        $this->db->from('crm_insurance_quotes q');
        $this->db->join('crm_insurance_quotes_filter qf','q.customer_id=qf.customer_id','inner');
        $this->db->join('crm_insurance_quotes_addon as qa', 'qa.quote_id=q.id','left');
        $this->db->join('crm_prev_policy_insurer as pi', 'pi.prev_policy_insurer_slug=q.insurance_company','left');
        $this->db->where('q.is_latest', '1');
        $this->db->where('q.case_id', $caseId);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();  
    }


    public function getAddOnQuotesListByQuoteId($quoteId){
        $this->db->select('qa.*');
        $this->db->from('crm_insurance_quotes_addon qa');
        $this->db->where('qa.quote_id', $quoteId);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }
    
    public function getcurrentInsurerId($customerId){
        $this->db->select('q.insurance_company as cid');
        $this->db->from('crm_insurance_quotes q');
        $this->db->where('q.is_latest', '1');
        $this->db->where('q.customer_id', $customerId);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }
    
    public function getInsQuotesByCustomerId($customerId){
        if(isset($customerId)){
            $this->db->select('q.*');
            $this->db->from('crm_insurance_quotes as q');
            $this->db->where('q.customer_id', $customerId);
            $this->db->where('q.is_latest', '1');
            $query = $this->db->get();
            //echo $this->db->last_query();die;
            $res=$query->result_array();
            if(!empty($res)){
                return $res;
            }else{
                return false;
            }
        }
    }

public function updateQuoteById($Id){
      if(!empty($Id)){
         $this->db->select('q.customer_id');
            $this->db->from('crm_insurance_quotes as q');
            $this->db->where('q.id', $Id);
            $this->db->where('q.is_latest', '1');
            $query = $this->db->get();
            $res=$query->result_array();
            $customerId=(isset($res[0]['customer_id'])) ? $res[0]['customer_id']:0;
            if($customerId > 0){
            $udata['flag']='0'; 
            $this->db->where('customer_id', $customerId);
            $result=$this->db->update('crm_insurance_quotes', $udata);
            }
            $data['flag']='1'; 
            $this->db->where('id', $Id);
            $this->db->where('customer_id', $customerId);
            $result=$this->db->update('crm_insurance_quotes', $data);
            //echo $this->db->last_query();die;
            return true;
       }  
    }
    public function deleteQuoteById($quoteId){
        if($quoteId > 0){
            $udata['is_latest']='0';
            $udata['flag']='0'; 
            $this->db->where('id', $quoteId);
            $result=$this->db->update('crm_insurance_quotes', $udata);
            //echo $this->db->last_query();die;
            }
         return true;   
    }
    public function getCustomerIdByQid($quoteId,$flag = ""){
           $this->db->select('q.customer_id,q.quote_date');
            $this->db->from('crm_insurance_quotes as q');
            $this->db->where('q.id', $quoteId);
            $this->db->where('q.is_latest', '1');
            $query = $this->db->get();
            $res=$query->result_array();
            if($flag == 1) {
               return  $res[0];
            }else{
               return  $customerId=(isset($res[0]['customer_id'])) ? $res[0]['customer_id']:0;  
            }
             
    }
    public function getAcceptedQuote($customerId){
            $this->db->select('q.*');
            $this->db->from('crm_insurance_quotes as q');
            $this->db->where('q.customer_id', $customerId);
            $this->db->where('q.flag', '1');
            $this->db->where('q.is_latest', '1');
            $query = $this->db->get();
            //echo $this->db->last_query();die;
            return $query->result_array();
    }

    public function getshowroomprice($dbversionId){
        $this->db->select('q.ex_showroom as price');
        $this->db->from('orp_price_actual q');
        $this->db->join('technical_specifications t','t.id=q.technical_specification_id','inner');
        $this->db->where('t.version_id', $dbversionId);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();  
    }
    public function getcatId($customerId){
        $this->db->select('cd.ins_category');
        $this->db->from('crm_insurance_case_details cd');
        $this->db->where('cd.customer_id', $customerId);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $insCat=$query->result_array();
        return !empty($insCat[0]['ins_category']) ? $insCat[0]['ins_category']:0;
    }


    public function getCentralStock($data=[],$id='',$regno='',$customer_id='',$engineno='',$chassisno='',$flag='')
    {
        $this->db->select('cd.*,c.premium');
        $this->db->from('crm_insurance_case_details cd');
        $this->db->join('crm_insurance_customer_details as c','c.id=cd.customer_id','inner');
         if(!empty($flag))
        {
            $this->db->join('crm_insurance_part_payment as cp','cd.customer_id=cp.customer_id','left');
        }
        if(!empty($id))
        {
            $this->db->where('cd.id',$id);
        }
        if(!empty($regno))
        {
            $this->db->where('cd.regno',$regno);
        }
        if(!empty($customer_id))
        {
            $this->db->where('cd.customer_id',$customer_id);
        }
        if(!empty($engineno))
        {
            $this->db->where('cd.engineNo',$engineno);
        }
        if(!empty($chassisno))
        {
            $this->db->where('cd.chasisNo',$chassisno);
        }
        if(!empty($flag))
        {
            $currentDate = date('Y-m-d');
            $second_date = date('Y-m-d', strtotime('-30 days'));
            //$this->db->where('c.current_issue_date',);
            $this->db->where('c.current_issue_date >=', $second_date);
            $this->db->where('c.current_issue_date <=', $currentDate);
            $this->db->where('cp.entry_type!=4');
            $this->db->where('cp.reasonId','2');
            $this->db->limit('1');
        }
        $query = $this->db->get();
     //  echo $this->db->last_query();
        return $insCat=$query->result_array();
    }
    public function getAddUpdateCaseDetails($caseId,$csId){
        $today = date('Y-m-d');
        $insert_id='';
        $caseArr=current($this->getCaseDetails($caseId));
        if(!empty($caseArr['customer_id'])){
            $customerId=$caseArr['customer_id'];
            $cData=current($this->getCustomerInfo($customerId));
            $data=[];
            $custdata=[];
            $casedata=[];
            if(!empty($cData)){
                $custdata['buyer_type']=$cData['buyer_type'];
                if($cData['buyer_type']=='1'){
                $custdata['customer_name']= !empty($cData['customer_name']) ? $cData['customer_name']:'';
                $custdata['customer_email']= !empty($cData['customer_email']) ? $cData['customer_email']:'';
                $custdata['customer_address']= !empty($cData['customer_address']) ? $cData['customer_address']:'';
                $custdata['customer_city_id']= !empty($cData['customer_city_id']) ? $cData['customer_city_id']:0 ;
                $custdata['customer_state_id']= !empty($cData['customer_state_id']) ? $cData['customer_state_id']:0;
                $custdata['customer_pincode']= !empty($cData['customer_pincode']) ? $cData['customer_pincode'] : 0;
                $custdata['customer_gender']= !empty($cData['customer_gender']) ? $cData['customer_gender'] : 0;
                $custdata['customer_marital']= !empty($cData['customer_marital']) ? $cData['customer_marital'] : 0;
                $custdata['customer_dob']= !empty($cData['customer_dob']) ? $cData['customer_dob']:'';
                $custdata['customer_occupation']= !empty($cData['customer_occupation']) ? $cData['customer_occupation']:'';
                $custdata['customer_annual_income']= !empty($cData['customer_annual_income']) ? $cData['customer_annual_income']:'';
                $custdata['customer_pan_no']= !empty($cData['customer_pan_no']) ? $cData['customer_pan_no'] : '';
                $custdata['customer_aadhaar']= !empty($cData['customer_aadhaar']) ? $cData['customer_aadhaar'] :'';
                $custdata['customer_gst_no']= !empty($cData['customer_gst_no']) ? $cData['customer_gst_no'] : '';
                $custdata['customer_nominee_name']= !empty($cData['customer_nominee_name']) ? $cData['customer_nominee_name']:'';
                $custdata['customer_nominee_age']= !empty($cData['customer_nominee_age']) ? $cData['customer_nominee_age'] : 0;
                $custdata['customer_nominee_address']= !empty($cData['customer_nominee_address']) ? $cData['customer_nominee_address']:'';
                $custdata['customer_nominee_pincode']= !empty($cData['customer_nominee_pincode']) ? $cData['customer_nominee_pincode'] : '';
                $custdata['customer_nominee_city']= !empty($cData['customer_nominee_city']) ? $cData['customer_nominee_city'] : 0;
                $custdata['customer_nominee_relation']= !empty($cData['customer_nominee_relation']) ? $cData['customer_nominee_relation']: '';
                $custdata['customer_nominee_ref_name']= !empty($cData['customer_nominee_ref_name']) ? $cData['customer_nominee_ref_name']:'';
                $custdata['customer_nominee_ref_phone']= !empty($cData['customer_nominee_ref_phone']) ? $cData['customer_nominee_ref_phone']:'';
                $custdata['customer_status']= !empty($cData['customer_status']) ? $cData['customer_status'] : 0;
                $custdata['customer_source']= !empty($cData['customer_source']) ? $cData['customer_source'] : '';
                $custdata['iscustomerAddress']= $cData['iscustomerAddress'];
                $now = strtotime(date('Y-m-d')); 
                $expire_due_date = strtotime($cData['current_due_date']);
                $duedateDiff = $now - $expire_due_date;
                $duedateDiff= round($duedateDiff / (60 * 60 * 24));
                if($duedateDiff > 90){
                $custdata['isexpired']= '1';    
                }
                }elseif($cData['buyer_type']=='2'){
                 $custdata['customer_company_name']= !empty($cData['customer_company_name']) ? $cData['customer_company_name']:'';   
                }
                $casedata['ins_category']= '3';
                $casedata['source']= 'walkin';
                $casedata['dealer_id']= !empty($cData['dealer_id']) ? $cData['dealer_id'] : '';
                $casedata['sales_id']= !empty($cData['sales_id']) ? $cData['sales_id'] : '';
                $casedata['regNo']= !empty($cData['regNo']) ? $cData['regNo']:'';
                $casedata['make']= !empty($cData['make']) ? $cData['make'] : '';
                $casedata['model']= !empty($cData['model']) ? $cData['model'] : '';
                $casedata['variantId']= !empty($cData['variantId']) ? $cData['variantId']:'';
                $casedata['engineNo']= !empty($cData['engineNo']) ? $cData['engineNo']:'';
                $casedata['chasisNo']= !empty($cData['chasisNo']) ? $cData['chasisNo'] : '';
                $casedata['make_month']= !empty($cData['make_month']) ? $cData['make_month']:'';
                $casedata['make_year']= !empty($cData['make_year']) ? $cData['make_year']: '';
                $casedata['reg_month']= !empty($cData['reg_month']) ? $cData['reg_month'] : '';
                $casedata['reg_year']= !empty($cData['reg_year']) ? $cData['reg_year'] : '';
                $casedata['zone']= !empty($cData['zone']) ? $cData['zone'] : '';
                $casedata['car_age']= !empty($cData['car_age']) ? $cData['car_age']:'';
                $casedata['cc']= !empty($cData['cc']) ? $cData['cc'] : '';
                $casedata['car_city']= !empty($cData['car_city']) ? $cData['car_city'] : '';
                $casedata['is_latest']= $cData['is_latest'];
                $casedata['renew_flag']= '1';
                $casedata['follow_status']= '1';
                $casedata['created_date']= date('Y-m-d H:i:s');
                $custdata['crm_customer_id']=$cData['crm_customer_id'];
                $custdata['previous_insurance_company']=!empty($cData['new_ins_company']) ? $cData['new_ins_company']:'';
                $custdata['previous_policy_no']=!empty($cData['current_policy_no']) ? $cData['current_policy_no']:'';
                $custdata['previous_policy_type']=!empty($cData['current_policy_type']) ? $cData['current_policy_type']: '';
                $custdata['previous_issue_date']=!empty($cData['current_issue_date']) ? $cData['current_issue_date'] :'';
                $custdata['previous_due_date']=!empty($cData['current_due_date']) ? $cData['current_due_date'] : '';
                $custdata['previous_claim_taken']= '0';
                $custdata['previous_ncb_discount']=!empty($cData['current_ncb_discount']) ? $cData['current_ncb_discount'] : '';
                $custdata['current_insurance_company']='';
                $custdata['current_policy_no']='';
                $custdata['current_policy_type']= '';
                $custdata['current_issue_date']='';
                $custdata['current_due_date']= '';
                //$custdata['current_policy_taken']=!empty($cData['current_policy_taken']) ? $cData['current_policy_taken'] : '';
                $custdata['current_ncb_discount']='';
                
            }
            $this->db->insert('crm_insurance_customer_details', $custdata);
            $insert_id = $this->db->insert_id();
            if($insert_id > 0){
              $casedata['customer_id']= $insert_id;
              $this->db->insert('crm_insurance_case_details', $casedata);
              $case_insert_id = $this->db->insert_id();
              $this->db->where('id', $csId);
              $result=$this->db->update('crm_central_stock', array('processed'=>'1'));
              echo $this->db->last_query();
              $this->db->insert('crm_ins_renew_history_track', array('activity' => '1','case_id' => $case_insert_id));
            }
        }
        return $insert_id;
        
    } 
    public function getNewInsQuotesByCustomerId($customerId){
        if(isset($customerId)){
            $this->db->select('q.*,qa.*,q.id as qid');
            $this->db->from('crm_insurance_quotes as q');
            $this->db->join('crm_insurance_quotes_addon as qa', 'qa.quote_id=q.id','left');
            $this->db->where('q.customer_id', $customerId);
            $this->db->where('q.is_latest', '1');
            $query = $this->db->get();
            $res=$query->result_array();
            if(!empty($res)){
                return $res;
            }else{
                return false;
            }
        }
    }
    
    public function getsiscompFlag($dealerId){
        $this->db->select('q.*');
        $this->db->from('crm_admin_dealers as q');
        $this->db->where('q.dealer_id', $dealerId);
        $query = $this->db->get();
        $res=$query->result_array();
        $ins_sis_comp=(!empty($res[0]['ins_sis_comp'])) ? $res[0]['ins_sis_comp'] : '';
        return $ins_sis_comp;
    }
    
    public function getThirdPartyRates($cat,$carcc,$flag = ""){        
            if($carcc <='1000'){
              $cc='1';  
            }elseif(($carcc > '1000') && ($carcc <= '1500')){
              $cc='2';  
            }elseif($carcc > '1500'){
              $cc='3';  
            }
            if($flag == 1)
               $cc =  $carcc; 
            $this->db->select('p.basic_third_party,p.personal_acc_cover,p.paid_driver');
            $this->db->from('crm_insurance_prem_calc as p');
            $this->db->where('p.cat', $cat);
            $this->db->where('p.cc', $cc);
            $query = $this->db->get();
            $res=$query->result_array();
            return $res;
    }
    
    public function getQSource(){
        $this->db->select('q.*');
        $this->db->from('crm_quote_source as q');
        $this->db->where('q.status', '1');
        $query = $this->db->get();
        $res=$query->result_array();
        $insQsource=(!empty($res)) ? $res : '';
        return $insQsource;
    }

    function IND_money_format($number){        
        $money = floor($number);
        $length = strlen($money);
        $delimiter = '';
        $money = strrev($money);
        for($i=0;$i<$length;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
                $delimiter .=',';
            }
            $delimiter .=$money[$i];
        }
        $result = strrev($delimiter);
        return $result;
    }


    public function checkduplicateCase($engineNo,$chasisNo,$updateId=false,$daycheck=false){

        $this->db->select('icd.id as caseid');
        $this->db->from('crm_insurance_case_details as icd');
        $this->db->where('icd.engineNo', $engineNo);
        $this->db->where('icd.chasisNo', $chasisNo);
        if($daycheck){
        $this->db->where('icd.created_date >= CURDATE() - INTERVAL '.$daycheck.' DAY  ');
        $this->db->where('icd.cancel_id=0');
        }
        if($updateId)
        $this->db->where('icd.id NOT IN('.$updateId.')');
        $query = $this->db->get();
        $res=$query->result_array();
        if(!empty($res[0]['caseid'])){
        // echo $engineNo.'--'.$chasisNo.'<br>' ,$this->db->last_query();
            if($updateId){

            $caseids =  array_reduce($res, function(&$new,$entry){
                $new[] = $entry['caseid'];
                return $new;
            });
            return implode(',', $caseids) ;
            }else return true;

        }else{
            return false;
        }
        return $res;
    }

    public function getmakemodelByversionId($versionId){
        $this->db->select('mv.mk_id as make_id, mv.model_id, mv.db_version as version, mv.db_version_id as version_id');
        $this->db->from('model_version as mv');
        $this->db->join('make_model as mm', 'mm.id=mv.model_id','inner');
        $this->db->join('car_make as cm', 'mv.mk_id = cm.id','left');
        $this->db->where_in('mv.dis_cont', array(0,1));
        $this->db->where_in('mm.dis_cont', array(0,1));
        $this->db->where('mv.db_version_id', $versionId);
        $query = $this->db->get();
        $res=$query->result_array();
        return $res;
    }
    
    public function getInsuranceCompany($id){
        
        $this->db->select('cppi.short_name');
        $this->db->from('crm_prev_policy_insurer as cppi');
        $this->db->where_in('cppi.id', $id);
        $query = $this->db->get();
        $res=$query->row_array();
        return !empty($res)?$res['short_name']:"";
    }
   public function deactivateQuotes($customerId){
        if($customerId > 0){
            $udata['is_latest']='0';
            $udata['status']='0';
            $udata['flag']='0'; 
            $this->db->where('customer_id', $customerId);
            $result=$this->db->update('crm_insurance_quotes', $udata);
        }
      //  echo $this->db->last_query();die;
         return true;  
            
    }

    public function fetchData($tbl,$column,$con1='',$con2=''){
                $this->db->select($column);
                $this->db->from($tbl);
                if($con1!=""){
                $this->db->where($con1);
                }
                if($con2!=""){
                  $this->db->where($con2);  
                }
                $query = $this->db->get();
                $result = $query->result_array();
                return current($result);
    }

    public function saveData($tbl, $data,$policy_id=""){
        if(!empty($policy_id)){
            $this->db->where('id', $policy_id);
            $this->db->update($tbl, $data);
        }else{
            $this->db->insert($tbl, $data);
            $insert_id = $this->db->insert_id();
            return $result = $insert_id;
        }
    }
    public function getUpdateStatusList(){        
        $this->db->select('id,status');
        $this->db->from('crm_insurance_update_status');
        $query = $this->db->get();
        $result=$query->result_array();
        $status_list = array();
        foreach($result as $res){
          $status_list[$res['id']] =   $res['status'];
        }
        return $status_list;
    }

    public function getInshistoryEmail($case_id){
        $where = "  date(l.created_date) ='". date('Y-m-d')."'";
      //  $where = "  date(l.created_date) ='2020-02-18'";
      // $this->db->select('h.*,pp.short_name,u.name');
       $this->db->select("COUNT(distinct CASE WHEN (l.activity_text like '%Issued%') THEN l.id ELSE null END ) issued,COUNT(distinct CASE WHEN (l.activity_text like '%Case Added%') THEN l.id ELSE null END ) added,
          COUNT(distinct CASE WHEN (l.activity_text like '%Quotes Share%') THEN l.id ELSE null END ) quote");
       $this->db->from('crm_insurance_inq_history as l');
       //$this->db->join('crm_prev_policy_insurer as pp', 'pp.prev_policy_insurer_slug=l.company_id','left');
       $this->db->join('crm_user as u','u.id=l.user_id','left');
       $this->db->where('u.id', $case_id);
       $this->db->where($where);
       $query = $this->db->get();
    //   echo $this->db->last_query(); exit;
       return $historyData=$query->result_array();
    }

    public function getInsuranceCompMailer()
    {
          $where = " l.current_policy_no !='' and date(ind.created_date) ='". date('Y-m-d')."' and ind.source like '%issued%' and cd.last_updated_status in (6,9) ";
           $this->db->select("count(l.id) as counter, ins.short_name");
           $this->db->from('crm_insurance_customer_details as l');
           $this->db->join('crm_prev_policy_insurer as ins','l.current_insurance_company =ins.id','left');
           $this->db->join('crm_insurance_case_details as cd','cd.customer_id = l.id','left');
           $this->db->join('crm_insurance_inq_history as ind','ind.customer_id = cd.customer_id','left');
          // $this->db->where('u.id', $case_id);
           $this->db->where($where);
           $this->db->group_by('ins.id');
           $query = $this->db->get();
    //   echo $this->db->last_query(); exit;
          return $historyData=$query->result_array();


         //select count(l.id), ins.short_name from  crm_insurance_customer_details as l left join crm_prev_policy_insurer as ins on l.current_insurance_company =ins.id left join crm_insurance_case_details as cd on cd.customer_id = l.id left join crm_insurance_inq_history as ind on ind.customer_id = cd.customer_id  where l.current_policy_no !='' and cd.last_updated_status in (6,9)  and ind.source like '%issued%' and date(ind.created_date) = '2020-02-18'  group by ins.id
    }
}
