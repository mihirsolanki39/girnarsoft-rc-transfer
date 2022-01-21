<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class UsedcarPurchase extends MY_Controller {

    public function __construct() {
        parent::__construct();
        
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
        $this->load->model('Crm_stocks');
        $this->load->model('Leadmodel');
        $this->load->model('Crm_buy_lead_history_track');
        $this->load->model('State');
        $this->load->model('Showroom');
        $this->load->model('UsedCarImageMapper');
        $this->load->model('Leadsellmodel');
        $this->load->model('Crm_adv_booking');
        $this->load->model('Crm_previous_insurer');
        $this->load->model('Crm_insurance');
        $this->load->model('Crm_dealers');
        $this->load->model('Crm_used_car_sale_case_info');

        error_reporting(0) ;
        if (!$this->session->userdata['userinfo']['id'])
        {
            return redirect('login');
        }
    }

    public function saveUpdateStockData($id = '') 
    {
        $params = $this->input->post();
        /*echo "<pre>";
        print_r($params);
        exit;*/
        //if(!empty($params['caseinfo']))
        if(!empty($params['purchasecase']))
        {
            $this->addEditCaseInfo($params);
        }
        if(!empty($params['sellinfo']))
        {
            $this->addEditSellInfo($params);
        }
        if(!empty($params['payinfo']))
        {
            $this->addEditPaymentInfo($params);
        }
        if(!empty($params['refurbinfo']))
        {
            $this->addEditRefurbInfo($params);
        }
    }
    public function usedcarpurchase($id='')
    {
        $caseId ='';
        //echo $id;die;
        if((!empty($id)) && ($id!='add'))
        {
            $editId  = !empty($id)? explode('_',base64_decode($id)):'';
            $caseId  = !empty($editId)?end($editId):'';
            
        }
        //echo $caseId;die;
        if(!empty($caseId))
        {
           $usedCarInfo               = $this->Crm_stocks->getUsedcarInfo($caseId);
           //print_r($usedCarInfo);die;
           $data['usedCarInfo']    = $usedCarInfo[0];
           $paymentDe                 = $this->Crm_stocks->getPaymentInfo($caseId);
           $data['paymentDe'] = $paymentDe;
        }
       
        $data['balance_amount_left']=$this->getBalanceAmount($caseId);
       
        $subids = [];
        $data['pageTitle']      = 'Case Information';
        $data['pageType'] = 'usedcarpurchase';
      
        $data['category'] = $this->Crm_stocks->usedCarPurchaseCat();
        $data['purchased_by'] = $this->Crm_user->getEmployeeByRole('','Used Car','Purchase Executive');
        $data['manager'] = $this->Crm_user->getEmployeeByRole('','All','Manager');
        $data['purchased_by']=array_merge($data['purchased_by'],$data['manager']);
        
        $data['evaluated_by'] = $this->Crm_user->getEmployeeByRole('','Used Car','Evaluator');
     
        $this->loadViews("usedcarpurchase/caseinformation", $data);
    }
    public function addEditCaseInfo($params)
    {
        //print_r($params);die;
        $usedCarCaseInfo    =   $this->renderCaseInfoForm($params); 
        $validationCheck    =   $this->session->userdata['userinfo']['is_admin']!=1?$this->caseInfoValidation($params):[]; 
        if(!empty($validationCheck))
        {
            echo json_encode($validationCheck);exit;
        }  
        if(!empty($params['caseinfo']))
        { 
           $upId = $params['caseinfo'];
           $action='1';
        }
        else
        {
            $upId = '';
            $action = '0';
        }
        $cuBnkInfo       = $this->Crm_stocks->addCrmUsedcarPurchaseCaseinfo($usedCarCaseInfo,$upId);
        if(!empty($cuBnkInfo ))
        {
            
            $paymentDetails=$this->db->query('select id from usedcar_payment_details where case_id='.$cuBnkInfo)->result_array();
            if ($params['tradetype'] == 1 && !empty($params['expected_amt']))
            {
                $payment = ['case_id' => $cuBnkInfo, 'expected_price' => str_replace(',','',$params['expected_amt'])];
            }
            else if ($params['tradetype'] == 2 && $params['purchase_amt'])
            {
                $payment = ['case_id' => $cuBnkInfo, 'purchaseprice' => str_replace(',','',$params['purchase_amt']),'purchasedate' => date('Y-m-d',strtotime($params['pdate']))];
            }
            
            if (!empty($payment))
            {
                if (empty($paymentDetails))
                {
                    $this->Crm_stocks->addUsedcarPersonnel($payment);
                }
                else
                {
                    $this->db->where('case_id', $upId);
                    $this->db->update('usedcar_payment_details', $payment);
                }
            }
            $otherData=$this->db->query('select id from crm_used_car_other_fields where case_id='.$cuBnkInfo)->result_array();
            //print_r($otherData);die;
            $usedcarother=[];
            if(!empty($otherData)){
               
                    $this->db->where('case_id', $cuBnkInfo);
                    $this->db->update('crm_used_car_other_fields', ['tradetype'=>$params['tradetype']]);
            } else 
            {               
                $usedcarother['cnt_id']    = $params['carid'];
                $usedcarother['case_id']   = $cuBnkInfo;
                $usedcarother['tradetype'] = $params['tradetype'];
                $this->db->insert('crm_used_car_other_fields', $usedcarother);
            }
            $result= array('status'=>'True','message'=>'Case Information Added Successfully','Action'=>  base_url().'cardetails/' . base64_encode(DEALER_ID.'_'. $cuBnkInfo));
        }
        echo json_encode($result);exit;

    }
    public function renderCaseInfoForm($params)
    {
       
        $bnkInfor                            = [];
        if(isset($params)){
        //$bnkInfor['id']                      = !empty($params['stockId'])?$params['stockId']:'';
        $bnkInfor['cat_id']                  = !empty($params['source_cat'])?$params['source_cat']:'';
        $bnkInfor['name_id']                 = !empty($params['source_name'])?$params['source_name']:'';
        $bnkInfor['evaluation_date']         = !empty($params['dob'])?date('Y-m-d',strtotime($params['dob'])):'';
        $bnkInfor['evaluated_by']            = !empty($params['evaluated_by'])?$params['evaluated_by']:'';
        $bnkInfor['overall_condition']       = !empty($params['overall_condition'])?$params['overall_condition']:'';
        $bnkInfor['evaluation_remark']       = !empty($params['evaluation_remark'])?$params['evaluation_remark']:'';
        $bnkInfor['purchased_by']            = !empty($params['purchased_by'])?$params['purchased_by']:'';
        $bnkInfor['closed_by']               = !empty($params['closed_by'])?$params['closed_by']:'';
        $bnkInfor['purchase_date']           = !empty($params['pdate'])?date('Y-m-d',strtotime($params['pdate'])):'';
        $bnkInfor['delivery_date']           = !empty($params['ddate'])?date('Y-m-d',strtotime($params['ddate'])):'';
        $bnkInfor['liquid_mode']             = $params['liquid_mode'];
        if($params['stockId']==''){
            $bnkInfor['created_date']        = date('Y-m-d H:i:s');
            $bnkInfor['created_by']          = $this->session->userdata['userinfo']['id'];
        }
        $bnkInfor['updated_by']              = $this->session->userdata['userinfo']['id'];
            if (!empty($params['source_cat']) && !empty($params['source_name']) && !empty($params['ddate'])  
            && (!empty($params['purchase_amt']) || !empty($params['expected_amt'])))
            {
                $bnkInfor['is_case_details_completed'] = '1';
            }
            else
            {
                $bnkInfor['is_case_details_completed'] = '0';
            }
        }
        return $bnkInfor;

    }
    public function caseInfoValidation($params)
    {   
        $this->form_validation->set_error_delimiters('', '');
        
        if(empty($params['source_cat'])){
        $this->form_validation->set_rules('source_cat', 'Source Category', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        else if(empty($params['source_name'])){
        $this->form_validation->set_rules('source_name', 'Source Name','required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        
            else if(empty($params['dob']) && $params['source_cat']!=1){
            $this->form_validation->set_rules('dob', 'Evaluation Date', 'required');
             if ($this->form_validation->run() == FALSE) {
                return array('status'=>'False','message'=>validation_errors());
            }
            }
            else if(empty($params['evaluated_by']) && $params['source_cat']!=1){
            $this->form_validation->set_rules('evaluated_by', 'Evaluated By', 'required');
             if ($this->form_validation->run() == FALSE) {
                return array('status'=>'False','message'=>validation_errors());
            }
            }
            else if(empty($params['overall_condition']) && $params['source_cat']!=1){
            $this->form_validation->set_rules('overall_condition', 'Overall Condition', 'required');
             if ($this->form_validation->run() == FALSE) {
                return array('status'=>'False','message'=>validation_errors());
            }
            }  
            else if(empty($params['evaluation_remark']) && $params['source_cat']!=1){
            $this->form_validation->set_rules('evaluation_remark', 'Evaluation Remark', 'required');
             if ($this->form_validation->run() == FALSE) {
                return array('status'=>'False','message'=>validation_errors());
            }
            } 
       
       /* else if(empty($params['purchased_by'])){
        $this->form_validation->set_rules('purchased_by', 'Purchased By', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }   
        else if(empty($params['pdate'])){
        $this->form_validation->set_rules('pdate', 'Purchased Date', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }  */
        else if(empty($params['ddate'])){
        $this->form_validation->set_rules('ddate', 'Delivery Date', 'required');
         if ($this->form_validation->run() == FALSE) {
            return array('status'=>'False','message'=>validation_errors());
        }
        } 

    }
    public function getSubCatergory()
    {
        $str = '';
        $cat_id = $this->input->post('cat_id');
        $sel = $this->input->post('sel');
        if (in_array($cat_id, [6, 8]))
        {
            $dealerType=  $cat_id==6?['1','2']:['0','2'];
            $subids = $this->Crm_dealers->getDealersByType($dealerType);
            ///print_r($subids);die;
        }
        else
        {
            $subids = $this->Crm_stocks->usedCarPurchaseCat($cat_id);
        }
        if(!empty($subids))
        {
            
            foreach ($subids as $key => $value) 
            {
                $selected = '';
                if((!empty($sel)) && ($value['id']==$sel))
                {
                     $selected = 'selected="selected"';
                }
               $str .= "<option value='".$value['id']."'".$selected." >".$value['cat_name']."</option>";
            }
            
        }
        echo $str; exit;
    }
    public function mapCentralToCrmData($centralStockData,$crmStockData){
         //print_r($centralStockData);
          $crmStockData['central_stock_id']=$centralStockData['id'];
          $crmStockData['reg_no']=$centralStockData['reg_no'];
          $crmStockData['engineno']=$centralStockData['engine_no'];
          $crmStockData['chassisno']=$centralStockData['chassis_no'];
          $crmStockData['make_id']=$centralStockData['make_id'];
          $crmStockData['model_id']=$centralStockData['model_id'];
          $crmStockData['version_id']=$centralStockData['version_id'];
          $crmStockData['db_version_id']=$centralStockData['version_id'];
          $crmStockData['insurance_date']=$centralStockData['insurance_expire'];
          $crmStockData['insurance_exp_year']=date('Y',strtotime($centralStockData['insurance_expire']));
          $crmStockData['insurance_exp_month']=date('m', strtotime($centralStockData['insurance_expire']));
          $crmStockData['make_month']=1;
          $crmStockData['make_year']=2017;
          $crmStockData['make_year']=2017;
         //print_r($crmStockData);die;
          
          return $crmStockData;
    }

    public function usedcarcardetail($id='')
    {
        // error_reporting(1);
        $data = [];
        $editId  = !empty($id)? explode('_',base64_decode($id)):'';
        //print_r($editId);die;
        $caseid   = !empty($editId)?end($editId):'';
        //$car_id   = !empty($editId)?end($editId):'';
        //$usedCarInfo = [];
        $getData = $this->input->get();
       // print_r($getData);die;
        $regCityList           = $this->UserDashboard->getRegCityListArr();
        $getColors             = $this->UserDashboard->getColors();
        $certifiedcarlists     = $this->UserDashboard->getCertifiedList();
        $selectshowrooms       = $this->Showroom->getList('1');
        $colArr                 = array();
        $data['caseid']   = $caseid;
        $dealer_id      = DEALER_ID; 
        $central_stock_id=0;
        $carDeatil          = array();
        if(!empty($caseid))
        {
             
           //$carDeatil      = $this->UserDashboard->getStockDetailsByCarId($car_id,$dealer_id);
           $usedCarInfo           = $this->Crm_stocks->getUsedcarInfo($caseid);
           $carDeatil   = $usedCarInfo[0];
           $priceBreakup = $this->Crm_stocks->getPriceBreakUp($carDeatil['car_id'],$caseid);
           $websiteLink = $this->Crm_stocks->getWebsiteLink($carDeatil['car_id'],$caseid);
           
           //print_r($carDeatil);die;
           if (!empty($getData['eng_no']) && !empty($getData['chs_no']))
           {
                $centralStockData       = $this->Crm_stocks->getCrmCentralStock(['engine_no' => $getData['eng_no'], 'chassis_no' => $getData['chs_no']],true);
                $carDeatil['engineno']  = $getData['eng_no'];
                $carDeatil['chassisno'] = $getData['chs_no'];
                if (!empty($centralStockData))
                {
                    $carDeatil                     = $this->mapCentralToCrmData($centralStockData[0], $carDeatil);
                    $central_stock_id              = !empty($carDeatil) ? $carDeatil['central_stock_id'] : 0;
                    $data['central_stock_id'] = $central_stock_id;
                }
                 
           }
           $paymentDe                 = $this->Crm_stocks->getPaymentInfo($caseid);
           $data['paymentDe'] = $paymentDe;
          //print_r($paymentDe);die;
        }
        $car_id=0;
        if(!empty($carDeatil['car_id']))
        {
            $car_id=$carDeatil['car_id'];

        }
        foreach($getColors as $c=>$cols)
        {
             $colArr[] = $cols['name'];
        }
         $city                   = '';
        foreach($selectshowrooms as $key=>$val)
        {
            $city=$val['city'];
            break;
        }

        if(trim($car_id) == ''){
            $car_id = 0;
        }
        
        $imageMapArray      = array();
        $makeListArr        = array();
        $modelListArr       = array();
        $versionListArr     = array();
        $getZoneDetail      = array();
        $area_of_cover      = '';
        $inventory_docs     = array();
        $monthName = '';

        if(!empty($car_id) || !empty($central_stock_id)){
            $checkmsg = '';
            if($carDeatil['is_gaadi']=='1')
            {
                $arr['checkmsg'] = '1'; 
            }
            $carDeatil['month'] = $carDeatil['reg_month'];
            if($carDeatil['insurance_type']!='')
            {
                $carDeatil['insurance'] = $carDeatil['insurance_type'];
            }
            $carDeatil['year'] = $carDeatil['insurance_exp_year'];
            $carDeatil['tax'] = ucfirst($carDeatil['tax_type']);
            $makeModelVersion       = $this->Make_model->getMakeModelVersionByCarId($carDeatil['version_id']);
            $carDeatil['make_id']   = $makeModelVersion[0]['make_id'];
            $carDeatil['make']      = $makeModelVersion[0]['make'];
            $carDeatil['model_id']  = $makeModelVersion[0]['model_id'];

            $monthName = date("M", mktime(0, 0, 0, $carDeatil['insurance_exp_month'], 10)); 
            
            $where          = " WHERE 1=1 ";
            $fields         = "id,make";
            $makeListArr    = $this->UserDashboard->getCarMakeList('used',$fields,$where);
            //echo "<pre>";print_r($makeListArr);die;
            $where          = " WHERE make='".$makeModelVersion[0]['make']."'";
            $fields         = "id,make_id,make,model";
            $modelListArr   = $this->UserDashboard->getCarModelList('used',$fields,'model',$where);

            $make           = trim($carDeatil['make_id']);
            $model          = trim($carDeatil['model_id']);
            $fields         = "db_version_id,db_version,uc_fuel_type,Displacement";
            $sqlJoin        = " ";
            $where          = $sqlJoin." WHERE model_version.mk_id = '".$make."' AND model_version.model_id = '".$model."' ";
            $orderBy    = "uc_fuel_type";
            $versionListArr  = $this->UserDashboard->getCarVersionList($make,'used',$fields,$orderBy,$where);
            $versionListArrTemp = $versionListArr;
            $versionListArr = array();
            foreach($versionListArrTemp as $key => $value){
                $versionListArr[$value['uc_fuel_type']]['uc_fuel_type'] = $value['uc_fuel_type'];
                $versionListArr[$value['uc_fuel_type']]['key'] = $key;
                $versionListArr[$value['uc_fuel_type']]['data'][] = $value;
            }

            /////$imageMapArray  = $this->UsedCarImageMapper->getAllImagesByCarId($car_id);

            foreach($selectshowrooms as $key=>$val)
            {
                if($carDeatil['showroom_id'] == $val['id']){
                    $city                   = $val['city'];
                    $showroomId             = $carDeatil['showroom_id'];
                    $defaultShowrromName    = $val['outlet_address'];
                }
            }

            $getZoneDetail                  = $this->UserDashboard->getZoneDetail($carDeatil['locality_names']);

            ///$inventory_docs =  $this->UserDashboard->getDocInfo($car_id);
            
        }
        $data['rto']       = $this->Loan_customer_case->getRto();
        $data['car_id']=$car_id;
        $data['carDeatil'] = $carDeatil;
        $data['usedCarInfo']    = $carDeatil;
        $data['makeListArr'] = $makeListArr;
        $data['modelListArr'] = $modelListArr;
        $data['versionListArr'] = $versionListArr;
        $data['area_of_cover'] = $area_of_cover;
        $data['showroomId'] = $selectshowrooms[0]['id'];
        $data['defaultShowrromName'] = $selectshowrooms[0]['outlet_address'];
        $data['getZoneDetail'] = $getZoneDetail;
        $data['monthInsuraanceText'] = $monthName; 
        $data['colArr'] = $colArr;
        $data['regCityList'] = $regCityList;
        $data['certifiedcarlists'] = $certifiedcarlists;
        $data['selectshowrooms'] = $selectshowrooms;
        $data['banklist'] = $this->getcustomerBankList();
        //$data['banklist'] = $this->Crm_banks->getBanklist();
        $data['insurer_list'] = $this->Crm_previous_insurer->getInsurerList();
        $data['city'] = $city;
        if ($carDeatil['liquid_mode'] == 2)
        {
            $purchase_price    = $carDeatil['tradetype'] == 1 ? $carDeatil['expected_price'] : $carDeatil['purchaseprice'];
            //print_r($data['carDeatil']);die;
            $data['carDeatil']['car_price'] = !empty($data['carDeatil']['car_price']) ? $data['carDeatil']['car_price'] : $purchase_price;
        }
        $subids = [];
        $data['pageTitle']      = 'Car Details';
        $data['pageType'] = 'usedcarpurchase';
       /* echo "<pre>";
        print_r($data['carDeatil']);
        exit;*/
        $data['balance_amount_left']=$this->getBalanceAmount($caseid);
        $data['price_breakup'] = $priceBreakup;
        $data['website_link'] = $websiteLink;
        $this->loadViews("usedcarpurchase/cardetails", $data);
    }
    public function checkCentralStock()
    {
        $postData = $this->input->post();
        //print_r($postData);die;
        $data     = [
            'engine_no'  => $postData['engine_no'],
            'chassis_no' => $postData['chassis_no']
        ];
        $result=$this->Crm_stocks->getCrmCentralStock($data);
       //print_r($result);
        $response = empty($result)?['exist'=>'no']:['exist'=>'yes','engine_no'=> $result[0]['engine_no'],'chassis_no'=>$result[0]['chassis_no']];
        exit(json_encode($response));
    }

    public function uploadDocs($case_id)
    {
        $editId      = !empty($case_id)? explode('_',base64_decode($case_id)):'';
        $caseId  = !empty($editId)?end($editId):'';
        $data = [];
        $seg = $this->uri->segment(3);
        if(!empty($seg))
        {
            $data['disbural'] = '1';
        }
        //$data = [];     
        if(!empty($caseId))
        {
           $usedCarInfo           = $this->Crm_stocks->getUsedcarInfo($caseId);
           $carDeatil   = $usedCarInfo[0];
            $paymentDe                 = $this->Crm_stocks->getPaymentInfo($caseId);
           $data['paymentDe'] = $paymentDe;


        }
        $bnkId = '';
        $uploadDocList = [];
        $data['usedCarInfo']    = $carDeatil;
        $data['pageTitle']      = 'Car Upload Docs';
        $data['pageType']       = 'usedcarpurchase';
        $data['case_id']         = $caseId;
        $data['carDeatil']         = $carDeatil;
        $data['balance_amount_left']=$this->getBalanceAmount($caseId);
        $this->loadViews("usedcarpurchase/uploadDocs",$data);
    }
    public function logindoc()
    {
        $caseId  = $this->input->post('cases_id');
        $imgListUpdated = '';
        $arr = ['1','2','3','4','5','6'];
        $data = [];
        $imgListArr = [];
        $personnelDocs = [];
        $bnkId = '';
        $uploadDocList = [];
        $data['pageTitle']      = 'Car Upload Docs';
        $data['pageType']       = 'usedcarpurchase';

        $docList = $this->Crm_upload_docs_list->getDocList('','6');
        foreach($docList as $key => $val)
        {
            $uploadDocList[$val['parent_id']]['name']= $val['parent_name'];
            $uploadDocList[$val['parent_id']]['is_require']= $val['is_require'];
            //echo $data['CustomerInfo']['loan_for'].'-'.$val['id'];
            if(($data['CustomerInfo']['loan_for'] == '2') && $val['id']=='7')
            {
                $uploadDocList[$val['parent_id']]['is_require']= '1';
            }

            $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'],'6'); 
            foreach ($sublist as $skey => $sval)
            {
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['name'] = $sval['name'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['sub_category_id'] = $sval['sub_category_id'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = $sval['is_require'];
            }   
        }
        if(!empty($caseId))
        {
           $usedCarInfo           = $this->Crm_stocks->getUsedcarInfo($caseId);
           $carDeatil   = $usedCarInfo[0];
            $paymentDe                 = $this->Crm_stocks->getPaymentInfo($caseId);
           $data['paymentDe'] = $paymentDe;
        }
        
        $data['usedCarInfo']    = $carDeatil;
        $imgListArr =  $this->Crm_stocks->getAllTagUsedCarImages($carDeatil['car_id']);
        $data['uploadDocList'] = $uploadDocList;
        $data['imageList']   =  $imgListArr;
        $data['car_id']      =  $caseId;
        //$data['pendencyDoc'] = $this->Crm_upload_docs_list->getPendencyDetail($caseId,1);
        //$data['rolemgmt'] = $this->financeUserMgmt('','uploadDocs');    
  
        echo $datas=$this->load->view('usedcarpurchase/loginDoc',$data,true); exit;
        //$this->loadViews("finance/loginDocs",$data);
    }

public function cardoc()
    {
        $caseId  = $this->input->post('cases_id');
        $imgListUpdated = '';
        $arr = ['1','2','3','4','5','6'];
        $data = [];
        $imgListArr = [];
        $personnelDocs = [];
        $bnkId = '';
        $uploadDocList = [];
        $data['pageTitle']      = 'Upload Car Docs';
        $data['pageType']       = 'usedcarpurchase';

        $docList = $this->Crm_upload_docs_list->getDocList('','7');
       /* echo "<pre>";
        print_r($docList);
        exit;*/
        foreach($docList as $key => $val)
        {
            $uploadDocList[$val['parent_id']]['name']= $val['parent_name'];
            $uploadDocList[$val['parent_id']]['is_require']= $val['is_require'];
            $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'],'7'); 
            foreach ($sublist as $skey => $sval)
            {
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['name'] = $sval['name'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['sub_category_id'] = $sval['sub_category_id'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = $sval['is_require'];
            }   
        }
        if(!empty($caseId))
        {
           $usedCarInfo           = $this->Crm_stocks->getUsedcarInfo($caseId);
           $carDeatil   = $usedCarInfo[0];
            $paymentDe                 = $this->Crm_stocks->getPaymentInfo($caseId);
           $data['paymentDe'] = $paymentDe;
           $data['tradetype'] = $carDeatil['tradetype'];
        }
        $data['carid']      =  $carDeatil['car_id'];
        $data['usedCarInfo']    = $carDeatil;
       /*echo "<pre>";
        print_r($data);
        exit;*/
         $i = 0;
        $imgListUpdated = $this->Crm_upload_docs_list->getImageuploadList($data['carid'],'','','','7',$caseId);
          if(!empty($imgListUpdated))
        {
            foreach($imgListUpdated as $imgK => $imgV)
            {
                $name = '';
                $bank_name = '';
                if(in_array($imgV['tag_id'], $arr))
                {
                   $imageTag = $this->Crm_upload_docs_list->getImageuploadList('','',$imgV['tag_id'],'','7',$caseId);
                   $bankname = $this->Crm_banks->getBankNameBybnkId($imageTag[0]['bank_id']);
                   $bank_name = $imgV['name'] .' ('. $bankname['bank_name'].')';
                }
                $a['allids'][]       =   $imgV['parent_id'];
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
        if(!empty($a['allids'])){
            $data['allParentIds'] =  $a['allids'];
          }
        $data['imageList'] =  $imgListArr;
        //$imgListArr =  $this->Crm_stocks->getAllTagUsedCarImages($carDeatil['car_id'],$caseId);
        $data['uploadDocList'] = $uploadDocList;
        $data['imageList']   =  $imgListArr;
        $data['car_id']      =  $caseId;
        $data['pendencyDoc'] = $this->Crm_upload_docs_list->getPendencyDetail($caseId,'7');
        echo $datas=$this->load->view('usedcarpurchase/cardoc',$data,true); exit;
        //$this->loadViews("finance/loginDocs",$data);
    }

    public function uploadLoginDocs()
    {
        $caseid = $this->uri->segment(3);
        $data = [];       
        $file_name_key              = key($_FILES);
        $config['upload_path']      = UPLOAD_IMAGE_PATH.'uploadcar/original/';
        $config['allowed_types']    = ['gif', 'png', 'jpg','jpeg','pdf'];
        $config['max_size']         = '8000';
        $config['max_width']        = '5000';
        $config['max_height']       = '5000';
        $config['min_width']        = '300';
        $config['min_height']       = '200';
        $config['encrypt_name']     = True;

        $this->load->library('upload', $config);
        if($this->upload->do_upload($file_name_key))
        {
            $usedCarInfo           = $this->Crm_stocks->getUsedcarInfo($caseid);
            $datas = $this->upload->data();
            $arr = $usedCarInfo[0]['car_id'];
            $data['file_name'] = $datas['file_name'];
            $result = $this->UserDashboard->manageCarImages($data,$arr); 
        }
        else
        {
            //echo "dfrrf"; exit;
            //$arrs
           $error  =   $this->response = $this->upload->display_errors();
            $result = array('error' => $error, 'status' => 400); 
            exit(json_encode($result));
        }
       
    }

    public function getchecklistdoc()
    {
        $caseId  = $this->input->post('case_id');
        $imgListUpdated = '';
        $arr = ['1','2','3','4','5','6'];
        $data = [];
        $imgListArr = [];
        $personnelDocs = [];
        $bnkId = '';
        $uploadDocList = [];
        $data['pageTitle']      = 'Upload Car Docs';
        $data['pageType']       = 'usedcarpurchase';
        $docList = $this->Crm_upload_docs_list->getDocList('','7');
        foreach($docList as $key => $val)
        {
            $uploadDocList[$val['parent_id']]['name']= $val['parent_name'];
            $uploadDocList[$val['parent_id']]['is_require']= $val['is_require'];
            $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'],'7'); 
            foreach ($sublist as $skey => $sval)
            {
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['name'] = $sval['name'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['check_status'] = !empty($sval['checklist_status'])?$sval['checklist_status']:'2';
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['sub_category_id'] = $sval['sub_category_id'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = $sval['is_require'];
            }   
        }
        if(!empty($caseId))
        {
           $usedCarInfo           = $this->Crm_stocks->getUsedcarInfo($caseId);
           $carDeatil   = $usedCarInfo[0];
            $paymentDe                 = $this->Crm_stocks->getPaymentInfo($caseId);
           $data['paymentDe'] = $paymentDe;
        }
        $data['carid']      =  $carDeatil['car_id'];
        $data['usedCarInfo']    = $carDeatil;
        $i = 0;
        $imgListUpdated = $this->Crm_upload_docs_list->getChecklistDoc($caseId,'7');
       
          if(!empty($imgListUpdated))
        {
            foreach($imgListUpdated as $imgK => $imgV)
            {
                $name = '';
                $bank_name = '';
                if(in_array($imgV['tag_id'], $arr))
                {
                   $imageTag = $this->Crm_upload_docs_list->getImageuploadList('','',$imgV['tag_id'],'','7',$caseId);
                   $bankname = $this->Crm_banks->getBankNameBybnkId($imageTag[0]['bank_id']);
                   $bank_name = $imgV['name'] .' ('. $bankname['bank_name'].')';
                }
                $a['allids'][]       =   $imgV['id'];
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
        if(!empty($a['allids'])){
            $data['allsub_id'] =  $a['allids'];
          }
          //echo "<pre>";print_r($uploadDocList);die;
        $data['uploadDocList'] = $uploadDocList;
        $data['imageList']   =  $imgListArr;
        $data['car_id']      =  $caseId;
        $data['checklist'] = $this->Crm_upload_docs_list->getChecklist('',$caseId,'7','1');
        $data['pendencyDoc'] = $this->Crm_upload_docs_list->getPendencyDetail($caseId,'7');
        
        echo $datas=$this->load->view('usedcarpurchase/checklistdoc',$data,true); exit;
        //$this->loadViews("finance/loginDocs",$data);
    }

    public function uploadCarDocs(){

        //echo UPLOAD_IMAGE_PATH_LOCAL.'uploadLoginDocs/'; exit;
        $arr = $this->uri->segment(3);
        $ar  = explode('-', $arr);
        $data = [];       
        $file_name_key              = key($_FILES);
        $config['upload_path']      = UPLOAD_IMAGE_PATH_LOCAL.'carDoc/';
        $config['allowed_types']    = ['gif', 'png', 'jpg','jpeg'];
        $config['max_size']         = '8000';
        $config['max_width']        = '5000';
        $config['max_height']       = '5000';
        $config['min_width']        = '300';
        $config['min_height']       = '200';
        $config['encrypt_name']     = True;

        $this->load->library('upload', $config);
        if($this->upload->do_upload($file_name_key))
        {
            $datas = $this->upload->data();
            
            $data['doc_name'] = $datas['file_name'];
            $data['doc_url'] = 'carDoc/'.$datas['file_name'];
            $data['doc_type'] = '7';
            $data['customer_id'] = $ar['1'];
            $data['case_id'] = $ar['0'];
            $data['created_on'] = date('Y-m-d h:i:s');
            $data['created_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';

              $result = $this->Crm_upload_docs_list->insertLoginDocs($data);
              echo trim($result); exit;
 
         }
        else
        {
           //echo $this->response = $this->upload->display_errors(); exit;
           $error  = array('Invalid Request!');
           echo $result = array('error' => $error, 'status' => 400); exit;
        }  
    }

     public function showImagesToTag()
    {
        $customer_id = $this->input->post('customer_id');
        $caseId= $this->input->post('case_id');
        $doc= $this->input->post('doc');
        $doctype= $this->input->post('doctype');
        $data = [];
        $i = 0;
       //echo $doc; exit;
        //$doc = 7;
        if(!empty($doctype))
        {
           // $doc = 2;
        }
        if(!empty($caseId))
        {
           $usedCarInfo           = $this->Crm_stocks->getUsedcarInfo($caseId);
           $carDeatil   = $usedCarInfo[0];
        }
        if(empty($doc))
        {
            $imageList =  $this->Crm_stocks->getAllTagUsedCarImages($carDeatil['car_id']);

            $str = '[';
            foreach($imageList as $key => $val)
            {
                $data[$i]['id'] = $val['id'];
                $data[$i]['small'] = $val['image_url'];
                $data[$i]['big'] = $val['image_url'];
                $data[$i]['tag_id'] = $val['tag_id'];
                $i++;
            }
        }
        else
        {
             $imageList = $this->Crm_upload_docs_list->getImageuploadList($customer_id,'','','','7',$case_id);
            //$imageList = $this->Crm_upload_docs_list->getImageuploadList($caseId,'','','','7',$customer_id);
            $str = '[';
              foreach($imageList as $key => $val)
            {
                $data[$i]['id'] = $val['id'];
                $data[$i]['small'] = (($val['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$val['doc_url'];
                $data[$i]['big'] = (($val['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$val['doc_url'];;
                $data[$i]['tag_id'] = $val['tag_id'];
                $i++;
            }
        }
        echo json_encode($data); exit;
    }

    public function loanTagMapping()
    {
        $data = [];
        $err =[];
        $doc  = '';
        $doctype = $this->input->post('doctype');
        $flag = $this->input->post('flag');
        $ctag_id =  $this->input->post('tag_id');
        $id = $this->input->post('id');
        $customer_id = $this->input->post('customer_id');
        $doc = $this->input->post('doc');
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
        if(!empty($ctag_id))
        {
            $data['parent_tag_id'] = $ctag_id;
        }
        if(!empty($case_id))
        {
           $usedCarInfo           = $this->Crm_stocks->getUsedcarInfo($case_id);
           $carDeatil   = $usedCarInfo[0];
 
        }
        if(empty($doc))
        {
            $img_detail =  $this->Crm_stocks->getAllTagUsedCarImages($carDeatil['car_id'],$img); 
        } 
        else if(!empty($flag))
        {
            $img_detail = $this->Crm_upload_docs_list->getImageuploadList('','','','','7',$case_id,'','','','',$ctag_id);
        } 
        else
        {
             $img_detail = $this->Crm_upload_docs_list->getImageuploadList($customer_id,$img,'','','7',$case_id);
        }

        if($type=='add')
        {
            $data['created_on'] = date('Y-m-d H:i:s');
            $data['created_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
           // echo $img_detail[0]['tag_id'].'-'.$data['tag_id']; exit;
            if((empty($img_detail[0]['tag_id'])) && (!empty($data['tag_id'])))
            {
               // echo "fdsrfrag"; exit;
                if(empty($doc))
                {
                    $imageList = $this->UserDashboard->updateTagImageMapper($carDeatil['car_id'],$img,$data['tag_id'],'1','',$data['parent_tag_id']);
                }
                else
                {
                    $checkPendency = $this->Crm_upload_docs_list->getPendencyDetail($case_id,'7',$data['tag_id']);
                    $imageList = $this->Crm_upload_docs_list->insertTagMapping($data);
                    $des = [];
                    $des[0]['tag_id'] = $data['parent_tag_id'];
                    $des[0]['case_id'] = $case_id;
                    $des[0]['doc_type'] = '7';
                    $des[0]['status'] = '1';
                    $this->Crm_upload_docs_list->saveCheckLists($des,$case_id);
                    //$this->addCustomerPersonnelDocs($doc,$customer_id,$img,$tag,'',$subcat);
                }
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
               // echo "ggg";
                if(empty($doc))
                {
                  //  echo "ffff";
                    $imageList = $this->UserDashboard->updateTagImageMapper($carDeatil['car_id'],$img,'0','1','','0','1');
        
                    $err['msg'] = "Tagged Removed Successfully"; 
                    $err['status'] = "1";
                    $err['tag_id'] = $img_detail[0]['tag_id'];
                    $err['parent_tag_id'] = $img_detail[0]['parent_tag_id'];
               }
                else
                {

                    $imageList = $this->Crm_upload_docs_list->insertTagMapping($data,$img_detail[0]['imgID']);
                    $des = [];
                    $des['tag_id'] = $img_detail[0]['parent_tag_id'];
                    $des['case_id'] = $case_id;
                    $des['doc_type'] = '7';
                    $des['status'] = '2';
                            $this->Crm_upload_docs_list->saveCheckLists($des,$case_id);
                    $err['msg'] = "Tagged Removed Successfully"; 
                    $err['status'] = "1";
                    $err['tag_id'] = $img_detail[0]['tag_id'];
                    $err['parent_tag_id'] = $img_detail[0]['parent_tag_id'];
                }
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
                if(empty($doc))
                {
                    $imageList = $this->UserDashboard->updateTagImageMapper($carDeatil['car_id'],$img,'0','1',$reason_id,'0','1');
        
                    $err['msg'] = "Image Mark Incorrect"; 
                    $err['status'] = "0";
               }
               else{
            $update_img_detail = $this->Crm_upload_docs_list->getImageuploadList($customer_id,$img,'','',$doc);
           // $this->addCustomerPersonnelDocs($doc,$customer_id,$img,'','1');
            $data['mark_incorrect'] = $reason_id;
            $data['tag_id'] = '';
            $data['updated_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
            $imageList = $this->Crm_upload_docs_list->insertTagMapping($data,$update_img_detail[0]['imgID']);
             $err['msg'] = "Image Mark Incorrect"; 
            $err['status'] = "0";
            }
           
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
        $arr        = ['1','2','3','4','5','6'];
        $tagid      = $this->input->post('tagid');
        $caseid     = $this->input->post('case_id');
        $imag_id    = $this->input->post('imag_id');
        $doctype    = $this->input->post('doctype');
        $doc        = $this->input->post('doc');
        $errImg= "";
        if(!empty($case_id))
        {
           $usedCarInfo           = $this->Crm_stocks->getUsedcarInfo($caseid);
           $carDeatil   = $usedCarInfo[0];
        }
        if(empty($doc)){
            $img_detail =  $this->Crm_stocks->getAllTagUsedCarImages($carDeatil['car_id'],$imag_id);
            if(!empty($img_detail))
            {
                
                //$imageTags = $this->Crm_upload_docs_list->getImageuploadList('',$imag_id,'','',$doctype,$caseid);
               // if(!empty($img_detail[0]['tag_id']))
              //  {
                    if($img_detail[0]['incorrect_image']>0)
                    {
                        $errImg = ($img_detail[0]['incorrect_image']==1)?'Incorrect Doc':'Unclear Image';
                        echo json_encode($errImg); exit;
                    }
                else{
                    echo json_encode($img_detail[0]['sub_name']); exit;
                }
                //}
            }
        }
        else
        {
            $imageTags = $this->Crm_upload_docs_list->getImageuploadList('',$imag_id,'','',$doctype,$caseid);
            if(!empty($imageTags))
            {
                if($imageTags[0]['err']>0)
                {
                    $errImg = ($imageTags[0]['err']==1)?'Incorrect Doc':'Unclear Image';
                    echo json_encode($errImg); exit;
                }
                echo json_encode($imageTags[0]['name']); exit;
            }  
        }
        echo json_encode(''); exit;
    }


     public function getImagedownload($caseId,$doc='1')
    {
        $this->load->library('zip');
        $data = [];
       // $doc = 1;
        if(!empty($caseId))
        {
           $usedCarInfo           = $this->Crm_stocks->getUsedcarInfo($caseId);
           $carDeatil   = $usedCarInfo[0];
        }
        $imageList =  $this->Crm_stocks->getAllTagUsedCarImages($carDeatil['car_id']);
        //$imageList = $this->Crm_upload_docs_list->getImageuploadList('','','','',$doc,$caseId);
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
            $h = 1;
            //$imageName = $this->Crm_upload_docs_list->getImageuploadList('','','','','','','','',$arr);
            $imgdata=array();
            foreach ($imageList as $key => $value) 
            {
                if(!empty($value))
                {
                    $newfname='';
                    $imgContet='';
                    $newfname = $value['image_url'];
                    $imgContet=file_get_contents($newfname);
                    if(!empty($value['sub_name'])){
                        $a = explode('.', $value['image_name']);
                        $nam = $h.'_'.$value['sub_name'].'.'.$a[1];
                    }
                    else
                    {
                        $nam = $h.'_'.$value['image_name'];  
                    }
                    $imgdata[$nam] = $imgContet;
                    $h ++;
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
          $this->zip->archive('uploadcar/original/'.$filename.'.zip');
          $this->zip->download($filename);
          }else{
             echo "error"; exit; 
          }

        }
        
        $this->uploadDocs($caseId);
    }
    
    public function getImagedownloadcardoc($caseId)
    {
        $this->load->library('zip');
        $data = [];
       // $doc = 1;
        $imageList = $this->Crm_upload_docs_list->getImageuploadList('','','','','7',$caseId);
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
           
            $imageName = $this->Crm_upload_docs_list->getImageuploadList('','','','','','','','',$arr);
            $imgdata=array();
            $h = 1;
            foreach ($imageName as $key => $value) 
            {
                if(!empty($value))
                {
                    $newfname='';
                    $imgContet='';
                    $newfname = UPLOAD_IMAGE_PATH_LOCAL.'carDoc/'.$value['doc_name'];
                    $imgContet=file_get_contents($newfname);
                    if(!empty($value['name'])){
                        $a = explode('.', $value['doc_name']);
                        $nam = $h.'-'.$value['buyer_name'].'-'.$value['name'].'.'.$a[1];
                        //$nam = $value['name'].'.'.$a[1];
                    }
                    else
                    {
                        $nam = $h.'-'.$value['doc_name'];  
                    }
                    $imgdata[$nam] = $imgContet;
                    $h ++;
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
          $this->zip->archive('carDoc/'.$filename.'.zip');
          $this->zip->download($filename);
          }else{
             echo "error"; exit; 
          }

        }
        
        $this->uploadDocs($caseId);
    }
    public function saveLoginDocs()
    {       
        //echo "dsd"; exit;
        $err = [];
        $bank = [];
        $req_id = [];
        $req = [];
        $caseInfo = [];
        $tagArr = [];
        $req_sid = [];
        $penTagId = [];
        $checkloginform = $this->input->post('checkloginform');
        $case_id = $this->input->post('case_id');
        $printTypes = $this->input->post('printTypes');
        $customer_id = $this->input->post('customer_id');
        $docc = $this->input->post('doc');
        if(!empty($checkloginform))
        {
            $this->saveCheckList($checkloginform,$case_id,'7');
        }
        if(!empty($case_id))
        {
           $usedCarInfo           = $this->Crm_stocks->getUsedcarInfo($case_id);
           $carDeatil   = $usedCarInfo[0];
        }
       
        $doctype = $this->input->post('doctype');
        if(empty($docc))
        {
            $imageList =  $this->Crm_stocks->getAllTagUsedCarImages($carDeatil['car_id']);
            $docList = $this->Crm_upload_docs_list->getDocList('','6'); 
        }
        else
        {
            $imageList = $this->Crm_upload_docs_list->getImageuploadList($carDeatil['car_id'],'','','','7',$case_id);
            
            if($carDeatil['cat_id']!=1 && empty($imageList))
            {
                $results = array('status' => 'False', 'message' => 'Please upload at least 1 Doc');
                echo json_encode($results);
                exit;
            }
            $docList = $this->Crm_upload_docs_list->getDocList('','7');
            $checkPendency = $this->Crm_upload_docs_list->getPendencyDetail($caseId,'7');
            if(!empty($checkPendency))
            {
                foreach($checkPendency as $pkey => $pval)
                {
                    $penTagId[] = $pval['pendency_doc_id'];
                }
            } 
        }
       
        $dc_images_array=[];
        foreach($imageList as $imgk => $imgv)
        {
            $dc_images_array[]= ['image_url'=>$imgv['image_url'],'status'=>$imgv['status']];
            
            
            if($imgv['incorrect_image']=='1')
            {
                $results= array('status'=>'False','message'=>'Please Resolve Incorrect Docs');
                echo json_encode($results); //exit;
            }
            $tagArr[] = $imgv['tag_id'];
        }
        
        $res=$this->UserDashboard->updateNewImageFlag(['car_id'=>$carDeatil['car_id'],'image_urls'=> serialize($dc_images_array)]);
//        $resArr               = json_decode($res);
//        if ($resArr->status == 'F')
//        {
//            $results = array('status' => 'True', 'message' => $resArr->msg, 'Action' => base_url() . 'paymentdetails/' . base64_encode(DEALER_ID . '_' . $case_id));
//        }
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
        if(empty($docc))
        {
            if($carDeatil['upload_car_photos']=='1')
            {
                $caseInfo['car_photo_updated_at']=date('Y-m-d H:i:s');
                $this->UserDashboard->updateOtherUploads($caseInfo,$case_id);
                $results= array('status'=>'True','message'=>'Docs uploaded Successfully','Action'=>  base_url().'sellerdetails/' . base64_encode(DEALER_ID.'_' .$case_id));
            }
            else
            {
                $caseInfo['car_photo_uploaded_at']=date('Y-m-d H:i:s');
                $caseInfo['car_photo_created_by']=!empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
                $caseInfo['upload_car_photos'] = '1';
                $this->UserDashboard->updateOtherUploads($caseInfo,$case_id);
                $results= array('status'=>'True','message'=>'Docs uploaded Successfully','Action'=>  base_url().'sellerdetails/' . base64_encode(DEALER_ID.'_' .$case_id));
            }
        }
        else
        {
            /*foreach($docList as $key => $val)
            {
                if(($val['is_require']>0))
                {
                    //echo "fefe".'----'.$val['id'];
                    $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'],'7'); 
                    foreach ($sublist as $skey => $sval)
                    {
                        $uploadDocList['name'] = $sval['name'];
                        if($sval['is_require']>0)
                        {
                            $req_sid[$val['parent_id']][]=$sval['sub_category_id'];
                        }                    
                    }   
                }                
            }
            foreach($req_sid as $rkey => $rval)
            {
                foreach($rval as $kr)
                {
                    if(!in_array($kr, $tagArr))
                    {
                        $results= array('status'=>'False','message'=>'Please upload all required Doc');
                        echo json_encode($results); exit;
                    }
                }
            }*/
            if(!empty($printTypes))
            {
                $caseInfo['print_docs'] = $printTypes;
            }
            if($carDeatil['upload_car_docs']=='1')
            {
                $caseInfo[' upload_car_docs_updated_on']=date('Y-m-d H:i:s');
                //$caseInfo['print_docs'] = $printTypes;
                $this->UserDashboard->updateOtherUploads($caseInfo,$case_id);
                $results= array('status'=>'True','message'=>'Docs uploaded Successfully','Action'=>  base_url().'paymentdetails/' . base64_encode(DEALER_ID.'_' .$case_id));
            }
            else
            {
                $caseInfo['upload_car_docs_created_on']=date('Y-m-d H:i:s');
                $caseInfo['upload_car_docs_created_by']=!empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
                $caseInfo['upload_car_docs'] = '1';
               // $caseInfo['print_docs'] = $printTypes;
                $this->UserDashboard->updateOtherUploads($caseInfo,$case_id);
                if((!empty($carDeatil['tradetype'])) && ($carDeatil['tradetype']=='1')){
                     $results= array('status'=>'True','message'=>'Docs uploaded Successfully','Action'=>  base_url().'paymentdetails/' . base64_encode(DEALER_ID.'_' .$case_id));
                }
                else{
                $results= array('status'=>'True','message'=>'Docs uploaded Successfully','Action'=>  base_url().'paymentdetails/' . base64_encode(DEALER_ID.'_' .$case_id));
                }
            }
        }
        echo json_encode($results); exit;
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
        $imggg = $this->Crm_upload_docs_list->getImageuploadList('','','','',$doctype,$case_id);
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
                        if(($v['tag_id']=='1')||($v['tag_id']=='2'))
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
                        if(!empty($v['parent_id']))
                        {
                            $ids[] = $v['parent_id'];
                        }
                    }
                }
            }
            $sublist = $this->Crm_upload_docs_list->getCategoryList($ids,$doctype); 
            $str = "<option value=''>Select Category</option>";
            foreach($sublist as $key => $val)
            {
                if($val['is_required']=='1')
                {
                    $prntName = $val['parent_name'].' ';
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
                    $sName = $val['name'].' ';
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
        $update_img_detail = $this->Crm_upload_docs_list->getImageuploadList('','',$pendencyId,'',$doctype,$case_id);
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

    public function deleteImg()
    {
        $data = [];
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $ty = $this->input->post('doc');
        if(!empty($ty)){
            $data['status'] = '0';
            $data['updated_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
        }
        if(!empty($type))
        {
            $arr = explode(',', $id);
            foreach ($arr as $key => $value) 
            {
                if(empty($ty))
                {
                    $getImage = $this->db->select('image_url,usedcar_id')->get_where(USED_CAR_IMAGE_MAPPER,array('id'=>$value))->row_array();
                    $dc_images_array[]=['image_url'=>$getImage['image_url'],'status'=>'0'];
                    $res=$this->UserDashboard->updateNewImageFlag(['car_id'=>$getImage['usedcar_id'],'image_urls'=> serialize($dc_images_array)]);
//                    $resArr               = json_decode($res);
//                    if ($resArr->status == 'F')
//                    {
//                        $results = array('status' => 'True', 'message' => $resArr->msg, 'Action' => base_url() . 'paymentdetails/' . base64_encode(DEALER_ID . '_' . $case_id));
//                    }
                            
                    $this->UserDashboard->updateTagImageMapper('',$value,'0','0');
                }
                else
                {
                    $data['status'] = '0';
                    $data['updated_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
                    $this->Crm_upload_docs_list->insertLoginDocs($data,$value);
                }
              //$this->addCustomerPersonnelDocs('','',$value,'','2');
            }
        }
        else
        {
             if(empty($ty)){
                 
                    $getImage = $this->db->select('image_url,usedcar_id')->get_where(USED_CAR_IMAGE_MAPPER,array('id'=>$id))->row_array();
                    $dc_images_array[]=['image_url'=>$getImage['image_url'],'status'=>'0'];
                    $res=$this->UserDashboard->updateNewImageFlag(['car_id'=>$getImage['usedcar_id'],'image_urls'=> serialize($dc_images_array)]);
//                    $resArr               = json_decode($res);
//                    if ($resArr->status == 'F')
//                    {
//                        $results = array('status' => 'True', 'message' => $resArr->msg, 'Action' => base_url() . 'paymentdetails/' . base64_encode(DEALER_ID . '_' . $case_id));
//                    }
                    $this->UserDashboard->updateTagImageMapper('',$id,'0','0');
                }
            else{
                  $this->Crm_upload_docs_list->insertLoginDocs($data,$id);
            }
            //$this->addCustomerPersonnelDocs('','',$id,'','2');
            //$this->Crm_upload_docs_list->insertLoginDocs($data,$id);
        }
        return true;
    }
    public function sellerDetails($id)
    {
        $editId  = !empty($id)? explode('_',base64_decode($id)):'';
        $caseId  = !empty($editId)?end($editId):'';
        $data['pageTitle']      = 'Seller Details';
        $data['pageType']       = 'usedcarpurchase';
        ///$data['carid'] = $caseId;
        $usedCarInfo               = $this->Crm_stocks->getUsedcarInfo($caseId);
        $data['usedCarInfo'] = $usedCarInfo[0];
         $paymentDe                 = $this->Crm_stocks->getPaymentInfo($caseId);
           $data['paymentDe'] = $paymentDe;
        $data['balance_amount_left']=$this->getBalanceAmount($caseId);
        $this->loadViews("usedcarpurchase/sellerdetails",$data);
    }

    public function addEditSellInfo($params)
    {  
        if(!empty($params['case_id']))
        { 
           $upId = $params['case_id'];
           $action='1'; 
        }
        $idd = '';
        $usedCarInfo               = $this->Crm_stocks->getUsedcarInfo($params['case_id']);
        $carDetail = $usedCarInfo[0];
       // print_r($carDetail);die;
        if(!empty($carDetail['sell_cust_car_id'])){
            $idd = $carDetail['sell_cust_car_id'];
        }
        $flag = '0';
        if($carDetail['seller_name']!='')
        {
            $flag = '1';
        }
        if($carDetail['is_case_details_completed']==0){
             exit(json_encode(array('status'=>'False','message'=>'Please Complete Case Information!','Action'=>  base_url().'sellerdetails/' . base64_encode(DEALER_ID.'_'. $upId))));
        }
        $datapost    =   $this->rendersellInfoForm($params,$flag,'lead'); 
        
        $sell_customer_id = $this->Leadsellmodel->add_seller_lead_to_dc($datapost);
        if(!empty($sell_customer_id)){
            $datacarpost    =   $this->rendersellInfoCarForm($carDetail,$sell_customer_id);
            $car_details = $this->Leadsellmodel->saveSellCustomerCarDetails($datacarpost,$idd);
            $params['sell_cust_car_id'] = $car_details;
            $usedCarCaseInfo    =   $this->rendersellInfoForm($params,$flag);
            $cuBnkInfo = $this->UserDashboard->updateOtherUploads($usedCarCaseInfo,$upId);
            $this->addInsurance($params);
            if(!empty($cuBnkInfo ))
            {
                $result= array('status'=>'True','message'=>'Seller Information Added Successfully','Action'=>  base_url().'uploadcardocs/' . base64_encode(DEALER_ID.'_'. $upId).'/dis');
            }
       }
       else
       {
            $result= array('status'=>'False','message'=>'Some Error Occur','Action'=>  base_url().'sellerdetails/' . base64_encode(DEALER_ID.'_'. $upId));
       }
        echo json_encode($result);exit;

    }

    public function addCentralCustomerDetails($data)
    {
        $bnkInfor['name']                 = !empty($params['name'])?$params['name']:'';
        $bnkInfor['email']       = !empty($params['email'])?$params['email']:'';
        $bnkInfor['name_type'] = (!(empty($params['seller_type'])) && ($params['seller_type']=='2'))?'1':'2';
        $bnkInfor['address']       = !empty($params['address'])?$params['address']:'';
        $this->addUpdateMasterCustomer($bnkInfor,$bnkInfor['customer_id'],'Seller stock');

    }

    public function addInsurance($params,$flag='')
    {
        $usedCarInfo               = $this->Crm_stocks->getUsedcarInfo($params['case_id']);
        $cent_id =  $this->getCentralStockDetails('',$usedCarInfo[0]['engineno'],$usedCarInfo[0]['chassisno'],1);
        if($usedCarInfo[0]['insurance_type']!='No Insurance')
        {
            $updateCusInsurance['crm_customer_id'] = $usedCarInfo[0]['customer_id'];
            $updateCusInsurance['buyer_type'] = (!(empty($usedCarInfo[0]['seller_type'])) && ($usedCarInfo[0]['seller_type']=='2'))?'1':'2';
            $updateCusInsurance['customer_name'] = $usedCarInfo[0]['seller_name'];
            $updateCusInsurance['customer_email'] = $usedCarInfo[0]['seller_email'];
            $updateCusInsurance['customer_address'] = $usedCarInfo[0]['seller_address'];
            $updateCusInsurance['insurance_company'] = $usedCarInfo[0]['insurer_id'];
            $updateCusInsurance['policy_no'] = $usedCarInfo[0]['insurance_policy_no'];
            $updateCusInsurance['due_date'] = date('Y-m-d',strtotime($usedCarInfo[0]['insurance_date']));
            $id = $this->Crm_insurance->addInsuranceCustomer($updateCusInsurance);

            $updateCaseIns['customer_id'] =$id;
            $updateCaseIns['ins_category'] = '2';
            $updateCaseIns['regNo'] = $usedCarInfo[0]['reg_no'];
            $updateCaseIns['make'] = $usedCarInfo[0]['make_id'];
            $updateCaseIns['model'] = $usedCarInfo[0]['model_id'];
            $updateCaseIns['variantId'] =$usedCarInfo[0]['db_version_id'];
            $updateCaseIns['engineNo'] = $usedCarInfo[0]['engineno'];
            $updateCaseIns['chasisNo'] = $usedCarInfo[0]['chassisno'];
            $updateCaseIns['make_month'] = $usedCarInfo[0]['make_month'];
            $updateCaseIns['make_year'] = $usedCarInfo[0]['make_year'];
            $updateCaseIns['reg_month'] = $usedCarInfo[0]['reg_month'];
            $updateCaseIns['reg_year'] = $usedCarInfo[0]['reg_year'];
            $caseid = $this->Crm_insurance->addInsuranceCases($updateCaseIns);

            $updateCntDetail['insurance_expire'] = $usedCarInfo[0]['insurance_date'];
            $updateCntDetail['insurance_case_id'] =  $caseid;
            $updateCntDetail['seller_id'] = $usedCarInfo[0]['sell_cust_car_id'];
            $updateCntDetail['insurance_customer_id'] = $usedCarInfo[0]['customer_id'];
            $updateCntDetail['engine_no'] = $usedCarInfo[0]['engineno'];
            $updateCntDetail['chassis_no'] = $usedCarInfo[0]['chassisno'];
            $this->crmCentralStockData($updateCntDetail,'Stock','1');
        }
        return true;
    }

    public function rendersellInfoForm($params,$flag='',$lead='')
    {
        $bnkInfor                            = [];
        $customerId = $this->crmCentralCustomer($params,'Stock');
        $params['customer_id'] = !empty($customerId) ? $customerId : '';
        $this->addCentralCustomerDetails($params);

        if(empty($lead))
        {
            if(isset($params)){
            $bnkInfor['customer_id']        = !empty($params['customer_id'])?$params['customer_id']:'';
            $bnkInfor['seller_type']        = !empty($params['seller_type'])?$params['seller_type']:'';
            $bnkInfor['seller_name']        = !empty($params['name'])?$params['name']:'';
            $bnkInfor['seller_mobile']      = !empty($params['mobile'])?$params['mobile']:'';
            $bnkInfor['seller_email']       = !empty($params['email'])?$params['email']:'';
            $bnkInfor['seller_address']     = !empty($params['address'])?$params['address']:'';
            $bnkInfor['sell_cust_car_id']   = !empty($params['sell_cust_car_id'])?$params['sell_cust_car_id']:'';
            if(empty($flag))
            {
                $bnkInfor['seller_created_date']        = date('Y-m-d H:i:s');
                $bnkInfor['seller_created_by']          = $this->session->userdata['userinfo']['id'];
            }
            $bnkInfor['seller_updated_by']              = $this->session->userdata['userinfo']['id'];
            
            }
        }
        else
        {
            $bnkInfor['dealer_id'] = DEALER_ID;
            //$bnkInfor['customer_id']                  = !empty($params['customer_id'])?$params['customer_id']:'';
            $bnkInfor['add_seller_name']                 = !empty($params['name'])?$params['name']:'';
            $bnkInfor['add_seller_mobile']            = !empty($params['mobile'])?$params['mobile']:'';
            $bnkInfor['add_seller_email']       = !empty($params['email'])?$params['email']:'';
            $bnkInfor['add_seller_status']       = 'Warm';
            $bnkInfor['add_seller_source']    = 'Converted';
        }
        return $bnkInfor;
    }
    public function rendersellInfoCarForm($arr,$customer_id)
    {
        $bnkInfor                            = [];
        $bnkInfor['sell_customer_id']   = $customer_id;
        $bnkInfor['make'] = $arr['make'];
        $bnkInfor['model'] = $arr['model'];
        $bnkInfor['variant'] = $arr['carversion'];
        $bnkInfor['myear'] = $arr['make_year'];
        $bnkInfor['mmonth'] = $arr['make_month'];
        $bnkInfor['colour'] = $arr['colour'];
        $bnkInfor['pricefrom'] = $arr['car_price'];
        $bnkInfor['regno'] = $arr['reg_no'];
        //$bnkInfor['regplace'] = $arr['make'];
        $bnkInfor['regplace_city_id'] = $arr['reg_place_city_id'];
        $bnkInfor['enquiry_date'] =  date('Y-m-d H:i:s');
        //$bnkInfor['source'] = $arr['make'];
        $bnkInfor['km'] = $arr['km_driven'];
        $bnkInfor['fuel_type'] = $arr['fuel_type'];
        $bnkInfor['owner'] = $arr['owner_type'];
        $bnkInfor['car_id'] = $arr['car_id'];
        $bnkInfor['make_id'] = $arr['make_id'];
        $bnkInfor['model_id'] = $arr['model_id'];
        $bnkInfor['version_id'] = $arr['db_version_id'];
        $bnkInfor['quote_price'] = $arr['listing_price'];
        $bnkInfor['added_from'] = date('Y-m-d H:i:s');

        return $bnkInfor; 


    }
    public function paymentDetails($id)
    {
       // ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
        $editId  = !empty($id)? explode('_',base64_decode($id)):'';
        $caseId  = !empty($editId)?end($editId):'';
        $paymentDeta = [];
        $pamt = 0;
        $tamt = 0;
        $lamt = 0;
        $data['pageTitle']      = 'Payment Details';
        $data['pageType']       = 'usedcarpurchase';
        $data['banklist']= $this->getcustomerBankList();
        //$data['banklist'] = $this->Crm_banks->getBanklist();
        $usedCarInfo               = $this->Crm_stocks->getUsedcarInfo($caseId);
        $data['carid'] = $usedCarInfo[0]['car_id'];
        $data['case_id'] = $caseId;
        $data['usedCarInfo'] = $usedCarInfo[0];
        $paymentDe                 = $this->Crm_stocks->getPaymentInfo($caseId);
        $i = 0;
        foreach ($paymentDe as $key => $value) 
        {
            $pamt = $value['purchaseprice'];
            $tamt = (int)$tamt+(int)$value['amount'];


        //$paymentDeta[$i]['purchaseprice']
           $paymentDeta[$i]['id'] = $value['id'];
           $paymentDeta[$i]['purchaseprice'] = $this->IND_money_format($value['purchaseprice']);
           $paymentDeta[$i]['purchasedate'] = $value['purchasedate'];
           $paymentDeta[$i]['instrumenttype'] = $value['instrumenttype'];
           $paymentDeta[$i]['amount'] = $this->IND_money_format($value['amount']);
           $paymentDeta[$i]['insno'] = $value['insno'];
           $paymentDeta[$i]['payment_bank'] = $value['payment_bank'];
           $banks= $this->getcustomerBankList($value['payment_bank']);
           $paymentDeta[$i]['bank_name'] = $banks['bank_name'];
           $paymentDeta[$i]['insdate'] = $value['insdate'];
           $paymentDeta[$i]['favouring'] = $value['favouring'];
           $paymentDeta[$i]['payment_date'] =$value['payment_date'];
           $paymentDeta[$i]['car_id'] = $value['car_id'];
           $paymentDeta[$i]['remarks'] = $value['remarks'];
           $paymentDeta[$i]['case_id'] = $value['case_id'];
           $i++;
        }
        //if(!empty)
        $lamt = (int)$pamt - (int)$tamt; 
        if((int)$pamt <= (int)$tamt)
        {
            $lamt = 0;
        }
        $paymentDeta[0]['amountprice'] = $this->IND_money_format($tamt);
        $paymentDeta[0]['leftprice'] = $this->IND_money_format($lamt);
        $data['paymentDe'] = $paymentDeta;
        $data['total_count'] = count($paymentDe);
        $data['balance_amount_left']=$this->getBalanceAmount($caseId);
        $this->loadViews("usedcarpurchase/paymentdetails",$data);
    }

    public function addEditPaymentInfo($params)
    {
       
        $count                  = count($params['instrumenttype']);
        $data                   = [];
        $data['purchaseprice']  = str_replace(',', '', $params['purchaseprice']);
        $data['purchasedate']   = date('Y-m-d', strtotime($params['purchasedate']));
        $data['case_id']        = $params['case_id'];
        $data['car_id']         = $params['car_id'];
        $data['updated_by']     = !empty($_SESSION['userinfo']['id']) ? $_SESSION['userinfo']['id'] : '';
        $data['instrumenttype'] = $params['instrumenttype'];
        $data['amount']         = str_replace(',', '', $params['amount']);
        $data['insno']          = $params['insno'];
        $data['payment_bank']   = $params['payment_bank'];
        $data['insdate']        = date('Y-m-d', strtotime($params['insdate']));
        $data['favouring']      = $params['favouring'];
        $data['remarks']        = $params['remark'];
        $ids                    = !empty($params['ids'][$j]) ? $params['ids'] : '';
        if (empty($params['ids']))
        {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = !empty($_SESSION['userinfo']['id']) ? $_SESSION['userinfo']['id'] : '';
        }
        $data['payment_date'] = date('Y-m-d', strtotime($params['paydate']));

        
        if($data['instrumenttype'] == 1)
        {
            $amount_paid = $this->Crm_stocks->getPaymentDoneByCash($data['case_id']);
            if ($data['amount'] > 200000 )
            {
                exit(json_encode(array('status' => 'False', 'message' => 'Payment Cant Be More Than Rs 2,00,000 By Cash')));
            }
            elseif (!empty($amount_paid) && $data['amount'] > (200000 - $amount_paid['paid']))
            {
                exit(json_encode(array('status' => 'False', 'message' => 'Payment Cant Be More Than Rs 2,00,000 By Cash')));
            }
        }
        $result = $this->Crm_stocks->addUsedcarPersonnel($data, $ids);
        

        $id                 = !empty($params['edit_id']) ? $params['edit_id'] : '';
        $d['paymentdetail'] = '1';
        $this->UserDashboard->updateOtherUploads($d, $data['case_id']);
        //$result = $this->Crm_stocks->addUsedcarPersonnel($data,$id);
        $result             = array('status' => 'True', 'message' => 'Payment Information Added Successfully', 'Action' => base_url() . 'inventoryListing/');
        echo json_encode($result);
        exit;
    }

    public function refurbDetails($id)
    {
        $editId  = !empty($id)? explode('_',base64_decode($id)):'';
        $caseId  = !empty($editId)?end($editId):'';
        $paymentDeta = [];
        $data['pageTitle']      = 'Refurb Details';
        $data['pageType']       = 'usedcarpurchase';
        $data['banklist'] = $this->Crm_banks->getBanklist();
        $usedCarInfo               = $this->Crm_stocks->getUsedcarInfo($caseId);
        $data['carid'] = $usedCarInfo[0]['car_id'];
        $data['case_id'] = $caseId;
        $data['usedCarInfo'] = $usedCarInfo[0];
        $paymentDel                 = $this->Crm_stocks->getPaymentInfo($caseId);
        $paymentDe                 = $this->Crm_stocks->getRefurbInfo($caseId);
        $i = 0;
        foreach ($paymentDe as $key => $value) 
        {
            $allIds[] = $value['id'];
           $paymentDeta[$i]['purchaseprice'] = $this->IND_money_format($paymentDel[0]['purchaseprice']);
           $paymentDeta[$i]['id'] = $value['id'];
           $paymentDeta[$i]['refurb_cost'] = $this->IND_money_format($value['refurb_cost']);
           $paymentDeta[$i]['workshop_date'] = $value['workshop_date'];
           $paymentDeta[$i]['workshop_sent'] = $value['workshop_sent'];
           $paymentDeta[$i]['after_refurb_date'] = $value['after_refurb_date'];
           $paymentDeta[$i]['instrumenttype'] = $value['instrument_type'];
           $paymentDeta[$i]['amount'] = $this->IND_money_format($value['amount']);
           $paymentDeta[$i]['insno'] = $value['insno'];
           $paymentDeta[$i]['payment_bank'] = $value['bank_id'];
           $paymentDeta[$i]['insdate'] = $value['insdate'];
           $paymentDeta[$i]['favouring'] = $value['favouring'];
           $paymentDeta[$i]['payment_date'] =$value['payment_date'];
           $paymentDeta[$i]['car_id'] = $value['car_id'];
           $paymentDeta[$i]['case_id'] = $value['case_id'];
           $i++;
        }
        $data['paymentDe'] = $paymentDeta;
        $data['workshop'] = $this->Crm_adv_booking->getRefurbWorkshop();;
        $data['total_count'] = count($paymentDe);
        $data['all_ids'] = implode(',', $$allIds); 
       // $this->loadViews("usedcarpurchase/paymentdetails",$data);
        $this->loadViews("usedcarpurchase/refurbdetails",$data);
    }

    public function addEditRefurbInfo($params)
    {
       /*echo "<pre>";
        print_r($params);
        exit;*/
        $count = count($params['instrumenttype']);
        $data = [];
        $data['refurb_cost'] =str_replace(',','',$params['refurb_cost']);
        $data['workshop_date'] =date('Y-m-d',strtotime($params['workshop_date'])); 
        $data['workshop_sent'] =$params['sent_to'];
        $date = date('Y-m-d');
        $data['case_id'] = $params['case_id'];
        $data['car_id'] = $params['car_id'];   
        $data['updated_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
        $data['after_refurb_date'] =date('Y-m-d',strtotime($params['refdate']));       
        $j = 0;
        if(strtotime($date) < strtotime($data['workshop_date']))
        {
            $this->UserDashboard->updateCarStatus($data['car_id']);
        }
        for($i = 1;$i<=$count;)
        {
           
            $data['instrument_type'] = $params['instrumenttype'][$j];
            $data['amount'] = str_replace(',','',$params['amount'][$j]);
            $data['insno'] = $params['insno'][$j];
            $data['bank_id'] = $params['payment_bank'][$j];
            $data['insdate'] = date('Y-m-d',strtotime($params['insdate'][$j]));
            $data['favouring'] = $params['favouring'][$j];
            $ids = !empty($params['ids'][$j])?$params['ids'][$j]:'';
            if(empty($params['ids']))
            {
                 $data['created_at'] = date('Y-m-d H:i:s');
                 $data['created_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
            }
            $data['payment_date'] =  date('Y-m-d',strtotime($params['paydate'][$j]));
            //$params['paydate'][$j];

            $i++;
            $j++;
            $result[$i][] = $this->Crm_stocks->addUsedcarRefurb($data,$ids);
        }
        
        $id = !empty($params['edit_id'])?$params['edit_id']:'';
        $d['refurbdetail'] = '1';    
        $this->UserDashboard->updateOtherUploads($d,$data['case_id']);
        //$result = $this->Crm_stocks->addUsedcarPersonnel($data,$id);
        $result= array('status'=>'True','message'=>'Refurb Information Added Successfully','Action'=>  base_url().'inventoryListing/');
        echo json_encode($result);exit;

    }
    

     public function printpdf($caseId)
     {

      require_once(APPPATH . "third_party/dompdf/dompdf_config.inc.php");
      $printTypes = $this->input->post('printTypes');// 1 => no 2 => yes
      $dataType = $this->input->post('dataType');
      
      if(!empty($caseId)){
    // echo $caseId ; exit;
        $usedCarInfo               = $this->Crm_stocks->getUsedcarInfo($caseId);
        $data['carid'] = $usedCarInfo[0]['car_id'];
        $data['case_id'] = $caseId;
        $data['usedCarInfo'] = $usedCarInfo[0];
        $closed_by = $this->Crm_user->getEmployee('',$usedCarInfo[0]['closed_by']);
        $purchased_by = $this->Crm_user->getEmployee('',$usedCarInfo[0]['purchased_by']);
        $data['usedCarInfo']['closed_by'] = $closed_by[0]['name'];
        $data['usedCarInfo']['purchased_by_name'] = $purchased_by[0]['name'];
        
        $redirect_to= $data['usedCarInfo']['tradetype']==1 ?base_url().'inventoryListing':base_url().'paymentdetails/' . base64_encode(DEALER_ID.'_' .$caseId);
        
        if(!empty($printTypes) && $printTypes=='1'){
          
          exit(json_encode(['status'=>true,'Action'=> $redirect_to]));
        }
        
        $paymentDel                 = $this->Crm_stocks->getPaymentInfo($caseId);
        
        $this->db->select('c.city_name');
        $this->db->from('crm_outlet o');
        $this->db->join('city_list c','c.city_id=o.city','left');
        $this->db->where('dealer_id', DEALER_ID);
        $this->db->where('status', '1');
        $query = $this->db->get();
        $dealercity = $query->row_array();
        $data['dealer_showroom_city']=$dealercity['city_name'];
       
        $price=$usedCarInfo[0]['tradetype']==1?$paymentDel[0]['expected_price']:$paymentDel[0]['purchaseprice'];
        $data['paymentDel']= $this->IND_money_format($price);
        $data['paymentWord']= convertToIndianCurrency($price);
        //$data['orderId']=$orderId;
        $time=time();
        $filename            = $data['usedCarInfo']['tradetype'] == 1 ? 
                'park_and_sell_' . $caseId . '_' . $time . '.pdf' : 
                'off_load_' . $caseId . '_' . $time . '.pdf';
        }
        $html = $this->load->view('usedcarpurchase/pdfFile', $data, true);
        
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $output = $dompdf->output();
        
        $type=$data['usedCarInfo']['tradetype']==1?'park_sell_':'offload_';
        
        $upload_folder=UPLOAD_IMAGE_PATH_LOCAL.strtolower($type).'docs/';
        is_dir($upload_folder) || mkdir($upload_folder, 0777, true);
        
        $file_path=$upload_folder . $filename;
        file_put_contents($file_path, $output);
        
        if(!empty($dataType) && $dataType=='json'){
          
          exit(json_encode(['file_name' => $filename,'type'=>strtolower($type),'status'=>true,'message'=>'File Downloaded Successfully','Action'=> $redirect_to]));
        }
        $this->downloadFile($file_path,$filename);
    }
    public function downloadFile($file_path='',$file_name=''){
        
        if(empty($file_path))
        {
            $file_name = $_GET['file'];
            $type      = $_GET['type'];

           $file_path = UPLOAD_IMAGE_PATH_LOCAL . strtolower($type) . 'docs/'.$file_name;
            //$file_path='/var/www/cdn/deliverydocs/'.$file_name;
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        flush(); // Flush system output buffer
        readfile($file_path);
        exit;
    }

    function no_to_words($no)
    {   
        $words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred &','1000' => 'thousand','100000' => 'lakh','10000000' => 'crore');
        if($no == 0)
            return ' ';
        else 
        {
            $novalue='';
            $highno=$no;
            $remainno=0;
            $value=100;
            $value1=1000;       
            while($no>=100)    
            {
                if(($value <= $no) &&($no  < $value1))    
                {
                    $novalue=$words["$value"];
                    $highno = (int)($no/$value);
                    $remainno = $no % $value;
                    break;
                }
                $value= $value1;
                $value1 = $value * 100;
            }       
            if(array_key_exists("$highno",$words))
                  return $words["$highno"]." ".$novalue." ".no_to_words($remainno);
            else 
            {
                $unit=$highno%10;
                $ten =(int)($highno/10)*10;            
                return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".no_to_words($remainno);
            }
        }
    }


    public function addUsedPurchased()
    {
        /*echo "<pre>";
        print_r($_POST);
        exit;*/
        $id = '';
        $data = [];
        $id = $this->input->post('edid');
        $instrumenttype= $this->input->post('instrumenttype');
        $amount= $this->input->post('amount');
        $insno= $this->input->post('insno');
        $insdatef= $this->input->post('insdate');
        $payment_bank= $this->input->post('payment_bank');
        $favouring= $this->input->post('favouring');
        $paydates= $this->input->post('paydates');
        $case_id= $this->input->post('case_id');
        $amount = str_replace(',','',$amount);
        $data['instrumenttype'] = $instrumenttype;
        $data['amount'] = $amount;
        $data['insno'] = $insno;
        $data['payment_bank'] = $payment_bank;
        $data['insdate'] = date('Y-m-d',strtotime($insdatef));
        $data['payment_date'] = date('Y-m-d',strtotime($paydates));
        $data['favouring'] = $favouring;
         $data['remarks'] =$this->input->post('remarks');
        if(empty($id))
        {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
        }
        //$data['payment_date'] =  date('Y-m-d',strtotime($params['paydates']));
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
        $insdatef = date('Y-m-d',strtotime($insdatef));
        $paymentEdit = $this->Crm_stocks->getPaymentInfo($case_id);
         $data['purchaseprice'] = $paymentEdit[0]['purchaseprice'];
         $data['purchasedate'] = $paymentEdit[0]['purchasedate'];
         $data['car_id'] = $paymentEdit[0]['car_id'];
         $data['case_id'] =  $case_id;
         
        if($data['instrumenttype'] == 1)
        {
            $amount_paid_by_cash = $this->Crm_stocks->getPaymentDoneByCash($data['case_id'],$id);
            if ($data['amount'] > 200000 )
            {
                exit(json_encode(array('status' => 'False', 'message' => 'Payment Cant Be More Than Rs 2,00,000 By Cash')));
            }
            elseif (!empty($amount_paid_by_cash) && $data['amount'] > (200000 - $amount_paid_by_cash['paid']))
            {
                exit(json_encode(array('status' => 'False', 'message' => 'Payment Cant Be More Than Rs 2,00,000 By Cash')));
            }
        }

            $total_amount_paid = $this->Crm_stocks->getAmountPaid($data['case_id'],$id);
            if ($data['amount'] > $data['purchaseprice'] )
            {
                exit(json_encode(array('status' => 'False', 'message' => 'Payment Cant Be More Than Purchase Price')));
            }
            elseif (!empty($total_amount_paid) && $data['amount'] > ($data['purchaseprice'] - $total_amount_paid['paid']))
            {
                exit(json_encode(array('status' => 'False', 'message' => 'Payment Cant Be More Than Purchase Price')));
            }

        
        $result = $this->Crm_stocks->addUsedcarPersonnel($data,$id);
        
        $purchasepr = (int)$paymentEdit[0]['purchaseprice'];
        $amo = 0;
        foreach ($paymentEdit as $key => $value) {
            $amo = $amo+(int)$value['amount'];
        }
        $amout = $amo;
        $d['amout'] = $this->IND_money_format($amo);
        $let = (int)$purchasepr - (int)$amout;
        if((int)$purchasepr <= (int)$amout)
        {
            $let = 0;
        }
        $d['status'] ='True'; 
        $d['left'] =$this->IND_money_format($let); 
        echo json_encode($d); exit;
    }

    public function getUsedPurchased()
    {
        //echo "frdfr"; exit;
        $id = $this->input->post('editids');
        $i = 0;
        $paymentEdit = $this->Crm_stocks->getPaymentInfo('',$id); 
        foreach ($paymentEdit as $key => $value) 
        {
           $paymentDeta[$i]['id'] = $value['id'];
           //$paymentDeta[$i]['purchaseprice'] = $this->IND_money_format($value['purchaseprice']);
           //$paymentDeta[$i]['purchasedate'] = $value['purchasedate'];
           $paymentDeta[$i]['instrumenttype'] = $value['instrumenttype'];
           $paymentDeta[$i]['amount'] = $this->IND_money_format($value['amount']);
           $paymentDeta[$i]['insno'] = $value['insno'];
           $paymentDeta[$i]['payment_bank'] = $value['payment_bank'];
           $banks= $this->Crm_banks->getBankNameBybnkId($value['payment_bank']);
           $paymentDeta[$i]['bank_name'] = $banks['bank_name'];
           $paymentDeta[$i]['insdate'] = date('d-m-Y',strtotime($value['insdate']))!='01-01-1970'?date('d-m-Y',strtotime($value['insdate'])):'';//$value['insdate'];
           $paymentDeta[$i]['favouring'] = $value['favouring'];
           $paymentDeta[$i]['payment_date'] =date('d-m-Y',strtotime($value['payment_date']))!='01-01-1970'?date('d-m-Y',strtotime($value['payment_date'])):date('d-m-Y');
           $paymentDeta[$i]['car_id'] = $value['car_id'];
           $paymentDeta[$i]['remarks'] = !empty($value['remarks'])?$value['remarks']:'';
           $paymentDeta[$i]['case_id'] = $value['case_id'];
           $i++;
        }
        echo json_encode($paymentDeta);   exit;
    }


    /*public function addUsedCarDetailsApi($data,$image)
    {
        $this->UserDashboard->addUsedCarApi($data);
        return true;
    }*/
    
     public function getRtoState()
    {
        $data = [];
        $rto_id = $this->input->post('rto');
        $regno = $this->input->post('regno');
        $centralcity = $this->input->post('cntcity');
        if(!empty($regno))
        {
            $rto_state = $this->Loan_customer_case->getRtoState('',$regno);
            $state_details = $this->Loan_customer_case->getStateDetails($rto_state[0]['state']);
            $data['status'] = 'True';
            $data['rto_state'] = $rto_state[0]['state'];
            $data['rto_state_id'] = $state_details[0]['state_list_id'];
            $data['central_city_id'] = $rto_state[0]['central_city_id'];
            $str = '';
            foreach ($rto_state as $key => $value) {
              // $str .='<option value="$value[id]">$value[Registration_Index] ." ". $value[Place_of_Registration] </option>';
                $str .="<option value=".$value['rto_id'].">$value[rto_code] $value[rto_name] </option>";
            }
            echo  $str; exit;
        }
        if(!empty($rto_id))
        {
            $rto_state = $this->Loan_customer_case->getRtoState($rto_id);
            $state_details = $this->Loan_customer_case->getStateDetails($rto_state[0]['state']);
            $data['status'] = 'True';
            $data['rto_state'] = $rto_state[0]['state'];
            $data['rto_state_id'] = $state_details[0]['state_list_id'];
            $data['central_city_id'] = $rto_state[0]['central_city_id'];
       
        }

        if(!empty($centralcity))
        {
            $stateid = $this->input->post('state_id');
            $rto_state = $this->Loan_customer_case->getCityList($stateid);
            $data['status'] = 'True';
            $data['city_list'] = $rto_state;
        }

        echo json_encode($data); exit;
    }
    
    public function getBalanceAmount($case_id=0)
    {

        $paymentDetails = $this->Crm_stocks->getPaymentDetails($case_id);

        $purchase_amount = !empty($paymentDetails['purchase_amount']) ? $paymentDetails['purchase_amount'] : 0;
        $total_payment   = !empty($paymentDetails['paid']) ? $paymentDetails['paid'] : 0;
        return ($purchase_amount - $total_payment);
    }
    
    public function getCustomerLeadDetails(){
       $customerDetails = array(); 
       $customer_mobile = $this->input->post('customer_mobile');
       if(!empty($customer_mobile)){
           $customerDetails = $this->Crm_used_car_sale_case_info->getLeadCustomerDetails($customer_mobile);
       }
       echo json_encode($customerDetails); exit;
       
    }

}
?>
