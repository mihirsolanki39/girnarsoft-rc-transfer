<?php

/**
 * model : Crm_outlets
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Crm_buy_customer_status extends CI_Model {

    public function __construct() {
        
    }

    public function getCustomerStatus($notIn=[]) {
//        $query = $this->db->get_where('crm_buy_customer_status', array('parent' => '0', 'active' => 'yes'));
//        $result = $query->result(); 
        $this->db->select('crm_buy_customer_status.*');
        $this->db->from('crm_buy_customer_status');
        $this->db->where('parent','0');
        $this->db->where('active','yes');
        if(!empty($notIn)){
        $this->db->where_not_in('id',$notIn);
        }
       $query = $this->db->get();
       $result = $query->result_object();
       return $result;
    }
    
    function validate_status_by_followDate($pstatus, $pfollow, $nstatus, $nfollow, $comment = '') {
        $currentDate = time();
        if (($nfollow == '' || $nfollow == 0) && $comment != '') {
            if ($nfollow >= $currentDate) {
                $returnvale = 0;
            } else {
                $returnvale = 1;
            }
        } else if ($nfollow == $pfollow && $pstatus == $nstatus) {
            $returnvale = 0;
        } else if ($nstatus == 'Walked-In' || $nstatus == 'Booked' || $nstatus == 'Converted' || $nstatus == 'Closed') {
            $returnvale = 0;
        } else if ($nstatus == 'Hot' || $nstatus == 'Warm' || $nstatus == 'Cold' || $nstatus == 'WalkInScheduled') {
            if ($nfollow != '') {
                if ($nfollow >= $currentDate) {
                    $returnvale = 0;
                } else {
                    $returnvale = 1;
                }
            } else {
                $returnvale = 0;
            }
        } else if ($nstatus == '' && $nfollow != '') {
            if ($nfollow >= $currentDate) {
                $returnvale = 0;
            } else {
                $returnvale = 1;
            }
        } else {
            $returnvale = 0;
        }
        return $returnvale;
    }
    
    public function getLeadsStatusbyName($statusName) {
        $statusName=strtolower($statusName);
        
         $query = $this->db->get_where('crm_buy_customer_status', array('parent' => '0', 'status_name' => $statusName));
        $result = $query->result();  
        return $result;
    }
    
    public function mappOldToNew($oldStatus,$followDate='')
    {
        $oldStatus=trim($oldStatus);
        $status                = array();
        if($oldStatus == 'Hot' || $oldStatus == 'Cold' || $oldStatus == 'Warm')
        {
            $status['ldm_lead_rating']      = $oldStatus;
            $oldStatus = 'Interested';
        }
        elseif($oldStatus == 'WalkInScheduled')
        {
            $oldStatus = 'Walk-in Scheduled';
        }
        elseif($oldStatus == 'Walked- In' || $oldStatus == 'Walked-In' || $oldStatus == 'Walked-in')
        {
            $oldStatus = 'Walk-in Done';
        }
        elseif($oldStatus == 'Follow Up')
        {
            $oldStatus = 'Follow Up';
        }
        elseif($oldStatus == 'Walk In')
        {
            $oldStatus = 'Walk In';
        }
        elseif($oldStatus == 'Interested')
        {
            $oldStatus = 'Interested';
        }
        elseif($oldStatus == 'Walk-in Scheduled')
        {
            //$oldstatus = 'Walk In';
            $oldStatus = 'Walk-in Scheduled';
        }
        elseif($oldStatus == 'Walk-in Done')
        {
            $oldStatus = 'Walk-in Done';
        }
        elseif($oldStatus == 'Booked' || $oldStatus == 'Converted' || $oldStatus == 'Closed' || $oldStatus == 'Customer Offer' || $oldStatus == 'New')
        {
            $oldStatus = $oldStatus;
        }
        else
        {
            $oldStatus = 'New';
        }
        
        $getLeadsStatus=$this->getLeadsStatusbyName($oldStatus);
        //echo "<pre>";print_r($getLeadsStatus);exit;
        $status['statusId']    = $getLeadsStatus[0]->id;
        $status['status_name'] = $getLeadsStatus[0]->status_name;
        return $status;
    }
    
    public function getLeadsStatusbyId($statusId) {
        $query = $this->db->get_where('crm_buy_customer_status', array('id' => $statusId));
        //echo $this->db->last_query();die;
        $result = $query->result();  
        return $result;
    }

}

