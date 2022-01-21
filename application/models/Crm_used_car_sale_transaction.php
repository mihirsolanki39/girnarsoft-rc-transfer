<?php

/**
 * model : Crm_insurance
 * User Class to control all insurance related operations.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_used_car_sale_transaction extends CI_Model
{

    private $dateTime = '';
    private $zero     = 0;
    private $date     = '';

    public function __construct()
    {
        parent::__construct();
        $this->dateTime = date("Y-m-d H:i:s");
    }
    public function createData($data)
    {
       
        $data['issue_new_insurance'] = $data['issue_new_insurance'] == 'yes' ? '1' : '0';
        $data['is_loan_req']         = $data['is_loan_req'] == 'yes' ? '1' : '0';
        return [
            'uc_sales_case_id'       => $data['caseId'],
            'uc_sales_exe_id'        => $data['sales_exec_id'],
            //'trnx_status'            => $data['current_trxn_status'],
            'new_insurance_req'      => $data['issue_new_insurance'],
            'insurance_case_id'      => $data['insurance_case_id'],
            'loan_req'               => $data['is_loan_req'],
            'loan_case_id'           => $data['loan_case_id'],
            'base_vehicle_price'     => str_replace(',','',$data['base_vehicle_price']),
            'tcs'                    => str_replace(',','',$data['tcs']),
            'rto_charges'            => str_replace(',','',$data['rto']),
            'amount'                 => str_replace(',','',$data['total_amt']),
            'actual_amount'          => ($data['rolename']=='24')?str_replace(',','',$data['actual_sales_amount']):'',
            'advance_payment'        => !empty($data['advance_payment'])?str_replace(',','',$data['advance_payment']):0,
            'additional_accessories' => $data['additional_accessories'],
            'insurance_charges'      => str_replace(',','',$data['insurance_charges']),
            'loan_amount'            => $data['is_loan_req']==1?str_replace(',','',$data['loan_amount']):'',
            'bank_id'                => $data['is_loan_req']==1?$data['bank_id']:'',
            'roi'                    => $data['is_loan_req']==1?str_replace('%','',trim($data['roi'])):'',
            'tenure'                 => $data['is_loan_req']==1?$data['tenure']:'',
            'valuaton_charges'       => $data['is_loan_req']==1?str_replace(',','',$data['valuaton_charges']):'',
            'hypothecation'          => $data['is_loan_req']==1?str_replace(',','',$data['hypothecation']):'',
            'processing_fee'         => $data['is_loan_req']==1?str_replace(',','',$data['processing_fee']):'',
        ];
    }

    public function SaveTransactionData($data,$id=0)
    {
        if (empty($id))
        {
            $data['created_date'] = date('Y-m-d H:i:s');
            $data['updated_date'] = date('Y-m-d H:i:s');
            $this->db->insert('crm_uc_sales_transactions', $data);
            return  $this->db->insert_id();
        }
        else
        {
            $data['updated_date'] = date('Y-m-d H:i:s');
            $this->db->where('id', $id);
            $this->db->update('crm_uc_sales_transactions', $data);
            return $id;
        }
    }
    public function getTranxData($case_id)
    {
        $this->db->select('t.*');
        $this->db->from('crm_uc_sales_transactions t');
        $this->db->join('crm_used_car_sale_case_info as usc','usc.id=t.uc_sales_case_id','inner');
        $this->db->where('uc_sales_case_id', $case_id);
        $this->db->where('usc.status','1');
        $query    = $this->db->get();
        //echo $this->db->last_query(); exit;
        return $query->result_array();
    }

   

}
