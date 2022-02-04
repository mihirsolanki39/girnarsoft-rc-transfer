<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class : Dashboard (DashboardController)
 * User Class to control all doOrder related operations.
 * @author : Meenakshi
 */
class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Crm_user');
        $this->load->model('Loan_customer_info');
        $this->load->model('Loan_customer_case');
        $this->load->model('Crm_adv_booking');
        $this->load->library('form_validation');
        $this->load->model('Leadmodel');
        $this->load->model('Crm_dealers');
        $this->load->model('Make_model');
        $this->load->model('UserDashboard');
        $this->load->model('Loan_customer_reference_info');
        $this->load->model('City');
        $this->load->model('state_list');
        $this->load->model('Crm_banks');
        $this->load->model('Loan_post_delivery_info');
        $this->load->model('Crm_insurance_company');
        $this->load->model('Loan_payment_info');
        $this->load->model('Crm_applicant_type');
        $this->load->model('Crm_upload_docs_list');
        $this->load->model('Dashboard_model');
        //$this->load->library('Pdf');
        if (!$this->session->userdata['userinfo']['id']) {
            return redirect('login');
        }
    }

    public function dashboardMain($type = "")
    {
        // echo "<pre>";
        // print_r($this->session->userdata['userinfo']);
        // exit;

        $module = $this->Dashboard_model->getAllowedModule();
        $type = empty($type) ? $module[0] : $type;
        $team  = $this->session->userdata['userinfo']['team_id'];

        if ($this->session->userdata['userinfo']['is_admin'] == 2) {
            $module = $this->session->userdata['userinfo']['team_ids'];
        }

        if ($this->session->userdata['userinfo']['is_admin'] == 1 || $team == 3 || $team == 8) {
            if ($type == "")
                $type = 1;
            if ($this->session->userdata['userinfo']['dealer_id'] == 49) {
                $module = array(1, 2, 6, 10);
            } else {
                $module = array(1, 2, 4, 5, 6, 10);
            }
        }

        // if ($type == ""){
        //     $type = 1;
        // }

        // print_r($module) .'module';
        // echo '<br>';
        // echo $type .'type';
        // exit;

        if ($team == 7 && $type == "") {
            $type = 5;
        }
        if (in_array($type, $module) || $this->session->userdata['userinfo']['is_admin'] == '1' || $this->session->userdata['userinfo']['is_admin'] == '2') {
            switch ($type) {
                case "1":
                    $data = $this->getLoanDashboard($type);
                    $data['cards'] = LOAN_CARDS;
                    break;
                case "2":
                    $data = $this->getInsuranceDashboard($type);
                    $data['cards'] = INSURANCE_CARDS;
                    break;
                case "6":
                    $data = $this->getDoDashboard($type);
                    $data['cards'] = DO_CARDS;
                    break;
                case "10":
                    $data = $this->getRCDashboard($type);
                    $data['cards'] = RC_CARDS;
                    break;
                case "4":
                    $data = $this->getStockDashboard($type);
                    $data['cards'] = STOCK_CARDS;
                    break;
                case "5":
                    $data = $this->getLeadDashboard($type);
                    $data['cards'] = LEAD_CARDS;
                    break;
                default:
                    $data = $data;
            }
            $data['role_id'] = $this->session->userdata['userinfo']['role_id'];
            $data['type'] = $type;
            $data['modules'] = $module;
            $data['pageTitle']      = 'Dashboard';
            $data['pageType']       = 'dashboard';

            // echo '<pre>';
            // print_r($data['role_id']);
            // exit;

            if ($type != "") {
                $this->loadViews("dashboard/dashboard", $data);
            } else {
                $this->loadViews("dashboard/dashboard_1", $data);
            }
        } else
            echo "Your are not allowed to access this page.";
    }

    public function getRCDashboard($type)
    {
        $employeeId = "";
        $data = array();
        $role_id = $this->session->userdata['userinfo']['role_id'];
        $employeeId = $this->session->userdata['userinfo']['id'];

        $team  = $this->session->userdata['userinfo']['team_id'];
        if ($this->session->userdata['userinfo']['is_admin'] == '1' || $role_id == 2) {
            $employeeId = "";
        }
        $permissions = $this->Dashboard_model->getPermissions($type);
        if (in_array(2, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $data['pending_case_count'] = $this->Dashboard_model->getRCPending($employeeId);
            $data['pending_card'] = RC_PENDING_TAB;
            $data['pending_url'] = RC_PENDING_URL;
        }
        if (in_array(3, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $data['payout_case_count'] = $this->Dashboard_model->getRCDelay($employeeId);
            $data['delay_card'] = RC_PENDING_TAB;
            $data['delay_url'] = RC_DELAY_URL;
        }
        $totalBanks = $this->Dashboard_model->getTotalBankLimit();
        $data['bank'] = $totalBanks;
        $data['permissions'] = $permissions;
        return $data;
    }

    public function getInsuranceDashboard($type)
    {
        $employeeId = "";
        $data = array();
        $role_id = $this->session->userdata['userinfo']['role_id'];
        $employeeId = $this->session->userdata['userinfo']['id'];
        $team  = $this->session->userdata['userinfo']['team_id'];
        if ($this->session->userdata['userinfo']['is_admin'] == '1' || $role_id == 2 || $team == 8) {
            $employeeId = "";
        }
        $permissions = $this->Dashboard_model->getPermissions($type);
        if (in_array(1, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $data['inprocess_count'] = current($this->Dashboard_model->getInsuranceDashboard($employeeId));
            $data['progress_card'] = IN_PROGRESS_TAB;
            $data['progress_url'] = PROGRESS_URL;
        }
        if (in_array(2, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $data['renewal_count'] = $this->Dashboard_model->getRenewalCount($employeeId);
            $data['renewal_card'] = RENEWAL_COUNT;
        }
        if (in_array(3, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $data['payout_case_count'] = $this->Dashboard_model->getPayoutCaseCount($employeeId);
            $data['delay_card'] = Payout_CASES;
            $data['delay_url'] =  PAYOUT_CASES_URL;
        }
        if (in_array(4, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $data['case_wise_count'] = $this->Dashboard_model->getCaseWiseCount($employeeId);
        }
        if (in_array(6, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $data['amount_trend'] = $this->Dashboard_model->getODAMountTrend($employeeId);
        }
        if (in_array(5, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $data['case_trend'] = $this->Dashboard_model->getCaseWiseTrend($employeeId);
        }
        $data['permissions'] = $permissions;
        return $data;
    }
    public function getLoanDashboard($type)
    {
        $employeeId = "";
        $data = array();
        $role_id = $this->session->userdata['userinfo']['role_id'];
        $data['rolemgmt'] = $this->financeUserMgmt();
        if (isset($data['rolemgmt'][0]['role_name']) && (($data['rolemgmt'][0]['role_name'] == 'Used Car') || ($data['rolemgmt'][0]['role_name'] == 'New Car') || ($data['rolemgmt'][0]['role_name'] == 'Refinance'))) {
            $employeeId = $this->session->userdata['userinfo']['id'];
        } else {
            $employeeId = "";
        }
        $permissions = $this->Dashboard_model->getPermissions($type);
        if (in_array(1, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $data['inprocess_count'] = $this->Dashboard_model->getInProgressCount($employeeId);
            $data['progress_card'] = LOAN_IN_PROGRESS_TAB;
            $data['progress_url'] = LOAN_PROGRESS_URL;
        }
        if (in_array(2, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $data['pending_case_count'] = $this->Dashboard_model->getLoanPendingCaseCount($employeeId);
            $data['pending_card'] = PENDING_ACTIVITIES_CASES;
            $data['pending_url'] = LOAN_PENDING_URL;
        }
        if (in_array(3, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $data['payout_case_count'] = $this->Dashboard_model->getLoanPayoutCaseCount($employeeId);
            $data['delay_card'] = Payout_CASES;
            $data['delay_url'] = LOAN_PAYOUT_CASES_URL;
        }
        if (in_array(4, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $data['case_wise_count'] = $this->Dashboard_model->getLoanCaseWiseCount($employeeId);
        }
        if (in_array(5, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $data['case_trend'] = $this->Dashboard_model->getLoanCaseWiseTrend($employeeId);
        }
        if (in_array(6, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $data['amount_trend'] = $this->Dashboard_model->getDisbursedAMountTrend($employeeId);
        }
        $data['permissions'] = $permissions;
        return $data;
    }
    public function getdasboardtabs()
    {
        echo $datas = $this->load->view('docmanager/doc_tab_pages', $data, true);
        exit;
    }


    public function getDoDashboard($type)
    {
        $employeeId = "";
        $data = array();
        $role_id = $this->session->userdata['userinfo']['role_id'];
        $employeeId = $this->session->userdata['userinfo']['id'];
        if ($this->session->userdata['userinfo']['is_admin'] == '1') {
            $employeeId = "";
        }
        $permissions = $this->Dashboard_model->getPermissions($type);
        if (in_array(2, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $data['pending_case_count'] = current($this->Dashboard_model->getDoCount($employeeId));
            $data['pending_card'] = DO_PENDING_CASES;
            $data['pending_url'] = DO_PROGRESS_URL;
        }
        if (in_array(3, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $data['case_trend'] = $this->Dashboard_model->getDoCaseWiseTrend($employeeId);
        }
        if (in_array(5, $permissions) || $this->session->userdata['userinfo']['is_admin'] == '1') {
            $doallBalance      =  $this->Dashboard_model->getDoBalance();
            $showroomCasecount = 0;
            $customerCasecount = 0;
            $showroomBal = 0;
            $customerBal = 0;
            foreach ($doallBalance as $key => $balance) {
                if ($balance['showroom_balance'] != 0 && $balance['showroom_balance'] != '') {
                    $showroomBal = $showroomBal + $balance['showroom_balance'];
                    $showroomCasecount++;
                }
                if ($balance['customer_balance'] != 0) {
                    $customerBal = $customerBal + $balance['customer_balance'];
                    $customerCasecount++;
                }
            }
            $data['doBalance']['showroomBal']     = $this->no_to_words($showroomBal);
            $data['doBalance']['showroomBalCase'] = $showroomCasecount;
            $data['doBalance']['customerBal']     = $this->no_to_words($customerBal);
            $data['doBalance']['customerBalCase'] = $customerCasecount;
        }
        $data['permissions'] = $permissions;
        return $data;
    }
    public function getStockDashboard($type)
    {
        $permissions = $this->Dashboard_model->getPermissions($type);
        $allStatus = [];
        $dealerId = DEALER_ID;
        $totsearchText['tab_value'] = '';
        $search45Text['invdashId'] = '2';
        $response['active_case'] = count($this->crm_stocks->getInventoryListing($dealerId, $allStatus, $totsearchText, true));
        $response['age_45_days'] = count($this->crm_stocks->getInventoryListing($dealerId, $allStatus, $search45Text, true));
        $data['pending_case_count'] = $response;
        $data['pending_card'] = STOCK_STATUS_CASES;
        $data['pending_url'] = STOCK_STATUS_URL;
        $data['permissions'] = $permissions;
        return $data;
    }

    public function getLeadDashboard($type)
    {
        $permissions = $this->Dashboard_model->getPermissions($type);
        $leadpost['ucdid'] = DEALER_ID;
        $leadCount = current($this->Leadmodel->getdashboardLeads($leadpost));
        $totalNewLeadCount = $this->Leadmodel->getcurrentmonthlead($employeeId);
        $leadCount['lead_added'] = ($totalNewLeadCount > 0) ? $totalNewLeadCount : 0;
        // $data['leadPending']=$this->Leadmodel->getLeadsPending($leadpost);
        $leadPending = $this->Leadmodel->todayLeadTabcount($leadpost);
        $leadCount['pending'] = $leadPending['alllead'];

        $data['inprocess_count'] = $leadCount;
        $data['progress_card'] = LEAD_STATUS_CASES;
        $data['progress_url'] = LEAD_STATUS_URL;
        $data['permissions'] = $permissions;
        return $data;
    }

    public function financeUserMgmt($id = '', $module = '')
    {
        $role_id = $this->session->userdata['userinfo']['role_id'];
        $role = $this->Crm_user->getRightsByRole($role_id, $module);
        if (($role_id > 0) && ($role_id != '24')) {
            $role['role_name'] = !empty($role[0]['role_name']) ? $role[0]['role_name'] : '';
            $role['role_id'] = $role_id;
        } else {
            $role[0]['role_name'] = 'admin';
            $role[0]['team_name'] = '';
            $role[0]['edit_permission'] = '1';
            $role[0]['add_permission'] = '1';
            $role[0]['view_permission'] = '1';
            $role[0]['role_id'] = $role_id;
        }
        return $role;
    }

    function no_to_words($no)
    {
        $finalval = '';
        if ($no == 0) {
            return ' ';
        } else {
            $n =  strlen($no); // 7
            switch ($n) {
                case 3:
                    $val = $no / 100;
                    $val = round($val, 2);
                    $finalval =  $val . " hundred";
                    break;
                case 4:
                    $val = $no / 1000;
                    $val = round($val, 2);
                    $finalval =  $val . " thousand";
                    break;
                case 5:
                    $val = $no / 1000;
                    $val = round($val, 2);
                    $finalval =  $val . " thousand";
                    break;
                case 6:
                    $val = $no / 100000;
                    $val = round($val, 2);
                    $finalval =  $val . " lakh";
                    break;
                case 7:
                    $val = $no / 100000;
                    $val = round($val, 2);
                    $finalval =  $val . " lakh";
                    break;
                case 8:
                    $val = $no / 10000000;
                    $val = round($val, 2);
                    $finalval =  $val . " cr.";
                    break;
                case 9:
                    $val = $no / 10000000;
                    $val = round($val, 2);
                    $finalval =  $val . " cr.";
                    break;

                default:
                    echo "";
            }
            return $finalval;
        }
    }
}
