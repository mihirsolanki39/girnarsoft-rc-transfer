<?php

class Lead extends MY_Controller
{

    public function index()
    {
        
    }

    public function __construct()
    {
        parent::__construct();
        $this->dateTime = date("Y-m-d H:i:s");
        $this->load->model('Crm_buy_customer_status');
        $this->load->model('Crm_buy_lead_dealer_mapper');
        $this->load->model('Crm_buy_lead_car_detail');
        $this->load->model('Crm_buy_lead_customer_preferences');
        $this->load->model('Crm_buy_lead_customer');
        $this->load->model('Crm_buy_lead_history_track');
        $this->load->model('Crm_lead_customer_comment');
        $this->load->model('Crm_lead_customer_detail');
        $this->load->model('Crm_buy_lead_addedit_log');
        $this->load->model('Leadmodel');
        $this->load->model('Crm_used_car');
        $this->load->model('Make_model');
        $this->load->model('Crm_buy_lead_feedback_closed');
        $this->load->model('Ublms_locations');
        $this->load->model('Crm_user');
        $this->load->model('Crm_rc');
        $this->load->model('Variant_features');
        $this->load->model('Crm_used_car_sale_case_info');
        $this->load->model('Crm_lead_assign_rule');
        $this->load->model('Crm_lead_assign_rule_mapping');
        $this->load->helpers('range_helper');
        $method         = $this->router->fetch_method();
        if ($method != 'SyncbuyerupdatedLeadsfromDC')
        {
            if (!$this->session->userdata['userinfo']['id'])
            {
                return redirect('login');
            }
        }
    }

    function AddLeadIndex()
    {
        $data                      = [];
        $this->global['pageTitle'] = 'CodeInsect : Add Lead';
        $data['maxPriceArr']       = array('0' => 'Price Min', '25000' => '25,000', '50000' => '50,000', '75000' => '75,000', '100000' => '1 Lakh', '125000' => '1.25 Lakh', '150000' => '1.5 Lakh', '175000' => '1.75 Lakh', '200000' => '2 Lakh', '225000' => '2.25 Lakh', '250000' => '2.5 Lakh', '275000' => '2.75 Lakh', '300000' => '3 Lakh', '325000' => '3.25 Lakh', '350000' => '3.5 Lakh', '375000' => '3.75 Lakh', '400000' => '4 Lakh', '425000' => '4.25 Lakh', '450000' => '4.5 Lakh', '475000' => '4.75 Lakh', '500000' => '5 Lakh', '550000' => '5.5 Lakh', '600000' => '6 Lakh', '650000' => '6.5 Lakh', '700000' => '7 Lakh', '750000' => '7.5 Lakh', '800000' => '8 Lakh', '850000' => '8.5 Lakh', '900000' => '9 Lakh', '950000' => '9.5 Lakh', '1000000' => '10 Lakh', '1100000' => '11 Lakh', '1200000' => '12 Lakh', '1300000' => '13 Lakh', '1400000' => '14 Lakh', '1500000' => '15 Lakh', '1600000' => '16 Lakh', '1700000' => '17 Lakh', '1800000' => '18 Lakh', '1900000' => '19 Lakh', '2000000' => '20 Lakh', '2500000' => '25 Lakh', '3000000' => '30 Lakh', '4000000' => '40 Lakh', '5000000' => '50 Lakh', '7500000' => '75 Lakh', '10000000' => '1 Crore', '30000000' => '3 Crore');
        $data['statusData']        = $this->Crm_buy_customer_status->getCustomerStatus(['1', '2', '13']);
        $data['makeList']          = $this->Make_model->getCarMakeList('used');
        $data['getDeatCarFuelArr'] = array('Petrol', 'Diesel', 'CNG', 'LPG', 'Hybrid', 'Electric');
        $locpost['ucdid']          = DEALER_ID;
        $data['localityData']      = $this->Ublms_locations->getdealerlocality($locpost);
        $this->loadViews("lead/add_buyer_lead", $this->global, $data, NULL);
    }

    function getModel()
    {
        $make   = $this->input->post('make');
        $result = $this->Make_model->getCarModelList($make);
        //echo '<pre>';print_r($result);die;
        $option = "<option value='' >Select Model</option>";
        foreach ($result as $ModelKey => $ModelValue)
        {
            $option .= "<option value='" . $ModelValue['id'] . "' >" . $ModelValue['model'] . "</option>";
        }
        echo $option;
    }

    function addNewLead($requestData = '',$returnurl = "")
    {

        //echo "<pre>";print_r($requestData);exit;
        $this->load->helper('crm_helper');
        //$requestParams = $this->input->post();
        
        if (empty($requestData))
        {
            $requestParams = $this->input->post();
        }
        else
        {
            $requestParams = $requestData;
        }
        //echo "<pre>";print_r($requestParams);die;
        $leadDataPost = $requestParams;
        $arrMsg       = array();
        $appDetail    = array();
        $userName     = (!empty($requestParams['txtname'])) ? $requestParams['txtname'] : '';

        if (empty($requestParams['dcsync']))
        {
            $requestParams['ucdid'] = DEALER_ID;
            $dealerId               = DEALER_ID;
        }
        else
        {
            $dealerId = $requestParams['ucdid'];
        }


        if (!empty($requestParams['lead_status']))
        {
            $requestParams['cusstatus']  = $requestParams['lead_status'];
            $requestParams['dcusstatus'] = $requestParams['lead_status'];
        }
        if (!empty($requestParams['mobile']))
        {
            $requestParams['txtmobile'] = $requestParams['mobile'];
        }
        if (!empty($requestParams['comment']))
        {
            $leadDataPost['txtcomment'] = $requestParams['comment'];
        }
        if (!empty($requestParams['name']))
        {
            $leadDataPost['txtname'] = $requestParams['name'];
        }
        $statusId = '';
        if (!empty($requestParams['cusstatus']))
        {
            $customerStatus = $this->Crm_buy_customer_status->mappOldToNew($requestParams['cusstatus']);
            $statusId       = $customerStatus['statusId'];
        }
        $statusName = $customerStatus['status_name'];
        if (empty($leadDataPost['followdate']) || $leadDataPost['followdate'] == '1970-01-01 01:00:00')
        {
            $leadDataPost['followdate'] = '';
        }
        $mobile      = !empty($leadDataPost['txtmobile']) ? $leadDataPost['txtmobile'] : '';
        $followDatee = date("Y-m-d H:i:s", strtotime($leadDataPost['followdate']));
        if (!empty($leadDataPost['dfollowdate']))
        {
            $dfollowDatee = date("Y-m-d H:i:s", strtotime($leadDataPost['dfollowdate'])); //previous follw date
        }
        else
        {
            $dfollowDatee = '';
        }
        $leadDataPost['cusstatus']     = !empty($leadDataPost['cusstatus']) ? $leadDataPost['cusstatus'] : '';
        $dcusstatus                    = !empty($requestParams['dcusstatus']) ? $requestParams['dcusstatus'] : '';
        $leadDataPost['txtcomment']    = !empty($leadDataPost['txtcomment']) ? $leadDataPost['txtcomment'] : '';
        $validate_status_by_followDate = $this->Crm_buy_customer_status->validate_status_by_followDate($dcusstatus, $dfollowDatee, $leadDataPost['cusstatus'], $followDatee, $leadDataPost['txtcomment']);
        if ($validate_status_by_followDate == 1)
        {
            // echo "sssss";
            //echo '1';exit;
        }

        $requestParams['mobile']                       = !empty($leadDataPost['txtmobile']) ? $leadDataPost['txtmobile'] : '';
        $requestParams['name']                         = !empty($leadDataPost['txtname']) ? $leadDataPost['txtname'] : '';
        $requestParams['email']                        = !empty($leadDataPost['txtemail']) ? $leadDataPost['txtemail'] : '';
        $requestParams['car_id']                       = !empty($leadDataPost['gaadi_id']) ? $leadDataPost['gaadi_id'] : '';
        $requestParams['ucdid']                        = $dealerId;
        $requestParams['comment']                      = !empty($leadDataPost['txtcomment']) ? $leadDataPost['txtcomment'] : '';
        $requestParams['lead_alternate_mobile_number'] = !empty($leadDataPost['cd_alternate_mobile']) ? $leadDataPost['cd_alternate_mobile'] : '';
        $requestParams['budget']                       = !empty($leadDataPost['price_max']) ? $leadDataPost['price_max'] : '';
        $requestParams['lead_source']                  = !empty($leadDataPost['lead_source']) ? $leadDataPost['lead_source'] : '';
        if (!empty($leadDataPost['followdate']))
        {
            $requestParams['next_follow'] = date("Y-m-d H:i:s", strtotime($leadDataPost['followdate']));
        }


        //$data['ldm_walkin_date']    = $requestParams['walkinDate'];
        //$data['ldm_follow_date']    = $requestParams['next_follow'];
        if (empty($requestParams['lead_status']))
        {
            $requestParams['lead_status'] = !empty($leadDataPost['cusstatus']) ? $leadDataPost['cusstatus'] : '';
        }
        $requestParams['sub_source']  = 'self';
        $requestParams['locality_id'] = !empty($leadDataPost['locality_id']) ? $leadDataPost['locality_id'] : '';
        $requestParams['dcsync']      = !empty($leadDataPost['dcsync']) ? $leadDataPost['dcsync'] : '';

        if (isset($requestParams['txtemail']) && $requestParams['txtemail'] != '')
        {
            $chkemailVaild = chkEmailVaild($requestParams['txtemail']);
            if ($chkemailVaild == '1')
            {
                $requestParams['txtemail'] = '';
            }
        }
        $chkValidationInput = $this->chkValidationInput($requestParams);
        if ($chkValidationInput)
        {
            return $chkValidationInput;
        }

        if (isset($requestParams['rating']))
        {
            $data['ldm_lead_rating'] = $requestParams['rating'];
        }

        //$statusId                      = isset($requestParams['statusId'])?$requestParams['statusId']:'';
        $data['status_name'] = !empty($statusName) ? $statusName : '';
        $data['lead_source'] = $requestParams['lead_source'];


        $mobile                      = substr(trim($requestParams['txtmobile']), -10);
        $data['mobile']              = preg_replace("/[^0-9]/", "", $mobile);
        $custo_id                    = $this->crmCentralCustomer($data['mobile'], 'Buyer Lead');
        $data['city_id']             = isset($requestParams['city_id']) ? $requestParams['city_id'] : '';
        $data['location_id']         = isset($requestParams['locality_id']) ? $requestParams['locality_id'] : '';
        $data['gaadi_verified']      = isset($requestParams['gaadi_verified']) ? $requestParams['gaadi_verified'] : '';
        $data['opt_verified']        = isset($requestParams['otp_verified']) ? $requestParams['otp_verified'] : '';
        $data['is_finance']          = isset($requestParams['is_finance']) ? $requestParams['is_finance'] : '';
        $data['lead_score']          = isset($requestParams['lead_score']) ? $requestParams['lead_score'] : '';
        $data['central_customer_id'] = !empty($custo_id) ? $custo_id : '';

        $leadCustomerId = $this->Leadmodel->BuyLeadCustomer($data);

        $data['ldm_customer_id'] = $leadCustomerId;
        if (!empty($requestParams['txtname'])):
            $data['ldm_name'] = preg_replace("/[^a-zA-Z\s]/", "", $requestParams['txtname']);
        endif;

        $data['ldm_email']      = isset($requestParams['txtemail']) ? $requestParams['txtemail'] : '';
        $altmobile              = isset($requestParams['cd_alternate_mobile']) ? substr(trim($requestParams['cd_alternate_mobile']), -10) : '';
        $data['ldm_alt_mobile'] = preg_replace("/[^0-9]/", "", $altmobile);
        $data['ldm_alt_email']  = isset($requestParams['alt_email']) ? $requestParams['alt_email'] : '';
        /* if(isset($requestParams['lead_status']) && $requestParams['lead_status']!='')
          {
          $data['ldm_status_id']      = $statusId;
          } */
        $data['ldm_status_id']  = $statusId;
        if ($requestParams['next_follow'])
        {
            $getCustomerFollow = $this->Crm_buy_lead_customer->getCustomerFollow($requestParams, $statusId);
            if (isset($getCustomerFollow['ldm_walkin_date']) && $getCustomerFollow['ldm_walkin_date'])
            {
                $data['ldm_walkin_date'] = isset($getCustomerFollow['ldm_walkin_date']) ? $getCustomerFollow['ldm_walkin_date'] : '';
            }
            if (isset($getCustomerFollow['ldm_follow_date']) && $getCustomerFollow['ldm_follow_date'])
            {
                $data['ldm_follow_date'] = isset($getCustomerFollow['ldm_follow_date']) ? $getCustomerFollow['ldm_follow_date'] : '';
            }
        }
        $data['ldm_source']      = isset($requestParams['lead_source']) ? $requestParams['lead_source'] : '';
        $data['ldm_sub_source']  = isset($requestParams['sub_source']) ? $requestParams['sub_source'] : '';
        $data['ldm_location_id'] = isset($requestParams['locality_id']) ? $requestParams['locality_id'] : '';
        if (!empty($requestParams['total_assign_lead']))
        {
            $data['ldm_total_assign_lead'] = isset($requestParams['total_assign_lead']) ? intval($requestParams['total_assign_lead']) : '';
        }
        if ($data['status_name'] && (strtolower($requestParams['lead_source']) == 'self' || strtolower($requestParams['sub_source']) == 'self' || $requestParams['sub_source'] == 'Mobile'))
        {
            if (isset($requestParams['booking_amount']) && $requestParams['booking_amount'])
            {
                $data['ldm_amount'] = isset($requestParams['booking_amount']) ? $requestParams['booking_amount'] : '';
                $data['ldm_car_id'] = isset($requestParams['car_id']) ? $requestParams['car_id'] : '';
            }
            else if (isset($requestParams['sale_amount']) && $requestParams['sale_amount'])
            {
                $data['ldm_amount'] = isset($requestParams['sale_amount']) ? $requestParams['sale_amount'] : '';
                $data['ldm_car_id'] = isset($requestParams['car_id']) ? $requestParams['car_id'] : '';
            }
            else if (isset($requestParams['offer_amount']) && $requestParams['offer_amount'])
            {
                $data['ldm_amount'] = isset($requestParams['offer_amount']) ? $requestParams['offer_amount'] : '';
                $data['ldm_car_id'] = isset($requestParams['car_id']) ? $requestParams['car_id'] : '';
            }
            else
            {
                $data['ldm_amount'] = '0';
                $data['ldm_car_id'] = '0';
            }
        }
        $data['user_id'] = isset($this->session->userdata['userinfo']) ? $this->session->userdata['userinfo']['id'] : '';
        $dId             = DEALER_ID; //isset($this->session->userdata['userinfo'])?$this->session->userdata['userinfo']['id']:'';

        $logSourceType           = '';
        $data['log_source_type'] = $logSourceType;


        $data['repeat_car_id']    = isset($requestParams['car_id']) ? $requestParams['car_id'] : '';
        $data['only_update_flag'] = isset($requestParams['only_update_flag']) ? $requestParams['only_update_flag'] : '';

        $data['ldm_dealer_id'] = $requestParams['ucdid'];
        //echo "<pre>";print_r($data);exit;
        //insert update in buy_lead_dealer_mapper table
        $dealersClassified     = $this->Leadmodel->getclassifiedDealers($dealerId);
        $dcdata                = [];
        /*
          if(!empty($requestParams) && empty($requestParams['dcsync'])){
          //if($dealersClassified[0]['is_classified'] > 0){
          //$dcdata['buyer_case_id']     = $leadmapperId;
          $dcdata['customer_name']   = $requestParams['name'];
          $dcdata['customer_mobile']   = $requestParams['mobile'];
          $dcdata['dc_dealer_id']      = $requestParams['ucdid'];
          $dcdata['customer_email']    = $requestParams['email'];
          $dcdata['comment']           = $requestParams['comment'];
          $dcdata['lead_alternate_mobile_number']=$requestParams['lead_alternate_mobile_number'];
          $dcdata['budget']            = $requestParams['budget'];
          $dcdata['lead_source']       = $requestParams['lead_source'];
          $dcdata['next_follow']       = $requestParams['next_follow'];
          $dcdata['lead_status']       = $requestParams['lead_status'];
          $dcdata['sub_source']        = $requestParams['sub_source'];
          $dcdata['locality_id']       =$requestParams['locality_id'];
          $dcdata['city_id']           =!empty($requestParams['city_id']) ? $requestParams['city_id']:'';
          $dcdata['gaadi_verified']    =!empty($requestParams['gaadi_verified']) ? $requestParams['gaadi_verified']:'';
          $dcdata['opt_verified']      =!empty($requestParams['opt_verified']) ? $requestParams['opt_verified']:'';
          $dcdata['is_finance']        =!empty($requestParams['is_finance']) ? $requestParams['is_finance']:'';
          //$dcdata['lead_created_date']    = $this->dateTime;
          if ($data['status_name'] && (strtolower($requestParams['lead_source']) == 'self' || strtolower($requestParams['sub_source']) == 'self' || $requestParams['sub_source'] == 'Mobile')) {
          if (isset($requestParams['booking_amount']) && $requestParams['booking_amount']) {
          $dcdata['booking_amount'] = isset($requestParams['booking_amount'])?$requestParams['booking_amount']:'';
          $dcdata['car_id'] = isset($requestParams['car_id'])?$requestParams['car_id']:'';
          } else if (isset($requestParams['sale_amount']) && $requestParams['sale_amount']) {
          $dcdata['sale_amount'] = isset($requestParams['sale_amount'])?$requestParams['sale_amount']:'';
          $dcdata['car_id'] = isset($requestParams['car_id'])?$requestParams['car_id']:'';
          } else if (isset($requestParams['offer_amount']) && $requestParams['offer_amount']) {
          $dcdata['offer_amount'] = isset($requestParams['offer_amount'])?$requestParams['offer_amount']:'';
          $dcdata['car_id'] = isset($requestParams['car_id'])?$requestParams['car_id']:'';
          } else {
          $dcdata['ldm_amount'] = '0';
          $dcdata['ldm_car_id'] = '0';
          }
          }
          //print_r($dcdata);die;

          if($dcdata['lead_status'] == 'Walk-in Scheduled')
          {
          $dcdata['lead_status'] = "Walk In";
          }
          else if ($dcdata['lead_status'] == 'Walk-in Done')
          {
          $dcdata['lead_status'] = "Walked In";
          }
          $dcjsonData=json_encode($dcdata);
          $leadData['info']=$dcjsonData;

          //$url              = API_URL . "api/buyer_lead_verify_crm.php?apikey=U3KqyrewdMuCotTS&method=addBuyerLead";
          //$sent_time        = date('Y-m-d H:i:s');

          //$dcresponse       = $this->Leadmodel->sendLeadsToDC($leadData, $url);
          //LOG
          $response_json=json_decode($dcresponse,true);
          $this->Leadmodel->api_log([
          'sync_module'   => 'lead',
          'reference_id'  => $response_json['lead_results'][0]['lead_id'],
          'api_url'       => $url,
          'source'       =>  'crm',
          'dealer_id'     => DEALER_ID,
          'request'       => $dcjsonData,
          'response'      => $dcresponse,
          'status'        => strtoupper($response_json['lead_results'][0]['status']),
          'added_by'      => $this->session->userdata['userinfo']['id'],
          'sent_time'     => $sent_time,
          'response_time' => date('Y-m-d H:i:s'),
          ]);

          //}
          }
         */
        if (!empty($requestParams['dcleadid']))
        {
            $data['dcleadid'] = isset($requestParams['dcleadid']) ? $requestParams['dcleadid'] : '';
        }
        else
        {
            $data['dcleadid'] = isset($dcleadId) ? $dcleadId : '';
        }
        //print_r($data);die;
        $leadmapperId = $this->Leadmodel->setBuyLeadDealerMapper($data, $data['user_id']);

        

        if ($statusId == 12)
        {
            $leadMapperidss            = $leadmapperId['lead_dealer_mapper_id'];
            $leadData                  = $this->Leadmodel->getBuyLeadsForRc($leadMapperidss);

            // echo "<pre>";
            // print_r($leadMapperidss);
            // print_r($leadData);
            // exit;

            $rcdata['buyer_case_id']   = $leadData[0]['leadId'];
            $rcdata['customer_mobile'] = $leadData[0]['customer_mobile'];
            $rcdata['customer_id']     = $leadData[0]['customer_id'];
            $rcdata['reg_no']          = $leadData[0]['reg_no'];
            $rcdata['customer_name']   = $leadData[0]['customer_name'];
            $rcdata['customer_email']  = $leadData[0]['customer_email'];
            $rcdata['make_id']         = $leadData[0]['make_id'];
            $rcdata['model_id']        = $leadData[0]['model_id'];
            $rcdata['version_id']      = $leadData[0]['version_id'];
            $rcdata['reg_year']        = $leadData[0]['reg_year'];
            $carImage                  = $this->Crm_rc->setRcCarDetail($rcdata);
        }
        if (isset($requestParams['locality_id']) && intval($requestParams['locality_id']) > 0)
        {
            $this->Crm_lead_customer_detail->updateLocation($data['mobile'], $dId, $requestParams['locality_id']);
        }

        $data['lc_comment']               = !empty($requestParams['comment']) ? $requestParams['comment'] : '';
        $data['lc_lead_dealer_mapper_id'] = !empty($leadmapperId['lead_dealer_mapper_id']) ? $leadmapperId['lead_dealer_mapper_id'] : '';
        $data['lc_follow_date']           = !empty($data['ldm_follow_date']) ? $data['ldm_follow_date'] : '';
        $data['lc_status_id']             = $statusId;
        $data['lc_source']                = !empty($requestParams['lead_source']) ? $requestParams['lead_source'] : '';
        $data['lc_sub_source']            = !empty($requestParams['sub_source']) ? $requestParams['sub_source'] : '';

        $this->Crm_buy_lead_customer->saveCustomerCarLead($leadmapperId['lead_dealer_mapper_id'], $requestParams);
        if (!empty($requestParams['lognew']))
        {
            $leadmapid   = $leadmapperId['lead_dealer_mapper_id'];
            $leadappData = $this->Leadmodel->getBuyLeadsForRc($leadmapid);
            //print_r($leadappData);die;
            if (!empty($leadappData))
            {
                $logdata['leadId']    = $leadappData[0]['leadId'];
                $logdata['name']      = $leadappData[0]['customer_name'];
                $logdata['email']     = $leadappData[0]['customer_email'];
                $logdata['mobile']    = $leadappData[0]['customer_mobile'];
                $logdata['carid']     = $leadappData[0]['carId'];
                $logdata['date_time'] = $this->dateTime;
                //$logId                = $this->Leadmodel->setleadlogCarDetail($logdata);
            }
        }


        if (!empty($requestParams['lead_source']))
        {
            if ((strtolower($requestParams['lead_source']) == 'zigwheels' 
                    || strtolower($requestParams['lead_source']) == 'self' 
                    || strtolower($requestParams['lead_source']) == 'gaadi' 
                    || strtolower($requestParams['lead_source']) == 'cardekho' || strtolower($requestParams['lead_source']) == 'website'
                    || strtolower($requestParams['lead_source']) == 'dealerapp') 
                    && !empty($requestParams['car_id']) && intval($requestParams['car_id']) > 0){
                $autoPrefillingPreferences = $this->Crm_buy_lead_customer_preferences->autoPrefillingPreferences($leadmapperId['lead_dealer_mapper_id']);
                //$requestParams['makeIds']  = !empty($autoPrefillingPreferences['make_id']) ? $autoPrefillingPreferences['make_id'] : '';
                //$requestParams['modelIds'] = !empty($autoPrefillingPreferences['model_id']) ? $autoPrefillingPreferences['model_id'] : '';
                $requestParams['makeIds']  = !empty($requestParams['makeIds']) ? implode(',',array_unique(array_merge(explode(',',$requestParams['makeIds']),explode(',',$autoPrefillingPreferences['make_id'])))) : $autoPrefillingPreferences['make_id'];
                $requestParams['modelIds'] = !empty($requestParams['modelIds']) ? implode(',',array_unique(array_merge(explode(',',$requestParams['modelIds']),explode(',',$autoPrefillingPreferences['model_id'])))):$autoPrefillingPreferences['model_id'];
                $requestParams['budget']   = !empty($autoPrefillingPreferences['car_price']) ? $autoPrefillingPreferences['car_price'] : '';
            }
        }
        $preferId = $this->Leadmodel->AddEditLeadPreferences($requestParams, $leadmapperId['lead_dealer_mapper_id']);

        $data['car_id']         = !empty($requestParams['car_id']) ? $requestParams['car_id'] : '';
        $data['call_type']      = !empty($requestParams['call_type']) ? $requestParams['call_type'] : '';
        $data['call_duration']  = !empty($requestParams['call_duration']) ? $requestParams['call_duration'] : '';
        $data['shared_item']    = !empty($requestParams['shared_item']) ? $requestParams['shared_item'] : '';
        $data['shared_by']      = !empty($requestParams['shared_by']) ? $requestParams['shared_by'] : '';
        $data['booking_amount'] = !empty($requestParams['booking_amount']) ? $requestParams['booking_amount'] : '';
        $data['sale_amount']    = !empty($requestParams['sale_amount']) ? $requestParams['sale_amount'] : '';
        $data['offer_amount']   = !empty($requestParams['offer_amount']) ? $requestParams['offer_amount'] : '';
        $data['feedback']       = !empty($requestParams['feedback']) ? $requestParams['feedback'] : '';
        $data['leadmapperId']   = !empty($leadmapperId['lead_dealer_mapper_id']) ? $leadmapperId['lead_dealer_mapper_id'] : '';
        $data['feedback_id']    = !empty($requestParams['feedback_id']) ? $requestParams['feedback_id'] : '';
        $data['comment_type']   = !empty($requestParams['feedback_id']) ? $requestParams['feedback_id'] : ''; //changes comment source only


        if (!empty($leadmapperId['leadadd']) && $leadmapperId['leadadd'] == 'add')
        {
            $data['ldm_status_id'] = '1';
            $data['status_name']   = 'New';
        }
        else if (!empty($leadmapperId['leadadd']) && $leadmapperId['leadadd'] == 'follow')
        {
            $data['ldm_status_id'] = '2';
            $data['status_name']   = 'Follow Up';
        }
      //  echo "<pre>";print_r($data);exit;
        $this->Crm_buy_lead_history_track->trackAllHistory($data, $logSourceType);
        $outPutData           = array();
        $outPutData['error']  = "";
        $outPutData['status'] = "T";
        if (!empty($requestParams['method']) && $requestParams['method'] == 'leadadd')
        {
            $returnData               = array();
            $returnData['android_id'] = 1;
            $returnData['error']      = "";
            $returnData['lead_id']    = !empty($leadmapperId['lead_dealer_mapper_id']) ? $leadmapperId['lead_dealer_mapper_id'] : '';
            $returnData['msg']        = "Lead Added";
            $returnData['status']     = "T";
            if (!empty($leadmapperId['lead_dealer_mapper_id']) && $leadmapperId['lead_dealer_mapper_id'] > 0)
            {
                $outPutData['lead_results'] = [$returnData];
            }
            else
            {
                $outPutData['lead_results'] = [];
            }
        }
        else
        {
            $outPutData['msg'] = "lead edited successfully";
        }
        if (!$requestParams['lead_source'])
        {
            $data['ldm_source'] = !empty($requestParams['sub_source']) ? $requestParams['sub_source'] : '';
        }
        $this->Crm_buy_lead_addedit_log->insertEditlog($data, $requestParams, $outPutData);
        /*
         * SYNC FROM CRM TO DC
         */
        if (empty($requestParams['dcsync']))
        {
            $this->Leadmodel->crmToDcLeadSync($filter_data = [
                'dealer_id' => DEALER_ID,
                'ldm_id'    => $leadmapperId['lead_dealer_mapper_id'],
            ]);
        }
        /*
         * LOG DATA FROM DC TO CRM
         */
        else{
            
            $this->assignLeadToUser($leadmapperId['lead_dealer_mapper_id']);
            
            $log_data=[
                'sync_module'   => 'lead',
                'lead_id'       => $leadmapperId['lead_dealer_mapper_id'],
                'api_url'       => '',
                'source'        => 'dc',
                'dealer_id'     => $requestParams['ucdid'],
                'reference_lead_id' => $requestParams['lead_id'],
                'reference_log_id'  => $requestParams['ref_log_id'],
                'request'           => json_encode($requestParams),
                'response'          => json_encode($outPutData),
                'status'            => strtoupper($outPutData['lead_results'][0]['status']) == 'T' ? 'T' : 'F',
                'response_time'     => date('Y-m-d H:i:s'),
                'added_by'          => $requestParams['ucdid'],
                'sent_time'         => date('Y-m-d H:i:s'),
            ];
            $log_id=$this->Leadmodel->api_log($log_data);
            $outPutData['log_id'] = $log_id;
            if($returnurl != ""){
           return $returnurl; 
           }else{
           return json_encode($outPutData);
           }
            
        }
        
        if($returnurl != ""){
           return $returnurl; 
        }else{
        //return json_encode($outPutData);    
        echo json_encode($outPutData);
        die; 

        }

    }


  /*  public static function chkValidationInput($requestParams)
    {
        $mobile = preg_replace("/[^0-9]/", "", trim($requestParams['txtmobile']));
        $mobile = substr($mobile, -10);
        if (!empty($requestParams['cd_alternate_mobile']))
        {
            $altMobile = substr(trim($requestParams['cd_alternate_mobile']), -10);
            $altMobile = preg_replace("/[^0-9]/", "", $altMobile);
        }
        else
        {
            $altMobile = '';
        }
        $email    = (!empty($requestParams['txtemail']) ? $requestParams['txtemail'] : '');
        $dealerId = isset($requestParams['ucdid']) ? intval($requestParams['ucdid']) : '';
//        if ($dealerId == 0) {
//            return array('status' => 'T', 'msg' => 'Dealer Not Valid', 'error' => '');
//        }
        if ($mobile == '' || strlen($mobile) < 10 || !is_numeric($mobile))
        {
            return array('status' => 'T', 'msg' => 'Please Enter a Valid Mobile Number.', 'error' => '');
        }

        if ($altMobile != '')
        {
            if (strlen($altMobile) < 10 || !is_numeric($altMobile))
            {
                return array('status' => 'T', 'msg' => 'Please Enter a Valid Alt Mobile Number.', 'error' => '');
            }
        }
    }
*/
    public function ajax_edit_buyer_similar_car()
    {
        $filterArr       = array();
        $filterArr       = $this->input->post();
        $listType        = $filterArr['type'];
        $customerid      = $filterArr['id'];
        $typee           = $filterArr['type'];
        $data['typee']   = $filterArr['type'];
        $query           = $this->db->get_where('crm_lead_customer_detail', array('id' => $customerid, 'cd_did' => DEALER_ID));
        $result          = $query->row_array();
        $req             = array();
        $req['mobile']   = !empty($result['cd_customer_mobile']) ? $result['cd_customer_mobile'] : '';
        $req['dealerid'] = DEALER_ID; //$_SESSION[ses_used_car_dealer_id];

        $req['make']              = !empty($filterArr['make']) ? $filterArr['make'] : '';
        $req['model']             = !empty($filterArr['model']) ? $filterArr['model'] : '';
        $req['keyword']           = !empty($filterArr['keyword']) ? $filterArr['keyword'] : '';
        $req['km_from']           = !empty($filterArr['km_from']) ? $filterArr['km_from'] : '';
        $req['km_to']             = !empty($filterArr['km_to']) ? $filterArr['km_to'] : '';
        $req['year_from']         = !empty($filterArr['year_from']) ? $filterArr['year_from'] : '';
        $req['year_to']           = !empty($filterArr['year_to']) ? $filterArr['year_to'] : '';
        $req['price_min']         = !empty($filterArr['price_min']) ? $filterArr['price_min'] : '';
        $req['price_max']         = !empty($filterArr['price_max']) ? $filterArr['price_max'] : '';
        $req['fuel_type']         = !empty($filterArr['fuel_type']) ? $filterArr['fuel_type'] : '';
        $req['transmission_type'] = !empty($filterArr['transmission_type']) ? $filterArr['transmission_type'] : '';

        $ses_id_original = DEALER_ID; //$_SESSION['ses_id_original'];

        $usedCarDetails = $this->Crm_used_car->getDealerCar($ses_id_original, $req);
        if ($typee == 'all')
        {
            $data['getEnquiryListDetail'] = $usedCarDetails;
        }
        else
        {
            $data['getEnquiryListDetail'] = $usedCarDetails;
        }
        $data['makeList'] = $this->Make_model->getCarMakeList('used');
        $this->load->view('lead/car_box.php', $data);
    }

    public function getLeads()
    {
        $lead_status      = $this->Crm_buy_customer_status->getCustomerStatus();
        $locpost['ucdid'] = DEALER_ID;
        if ($this->input->get("type"))
        {
            $type = $this->input->get("type");
        }
        else
        {
            $type = $this->input->post("type");
        }
        //echo "<pre>";print_r($type);exit;
        $keyword          = $this->input->post("keyword");
        $filter_data_type = $this->input->get("type");
        $viewlead         = $this->input->get("viewlead");
        $gaadi_id         = $this->input->get("gaadi_id");
        $filter           = $this->input->get("filter");
        $pendingleads     = $this->input->get("pendingleads");
        $status           = $this->input->get("status");
        $leaddashId       = (!empty($leaddashId)) ? $leaddashId : '';
        $headerInfo       = [
            'pageTitle'        => 'Buyer Leads',
            'lead_status'      => $lead_status,
            'localityData'     => $this->Ublms_locations->getdealerlocality($locpost),
            'type'             => empty($type) ? 'all' : $type,
            'filter_data_type' => $filter_data_type,
            'viewlead'         => $viewlead,
            'gaadi_id'         => $gaadi_id,
            'filter'           => $filter,
            'fstatus'          => $status,
            'pendingleads'     => $pendingleads,
            'keyword'          => $keyword
        ];
        //echo '<pre>';print_r($headerInfo);die; 
        $this->loadViews('lead/list_buyer_lead', $headerInfo);
    }

    public function getLeadAssignment()
    {

        $lead_status      = $this->Crm_buy_customer_status->getCustomerStatus();
        $locpost['ucdid'] = DEALER_ID;
        if ($this->input->get("type"))
        {
            $type = $this->input->get("type");
        }
        else
        {
            $type = $this->input->post("type");
        }
        //echo "<pre>";print_r($type);exit;
        $keyword          = $this->input->post("keyword");
        $filter_data_type = $this->input->get("type");
        $viewlead         = $this->input->get("viewlead");
        $gaadi_id         = $this->input->get("gaadi_id");
        $filter           = $this->input->get("filter");
        $pendingleads     = $this->input->get("pendingleads");
        $status           = $this->input->get("status");
        $leaddashId       = (!empty($leaddashId)) ? $leaddashId : '';

        $execList   = $this->Crm_user->getEmployeeByRoleAndTeam('7', '21');
        $headerInfo = [
            'pageTitle'        => 'Buyer Leads',
            'lead_status'      => $lead_status,
            'localityData'     => $this->Ublms_locations->getdealerlocality($locpost),
            'type'             => empty($type) ? 'all' : $type,
            'filter_data_type' => $filter_data_type,
            'viewlead'         => $viewlead,
            'gaadi_id'         => $gaadi_id,
            'filter'           => $filter,
            'fstatus'          => $status,
            'pendingleads'     => $pendingleads,
            'execList'         => $execList,
            'keyword'          => $keyword
        ];
        //echo '<pre>';print_r($headerInfo);die; 
        $this->loadViews('lead/lead_assignment_list', $headerInfo);
    }

    public function ajax_assignment_leads()
    {
        $dealerId          = DEALER_ID;
        $datapost          = $this->input->post();
        $datapost['ucdid'] = DEALER_ID;
        $lead_status       = $this->Crm_buy_customer_status->getCustomerStatus();
        if ((isset($datapost['crateddate_from']) || isset($datapost['crateddate_to'])) && $datapost['crateddate_from'] != '' || $datapost['crateddate_to'] != '')
        {
            $datapost['createStartDate'] = $datapost['crateddate_from'];
            $datapost['createEndDate']   = $datapost['crateddate_to'];
        }
        if ((isset($datapost['updatedaterange_from']) || isset($datapost['updatedaterange_to'])) && $datapost['updatedaterange_from'] != '' || $datapost['updatedaterange_to'] != '')
        {
            $datapost['startdate'] = $datapost['updatedaterange_from'];
            $datapost['enddate']   = $datapost['updatedaterange_to'];
        }
        if (($datapost['updatedaterange_follow_from'] != '' || $datapost['updatedaterange_follow_to'] != '') && (isset($datapost['updatedaterange_follow_from']) || isset($datapost['updatedaterange_follow_to'])))
        {
            $datapost['startfollowdate'] = $datapost['updatedaterange_follow_from'];
            $datapost['endfollowdate']   = $datapost['updatedaterange_follow_to'];
        }
        //echo "<pre>";print_r($datapost);exit;

        if ($datapost['filter_data_type'] == 'todayworks')
        {
            $getLeads      = $this->Leadmodel->getLeads($datapost, $dealerId);
            //$leadtabCounts    = $objbuyer->todayLeadTabcount($datapost); 
            $leadTabCounts = $this->Leadmodel->todayLeadTabcount($datapost, $dealerId);
            $leadtabCounts = $leadTabCounts;
        }
        else
        {
            $getLeads = $this->Leadmodel->getLeads($datapost, $dealerId);

            //$datapost['type']='';
            $leadTabCounts = $this->Leadmodel->leadTabCounts($datapost, $dealerId);
            $leadtabCounts = $leadTabCounts;
        }

        /* if($datapost['recievedLeadFilter']=='1' && $datapost['crateddate_from']=='' && $datapost['crateddate_to']=='' && $datapost['filter_data_type']=='allleads'){
          $datapost['crateddate_from']=date('01/m/Y');
          $datapost['crateddate_to']=date('d/m/Y');
          }
          if($datapost['recievedLeadFilter']=='2' && $datapost['crateddate_from']=='' && $datapost['crateddate_to']=='' && $datapost['filter_data_type']=='allleads'){
          $last7days = date('d/m/Y', strtotime(date('Y-m-d')) - (3600 * 24 * 6));
          $datapost['crateddate_from']=$last7days;
          $datapost['crateddate_to']=date('d/m/Y');
          }
          if($datapost['recievedLeadFilter']=='3' && $datapost['crateddate_from']=='' && $datapost['crateddate_to']=='' && $datapost['filter_data_type']=='allleads'){
          $datapost['crateddate_from']=date('d/m/Y');
          $datapost['crateddate_to']=date('d/m/Y');
          } */

        //print_r($getLeads);die;

        $headerInfo = [
            'query'        => $getLeads,
            'leadtabCount' => $leadtabCounts,
            'lead_status'  => $lead_status,
            'type'         => $this->input->post('type')
        ];
        //print_r($headerInfo);die;
        $this->load->view('lead/ajax_assign_leads_list', $headerInfo);
    }

    public function ajax_lead_assign_rule()
    {
        $executives   = $this->Crm_user->getExecutive();
        $priceSegment = $this->Crm_lead_assign_rule->getPriceSegment();
        //print_r($priceSegment);die;
        $min_price    = [];
        $max_price    = [];
        $data         = [];
        foreach ($priceSegment as $price)
        {
            $min_price[] = $price['min_price'];
            $max_price[] = $price['max_price'];
        }
        $data['min_price_segment'] = $min_price;
        $data['max_price_segment'] = $max_price;

        $assignRuleResult = $this->Crm_lead_assign_rule->getLeadRuleData();
        if ($assignRuleResult)
        {
            $rule_type = $assignRuleResult[0]['rule_type'];
        }
        //print_r($assignRuleResult);die;
        $data['rule_type']        = isset($rule_type) ? $rule_type : '1';
        $data['assignRuleResult'] = $assignRuleResult;
        $data['executives']       = $executives;
        $this->load->view('lead/ajax_lead_assign_rule', $data);
    }

    public function show_employee_list()
    {
        $data['execList'] = $this->Crm_user->getEmployeeByRoleAndTeam('7', '21');

        $this->load->view('lead/show_employee_list', $data);
    }

    public function getEmplist()
    {
        $srchtxt      = $this->input->post('txtsrch');
        $chkassign    = $this->input->post('chkassign');
        // echo '<pre>';
        // print_r($srchtxt.'1');
        // print_r($chkassign.'2');
        // echo '</pre>';
        // exit;
        $assignedCase = '';
        if (!empty($chkassign))
        {
            $y = 0;
            foreach ($chkassign as $key => $val)
            {
                $assignedCase .= $val . ",";
                $y++;
            }
            $assignedCase = trim($assignedCase, ",");
        }

        $html     = '';
        $roleType = array('Sales Executive');
        $execList = $this->Crm_user->getEmployeeByRoleAndTeam('5', '12', $srchtxt);

        // echo '<pre>';
        // print_r($execList);
        // exit;

        if (!empty($execList))
        {
            $i = 0;
            foreach ($execList as $ekey => $eval)
            {
                $html .= '<d
                
                
                iv class="list-group-item">
                  <div class="col-md-12 pad-L0 pad-R0">
                      <input class="mrg-T10 clsoptassign" type="radio" name="optassign[]" id="exe_' . $i . '" value="' . $eval['id'] . '">
                        <label class="w100" for="exe_' . $i . '">
                            <p class="ws mrg-B0" style="display: inline-block">' . $eval['name'] . '<br><i class="oi">' . $eval['email'] . '</i></p> <span class="mrg-R0"></span>
                                
                        </label>
                  </div>
                </div>';
                $i++;
            }
            $y    = isset($y) ? $y : '';
            $html .= '<input type="hidden" name="assigntxt" id="assigntxt" value="' . $assignedCase . '">';
            $html .= '<input type="hidden" name="totassign" id="totassign" value="' . $y . '">';
        }
        echo $html;
    }

    public function assign_leads_to_user_manually()
    {
        // print_r($this->input->post());die;
        $user_id        = $this->input->post('optassign')[0];
        $assign_to_all  = $this->input->post('assign_to_all');
        $assigned_leads = $this->input->post('assigned_leads');
        //echo DEALER_ID;die;
        $datapost       = $this->input->post();

        if ($assign_to_all == 'n' && !empty(json_decode($assigned_leads)))
        {
            $lead_array = json_decode($assigned_leads);
        }
        elseif ($assign_to_all == 'y')
        {

            if ((isset($datapost['crateddate_from']) || isset($datapost['crateddate_to'])) && $datapost['crateddate_from'] != '' || $datapost['crateddate_to'] != '')
            {
                $datapost['createStartDate'] = $datapost['crateddate_from'];
                $datapost['createEndDate']   = $datapost['crateddate_to'];
            }
            if ((isset($datapost['updatedaterange_from']) || isset($datapost['updatedaterange_to'])) && $datapost['updatedaterange_from'] != '' || $datapost['updatedaterange_to'] != '')
            {
                $datapost['startdate'] = $datapost['updatedaterange_from'];
                $datapost['enddate']   = $datapost['updatedaterange_to'];
            }
            if (($datapost['updatedaterange_follow_from'] != '' || $datapost['updatedaterange_follow_to'] != '') && (isset($datapost['updatedaterange_follow_from']) || isset($datapost['updatedaterange_follow_to'])))
            {
                $datapost['startfollowdate'] = $datapost['updatedaterange_follow_from'];
                $datapost['endfollowdate']   = $datapost['updatedaterange_follow_to'];
            }
            $getLeads        = $this->Leadmodel->getLeads($datapost, DEALER_ID, $show_all_result = false);

            $lead_array = array_column($getLeads['leads'], 'leadID');
        }
        else
        {
            $result = array('status' => 'False', 'message' => 'Please Assign Some Leads', 'Action' => '');
            echo json_encode($result);
            exit;
        }

        $this->db->where_in('ldm_id', $lead_array);
        $this->db->update('crm_buy_lead_dealer_mapper', ['assigned_to' => $user_id, 'updated_by' => $this->session->userdata['userinfo']['id']]);


        $result = array('status' => 'True', 'message' => 'Lead Assigned Successfully', 'Action' => '');
        echo json_encode($result);
        exit;
    }

    public function save_assignment_rule()
    {
        $post_data = $this->input->post();
        $rule_type = $post_data['rule_type'];
        $ruleData  = $post_data['data'];
        //print_r($post_data);
        //die;
        //echo DEALER_ID;
        $leadRule  = $this->Crm_lead_assign_rule->getLeadRule();

        if (empty($leadRule))
        {
            $save_rule = [
                'rule_type' => $rule_type,
                'dealer_id' => DEALER_ID,
                'status'    => '1',
            ];
            $rule_id   = $this->Crm_lead_assign_rule->save($save_rule);
        }
        else
        {
            $save_rule = [
                'rule_type' => $rule_type,
                'dealer_id' => DEALER_ID,
                'status'    => '1',
            ];
            $rule_id   = $this->Crm_lead_assign_rule->save($save_rule, $leadRule['id']);
        }
        /* archive old rule */
        $this->Crm_lead_assign_rule_mapping->updateRuleMappingByRuleId(['status' => '0'], $rule_id);

        foreach ($ruleData as $rule)
        {

            $rule_mapping_data = [
                'rule_id'         => $rule_id,
                'user_id'         => $rule['user_id'],
                'rule_valid_from' => $rule['from'],
                'rule_valid_to'   => $rule['to'],
                'status'          => '1',
            ];
            $update_id         = !empty($rule['mapping_id']) ? $rule['mapping_id'] : '';

            $last_id = $this->Crm_lead_assign_rule_mapping->save($rule_mapping_data, $update_id);
        }
        if ($last_id)
        {
            $result = array('status' => true, 'message' => 'Rule Saved Successfully', 'Action' => '');
        }
        else
        {
            $result = array('status' => false, 'message' => 'Something Went Wrong', 'Action' => '');
        }
        exit(json_encode($result));
    }

    public function ajax_getLeads()
    {
        $dealerId          = DEALER_ID;
        $datapost          = $this->input->post();
        $datapost['ucdid'] = DEALER_ID;
        $lead_status       = $this->Crm_buy_customer_status->getCustomerStatus();
        if($datapost['lasturl']=='1')
        {
           // date('d/m/Y');
           $datapost['crateddate_from'] = '01/'.date('m/Y');;
           $datapost['crateddate_to'] = date('d/m/Y');
            
        }
        if($datapost['lasturl'] == '2')
        {
           $datapost['filter_data_type'] = 'todayworks' ;
        }
        if ((isset($datapost['crateddate_from']) || isset($datapost['crateddate_to'])) && $datapost['crateddate_from'] != '' || $datapost['crateddate_to'] != '')
        {
            $datapost['createStartDate'] = $datapost['crateddate_from'];
            $datapost['createEndDate']   = $datapost['crateddate_to'];
        }
        if ((isset($datapost['updatedaterange_from']) || isset($datapost['updatedaterange_to'])) && $datapost['updatedaterange_from'] != '' || $datapost['updatedaterange_to'] != '')
        {
            $datapost['startdate'] = $datapost['updatedaterange_from'];
            $datapost['enddate']   = $datapost['updatedaterange_to'];
        }
        if (($datapost['updatedaterange_follow_from'] != '' || $datapost['updatedaterange_follow_to'] != '') && (isset($datapost['updatedaterange_follow_from']) || isset($datapost['updatedaterange_follow_to'])))
        {
            $datapost['startfollowdate'] = date('d/m/Y',strtotime($datapost['updatedaterange_follow_from']));
            $datapost['endfollowdate']   = date('d/m/Y',strtotime($datapost['updatedaterange_follow_to']));
        }
        //echo "<pre>";print_r($datapost);exit;

        if ($datapost['filter_data_type'] == 'todayworks')
        {
            $getLeads      = $this->Leadmodel->getLeads($datapost, $dealerId);
            //$leadtabCounts    = $objbuyer->todayLeadTabcount($datapost); 
            $leadTabCounts = $this->Leadmodel->todayLeadTabcount($datapost, $dealerId);
            $leadtabCounts = $leadTabCounts;
        }
        else
        {
            $getLeads      = $this->Leadmodel->getLeads($datapost, $dealerId);
            //$datapost['type']='';
            $leadTabCounts = $this->Leadmodel->leadTabCounts($datapost, $dealerId);
            $leadtabCounts = $leadTabCounts;
        }

        /* if($datapost['recievedLeadFilter']=='1' && $datapost['crateddate_from']=='' && $datapost['crateddate_to']=='' && $datapost['filter_data_type']=='allleads'){
          $datapost['crateddate_from']=date('01/m/Y');
          $datapost['crateddate_to']=date('d/m/Y');
          }
          if($datapost['recievedLeadFilter']=='2' && $datapost['crateddate_from']=='' && $datapost['crateddate_to']=='' && $datapost['filter_data_type']=='allleads'){
          $last7days = date('d/m/Y', strtotime(date('Y-m-d')) - (3600 * 24 * 6));
          $datapost['crateddate_from']=$last7days;
          $datapost['crateddate_to']=date('d/m/Y');
          }
          if($datapost['recievedLeadFilter']=='3' && $datapost['crateddate_from']=='' && $datapost['crateddate_to']=='' && $datapost['filter_data_type']=='allleads'){
          $datapost['crateddate_from']=date('d/m/Y');
          $datapost['crateddate_to']=date('d/m/Y');
          } */



        $headerInfo = [
            'query'        => $getLeads,
            'leadtabCount' => $leadtabCounts,
            'lead_status'  => $lead_status,
            'type'         => $this->input->post('type')
        ];
        //echo "<pre>"; print_r($headerInfo);die;
        $this->load->view('lead/ajax_getLeads', $headerInfo);
    }

    public function buyer_email_sms()
    {
        $userData       = $this->Crm_user->getLoginUserDetails();
        $postData       = $this->input->post();
        $this->load->helpers('curl');
        $customermobile = !empty($postData['mobile']) ? $postData['mobile'] : '';
        $requestType    = !empty($postData['message']) ? $postData['message'] : '';
        $type           = !empty($postData['type']) ? $postData['type'] : '';
        $lead_id        = !empty($postData['lead_id']) ? $postData['lead_id'] : '';
        $gaadi_id       = !empty($postData['gaadi_id']) ? $postData['gaadi_id'] : '';
        //echo $requestType;die;
        if ($requestType == 'email')
        {

            /* Function use to get Email Content */
            echo $this->Crm_buy_lead_car_detail->getLeadEmailData($lead_id);
            exit;
        }
        else if (($requestType == 'message') && $lead_id)
        {
            /* Function use to get Lead SMS Status */
            $result = $this->Crm_buy_lead_dealer_mapper->checkLeadMessageStatus($lead_id);

            if ($result)
            {
                /* Function use to get radio button */
                $response = $this->renderRadioButton($result);
                echo $response['msgtype'];

                /* Function use to get sms text and car details */
                $renderSmsText = $this->renderSmsText($result, $response, $lead_id, $type, $gaadi_id, $userData);
                echo $renderSmsText;
                exit;
            }
        }
        else if (($requestType == 'whatsup') && $lead_id)
        {


            $result = $this->Crm_buy_lead_dealer_mapper->checkLeadMessageStatus($lead_id);

            if ($result)
            {
                /* Function use to get radio button */
                $response = $this->Crm_buy_lead_car_detail->renderRadioButtonWhatsup($result, $type);

                echo $response['msgtype'];

                /* Function use to get sms text and car details */
                $renderSmsText = $this->renderSmsText($result, $response, $lead_id, $type, $gaadi_id, $userData);
                echo $renderSmsText;
                exit;
            }
        }
        if (!empty($postData['type']) && $postData['type'] == 'emailsend')
        {
            /* Function use to get Email Content */
            echo $this->Crm_buy_lead_dealer_mapper->sendEmail($postData);
            exit;
        }
        //echo '<pre>';print_r($_POST);die;
        if (!empty($postData['send_type']) && $postData['send_type'] == 'sms' || !empty($postData['send_type']) && $postData['send_type'] == 'whatsup')
        {

            if (!empty($postData['send_type']) && $postData['send_type'] == 'whatsup')
            {

                if (!empty($postData['whatsuptype']) && $postData['whatsuptype'] == '1')
                {

                    $shared_item = 'Call Reminder Sent';
                }
                else if (!empty($postData['whatsuptype']) && $postData['whatsuptype'] == '2')
                {

                    $shared_item = 'Car Details Sent';
                }
                else if (!empty($postData['whatsuptype']) && $postData['whatsuptype'] == '3')
                {

                    $shared_item = 'Dealership Location Sent';
                }
                $this->Crm_buy_lead_dealer_mapper->saveHistory($shared_item, 'WHATSAPP', $postData['custoMobile'], $postData['lead_id']);
                echo "sucess";
                exit;
            }
            if (!empty($postData['custoMobile']) && !empty($postData['lead_id']))
            {
                $satus = curlPostData($postData['custoMobile'], $postData['buyersmsn'], 'gaadi');
                if ($satus == 1)
                {

                    $data = [
                        'dc_id'           => !empty($userData['id']) ? $userData['id'] : '',
                        'dc_name'         => !empty($userData['name']) ? $userData['name'] : '',
                        'dealer_id'       => DEALER_ID,
                        'dealer_name'     => !empty($userData['organization']) ? $userData['organization'] : '',
                        'customer_mobile' => !empty($postData['custoMobile']) ? $postData['custoMobile'] : '',
                        'sms_text'        => !empty($postData['buyersmsn']) ? $postData['buyersmsn'] : '',
                        'patfrom'         => 'DESKTOP',
                        'sms_type'        => !empty($postData['smstype']) ? $postData['smstype'] : ''
                    ];
                    $this->db->insert('lead_log_Customer_sms', $data);

                    $set = '';
                    if (!empty($postData['smstype']) && $postData['smstype'] == '1')
                    {
                        $shared_item = 'Call Reminder Sent';
                    }
                    else if (!empty($postData['smstype']) && $postData['smstype'] == '2')
                    {
                        $shared_item = 'Car Details Sent';
                    }
                    else if (!empty($postData['smstype']) && $postData['smstype'] == '3')
                    {
                        $shared_item = 'Dealership Location Sent';
                    }
                    if (empty($postData['customer_mobile_number']))
                    {
                        $postData['customer_mobile_number'] = !empty($postData['custoMobile']) ? $postData['custoMobile'] : '';
                    }
                    $this->Crm_buy_lead_dealer_mapper->saveHistory($shared_item, 'Sms', $postData['custoMobile'], $postData['lead_id']);
                    echo "sucess";
                    exit;
                }
            }
            else
            {
                echo 'error';
                exit;
            }
        }
    }

    public function renderRadioButton($result)
    {
        $response                     = array();
        $msgtype                      = '';
        $checkedtab                   = '';
        $checked_tab                  = ['send_reminder' => '0', 'car_details' => '0', 'dealer_location' => '0'];
        $checkedtab                   .= '1,';
        $checked_tab['send_reminder'] = '1';

        $msgtype                        .= '<span class="mrg-R10 mrg-T10 mob-xs"><input type="radio" onclick="sendSmsNewVersion(this.id,this.value);" checked="checked" value="1" name="smstype" id="smstype1" class="smstype"><label for="smstype1"><span></span>Reminder</label></span>';
        $checkedtab                     .= '2,';
        $checked_tab['car_details']     = '1';
        $msgtype                        .= '<span class="mrg-R10 mob-xs"><input type="radio" onclick="sendSmsNewVersion(this.id,this.value);" value="2" name="smstype" id="smstype2" class="smstype"><label for="smstype2"><span></span>Car Details</label></span>';
        $checkedtab                     .= '3,';
        $checked_tab['dealer_location'] = '1';
        $msgtype                        .= '<span class="mrg-R10 mob-xs"><input type="radio" onclick="sendSmsNewVersion(this.id,this.value);" value="3" name="smstype" id="smstype3" class="smstype"><label for="smstype3"><span></span> Dealer Location</label></span>';

        $msgtype .= "@#$%*";

        $response['msgtype']     = $msgtype;
        $response['checkedtab']  = $checkedtab;
        $response['checked_tab'] = $checked_tab;
        return $response;
    }

    public function renderSmsText($result, $response, $lead_id, $type, $gaadi_id = '', $userData)
    {
        $defaultTabType = explode(",", substr($response['checkedtab'], 0, -1));
        /* Condition for render car detail sms data */
        if (($type == '' && $defaultTabType[0] == '2') || ($type == '2' && $response['checked_tab']['car_details'] == '1'))
        {
            $smsText = $this->renderCarDetailSmsText($result, $userData, $gaadi_id, $lead_id);
        }
        /* Condition for render dealer location sms text */
        else if (($type == '' && $defaultTabType[0] == '3') || ($type == '3' && $response['checked_tab']['dealer_location'] == '1'))
        {
            $smsText = $this->Crm_buy_lead_car_detail->renderLocationSmsText($result, $userData);
        }
        /* Condition for render reminder sms text */
        else if (($type == '' && $defaultTabType[0] == '1') || ($type == '1' && $response['checked_tab']['send_reminder'] == '1'))
        {
            $loginUserData['name']   = !empty($_SESSION['userinfo']['name']) ? ucwords($_SESSION['userinfo']['name']) : '';
            $loginUserData['mobile'] = !empty($_SESSION['userinfo']['mobile']) ? ucwords($_SESSION['userinfo']['mobile']) : '';
            $smsText                 = $this->Crm_buy_lead_car_detail->renderReminderSmsText($result, $loginUserData);
        }
        if (trim($type) == '')
        {
            $smsText .= $response['checkedtab'];
        }
        return $smsText;
    }

    public function renderCarDetailSmsText($result, $userData, $gaadi_id, $lead_id)
    {
        if (!$gaadi_id)
        {
            return $car_list = $this->Crm_buy_lead_car_detail->renderCarListSmsData($lead_id, $result, $userData);
        }
        else
        {
            $car_list = '';
            $car_list .= "@#$%*";
            $car_list .= $this->Crm_buy_lead_car_detail->renderSingleCarMessage($gaadi_id, $result, $userData);
            return $car_list;
        }
    }

    public function addEditLeadsOnListing()
    {

        $datapost                        = array();
        $datapost                        = $this->input->post();
        $datapost['ucdid']               = DEALER_ID; //$_SESSION['ses_used_car_dealer_id'];
        $datapost['username']            = !empty($_SESSION['ses_dealer_username']) ? $_SESSION['ses_dealer_username'] : '';
        $datapost['normal_password']     = 'sarojsahoo';
        $datapost['dealer_id']           = DEALER_ID; //$_SESSION['ses_id_original'];
        $datapost['txtname']             = $this->input->post('name');
        $datapost['txtemail']            = $this->input->post('email');
        $datapost['cd_alternate_mobile'] = $this->input->post('lead_alternate_mobile_number');
        $datapost['locality_id']         = $this->input->post('locality_id');
        $datapost['txtmobile']           = $this->input->post('mobile');
        //echo '<pre>';print_r($datapost);die;
        $getLeadsnew                     = $this->addNewLead($datapost);
    }

    public function get_history()
    {
        //$lead_id=$_REQUEST['lead_id'];//23;//
        $lead_id  = $this->input->post('lead_id');
        $this->load->helpers('history_helper');
        $usertype = '';
        if ($lead_id)
        {

            $historyData = $this->Crm_buy_lead_history_track->getLeadHistoryTrack($lead_id, $usertype);
            if ($historyData)
            {
                echo renderHistoryHTMLFinal($historyData);
                exit;
            }
            else
            {
                echo 'No history available';
                exit;
            }
        }
        else
        {

            echo 'Sorry request not valid';
            exit;
        }
    }

    public function ajax_carlist()
    {
        $range                      = $this->Crm_buy_lead_customer_preferences->getbudgetList();
        $requestData                = $this->input->post();
        //echo "<pre>";print_r($range);exit;
        $getLeadFavoriteCar         = $this->Crm_used_car->getLeadFavoriteCar($requestData['leadId']);
        $objGetcarFeature           = $this->Variant_features;
        $objCrm_buy_lead_car_detail = $this->Crm_buy_lead_car_detail;
        $objCrm_used_car            = $this->Crm_used_car;
        $objMake_model              = $this->Make_model;

        $data = [
            'requestData'                => $requestData,
            'getLeadFavoriteCar'         => $getLeadFavoriteCar,
            'objGetcarFeature'           => $objGetcarFeature,
            'objCrm_buy_lead_car_detail' => $objCrm_buy_lead_car_detail,
            'objCrm_used_car'            => $objCrm_used_car,
            'objMake_model'              => $objMake_model,
            'range'                      => $range
        ];

        $this->load->view('lead/ajax_carlist', $data);
    }

    public function ajax_recomm_car()
    {
        $dealer_id             = DEALER_ID;
        $requestData           = $this->input->post();
        // echo "<pre>";print_r($requestData); exit;
        $range                 = $this->Crm_buy_lead_customer_preferences->getbudgetList();
        $getOnlyFavortieCarIds = $this->Crm_buy_lead_car_detail->getOnlyFavortieCarIds($requestData['leadId']);


        $getRecommCar     = $this->Crm_buy_lead_car_detail;
        $objGetcarFeature = $this->Variant_features;
        $objCrm_used_car  = $this->Crm_used_car;
        $objMake_model    = $this->Make_model;
        $data             = [
            'requestData'                => $requestData,
            'favortieCarIds'             => $getOnlyFavortieCarIds,
            'objCrm_buy_lead_car_detail' => $getRecommCar,
            'objCrm_used_car'            => $objCrm_used_car,
            'objMake_model'              => $objMake_model,
            'objGetcarFeature'           => $objGetcarFeature,
            'objLeadmodel'               => $this->Leadmodel,
            'range'                      => $range,
            'dealer_id'                  => $dealer_id
        ];
        
        //echo "<pre>";print_r($data);die;
        
        $this->load->view('lead/ajax_recomm_car', $data);
    }

    public function ajax_assign_car()
    {

        $requestPrems          = $this->input->post();
        //echo "<pre>";print_r($requestPrems);exit;
        $datapost              = array();
        $datapost['ucdid']     = DEALER_ID;
        $datapost['carid']     = $requestPrems['carid'];
        $datapost['lead_id']   = $requestPrems['lead_id'];
        $datapost['favourite'] = 1;
        if ($requestPrems['type'] == '2')
        {
            $datapost['favourite'] = 0;
        }
        $assign           = $this->Leadmodel->assignUnassignlead($datapost);
        //echo "<pre>";print_r($assign);exit;
        $favouriteCarsArr = array();
        if (!empty($requestPrems['favouriteCars']))
        {
            $favouriteCarsArr = json_decode($requestPrems['favouriteCars']);
        }
        if ($requestPrems['type'] == 1)
        {

            $arrFavrouite = array(
                'car_id'       => $requestPrems['carid'],
                'year'         => $requestPrems['recomYear'],
                'month'        => $requestPrems['recomMonth'],
                'version_id'   => $requestPrems['recomVersionId'],
                'city_name'    => $requestPrems['recomCityName'],
                'owner'        => $requestPrems['recomOwner'],
                'insurance'    => $requestPrems['recomInsurance'],
                'city_id'      => $requestPrems['recomCityId'],
                'color'        => $requestPrems['recomColor'],
                'km'           => $requestPrems['recomKm'],
                'price'        => $requestPrems['recomPrice'],
                'make'         => $requestPrems['recomMake'],
                'model'        => $requestPrems['recomModel'],
                'version'      => $requestPrems['recomVersion'],
                'regno'        => $requestPrems['recomRegno'],
                'favourite'    => 1,
                'makeID'       => $requestPrems['recomMakeId'],
                'fuel_type'    => $requestPrems['recomFuelType'],
                'ins_month'    => $requestPrems['recomExpiryInsuranceMonth'],
                'ins_year'     => $requestPrems['recomExpiryInsuranceYear'],
                'transmission' => $requestPrems['recomTransmission'],
            );
            //array_unshift($favouriteCarsArr, $arrFavrouite);
        }
        else
        {
            $favArr = array();
            if (!empty($favouriteCarsArr))
            {
                foreach ($favouriteCarsArr as $key => $val)
                {
                    if ($val->car_id == $requestPrems['carid'])
                    {
                        continue;
                    }
                    else
                    {
                        $favArr[] = $val;
                    }
                }
            }
            $favouriteCarsArr = $favArr;
        }
        $this->Leadmodel->crmToDcLeadSync($filter_data = [
            'dealer_id' => DEALER_ID,
            'ldm_id'    => $requestPrems['lead_id'],
        ]);
        echo json_encode($favouriteCarsArr);
        exit;
    }

    public function exportExcel()
    {
        $datapost = array();
        $datapost = $this->input->get();
        $this->load->helpers('Buyer_excel');
        if (!empty($datapost['crateddate_from']) || !empty($datapost['crateddate_to']))
        {
            $datapost['createStartDate'] = $datapost['crateddate_from'];
            $datapost['createEndDate']   = $datapost['crateddate_to'];
        }
        if (!empty($datapost['updatedaterange_from']) || !empty($datapost['updatedaterange_to']))
        {
            $datapost['startdate'] = $datapost['updatedaterange_from'];
            $datapost['enddate']   = $datapost['updatedaterange_to'];
        }
        if (!empty($datapost['updatedaterange_follow_from']) || !empty($datapost['updatedaterange_follow_to']))
        {
            $datapost['startfollowdate'] = $datapost['updatedaterange_follow_from'];
            $datapost['endfollowdate']   = $datapost['updatedaterange_follow_to'];
        }
        $datapost['dealer_id'] = DEALER_ID; //69
        $datapost['ucdid']     = DEALER_ID; //69

        if (!empty($datapost['filter_data_type']) && $datapost['filter_data_type'] == 'todayworks' && !empty($datapost['export']) && $datapost['export'] == 'export')
        {
            //$getLeadsnew = $objbuyer->getTodayLeads($datapost);
            $getLeadsnew = $this->Leadmodel->getLeads($datapost, DEALER_ID,false);
            $this->exportBuyerLeadData($getLeadsnew['leads'], $datapost['type']);
            exit;
        }
        else if (!empty($datapost['export']) && $datapost['export'] == 'export')
        {
            $getLeadsnew = $this->Leadmodel->getLeads($datapost, DEALER_ID,false);
            $this->exportBuyerLeadData($getLeadsnew['leads'], $datapost['type']);
            exit;
        }
    }

    function exportBuyerLeadData($leadData, $type)
    {
        $this->load->helpers('Buyer_excel');
        $fileType    = array('futurefollow' => 'Finalized', 'pastfollow' => 'Walk-Ins', 'todayfollow' => 'Follow-UP', 'noaction' => 'New', 'all' => 'All', 'closed' => 'Closed', 'converted' => 'Converted');
        $objPHPExcel = new PHPExcel();
        $filename    = "Buy-Leads-" . $type . '-' . date('d-F-Y') . ".xls";
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel = $this->makeExcelHeader($objPHPExcel);
        $objPHPExcel = $this->makeExcelRows($objPHPExcel, $leadData);
        $objPHPExcel->getActiveSheet();
        $objPHPExcel->getActiveSheet()->setTitle('Buyer Enquiery Report');
        //$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        $objWriter   = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit();
    }

    function makeExcelHeader($objPHPExcel)
    {
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Customer Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Mobile Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Alt Mobile Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Customer Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Creation Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Car Details');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Requirements');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Follow up Date ');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Comment');
        //$objPHPExcel->getActiveSheet()->getColumnDimension('F1')->setWidth(200);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('G1')->setWidth(200);
        $objPHPExcel->getActiveSheet()->getStyle("A1:J1")->getFont()->setBold(true);
        return $objPHPExcel;
    }

    function makeExcelRows($objPHPExcel, $data)
    {
        $count = 2;
        foreach ($data as $key => $value)
        {
            $customerName = ($value['name']) ? $value['name'] : 'NA';
            if (!empty($value['history']))
            {
                $comment = $this->getCommentText($value['history']);
            }
            else
            {
                $comment = '';
            }
            if (!empty($value['preferences']))
            {
                $requirement = $this->getRequirement($value['preferences']);
            }
            else
            {
                $requirement = '';
            }
            $followUpDate = '';
            if (isset($value['followDate']) && $value['followDate'] != '' && $value['followDate'] != '0000-00-00 00:00:00')
            {
                $followUpDate = date('d-m-Y', strtotime($value['followDate']));
            }
            $leadCreatedDate = date('d-m-Y', strtotime($value['leadCreatedDate']));
            $carList         = getCarList($value['car_list']);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $count, $customerName);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $count, $value['number']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $count, $value['alt_number']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $count, $value['emailID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $count, $leadCreatedDate);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $count, $carList);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $count, $requirement);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $count, $value['lead_status']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $count, $followUpDate); //
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $count, $comment);

            $count++;
        }
        return $objPHPExcel;
    }

    function getCommentText($data)
    {
        if (!empty($data[0]['comment']))
        {
            $comment = $data[0]['comment']['comment_text'];
        }
        else if (!empty($data[0]['feedback']))
        {
            $comment = $data[0]['feedback'];
        }
        else if (!empty($data[1]['comment']))
        {
            $comment = $data[1]['comment']['comment_text'];
        }
        else if (!empty($data[1]['feedback']))
        {
            $comment = $data[1]['feedback'];
        }
        else
        {
            $comment = 'NA';
        }
        return $comment;
    }

    function getRequirement($data)
    {
        $requirement = '';
        if (!empty($data['budget']))
        {
            $requirement .= no_to_words($data['budget']) . '|';
        }
        if (!empty($data['bodyType']))
        {
            $requirement .= implode(",", $data['bodyType']) . '|';
        }
        if (!empty($data['fuelType']))
        {
            $requirement .= $data['fuelType'] . '|';
        }
        if (!empty($data['transmission']))
        {
            $requirement .= $data['transmission'] . '|';
        }
        if (!empty($data['makeIds']))
        {
            $requirement .= $this->Make_model->getMakeName(implode(',', $data['makeIds'])) . '|';
        }
        if (!empty($data['modelIds']))
        {
            $requirement .= $this->Make_model->getMakeModelName(implode(',', $data['modelIds'])) . '|';
        }
        $requirement = substr($requirement, 0, -1);
        if (!$requirement)
        {
            $requirement = '';
        }
        return $requirement;
    }

    function getCarList($car)
    {
        $carData = '';
        if (!empty($car[0]))
        {
            $carData .= $car[0]['make'] . "|" . $car[0]['model'] . "|" . $car[0]['version'] . "| ";
            $price   = !empty($car[0]['price']) ? $car[0]['price'] : '';
            $regno   = !empty($car[0]['regno']) ? $car[0]['regno'] : '';
            $km      = $car[0]['km'];
            if ($regno)
            {
                $carData .= $regno . '|';
            }
            if (!empty($price))
            {
                if ($price >= 100000)
                {
                    if (($price % 100000) == 0)
                    {
                        $carData .= ($price / 100000);
                    }
                    else
                    {
                        $carData .= number_format(($price / 100000), 2);
                    }
                }
                else
                {
                    $carData .= $price;
                }
                $carData .= ' Lakh | ';
            }

            if ($km)
            {
                $carData .= $km . ' kms | ';
            }
            if (!empty($car[0]['month']) || !empty($car[0]['year']))
            {
                $carData .= $car[0]['month'] . $car[0]['year'] . ' |';
            }
            $carData = substr($carData, 0, -1);
        }
        else
        {
            $carData = '';
        }
        return $carData;
    }

    public function ajax_buyer_lead_update()
    {
        //echo "<PRE>";
        //print_r($this->input->post());die;
        $req['dealerid'] = DEALER_ID;
        $dealer_id       = DEALER_ID;
        $requestData     = $this->input->get('term');
        print_r($requestData);
        $req['make']     = $requestData;
        $req['model']    = $requestData;
        $dealerStock     = $this->Crm_used_car->getDealerCar($dealer_id, $req, true);
        $type            = $this->input->post('type');
        $headerInfo      = [
            'getDealerCar' => $dealerStock,
            'type'         => $type
        ];

        if (!$type) {

            if ($dealerStock)
            {
                $response = array();
                $i        = 0;
                foreach ($dealerStock as $key => $value)
                {
                    $response[$i]['id']    = $value['car_id'];
                    $response[$i]['value'] = $value['make'] . ' ' . $value['model'] . ' ' . $value['carversion'] . ' ( ' . $value['regno'] . ')';
                    $carImage              = $this->Crm_used_car->getUsedCarImages($value['car_id']);
                    $response[$i]['html']  = $this->getstockHtml($value, $carImage);
                    $i++;
                }
            }
            else
            {
                $response[0]['value'] = 'Sorry no car found.';
            }
            echo json_encode($response);
            die;
        }

        switch ($type)
        {
            case 'savestatus':
                echo $this->updateStatus($this->input->post(), $dealer_id);
                exit;
                exit;
                break;
            case 'getfeedback':
                echo $this->getFeedback($this->input->post());
                exit;
                exit;
                break;
            case 'getbookingoffer':
                echo $this->getBookAmountHtml($this->input->post());
                exit;
                exit;
                break;
        }
        //  $this->load->view('lead/ajax_buyer_lead_update', $headerInfo);
    }

    public function updateStatus($post = '', $dealer_id = '')
    {
        error_reporting(0);
        $postData = $this->input->post();
        $case_id = $this->Crm_used_car_sale_case_info->isUsedCarSaleLeadIdById($postData['lead_id']);
        if(isset($postData['car_id']) && $postData['car_id'] != ""){
        $car_id = $postData['car_id'];    
        }else{
        $carDetails = $this->Leadmodel->getLeadLatestCar($postData['lead_id']);
        $car_id = $carDetails['car_id'];
        }
            
        $returnUrl = base_url() . 'lead/getLeads';
        //echo "<pre>";print_r($postData);exit;
        if ($postData)
        {
            $post = $postData;
        }
        if ($post['status'] == 'Booked')
        {
            $data['booking_amount'] = $post['offer'];
            $returnUrl = base_url() . 'addUcBuyerLead/' . base64_encode($car_id."_".$case_id);
            unset($post['status']);
        }
        else if ($post['status'] == 'Customer Offer')
        {
            $data['offer_amount'] = $post['offer'];
        }
        else if ($post['status'] == 'Converted')
        {
            $data['sale_amount'] = $post['offer'];
            unset($post['status']);
            if($case_id != ""){
             $returnUrl = base_url() . 'uploadUcSalesDocument/' . base64_encode($car_id."_".$case_id);    
            }else{
             $returnUrl = base_url() . 'addUcBuyerLead/' . base64_encode($car_id."_".$case_id);   
            }
            
        }
        $data['txtname']     = !empty($post['txtname']) ? $post['txtname'] : '';
        $data['txtmobile']   = $post['txtmobile'];
        $data['ucdid']       = $dealer_id;
        $data['source']      = 'SELF';
        $data['lead_source'] = 'SELF';
        $data['rating']      = $post['rating'];
        $data['lead_status'] = $post['status'];
        $data['car_id']      = (isset($post['car_id'])) ? $post['car_id'] : '';
        $data['gaadi_id']    = (isset($post['car_id'])) ? $post['car_id'] : '';
        $data['followdate']  = (isset($post['next_follow'])) ? $post['next_follow'] : '';
        //$data['APP_VERSION']            = 58;
        if (isset($post['feedback']) && $post['feedback'])
        {
            $feedBackArray       = explode('$', $post['feedback']);
            $data['feedback_id'] = $feedBackArray[0];
            $data['comment']     = $this->db->escape_str($feedBackArray[1]);
        }

        if (isset($data['comment']) && $data['comment'] && $post['comment'])
        {
            $data['comment'] .= ' | ' . $this->db->escape_str($post['comment']);
        }
        else if (isset($data['comment']) && $data['comment'])
        {
            
        }
        else
        {
            $data['comment'] = $this->db->escape_str($post['comment']);
        }

        //$data['feedback']               = mysql_real_escape_string($post['feedback']);
        if (isset($post['status']) && $post['status'] == 'Walk In')
        {
            if ($post['follow_up'])
            {
                $post['follow_up'] = date("Y-m-d H:i:s", strtotime($post['follow_up']));
            }
            if (isset($post['status']) && $post['reminder_date'])
            {
                $post['reminder_date'] = date("Y-m-d H:i:s", strtotime($post['reminder_date']));
            }
            $data['walkinDate']  = $post['follow_up'];
            $data['next_follow'] = $post['reminder_date'];
        }
        else
        {
            $post['follow_up']   = date("Y-m-d H:i:s", strtotime($post['follow_up']));
            $data['next_follow'] = $post['follow_up'];
        }
        
        $result = $this->addNewLead($data,$returnUrl);

        return $result;
    }

    public function getFeedback($post)
    {
        $currentStatus = $post['status'];
        $lastStatus    = $post['lastStatus'];
        if ($currentStatus == 'Walk-in Done')
        {
            $feedBackOptions = $this->Crm_buy_lead_feedback_closed->getAllFeedBack(3);
            $base_url        = base_url('assets/admin_assets/images/cancel.png');
            $response        = '<div class="modal-header bg-gray">
        <button type="button" class="close" data-dismiss="modal"><img src="' . $base_url . '"><span class="sr-only">Close</span></button>
        <h4 class="modal-title">What happened during Walk in?</h4>
      </div>
      <style>
        .modal label {
            margin-bottom: 10px !important;
            color: #000;
            opacity: 0.87;
            font-size: 14px;
            font-weight: 500 !important;
        }
      </style>
      <div class="modal-body pad-T25 pad-B0">
	 	<div class="col-md-12 clearfix">
		  	<div class="row pad-B20 font-14 text-999">
				Select what happened during walk in:
			</div>
			<div class="row">
                        ' . $this->renderFeedbackOptions($feedBackOptions) . '
                                 <div class=" mrg-T15 font-14" id="show_comment" style="display:none;">
                                        <span class="text-999">Add Comment</span>
					<span class="">
                                        <textarea name="comment_feedback" id="comment_feedback" maxlength="200"  placeholder="Add Comment" rows="3" class="form-control mrg-T10 mrg-B5" style="height: 60px !important;"></textarea>
                    			</span>	
				</div>
				</div>
			</div>
		  </div> 
		  <div class="clearfix pad-T5">
		  	
		  </div>         
      </div>
      <div class="modal-footer text-left" id="editpopup1">
		<button type="button" class="btn btn-primary"  id="saveFeedback">SAVE</button>
      </div>
    ';
        }
        else if ($currentStatus == 'Closed' && in_array($lastStatus, array('New', 'Follow Up', 'Interested')))
        { //
            $feedBackOptions = $this->Crm_buy_lead_feedback_closed->getAllFeedBack(1);
            $response        = '<div class="modal-header bg-gray">
        <button type="button" class="close" data-dismiss="modal"><img src="' . BASE_HREF . 'images/cancel.png"><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Reason for closing the lead</h4>
      </div>
      <div class="modal-body">
	 	<div class="col-md-12 clearfix">
		  	<div class="row pad-B10">
				Select what happened during process:
			</div>
			<div class="row">
				' . $this->renderFeedbackOptions($feedBackOptions) . '
                                <div class="mrg-T10" id="show_comment" style="display:none;">
                                        Other
					<span class="mrg-R20">
                                        <textarea name="comment_feedback" id="comment_feedback" maxlength="200"  placeholder="Add Comment" rows="3" class="form-control "></textarea>
					</span>	
				</div>
                               
				</div>
			</div>
		  </div> 
		  <div class="clearfix pad-T5">
		  	
		  </div>         
      </div>
      <div class="modal-footer pad-T0 text-left">
		<button type="button" class="btn btn-primary"  id="saveFeedback">Save</button>
      </div>
    ';
        }
        else
        {
            $feedBackOptions = $this->Crm_buy_lead_feedback_closed->getAllFeedBack(2);
            $base_url        = base_url('assets/admin_assets/images/cancel.png');
            $response        = '<div class="modal-header bg-gray">
        <button type="button" class="close" data-dismiss="modal"><img src="' . $base_url . '"><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Why did Customer change his mind?</h4>
      </div>
      <div class="modal-body pad-T30 pad-B0">
	 	<div class="col-md-12 clearfix">
		  	<div class="row pad-B10 font-14 text-999">
				Select what happened during process:
			</div>
			<div class="row">
				' . $this->renderFeedbackOptions($feedBackOptions) . '
                                <div class="mrg-T15 text-999" id="show_comment" style="display:none;">
                                        Add Comment
					<span class="mrg-R20">
                                        <textarea name="comment_feedback" id="comment_feedback" style="height: 60px !important;" placeholder="Add Comment" rows="3" class="form-control mrg-T10"></textarea>
					</span>	
				</div>
                                
				</div>
			</div>
		  </div> 
		  <div class="clearfix pad-T5">
		  	
		  </div>         
      </div>
      <div class="modal-footer text-left">
		  <button type="button" class="btn btn-primary"  id="saveFeedback">SAVE</button>
      </div>
    ';
        }

        return $response;
    }

    public function renderFeedbackOptions($feedBackOptions)
    {
        $options = '';
        if ($feedBackOptions)
        {
            foreach ($feedBackOptions as $key => $val)
            {
                $class = '';
                if (strtolower($val->feedback_text) == 'other')
                {
                    $class = 'show_comment_area';
                }
                $options .= '<div class="">
                        <span class="mrg-R20">
                        <input type="radio" class="' . $class . '" name="feedback_answer" id="' . $key . '" value="' . $val->id . '$' . $val->feedback_text . '"><label for="' . $key . '"><span></span>' . $val->feedback_text . '</label>
                        </span>	
                    </div>';
            }
        }
        return $options;
    }

    public function getBookAmountHtml($post)
    {
        $favorite = '';
        if ($post['lead_id'])
        {
            $dataarray = array();
            $favorite  = $this->Crm_used_car->getLeadFavoriteCar($post['lead_id']);
        }
        if ($post['status'] == 'Booked')
        {
            //$text='Booking Done';
            $text      = 'Select the car ' . ($post['customer_name'] != '' ? $post['customer_name'] : 'Customer') . ' has booked';
            $inputText = 'Booking';
        }
        else if ($post['status'] == 'Customer Offer')
        {
            //$text='Offer Done';
            $text      = 'Select the car ' . ($post['customer_name'] != '' ? $post['customer_name'] : 'Customer') . ' has given offer on';
            $inputText = 'Offer';
        }
        else if ($post['status'] == 'Converted')
        {
            //$text='Sale Done';
            $text      = 'Select the car ' . ($post['customer_name'] != '' ? $post['customer_name'] : 'Customer') . ' has bought';
            $inputText = 'Sale';
        }
        $cancel   = base_url("assets/admin_assets/images/cancel.png");
        $stock    = base_url("assets/admin_assets/images/stock.png");
        $response = '<div class="modal-header bg-gray">
        <button type="button" class="close" data-dismiss="modal"><img src="' . $cancel . '"><span class="sr-only">Close</span></button>
        <h4 class="modal-title">' . $text . '</h4>
        <div class="text-header-new">*You can select only one car</div>
      </div>
      <div class="pad-all-30 pad-T15 pad-B15" style="display:inline-block; width:100%;">
	  	<div role="tabpanel">
			<ul class="nav nav-tabs similartabs" role="tablist">
                        <input type="hidden" name="status_amount" id="status_amount" value="' . $post['status'] . '"/>';
        if ($favorite)
        {
            $response .= '<li class="active"><a href="#faves" aria-controls="faves" role="tab" data-toggle="tab" class="stock-in">Favourites</a></li>
                                        <li><a href="#stock-in" aria-controls="stock-in" role="tab" data-toggle="tab" class="stock-in">Stock</a></li>
                                        </ul>
                                        <div class="tab-content">';
        }
        else
        {
            $response .= '<li class="active"><a href="#stock-in" aria-controls="stock-in" role="tab" data-toggle="tab" class="stock-in">Stock</a></li>
                                        </ul>
                                        <div class="tab-content">';
        }
        $fav = 'active';
        if ($favorite)
        {
            $favoriteHtml = $this->getFavoriteHtml($favorite, $inputText);
            $response     .= $favoriteHtml;
            $fav          = '';
        }
        $response .= '<div role="tabpanel" class="tab-pane ' . $fav . '" id="stock-in">
					<div class="clearfix pad-all-15 pad-B0">
						<div class="row">
							<div class="col-md-12">
								<input type="text" class="input-lg form-control ic-search edit-lead-name mrg-B15 searchmakemodellive" placeholder="Search Make Model here">
								<div id="carousel-example-generic3" class="carousel slide" data-ride="carousel">
							   <div class="carousel-inner" id="new-buyerlead2" role="listbox" style=" text-align: left; border: 1px solid #eee; box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);  border-radius: 5px;">
							  <div class="item active">
									
								  <ul class="list-unstyled car-list" id="stockHtml">
									<li class="">
										<div class="clearfix " style="position:relative; width:100%">
											<div class="col-md-12">
												<div class="img-box clearfix"  data-toggle="modal" data-target="#model-uploadPhoto">
													<!--<a href="#"> <div  class="img_thumb"></div></a>-->
													
												</div>
												
												
												
											</div>

                      <div class="col-md-12">
                        <div class="car-specs">
                          <div class="row list-icon" id="pref-avail">
                          <h2 class="carname mrg-T15"></h2>
                          <div class="text-center" style="width:100%">
                          <img src="' . $stock . '">
                          <div class="font-16 col-black mrg-T30 mrg-B30">No Car Available</div>
                          </div>
                          </div>
                          <div class="row mrg-T5">
                            <div class="col-black font-20 text-bold"></div>
                          </div>                          

                        </div>
											<div class="col-md-12">
												<!--<div class="car-specs">
													<div class="row list-icon" id="pref-avail">
														<ul>
															<li> </li>
														</ul>
													</div>
												</div>-->
												<div class="row mrg-T20">
													<div class="col-md-12">
														<!--<div class="row">
															<div class="col-md-3 pad-R0">
																<div class="font-14 col-black line-hit-35">Enter Amount</div>
															</div>
															<div class="col-md-6 pad-L0">
															 <input type="text" class="form-control rupee" placeholder="Enter Amount"  onkeypress="return forceNumber(event);"  onkeyup="wordc_.innerHTML=convertNumberToWords(this.value);" maxlength="9">
<div id="wordc_" class="price-text" style="clear:both;"></div>														</div>	
													
														</div>-->
													</div>													
												</div>
											</div>
											</div>
									</li>
									
								 </ul>
								</div>
              </div>
							
							 
							</div>
							</div>
						</div>           
					</div>

				</div>
        <div class="col-md-12">
              <div class="mrg-T15">
                  <button type="button" class="btn btn-primary btn-popup" id="saveofferstatus" style="width:100%">SAVE</button>
              </div>
            </div> 

			</div>

		</div>
				
                   
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Back</button>
        
      </div>-->
     
';
        return $response;
    }

    public function getFavoriteHtml($favorite, $inputText)
    {
        $total    = count($favorite);
        $response = '<div role="tabpanel" class="tab-pane active" id="faves">
					
					<div class="clearfix pad-all-15 pad-B0">
						<div id="carousel-example-generic2" class="carousel slide" data-ride="carousel">
							  <div class="carousel-inner" id="new-buyerlead2" role="listbox" style="text-align:left; border:1px solid #eee; border-radius:5px; box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);">';
        $counter  = 0;
        foreach ($favorite as $key => $val)
        {
            $price    = no_to_words($val['price']);
            $active   = ($counter == 0) ? 'active' : '';
            $img      = $this->Crm_used_car->getUsedCarImages($val['car_id']);
            $km       = $val['km'];
            $response .= '<div class="item ' . $active . '">
									<ul class="list-unstyled car-list">
									<li class="">
                                                                        <input type="hidden" id="amount_car_' . $val['car_id'] . '" name="amount_car_' . $val['car_id'] . '" value="' . $val['price'] . '" />
                                        <span class="check-bxnew">
                                        <input type="radio" class="selectoffercar" name="select_car_offer" value="' . $val['car_id'] . '" id="' . $val['car_id'] . '"><label for="' . $val['car_id'] . '"><span></span></label>
                                        </span>
										<div class="clearfix " style="position:relative;">
											<div class="col-md-6">
												<div class="img-box clearfix"  data-toggle="modal" data-target="#model-uploadPhoto">
													<a href="#"> <div  class="img_thumb"><img src="' . $img . '" class="img-responsive"></div></a>
													
												</div>
												
												
											</div>
											<div class="col-md-6">
												<div class="car-specs">
													<div class="row list-icon" id="pref-avail">
                                        <h2 class="carname">' . $val['make'] . " " . $val['model'] . " " . $val['version'] . '<a></a></h2>
													</div>
                          <div class="row mrg-T5">
                            <div class="col-black font-20 text-bold"><i class="fa fa-inr" aria-hidden="true"></i> ' . $price . '</div>
                          </div>														

												</div>	

												<!--<div class="row mrg-T20">
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-3 pad-R0">
																<div class="font-14 col-black line-hit-35">' . $inputText . ' Amount</div>
															</div>
															<div class="col-md-6 pad-L0">
															 <input type="text" class="form-control rupee" id="amount_' . $val['car_id'] . '" placeholder="Enter Amount"  onkeypress="return forceNumber(event);"  onkeyup="wordd_' . $val['car_id'] . '.innerHTML=convertNumberToWords(this.value);" maxlength="9">
<div id="wordd_' . $val['car_id'] . '" class="price-text" style="clear:both;"></div>														</div>	
													
														</div>
													</div>													
												</div>-->
											</div>
                      <div class="col-md-12">
                        <div class="details-car font-14">
                          <ul>
                              <li> <span>' . $km . '&nbsp;kms</span> <span> <i class="fa fa-circle col-dot" aria-hidden="true"></i> ' . $val['year'] . '</span>  <span> <i class="fa fa-circle col-dot" aria-hidden="true"></i> ' . $val['fuel_type'] . '</span> <span> <i class="fa fa-circle col-dot" aria-hidden="true"></i> ' . $val['regno'] . '</span></li>
                            </ul>
                            </div>
                        </div>

                        <div class="col-md-12">
                          <div class="mrg-T15 booking-amt">
                            <label>' . $inputText . ' Amount</label>
                               <input type="text" class="form-control rupee-icon rsicon" id="amount_' . $val['car_id'] . '" placeholder="Enter Amount"  onkeypress="return forceNumber(event);"  onkeyup="wordv_' . $val['car_id'] . '.innerHTML=convertNumberToWords(this.value);" value="" maxlength="9">
                                   <div id="wordv_' . $val['car_id'] . '" class="price-text" style="clear:both;"></div>
                              </div>
                        </div>

											</div>
									</li>
									
								 </ul>
								</div>';
            $counter++;
        }

        $response .= '</div>';
        if ($total > 1)
        {
            $response .= '<a class="left carousel-control" href="#carousel-example-generic2" role="button" data-slide="prev" style="top: 50%; width:5%; left:-45px;">
								<i class="fa fa-angle-left" aria-hidden="true"></i>
								<span class="sr-only">Previous</span>
							  </a>
							  <a class="right carousel-control" href="#carousel-example-generic2" role="button" data-slide="next" style="top: 50%; width:5%;right: -35px;">
								<i class="fa fa-angle-right" aria-hidden="true"></i>
								<span class="sr-only">Next</span>
							  </a>';
        }
        $response .= '</div>
					</div>
				</div>';
        return $response;
    }

    public function getstockHtml($val, $carImage)
    {
        $priceFilter = str_replace(",", "", $val['price']);
        $price       = no_to_words($priceFilter);
        if (!isset($val['version']))
        {
            $val['version'] = '';
        }
        if (!isset($val['make']))
        {
            $val['make'] = '';
        }
        if (!isset($val['model']))
        {
            $val['model'] = '';
        }
        $response = ' <li class="">
        <span class="check-bxnew">
          <input type="hidden" name="amount_car_' . $val['car_id'] . '" id="amount_car_' . $val['car_id'] . '" value="' . $priceFilter . '" />
          <input type="radio"  class="selectoffercar" checked name="select_car_offer" value="' . $val['car_id'] . '" id="' . $val['car_id'] . '"><label for="' . $val['car_id'] . '"><span></span></label>
          </span>
                <div class="clearfix " style="position:relative;">
                        <div class="col-md-6">
                                <div class="img-box clearfix"  data-toggle="modal" data-target="#model-uploadPhoto">
                                        <a href="#"> <div  class="img_thumb"><img src="' . $carImage . '" class="img-responsive"></div></a>

                                </div>

                                
                        </div>

                        <div class="col-md-6">
                        <div class="car-specs">
                          <div class="row list-icon" id="pref-avail">
                          <h2 class="carname">' . $val['make'] . " " . $val['model'] . " " . $val['version'] . '<a></a></h2>
                          </div>
                          <div class="row mrg-T5">
                            <div class="col-black font-20 text-bold"><i class="fa fa-inr" aria-hidden="true"></i> ' . $price . '</div>
                          </div>                            

                        </div>  

                        <div class="col-md-12">
                                <!--<div class="car-specs">
                                        <div class="row list-icon" id="pref-avail">
                                                <ul>
                                                        <li> <span>' . $price . ',</span>  <span>' . $val['fuel_type'] . ',</span> <span>' . $val['transmission'] . '</span></li>
                                                </ul>
                                        </div>														

                                </div>-->	
                                <!--<div class="row mrg-T20">
                                        <div class="col-md-12">
                                                <div class="row">
                                                        <div class="col-md-3 pad-R0">
                                                                <div class="font-14 col-black line-hit-35">Enter Amount</div>
                                                        </div>
                                                        <div class="col-md-6 pad-L0">
                                                         <input type="text" class="form-control rupee" id="amount_' . $val['car_id'] . '" placeholder="Enter Amount"  onkeypress="return forceNumber(event);"  onkeyup="wordm_' . $val['car_id'] . '.innerHTML=convertNumberToWords(this.value);" maxlength="9">
<div id="wordm_' . $val['car_id'] . '" class="price-text" style="clear:both;"></div>
                                                        </div>	

                                                </div>
                                        </div>													
                                </div>-->
                        </div>

                        </div>
                        <div class="col-md-12">
                        <div class="details-car font-14">
                          <ul>
                              <li> <span>' . $val['Kms'] . '&nbsp;kms</span> <span> <i class="fa fa-circle col-dot" aria-hidden="true"></i> ' . $val['myear'] . '</span>  <span> <i class="fa fa-circle col-dot" aria-hidden="true"></i> ' . $val['fuel_type'] . '</span> <span> <i class="fa fa-circle col-dot" aria-hidden="true"></i> ' . $val['regno'] . '</span></li>
                            </ul>
                            </div>
                        </div>

                        <div class="col-md-12">
                          <div class="mrg-T15 booking-amt">
                            <label>Enter Amount</label>
                               <input type="text" class="form-control rupee-icon rsicon" id="amount_' . $val['car_id'] . '" placeholder="Enter Amount"  onkeypress="return forceNumber(event);"  onkeyup="worda_' . $val['car_id'] . '.innerHTML=convertNumberToWords(this.value);" maxlength="9">
<div id="worda_' . $val['car_id'] . '" class="price-text" style="clear:both;"></div>
                              </div>
                        </div>

                      </div>
        </li>';

        return $response;
    }

    public function SyncbuyerupdatedLeadsfromDC($apikey)
    {
        $requestParams = $this->input->post();
        $datas         = [];
        $datanew       = array();
        if ($apikey == 'p3zW7WLsni08WqoeQ=')
        {
            if (!empty($requestParams))
            {
                //echo "hio"; exit;
                $datanew = json_decode($requestParams['info'], true);
                //echo "<pre>"; print_r($datanew);die;
                if (!empty($datanew))
                {
                    $datanew['txtname']          = !empty($datanew['name']) ? $datanew['name'] : '';
                    $datanew['price_max']        = !empty($datanew['budget']) ? $datanew['budget'] : '';
                    $datanew['gaadi_id']         = !empty($datanew['car_id']) ? $datanew['car_id'] : '';
                    $datanew['only_update_flag'] = !empty($datanew['car_id']) ? 0 : 1;
                    $datanew['dcsync'] = '1';
                    $datanew['method'] = 'leadadd';
                    $leadResponse      = $this->addNewLead($datanew); //call function
                }
            }
            else
            {
                echo "No Data";
            }
            echo $leadResponse;
        }
        else
        {
            echo "Invalid Api key";
        }
    }

    public function addLead()
    {
        $requestParams = $this->input->post();
        $datanew       = [];
        $pushtoDC = array();

        if (!empty($requestParams))
        {
            $datanew['customer_name']   = $requestParams['txtcustName'];
            $datanew['customer_mobile'] = $requestParams['txtMobile'];
            $datanew['status_id']       = $requestParams['status'];
            $datanew['follow_date']     = date('Y-m-d H:i:s', strtotime($requestParams['followup_date']));
            $datanew['lead_source']     = $requestParams['lead_source'];
            $datanew['lead_sub_source'] = 'self';
            $datanew['car_id']          = $requestParams['car_id'];

            $id = $this->Crm_used_car_sale_case_info->addBuyerDetails($datanew);            
            $statusTxt = $this->Crm_used_car_sale_case_info->getStatusName($requestParams['status']);
            
            //push lead to DC
            $pushtoDC['txtname'] = $requestParams['txtcustName'];
            $pushtoDC['txtemail'] = "";
            $pushtoDC['txtmobile'] = $requestParams['txtMobile'];
            $pushtoDC['cd_alternate_mobile'] = "";
            $pushtoDC['locality_id'] = "";
            $pushtoDC['lead_source'] = "WALK-IN";
            $pushtoDC['price_max'] = "";
            $pushtoDC['cusstatus'] = $statusTxt['status_name'];
            $pushtoDC['followdate'] = date('Y-m-d H:i:s', strtotime($requestParams['followup_date']));
            $pushtoDC['dfollowdate'] = "";
            $pushtoDC['txtcomment'] = "";
            $pushtoDC['lognew'] = "add";
            $pushtoDC['gaadi_id'] = $requestParams['car_id'];
            $pushtoDC['type'] = "similar_cars";
            
            $res = $this->addNewLead($pushtoDC);
            
            $response = json_decode($res);
            
            if ($id && $response['status'] == 'T')
            {
                exit(json_encode(['msg' => 'Lead Added Successfully', 'status' => true]));
            }
            else
            {
                exit(json_encode(['msg' => 'Something is wrong!', 'status' => false]));
            }
        }
    }

    public function ajax_alreadyExistsCustomer()
    {
        $mobile =$this->input->post('mobile');
        $status  = $this->Leadmodel->leadAlreadyExist($mobile,DEALER_ID);
        if((empty($status)) || ($status=='13') || ($status=='12'))
        {
            echo json_encode(array('status'=>'1')); exit;
        }
        else
        {
           echo json_encode(array('status'=>'0')); exit; 
        }

    }

    public function getdashboardlistpage($case)
    {
        $headerInfo['case'] = ($case!='conversion')?'Walk-in Done':'Converted';;
        $counts = $this->Leadmodel->getdashboardLeadspage($case);
        $data = $this->Leadmodel->getdashboardLeadspage($case,'1');
        $leads = [];
        $i=0;
        foreach ($data as $key => $value) {
                $resultCarList = $this->Leadmodel->getLeadCarList(array(), $value['lead_id']);
                $lastCar = $this->Leadmodel->leadwiseCarListgetLeads($value['lead_id']);
                $leads[$i] = $data[$i];
                if($lastCar){
                $leads[$i]['makeid'] = intval($lastCar[0]['makeID']);
                $leads[$i]['model'] = $lastCar[0]['model'];
                $leads[$i]['db_version'] = $lastCar[0]['version'];
                $leads[$i]['make'] = $lastCar[0]['make'];
                $leads[$i]['reg_no'] = $lastCar[0]['regno'];
                 $leads[$i]['make_year'] = $lastCar[0]['year'];
                }
                $leads[$i]['car_list'] = $resultCarList;

                    $lcp_makename = '';
                    $lcp_modelname = '';
                    $bodytype = explode(",", $val['lcp_body_type']);
                    $lcp_make = explode(",", $val['lcp_make']);
                    $lcp_model = explode(",", $val['lcp_model']);
                    
                    
                if ((intval($val['lcp_price_to']) > 0 || trim($val['lcp_make']) != '' || trim($val['lcp_model']) != '')) {
                        $lcp_fuel_type = explode(",", $val['lcp_fuel_type']);
                        $lcp_transmission_type = explode(",", $val['lcp_transmission_type']);
                        $leads[$i]['preferences'] = [
                            'budget' => ($val['lcp_price_to'] == '' ? '0' : $val['lcp_price_to']),
                            'fuelType' => $lcp_fuel_type[0],
                            'transmission' => $lcp_transmission_type[0],
                            'bodyType' => ((trim($val['lcp_body_type']) == '') ? [] : $bodytype),
                            'makeIds' => ((trim($val['lcp_make']) == '' ) ? [] : $lcp_make),
                            'modelIds' => ((trim($val['lcp_model']) == '') ? [] : $lcp_model),
                        ];
                    } 
                    $i++;
        }
      
        $headerInfo['data'] = $leads; 
        $headerInfo['counts']=!empty($counts['counts'])?$counts['counts']:'0';
        $this->loadViews('lead/dashboardlist', $headerInfo);
    }


}
