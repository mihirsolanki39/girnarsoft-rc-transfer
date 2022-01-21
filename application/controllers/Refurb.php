<?php

class Refurb extends MY_Controller {
    public $activity_mapping = array('New' => '1', 'Follow Up' => '2', 'Quotes shared' => '3','Closed' => '4');

    public function index() {
    }

    public function __construct() {
        parent::__construct();
        $this->load->model('Crm_user');
        $this->load->model('Crm_renew');
        $this->load->model('Crm_refurb_workshop');
        $this->load->model('Crm_insurance');
        $this->load->model('Crm_banks');
        $this->load->helpers('range_helper');
        if(!$this->session->userdata['userinfo']['id']){
             return redirect('login'); 
        }
    }

    public function RenewLeadIndex() {
      $data                      = [];
      $this->global['pageTitle'] = 'CodeInsect : Add Lead';
      $data['maxPriceArr']       = array('0' => 'Price Min','25000'=>'25,000','50000'=>'50,000','75000'=>'75,000','100000' => '1 Lakh','125000' => '1.25 Lakh','150000' => '1.5 Lakh','175000' => '1.75 Lakh','200000' => '2 Lakh','225000' => '2.25 Lakh','250000' => '2.5 Lakh','275000' => '2.75 Lakh','300000' => '3 Lakh','325000' => '3.25 Lakh','350000' => '3.5 Lakh','375000' => '3.75 Lakh','400000' => '4 Lakh','425000' => '4.25 Lakh','450000' => '4.5 Lakh','475000' => '4.75 Lakh','500000' => '5 Lakh','550000' => '5.5 Lakh','600000' => '6 Lakh','650000' => '6.5 Lakh','700000' => '7 Lakh','750000' => '7.5 Lakh','800000' => '8 Lakh','850000' => '8.5 Lakh','900000' => '9 Lakh','950000' => '9.5 Lakh','1000000' => '10 Lakh','1100000' => '11 Lakh','1200000' => '12 Lakh','1300000' => '13 Lakh','1400000' => '14 Lakh','1500000' => '15 Lakh','1600000' => '16 Lakh','1700000' => '17 Lakh','1800000' => '18 Lakh','1900000' => '19 Lakh','2000000' => '20 Lakh','2500000' => '25 Lakh','3000000' => '30 Lakh','4000000' => '40 Lakh','5000000' => '50 Lakh','7500000' => '75 Lakh','10000000' => '1 Crore','30000000' => '3 Crore');
      $data['statusData']        = $this->Crm_buy_customer_status->getCustomerStatus(['1','2','13']);
      $data['makeList']          = $this->Make_model->getCarMakeList('used');
      $data['getDeatCarFuelArr'] = array('Petrol','Diesel','CNG','LPG','Hybrid','Electric');
      $locpost['ucdid']          = DEALER_ID;
      $data['localityData']      = $this->Ublms_locations->getdealerlocality($locpost);
      $this->loadViews("renew/add_buyer_lead", $this->global, $data, NULL);
    }

    public function get_refurblist()
    {
        $is_admin              =   $this->session->userdata['userinfo']['is_admin'];
        $dealerId              =   DEALER_ID;
        $postdata              =   array();
        $datapost              =   $this->input->post();
        
        $datapost['ucdid']     =   DEALER_ID;
        $userId                =   $this->session->userdata['userinfo']['id'];
        $datapost['userId']    =   $userId;
        //$datapost = explode('&', $dataposts['data']);
        $is_search             =   0;
        $source                =   1;
        $page                  =   1;
        $limit                 =   10;
        $w_id                  =   '';
        /*echo "<pre>";
        print_r($datapost);
        exit;*/
        if(isset($datapost['source']) && is_numeric($datapost['source']) && intval($datapost['source']) > 0){
            $source = intval($datapost['source']);
        }

        if(isset($datapost['w_id']) && is_numeric($datapost['w_id']) && intval($datapost['w_id']) > 0){
            $w_id = intval($datapost['w_id']);
        }
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

            $services_array = ['1'=>'Denting','2'=>'Painting','3'=>'Washing','4'=>'Engine Repair','5'=>'AC Repair'];
            $datapost['source'] = '1';
            $datapost['flag'] = '1';
            $caseList              =   $this->Crm_refurb_workshop->getCaseList($datapost,$page,$limit,$dealerId);
            $totalcount              =   $this->Crm_refurb_workshop->getCaseList($datapost,'','',$dealerId);

            $headerInfo=[
                  'caseList'    => $caseList,
                  'totalCount' => count($totalcount),
                  'page' => $page,
                  'limit'=>$limit,
                  'services_array' =>$services_array
                ];
                $this->load->view('refurb/get_refurblist',$headerInfo);
    }
    public function refurblistingnew()
    {
      $is_admin=$this->session->userdata['userinfo']['is_admin'];
      $dealerId           = DEALER_ID;
      if($this->input->get("type")){
          $type=$this->input->get("type");
      }else{
          $type=$this->input->post("type");
      }
      $refurbtabCounts=$this->Crm_refurb_workshop->leadTabCounts($datapost,$dealerId);
      $totalcnt=!empty($refurbtabCounts) ? count($refurbtabCounts):0;
      $headerInfo=[
            'pageTitle'=>'Refurb',
            'is_admin' => $is_admin,
            'totalcase' => $totalcnt  
          ];
      //echo '<pre>';print_r($headerInfo);die; 
      $this->loadViews('refurb/listrefurb',$headerInfo);
    }       

    public function ajax_getRefurbnew()
    {
      $is_admin=$this->session->userdata['userinfo']['is_admin'];
      $dealerId=DEALER_ID;
      $datapost=$this->input->post();
      $datapost['ucdid']=DEALER_ID;
      $userId=$this->session->userdata['userinfo']['id'];
      $datapost['userId']=$userId;
      $ptype=isset($datapost['ptype']) ? $datapost['ptype']:'';
      $tabCounts=$this->Crm_refurb_workshop->leadTabCounts($datapost,$dealerId);
      $getCases= $this->Crm_refurb_workshop->getCaseList($datapost,$dealerId,$userId);

      $headerInfo=[
                'query'    => $getCases,
                'renewtabCount' => $tabCounts,
                'lead_status' => '',
                'is_admin' => $is_admin,
                'ptype' => $ptype,
                'type' => $this->input->post('type')
              ];
      $this->load->view('refurb/ajax_refurb',$headerInfo);
    }
    
    public function refurblist(){
      //error_reporting(E_ALL);
      $is_admin           = $this->session->userdata['userinfo']['is_admin'];
      $dealerId           = DEALER_ID;

      $type               = 1;
      if($this->input->get("type")){
        $type             = $this->input->get("type");
      }

      /*$refurbtabCounts    = $this->Crm_refurb_workshop->leadTabCounts($datapost,$dealerId);
      $totalcnt           = !empty($refurbtabCounts) ? count($refurbtabCounts):0;*/

      $headerInfo=[
          'pageTitle' =>'View Refurb Cases',
          'is_admin'  => $is_admin,
          'type'      => $type  
      ];

      $this->loadViews('refurb/refurblisting',$headerInfo); 
    }

    public function ajax_getRefurb(){
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

        $refurbtabCounts       =   $this->Crm_refurb_workshop->leadTabCounts($datapost,$dealerId);
        $totalCount            =   !empty($refurbtabCounts) ? count($refurbtabCounts):0;
        $caseList              =   $this->Crm_refurb_workshop->getCaseList($datapost,$page,$limit,$dealerId);
        /*$i= 0 ;
        foreach ($caseList as $key => $value) {
          $caseList[$i]['estimated_amt'] = $this->IND_money_format($caseList[$i]['estimated_amt']);
          $caseList[$i]['total_amount'] = $this->IND_money_format($caseList[$i]['total_amount']);
          $i++;
        }*/
        $headerInfo=[
                  'caseList'    => $caseList,
                  'totalCount'  => $totalCount,
                  'is_admin'    => $is_admin,
                  'source'      => $source,
                  'page'        => $page,
                  'limit'       => $limit,
                  'is_search'   => $is_search
                ];
        $this->load->view('refurb/ajax_refurblisting',$headerInfo);
    }
    
    public function get_history() {
        $datapost              =   $this->input->post();
        $historyList           =   $this->Crm_refurb_workshop->getRefurbHistoryList($datapost);
        $headerInfo=['historyList' => $historyList];
        $this->load->view('refurb/get_history',$headerInfo);
    }

    public function make_payment(){
        
      $datapost  = $this->input->post();
      $banklist = $this->Crm_banks->getcustomerBankList();
      $workshop_id  = !empty($datapost['w_id'])?$datapost['w_id']:$datapost['workshop_id'];
         
       $flag='';
       if(!empty($datapost['type']) && $datapost['module'] =='refublist_module'){
           
          $summary              =   $this->Crm_refurb_workshop->getPaymentSummary($workshop_id);
          $bankArray            =   [];
           
          foreach($banklist as $ckey => $cval){ 
              $bankArray[$cval['bank_id']] = $cval['bank_name'];
            }
            
            $paymentDetails_data =   $this->Crm_refurb_workshop->getPaymentList($workshop_id,$bankArray,'');
            
             $car_ids_array_paid = array();
            
             if(!empty($paymentDetails_data)){
                 foreach($paymentDetails_data as $values){
                
                        foreach($values['car_ids'] as  $ids){
                            $paymentDetailss[$ids]  =   $ids;
                        }
                    }
                $car_ids_array_paid =  array_keys($paymentDetailss);
            }            
            //Get all stock lists
            $caseList = $this->Crm_refurb_workshop->getStocksList($datapost,'','',$car_ids_array_paid);
            //echo "<pre>";print_r($caseList);die;
          
      }elseif(!empty($datapost['module']) && $datapost['module'] == 'payment_details_1' && empty($datapost['type'])){
         
         
          
          $summary              =   $this->Crm_refurb_workshop->getPaymentSummary($workshop_id);
          $bankArray            =   [];
          
          foreach($banklist as $ckey => $cval){ 
              $bankArray[$cval['bank_id']] = $cval['bank_name'];
            }            
            //Get all payment list
            $paymentDetails_data =   $this->Crm_refurb_workshop->getPaymentList($workshop_id,$bankArray,'');
            
             $case_ids_array_paid = array();
            
             if(!empty($paymentDetails_data)){
                 foreach($paymentDetails_data as $values){                
                        foreach($values['refurb_case_ids'] as  $ids){                           
                            $paymentDetailss[$ids]  =   $ids;
                        }
                    }
                $case_ids_array_paid =  array_keys($paymentDetailss);
            }
            $caseList = $this->Crm_refurb_workshop->getStocksList($datapost,DEALER_ID,'',$case_ids_array_paid);
          
      }else{
          
          $workshop_id =       !empty($datapost['workshop_id'])? $datapost['workshop_id']:'';
          $payment_id =       !empty($datapost['w_id'])? $datapost['w_id']:'';
          
          //$summary              =   $this->Crm_refurb_workshop->getPaymentSummary($workshop_id);
          $bankArray            =   [];
          
          foreach($banklist as $ckey => $cval){ 
              $bankArray[$cval['bank_id']] = $cval['bank_name'];
            }

            //Get all payment list
          $paymentDetails_data_edit =   $this->Crm_refurb_workshop->getPaymentList($workshop_id,$bankArray,'',$payment_id);
          //echo "<pre>";print_r($paymentDetails_data);die;
          $car_ids_array_paid = array();
            
             if(!empty($paymentDetails_data)){
                 foreach($paymentDetails_data as $values){                
                        foreach($values['car_ids'] as  $ids){                           
                            $paymentDetailss[$ids]  =   $ids;
                        }
                    }
                $car_ids_array_paid_seperate =  array_keys($paymentDetailss);
            }
          
          $flag='new';
          $caseList = $this->Crm_refurb_workshop->getStocksList($datapost,DEALER_ID,$flag);
      }
      
       $summary = !empty($summary)?$summary:'';      
       $headerInfo=['workshop_id' => $workshop_id, 
                    'banklist' => $banklist,
                    'summary' => $summary,
                    'paymentDetails'    => !empty($paymentDetails_data_edit)?current($paymentDetails_data_edit):array(),
                    'caseList'=>$caseList,
                    'flag'=>$flag,
                    'car_ids_get'=> !empty($car_ids_array_paid_seperate)?$car_ids_array_paid_seperate:'',
                    'module' => !empty($datapost['module'])?$datapost['module']:''
           ];
        // echo "<pre>";print_r($headerInfo);
         $this->load->view('refurb/makenew_payment',$headerInfo);
    }

    public function save_payment(){
      $datapost              = $this->input->post();
      //echo "<pre>";print_r($datapost);die;
      $count = count($datapost['verified']);
      $data = [];
      foreach ($datapost['verified'] as $key => $value) {
        $arr = explode('@',$value);
        $data['car_id'][] = $arr[0];
        $data['refurb_case_id'][] = $arr[1];
      }
     
      $data['counter'] = $datapost['counter'];
      $data['total_amount'] = $datapost['totamt'];
      $data['instrumenttype'] = $datapost['instrumenttype'];
      $data['amount'] = $datapost['amount'];
      $data['short_amount'] = $datapost['short_amount'];
      $data['paydates'] = $datapost['paydate'];
      $data['insno'] = $datapost['insno'];
      $data['insdate'] = $datapost['insdate'];
      $data['payment_bank'] = $datapost['payment_bank'];
      $data['favouring'] = $datapost['favouring'];
      $data['remark'] = $datapost['remark'];
      $data['workshop_id'] = $datapost['workshop_id'];
      $data['edit_id'] = $datapost['edit_id'];
      //echo "<pre>";print_r($data);die;
      $payment_id            = $this->Crm_refurb_workshop->managePayment($data);
      print json_encode(array('status' => 1, 'id' => $payment_id));
      exit;
    }

    public function workdetails(){
      $is_admin           = $this->session->userdata['userinfo']['is_admin'];
      $dealerId           = DEALER_ID;

      $w_id               = '';
      if($this->input->get("w_id")){
        $w_id             = $this->input->get("w_id");
      }

      $type               = 1;
      if($this->input->get("type")){
        $type             = $this->input->get("type");
      }

      $workshopDeatils    =   $this->Crm_refurb_workshop->getworkshoplist($w_id);

      $headerInfo=[
          'pageTitle' =>'Workshop history and Payment details',
          'is_admin'  => $is_admin,
          'type'      => $type,
          'w_id'      => $w_id,
          'w_details' => $workshopDeatils[0] 
      ];

      $this->loadViews('refurb/workdetails',$headerInfo); 
    }

    public function ajax_getPaymentAndStock()
     {
        
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
        $w_id                  =   '';
        
        //echo "<pre>";print_r($datapost);die;
        if(isset($datapost['source']) && is_numeric($datapost['source']) && intval($datapost['source']) > 0){
            $source = intval($datapost['source']);  
        }

        if(isset($datapost['w_id']) && is_numeric($datapost['w_id']) && intval($datapost['w_id']) > 0){
            $w_id = intval($datapost['w_id']);
        }      
        
        
        if(intval($source) == 1 && intval($w_id) > 0){
                     
          $summary              =   $this->Crm_refurb_workshop->getPaymentSummary($w_id);
          $banklist             =   $this->Crm_banks->getcustomerBankList();
          $bankArray            =   [];
          foreach($banklist as $ckey => $cval){ 
                     $bankArray[$cval['bank_id']] = $cval['bank_name'];
          }
          
         
          $paymentDetails       =   $this->Crm_refurb_workshop->getPaymentList('',$bankArray,$w_id);
          $caseList = $this->Crm_refurb_workshop->getStocksList($datapost,DEALER_ID);
          //echo "<pre>";print_r($paymentDetails);die;
          $headerInfo=[
                  'summary'           => $summary,
                  'paymentDetails'    => $paymentDetails,
                  'source'            => $source,
                  'caseList'          => $caseList,
                  'workshop'          => $datapost['w_id']
                ];
                
             // echo "<pre>";print_r($paymentDetails);die;
              $this->load->view('refurb/ajax_getpaymentandstock',$headerInfo);
        } 
        else 
        {  
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

                $page                   = $datapost['page'];
                $is_search              = 1;
            }

            $services_array = ['1'=>'Denting','2'=>'Painting','3'=>'Washing','4'=>'Engine Repair','5'=>'AC Repair'];
            $datapost['source'] = '1';
            $datapost['flag']   = '1';
            
            $caseList              =   $this->Crm_refurb_workshop->getCaseList($datapost,$page,$limit,$dealerId);
            $totalcount              =   $this->Crm_refurb_workshop->getCaseList($datapost,'','',$dealerId);
            //echo "<pre>";print_r($caseList);die;
            
            $headerInfo=[
                  'caseList'    => $caseList,
                  'totalCount' => count($totalcount),
                  'page' => $page,
                  'limit'=>$limit,
                  'services_array' =>$services_array
                ];
                $this->load->view('refurb/ajax_getstock',$headerInfo);
       
        }
    }
    
    public function ajax_paymentDetails(){
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
        $w_id                  =   $datapost['w_id'];
        $summary              =   $this->Crm_refurb_workshop->getPaymentSummary($w_id);
          $banklist             =   $this->Crm_banks->getcustomerBankList();
          $bankArray            =   [];
          foreach($banklist as $ckey => $cval){ 
                     $bankArray[$cval['bank_id']] = $cval['bank_name'];
          }
       $paymentDetails       =   $this->Crm_refurb_workshop->getPaymentList('',$bankArray,$w_id,'',$datapost); 
       $headerInfo=[
                  'summary'           => $summary,
                  'paymentDetails'    => $paymentDetails,
                  'source'            => $source,
                  'workshop'          => $datapost['w_id']
                ];
        
      $this->load->view('refurb/ajax_paymentDetails',$headerInfo);  
    }
}        