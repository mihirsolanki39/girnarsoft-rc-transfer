<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Crm_inspection_status extends CI_Model {

    public function __construct()
    {
        parent::__construct();       
    }

    public function getInspectionStatus()
    {
        $this->db->select('*');
        $this->db->from('crm_inspection_status');
        $query = $this->db->where('status', '1');
        $query = $this->db->order_by('inspectName','asc');
        $query = $this->db->get();
        $inspectList = $query->result_array();
        return $inspectList;
    }
    
      

}
