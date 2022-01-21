<?php

/**
 * model : Crm_insurance
 * User Class to control all insurance related operations.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_used_car_sale_booking extends CI_Model
{

    private $dateTime = '';
    private $zero     = 0;
    private $date     = '';

    public function __construct()
    {
        parent::__construct();
        $this->dateTime = date("Y-m-d H:i:s");
    }
    public static $table= 'crm_uc_sales_booking';
    public function createData($data)
    {
        return [
            'uc_sales_case_id' => $data['caseId'],
            'booking_date'     => date('Y-m-d H:i:s',strtotime($data['booking_date'])),
            'date_of_delivery' => date('Y-m-d H:i:s',strtotime($data['date_of_delivery'])),
            'booking_amount'   => $data['booking_amount'],
            'booking_form_no'  => $data['booking_form_no'],
            'instrument_type'  => $data['instrument_type'],
            'instrument_no'    => $data['instrument_no'],
            'instrument_date'  => date('Y-m-d H:i:s',strtotime($data['instrument_date'])),
            'bank_id'          => $data['bank_id'],
            'favouring'        => $data['favouring'],
            'payment_date'     => date('Y-m-d H:i:s',strtotime($data['payment_date'])),
            'receipt_no'       => $data['receipt_no']

        ];
    }

    public function saveBookingData($data,$id=0)
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
    public function getBookingData($case_id)
    {
        $this->db->select('b.*');
        $this->db->from(self::$table.' b');
        $this->db->join('crm_used_car_sale_case_info as usc','usc.id=b.uc_sales_case_id','inner');
        $this->db->where('uc_sales_case_id', $case_id);
        $this->db->where('usc.status','1');
        $query    = $this->db->get();
        return $query->result_array();

    }

   

}
