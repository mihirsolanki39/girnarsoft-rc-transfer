<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class : Financce (FinanceController)
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
class Finance extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Crm_user');
        $this->load->model('Crm_rc');
        $this->load->model('Crm_insurance');
        $this->load->model('Loan_customer_info');
        $this->load->model('Loan_customer_case');
        $this->load->library('form_validation');
        $this->load->model('Leadmodel');
        $this->load->model('Crm_dealers');
        $this->load->model('Make_model');
        $this->load->model('UserDashboard');
        $this->load->model('Loan_customer_reference_info');
        $this->load->model('City');
        $this->load->model('Crm_banks_List');
        $this->load->model('state_list');
        $this->load->model('Crm_banks');
        $this->load->model('Loan_post_delivery_info');
        $this->load->model('Crm_insurance_company');
        $this->load->model('Loan_payment_info');
        $this->load->model('Crm_applicant_type');
        $this->load->model('Crm_upload_docs_list');
        $this->load->model('crm_stocks');
        $this->load->model('Leadmodel');
        $this->load->model('Crm_buy_lead_history_track');
        $this->load->library('excel');
        $this->load->helper('loanlistingexcel');

        if (!$this->session->userdata['userinfo']['id'])
        {
            return redirect('login');
        }
        //error_reporting(1);
        //ini_set('display_errors', 1);
    }

    public function addLoanHistory($case_id,$activity,$details='-',$bank_id,$remark='',$status='1',$created_by,$action="Add",$created_at='')
    {
        $data = [];
        $data['case_id'] = $case_id;
        $data['activity'] = trim($activity);
        $data['bank_details'] = trim($details);
        $data['bank_id']    =  $bank_id;
        $data['remark'] = trim($remark);
        $data['status'] = ($status=='0')?'0':'1';
        $data['created_by'] = $created_by;
               // $data['created_at'] = (empty($created_at) && (($created_at=='1970-01-01 00:00:00') || ($created_at=='0000-00-00 00:00:00')))?date('Y-m-d H:i:s'):date('Y-m-d H:i:s',strtotime($created_at));

        $data['created_at'] = (!empty($created_at) && ($created_at!='1970-01-01 00:00:00'))?date('Y-m-d H:i:s',strtotime($created_at)):date('Y-m-d H:i:s');
        $data['action'] = $action;
        $this->Loan_customer_case->addLoanHistory($data);
    }
    public function addLoanHistoryUpdateLog($case_id,$updated_data=[],$module='-',$status,$action)
    {
        $data = [];
        $data['case_id'] = $case_id;
        $data['updated_data'] = serialize($updated_data);
        $data['module'] = $module;
        $data['status']    =  $status;
        $data['action'] = $action;
        $this->Loan_customer_case->addLoanHistoryUpdateLog($data);
    }

    public function renderLeadDetailsForm($id='') 
    {
        $data = [];
        if($id=='add')
        {
            $editId = '';
            $caseId  = '';
            $data['add'] = 1;
        }
        else
        {
            $editId  = !empty($id)? explode('_',base64_decode($id)):'';
            $caseId  = !empty($editId)?end($editId):'';
        }

        $data['pageTitle']      = 'Add Loan Details';
        $data['pageType']       = 'loan';
        $data['employeeListAll'] = $this->Crm_user->getEmployee();
        $data['employeeListByTeam'] = $this->Crm_user->getEmployee('7','','','22');
        $data['employeeList']   =  $this->Crm_user->getEmployee('1');
        $data['dealerList']     =  $this->Crm_dealers->getDealers('','0,1,2');
        if(!empty($caseId))
        {
            $custInfo               = $this->Loan_customer_case->getCaseInfoByCaseId($caseId);
            $data['CustomerInfo']   = $custInfo[0];
            if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
            if(!empty($data['CustomerInfo']['loan_amt']))
            {
                $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
                $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
               // $data['loanamt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
            }
            $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
         }
        if(!empty($data['CustomerInfo']['id']))
        {
            $caseIdArr              = current($this->Loan_customer_case->getCaseId($data['CustomerInfo']['id']));
            $data['refrenceData']   = current($this->Loan_customer_reference_info->getRefrenceId($caseIdArr['id']));
        }       
        if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
        $data['rolemgmt'] = $this->financeUserMgmt('','leadDetails');
        $this->loadViews("finance/leadDetail", $data);
    }
     public function saveUpdateFinanceData($id = '') {
        $params = $this->input->post();
       /* echo"<pre>";
        print_r($params);
        die();*/
        if (!empty($params['mobile'])) {
            $customerId = $this->crmCentralCustomer($params,'Loan');
            $params['customer_id'] = !empty($customerId) ? $customerId : '';
        }
        if(!empty($params['leadForm'])){
            $this->addEditLeadDetails($params);
        }
        if(!empty($params['CaseInfoForm'])){
            $this->addEditCaseInfoForms($params);
        }
        if(!empty($params['financeAcedmicForm'])){
            $this->addEditFinanaceAcedmicForms($params);
        }
        if(!empty($params['loanExpectedForm'])){
            $this->addEditLoanExpectedcForms($params);
        }
        if(!empty($params['residenceForm'])){
            $this->addEditResidenceForms($params);
        }
        if(!empty($params['refrenceForm'])){
            $this->addEditRefrenceDetails($params);
        }
        if(!empty($params['LeadLoginForm']))
        {
            $this->addEditFileLogin($params);
        }
        if(!empty($params['LeadCPVForm']))
        {
            $this->addEditCpvDetails($params);
        }
        if(!empty($params['LeadDecisionForm']))
        {
            $this->addEditCpvDetails($params);
        }
        if(!empty($params['LeadDisbursalForm']))
        {
            $this->addEditCpvDetails($params);
        }
        if(!empty($params['deliveryForm'])){
            $this->addEditLoanPostDetails($params);
        }
        if(!empty($params['paymentForm'])){
            $this->addEditLoanPaymentDetails($params);
        }
         if(!empty($params['paymentForm2'])){
            $this->addEditLoanPaymentDetails($params,'1');
        }
        if(!empty($params['bankInfoForm']))
        {
            $this->addEditBankInfo($params);
        }
        if(!empty($params['coapplicantForm'])){
            $this->addEditCoapplicantForms($params);
        }
        if(!empty($params['guarantorForm']))
        {
            $this->addEditGuarantorForms($params);
        }
    }   

    public function addEditLeadDetails($params){
        $leadInfoParams         = $this->renderCustomerDetailsParams($params);
        $updateId               = '';
        $caseId                 = '';
        $results                 = [];
        $data = [];
        $action  = '0';
        $editId= '';
        if(!empty($leadInfoParams['customer_id']) && (empty($params['actionType']))){
            $editId  = $leadInfoParams['customer_id'];
        }
        $validationCheck        = $this->leadDetailFormValidation($params,$editId);
        if(!empty($validationCheck)){
            echo json_encode($validationCheck);exit;
        }
        if(!empty($leadInfoParams['customer_id']) && (empty($params['actionType'])))
        {
            $getLoanCustomerId       = current($this->Loan_customer_info->getCustomerInfoByCaseID($params['caseId']));
            $updateId                = $getLoanCustomerId['customer_loan_id'];
            $action = '1';
            $data['leadInfoParams']  = $leadInfoParams;
        }else{
            $leadInfoParams['created_date'] = date('Y-m-d H:i:s');
        }
        $saveCustomerInfo       = $this->Loan_customer_info->saveUpdateCustomerInfo($leadInfoParams,$updateId);
        $checkIfCust = $this->getCustomerDetails('',$leadInfoParams['customer_id'],'1');
        if(empty($checkIfCust)){
            $custId = "";
        }
        else{
            $custId = $leadInfoParams['customer_id'];
        }
        $saveUpdateCustomerPersonnelInfo = $this->addUpdateMasterCustomer($leadInfoParams,$custId);

        if(!empty($saveCustomerInfo))
        {
            $checkCaseInfoExistance              = current($this->Loan_customer_case->getCaseId($saveCustomerInfo));
            $flag = '';
            if(!empty($checkCaseInfoExistance)){
                $caseId                          = $checkCaseInfoExistance['customer_loan_id'];
                $flag = 1;
            }
            $caseInfoParams                      = $this->renderCaseLeadDetailsParams($params);
            $caseInfoParams['customer_loan_id']  = $saveCustomerInfo;  
            $caseInfoParams['last_updated_date'] = date('Y-m-d H:i:s');
            if($action == 0){
            $caseInfoParams['created_date'] = date('Y-m-d H:i:s');    
            }
            
            $saveCaseInfo = $this->Loan_customer_case->saveUpdateCaseInfo($caseInfoParams,$caseId,$flag);
            $data['caseInfoParams'] = $caseInfoParams;
        }

        if (!empty($saveCustomerInfo) && !empty($saveCaseInfo && empty($updateId) && empty($caseId))) {
            $this->addLoanHistory($saveCustomerInfo,'Open','-','','','',$this->session->userdata['userinfo']['id'],'Add');
            $this->updateLoanStatus($data['caseInfoParams']['customer_loan_id'],'5');
            $results= array('status'=>'True','message'=>'Lead details Added Successfully','customerId'=>  base64_encode('CustomerId_'.$data['caseInfoParams']['customer_loan_id']));
        } elseif (!empty($updateId) && empty(!$caseId)) {
            $this->addLoanHistory($caseId,'Open','-','','','',$this->session->userdata['userinfo']['id'],'Update');
            $this->updateLoanStatus($data['caseInfoParams']['customer_loan_id']);
            $results= array('status'=>'True','message'=>'Lead details Updated Successfully','customerId'=>  base64_encode('CustomerId_'.$data['caseInfoParams']['customer_loan_id']));
        } else {
            $results= array('status'=>'False','message'=>'Something went Wrong');
        }

        $this->addLoanHistoryUpdateLog($saveCustomerInfo,$data,'leadForm','',$action);
        echo json_encode($results);exit;
    }
    
    public function renderCustomerDetailsParams($params){
        $leadDetails                            = [];
        if(isset($params)){
        $leadDetails['customer_id']             = !empty($params['customer_id'])?$params['customer_id']:'';
        $leadDetails['buyer_type']              = !empty($params['buyer_type'])?$params['buyer_type']:'';
        $leadDetails['case_field']              = !empty($params['case_ty'])?$params['case_ty']:'';
        $leadDetails['guaranter_case']          = !empty($params['guaranter_case'])?$params['guaranter_case']:'0';
        $leadDetails['co_applicant']             = !empty($params['co_app'])?$params['co_app']:'0'; 
        $leadDetails['name']                    = !empty($params['Cname'])?ucwords(strtolower(trim($params['Cname']))):'';
        $leadDetails['email']                   = !empty($params['Cemail'])?trim($params['Cemail']):'';
        $leadDetails['source_type']             = !empty($params['lead_source'])?$params['lead_source']:'';
        $leadDetails['dealer_id']               = !empty($params['dealerName'])?trim($params['dealerName']):'';
        $leadDetails['addmobile']               = !empty($params['Camobile'])?trim($params['Camobile']):'';
        //$leadDetails['rc_transfer_by']          = !empty($params['RctransferdoneBy'])?$params['RctransferdoneBy']:'';
        $leadDetails['meet_the_customer']       = !empty($params['meet_the_customer'])?$params['meet_the_customer']:'';
        $leadDetails['meeting_customer_place']  = !empty($params['meeting_customer_place'])?ucwords(strtolower(trim($params['meeting_customer_place']))):'';
        $leadDetails['seen_customer_doc']       = !empty($params['seen_customer_doc'])?$params['seen_customer_doc']:'';
        $leadDetails['discussed_manager']       = !empty($params['case_discussed'])?$params['case_discussed']:'';
        $leadDetails['reason_recommendation']   = !empty($params['reasonRecommendation'])?$params['reasonRecommendation']:'';
        $leadDetails['lead_status']             = !empty($params['lead_status'])?$params['lead_status']:'';
        $leadDetails['dealt_by']                = !empty($params['dealt_by'])?$params['dealt_by']:'';
        $leadDetails['assign_case_to']          = !empty($params['assign_case_to'])?$params['assign_case_to']:'';        
        }
        return $leadDetails;
    }
    
    public function renderCaseLeadDetailsParams($params){
        $caseInfo                            = [];
        if(isset($params)){
        $caseInfo['loan_for']                = !empty($params['loan_for'])?$params['loan_for']:'';
        $caseInfo['loan_type']               = !empty($params['loan_type'])?$params['loan_type']:'';
        //$caseInfo['created_date']         = date('Y-m-d H:i:s');
        if(!empty($_SESSION['userinfo'])){
        $caseInfo['created_by']          = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
        }
        }
        return $caseInfo;
    }
    
    public function leadDetailFormValidation($params,$editid='') {
        $this->form_validation->set_error_delimiters('', '');
        if(empty($params['buyer_type'])){
        $this->form_validation->set_rules('buyer_type', 'Buyer Type', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['loan_for'])){
        $this->form_validation->set_rules('loan_for', 'Loan For', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['loan_type'])){
        $this->form_validation->set_rules('loan_type', 'Loan Type', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        } if(empty($params['mobile'])){
        $this->form_validation->set_rules('mobile','Mobile','required|min_length[10]|max_length[10]|regex_match[/^[6-9][0-9]{9}$/]');
        if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(!empty($params['mobile'])){
        $this->form_validation->set_rules('mobile','Mobile','min_length[10]|max_length[10]|regex_match[/^[6-9][0-9]{9}$/]');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['Cname'])){
        $this->form_validation->set_rules('Cname','Name','required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(!empty($params['Cname'])){
            $this->form_validation->set_rules('Cname','Name','required|min_length[3]','required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
       if(empty($params['Cemail'])){
        $this->form_validation->set_rules('Cemail', 'Email Address', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(!empty($params['Cemail']) && (empty($editid)) && (empty($params['precustomer']))){
            $this->form_validation->set_rules('Cemail', 'Email Address', 'valid_email|is_unique[loan_customer_info.email]');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else{
           $this->form_validation->set_rules('Cemail', 'Email Address', 'valid_email','required'); 
            if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['lead_source'])){
        $this->form_validation->set_rules('lead_source', 'Lead Source', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(!empty($params['lead_source'])&& $params['lead_source']=='1'){
        if(empty($params['dealerName'])){
        $this->form_validation->set_rules('dealerName', 'Dealer Name', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        }
        if(isset($params['seen_customer_doc']) && empty($params['seen_customer_doc'])){
          $this->form_validation->set_rules('seen_customer_doc', 'Document Feedback', 'required');  
           if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }  
        }
        if(empty($params['dealt_by'])){
          $this->form_validation->set_rules('dealt_by', 'Dealt By', 'required');  
           if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['assign_case_to'])){
           $this->form_validation->set_rules('assign_case_to', 'Assign Case To', 'required'); 
            if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        $this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
        if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
    }
    
    public function personalDetail($id=''){
        $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $casesId  = !empty($editId)?end($editId):'';
        $custInfo       = $this->Loan_customer_case->getCaseInfoByCaseId($casesId);
        $customerName  = $custInfo[0];

        $data = [];
        $data['pageTitle']      = 'Personal Details';
        $data['pageType']       = 'loan';
        $data['CustomerInfo']   = !empty($customerName)?$customerName:'';
        if(!empty($data['CustomerInfo']['modelId'])){
            $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
        }
        if(!empty($data['CustomerInfo']['loan_amt'])){
            $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
            $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
          //  $data['loanamt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
        }
        $data['customerId']     = !empty($data['CustomerInfo']['customer_id'])?$data['CustomerInfo']['customer_id']:'';
        $personelDetail = $this->getCustomerDetails('',$data['CustomerInfo']['customer_id'],'1');
        $data['CustomerPerDetail'] = $personelDetail[0];
        $customerMobileNumber      = $this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']);
        $data['customerMobileNumber'] = $customerMobileNumber[0];
        //$data['CustomerInfo']       = current($this->Loan_customer_info->getCustomerInfoByCustomerId($customerId));
        $caseIdInfo                            = current($this->Loan_customer_case->getCaseId($data['CustomerInfo']['id']));
        $caseId = $caseIdInfo['customer_loan_id'];
        $data['refrenceData']              = current($this->Loan_customer_reference_info->getRefrenceId($caseId['id']));
        $data['rolemgmt'] = $this->financeUserMgmt('','personalDetail');
        if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
        $this->loadViews("finance/personalDetail", $data);
    }
    
    public function addEditCaseInfoForms($params){
        $customerInfos          = $this->Loan_customer_info->getCustomerInfoByCaseID($params['caseId']);
        $customerInfo           = $customerInfos[0];
        $personalInfo           = $this->renderPersonalInfo($params,$customerInfo);
        $validationCheck        = $this->personalDetailFormValidation($params);
        $action = '0';
        if(!empty($validationCheck)){
            echo json_encode($validationCheck);exit;
             
        }

        if(!empty($params['customerId']))
        {
            //echo $customerInfo['id']; exit;
            $savepersonalInfo       = $this->Loan_customer_info->saveUpdateCustomerInfo($personalInfo,$customerInfo['customer_loan_id']);
            $saveUpdateCustomerInfo = $this->addUpdateMasterCustomer($personalInfo,$customerInfo['customer_id']);
            $action = '1';  
            $this->updateLoanStatus($customerInfo['customer_loan_id']);
           // $data['last_updated_date'] = date('Y-m-d H:i:s');
            //$lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($data, $params['caseId']);
        }
        if(!empty($savepersonalInfo)){
            $result= array('status'=>'True','message'=>'Customer Personal Details Added Successfully','Action'=>  base_url().'financeAcedmic/' . base64_encode('CustomerId_' . $params['caseId']));
        }
        $this->addLoanHistoryUpdateLog($savepersonalInfo,$params,'Personal Info','',$action);
        //$this->addLoanHistory($savepersonalInfo,'Personal Info','-','','','0',$this->session->userdata['userinfo']['id']);
        echo json_encode($result);exit;
    }
    
    public function renderPersonalInfo($params,$customerInfo){
        $personalInfo                            = [];
        if(isset($params)){
        $personalInfo['gender']                       = !empty($params['gender'])?$params['gender']:'';
        $personalInfo['martial_status']               = !empty($params['martial_status'])?$params['martial_status']:'';
        if(isset($customerInfo) && $customerInfo['Buyer_Type']=='2'){
        $personalInfo['dob']                          = !empty($params['dob'])?date('Y-m-d',strtotime($params['dob'])):'';
        $personalInfo['date_of_incorporation']  = '';
        }else{
             $personalInfo['dob'] = '';
        $personalInfo['date_of_incorporation']        = !empty($params['dob'])?date('Y-m-d',strtotime($params['dob'])):'';
        $personalInfo['gst_number']                 = !empty($params['gst_number'])?trim($params['gst_number']):'';
        }
        $personalInfo['no_of_dependent']              = !empty($params['no_of_dependent'])?trim($params['no_of_dependent']):'';
        $personalInfo['pan_number']                   = !empty($params['pan_number'])?trim($params['pan_number']):'';
        $personalInfo['aadhar_no']                    = !empty($params['aadhar_no'])?trim($params['aadhar_no']):'';
        $personalInfo['father_name']                  = !empty($params['father_name'])?ucwords(strtolower(trim($params['father_name']))):'';
        $personalInfo['mother_name']                  = !empty($params['mother_name'])?ucwords(strtolower(trim($params['mother_name']))):'';
        $personalInfo['updated_date']                 = date('Y-m-d H:i:s');
        }
        return $personalInfo;
    }
    
     public function personalDetailFormValidation($params) {
        $this->form_validation->set_error_delimiters('', '');
        if(empty($params['gender']) && ($params['buyerType']=='2')){
        $this->form_validation->set_rules('gender', 'Gender', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['martial_status']) && ($params['buyerType']=='2')){
        $this->form_validation->set_rules('martial_status', 'Martial Status', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['dob']) && ($params['buyerType']=='2')){
        $this->form_validation->set_rules('dob', 'Date of Birth/Incorp', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['no_of_dependent']) && ($params['buyerType']=='2')){
        $this->form_validation->set_rules('no_of_dependent', 'No of Dependent', 'required|max_length[2]','required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(!empty($params['no_of_dependent'])){
        $this->form_validation->set_rules('no_of_dependent', 'No of Dependent', 'required|max_length[2]','required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['pan_number'])){
        $this->form_validation->set_rules('pan_number', 'Pan Number', 'required|max_length[10]|regex_match[/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/]');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['father_name']) && ($params['buyerType']=='2')){
        $this->form_validation->set_rules('father_name', 'Father Name', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['mother_name']) && ($params['buyerType']=='2')){
        $this->form_validation->set_rules('mother_name', 'Mother Name', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
    }
    
    public function financeAcedmic($id=''){
        $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $casesId  = end($editId);
        $customerName          = $this->Loan_customer_case->getCaseInfoByCaseId($casesId);
        $data = [];
        $data['pageTitle']      = 'Finance Acedmic';
        $data['pageType']       = 'loan';
        $data['CustomerInfo']   = !empty($customerName[0])?$customerName[0]:'';
        if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
         if(!empty($data['CustomerInfo']['loan_amt']))
        {
            $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
            $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
        }
        $data['customerId']     = !empty($data['CustomerInfo']['customer_id'])?$data['CustomerInfo']['customer_id']:'';
        $data['edicationType']  = ['0'=>'Select Highest Education','1'=>'10th','2'=>'12th','3'=>'Under Graduate','4'=>'Post Graduate','5'=>'Others'];
        $data['employmentType']  = ['1'=>'Salaried','2'=>'Self Employed-Business','3'=>'Self Employed-Profession','4'=>'Others'];
        //$data['CustomerInfo']   = current($this->Loan_customer_info->getCustomerInfoByCustomerId($customerId));
        $data['bus_applicantList']   = $this->Crm_applicant_type->ApplicantTypeListing('Applicant Type');
        $data['bus_industryList']   = $this->Crm_applicant_type->IndustryTypeListing('business');
        $data['oth_industryList']   = $this->Crm_applicant_type->ApplicantTypeListing('Other Type');
        $data['professionList']   = $this->Crm_applicant_type->ApplicantTypeListing('Profession Type');
        $data['cityList']      = $this->City->getAllCityListNew();
        $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
       // $caseId                            = current($this->Loan_customer_case->getCaseId($data['CustomerInfo']['customer_loan_id']));
        $caseId = $casesId;
        $data['refrenceData']              = current($this->Loan_customer_reference_info->getRefrenceId($caseId));
        if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
        $data['CustomerInfo']['bus_start_business_date'] = $data['CustomerInfo']['bus_start_business_mon'].'-'.$data['CustomerInfo']['bus_start_business_year'];
        /*echo "<pre>";
       print_r($data);
       exit; */
        $data['rolemgmt'] = $this->financeUserMgmt('','financeAcedmic');
        $this->loadViews("finance/financeAcedmic", $data);
    }
    
    public function addEditFinanaceAcedmicForms($params){
        $customerInfos             = $this->Loan_customer_info->getCustomerInfoByCaseID($params['caseId']);
         $customerInfo =  $customerInfos[0];
        $financeAcedmic           = $this->renderFinanceAcedmic($params,$customerInfo);
        $validationCheck       = $this->financeAcademicDetailFormValidation($params);
        //print_r($validationCheck);
        if(!empty($validationCheck)){
         $result = $validationCheck;             
        }else{
        if(!empty($params['customerId']))
        {
            $customerProId       = $this->Loan_customer_info->saveUpdateCustomerInfo($financeAcedmic,$customerInfo['customer_loan_id']);
            $financeAcedmicOther           = $this->renderFinanceAcedmicOther($params,$customerInfo['customer_id'],$customerProId);
            $customerOtherinfo=current($this->Loan_customer_info->getCustomerOtherInfo($customerInfo['customer_id']));
            if(!empty($customerOtherinfo['customer_id']))
            {
                $savepersonalInfo       = $this->Loan_customer_info->saveUpdateCustomerOtherInfo($financeAcedmicOther,$customerOtherinfo['customer_id']);
                $action = '1';
            }
            else
            {
              $savepersonalInfo       = $this->Loan_customer_info->saveUpdateCustomerOtherInfo($financeAcedmicOther);
              $action = '0';  
            }
            $this->updateLoanStatus($customerInfo['customer_loan_id']);
            //$data['last_updated_date'] = date('Y-m-d H:i:s');
            //$lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($data, $params['caseId']);
            $this->addLoanHistoryUpdateLog($params['caseId'],$financeAcedmicOther,'Finance Academic','',$action);
            //$this->addLoanHistory($params['caseId'],'Education and Employment Details Added','-','','Finance Academic','0',$this->session->userdata['userinfo']['id']);
        }
        if(!empty($savepersonalInfo)){
            $result= array('status'=>'True','message'=>'Financial & Academic Details Added Successfully','Action'=>  base_url().'loanExpected/' . base64_encode('CustomerId_' . $params['caseId']));
        }
        }
        echo json_encode($result);exit;
    }
    public function renderFinanceAcedmic($params,$customerInfo){
        $financeAcedmic                            = [];
        if(isset($params)){
        $financeAcedmic['highest_education']       = !empty($params['highest_education'])?$params['highest_education']:'';
        $financeAcedmic['profession_type']         = !empty($params['profession_type'])?$params['profession_type']:'';
        $financeAcedmic['industory_detail']        = !empty($params['industory_detail'])?$params['industory_detail']:'';
        $financeAcedmic['annual_income']           = !empty($params['annual_income'])?trim($params['annual_income']):'';
        $financeAcedmic['annual_income']           = !empty($params['annual_income'])?trim($params['annual_income']):'';
        $financeAcedmic['type_of_vehicle_owned']   = !empty($params['type_of_vehicle_owned'])?$params['type_of_vehicle_owned']:'';
        $financeAcedmic['vehicle_ownership']       = !empty($params['vehicle_ownership'])?$params['vehicle_ownership']:'';
        //$financeAcedmic['office']                  = !empty($params['office'])?$params['office']:'';
        $financeAcedmic['office_landmark']          = !empty($params['office_landmark'])?ucwords(strtolower(trim($params['office_landmark']))):'';
         $financeAcedmic['office_address']          = !empty($params['office_address'])?ucwords(strtolower(trim($params['office_address']))):'';
        $financeAcedmic['office_pincode']          = !empty($params['office_pincode'])?trim($params['office_pincode']):'';
        $financeAcedmic['office_phone']            = !empty($params['office_phone'])?trim($params['office_phone']):'';
        $financeAcedmic['office_mobile']           = !empty($params['office_mobile'])?trim($params['office_mobile']):'';
        $financeAcedmic['office_email']            = !empty($params['office_email'])?trim($params['office_email']):'';
        $financeAcedmic['office_city']             = !empty($params['office_cityList'])?$params['office_cityList']:'';
        
    }
        return $financeAcedmic;
    }
    
    public function renderFinanceAcedmicOther($params,$customerInfoId,$customerProId){
        $financeAcedmic                            = [];
        //echo "zzz".$customerInfoId;die;
        if(isset($params)){
            $bus_start_business_date = explode('-', $params['bus_start_business_date']);
        $financeAcedmic['customer_info_id']  =  $customerProId; 
        $financeAcedmic['customer_id']       =  $customerInfoId;
        $financeAcedmic['employment_type']   =  !empty($params['employment_type'])?$params['employment_type']:'';
        if($params['empType']=='1'){    
        $financeAcedmic['employer_name']       = !empty($params['employer_name'])?ucwords(strtolower(trim($params['employer_name']))):'';
        $financeAcedmic['employee_doj']         = !empty($params['date_of_joining'])?date('Y-m-d',strtotime($params['date_of_joining'])):'';
        $financeAcedmic['totalexp']        = !empty($params['total_experience'])?trim($params['total_experience']):'';
        $financeAcedmic['gross_mon_income']           = !empty($params['monthly_income'])?trim($params['monthly_income']):'';
        $financeAcedmic['is_notice_period']           = !empty($params['notice_period'])?trim($params['notice_period']):'';
        }
        if($params['empType']=='2'){
        $financeAcedmic['bus_applicant_type']   = !empty($params['bus_applicant_type'])?$params['bus_applicant_type']:'';
        $financeAcedmic['bus_industry_type']       = !empty($params['bus_industry_type'])?$params['bus_industry_type']:'';
        $financeAcedmic['bus_business_name']                  = !empty($params['bus_business_name'])?ucwords(strtolower(trim($params['bus_business_name']))):'';
        $financeAcedmic['bus_off_set_up']          = !empty($params['bus_office_setup_type'])?$params['bus_office_setup_type']:'';
        $financeAcedmic['bus_start_business_mon']  = !empty($bus_start_business_date[0])?$bus_start_business_date[0]:'';
        $financeAcedmic['bus_start_business_year'] = !empty($bus_start_business_date[1])?$bus_start_business_date[1]:'';
        $financeAcedmic['bus_itr_income1']           = !empty($params['bus_itr_income1'])?trim($params['bus_itr_income1']):'';
        $financeAcedmic['bus_itr_income2']            = !empty($params['bus_itr_income2'])?trim($params['bus_itr_income2']):'';
        }
        if($params['empType']=='3'){
        $financeAcedmic['pro_off_set_up']               = !empty($params['pro_office_setup_type'])?$params['pro_office_setup_type']:'';
        $financeAcedmic['pro_itr_income1']              = !empty($params['pro_itr_income1'])?trim($params['pro_itr_income1']):'';
        $financeAcedmic['pro_itr_income2']              = !empty($params['pro_itr_income2'])?trim($params['pro_itr_income2']):'';
        $financeAcedmic['pro_industry_type']            = !empty($params['pro_industry_type'])?$params['pro_industry_type']:'';
        $financeAcedmic['pro_start_date_mon']           = !empty($params['pro_start_date_month'])?$params['pro_start_date_month']:'';
        $financeAcedmic['pro_start_date_year']          = !empty($params['pro_start_date_year'])?$params['pro_start_date_year']:'';
        }
        if($params['empType']=='4'){
        $financeAcedmic['oth_type']                     = !empty($params['oth_type'])?$params['oth_type']:'';
        $financeAcedmic['oth_customer_own']             = !empty($params['others_followup'])?$params['others_followup']:'';
        $financeAcedmic['oth_customer_taken_loan']      = !empty($params['others_loan'])?$params['others_loan']:'';
        }
        $financeAcedmic['created_on'] = date('Y-m-d H:i:s');
    }
        return $financeAcedmic;
    }
    
    public function financeAcademicDetailFormValidation($params){
        if($params['buyerType']=='2'){
        $this->form_validation->set_error_delimiters('', '');
        if(empty($params['highest_education'])){
        $this->form_validation->set_rules('highest_education', 'Highest Education', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }if(!empty($params['highest_education'])){
        $this->form_validation->set_rules('highest_education', 'Highest Education','numeric|required|greater_than[0]', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['employment_type'])){
        $this->form_validation->set_rules('employment_type', 'Employment Type', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['type_of_vehicle_owned'])){
        $this->form_validation->set_rules('type_of_vehicle_owned', 'Type of vehicle owned', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['vehicle_ownership'])){
        $this->form_validation->set_rules('vehicle_ownership', 'Vehicle Ownership', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        }
        if($params['buyerType']=='2'){
        if($params['employment_type']=='1'){
           if(empty($params['employer_name'])){
            $this->form_validation->set_rules('employer_name', 'Employer Name', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(!empty($params['employer_name'])){
            $this->form_validation->set_rules('employer_name', 'Employer Name','required|min_length[3]', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }
            else if(empty($params['date_of_joining'])){
            $this->form_validation->set_rules('date_of_joining', 'Date of Joining', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(empty($params['total_experience'])){
            $this->form_validation->set_rules('total_experience', 'Total Experience', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(empty($params['monthly_income'])){
            $this->form_validation->set_rules('monthly_income', 'Monthly Income', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(empty($params['notice_period'])){
            $this->form_validation->set_rules('notice_period', 'Notice Period', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            } 
        }
        if($params['employment_type']=='2'){
              $bus_start_business_date = explode('-', $params['bus_start_business_date']);
              $params['bus_start_date_month'] = $bus_start_business_date[0];
              $params['bus_start_date_year'] = $bus_start_business_date[1];
            if(empty($params['bus_applicant_type'])){
            $this->form_validation->set_rules('bus_applicant_type', 'Applicant Type', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(empty($params['bus_industry_type'])){
            $this->form_validation->set_rules('bus_industry_type', 'Industry Type', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(empty($params['bus_business_name'])){
            $this->form_validation->set_rules('bus_business_name', 'Business Name', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(empty($params['bus_office_setup_type'])){
            $this->form_validation->set_rules('bus_office_setup_type', 'Office Set Up Type', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(empty($params['bus_start_date_month'])){
            $this->form_validation->set_rules('bus_start_date_month', 'Start Date Of Month', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(empty($params['bus_start_date_year'])){
            $this->form_validation->set_rules('bus_start_date_year', 'Start Date Of Year', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(!empty($params['bus_start_date_year'])){
                //exit;
            if((($params['bus_start_date_month']) > date('n')) && $params['bus_start_date_year']==date('Y'))
                {
                    //echo "dwedwd"; exit;
                    $this->form_validation->set_rules('bus_start_date_month', 'Start Date Of Month', 'dateRule',
                         array('dateRule' => 'Date should be smaller than current date %s.')
                         );
                    if ($this->form_validation->run() == FALSE) {
                    return array('status'=>'False','message'=>validation_errors());
                }
            }
        }
        else if(!empty($params['bus_start_date_year']) && ($params['bus_start_date_year'] < date(Y))){

             if(empty($params['bus_itr_income1'])){
            $this->form_validation->set_rules('bus_itr_income1', 'Gross Income of previous year', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(empty($params['bus_itr_income2'])){
            $this->form_validation->set_rules('bus_itr_income2', 'Gross Income of previous year', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        }
        }
        if($params['employment_type']=='3'){
           if(empty($params['pro_office_setup_type'])){
            $this->form_validation->set_rules('pro_office_setup_type', 'Office Set Up Type', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['pro_industry_type'])){
            $this->form_validation->set_rules('pro_industry_type', 'Profession Type', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(empty($params['pro_start_date_month'])){
            $this->form_validation->set_rules('pro_start_date_month', 'Start Date Of Month', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(empty($params['pro_start_date_year'])){
            $this->form_validation->set_rules('pro_start_date_year', 'Start Date Of Year', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        } 
        }
        if($params['employment_type']=='4'){
           if(empty($params['oth_type'])){
            $this->form_validation->set_rules('oth_type', 'Other Type', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(empty($params['others_followup'])){
            $this->form_validation->set_rules('others_followup', 'Does the customer own', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(empty($params['others_loan'])){
            $this->form_validation->set_rules('others_loan', 'Has the Customer taken', 'required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }
        }
        
        $this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
    }
    }

    
     public function loanExpected($id=''){
        $this->load->helper('date_helper');
        $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $casesId  = !empty($editId)? end($editId):''; 
        $custInfo       = $this->Loan_customer_case->getCaseInfoByCaseId($casesId);
        $customerName   = $custInfo[0];
        //$customerName          = current($this->Loan_customer_info->getCustomerInfo($customerId));
        $data = [];
        $data['pageTitle']      = 'Loan Expected';
        $data['pageType']       = 'loan';
        $data['CustomerInfo']   =  !empty($customerName)?$customerName:'';
        if(!empty($data['CustomerInfo']['modelId'])){
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
        }
        $data['CustomerInfo']['mmyear'] = '';
        if(!empty($data['CustomerInfo']['mm']) && (!empty($data['CustomerInfo']['myear']))){
            $da = '01-'.$data['CustomerInfo']['mm'].'-'.$data['CustomerInfo']['myear'];
           $data['CustomerInfo']['mmyear'] = date('m-Y',strtotime($da));
        }
        if(!empty($data['CustomerInfo']['loan_amt'])){
            $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
            $data['CustomerInfo']['loan_expected'] = $this->IND_money_format($data['CustomerInfo']['loan_expected']);
            $data['CustomerInfo']['ex_loan_expected'] = $this->IND_money_format($data['CustomerInfo']['ex_loan_expected']);
            $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
        }
        $data['customerId']     = !empty($data['CustomerInfo']['customer_id'])?$data['CustomerInfo']['customer_id']:'';
        //$data['makeList']       = (array) $this->Make_model->getMake();
         $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));

        $caseId                 = $casesId; //current($this->Loan_customer_case->getCaseId($data['CustomerInfo']['id']));
        $data['makeList']       = (array) $this->getMakeModelNameComm();
        $data['showroomList']     =  $this->Crm_dealers->getDealers('','1','1');
        $makeId=(!empty($data['CustomerInfo']['makeId'])) ? $data['CustomerInfo']['makeId'] : '';
        $modelId=(!empty($data['CustomerInfo']['modelId'])) ? $data['CustomerInfo']['modelId'] : '';
        $data['version']        =  $this->getVersionComm($makeId,$modelId,'1');
        $data['monthlist']= getMonthArr();
        //$data['citylist'] = $this->City->getAllCityList();
        $data['refrenceData']   = current($this->Loan_customer_reference_info->getRefrenceId($caseId));
        if($data['CustomerInfo']['loan_for']=='2'){
            if($data['CustomerInfo']['meet_the_customer']=='1'){
                $data['banks']          = $this->Crm_banks->getAllBankId();
            }else{
                $data['banks']          = $this->Crm_banks->getEmpBankInfo($data['CustomerInfo']['meet_the_customer']);
            }
        }
        else{
             $data['banks']          = $this->Crm_banks->getAllBankId(); 
        }
        $data['loanValue']      = $this->Loan_customer_case->getLoanInfoByCustomerId($data['CustomerInfo']['customer_loan_id'],0,1);
        if(!empty($data['banks'])){
            $data['bankname']       = $this->Crm_banks->getBankNameById($data['banks']);
        }
        if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        
        $data['CustomerInfo']['left_amt'] = $left_amount;
        $data['rto']       = $this->Loan_customer_case->getRto();
        $data['allbank'] = $this->Crm_banks->getcustomerBankList();
        $data['rolemgmt'] = $this->financeUserMgmt('','loanExpected');
        $this->loadViews("finance/loanExpected", $data);
    }

    public function getMakeModelNameByYear()
    {
        return $this->getMakeModelNameComm($myear);
    }
    
    public function addEditLoanExpectedcForms($params)
    {
        $params['loan_amt']       = str_replace(',','',$params['loan_amt']);
        $params['ex_loan_amt']       = str_replace(',','',$params['ex_loan_amt']);
        $customerInfos            = $this->Loan_customer_info->getCustomerInfoByCaseID($params['caseId']);
        $customerInfo             = $customerInfos[0];
        $loanExpectecd            = $this->renderLoanExpected($params,$customerInfo);
        $loansExpected            = $this->renderLoanExpected($params,$customerInfo,1);
        $centralStock             = $this->renderLoanExpected($params,$customerInfo,2);
        $validationCheck          = $this->LoanExpectedFormValidation($params);
        $result                   = []; 
        $hisData = [];
        $action = "0";
        $actions = "Add";
        if(!empty($validationCheck)){
         echo json_encode($validationCheck);exit;
        }
        $checkIfAlreadyExists = $this->Loan_customer_info->getCustomerInfoByCustomerId('','',$params['caseId']);
        if(!empty($checkIfAlreadyExists))
        {
            $makeId = $checkIfAlreadyExists[0]['makeId']; 
            $modelId = $checkIfAlreadyExists[0]['modelId'];
            $versionId = $checkIfAlreadyExists[0]['versionId'];
            if($makeId>0)
            {
                $actions = 'Update';
                $activity = 'Loan Expected';
                $action = '1';
                $remark = 'Loan Expected';
            }
            else
            {
                $activity = 'Loan Expected';
                $remark = 'Loan Expected';
            }
            $makenIdNew = $loanExpectecd['makeId'];
            $modelIdNew = $loanExpectecd['modelId'];
            $versionIdNew = $loanExpectecd['versionId'];
            if(($makeId>0) && ($makeId!=$makenIdNew) && ($modelId!=$modelIdNew) && ($versionId!=$versionIdNew))
            {
                $action = '1';
                $actions = 'Update';
                $remark = 'Car changed';
                $his = $this->addLoanHistory($params['caseId'],$remark,'-','-',$remark,'',$this->session->userdata['userinfo']['id'],'Add');
            }
        }
        $editId = ($actions == 'add')? false : $params['caseId'];
        if(!empty($params['engine_number']) && !empty($params['chassis_number'])){

        $isExist=$this->Loan_customer_case->checkduplicateCase($params['engine_number'],$params['chassis_number'],$customerInfo['id'],180);
        if($isExist){
         $result= array('status'=>'False','message'=>'<span class="duplicatecheck"> Case Already Exists with Case ID - '.$isExist.' </span>','errortype' => 2,'titlehead' => 'Duplicate Case' ,'caseids' => $isExist );   
         echo json_encode($result);exit;   
        }}

        $savepersonalInfo      =  $this->Loan_customer_case->saveUpdateCaseInfo($loanExpectecd,$customerInfo['customer_loan_id'],1);
        $hisData['loanExpectecd']   = $loanExpectecd;
        $loansExpected['case_id']   = $savepersonalInfo;   
        
        // check if loan file have same case
        $checkIfExistss = $this->Loan_customer_case->checkIfExists('',$loansExpected['case_id']);
        if(empty($checkIfExistss)){
            $checkIfExist = $this->Loan_customer_case->checkIfExists($loansExpected['bank_id'] ,$loansExpected['case_id']);
            if(empty($checkIfExist))
            {
                $saveLoanInfo = $this->Loan_customer_case->saveCaseFileLogin($loansExpected);
                $bankk         = $this->Crm_banks->getBankNameBybnkId($loansExpected['bank_id']);
            }
            else
            {
                //$saveLoanInfo = $this->Loan_customer_case->saveCaseFileLogin($loansExpected,$loansExpected['case_id']);
            }

        }
        $this->crmCentralStockData($centralStock,'Loan');
        $this->updateLoanStatus($customerInfo['customer_loan_id']);
        $hisData['fileData']=$loansExpected;
        $bankk  = $this->Crm_banks->getBankNameBybnkId($loansExpected['bank_id']);
        if(!empty($savepersonalInfo))
        {
           if((!empty($customerInfo['Buyer_Type'])) && ($customerInfo['Buyer_Type']=='2')){
            $result= array('status'=>'True','message'=>'Loan Expected Details Added Successfully','Action'=>  base_url().'residentialInfo/' . base64_encode('CustomerId_' . $params['caseId']));
             }else  
             {
                 $result= array('status'=>'True','message'=>'Loan Expected Details Added Successfully','Action'=>  base_url().'refrenceDetails/' . base64_encode('CustomerId_' . $params['caseId']));
             }
        }
        $this->addLoanHistoryUpdateLog($loansExpected['case_id'],$hisData,$module='Loan Expected','',$action);
        if(empty($his)){
            //echo $loansExpected['case_id'].$activity.$bankk['bank_name'] .$loansExpected['bank_id'].$remark.$this->session->userdata['userinfo']['id'].$actions;
            $this->addLoanHistory($loansExpected['case_id'],$activity,$bankk['bank_name'] ,$loansExpected['bank_id'],$remark,'',$this->session->userdata['userinfo']['id'],$actions);
        }
        echo json_encode($result);exit;
    }
    
    public function renderLoanExpected($params,$customerInfo,$loanData=''){
        $loanExpectecd                            = [];
       $params['regno'] =  str_replace(' ', '', $params['regno']);
        $mmyear = !empty($params['mmyear'])?$params['mmyear']:'';
        $myr = explode('-', $mmyear);
        if(isset($params)){
        $loanExpectecd['makeId']         = !empty($params['makeId'])?$params['makeId']:'';
        $loanExpectecd['mm']         = !empty($myr[0])?$myr[0]:'';
        $loanExpectecd['myear']         =!empty($myr[1])?$myr[1]:'';
        $loanExpectecd['modelId']        = !empty($params['modelId'])?$params['modelId']:'';
        $loanExpectecd['versionId']      = !empty($params['versionId'])?$params['versionId']:'';
        $loanExpectecd['reg_year']       = !empty($params['reg_year'])?date('Y-m-d',strtotime($params['reg_year'])):'';
        $loanExpectecd['regno']          = !empty($params['regno'])?ucwords(strtolower(trim($params['regno']))):'';
        $loanExpectecd['engine_number']  = !empty($params['engine_number'])?trim($params['engine_number']):'';
        $loanExpectecd['challanexist']  = !empty($params['challanexist'])?trim($params['challanexist']):'';
        $loanExpectecd['chassis_number'] = !empty($params['chassis_number'])?trim($params['chassis_number']):'';
        $loanExpectecd['loan_expected']       = !empty($params['loan_amt'])?trim($params['loan_amt']):'';
        $loanExpectecd['roi_expected']            = !empty($params['roi'])?trim($params['roi']):'';
        $loanExpectecd['tenor_expected']          = !empty($params['tenor'])?trim($params['tenor']):'';
        $loanExpectecd['bank_expected']        = !empty($params['financer'])?trim($params['financer']):'';
        $loanExpectecd['rto_id']        = !empty($params['rto'])?trim($params['rto']):'';
        $loanExpectecd['updated_date']   = date('Y-m-d H:i:s');
        $loanExpectecd['ex_loan_expected']        = !empty($params['ex_loan_amt'])?trim($params['ex_loan_amt']):'';
        $loanExpectecd['hpto']        = !empty($params['hpto'])?$params['hpto']:'';

       // $loanExpectecd['showroomAddress']  = !empty($params['showroom_address'])?trim($params['showroom_address']):'';
        //$loanExpectecd['showroomName']  = !empty($params['showroomName'])?trim($params['showroomName']):'';
           
        
        }
        if($loanData==1)
        {
            $loanExpectecd                            = [];
            $loanExpectecd['file_loan_amount']       = !empty($params['loan_amt'])?$params['loan_amt']:'';
            $loanExpectecd['file_roi']            = !empty($params['roi'])?$params['roi']:'';
            $loanExpectecd['file_tenure']          = !empty($params['tenor'])?$params['tenor']:'';
            $loanExpectecd['bank_id']        = !empty($params['financer'])?$params['financer']:'';
            $loanExpectecd['created_on']   = date('Y-m-d H:i:s');
        }
        if($loanData==2)
        {
            $loanExpectecd                            = [];
            $loanExpectecd['loan_for']         = !empty($customerInfo['loan_for'])?$customerInfo['loan_for']:'';
            $loanExpectecd['mm']         = !empty($params['makemonth'])?$params['makemonth']:'';
            $loanExpectecd['myear']         = !empty($params['myear'])?$params['myear']:'';
            $loanExpectecd['make_id']         = !empty($params['makeId'])?$params['makeId']:'';
            $loanExpectecd['model_id']        = !empty($params['modelId'])?$params['modelId']:'';
            $loanExpectecd['version_id']      = !empty($params['versionId'])?$params['versionId']:'';
            $loanExpectecd['loan_case_id']    = !empty($customerInfo['customer_loan_id'])?$customerInfo['customer_loan_id']:'';
            $loanExpectecd['loan_customer_id']       = !empty($customerInfo['customer_id'])?$customerInfo['customer_id']:'';
            $loanExpectecd['reg_no']          = !empty($params['regno'])?strtoupper(trim($params['regno'])):'';
            $loanExpectecd['engine_no']  = !empty($params['engine_number'])?strtoupper(trim($params['engine_number'])):'';
            $loanExpectecd['chassis_no'] = !empty($params['chassis_number'])?strtoupper(trim($params['chassis_number'])):'';
        }
        return $loanExpectecd;
    }
    

    function getModel() {
        $make    = $this->input->post('make');
        echo $this->getModelComm($make,'1');
    }
    function getVersion() {
        $model      = $this->input->post('model');
        $make       = $this->input->post('make');
        $flag       = $this->input->post('flag');
        $year       = $this->input->post('year');
        echo $this->getVersionComm($make,$model,$flag ,'1',$year);
        //echo $this->db->last_query();
    }

    function getMakeModelIdName()
    {
        $opt = '';
        $result =  $this->getMakeModelNameComm(); 
        if(!empty($result))
        {
            $option  = "<option value='' >Select Make Model</option>";
            foreach ($result as $ModelKey => $ModelValue) {
                $option .="<option rel='".$ModelValue['make_id']."'  value='" . $ModelValue['model_id'] . "' >" . $ModelValue['make'] .' '. $ModelValue['model']. "</option>";
            } 
            echo   $option;
        }
    }
    
    public function LoanExpectedFormValidation($params) {
        $this->form_validation->set_error_delimiters('', '');
        if(empty($params['loan_amt'])){
        $this->form_validation->set_rules('loan_amt', 'Loan Amount', 'required');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['roi'])){
        $this->form_validation->set_rules('roi', 'Rate of Interest', 'required');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['tenor'])){
        $this->form_validation->set_rules('tenor', 'Tenor', 'required');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['financer'])){
        $this->form_validation->set_rules('financer', 'Financer', 'required');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['makeId'])){
        $this->form_validation->set_rules('makeId', 'Make', 'required');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['modelId'])){
        $this->form_validation->set_rules('modelId', 'Model', 'required');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['versionId'])){
        $this->form_validation->set_rules('versionId', 'Version', 'required');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['reg_year']) && ($params['loanFor']=='2')){
        $this->form_validation->set_rules('reg_year', 'Reg Date', 'required');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['regno']) && ($params['loanFor']=='2')){
        $this->form_validation->set_rules('regno', 'Reg Number', 'required');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
//         if((empty($params['engine_number'])) && ($params['loanFor']=='2')){
//        $this->form_validation->set_rules('engine_number', 'Engine Number', 'required|min_length[6]|max_length[17]');
//        if ($this->form_validation->run() == FALSE && validation_errors()) {
//            return array('status'=>'False','message'=>validation_errors());
//        }
//        }else if((!empty($params['engine_number'])) && ($params['loanFor']=='2')){
//        $this->form_validation->set_rules('engine_number', 'Engine Number', 'min_length[6]|max_length[17]');
//        if ($this->form_validation->run() == FALSE && validation_errors()) {
//            return array('status'=>'False','message'=>validation_errors());
//        }
//        }
//        if((empty($params['chassis_number'])) && ($params['loanFor']=='2')){
//        $this->form_validation->set_rules('chassis_number', 'Chassis Number', 'required|min_length[6]|max_length[17]');
//        if ($this->form_validation->run() == FALSE && validation_errors()) {
//            return array('status'=>'False','message'=>validation_errors());
//        }
//        }
//        else if((!empty($params['chassis_number'])) && ($params['loanFor']=='2')){
//        $this->form_validation->set_rules('chassis_number', 'Chassis Number', 'required|min_length[6]|max_length[17]');
//        if ($this->form_validation->run() == FALSE && validation_errors()) {
//            return array('status'=>'False','message'=>validation_errors());
//        }
//        }
       
        $this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        /*if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }*/
    }
    
     public function residentialInfo($id=''){
        $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $casesId  = !empty($editId)? end($editId):'';
       // $customerName          = current($this->Loan_customer_info->getCustomerInfo($customerId));
        $custInfo       = $this->Loan_customer_case->getCaseInfoByCaseId($casesId);
        $customerName  = $custInfo[0];
       
        $data = [];
        $data['pageTitle']      = 'Residential Information';
        $data['pageType']       = 'loan';
        $data['CustomerInfo']   =  !empty($customerName)?$customerName:'';
        if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
        if(!empty($data['CustomerInfo']['loan_amt'])){
             $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
              $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
            //$data['loanamt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
        }
         /*if(!empty($data['CustomerInfo']['loan_approval_status']))
            {
                $tagStatus = $this->Loan_customer_case->getFileTagName($data['CustomerInfo']['loan_approval_status']);
                $data['app_status'] = $tagStatus[0]['file_tag'];
            }*/
        $personalDetail = $this->getCustomerDetails('',$data['CustomerInfo']['customer_id'],'1');
        $data['personelDetail'] = $personalDetail[0];
        $data['customerId']     = !empty($customerId)?$customerId:'';
        $data['stateList']      = $this->state_list->getStateList();
        $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
        $data['cityList']       =  $this->getCityListByStateId($data['CustomerInfo']['residence_state']);
       // $data['CustomerInfo']   = current($this->Loan_customer_info->getCustomerInfoByCustomerId($data['CustomerInfo']['customer_id']));
        $caseId                 = $casesId;
        $data['refrenceData']   = current($this->Loan_customer_reference_info->getRefrenceId($caseId));
        if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
        /*echo "<pre>";
        print_r($data);
        exit; */
        $data['rolemgmt'] = $this->financeUserMgmt('','residentialInfo');
        $this->loadViews("finance/residentialInfo", $data);
    }
    
    function getcities(){
       $stateId   = $this->input->post('stateId');
       $this->db->select('city_id,city_name');
       $this->db->from('city_list');
       $this->db->where('state_id', $stateId);
       $query = $this->db->get();
       $result = $query->result_array();
       $option= "<option value='' >Select City</option>";
       foreach ($result as $cityKey => $cityValue) {
            $option .="<option value='" . $cityValue['city_id'] . "' >" . $cityValue['city_name'] . "</option>";
        }
        echo $option;
    }
    
    public function getCityListByStateId($stateId){
       $this->db->select('city_id,city_name');
       $this->db->from('city_list');
       $this->db->where('state_id', $stateId);
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     

    }
    
    public function addEditResidenceForms($params){
       // $customerInfo             = current($this->Loan_customer_info->getCustomerInfo($params['customerId']));
        $custInfo =   $this->Loan_customer_case->getCaseInfoByCaseId($params['caseId']);
        $customerInfo = $custInfo[0];
        $residenceForm            = $this->renderResidenceForm($params,$customerInfo);
        $validationCheck          = $this->residenceFormValidation($params);
        $action = "0";
        if(!empty($validationCheck)){
         echo json_encode($validationCheck);exit;
        }
        if(!empty($params['customerId']))
        {
            $residenceInfo       = $this->Loan_customer_info->saveUpdateCustomerInfo($residenceForm,$customerInfo['customer_loan_id']);
             $saveUpdateCustomerPersonnelInfo = $this->addUpdateMasterCustomer($residenceForm,$customerInfo['customer_id']);
            if($customerInfo['customer_loan_id']!='')
            {
                $action = '1';
            }
            $case_id =$customerInfo['customer_loan_id'];
            $this->updateLoanStatus($customerInfo['customer_loan_id']);
            //$data['last_updated_date'] = date('Y-m-d H:i:s');
           // $lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($data, $customerInfo['customer_loan_id']);
        }
        if(!empty($residenceInfo)){
            $result= array('status'=>'True','message'=>'Residence Details Added Successfully','Action'=>  base_url().'refrenceDetails/' . base64_encode('CustomerId_' . $params['caseId']));
                $this->addLoanHistoryUpdateLog($case_id,$residenceForm,'Residence Details','',$action);
                $this->addLoanHistory($case_id,'Residence Details Updated','','','Residence Details Updated','0',$this->session->userdata['userinfo']['id']);
        }
        echo json_encode($result);exit;
    }
    
     public function renderResidenceForm($params,$customerInfo){
          $residence                           = [];
        if(isset($params)){
        $residence['residance_type']       = !empty($params['residance_type'])?$params['residance_type']:'';
        $residence['length_of_stay']       = !empty($params['length_of_stay'])?trim($params['length_of_stay']):'';
        $residence['residence_address']    = !empty($params['residence_address'])?ucwords(strtolower(trim($params['residence_address']))):'';
        $residence['residence_state']      = !empty($params['residence_state'])?$params['residence_state']:'';
        $residence['residence_city']       = !empty($params['residence_city'])?$params['residence_city']:'';
        $residence['residence_pincode']    = !empty($params['residence_pincode'])?trim($params['residence_pincode']):'';
        $residence['residence_phone']      = !empty($params['residence_phone'])?trim($params['residence_phone']):'';
        $residence['landmark']      = !empty($params['landmark'])?ucwords(strtolower(trim($params['landmark']))):'';
        if(!empty($params['sameas']))
        {
            $residence['sameas'] = $params['sameas'];
            $residence['corres_add']      = !empty($params['residence_address'])?ucwords(strtolower(trim($params['residence_address']))):'';
            $residence['corres_state']    = !empty($params['residence_state'])?trim($params['residence_state']):'';
            $residence['corres_city']     = !empty($params['residence_city'])?$params['residence_city']:'';
            $residence['corres_pincode']  = !empty($params['residence_pincode'])?trim($params['residence_pincode']):'';
            $residence['corres_phone']    = !empty($params['residence_phone'])?trim($params['residence_phone']):'';
            $residence['cores_landmark']      = !empty($params['landmark'])?ucwords(strtolower(trim($params['landmark']))):'';
           // $residence['updated_date']         = date('Y-m-d H:i:s');
        }
        else
        {
            $residence['sameas'] = '0';
            $residence['corres_add']      = !empty($params['corres_address'])?ucwords(strtolower(trim($params['corres_address']))):'';
            $residence['corres_state']    = !empty($params['corres_state'])?$params['corres_state']:'';
            $residence['corres_city']     = !empty($params['corres_city'])?$params['corres_city']:'';
            $residence['corres_pincode']  = !empty($params['corres_pincode'])?trim($params['corres_pincode']):'';
            $residence['corres_phone']    = !empty($params['corres_phone'])?trim($params['corres_phone']):'';
             $residence['cores_landmark']      = !empty($params['cores_landmark'])?ucwords(strtolower(trim($params['cores_landmark']))):'';
        }
        $residence['updated_date']         = date('Y-m-d H:i:s');
        }
        return $residence;
    }
    
     public function residenceFormValidation($params) {
        $this->form_validation->set_error_delimiters('', '');
        if(empty($params['residance_type'])){
        $this->form_validation->set_rules('residance_type', 'Residance Type', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['length_of_stay'])){
        $this->form_validation->set_rules('length_of_stay', 'Length Of Stay', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['residence_address'])){
        $this->form_validation->set_rules('residence_address', 'Address', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['residence_state'])){
        $this->form_validation->set_rules('residence_state', 'State', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['residence_city'])){
        $this->form_validation->set_rules('residence_city', 'City', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['residence_pincode'])){
        $this->form_validation->set_rules('residence_pincode', 'Pincode', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['residence_phone'])){
        $this->form_validation->set_rules('residence_phone', 'Phone', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(!empty($params['residence_phone'])){
        $this->form_validation->set_rules('residence_phone', 'Phone', 'required|min_length[10]|max_length[10]|regex_match[/^[6-9][0-9]{9}$/]');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(!empty($params['sameas']) && ($params['sameas']!='1'))
        {
            if(empty($params['corres_address'])){
            $this->form_validation->set_rules('corres_address', 'Correspondence Address', 'required');
             if ($this->form_validation->run() == FALSE) {
                return array('status'=>'False','message'=>validation_errors());
            }
            }
            else if(empty($params['corres_state'])){
            $this->form_validation->set_rules('corres_state', 'Correspondence State', 'required');
             if ($this->form_validation->run() == FALSE) {
                return array('status'=>'False','message'=>validation_errors());
            }
            }
            else if(empty($params['corres_city'])){
            $this->form_validation->set_rules('corres_city', 'Correspondence City', 'required');
             if ($this->form_validation->run() == FALSE) {
                return array('status'=>'False','message'=>validation_errors());
            }
            }
            else if(empty($params['corres_pincode'])){
            $this->form_validation->set_rules('corres_pincode', 'Correspondence Pincode', 'required');
             if ($this->form_validation->run() == FALSE) {
                return array('status'=>'False','message'=>validation_errors());
            }
            }
            if(empty($params['corres_phone'])){
            $this->form_validation->set_rules('corres_phone', 'Correspondence Phone', 'required');
             if ($this->form_validation->run() == FALSE) {
                return array('status'=>'False','message'=>validation_errors());
            }
            }
        }
        $this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
    }
    
    public function refrenceDetails($id=''){
        $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $casesId  = !empty($editId)? end($editId):'';
        $custInfo =   $this->Loan_customer_case->getCaseInfoByCaseId($casesId);
        $customerName  = $custInfo[0];
        //$customerName          = current($this->Loan_customer_info->getCustomerInfo($customerId));
        $data = [];
        $data['pageTitle']      = 'Refrence Details';
        $data['pageType']       = 'loan';
        $data['CustomerInfo']   =  !empty($customerName)?$customerName:'';
        $data['customerId']     = !empty($data['CustomerInfo']['customer_id'])?$data['CustomerInfo']['customer_id']:'';
        $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
        if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
         if(!empty($data['CustomerInfo']['loan_amt'])){
             $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
              $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
           // $data['loanamt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
        }
        /* if(!empty($data['CustomerInfo']['loan_approval_status']))
            {
                $tagStatus = $this->Loan_customer_case->getFileTagName($data['CustomerInfo']['loan_approval_status']);
                $data['app_status'] = $tagStatus[0]['file_tag'];
            }*/
        //$data['CustomerInfo']   = current($this->Loan_customer_info->getCustomerInfoByCustomerId($customerId));
        $data['relation']       = ['Friend','Neighbour','Cousin','Uncle','Aunt','Distant Relative','Other'];
        $data['grelation'] = ['Aunt','Cousin','Distant Relative','Director','Father','Friend','Husband','Mother','Neighbour','Partner','Uncle','Other'];
        $caseIdInfo                = current($this->Loan_customer_case->getCaseId($casesId));
        $caseId = $caseIdInfo['customer_loan_id'];
        $data['refrenceData']   = current($this->Loan_customer_reference_info->getRefrenceId($casesId));
        $data['rolemgmt'] = $this->financeUserMgmt('','refrenceDetails');
        if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
        $this->loadViews("finance/refrenceDetails", $data);
    }
    
    public function addEditRefrenceDetails($params){
        $custInfo =   $this->Loan_customer_case->getCaseInfoByCaseId($params['caseId']);
        $customerInfo = $custInfo[0];
        //$customerInfo             = current($this->Loan_customer_info->getCustomerInfo($params['customerId']));
        $caseId                   = current($this->Loan_customer_case->getCaseId($customerInfo['customer_loan_id']));
       // $caseId = $caseIdInfo['customer_loan_id'];
        $refrenceForm             = $this->renderRefrenceForm($params,$caseId);
        $getRefrenceId            = current($this->Loan_customer_reference_info->getRefrenceId($caseId['customer_loan_id']));
        $validationCheck          = $this->refenceFormValidation($params);
        $action = '0';
        if(!empty($validationCheck)){
         echo json_encode($validationCheck);exit;
        }
        if(!empty($params['customerId']))
        {
            $residenceInfo       = $this->Loan_customer_reference_info->addEditRefrenceData($refrenceForm,$getRefrenceId['id']);
            if($getRefrenceId['id']!='')
            {
                $action = '1';
                $this->updateLoanStatus($customerInfo['customer_loan_id']);
            }
            else
            {
                //$this->updateLoanStatus($caseId['customer_loan_id'],'10');
            }
            //$data['last_updated_date'] = date('Y-m-d H:i:s');
            //$lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($data, $customerInfo['customer_loan_id']);
        }
        if(!empty($residenceInfo))
        {
            $result= array('status'=>'True','message'=>'refrence Details Added Successfully','Action'=>  base_url().'bankInfo/' . base64_encode('CustomerId_' . $customerInfo['customer_loan_id']));
                $this->addLoanHistoryUpdateLog($caseId['customer_loan_id'],$refrenceForm,'refrenceDetails','',$action);
                $this->addLoanHistory($caseId['customer_loan_id'],'Reference Details','-','','Reference Details','0',$this->session->userdata['userinfo']['id']);
        }
        echo json_encode($result);exit;
    }
    
     public function renderRefrenceForm($params,$caseId){
        $residence                           = [];
        if(isset($params)){
        $residence['customer_case_id']      = !empty($caseId['customer_loan_id'])?$caseId['customer_loan_id']:'';
        $residence['ref_name_one']          = !empty($params['ref_name_one'])?ucwords(strtolower(trim($params['ref_name_one']))):'';
        $residence['ref_address_one']       = !empty($params['ref_address_one'])?ucwords(strtolower(trim($params['ref_address_one']))):'';
        $residence['ref_phone_one']         = !empty($params['ref_phone_one'])?trim($params['ref_phone_one']):'';
        $residence['ref_relationship_one']  = !empty($params['ref_relationship_one'])?trim($params['ref_relationship_one']):'';
        $residence['ref_name_two']          = !empty($params['ref_name_two'])?ucwords(strtolower(trim($params['ref_name_two']))):'';
        $residence['ref_address_two']       = !empty($params['ref_address_two'])?ucwords(strtolower(trim($params['ref_address_two']))):'';
        $residence['ref_phone_two']         = !empty($params['ref_phone_two'])?trim($params['ref_phone_two']):'';
        $residence['ref_relationship_two']  = !empty($params['ref_relationship_two'])?trim($params['ref_relationship_two']):'';

         $residence['g_name_one']          = !empty($params['g_name_one'])?ucwords(strtolower(trim($params['g_name_one']))):'';
        $residence['g_address_one']       = !empty($params['g_address_one'])?ucwords(strtolower(trim($params['g_address_one']))):'';
        $residence['g_phone_one']         = !empty($params['g_phone_one'])?trim($params['g_phone_one']):'';
        $residence['g_relationship_one']  = !empty($params['g_relationship_one'])?trim($params['g_relationship_one']):'';
        $residence['g_name_two']          = !empty($params['g_name_two'])?ucwords(strtolower(trim($params['g_name_two']))):'';
        $residence['g_address_two']       = !empty($params['g_address_two'])?ucwords(strtolower(trim($params['g_address_two']))):'';
        $residence['g_phone_two']         = !empty($params['g_phone_two'])?trim($params['g_phone_two']):'';
        $residence['g_relationship_two']  = !empty($params['g_relationship_two'])?trim($params['g_relationship_two']):'';

         $residence['co_name_one']          = !empty($params['co_name_one'])?ucwords(strtolower(trim($params['co_name_one']))):'';
        $residence['co_address_one']       = !empty($params['co_address_one'])?ucwords(strtolower(trim($params['co_address_one']))):'';
        $residence['co_phone_one']         = !empty($params['co_phone_one'])?trim($params['co_phone_one']):'';
        $residence['co_relationship_one']  = !empty($params['co_relationship_one'])?trim($params['co_relationship_one']):'';
        $residence['co_name_two']          = !empty($params['co_name_two'])?ucwords(strtolower(trim($params['co_name_two']))):'';
        $residence['co_address_two']       = !empty($params['co_address_two'])?ucwords(strtolower(trim($params['co_address_two']))):'';
        $residence['co_phone_two']         = !empty($params['co_phone_two'])?trim($params['co_phone_two']):'';
        $residence['co_relationship_two']  = !empty($params['co_relationship_two'])?trim($params['co_relationship_two']):'';

        $residence['created_date']          = date('Y-m-d H:i:s');
        
        }
        return $residence;
    }
    
     public function refenceFormValidation($params) {
        $this->form_validation->set_error_delimiters('', '');
        if(empty($params['ref_name_one'])){
        $this->form_validation->set_rules('ref_name_one', 'Reference Name 1', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['ref_address_one'])){
        $this->form_validation->set_rules('ref_address_one', 'Reference Address 1', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['ref_phone_one'])){
        $this->form_validation->set_rules('ref_phone_one', 'Reference Phone 1','required|min_length[10]|max_length[10]|regex_match[/^[6-9][0-9]{9}$/]', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(!empty($params['ref_phone_one'])){
        $this->form_validation->set_rules('ref_phone_one', 'Reference Phone 1','required|min_length[10]|max_length[10]|regex_match[/^[6-9][0-9]{9}$/]', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['ref_relationship_one'])){
        $this->form_validation->set_rules('ref_relationship_one', 'Reference Relation 1', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['ref_name_two'])){
        $this->form_validation->set_rules('ref_name_two', 'Reference Name 2', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['ref_address_two'])){
        $this->form_validation->set_rules('residence_city', 'Reference Address 2', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['ref_phone_two'])){
        $this->form_validation->set_rules('ref_phone_two', 'Reference Phone 2', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(!empty($params['ref_phone_two'])){
        $this->form_validation->set_rules('ref_phone_two', 'Reference Phone 2', 'required|min_length[10]|max_length[10]|regex_match[/^[6-9][0-9]{9}$/]', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['ref_relationship_two'])){
        $this->form_validation->set_rules('ref_relationship_two', 'Reference Relation 2', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        $this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
    }

    public function bankInfo($customer_id)
    {
        $editId      = !empty($customer_id)? explode('_',base64_decode($customer_id)):'';
        $casesId     = !empty($editId)?end($editId):'';
        $data        = [];
        $bnkId       = '';
        $data['pageTitle']      = 'Customer Banking Information';
        $data['pageType']       = 'loan';
        $custInfo =   $this->Loan_customer_case->getCaseInfoByCaseId($casesId);
        $customerName  = $custInfo[0];
        $data['CustomerInfo']   =  !empty($customerName)?$customerName:'';
        $data['customerId']     = !empty($data['CustomerInfo']['customer_id'])?$data['CustomerInfo']['customer_id']:'';
        $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
        if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
         if(!empty($data['CustomerInfo']['loan_amt'])){
             $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
              $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
            //$data['loanamt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
        }
        $caseIdInfo                = current($this->Loan_customer_case->getCaseId($casesId));
        $caseId = $caseIdInfo['customer_loan_id'];
        $data['refrenceData']   = current($this->Loan_customer_reference_info->getRefrenceId($casesId));
       // $data['bankname']     = $this->Crm_banks->getBanklist();
        $data['bankname']=$this->getcustomerBankList();
        $data['rolemgmt'] = $this->financeUserMgmt('','bankInfo');
         if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
        $this->loadViews("finance/bankInfo", $data);
    }
    public function renderBankInfoForm($params)
    {
        $bnkInfor                           = [];
        if(isset($params)){
        $bnkInfor['case_id']      = !empty($params['caseId'])?$params['caseId']:'';
        $bnkInfor['bank_id']          = !empty($params['bank_name'])?trim($params['bank_name']):'';
        $bnkInfor['bank_branch']       = !empty($params['bank_branch'])?ucwords(strtolower(trim($params['bank_branch']))):'';
        $bnkInfor['account_no']         = !empty($params['account_no'])?trim($params['account_no']):'';
        $bnkInfor['ifci_code']  = !empty($params['ifsc_code'])?trim($params['ifsc_code']):'';
        $bnkInfor['account_type']          = !empty($params['account_type'])?$params['account_type']:'';

        $bnkInfor['bank_id_two']          = !empty($params['bank_name_two'])?trim($params['bank_name_two']):'';
        $bnkInfor['bank_branch_two']       = !empty($params['bank_branch_two'])?ucwords(strtolower(trim($params['bank_branch_two']))):'';
        $bnkInfor['account_no_two']         = !empty($params['account_no_two'])?trim($params['account_no_two']):'';
        $bnkInfor['ifci_code_two']  = !empty($params['ifsc_code_two'])?trim($params['ifsc_code_two']):'';
        $bnkInfor['account_type_two']          = !empty($params['account_type_two'])?$params['account_type_two']:'';
        if($params['cust_bnk_id']==''){
            $bnkInfor['created_date']          = date('Y-m-d H:i:s');
        }
        
        }
        return $bnkInfor;
    }
    public function addEditBankInfo($params){
        $custInfo =   $this->Loan_customer_case->getCaseInfoByCaseId($params['caseId']);
        $customerInfo = $custInfo[0];
        $caseIdInfo                   = current($this->Loan_customer_case->getCaseId($customerInfo['customer_loan_id']));
        $caseId = $caseIdInfo['customer_loan_id'];
        $bnkForm                  = $this->renderBankInfoForm($params,$caseId);
       // if(($params['is_coapplicant']!='1') && ($params['is_guaranter']!='1')) {
        if(!empty($params['cust_bnk_id']))
        { 
           $upId = $params['cust_bnk_id'];
           $action='1';
        }
        else
        {
            $upId = '';
            $action = '0';
        }
   // }
        $cuBnkInfo       = $this->Loan_customer_info->saveCustomerBankInfo($bnkForm,$upId);
        if(!empty($cuBnkInfo ))
        {
            if(($params['is_coapplicant']!='1') && ($params['is_guaranter']!='1')) {
              $result= array('status'=>'True','message'=>'Bank Details Added Successfully','Action'=>  base_url().'uploadDocs/' . base64_encode('CustomerId_' . $customerInfo['customer_loan_id']));
              if($action=='0')
                {
                     $this->updateLoanStatus($params['caseId'],'10');
                }
                if($action=='1')
                {
                     $this->updateLoanStatus($params['caseId']);
                }
              }
              else if($params['is_coapplicant']=='1')
              {
                    $result= array('status'=>'True','message'=>'Bank Details Added Successfully','Action'=>  base_url().'coapplicantDetail/' . base64_encode('CustomerId_' . $customerInfo['customer_loan_id']));
              }
              else if(($params['is_coapplicant']!='1') && ($params['is_guaranter']=='1'))
              {
                    $result= array('status'=>'True','message'=>'Bank Details Added Successfully','Action'=>  base_url().'guarantorDetail/' . base64_encode('CustomerId_' . $customerInfo['customer_loan_id']));
              }
                $this->addLoanHistoryUpdateLog($caseId['customer_loan_id'],$bnkForm,'Bank Information','',$action);
                
               // $this->addLoanHistory($caseId['customer_loan_id'],'Reference Details','-','','Reference Details','0',$this->session->userdata['userinfo']['id']);
        }
        echo json_encode($result);exit;
    }
    

    public function loanFileLogin($customer_id)
    {
        $editId      = !empty($customer_id)? explode('_',base64_decode($customer_id)):'';
        $casesId  = !empty($editId)?end($editId):'';
        $data = [];
        $bnkId = '';
        $data['pageTitle']      = 'Loan File Login';
        $data['pageType']       = 'loan';
        $data['customerDetail'] =  $this->Loan_customer_case->getCaseInfoByCaseId($casesId);
        $data['loanDetail']     =  $this->Loan_customer_case->getLoanInfoByCustomerId($data['customerDetail'][0]['customer_loan_id']);
        $data['loanCount']  =  count($data['loanDetail']); 
        //echo count($data['loanDetail']); exit;
        $data['case_id']        = $casesId;
        if(!empty($casesId))
        {
            $cust_detail = $this->Loan_customer_case->getCaseInfoByCaseId($casesId);
            $data['CustomerInfo']       =  $cust_detail[0];
            if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
             if(!empty($data['CustomerInfo']['loan_amt'])){
             $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
              $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
        }
              $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
        }
        
        foreach ($data['loanDetail'] as $key => $value) 
        {
           
            $bnkId        .= $value['bank_id'].',';
            $bankk         = $this->Crm_banks->getBankNameBybnkId($value['bank_id']);
            $data['loanDetail'][$key]['bank_name']      =  $bankk['bank_name'];  
            if($value['tag_flag']=='4')
            {
                $data['disbural'] = '1';
            } 
            $data['loanDetail'][$key]['emi']      = $this->calculateEmi($value['file_loan_amount'],$value['file_tenure'],$value['file_roi']); 
             $data['loanDetail'][$key]['emi'] = $this->IND_money_format($data['loanDetail'][$key]['emi']);
             $data['loanDetail'][$key]['file_loan_amount'] = $this->IND_money_format($value['file_loan_amount']);
        }

        $data['bank_id']        = trim($bnkId,',');
        //$data['emi']            = $this->calculateEmi($data['loanDetail'][0]['file_loan_amount'],$data['loanDetail'][0]['file_tenure'],$data['loanDetail'][0]['file_roi']);
        if($data['CustomerInfo']['meet_the_customer']=='1')
        {
            $bankList          = $this->Crm_banks->getAllBankId();
        }else{
            $bankList = $this->Crm_banks->getEmpBankInfo($data['CustomerInfo']['meet_the_customer']);
        }
        $data['bank_list_count'] =  count($bankList);
        $data['rolemgmt'] = $this->financeUserMgmt('','loanFileLogin');
         if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
       
        $this->loadViews("finance/loanFileLogin", $data);
    }
    
    public function postDeliveryDetails($customer_id){
        $editId      = !empty($customer_id)? explode('_',base64_decode($customer_id)):'';
        $casesId  = !empty($editId)?end($editId):'';
        //echo $customerId; exit;
        $data = [];
        $custInfo       = $this->Loan_customer_case->getCaseInfoByCaseId($casesId);
        $data['CustomerInfo']  = $custInfo[0];
        //$data['CustomerInfo']  = current($this->Loan_customer_info->getCustomerInfoByCustomerId($customerId));
        //$caseId  = current($this->Loan_customer_info->getCaseInfoByCustomerId($customerId));
        $data['postInfo']  = current($this->Loan_post_delivery_info->getPostDetails($data['CustomerInfo']['customer_loan_id']));
        $data['insurerList']=$this->Crm_insurance_company->getInsurer();
        $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
        if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
        if(!empty($data['CustomerInfo']['loan_amt'])){
             $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
             $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
           // $data['loanamt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
        }
        /* if(!empty($data['CustomerInfo']['loan_approval_status']))
            {
                $tagStatus = $this->Loan_customer_case->getFileTagName($data['CustomerInfo']['loan_approval_status']);
                $data['app_status'] = $tagStatus[0]['file_tag'];
            }*/
            $data['showroomList']     =  $this->Crm_dealers->getDealers('','1','1');
            $data['employeeList']   =  $this->Crm_user->getEmployee('1');
            $data['allemployeeList']   =  $this->Crm_user->getEmployee('2');
        $data['pageTitle']      = 'Loan Invoice';
        $data['pageType']       = 'loan';
        $data['rolemgmt'] = $this->financeUserMgmt('','postDeliveryDetails');
        if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
        $this->loadViews("finance/loanPostDelivery", $data);
    }
    
    public function addEditLoanPostDetails($params){
        $customerInfos          = $this->Loan_customer_info->getCustomerInfoByCaseID($params['case_id']);
        $customerInfo           = $customerInfos[0];
        $validationCheck=$this->postDeliveryFormValidation($params);
        if(!empty($validationCheck)){
         echo json_encode($validationCheck);exit;
        }
        if(!empty($params['customerId']))
        {
            $caseId                   = current($this->Loan_customer_case->getCaseId($customerInfo['customer_loan_id']));  
        
            $renderPostDeliveryForm=$this->renderPostForm($params,$caseId);
            if(!empty($caseId))
            {
                $existcaseId  = current($this->Loan_post_delivery_info->getCaseIdFromPost($caseId['customer_loan_id']));
                if(empty($existcaseId))
                {                    
                    $postInfo       = $this->Loan_post_delivery_info->addEditPostDeliveryData($renderPostDeliveryForm);
                    $action = '0';
                    $ac ='Add';
                }
                else
                {                   
                    $postInfo       = $this->Loan_post_delivery_info->addEditPostDeliveryData($renderPostDeliveryForm,$caseId['customer_loan_id']);   
                    $action = '1';
                    $ac ='Update';
                    $this->updateLoanStatus($customerInfo['customer_loan_id']);
                }
                $this->addLoanHistoryUpdateLog( $customerInfo['id'],$renderPostDeliveryForm,'Post Delivery Details','',$action);
                $this->addLoanHistory($customerInfo['id'],'Post Delivery Details','-','','Post Delivery Details','',$this->session->userdata['userinfo']['id'],$ac);
            }
            if(!empty($postInfo))
            {
                if($customerInfo['loan_for']=='1')
            {
              $result= array('status'=>'True','message'=>'Post Delivery Details Added Successfully','Action'=>  base_url().'uploadDocs/' . base64_encode('CustomerId_' . $caseId['customer_loan_id']).'/post');
            }
            else{
             
            if(($this->session->userdata['userinfo']['is_admin'] == 1)  || ($this->session->userdata['userinfo']['team_name'] == "Loan" && $this->session->userdata['userinfo']['role_name'] == "Accountant"))
               $action = base_url().'loanpayment/'.base64_encode('CustomerId_' . $caseId['customer_loan_id']);
            else
                 $action = base_url().'loanListing/';
                
               $result= array('status'=>'True','message'=>'Post Delivery Details Added Successfully','Action'=>  $action);
            }
                 //$result= array('status'=>'True','message'=>'Payment Delivery Details Added Successfully','Action'=>  base_url().'uploadDocs/' . base64_encode('CustomerId_' . $caseId['customer_loan_id']).'/post');
               // $result= array('status'=>'True','message'=>'Post Delivery Details Added Successfully','Action'=>  base_url().'paymentDetails/' . base64_encode('CustomerId_' . $caseId['customer_loan_id']));
            }
            echo json_encode($result);exit;
        }
    }
    
    public function postDeliveryFormValidation($params) {
        //echo '<pre>';print_r($params['loan_for']);die;
        $this->form_validation->set_error_delimiters('', '');
        if(empty($params['invoice_no']) && ($params['loan_for']=='1')){
        $this->form_validation->set_rules('invoice_no', 'Invoice No', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['invoice_date'])  && ($params['loan_for']=='1')){
        $this->form_validation->set_rules('invoice_date', 'Invoice Date', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['invoice_received_as'])  && ($params['loan_for']=='1')){
        $this->form_validation->set_rules('invoice_received_as', 'Received As','required', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(!empty($params['invoice_received_on'])  && ($params['loan_for']=='1')){
        $this->form_validation->set_rules('invoice_received_on', 'Received On','required', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['rc_regNo']) && ($params['loan_for']=='2')){
        $this->form_validation->set_rules('rc_regNo', 'Registration No', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['rc_chassis_no'])){
        $this->form_validation->set_rules('rc_chassis_no', 'Chassis No', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['rc_engine_no'])){
        $this->form_validation->set_rules('rc_engine_no', 'Engine No', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['rc_regDate']) && ($params['loan_for']=='2')){
        $this->form_validation->set_rules('rc_regDate', 'Registration Date', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(!empty($params['rc_lein_mark'])){
        $this->form_validation->set_rules('rc_lein_mark', 'Leain Mark', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['rc_received_as'])  && ($params['loan_for']=='1')){
        $this->form_validation->set_rules('rc_received_as', 'Received As', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['rc_registration_from'])  && ($params['loan_for']=='1')){
        $this->form_validation->set_rules('rc_registration_from', 'Registration From', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['rc_received_on'])  && ($params['loan_for']=='1')){
        $this->form_validation->set_rules('rc_received_on', 'Received On', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty(trim($params['insurance_company']))){
        $this->form_validation->set_rules('insurance_company', 'Insurance Company', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        /*else if(empty($params['insurance_by'])){
        $this->form_validation->set_rules('insurance_by', 'Insurance By', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/
        else if(empty($params['icn_no'])){
        $this->form_validation->set_rules('icn_no', 'ICN No', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['insurance_expiry'])){
        $this->form_validation->set_rules('insurance_expiry', 'Insurance Expiry', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['delivery_date']) && ($params['loan_for']=='1')){
        $this->form_validation->set_rules('delivery_date', 'Delivery date', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        /*else if(empty($params['filling_no'])){
        $this->form_validation->set_rules('filling_no', 'Filling No', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/
        $this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
    }
    
    public function renderPostForm($params,$caseId){
        $postDelivery                           = [];
        if(isset($params)){
        $postDelivery['case_id']      = !empty($caseId['customer_loan_id'])?$caseId['customer_loan_id']:'';
        $postDelivery['invoice_no']          = !empty($params['invoice_no'])?$params['invoice_no']:'';
        $postDelivery['invoice_date']       = !empty($params['invoice_date'])?date('Y-m-d',strtotime($params['invoice_date'])):'';
        $postDelivery['invoice_received_as']         = !empty($params['invoice_received_as'])?$params['invoice_received_as']:'';
        $postDelivery['invoice_received_from']  = !empty($params['invoice_received_from'])?ucwords(strtolower($params['invoice_received_from'])):'';
        $postDelivery['invoice_received_on']          = !empty($params['invoice_received_on'])?date('Y-m-d',strtotime($params['invoice_received_on'])):'';
        $postDelivery['rc_regNo']       = !empty($params['rc_regNo'])?$params['rc_regNo']:'';
        $postDelivery['rc_chassis_no']         = !empty($params['rc_chassis_no'])?$params['rc_chassis_no']:'';
        $postDelivery['rc_engine_no']  = !empty($params['rc_engine_no'])?$params['rc_engine_no']:'';
        $postDelivery['rc_thirdex']  = !empty($params['rc_thirdex'])?date('Y-m-d',strtotime($params['rc_thirdex'])):'';
         $postDelivery['rc_reg_date']  = !empty($params['rc_regDate'])?date('Y-m-d',strtotime($params['rc_regDate'])):'';
        $postDelivery['rc_lein_mark']  = !empty($params['rc_lein_mark'])?$params['rc_lein_mark']:'';
        $postDelivery['rc_received_as']  = !empty($params['rc_received_as'])?$params['rc_received_as']:'';
        $postDelivery['rc_registration_from']  = !empty($params['rc_registration_from'])?ucwords(strtolower($params['rc_registration_from'])):'';
        $postDelivery['rc_received_on']  = !empty($params['rc_received_on'])?date('Y-m-d',strtotime($params['rc_received_on'])):'';
        $postDelivery['insurance_company']  = !empty($params['insurance_company'])?$params['insurance_company']:'';
        $postDelivery['insurance_by']  = !empty($params['insurance_by'])?$params['insurance_by']:'';
        $postDelivery['icn_no']  = !empty($params['icn_no'])?$params['icn_no']:'';
        $postDelivery['insurance_expiry']  = !empty($params['insurance_expiry'])?date('Y-m-d',strtotime($params['insurance_expiry'])):'';
        $postDelivery['delivery_date']  = !empty($params['delivery_date'])?date('Y-m-d',strtotime($params['delivery_date'])):'';
        $postDelivery['filling_no']  = !empty($params['filling_no'])?$params['filling_no']:'';
        $postDelivery['file_by']  = !empty($params['file_by'])?$params['file_by']:'';
        $postDelivery['service_received_as']  = !empty($params['service_received_as'])?$params['service_received_as']:'';
        $postDelivery['service_received_from']  = !empty($params['service_received_from'])?$params['service_received_from']:'';
        $postDelivery['service_received_on']  = !empty($params['service_received_on'])?date('Y-m-d',strtotime($params['service_received_on'])):'';
        $postDelivery['noplate_received_as']  = !empty($params['noplate_received_as'])?$params['noplate_received_as']:'';
        $postDelivery['noplate_received_from']  = !empty($params['noplate_received_from'])?$params['noplate_received_from']:'';
        $postDelivery['noplate_received_on']  = !empty($params['noplate_received_on'])?date('Y-m-d',strtotime($params['noplate_received_on'])):'';


 $postDelivery['showroomAddress']  = !empty($params['showroom_address'])?$params['showroom_address']:'';
  $postDelivery['showroomName']  = !empty($params['showroomName'])?$params['showroomName']:'';

        $postDelivery['created_date']          = date('Y-m-d H:i:s');
        $postDelivery['status']          = '1';
        
        }
        return $postDelivery;
    }
    
    public function paymentDetails($customer_id){
        $editId      = !empty($customer_id)? explode('_',base64_decode($customer_id)):'';
        $caserId  = !empty($editId)?end($editId):'';
        //echo $customerId; exit;
        $data = [];
        $data['banklist']=$this->getcustomerBankList();
        //$data['banklist']=$this->Crm_banks->getBanklist();
        $custInfo       = $this->Loan_customer_case->getCaseInfoByCaseId($caserId);        
        $data['CustomerInfo']  = $custInfo[0];
        //$data['CustomerInfo']  = current($this->Loan_customer_info->getCustomerInfoByCustomerId($customerId));
         $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
        $caseId  = $caserId; //current($this->Loan_customer_info->getCaseInfoByCustomerId($customerId));
        $data['postInfo']  = $this->Loan_payment_info->getPaymentDetails($data['CustomerInfo']['customer_loan_id']);
        $data['pageTitle']      = 'Loan Payment';
        $data['pageType']       = 'loan';
        if(!empty($data['postInfo']))
        {
             foreach ($data['postInfo'] as $key => $value) {
                $data['postInfo'][$key]['amount'] = $this->IND_money_format($data['postInfo'][$key]['amount']);
            }
            //$data['postInfo']['amount'] = $this->IND_money_format($data['postInfo']['amount']);
        }
        if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
        if(!empty($data['CustomerInfo']['loan_amt'])){
             $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
              $data['CustomerInfo']['disburse_emi'] = $this->IND_money_format($data['CustomerInfo']['disburse_emi']);
              $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
           // $data['loanamt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
        }
        $data['rolemgmt'] = $this->financeUserMgmt('','paymentDetails');
         if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
      //  echo "";
        $this->loadViews("finance/part_make_payment", $data);
    }
    
    public function addEditLoanPaymentDetails($params,$flag=''){
      //  echo $flag; exit;
        if(empty($flag)){
        $params['amount'] = str_replace(',','',$params['amount']);
        $customerInfos         = $this->Loan_customer_info->getCustomerInfoByCaseID($params['case_id']);
        $customerInfo =  $customerInfos[0];
        $validationCheck=$this->postPaymentFormValidation($params);
        if(!empty($validationCheck)){
         echo json_encode($validationCheck);exit;
        }
        if(!empty($params['customerId'])){
//        echo '<pre>';print_r($getRefrenceId);die;
            $caseId                   = current($this->Loan_customer_case->getCaseId($customerInfo['customer_loan_id']));
            
            $renderPaymentForm=$this->renderPaymentForm($params,$caseId);
            if(!empty($caseId)){
                 $payInfo       = $this->Loan_payment_info->addEditPaymentData($renderPaymentForm,$params['edit_id']);
                $existcaseId  = $this->Loan_payment_info->getCaseIdFromPayment($caseId['customer_loan_id']);
                if((empty($params['edit_id'])) && (!empty($existcaseId))){
                  
                    $action = '1';  
                    $ac ='Update';
                }else if((empty($params['edit_id'])) && (empty($existcaseId)))
                {
                   // $payInfo       = $this->Loan_payment_info->addEditPaymentData($renderPaymentForm);
                    $action = '0';
                    $ac ='Add';
                }
                else{
                
                $action = '1';  
                $ac ='Update';
                $this->updateLoanStatus($caseId['customer_loan_id']);
            }
            //$data['last_updated_date'] = date('Y-m-d H:i:s');
            //$lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($data, $params['case_id']);
            $this->addLoanHistoryUpdateLog($customerInfo['id'],$renderPaymentForm,'Payment Details','',$action);
            $this->addLoanHistory($customerInfo['id'],'Payment Details','-','','Payment Details','',$this->session->userdata['userinfo']['id'],$ac);
        }
        if(!empty($payInfo))
        {
            
            $result= array('status'=>'True','message'=>'Payment Details Added Successfully','Action'=>  base_url().'paymentDetails/' . base64_encode('CustomerId_' . $caseId['customer_loan_id']));
            
        }
    }
}
    else{
            $result= array('status'=>'True','message'=>'Payment Details Added Successfully','Action'=>  base_url().'postDeliveryDetails/' . base64_encode('CustomerId_' . $params['case_id']));
            
        }
       
        
        echo json_encode($result);exit;
        
    }
    
    public function postPaymentFormValidation($params) {
        //echo '<pre>';print_r($params);die;
        $this->form_validation->set_error_delimiters('', '');
        if(empty($params['instrument_type'])){
        $this->form_validation->set_rules('instrument_type', 'Instrument Type', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        /*else if(empty($params['instrument_no'])){
        $this->form_validation->set_rules('instrument_no', 'Instrument No', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/
        if(!empty($params['instrument_type']) && (($params['instrument_type']=='1') || ($params['instrument_type']=='2') || ($params['instrument_type']=='3')) ){
        if(empty($params['drawn_bank'])){
        $this->form_validation->set_rules('drawn_bank', 'Drawn Bank','required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(!empty($params['account_no'])){
        $this->form_validation->set_rules('account_no', 'Account','required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['instrument_date'])){
        $this->form_validation->set_rules('instrument_date', 'Instrument Date', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['amount'])){
        $this->form_validation->set_rules('amount', 'Amount', 'required|min_length[8]|max_length[8]');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['favouring'])){
        $this->form_validation->set_rules('favouring', 'Favouring', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(empty($params['signed_by'])){
        $this->form_validation->set_rules('signed_by', 'Signed By', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(trim($params['instrument_type'])=='1'){
            if(empty(trim($params['cheque_from']))){
            $this->form_validation->set_rules('cheque_from', 'Cheque From', 'trim|required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }
            if($params['entry']=='batch'){
            if(empty(trim($params['cheque_to']))){
            $this->form_validation->set_rules('cheque_to', 'Cheque To', 'trim|required');
             if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }
            }
        }
    }
        
        $this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
           
    }
    
    public function renderPaymentForm($params,$caseId){
        $payment                           = [];
        if(isset($params)){
        $payment['case_id']             = !empty($caseId['customer_loan_id'])?$caseId['customer_loan_id']:'';
        $payment['instrument_type']     = !empty($params['instrument_type'])?$params['instrument_type']:'';
        $payment['signed_by_opt']     = !empty($params['signed_by_opt'])?$params['signed_by_opt']:'';
        $payment['instrument_no']       = !empty($params['instrument_no'])?$params['instrument_no']:'';
        if($params['instrument_type']=='1'){
            $payment['cheque_from']     = !empty($params['cheque_from'])?$params['cheque_from']:'';
            $payment['cheque_to']       = !empty($params['cheque_to'])?$params['cheque_to']:'';
        }
        $payment['drawn_bank']          = !empty($params['drawn_bank'])?$params['drawn_bank']:'';
        $payment['account_no']          = !empty($params['account_no'])?$params['account_no']:'';
        $payment['instrument_date']     = !empty($params['instrument_date'])?date('Y-m-d',strtotime($params['instrument_date'])):'';
        $payment['amount']              = !empty($params['amount'])?$params['amount']:'';
        $payment['favouring']           = !empty($params['favouring'])?$params['favouring']:'';
        $payment['signed_by']           = !empty($params['signed_by'])?ucwords(strtolower($params['signed_by'])):'';
        $payment['entry']               = !empty($params['entry'])?$params['entry']:'';
        $payment['created_on']          = date('Y-m-d H:i:s');
        $payment['status']              = '1';
        
        }
        return $payment;
    }
      function no_to_words($no)
{
    $finalval='';
    if($no == 0) {
        return ' ';

    }else {
        $n =  strlen($no); // 7
        switch ($n) {
            case 3:
                $val = $no/100;
                $val = round($val, 2);
                $finalval =  $val ."-hundred";
                break;
            case 4:
                $val = $no/1000;
                $val = round($val, 2);
                $finalval =  $val ."-thousand";
                break;
            case 5:
                $val = $no/1000;
                $val = round($val, 2);
                $finalval =  $val ."-thousand";
                break;
            case 6:
                $val = $no/100000;
                $val = round($val, 2);
                $finalval =  $val ."-lakh";
                break;
            case 7:
                $val = $no/100000;
                $val = round($val, 2);
                $finalval =  $val ."-lakh";
                break;
            case 8:
                $val = $no/10000000;
                $val = round($val, 2);
                $finalval =  $val ."-cr.";
                break;
            case 9:
                $val = $no/10000000;
                $val = round($val, 2);
                $finalval =  $val ."-cr.";
                break;

            default:
                echo "";
        }
        return $finalval;

    }
}
    public function dashboardDetails(){
        $data['rolemgmt'] = $this->financeUserMgmt();
        if($this->session->userdata['userinfo']['is_admin']=='1')
        {
           // echo "fff"; exit;
            $bank = [];
            $i=0;
            $data['loanCount']=current($this->Loan_customer_info->getLoanDashboard());
            $totalBanks=$this->Loan_customer_info->getTotalBankLimit();
            foreach ($totalBanks as $key => $value) {
                $bank[$i]['bank_name']=$value['bank_name'];
                $bank[$i]['amount_limit']=$value['amount_limit'];
                $bank[$i]['bank_id']=$value['bank_id'];
                $bank[$i]['usedAmount']=$this->Loan_customer_info->getUsedAmount($value['bank_id']);
                $bank[$i]['leftAmount'] = (int)$bank[$i]['amount_limit'] - (int)(!empty($bank[$i]['usedAmount'])?$bank[$i]['usedAmount']:0);
                $bank[$i]['leftAmountRound'] = $this->no_to_words($bank[$i]['leftAmount']);
                $i++;
            }
        $data['bank'] = $bank;
        $data['insuranceCount']=current($this->Loan_customer_info->getInsuranceDashboard());
        $data['insuranceCount']['pendingRenew']=$this->Loan_customer_info->getInsurn();
        $data['dcCount']=current($this->Loan_customer_info->getDcDashboard());
        $data['rcCount']=current($this->Loan_customer_info->getRcDashboard());
        $allStatus = [];
        $dealerId=DEALER_ID;
        $request['ucdid'] = $dealerId;
        $totsearchText['tab_value']='';
        $search45Text['invdashId']='2';
        $invdashId='2';
        $data['stockCount']=count($this->crm_stocks->getInventoryListing($dealerId, $allStatus, $totsearchText, true));
        $data['stock45Count']=count($this->crm_stocks->getInventoryListing($dealerId, $allStatus, $search45Text, true));
        $leadpost['ucdid']=DEALER_ID;
        $data['leadCount']=current($this->Leadmodel->getdashboardLeads($leadpost));
        $totalNewLeadCount=$this->Leadmodel->getcurrentmonthlead();
        $data['totlead']=($totalNewLeadCount > 0) ? $totalNewLeadCount : 0;
      // $data['leadPending']=$this->Leadmodel->getLeadsPending($leadpost);
        $leadPending = $this->Leadmodel->todayLeadTabcount($request); 
            $data['leadPending']=$leadPending['alllead']; 
        }
        else
        {
            $employeeId= $this->session->userdata['userinfo']['id'];
            $role_id = $this->session->userdata['userinfo']['role_id'];
            
            if(isset($data['rolemgmt'][0]['role_name']) && (($data['rolemgmt'][0]['role_name']=='Used Car') || ($data['rolemgmt'][0]['role_name']=='New Car') || ($data['rolemgmt'][0]['role_name']=='Refinance')))
            {
                
                $data['loanCount']=current($this->Loan_customer_info->getLoanDashboard($employeeId));

            }
            else if(isset($data['rolemgmt'][0]['role_name']) && (($data['rolemgmt'][0]['role_name']=='Loan Admin') || ($data['rolemgmt'][0]['role_name']=='Accountant')))
          
            {
                $data['loanCount']=current($this->Loan_customer_info->getLoanDashboard());
            }
            $bank = [];
            $i=0;
            if((!empty($data['rolemgmt'][0]['team_name'])) && (($data['rolemgmt'][0]['team_name']=='Sales') && ($data['rolemgmt'][0]['role_name']=='Executive')))
            {
                
                $totalBanks=$this->Loan_customer_info->getTotalBankLimit($employeeId);
                $emp_id = $employeeId;
            }
            else
            {
                $totalBanks=$this->Loan_customer_info->getTotalBankLimit();
                $emp_id = '';
            }
            foreach ($totalBanks as $key => $value) {
                $bank[$i]['bank_name']=$value['bank_name'];
                $bank[$i]['amount_limit']=$value['amount_limit'];
                $bank[$i]['bank_id']=$value['bank_id'];
                $bank[$i]['usedAmount']=$this->Loan_customer_info->getUsedAmount($value['bank_id'],$emp_id);
                $bank[$i]['leftAmount'] = (int)$bank[$i]['amount_limit'] - (int)(!empty($bank[$i]['usedAmount'])?$bank[$i]['usedAmount']:0);
                $bank[$i]['leftAmountRound'] = $this->no_to_words($bank[$i]['leftAmount']);
                $i++;
            }
            $data['bank'] = $bank;
            //$data['insuranceCount']=current($this->Loan_customer_info->getInsuranceDashboard());
            $data['rcCount']=current($this->Loan_customer_info->getRcDashboard());
            $data['insuranceCount']=current($this->Loan_customer_info->getInsuranceDashboard($employeeId));
            if($role_id == 2){
            $data['insuranceCount']=current($this->Loan_customer_info->getInsuranceDashboard());           
            $data['insuranceCount']['pendingRenew']=$this->Loan_customer_info->getInsurn();    
        }else{
         $data['insuranceCount']['pendingRenew']=$this->Loan_customer_info->getInsurn($employeeId);   
        }
            $allStatus = [];
            $dealerId=DEALER_ID;
            $request['ucdid'] = $dealerId;
            $totsearchText['tab_value']='';
            $search45Text['invdashId']='2';
            $invdashId='2';
            $data['stockCount']=count($this->crm_stocks->getInventoryListing($dealerId, $allStatus, $totsearchText, true));
            $data['stock45Count']=count($this->crm_stocks->getInventoryListing($dealerId, $allStatus, $search45Text, true));
            $leadpost['ucdid']=DEALER_ID;
            $data['leadCount']=current($this->Leadmodel->getdashboardLeads($leadpost));
             $data['dcCount']=current($this->Loan_customer_info->getDcDashboard());
            $totalNewLeadCount=$this->Leadmodel->getcurrentmonthlead($employeeId);

            $data['totlead']=($totalNewLeadCount > 0) ? $totalNewLeadCount : 0;
           // $data['leadPending']=$this->Leadmodel->getLeadsPending($leadpost);
            $leadPending = $this->Leadmodel->todayLeadTabcount($request); 
            $data['leadPending']=$leadPending['alllead']; 
        }
        
        $data['pageTitle']      = 'Dashboard';
        $data['pageType']       = 'dashboard';   
        $this->loadViews("finance/dashboard", $data); 
    }

        
    public function calculateEmi($lamount,$tenor,$rate,$type='0')
    {
        //$rate = (floatval)$rate;
        $mic = ($rate/100) /12; // Monthly interest
        $fv = 0;
        if ($mic === 0)
        return -($lamount + $fv)/$tenor;

        $pvif = pow(1 + $mic, $tenor);
        $pmt = (-$mic * $lamount * ($pvif + fv) / ($pvif - 1));

        if ($type === 1)
            $pmt /= (1 + $mic);

        return abs(round($pmt));
      /*  $top = pow((1+$mic),$tenor);
        $bottom = $top - 1;
        $sp = $top / $bottom;
        $emi = (($lamount * $mic) * $sp);
        return round($emi);*/
    }
    
    public function getBankList()
    {
        $id=$this->input->post('bank_id');
        $case_id=$this->input->post('case_id');
        $type=$this->input->post('type');
        if($type=='loan')
        {
            $tag_id=$this->input->post('tag_id');
            $customer_id=$this->input->post('customer_id');
            $tag_list = $this->Crm_upload_docs_list->getImageList($customer_id,'',$tag_id);
            $image_list = $this->Crm_upload_docs_list->getImageList($customer_id);
            $emp_id =  $this->Loan_customer_case->getCaseInfoByCaseId($case_id);
            if($emp_id[0]['loan_for']=='2'){
                if($emp_id[0]['meet_the_customer']>'1'){
                    $bankList = $this->Crm_banks->getEmpBankName($emp_id[0]['meet_the_customer'],$id);
                }
                else
                {
                    $bankList = $this->Crm_banks->getBankIdnotin();
                }
            }
            else
            {

                  $bankList = $this->Crm_banks->getBanklist();
            }
            $str = "<option value=''>Select Bank</option>";
                foreach($bankList as $key => $val)
                {
                    $str .="<option value=".$val['id'].">$val[bank_name]</option>";
                }
                echo $str; exit;
        } 
        if(($id=='') && empty($case_id))
        {
            $bankList =  $this->Crm_banks->getBankNameBybnkId();
        }
        if(!empty($case_id) && !empty($id)) 
        {
           $emp_id =  $this->Loan_customer_case->getCaseInfoByCaseId($case_id);
           $bankList = $this->Crm_banks->getEmpBankName($emp_id[0]['meet_the_customer'],$id);
            if($emp_id[0]['meet_the_customer']>'1'){
                $bankList = $this->Crm_banks->getEmpBankName($emp_id[0]['meet_the_customer'],$id);
            }
            else
            {
                 $bankList = $this->Crm_banks->getBankIdnotin($id);
            }
        }
        else
        {
             $bankList =  $this->Crm_banks->getBankIdnotin($id);
        }
        $str = "<option value=''>Select Bank</option>";
        foreach($bankList as $key => $val)
        {
            $str .="<option value=".$val['id'].">$val[bank_name]</option>";
        }
        //$cout = '';
        if((count($bankList)==1) && (!empty($case_id) && !empty($id)))
        {
           echo $str.'@@1'; exit;
        }
        else
        {
            echo $str; exit;    
        }
        
    }

    public function addEditFileLogin($datapost)
    {
        $data = [];
        $result =[];
        $validate = [];
        $validate = $this->loanFileLoginValidation($datapost);
        if(empty($validate))
        {   
            $loopCount = count($datapost['file_loan_amount']);
            $bank_ids = explode(',', $datapost['bank_id']);
            $case_id = $datapost['case_id']; 
            $j = 0;
            $changed = [];
            for($i = 1;$i<=$loopCount;)
            {
               // $params['loan_amt'] = str_replace(',','',$datapost['file_loan_amount'][$j]);
                $data['file_loan_amount'] =str_replace(',','',$datapost['file_loan_amount'][$j]);  
                $data['file_tenure'] = $datapost['file_tenor_amount'][$j];
                $data['file_roi'] = $datapost['file_roi_amount'][$j];
                $data['ref_id'] = $datapost['file_ref_id'][$j];
                $data['file_remark'] = $datapost['file_rmk'][$j];
                $data['bank_id'] = $bank_ids[$j];
                $data['case_id'] = $case_id;
                $data['file_login_date'] =  date('Y-m-d H:i:s',strtotime($datapost['file_login_date'][$j]));
                //$actionss = 'Add'; (need to test)
                $checkIfExist=$this->Loan_customer_case->checkIfExists($data['bank_id'],$data['case_id']);
                $updateId = ($datapost['abc'][$j]>0)?$datapost['abc'][$j]:'';
                if($updateId>0){
                    
                    if($checkIfExist[0]['tag_flag']=='5')
                    {
                         $data['tag_flag'] = '1';
                         $this->updateLoanStatus($case_id,'1');
                        
                         $actionss = 'Add';
                    }
                    else
                    {
                        if((int)$data['file_loan_amount']<>(int)$checkIfExist[0]['file_loan_amount'])
                        {
                            $changed[$updateId]=$updateId;
                        }
                        if((int)$data['file_tenure']<>(int)$checkIfExist[0]['file_tenure'])
                        {
                            $changed[$updateId]=$updateId;
                        }
                        if((int)$data['file_tenure']<>(int)$checkIfExist[0]['file_tenure'])
                        {
                           $changed[$updateId]=$updateId;
                        }
                        if((int)$data['file_roi']<>(int)$checkIfExist[0]['file_roi'])
                        {
                           $changed[$updateId]=$updateId;
                        }
                        $data['tag_flag'] = $checkIfExist[0]['tag_flag'];
                        $this->updateLoanStatus($case_id,$checkIfExist[0]['tag_flag']);
                        $actionss = 'Update';
                    }
                    $action = '0';
                    $checkLoanAmt = $this->getLoanLimit($data['file_loan_amount'],$data['case_id'],$data['bank_id'],1);
                    if($checkLoanAmt['status']== 0)
                    {
                        //$this->renderSalesLowBalanceSms();
                        //echo json_encode($checkLoanAmt);exit;
                    }
                    $result[$i][] = $this->Loan_customer_case->saveCaseFileLogin($data,$updateId);
                }
                else if(empty($checkIfExist))
                {
                    //echo "awqqee";
                    $data['tag_flag'] = '1'; 
                    $this->updateLoanStatus($case_id,'1');
                    $checkLoanAmt = $this->getLoanLimit($data['file_loan_amount'],$data['case_id'],$data['bank_id'],1);
                    if($checkLoanAmt['status']== 0)
                    {
                        //echo json_encode($checkLoanAmt);exit;
                    }
                    $result[$i][] = $this->Loan_customer_case->saveCaseFileLogin($data,$updateId);
                   // echo "<pre>";
                   // print_r($result);
                    //exit;
                    $action = '1';
                    $actionss = 'Add';
                }
                $custInfo       = $this->Loan_customer_case->getCaseInfoByCaseId($case_id);
                $bankk         = $this->Crm_banks->getBankNameBybnkId($data['bank_id']);
                
                $dataed['last_updated_date'] = date('Y-m-d H:i:s');
                if(($custInfo[0]['loan_approval_status'] != 4) && ($custInfo[0]['loan_approval_status'] != 2) && ($custInfo[0]['loan_approval_status'] != 11))
                  $dataed['loan_approval_status'] = 1;
                $lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($dataed, $case_id);
                $this->addLoanHistory($case_id,'Filed',$bankk['bank_name'],$data['bank_id'],'','',$this->session->userdata['userinfo']['id'],$actionss,$data['file_login_date']);
                $this->addLoanHistoryUpdateLog($case_id,$data,'LeadLoginForm','',$action);
                $j++;
                $i++;
            }
           // exit;
            if(!empty($result))
            {
                if($actionss == 'Add'){
                   // $this->renderFileLoginSms($case_id,$loopCount,$datapost);
                }
                if(!empty($changed))
                {
                   //  $this->renderFileLoginSms($case_id,$loopCount,$datapost,$changed);  
                }
                $results= array('status'=>'True','message'=>'Case File Updated Successfully','Action'=>  base_url().'cpvDetails/' . base64_encode('CustomerId_' . $case_id));
            }
            else
            {
                $results= array('status'=>'False','message'=>'Something went Wrong');
            }
             echo json_encode($results);exit;
        }
        else if(!empty($validate))
        {
           echo json_encode($validate);exit;
        }
    }

    public function loanFileLoginValidation($params)
    {
          
        $err = [];
        if(empty($params['file_loan_amount']))
        {
            $err['Loan_amount'] = 'Loan amount cannot be empty';
        }
        if(empty($params['file_tenor_amount']))
        {
            $err['Loan_tenor'] = 'Loan tenor cannot be empty';
        }
        if(empty($params['file_roi_amount']))
        {
            $err['Loan_roi'] = 'Loan amount cannot be empty';
        }
        if($params['bank_id']=='')
        {
             $err['Loan_bank'] = 'Loan bank cannot be empty';
        }
        return $err;
    }

    public function deleteFormLogin()
    {
        $id = $this->input->post('id');
        $datetime = $this->input->post('datetime');
        $tag_status = '';
        $tag_status = $this->input->post('tag_status');
        $rejectReason = '';
        $dd = '';
        $rejectReason =  $this->input->post('rejectReason');
        $case_id = $this->input->post('caseid');       
        $getinfocustomer = $this->Loan_customer_case->getCaseInfoByCaseId($case_id);       
        $r = $this->Loan_customer_case->getCaseIdFromFile($id);       
        if($tag_status==''){
              $result =  $this->Loan_customer_case->deleteCaseFileLogin($id);
        } else {
            $data = [] ;
            $data['tag_flag'] = $tag_status;
            if($data['tag_flag']=='2')
            {
                $dd= !empty($datetime)?date('Y-m-d H:i:s', strtotime($datetime)):'';
                //$this->renderApprovedSms($r[0]['case_id'],$id);
                $data['approved_date'] = $dd;
                $status = 'Approved';
                $da = [];     
                if($getinfocustomer[0]['loan_approval_status']=='1'){       
                     $da['loan_approval_status']='2';       
                     $result = $this->Loan_customer_case->saveUpdateCaseInfo($da,$case_id,'1');     
                    }
            }
            if(($tag_status=='3') && ($rejectReason!=''))
            {
               $getmapppingInfo = $this->Loan_customer_case->getMappingInfoByCaseId($case_id,$id);
               $dd= !empty($datetime)?date('Y-m-d H:i:s', strtotime($datetime)):'';
               $data['reason_id'] =  $rejectReason;
               $data['rejected_date'] =$dd;
               $status = 'Rejected';
               $rejreason = $this->Loan_customer_case->getRejectList('',$rejectReason,'1');
               $reason = $rejreason[0]['reject_reason'];
               if(empty($getmapppingInfo)){       
                     $da['loan_approval_status']='3';       
                     $result = $this->Loan_customer_case->saveUpdateCaseInfo($da,$case_id,'1');     
                    }
            }
            $result = $this->Loan_customer_case->saveCaseFileLogin($data,$id);
            $bank_idd = $this->Crm_banks->getBankNameBybnkId($r[0]['bank_id']);
            $this->addLoanHistory($r[0]['case_id'],$status,$bank_idd['bank_name'],$r[0]['bank_id'],$reason,'',$this->session->userdata['userinfo']['id'],'Add',date('Y-m-d H:i:s', strtotime($dd)));
        }
       echo $result; exit;
    }

    public function cpvDetails($customer_id)
    {
        $editId      = !empty($customer_id)? explode('_',base64_decode($customer_id)):'';
        $casesId  = !empty($editId)?end($editId):'';
        $data = [];
        $bnkId = '';
        $data['pageTitle']      = 'Loan Cpv Details';
        $data['pageType']       = 'loan';
        $custInfo       = $this->Loan_customer_case->getCaseInfoByCaseId($casesId);
        $data['customerDetail']  = $custInfo;
        //$data['customerDetail'] =  $this->Loan_customer_info->getCaseInfoByCustomerId($customerId);
        $data['loanDetail']     =  $this->Loan_customer_case->getLoanInfoByCustomerId($data['customerDetail'][0]['customer_loan_id']);
        $data['case_id']        = $data['customerDetail'][0]['customer_loan_id'];
        if(!empty($casesId)){
        $data['CustomerInfo']       =  $custInfo[0];
        $this->updateLoanStatus($data['case_id'],$data['CustomerInfo']['tag_flag']);
        $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
        }
        foreach ($data['loanDetail'] as $key => $value) 
        {
            $bnkId        .= $value['bank_id'].',';
            $bankk         = $this->Crm_banks->getBankNameBybnkId($value['bank_id']);
            $data['loanDetail'][$key]['bank_name']      =  $bankk['bank_name'];  
            if($value['tag_flag']=='4')
            {
                $data['disbural'] = '1';
            } 
        }
        $data['reject_reason']  =  $this->Loan_customer_case->getRejectList();
        $data['bank_id']        = trim($bnkId,',');
        $data['emi']            = $this->calculateEmi($data['loanDetail'][0]['file_loan_amount'],$data['loanDetail'][0]['file_tenure'],$data['loanDetail'][0]['file_roi']);
        if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
        if(!empty($data['CustomerInfo']['loan_amt'])){
             $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
              $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
            //$data['loanamt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
        }
        $data['rolemgmt'] = $this->financeUserMgmt('','cpvDetails');
        if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
        $this->loadViews("finance/cpvDetails", $data);
    }

    public function addEditCpvDetails($datapost)
    {
        $flg = "";
        $customerInfos         = $this->Loan_customer_info->getCsvDetailsByCaseID($datapost['case_id']);
        $custInfo       = $this->Loan_customer_case->getCaseInfoByCaseId($datapost['case_id']);
        $data = [];
        $result =[];
        $results =[];
        $abc = [];
        $msg = [];
        $LeadDisbursalForm = [];
        $ftag = [];
        $case_id = (empty($datapost['case_id']))?$datapost['edit_id']:$datapost['case_id']; 
        $bank_ids = explode(',', $datapost['bank_id']);
        if(count($customerInfos)=='1'){
            $acction = 'Add';
        }
        else{
            $acction = 'Update';
        }
        if(isset($datapost['LeadDisbursalForm'])){
            $LeadDisbursalForm =  '1';
             $acction = 'Update';
        }
        if(isset($datapost['abc'])) {
            $abc = $datapost['abc'];
            $counter = count($abc); 
        }
        if(isset($datapost['mapp_id'])){
            $counter = count($datapost['mapp_id']); 
        }
        $j = 1;
        $k = 0;
        
        for($i = 1;$i<=$counter;)
            {
                if((empty($abc)) && (empty($ref_id)))
                {
                    $data['valuation_status'] = $datapost['CPV_'.$j];  
                    $data['cpv_status'] = $datapost['cpvstatus_'.$j]; 
                    $data['bank_remark'] = $datapost['cpvremark_'.$j]; 
                    $updateId = $datapost['mappid_'.$j];
                    $data['bank_id'] = $bank_ids[$k];
                    $remark = 'CPV Status';
                   // $customerInfos[$k]['cpv_status'];
                    if(($customerInfos[$k]['cpv_status']!=$data['cpv_status']) || ($customerInfos[$k]['valuation_status']!=$data['valuation_status'])){
                       $acction = 'Add';  
                    }
                    else
                    {
                        $acction = 'Update';
                    }
                    $status = (($data['valuation_status']=='1') && ($data['cpv_status']>='1'))?'CPV Complete':'CPV Complete';
                    $updateFile = 'CPV File';
                    if((!empty($data['cpv_status'])) && ($data['valuation_status']>0))
                    {
                        $msg[] = 'added';
                    }                 
                }
                else
                {                    
                    if(!empty($LeadDisbursalForm))
                    {
                        $flg=$datapost['flg'];
                        if(!empty($datapost['loan_dis_amt']))
                        {
                            $data['disbursed_amount'] = str_replace(',','',$datapost['loan_dis_amt']);
                        }else{
                            $data['disbursed_amount'] = str_replace(',','',$datapost['file_loan_amount'][$k]);
                        }
                        if(!empty($datapost['net_disburse']))
                        {
                            $data['gross_net_amount'] =  str_replace(',','',$datapost['net_disburse']);
                        }else{
                            $data['gross_net_amount'] =  str_replace(',','',$datapost['net_dis_amount'][$k]);
                        }
                        $data['loanno'] = $datapost['loanno'][$k];
                        $data['disbursed_tenure'] = $datapost['file_tenor_amount'][$k];
                        $data['disbursed_roi'] = $datapost['file_roi_amount'][$k];
                        $data['bank_id'] = $bank_ids[$k];
                        $loan_bank_limit = $this->Loan_customer_case->getDealerAdmin();
                        $checkLoanAmt = $this->getLoanLimit($data['disbursed_amount'],$case_id,$data['bank_id'],1);
                        if(($checkLoanAmt['status']== 0) && ($custInfo[0]['loan_for']==2) && ($loan_bank_limit == 2)  && ($custInfo[0]['meet_the_customer']>1))
                        {
                             echo json_encode($checkLoanAmt);exit;
                        }
                        //$data['ref_id'] = $datapost['ref_id'][$k];
                        $data['disbursed_date'] = date('Y-m-d H:i:s', strtotime($datapost['file_login_date'][$k]));
                        $updateId = $datapost['abc'][$k];
                        $updateFile = 'Disbursal File';
                        $remark = '';
                        if($datapost['des_id'][$k]=='3'){
                            $status = 'Rejected';
                            $remark = $datapost['remark'][$k];
                        }
                        if($datapost['des_id'][$k]=='4') {
                            $status = 'File for Disbursal';
                            $msg[] = 'added';
                            if(($custInfo[0]['loan_for']==2) && ($custInfo[0]['loan_approval_status']==2)){
                                $this->crmEmpAmountLog($case_id,$data['bank_id'],$data['disbursed_amount'],$custInfo[0]['meet_the_customer']);
                            }
                        }
                        else {
                            $status = 'Approved';
                        }                        
                    }
                    else{
                        $data['approved_loan_amt'] = str_replace(',','',$datapost['file_loan_amount'][$k]);  
                        if(empty($datapost['file_loan_amount'][$k])){
                            $results= array('status'=>'False','message'=>'Please Fill Loan Amount');
                            echo json_encode($results); exit;
                        }
                        $data['approved_tenure'] = $datapost['file_tenor_amount'][$k];
                        if(empty($datapost['file_tenor_amount'][$k])){
                            $results= array('status'=>'False','message'=>'Please Fill Tenure');
                            echo json_encode($results); exit;
                        }
                        $data['approved_roi'] = $datapost['file_roi_amount'][$k];
                       // $data['disbursed_date'] = date('Y-m-d H:i:s', strtotime($datapost['file_login_date'][$k]));
                        if(empty($datapost['file_roi_amount'][$k])){
                            $results= array('status'=>'False','message'=>'Please Fill ROI');
                            echo json_encode($results); exit;
                        }
                        //$data['fileno'] = $datapost['file_ref_id'][$k];
                        if(empty($datapost['file_ref_id'][$k]))
                        {
                            $results= array('status'=>'False','message'=>'Please Fill File no');
                            echo json_encode($results); exit;
                        }
                        $data['decision_remark'] = $datapost['file_rmk'][$k];
                        //$data['bank_id'] = $bank_ids[$k];
                        $data['bank_id'] = $bank_ids[$k];
                        $checkLoanAmt = $this->getLoanLimit($data['approved_loan_amt'],$case_id,$data['bank_id'],1);
                        if($checkLoanAmt['status']== 0)
                        {
                               // echo json_encode($checkLoanAmt);exit;
                        }
                        $data['approved_emi'] = $this->calculateEmi($data['approved_loan_amt'],$data['approved_tenure'], $data['approved_roi']);
                        $updateId = $datapost['mappid_'.$j];
                        $status = 'Filed';
                        $remark = '';
                        $updateFile = 'Decision File';
                        $ftag[] = $datapost['filetag'][$k];
                        if($datapost['filetag'][$k]=='3'){
                            $status = 'Rejected';
                            $remark = $datapost['remark'][$k];
                            $data['rejected_date'] = date('Y-m-d H:i:s', strtotime($datapost['file_login_date'][$k]));
                        }
                        else if($datapost['filetag'][$k]=='2')
                        {

                            $status = 'Approved';
                            $msg[] = 'added';
                            $data['approved_loan_amt'] = $data['approved_loan_amt'];
                            $data['approved_tenure'] = $data['approved_tenure'];
                            $data['approved_roi'] = $data['approved_roi'];
                          //  $data['fileno'] = $data['fileno'];
                            $data['approved_date'] = date('Y-m-d H:i:s', strtotime($datapost['file_login_date'][$k]));

                        }
                       
                    }

                }
                $action = '0';
                if($updateId>0)
                {
                    $action = '1';
                }
                $result[$i][] = $this->Loan_customer_case->saveCaseFileLogin($data,$updateId);
                if($status == 'Approved')
                {
                    //$this->renderApprovedSms($datapost['case_id'],$updateId);
                }
                if($updateFile == 'Disbursal File')
                {
                   // $this->renderDisbursedSms($datapost['case_id'],$updateId);
                }
                $bankk         = $this->Crm_banks->getBankNameBybnkId($data['bank_id']);
                if($updateFile != 'Decision File'){
                $this->addLoanHistory($case_id,$status,$bankk['bank_name'],$data['bank_id'],$remark,'',$this->session->userdata['userinfo']['id'],$acction,date('Y-m-d H:i:s', strtotime($datapost['file_login_date'][$k])));
                    }
                $this->addLoanHistoryUpdateLog($case_id,$data,$updateFile,'',$action);
                $j++;
                $i++;
                $k++;
            }
            if(!empty($result))
            {
               
                if(($updateFile=='Decision File') && (in_array('2', $ftag) || in_array('4', $ftag)))
                {
                    if(in_array('2', $ftag) || in_array('4', $ftag)){
                        $dataed['last_updated_date'] = date('Y-m-d H:i:s');
                        $lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($dataed, $case_id);
                    }
                    $results= array('status'=>'True','message'=>$updateFile .' Updated Successfully','Action'=>  base_url().'uploadDocs/' . base64_encode('CustomerId_' . $case_id).'/dis');
                }
                else
                {
                    $results= array('status'=>'False','message'=>'Please Approve File.');
                }
                if($updateFile == 'CPV File')
                {

                    if(in_array('added', $msg)){
                        $dataed['last_updated_date'] = date('Y-m-d H:i:s');
                        $lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($dataed, $case_id);
                        $results= array('status'=>'True','message'=>$updateFile .' Updated Successfully','Action'=>  base_url().'decisionDetails/' . base64_encode('CustomerId_' . $case_id));
                    }else{
                        $results= array('status'=>'False','message'=>'Please Complete Cpv Details');
                    }
                }
                if($updateFile=='Disbursal File')
                {
                    if(in_array('added', $msg))
                    {
                        $dataed['last_updated_date'] = date('Y-m-d H:i:s');
                        if(($custInfo[0]['loan_approval_status'] != 8) && ($custInfo[0]['loan_approval_status'] != 11))
                           $dataed['loan_approval_status'] = 4;
                        $lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($dataed, $case_id);
                       // $results= array('status'=>'True','message'=>$updateFile .' Updated Successfully','Action'=>  base_url().'uploadDocs/' . base64_encode('CustomerId_' . $case_id).'/dis');
                        if($flg=='1')
                        {
                            $results= array('status'=>'True','message'=>' Updated Successfully','Action'=>  base_url().'disbursalDetails/' . base64_encode('CustomerId_' .$case_id));
                        }else{
                         $results= array('status'=>'True','message'=>' Updated Successfully','Action'=>  base_url().'paymentDetails/' . base64_encode('CustomerId_' .$case_id));
                        }
                       // }
                    }  
                    else
                    {
                        $results= array('status'=>'False','message'=>'Please Disburse Case File');
                    }
                }
            }
            echo json_encode($results);exit;
        }
       



    public function decisionDetails($customer_id)
    {

        $editId      = !empty($customer_id)? explode('_',base64_decode($customer_id)):'';
        $caseId  = !empty($editId)?end($editId):'';
       // echo $customerId; 
        $data = [];
        $bnkId = '';
        $data['pageTitle']      = 'Loan Decision Details';
        $data['pageType']       = 'loan';
        $data['customerDetail'] = $this->Loan_customer_case->getCaseInfoByCaseId($caseId);
        $data['CustomerInfo']  = $data['customerDetail'][0];
        //$data['customerDetail'] =  $this->Loan_customer_info->getCaseInfoByCustomerId($customerId);
        $data['loanDetail']     =  $this->Loan_customer_case->getLoanInfoByCustomerId($data['customerDetail'][0]['customer_loan_id'],'','','1');
        $data['case_id']        = $data['customerDetail'][0]['customer_loan_id'];
        if(!empty($caseId))
        {
            $this->updateLoanStatus($data['case_id'],$data['CustomerInfo']['tag_flag']);
        //$data['CustomerInfo']       = current($this->Loan_customer_info->getCustomerInfoByCustomerId($customerId));
         $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id'],0,'',1));
        }
        $ab ='';
        foreach ($data['loanDetail'] as $key => $value) 
        {
            $bnkId        .= $value['bank_id'].',';
            $bankk         = $this->Crm_banks->getBankNameBybnkId($value['bank_id']);
            $data['loanDetail'][$key]['bank_name']      =  $bankk['bank_name']; 
            if($value['tag_flag']=='4')
            {
                $data['disbural'] = '1';
            } 
            $data['loanDetail'][$key]['emi'] = $this->calculateEmi($data['loanDetail'][$key]['file_loan_amount'],$data['loanDetail'][$key]['file_tenure'],$data['loanDetail'][$key]['file_roi']);
            $data['loanDetail'][$key]['emi'] = $this->IND_money_format($data['loanDetail'][$key]['emi']);
            $data['loanDetail'][$key]['file_loan_amount'] = $this->IND_money_format($data['loanDetail'][$key]['file_loan_amount']);
            $data['loanDetail'][$key]['approved_loan_amt'] = $this->IND_money_format($data['loanDetail'][$key]['approved_loan_amt']);
            $data['loanDetail'][$key]['disbursed_amount'] = $this->IND_money_format($data['loanDetail'][$key]['disbursed_amount']);
            if($data['loanDetail'][$key]['cpvstatus']!='2')
            {
                $ab = '1';
            }

        }
        if (empty($ab)) {
           header('Location:'.base_url().'loanListing/');
        }
       
        $data['bank_id']        = trim($bnkId,',');
        //$data['emi']            = $this->calculateEmi($data['loanDetail'][0]['file_loan_amount'],$data['loanDetail'][0]['file_tenure'],$data['loanDetail'][0]['file_roi']);
        $data['reject_reason']  =  $this->Loan_customer_case->getRejectList();
        if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
        if(!empty($data['CustomerInfo']['loan_amt']))
        {
            $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
            $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
            //$data['loanamt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
        }
        $data['rolemgmt'] = $this->financeUserMgmt('','decisionDetails');
        if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
        $this->loadViews("finance/decisionDetails", $data);
    }
   
    public function disbursalDetails($customer_id)
    {
        $editId      = !empty($customer_id)? explode('_',base64_decode($customer_id)):'';
        $casesId     = !empty($editId)?end($editId):'';
        $data = [];
        $bnkId = '';
        $data['pageTitle']      = 'Loan Disbursal Details';
        $data['pageType']       = 'loan';
        $data['customerDetail']       = $this->Loan_customer_case->getCaseInfoByCaseId($casesId);
        $data['loanDetail']     =  $this->Loan_customer_case->getLoanInfoByCustomerId($data['customerDetail'][0]['customer_loan_id'],2);
        if($data['customerDetail'][0]['tag_flag']=='4'){
            $data['loanDetail']     =  $this->Loan_customer_case->getLoanInfoByCustomerId($data['customerDetail'][0]['customer_loan_id'],4,0,0,1);
        }
       // $data['loanDetail']     =  $this->Loan_customer_case->getLoanInfoByCustomerId($data['customerDetail'][0]['customer_loan_id'],2);
        $data['case_id']        = $casesId;
        if(!empty($casesId))
        {
             $mi_funding = '';
            $data['CustomerInfo']       = $data['customerDetail'][0];
            $data['customerMobileNumber']  = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
            $this->updateLoanStatus($data['case_id'],$data['CustomerInfo']['tag_flag']);
            if((!empty($data['CustomerInfo']['engine_number'])) && (!empty($data['CustomerInfo']['chassis_number']))){
           $getinsu = $this->Crm_insurance->getCaseDetails('',$data['CustomerInfo']['engine_number'],$data['CustomerInfo']['chassis_number']);
           $mi_funding = $getinsu[0]['premium'];
            }
        }
        foreach ($data['loanDetail'] as $key => $value) 
        {
            $bnkId        .= $value['bank_id'].',';
            $bankk         = $this->Crm_banks->getBankNameBybnkId($value['bank_id']);
            $data['loanDetail'][$key]['bank_name']      =  $bankk['bank_name'];
            if($value['tag_flag']=='4')
            {
                $data['disbural'] = '1'; }
                $am = (!empty($data['loanDetail'][$key]['disbursed_amount'])?$data['loanDetail'][$key]['disbursed_amount']:(!empty($data['loanDetail'][$key]['approved_loan_amt'])?$data['loanDetail'][$key]['approved_loan_amt']:$data['loanDetail'][$key]['file_loan_amount']));
                 $te = (!empty($data['loanDetail'][$key]['disbursed_tenure'])?$data['loanDetail'][$key]['disbursed_tenure']:(!empty($data['loanDetail'][$key]['approved_tenure'])?$data['loanDetail'][$key]['approved_tenure']:$data['loanDetail'][$key]['file_tenure']));
                 $ro = (!empty($data['loanDetail'][$key]['disbursed_roi'])?$data['loanDetail'][$key]['disbursed_roi']:(!empty($data['loanDetail'][$key]['approved_roi'])?$data['loanDetail'][$key]['approved_roi']:$data['loanDetail'][$key]['file_roi']));
               // $data['loanDetail'][$key]['file_loan_amount'],$data['loanDetail'][$key]['file_tenure'],$data['loanDetail'][$key]['file_roi']
                 $type=0;
             if((!empty($data['CustomerInfo']['loan_amt'])) && !(empty($data['CustomerInfo']['counter_emi']))){
                $type =1;
            }
            $data['loanDetail'][$key]['emi'] = $this->calculateEmi((!empty($data['CustomerInfo']['gross_loan'])?$data['CustomerInfo']['gross_loan']:$am),$te,$ro,$type);

          //  $data['loanDetail'][$key]['emi'] = $this->calculateEmi($am,$te,$ro,$type);
            $data['loanDetail'][$key]['emi'] = $this->IND_money_format($data['loanDetail'][$key]['emi']);
            $data['loanDetail'][$key]['file_loan_amount'] = $this->IND_money_format($data['loanDetail'][$key]['file_loan_amount']);
            $data['loanDetail'][$key]['approved_loan_amt'] = $this->IND_money_format($data['loanDetail'][$key]['approved_loan_amt']);
            $data['loanDetail'][$key]['disbursed_amount'] = $this->IND_money_format($data['loanDetail'][$key]['disbursed_amount']);
            $data['loanDetail'][$key]['gross_net_amount'] = $this->IND_money_format($data['loanDetail'][$key]['gross_net_amount']);

        }
        $data['bank_id']        = trim($bnkId,',');
        if(!empty($data['loanDetail'])){
      //  $data['emi']            = $this->calculateEmi($data['loanDetail'][0]['file_loan_amount'],$data['loanDetail'][0]['file_tenure'],$data['loanDetail'][0]['file_roi']);
        }   
        if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
        if(!empty($data['CustomerInfo']['loan_amt'])){
            $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
            $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
            $data['CustomerInfo']['gps_disburse'] = $this->IND_money_format($data['CustomerInfo']['gps_disburse']);
            $data['CustomerInfo']['loan_disburse'] = $this->IND_money_format($data['CustomerInfo']['loan_disburse']);
            $data['CustomerInfo']['motor_disburse'] = $this->IND_money_format(!empty($mi_funding)?$mi_funding:$data['CustomerInfo']['motor_disburse']);
            $data['CustomerInfo']['fee_disburse'] = $this->IND_money_format($data['CustomerInfo']['fee_disburse']);
            $data['CustomerInfo']['other_disburse'] = $this->IND_money_format($data['CustomerInfo']['other_disburse']);
            $data['CustomerInfo']['existing_disburse'] = $this->IND_money_format($data['CustomerInfo']['existing_disburse']);
            $data['CustomerInfo']['processing_disburse'] = $this->IND_money_format($data['CustomerInfo']['processing_disburse']);
            $data['CustomerInfo']['rc_disburse'] = $this->IND_money_format($data['CustomerInfo']['rc_disburse']);
            $data['CustomerInfo']['total_amount'] = $this->IND_money_format($data['CustomerInfo']['total_amount']);
            $data['CustomerInfo']['loan_amount'] = $this->IND_money_format($data['CustomerInfo']['loan_amount']);
            /*------------------*/
            $data['CustomerInfo']['gross_loan'] = $this->IND_money_format($data['CustomerInfo']['gross_loan']);
            $data['CustomerInfo']['extend_warranty'] = $this->IND_money_format($data['CustomerInfo']['extend_warranty']);
            $data['CustomerInfo']['counter_emi'] = $data['CustomerInfo']['counter_emi'];
            $data['CustomerInfo']['total_emi'] = $this->IND_money_format($data['CustomerInfo']['total_emi']);
            $data['CustomerInfo']['disburse_emi'] = $this->IND_money_format($data['CustomerInfo']['disburse_emi']);
            $data['CustomerInfo']['existing_loan'] = $this->IND_money_format($data['CustomerInfo']['existing_loan']);
            $data['CustomerInfo']['existing_account_no'] =$data['CustomerInfo']['existing_account_no'];
            $data['CustomerInfo']['loan_short'] = $this->IND_money_format($data['CustomerInfo']['loan_short']);
            $data['CustomerInfo']['loan_amount'] = $this->IND_money_format($data['customerDetail'][0]['loan_amount']);
            $data['CustomerInfo']['first_emi'] = date('d-m-Y',strtotime($data['CustomerInfo']['first_emi']));
            $data['CustomerInfo']['payout'] = ucwords($data['CustomerInfo']['payout']);

            $data['CustomerInfo']['remark'] = ucwords(strtolower($data['CustomerInfo']['remark']));


            $data['CustomerInfo']['loan_credit_protect'] = $this->IND_money_format($data['CustomerInfo']['loan_credit_protect']);

            $data['CustomerInfo']['health_insurance'] = $this->IND_money_format($data['CustomerInfo']['health_insurance']);

        }
        /* if(!empty($data['CustomerInfo']['loan_approval_status']))
            {
                $tagStatus = $this->Loan_customer_case->getFileTagName($data['CustomerInfo']['loan_approval_status']);
                $data['app_status'] = $tagStatus[0]['file_tag'];
            } */
        if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
        $data['reject_reason']  =  $this->Loan_customer_case->getRejectList();
        $data['rolemgmt'] = $this->financeUserMgmt('','disbursalDetails');
        $this->loadViews("finance/disbursalDetails", $data);
    }

    public function getRejectReason()
    {
        $parent_id = $this->input->post('id');
        $data = $this->Loan_customer_case->getRejectList($parent_id);
        $str = "<option value='0'>Select</option>";
        foreach($data as $dk => $dv)
        {
            $str .= "<option value=".$dv['id'].">$dv[reject_reason]</option>";
        }
        echo $str; exit;
    }

    public function reloginFile()
    {
           
            $data = [];
            $datapost = $this->input->post();
            $updateId = $datapost['id'];
            $previousLoanAmount = $this->Loan_customer_case->getLoanInfoById($updateId);
            $data['file_loan_amount'] = str_replace(',','',$datapost['loanAmount']); //$datapost['loanAmount'];
            $data['file_tenure'] = $datapost['numberOfMonths'];
            $data['file_roi'] = $datapost['rateOfInterest'];
            $data['case_id'] = $datapost['case_id'];
            $data['tag_flag'] = '1';
            $data['approved_loan_amt'] = '';
            $data['approved_tenure'] = '';
            $data['approved_roi'] = '';
            $data['approved_emi'] = '';
            $data['approved_bank_remark '] = '';
            $data['valuation_status '] = '0';
            $data['bank_remark '] = '';
            $data['cpv_status '] = '0';
            $data['ref_id'] = '';
            $bank_id = $datapost['bank_id'];
            $status = 'Relogin';
            $remark = 'Relogin';
            $updateFile = $datapost['module'];
            $this->Loan_customer_case->saveCaseFileLogin($data,$updateId);
            $dataed['last_updated_date'] = date('Y-m-d H:i:s');
            $lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($dataed, $datapost['case_id']);
            $bankk         = $this->Crm_banks->getBankNameBybnkId($bank_id);
            $this->addLoanHistory($data['case_id'],$status,$bankk['bank_name'], $bank_id,$remark,'',$this->session->userdata['userinfo']['id']);
            $this->addLoanHistoryUpdateLog($data['case_id'],$data,$updateFile,'','update');
            $results= array('status'=>'True','message'=>$updateFile .' Updated Successfully','Action'=>  base_url().'loanFileLogin/' . base64_encode('CustomerId_' . $data['case_id']));
            $this->Loan_customer_case->loanAmountHistoryLog($previousLoanAmount,$data,$datapost['case_id']);
            echo json_encode($results); exit;
    }

    public function updateDisburseLoan()
    {
        $data = [];
        $datapost = $this->input->post();
        $flag  = $this->input->post('flag');
        $rc_detail = [];
        $refId = $datapost['refId'];
        $loanno = $datapost['loanno'];
        if(empty($refId))
        {
            $results= array('status'=>'0','msg'=>'Please select Reference Id');
            echo json_encode($results); exit;
        }
        $stt = 'Update';
        if($flag!='1'){
            $data['tag_flag'] = '4';
            $stt = 'Add';
        }
        if(!empty($datapost['tensure']))
        $data['disbursed_tenure'] = $datapost['tensure'];
        if(!empty($datapost['roi']))
        $data['disbursed_roi'] = $datapost['roi'];
        $data['loanno'] = $refId;
        $updateId = $datapost['id'];
        $bannk =$datapost['bank_id'];
        $bankname = $this->Crm_banks->getBankNameBybnkId($bannk); 
        //$data['disbursed_date'] = date('Y-m-d H:i:s');;
        $this->Loan_customer_case->saveCaseFileLogin($data,$updateId);
        $dataed = array();
        $dataed['last_updated_date'] = date('Y-m-d H:i:s');
        $dataed['loan_approval_status'] = 4;
        $lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($dataed, $datapost['caseid']);
        $fileLogin = $this->Loan_customer_case->getCaseIdFromFile($updateId);
        $allInfo = $this->Loan_customer_case->getCaseInfoByCaseId($fileLogin[0]['case_id']);
        $customerMobileNumber = current($this->Loan_customer_info->getCustomerMobileNumber($allInfo[0]['customer_id']));

      //  echo $allInfo[0]['loan_for'].' - '. $allInfo[0]['loan_type'];
        if(($allInfo[0]['loan_for']=='2') && (trim(strtolower($allInfo[0]['loan_type']))!='topup') && ($flag!='1')){
        $rc_detail['customer_id'] = $allInfo[0]['customer_id'];
        $rc_detail['customer_name'] = $allInfo[0]['name'];
        $rc_detail['customer_mobile'] = $customerMobileNumber['mobile'];
        $rc_detail['customer_email'] = $allInfo[0]['email'];
        $rc_detail['loan_case_type'] = ($allInfo[0]['loan_type']=='refinance')?'1':'3';
        $rc_detail['make_id'] = $allInfo[0]['makeId'];
        $rc_detail['loan_sno'] = $allInfo[0]['loan_srno'];
        $rc_detail['model_id'] = $allInfo[0]['modelId'];
        $rc_detail['version_id'] = $allInfo[0]['versionId'];
        $rc_detail['reg_year'] = $allInfo[0]['reg_year'];
        $rc_detail['pending_from'] = $allInfo[0]['rc_by'];
        $rc_detail['reg_no'] = $allInfo[0]['regno'];
        $rc_detail['loanno'] = $loanno;
        $rc_detail['loan_ref_id'] = $allInfo[0]['ref_id'];
        $rc_detail['bank_id_loan'] = $allInfo[0]['financer'];
        $rc_detail['loan_disbursement_date'] = $allInfo[0]['disbursed_date']; 
            $this->Crm_rc->setRcCarDetail($rc_detail);
        }

        $results= array('status'=>'1','msg'=>'Disbursed Successfully');
        $this->addLoanHistory($datapost['caseid'],'Disbursed',$bankname['bank_name'],$bannk,'','',$this->session->userdata['userinfo']['id'],$stt);
        $this->addLoanHistoryUpdateLog($datapost['caseid'],$data,'Disbured','','1');
        echo json_encode($results); exit;
    }
    public function crmEmpAmountLog($case_id,$bank_id,$dis_amount,$emp_id)
    {
        $data = [];
        $data['case_id'] = $case_id;
        $data['bank_id'] = $bank_id;
        $amount_assigned = $this->Loan_customer_info->getAssignedLimitByBankEmp($emp_id,$bank_id);
        $remain = $this->Loan_customer_info->getRemainingLimitByBankEmp($emp_id,$bank_id);
        $getRemaining = (int)$amount_assigned - (int)(!empty($remain)?$remain:0);
        $data['amount_assigned'] = $getRemaining;
        $data['amount_credit'] = 0;
        $data['amount_debit'] = $dis_amount;
        $data['amount_remaining'] = (int)$getRemaining-(int)$dis_amount;
        $data['action'] = '1';
        $data['created_by'] = $this->session->userdata['userinfo']['id'];
        $data['emp_id'] = $emp_id;
        $this->Loan_customer_info->crmEmpAmountLog($data);
    }

    public function uploadDocs($case_id)
    {
        $editId      = !empty($case_id)? explode('_',base64_decode($case_id)):'';
        $caseId  = !empty($editId)?end($editId):'';
        $data = [];
        $seg = $this->uri->segment(3);
        if(!empty($seg) && (($seg=='dis') || ($seg=='diss')))
        {
            $data['disbural'] = '1';
        }
        if(!empty($seg) && ($seg=='post'))
        {
            $data['disbural'] = '1';
            $data['postd'] = '1';
        }

        $bnkId = '';
        $uploadDocList = [];
        $data['pageTitle']      = 'Loan Upload Docs';
        $data['pageType']       = 'loan';
        if(!empty($caseId)){
            $custInfo       = $this->Loan_customer_case->getCaseInfoByCaseId($caseId);
            $data['CustomerInfo']  = $custInfo[0];
            if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
            if(!empty($data['CustomerInfo']['loan_amt'])){
                 $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
              $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
            //$data['loanamt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
        }
            $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
        }
        $data['rolemgmt'] = $this->financeUserMgmt('','uploadDocs');
         if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
        $this->loadViews("finance/uploadDocs",$data);
    }

   public function logindoc()
    {
        $customerId  = $this->input->post('customer_id');
        $caseId  = $this->input->post('cases_id');
        $imgListUpdated = '';
        $arr = ['1','2','3','4','5','6'];
        $data = [];
        $imgListArr = [];
        $personnelDocs = [];
        $bnkId = '';
        $uploadDocList = [];
        $a = [];
        $b = [];
        $data['pageTitle']      = 'Loan Login Docs';
        $data['pageType']       = 'loan';
        if(!empty($customerId)){
            $custInfo       = $this->Loan_customer_case->getCaseInfoByCaseId($caseId);
            $data['CustomerInfo']  = $custInfo[0];
            if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
            if(!empty($data['CustomerInfo']['loan_amt']))
            {
                $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
                $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
            }
            $data['customerMobileNumber'] = current($this->Loan_customer_info->getCustomerMobileNumber($customerId));
        }
        
        //$data['co_appreq'] = $co_appreq;
        $docList = $this->Crm_upload_docs_list->getDocList('','1');
        foreach($docList as $key => $val)
        {
            $uploadDocList[$val['parent_id']]['name']= $val['parent_name'];
            $uploadDocList[$val['parent_id']]['is_require']= $val['catreq'];
            //echo $data['CustomerInfo']['loan_for'].'-'.$val['id'];
            if(($data['CustomerInfo']['loan_for'] == '2') && $val['id']=='7')
            {
                $uploadDocList[$val['parent_id']]['is_require']= '1';
            }
            if(($data['CustomerInfo']['co_applicant']=='1') && ($val['parent_id']=='8'))
            {
                //echo "dfgdgr"; exit;
                       $uploadDocList[$val['parent_id']]['is_require']= '1';
            }
            if(($data['CustomerInfo']['case_field']=='1') && ($val['parent_id']=='4'))
            {
               // echo "dfgdgr"; exit;
                       $uploadDocList[$val['parent_id']]['is_require']= '1';
            }

            $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'],'1'); 
            foreach ($sublist as $skey => $sval)
            {
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['name'] = $sval['name'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['sub_category_id'] = $sval['sub_category_id'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = $sval['is_require'];
                   if(($data['CustomerInfo']['loan_for'] == '2') && $sval['sub_category_id']=='42')
                    {
                        $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = '1';
                    }
                    if(($data['CustomerInfo']['co_applicant']=='1') && ($val['parent_id']=='8'))
                    {
                        $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = '1'; 
                    }
                    if(($data['CustomerInfo']['loan_for']=='1') && $val['parent_id']=='12')
                        {
                             $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require']= '1';
                             //$req_sid['12'][]='210';
                        }
                        if(($data['CustomerInfo']['loan_for'] == '2') && $val['parent_id']=='12')
                        {
                            $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require']= '0';
                        }
            }   
        }
        $data['uploadDocList'] = $uploadDocList;
        $i = 0;
        $imgListUpdated = $this->Crm_upload_docs_list->getImageList($customerId,'','','','1',$caseId);
        if(!empty($imgListUpdated))
        {
            $tagIdN = [];
            foreach($imgListUpdated as $imgK => $imgV)
            {
                $tagIdN = $imgV['tag_id'];
                $name = '';
                $bank_name = '';
                if(in_array($imgV['tag_id'], $arr))
                {
                   $imageTag = $this->Crm_upload_docs_list->getImageList('','',$imgV['tag_id'],'','1',$caseId);
                   $bankname = $this->Crm_banks->getBankNameBybnkId($imageTag[0]['bank_id']);
                   $bank_name = $imgV['name'].(!empty($bankname['bank_name'])?'( '.$bankname['bank_name'].' )':'');
                }

                if(!empty($bank_name))
                {
                    $name = $bank_name;
                }
                else
                {
                    $name = $imgV['name'];
                }
                $a['allids'][]       =   $imgV['sub_id'];
               // $a['allpids']['parent_id']       =   $imgV['parent_id'];
                $imgListArr[$i]['id']           =   $imgV['id'];
                $imgListArr[$i]['doc_name']     =   $imgV['doc_name'];
               // $imgListArr[$i]['doc_url']      =   ((!empty($imgV['aws_url'])) && ($imgV['sent_to_aws']=='1'))?$imgV['aws_url']:$imgV['doc_url'];
                $imgListArr[$i]['doc_url']      =   (($imgV['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$imgV['doc_url'];
                $imgListArr[$i]['doc_type']     =   $imgV['doc_type'];
                $imgListArr[$i]['customer_id']  =   $imgV['customer_id'];
                $imgListArr[$i]['case_id']      =   $imgV['case_id'];
                $imgListArr[$i]['status']       =   $imgV['status'];
                $imgListArr[$i]['created_on']   =   $imgV['created_on'];
                $imgListArr[$i]['updated_on']   =   $imgV['updated_on'];
                $imgListArr[$i]['tag_id']       =   $imgV['parent_tag_id'];
                $imgListArr[$i]['sub_id']       =   $imgV['sub_id'];
                $imgListArr[$i]['image_id']     =   $imgV['image_id'];
                $imgListArr[$i]['imgID']        =   $imgV['imgID'];
                $imgListArr[$i]['bank_id']      =   $imgV['bank_id'];
                $imgListArr[$i]['name']         =   $name;
                $imgListArr[$i]['parent_id']    =   $imgV['parent_id'];
                $imgListArr[$i]['err']          =   $imgV['err'];
                $i++;
            }
        }
        
 
        $a['allids'] = array_filter($a['allids']);
        

        if(!empty($a['allids']))
        {
            $sublistsss = $this->Crm_upload_docs_list->getDocList('','1','','','','',$a['allids']);

            foreach($sublistsss as $ssub => $kkk)
            {
                $b['allParentIds'][] = $kkk['parent_id'];
            }

        }
        $data['imageList'] =  $imgListArr;
        $data['allParentIds'] =  !empty($b)?$b:'';
        $data['pendencyDoc'] = $this->Crm_upload_docs_list->getPendencyDetail($caseId,1);
        $data['rolemgmt'] = $this->financeUserMgmt('','uploadDocs');
        if((empty($data['imageList'])) && ($data['CustomerInfo']['upload_login_doc_flag']=='0'))
        {
            $getPersonnelCustomerDocs = $this->Crm_upload_docs_list->getPersonnelDocs($customerId);
            if(!empty($getPersonnelCustomerDocs))
            {
                foreach ($getPersonnelCustomerDocs as $keyI => $valI) {
                    $personnelDocs['doc_name'] = $valI['doc_name'];
                    $personnelDocs['doc_url'] = (($valI['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$valI['doc_url'];
                    $personnelDocs['doc_type']  = $valI['doc_type'];;
                    $personnelDocs['customer_id'] = $valI['customer_id'];;
                    $personnelDocs['case_id']    = $caseId;
                    $personnelDocs['created_on'] = date('Y-m-d h:i:s');
                    $personnelDocs['created_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';

                    $result = $this->Crm_upload_docs_list->insertLoginDocs($personnelDocs);
                    $tagArr['image_id'] = $result;
                    $tagArr['tag_id'] = $valI['tag_id'];
                    $tagArr['created_on'] = date('Y-m-d h:i:s');
                    $tagArr['created_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
                    $imageList = $this->Crm_upload_docs_list->insertTagMapping($tagArr);
                    $i++;
                }
            }
        } 
         if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
        echo $datas=$this->load->view('finance/loginDoc',$data,true); exit;
        //$this->loadViews("finance/loginDocs",$data);
    }


  public function disbursedoc()
    {
        $customerId  = $this->input->post('customer_id');
        $caseId  = $this->input->post('cases_id');
        $data = [];
        $imgListUpdated = '';
        $arr=[];
        $imgListArr = [];
        $bnkId = '';
        $uploadDocList = [];
        $data['pageTitle']      = 'Loan Disbursal Docs';
        $data['pageType']       = 'loan';
        if(!empty($customerId)){
           // $data['CustomerInfo']       = $this->Loan_customer_case->getCaseInfoByCaseId($caseId);
            $custInfo       = $this->Loan_customer_case->getCaseInfoByCaseId($caseId);
            $data['CustomerInfo']  = $custInfo[0];
            if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
            if(!empty($data['CustomerInfo']['loan_amt'])){
                 $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
              $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
            //$data['loanamt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
        }
            $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($customerId));
        }
        $docList = $this->Crm_upload_docs_list->getDocList('','2');
        foreach($docList as $key => $val)
        {
            $uploadDocList[$val['parent_id']]['name']= $val['parent_name'];
            $uploadDocList[$val['parent_id']]['is_require']= $val['is_require'];
            if(($data['CustomerInfo']['loan_for'] == '2') && ($val['parent_id']=='12'))
                    {
                        $uploadDocList[$val['parent_id']]['is_require'] = '0';
                    }
            //echo $data['CustomerInfo']['loan_for'].'-'.$val['id'];
            $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'],'2'); 
            foreach ($sublist as $skey => $sval)
            {
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['name'] = $sval['name'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['sub_category_id'] = $sval['sub_category_id'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = $sval['is_require'];
                   if(($data['CustomerInfo']['loan_for'] == '2') && $sval['sub_category_id']=='42')
                    {
                        $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = '1';
                    }
                   /* if(($data['CustomerInfo']['loan_for'] == '1') && ($sval['sub_category_id']=='210'))
                    {
                        $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = '1';
                    }
                    else
                    {
                        $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = '0';
                    }*/
            }   
        }
        $data['uploadDocList'] = $uploadDocList;
        $i = 0;
        $imgListUpdated = $this->Crm_upload_docs_list->getImageList($customerId,'','','','2',$caseId);
        if(!empty($imgListUpdated))
        {
            foreach($imgListUpdated as $imgK => $imgV)
            {
                $name = '';
                $bank_name = '';
                if(in_array($imgV['tag_id'], $arr))
                {
                   $imageTag = $this->Crm_upload_docs_list->getImageList('','',$imgV['tag_id'],'','2',$caseId);
                   $bankname = $this->Crm_banks->getBankNameBybnkId($imageTag[0]['bank_id']);
                   $bank_name = $imgV['name'] .' ('. $bankname['bank_name'].')';
                }
                $a['allids'][]       =   $imgV['sub_id'];
                $imgListArr[$i]['id']           =   $imgV['id'];
                $imgListArr[$i]['doc_name']     =   $imgV['doc_name'];
                $imgListArr[$i]['doc_url']      =   (($imgV['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$imgV['doc_url'];
                $imgListArr[$i]['doc_type']     =   $imgV['doc_type'];
                $imgListArr[$i]['customer_id']  =   $imgV['customer_id'];
                $imgListArr[$i]['case_id']      =   $imgV['case_id'];
                $imgListArr[$i]['status']       =   $imgV['status'];
                $imgListArr[$i]['created_on']   =   $imgV['created_on'];
                $imgListArr[$i]['updated_on']   =   $imgV['updated_on'];
                $imgListArr[$i]['tag_id']       =   $imgV['parent_tag_id'];
                $imgListArr[$i]['sub_id']       =   $imgV['sub_id'];
                $imgListArr[$i]['image_id']     =   $imgV['image_id'];
                $imgListArr[$i]['imgID']        =   $imgV['imgID'];
                $imgListArr[$i]['bank_id']      =   $imgV['bank_id'];
                $imgListArr[$i]['name']         =   !(empty($bank_name))?$bank_name:$imgV['name'];
                $imgListArr[$i]['parent_id']    =   $imgV['parent_id'];
                $imgListArr[$i]['err']          =   $imgV['err'];
                $i++;
            }
        }
        $a['allids'] = array_filter($a['allids']);

        if(!empty($a['allids']))
        {
            $sublistsss = $this->Crm_upload_docs_list->getDocList('','2','','','','',$a['allids']);

            foreach($sublistsss as $ssub => $kkk)
            {
                $b['allParentIds'][] = $kkk['parent_id'];
            }

        }
        $data['imageList'] =  $imgListArr;
        $data['allParentIds'] =  !empty($b)?$b:'';
        $data['imageList'] =  $imgListArr;
       //$data['imageList'] = $this->Crm_upload_docs_list->getImageList($customerId,'','','','2',$caseId);
        $data['pendencyDoc'] = $this->Crm_upload_docs_list->getPendencyDetail($caseId,'2');
        $data['rolemgmt'] = $this->financeUserMgmt('','disuploadDocs');
        if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
        echo $datas=$this->load->view('finance/disburseDoc',$data,true); exit;
    }


    public function postdisbursedoc()
    {
        $customerId  = $this->input->post('customer_id');
        $caseId  = $this->input->post('cases_id');
        $data = [];
        $imgListUpdated = '';
        $arr=[];
        $imgListArr = [];
        $bnkId = '';
        $uploadDocList = [];
        $data['pageTitle']      = 'Loan Post Disbursal Docs';
        $data['pageType']       = 'loan';
        if(!empty($customerId)){
            $custInfo       = $this->Loan_customer_case->getCaseInfoByCaseId($caseId);
            $data['CustomerInfo']  = $custInfo[0];
            if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
            if(!empty($data['CustomerInfo']['loan_amt'])){
                 $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
              $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
            //$data['loanamt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
        }
            $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($customerId));
        }
        $docList = $this->Crm_upload_docs_list->getDocList('','9');
        foreach($docList as $key => $val)
        {
            $uploadDocList[$val['parent_id']]['name']= $val['parent_name'];
            $uploadDocList[$val['parent_id']]['is_require']= $val['is_require'];
            //echo $data['CustomerInfo']['loan_for'].'-'.$val['id'];
            $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'],'9'); 
            foreach ($sublist as $skey => $sval)
            {
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['name'] = $sval['name'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['sub_category_id'] = $sval['sub_category_id'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = $sval['is_require'];
                   
            }   
        }
        $data['uploadDocList'] = $uploadDocList;
        $i = 0;
         $imgListUpdatedpre = $this->Crm_upload_docs_list->getImageList($customerId,'','','','2',$caseId,'','96,123');
          if((!empty($imgListUpdatedpre)))
            {
                foreach ($imgListUpdatedpre as $keyI => $valI) {
                    $a['allids'][]       =   $valI['sub_id'];
                    $imgListArr[$i]['id']           =   $valI['id'];
                    $imgListArr[$i]['doc_name']     =   $valI['doc_name'];
                    $imgListArr[$i]['doc_url']      =   (($valI['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$valI['doc_url'];
                    $imgListArr[$i]['doc_type']     =   $valI['doc_type'];
                    $imgListArr[$i]['customer_id']  =   $valI['customer_id'];
                    $imgListArr[$i]['case_id']      =   $valI['case_id'];
                    $imgListArr[$i]['status']       =   $valI['status'];
                    $imgListArr[$i]['created_on']   =   $valI['created_on'];
                    $imgListArr[$i]['updated_on']   =   $valI['updated_on'];
                    $imgListArr[$i]['tag_id']       =   $valI['parent_tag_id'];
                    $imgListArr[$i]['sub_id']       =   $valI['sub_id'];
                    $imgListArr[$i]['image_id']     =   $valI['image_id'];
                    $imgListArr[$i]['imgID']        =   $valI['imgID'];
                    $imgListArr[$i]['bank_id']      =   $valI['bank_id'];
                    $imgListArr[$i]['name']         =   $valI['name'];
                    $imgListArr[$i]['parent_id']    =   $valI['parent_id'];
                    $imgListArr[$i]['err']          =   $valI['err'];
                    $i++;
                }
            }

        $imgListUpdated = $this->Crm_upload_docs_list->getImageList($customerId,'','','','9',$caseId);      
        if(!empty($imgListUpdated))
        {
            foreach($imgListUpdated as $imgK => $imgV)
            {
                $name = '';
                $bank_name = '';
                if(in_array($imgV['tag_id'], $arr))
                {
                   $imageTag = $this->Crm_upload_docs_list->getImageList('','',$imgV['tag_id'],'','9',$caseId);
                   $bankname = $this->Crm_banks->getBankNameBybnkId($imageTag[0]['bank_id']);
                   $bank_name = $imgV['name'] .' ('. $bankname['bank_name'].')';
                }

                $a['allids'][]       =   $imgV['sub_id'];
                $imgListArr[$i]['id']           =   $imgV['id'];
                $imgListArr[$i]['doc_name']     =   $imgV['doc_name'];
                $imgListArr[$i]['doc_url']      =   (($imgV['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$imgV['doc_url'];
                $imgListArr[$i]['doc_type']     =   $imgV['doc_type'];
                $imgListArr[$i]['customer_id']  =   $imgV['customer_id'];
                $imgListArr[$i]['case_id']      =   $imgV['case_id'];
                $imgListArr[$i]['status']       =   $imgV['status'];
                $imgListArr[$i]['created_on']   =   $imgV['created_on'];
                $imgListArr[$i]['updated_on']   =   $imgV['updated_on'];
                $imgListArr[$i]['tag_id']       =   $imgV['parent_tag_id'];
                $imgListArr[$i]['sub_id']       =   $imgV['sub_id'];
                $imgListArr[$i]['image_id']     =   $imgV['image_id'];
                $imgListArr[$i]['imgID']        =   $imgV['imgID'];
                $imgListArr[$i]['bank_id']      =   $imgV['bank_id'];
                $imgListArr[$i]['name']         =   !(empty($bank_name))?$bank_name:$imgV['name'];
                $imgListArr[$i]['parent_id']    =   $imgV['parent_id'];
                $imgListArr[$i]['err']          =   $imgV['err'];
                $i++;
            }
        }
        $a['allids'] = array_filter($a['allids']);

        if(!empty($a['allids']))
        {
            $sublistsss = $this->Crm_upload_docs_list->getDocList('','9','','','','',$a['allids']);

            foreach($sublistsss as $ssub => $kkk)
            {
                $b['allParentIds'][] = $kkk['parent_id'];
            }

        }
        $data['imageList'] =  $imgListArr;
        $data['allParentIds'] =  !empty($b)?$b:'';
        $data['imageList'] =  $imgListArr;
        $data['pendencyDoc'] = $this->Crm_upload_docs_list->getPendencyDetail($caseId,'9');
        $data['rolemgmt'] = $this->financeUserMgmt('','disuploadDocs');
        if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }                 
        $data['CustomerInfo']['left_amt'] = $left_amount;
        echo $datas=$this->load->view('finance/postdisbursedoc',$data,true); exit;
    }

    public function uploadLoginDocs()
    {
        //echo UPLOAD_IMAGE_PATH_LOCAL.'uploadLoginDocs/'; exit;
        $arr = $this->uri->segment(3);
        $ar  = explode('-', $arr);
        $data = [];       
        $file_name_key              = key($_FILES);
        $config['upload_path']      = UPLOAD_IMAGE_PATH_LOCAL.'uploadLoginDocs/';
        $config['allowed_types']    = ['gif', 'png', 'jpg','jpeg','pdf','tif'];
        $config['max_size']         = '8000';
        $config['max_width']        = '7000';
        $config['max_height']       = '7000';
        $config['min_width']        = '300';
        $config['min_height']       = '200';
        $config['encrypt_name']     = True;

        $this->load->library('upload', $config);
        if($this->upload->do_upload($file_name_key))
        {
            $datas = $this->upload->data();
            
            $data['doc_name'] = $datas['file_name'];
            $data['doc_url'] = 'uploadLoginDocs/'.$datas['file_name'];
            $data['doc_type'] = '1';
            if(!empty($ar['2']))
            {
                $data['doc_type'] = $ar['2'];
            }
            $data['customer_id'] = $ar['1'];
            $data['case_id'] = $ar['0'];
            $data['created_on'] = date('Y-m-d h:i:s');
            $data['created_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';

              $result = $this->Crm_upload_docs_list->insertLoginDocs($data);
              echo trim($result); exit;
 
         }
        else
        {
           echo $this->response = $this->upload->display_errors(); exit;
           $error  = array('Invalid Request!');
           echo $result = array('error' => $error, 'status' => 400); exit;
        }
       
    }
    public function deleteImg()
    {
        $data = [];
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $data['status'] = '0';
        $data['updated_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
        if(!empty($type))
        {
            $arr = explode(',', $id);
            foreach ($arr as $key => $value) 
            {
              $this->Crm_upload_docs_list->insertLoginDocs($data,$value);
              $this->addCustomerPersonnelDocs('','',$value,'','2');
            }
        }
        else
        {
            $this->addCustomerPersonnelDocs('','',$id,'','2');
            $this->Crm_upload_docs_list->insertLoginDocs($data,$id);
        }
        return true;
    }

    public function getImagedownload($caseId,$doc='1')
    {
        $this->load->library('zip');
        $data = [];
         $imgListUpdatedpre = [];
       // $doc = 1;
        $imageList = $this->Crm_upload_docs_list->getImageList('','','','',$doc,$caseId);
        if($doc=='9')       
        {       
             $imgListUpdatedpre = $this->Crm_upload_docs_list->getImageList('','','','','2',$caseId,'','96,123');       
        }
        if((!empty($imageList)) || (!empty($imgListUpdatedpre)) ){
        $id='';
            foreach($imageList as $key => $val)
            {
                $id.= $val['id'].',';
            }
            if(!empty($imgListUpdatedpre))      
            {       
                foreach($imgListUpdatedpre as $keys => $vals)       
                {       
                    $id.= $vals['id'].',';      
                }       
            }
            $newid=rtrim($id,",");
        }
        $id = $newid;
        $type = 'all';
        $data['status'] = '0';
        $data['updated_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
        if(!empty($type))
        {
            $id = trim($id,',');
            $arr = explode(',', $id);
           
            $imageName = $this->Crm_upload_docs_list->getImageList('','','','','','','','',$arr);
            $imgdata=array();
            $i = 1;
            foreach ($imageName as $key => $value) 
            {
                if(!empty($value))
                {
                    $newfname='';
                    $imgContet='';
                    $newfname = UPLOAD_IMAGE_PATH_LOCAL.'uploadLoginDocs/'.$value['doc_name'];
                    if(!empty($value['aws_url']))
                    {
                        $newfname = $value['aws_url'];
                    }
                    $imgContet=file_get_contents($newfname);
                    if(!empty($value['name'])){
                        $a = explode('.', $value['doc_name']);
                        $nam = str_replace(' ','-', $value['buyer_name']).'-'.$value['name'].'-'.$i.'.'.$a[1];
                        //$nam = $value['name'].'.'.$a[1];
                    }
                    else
                    {
                        $nam = $value['doc_name'];  
                    }
                    $imgdata[$nam] = $imgContet;
                }
                else
                {
                    echo "error"; exit;
                }
                $i++;
          }
          if(!empty($imgdata)){
          $time=time();
          $filename='files_backup_'.$time;
          $this->zip->add_data($imgdata);
          $this->zip->archive('uploadLoginDocs/'.$filename.'.zip');
          $this->zip->download($filename);
          }else{
             echo "error"; exit; 
          }

        }
        
        $this->uploadDocs($caseId);
    }
    

    public function showImagesToTag()
    {
        $customer_id = $this->input->post('customer_id');
        $case_id= $this->input->post('case_id');
       
        $doctype= $this->input->post('doctype');
        $data = [];
        $i = 0;
        $doc = '1';
        if(!empty($doctype) && ($doctype=='disburse'))
        {
            $doc = '2';
        }
        if(!empty($doctype) && ($doctype=='post'))
        {
            $doc = '9';
        }
         
        $imageList = $this->Crm_upload_docs_list->getImageList($customer_id,'','','',$doc,$case_id);
        $str = '[';
        $imgListUpdatedpre = $this->Crm_upload_docs_list->getImageList($customer_id,'','96','','2',$case_id);

          if((!empty($imgListUpdatedpre)))
            {
                foreach ($imgListUpdatedpre as $keyI => $valI) {
                    $image_type=end(explode('.',$valI['doc_name']));
                    $data[$i]['id'] = $valI['id'];
                    $data[$i]['small'] = (($valI['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$valI['doc_url'];
                    $data[$i]['big'] = (($valI['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$valI['doc_url'];
                    $data[$i]['image_type'] = $image_type;
                    $data[$i]['tag_id'] = $valI['tag_id'];
                    $i++;
                }
            }
        foreach($imageList as $key => $val)
        {
            $image_type=end(explode('.',$val['doc_name']));
            $data[$i]['id'] = $val['id'];
            $data[$i]['small'] =(($val['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$val['doc_url'];
            $data[$i]['big'] = (($val['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$val['doc_url'];
            $data[$i]['image_type'] = $image_type;
            $data[$i]['tag_id'] = $val['tag_id'];
            $i++;
        }
        echo json_encode($data); exit;
    }

    public function loanTagMapping()
    {
        error_reporting(0);
        $data = [];
        $err =[];
        $doc = '1';
        $doctype = $this->input->post('doctype');
        if(!empty($doctype) && ($doctype=='disburse'))
        {
            $doc = '2';
        }
        if(!empty($doctype) && ($doctype=='post'))
        {
            $doc = '9';
        }
        $id = $this->input->post('id');
        $customer_id = $this->input->post('customer_id');
        $case_id = $this->input->post('case_id');
        $img =  $this->input->post('ImgID');
        $tag = $this->input->post('taggID');
        $bank = $this->input->post('bank');
        $type = $this->input->post('type');
        $subcat = $this->input->post('subcat');
        $reason_id = $this->input->post('reason_id');
        if(!empty($img))
        {
             $data['image_id'] =$img;
        }
        if(!empty($tag))
        {
            $data['parent_tag_id']= $tag;
        }
        if(!empty($subcat))
        {
             $data['tag_id'] = $subcat;
        }
        if((!empty($bank)) && empty($doctype))
        {
             $data['bank_id']= $bank;
        }

        $img_detail = $this->Crm_upload_docs_list->getImageList($customer_id,$img,'','',$doc);     
        if(($type=='add') || ($type=='bank'))
        {
            $data['created_on'] = date('Y-m-d H:i:s');
            $data['created_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
            if((empty($img_detail)) && (!empty($data['tag_id'])))
            {
                $checkPendency = $this->Crm_upload_docs_list->getPendencyDetail($case_id,$doc,$data['tag_id']);
                $imageList = $this->Crm_upload_docs_list->insertTagMapping($data);
                $this->addCustomerPersonnelDocs($doc,$customer_id,$img,$tag,'',$subcat);
                if(!empty($checkPendency))
                {
                    $datass['pendency_status'] = 'Resolved';
                    $datass['status'] = '0';
                    $datass['image_id'] = $imageList;
                    $checkPendency = $this->Crm_upload_docs_list->insertPendencyMapping($datass,$checkPendency[0]['id']);
                }
                $err['msg'] = "Image Tagged Successfully"; 
                $err['status'] = "1";
                echo json_encode($err); exit;

            }
            else if($img_detail[0]['err']=='1')
            {
                $err['msg'] = "Image Marked Incorrect"; 
                $err['status'] = "0";
                echo json_encode($err); exit;
            }
            else 
            {
                $err['msg'] = "Already Tagged"; 
                $err['status'] = "0";
               echo json_encode($err); exit;  //echo $msg = "Already Tagged"; exit;
            }   
        }
        else if($type=='remove')
        {
            $data['status'] = '0';
            $data['updated_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
            if(!empty($img_detail))
            {
                $imageList = $this->Crm_upload_docs_list->insertTagMapping($data,$img_detail[0]['imgID']);
                $this->addCustomerPersonnelDocs($doc,$customer_id,$img,'','2');
                $err['msg'] = "Tagged Removed Successfully"; 
                $err['status'] = "1";
                $err['tag_id'] = $img_detail[0]['tag_id'];
                $err['parent_tag_id'] = $img_detail[0]['parent_tag_id'];
                echo json_encode($err); exit;
            }
            else
            {
                $err['msg'] = "Image is not Tagged"; 
                $err['status'] = "0";
                echo json_encode($err); exit;
            }
          
        }
        else if(($type=='markincorrect') && (!empty($reason_id)))
        {
            $imageList = '';
            $update_img_detail = $this->Crm_upload_docs_list->getImageList($customer_id,$img,'','',$doc);
            $this->addCustomerPersonnelDocs($doc,$customer_id,$img,'','1');
            $data['mark_incorrect'] = $reason_id;
            $data['tag_id'] = '';
            $data['updated_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
            $imageList = $this->Crm_upload_docs_list->insertTagMapping($data,$update_img_detail[0]['imgID']);
            $err['msg'] = "Image Mark Incorrect"; 
            $err['status'] = "0";
            echo json_encode($err); exit;
        }
        else if((empty($img_detail)) && (empty($data['tag_id'])))
        {
            // echo $msg = "Image is not Tagged"; exit;
            $err['msg'] = "Image is not Tagged"; 
            $err['status'] = "0";
           echo json_encode($err); exit;
        }
        else if((!empty($data['tag_id'])) && (!empty($img_detail)))
        {
              //echo  $msg = "Cann't Tag Image"; exit;
            $err['msg'] = "Cann't Tag Image"; 
            $err['status'] = "0";
            echo json_encode($err); exit;
        }
    }
    public function addCustomerPersonnelDocs($doc='',$customer_id='',$img,$tag='',$flag=0,$subcat='')
    {
        $data =[];
        $id='';
        $arr = explode(',', PERSONAL_DOCS);
        if(!empty($subcat))
        {
            if(in_array($subcat, $arr))
            {
               $getExistingCustomer = $this->Crm_upload_docs_list->getPersonnelDocs($customer_id,$subcat);
               if(!empty($getExistingCustomer))
               {
                    $id = $getExistingCustomer[0]['id'];
               }
               $data['image_id'] = $img;
               $data['tag_id']   = $subcat;
               $data['parent_tag_id']   = $tag;
               $data['customer_id']   = $customer_id;
               $data['doc_type'] = $doc;
               $data['status'] = '1';
               $data['updated_by'] = $this->session->userdata['userinfo']['id'];
               $this->Crm_upload_docs_list->insertPersonnelDocs($data,$id); 
            }
        }
        else if(!empty($flag))
        {
            $getExistingCustomer = $this->Crm_upload_docs_list->getPersonnelDocs($customer_id,'','',$img);
            if(!empty($getExistingCustomer))
            {
                $id = $getExistingCustomer[0]['id'];
                $data['status'] = '0';
                $this->Crm_upload_docs_list->insertPersonnelDocs($data,$id);
            }
                 
        }
    }
    public function pendencyByCatId()
    {
        //$parent = [];
        $catID = $this->input->post('catId');
        $case_id = $this->input->post('case_id');
        $doctype = $this->input->post('doctype');
        $type = $this->input->post('type');
        $sublist = '';
        $ids = [];
        $dd = [];
        $imggg = $this->Crm_upload_docs_list->getImageList('','','','',$doctype,$case_id);
        $update_img_detail = $this->Crm_upload_docs_list->getPendencyDetail($case_id,$doctype);
        foreach ($update_img_detail as $key => $value)
        {
            if($value['doc_id']>0)
            {
                 $ids[] = $value['doc_id'];
            }
         
        }
        if($type=='getcategoryId')
        {
            if(!empty($imggg))
            {
                if($doctype=='1')
                {
                    foreach ($imggg as $k => $v) {
                        if(($v['tag_id']=='1'))
                        {
                           $dd[] = $v['tag_id'];
                        }
                        else if(!empty($v['parent_id']))
                        {
                            $ids[] = $v['parent_id'];
                        }
                    }
                    if((in_array('1', $dd)) && (in_array('2', $dd)))
                        {
                            $ids[] = '1';
                        }
                }
                else
                {
                    foreach ($imggg as $k => $v) {
                       /* if(($v['tag_id']=='64')||($v['tag_id']=='129') || ($v['tag_id']=='135')||($v['tag_id']=='136'))
                        {
                           $dd[] = $v['tag_id'];
                           $ids[] =  $v['tag_id'];
                        }
                        else*/ if(!empty($v['parent_id']))
                        {
                            $ids[] = $v['parent_id'];
                        }
                    }
                    /*if((in_array('64', $dd)) && (in_array('129', $dd)))
                        {
                            $ids[] = '63';
                        }
                        if((in_array('135', $dd)) && (in_array('136', $dd)))
                        {
                            $ids[] = '69';
                        }*/
                }
            }
            $sublist = $this->Crm_upload_docs_list->getCategoryList($ids,$doctype); 
            $str = "<option value=''>Select Category</option>";
            foreach($sublist as $key => $val)
            {
                if($val['is_required']=='1')
                {
                    $prntName = $val['parent_name'].' *';
                }
                else
                {
                    $prntName = $val['parent_name']; 
                }
                $str .="<option value=".$val['id'].">$prntName</option>";
            }
            echo $str; exit;
        }
        else
        {
            $sublist = $this->Crm_upload_docs_list->getSubCategoryList($catID,$ids); 
            $str = "<option value=''>Select Pendency Doc</option>";
            foreach($sublist as $key => $val)
            {
                if($val['is_require']=='1')
                {
                    $sName = $val['name'].' *';
                }
                else
                {
                    $sName = $val['name']; 
                }
                $str .="<option value=".$val['sub_category_id'].">$sName</option>";
            }
            echo $str; exit;
        }
    }

    public function addPendencyDoc()
    {
        $data = [];
        $datas = [];
        $case_id = $this->input->post('case_id');
        $doctype = $this->input->post('doctype');
        $pendencyId = $this->input->post('pendencyId');
        $category_id = $this->input->post('category_id');
        //$pendencyName = $this->input->post('pendencyName');
        $update_img_detail = $this->Crm_upload_docs_list->getImageList('','',$pendencyId,'',$doctype,$case_id);
        if(!empty($update_img_detail))
        {
            $datas['is_pendency'] = '1';
            $imageList = $this->Crm_upload_docs_list->insertTagMapping($datas,$update_img_detail[0]['imgID']);
        }
        $checkPendency = $this->Crm_upload_docs_list->getPendencyDetail($case_id,$doctype,$pendencyId);
        if(empty($checkPendency))
        {

            $data['case_id'] = $case_id;
            $data['doc_type'] = $doctype;
            $data['pendency_doc_id'] = $pendencyId;
            $data['pendency_status'] = 'Active';
            $checkPendency = $this->Crm_upload_docs_list->insertPendencyMapping($data);
            if(!empty($checkPendency))
            {
                $err['msg'] = $category_id;
                $err['status'] = '1';
            }
        }
        else
        {
            $err['msg'] = 'Already Exists.';
            $err['status'] = '0';
        }
        echo json_encode($err); exit;
    }

public function getLoanLimit($LoanAmt="",$CaseId="",$BankId="",$flag=0)
{
    $err = [];
    $emplimit =0;
    if($flag>0)
    {
        $loan_amt = (int)($LoanAmt);
        $case_id  = $CaseId;
        $bank_id  = $BankId;   
    }
    else
    {
        $loan_amt = (int)($this->input->post('loanAmt'));
        $case_id  = $this->input->post('case_id');
        $bank_id  = $this->input->post('bank');
    }   
    $caseInfo = $this->Loan_customer_case->getCaseInfoByCaseId($case_id);
    $emp_id   =  $caseInfo[0]['meet_the_customer'];
    $loanAmt = 0;
    if($emp_id=='1')
    {
        $getTotalBankLimit = $this->Crm_banks->getBankInfo($BankId);  
        $totalLimit =!empty($getTotalBankLimit[0]['amount_limit'])?$getTotalBankLimit[0]['amount_limit']:0;
        $totalLimitAssigned = $this->Crm_banks->getEmpBankInfo('',$BankId);
        $sum = 0;
        if(!empty($totalLimitAssigned))
        {
            foreach ($totalLimitAssigned as $key => $value)
            {
               $sum = (int)$value['emp_limit'];
            }
             
        }
        $remainglimit = (int)$totalLimit - (int)$sum;
        if($remainglimit>=$loan_amt)
        {
            $err['status'] = '1';
            $err['message'] = 'Limit Remaining for this Bank is : '. $remainglimit;
        }else
        {
            $err['status'] = '0';
            $err['message'] = 'Limit Exceeded for this Bank';
        }
         if($flag=='1')
        {
            return $err;
        }
        else
        {
            echo json_encode($err); exit;
        }
    }
    $loanLimit = $this->Loan_customer_case->checkLoanAmount($emp_id,$bank_id);
    if(!empty($loanLimit))
    {
        $emplimit = (int)$loanLimit[0]['emp_limit'];  
    }   
    $overAllEmpLimit = $this->Loan_customer_case->checkOverAllLimitByEmpId($emp_id,$bank_id);
    $empAssignLimit  = $this->Loan_customer_info->getBankMappingByEmployeeId($emp_id,$bank_id);
    $overall = 0;
    
    if (!empty($overAllEmpLimit))
    {
        foreach ($overAllEmpLimit as $key => $value) 
        {
            if(empty($value['approved_loan_amt']))
            {
                $overall = $overall+$value['file_loan_amount'];
            }
            else
            {
                $overall = $overall+$value['approved_loan_amt'];
            }
        }
    }
    
    $limit = $emplimit - $overall; 
    if(!empty($loan_amt))
    {
        if(($emplimit>=$loan_amt) && ($emplimit>=$overall))
        {
            $limits = (int)$limit - (int)$loan_amt;
            $err['status'] = '1';
            $err['message'] = 'Limit Remaining for this Bank is : '. $limits;
        }
        else
        {   
           // $limit - $loan_amt;
            $err['status'] = '0';
            $err['message'] = 'Limit Exceeded for this Bank';
        }
    }
    if($flag=='1')
    {
        return $err;
    }
    else
    {
        echo json_encode($err); exit;
    }
}
    
    public function saveLoginDocs()
    {
        $err = [];
        $bank = [];
        $req_id = [];
        $req = [];
        $caseInfo = [];
        $tagArr = [];
        $req_sid = [];
        $customer_id = $this->input->post('customer_id');
        $case_id = $this->input->post('case_id');
        $arr =  $this->Loan_customer_case->getCaseInfoByCaseId($case_id);
        $arrCustomer = $arr[0];
        $doctype = $this->input->post('doctype');
        $imageList = $this->Crm_upload_docs_list->getImageList($customer_id,"","","",$doctype,$case_id);
        $custInfo       = $this->Loan_customer_case->getCaseInfoByCaseId($case_id);
        $CustomerInfo  = $custInfo[0];
        $ar = [];
        
        $ar = ['8','10','61','12','14','15','16','45','46','54'];
        
        $ar2 = [];
        if($arrCustomer['case_field']=='1')
        {
               $ar2 = ['16','17','24','28','41'];
        }

        $checkPendency = $this->Crm_upload_docs_list->getPendencyDetail($case_id,$doctype);
       /* echo "<pre>";
        print_r($checkPendency);
        exit;*/
        $docList = $this->Crm_upload_docs_list->getDocList('0',$doctype);
        
        if(!empty($checkPendency))
        {
            foreach($checkPendency as $pkey => $pval)
            {
                $penTagId[] = $pval['pendency_doc_id'];
            }
        } 
        foreach($imageList as $imgk => $imgv)
        {
            if($imgv['err']=='1')
            {
                $results= array('status'=>'False','message'=>'Please Resolve Incorrect Docs');
                echo json_encode($results); exit;
            }
            if($imgv['tag_id']=='42')
            {
               $tagArr[] = '7'; 
            }
            $tagArr[] = $imgv['tag_id'];
            $bank[] = $imgv['bank_id'];
        }
        if(!empty($penTagId)){
            foreach($penTagId as $pk => $pv)
            {   
                if(!empty($tagArr))
                {
                    array_push($tagArr,$pv);
                }
                else
                {
                    $tagArr[]=$pv;   
                }
            }
        }
        /*echo "<pre>";
        print_r($docList);
        exit;*/
       
            foreach($docList as $key => $val)
            {
                if(($val['is_require']>0) || (($val['parent_id']=='8') && ($CustomerInfo['co_applicant']=='1') && ($doctype=='1')))
                {
                    //echo "fefe".'----'.$val['id'];
                    $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'],$doctype); 
                    foreach ($sublist as $skey => $sval)
                    {
                        $uploadDocList['name'] = $sval['name'];
                        if($sval['is_require']>0)
                        {
                            $req_sid[$val['parent_id']][]=$sval['sub_category_id'];
                        }
                        else if(($val['parent_id']=='8') && ($CustomerInfo['co_applicant']=='1') && ($doctype=='1'))
                            {
                               $req_sid[$val['parent_id']][]=$sval['sub_category_id'];
                            } 
                                       
                    }   //
                }               
                else if(($val['parent_id']=='2') && ($doctype=='1') && ($CustomerInfo['loan_for']=='2'))
                {
                   $req_sid['2'][]='42';
                }   
                if(($doctype=='2') && ($CustomerInfo['loan_for']=='1'))
                {
                   // $req_sid['12'][]='210';
                }
                else if($doctype>'2')
                {
                    //echo "ffff"; exit;
                   unset($req_sid);
                }
                
            }
           
            if($doctype == '1'){
            $pendingIds ='';
            $flag = '1';
            $a= '1';
            $counter = 1;
            foreach ($ar as $ars) 
            {
                if(in_array($ars, $tagArr))
                    {
                       $a=0;
                    }
            }
            if($a==0)
            {
                foreach ($ar2 as $ars2) 
                {
                    if(in_array($ars2, $tagArr))
                        {
                           $counter++;
                        }
                }
            }
            else
            {
                  $pendingIds = '8,';
            } 
           if(($a==0) && (($counter>2) || ($arrCustomer['case_field']>='2')))
             {
                $flag=0;
             }
            else 
            {
                if($arrCustomer['case_field']=='1')
                {
                    $pendingIds .= '16,17,';
                }
            }
        }
            foreach($req_sid as $rkey => $rval)
            {
                foreach($rval as $kr)
                {
                    if(!in_array($kr, $tagArr))
                    {
                        $pendingIds .= $kr.',';
                    }
                }
            }
            $pendingId = rtrim($pendingIds,',');
            if(!empty($pendingId))
            {
                $pend = explode(',', $pendingId);
                $cn = $this->Crm_upload_docs_list->getDocList('',$doctype,'','','','',$pend); 
                foreach($cn as $ck => $cv)
                {
                    $catlist .= $cv['parent_name'].' - '. $cv['name'].', ';   
                }
                $pendingList = rtrim($catlist,',');
                $results= array('status'=>'False','message'=>$pendingList);
                echo json_encode($results); exit;
            }
            if($doctype=='1')
            {
                $caseInfo['upload_login_doc_flag']='1';
                $caseInfo['upload_login_update_date']=date('Y-m-d H:i:s');
                if($arrCustomer['upload_docs_created_at']=='0000-00-00 00:00:00')
                {
                    $caseInfo['loan_approval_status'] = '7';
                    $caseInfo['upload_docs_created_at']=date('Y-m-d H:i:s');
                }
                $caseInfo['last_updated_date'] = date('Y-m-d H:i:s');
                $aaa = $this->Loan_customer_case->saveUpdateCaseInfo($caseInfo, $case_id,'1');
                $document = "Login Document Uploaded";
                if(!empty($checkPendency))
                {
                    $document = "Login Upload Docs with Pendency";
                }
                $this->addLoanHistoryUpdateLog($case_id,'-',$document,'','0');
                $this->addLoanHistory($case_id,$document,'-','','-','',$this->session->userdata['userinfo']['id']);
                //$lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($dataed, $case_id,'1');
                if((empty($flag)) || ($flag=='0')){
                $results= array('status'=>'True','message'=>'Docs uploaded Successfully','Action'=>  base_url().'loanFileLogin/' . base64_encode('CustomerId_' .$case_id));
                }
                else
                {
                    $results= array('status'=>'False','message'=>'Please upload all required Doc');
                        echo json_encode($results); exit;
                }
            }
            if($doctype=='2')
            {
                $caseInfo['upload_dis_doc_flag']='1';
                $caseInfo['upload_disburse_doc_update']=date('Y-m-d H:i:s');
                if($arrCustomer['upload_dis_created_date']=='0000-00-00 00:00:00')
                {
                    //$caseInfo['loan_approval_status'] = '8';
                    $caseInfo['upload_dis_created_date']=date('Y-m-d H:i:s');
                }
                $caseInfo['last_updated_date'] = date('Y-m-d H:i:s');
                $aaa = $this->Loan_customer_case->saveUpdateCaseInfo($caseInfo, $case_id,'1');
                $document = "Disbursal Document Uploaded";
                if(!empty($checkPendency))
                {
                    $document = "Disbursal Upload Docs with Pendency";
                }
                $this->addLoanHistoryUpdateLog($case_id,'-',$document,'','0');
                $this->addLoanHistory($case_id,$document,'-','','-','',$this->session->userdata['userinfo']['id']);
               
                //$lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($dataed, $case_id);

            $results= array('status'=>'True','message'=>$updateFile .' Docs uploaded Successfully','Action'=>  base_url().'disbursalDetails/' . base64_encode('CustomerId_' . $case_id));
                
            }
            if($doctype=='9')
            {
                $caseInfo['upload_post_doc_flag']='1';
                $caseInfo['upload_post_updated_at']=date('Y-m-d H:i:s');
                if($arrCustomer['upload_post_created_at']=='0000-00-00 00:00:00')
                {
                    $caseInfo['loan_approval_status'] = '8';
                    $caseInfo['upload_post_created_at']=date('Y-m-d H:i:s');
                }
                $caseInfo['last_updated_date'] = date('Y-m-d H:i:s');
                $aaa = $this->Loan_customer_case->saveUpdateCaseInfo($caseInfo, $case_id,'1');
                $document = "Post Disbursal Document Uploaded";
                if(!empty($checkPendency))
                {
                    $document = "Post Disbursal Upload Docs with Pendency";
                }
                $this->addLoanHistoryUpdateLog($case_id,'-',$document,'','0');
                $this->addLoanHistory($case_id,$document,'-','','-','',$this->session->userdata['userinfo']['id']);
               
                //$lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($dataed, $case_id);
            if(($this->session->userdata['userinfo']['is_admin'] == 1)  || ($this->session->userdata['userinfo']['team_name'] == "Loan" && $this->session->userdata['userinfo']['role_name'] == "Accountant"))
               $action = base_url().'loanpayment/'.base64_encode('CustomerId_' . $case_id);
            else
                 $action = base_url().'loanListing/';

            $results= array('status'=>'True','message'=>$updateFile .' Docs uploaded Successfully','Action'=>  $action);
                
            }
          
        echo json_encode($results); exit;
    }

    public function addUpdateMasterCustomers($params,$id="")
    {
        $data = [];
       // $checkIfExist = $this->Loan_customer_info->getMasterCustomerDetails($id);
        if(isset($params['customer_id']))
        {
            $data['customer_id'] = $params['customer_id'];
        }
        if(isset($params['buyer_type']) && ($params['buyer_type']=='1'))
        {
            $data['name_type'] = '1';
           if(isset($params['name']))
            {
                $data['company_name'] = $params['name'];
            } 
        }
        else
        {
            $data['name_type'] = '2';
            if(isset($params['name']))
            {
                $data['customer_name'] = $params['name'];
            }
        }
        if(isset($params['email']))
        {
            $data['customer_email'] = $params['email'];
        }
        if(isset($params['gender']))
        {
            $data['customer_gender'] = $params['gender'];
        }
        if(isset($params['martial_status']))
        {
            $data['customer_martial_status'] = $params['martial_status'];
        }
        if(isset($params['dob']))
        {
            $data['customer_dob'] = date('Y-m-d',strtotime($params['dob']));
        }

        if(isset($params['date_of_incorporation']))
        {
            $data['date_of_incorporation'] = date('Y-m-d',strtotime($params['date_of_incorporation']));
        }
        if(isset($params['pan_number']))
        {
            $data['customer_pan_no'] = $params['pan_number'];
        }
        if(isset($params['aadhar_no']))
        {
            $data['customer_aadhar_no'] = $params['aadhar_no'];
        }
        if(isset($params['father_name']))
        {
            $data['customer_father_name'] = $params['father_name'];
        }
        if(isset($params['mother_name']))
        {
            $data['customer_mother_name'] = $params['mother_name'];
        }
        if(isset($params['residance_type']))
        {
            $data['residence_type_id'] = $params['residance_type'];
        }
        if(isset($params['residence_address']))
        {
            $data['address'] = $params['residence_address'];
        }
        if(isset($params['residence_state']))
        {
            $data['state_id'] = $params['residence_state'];
        }
        if(isset($params['residence_city']))
        {
            $data['city_id'] = $params['residence_city'];
        }
        if(isset($params['residence_pincode']))
        {
            $data['pincode'] = $params['residence_pincode'];
        }
        if(isset($params['residence_phone']))
        {
            $data['residence_phone'] = $params['residence_phone'];
        }
        $data['last_updated_by_module'] = 'loan';
        if($id=='')
        {
            $data['created_on']  = date('Y-m-d H:i:s');
            $data['created_by_module'] = 'loan';
            $this->Loan_customer_info->updateMasterCustomerDetails($data);
        }
        else
        {
            $this->Loan_customer_info->updateMasterCustomerDetails($data,$id); 
        }

        return true;
    }

    public function loanListing($type="")
    {
        $data = $datapost = [];
        if(!empty($type))
        {
            $data['type']  = $type;
        }
        $pages                  =   1;
        $data['page'] = 1;
        $data['limit']                 =   10;
        $data['pageTitle'] = 'Loan Listing';
        $data['employeeList']   =  $this->Crm_user->getEmployee('2');
        $data['fileTags'] = $this->Loan_customer_case->fileLoginTags();
        $data['rolemgmt'] = $this->financeUserMgmt();
        $data['title'] = 'Loan Listing';
        $datapost = $this->input->post();
        if(empty($datapost['dashboard'])){            
          $datapost['dashboard']=$type;        
        }
        if(!empty($datapost)){  
           $ajax_type = trim($this->input->post('ajax_type'));
        }
        $datapost['is_count']=0;
        $caseInfoAll = $loanId = [];
        $role_name = $this->session->userdata['userinfo']['role_name'];
        $user_id = $this->session->userdata['userinfo']['id'];
        $datapost['role_name'] = $role_name;
        $datapost['user_id'] = $user_id;
        $caseInfo   = $caseInfoAll =  $this->Loan_customer_case->getAllCaseInfo($datapost);
        $datapost['is_count']=1;
        $caseInfoCount  =  $this->Loan_customer_case->getAllCaseInfo($datapost);
        $data['loan_listing'] = $caseInfo;
        $data['loan_tags'] = $this->Loan_customer_case->getFileTags();
        $data['loan_list_id'] = $loanId;
        $data['total_count']  = $caseInfoCount;
        if(isset($datapost['export']) && $datapost['export'] == 'export'){
        $filename = 'Loan_cases_'.date('dM').'.xls';
        $datapost['export']=1;
        $datapost['is_count']=0;
        $caseInfoAll =  $this->Loan_customer_case->getAllCaseInfo($datapost);
        //echo "<pre>";print_r($getLeads['leads']);die;

        exportLoanData($caseInfoAll,$filename);    
        }
    
        if( $ajax_type == 1){
           echo $datas=$this->load->view('finance/loanCasesListing',$data,true); exit;}
        else{
           $this->loadViews("finance/loanListing", $data); 
        }
    }

    public function loanListingCase()
    {
        error_reporting(0);
        //$pages                  =   1;
        $datapost = $this->input->post();
        $searchbyval    = trim($this->input->post('searchbyval'));
        $searchbyvaldealer    = trim($this->input->post('searchbyvaldealer'));
        $searchbyvalbank    = trim($this->input->post('searchbyvalbank'));
        $searchby       = trim($this->input->post('searchby'));
        $loan_source    = trim($this->input->post('loan_source'));
        $loan_status    = trim($this->input->post('loan_status'));
        $searchdate     = trim($this->input->post('searchdate'));
        $daterange_to   = trim($this->input->post('daterange_to'));
        $daterange_from = trim($this->input->post('daterange_from'));
        $status         = trim($this->input->post('status'));
        $assignedto     = trim($this->input->post('assignedto'));
        $pages          = trim($this->input->post('page'));
        $dashboard      = trim($this->input->post('dashboard'));
        $data['limit']                 =   10;
        $caseInfoAll = [];
        $loanId = [];
        $role_name = $this->session->userdata['userinfo']['role_name'];
        $user_id = $this->session->userdata['userinfo']['id'];
        $caseInfo   =  $this->Loan_customer_case->getAllCaseInfo($searchbyval,$searchbyvaldealer,$searchby,$loan_source,$loan_status,$searchdate,$daterange_to,$daterange_from,$status,$assignedto,$pages,$dashboard,$role_name,$user_id,$searchbyvalbank);
        $caseInfoCount  =  $this->Loan_customer_case->getAllCaseInfoCount($searchbyval,$searchbyvaldealer,$searchby,$loan_source,$loan_status,$searchdate,$daterange_to,$daterange_from,$status,$assignedto,$pages,$dashboard,$role_name,$user_id,$searchbyvalbank);
        /*echo "<pre>";
        print_r($caseInfo);
        exit;*/
        foreach ($caseInfo as $key => $value) 
        {
            if($value['customer_loan_id']>0){
            $loanId[] = $value['customer_loan_id'];
             $caseInfoAll[$value['customer_loan_id']]['sr_no'] = $value['sr_no'];
            $checkPendency = $this->Crm_upload_docs_list->getPendencyDetail($value['customer_loan_id']);
            $caseInfoAll[$value['customer_loan_id']]['pendency'] = count($checkPendency);
            $caseInfoAll[$value['customer_loan_id']]['customerid'] = $value['customer_id'];
            $caseInfoAll[$value['customer_loan_id']]['loanid'] = $value['customer_loan_id'];
            $caseInfoAll[$value['customer_loan_id']]['customer_name'] = ucwords(strtolower($value['name']));
            $caseInfoAll[$value['customer_loan_id']]['customer_mobile'] = $value['customer_mobile'];
            $caseInfoAll[$value['customer_loan_id']]['customer_email']  = $value['email'];
            $caseInfoAll[$value['customer_loan_id']]['customer_address'] = $value['residence_address'];
            $caseInfoAll[$value['customer_loan_id']]['customer_city'] = $value['customer_city']; 
            $caseInfoAll[$value['customer_loan_id']]['case_type'] = $value['loan_type'];  
             $caseInfoAll[$value['customer_loan_id']]['reff_id'] = !empty($value['ref_id'])?$value['ref_id']:'NA';                      
            $caseInfoAll[$value['customer_loan_id']]['customer_created_on'] = date('d M, Y',strtotime($value['customer_created_on']));
            $this->IND_money_format($value['file_loan_amount']);
            $caseInfoAll[$value['customer_loan_id']]['make'] = $value['make_name'];
            $caseInfoAll[$value['customer_loan_id']]['model'] = $value['model_name'];
            $caseInfoAll[$value['customer_loan_id']]['version'] = $value['version_name']; 
            $caseInfoAll[$value['customer_loan_id']]['regno'] = strtoupper($value['regno']); 
            $caseInfoAll[$value['customer_loan_id']]['regyear'] = $value['reg_year']; 
            $caseInfoAll[$value['customer_loan_id']]['cartype'] = ($value['loan_for']=='2')?'Used Car':'New Car'; 
            $caseInfoAll[$value['customer_loan_id']]['priority'] = $value['priority'];
            $caseInfoAll[$value['customer_loan_id']]['file_loan_amount'] = $this->IND_money_format($value['file_loan_amount']);
            $caseInfoAll[$value['customer_loan_id']]['file_tenure'] = $value['file_tenure'];
            $caseInfoAll[$value['customer_loan_id']]['file_roi'] = $value['file_roi'];
             $caseInfoAll[$value['customer_loan_id']]['disbursed_amount'] = $this->IND_money_format($value['disbursed_amount']);
            $caseInfoAll[$value['customer_loan_id']]['disbursed_tenure'] = $value['disbursed_tenure'];
            $caseInfoAll[$value['customer_loan_id']]['disbursed_roi'] = $value['disbursed_roi'];
            $caseInfoAll[$value['customer_loan_id']]['valuation_status'] = $value['valuation_status'];
            $caseInfoAll[$value['customer_loan_id']]['cpv_status'] = $value['cpv_status'];
            $caseInfoAll[$value['customer_loan_id']]['approved_loan_amt'] = $this->IND_money_format($value['approved_loan_amt']);
            $caseInfoAll[$value['customer_loan_id']]['approved_tenure'] = $value['approved_tenure'];
            $caseInfoAll[$value['customer_loan_id']]['approved_roi'] = $value['approved_roi'];
            $caseInfoAll[$value['customer_loan_id']]['approved_emi'] = $value['approved_emi'];
            $caseInfoAll[$value['customer_loan_id']]['file_login_date'] = $value['file_login_date'];
            $caseInfoAll[$value['customer_loan_id']]['approved_date'] = $value['approved_date'];
            $caseInfoAll[$value['customer_loan_id']]['rejected_date'] = $value['rejected_date'];
            $caseInfoAll[$value['customer_loan_id']]['disbursed_date'] = $value['disbursed_date'];
            $caseInfoAll[$value['customer_loan_id']]['sales_exe'] = ($value['meet_the_customer']=='1')?'Self':$value['sales_exe']; 
            $caseInfoAll[$value['customer_loan_id']]['myear'] = $value['myear']; 
            if($value['loan_approval_status']>'5')
            {
                $tagStatus = $this->Loan_customer_case->getFileTagName($value['loan_approval_status']);
                $caseInfoAll[$value['customer_loan_id']]['file_tag'] = $tagStatus[0]['file_tag'];
                $caseInfoAll[$value['customer_loan_id']]['tag_flag'] = $value['loan_approval_status'];
            }
            else
            {
                $caseInfoAll[$value['customer_loan_id']]['file_tag'] = $value['file_tag'];
                $caseInfoAll[$value['customer_loan_id']]['tag_flag'] = $value['tag_flag'];
            }
            $caseInfoAll[$value['customer_loan_id']]['loan_approval_status'] = $value['loan_approval_status'];
            if($value['loan_approval_status']=='11')
            {
               $paydate =   $this->Loan_customer_case->selectLoanPartpayment('','','',$value['customer_loan_id'],'1'); 
            }
            $caseInfoAll[$value['customer_loan_id']]['payment_dates'] = $paydate[0]['created_date'];
            $caseInfoAll[$value['customer_loan_id']]['cancel_date'] = $value['cancel_date'];
            $caseInfoAll[$value['customer_loan_id']]['created_date'] = $value['created_date'];
            $caseInfoAll[$value['customer_loan_id']]['bank_name'] = $value['financer_name'];
            if($value['upload_login_doc_flag']=='1')
            {
                $caseInfoAll[$value['customer_loan_id']]['upload_docs_created_at'] = $value['upload_docs_created_at'];
            }
            if($value['upload_dis_doc_flag']=='1')
            {
                $caseInfoAll[$value['customer_loan_id']]['upload_dis_created_date'] = $value['upload_dis_created_date'];
            }
           

            $caseInfoAll[$value['customer_loan_id']]['source'] = ($value['source_type']=='1')?'Dealer':'InHouse';
            $dealerId = $this->Crm_dealers->getDealers($value['dealer_id'],'0,1,2');
            $caseInfoAll[$value['customer_loan_id']]['dealer_detail'] = $dealerId[0]['organization'];
            $empInfo = $this->Crm_user->getEmployee('',$value['assign_case_to']);
            $caseInfoAll[$value['customer_loan_id']]['assigned_to'] = (!empty($empInfo[0]))?$empInfo[0]['name']:'';
            $uploadLogDocs = $this->Crm_upload_docs_list->getImageList($value['customer_id'],"","","",1,$value['customer_loan_id']);
            $uploadDisDocs = $this->Crm_upload_docs_list->getImageList($value['customer_id'],"","","",2,$value['customer_loan_id']);
            
            $link = ((!empty($value["instrument_type"]))? base_url('leadDetails/').base64_encode('CustomerId_'.$value["customer_loan_id"]):''); 
            if(empty($link)){
             $link = ((!empty($value["upload_dis_doc_flag"]) && ($value["upload_dis_doc_flag"]=='1'))? base_url('postDeliveryDetails/').base64_encode('CustomerId_'.$value["customer_loan_id"]):'');
            }
            if(empty($link)){
             $link = ((!empty($value["invoice_no"]))? base_url('paymentDetails/').base64_encode('CustomerId_'.$value["customer_loan_id"]):'');
            }
            if(empty($link)){
              $link = ((!empty($value["tag_flag"]) && ($value["tag_flag"]=='4'))? base_url('uploadDocs/').base64_encode('CustomerId_'.$value["customer_loan_id"]).'/dis':''); 
            }
            if(empty($link)){
                //echo $value["tag_flag"];
            $link = ((!empty($value["file_tag"]) && (($value["tag_flag"]=='2') || $value["tag_flag"]=='4'))? base_url('disbursalDetails/').base64_encode('CustomerId_'.$value["customer_loan_id"]):'');
            }
            if(empty($link) && (($value['cpv_status']!='2') && ($value['cpv_status']!='0') ))
            {
                $link = ((!empty($value["file_tag"]) && (!empty($value['cpvstatus']) && ($value['cpvstatus']>0) ))? base_url('decisionDetails/').base64_encode('CustomerId_'.$value["customer_loan_id"]):'');
            }
            if(empty($link))
            {

                $link =((!empty($value["file_tag"]) && ($value["tag_flag"]=='1'))? base_url('cpvDetails/').base64_encode('CustomerId_'.$value["customer_loan_id"]):''); 
            }
            if(empty($link))
            {
                $link = ((!empty($value["customer_id"]) && ($value["tag_flag"]=='5') && !empty($value["ref_name_one"]))? base_url('loanFileLogin/').base64_encode('CustomerId_'.$value["customer_loan_id"]):''); 
            }
            if(empty($link))
            {
                $link = ((!empty($value["customer_id"]) && !empty($value["ref_name_one"]))? base_url('loanFileLogin/').base64_encode('CustomerId_'.$value["customer_loan_id"]):''); 
            }

            if(empty($link))
            {
                $link = ((!empty($value["customer_id"])&& !empty($value["ref_name_one"]))? base_url('refrenceDetails/').base64_encode('CustomerId_'.$value["customer_loan_id"]):''); 
            }
            if(empty($link))
            {
                $link = ((!empty($value["customer_id"]) && !empty($value["residence_pincode"])) ? base_url('residentialInfo/').base64_encode('CustomerId_'.$value["customer_loan_id"]):'');
            }
            if(empty($link))
            {
                $link = ((!empty($value["customer_id"]) && !empty($value["loan_amt"]))? base_url('loanExpected/').base64_encode('CustomerId_'.$value["customer_loan_id"]):''); 
            }
            if(empty($link))
            {
                $link = ((!empty($value["customer_id"]) && !empty($value["highest_education"])) ? base_url('financeAcedmic/').base64_encode('CustomerId_'.$value["customer_loan_id"]):''); 
            }
            if(empty($link))
            {
                $link = ((!empty($value["customer_id"]) && !empty($value["pan_number"]))? base_url('personalDetail/').base64_encode('CustomerId_'.$value["customer_loan_id"]):''); 
            }
            if(empty($link))
            {
                $link = (!empty($value["customer_id"])? base_url('leadDetails/').base64_encode('CustomerId_'.$value["customer_loan_id"]):'#');
            }
            $caseInfoAll[$value['customer_loan_id']]['link'] =  $link;
        }
         $data['page'] =(!empty($pages)) ? $pages :1;
        $data['loan_listing'] = $caseInfoAll;
        $data['loan_list_id'] = $loanId;
        $data['total_count']  = $caseInfoCount;

    }
  //  echo "<pre>";
//print_r($data); exit;
        echo $datas=$this->load->view('finance/loanCasesListing',$data,true); exit;
    }

    public function getCustomerDetails($mobile="",$customerId="",$flag='')
    {
        $params = [];
        if(empty($mobile))
        {
            $mobiles = $this->input->post('mobile');
            if(!empty($mobiles))
            {
                $params['mobile'] = $mobiles;
                $customerId = $this->Leadmodel->BuyLeadCustomer($params);
            }
        }
        else if(!empty($mobile))
        {
            $params['mobile'] = $mobile;
            $customerId = $this->Leadmodel->BuyLeadCustomer($params);  
        }
        if(!empty($customerId))
        {
            //echo $customerId.'--------'; 
           $result = $this->Loan_customer_info->getMasterCustomerDetails($customerId);
        }
        if($flag>0)
        {
            return $result;
        }
        if(!empty($result))
        {
            echo json_encode($result[0]); exit;
        }
        else
        {
            echo json_encode($result); exit;
        }
    }

    public function getTagName()
    {
        $arr        = ['1','2','3','4','5','6'];
        $tagid      = $this->input->post('tagid');
        $caseid     = $this->input->post('case_id');
        $imag_id    = $this->input->post('imag_id');
        $doctype    = $this->input->post('doctype');
        $errImg= "";
        if(!empty($imag_id))
        {
            $imageTags = $this->Crm_upload_docs_list->getImageList('',$imag_id,'','','',$caseid);
            //$imgListUpdatedpre = $this->Crm_upload_docs_list->getImageList('','','96','','2',$caseId);
            if(!empty($imageTags))
            {
                if($imageTags[0]['err']>0)
                {
                    $errImg = ($imageTags[0]['err']==1)?'Incorrect Doc':'Unclear Image';
                    echo json_encode($errImg); exit;
                }
                if(in_array($imageTags[0]['tag_id'], $arr))
                {
                   $imageTag = $this->Crm_upload_docs_list->getImageList('','',$imageTags[0]['tag_id'],'',$doctype,$caseid);
                   $bankname = $this->Crm_banks->getBankNameBybnkId($imageTag[0]['bank_id']);
                   $bank_name = $imageTag[0]['name'] .' ( '. $bankname['bank_name'].' )';
                   echo json_encode($bank_name); exit;
                }
                echo json_encode($imageTags[0]['name']); exit;
            }
        }
        else if($tagid>0)
        {
            $tagName = $this->Crm_upload_docs_list->getTagNameById($tagid);
            $imTag = $this->Crm_upload_docs_list->getImageList('','',$tagid,'',$doctype,$caseid);
            /*echo "<pre>";
            print_r($imTag);
            exit;*/
            if(!empty($imTag))
            {
                if(in_array($tagName[0]['id'], $arr))
                {
                    $imageTagss = $this->Crm_upload_docs_list->getImageList('','',$tagName[0]['id'],'',$doctype,$caseid);
                    $bankname = $this->Crm_banks->getBankNameBybnkId($imageTagss[0]['bank_id']);
                    $bank_name = $tagName[0]['name'] .' ( '. $bankname['bank_name'].' )';
                    echo json_encode($bank_name); exit;
                }
              echo json_encode($tagName[0]['name']); exit;
            }
        }
        echo json_encode(''); exit;
    }

    public function getDealerList()
    {
        $status = $this->input->post('status');
        $str = '';

        $dealerList = $this->Crm_dealers->getDealers('','0,1,2','',$status);

        $str  = "<option value=''>Select Dealership</option>";
        foreach ($dealerList as $dkey => $dval) 
        {
            $str .="<option value='" .$dval['id']. "'>" . $dval['organization'] . "</option>";
        }
        echo $str; exit;
    }

    public function populateWashoutReason($typeId='')
    {
        $washoutReason = array();
        $washoutReason[1][1] = 'Customer declined';
        $washoutReason[1][2] = 'Lost to other channel';
        $washoutReason[1][3] = 'Lost to other bank';
        $washoutReason[1][4] = 'Dealer declined';
        $washoutReason[1][5] = 'Others';
        $washoutReason[2][6] = 'Poor Credit - CIBIL issue';
        $washoutReason[2][7] = 'Poor Credit - AL Defaulter';
        $washoutReason[2][8] = 'Income Eligibility';
        $washoutReason[2][9] = 'Required Docs not provided';
        $washoutReason[2][10] = 'Address issues (Contactibility)';
        $washoutReason[2][11] = 'Others';
        $washoutReason[3][12] = 'Blacklisted vehicle';
        $washoutReason[3][13] = 'Transfer Docs not available';
        $washoutReason[3][14] = 'Transfer not doable';
        $washoutReason[3][15] = 'Challans';
        $washoutReason[3][16] = 'Superdaari';
        $washoutReason[3][17] = 'Others';
        $washoutReason[4][18] = 'Vehicle changed';
        $washoutReason[4][19] = 'Car sold in cash';
        $washoutReason[4][20] = 'Valuation issue';
        $washoutReason[4][21] = 'Old Car';
        $washoutReason[4][22] = 'Higher LTV';
        $washoutReason[4][23] = 'Accidental vehicle';
        $washoutReason[4][24] = 'Others';
        $washoutReason[5][25] = 'NOC';
        $washoutReason[5][26] = 'Form 29/30';
        $washoutReason[5][27] = 'Insurance';
        $washoutReason[5][28] = 'Others';
        if(empty($typeId))
        {
            $washoutId = $this->input->post('id');
            $str = '';
            if($washoutId>0)
            {
                $str = "<option value='0'>Select One</option>";
                foreach($washoutReason[$washoutId] as $key => $val)
                {
                   $str .="<option value=".$key.">$val</option>";
                }

                echo $str; exit;
            }
            echo $str; exit;
        }
        else
        {
            foreach ($washoutReason as $key => $value) {
        
                foreach ($value as $skey => $svalue) {
                    if($skey==$typeId)
                    {
                        return $svalue;
                    }
                }
            }
            //exit;
        }
    }

    public function cancelNow()
    {
        $type_id = $this->input->post('type_id');
        $type = $this->input->post('type');
        $case_id = $this->input->post('case_id');
        $data = [];
        //$data['cancel_type'] = '0';
        $data['loan_approval_status'] = '9';
        if($type=='washout')
        {
           // $this->renderWashoutSms($case_id,$type_id);
            $data['loan_approval_status'] = '6';
        }
        $data['last_updated_date'] = date('Y-m-d H:i:s');
        $data['cancel_id'] = $type_id;
        $data['cancel_date'] = date('Y-m-d H:i:s');
        $cancelUpdate = $this->Loan_customer_case->saveUpdateCaseInfo($data, $case_id,'1');
        $this->addLoanHistory($case_id,$type,'-','-',$type,'',$this->session->userdata['userinfo']['id']);
        $this->addLoanHistoryUpdateLog($case_id,'','-','','1');
        $cancelUpdate = $this->Loan_customer_case->saveUpdateCaseInfo($data, $case_id);
        //$lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($dataed, $case_id);
        echo $cancelUpdate; exit;
    }

    public function reopenCase()
    {
        $case_id = $this->input->post('caseId');
        $data['last_updated_date'] = date('Y-m-d H:i:s');
        $data['loan_approval_status'] = '5';
        $data['cancel_id'] = '0';
        $data['reopen_date'] = date('Y-m-d H:i:s');
        $cancelUpdate = $this->Loan_customer_case->saveUpdateCaseInfo($data, $case_id,'1');
        $this->addLoanHistory($case_id,'Reopen Case','-','-','Reopen Case','',$this->session->userdata['userinfo']['id'],'Updated');
        $this->addLoanHistoryUpdateLog($case_id,'','-','','1');
        echo "1"; exit;
    }


    public function updateLoanStatus($case_id,$status='')
    {
        $data['last_updated_date'] = date('Y-m-d H:i:s');
        $getLastStatus = $this->Loan_customer_case->getCaseId($case_id);       
        $checkIfExists = $this->Loan_customer_case->checkIfExists('',$case_id);
        foreach ($checkIfExists as $key => $value) {
            $tag_value[]=$value['tag_flag'];
        }
        if(!empty($getLastStatus))
        {
            if(($getLastStatus[0]['loan_approval_status']=='5') && !empty($status))
            {
                $data['loan_approval_status'] = $status;
            }
            if(($getLastStatus[0]['loan_approval_status']=='5') && ($status=='1'))
            {
                $data['loan_approval_status'] = '1';
            }
            if(($getLastStatus[0]['loan_approval_status']=='1') && ($status=='2'))
            {
                $data['loan_approval_status'] = '2';
            }
            if(($getLastStatus[0]['loan_approval_status']=='2') && ($status=='4'))
            {
                $data['loan_approval_status'] = '4';
            }else{
                
            }
        }
        $cancelUpdate = $this->Loan_customer_case->saveUpdateCaseInfo($data, $case_id,'1');
    }

    public function getHistoryDetail()
    {
        $case_id = $this->input->post('caseId');
        $result =  $this->Loan_customer_case->getLoanHistory($case_id);
        $str = '';
        foreach($result as $key => $val)
        {
            $reason  = '';
            if($val['activity']=='Rejected')
            {
                $reason = '('.$val['remark'].')';
            }
          $usernamearr=$this->Crm_user->getEmployee('',$val['created_by']);
          $username = ucwords(strtolower($usernamearr[0]['name']));
          $bank =  (!empty($val['bank_details']) && ($val['bank_details']!='-')?'('.$val['bank_details'].')':'');
         $str .='<li class="side_nav">
            
                <div class="col-md-12 border-B">
                <div class="row">
                    <div class="col-sm-4">
                <a href="#" class="sidenav-a">
                <span class="img-type"></span>'.date('jS M',strtotime($val['created_at'])).'
                </a>
            </div>
            <div class="col-sm-4 side_text">
                <span class="active_text">'.$val['activity'].' '.$reason.'</span>
                <span class="Detail_text">'.(!empty($bank)?$bank:'').'</span>
            </div>
            <div class="col-sm-4">
                <span class="Detail_text mrg-T15">'.(!empty($username)?$username:'').'</span>
            </div>
                </div>
            </div>
        </li>'; 
        }
        echo $str;
        exit;
    }

    public function checkRefnumbers()
    {
        $ref_no = $this->input->post('refid');
        $id = $this->input->post('id');
        $flag = $this->input->post('flag');
        $res = [];
        $checkIfRefnumber= $this->Loan_customer_info->checkRefId($ref_no,'',$id,$flag);
        if(!empty($checkIfRefnumber))
        {
            $res['status'] = '0';
        }
        else
        {
            $res['status'] = '1';
        }
        echo json_encode($res); exit;

    }

    public function disbursalDistribution()
    {
        $datapost = $this->input->post();
       
        $datapost['first_emi'] = date('Y-m-d',strtotime($datapost['first_emi'])) ;
        $datapost['case_id'] =  $datapost['case_id'];
        $datapost['gps_disburse'] =  str_replace(',','',$datapost['gps_disburse']);
        $datapost['loan_amount'] =  str_replace(',','',$datapost['loan_amount']);
        $datapost['loan_disburse'] =  str_replace(',','',$datapost['loan_disburse']);
        $datapost['motor_disburse'] =  str_replace(',','',$datapost['motor_disburse']);
        $datapost['fee_disburse'] =  str_replace(',','',$datapost['fee_disburse']);
        $datapost['other_disburse'] =  str_replace(',','',$datapost['other_disburse']);
        $datapost['existing_disburse'] =  str_replace(',','',$datapost['existing_disburse']);
        $datapost['gross_loan'] =  str_replace(',','',$datapost['gross_loan']);
        $datapost['total_amount'] =  str_replace(',','',$datapost['total_amount']);
        $datapost['extend_warranty'] =  str_replace(',','',$datapost['extend_warranty']);
        $datapost['counter_emi'] =  $datapost['counter_emi'];
        $datapost['total_emi'] =  str_replace(',','',$datapost['total_emi']);
        $datapost['existing_account_no'] =  $datapost['existing_account_no'];
        $datapost['loan_short'] =  str_replace(',','',$datapost['loan_short']);
        $datapost['remark'] =  $datapost['remark'];
        $datapost['disburse_emi'] =  str_replace(',','',$datapost['disburse_emi']);
        $datapost['payout']=$datapost['payout'];
        $datapost['loan_amount'] =  str_replace(',','',$datapost['loan_dis_amt']);
        $datapost['loan_credit_protect'] =  str_replace(',','',$datapost['loan_credit_protect']);
        $datapost['health_insurance'] =  str_replace(',','',$datapost['health_insurance']);
        $loan_dis_amt =  str_replace(',','',$datapost['loan_dis_amt']);
        unset($datapost['loan_dis_amt']);
       /* echo "<pre>";
        print_r($datapost);
        exit;*/

        $loanDetail     =  $this->Loan_customer_case->getLoanInfoByCustomerId($datapost['case_id'],4,0,0,1);
           $diss='';
        if(empty($loanDetail))
        {
            $loanDetail     =  $this->Loan_customer_case->getLoanInfoByCustomerId($datapost['case_id'],2,0,0,0);
            $diss = $loanDetail[0]['approved_loan_amt'];

        }
        else if((!empty($loanDetail)) && ($loanDetail[0]['disbursed_amount']=='') && ($diss==''))
        {
             $loanDetail     =  $this->Loan_customer_case->getLoanInfoByCustomerId($datapost['case_id'],2,0,0,0);
             $diss = $loanDetail[0]['approved_loan_amt'];
        } 
        else
        {
             $diss = $loanDetail[0]['disbursed_amount'];
        } 
        
        $updateId       =  $loanDetail[0]['id'];

        $disbursed_amount = $datapost['total_amount'];
        $data['gross_net_amount']=$disbursed_amount;
        $data['disbursed_amount']=$datapost['gross_loan'];
        
        $res = [];
        $caseId  = '';
        $checkIfEx = $this->Loan_customer_info->checkCrmDisbursalDistribution($datapost['case_id']);
        if(!empty($checkIfEx))
        {
            $caseId=$datapost['case_id'];
        }
    
        $aab = $this->Loan_customer_info->crmDisbursalDistribution($datapost,$caseId);
        $this->Loan_customer_case->saveCaseFileLogin($data,$updateId);
       
        if(!empty($aab)){
            $res['status'] = '1';
            $res['res']=implode(',',$datapost);
        }
        else
        {
            $res['status'] = '0';
            $res['res'] = '';
        }
        echo json_encode($res); exit;
    }

    public function getAssignedToList()
    {
        $loanFor = $this->input->post('loanshow');
        $assignedto = $this->input->post('assignedto');
        $str = '';
        //$employeeListByTeam = '';
        if($loanFor=='1')
        {
            $employeeListByTeam = $this->Crm_user->getEmployee('2','','New Car');
        }
        else if($loanFor=='2')
        {
            $employeeListByTeam = $this->Crm_user->getEmployee('2','','Used Car');
        }
        $str = "<option value=''>Please Select</option>";
        if(!empty($employeeListByTeam))
        {
            foreach($employeeListByTeam as $key => $val)
            {
                $sel = '';
                if(!empty($assignedto) && ($assignedto==$val['id']))
                {
                     $sel = 'selected="selected"';
                }
               $str .="<option value=".$val['id']." ".$sel.">$val[name]</option>";
            }
        }
        echo $str; exit;
    }

    public function financeUserMgmt($id= '' ,$module='')
    {
        $role_id = $this->session->userdata['userinfo']['role_id'];
        $role = $this->Crm_user->getRightsByRole($role_id,$module);
        if(($role_id>0) && ($role_id!='24')){
            $role['role_name'] = !empty($role[0]['role_name']) ? $role[0]['role_name'] :'';
            $role['role_id'] = $role_id;
        }
        else 
        {
            $role[0]['role_name'] = 'admin';
            $role[0]['team_name'] = '';
            $role[0]['edit_permission'] = '1';
            $role[0]['add_permission'] = '1';
            $role[0]['view_permission'] = '1';
            $role[0]['role_id'] = $role_id;
        }
        return $role;
    }

    public function getRtoState()
    {
        $data = [];
        $rto_id = $this->input->post('rto');
        $regno = $this->input->post('regno');
        //$regno = $this->input->post('regno');
        if(!empty($regno))
        {
            $rto_state = $this->Loan_customer_case->getRto('',$regno);
            $data['status'] = 'True';
            $data['rto_state'] = $rto_state[0]['state'];
            $str = '';
            foreach ($rto_state as $key => $value) {
              // $str .='<option value="$value[id]">$value[Registration_Index] ." ". $value[Place_of_Registration] </option>';
                $str .="<option value=".$value['id'].">$value[Registration_Index] $value[Place_of_Registration] </option>";
            }
            echo  $str; exit;
        }
        if(!empty($rto_id))
        {
            $rto_state = $this->Loan_customer_case->getRto($rto_id);
            $data['status'] = 'True';
            $data['rto_state'] = $rto_state[0]['state'];
       
        }

        echo json_encode($data); exit;
    }

    public function renderWashoutSms($case_id,$type_id)
    {
        $loanData  = $this->Loan_customer_case->getCaseInfoByCaseId($case_id);
        $empMobile = $this->Crm_user->getEmployee('',$loanData[0]['assign_case_to']);
        $markedby  = $this->Crm_user->getEmployee('',$this->session->userdata['userinfo']['id']);
        $mobile    = current($this->Loan_customer_info->getCustomerMobileNumber($loanData[0]['customer_id']));
        $reason    = $this->populateWashoutReason($type_id);
        $content = "Hi,-NL2BR-".ucwords(strtolower($loanData[0]['name'])).' ('.$mobile['mobile'].') loan file for '. $loanData[0]['make_name'] .' '.$loanData[0]['model_name'].' has been marked as Washout by '.$markedby[0]['name'] .'-NL2BR- Washout reason:'.$reason; 
        $this->smsSent($empMobile[0]['mobile'],$content,$case_id,'','5',"Washout");
    }

    public function renderApprovedSms($case_id,$mapping_id)
    {
        $loanData  = $this->Loan_customer_case->getCaseInfoByCaseId($case_id,$mapping_id);
        if($loanData[0]['source_type']=='1')
        {
          $dealerMob = $this->Crm_dealers->getDealerById($loanData[0]['dealer_id']); 
        }
        $loanAmt = $this->IND_money_format($loanData[0]['approved_loan_amt']);
        $approved_emi = $this->calculateEmi($loanData[0]['approved_loan_amt'],$loanData[0]['approved_tenure'], $loanData[0]['approved_roi']);
        $approved_emis =   $this->IND_money_format($approved_emi);
        $empMobile = $this->Crm_user->getEmployee('',$loanData[0]['assign_case_to']);
        $markedby  = $this->Crm_user->getEmployee('',$this->session->userdata['userinfo']['id']);
        $mobile    = current($this->Loan_customer_info->getCustomerMobileNumber($loanData[0]['customer_id']));
        //$reason    = $this->populateWashoutReason($type_id);
        $content = "Hi,-NL2BR-".ucwords(strtolower($loanData[0]['name'])).' ('.$mobile['mobile'].') loan file for '. $loanData[0]['make_name'] .' '.$loanData[0]['model_name'].' has been approved by '.$loanData[0]['financer_name'] .' (Ref id: '.$loanData[0]['ref_id'].' )-NL2BR- Approved Loan Details: Rs '.$loanAmt.' ,'.$loanData[0]['approved_tenure'].'months ,'.$loanData[0]['approved_roi'].' % ROI, Rs'.$approved_emis.' EMI-NL2BR-Please ensure enough bank limit for smooth disbursement.'; 
        $this->smsSent($empMobile[0]['mobile'],$content,$case_id,'','2',"Approved");
        if(!empty($dealerMob))
        {
            $contents = "Hi,-NL2BR-".ucwords(strtolower($loanData[0]['name'])).' ('.$mobile['mobile'].') loan file for '. $loanData[0]['make_name'] .' '.$loanData[0]['model_name'].'has been approved by '.$loanData[0]['financer_name'] .' (Ref id: '.$loanData[0]['ref_id'].' )-NL2BR- Approved Loan Details: Rs '.$loanAmt.' ,'.$loanData[0]['approved_tenure'].'months ,'.$loanData[0]['approved_roi'].' % ROI, Rs'.$approved_emis.' EMI'; 
            $this->smsSent($dealerMob['mobile'],$contents,$case_id,'','2',"Dealer");
        }
    }

    public function renderRejectSms($case_id,$mapping_id,$rejectId)
    {
        $rejectReason = $this->Loan_customer_case->getRejectList('',$rejectId);
        $loanData  = $this->Loan_customer_case->getCaseInfoByCaseId($case_id,$mapping_id);
        if($loanData[0]['source_type']=='1')
        {
          $dealerMob = $this->Crm_dealers->getDealerById($loanData[0]['dealer_id']); 
        }
        $empMobile = $this->Crm_user->getEmployee('',$loanData[0]['assign_case_to']);
        $markedby  = $this->Crm_user->getEmployee('',$this->session->userdata['userinfo']['id']);
        $mobile    = current($this->Loan_customer_info->getCustomerMobileNumber($loanData[0]['customer_id']));
        //$reason    = $this->populateWashoutReason($type_id);
        $content = "Hi,-NL2BR-".ucwords(strtolower($loanData[0]['name'])).' ('.$mobile['mobile'].') loan file for '. $loanData[0]['make_name'] .' '.$loanData[0]['model_name'].' has been rejected by '.$loanData[0]['financer_name'] .' (Ref id: '.$loanData[0]['ref_id'].' )-NL2BR- Rejection reason:'.$rejectReason[0]['reject_reason']; 
        $this->smsSent($empMobile[0]['mobile'],$content,$case_id,'','3',"Rejected");
        if(!empty($dealerMob))
        {
            $this->smsSent($dealerMob['mobile'],$content,$case_id,'','3',"Dealer");
        }
    }

    public function renderDisbursedSms($case_id,$mapping_id)
    {
        $loanData  = $this->Loan_customer_case->getCaseInfoByCaseId($case_id,$mapping_id);
        if($loanData[0]['source_type']=='1')
        {
          $dealerMob = $this->Crm_dealers->getDealerById($loanData[0]['dealer_id']); 
        }
        $loanAmt = $this->IND_money_format($loanData[0]['gross_net_amount']);
        $approved_emi = $this->calculateEmi($loanData[0]['gross_net_amount'],$loanData[0]['disbursed_tenure'], $loanData[0]['disbursed_roi']);
        $approved_emis =   $this->IND_money_format($approved_emi);
        $empMobile = $this->Crm_user->getEmployee('',$loanData[0]['assign_case_to']);
        $markedby  = $this->Crm_user->getEmployee('',$this->session->userdata['userinfo']['id']);
        $mobile    = current($this->Loan_customer_info->getCustomerMobileNumber($loanData[0]['customer_id']));
        //$reason    = $this->populateWashoutReason($type_id);
        $content = "Congratulations,-NL2BR-".ucwords(strtolower($loanData[0]['name'])).' ('.$mobile['mobile'].') loan file for '. $loanData[0]['make_name'] .' '.$loanData[0]['model_name'].' has been disbursed by '.$loanData[0]['financer_name'] .' (Ref id: '.$loanData[0]['ref_id'].' )-NL2BR- Disbursement Details: Rs '.$loanAmt.' (Net disbursed amount),'.$loanData[0]['disbursed_tenure'].'months ,'.$loanData[0]['disbursed_roi'].' % ROI, Rs'.$approved_emis.' EMI'; 
        $this->smsSent($empMobile[0]['mobile'],$content,$case_id,'','4',"Disburse");
        if(!empty($dealerMob))
        {
            $this->smsSent($dealerMob['mobile'],$content,$case_id,'','4',"Dealer");
        }
    }

    public function renderFileLoginSms($case_id,$loopCount,$datapost,$updatedId=[])
    {
        $bank_id = '';
        $s = [];
        $smsAlreadySent = [];
        $smsSentTo = $this->Loan_customer_case->checkIfExists('',$case_id);
        if(!empty($smsSentTo))
        {
            foreach ($smsSentTo as $skey => $svalue)
            {
                if(($svalue['tag_flag']=='1') && ($svalue['sms_sent']=='1'))
                {
                   // echo $svalue['id'];
                    $smsAlreadySent[$svalue['id']]=$svalue['id'];
                }  
            }
//exit;
        }
        $loanData  = $this->Loan_customer_case->getCaseInfoByCaseId($case_id);
        $mobile    = current($this->Loan_customer_info->getCustomerMobileNumber($loanData[0]['customer_id']));
        if($loanData[0]['source_type']=='1')
        {
          $dealerMob = $this->Crm_dealers->getDealerById($loanData[0]['dealer_id']); 
        }
       // echo 'sssswsqwss'; exit;
        $content = "Hi,-NL2BR-".ucwords(strtolower($loanData[0]['name'])).' ('.$mobile['mobile'].') loan file for '. $loanData[0]['make_name'] .' '.$loanData[0]['model_name'].' has been successfully logged into following bank(s):-NL2BR-';
        $i = 1;
        // echo '<pre>'; print_r($loanData); exit;
        foreach ($loanData as $key => $value) 
        {
            if(!empty($updatedId))
            {
                if(array_search($value['fileLoginId'], $updatedId))
                {
                    
                }
                else
                {
                  continue;   
                }
            }
            if(!empty($smsAlreadySent))
            {
                if(array_search($value['fileLoginId'], $smsAlreadySent))
                {
                   // echo $value['fileLoginId']."dsffrf".$i;
                    continue;
                }
                else
                {
                    //echo $value['fileLoginId']."rrrrr".$i;
                }
            }
            $bank_id .= $value['financer'].',';
            $loanAmt = $this->IND_money_format($value['loan_amt']);
            $approved_emi = $this->calculateEmi($value['loan_amt'],$value['tenor'], $value['roi']);
            $approved_emis =   $this->IND_money_format($approved_emi);
            $empMobile = $this->Crm_user->getEmployee('',$loanData[0]['assign_case_to']);
            $content .='-NL2BR-'.$i.'. '.$value['financer_name'] .' (Ref id: '.$value['ref_id'].' )-NL2BR-Loan Details:Rs '.$loanAmt.', '.$value['tenor'].' months, '.$value['roi'].' % ROI, Rs'.$approved_emis.' EMI ';
            $s['sms_sent'] = '1';  
            $this->Loan_customer_case->saveCaseFileLogin($s,$value['fileLoginId']);
            $i++;
        }
        if(($loopCount>'1') && (empty($updatedId)))
        {
            $type = '6';
            $remark = 'Multiple File Logged';
        }
        else if((!empty($updatedId)) && (count($updatedId)>'1'))
        {
            $type = '6';
            $remark = 'Multiple File Logged Updated';
        }
        else
        {
            $type = '1';
            $remark = 'File Logged';
            if(!empty($updatedId))
            {
                $remark = 'File Logged Updated';   
            }
        }
       // echo $content; exit;
        $bank_id = trim($bank_id,',');
        $sentSms = $empMobile[0]['mobile'];
        $sentSmsTest = '8826975366';
        $this->smsSent($sentSmsTest,$content,$case_id,$bank_id,$type,$remark);
        if(!empty($dealerMob))
        {
            $sentSms = $dealerMob['mobile'];
            $sentSmsTest = '8826975366';
            $this->smsSent($sentSmsTest,$content,$case_id,$bank_id,$type,"Dealer");
        }
       // return true;
    }

    public function renderLowBalSms($bank_id,$ref_id,$case_id)
    {
        $loanData  = $this->Loan_customer_case->getCaseInfoByCaseId($case_id);
        $mobile    = current($this->Loan_customer_info->getCustomerMobileNumber($loanData[0]['customer_id']));
        $bankName  = $this->Crm_banks_List->crmBankName($bank_id);
        $empMobile = $this->Crm_user->getEmployee('',$loanData[0]['assign_case_to']);
        $content = "Attention!-NL2BR-Loan Disbursement for ".$bankName[0]->bank_name .' (Ref id: '.$ref_id.' ) failed due to pending RC transfers.-NL2BR-Click on '.base_url().' to view pending RC cases for assigned banks.-NL2BR-Please ask RTO executive to mark RC transfer in system if already done.'; 
        
        $this->smsSent($empMobile[0]['mobile'],$content,$case_id,'','7',"Disburse Low Balance");
    }

    public function findParentModel($model_id)
    {
        $models = $this->Make_model->getParentModel($model_id);
        if(!empty($models))
        {
            return $models;
        }
    }

    public function prefillcar()
    {
        $res = [];
        $reg_no = $this->input->post('reg_no');
        $engno = $this->input->post('engno');
        $chasno = $this->input->post('chasno');
        if(!empty($reg_no))
        {
            $data['reg_no'] = $reg_no;
        }
        if(!empty($engno))
        {
            $data['engine_no'] = $engno;
        }
        if(!empty($chasno))
        {
            $data['chassis_no'] = $chasno;
        }
        $result = $this->crm_stocks->getCrmCentralStock($data);
        if(!empty($result))
        {
            $res['status'] = '1';
            $res['result'] = $result;
        }
        else
        {
            $res['status'] = '0';
            $res['result'] = $result;
        }
        echo json_encode($res); exit; 
    }

    public function printpdf($caseId)
     {
        $pdfData = [];
      $this->load->helper('pdf_helper');
      if(!empty($caseId)){
            $data['case_id']        = $caseId;
            $cust_detail = $this->Loan_customer_case->getCaseInfoByCaseId($caseId);
            $data['CustomerInfo']       =  $cust_detail[0];
            if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
             if(!empty($data['CustomerInfo']['loan_amt'])){
             $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
              $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
        }
   
        $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
        $time=time();
        $filename=str_replace(' ','_', $data['CustomerInfo']['name']).'_QDESheet'.$caseId.'_'.$time;
        }
        $length_of_stay = '';
        if($data['CustomerInfo']['length_of_stay']=='1')
        {
            $length_of_stay = 'Below 1 Year';   
        }
        if($data['CustomerInfo']['length_of_stay']=='2')
        {
            $length_of_stay = '1 Year';   
        }
        if($data['CustomerInfo']['length_of_stay']=='3')
        {
            $length_of_stay = 'Above 2 Year';   
        }
        $pdfData['dealer_id'] = DEALER_ID;
        $pdfData['length_of_stay']= $length_of_stay;
        $pdfData['customer_id'] = $data['CustomerInfo']['customer_id'];
        $pdfData['customer_name'] = $data['CustomerInfo']['name'];
        $pdfData['customer_email'] = $data['CustomerInfo']['email'];
        $pdfData['dob'] = (!empty($data['CustomerInfo']['dob']) && ($data['CustomerInfo']['dob']!='0000-00-00'))?date('d/m/Y', strtotime($data['CustomerInfo']['dob'])):'';
        $pdfData['pan_number'] = strtoupper($data['CustomerInfo']['pan_number']);
        $pdfData['gender'] = strtoupper($data['CustomerInfo']['gender']);
        $pdfData['mother_name'] = $data['CustomerInfo']['mother_name'];


         $pdfData['Buyer_Type'] = $data['CustomerInfo']['Buyer_Type'];

        $pdfData['loan_amt'] = $data['loanamt'];
        //$pdfData['custbank'] = $data['CustomerInfo']['custbank'];
        $pdfData['custacc'] = $data['CustomerInfo']['custacc'];
        $pdfData['residence_address'] = $data['CustomerInfo']['residence_address'];

        $pdfData['landmark'] = $data['CustomerInfo']['landmark'];
        $pdfData['cores_landmark'] = $data['CustomerInfo']['cores_landmark'];
        $pdfData['residence_state'] = $this->state_list->getStateList($data['CustomerInfo']['residence_state']);
        $pdfData['residence_city'] = $this->City->getCityNameById($data['CustomerInfo']['residence_city']);
        $pdfData['residence_pincode'] = $data['CustomerInfo']['residence_pincode'];
        $pdfData['residence_phone'] = $data['CustomerInfo']['residence_phone'];
        if($data['CustomerInfo']['sameas']=='0')
        {
            $pdfData['corres_add'] = $data['CustomerInfo']['corres_add'];
            $pdfData['corres_state'] =$this->state_list->getStateList($data['CustomerInfo']['corres_state']);
            $pdfData['corres_city'] = $this->City->getCityNameById($data['CustomerInfo']['corres_city']);
            $pdfData['corres_pincode'] = $data['CustomerInfo']['corres_pincode'];
            $pdfData['corres_phone'] = $data['CustomerInfo']['corres_phone'];
        }
        else
        {
            $pdfData['corres_add'] = $data['CustomerInfo']['residence_address'];
            $pdfData['corres_state'] = $this->state_list->getStateList($data['CustomerInfo']['residence_state']);
            $pdfData['corres_city'] =  $this->City->getCityNameById($data['CustomerInfo']['residence_city']);
            $pdfData['corres_pincode'] = $data['CustomerInfo']['residence_pincode'];
            $pdfData['corres_phone'] = $data['CustomerInfo']['residence_phone'];
        }
        
        
        if(((($data['CustomerInfo']['employment_type']=='2') || (($data['CustomerInfo']['employment_type']=='3')))&&(($data['CustomerInfo']['bus_off_set_up']=='2')||($data['CustomerInfo']['pro_off_set_up']=='2'))) || ($data['CustomerInfo']['Buyer_Type']=='1')){
            $pdfData['office_address'] = $data['CustomerInfo']['office_address'];
            $pdfData['office_landmark'] = $data['CustomerInfo']['office_landmark'];
            $pdfData['office_city'] =  $this->City->getCityNameById($data['CustomerInfo']['office_city']);
            $pdfData['office_phone'] = $data['CustomerInfo']['office_phone'];
            $pdfData['office_pincode'] = $data['CustomerInfo']['office_pincode'];
            $pdfData['office_mobile'] = $data['CustomerInfo']['office_mobile'];
            $pdfData['office_email'] = $data['CustomerInfo']['office_email'];
        }
            $pdfData['ref_address_one'] = $data['CustomerInfo']['ref_address_one'];
            $pdfData['ref_name_one'] = $data['CustomerInfo']['ref_name_one'];
            $pdfData['ref_phone_one'] = $data['CustomerInfo']['ref_phone_one'];
            $pdfData['ref_relationship_one'] = $data['CustomerInfo']['ref_relationship_one'];
            $pdfData['ref_name_two'] = $data['CustomerInfo']['ref_name_two'];
            $pdfData['ref_address_two'] = $data['CustomerInfo']['ref_address_two'];
            $pdfData['ref_phone_two'] = $data['CustomerInfo']['ref_phone_two'];
            $pdfData['ref_relationship_two'] = $data['CustomerInfo']['ref_relationship_two'];
             /*echo "<pre>";
        print_r($pdfData);
        exit;*/

        $html = $this->load->view('finance/pdffile.php', $pdfData, true);
        @pdf_create($html, $filename);
        write_file('name', $data);
        //$this->orderListing();
    }


    public function loanpayment($customer_id='')
    {
      
        $editId      = !empty($customer_id)? explode('_',base64_decode($customer_id)):'';
        $casesId     = !empty($editId)?end($editId):'';
        $data = [];
        $bnkId = '';
        $data['pageTitle']      = 'Loan Payment Details';
        $data['pageType']       = 'loan';
        $data['customerDetail']       = $this->Loan_customer_case->getCaseInfoByCaseId($casesId);
        $data['paymentDetails']       = $this->Loan_customer_case->getPaymentInfoByCaseId($casesId);
        $data['loanDetail']     =  $this->Loan_customer_case->getLoanInfoByCustomerId($data['customerDetail'][0]['customer_loan_id'],2);
        if($data['customerDetail'][0]['tag_flag']=='4'){
            $data['loanDetail']     =  $this->Loan_customer_case->getLoanInfoByCustomerId($data['customerDetail'][0]['customer_loan_id'],4,0,0,1);
        }
        
        $data['case_id']        = $casesId;
        if(!empty($casesId))
        {
            $data['CustomerInfo']       = $data['customerDetail'][0];
            $data['customerMobileNumber']  = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
            $this->updateLoanStatus($data['case_id'],$data['CustomerInfo']['tag_flag']);
        }
        foreach ($data['loanDetail'] as $key => $value) 
        {
            $bnkId        .= $value['bank_id'].',';
            $bankk         = $this->Crm_banks->getBankNameBybnkId($value['bank_id']);
            $data['loanDetail'][$key]['bank_name']      =  $bankk['bank_name'];
            if($value['tag_flag']=='4')
            {
                $data['disbural'] = '1'; }
                $am = (!empty($data['loanDetail'][$key]['disbursed_amount'])?$data['loanDetail'][$key]['disbursed_amount']:(!empty($data['loanDetail'][$key]['approved_loan_amt'])?$data['loanDetail'][$key]['approved_loan_amt']:$data['loanDetail'][$key]['file_loan_amount']));
                 $te = (!empty($data['loanDetail'][$key]['disbursed_tenure'])?$data['loanDetail'][$key]['disbursed_tenure']:(!empty($data['loanDetail'][$key]['approved_tenure'])?$data['loanDetail'][$key]['approved_tenure']:$data['loanDetail'][$key]['file_tenure']));
                 $ro = (!empty($data['loanDetail'][$key]['disbursed_roi'])?$data['loanDetail'][$key]['disbursed_roi']:(!empty($data['loanDetail'][$key]['approved_roi'])?$data['loanDetail'][$key]['approved_roi']:$data['loanDetail'][$key]['file_roi']));
            
            $data['loanDetail'][$key]['emi'] = $this->calculateEmi($am,$te,$ro);
            $data['loanDetail'][$key]['emi'] = $this->IND_money_format($data['loanDetail'][$key]['emi']);
            $data['loanDetail'][$key]['file_loan_amount'] = $this->IND_money_format($data['loanDetail'][$key]['file_loan_amount']);
            $data['loanDetail'][$key]['approved_loan_amt'] = $this->IND_money_format($data['loanDetail'][$key]['approved_loan_amt']);
            $data['loanDetail'][$key]['disbursed_amount'] = $this->IND_money_format($data['loanDetail'][$key]['disbursed_amount']);
            $data['loanDetail'][$key]['gross_net_amount'] = $this->IND_money_format($data['loanDetail'][$key]['gross_net_amount']);

        }
        $data['bank_id']        = trim($bnkId,',');
        if(!empty($data['loanDetail'])){
        }   
        if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
        if(!empty($data['CustomerInfo']['loan_amt'])){
            $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
            $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
            $data['CustomerInfo']['disbursed_amount'] = $this->IND_money_format($data['CustomerInfo']['disbursed_amount']);
            $data['CustomerInfo']['gps_disburse'] = $this->IND_money_format($data['CustomerInfo']['gps_disburse']);
            $data['CustomerInfo']['loan_disburse'] = $this->IND_money_format($data['CustomerInfo']['loan_disburse']);
            $data['CustomerInfo']['motor_disburse'] = $this->IND_money_format($data['CustomerInfo']['motor_disburse']);
            $data['CustomerInfo']['fee_disburse'] = $this->IND_money_format($data['CustomerInfo']['fee_disburse']);
            $data['CustomerInfo']['other_disburse'] = $this->IND_money_format($data['CustomerInfo']['other_disburse']);
            $data['CustomerInfo']['existing_disburse'] = $this->IND_money_format($data['CustomerInfo']['existing_disburse']);
            $data['CustomerInfo']['processing_disburse'] = $this->IND_money_format($data['CustomerInfo']['processing_disburse']);
            $data['CustomerInfo']['rc_disburse'] = $this->IND_money_format($data['CustomerInfo']['rc_disburse']);
            $data['CustomerInfo']['total_amount'] = $this->IND_money_format($data['CustomerInfo']['total_amount']);
            $data['CustomerInfo']['loan_amount'] = $this->IND_money_format($data['CustomerInfo']['loan_amount']);
            /*------------------*/
            $data['CustomerInfo']['gross_loan'] = $this->IND_money_format($data['CustomerInfo']['gross_loan']);
            $data['CustomerInfo']['extend_warranty'] = $this->IND_money_format($data['CustomerInfo']['extend_warranty']);
            $data['CustomerInfo']['counter_emi'] = $data['CustomerInfo']['counter_emi'];
            $data['CustomerInfo']['total_emi'] = $this->IND_money_format($data['CustomerInfo']['total_emi']);
            $data['CustomerInfo']['disburse_emi'] = $this->IND_money_format($data['CustomerInfo']['disburse_emi']);
            $data['CustomerInfo']['existing_loan'] = $this->IND_money_format($data['CustomerInfo']['existing_loan']);
            $data['CustomerInfo']['existing_account_no'] =$data['CustomerInfo']['existing_account_no'];
            $data['CustomerInfo']['loan_short'] = $this->IND_money_format($data['CustomerInfo']['loan_short']);
            $data['CustomerInfo']['loan_amount'] = $this->IND_money_format($data['customerDetail'][0]['loan_amount']);
            $data['CustomerInfo']['first_emi'] = date('d-m-Y',strtotime($data['CustomerInfo']['first_emi']));
            $data['CustomerInfo']['remark'] = ucwords($data['CustomerInfo']['remark']);
            $data['CustomerInfo']['payout'] = ucwords($data['CustomerInfo']['payout']);

        }
        $gross_net_amount = $data['CustomerInfo']['gross_net_amount'];
        $data['CustomerInfo']['gross_net_amount'] = $this->IND_money_format($data['CustomerInfo']['gross_net_amount']);
        $data['reject_reason']  =  $this->Loan_customer_case->getRejectList();
        $data['rolemgmt'] = $this->financeUserMgmt('','loanpayment');
        $data['banklist']          = $this->Crm_banks->getcustomerBankList(); 
        $flag = '1';
        if($this->session->userdata['userinfo']['id']=='1')
        {
            $flag = '';
        }
        $engineno = !empty($data['customerDetail'][0]['engine_number'])?$data['customerDetail'][0]['engine_number']:"";
        $chassisno = !empty($data['customerDetail'][0]['chassis_number'])?$data['customerDetail'][0]['chassis_number']:"";
        if((!empty($engineno)) && (!empty($chassisno))){
            $insdata = $this->Crm_insurance->getCentralStock('','','','',$engineno,$chassisno,'1');
        }
        if(!empty($insdata))
        {      
          $premiumInt =  $this->IND_money_format($insdata[0]['premium']);  
        }
        $data['premiumInt'] = !empty($premiumInt)?$premiumInt:0;
        $ii = 0;
        $Clearance = $this->Loan_customer_case->selectLoanPartpayment('','2',$flag,$casesId); 
        $payment = $this->Loan_customer_case->selectLoanPartpayment('','1',$flag,$casesId); 
        $total_clearance_amount = 0;
        foreach ($Clearance as $key => $value) {
           $data['Clearance'][$ii]['id'] = $value['id'];
           $data['Clearance'][$ii]['entry_type'] = $value['entry_type'];
           $data['Clearance'][$ii]['bank_id'] = $value['bank_id'];
           $data['Clearance'][$ii]['payment_by'] = $value['payment_by'];
           $data['Clearance'][$ii]['customer_id'] = $value['customer_id'];
           $data['Clearance'][$ii]['case_id'] = $value['case_id'];
           $data['Clearance'][$ii]['payment_date'] = $value['payment_date'];
           $data['Clearance'][$ii]['payment_mode'] = $value['payment_mode'];
           $data['Clearance'][$ii]['favouring_to'] = $value['favouring_to'];
           $data['Clearance'][$ii]['amount'] = $this->IND_money_format($value['amount']);
           $total_clearance_amount = $total_clearance_amount+$value['amount'];          
           $data['Clearance'][$ii]['instrument_no'] = $value['instrument_no'];
           $data['Clearance'][$ii]['instrument_date'] = $value['instrument_date'];
           $data['Clearance'][$ii]['bank_name'] = $value['bank_name'];
           $data['Clearance'][$ii]['pay_remark'] = $value['pay_remark'];
           $data['Clearance'][$ii]['created_by'] = $value['created_by'];
           $data['Clearance'][$ii]['date_time'] = $value['date_time'];
           $data['Clearance'][$ii]['update_date'] = $value['update_date'];
            $ii++;
        }
       
        $netpayamtcheck = 0;
     
        $data['total_clearance_amount'] = $this->IND_money_format($total_clearance_amount);
        $jj = 0;
        foreach ($payment as $keys => $values) {
           $data['payment'][$jj]['id'] = $values['id'];
           $data['payment'][$jj]['entry_type'] = $values['entry_type'];
           $data['payment'][$jj]['bank_id'] = $values['bank_id'];
           $data['payment'][$jj]['payment_by'] = $values['payment_by'];
           $data['payment'][$jj]['customer_id'] = $values['customer_id'];
           $data['payment'][$jj]['case_id'] = $values['case_id'];
           $data['payment'][$jj]['payment_date'] = $values['payment_date'];
           $data['payment'][$jj]['payment_mode'] = $values['payment_mode'];
           $data['payment'][$jj]['favouring_to'] = $values['favouring_to'];
           $data['payment'][$jj]['amount'] = $this->IND_money_format($values['amount']);
           $data['payment'][$jj]['instrument_no'] = $values['instrument_no'];
           $data['payment'][$jj]['instrument_date'] = $values['instrument_date'];
           $data['payment'][$jj]['bank_name'] = $values['bank_name'];
           $data['payment'][$jj]['pay_remark'] = $values['pay_remark'];
           $data['payment'][$jj]['created_by'] = $values['created_by'];
           $data['payment'][$jj]['date_time'] = $values['date_time'];
            $data['payment'][$jj]['update_date'] = $values['update_date'];
            if($values['payment_by']==2)
            {
                $netpayamtcheck = 1;
            }
            $jj++;
        }
        $data['netpayamtcheck']=$netpayamtcheck;
         $out_amount = 0;
        $net_PaymentInfo = $this->Loan_customer_case->getPaymentInfoByCaseId($casesId);        
        $net_payable_amount = $net_PaymentInfo['net_amount'];
        if($net_payable_amount == 0){  
             if(empty($data['CustomerInfo']['disbursed_amount'])){
                $disbur = (empty($data['CustomerInfo']['approved_loan_amt'])? $data['CustomerInfo']['file_loan_amount']:$data['CustomerInfo']['approved_loan_amt']);
               }else{
                 $disbur = $data['CustomerInfo']['disbursed_amount'];
               }
              $net_payable_amount = !empty($data['CustomerInfo']['loan_amount'])?$data['CustomerInfo']['loan_amount']:$disbur;
              $net_payable_amount = str_replace(',','',$net_payable_amount);
        }
        if($netpayamtcheck > 0){
         $out_amount = $net_payable_amount - $total_clearance_amount; 
        }
        
        $data['out_amount'] = $this->IND_money_format($out_amount);
        if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($casesId);
        }
        $data['CustomerInfo']['left_amt'] = $left_amount;
        $totalamt = $this->checkamout('',$casesId,1,1);
        $data['totalamt'] = (int)str_replace(',','',$data['CustomerInfo']['gross_net_amount'])-(int)$totalamt; 
        if(($data['totalamt']==0) && ($out_amount==0) && $gross_net_amount > 0 ){
            $da['loan_approval_status']='11'; 
            $this->Loan_customer_case->saveUpdateCaseInfo($da,$casesId,'1');  
        }
        else {
              $da['loan_approval_status']='4'; 
            if($CustomerInfo["upload_post_doc_flag"]=='1')
              $da['loan_approval_status']='8';              
        }   
	$this->loadViews("finance/loanpayment", $data);
    }


    public function makepayment()
    {
        $datapost              = $this->input->post();
        $editId      = $datapost['id'];
        $casesId     = $datapost['case_id'];
        $customer_id = $datapost['customer_id'];
        $data = [];
        $bnkId = '';
        if(!empty($editId))
        {
            $pay = $this->Loan_customer_case->selectLoanPartpayment($editId);

            $data['paymentDetails'] = $pay[0];
            $data['paymentDetails']['amount'] = $this->IND_money_format($pay[0]['amount']);
        }
        $data['customerDetail']       = $this->Loan_customer_case->getCaseInfoByCaseId($casesId);
        $data['loanDetail']     =  $this->Loan_customer_case->getLoanInfoByCustomerId($data['customerDetail'][0]['customer_loan_id'],2);
         $data['banklist']          = $this->Crm_banks->getcustomerBankList();//getAllBankId(); 
        if($data['customerDetail'][0]['tag_flag']=='4'){
            $data['loanDetail']     =  $this->Loan_customer_case->getLoanInfoByCustomerId($data['customerDetail'][0]['customer_loan_id'],4,0,0,1);
        }
        $data['case_id']        = $casesId;
        if(!empty($casesId))
        {
            $data['CustomerInfo']       = $data['customerDetail'][0];
            $data['customerMobileNumber']  = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
            $this->updateLoanStatus($data['case_id'],$data['CustomerInfo']['tag_flag']);
        }
        foreach ($data['loanDetail'] as $key => $value) 
        {
            $bnkId        .= $value['bank_id'].',';
            $bankk         = $this->Crm_banks->getBankNameBybnkId($value['bank_id']);
            $data['loanDetail'][$key]['bank_name']      =  $bankk['bank_name'];
            if($value['tag_flag']=='4')
            {
                $data['disbural'] = '1'; }
                $am = (!empty($data['loanDetail'][$key]['disbursed_amount'])?$data['loanDetail'][$key]['disbursed_amount']:(!empty($data['loanDetail'][$key]['approved_loan_amt'])?$data['loanDetail'][$key]['approved_loan_amt']:$data['loanDetail'][$key]['file_loan_amount']));
                 $te = (!empty($data['loanDetail'][$key]['disbursed_tenure'])?$data['loanDetail'][$key]['disbursed_tenure']:(!empty($data['loanDetail'][$key]['approved_tenure'])?$data['loanDetail'][$key]['approved_tenure']:$data['loanDetail'][$key]['file_tenure']));
                 $ro = (!empty($data['loanDetail'][$key]['disbursed_roi'])?$data['loanDetail'][$key]['disbursed_roi']:(!empty($data['loanDetail'][$key]['approved_roi'])?$data['loanDetail'][$key]['approved_roi']:$data['loanDetail'][$key]['file_roi']));
            
            $data['loanDetail'][$key]['emi'] = $this->calculateEmi($am,$te,$ro);
            $data['loanDetail'][$key]['emi'] = $this->IND_money_format($data['loanDetail'][$key]['emi']);
            $data['loanDetail'][$key]['file_loan_amount'] = $this->IND_money_format($data['loanDetail'][$key]['file_loan_amount']);
            $data['loanDetail'][$key]['approved_loan_amt'] = $this->IND_money_format($data['loanDetail'][$key]['approved_loan_amt']);
            $data['loanDetail'][$key]['disbursed_amount'] = $this->IND_money_format($data['loanDetail'][$key]['disbursed_amount']);
            $data['loanDetail'][$key]['gross_net_amount'] = $this->IND_money_format($data['loanDetail'][$key]['gross_net_amount']);

        }
        $data['bank_id']        = trim($bnkId,',');
    
        if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
        if(!empty($data['CustomerInfo']['loan_amt'])){
            $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
            $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
            $data['CustomerInfo']['gps_disburse'] = $this->IND_money_format($data['CustomerInfo']['gps_disburse']);
            $data['CustomerInfo']['loan_disburse'] = $this->IND_money_format($data['CustomerInfo']['loan_disburse']);
            $data['CustomerInfo']['motor_disburse'] = $this->IND_money_format($data['CustomerInfo']['motor_disburse']);
            $data['CustomerInfo']['fee_disburse'] = $this->IND_money_format($data['CustomerInfo']['fee_disburse']);
            $data['CustomerInfo']['other_disburse'] = $this->IND_money_format($data['CustomerInfo']['other_disburse']);
            $data['CustomerInfo']['existing_disburse'] = $this->IND_money_format($data['CustomerInfo']['existing_disburse']);
            $data['CustomerInfo']['processing_disburse'] = $this->IND_money_format($data['CustomerInfo']['processing_disburse']);
            $data['CustomerInfo']['rc_disburse'] = $this->IND_money_format($data['CustomerInfo']['rc_disburse']);
            $data['CustomerInfo']['total_amount'] = $this->IND_money_format($data['CustomerInfo']['total_amount']);
            $data['CustomerInfo']['loan_amount'] = $this->IND_money_format($data['CustomerInfo']['loan_amount']);
            /*------------------*/
            $data['CustomerInfo']['gross_loan'] = $this->IND_money_format($data['CustomerInfo']['gross_loan']);
            $data['CustomerInfo']['extend_warranty'] = $this->IND_money_format($data['CustomerInfo']['extend_warranty']);
            $data['CustomerInfo']['counter_emi'] = $data['CustomerInfo']['counter_emi'];
            $data['CustomerInfo']['total_emi'] = $this->IND_money_format($data['CustomerInfo']['total_emi']);
            $data['CustomerInfo']['disburse_emi'] = $this->IND_money_format($data['CustomerInfo']['disburse_emi']);
            $data['CustomerInfo']['existing_loan'] = $this->IND_money_format($data['CustomerInfo']['existing_loan']);
            $data['CustomerInfo']['existing_account_no'] =$data['CustomerInfo']['existing_account_no'];
            $data['CustomerInfo']['loan_short'] = $this->IND_money_format($data['CustomerInfo']['loan_short']);
            $data['CustomerInfo']['loan_amount'] = $this->IND_money_format($data['customerDetail'][0]['loan_amount']);
            $data['CustomerInfo']['first_emi'] = date('d-m-Y',strtotime($data['CustomerInfo']['first_emi']));
            $data['CustomerInfo']['remark'] = ucwords($data['CustomerInfo']['remark']);
            $data['CustomerInfo']['payout'] = ucwords($data['CustomerInfo']['payout']);

        }

        $data['reject_reason']  =  $this->Loan_customer_case->getRejectList();
        $data['rolemgmt'] = $this->financeUserMgmt('','loanpayment');
        $this->load->view('finance/makepayment',$data);
    }

    public function save_payment()
    {
        $datapost = $this->input->post();
        $data['customer_id'] = $datapost['customer_id'];
        $data['bank_id'] = $datapost['payment_bank'];
        $data['bank_name'] = $datapost['payment_banks_name'];
        $data['case_id'] = $datapost['case_id'];
         $tp = $datapost['tp'];
         if($tp=='1'){
             $data['payment_by'] = $datapost['payment_by'];
          }else{
            $data['payment_by'] = $datapost['inpayment_by'];
        }
        $data['payment_mode'] = $datapost['payment_mode'];
        $data['payment_date'] = (!empty($datapost['paydate']) && ($datapost['paydate']!='1970-01-01'))?date('Y-m-d',strtotime($datapost['paydate'])):'';
        $data['amount'] = str_replace(',', '', $datapost['amount']);
        //$data['bank_name'] = $datapost['payment_bank'];
        $data['favouring_to'] = $datapost['favouring'];
        $data['instrument_no'] = $datapost['instrument_no'];
        $data['instrument_date'] =(!empty($datapost['instrument_date']) && ($datapost['instrument_date']!='1970-01-01'))?date('Y-m-d',strtotime($datapost['instrument_date'])):'';
        $data['pay_remark'] = $datapost['remark'];
        $type = $datapost['type'];
        $id = $datapost['edit_id'];
        $data['entry_type'] = $datapost['tp'];
        $data['updated_by'] = $this->session->userdata['userinfo']['id'];
        if($id=='')
        {
            $data['created_by'] = $this->session->userdata['userinfo']['id'];
            $data['created_date'] = date('Y-m-d H:i:s');
        }
       $ids = $this->Loan_customer_case->addLoanPartpayment($data,$id);
       echo $ids; exit;

    }
    public function  save_net_payment(){
        $datapost = $this->input->post();
        $update_id = !empty($datapost['update_id'])?$datapost['update_id']:"";
        $rc_details = $this->Crm_rc->getRcFullCarDetail('',$datapost['loan_sno']);
        $data['case_id'] = $datapost['net_case_id'];
        $data['loan_amount'] =  str_replace(',', '', $datapost['net_laon_amount']);
        $data['net_amount'] =  str_replace(',', '', $datapost['net_amount']);
        $data['loan_short'] = !empty($datapost['net_payment_short'])?str_replace(',','',$datapost['net_payment_short']):'0';
        $data['processing_fee'] = str_replace(',','',$datapost['net_processing_fee']);
        $data['counter_emi'] = $datapost['net_counter_emi'];
        $data['total_emi'] = str_replace(',','',$datapost['net_total_emi']);
        $data['disburse_emi'] = "";
        $data['insuranace'] = str_replace(',','',$datapost['net_insurance']);
        //$data['bank_name'] = $datapost['payment_bank'];
        $data['rc_trans_by'] = $datapost['rc_transfered'];
        $data['rc_trans_price'] = str_replace(',','',$datapost['rc_trans_price']);
        $data['other_adjustment'] = str_replace(',','',$datapost['other_adjustment']);
        $data['payout'] = !empty($datapost['net_payout'])?$datapost['net_payout']:'0';
        $data['remark'] = $datapost['net_remark'];
         if($update_id=='')
        {
            $data['created_by'] = $this->session->userdata['userinfo']['id'];
        }
        $data['updated_by'] = $this->session->userdata['userinfo']['id'];
        $data['created_on'] = date('Y-m-d H:i:s');
        
       $ids = $this->Loan_customer_case->addLoanNetpayment($data,$update_id,$rc_details['rcid']);
       echo $ids; exit;
    }

    public function checkamout($id='',$case_id='',$flag='',$type='')
    {
        $sum = 0;
        $id = !empty($id)?$id:$this->input->post('edit_id');
        $type = !empty($type)?$type:$this->input->post('type');
        $case_id = !empty($case_id)?$case_id:$this->input->post('case_id');
        $pay = $this->Loan_customer_case->selectLoanPartpayment($id,$type,1,$case_id);
        foreach ($pay as $key => $value)
        {
           $sum = (int)$sum+(int)$value['amount'];
        }
        if(empty($flag))
        {
            echo  $sum; exit;
          }
        else{
            return $sum;
        }
    }
     public function makeloanpartpayment(){
        $caserId  = $this->input->post('case_id');
        $id  = $this->input->post('id');
        $type = $this->input->post('type');
        $data = [];
        $data['banklist']=$this->getcustomerBankList();
        $custInfo       = $this->Loan_customer_case->getCaseInfoByCaseId($caserId);        
        $data['CustomerInfo']  = $custInfo[0];
         $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
        $caseId  = $caserId;
        $data['postInfo']=[]; //current($this->Loan_customer_info->getCaseInfoByCustomerId($customerId));
        if($type!='add')
        $data['postInfo']  = current($this->Loan_payment_info->getPaymentDetails($data['CustomerInfo']['customer_loan_id'],$id));
        $data['pageTitle']      = 'Loan Payment';
        $data['pageType']       = 'loan';
        if(!empty($data['postInfo']['amount']))
        {
            $data['postInfo']['amount'] = $this->IND_money_format($data['postInfo']['amount']);
        }
        if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
        if(!empty($data['CustomerInfo']['loan_amt'])){
             $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
              $data['CustomerInfo']['disburse_emi'] = $this->IND_money_format($data['CustomerInfo']['disburse_emi']);
              $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
           // $data['loanamt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
        }
        $data['rolemgmt'] = $this->financeUserMgmt('','paymentDetails');
        if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;

        echo $this->load->view("finance/loanPaymentDetails",$data,true);exit;
        //$this->loadViews("finance/part_make_payment", $data);
    }

    public function coapplicantDetail($id='')
    {
        $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $casesId  = end($editId);
        $customerName          = $this->Loan_customer_case->getCaseInfoByCaseId($casesId);
        $data = [];
        $data['pageTitle']      = 'Coapplicant Detail';
        $data['pageType']       = 'loan';
        $data['CustomerInfo']   = !empty($customerName[0])?$customerName[0]:'';
        if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
         if(!empty($data['CustomerInfo']['loan_amt']))
        {
            $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
            $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
        }
        $data['customerId']     = !empty($data['CustomerInfo']['customer_id'])?$data['CustomerInfo']['customer_id']:'';
        $data['edicationType']  = ['0'=>'Select Highest Education','1'=>'10th','2'=>'12th','3'=>'Under Graduate','4'=>'Post Graduate','5'=>'Others'];
        $data['employmentType']  = ['1'=>'Salaried','2'=>'Self Employed-Business','3'=>'Self Employed-Profession','4'=>'Others'];
        //$data['CustomerInfo']   = current($this->Loan_customer_info->getCustomerInfoByCustomerId($customerId));
        $data['bus_applicantList']   = $this->Crm_applicant_type->ApplicantTypeListing('Applicant Type');
        $data['bus_industryList']   = $this->Crm_applicant_type->IndustryTypeListing('business');
        $data['oth_industryList']   = $this->Crm_applicant_type->ApplicantTypeListing('Other Type');
        $data['professionList']   = $this->Crm_applicant_type->ApplicantTypeListing('Profession Type');
        $data['cityList']      = $this->City->getAllCityListNew();
        $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
       // $caseId                            = current($this->Loan_customer_case->getCaseId($data['CustomerInfo']['customer_loan_id']));
        $caseId = $casesId;
        $data['bankname']=$this->getcustomerBankList();
        $data['refrenceData']              = current($this->Loan_customer_reference_info->getRefrenceId($caseId));
        if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
       
        $coapplicantInfo = $this->Loan_customer_case->getCoapplicantDataByCaseId($casesId);
        $data['coapplicantInfo'] = $coapplicantInfo[0];
        $data['coapplicantInfo']['bus_start_business_date'] = $data['coapplicantInfo']['bus_start_business_mon'].'-'.$data['coapplicantInfo']['bus_start_business_year'];
        $data['rolemgmt'] = $this->financeUserMgmt('','coapplicantDetail');
        $this->loadViews("finance/coapplicantDetail", $data);
    }
    public function addEditCoapplicantForms($params){
       // echo "fff"; exit;
        $id = (!empty($params['editid'])?$params['editid']:''); 
        $coapplicantDetails           = $this->renderCoapplicant($params);
        $savepersonalInfo             = $this->Loan_customer_info->saveUpdateCoapplicantDetails($coapplicantDetails,$id);
              $action = '0';  
        
        if(!empty($savepersonalInfo)){
            if($params['is_guaranter']=='1'){
                $result= array('status'=>'True','message'=>'Coapplicant Details Added Successfully','Action'=>  base_url().'guarantorDetail/' . base64_encode('CustomerId_' . $params['caseId']));
            }
            else
            {
                $result= array('status'=>'True','message'=>'Coapplicant Details Added Successfully','Action'=>  base_url().'uploadDocs/' . base64_encode('CustomerId_' . $params['caseId']));
            }
        }
        echo json_encode($result);exit;
    }
    public function renderCoapplicant($params){
        $financeAcedmic                            = [];
        if(!empty($params)){
        $financeAcedmic['highest_education']       = !empty($params['highest_education'])?$params['highest_education']:'';
        $financeAcedmic['profession_type']         = !empty($params['profession_type'])?$params['profession_type']:'';
        $financeAcedmic['industory_detail']        = !empty($params['industory_detail'])?$params['industory_detail']:'';
        $financeAcedmic['annual_income']           = !empty($params['annual_income'])?trim($params['annual_income']):'';
        $financeAcedmic['type_of_vehicle_owned']   = !empty($params['type_of_vehicle_owned'])?$params['type_of_vehicle_owned']:'';
        $financeAcedmic['vehicle_ownership']       = !empty($params['vehicle_ownership'])?$params['vehicle_ownership']:'';
        //$financeAcedmic['office']                  = !empty($params['office'])?$params['office']:'';
        $financeAcedmic['office_landmark']          = !empty($params['office_landmark'])?ucwords(strtolower(trim($params['office_landmark']))):'';
         $financeAcedmic['office_address']          = !empty($params['office_address'])?ucwords(strtolower(trim($params['office_address']))):'';
        $financeAcedmic['office_pincode']          = !empty($params['office_pincode'])?trim($params['office_pincode']):'';
        $financeAcedmic['office_phone']            = !empty($params['office_phone'])?trim($params['office_phone']):'';
        $financeAcedmic['office_mobile']           = !empty($params['office_mobile'])?trim($params['office_mobile']):'';
        $financeAcedmic['office_email']            = !empty($params['office_email'])?trim($params['office_email']):'';
        $financeAcedmic['office_city']             = !empty($params['office_cityList'])?$params['office_cityList']:'';
         $bus_start_business_date = explode('-', $params['bus_start_business_date']);
        $financeAcedmic['case_id']       =  $params['caseId'];
        $financeAcedmic['employment_type']   =  !empty($params['employment_type'])?$params['employment_type']:'';
        $financeAcedmic['employer_name']       = !empty($params['employer_name'])?ucwords(strtolower(trim($params['employer_name']))):'';
        $financeAcedmic['employee_doj']         = !empty($params['date_of_joining'])?date('Y-m-d',strtotime($params['date_of_joining'])):'';
        $financeAcedmic['totalexp']        = !empty($params['total_experience'])?trim($params['total_experience']):'';
        $financeAcedmic['gross_mon_income']           = !empty($params['monthly_income'])?trim($params['monthly_income']):'';
        $financeAcedmic['is_notice_period']           = !empty($params['notice_period'])?trim($params['notice_period']):'';
        
       // if($params['empType']=='2'){
        $financeAcedmic['bus_applicant_type']   = !empty($params['bus_applicant_type'])?$params['bus_applicant_type']:'';
        $financeAcedmic['bus_industry_type']       = !empty($params['bus_industry_type'])?$params['bus_industry_type']:'';
        $financeAcedmic['bus_business_name']                  = !empty($params['bus_business_name'])?ucwords(strtolower(trim($params['bus_business_name']))):'';
        $financeAcedmic['bus_off_set_up']          = !empty($params['bus_office_setup_type'])?$params['bus_office_setup_type']:'';
        $financeAcedmic['bus_start_business_mon']  = !empty($bus_start_business_date[0])?$bus_start_business_date[0]:'';
        $financeAcedmic['bus_start_business_year'] = !empty($bus_start_business_date[1])?$bus_start_business_date[1]:'';
        $financeAcedmic['bus_itr_income1']           = !empty($params['bus_itr_income1'])?trim($params['bus_itr_income1']):'';
        $financeAcedmic['bus_itr_income2']            = !empty($params['bus_itr_income2'])?trim($params['bus_itr_income2']):'';
       /// }
       // if($params['empType']=='3'){
        $financeAcedmic['pro_off_set_up']               = !empty($params['pro_office_setup_type'])?$params['pro_office_setup_type']:'';
        $financeAcedmic['pro_itr_income1']              = !empty($params['pro_itr_income1'])?trim($params['pro_itr_income1']):'';
        $financeAcedmic['pro_itr_income2']              = !empty($params['pro_itr_income2'])?trim($params['pro_itr_income2']):'';
        $financeAcedmic['pro_industry_type']            = !empty($params['pro_industry_type'])?$params['pro_industry_type']:'';
        $financeAcedmic['pro_start_date_mon']           = !empty($params['pro_start_date_month'])?$params['pro_start_date_month']:'';
        $financeAcedmic['pro_start_date_year']          = !empty($params['pro_start_date_year'])?$params['pro_start_date_year']:'';
      //  }
      //  if($params['empType']=='4'){
        $financeAcedmic['oth_type']                     = !empty($params['oth_type'])?$params['oth_type']:'';
        $financeAcedmic['oth_customer_own']             = !empty($params['others_followup'])?$params['others_followup']:'';
        $financeAcedmic['oth_customer_taken_loan']      = !empty($params['others_loan'])?$params['others_loan']:'';
        $financeAcedmic['branch_name']                     = !empty($params['bank_branch'])?$params['bank_branch']:'';
        $financeAcedmic['bank_id']                     = !empty($params['bank_name'])?$params['bank_name']:'';
        $financeAcedmic['account_no']                     = !empty($params['account_no'])?$params['account_no']:'';
        $financeAcedmic['ifci_code']                     = !empty($params['ifsc_code'])?$params['ifsc_code']:'';
        $financeAcedmic['account_type']                     = !empty($params['account_type'])?$params['account_type']:'';
        //}
        if(empty($params['editid']))
        {
            $financeAcedmic['created_on'] = date('Y-m-d H:i:s');
            $financeAcedmic['created_by'] = $this->session->userdata['userinfo']['id'];    
        }
        $financeAcedmic['updated_by'] = $this->session->userdata['userinfo']['id'];        
    }
        return $financeAcedmic;
    }

    public function guarantorDetail($id='')
    {
        $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $casesId  = end($editId);
        $customerName          = $this->Loan_customer_case->getCaseInfoByCaseId($casesId);
        $data = [];
        $data['pageTitle']      = 'Guarantor Detail';
        $data['pageType']       = 'loan';
        $data['CustomerInfo']   = !empty($customerName[0])?$customerName[0]:'';
        if(!empty($data['CustomerInfo']['modelId']))
            {
                $data['CustomerInfo']['model_name']    = $this->findParentModel($data['CustomerInfo']['modelId']);
            }
         if(!empty($data['CustomerInfo']['loan_amt']))
        {
            $data['CustomerInfo']['loan_amt'] = $this->IND_money_format($data['CustomerInfo']['loan_amt']);
            $data['loanamt'] = $data['CustomerInfo']['loan_amt'];
        }
        $data['customerId']     = !empty($data['CustomerInfo']['customer_id'])?$data['CustomerInfo']['customer_id']:'';
        $data['edicationType']  = ['0'=>'Select Highest Education','1'=>'10th','2'=>'12th','3'=>'Under Graduate','4'=>'Post Graduate','5'=>'Others'];
        $data['employmentType']  = ['1'=>'Salaried','2'=>'Self Employed-Business','3'=>'Self Employed-Profession','4'=>'Others'];
        //$data['CustomerInfo']   = current($this->Loan_customer_info->getCustomerInfoByCustomerId($customerId));
        $data['bus_applicantList']   = $this->Crm_applicant_type->ApplicantTypeListing('Applicant Type');
        $data['bus_industryList']   = $this->Crm_applicant_type->IndustryTypeListing('business');
        $data['oth_industryList']   = $this->Crm_applicant_type->ApplicantTypeListing('Other Type');
        $data['professionList']   = $this->Crm_applicant_type->ApplicantTypeListing('Profession Type');
        $data['cityList']      = $this->City->getAllCityListNew();
        $data['customerMobileNumber']      = current($this->Loan_customer_info->getCustomerMobileNumber($data['CustomerInfo']['customer_id']));
       // $caseId                            = current($this->Loan_customer_case->getCaseId($data['CustomerInfo']['customer_loan_id']));
        $caseId = $casesId;
        $data['bankname']=$this->getcustomerBankList();
        $data['refrenceData']              = current($this->Loan_customer_reference_info->getRefrenceId($caseId));
        if($data['CustomerInfo']['loan_approval_status'] == 11 ){
          $left_amount = 1;   
        } else{
          $left_amount = $this->Loan_customer_case->getOutstandingAmount($caseId);;
        }   
        $data['CustomerInfo']['left_amt'] = $left_amount;
        $data['CustomerInfo']['bus_start_business_date'] = $data['CustomerInfo']['bus_start_business_mon'].'-'.$data['CustomerInfo']['bus_start_business_year'];
        $guarantorInfo = $this->Loan_customer_case->getGuarantorDataByCaseId($casesId);
        $data['guarantorInfo'] = $guarantorInfo[0];
       $data['guarantorInfo']['bus_start_business_date'] = $data['guarantorInfo']['bus_start_business_mon'].'-'.$data['guarantorInfo']['bus_start_business_year'];
        $data['rolemgmt'] = $this->financeUserMgmt('','guarantorDetail');
        $this->loadViews("finance/guarantorDetail", $data);
    }
    public function addEditGuarantorForms($params){
        $id = (!empty($params['editid'])?$params['editid']:''); 
        $guarantorDetail           = $this->renderGuarantorDetail($params);
        $savepersonalInfo          = $this->Loan_customer_info->saveUpdateGuarantorDetails($guarantorDetail,$id);
              $action = '0';  
        
        if(!empty($savepersonalInfo)){
           
                $result= array('status'=>'True','message'=>'Guarantor Details Added Successfully','Action'=>  base_url().'uploadDocs/' . base64_encode('CustomerId_' . $params['caseId']));
           // }
        }
        echo json_encode($result);exit;
    }
    public function renderGuarantorDetail($params){
        $financeAcedmic                            = [];
        if(!empty($params)){
        $financeAcedmic['highest_education']       = !empty($params['highest_education'])?$params['highest_education']:'';
        $financeAcedmic['profession_type']         = !empty($params['profession_type'])?$params['profession_type']:'';
        $financeAcedmic['industory_detail']        = !empty($params['industory_detail'])?$params['industory_detail']:'';
        $financeAcedmic['annual_income']           = !empty($params['annual_income'])?trim($params['annual_income']):'';
        $financeAcedmic['type_of_vehicle_owned']   = !empty($params['type_of_vehicle_owned'])?$params['type_of_vehicle_owned']:'';
        $financeAcedmic['vehicle_ownership']       = !empty($params['vehicle_ownership'])?$params['vehicle_ownership']:'';
        //$financeAcedmic['office']                  = !empty($params['office'])?$params['office']:'';
        $financeAcedmic['office_landmark']          = !empty($params['office_landmark'])?ucwords(strtolower(trim($params['office_landmark']))):'';
         $financeAcedmic['office_address']          = !empty($params['office_address'])?ucwords(strtolower(trim($params['office_address']))):'';
        $financeAcedmic['office_pincode']          = !empty($params['office_pincode'])?trim($params['office_pincode']):'';
        $financeAcedmic['office_phone']            = !empty($params['office_phone'])?trim($params['office_phone']):'';
        $financeAcedmic['office_mobile']           = !empty($params['office_mobile'])?trim($params['office_mobile']):'';
        $financeAcedmic['office_email']            = !empty($params['office_email'])?trim($params['office_email']):'';
        $financeAcedmic['office_city']             = !empty($params['office_cityList'])?$params['office_cityList']:'';
         $bus_start_business_date = explode('-', $params['bus_start_business_date']);
        $financeAcedmic['case_id']       =  $params['caseId'];
        $financeAcedmic['employment_type']   =  !empty($params['employment_type'])?$params['employment_type']:'';
        $financeAcedmic['employer_name']       = !empty($params['employer_name'])?ucwords(strtolower(trim($params['employer_name']))):'';
        $financeAcedmic['employee_doj']         = !empty($params['date_of_joining'])?date('Y-m-d',strtotime($params['date_of_joining'])):'';
        $financeAcedmic['totalexp']        = !empty($params['total_experience'])?trim($params['total_experience']):'';
        $financeAcedmic['gross_mon_income']           = !empty($params['monthly_income'])?trim($params['monthly_income']):'';
        $financeAcedmic['is_notice_period']           = !empty($params['notice_period'])?trim($params['notice_period']):'';
        
       // if($params['empType']=='2'){
        $financeAcedmic['bus_applicant_type']   = !empty($params['bus_applicant_type'])?$params['bus_applicant_type']:'';
        $financeAcedmic['bus_industry_type']       = !empty($params['bus_industry_type'])?$params['bus_industry_type']:'';
        $financeAcedmic['bus_business_name']                  = !empty($params['bus_business_name'])?ucwords(strtolower(trim($params['bus_business_name']))):'';
        $financeAcedmic['bus_off_set_up']          = !empty($params['bus_office_setup_type'])?$params['bus_office_setup_type']:'';
        $financeAcedmic['bus_start_business_mon']  = !empty($bus_start_business_date[0])?$bus_start_business_date[0]:'';
        $financeAcedmic['bus_start_business_year'] = !empty($bus_start_business_date[1])?$bus_start_business_date[1]:'';
        $financeAcedmic['bus_itr_income1']           = !empty($params['bus_itr_income1'])?trim($params['bus_itr_income1']):'';
        $financeAcedmic['bus_itr_income2']            = !empty($params['bus_itr_income2'])?trim($params['bus_itr_income2']):'';
       /// }
       // if($params['empType']=='3'){
        $financeAcedmic['pro_off_set_up']               = !empty($params['pro_office_setup_type'])?$params['pro_office_setup_type']:'';
        $financeAcedmic['pro_itr_income1']              = !empty($params['pro_itr_income1'])?trim($params['pro_itr_income1']):'';
        $financeAcedmic['pro_itr_income2']              = !empty($params['pro_itr_income2'])?trim($params['pro_itr_income2']):'';
        $financeAcedmic['pro_industry_type']            = !empty($params['pro_industry_type'])?$params['pro_industry_type']:'';
        $financeAcedmic['pro_start_date_mon']           = !empty($params['pro_start_date_month'])?$params['pro_start_date_month']:'';
        $financeAcedmic['pro_start_date_year']          = !empty($params['pro_start_date_year'])?$params['pro_start_date_year']:'';
      //  }
      //  if($params['empType']=='4'){
        $financeAcedmic['oth_type']                     = !empty($params['oth_type'])?$params['oth_type']:'';
        $financeAcedmic['oth_customer_own']             = !empty($params['others_followup'])?$params['others_followup']:'';
        $financeAcedmic['oth_customer_taken_loan']      = !empty($params['others_loan'])?$params['others_loan']:'';
        $financeAcedmic['branch_name']                     = !empty($params['bank_branch'])?$params['bank_branch']:'';
        $financeAcedmic['bank_id']                     = !empty($params['bank_name'])?$params['bank_name']:'';
        $financeAcedmic['account_no']                     = !empty($params['account_no'])?$params['account_no']:'';
        $financeAcedmic['ifci_code']                     = !empty($params['ifsc_code'])?$params['ifsc_code']:'';
        $financeAcedmic['account_type']                     = !empty($params['account_type'])?$params['account_type']:'';
        //}
        if(empty($params['editid']))
        {
            $financeAcedmic['created_on'] = date('Y-m-d H:i:s');
            $financeAcedmic['created_by'] = $this->session->userdata['userinfo']['id'];    
        }
        $financeAcedmic['updated_by'] = $this->session->userdata['userinfo']['id'];        
    }
        return $financeAcedmic;
    }
}

