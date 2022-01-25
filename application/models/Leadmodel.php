<?php

class Leadmodel extends CI_Model
{
    private $dateTime = '';
    private $zero = 0;
    private $date = '';
    public function __construct()
    {
        parent::__construct();
        $this->dateTime = date("Y-m-d H:i:s");
        $this->date = date('Y-m-d');
        $this->load->helpers('range_helper');
        $this->load->model('Crm_buy_lead_customer_preferences');
        $this->load->model('Crm_buy_lead_car_detail');
    }

    public function getBuyLeadCustomer($mobile)
    {
        $query = $this->db->get_where('crm_buy_lead_customer', array('mobile' => $mobile, 'active' => '1'));
        return $query->row_array();
    }

    public function BuyLeadCustomer($requestParams)
    {
        $getBuyLeadCustomer = $this->getBuyLeadCustomer($requestParams['mobile']);
        $buyLeadCustomer = array();
        $buyLeadCustomer['city_id'] = (!empty($requestParams['city_id'])  ? $requestParams['city_id'] : $getBuyLeadCustomer['city_id']);
        $buyLeadCustomer['location_id'] = (isset($getBuyLeadCustomer['location_id']) && (intval($getBuyLeadCustomer['location_id']) > 0) ? intval($getBuyLeadCustomer['location_id']) : !empty($requestParams['location_id']) ? $requestParams['location_id'] : '');

        $buyLeadCustomer['opt_verified'] = ((isset($requestParams['opt_verified']) && $getBuyLeadCustomer['opt_verified'] != 1) ? $requestParams['opt_verified'] : $getBuyLeadCustomer['opt_verified']);
        $buyLeadCustomer['is_finance'] = (isset($requestParams['is_finance']) ? $requestParams['is_finance'] : $getBuyLeadCustomer['is_finance']);
        $buyLeadCustomer['lead_score'] = (isset($requestParams['lead_score']) ? $requestParams['lead_score'] : $getBuyLeadCustomer['lead_score']);
        $buyLeadCustomer['active'] = isset($requestParams['active']) ? $requestParams['active'] : $getBuyLeadCustomer['active'];
        $buyLeadCustomer['mobile'] = isset($requestParams['mobile']) ? $requestParams['mobile'] : '';
        if (empty($getBuyLeadCustomer['id'])) {
            $buyLeadCustomer['active'] = '1';
            $buyLeadCustomer['date_time'] = $this->dateTime;
            $buyLeadCustomer['updated_date'] = $this->dateTime;
            $this->db->insert('crm_buy_lead_customer', $buyLeadCustomer);
            $leadId = $this->db->insert_id();
        } else {
            // echo '<pre>';print_r($getBuyLeadCustomer);die;
            $buyLeadCustomer['updated_date'] = $this->dateTime;
            $this->db->where('id', $getBuyLeadCustomer['id']);
            $this->db->update('crm_buy_lead_customer', $buyLeadCustomer);
            $leadId = $getBuyLeadCustomer['id'];
        }
        return $leadId;
    }


    public function getBuyLeadDealerMapper($leadid, $dealerid)
    {
        $query = $this->db->get_where('crm_buy_lead_dealer_mapper', array('ldm_dealer_id' => $dealerid, 'ldm_customer_id' => $leadid));
        //echo $str = $this->db->last_query();  
        return $query->row_array();
    }


    public function setBuyLeadDealerMapper($requestParams, $ucdid)
    {
        date_default_timezone_set('Asia/Kolkata');
        $returnArr = [];
        $dealerId = $ucdid;
        $getBuyLeadDealerMapper = $this->getBuyLeadDealerMapper($requestParams['ldm_customer_id'], $requestParams['ldm_dealer_id']);

        //echo "<pre>";print_r($getBuyLeadDealerMapper);exit;
        $buyLeadDealerMapper = array();
        $buyLeadDealerMapper['dcleadid']           = !empty($requestParams['dcleadid']) ? $requestParams['dcleadid'] : 0;
        $buyLeadDealerMapper['ldm_name']           = (!empty($requestParams['ldm_name']) ? $requestParams['ldm_name'] : $getBuyLeadDealerMapper['ldm_name']);
        $buyLeadDealerMapper['ldm_email']          = (!empty($requestParams['ldm_email'])  ? $requestParams['ldm_email'] : $getBuyLeadDealerMapper['ldm_email']);
        $buyLeadDealerMapper['ldm_alt_mobile']     = (!empty($requestParams['ldm_alt_mobile']) ? $requestParams['ldm_alt_mobile'] : $getBuyLeadDealerMapper['ldm_alt_mobile']);
        $buyLeadDealerMapper['ldm_alt_email']      = (!empty($requestParams['ldm_alt_email'])  ? $requestParams['ldm_alt_email'] : $getBuyLeadDealerMapper['ldm_alt_email']);
        $buyLeadDealerMapper['ldm_status_id']      = ((!empty($requestParams['ldm_status_id']) && intval($requestParams['ldm_status_id']) > 0) ? $requestParams['ldm_status_id'] : $getBuyLeadDealerMapper['ldm_status_id']);
        $buyLeadDealerMapper['ldm_lead_rating']    = (!empty($requestParams['ldm_lead_rating']) ? $requestParams['ldm_lead_rating'] : $getBuyLeadDealerMapper['ldm_lead_rating']);
        $buyLeadDealerMapper['ldm_follow_date']    = ((!empty($requestParams['ldm_follow_date']) && $requestParams['ldm_follow_date'] != '0000-00-00 00:00:00') ? $requestParams['ldm_follow_date'] : $getBuyLeadDealerMapper['ldm_follow_date']);

        if ($getBuyLeadDealerMapper['ldm_status_id'] == '4' && $requestParams['ldm_status_id'] == '' && ($requestParams['ldm_walkin_date'] == '' || $requestParams['ldm_walkin_date'] == '0000-00-00 00:00:00')) {
            $buyLeadDealerMapper['ldm_walkin_date'] = ((!empty($requestParams['ldm_follow_date']) && $requestParams['ldm_follow_date'] != '0000-00-00 00:00:00') ? $requestParams['ldm_follow_date'] : $getBuyLeadDealerMapper['ldm_follow_date']);
        } else {
            $buyLeadDealerMapper['ldm_walkin_date'] = ((!empty($requestParams['ldm_walkin_date'])  && $requestParams['ldm_walkin_date'] != '0000-00-00 00:00:00') ? $requestParams['ldm_walkin_date'] : $getBuyLeadDealerMapper['ldm_walkin_date']);
        }
        $buyLeadDealerMapper['ldm_amount'] = (isset($requestParams['ldm_amount']) && $requestParams['ldm_amount'] != '0' ? $requestParams['ldm_amount'] : $getBuyLeadDealerMapper['ldm_amount']);
        $buyLeadDealerMapper['ldm_car_id'] = (isset($requestParams['ldm_car_id']) && $requestParams['ldm_car_id'] != '0' ? $requestParams['ldm_car_id'] : $getBuyLeadDealerMapper['ldm_car_id']);
        $buyLeadDealerMapper['ldm_location_id'] = (!empty($requestParams['ldm_location_id']) ? $requestParams['ldm_location_id'] : $getBuyLeadDealerMapper['ldm_location_id']);
        $buyLeadDealerMapper['ldm_city_id'] = (isset($requestParams['ldm_city_id']) ? $requestParams['ldm_city_id'] : $getBuyLeadDealerMapper['ldm_city_id']);
        $buyLeadDealerMapper['ldm_total_assign_lead'] = (isset($requestParams['ldm_total_assign_lead']) ? $requestParams['ldm_total_assign_lead'] : $getBuyLeadDealerMapper['ldm_total_assign_lead']);
        $buyLeadDealerMapper['ldm_customer_id'] = (isset($requestParams['ldm_customer_id']) ? $requestParams['ldm_customer_id'] : $getBuyLeadDealerMapper['ldm_customer_id']);
        $buyLeadDealerMapper['ldm_dealer_id'] = ($requestParams['ldm_dealer_id'] > 0 ? $requestParams['ldm_dealer_id'] : $getBuyLeadDealerMapper['ldm_dealer_id']);
        $buyLeadDealerMapper['gaadi_verified'] = (($requestParams['gaadi_verified'] != '' && $requestParams['gaadi_verified'] != 0) ? $requestParams['gaadi_verified'] : $getBuyLeadDealerMapper['gaadi_verified']);

        if (empty($requestParams['ldm_follow_date'])) {
            $requestParams['ldm_follow_date'] = '';
        }

        //echo '<pre>';print_r($getBuyLeadDealerMapper);die;
        if (!empty($getBuyLeadDealerMapper)) {

            if ($getBuyLeadDealerMapper['ldm_status_id'] == '1' && $requestParams['ldm_follow_date'] != '' && $requestParams['ldm_follow_date'] != '0000-00-00 00:00:00' && ($requestParams['ldm_status_id'] == 1 || $requestParams['ldm_status_id'] == '')) {
                $buyLeadDealerMapper['ldm_status_id'] = '2';
                $returnArr['leadadd']                 = 'follow';
            }
            $buyLeadDealerMapper['syncd_with_dc'] = '0';
            $this->db->where('ldm_id', $getBuyLeadDealerMapper['ldm_id']);
            $this->db->update('crm_buy_lead_dealer_mapper', $buyLeadDealerMapper);
            $leadDealerMapperId = $getBuyLeadDealerMapper['ldm_id'];

            $data['statusrepeat']      = 'statusrepeat';
        } else {

            $buyLeadDealerMapper['dcleadid']           = !empty($requestParams['dcleadid']) ? $requestParams['dcleadid'] : 0;
            $buyLeadDealerMapper['ldm_active']           = !empty($requestParams['ldm_active']) ? $requestParams['ldm_active'] : $getBuyLeadDealerMapper['ldm_active'];
            $buyLeadDealerMapper['ldm_update_date']      = date('Y-m-d H:i:s');
            $buyLeadDealerMapper['ldm_created_date']     = date('Y-m-d H:i:s');
            $buyLeadDealerMapper['ldm_is_sms']           = !empty($requestParams['ldm_is_sms']) ? $requestParams['ldm_is_sms'] : '';
            $buyLeadDealerMapper['ldm_is_sms_cardetail'] = !empty($requestParams['ldm_is_sms_cardetail']) ? $requestParams['ldm_is_sms_cardetail'] : '';
            $buyLeadDealerMapper['ldm_is_sms_location']  = !empty($requestParams['ldm_is_sms_location']) ? $requestParams['ldm_is_sms_location'] : '';
            $buyLeadDealerMapper['ldm_source']           = !empty($requestParams['ldm_source']) ? $requestParams['ldm_source'] : '';
            $buyLeadDealerMapper['ldm_sub_source']       = !empty($requestParams['ldm_sub_source']) ? $requestParams['ldm_sub_source'] : '';
            $buyLeadDealerMapper['added_by']             = $this->session->userdata['userinfo']['id'];
            if (!$this->session->userdata['userinfo']['is_admin']) {
                $buyLeadDealerMapper['assigned_to']          = $this->session->userdata['userinfo']['id'];
                $buyLeadDealerMapper['updated_by']           = $this->session->userdata['userinfo']['id'];
            }

            if (!empty($requestParams['ldm_follow_date']) && $requestParams['ldm_follow_date'] != '' && $requestParams['ldm_follow_date'] != '0000-00-00 00:00:00' && ($requestParams['ldm_status_id'] == 1 || $requestParams['ldm_status_id'] == '0')) {
                $buyLeadDealerMapper['ldm_status_id'] = '2';
                $returnArr['leadadd'] = 'follow';
            }
            if (intval($buyLeadDealerMapper['ldm_status_id']) == 0 || intval($buyLeadDealerMapper['ldm_status_id']) == 1) {
                $buyLeadDealerMapper['ldm_status_id'] = 1;
                $returnArr['leadadd']                 = 'add';
            }
            $this->db->insert('crm_buy_lead_dealer_mapper', $buyLeadDealerMapper);
            $leadDealerMapperId = $this->db->insert_id();
            $data['addnew_status'] = 'addnew_status';
        }
        if (!empty($data['addnew_status']) && ($data['addnew_status'] == 'addnew_status')) {
            $histdata['status'] = '1';
            $histdata['status_name'] = 'New';
            $histdata['ldm_status_id'] = '1';
            $histdata['mobile'] = !empty($requestParams['mobile']) ? $requestParams['mobile'] : '';
            $histdata['lc_lead_dealer_mapper_id'] = $leadDealerMapperId;
            $histdata['ldm_dealer_id'] = ($requestParams['ldm_dealer_id'] > 0 ? $requestParams['ldm_dealer_id'] : $getBuyLeadDealerMapper['ldm_dealer_id']);;
            $histdata['booking_amount'] = '';
            $histdata['offer_amount'] = '';
            $histdata['datetime'] = $this->dateTime;
            $histdata['hashentry'] = $this->Crm_buy_lead_history_track->rowDataUnique($histdata, '1');
            $this->Crm_buy_lead_history_track->trackAllHistory($histdata);
        }
        //echo $leadDealerMapperId;die;
        $returnArr['lead_dealer_mapper_id'] = $leadDealerMapperId;
        return $returnArr;
    }

    function getBuyLeadCarDetail($lead_deale_mapp_id, $car_id)
    {

        $query = $this->db->get_where('crm_buy_lead_car_detail', array('lcd_lead_dealer_mapper_id' => $lead_deale_mapp_id, 'lcd_car_id' => $car_id));
        return $query->row_array();
    }

    function setBuyLeadCarDetail($requestParams)
    {

        $getBuyLeadCarDetail = $this->getBuyLeadCarDetail($requestParams['lead_id'], $requestParams['car_id']);

        $buyLeadCarDetail = array();
        $buyLeadCarDetail['lcd_updated_date'] = $this->dateTime;
        if (!empty($getBuyLeadCarDetail)) {
            $buyLeadCarDetail['lcd_favourite']             = ((isset($requestParams['favourite'])) ? $requestParams['favourite'] : $getBuyLeadCarDetail['lcd_favourite']);
            $buyLeadCarDetail['sell_amount'] = (!empty($requestParams['sale_amount']) && $requestParams['sale_amount'] > 0 ? $requestParams['sale_amount'] : $getBuyLeadCarDetail['sell_amount']);
            $buyLeadCarDetail['booking_amount'] = (!empty($requestParams['booking_amount']) && $requestParams['booking_amount'] > 0 ? $requestParams['booking_amount'] : $getBuyLeadCarDetail['booking_amount']);
            $buyLeadCarDetail['offer_amount'] = (!empty($requestParams['offer_amount']) && $requestParams['offer_amount'] > 0 ? $requestParams['offer_amount'] : $getBuyLeadCarDetail['offer_amount']);
            //echo "<pre>";print_r($buyLeadCarDetail);exit;
            $this->db->where('lcd_lead_dealer_mapper_id', $getBuyLeadCarDetail['lcd_lead_dealer_mapper_id']);
            $this->db->where('lcd_car_id', $requestParams['car_id']);
            $this->db->update('crm_buy_lead_car_detail', $buyLeadCarDetail);
            $inserted_id = $getBuyLeadCarDetail['lcd_id'];
            $lcdId = $getBuyLeadCarDetail['lcd_id'];
        } else {
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
            $lcdId                                         = '0';
            $this->db->insert('crm_buy_lead_car_detail', $buyLeadCarDetail);
            $inserted_id = $this->db->insert_id();
        }
        /*if(intval($requestParams['sale_amount'])>0)
                 {
                 }*/
        if ($lcdId == '0') {
            $this->updateIsLatest($requestParams['lead_id'], $inserted_id);
        }

        return $inserted_id;
    }

    public function updateIsLatest($leadId, $inserted_id)
    {
        $updateCarData = [
            'lcd_is_latest' => '0',
        ];

        $this->db->where('lcd_lead_dealer_mapper_id', $leadId);
        $this->db->where('lcd_id !=', $inserted_id);
        $this->db->update('crm_buy_lead_car_detail', $updateCarData);
        return $leadId;
    }



    public function AddEditLeadPreferences($requestParams, $leadId)
    {
        $prefer = array();

        $prefer['lead_id'] = $leadId;
        if (isset($requestParams['makeIds'])) {
            $prefer['makeIds'] = $requestParams['makeIds'];
        }
        if (isset($requestParams['modelIds'])) {
            $prefer['modelIds'] = $requestParams['modelIds'];
        }
        if (!empty($requestParams['budget'])) {
            $prefer['budget'] = $requestParams['budget'];
        }
        if (isset($requestParams['fuel_type'])) {
            $prefer['fuel_type'] = $requestParams['fuel_type'];
        }
        if (isset($requestParams['transmission'])) {
            $prefer['transmission'] = $requestParams['transmission'];
        }
        if (isset($requestParams['body_type'])) {
            $prefer['body_type'] = $requestParams['body_type'];
        }

        $preferId =   $this->addEditpreferences($prefer);
        return $preferId;
    }


    public function getBuyLeadCustomerPreferences($lead_deale_mapp_id)
    {
        $query = $this->db->get_where('crm_buy_lead_customer_preferences', array('lcp_lead_dealer_mapper_id' => $lead_deale_mapp_id, 'lcp_is_latest' => '1', 'lcp_active' => '1'));
        return $query->row_array();
    }


    public function addEditpreferences($request)
    {
        $chkCustomerPreferences = $this->getBuyLeadCustomerPreferences($request['lead_id']);
        $request['ucdid'] = !empty($request['ucdid']) ? $request['ucdid'] : '';
        $datetime = $this->dateTime;

        $buyLeadCustomerPreferences = array();
        $buyLeadCustomerPreferences['lcp_lead_dealer_mapper_id'] = !empty($request['lead_id']) ? $request['lead_id'] : '';

        $buyLeadCustomerPreferences['lcp_make'] = (isset($request['makeIds']) ? $request['makeIds'] : $chkCustomerPreferences['lcp_make']);
        $buyLeadCustomerPreferences['lcp_model'] = (isset($request['modelIds']) ? $request['modelIds'] : $chkCustomerPreferences['lcp_model']);
        $buyLeadCustomerPreferences['lcp_price_from'] = (isset($request['budget']) ? $request['budget'] : $chkCustomerPreferences['lcp_price_from']);
        $buyLeadCustomerPreferences['lcp_price_to'] = (isset($request['budget']) ? $request['budget'] : $chkCustomerPreferences['lcp_price_from']);
        $buyLeadCustomerPreferences['lcp_fuel_type'] = (isset($request['fuel_type']) ? $request['fuel_type'] : $chkCustomerPreferences['lcp_fuel_type']);
        $buyLeadCustomerPreferences['lcp_transmission_type'] = (isset($request['transmission']) ? $request['transmission'] : $chkCustomerPreferences['lcp_transmission_type']);
        $buyLeadCustomerPreferences['lcp_body_type'] = (isset($request['body_type']) ? $request['body_type'] : $chkCustomerPreferences['lcp_body_type']);

        if (!empty($chkCustomerPreferences)) {
            $buyLeadCustomerPreferences['lcp_platform'] = !empty($request['source']) ? $request['source'] : '';
            $buyLeadCustomerPreferences['lcp_updated_date'] = $datetime;

            $this->db->where('lcp_id', $chkCustomerPreferences['lcp_id']);
            $this->db->update('crm_buy_lead_customer_preferences', $buyLeadCustomerPreferences);
            $insertedId = !empty($chkCustomerPreferences['lcp_id']) ? $chkCustomerPreferences['lcp_id'] : '';
        } else {
            $buyLeadCustomerPreferences['lcp_created_date'] = $datetime;
            $this->db->insert('crm_buy_lead_customer_preferences', $buyLeadCustomerPreferences);
            $insertedId = $this->db->insert_id();
        }

        if (intval($insertedId) > $this->zero) {
            return array('status' => 'T', 'msg' => 'Updated successfully.', 'leadids' => $insertedId, 'error' => '');
        } else {

            return array('status' => 'F', 'msg' => 'Not Added.', 'error' => 'There is some error in parameters passed.');
        }
    }
    public function getTodayleadsQuery($requestParams, $perPageRecord, $pageNo, $startLimit)
    {

        $lastdaydate = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 7));
        $lastdaydate90 = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 90));
        $this->db->select('ldm.*');
        $this->db->select('lcp.*');
        $this->db->select('loc.location_name as localityname,lc.is_finance,lc.lead_score,lc.mobile,lc.opt_verified,lc.gaadi_verified as gaadi_common,cs.status_name,CASE WHEN (DATE(ldm.ldm_created_date)>=' . $lastdaydate . ') THEN 1 ELSE 0 END  as htcrt');
        $this->db->from('crm_buy_lead_dealer_mapper as ldm');
        $this->db->join('crm_buy_lead_customer as lc', 'lc.id=ldm.ldm_customer_id', 'left');
        $this->db->join('crm_buy_lead_customer_preferences as lcp', 'lcp.lcp_lead_dealer_mapper_id = ldm.ldm_id AND lcp.lcp_is_latest=1 AND lcp.lcp_active=1', 'left');
        $this->db->join('crm_buy_customer_status AS cs', 'cs.id=ldm.ldm_status_id', 'left');
        $this->db->join('ublms_locations as loc', 'ldm.ldm_location_id = loc.location_id', 'left');
        $this->db->where('ldm.ldm_dealer_id', $requestParams['ucdid']);
        //$this->db->where('ldm.ldm_dealer_id' ,'69');
        $this->db->where('ldm.ldm_dealer_id>', '0');
        if ($this->session->userdata['userinfo']['is_admin'] != 1) {
            $this->db->where('ldm.assigned_to', $this->session->userdata['userinfo']['id']);
        }
        $this->db->where('lc.mobile>', '0');
        //  $this->db->where('DATE(ldm.ldm_follow_date) <=',date('Y-m-d'));
        $this->webTodayGetLeadsFilterByTab($requestParams);
        $this->webTodayGetLeadsFilter($requestParams);
        $this->db->group_by(array('ldm.ldm_id'));
        $this->orderbyGetLeadsFilter($requestParams);

        if (isset($requestParams['type']) && $requestParams['type'] != '' && $requestParams['sorting'] == '1') {
            //$this->db->sortingTabwise($requestParams);
        }

        // if (empty($requestParams['export']) && $requestParams['export'] != 'export') {
        if (isset($requestParams['page'])) {
            $this->db->offset((int) ($startLimit));
        }
        if (!empty($perPageRecord)) {
            $this->db->limit((int) $perPageRecord);
        }
        // }

        $query = $this->db->get();
        return $query->result_array();
        // echo  $str = $this->db->last_query();
    }

    public function getleadsQuery($requestParams, $perPageRecord, $pageNo, $startLimit)
    {
        //,CASE WHEN (DATE(ldm.ldm_created_date)>='".$lastdaydate."') THEN 1 ELSE 0 END  as htcrt
        $lastdaydate = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 7));
        $lastdaydate90 = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 90));
        $this->db->select('ldm.*');
        $this->db->select('lcp.*');
        $this->db->select('loc.location_name as localityname,lc.is_finance,lc.lead_score,lc.mobile,lc.opt_verified,lc.gaadi_verified as gaadi_common,cs.status_name,CASE WHEN (DATE(ldm.ldm_created_date)>=' . $lastdaydate . ') THEN 1 ELSE 0 END  as htcrt,cu.name assigned_to_user,t.amount sale_amount,t.advance_payment booking_amount');
        $this->db->from('crm_buy_lead_dealer_mapper as ldm');
        $this->db->join('crm_buy_lead_customer as lc', 'lc.id=ldm.ldm_customer_id', 'left');
        $this->db->join('crm_buy_lead_customer_preferences as lcp', 'lcp.lcp_lead_dealer_mapper_id = ldm.ldm_id AND lcp.lcp_is_latest=1 AND lcp.lcp_active=1', 'left');
        $this->db->join('crm_buy_customer_status AS cs', 'cs.id=ldm.ldm_status_id', 'left');
        $this->db->join('ublms_locations as loc', 'ldm.ldm_location_id = loc.location_id', 'left');
        $this->db->join('crm_user as cu', 'ldm.assigned_to = cu.id', 'left');
        $this->db->join('crm_used_car_sale_case_info as uco', 'uco.car_id=ldm_car_id', 'left');
        $this->db->join('crm_uc_sales_transactions t ', 't.uc_sales_case_id = uco.id', 'left');
        $this->db->where('ldm.ldm_dealer_id', $requestParams['ucdid']);
        //$this->db->where('ldm.ldm_dealer_id' ,'69');
        $this->db->where('ldm.ldm_dealer_id>', '0');
        if ($this->session->userdata['userinfo']['is_admin'] != 1) {
            $this->db->where('ldm.assigned_to', $this->session->userdata['userinfo']['id']);
        }
        $this->db->where('lc.mobile>', '0');
        $this->webGetLeadsFilterbyTab($requestParams);
        $this->webGetLeadsFilter($requestParams);
        $this->db->group_by(array('ldm.ldm_id'));
        $this->orderbyGetLeadsFilter($requestParams);

        if (isset($requestParams['type']) && $requestParams['type'] != '' && $requestParams['sorting'] == '1') {
            //$this->db->sortingTabwise($requestParams);
        }

        // if (empty($requestParams['export']) && $requestParams['export'] != 'export') {
        if (!empty($pageNo)) {
            $this->db->offset((int) ($startLimit));
        }
        if (!empty($perPageRecord)) {
            $this->db->limit((int) $perPageRecord);
        }
        // }

        $query = $this->db->get();
        //  echo $str = $this->db->last_query();die;

        return  $query->result_array();
    }


    public function leadwiseCarListgetLeads($leadId, $carId = false, $limit = false)
    {
        //,ucm.car_certification
        $this->db->select('lcd.lcd_car_id,uc.insurance_exp_month,uc.insurance_exp_year,uc.insurance_type AS insurance,uc.reg_month AS month, uc.reg_year year,uc.make_month AS mmonth,uc.make_year AS myear, uc.colour AS colour, uc.km_driven AS km, uc.car_price AS pricefrom,uc.reg_no AS regno,uc.owner_type AS owner,uc.version_id,lcd.lcd_car_id  AS car_id,mv.mk_id AS makeID,mv.db_version AS version,cl.city_id,cl.city_name,
mv.uc_body_type AS body_type,mv.uc_transmission AS transmission,mv.uc_fuel_type AS fuel_type,mm.make,CASE WHEN mm.parent_model_id>0 THEN (select model from make_model where  id = mm.parent_model_id limit 1) ELSE mm.model END AS model,lcd.lcd_favourite,
lcd.offer_amount,lcd.booking_amount,lcd.lcd_source,lcd.lcd_sub_source,uc.certification_status,uc.car_status as active');
        $this->db->from('crm_buy_lead_car_detail as lcd');
        $this->db->join('crm_used_car as uc', 'uc.id=lcd.lcd_car_id', 'left');
        $this->db->join('model_version as mv', 'mv.db_version_id=uc.version_id', 'left');
        $this->db->join('make_model as mm', 'mm.id=mv.model_id', 'left');
        $this->db->join('city_list as cl', 'uc.city_id=cl.city_id', 'left');
        //$this->db->join('usedcar_certification_mapper as ucm', 'ucm.car_id=uc.old_car_id','left');
        $this->db->where('lcd.lcd_lead_dealer_mapper_id', $leadId);
        $this->db->where('lcd.lcd_active', '1');
        $this->db->where('lcd.lcd_favourite', '1');
        $this->db->where('uc.car_status!=', '9');
        $this->db->where('lcd.lcd_car_id>', '0');
        if ($carId) {
            $this->db->where('lcd.lcd_car_id', $carId);
        }
        $this->db->order_by('lcd.lcd_id DESC');
        if ($limit) {
            $this->db->limit((int) $limit);
        }
        $query = $this->db->get();
        $carList =  $query->result_array();

        return $carList;
    }
    public function getLeadCarList($requestParams, $leadId, $carId = false, $limit = false)
    {
        $leadCarList = $this->leadwiseCarListgetLeads($leadId, $carId = false, $limit = false);
        $carList = array();
        $j = 0;
        foreach ($leadCarList as $key => $value) {
            $nooptionUnassign = $this->nooptionUnassign($value['lcd_source'], $value['lcd_sub_source']);

            $carList[$key]['disable_unassign'] = (intval($nooptionUnassign) == 1 ? true : false);
            $carList[$key]['car_id'] = $value['car_id'];
            $carList[$key]['is_sold'] = ($value['active'] != 1 && $value['active'] != '') ? true : false;
            //$carList[$key]['lead_count'] = intval($leadcount[count]);
            //$carList[$key]['offer_count'] = intval($offers[0]->offer);
            $carList[$key]['offer'] = (intval($value['offer_amount']) > 0 ? true : false);
            $carList[$key]['year'] = !empty($value['myear']) ? $value['myear'] : '';
            $carList[$key]['month'] = !empty($value['mm']) ? $value['mm'] : '';
            $carList[$key]['version_id'] = !empty($value['version_id']) ? $value['version_id'] : '';
            $carList[$key]['city_name'] = !empty($value['city_name']) ? $value['city_name'] : '';
            $carList[$key]['owner'] = !empty($value['owner']) ? $value['owner'] : '';
            $carList[$key]['insurance'] = !empty($value['insurance']) ? $value['insurance'] : '';
            $carList[$key]['expiry_date'] = !empty($value['expiry_date']) ? $value['expiry_date'] : '';
            $carList[$key]['city_id'] = !empty($value['city_id']) ? $value['city_id'] : '';
            $carList[$key]['color'] = !empty($value['color']) ? $value['color'] : '';
            $carList[$key]['km'] = !empty($value['km']) ? $value['km'] : '';
            $carList[$key]['transmission'] = !empty($value['transmission']) ? $value['transmission'] : '';
            $carList[$key]['body_type'] = !empty($value['body_type']) ? $value['body_type'] : '';
            $carList[$key]['price'] = !empty($value['pricefrom']) ? $value['pricefrom'] : '';
            $carList[$key]['make'] = !empty($value['make']) ? $value['make'] : '';
            $carList[$key]['ins_month'] = !empty($value['month']) ? $value['month'] : '';
            $carList[$key]['ins_year'] = !empty($value['year']) ? $value['year'] : '';
            $carList[$key]['model'] = !empty($value['model']) ? $value['model'] : '';
            $carList[$key]['version'] = !empty($value['version']) ? $value['version'] : '';
            $carList[$key]['regno'] = !empty($value['regno']) ? $value['regno'] : '';
            $carList[$key]['favourite'] = !empty($value['lcd_favourite']) ? $value['lcd_favourite'] : '';
            $carList[$key]['lead_count'] = '4';
            $carList[$key]['makeID'] = !empty($value['makeID']) ? intval($value['makeID']) : '';
            $websiteUrl = '';
            if (!empty($value['car_certification']) && $value['car_certification'] == 18 && $value['certification_status'] == 1) {
                $carList[$key]['trustmarkCertified'] = 'true';
            } else {
                $carList[$key]['trustmarkCertified'] = 'false';
            }
            $carList[$key]['fuel_type'] = !empty($value['fuel_type']) ? $value['fuel_type'] : '';
            //$carList[$key]['imageIcon']=$imageArray[0];

        }
        return $carList;
    }

    public function nooptionUnassign($source, $subsource)
    {
        $option = 1;
        $source =  strtolower($source);
        $subsource = strtolower($subsource);
        if ($source == 'self' || (($source == 'gaadi' || $source == '') && $subsource == 'mobile')) {
            $option = 0;
        }
        return $option;
    }
    public function getLeads($requestParams, $dealerId, $limit = true)
    {
        //echo "<pre>";print_r($requestParams);exit;
        $requestParams['rpp'] = 10;
        $responseData = array();
        $daysCount = 30;
        if ($limit) {
            $perPageRecord = $requestParams['rpp'] == 0 ? 50 : $requestParams['rpp'];
            $pageNo = (isset($requestParams['page']) && $requestParams['page'] != '') ? $requestParams['page'] : '1';
            $startLimit = ($pageNo - 1) * $perPageRecord;
        }
        $requestParams['dealerID'] = $dealerId;
        $requestParams['ucdid']   = $dealerId;
        if ($requestParams['filter_data_type'] == 'todayworks') {
            $getleads = $this->getTodayleadsQuery($requestParams, $perPageRecord, $pageNo, $startLimit);

            $totalRecords = count($this->getTodayleadsQuery($requestParams, $perPageRecord, $pageNo, $startLimit));
            $totalRecords = count($getleads);
        } else {
            $getleads = $this->getleadsQuery($requestParams, $perPageRecord, $pageNo, $startLimit);

            $totalRecords = count($this->getLeadsQuery($requestParams, $perPageRecord, $pageNo, $startLimit));
            $totalRecords = count($getleads);
        }
        $leads = array();
        /* echo "<pre>";
        print_r($getleads);
        exit;*/
        if (!empty($getleads)) {
            $i = 0;
            $ldmIdsArray = array();
            foreach ($getleads as $key => $val) {
                $ldmIdsArray[] = $val['ldm_id'];
                $leads[$i]['dealerID'] = $dealerId;
                $leads[$i]['ucdid'] = $val['ldm_dealer_id'];
                $leads[$i]['assigned_to_user'] = $val['assigned_to_user'];
                $leads[$i]['leadID'] = $val['ldm_id'];
                //$leads[$i]['dealership_name'] = $val['organization'];
                $leads[$i]['localityname'] = $val['localityname'];
                $leads[$i]['location'] = $val['ldm_location_id'];
                $leads[$i]['is_finance'] = $val['is_finance'];
                $leads[$i]['emailID'] = (stripos($val['ldm_email'], "null") == true ? '' : $val['ldm_email']);
                $leads[$i]['alt_number'] = preg_replace("/[^0-9]/", "", $val['ldm_alt_mobile']);
                $leads[$i]['changetime'] = $val['ldm_update_date'];
                $name = ucwords(strtolower(preg_replace("/[^a-zA-Z\s]/", "", $val['ldm_name'])));
                $leads[$i]['name'] = (stripos($name, "null") == true ? '' : $name);
                $leads[$i]['number'] = preg_replace("/[^0-9]/", "", $val['mobile']);
                $leads[$i]['assign_lead'] = intval($val['ldm_total_assign_lead']);
                $leads[$i]['verified'] = (($val['gaadi_verified'] == '1') ? true : false);
                $leads[$i]['otp_verified'] = (($val['opt_verified'] == '1') ? true : false);
                if (strtolower($val['ldm_source']) == 'cardekho knowlarity' || strtolower($val['ldm_source']) == 'cardekho_knowlarity') {
                    $val['ldm_source'] = 'Call Tracker';
                } elseif (strtolower($val['ldm_source']) == 'gaadi' || strtolower($val['ldm_source']) == '' || strtolower($val['ldm_source']) == 'self' || strtolower($val['ldm_source'] == 'UB')) {
                    $val['ldm_source'] = 'Gaadi';
                }
                $leads[$i]['source'] = ($val['ldm_source'] == 'UB' ? 'Gaadi' : ucfirst(strtolower($val['ldm_source'])));


                $leads[$i]['lead_status'] = $val['status_name'];



                if (isset($requestParams['source']) && $requestParams['source'] != 'ANDROID_APP') {
                    $leads[$i]['lead_status_id'] = $val['ldm_status_id'];
                }
                $statusid = $val['ldm_status_id'];
                $leads[$i]['lead_status_id'] = $statusid;
                $getamount = '';
                $leads[$i]['leadCreatedDate'] = $val['ldm_created_date'];

                //$time = strtotime( $leads[$i]['leadCreatedDate']) + 19800; // Add 1 hour
                //$leads[$i]['leadCreatedDate'] = date('Y-m-d h:i:s', $time);
                $leads[$i]['followDate'] = '';
                if ($statusid == '1') { //New
                    $leads[$i]['createdDate'] = $val['ldm_created_date'];
                } else {
                    $leads[$i]['updatedDate'] = $val['ldm_update_date'];
                    $leads[$i]['followDate'] = ($val['ldm_follow_date'] != '0000-00-00 00:00:00' ? $val['ldm_follow_date'] : '');
                }
                if ($statusid == '11') { //Booked
                    $leads[$i]['bookingAmount'] = (intval($val['ldm_amount']) == 0 ? '' : number_format('%!.0n', intval($val['ldm_amount'])));
                }
                if ($statusid == '12') { //Booked
                    $leads[$i]['sellAmount'] = (intval($val['ldm_amount']) == 0 ? '' : number_format('%!.0n', intval($val['ldm_amount'])));
                    $leads[$i]['sellAmount'] = (intval($val['sale_amount']) > 0) ? $val['sale_amount'] : $leads[$i]['sellAmount'];
                }
                if ($statusid == '10') { //Customer Offer
                    $leads[$i]['offerAmount'] = (intval($val['ldm_amount']) == 0 ? '' : number_format('%!.0n', intval($val['ldm_amount'])));
                    $leads[$i]['car_id'] = intval($val['ldm_car_id']);
                }
                if ($statusid == '9' || $statusid == '4') { //Walked-in
                    $leads[$i]['walkinDate'] = ($val['ldm_walkin_date'] != '0000-00-00 00:00:00' ? $val['ldm_walkin_date'] : '');
                }
                $hotlead_crecteriaText = '';
                if ($val['htcrt'] == '1' && ($val['lead_score'] > 6 || strtolower($val['ldm_source']) == 'website' || $val['ldm_source'] == 'CarDekho Knowlarity')) {
                    $hotlead_crecteriaText = 'Hot';
                }
                $leads[$i]['rating'] = ($val['ldm_lead_rating'] != '' ? $val['ldm_lead_rating'] : $hotlead_crecteriaText);

                // }
                if ($statusid == '4') { //Walk-in
                    $leads[$i]['reminderDate'] = ($val['ldm_follow_date'] != '0000-00-00 00:00:00' ? $val['ldm_follow_date'] : '');
                }
                if ($statusid == '12') {
                    $leads[$i]['saleAmount'] = (intval($val['ldm_amount']) == 0 ? '' : money_format('%!.0n', intval($val['ldm_amount'])));
                    $leads[$i]['saleAmount'] = (intval($val['sale_amount']) > 0) ? $val['sale_amount'] : $leads[$i]['saleAmount'];
                }
                $resultCarList = $this->getLeadCarList($requestParams, $val['ldm_id']);
                $lastCar = $this->leadwiseCarListgetLeads($val['ldm_id']);
                if ($lastCar) {
                    $leads[$i]['makeID'] = intval($lastCar[0]['makeID']);
                    $leads[$i]['model'] = $lastCar[0]['model'];
                    $leads[$i]['version'] = $lastCar[0]['version'];
                }
                $leads[$i]['car_list'] = $resultCarList;

                $lcp_makename = '';
                $lcp_modelname = '';
                $bodytype = explode(",", $val['lcp_body_type']);
                $lcp_make = explode(",", $val['lcp_make']);
                $lcp_model = explode(",", $val['lcp_model']);


                if ((intval($val['lcp_price_to']) > 0 || trim($val['lcp_fuel_type']) != '' || trim($val['lcp_transmission_type']) != '' || trim($val['lcp_body_type']) != '' || trim($val['lcp_make']) != '' || trim($val['lcp_model']) != '')) {
                    $lcp_fuel_type = explode(",", $val['lcp_fuel_type']);
                    $lcp_transmission_type = explode(",", $val['lcp_transmission_type']);
                    $leads[$i]['preferences'] = [
                        'budget' => ($val['lcp_price_to'] == '' ? '0' : $val['lcp_price_to']),
                        'fuelType' => $lcp_fuel_type[0],
                        'transmission' => $lcp_transmission_type[0],
                        'bodyType' => ((trim($val['lcp_body_type']) == '') ? [] : $bodytype),
                        'makeIds' => ((trim($val['lcp_make']) == '') ? [] : $lcp_make),
                        'modelIds' => ((trim($val['lcp_model']) == '') ? [] : $lcp_model),
                    ];
                }
                $historyData = [];
                $this->load->model('Crm_buy_lead_history_track');
                $historyData = $this->Crm_buy_lead_history_track->getLeadHistoryTrack($val['ldm_id'], '', '2');
                $leads[$i]['history'] = $historyData;

                $i++;
            }
        }


        $lastRecord = $pageNo * $perPageRecord;
        $nextRecords = true;
        if ($lastRecord >= $totalRecords) {
            $nextRecords = false;
        }

        if (isset($requestParams['leadID']) && $requestParams['leadID'] > 0) {
            return array('status' => 'T', 'leads' => $leads);
        }
        $responseData['error'] = "";
        $responseData['msg'] = "username and password matched!!";
        $responseData['status'] = "T";
        if ($pageNo == '1') {
            $responseData['budget_list'] = $this->Crm_buy_lead_customer_preferences->getbudgetList();
            //$responseData['budget_list']='';
        }
        $responseData['leads'] = $leads;
        $responseData['pageNumber'] = $pageNo;

        $responseData['totalRecords'] = $totalRecords;
        $responseData['hasNext'] = $nextRecords;

        $responseData['hasNext'] = $nextRecords;
        $responseData['pageSize'] = $perPageRecord;
        $responseData['days_count'] = $daysCount;

        return $responseData;
    }


    public function orderbyGetLeadsFilter($requestParams)
    {

        if (array_key_exists('changetime', $requestParams)) {
            $this->db->order_by('ldm.ldm_update_date asc');
            $this->db->order_by('ldm.ldm_id');
        } else {
            if (isset($requestParams['sorting']) && $requestParams['sorting'] == 1) {
                $this->db->order_by('ldm.ldm_update_date DESC');
            } else if (isset($requestParams['sorting']) && $requestParams['sorting'] == 2) {
                $this->db->order_by('ldm.ldm_created_date DESC');
            } else {
                $this->db->order_by('ldm.ldm_update_date DESC');
                $this->db->order_by('ldm.ldm_id');
            }
        }


        return $this;
    }

    public function sortingTabwise($requestParams)
    {

        $curdatetime = "curdate()";
        if (isset($requestParams['type']) && $requestParams['type'] == 'noaction') {
            $this->db->order_by('ldm.ldm_created_date DESC');
        } else if (isset($requestParams['type']) && $requestParams['type'] == 'todayfollow') {

            $this->db->order_by("(case when DATE(ldm.ldm_follow_date) = DATE(" . $curdatetime . ") then 1
               when DATE(ldm.ldm_follow_date) > DATE(" . $curdatetime . ") then 0
               when DATE(ldm.ldm_follow_date) < DATE(" . $curdatetime . ") then 2
               end) asc,
                (case when DATE(ldm.ldm_follow_date) <> DATE(" . $curdatetime . ")then ldm.ldm_follow_date end ) desc,time(ldm.ldm_follow_date) asc");
        } else if (isset($requestParams['type']) && $requestParams['type'] == 'pastfollow') {

            $this->db->order_by("(case when DATE(ldm.ldm_follow_date) = DATE(" . $curdatetime . ") then 1
               when DATE(ldm.ldm_follow_date) > DATE(" . $curdatetime . ") then 0
               when DATE(ldm.ldm_follow_date) < DATE(" . $curdatetime . ") then 2
               end) asc,
                (case when DATE(ldm.ldm_follow_date) <> DATE(" . $curdatetime . ")then ldm.ldm_follow_date end ) desc,time(ldm.ldm_follow_date) asc");
        } else if (isset($requestParams['type']) && $requestParams['type'] == 'futurefollow') {

            $this->db->order_by("(case when DATE(ldm.ldm_follow_date) = DATE(" . $curdatetime . ") then 1
               when DATE(ldm.ldm_follow_date) > DATE(" . $curdatetime . ") then 0
               when DATE(ldm.ldm_follow_date) < DATE(" . $curdatetime . ") then 2
               end) asc,
                (case when DATE(ldm.ldm_follow_date) <> DATE(" . $curdatetime . ")then ldm.ldm_follow_date end ) desc,time(ldm.ldm_follow_date) asc");
        } else if (isset($requestParams['type']) && $requestParams['type'] == 'all' && $requestParams['filter_data_type'] != 'todayworks') {
            $this->db->order_by('ldm.ldm_created_date DESC');
        } else if (isset($requestParams['type']) && $requestParams['type'] == 'all' && $requestParams['filter_data_type'] == 'todayworks') {

            $this->db->order_by("IF(DATE(gtdate)  = DATE(now()), 0, 1),
                                  IF(DATE(gtdate)  = DATE(now()), TO_DAYS(gtdate), UNIX_TIMESTAMP(gtdate) * -1)");
        } else if (isset($requestParams['type']) && $requestParams['type'] == 'closed') {
            $this->db->order_by('ldm.ldm_update_date DESC');
        } else if (isset($requestParams['type']) && $requestParams['type'] == 'converted') {
            $this->db->order_by('ldm.ldm_update_date DESC');
        }
        return $this;
    }

    public function webTodayGetLeadsFilter($requestParams)
    {
        $select = $this->db;
        $objBuyLeadCarDetail = new Crm_buy_lead_car_detail();
        if (isset($requestParams['keyword']) && $requestParams['keyword'] != '') {
            $select->where("(ldm.ldm_name like '%" . trim($requestParams['keyword']) . "%' or lc.mobile like '%" . trim($requestParams['keyword']) . "%' or ldm.ldm_alt_mobile like '%" . trim($requestParams['keyword']) . "%' or ldm.ldm_email like '%" . trim($requestParams['keyword']) . "%')");
        }
        $leadTypeLand = '';
        if (isset($requestParams['pendingleads']) && $requestParams['pendingleads'] == 'pendingleads') {
            $leadTypeLand = $requestParams['pendingleads'];
        }
        $leadsID = $objBuyLeadCarDetail->getLeadsByCarId($requestParams['gaadi_id'], $leadTypeLand);
        if ((isset($requestParams['pendingleads']) || isset($requestParams['pendingleads'])) && ($requestParams['viewlead'] == 'viewlead' || $requestParams['pendingleads'] == 'pendingleads') && count($leadsID) > 0) {
            $select->where("ldm.ldm_id in(" . $leadsID['leadsID'] . " )");
        }
        if (isset($requestParams['lead_source']) && $requestParams['lead_source'] != '') {
            if ($requestParams['lead_source'] == 'Gaadi') {
                $select->where("lower(ldm.ldm_source) in ('gaadi','','self','ub')");
            } else {
                $select->where("ldm.ldm_source='" . $requestParams['lead_source'] . "'");
            }
        }
        if (isset($requestParams['status']) && $requestParams['status'] != '') {
            $select->where("ldm.ldm_status_id = '" . $requestParams['status'] . "'");
        }
        if (isset($requestParams['startdate']) && $requestParams['startdate'] != '') {
            $select->where("DATE(ldm.ldm_update_date) >=", $this->changeDateformat($requestParams['startdate']));
        }
        if (isset($requestParams['enddate']) && $requestParams['enddate'] != '') {
            $select->where("DATE(ldm.ldm_update_date) <=", $this->changeDateformat($requestParams['enddate']));
        }
        if (isset($requestParams['createStartDate']) && $requestParams['createStartDate'] != '') {
            $select->where("DATE(ldm.ldm_created_date) >=", $this->changeDateformat($requestParams['createStartDate']));
        }
        if (isset($requestParams['createEndDate']) && $requestParams['createEndDate'] != '') {
            $select->where("DATE(ldm.ldm_created_date) <=", $this->changeDateformat($requestParams['createEndDate']));
        }
        if (isset($requestParams['startfollowdate']) && $requestParams['startfollowdate'] != '') {
            $select->where("DATE(ldm.ldm_follow_date) >=", $this->changeDateformat($requestParams['startfollowdate']));
        }
        if (isset($requestParams['endfollowdate']) && $requestParams['endfollowdate'] != '') {
            $select->where("DATE(ldm.ldm_follow_date) <=", $this->changeDateformat($requestParams['endfollowdate']));
        }
        if ((isset($requestParams['verified']) && $requestParams['verified'] != '')) {
            $select->where("ldm.gaadi_verified ='" . $requestParams['verified'] . "'");
        }

        if ((isset($requestParams["otp_verified"]) && $requestParams["otp_verified"] != '')) {
            $select->where("lc.opt_verified ='" . $requestParams["otp_verified"] . "'");
        }
        /* //$whereWalkin
        $select->where("DATE(ldm.ldm_walkin_date) <= ",$this->date);
        $select->where("DATE(ldm.ldm_walkin_date) >= ",$lastsevenDate);
        
        //$whereUpdated
        $select->where("DATE(ldm.ldm_update_date) <= ",$this->date);
        $select->where("DATE(ldm.ldm_update_date) >= ",$lastsevenDate);
        * 
        */
    }


    public function webTodayGetLeadsFilterByTab($requestParams)
    {
        //echo "<pre>";print_r($requestParams);exit;
        $select = $this->db;
        $lastsevenDate = date('Y-m-d', strtotime('-6 days'));
        $todayDate     = date('Y-m-d');
        if (isset($requestParams['type']) && $requestParams['type'] == 'noaction') {
            //$whereCreated
            $select->where("ldm.ldm_status_id", "1");
            $select->where("DATE(ldm.ldm_created_date) <= ", $this->date);
            $select->where("DATE(ldm.ldm_created_date) >= ", $lastsevenDate);
        }
        if (isset($requestParams['type']) && $requestParams['type'] == 'todayfollow') {
            //$whereFlollow
            $select->where_in("ldm.ldm_status_id", array('2', '3'));
            $select->where("DATE(ldm.ldm_follow_date) <= ", $this->date);
            $select->where("DATE(ldm.ldm_follow_date) >= ", $lastsevenDate);
        }

        if (isset($requestParams['type']) && $requestParams['type'] == 'followfuturedate') {
            $select->where("DATE(ldm.ldm_follow_date) > ", $this->date);
            $select->where_not_in("ldm.ldm_status_id", array('1', '12', '13'));
        }
        if (isset($requestParams['type']) && $requestParams['type'] == 'pastfollow') {
            $select->where_in("ldm.ldm_status_id", array('4', '9'));
            //$whereWalkin
            $select->where("DATE(ldm.ldm_walkin_date) <= ", $this->date);
            $select->where("DATE(ldm.ldm_walkin_date) >= ", $lastsevenDate);
            //$whereFlollow
            $select->where("DATE(ldm.ldm_follow_date) <= ", $this->date);
            $select->where("DATE(ldm.ldm_follow_date) >= ", $lastsevenDate);
        }
        if (isset($requestParams['type']) && $requestParams['type'] == 'futurefollow') {
            $select->where_in("ldm.ldm_status_id", array('10', '11'));
            $select->where("DATE(ldm.ldm_follow_date) <= ", $this->date);
            $select->where("DATE(ldm.ldm_follow_date) >= ", $lastsevenDate);
        }
        if (isset($requestParams['type']) && $requestParams['type'] == 'closed') {

            $select->where("ldm.ldm_status_id", '13');
        }
        if (isset($requestParams['type']) && $requestParams['type'] == 'converted') {
            $select->where("ldm.ldm_status_id", '12');
        }

        if (isset($requestParams['type']) && $requestParams['type'] == 'all') {
            //echo "asdsadas";exit;
            $select->where("(DATE(ldm.ldm_created_date) <= '" . $this->date . "' and DATE(ldm.ldm_created_date) >='" . $lastsevenDate . "' or DATE(ldm.ldm_follow_date) <='" . $this->date . "' and DATE(ldm.ldm_follow_date) >='" . $lastsevenDate . "' or DATE(ldm.ldm_walkin_date) <='" . $this->date . "' and DATE(ldm.ldm_walkin_date) >='" . $lastsevenDate . "')");
            /* $select->where("DATE(ldm.ldm_created_date) <= ", $this->date);
            $select->where("DATE(ldm.ldm_created_date) >= ", $lastsevenDate);
            $select->or_where("DATE(ldm.ldm_follow_date) <= ", $this->date);
            $select->or_where("DATE(ldm.ldm_follow_date) >= ", $lastsevenDate);
            
           */
            $select->where_in("ldm.ldm_status_id", array('1', '2', '3', '4', '9', '10', '11'));
            $select->where_not_in("ldm.ldm_status_id", array('12', '13'));
        }
    }
    public function webGetLeadsFilter($requestParams)
    {
        $select = $this->db;
        $objBuyLeadCarDetail = new Crm_buy_lead_car_detail();

        if (isset($requestParams['filter']) && $requestParams['filter'] != '') {

            $startdate = date('Y-m-d', strtotime('-6 days'));
            $enddate = date('Y-m-d');
            if (isset($requestParams['pendingleads']) && $requestParams['pendingleads'] == 'pendingleads') {
                $lastsevenDate = date('Y-m-d', strtotime('-6 days'));
                $todayDate = date('Y-m-d');
                $whereFlollow         = " AND    DATE(ldm.ldm_follow_date) >= '$lastsevenDate' AND DATE(ldm.ldm_follow_date) <= '$todayDate'";
                $whereCreated         = "  AND    DATE(ldm.ldm_created_date) >= '$lastsevenDate' AND  DATE(ldm.ldm_created_date) <= '$todayDate'";
                $whereWalkin          = "  AND    DATE(ldm.ldm_walkin_date) >= '$lastsevenDate' AND  DATE(ldm.ldm_walkin_date) <= '$todayDate'";
                $whereUpdated         = "  AND    DATE(ldm.ldm_created_date) >= '$lastsevenDate' AND  DATE(ldm.ldm_created_date) <= '$todayDate'";
                $select->where(" ( ldm.ldm_status_id = '1' $whereCreated OR  ldm.ldm_status_id IN ('2', '3') $whereCreated OR  ldm.ldm_status_id = '4' $whereWalkin OR  ldm.ldm_status_id IN ('10','9','11') $whereUpdated)");
            } else {
                $select->where(" DATE(ldm.ldm_created_date) >='$startdate' ");
                $select->where(" DATE(ldm.ldm_created_date) <='$enddate' ");
            }
        }

        if (isset($requestParams['keyword']) && $requestParams['keyword'] != '') {
            $select->where("(ldm.ldm_name like '%" . trim($requestParams['keyword']) . "%' or lc.mobile like '%" . trim($requestParams['keyword']) . "%' or ldm.ldm_alt_mobile like '%" . trim($requestParams['keyword']) . "%' or ldm.ldm_email like '%" . trim($requestParams['keyword']) . "%')");
        }
        $leadTypeLand = '';
        if (isset($requestParams['pendingleads']) && $requestParams['pendingleads'] == 'pendingleads') {
            $leadTypeLand = $requestParams['pendingleads'];
        }
        $leadsID = $objBuyLeadCarDetail->getLeadsByCarId($requestParams['gaadi_id'], $leadTypeLand);
        if ((isset($requestParams['pendingleads']) || isset($requestParams['pendingleads'])) && ($requestParams['viewlead'] == 'viewlead' || $requestParams['pendingleads'] == 'pendingleads') && count($leadsID) > 0) {
            $select->where("ldm.ldm_id in(" . $leadsID['leadsID'] . " )");
        }
        if (isset($requestParams['lead_source']) && $requestParams['lead_source'] != '') {
            if ($requestParams['lead_source'] == 'Gaadi') {
                $select->where("lower(ldm.ldm_source) in ('gaadi','','self','ub')");
            } else {
                $select->where("ldm.ldm_source='" . $requestParams['lead_source'] . "'");
            }
        }
        if (isset($requestParams['status']) && $requestParams['status'] != '') {
            $select->where("ldm.ldm_status_id = '" . $requestParams['status'] . "'");
        }
        if (isset($requestParams['fstatus']) && $requestParams['fstatus'] != '') {
            $select->where("ldm.ldm_status_id = '" . $requestParams['fstatus'] . "'");
        }
        if (isset($requestParams['startdate']) && $requestParams['startdate'] != '') {
            $select->where("DATE(ldm.ldm_update_date) >=", $this->changeDateformat($requestParams['startdate']));
        }
        if (isset($requestParams['enddate']) && $requestParams['enddate'] != '') {
            $select->where("DATE(ldm.ldm_update_date) <=", $this->changeDateformat($requestParams['enddate']));
        }
        if (isset($requestParams['createStartDate']) && $requestParams['createStartDate'] != '') {
            $select->where("DATE(ldm.ldm_created_date) >=", $this->changeDateformat($requestParams['createStartDate']));
        }
        if (isset($requestParams['createEndDate']) && $requestParams['createEndDate'] != '') {
            $select->where("DATE(ldm.ldm_created_date) <=", $this->changeDateformat($requestParams['createEndDate']));
        }
        if (isset($requestParams['startfollowdate']) && $requestParams['startfollowdate'] != '') {
            $select->where("DATE(ldm.ldm_follow_date) >=", $this->changeDateformat($requestParams['startfollowdate']));
        }
        if (isset($requestParams['endfollowdate']) && $requestParams['endfollowdate'] != '') {
            $select->where("DATE(ldm.ldm_follow_date) <=", $this->changeDateformat($requestParams['endfollowdate']));
        }
        if ((isset($requestParams['verified']) && $requestParams['verified'] != '')) {
            $select->where("ldm.gaadi_verified ='" . $requestParams['verified'] . "'");
        }

        if ((isset($requestParams["otp_verified"]) && $requestParams["otp_verified"] != '')) {
            $select->where("lc.opt_verified ='" . $requestParams["otp_verified"] . "'");
        }
        if ((isset($requestParams["assigned_to"]) && $requestParams["assigned_to"] != '')) {
            $select->where("ldm.assigned_to ='" . $requestParams["assigned_to"] . "'");
        }

        //return $select;
    }

    public function webGetLeadsFilterbyTab($requestParams)
    {
        $select = $this->db;
        if (isset($requestParams['type']) && $requestParams['type'] == 'noaction') {
            //$select->where("DATE(ldm.ldm_follow_date)","0000-00-00");
            $select->where("ldm.ldm_status_id", "1");
        }
        if (isset($requestParams['type']) && $requestParams['type'] == 'todayfollow') {
            $select->where("DATE(ldm.ldm_follow_date) <= ", $this->date);
            $select->where_in("ldm.ldm_status_id", array('2', '3'));
        }
        if (isset($requestParams['type']) && $requestParams['type'] == 'followfuturedate') {
            $select->where("DATE(ldm.ldm_follow_date) >", $this->date);
            $select->where_not_in("ldm.ldm_status_id", array('1', '12', '13'));
        }
        if (isset($requestParams['type']) && $requestParams['type'] == 'pastfollow') {
            $select->where("DATE(ldm.ldm_follow_date) <= ", $this->date);
            $select->where_in("ldm.ldm_status_id", array('4', '9'));
        }
        if (isset($requestParams['type']) && $requestParams['type'] == 'futurefollow') {
            $select->where("DATE(ldm.ldm_follow_date) <= ", $this->date);
            $select->where_in("ldm.ldm_status_id", array('10', '11'));
        }
        if (isset($requestParams['type']) && $requestParams['type'] == 'closed') {

            $select->where("ldm.ldm_status_id", '13');
        }
        if (isset($requestParams['type']) && $requestParams['type'] == 'converted') {
            $select->where("ldm.ldm_status_id", '12');
        }
        if (isset($requestParams['type']) && $requestParams['type'] == 'assigned_leads_tab') {
            $select->where_not_in("ldm.assigned_to", ['', '0']);
            $select->where("ldm.assigned_to is not NULL ");
        }
        if (isset($requestParams['type']) && $requestParams['type'] == 'unassigned_leads_tab') {
            // $select->where_in("ldm.assigned_to",['','0']);
            $select->where("ldm.assigned_to is NULL ");
        }
    }

    function leadTabCounts($request)
    {
        $data = array();

        $this->db->select("sum( CASE WHEN ldm.assigned_to is not null THEN 1 ELSE 0 END) AS assigned_leads, sum( CASE WHEN ldm.assigned_to is null THEN 1 ELSE 0 END) AS un_assigned_leads,sum(CASE WHEN (ldm.ldm_status_id='1') THEN 1 ELSE 0 END) AS New,sum(CASE WHEN (DATE(ldm.ldm_follow_date) <= curdate() and ldm.ldm_status_id in ('2','3')) THEN 1 ELSE 0 END) as follow_up,sum(CASE WHEN ((DATE(ldm.ldm_follow_date) > curdate() and ldm.ldm_status_id not in ('1','12','13'))) THEN 1 ELSE 0 END) as future_follow_up,sum(CASE WHEN (DATE(ldm.ldm_follow_date) <= curdate() and ldm.ldm_status_id in ('4','9')) THEN 1 ELSE 0 END) AS walkIn,sum(CASE WHEN (DATE(ldm.ldm_follow_date) <= curdate() and ldm.ldm_status_id in ('10','11')) THEN 1 ELSE 0 END) AS finalized,sum(CASE WHEN (ldm.ldm_status_id='12') THEN 1 ELSE 0 END) AS converted,sum(CASE WHEN (ldm.ldm_status_id='13') THEN 1 ELSE 0 END) AS closed,count(ldm.ldm_id) as alllead");
        $this->db->from('crm_buy_lead_dealer_mapper as ldm');
        $this->db->join('crm_buy_lead_customer as lc', 'lc.id=ldm.ldm_customer_id', 'left');
        $this->db->join('crm_buy_lead_customer_preferences as lcp', 'lcp.lcp_lead_dealer_mapper_id = ldm.ldm_id AND lcp.lcp_is_latest=1 AND lcp.lcp_active=1', 'left');
        $this->db->join('crm_buy_customer_status AS cs', 'cs.id=ldm.ldm_status_id', 'left');
        $this->db->join('ublms_locations as loc', 'ldm.ldm_location_id = loc.location_id', 'left');
        /* if (isset($request['type']) && $request['type'] == 'noaction') {
            $this->db->where("DATE(ldm.ldm_follow_date) ='0000-00-00'");
            $this->db->where("ldm.ldm_status_id =", "1");
        }
        if (isset($request['type']) && $request['type'] == 'todayfollow') {
            $this->db->where("DATE(ldm.ldm_follow_date) <=", $this->date);
            $this->db->where_in("ldm.ldm_status_id", array('2', '3'));
        }
        if (isset($request['type']) && $request['type'] == 'followfuturedate') {

            $this->db->where("DATE(ldm.ldm_follow_date) >", $this->date);
            $this->db->where_not_in("ldm.ldm_status_id", array('1', '12', '13'));
        }
        if (isset($request['type']) && $request['type'] == 'pastfollow') {
            $this->db->where("DATE(ldm.ldm_follow_date) <=", $this->date);
            $this->db->where_in("ldm.ldm_status_id", array('4', '9'));
        }
        if (isset($request['type']) && $request['type'] == 'futurefollow') {
            $this->db->where("DATE(ldm.ldm_follow_date) <=", $this->date);
            $this->db->where_in("ldm.ldm_status_id", array('10', '11'));
        }

        if (isset($request['type']) && $request['type'] == 'closed') {
            $this->db->where("ldm.ldm_status_id =", "13");
        }
        if (isset($request['type']) && $request['type'] == 'converted') {
            $this->db->where("ldm.ldm_status_id =", "12");
        }*/

        /* $lastdaydate = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 7));
        if (isset($request['today_lead']) && $request['today_lead']) {
            $this->db->where("DATE(ldm.ldm_update_date) >=", $lastdaydate);
        }*/
        $this->db->where("ldm.ldm_dealer_id", $request['ucdid']);
        if ($this->session->userdata['userinfo']['is_admin'] != 1) {
            $this->db->where('ldm.assigned_to', $this->session->userdata['userinfo']['id']);
        }
        $this->db->where("ldm.ldm_dealer_id>", '0');
        $this->db->where("lc.mobile>", '0');

        $this->webGetLeadsFilter($request);
        $this->db->group_by("ldm.ldm_dealer_id");

        $query = $this->db->get();
        $data =  current($query->result_array());
        //echo $str = $this->db->last_query();
        return $data;
    }

    function assignUnassignlead($request)
    {
        //echo "<pre>";print_r($request);exit;
        $carId = $request['carid'];
        $dealerID = $request['ucdid'];
        $lead_id = $request['lead_id'];
        $favourite = $request['favourite'];
        //echo "<pre>";print_r($request);exit;
        if ($dealerID == '') {
            return array('status' => 'F', 'msg' => 'Parameter dealerID is empty.', 'error' => 'Parameter dealerID is empty');
        }

        if ($lead_id == '') {
            return array('status' => 'F', 'msg' => 'Parameter leadID is empty.', 'error' => 'Parameter leadID is empty.');
        }
        if ($carId == '') {
            return array('status' => 'F', 'msg' => 'Parameter carId is empty.', 'error' => 'Parameter carId is empty');
        }
        if (!empty($request['carid'])) {
            $addcustomerdetail = array();
            $car_ids = explode(",", $request['carid']);
            foreach ($car_ids as $key => $val) {
                //lead with carId
                $totrec = 0;
                $lastmakemodel = '';
                $lastmake = '';
                $lastmodel = '';
                $sql = "select id as gaadi_id from crm_used_car where id='" . $val . "'";
                $result =  $this->db->query($sql, [])->result_object();
                //echo "<PRE>";
                //print_r($result);
                $totrec = count($result);
                $datetime = $this->dateTime;
                if ($totrec > 0) {
                    $requestAssignUnassign = [];
                    $requestAssignUnassign['lead_id'] = $lead_id;
                    $requestAssignUnassign['car_id'] = $carId;
                    $requestAssignUnassign['favourite'] = $favourite;
                    $carleadId = $this->setBuyLeadCarDetail($requestAssignUnassign);
                    //$carleadId = $this->setlead_car_detail($lead_id, $result[0]->gaadi_id, $favourite);
                    if ($val > 0) {
                        $this->db->query("update crm_used_car set last_update_date='" . $this->dateTime . "' where id='" . $val . "'");
                        $this->db->query("update crm_buy_lead_dealer_mapper set syncd_with_dc='0', ldm_update_date='" . $this->dateTime . "' where ldm_id='" . $lead_id . "'");
                    }
                }
            }
            if ($carleadId > 0 && $favourite == '1') {
                return array('status' => 'T', 'msg' => 'Car Assigned Successfully', 'error' => '');
            } else if ($carleadId > 0 && $favourite == '0') {
                return array('status' => 'T', 'msg' => 'Car Unassigned Successfully.', 'error' => '');
            } else {

                return array('status' => 'T', 'msg' => 'Car Not Assigned.', 'error' => 'Car Not Assigned.');
            }
        } else {

            return array('status' => 'T', 'msg' => 'Car Not Assigned.', 'error' => 'Car Not Assigned.');
        }
    }

    function changeDateformat($date)
    {
        if ($date != '') {
            $date_array = explode('/', date($date));
            $date = trim($date_array[2]) . '-' . trim($date_array[1]) . '-' . trim($date_array[0]);
            // $date=date('Y-m-d',strtotime($date));  
        }
        return $date;
    }


    public function todayLeadTabcount($request)
    {
        $data = array();
        $lastsevenDate = date('Y-m-d', strtotime('-6 days'));
        $todayDate     = date('Y-m-d');
        $whereFlollow         = " AND    DATE(ldm.ldm_follow_date) >= '$lastsevenDate' AND DATE(ldm.ldm_follow_date) <= '$todayDate'";
        $whereCreated         = "  AND    DATE(ldm.ldm_created_date) >= '$lastsevenDate' AND  DATE(ldm.ldm_created_date) <= '$todayDate'";
        $whereWalkin          = "  AND    DATE(ldm.ldm_walkin_date) >= '$lastsevenDate' AND  DATE(ldm.ldm_walkin_date) <= '$todayDate'";
        $whereUpdated         = "  AND    DATE(ldm.ldm_update_date) >= '$lastsevenDate' AND  DATE(ldm.ldm_update_date) <= '$todayDate'";

        $this->db->select("SUM(CASE
                          WHEN (ldm.ldm_status_id IN ('10','11') $whereFlollow ) THEN 1
                          ELSE 0
                        END) AS finalized,
                        SUM(CASE
                          WHEN (ldm.ldm_status_id IN ('2', '3')  $whereFlollow ) THEN 1
                          ELSE 0
                        END) AS follow_up,sum(CASE WHEN ((DATE(ldm.ldm_follow_date) > curdate() and ldm.ldm_status_id not in ('1','12','13'))) THEN 1 ELSE 0 END) as future_follow_up,
                        SUM(CASE
                          WHEN (ldm.ldm_status_id = '1' $whereCreated ) THEN 1
                          ELSE 0
                        END) AS New,
                        SUM(CASE
                          WHEN (ldm.ldm_status_id  in ('4','9')  $whereFlollow) THEN 1
                          ELSE 0
                        END) AS Scheduled,
                        SUM(CASE
                          WHEN (ldm.ldm_status_id = '4' $whereFlollow 
                        AND  DATE(ldm.ldm_walkin_date) > '$todayDate') THEN 1
                          ELSE 0
                        END) AS Reminder,
                        SUM(CASE
                          WHEN (ldm.ldm_status_id = '12' $whereUpdated) THEN 1
                          ELSE 0
                        END) AS converted,
                       SUM(CASE
                          WHEN (ldm.ldm_status_id = '13' $whereUpdated) THEN 1
                          ELSE 0
                        END) AS closed");
        $this->db->from('crm_buy_lead_dealer_mapper as ldm');
        $this->db->join('crm_buy_lead_customer as lc', 'lc.id=ldm.ldm_customer_id', 'left');
        $this->db->join('crm_buy_lead_customer_preferences as lcp', 'lcp.lcp_lead_dealer_mapper_id = ldm.ldm_id AND lcp.lcp_is_latest=1 AND lcp.lcp_active=1', 'left');
        $this->db->join('crm_buy_customer_status AS cs', 'cs.id=ldm.ldm_status_id', 'left');
        $this->db->join('ublms_locations as loc', 'ldm.ldm_location_id = loc.location_id', 'left');

        $this->db->where("ldm.ldm_dealer_id", $request['ucdid']);
        $this->db->where("ldm.ldm_dealer_id>", '0');
        if ($this->session->userdata['userinfo']['is_admin'] != 1) {
            $this->db->where('ldm.assigned_to', $this->session->userdata['userinfo']['id']);
        }
        $this->db->where("lc.mobile>", '0');
        $this->webTodayGetLeadsFilter($request);
        $this->db->group_by("ldm.ldm_dealer_id");

        $query = $this->db->get();
        $data =  current($query->result_array());
        //echo $str = $this->db->last_query();

        if ($data) {
            $data['walkIn'] = $data['Scheduled']; //$leadCountData[0]->Reminder+
            $data['future_follow_up'] = 0;
            $data['alllead'] = $data['Scheduled'] + $data['New'] + $data['follow_up'] + $data['finalized']; //$leadCountData[0]->Reminder+
        }
        //   echo "<pre>";print_r($data);exit;
        return $data;
    }

    public function getMakeModelName($modelIds)
    {
        $makeModelStr = '';
        if (!empty($modelIds)) {
            $sql = "Select id, make, model from make_model";
            $sql .= " where id IN (" . $modelIds . ") ";
            $sql .= " order by model ASC";
            $modelData = $this->db->query($sql, [])->result_object();
            if (isset($modelData) && !empty($modelData)) {
                foreach ($modelData as $modelKey => $modelVal) {
                    $makeModelStr .= $modelVal->make . " " . $modelVal->model . ',';
                }
            }
        }
        if (!empty($makeModelStr)) {
            $makeModelStr = substr($makeModelStr, 0, -1);
        }
        return $makeModelStr;
    }

    public function getMakeName($makeIds)
    {
        $makeStr = '';
        if (!empty($makeIds)) {
            $sql = "Select id, make from car_make";
            $sql .= " where id IN (" . $makeIds . ") ";
            $makeData = $this->db->query($sql, [])->result_object();
            if (isset($makeData) && !empty($makeData)) {
                foreach ($makeData as $makeKey => $makeVal) {
                    $makeStr .= $makeVal->make . ',';
                }
            }
        }
        if (!empty($makeStr)) {
            $makeStr = substr($makeStr, 0, -1);
        }
        return $makeStr;
    }

    public function getBuyCustomer($keyword)
    {
        $ar = explode('(', $keyword);
        if (!empty($ar[0])) {
            $keyword = $ar[0];
        }
        $this->db->select("lc.mobile,ldm.ldm_name as name,ldm.ldm_id as lead_id");
        $this->db->from('crm_buy_lead_dealer_mapper as ldm');
        $this->db->join('crm_buy_lead_customer as lc', 'lc.id=ldm.ldm_customer_id', 'left');
        $this->db->where("ldm.ldm_dealer_id>", '0');
        $this->db->where("lc.mobile>", '0');
        $this->db->where("(ldm.ldm_name like '%" . trim($keyword) . "%' or lc.mobile like '%" . trim($keyword) . "%' or ldm.ldm_alt_mobile like '%" . trim($keyword) . "%' or ldm.ldm_email like '%" . trim($keyword) . "%')");
        $this->db->where("ldm.ldm_dealer_id", DEALER_ID);
        $query = $this->db->get();
        $data =  $query->result_array();
        //echo $str = $this->db->last_query();exit;
        return $data;
    }

    public function getBuyLeadsForRc($leadid)
    {
        $this->db->select("ldm.ldm_id as leadId,lc.mobile as customer_mobile,lc.id as customer_id,uc.reg_no,uc.reg_year,ldm.ldm_name as customer_name,ldm.ldm_email as customer_email,mv.mk_id AS make_id,mv.model_id as model_id,uc.version_id as version_id,uc.reg_year,lcd.lcd_car_id as carId");
        $this->db->from('crm_buy_lead_dealer_mapper as ldm');
        $this->db->join('crm_buy_lead_car_detail as lcd', 'lcd.lcd_lead_dealer_mapper_id=ldm.ldm_id', 'left');
        $this->db->join('crm_used_car as uc', 'uc.id=lcd.lcd_car_id', 'left');
        $this->db->join('model_version as mv', 'mv.db_version_id=uc.version_id', 'left');
        $this->db->join('make_model as mm', 'mm.id=mv.model_id', 'left');
        $this->db->join('crm_buy_lead_customer as lc', 'lc.id=ldm.ldm_customer_id', 'left');
        $this->db->join('crm_buy_customer_status as cs', 'cs.id=ldm.ldm_status_id', 'left');
        $this->db->where("ldm.ldm_dealer_id>", '0');
        $this->db->where("lc.mobile>", '0');
        $this->db->where("lcd.lcd_is_latest", '1');
        $this->db->where("ldm.ldm_dealer_id", DEALER_ID);
        $this->db->where("ldm.ldm_id", $leadid);
        $query = $this->db->get();
        $data =  $query->result_array();
        //echo $str = $this->db->last_query();exit;
        return $data;
    }
    public function getdashboardLeads($requestParams)
    {
        $starttimePeriod = date('Y-m-01');
        $endtimePeriod = date('Y-m-d');
        $this->db->select(" count(CASE WHEN (activity_text IN ( 'New' ) ) THEN lead_mapper_id  ELSE NULL END) AS leadAdded,
        count(CASE WHEN (activity_text IN ( 'converted' ) ) THEN lead_mapper_id  ELSE NULL END) AS converted,
        count(CASE WHEN(activity_text IN ( 'Walk-in Done' ) ) THEN lead_mapper_id ELSE NULL  END) AS walkdone
        ");
        $this->db->from('crm_buy_lead_history_track as ldm');
        $this->db->join('crm_buy_lead_dealer_mapper as lm', 'lm.ldm_id=ldm.lead_mapper_id');
        $this->db->where('ldm.dealer_id', $requestParams['ucdid']);
        $this->db->where(" date_format(datetime, '%Y-%m-%d') >= '$starttimePeriod'");
        $this->db->where(" date_format(datetime, '%Y-%m-%d') <= '$endtimePeriod'");
        if ($this->session->userdata['userinfo']['is_admin'] != 1) {
            $this->db->where('lm.assigned_to', $this->session->userdata['userinfo']['id']);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $result = $query->result_array();
        //print_r($result);die;
        return  $result;
    }

    public function getLeadsPending($dealerId)
    {
        $startDate = date('Y-m-d', strtotime('-6 days'));
        $endDate = date('Y-m-d');
        if ($dealerId) {
            $this->db->select(" Sum(CASE 
                            WHEN ( ldm.ldm_status_id IN ( '10' ) 
                                   AND Date(ldm.ldm_created_date) >= '$startDate' 
                                   AND Date(ldm.ldm_created_date) <= '$endDate' ) THEN 1 
                            ELSE 0 
                          END) as offer,
                        Sum(CASE 
                            WHEN ( ldm.ldm_status_id IN ( '9' ) 
                               AND Date( ldm.ldm_created_date) >= '$startDate' 
                               AND Date(ldm.ldm_created_date) <= '$endDate' ) THEN 1 
                            ELSE 0 
                         END) as walkedin,
                        Sum(CASE 
                            WHEN ( ldm.ldm_status_id IN ( '11' ) 
                                   AND Date(ldm.ldm_created_date) >= '$startDate'
                                   AND Date(ldm.ldm_created_date) <= '$endDate' ) THEN 1 
                            ELSE 0 
                          END) as booked,
                        Sum(CASE 
                            WHEN ( ldm.ldm_status_id IN ( '2', '3' ) 
                                   AND Date(ldm.ldm_follow_date) >= '$startDate' 
                                   AND Date(ldm.ldm_follow_date) <= '$endDate' ) THEN 1 
                            ELSE 0 
                          END) as follow_up,
                          Sum(CASE 
                            WHEN ( ldm.ldm_status_id = '1' 
                                   AND Date(ldm.ldm_created_date) >= '$startDate' 
                                   AND Date(ldm.ldm_created_date) < '$endDate' ) THEN 1 
                            ELSE 0 
                          END) as pending,
                          Sum(CASE 
                            WHEN ( ldm.ldm_status_id = '4' 
                                   AND Date(ldm.ldm_created_date) >= '$startDate'
                                   AND Date(ldm.ldm_created_date) <= '$endDate' 
                                   AND Date(ldm.ldm_walkin_date) > '$endDate' ) THEN 1 
                            ELSE 0 
                          END) as reminder,
                        Sum(CASE 
                            WHEN ( ldm.ldm_status_id = '4' 
                               AND Date(ldm.ldm_walkin_date) >= '$startDate' 
                               AND Date(ldm.ldm_walkin_date) <= '$endDate' ) THEN 1 
                            ELSE 0 
                            END) as scheduled");
            $this->db->from('crm_buy_lead_dealer_mapper as ldm');
            //$this->db->join(array('lc' => 'buy_lead_customer'), "lc.id = crm_buy_lead_dealer_mapper.ldm_customer_id", [], 'left');
            $this->db->join('crm_buy_lead_customer as lc', 'lc.id=ldm.ldm_customer_id', 'left');
            //$this->db->join(array('lcp' => 'buy_lead_customer_preferences'), "lcp.lcp_lead_dealer_mapper_id = crm_buy_lead_dealer_mapper.ldm_id AND lcp.lcp_is_latest = '1' ", [], 'left');
            $this->db->join('crm_buy_lead_customer_preferences as lcp', 'lcp.lcp_lead_dealer_mapper_id = ldm.ldm_id AND lcp.lcp_is_latest=1', 'left');
            //$this->db->join(array('cs' => 'buy_customer_status'), "cs.id  = crm_buy_lead_dealer_mapper.ldm_status_id", [], 'left');
            $this->db->join('crm_buy_customer_status AS cs', 'cs.id=ldm.ldm_status_id', 'left');
            $this->db->where('ldm.ldm_dealer_id', $dealerId['ucdid']);
            $this->db->where('lc.mobile > 0');
            //echo str_replace('"', '', $select->getSqlString()); exit;
            $query = $this->db->get();
            //echo $this->db->last_query();die;
            $result =  $query->result_array();
            //print_r($result);
            $finalSum = 0;
            if ($result) {
                foreach ($result[0] as $key => $value) :
                    if ($value) :
                        $finalSum += $value;
                    endif;
                endforeach;
            }
            return $finalSum;
        } else {
            //return   array('status'=>'F','msg'=>'Dealer id can not be blank.','error'=>'Dealer id can not be blank.');
        }
    }
    public function getclassifiedDealers($dealerId)
    {
        $this->db->select('d.*');
        $this->db->from('crm_admin_dealers as d');
        $this->db->where('d.is_classified', '1');
        $this->db->where('d.status', '1');
        $this->db->where('d.dealer_id', $dealerId);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function addCrmDCBuyerlogDetails($requestData, $id = '')
    {
        if (empty($id)) {
            $this->db->insert('crm_dc_buy_lead_log', $requestData);
            $lastId = $this->db->insert_id();
        } else {
            $this->db->where('id', $id);
            $this->db->update('crm_dc_buy_lead_log', $requestData);
            $lastId = $id;
        }
        return $lastId;
    }
    public function setleadlogStatusCommentResponse($logdetail)
    {
        if (!empty($logdetail)) {
            $this->db->insert('log_crm_buyerlead_status_comment_response', $logdetail);
            $logId = $this->db->insert_id();
        }
    }
    public function sendLeadsToDC($leaddata, $url)
    {
        if (isset($leaddata) && !empty($leaddata) > 0) {
            $vars = '';
            foreach ($leaddata as $k => $v) {
                $vars .= '&' . $k . '=' . $v;
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
            $response = curl_exec($ch);
            return $response;
        }
    }
    public function api_log($requestData, $id = '')
    {
        if (empty($id)) {
            $this->db->insert('crm_dc_sync_log', $requestData);
            $lastId = $this->db->insert_id();
        } else {
            $this->db->where('id', $id);
            $this->db->update('crm_dc_sync_log', $requestData);
            $lastId = $id;
        }
        return $lastId;
    }
    public function getAsyncLeads($requestParams)
    {

        $this->db->select('ldm.*');
        $this->db->select('lcp.*');
        $this->db->select('loc.location_name as localityname,lc.is_finance,lc.lead_score,lc.mobile,lc.opt_verified,lc.gaadi_verified as gaadi_common,cs.status_name, group_concat( lcd.lcd_car_id) car_id ');
        $this->db->from('crm_buy_lead_dealer_mapper as ldm');
        $this->db->join('crm_buy_lead_customer as lc', 'lc.id=ldm.ldm_customer_id', 'left');
        $this->db->join('crm_buy_lead_customer_preferences as lcp', 'lcp.lcp_lead_dealer_mapper_id = ldm.ldm_id AND lcp.lcp_is_latest=1 AND lcp.lcp_active=1', 'left');
        $this->db->join('crm_buy_customer_status AS cs', 'cs.id=ldm.ldm_status_id', 'left');
        $this->db->join('ublms_locations as loc', 'ldm.ldm_location_id = loc.location_id', 'left');
        $this->db->join('crm_buy_lead_car_detail as lcd', 'lcd.lcd_lead_dealer_mapper_id=ldm.ldm_id', 'left');
        $this->db->where('ldm.ldm_dealer_id', $requestParams['dealer_id']);
        $this->db->where('ldm.ldm_dealer_id>', '0');
        $this->db->where('lc.mobile>', '0');
        if (!empty($requestParams['ldm_id'])) {
            $this->db->where('ldm.ldm_id', $requestParams['ldm_id']);
        } else {
            $this->db->where('ldm.syncd_with_dc', '0');
        }
        $query = $this->db->get();

        return  $query->result_array();
    }
    public function crmToDcLeadSync($request = [])
    {
        /*
         *  PICK-UP LEADS WITH syncd_with_dc = 0
         */
        $aSyncLeads  = $this->getAsyncLeads($request);
        //print_r($aSyncLeads);die;
        $url = API_URL . "api/buyer_lead_verify_crm.php?apikey=U3KqyrewdMuCotTS&method=addBuyerLead";
        $i   = 0;
        foreach ($aSyncLeads as $leads) {
            $lead_id      = $leads['ldm_id'];
            $data_to_sync = $this->dcData($leads);

            $sent_time   = date('Y-m-d H:i:s');
            /*
             * LOG THE API REQUEST
             */
            $log_data = [
                'sync_module'   => 'lead',
                'lead_id'       => $lead_id,
                'api_url'       => $url,
                'source'        => 'crm',
                'dealer_id'     => DEALER_ID,
                //'request'       => json_encode($data_to_sync),
                'added_by'      => $this->session->userdata['userinfo']['id'],
                'sent_time'     => $sent_time,
            ];
            $log_id = $this->api_log($log_data);

            $data_to_sync['log_id'] = $log_id;
            $json_data    = json_encode($data_to_sync);
            /*
             * PUSH LEADS TO DC
             * API CALL
             */
            $dc_response = $this->sendLeadsToDC(['info' => $json_data], $url);

            $response_json = json_decode($dc_response, true);
            /*
             * LOG THE API RESPONSE
             */
            $this->api_log([
                'reference_lead_id' => $response_json['lead_results'][0]['lead_id'],
                'reference_log_id'  => $response_json['log_id'],
                'request'           => $json_data,
                'response'          => $dc_response,
                'status'            => strtoupper($response_json['lead_results'][0]['status']) == 'T' ? 'T' : 'F',
                'response_time'     => date('Y-m-d H:i:s'),
            ], $log_id);

            /*
             * IF API RESPONSE = TRUE 
             * THEN SET  syncd_with_dc = 1 
             */
            if ($response_json['lead_results'][0]['status']) {
                $i++;
                $updateData = ['syncd_with_dc' => '1'];
                $this->db->where('ldm_id', $lead_id);
                $this->db->update('crm_buy_lead_dealer_mapper', $updateData);
            }
        }
        //echo $i . ' lead(s)  synced with Dealer Central ' . PHP_EOL . 'view [request-response] log in crm_dc_sync_log';
    }

    public function dcData($crmData)
    {

        if ($crmData['status_name'] == 'Walk-in Scheduled') {
            $crmData['status_name'] = "Walk In";
        } else if ($crmData['status_name'] == 'Walk-in Done') {
            $crmData['status_name'] = "Walked In";
        }

        $historyData = $this->Crm_buy_lead_history_track->getLeadHistoryTrack($crmData['ldm_id'], '', '1');

        $dcData = [
            'lead_id'                      => $crmData['ldm_id'],
            'customer_name'                => $crmData['ldm_name'],
            'customer_mobile'              => $crmData['mobile'],
            'dc_dealer_id'                 => DEALER_ID,
            'customer_email'               => $crmData['ldm_email'],
            'comment'                      => !empty($historyData[0]['comment']['comment_text']) ? $historyData[0]['comment']['comment_text'] : '',
            'lead_alternate_mobile_number' => $crmData['ldm_alt_mobile'],
            'lead_source'                  => $crmData['ldm_source'],
            'sub_source'                   => $crmData['ldm_sub_source'],
            'next_follow'                  => ($crmData['ldm_follow_date'] != '0000-00-00 00:00:00' ? $crmData['ldm_follow_date'] : ''),
            'lead_status'                  => $crmData['status_name'],
            'locality_id'                  => $crmData['ldm_location_id'],
            'city_id'                      => $crmData['ldm_city_id'],
            'gaadi_verified'               => $crmData['gaadi_verified'],
            'opt_verified'                 => $crmData['opt_verified'],
            'is_finance'                   => $crmData['is_finance'],
            'car_id'                       => $crmData['car_id'],
            'only_update_flag'             => !empty($crmData['car_id']) ? 0 : 1,
            'ldm_lead_rating'              => $crmData['ldm_lead_rating'],
            //user preferences data
            'budget'                       => $crmData['lcp_price_from'],
            'makeIds'                      => $crmData['lcp_make'],
            'modelIds'                     => $crmData['lcp_model'],
            'fuel_type'                    => $crmData['lcp_fuel_type'],
            'transmission'                 => $crmData['lcp_transmission_type'],
            'uc_b_type'                    => $crmData['lcp_body_type'],
            //'lead_created_date'            => $crmData['ldm_created_date'],
        ];
        if (strtolower($crmData['status_name']) == 'booked') {
            $dcData['booking_amount'] = $crmData['ldm_amount'];
        }
        if (strtolower($crmData['status_name']) == 'customer offer') {
            $dcData['offer_amount'] = $crmData['ldm_amount'];
        }
        if (strtolower($crmData['status_name']) == 'converted') {
            $dcData['sale_amount'] = $crmData['ldm_amount'];
        }
        return $dcData;
    }
    public function getLeadLatestCar($lead_id)
    {

        $query = "SELECT uc.id car_id,uc.car_price 
                FROM crm_used_car uc inner join crm_buy_lead_car_detail lcd 
                on uc.id=lcd.lcd_car_id 
                where
                lcd_lead_dealer_mapper_id=$lead_id and lcd.lcd_is_latest='1' and lcd.lcd_active='1'";

        $result = $this->db->query($query)->row_array();
        return $result;
    }
    public function getLeadBasicDate($lead_id)
    {
        $query = "SELECT bl.ldm_created_date,bl.ldm_source,bl.ldm_sub_source,bl.assigned_to,cd.lcp_price_from as car_price FROM crm_buy_lead_dealer_mapper as bl inner join crm_buy_lead_customer_preferences as cd on cd.lcp_lead_dealer_mapper_id = bl.ldm_id "
            . "where bl.ldm_id=$lead_id";
        $result = $this->db->query($query)->row_array();
        return $result;
    }

    public function leadAlreadyExist($mobile, $dealer_id)
    {
        $query = "SELECT `ldm`.`ldm_status_id` FROM `crm_buy_lead_dealer_mapper` as `ldm` LEFT JOIN `crm_buy_lead_customer` as `lc` ON `lc`.`id`=`ldm`.`ldm_customer_id` LEFT JOIN `crm_buy_customer_status` AS `cs` ON `cs`.`id`=`ldm`.`ldm_status_id` 
WHERE `ldm`.`ldm_dealer_id` = " . $dealer_id . " and (`ldm`.`ldm_name` like '%" . $mobile . "%' or `lc`.`mobile` like '%" . $mobile . "%' or `ldm`.`ldm_alt_mobile` like '%" . $mobile . "%') GROUP BY `ldm`.`ldm_id`";
        $result = $this->db->query($query)->row_array();
        return $result;
    }
    public function getcurrentmonthlead($empid = '')
    {
        $starttimePeriod = date('Y-m-01');
        $endtimePeriod = date('Y-m-d');
        $where = '';
        if (!empty($empid)) {
            $where = " and cu.id = '" . $empid . "'";
        }
        $query = " SELECT `ldm`.ldm_customer_id
        FROM `crm_buy_lead_dealer_mapper` as `ldm`
        LEFT JOIN `crm_buy_lead_customer` as `lc` ON `lc`.`id`=`ldm`.`ldm_customer_id`
        LEFT JOIN `crm_buy_lead_customer_preferences` as `lcp` ON `lcp`.`lcp_lead_dealer_mapper_id` = `ldm`.`ldm_id` AND `lcp`.`lcp_is_latest`=1 AND `lcp`.`lcp_active`=1
        LEFT JOIN `crm_buy_customer_status` AS `cs` ON `cs`.`id`=`ldm`.`ldm_status_id`
        LEFT JOIN `ublms_locations` as `loc` ON `ldm`.`ldm_location_id` = `loc`.`location_id`
        LEFT JOIN `crm_user` as `cu` ON `ldm`.`assigned_to` = `cu`.`id`
        LEFT JOIN `crm_used_car_sale_case_info` as `uco` ON `uco`.`car_id`=`ldm_car_id`
        LEFT JOIN `crm_uc_sales_transactions` `t` ON `t`.`uc_sales_case_id` = `uco`.`id`
        WHERE ldm.ldm_dealer_id = '" . DEALER_ID . "'
        AND `ldm`.`ldm_dealer_id` > '0' " . $where . "
        AND `lc`.`mobile` > '0'
        AND DATE(ldm.ldm_created_date) >= '" . $starttimePeriod . "'
        AND DATE(ldm.ldm_created_date) <= '" . $endtimePeriod . "'
        GROUP BY `ldm`.`ldm_id`";
        $result = $this->db->query($query)->result_array();
        return count($result);
    }
    public function getdashboardLeadspage($flag, $flags = '')
    {
        $starttimePeriod = date('Y-m-01');
        $endtimePeriod = date('Y-m-d');
        $case = '';
        if (($flag != 'conversion') && (empty($flags))) {
            $select = " count(CASE WHEN(activity_text IN ( 'Walk-in Done' ) ) THEN lead_mapper_id ELSE NULL  END) AS counts";
            // $case = 'Walk-in Done';
        } else if (empty($flags)) {
            $select = "  count(CASE WHEN (activity_text IN ( 'converted' ) ) THEN lead_mapper_id  ELSE NULL END) AS counts";
            //$case = 'converted';
        }
        if (!empty($flags)) {
            $case = ($flag != 'conversion') ? 'Walk-in Done' : 'Converted';
            $select = "ldm.datetime as created_date,lm.ldm_id as lead_id,lm.ldm_name,lm.ldm_status_id,lm.ldm_sub_status_id,lm.ldm_source,lm.ldm_sub_source,lm.ldm_update_date,lc.mobile,lm.assigned_to,cs.status_name,icd.reg_no,icd.make_year,mm.model,mm.make,mv.db_version,lcp.*";
        }
        $this->db->select($select);
        $this->db->from('crm_buy_lead_history_track as ldm');
        $this->db->join('crm_buy_lead_dealer_mapper as lm', 'lm.ldm_id=ldm.lead_mapper_id');
        if (!empty($flags)) {
            $this->db->join('crm_buy_lead_customer as lc', 'lc.id=lm.ldm_customer_id', 'left');
            $this->db->join('crm_buy_customer_status AS cs', 'cs.id=lm.ldm_status_id', 'left');
            $this->db->join('crm_buy_lead_customer_preferences as lcp', 'lcp.lcp_lead_dealer_mapper_id = lm.ldm_id AND lcp.lcp_is_latest=1 AND lcp.lcp_active=1', 'left');
            $this->db->join('crm_user as cu', 'lm.assigned_to = cu.id', 'left');
            $this->db->join('crm_used_car as icd', 'lm.ldm_car_id = icd.id', 'left');
            $this->db->join('model_version as mv', 'mv.db_version_id=icd.version_id', 'left');
            $this->db->join('make_model as mm', 'mm.id=mv.model_id', 'left');
            $this->db->where('ldm.activity_text', $case);
        }
        $this->db->where('ldm.dealer_id', DEALER_ID);
        $this->db->where(" date_format(ldm.datetime, '%Y-%m-%d') >= '$starttimePeriod'");
        $this->db->where(" date_format(ldm.datetime, '%Y-%m-%d') <= '$endtimePeriod'");
        if ($this->session->userdata['userinfo']['is_admin'] != 1) {
            $this->db->where('lm.assigned_to', $this->session->userdata['userinfo']['id']);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();//die;
        if (!empty($flags)) {
            $result = $query->result_array();
        } else {
            $result = $query->row_array();
        }
        return  $result;
    }
}
