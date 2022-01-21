<?php
/**
 * model : Crm_outlets
 * User Class to Control all role related Operations .
 * @author : Rakesh kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rolemodel extends CI_Model
{
    public function __construct()
        {
                parent::__construct();
                $this->dateTime=date("Y-m-d H:i:s");
        }
    public function getTotalRole(){
        $status=array('0','1');
        $query = $this->db
            ->select('crm_role.id')
            ->from('crm_role')       
            ->join('crm_team_type','crm_team_type.id=crm_role.team_id','inner')       
            ->where_in('crm_role.status',$status)       
            -> get();
        return $query->num_rows();
        
    }    
    
    public function getRole($id='')
        {
            $status=array('0','1');
            if(!empty($id)){
           return $query = $this->db
            ->select('crm_role.id, crm_role.role_name,crm_role.team_id, crm_role.status, crm_role.created_date, crm_role.updated_date, crm_role.created_by,crm_role.updated_by,crm_team_type.team_name')
            ->from('crm_role')       
            ->join('crm_team_type','crm_team_type.id=crm_role.team_id','inner')       
            ->where('crm_role.id', $id)
            ->where_in('crm_role.status',$status)       
            -> get('')
             ->result_array();
            }else{
            return $query = $this->db
                    ->select('crm_role.id, crm_role.role_name,crm_role.team_id, crm_role.status, crm_role.created_date, crm_role.updated_date, crm_role.created_by,crm_role.updated_by,crm_team_type.team_name')
                    ->from('crm_role')       
                    ->join('crm_team_type','crm_team_type.id=crm_role.team_id','inner')
                    ->where_in('crm_role.status',$status)
                    //->limit($limit, $start)
                    ->get()
            //echo $this->db->last_query();
                    ->result_array();
        }         

        }
    /**
     * This function is used to add new role to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewRole($userInfo, $updateId = '') {
        //print_r($userInfo);exit;
        if (empty($updateId)) {
            $this->db->trans_start();
            $this->db->insert('crm_role', $userInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result= $insert_id;
        } else {
            $this->db->where('id', $updateId);
            $this->db->update('crm_role', $userInfo);
            return $updateId;
        }
        return $result;
    }    
     /*
     * Delete Role
     */
    public function delete($id){
        $data['status']='2';
        $delete = $this->db->update('crm_role',$data,array('id'=>$id));
        return $delete?true:false;
    } 
    
    public function updateRoleStatus($roleInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('crm_role', $roleInfo);
        //echo $this->db->last_query();die;
        return TRUE;
    }
    
    public function getRoleNameByteam(){
        $this->db->select('r.id,r.role_name');
        $this->db->from('crm_role r');
        $this->db->join('crm_team_type t','t.id=r.team_id','inner');
        $this->db->where('t.team_name', "Insurance");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
            
    }
    public function getRoleNameById($id){
        $this->db->select('r.id,r.role_name');
        $this->db->from('crm_role r');
        $this->db->where('r.id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
            
    }
}
