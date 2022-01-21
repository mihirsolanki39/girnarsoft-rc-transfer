<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Dealer (DealerController)
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
class Dealer extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('crm_dealers');
        $this->load->model('state_list');
        $this->load->model('Crm_banks');
        $this->load->model('Crm_user');
         if(!$this->session->userdata['userinfo']['id']){
             return redirect('login');
            }
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Dealer';
        
        $this->loadViews("dealers", $this->global, NULL , NULL);
    }
    
    /**
     * This function is used to load the user list
     */
    function dealerListingold($userId = NULL) {
        $searchText          = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText']  = $searchText;
        $this->load->library('pagination');

        $count   = $this->crm_dealers->dealerListingCount($searchText);
        $returns = $this->paginationCompress("dealerListing/", $count, 10);
        $data['userRecords'] = $this->crm_dealers->dealerListing('',$searchText,$returns["page"], $returns["segment"]);

        $this->global['pageTitle'] = 'Dealer Listing';
        $this->loadViews("dealer/dealers", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the add new form
     */
    function addNew($dealerId=null)
    {
                    $bankName           = $this->getcustomerBankList();
           // $bankName           = $this->Crm_banks->getBanklist();
           // echo "<pre>";print_r($this->input->post());die;
            $this->load->model('crm_dealers');
            $data['services']   = ['0'=>'loan','1'=>'insurance','2'=>'new_car','3'=>'used_car'];
            $data['stateList']  =  $this->state_list->getStateList();
            $data['userList']   =  $this->Crm_user->getEmployeeByTeam('Sales');
            $data['bankName']   = $bankName;
            $this->global['pageTitle'] = 'Add New Dealer';
            $this->loadViews("dealer/addNewDealer", $this->global,$data, NULL);
    }

    
    function checkEmailExists()
    {
        $userId  = $this->input->post("updateId");
        $email = $this->input->post("dealership_email");

        if(empty($userId)){
            $result = $this->crm_dealers->checkEmailExists($email);
        } else {
            $result = $this->crm_dealers->checkEmailExists($email, $userId);
        }
        $is_email_unique='';
        if($result['status']=='true'){
        if ($this->input->post('dealership_email') == $result['data']['dealership_email'])
        {
            $is_email_unique = '|is_unique[crm_dealers.dealership_email]';
        }
        }

        return $is_email_unique;
    }
    function checkMobileExists()
    {
        $userId      = $this->input->post("updateId");
        $mobile = $this->input->post("dealership_contact_number");

        if(empty($userId)){
            $result = $this->crm_dealers->checkMobileExists($mobile);
        } else {
            $result = $this->crm_dealers->checkMobileExists($mobile, $userId);
        }
        $is_mobile_unique= '';
        if($result['status']=='true'){
        if ($this->input->post('dealership_contact_number') == $result['data']['dealership_contact']) {
            $is_mobile_unique = '|is_unique[crm_dealers.dealership_contact]';
        }
        }

        return $is_mobile_unique;
    }
    function checkOwnerNumberExists()
    {
        $userId      = $this->input->post("updateId");
        $mobile = $this->input->post("owner_contact_number");

        $is_mobile_unique = '';
        if(empty($userId)){
            $result = $this->crm_dealers->checkOwnerNumberExists($mobile);
        } else {
            $result = $this->crm_dealers->checkOwnerNumberExists($mobile, $userId);
        }
        if($result['status']=='true'){
        if ($this->input->post('owner_contact_number') == $result['data']['owner_mobile']) {
            $is_mobile_unique = '|is_unique[crm_dealers.owner_mobile]';
        }
        }
        return $is_mobile_unique;
    }
    
    function addNewDealer($id='')
    {   
       
          $updateId           = $this->input->post('updateId');
              
                $organization       = ucfirst(ucwords(strtolower($this->security->xss_clean($this->input->post('organization')))));
                $services           = $this->input->post('services');
                $paymentFavoring    = $this->security->xss_clean($this->input->post('payment_favoring'));
                $gstNumber          = $this->security->xss_clean($this->input->post('gst_number'));
                $dealerEmail        = strtolower($this->security->xss_clean($this->input->post('dealership_email')));
                $dealerNumber       = $this->security->xss_clean($this->input->post('dealership_contact_number'));
                
                
                
                $outletAddress      = $this->input->post('outlet_address');
                $city               = $this->input->post('city');
                $state              = $this->input->post('state');
                $assignUser         = $this->input->post('assignUser');
                
                $ownerName          = ucfirst(strtolower($this->input->post('owner_name')));
                $ownerMobile        = $this->input->post('owner_contact_number');
                
                $account_number    = $this->security->xss_clean($this->input->post('account_number'));
                $dealer_banks    = $this->security->xss_clean($this->input->post('dealer_banks'));
                $ifsc_code    = $this->security->xss_clean($this->input->post('ifsc_code'));
                $account_type    = $this->security->xss_clean($this->input->post('account_type'));
               // $dealer_type  = $this->security->xss_clean($this->input->post('dealer_type'));
                $d_type    = $this->security->xss_clean($this->input->post('dealer_type'));
                if($d_type=='1')
                {
                    $servi = '2';
                }
                else
                {
                    $servi = !empty($services)? implode(',',$services):'';
                }
                $dealerInfo = array(
                    'organization'      =>  addslashes($organization),
                    'dealership_email'  =>  $dealerEmail,
                    'dealership_contact'=>  $dealerNumber,
                    'services'          =>  $servi,
                    'payment_favoring'  =>  !empty($paymentFavoring)?ucwords($paymentFavoring):'',
                    'gst_number'        =>  !empty($gstNumber)?strtoupper($gstNumber):'',
                    'owner_name'        => ucwords($ownerName),
                    'owner_mobile'      => $ownerMobile,
                    'status'            =>  '1',
                    'user_id'           =>  $assignUser,
                    'account_number'    => !empty($account_number)?$account_number:'',
                    'dealer_banks'      => !empty($dealer_banks)?$dealer_banks:'',
                    'ifsc_code'         => !empty($ifsc_code)?strtoupper($ifsc_code):'',
                    'account_type'      => !empty($account_type)?$account_type:'',
                    //'dealer_id' => DEALER_ID,
                    'dealer_type'       => $d_type
                    
                    
                    );
                if(empty($updateId)){
                  $dealerInfo['created_date']  = date('Y-m-d H:i:s');
                  $dealerInfo['created_by']  = $this->session->userdata['userinfo']['id'];

                }else{
                  $dealerInfo['updated_date']  = date('Y-m-d H:i:s');
                  $dealerInfo['updated_by']  = $this->session->userdata['userinfo']['id']; 
                }
                if($dealerInfo){
                $this->load->model('crm_dealers');
                $basicResult = $this->crm_dealers->addNewDealer($dealerInfo,$updateId);
                if(DEALER_ID=='49'){
                    if(empty($updateId))
                    {
                        $is_sms = $this->renderOnboardingSms($dealerInfo,$ownerMobile,$basicResult);
                    }
                }
                }
                
                
                $outletInfo = [
                    'dealer_id'         => $basicResult,
                    'outlet_address'    => addslashes($outletAddress),
                    'city'              => $city,
                    'state'             => $state,
                    'status'            => '1',
                    'created_date'      => empty($updateId) ? date('Y-m-d H:i:s'):'',
                    'updated_date'      => !empty($updateId) ? date('Y-m-d H:i:s'):''
                ];
                
                if($outletInfo) {
                $this->load->model('crm_outlet');
                $outletResult = $this->crm_outlet->addOutlet($outletInfo,$updateId);
                }
                
                if($basicResult > 0)
                { 
                    redirect('/dealerListing');
                    
                }
                else
                {
                    $this->session->set_flashdata('error', 'Dealer creation failed');
                }
                if(!empty($updateId)){
                redirect('editDealer/'.base64_encode('dealerId_'.$updateId));
                }else{
                    redirect('addDealer');
                }
            //}
    }

    
    /**
     * This function is used load dealer edit information
     * @param number $dealerId : Optional : This is dealer id
     */
    function editDealer($dealerId = NULL)
    {
        $bankName           = $this->getcustomerBankList();
        //$bankName           = $this->Crm_banks->getBanklist();
        $editId  = !empty($dealerId)? explode('_',base64_decode($dealerId)):'';
        $id  = end($editId);
        if(!is_numeric($id))
            {
                redirect('dealerListing');
            }
            $data['dealerInfo'] = $this->crm_dealers->dealerListing($id,'','', '');
            $data['services']   = ['0'=>'loan','1'=>'insurance','2'=>'new_car','3'=>'used_car'];
            $data['stateList']  =  $this->state_list->getStateList();
             $data['userList']   =  $this->Crm_user->getEmployeeByTeam('Sales');
            //$data['userList']   =  $this->getUser();
            $data['cityList']   =  $this->getCityListByStateId($data['dealerInfo'][0]->state);
            $data['bankName']   = $bankName;
//echo '<pre>';print_r($data);die;
            $this->global['pageTitle'] = 'Edit Dealer';
            $this->loadViews("dealer/addNewDealer", $this->global, $data, NULL);
    }
    
    
    
    /**
     * This function is used to load the change password screen
     */
    function loadChangePass()
    {
        $this->global['pageTitle'] = 'Change Password';
        
        $this->loadViews("changePassword", $this->global, NULL, NULL);
    }
    
    
    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = '404 - Page Not Found';
        $this->loadViews("404", $this->global, NULL, NULL);
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
    
    function checkMobile(){
        $mobile      = $this->input->post('mobile');
        $updateId    = $this->input->post('updateId');
        $checkMobile = $this->crm_dealers->checkMobileExists($mobile,$updateId);
        echo json_encode($checkMobile);die;
    }
    function checkEmail(){
        $email       = $this->input->post('email');
        $updateId    = $this->input->post('updateId');
        $checkemail  = $this->crm_dealers->checkEmailExists($email,$updateId);
        echo json_encode($checkemail);die;
    }
    function checkOwnerMobile(){
        $mobile       = $this->input->post('mobile');
        $updateId    = $this->input->post('updateId');
        $checkMobile  = $this->crm_dealers->checkOwnerNumberExists($mobile,$updateId);
        echo json_encode($checkMobile);die;
    }
    
    public function getCityListByStateId($stateId){
       $this->db->select('city_id,city_name');
       $this->db->from('city_list');
       $this->db->where('state_id', $stateId);
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     

    }
    public function getUser(){
       $this->db->select('id,name,email');
       $this->db->from('crm_user');
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;      

    }
    
    
     public function activeInactiveDealer() {
        $error = array();
        $postData = $this->input->post();
        if (!empty($postData)) {
            $dealerData = $this->setDealerStatus($postData);
            return $dealerData;
        } else {
            $error[] = "Dealer Not Updated!";
        }
        return $error;
    }

    public function setDealerStatus($data = array()) {
        if (!empty($data)) {
            $id = $data['dealer_id'];
            if (trim($data['flag']) == 'deactivate') {
                $dataArray= ['status'=>'0'];
            } else if (trim($data['flag']) == 'activate') {
                $dataArray= ['status'=>'1'];
            }
            $result = $this->crm_dealers->updateDealerStatus($dataArray,$id);
        }
        echo $result;die;
    }


    public function dealerListing($invId='') {
        $page                  =   1;
        $limit                 =   10;
        $postdata              =   array();
        $datapost              =   $this->input->post();
        //print_r($params);die;
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
        $data['list'] = $this->crm_dealers->getdealerListingNew($datapost,$page,$limit);
        $perpagecnt = $this->crm_dealers->getdealerListingNew($datapost);
        $data['totalCnt'] =(!empty($perpagecnt)) ? count($perpagecnt) :0;
        $dealercnt = $this->crm_dealers->getdealerListingNew($datapost);
        $data['totalCount'] =(!empty($dealercnt)) ? count($dealercnt) :0;
        $data['employeeList'] =  $this->Crm_user->getEmployee('6','','Executive');
        $data['limit'] =(!empty($limit)) ? $limit :0;
        $data['page'] =(!empty($page)) ? $page :1;
        $this->global['pageTitle'] = 'Dealer Listing';
        $this->loadViews("dealer/dealerlisting", $this->global, $data, NULL);
    }
    
    public function ajax_dealer($invId='') {
        $pageNo                  =   1;
        $limit                 =   10;
        $postdata              =   array();
        $datapost              =   $this->input->post();
        //print_r($params);die;
        if(isset($datapost['data']) && trim($datapost['data']) != ''){
            $strdata              = str_replace('amp;', '', $datapost['data']);
            parse_str($strdata,$postdata);
            unset($datapost['data']);

            if(isset($postdata['source']) && trim($postdata['source']) != ''){
                $source = intval($postdata['source']);
            }

            foreach($postdata as $key => $val){
              $datapost[$key]    =   $val;
            }
            if(!empty($datapost['issearch']) && ($datapost['issearch']=='1')){
            $page=$pageNo;    
            }else{
            $page                   = $postdata['page'];
            }
            $is_search              = 1;
        }
        $data['list'] = $this->crm_dealers->getdealerListingNew($datapost,$page,$limit);
        $dealercnt = $this->crm_dealers->getdealerListingNew($datapost);
        $data['totalCount'] =(!empty($dealercnt)) ? count($dealercnt) :0;
        $data['limit'] =(!empty($limit)) ? $limit :0;
        $data['page'] =(!empty($page)) ? $page :1;
        $this->load->view('dealer/ajax_dealer',$data);
    }
    
    public function exportDealerExcel($id) {
        $datapost  = array();
        $datapost  = $this->input->get();
        $this->load->helpers('dealer_excel_helper');
        if (!empty ($id) && $id == '1') {
            $getDealers = $this->crm_dealers->getdealerexportListing($datapost);
            exportDealerData($getDealers);
            exit;
        }
        
    }

    public function renderOnboardingSms($dealerInfo,$ownerMobile,$dealer_id)
    {
        $markedby  = $this->Crm_user->getEmployee('',$this->session->userdata['userinfo']['id']);
        $mobile    = current($this->Loan_customer_info->getCustomerMobileNumber($loanData[0]['customer_id']));
        $content = "Welcome to Bir Motors,-NL2BR- -NL2BR-Dear ".ucwords(strtolower($dealerInfo['organization'])).', thanks for your association with us.-NL2BR--NL2BR-For any auto loan, refinance, purchase of new or used car, car insurance you can reach us on 9710021795 and 9710221795'; 
        $this->smsSent($ownerMobile,$content,$dealer_id,'','','',1);
        return 1;
    }

}


