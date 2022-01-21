<?php
/** 
 * model : Crm_renew_history_track
 * User Class to control all insurance renew related operations.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_renew_history_track extends CI_Model {

    public $activity_mapping = array('New' => '1', 'Follow Up' => '2', 'Quotes shared' => '3','Payment Pending' => '4','Closed' => '5','Policy Pending'=>'6');
    public $zone_A_arr = array('8','125','129','227','336','344','471','660');
    
    public function __construct() {
        parent::__construct();
        $this->dateTime=date('Y-m-d H:i:s');
    }
public function getRenewHistoryTrack($leadId,$userType='', $total = '', $historyType=false)
            {
                $select=$this->db;
                $returnArray  = array();
                $limit        = ($total) ? " $total " : '';
                $source='';
                
                $select->select('hlt.*,fs.*');
                  $select->from('crm_ins_renew_history_track as hlt');
                  $this->db->join('crm_insurance_renew_follow_status as fs', 'fs.statusid=hlt.activity','inner');
                  $select->where("hlt.case_id=",$leadId);
                if($total=='2'){
                    $select->where_not_in('hlt.activity', ['4','5','6']);
                }
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
                       $response[$j]['activity']=$value['activity'];
                       $response[$j]['status']=$value['status'];
                       $response[$j]['activity_text']=$value['activity_text'];
                       $response[$j]['datetime']=$value['datetime'];
                      $j++;
                    }
                }
                else
                {
                    return [];
                }
                return $response;
            }
    public function getActivityData($data)
                {
                    $data = (array) $data;
                    $response=[];
                    if($data['activity'] == $this->activity_mapping['share'])
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
                    }
                    return $response;
                }        
}
