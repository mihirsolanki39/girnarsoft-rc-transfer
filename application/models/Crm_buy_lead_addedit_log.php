<?php

/**
 * model : crm_buy_lead_addedit_log
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_buy_lead_addedit_log extends CI_Model {

    public function __construct() {
        
    }
    
     public function insertEditlog($data,$request,$respone)
        {
            $logData                =  array();
            $logData['lead_id']     =  !empty($data['lc_lead_dealer_mapper_id'])?$data['lc_lead_dealer_mapper_id']:'';
            $logData['mobile']      =  !empty($data['mobile'])?$data['mobile']:'';
            $logData['dealer_id']   =  !empty($data['ldm_dealer_id'])?$data['ldm_dealer_id']:'';
            $logData['input']       =  json_encode($request);
            $logData['output']      =  json_encode($respone);
            $logData['source']      =  !empty($data['ldm_source'])?$data['ldm_source']:'';
            $logData['sub_source']  =  !empty($data['ldm_sub_source'])?$data['ldm_sub_source']:'';
            $this->db->trans_start();
            $this->db->insert('crm_buy_lead_addedit_log', $logData);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }


}

