<?php

/** 
 * model : Crm_renew
 * User Class to control all insurance renew related operations.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_renew extends CI_Model {

    //public $activity_mapping = array('New' => '1', 'Follow Up' => '2', 'Quotes shared' => '3','Closed' => '4');
    //public $zone_A_arr = array('8','125','129','227','336','344','471','660');
    
    public function __construct() {
        parent::__construct();
        $this->dateTime=date('Y-m-d H:i:s');
        $this->load->model('Crm_renew_history_track');
        $this->load->model('Crm_insurance_part_payment');
    }
    
    public function getCaseList($requestParams, $dealerId,$userId){
        $responseData = array();
        $daysCount = 30;
        $perPageRecord = $requestParams['rpp'] == 0 ? 10 : $requestParams['rpp'];
        $pageNo = (isset($requestParams['page']) && $requestParams['page'] != '') ? $requestParams['page'] : '1';
        $startLimit = ($pageNo - 1) * $perPageRecord;
        $requestParams['dealerID']=$dealerId;
        $requestParams['userId']=$userId;
        $getleads=$this->getInsleadsQuery($requestParams, $perPageRecord, $pageNo, $startLimit);
        
        //$totalRecords = count($this->getInsleadsQuery($requestParams, $perPageRecord, $pageNo, $startLimit,'1'));
        $totalRecords = count($getleads);
        $leads = array();
        if (!empty($getleads)) {
            $i = 0;
               foreach ($getleads as $key => $val) {
                $leads[$i]['caseId']=$val['caseId'];
                $leads[$i]['customer_id']=$val['customer_id'];
                $leads[$i]['dealerID'] = $dealerId;
                //$leads[$i]['ucdid'] = $val['ldm_dealer_id'];
                $leads[$i]['emailID'] = (stripos($val['customer_email'], "null") == true ? '' : $val['customer_email']);
                $leads[$i]['changetime'] = $val['created_date'];
                $name = ucwords(strtolower(preg_replace("/[^a-zA-Z\s]/", "", $val['customer_name'])));
                $leads[$i]['customer_name'] = (stripos($name, "null") == true ? '' : $name);
                $leads[$i]['customer_company_name'] = $val['customer_company_name'];
                $leads[$i]['customer_mobile'] =$val['mobile'];
                $leads[$i]['city_name']=ucwords(strtolower(preg_replace("/[^a-zA-Z\s]/", "", $val['city_name'])));
                $leads[$i]['customer_company_name'] = $val['customer_company_name'];
                $leads[$i]['number'] = preg_replace("/[^0-9]/", "", $val['mobile']);
                $leads[$i]['mmv'] = $val['makeName']."-".$val['modelName']."-".$val['versionName'];
                $leads[$i]['make'] = $val['makeName'];
                $leads[$i]['model'] = $val['modelName'];
                $leads[$i]['version'] = $val['versionName'];
                $leads[$i]['regNo'] =$val['regNo'];
                $leads[$i]['ins_category'] =$val['ins_category'];
                $leads[$i]['isexpired'] =$val['isexpired'];
                $leads[$i]['dealerName'] =$val['dealerName'];
                $leads[$i]['source'] =  ucfirst(strtolower($val['source']));
                $leads[$i]['lead_status_id'] = $val['follow_status'];
                $leads[$i]['lead_status'] = $val['status_name'];
                $leads[$i]['make_year'] = $val['make_year'];
                $leads[$i]['leadCreatedDate'] = ($val['addDate']!='0000-00-00') ? date("d M, Y",strtotime($val['addDate'])) : '';
                $leads[$i]['last_updated_date'] = ($val['last_updated_date']!='0000-00-00 00:00:00') ? date("d M, Y",strtotime($val['last_updated_date'])) : '';
                $leads[$i]['created_date'] = ($val['created_date']!='') ? date("d M, Y",strtotime($val['created_date'])) : '';
                $leads[$i]['make_year'] = $val['make_year'];
                $leads[$i]['insurer_name']=$val['short_name'];
                $leads[$i]['due_date'] = $val['current_due_date'];
                $leads[$i]['assign_to'] = $val['assign_to'];
                $leads[$i]['employeeName'] = $val['employeeName'];
                $leads[$i]['current_policy_no'] = $val['current_policy_no'];
                $leads[$i]['previous_policy_no'] = $val['previous_policy_no'];
                $leads[$i]['previous_due_date'] = ($val['previous_due_date']!='0000-00-00') ? date("d M, Y",strtotime($val['previous_due_date'])) : '';
                $leads[$i]['follow_up_date']=$val['follow_date'];
                $leads[$i]['follow_status']=$val['follow_status'];
                $leads[$i]['comment']=$val['comment'];
                $leads[$i]['quote_add_date']=($val['quote_add_date']!='0000-00-00 00:00:00') ? date("d M,Y",strtotime($val['quote_add_date'])):'';
                $leads[$i]['payment_date']=($val['payment_date']!='0000-00-00') ? date("d M, Y",strtotime($val['payment_date'])):'';
                $leads[$i]['upload_ins_doc_flag']=$val['upload_ins_doc_flag'];
                $leads[$i]['od_amt']=$val['od_amt'];
                $leads[$i]['idv']=$val['idv'];
                $leads[$i]['current_insurance_company']=$val['current_insurance_company'];
                $leads[$i]['previous_insurance_company']=$val['previous_insurance_company'];
                $leads[$i]['inspection_add_date']=($val['inspection_add_date']!='0000-00-00 00:00:00') ? date("d M, Y",strtotime($val['inspection_add_date'])) : '';
                $leads[$i]['customer_address']=$val['customer_address'];
                $leads[$i]['ins_approval_status']=$val['ins_approval_status'];
                $leads[$i]['quote_shared_status']=$val['quote_shared_status'];
                $leads[$i]['inspection_status']=$val['inspection_status'];
                $leads[$i]['policy_status']=$val['policy_status'];
                $leads[$i]['updateStatus']=$val['updateStatus'];
                $leads[$i]['buyer_type'] = $val['buyer_type'];
                $leads[$i]['payment_by'] = $val['payment_by'];
                $leads[$i]['last_updated_status'] = $val['last_updated_status'];
                $leads[$i]['preinsurerName']=$val['preinsurerName'];
                $leads[$i]['fstatus']=$val['fstatus'];
                $leads[$i]['customer_nominee_ref_name'] = $val['customer_nominee_ref_name'];
                $historyData=[];
                $historyData=$this->Crm_renew_history_track->getRenewHistoryTrack($val['caseId'],'',1);
                $leads[$i]['history']=$historyData;
                $leads[$i]['IsPaymentCompleted']= $this->IsPaymentCompleted($val['customer_id']); 
                $i++;
            }
        }
        $lastRecord = $pageNo * $perPageRecord;
        $nextRecords = true;
        if ($lastRecord >= $totalRecords) {
            $nextRecords = false;
        }
        
        if (isset($requestParams['leadID']) && $requestParams['leadID'] > 0) {
            return array('status' => 'T', 'leads' => $leads);
        }
        $responseData['error'] = "";
        $responseData['msg'] = "username and password matched!!";
        $responseData['status'] = "T";
        if ($pageNo == '1') {
           //$responseData['budget_list'] = $this->Crm_buy_lead_customer_preferences->getbudgetList();
            //$responseData['budget_list']='';
        }
        $responseData['leads'] = $leads;
        
        $responseData['pageNumber'] = $pageNo;
        
            $responseData['totalRecords'] = $totalRecords;
            $responseData['hasNext'] = $nextRecords;
            $responseData['viewcolcount'] = ($requestParams['currenturl']=='getInsCases')?8:7;
     
        $responseData['hasNext'] = $nextRecords;
        $responseData['pageSize'] = $perPageRecord;
        $responseData['days_count'] = $daysCount;

        return $responseData;
    }
    
    public function getInsleadsQuery($requestParams, $perPageRecord, $pageNo, $startLimit)
    {
        $current_date = date('Y-m-d');
        $todaylast30 = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 30));
        $todayplus45 = date('Y-m-d', strtotime(date('Y-m-d')) + (3600 * 24 * 45));
        $todayplus30 = date('Y-m-d', strtotime(date('Y-m-d')) + (3600 * 24 * 30));
        $todaylastyear = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 365));
        
         //$fetchFields = '`cd`.customer_name,cd.customer_email,cd.customer_company_name,cd.customer_address,cd.buyer_type,cd.payment_by,icd.ins_approval_status,icd.quote_shared_status,icd.inspection_status,icd.policy_status,icd.last_updated_status,icd.created_date,lc.mobile,icd.regNo,icd.ins_category,cd.isexpired,icd.source,icd.follow_status,cs.status_name,icd.make_year,icd.last_updated_date,pp.short_name,cd.current_due_date,icd.assign_to,cd.current_policy_no,cd.previous_policy_no,cd.previous_due_date,icd.comment,icd.quote_add_date,cd.payment_date,icd.upload_ins_doc_flag,cd.od_amt,cd.idv,cd.current_insurance_company,cd.previous_insurance_company,icd.inspection_add_date,c.city_name,cd.id as customer_id,cs.id as lead_status_id,icd.follow_up_date as follow_date,mm.make as makeName,mm.model as modelName,mv.db_version as versionName,d.organization as dealerName,u.name as employeeName,icd.created_date as addDate,ust.status as updateStatus,icd.id as caseId,pp.short_name as preinsurerName,rfs.status as fstatus';
        //$this->db->select($fetchFields);
        $this->db->select('icd.*,cd.*,pp.short_name,cs.status_name,lc.mobile,c.city_name,cd.id as customer_id,cs.id as lead_status_id,icd.follow_up_date as follow_date,mm.make as makeName,mm.model as modelName,mv.db_version as versionName,d.organization as dealerName,u.name as employeeName,icd.created_date as addDate,ust.status as updateStatus,icd.id as caseId,pp.short_name as preinsurerName,rfs.status as fstatus,cd.customer_nominee_ref_name');
        $this->db->from('crm_insurance_case_details as icd');
        $this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id','inner');
        $this->db->join('crm_customers as lc', 'lc.id=cd.crm_customer_id','inner');
        $this->db->join(CITY_LIST.' as c', 'c.city_id=cd.customer_city_id','left');
        $this->db->join('crm_prev_policy_insurer as pp', 'pp.prev_policy_insurer_slug=cd.previous_insurance_company','left');
        $this->db->join('crm_insurance_customer_status AS cs', 'cs.id=icd.follow_status','left');
        $this->db->join(MODEL_VERSION.' as mv', 'mv.db_version_id=icd.variantId','left');
        $this->db->join(MAKE_MODEL.' as mm', 'mm.id=mv.model_id','left');
        $this->db->join('crm_dealers as d', 'd.id=icd.dealer_id and d.status="1"','left');
        $this->db->join('crm_user as u', 'u.id=icd.assign_to and u.status="1"','left');
        $this->db->join('crm_insurance_update_status as ust', 'ust.statusId=icd.last_updated_status','left');
        $this->db->join('crm_insurance_renew_follow_status as rfs', 'rfs.statusId=icd.follow_status','left');
        $this->db->join('crm_insurance_quotes as qu', 'qu.customer_id=icd.customer_id and qu.is_latest="1" and qu.flag="1"','left');
        //$this->db->where('icd.dealer_id' ,DEALER_ID);
        //$this->db->where('icd.dealer_id>','0');
        if(!empty($requestParams['userId']) && $requestParams['userId'] > 0 && $requestParams['userId']!='1'){
           $this->db->where('icd.assign_to',$requestParams['userId']); 
        }
        
        if(!empty($requestParams['type']) && ($requestParams['type']=='upcomingfollow')){
                    $this->db->where('icd.follow_status!=',5);
                       $wheres ="(MONTH(cd.previous_due_date) > '".date('m')."' or (MONTH(cd.previous_due_date)='".date('m')."'  AND DAY(cd.previous_due_date) >= '".date('d')."'))";
                    $this->db->where($wheres);
                    $this->db->where('date(icd.follow_up_date)>',date('Y-m-d'));
                    $this->db->where('icd.follow_up_date!=','0000-00-00 00:00:00');
                    $this->db->order_by('icd.follow_up_date','ASC'); 
        }
        if(!empty($requestParams['type']) && ($requestParams['type']=='allfollow')){
            //$this->db->where('icd.follow_status!=',5);
              $wheres ="(MONTH(cd.previous_due_date) > '".date('m')."' or (MONTH(cd.previous_due_date)='".date('m')."'  AND DAY(cd.previous_due_date) >= '".date('d')."'))";
             $wheres2 = "(icd.follow_up_date='0000-00-00 00:00:00' or (date(icd.follow_up_date) = '".Date('Y-m-d')."'))";  
            // $whered = "((icd.follow_up_date != '0000-00-00 00:00:00' AND date(icd.follow_up_date) = '".Date('Y-m-d')."' and (MONTH(cd.previous_due_date) > '".date('m')."' or (MONTH(cd.previous_due_date)='".date('m')."'  AND DAY(cd.previous_due_date) >= '".date('d')."')) or (Year(cd.previous_due_date) = '".date('Y')."' and ((date(icd.follow_up_date)= '".Date('Y-m-d')."')) or (icd.follow_up_date ='0000-00-00 00:00:00')))) AND icd.follow_status != 5) ";
             $whered = "( (icd.follow_up_date != '0000-00-00 00:00:00' AND date(icd.follow_up_date) = '".Date('Y-m-d')."' and (MONTH(cd.previous_due_date) > '".date('m')."' or  
(MONTH(cd.previous_due_date) = '".date('m')."'  AND DAY(cd.previous_due_date) >= '".date('d')."')) or (Year(cd.previous_due_date) = '".date('Y')."' and ((date(icd.follow_up_date)= '".Date('Y-m-d')."') or (icd.follow_up_date ='0000-00-00 00:00:00'))))AND `icd`.`follow_status` != 5)";   
            $this->db->where($whered);
           // $this->db->where($wheres2);
           // $this->db->where('Year(cd.previous_due_date)>=',Date('Y'));
            $this->db->order_by('icd.follow_up_date','DESC'); 
            $this->db->order_by('DAY(cd.previous_due_date)','ASC');    
            $this->db->order_by('MONTH(cd.previous_due_date)','ASC');  
            
        }
        if(!empty($requestParams['type']) && ($requestParams['type'] == 'pastfollow')){
            $this->db->where('icd.follow_status!=',5);
            $this->db->where('icd.follow_up_date!=','0000-00-00 00:00:00');
               $wheres ="(MONTH(cd.previous_due_date) > '".date('m')."' or (MONTH(cd.previous_due_date)='".date('m')."'  AND DAY(cd.previous_due_date) >= '".date('d')."'))";
                    $this->db->where($wheres);
            $this->db->where('date(icd.follow_up_date)<',date('Y-m-d'));
            $this->db->order_by('icd.follow_up_date','DESC'); 
        }
        if(!empty($requestParams['type']) && ($requestParams['type'] == 'breakin')){
            $this->db->where('Year(cd.previous_due_date)<',date('Y'));
            $this->db->where('icd.follow_up_date=','0000-00-00 00:00:00');
            $this->db->where('icd.follow_status!=',5); 
           $wheres ="(MONTH(cd.previous_due_date) >= '".date('m')."' or (MONTH(cd.previous_due_date)='".date('m')."'  AND DAY(cd.previous_due_date) >= '".date('d')."'))";
                    $this->db->where($wheres);
            $this->db->order_by('DAY(cd.previous_due_date)','ASC');    
            $this->db->order_by('MONTH(cd.previous_due_date)','ASC'); 
        }
        if(!empty($requestParams['type']) && ($requestParams['type'] == 'lost')){
            $this->db->where('icd.follow_status',5); 
            $this->db->order_by('icd.last_updated_date','DESC');
        }
        if(!empty($requestParams['type']) && ($requestParams['type']=='allcount')){
            if(isset($requestParams['tabtype']) && $requestParams['tabtype']=='3'){
                $dt = date("Y-m-d");
                $expired_7days = date( "Y-m-d", strtotime( "$dt +7 day" ) );
                $wheres3 = "DATE(cd.previous_due_date) >='".date("Y-m-d")."' AND DATE(cd.previous_due_date) <='".$expired_7days."'";
                $this->db->where($wheres3);                 
            }
            $this->db->order_by('icd.last_updated_date','DESC'); 
        }
         if(!empty($requestParams['type']) && ($requestParams['type']=='policyexpired')){
            
                  // $this->db->where('Year(cd.previous_issue_date)<',date('Y'));
                    $wheres ="(MONTH(cd.previous_due_date) < '".date('m')."' or (MONTH(cd.previous_due_date)='".date('m')."'  AND DAY(cd.previous_due_date) < '".date('d')."'))";
                    $this->db->where($wheres);
                    $this->db->where('icd.follow_status!=',5); 
        }
        
                if($requestParams['type']=='all'){
                    $this->db->where("icd.assign_to>=0");
                }elseif($requestParams['type']=='assigned'){
                   $this->db->where("icd.assign_to > 0"); 
                }elseif($requestParams['type']=='notassigned'){
                    $this->db->where("icd.assign_to=0");
                }
         
        $this->db->where('lc.mobile>','0');
        $this->db->where('icd.renew_flag','1');
        if($requestParams['ptype'] == "assign"){
        $this->db->order_by('DAY(cd.previous_due_date)','ASC');    
        $this->db->order_by('MONTH(cd.previous_due_date)','ASC');    
        }
        //$this->db->where('cd.current_issue_date <',$todaylastyear);
        //$this->db->where('cd.current_due_date >',$todaylast30);
        //$this->db->where('cd.current_due_date <',$todayplus45);
        $this->InsGetLeadsFilter($requestParams);
        $this->db->group_by(array('icd.id'));
        
        
        if (isset($requestParams['page']))
           {
              $this->db->offset((int) ($startLimit));
           }
           if (!empty($perPageRecord))
           {
               $this->db->limit((int) $perPageRecord);
           }
            // }
                   
          $query = $this->db->get();
       //   echo $this->db->last_query();die;
         return  $query->result_array();
    }
    public function InsGetLeadsFilter($requestParams) {
       //  echo "gggg"; exit;
        $todaylast30 = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 30));
        $todayplus45 = date('Y-m-d', strtotime(date('Y-m-d')) + (3600 * 24 * 45));
        $todaydate = date('Y-m-d', strtotime(date('Y-m-d')));
        $select=$this->db;
        if(isset($requestParams['policy_status']) && ($requestParams['policy_status']=='1')){
            //not expired
            $select->where('cd.previous_due_date >=',$todaydate);
        }elseif(isset($requestParams['policy_status']) && ($requestParams['policy_status']=='2')){
            //Already Expired
            $select->where('cd.previous_due_date <',$todaydate);
        }
        if(isset($requestParams['searchby']) && $requestParams['searchby'] != '' && $requestParams['keyword'] != ''){
            if($requestParams['searchby'] == 'name'){
            $select->where("(cd.customer_name like '%" . trim($requestParams['keyword']). "%' or cd.customer_company_name like '%" . trim($requestParams['keyword']) . "%')");    
            }else if($requestParams['searchby'] == 'mobile'){
            $select->where("lc.mobile like '%" . trim($requestParams['keyword']). "%'");    
            }
            else{
            $select->where("icd.regNo like '%" .trim($requestParams['keyword']). "%'");    
            }
        }
         if($requestParams['searchdateby'] == 'followupdate'){

                   if (isset($requestParams['startfollowdate']) && $requestParams['startfollowdate'] != '') {
                   $select->where("DATE(icd.follow_up_date) >=",$this->changeDateformat($requestParams['startfollowdate'],1));
                }
                if (isset($requestParams['endfollowdate']) && $requestParams['endfollowdate'] != '') {
                    $select->where("DATE(icd.follow_up_date) <=",$this->changeDateformat($requestParams['endfollowdate'],1));
                }   
            }else if($requestParams['searchby'] == 'duedate'){
                   if (isset($requestParams['startfollowdate']) && $requestParams['startfollowdate'] != '') {
                   $select->where("DATE(cd.previous_due_date) >=",$this->changeDateformat($requestParams['startfollowdate'],1));
                }
                if (isset($requestParams['endfollowdate']) && $requestParams['endfollowdate'] != '') {
                    $select->where("DATE(cd.previous_due_date) <=",$this->changeDateformat($requestParams['endfollowdate'],1));
                }    
            }
        
        if (isset($requestParams['odAmt']) && $requestParams['odAmt'] != '') {
            if($requestParams['odAmt']=='1'){    
            $select->where("qu.own_damage < 10000 ");
            }elseif($requestParams['odAmt']=='2'){    
            $select->where("qu.own_damage >= 10000 ");
            $select->where("qu.own_damage <= 20000 ");
            }elseif($requestParams['odAmt']=='3'){    
            $select->where("qu.own_damage > 20000 ");
            }
        }
        
        if (isset($requestParams['assign_to']) && $requestParams['assign_to'] != '') {
            
                $select->where("icd.assign_to='" . $requestParams['assign_to'] . "'");
        }
        
        if(isset($requestParams['lead_status']) && $requestParams['lead_status']!=''){
            $select->where("icd.follow_status='" . $requestParams['lead_status'] . "'");
        }
        
        
    }
    function leadTabCounts($requestParams,$dealerId) {
        $data = array();
        $todaylast30 = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 30));
        $todayplus45 = date('Y-m-d', strtotime(date('Y-m-d')) + (3600 * 24 * 45));
        $todaylastyear = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 365));
        $where3 ="";
        if($requestParams['tabtype'] == 3){
            $dt = date("Y-m-d");
            $expired_7days = date( "Y-m-d", strtotime( "$dt +7 day" ) );
            $wheres3 = "DATE(cd.previous_due_date) >=".date("Y-m-d")." AND DATE(cd.previous_due_date) <=".$expired_7days. " AND ";
        }
        $wheres1 ="(MONTH(cd.previous_due_date) > '".date('m')."' or (MONTH(cd.previous_due_date)='".date('m')."'  AND DAY(cd.previous_due_date) >= '".date('d')."'))";
        $wheres2 ="(MONTH(cd.previous_due_date) < '".date('m')."' or (MONTH(cd.previous_due_date)='".date('m')."'  AND DAY(cd.previous_due_date) < '".date('d')."'))";
        if($requestParams['ptype'] == 'listing'){
        $this->db->select("count(DISTINCT(CASE WHEN ((icd.follow_up_date != '0000-00-00 00:00:00' AND date(icd.follow_up_date) = CURDATE() and $wheres1 or (Year(cd.previous_due_date) = YEAR(CURDATE()) and ((date(icd.follow_up_date)= CURDATE()) or (icd.follow_up_date ='0000-00-00 00:00:00')))) AND icd.follow_status != 5) THEN icd.id ELSE null END)) as todayfollowup, 
            count(DISTINCT(CASE WHEN (icd.follow_up_date != '0000-00-00 00:00:00' AND date(icd.follow_up_date) < CURDATE() and $wheres1 AND icd.follow_status != 5) THEN icd.id ELSE null END)) as pastfollowdate, 
            count(DISTINCT(CASE WHEN (icd.follow_up_date != '0000-00-00 00:00:00' AND date(icd.follow_up_date) > CURDATE() and $wheres1 AND icd.follow_status != 5) THEN icd.id ELSE null END)) as futureFollowupDate,
            count(DISTINCT(CASE WHEN (YEAR(cd.previous_due_date) < YEAR(CURDATE()) and $wheres1 AND icd.follow_status != 5 AND icd.follow_up_date = '0000-00-00 00:00:00') THEN cd.id ELSE null END)) as breakIn,
            count(DISTINCT(CASE WHEN (icd.follow_status = 5) THEN icd.id ELSE null END)) as lost,

            count(DISTINCT(CASE WHEN $wheres3 icd.id THEN icd.id ELSE null END))as allcount, 

            count(DISTINCT(CASE WHEN ( $wheres2 AND icd.follow_status != 5) THEN icd.id ELSE null END)) as policyexpired ");    
        }else{
        $this->db->simple_query('SET SESSION group_concat_max_len=15000');
        $this->db->select("GROUP_CONCAT(DISTINCT(CASE WHEN (icd.assign_to>=0) THEN icd.id ELSE null END)) as tot_ids ,"
               . "GROUP_CONCAT(DISTINCT(CASE WHEN (icd.assign_to <> 0) THEN icd.id ELSE null END)) as totassigned_ids,"
               . "GROUP_CONCAT(DISTINCT(CASE WHEN (icd.assign_to=0) THEN icd.id ELSE null END)) as totnotassigned_ids,"
               . "count(DISTINCT(CASE WHEN (icd.assign_to>=0) THEN icd.id ELSE null END)) as tot ,"
               . " count(DISTINCT(CASE WHEN (icd.assign_to <> 0) THEN icd.id ELSE null END)) as totassigned,"
               . " count(DISTINCT(CASE WHEN (icd.assign_to=0) THEN icd.id ELSE null END)) as totnotassigned");
        }
        $this->db->from('crm_insurance_case_details as icd');
        $this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id','inner');
        $this->db->join('crm_customers as lc', 'lc.id=cd.crm_customer_id','inner');
        $this->db->join(CITY_LIST.' as c', 'c.city_id=cd.customer_city_id','left');
        $this->db->join('crm_prev_policy_insurer as pp', 'pp.prev_policy_insurer_slug=cd.current_insurance_company','left');
        $this->db->join('crm_insurance_customer_status AS cs', 'cs.id=icd.follow_status','left');
        $this->db->join(MODEL_VERSION.' as mv', 'mv.db_version_id=icd.variantId','left');
        $this->db->join(MAKE_MODEL.' as mm', 'mm.id=mv.model_id','left');
        $this->db->join('crm_dealers as d', 'd.id=icd.dealer_id and d.status="1"','left');
        $this->db->join('crm_user as u', 'u.id=icd.assign_to and u.status="1"','left');
        $this->db->join('crm_upload_docs_loan as doc', 'doc.customer_id=icd.customer_id','left');
        $this->db->join('crm_insurance_update_status as ust', 'ust.statusId=icd.last_updated_status','left');
//        $this->db->select("count(DISTINCT(CASE WHEN (icd.follow_up_date ='0000-00-00 00:00:00' OR date(icd.follow_up_date)= CURDATE()) THEN icd.id ELSE null END)) as todayfollowup , count(DISTINCT(CASE WHEN (icd.follow_up_date != '0000-00-00 00:00:00' AND icd.follow_up_date < CURDATE()) THEN icd.id ELSE null END)) as pastfollowdate, count(DISTINCT(CASE WHEN (icd.follow_up_date != '0000-00-00 00:00:00' AND icd.follow_up_date > CURDATE()) THEN icd.id ELSE null END)) as futureFollowupDate,count(DISTINCT(CASE WHEN (cd.previous_due_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL +1 MONTH)) THEN cd.id ELSE null END)) as breakIn,count(DISTINCT(CASE WHEN (icd.last_updated_status IN (7,8,9)) THEN icd.id ELSE null END)) as lost");
//        $this->db->from('crm_insurance_case_details as icd');
//        $this->db->join('crm_insurance_customer_details as cd', 'cd.id=icd.customer_id','inner');
//        $this->db->join('crm_customers as lc', 'lc.id=cd.crm_customer_id','inner');
        $this->db->join('crm_insurance_quotes as qu', 'qu.customer_id=icd.customer_id and qu.is_latest="1" and qu.flag="1"','left');
        //$this->db->where('icd.dealer_id' ,DEALER_ID);
        //$this->db->where('icd.dealer_id>','0');
        if(!empty($requestParams['userId']) && $requestParams['userId'] > 0 && $requestParams['userId']!='1'){
           $this->db->where('icd.assign_to',$requestParams['userId']); 
        }
        $this->db->where('lc.mobile>','0');
        $this->db->where('icd.renew_flag','1');
        //$this->db->where('cd.current_issue_date <',$todaylastyear);
        //$this->db->where('cd.current_due_date >',$todaylast30);
        //$this->db->where('cd.current_due_date <',$todayplus45);
        $this->InsGetLeadsFilter($requestParams);
        $this->db->order_by('icd.last_updated_date','DESC');
        $query = $this->db->get();
        $data =  current($query->result_array());
       // echo $str = $this->db->last_query();die;
        return $data;
    }

    public function getRenewFollowStatus($notIn=[]) {
        $this->db->select('us.*');
        $this->db->from('crm_insurance_renew_follow_status as us');
        if(!empty($notIn)){
        $this->db->where_not_in('id',$notIn);
        }
       $query = $this->db->get();
       $result = $query->result_object();
       return $result;
    }
    
    public function setAssignCases($assignTO,$caseId){
        $this->db->where('id', $caseId);
        $this->db->update('crm_insurance_case_details', $assignTO);
        //echo $str = $this->db->last_query();
        return true;
    }
    public function addUpdateHistory($data){
          $this->db->insert('crm_ins_renew_history_track', $data);
          $insertid = $this->db->insert_id();
          return $insertid;
    }
    public function updateFollowStatus($case_id,$data){
        $this->db->where('id', $case_id);
          $this->db->update('crm_insurance_case_details', $data);
          return true;
    }
    public function changeDateformat($date,$flag='') {
        if ($date != '') {
            if(empty($flag))
            $date_array = explode('/', date($date));
        else
            $date_array = explode('-', date($date));

            $date = trim($date_array[2]) . '-' . trim($date_array[1]) . '-' . trim($date_array[0]);
            // $date=date('Y-m-d',strtotime($date));  
        }
        return $date;
    }
    public function getrenewCases(){
        $this->db->select('ccs.*');
        $this->db->from('crm_central_stock as ccs');
        $this->db->join('crm_insurance_case_details as icd', 'ccs.engine_no=icd.engineNo and ccs.chassis_no=icd.chasisNo','inner');
        /*$where = "DATE_FORMAT( ccs.insurance_expire,  '%Y-%m' ) BETWEEN DATE_FORMAT( DATE_SUB( DATE( NOW( ) ) , INTERVAL 90 DAY ) ,  '%Y-%m' ) 
       AND DATE_FORMAT( DATE_ADD( DATE( NOW( ) ) , INTERVAL 30 DAY ) ,  '%Y-%m' ) AND YEAR( ccs.insurance_expire ) <= YEAR( NOW( ) ) ";
       $this->db->where($where);*/
       $this->db->where('stock_added_module','Insurance'); 
       $where=" YEAR( ccs.insurance_expire ) <= YEAR( NOW( ) ) ";
       $this->db->where($where);
       $this->db->where('processed', '0');
       $query = $this->db->get();
       //echo $this->db->last_query();die;
       $result = $query->result_array();
       return $result;
    }
    
    public function getClosereason(){
        $this->db->select('rcr.*');
        $this->db->from('crm_insurance_renew_close_reason as rcr');
        $this->db->where('status', '1');
        $query = $this->db->get();
       //echo $this->db->last_query();die;
        $result = $query->result_object();
        return $result;
    }

    public function getLastUpdateStatusById($id='')
    {
        $this->db->select('rcr.*');
        $this->db->from('crm_insurance_update_status as rcr');
        $this->db->where('statusId', $id);
        $query = $this->db->get();
       //echo $this->db->last_query();die;
        $result = $query->result_object();
        return $result;
        # code...
    }

    public function IsPaymentCompleted($customerId)
    {   
        $IsPaymentCompleted = false;
        $CompletionStatus = [];
        $CompletionStatus['PaymentStatus'] = $IsPaymentCompleted;
        $PaymentStatuses = $this->Crm_insurance_part_payment->getPaymentStatus($customerId);
        $CompletionStatus['last_updated_status'] = $PaymentStatuses['last_updated_status'];
        $CompletionStatus['follow_status'] = $PaymentStatuses['follow_status'];
        $CompletionStatus['isInhouseCase'] = $PaymentStatuses['isInhouseCase'];

        // print_r($PaymentStatuses);die;
        if(!empty($PaymentStatuses) ){
          if( ( isset($PaymentStatuses['isClearanceComplete']) && $PaymentStatuses['isClearanceComplete'] == true && $PaymentStatuses['isInsurancePaymentCompleted'] == true) ){
            $CompletionStatus['PaymentStatus'] = true;
            $CompletionStatus['follow_status'] = 6;
            $statusTobeFetched = 5;
          }
          elseif( (isset($PaymentStatuses['isClearanceComplete']) && $PaymentStatuses['isClearanceComplete'] == false  && $PaymentStatuses['isInsurancePaymentCompleted'] == false) || (empty($PaymentStatuses['isClearanceComplete']) && $PaymentStatuses['isInsurancePaymentCompleted'] == true) ){
            $CompletionStatus['PaymentStatus'] = false;
            $CompletionStatus['follow_status'] = 4;
            $statusTobeFetched = 6;
          }
          $CompletionStatus['PaymentStatusDescription'] = $this->getLastUpdateStatusById($statusTobeFetched)[0]->status;
         }
         return $CompletionStatus;
    }
}    