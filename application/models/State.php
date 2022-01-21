<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class State extends CI_Model {

    public function __construct()
    {
        parent::__construct();       
    }

    public function getTable()
    {
        return 'state_list';
    }

   
    public function getStateList()
    {
         $this->load->database();
        /*$stateListArray = $this->fetchAll(array(
            'fields'     => array('state_list_id', 'state_list_name'),
            'conditions' => array('con_id' => '1'),
            'order'      => array('state_list_name')
        ));*/
        $query = $this->db->get_where('state_list', array('con_id' => '1'));
        $query = $this->db->order_by(array('state_list_name'=>'asc'));
        $stateListArray = $query->result_array();
        foreach ($stateListArray as $state)
        {
            $stateList[$state['state_list_id']] = $state['state_list_name'];
        }
        return $stateList;
    }
    
      public function getState($zoneid) {
         $this->load->database();
        $zonid = '';
        $zonids = '';
        if(!empty($zoneid)){
            foreach ($zoneid as $zk => $zval) {
                $zonid.="'" . $zval . "',";
            }
            $zonids = substr($zonid, 0, -1);
            $zonids = "and cs.zone_id in(" . $zonids . ")";
        }        
        
        $state = $this->db->query("select cs.state_id,cs.state_name from sfa.sfa_zone_state_city_mapping as cs  where cs.status='1' $zonids group by cs.state_id ");
        $state = $state->result_array();
        return $state;
    }
    
    public function getStateByRaId($citiid) {
         $this->load->database();
        if(!empty($citiid)){
        $stds = $this->db->query("select state_id,state_name from sfa_zone_state_city_mapping as bud  where city_id in (" .$citiid . ")  group by state_id ");
        $stds = $stds->result_array();
        }
        else {
            $stds=[];
        } 
        return $stds;
    }

}
