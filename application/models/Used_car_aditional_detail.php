<?php

/**
 * model : Crm_outlets
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Used_car_aditional_detail extends CI_Model {

    public function __construct() {
        
    }

    public function getcarAdditionalDetail($carId = '') { {
            $this->db->select('*');
            $this->db->from('used_car_aditional_detail');
            $this->db->where('carID', $carId);
            $query = $this->db->get();
            $result = $query->row_array();
            return $result;
        }
    }
    
   public function renderCarShareSmsText($response, $car_id, $requestType,$flag='0') {
       /*echo "<pre>";
        print_r($response);
        exit;*/
        $this->load->helper('range_helper');
        $pricefrom = $this->money_formats($response['pricefrom']);
        $kms       = $this->money_formats($response['km']);
        $year       = $response['make_year'];
        $executive = $this->session->userdata['userinfo']['name'];
        $executiveMobile = $this->session->userdata['userinfo']['mobile'];
        $Driven = $kms != '' ? $kms . ' Kms Driven ' : '';
        $owner = (!empty($response['owner']))? $response['owner'].' Owner car':'';
        $fuel_type = $response['fuel_type'] != '' ? ' (' . $response['fuel_type'] . '), ' : '';
        $color = $response['colour'] != '' ? $response['colour'] . ' Colour, ' : '';
        $price = $pricefrom != '' ? ' @ Rs ' . $pricefrom : '';
        if($flag=='1'){
            $msg = '';
            $msg .= 'Hi Customer,'."\n";
            $msg .= 'Thank you for showing interest in '.$year.' '. $response['make'] . ' ' . $response['model'] . ' ' . $response['carversion'];
            $msg .= $fuel_type . $color . $Driven . $owner .$price.'.'."\n";
            $msg .= ' Please call on '.ucwords($executive).' - '.$executiveMobile.' for any assistance.'."\n".' Regards,'."\n";
            $msg .= ' ' . ORGANIZATION ."\n";
            //$msg .= ' ' . MOBILESMS;
        }
        else
        {
            $msg = '';
            $msg .= 'Hi Customer,'."\n";
            $msg .= 'Please have a look at ' . $response['make'] . ' ' . $response['model'] . ' ' . $response['carversion'];
            $msg .= $fuel_type . $color . $Driven;
            $msg .= $price . ' - http://' . DOMAIN . '/car_detail.php?id=' . $response['gaadi_id']."\n";
            $msg .= 'Regards,'."\n";
            $msg .= ' ' . ORGANIZATION ."\n";
            $msg .= ' ' . MOBILESMS;
        }

        $sms_text = preg_replace("/&#?[a-z0-9]+;/i", "", $msg);
        return $sms_text;
    }
     public function money_formats($number){        
        //$decimal = (string)($number - floor($number));
        $money = floor($number);
        $length = strlen($money);
        $delimiter = '';
        $money = strrev($money);
 
        for($i=0;$i<$length;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
                $delimiter .=',';
            }
            $delimiter .=$money[$i];
        }
 
        $result = strrev($delimiter);
       // $decimal = preg_replace("/0\./i", ".", $decimal);
       // $decimal = substr($decimal, 0, 3);
 
        //if( $decimal != '0'){
       //     $result = $result.$decimal;
       // }
 
        return $result;
    }
}
