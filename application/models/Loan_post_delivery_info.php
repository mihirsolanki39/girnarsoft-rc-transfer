<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * model : Loan_post_case
 * User Class to control all dealer related operations.
 */
class Loan_post_delivery_info extends CI_Model {

    public function addEditPostDeliveryData($postInfo, $updateId = '') {
        if (empty($updateId)) {
            $this->db->trans_start();
            $this->db->insert('loan_post_delivery_details', $postInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
        } else {
            $this->db->where('case_id', $updateId);
            $this->db->update('loan_post_delivery_details', $postInfo);
            return $updateId;
        }
        return $result;
    }
    
    public function getCaseIdFromPost($case_id){
       $this->db->select('*');
       $this->db->from('loan_post_delivery_details');
       $this->db->where('case_id', $case_id);
       $this->db->where('status', '1');
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     

    }
    
    public function getPostDetails($case_id){
       $this->db->select('*');
       $this->db->from('loan_post_delivery_details');
       $this->db->where('case_id', $case_id);
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     

    }

}
