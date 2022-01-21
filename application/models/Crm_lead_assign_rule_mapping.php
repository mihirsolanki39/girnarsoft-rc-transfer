<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_lead_assign_rule_mapping extends CI_Model {

    public function __construct() {
        
    }
    private $table ='crm_lead_assign_rule_mapping';

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
    function updateRuleMappingByRuleId($data,$rule_id){
        $data['updated_date']=date('Y-m-d H:i:s');
        $this->db->where('rule_id', $rule_id);
        $this->db->update($this->table, $data);
    }
}