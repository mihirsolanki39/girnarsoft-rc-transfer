<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PayoutInsurance extends MY_Controller {    
    public function __construct() {
        parent::__construct();
        $this->load->model('Crm_insurance');
        $this->load->model('Crm_insurance_part_payment');
        $this->load->model('Crm_user');
        $this->load->model('Crm_dealers');
        $this->load->library('form_validation');
        $this->load->model('Crm_insurance_customer_status');
        $this->load->model('Crm_insurance_company');
        $this->load->model('Insurance_payout');
        $this->load->model('Crm_banks');
        $this->load->helper('range_helper');
        $this->load->library('excel');
        $this->load->helper('exportinsdata');
        if (!$this->session->userdata['userinfo']['id']){
            return redirect('login');
        }
    }
    public function addPayoutHistoryUpdateLog($payout_id,$updated_data,$action)
    {
        $data = [];
        $data['payout_id'] = $payout_id;
        $data['updated_data'] = serialize($updated_data);
        $data['action'] = $action;
        $this->Insurance_payout->addPayoutHistoryUpdateLog($data);
    }
    
    public function financeUserMgmt($id= '' ,$module='')
    {
        $role_id = $this->session->userdata['userinfo']['role_id'];
        $role = $this->Crm_user->getRightsByRole($role_id,$module);
        if($role_id>0){
            $role['role_name'] = !empty($role[0]['role_name']) ? $role[0]['role_name'] :'';
            $role['role_id'] = $role_id;
        }
        else{
            $role[0]['role_name'] = 'admin';
            $role[0]['team_name'] = '';
            $role[0]['edit_permission'] = '1';
            $role[0]['add_permission'] = '1';
            $role[0]['view_permission'] = '1';
        }
        return $role;
    }
    public function insurancePayout($type="",$id=null)
    {
        $editId  = !empty($id)? explode('_',base64_decode($id)):'';
        $pay_id  = !empty($editId)?end($editId):'';
        $data['pageTitle']      = 'Insurance Payout Management';
        $data['type'] = $type;
        $data['type_id'] = $pay_id;
        $this->loadViews("insurancePayout/payout",$data); 
    }
    
     public function insurancePayoutOthers($type = ""){
            $data['pageTitle']      = 'Insurance Payout From Companies';
            $data['employeeList']   =  $this->Crm_user->getEmployee('3');
            $data['source_percentage'] = $this->Insurance_payout->getData('crm_insurance_company_percentage',array('payout_percentage as name','ref_id as id'),array('type'=>'2'));
            ###########  search code start here ##################
            $postData = $this->input->post();
            $ajaxSearch     =  trim($this->input->post('source'));
            $pages          = trim($this->input->post('page'));
            $data['limit']  =   10;
            $loanId = $caseInfoAll = [];
            //$params = array();
            $params['keyword']          = trim($this->input->post('keyword'));
            $params['ins_category']     = trim($this->input->post('ins_category'));
            $params['searchby']         = trim($this->input->post('searchby'));
            $params['ins_policy']       = trim($this->input->post('ins_policy'));
            $params['dealtby']          = trim($this->input->post('dealtby'));
            $params['ins_status']       = trim($this->input->post('ins_status'));

            if(!empty($this->input->post('searchdate'))){
              $params['searchdate']       = trim($this->input->post('searchdate'));
              $params['createStartDate']  = trim($this->input->post('createStartDate'));
              $params['createEndDate']    = trim($this->input->post('createEndDate'));
            }
            else{                
              $params['searchdate']       = trim('issuedate');
              $fullDate = date_parse_from_format("Y/m/d", dateStart);
              $month_from_constant   = $fullDate["month"];
              $current_month         =  date('m');
              if(empty($postData)){
              if($month_from_constant == $current_month && date('d/m/Y',strtotime(dateStart)) <= date('d/m/Y')){
                  $constantStartdate = date('d/m/Y',strtotime(dateStart));
                  $params['createStartDate']  = $constantStartdate;
                  $params['createEndDate']    = date('d/m/Y'); 
              }else { 
                  if($type != 3){
                        $prevmonthFistDate = date("d/m/Y", strtotime("first day of previous month"));
                        if($prevmonthFistDate < date('d/m/Y',strtotime(dateStart))){
                           $params['createStartDate'] = date('d/m/Y',strtotime(dateStart)); 
                        }else {
                           $params['createStartDate'] = date("d/m/Y", strtotime("first day of previous month")); 
                        }
                        $params['createEndDate']   = date("d/m/Y", strtotime("last day of previous month"));
                  }else{
                      $params['createEndDate']    = date('d/m/Y'); 
                      $params['createStartDate'] = date("d/m/Y", strtotime( date( 'Y-m-01' )." -6 months"));
                      if( date('d/m/Y',strtotime(dateStart)) > $params['createStartDate']){
                        $params['createStartDate'] =    date('d/m/Y',strtotime(dateStart)); 
                      }
                  }
              }
            }
            }
          //  echo "<prE>";print_R($params);die;
            $params['keywordbyd']       = trim($this->input->post('keywordbyd'));
            $params['keywordbyIns']     = trim($this->input->post('keywordbyIns'));
            $params['keywordsl']        = trim($this->input->post('keywordsl'));
            $params['payout_status_new']= trim($this->input->post('payout_status'));
            $params['is_count']         = 0;
            
            $params['pages']= $pages;
            $params['user_id']= $this->session->userdata['userinfo']['id'];        
            $params['role_name']= $this->session->userdata['userinfo']['role_name'];
            $params['is_count']= 0;
            $caseInfo   =  $this->Insurance_payout->getPayoutAllOthersCaseInfo($params);
            
            $params['is_count']= 1;
            $caseInfoCount  =  $this->Insurance_payout->getPayoutAllOthersCaseInfo($params);
            $data['page'] =(!empty($pages)) ? $pages :1;
            $data['insurance_listing'] = $caseInfo;
            $data['insurance_list_id'] = $loanId;
            $data['total_count']  = $caseInfoCount;
            $data['createStartDate'] = $params['createStartDate']; 
            $data['createEndDate']   = $params['createEndDate']; 
             ###########  search code  ends here ##################
           if(empty($ajaxSearch)){
               $this->loadViews("insurancePayoutOthers/payout",$data); 
           }else{
               echo $datas=$this->load->view('insurancePayoutOthers/ajax_insurancePayoutOthers',$data,true); exit; 
           }         
     }
    
    
    public function ajax_PayoutList($type =null)
    {
        $roleType=array('Executive','Lead');
        $data['employeeList'] =  $this->Crm_user->getEmployee('3','',$roleType);       
        error_reporting(0);
        $datapost = $this->input->post();  
       
        $tab =  trim($this->input->post('source'));
        $data['source'] = $tab;
        $pages          = trim($this->input->post('page'));
        $data['limit']  =   10;
        if($tab != 2){             
            $loanId = $caseInfoAll = [];
            $params = array();
            $params['keyword']= trim($this->input->post('keyword'));
            $params['ins_category']= trim($this->input->post('ins_category'));
            $params['searchby']= trim($this->input->post('searchby'));
            $params['ins_policy']=  trim($this->input->post('ins_policy'));
            $params['dealtby']= trim($this->input->post('dealtby'));
            $params['ins_status']= trim($this->input->post('ins_status'));
            $params['searchdate']= trim($this->input->post('searchdate'));
            $params['createStartDate']= trim($this->input->post('createStartDate'));
            $params['createEndDate']=  trim($this->input->post('createEndDate'));           
            $params['payout_status']= trim($this->input->post('payout_status'));
            $params['keywordbyd']= trim($this->input->post('keywordbyd'));
            $params['keywordbyIns']= trim($this->input->post('keywordbyIns'));
            $params['keywordsl']= trim($this->input->post('keywordsl'));
            $params['payout_status']= trim($this->input->post('payout_status'));
            $params['is_count']= 0;   
            $params['tab']= $tab;
            if($tab == 3){
                $params['insdashId']=5;
            }
            $params['pages']= $pages;
            $params['user_id']= $this->session->userdata['userinfo']['id'];        
            $params['role_name']= $this->session->userdata['userinfo']['role_name'];
            $params['is_count']= 0;
            $caseInfo   =  $this->Insurance_payout->getPayoutAllCaseInfo($params);
          
            $params['is_count']= 1;
            $caseInfoCount  =  $this->Insurance_payout->getPayoutAllCaseInfo($params);
            $data['page'] =(!empty($pages)) ? $pages :1;
            $data['insurance_listing'] = $caseInfo;
            $data['insurance_list_id'] = $loanId;
            $data['total_count']  = $caseInfoCount;
            
            if(empty($type)){
                echo $datas=$this->load->view('insurancePayout/insurancePayout_cases',$data,true); exit;
            }else
                echo $datas=$this->load->view('insurancePayout/ajax_insurancePayout',$data,true); exit;             
        }else if($tab == 2){
            $params['is_count']= 0;
            $params['pages']= $pages;
           
            $params['keyword']= trim($this->input->post('keyword'));
             if(!empty($pay_id) && empty($params['keyword'])){
                $params['keyword']=$pay_id;
                $params['searchby']= "searchpayout";
            }
            $params['keywordsl']= trim($this->input->post('keywordsl'));
            $params['keywordbyd']= trim($this->input->post('keywordbyd'));
            $params['searchby']= trim($this->input->post('searchby'));
            $params['searchdate']= trim($this->input->post('searchdate'));
            $params['daterange_to']= trim($this->input->post('daterange_to'));
            $params['daterange_from']= trim($this->input->post('daterange_from'));
            $payouthistory   =  $this->Insurance_payout->getPayoutHistory($params);
            $params['is_count']= 1;
            $payouthistoryCount  =  $this->Insurance_payout->getPayoutHistory($params);
            $data['page'] =(!empty($pages)) ? $pages :1;
            
            $data['payout_history'] =$payouthistory;
            $data['total_count'] =$payouthistoryCount;
              if($type ==1){
               echo $datas=$this->load->view('insurancePayout/ajax_payout_history',$data,true); exit; 
            }else
         echo $datas=$this->load->view('insurancePayout/payout_history',$data,true); exit;
        }
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
    public function  makePayout($id=''){
        $data['pageTitle']      = 'Insurance Payout Management';  
        $editId      = !empty($id)? explode('_',base64_decode($id)):'';
        $pay_id        = !empty($editId)?end($editId):'';
        $dealer_id =  "";
        if(!empty($pay_id)){
           $data['paymentDetails']  =  $this->Insurance_payout->getPaymentDetails($pay_id);
           $dealer_id =  $data['paymentDetails']['dealer_id'];
           $data['paymentDetails']['amount']  = $this->IND_money_format($data['paymentDetails']['amount']);
           $data['paymentDetails']['total_amount']  = $this->IND_money_format($data['paymentDetails']['total_amount']);
        }
        $data['dealerList']  =  $this->Insurance_payout->getDealers($dealer_id);
        $data['banklist']          = $this->Crm_banks->getcustomerBankList();
        $this->loadViews("insurancePayout/makePayout",$data); 
    }


    public function ajax_getdealerwise_insurance(){
        $datapost = $this->input->post();
        $dealerId = $this->input->post('makedealerSearch');
        $editId =   $this->input->post('edit_id');
        $data['editid'] = $editId;
        $data['quote_sources'] = $this->Insurance_payout->getData('crm_quote_source',array('name as name','id as id'),array('status'=>'1'));
        
        $data['case_details'] = $this->Insurance_payout->getPayoutCaseDealerWiseData($datapost);
        $data['clearance_payment'] = $this->Insurance_payout->getClearanceDataDealerWiseData($dealerId);
        $data['inhouse_payment'] = $this->Insurance_payout->getInhousePaymentDealerWise($dealerId);
        $data['source_percentage'] = $this->Insurance_payout->getData('crm_insurance_company_percentage',array('payout_percentage as name','ref_id as id'),array('type'=>'2'));
        
        if(!empty($editId)){
           $data['caseids']  =  $this->Insurance_payout->getPayoutCaseIDs($editId);
        }
        echo $datas=$this->load->view('insurancePayout/ajax_getdealerwise_insurancelist',$data,true); exit;
    }
    
    public function  editPayout(){
        $datapost = $this->input->post();
        $paymentId  = trim($this->input->post('paymentId'));
        $data['paymentDetails']  =  $this->Insurance_payout->getPaymentDetails($paymentId);
        $data['paymentDetails']['amount']  = $this->IND_money_format($data['paymentDetails']['amount']);
//        $data['paymentDetails']['gst_amount']  = $this->IND_money_format($data['paymentDetails']['gst_amount']);
//        $data['paymentDetails']['tds_amount']  = $this->IND_money_format($data['paymentDetails']['tds_amount']);
//        $data['paymentDetails']['gst_excluded_amount']  = $this->IND_money_format($data['paymentDetails']['gst_excluded_amount']);
//        $data['paymentDetails']['total_amount']  = $this->IND_money_format($data['paymentDetails']['total_amount']); 
//        
        $data['dealerList']  =  $this->Crm_dealers->getDealers();
        $data['banklist']          = $this->Crm_banks->getcustomerBankList(); 
         //       echo "<pre>";print_r($data);die;
        $this->load->view('payout/editPayout',$data);
    }
    /* need to chnage data here to chnage insurance data dealer by */
    
    public function getPendingPayout(){
        
        $datapost = $this->input->post();
        $dealer_id      = trim($this->input->post('source'));
        $edit_id        = trim($this->input->post('editId'));
        $param['dealer_id'] =$dealer_id;
        $param['case_type_id'] =trim($this->input->post('case_type_id'));
        $param['editid'] = $edit_id;
        $caseInfo   =  $this->Insurance_payout->getPayoutCaseDealerWiseData($param);
        
        
        if(!empty($edit_id)){
           $caseids  =  $this->Insurance_payout->getPayoutCaseIDs($edit_id);
        }
        $i =1;
        ///echo "<pre>";print_r($caseInfo);die;
        if(!empty($caseInfo)){
        foreach( $caseInfo as $value) {
            
            $rc_status = $sr_no = $loan_for = $pending_from = $customer_id = "";
            $payout_amount = $approved_emi = $approved_loan_amt = $payout = $disbursal_payout= $disbur= 0;
            $loan_for = ($value['loan_for']=='2')?'Used Car':'New Car';
            $sr_no = $value['sr_no'];
            if(empty($value['disbursed_amount'])){
             $disbur = (empty($value['approved_loan_amt'])? $value['file_loan_amount']:$value['approved_loan_amt']);
            }else{
              $disbur = $value['disbursed_amount'];
            }
            if(!empty($value['loan_amount'])){
              $disbur =   $value['loan_amount'];
            }
             
            $approved_loan_amt = $this->IND_money_format($disbur);
            
            $disbursal_payout = !empty($value['payout'])?$value['payout']:"0";
            if(!empty($value['final_payout']))
                $payout =  $value['final_payout'];
            else
                $payout = !empty($value['net_payout'])?$value['net_payout']:$disbursal_payout;
            $approved_emi = $this->IND_money_format($value['approved_emi']);
            $payout_amount = 0;$pending_from = "";
            $customer_id = $value['customer_loan_id'];
            if(!empty($value['rc_status']))
                 $rc_status = "Status - ".RC_STATUS[$value['rc_status']];
            if(!empty($value['pending_from']))
                 $pending_from = "Pending From - ". RC_PENDING_FROM[$value['pending_from']];
           // echo $payout;die;
            if(!empty($payout) && $payout != 0){
             $payout_amount = ($disbur - $approved_emi) *($payout/100);
             $payout_amount = round($payout_amount);
             $payout_amount = $this->IND_money_format($payout_amount);
             
            }          
            
                $checked = "";
                if(!empty($edit_id) && in_array($customer_id, $caseids) )
                    $checked = "checked";
                    $regno = "";
                    if(!empty($value['reg_year'])) {
                    $regno = strtoupper($value['regno']) .'  '.'  '.$value['reg_year'].' Model';                               
                    }
                     $car_loan_type = $value["loan_for"];
                     $html .='<tr><td>';
                     $html .= "<input name='verified[]' data-loan-for='$car_loan_type' onclick='getCheckedCasesCount(1)'  type='checkbox' id='car_$sr_no' value='$sr_no' $checked>";
                     $html .="<label class='mrg-R10' for='car_$sr_no'><span></span></label>"; 
                     $html .= "<input type='hidden' value='$customer_id' name='case_id_$sr_no' id ='hidden_case_id_$sr_no'>";
                     $html .='</td><td><div class="mrg-B5"><b>';
                     $html .= ucwords(strtolower($value['name'])).'<br/> '.$value['customer_mobile'] .'</b> </div>';                     
                     $html .='</td>';
                     $html .= '<td><div class="mrg-B5">';
                     $html .= "<b>".$value['make_name'].' '.$value['model_name'] . ' '.$value['version_name']."</b> </div>";
                     $html .= $regno."<br />";
                     $html .= '<div class="arrow-details"><span class="font-10">'.$loan_for.'-'.ucwords($value['loan_type']);
                     $html .='</span></div><div style="min-height: 20px;"></div></td><td>';
                     $html .= "<input type='hidden' value='$approved_loan_amt' id ='hidden_amount_$sr_no'>";
                     $html .= "<input type='hidden' value='$approved_emi' id ='hidden_emi_$sr_no'>";
                     $html .='Loan Amount - <i class="fa fa-rupee"></i> <span id="est_amt">'.$approved_loan_amt.'</span><br />';
                     if($approved_emi > 0){
                       $html .= "Advance EMI - <i class='fa fa-rupee'></i> ". $approved_emi. "<br />";
                     }
                     $html .= $value['financer_name'];
                     $html .='</td>';
                     $html .="<td>$rc_status <br /> $pending_from</td>";
                     $html .= "<td><input type='text' class='form-control col-md-2' maxlength='5' onkeypress='return isRoiNumberKey(event);' value='$payout' name='payout_per_$sr_no' onblur='calculatePayout($sr_no)' id='payout_per_$sr_no'>";
                     $html .= "<input type='hidden' class='hidden_payment_amount' value='$payout_amount' name='hidden_payment_amount_$sr_no' id='hidden_payment_amount_$sr_no'></td>";
                     $html .= "<td><div class='payout_amount_$sr_no'><i class='fa fa-rupee'></i>  $payout_amount</div></td>";
                     $html .= '</tr>';
                     $i++;
          
          }
        }
        else{
             $html .='<tr><td colspan="7">No Data Found.</td></tr>';
        }
          $response = array('status'=>true,'html'=>$html);
        echo json_encode($response);die;
    }    
    public function save_payment() {
        $datapost = $this->input->post();
        if($datapost['payment_mode'] == 2 || $datapost['payment_mode'] == 3){
            $data['bank_id'] = $datapost['payment_bank'];
            $data['bank_name'] = $datapost['bank_name'];
        }else {
             $data['bank_id'] = "";
            $data['bank_name'] = "";
        }
        $data['payment_mode'] = $datapost['payment_mode'];
        $data['payment_date'] = (!empty($datapost['paydate']) && ($datapost['paydate']!='1970-01-01'))?date('Y-m-d',strtotime($datapost['paydate'])):'';
        $data['amount'] = str_replace(',', '', $datapost['net_amount']);
        $data['dealer_id'] =  $datapost['makedealerSearch'];
        $data['favouring_to'] = $datapost['favouring'];
        $data['instrument_no'] = $datapost['insno'];
        $data['instrument_date'] =(!empty($datapost['insdate']) && ($datapost['insdate']!='1970-01-01'))?date('Y-m-d',strtotime($datapost['insdate'])):'';
        $data['pay_remark'] = $datapost['remark'];  
        $data['prime_dealer_id'] = DEALER_ID;  
        $data['total_due_amt'] =  str_replace(',', '',$datapost['total_due_amt']);
        $data['total_amount'] =  str_replace(',', '',$datapost['total_amount']);
        //echo "<prE>";print_r($datapost);die;
        $editid = !empty($datapost['edit_id'])?$datapost['edit_id']:"";
        $data['updated_by'] = $this->session->userdata['userinfo']['id'];
        $date = date('Y-m-d H:i:s');
        if($editid=='') {
            $data['date_time'] = $date;
            $data['created_by'] = $this->session->userdata['userinfo']['id'];
        }
        $payout_id = $this->Insurance_payout->savePayout($data,$editid);
        
        $log_data = $edit_log_data = array();        
        $log_data['dealer_id'] = $data['dealer_id'];
        $log_data['bank_details'] = $data['bank_name'];
        $log_data['bank_id'] = $data['bank_id'];     
        $log_data['created_by'] = $this->session->userdata['userinfo']['id'];
        $log_data['status'] = "1";  
        $log_data['payout_id'] = $payout_id;
        if($editid=='')
          $action = "0";
        else 
          $action = "1";
          $log_data['action'] = ($action == 0)?"Add":"Update";
        $this->Insurance_payout->addPayoutHistory($log_data);
        
            $caseIds = $this->Insurance_payout->getPayoutCaseIDs($editid,1);
            $edit_ids = array();
            foreach($datapost['verified'] as $key=> $verified){
                if (!in_array($verified, $caseIds)) {          
                    $mapping_data[$key]['payout_id'] =  $payout_id;      
                    $mapping_data[$key]['dealer_id'] =  $datapost['makedealerSearch'];
                    $mapping_data[$key]['due_amount'] =   $datapost['due_payment_'.$verified];
                    $mapping_data[$key]['payout'] =   $datapost['payout_per_'.$verified];
                    $mapping_data[$key]['payment_amount'] =  str_replace(',', '',  $datapost['hidden_payment_amount_'.$verified]);                   
                    $mapping_data[$key]['sr_no'] =  $verified;
                    $mapping_data[$key]['is_settled'] =  isset($datapost['settle_due_'.$verified])?$datapost['settle_due_'.$verified]:"0";
                    
                    $mapping_data[$key]['date_time'] = $date;
                    $mapping_data[$key]['created_by'] = $this->session->userdata['userinfo']['id'];
                    $mapping_data[$key]['updated_by'] = $this->session->userdata['userinfo']['id'];
                    $mapping_data[$key]['status'] =   1;
                    $log_arr = $mapping_data[$key];
                    $log_arr['action'] = "add";
                    $edit_log_data[] = $log_arr;
                    if(!empty($datapost['due_payment_'.$verified])){
                        $customer_id = $datapost['ins_customer_id_'.$verified];
                        $encrpted_id = base64_encode('payoutId_'.$payout_id);
                        $part_payment[$key]['entry_type'] =  4;
                        $part_payment[$key]['customer_id'] =  $customer_id;
                        $part_payment[$key]['payment_by'] =  1;
                        $part_payment[$key]['amount'] = $datapost['due_payment_'.$verified];
                        $part_payment[$key]['payment_date'] =  (!empty($datapost['paydate']) && ($datapost['paydate']!='1970-01-01'))?date('Y-m-d',strtotime($datapost['paydate'])):'';
                        $part_payment[$key]['payment_mode'] =  2;
                        $part_payment[$key]['pay_remark'] =  "Adjusted In  Payout ID <a href = '/insurancePayout/2/".$encrpted_id."'>".$payout_id."</a>";
                        $insuranceCase = array('last_updated_status'=>9);
                        $this->Crm_insurance->updateInsuranceCase($insuranceCase,$verified);                        
                    }
                }else{                  
                   $edit_mapping_data = array();
                   $edit_mapping_data['sr_no'] =  $verified;
                   $edit_mapping_data['payout_id'] =  $payout_id;  
                   $edit_mapping_data['dealer_id'] =  $datapost['makedealerSearch'];
                   $edit_mapping_data['status'] =   1;
                   $edit_mapping_data['due_amount'] =   $datapost['due_payment_'.$verified];
                   $edit_mapping_data['payout'] =   $datapost['payout_per_'.$verified];
                   $edit_mapping_data['payment_amount'] =  str_replace(',', '',  $datapost['hidden_payment_amount_'.$verified]);  
                   $edit_mapping_data['is_settled'] =  isset($datapost['settle_due_'.$verified])?$datapost['settle_due_'.$verified]:"0";
                   $edit_mapping_data['updated_by'] = $this->session->userdata['userinfo']['id'];
                  // echo "<pre>";print_R($edit_mapping_data);die;
                   $this->Insurance_payout->savePayoutCaseMapping($edit_mapping_data,$verified); 
                   $edit_mapping_data['action'] = 'edit'; 
                   $edit_log_data[] = $edit_mapping_data; 
                   if(!empty($datapost['due_payment_'.$verified])){
                        $encrpted_id = base64_encode('payoutId_'.$payout_id);
                        $customer_id = $datapost['ins_customer_id_'.$verified];
                        $part_payment[$key]['entry_type'] =  4;
                        $part_payment[$key]['customer_id'] =  $customer_id;
                        $part_payment[$key]['payment_by'] =  1;
                        $part_payment[$key]['amount'] = $datapost['due_payment_'.$verified];
                        $part_payment[$key]['payment_date'] =  (!empty($datapost['paydate']) && ($datapost['paydate']!='1970-01-01'))?date('Y-m-d',strtotime($datapost['paydate'])):'';
                        $part_payment[$key]['payment_mode'] =  2;
                        $part_payment[$key]['pay_remark'] =  "Adjusted In  Payout ID <a href = '/insurancePayout/2/".$encrpted_id."'>".$payout_id."</a>";
                        $insuranceCase = array('last_updated_status'=>9);
                        $this->Crm_insurance->updateInsuranceCase($insuranceCase,$verified);  
                    }
                } 
        }       
        $ids = $this->Insurance_payout->savePayoutCaseMapping($mapping_data);
        if(!empty($part_payment)){
          $ids = $this->Insurance_payout->saveInsurancePartPayment($part_payment);
        }
        $data['action'] = $action;
        $log_arary = array('payment'=>$data,'mapping_data'=>$edit_log_data);
        $this->addPayoutHistoryUpdateLog($payout_id,$log_arary,$action);
       echo $ids; exit;
    }
      public function printpdf($payoutId)
     {
        $pdfData = [];
        $this->load->helper('pdf_helper');
      if(!empty($payoutId)){
            $data['payout_id']        = $payoutId;
            $case_data = $this->Insurance_payout->getCaseInfoById($payoutId);
            $payout_data = $this->Insurance_payout->getPayoutInfoById($payoutId);   
            $time=time();
        $filename=str_replace(' ','_', $payout_data['organization']).'_'.$payoutId.'_'.$time;
        }
       
        $payout_data['gst_excluded_amount'] = round($payout_data['gst_excluded_amount']);
        $payout_data['gst_amount'] = round($payout_data['gst_amount']);
        $pdfData['case_details']= $case_data;
        $pdfData['payout_Detail'] = $payout_data;
        //echo "<prE>";print_r($pdfData);die;
        $html = $this->load->view('payout/pdffile.php', $pdfData, true);
        @pdf_create($html, $filename);
        write_file('name', $data);
        //$this->orderListing();
    }
 public function printPayoutpdf()
     {
        $pdfData = [];
         $payoutId = $_POST['id'];
        //$this->load->helper('pdf_helper');
      if(!empty($payoutId)){
             $data['payout_id']        = $payoutId;
             $pdfData['case_details']  = $this->Insurance_payout->getCaseInfoById($payoutId);
        
             $pdfData['payout_Detail'] = $this->Insurance_payout->getPaymentDetails( $payoutId);
             $time      = time();
             $filename  = str_replace(' ','_', $pdfData['case_details'][0]['dealerName']).'_'.$payoutId.'_'.$time;
             $html      = $this->load->view('insurancePayout/pdffile.php', $pdfData, true);
             $this->deliveryDocs($html,$filename);
            // @pdf_create($html, $filename);
        }

    }
    public function import_dealers(){

        $this->load->helper('file');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('download');
        $file_name_key        = key($_FILES);
        $filenameExtension    = $_FILES[$file_name_key]['name'];
        $extension = explode('.',$filenameExtension);
        
        if($extension['1']=='xlsx' || $extension['1']=='csv' || $extension['1']=='xls' ){
        if($_SERVER['HTTP_HOST']=='localhost'){
         $config['upload_path'] = './assets/payout';
        }else{
         $config['upload_path']=UPLOAD_IMAGE_PATH_LOCAL.'insurance_payout_company/';   
        }
         
         $config['allowed_types']='xls|csv|xlsx';
         $config['max_size']      = '10000'; // kbytes 
         $config['encrypt_name'] = TRUE;
         //echo "<prE>";print_r($config);die;
        $this->load->library('upload',$config);
        if($this->upload->do_upload($file_name_key)){
            $data = array('upload_data' => $this->upload->data());
            $filepath = $data['upload_data']['full_path'];
            $handle = fopen($filepath, "r");
            
             $filedataArray = array();

              ######### for xlsx upload start ##########
             $objPHPExcel = PHPExcel_IOFactory::load($filepath);
             $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

        
              foreach ($cell_collection as $cell) {
            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
            //header will/should be in row 1 only. of course this can be modified to suit your need.
            if ($row == 1) {
                $header[$row][$column] = $data_value;
            } else {
                $filedataArray[$row][$column] = $data_value;
            }
        }

        $xlsxData['header'] = $header;
        $xlsxData['values'] = $filedataArray;

       
        
        
             ######### for xlsx upload end   ##########
              $filedataArraySize = count($filedataArray);              
              if($filedataArraySize>0){
              $uploaded_data = $exportData = $exportDataArray= $exportDataerr= $response = array();
               $successCount = $failureCount =  0;
               
              for($i=2;$i<$filedataArraySize;$i++){
             $policydataExist = $this->Insurance_payout->getconditionalData(trim($filedataArray[$i][B])); 

             /*echo "<pre>";
             print_r($policydataExist);
             die();*/

            
                $blankdataCon = (!empty($filedataArray[$i][A]) && !empty($filedataArray[$i][B]) && !empty($filedataArray[$i][C]) && !empty($filedataArray[$i][D]) && (is_numeric($filedataArray[$i][C])) && is_numeric($filedataArray[$i][D]) && ($filedataArray[$i][C]>0) && ($filedataArray[$i][D]>0));
                 
                 if(empty($policydataExist['policy_number']) && !empty($policydataExist['id']) && $blankdataCon){
                    $successCount = $successCount+1;
                    $uploaded_data[] = array(
                                            'insurance_company' => trim($filedataArray[$i][A]),
                                            'policy_number'     => trim($filedataArray[$i][B]),
                                            'payout'            => trim($filedataArray[$i][C]),
                                            'payout_amount'     => trim($filedataArray[$i][D]),
                                            'created_by'     => $this->session->userdata['userinfo']['id'],
                                            'created_on'        => date('Y-m-d H:i:s'),
                                            );

                    $exportData['insurance_company']  = trim($filedataArray[$i][A]);
                    $exportData['policy_number']      = trim($filedataArray[$i][B]);
                    $exportData['payout']             = trim($filedataArray[$i][C]);
                    $exportData['payout_amount']      = trim($filedataArray[$i][D]);
                    $exportData['status']             = "success";
                      //$exportDataaa[] =$exportData; 


                  ############## update payout status start #######################
                     $policyDetails = $this->Insurance_payout->getPayoutDetails('crm_insurance_payout_details',array('payout_amount as actualPayout'),array('policy_no'=>trim($filedataArray[$i][B])));
                        
                    if(!empty($policyDetails['actualPayout']) && ($policyDetails['actualPayout']>0)){
                         $updatedData = array();
                        
                        $actualPayout       = $policyDetails['actualPayout'];
                        $calculatedPayout   = $filedataArray[$i][D];
                        $difference         = $actualPayout - $calculatedPayout;

                        if($difference==0){
                        $updatedData['status'] ='3';
                        }else if($calculatedPayout>$actualPayout){
                        $updatedData['status'] ='3';
                        }else if($calculatedPayout<$actualPayout){
                         $updatedData['status'] ='2';
                        }

                        if(!empty($updatedData)){
                         $updatedData['updated_by']= $this->session->userdata['userinfo']['id'];
                        $updateStatus =  $this->Insurance_payout->updateconditionalData('crm_insurance_payout_details',$updatedData,array('policy_no'=>trim($filedataArray[$i][B])));
                        }
                      
                       }
                 ############## update payout status end #######################
                     $exportDataArray[] =$exportData; 

               }else{

               $con2 = (!empty($policydataExist['policy_number']) && !empty($policydataExist['id']));
               $con3 =  (empty($policydataExist['policy_number']) && empty($policydataExist['id']));
               $con4 =  (empty($policydataExist['policy_number']) && !empty($policydataExist['id']));
               $con5 = (empty($filedataArray[$i][A]) || empty($filedataArray[$i][B]) || empty($filedataArray[$i][C]) || empty($filedataArray[$i][D]));
               
                if($con2 || $con3 || $con3 || $con4 || $con5){
                     $failureCount  = $failureCount+1;
                     $exportDataerr['insurance_company']   = trim($filedataArray[$i][A]);
                     $exportDataerr['policy_number']       = trim($filedataArray[$i][B]);
                     $exportDataerr['payout']              = trim($filedataArray[$i][C]);
                     $exportDataerr['payout_amount']       = trim($filedataArray[$i][D]);
                     $exportDataerr['status']              = "failure";
                     if($con5){
                        $exportDataerr['reason']  = "Any column is empty";
                     }else if(ctype_alnum($filedataArray[$i][C])){
                       // $exportData['reason'] ="";
                        $exportDataerr['reason']  = "Payout percentage has invalid value please fill digit only";
                     }else if(ctype_alnum($filedataArray[$i][D])){
                        //$exportData['reason'] ="";
                        $exportDataerr['reason']  = "Payout Amount has invalid value please fill digit only";
                     }else if($con2){
                        //$exportData['reason'] ="";
                        $exportDataerr['reason']  = "payout already exists";
                     }else{
                      //$exportData['reason'] ="";
                      $exportDataerr['reason']  = "invalid policy";  
                     } 
                     $exportDataArray[] =$exportDataerr;                     
                  }
                 }
                
                }
                if(!empty($uploaded_data)){
                $inserted = $this->db->insert_batch('crm_insurance_uploaded_payout', $uploaded_data);
                }
             
               }
                ############ for download file upload status   #############
              $file_location = $data['upload_data']['file_path'];
              $fileExtension = $data['upload_data']['file_ext'];
              $filesName     = 'uploadedPayout_'.time().$fileExtension; 
               header("Content-Description: File Transfer"); 
               header("Content-Disposition: attachment; filename=$filesName"); 
               header("Content-Type: application/csv; ");

               $file = fopen($file_location. $filesName, "w");
               $header = array("insurance_company","policy_number","payout_percentage","payout_amount","status","reason"); 
               fputcsv($file, $header);
               foreach ($exportDataArray as $key=>$line){ 
                 fputcsv($file,$line); 
                }
               fclose($file); 
               $response['status']        =  1;
               $response['download_path'] =  base_url()."PayoutInsurance/downloadCSV/".$filesName; 
               $response['success_msg']   =  "You have added " .$successCount."Record successfully and " .$failureCount. "Record failure ";
              echo json_encode($response);die;    

                }else{
                    $response['status']        = 'error';
                    $response['message']       = $this->upload->display_errors();
                    echo json_encode($response);die; 
                    die();
                     }

             }else{
                $response['status']        = 'error';
                $response['message']       = 'Please Select Valid file xslx OR csv';
                echo json_encode($response);die; 
               }


      
    }

    public function downloadCSV($file) {
        if (isset($file)) {

            if($_SERVER['HTTP_HOST']=='localhost'){
             $filepath='./assets/payout/'.$file; 
            }else{
              $filepath=UPLOAD_IMAGE_PATH_LOCAL.'insurance_payout_company/'.$file;   
            }
                      
            if (file_exists($filepath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filepath));
                flush(); // Flush system output buffer
                readfile($filepath);
                unset($filepath);
                exit;
            }
        }
    }


    public function insuranceSaveComment(){
      $datapost = $this->input->post();
      $updated =  $this->Insurance_payout->updateconditionalData('crm_insurance_uploaded_payout',array('difference'=>$datapost['differenceAmount'],'comment'=>$datapost['comment']),array('policy_number'=>$datapost['policyno']));
      $updatedStatus = $this->Insurance_payout->updateconditionalData('crm_insurance_payout_details',array('status'=>'3'),array('policy_no'=>$datapost['policyno']));

     echo $updated;
     exit();
    }
    public function deliveryDocs($html,$filename)
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

    public function downloadBookingPdf()
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
