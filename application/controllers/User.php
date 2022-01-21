<?php
require APPPATH . '/libraries/BaseController.php';
class User extends MY_Controller
{
    function __construct()
    {
             parent::__construct();
             $this->load->model('Usermodel');
             $this->load->model('loan_customer_case');
             
             $this->load->helper('form');
             $this->load->library('pagination');
             $this->load->model('Crm_banks_List');
              $this->load->helper('url');  
               if(!$this->session->userdata['userinfo']['id']){
             return redirect('login');
            }
    }

    
	public function userList()
	{
        $params = array();
        
        $searchText          = $this->input->post();
        $params['searchText']  = $searchText;
        $pages                  =   1;
        $params['page'] = 1;
        $params['limit']                 =   10;
        $params['pageTitle'] = 'Employee Listing';
        $params['title'] = 'Employee Listing';
        $params["results"] = [];
        $count = 0;
       // $pages          = trim($this->input->post('page'));
        $teams   = $this->Usermodel->getTeams();
        $arr   = $this->Usermodel->get_current_page_records('',$searchText,$pages);
        $arr_count   = $this->Usermodel->get_current_page_records('',$searchText,$pages,1);
        if(!empty($arr)){
            $count = count($arr);
        }
        //$returns = $this->paginationCompress("userList/".$searchText, $count, $limit_per_page);
        $params["results"] = $arr;
        $params['teams'] = $teams;
        $params["total_count"] = $arr_count;
        
	    $this->loadViews('employee/view_user',$params);
	}
        public function ajax_userList()
	{
            $params = array();

            $postdata          = $this->input->post();
           // $params['searchText']  = $searchText;
            
            $params['page'] = 1;
            $params['limit']   =   10;
            $params['pageTitle'] = 'Employee Listing';
            $params['title'] = 'Employee Listing';
            $params["results"] = [];
           
            $count = 0;
            $pages          = trim($this->input->post('page'));
            if(empty($pages))
                $pages = 1;
            if(empty($pages))
                 $pages = 1;
             $params['page'] = $pages;
            $arr   = $this->Usermodel->get_current_page_records('',$postdata,$pages);
            $arr_count   = $this->Usermodel->get_current_page_records('',$postdata,$pages,1);
            if(!empty($arr)){
                $count = count($arr);
            }
            $params["results"] = $arr;
            $params["total_count"] = $arr_count;
            echo $datas=$this->load->view('employee/ajax_view_user',$params,true); exit;
	}
        
        function addNew($dealerId=null)
        {
            $data['banksname'] = $this->Usermodel->getBank();
            $data['team']      =  $this->Usermodel->team();
            $data['dealer']      =  $this->Usermodel->dealer();
            $data['loan_bank_limit'] = $this->loan_customer_case->getDealerAdmin();
            $data['bank_count']= count($data['banksname']);
            $data['pageTitle'] = 'Add New User';
            $data['adminDealer'] = $this->getDealerAdminByDealerId(DEALER_ID);
            //echo "<prE>";print_r($data);die;
            $this->loadViews("employee/add_user",$data);
        }
        
    function checkEmailExists($userId)
    {
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->Usermodel->checkEmailExists($email);
        } else {
            $result = $this->Usermodel->checkEmailExists($email, $userId);
        }
        $is_email_unique='';
        if($result['status']=='true'){
        if ($this->input->post('email') == $result['data']['email'])
        {
            $is_email_unique = '|is_unique[crm_user.email]';
        }
        }
        return $is_email_unique;
    }
    
    function checkMobileExists($userId)
    {
        $mobile = $this->input->post("mobile");

        if(empty($userId)){
            $result = $this->Usermodel->checkMobileExists($mobile);
        } else {
            $result = $this->Usermodel->checkMobileExists($mobile, $userId);
        }
        $is_mobile_unique= '';
        if($result['status']=='true'){
        if ($this->input->post('mobile') == $result['data']['mobile']) {
            $is_mobile_unique = '|is_unique[crm_user.mobile]';
        }
        }

        return $is_mobile_unique;
    }
    public function password_check($str)
    {
       if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
         return TRUE;
       }
       return FALSE;
    }    

    function addUser($userId=NULL)
    {        
       // echo "<pre>";print_r($_POST);die;
        $response = array();
        $id = '';
        if(!empty($userId)){
        $editId  = !empty($userId)? explode('_',base64_decode($userId)):'';
        $id  = end($editId);
        }
        $arr['banksname'] = $this->Usermodel->getBank();
        $arr['bank_count'] = count($arr['banksname']); 
        $checkEmail        = $this->checkEmailExists($id);
        $checkMobile       = $this->checkMobileExists($id);
        $this->load->model('Usermodel');
        $arr['team'] =  $this->Usermodel->team(); 
        $arr['loan_bank_limit'] = $this->loan_customer_case->getDealerAdmin();
        $arr['dealer'] =  $this->Usermodel->dealer();    
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="">', '</div>');
    	$this->form_validation->set_rules('name', 'Name',  array('required','trim'));
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]'."'$checkEmail'");
        $this->form_validation->set_rules('mobile', 'mobile', 'required|min_length[10]|max_length[10]|regex_match[/^[6-9][0-9]{9}$/]'."'$checkMobile'");
        $this->form_validation->set_rules('password', 'password', 'required|min_length[8]|callback_password_check');
        $this->form_validation->set_rules('team_id', 'Team Id', 'required');
        $this->form_validation->set_rules('role_id', 'Role Id', 'required');
        $this->form_validation->set_message('password_check', 'Password should be alphanumeric');
        if($this->form_validation->run() == FALSE){ 
            validation_errors('<div class="error">', '</div>');
            $error = validation_errors();
            $response = array('status'=>0, "message"=>$error); 
             echo json_encode($response);  die;  
        }
        else {
            $arr['banksname'] = $this->Usermodel->getBank();
            $arr['bank_count'] = count($arr['banksname']); 
            $dataArr = $this->input->post();
            if ($id == '') {
                $dataArr['status']='1';
                $res = $this->Usermodel->add_user($dataArr);                
            } else {               
                $dataArr['limits'] = str_replace(',', '',$dataArr['limits']);              
                $res = $this->Usermodel->add_user($dataArr, $this->input->post('id'));
            }
            if($res > 0){ 
              $response = array('status'=>1,"message"=>'');
            }else{
                $response = array('status'=>0, "message"=>'User creation failed');
            }
              echo json_encode($response);  die;      
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
    function edit($userId = NULL)
        {
           // echo DEALER_ID; exit;
        $editId  = !empty($userId)? explode('_',base64_decode($userId)):'';
        $id  = end($editId);
        if($id == null)
            {
                redirect('user');
            }
            $data['empInfo']   = $this->Usermodel->getEditUser($id);
            $data['banksname'] = $this->Usermodel->getBank();
            $data['team']      =  $this->Usermodel->team();
            $data['dealer']      =  $this->Usermodel->dealer();
            $data['bank_count']= count($data['banksname']); 
            $data['loan_bank_limit'] = $this->loan_customer_case->getDealerAdmin();
            $data['role']      =  $this->Usermodel->role($data['empInfo'][0]['team_id']);
            $data['adminDealer'] = $this->getDealerAdminByDealerId(DEALER_ID);
            $this->global['pageTitle'] = 'Edit Employee Details';
            //echo "<pre>";
           // print_r($data);
           // exit;
            $this->loadViews("employee/add_user", $this->global, $data, NULL);
    }
    function edit_user($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        return TRUE;
    }

    function getRole()
    {
        $data = $this->input->post();
        $this->load->model('Usermodel');
        $role =  $this->Usermodel->role($data['teamId']);
       echo json_encode($role);exit;
      
    }   
    function getBankOptions()
    {
        $data = $this->input->post();
        $this->load->model('Usermodel');
        $getSelectedBank = !empty($data['bank'])?$data['bank']:'';
        $bank =  $this->Usermodel->getBank($getSelectedBank);
        $response =[];
        foreach ($bank as $key=>$value){
            if(is_numeric($value->bank_id)){
            $bankName  = $this->Crm_banks_List->crmBankName($value->bank_id);
            $response[$key]['bank_name'] = !empty($bankName[0]->bank_name)?$bankName[0]->bank_name:'';
            }
            $response[$key]['id']   = !empty($bankName[0]->id)?$bankName[0]->id:'';
        }
        $option= "<option value='' >Select Bank</option>";
       foreach ($response as $key => $value) {
           if(!empty( $value['bank_name'])){
            $option .="<option value='" . $value['id'] . "' >" . $value['bank_name'] . "</option>";
           }
        }
        echo $option;
        //echo json_encode($response);exit;
    }
    public function activeInactiveEmp()
    {
        $response = array();
        $postData = $this->input->post();
        $postedData = array(
            'status' => $postData['status'],
            'updated_date' => date('Y-m-d h:i:s')
        );
        $id=$this->input->post('id');
        if (!empty($postData)) {
            $roleData = $this->Usermodel->updateEmpStatus($postedData,$id);
            $response[] = $roleData; 
        } else {
            $response[] = "Employee Not Updated!";
        }
        echo json_encode($response); exit;
    }

    public function getBankLimit()
    {
        $error = array();
        $id=$this->input->post('bank_id');
        $editid=$this->input->post('edit_id');
        $editid  = !empty($editid)? explode('_',base64_decode($editid)):'';
        $bankLimit = $this->Usermodel->getBankLimit($id,end($editid));
        return $bankLimit; 
    }

    public function EmployeeListing($invId='') {
        $this->loadViews("employee/employee-listing", $this->global, $data, NULL);
    }
    
    public function getUserRoleByTeam(){
       $team_id=$this->input->post('id');
       $teams   = $this->Usermodel->getRoleByTeamID($team_id);
       $response = array("status"=>1,"data"=>$teams);
       echo json_encode($response);
    }
}
