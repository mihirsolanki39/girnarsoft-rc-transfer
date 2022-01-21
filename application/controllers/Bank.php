<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Bank (BankController)
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
class Bank extends MY_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('crm_banks');
        $this->load->model('state_list');
        $this->load->model('Crm_banks_List');
        $this->load->model('Bank_employee_limit_mapping');
         if(!$this->session->userdata['userinfo']['id']){
             return redirect('login');
            }

    }
    
    
    public function index()
    {
        $this->global['pageTitle'] = 'Bank';
        $this->loadViews("bank", $this->global, NULL , NULL);
    }
    
    
    function bankListing() {
        $is_admin           = $this->session->userdata['userinfo']['is_admin'];
        $dealerId           = DEALER_ID;

        $type               = 1;
        if($this->input->get("type")){
          $type             = $this->input->get("type");
        }
        $searchText          = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText']  = $searchText;
        //$data['bankRecords'] = $this->crm_banks->BankListings($searchText);
        //$data['banks']       =  $this->Crm_banks_List->crmBankList();
        $data['type']       = $type;
        $this->global['pageTitle'] = 'Bank Listing';
        $this->loadViews("bank/bankList", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the add new form
     */
    function addBank($id = NULL)
    {

            if(!empty($id) && ($id!='')){
            $bankId  = !empty($id)? explode('_',base64_decode($id)):'';
            $id      = end($bankId);
            }
            
            $data['stateList']         =  $this->state_list->getStateList();
            $data['banks']             =  $this->Crm_banks_List->crmBankList();
            if($id){
            $data['bankid']          = $id;    
            $data['bankInfo']        = $this->crm_banks->getBankInfo($id);
            $data['bank'][0] = $this->crm_banks->getBankNameBybnkId($data['bankInfo'][0]['bank_id']);
            $data['cityList']          =  $this->getCityListByStateId($data['bankInfo'][0]['state']);
            $data['bankInfo'][0]['amount_limit'] = $this->IND_money_format($data['bankInfo'][0]['amount_limit']);
            $this->global['pageTitle'] = 'Update Bank';
            }else{
            $this->global['pageTitle'] = 'Add New Bank';    
            }
            //echo "<prE>";print_r($data);die;
            $this->loadViews("bank/addBank", $this->global,$data, NULL);
    }
    
    
    function addNewBank($id = NULL)
    {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="text-danger" style="font-size:12px">', '</div>');
            $this->form_validation->set_rules('bank_name','Bank Name','trim|required');
            $this->form_validation->set_rules('branch','Branch','trim|required');
            //$this->form_validation->set_rules('amount_limit','Amount Limit','callback_validate_money','required');
            //$this->form_validation->set_rules('pincode','Pincode','trim|required');
            //$this->form_validation->set_rules('amount_limit','Amount Limit','required|max_length[10]|min_length[8]','required');
            //$this->form_validation->set_rules('amount_limit','Amount Limit','required|greater_than[10]','required');
           // $this->form_validation->set_rules('ifsc_code','IFSC Code','required|alpha_numeric_spaces','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addBank();
            }
            else
            {
                $bankName      = $this->security->xss_clean($this->input->post('bank_name'));
                $address       = $this->security->xss_clean($this->input->post('address'));
                $branch        = $this->security->xss_clean($this->input->post('branch'));
                $pincode       = $this->security->xss_clean($this->input->post('pincode'));
                $state         = $this->security->xss_clean($this->input->post('state'));
                $city          = $this->security->xss_clean($this->input->post('city'));
                $micrCode      = $this->security->xss_clean($this->input->post('micr_code'));
                $ifsc_code     = $this->security->xss_clean($this->input->post('ifsc_code'));
                $amount_limit  = $this->security->xss_clean($this->input->post('amount_limit'));
                 $definedLimit  = $this->security->xss_clean($this->input->post('definedLimit'));
                $bankNameInfo = array(
                    'bank_name' =>     ucwords($bankName),
                    'status'    => '1'
                );
                $bankId = $this->crm_banks->addCrmBank($bankNameInfo);
                $checkamount =  $this->ajax_validate_limit($definedLimit,$bankId,$amount_limit,'1');
               // echo "<pre>";
               // print_r($checkamount);
               // exit;
                $bankInfo = array(
                    'bank_id'       =>     $bankId,
                    'address'         =>   ucwords(trim($address)), 
                    'branch_name'     =>   trim($branch),
                    'pin_code'        =>   trim($pincode),
                    'state'           =>   $state,
                    'city'            =>   $city,
                    'micr_code'       =>   trim($micrCode),
                    'ifsc_code'       =>   trim($ifsc_code),
                    'amount_limit'    =>   str_replace(',','', $amount_limit),
                    'status'          =>  '1',
                    'created_date'    =>   date('Y-m-d H:i:s'),
                );
                
                $result = $this->crm_banks->addNewBank($bankInfo);
                
                if($result > 0)
                {
                    redirect('bank');
                  //$this->loadViews("bank/bankList", $this->global, $data, NULL);
                    //$this->session->set_flashdata('success', 'New bank created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                   
                }
               $data['stateList']         =  $this->state_list->getStateList();
               $data['banks']             =  $this->Crm_banks_List->crmBankList();
               $this->loadViews('bank/addBank',$data);
                
            }
    }
    public function checkDuplicateBank()
    {
        $bank  = $this->input->post('bank_name');
        $edit_id  = $this->input->post('updateId');
        $bank = trim($bank);
        $exists = $this->Crm_banks->getBankNameByName($bank,$edit_id);
       // echo "<pre>";print_r($exists);die;
        if(empty($exists))
           $response = array("status"=>1);
        else
            $response = array("status"=>0);
        echo json_encode($response);die;
    }   
        public function editBank($id = NULL) {
            $bankId  = !empty($id)? explode('_',base64_decode($id)):'';
            $id      = end($bankId);
                if (!is_numeric($id)) {
                    redirect('bank');
                }
               $data['stateList']         =  $this->state_list->getStateList();
               $data['bankInfo']          = $this->crm_banks->getBankInfo($id);
               $data['bankName']          = $this->Crm_banks_List->crmBankList($data['bankInfo'][0]['bank_id']);
               $data['banks']             =  $this->Crm_banks_List->crmBankList();
               $data['cityList']          =  $this->getCityListByStateId($data['bankInfo'][0]['state']);
               $this->global['pageTitle'] = 'Edit Bank';
               $data['bankInfo'][0]['amount_limit'] = $this->IND_money_format($data['bankInfo'][0]['amount_limit']);
               $this->loadViews("bank/editBank", $this->global, $data, NULL);
            }
    public function getCityListByStateId($stateId){
       $this->db->select('city_id,city_name');
       $this->db->from('city_list');
       $this->db->where('state_id', $stateId);
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     

    }
    
    public function activeInactive() {
        $error = array();
        $postData = $this->input->post();
        if (!empty($postData)) {
            $dealerData = $this->setBankStatus($postData);
            return $dealerData;
        } else {
            $error[] = "Bank Not Updated!";
        }
        return $error;
    }

    public function setBankStatus($data = array()) {
        if (!empty($data)) {
            $id = $data['bank_id'];
            $type = $data['type'];
            if (trim($data['flag']) == 'deactivate') {
                $dataArray= ['status'=>'0'];
            } else if (trim($data['flag']) == 'activate') {
                $dataArray= ['status'=>'1'];
            }
            $result = $this->crm_banks->updateBank($dataArray,$id,$type);
        }
        echo $result;die;
    }
    
    function validate_limit($definedLimit) {
        $bankId   = $this->input->post('updateId');
        $getDistributedLimit  =$this->Bank_employee_limit_mapping->getEmployeeLimit($bankId);
       //echo '<pre>';print_r($getDistributedLimit[0]->distributedLimit);die;
        
        if ($getDistributedLimit[0]->distributedLimit < $definedLimit) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function updateBank()
    {//

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="text-danger" style="font-size:12px">', '</div>');
            $this->form_validation->set_rules('bank_name','Bank Name','trim|required');
            $this->form_validation->set_rules('branch','Branch','trim|required');
            //$this->form_validation->set_rules('amount_limit','Amount Limit','callback_validate_money','required');
            // $this->form_validation->set_rules('amount_limit','Amount Limit','required|greater_than[100]','required');
            // $this->form_validation->set_rules('ifsc_code','IFSC Code','required|alpha_numeric_spaces','required');
            if($this->form_validation->run() == FALSE)
            {

                $this->addBank();
            }
            else
            {

                $bankName      = $this->security->xss_clean($this->input->post('bank_name'));
                $address       = $this->security->xss_clean($this->input->post('address'));
                $branch        = $this->security->xss_clean($this->input->post('branch'));
                $pincode       = $this->security->xss_clean($this->input->post('pincode'));
                $state         = $this->security->xss_clean($this->input->post('state'));
                $city          = $this->security->xss_clean($this->input->post('city'));
                $micrCode      = $this->security->xss_clean($this->input->post('micr_code'));
                $ifsc_code     = $this->security->xss_clean($this->input->post('ifsc_code'));
                $amount_limit  = $this->security->xss_clean($this->input->post('amount_limit'));
                $updatedId     = $this->input->post('updateId');
                $bankInfo1        = $this->crm_banks->getBankInfo($updatedId);
              //  $dbank = $this->crm_banks->getBankNameBybnkId($bankInfo1[0]['bank_id']);
                $bankNameInfo = array(
                    'bank_name'       =>     ucwords($bankName),
                    'status'    => '1'
                );
                $bankId = $this->crm_banks->updateCrmBanks($bankNameInfo,$bankInfo1[0]['bank_id']);
                $checkamount =  $this->ajax_validate_limit($definedLimit,$bankId,$amount_limit,'1');
                
                $bankInfo = array(
                    'bank_id'         =>   $bankId,
                    'address'         =>   ucwords($address), 
                    'branch_name'     =>   ucwords(trim($branch)),
                    'pin_code'        =>   trim($pincode),
                    'state'           =>   $state,
                    'city'            =>   $city,
                    'micr_code'       =>   trim($micrCode),
                    'ifsc_code'       =>   trim($ifsc_code),
                    'amount_limit'    =>   str_replace(',','', $amount_limit),
                    'status'          =>  '1',
                    'updated_date'    =>   date('Y-m-d H:i:s'),
                );
                $result = $this->crm_banks->updateBank($bankInfo,$updatedId,'partner');
                if($result > 0)
                {
                    //$this->session->set_flashdata('success', 'Bank Details updated successfully');
                    redirect('bank');
                }
                else
                {
                    redirect('editBank/'.base64_encode('bankId_'.$updatedId));
                }
                
                redirect('editBank/'.base64_encode('bankId_'.$updatedId));
            }
            redirect('editBank/'.base64_encode('bankId_'.$updatedId));
    }
    
    function ajax_validate_limit($definedLimit='',$bankId='',$limit='',$flag='') {
        if($flag==''){
            $definedLimit = str_replace(',', '', $this->input->post('definedLimit')); //exit;
            $bankId       = $this->input->post('bankId');
            $limit       = $this->input->post('limit');
        }
        $getDistributedLimit  =$this->Bank_employee_limit_mapping->getEmployeeLimit($bankId);
        //$summ = (int)$limit+(int)$getDistributedLimit[0]->distributedLimit; exit;
    //echo $getDistributedLimit[0]->distributedLimit .'---'. $definedLimit.'---'.$limit;
        if(!empty($getDistributedLimit))
        {
            //echo "fff";
            if (($getDistributedLimit[0]->distributedLimit > $definedLimit) || ($limit < $getDistributedLimit[0]->distributedLimit)) 
            {
                //echo "ffff"; exit;
                $result = ['status'=>'false','msg'=>'Limit  already assigned to user is '.$getDistributedLimit[0]->distributedLimit];
            }
             else
            {
                $result = ['status'=>'true','msg'=>''];
            }
        }
        else
        {
           // echo "ggg";
            $result = ['status'=>'true','msg'=>''];
        }
        if(empty($flag)){
                echo json_encode($result);exit;
        }
        else
        {
            return  $result;
        }
    }

    public function validate_money ($input)
    {
        $input =   str_replace(',','', $input);
        if(strlen($input)<8 || strlen($input)>11)
        {
            $this->form_validation->set_message('validate_money','Please enter a valid Loan Amount!');    
            return false;
        }
        if($input<'100')
        {
            $this->form_validation->set_message('validate_money','Please enter valid Loan Amount!');    
            return false;
        }
        else
        {
            return true;
        }
    }
    
    public function bankListingNew($invId='') {
        $this->loadViews("bank/banklisting-new", $this->global, $data, NULL);
    }
    
    public function ajax_getbank(){
        $is_admin              =   $this->session->userdata['userinfo']['is_admin'];
        $dealerId              =   DEALER_ID;
        $postdata              =   array();
        $datapost              =   $this->input->post();
        $datapost['ucdid']     =   DEALER_ID;
        $userId                =   $this->session->userdata['userinfo']['id'];
        $datapost['userId']    =   $userId;
        $is_search             =   0;
        $source                =   1;
        $page                  =   1;
        $limit                 =   10;
        
        if(isset($datapost['source']) && is_numeric($datapost['source']) && intval($datapost['source']) > 0){
            $source = intval($datapost['source']);
        }

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
            $is_search              = 1;
        }

        //$refurbtabCounts       =   $this->Crm_refurb_workshop->leadTabCounts($datapost,$dealerId);
        //$totalCount            =   !empty($refurbtabCounts) ? count($refurbtabCounts):0;
        //$caseList              =   $this->Crm_refurb_workshop->getCaseList($datapost,$page,$limit,$dealerId);
        $tabcount   = $this->crm_banks->getBankCaseList($datapost,'','');
        $totalCounts =   !empty($tabcount) ? count($tabcount):0;
        $bankRecords = $this->crm_banks->getBankCaseList($datapost,$page,$limit);
        //$data['banks']       =  $this->Crm_banks_List->crmBankList();
        $headerInfo=[
                  'totalCounts'    => $totalCounts,
                  'bankRecords'  => $bankRecords,
                  'is_admin'    => $is_admin,
                  'source'      => $source,
                  'page'        => $page,
                  'limit'       => $limit,
                  'is_search'   => $is_search
                ];
        $this->load->view('bank/ajax_bank',$headerInfo);
    }
function addCustomerBankData(){
        $postData = $this->input->post();
        $type = $postData['type'];
        $bankId = !empty($postData['bankId']) ?$postData['bankId'] :'';
         $msg = "";
        
        if(!empty($postData['bankName']) && ($postData['bankName']!='')){
            $bankName=ucwords(trim($postData['bankName']));
            $bankInfo = array(
                    'bank_name'       =>   $bankName,
                    'status'          =>  '1'
                );
                if($type=='add'){
                 $bankInfo['date_added']   = date('Y-m-d H:i:s');
                }else{
                  $bankInfo['date_updated']   = date('Y-m-d H:i:s');  
                }

                $check_exist = $this->crm_banks->checkDuplicateCustomerBank($bankInfo,$type,$bankId);
        
                if(empty($check_exist))
                   $result = $this->crm_banks->addCustomerBankData($bankInfo,$type,$bankId);
               else {
                  $msg = "Bank name already exist"; 
                  $result=0;
               }
            
        }else{
            $result=0;
        }
        $response = array('status'=>$result,"message"=>$msg);
        echo json_encode($response);exit;
    }
    }
    
    

