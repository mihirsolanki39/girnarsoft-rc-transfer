<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * model : Loan_customer_case
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
class Loan_customer_reference_info extends CI_Model {

    public function addEditRefrenceData($caseInfo, $updateId = '') {
        if (empty($updateId)) {
            $this->db->trans_start();
            $this->db->insert('loan_customer_reference_info', $caseInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
        } else {
            $this->db->where('id', $updateId);
            $this->db->update('loan_customer_reference_info', $caseInfo);
            return $updateId;
        }
        return $result;
    }
    
    public function getRefrenceId($customer_id){
       $this->db->select('*');
       $this->db->from('loan_customer_reference_info');
       $this->db->where('customer_case_id', $customer_id);
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     

    }
    
    public function getRefrenceDetails($customer_id){
       $this->db->select('*');
       $this->db->from('loan_customer_reference_info');
       $this->db->where('customer_case_id', $customer_id);
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     

    }

}
