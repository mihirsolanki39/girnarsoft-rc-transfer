<?php

/**
 * model : Crm_lead_customer_comment
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_lead_customer_comment extends CI_Model {

    public function __construct() {
        
    }
    
    public function setLeadCustomerComment($requestParams) {
            $leadCustomerComment=[];
            $leadCustomerComment['lc_customer_mobile']     = $requestParams['mobile'];
            $leadCustomerComment['lc_did']                 = $requestParams['ucdid'];
            $leadCustomerComment['lc_conversation_comment']= $requestParams['comment'];
            $leadCustomerComment['lc_plateform']           = $requestParams['lc_plateform'];
            $leadCustomerComment['lc_customer_mobile']     = $requestParams['mobile'];
            if($requestParams['comment']){
            $this->db->trans_start();
            $this->db->insert('crm_lead_customer_comment', $leadCustomerComment);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result= $insert_id;
            }
       return $result;
    }


}

?>
