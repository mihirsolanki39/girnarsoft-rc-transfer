<?php

/**
 * model : Crm_outlets
 * User Class to control all dealer related operations.
 */
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Crm_insurance_customer_status extends CI_Model {

    public function __construct() {
        
    }

    public function getCustomerStatus($notIn=[]) {
        $this->db->select('crm_insurance_customer_status.*');
        $this->db->from('crm_insurance_customer_status');
        $this->db->where('parent','0');
        $this->db->where('active','yes');
        if(!empty($notIn)){
        $this->db->where_not_in('id',$notIn);
        }
       $query = $this->db->get();
       $result = $query->result_object();
       return $result;
    }
}