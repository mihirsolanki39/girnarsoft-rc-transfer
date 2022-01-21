<?php

/**
 * model : Crm_insurance
 * User Class to control all insurance related operations.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_used_car_sale_delivery extends CI_Model
{

    private $dateTime = '';
    private $zero     = 0;
    private $date     = '';

    public function __construct()
    {
        parent::__construct();
        $this->dateTime = date("Y-m-d H:i:s");
    }
    public static $table= 'crm_uc_sales_delivery';
    public function createData($data)
    {
        return [
            'uc_sales_case_id' => $data['caseId'],
            'delivery_date'    => date('Y-m-d H:i:s', strtotime($data['delivery_date'])),
            //'is_delivered'     => '1',
            'gate_pass_no'     => $data['gate_pass_no'],
            'sold_invoice_no'  => $data['sold_invoice_no'],
            'sold_invoice_date'     => date('Y-m-d H:i:s',strtotime($data['sold_invoice_date'])),
        ];
    }

    public function saveDeliveryData($data,$id=0)
    {
        
        if (empty($id))
        {
            $data['created_date'] = date('Y-m-d H:i:s');
            $data['updated_date'] = date('Y-m-d H:i:s');
            $this->db->insert(self::$table, $data);
            return  $this->db->insert_id();
        }
        else
        {
            $data['updated_date'] = date('Y-m-d H:i:s');
            $this->db->where('id', $id);
            $this->db->update(self::$table, $data);
            return $id;
        }
    }
    public function getDeliveryData($case_id)
    {
        $this->db->select('d.*');
        $this->db->from(self::$table.' d');
        $this->db->join('crm_used_car_sale_case_info as usc','usc.id=d.uc_sales_case_id','inner');
        $this->db->where('d.uc_sales_case_id', $case_id);
        $this->db->where('usc.status','1');
        $query    = $this->db->get();
        return $query->result_array();
        
    }

   

}
