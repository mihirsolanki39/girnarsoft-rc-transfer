<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class : DeliveryOrder (DeliveryOrderController)
 * User Class to control all doOrder related operations.
 * @author : rakesh kumar
 */
class DeliveryOrder extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Crm_user');
        $this->load->model('Loan_customer_info');
        $this->load->model('Loan_customer_case');
        $this->load->model('Crm_adv_booking');
        $this->load->library('form_validation');
        $this->load->model('Leadmodel');
        $this->load->model('Crm_dealers');
        $this->load->model('Make_model');
        $this->load->model('UserDashboard');
        $this->load->model('Loan_customer_reference_info');
        $this->load->model('City');
        $this->load->model('state_list');
        $this->load->model('Crm_banks');
        $this->load->model('Loan_post_delivery_info');
        $this->load->model('Crm_insurance_company');
        $this->load->model('Loan_payment_info');
        $this->load->model('Crm_applicant_type');
        $this->load->model('Crm_upload_docs_list');
        $this->load->library('excel');
        $this->load->helper('exportdodata');
        //$this->load->library('Pdf');
        if (!$this->session->userdata['userinfo']['id'])
        {
            return redirect('login');
        }
        
    }

public function getSalesList()
{
    $saleId = $this->input->post('saleid');
    $empData   =  $this->Crm_user->getEmpByDealer($saleId);
    echo $empData[0]['id']; exit;
}

public function loanDoInfo($order_id=''){
        $this->load->helper('range_helper');
        $editId      = !empty($order_id)? explode('_',base64_decode($order_id)):'';
        $orderId  = !empty($editId)?end($editId):'';
        $data = [];
        $data['pageTitle']      = 'Delivery Order';
        $data['pageType']       = 'deliveryOrder';
        if(!empty($orderId)){
        $data['orderinfo']=current($this->Loan_customer_case->getDeliveryOrderInfo($orderId));

        if(($data['orderinfo']['application_no'] != "") && ($data['orderinfo']['loan_filled']==1)){
                 $financerdata['financerDetail'] = current($this->Loan_customer_case->getloanInfoByRefid($data['orderinfo']['application_no'],1,''));
                  // echo "<pre>";print_r($loandata['loanDetail']);die;
                 $data['orderinfo']['hp_to'] = $financerdata['financerDetail']['financer'];
              }else{
                 $financerdata['financerDetail'] =  current($this->Loan_customer_case->getloanInfoByRefid('',1,1,$orderId));
                 if($data['orderinfo']['loan_taken_from']=='2')
                   $data['orderinfo']['hp_to'] = $financerdata['financerDetail']['financer'];
                 else
                   $data['orderinfo']['hp_to'] = !empty($data['orderinfo']['hp_to'])?$data['orderinfo']['hp_to']:'NA';
              }
        $data['cancel_reason'] = $this->Loan_customer_case->doCancelReason();
        $doAmtt=!empty($data['orderinfo']['do_amt']) ? $data['orderinfo']['do_amt'] : '';
        $data['orderinfo']['do_amt']=indian_currency_form($doAmtt);
        $data['orderinfo']['showroom_disc']=(!empty($data['orderinfo']['showroom_disc'])) ? indian_currency_form($data['orderinfo']['showroom_disc']):'';
        $data['orderinfo']['scheme_disc']=(!empty($data['orderinfo']['scheme_disc'])) ? indian_currency_form($data['orderinfo']['scheme_disc']):'';

        $data['orderinfo']['gross_do_amt']=(!empty($data['orderinfo']['gross_do_amt'])) ? indian_currency_form($data['orderinfo']['gross_do_amt']):'';
        $data['orderinfo']['ex_show']=(!empty($data['orderinfo']['ex_show'])) ? indian_currency_form($data['orderinfo']['ex_show']):'';
        $data['orderinfo']['tcs']=(!empty($data['orderinfo']['tcs'])) ? indian_currency_form($data['orderinfo']['tcs']):'';
        $data['orderinfo']['epc']=(!empty($data['orderinfo']['epc'])) ? indian_currency_form($data['orderinfo']['epc']):'';
        $data['orderinfo']['road_tax']=(!empty($data['orderinfo']['road_tax'])) ? indian_currency_form($data['orderinfo']['road_tax']):'';
        $data['orderinfo']['insu_premium']=(!empty($data['orderinfo']['insu_premium'])) ? indian_currency_form($data['orderinfo']['insu_premium']):'';
        $data['orderinfo']['do_insu_premium']=(!empty($data['orderinfo']['do_insu_premium'])) ? indian_currency_form($data['orderinfo']['do_insu_premium']):'';
        $data['orderinfo']['do_external_warranty']=(!empty($data['orderinfo']['do_external_warranty'])) ? indian_currency_form($data['orderinfo']['do_external_warranty']):'';


        $data['orderinfo']['showroom_discount']=(!empty($data['orderinfo']['showroom_discount'])) ? indian_currency_form($data['orderinfo']['showroom_discount']):'';
        $data['orderinfo']['scheme']=(!empty($data['orderinfo']['scheme'])) ? indian_currency_form($data['orderinfo']['scheme']):'';

  #added column for showroom discount start  by Masawwar Ali 
        $data['orderinfo']['show_ex_disc']=(!empty($data['orderinfo']['show_ex_disc'])) ? indian_currency_form($data['orderinfo']['show_ex_disc']):'';
        $data['orderinfo']['show_loyalty']=(!empty($data['orderinfo']['show_loyalty'])) ? indian_currency_form($data['orderinfo']['show_loyalty']):'';
        $data['orderinfo']['show_corporate']=(!empty($data['orderinfo']['show_corporate'])) ? indian_currency_form($data['orderinfo']['show_corporate']):'';
   #added column for showroom discount end    by Masawwar Ali 

   #added column for shared discount start  by Masawwar Ali 
        $data['orderinfo']['dis_ex_disc']=(!empty($data['orderinfo']['dis_ex_disc'])) ? indian_currency_form($data['orderinfo']['dis_ex_disc']):'';
        $data['orderinfo']['dis_loyalty']=(!empty($data['orderinfo']['dis_loyalty'])) ? indian_currency_form($data['orderinfo']['dis_loyalty']):'';
        $data['orderinfo']['dis_corporate']=(!empty($data['orderinfo']['dis_corporate'])) ? indian_currency_form($data['orderinfo']['dis_corporate']):'';
  #added column for shared discount end    by Masawwar Ali 


        $data['orderinfo']['total_showroom_discount']=(!empty($data['orderinfo']['total_showroom_discount'])) ? indian_currency_form($data['orderinfo']['total_showroom_discount']):'';
        $data['orderinfo']['total_dis_amount']=(!empty($data['orderinfo']['total_dis_amount'])) ? indian_currency_form($data['orderinfo']['total_dis_amount']):'';


        $data['orderinfo']['loan_amt']=(!empty($data['orderinfo']['loan_amt'])) ? indian_currency_form($data['orderinfo']['loan_amt']):'';
        $data['orderinfo']['dedu_loan']=(!empty($data['orderinfo']['dedu_loan'])) ? indian_currency_form($data['orderinfo']['dedu_loan']):'';
        $data['orderinfo']['margin_money']=(!empty($data['orderinfo']['margin_money'])) ? indian_currency_form($data['orderinfo']['margin_money']):'';
        $data['orderinfo']['net_do_amt']=(!empty($data['orderinfo']['net_do_amt'])) ? indian_currency_form($data['orderinfo']['net_do_amt']):'';
            
        $data['orderinfo']['insurance']=(!empty($data['orderinfo']['insurance'])) ? $data['orderinfo']['insurance']:'';
         $data['orderinfo']['reg_type']=(!empty($data['orderinfo']['reg_type'])) ? $data['orderinfo']['reg_type']:'';

        $data['order_id']=$orderId;
        }
        $data['employeeList']   =  $this->Crm_user->getEmployee('4','','Executive');
        $data['employeeSalesList']   =  $this->Crm_user->getEmployee('1','','');
        $data['dealerList']     =  $this->Crm_dealers->getDealers('','0','1');
        $data['showroomList']     =  $this->Crm_dealers->getDealers('','1','1');
        $data['makeList']       = (array) $this->getMakeModelNameComm();
        $makeId=(!empty($data['orderinfo']['make'])) ? $data['orderinfo']['make'] : '';
        //$data['model']          =  $this->getModelComm($makeId);
        $modelId=(!empty($data['orderinfo']['model'])) ? $data['orderinfo']['model'] : '';
        $data['version']        =  $this->getVersionComm($makeId,$modelId,'1');
        $data['banklist']        =  $this->Crm_banks->getBanklist();
        $data['cusbanklist']     =  $this->Crm_banks->getcustomerBankList();
        $data['priceBreakup']     =  !empty($orderId)?$this->Loan_customer_case->selectPriceBreakup($orderId):"";
        $data['discountShared']     =  !empty($orderId)?$this->Loan_customer_case->selectDiscountShared($orderId):"";
        $data['showroomDiscount']     =  !empty($orderId)?$this->Loan_customer_case->selectShowroomDiscount($orderId):"";
        $getColors             = $this->UserDashboard->getColors();
        $colArr                 = array();
        foreach($getColors as $c=>$cols)
        {
             $colArr[] = $cols['name'];
        }
        $data['colArr']=$colArr;
        $this->loadViews("deliveryorder/loanDoInfo", $data);   
    }

    /* function getModel($makeId) {
        $make    = $makeId;
        $getMakeNameById=[];
        $getMakeNameById = $this->Make_model->getMakeNameBymakeId($make);
        $makeName=isset($getMakeNameById[0]['make']) ? $getMakeNameById[0]['make'] : '';
       return $result  = $this->Make_model->getCarModelList($makeName,'all');
        
    }
    function getVersion($make,$model) {
       // $model      = $this->input->post('model');
        //$make       = $this->input->post('make');
         $flag       = '1';
        $fields     = "db_version_id,db_version,uc_fuel_type,Displacement";
        $sqlJoin    = " ";
        $where      = $sqlJoin." WHERE model_version.mk_id = '".$make."' AND model_version.model_id = '".$model."' ";
        $orderBy    = "uc_fuel_type";
        $versionListArr =array();
        $versionListArr  =  $this->UserDashboard->getCarVersionList($make,'used',$fields,$orderBy,$where);
        if(!empty($flag))
        {
            $versionListArr  =  $this->UserDashboard->getCarVersionList($make,'all',$fields,$orderBy,$where);
        }
        
      
         return $versionListArr; 
    }*/
    
    public function loanReceiptDetail($order_id){
        $this->load->helper('range_helper');
        $editId      = !empty($order_id)? explode('_',base64_decode($order_id)):'';
        $orderId  = !empty($editId)?end($editId):'';
        $data = [];
        if(!empty($orderId)){
        $orderData=current($this->Loan_customer_case->getReceiptInfo($orderId));
        $orderData['do_amt']=$this->IND_money_format($orderData['do_amt']);
        $orderData['amount']=$this->IND_money_format($orderData['amount']);
        $orderData['creditAmt']=$this->IND_money_format($orderData['creditAmt']);
        //$orderData['banklist']=$this->Loan_customer_case->getBanklist();
        $orderData['banklist']=$this->getcustomerBankList();
        $data['orderinfo']=$orderData;
        }
        $data['pageTitle']      = 'Delivery Receipt';
        $data['pageType']       = 'deliveryOrder';
        $data['orderId']      = $orderId;
        $this->loadViews("deliveryorder/loanReceiptDetail", $data);
    }
    
    public function saveDeliveryOrderData(){
        $params = $this->input->post();
        if(!empty($params['deliveryForm'])){
           $this->addEditDeliveryOrderData($params); 
        }
        if(!empty($params['receiptForm'])){
              echo "bb";die;
           $this->addEditReceiptOrderData($params); 
        }
    }
    
    public function addEditDeliveryOrderData(){
        $params = $this->input->post();
        $editId=$this->input->post('order_id');
        $validationCheck = [];//$this->deliveryOrderFormValidation($params,$editId);
        if(!empty($validationChpriceShowroomeck)){
            echo json_encode($validationCheck);exit;
        }else{
           $datas= $this->renderdeliveryOrderForm($params);
        }
       
      
       if(!empty($editId)){
          $paymentExists = $this->Loan_customer_case->getData('crm_do_part_payment',array('id'),array('case_id'=>$editId));
         }
      if(empty($editId) || (!empty($editId) && empty($paymentExists) )){
        $grossDoamount      = $datas['gross_do_amt'];
        $showroom_discount  = $datas['total_showroom_discount']; 
        $loan_disburse_amts = 0;
         if($datas['application_no']!='' && $datas['loan_filled']==1){
            $loan_disburse_amts =  $this->loanDetails($datas['application_no'],1);
           }
         $discountShared = $datas['scheme_disc'];
           
        $showroomAmount = (int)$grossDoamount - (int)$showroom_discount - (int)$loan_disburse_amts;

        $customerAmount = ((int)$grossDoamount - (int)$discountShared - (int)$loan_disburse_amts);
        $datas['showroom_balance'] = $showroomAmount;
        $datas['customer_balance'] = $customerAmount;
      }

/*echo "gross do amount ".$grossDoamount."<br>";
echo "showroom discount ".$showroom_discount."<br>";
echo "loan disburse amounts ".$loan_disburse_amts."<br>";
echo "discount shared ".$discountShared."<br>";
echo "loan disburse amounts".$loan_disburse_amts."<br>";
*//*echo "<pre>";
print_r($datas);
die();*/
        $orderId = $this->Loan_customer_case->saveUpdateOrderInfo($datas,$editId);
        $do_price = $this->priceShowroom($params,$orderId);
        $do_showroom = $this->savShowroom($params,$orderId);   
        $do_dis = $this->disShowroom($params,$orderId);
        if(!empty($editId))
            $msg = "Delivery Details edited Successfully";
        else
            $msg = "Delivery Details edited Successfully";
        if($orderId){

         $result= array('status'=>'True','message'=>$msg,'Action'=>  base_url().'dopayment/' .base64_encode('OrderId_'.$orderId));   

        }else{
          $result= array('status'=>'False','message'=>'Someting Went Wrong');     
        }
        echo json_encode($result);exit;
    }
    public function savShowroom($par,$do_id)
    {
        $name ='';
        $price = '';
        $editId=$this->input->post('order_id');
        
        $this->db->where('do_id', $editId);
        $this->db->delete('do_showroom_discount');
        
        if(!empty($par['disn2'][0]))
        {
           $name = explode(',', $par['disn2'][0]);
           $price = explode(',', $par['disp2'][0]);
           $data = array_combine($name, $price);
           $update_id='';
           foreach ($data as $key => $value) {
               $abc['s_name'] = $key;
               $abc['s_price'] = $value;
               $abc['do_id'] = $do_id;
               $this->Loan_customer_case->doShowroomDiscount($abc);
           }
        }
    }
     public function priceShowroom($par,$do_id)
    {
        $name ='';
        $price = '';

        $editId=$this->input->post('order_id');
        
        $this->db->where('do_id', $editId);
        $this->db->delete('do_price_breakup');
        
        if(!empty($par['disn1'][0]))
        {
           $name = explode(',', $par['disn1'][0]);
           $price = explode(',', $par['disp1'][0]);
           $data = array_combine($name, $price);      
           
           $update_id='';
           foreach ($data as $key => $value) {
               $abc['p_name'] = $key;
               $abc['p_price'] = $value;
               $abc['do_id'] = $do_id;
              
               $this->Loan_customer_case->doPriceBreakup($abc);
           }
        }
    }
     public function disShowroom($par,$do_id)
    {
        $name ='';
        $price = '';
        $editId=$this->input->post('order_id');
        
        $this->db->where('do_id', $editId);
        $this->db->delete('do_discount_shared');
        
        if(!empty($par['disn'][0]))
        {
           $name = explode(',', $par['disn'][0]);
           $price = explode(',', $par['disp'][0]);
           $data = array_combine($name, $price);
           $update_id='';
           foreach ($data as $key => $value) {
               $abc['dis_name'] = $key;
               $abc['dis_price'] = $value;
               $abc['do_id'] = $do_id;
               $this->Loan_customer_case->doDiscountShared($abc);
           }
        }
    }
    public function deliveryOrderFormValidation($params,$editId){
        //print_r($params);die;
        $this->form_validation->set_error_delimiters('', '');
        if(empty($params['booking_done'])){
        $this->form_validation->set_rules('booking_done', 'Booking Done', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(($params['booking_done']=='1') && (empty($params['booking_slip_no']))){
        $this->form_validation->set_rules('booking_slip_no', 'Booking Slip No', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['deliverySource'])){
        $this->form_validation->set_rules('deliverySource', 'Delivery Source', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(($params['deliverySource']=='2') && (empty($params['deliverySource']))){
        $this->form_validation->set_rules('deliverySource', 'Delivery Source', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }/*else if(($params['deliverySource']=='1') && (empty($params['dealerName']))){
        $this->form_validation->set_rules('dealerName', 'Delivery Name', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/else if(empty($params['do_date'])){
        $this->form_validation->set_rules('do_date', 'Delivery Order Date', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(($params['loan_taken_from']=='1') && ($params['loan_taken']=='1') && ($params['loan_filled']=='1') && (empty($params['application_no']))){
        $this->form_validation->set_rules('application_no', 'Application No', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }/*else if(empty($params['do_no'])){
        $this->form_validation->set_rules('do_no', 'Delivery Order No', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['do_amt'])){
        $this->form_validation->set_rules('do_amt', 'Delivery Amount', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['do_amt_word'])){
        $this->form_validation->set_rules('do_amt_word', 'Delivery Order Amount', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/else if(empty($params['showroomName'])){
        $this->form_validation->set_rules('showroomName', 'Showroom Name', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['showroom_address'])){
        $this->form_validation->set_rules('showroom_address', 'Showroom Address', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['kind_attn'])){
        $this->form_validation->set_rules('kind_attn', 'Kind Attention', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }/*else if(empty($params['showroom_disc'])){
        $this->form_validation->set_rules('showroom_disc', 'Showroom Discount', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['scheme_disc'])){
        $this->form_validation->set_rules('scheme_disc', 'Scheme Discount', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/else if(empty($params['delivery_date'])){
        $this->form_validation->set_rules('delivery_date', 'Delivery Date', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['exp_payment_date'])){
        $this->form_validation->set_rules('exp_payment_date', 'Expected Payment Date', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['customer_mobile_no'])){
        $this->form_validation->set_rules('customer_mobile_no', 'Customer Mobile No', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['customer_name'])){
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['customer_address'])){
        $this->form_validation->set_rules('customer_address', 'Customer Address', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['make'])){
        $this->form_validation->set_rules('make', 'Make', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['model'])){
        $this->form_validation->set_rules('model', 'Model', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['variant'])){
        $this->form_validation->set_rules('variant', 'Variant', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['color'])){
        $this->form_validation->set_rules('color', 'Color', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['new_car_price'])){
        $this->form_validation->set_rules('new_car_price', 'New Car Price', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['insurance'])){
        $this->form_validation->set_rules('insurance', 'Insurance', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        return false;
    }
    
    public function renderdeliveryOrderForm($params){
        $returnArr=array();
           if(!empty($params)){
            $returnArr['updated_by'] = $this->session->userdata['userinfo']['id'];
           $returnArr['updated_on'] = date('Y-m-d H:i:s');
           if(empty($params['order_id'])){
             $returnArr['created_by'] = $this->session->userdata['userinfo']['id'];
             $returnArr['created_on'] = date('Y-m-d H:i:s');
            }
            // $returnArr['do_status']=$params['do_status'];
            $returnArr['deliverySource']=$params['deliverySource'];
            $returnArr['dealer_id']=isset($params['dealerName']) ? $params['dealerName'] : '';
            $returnArr['deliverySales']=$params['deliveryArg']; 
            $returnArr['do_date']=date('Y-m-d',strtotime($params['do_date'])); 
            $returnArr['loan_taken']=$params['loan_taken'];
            $returnArr['loan_taken_from']=isset($params['loan_taken_from']) ? $params['loan_taken_from']:'0';
            $returnArr['loan_filled']=isset($params['loan_filled']) ? $params['loan_filled']:'';
            $returnArr['application_no']=$params['application_no'];
            $returnArr['do_amt']= str_replace(",", "",$params['net_do_amt']); 
            $returnArr['do_amt_word']=!empty($params['do_amt_word'])?'-':'-'; 
            $returnArr['showroomName']=$params['showroomName']; 
            $returnArr['showroomAddress']=ucwords($params['showroom_address']); 
            $returnArr['kind_attn']=ucwords($params['kind_attn']); 
            $returnArr['showroom_disc']=str_replace(",", "",$params['showroom_disc']); 
            $returnArr['scheme_disc']=str_replace(",", "",$params['scheme_disc']); 
            $returnArr['delivery_date']=date('Y-m-d',strtotime($params['delivery_date'])); 
            $returnArr['exp_payment_date']=date('Y-m-d',strtotime($params['exp_payment_date'])); 
            $returnArr['customer_mobile_no']=$params['customer_mobile_no']; 
            $returnArr['customer_name']=ucwords($params['customer_name']); 
            $returnArr['customer_address']=ucwords($params['customer_address']); 
            $returnArr['deliveryTeam']=$params['deliveryTeam']; 
            $returnArr['make']=$params['make']; 
            $returnArr['model']=$params['model']; 
            $returnArr['variant']=$params['variant'];
            $returnArr['color']=$params['color']; 
            $returnArr['hp_to']=(!empty($params['loan_taken_from']) && ($params['loan_taken_from']=='1'))?(!empty($params['hp_tos'])?$params['hp_tos']:''):(!empty($params['hp_to'])?$params['hp_to']:'');

             /*$returnArr['hp_to']=(!empty($params['loan_taken_from']) && ($params['loan_taken_from']=='1'))?(!empty($params['hp_tos'])?$params['hp_tos']: !empty($params['hp_tos_hidden'])?$params['hp_tos_hidden']:''):(!empty($params['hp_to'])?$params['hp_to']:'');
             */

             if($returnArr['hp_to']==''){
              /*$returnArr['hp_to']= (!empty($params['loan_taken_from']) && ($params['loan_taken_from']=='1') && (!empty($params['application_no'])))?(!empty($params['hp_tos_hidden'])?$params['hp_tos_hidden']:'');*/
              $returnArr['hp_to']= (!empty($params['loan_taken_from']) && ($params['loan_taken_from']=='1') && (!empty($params['application_no'])))?(!empty($params['hp_tos_hidden'])?$params['hp_tos_hidden']:''):'';
             }
            $returnArr['new_car_price']=str_replace(",", "",$params['new_car_price']);
            $returnArr['booking_done']=$params['booking_done'];
            $returnArr['booking_slip_no']=$params['booking_slip_no'];
            $returnArr['insurance']=$params['insurance'];
            $returnArr['reg_type']=$params['reg_type'];
            $returnArr['status'] = '1';
            $returnArr['add_date'] = date('Y-m-d H:i:s');
            $returnArr['update_date'] = date('Y-m-d H:i:s');
            $returnArr['last_updated_status'] = '1';
            $returnArr['last_updated_date'] = date('Y-m-d H:i:s');

            $returnArr['ex_show']= str_replace(",", "",$params['ex_shows']); 
            $returnArr['tcs']= str_replace(",", "",$params['tcss']); 
            $returnArr['epc']= str_replace(",", "",$params['epcs']); 
            $returnArr['do_insu_premium'] = str_replace(",", "",$params['insu_premium_dos']); 
            $returnArr['do_external_warranty'] = str_replace(",", "",$params['external_warrantys']); 
            $returnArr['road_tax']= str_replace(",", "",$params['road_taxs']); 
            $returnArr['gross_do_amt']= str_replace(",", "",$params['grs_amts']); 
            $returnArr['showroom_discount']= str_replace(",", "",$params['showroom_show']); 

            /*$grossDoamount     = str_replace(",", "",$params['grs_amts']);
            $showroom_discount = str_replace(",", "",$params['showroom_show']); 
            $loan_disburse_amts = 0;
         if($params['application_no']!='' && $params['loan_filled']==1){
            $loan_disburse_amts =  $this->loanDetails($params['application_no'],1);
           }
           $showroomAmount = (int)$grossDoamount - (int)$showroom_discount - (int)$loan_disburse_amts;

           $discountShared = str_replace(",", "",$params['scheme_disc']);
           $customerAmount = ((int)$grossDoamount - (int)$discount_shared - (int)$loan_disburse_amts);

           $returnArr['showroom_balance'] = $showroomAmount;
           $returnArr['customer_balance'] = $customerAmount;*/

            $returnArr['scheme']= str_replace(",", "",$params['schemes_show']);

            #showroom discount popup add params start by Masawwar Ali
            $returnArr['show_ex_disc']= str_replace(",", "",$params['ex_disc_show']);
            $returnArr['show_loyalty']= str_replace(",", "",$params['loyalty_show']);
            $returnArr['show_corporate']= str_replace(",", "",$params['corporate_show']); #showroom discount popup add params ends by Masawwar Ali 
            $returnArr['total_showroom_discount']= str_replace(",", "",$params['distotal_show']); 
            $returnArr['total_dis_amount']= str_replace(",", "",$params['distotal_dis']); 
            $returnArr['loan_amt']= str_replace(",", "",$params['loan_amt']); 
            $returnArr['dedu_loan']= str_replace(",", "",$params['dedu_loan']); 
            $returnArr['margin_money']= str_replace(",", "",$params['margin_money']); 
            $returnArr['margin_money_inhouse']= str_replace(",", "",$params['margin_money_inhouse']); 
            $returnArr['include_margin_money_in']=isset($params['include_margin_money_in'])?$params['include_margin_money_in']:0;
            $returnArr['include_margin_money_cus']=isset($params['include_margin_money_cus'])?$params['include_margin_money_cus']:0;
            $returnArr['include_dis_shared']= isset($params['include_dis_shared']) ? $params['include_dis_shared']:'0';
            
            $returnArr['net_do_amt']= str_replace(",", "",$params['net_do_amt']); 

            $returnArr['dshowroom_dis']= str_replace(",", "",$params['showroom_dis']); 
            $returnArr['dscheme_dis']= str_replace(",", "",$params['schemes_dis']); 

            # added column for discount shared start by Masawwar Ali
            $returnArr['dis_ex_disc']= str_replace(",", "",$params['ex_disc_dis']);
            $returnArr['dis_loyalty']= str_replace(",", "",$params['loyalty_dis']); 
            $returnArr['dis_corporate']= str_replace(",", "",$params['corporate_dis']);  
            # added column for discount shared end   by Masawwar Ali

            $returnArr['insu_premium']= str_replace(",", "",$params['insu_premium']); 
            $returnArr['sameas']= isset($params['sameas']) ? $params['sameas']:'0';
            $returnArr['sameasloan']=isset($params['sameasloan']) ? $params['sameasloan']:'0'; 
        }
        return $returnArr;
        
    }
    
    public function addEditReceiptOrderData($params){
        //$params = $this->input->post();
        $orderId=$this->input->post('order_id');
        $receiptId=$this->input->post('receipt_id');
        $validationCheck = $this->receiptOrderFormValidation($params);
        if(!empty($validationCheck)){
            echo json_encode($validationCheck);exit;
        }else{
           $datas= $this->renderReceiptOrderForm($params);
           if($datas['receiptDate']!='0000-00-00'){
            $doArr['last_updated_status'] = '2';
            $doArr['last_updated_date'] = date('Y-m-d H:i:s');
           }
           $orderId = $this->Loan_customer_case->saveUpdateOrderInfo($doArr,$orderId);
        }
        $receipttId = $this->Loan_customer_case->saveUpdateReceiptInfo($datas,$receiptId);
        if($receipttId){
         $result= array('status'=>'True','message'=>'Receipt Details added Successfully','Action'=>  base_url().'orderListing');   
        }else{
          $result= array('status'=>'False','message'=>'Someting Went Wrong');     
        }
        echo json_encode($result);exit;
    }
    
    public function receiptOrderFormValidation($params){
        //print_r($params);die;
        $this->form_validation->set_error_delimiters('', '');
        if(empty($params['paymentBy'])){
        $this->form_validation->set_rules('paymentBy', 'PaymentBy', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(($params['paymentBy']=='2') && empty($params['amount'])){
        $this->form_validation->set_rules('amount', 'Amount', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if($params['paymentBy']=='1'){
        $this->form_validation->set_rules('paymentBy', 'PaymentBy', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        if(empty($params['paymentType'])){
        $this->form_validation->set_rules('paymentType', 'Type of Payment', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['instrumentType'])){
        $this->form_validation->set_rules('instrumentType', 'Instrument Type', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }/*else if(empty($params['instrument_no'])){
        $this->form_validation->set_rules('instrument_no', 'Instrument No', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/else if(empty($params['credited_amt'])){
        $this->form_validation->set_rules('credited_amt', 'Credited Amount', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['credited_date'])){
        $this->form_validation->set_rules('credited_date', 'Credited Date', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }/*else if(empty($params['favouring_in'])){
        $this->form_validation->set_rules('favouring_in', 'Favouring In', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['drawn_on'])){
        $this->form_validation->set_rules('drawn_on', 'Drawn On', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }else if(empty($params['receipt_date'])){
        $this->form_validation->set_rules('receipt_date', 'Receipt Date', 'required');
         if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        }*/
        }
        if ($this->form_validation->run() == FALSE && validation_errors()) {
            return array('status'=>'False','message'=>validation_errors());
        }
        return false;
    }
    
    public function renderReceiptOrderForm($params){
        $returnArr=array();
        if(!empty($params)){
            $returnArr['orderId']=$params['order_id']; 
            $returnArr['paymentBy']=$params['paymentBy'];
            $returnArr['paymentType']=$params['paymentType']; 
            $returnArr['intrumentType']=$params['instrumentType']; 
            $returnArr['instrumentNo']=($params['instrument_no']!='') ? $params['instrument_no']:''; 
            $returnArr['receipt_no']=($params['receipt_no']!='') ? $params['receipt_no']:''; 
            $returnArr['creditAmt']=str_replace(",", "",$params['credited_amt']); 
            $returnArr['creditDate']=date('Y-m-d',strtotime($params['credited_date']));
            $returnArr['favouring']=$params['favouring_in']; 
            $returnArr['drawnOn']=$params['drawn_on'];
            $returnArr['payment_remark']=$params['payment_remark']; 
            $returnArr['receiptDate']=date('Y-m-d',strtotime($params['receipt_date']));
            $returnArr['amount']=(isset($params['amount']) && ($params['paymentBy']=='2')) ? str_replace(",", "",$params['amount']) : ''; 
            $returnArr['status']='1';
            $returnArr['createdDate'] = date('Y-m-d H:i:s');
      
        }
        return $returnArr;
    }
    
    function loanDetails($loanId='',$flag='',$flag2=''){
        if(empty($loanId)){
            $loanId = $this->input->post('loanId');
        }
       // echo $loanId;die;
        if(!empty($loanId)){
        $custInfo=$this->Loan_customer_case->getloanInfoByCaseId($loanId);
      //  echo "<pre>";print_r($custInfo);die;
        if(!empty($custInfo)){
            if(!empty($custInfo[0]['loan_amount']))
            {
                $loan_amt = $custInfo[0]['loan_amount'];
            }
          else if(!empty($custInfo[0]['gross_net_amount']))
            {
                $loan_amt = $custInfo[0]['gross_net_amount'];
            }
            else if(!empty($custInfo[0]['disbursed_amount']))
            {
                $loan_amt = $custInfo[0]['disbursed_amount'];
            }
            else if(!empty($custInfo[0]['approved_loan_amt']))
            {
                $loan_amt = $custInfo[0]['approved_loan_amt'];
            }
            else if(!empty($custInfo[0]['file_amount']))
            {
                $loan_amt = $custInfo[0]['file_amount'];
            }/*else if(!empty($custInfo[0]['fee_disburse'])){
              $feeDisburse = $custInfo[0]['fee_disburse'];
            }else if(!empty($custInfo[0]['other_disburse'])){
              $otherDisburse = $custInfo[0]['other_disburse'];
            }else if(!empty($custInfo[0]['total_emi'])){
              $totalEmi = $custInfo[0]['total_emi'];
            }else if(!empty($custInfo[0]['existing_disburse'])){
              $existingDisburse = $custInfo[0]['existing_disburse'];
            }*/
        $data['customer_name']=$custInfo[0]['name'];
        $data['customer_mobile_no']=$custInfo[0]['cus_mobile'];
        $data['customer_address']=$custInfo[0]['residence_address'];
        $data['make']=(!empty($custInfo[0]['makeId'])) ? $custInfo[0]['makeId'] :'';
        $data['model']=(!empty($custInfo[0]['modelId'])) ? $custInfo[0]['modelId'] :'';
        $data['version']=(!empty($custInfo[0]['versionId'])) ? $custInfo[0]['versionId'] :'';
        $data['make_name']=(!empty($custInfo[0]['make_name'])) ? $custInfo[0]['make_name'] :'Select Make';
        $data['model_name']=(!empty($custInfo[0]['model_name'])) ? $custInfo[0]['model_name'] :'Select Model';
        $data['version_name']=(!empty($custInfo[0]['version_name'])) ? $custInfo[0]['version_name'] :'Select Version';
        $data['financer']=(!empty($custInfo[0]['financer'])) ? $custInfo[0]['financer'] :'';
        $data['showroom_id']=$custInfo[0]['showroomId'];
        $data['showroomName']=(!empty($custInfo[0]['showroomName'])) ? $custInfo[0]['showroomName'] :'';
        $data['outlet_address']=(!empty($custInfo[0]['outlet_address'])) ? $custInfo[0]['outlet_address'] :'';
        $data['loan_amt']=$this->IND_money_format($loan_amt);
        //$totalDeductions =  $feeDisburse+$otherDisburse+$totalEmi+$existingDisburse;
        $feeDisburse = !empty($custInfo[0]['fee_disburse'])?$custInfo[0]['fee_disburse']:0;
        $otherDisburse = !empty($custInfo[0]['other_disburse'])?$custInfo[0]['other_disburse']:0;
        $totalEmi =!empty($custInfo[0]['total_emi'])?$custInfo[0]['total_emi']:0;
        $existingDisburse=!empty($custInfo[0]['existing_disburse'])?$custInfo[0]['existing_disburse']:0;
       $deduction =  $feeDisburse+$otherDisburse+$totalEmi+$existingDisburse;
       $data['totalDeductions']=$this->IND_money_format($deduction);
        $result= array('status'=>'True','message'=>$data);
        }else{
          $result= array('status'=>'False','message'=>'');  
        }
        }else{
         $result= array('status'=>'False','message'=>'');
        }
         if(empty($flag)){
             echo json_encode($result);
         }
         else
         {
            if(!empty($custInfo[0]['gross_net_amount']))
            {
                $loan_amt = $custInfo[0]['gross_net_amount'];
            }
            return $loan_amt;
         }
    }
    
    function dealerDetails(){
        $dealerId = $this->input->post('dealerId');
        if(!empty($dealerId)){
        $dealerinfo=$this->Crm_dealers->dealerListing($dealerId,'','','');
        //print_r($dealerinfo);die;
        $data['address']=$dealerinfo[0]->user_address;
        $data['owner']=$dealerinfo[0]->owner_name;
        $result= array('status'=>'True','message'=>$data);
        }else{
         $result= array('status'=>'False','message'=>'');
        }
        echo json_encode($result);
        }
    public function orderListing($doId=''){
        $data = [];
        $page                  =   1;
        $limit                 =   10;
        $dealerId=DEALER_ID;
        $userId=$this->session->userdata['userinfo']['id'];
        $datapost=$this->input->post();
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

            $page                   = $postdata['page'];
            $is_search              = 1;
        }
        if(isset($userId) && ($userId!='')){
        $datapost['userId']=$userId;
        }
        $datapost['dodashId']        = (!empty($doId)) ? $doId:'';
        $getLeads= $this->Loan_customer_case->getOrderListing($datapost,$dealerId,$page,$limit);

        $getLeadsCount= $this->Loan_customer_case->getOrderListingCount($datapost,$dealerId);
        $datapost['type']='';
        $data['query']=$getLeads;
        $data['limit']=$limit;
        $data['page']=1;
        $data['total_count']=count($getLeadsCount['leads']);
        $data['pageTitle']      = 'Delivery Order Listing';
        $data['doId']        = (!empty($doId)) ? $doId:'';
        $data['employeeList']   =  $this->Crm_user->getEmployee('1','','');
        $data['dealerList']     =  $this->Crm_dealers->getDealers('','0','1');
        $data['showroomList']     =  $this->Crm_dealers->getDealers('','1','1');
        $data['banklist']        =  $this->Crm_banks->getBanklist();
        if(isset($datapost['export']) && $datapost['export'] == 'export'){
        $filename = 'Delivery_Order_'.date('dM').'.xls';
        //echo "<pre>";print_r($getLeads['leads']);die;
        exportDoData($getLeads['leads'],$filename);    
        }
        $this->loadViews("deliveryorder/orderListing", $data);   
    }
    public function ajax_getdelivery()
    {
        $data = [];
        $page                  =   1;
        $limit                 =   10;
        $dealerId=DEALER_ID;
        $userId=$this->session->userdata['userinfo']['id'];
        $datapost=$this->input->post();
        $datapost['dodashId']        = (!empty($doId)) ? $doId:'';
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

            $page                   = $postdata['page'];
            $is_search              = 1;
        }
        if(isset($userId) && ($userId!='')){
        $datapost['userId']=$userId;
        }
        $getLeads= $this->Loan_customer_case->getOrderListing($datapost,$dealerId,$page,$limit);
        $getLeadsCount= $this->Loan_customer_case->getOrderListingCount($datapost,$dealerId);
        $datapost['type']='';
        $data['query']=$getLeads;
        $data['total_count']=count($getLeadsCount['leads']);
        $data['limit'] =(!empty($limit)) ? $limit :0;
        $data['page'] =(!empty($page)) ? $page :1;
        $data['pageTitle']      = 'Delivery Order Listing';
        $data['doId']        = (!empty($doId)) ? $doId:'';
        $data['employeeList']   =  $this->Crm_user->getEmployee('1','','');
        $data['dealerList']     =  $this->Crm_dealers->getDealers('','0','1');
        $data['banklist']        =  $this->Crm_banks->getBanklist();
        $this->load->view("deliveryorder/ajax_getdelivery", $data);   
    }
    
    function bookingDetails(){
        $booking_slip_no = $this->input->post('booking_slip_no');
        if(!empty($booking_slip_no)){
        $custInfo=$this->Loan_customer_case->getbookingInfoByslipno($booking_slip_no);
        //print_r($custInfo);die;
        if(!empty($custInfo)){
        $data['source']=$custInfo[0]['source'];
        $data['sourceName']=($custInfo[0]['source']=='1') ? 'Dealer' : 'Inhouse';
        $data['dealer_id']=$custInfo[0]['dealer_id'];
        $data['dealerName']=(!empty($custInfo[0]['dealerName'])) ? $custInfo[0]['dealerName'] :'';
        $data['showroom_id']=$custInfo[0]['showroom_id'];
        $data['showroomName']=(!empty($custInfo[0]['showroomName'])) ? $custInfo[0]['showroomName'] :'';
        $data['outlet_address']=(!empty($custInfo[0]['outlet_address'])) ? $custInfo[0]['outlet_address'] :'';
        $data['emp_id']=$custInfo[0]['emp_id'];
        $data['kind_attn']=$custInfo[0]['kind_attn'];
        $data['execName']=$custInfo[0]['execName'];
        $data['customer_name']=$custInfo[0]['customer_name'];
        $data['customer_mobile_no']=$custInfo[0]['customer_mobile'];
        $data['customer_address']=$custInfo[0]['customer_address'];
        $data['make']=(!empty($custInfo[0]['make_id'])) ? $custInfo[0]['make_id'] :'';
        $data['model']=(!empty($custInfo[0]['model_id'])) ? $custInfo[0]['model_id'] :'';
        $data['version']=(!empty($custInfo[0]['version_id'])) ? $custInfo[0]['version_id'] :'';
        $data['make_name']=(!empty($custInfo[0]['make_name'])) ? $custInfo[0]['make_name'] :'Select Make';
        $data['model_name']=(!empty($custInfo[0]['model_name'])) ? $custInfo[0]['model_name'] :'Select Model';
        $data['version_name']=(!empty($custInfo[0]['version_name'])) ? $custInfo[0]['version_name'] :'Select Version';
        $data['financer']=(!empty($custInfo[0]['financer'])) ? $custInfo[0]['financer'] :'';
        $data['colorId']=(!empty($custInfo[0]['colorId'])) ? $custInfo[0]['colorId'] :'';
        $data['colorName']=(!empty($custInfo[0]['colorName'])) ? $custInfo[0]['colorName'] :'';
        $result= array('status'=>'True','message'=>$data);
        }else{
          $result= array('status'=>'False','message'=>'');  
        }
        }else{
         $result= array('status'=>'False','message'=>'');
        }
         
        echo json_encode($result);
    }

    public function getpdf(){
        $orderId = $_POST['orderId'];
        $dealerid= $_POST['dealerid'];
        $this->load->helper('pdf_helper');
        if(!empty($orderId)){
        $data['orderinfo']=current($this->Loan_customer_case->getOrderDetailspdf($orderId)); 
        if(($data['orderinfo']['application_no'] != "") && ($data['orderinfo']['loan_filled']==1)){
                 $financerdata['financerDetail'] = current($this->Loan_customer_case->getloanInfoByRefid($data['orderinfo']['application_no'],1,''));
                  // echo "<pre>";print_r($loandata['loanDetail']);die;
                 $data['orderinfo']['bank_name'] = $financerdata['financerDetail']['financer_name'];
              }else{
                 $financerdata['financerDetail'] =  current($this->Loan_customer_case->getloanInfoByRefid('',1,1,$orderId));
                 if($data['orderinfo']['loan_taken_from']=='2'){
                   $data['orderinfo']['bank_name'] = $financerdata['financerDetail']['financer_name'];
                 }
                 else{
                   $data['orderinfo']['bank_name'] = !empty($data['orderinfo']['bank_name'])?$data['orderinfo']['bank_name']:'NA';
                 }
              }
          if($data['orderinfo']['reg_type']=='1'){
            $data['orderinfo']['registration_type'] = "Private Number";
           }else if($data['orderinfo']['reg_type']==2){
            $data['orderinfo']['registration_type'] = "Commercial Number";
            }else{
              $data['orderinfo']['registration_type'] = "NA";
            }    

        $data['orderinfo']['gross_do_amt'] = indian_currency_form($data['orderinfo']['gross_do_amt']);
        $data['orderinfo']['showroom_disc'] = indian_currency_form($data['orderinfo']['showroom_disc']);
        $data['orderinfo']['ex_show'] = indian_currency_form($data['orderinfo']['ex_show']);
          $data['orderinfo']['tcs'] = indian_currency_form($data['orderinfo']['tcs']);
            $data['orderinfo']['epc'] = indian_currency_form($data['orderinfo']['epc']);  
        $feeDisburse = !empty($data['orderinfo']['fee_disburse'])?$data['orderinfo']['fee_disburse']:0;
        $otherDisburse = !empty($data['orderinfo']['other_disburse'])?$data['orderinfo']['other_disburse']:0;
        $totalEmi = !empty($data['orderinfo']['total_emi'])?$data['orderinfo']['total_emi']:0;
        $existingDisburse = !empty($data['orderinfo']['existing_disburse'])?$data['orderinfo']['existing_disburse']:0;
        $totalDeductions = $feeDisburse+$otherDisburse+$totalEmi+$existingDisburse;
        $loanAmount = !empty($data['orderinfo']['loan_amt'])?$data['orderinfo']['loan_amt']:0;
        $finalLoanAmount = $loanAmount-$totalDeductions;    
        $data['orderinfo']['loan_amt'] = indian_currency_form($finalLoanAmount);
        $data['orderinfo']['margin_money'] = indian_currency_form($data['orderinfo']['margin_money']);
        $data['orderinfo']['do_amt_word'] = $this->convertNumberToWordsForIndia($data['orderinfo']['net_do_amt']);
        $data['orderinfo']['net_do_amt'] = indian_currency_form($data['orderinfo']['net_do_amt']);
       
        $data['orderinfo']['road_tax'] = indian_currency_form($data['orderinfo']['road_tax']);

        $data['orderinfo']['do_insu_premium'] = indian_currency_form($data['orderinfo']['do_insu_premium']);
        $data['orderinfo']['do_external_warranty'] = indian_currency_form($data['orderinfo']['do_external_warranty']);

        $data['orderId']=$orderId;
        $data['orderinfo']['do_date'] = $data['orderinfo']['do_date'];
        $n = str_replace(' ', '_', $data['orderinfo']['customer_name']);
        $nameS = $n.'_OrderReceipt_';
        $time=time();
        $filename=$nameS.$orderId.'_'.$time;
        $data['priceBreakup']     =  !empty($orderId)?$this->Loan_customer_case->selectPriceBreakup($orderId):"";
        }
        if($dealerid!='49'){

        $html = $this->load->view('deliveryorder/autopdfFile', $data, true);
        }
        if($dealerid=='49')
        {
        $html = $this->load->view('deliveryorder/pdfFile', $data, true);  
        }  
        $this->deliveryDocs($html,$filename);
        //@pdf_create($html, $filename);
        //write_file('name', $data);
        $this->orderListing();
    }

    public function advBookingListing()
    {
        $data = [];
        $page                  =   1;
        $limit                 =   10;
        $data['pageTitle']      = 'Advance Booking Listing';
        $data['employeeList']   =  $this->Crm_user->getEmployee('1');
        $data['dealerList']     =  $this->Crm_dealers->getDealerShowroom();
        $datapost = $this->input->post();
        $searchbyval    = $this->input->post('searchbyval');
        $searchbyvaldealer    = $this->input->post('searchbyvaldealer');
        $searchby       = $this->input->post('searchby');
        $showroom    = $this->input->post('showroom');
        $sale_emp    = $this->input->post('sale_emp');
        $searchdate     = $this->input->post('searchdate');
        $daterange_to   = $this->input->post('daterange_to');
        $daterange_from = $this->input->post('daterange_from');
        $pages          = $this->input->post('page');
        $dashboard      = $this->input->post('dashboard');
        $caseInfoAll = [];
        $loanId = [];
        $data['limit'] = $limit;
        $role_name = $this->session->userdata['userinfo']['role_name'];
        $user_id = $this->session->userdata['userinfo']['id'];
        $caseInfo   =  $this->Crm_adv_booking->getAllBookingInfo($searchbyval,$searchbyvaldealer,$searchby,$showroom,$sale_emp,$searchdate,$daterange_to,$daterange_from,$pages,$dashboard,$role_name,$user_id);
        $caseInfoCount   =  $this->Crm_adv_booking->getAllBookingInfoCount($searchbyval,$searchbyvaldealer,$searchby,$showroom,$sale_emp,$searchdate,$daterange_to,$daterange_from,$pages,$dashboard,$role_name,$user_id);
          
        foreach ($caseInfo as $key => $value) 
        {
            $loanId[] = $value['id'];
            $caseInfoAll[$value['id']]['source'] = ($value['source']=='1')?'Dealer':'Inhouse';
             $caseInfoAll[$value['id']]['booking_date'] = (!empty($value['booking_date']) && $value['booking_date'] != "0000-00-00 00:00:00" && $value['booking_date'] != "1970-01-01 00:00:00")?date('dS M Y',strtotime($value['booking_date'])):"";
            $caseInfoAll[$value['id']]['booking_slip_no'] = $value['booking_slip_no'];
            $caseInfoAll[$value['id']]['booking_amount'] = $this->IND_money_format($value['booking_amount']);
            $caseInfoAll[$value['id']]['amount_paid_to'] = ($value['amount_paid_to']=='1')?'Showroom':'Inhouse';
            $caseInfoAll[$value['id']]['showroom_booking_no'] = $value['showroom_booking_no']; 
            $caseInfoAll[$value['id']]['customer_mobile'] = $value['customer_mobile'];
            $caseInfoAll[$value['id']]['customer_name'] = $value['customer_name'];
            $caseInfoAll[$value['id']]['customer_address'] = $value['customer_address'];
            $caseInfoAll[$value['id']]['color'] = $value['colors'];
            $caseInfoAll[$value['id']]['registration'] = ($value['registration']=='1')?'Private Number':'Commercial Number';
            $caseInfoAll[$value['id']]['created_on'] = date('dS M Y',strtotime($value['created_on']));
            $caseInfoAll[$value['id']]['updated_on'] = date('dS M Y',strtotime($value['updated_on']));
            $caseInfoAll[$value['id']]['created_by'] = $value['created_by'];
            $caseInfoAll[$value['id']]['updated_by'] = $value['updated_by'];
            $caseInfoAll[$value['id']]['showroom'] = $value['showroom'] ;
            $caseInfoAll[$value['id']]['dealer_name'] = $value['dealership_name'];
            $caseInfoAll[$value['id']]['showroom_add'] = $value['outlet_address'];
            $caseInfoAll[$value['id']]['version'] = $value['version_name'];
            $caseInfoAll[$value['id']]['make'] = $value['make_name'];
            $caseInfoAll[$value['id']]['model'] = $value['model_name'];
            $caseInfoAll[$value['id']]['emp_name'] = $value['name'];
            $caseInfoAll[$value['id']]['link'] =  (!empty($value["id"])? base_url('addadvbooking/').base64_encode('BookingId_'.$value["id"]):'#');;
        } 
        $data['loan_listing'] = $caseInfoAll;
        $data['loan_list_id'] = $loanId; 
        $data['page'] =  $page; 
       
        $data['total_count'] = count($caseInfoCount);
        $this->loadViews("advBooking/advbookinglisiting", $data); 
    }

    public function bookingListingCase()
    {
        error_reporting(0);
        $datapost = $this->input->post();
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

            $page                   = $postdata['page'];
            $is_search              = 1;
        }
        $searchbyval    = $datapost['searchbyval'];
        $searchbyvaldealer    = $datapost['searchbyvaldealer'];
        $searchby       = $datapost['searchby'];
        $showroom    = $datapost['showroom'];
        $sale_emp    = $datapost['sale_emp'];
        $searchdate     = $datapost['searchdate'];
        $daterange_to   = $datapost['daterange_to'];
        $daterange_from = $datapost['daterange_from'];
        $pages          = $datapost['page'];
        $dashboard      = $datapost['dashboard'];
        $caseInfoAll = [];
        $loanId = [];
        $data['limit'] = 10;
        $role_name = $this->session->userdata['userinfo']['role_name'];
        $user_id = $this->session->userdata['userinfo']['id'];
        $caseInfo   =  $this->Crm_adv_booking->getAllBookingInfo($searchbyval,$searchbyvaldealer,$searchby,$showroom,$sale_emp,$searchdate,$daterange_to,$daterange_from,$pages,$dashboard,$role_name,$user_id);
        $caseInfoCount   =  $this->Crm_adv_booking->getAllBookingInfoCount($searchbyval,$searchbyvaldealer,$searchby,$showroom,$sale_emp,$searchdate,$daterange_to,$daterange_from,$pages,$dashboard,$role_name,$user_id);
      //      echo "<pre>";print_r($caseInfo);die;
        foreach ($caseInfo as $key => $value) 
        {
            $loanId[] = $value['id'];
            $caseInfoAll[$value['id']]['source'] = ($value['source']=='1')?'Dealer':'Inhouse';
            $caseInfoAll[$value['id']]['booking_date'] = (!empty($value['booking_date']) && $value['booking_date'] != "0000-00-00 00:00:00" && $value['booking_date'] != "1970-01-01 00:00:00")?date('dS M Y',strtotime($value['booking_date'])):"";
            $caseInfoAll[$value['id']]['booking_slip_no'] = $value['booking_slip_no'];
            $caseInfoAll[$value['id']]['booking_amount'] = $this->IND_money_format($value['booking_amount']);
            $caseInfoAll[$value['id']]['amount_paid_to'] = ($value['amount_paid_to']=='1')?'Showroom':'Inhouse';
            $caseInfoAll[$value['id']]['showroom_booking_no'] = $value['showroom_booking_no']; 
            $caseInfoAll[$value['id']]['customer_mobile'] = $value['customer_mobile'];
            $caseInfoAll[$value['id']]['customer_name'] = $value['customer_name'];
            $caseInfoAll[$value['id']]['customer_address'] = $value['customer_address'];
            $caseInfoAll[$value['id']]['color'] = $value['colors'];
            $caseInfoAll[$value['id']]['registration'] = ($value['registration']=='1')?'Private Number':'Commercial Number';
            $caseInfoAll[$value['id']]['created_on'] = date('dS M Y',strtotime($value['created_on']));
            $caseInfoAll[$value['id']]['updated_on'] = date('dS M Y',strtotime($value['updated_on']));
            $caseInfoAll[$value['id']]['created_by'] = $value['created_by'];
            $caseInfoAll[$value['id']]['updated_by'] = $value['updated_by'];
            $caseInfoAll[$value['id']]['showroom'] = $value['showroom'] ;
            $caseInfoAll[$value['id']]['dealer_name'] = $value['dealership_name'];
            $caseInfoAll[$value['id']]['showroom_add'] = $value['outlet_address'];
            $caseInfoAll[$value['id']]['version'] = $value['version_name'];
            $caseInfoAll[$value['id']]['make'] = $value['make_name'];
            $caseInfoAll[$value['id']]['model'] = $value['model_name'];
            $caseInfoAll[$value['id']]['emp_name'] = $value['name'];
            $caseInfoAll[$value['id']]['link'] =  (!empty($value["id"])? base_url('addadvbooking/').base64_encode('BookingId_'.$value["id"]):'#');;
        } 
        $data['loan_listing'] = $caseInfoAll;
        $data['loan_list_id'] = $loanId;  
        $data['page'] =  (!empty($page)) ? $page :1;
        $data['total_count'] = count($caseInfoCount);
       
        echo $datas=$this->load->view('advBooking/advbookingdata',$data,true); exit;
    }

    public function addadvbooking($adv_b='')
    {
        $data = [];
        $data['pageTitle']      = 'Advance Booking';
        $data['pageType']       = 'advancebooking';
        $editId      = !empty($adv_b)? explode('_',base64_decode($adv_b)):'';
        $rcId        = !empty($editId)?end($editId):'';
        if(!empty($rcId))
        {
            $getBookingDetail = $this->Crm_adv_booking->getAdvBooking($rcId);
            $data['getBookingDetail'] = $getBookingDetail[0];
            $showroom     =  $this->Crm_dealers->getDealerShowroom($data['getBookingDetail']['showroom_id']);
            $data['getBookingDetail']['showroom_add'] = $showroom[0]['user_address'];
          //  $data['getBookingDetail']['kind_attn'] = ucwords($showroom[0]['owner_name']);
            $data['getBookingDetail']['booking_amount'] = $this->IND_money_format($data['getBookingDetail']['booking_amount']);
        }
        /*$data['employeeList']   =  $this->Crm_user->getEmployee('1');
        $data['dealerList']     =  $this->Crm_dealers->getDealerShowroom();
        $data['makeList']       = (array) $this->Make_model->getMake();
        $makeId=(!empty($data['getBookingDetail']['make_id'])) ? $data['getBookingDetail']['make_id'] : '';
        //$data['model']          =  $this->Make_model->getModelByMakeId($makeId);
        $modelId=(!empty($data['getBookingDetail']['model_id'])) ? $data['getBookingDetail']['model_id'] : '';
         $data['model']          =  $this->getModel($makeId);
        //$modelId=(!empty($data['orderinfo']['model'])) ? $data['orderinfo']['model'] : '';
        $data['version']        =  $this->getVersion($makeId,$modelId);*/
        $data['employeeList']   =  $this->Crm_user->getEmployee('4','','Executive');
        $data['employeeSalesList']   =  $this->Crm_user->getEmployee('1','','');
        $data['dealerList']     =  $this->Crm_dealers->getDealers('','0','1');
        $data['showroomList']     =  $this->Crm_dealers->getDealers('','1','1');
        $data['makeList']       = (array) $this->getMakeModelNameComm();    
       // $data['makeList']       = (array) $this->Make_model->getMake();
        $makeId=(!empty($data['getBookingDetail']['make_id'])) ? $data['getBookingDetail']['make_id'] : '';
        $data['model']          =  $this->getModelComm($makeId,'1');
         $modelId=(!empty($data['getBookingDetail']['model_id'])) ? $data['getBookingDetail']['model_id'] : '';
        //$modelId=(!empty($data['orderinfo']['model'])) ? $data['orderinfo']['model'] : '';
        $data['version']        =  $this->getVersionComm($makeId,$modelId,'1');
       
        //$data['version']        =  $this->Make_model->getVersionById($makeId,$modelId);
        $data['getColors']             = $this->UserDashboard->getColors();
        $this->loadViews("advBooking/addadvbooking", $data); 
    }

    public function saveBookingInfoData()
    {
        $params = $this->input->post();
        $id  = $params['id'];
        $data = [];
        $data['source'] = $params['source'];  
        $data['dealer_id'] = $params['dealer_name'];  
        $data['emp_id'] = $params['emp_id'];  
        $data['booking_date'] = !empty($params['booking_date'])?date('Y-m-d',strtotime($params['booking_date'])):"";  
        $data['booking_slip_no'] = $params['booking_slip_no'];  
        $data['booking_amount'] = str_replace(',','',$params['booking_amount']);  
        $data['amount_paid_to'] = $params['amount_paid_to'];  
        $data['showroom_id'] = $params['showroom'];  
        $data['showroom_booking_no'] = $params['showroom_booking_no'];  
        $data['customer_mobile'] = $params['mobile'];  
        $data['kind_attn'] = ucwords($params['kind_attn']);  
        $data['customer_name'] = ucwords($params['customer_name']);  
        $data['customer_address'] = $params['customer_address'];  
        $data['make_id'] = $params['makeId'];  
        $data['model_id'] = $params['modelId'];  
        $data['version_id'] = $params['versionId']; 
        $data['color'] = $params['color']; 
        $data['registration'] = $params['registration'];
        $data['updated_by'] = $this->session->userinfo['id'];
        if(empty($id))
        {
            $data['created_on'] = date('Y-m-d h:i:s');
            $data['created_by'] = $this->session->userinfo['id'];      
        } 
        /* echo "<pre>";
        print_r($data);
        die();*/
        $this->Crm_adv_booking->addAdvBooking($data,$id);
        $result= array('status'=>'True','message'=>'Booking details Updated Successfully','Action'=>  base_url().'advBookingListing');
        echo json_encode($result);exit;
      }

      public function getShowroomDetails()
      {
        $data = [];
        $params = $this->input->post();
        $id  = $params['showroom_id'];
        $showroom     =  $this->Crm_dealers->getDealerShowroom($id);
        $data['add'] = $showroom[0]['user_address'];
        $data['attn'] = ucwords($showroom[0]['owner_name']);
        echo json_encode($data); exit;
      }


    public function saveRefurbInfoData()
    {

        $params = $this->input->post();
        $id  = $params['id'];
        $data = [];
        $data['name'] = ucwords($params['name']);  
        $data['mobile'] = $params['mobile'];  
        $data['address'] = $params['address'];  
      //  $data['booking_date'] = date('Y-m-d',strtotime($params['booking_date']));  
        $data['services'] = $params['service'];  
        //$data['booking_amount'] = str_replace(',','',$params['booking_amount']);  
        $data['owner_name'] = ucwords($params['owner_name']);  
        $data['owner_mobile'] = $params['owner_mobile'];  
        $data['updated_by'] = $this->session->userinfo['id'];
        if(empty($id))
        {
            $data['created_at'] = date('Y-m-d h:i:s');
            $data['created_by'] = $this->session->userinfo['id'];      
        }  
        $this->Crm_adv_booking->addRefurbWorkshop($data,$id);
        $result= array('status'=>'True','message'=>'Workshop details Updated Successfully','Action'=>  base_url().'refurbworkshoplisting');
        echo json_encode($result);exit;
      }


    public function addrefurbworkshop($adv_b='')
    {
        $data = [];
        $data['pageTitle']      = 'Refurb Workshop';
        $data['pageType']       = 'refurbworkshop';
        $editId      = !empty($adv_b)? explode('_',base64_decode($adv_b)):'';
        $rcId        = !empty($editId)?end($editId):'';
        if(!empty($rcId))
        {
            $getBookingDetail = $this->Crm_adv_booking->getRefurbWorkshop($rcId);
            $data['getBookingDetail'] = $getBookingDetail[0];
        }
           $this->loadViews("refurbWorkshop/refurbWorkshop", $data); 
    }

    public function refurbWorkshopListing()
    {
        $data['pageTitle']      = 'Refurb Workshop Listing';
        $this->loadViews("refurbWorkshop/refurbworkshoplisting", $data); 
    }

     public function worshopListingCase()
    {
        error_reporting(0);
        $datapost = $this->input->post();
        $searchbyval    = $this->input->post('searchbyval');
        $searchbyvaldealer    = $this->input->post('searchbyvaldealer');
        $searchby       = $this->input->post('searchby');
        $pages          = $this->input->post('page');
        $caseInfoAll = [];
        $loanId = [];
       // $role_name = $this->session->userdata['userinfo']['role_name'];
        $user_id = $this->session->userdata['userinfo']['id'];
        $caseInfo   =  $this->Crm_adv_booking->getRefurbWorkshopAll($searchbyval,$searchbyvaldealer,$searchby,$pages);
        $caseInfoCount   =  $this->Crm_adv_booking->getRefurbWorkshopAllCount($searchbyval,$searchbyvaldealer,$searchby,$pages);
        foreach ($caseInfo as $key => $value) 
        {
            $loanId[] = $value['id'];
            $caseInfoAll[$value['id']]['name'] = $value['name'];
            $caseInfoAll[$value['id']]['mobile'] = $value['mobile'];
            $caseInfoAll[$value['id']]['address'] = $value['address'];
            $caseInfoAll[$value['id']]['services'] =$value['services'];
            $caseInfoAll[$value['id']]['owner_mobile'] = $value['owner_mobile'];
            $caseInfoAll[$value['id']]['created_on'] = date('dS M Y',strtotime($value['created_at']));
            $caseInfoAll[$value['id']]['owner_name'] = $value['owner_name'];
            $caseInfoAll[$value['id']]['link'] =  (!empty($value["id"])? base_url('addrefurbworkshop/').base64_encode('RefurbId_'.$value["id"]):'#');;
        } 
        $data['loan_listing'] = $caseInfoAll;
        $data['loan_list_id'] = $loanId;  
        $data['total_count'] = $caseInfoCount;

        echo $datas=$this->load->view('refurbWorkshop/workshopdata',$data,true); exit;
    }


 public function dopayment($order_id='')
    {
        $editId      = !empty($order_id)? explode('_',base64_decode($order_id)):'';
        $orderId  = !empty($editId)?end($editId):'';
        $data = [];
        $data['pageTitle']      = 'Delivery Order';
        $data['pageType']       = 'deliveryOrder';
        if(!empty($orderId)){
        $data['orderinfo']=current($this->Loan_customer_case->getDeliveryOrderInfo($orderId));
        $data['orderinfo']['net_do_amt']=(!empty($data['orderinfo']['net_do_amt'])) ? indian_currency_form($data['orderinfo']['net_do_amt']):'';

        $data['order_id']=$orderId;
        }
        $data['banklist']        =  $this->Crm_banks->getBanklist();
        $data['cusbanklist']     =  $this->Crm_banks->getcustomerBankList();
        $flag = '1';
        if($this->session->userdata['userinfo']['id']=='1')
        {
            $flag = '';
        }
        $sumshow1 = 0;
        $sumcust2 = 0;
         $data['Clearanceshow'] = $this->Loan_customer_case->selectDoPartpayment('','2',$flag,$orderId); 
        $data['paymentshow'] = $this->Loan_customer_case->selectDoPartpayment('','1',$flag,$orderId);
        $data['Clearance'] = $this->Loan_customer_case->selectDoPartpayment('','2','',$orderId); 
        $data['payment'] = $this->Loan_customer_case->selectDoPartpayment('','1','',$orderId);

        ## for showroom additional at showroom to inhouse payment 
        $sumshtoInhouse = 0;
        foreach ($data['Clearance'] as $key => $values) {
         if($values['payment_by']=='3'){
           $sumshtoInhouse = $sumshtoInhouse + $values['amount']; 
         } 
        }

        $payment = $this->Loan_customer_case->selectDoPartpayment('','','',$orderId); 

        /*echo $this->db->last_query();
        die();*/

        foreach ($data['payment'] as $key => $value) {
         $sumshow1 = $sumshow1 + $value['amount'];
        }
        $gross_do_amt = !empty($data['orderinfo']['gross_do_amt'])?$data['orderinfo']['gross_do_amt']:0;
        $showroom_discount =  !empty($data['orderinfo']['showroom_disc'])?$data['orderinfo']['showroom_disc']:0;
        $loan_disburse_amt =  $this->loanDetails($data['orderinfo']['application_no'],1);
        $loan_disburse_amts  = !empty($loan_disburse_amt)?$loan_disburse_amt:0;
        $sum1 =  (int)$gross_do_amt - (int)$showroom_discount - (int)$loan_disburse_amts - (int)$sumshow1 + (int)($sumshtoInhouse);
        $insu_premium = (!empty($data['orderinfo']['insu_premium']) && ($data['orderinfo']['insurance']=='2'))?$data['orderinfo']['insu_premium']:0;
        $discount_shared = !empty($data['orderinfo']['scheme_disc'])?$data['orderinfo']['scheme_disc']:0;
        foreach ($payment as $pkey => $pvalue) {
            if($pvalue['payment_by'] == '1')
            {
                $sumcust2 = $sumcust2 + $pvalue['amount'];
            }
        }
        $sum2 = ((int)$gross_do_amt - (int)$discount_shared - (int)$loan_disburse_amts - (int)$sumcust2) + (int)$insu_premium;
        $data['showroom'] = $this->IND_money_format($sum1);
        $data['inhouse'] = $this->IND_money_format($sum2);
                ##### update on payment clearance start by Masawwar Ali 
        $update_array = array('showroom_balance' => $sum1, 'customer_balance' => $sum2);
        if (($sum1 == 0 && $sum2 == 0) && ($data['orderinfo']['cancel_id'] == 0) && ($data['orderinfo']['do_updated_status'] == '1')) {
            $update_array['do_updated_status'] = '2';
        } else if (($sum1 != 0 || $sum2 != 0) && ($data['orderinfo']['cancel_id'] == 0) && ($data['orderinfo']['do_updated_status'] == '2')) {
            $update_array['do_updated_status'] = '1';
        }
        $this->db->where('id', $orderId);
        $this->db->update('crm_finance_delivery', $update_array);
        ##### update on payment clearance end by Masawwar Ali 
        $this->loadViews("deliveryorder/dopayment", $data);
    }


    public function makepayment()
    {
        $datapost              = $this->input->post();
        $editId      = $datapost['id'];
        $orderId     = $datapost['case_id'];
        $customer_id = $datapost['customer_id'];
        $data = [];
        $bnkId = '';
        if(!empty($editId))
        {
            $pay = $this->Loan_customer_case->selectDoPartpayment($editId,'','',$orderId);
            $data['paymentDetails'] = $pay[0];
        }
        $data['orderinfo']=current($this->Loan_customer_case->getDeliveryOrderInfo($orderId));
        $data['banklist']        =  $this->Crm_banks->getcustomerBankList();
        $this->load->view('deliveryorder/makepayment',$data);
    }

    public function save_payment()
    {
        $datapost = $this->input->post();
        //$data['customer_id'] = $datapost['customer_id'];
        $data['bank_id'] = $datapost['payment_bank'];
        $data['bank_name'] = $datapost['financer'];
        $data['case_id'] = $datapost['case_id'];
        $data['payment_by'] = $datapost['payment_by'];
        $data['payment_mode'] = $datapost['payment_mode'];
        $data['payment_date'] = (!empty($datapost['paydate']) && ($datapost['paydate']!='1970-01-01'))?date('Y-m-d',strtotime($datapost['paydate'])):'';
        $data['amount'] = str_replace(',', '', $datapost['amount']);
        //$data['bank_name'] = $datapost['payment_bank'];
        $data['favouring_to'] = $datapost['favouring'];
        $data['instrument_no'] = $datapost['instrument_no'];
        $data['instrument_date'] =(!empty($datapost['instrument_date']) && ($datapost['instrument_date']!='1970-01-01'))?date('Y-m-d',strtotime($datapost['instrument_date'])):'';
        $data['pay_remark'] = $datapost['remark'];
        $type = $datapost['type'];
        $id = $datapost['edit_id'];
        $data['entry_type'] = $datapost['tp'];

        if($id=='')
        {
            $data['created_by'] = $this->session->userdata['userinfo']['id'];
        }
       $ids = $this->Loan_customer_case->addDoPartpayment($data,$id);
       echo $ids; exit;

    }

    public function getexshowprice()
    {
        $versionid = $this->input->post('version');
        $exprice=$this->Loan_customer_case->getExShowprice($versionid);
        echo $exprice['ex_showroom'];  exit;
    }

    function convertNumberToWordsForIndia($number){
    //A function to convert numbers into Indian readable words with Cores, Lakhs and Thousands.
    $words = array(
    '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five',
    '6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten',
    '11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen',
    '16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty',
    '30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy',
    '80' => 'eighty','90' => 'ninty');
    
    //First find the length of the number
    $number_length = strlen($number);
    //Initialize an empty array
    $number_array = array(0,0,0,0,0,0,0,0,0);        
    $received_number_array = array();
    
    //Store all received numbers into an array
    for($i=0;$i<$number_length;$i++){    
        $received_number_array[$i] = substr($number,$i,1);    
    }
    //Populate the empty array with the numbers received - most critical operation
    for($i=9-$number_length,$j=0;$i<9;$i++,$j++){ 
        $number_array[$i] = $received_number_array[$j]; 
    }
    $number_to_words_string = "";
    //Finding out whether it is teen ? and then multiply by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
    for($i=0,$j=1;$i<9;$i++,$j++){
        //"01,23,45,6,78"
        //"00,10,06,7,42"
        //"00,01,90,0,00"
        if($i==0 || $i==2 || $i==4 || $i==7){
            if($number_array[$j]==0 || $number_array[$i] == "1"){
                $number_array[$j] = intval($number_array[$i])*10+$number_array[$j];
                $number_array[$i] = 0;
            }
               
        }
    }
    $value = "";
    for($i=0;$i<9;$i++){
        if($i==0 || $i==2 || $i==4 || $i==7){    
            $value = $number_array[$i]*10; 
        }
        else{ 
            $value = $number_array[$i];    
        }            
        if($value!=0)         {    $number_to_words_string.= $words["$value"]." "; }
        if($i==1 && $value!=0){    $number_to_words_string.= "Crores "; }
        if($i==3 && $value!=0){    $number_to_words_string.= "Lakhs ";    }
        if($i==5 && $value!=0){    $number_to_words_string.= "Thousand "; }
        if($i==6 && $value!=0){    $number_to_words_string.= "Hundred  "; }            
    }
   
    return ucwords(strtolower($number_to_words_string));
}

    function cancelDoNow()
    {
        $do_id = $this->input->post('do_id');
        $canceldo_type = $this->input->post('canceldo_type');
        $otherreatext = $this->input->post('otherreatext');
        $id = $this->Loan_customer_case->updateDoCancelReason($do_id,$canceldo_type,$otherreatext);
        if(!empty($id))
        {
            $err['status'] = '1';
        }
        echo json_encode($err); exit;
    }
    public function downloadPdf(){
        $pdfData = [];
        $doId = $_POST['id'];
        //$this->load->helper('pdf_helper');
        $this->load->helper('range_helper');
      if(!empty($doId)){
        $data['orderinfo']=current($this->Loan_customer_case->getDeliveryOrderInfo($doId,'group'));
        $data['cancel_reason'] = $this->Loan_customer_case->doCancelReason();
                 
      if($data['orderinfo']['application_no'] != "" && $data['orderinfo']['loan_filled']==1){
         $loandata['loanDetail'] = current($this->Loan_customer_case->getloanInfoByRefid($data['orderinfo']['application_no'],1,''));
        // echo "<pre>";print_r($loandata['loanDetail']);die;
         $data['loanDetail']['financer_name']       = $loandata['loanDetail']['financer_name'];
         //$data['loanDetail']['loan_amount']       = $loandata['loanDetail']['loan_amount'];
         $loan_amt = (!empty($loandata['loanDetail']['disbursed_amount']))?$loandata['loanDetail']['disbursed_amount']:(!(empty($loandata['loanDetail']['approved_loan_amt']))?$loandata['loanDetail']['approved_loan_amt']:$loandata['loanDetail']['file_loan_amount']);
         $disbursed_emi = !empty($loandata['loanDetail']['disburse_emi'])?$loandata['loanDetail']['disburse_emi']:(!empty($loandata['loanDetail']['approved_emi'])?$loandata['loanDetail']['approved_emi']:"");
         $data['loanDetail']['loan_amount']         = !empty($loan_amt)?$loan_amt:"0";
         $data['loanDetail']['disbursed_roi']       = (!empty($loandata['loanDetail']['disbursed_roi']))?$loandata['loanDetail']['disbursed_roi']:(!(empty($loandata['loanDetail']['approved_roi']))?$loandata['loanDetail']['approved_roi']:$loandata['loanDetail']['approved_roi']);
         $data['loanDetail']['disbursed_tenure']    = (!empty($loandata['loanDetail']['disbursed_tenure']))?$loandata['loanDetail']['disbursed_tenure']:(!(empty($loandata['loanDetail']['approved_tenure']))?$loandata['loanDetail']['approved_tenure']:$loandata['loanDetail']['file_tenure']);
         /*$data['loanDetail']['disburse_emi']        = $this->calculateEmi($loandata['loanDetail']['loan_amount'],$loandata['loanDetail']['disbursed_tenure'],$loandata['loanDetail']['disbursed_roi'] ,$type='0');*/
         
       //  echo $loandata['loanDetail']['loan_amount']."+++".$loandata['loanDetail']['disbursed_tenure']."_____".$loandata['loanDetail']['disbursed_roi']."+++++" .$type;die;
         $emiAmount = 0;
         if(!empty($disbursed_emi))
          $emiAmount  = $this->calculateEmi($data['loanDetail']['loan_amount'],$loandata['loanDetail']['disbursed_tenure'],$loandata['loanDetail']['disbursed_roi'] ,$type='0');
    
         if(!empty($disbursed_emi)){
              $data['loanDetail']['disburse_emi'] = $disbursed_emi;
            }else{
             $data['loanDetail']['disburse_emi'] = $emiAmount;   
            }
        }else{
      //echo "fff"; exit;
            $loandata['loanDetail'] = current($this->Loan_customer_case->getloanInfoByRefid('',1,1,$doId));
            if($data['orderinfo']['loan_taken_from']=='2')
            $data['loanDetail']['financer_name']       = $loandata['loanDetail']['financer_name'];
            else
            $data['loanDetail']['financer_name']       = !empty($data['orderinfo']['financer_name'])?$data['orderinfo']['financer_name']:'NA';
            $data['loanDetail']['loan_amount']         = !empty($data['orderinfo']['loan_amt'])?$data['orderinfo']['loan_amt']:0;        
            $data['loanDetail']['disburse_emi']        = 0;             
            $data['loanDetail']['disbursed_roi']       = '';          
            $data['loanDetail']['disbursed_tenure']    = '';
            }
         //$data['orderinfo']['insu_premium'] = (!empty($data['orderinfo']['insurance']) && ($data['orderinfo']['insurance']=='2'))?$data['orderinfo']['insu_premium']:'0';
         $data['priceBreakup']     =  !empty($doId)?$this->Loan_customer_case->selectPriceBreakup($doId):"";
        $flag = '1';
        if($this->session->userdata['userinfo']['id']=='1')
        {
            $flag = '';
        }
       ###### payment by customers 
        $data['paymentbyCustomer'] = current($this->Loan_customer_case->sumofDoPartpayment($flag,$doId,'1'));
       ###### Payment To Showroom
       $data['paymentshow'] = current($this->Loan_customer_case->sumofDoPartpayment($flag,$doId,'','1'));
       #### for total showroom and inhouse calculate start
       #### showroom payment done data start 
       $data['paymentshowroom'] = $this->Loan_customer_case->selectDoPartpayment('','1',$flag,$doId);
       #### showroom payment done data end

       #### inhouse payment done start 
       $data['paymentInhouse'] = $this->Loan_customer_case->selectDoPartpayment('','2',$flag,$doId);
       ## for showroom additional at showroom to inhouse payment 
                $sumshtoInhouse = 0;
                foreach ($data['paymentInhouse'] as $key => $values) {
                 if($values['payment_by']=='3'){
                   $sumshtoInhouse = $sumshtoInhouse + $values['amount']; 
                 } 
                }
      
       #### inhouse payment done end
       #### for total showroom and inhouse calculate start 
        $sumshow1 = 0;
        $sumcust2 = 0;
        $paymentdata['payment'] = $this->Loan_customer_case->selectDoPartpayment('','1','',$doId);
        /*echo"<pre>";
        print_r($data);
        die();*/
        $payment = $this->Loan_customer_case->selectDoPartpayment('','','',$doId); 
        foreach ($paymentdata['payment'] as $key => $value) {
         $sumshow1 = $sumshow1 + $value['amount'];
        }
        $gross_do_amt = !empty($data['orderinfo']['gross_do_amt'])?$data['orderinfo']['gross_do_amt']:0;

        $showroom_discount =  !empty($data['orderinfo']['showroom_disc'])?$data['orderinfo']['showroom_disc']:0;
        if($data['orderinfo']['application_no'] != "" && $data['orderinfo']['loan_filled']==1){
          $loan_disburse_amt   =  $this->loanDetails($data['orderinfo']['application_no'],1);
          $loan_disburse_amts  = !empty($loan_disburse_amt)?$loan_disburse_amt:0;
        }else{
          $loan_disburse_amts = 0;   
        }
        $sum1 =  (int)$gross_do_amt - (int)$showroom_discount - (int)$loan_disburse_amts - (int)$sumshow1 + (int)$sumshtoInhouse;
        $insu_premium = (!empty($data['orderinfo']['insu_premium']) && ($data['orderinfo']['insurance']=='2'))?$data['orderinfo']['insu_premium']:0;
        $discount_shared = !empty($data['orderinfo']['scheme_disc'])?$data['orderinfo']['scheme_disc']:0;
        foreach ($payment as $pkey => $pvalue) {
            if($pvalue['payment_by'] == '1')
            {
                $sumcust2 = $sumcust2 + $pvalue['amount'];
            }
        }
        $sum2 = ((int)$gross_do_amt - (int)$discount_shared - (int)$loan_disburse_amts - (int)$sumcust2) + (int)$insu_premium;
         #### for total showroom and inhouse calculate end  
        $data['showroom_total_balance'] = $this->IND_money_format($sum1);
        $data['inhouse_total_balance']  = $this->IND_money_format($sum2);

            $time=time();
            $customerName = !empty($data['orderinfo']['customer_name'])?$data['orderinfo']['customer_name']:"NA";
            $filename=str_replace(' ','_', $customerName).'_'.$doId.'_'.$time;
            $html = $this->load->view('deliveryorder/dodetailpdf.php', $data, true);
           // @pdf_create($html, $filename);
             $this->deliveryDocs($html,$filename);
        }

    }
    public function calculateEmi($lamount,$tenor,$rate,$type='0')
    {
        $mic = ($rate/100) /12; // Monthly interest
        $fv = 0;
        if ($mic === 0)
        return -($lamount + $fv)/$tenor;

        $pvif = pow(1 + $mic, $tenor);
        $pmt = (-$mic * $lamount * ($pvif + fv) / ($pvif - 1));
        if ($type === 1)
            $pmt /= (1 + $mic);

        return abs(round($pmt));
    }


    public function updateBalance(){

       $alldata = $this->Loan_customer_case->getData('crm_finance_delivery',array('id'),array('customer_balance'=>''),array('showroom_balance'=>''),array('cancel_id'=>'0'));
      
       $count = 1;
       if(!empty($alldata)){
       foreach ($alldata as $k => $v) { 
            $orderId  = $v->id;
            $data['orderinfo']=current($this->Loan_customer_case->getDeliveryOrderInfo($orderId));
          
            $flag = '1';
          if($this->session->userdata['userinfo']['id']=='1')
            {
              $flag = '';
            }
        $sumshow1 = 0;
        $sumcust2 = 0;
        $data['Clearance'] = $this->Loan_customer_case->selectDoPartpayment('','2','',$orderId); 
        $data['payment'] = $this->Loan_customer_case->selectDoPartpayment('','1','',$orderId);

        $sumshtoInhouse = 0;
        foreach ($data['Clearance'] as $key => $values) {
         if($values['payment_by']=='3'){
           $sumshtoInhouse = $sumshtoInhouse + $values['amount']; 
         } 
        }

        $payment = $this->Loan_customer_case->selectDoPartpayment('','','',$orderId); 

        foreach ($data['payment'] as $key => $value) {
         $sumshow1 = $sumshow1 + $value['amount'];
        }
        $gross_do_amt = !empty($data['orderinfo']['gross_do_amt'])?$data['orderinfo']['gross_do_amt']:0;
        $showroom_discount =  !empty($data['orderinfo']['showroom_disc'])?$data['orderinfo']['showroom_disc']:0;
        $loan_disburse_amt =  $this->loanDetails($data['orderinfo']['application_no'],1);
        $loan_disburse_amts  = !empty($loan_disburse_amt)?$loan_disburse_amt:0;

        $sum1 =  (int)$gross_do_amt - (int)$showroom_discount - (int)$loan_disburse_amts - (int)$sumshow1 + (int)($sumshtoInhouse);

        $insu_premium = (!empty($data['orderinfo']['insu_premium']) && ($data['orderinfo']['insurance']=='2'))?$data['orderinfo']['insu_premium']:0;
        
        $discount_shared = !empty($data['orderinfo']['scheme_disc'])?$data['orderinfo']['scheme_disc']:0;

        foreach ($payment as $pkey => $pvalue) {
            if($pvalue['payment_by'] == '1')
            {
              $sumcust2 = $sumcust2 + $pvalue['amount'];
            }
        }
        $sum2 = ((int)$gross_do_amt - (int)$discount_shared - (int)$loan_disburse_amts - (int)$sumcust2) + (int)$insu_premium;
        $sum1 = !empty($sum1)?$sum1:0;
        $sum2 = !empty($sum2)?$sum2:0;

         $this->db->where('id', $orderId);
        $updated =  $this->db->update('crm_finance_delivery', array('showroom_balance'=>$sum1,'customer_balance'=>$sum2));
          if($updated){
            $count++;
           }
        }
         echo "Total ".$count. "Record Updated Successfully";
         die();
      }
      else{
          echo "<script>alert('No data for Updation Thank you ')</script>";
          die();
          }
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
 
