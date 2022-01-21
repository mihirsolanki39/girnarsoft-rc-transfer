<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class : Financce (FinanceController)
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
class Payout extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Crm_user');
        $this->load->model('Loan_customer_info');
        $this->load->model('Loan_customer_case');
        $this->load->model('Payout_cases');
        $this->load->library('form_validation');
        $this->load->model('Crm_dealers');
        if (!$this->session->userdata['userinfo']['id'])
        {
            return redirect('login');
        }
    }
    public function addPayoutHistoryUpdateLog($payout_id,$updated_data,$action)
    {
        $data = [];
        $data['payout_id'] = $payout_id;
        $data['updated_data'] = serialize($updated_data);
        $data['action'] = $action;
        $this->Payout_cases->addPayoutHistoryUpdateLog($data);
    }
    public function financeUserMgmt($id= '' ,$module='')
    {
        $role_id = $this->session->userdata['userinfo']['role_id'];
        $role = $this->Crm_user->getRightsByRole($role_id,$module);
        if($role_id>0){
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
        }
        return $role;
    }
    public function loanPayout($type="")
    {
        $data['pageTitle']      = 'Payout Management';
        $data['type'] = $type;
        $this->loadViews("payout/loanPayout",$data); 
    }
    public function ajax_PayoutList($type =null)
    {
       
        $data['employeeList']   =  $this->Crm_user->getEmployee('2');
        $data['fileTags'] = $this->Loan_customer_case->fileLoginTags();
        $data['rolemgmt'] = $this->financeUserMgmt();
        error_reporting(0);
        $datapost = $this->input->post();  
         $tab =  trim($this->input->post('source'));
        $pages          = trim($this->input->post('page'));
        $data['limit']  =   10;
        if($tab != 2){
            $loanId = $caseInfoAll = [];
            $params = array();
            $params['searchbyval']= trim($this->input->post('searchbyval'));
            $params['searchbyvaldealer']= trim($this->input->post('searchbyvaldealer'));
            $params['searchby']= trim($this->input->post('searchby'));
            $params['loan_source']=  trim($this->input->post('loan_source'));
            $params['loan_status']= trim($this->input->post('loan_status'));
            $params['searchdate']= trim($this->input->post('searchdate'));
            $params['daterange_to']= trim($this->input->post('daterange_to'));
            $params['daterange_from']= trim($this->input->post('daterange_from'));
            $params['status']=  trim($this->input->post('status'));
            $params['assignedto']= trim($this->input->post('assignedto'));
            $params['searchbyvalbank']= trim($this->input->post('searchbyvalbank'));
            $params['payout_status']= trim($this->input->post('payout_status'));
            $params['pages']= $pages;
            $params['user_id']= $this->session->userdata['userinfo']['id'];        
            $params['role_name']= $this->session->userdata['userinfo']['role_name'];
            $params['tab']= $tab;
            $params['is_count']= 0;
            if($tab == 3 && empty($params['payout_status'])){
                $params['payout_status']= 1;
            }
            $caseInfo   =  $this->Payout_cases->getPayoutAllCaseInfo($params);
            $params['is_count']= 1;
            $caseInfoCount  =  $this->Payout_cases->getPayoutAllCaseInfo($params);
            $data['page'] =(!empty($pages)) ? $pages :1;
            $data['loan_listing'] = $caseInfo;
            $data['loan_list_id'] = $loanId;
            $data['total_count']  = $caseInfoCount;
            $data['type'] =$tab;            
            if(empty($type)){
               echo $datas=$this->load->view('payout/loanPayout_cases',$data,true); exit;
            }else
               echo $datas=$this->load->view('payout/ajax_loanPayout',$data,true); exit;    
        }else if($tab == 2){
            $params['is_count']= 0;
            $params['pages']= $pages;
            $params['searchbyval']= trim($this->input->post('searchbyval'));
            $params['searchbyvaldealer']= trim($this->input->post('searchbyvaldealer'));
            $params['searchby']= trim($this->input->post('searchby'));
            $params['searchdate']= trim($this->input->post('searchdate'));
            $params['daterange_to']= trim($this->input->post('daterange_to'));
            $params['daterange_from']= trim($this->input->post('daterange_from'));
            
            $payouthistory   =  $this->Payout_cases->getPayoutHistory($params);
            $params['is_count']= 1;
            $payouthistoryCount  =  $this->Payout_cases->getPayoutHistory($params);
            $data['page'] =(!empty($pages)) ? $pages :1;
            $data['payout_history'] =$payouthistory;
            $data['total_count'] =$payouthistoryCount;
            
            if($type ==1){
               echo $datas=$this->load->view('payout/ajax_payout_history',$data,true); exit; 
            }else
         echo $datas=$this->load->view('payout/payout_history',$data,true); exit;
        }
    }function IND_money_format($number){        
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
    public function  makePayout(){
        
        $data['dealerList']  =  $this->Payout_cases->getDealers();
        $data['banklist']          = $this->Crm_banks->getcustomerBankList(); 
        $this->load->view('payout/makePayout',$data);
    }
    
    public function  editPayout(){
        $datapost = $this->input->post();
        $paymentId  = trim($this->input->post('paymentId'));
        $data['paymentDetails']  =  $this->Payout_cases->getPaymentDetails($paymentId);
        $data['paymentDetails']['amount']  = $this->IND_money_format($data['paymentDetails']['amount']);

        $data['dealerList']  =  $this->Crm_dealers->getDealers();
        $data['banklist']          = $this->Crm_banks->getcustomerBankList(); 
        //echo "<pre>";print_r($data);die;
        $this->load->view('payout/editPayout',$data);
    }
    
    public function getPendingPayout(){
        $datapost = $this->input->post();
        $dealer_id    = trim($this->input->post('source'));
        $edit_id    = trim($this->input->post('editId'));
        $param['dealer_id'] =$dealer_id;
        $param['case_type_id'] =trim($this->input->post('case_type_id'));
        $param['editid'] = $edit_id;
        $caseInfo   =  $this->Payout_cases->getPayoutCaseDealerWise($param);
        if(!empty($edit_id)){
           $caseids  =  $this->Payout_cases->getPayoutCaseIDs($edit_id);
        }
        $i =1;
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
    public function save_payment()
    {
        $datapost = $this->input->post();
     //   echo "<pre>";print_r($datapost);die;
        if($datapost['payment_mode'] == 2){
            $data['bank_id'] = $datapost['payment_bank'];
            $data['bank_name'] = $datapost['bank_name'];
        }else
        {
             $data['bank_id'] = "";
            $data['bank_name'] = "";
        }
        $data['payment_mode'] = $datapost['payment_mode'];
        $data['payment_date'] = (!empty($datapost['paydate']) && ($datapost['paydate']!='1970-01-01'))?date('Y-m-d',strtotime($datapost['paydate'])):'';
        $data['amount'] = str_replace(',', '', $datapost['amount']);
        $data['dealer_id'] =  $datapost['dealer'];
        $data['favouring_to'] = $datapost['favouring'];
        $data['instrument_no'] = $datapost['insno'];
        $data['instrument_date'] =(!empty($datapost['insdate']) && ($datapost['insdate']!='1970-01-01'))?date('Y-m-d',strtotime($datapost['insdate'])):'';
        $data['pay_remark'] = $datapost['remark'];  
        $data['prime_dealer_id'] = DEALER_ID;  
        $data['tds_type'] =  $datapost['tds_type']; 
        $data['pdd_charges'] = str_replace(',', '',$datapost['pdd_charges']);
        $data['pdd_charge_total'] = str_replace(',', '',$datapost['pdd_amount_total']);
        $data['tds_amount'] =  str_replace(',', '',$datapost['tds_amount']);
        $data['gst_type'] =  $datapost['gst_type'];
        $data['gst_amount'] = str_replace(',', '',$datapost['gst_amount']); 
        $data['gst_excluded_amount'] =  str_replace(',', '',$datapost['gst_excluded_amount']);
        $data['total_amount'] =  str_replace(',', '',$datapost['total_amount']);
        
        $editid = !empty($datapost['edit_id'])?$datapost['edit_id']:"";
        $data['updated_by'] = $this->session->userdata['userinfo']['id'];
        $date = date('Y-m-d H:i:s');
        if($editid=='')
        {
            $data['date_time'] = $date;
            $data['created_by'] = $this->session->userdata['userinfo']['id'];
        }
        $payout_id = $this->Payout_cases->savePayout($data,$editid);
        
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
        $this->Payout_cases->addPayoutHistory($log_data);
        
            $caseIds = $this->Payout_cases->getPayoutCaseIDs($editid,1);
            $edit_ids = array();
            foreach($datapost['verified'] as $key=> $verified){
               $case = $datapost['case_id_'.$verified];
                if (!in_array($case, $caseIds)) {
                    $mapping_data[$key]['case_id'] =  $datapost['case_id_'.$verified];            
                    $mapping_data[$key]['payout_id'] =  $payout_id;      
                    $mapping_data[$key]['dealer_id'] =  $datapost['dealer'];
                    $mapping_data[$key]['payout'] =   $datapost['payout_per_'.$verified];
                    $mapping_data[$key]['payment_amount'] =  str_replace(',', '',  $datapost['hidden_payment_amount_'.$verified]);                   
                    $mapping_data[$key]['sr_no'] =  $verified;
                    $mapping_data[$key]['date_time'] = $date;
                    $mapping_data[$key]['created_by'] = $this->session->userdata['userinfo']['id'];
                    $mapping_data[$key]['updated_by'] = $this->session->userdata['userinfo']['id'];
                    $mapping_data[$key]['status'] =   1;
                    $log_arr = $mapping_data[$key];
                    $log_arr['action'] = "add";
                    $edit_log_data[] = $log_arr;
                }else{
                  if(!empty($case)){
                   $edit_ids[] = $case;                   
                   $edit_mapping_data = array();
                   $edit_mapping_data['case_id'] =  $datapost['case_id_'.$verified]; 
                   $edit_mapping_data['sr_no'] =  $verified;
                   $edit_mapping_data['payout_id'] =  $payout_id;  
                   $edit_mapping_data['dealer_id'] =  $datapost['dealer'];
                   $edit_mapping_data['status'] =   1;
                   $edit_mapping_data['payout'] =   $datapost['payout_per_'.$verified];
                   $edit_mapping_data['payment_amount'] =  str_replace(',', '',  $datapost['hidden_payment_amount_'.$verified]);       
                   $edit_mapping_data['updated_by'] = $this->session->userdata['userinfo']['id'];
                   $this->Payout_cases->savePayoutCaseMapping($edit_mapping_data,$case); 
                   $edit_mapping_data['action'] = 'edit'; 
                   $edit_log_data[] = $edit_mapping_data;
                  }
               } 
        }
        $diff_ids = array_diff($caseIds, $edit_ids);
        if (!empty($diff_ids)) {
            foreach ($diff_ids as $diff) {
                  $caseDeatil = $this->Payout_cases->getPayoutdetailsCaseIDs($diff);
                  $edit_mapping_data = array();
                  $edit_mapping_data['status'] = 0; 
                  $edit_mapping_data['updated_by'] = $this->session->userdata['userinfo']['id'];
                  $this->Payout_cases->savePayoutCaseMapping($edit_mapping_data, $diff);
                  $edit_mapping_data['dealer_id'] =  $datapost['dealer'];
                  $edit_mapping_data['case_id'] = $diff;
                  $edit_mapping_data['sr_no'] = $caseDeatil['sr_no'];
                  $edit_mapping_data['payout_id'] = $diff;
                  $edit_mapping_data['payout'] = $caseDeatil['payout'];
                  $edit_mapping_data['payment_amount'] = str_replace(',', '', $caseDeatil['payment_amount']); 
                  $edit_mapping_data['action'] = 'edit'; 
                  $edit_log_data[] = $edit_mapping_data;
            }
        } 
        
        $ids = $this->Payout_cases->savePayoutCaseMapping($mapping_data);
         $data['action'] = $action;
        $log_arary = array('payment'=>$data,'mapping_data'=>$edit_log_data);
       // echo "<pre>";print_r($log_arary);
            $this->addPayoutHistoryUpdateLog($payout_id,$log_arary,$action);
       echo $ids; exit;

    }
      public function printpdf()
     {
        $pdfData = [];
        $payoutId = $_POST['id'];
        $this->load->helper('pdf_helper');
      if(!empty($payoutId)){
            $data['payout_id']        = $payoutId;
            $case_data = $this->Payout_cases->getCaseInfoById($payoutId);
            $payout_data = $this->Payout_cases->getPayoutInfoById($payoutId);   
            $time=time();
        $filename=str_replace(' ','_', $payout_data['organization']).'_'.$payoutId.'_'.$time;
        }
       
        $payout_data['gst_excluded_amount'] = round($payout_data['gst_excluded_amount']);
        $payout_data['gst_amount'] = round($payout_data['gst_amount']);
        $pdfData['case_details']= $case_data;
        $pdfData['payout_Detail'] = $payout_data;
        //echo "<prE>";print_r($pdfData);die;
        $html = $this->load->view('payout/pdffile.php', $pdfData, true);
        $this->deliveryDocs($html,$filename);
        //@pdf_create($html, $filename);
       // write_file('name', $data);
        //$this->orderListing();
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
