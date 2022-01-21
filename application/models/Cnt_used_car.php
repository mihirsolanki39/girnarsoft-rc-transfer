<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cnt_used_car extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getTable()
    {
        return 'cnt_used_car';
    }

    public function getCntUsedCarData($car_id = 0)
    {

        $this->db->select('uc.*');
        $this->db->from('cnt_used_car as uc');
        $this->db->order_by('uc.id');
        //$this->db->limit('3');
        if (!empty($car_id))
        {
            $this->db->where('id', $car_id);
        }
        $query  = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getCntUsedImages($car_id='',$image_name='')
    {

        
        $this->db->select('im.*');
        $this->db->from('cnt_used_car as uc');
        $this->db->join('im', 'uc.id=im.usedcar_id', 'left');
        $this->db->where_in('im.status', ['1', '2', '3']);
        if(!empty($car_id)){
            $this->db->where('im.usedcar_id', $car_id);
        }
        if(!empty($image_name)){
            $this->db->where('im.image_name', $image_name);
        }
        $this->db->order_by('uc.id');
        $this->db->order_by('im.status');
        $query  = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function save_cnt_data($data, $id = '')
    {
        if (empty($id))
        {
            $this->db->insert('cnt_used_car', $data);
            $insert_id = $this->db->insert_id();
            $result    = $insert_id;
        }
        else
        {
            $this->db->where('id', $id);
            $this->db->update('cnt_used_car', $data);
            $result = $id;
        }
        return $result;
    }

    public function DcToCrmMapping($data)
    {

        return [
            'id'                  => $data['id'],
            'dealer_id'           => $data['dealer_id'],
            'version_id'          => $data['version_id'],
            'showroom_id'         => $data['showroom_id'],
            'city_id'             => $data['city_id'],
            'locality_id'         => $data['locality_id'],
            'reg_place_city_id'   => $data['reg_place_city_id'],
            'car_status'          => $data['car_status'],
            'is_feature'          => $data['is_feature'],
            'is_gaadi'            => $data['is_gaadi'],
            'is_cardekho'         => $data['is_cardekho'],
            'is_zigwheels'        => $data['is_zigwheels'],
            'km_driven'           => $data['km_driven'],
            'car_price'           => $data['car_price'],
            'sold_price'          => $data['sold_price'],
            'colour'              => $data['colour'],
            'owner_type'          => $data['owner_type'],
            'make_month'          => $data['make_month'],
            'make_year'           => $data['make_year'],
            'insurance_type'      => $data['insurance_type'],
            'insurance_exp_year'  => $data['insurance_exp_year'],
            'insurance_exp_month' => $data['insurance_exp_month'],
            'reg_no'              => $data['reg_no'],
            'reg_date'            => $data['reg_year'].'-'.$data['reg_month'].'-01',
            'reg_month'           => $data['reg_month'],
            'reg_year'            => $data['reg_year'],
            'reg_rto_city'        => $data['reg_rto_city'],
            'is_cng_fitted'       => $data['is_cng_fitted'],
            'tax_type'            => $data['tax_type'],
            'user_type'           => $data['user_type'],
            'created_date'        => date('Y-m-d H:i:s'),
            'last_update_date'    => $data['last_update_date'],
        ];
    }
    

}
