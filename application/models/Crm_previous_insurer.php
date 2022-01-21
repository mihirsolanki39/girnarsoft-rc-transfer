<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Crm_previous_insurer extends CI_Model {

    public function __construct()
    {
        parent::__construct();       
    }

    public function getTable()
    {
        return 'crm_prev_policy_insurer';
    }

   
    public function getInsurerList()
    {
        $this->db->select('*');
        $this->db->from('crm_prev_policy_insurer');
        $query = $this->db->where('status', '1');
        $query = $this->db->order_by('prev_policy_insurer_name','asc');
        $query = $this->db->get();
        $insurerListArray = $query->result_array();
        return $insurerListArray;
    }
    
      

}
