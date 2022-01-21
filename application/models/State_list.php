<?php

/**
 * model : Crm_outlets
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class State_list extends CI_Model {

    public function __construct() {
        
    }

    /**
     * This function is used to add new dealer to system
     * @return number $insert_id : This is last inserted id
     */
    public function getStateList($id='') {
       $this->db->select('state_list_id as state_id,state_list_name as state_name');
       $this->db->from(STATE_LIST);
       if(!empty($id))
       {
          $this->db->where('state_list_id',$id);
       }
       $query = $this->db->get();
       $result = $query->result();
       return $result;
    }

}

?>
