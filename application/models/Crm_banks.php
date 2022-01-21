<?php

/**
 * model : Crm_Bank
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_banks extends CI_Model {

    public function __construct() {
        
    }

    function BankListings($searchText='') {
        $this->db->select('b.*');
        $this->db->from('crm_banks as b');
        $this->db->where('b.status', '1');
       
        if(!empty($searchText)) {
            $likeCriteria = "(cbl.bank_name  LIKE '%".$searchText."%'
                            OR  b.branch_name  LIKE '%".$searchText."%'
                            OR  b.amount_limit  LIKE '%".$searchText."%'
                            OR  b.address  LIKE '%".$searchText."%')";
            $this->db->join('crm_bank_list  as cbl', 'cbl.id=b.bank_id','left');
            $this->db->where($likeCriteria);
            $this->db->where('cbl.status', '1');
        }
        $query = $this->db->get();
        $result = $query->result();
       //echo $this->db->last_query();die;
        return $result;
    }

    function addNewBank($bankInfo) {
        $this->db->trans_start();
        $this->db->insert('crm_banks', $bankInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        $result = $insert_id;
        return $result;
    }
    
    function addCrmBank($bankInfo){
        $bank_name=$bankInfo['bank_name'];
        $this->db->select('b.*');
        $this->db->from('crm_bank_list as b');
        $this->db->where('b.bank_name', $bank_name);
        $this->db->where('b.status', '1');
        $query = $this->db->get();
        $result = $query->result();
        if(!empty($result[0]->bank_name)){
        $bankId=$result[0]->id; 
        return $bankId;
        }else{
        $this->db->insert('crm_bank_list', $bankInfo);
        $insert_id = $this->db->insert_id();
        $bankId = $insert_id;
        return $bankId;
        }
        
    }

    function updateCrmBanks($bankInfo,$id='')
    {
        $this->db->where('id',$id);
        $bankId = $this->db->update('crm_bank_list', $bankInfo);
        return $id;
    }
    
    function getBankInfo($id = '',$bnk_id='') {
        $this->db->select('b.*');
        $this->db->from('crm_banks as b');
        $this->db->where('b.status', '1');
        if($id != 0){
            $this->db->where("id", $id);
        }
        if($bnk_id != 0){
            $this->db->where("bank_id", $bnk_id);
        }
        
        $query = $this->db->get();
        $result = $query->result_array();
        //echo $this->db->last_query();die;
        return $result;
    }
    
    function getBankNameById($banks){
        $data= [];
        foreach ($banks as $bank){
            $data[] = $bank['bank_id'];
        }
        $this->db->select('b.*');
        $this->db->from('crm_bank_list as b');
        $this->db->where('b.status', '1');
        if($data != 0){
            $this->db->where_in("id", $data);
        }
        
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
            
    function updateBank($bankInfo, $id,$type='')
    {
        if($type=='partner'){
            $this->db->where('id', $id);
            $res = $this->db->update('crm_banks', $bankInfo);
        }elseif($type=='all'){
            $this->db->where('bank_id', $id);
            $res = $this->db->update('crm_customer_banklist', $bankInfo);   
        }
        if($bankInfo['status'] != 1){
            $this->db->select('b.bank_id');
            $this->db->from('crm_banks as b');
            $this->db->where('b.id', $id);
            $query = $this->db->get();
            $result = $query->row();
            
            $this->db->where('bank_id', $result->bank_id);
            $res = $this->db->update(BANK_EMP_LIMIT_MAPPING, array('status'=>0));   
        }
        return $id;
    }

    function getBankIdnotin($data='')
    {
                   
        $this->db->select('distinct(b.id),b.bank_name,b.logo,cb.bank_id');
        $this->db->from('crm_bank_list as b');
        $this->db->join('crm_banks as cb','cb.bank_id=b.id','inner');
        $this->db->where('b.status', '1');
            $this->db->where('cb.status', '1');
        if($data != 0){
            $ids = explode(',', $data);
            $this->db->where_not_in("b.id", $ids);
        }
        
        $query = $this->db->get();
        $result = $query->result_array();
        //echo $this->db->last_query(); exit; 
        return $result;
    }
    function getAllBankId()
    {
                   
        $this->db->select('b.id,b.bank_name,b.logo,cb.bank_id');
        $this->db->from('crm_bank_list as b');
        $this->db->join('crm_banks as cb','cb.bank_id=b.id','inner');
        $this->db->where('b.status', '1');
        $query = $this->db->get();
        $result = $query->result_array();
       // echo $this->db->last_query(); exit; 
        return $result;
    }

    function getBankNameBybnkId($id='')
    {
        $this->db->select('b.id,b.bank_name,b.logo');
        $this->db->from('crm_bank_list as b');
        $this->db->join('crm_banks as cb','cb.bank_id=b.id','inner');
        $this->db->where('b.status', '1');
         $this->db->where('cb.status', '1');
        if(!empty($id)){
             $this->db->where("b.id", $id);
        }
       
        
        $query = $this->db->get();
        $result = $query->result_array();
        //print_r($result);
        //echo $this->db->last_query(); exit; 
         if(!empty($id)){
            return $result[0];
        }
        else
        {
             return $result;
        }
        
    }
    
    function getBanklist(){
        $this->db->select('b.*');
        $this->db->from('crm_bank_list as b');
        $this->db->join('crm_banks as cb','cb.bank_id=b.id','inner');
        $this->db->where('b.status', '1');
        $this->db->where('cb.status', '1');
       // $this->db->where('b.status', '1');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    public function getEmpBankInfo($emp_id='',$bnk_id='')
    {
        if($emp_id!=''){
          $this->db->where('bm.emp_id',$emp_id);  
      }if($bnk_id!=''){
              $this->db->where('bm.bank_id',$bnk_id);  
      }

        $this->db->where('bm.status','1');
        $this->db->from('bank_employee_limit_mapping as bm');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        $result = $query->result_array();
        return $result;
    }
    public function getEmpBankName($emp_id,$id)
    {
        $bank_id=explode(',',$id);
        $this->db->select('bm.bank_id as id,cb.bank_name');
        $this->db->where('bm.emp_id',$emp_id);
        $this->db->where('bm.status','1');
        $this->db->from('bank_employee_limit_mapping as bm');
        $this->db->join('crm_bank_list as cb','bm.bank_id=cb.id','inner');
        $this->db->join('crm_banks as b','b.bank_id=cb.id','inner');
        $this->db->where('b.status', '1');
        $this->db->where('cb.status', '1');
        if($bank_id != 0){
            $this->db->where_not_in("bm.bank_id", $bank_id);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getcustomerBankList($id='',$ids=[])
    {
        $bank_id= '';
        if(!empty($ids))
        {
            $bank_id=explode(',',$ids);
        }
        $this->db->select('*');
        $this->db->where('status','1');
        $this->db->from('crm_customer_banklist');
        if($bank_id != 0){
            $this->db->where_not_in("bank_id", $bank_id);
        }
        if(!empty($id))
        {
            $this->db->where_not_in("bank_id", $id);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    } 
    
public function getBankCaseList($requestParams,$page,$limit){
        $responseData   = array();
        $fields         = '*';
        if($requestParams['source']=='1'){
            $fields     =   'b.*,cbl.bank_name';
        } else if($requestParams['source']=='2'){
            $fields     =   "b.*"; 
        }

        if($requestParams['source']=='1'){
            $this->db->select($fields);
            $this->db->from('crm_banks as b');
            $this->db->join('crm_bank_list  as cbl', 'cbl.id=b.bank_id','left');
           // $this->db->where('b.status ','1');
        } else if($requestParams['source']=='2'){
            $this->db->select($fields);
            $this->db->from('crm_customer_banklist as b');
        }
        
        $this->db   = $this->bankGetFilter($requestParams,$this->db);

        if (isset($page))
        {
            $offset     = ($page - 1) * $limit;
            $this->db->offset((int) ($offset));
        }
        if (!empty($limit))
        {
            $this->db->limit((int) $limit);
        }
        if($requestParams['source']=='1'){
        $this->db->order_by('b.id','DESC');
        }else if($requestParams['source']=='2'){
         $this->db->order_by('b.bank_id','DESC');   
        }
        $query      = $this->db->get(); 
       // echo $this->db->last_query(); exit;
        $getleads   = $query->result_array();
        $leads = array();
        if (!empty($getleads)) {
            $i = 0;
            foreach ($getleads as $key => $val) {
                if($requestParams['source']=='1'){
                    $leads[$i]['id']            =       $val['id'];
                    $leads[$i]['bank_id']             =       $val['bank_id'];
                    $leads[$i]['bank_name']             =       $val['bank_name'];
                    $leads[$i]['branch_name']              =       $val['branch_name'];
                    $leads[$i]['amount_limit']             =       $val['amount_limit'];
                    $leads[$i]['status']           =       $val['status'];
                    
                } else if($requestParams['source']=='2'){
                    $leads[$i]['id']                =       $val['id'];
                    $leads[$i]['bank_id']             =       $val['bank_id'];
                    $leads[$i]['bank_name']              =       $val['bank_name'];
                    $leads[$i]['branch_name']            =       $val['branch_name'];
                    $leads[$i]['amount_limit']        =       $val['amount_limit'];
                    $leads[$i]['status']      =       $val['status'];
                }
                $i++;
            }
        }
        
        return $leads;
    }
    
    public function bankGetFilter($requestParams,$select) {
        if($requestParams['source']=='1'){

            if(isset($requestParams['bstatus']) && ($requestParams['bstatus']!='')){
                $select->where('b.status ',$requestParams['bstatus']);
            }

            if (isset($requestParams['search_by']) && $requestParams['search_by'] != '') {
                $select->where("(cbl.bank_name like '%" . trim($requestParams['search_by']) . "%')");
            }

        } else if($requestParams['source']=='2'){
            if(isset($requestParams['bstatus']) && ($requestParams['bstatus']!='')){
                $select->where('b.status ',$requestParams['bstatus']);
            }
            if (isset($requestParams['search_by']) && $requestParams['search_by'] != '') {
                $select->where("(b.bank_name like '%" . trim($requestParams['search_by']) . "%')");
            }
        }

        return $select;
    }
    
    function checkDuplicateCustomerBank($bankInfo,$type,$id){
        $this->db->select('bank_id,bank_name');
        $this->db->where("bank_name",$bankInfo['bank_name']);
        $this->db->where("bank_id !=",$id);
        $query =  $this->db->get('crm_customer_banklist'); 
      
        return $query->row_array();
    }
    function addCustomerBankData($bankInfo, $type, $id) {

        if ($type == 'add') {
            $this->db->insert('crm_customer_banklist', $bankInfo);
            $insert_id = $this->db->insert_id();
            $result = $insert_id;
            return ($result > 0) ? 1 : 0;
        } else if ($type == 'edit') {
            $bank_id = $id;
            $this->db->where('bank_id', $bank_id);
            $res = $this->db->update('crm_customer_banklist', $bankInfo);
            //echo $this->db->last_query(); exit;
            return ($res) ? 1 : 0;
        }
    }

    function getBankNameByName($bankname,$id)
    {
       // return $query = $this->db
        $this->db->select('cbl.id, cbl.bank_name');
        $this->db->join('crm_banks  as cb', 'cbl.id=cb.bank_id','left');
        $this->db->where("cbl.bank_name",$bankname);
        $this->db->where("cb.id !=",$id);
        $query =  $this->db->get('crm_bank_list as cbl'); 
        return $query->row_array();
    }
}
