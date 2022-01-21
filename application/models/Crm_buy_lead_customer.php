<?php

/**
 * model : Crm_buy_lead_customer
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_buy_lead_customer extends CI_Model {

    private $dateTime = '';

    public function __construct() {
        $this->dateTime = date('Y-m-d H:i:s');
    }

    public function getBuyLeadCustomer($mobile) {
        $query = $this->db->get_where('crm_buy_lead_customer', array('mobile' => $mobile));
        return $query->row_array();
    }

  /*  public function getCustomerFollow($requestParams) {
        if (isset($requestParams['method']) && $requestParams['method'] == 'leadadd') {
            $data['ldm_walkin_date'] = isset($requestParams['next_follow'])?$requestParams['next_follow']:'';
            $data['ldm_follow_date'] = isset($requestParams['next_follow'])?$requestParams['next_follow']:'';
        } else {
            $data['ldm_walkin_date'] = isset($requestParams['walkinDate'])?$requestParams['walkinDate']:'';
            $data['ldm_follow_date'] = isset($requestParams['next_follow'])?$requestParams['next_follow']:'';
        }

        return $data;
    }*/
    
    
    public function getCustomerFollow($requestParams,$statusId)
    {
        
                if($statusId=='4'){
                $data['ldm_walkin_date']    = (!empty($requestParams['walkinDate'])?$requestParams['walkinDate']:$requestParams['next_follow']);
                $data['ldm_follow_date']    = (!empty($requestParams['next_follow'])?$requestParams['next_follow']:$requestParams['walkinDate']);
                }else if($statusId=='9' && $requestParams['lead_source']=='UB')
                    {
                    $data['ldm_walkin_date']    = (!empty($requestParams['walkinDate'])?$requestParams['walkinDate']:'');
                    $data['ldm_follow_date']    = (!empty($requestParams['next_follow'])?$requestParams['next_follow']:'');
                      
                    }
                else if($statusId=='9' && $requestParams['lead_source']!='UB')
                    {
                    $data['ldm_walkin_date']    = date('Y-m-d H:i:s');
                    $data['ldm_follow_date']    = (!empty($requestParams['next_follow'])?$requestParams['next_follow']:'');
                      
                    }    
                else
                    {
                      $data['ldm_follow_date']    = (!empty($requestParams['next_follow'])?$requestParams['next_follow']:'');
                    }
           
            return $data;
    }

    public function getCustomerSource($requestParams) {
        $log_source_type = '';
        $requestParams['sub_source'] = strtolower($requestParams['sub_source']);
        if ($requestParams['sub_source'] == 'self') {
            $log_source_type = '1';
        } else if ($requestParams['sub_source'] == 'mobile') {
            $log_source_type = '2';
        } else if (strtolower($requestParams['lead_source']) == 'ub') {
            $log_source_type = '3';
        } else if ($requestParams['sub_source'] == 'conversionmark') {
            $log_source_type = '5';
        } else if ($requestParams['sub_source'] == 'knowlarity') {
            $log_source_type = '4';
        } else {
            $log_source_type = '1';
        }
        return $log_source_type;
    }

    public function saveCustomerCarLead($leadmapperId, $requestParams) {
        $this->load->model('Crm_used_car');
        $this->load->model('Leadmodel');
        $arrCarDetail = array();
        $arrCarDetail['lead_id']        = $leadmapperId;
        $arrCarDetail['source']         = !empty($requestParams['lead_source'])?$requestParams['lead_source']:'';
        $arrCarDetail['sub_source']     = !empty($requestParams['sub_source'])?$requestParams['sub_source']:'';
        $arrCarDetail['sale_amount']    = !empty($requestParams['sale_amount'])?$requestParams['sale_amount']:'';
        $arrCarDetail['booking_amount'] = !empty($requestParams['booking_amount'])?$requestParams['booking_amount']:'';
        $arrCarDetail['offer_amount']   = !empty($requestParams['offer_amount'])?$requestParams['offer_amount']:'';
        $requestParams['car_id']        = !empty($requestParams['gaadi_id'])? $requestParams['gaadi_id']:'';
        $leadCarId = '';
        
        if (!isset($requestParams['only_update_flag'])){
           $requestParams['only_update_flag']=0; 
        }
        if (!empty($requestParams['car_id'])) {
            $gaadiIds = explode(",", $requestParams['car_id']);
            $leadCarId = '0';
            foreach ($gaadiIds as $keey => $vaal) {
                if ($vaal) {
                    $carDetail = $this->Crm_used_car->getUsedCarDetailsSql($vaal);
                }
                $arrCarDetail['car_id']     = $vaal;
                $arrCarDetail['model_id']   = !empty($carDetail['model_id'])?$carDetail['model_id']:'';
                $arrCarDetail['version_id'] = !empty($carDetail['version_id'])?$carDetail['version_id']:'';
                if ($vaal > 0) {
                    if (isset($requestParams['only_update_flag']) && intval($requestParams['only_update_flag']) == 0) {
                        $leadCarId = $this->Leadmodel->setBuyLeadCarDetail($arrCarDetail);
                    }
                }
            }
        }
        return $leadCarId;
    }

}
