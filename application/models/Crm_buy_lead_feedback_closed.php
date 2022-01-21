<?php

/**
 * model : Crm_used_car
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_buy_lead_feedback_closed extends CI_Model {

    public function __construct() {
        
    }
    
    public function getAllFeedBack($type){
            global $DB;
            $sql="SELECT * FROM crm_buy_lead_feedback_closed where status=1 and type='$type'";
            $response = $this->db->query($sql, [])->result_object();
            return $response;
  	 }  

}

