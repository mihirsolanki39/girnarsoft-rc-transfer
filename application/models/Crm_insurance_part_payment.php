<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Crm_insurance_part_payment extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getTable() {
        return 'crm_insurance_part_payment';
    }
    
     public function addInsurancePartPayment($userInfo, $partPaymentId = '',$customerId){
        if (empty($partPaymentId)) {
                $this->db->insert( $this->getTable() , $userInfo);
            } else {
                $this->db->where('id', $partPaymentId);
                $this->db->update($this->getTable(), $userInfo);
           }
           //echo $this->db->last_query();die;
           $PaymentDetails = $this->Crm_insurance_part_payment->getCustomerPaymentDetails($userInfo['customer_id'] ,$partPaymentId);
           if(!empty($PaymentDetails)){
             if(!empty(current($PaymentDetails)['total_amount_paid'])){
              
              if( current($PaymentDetails)['total_amount_paid'] == current($PaymentDetails)['totalpremium'] ){
                    $data = ['is_payment_completed' => 1];
              }else $data = ['is_payment_completed' => 0];
              try {
                    $this->db->where('id', $userInfo['customer_id']);
                    $ret = $this->db->update('crm_insurance_customer_details', $data);
              } catch (Exception $e) {
            } 
          $this->load->model('Crm_renew');
          $IsPaymentCompleted = $this->Crm_renew->IsPaymentCompleted($customerId);
          if(!empty($IsPaymentCompleted) && $IsPaymentCompleted['isInhouseCase']==true){
            $renewcaseArr=[];
            $renewcaseArr['follow_status']=$IsPaymentCompleted['follow_status'];
            $this->Crm_insurance->updateInsuranceCase($renewcaseArr,$customerId);
            $data['caseData']=current($this->Crm_insurance->getCaseDetailsByCustomerId($customerId));
            $renewdata=[];
            $renewdata['activity']=$IsPaymentCompleted['follow_status'];
            $renewdata['case_id']=$data['caseData']['id'];
            $renewdata['user_id']=isset($this->session->userdata['userinfo']['id']) ? $this->session->userdata['userinfo']['id']:'';
            $this->Crm_renew->addUpdateHistory($renewdata);
           }
          }
        }

        return $userInfo['customer_id'];
    }

    public function getCustomerPartPayment($customer_id,$partpaymentId='')
    {
       $this->db->select('cpp.*,cb.bank_name as bankname,pr.reason');
       $this->db->from('crm_insurance_part_payment cpp');
       $this->db->join('crm_customer_banklist as cb','cb.bank_id=cpp.bank_name','left');
       $this->db->join('crm_insurance_payment_reason as pr','cpp.reasonId=pr.reasonId','left');
       $this->db->where('cpp.customer_id', $customer_id);

       if(!empty($partpaymentId)){
        $this->db->where('cpp.id', $partpaymentId);
       }
       
       $query = $this->db->get();
       $result = $query->result_array();

       $partPayments = [];
       if(!empty($result)){
        foreach ($result as $key => $partPayment) {
            $partPayments[$partPayment['entry_type']][] = $partPayment;
        }
       }
       // echo $this->db->last_query();die;
       return  $partPayments; 
    }
    public function getCustomerPaymentDetails($customer_id,$partpaymentId='',$flag="")
    {
       $this->db->select('SUM(amount) as total_amount_paid,SUM(subvention_amt) as total_subvention, iq.totpremium as totalpremium');
       $this->db->from('crm_insurance_part_payment cpp');
       $this->db->join('crm_insurance_quotes as iq', 'iq.customer_id=cpp.customer_id and iq.flag="1"','left');
       $this->db->where('cpp.customer_id', $customer_id);
       $this->db->where('cpp.entry_type IN(1,2,3)');
       if(!empty($partpaymentId) && $flag != 1)
       $this->db->where('cpp.id NOT IN('.$partpaymentId.')');
       $query = $this->db->get();
       $result = $query->result_array();
       // echo $this->db->last_query();die;
       return $result; 
    }
    public function getInhousePaidAmount($customer_id,$partpaymentId='')
    {
       $this->db->select('SUM(amount) as inhouse_paid_amt');
       $this->db->from('crm_insurance_part_payment cpp');
       // $this->db->join('crm_insurance_quotes as iq', 'iq.customer_id=cpp.customer_id and iq.flag="1"','left');
       // die($customer_id);
       $this->db->where('cpp.customer_id', $customer_id);
       $this->db->where('cpp.entry_type IN(2)');
       if(!empty($partpaymentId))
       $this->db->where('cpp.id NOT IN('.$partpaymentId.')');
       $query = $this->db->get();
       $result = $query->result_array();
       // echo $this->db->last_query();die;
       return  $result; 
    }
    public function getPaidAmountbyType($customer_id,$partpaymentId='',$type)
    {
       $this->db->select('SUM(amount) as paid_amt_type');
       $this->db->from('crm_insurance_part_payment cpp');
       $this->db->where('cpp.customer_id', $customer_id);
       $this->db->where('cpp.entry_type IN('.$type.')');
       if(!empty($partpaymentId))
       $this->db->where('cpp.id NOT IN('.$partpaymentId.')');
       $query = $this->db->get();
       $result = $query->result_array();
       // echo $this->db->last_query();die;
       return  $result; 
    }

    public function completePayment($data,$customerId,$current_policy_no)
    {
      $updatestatus=[];
      try {
          $this->db->where('id', $customerId);
          $ret = $this->db->update('crm_insurance_customer_details', $data);
          $updatestatus['last_updated_status'] = 6;
          if($data['is_payment_completed']=='1')
          {
              if(!empty($current_policy_no))
                   $updatestatus['last_updated_status'] = 9;
              else
                   $updatestatus['last_updated_status'] = 5;
          }
          $this->db->where('customer_id', $customerId);
          $ret = $this->db->update('crm_insurance_case_details', $updatestatus);
          return $ret?true:false;
        } catch (Exception $e) {
          return false;
      }
    }
    
     public function changesStatus($data,$customerId)
    {
      $updatestatus=[];
      try {
//          $this->db->where('id', $customerId);
//          $ret = $this->db->update('crm_insurance_customer_details', $data);
          $updatestatus['last_updated_status'] = 6;
          if($data['is_payment_completed']=='1') 
              $updatestatus['last_updated_status'] = 6;
          else if($data['is_payment_completed']=='2') 
               $updatestatus['last_updated_status'] = 5;
          else if($data['is_payment_completed']=='3') 
               $updatestatus['last_updated_status'] = 9;
          $this->db->where('customer_id', $customerId);
          $ret = $this->db->update('crm_insurance_case_details', $updatestatus);
          return $ret?true:false;
        } catch (Exception $e) {
          return false;
      }
    }

    public function getPaymentStatus($customerId)
    {
      try {
       $PaymentStatuses = []; 
       $this->load->model('Crm_insurance');
       $caseDetails = $this->Crm_insurance->getCaseDetailsByCustomerId($customerId);
       $last_updated_status = $caseDetails[0]['last_updated_status']; 
       $follow_status = $caseDetails[0]['follow_status']; 
       $PaymentStatuses['last_updated_status'] = $last_updated_status;
       $PaymentStatuses['follow_status'] = $follow_status;
       if(empty($last_updated_status))
        return false;
       
       $premiumAmt = $this->Crm_insurance->getCustomerInfo($customerId)[0]['totalpremium']; 
       $clearance = $this->getPaidAmountbyType($customerId,'','4');
       $inhouse = $this->getPaidAmountbyType($customerId,'','2');
       $CustomerTotalPaid = $this->getPaidAmountbyType($customerId,'','1,3,2');
       if( !empty($inhouse[0]['paid_amt_type']) ){

         if( !empty($CustomerTotalPaid[0]['paid_amt_type']) || $CustomerTotalPaid[0]['paid_amt_type']==0){
           $isInsurancePaymentCompleted = ( ($premiumAmt == $CustomerTotalPaid[0]['paid_amt_type']) || ($last_updated_status == 5) )? true : false ;

           $PaymentStatuses['isInsurancePaymentCompleted'] = $isInsurancePaymentCompleted;
         }else $PaymentStatuses['isInsurancePaymentCompleted'] = false;
         
         if(!empty($clearance[0]['paid_amt_type']) || $clearance[0]['paid_amt_type'] == 0 ){

           $isClearanceComplete = ( ( ((int)$inhouse[0]['paid_amt_type'] == (int)$clearance[0]['paid_amt_type']) && ($last_updated_status == 6) ) || ( ((int)$inhouse[0]['paid_amt_type'] >= (int)$clearance[0]['paid_amt_type']) && ($last_updated_status == 5) ) )? true : false ; 
           $PaymentStatuses['isClearanceComplete'] = $isClearanceComplete;
         }else $PaymentStatuses['isClearanceComplete'] = false;
         $PaymentStatuses['isInhouseCase'] = true;
       }else $PaymentStatuses['isInhouseCase'] = false;
       return $PaymentStatuses;
      } catch (Exception $e) {
       return false;          
      }
    }

}
