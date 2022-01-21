<?php

/**
 * model : Crm_outlets
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Used_car_model_details extends CI_Model {

    public function __construct() {
        
    }

    /**
     * This function is used to add new dealer to system
     * @return number $insert_id : This is last inserted id
     */
    public function getModelDetail($carID='') {
       $this->db->select('*');
       $this->db->from('used_car_model_details');
       $this->db->where('carID', $carID);
       $query = $this->db->get();
       $result= $query->row_array();
       return $result;
    }

}

?>
