<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * Author:vikas kumar
 */


class LeadSell extends MY_Controller {

    public function index() {
        
    }

    public function __construct() {
        parent::__construct();
        $this->dateTime=date("Y-m-d H:i:s");
        $this->load->model('Make_model');
        $this->load->model('Leadsellmodel');
         if(!$this->session->userdata['userinfo']['id']){
             return redirect('login');
            }
          //  error_reporting(0);
    }
    
    public function getSellerLeads()
     {
        $type=$this->input->post("type");
        $make = $this->Make_model->getCarMakeList();
        $getColorCar=$this->Leadsellmodel->getColorCar();
        //echo "<pre>";print_r($getColorCar);exit;
        $headerInfo=[
                  'pageTitle'=>'Seller Leads',
                  'type'     =>$type,
                  'make'     =>$make,
                  'color'   =>$getColorCar
                ];
            $this->loadViews('leadsell/list_seller_lead',$headerInfo);
     }
    public function ajaxSellLead()
    {
        //error_reporting(0);
        $exportdata=$this->input->get('exportdata');
        
        if($exportdata=='export'){
            $datapost=$this->input->get();
        }else{
           $datapost=$this->input->post();
        }
        $getLeads=$this->Leadsellmodel->getleadsQuery($datapost);
        $leadtabCounts=0;
        $headerInfo=[
                  'result'    => $getLeads,
                  'leadtabCount' => $leadtabCounts,
                  'request'      =>$datapost,
                  'Leadsellmodel'=>$this->Leadsellmodel,
                ];
       $this->load->view('leadsell/ajax_getSellerLeads',$headerInfo);
    }
    public function sellEnquiryRecordsCount()
    {
        $datapost=$this->input->post();
        $stats=current($this->Leadsellmodel->getSellerLeadCount($datapost));
        //echo "<pre>";print_r($stats);exit;
        echo ($stats['no_action_taken']>0?$stats['no_action_taken']:0)."||".($stats['today_follow_up']>0?$stats['today_follow_up']:0)."||".($stats['past_follow_up']>0?$stats['past_follow_up']:0)."||".($stats['alls']>0?$stats['alls']:0)."||".($stats['closed']>0?$stats['closed']:0)."||".($stats['converted']>0?$stats['converted']:0);
        exit;
        
    }
    
    public function add_seller_lead()
    {
        $datapost=$this->input->post();
        //echo "<pre>";print_r($datapost);exit;
       $chkValidateSellerAdd= $this->chkValidateSellerAdd($datapost);
       if($chkValidateSellerAdd){
           return $chkValidateSellerAdd;exit;
       }
        $dealer_id = DEALER_ID;
        $datapost['dealer_id']=$dealer_id;
        $follow_date='';
        if (trim($datapost['add_seller_follow_date'] != '')) {
            $follow_date = date('Y-m-d H:i:s', strtotime($datapost['add_seller_follow_date']));
        }
        else
        {
        $follow_date='0000-00-00 00:00:00';
        } 
        $datapost['follow_date']=$follow_date;
        $isClassified=$this->Leadsellmodel->isClassifieddealer($dealer_id);
        /*echo "<pre>";
        print_r($isClassified);
        exit;*/
       //if(!empty($isClassified[0]['id']) && $isClassified[0]['id'] >= 0){
        $results=json_encode($datapost);
        $sellDCData['dealer_id']=$dealer_id;
        $sellDCData['info']=$results;
        $url=API_URL."/api/sell_lead_verify_crm.php?method=addSellerLead&apikey=U3KqyrewdMuCotTS&info";
        $logdata['dealer_id']=$dealer_id;
        $logdata['requestdata']=$results;
        $logdata['add_date']=$this->dateTime;
        $lastLogid=$this->Leadsellmodel->addCrmDclogDetails($logdata);
        $dc_sell_customer_id=$this->sendLeadsToDC($sellDCData, $url);
        if(!empty($dc_sell_customer_id) && $dc_sell_customer_id!=''){
        $dclogdata['responsedata']=$dc_sell_customer_id;
        $dclogdata['update_date']=$this->dateTime;
        $this->Leadsellmodel->addCrmDclogDetails($dclogdata,$lastLogid);    
        $datapost['dcleadid']=$dc_sell_customer_id;
        }
        /*echo "<pre>";
        print_r($datapost);
        exit;*/
        $datapost['crm_customer_id'] = $this->crmCentralCustomer($datapost['add_seller_mobile'],'Seller');
        $sellCustomerId=$this->Leadsellmodel->setSellCustomer($datapost);
        $customerSeller=[];
        $customerSeller['name'] = $datapost['add_seller_name'];
        $customerSeller['customer_id'] = $datapost['crm_customer_id'];
        //$customerSeller[''] = $datapost['add_seller_mobile'];
        $customerSeller['email'] = $datapost['add_seller_email'];
        $customerSeller['name_type'] ='2';
        $this->addUpdateMasterCustomer($customerSeller);
        $this->Leadsellmodel->setSellCustomerComments($datapost,$sellCustomerId);
        $this->addupdateCentralStock($datapost,$sellCustomerId);
        $this->Leadsellmodel->setSellCustomerCarDetails($datapost, $sellCustomerId);
       // }
         
        if(!empty($sellCustomerId)){
           echo '<span class="success">Lead Added Successfully</span>'; die;
        }
    }

    public function addupdateCentralStock($datapost,$sellCustomerId)
    {
        //$count = count($datapost['add_seller_myear']);
        for($i=0;$i < count($datapost['add_seller_make']);$i++){
            $make = addslashes(trim($datapost['add_seller_make'][$i]));
            $model = addslashes(trim($datapost['add_seller_model'][$i]));
            $variant = addslashes(trim($datapost['add_seller_variant'][$i]));
            $myear = addslashes(trim($datapost['add_seller_myear'][$i]));
            $mmonth = addslashes(trim($datapost['add_seller_mmonth'][$i]));
            if($mmonth=='Jan')
            {
                $mm = '1';
            }
            if($mmonth=='Feb')
            {
                $mm = '2';
            }
            if($mmonth=='Mar')
            {
                $mm = '3';
            }
            if($mmonth=='Apr')
            {
                $mm = '4';
            }
            if($mmonth=='May')
            {
                $mm = '5';
            }
            if($mmonth=='Jun')
            {
                $mm = '6';
            }
            if($mmonth=='Jul')
            {
                $mm = '7';
            }
            if($mmonth=='Aug')
            {
                $mm = '8';
            }
            if($mmonth=='Sep')
            {
                $mm = '9';
            }
            if($mmonth=='Oct')
            {
                $mm = '10';
            }
            if($mmonth=='Nov')
            {
                $mm = '11';
            }
            if($mmonth=='Dec')
            {
                $mm = '12';
            }
            if ($make != '' && $model != '' && $variant != '' && $myear != '' && $mmonth != '') {
                $regno = addslashes(trim($datapost['add_seller_regno'][$i]));
                $km = addslashes(trim($datapost['add_seller_km'][$i]));
                $mmvids = $this->Leadsellmodel->getMakeModelVersionIds($make,$model,$variant);

                $make_id = $mmvids['make_id'];
                $model_id = $mmvids['model_id'];
                $version_id = $mmvids['version_id'];
                $carDetails=[];
                $carDetails['seller_id']=$sellCustomerId;
                $carDetails['myear']=(!empty($myear))?$myear:'0';
                $carDetails['mm']=(!empty($mm))?$mm:'0';
                $carDetails['reg_no']=(!empty($regno))?$regno:'';
                $carDetails['km']=(!empty($km))?$km:'';
                $carDetails['make_id']=(!empty($make_id))?$make_id:'0';
                $carDetails['model_id']=(!empty($model_id))?$model_id:'0';;
                $carDetails['version_id']=(!empty($version_id))?$version_id:'0';;
                $carDetails['first_car_type']= '2';
                $this->crmCentralStockData($carDetails,'Seller');
            }

        }

    }
    
    public function chkValidateSellerAdd($datapost) {
        $name = addslashes(trim($datapost['add_seller_name']));
        if ($name == '') {
            echo '<span class="error">Please Enter Name</span>';
            die;
        }
        if (preg_match('/([^a-zA-Z.\s])/', $name)) {
            echo '<span class="error">Special Characters or Digits are Not Allowed in Name</span>';
            die;
        }
        $email = !empty($datapost['add_seller_email'])?addslashes(trim($datapost['add_seller_email'])):'';

        $mobile = addslashes(trim($datapost['add_seller_mobile']));

        if ($mobile == '' || strlen($mobile) < 10 || !is_numeric($mobile) || !($mobile[0] == '6' || $mobile[0] == '7' || $mobile[0] == '8' || $mobile[0] == '9')) {
            echo '<span class="error">Please Enter a Valid Mobile Number</span>';
            die;
        }
        if(!empty($email)) {
            if (preg_match('/([^a-zA-Z0-9._@])/', $email)) {
                echo '<span class="error">Special Characters are Not Allowed in Email</span>';
                die;
            }
            $emailArr = explode("@", $email);
            $emailArr2 = explode(".", $emailArr[1]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || is_numeric($emailArr[0]) || is_numeric($emailArr2[0]) || is_numeric($emailArr2[1])) {
                echo '<span class="error">Please Enter Valid Email Address</span>';
                die;
            }
        }
        if ($datapost['add_seller_mmonth'][0] == '' || $datapost['add_seller_make'][0] == '' || $datapost['add_seller_model'][0] == '' || $datapost['add_seller_variant'][0] == '' || $datapost['add_seller_regno'][0] == '') {
            echo '<span class="error">Please Enter Car Details</span>';
            die;
        }
        if (trim($datapost['other_color'][0]) != '') {
            if (preg_match('/([^a-zA-Z.\s])/', $datapost['other_color'][0])) {
                echo '<span class="error">Special Characters or Digits are Not Allowed in other color</span>';
                die;
            }
        }

        if ($datapost['add_seller_price'][0] <= 10000) {
            echo '<span class="error">Please enter price greater than 10,000</span>';
            die;
        }

        if (preg_match('/([^a-zA-Z0-9\s])/', $datapost['add_seller_regno'][0])) {
            echo '<span class="error">Special Characters are Not Allowed in Reg No</span>';
            die;
        }
        if ($datapost['add_seller_km'][0] <= 1000) {
            echo '<span class="error">Please enter kms greater than 1,000</span>';
            die;
        }
    }
    
    public function sellEnqAddComment()
    {
        error_reporting(0);
        $datapost=$this->input->post();
        
        $chkValidateUpdateSeller=$this->chkValidateUpdateSeller($datapost);
        if($chkValidateUpdateSeller){
            return json_encode($chkValidateUpdateSeller);exit;
        }
        $comment = trim(addslashes($datapost['add_seller_comment']));
        $results=json_encode($datapost);
        $dealer_id = DEALER_ID;
        $sellDCData['dealer_id']=$dealer_id;
        $sellDCData['info']=$results;
        $url=API_URL."api/sell_lead_verify_crm.php?method=addSellerLead&apikey=U3KqyrewdMuCotTS&info";
        $logdata['dealer_id']=$dealer_id;
        $logdata['requestdata']=$results;
        $logdata['add_date']=$this->dateTime;
        $lastLogid=$this->Leadsellmodel->addCrmDclogDetails($logdata);
        $dc_sell_customer_id=$this->sendLeadsToDC($sellDCData, $url);
        if(!empty($dc_sell_customer_id) && ($dc_sell_customer_id!='')){
            $dc_sell_customer_id=str_replace('"',"",$dc_sell_customer_id);
            $datapost['dcleadid']=$dc_sell_customer_id;
        }
        $sellCustomerId=$this->Leadsellmodel->setSellCustomer($datapost);
        $this->Leadsellmodel->setSellCustomerComments($datapost,$sellCustomerId);
        //echo "<pre>";print_r(json_encode($sellCustomerId));exit;
        if($comment!='')
        {
        $getComment=$this->Leadsellmodel->getSellCustomerComments($sellCustomerId);
       //echo json_encode($sellCustomerId);
       $data=[
           'comment'=> $comment,
           'result' => $getComment,
           'id'     => $sellCustomerId
       ];
       $this->load->view('leadsell/sellEnqAddComment.php', $data);
        }else{
            echo '1';exit;
        }
    }
    
    public function chkValidateUpdateSeller($datapost)
    {
        $id = $datapost['id'];
        $status=$datapost['add_seller_status'];
        $save_popup = $datapost['save_popup'];
        $comment = trim(addslashes($datapost['add_seller_comment']));
        if(trim($datapost['follow_date']!='')){
	$follow_date = date('Y-m-d H:i:s',strtotime($datapost['follow_date']));
	if(strtotime(date('Y-m-d H:i:s'))>=strtotime($follow_date) && (in_array($status,array('Hot','Cold','Warm','WalkInScheduled','Evaluation Scheduled'))))
	{ 
		echo '<span class="error">Please Enter Future Follow Up Date</span>';die;
	}
        elseif(strtotime(date('Y-m-d H:i:s'))>=strtotime($follow_date) && $comment!=''){
            
            echo '<span class="error">Please Enter Future Follow Up Date</span>';die;
        }
	}
	
	$name = trim(addslashes($datapost['add_seller_name']));
	if($name==''){
		echo '<span class="error">Please Enter Name</span>';die;
	}
	if(preg_match('/([^a-zA-Z.\s])/', $name))
	{
		echo '<span class="error">Special Characters or Digits are Not Allowed in Name</span>';die;
	}
        if(isset($datapost['add_seller_email']) && trim($datapost['add_seller_email'])!=''){
	$email = trim(addslashes($datapost['add_seller_email']));
	if(preg_match('/([^a-zA-Z0-9._@])/', $email))
	{
		echo '<span class="error">Special Characters are Not Allowed in Email</span>';die;
	}
	$emailArr = explode("@",$email);
	$emailArr2 = explode(".",$emailArr[1]);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL) || is_numeric($emailArr[0]) || is_numeric($emailArr2[0]) || is_numeric($emailArr2[1]))
	{

		echo '<span class="error">Please Enter Valid Email Address</span>';die;
	}

        }
    }
    
    public function saveRetailPrice()
    {
        $datapost=$this->input->post();
        if($this->session->userdata['userinfo']['id']){
            $userid=$this->session->userdata['userinfo']['id'];
            $userType=$this->session->userdata['userinfo']['role_id'];
        }
        
        $data['user_id']          =  $userid;
        $data['user_type']        =  $userType;
        $data['quotePrice']       =  $datapost['quotePrice'];
        $data['sellCarId']        =  $datapost['sellCarId'];
        //$data['sell_customer_id'] =  $datapost['sell_customer_id'];
        $saveStatus=$this->Leadsellmodel->saveRetailPrice($data);
        return $saveStatus;
    }
    
    public function getScComments()
    {
        $datapost=$this->input->post();
        if($datapost['id']){
         $getComment=$this->Leadsellmodel->getSellCustomerComments($datapost['id']);
         $data=[];
         $data['result']=$getComment;
        $this->load->view('leadsell/getScComments.php', $data);
        }
    }
    
    public function getScMoreCars()
    {
        $datapost=$this->input->post();
        $moreCars=$this->Leadsellmodel->getScMoreCars($datapost['id']);
        $data=[];
        $data['result']=$moreCars;
        $this->load->view('leadsell/getScMoreCars.php', $data);
    }
    public function sendLeadsToDC($leaddata, $url) {
    if (isset($leaddata) && !empty($leaddata) > 0) {
        $vars='';
        foreach ($leaddata as $k => $v) {
            $vars .= '&' . $k . '=' . $v;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_POST, count($vars));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        $response = curl_exec($ch);
        return $response;
    }
    } 
}
