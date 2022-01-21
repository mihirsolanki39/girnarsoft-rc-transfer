<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Showroom extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getList($dealer_id)
    {
        $this->load->database();
        $query = $this->db->get_where(CRM_OUTLET, array('dealer_id' => $dealer_id,'status'=>'1'));
        $showroomArray = $query->result_array();
        return $showroomArray;
    }

  
}
