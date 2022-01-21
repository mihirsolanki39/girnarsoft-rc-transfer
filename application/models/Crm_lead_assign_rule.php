<?php

/**
 * model : Crm_outlets
 * User Class to control all dealer related operations.
 * @author : Anirudh aima
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_lead_assign_rule extends CI_Model {

    public function __construct() {
        
    }
    private $table ='crm_lead_assign_rule';

    function save($data,$id='') {
        if (empty($id)) {
            $data['created_date']=date('Y-m-d H:i:s');
            $data['updated_date']=date('Y-m-d H:i:s');
            $this->db->insert($this->table, $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            $data['updated_date']=date('Y-m-d H:i:s');
            $this->db->where('id', $id);
            $this->db->update($this->table, $data);
            return $id;
        }
    }
    public function getLeadRule()
    {
        $this->db->select('*');
        $this->db->from($this->table . ' as r');
        $this->db->where('r.dealer_id', DEALER_ID);
        $this->db->where('r.status', '1');
        $query  = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
    public function getLeadRuleData()
    {
        $this->db->select('r.rule_type,rm.user_id,rm.id mapping_id,rm.rule_valid_from,rm.rule_valid_to');
        $this->db->from($this->table . ' as r');
        $this->db->join('crm_lead_assign_rule_mapping  as rm', 'r.id=rm.rule_id', 'left');
        $this->db->where('r.dealer_id', DEALER_ID);
        $this->db->where('r.status', '1');
        $this->db->where('rm.status', '1');
        $query  = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    public function getPriceSegment()
    {
        $this->db->select('*');
        $this->db->from('crm_car_price_segment');
        $this->db->where('dealer_id', DEALER_ID);
        $query  = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    public function getUserRuleMapping($value){
        
        $query="SELECT user_id FROM crm_lead_assign_rule_mapping 
        where rule_valid_from <=$value and rule_valid_to >=$value and status='1'";
        $result = $this->db->query($query)->row_array();
        return $result;
    }
    
}

?>
