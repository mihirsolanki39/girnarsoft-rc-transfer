<?php

class MY_Controller extends CI_Controller
{
    //echo "esfserf"; exit;
   /**
     * This function used to load views
     * @param {string} $viewName : This is view name
     * @param {mixed} $headerInfo : This is array of header information
     * @param {mixed} $pageInfo : This is array of page information
     * @param {mixed} $footerInfo : This is array of footer information
     * @return {null} $result : null
     */

      public $global = array ();
    function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){
        $data=[];
        $data['userinfo']=$this->session->userdata('userinfo');
        $data['menu']=$this->menu_data();
       //print_r($data); exit;
        $this->load->view('includes/header.php', $headerInfo);
        $this->load->view('includes/menu.php', $data);
        if(isset($headerInfo['pageType']) && $headerInfo['pageType']=='loan' && $headerInfo['pageType']!='insurance'){
            $this->load->view("includes/loan_left_top.php", $headerInfo);   
        }else if(isset($headerInfo['pageType']) && $headerInfo['pageType']=='insurance'){
            $this->load->view("includes/insurance_left_top.php", $headerInfo);
        }else if(isset($headerInfo['pageType']) && $headerInfo['pageType']=='deliveryOrder'){
            $this->load->view("includes/delivery_left_top.php", $headerInfo);
        }else if(isset($headerInfo['pageType']) && $headerInfo['pageType']=='rcdetail'){
            $this->load->view("includes/rc_left_top.php", $headerInfo);
        }else if(isset($headerInfo['pageType']) && $headerInfo['pageType']=='advancebooking'){
            $this->load->view("includes/advbooking_left_top.php", $headerInfo);
        }else if(isset($headerInfo['pageType']) && $headerInfo['pageType']=='usedcarsale'){
            $this->load->view("includes/usedcar_left_top.php", $headerInfo);
        }
         else if(isset($headerInfo['pageType']) && $headerInfo['pageType']=='usedcarpurchase'){
            $this->load->view("includes/stock_left_top.php", $headerInfo);
        }
         else if(isset($headerInfo['pageType']) && $headerInfo['pageType']=='refurbworkshop'){
            $this->load->view("includes/refurb_left_top.php", $headerInfo);
        }else if(isset($headerInfo['pageType']) && $headerInfo['pageType']=='docmanager'){
            //$this->load->view("includes/insurance_left_top.php", $headerInfo);
        }
       // echo $pageInfo; exit;
        $this->load->view($viewName, $pageInfo);

        if(isset($headerInfo['pageType']) && ($headerInfo['pageType']=='loan' || $headerInfo['pageType']=='insurance' || $headerInfo['pageType']=='deliveryOrder')){
         $this->load->view("includes/loan_left_bottom.php", $headerInfo);   
        }
        $this->load->view('includes/bootmodels.php', $headerInfo);
        $this->load->view('includes/footer.php', $footerInfo);
    }
    public function __construct() {
        date_default_timezone_set('Asia/Kolkata');
        parent::__construct();       
        $dealer_id = (!empty($this->session->userdata['userinfo']['dealer_id'])) ? $this->session->userdata['userinfo']['dealer_id']:0 ;
        $organization = (!empty($this->session->userdata['userinfo']['organization'])) ? $this->session->userdata['userinfo']['organization']:0 ;
        $showroom_id = (!empty($this->session->userdata['userinfo']['default_showroom_id'])) ? $this->session->userdata['userinfo']['default_showroom_id']:0 ;
        $address = (!empty($this->session->userdata['userinfo']['address'])) ? $this->session->userdata['userinfo']['address']:0 ;
        $mobile = (!empty($this->session->userdata['userinfo']['mobile'])) ? $this->session->userdata['userinfo']['mobile']:'' ;
        $email = (!empty($this->session->userdata['userinfo']['email'])) ? $this->session->userdata['userinfo']['email']:'' ;
        //$dealer_id = '69';
            defined('DEALER_ID')   OR define('DEALER_ID',($dealer_id > 0)? $dealer_id: '69');
            defined('ORGANIZATION')   OR define('ORGANIZATION',(!empty($organization))? $organization:'');
             defined('DEALER_NAME')   OR define('DEALER_NAME',(!empty($organization))? $organization:'');
            defined('DEALER_ADDRESS')   OR define('DEALER_ADDRESS',(!empty($address))? $address:'');
            defined('DEALER_MOBILE')   OR define('DEALER_MOBILE',($mobile > 0)? $mobile: '');
            defined('MOBILESMS')   OR define('MOBILESMS',($mobile > 0)? $mobile: '');
            defined('DEALER_EMAIL')   OR define('DEALER_EMAIL',(!empty($email))? $email: '');
            $this->load->model('Crm_user');
            $this->load->model('Crm_rc');
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
            $this->config->load('utility_constants');
            $this->load->model('Crm_buy_customer_status');
            $this->load->model('Crm_buy_lead_customer');
            $this->load->model('Crm_rc');
            $this->load->model('Crm_lead_customer_detail');
            $this->load->model('Crm_buy_lead_customer_preferences');
            $this->load->model('Crm_buy_lead_addedit_log');
            $this->load->model('Crm_used_car_sale_case_info');

        }

        function paginationCompress($link, $count, $perPage = 10, $segment = SEGMENT) {
        $config ['base_url'] = base_url () . $link;
        $config ['total_rows'] = $count;
        $config ['uri_segment'] = $segment;
        $config ['per_page'] = $perPage;
        $config ['num_links'] = 5;
        $config ['full_tag_open'] = '<nav><ul class="pagination">';
        $config ['full_tag_close'] = '</ul></nav>';
        $config ['first_tag_open'] = '<li class="arrow">';
        $config ['first_link'] = 'First';
        $config ['first_tag_close'] = '</li>';
        $config ['prev_link'] = 'Previous';
        $config ['prev_tag_open'] = '<li class="arrow">';
        $config ['prev_tag_close'] = '</li>';
        $config ['next_link'] = 'Next';
        $config ['next_tag_open'] = '<li class="arrow">';
        $config ['next_tag_close'] = '</li>';
        $config ['cur_tag_open'] = '<li class="active"><a href="#">';
        $config ['cur_tag_close'] = '</a></li>';
        $config ['num_tag_open'] = '<li>';
        $config ['num_tag_close'] = '</li>';
        $config ['last_tag_open'] = '<li class="arrow">';
        $config ['last_link'] = 'Last';
        $config ['last_tag_close'] = '</li>';
    
        $this->pagination->initialize ( $config );
        $page = $config ['per_page'];
        $segment = $this->uri->segment ( $segment );
    
        return array (
                "page" => $page,
                "segment" => $segment
        );
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
    function menu_data()
    {
        $mainMenu = [];
        $subMenu  = [];
        $this->load->model('Crm_user');
        $this->load->model('Rolemodel');
        $userinfo=$this->session->userdata('userinfo');
        $menu = $this->Crm_user->getHeaderByRole($userinfo['role_id'],'0');
        $i = 0;
        if(!empty($menu))
        {
            foreach ($menu as $key => $value)
            {
                //print_r($value);
                $mainMenu[$i]['menu'] = $value['menu'];
                $mainMenu[$i]['url']  = $value['menu_url'];
                $mainMenu[$i]['id'] = $value['headerid'];
                $mainMenu[$i]['status'] = $value['statue'];
                $subM = $this->Crm_user->getHeaderByRole($userinfo['role_id'],$value['headerid']);
                $j = 0;
                foreach ($subM as $skey => $svalue) 
                {
                   $mainMenu[$i]['sub'][$j]['menu'] = $svalue['menu'];
                   $mainMenu[$i]['sub'][$j]['url']  = $svalue['menu_url'];
                   $mainMenu[$i]['sub'][$j]['status'] = $svalue['statue'];
                   $j++;
                }
                $i++;
            }
           // exit;
        }
       return $mainMenu;
    }

    /* public function  sendSms($mobile,$message){
        $requestParams              = $this->input->post();
        $this->load->model('Crm_sms');
        $customermobile    = !empty($requestParams['mobile'])?$requestParams['mobile']:'';
        $requestType       = !empty($requestParams['message'])?$requestParams['message']:'';
        $case_id          = !empty($requestParams['case_id'])?$requestParams['case_id']:'';
        if (!empty($case_id)) {
            $response=$this->Loan_->getStockSMSData($car_id);
            if(!empty($response)){
            $renderSmsText = $this->Used_car_aditional_detail->renderCarShareSmsText($response, $car_id, $requestType);
                echo trim($renderSmsText);
                exit;
            }
        }
    }*/
    function smsSent($mobile,$message,$case_id='',$bank_id='',$smsType="",$smsReason="",$flag='')
    {
        //$mobile = '8826975366';
        $this->load->helper('curl');
        $mobile  = !empty($mobile)?$mobile:'';
        $smsText = !empty($message)?$message:'';
        if(!empty($mobile))
        {
            $curlRequest = curlPostData($mobile, $smsText, 'gaadi');
            if(empty($flag)){
                $this->load->model('Loan_customer_case');
                $insertLog = $this->Loan_customer_case->insertSmsLog($mobile,$smsText,$case_id,$bank_id,$smsType,$smsReason);
                if($curlRequest)
                {
                    $this->Loan_customer_case->insertSmsLog($mobile,$smsText,$case_id,$bank_id,$smsType,$smsReason,$insertLog,'1');
                }
            }
            else
            {   
                if($curlRequest)
                {
                    $this->load->model('Crm_dealers');
                    $this->Crm_dealers->dealerSmsLog($mobile,$message,$case_id);
                    $case['sms_sent'] = 1;
                    $this->Crm_dealers->addNewDealer($case,$case_id);
                    return true;
                }

            }
        }
        //return true;
    }
    
    function UserMgmtRole($id= '' ,$module='')
    {
        $this->load->model('Crm_user');
        $this->load->model('Rolemodel');
        $role_id = $this->session->userdata['userinfo']['role_id'];
        $role = $this->Crm_user->getRightsByRole($role_id,$module);
        if($role_id>0){
            $role['role_name'] = !empty($role[0]['role_name']) ? $role[0]['role_name'] :'';
            $role['role_id'] = $role_id;
        }
        else
        {
            $role[0]['role_name'] = 'admin';
            $role[0]['edit_permission'] = '1';
            $role[0]['add_permission'] = '1';
            $role[0]['view_permission'] = '1';
        }
        return $role;
    }

    function crmCentralStockData($data,$module='',$flag='')
    {
            if(!empty($data['loan_for']))
            {
                 $centralStock['loan_for']          = $data['loan_for'];
            }
            if(!empty($data['make_id']))
            {
                 $centralStock['make_id']          = $data['make_id'];
            }
            if(!empty($data['model_id']))
            {
                 $centralStock['model_id']          = $data['model_id'];
            }
            if(!empty($data['version_id']))
            {
                 $centralStock['version_id']          = $data['version_id'];
            }
            if(!empty($data['reg_no']))
            {
                 $centralStock['reg_no']          = $data['reg_no'];
            }
            if(!empty($data['engine_no']))
            {
                 $centralStock['engine_no']          = $data['engine_no'];
            }
            if(!empty($data['chassis_no']))
            {
                 $centralStock['chassis_no']          = $data['chassis_no'];
            }
            if(!empty($data['km']))
            {
                 $centralStock['km']          = $data['km'];
            }
            if(!empty($data['mm']))
            {
                 $centralStock['mm']          = $data['mm'];
            }
            if(!empty($data['myear']))
            {
                 $centralStock['myear']          = $data['myear'];
            }
            if(strtolower($module)=='insurance')
            {
                $centralStock['insurance_expire']  = date('Y-m-d',strtotime($data['insurance_expire']));

                if(!empty($data['insurance_case_id']))
                {
                    $centralStock['last_insurance_case_id'] = $data['insurance_case_id'];
                }
                if(!empty($data['insurance_customer_id']))
                {
                   $centralStock['last_insurance_customer_id'] = $data['insurance_customer_id']; 
                }
                
            }
            if(strtolower($module)=='loan')
            {
                if(!empty($data['loan_case_id']))
                {
                    $centralStock['last_loan_case_id'] = $data['loan_case_id'];
                }
                if(!empty($data['loan_customer_id']))
                {
                   $centralStock['last_loan_customer_id'] = $data['loan_customer_id']; 
                }
                //$centralStock['last_loan_case_id'] = !empty($data['loan_case_id'])?$data['loan_case_id']:'';
                //$centralStock['last_loan_customer_id'] = !empty($data['loan_customer_id'])?$data['loan_customer_id']:'';

            }
            if(strtolower($module)=='stock')
            {
                $centralStock['insurance_expire']    = !empty($data['insurance_expire'])?date('Y-m-d',strtotime($data['insurance_expire'])):'';
                if(!empty($data['cnt_id']))
                {
                    $centralStock['cnt_id']    = $data['cnt_id'];
                }
                if(!empty($data['buyer_id']))
                {
                    $centralStock['buyer_id'] = $data['buyer_id'] ; 
                }
                if(!empty($data['seller_id']))
                {
                    $centralStock['seller_id'] = $data['seller_id'] ; 
                }
                if($flag=='1')
                {
                    if(!empty($data['insurance_case_id']))
                    {
                        $centralStock['last_insurance_case_id'] = $data['insurance_case_id'];
                    }
                    if(!empty($data['insurance_customer_id']))
                    {
                       $centralStock['last_insurance_customer_id'] = $data['insurance_customer_id']; 
                    }
                }
            }
            if(strtolower($module)=='seller')
            {
                $centralStock['seller_id']    = !empty($data['seller_id'])?$data['seller_id']:'';
            }
            $centralStock['module'] = !empty($module)?$module:'';
            $this->load->model('Crm_stocks');
           
            $result = $this->Crm_stocks->crmCentralStock($centralStock);
            return $result;
    }
    
    function getCentralStockDetails($reg_no='',$engno='',$chasno='',$flag='')
    {
        $this->load->model('Crm_stocks');
        $data = [];
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
        $result = $this->Crm_stocks->getCrmCentralStock($data);
        if($flag=='')
        {
           echo json_encode($result); exit;  
        }
        else
        {
           return  $result;
        }
           
    }

    function crmCentralCustomer($cust,$module='')
    {
        $data = [];
        $this->load->model('Loan_customer_info');
        $data['mobile'] = $cust['mobile'];
        $data['module'] = $module;
        $check = $this->Loan_customer_info->getCustomersMobile($data['mobile']);
        if(empty($check))
        {
            $customer_id = $this->Loan_customer_info->insertCustomersMobile($data);
        }
        else
        {
            $customer_id =  $check[0]['id'];
        }
        
        return $customer_id;
    }

    function addUpdateMasterCustomer($params,$id="",$module='')
    {
        $this->load->model('Loan_customer_info');
        $data = [];
        if(isset($params['customer_id']))
        {
            $crm = $this->Loan_customer_info->getMasterCustomerDetails($params['customer_id']);
            $data['customer_id'] = $params['customer_id'];
        }
        if(empty($id))
        {
            if(!empty($crm))
            {
                $id = $crm[0]['customer_id'];
            }
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
        if(isset($params['address']))
        {
            $data['address'] = $params['address'];
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
        $data['last_updated_by_module'] = $module;
        if($id=='')
        {
            $data['created_on']  = date('Y-m-d H:i:s');
            $data['created_by_module'] = $module;
            $this->Loan_customer_info->updateMasterCustomerDetails($data);
        }
        else
        {
            $this->Loan_customer_info->updateMasterCustomerDetails($data,$id); 
        }

        return true;
    }

    function getcustomerBankList($id='',$ids=[],$flag='')
    {
        $this->load->model('Crm_banks');
        $res = $this->Crm_banks->getcustomerBankList($id,$ids);
        if(empty($flag))
        {
            return $res;
        }
        else
        {
            echo json_encode($res); exit;
        }
 
    }

    function getDealerAdminByDealerId($dealer_id)
    {
        $this->load->model('Crm_dealers');
        $result = $this->Crm_dealers->getDealerAdmin($dealer_id);
        return $result;
    }
    function saveCheckList($checklist,$case_id)
    {
       
        $checkPost = explode('&', $checklist);
        $i = 0;
        foreach ($checkPost as  $value) {
            $tag = explode('_', $value);
            $data = explode('=', $tag[1]);
            if(!empty($data[0]))
            {
                $tag_id[$i]['tag_id'] = $data[0];
                $tag_id[$i]['doc_type'] = '7';
                $tag_id[$i]['case_id'] = $case_id;
                $tag_id[$i]['status'] =  $data[1] ;
                $i++;
            }
        }
        $this->Crm_upload_docs_list->saveCheckLists($tag_id,$case_id);
    }
    function saveCheckListData($checklist,$case_id,$doc_type)
    {
        $i = 0;
        $checklist_data=[];
        foreach ($checklist as $key=> $value) {
            $tag = explode('_', $key);
            $tag_id = $tag[1];
           
                $checklist_data[$i]['tag_id'] = $tag_id;
                $checklist_data[$i]['doc_type'] = $doc_type;
                $checklist_data[$i]['case_id'] = $case_id;
                $checklist_data[$i]['status'] =  $value ;
                $i++;
        }
        
        return $this->Crm_upload_docs_list->saveCheckLists($checklist_data,$case_id);
    }

    function getModelComm($makeId,$flag='') {
        $make    = $makeId;
        $getMakeNameById=[];
        $getMakeNameById = $this->Make_model->getMakeNameBymakeId($make);
        $makeName=isset($getMakeNameById[0]['make']) ? $getMakeNameById[0]['make'] : '';
        $result  = $this->Make_model->getCarModelList($makeName,'all');
        if(!empty($flag))
        {
            $option  = "<option value='' >Select Model</option>";
            foreach ($result as $ModelKey => $ModelValue) {
                $option .="<option value='" . $ModelValue['id'] . "' >" . $ModelValue['model'] . "</option>";
            }
            return $option;
        }
        else
        {
            return $result;
        }
        
    }
    function getVersionComm($make,$model,$flag='',$flag2='',$year='') {
        // $flag       = '1';
        //$models =  $this->Make_model->getParentModel($model,'1');
        $models = $model;
        $models=str_replace(',',"','",$models);

        $fields     = "db_version_id,db_version,uc_fuel_type,Displacement";
        $sqlJoin    = " ";
        $where      = $sqlJoin." WHERE model_version.mk_id = '".$make."' AND model_version.model_id in ('".$models."') ";
        $orderBy    = "uc_fuel_type";
        $versionListArr =array();
        $versionListArr  =  $this->UserDashboard->getCarVersionList($make,'used',$fields,$orderBy,$where,$year);
        if(!empty($flag))
        {
            $versionListArr  =  $this->UserDashboard->getCarVersionList($make,'all',$fields,$orderBy,$where,$year);
        }
        if(!empty($flag2))
        {
            $option  = "<option value='' >Select Version</option>";
            foreach ($versionListArr as $ModelKey => $ModelValue) {
                $option .="<option value='" . $ModelValue['db_version_id'] . "' >" . $ModelValue['db_version'] . "</option>";
            } 
            return $option;
        }
        else
        {
            return $versionListArr;   
        }      
    }

    function getMakeModelNameComm($myear='')
    {
       return $result =  $this->Make_model->getMakeModelDuoName($myear);
       /*$option  = "<option value='' >Select Version</option>";
            foreach ($result as $ModelKey => $ModelValue) {
                $option .="<option rel='".$ModelValue['make_id']."'  value='" . $ModelValue['model_id'] . "' >" . $ModelValue['make'] .' '. $ModelValue['model']. "</option>";
            } 
            echo   $option;*/
    }
    
    function add_new_lead($requestData = [],$source='')
    {
        //echo "<pre>";print_r($requestData);exit;
        $this->load->helper('crm_helper');
        //$requestParams = $this->input->post();
        
        if (empty($requestData))
        {
            $requestParams = $this->input->post();
        }
        else
        {
            $requestParams = $requestData;
        }
        
        //echo "<pre>";print_r($requestParams);die;
        $leadDataPost = $requestParams;
        $arrMsg       = array();
        $appDetail    = array();
        $userName     = (!empty($requestParams['txtname'])) ? $requestParams['txtname'] : '';

        if (empty($requestParams['dcsync']))
        {
            $requestParams['ucdid'] = DEALER_ID;
            $dealerId               = DEALER_ID;
        }
        else
        {
            $dealerId = $requestParams['ucdid'];
        }


        if (!empty($requestParams['lead_status']))
        {
            $requestParams['cusstatus']  = $requestParams['lead_status'];
            $requestParams['dcusstatus'] = $requestParams['lead_status'];
        }
        if (!empty($requestParams['mobile']))
        {
            $requestParams['txtmobile'] = $requestParams['mobile'];
        }
        if (!empty($requestParams['comment']))
        {
            $leadDataPost['txtcomment'] = $requestParams['comment'];
        }
        if (!empty($requestParams['name']))
        {
            $leadDataPost['txtname'] = $requestParams['name'];
        }
        $statusId = '';
        if (!empty($requestParams['cusstatus']))
        {
            $customerStatus = $this->Crm_buy_customer_status->mappOldToNew($requestParams['cusstatus']);
            $statusId       = $customerStatus['statusId'];
        }
        $statusName = $customerStatus['status_name'];
        if (empty($leadDataPost['followdate']) || $leadDataPost['followdate'] == '1970-01-01 01:00:00')
        {
            $leadDataPost['followdate'] = '';
        }
        $mobile      = !empty($leadDataPost['txtmobile']) ? $leadDataPost['txtmobile'] : '';
        $followDatee = strtotime(date("Y-m-d H:i:s", strtotime($leadDataPost['followdate'])));
        if (!empty($leadDataPost['dfollowdate']))
        {
            $dfollowDatee = strtotime(date("Y-m-d H:i:s", strtotime($leadDataPost['dfollowdate']))); //previous follw date
        }
        else
        {
            $dfollowDatee = '';
        }
        $leadDataPost['cusstatus']     = !empty($leadDataPost['cusstatus']) ? $leadDataPost['cusstatus'] : '';
        $dcusstatus                    = !empty($requestParams['dcusstatus']) ? $requestParams['dcusstatus'] : '';
        $leadDataPost['txtcomment']    = !empty($leadDataPost['txtcomment']) ? $leadDataPost['txtcomment'] : '';
        $validate_status_by_followDate = $this->Crm_buy_customer_status->validate_status_by_followDate($dcusstatus, $dfollowDatee, $leadDataPost['cusstatus'], $followDatee, $leadDataPost['txtcomment']);
        if ($validate_status_by_followDate == 1)
        {
            // echo "sssss";
            //echo '1';exit;
        }

        $requestParams['mobile']                       = !empty($leadDataPost['txtmobile']) ? $leadDataPost['txtmobile'] : '';
        $requestParams['name']                         = !empty($leadDataPost['txtname']) ? $leadDataPost['txtname'] : '';
        $requestParams['email']                        = !empty($leadDataPost['txtemail']) ? $leadDataPost['txtemail'] : '';
        $requestParams['car_id']                       = !empty($leadDataPost['gaadi_id']) ? $leadDataPost['gaadi_id'] : '';
        $requestParams['ucdid']                        = $dealerId;
        $requestParams['comment']                      = !empty($leadDataPost['txtcomment']) ? $leadDataPost['txtcomment'] : '';
        $requestParams['lead_alternate_mobile_number'] = !empty($leadDataPost['cd_alternate_mobile']) ? $leadDataPost['cd_alternate_mobile'] : '';
        $requestParams['budget']                       = !empty($leadDataPost['price_max']) ? $leadDataPost['price_max'] : '';
        $requestParams['lead_source']                  = !empty($leadDataPost['lead_source']) ? $leadDataPost['lead_source'] : '';
        if (!empty($leadDataPost['followdate']))
        {
            $requestParams['next_follow'] = date("Y-m-d H:i:s", strtotime($leadDataPost['followdate']));
        }


        //$data['ldm_walkin_date']    = $requestParams['walkinDate'];
        //$data['ldm_follow_date']    = $requestParams['next_follow'];
        if (empty($requestParams['lead_status']))
        {
            $requestParams['lead_status'] = !empty($leadDataPost['cusstatus']) ? $leadDataPost['cusstatus'] : '';
        }
        $requestParams['sub_source']  = 'self';
        $requestParams['locality_id'] = !empty($leadDataPost['locality_id']) ? $leadDataPost['locality_id'] : '';
        $requestParams['dcsync']      = !empty($leadDataPost['dcsync']) ? $leadDataPost['dcsync'] : '';

        if (isset($requestParams['txtemail']) && $requestParams['txtemail'] != '')
        {
            $chkemailVaild = chkEmailVaild($requestParams['txtemail']);
            if ($chkemailVaild == '1')
            {
                $requestParams['txtemail'] = '';
            }
        }
        $chkValidationInput = $this->chkValidationInput($requestParams);
        if ($chkValidationInput)
        {
            return $chkValidationInput;
        }

        if (isset($requestParams['rating']))
        {
            $data['ldm_lead_rating'] = $requestParams['rating'];
        }

        //$statusId                      = isset($requestParams['statusId'])?$requestParams['statusId']:'';
        $data['status_name'] = !empty($statusName) ? $statusName : '';
        $data['lead_source'] = $requestParams['lead_source'];


        $mobile                      = substr(trim($requestParams['txtmobile']), -10);
        $data['mobile']              = preg_replace("/[^0-9]/", "", $mobile);
        $custo_id                    = $this->crmCentralCustomer($data['mobile'], 'Buyer Lead');
        $data['city_id']             = isset($requestParams['city_id']) ? $requestParams['city_id'] : '';
        $data['location_id']         = isset($requestParams['locality_id']) ? $requestParams['locality_id'] : '';
        $data['gaadi_verified']      = isset($requestParams['gaadi_verified']) ? $requestParams['gaadi_verified'] : '';
        $data['opt_verified']        = isset($requestParams['otp_verified']) ? $requestParams['otp_verified'] : '';
        $data['is_finance']          = isset($requestParams['is_finance']) ? $requestParams['is_finance'] : '';
        $data['lead_score']          = isset($requestParams['lead_score']) ? $requestParams['lead_score'] : '';
        $data['central_customer_id'] = !empty($custo_id) ? $custo_id : '';

        $leadCustomerId = $this->Leadmodel->BuyLeadCustomer($data);

        $data['ldm_customer_id'] = $leadCustomerId;
        if (!empty($requestParams['txtname'])):
            $data['ldm_name'] = preg_replace("/[^a-zA-Z\s]/", "", $requestParams['txtname']);
        endif;

        $data['ldm_email']      = isset($requestParams['txtemail']) ? $requestParams['txtemail'] : '';
        $altmobile              = isset($requestParams['cd_alternate_mobile']) ? substr(trim($requestParams['cd_alternate_mobile']), -10) : '';
        $data['ldm_alt_mobile'] = preg_replace("/[^0-9]/", "", $altmobile);
        $data['ldm_alt_email']  = isset($requestParams['alt_email']) ? $requestParams['alt_email'] : '';
        /* if(isset($requestParams['lead_status']) && $requestParams['lead_status']!='')
          {
          $data['ldm_status_id']      = $statusId;
          } */
        $data['ldm_status_id']  = $statusId;
        if ($requestParams['next_follow'])
        {
            $getCustomerFollow = $this->Crm_buy_lead_customer->getCustomerFollow($requestParams, $statusId);
            if (isset($getCustomerFollow['ldm_walkin_date']) && $getCustomerFollow['ldm_walkin_date'])
            {
                $data['ldm_walkin_date'] = isset($getCustomerFollow['ldm_walkin_date']) ? $getCustomerFollow['ldm_walkin_date'] : '';
            }
            if (isset($getCustomerFollow['ldm_follow_date']) && $getCustomerFollow['ldm_follow_date'])
            {
                $data['ldm_follow_date'] = isset($getCustomerFollow['ldm_follow_date']) ? $getCustomerFollow['ldm_follow_date'] : '';
            }
        }
        $data['ldm_source']      = isset($requestParams['lead_source']) ? $requestParams['lead_source'] : '';
        $data['ldm_sub_source']  = isset($requestParams['sub_source']) ? $requestParams['sub_source'] : '';
        $data['ldm_location_id'] = isset($requestParams['locality_id']) ? $requestParams['locality_id'] : '';
        if (!empty($requestParams['total_assign_lead']))
        {
            $data['ldm_total_assign_lead'] = isset($requestParams['total_assign_lead']) ? intval($requestParams['total_assign_lead']) : '';
        }
        if ($data['status_name'] && (strtolower($requestParams['lead_source']) == 'self' || strtolower($requestParams['sub_source']) == 'self' || $requestParams['sub_source'] == 'Mobile'))
        {
            if (isset($requestParams['booking_amount']) && $requestParams['booking_amount'])
            {
                $data['ldm_amount'] = isset($requestParams['booking_amount']) ? $requestParams['booking_amount'] : '';
                $data['ldm_car_id'] = isset($requestParams['car_id']) ? $requestParams['car_id'] : '';
            }
            else if (isset($requestParams['sale_amount']) && $requestParams['sale_amount'])
            {
                $data['ldm_amount'] = isset($requestParams['sale_amount']) ? $requestParams['sale_amount'] : '';
                $data['ldm_car_id'] = isset($requestParams['car_id']) ? $requestParams['car_id'] : '';
            }
            else if (isset($requestParams['offer_amount']) && $requestParams['offer_amount'])
            {
                $data['ldm_amount'] = isset($requestParams['offer_amount']) ? $requestParams['offer_amount'] : '';
                $data['ldm_car_id'] = isset($requestParams['car_id']) ? $requestParams['car_id'] : '';
            }
            else
            {
                $data['ldm_amount'] = '0';
                $data['ldm_car_id'] = '0';
            }
        }
        $data['user_id'] = isset($this->session->userdata['userinfo']) ? $this->session->userdata['userinfo']['id'] : '';
        $dId             = DEALER_ID; //isset($this->session->userdata['userinfo'])?$this->session->userdata['userinfo']['id']:'';

        $logSourceType           = '';
        $data['log_source_type'] = $logSourceType;


        $data['repeat_car_id']    = isset($requestParams['car_id']) ? $requestParams['car_id'] : '';
        $data['only_update_flag'] = isset($requestParams['only_update_flag']) ? $requestParams['only_update_flag'] : '';

        $data['ldm_dealer_id'] = $requestParams['ucdid'];
        //echo "<pre>";print_r($data);exit;
        //insert update in buy_lead_dealer_mapper table
        $dealersClassified     = $this->Leadmodel->getclassifiedDealers($dealerId);
        $dcdata                = [];
        /*
          if(!empty($requestParams) && empty($requestParams['dcsync'])){
          //if($dealersClassified[0]['is_classified'] > 0){
          //$dcdata['buyer_case_id']     = $leadmapperId;
          $dcdata['customer_name']   = $requestParams['name'];
          $dcdata['customer_mobile']   = $requestParams['mobile'];
          $dcdata['dc_dealer_id']      = $requestParams['ucdid'];
          $dcdata['customer_email']    = $requestParams['email'];
          $dcdata['comment']           = $requestParams['comment'];
          $dcdata['lead_alternate_mobile_number']=$requestParams['lead_alternate_mobile_number'];
          $dcdata['budget']            = $requestParams['budget'];
          $dcdata['lead_source']       = $requestParams['lead_source'];
          $dcdata['next_follow']       = $requestParams['next_follow'];
          $dcdata['lead_status']       = $requestParams['lead_status'];
          $dcdata['sub_source']        = $requestParams['sub_source'];
          $dcdata['locality_id']       =$requestParams['locality_id'];
          $dcdata['city_id']           =!empty($requestParams['city_id']) ? $requestParams['city_id']:'';
          $dcdata['gaadi_verified']    =!empty($requestParams['gaadi_verified']) ? $requestParams['gaadi_verified']:'';
          $dcdata['opt_verified']      =!empty($requestParams['opt_verified']) ? $requestParams['opt_verified']:'';
          $dcdata['is_finance']        =!empty($requestParams['is_finance']) ? $requestParams['is_finance']:'';
          //$dcdata['lead_created_date']    = $this->dateTime;
          if ($data['status_name'] && (strtolower($requestParams['lead_source']) == 'self' || strtolower($requestParams['sub_source']) == 'self' || $requestParams['sub_source'] == 'Mobile')) {
          if (isset($requestParams['booking_amount']) && $requestParams['booking_amount']) {
          $dcdata['booking_amount'] = isset($requestParams['booking_amount'])?$requestParams['booking_amount']:'';
          $dcdata['car_id'] = isset($requestParams['car_id'])?$requestParams['car_id']:'';
          } else if (isset($requestParams['sale_amount']) && $requestParams['sale_amount']) {
          $dcdata['sale_amount'] = isset($requestParams['sale_amount'])?$requestParams['sale_amount']:'';
          $dcdata['car_id'] = isset($requestParams['car_id'])?$requestParams['car_id']:'';
          } else if (isset($requestParams['offer_amount']) && $requestParams['offer_amount']) {
          $dcdata['offer_amount'] = isset($requestParams['offer_amount'])?$requestParams['offer_amount']:'';
          $dcdata['car_id'] = isset($requestParams['car_id'])?$requestParams['car_id']:'';
          } else {
          $dcdata['ldm_amount'] = '0';
          $dcdata['ldm_car_id'] = '0';
          }
          }
          //print_r($dcdata);die;

          if($dcdata['lead_status'] == 'Walk-in Scheduled')
          {
          $dcdata['lead_status'] = "Walk In";
          }
          else if ($dcdata['lead_status'] == 'Walk-in Done')
          {
          $dcdata['lead_status'] = "Walked In";
          }
          $dcjsonData=json_encode($dcdata);
          $leadData['info']=$dcjsonData;

          //$url              = API_URL . "api/buyer_lead_verify_crm.php?apikey=U3KqyrewdMuCotTS&method=addBuyerLead";
          //$sent_time        = date('Y-m-d H:i:s');

          //$dcresponse       = $this->Leadmodel->sendLeadsToDC($leadData, $url);
          //LOG
          $response_json=json_decode($dcresponse,true);
          $this->Leadmodel->api_log([
          'sync_module'   => 'lead',
          'reference_id'  => $response_json['lead_results'][0]['lead_id'],
          'api_url'       => $url,
          'source'       =>  'crm',
          'dealer_id'     => DEALER_ID,
          'request'       => $dcjsonData,
          'response'      => $dcresponse,
          'status'        => strtoupper($response_json['lead_results'][0]['status']),
          'added_by'      => $this->session->userdata['userinfo']['id'],
          'sent_time'     => $sent_time,
          'response_time' => date('Y-m-d H:i:s'),
          ]);

          //}
          }
         */
        if (!empty($requestParams['dcleadid']))
        {
            $data['dcleadid'] = isset($requestParams['dcleadid']) ? $requestParams['dcleadid'] : '';
        }
        else
        {
            $data['dcleadid'] = isset($dcleadId) ? $dcleadId : '';
        }
        //print_r($data);die;
        $leadmapperId = $this->Leadmodel->setBuyLeadDealerMapper($data, $data['user_id']);


        if ($statusId == 12)
        {
            $leadMapperidss            = $leadmapperId['lead_dealer_mapper_id'];
            $leadData                  = $this->Leadmodel->getBuyLeadsForRc($leadMapperidss);
            $rcdata['buyer_case_id']   = $leadData[0]['leadId'];
            $rcdata['customer_mobile'] = $leadData[0]['customer_mobile'];
            $rcdata['customer_id']     = $leadData[0]['customer_id'];
            $rcdata['reg_no']          = $leadData[0]['reg_no'];
            $rcdata['customer_name']   = $leadData[0]['customer_name'];
            $rcdata['customer_email']  = $leadData[0]['customer_email'];
            $rcdata['make_id']         = $leadData[0]['make_id'];
            $rcdata['model_id']        = $leadData[0]['model_id'];
            $rcdata['version_id']      = $leadData[0]['version_id'];
            $rcdata['reg_year']        = $leadData[0]['reg_year'];
            $carImage                  = $this->Crm_rc->setRcCarDetail($rcdata);
        }
        if (isset($requestParams['locality_id']) && intval($requestParams['locality_id']) > 0)
        {
            $this->Crm_lead_customer_detail->updateLocation($data['mobile'], $dId, $requestParams['locality_id']);
        }

        $data['lc_comment']               = !empty($requestParams['comment']) ? $requestParams['comment'] : '';
        $data['lc_lead_dealer_mapper_id'] = !empty($leadmapperId['lead_dealer_mapper_id']) ? $leadmapperId['lead_dealer_mapper_id'] : '';
        $data['lc_follow_date']           = !empty($data['ldm_follow_date']) ? $data['ldm_follow_date'] : '';
        $data['lc_status_id']             = $statusId;
        $data['lc_source']                = !empty($requestParams['lead_source']) ? $requestParams['lead_source'] : '';
        $data['lc_sub_source']            = !empty($requestParams['sub_source']) ? $requestParams['sub_source'] : '';

        $this->Crm_buy_lead_customer->saveCustomerCarLead($leadmapperId['lead_dealer_mapper_id'], $requestParams);
        if (!empty($requestParams['lognew']))
        {
            $leadmapid   = $leadmapperId['lead_dealer_mapper_id'];
            $leadappData = $this->Leadmodel->getBuyLeadsForRc($leadmapid);
            //print_r($leadappData);die;
            if (!empty($leadappData))
            {
                $logdata['leadId']    = $leadappData[0]['leadId'];
                $logdata['name']      = $leadappData[0]['customer_name'];
                $logdata['email']     = $leadappData[0]['customer_email'];
                $logdata['mobile']    = $leadappData[0]['customer_mobile'];
                $logdata['carid']     = $leadappData[0]['carId'];
                $logdata['date_time'] = $this->dateTime;
                //$logId                = $this->Leadmodel->setleadlogCarDetail($logdata);
            }
        }


        if (!empty($requestParams['lead_source']))
        {
            if ((strtolower($requestParams['lead_source']) == 'zigwheels' 
                    || strtolower($requestParams['lead_source']) == 'self' 
                    || strtolower($requestParams['lead_source']) == 'gaadi' 
                    || strtolower($requestParams['lead_source']) == 'cardekho' || strtolower($requestParams['lead_source']) == 'website'
                    || strtolower($requestParams['lead_source']) == 'dealerapp') 
                    /*&& !empty($requestParams['car_id']) && intval($requestParams['car_id']) > 0*/){
                $autoPrefillingPreferences = $this->Crm_buy_lead_customer_preferences->autoPrefillingPreferences($leadmapperId['lead_dealer_mapper_id']);
                $requestParams['makeIds']  = !empty($autoPrefillingPreferences['make_id']) ? $autoPrefillingPreferences['make_id'] : '';
                $requestParams['modelIds'] = !empty($autoPrefillingPreferences['model_id']) ? $autoPrefillingPreferences['model_id'] : '';
                $requestParams['budget']   = !empty($autoPrefillingPreferences['car_price']) ? $autoPrefillingPreferences['car_price'] : '';
            }
        }
        $preferId = $this->Leadmodel->AddEditLeadPreferences($requestParams, $leadmapperId['lead_dealer_mapper_id']);

        $data['car_id']         = !empty($requestParams['car_id']) ? $requestParams['car_id'] : '';
        $data['call_type']      = !empty($requestParams['call_type']) ? $requestParams['call_type'] : '';
        $data['call_duration']  = !empty($requestParams['call_duration']) ? $requestParams['call_duration'] : '';
        $data['shared_item']    = !empty($requestParams['shared_item']) ? $requestParams['shared_item'] : '';
        $data['shared_by']      = !empty($requestParams['shared_by']) ? $requestParams['shared_by'] : '';
        $data['booking_amount'] = !empty($requestParams['booking_amount']) ? $requestParams['booking_amount'] : '';
        $data['sale_amount']    = !empty($requestParams['sale_amount']) ? $requestParams['sale_amount'] : '';
        $data['offer_amount']   = !empty($requestParams['offer_amount']) ? $requestParams['offer_amount'] : '';
        $data['feedback']       = !empty($requestParams['feedback']) ? $requestParams['feedback'] : '';
        $data['leadmapperId']   = !empty($leadmapperId['lead_dealer_mapper_id']) ? $leadmapperId['lead_dealer_mapper_id'] : '';
        $data['feedback_id']    = !empty($requestParams['feedback_id']) ? $requestParams['feedback_id'] : '';
        $data['comment_type']   = !empty($requestParams['feedback_id']) ? $requestParams['feedback_id'] : ''; //changes comment source only


        if (!empty($leadmapperId['leadadd']) && $leadmapperId['leadadd'] == 'add')
        {
            $data['ldm_status_id'] = '1';
            $data['status_name']   = 'New';
        }
        else if (!empty($leadmapperId['leadadd']) && $leadmapperId['leadadd'] == 'follow')
        {
            $data['ldm_status_id'] = '2';
            $data['status_name']   = 'Follow Up';
        }
        //echo "<pre>";print_r($data);exit;
        $this->Crm_buy_lead_history_track->trackAllHistory($data, $logSourceType);
        $outPutData           = array();
        $outPutData['error']  = "";
        $outPutData['status'] = "T";
        if (!empty($requestParams['method']) && $requestParams['method'] == 'leadadd')
        {
            $returnData               = array();
            $returnData['android_id'] = 1;
            $returnData['error']      = "";
            $returnData['lead_id']    = !empty($leadmapperId['lead_dealer_mapper_id']) ? $leadmapperId['lead_dealer_mapper_id'] : '';
            $returnData['msg']        = "Lead Added";
            $returnData['status']     = "T";
            if (!empty($leadmapperId['lead_dealer_mapper_id']) && $leadmapperId['lead_dealer_mapper_id'] > 0)
            {
                $outPutData['lead_results'] = [$returnData];
            }
            else
            {
                $outPutData['lead_results'] = [];
            }
        }
        else
        {
            $outPutData['msg'] = "lead edited successfully";
        }
        if (!$requestParams['lead_source'])
        {
            $data['ldm_source'] = !empty($requestParams['sub_source']) ? $requestParams['sub_source'] : '';
        }
        $this->Crm_buy_lead_addedit_log->insertEditlog($data, $requestParams, $outPutData);
        
        /*
         * SYNC FROM CRM TO DC
         */
        if (empty($requestParams['dcsync']))
        {
            $this->Leadmodel->crmToDcLeadSync($filter_data = [
                'dealer_id' => DEALER_ID,
                'ldm_id'    => $leadmapperId['lead_dealer_mapper_id'],
            ]);
        }
        /*
         * LOG DATA FROM DC TO CRM
         */
        else{
            
            $this->assignLeadToUser($leadmapperId['lead_dealer_mapper_id']);
            
            $log_data=[
                'sync_module'   => 'lead',
                'lead_id'       => $leadmapperId['lead_dealer_mapper_id'],
                'api_url'       => '',
                'source'        => 'dc',
                'dealer_id'     => $requestParams['ucdid'],
                'reference_lead_id' => $requestParams['lead_id'],
                'reference_log_id'  => $requestParams['ref_log_id'],
                'request'           => json_encode($requestParams),
                'response'          => json_encode($outPutData),
                'status'            => strtoupper($outPutData['lead_results'][0]['status']) == 'T' ? 'T' : 'F',
                'response_time'     => date('Y-m-d H:i:s'),
                'added_by'          => $requestParams['ucdid'],
                'sent_time'         => date('Y-m-d H:i:s'),
            ];
            $log_id=$this->Leadmodel->api_log($log_data);
            $outPutData['log_id'] = $log_id;
            return json_encode($outPutData);
        }
        if (!empty($requestParams['gaadi_id']) && empty($source))
        {
            $booking_form_url               = $this->getBookingFormURL($requestParams['gaadi_id'],$leadmapperId['lead_dealer_mapper_id']);
            $outPutData['booking_form_url'] = $booking_form_url;
        }
        if($source=='uc_sale_booking'){
            return $outPutData;
        }
        echo json_encode($outPutData);
        die;
    }
    public static function chkValidationInput($requestParams)
    {
        $mobile = preg_replace("/[^0-9]/", "", trim($requestParams['txtmobile']));
        $mobile = substr($mobile, -10);
        if (!empty($requestParams['cd_alternate_mobile']))
        {
            $altMobile = substr(trim($requestParams['cd_alternate_mobile']), -10);
            $altMobile = preg_replace("/[^0-9]/", "", $altMobile);
        }
        else
        {
            $altMobile = '';
        }
        $email    = (!empty($requestParams['txtemail']) ? $requestParams['txtemail'] : '');
        $dealerId = isset($requestParams['ucdid']) ? intval($requestParams['ucdid']) : '';
//        if ($dealerId == 0) {
//            return array('status' => 'T', 'msg' => 'Dealer Not Valid', 'error' => '');
//        }
        if ($mobile == '' || strlen($mobile) < 10 || !is_numeric($mobile))
        {
            return array('status' => 'T', 'msg' => 'Please Enter a Valid Mobile Number.', 'error' => '');
        }

        if ($altMobile != '')
        {
            if (strlen($altMobile) < 10 || !is_numeric($altMobile))
            {
                return array('status' => 'T', 'msg' => 'Please Enter a Valid Alt Mobile Number.', 'error' => '');
            }
        }
    }
    public function assignLeadToUser($lead_id)
    {
        $assignRuleResult = $this->Crm_lead_assign_rule->getLeadRuleData();
        $leadBasicData    = $this->Leadmodel->getLeadBasicDate($lead_id);
        $rule             = isset($assignRuleResult[0]['rule_type']) ? $assignRuleResult[0]['rule_type'] : '';
        if (!empty($rule) && empty($leadBasicData['assigned_to']) 
        /*&& in_array(strtolower($leadBasicData['ldm_source']), ['zigwheels', 'gaadi', 'cardekho'])*/)
        {

            if ($rule == 1)
            {
                $leadCarDetails = $this->Leadmodel->getLeadLatestCar($lead_id);
                //$search_value   = !empty($leadCarDetails['car_price'])?$leadCarDetails['car_price']:0;
                $search_value   = !empty($leadCarDetails['car_price'])?$leadCarDetails['car_price']:(!empty($leadBasicData['car_price'])?$leadBasicData['car_price']:0);

            }
            else if ($rule == 2)
            {
                $search_value = date('d', strtotime($leadBasicData['ldm_created_date']));
            }
            $ruleData = $this->Crm_lead_assign_rule->getUserRuleMapping($search_value);
            if (!empty($ruleData))
            {
                $this->db->where('ldm_id', $lead_id);
                $this->db->update('crm_buy_lead_dealer_mapper', ['assigned_to' => $ruleData['user_id']]);
            }
        }
    }
    public function getBookingFormURL($car_id,$lead_id)
    {

        $caseData = $this->Crm_used_car_sale_case_info->getUcSalesCaseByCarid($car_id);
        $case_id              = $caseData['id'];
        $salesCaseDetails     = $this->Crm_used_car_sale_case_info->getSalesStatus($case_id);
        //print_r($caseData);die;
        
        $this->db->select('ldm_id,ldm_status_id,ldm_email,ldm_name,lc.mobile');
        $this->db->from('crm_buy_lead_dealer_mapper ldm');
        $this->db->join('crm_buy_lead_customer lc','ldm.ldm_customer_id=lc.id','left');
        $this->db->where('ldm_id', (int)$lead_id);
        $query  = $this->db->get();
        $leadData= $query->row_array();
        
        $lead_name= $leadData['ldm_name'];
        $lead_email= $leadData['ldm_email'];
        $lead_mobile= $leadData['mobile'];
        
        //booked lead
        if($leadData['ldm_status_id']==11 || empty($case_id)){
         return base_url() . 'addUcBuyerLead/'.base64_encode($car_id.'_'.$case_id).'/?mobile='.$lead_mobile.'&name='.$lead_name.'&email='.$lead_email;
        }
        //converted lead
        if($leadData['ldm_status_id']==12){
         return $this->crm_stocks->getUcSalesEditLink($salesCaseDetails, $car_id, $case_id);
        }
        //print_r($salesCaseDetails);die;
        //$sales_edit_form_link = $this->crm_stocks->getUcSalesEditLink($salesCaseDetails, $car_id, $case_id);
       
        //return $sales_edit_form_link;
    }
    
}
    
