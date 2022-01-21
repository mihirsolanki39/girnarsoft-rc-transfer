<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Insurance
 * Insurance Class for user|executive.
 * @author : Rakesh kumar
 */
class Insurance extends BaseController
{
    public $activity_mapping = array('status' => '1', 'comment' => '2', 'followup' => '3');
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        //$this->load->library('Phpmailer');
        $this->dateTime=date('Y-m-d H:i:s');
        $this->load->model('Crm_insurance');
        $this->load->model('Crm_insurance_part_payment');
        $this->load->model('Crm_user');
        $this->load->model('Crm_dealers');
        $this->load->model('City');
        $this->load->model('Make_model');
        $this->load->library('form_validation');
        $this->load->model('state_list');
        $this->load->model('Crm_previous_insurer');
        $this->load->model('Crm_insurance_customer_status');
        $this->load->model('Crm_insurance_company');
        $this->load->model('Rolemodel');
        $this->load->model('Crm_upload_docs_list');
        $this->load->model('UserDashboard');
        $this->load->model('Crm_renew');
        $this->load->model('Crm_inspection_status');
        $this->load->helpers('range_helper');
        $this->load->helpers('date_helper');
        $this->load->helpers('crm_helper');
        $this->load->helpers('insurance_helper');
        $this->load->model('Crm_banks');
        $this->load->library('excel');
        $this->load->helper('exportinsdata');
         if(!$this->session->userdata['userinfo']['id']){
             return redirect('login');
            }
             //error_reporting(1);
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'CodeInsect : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * This function is used to load the add new form
     */
    function addNew($id='')
    {
            $editId      = !empty($id)? explode('_',base64_decode($id)):'';
            $customerId  = !empty($editId)?end($editId):'';
            $userInfo=$this->session->userdata['userinfo'];
            $data=[];
            $leadNotIn=[4];
            $roleType=array('Executive','Lead');
            if(!empty($customerId)){        
            $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
            $data['customerId']     = !empty($customerId)?$customerId:'';
            $data['CustomerInfo'] = !empty($customerName)?$customerName:'';
            }
            $data['lead_status'] = $this->Crm_insurance_customer_status->getCustomerStatus($leadNotIn);
            $data['role'] = $this->Rolemodel->getRoleNameByteam();
            $data['employeeList'] =  $this->Crm_user->getEmployee('3','',$roleType);
            $data['salesList'] =  $this->Crm_user->getEmployee('5','','');
            $data['dealerList']     =  $this->Crm_dealers->getDealers('','0,1,2');
            $data['permission']     =  $this->Crm_insurance->getUserRole($userInfo['role_id'],'addInsurance');
            $data['insCat']=['1'=>'New Car','2'=>'Used Car Purchase','3'=>'Renewal','4'=>'Policy Already Expired'];
            $data['pageTitle'] = 'Add New Insurance';
            $data['pageType'] = 'insurance';            
            $this->loadViews("insurance/addEditinsuranceCase",$data);    
    }
    public function addInsHistory($case_id,$activity,$details='-',$bank_id,$remark='')
    {
        $data = [];
        $data['case_id'] = $case_id;
        $data['activity'] = $activity;
        $data['bank_details'] = $details;
        $data['bank_id']    =  $bank_id;
        $data['remark'] = $remark;
        $this->Crm_insurance->addInsHistory($data);
    }
    public function addInsHistoryUpdateLog($case_id,$updated_data=[],$module='-',$status,$action)
    {
        $data = [];
        $data['case_id'] = $case_id;
        $data['updated_data'] = serialize($updated_data);
        $data['module'] = $module;
        $data['status']    =  $status;
        $data['action'] = $action;
        $this->Crm_insurance->addInsHistoryUpdateLog($data);
    }
    public function saveUpdateInsuranceData($id = '') {
        $params = $this->input->post();
        if (!empty($params['step1'])) {
            $validationCheck=$this->insDetailFormValidation($params);
           if(!empty($validationCheck)){
                echo  json_encode($validationCheck);
            }else{
            $params['created_date']=date('Y-m-d H:i:s');
            $params['customer_name']=(!empty($params['customer_name'])) ? getUpperCase($params['customer_name']) : '';
            $params['customer_company_name']=(!empty($params['customer_company_name'])) ? getUpperCase($params['customer_company_name']) : '';
            $params['isexpired']=(!empty($params['isexpired'])) ? $params['isexpired'] : '0';
            if(!empty($params['customerId'])){  
                $caseDetails=current($this->Crm_insurance->getCaseDetailsByCustomerId($customerId));
                $customerId = $this->Crm_insurance->addInsuranceCase($params,$params['customerId'],$caseDetails['left_menu_status'],1);
                $this->addInsHistoryUpdateLog($caseDetails['id'],$params,'caseDetail','1','1');           
            }else{
                $customerId = $this->Crm_insurance->addInsuranceCase($params);
                $caseDetails=current($this->Crm_insurance->getCaseDetailsByCustomerId($customerId));
                $this->addInsHistoryUpdateLog($caseDetails['id'],$params,'caseDetail','1','0');
                $histArr=array();
                $histArr['company_id']='';
                $histArr['customer_id']=$customerId;
                $histArr['created_date']=date('Y-m-d H:i:s');
                $histArr['history_type']='insurance';
                $histArr['source']='case_added';
                $histArr['activity_text']='Case Added';
               // echo "<pre>";print_r($histArr);die;
                $this->saveInsHistory($histArr);
            }
            $params['customer_id'] = !empty($customerId) ? $customerId : '';
            if(!empty($customerId)){
            $result= array('status'=>'True','message'=>'Insurance Case Details Added Successfully','Action'=>  base_url().'insvehicalDetail/' . base64_encode('customerId_' . $customerId));
                }
            echo json_encode($result);exit;
            }
        }
        
        if (!empty($params['step2'])) {
            //print_r($params);die;
            $validationCheck=$this->inspersonalFormValidation($params);
            if(!empty($validationCheck)){
                echo  json_encode($validationCheck);exit;
            }else{
            $customerLeadId = current($this->Crm_insurance->getcustomerLeadIdById($params['customerId']));
            //$loanCustomer=current($this->Crm_insurance->getloanleadDetailsById($customerLeadId));    
             $postcustomerextraData=[];   
            if(isset($params['isaddress']) && $params['isaddress']=='1'){
            $postcustomerextraData = array(
                'iscustomerAddress' => $params['isaddress'],
                'customer_nominee_address' => $params['customer_address'],
                'customer_nominee_pincode' => $params['customer_pincode'],
                'customer_nominee_city' => $params['customer_city']
            );   
            }    
            $postcustomerData = array(
                'customer_address' => getUpperCase($params['customer_address']),
                'customer_city_id' => $params['customer_city'],
                'customer_pincode' => $params['customer_pincode'],
                'customer_gender' => (isset($params['customer_gender'])) ? $params['customer_gender']:'',
                'customer_marital' => (isset($params['customer_marital'])) ? $params['customer_marital']:'',
                'customer_dob' => (isset($params['customer_dob'])) ? date('Y-m-d',strtotime($params['customer_dob'])):'',
                'customer_occupation' => (isset($params['customer_occupation'])) ? $params['customer_occupation']:'',
                'customer_aadhaar' => (isset($params['customer_aadhar'])) ? $params['customer_aadhar'] : '',
                'customer_pan_no' => (isset($params['customer_pan'])) ? $params['customer_pan'] : '',
                'iscustomerAddress' => 2,
                'customer_gst_no' => (isset($params['customer_gst']))?$params['customer_gst']:'0',
                'iscustomerAddress' => 2,
                'customer_nominee_address' => (isset($params['nominee_customer_address'])) ? getUpperCase($params['nominee_customer_address']):'',
                'customer_nominee_pincode' => (isset($params['nominee_customer_pincode'])) ? $params['nominee_customer_pincode']:'',
                'customer_nominee_city' => (isset($params['nominee_customer_city'])) ? $params['nominee_customer_city']:'',
                'customer_nominee_name' => (isset($params['nominee_customer_name'])) ? getUpperCase($params['nominee_customer_name']):'',
                'customer_nominee_relation' => (isset($params['nominee_customer_relation'])) ? $params['nominee_customer_relation']:'',
                'customer_nominee_age' => (isset($params['nominee_customer_age'])) ? $params['nominee_customer_age']:'',
                'customer_nominee_ref_name' => (isset($params['reference_customer_name'])) ? getUpperCase($params['reference_customer_name']):'',
                'customer_nominee_ref_phone' => (isset($params['reference_customer_mobile'])) ? $params['reference_customer_mobile']:''
                
            );
            if($customerLeadId!=''){
              $postPersonalcustomerData = array(
                'address' => $params['customer_address'],
                'pincode' => $params['customer_pincode'],
                'city_id' => $params['customer_city'],
                'customer_aadhar_no' => (isset($params['customer_aadhar'])) ? $params['customer_aadhar'] :'',
                'customer_pan_no' => $params['customer_pan']
                
            );
              $customerId = $this->Crm_insurance->updatePersonalCustomerDetails($postPersonalcustomerData,$customerLeadId);
            }
            $postcustomerData=array_merge($postcustomerData,$postcustomerextraData);
            $customerId = $this->Crm_insurance->addInsuranceCustomer($postcustomerData,$params['customerId']);
            $caseDetails=current($this->Crm_insurance->getCaseDetailsByCustomerId($params['customerId']));
             $left_menu_status = INSURANCE_LEFT_SIDE_MENU['CUSTOMER_DETAILS'];
               if($caseDetails['left_menu_status'] < $left_menu_status){
               $userInfo['left_menu_status'] = $left_menu_status;
               $caseDetails=$this->Crm_insurance->addInsuranceCases($userInfo,$caseDetails['id']); 
            }        
            
            $this->addInsHistoryUpdateLog($caseDetails['id'],$params,'customerDetail','1','1');
            $params['customer_id'] = !empty($customerId) ? $customerId : '';
             $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
            if(!empty($customerId)){
            $InsCategory=current($this->Crm_insurance->getCaseDetailsByCustomerId($params['customer_id']));
            if($customerName['mi_funding']=='2'){
            $result= array('status'=>'True','message'=>'Customer Details Added Successfully','Action'=>  base_url().'inspaymentDetail/' . base64_encode('customerId_' . $customerId));
            }
            else
            {
               $result= array('status'=>'True','message'=>'Customer Details Added Successfully','Action'=>  base_url().'insPolicyDetails/' . base64_encode('customerId_' . $customerId)); 
            }
            
        }
        echo json_encode($result);exit;
            }
        }
        
        if (!empty($params['step3'])) {
            $validationCheck=$this->insVehicalFormValidation($params);
            if(!empty($validationCheck)){
                echo  json_encode($validationCheck);exit;
            }else{
               $cat=$this->Crm_insurance->getcatId($params['customerId']);
               if(!empty($cat) && (($cat=='2') || ($cat=='3') || ($cat=='4'))){
               if(!empty($params['regNo'])){
                   $zone=$this->Crm_insurance->getZonefromRegNo($params['regNo']);
               }
               if(!empty($params['makemonth']) && !empty($params['myear'])){
                   $carAge=$this->Crm_insurance->getCarAge($params['makemonth'],$params['myear']);
               }
               }elseif(!empty($cat) && ($cat=='1')){
                   $zone=$this->Crm_insurance->getZonefromCity($params['car_city']);
                   $carAge=1;
               }
               if(!empty($params['variant'])){
                   $carCC=$this->Crm_insurance->getCarCC($params['variant']);
               }
               
               $postcaseData = array(
                'make' => $params['make'],
                'model' => $params['model'],
                'variantId' => $params['variant'],
                'engineNo' => (!empty($params['engine_no']))?$params['engine_no']:'',
                'chasisNo' => (!empty($params['chassis_no'])) ? $params['chassis_no']:'',
                'make_month' => $params['makemonth'],   
                'make_year' => $params['myear'],
                //'reg_month' => (!empty($params['regmonth'])) ? $params['regmonth'] :'',   
                //'reg_year' => (!empty($params['regyear'])) ? $params['regyear'] :'',
                'reg_date' => (!empty($params['reg_date'])) ? date('Y-m-d',strtotime($params['reg_date'])) :'',   
                'regNo' => (!empty($params['regNo'])) ? $params['regNo'] :'',
                'zone' => (!empty($zone)) ? $zone :'',
                'car_age' => (!empty($carAge)) ? $carAge :'',
                'cc' => (!empty($carCC)) ? $carCC :'',
                'car_city' => !empty($params['car_city']) ? $params['car_city'] :'',   
                   
            );    
            $caseDetails=current($this->Crm_insurance->getCaseDetailsByCustomerId($params['customerId']));
            if(!empty($params['engine_no']) && !empty($params['chassis_no'])){

               $isExist=$this->Crm_insurance->checkduplicateCase($params['engine_no'],$params['chassis_no'],$caseDetails['id'],180);
               if(!empty($isExist) ){
                $result= array('status'=>'False','message'=>'<span class="duplicatecheck"> Case Already Exists with Case ID - '.$isExist.' </span>','errortype' => 2,'titlehead' => 'Duplicate Case' ,'caseids' => $isExist );   
                echo json_encode($result);exit;
               } 
            }
            $left_menu_status = INSURANCE_LEFT_SIDE_MENU['VEHICLE_DETAILS'];
            if($caseDetails['left_menu_status'] < $left_menu_status){
               $postcaseData['left_menu_status'] = $left_menu_status;
            }
            $customerId = $this->Crm_insurance->updateInsuranceCase($postcaseData,$params['customerId']);
            $caseDetails=current($this->Crm_insurance->getCaseDetailsByCustomerId($params['customerId']));
             $this->addInsHistoryUpdateLog($caseDetails['id'],$params,'vehicleDetail','1','1');
            $params['customer_id'] = !empty($customerId) ? $customerId : '';
            $customerName = current($this->Crm_insurance->getCustomerInfo($params['customerId']));
            if($customerName['zone']!='' && $customerName['car_age']!='' && $customerName['cc']!=''){
                $quotes=$this->Crm_insurance->getNewInsQuotesByCustomerId($params['customerId']);
                if(!empty($quotes)){
                    $quotes[0]['inscat']=$customerName['ins_category'];
                    foreach($quotes as $qk=>$vq){
                        $this->Crm_insurance->setFinalQuotesData($customerId,$vq,'1');
                    }
                }
            }
            if(!empty($customerId)){
            $result= array('status'=>'True','message'=>'Vehicle Details Added Successfully','Action'=>  base_url().'insFileLogin/' . base64_encode('customerId_' . $customerId));   
            }
            echo json_encode($result);exit;
            } 
            
        }
        
        if (!empty($params['step9'])) {
           $validationCheck = $this->insFileLoginValidation($params);
            if(empty($validate))
            {
            $loopCount = count($params['idv_amt']);
            $quotesArr=[];
            $j = 0;
            $caseData=current($this->Crm_insurance->getCaseDetailsByCustomerId($params['customerId']));
            $caseId=$caseData['id'];
            $quoteId = current($this->Crm_insurance->checkExistsQuotes($params['customerId']));
            if($quoteId['id'] > 0){
              $data['is_latest']='0';  
              $customerId = $this->Crm_insurance->updateInsuranceQuotes($data,$params['customerId']);  
            }
           for($i = 1;$i<=$loopCount;)
            {
                $histArr=[]; 
                $quotesArr['customer_id']=$params['customerId'];
                $quotesArr['case_id']=$caseId;
                $quotesArr['insurance_company']=$params['insId'][$j];
                $quotesArr['idv']=str_replace(",","",$params['idv_amt'][$j]);    
                $quotesArr['premium']=str_replace(",","",$params['premium_amt'][$j]);   
                $quotesArr['duration']=$params['idv_duration'][$j];
                $quotesArr['logo']=$params['inslogo'][$j];
                $quotesArr['is_latest']='1';
                $quotesArr['updated_on']=date('Y-m-d H:i:s');
                $quotesArr['sms']=(isset($params['instype'][$j])) ? '1' : '';
                $histArr['company_id']=$params['insId'][$j];
                $histArr['customer_id']=$params['customerId'];
                $histArr['created_date']=date('Y-m-d H:i:s');
                $histArr['history_type']='insurance';
                $histArr['source']='quotes';
                $histArr['activity_text']='Quotes Shared';
                $qhStatus =$this->Crm_insurance->checkalreadyExistsQuotes($quotesArr);
                if(empty($qhStatus)){
                $this->saveInsHistory($histArr);
                }
              $i++;
              $j++;
           //$qStatus = $this->Crm_insurance->checkalreadyExistsQuotes($quotesArr);
           //if(empty($qStatus)){
           $customerId = $this->Crm_insurance->addInsuranceQuotes($quotesArr);
           //}
           $caseArr=array();
           $caseArr['quote_add_date']=date('Y-m-d H:i:s');
           $caseArr['quote_shared_status']='1';
           $caseArr['last_updated_date']=date('Y-m-d H:i:s');
           $lastStatusArr=$this->Crm_insurance->getlastStatusId($params['customerId']);
           if(!empty($lastStatusArr[0]['lastStatus']) &&  ($lastStatusArr[0]['lastStatus'] < '2')){
           $caseArr['last_updated_status']='2';
           }
            $left_menu_status = INSURANCE_LEFT_SIDE_MENU['INSURANCE_QUOTES'];
            if($caseData['left_menu_status'] < $left_menu_status){
               $caseArr['left_menu_status'] = $left_menu_status;
            }
           $this->Crm_insurance->updateInsuranceCaseById($caseArr,$caseId);
           $this->addInsHistoryUpdateLog($caseId,$params,'Quotes','1','1');
           }
           if($customerId){
            $this->Crm_insurance->getsmsQuotes($params['customerId']);
           }
           if(!empty($customerId)){
            $customerIds=$params['customerId']; 
            $result= array('status'=>'True','message'=>'Insurance Quotes Updated Successfully','Action'=>  base_url().'inspersonalDetail/' . base64_encode('customerId_' . $customerIds));   
            echo  json_encode($result);exit;
            }
            }else{
                echo  json_encode($validationCheck);exit;
            }
           
       }
        
        if (!empty($params['step4'])) {
            $validationCheck=$this->insPreviousPolicyValidation($params);
            if(!empty($validationCheck)){
                echo  json_encode($validationCheck);exit;
            }else{
               $postcaseData = array(
                'previous_insurance_company' => $params['ins_company'],
                'previous_issue_date' => date('Y-m-d',strtotime($params['previous_issue_date'])),
                'previous_policy_type' => $params['previous_policy_type'],
                'previous_policy_no' => addslashes(trim($params['previous_policy_no'])),
                'previous_due_date' => date('Y-m-d',strtotime($params['previous_due_date'])),
                'previous_claim_taken' => $params['previous_claim_taken'],
                'previous_ncb_discount' => rtrim($params['previous_ncb_discount'],"%")
            );    
            $customerId = $this->Crm_insurance->addInsuranceCustomer($postcaseData,$params['customerId']);
            $caseDetails=current($this->Crm_insurance->getCaseDetailsByCustomerId($params['customerId']));
             $left_menu_status = INSURANCE_LEFT_SIDE_MENU['PREVIOUS_POLICY'];            
            if($caseDetails['left_menu_status'] < $left_menu_status){
               $caseArr = array();
               $caseArr['left_menu_status'] = $left_menu_status;
               $this->Crm_insurance->updateInsuranceCaseById($caseArr,$caseDetails['id']);
            }
            $this->addInsHistoryUpdateLog($caseDetails['id'],$params,'previousPolicyDetail','1','1');
            $params['customer_id'] = !empty($customerId) ? $customerId : '';
            if(!empty($customerId)){
            $InsCategory=current($this->Crm_insurance->getCaseDetailsByCustomerId($params['customerId']));
            // print_r($InsCategory); die();
            $ins_category=$InsCategory['ins_category'];
            if($ins_category=='1'){ 
            $result= array('status'=>'True','message'=>'Previous Policy Details Added Successfully','Action'=>  base_url().'inspersonalDetail/' . base64_encode('customerId_' . $customerId));    
            }elseif($ins_category=='2' || $ins_category=='4'){ 
            $result= array('status'=>'True','message'=>'Previous Policy Details Added Successfully','Action'=>  base_url().'insInspection/' . base64_encode('customerId_' . $customerId));    
            }elseif($ins_category=='3'){ 
            $result= array('status'=>'True','message'=>'Previous Policy Details Added Successfully','Action'=>  base_url().'inspersonalDetail/' . base64_encode('customerId_' . $customerId));    
            }elseif($ins_category=='4'){ 
            $result= array('status'=>'True','message'=>'Previous Policy Details Added Successfully','Action'=>  base_url().'inspersonalDetail/' . base64_encode('customerId_' . $customerId));    
            }else{   
            $result= array('status'=>'True','message'=>'Previous Policy Details Added Successfully','Action'=>  base_url().'inspersonalDetail/' . base64_encode('customerId_' . $customerId));
            }
        }
        echo json_encode($result);exit;
            } 
            
        }
        
        if (!empty($params['step10'])) {
            if(!empty($params)){
            $loopCount = count($params['reference_no']);
            $insArr=[];
            $j = 0;
            $caseData=current($this->Crm_insurance->getCaseDetailsByCustomerId($params['customerId']));
            $caseId=$caseData['id'];
            $inspectId = current($this->Crm_insurance->checkExistsInspect($params['customerId']));
            if($inspectId['id'] > 0){
              $data['is_latest']='0';  
              $customerId = $this->Crm_insurance->updateInspection($data,$params['customerId']);  
            }
           for($i = 1;$i<=$loopCount;)
            {
                $histArr=array();
                $iscompArr=array();
                $iscomp='';
                $iscompleted='';
                $insArr['customer_id']=$params['customerId'];
                $insArr['case_id']=$caseId;
                $insArr['inspect_company']=$params['insId'][$j];
                $insArr['inspect_status']=$params['ins_status_'.$j];    
                $insArr['inspect_reference_no']=$params['reference_no'][$j];   
                $insArr['inspect_comment']=$params['ins_comment'][$j];
                $insArr['logo']=!empty($params['inslogo'][$j]) ? $params['inslogo'][$j] : '';
                $insArr['sms']=(isset($params['instype'][$j])) ? '1' : '';
                //$iscomp=!isset($params['ins_status_'.$j]) ? $params['ins_status_'.$j] : '0';
                //$iscompArr=explode("_",$iscomp);
                $iscompleted=(isset($params['ins_status_'.$j]) && ($params['ins_status_'.$j]=='1')) ? '1' : '0';
                $insArr['priority']=$iscompleted;
                $insArr['is_latest']='1';
                $insArr['updated_on']=date('Y-m-d H:i:s'); 
                $histArr['company_id']=$params['insId'][$j];
                $histArr['customer_id']=$params['customerId'];
                $histArr['created_date']=date('Y-m-d',strtotime($params['inspection_date']));
                $histArr['history_type']='insurance';
                $histArr['source']='inspection';

                $histArr['activity_text']=(isset($iscompleted) && ($iscompleted=='1')) ? 'Inspection Completed' : 'Inspection Pending';

             
                $this->saveInsHistory($histArr);
              $i++;
              $j++;
           
           $customerId = $this->Crm_insurance->addInspectionData($insArr);
           $inspectDate['inspection_add_date']=date('Y-m-d',strtotime($params['inspection_date']));
           $inspectDate['inspection_status']='1';
           $inspectDate['last_updated_date']=date('Y-m-d H:i:s');
           $inspectFlag='';
           $inspectArr=$this->Crm_insurance->getInspectionList($params['customerId']);
           if(!empty($inspectArr)){
               foreach($inspectArr as $ink=>$inv){
                   if($inv['inspect_status']=='1'){
                     $inspectFlag=true;  
                   }
               }
           }
           $lastStatusArr=$this->Crm_insurance->getlastStatusId($params['customerId']);
           if(!empty($lastStatusArr[0]['lastStatus']) && (isset($iscompleted) && ($iscompleted=='1'))){
           $inspectDate['last_updated_status']='4';
           }else{
           $inspectDate['last_updated_status']='3';    
           }
           $left_menu_status = INSURANCE_LEFT_SIDE_MENU['INSPECTION'];            
            if($caseData['left_menu_status'] < $left_menu_status){
               $inspectDate['left_menu_status'] = $left_menu_status;
            }   
           $this->Crm_insurance->updateInsuranceCaseById($inspectDate,$caseId);
           $this->addInsHistoryUpdateLog($caseId,$params,'Inspection','1','1');
            }
            $mess= 'Inspection Done Successfully';
            if($insArr['inspect_status']=='0')
            {
               $mess= 'Status Updated Successfully'; 
            }
           if(!empty($customerId))
            {
               $this->Crm_insurance->getsmsInspection($params['customerId']); 
               $results= array('status'=>'True','message'=>$mess,'Action'=>  base_url().'inspersonalDetail/' . base64_encode('customerId_' . $params['customerId']));
                echo  json_encode($results);exit;
            }
            }else{
                echo  json_encode($validationCheck);exit;
            }
           
            }
        
        
        if (!empty($params['step5'])) {
            $centralStock = []; 
            $validationCheck=$this->insPolicyValidation($params);
            if(!empty($validationCheck)){
                echo  json_encode($validationCheck);exit;
            }else{
            //echo "hiiiiiiiiiiiiiiiii"; die();
                $getInsInfo = $this->Crm_insurance->getCustomerInfo($params['customerId']);        
                ########   save payout related details  start###########
                        $addOn = 0;
                        $od_amount = 0;
                        $percentage = 0;
                        $payoutPSPercentage = 0;
                        if(($getInsInfo[0]['source_id']==1) || ($getInsInfo[0]['source_id']==0)){
                         $payoutPercentage = $getInsInfo[0]['new_ins_company'];
                       $payoutPercentage  = $this->Crm_insurance->fetchData('crm_insurance_company_percentage',array('payout_percentage'),array('ref_id'=>$getInsInfo[0]['new_ins_company']),array('type'=>'1'));
                        }else{
                         $payoutPercentage  = $this->Crm_insurance->fetchData('crm_insurance_company_percentage',array('payout_percentage'),array('ref_id'=>$getInsInfo[0]['source_id']),array('type'=>'2'));

                        }
                    $payoutPSPercentage = $payoutPercentage['payout_percentage'];

                        $od_amount = $getInsInfo[0]['own_damage'];
                        
                        if ($getInsInfo[0]['road_side_assistance'] == '1') {
                            $addOn = (int) $getInsInfo[0]['road_side_assistance_txt'];
                        }
                        if ($getInsInfo[0]['loss_of_personal_belonging'] == '1') {
                            $addOn += (int) $getInsInfo[0]['loss_of_personal_belonging_txt'];
                        }
                        if ($getInsInfo[0]['emergency_transport_hotel_premium'] == '1') {
                            $addOn += (int) $getInsInfo[0]['emergency_transport_hotel_premium_txt'];
                        }

                        if ($getInsInfo[0]['driver_cover'] == '1') {
                            $driver_cover = (int) $getInsInfo[0]['paid_driver'];
                        }
                        if ($getInsInfo[0]['personal_acc_cover'] == '1') {
                            $personal_acc_cover = (int) $getInsInfo[0]['personal_acc_cover'];
                        }
                        if ($getInsInfo[0]['passenger_cover'] == '1') {
                            $passenger_cover = $getInsInfo[0]['pass_cover'];
                        }
                        if ($getInsInfo[0]['anti_theft'] == '1') {
                            $addOn -= $getInsInfo[0]['anti_theft_txt'];
                        }
                        if ($getInsInfo[0]['add_on']) {
                            $addOn += $getInsInfo[0]['add_on'];
                        }

             $ownDamageAmount = !empty($getInsInfo[0]['own_damage'])?$getInsInfo[0]['own_damage']:0;
             $addOn = !empty($addOn)?$addOn:0;
             $payoutPSPercentage = !empty($payoutPSPercentage)?$payoutPSPercentage:0;
             $totalPayoutAmount  = round((($addOn + $ownDamageAmount)*$payoutPSPercentage)/100);
             /*$policy_no = !empty($getInsInfo[0]['current_policy_no'])?$getInsInfo[0]['current_policy_no']:"";*/

             
             if($params['policy_issued']=='1'){
               $policy_no = addslashes($params['policy_no']); 
              }else{
               $policy_no = '';  
              }
            $serialNo = !empty($getInsInfo[0]['sno'])?$getInsInfo[0]['sno']:"";     
            $payoutDataArray = array(
                                     'payout_amount'    => $totalPayoutAmount,
                                     'percentage'       => $payoutPSPercentage,
                                     'policy_no'        => $policy_no,
                                     'policy_issued'    => $params['policy_issued'],
                                     'addon_amount'     => $addOn,
                                     'own_damage'       => $ownDamageAmount,
                                     'case_id'          => $serialNo,
                                     'created_on'       => date('Y-m-d H:i:s'),
                                    );
            
             
           $policyExistancy =  $this->Crm_insurance->fetchData('crm_insurance_payout_details',array('id'),array('policy_no'=>$policy_no));

           $policy_id = "";
            if(!empty($policyExistancy['id'])){
             $policy_id =  $policyExistancy['id'];
             $payoutDataArray['updated_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
            }else{
                $payoutDataArray['created_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
            }
              $this->Crm_insurance->saveData('crm_insurance_payout_details',$payoutDataArray,$policy_id); 
                ########   save payout related details  ends  by Masawwar Ali###########

                $postcaseData = array(
                'current_insurance_company' => $params['ins_company'],
                'current_issue_date' => date('Y-m-d',strtotime($params['issue_date'])),
                'inception_date' => date('Y-m-d',strtotime($params['inception_date'])),
                'current_policy_type' => $params['policy_type'],
                'current_policy_no' => addslashes($params['policy_no']),
                'current_due_date' => date('Y-m-d',strtotime($params['due_date'])),
                'current_ncb_discount' => str_replace("%","",$params['ncb_discount']),
                'current_policy_issued' => $params['policy_issued'],
                'current_covernote_no' => $params['covernote_no'],
                'current_ins_duration' => $params['ins_duration'],
                'current_loan_taken' => !empty($params['loan_taken']) ? $params['loan_taken'] : '0',
                'current_hp_to' => !empty($params['hp_to']) ? $params['hp_to'] :'',    
                'idv' => str_replace(",","",$params['idv']),
                'premium' => str_replace(",","",$params['premium'])   
            ); 
            $centralStock['loan_for']         = (!empty($getInsInfo[0]['ins_category']) && ($getInsInfo[0]['ins_category']=='1'))?$getInsInfo[0]['ins_category']:'2';
            $centralStock['make_id']         = !empty($getInsInfo[0]['make'])?$getInsInfo[0]['make']:'';
            $centralStock['model_id']        = !empty($getInsInfo[0]['model'])?$getInsInfo[0]['model']:'';
            $centralStock['version_id']      = !empty($getInsInfo[0]['variantId'])?$getInsInfo[0]['variantId']:'';
            $centralStock['mm']      = !empty($getInsInfo[0]['make_month'])?$getInsInfo[0]['make_month']:'';
            $centralStock['myear']      = !empty($getInsInfo[0]['make_year'])?$getInsInfo[0]['make_year']:'';
            $centralStock['insurance_case_id']    = !empty($getInsInfo[0]['id'])?$getInsInfo[0]['id']:'';
            $centralStock['insurance_customer_id']       = !empty($getInsInfo[0]['crm_customer_id'])?$getInsInfo[0]['crm_customer_id']:'';
            $centralStock['reg_no']          = !empty($getInsInfo[0]['regNo'])?strtoupper($getInsInfo[0]['regNo']):'';
            $centralStock['engine_no']  = !empty($getInsInfo[0]['engineNo'])?strtoupper($getInsInfo[0]['engineNo']):'';
            $centralStock['chassis_no'] = !empty($getInsInfo[0]['chasisNo'])?strtoupper($getInsInfo[0]['chasisNo']):'';
            $centralStock['insurance_expire'] = date('Y-m-d',strtotime($params['due_date']));
            $this->crmCentralStockData($centralStock,'Insurance');
            $cntcustomerId = $this->Crm_insurance->addInsuranceCustomer($postcaseData,$params['customerId']);
            if($cntcustomerId >0){
            //$caseArr['last_updated_date']=date('Y-m-d H:i:s');
            //$caseArr['last_updated_status']='6';
            $caseArr['renew_flag']='0';
            }
            //echo $lastStatusArr[0]['lastStatus']."++++"$params['policy_issued']."+++++".$params['policy_issued'];
            $lastStatusArr=$this->Crm_insurance->getlastStatusId($params['customerId']);
            $lastStatusArr[0]['lastStatus'];
            if(!empty($lastStatusArr[0]['lastStatus']) && ($params['policy_issued']=='1') && ($lastStatusArr[0]['lastStatus'] == '6')){
                 $caseArr['last_updated_status']= $lastStatusArr[0]['lastStatus'];
            }
            if(!empty($lastStatusArr[0]['lastStatus']) && ($params['policy_issued']=='1') && ($lastStatusArr[0]['lastStatus'] <= '9')){
                  $caseArr['last_updated_status']='9';
            }elseif(!empty($lastStatusArr[0]['lastStatus']) && ($params['policy_issued']=='2') && ($lastStatusArr[0]['lastStatus'] <= '9')){
                  $caseArr['last_updated_status']='5'; 
            }
             $status_list = $this->Crm_insurance->getUpdateStatusList();
            $histArr=array();
            $histArr['company_id']='';
            $histArr['customer_id']=$params['customerId'];
            $histArr['created_date']=date('Y-m-d H:i:s');
            $histArr['history_type']='insurance';
            $histArr['source']=$status_list[$caseArr['last_updated_status']];
            $histArr['activity_text']=$status_list[$caseArr['last_updated_status']];
            $this->saveInsHistory($histArr);
            
            $caseArr['policy_status']='1';
            if(isset($getInsInfo[0]['policy_status']) && $getInsInfo[0]['policy_status'] == 0){
              $caseArr['policy_issued_date']=date('Y-m-d H:i:s');
            }
            $caseArr['last_updated_date']=date('Y-m-d H:i:s');
            
            $left_menu_status = INSURANCE_LEFT_SIDE_MENU['NEW_POLICY_DETAILS'];            
            if($caseDetails['left_menu_status'] < $left_menu_status){
               $caseArr['left_menu_status'] = $left_menu_status;
            }  
          //  echo "<pre>";print_r($caseArr);die;
            $this->Crm_insurance->updateInsuranceCase($caseArr,$params['customerId']);
            $caseDetails=current($this->Crm_insurance->getCaseDetailsByCustomerId($params['customerId']));
            $this->addInsHistoryUpdateLog($caseDetails['id'],$params,'policyDetail','1','1');
            $customerId  = !empty($params['customerId']) ? $params['customerId']: '';
            if(!empty($customerId)){
            $result= array('status'=>'True','message'=>'Policy Details Added Successfully','Action'=>  base_url().'insDocumentDetails/' . base64_encode('customerId_' . $customerId));
        }
        echo json_encode($result);exit;
            } 
            
        }
        if (!empty($params['step8'])) {
            $validationCheck=$this->insPaymentValidation($params);
            if(!empty($validationCheck)){
               $result=$validationCheck;
            }else{                 
                if(($params['payment_by']=='1') || ($params['payment_by']=='3')){
                    $postcaseData = array(
                    'payment_by' => $params['payment_by'],
                    'payment_date' => ($params['payment_date']!='') ? date('Y-m-d',strtotime($params['payment_date'])):'0000-00-00',
                    'favouring_to' => $params['cheque_favour'],
                    'payment_mode' => $params['payment_mode'],                   
                    'instrument_no' => $params['instrument_no'],
                    'instrument_date' => ($params['instrument_date']!='') ? date('Y-m-d',strtotime($params['instrument_date'])):'0000-00-00',   
                    'bank_name' => !empty($params['bank_name'])?$params['bank_name']:"", 
                    'receipt_date' => ($params['receipt_date']!='') ? date('Y-m-d',strtotime($params['receipt_date'])):'0000-00-00',  
                    'amount' => str_replace(",","",$params['policy_amt']),
                    'pay_remark' => addslashes($params['pay_remark']),
                    'subvention_amt' => str_replace(",","",$params['subvention_amt'])   
                    );
                    $postcaseData['sisreasonId'] = $params['pay_sis_reason']; 
                    $postcaseData['receipt_no'] = $params['receipt_no'];
                    $postcaseData['reasonId'] = $params['pay_reason']; 
                
                } elseif ($params['payment_by'] == '2') {
                    $postcaseData = array(
                        'payment_by' => $params['payment_by'],
                        'reasonId' => $params['pay_reason'],
                        'in_payment_date' => ($params['in_payment_date'] != '') ? date('Y-m-d', strtotime($params['in_payment_date'])) : '0000-00-00',
                        'in_favouring_to' => $params['in_cheque_favour'],
                        'in_payment_mode' => $params['in_payment_mode'],
                        'in_instrument_no' => $params['in_instrument_no'],
                        'in_instrument_date' => ($params['in_instrument_date'] != '') ? date('Y-m-d', strtotime($params['in_instrument_date'])) : '0000-00-00',
                        'in_bank_name' => $params['in_bank_name'],
                        'in_amount' => str_replace(",", "", $params['in_policy_amt']),
                        'pay_in_remark' => addslashes($params['pay_in_remark']),
                        'in_subvention_amt' => str_replace(",", "", $params['in_subvention_amt'])
                    );
                    if ($params['in_payment_mode'] == '1') {
                        $postcaseData['in_favouring_to'] = $params['in_cheque_favour'];
                    } elseif ($params['in_payment_mode'] == '2') {
                        $postcaseData['sisreasonId'] = $params['pay_sis_reason'];
                    }
                }
                // echo "assasa<pre>"; print_r($params); die();

              if(($params['cpayment_by']=='1') || ($params['cpayment_by']=='3')){
                   $postcaseData = array(
                    'cpayment_by' => $params['cpayment_by'],
                    'sisreasonId' => $params['pay_sis_reason'],   
                    'payment_date' => ($params['payment_date']!='') ? date('Y-m-d',strtotime($params['payment_date'])):'0000-00-00',
                    'favouring_to' => $params['cheque_favour'],
                    'reasonId' => $params['pay_reason'], 
                    'payment_mode' => $params['payment_mode'],
                    'instrument_no' => $params['instrument_no'],
                    'instrument_date' => ($params['instrument_date']!='') ? date('Y-m-d',strtotime($params['instrument_date'])): '0000-00-00',   
                    'bank_name' => $params['bank_name'],   
                    'receipt_no' => $params['receipt_no'],
                    'receipt_date' => ($params['receipt_date']!='') ?  date('Y-m-d',strtotime($params['receipt_date'])):'0000-00-00',  
                    'amount' => str_replace(",","",$params['policy_amt']),
                    'pay_remark' => addslashes($params['pay_remark']),   
                    'subvention_amt' => str_replace(",","",$params['subvention_amt'])    
                    );
              }
              $partPaymentId = !empty($params['partpaymentid'] && $params['partpaymentid']!='undefined' && $params['partpaymentid'] != null) ? $params['partpaymentid'] : null ;
              $entry_type = ( !empty($params['payment_by']) )? $params['payment_by'] : (!empty( $params['cpayment_by'] )? '4' : $params['cpayment_by']) ;
              $postcaseData['entry_type'] = $entry_type;
              $CustomerInfo =  current($this->Crm_insurance->getCustomerInfo($params['customerId'],$partPaymentId));  
              $crm_customer_id =  $CustomerInfo['crm_customer_id'];
              $dataToInserted = array(
                'payment_by' =>  ( !empty($postcaseData['payment_by']) ? $postcaseData['payment_by'] : $postcaseData['cpayment_by'] ),
                'receipt_no' =>  ( !empty($postcaseData['receipt_no']) ? $postcaseData['receipt_no'] : '' ),
                'receipt_date' =>  ( !empty($postcaseData['receipt_date']) ? $postcaseData['receipt_date'] : '' ),
                'payment_date' =>  ( !empty($postcaseData['payment_date']) ? $postcaseData['payment_date']  : $postcaseData['in_payment_date'] ),
                'payment_mode' =>  ( !empty($postcaseData['payment_mode']) ? $postcaseData['payment_mode'] : $postcaseData['in_payment_mode'] ),
                'favouring_to' =>  ( !empty($postcaseData['favouring_to']) ?$postcaseData['favouring_to']:  $postcaseData['in_favouring_to']) ,
                'amount' =>  ( !empty($postcaseData['amount']) ? $postcaseData['amount'] : $postcaseData['in_amount'] ),
                'subvention_amt' =>  ( !empty($postcaseData['subvention_amt']) ? $postcaseData['subvention_amt'] : $postcaseData['in_subvention_amt'] ),
                'cheque_no' =>  ( !empty($postcaseData['cheque_no']) ? $postcaseData['cheque_no'] : ( !empty($postcaseData['in_cheque_no']) ? $postcaseData['in_cheque_no'] : '' )  ),
                'instrument_no' =>  ( !empty($postcaseData['instrument_no']) ? $postcaseData['instrument_no'] : ( !empty($postcaseData['in_instrument_no']) ? $postcaseData['in_instrument_no'] : '' )  ),
                'instrument_date' =>  ( !empty($postcaseData['instrument_date']) ? $postcaseData['instrument_date'] : ( !empty($postcaseData['in_instrument_date']) ? $postcaseData['in_instrument_date'] : '' )  ),
                'bank_name' =>  ( !empty($postcaseData['bank_name']) ? $postcaseData['bank_name'] : ( !empty($postcaseData['in_bank_name'])? $postcaseData['in_bank_name'] : '') ),
                'drawn_on' =>  ( !empty($postcaseData['drawn_on']) ? $postcaseData['drawn_on'] : ( !empty( $postcaseData['in_drawn_on'] )? $postcaseData['in_drawn_on'] : '' )  ),
                'reasonId' =>  ( !empty($postcaseData['reasonId']) ? $postcaseData['reasonId'] : null ),
                'sisreasonId' =>  ( !empty($postcaseData['sisreasonId']) ? $postcaseData['sisreasonId'] : null ),
                'entry_type'  => $entry_type,
                'pay_remark'  =>  ( !empty($postcaseData['pay_remark']) ? $postcaseData['pay_remark'] : (!empty($postcaseData['pay_in_remark'])? $postcaseData['pay_in_remark']: '' ) ),
                'customer_id'  =>  $params['customerId'] ,
                );
            if(!empty($CustomerInfo['PartPaymentDetails'])){
               $inhouse_paid_amt = $this->Crm_insurance_part_payment->getInhousePaidAmount($params['customerId'],$partPaymentId);
               $clearance_paid_amt = $this->Crm_insurance_part_payment->getPaidAmountbyType($params['customerId'],$partPaymentId,'4');
               if($entry_type!=4){
                    $subvention = $CustomerInfo['totalpremium'] -  current($CustomerInfo['PartPaymentDetails'])['total_amount_paid']; 
               }
               if($entry_type==4 && !empty(current($inhouse_paid_amt)['inhouse_paid_amt']) ){
                    $subamt  = $CustomerInfo['customerPartPayments'][2];
                    $Clearance  = $CustomerInfo['customerPartPayments'][4];
                    $sum  = 0;
                    $sum1 = 0;
                    foreach($subamt as $k =>$v){
                      if($v['payment_by']=='2'){
                         $sum = (int)$sum + (int)$v['amount'];
                      }
                    }
                    foreach($Clearance as $ck =>$cv){
                        if($cv['payment_by']=='4'){
                         $sum1 = (int)$sum1 + (int)$cv['amount'];
                      }
                    }
                    $subvention = $sum - $sum1;
                }
                
                if($error){
                 $result= array('status'=>'False','message'=>$message,'Action'=>  base_url().'inspaymentDetail/' . base64_encode('customerId_' . $customerId)); 
                 echo json_encode($result);exit; 
                }               
            }
                  
            $customerId = $this->Crm_insurance_part_payment->addInsurancePartPayment($dataToInserted,$partPaymentId,$params['customerId']);
            $CustomerInfo =  current($this->Crm_insurance->getCustomerInfo($params['customerId'],$partPaymentId,1));
           
                $subamt = $CustomerInfo['customerPartPayments'][2];
                $totalpremium = $CustomerInfo['totalpremium'];
                $total_amount_paid = current($CustomerInfo['PartPaymentDetails'])['total_amount_paid'];
                $pending_amount = $totalpremium - $total_amount_paid;
                $Clearance = $CustomerInfo['customerPartPayments'][4];
                $sum = $sum1 = $subvention= 0;
                $sum1 = 0;
                if (!empty($Clearance)) {
                    foreach ($subamt as $k => $v) {
                        if ($v['payment_by'] == '2') {
                            $sum = (int) $sum + (int) $v['amount'];
                        }
                    }
                    foreach ($Clearance as $ck => $cv) {
                        if ($cv['entry_type'] == '4') {
                            $sum1 = (int) $sum1 + (int) $cv['amount'];
                        }
                    }
                     $subvention = $sum - $sum1;
                }
               
            $caseArr['last_updated_date']=date('Y-m-d H:i:s');
            $lastStatusArr=$this->Crm_insurance->getlastStatusId($params['customerId']);
            if($lastStatusArr[0]['lastStatus'] != 9){
                if($pending_amount == 0 && !empty($subamt)){
                  $caseArr['last_updated_status']='6';
                }
                if($pending_amount == 0 && (empty($subamt) || (!empty($Clearance) && $subvention == 0))){
                    $caseArr['last_updated_status']='5';
                }
            }else{
                $caseArr['last_updated_status']=$lastStatusArr[0]['lastStatus'];
            }
            $this->Crm_insurance->updateInsuranceCase($caseArr,$params['customerId']);
            $caseDetails=current($this->Crm_insurance->getCaseDetailsByCustomerId($params['customerId']));
            $this->addInsHistoryUpdateLog($caseDetails['id'],$params,'paymentDetail','1','1');
            $status_list = $this->Crm_insurance->getUpdateStatusList();
           
            $histArr=array();
            $histArr['company_id']='';
            $histArr['customer_id']=$params['customerId'];
            $histArr['created_date']=date('Y-m-d H:i:s');
            $histArr['history_type']='insurance';
            $histArr['source']=$status_list[$caseArr['last_updated_status']];
            $histArr['activity_text']=$status_list[$caseArr['last_updated_status']];
            if($lastStatusArr[0]['lastStatus'] != 9){
                if( $caseArr['last_updated_status'] == 5 || $caseArr['last_updated_status'] == 6){
                     $this->saveInsHistory($histArr);
                }
            }
            $caseArr=array();
            $caseArr['policy_status']='1';
            $caseArr['policy_issued_date']=date('Y-m-d H:i:s');
            $caseArr['last_updated_date']=date('Y-m-d H:i:s');
             $left_menu_status = INSURANCE_LEFT_SIDE_MENU['PAYMENT_DETAILS'];            
            if($caseDetails['left_menu_status'] < $left_menu_status){
               $caseArr['left_menu_status'] = $left_menu_status;
            } 
            $this->Crm_insurance->updateInsuranceCaseById($caseArr,$caseDetails['id']);
            $params['customer_id'] = !empty($customerId) ? $customerId : '';
            $InsCategory=current($this->Crm_insurance->getCaseDetailsByCustomerId($params['customer_id']));
            $ins_category=$InsCategory['ins_category'];
            $is_payment_completed = $CustomerInfo['is_payment_completed'];
            if(!$is_payment_completed){
             $result= array('status'=>'True','message'=>'Payment Details Added Successfully','Action'=>  base_url().'inspaymentDetail/' . base64_encode('customerId_' . $customerId));   
            }else
            $result= array('status'=>'True','message'=>'Payment Details Added Successfully','Action'=>  base_url().'inspaymentDetail/' . base64_encode('customerId_' . $customerId));   
        } 
           echo json_encode($result);exit; 
        }
    }
    
    public function insFileLoginValidation($params){
        
    }


    public function inspersonalDetail($id='')
    {
        $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $customerId  = !empty($editId)?end($editId):'';
        $userInfo=$this->session->userdata['userinfo'];
        $postData = $this->input->post();
        $data=[];
        $customerLeadId = current($this->Crm_insurance->getcustomerLeadIdById($customerId));
        $CustomerDetails=current($this->Crm_insurance->getCustomerDetailsById($customerLeadId));
        $case_details = current($this->Crm_insurance->getCaseDetailsByCustomerId($customerId));
       // echo "<pre>";print_r($case_details);die;
        //$loanCustomer = [];
        if(!empty($CustomerDetails)){
            $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
            $customerDetails['sno']=$customerName['sno'];
            $customerDetails['mi_funding']=$customerName['mi_funding'];
            $customerDetails['customer_email']=$customerName['customer_email'];
            $customerDetails['customer_address']=$customerName['customer_address'];
            $customerDetails['customer_pincode']=$customerName['customer_pincode'];
            $customerDetails['customer_city_id']=$customerName['customer_city_id'];
            $customerDetails['customer_aadhaar']=$customerName['customer_aadhar_no'];
            $customerDetails['customer_pan_no']=$customerName['customer_pan_no'];
            $customerDetails['customer_name']=$customerName['customer_name'];
            $customerDetails['mobile']=$customerName['mobile'];
            $customerDetails['makeName']=$customerName['makeName'];
            $customerDetails['modelName']=$customerName['modelName'];
            $customerDetails['versionName']=$customerName['versionName'];
            $customerDetails['regNo']=$customerName['regNo'];
            
            $customerDetails['customer_gender']=$customerName['customer_gender'];
            $customerDetails['customer_marital']=$customerName['customer_marital'];
            $customerDetails['customer_dob']= $customerName['customer_dob'];
            $customerDetails['customer_occupation']=$customerName['customer_occupation'];
            //$customerDetails['customer_annual_income']=$customerName['customer_annual_income'];
            $customerDetails['customer_gst']=$customerName['customer_gst_no'];
            $customerDetails['customer_nominee_name']=$customerName['customer_nominee_name'];
            $customerDetails['customer_nominee_age']=$customerName['customer_nominee_age'];
            $customerDetails['customer_nominee_address']=$customerName['customer_nominee_address'];
            $customerDetails['customer_nominee_pincode']=$customerName['customer_nominee_pincode'];
            $customerDetails['customer_nominee_city']=$customerName['customer_nominee_city'];
            $customerDetails['customer_nominee_relation']=$customerName['customer_nominee_relation'];
            $customerDetails['customer_nominee_ref_name']=$customerName['customer_nominee_ref_name'];
            $customerDetails['customer_nominee_ref_phone']=$customerName['customer_nominee_ref_phone'];
            $customerDetails['iscustomerAddress']=$customerName['iscustomerAddress'];
            $customerDetails['buyer_type']=$customerName['buyer_type'];
            $customerDetails['customer_company_name']=$customerName['customer_company_name'];
            $customerDetails['mobile']=$customerName['mobile'];
            $customerDetails['ins_category']=$customerName['ins_category'];
            $customerDetails['source']=$customerName['source'];
            //$customerDetails['follow_status']=$customerName['follow_status'];
            //$customerDetails['follow_up_date']=$customerName['follow_up_date'];
            $customerDetails['comment']=$customerName['comment'];
            $customerDetails['assign_to']=$customerName['assign_to'];
            $customerDetails['iscustomerAddress']=$customerName['iscustomerAddress'];
            $customerDetails['quote_add_date']=$customerName['quote_add_date'];
            $customerDetails['quote_shared_status']=$customerName['quote_shared_status'];
            $customerDetails['inspection_status']=$customerName['inspection_status'];
            $customerDetails['make']=$customerName['make'];
            $customerDetails['previous_insurance_company']=$customerName['previous_insurance_company'];
            $customerDetails['current_insurance_company']=$customerName['current_insurance_company'];
            $customerDetails['od_amt']=$customerName['od_amt'];
            $customerDetails['upload_ins_doc_flag']=$customerName['upload_ins_doc_flag'];
            $customerDetails['payment_date']=$customerName['payment_date'];
            $customerDetails['short_name']=$customerName['short_name'];
            $customerDetails['previous_due_date']=$customerName['previous_due_date'];
            $customerDetails['previous_ncb_discount']=$customerName['previous_ncb_discount'];
            $customerDetails['make']=$customerName['make'];
            $customerDetails['inspection_status']=$customerName['inspection_status'];
            $customerDetails['ins_approval_status']=$customerName['ins_approval_status'];
            $customerDetails['policy_status']=$customerName['policy_status'];
            $customerDetails['payment_by']=$customerName['payment_by'];
            $customerDetails['isexpired']=$customerName['isexpired'];
            $customerDetails['curr_short_name']=$customerName['curr_short_name'];
            $customerDetails['current_policy_type']=$customerName['current_policy_type'];
            $customerDetails['customer_id']=$customerId;
            $partpayments = $this->Crm_insurance_part_payment->getCustomerPartPayment($customerId);
            $PaymentDetails = $this->Crm_insurance_part_payment->getCustomerPaymentDetails($customerId);
            $customerDetails['customerPartPayments'] =  $partpayments; 
            $customerDetails['PartPaymentDetails']   =  $PaymentDetails;
             $customerDetails['left_menu_status']     = $case_details['left_menu_status'];
            // echo "<PRE>";
            // print_r($customerDetails); die;
        $data['CustomerInfo'] = !empty($customerDetails)?$customerDetails:'';
        }else{
            $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
            $data['CustomerInfo'] = !empty($customerName)?$customerName:'';
        }
        $data['citylist'] = $this->City->getAllCityList();
        $data['occupation'] = $this->Crm_insurance_company->getOccupation();
        $data['annualIncome'] = $this->Crm_insurance_company->getAnnualincome();
        $data['permission']     =  $this->Crm_insurance->getUserRole($userInfo['role_id'],'inspersonalDetail');
        $data['customerId']     = !empty($customerId)?$customerId:'';
        $data['pageTitle'] = 'Add New Insurance';
        $data['pageType'] = 'insurance';
        $this->loadViews("insurance/add_insurance_customer_detail",$data);
    }
    
   public function insvehicalDetail($id=''){
        $this->load->helper('date_helper');
        $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $customerId  = !empty($editId)?end($editId):'';
        $userInfo=$this->session->userdata['userinfo'];
        $data=[];
        $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
        $data['CustomerInfo'] = !empty($customerName)?$customerName:'';
        $mkYear=!empty($data['CustomerInfo']['make_year']) ? $data['CustomerInfo']['make_year']:'';
        $data['make'] = $this->Make_model->getMake();
        $data['model'] =  $this->Make_model->getModelByMakeId($data['CustomerInfo']['make']);
        $data['makeList']  = (array) $this->getMakeModelNameComm();
        
        $fields     = " id ";
        $where      = " WHERE make_model.parent_model_id='".$model."'";
        //$data['version']=$this->UserDashboard->getCarVersionListNew($fields,$where,$mkYear,$data['CustomerInfo']['model']);
        $data['version']=  $this->Make_model->getVersionById($data['CustomerInfo']['make'],$data['CustomerInfo']['model']);
        $data['monthlist']= getMonthArr();
        $data['citylist'] = $this->City->getAllCityList();
        $data['permission']     =  $this->Crm_insurance->getUserRole($userInfo['role_id'],'insvehicalDetail'); 
        $data['customerId']     = !empty($customerId)?$customerId:'';
        $data['pageTitle'] = 'Add New Insurance';
        $data['pageType'] = 'insurance';
        $this->loadViews("insurance/add_insurance_vehicle_detail",$data);   
   }
   
   public function insCustomerStatus($id=''){
       $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $customerId  = !empty($editId)?end($editId):'';
        $data=[];
        $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
        $data['CustomerInfo'] = !empty($customerName)?$customerName:'';
        $data['customerId']     = !empty($customerId)?$customerId:'';
        $data['pageTitle'] = 'Add New Insurance';
        $data['pageType'] = 'insurance';
        $this->loadViews("insurance/add_insurance_status",$data);
   }
   
   public function insPremiumDetails($id=''){
       $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $customerId  = !empty($editId)?end($editId):'';
        $userInfo=$this->session->userdata['userinfo'];
        $data=[];
        $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
        $idvAmt=!empty($customerName['idv']) ? $customerName['idv']:'';
        $odAmt=!empty($customerName['od_amt']) ? $customerName['od_amt']:'';
        $accAmt=!empty($customerName['accessories']) ? $customerName['accessories']:'';
        $extraAmt=!empty($customerName['extra_charge']) ? $customerName['extra_charge']:'';
        $preAmt=!empty($customerName['premium']) ? $customerName['premium']:'';
        $specdiscount=!empty($customerName['special_discount']) ? $customerName['special_discount']:'';
        $gstAmt=!empty($customerName['gst']) ? $customerName['gst']:'';
        $customerName['idv']=indian_currency_form($idvAmt);
        $customerName['od_amt']=indian_currency_form($odAmt);
        $customerName['accessories']=indian_currency_form($accAmt);
        $customerName['extra_charge']=indian_currency_form($extraAmt);
        $customerName['premium']=indian_currency_form($preAmt);
        $customerName['special_discount']=indian_currency_form($specdiscount);
        $customerName['gst']=indian_currency_form($gstAmt);
        $data['permission']     =  $this->Crm_insurance->getUserRole($userInfo['role_id'],'insPremiumDetails');
        $data['CustomerInfo'] = !empty($customerName)?$customerName:'';
        $data['customerId']     = !empty($customerId)?$customerId:'';
        $data['pageTitle'] = 'Add New Insurance';
        $data['pageType'] = 'insurance';
        $this->loadViews("insurance/add_insurance_premium_details",$data);
   } 
   
   public function insPreviousDetails($id=''){
       $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $customerId  = !empty($editId)?end($editId):'';
        $userInfo=$this->session->userdata['userinfo'];
        $data=[];
        $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
        $data['qfiterList'] = current($this->Crm_insurance->getFilterQuotesData($customerId));
        $data['insurerList'] = $this->Crm_previous_insurer->getInsurerList();
        $data['permission']     =  $this->Crm_insurance->getUserRole($userInfo['role_id'],'insPreviousDetails');
        $data['CustomerInfo'] = !empty($customerName)?$customerName:'';
        $data['customerId']     = !empty($customerId)?$customerId:'';
        $data['ins_company']=['1'=>'ICICI Lombard','2'=>'kotak Mahindra'];
        $data['policy_scheme']=['1'=>'Private Car'];
        $data['pageTitle'] = 'Add New Insurance';
        $data['pageType'] = 'insurance';
        $this->loadViews("insurance/add_insurance_previous_policy_details",$data);
   }
   
   public function insPolicyDetails($id=''){
       $this->load->helper('range_helper');
       $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $customerId  = !empty($editId)?end($editId):'';
        $userInfo=$this->session->userdata['userinfo'];
        $data=[];
        $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
        $data['quoteData'] = current($this->Crm_insurance->getAcceptedQuote($customerId));
        $data['ncbData'] = current($this->Crm_insurance->getFilterQuotesData($customerId));
        $data['insurerList'] = $this->Crm_previous_insurer->getInsurerList();
        $data['banklist']        =  $this->Crm_banks->getcustomerBankList();
        $data['permission']     =  $this->Crm_insurance->getUserRole($userInfo['role_id'],'insPolicyDetails');
        $data['insdur']=['1'];
        $data['CustomerInfo'] = !empty($customerName)?$customerName:'';
        $data['customerId']     = !empty($customerId)?$customerId:'';
        //$this->Crm_insurance->insuranceTabStatus($customerId);
        $data['policy_scheme']=['1'=>'Private Car'];
        $data['pageTitle'] = 'Add New Insurance';
        $data['pageType'] = 'insurance';
        /*echo"<pre>";
        print_r($data);
        die();*/
        $this->loadViews("insurance/add_insurance_policy_details",$data);
   }
   
   public function insDocumentDetails($id=''){
        $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $customerId  = !empty($editId)?end($editId):'';
        $userInfo=$this->session->userdata['userinfo'];
        $data=[];
        $imgListArr=[];
        $uploadDocList=[];
        $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
        $data['CustomerInfo'] = !empty($customerName)?$customerName:'';
        $data['customerId']     = !empty($customerId)?$customerId:'';
        //echo $customerName['ins_category']; exit;
        $docList = $this->Crm_upload_docs_list->getDocList('','3','','',$customerName['ins_category']);
     //   echo "<pre>";print_r($docList);die;
        foreach($docList as $key => $val)
        {
            $uploadDocList[$val['parent_id']]['name']= $val['parent_name'];
            $uploadDocList[$val['parent_id']]['is_require']= $val['is_require'];
            //echo $data['CustomerInfo']['loan_for'].'-'.$val['id'];    

            $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'],'3','','',$customerName['ins_category']); 
            foreach ($sublist as $skey => $sval)
            {
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['name'] = $sval['name'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['sub_category_id'] = $sval['sub_category_id'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = $sval['is_required'];
            }   
        }
        $data['uploadDocList'] = $uploadDocList;
        $data['permission']     =  $this->Crm_insurance->getUserRole($userInfo['role_id'],'insDocumentDetails');
        $imgListUpdated = $this->Crm_upload_docs_list->getInsImageList($customerId,'','','','3');
          if(!empty($imgListUpdated))
        {
            $i=0;
            $tagIdN = [];
            foreach($imgListUpdated as $imgK => $imgV)
            {
                $tagIdN = $imgV['tag_id'];
                $name = $imgV['name'];
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
                $imgListArr[$i]['name']         =   $name;
                $imgListArr[$i]['parent_id']    =   $imgV['parent_id'];
                $imgListArr[$i]['err']          =   $imgV['err'];
                $i++;
            }
        }
        $data['imageList'] =  $imgListArr;
        $data['pageTitle'] = 'Add New Insurance';
        $data['pageType'] = 'insurance';
        $this->loadViews("insurance/add_insurance_document_details",$data);
   }
   
   public function logindoc()
    {
        //$editId      = !empty($customer_id)? explode('_',base64_decode($customer_id)):'';
        //$customerId  = !empty($editId)?end($editId):'';
        $customerId  = $this->input->post('customer_id');
        $userInfo=$this->session->userdata['userinfo'];
        $data = [];
        $imgListArr = [];
        $bnkId = '';
        $uploadDocList = [];
        $data['pageTitle']      = 'Insurance Docs';
        $data['pageType']       = 'insurance';
        if(!empty($customerId)){
        $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
        if($customerName['ins_category'] == 4 && $customerName['isexpired'] == 1){
        $customerName['ins_category'] = 5;    
        }
        $data['CustomerInfo'] = !empty($customerName)?$customerName:'';
        $data['customerId']     = !empty($customerId)?$customerId:'';
        }
         $docList = $this->Crm_upload_docs_list->getDocList('','3','','',$customerName['ins_category']);
         foreach($docList as $key => $val)
        {
           //if( $val['parent_name'] == "Previous Policy" && $customerName['isexpired'] == 1 )
           // continue;
           if($val['listreq'] == '0' && $val['liststatus'] == '0')
            continue;  
            $uploadDocList[$val['parent_id']]['name']= $val['parent_name'];
            $uploadDocList[$val['parent_id']]['is_require']= $val['listreq'];
            $uploadDocList[$val['parent_id']]['status']= $val['liststatus'];
            //echo $data['CustomerInfo']['loan_for'].'-'.$val['id'];    

            $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'],'3','','',$customerName['ins_category']); 
            foreach ($sublist as $skey => $sval)
            {
                if($sval['liststatus']=='0')
                {
                    continue;
                }
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['name'] = $sval['name'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['sub_category_id'] = $sval['sub_category_id'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = $sval['listreq'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['liststatus'] = $sval['liststatus'];
            }   
        }
        //echo "<pre>";print_r($uploadDocList);die;
        $data['uploadDocList'] = $uploadDocList;
        $data['pendencyDoc'] = $this->Crm_upload_docs_list->getPendencyDetail($data['CustomerInfo']['id'],3);
        $data['permission']     =  $this->Crm_insurance->getUserRole($userInfo['role_id'],'logindoc');
        $imgListUpdated = $this->Crm_upload_docs_list->getInsImageList($customerId,'','','','3');
          if(!empty($imgListUpdated))
        {
            $i=0;
            $tagIdN = [];
            foreach($imgListUpdated as $imgK => $imgV)
            {
                $a['allids'][]       =   $imgV['sub_id'];
                $tagIdN = $imgV['tag_id'];
                $name = $imgV['name'];
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
                $imgListArr[$i]['name']         =   $name;
                $imgListArr[$i]['parent_id']    =   $imgV['parent_id'];
                $imgListArr[$i]['err']          =   $imgV['err'];
                $i++;
            }
        }
        if(!empty($a['allids'])){

            $sublistsss = $this->Crm_upload_docs_list->getDocList('',3,'','','','',$a['allids']); 
            foreach($sublistsss as $ssub => $kkk)
            {
                $b['allParentIds'][] = $kkk['parent_id'];
            }
        }
        $data['allParentIds'] =  !empty($b)?$b:'';
        $data['imageList'] =  $imgListArr;
        echo $datas=$this->load->view('insurance/loginDoc',$data,true); exit;
        //$this->loadViews("finance/loginDocs",$data);
    }
   
   public function inspaymentDetail($id=''){
        $this->load->helper('range_helper');
        $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $customerId  = !empty($editId)?end($editId):'';
        $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
        //echo "<pre>";print_r($customerName);die;
        $customerName['id'] = $customerName['cust_id'];
        // die($customerId);
        $userInfo=$this->session->userdata['userinfo'];
        $dealer_id=!empty($userInfo['dealer_id']) ? $userInfo['dealer_id'] : '';
        // die($dealer_id);
        $data=[];
        $customerPartPaymentsAll = $this->Crm_insurance_part_payment->getCustomerPartPayment($customerName['id']);
        $PaymentDetails = $this->Crm_insurance_part_payment->getCustomerPaymentDetails($customerName['id']);

        $ci = 0;
        $customerPartPayments =$customerPartPaymentsAll;
        $data['dealer_info']=$this->Crm_user->getAdminDealerDetails($dealer_id);
        $customerName['customerPartPayments'] = $customerPartPayments; 
        $customerName['PartPaymentDetails']   =  $PaymentDetails; 
        $payAmt=!empty($customerName['amount']) ? $customerName['amount']:'';
        $customerName['amount'] = indian_currency_form($payAmt);
        $data['payreason']      = $this->Crm_insurance->getPayReason('1');
        $data['paysisreason']   = $this->Crm_insurance->getPayReason('2');
        $data['permission']     = $this->Crm_insurance->getUserRole($userInfo['role_id'],'inspaymentDetail');
        $bankName               = $this->getcustomerBankList();
        $data['banklist']       = $bankName;
        $data['entrytype']      = !empty($params['entrytype'])? $params['entrytype'] : 1 ;
        $data['is_inhouse']     = ( !empty($customerName['customerPartPayments']['2']) ) ? 'inhse' : '';
        $data['underclearance']      = ( !empty($customerName['customerPartPayments']['4']) ) ? true : false;
        $data['partpaymentid']  = !empty($params['partpaymentid'])?$params['partpaymentid']:null;
        $quoteData = current($this->Crm_insurance->getAcceptedQuote($customerId));
        $data['totpremium']=(!empty($quoteData['totpremium'])) ? indian_currency_form($quoteData['totpremium']):0;
        $data['CustomerInfo'] = !empty($customerName)?$customerName:'';
        $data['customerId']     = !empty($customerId)?$customerId:'';
        $data['siscomp'] = $this->Crm_insurance->getsiscompFlag($dealer_id);
        $data['pageTitle'] = 'Add New Insurance';
        $data['pageType'] = 'insurance';
        $totalAmountPaid = $this->Crm_insurance_part_payment->getPaidAmountbyType($customerId,$partPaymentId,'1,3,4');
        $data['favouring'] = !empty($customerName['current_accepted_company'])? $customerName['current_accepted_company'] : '' ;
        
        $data['totalAmountPaid'] =  $totalAmountPaid;
       // echo "<pre>";print_R($data);die;
       $this->loadViews("insurance/add_insurance_payment_details_new",$data);
   }
   
   public function insFilelogin($id=''){
        $this->load->helper('range_helper');        
        $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $customerId  = !empty($editId)?end($editId):'';
        $userInfo=$this->session->userdata['userinfo'];
        $data=[];
        $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
        $caseData=current($this->Crm_insurance->getCaseDetailsByCustomerId($customerId));
        if($caseData['zone'] == 0 && $caseData['cc'] == ""){
        return redirect('insvehicalDetail/'.$id);    
        }
        $data['insurerList'] = $this->Crm_previous_insurer->getInsurerList();
        $data['quotes'] = $this->Crm_insurance->getQuotesList($caseData['id']);
        $data['permission']     =  $this->Crm_insurance->getUserRole($userInfo['role_id'],'insFilelogin');
        $data['coverlist']     =  $this->Crm_insurance->getadditionalCover();
        $data['mcoverlist']     =  $this->Crm_insurance->getadditionalCover(array('11','12'));
        $data['filterdata']     =  current($this->Crm_insurance->getFilterQuotesData($customerId,1));
        $data['filterdata']['policy_type']     =  !empty($customerName['current_policy_type'])?$customerName['current_policy_type']:'';
        $data['qsourceList']    =  $this->Crm_insurance->getQSource();
        $data['citylist'] = $this->City->getAllCityList();
        $data['CustomerInfo'] = !empty($customerName)?$customerName:'';
        $data['customerId']     = !empty($customerId)?$customerId:'';
        $data['pageTitle'] = 'Add New Insurance';
        $data['pageType'] = 'insurance';
        $this->loadViews("insurance/InsFileLogin",$data);
   }
   public function getinsFilelogin($id=''){
       $userInfo=$this->session->userdata['userinfo'];
       $editId      = !empty($id)? base64_decode($id):'';
       $caseId  = !empty($editId)?$editId:'';
       $result=[];
       if($caseId!=''){
          $customerId=$this->Crm_insurance->getAddUpdateCaseDetails($caseId);
          $imgData=$this->Crm_upload_docs_list->getInsImageList('','','','',3,$caseId);
          if(!empty($imgData)){
              foreach($imgData as $imgk=>$imgv){
              $imgArr=[];    
              $caseData=current($this->Crm_insurance->getCaseDetailsByCustomerId($customerId));
              $newCaseId=!empty($caseData['id']) ? $caseData['id'] :'';
              $imgArr['doc_name']=!empty($imgv['doc_name']) ? $imgv['doc_name']:'';
              $imgArr['doc_url']=(($imgV['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$imgV['doc_url'];
              $imgArr['doc_type']=!empty($imgv['doc_type']) ? $imgv['doc_type'] : '';
              $imgArr['customer_id']=!empty($customerId) ? $customerId : '';
              $imgArr['case_id']=$newCaseId;
              $imgArr['status']='1';
              $imgArr['created_on']=$this->dateTime;
              $this->Crm_upload_docs_list->insertLoginDocs($imgArr);
              }
          }
          redirect("insFileLogin/".base64_encode('customerId_' . $customerId));
        }else{
            $result= array('status'=>'False','message'=>'Case Id not valid'); 
            echo json_encode($result);
        }
        
   }
   public function insInspection($id=''){
        $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $customerId  = !empty($editId)?end($editId):'';
        $userInfo=$this->session->userdata['userinfo'];
        $data=[];
        $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
        $caseData=current($this->Crm_insurance->getCaseDetailsByCustomerId($customerId));
        $data['insurerList'] = $this->Crm_previous_insurer->getInsurerList();
        $data['inspectList'] = $this->Crm_inspection_status->getInspectionStatus();
        $data['quotes'] = $this->Crm_insurance->getQuotesList($caseData['id'],'',1);
        $data['inspection'] = $this->Crm_insurance->getInspectionList($customerId);
        $data['permission']     =  $this->Crm_insurance->getUserRole($userInfo['role_id'],'insInspection');
        $data['CustomerInfo'] = !empty($customerName)?$customerName:'';
        $data['customerId']     = !empty($customerId)?$customerId:'';
        $data['pageTitle'] = 'Add New Insurance';
        $data['pageType'] = 'insurance';
        $this->loadViews("insurance/add_insurance_inspection",$data);
   }
   public function insDetailFormValidation($params) {
        //print_r($params);die;
        
        $this->form_validation->set_error_delimiters('', '');
        if($params['buyer_type']=='1'){
            if(empty($params['customer_name'])){
            $this->form_validation->set_rules('customer_name', 'Buyer Name', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
                return array('status'=>'False','message'=>validation_errors());
            }
            }
        }
        if($params['buyer_type']=='2'){
            if(empty($params['customer_company_name'])){
            $this->form_validation->set_rules('customer_company_name', 'Company Name', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
                return array('status'=>'False','message'=>validation_errors());
            }
            }
        }
        if(empty(trim($params['customer_mobile']))){
        $this->form_validation->set_rules('customer_mobile', 'Mobile Number', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['ins_category'])){
        $this->form_validation->set_rules('ins_category', 'Insurance Category', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['source'])){
        $this->form_validation->set_rules('source', 'Source', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(!empty($params['source']) && $params['source']=='dealer'){
           if(empty($params['dealerName'])){ 
            $this->form_validation->set_rules('dealerName', 'Dealer Name', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
           }
        }
        if(empty($params['customer_email'])){
        $this->form_validation->set_rules('customer_email', 'Customer Email', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(!empty($params['customer_email'])){
        $this->form_validation->set_rules('customer_email', 'Customer Email', 'trim|valid_email'); 
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }   
        }
        //$this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
    }
    public function inspersonalFormValidation($params) {
        //print_r($params);die;
        $this->form_validation->set_error_delimiters('', '');
        if(empty($params['customer_address'])){
        $this->form_validation->set_rules('customer_address', 'Customer Address', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['customer_city'])){
        $this->form_validation->set_rules('customer_city', 'Customer city', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['customer_pincode'])){
        $this->form_validation->set_rules('customer_pincode', 'Customer Pincode', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(!empty($params['customer_pincode'])){

            $this->form_validation->set_rules('customer_pincode', 'Customer Pincode','required|min_length[6]', 'required');
                 if ($this->form_validation->run() == FALSE && validation_errors()) {
                    return array('status'=>'False','message'=>validation_errors());
                }
            }
        if($params['btype']=='1'){
       /* if(empty($params['customer_dob'])){
        $this->form_validation->set_rules('customer_dob', 'Customer DOB', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['customer_occupation'])){
        $this->form_validation->set_rules('customer_occupation', 'Customer Occupation', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        /*if(!empty($params['customer_aadhar'])){
        $this->form_validation->set_rules('customer_aadhar', 'Customer Aadhar No','required|max_length[12]|min_length[12]', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/
        if($params['customer_dob']!=''){
        $birthDate = $params['customer_dob'];
        if(time() - intval($birthDate) < 18 * 31536000)  {
         $this->form_validation->set_rules('customer_dob', 'Customer DOB', 'required|valid_customer_dob');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
             
            return array('status'=>'False','message'=>'Please Enter Valid DOB');
        }
        }
        }
        }
        /*if(empty($params['customer_pan'])){
        $this->form_validation->set_rules('customer_pan', 'Customer Pan Number', 'required|max_length[10]|regex_match[/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/]');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/
        /*if(!empty($params['customer_pan'])){
        $this->form_validation->set_rules('customer_pan', 'Customer Pan Number', 'max_length[10]|regex_match[/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/]');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/
       /* if(empty($params['customer_aadhar'])){
        $this->form_validation->set_rules('customer_aadhar', 'Customer Aadhar Number','required|max_length[12]|min_length[12]', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/
        
        if($params['btype']=='2'){
        // if(empty($params['customer_gst'])){
        // $this->form_validation->set_rules('customer_gst', 'Customer GST Number','required', 'required');
        // }     

        /*if(!empty($params['customer_gst'])){
        $this->form_validation->set_rules('customer_gst', 'Customer GST No','required|max_length[15]', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/
        }
        if($params['btype']=='1'){
        if(empty($params['nominee_customer_name'])){
        $this->form_validation->set_rules('nominee_customer_name', 'Nominee Customer Name', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        } 
        else if(empty($params['nominee_customer_age'])){
        $this->form_validation->set_rules('nominee_customer_age', 'Nominee Customer Age', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }/*else if(empty($params['reference_customer_name'])){
        $this->form_validation->set_rules('reference_customer_name', 'Reference Customer Name', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['reference_customer_mobile'])){
        $this->form_validation->set_rules('reference_customer_mobile', 'Reference Customer Mobile', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/elseif(!isset($params['isaddress'])){
            if(empty($params['nominee_customer_address'])){
            $this->form_validation->set_rules('nominee_customer_address', 'Nominee Address', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(empty($params['nominee_customer_pincode'])){
            $this->form_validation->set_rules('nominee_customer_pincode', 'Nominee Pincode', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(empty($params['nominee_customer_city'])){
            $this->form_validation->set_rules('nominee_customer_city', 'Nominee City', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }
            
        }
        if(empty($params['nominee_customer_relation'])){
        $this->form_validation->set_rules('nominee_customer_relation', 'Nominee Customer Relation', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        }
        
        //$this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
    }
    
    public function insVehicalFormValidation($params) {
        //print_r($params);die;
        $this->form_validation->set_error_delimiters('', '');
        if(isset($params['regNo']) && empty($params['regNo'])){
        $this->form_validation->set_rules('regNo', 'Vehicle Reg No', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }elseif(empty($params['make'])){
        $this->form_validation->set_rules('make', 'Vehicle make', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['model'])){
        $this->form_validation->set_rules('model', 'Vehicle model', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['variant'])){
        $this->form_validation->set_rules('variant', 'Vehicle version', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }/*if(empty($params['engine_no'])){
        $this->form_validation->set_rules('engine_no', 'Vehicle Engine No', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/
        if(!empty($params['engine_no'])){
        $this->form_validation->set_rules('engine_no', 'Vehicle Engine No', 'required|min_length[6]|max_length[17]','required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        /*if(empty($params['chassis_no'])){
        $this->form_validation->set_rules('chassis_no', 'Vehicle Chassis No', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/else if(!empty($params['chassis_no'])){
        $this->form_validation->set_rules('chassis_no', 'Vehicle Chassis No', 'required|min_length[6]|max_length[17]','required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }if(empty($params['makemonth'])){
        $this->form_validation->set_rules('makemonth', 'Vehicle Make Month', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }if(empty($params['myear'])){
        $this->form_validation->set_rules('myear', 'Vehicle Make Year', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(isset($params['regmonth']) && empty($params['regmonth'])){
        $this->form_validation->set_rules('regmonth', 'Vehicle Reg Month', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(isset($params['regyear']) && empty($params['regyear'])){
        $this->form_validation->set_rules('regyear', 'Vehicle Reg year', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if(isset($params['regyear'])){
        if(intval($params['regyear']) < intval($params['myear'])){
         $this->form_validation->set_rules('regyear', 'Reg year', 'required|greater_than[Make year]');
          if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(intval($params['regyear']) ==intval($params['myear'])){
            if(intval($params['regmonth']) < intval($params['makemonth'])){
                $this->form_validation->set_rules('regmonth', 'Reg Month', 'required|greater_than[Make month]');
                 if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }
        }
        }
        //die;
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
    }
    public function insStatusFormValidation($params) {
        //print_r($params);die;
        $this->form_validation->set_error_delimiters('', '');
        if(empty($params['source'])){
        $this->form_validation->set_rules('source', 'Source', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        //$this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
    }
    
    public function insPremiumFormValidation($params) {
        //print_r($params);die;
        $this->form_validation->set_error_delimiters('', '');
        if(empty($params['idv'])){
        $this->form_validation->set_rules('idv', 'IDV', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }elseif(empty($params['od_amt'])){
        $this->form_validation->set_rules('od_amt', 'OD Amount', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['ncb'])){
        $this->form_validation->set_rules('ncb', 'NCB', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['premium'])){
        $this->form_validation->set_rules('premium', 'Premium', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['accessories'])){
        $this->form_validation->set_rules('accessories', 'Total IDV', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        //$this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
    }
    
    public function insPreviousPolicyValidation($params) {
        //print_r($params);die;
        $this->form_validation->set_error_delimiters('', '');
        if(empty($params['ins_company'])){
        $this->form_validation->set_rules('ins_company', 'Insurance Company', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['previous_issue_date'])){
        $this->form_validation->set_rules('previous_issue_date', 'Issue Date', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['previous_policy_no'])){
        $this->form_validation->set_rules('previous_policy_no', 'Policy No', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['previous_due_date'])){
        $this->form_validation->set_rules('previous_due_date', 'Due Date', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['previous_ncb_discount']) && (!empty($params['previous_claim_taken']) && ($params['previous_claim_taken']=='2'))){
        $this->form_validation->set_rules('previous_ncb_discount', 'NCB Discount', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['previous_claim_taken'])){
         $this->form_validation->set_rules('previous_claim_taken', 'Previous Claim Taken', 'required'); 
          if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }  
        }
        /*if($params['previous_issue_date'] > $params['previous_due_date']){
         $this->form_validation->set_rules('previous_issue_date', 'Previous Due Date', 'required|greater_than[Previous Issue Date]');
          if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/
        
        //$this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
    }
    
    public function insPolicyValidation($params) {
        //print_r($params);die;
        $this->form_validation->set_error_delimiters('', '');
        if(empty($params['ins_company'])){
        $this->form_validation->set_rules('ins_company', 'Insurance Company', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['issue_date'])){
        $this->form_validation->set_rules('issue_date', 'Issue Date', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(!isset($params['policy_type'])){
        $this->form_validation->set_rules('policy_type', 'Policy Type', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['due_date'])){
        $this->form_validation->set_rules('due_date', 'Due Date', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        /*else if(empty(trim($params['ncb_discount']))){
        $this->form_validation->set_rules('ncb_discount', 'NCB Discount', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/
        
        if(empty(trim($params['ins_duration']))){
        $this->form_validation->set_rules('ins_duration', 'Insurance Duration', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        /*if($params['policy_issued']=='1'){
          if(empty(trim($params['policy_no']))){  
            $this->form_validation->set_rules('policy_no', 'Policy No', 'required');
            if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
            }
          }
        }elseif($params['policy_issued']=='2'){
          if(empty(trim($params['covernote_no']))){  
            $this->form_validation->set_rules('covernote_no', 'Covernote No', 'required');
            if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
            }
          }
        }*/
        //$this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
    }
    
    public function insDocumentFormValidation($image) {
        //print_r($image);die;
        $imgArrName=array('0'=>'Rc Copy','1'=>'RC Copy 2','2'=>'form 29','3'=>'form 30 image1','4'=>'form 30 image2');
        $this->form_validation->set_error_delimiters('', '');
        if(isset($image['docimg']['name'])){
        $cpt=count($image['docimg']['name']);
        }
        for($i=0;$i<$cpt;$i++){
        if(empty($image['docimg']['name'][$i])){
          $this->form_validation->set_rules(docimg[$i], $image['docimg']['name'][$i], 'required'); 
           if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        } 
        }
        else if($image['docimg']['name'][$i]!='' && $image['docimg']['size'][$i] > 0)
    {
                $imagename=$image['docimg']['name'][$i];
        $ext=explode(".",$imagename);
                $extnImg1=strtolower(end($ext));
                //$extnImg1=strtolower(array_pop(explode(".",$rcCopy)));
        if (!in_array ($extnImg1, array('jpeg','jpg','png','pdf') ) ) {
                $this->form_validation->set_rules('docimg['.$i.']', 'Upload '.$imgArrName[$i].' in jpeg/png/pdf format', 'required');
                 if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }
        elseif($image['docimg']['size'][$i] > 8000000 || $image['docimg']['size'][$i] < 25000)
             {
             $this->form_validation->set_rules('docimg['.$i.']', 'Upload '.$imgArrName[$i].' more than 25kb or less than 8 mb in size', 'required');
              if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
             }                   
    }
        }
        //$this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
    }
    public function insPaymentValidation($params) {
        //print_r($params);die;
        $this->form_validation->set_error_delimiters('', '');
        
        /*if(!isset($params['payment_by'])){
            $this->form_validation->set_rules('payment_by', 'Payment By', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }
        if($params['payment_by']=='2'){
            if(empty($params['pay_reason'])){
            $this->form_validation->set_rules('pay_reason', 'Payment Reason', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
            }
            }
        }
        if($params['payment_by']=='1'){
        if($params['payment_mode']=='1'){
          if(empty($params['payment_date'])){
            $this->form_validation->set_rules('payment_date', 'Payment Date', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(isset($params['cheque_favour']) && empty($params['cheque_favour'])){
            $this->form_validation->set_rules('cheque_favour', 'Favouring', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(isset($params['policy_amt']) && empty($params['policy_amt'])){
            $this->form_validation->set_rules('policy_amt', 'Amount Drawn', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }*//*else if(isset($params['policy_amt'])){
            $this->form_validation->set_rules('policy_amt', 'Amount Drawn', 'numeric');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
            }
            }else if(isset($params['cheque_no']) && empty($params['cheque_no'])){
            $this->form_validation->set_rules('cheque_no', 'Cheque No', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            } 
        }
       if($params['payment_mode']=='2'){
            if(empty($params['payment_date'])){
            $this->form_validation->set_rules('payment_date', 'Payment Date', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }
            if(isset($params['policy_amt']) && empty($params['policy_amt'])){
            $this->form_validation->set_rules('policy_amt', 'Amount Drawn', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }/*else if(isset($params['policy_amt'])){
            $this->form_validation->set_rules('policy_amt', 'Amount Drawn', 'numeric');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }
            if(isset($params['transaction_no']) && empty($params['transaction_no'])){
            $this->form_validation->set_rules('transaction_no', 'Transaction No', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }
       } 
       if($params['payment_mode']=='3'){
           if(empty($params['payment_date'])){
            $this->form_validation->set_rules('payment_date', 'Payment Date', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }else if(isset($params['policy_amt']) && empty($params['policy_amt'])){
            $this->form_validation->set_rules('policy_amt', 'Amount Drawn', 'required');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }/*else if(isset($params['policy_amt'])){
            $this->form_validation->set_rules('policy_amt', 'Amount Drawn', 'numeric');
             if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
            }
       }
        }*/
        //$this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
        /*if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }*/
    }
    
    function addNewProcess(){
        $postdata=$this->input->post();
        //print_r($postdata);die;
        $postdata['step1']=isset($postdata['step1']) ? $postdata['step1'] : '';
        $postdata['caseid']=isset($postdata['caseid']) ? $postdata['caseid'] : '';
        if($postdata['step1']=='true'){
            $customerMobile=$this->input->post('customer_mobile');
            $resultData=$this->Crm_insurance->getcustomerLeadId($customerMobile);
            $postcustomerData = array(
                'customer_name' => $this->input->post('customer_name'),
                'customer_mobile' => $this->input->post('customer_mobile'),
                'customer_address' => $this->input->post('customer_address'),
                'customer_pincode' => $this->input->post('customer_pincode'),
                'customer_city' => $this->input->post('customer_city'),
                'customer_email' => $this->input->post('customer_email'),
                'customer_aadhar' => $this->input->post('customer_aadhar'),
                'customer_pan' => $this->input->post('customer_pan'),
                'nominee_customer_name' => $this->input->post('nominee_customer_name'),
                'nominee_customer_relation' => $this->input->post('nominee_customer_relation'),
                'reference_customer_name' => $this->input->post('reference_customer_name'),
                'reference_customer_mobile' => $this->input->post('reference_customer_mobile')
            );
            if($postdata['caseid']!=''){
             $insertCustomer=$this->Crm_insurance->addInsuranceCustomer($postcustomerData,$postdata['caseid']);
             $caseid=$postdata['caseid'];
            }
            
        }else if($postdata['step2']=='true'){
        $this->load->helper('form');
        $this->load->library('form_validation');
        //$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('ins_category','Insurance category' ,'required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('case_status','Case Status' ,'required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
                $this->addNew();
            }
        else if ($this->form_validation->run() === true)
        {
            //prepare insurance case page data
            $postcaseData = array(
                'ins_category' => $this->input->post('ins_category'),
                'created_by' => DEALER_ID,
                'created_date' => date('Y-m-d H:i:s')
            );
            if($postdata['caseid']!=''){
             $this->Crm_insurance->addInsuranceCase($postcaseData,$postdata['caseid']);
             $caseid=$postdata['caseid'];
            }else{
            $caseid=$this->Crm_insurance->addInsuranceCase($postcaseData);
            }
            if(!empty($caseid)){
            $postcustomerData = array(
                'buyer_type' => $this->input->post('buyer_type'),
                'case_id' => $caseid,
                'crm_customer_id' => DEALER_ID,
                'customer_status' => $this->input->post('case_status'),
                'created_by' => DEALER_ID,
                'created_date' => date('Y-m-d H:i:s')
            );
            if($postdata['caseid']!=''){
              $insertCustomer=$this->Crm_insurance->addInsuranceCustomer($postcustomerData,$postdata['caseid']);  
            }else{
             $insertCustomer=$this->Crm_insurance->addInsuranceCustomer($postcustomerData);
            }
            if($insertCustomer){
                $dataArrCase=$this->Crm_insurance->getCaseDetails($caseid);
                echo json_encode($dataArrCase);
                    
            }else{
                //echo 'error';
            }
            
        }
        }
        }else{
            
        }
        
    }
    
    public function getModel() {
        $make = $this->input->post('make');
        $getMakeNameById=[];
        $getMakeNameById = $this->Make_model->getMakeNameById($make);
        $makeName=isset($getMakeNameById[0]['make']) ? $getMakeNameById[0]['make'] : '';
        $result  = $this->Make_model->getCarModelList($makeName);
        $option = "<option value='' >Select Model</option>";
        foreach ($result as $ModelKey => $ModelValue) {
            $option .="<option value='" . $ModelValue['id'] . "' >" . $ModelValue['model'] . "</option>";
        }
        echo $option;
    }
    
    public function getVariant(){
        $model      = $this->input->post('model');
        $make       = $this->input->post('make');
        $fields     = "db_version_id,db_version,uc_fuel_type,Displacement";
        $sqlJoin    = " ";
        $where      = $sqlJoin." WHERE model_version.mk_id = '".$make."' AND model_version.model_id = '".$model."' ";
        $orderBy    = "uc_fuel_type";
        $versionListArr =array();
        $versionListArr  =  $this->UserDashboard->getCarVersionList($make,'used',$fields,$orderBy,$where);
        $option  = "<option value='' >Select Version</option>";
        foreach ($versionListArr as $ModelKey => $ModelValue) {
            $option .="<option value='" . $ModelValue['db_version_id'] . "' >" . $ModelValue['db_version'] . "</option>";
        }
        echo $option;
        
    }
    public function uploadInsDocs()
    {
        //echo UPLOAD_INS_IMAGE_PATH.'insurance_document/'; exit;
        //echo UPLOAD_INS_IMAGE_PATH
        $arr = $this->uri->segment(3);
        $ar  = explode('-', $arr);
        $data = [];       
        //print_r($_FILES);die;
        $file_name_key              = key($_FILES);
        $config['upload_path']      = UPLOAD_INS_IMAGE_PATH;
        $config['allowed_types']    = ['gif', 'png', 'jpg','jpeg','pdf','tif'];
        $config['max_size']         = '8000';
        $config['max_width']        = '7000';
        $config['max_height']       = '7000';
        $config['min_width']        = '300';
        $config['min_height']       = '200';
        $config['encrypt_name']     = True;
       //echo UPLOAD_IMAGE_URL_LOCAL.'insurance_document/'.$datas['file_name']; exit;
        $this->load->library('upload', $config);
        if($this->upload->do_upload($file_name_key))
        {
            $datas = $this->upload->data();
            
            $data['doc_name'] = $datas['file_name'];
            $data['doc_url'] = 'insurance_document/'.$datas['file_name'];
            $data['doc_type'] = '3';
            $data['customer_id'] = $ar['1'];
            $data['case_id'] = $ar['0'];
            $data['created_on'] = date('Y-m-d H:i:s');

              $result = $this->Crm_upload_docs_list->insertLoginDocs($data);
              $this->addInsHistoryUpdateLog($ar['0'],$data,'documents','1','1');
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
        if(!empty($type))
        {
            $arr = explode(',', $id);
            foreach ($arr as $key => $value) 
            {
              $this->Crm_upload_docs_list->insertLoginDocs($data,$value);
            }
        }
        else
        {
            $this->Crm_upload_docs_list->insertLoginDocs($data,$id);
        }
        return true;
        /*$data = [];
        $id = $this->input->post('id');
        $data['status'] = '0';
        $this->Crm_upload_docs_list->insertLoginDocs($data,$id);
        return true; */
    }

    public function showImagesToTag()
    {
        $customer_id = $this->input->post('customer_id');
        $case_id= $this->input->post('case_id');
       
        $doctype= $this->input->post('doctype');
        $data = [];
        $i = 0;
        $doc = 3;
        $imageList = $this->Crm_upload_docs_list->getInsImageList($customer_id,'','','',$doc,$case_id);
        $str = '[';
        foreach($imageList as $key => $val)
        {
            $image_type=end(explode('.',$val['doc_name']));
            $data[$i]['id'] = $val['id'];
            $data[$i]['small'] =(($val['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$val['doc_url'];
            $data[$i]['big'] =(($val['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$val['doc_url'];
            $data[$i]['image_type'] = $image_type;
            $data[$i]['tag_id'] = $val['tag_id'];
            $i++;
        }
        echo json_encode($data); exit;
    }
    
    public function saveLoginDocs()
    {
        $err = [];
        $req_id = [];
        $req = [];
        $caseInfo = [];
        $customer_id = $this->input->post('customer_id');
        $case_id = $this->input->post('case_id');
        $customerName = current($this->Crm_insurance->getCustomerInfo($customer_id));
        $doctype = 2;
        $imageList = $this->Crm_upload_docs_list->getInsImageList($customer_id,"","","",3,$case_id);
        $checkPendency = $this->Crm_upload_docs_list->getPendencyDetail($case_id,3);
        $docList = $this->Crm_upload_docs_list->getDocList('','3','','',$customerName['ins_category']);
        $tagArr=[];
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
            $tagArr[] = $imgv['tag_id'];
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
      //  echo "<pre>";print_r($docList);die;
        foreach($docList as $key => $val)
            {
                if( $val['parent_name'] == "Previous Policy" && $customerName['isexpired'] == 1 )
                continue;
                if(($val['is_required']>0))
                {

                    $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'],'3','','',$customerName['ins_category']);
                   // echo "<prE>";print_r($sublist);
                    foreach ($sublist as $skey => $sval)
                    {
                        $uploadDocList['name'] = $sval['name'];
                        if($sval['is_required']>0)
                        {
                            $req_sid[$val['sub_category_id']][]=$sval['sub_category_id'];
                        }                      
                    }    
                }
                
            }
           if(!empty($req_sid)){ 
            foreach($req_sid as $rkey => $rval)
            {
                foreach($rval as $kr)
                {
                    if(!in_array($kr, $tagArr))
                    {
                        $requiredIds .= $kr.',';
                    }
                }
            }
            $requiredId = rtrim($requiredIds,',');
            
            if(!empty($requiredId))
            {
                $pend = explode(',', $requiredId);
               
                $cn = $this->Crm_upload_docs_list->getDocList('','','','',$customerName['ins_category'],'1',$pend); 
                // echo "<pre>";print_r($cn);die;
                foreach($cn as $ck => $cv)
                {
                    $catlist[]= $cv['parent_name'].' - '. $cv['name'];   
                }
                $requiredList = implode(',',$catlist);                
                $caseInfo['upload_ins_doc_flag']='0';
                $this->Crm_insurance->updateInsuranceCaseById($caseInfo, $case_id);
                $results= array('status'=>'False','message'=>$requiredList);
                echo json_encode($results); exit;
            }
             }
            if($doctype=='2')
            {
                $caseInfo['upload_ins_doc_flag']='1';
                if($customerName['upload_docs_created_at']=='0000-00-00 00:00:00')
                {
                    $caseInfo['upload_docs_created_at']=date('Y-m-d H:i:s');
                }
                $left_menu_status = INSURANCE_LEFT_SIDE_MENU['UPLOAD_DOCS'];            
                if($caseDetails['left_menu_status'] < $left_menu_status){
                   $caseInfo['left_menu_status'] = $left_menu_status;
                } 
               $aaa = $this->Crm_insurance->updateInsuranceCaseById($caseInfo, $case_id);
               $this->addInsHistoryUpdateLog($case_id,$caseInfo,'Document','1','1');
               $results= array('status'=>'True','message'=>'Docs uploaded Successfully','Action'=>  base_url().'insListing/');
            }
            
          
        echo json_encode($results); exit;
    }
   /* public function pendencyByCatId()
    {
        $catID = $this->input->post('catId');
        $inscat = $this->input->post('inscat');
        $case_id = $this->input->post('case_id');
        $doctype = $this->input->post('doctype');
        $type = $this->input->post('type');
        $sublist = '';
        $ids=[];
        $imggg = $this->Crm_upload_docs_list->getInsImageList('','','','',$doctype,$case_id);
        $update_img_detail = $this->Crm_upload_docs_list->getPendencyDetail($case_id,$doctype);
        //echo "<pre>";
        //print_r($update_img_detail);
        foreach ($update_img_detail as $key => $value) {
            if($value['doc_id']>0)
            {
                 $ids[] = $value['doc_id'];
            }
         
        }
       // echo "tagggg-------------------------------------";
        //print_r($ids);
        $doctype=3;
        if($type=='getcategoryId')
        {
            $catlist=$this->Crm_upload_docs_list->getInsPendencyImageList('','','','',3,$case_id);
            //print_r($catlist);
            if(!empty($catlist)){
            $rcImg=true;
            $cids=[];
            $invImgcnt=0;
            $rcImgcnt=0;
            $form29Imgcnt=0;
            $form301Imgcnt=0;
            $form302Imgcnt=0;
            $prevpolicyImgcnt=0;
            $newpolicyImgcnt=0;
            $covernoteImgcnt=0;
            $inspectionImgcnt=0;
            foreach ($catlist as $key => $val) {
                if($val['tag_id']>0)
                {
                    if($inscat=='1'){
                     if($val['tag_id']=='218'){
                      $invImgcnt++;  
                    }
                    if($invImgcnt=='1'){
                    $cids[] = 217;
                    }
                    if($val['tag_id']=='216'){
                      $newpolicyImgcnt++;  
                    }
                    if($newpolicyImgcnt=='1'){
                    $cids[] = 215;
                    }
                    if($val['tag_id']=='214'){
                      $covernoteImgcnt++;  
                    }
                    if($covernoteImgcnt=='1'){
                    $cids[] = 213;
                    }
                    }
                    if($inscat=='2'){
                    if($val['tag_id']=='255' || $val['tag_id']=='207'){
                      $rcImgcnt++;  
                    }
                    if($rcImgcnt=='2'){
                    $cids[] = 206;
                    }
                    if($val['tag_id']=='222'){
                      $form29Imgcnt++;  
                    }
                    if($form29Imgcnt=='1'){
                    $cids[] = 221;
                    }
                    if($val['tag_id']=='224'){
                      $form301Imgcnt++;  
                    }
                    if($form301Imgcnt=='1'){
                     $cids[] = 223;
                    }
                    if($val['tag_id']=='226'){
                      $form302Imgcnt++;  
                    }
                    if($form302Imgcnt=='1'){
                     $cids[] = 225;
                    }
                    if($val['tag_id']=='236'){
                      $newpolicyImgcnt++;  
                    }
                    if($newpolicyImgcnt=='1'){
                     $cids[] = 235;
                    }
                    if($val['tag_id']=='238'){
                      $covernoteImgcnt++;  
                    }
                    if($covernoteImgcnt=='1'){
                     $cids[] = 237;
                    }
                    }
                    if($inscat=='3'){
                    if($val['tag_id']=='240' || $val['tag_id']=='241'){
                      $rcImgcnt++;  
                    }
                    if($rcImgcnt=='2'){
                    $cids[] = 239;
                    }
                    if($val['tag_id']=='210' || $val['tag_id']=='211' || $val['tag_id']=='212'){
                      $prevpolicyImgcnt++;  
                    }
                    if($prevpolicyImgcnt=='3'){
                    $cids[] = 209;
                    }
                    if($val['tag_id']=='243'){
                      $newpolicyImgcnt++;  
                    }
                    if($newpolicyImgcnt=='1'){
                     $cids[] = 242;
                    }
                    if($val['tag_id']=='245'){
                      $covernoteImgcnt++;  
                    }
                    if($covernoteImgcnt=='1'){
                     $cids[] = 244;
                    }
                    }
                    if($inscat=='4'){
                    if($val['tag_id']=='247' || $val['tag_id']=='248'){
                      $rcImgcnt++;  
                    }
                    if($rcImgcnt=='2'){
                    $cids[] = 246;
                    }
                    if($val['tag_id']=='257' || $val['tag_id']=='258' || $val['tag_id']=='259'){
                      $prevpolicyImgcnt++;  
                    }
                    if($prevpolicyImgcnt=='3'){
                    $cids[] = 256;
                    }
                    if($val['tag_id']=='250'){
                      $newpolicyImgcnt++;  
                    }
                    if($newpolicyImgcnt=='1'){
                     $cids[] = 249;
                    }
                    if($val['tag_id']=='252'){
                      $covernoteImgcnt++;  
                    }
                    if($covernoteImgcnt=='1'){
                     $cids[] = 251;
                    }
                    if($val['tag_id']=='254'){
                      $inspectionImgcnt++;  
                    }
                    if($inspectionImgcnt=='1'){
                     $cids[] = 253;
                    }
                    }
                }
                
            }
            }
            $sublist = $this->Crm_upload_docs_list->getInsDocList('0',$doctype,$cids,$inscat); 
            $str = "<option value=''>Select Category</option>";
            foreach($sublist as $key => $val)
            {
                $str .="<option value=".$val['id'].">$val[name]</option>";
            }
            echo $str; exit;
        }
        else
        {
            $sublist = $this->Crm_upload_docs_list->getInsDocList($catID,$doctype,$ids,$inscat); 
            $str = "<option value=''>Select Pendency Doc</option>";
            foreach($sublist as $key => $val)
            {
                $str .="<option value=".$val['id'].">$val[name]</option>";
            }
            echo $str; exit;
        }
    }*/
      public function pendencyByCatId()
    {
        //$parent = [];
        $catID = $this->input->post('catId');
        $case_id = $this->input->post('case_id');
        $doctype = $this->input->post('doctype');
        $type = $this->input->post('type');
        $inscat = $this->input->post('inscat');
        $rel_id = $this->input->post('rel_id');
        $sublist = '';
        $ids = [];
        $dd = [];
        $groupby = 1;
        $imggg = $this->Crm_upload_docs_list->getInsImageList('','','','','3',$case_id);
        $update_img_detail = $this->Crm_upload_docs_list->getPendencyDetail($case_id,'3');
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
                foreach ($imggg as $k => $v)
                {
                    if(!empty($v['parent_tag_id']))
                    {
                        $ids[] = $v['parent_tag_id'];
                    }
                }
    
           }
            
            $sublist = $this->Crm_upload_docs_list->getDocList('','3',$ids,'',$inscat,$groupby);
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
                $str .="<option value=".$val['id']." rel=".$val['parent_id'].">$prntName</option>";
            }
            echo $str; exit;
        }
        else
        {
            //echo $inscat;
            $groupby = 2;
            $sublist = $this->Crm_upload_docs_list->getDocList($rel_id,'3',$ids,'',$inscat,$groupby); 
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
    
    public function loanTagMapping()
    {
        $data = [];
        $err =[];
        $doc = '3';
        $doctype = $this->input->post('doctype');
        $id = $this->input->post('id');
        $customer_id = $this->input->post('customer_id');
        $case_id = $this->input->post('case_id');
        $img =  $this->input->post('ImgID');
        $tag = $this->input->post('taggID');
        $type = $this->input->post('type');
        $reason_id = $this->input->post('reason_id');
        $subcat = $this->input->post('subcat');
        if(!empty($img))
        {
             $data['image_id'] =$img;
        }
        if(!empty($subcat))
        {
             $data['tag_id'] = $subcat;
        }
        if(!empty($tag))
        {
            $data['parent_tag_id']= $tag;
        }
        

        $img_detail = $this->Crm_upload_docs_list->getInsImageList($customer_id,$img,'','',$doc);     
        if(($type=='add') || ($type=='bank'))
        {
            $data['created_on'] = date('Y-m-d H:i:s');
            $data['created_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
            if((empty($img_detail)) && (!empty($data['tag_id'])))
            {
                $checkPendency = $this->Crm_upload_docs_list->getPendencyDetail($case_id,$doc,$data['tag_id']);
                $imageList = $this->Crm_upload_docs_list->insertTagMapping($data);
                if(!empty($checkPendency))
                {
                    //echo "sfsfrf"; exit;
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
            if(!empty($img_detail))
            {
                $imageList = $this->Crm_upload_docs_list->insertTagMapping($data,$img_detail[0]['imgID']);
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
            $update_img_detail = $this->Crm_upload_docs_list->getInsImageList($customer_id,$img,'','',$doc);
            $data['mark_incorrect'] = $reason_id;
            $data['tag_id'] = '';
            $imageUp = (!empty($update_img_detail[0]['imgID'])?$update_img_detail[0]['imgID']:'');
            $imageList = $this->Crm_upload_docs_list->insertTagMapping($data,$imageUp);
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
    public function getTagName()
    {
        $arr        = ['8','9','10','11','12','13'];
        $tagid      = $this->input->post('tagid');
        $caseid     = $this->input->post('case_id');
        $imag_id    = $this->input->post('imag_id');
        $doctype    = $this->input->post('doctype');
        $errImg= "";
        if(!empty($imag_id))
        {
            $imageTags = $this->Crm_upload_docs_list->getInsImageList('',$imag_id,'','',$doctype,$caseid);
            if(!empty($imageTags))
            {
                if($imageTags[0]['err']>0)
                {
                    $errImg = ($imageTags[0]['err']==1)?'Incorrect Doc':'Unclear Image';
                    echo json_encode($errImg); exit;
                }
                if(in_array($imageTags[0]['tag_id'], $arr))
                {
                   $imageTag = $this->Crm_upload_docs_list->getInsImageList('','',$imageTags[0]['tag_id'],'',$doctype,$caseid);
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
            $imTag = $this->Crm_upload_docs_list->getInsImageList('','',$tagid,'',$doctype,$caseid);
            /*echo "<pre>";
            print_r($imTag);
            exit;*/
            if(!empty($imTag))
            {
                if(in_array($tagName[0]['id'], $arr))
                {
                    $imageTagss = $this->Crm_upload_docs_list->getInsImageList('','',$tagName[0]['id'],'',$doctype,$caseid);
                    $bankname = $this->Crm_banks->getBankNameBybnkId($imageTagss[0]['bank_id']);
                    $bank_name = $tagName[0]['name'] .' ( '. $bankname['bank_name'].' )';
                    echo json_encode($bank_name); exit;
                }
              echo json_encode($tagName[0]['name']); exit;
            }
        }
        echo json_encode(''); exit;
    }
    public function addPendencyDoc()
    {
        $data = [];
        $datas= [];
        $case_id = $this->input->post('case_id');
        $doctype = $this->input->post('doctype');
        $pendencyId = $this->input->post('pendencyId');
        $category_id = $this->input->post('category_id');
        //$pendencyName = $this->input->post('pendencyName');
        $update_img_detail = $this->Crm_upload_docs_list->getInsImageList('','',$pendencyId,'',$doctype,$case_id);
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
    public function insListing($insId=''){
        $page                  =   1;
        $limit                 =   10;
        $data=[];
        $roleType=array('Executive','Lead');
        $data['employeeList'] =  $this->Crm_user->getEmployee('3','',$roleType);
        $data['insId']        = (!empty($insId)) ? $insId:'';
        $userId=$this->session->userdata['userinfo']['id'];
        $userInfo=$this->session->userdata['userinfo'];
        $dealer_id=!empty($userInfo['dealer_id']) ? $userInfo['dealer_id'] : '';
        $insdashId=$this->uri->segment(2);
        $datapost              =   $this->input->post();  
        $ajax_type = "";
        
        if(isset($datapost['data']) && trim($datapost['data']) != ''){
            $data_str             = str_replace('amp;', '', $datapost['data']);
            parse_str($data_str,$postdata);
            unset($datapost['data']);

            if(isset($postdata['source']) && trim($postdata['source']) != ''){
                $source = intval($postdata['source']);               
            }
            foreach($postdata as $key => $val){
              $datapost[$key]    =   $val;
            }      
            $insdashId = intval($postdata['insdashId']);
            $page                   = $postdata['page'];
            $datapost['page']=$page;
            $is_search              = 1;
        }
        if(isset($insdashId) && ($insdashId!='')){
            $datapost['insdashId']=$insdashId;
        }
        if(isset($userId) && ($userId!='')){
        $datapost['userId']=$userId;
        }
        $datapost['dealerID']=$dealerId;
        $datapost['userId']=$userId; 
        if(!empty($datapost)){  
           $ajax_type = trim($datapost['ajax_type']);
        }
        if(isset($datapost['export']) && !empty($datapost['export']) ) {
         $getLeads= $this->Crm_insurance->getInsurance($datapost,$dealerId,$userId,1);
        }else{
         $getLeads= $this->Crm_insurance->getInsleadsQuery($datapost,1);
        }
        $leadTabCounts=count($this->Crm_insurance->getInsleadsQuery($datapost));
        $data['lead_status'] = $this->Crm_insurance_customer_status->getCustomerStatus();        
        $data['query']=$getLeads;
        $data['leadtabCount']=$leadTabCounts;
        $data['limit'] =(!empty($limit)) ? $limit :0;
        $data['page'] =(!empty($page)) ? $page :1;
        $data['insId']=(!empty($insdashId)) ? $insdashId :'';
        $data['pageTitle'] = 'Insurance Enquiry';
        $data['pageType'] = 'insuranceList';
        if ( isset($datapost['export']) && !empty($datapost['export']) ) {
        $filename = 'Insurance_Cases_'.date('dM').'.xls';
        exportInsData($data['query'],$filename,$data['dealer_info'][0]);
        }
        //echo "<pre>";print_r($data);die;
        if( $ajax_type == 1){
           echo $datas=$this->load->view('insurance/ajax_getInsurance',$data,true); exit;}
        else{
           $this->loadViews("insurance/insListing",$data);
        }
        
   }
   
   public function getDealerList()
    {
        $str = '';
        $dealerList = $this->Crm_dealers->getDealers();
        $str  = "<option value=''>Select Dealer</option>";
        foreach ($dealerList as $dkey => $dval) 
        {
            $str .="<option value='" .$dval['id']. "'>" . $dval['organization'] . "</option>";
        }
        echo $str; exit;
    }
    
    public function getInsurerSearchList()
    {
        $catId = $this->input->post('catId');
        $customer_id = $this->input->post('customer_id');
        $customerName = current($this->Crm_insurance->getCustomerInfo($customer_id));
        $str = '';
        if($catId=='1'){
        $idv='';
        $versionId=!empty($customerName['variantId']) ? $customerName['variantId']:'';
        $filterData=current($this->Crm_insurance->getFilterQuotesData($customer_id,1));
        }
        $zoneData=$this->Crm_insurance->getZoneCcAge($customer_id);
        if($catId=='1'){
            $zoneData[0]['duration']=$filterData['duration'];
            $zoneData[0]['car_age']='1';
        }
        if(!empty($zone)){
          $zoneData[0]['zone']= $zone; 
        }
        if(!empty($zoneData)){
            $cdata=$this->Crm_insurance->getCalculatePremium($zoneData);
        }
        if(!empty($cdata[0]['cc'])){
        $cc=$cdata[0]['cc'];    
        $thirdPData= current($this->Crm_insurance->getThirdPartyRates($catId,$cc,1));
        }
        if(empty($thirdPData))
            $thirdPData = array();
          $thirdPData['basic_third_party']=(!empty($thirdPData['basic_third_party'])) ? trim(indian_currency_form($thirdPData['basic_third_party'])) : 0;
          $thirdPData['personal_acc_cover']=(!empty($thirdPData['personal_acc_cover'])) ? trim(indian_currency_form($thirdPData['personal_acc_cover'])):0;
          $thirdPData['paid_driver']=(!empty($thirdPData['paid_driver'])) ? trim(indian_currency_form($thirdPData['paid_driver'])):0;
          $ins_ids=[];
        $currinsurerIds = $this->Crm_insurance->getcurrentInsurerId($customer_id);
        if(!empty($currinsurerIds)){
            foreach($currinsurerIds as $val){
                $ins_ids[]=$val['cid'];
            }
        }
        
        $insurerList = $this->Crm_previous_insurer->getInsurerList();
        $company_list= "<option value=''>Select Company</option>";
        foreach ($insurerList as $dkey => $dval) 
        {
            if(!in_array($dval['prev_policy_insurer_slug'], $ins_ids)){
            $company_list .="<option value='" .$dval['prev_policy_insurer_slug']."#".$dval['logo']."'>".$dval['short_name']."</option>";
            }
        }
        $strCover = "<option value=''>Select</option>";
        $mcoverlist=$this->Crm_insurance->getadditionalCover(array('11','12'));
            if(!empty($mcoverlist)){
                $x=0;
                foreach($mcoverlist as $key=>$val){
                    $mselected='';
                    $strCover .="<option class='' value='".$val['coverName']."'>".$val['labelName']."</option>";
                }
            }
            $response =array("compony"=>$company_list,"strCover"=>$strCover,"insData"=>$thirdPData);
        
        echo json_encode($response); exit;
    }
    
    
   
   public function ajax_getInsurance()
   {
       $pages        =1;        
       $limit       = 10;
       $perPageRecord = 10;
       
       $data=[];
       $dealerId=DEALER_ID;
       $userId=$this->session->userdata['userinfo']['id'];
       $postdata              =   array();
       $datapost=$this->input->post();       
       $datapost['type']='';
       $datapost['userId']=$userId;
       if(isset($datapost['data']) && trim($datapost['data']) != ''){
            $strdata              = str_replace('amp;', '', $datapost['data']);
            parse_str($strdata,$postdata);
            unset($datapost['data']);

            foreach($postdata as $key => $val){
              $datapost[$key]    =   $val;
            }

            $page                   = $postdata['page'];
            $is_search              = 1;
            $pageNo = (isset($datapost['page']) && $datapost['page'] != '') ? $datapost['page'] : '1';
            if(isset($datapost['issearch']) && $datapost['issearch']=='1'){
             $startLimit = ($pages - 1) * $perPageRecord;
             $datapost['page']='1';
            }else{
            $startLimit = ($pageNo - 1) * $perPageRecord;
            }
        }
        if(isset($userId) && ($userId!='')){
        $datapost['userId']=$userId;
        }
         $datapost['dealerID']=$dealerId;
        $datapost['userId']=$userId; 
        // $getLeads= $this->Crm_insurance->getInsurance($datapost,$dealerId,$userId,1);
        $getLeads= $this->Crm_insurance->getInsleadsQuery($datapost,1);
        $leadTabCounts=count($this->Crm_insurance->getInsleadsQuery($datapost));
       // $getLeads= $this->Crm_insurance->getInsurance($datapost,$dealerId,$userId);
       // $totCounts=count($this->Crm_insurance->getInsleadsQuery($datapost,$perPageRecord,$pageNo,$startLimit));
       //$leadTabCounts=count($this->Crm_insurance->getInsleadsQuery($datapost,'','',''));
       $data['lead_status'] = $this->Crm_insurance_customer_status->getCustomerStatus();
       $data['query']['leads']=$getLeads;
       $data['leadtabCount']=$leadTabCounts;
       $data['totalCount']=$totCounts;
       $data['limit'] =(!empty($limit)) ? $limit :0;
       $data['page'] =(!empty($page)) ? $page :1;
     //  echo "<pre>";print_r($data);die;
        $this->load->view('insurance/ajax_getInsurance',$data);
     
   }
   
   public function ajax_save_inquiry(){
         $request=$this->input->post();       
        /*$customerId=$this->saveCustomerLead($request);
        $request['customer_id']=$customerId;
        if($request['make']!='' && $request['model']!='' && $request['version']!='' && intval($customerId)>0){
        $carId=$insuCarDetailObj->saveCarDetail($request);
        }*/
        $return=$this->trackAllHistory($request);
        return $return;
   }
   
   public function saveCustomerLead($request)
    {
         $checkDuplicate = $this->getCustomerDetail($request);
         $historyObj= new InquiryHistory();
         if($request['follow_up']){
             $follow_up=date('Y-m-d H:i:s',strtotime($request['follow_up']));
         }
         $requestData = [
            'name'              => ($request['name']!=''?$request['name']:$checkDuplicate['name']),
            'email_address'     => ($request['email_address']!=''?$request['email_address']:$checkDuplicate['email_address']),
            'mobile'            => ($request['mobile']!=''?$request['mobile']:$checkDuplicate['mobile']),
            'city'              => ($request['city']!=''?$request['city']:$checkDuplicate['city']),
            'status'            => ($request['status']>0?$request['status']:$checkDuplicate['status']),
            'follow_up'         => ($follow_up!=''?$follow_up:$checkDuplicate['follow_up']),
            'dealer_id'         => ($request['dealer_id']>0?$request['dealer_id']:$checkDuplicate['dealer_id']),
            
            'updated_date'      => $this->dateTime
           ];
        
       
       
        if (empty($checkDuplicate))
        {
            if($request['created_date']){
            $requestData['created_date']    =   $request['created_date']; 
            $requestData['source']    =   ($request['source'])?$request['source']:'';
            }else{
            $requestData['created_date']    =   $this->dateTime;
            }
            $requestData['source']          =   $request['source'];
            $customer_id=$this->save($requestData);
            
            //echo "id:".$customer_id;exit;
        }else{
            
            $this->save($requestData, ['customer_id'=>$checkDuplicate['customer_id']]);
            $customer_id=$checkDuplicate['customer_id'];
            if($request['update']!='update'){
            $request['repeat_lead']='Customer show interest again';
            $request['customer_id']=$customer_id;
             $historyObj->trackAllHistory($request);
            }
        }
        
        return $customer_id;
    }
   
   public function trackAllHistory($data,$source='1') {
        $combinationId = $this->unique_combination_id();
        if (empty($data['usertype'])) {
            $data = $this->getUserSpecificData($data);
        }
        $data['source'] = $source;
        
        if($data['status'])
        {   
            //$this->saveStatusHistory($data, $combinationId);
        }
        if($data['follow_up']  && $data['follow_up']!='')
        {
            //$this->saveFollowUpHistory($data, $combinationId);
        }
        if($data['comment'])
        {
            $output=$this->saveCommentHistory($data, $combinationId);
        }
        //if($data['repeat_lead'])
        //{
            //$data['comment']=$data['repeat_lead'];
            //$this->saveCommentHistory($data, $combinationId);
        //}
        echo $output;
    }
    public function getUserSpecificData($request) {
        if (isset($request['user_id']) && $request['user_id'] > 0) {
            $request['usertype'] = 'TELECALLER';
            $request['userid'] = $_SESSION['user_id'];
        } else {
            $request['usertype'] = 'dealer';
            $request['userid'] = DEALER_ID;
            $request['dealer_id'] = DEALER_ID;
        }
        return $request;
    }
   
   public function saveCommentHistory($data, $combinationId)
            {
                //$chkDulicateHistory=$this->Crm_insurance->checkExistingHistory($this->activity_mapping['comment'], $data['comment'], $data['customer_id'],$data['type']);
                    //if(!$chkDulicateHistory){
                $insertDataArray['activity']       = $this->activity_mapping['comment'];
                $insertDataArray['activity_text']  = $data['comment'];
                $insertDataArray['mobile']         = $data['mobile'];
                $insertDataArray['dealer_id']      = $data['dealer_id'];
                $insertDataArray['combination_id'] = $combinationId;
                $insertDataArray['user_id']        = $data['userid'];
                $insertDataArray['source']         = $data['source'];
                $insertDataArray['customer_id']    = $data['customer_id'];
                $insertDataArray['created_date']   = $this->dateTime;
                $insertDataArray['history_type']   = $data['type'];
                $jsonData=  json_encode($data);
                $textunique = md5($jsonData);
                $insertDataArray['hashentry'] =    $textunique;

                if($insertDataArray)
                {
                    $this->Crm_insurance->saveInsurancehistory($insertDataArray);
                    return 1;
                }
                 else {
                    return false;
                }
                    }
           
    public function saveInsHistory($data, $customerId='')
    {
        $insertDataArray=array();
        $userId=$this->session->userdata['userinfo']['id'];
        if(!empty($data)){
        $insArr=$this->Crm_insurance->alreadyExistInsurancehistory($data);
        if(empty($insArr)){
        $insertDataArray['activity_text']  = $data['activity_text'];    
        $insertDataArray['company_id']     = (!empty($data['company_id'])) ? $data['company_id'] : '';
        $insertDataArray['source']         = $data['source'];
        $insertDataArray['customer_id']    = $data['customer_id'];
        $insertDataArray['user_id']   = $userId;
        $insertDataArray['created_date']   = $data['created_date'];
        $insertDataArray['history_type']   = $data['history_type'];
        }}
        if($insertDataArray)
        {
            $this->Crm_insurance->saveInsurancehistory($insertDataArray);
            return 1;
        }
         else {
            return false;
        }
    }    
    public function get_history(){
        $customer_id = $this->input->post('customer_id');
        $this->load->helpers('insurance_history_helper');
        $usertype = '';
        if (!empty($customer_id)) {
            $caseDetails=current($this->Crm_insurance->getCaseDetailsByCustomerId($customer_id));
            $caseId=!empty($caseDetails['id']) ? $caseDetails['id']:'';
            $historyData = $this->Crm_insurance->getInshistory($customer_id, $total = '');
            $renewhistoryData = $this->Crm_renew_history_track->getRenewHistoryTrack($caseId, $usertype);
            $renewhistoryData='';
            if ($historyData || $renewhistoryData) {
                echo renderHistoryHTMLFinaltimeline($historyData,$renewhistoryData);
                exit;
            } else {
                echo '<div class="col-sm-12" style="text-align:center">No history available</div>';
                exit;
            }
        } else {

            echo 'Sorry request not valid';
            exit;
        }
    }        
 
    public function unique_combination_id() {
        $words = "abcdefghijlmnopqrstvwyz";
        $vocals = "aeiou";
        $length=23;
        $text = "";
        $vocal = rand(0, 1);
        for ($i = 0; $i < $length; $i ++) {
            if ($vocal) {
                $text .= substr($vocals, mt_rand(0, 4), 1);
            } else {
                $text .= substr($words, mt_rand(0, 22), 1);
            }
            $vocal = !$vocal;
        }
        $text = sha1(uniqid($text));
        $text = substr($text, -7, 6);
        return $text;
    }
    
    public function populateWashoutReason()
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

    public function cancelNow()
    {
        $type_id = $this->input->post('type_id');
        $type = $this->input->post('type');
        $customer_id = $this->input->post('customer_id');
        $case_id = $this->input->post('case_id');
        $canceltxt=$this->input->post('canceltxt');
        $closetxt=$this->input->post('closetxt');
        $other=($type_id=='4') ? $closetxt : '';
        $other=($type_id=='3') ? $canceltxt : '';
        $userId=$this->session->userdata['userinfo']['id'];
        $data = [];
        if(($type=='cancel') && ($type_id=='3'))
        {
        $data['ins_approval_status'] = '9';
        $data['last_updated_status']='7';
        $data['other_reason']=$other;
        }else if($type=='cancel'){
          $data['ins_approval_status'] = '9';
          $data['last_updated_status']='7';  
        }
        if(($type=='washout') && ($type_id=='4'))
        {
            $data['ins_approval_status'] = '6';
            $data['last_updated_status']='8';
            $data['other_reason']=$other;
            
        }else if($type=='washout'){
        
            $data['ins_approval_status'] = '6';
            $data['last_updated_status']='8';
            $data['follow_status'] = '5';
            $updateHistory = $this->Crm_renew->addUpdateHistory(array('case_id' => $case_id,'activity' => 5,'activity_text' => $closetxt,'user_id' => $userId));
            
            
        }
        $data['last_updated_date'] = date('Y-m-d H:i:s');
        $data['cancel_id'] = $type_id;
        $data['cancel_date'] = date('Y-m-d H:i:s');
        $this->addInsHistoryUpdateLog($customer_id,'','-','','1');
        $cancelUpdate = $this->Crm_insurance->updateInsuranceCase($data, $customer_id);
        $histArr=array();
        $histArr['customer_id']=$customer_id;
        $histArr['created_date']=date('Y-m-d H:i:s');
        $histArr['history_type']='insurance';
        $histArr['company_id']='';
        if($type=='washout'){
        $histArr['source']='not_interested';
        $histArr['activity_text']=$closetxt;
        $histArr['company_id']='';
        }else{
        $histArr['source']='policy_cancel';
        $histArr['activity_text']=$canceltxt;
        $histArr['company_id']='';
        }
        $this->saveInsHistory($histArr);
        echo $cancelUpdate; exit;
    }

    public function reopenCase()
    {
        $customerId = $this->input->post('customerId');
        $link = $this->input->post('links');
        $getcaseDetails = $this->Crm_insurance->getCaseDetailsByCustomerId($customerId);
        $getcaseDetails = current($getcaseDetails);
        if($getcaseDetails['renew_flag'] == '1'){
        $data['follow_status'] = 2;
        $data['follow_up_date'] = date("Y-m-d H:i:s");
        }
        $data['last_updated_status']=$this->getlastReopenStatus($link,$customerId);
        $data['last_updated_date'] = date('Y-m-d H:i:s');
        $data['ins_approval_status'] = '5';
        $data['cancel_id'] = '0';
        $data['reopen_date'] = date('Y-m-d H:i:s');
        $histArr=array();
        $histArr['customer_id']=$customerId;
        $histArr['created_date']=date('Y-m-d H:i:s');
        $histArr['history_type']='insurance';
        $histArr['company_id']='';
        $histArr['source']='reopen';
        $histArr['activity_text']='Reopen';    
        $this->saveInsHistory($histArr);
        $cancelUpdate = $this->Crm_insurance->updateInsuranceCase($data, $customerId);
        $caseDetails=$this->Crm_insurance->getCaseDetailsByCustomerId($customerId);
        $case_id=$caseDetails[0]['id'];
        $this->addInsHistoryUpdateLog($case_id,'','-','','1');
        echo "1"; exit;
    }
    
    public function getlastReopenStatus($link,$customerId){
        $data=array();
        $dataArr=$this->Crm_insurance->getCaseDetailsByCustomerId($customerId);
        $links=explode("/",$link);
        if(!empty($links)){
            switch ($links[3]) {
                case 'addInsurance':
                $data['last_updated_status']='1';
                    break;
                case 'insFileLogin':
                case 'inspersonalDetail':
                case 'insvehicalDetail': 
                case 'insPreviousDetails':    
                   if(($dataArr[0]['ins_category']=='2') || ($dataArr[0]['ins_category']=='3') || ($dataArr[0]['ins_category']=='4')){
                    $data['last_updated_status']='2';
                    }elseif($dataArr[0]['ins_category']=='1'){
                       $data['last_updated_status']='1'; 
                    }
                    break;
                case 'insInspection':
                case 'insDocumentDetails':
                case 'insPremiumDetails':    
                if(($dataArr[0]['ins_category']=='2') || ($dataArr[0]['ins_category']=='3') || ($dataArr[0]['ins_category']=='4')){
                    $data['last_updated_status']='3';
                    }elseif($dataArr[0]['ins_category']=='1'){
                       $data['last_updated_status']='1'; 
                    }
                    break;
                case 'insPolicyDetails':
                    
                    if(!empty($dataArr) && ($dataArr[0]['current_policy_issued']=='1')){
                    $data['last_updated_status']='4';
                    }elseif(!empty($dataArr) && ($dataArr[0]['current_policy_issued']=='2')){
                    $data['last_updated_status']='5';    
                    }
                    break;
                case 'inspaymentDetail':
                    if(!empty($dataArr) && ($dataArr[0]['payment_by']=='2') && ($dataArr[0]['pay_reason']=='3')){
                    $data['last_updated_status']='6';
                    }
                    break;
                default:
                    break;
            }
        }
        return $data['last_updated_status'];
    } 
    
    public function deleteFormLogin(){
        $id = $this->input->post('id');
        $types = $this->input->post('type');
        if($types=='inspection'){
        $cancelUpdate = $this->Crm_insurance->updateInspectionById($id);
        }else if($types=='quotes'){
         $cancelUpdate = $this->Crm_insurance->updateQuotesById($id);   
        }
        if($cancelUpdate) {
            return true;
        }else{
            return false;   
        }
    }

    public function confirmsave(){
       echo renderInsuranceHTMLFinal();exit;
    }


     public function getImagedownload($caseId,$doc='3')
    {
        $this->load->library('zip');
        $data = [];
       // $doc = 1;
        $newid = '';
        $i=1;
        $imageList = $this->Crm_upload_docs_list->getInsImageList('','','','',$doc,$caseId);
        if(!empty($imageList)){
        $id='';
            foreach($imageList as $key => $val)
            {
                $id.= $val['id'].',';
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
           
            $imageName = $this->Crm_upload_docs_list->getInsImageList('','','','','','','','',$arr);
            $imgdata=array();
            foreach ($imageName as $key => $value) 
            {
                if(!empty($value))
                {
                    $na = !empty($value['buyer_name'])?$value['buyer_name']:$value['customer_company_name'];
                    $newfname='';
                    $imgContet='';
                    $newfname = !empty($value['aws_url'])?$value['aws_url']:UPLOAD_INS_IMAGE_PATH.$value['doc_name'];
                    $imgContet=file_get_contents($newfname);
                    if(!empty($value['name'])){
                        $a = explode('.', $value['doc_name']);
                        $nam = $i.'_'.$na.'-'.$value['name'].'.'.$a[1];
                    }
                     else
                    {
                        $nam = $i.'_'.$na.'-'.$value['doc_name'];  
                    }
                    $imgdata[$nam] = $imgContet;
                    $i++;
                }
                else
                {
                    echo "error"; exit;
                }
               
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
        
        $this->insDocumentDetails($caseId);
    }
    
    public function getmakemodelversionlist()
    {
        //error_reporting(E_ALL);
        $makeExistArr       = array('0'=>'Maruti','1'=>'Hyundai','2'=>'Honda','3'=>'Chevrolet');
        $types              = trim($this->input->post('type'));
        $year               = trim($this->input->post('year'));
        $launchDate         = trim($this->input->post('year'))."-01"."-01";
        if (isset($types) && ($types== 'make')) {
            $where          = " WHERE 1=1 ";
            $fields         = "id,make";
            $makeListArr    =  $this->UserDashboard->getCarMakeList('all',$fields,$where);
            
            $option = "<option value='' >Select Make</option>";
            foreach ($makeListArr as $MakeKey => $MakeValue) {
                $option .="<option value='" . $MakeValue['id'] . "' >" . $MakeValue['make'] . "</option>";
            }
            echo $option;
            exit();
        }

        if (isset($types) && ($types == 'model')) {
            $makeId           = trim($this->input->post('make'));
            $make=$this->Crm_insurance->getmakeById($makeId);
            $where          = " WHERE make='".$make."' AND parent_model_id='0'";
            
            $fields         = "id,make_id,make,model";
            $modelListArr   =  $this->Make_model->getModelByMakeId($makeId);
            $option = "<option value='' >Select Model</option>";
            foreach ($modelListArr as $ModelKey => $ModelValue) {
                $option .="<option value='" . $ModelValue['id'] . "' >" . $ModelValue['model'] . "</option>";
            }
            echo $option;
            exit();    
        }
        
        if (isset($types) && ($types == 'version')) {
            //$make       = trim($this->input->post('mk_id'));
            $makeText   = trim($this->input->post('make'));
            $make=$this->Crm_insurance->getmakeId($makeText);
            $model      = trim($this->input->post('model_id'));
            $mkYear   = trim($this->input->post('year'));
            $fields     = " id ";
            $sqlJoin    = " ";
            $where      = $sqlJoin." WHERE make_model.parent_model_id='".$model."'";
            $versionListArr =array();
            $versionListArr  =  $this->Make_model->getVersionById($make,$model);
            
            $option = "<option value='' >Select Version</option>";
            foreach ($versionListArr as $VersionKey => $VersionValue) {
                $option .="<option value='" . $VersionValue['db_version_id'] . "' >" . $VersionValue['db_version'] . " (".$VersionValue['uc_fuel_type']."-".$VersionValue['Displacement']." cc)". "</option>";
            }
            echo $option;
            exit();    
        }
    }
    
    public function getSalesDetails(){
        $dealerId   = trim($this->input->post('dealerId'));
        $salesData=$this->Crm_insurance->getSalesId($dealerId);
        $option = "";
            foreach ($salesData as $salesKey => $salesVal) {
                $selected=($salesVal['dealerId']==$dealerId) ? 'selected=selected':'';
                $option .="<option value='" . $salesVal['id'] . "' $selected >" . $salesVal['name'] . "</option>";
            }
            echo $option;
            exit();
    }
    
    public function saveUpdatefilterQuotesData(){
        $params = $this->input->post();
        $customerId=$params['customerId'];
        $postdata=[];
        if(!empty($params)){
            $postdata=array(
                    'customer_id' => $params['customerId'],
                    'duration' => !empty($params['duration']) ? $params['duration'] :'',
                    'claim_taken' => !empty($params['claimtaken']) ? $params['claimtaken'] :'',
                    'ncb_discount' => (!empty($params['ncbdiscount']) && ($params['claimtaken']=='2')) ? $params['ncbdiscount']:'',
                    'ncb_discount_prev' => (!empty($params['ncbdiscountprev']) && ($params['claimtaken']=='2')) ? $params['ncbdiscountprev']:'', 
                    'status' => '1'
                    );
            $response=$this->Crm_insurance->addFilterQuotesData($postdata);
            
            $postdata = array(
                  'current_policy_type' => !empty($params['policy_type']) ? $params['policy_type'] :'1',
                  'current_ins_duration' => !empty($params['duration']) ? $params['duration'] :'',
            );
            $response=$this->Crm_insurance->addInsuranceCustomer($postdata,$customerId);
//            echo "<pre>";print_r($postdata);
//            echo $response;die;
           if($params['srcinscat'] != 1){ 
            if(!empty($params['previous_policy_type']) && $params['policy_type'] != $params['previous_policy_type']){
              $quotes=$this->Crm_insurance->deactivateQuotes($customerId);
            }
           } 
            
            $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
            if($customerName['zone']!='' && $customerName['car_age']!='' && $customerName['cc']!=''){
            $quotes=$this->Crm_insurance->getNewInsQuotesByCustomerId($customerId);
            if(!empty($quotes)){
            $quotes[0]['inscat']=!empty($params['srcinscat']) ?  $params['srcinscat']:''; 
            
            foreach($quotes as $kq=>$vq){
            $this->Crm_insurance->setFinalQuotesData($customerId,$vq,'1');
            }
            }
            }
            if(!empty($response)){
            $result= array('status'=>'True','Action'=>  base_url().'insFileLogin/' . base64_encode('customerId_' . $customerId));   
            }
            echo json_encode($result);exit;
            
        }
        
    }
    
    public function getInsuranceQuotes(){
        $params = $this->input->post();
        $is_subtract = 0;
    if(!empty($params['ftype']) &&  ($params['ftype']=='2')){
            if(!empty($params['madd_on'])){
                foreach($params['madd_on'] as $k=>$mv){
                    if($mv == "anti_theft" && count($params['madd_on']) == 1){
                        $params['is_subtract'] = 1;
                    }else{
                        $params['is_subtract'] = 0;
                    }
                  $params[$mv]='1';  
                }
            }
           $params['idv'] = $params['midv'];
           $params['idv_2'] = $params['midv2'];
           $params['idv_3'] = $params['midv3'];
           $params['ins_detail'] = $params['mins_detail'];
           $params['basic_od_amt'] = $params['mbasic_od_amt'];
           $params['electrical_accessories_txt'] = $params['melectrical'];
           $params['non_electrical_accessories_txt'] = $params['mnonelectrical'];
           $params['ncb_discount'] = $params['mncb_discount'];
           $params['od_discount'] = $params['mod_discount'];
           $params['pass_cover'] = $params['mpass_cover'];
           $params['per_acc_cover'] = $params['mper_acc_cover'];
           $params['paid_driver'] = $params['mpaid_driver'];
           $params['od_discount'] = $params['mod_discount'];
           $params['add_on_txt'] = $params['maddon_price'];
           $params['qsource'] = $params['qsource'];
           $params['quote_date'] = date('Y-m-d',strtotime($params['quote_date']));           
           $params['is_subtract'] = $is_subtract;
           
        }else{
           $params['pass_cover'] = $params['pass_cover'];
           $params['per_acc_cover'] = $params['per_acc_cover'];
           $params['paid_driver'] = $params['paid_driver'];
           $params['qsource'] = $params['qsource'];
           $params['quote_date'] = date('Y-m-d',strtotime($params['quote_date']));
        }
        $ins_details = explode("#", $params['ins_detail']);
        $result=[];
        $customerId=!empty($params['customer_idd']) ? $params['customer_idd']:'';
        if(empty($params['quote_id'])){
            $histArr=array();
            $histArr['company_id']=$ins_details[0];
            $histArr['customer_id']=$customerId;
            $histArr['created_date']=date('Y-m-d H:i:s',strtotime($params['quote_date']));
            $histArr['history_type']='insurance';
            $histArr['source']='quotes';
            $histArr['activity_text']='Quotes Share';    
           // echo "<pre>aaa";print_r($histArr);die;
            $this->saveInsHistory($histArr);  
        }     
        $quotesData=$this->Crm_insurance->getFilterQuotesData($customerId);
        $caseData=current($this->Crm_insurance->getCaseDetailsByCustomerId($customerId));
        $params['case_id']=$caseData['id'];
        $params['zone']=!empty($params['zone_list'])?$params['zone_list']:$params['zone_list_new'];//!empty($caseData['zone']) ? $caseData['zone']:'';
        $params['cc']=!empty($caseData['cc']) ? $caseData['cc']:'';
        $quotesDataFinal=$this->Crm_insurance->setFinalQuotesData($customerId,$params);
            $data['caseData']=current($this->Crm_insurance->getCaseDetailsByCustomerId($customerId));
            if( !in_array($data['follow_status'], [4,6])){
                $renewcaseArr=[];
                $renewcaseArr['follow_status']='3';
                $this->Crm_insurance->updateInsuranceCase($renewcaseArr,$customerId);
            }
            $renewdata=[];
            $renewdata['activity']='3';
            $renewdata['case_id']=$data['caseData']['id'];
            $renewdata['user_id']=isset($this->session->userdata['userinfo']['id']) ? $this->session->userdata['userinfo']['id']:'';
            $this->Crm_renew->addUpdateHistory($renewdata);
        $caseArr=array();
      //  $caseArr['quote_add_date']=date('Y-m-d H:i:s');
        $caseArr['quote_shared_status']='1';
        $caseArr['last_updated_date']=date('Y-m-d H:i:s');
        $lastStatusArr=$this->Crm_insurance->getlastStatusId($customerId);
        if(!empty($lastStatusArr[0]['lastStatus']) &&  ($lastStatusArr[0]['lastStatus'] < '2')){
        $caseArr['last_updated_status']='2';
        }
        $this->Crm_insurance->updateInsuranceCaseById($caseArr,$caseData['id']);
        $this->addInsHistoryUpdateLog($caseData['id'],$quotesDataFinal,'Quotes','1','1');
        if(!empty($quotesDataFinal)){
        $result= array('status'=>'True','message'=>'Quotes Details Added Successfully','Action'=>  base_url().'insFileLogin/' . base64_encode('customerId_' . $customerId));   
        }
        echo json_encode($result);exit;
    }
    
    public function get_quotespop(){
        $quote_id = $this->input->post('quote_id');
        $customerId = $this->input->post('customer_id');
        $inscat = $this->input->post('inscat');
        $this->load->helpers('insurance_helper');
        
        if ($quote_id) {
           $insData = $this->Crm_insurance->getQuotesListByQuoteId($quote_id);
           //echo "<pre>";print_r($insData);die;
           if ($insData) {
                echo renderInsurancequotesBreakUp($insData,$inscat);
                exit;
            } else {
                echo '<div class="col-sm-12" style="text-align:center">No Breakup available</div>';
                exit;
            }
        } else {

            echo 'Sorry request not valid';
            exit;
        }
    }
    public function getQuoteInsurerData(){
        $quote_id = $this->input->post('quote_id');
        $str = '';
        $insData = current($this->Crm_insurance->getQuotesListByQuoteId($quote_id));
        $addOnListt=current($this->Crm_insurance->getAddOnQuotesListByQuoteId($quote_id));
        $addOnList=$this->filterAddon($addOnListt);
        
        if(!empty($insData)){
            $insData['quote_date']= (!empty($insData['quote_date']) && $insData['quote_date']!="0000-00-00")?$insData['quote_date']:date('Y-m-d');
            if($insData['ftype']=='2'){
              $mcoverlist=$this->Crm_insurance->getadditionalCover(array('11','12'));
              $insData['basic_own_damage']=(!empty($insData['basic_own_damage'])) ? trim(indian_currency_form($insData['basic_own_damage'])):0;
              $insData['ncb']=(!empty($insData['ncb'])) ? trim(indian_currency_form($insData['ncb'])) : 0;
              $insData['add_on']=(!empty($insData['add_on'])) ? trim(indian_currency_form($insData['add_on'])):0;
              $insData['electrical_accessories_txt']=(!empty($insData['add_on'])) ? trim(indian_currency_form($insData['electrical_accessories_txt'])):0;
              $insData['non_electrical_accessories_txt']=(!empty($insData['add_on'])) ? trim(indian_currency_form($insData['non_electrical_accessories_txt'])):0;
           }
           else{
               $mcoverlist=$this->Crm_insurance->getadditionalCover();
            }
            if(!empty($mcoverlist)){
                $x=0;
                foreach($mcoverlist as $key=>$val){
                    $mselected='';
                    if(in_array($val['coverName'], $addOnList)){
                    $mselected= "selected='selected'";
                    }
                    $strCover .="<option class='' value='".$val['coverName']."' $mselected>".$val['labelName']."</option>";
                }
            } 
            $insData['od_discount']=(!empty($insData['od_discount'])) ? trim(indian_currency_form($insData['od_discount'])):0;
            $insData['passenger_cover_txt']=(!empty($insData['passenger_cover_txt'])) ? trim(indian_currency_form($insData['passenger_cover_txt'])):0;
            $insData['pcover']=(!empty($insData['pcover'])) ? trim(indian_currency_form($insData['pcover'])):0;
            $insData['paid_driver']=(!empty($insData['paid_driver'])) ? trim(indian_currency_form($insData['paid_driver'])):0;
            $insData['totpremium']=(!empty($insData['totpremium'])) ? trim(indian_currency_form($insData['totpremium'])) : 0;
            $insData['idv']=(!empty($insData['idv'])) ? trim(indian_currency_form($insData['idv'])):0;
            $insData['quote_date']=(!empty($insData['quote_date'])) ?date('d-m-Y', strtotime($insData['quote_date'])):0;          
            $insData['od_disc_perc']=trim($insData['od_disc_perc']);
            $insData['depAmt']=trim(indian_currency_form($insData['depAmt']));
           
            $qsource=trim($insData['qsource']);
            $insurer=trim($insData['insurance_company']);
        }
        $ins_ids=[];
        $customer_id = $this->input->post('customer_id');
        $currinsurerIds = $this->Crm_insurance->getcurrentInsurerId($customer_id);
        if(!empty($currinsurerIds)){
            foreach($currinsurerIds as $val){
                $ins_ids[]=$val['cid'];
            }
        }
        $insStr='';
        $insurerList = $this->Crm_previous_insurer->getInsurerList();
        
        $insStr  = "<option value=''>Select Company</option>";
        $insss='';
        foreach ($insurerList as $dkey => $dval) 
        {
            if(!in_array($dval['prev_policy_insurer_slug'], $ins_ids)){
                $selected=($dval['prev_policy_insurer_slug']==$insurer) ? "selected='selected'":'';
                //$insss=$dval['prev_policy_insurer_slug']."#".$dval['logo'];
            $insStr .="<option value='" .$dval['prev_policy_insurer_slug']."#".$dval['logo']. "' $selected>" . $dval['short_name'] . "</option>";
            }
        }
        $response = array("insData"=>$insData,'compony'=>$insStr,"strCover"=>$strCover,"totpremium"=>$totpremium,'mcoverlist'=>$mcoverlist);
        echo json_encode($response);die;
    }
    public function calInsQuotePremium(){
        $inscat = $this->input->post('catid');
        $ftype = $this->input->post('ftype');
        $pdata=[];
        if(!empty($ftype) && ($ftype=='2')){
            $pdata=$this->input->post();  
            $idv=!empty($pdata['midv']) ? str_replace(',','',$pdata['midv']):0; 
            $mbasic_od_amt=!empty($pdata['mbasic_od_amt']) ? str_replace(',','',$pdata['mbasic_od_amt']):0;
            $mncb_discount=!empty($pdata['mncb_discount']) ? str_replace(',','',$pdata['mncb_discount']):0;
            $mod_discount=!empty($pdata['mod_discount']) ? str_replace(',','',$pdata['mod_discount']):0;
            $mpass_cover=!empty($pdata['mpass_cover']) ? str_replace(',','',$pdata['mpass_cover']):0;
            $mper_acc_cover=!empty($pdata['mper_acc_cover']) ? str_replace(',','',$pdata['mper_acc_cover']):0;
            $mpaid_driver=!empty($pdata['mpaid_driver']) ? str_replace(',','',$pdata['mpaid_driver']):0;
            $maddon_price=!empty($pdata['maddon_price']) ? str_replace(',','',$pdata['maddon_price']):0;
            $melectrical=!empty($pdata['melectrical']) ? str_replace(',','',$pdata['melectrical']):0;
            $mnonelectrical=!empty($pdata['mnonelectrical']) ? str_replace(',','',$pdata['mnonelectrical']):0;
            $add_on_txt=!empty($pdata['maddon_price']) ? str_replace(',','',$pdata['maddon_price']):0;
        }else{
            $pdata=$this->input->post();    
            $zone = $this->input->post('zone_list');
            $od_disc = $this->input->post('od_disc');
            $idv = $this->input->post('idv');
            $per_acc_cover=!empty($pdata['per_acc_cover']) ? str_replace(',','',$pdata['per_acc_cover']):0;
            $paid_driver=!empty($pdata['paid_driver']) ? str_replace(',','',$pdata['paid_driver']):0;
            $pass_cover=!empty($pdata['pass_cover']) ? str_replace(',','',$pdata['pass_cover']):0;
        }
        if(empty($inscat)){
        $inscat = $this->input->post('inscat');
        }
        $is_subtract = 0;
         if(!empty($ftype) &&  ($ftype=='2')){
            if(!empty($pdata['madd_on'])){
                
                foreach($pdata['madd_on'] as $k=>$mv){
                    if($mv == "anti_theft" && count($pdata['madd_on']) == 1){
                        $is_subtract = 1;
                    }else{
                        $is_subtract = 0;
                    } 
                }
            }
         }
        $customerId = $this->input->post('customer_id');  
        $addOnData = $this->input->post();       
        $filterData=$this->Crm_insurance->getFilterQuotesData($customerId,1);
      //  echo "<pre>";print_r($filterData);die;
        $zoneData=$this->Crm_insurance->getZoneCcAge($customerId);
       
        if($inscat=='1'){
            $zoneData[0]['duration'] = !empty($filterData[0]['duration'])?$filterData[0]['duration']:'';
             $zoneData[0]['car_age']='1';
        }
        if(!empty($zone)){
           $zoneData[0]['zone'] =  $zone;
        }
        
        if(!empty($zoneData)){
             $cdata=$this->Crm_insurance->getCalculatePremium($zoneData);
         }
        $finalownDamage=0; 
        $odPremium=0;
        $thirdParty=0;
        $addOns=0;
        $electrical=0;
        $nonelectrical=0;
        $addOn=0;
        $totgst=0;
        if(!empty($addOnData['road_side_assistance']) && ($addOnData['road_side_assistance']=='1')){
        $addOn=(!empty($addOnData['road_side_assistance_txt'])) ? (int)str_replace(',','',$addOnData['road_side_assistance_txt']):'0';
        }
        if(!empty($addOnData['loss_of_personal_belonging']) && ($addOnData['loss_of_personal_belonging']=='1')){
            $addOn+=(!empty($addOnData['loss_of_personal_belonging_txt'])) ? (int)$addOnData['loss_of_personal_belonging_txt']:'0';
        }
        if(!empty($addOnData['emergency_transport_hotel_premium']) && ($addOnData['emergency_transport_hotel_premium']=='1')){
            $addOn+=(!empty($addOnData['emergency_transport_hotel_premium_txt'])) ? (int)$addOnData['emergency_transport_hotel_premium_txt']:'0';
        }
        
        if(!empty($addOnData['anti_theft']) && ($addOnData['anti_theft']=='1')){           
         $addOn= (int)$addOn - (int) str_replace(",","",$addOnData['anti_theft_txt']); 
        }
        if(!empty($cdata)){
            $idv=str_replace(",", "", $idv);
            if($inscat=='1'){
                if(!empty($filterData[0]['duration']) && ($filterData[0]['duration']=='1')){
                 $basicOwnDamage=(int)$idv*($cdata[0]['normal_rate']/100);//basic Own damage   
                }else{    
                $basicOwnDamage=(2.57)*(int)$idv*($cdata[0]['normal_rate']/100);//basic Own damage
                }
            }else{
            $basicOwnDamage=(int)$idv*((float)$cdata[0]['normal_rate']/100);//basic Own damage
            $basicOwnDamage=round($basicOwnDamage);
            }
            if(!empty($ftype) && ($ftype=='2')){
            $basicOwnDamage=(!empty($mbasic_od_amt)) ? str_replace(",","",$mbasic_od_amt):'0';    
            }else{
            $basicOwnDamage=round((int)$basicOwnDamage);
            }
            if(!empty($ftype) && ($ftype=='2')){
            $odDiscount=round((int) $mod_discount);    
            }else{
            $odDiscount=(!empty($od_disc))? (int)$basicOwnDamage*((int)$od_disc/100):0;// own damage discount
            }
            $odDiscount=round($odDiscount);
            if(!empty($ftype) && ($ftype=='2')){
            $electrical=(!empty($melectrical) && ($melectrical!='')) ? str_replace(",","",$melectrical):'0';//eletrical
            }else{
            if(!empty($addOnData['electrical_accessories']) && ($addOnData['electrical_accessories']=='1')){
            $electrical=(int)str_replace(',','',$addOnData['electrical_accessories_txt'])*(4/100);//eletrical
            }
            }
            if(!empty($ftype) && ($ftype=='2')){
            $nonelectrical=(!empty($mnonelectrical) && ($mnonelectrical!='')) ? str_replace(",","",$mnonelectrical):'0';//eletrical    
            }else{
            if(!empty($addOnData['non_electrical_accessories']) && ($addOnData['non_electrical_accessories']=='1')){
            $nonelectrical=(int)str_replace(',','',$addOnData['non_electrical_accessories_txt'])*(4/100);//non electrical
            }
            }
            $ncbtotal=(int)$basicOwnDamage-(int)$odDiscount;
            //$ncb_discount=!empty($addOnData['ncb_discount']) ? $addOnData['ncb_discount']:'0';
            if(!empty($ftype) && ($ftype=='2')){
            $ncbtotal=(!empty($mncb_discount)) ? str_replace(",","",$mncb_discount):'0';//ncb discount    
            }else{
            $ncbtotal=(int)$ncbtotal*((int)$filterData[0]['ncb_discount']/100);//ncb discount
            }
            $ncbtotal=round($ncbtotal);
            $ownDamage=(int)$basicOwnDamage-(int)$odDiscount;
            $subownDamage=(int)$ownDamage+(int)$electrical+(int)$nonelectrical;
            $finalownDamage=(int)$subownDamage-(int)$ncbtotal;
            $finalownDamage=round($finalownDamage);
            if(!empty($ftype) && ($ftype=='2')){
            $basicThirdParty=(int)$cdata[0]['basic_third_party'];//basic third party
            $personalAccCover=(!empty($mper_acc_cover)) ? str_replace(",","",$mper_acc_cover):'0'; // personal accident cover
            $paidDriver=(!empty($mpaid_driver)) ? str_replace(",","",$mpaid_driver):'0'; // paid driver
            $passengerCover=(!empty($mpass_cover)) ? str_replace(",","",$mpass_cover):'0'; // paid driver
            $thirdParty=(int)$basicThirdParty+(int)$personalAccCover+(int)$paidDriver+(int)$passengerCover; // third party   
            }else{
            $basicThirdParty=(int)$cdata[0]['basic_third_party'];//basic third party
            $personalAccCover=(!empty($per_acc_cover)) ? str_replace(",","",$per_acc_cover):'0';; // personal accident cover
            $paidDriver=(!empty($paid_driver)) ? str_replace(",","",$paid_driver):'0';; // paid driver
            $passengerCover=(!empty($pass_cover)) ? str_replace(",","",$pass_cover):'0'; // passenger Cover
            $thirdParty=(int)$basicThirdParty+(int)$personalAccCover+(int)$paidDriver+(int)$passengerCover; // third party    
          // echo $basicThirdParty."++++".$personalAccCover."++++".$paidDriver."+++".$passengerCover;die;
            }
            if(!empty($addOnData['add_on_perc'])){
            $addOn+=round((int)$idv*(float)$addOnData['add_on_perc']/100);
            }
            if(!empty($ftype) && ($ftype=='2')){                
                 $addOn+=round($add_on_txt);
            }else{
            if(!empty($addOnData['add_on_txt'])){
            $addOn+=round(str_replace(',','',$addOnData['add_on_txt']));
            }
            }
            }
            if($filterData[0]['policy_type_customer'] == 3)
                $thirdParty = 0;
            
            if(!empty($ftype) && ($ftype=='2') && $is_subtract == 1){
              $totgst_sum=(int)$finalownDamage+(int)$thirdParty-(int)$addOn;  
            }else{
                $totgst_sum=(int)$finalownDamage+(int)$thirdParty+(int)$addOn;
            }
            $totgst=round((int)$totgst_sum*(18/100));
            $totpremium= round((int)$totgst_sum+(int)$totgst);
            $totpremium=indian_currency_form($totpremium);
            echo $totpremium;exit;
 
    }
    
    public function confirmQuotesave(){
        $data = [];
        $quote_id = $this->input->post('quote_id');
        $qCaseid = $this->Crm_insurance->getQuotesListByQuoteId($quote_id);
        $qu = $this->Crm_insurance->getQuotesList($qCaseid[0]['case_id'],'','1');
        $data[0]['head'] = 'Change Accepted Quote';
        $data[0]['body'] = 'Are you Sure you want to change accepted Quotes? <br/> *Details in subsequent sections will be changed accordingly.';
        if(empty($qu))
        {
            $data[0]['head'] = 'Accept Quote';
            $data[0]['body'] = 'Are you sure you want to accept this Quote? <br/> *You may change accepted quote later.';
        }
       echo json_encode($data);exit;
    }
    public function confirmdeleteQuote(){
        echo renderInsuranceHTMLFinal();exit;
    }
    
    public function confirmUpdateQuotesave(){
       $quote_id = $this->input->post('quote_id');
       $quote_data = $this->Crm_insurance->getCustomerIdByQid($quote_id,1);
       $customerId = $quote_data['customer_id'];
       $quote_date = $quote_data['quote_date'];
       $result='';
       if(!empty($quote_id)){
            $caseData=current($this->Crm_insurance->getCaseDetailsByCustomerId($customerId));
            $left_menu_status = INSURANCE_LEFT_SIDE_MENU['INSURANCE_QUOTES'];
            if($caseData['left_menu_status'] < $left_menu_status){                
               $this->Crm_insurance->updateInsuranceCaseById(array('left_menu_status'=>$left_menu_status,'quote_add_date'=>$quote_date),$caseData['id']);
            }else{
                 $this->Crm_insurance->updateInsuranceCaseById(array('quote_add_date'=>$quote_date),$caseData['id']);  
            }
           $result=$this->Crm_insurance->updateQuoteById($quote_id);
       }
       if(!empty($result)){

        ### update ADDON AND OD amount on update insurance company start Masawwar Ali
        $getInsInfo = $this->Crm_insurance->getCustomerInfo($customerId);
        $caseIdexist = $this->Crm_insurance->fetchData('crm_insurance_payout_details',array('policy_no'),array('case_id'=>$getInsInfo[0]['id'])); 
        if(!empty($caseIdexist) && ($caseIdexist['policy_no']!='')){
            $getInsInfo[0]['payout_policy_no'] = $caseIdexist['policy_no'];
            $this->updateAddonsAndOdamount($getInsInfo);
        }
        ### update ADDON AND OD amount on update insurance company end Masawwar Ali
        $result= array('status'=>'True','Action'=>  base_url().'insFileLogin/' . base64_encode('customerId_' . $customerId));   
        }
        echo json_encode($result);exit;
    }
    public function confirmDeleteQuotesave(){
      $quote_id = $this->input->post('quote_id');
      $customerId = $this->Crm_insurance->getCustomerIdByQid($quote_id);
       $result='';
       if(!empty($quote_id)){
           $result=$this->Crm_insurance->deleteQuoteById($quote_id);
       }
       if(!empty($result)){
        $result= array('status'=>'True','message'=>'Quotes Details Deleted Successfully','Action'=>  base_url().'insFileLogin/' . base64_encode('customerId_' . $customerId));   
        }
        echo json_encode($result);exit;
    }
    
      public function getinspdf(){
        $da = [];
        $customerId = $_POST['orderId'];
       // $this->load->helper('pdf_helper');
        if(!empty($customerId)){

        $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
        if($customerName['zone']!='' && $customerName['car_age']!='' && $customerName['cc']!=''){
            $quotes=$this->Crm_insurance->getInsQuotesByCustomerId($customerId);
        }
        $data['caseData']=current($this->Crm_insurance->getCaseDetailsByCustomerId($customerId));
        $data['insurerList'] = $this->Crm_previous_insurer->getInsurerList();
        $data['quotes'] = $this->Crm_insurance->getQuotesList($data['caseData']['id']);
        $allQuotesDetails= $this->Crm_insurance->getQuotesListByCaseId($data['caseData']['id']);
        $i=0;
        foreach ($allQuotesDetails as $key => $value) {
            $addOn = 0;
            $addOns = [];
            $electrical = '';
            $nonelectrical = '';
            $da[$i]['idv'] =$this->IND_money_format($value['idv']);
            $idv =(int)$value['idv'];
            $od_disc = (int)$value['od_disc_perc'];
            $basicOwnDamage=(int)$value['basic_own_damage'];//basic Own damage
            $odDiscount=$basicOwnDamage*($od_disc/100);// own damage discount
            $quotes['od_discount']=$odDiscount;
                          if($value['electrical_accessories']=='1')
                          {
                            $electrical=$value['electrical_accessories_txt']*(4/100);//eletrical
                            $quotes['electrical']=$electrical;
                          }
                          if($value['non_electrical_accessories']=='1')
                          {
                            $nonelectrical=$value['non_electrical_accessories_txt']*(4/100);//non electrical
                            $quotes['nonelectrical']=$nonelectrical;
                          }
                          //$odPremium=$subtotal-$newsubtotal;
                          $ncbtotal=((int)$basicOwnDamage-(int)$odDiscount);
                          $ncbtotal=(int)$ncbtotal*((int)$value['ncb_discount']/100);//ncb discount
                          $quotes['ncb']=round($ncbtotal);
                          $ownDamage=(int)$basicOwnDamage-(int)$odDiscount;
                          $subownDamage=(int)$ownDamage+(int)$electrical+(int)$nonelectrical;
                          $finalownDamage=(int)$subownDamage-(int)$ncbtotal;
                          $quotes['own_damage']=round($finalownDamage);
                          $third = $value['third_party'];
                          $gsts = $value['gst'];
                          $basicThirdParty=$value['basic_third_party'];//basic third party
                          $quotes['basic_third_party']=(int)$basicThirdParty;
                          /*$personalAccCover=330; // personal accident cover
                          $quotes['personal_acc_cover']=(int)$personalAccCover;
                          $paidDriver=50; // paid driver
                          $quotes['paid_driver']=(int)$paidDriver;*/
                           if($inscat=='1'){
                            $personalAccCover=(int)$value['personal_acc_cover_txt']; // personal accident cover
                            $passengerCover=(int)$value['passenger_cover_txt']; // paid driver
                            $paidDriver=(int)$value['driver_cover_txt']; // paid driver
                            }else{
                            $personalAccCover=(int)$value['personal_acc_cover_txt']; // personal accident cover
                            $passengerCover=(int)$value['passenger_cover_txt']; // paid driver
                            $paidDriver=(int)$value['driver_cover_txt']; // paid driver   
                            }
                          $thirdParty=$basicThirdParty+$personalAccCover+$passengerCover+$paidDriver; // third party
                          $insurer_name_trimmed = $value['short_name'];
                        $da[$i]['ncb_disc'] = $value['ncb_discount'];  
                        $da[$i]['insurer_name_trimmed'] = $value['short_name'];
                        $da[$i]['gsts'] = $this->IND_money_format($gsts);  
                        $da[$i]['third'] = $this->IND_money_format($third);   
                        $da[$i]['thirdParty'] = $this->IND_money_format($thirdParty);     
                        $da[$i]['emailImg'] = base_url('assets/images/inr.png');
                              $final_od = $value['own_damage'];
                        $da[$i]['final_od'] = $this->IND_money_format($final_od);
                          if($value['road_side_assistance']=='1'){
                              $addOn=(int)$value['road_side_assistance_txt'];
                              $addOns['Road Side Assistance']= 'Road Side Assistance';
                          }
                          if($value['invoice_cover']=='1'){
                              //$addOn+=(int)$value['invoice_cover_txt'];
                               $addOns['Invoice Cover']= 'Invoice Cover';
                          }
                          if($value['consumables']=='1'){
                              //$addOn+=(int)$value['consumables_txt'];
                               $addOns['Consumables']= 'Consumables';
                          }
                          if($value['engine_cover_box']=='1'){
                              //$addOn+=(int)$value['engine_cover_box_txt'];
                              $addOns['Engine Gear Box Cover'] = 'Engine Gear Box Cover';
                          }
                          if($value['key_replacement']=='1'){
                              $addOn+=(int)$value['key_replacement_txt'];
                              $addOns['Key Replacement'] = 'Key Replacement';
                          }
                          if($value['ncb_protection_cover']=='1'){
                              $addOn+=(int)$value['ncb_protection_cover_txt'];
                              $addOns['Ncb Protection Cover'] = 'Ncb Protection Cover';
                          }
                          if($value['tyre_secure']=='1'){
                              $addOn+=(int)$value['tyre_secure_txt'];
                              $addOns['Tyre Secure'] = 'Tyre Secure';
                          }
                          if($value['driver_cover']=='1'){
                              //$addOn+=(int)$value['driver_cover_txt'];
                              $addOns['Driver Cover'] = 'Driver Cover';
                          }
                          if($value['personal_acc_cover']=='1'){
                              //$addOn+=(int)$value['personal_acc_cover_txt'];
                              $addOns['Personal Accidental Cover'] = 'Personal Accidental Cover';
                          } 
                          if($value['passenger_cover']=='1'){
                              //$addOn+=(int)$value['passenger_cover_txt'];
                              $addOns['Passenger Cover'] = 'Passenger Cover';
                          } 
                          if($value['electrical_accessories']=='1'){
                                //$addOn+=(int)$value['electrical_accessories_txt'];
                              $addOns['Electrical Accessories'] = 'Electrical Accessories';
                          }
                          if($value['non_electrical_accessories']=='1'){
                              //$addOn+=(int)$value['non_electrical_accessories_txt'];
                              $addOns['Non Electrical Accessories'] = 'Non Electrical Accessories';
                          }
                          if($value['loss_of_personal_belonging']=='1'){
                              $addOn+=(int)$value['loss_of_personal_belonging_txt'];
                              $addOns['Loss Of Personal Belonging'] = 'Loss Of Personal Belonging';
                          }
                          if($value['emergency_transport_hotel_premium']=='1'){
                              $addOn+=(int)$value['emergency_transport_hotel_premium_txt'];
                              $addOns['Emergency Transport Hotel Premium'] = 'Emergency Transport Hotel Premium';
                          }
                          if($value['zero_dep']=='1'){
                              $addOns['Zero Dep'] = 'Zero Dep';
                          }
                          if($value['add_on']){
                             $addOn+=(int)$value['add_on']; 
                          }
                          if(!empty($value['anti_theft']) && ($value['anti_theft']=='1')){           
                            $addOn= (int)$addOn - (int) str_replace(",","",$value['anti_theft_txt']); 
                          }
                          if($value['totpremium']){
                             $totpremium=(int)$value['totpremium']; 
                          }
                          $totgst=$finalownDamage+$thirdParty+$addOn;
                          $totgst=round($totgst*(18/100));
                          $totpremium= round($totpremium);
            $da[$i]['addOn']  = $this->IND_money_format($addOn);     
            $da[$i]['totpremium']   = $this->IND_money_format($totpremium);    // if ($value['logo']) {
            $da[$i]['img']  = "<img src='" . base_url('assets/images/insurerlogo/'.$value['logo']) . "' style='width:60px !important;'>";
            $da[$i]['zeroDap'] = implode(', ',$addOns);
            if($customerName['renew_flag']=='0'){
            $histArr=[];
            $histArr['company_id']=$value['insurance_company'];
            $histArr['customer_id']=$customerId;
            $histArr['created_date']=date('Y-m-d H:i:s');
            $histArr['history_type']='insurance';
            $histArr['source']='quotes';
            $histArr['activity_text']='Quotes Shared';
            $this->saveInsHistory($histArr);
            }
            $i++;
        }
        $data['allQuotesDetails']  = $da;
        // $data['permission']     =  $this->Crm_insurance->getUserRole($userInfo['role_id'],'insFilelogin');
        //$data['coverlist']     =  $this->Crm_insurance->getadditionalCover();
        //$data['filterdata']     =  current($this->Crm_insurance->getFilterQuotesData($customerId));
        //$data['citylist'] = $this->City->getAllCityList();
        $filterdata =  current($this->Crm_insurance->getFilterQuotesData($customerId));
        $customerName['ncb_disc']=!empty($filterdata['ncb_discount']) ? $filterdata['ncb_discount'] :'';
        $model =$this->Make_model->getParentModel($customerName['model']);
        $data['CustomerInfo'] = !empty($customerName)?$customerName:'';
        $data['CustomerInfo']['modelName'] = $model;
        $data['customerId']     = !empty($customerId)?$customerId:'';
        $senderDetail = $this->Crm_user->getAdminDealerDetails(DEALER_ID);
        $data['senderEmail'] = $senderDetail;
        $time=time();
        $day=date('d');
        $month=date('m');
        $monthName=date("F", mktime(0, 0, 0, $month, 10));
        $year=date('Y');
        if($customerName['buyer_type']=='1')
        {
            $cname = $customerName['customer_name'];
        }
        else
        {
            $cname = $customerName['customer_company_name'];
        }
        $customerNameStr=str_replace(" ","_",trim($cname));
        $filename=$customerNameStr.'_Quotes'.$day.$monthName.$year;
        //$filename='QuotesReceipt_'.$customerId.'_'.$time;
        }
        if($customerName['renew_flag']=='1'){
        $caseArr['follow_status']='3';
        $this->Crm_insurance->updateInsuranceCase($caseArr,$customerId);
        $renewdata=[];
        $renewdata['activity']='3';
        $renewdata['case_id']=$data['caseData']['id'];
        $renewdata['user_id']=isset($this->session->userdata['userinfo']['id']) ? $this->session->userdata['userinfo']['id']:'';
        $this->Crm_renew->addUpdateHistory($renewdata);
        }
        $links =  UPLOAD_IMAGE_URL.'deliverydocs/'.$filename.'.pdf';
        $this->renderQuoteShareSms($data,$links);
        $html = $this->load->view('insurance/getpdf', $data, true);
        $this->quotesDocs($html, $filename);
       // pdf_create($html, $filename,'TRUE','1',$data);
      //  return true;
        //write_file('name', $data);

    }

    public function renderQuoteShareSms($data,$link)
    {
        $this->Crm_insurance->getsmsQuotes($data['quotes'][0]['customer_id'],$link);
    }


    public function updateCarDetails()
    {
        $engineno = $this->input->post('engineno');
        $chassisno = $this->input->post('chassisno');
        $customerId = $this->input->post('customer_id');
        $postcaseData['engineNo'] =(!empty($engineno))?ucwords($engineno):'';
        $postcaseData['chasisNo'] = (!empty($chassisno)) ?ucwords($chassisno):'';
              
        $customerId = $this->Crm_insurance->updateInsuranceCase($postcaseData,$customerId);
        return true;
    }
    public function uploadexcel(){
        $this->load->helper('date_helper');
        $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $customerId  = !empty($editId)?end($editId):'';
        $userInfo=$this->session->userdata['userinfo'];
        $data=[];
        $data['pageTitle'] = 'Add New Insurance';
        $data['pageType'] = 'insuranceList';
        $this->loadViews("insurance/importexcel",$data);   
   }
   
   public function uploadinsFile(){
       $caseId  = null;
       $data    = [];
       $rowmsgs = [];
     if(isset($_FILES["uploadfile"]["name"]) && !empty($_FILES["uploadfile"]["name"]) ){
       $fileName=$_FILES["uploadfile"]["name"];
       $ext=explode(".",$fileName);
       if($ext[1]!='xlsx' && $ext[1]!='xls'){
        $rowmsgs[] = 'Please upload valid file';  
       }else{
        $path = $_FILES["uploadfile"]["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);
        foreach($object->getWorksheetIterator() as $worksheet)
        {
         
         $highestRow = $worksheet->getHighestRow();
         $highestColumn = $worksheet->getHighestColumn();
         for($row=2; $row<=$highestRow; $row++)
         {
          
          $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
          if($this->isEmptyRow(reset($rowData))) { 
            $rowmsgs[] = 'data has been processed upto row '.$row;  
              break; }

          $buyerType = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
          $insCategory = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
          $source = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
          $dealer_id = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
          $regNo = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
          $variantId = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
          $engineNo = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
          $chasisNo = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
          $make_month = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
          $make_year = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
          $reg_date = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
          $reg_date = PHPExcel_Style_NumberFormat::toFormattedString($reg_date,PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2) ;
          $zone = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
          $car_age = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
          $cc = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
          $customer_name = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
          $customer_mobile = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
          $customer_email = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
          $customer_address = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
          $customer_city_id = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
          $customer_pincode = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
          $customer_gender = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
          $customer_marital = $worksheet->getCellByColumnAndRow(21, $row)->getValue();
          $current_insurance_company = $worksheet->getCellByColumnAndRow(22, $row)->getValue();
          $current_policy_no = $worksheet->getCellByColumnAndRow(23, $row)->getValue();
          $current_policy_type = $worksheet->getCellByColumnAndRow(24, $row)->getValue();
          $current_issue_date = $worksheet->getCellByColumnAndRow(25, $row)->getValue();
          $current_issue_date = PHPExcel_Style_NumberFormat::toFormattedString($current_issue_date,PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);

          $current_due_date = $worksheet->getCellByColumnAndRow(26, $row)->getValue();

          $current_due_date = PHPExcel_Style_NumberFormat::toFormattedString($current_due_date,PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
          $current_ncb_discount = $worksheet->getCellByColumnAndRow(27, $row)->getValue();
          $totpremium = $worksheet->getCellByColumnAndRow(28, $row)->getValue();
          $idv = $worksheet->getCellByColumnAndRow(29, $row)->getValue();
          $car_city = $worksheet->getCellByColumnAndRow(30, $row)->getValue();
          $errmsg='';
          if($customer_name==''){
              $errmsg='customer name blank at row no '.$row; 
          }
          if($customer_mobile==''){
              $errmsg='customer_mobile blank at row no '.$row;
          }else if(strlen($customer_mobile) > 10 || strlen($customer_mobile) < 10){
              $errmsg='valid Mobile No. at  row no '.$row;
          }else if( ! is_numeric($customer_mobile) ){
              $errmsg='customer mobile should be digit only at row no '.$row;
          }

          // if($customer_email==''){
          //     $errmsg='customer email blank at row no '.$row;
          // }else
           if(!empty($customer_email) && !filter_var($customer_email , FILTER_VALIDATE_EMAIL ) ){
              $errmsg='invalid email address at  row no '.$row;
          }
          // if($customer_city_id==''){
          //     $errmsg='customer city id at row no '.$row;
          // }else 
          if( !empty($customer_city_id) && ! is_numeric($customer_city_id) ){
              $errmsg='city id should be digit only at row no '.$row;
          }
          // if($customer_pincode==''){
          //     $errmsg='customer_pincode blank at row no '.$row;
          // }
          if( !empty($customer_gender) && ! is_numeric($customer_gender) ){
              $errmsg='gender should be digit only at row no '.$row;
          }
          // if($customer_marital==''){
          //     $errmsg='customer gender blank at row no '.$row;
          // }    
          // if($customer_pincode==''){
          //     $errmsg='customer_pincode blank at row no '.$row;
          // }else
          if( !empty($customer_pincode) && preg_match('/^[A-Za-z0-9]*$/', $customer_pincode) == false ){
              $errmsg='customer_pincode should be alphabetic and digit only at row no '.$row;
          }
          // if($customer_gender==''){
          //     $errmsg='Error row no '.$row;
          // }else
          // if( ! is_numeric($customer_gender) ){
          //     $errmsg='gender should be digit only at row no '.$row;
          // }
          // if($customer_marital==''){
          //     $errmsg='customer marital blank at row no '.$row;
          // }else
          if( !empty($customer_marital) && ! is_numeric($customer_marital) ){
              $errmsg='customer_marital should be digit only at row no '.$row;
          }
          if($current_insurance_company==''){
              $errmsg='current insurance company blank at row no '.$row;
          }elseif( ! is_numeric($current_insurance_company) ){
              $errmsg='current_insurance_company id should be digit only at row no '.$row;
          }
          if($current_policy_no==''){
              $errmsg='current policy no at row no '.$row;
          }
          if($current_issue_date==''){
              $errmsg='current_issue_date blank at row no '.$row;
          }
          if($current_due_date==''){
              $errmsg='current due date blank at row no '.$row;
          }elseif( !empty($current_due_date) && preg_match("/^20[0-9]{2}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$current_due_date) == false)
            $errmsg='current_due_date format not valid i.e. YYYY-mm-dd at row no '.$row;

          // if($current_ncb_discount==''){
          //     $errmsg='current ncb discount blank at row no '.$row;
          // }
          if($buyerType==''){
              $errmsg='Error row no '.$row;
          }
          if($insCategory==''){
              $errmsg='buyerType blank at row no '.$row;
          }if( ! is_numeric($insCategory) ){
              $errmsg='ins category should be digit only at row no '.$row;
          }
          if($source==''){
              $errmsg='source blank at row no '.$row;
          }
          
          if( $source == 'dealer' && !empty($dealer_id) && ! is_numeric($dealer_id) ){
              $errmsg='dealer id should be digit only at row no '.$row;
          }
          if($regNo==''){
              $errmsg='regNo blank at row no '.$row;
          }
          if($variantId==''){
              $errmsg='variantId blank at row no '.$row;
          }elseif( ! is_numeric($variantId) ){
              $errmsg='variantId should be digit only at row no '.$row;
          }
          // if($engineNo==''){
          //     $errmsg='engineNo blank at row no '.$row;
          // }
          // if($chasisNo==''){
          //     $errmsg='chasisNo balnk at row no '.$row;
          // }
          // if($make_month==''){
          //     $errmsg='make month blank at row no '.$row;
          // }else
          if( !empty($make_month) && ! is_numeric($make_month) ){
              $errmsg='make_month should be digit only at row no '.$row;
          }
          // if($make_year==''){
          //     $errmsg='make year blank at row no '.$row;
          // }else
          if( !empty($make_year) && ! is_numeric($make_year) ){
              $errmsg='make_year should be digit only at row no '.$row;
          }

          // if($reg_date==''){
          //     $errmsg='reg_date balnk at row no '.$row;
          // }else

          if ( !empty($reg_date) && preg_match("/^20[0-9]{2}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$reg_date) == false)
            $errmsg='reg date format not valid i.e. YYYY-mm-dd at row no '.$row;

          // if($totpremium==''){
          //     $errmsg='totpremium blank at row no '.$row;
          // }else
          if( !empty($totpremium) &&  ! is_numeric($totpremium) ){
              $errmsg='totpremium should be digit only at row no '.$row;
          }

          if($current_policy_type==''){
              $errmsg='current_policy_type blank at row no '.$row;
          }elseif( ! is_numeric($current_policy_type) ){
              $errmsg='current_policy_type should be digit only at row no '.$row;
          }  
          $engineNo = empty($engineNo)? null : $engineNo;
          $chasisNo = empty($chasisNo)? null : $chasisNo;
            // echo preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$reg_date,$matches) ."$reg_date ww<br>";
            // print_r($matches)."<br>";
          // echo $reg_date , " || $current_issue_date || $current_due_date" ."<br>";  
          // echo $reg_date ."<br>";  
          // if($zone==''){
          //     $errmsg='zone balnk at row no '.$row;
          // }else
          if( !empty($zone) && preg_match("/^[0-9]+$/",$zone) == false){
              $errmsg='zone can be digit only at row no '.$row;
          }
          // if($car_age==''){
          //     $errmsg='car age blank at row no '.$row;
          // }else
          if( !empty($car_age) && ! is_numeric($car_age) ){
              $errmsg='car age should be digit only at row no '.$row;
          }
           
          // if($cc==''){
          //     $errmsg='cc blank at row no '.$row;
          // }else
          if( !empty($cc) && ! is_numeric($cc) ){
              $errmsg='cc should be digit only at row no '.$row;
          }
          if($errmsg!=''){
              $rowmsgs[] = $errmsg;  
              continue;
          }
          $isExist=$this->Crm_insurance->checkduplicateCase($engineNo,$chasisNo);
          try {


              if($isExist==false){
                $customerLeadId=$this->Crm_insurance->getcustomerLeadId($customer_mobile);
                $customerPersInfo=[];
                $customerPersInfo['customer_name']=$customer_name;
                $customerPersInfo['created_on']=date('Y-m-d H:i:s');
                $customerPersInfo['created_by_module']='Insurance';
                $customerPersInfo['last_updated_by_module']='Insurance';
                
                if(!empty($customerLeadId)){
                    $leadCustomerId=$customerLeadId['leadId'];
                    $customerLeadId=$this->Crm_insurance->getcustomerDetailsByLeadId($leadCustomerId);
                    if(empty($customerLeadId)){
                        $customerPersInfo['customer_id']=$leadCustomerId;
                        $customerLeadddId=$this->Crm_insurance->addNewPersonalCustomer($customerPersInfo);
                       $cLeadId=$customerLeadId['leadId'];
                    }else{
                        $cLeadId=$customerLeadId['leadId'];
                    }
                    $cLeadId=$customerLeadId['leadId'];
                }else{
                    $newLead['mobile']=$customer_mobile;
                    $leadCustomerId=$this->Crm_insurance->addNewleadCustomer($newLead);
                    $customerPersInfo['customer_id']=$leadCustomerId;
                    $personalId=$this->Crm_insurance->addNewPersonalCustomer($customerPersInfo);
                    $cLeadId=(!empty($leadCustomerId)) ? $leadCustomerId : '';
                }
                $customer_names= ($buyerType=='1') ? $customer_name:'';
                $customer_company_name= ($buyerType=='2') ? $customer_name : '';
                if($variantId){
                $mmv=current($this->Crm_insurance->getmakemodelByversionId($variantId));
                // echo "<pre>"; print_r($mmv);die;
                $make_id=$mmv['make_id'];
                $model_id=$mmv['model_id'];
                }
                
                  $customerdata = array(
                     'buyer_type'  => $buyerType, 
                     'customer_name' => $customer_names,
                     'customer_company_name' => $customer_company_name,
                     'crm_customer_id' => $cLeadId,
                     'customer_email' => (!empty($customer_email) ? $customer_email : '' ),
                     'customer_city_id' => $customer_city_id,
                     'customer_address' => $customer_address, 
                     'customer_pincode' => (!empty($customer_pincode) ? $customer_pincode : '' ) ,
                     'customer_gender' => (!empty($customer_gender) ? $customer_gender : '' ),
                     'customer_marital' => (!empty($customer_marital) ? $customer_marital : '' ),
                     'current_policy_no' => $current_policy_no,
                     'current_policy_type' => $current_policy_type,
                     'current_issue_date' => $current_issue_date,
                     'current_due_date' => $current_due_date,
                     'current_ncb_discount' => (!empty($current_ncb_discount) ? $current_ncb_discount : '' ),
                     'created_date' => date('Y-m-d H:i:s')     
                      );
                  $customerId=$this->Crm_insurance->addInsuranceCustomer($customerdata);
                 
                  $casedata = array(
                   'customer_id' => $customerId,
                   'ins_category'   => $insCategory,
                   'source'    => $source,
                   'dealer_id'  => (!empty($dealer_id) ? $dealer_id : '') ,
                   'regNo'   => $regNo,
                   'make' =>  $make_id,
                   'model' =>  $model_id,   
                   'variantId' =>  $variantId,
                   'engineNo' =>   (!empty($engineNo) ? $engineNo : '' ) ,
                   'chasisNo'   => (!empty($chasisNo) ? $chasisNo : '' ),
                   'car_city' => (!empty($car_city) ? $car_city : '' ),
                   'make_month' => (!empty($make_month) ? $make_month : '' ),
                   'make_year' => (!empty($make_year) ? $make_year : '' ),
                   'reg_date' => (!empty($reg_date) ? $reg_date : '' ),
                   'zone' => (!empty($zone) ? $zone : '' ),
                   'car_age' => (!empty($car_age) ? $car_age : '' ) ,
                   'cc' => (!empty($cc) ? $cc : '' ),
                   'last_updated_status' => '1',   
                   'created_date' => date('Y-m-d H:i:s'),
                   'last_updated_date' => date('Y-m-d H:i:s')   
                  );         
                  $this->db->insert('crm_insurance_case_details', $casedata);
                  $caseId= $this->db->insert_id();
                   $stockdata = array(
                   'reg_no'   => $regNo,
                   'make_id' =>  $make_id,
                   'model_id' =>  $model_id,   
                   'version_id' =>  $variantId,
                   'engine_no' =>   (!empty($engineNo) ? $engineNo : '' ) ,
                   'chassis_no'   => (!empty($chasisNo) ? $chasisNo : '' ),
                   'insurance_case_id' => $caseId,
                   'mm' => (!empty($make_month) ? $make_month : '' ),
                   'myear' => (!empty($make_year) ? $make_year : '' ),
                   'loan_for' => (!empty($insCategory) ? $insCategory : '' ),
                   'insurance_customer_id' => $customerId,
                   'insurance_expire' => date('Y-m-d',strtotime($current_due_date))   
                  );
                  $stk = $this->crmCentralStockData($stockdata,'Insurance');
                  $logo='logo_'.$current_insurance_company.'.png';
                  $addOndata = array(
                   'case_id' => $caseId, 
                   'customer_id' => $customerId,
                   'idv' => (!empty($idv) ? $idv : '' ),
                   'insurance_company'   => $current_insurance_company,
                   'totpremium' => (!empty($totpremium) ? $totpremium : '' ),
                   'logo' =>   $logo,
                   'is_latest' => '1',
                   'flag'    => '1',
                   'added_on'  => date('Y-m-d H:i:s')
                   );
                  $quoteId=$this->db->insert('crm_insurance_quotes', $addOndata);
                  $filterdata = array(
                   'customer_id' => $customerId,
                   'ncb_discount'   => (!empty($current_ncb_discount) ? $current_ncb_discount : '' ),
                   'status'    => '1'
                   );
                  $this->db->insert('crm_insurance_quotes_filter', $filterdata);
             }else{
                 $errmsg = "Data already exist with engine and chasis no at row no ".$row;
             }
             
         } catch (Exception $e) {
             $errmsg = "Internal error occurred while saving data at row ". $row;
         }
         if($errmsg!=''){
              $rowmsgs[] = $errmsg;  
              continue;
          }
         }
        }
        if( empty($rowmsgs) && $caseId > 0){
            $data['rowmsgs_success'] = "Data Imported Successfully";
        }elseif(!empty($rowmsgs)){
            $errors = implode('<br>', $rowmsgs);
            $data['rowmsgs_error'] = $errors;
        }
       
       }
      }
       $this->loadViews("insurance/importexcel",$data);
   }
    public function filterAddon($addOns){
      $data=[];
        if(!empty($addOns)){            
              foreach($addOns as $key=>$val){
                if($val == 1){
                  $data[]=$key;
                }
           }
        }        
        return $data;
    }
    public function getInsuList()
    {
        $str = '';
        $insurerList = $this->Crm_previous_insurer->getInsurerList();
        $str  = "<option value=''>Select Company</option>";
        foreach ($insurerList as $dkey => $dval) 
        {
            $str .="<option value='" .$dval['prev_policy_insurer_slug']."'>" . $dval['short_name'] . "</option>";
        }
        echo $str; exit;
    }

    public function getPartPaymentForm()
    {   
        $this->load->helper('range_helper');
        $params = $this->input->post();
        $userInfo  = $this->session->userdata['userinfo'];
        $dealer_id =  DEALER_ID;
        $customerId = !empty($params['customerId'])? $params['customerId'] : null ;
        $customerPartPayments = $this->Crm_insurance_part_payment->getCustomerPartPayment($customerId);
        // print_r($customerId);die;
        $PaymentDetails = $this->Crm_insurance_part_payment->getCustomerPaymentDetails($customerId);
        $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
        $customerName['customerPartPayments'] = $customerPartPayments; 
        $customerName['PartPaymentDetails']   =  $PaymentDetails;
        $data['CustomerInfo'] = !empty($customerName)?$customerName:'';
        $data['change_mode']  =  ($params['mode']=='edit') ? 'edit' : 'add';
        if($data['change_mode']=='edit' && !empty($params['partpaymentid'])){
            $CurrentPartPaymentDetails = $this->Crm_insurance_part_payment->getCustomerPartPayment($customerId,$params['partpaymentid']);    
            $data['CurrentPartPaymentDetails']  = current($CurrentPartPaymentDetails);
        }
        $data['CurrentPartPaymentDetails'][0]['amount']  = $this->IND_money_format($data['CurrentPartPaymentDetails'][0]['amount']);
        $data['is_inhouse']     = ( !empty($customerName['customerPartPayments']['2']) ) ? 'inhse' : '';
        $data['entrytype']      = !empty($params['entrytype'])? $params['entrytype'] : null ;
        $payAmt=!empty($customerName['amount']) ? $customerName['amount']:'';
        $customerName['amount'] = indian_currency_form($payAmt);
        $data['payreason']      = $this->Crm_insurance->getPayReason('1');
        $data['paysisreason']   = $this->Crm_insurance->getPayReason('2');
        $data['permission']     = $this->Crm_insurance->getUserRole($userInfo['role_id'],'inspaymentDetail');
        $bankName               = $this->getcustomerBankList();
        $data['banklist']       = $bankName;
        $quoteData = current($this->Crm_insurance->getAcceptedQuote($customerId));
        $data['totpremium']=(!empty($quoteData['totpremium'])) ? indian_currency_form($quoteData['totpremium']):0;
        $data['customerId']     = !empty($customerId)?$customerId:'';
        $data['partpaymentid']  = !empty($params['partpaymentid'])?$params['partpaymentid']:null;
        $data['siscomp']        = $this->Crm_insurance->getsiscompFlag($dealer_id);
        $data['pageTitle']      = ($mode == 'edit')?  'Edit New Insurance' : 'Add New Insurance';
        $data['pageType'] = 'insurance';
        $data['favouring'] = !empty($customerName['current_accepted_company'])? $customerName['current_accepted_company'] : '' ;
        if(!empty($params['entrytype']) && $params['entrytype']=='4')
        echo $this->load->view('insurance/payment_clearance_form',$data,true);
        else echo $this->load->view('insurance/part_payment_form',$data,true);
        die;
     }

    public function completePayment()
    {
        $customerId = $this->input->post('customerId');
        $flag = $this->input->post('flag');
        $customerName = current($this->Crm_insurance->getCustomerInfo($customerId));
        $current_policy_no = !empty($customerName['current_policy_no'])?$customerName['current_policy_no']:"";
        if(empty($flag)){
        $data = ['is_payment_completed' => '1'];
        }else
        {
            $data = ['is_payment_completed' => '0']; 
        }
        $PaymentCompleted = $this->Crm_insurance_part_payment->completePayment($data,$customerId,$current_policy_no);
        $this->load->model('Crm_renew');
        $IsPaymentCompleted = $this->Crm_renew->IsPaymentCompleted($customerId);
          if(!empty($IsPaymentCompleted) && $IsPaymentCompleted['isInhouseCase']==true){
            $renewcaseArr=[];
            $renewcaseArr['follow_status']=$IsPaymentCompleted['follow_status'];
            $this->Crm_insurance->updateInsuranceCase($renewcaseArr,$customerId);
            $data['caseData']=current($this->Crm_insurance->getCaseDetailsByCustomerId($customerId));
            $renewdata=[];
            $renewdata['activity']=$IsPaymentCompleted['follow_status'];
            $renewdata['case_id']=$data['caseData']['id'];
            $renewdata['user_id']=isset($this->session->userdata['userinfo']['id']) ? $this->session->userdata['userinfo']['id']:'';
            $this->Crm_renew->addUpdateHistory($renewdata);
           }
        echo $PaymentCompleted? 1 : 0 ; die;
    }

    public function migration()
    {
        $customerName = $this->Crm_insurance->getCustomerInfoMigrartion();
        # code...
        $customerName['id'] = $customerName['cust_id'];
        // die($customerId);


        foreach ($customerName as $key => $customer) {
        // echo "<pre>"; print_r($customer); die;

                   if(!empty($customer['payment_by']) && (empty($customer['cpayment_by']) && ($customer['payment_by']!='2'))){
                     $entrytype = 1;
                     $postcaseData = array(
                    'payment_by' =>  (  $customer['payment_by'] ),
                    'payment_date' =>  ( $customer['payment_date'] ),
                    'payment_mode' =>  ( $customer['payment_mode'] ),
                    'favouring_to' =>  ( $customer['favouring_to'] ),
                    'amount' =>  ( $customer['amount'] ),
                    'subvention_amt' =>  ( $customer['subvention_amt'] ),
                    'cheque_no' =>  ( $customer['cheque_no'] ),
                    'instrument_no' =>  (  $customer['instrument_no'] ),
                    'instrument_date' =>  ( $customer['instrument_date'] ),
                    'bank_name' =>  ( $customer['bank_name'] ),
                    'drawn_on' =>  ( $customer['drawn_on'] ),
                    'transaction_id' =>  ( $customer['transaction_id'] ),
                    'reasonId' =>  ( $customer['reasonId'] ),
                    'entry_type'  => $entrytype,
                    'pay_remark'  =>  (  $customer['pay_remark'] ),
                    'customer_id' => $customer['cust_id']
                    );
                    $this->db->insert( 'crm_insurance_part_payment' , $postcaseData);

                }

                if(  !empty($customer['in_payment_mode'])  ){
                    $entrytype = 2 ;
                    $postcaseData = array(
                    'payment_by' =>  (  $customer['payment_by'] ),
                    'payment_date' =>  ( $customer['in_payment_date'] ),
                    'payment_mode' =>  ( $customer['in_payment_mode'] ),
                    'favouring_to' =>  ( $customer['in_favouring_to'] ),
                    'amount' =>  ( $customer['in_amount'] ),
                    'subvention_amt' =>  ( $customer['in_subvention_amt'] ),
                    'cheque_no' =>  ( $customer['in_cheque_no'] ),
                    'instrument_no' =>  (  $customer['in_instrument_no'] ),
                    'instrument_date' =>  ( $customer['in_instrument_date'] ),
                    'bank_name' =>  ( $customer['in_bank_name'] ),
                    'drawn_on' =>  ( $customer['in_drawn_on'] ),
                    'transaction_id' =>  ( $customer['in_transaction_id'] ),
                    'reasonId' =>  ( $customer['reasonId'] ),
                    'entry_type'  => $entrytype,
                    'pay_remark'  =>  (  $customer['pay_in_remark'] ),
                    'customer_id' => $customer['cust_id']

                    );
                    $this->db->insert( 'crm_insurance_part_payment' , $postcaseData);
                }
              if( !empty( $customer['cpayment_by'] )  ){
                $entrytype = 4;
                  $postcaseData = array(
                'payment_by' =>  (  $customer['cpayment_by'] ),
                'payment_date' =>  ( $customer['payment_date'] ),
                'payment_mode' =>  ( $customer['payment_mode'] ),
                'favouring_to' =>  ( $customer['favouring_to'] ),
                'amount' =>  ( $customer['amount'] ),
                'subvention_amt' =>  ( $customer['subvention_amt'] ),
                'cheque_no' =>  ( $customer['cheque_no'] ),
                'instrument_no' =>  (  $customer['instrument_no'] ),
                'instrument_date' =>  ( $customer['instrument_date'] ),
                'bank_name' =>  ( $customer['bank_name'] ),
                'drawn_on' =>  ( $customer['drawn_on'] ),
                'transaction_id' =>  ( $customer['transaction_id'] ),
                'reasonId' =>  ( $customer['reasonId'] ),
                'entry_type'  => $entrytype,
                'pay_remark'  =>  (  $customer['pay_remark'] ),
                'customer_id' => $customer['cust_id']

                );
                $this->db->insert( 'crm_insurance_part_payment' , $postcaseData);
              }
        }


    }

    public function getTotalPay()
    {
        $customerId = $this->input->post('customer_id');
        $id = $this->input->post('id');
        $flag = $this->input->post('flag');
        if($flag == ''){
            $PaymentDetails = $this->Crm_insurance_part_payment->getCustomerPaymentDetails($customerId,$id);
            $result = $PaymentDetails[0]['total_amount_paid'];
        }
else
{
    $clearance = $this->Crm_insurance_part_payment->getPaidAmountbyType($customerId,$id,'4');
    $inhouse = $this->Crm_insurance_part_payment->getPaidAmountbyType($customerId,'','2');
    $result = (int)$inhouse[0]['paid_amt_type'] - (int)$clearance[0]['paid_amt_type'];
}
      echo  $result;
        exit;
    }
    
    
     public function changesStatus()
    {
        $customerId = $this->input->post('customerId');
        $flag = $this->input->post('flag');
        if(!empty($flag)){
             $data = ['is_payment_completed' => $flag];
        }else
        {
            $data = ['is_payment_completed' => '0']; 
        }
         $isPaymentCompleted = $this->Crm_insurance_part_payment->changesStatus($data,$customerId);
         $result= array('status'=>'True','message'=>'status updated Successfully','Action'=>  base_url().'insPolicyDetails/' . base64_encode('customerId_' . $customerId));   
         echo json_encode($result); die;
    }

    public function insurancePayout(){
        $page                  =   1;
        $limit                 =   10;
        $data=[];
        $roleType=array('Executive');
        //print_r($customerName);
        $data['lead_status'] = $this->Crm_insurance_customer_status->getCustomerStatus();
        $data['employeeList'] =  $this->Crm_user->getEmployee('3','',$roleType);
        //$data['insId']        = (!empty($insId)) ? $insId:'';
        $userId=$this->session->userdata['userinfo']['id'];
        $userInfo=$this->session->userdata['userinfo'];
        $dealer_id=!empty($userInfo['dealer_id']) ? $userInfo['dealer_id'] : '';
        // $insdashId=$this->uri->segment(2);
        $datapost              =   $this->input->post();
        
        
        if(isset($datapost['data']) && trim($datapost['data']) != ''){
            $data              = str_replace('amp;', '', $datapost['data']);
            parse_str($data,$postdata);
            unset($datapost['data']);

            if(isset($postdata['source']) && trim($postdata['source']) != ''){
                $source = intval($postdata['source']);
            }

            foreach($postdata as $key => $val){
              $datapost[$key]    =   $val;
            }
            
            $page                   = $postdata['page'];
            $datapost['page']=$page;
            $is_search              = 1;
        }
        /*if(isset($insdashId) && ($insdashId!='')){
            $datapost['insdashId']=$insdashId;
        }*/
        if(isset($userId) && ($userId!='')){
        $datapost['userId']=$userId;
        }
        $whereStatus = 1;
        $getLeads= $this->Crm_insurance->getInsurance($datapost,$dealerId,$userId,1,$whereStatus);
        $leadTabCounts=count($this->Crm_insurance->getInsleadsQuery($datapost,'','','',$whereStatus));
        echo $leadTabCounts;
        die();
        echo $this->db->last_query();
        exit;
        $data['lead_status'] = $this->Crm_insurance_customer_status->getCustomerStatus();
        $data['dealer_info']=$this->Crm_user->getAdminDealerDetails($dealer_id);
        $data['query']=$getLeads;
        $data['leadtabCount']=$leadTabCounts;
        $data['limit'] =(!empty($limit)) ? $limit :0;
        $data['page'] =(!empty($page)) ? $page :1;
        // $data['insId']=(!empty($insdashId)) ? $insdashId :'';
        $data['pageTitle'] = 'Insurance Enquiry';
        $data['pageType'] = 'insuranceList';
        //echo "<pre>"; print_r($data['query']['leads']);die;
        if ( isset($datapost['export']) && !empty($datapost['export']) ) {
        $filename = 'Insurance_Cases_'.date('dM').'.xls';
        //echo "<pre>"; print_r($data['query']['leads']);die;
        exportInsData($data['query']['leads'],$filename,$data['dealer_info'][0]);
        }
       // echo "<prE>";print_r($data);die;
        $this->loadViews("insurance/payoutListing",$data);
    }

    public function updateAddonsAndOdamount($getInsInfo){
                        $addOn = 0;
                        $od_amount = 0;
                        $percentage = 0;
                        $payoutPSPercentage = 0;
                        if(($getInsInfo[0]['source_id']==1) || ($getInsInfo[0]['source_id']==0)){
                         $payoutPercentage = $getInsInfo[0]['new_ins_company'];
                       $payoutPercentage  = $this->Crm_insurance->fetchData('crm_insurance_company_percentage',array('payout_percentage'),array('ref_id'=>$getInsInfo[0]['new_ins_company']),array('type'=>'1'));
                        }else{
                         $payoutPercentage  = $this->Crm_insurance->fetchData('crm_insurance_company_percentage',array('payout_percentage'),array('ref_id'=>$getInsInfo[0]['source_id']),array('type'=>'2'));

                        }
                    $payoutPSPercentage = $payoutPercentage['payout_percentage'];

                        $od_amount = $getInsInfo[0]['own_damage'];
                        
                        if ($getInsInfo[0]['road_side_assistance'] == '1') {
                            $addOn = (int) $getInsInfo[0]['road_side_assistance_txt'];
                        }
                        if ($getInsInfo[0]['loss_of_personal_belonging'] == '1') {
                            $addOn += (int) $getInsInfo[0]['loss_of_personal_belonging_txt'];
                        }
                        if ($getInsInfo[0]['emergency_transport_hotel_premium'] == '1') {
                            $addOn += (int) $getInsInfo[0]['emergency_transport_hotel_premium_txt'];
                        }

                        if ($getInsInfo[0]['driver_cover'] == '1') {
                            $driver_cover = (int) $getInsInfo[0]['paid_driver'];
                        }
                        if ($getInsInfo[0]['personal_acc_cover'] == '1') {
                            $personal_acc_cover = (int) $getInsInfo[0]['personal_acc_cover'];
                        }
                        if ($getInsInfo[0]['passenger_cover'] == '1') {
                            $passenger_cover = $getInsInfo[0]['pass_cover'];
                        }
                        if ($getInsInfo[0]['anti_theft'] == '1') {
                            $addOn -= $getInsInfo[0]['anti_theft_txt'];
                        }
                        if ($getInsInfo[0]['add_on']) {
                            $addOn += $getInsInfo[0]['add_on'];
                        }

             $ownDamageAmount = !empty($getInsInfo[0]['own_damage'])?$getInsInfo[0]['own_damage']:0;
             $addOn = !empty($addOn)?$addOn:0;
             $payoutPSPercentage = !empty($payoutPSPercentage)?$payoutPSPercentage:0;
             $totalPayoutAmount  = round((($addOn + $ownDamageAmount)*$payoutPSPercentage)/100);   
            $payoutDataArray = array(
                                     'payout_amount'    => $totalPayoutAmount,
                                     'percentage'       => $payoutPSPercentage,
                                     'addon_amount'     => $addOn,
                                     'own_damage'       => $ownDamageAmount,
                                    );
            $this->db->where('policy_no', trim($getInsInfo[0]['payout_policy_no']));
            $this->db->update('crm_insurance_payout_details', $payoutDataArray);
                ########   save payout related details  ends  by Masawwar Ali###########
    }
     public function quotesDocs($html,$filename)
    {    
        $filename = $filename.'.pdf';
        require_once(APPPATH . "third_party/dompdf/dompdf_config.inc.php");
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $output = $dompdf->output();
        $upload_folder=UPLOAD_IMAGE_PATH_LOCAL.'deliverydocs/';
        is_dir($upload_folder) || mkdir($upload_folder, 0777, true);
        file_put_contents($upload_folder . $filename, $output);
        echo json_encode(['file_name' => $filename,'type'=>strtolower($type),'status'=>true,'message'=>'File Downloaded Successfully']);
        exit;
    }

    public function downloadInsurance()
    {
        $file_name = $_GET['file'];
        $file_path  =UPLOAD_IMAGE_PATH_LOCAL.'deliverydocs/'.$file_name;
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        flush(); // Flush system output buffer
        readfile($file_path);
        exit;
    }
}



 
