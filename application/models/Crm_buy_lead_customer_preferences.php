<?php

/**
 * model : Crm_buy_lead_dealer_mapper
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_buy_lead_customer_preferences extends CI_Model {

    public function __construct() {
        
    }

    function autoPrefillingPreferences($leadId) {
        $this->load->model('Crm_buy_lead_car_detail');
        $returnarr     = [];
        $car_price     = 0;
        $make_id       = '';
        $model_id      = '';
        if ($leadId > 0) {
            $data = $this->Crm_buy_lead_car_detail->getLeadCarDetail($leadId);
            $i = 0;
            foreach ($data as $key => $value) {

                $car_price+=$value['pricefrom'];

                if ($value['make_id'] > 0) {
                    $make_id.=$value['make_id'] . ",";
                }
                if ($value['model_id'] > 0) {
                    $model_id.=$value['model_id'] . ",";
                }
                $i++;
            }
            $car_price = $car_price / $i;
            $make_id = trim($make_id, ",");
            $model_id = trim($model_id, ",");

            $makmodel = $this->mergeMakeidModel($make_id, $model_id, $leadId);
            $nearbudget = $this->getClosedBudget($car_price);
            $returnarr['make_id'] = $makmodel['makeid'];
            $returnarr['model_id'] = $makmodel['modelid'];
            $returnarr['car_price'] = $nearbudget;
            $returnarr['lead_id'] = $leadId;
        }
        return $returnarr;
    }
    
    public function getBuyLeadCustomerPreferences($lead_deale_mapp_id) {
        $query = $this->db->get_where('crm_buy_lead_customer_preferences', array('lcp_lead_dealer_mapper_id' => $lead_deale_mapp_id,'lcp_is_latest'=>'1','lcp_active'=>'1'));
        return $query->result_array();
    }

    function mergeMakeidModel($makeid, $modelid, $leadid) {
        $returnarr = array();
        $result = $this->getBuyLeadCustomerPreferences($leadid);
        if (!empty($result) && (!empty($result['lcp_make']) || !empty($result['lcp_model']))) {
            $oldmakeid = explode(",", $result['lcp_make']);
            $oldmakeid = explode(",", $result['lcp_model']);
            $newmakeid = explode(",", $makeid);
            $newmodelid = explode(",", $modelid);
            $makeid = $oldmakeid + $newmakeid;
            $modelid = $oldmakeid + $newmodelid;
        } else {
            $makeid = $makeid;
            $modelid = $modelid;
        }
        $returnarr['makeid'] = $makeid;
        $returnarr['modelid'] = $modelid;
        return $returnarr;
    }

    function getClosedBudget($amount) {
        $budgetarray = $this->getbudgetList();

        $i           = 1;
        $famount     = array();
        $nearAmount1 ='';
        $nearAmount2 ='';
        foreach ($budgetarray as $kk => $value) {
            $budget[$value['key']] = $value['key'];
            if ($amount < $value['key']) {
                $nearAmount1 = $value['key'] - $amount;
            } else {
                $nearAmount2 = $amount - $value['key'];
            }

            if ($nearAmount2 < $nearAmount1) {

                break;
            }
            $famount[$i] = $value['key'];
            $i++;
        }

        return $famount[$i - 1];
    }
    
    function getbudgetList() {
            $budgetArr = array(
            //array('key' => '0', 'value' => '0'),
            array('key' => '25000', 'value' => '25,000'),
            array('key' => '50000', 'value' => '50,000'),
            array('key' => '75000', 'value' => '75,000'),
            array('key' => '100000', 'value' => '1 Lac'),
            array('key' => '125000', 'value' => '1.25 Lacs'),
            array('key' => '150000', 'value' => '1.50 Lacs'),
            array('key' => '175000', 'value' => '1.75 Lacs'),
            array('key' => '200000', 'value' => '2 Lacs'),
            array('key' => '225000', 'value' => '2.25 Lacs'),
            array('key' => '250000', 'value' => '2.50 Lacs'),
            array('key' => '275000', 'value' => '2.75 Lacs'),
            array('key' => '300000', 'value' => '3 Lacs'),
            array('key' => '325000', 'value' => '3.25 Lacs'),
            array('key' => '350000', 'value' => '3.50 Lacs'),
            array('key' => '375000', 'value' => '3.75 Lacs'),
            array('key' => '400000', 'value' => '4 Lacs'),
            array('key' => '425000', 'value' => '4.25 Lacs'),
            array('key' => '450000', 'value' => '4.50 Lacs'),
            array('key' => '475000', 'value' => '4.75 Lacs'),
            array('key' => '500000', 'value' => '5 Lacs'),
            array('key' => '550000', 'value' => '5.50 Lacs'),
            array('key' => '600000', 'value' => '6 Lacs'),
            array('key' => '650000', 'value' => '6.50 Lacs'),
            array('key' => '700000', 'value' => '7 Lacs'),
            array('key' => '750000', 'value' => '7.50 Lacs'),
            array('key' => '800000', 'value' => '8 Lacs'),
            array('key' => '850000', 'value' => '8.50 Lacs'),
            array('key' => '900000', 'value' => '9 Lacs'),
            array('key' => '950000', 'value' => '9.50 Lacs'),
            array('key' => '1000000', 'value' => '10 Lacs'),
            array('key' => '1100000', 'value' => '11 Lacs'),
            array('key' => '1200000', 'value' => '12 Lacs'),
            array('key' => '1300000', 'value' => '13 Lacs'),
            array('key' => '1400000', 'value' => '14 Lacs'),
            array('key' => '1500000', 'value' => '15 Lacs'),
            array('key' => '1600000', 'value' => '16 Lacs'),
            array('key' => '1700000', 'value' => '17 Lacs'),
            array('key' => '1800000', 'value' => '18 Lacs'),
            array('key' => '1900000', 'value' => '19 Lacs'),
            array('key' => '2000000', 'value' => '20 Lacs'),
            array('key' => '2500000', 'value' => '25 Lacs'),
            array('key' => '3000000', 'value' => '30 Lacs'),
            array('key' => '4000000', 'value' => '40 Lacs'),
            array('key' => '5000000', 'value' => '50 Lacs'),
            array('key' => '7500000', 'value' => '75 Lacs'),
            array('key' => '10000000', 'value' => '1 Crore'),
            array('key' => '30000000', 'value' => '3 Crores')
        );

        return $budgetArr;
}
    
    

}

