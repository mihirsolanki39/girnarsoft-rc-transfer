<?php

class UsedCarSale extends MY_Controller {

    public function index() {
        
    }

    public function __construct() {
        parent::__construct();
        $this->dateTime=date("Y-m-d H:i:s");
        $this->load->model('Crm_used_car_sale_case_info');
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
        $this->load->model('Crm_used_car_sale_transaction');
        $this->load->model('Crm_used_car_sale_booking');
        $this->load->model('Crm_used_car_sale_payment');
        $this->load->model('Crm_used_car_sale_delivery');
        $this->load->model('Crm_insurance');
        $this->load->model('Crm_buy_customer_status');
        $this->load->model('Crm_buy_lead_customer');
        $this->load->model('Crm_lead_customer_detail');
        $this->load->model('Crm_buy_lead_addedit_log');
        $this->load->helper('curl_helper');
        $this->is_admin_or_accountant=$_SESSION['userinfo']['is_admin']==1 || $_SESSION['userinfo']['role_id']==20;
        
    }
    
    function AddLeadIndex($encoded_case_id=0) {
        $data                      = [];

        $decoded_case_id= base64_decode($encoded_case_id);
        $case=explode('_',$decoded_case_id);
        //print_r($case);dieCrm_buy_lead_customer
        $car_id=$case[0];
        $case_id=$case[1];
        $this->verifyUsedCarSalesURL($case);
        $data['pageTitle'] = 'Add Buyer Lead';
        $data['pageType']  = 'usedcarsale';
        $data['case_id']   = $case_id;
        $data['car_id']   = $car_id;
        $query_string         = $this->input->get();
        $data['query_string'] = !empty($query_string)?$query_string:[];
        
        $salesStatus             = $this->Crm_used_car_sale_case_info->getSalesStatus($case_id);
        $data['category']        = $this->crm_stocks->usedCarPurchaseCat();
        $stockDetails            = $this->crm_stocks->getcarDetail($car_id,['car_status']);
        $leadDetails             = $this->Crm_used_car_sale_case_info->getCustomerDetails($car_id);
        //print_r($leadDetails);die;
        $data['car_status']=$stockDetails['car_status'];
        
        $data['salesStatus'] = $salesStatus[0];
        $data['form'] = 'buyer_details';
        
        $ucSalesCaseInfo     = $this->Crm_used_car_sale_case_info->getUcSalesCaseInfo($case_id);
        if(!empty($query_string)){
           !empty($query_string['mobile'])?$ucSalesCaseInfo['customer_mobile']=$query_string['mobile']:'';
           !empty($query_string['email'])?$ucSalesCaseInfo['customer_email']=$query_string['email']:'';
           !empty($query_string['name'])?$ucSalesCaseInfo['customer_name']=$query_string['name']:'';
           empty($ucSalesCaseInfo['buyer_type'])?$ucSalesCaseInfo['buyer_type']=1:'';
            
        }
        $data['headerData'] = $this->headerData($ucSalesCaseInfo);
        
        $data['ucSalesCaseInfo'] = $ucSalesCaseInfo;
        $data['leadData'] = $leadDetails;
        $data['ucSalesCaseInfo']['car_id'] = $car_id;
        
        //print_r($data['headerData']);die;
        $this->loadViews("usedcarsale/addBuyerDetails", $data);
    }
    public function headerData($ucSalesCaseInfo){
        
    return [
            'reg_no'          => $ucSalesCaseInfo['reg_no'],
            'make'            => $ucSalesCaseInfo['make'],
            'model'           => $ucSalesCaseInfo['model'],
            'version'         => $ucSalesCaseInfo['version'],
            'customer_name'   => $ucSalesCaseInfo['buyer_type'] == 1 ? $ucSalesCaseInfo['customer_name'] : $ucSalesCaseInfo['company_name'],
            'customer_mobile' => $ucSalesCaseInfo['customer_mobile'],
            'sale_amount'     => $ucSalesCaseInfo['sale_amount'],
            'booking_amount'  => $ucSalesCaseInfo['booking_amount'],
        ];
    }
    
    public function saveUpdateUsedCarsaleData($id = '') {
        $params = $this->input->post();
        if(!empty($params['step1'])){
            $this->addupdateBuyerDetails($params);
            
        }
        if(!empty($params['step2'])){
            $this->addupdateTranxDetails($params);
            
        }
        if(!empty($params['step3'])){
            $this->addupdateBookingDetails($params);
        }
        if(!empty($params['step6'])){
            $this->addupdatePaymentDetails($params);
        }
        if(!empty($params['step7'])){
            $this->addupdateDeliveryDetails($params);
        }
        //echo json_encode($params);exit;
    }
    public function addupdateBuyerDetails($params){
        //print_r($params);die;
        $leadMapperData=[];
        $validationCheck=$this->step1ValidateForm($params);
        
            if(!empty($validationCheck)){
                echo  json_encode($validationCheck);
            }else{
                $leadMapperData['name']=!empty($params['customer_name']) ? $params['customer_name']:'';
                $leadMapperData['mobile']=!empty($params['customer_mobile']) ? $params['customer_mobile']:'';
                $leadMapperData['email']=!empty($params['customer_email']) ? $params['customer_email']:'';
                $case_id = $this->Crm_used_car_sale_case_info->addBuyerDetails($params);
                if (!empty($case_id))
                {
                    $result = array('status' => true, 'message' => 'Buyer Details Added Successfully', 'Action' => base_url() . 'ucSalesTxnDetails/' . base64_encode($params['car_id'].'_'.$case_id));
                }
            echo json_encode($result);exit;
            }
    }
    public function addupdateTranxDetails($params)
    {
       $validationCheck = $this->step1ValidateForm($params);
        if (!empty($validationCheck))
        {
            echo json_encode($validationCheck);
        }
        else
        {
            $tranxData_new     = $this->Crm_used_car_sale_transaction->createData($params);
            
            $isTranxExists = $this->Crm_used_car_sale_transaction->getTranxData($params['caseId']);

            //$advance_payment = $tranxData_new['advance_payment'];
            //echo $balance_amount=$this->findBalanceAmount($params['caseId']);die;
            //$this->amountPayableByAdmin($tranxData_new['advance_payment'],$params['caseId']);
            $tranx_id      = 0;
            if ($isTranxExists)
            {
                $tranx_id = $isTranxExists[0]['id'];
            }
            else if($_SESSION['userinfo']['role_id']!='24') 
            {
                $tranxData_new['actual_amount'] = str_replace(',','',$params['total_amt']);   
            }
            else
            {
              $tranxData_new['actual_amount'] = str_replace(',','',$params['actual_sales_amount']);  
            }
            $last_id = $this->Crm_used_car_sale_transaction->SaveTransactionData($tranxData_new,$tranx_id);
            if (!empty($last_id))
            {
             $this->db->where('id',$params['caseId'])->update('crm_used_car_sale_case_info',['is_tranx_details_completed'=>'1']);
             
             //CHANGE STATUS OF CAR to Booked=4 or Sold=3
//             $car_status= $tranxData_new['trnx_status']==1?'4':'3';
//             $this->db->where('id', $params['car_id'])->update('crm_used_car',
//                     ['car_status'=>$car_status,'last_update_date'=>date('Y-m-d H:i:s')]);
             
             //ADD ADVANCE PAYMENT IN PAYMENT DETAILS
             $paymentDetails=$this->Crm_used_car_sale_payment->getAdvancePayment($params['caseId']);
             if(!empty($paymentDetails)){
                 $payment=[
                     'amount'=>!empty($tranxData_new['advance_payment'])?$tranxData_new['advance_payment']:0,
                     'updated_by'        => $_SESSION['userinfo']['id']
                 ];
                 $this->Crm_used_car_sale_payment->savePaymentData($payment,$paymentDetails[0]['id']);
             }
             else{
                   $payment=[
                        'uc_sales_case_id' => $params['caseId'],
                        'amount'           => !empty($tranxData_new['advance_payment']) ? $tranxData_new['advance_payment'] : 0,
                        'payment_date'     => date('Y-m-d H:i:s'),
                        'is_advance_payment'  => '1',
                        'updated_by'        => $_SESSION['userinfo']['id']
                    ];
                    $this->Crm_used_car_sale_payment->savePaymentData($payment);
                    
                    
             }
             if($params['issue_new_insurance']=='yes'){
                    $insuranceCase = $this->addInsurance($params);
                    $this->db->where('id', $params['caseId']);
                    $this->db->update('crm_used_car_sale_case_info', ['insurance_case_id' => $insuranceCase['insurance_case_id'],'insurance_customer_id'=>$insuranceCase['insurance_customer_id']]);
             }
             if($params['is_loan_req']=='yes'){
                    $loanCase = $this->addLoan($params);
                    $this->db->where('id', $params['caseId']);
                    $this->db->update('crm_used_car_sale_case_info', ['loan_case_id' => $loanCase['loan_case_id'],'loan_customer_id'=>$loanCase['loan_customer_id']]);
             }
             
             $result = array('status' => true, 'message' => 'Transactions Details Added Successfully', 'Action' => base_url() . 'ucSalesBookingDetails/' . base64_encode($params['car_id'] . '_' . $params['caseId']));
            }
            echo json_encode($result);
            exit;
        }
    }
    public function  addupdateBookingDetails($params){
     //   echo $params['caseId']; exit;
        $validationCheck = $this->step1ValidateForm($params);
        if (!empty($validationCheck))
        {
            echo json_encode($validationCheck);
        }
        else
        {
            $ucSalesCaseInfo     = $this->Crm_used_car_sale_case_info->getUcSalesCaseInfo($params['caseId']);
            //print_r($ucSalesCaseInfo);die;
           

            $bookingDataNew     = $this->Crm_used_car_sale_booking->createData($params);
            //print_r($bookingDataNew);die;
            $isBookingDataExists = $this->Crm_used_car_sale_booking->getBookingData($params['caseId']);
            //print_r($isTranxExists);die;
            $booking_id      = 0;
            if ($isBookingDataExists)
            {
                $booking_id = $isBookingDataExists[0]['id'];
            }
            $last_id = $this->Crm_used_car_sale_booking->saveBookingData($bookingDataNew,$booking_id);
            if (!empty($last_id))
            {
                
                
                //ADD ADVANCE PAYMENT IN PAYMENT DETAILS
                $paymentDetails=$this->Crm_used_car_sale_payment->getAdvancePayment($params['caseId']);
                $payment=[
                    'amount'          => !empty($bookingDataNew['booking_amount']) ? str_replace(',','',$bookingDataNew['booking_amount']) : 0,
                    'instrument_no'   => !empty($bookingDataNew['instrument_no']) ? $bookingDataNew['instrument_no'] : 0,
                    'instrument_type'   => !empty($bookingDataNew['instrument_type']) ? $bookingDataNew['instrument_type'] : 0,
                    'instrument_date' => !empty($bookingDataNew['instrument_date']) ? $bookingDataNew['instrument_date'] : 0,
                    'bank_id'         => !empty($bookingDataNew['bank_id']) ? $bookingDataNew['bank_id'] : 0,
                    'favouring'       => !empty($bookingDataNew['favouring']) ? $bookingDataNew['favouring'] : 0,
                    'payment_date'    => !empty($bookingDataNew['payment_date']) ? $bookingDataNew['payment_date'] : date('Y-m-d H:i:s'),
                    'updated_by'      => $_SESSION['userinfo']['id'],
                    'role_id'       => !empty($_SESSION['userinfo']['role_id'])?$_SESSION['userinfo']['role_id']:''
                ];
                if(!empty($paymentDetails)){
                    $this->Crm_used_car_sale_payment->savePaymentData($payment,$paymentDetails[0]['id']);
                }
                else{
                      $payment['uc_sales_case_id'] = $params['caseId'];
                      $payment['is_advance_payment']  = '1';
                     // $payment['role_id']       => !empty($_SESSION['userinfo']['role_id'])?$_SESSION['userinfo']['role_id']:'';
                      $this->Crm_used_car_sale_payment->savePaymentData($payment);
                }
                //MARK BOOKING STATUS AS COMPLETE
                $this->db->where('id',$params['caseId'])->update('crm_used_car_sale_case_info',['is_booking_details_completed'=>'1']);
                
                $stockData    = $this->db->get_where('crm_used_car',array('id'=>$params['car_id']))->result_array();
                
                //MARK STOCK AS BOOKED
                if($stockData[0]['car_status']==1){
                     $this->db->where('id', $params['car_id'])->update('crm_used_car',
                     ['car_status'=>'4','last_update_date'=>date('Y-m-d H:i:s')]);
                }
                
               
                
                $this->updateLeadStatus($params['car_id'],"Booked", $params['booking_amount']);
                
                

                $redirect_to= base_url() . 'uploadUcSalesDocument/' . base64_encode($params['car_id'] . '_' . $params['caseId']);
                $this->send_booking_sms($params['caseId']);
                $leadResponse=$this->updateLead($ucSalesCaseInfo,'Booked');
                
                if($stockData[0]['car_status']==4){
                    $redirect_to=  base_url() . 'inventoryListing?status=booked';
                }
                $result = array('status' => true, 'message' => 'Booking Details Added Successfully', 'Action' =>$redirect_to);
            }
            echo json_encode($result);
            exit;
        }
    }
   
    public function addupdatePaymentDetails($params)
    {
        $validationCheck = $this->step1ValidateForm($params);
        if (!empty($validationCheck))
        {
            echo json_encode($validationCheck);
        }
        else
        {
            
            $balance_amount=$this->findBalanceAmount($params['caseId'],$params['edid']);
            $canDoPayment= str_replace(',','',$params['amount']) > $balance_amount;
            //echo $canDoPayment;die;

            if($canDoPayment){
                exit( json_encode(array('status' => false, 'message' => 'Payment Can\'t Be More Than Outstanding Amount')));

            }
            
             //print_r($tranxData);die;
            //$this->amountPayableByAdmin($params['amount'],$params['caseId']);
            
            $paymentDataNew = $this->Crm_used_car_sale_payment->createData($params);

            $isPaymentDataExists = $this->Crm_used_car_sale_payment->getPaymentById($params['edid']);
            //print_r($isPaymentDataExists);die;
            $payment_id          = 0;
             $message = "Payment Details Added Successfully";
            if ($isPaymentDataExists)
            {
                $payment_id = $isPaymentDataExists[0]['id'];
                $message = "Payment Details Updated Successfully";
            }
            $last_id = $this->Crm_used_car_sale_payment->savePaymentData($paymentDataNew,$payment_id);
            if (!empty($last_id))
            {
                $redirect_to = base_url() . 'ucSalesPaymentDetails/' . base64_encode($params['car_id'] . '_' . $params['caseId']);
                
                //IF BALANCE IS NILL THEN SET PAYMENT STATUS = COMPLETE
                if ($paymentDataNew['amount'] - $balance_amount == 0)
                {
                   
                    $this->db->where('id', $params['caseId'])->update('crm_used_car_sale_case_info', ['is_payment_details_completed' => '1']);
                    $redirect_to = base_url() . 'ucSalesDeliveryDetails/' . base64_encode($params['car_id'] . '_' . $params['caseId']);
                }

                $stockData   = $this->db->get_where('crm_used_car', array('id' => $params['car_id']))->result_array();

//                if ($stockData[0]['car_status'] == 4)
//                {
//                    $redirect_to = base_url() . 'inventoryListing?status=booked';
//                }
                $result = array('status' => true, 'message' => $message, 'Action' => $redirect_to);
            }
            echo json_encode($result);
            exit;
        }
    }
    public function amountPayableByAdmin($payment, $case_id)
    {
        $tranxData = $this->Crm_used_car_sale_transaction->getTranxData($case_id);
        $amount_paid = $this->Crm_used_car_sale_payment->paymentByAdmin($case_id);

       // print_r($tranxData);die;
        if (!empty($tranxData) && $this->is_admin_or_accountant)
        {
            $actual_sale_amount = $tranxData[0]['actual_amount'];
            $sale_amount        = $tranxData[0]['amount'];
            if (str_replace(',', '', $payment)+$amount_paid > ($actual_sale_amount - $sale_amount))
            {
                exit(json_encode(array('status' => false, 'message' => 'You  are\'t Authorized Do Payment')));
            }
        }
    }

    public function  addupdateDeliveryDetails($params){
        
        $validationCheck = $this->step1ValidateForm($params);
        if (!empty($validationCheck))
        {
            echo json_encode($validationCheck);
        }
        else
        {
            $ucSalesCaseInfo     = $this->Crm_used_car_sale_case_info->getUcSalesCaseInfo($params['caseId']);
            $bookingDataNew     = $this->Crm_used_car_sale_delivery->createData($params);
            
            $isDeliveryDataExists = $this->Crm_used_car_sale_delivery->getDeliveryData($params['caseId']);
            
            $delivery_id      = 0;
            if ($isDeliveryDataExists)
            {
                $delivery_id = $isDeliveryDataExists[0]['id'];
            }
            $last_id = $this->Crm_used_car_sale_delivery->saveDeliveryData($bookingDataNew,$delivery_id);
            if (!empty($last_id))
            {
                $this->db->where('id', $params['caseId'])->update('crm_used_car_sale_case_info', ['is_delivery_details_completed' => '1']);
                $this->crm_stocks->updateMarktoSold(['car_status' => '3'], $params['car_id']);
                
                $tranxData             = $this->Crm_used_car_sale_transaction->getTranxData($params['caseId']);
                
                
                
                $this->updateLeadStatus($params['car_id'],"Converted",$tranxData[0]['actual_amount']);
                
                
                
                
                $this->send_delivery_sms($params['caseId']);
                $this->updateLead($ucSalesCaseInfo,'Converted');
                //$stockData    = $this->db->get_where('crm_used_car',array('id'=>$params['car_id']))->result_array();
                
//                if($stockData[0]['car_status']==3){
//                }
//                if($stockData[0]['car_status']==4){
//                    $redirect_to=  base_url() . 'inventoryListing?status=booked';
//                }
                    //$redirect_to=  base_url() . 'inventoryListing?status=sold';
                    $redirect_to=  base_url() . 'uploadUcSalesDocument/' . base64_encode($params['car_id'].'_'.$params['caseId']).'/diss';
                               //$results= array('status'=>'True','message'=>'Docs uploaded Successfully','Action'=>  );
                $result = array('status' => true, 'message' => 'Delivery Details Added Successfully', 'Action' =>$redirect_to);
            }
            echo json_encode($result);
            exit;
        }
    }

    public function step1ValidateForm($params){
        return false;
    }
    public function canDoPayment($payment, $balance_amount)
    {
        return $payment <= $balance_amount;
    }

    public function findBalanceAmount($case_id,$payment_id=''){
         $tranxData                 = $this->Crm_used_car_sale_transaction->getTranxData($case_id);
        //$paymentData               = $this->Crm_used_car_sale_payment->getPaymentData($case_id);
        $amount_paid               = $this->Crm_used_car_sale_payment->getTotalAmountPaid($case_id,$this->is_admin_or_accountant,$payment_id,$_SESSION['userinfo']['role_id']);
        if($_SESSION['userinfo']['role_id']=='24'){
        $total_sale_amount = $tranxData[0]['actual_amount'];
    }
    else{
     $total_sale_amount=$tranxData[0]['actual_amount'];
    }
//        if($this->is_admin_or_accountant)
//        {
//            $total_sale_amount=$tranxData[0]['actual_amount'];
//        }
       
        return $balance_amount=$total_sale_amount-$amount_paid;
    }

    public function uploadCustomerDocs($encoded_case_id,$document_type=''){
        
        //$editId      = !empty($case_id)? explode('_',base64_decode($case_id)):'';
        //$caseId  = !empty($editId)?end($editId):'';
       
        
        $decoded_case_id= base64_decode($encoded_case_id);
        
        $case=explode('_',$decoded_case_id);
        $caseId=$case[1];
        $car_id=$case[0];
        $data = [];
        $salesStatus             = $this->Crm_used_car_sale_case_info->getSalesStatus($caseId);
        
        if(empty($salesStatus)){
            header('location:'.base_url('inventoryListing/'));
        }
        if($salesStatus[0]['booking_id'] == 0){
            $redirect_to = base_url('ucSalesTxnDetails/' .$encoded_case_id);
            header('location:' . $redirect_to); 
        }
        $data['salesStatus'] = $salesStatus[0];
        $data['form'] = $document_type!=''?'vehicle_details':'doc_details';
        
        $stockDetails            = $this->crm_stocks->getcarDetail($car_id,['car_status']);
        $data['car_status']=$stockDetails['car_status'];
        
        $seg = $this->uri->segment(3);
        if(!empty($seg))
        {
            $data['disbural'] = '1';
        }
        
        $ucSalesCaseInfo     = $this->Crm_used_car_sale_case_info->getUcSalesCaseInfo($caseId);
        $data['headerData'] = $this->headerData($ucSalesCaseInfo);
        
        $bnkId = '';
        $uploadDocList = [];
        $data['pageTitle']      = 'Sales Upload Docs';
        $data['pageType']       = 'usedcarsale';
        $data['case_id']   = $caseId;
        $data['car_id']    = $car_id;
        if(!empty($caseId))
        {
            $custInfo       = $this->Loan_customer_case->usedcarsalesid($caseId);
            $data['CustomerInfo']  = $custInfo;
        }
       // $data['rolemgmt'] = $this->financeUserMgmt('','uploadDocs');
       
        $this->loadViews("usedcarsale/uploadCustomerDocs",$data);

    }
    public function saveLoginDocs()
    {
        
        
        $err = [];
        $bank = [];
        $req_id = [];
        $req = [];
        $caseInfo = [];
        $tagArr = [];
        $req_sid = [];
        //print_r($this->input->post());die;
        $customer_id = $this->input->post('customer_id');
        $case_id = $this->input->post('case_id');
        $ucSalesCaseInto =  $this->Crm_used_car_sale_case_info->getUcSalesCaseInfo($case_id);
       // print_r($ucSalesCaseInto);die;
//        $arrCustomer = $arr[0];
        $doctype = $this->input->post('doctype');
        $imageList = $this->Crm_upload_docs_list->getImageList($customer_id,"","","",$doctype,$case_id);
        /*echo "<pre>";
        print_r($imageList);
        exit;*/
        $checkPendency = $this->Crm_upload_docs_list->getPendencyDetail($case_id,$doctype);
       /* echo "<pre>";
        print_r($checkPendency);
        exit;*/
        $docList = $this->Crm_upload_docs_list->getDocList('0',$doctype);
         /*echo "<pre>";
        print_r($docList);
        exit;*/
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
            if($imgv['tag_id']=='42')
            {
               $tagArr[] = '7'; 
            }
            $tagArr[] = $imgv['tag_id'];
            $bank[] = $imgv['bank_id'];
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
       /* echo "<pre>";
        print_r($docList);
        exit;*/
            foreach($docList as $key => $val)
            {
                if(($val['is_require']>0))
                {
                    //echo "fefe".'----'.$val['id'];
                    $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'],$doctype); 
                    foreach ($sublist as $skey => $sval)
                    {
                        $uploadDocList['name'] = $sval['name'];
                        if($sval['is_require']>0)
                        {
                            $req_sid[$val['parent_id']][]=$sval['sub_category_id'];
                        }                    
                    }   
                }
//                else if(($arrCustomer['loan_for']=='2') && ($val['parent_id']=='7') && ($doctype=='1'))
//                {
//                    $req_sid['parent_id'][]='42';
//                }   
                
            }

            foreach($req_sid as $rkey => $rval)
            {
                foreach($rval as $kr)
                {
                    if(!in_array($kr, $tagArr))
                    {
                        $results= array('status'=>'False','message'=>'Please upload all required Doc');
                        //echo json_encode($results); exit;
                    }
                }
            }
            if($doctype=='8')
            {
                //$caseInfo['upload_login_update_date']=date('Y-m-d H:i:s');
//                if($arrCustomer['upload_docs_created_at']=='0000-00-00 00:00:00')
//                {
//                    $caseInfo['loan_approval_status'] = '7';
//                    $caseInfo['upload_docs_created_at']=date('Y-m-d H:i:s');
//                }
                //$caseInfo['last_updated_date'] = date('Y-m-d H:i:s');
                $caseInfo['is_buyer_docs_uploaded']='1';
                $this->Crm_used_car_sale_case_info->saveUpdateCaseInfo($caseInfo, $case_id);
               // $document = "Login Document Uploaded";
//                if(!empty($checkPendency))
//                {
//                    $document = "Login Upload Docs with Pendency";
//                }
//                $this->addLoanHistoryUpdateLog($case_id,'-',$document,'','0');
//                $this->addLoanHistory($case_id,$document,'-','','-','',$this->session->userdata['userinfo']['id']);
                //$lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($dataed, $case_id,'1');
                 $results= array('status'=>'True','message'=>'Docs uploaded Successfully','Action'=>base_url() . 'ucSalesPaymentDetails/' . base64_encode($ucSalesCaseInto['car_id'] . '_' . $case_id));
                //$results= array('status'=>'True','message'=>'Docs uploaded Successfully','Action'=>  base_url() . 'uploadUcSalesDocument/' . base64_encode($ucSalesCaseInto['car_id'].'_'.$case_id).'/diss');
            }
            if($doctype=='9')
            {
//                $caseInfo['upload_dis_doc_flag']='1';
//                $caseInfo['upload_disburse_doc_update']=date('Y-m-d H:i:s');
//                if($arrCustomer['upload_dis_created_date']=='0000-00-00 00:00:00')
//                {
//                    $caseInfo['loan_approval_status'] = '8';
//                    $caseInfo['upload_dis_created_date']=date('Y-m-d H:i:s');
//                }
//                $caseInfo['last_updated_date'] = date('Y-m-d H:i:s');
                 
                 $caseInfo['is_vehicle_images_uploaded']= !empty($imageList)?'1':'0';
                 $this->Crm_used_car_sale_case_info->saveUpdateCaseInfo($caseInfo, $case_id);
                //$document = "Disbursal Document Uploaded";
//                if(!empty($checkPendency))
//                {
//                    $document = "Disbursal Upload Docs with Pendency";
//                }
//                $this->addLoanHistoryUpdateLog($case_id,'-',$document,'','0');
//                $this->addLoanHistory($case_id,$document,'-','','-','',$this->session->userdata['userinfo']['id']);
//               
                //$lastUpdateDate = $this->Loan_customer_case->saveUpdateCaseInfo($dataed, $case_id);
                //$results= array('status'=>'True','message'=>'Docs uploaded Successfully','Action'=>base_url() . 'ucSalesPaymentDetails/' . base64_encode($ucSalesCaseInto['car_id'] . '_' . $case_id));
                $results= array('status'=>'True','message'=>'Vehicle Delivery Pics uploaded Successfully','Action'=>base_url() . 'inventoryListing?status=sold');
            }
          
        echo json_encode($results); exit;
    }

    public function logindoc()
    {
        $customerId  = $this->input->post('customer_id');
        $caseId  = $this->input->post('cases_id');
        $imgListUpdated = '';
        $arr = ['1','2','3','4','5','6'];
        $data = [];
        $imgListArr = [];
        $personnelDocs = [];
        $bnkId = '';
        $uploadDocList = [];
        $a = [];
        $b = [];
        $data['pageTitle']      = 'Sales Docs';
        $data['pageType']       = 'usedcarsale';
        if(!empty($customerId)){
            $custInfo       = $this->Loan_customer_case->usedcarsalesid($caseId);
            $data['CustomerInfo']  = $custInfo;
        }

        $docList = $this->Crm_upload_docs_list->getDocList('','8');
        foreach($docList as $key => $val)
        {
            $uploadDocList[$val['parent_id']]['name']= $val['parent_name'];
            $uploadDocList[$val['parent_id']]['is_require']= $val['is_require'];

            $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'],'8'); 
            foreach ($sublist as $skey => $sval)
            {
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['name'] = $sval['name'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['sub_category_id'] = $sval['sub_category_id'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = $sval['is_require'];
                   }   
        }
        $data['uploadDocList'] = $uploadDocList;
        $i = 0;
        $imgListUpdated = $this->Crm_upload_docs_list->getImageList($customerId,'','','','8',$caseId);
        if(!empty($imgListUpdated))
        {
            $tagIdN = [];
            foreach($imgListUpdated as $imgK => $imgV)
            {
                $tagIdN = $imgV['tag_id'];
                $name = '';
                $bank_name = '';
                if(in_array($imgV['tag_id'], $arr))
                {
                   $imageTag = $this->Crm_upload_docs_list->getImageList('','',$imgV['tag_id'],'','8',$caseId);
                   $bankname = $this->Crm_banks->getBankNameBybnkId($imageTag[0]['bank_id']);
                   $bank_name = $imgV['name'].(!empty($bankname['bank_name'])?'( '.$bankname['bank_name'].' )':'');
                }

                if(!empty($bank_name))
                {
                    $name = $bank_name;
                }
                else
                {
                    $name = $imgV['name'];
                }
                $a['allids'][]       =   $imgV['sub_id'];
                $imgListArr[$i]['id']           =   $imgV['id'];
                $imgListArr[$i]['doc_name']     =   $imgV['doc_name'];
                $imgListArr[$i]['doc_url']      =  (($imgV['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$imgV['doc_url'];
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
        if(!empty($a['allids']))
        {
            $sublistsss = $this->Crm_upload_docs_list->getDocList('','8','','','','',$a['allids']); 
            foreach($sublistsss as $ssub => $kkk)
            {
                $b['allParentIds'][] = $kkk['parent_id'];
            }
         }
        $data['imageList'] =  $imgListArr;
        $data['allParentIds'] =  !empty($b)?$b:'';
        $data['pendencyDoc'] = $this->Crm_upload_docs_list->getPendencyDetail($caseId,1);

        
        echo $datas=$this->load->view('usedcarsale/loginDoc',$data,true); exit;
        //$this->loadViews("finance/loginDocs",$data);
    }
    public function checkList(){
        $caseId  = $this->input->post('case_id');
        $doctype  = $this->input->post('doctype');
        
        $data['case_id']=$caseId;
        $data['doc_type']=$doctype;
        $uploadDocList=[];
        $docList = $this->Crm_upload_docs_list->getDocList('',$doctype);
        $imgListUpdated = $this->Crm_upload_docs_list->getChecklistDoc($caseId,$doctype);
        $chekLists = $this->Crm_upload_docs_list->getDocCheckList($caseId,$doctype);
        $checkList_new=[];
        foreach($chekLists as $checkList)
        {

            $checkList_new[$checkList['tag_id']] = $checkList['status'];
        }
        $tag_list_id=[];
        foreach($imgListUpdated as  $imgV)
        {

            $tag_list_id[] = $imgV['id'];
        }
        $data['allsub_id']=$tag_list_id;
        foreach($docList as $key => $val)
        {
            $uploadDocList[$val['parent_id']]['name']= $val['parent_name'];
            $uploadDocList[$val['parent_id']]['is_require']= $val['is_require'];
            
            $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'],'8'); 
            foreach ($sublist as $skey => $sval)
            {
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['name'] = $sval['name'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['check_status'] = $checkList_new[$sval['id']];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['sub_category_id'] = $sval['sub_category_id'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = $sval['is_require'];
            }   
        }
        
        $data['uploadDocList'] = $uploadDocList;
        $this->load->view('usedcarsale/checklist',$data);
    }
    public function saveCheckList(){
        $caseId  = $this->input->post('case_id');
        $doctype  = $this->input->post('doc_type');
        $checklist=$this->input->post();
        unset($checklist['case_id'],$checklist['doc_type']);
        //print_r($checklist);die;
        $last_id=$this->saveCheckListData($checklist,$caseId,$doctype);
        $ucSalesCaseInfo     = $this->Crm_used_car_sale_case_info->getUcSalesCaseInfo($caseId);
        $car_id =$ucSalesCaseInfo['car_id'];
        if($last_id){
            $caseInfo['is_buyer_docs_uploaded']='1';
            $this->Crm_used_car_sale_case_info->saveUpdateCaseInfo($caseInfo, $caseId);
        $result = array('status' => true, 'message' => 'Checklist Details Saved Successfully',
            'Action' => base_url() . 'ucSalesPaymentDetails/' . base64_encode($car_id.'_'.$caseId));
        }
        else{
            $result = array('status' => false, 'message' => 'Checklist Details Couldn\'t Be Saved ',
            'Action' => base_url() . 'uploadUcSalesDocument/' . base64_encode($car_id.'_'.$caseId).'/diss');
        }
        exit(json_encode($result));
    }

    public function disbursedoc()
    {
        $customerId  = $this->input->post('customer_id');
        $caseId  = $this->input->post('cases_id');
        $data = [];
        $b =[];
        $imgListUpdated = '';
        $arr = ['8','9','10','11','12','13'];
        $imgListArr = [];
        $bnkId = '';
        $uploadDocList = [];
        $data['pageTitle']      = 'Upload Vehicle Docs';
        $data['pageType']       = 'usedcarsale';
        
        if(!empty($customerId)){
            $custInfo       = $this->Loan_customer_case->usedcarsalesid($caseId);
            $data['CustomerInfo']  = $custInfo;
        }
        $docList = $this->Crm_upload_docs_list->getDocList('','6');

        foreach($docList as $key => $val)
        {
            $uploadDocList[$val['parent_id']]['name']= $val['parent_name'];
            $uploadDocList[$val['parent_id']]['is_require']= $val['is_require'];
            //echo $data['CustomerInfo']['loan_for'].'-'.$val['id'];
            $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'],'6'); 
            foreach ($sublist as $skey => $sval)
            {
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['name'] = $sval['name'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['sub_category_id'] = $sval['sub_category_id'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = $sval['is_require'];
            }   
        }
        $data['uploadDocList'] = $uploadDocList;
        $i = 0;
        $imgListUpdated = $this->Crm_upload_docs_list->getImageList($customerId,'','','','9',$caseId);
        if(!empty($imgListUpdated))
        {
            foreach($imgListUpdated as $imgK => $imgV)
            {
                $name = '';
                $bank_name = '';
                if(in_array($imgV['tag_id'], $arr))
                {
                   $imageTag = $this->Crm_upload_docs_list->getImageList('','',$imgV['tag_id'],'','9',$caseId);
                   $bankname = $this->Crm_banks->getBankNameBybnkId($imageTag[0]['bank_id']);
                   $bank_name = $imgV['name'] .' ('. $bankname['bank_name'].')';
                }
                $a['allids'][]       =   $imgV['sub_id'];
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
         if(!empty($a['allids']))
        {
            $sublistsss = $this->Crm_upload_docs_list->getDocList('','6','','','','',$a['allids']); 
            foreach($sublistsss as $ssub => $kkk)
            {
                $b['allParentIds'][] = $kkk['parent_id'];
            }
         }
           $data['imageList'] =  $imgListArr;
        $data['allParentIds'] =  !empty($b)?$b:'';
        //$data['imageList'] =  $imgListArr;
        $data['pendencyDoc'] = $this->Crm_upload_docs_list->getPendencyDetail($caseId,'6');
        /*echo "<pre>";
        print_r($data);
        exit;*/
        echo $datas=$this->load->view('usedcarsale/disburseDoc',$data,true); exit;
    }

public function getTagName()
    {
        $arr        = ['1','2','3','4','5','6'];
        $tagid      = $this->input->post('tagid');
        $caseid     = $this->input->post('case_id');
        $imag_id    = $this->input->post('imag_id');
        $doctype    = $this->input->post('doctype');
        $errImg= "";
        if(!empty($imag_id))
        {
            $imageTags = $this->Crm_upload_docs_list->getImageList('',$imag_id,'','',$doctype,$caseid);
            if(!empty($imageTags))
            {
                if($imageTags[0]['err']>0)
                {
                    $errImg = ($imageTags[0]['err']==1)?'Incorrect Doc':'Unclear Image';
                    echo json_encode($errImg); exit;
                }
                if(in_array($imageTags[0]['tag_id'], $arr))
                {
                   $imageTag = $this->Crm_upload_docs_list->getImageList('','',$imageTags[0]['tag_id'],'',$doctype,$caseid);
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
            $imTag = $this->Crm_upload_docs_list->getImageList('','',$tagid,'',$doctype,$caseid);
            /*echo "<pre>";
            print_r($imTag);
            exit;*/
            if(!empty($imTag))
            {
                if(in_array($tagName[0]['id'], $arr))
                {
                    $imageTagss = $this->Crm_upload_docs_list->getImageList('','',$tagName[0]['id'],'',$doctype,$caseid);
                    $bankname = $this->Crm_banks->getBankNameBybnkId($imageTagss[0]['bank_id']);
                    $bank_name = $tagName[0]['name'] .' ( '. $bankname['bank_name'].' )';
                    echo json_encode($bank_name); exit;
                }
              echo json_encode($tagName[0]['name']); exit;
            }
        }
        echo json_encode(''); exit;
    }
 public function deleteImg()
    {
        $data = [];
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $data['status'] = '0';
        $data['updated_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
        if(!empty($type))
        {
            $arr = explode(',', $id);
            foreach ($arr as $key => $value) 
            {
              $imageList = $this->Crm_upload_docs_list->getImageList('',$value,'','','8');
              
                if ($imageList)
                {
                    $tag_id  = $imageList[0]['tagid'];
                    $case_id = $imageList[0]['case_id'];

                    //SAVE CHECKLIST
                    $des['tag_id']   = $tag_id;
                    $des['case_id']  = $case_id;
                    $des['doc_type'] = '8';
                    $des['status']   = '2';
                    $this->Crm_upload_docs_list->saveCheckLists([$des], $case_id);
                }
                $this->Crm_upload_docs_list->insertLoginDocs($data,$value);
              //$this->addCustomerPersonnelDocs('','',$value,'','2');
            }
        }
        else
        {
            $imageList = $this->Crm_upload_docs_list->getImageList('',$id,'','','8');
            
            if ($imageList)
            {
                $tag_id  = $imageList[0]['tagid'];
                $case_id = $imageList[0]['case_id'];

                $des['tag_id']   = $tag_id;
                $des['case_id']  = $case_id;
                $des['doc_type'] = '8';
                $des['status']   = '2';
                
                $this->Crm_upload_docs_list->saveCheckLists([$des], $case_id);
            }
            //$this->addCustomerPersonnelDocs('','',$id,'','2');
            $this->Crm_upload_docs_list->insertLoginDocs($data,$id);
        }
        return true;
    }

    public function getImagedownload($caseId,$doc='1')
    {
        //echo "fff"; exit;
        $this->load->library('zip');
        $data = [];
       // $doc = 1;
        $imageList = $this->Crm_upload_docs_list->getImageList('','','','',$doc,$caseId);
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
           
            $imageName = $this->Crm_upload_docs_list->getImageList('','','','','','','','',$arr);
            $imgdata=array();
            $h = 1;
            foreach ($imageName as $key => $value) 
            {
                if(!empty($value))
                {
                    $newfname='';
                    $imgContet='';
                    $newfname = !empty($value['aws_url'])?$value['aws_url']:UPLOAD_IMAGE_PATH_LOCAL.'uploadSalesDocs/'.$value['doc_name'];
                    $imgContet=file_get_contents($newfname);
                    if(!empty($value['name'])){
                        $a = explode('.', $value['doc_name']);
                        $nam =  $h . '-' .$value['buyer_name'].'-'.$value['name'].'.'.$a[1];
                        //$nam = $value['name'].'.'.$a[1];
                    }
                    else
                    {
                        $nam = $h . '-' . $value['doc_name'];  
                    }
                    $imgdata[$nam] = $imgContet;
                }
                else
                {
                    echo "error"; exit;
                }
                $h++;
          }
          if(!empty($imgdata)){
          $time=time();
          $filename='files_backup_'.$time;
          $this->zip->add_data($imgdata);
          $this->zip->archive('uploadSalesDocs/'.$filename.'.zip');
          $this->zip->download($filename);
          }else{
             echo "error"; exit; 
          }

        }
        
        $this->uploadDocs($caseId);
    }
    

    public function showImagesToTag()
    {
        $customer_id = $this->input->post('customer_id');
        $case_id= $this->input->post('case_id');
       
        $doctype= $this->input->post('doctype');
        $data = [];
        $i = 0;
        $doc = '8';
        if(!empty($doctype))
        {
            $doc = '9';
        }
        $imageList = $this->Crm_upload_docs_list->getImageList($customer_id,'','','',$doc,$case_id);
        $str = '[';
        foreach($imageList as $key => $val)
        {
            $image_type=end(explode('.',$val['doc_name']));
            $data[$i]['id'] = $val['id'];
            $data[$i]['small'] = (($val['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$val['doc_url'];
            $data[$i]['big'] = (($val['sent_to_aws']=='1')?AWS_PATH:UPLOAD_IMAGE_URL).$val['doc_url'];
            $data[$i]['image_type'] = $image_type;
            $data[$i]['tag_id'] = $val['tag_id'];
            $i++;
        }
        echo json_encode($data); exit;
    }

    public function loanTagMapping()
    {
        error_reporting(0);
        $data = [];
        $err =[];
        $doc = '8';
        $dc = '8';
        $doctype = $this->input->post('doctype');
        if(!empty($doctype))
        {
            $doc = '9';
            $dc = '6';
        }
        $id = $this->input->post('id');
        $flag = $this->input->post('flag');
        $customer_id = $this->input->post('customer_id');
        $case_id = $this->input->post('case_id');
        $img =  $this->input->post('ImgID');
        $tag = $this->input->post('taggID');
        $bank = $this->input->post('bank');
        $type = $this->input->post('type');
        $subcat = $this->input->post('subcat');
        $reason_id = $this->input->post('reason_id');
        $check_list_status= $this->input->post('tag_status');
      //  echo $type; exit;
        //print_r($this->input->post());die;
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

        else if(!empty($flag))
        {
            $img_detail = $this->Crm_upload_docs_list->getImageuploadList('','','','',$doc,$case_id,'','','','',$tag);
        } 
        else
        {
             $img_detail = $this->Crm_upload_docs_list->getImageuploadList($customer_id,$img,'','',$doc,$case_id);
        }
       
        //print_r($img_detail);die;
        //$img_detail = $this->Crm_upload_docs_list->getImageList($customer_id,$img,'','',$doc,$case_id);   
        if(($type=='add') || ($type=='bank'))
        {
           // echo "sfrfrf"; exit;    
            $data['created_on'] = date('Y-m-d H:i:s');
            $data['created_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
            if((empty($img_detail)) && (!empty($data['tag_id'])))
            {
                //echo "seeee"; exit;
                $checkPendency = $this->Crm_upload_docs_list->getPendencyDetail($case_id,$dc,$data['tag_id']);
                //echo
                $imageList = $this->Crm_upload_docs_list->insertTagMapping($data);
               // $this->addCustomerPersonnelDocs($doc,$customer_id,$img,$tag,'',$subcat);
                if(!empty($checkPendency))
                {
                    $datass['pendency_status'] = 'Resolved';
                    $datass['status'] = '0';
                    $datass['image_id'] = $imageList;
                    $checkPendency = $this->Crm_upload_docs_list->insertPendencyMapping($datass,$checkPendency[0]['id']);
                }
               // echo "ddddd"; exit; 
                //SAVE CHECKLIST
                $des['tag_id']   = $tag;
                $des['case_id']  = $case_id;
                $des['doc_type'] = $doc;
                $des['status']   = '1';
                if($tag=='234'){
                  $des['tag_id'] = '239' ;  
                  $this->Crm_upload_docs_list->saveCheckLists([$des], $case_id);
                }
                if($des['tag_id']=='239'){
                  $des['tag_id'] = '234' ;  
                  $this->Crm_upload_docs_list->saveCheckLists([$des], $case_id);
                }
                $this->Crm_upload_docs_list->saveCheckLists([$des], $case_id);
                
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
                $imageList = $this->Crm_upload_docs_list->insertTagMapping($data,$img_detail[0]['imgID']);
                //$this->addCustomerPersonnelDocs($doc,$customer_id,$img,'','2');
                $err['msg'] = "Tagged Removed Successfully"; 
                $err['status'] = "1";
                $err['tag_id'] = $img_detail[0]['tag_id'];
                $err['parent_tag_id'] = $img_detail[0]['parent_tag_id'];
                
                //SAVE CHECKLIST
                $des['tag_id']   = $img_detail[0]['parent_tag_id'];
                $des['case_id']  = $case_id;
                $des['doc_type'] = $doc;
                $des['status']   = '2';
               if($des['tag_id']=='234'){
                  $des['tag_id'] = '239' ;  
                  $this->Crm_upload_docs_list->saveCheckLists([$des], $case_id);
                }
                if($des['tag_id']=='239'){
                  $des['tag_id'] = '234' ;  
                  $this->Crm_upload_docs_list->saveCheckLists([$des], $case_id);
                }
                $this->Crm_upload_docs_list->saveCheckLists([$des], $case_id);
                
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
            $update_img_detail = $this->Crm_upload_docs_list->getImageList($customer_id,$img,'','',$doc);
            //$this->addCustomerPersonnelDocs($doc,$customer_id,$img,'','1');
            $data['mark_incorrect'] = $reason_id;
            $data['tag_id'] = '';
            $data['updated_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
            $imageList = $this->Crm_upload_docs_list->insertTagMapping($data,$update_img_detail[0]['imgID']);
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
        $imggg = $this->Crm_upload_docs_list->getImageList('','','','',$doctype,$case_id);
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
               
                    foreach ($imggg as $k => $v) {
                       /* if(($v['tag_id']=='64')||($v['tag_id']=='129') || ($v['tag_id']=='135')||($v['tag_id']=='136'))
                        {
                           $dd[] = $v['tag_id'];
                           $ids[] =  $v['tag_id'];
                        }
                        else*/ if(!empty($v['parent_id']))
                        {
                            $ids[] = $v['parent_id'];
                        }
                    }
            }
            $sublist = $this->Crm_upload_docs_list->getCategoryList($ids,$doctype); 
            $str = "<option value=''>Select Category</option>";
            foreach($sublist as $key => $val)
            {
                if($val['is_required']=='1')
                {
                    $prntName = $val['parent_name'].'';
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
                    $sName = $val['name'].'';
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
        $update_img_detail = $this->Crm_upload_docs_list->getImageList('','',$pendencyId,'',$doctype,$case_id);
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






   /* public function uploadVehicleDocs(){
echo "UsedCarSale/uploadVehicleDocs";die;
    }*/
   
    public function uploadLoginDocs()
    {
        $arr = $this->uri->segment(3);
        $ar  = explode('-', $arr);
        
        $data = [];       
        $file_name_key              = key($_FILES);
        $config['upload_path']      = UPLOAD_IMAGE_PATH_LOCAL.'uploadSalesDocs/';
        $config['allowed_types']    = ['gif', 'png', 'jpg','jpeg','pdf','tif'];
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
            $data['doc_url'] = 'uploadSalesDocs/'.$datas['file_name'];
            $data['doc_type'] = '8';
            if(!empty($ar['2']))
            {
                $data['doc_type'] = '9';
            }
            $data['customer_id'] = $ar['1'];
            $data['case_id'] = $ar['0'];
            $data['created_on'] = date('Y-m-d h:i:s');
            $data['created_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';

              $result = $this->Crm_upload_docs_list->insertLoginDocs($data);
              echo trim($result); exit;
 
         }
        else
        {
           $error  = array('Invalid Request!');
           echo $result = array('error' => $error, 'status' => 400); exit;
        }
       
    }
    public function getTransactionDetails($encoded_case_id)
    {
        $data                    = [];
        $data['pageTitle']       = 'Add Buyer Lead';
        $data['pageType']        = 'usedcarsale';
        $decoded_case_id         = base64_decode($encoded_case_id);
        $case                    = explode('_', $decoded_case_id);
        $this->verifyUsedCarSalesURL($case);
        $case_id                 = $case[1];
        $car_id                  = $case[0];
        $data['case_id']         = $case_id;
        $data['car_id']          = $car_id;
        $bankList= json_encode($this->Crm_banks_List->crmBankName());
        $data['bankList']= json_decode($bankList,1);
        
        $ucSalesCaseInfo     = $this->Crm_used_car_sale_case_info->getUcSalesCaseInfo($case_id);
        $data['headerData'] = $this->headerData($ucSalesCaseInfo);
        
        $stockDetails            = $this->crm_stocks->getcarDetail($car_id,['car_status']);
        $data['car_status']=$stockDetails['car_status'];
        
        $ucSalesExec             = $this->Crm_user->getEmployeeByRoleAndTeam(7, 21);
        $tranxData             = $this->Crm_used_car_sale_transaction->getTranxData($case_id);
        
        $salesStatus             = $this->Crm_used_car_sale_case_info->getSalesStatus($case_id);
        
        $total_sale_amount = $tranxData[0]['amount'];
        if($this->is_admin_or_accountant)
        {
            $total_sale_amount=$tranxData[0]['actual_amount'];
        }
        $data['salesStatus'] = $salesStatus[0];
        $data['form'] = 'tranx_details';
        //print_r($salesStatus);die;
        $data['ucSalesExecList'] = $ucSalesExec;
        $data['tranxData'] = $tranxData[0];
        $this->loadViews("usedcarsale/transactionDetails", $data);

    }

    public function getBookingDetails($encoded_case_id)
    {
        $data              = [];
        $data['pageTitle'] = 'Add Buyer Lead';
        $data['pageType']  = 'usedcarsale';
        $decoded_case_id   = base64_decode($encoded_case_id);
        $case              = explode('_', $decoded_case_id);
        $this->verifyUsedCarSalesURL($case);
        $case_id           = $case[1];
        $car_id            = $case[0];
        $data['case_id']   = $case_id;
        $data['car_id']    = $car_id;
        $bankList= json_encode($this->Crm_banks_List->crmBankName());
        $data['bankList']= json_decode($bankList,1);
        
        $stockDetails            = $this->crm_stocks->getcarDetail($car_id,['car_status']);
        $data['car_status']=$stockDetails['car_status'];
        
        $ucSalesCaseInfo     = $this->Crm_used_car_sale_case_info->getUcSalesCaseInfo($case_id);
        $data['headerData'] = $this->headerData($ucSalesCaseInfo);
        
        $bookingData = $this->Crm_used_car_sale_booking->getBookingData($case_id);
        //print_r($bookingData);die;
        $tranxData             = $this->Crm_used_car_sale_transaction->getTranxData($case_id);
        $data['advance_payment']=$tranxData[0]['advance_payment'];
        $data['bookingData']=$bookingData[0];
        
        $salesStatus             = $this->Crm_used_car_sale_case_info->getSalesStatus($case_id);
        $data['salesStatus'] = $salesStatus[0];
        $data['form'] = 'booking_details';
        
        $this->loadViews("usedcarsale/bookingDetails", $data);
    }

    public function getPaymentDetails($encoded_case_id)
    {
        $data              = [];
        $data['pageTitle'] = 'Add Buyer Lead';
        $data['pageType']  = 'usedcarsale';
        $decoded_case_id   = base64_decode($encoded_case_id);
        $case              = explode('_', $decoded_case_id);
        $this->verifyUsedCarSalesURL($case);
        $case_id           = $case[1];
        $car_id            = $case[0];
        $data['case_id']   = $case_id;
        $data['car_id']    = $car_id;
        
        
        $data['bankList']= $this->getcustomerBankList();
        
        $stockDetails            = $this->crm_stocks->getcarDetail($car_id,['car_status']);
        $data['car_status']=$stockDetails['car_status'];
        
        $ucSalesCaseInfo     = $this->Crm_used_car_sale_case_info->getUcSalesCaseInfo($case_id);
        $data['headerData'] = $this->headerData($ucSalesCaseInfo);
        
        $tranxData                 = $this->Crm_used_car_sale_transaction->getTranxData($case_id);
        $amount_paid               = $this->Crm_used_car_sale_payment->getTotalAmountPaid($case_id,$this->is_admin_or_accountant,'',$_SESSION['userinfo']['role_id']);
        $paymentData               = $this->Crm_used_car_sale_payment->getPaymentData($case_id,$_SESSION['userinfo']['role_id']);
        
        $salesStatus             = $this->Crm_used_car_sale_case_info->getSalesStatus($case_id);
        //print_r($salesStatus);die;
        /*echo "<pre>";
        print_r($tranxData);
        exit;*/
        $data['salesStatus'] = $salesStatus[0];
        $data['form'] = 'payment_details';
        
        $total_sale_amount = $tranxData[0]['amount'];
        if($_SESSION['userinfo']['role_id']=='24')
        {
            $total_sale_amount=$tranxData[0]['actual_amount'];
        }
        //NOT ADMIN AND ACCOUNTANT
        //$ap=0;
//        if(!$this->is_admin_or_accountant)
//        {
//           $new_payment= array_filter($paymentData, function($payment) {
//               //$ap+=$payment['amount'];
//                if ($payment['role_id']==21 || $payment['is_advance_payment']=='1')
//                {
//                    return true;
//                }
//            });
//            $paymentData=$new_payment;
//        }
       
        //print_r($paymentData);die;
        $data['total_sale_amount']   = $total_sale_amount;
        $data['amount_paid']         = $amount_paid;
        $balance_left = (int)($total_sale_amount - $amount_paid);
        $data['balance_amount_left'] = $balance_left>0?$balance_left:0;
        $data['paymentData']         = $paymentData;
       //echo "<pre>"; print_r($data);die;
        $this->loadViews("usedcarsale/paymentDetails", $data);
        //echo "UsedCarSale/uploadVehicleDocs";
        //die;
    }
    
      public function getexshowprice()
    {
        $caseid = $this->input->post('caseid');
        $exprice=$this->crm_stocks->getPaymentDetails($caseid);
        if($exprice['purchase_amount'] == ""){
        echo $exprice['expected_price'];    
        }else{
        echo $exprice['purchase_amount'];   
        }
        exit;
    }

    
    
    public function getPaymentById(){
        $params = $this->input->post();
        $payment_id= $params['editids'];
        $paymentData = $this->Crm_used_car_sale_payment->getPaymentById($payment_id);
        //print_r($paymentData);die;
        $paymentData[0]['amount'] = indian_currency_form($paymentData[0]['amount']);
        $paymentData[0]['instrument_date'] = $paymentData[0]['instrument_date']!='0000-00-00 00:00:00'?date('d-m-Y', strtotime($paymentData[0]['instrument_date'])):date('d-m-Y');
        $paymentData[0]['payment_date']    = date('d-m-Y', strtotime($paymentData[0]['payment_date']));
        echo json_encode($paymentData);die;
    }

    public function getDeliveryDetails($encoded_case_id)
    {
        $data=[];
        $data['pageTitle'] = 'Add Buyer Lead';
        $data['pageType'] = 'usedcarsale';
        
        $decoded_case_id= base64_decode($encoded_case_id);
        $case=explode('_',$decoded_case_id);
        $this->verifyUsedCarSalesURL($case);
        $case_id=$case[1];
        $car_id=$case[0];
        
        $stockDetails            = $this->crm_stocks->getcarDetail($car_id,['car_status']);
        $data['car_status']=$stockDetails['car_status'];
        
        $ucSalesCaseInfo     = $this->Crm_used_car_sale_case_info->getUcSalesCaseInfo($case_id);
        $data['headerData'] = $this->headerData($ucSalesCaseInfo);
        
        $paymentStatus=$this->paymentStatus(['case_id'=>$case_id,'car_id'=>$car_id]);
       
        $salesStatus             = $this->Crm_used_car_sale_case_info->getSalesStatus($case_id);
        $data['salesStatus'] = $salesStatus[0];
        $data['form'] = 'delivery_details';
        
        if (!$paymentStatus['status'])
        {
            $redirect_to = base_url('ucSalesPaymentDetails/' . base64_encode($car_id . '_' . $case_id));
            header('location:' . $redirect_to);
        }
        
        $deliveryData = $this->Crm_used_car_sale_delivery->getDeliveryData($case_id);
        $data['deliveryData']         = $deliveryData[0];
        //print_r($deliveryData);die;
        $data['case_id']   = $case_id;
        $data['car_id']    = $car_id;
        $this->loadViews("usedcarsale/deliveryDetails", $data);
       
    }
    public function paymentStatus($request=[])
    {   
        $params = !empty($this->input->post())?$this->input->post():$request;
        
        $tranxData   = $this->Crm_used_car_sale_transaction->getTranxData($params['case_id']);
        //$paymentData               = $this->Crm_used_car_sale_payment->getPaymentData($case_id);
        $amount_paid = $this->Crm_used_car_sale_payment->getTotalAmountPaid($params['case_id'], $this->is_admin_or_accountant,'',$_SESSION['userinfo']['role_id']);

        $amount_paid_x = $this->Crm_used_car_sale_payment->getTotalAmountPaid($params['case_id'], $this->is_admin_or_accountant,'','24');

        $total_sale_amount = $tranxData[0]['actual_amount'];
//        if ($this->is_admin_or_accountant)
//        {
//            $total_sale_amount = $tranxData[0]['actual_amount'];
//       }
       // echo $total_sale_amount .'-'.$amount_paid;
        $balance_amount = (int)$total_sale_amount - (int)$amount_paid;
        $balance_amount_x = (int)$total_sale_amount - (int)$amount_paid_x;
      // exit; 
        if($balance_amount_x > 0)
        {
            $result = json_encode(array('status' => false, 'message' => 'Payment Is Pending'));
        }
        else
        {
            $result = json_encode(array('status' => true, 'message' => '', 'Action' => base_url('ucSalesDeliveryDetails/' . base64_encode($params['car_id'] . '_' . $params['case_id']))));
        }
        if($request){
            return (array)json_decode($result);
        }
        echo $result;
    }
    
    public function addInsurance($params,$flag='')
    {
        //print_r($params);die;
        $usedCarInfo = $this->Crm_used_car_sale_case_info->getSalesCaseData($params['caseId']);
        //print_r($usedCarInfo);die;
       // $cent_id     = $this->getCentralStockDetails('', $usedCarInfo[0]['engineno'], $usedCarInfo[0]['chassisno'], 1);
        
            $updateCusInsurance['crm_customer_id']   = $usedCarInfo[0]['customer_id'];
            $updateCusInsurance['buyer_type']        = $usedCarInfo[0]['seller_type'];
            $updateCusInsurance['customer_name']     = $usedCarInfo[0]['seller_name'];
            $updateCusInsurance['customer_email']    = $usedCarInfo[0]['seller_email'];
            $updateCusInsurance['customer_address']  = $usedCarInfo[0]['seller_address'];
            !empty($usedCarInfo[0]['insurer_id'])?$updateCusInsurance['insurance_company'] = $usedCarInfo[0]['insurer_id']:'';
            !empty($usedCarInfo[0]['policy_no'])?$updateCusInsurance['policy_no']         = $usedCarInfo[0]['insurance_policy_no']:'';
            !empty($usedCarInfo[0]['insurance_date'])?$updateCusInsurance['due_date']          = date('Y-m-d', strtotime($usedCarInfo[0]['insurance_date'])):'';
            $id                                      = $this->Crm_insurance->addInsuranceCustomer($updateCusInsurance,$usedCarInfo[0]['insurance_customer_id']);

        $updateCaseIns['customer_id']         = $id;
        $updateCaseIns['ins_category']        = '2';
        $updateCaseIns['source']              = 'walkin';
        $updateCaseIns['regNo']               = $usedCarInfo[0]['reg_no'];
        $updateCaseIns['make']                = $usedCarInfo[0]['make_id'];
        $updateCaseIns['model']               = $usedCarInfo[0]['model_id'];
        $updateCaseIns['variantId']           = $usedCarInfo[0]['db_version_id'];
        $updateCaseIns['engineNo']            = !empty($usedCarInfo[0]['engineno'])?$usedCarInfo[0]['engineno']:'';
        $updateCaseIns['chasisNo']            = !empty($usedCarInfo[0]['chassisno'])?$usedCarInfo[0]['chassisno']:'';
        $updateCaseIns['make_month']          = !empty($usedCarInfo[0]['make_month'])?$usedCarInfo[0]['make_month']:'';
        $updateCaseIns['make_year']           = !empty($usedCarInfo[0]['make_year'])?$usedCarInfo[0]['make_year']:'';
        $updateCaseIns['reg_month']           = !empty($usedCarInfo[0]['reg_month'])?$usedCarInfo[0]['reg_month']:'';
        $updateCaseIns['reg_year']            = !empty($usedCarInfo[0]['reg_year'])?$usedCarInfo[0]['reg_year']:'';
        $updateCaseIns['car_city']            = !empty($usedCarInfo[0]['city_id'])?$usedCarInfo[0]['city_id']:'';
        $updateCaseIns['last_updated_status'] = '1';
        $caseid                        = $this->Crm_insurance->addInsuranceCases($updateCaseIns,$usedCarInfo[0]['insurance_case_id']);

            $updateCntDetail['insurance_expire']      = $usedCarInfo[0]['insurance_date'];
            $updateCntDetail['insurance_case_id']     = $caseid;
            $updateCntDetail['reg_no']     = $usedCarInfo[0]['reg_no'];
            $updateCntDetail['seller_id']             = $usedCarInfo[0]['sell_cust_car_id'];
            $updateCntDetail['insurance_customer_id'] = $usedCarInfo[0]['customer_id'];
            $updateCntDetail['engine_no']             = $usedCarInfo[0]['engineno'];
            $updateCntDetail['chassis_no']            = $usedCarInfo[0]['chassisno'];
            $this->crmCentralStockData($updateCntDetail, 'Stock', '1');
        
        return ['insurance_customer_id'=>$id,'insurance_case_id'=>$caseid];
    }
      public function addLoan($params,$flag='')
    {
        //print_r($params);die;
        $usedCarInfo = $this->Crm_used_car_sale_case_info->getSalesCaseData($params['caseId']);
        //print_r($usedCarInfo);die;
       // $cent_id     = $this->getCentralStockDetails('', $usedCarInfo[0]['engineno'], $usedCarInfo[0]['chassisno'], 1);
        
            $leadInfoParams['customer_id'] = $usedCarInfo[0]['customer_id'];
            $leadInfoParams['Buyer_Type']  = $usedCarInfo[0]['seller_type']==1?'2':'1';
            $leadInfoParams['name']        = $usedCarInfo[0]['seller_name'];
            $leadInfoParams['email']       = $usedCarInfo[0]['seller_email'];

            $id       = $this->Loan_customer_info->saveUpdateCustomerInfo($leadInfoParams,$usedCarInfo[0]['loan_customer_id']);
             
            $caseInfoParams['customer_loan_id']  = $id;
            $caseInfoParams['loan_for'] = '2';
            $caseInfoParams['loan_type'] = 'Purchase';
            $caseInfoParams['regno']        = $usedCarInfo[0]['reg_no'];
            $caseInfoParams['makeId']         = $usedCarInfo[0]['make_id'];
            $caseInfoParams['modelId']        = $usedCarInfo[0]['model_id'];
            $caseInfoParams['versionId']    = $usedCarInfo[0]['db_version_id'];
            $caseInfoParams['engine_number']     = !empty($usedCarInfo[0]['engineno'])?$usedCarInfo[0]['engineno']:'';
            $caseInfoParams['chassis_number']     = !empty($usedCarInfo[0]['chassisno'])?$usedCarInfo[0]['chassisno']:'';
           
            $caseInfoParams['loan_expected']      = $usedCarInfo[0]['loan_amount'];
            $caseInfoParams['bank_expected']      = $usedCarInfo[0]['bank_id'];
            $caseInfoParams['roi_expected']      = $usedCarInfo[0]['roi'];
            $caseInfoParams['tenor_expected']     = $usedCarInfo[0]['tenure'];
            //$caseInfoParams['last_updated_status'] = '5';
//            $caseInfoParams['make_month']   = $usedCarInfo[0]['make_month'];
//            $caseInfoParams['make_year']    = $usedCarInfo[0]['make_year'];
//            $caseInfoParams['reg_month']    = $usedCarInfo[0]['reg_month'];
//            $caseInfoParams['reg_year']     = $usedCarInfo[0]['reg_year'];
//            $caseInfoParams['car_city']     = $usedCarInfo[0]['city_id'];

            $caseid = $this->Loan_customer_case->saveUpdateCaseInfo($caseInfoParams,$usedCarInfo[0]['loan_case_id']);
            
            $updateCntDetail['insurance_expire']      = $usedCarInfo[0]['insurance_date'];
            $updateCntDetail['loan_case_id']          = $caseid;
            $updateCntDetail['reg_no']                = $usedCarInfo[0]['reg_no'];
            $updateCntDetail['seller_id']             = $usedCarInfo[0]['sell_cust_car_id'];
            $updateCntDetail['loan_customer_id']      = $usedCarInfo[0]['customer_id'];
            $updateCntDetail['engine_no']             = $usedCarInfo[0]['engineno'];
            $updateCntDetail['chassis_no']            = $usedCarInfo[0]['chassisno'];
            $this->crmCentralStockData($updateCntDetail, 'Stock', '1');
        
        return ['loan_customer_id'=>$id,'loan_case_id'=>$caseid];
    }
    function send_booking_sms($case_id){
        
        $usedCarSaleData = $this->Crm_used_car_sale_case_info->getSalesCaseData($case_id);
        //print_r($usedCarSaleData);die;
        $sms_data=$usedCarSaleData[0];
        
        $customer_name = $sms_data['seller_name'];
        $make          = $sms_data['make'];
        $model         = $sms_data['model'];
        $version       = $sms_data['version'];
        $booking_amount       = $sms_data['advance_payment'];
        
        if (!empty($sms_data['parent_model_id']))
        {
            $parent_model     = $this->db->query("SELECT model
                                FROM  make_model
                            where id=" . $sms_data['parent_model_id'])->row_array();
            $model = $parent_model['model'];
        }
        
        $sms_text="Dear $customer_name ,
            
                    Thank you for choosing ".ORGANIZATION." as your trusted partner towards booking $make $model $version with an amount of Rs ".indian_currency_form($booking_amount)."
                     Please call on ".DEALER_MOBILE." for any assistance.
                     - Greetings
                    ".ORGANIZATION;
       //9958035434
        $mobile = APPLICATION_ENV=='local'?'8512070952':'7289880677';
        
       $result=SEND_SMS($mobile, $sms_text);
       return json_encode($result);
    }
    function send_delivery_sms($case_id){
        
        $usedCarSaleData = $this->Crm_used_car_sale_case_info->getSalesCaseData($case_id);
        $sms_data=$usedCarSaleData[0];
        
        $customer_name = $sms_data['seller_name'];
        $make          = $sms_data['make'];
        $model         = $sms_data['model'];
        $version       = $sms_data['version'];
        
        if (!empty($sms_data['parent_model_id']))
        {
            $parent_model     = $this->db->query("SELECT model
                                FROM  make_model
                            where id=" . $sms_data['parent_model_id'])->row_array();
            $model = $parent_model['model'];
        }
        $mobile = APPLICATION_ENV=='local'?'8512070952':'7289880677';
        $sms_text="Dear $customer_name ,
                    Congratulations for your $make $model $version. Hope to serve you again. You can contact us on ".DEALER_MOBILE." for Insurance Renewals.
                    - Greetings
                   ".ORGANIZATION;
       
       $result=SEND_SMS($mobile, $sms_text);
       return json_encode($result);
    }
    public function verifyUsedCarSalesURL($case)
    {

        $case_id = $case[1];
        $car_id  = $case[0];

        if (empty($case_id))
        {
            $caseData             = $this->Crm_used_car_sale_case_info->getUcSalesCaseByCarid($car_id);
            //print_r($caseData);die;
            if(empty($caseData)){
                return true;
            }
            $case_id              = $caseData['id'];
            $salesCaseDetails     = $this->Crm_used_car_sale_case_info->getSalesStatus($case_id);
            //print_r($salesCaseDetails);die;
            $sales_edit_form_link = $this->crm_stocks->getUcSalesEditLink($salesCaseDetails, $car_id, $case_id);
            header('location:' . $sales_edit_form_link);
            die;
        }
        return true;
    }

    
 public function addNewLead($requestData = '')
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
        $followDatee = date("Y-m-d H:i:s", strtotime($leadDataPost['followdate']));
        if (!empty($leadDataPost['dfollowdate']))
        {
            $dfollowDatee = date("Y-m-d H:i:s", strtotime($leadDataPost['dfollowdate'])); //previous follw date
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
                    && !empty($requestParams['car_id']) && intval($requestParams['car_id']) > 0){
                $autoPrefillingPreferences = $this->Crm_buy_lead_customer_preferences->autoPrefillingPreferences($leadmapperId['lead_dealer_mapper_id']);
                //$requestParams['makeIds']  = !empty($autoPrefillingPreferences['make_id']) ? $autoPrefillingPreferences['make_id'] : '';
                //$requestParams['modelIds'] = !empty($autoPrefillingPreferences['model_id']) ? $autoPrefillingPreferences['model_id'] : '';
                $requestParams['makeIds']  = !empty($requestParams['makeIds']) ? implode(',',array_unique(array_merge(explode(',',$requestParams['makeIds']),explode(',',$autoPrefillingPreferences['make_id'])))) : $autoPrefillingPreferences['make_id'];
                $requestParams['modelIds'] = !empty($requestParams['modelIds']) ? implode(',',array_unique(array_merge(explode(',',$requestParams['modelIds']),explode(',',$autoPrefillingPreferences['model_id'])))):$autoPrefillingPreferences['model_id'];
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
        return json_encode($outPutData);
        
    }
    
    public function updateLeadStatus($car_id,$status,$amount){
         //MARK LEAD AS BOOKED
                $salesCaseInfo = $this->Crm_used_car_sale_case_info->getUcSalesCaseByCarid($car_id);
                if(!empty($salesCaseInfo)){
                  $LeadStatusUpdate['lead_id'] = $salesCaseInfo['ldm_id'];
                  $LeadStatusUpdate['txtmobile'] = $salesCaseInfo['customer_mobile'];
                  $LeadStatusUpdate['status'] = $status;
                  $LeadStatusUpdate['follow_up'] =  date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' + 1 days'));
                  $LeadStatusUpdate['rating'] = "";
                  $LeadStatusUpdate['reminder_date'] = "";
                  $LeadStatusUpdate['comment'] = "";
                  $LeadStatusUpdate['feedback'] = "";
                  $LeadStatusUpdate['car_id'] = $salesCaseInfo['car_id'];
                  $LeadStatusUpdate['offer'] = str_replace(",","",$amount);
                  $LeadStatusUpdate['type'] = "savestatus";
                  
         
            $post = $LeadStatusUpdate;
        
        if ($post['status'] == 'Booked')
        {
            $data['booking_amount'] = $post['offer'];
        }
        else if ($post['status'] == 'Customer Offer')
        {
            $data['offer_amount'] = $post['offer'];
        }
        else if ($post['status'] == 'Converted')
        {
            $data['sale_amount'] = $post['offer'];
        }
        $data['txtname']     = !empty($post['txtname']) ? $post['txtname'] : '';
        $data['txtmobile']   = $post['txtmobile'];
        $data['ucdid']       = DEALER_ID;
        $data['source']      = 'SELF';
        $data['lead_source'] = 'SELF';
        $data['rating']      = $post['rating'];
        $data['lead_status'] = $post['status'];
        $data['car_id']      = (isset($post['car_id'])) ? $post['car_id'] : '';
        $data['gaadi_id']    = (isset($post['car_id'])) ? $post['car_id'] : '';
        $data['followdate']  = (isset($post['next_follow'])) ? $post['next_follow'] : '';
        //$data['APP_VERSION']            = 58;
        if (isset($post['feedback']) && $post['feedback'])
        {
            $feedBackArray       = explode('$', $post['feedback']);
            $data['feedback_id'] = $feedBackArray[0];
            $data['comment']     = $this->db->escape_str($feedBackArray[1]);
        }

        if (isset($data['comment']) && $data['comment'] && $post['comment'])
        {
            $data['comment'] .= ' | ' . $this->db->escape_str($post['comment']);
        }
        else if (isset($data['comment']) && $data['comment'])
        {
            
        }
        else
        {
            $data['comment'] = $this->db->escape_str($post['comment']);
        }

        //$data['feedback']               = mysql_real_escape_string($post['feedback']);
        if (isset($post['status']) && $post['status'] == 'Walk In')
        {
            if ($post['follow_up'])
            {
                $post['follow_up'] = date("Y-m-d H:i:s", strtotime($post['follow_up']));
            }
            if (isset($post['status']) && $post['reminder_date'])
            {
                $post['reminder_date'] = date("Y-m-d H:i:s", strtotime($post['reminder_date']));
            }
            $data['walkinDate']  = $post['follow_up'];
            $data['next_follow'] = $post['reminder_date'];
        }
        else
        {
            $post['follow_up']   = date("Y-m-d H:i:s", strtotime($post['follow_up']));
            $data['next_follow'] = $post['follow_up'];
        }
        
                $response = $this->addNewLead($data);
                
                return $response;
                  
    }
    
        }
                
    public function updateLead($params,$type){
        
        
        $this->db->select('ldm_id');
        $this->db->from('crm_buy_lead_dealer_mapper ldm');
        $this->db->join('crm_buy_lead_customer lc','ldm.ldm_customer_id=lc.id','left');
        $this->db->where('ldm_id', (int)$params['ldm_id']);
        $query  = $this->db->get();
        $leadData= $query->row_array();
        if(empty($leadData)){
            return true;
        }
        $update['booking_amount'] = $params['booking_amount'];
        $update['txtmobile']      = $params['customer_mobile'];
        $update['ucdid']          = DEALER_ID;
        $update['lead_status']    = $type;
        $update['car_id']         = $params['car_id'];
        $update['gaadi_id']       = $params['car_id'];
        //$update['next_follow']    = '2019-07-27 12:19:00';
        //$update['lead_id']        = $params['ldm_id'];


        return $this->add_new_lead($update,$source='uc_sale_booking');
        
    }

}