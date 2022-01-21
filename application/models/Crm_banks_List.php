<?php

/**
 * model : Crm_Bank
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_banks_List extends CI_Model {

    public function __construct() {
        
    }

    function crmBankList($id='') {
        $bankDetails = $this->crm_banks->BankListings();
        $exitsingId = '';
        $notIn =[];
        foreach ($bankDetails as $key => $value) {
        $exitsingId.="" . $value->bank_id . ",";
        }
        $returnId = substr($exitsingId, 0, -1);
        if(!empty($returnId)){
            $notIn =  explode(',', $returnId);
        }
        if(!empty($id)){
         $search =array_search($id, $notIn);
         unset($notIn[$search]);
        }
        $this->db->select('b.*');
        $this->db->from('crm_bank_list as b');
        $this->db->where('b.status', '1');
        if(!empty($notIn)){
        $this->db->where_not_in('b.id', $notIn);
        }
        $query = $this->db->get();
        $result = $query->result();
       // echo $this->db->last_query();die;
        return $result;
    }
    function crmBankName($id='') {
        $this->db->select('b.*');
        $this->db->from('crm_bank_list as b');
        $this->db->where('b.status', '1');
        if(!empty($id)){
        $this->db->where('b.id', $id);
        }
        $query = $this->db->get();
        $result = $query->result();
        //echo $this->db->last_query();die;
        return $result;
    }

    
    
    

}


