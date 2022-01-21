<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class UsedCarImageMapper extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

   
    public function getAllImagesByCarId($car_id) {
        // $sql = "SELECT * from ".USED_CAR_IMAGE_MAPPER." where usedcar_id='".$car_id."' and status='1' "; 
        $result    = $this->db->get_where(USED_CAR_IMAGE_MAPPER, array('usedcar_id'=>$car_id,'status'=>'1'))->result_array();
        return  $result;
       // $result = $this->fetchAll(['fields' => ['*'], 'conditions' => ['usedcar_id' => $car_id, 'status' => '1']]);
       // return $result;
    }
    
    public function getCrmUcImages($car_id='',$image_name='',$flag='')
    {

        
        $this->db->select('*');
        $this->db->from(USED_CAR_IMAGE_MAPPER);
        $this->db->where_in('status', ['1', '2', '3']);
        if(!empty($flag) && ($flag=='1'))
        {
           $this->db->where('is_on_cdn', '1');
        }
        if(!empty($flag) && ($flag=='2'))
        {
           $this->db->where('is_on_cdn', '0');
            $this->db->where('sent_to_aws', '0');
           $this->db->where('source not like "dealerCentral"');
        }
        if(!empty($car_id)){
            $this->db->where('usedcar_id', $car_id);
        }
        if(!empty($image_name)){
            $this->db->where('image_name', $image_name);
        }
        $this->db->order_by('order');
        $query  = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    public function getImagesToSyncWithDC(){
        $this->db->select('car_id,id');
        $this->db->from('crm_to_dc_image_sync sync');
        $this->db->where('is_syncd','0');
        $query  = $this->db->get();
        return $query->result_array();
    }

}
