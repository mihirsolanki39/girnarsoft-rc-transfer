<?php
/**
 * model : Crm_outlets
 * User Class to Control all team related Operations .
 * @author : Rakesh kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teammodel extends CI_Model
{
    public function __construct()
        {
                parent::__construct();
                $this->dateTime=date("Y-m-d H:i:s");
        }
    public function teamListingCount()
        {
            $status=array('0','1');
            
           return $query = $this->db
            ->select('id, team_name, status, created_date, updated_date, created_by')
            //->where('id', $id)
            ->where_in('status',$status)       
            -> get('crm_team_type')
             ->num_rows();
            

        }    
    
    public function getTeam($id='',$page='',$segment='')
        {
            $status=array('0','1');
            if(!empty($id)){
           return $query = $this->db
            ->select('id, team_name, status, created_date, updated_date, created_by')
            ->where('id', $id)
            ->where_in('status',$status)       
            -> get('crm_team_type')
             ->result_array();
            }else{
            return $query = $this->db
                    ->select('id, team_name, status, created_date, updated_date, created_by')
                    ->where_in('status',$status)
                    ->limit($page, $segment)
                    ->get('crm_team_type')
            //echo $this->db->last_query();
                    ->result_array();
        }         

        }
    /*
     * Insert Team
     */
    public function insert($data = array()) {
        $insert = $this->db->insert('crm_team_type', $data);
        if($insert){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    
    /*
     * Update Team
     */
    public function update($id,$data) {
        if(!empty($data) && !empty($id)){
            $update = $this->db->update('crm_team_type', $data, array('id'=>$id));
            return $update?true:false;
        }else{
            return false;
        }
    }
    
    /*
     * Delete Team
     */
    public function delete($id){
        $data['status']='2';
        $delete = $this->db->update('crm_team_type',$data,array('id'=>$id));
        return $delete?true:false;
    } 
    
    function updateTeamStatus($teamInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('crm_team_type', $teamInfo);
        return TRUE;
    }

    function getTeamNameByName($teamname)
    {
       // return $query = $this->db
        $this->db->select('id, team_name, status, created_date, updated_date, created_by');
        $this->db->where("team_name LIKE '%$teamname%'");
        $query =  $this->db->get('crm_team_type');
        //echo $this->db->last_query(); exit;
        return $query->result_array();
    }
}
