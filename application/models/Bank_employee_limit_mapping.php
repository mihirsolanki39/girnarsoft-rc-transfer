<?php

/**
 * model : Bank_employee_limit_mapping
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bank_employee_limit_mapping extends CI_Model {

    public function __construct() {
        
    }

    function getEmployeeLimit($id = '') {
        $this->db->select('sum(b.emp_limit)as distributedLimit');
        $this->db->from(BANK_EMP_LIMIT_MAPPING .' as b');
        $this->db->join('crm_user  as u', 'b.emp_id=u.id','LEFT'); 
        $this->db->where('b.status','1');
        $this->db->where('u.status','1');
        if ($id != 0) {
            $this->db->where("bank_id", $id);
        }

        $query = $this->db->get();
        $result = $query->result();
        return !empty($result)?$result:[];
    }

}

