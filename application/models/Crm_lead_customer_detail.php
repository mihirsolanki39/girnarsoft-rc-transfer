<?php

/**
 * model : Crm_lead_customer_detail
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_lead_customer_detail extends CI_Model {

    public function __construct() {
        
    }
    
    public function updateLocation($mobile,$dealerId,$locationId){
        
        if($locationId){
            $leadCustomerDetail = [
                    'sp_city_location' => $locationId
                ];
            $this->db->where('cd_customer_mobile', $mobile);
            $this->db->where('cd_did', $dealerId);
            $this->db->update('crm_lead_customer_detail', $leadCustomerDetail);
        }
    }


}

?>
