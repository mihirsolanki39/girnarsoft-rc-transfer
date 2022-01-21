<?php

/**
 * model : Crm_outlets
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usedcar_condition_mapper extends CI_Model {

    public function __construct() {
        
    }
    
    public function getAllCondition($carId = '') { {
            $this->db->select('*');
            $this->db->from('usedcar_condition_mapper');
            $this->db->where('car_id', $carId);
            $query = $this->db->get();
            $result = $query->row_array();
            return $result;
        }
    }

}
