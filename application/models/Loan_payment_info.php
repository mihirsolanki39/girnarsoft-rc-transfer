<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * model : Loan_post_case
 * User Class to control all dealer related operations.
 */
class Loan_payment_info extends CI_Model {

    public function addEditPaymentData($paymentInfo, $updateId = '') {
     // echo $updateId; exit;
        if (empty($updateId)) {
            $this->db->trans_start();
            $this->db->insert('loan_payment_details', $paymentInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
        } else {
            $this->db->where('id', $updateId);
            $this->db->update('loan_payment_details', $paymentInfo);
            return $updateId;
        }
      //  echo  $this->db->last_query(); exit;
        return $result;
    }
    
    public function getCaseIdFromPayment($case_id){
       $this->db->select('*');
       $this->db->from('loan_payment_details');
       $this->db->where('case_id', $case_id);
       $this->db->where('status', '1');
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     

    }
    
    public function getPaymentDetails($case_id,$id='',$flag=''){
       $this->db->select('lp.*,cb.bank_name');
       $this->db->from('loan_payment_details as lp');
       $this->db->join('crm_customer_banklist as cb','lp.drawn_bank=cb.bank_id','left');
       $this->db->where('lp.case_id', $case_id);
       if(!empty($id))
       {
         $this->db->where('lp.id', $id);
       }
       if(!empty($flag))
       {
          $this->db->order_by("id", "desc");
          $this->db->limit('1', '1');
       }
       $query = $this->db->get();
       $result = $query->result_array();
       return  $result;     

    }

}
