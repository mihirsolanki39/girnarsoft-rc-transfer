<?php

/**
 * model : Crm_outlets
 * User Class to list Team .
 * @author : Rakesh kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teamlist extends CI_Model {

    public function __construct() {
        
    }

    /**
     * This function is used to add new Role to system
     * @return number $insert_id : This is last inserted id
     */
    public function getTeamlist() {
       $status=array('0','1'); 
       return $result= $this->db->select('id as teamId,team_name')
       ->from('crm_team_type')
       ->where_in('status',$status) 
       ->get()
       ->result();       
    }

}

?>
