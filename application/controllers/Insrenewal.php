<?php

class Insrenewal extends MY_Controller {

    public $activity_mapping = [];

    public function index() {
        
    }

    public function __construct() {
        parent::__construct();
        $this->load->model('Crm_user');
        $this->load->model('Crm_renew');
        $this->load->model('Crm_renew_history_track');
        $this->load->model('Crm_insurance');
        $this->load->helpers('range_helper');
        if (!$this->session->userdata['userinfo']['id']) {
            return redirect('login');
        }
    }

    function RenewLeadIndex() {
        $data = [];
        $this->global['pageTitle'] = 'CodeInsect : Add Lead';
        $data['maxPriceArr'] = array('0' => 'Price Min', '25000' => '25,000', '50000' => '50,000', '75000' => '75,000', '100000' => '1 Lakh', '125000' => '1.25 Lakh', '150000' => '1.5 Lakh', '175000' => '1.75 Lakh', '200000' => '2 Lakh', '225000' => '2.25 Lakh', '250000' => '2.5 Lakh', '275000' => '2.75 Lakh', '300000' => '3 Lakh', '325000' => '3.25 Lakh', '350000' => '3.5 Lakh', '375000' => '3.75 Lakh', '400000' => '4 Lakh', '425000' => '4.25 Lakh', '450000' => '4.5 Lakh', '475000' => '4.75 Lakh', '500000' => '5 Lakh', '550000' => '5.5 Lakh', '600000' => '6 Lakh', '650000' => '6.5 Lakh', '700000' => '7 Lakh', '750000' => '7.5 Lakh', '800000' => '8 Lakh', '850000' => '8.5 Lakh', '900000' => '9 Lakh', '950000' => '9.5 Lakh', '1000000' => '10 Lakh', '1100000' => '11 Lakh', '1200000' => '12 Lakh', '1300000' => '13 Lakh', '1400000' => '14 Lakh', '1500000' => '15 Lakh', '1600000' => '16 Lakh', '1700000' => '17 Lakh', '1800000' => '18 Lakh', '1900000' => '19 Lakh', '2000000' => '20 Lakh', '2500000' => '25 Lakh', '3000000' => '30 Lakh', '4000000' => '40 Lakh', '5000000' => '50 Lakh', '7500000' => '75 Lakh', '10000000' => '1 Crore', '30000000' => '3 Crore');
        $data['statusData'] = $this->Crm_buy_customer_status->getCustomerStatus(['1', '2', '13']);
        $data['makeList'] = $this->Make_model->getCarMakeList('used');
        $data['getDeatCarFuelArr'] = array('Petrol', 'Diesel', 'CNG', 'LPG', 'Hybrid', 'Electric');
        $locpost['ucdid'] = DEALER_ID;
        $data['localityData'] = $this->Ublms_locations->getdealerlocality($locpost);
        $this->loadViews("renew/add_buyer_lead", $this->global, $data, NULL);
    }
    
     public function getInsCases()
            {
            $is_admin=$this->session->userdata['userinfo']['is_admin'];
            $dealerId           = DEALER_ID;
            if($this->input->get("type")){
                $type=$this->input->get("type");
            }else{
                $type=$this->input->post("type");
            }
            $role_id = $this->session->userdata['userinfo']['role_id'];
            $roleType=array('Executive');
            $data['execList'] =  $this->Crm_user->getEmployee('3','','');
            $keyword=$this->input->post("keyword");
            $filter_data_type=$this->input->get("type");
            $filter=$this->input->get("filter");
            $datapost=$this->input->post();
            $renewtabCounts=$this->Crm_renew->leadTabCounts($datapost,$dealerId);
            $totalcnt=!empty($renewtabCounts['tot']) ? $renewtabCounts['tot']:0;
            $status=$this->input->get("status");
            $headerInfo=[
                  'pageTitle'=>'Renewal Cases',
                  'is_admin' => $is_admin,
                  'ptype' => 'assign',  
                  'role_id' => $role_id,
                  'data' =>  $data,
                  'totalcase' => $totalcnt  
                ];
            $this->loadViews('insrenewal/list_renew_case',$headerInfo);
            }
            
    public function getRenewListing($tabtype="")
            {
            $is_admin=$this->session->userdata['userinfo']['is_admin'];
            $dealerId = DEALER_ID;
            if($tabtype != "") {
                if($tabtype == 1 || $tabtype ==3)
                   $type = "allcount";   
                else if($tabtype == 4)
                   $type = "policyexpired";
                else if($tabtype == 2)
                    $type = "allfollow";
            }else{
            if($this->input->get("type")){
                $type=$this->input->get("type");
            }else{
                $type=$this->input->post("type");
            }
            }
            $role_id = $this->session->userdata['userinfo']['role_id'];
            $datapost=$this->input->post();
            $datapost['tabtype'] = $tabtype;
            $roleType=array('Executive');
            $data['execList'] =  $this->Crm_user->getEmployee('3','','');
            $keyword=$this->input->post("keyword");
            $filter_data_type=$this->input->get("type");
            $userId=$this->session->userdata['userinfo']['id'];
            $filter=$this->input->get("filter");
            $lead_status=$this->Crm_renew->getRenewFollowStatus();
            $status=$this->input->get("status");
            $renewtabCounts=$this->Crm_renew->leadTabCounts($datapost,$dealerId);
            $totalcnt=!empty($renewtabCounts['tot']) ? $renewtabCounts['tot']:0;
            $headerInfo=[
                  'pageTitle'=>'Renewal Cases',
                  'is_admin' => $is_admin,
                  'lead_status' => $lead_status, 
                  'ptype' => 'listing',  
                  'data' =>  $data,
                  'totalcase' => $totalcnt,
                  'role_id' => $role_id,
                  'type' =>$type,
                  'tabtype' =>$tabtype
                ];
            //echo '<pre>';print_r($headerInfo);die; 
            $this->loadViews('insrenewal/list_renew_case',$headerInfo);
            }
             public function ajax_getRenew()
            {
               $is_admin=$this->session->userdata['userinfo']['is_admin'];
               $dealerId=DEALER_ID;
               $datapost=$this->input->post();
               $datapost['ucdid']=DEALER_ID;
               $role_id = $this->session->userdata['userinfo']['role_id'];
               $lead_status = $this->Crm_renew->getRenewFollowStatus(array('3', '4','6'));
               if($role_id == 3){
               $userId=$this->session->userdata['userinfo']['id'];
               $datapost['userId']=$userId;    
               }
               $ptype=isset($datapost['ptype']) ? $datapost['ptype']:'';
               $type = isset($datapost['type']) ? $datapost['type']:'';
               $renewtabCounts=$this->Crm_renew->leadTabCounts($datapost,$dealerId);
               
               $getCases= $this->Crm_renew->getCaseList($datapost,$dealerId,$userId);
               if($ptype == 'listing'){
               $countArray = array('allcount' => 'allcount','allfollow' => 'todayfollowup','pastfollow'=>'pastfollowdate','upcomingfollow' => 'futureFollowupDate','breakin' => 'breakIn','lost' => 'lost','policyexpired'=>'policyexpired');
               }else{
               $countArray = array('all' => 'tot','assigned'=>'totassigned','notassigned' => 'totnotassigned');    
               }
               
               $headerInfo=[
                          'query'    => $getCases,
                          'renewtabCount' => $renewtabCounts,
                          'lead_status' => $lead_status,
                          'is_admin' => $is_admin,
                          'role_id' => $role_id,
                          'ptype' => $ptype,
                          'total_count' => $renewtabCounts[$countArray[$type]], 
                          'type' => $this->input->post('type')
                        ];
              // echo "<pre>";print_r($headerInfo);die();
               $this->load->view('insrenewal/ajax_getRenew',$headerInfo);
            }
        
    

    public function getEmplist() {
        $srchtxt = $this->input->post('txtsrch');
        $chkassign = $this->input->post('chkassign');
        $assignedCases = $this->input->post('assignedCases');
        //echo "<PRE>";
        //print_r($chkassign);
        $assignedCase = '';
        if (!empty($chkassign)) {
            $y = 0;
            foreach ($chkassign as $key => $val) {
                $assignedCase .= $val . ",";
                $y++;
            }
            $assignedCase = trim($assignedCase, ",");
        }
        if(!empty($assignedCases))
        {
          if(!empty($assignedCase))
           $assignedCase .= ','.$assignedCases;
          else
           $assignedCase = $assignedCases;
           //$assignedCase = trim($assignedCase, ",");
        }

        $html = '';
        $roleType = array('Executive');
        $execList = $this->Crm_user->getEmployeeByName($srchtxt, '', $roleType);
        if (!empty($execList)) {
            $i = 0;
            foreach ($execList as $ekey => $eval) {
                $html .= '<div class="list-group-item">
                  <div class="col-md-12 pad-L0 pad-R0">
                      <input class="mrg-T10 clsoptassign" type="radio" name="optassign[]" id="exe_' . $i . '" value="' . $eval['id'] . '">
                        <label class="w100" for="exe_' . $i . '">
                            <p class="ws mrg-B0" style="display: inline-block">' . $eval['name'] . '<br><i class="oi">' . $eval['email'] . '</i></p> <span class="mrg-R0"></span>
                                
                        </label>
                  </div>
                </div>';
                  $i++;}
                  $y=isset($y) ? $y:'';
                  $html.='<input type="hidden" name="assigntxt" id="assigntxt" value="'.$assignedCase.'">';
                  $html.='<input type="hidden" name="totassign" id="totassign" value="'.$y.'">';
                 }
               echo $html;   
           }
           
           public function getAssignCases(){
               $optassign=$this->input->post('optassign');
               $assignCaseIds=$this->input->post('assigntxt');
               $optassignId='';
               if(!empty($optassign) && !empty($assignCaseIds)){
                   foreach($optassign as $oval){
                       $optassignId=$oval;
                   }
                   $cases=explode(",",$assignCaseIds);
                   $data['assign_to']=$optassignId;
                   foreach($cases as $kc=>$vc){
                       $status=$this->Crm_renew->setAssignCases($data,$vc);
                   }
               }
               if(!empty($status)){
                $result= array('status'=>'True','message'=>'Case Assigned Successfully','Action'=>  base_url().'getInsCases/1');   
                }
                echo json_encode($result);exit;
           }
           
          public function renewUpdateStatus(){
              //error_reporting(0);
              $hdata=[];
              $data=[];
              $postData=$this->input->post();
              //echo "<pre>";print_r($postData);exit;
              $userId=$this->session->userdata['userinfo']['id'];
              $case_id                = !empty($postData['case_id']) ? $postData['case_id'] : '';
              $hdata['case_id'] = !empty($postData['case_id']) ? $postData['case_id'] : '';
              $lead_status = $this->Crm_renew->getRenewFollowStatus();
              foreach ($lead_status as $status) {
                  $this->activity_mapping[$status->status] = $status->id;
              }
              $hdata['activity']  = $this->activity_mapping[$postData['status']];
              $hdata['activity_text']  = !empty($postData['comment']) ? $postData['comment']:'';
              $hdata['user_id']        = $userId;
              $data['follow_status']    = $this->activity_mapping[$postData['status']];
              $follow_up_date    = (isset($postData['follow_up']))?$postData['follow_up']:'';
              if($follow_up_date != ""){
              $data['follow_up_date']     = date('Y-m-d H:i:s', strtotime($follow_up_date));    
              }
              $data['last_updated_date'] = date('Y-m-d H:i:s');
              
              if($postData['status']=='Closed'){
                   if (isset($postData['feedback_id']) && ($postData['feedback_id'] == '3')) {
                      $this->Crm_insurance->updateInsuranceCaseById(array('renew_flag'=>'2'),$case_id);
                   }
              }
               if($case_id){
                    $this->Crm_renew->updateFollowStatus($case_id,$data);
                    $status=$this->Crm_renew->addUpdateHistory($hdata);
                }
                echo $status;exit;


        $lead_status = $this->Crm_renew->getRenewFollowStatus();
        foreach ($lead_status as $status) {
            $this->activity_mapping[$status->status] = $status->id;
        }
        $hdata['activity'] = $this->activity_mapping[$postData['status']];
        $hdata['activity_text'] = !empty($postData['comment']) ? trim($postData['comment']) : '';
        $hdata['user_id'] = $userId;
        $data['follow_status'] = $this->activity_mapping[$postData['status']];
        $follow_up_date = (isset($postData['follow_up'])) ? $postData['follow_up'] : '';
        $data['follow_up_date'] = date('Y-m-d H:i:s', strtotime($follow_up_date));
        //echo "<pre>";print_r($data);exit;
        if ($postData['status'] == 'Closed') {
             if(!empty($postData['feedback_id']) && $postData['feedback_id']=='3'){
                $this->Crm_insurance->updateInsuranceCaseById(array('renew_flag' => '2'), $case_id);
             }
        }
        if ($case_id) {
            $this->Crm_renew->updateFollowStatus($case_id, $data);
            $status = $this->Crm_renew->addUpdateHistory($hdata);
        }
        echo $status;
        exit;
    }

    public function ajax_renew_lead_update() {
        //echo "<PRE>";
        //print_r($this->input->post());die;
        $req['dealerid'] = DEALER_ID;
        $dealer_id = DEALER_ID;
        $type = $this->input->post('type');
        $headerInfo = [
            'type' => $type
        ];

        switch ($type) {
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

    public function getFeedback() {
        $response = '<div class="modal-header bg-gray">
        <button type="button" class="close" data-dismiss="modal"><img src="' . BASE_URL . 'assets/admin_assets/images/cancel.png"><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Reason for closing the lead</h4>
      </div>
      <div class="modal-body">
	 	<div class="col-md-12 clearfix">
		  	<div class="row pad-B10">
				Select what happened during process:
			</div>
			<div class="row">';
        $response .= $this->getcloselist();
        $response .= '</div>
                    </div>
			</div>
		  </div> 
		  <div class="clearfix pad-T5 mrg-R20">
		  	
		  </div>         
      </div>
      <div class="modal-footer pad-T0 text-left">
		<button type="button" class="btn btn-primary"  id="saveFeedback">Save</button>
      </div>
    ';
        return $response;
    }

    public function getcloselist() {
        $list = $this->Crm_renew->getClosereason();
        $str = '';
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $str .= '<div class="">
                <span class="mrg-R20">
                <input type="radio" class="" name="feedback_answer" id="' . $v->reasonId . '" value="' . $v->reasonId . '$' . $v->reason . '"><label for="' . $v->reasonId . '"><span></span>' . $v->reason . '</label>
                </span>
                </div>';
            }
        }
        return $str;
    }

    public function get_history() {
        //$lead_id=$_REQUEST['lead_id'];//23;//
        $lead_id = $this->input->post('lead_id');
        $this->load->helpers('history_helper');
        $usertype = '';
        if ($lead_id) {

            $historyData = $this->Crm_renew_history_track->getRenewHistoryTrack($lead_id, $usertype);
            if ($historyData) {
                echo renderHistoryRenewHTMLFinal($historyData);
                exit;
            } else {
                echo 'No history available';
                exit;
            }
        } else {

            echo 'Sorry request not valid';
            exit;
        }
    }

}
