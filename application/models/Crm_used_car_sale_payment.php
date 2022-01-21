<?php

/**
 * model : Crm_insurance
 * User Class to control all insurance related operations.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_used_car_sale_payment extends CI_Model
{

    private $dateTime = '';
    private $zero     = 0;
    private $date     = '';

    public function __construct()
    {
        parent::__construct();
        $this->dateTime = date("Y-m-d H:i:s");
    }
    public static $table= 'crm_uc_sales_payment';
    public function createData($data)
    {
        return [
            'uc_sales_case_id'  => $data['caseId'],
            'instrument_type'   => $data['instrument_type'],
            'payment_date'      => date('Y-m-d H:i:s', strtotime($data['payment_date'])),
            'remarks'           => $data['remarks'],
            'amount'            => str_replace(',','',$data['amount']),
            'instrument_no'     => $data['instrument_type']!='cash'?$data['instrument_no']:'',
            'instrument_date'   => $data['instrument_type']!='cash'?date('Y-m-d H:i:s', strtotime($data['instrument_date'])):'0000-00-00 00:00:00',
            'favouring'         => $data['instrument_type']!='cash'?$data['favouring']:'',
            'bank_id'           => $data['instrument_type']!='cash'?$data['bank_id']:'',
            'status'            => '1',
            'role_id'            => $_SESSION['userinfo']['role_id'],
            'updated_by'        => $_SESSION['userinfo']['id']
        ];
    }

    public function savePaymentData($data,$id=0)
    {
        
        if (empty($id))
        {
            $data['created_by']   = $_SESSION['userinfo']['id'];
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
    public function getPaymentData($case_id,$role_id='')
    {

        $and = 'and p.role_id not in (24)';
        if($role_id=='24')
        {
            $and =' ';
        } 
        /*echo 'SELECT p.*,b.bank_name,u.role_id,u.team_id,is_admin FROM ' . self::$table . ' p '
                . 'inner join crm_used_car_sale_case_info usc on usc.id=p.uc_sales_case_id left join crm_customer_banklist b on p.bank_id=b.id left join crm_user u on u.id=p.updated_by  where p.status="1" and usc.status="1" and p.uc_sales_case_id='.$case_id.' '.$and ; exit;*/
        $result = $this->db->query('SELECT p.*,b.bank_name,u.role_id,u.team_id,is_admin FROM ' . self::$table . ' p '
                . 'inner join crm_used_car_sale_case_info usc on usc.id=p.uc_sales_case_id left join crm_customer_banklist b on p.bank_id=b.bank_id left join crm_user u on u.id=p.updated_by  where p.status="1" and usc.status="1" and p.uc_sales_case_id='.$case_id.' '.$and )->result_array();

        return $result;
    }
    public function getPaymentById($id)
    {
        $id = !empty($id)?$id:0;
        $result = $this->db->query('SELECT p.*,b.bank_name,u.role_id,u.team_id,is_admin FROM ' . self::$table . ' p '
                . 'inner join crm_used_car_sale_case_info usc on usc.id=p.uc_sales_case_id left join crm_customer_banklist b on p.bank_id=b.bank_id left join crm_user u on u.id=p.updated_by  where p.status="1" and usc.status="1" and p.id='.$id )->result_array();
        return $result;
    }
    public function getAdvancePayment($case_id){
        
        $this->db->select('p.*');
        $this->db->from(self::$table.' p');
        $this->db->join('crm_used_car_sale_case_info as usc','usc.id=p.uc_sales_case_id','inner');
        $this->db->where('p.uc_sales_case_id', $case_id);
        $this->db->where('p.is_advance_payment','1');
        $this->db->where('p.status','1');
        $this->db->where('usc.status','1');
        $query    = $this->db->get();
        
        return $query->result_array();
    }
    public function getTotalAmountPaid($case_id,$is_admin=true,$payment_id='',$role_id='')
    {
        $and ='';
        if(!empty($payment_id)){
            $and=' and p.id !='.$payment_id.' ';
        }
      // echo 'SELECT sum(p.amount) amount_paid FROM ' . self::$table . ' p inner join crm_used_car_sale_case_info usc on usc.id=p.uc_sales_case_id where p.status="1" and usc.status="1" and uc_sales_case_id=' . $case_id.$and; exit;
        if ($is_admin)
        {
            $ands = ' and p.role_id not in (24)';
            if($role_id=='24')
            {
                $ands = '';
            }
           // echo 'SELECT sum(p.amount) amount_paid FROM ' . self::$table . ' p inner join crm_used_car_sale_case_info usc on usc.id=p.uc_sales_case_id where p.status="1" and usc.status="1" and p.uc_sales_case_id=' . $case_id.$and.$ands; exit;
            $result = $this->db->query('SELECT sum(p.amount) amount_paid FROM ' . self::$table . ' p inner join crm_used_car_sale_case_info usc on usc.id=p.uc_sales_case_id where p.status="1" and usc.status="1" and p.uc_sales_case_id=' . $case_id.$and.$ands)->result_array();
        }
        else
        {
            $result = $this->db->query('SELECT sum(p.amount) amount_paid FROM ' . self::$table . ' p inner join crm_used_car_sale_case_info usc on usc.id=p.uc_sales_case_id '
                    . 'left join crm_user u on u.id=p.updated_by where p.status="1" and usc.status="1" and p.uc_sales_case_id=' . $case_id.' and ('
                    . ' u.role_id=21 or is_advance_payment="1" ) '.$and.$ands)->result_array();
        }
        return isset($result[0]['amount_paid'])?$result[0]['amount_paid']:0;
        
    }
    public function paymentByAdmin($case_id){
        
      $result = $this->db->query('SELECT sum(p.amount) amount_paid FROM ' . self::$table . ' p inner join crm_used_car_sale_case_info usc on usc.id=p.uc_sales_case_id '
                    . 'left join crm_user u on u.id=p.updated_by where p.status="1" and usc.status="1"  and p.uc_sales_case_id=' . $case_id.' and ('
                    . ' u.role_id=20 or u.is_admin="1" )')->result_array();
      return isset($result[0]['amount_paid'])?$result[0]['amount_paid']:0;

    }

}
