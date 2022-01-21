<?php

/**
 * model : Crm_insurance
 * User Class to control all insurance related operations.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_used_car_sale_case_info extends CI_Model
{

    private $dateTime = '';
    private $zero     = 0;
    private $date     = '';

    public function __construct()
    {
        parent::__construct();
        $this->dateTime = date("Y-m-d H:i:s");
    }

    public function getUcSalesCaseInfo($id = 0)
    {
        //echo $id;die;
        $this->db->select('usc.*,uc.reg_no,mm.make,mm.model,mv.db_version version,t.amount sale_amount,t.advance_payment booking_amount');
        $this->db->from('crm_used_car_sale_case_info as usc');
        $this->db->join('crm_used_car as uc','usc.car_id=uc.id','left');
        $this->db->join('model_version as mv', 'mv.db_version_id=uc.version_id', 'left');
        $this->db->join('make_model as mm', 'mm.id = mv.model_id', 'left');
        $this->db->join('crm_uc_sales_transactions t ', 't.uc_sales_case_id = usc.id', 'left');
        $this->db->where('usc.id', (int)$id);
        $this->db->where('usc.status', '1');
        $query  = $this->db->get();
        $result = $query->row_array();
       //echo $this->db->last_query();die;
        //print_r($result);die;
        return $result;
    }

    public function addBuyerDetails($data)
    {
        $leadcustomer = [];
        $leaddata     = [];
        $saleData     = [];
        
        $case_id = $data['caseId'];
        if (!empty($data['customer_mobile']))
        {
            //CENTRAL CUSTOMER
            $central_customer_id = $this->isCentralCustomer($data['customer_mobile']);
            if (empty($central_customer_id))
            {
                $central_customer_id = $this->addToCentralCustomer(['customer_mobile' => $data['customer_mobile']]);
            }
            //BUYER LEAD CUSTOMER
            $leadcustomerId = $this->getcustomerLeadId($data['customer_mobile']);
            if (empty($leadcustomerId))
            {
                $leadcustomer['mobile']              = $data['customer_mobile'];
                $leadcustomer['central_customer_id'] = $central_customer_id;
                $leadcustomerId                      = $this->addNewleadCustomer($leadcustomer);
            }
            else{
               $this->db->where('id', $leadcustomerId);
               $this->db->update('crm_buy_lead_customer', ['central_customer_id' => $central_customer_id]);
            }
            //BUYER LEAD
            if ($leadcustomerId)
            {
                $ldmId = $this->iscustomerLeadIdById($leadcustomerId);
                if ($ldmId)
                {
                    $leaddata['ldm_name']  = $data['customer_name'];
                    isset($data['customer_email'])?$leaddata['ldm_email'] =$data['customer_email']:'';
                    $this->db->where('ldm_customer_id', $leadcustomerId);
                    $this->db->update('crm_buy_lead_dealer_mapper', $leaddata);
                    $leadDealerMapperId    = $ldmId;
                }
                else
                {
                    $leaddata['ldm_customer_id']  = $leadcustomerId;
                    $leaddata['ldm_dealer_id']    = DEALER_ID;
                    $leaddata['ldm_name']         = $data['customer_name'];
                    $leaddata['ldm_email']        = $data['customer_email'];
                    $leaddata['ldm_status_id']    = isset($data['status_id']) ? $data['status_id'] : '';
                    $leaddata['ldm_source']       = isset($data['lead_source']) ? $data['lead_source'] : '';
                    $leaddata['ldm_sub_source']   = isset($data['lead_sub_source']) ? $data['lead_sub_source'] : '';
                    $leaddata['ldm_follow_date']  = isset($data['follow_date']) ? $data['follow_date'] : '';
                    $leaddata['ldm_created_date'] = $this->dateTime;
                    $leaddata['ldm_update_date'] = $this->dateTime;
                    $this->db->insert('crm_buy_lead_dealer_mapper', $leaddata);
                    $leadDealerMapperId          = $this->db->insert_id();
                }
                //LEAD CAR MAPPING
                $lcd_id=$this->setBuyLeadCarDetail(['lead_id'=>$leadDealerMapperId,'car_id'=>$data['car_id']]);
                //USED CAR SALES LEAD CASE
                //$case_id          = $this->isUsedCarSaleLeadIdById($leadDealerMapperId);
                
                //$caseDetails  = $this->getUcSalesCaseInfo($case_id);
                
                
                
                $data['ldm_id']   = $leadDealerMapperId;
                $uc_sale_case_id = $this->addUpdateUsedCarSale($data, $case_id);

                return $uc_sale_case_id;
            }
        }
        else
        {
            return false;
        }
    }

    public function addNewleadCustomer($userInfo)
    {
        $this->db->insert('crm_buy_lead_customer', $userInfo);
        $insert_id = $this->db->insert_id();
        //echo $this->db->last_query();die;
        return $result    = $insert_id;
    }

    public function getcustomerLeadId($mobile)
    {
        $this->db->select('lc.id as leadId');
        $this->db->from('crm_buy_lead_customer as lc');
        $this->db->where('lc.mobile', $mobile);
        $query  = $this->db->get();
        $result = $query->row_array();
        return !empty($result['leadId']) ? $result['leadId'] : '';
    }

    public function isUsedCarSaleLeadIdById($leadId)
    {
        $this->db->select('ucs.id as case_id');
        $this->db->from('crm_used_car_sale_case_info as ucs');
        $this->db->where('ucs.ldm_id', $leadId);
        $query  = $this->db->get();
        $result = $query->row_array();
        return !empty($result['case_id']) ? $result['case_id'] : '';
    }

    public function iscustomerLeadIdById($customer_id)
    {
        $this->db->select('ldm.ldm_id as leadId');
        $this->db->from('crm_buy_lead_dealer_mapper as ldm');
        $this->db->where('ldm.ldm_customer_id', $customer_id);
        $query  = $this->db->get();
        $result = $query->row_array();
        return !empty($result['leadId']) ? $result['leadId'] : '';
    }

    public function addUpdateUsedCarSale($data, $case_id = '')
    {
        if (!empty($case_id))
        {
            $saleData['ldm_id']                    = $data['ldm_id'];
           // $saleData['car_id']                    = $data['car_id'];
            $saleData['customer_name']             = $data['customer_name'];
            $saleData['company_name']              = isset($data['customer_company_name'])?$data['customer_company_name']:'';
            $saleData['customer_mobile']           = isset($data['customer_mobile'])?$data['customer_mobile']:'';
            $saleData['customer_email']            = isset($data['customer_email'])?$data['customer_email']:'';
            $saleData['customer_address']          = isset($data['customer_address'])?$data['customer_address']:'';
            $saleData['customer_driving_lic_no']   = isset($data['driving_license_no'])?$data['driving_license_no']:'';
            $saleData['customer_reference']        = isset($data['reference_of'])?$data['reference_of']:'';
            $saleData['source_category_id']        = isset($data['category_source_id'])?$data['category_source_id']:'';
            $saleData['source_id']                 = isset($data['source_id'])?$data['source_id']:'';
            $saleData['customer_relation']         = isset($data['customer_relation'])?$data['customer_relation']:'';
            $saleData['customer_relation_name']    = isset($data['relation_name'])?$data['relation_name']:'';
            $saleData['customer_relation_address'] = isset($data['relation_address'])?$data['relation_address']:'';
            $saleData['buyer_type']                = isset($data['buyer_type'])?$data['buyer_type']:'';
            $saleData['is_buyer_details_completed']= '1';
            $this->db->where('id', $case_id);
            $this->db->update('crm_used_car_sale_case_info', $saleData);
            $usedCarSaleId                         = $case_id;
        }
        else
        {
            $saleData['ldm_id']                    = $data['ldm_id'];
            $saleData['car_id']                    = $data['car_id'];
            $saleData['customer_name']             = isset($data['customer_name'])?$data['customer_name']:'';
            $saleData['company_name']              = isset($data['customer_company_name'])?$data['customer_company_name']:'';
            $saleData['customer_mobile']           = isset($data['customer_mobile'])?$data['customer_mobile']:'';
            $saleData['customer_email']            = isset($data['customer_email'])?$data['customer_email']:'';
            $saleData['customer_address']          = isset($data['customer_address'])?$data['customer_address']:'';
            $saleData['customer_driving_lic_no']   = isset($data['driving_license_no'])?$data['driving_license_no']:'';
            $saleData['customer_reference']        = isset($data['reference_of'])?$data['reference_of']:'';
            $saleData['source_category_id']        = isset($data['category_source_id'])?$data['category_source_id']:'';
            $saleData['source_id']                 = isset($data['source_id'])?$data['source_id']:'';
            $saleData['customer_relation']         = isset($data['customer_relation'])?$data['customer_relation']:'';
            $saleData['customer_relation_name']    = isset($data['relation_name'])?$data['relation_name']:'';
            $saleData['customer_relation_address'] = isset($data['relation_address'])?$data['relation_address']:'';
            $saleData['buyer_type']                = isset($data['buyer_type'])?$data['buyer_type']:'';
            $saleData['status']                    = '1';
            $saleData['addDate']                   = $this->dateTime;
            $saleData['is_buyer_details_completed']= '1';

            $this->db->insert('crm_used_car_sale_case_info', $saleData);
            $usedCarSaleId = $this->db->insert_id();
        }
        return $usedCarSaleId;
    }

    public function addToCentralCustomer($info)
    {
        $data['mobile']       = $info['customer_mobile'];
        //$data['date_time']    = date('Y-m-d H:i:s');
        //$data['updated_date'] = date('Y-m-d H:i:s');
        $data['created_date']    = date('Y-m-d H:i:s');
        $data['module']    = 'Stock';
        $data['status']    = '1';

        $this->db->insert('crm_customers', $data);
        return $this->db->insert_id();
    }

    public function isCentralCustomer($customer_mobile)
    {
        $this->db->select('id');
        $this->db->from('crm_customers');
        $this->db->where('mobile', $customer_mobile);
        $query  = $this->db->get();
        $result = $query->row_array();
        return !empty($result['id']) ? $result['id'] : '';
    }

    function getBuyLeadCarDetail($lead_deale_mapp_id, $car_id)
    {

        $query = $this->db->get_where('crm_buy_lead_car_detail', array('lcd_lead_dealer_mapper_id' => $lead_deale_mapp_id, 'lcd_car_id' => $car_id));
        return $query->row_array();
    }

    function setBuyLeadCarDetail($requestParams)
    {

        $getBuyLeadCarDetail = $this->getBuyLeadCarDetail($requestParams['lead_id'], $requestParams['car_id']);

        $buyLeadCarDetail                     = array();
        $buyLeadCarDetail['lcd_updated_date'] = $this->dateTime;
        if (!empty($getBuyLeadCarDetail))
        {
            $buyLeadCarDetail['lcd_favourite']  = ((isset($requestParams['favourite'])) ? $requestParams['favourite'] : $getBuyLeadCarDetail['lcd_favourite']);
            $buyLeadCarDetail['sell_amount']    = (!empty($requestParams['sale_amount']) && $requestParams['sale_amount'] > 0 ? $requestParams['sale_amount'] : $getBuyLeadCarDetail['sell_amount']);
            $buyLeadCarDetail['booking_amount'] = (!empty($requestParams['booking_amount']) && $requestParams['booking_amount'] > 0 ? $requestParams['booking_amount'] : $getBuyLeadCarDetail['booking_amount']);
            $buyLeadCarDetail['offer_amount']   = (!empty($requestParams['offer_amount']) && $requestParams['offer_amount'] > 0 ? $requestParams['offer_amount'] : $getBuyLeadCarDetail['offer_amount']);
            
            $this->db->where('lcd_lead_dealer_mapper_id', $requestParams['lead_id']);
            $this->db->where('lcd_car_id', $requestParams['car_id']);
            $this->db->update('crm_buy_lead_car_detail', $buyLeadCarDetail);
            $inserted_id                        = $getBuyLeadCarDetail['lcd_id'];
        }
        else
        {
            $this->updateIsLatest($requestParams['lead_id']);
            
            $buyLeadCarDetail['lcd_favourite']             = '1';
            $buyLeadCarDetail['lcd_active']                = '1';
            $buyLeadCarDetail['lcd_car_id']                = !empty($requestParams['car_id']) ? $requestParams['car_id'] : '';
            $buyLeadCarDetail['lcd_lead_dealer_mapper_id'] = !empty($requestParams['lead_id']) ? $requestParams['lead_id'] : '';
            $buyLeadCarDetail['lcd_model_id']              = !empty($requestParams['model_id']) ? $requestParams['model_id'] : '';
            $buyLeadCarDetail['lcd_version_id']            = !empty($requestParams['version_id']) ? $requestParams['version_id'] : '';
            $buyLeadCarDetail['lcd_source']                = !empty($requestParams['source']) ? $requestParams['source'] : '';
            $buyLeadCarDetail['lcd_sub_source']            = !empty($requestParams['sub_source']) ? $requestParams['sub_source'] : '';
            $buyLeadCarDetail['lcd_is_latest']             = '1';
            $buyLeadCarDetail['lcd_date_time']             = $this->dateTime;
            $this->db->insert('crm_buy_lead_car_detail', $buyLeadCarDetail);
            $inserted_id                                   = $this->db->insert_id();
        }
        

        return $inserted_id;
    }

    public function updateIsLatest($leadId)
    {
        $updateCarData = [
            'lcd_is_latest' => '0',
        ];
        $this->db->where('lcd_lead_dealer_mapper_id', $leadId);
        $this->db->update('crm_buy_lead_car_detail', $updateCarData);
        return $leadId;
    }
    
    public function getCustomerDetails($car_id){
        $this->db->select('ldm.ldm_name,ldm.ldm_email,ldm.ldm_alt_mobile,lcd.lcd_source,lcd.lcd_sub_source,blc.mobile');
        $this->db->from('crm_buy_lead_car_detail as lcd');
        $this->db->join('crm_buy_lead_dealer_mapper as ldm','ldm.ldm_id = lcd.lcd_lead_dealer_mapper_id','inner');
        $this->db->join('crm_buy_lead_customer as blc','blc.id = ldm.ldm_customer_id','left');
        $this->db->where('lcd.lcd_car_id',$car_id);
        $this->db->order_by('lcd.lcd_id','desc');
        $this->db->limit(1);
        $query  = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
    
    public function getSalesStatus($case_id)
    {
        $case_id=!empty($case_id)?$case_id:0;
 
        $result = $this->db->query("SELECT sc.is_buyer_details_completed case_id,sc.car_id,sc.is_vehicle_images_uploaded,sc.is_buyer_docs_uploaded,sc.is_tranx_details_completed trnx_id ,sc.is_booking_details_completed booking_id,sc.is_payment_details_completed payment_id,sc.is_delivery_details_completed delivery_id
                                    FROM crm_used_car_sale_case_info sc 
                                    where sc.id=$case_id   and sc.status='1' ")->result_array();
        
        /*$result = $this->db->query("SELECT sc.id case_id,sc.car_id,sc.is_vehicle_images_uploaded,sc.is_buyer_docs_uploaded,sct.id trnx_id ,scb.id booking_id,scp.id payment_id,scd.id delivery_id FROM crm_used_car_sale_case_info sc 
                                    left join crm_uc_sales_transactions sct on sc.id=sct.uc_sales_case_id
                                    left join crm_uc_sales_booking scb on sc.id=scb.uc_sales_case_id
                                    left join crm_uc_sales_payment scp on sc.id=scp.uc_sales_case_id and scp.status='1'
                                    left join crm_uc_sales_delivery scd on sc.id=scd.uc_sales_case_id
                                    where sc.id=$case_id group by sc.id ")->result_array();*/
        return $result;
    }
    public function saveUpdateCaseInfo($caseInfo, $case_id = '')
    {
        if (empty($case_id))
        {
            $this->db->trans_start();
            $this->db->insert('crm_used_car_sale_case_info', $caseInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result    = $insert_id;
        }
        else
        {
            $this->db->where('id', $case_id);
            $this->db->update('crm_used_car_sale_case_info', $caseInfo);
            $result = $case_id;
        }
        //echo $this->db->last_query(); exit;
        return $result;
    }
    public function getSalesCaseData($case_id)
    {

        $result = $this->db->query("SELECT sc.loan_case_id,sc.loan_customer_id,sc.insurance_customer_id,sc.insurance_case_id ,sc.buyer_type seller_type ,case when buyer_type=1 then sc.customer_name else sc.company_name end as seller_name,
                                    sc.customer_email seller_email,sc.customer_relation,sc.customer_relation_name,sc.customer_address seller_address,sc.customer_mobile,lc.central_customer_id customer_id,
                                    uc.reg_no,uc.colour,uc.km_driven,uc.insurance_type,uc.insurance_exp_year,uc.insurance_exp_month,uc.city_id,uc.owner_type,
                                    uc.version_id db_version_id,mv.mk_id make_id,mv.model_id,mv.db_version version,mm.make,mm.model,mm.parent_model_id,uc.make_month,uc.make_year,uc.reg_month,uc.reg_year,uco.engineno,uco.chassisno,
                                    sct.new_insurance_req,sct.loan_req,sct.base_vehicle_price,sct.tcs,sct.rto_charges,sct.amount,sct.advance_payment,scb.id booking_id,scb.booking_date,
                                    sct.loan_amount,sct.bank_id,sct.roi,sct.tenure,scd.sold_invoice_no,scb.date_of_delivery,scd.sold_invoice_date,scd.id delivery_id,sct.insurance_charges,bl.bank_name,
                                    insur.prev_policy_insurer_name insurer_name,o.outlet_address,uco.reg_date
                                    FROM crm_used_car_sale_case_info sc 
                                    left join crm_uc_sales_transactions sct on sc.id=sct.uc_sales_case_id
                                    left join crm_uc_sales_booking scb on sc.id=scb.uc_sales_case_id
                                    left join crm_uc_sales_payment scp on sc.id=scp.uc_sales_case_id and scp.status='1'
                                    left join crm_uc_sales_delivery scd on sc.id=scd.uc_sales_case_id
                                    left join crm_used_car uc on sc.car_id=uc.id 
                                    left join crm_used_car_other_fields uco on uco.cnt_id=uc.id
                                    left join model_version mv on mv.db_version_id=uc.version_id 
                                    left join make_model mm on mm.id=mv.model_id  
                                    left join crm_buy_lead_dealer_mapper ldm on ldm.ldm_id=sc.ldm_id
                                    left join crm_buy_lead_customer lc on lc.id=ldm.ldm_customer_id
                                    left join crm_bank_list bl on bl.id=sct.bank_id
                                    left join crm_prev_policy_insurer insur on insur.id=uc.insurer_id
                                    left join crm_outlet o on uc.dealer_id=o.dealer_id
                                    where sc.id=$case_id and sc.status='1' group by sc.id;")->result_array();
        return $result;
    }
    public function getUcSalesCaseByCarid($car_id){
        $this->db->select('*');
        $this->db->from('crm_used_car_sale_case_info as usc');
        $this->db->where('car_id', (int)$car_id);
        $this->db->where('status', '1');
        $query  = $this->db->get();
        return $query->row_array();
    }
    
    public function getStatusName($status_id){
        $this->db->select("status_name");
        $this->db->from('crm_buy_customer_status');
        $this->db->where('id',$status_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function getLeadCustomerDetails($mobile){
        $this->db->select("ldm.*");
        $this->db->from('crm_buy_lead_customer as blc');
        $this->db->join("crm_buy_lead_dealer_mapper as ldm",'ldm.ldm_customer_id = blc.id','left');
        $this->db->where("blc.mobile",$mobile);
        $query = $this->db->get();
        return $query->row_array();
                
    }

}
