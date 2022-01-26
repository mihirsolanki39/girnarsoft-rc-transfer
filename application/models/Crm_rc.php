<?php

/**
 * model : Crm_rc
 * User Class to control all rc related operations.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_rc extends CI_Model
{
    private $dateTime = '';
    public function __construct()
    {
        parent::__construct();
        $this->dateTime = date("Y-m-d H:i:s");
    }

    public function getRcList($requestParams, $dealerId, $flag = '', $page = '', $limit = '')
    {
        $requestParams['rpp'] = 10;
        $responseData = array();
        $daysCount = 30;
        $perPageRecord = $requestParams['rpp'] == 0 ? 10 : $requestParams['rpp'];
        $pageNo = (isset($requestParams['page']) && $requestParams['page'] != '') ? $requestParams['page'] : '1';
        $startLimit = ($pageNo - 1) * $perPageRecord;
        $requestParams['dealerID'] = $dealerId;
        $getleads = $this->getRcleadsQuery($requestParams, $perPageRecord, $pageNo, $startLimit);

        $totalRecords = count($this->getRcleadsQuery($requestParams, $perPageRecord, $pageNo, $startLimit, '1'));
        $totalRecords = count($getleads);
        $leads = array();
        if (!empty($getleads)) {
            $i = 0;
            foreach ($getleads as $key => $val) {
                $leads[$i]['rcId'] = $val['rc_id'];
                $leads[$i]['loan_sno'] = $val['loan_sno'];
                $leads[$i]['loanno'] = $val['loanno'];
                $leads[$i]['salesexe'] = $val['salesexe'];
                $leads[$i]['dealername'] = $val['dealername'];
                $leads[$i]['source_type'] = $val['source_type'];
                $leads[$i]['buyer_case_id'] = $val['buyer_case_id'];
                $leads[$i]['customer_id'] = $val['customer_id'];
                $leads[$i]['dealerID'] = $dealerId;
                //$leads[$i]['ucdid'] = $val['ldm_dealer_id'];
                $leads[$i]['emailID'] = (stripos($val['customer_email'], "null") == true ? '' : $val['customer_email']);
                $leads[$i]['changetime'] = $val['created_date'];
                $name = ucwords(strtolower(preg_replace("/[^a-zA-Z\s]/", "", $val['customer_name'])));
                $leads[$i]['customer_name'] = (stripos($name, "null") == true ? '' : $name);
                $leads[$i]['customer_mobile'] = $val['customer_mobile'];
                $leads[$i]['mmv'] = $val['makeName'] . "-" . $val['modelName'] . "-" . $val['versionName'];
                $leads[$i]['makeName'] = $val['makeName'];
                $leads[$i]['modelName'] = $val['modelName'];
                $leads[$i]['parent_makeName'] = $val['parentmakeName'];
                $leads[$i]['parent_modelName'] = $val['parentmodelName'];
                $leads[$i]['versionName'] = $val['versionName'];
                $leads[$i]['regNo'] = $val['reg_no'];
                $leads[$i]['reg_year'] = $val['reg_year'];
                $leads[$i]['loan_ref_id'] = $val['loan_ref_id'];
                $leads[$i]['bank_name'] = $val['bank_name'];
                $leads[$i]['loan_case_type'] = $val['loan_case_type'];
                $leads[$i]['loan_disbursement_date'] = ($val['loan_disbursement_date'] != '0000-00-00 00:00:00' && !empty($val['loan_disbursement_date'])) ? date("d M, Y", strtotime($val['loan_disbursement_date'])) : '';
                $leads[$i]['loan_delivery_date'] = ($val['loan_delivery_date'] != '0000-00-00 00:00:00' && !empty($val['loan_delivery_date'])) ? date("d M, Y", strtotime($val['loan_delivery_date'])) : '';
                $leads[$i]['created_date'] = ($val['created_date'] != '') ? date("d F , Y", strtotime($val['created_date'])) : '';
                $leads[$i]['assigned_on'] = ($val['assigned_on'] != '0000-00-00' && !empty($val['assigned_on'])) ? date("d M , Y", strtotime($val['assigned_on'])) : '';
                $leads[$i]['delivery_date'] = ($val['delivery_date'] != '0000-00-00' && !empty($val['delivery_date'])) ? date("d M, Y", strtotime($val['delivery_date'])) : '';
                $leads[$i]['rc_status'] = $val['rc_status'];
                $leads[$i]['rto_slip_no'] = $val['rto_slip_no'];
                $leads[$i]['pending_from'] = $val['pending_from'];
                $leads[$i]['rto_agent'] = $val['rto_agent'];
                $leads[$i]['pending_from'] = $val['pending_from'];
                $leads[$i]['rtoName'] = $val['rtoName'];
                $leads[$i]['upload_rc_docs'] = $val['upload_rc_docs'];
                $leads[$i]['rc_detail_form_update'] = $val['rc_detail_form_update'];
                //$leads[$i]['rc_transferred_docs_date'] =($val['rc_transferred_docs_date']!='0000-00-00 00:00:00') ? date("d F, Y",strtotime($val['rc_transferred_docs_date'])) : ''; 
                $leads[$i]['rc_transferred_docs'] = $val['rc_transferred_docs'];
                $leads[$i]['rc_transferred_docs_date'] = ($val['rc_transferred_docs_date'] != '0000-00-00 00:00:00') ? date("d M, Y", strtotime($val['rc_transferred_docs_date'])) : '';
                $leads[$i]['tranferred_date'] = (!empty($val['rc_transferred_date'])) ? date("d M, Y", strtotime($val['rc_transferred_date'])) : '';
                $leads[$i]['rcpayid'] = $val['rcpayid'];
                $leads[$i]['rc_amt'] = $val['rc_amt'];
                $leads[$i]['paydates'] = $val['paydates'];
                $leads[$i]['payment_rnd_id'] = $val['payment_rnd_id'];

                $i++;
            }
        }
        $lastRecord = $pageNo * $perPageRecord;
        $nextRecords = true;
        if ($lastRecord >= $totalRecords) {
            $nextRecords = false;
        }
        $responseData['error'] = "";
        $responseData['msg'] = "username and password matched!!";
        $responseData['status'] = "T";
        if ($pageNo == '1') {
            //$responseData['budget_list'] = $this->Crm_buy_lead_customer_preferences->getbudgetList();
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

    public function getRcleadsQuery($requestParams, $perPageRecord = '', $pageNo = '', $startLimit = '')
    {
        $lastdaydate = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 7));
        $lastdaydate90 = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 90));
        $this->db->select('lcc.customer_loan_id,rc.*,irc.*,ldd.delivery_date,mm.make as makeName,mm.model as modelName,mmp.make as parentmakeName,mmp.model as parentmodelName,mv.db_version as versionName,b.bank_name,u.name as rtoName,ue.name as salesexe,d.organization as dealername,lci.source_type,rpd.payment_rnd_id,rpd.id as rcpayid,rpd.amount as rc_amt,rpd.payment_mode as rc_pay_mode,rpd.paydates,rpd.payment_banks as paybnk,rpd.instrument_no,rpd.favouring,rpd.remark,rpd.instrument_date');
        $this->db->from('crm_rc_listing as rc');
        $this->db->join('crm_rc_info as irc', 'irc.rc_id=rc.id', 'inner');
        $this->db->join('loan_customer_case as lcc', 'lcc.id=rc.loan_sno', 'left');
        $this->db->join('loan_customer_info as lci', 'lcc.customer_loan_id=lci.id', 'left');
        $this->db->join('loan_post_delivery_details as ldd', 'lcc.customer_loan_id=ldd.case_id', 'left');
        $this->db->join('model_version as mv', 'mv.db_version_id=irc.version_id', 'left');
        $this->db->join('make_model as mm', 'mm.id=mv.model_id', 'left');
        $this->db->join('make_model as mmp', 'mmp.id=mm.parent_model_id', 'left');
        $this->db->join('crm_bank_list as b', 'b.id=irc.bank_id_loan', 'left');
        $this->db->join('crm_user as u', 'u.id=irc.rto_agent and u.status="1"', 'left');
        $this->db->join('crm_user as ue', 'ue.id=lci.meet_the_customer and ue.status="1"', 'left');
        $this->db->join('crm_dealers as d', 'd.id=lci.dealer_id and d.status="1"', 'left');
        $this->db->join('crm_rc_payment_details as rpd', 'rpd.id=irc.payment_id', 'left');
        $this->db->where('rc.customer_id>', '0');
        $this->InsGetLeadsFilter($requestParams);
        $this->db->group_by(array('rc.id'));
        $this->db->order_by('irc.updated_date', 'DESC');
        if (isset($requestParams['page'])) {
            $this->db->offset((int) ($startLimit));
        }
        if (!empty($perPageRecord)) {
            $this->db->limit((int) $perPageRecord);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();die;
        $re = $query->result_array();
        //cho "<pre>";print_r($re);die;
        return $re;
    }

    public function InsGetLeadsFilter($requestParams)
    {
        $select = $this->db;
        if (!empty($requestParams['casestatus'])) {
            $this->db->where('irc.loan_case_type', $requestParams['casestatus']);
        }
        if (isset($requestParams['rcdashId']) && $requestParams['rcdashId'] != '') {
            if ($requestParams['rcdashId'] == '1') {
                $select->where("irc.rc_status='1'");
            }
            if ($requestParams['rcdashId'] == '2') {
                $select->where("irc.rc_status='2'");
            }
            if ($requestParams['rcdashId'] == '7') {
                $select->where("irc.rc_status='1'");
                $new_date = date("Y-m-d", strtotime(date('Y-m-d') . " -15 days"));
                $select->where("DATE(irc.created_date) <=", $new_date);
            }
            if ($requestParams['rcdashId'] == '8') {
                $select->where("irc.rc_status='2'");
                $new_date = date("Y-m-d", strtotime(date('Y-m-d') . " -15 days"));
                $select->where("DATE(irc.created_date) <=", $new_date);
            }
        }
        if (isset($requestParams['searchby']) && $requestParams['searchby'] == 'searchrefid') {

            $select->where("rc.loan_ref_id='" . $requestParams['keyword'] . "'");
        }
        if (isset($requestParams['searchby']) && $requestParams['searchby'] == 'searchloanno') {

            $select->where("rc.loanno='" . $requestParams['keyword'] . "'");
        }
        if (isset($requestParams['searchby']) && $requestParams['searchby'] == 'searchcustname') {

            $select->where("irc.customer_name like '%" . trim($requestParams['keyword']) . "%'");
        }
        if (isset($requestParams['searchby']) && $requestParams['searchby'] == 'searchmobile') {

            $select->where("rc.customer_mobile like '%" . trim($requestParams['keyword']) . "%'");
        }
        if (isset($requestParams['searchby']) && $requestParams['searchby'] == 'searchrto') {

            $select->where("irc.rto_slip_no='" . $requestParams['keyword'] . "'");
        }
        if (isset($requestParams['searchby']) && $requestParams['searchby'] == 'searchsno') {

            $select->where("irc.rc_id='" . $requestParams['keyword'] . "'");
        }
        if (isset($requestParams['searchby']) && $requestParams['searchby'] == 'searchreg') {

            $select->where("rc.reg_no='" . $requestParams['keyword'] . "'");
        }
        if (!empty($requestParams['searchbyvaldealer'])) {
            $select->where("lci.dealer_id='" . $requestParams['searchbyvaldealer'] . "'");
            $select->where("lci.source_type=1");
        }
        if (isset($requestParams['searchby']) && $requestParams['searchby'] == 'searchbank' && !empty($requestParams['searchbyvalbank'])) {
            $select->where("irc.bank_id_loan ='" . $requestParams['searchbyvalbank'] . "'");
        }
        if (isset($requestParams['searchby']) && $requestParams['searchby'] == 'searchrtoagent' && !empty($requestParams['agentrto'])) {
            $select->where("u.id='" . $requestParams['agentrto'] . "'");
        }
        if (isset($requestParams['pending']) && $requestParams['pending'] != '') {

            $select->where("irc.pending_from='" . $requestParams['pending'] . "'");
        }
        if (isset($requestParams['agentrto']) && $requestParams['agentrto'] != '') {

            $select->where("u.id='" . $requestParams['agentrto'] . "'");
        }
        if (isset($requestParams['rcStatus']) && $requestParams['rcStatus'] != '') {

            $select->where("irc.rc_status='" . $requestParams['rcStatus'] . "'");
        }
        if (isset($requestParams['payid']) && $requestParams['payid'] != '') {

            $select->where("irc.payment_id='" . $requestParams['payid'] . "'");
        }
        if ((!empty($requestParams['paymentStatus']))) {
            if ($requestParams['paymentStatus'] == '1') {
                $select->where('irc.payment_id', 0);
            }
            if ($requestParams['paymentStatus'] == '2') {
                $select->where('irc.payment_id != 0');
            }
        }
        if (isset($requestParams['searchdate']) && $requestParams['searchdate'] == 'deliverydate') {

            if (isset($requestParams['createStartDate']) && $requestParams['createStartDate'] != '') {
                $select->where("DATE(ldd.delivery_date) >=", $this->changeDateformat($requestParams['createStartDate']));
            }
            if (isset($requestParams['createEndDate']) && $requestParams['createEndDate'] != '') {
                $select->where("DATE(ldd.delivery_date) <=", $this->changeDateformat($requestParams['createEndDate']));
            }
        }
        if (isset($requestParams['searchdate']) && $requestParams['searchdate'] == 'transferredon') {

            if (isset($requestParams['createStartDate']) && $requestParams['createStartDate'] != '') {
                $select->where("DATE(irc.rc_transferred_date) >=", $this->changeDateformat($requestParams['createStartDate']));
            }
            if (isset($requestParams['createEndDate']) && $requestParams['createEndDate'] != '') {
                $select->where("DATE(irc.rc_transferred_date) <=", $this->changeDateformat($requestParams['createEndDate']));
            }
        }
        if (isset($requestParams['searchdate']) && $requestParams['searchdate'] == 'disbursedate') {

            if (isset($requestParams['createStartDate']) && $requestParams['createStartDate'] != '') {
                $select->where("DATE(irc.loan_disbursement_date) >=", $this->changeDateformat($requestParams['createStartDate']));
            }
            if (isset($requestParams['createEndDate']) && $requestParams['createEndDate'] != '') {
                $select->where("DATE(irc.loan_disbursement_date) <=", $this->changeDateformat($requestParams['createEndDate']));
            }
        }
        if (!empty($requestParams['search'])) {
            $wh = " ( rc.loan_ref_id='" . $requestParams['search'] . "' or irc.customer_name like '%" . trim($requestParams['search']) . "%' or rc.reg_no='" . $requestParams['search'] . "' or rpd.instrument_no='" . $requestParams['search'] . "')";
            $select->where($wh);
            // $select->or_where("irc.customer_name like '%" . trim($requestParams['search']) . "%'");
            // $select->or_where("rc.reg_no='" . $requestParams['search'] . "'");
            // $select->or_where("rpd.instrument_no='" . $requestParams['search'] . "'");
        }
    }

    public function getRchistory($rcId, $limit)
    {
        $this->db->select('h.*,u.name as created_name');
        $this->db->from('crm_rc_timeline as h');
        $this->db->join('crm_user as u', 'u.id=h.created_by', 'inner');
        $this->db->where('h.rc_id', $rcId);
        if (intval($limit) > 0) {
            $this->db->limit((int) $limit);
        }
        $this->db->order_by('h.created_on', 'DESC');
        $query = $this->db->get();
        return $historyData = $query->result_array();
    }

    public function setRcCarDetail($params)
    {
        if ($params['reg_no'] != '' && $params['customer_mobile'] != '' && $params['loan_sno'] != '') {
            $rcData = $this->getRcCarDetail($params['reg_no'], $params['customer_mobile'], '', $params['loan_sno']);
        }
        if (empty($rcData)) {
            $rcDetail['buyer_case_id'] = !empty($params['buyer_case_id']) ? $params['buyer_case_id'] : '';
            $rcDetail['loan_ref_id'] = !empty($params['loan_ref_id']) ? $params['loan_ref_id'] : '';
            $rcDetail['customer_mobile'] = !empty($params['customer_mobile']) ? $params['customer_mobile'] : '';
            $rcDetail['customer_id'] = !empty($params['customer_id']) ? $params['customer_id'] : '';
            $rcDetail['reg_no'] = !empty($params['reg_no']) ? $params['reg_no'] : '';
            $rcDetail['loanno'] = !empty($params['loanno']) ? $params['loanno'] : '';
            $rcDetail['loan_sno'] = !empty($params['loan_sno']) ? $params['loan_sno'] : '';
            $rcDetail['status'] = '1';
            $rcDetail['created_at'] = $this->dateTime;
            $this->db->insert('crm_rc_listing', $rcDetail);
            $rcId = $this->db->insert_id();
            $data['rc_id'] = $rcId;
            $data['activity'] = 'Pending';
            $data['created_by'] = $this->session->userdata['userinfo']['id'];
            $data['remark'] = 'Pending';
            $data['status'] = '1';
            $this->insertRcTimeLine($data);

            if (!empty($rcId)) {
                $rcinfo['rc_id'] = !empty($rcId) ? $rcId : '';
                $rcinfo['customer_name'] = !empty($params['customer_name']) ? $params['customer_name'] : '';
                $rcinfo['customer_email'] = !empty($params['customer_email']) ? $params['customer_email'] : '';
                $rcinfo['make_id'] = !empty($params['make_id']) ? $params['make_id'] : '';
                $rcinfo['model_id'] = !empty($params['model_id']) ? $params['model_id'] : '';
                $rcinfo['version_id'] = !empty($params['version_id']) ? $params['version_id'] : '';
                $rcinfo['reg_year'] = !empty($params['reg_year']) ? $params['reg_year'] : '';
                $rcinfo['loan_case_type'] = !empty($params['loan_case_type']) ? $params['loan_case_type'] : '0';
                $rcinfo['bank_id_loan'] = !empty($params['bank_id_loan']) ? $params['bank_id_loan'] : '';
                $rcinfo['pending_from'] = !empty($params['pending_from']) ? $params['pending_from'] : '';
                $rcinfo['loan_disbursement_date'] = !empty($params['loan_disbursement_date']) ? $params['loan_disbursement_date'] : '';
                $rcinfo['loan_delivery_date'] = !empty($params['loan_delivery_date']) ? $params['loan_delivery_date'] : '';
                $rcinfo['pending_from'] = !empty($params['buyer_case_id']) ? '2' : '1';
                $rcinfo['created_date'] = $this->dateTime;
                $this->db->insert('crm_rc_info', $rcinfo);
                $rcInfoId = $this->db->insert_id();
            }
        }
        return $rcInfoId;
    }

    function getRcCarDetail($reg_no = '', $customer_mobile = '', $id = '', $loan_sno)
    {
        $this->db->select('*');
        $this->db->from('crm_rc_listing');
        if (!empty($reg_no)) {
            $this->db->where("reg_no", $reg_no);
        }
        if (!empty($customer_mobile)) {
            $this->db->where("customer_mobile", $customer_mobile);
        }
        if (!empty($loan_sno)) {
            $this->db->where("loan_sno", $loan_sno);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    function getRcFullCarDetail($id = '', $loan_sno = "")
    {
        $this->db->select('rc.*,cr.*,rc.id as rcid,mmp.make as parent_makeName,mmp.model as parent_modelName,mm.model,mm.make,mv.db_version as version,cl.bank_name');
        $this->db->from('crm_rc_listing as rc');
        $this->db->join('crm_rc_info as cr', 'cr.rc_id=rc.id', 'inner');
        $this->db->join('model_version as mv', 'cr.version_id=mv.db_version_id', 'left');
        $this->db->join('make_model as mm', 'mv.model_id = mm.id', 'left');
        $this->db->join('make_model as mmp', 'mmp.id=mm.parent_model_id', 'left');
        $this->db->join('crm_bank_list as cl', 'cl.id = cr.bank_id_loan', 'left');
        $this->db->where(array('rc.status' => '1'));
        if ($id != 0) {
            $this->db->where("rc.id", $id);
        }
        if ($loan_sno != 0) {
            $this->db->where("rc.loan_sno", $loan_sno);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    function getLoanDetailByRefId($ref_id)
    {
        $this->db->from('loan_file_login_mapping');
        $this->db->where('ref_id', $ref_id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    function updateRcInfoTable($data, $rc_id)
    {
        if (!empty($rc_id)) {
            $data['updated_by'] = $this->session->userdata['userinfo']['id'];
            $data['updated_date'] = date('Y-m-d h:i:s');
            $this->db->where('rc_id', $rc_id);
            $this->db->update('crm_rc_info', $data);
            //echo $this->db->last_query();
            $result = $rc_id;
            return $result;
        }
    }

    function insertHistoryLog($data)
    {
        $this->db->insert('crm_rc_history_log', $data);
        return $rcInfoId = $this->db->insert_id();
    }

    function insertRcTimeLine($data)
    {
        $this->db->insert('crm_rc_timeline', $data);
        return $rcInfoId = $this->db->insert_id();
    }
    function changeDateformat($date)
    {
        if ($date != '') {
            $date = date('Y-m-d', strtotime($date));
        }
        return $date;
    }

    public function getRcListCount($requestParams, $dealerId, $flag = '')
    {
        $requestParams['rpp'] = 10;
        $responseData = array();
        $daysCount = 30;
        $perPageRecord = $requestParams['rpp'] == 0 ? 10 : $requestParams['rpp'];
        $pageNo = (isset($requestParams['page']) && $requestParams['page'] != '') ? $requestParams['page'] : '1';
        $startLimit = ($pageNo - 1) * $perPageRecord;
        $requestParams['dealerID'] = $dealerId;
        $getleads = $this->getRcleadsQueryCount($requestParams, $perPageRecord, $pageNo, $startLimit);

        $totalRecords = count($this->getRcleadsQueryCount($requestParams, $perPageRecord, $pageNo, $startLimit, '1'));
        $totalRecords = count($getleads);
        $leads = array();
        if (!empty($getleads)) {
            $i = 0;
            foreach ($getleads as $key => $val) {
                $leads[$i]['rcId'] = $val['rc_id'];
                $leads[$i]['buyer_case_id'] = $val['buyer_case_id'];
                $leads[$i]['customer_id'] = $val['customer_id'];
                $leads[$i]['dealerID'] = $dealerId;
                //$leads[$i]['ucdid'] = $val['ldm_dealer_id'];
                $leads[$i]['emailID'] = (stripos($val['customer_email'], "null") == true ? '' : $val['customer_email']);
                $leads[$i]['changetime'] = $val['created_date'];
                $name = ucwords(strtolower(preg_replace("/[^a-zA-Z\s]/", "", $val['customer_name'])));
                $leads[$i]['customer_name'] = (stripos($name, "null") == true ? '' : $name);
                $leads[$i]['customer_mobile'] = $val['customer_mobile'];
                //$leads[$i]['city_name']=ucwords(strtolower(preg_replace("/[^a-zA-Z\s]/", "", $val['city_name'])));
                //$leads[$i]['number'] = preg_replace("/[^0-9]/", "", $val['mobile']);
                $leads[$i]['mmv'] = $val['makeName'] . "-" . $val['modelName'] . "-" . $val['versionName'];
                $leads[$i]['makeName'] = $val['makeName'];
                $leads[$i]['modelName'] = $val['modelName'];
                $leads[$i]['versionName'] = $val['versionName'];
                $leads[$i]['regNo'] = $val['reg_no'];
                $leads[$i]['reg_year'] = $val['reg_year'];
                $leads[$i]['loan_ref_id'] = $val['loan_ref_id'];
                $leads[$i]['loanno'] = $val['loanno'];
                $leads[$i]['bank_name'] = $val['bank_name'];
                $leads[$i]['loan_case_type'] = $val['loan_case_type'];
                $leads[$i]['loan_disbursement_date'] = ($val['loan_disbursement_date'] != '0000-00-00 00:00:00') ? date("d M, Y", strtotime($val['loan_disbursement_date'])) : '';
                $leads[$i]['loan_delivery_date'] = ($val['loan_delivery_date'] != '0000-00-00 00:00:00') ? date("d M, Y", strtotime($val['loan_delivery_date'])) : '';
                $leads[$i]['created_date'] = ($val['created_date'] != '') ? date("d F , Y", strtotime($val['created_date'])) : '';
                $leads[$i]['rc_status'] = $val['rc_status'];
                $leads[$i]['rto_slip_no'] = $val['rto_slip_no'];
                $leads[$i]['pending_from'] = $val['pending_from'];
                $leads[$i]['rto_agent'] = $val['rto_agent'];
                $leads[$i]['pending_from'] = $val['pending_from'];
                $leads[$i]['rtoName'] = $val['rtoName'];
                $leads[$i]['upload_rc_docs'] = $val['upload_rc_docs'];
                $leads[$i]['rc_detail_form_update'] = $val['rc_detail_form_update'];
                //$leads[$i]['rc_transferred_docs_date'] =($val['rc_transferred_docs_date']!='0000-00-00 00:00:00') ? date("d F, Y",strtotime($val['rc_transferred_docs_date'])) : ''; 
                $leads[$i]['rc_transferred_docs'] = $val['rc_transferred_docs'];
                $leads[$i]['rc_transferred_docs_date'] = ($val['rc_transferred_docs_date'] != '0000-00-00 00:00:00') ? date("d M, Y", strtotime($val['rc_transferred_docs_date'])) : '';
                $leads[$i]['tranferred_date'] = (!empty($val['rc_transferred_date'])) ? date("d M, Y", strtotime($val['rc_transferred_date'])) : '';
                $i++;
            }
        }
        $responseData['error'] = "";
        $responseData['msg'] = "username and password matched!!";
        $responseData['status'] = "T";
        if ($pageNo == '1') {
            //$responseData['budget_list'] = $this->Crm_buy_lead_customer_preferences->getbudgetList();
            //$responseData['budget_list']='';
        }
        $responseData['leads'] = $leads;
        return $responseData;
    }

    public function getRcleadsQueryCount($requestParams, $perPageRecord, $pageNo, $startLimit)
    {
        $lastdaydate = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 7));
        $lastdaydate90 = date('Y-m-d', strtotime(date('Y-m-d')) - (3600 * 24 * 90));
        $this->db->select('rc.*,irc.*,mm.make as makeName,mm.model as modelName,mv.db_version as versionName,b.bank_name,u.name as rtoName');
        $this->db->from('crm_rc_listing as rc');
        $this->db->join('crm_rc_info as irc', 'irc.rc_id=rc.id', 'inner');
        $this->db->join('loan_customer_case as lcc', 'lcc.id=rc.loan_sno', 'left');
        $this->db->join('loan_customer_info as lci', 'lcc.customer_loan_id=lci.id', 'left');
        $this->db->join('loan_post_delivery_details as ldd', 'lcc.customer_loan_id=ldd.case_id', 'left');
        $this->db->join('model_version as mv', 'mv.db_version_id=irc.version_id', 'left');
        $this->db->join('make_model as mm', 'mm.id=mv.model_id', 'left');
        $this->db->join('crm_bank_list as b', 'b.id=irc.bank_id_loan', 'left');
        $this->db->join('crm_user as u', 'u.id=irc.rto_agent and u.status="1"', 'left');
        $this->db->where('rc.customer_id>', '0');
        $this->InsGetLeadsFilter($requestParams);
        $this->db->group_by(array('rc.id'));
        $this->db->order_by('irc.updated_date', 'DESC');
        $query = $this->db->get();
        return  $query->result_array();
    }
    public function getCaseIdFromSrno($srno)
    {
        $this->db->select('lcc.customer_loan_id as case_id');
        $this->db->from('loan_customer_case as lcc');
        $this->db->where('lcc.id', $srno);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['case_id'];
    }
    function updateLoanNetPaymentTable($rc_info, $rc_id)
    {
        $rc_details =  $this->getRcFullCarDetail($rc_id);
        $caseid = $this->getCaseIdFromSrno($rc_details['loan_sno']);
        if (!empty($rc_details)) {
            $data = array("rc_trans_by" => $rc_info['pending_from']);
            $data['updated_by'] = $this->session->userdata['userinfo']['id'];
            $data['updated_on'] = date('Y-m-d h:i:s');
            $this->db->where('case_id', $caseid);
            $res = $this->db->update('crm_net_payment', $data);
            return $res;
        }
    }


    function insertRcPaymentDetails($data, $id = '')
    {
        if (!empty($id)) {
            $data['update_by'] = $this->session->userdata['userinfo']['id'];
            $this->db->where('id', $id);
            $res = $this->db->update('crm_rc_payment_details', $data);
            return $id;
        } else {
            $data['created_at'] = date('Y-m-d h:i:s');
            $data['created_by'] = $this->session->userdata['userinfo']['id'];
            $this->db->insert('crm_rc_payment_details', $data);
            return $rcInfoId = $this->db->insert_id();
        }
    }

    function getRCPaymentList($param)
    {
        //echo "<pre>";print_r($param);die;
        $rpp = PAGE_LIMIT_RENEW_CASE;
        $perPageRecord = $rpp == 0 ? PAGE_LIMIT_RENEW_CASE : $rpp;
        $pageNo = (isset($param['pages']) && $param['pages'] != '') ? $param['pages'] : '1';
        $startLimit = ($pageNo - 1) * $perPageRecord;

        if ($params['is_count'] == 0) {
            $this->db->select('rcp.*,cbl.bank_name,u.name as rto_name');
        } else if ($params['is_count'] == 1) {
            $this->db->select('rcp.id as payment_id');
        }
        $this->db->from('crm_rc_payment_details as rcp');
        $this->db->join('crm_rc_info as rci', 'rci.payment_id=rcp.id', 'inner');
        $this->db->join('crm_rc_listing as rcl', 'rcl.id=rci.rc_id', 'inner');
        $this->db->join('crm_user as u', 'rci.rto_agent=u.id', 'inner');
        $this->db->join('crm_customer_banklist as cbl', 'cbl.bank_id=rcp.payment_banks', 'left');
        $this->getRCPaymentSearchQuery($param);
        $this->db->group_by('rcp.id');
        $this->db->order_by('rcp.id', 'desc');
        if ($param['is_count'] == 0) {
            if (isset($param['pages'])) {
                $this->db->offset((int) ($startLimit));
            }
            if (!empty($perPageRecord)) {
                $this->db->limit((int) $perPageRecord);
            }
        }
        $query = $this->db->get();
        $result = $query->result_array();
        // echo $this->db->last_query();die;
        if ($param['is_count'] == 1) {
            $result = count($result);
        }
        return $result;
    }

    public function getRCPaymentSearchQuery($param)
    {
        if (!empty($param['keyword'])) {
            if (isset($param['searchby']) && $param['searchby'] == 'searchrto') {
                $this->db->where("rci.rto_slip_no='" . $param['keyword'] . "'");
            }
            if (isset($param['searchby']) && $param['searchby'] == 'searchpayid') {
                $this->db->where('rcp.payment_rnd_id', $param['keyword']);
            }
            if (isset($param['searchby']) && $param['searchby'] == 'searchcustname') {
                $this->db->where('rci.customer_name like "%' . $param['keyword'] . '%"');
            }
            if (isset($param['searchby']) && $param['searchby'] == 'searchmobile') {
                $this->db->where('customer_mobile like "%' . $param['keyword'] . '%"');
            }
            if (isset($param['searchby']) && $param['searchby'] == 'searchreg') {
                $this->db->where("rcl.reg_no='" . $param['keyword'] . "'");
            }
            if (isset($param['searchby']) && $param['searchby'] == 'searchinst') {
                $this->db->where("rcp.instrument_no='" . $param['keyword'] . "'");
            }
        }
        if (!empty($param['agentrto'])) {
            $this->db->where('rci.rto_agent', $param['agentrto']);
        }
        if (!empty($param['daterange_to'])) {
            $to = date('Y-m-d', strtotime($param['daterange_to']));
            $where = "DATE(rcp.paydates)";
            $this->db->where($where . ">=", $to);
        }
        if (!empty($param['daterange_from'])) {
            $to = date('Y-m-d', strtotime($param['daterange_from']));
            $where = "DATE(rcp.paydates)";
            $this->db->where($where . "<=", $to);
        }
    }

    public function setRcTransferDetail($params)
    {
        $rcDetail['buyer_case_id'] = !empty($params['buyer_case_id']) ? $params['buyer_case_id'] : '';
        $rcDetail['loan_ref_id'] = !empty($params['loan_ref_id']) ? $params['loan_ref_id'] : '';
        $rcDetail['customer_mobile'] = !empty($params['customer_mobile']) ? $params['customer_mobile'] : '';
        $rcDetail['customer_id'] = !empty($params['customer_id']) ? $params['customer_id'] : rand();
        $rcDetail['reg_no'] = !empty($params['reg_no']) ? $params['reg_no'] : rand();
        $rcDetail['status'] = '1';
        $rcDetail['created_at'] = $this->dateTime;
        $this->db->insert('crm_rc_listing', $rcDetail);
        $rcId = $this->db->insert_id();
        $data['rc_id'] = $rcId;
        $data['activity'] = 'Pending';
        $data['created_by'] = !empty($this->session->userdata['userinfo']['id']) ? $this->session->userdata['userinfo']['id'] : '1';
        $data['remark'] = 'Pending';
        // $data['created_at'] = $this->dateTime;
        $data['status'] = '1';
        $this->insertRcTimeLine($data);

        if (!empty($rcId)) {
            $rcinfo['rc_id'] = !empty($rcId) ? $rcId : '';
            $rcinfo['customer_name'] = !empty($params['customer_name']) ? $params['customer_name'] : '';
            $rcinfo['customer_email'] = !empty($params['customer_email']) ? $params['customer_email'] : '';
            $rcinfo['reg_year'] = !empty($params['reg_year']) ? $params['reg_year'] : '';
            $rcinfo['loan_case_type'] = !empty($params['loan_case_type']) ? $params['loan_case_type'] : '0';
            $rcinfo['bank_id_loan'] = !empty($params['bank_id_loan']) ? $params['bank_id_loan'] : '';
            $rcinfo['pending_from'] = !empty($params['pending_from']) ? $params['pending_from'] : '';
            $rcinfo['loan_disbursement_date'] = !empty($params['loan_disbursement_date']) ? $params['loan_disbursement_date'] : '';
            $rcinfo['loan_delivery_date'] = !empty($params['loan_delivery_date']) ? $params['loan_delivery_date'] : '';
            $rcinfo['pending_from'] = !empty($params['buyer_case_id']) ? '2' : '1';
            $rcinfo['status'] = !empty($params['status']) ? '1' : '';
            $rcinfo['created_date'] = $this->dateTime;
            $this->db->insert('crm_rc_info', $rcinfo);
            $rcInfoId = $this->db->insert_id();
        }

        if (!empty($rcId)) {
            $rcMapData['rc_id'] = !empty($rcId) ? $rcId : '';
            $rcMapData['customer_id'] = $rcDetail['customer_id'];
            $rcMapData['aadhar_no'] = !empty($params['aadhar_no']) ? $params['aadhar_no'] : '';
            $rcMapData['rto_type'] = !empty($params['rto_type']) ? $params['rto_type'] : '';
            $rcMapData['from_state'] = !empty($params['from_state']) ? $params['from_state'] : '';
            $rcMapData['from_city'] = !empty($params['from_city']) ? $params['from_city'] : '';
            $rcMapData['to_state'] = !empty($params['to_state']) ? $params['to_state'] : '';
            $rcMapData['to_city'] = !empty($params['to_city']) ? $params['to_city'] : '';
            $rcMapData['generated_date'] = $this->dateTime;
            $this->db->insert('crm_rc_transfer_mapping', $rcMapData);
            $rcMapId = $this->db->insert_id();
        }

        $rcAllDeatails = array('rc_ids' => $rcInfoId, 'customer_id' => $rcDetail['customer_id'], 'case' => $rcInfoId, 'mapId' => $rcMapId);
        // }
        return $rcAllDeatails;
    }

    // public function api_log($requestData, $id = '')
    // {
    //     if (empty($id)) {
    //         $this->db->insert('crm_dc_sync_log', $requestData);
    //         $lastId = $this->db->insert_id();
    //     } else {
    //         $this->db->where('id', $id);
    //         $this->db->update('crm_dc_sync_log', $requestData);
    //         $lastId = $id;
    //     }
    //     return $lastId;
    // }
}
