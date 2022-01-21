<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class City extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getTable() {
        return 'city_list';
    }

    public function getCityList($state_id = 0) {
        $this->load->database();
        /*$cityListArray = $this->fetchAll(array(
            'fields' => array('city_id', 'city_name'),
            'conditions' => array('con_id' => '1', 'state_id' => $state_id),
            'order' => array('city_name')
        ));*/

        $query = $this->db->get_where('city_list', array('con_id' => '1','state_id'=>$state_id));
        $query = $this->db->order_by(array('city_name'=>'asc'));
        $cityListArray = $query->result_array();

        foreach ($cityListArray as $city) {
            $cityList[$city['city_id']] = $city['city_name'];
        }
        return $cityList;
    }

    public function getAllCityList() {
         $this->load->database();
       /* $cityListArray = $this->fetchAll(array(
            'fields' => array('city_id', 'city_name'),
            'conditions' => array('con_id' => '1'),
            'order' => array('order_by')
        ));*/
        $this->db->select('city_id, city_name');
        $this->db->from('city_list'); 
        $this->db->where('con_id','1');
        $this->db->order_by('city_name','asc');
        $query = $this->db->get();
        $cityListArray = $query->result_array();
        

        /*foreach ($cityListArray as $city) {
            $cityList[$city['city_id']] = $city['city_name'];
        }*/
        return $cityListArray;
    }

    public function getCity($stateid, $zoneid) {
         $this->load->database();
        $statid = '';
        $zonid = '';
        foreach ($zoneid as $zk => $zval) {
            $zonid.="'" . $zval . "',";
        }
        foreach ($stateid as $sk => $sval) {
            $statid[] = $sval;
        }
        $statids = implode(",",$statid);
        $where = ($statids)?"zsc.state_id in($statids)":"1=1 order by zsc.city_name asc";
        $city = $this->db->query("select zsc.city_id,zsc.city_name from ".$this->getTable()." as zsc  where $where ");
        $city = $city->result_array();
        return $city;
    }
    
    public function getcityRayRaId($uid) {
         $this->load->database();
        $citiids = $this->db->query("select ucm.* from dc_users_city_mapping as ucm  where ucm.user_id='" . $uid . "' and ucm.status='1' ");
         $citiids = $citiids->result_array();
        return $citiids;
    }
    
    public function getAllCityListNew() {
         $this->load->database();
        $this->db->select('c.*');
        $this->db->from('city_list as c');
        $this->db->where('con_id', '1');
        
        $query = $this->db->order_by('city_name','asc');
        $query=$this->db->get();
        $cityList = $query->result_array();

        return $cityList;
    }

       public function getCityNameById($city_id) {
         $this->load->database();
        $this->db->select('c.*');
        $this->db->from('city_list as c');
        $this->db->where('con_id', '1');
        $this->db->where('city_id', $city_id);
        
        $query = $this->db->order_by('city_name','asc');
        $query=$this->db->get();
        $cityList = $query->result_array();

        return $cityList[0]['city_name'];
    }


}
