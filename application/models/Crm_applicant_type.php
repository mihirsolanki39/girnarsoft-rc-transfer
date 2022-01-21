<?php

/**
 * model : Crm_applicant_type
 * User Class to control all dealer related operations.
  */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_applicant_type extends CI_Model {

    public function __construct() {
        
    }

    function ApplicantTypeListing($type='') {
        $this->db->select('b.*');
        $this->db->from('crm_finance_employment_cat_details as b');
        if($type<>''){
        $this->db->where('b.type', $type);
        }
        $query = $this->db->get();
        
        $result = $query->result();
        //echo $this->db->last_query();die;
        return $result;
    }
    
    function IndustryTypeListing($type='') {
        $this->db->select('b.*');
        $this->db->from('crm_finance_industry_cat_details as b');
        if($type<>''){
        $this->db->where('b.industry_cat', $type);
        }
        $query = $this->db->get();
        $result = $query->result();
        //echo $this->db->last_query();die;
        return $result;
    }
}