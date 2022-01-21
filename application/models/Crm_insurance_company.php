<?php

/**
 * model : Crm_insurance_company
 * User Class to control all dealer related operations.
  */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_insurance_company extends CI_Model {

    public function __construct() {
        
    }

    /**
     * This function is used to add new Insurance Company
     */
    public function getInsurer() {
       $this->db->select('prev_policy_insurer_slug as insurer_id,prev_policy_insurer_name as insurer_name');
       $this->db->from('crm_prev_policy_insurer');
       $query = $this->db->get();
       $result = $query->result();
       return $result;
    }
    
    public function getOccupation() {
       $this->db->select('id,occval');
       $this->db->from('crm_customer_occupation');
       $query = $this->db->get();
       $result = $query->result();
       return $result;
    }
    public function getAnnualincome() {
       $this->db->select('annkey,annval');
       $this->db->from('crm_insurance_annual_income');
       $query = $this->db->get();
       $result = $query->result();
       return $result;
    }

}

?>
