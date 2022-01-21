<?php

/**
 * model : ublms_locations
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ublms_locations extends CI_Model {

    public function __construct() {
        
    }

    function getdealerlocality($request) {
        $this->db->select('lok.location_id as localityId,lok.location_name as localityname,cl.city_id,cl.city_name ');
        $this->db->from('ublms_locations as lok');
        $this->db->join('city_list  as cl', 'cl.city_id=lok.city_id','left');
        $query = $this->db->get();
        $rows  = $query->result_object();  
        $result = array();
        $i = 0;
        $cityName = '';
        foreach ($rows as $key => $res) 
        {
            if ($i == 0) 
            {
                $cityName = $res->city_name;
            }
            $result[] = array('locality_id' => $res->localityId, 'locality_name' => $res->localityname);
            $i++;
        }
        if ($result) 
        {
            $returnarr = array('status' => 'T', 'localities' => $result, 'city_name' => $cityName);
            return $returnarr;
        }
        else 
        {
            return $returnarr = array('status' => 'F', 'localities' => '', 'city_name' => '');
        }
    }

}

