<?php

/**
 * model : Crm_buy_lead_history_track
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_buy_lead_history_track extends CI_Model {

     public $activity_mapping = array('status' => '1', 'comment' => '2', 'followup' => 3, 'call' => 4, 'share' => 5, 'feedback' => 6,'walkindate'=>7);
    
    public $userType= array('0'=>'dealer','1'=>'DC','2'=>'EXECUTIVE','3'=>'TELECALLER','4'=>'BM','5'=>'SFAUSER');
    private $dateTime='';
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Crm_buy_lead_dealer_mapper');
        $this->load->helpers('crm_helper');
        $this->load->helpers('range_helper');
        $this->load->helpers('history_helper');
        $this->dateTime=date('Y-m-d H:i:s');
        
    }
    
    public function unique_combination_id()
    {
        $words  = "abcdefghijlmnopqrstvwyz";
        $vocals = "aeiou";

        $text  = "";
        $vocal = rand(0, 1);
        $length= 5;
        for($i = 0; $i < $length; $i ++ )
        {
            if($vocal)
            {
                $text .= substr($vocals, mt_rand(0, 4), 1);
            }
            else
            {
                $text .= substr($words, mt_rand(0, 22), 1);
            }
            $vocal = ! $vocal;
        }
        $text = sha1(uniqid($text));
        $text = substr($text, -7, 6);
        return $text;
    }

    public function trackAllHistory($data, $source = '2') {
      // echo '<pre>';print_r($data);die;
        $combinationId = $this->unique_combination_id();
        $data['source'] = $source;

        if (!empty($data['ldm_status_id'])) {
            if ($data['status_name'] != 'Walked In' && $data['status_name'] != 'Walk In') {
                $this->saveStatusHistory($data, $combinationId);
            }
        }
        /* Check Follow up Date coming or Not */
        if (!empty($data['lc_follow_date']) && $data['lc_follow_date'] != '') {
            $this->saveFollowUpHistory($data, $combinationId);
        }
        /* Check Walkin Date Date coming or Not */
        if (!empty($data['ldm_walkin_date']) && $data['ldm_walkin_date'] != '') {
            $this->saveWalkInDateHistory($data, $combinationId);
        }
        /* Check Comment text coming or Not */
        if (!empty($data['lc_comment'])) {
            $this->saveCommentHistory($data, $combinationId);
        }
       
        /* Check call details coming or Not */
      if (!empty($data['call_type'])) {
            $this->saveCallHistory($data, $combinationId);
        }
        /* Check Share Details coming or Not */
        if (!empty($data['shared_by'])) {
            $this->saveShareHistory($data, $combinationId);
        }
        /* Check feedback Details coming or Not */
       if (!empty($data['feedback'])) {
            $this->saveFeedbackHistory($data, $combinationId);
        }
    }
    
    
    public function saveStatusHistory($data, $combinationId)
    {

        $existingStatus = $this->checkExistingStatus($this->activity_mapping['status'], $data['status_name'], $data['lc_lead_dealer_mapper_id'],$data['booking_amount'],$data['offer_amount']);
 
        if(!empty($existingStatus))
        { //exit;
            $insertDataArray['activity']       = $this->activity_mapping['status'];
            $insertDataArray['activity_text']  = !empty($data['status_name'])?$data['status_name']:'';
            $insertDataArray['mobile']         = !empty($data['mobile'])?$data['mobile']:'';
            $insertDataArray['dealer_id']      = !empty($data['ldm_dealer_id'])?$data['ldm_dealer_id']:'';
            $insertDataArray['combination_id'] = $combinationId;
            $insertDataArray['user_id']        = !empty($data['userid'])?$data['userid']:'';
            $insertDataArray['user_type']      = !empty($data['usertype'])?$data['usertype']:'';
            $insertDataArray['source']         = !empty($data['source'])?$data['source']:'';
            $insertDataArray['lead_mapper_id'] = !empty($data['lc_lead_dealer_mapper_id'])?$data['lc_lead_dealer_mapper_id']:'';
            if(!empty($data['datetime']))
            {
                $insertDataArray['datetime'] = !empty($data['datetime'])?$data['datetime']:'';
            }
            if(!empty($data['booking_amount']))
            {
                $insertDataArray['booking_amount'] = !empty($data['booking_amount'])?$data['booking_amount']:'';
                $insertDataArray['car_id']         = !empty($data['car_id'])?$data['car_id']:'';
            }
            if(!empty($data['sale_amount']))
            {
                $insertDataArray['sale_amount'] = !empty($data['sale_amount'])?$data['sale_amount']:'';
                $insertDataArray['car_id']      = !empty($data['car_id'])?$data['car_id']:'';
            }
            if(!empty($data['offer_amount']))
            {
                $insertDataArray['offer_amount'] = !empty($data['offer_amount'])?$data['offer_amount']:'';
                $insertDataArray['car_id']       = !empty($data['car_id'])?$data['car_id']:'';
            }
            $insertDataArray['hashentry'] = $this->rowDataUnique($data,'1');
            if(!empty($insertDataArray))
            {
                $this->db->insert('crm_buy_lead_history_track', $insertDataArray);
                return 1;
            }
             else {
                return false;
            }
        }
        
    }
    
    
    public function checkExistingStatus($activityId, $status, $leadId,$booking_amount='',$offer_amount='')
        {
        
             if($activityId=='3'){
                    $status= date('Y-m-d', strtotime($status));
                    $this->db->select('*');
                    $this->db->from('crm_buy_lead_history_track as blcd');
                    $this->db->where('lead_mapper_id', $leadId);
                    $this->db->where('activity', $activityId);
                    $this->db->where("date(activity_text)", $status);
                    $query = $this->db->get();
                    $currentStatus = $query->row_array();
                   // echo "<pre>";print_r($currentStatus);
                    // echo $activityId;exit;
                
                }else if($activityId=='7'){
                    $status= date('Y-m-d', strtotime($status));
                    $this->db->select('*');
                    $this->db->from('crm_buy_lead_history_track as blcd');
                    $this->db->where('lead_mapper_id', $leadId);
                    $this->db->where('activity', $activityId);
                    $this->db->where("date(activity_text)", $status);
                    $query = $this->db->get();
                    $currentStatus = $query->row_array();
                    
                }else{
                    $this->db->select('*');
                    $this->db->from('crm_buy_lead_history_track as blcd');
                    $this->db->where('lead_mapper_id', $leadId);
                    $this->db->where('activity', $activityId);
                    $this->db->order_by('id', "desc");
                    $this->db->limit('1');
                    $query = $this->db->get();
                    $currentStatus = $query->row_array();
                    //echo "<pre>";print_r($currentStatus);
            if($currentStatus) {
                $id                 = $currentStatus['id'];
                $old_booking_amount = $currentStatus['booking_amount'];
                $old_offer_amount   = $currentStatus['offer_amount'];
                $activity_text      = $currentStatus['activity_text'];
                if (strtolower($status) == strtolower($activity_text)) {
                    if ($booking_amount && ($old_booking_amount != $booking_amount)) {
                        $currentStatus = false;
                    } else if ($offer_amount && ($old_offer_amount != $offer_amount)) {
                        $currentStatus = false;
                    } else {
                        return true;
                    }
                } else {
                    $currentStatus = false;
                }
            }
        }
        //echo "<pre>";print_r($currentStatus);
            if($currentStatus) {
                return true;
            } else {
                return false;
            }
    }
    
    
    public function saveFollowUpHistory($data, $combinationId)
    {
       
        $existingStatus = $this->checkExistingStatus($this->activity_mapping['followup'], $data['ldm_follow_date'], $data['lc_lead_dealer_mapper_id']);
        if(!$existingStatus)
        {
          
            $insertDataArray['activity']       = $this->activity_mapping['followup'];
            $insertDataArray['activity_text']  = !empty($data['lc_follow_date'])?$data['lc_follow_date']:'';
            $insertDataArray['mobile']         = !empty($data['mobile'])?$data['mobile']:'';
            $insertDataArray['dealer_id']      = !empty($data['ldm_dealer_id'])?$data['ldm_dealer_id']:'';
            $insertDataArray['combination_id'] = $combinationId;
            $insertDataArray['user_id']        = !empty($data['userid'])?$data['userid']:'';
            $insertDataArray['user_type']      = !empty($data['usertype'])?$data['usertype']:'';
            $insertDataArray['source']         = !empty($data['source'])?$data['source']:'';
            $insertDataArray['lead_mapper_id'] = !empty($data['lc_lead_dealer_mapper_id'])?$data['lc_lead_dealer_mapper_id']:'';
            if(!empty($data['datetime']))
            {
                $insertDataArray['datetime'] = !empty($data['datetime'])?$data['datetime']:'';
            }
            $insertDataArray['hashentry'] = $this->rowDataUnique($data,'3');
            if($insertDataArray)
            {
                $this->db->insert('crm_buy_lead_history_track', $insertDataArray);
                return 1;
            }
            else {
                return false;
            }
        }
    }
    
     public function saveWalkInDateHistory($data, $combinationId)
    {
         
       // echo "<pre>".$this->activity_mapping['walkindate']; print_r($data);
        $existingStatus = $this->checkExistingStatus($this->activity_mapping['walkindate'], $data['ldm_walkin_date'], $data['lc_lead_dealer_mapper_id']);
        if(!$existingStatus)
        {
             //exit;
            $insertDataArray['activity']       = $this->activity_mapping['walkindate'];
            $insertDataArray['activity_text']  = !empty($data['ldm_walkin_date'])?$data['ldm_walkin_date']:'';
            $insertDataArray['mobile']         = !empty($data['mobile'])?$data['mobile']:'';
            $insertDataArray['dealer_id']      = !empty($data['ldm_dealer_id'])?$data['ldm_dealer_id']:'';
            $insertDataArray['combination_id'] = $combinationId;
            $insertDataArray['user_id']        = !empty($data['userid'])?$data['userid']:'';
            $insertDataArray['user_type']      = !empty($data['usertype'])?$data['usertype']:'';
            $insertDataArray['source']         = !empty($data['source'])?$data['source']:'';
            $insertDataArray['lead_mapper_id'] = !empty($data['lc_lead_dealer_mapper_id'])?$data['lc_lead_dealer_mapper_id']:'';
            if(isset($data['datetime']) && $data['datetime'])
            {
                $insertDataArray['datetime'] = !empty($data['datetime'])?$data['datetime']:'';
            }
            $insertDataArray['hashentry'] = $this->rowDataUnique($data,'7');
            if($insertDataArray)
            {
                $this->db->insert('crm_buy_lead_history_track', $insertDataArray);
                return 1;
            }
            else {
                return false;
            }
        }
    }
    
     public function saveCommentHistory($data, $combinationId='')
    {
        $insertDataArray['activity']       = $this->activity_mapping['comment'];
        $insertDataArray['activity_text']  = !empty($data['lc_comment'])? $this->db->escape_str($data['lc_comment']):'';
        $insertDataArray['mobile']         = !empty($data['mobile'])?$data['mobile']:'';
        $insertDataArray['dealer_id']      = !empty($data['ldm_dealer_id'])?$data['ldm_dealer_id']:'';
        $insertDataArray['combination_id'] = $combinationId;
        $insertDataArray['user_id']        = !empty($data['userid'])?$data['userid']:'';
        $insertDataArray['user_type']      = !empty($data['usertype'])?$data['usertype']:'';
        if(!empty($data['comment_type']) && $data['comment_type']=='self'){
            $insertDataArray['source']         = '1';
        }else{
            $insertDataArray['source']         = !empty($data['source'])?$data['source']:'';
        }
        $insertDataArray['lead_mapper_id'] = !empty($data['lc_lead_dealer_mapper_id'])?$data['lc_lead_dealer_mapper_id']:'';
        $insertDataArray['feedback_id']    = !empty($data['feedback_id'])?$data['feedback_id']:'';
        if(!empty($data['datetime']))
           {
               $insertDataArray['datetime'] = !empty($data['datetime'])?$data['datetime']:'';
           }
        $insertDataArray['hashentry'] = $this->rowDataUnique($data,'2');   
        if($insertDataArray)
        {
            $this->db->insert('crm_buy_lead_history_track', $insertDataArray);
            return 1;
        }
         else {
                return false;
            }
    }
    
    public function saveCallHistory($data, $combinationId)
    {
        $insertDataArray['activity']       = $this->activity_mapping['call'];
        $insertDataArray['activity_text']  = !empty($data['call_type'])?$data['call_type']:'';
        $insertDataArray['mobile']         = !empty($data['mobile'])?$data['mobile']:'';
        $insertDataArray['dealer_id']      = !empty($data['ldm_dealer_id'])?$data['ldm_dealer_id']:'';
        $insertDataArray['combination_id'] = $combinationId;
        $insertDataArray['user_id']        = !empty($data['userid'])?$data['userid']:'';
        $insertDataArray['user_type']      = !empty($data['usertype'])?$data['usertype']:'';
        $insertDataArray['source']         = !empty($data['source'])?$data['source']:'';
        $insertDataArray['call_duration']  = !empty($data['call_duration'])?$data['call_duration']:'';
        $insertDataArray['call_type']      = !empty($data['call_type'])?$data['call_type']:'';
        $insertDataArray['lead_mapper_id'] = !empty($data['lc_lead_dealer_mapper_id'])?$data['lc_lead_dealer_mapper_id']:'';
        $insertDataArray['hashentry'] = $this->rowDataUnique($data,'4');
        if($insertDataArray)
        {
             $this->db->insert('crm_buy_lead_history_track', $insertDataArray);
        }
    }
    
    public function saveShareHistory($data, $combinationId)
    {
        $insertDataArray['activity']       = $this->activity_mapping['share'];
        $insertDataArray['activity_text']  = !empty($data['shared_by'])?$data['shared_by']:'';
        $insertDataArray['mobile']         = !empty($data['mobile'])?$data['mobile']:'';
        $insertDataArray['dealer_id']      = !empty($data['ldm_dealer_id'])?$data['ldm_dealer_id']:'';
        $insertDataArray['combination_id'] = $combinationId;
        $insertDataArray['user_id']        = !empty($data['userid'])?$data['userid']:'';
        $insertDataArray['user_type']      = !empty($data['usertype'])?$data['usertype']:'';
        $insertDataArray['source']         = !empty($data['source'])?$data['source']:'';
        $insertDataArray['shared_item']    = !empty($data['shared_item'])?$data['shared_item']:'';
        $insertDataArray['shared_by']      = !empty($data['shared_by'])?$data['shared_by']:'';
        $insertDataArray['car_id']         = !empty($data['car_id'])?$data['car_id']:'';
        $insertDataArray['lead_mapper_id'] = !empty($data['lc_lead_dealer_mapper_id'])?$data['lc_lead_dealer_mapper_id']:'';
        $insertDataArray['hashentry'] = $this->rowDataUnique($data,'5');
        if($insertDataArray)
        {
            $this->db->insert('crm_buy_lead_history_track', $insertDataArray);
        }
    }
    
    public function saveFeedbackHistory($data, $combinationId)
    {
        $insertDataArray['activity']       = $this->activity_mapping['feedback'];
        $insertDataArray['activity_text']  = !empty($data['feedback'])?$data['feedback']:'';
        $insertDataArray['mobile']         = !empty($data['mobile'])?$data['mobile']:'';
        $insertDataArray['dealer_id']      = !empty($data['ldm_dealer_id'])?$data['ldm_dealer_id']:'';
        $insertDataArray['combination_id'] = $combinationId;
        $insertDataArray['user_id']        = !empty($data['userid'])?$data['userid']:'';
        $insertDataArray['user_type']      = !empty($data['usertype'])?$data['usertype']:'';
        $insertDataArray['source']         = !empty($data['source'])?$data['source']:'';
        $insertDataArray['lead_mapper_id'] = !empty($data['lc_lead_dealer_mapper_id'])?$data['lc_lead_dealer_mapper_id']:'';
        $insertDataArray['feedback_id']    = !empty($data['feedback_id'])?$data['feedback_id']:'';
        $insertDataArray['hashentry'] = $this->rowDataUnique($data,'6');
        if($insertDataArray)
        {
            $this->db->insert('crm_buy_lead_history_track', $insertDataArray);
        }
    }
    
    public function rowDataUnique($data,$types)
        {
            $insertDataArray=array();
            if(!empty($data['ldm_status_id']) && $types=='1')
            {
                 $insertDataArray['activity']       = $this->activity_mapping['status'];
                 $insertDataArray['activity_text']  = !empty($data['status_name'])?$data['status_name']:'';
                 $insertDataArray['car_id']         = !empty($data['car_id'])?$data['car_id']:'';
                 $insertDataArray['booking_amount'] = !empty($data['booking_amount'])?$data['booking_amount']:'';
                 $insertDataArray['sale_amount']    = !empty($data['sale_amount'])?$data['sale_amount']:'';
                 $insertDataArray['offer_amount']   = !empty($data['offer_amount'])?$data['offer_amount']:'';
            }else if(!empty($data['lc_follow_date'])  && $data['lc_follow_date']!='' && $types=='3')
            {
                $insertDataArray['activity']       = $this->activity_mapping['followup'];
                $insertDataArray['activity_text']  = !empty($data['lc_follow_date'])?$data['lc_follow_date']:'';
                
            }
            else if(!empty($data['ldm_walkin_date'])  && $data['ldm_walkin_date']!='' && $types=='7')
            {
                $insertDataArray['activity']       = $this->activity_mapping['walkindate'];
                $insertDataArray['activity_text']  = !empty($data['ldm_walkin_date'])?$data['ldm_walkin_date']:'';
            }else if(!empty($data['lc_comment']) && $types=='2')
            {
                $insertDataArray['activity']       = $this->activity_mapping['comment'];
                $insertDataArray['activity_text']  = !empty($data['lc_comment'])?$this->db->escape_str($data['lc_comment']):'';
            }else if(!empty($data['call_type']) && $types=='4')
            {
                $insertDataArray['activity']       = $this->activity_mapping['call'];
                $insertDataArray['activity_text']  = !empty($data['call_type'])?$data['call_type']:'';
                $insertDataArray['call_duration']  = !empty($data['call_duration'])?$data['call_duration']:'';
                $insertDataArray['call_type']      = !empty($data['call_type'])?$data['call_type']:'';
            }else if(!empty($data['shared_by']) && $types=='5')
            {
                 $insertDataArray['activity']       = $this->activity_mapping['share'];
                 $insertDataArray['activity_text']  = !empty($data['shared_by'])?$data['shared_by']:'';
                 $insertDataArray['shared_item']    = !empty($data['shared_item'])?$data['shared_item']:'';
                 $insertDataArray['shared_by']      = !empty($data['shared_by'])?$data['shared_by']:'';
            }elseif(!empty($data['feedback']) && $types=='6')
            {
                $insertDataArray['activity']       = $this->activity_mapping['feedback'];
                $insertDataArray['activity_text']  = !empty($data['feedback'])?$data['feedback']:'';
            }
            
            $insertDataArray['lead_mapper_id'] = !empty($data['lc_lead_dealer_mapper_id'])?$data['lc_lead_dealer_mapper_id']:'';
            $insertDataArray['user_id']        = !empty($data['userid'])?$data['userid']:'';
            $insertDataArray['user_type']      = !empty($data['usertype'])?$data['usertype']:'';
            $insertDataArray['source']         = !empty($data['source'])?$data['source']:'';
            $insertDataArray['mobile']         = !empty($data['mobile'])?$data['mobile']:'';
            $insertDataArray['dealer_id']      = !empty($data['ldm_dealer_id'])?$data['ldm_dealer_id']:'';
            $insertDataArray['datetime']       = date('Y-m-d H'); 
            $jsonData=  json_encode($insertDataArray);
            $textunique = md5($jsonData);
            return $textunique;
            
        }
        
        
        
        public function getActivityData($data)
                {
                    $data = (array) $data;
                    $response=[];
                    if($data['activity'] == $this->activity_mapping['call'])
                    {
                        $response['type']     = ($data['call_type']) ? $data['call_type'] : '';
                        $response['duration'] = formatTotalTalkTime($data['call_duration']);
                    }
                    else if($data['activity'] == $this->activity_mapping['share'])
                    {
                        $response['shared_item'] = $data['shared_item'];
                        $response['shared_by']   = $data['shared_by'];
                    }
                    else if($data['activity'] == $this->activity_mapping['feedback'])
                    {
                        return $data['activity_text'];
                    }
                    else if($data['activity'] == $this->activity_mapping['followup'])
                    {
                        $response['followup_date'] = $data['activity_text'];
                    }
                    else if($data['activity'] == $this->activity_mapping['comment'])
                    {
                        $response['comment_text'] = $data['activity_text'];
                    }
                    else if($data['activity'] == $this->activity_mapping['status'])
                    {
                        $response['status_text'] = $data['activity_text'];
                        if($data['activity_text'] == 'Customer Offer')
                        {
                            $response['offer_amount'] = $data['offer_amount'];
                        }
                        else if($data['activity_text'] == 'Booked')
                        {
                            $response['booking_amount'] = $data['booking_amount'];
                        }
                        else if($data['activity_text'] == 'Converted')
                        {
                            $response['sale_amount'] = $data['sale_amount'];
                        }
                    }
                    return $response;
                }
        
           public function getLeadHistoryTrack($leadId,$userType='', $total = '', $historyType=false)
            {
                $select=$this->db;
                $returnArray  = array();
                $limit        = ($total) ? " $total " : '';
                $source='';
                
                $select->select('*');
                  $select->from('crm_buy_lead_history_track as hlt');
                  $select->where("hlt.lead_mapper_id=",$leadId);
                if($historyType){
                    if($userType=='dealer' || strtolower($userType)=='telecaller'){
                        $select->where(" ((hlt.activity IN (1,2,6) AND hlt.source !=3) OR (hlt.activity IN (1,6) AND hlt.source =3))");
                    }else {
                        $select->where_in('hlt.activity', ['1','2','6']);
                    }
                }else {
                    if($userType=='dealer' || strtolower($userType)=='telecaller'){
                            $select->where(" ((hlt.activity !='".$this->activity_mapping['followup']."' AND hlt.source !=3) OR (hlt.activity IN (1,6) AND hlt.source =3))");
                    }else{
                            $select->where("hlt.activity !='".$this->activity_mapping['followup']."'");
                    }
                } 
                if($total=='2'){
                    $select->where_not_in('hlt.activity', ['4','5','6']);
                }
                $select->group_by('hlt.combination_id');
                $select->order_by('hlt.datetime',' DESC');
                $select->order_by('hlt.id','DESC');
                if($limit>0){
                $select->limit((int) $limit);
                }
                $query = $select->get();
                 $historyData=  $query->result_array();
                if($historyData)
                {
                    $response = [];
                    $j        = 0;
                    foreach($historyData as $key => $value)
                    {
                        $response[$j]['datetime'] = $value['datetime'];
                        $combinationId='';
                        $leadMapperId='';
                        $combinationId=$value['combination_id'];
                        $leadMapperId=$value['lead_mapper_id'];
                        $historyOtherData = 
                          $select->select('*');
                          $select->from('crm_buy_lead_history_track as hlt');
                          $select->where("hlt.combination_id='" . $combinationId . "'  AND  hlt.activity !='".$this->activity_mapping['followup']."' AND hlt.lead_mapper_id='" . $leadMapperId . "'");
                          $select->order_by('datetime',' DESC');
                         $query=$select->get();
                 $historyOtherData=  $query->result_array();
                        $i = 1;
                        if($historyOtherData)
                        {
                            if(count($historyOtherData)==1 && $historyOtherData[0]['activity']==$this->activity_mapping['comment'] && strtolower($userType)=='dealer' && $historyOtherData[0]['source']==3){
                                unset($response[$j]);
                                $j--;
                            }
                            foreach($historyOtherData as $k => $value)
                            {
                                $keyvalue = array_search($value['activity'], $this->activity_mapping); // $key = 2;
                                $keyvalue=($keyvalue=='status')?'status_change':$keyvalue;
                                if($keyvalue=='comment' && $value['source']==3){
                                     $value['activity_text'] ='Agent: '. $value['activity_text'] ;
                                }
                                // this condition for not to display ub comment to dealer 
                                if($keyvalue=='comment' && $value['source']==3  && (strtolower($userType)=='dealer' || strtolower($userType)=='telecaller')){

                                }else {
                                $response[$j][$keyvalue] = $this->getActivityData($value);
                                }
                                $i ++;
                            }
                        }
                      $j++;
                    }
                }
                else
                {
                    return [];
                }
                return $response;
            }
        public function getbuyerlistreport($dealerId,$time,$type){
            //echo $type;die;
        $select=$this->db;    
        $activityId = $this->activity_mapping['status'];
        $where='';
        $lastmonthDate = date('Y-m-01');  
        if($type=='Walk-in Done'){
            $where =" DATE_FORMAT(ht.datetime,'%Y-%m-%d') >= '$lastmonthDate' AND (activity=1 AND activity_text in ('Walk-in Done'))";
            }elseif($type=='Converted'){
            $startDate=date('Y-m-01');    
            $where=" DATE_FORMAT(datetime,'%Y-%m-%d') >= '".$startDate."' AND (activity=1 AND activity_text in ('Converted'))";    
            }elseif($type=='New'){
                $where =" DATE_FORMAT(ht.datetime,'%Y-%m-%d') >= '$lastmonthDate' AND (activity=1 AND ht.activity_text in ('$type'))";
            }
            $select->select('ldm.*,ht.datetime as httime,lcp.*,lc.is_finance,lc.lead_score,lc.mobile,lc.opt_verified,lc.gaadi_verified as gaadi_common,cs.status_name,d.organization');
            $select->from('crm_buy_lead_history_track as ht');
            $select->join('crm_buy_lead_dealer_mapper AS ldm', 'ldm.ldm_id=ht.lead_mapper_id','left');
            $select->join('crm_buy_lead_customer AS lc', 'lc.id=ldm.ldm_customer_id','left');
            $select->join('crm_buy_lead_customer_preferences AS lcp', "lcp.lcp_lead_dealer_mapper_id = ldm.ldm_id AND lcp.lcp_is_latest='1' AND lcp.lcp_active='1'",'left');
            $select->join('crm_buy_customer_status AS cs', 'cs.id=ldm.ldm_status_id','left');
            //$select->join('crm_ublms_locations loc', 'ldm.ldm_location_id = loc.location_id','left');
            $select->join('crm_dealers AS d', 'd.id=ldm.ldm_dealer_id','left');
            $select->where(" ht.activity='$activityId' AND ldm.ldm_id is not null AND ht.dealer_id='$dealerId' ");
            if($this->session->userdata['userinfo']['is_admin']!=1){
             $this->db->where('ldm.added_by',$this->session->userdata['userinfo']['id']);
            }
            $select->where( $where );
            $select->group_by(array('ldm.ldm_id'));
            $select->order_by('ldm_update_date DESC');
            $query = $select->get();
            //echo $select->last_query();exit;
            $response =  $query->result_object();
                  //print_r($response);
                 
        $leads = array();
         if (!empty($response)) {
            $i = 0;
            foreach ($response as $key => $val) {
                $leads[$i]['dealerID'] = $dealerId;
                //$leads[$i]['ucdid'] = $val->ldm_dealer_id;
                $leads[$i]['leadID'] = $val->ldm_id;
                $leads[$i]['dealership_name']=$val->organization;
                //$leads[$i]['localityname'] = $val->localityname;
                $leads[$i]['location'] = $val->ldm_location_id;
                $leads[$i]['is_finance'] = $val->is_finance;
                $leads[$i]['emailID'] = $val->ldm_email;
                $leads[$i]['alt_number'] = preg_replace("/[^0-9]/", "",$val->ldm_alt_mobile);
                $leads[$i]['changetime'] = $val->ldm_update_date;
                $leads[$i]['httime'] = $val->httime;
                $name=ucwords(strtolower(preg_replace("/[^a-zA-Z\s]/", "", $val->ldm_name)));
                $leads[$i]['name'] = (stripos($name, "null")==true?'':$name);
               //$leads[$i]['name'] = ucwords(strtolower(preg_replace("/[^a-zA-Z\s]/", "", $val->ldm_name)));
                $leads[$i]['number'] = preg_replace("/[^0-9]/", "", $val->mobile);
                $leads[$i]['assign_lead'] = intval($val->ldm_total_assign_lead);
               // $leads[$i]['verified'] = (($val->gaadi_verified=='1' || $val->gaadi_common=='1')?true:false);
                $leads[$i]['verified'] = (($val->gaadi_verified=='1')?true:false);
                $leads[$i]['otp_verified'] = (($val->opt_verified=='1')?true:false);
                if(strtolower($val->ldm_source)=='cardekho knowlarity' || strtolower($val->ldm_source)=='cardekho_knowlarity'){
                   $val->ldm_source='Call Tracker'; 
                }elseif(strtolower($val->ldm_source)=='gaadi' || strtolower($val->ldm_source)=='' || strtolower($val->ldm_source)=='self' || strtolower($val->ldm_source=='UB'))
                    {
                    $val->ldm_source='Gaadi';
                    
                    }
                $leads[$i]['source'] = ($val->ldm_source=='UB'?'Gaadi':ucfirst(strtolower($val->ldm_source)));
                $leads[$i]['lead_status'] = $val->status_name;
                $statusid = $val->ldm_status_id;                
                $getamount = '';
                $leads[$i]['leadCreatedDate'] = $val->ldm_created_date;
                if ($statusid == '1') {//New
                    $leads[$i]['createdDate'] = $val->ldm_created_date;
                } else {
                    $leads[$i]['updatedDate'] = $val->ldm_update_date;
                    if ($statusid != '4') {//Walk-in
                        $leads[$i]['followDate'] = ($val->ldm_follow_date != '0000-00-00 00:00:00' ? $val->ldm_follow_date : '');
                    }
                }
                if ($statusid == '11') {//Booked
                    $leads[$i]['bookingAmount'] = (intval($val->ldm_amount)==0?'':money_format('%!.0n',intval($val->ldm_amount)));
                }
                if ($statusid == '10') {//Customer Offer
                    
                    $leads[$i]['offerAmount'] = (intval($val->ldm_amount)==0?'':money_format('%!.0n',intval($val->ldm_amount)));
                    $leads[$i]['car_id'] = intval($val->ldm_car_id);
                }

                if ($statusid == '9' || $statusid == '4') {//Walked-in
                    $leads[$i]['walkinDate'] = ($val->ldm_walkin_date != '0000-00-00 00:00:00' ? $val->ldm_walkin_date : '');
                }
                $hotlead_crecteriaText='';
                /*if($val->htcrt=='1' && ($val->lead_score>6 || strtolower($val->ldm_source)=='website' || $val->ldm_source=='CarDekho Knowlarity')){
                 $hotlead_crecteriaText='Hot';   
                }*/
                $leads[$i]['rating'] = ($val->ldm_lead_rating!=''?$val->ldm_lead_rating:$hotlead_crecteriaText);
// }
                if ($statusid == '4') {//Walk-in
                    $leads[$i]['reminderDate'] = ($val->ldm_follow_date != '0000-00-00 00:00:00' ? $val->ldm_follow_date : '');
                    
                }
                if ($statusid == '12') {
                    
                    $leads[$i]['saleAmount'] = (intval($val->ldm_amount)==0?'':money_format('%!.0n',intval($val->ldm_amount)));
                    $leads[$i]['saleAmountFormat'] = (intval($val->ldm_amount)==0?'':formatInIndianStyle($val->ldm_amount));
                }
                
                $car_id=($val->ldm_status_id==12)?$val->ldm_car_id:'';
                $resultcar_list = $this->leadwiseCarListgetLeads($val->ldm_id,$car_id,1);
                //print_r($resultcar_list);echo $resultcar_list[0]->makeID;die;
                $leads[$i]['makeID'] = intval((!empty($resultcar_list[0]->makeID)) ? $resultcar_list[0]->makeID:'');
                $leads[$i]['make'] = !empty($resultcar_list[0]->make) ? $resultcar_list[0]->make : '';
                $leads[$i]['model'] = !empty($resultcar_list[0]->model) ? $resultcar_list[0]->model : '';
                $leads[$i]['version'] = !empty($resultcar_list[0]->version) ? $resultcar_list[0]->version : '';
                $leads[$i]['regno'] = !empty($resultcar_list[0]->regno) ? $resultcar_list[0]->regno :'';
                $i++;
            }
         }
         return $leads;
        }
        
        function leadwiseCarListgetLeads($leadid,$car_id=false,$limit=false)
        {
                $select=$this->db;
             //$createUsedcarArray = $this->createUsedcarArray();
	$limitData='';
             if($limit){
                 $limitData= " Limit $limit";
             }
             $whereCarId='';
             if($car_id){
                  $whereCarId= " AND  lcd.lcd_car_id = $car_id";
             }
            $select->select("lcd.lcd_car_id,uc.insurance_exp_month,uc.insurance_exp_year,uc.insurance_type AS insurance,uc.reg_month AS month, uc.reg_year year,uc.make_month AS mmonth,uc.make_year AS myear, uc.colour AS colour, uc.km_driven AS km, uc.car_price AS pricefrom,uc.reg_no AS regno,uc.owner_type AS owner,uc.version_id,lcd.lcd_car_id  AS car_id,mv.mk_id AS makeID,mv.db_version AS version,cl.city_id,cl.city_name,
mv.uc_body_type AS body_type,mv.uc_transmission AS transmission,mv.uc_fuel_type AS fuel_type,mm.make,CASE WHEN mm.parent_model_id>0 THEN (select model from make_model where  id = mm.parent_model_id limit 1) ELSE mm.model END AS model,lcd.lcd_favourite,
lcd.offer_amount,lcd.booking_amount,lcd.lcd_source,lcd.lcd_sub_source,uc.certification_status,uc.car_status as active ");
            $select->from(" crm_buy_lead_car_detail AS lcd ");
            $select->join(" crm_used_car AS uc " ,'uc.id=lcd.lcd_car_id','left');
            $select->join(" model_version AS mv ",'mv.db_version_id=uc.version_id ' ,'left');
            $select->join(" make_model AS mm ",'mm.id=mv.model_id ','left');
            $select->join(" city_list cl", 'uc.city_id=cl.city_id ','left'); 
            $select->where(" lcd.lcd_lead_dealer_mapper_id='" . $leadid . "' AND  lcd_active='1'  and uc.car_status!='9' AND lcd.lcd_favourite='1' AND lcd.lcd_car_id>0 ");    
            $select->order_by(" lcd.lcd_id DESC "); 
            $query = $select->get();
            $resultcar_list =  $query->result_object();             
            return $resultcar_list;
        }
}

