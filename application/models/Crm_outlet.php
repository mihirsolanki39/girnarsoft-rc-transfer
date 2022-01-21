<?php

/**
 * model : Crm_outlets
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_outlet extends CI_Model {

    public function __construct() {
        
    }

    /**
     * This function is used to add new dealer to system
     * @return number $insert_id : This is last inserted id
     */
    function addOutlet($outletInfo, $updateId) {
        if (empty($updateId)) {
            $this->db->trans_start();
            $this->db->insert('crm_outlet', $outletInfo);

            $insert_id = $this->db->insert_id();

            $this->db->trans_complete();

            return $insert_id;
        } else {
            $this->db->where('dealer_id', $updateId);
            $this->db->update('crm_outlet', $outletInfo);
            return $this->db->affected_rows();
        }
    }

}

?>
