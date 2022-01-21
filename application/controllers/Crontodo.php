<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class : Crontodo (CrontodoController)
 * User Class to control all Cron related operations.
 * @author : rakesh kumar
 */
class Crontodo extends MY_Controller {
public $activity_mapping = array('1' => 'status', '2' => 'comment', '3' => 'followup', '4' => 'call', '5' => 'share', '6' => 'feedback','7'=>'walkindate');
    public function __construct() {
        parent::__construct();
        $this->dateTime=date('Y-m-d H:i:s');
        $this->load->model('Leadmodel');
        $this->load->model('Make_model');
        $this->load->model('Leadsellmodel');
        $this->load->model('UsedCarImageMapper');
        $this->load->model('Crm_renew');
        $this->load->model('Crm_dealers');
        $this->load->model('Crm_insurance');
        $this->load->model('Crm_upload_docs_list');
        $this->load->model('Loan_customer_case');
        $this->load->model('Crm_stocks');
        $this->load->model('Crm_upload_docs_list');
        error_reporting(0);
    }
//api to push new Lead from Dealer Crm to Dealer Central    
public function singlebuyerLeadsToDC()
 {
    if(@php_sapi_name() != 'cli') 
    {
    $data=$this->Leadmodel->getBuyLeadsForDC();
    $result=array();
    $leaddata=array();
    if(!empty($data)){
        foreach($data as $datas){
            $result['lead_id']=$datas['leadId'];
            $result['mobile']=$datas['customer_mobile'];
            $result['carid']=$datas['carid'];
            $result['name']=$datas['customer_name'];
            $result['email']=$datas['customer_email'];
            $url="";
            $curlres=$this->sendLeadsToDC($result, $url);
            if(!$curlres['true']){
            $leaddata['processed']='1';
            $this->Leadmodel->updateleadProcess($leaddata,$result['lead_id'],$result['mobile']);
            }
        }
    }
    echo json_encode($result);
    }else{
    echo "You dont have access"; 
    }
 }
 // Cron to send Lead to DC from CRM 
 public function buyerLeadsToDC()
 {
    if(@php_sapi_name() != 'cli') 
    {
    $data=$this->Leadmodel->getBuyerLeadsSyncToDC();
    $result=array();
    $leaddata=array();
    $arr_data=array();
    $leadData=array();
    $i=0;
    if(!empty($data)){
        foreach($data as $datas){
            $result[$i]['gaadi_verified']='1';
            $result[$i]['only_update_flag']='1';
            $arr_data[$i]['mobile']=$datas['mobile'];
            $arr_data[$i]['name']=$datas['name'];
            $arr_data[$i]['email']=$datas['email'];
            $arr_data[$i]['location_id']=$datas['location_id'];
            $arr_data[$i]['is_finance']=$datas['is_finance'];
            $arr_data[$i]['lead_score']=$datas['lead_score'];
            $arr_data[$i]['fuel_type']=$datas['fuel_type'];
            $arr_data[$i]['transmission']=$datas['transmission'];
            $arr_data[$i]['model_ids']=$datas['model_ids'];
            $arr_data[$i]['make_ids']=$datas['make_ids'];
            $arr_data[$i]['body_types']=$datas['body_types'];
            $arr_data[$i]['total_assign_lead']=$datas['total_assign_lead'];
            $result[$i]['arr_data']=$arr_data;
            
            $result[$i]['carid']=$datas['carid'];
            $result[$i]['is_verified']='1';
            $result[$i]['is_whatsapp']='0';
            $result[$i]['async_id']='1';
            $result[$i]['lead_source']='1';
            $result[$i]['dealer_id']=$datas['dealer_id'];
            $result[$i]['lead_id']=$datas['lead_id'];
            $result[$i]['cmobile']=$datas['mobile'];
            $i++;
        }
            echo $url=API_URL.'api/lead_verify_crm.php?';
            $results=json_encode($result);
            $leadData['salt_key']='g1a3a5d7i9';
            $leadData['is_sent']='0';
            $leadData['info']=$results;
            $curlres=$this->sendLeadsToDC($leadData, $url);
            /*if($curlres){
            $leaddata['processed']='1';
            $this->Leadmodel->updateleadProcess($leaddata,$result[0]['lead_id'],$result[0]['cmobile']);
            }*/
        
    }
    echo "Success";
    }else{
    echo "You dont have access"; 
    }
 }
 // Cron to send Lead to DC from CRM with lead status and comment
 public function buyerUpdateLeadsToDC()
 {
    if(@php_sapi_name() != 'cli') 
    {
    $resultuniq=$this->Leadmodel->uniqueLeadstoDc(); 
    $pusharr = array();
    $prcessedids='';
    foreach ($resultuniq as $keyuniq => $valuniq) {
        $result=$this->Leadmodel->getCombinationId($valuniq['combination_id']);
        foreach ($result as $key => $val) {    
        $pusharr[$val['combination_id']]['com_id'] = $val['combination_id'];
        $pusharr[$val['combination_id']]['mobile'] = $val['mobile'];
        $pusharr[$val['combination_id']]['dc_dealer_id'] = $val['dealer_id'];
        //$pusharr[$val['combination_id']]['user_type'] = $val['user_type'];
        //$pusharr[$val['combination_id']]['user_id'] = $val['user_id'];
        $pusharr[$val['combination_id']]['datetime'] = $val['datetime'];
        if($val['activity']=='1')
        {
        if($val['activity_text']=='Walk In'){
            $val['activity_text']='Walk-in Scheduled';
        }else if($val['activity_text']=='Walked In'){
            $val['activity_text']=='Walk-in Done';
        }
        $resstatusId=$this->Leadmodel->getStatusId($val['activity_text']);
        $pusharr[$val['combination_id']][$this->activity_mapping[$val['activity']]] = $resstatusId[0]['id'];
        }else{
            if($val['activity']=='4'){
            $activity_text=($val['call_duration']>0?true:false);
            }else{
            $activity_text=urlencode($val['activity_text']);
            }
        $pusharr[$val['combination_id']][$this->activity_mapping[$val['activity']]] = $activity_text;
        }
        $pusharr[$val['combination_id']]['status'] = $resstatusId[0]['id'];
        if($val['activity']=='1' && $val['activity_text']=='Customer Offer'){
        $pusharr[$val['combination_id']]['car_id'] = $val['car_id'];
        $pusharr[$val['combination_id']]['offer_amount'] = $val['offer_amount'];
        }else if($val['activity']=='1' && $val['activity_text']=='Booked'){
            $pusharr[$val['combination_id']]['car_id'] = $val['car_id'];
            $pusharr[$val['combination_id']]['booking_amount'] = $val['booking_amount'];
        }else if($val['activity']=='1' && $val['activity_text']=='Converted'){
            $pusharr[$val['combination_id']]['car_id'] = $val['car_id'];
            $pusharr[$val['combination_id']]['sale_amount'] = $val['sale_amount'];
        }else if($val['activity']=='1' && $val['activity_text']=='Follow Up'){
        
        $pusharr[$val['combination_id']]['call_duration'] = ($val['call_duration']>0?'true':'false');
        $pusharr[$val['combination_id']][$activity_mapping[$val['activity']]] = ($val['call_duration']>0?true:false);
        
    }
    
    $prcessedids.="'".$val['combination_id']."',";
    $processdata['processed']='2';
    //$this->Leadmodel->setLeadProcessed($processdata,$val['combination_id']);
        }
    }
    //echo "<PRE>";
    //print_r($pusharr);die;
    $dataarr=array();
    $i=0;
    foreach ($pusharr as $kk => $value) {
        foreach($value as $key=>$vald)
        {
            $dataarr[$i][$key]=urlencode($vald);
        }
        $i++;
    }
    //echo "<pre>ssss";
    //print_r($dataarr);
    //echo json_encode($dataarr);
    //exit;
    $url=API_URL.'api/update_buylead_by_crm_status.php?';
    $results=json_encode($dataarr);
    $leadData['apikey']='XZ83QX5BG35656';
    $leadData['is_sent']='0';
    $leadData['data']=$results;
    $curlres=$this->sendLeadsToDC($leadData, $url);
    print_r($curlres);die;
    if(!$curlres){
    $leaddata['processed']='1';
    $this->Leadmodel->setLeadByProcessedIds($leaddata,$prcessedids);
    }

 }
 }
 
 public function sellerLeadQuotesToDC(){
    if(@php_sapi_name() != 'cli') 
    {
     $resultdata=$this->Leadsellmodel->setLeadByProcessedIds();
     foreach($resultdata as $customer ){
                $data['apikey']     ='p3zW7WLsni08WqoeQ=';
                $data['dealer_id']  =$customer['dealer_id'];
                $data['mobile_no']  =$customer['mobile'];
                $data['status']     =(strtolower($customer['status'])=='walked-in')?'Evaluation Done':$customer['status'];
                $data['followdate'] =$customer['follow_date']!='0000-00-00 00:00:00'?$customer['follow_date']:''; 
                $data['quote_price']=$customer['quote_price'];
                $data['version_id'] =$customer['version_id'];
                $data['usertype']   =$customer['user_type'];
                $data['userid']     =$customer['user_id'];  
                echo" data for quote price <pre>";print_r($data);
                //$url="http://beta.usedcarsin.in/api/lead_verfied_CRM.php?salt_key=g1a3a5d7i9&is_sent=0&info";
                //$curlres=$this->sendLeadsToDC($result, $url);
                if(!$curlres['true']){
                //$response =api($data);
                echo"response for quote price <pre>";print_r($curlres);
                }
                //apiLog($data,$response);
             }
    }else{
      echo "You dont have access";   
    } 
 }
 
 public function sellerLeadunSyncToDC($apikey){
    if($apikey== 'p3zW7WLsni08WqoeQ=') 
    {
     $dealersClassified=$this->Leadsellmodel->getclassifiedDealers();
     if(!empty($dealersClassified)){
         foreach($dealersClassified as $dealer){
            $dealerId=$dealer['dealer_id'];
            $perPageRecord=10;
            $customerData=$this->Leadsellmodel->getsellerLeadunSyncToDC($dealerId,$perPageRecord);
            $leadData=array();
            $data=array();
            $i=0;
            $leadIds=[];
            if(!empty($customerData)){
                foreach($customerData as $customer ){
                $data[$i]['apikey']     ='p3zW7WLsni08WqoeQ=';
                $data[$i]['dealer_id']  =$customer['dealer_id'];
                $data[$i]['mobile_no']  =$customer['mobile'];
                $data[$i]['sms_user']  =$customer['sms_user'];
                $data[$i]['msg']  =$customer['msg'];
                $data[$i]['name']  =$customer['name'];
                $data[$i]['email']  =$customer['email'];
                $data[$i]['locality']  =$customer['locality'];
                $data[$i]['pin_code']  =$customer['pin_code'];
                $data[$i]['address']  =$customer['address'];
                $data[$i]['make']  =$customer['make'];
                $data[$i]['model']  =$customer['model'];
                $data[$i]['variant']  =$customer['variant'];
                $data[$i]['make_id']  =$customer['make_id'];
                $data[$i]['model_id']  =$customer['model_id'];
                $data[$i]['version_id']  =$customer['version_id'];
                $data[$i]['transmission']  =$customer['transmission'];
                $data[$i]['tax']  =$customer['tax'];
                $data[$i]['insurance_type']  =$customer['insurance_type'];
                $data[$i]['insurance_expiry']  =$customer['insurance_expiry'];
                $data[$i]['about_car']  =$customer['about_car'];
                $data[$i]['images']  =$customer['images'];
                $data[$i]['myear']  =$customer['myear'];
                $data[$i]['mmonth']  =$customer['mmonth'];
                $data[$i]['colour']  =$customer['colour'];
                $data[$i]['km']  =$customer['km'];
                $data[$i]['fuel_type']  =$customer['fuel_type'];
                $data[$i]['pricefrom']  =$customer['pricefrom'];
                $data[$i]['regno']  =$customer['regno'];
                $data[$i]['regplace']  =$customer['regplace'];
                $data[$i]['regplace_city_id']  =$customer['regplace_city_id'];
                //$data['flag']  =$customer['flag'];
                $data[$i]['source']  =$customer['source'];
                $data[$i]['verified']  =$customer['verified'];
                $data[$i]['city']  =$customer['city'];
                $data[$i]['city_id']  =$customer['city_id'];
                $data[$i]['owner']  =$customer['owner'];
                $data[$i]['href']  =$customer['href'];
                $data[$i]['status']     =(strtolower($customer['status'])=='walked-in')?'Evaluation Done':$customer['status'];
                $data[$i]['followdate'] =$customer['follow_date']!='0000-00-00 00:00:00'?$customer['follow_date']:'';   
                $data[$i]['usertype']   ='dealer';
                $data[$i]['userid']     =$customer['user_id'];
                $leadIds[].=$customer['leadId'];
                $i++;
             }
                if($leadIds){
                $results=json_encode($data);
                $leadData['salt_key']='g1a3a5d7i9';
                $leadData['api_name']='status_only';
                $leadData['is_sent']='0';
                $leadData['dealer_id']=$dealerId;
                $leadData['info']=$results;
                //print_r($leadData);die;
                $url=API_URL."api/sell_lead_verify_crm.php?salt_key=g1a3a5d7i9&is_sent=0&info";
                $response=$this->sendLeadsToDC($leadData, $url);
                if($response){
                //$res=json_decode($response,true);    
                $syndata['sync_status']='1';
                $this->Leadsellmodel->syncStatus($syndata,$leadIds);
                //echo"response for status follow up date<pre>";print_r($sellres);
                }
                }
            }else{
                echo "empty data";
            }  
    }}else{
        echo "Dealers not exist";
    } }else{
      echo "Invalid Api";     
    } 
 }
 
 public function sellerLeadCommentsToDC($apikey){
    if($apikey== 'p3zW7WLsni08WqoeQ=') 
    {
     $dealersClassified=$this->Leadsellmodel->getclassifiedDealers();
     if(!empty($dealersClassified)){
         foreach($dealersClassified as $dealer){
            $dealerId=$dealer['dealer_id'];
            $perPageRecord=10;
            $customerComments=$this->Leadsellmodel->getsellerLeadCommentsToDC($dealerId,$perPageRecord);
     //echo "<pre>";
     //print_r($customerComments);die;
     $data=[];       
     $commentids=[];
     if(!empty($customerComments)){
         $i=0;
     foreach($customerComments as $comment ){
                $data[$i]['apikey']     ='p3zW7WLsni08WqoeQ=';
                $data[$i]['dealer_id']  =$comment['dealer_id'];
                $data[$i]['mobile_no']  =$comment['mobile'];
                $data[$i]['status']     =(strtolower($comment['status'])=='walked-in')?'Evaluation Done':$comment['status'];
                $data[$i]['followdate'] =$comment['follow_date']!='0000-00-00 00:00:00'?$comment['follow_date']:''; 
                $data[$i]['comment']    =$comment['comment'];
                $data[$i]['usertype']   =$comment['comment_source'];
                $data[$i]['userid']     =$comment['comented_user_id'];
                $commentids[]=$comment['comment_id'];
                $i++;
             }
                if($commentids){
                $results=json_encode($data);
                $leadData['salt_key']='g1a3a5d7i9';
                $leadData['api_name']='comment_only';
                $leadData['is_sent']='0';
                $leadData['dealer_id']=$dealerId;
                $leadData['info']=$results;
                $url=API_URL."api/sell_lead_verify_crm.php?salt_key=g1a3a5d7i9&is_sent=0&info";
                $response=$this->sendLeadsToDC($leadData, $url);
                //print_r($response);die;
                if($response){
                $syndata['sync_status']='1';
                $this->Leadsellmodel->syncComments($syndata,$commentids); 
                //echo"response for status follow up date<pre>";print_r($sellres);
                }
                }
     }else{
         echo "Empty data set";
     }
     }}else{
         echo "Dealers Not Exist";
     }
     }  else{
      echo "Invalid API Key";     
    }
 }
 
 public function addNewcaseInsurance($apikey){
   if($apikey== 'p3zW7WLsni08WqoeQ=') 
    {
       $data=[];
       $data=$this->Crm_renew->getrenewCases();
       if(!empty($data)){
           foreach($data as $k=>$v){
               $caseId='';
               $today=date('Y-m-d');
               //echo  date($v['insurance_expire'],strtotime("+45 day"));
               $today45day=date('m-d', strtotime("+45 day", strtotime($today)));
               $expiryday=date('m-d', strtotime($v['insurance_expire']));
               if($expiryday <= $today45day){
                $caseId=$v['last_insurance_case_id'];
               
              if($caseId!=''){
                $csId=$v['id'];
                $customerId=$this->Crm_insurance->getAddUpdateCaseDetails($caseId,$csId);
                $imgData=$this->Crm_upload_docs_list->getInsImageList('','','','',3,$caseId);
                if(!empty($imgData)){
                    foreach($imgData as $imgk=>$imgv){
                    $imgArr=[];    
                    $caseData=current($this->Crm_insurance->getCaseDetailsByCustomerId($customerId));
                    $newCaseId=!empty($caseData['id']) ? $caseData['id'] :'';
                    $imgArr['doc_name']=!empty($imgv['doc_name']) ? $imgv['doc_name']:'';
                    $imgArr['doc_url']=!empty($imgv['doc_url']) ? $imgv['doc_url'] : '';
                    $imgArr['doc_type']=!empty($imgv['doc_type']) ? $imgv['doc_type'] : '';
                    $imgArr['customer_id']=!empty($customerId) ? $customerId : '';
                    $imgArr['case_id']=$newCaseId;
                    $imgArr['status']='1';
                    $imgArr['created_on']=$this->dateTime;
                    $this->Crm_upload_docs_list->insertLoginDocs($imgArr);
                    }
                }
        }
           }
           if(!empty($customerId)){
           echo "Case Added";
           }
       }}else{
           echo "Record Not Available";
       }
    }else{
        echo "Invalid Api Key";
    }  
 }


 public function sendLeadsToDC($leaddata, $url,$header='',$AUTH_KEY='',$SOURCE='') {
    if (isset($leaddata) && !empty($leaddata) > 0) {
        $vars='';
        foreach ($leaddata as $k => $v) {
            $vars .= '&' . $k . '=' . $v;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(!empty($header))
        {
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("key:" . $AUTH_KEY, "source:" . $SOURCE));
        }
        curl_setopt($ch, CURLOPT_POST, count($vars));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        $response = curl_exec($ch);
        print_r($response);
        return $response;
    }
}

public function adminPullDealer()
 {
    if(@php_sapi_name() != 'cli') 
    {
        $leaddata['dealer_id']=DEALER_ID;
        $url = API_URL.'central-admin-api/v1/crm/crmdetails';
        $response = $this->curlPost($url,$leaddata,'Uh9vBqeiwsojTSecOXFLbPiZ40fGJGqsM','crm');
        $res = json_decode($response);
        $requestParams = json_decode(json_encode($res), True);
        if(!empty($requestParams['data'])){
         $tes = $this->Crm_dealers->addUpdateAdminDealer($requestParams);// exit;
         echo json_encode($tes);
        }
        else
        {
            echo "Dealer is not in Dealer System."; 
        }
    }
    else
    {
        echo "You dont have access"; 
    }
 }

 public function curlPost($url, $data, $auth_key, $source)
    {

        $curl     = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, count($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("key:" . $auth_key, "source:" . $source));
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 500); // curl request connection timeout time 
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($curl);
        return $response;
    }
    

    
    public function pullModel()
    {   
        $tanle_name = 'dealers.make_model';
        $data = $this->Make_model->getDealersTableData($tanle_name);
        if(empty($data))
         die('No data found');   
        $this->Make_model->truncate_table($tanle_name);
        $this->Make_model->inset_data($tanle_name,$data);
        die('Make model Data copyed successfully');
        
    }

    public function pullVersion()
    {   
        $tanle_name = 'dealers.model_version';
        $data = $this->Make_model->getDealersTableData($tanle_name);
        if(empty($data))
         die('No data found');
        $this->Make_model->truncate_table($tanle_name);
        $this->Make_model->inset_data($tanle_name,$data);
        die('Model_version Data copyed successfully');
    }

    public function sendSmsToDealer(){
        $this->onetimeSms('9667006376');
        exit;
       $dealerDetail = $this->Crm_dealers->allDealers();
       foreach($dealerDetail as $key =>$value){
         $dealerDetail = $this->Crm_dealers->getDealerShowroom($value['id']);
         //$dealerDetail[0]['owner_mobile'] = "8826975366";
       //  $this->renderOnboardingSms($dealerDetail[0], $dealerDetail[0]['owner_mobile'], $id);
        // $dealerInfo = array('sms_sent' => 1);
       //  $this->Crm_dealers->updateDealerStatus($dealerInfo,$id);
       }
     
       return 1;
    }
    
        public function renderOnboardingSms($dealerInfo,$ownerMobile,$dealer_id)
    {
        $markedby  = $this->Crm_user->getEmployee('',$this->session->userdata['userinfo']['id']);
        $mobile    = current($this->Loan_customer_info->getCustomerMobileNumber($loanData[0]['customer_id']));
        $content = "Welcome to Bir Motors,-NL2BR- -NL2BR-Dear ".ucwords(strtolower($dealerInfo['organization'])).', thanks for your association with us.-NL2BR--NL2BR-For any auto loan, refinance, purchase of new or used car, car insurance you can reach us on 9710021795 and 9710221795'; 
        $this->smsSent($ownerMobile,$content,$dealer_id,'','','',1);
        return 1;


    
}

    public function oneTimeDoMigration()
    {
        $data = [];
        $this->db->select('*');
        $this->db->from('crm_finance_delivery');
        $query = $this->db->get();
        $result = $query->result_array();
        foreach ($result as $rkey => $rvalue) {
            $data['gross_do_amt']   = $rvalue['new_car_price'];
            $data['dshowroom_dis']   = $rvalue['scheme_disc'];
            $data['showroom_discount']   = $rvalue['showroom_disc'];
            $data['net_do_amt']   = $rvalue['do_amt'];
            $data['margin_money']   = 0;
            $data['reg_type']   = 1;
            $data['margin_money_inhouse']   = 0;
            if($rvalue['application_no']!=''){
                $data['loan_amt'] = $this->loanDetails($rvalue['application_no']);
            }
            $this->db->where('id', $rvalue['id']);
            $this->db->update('crm_finance_delivery', $data);
            echo $this->db->last_query();
            echo "  ---  ";
          // echo $result = $rvalue['id'] .'\n';
        }
    }

        public function loanDetails($loanId){
            $loan_amt = 0;
            $custInfo=$this->Loan_customer_case->getloanInfoByCaseId($loanId);
            if(!empty($custInfo[0]['gross_net_amount']))
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
            }
            return $loan_amt;
        }


    public function updateMiscellaneous()
    {   
        $tanle_name = 'dealers.used_car_miscellaneous';
        $data = $this->Crm_stocks->getStockByDealerId(DEALER_ID);
        if(empty($data))
         die('No data found');
        foreach ($data as $key => $values) 
        {
          $newdata = [];
          $misData =  $this->Crm_stocks->getDealersMiscellTableData($tanle_name,$values['id']);
          $checkIf = $this->Crm_stocks->getMiscellTableData($misData[0]['id']);
          $updateid='';
          if(!empty($checkIf))
          {
            $updateid = $misData[0]['id'];
          }
          foreach ($misData as $keys => $value) {
           
                $newdata['id']   = $value['id'];  
                $newdata['usedcar_id']   = $value['usedcar_id'];   
                $newdata['certification_id']   = $value['certification_id'];    
                $newdata['car_certification']   = $value['car_certification'];    
                $newdata['warranty_id']   = $value['warranty_id'];  
                $newdata['cng_lpg_fitment_endorsement_rc']   = $value['cng_lpg_fitment_endorsement_rc'];  
                $newdata['cng_lpg_fitment']   = $value['cng_lpg_fitment'];  
                $newdata['rc_image_url']   = $value['rc_image_url']; 
                $newdata['rc_document_url']   = $value['rc_document_url'];  
                $newdata['inspection_url']   = $value['inspection_url'];    
                $newdata['inspection_url_insurance']   = $value['inspection_url_insurance'];
                $newdata['engine_number']   = $value['engine_number'];    
                $newdata['chassis_no']   = $value['chassis_no'];   
                $newdata['recommended_package']   = $value['recommended_package'];   
                $newdata['evalution_id']   = $value['evalution_id'];   
                $newdata['ford_id']   = $value['ford_id'];   
                $newdata['honda_id']   = $value['honda_id'];   
                $newdata['dealercrm_id']   = $value['dealercrm_id'];   
                $newdata['clone_status']   = $value['clone_status'];  
                $newdata['fin_list']   = $value['fin_list'];   
                $newdata['inCertificationProcess']   = $value['inCertificationProcess'];    
                $newdata['sell_dealer']   = $value['sell_dealer'];  
                $newdata['image_folder']   = $value['image_folder'];    
                $newdata['cardekho_id']   = $value['cardekho_id'];   
                $newdata['good_deal_score']   = $value['good_deal_score'];    
                $newdata['is_good_deal']   = $value['is_good_deal'];    
                $newdata['cd_car_url']   = $value['cd_car_url'];   
                $newdata['updated_date_api']   = $value['updated_date_api'];    
                $newdata['lead_platform']   = $value['lead_platform'];    
                $newdata['is_updated']   = $value['is_updated'];   
                $newdata['demo_car']   = $value['demo_car'];   
                $newdata['qc_reg_no']   = $value['qc_reg_no'];   
                $newdata['stock_removal_reason_id']   = $value['stock_removal_reason_id'];   
                $newdata['is_carplan']   = $value['is_carplan'];   
                $newdata['gaadi_update_date']   = $value['gaadi_update_date'];  
                $newdata['secondaryid']   = $value['secondaryid'];    
                $newdata['encrypt_id_cardekho']   = $value['encrypt_id_cardekho'];   
                $newdata['encrypt_id_gaadi']   = $value['encrypt_id_gaadi'];
                $newdata['stock_type']   = $value['stock_type'];  
                $newdata['market_price']   = $value['market_price'];   
                $newdata['is_verified']   = $value['is_verified'];    
          }
          if(!empty($newdata))
          $this->Crm_stocks->updateMiscellaneousTableCrm($newdata,$updateid);

        
        }
        die('Miscellaneous Data Updaated successfully');
    }


      public function updateCarPermits()
    {   
        $data = $this->Crm_stocks->getStockOtherDetailsByDealerId(DEALER_ID);
       
        if(empty($data))
         die('No data found');
         $updateData = array();
        foreach ($data as $key => $values) 
        {
            //echo $values['reg_no'].'<br>';
            $d = date('Y-m-d');
            if(($values['permitvalid'])<= $d)
            {
                //echo 'permitvalid='.date('Y-m-d',strtotime($values['permitvalid'])).'<='.$d;
                //echo "ggg";
                $updateData['permit']='1';
                $updateData['permitvalid']='0000-00-00';
            }
            if(($values['fitvalid'])<= $d)
            {
                //echo 'fitvalid='.date('Y-m-d',strtotime($values['fitvalid'])).'<='.$d;
                //echo "ggg1";
                $updateData['fitness_certi']='1';
                $updateData['fitvalid']='0000-00-00';
            }
            if(($values['road_txvalid'])<= $d)
            {
                //echo 'road_txvalid='.date('Y-m-d',strtotime($values['road_txvalid'])).'<='.$d;
                //echo $values['road_txvalid'];
                 $updateData['road_txvalid']='0000-00-00';
                //echo "ggg2";
                $updateData['road_tx']='1';
            }    
        
     
            if(!empty($updateData)){
            $this->Crm_stocks->updateotherTableCrm($updateData,$values['id']);
        }
        }
        
        die('Data Updated successfully');
    }

    public function checkinsuranceValid()
    {
        $data = $this->Crm_stocks->getStockOtherDetailsByDealerId(DEALER_ID);
       
        if(empty($data))
         die('No data found');
         $updateData = array();
         $updateCron = array();
        foreach ($data as $key => $values) 
        {
            $d = date('Y-m-d');
            if(((strtolower($values['insurance_type']))!='no insurance') && ($values['insurance_date']<=$d))
            {
                 $updateData['insurance_date']='0000-00-00';
                 $updateCron['insurance_type'] = 'no insurance';
                 $updateCron['insurance_exp_month'] = 0;
                 $updateCron['insurance_exp_year'] = 0;
            }    
        
     
            if(!empty($updateData))
            {
                $this->Crm_stocks->updateotherTableCrm($updateData,$values['id']);
            }
            if(!empty($updateCron))
            {
               $update = $this->db->update('crm_used_car', $updateCron, array('id' => $values['carid']));
            }
        }
        
        die('Data Updated successfully');
    }
   
   public function moveoldimagestoaws()
   {
        $data = $this->Crm_upload_docs_list->getawsurl();
        if(empty($data))
        die('No data found');
        foreach ($data as $key => $values) 
        {
            $d = date('Y-m-d');
            $doc_url = $values['doc_url'];
            $docurl = explode('/', $doc_url);
            $docfolder = $docurl[3];
            $docimage = $docurl[4]; 

            $newurl = $docfolder.'/'.$docimage;   
            if(!empty($newurl))
            {
                $this->Crm_upload_docs_list->setawsurl($newurl,$values['id']);
            }
        }
        
        die('Data Updated successfully');
   }

   public function uploadimagestoaws()
   {
            $data = $this->Crm_upload_docs_list->getawsurl();
            $this->load->library('aws_lib');
            if(!empty($data))
            {
                
                foreach ($data as $key => $value) 
                { 
                    $doc_url = $value['doc_url'];
                    $docurl = explode('/', $doc_url);
                    $docfolder = $docurl[0];
                    $docimage = $docurl[1]; 
                    $sourceFile      = '/data1/deployer/dealercrmimage/'.$docfolder.'/'.$docimage;
                    $name            = $docimage;
                    $destinationFile = $docfolder.'/'.$name;
                    $file_exl = explode('.',$name);
                    $aws_url = $this->aws_lib->Upload($sourceFile, $destinationFile,end($file_exl)); 
                    if(!empty($aws_url['@metadata']['statusCode']) && $aws_url['@metadata']['statusCode']==200)
                    {
                        $result = $this->Crm_upload_docs_list->setawsurl($destinationFile,$value['id'],'1');
                    }
                }
            }
            $datausedcar = $this->UsedCarImageMapper->getCrmUcImages('','',2);
            if(!empty($datausedcar))
            {
                //$this->load->library('aws_lib');
                foreach ($datausedcar as $key => $value) 
                { 
                    $doc_url = $value['image_url'];
                    $docurl = explode('/', $doc_url);
                    $docfolder = $docurl[3].'/'.$docurl[4];
                    $docimage = $docurl[5]; 
                    $sourceFile      = '/data1/deployer/dealercrmimage/'.$docfolder.'/'.$docimage;
                    $name            = $docimage;
                    $destinationFile = $docfolder.'/'.$name;
                    $file_exl = explode('.',$name);
                    $aws_url = $this->aws_lib->Upload($sourceFile, $destinationFile,$file_exl[1]); 
                    if(!empty($aws_url['@metadata']['statusCode']) && $aws_url['@metadata']['statusCode']==200)
                    {
                        $result = $this->Crm_upload_docs_list->setusedcarawsurl($aws_url['@metadata']['effectiveUri'],$value['id'],'1');
                    }
                }
            }
    }

    /*public function onetimeSms($mobile)
    {
        $arr = ["company_handle" =>"2000191142",
                 "channel_type"=> "SMS_GUPSHUP",
                 "to"=> $mobile,
                 "message_behaviour_type"=> "MARKETING",
                 "message_priority"=> "HIGH",
                 "text"=> "Greetings from Bir Motors\nWe resume our office and accepting auto loan cases with proper distancing. You can coonect with our sales executive for any case.",
                 "data_attributes"=> {
                   "mask"=> "BIRMTR",
                   "domain"=> "",
                   "businessUnit"=> "Used car",
                   "subBusinessUnit"=> "Clasifieds",
                   "businessDept"=> "UBLMS",
                   "tag"=> "",
               }
               ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://botify.girnarsoft.com/api/v1/botify/send-message");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'access-key:MK7NllC9CNF2kQdX7OwEoEP1vKqoC5Sy7Q2OUd1q',
            'access-secret:22W2RdXT5cyuoAzZz938nKTpMidxD6CEFgU1zGyJxEPBztlDm2xX6Ku6DikSDcdPM79YLqd3DwQYUxOy',
            'cache-control:no-cache',
            'content-type:application/json;charset=UTF-8',
            'input-token:b7e01d683f6665da2f9174b35b87339660fc41005e32edae8a29b04cc7c04db89fdc082e7c9176a1f2830e6438cfcbed4e8c422587d6a9f9a9a23901453f3c30
            ts:1234567890',
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec ($ch);

        curl_close ($ch);
    }*/
}
