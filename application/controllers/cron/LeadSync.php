<?php

class LeadSync extends MY_Controller
{

    public function index()
    {
        
    }

    public function __construct()
    {
        parent::__construct();
        $this->dateTime = date("Y-m-d H:i:s");

        $this->load->model('Cnt_used_car');
        $this->load->model('Leadmodel');
        $this->load->model('Crm_buy_lead_history_track');
        $this->load->helper('curl_helper');
    }
    public function syncLead(){
        $filter_data = [
            'dealer_id' => DEALER_ID
        ];
        $this->Leadmodel->crmToDcLeadSync($filter_data);
    }
//    public function crmToDcLeadSync()
//    {
//
//        $filter_data = [
//            'dealer_id' => DEALER_ID
//        ];
//        /*
//         *  PICK-UP LEADS WITH syncd_with_dc = 0
//         */
//        $aSyncLeads  = $this->Leadmodel->getAsyncLeads($filter_data);
////print_r($aSyncLeads);die;
//        $url = API_URL . "api/buyer_lead_verify_crm.php?apikey=U3KqyrewdMuCotTS&method=addBuyerLead";
//        $i   = 0;
//        foreach ($aSyncLeads as $leads)
//        {
//            $lead_id      = $leads['ldm_id'];
//            $data_to_sync = $this->dcData($leads);
//
//            $sent_time   = date('Y-m-d H:i:s');
//            /*
//             * LOG THE API REQUEST
//             */
//            $log_data=[
//                'sync_module'   => 'lead',
//                'lead_id'       => $lead_id,
//                'api_url'       => $url,
//                'source'        => 'crm',
//                'dealer_id'     => DEALER_ID,
//                //'request'       => json_encode($data_to_sync),
//                'added_by'      => $this->session->userdata['userinfo']['id'],
//                'sent_time'     => $sent_time,
//            ];
//            $log_id=$this->Leadmodel->api_log($log_data);
//            
//            $data_to_sync['log_id']=$log_id;
//            $json_data    = json_encode($data_to_sync);
//            /*
//             * PUSH LEADS TO DC
//             * API CALL
//             */
//            $dc_response = $this->Leadmodel->sendLeadsToDC(['info' => $json_data], $url);
//
//            $response_json = json_decode($dc_response, true);
//            /*
//             * LOG THE API RESPONSE
//             */
//            $this->Leadmodel->api_log([
//                'reference_lead_id' => $response_json['lead_results'][0]['lead_id'],
//                'reference_log_id'  => $response_json['log_id'],
//                'request'           => $json_data,
//                'response'          => $dc_response,
//                'status'            => strtoupper($response_json['lead_results'][0]['status']) == 'T' ? 'T' : 'F',
//                'response_time'     => date('Y-m-d H:i:s'),
//            ],$log_id);
//
//            /*
//             * IF API RESPONSE = TRUE 
//             * THEN SET  syncd_with_dc = 1 
//             */
//            if ($response_json['lead_results'][0]['status'])
//            {
//                $i++;
//                $updateData = ['syncd_with_dc' => '1'];
//                $this->db->where('ldm_id', $lead_id);
//                $this->db->update('crm_buy_lead_dealer_mapper', $updateData);
//            }
//        }
//        echo $i . ' lead(s)  synced with Dealer Central ' . PHP_EOL . 'view [request-response] log in crm_dc_sync_log';
//    }
//
//    public function dcData($crmData)
//    {
//
//        if ($crmData['status_name'] == 'Walk-in Scheduled')
//        {
//            $crmData['status_name'] = "Walk In";
//        }
//        else if ($crmData['status_name'] == 'Walk-in Done')
//        {
//            $crmData['status_name'] = "Walked In";
//        }
//
//        $historyData = $this->Crm_buy_lead_history_track->getLeadHistoryTrack($crmData['ldm_id'], '', '1');
//       
//        $dcData= [
//            'lead_id'                      => $crmData['ldm_id'],
//            'customer_name'                => $crmData['ldm_name'],
//            'customer_mobile'              => $crmData['mobile'],
//            'dc_dealer_id'                 => 69,
//            'customer_email'               => $crmData['ldm_email'],
//            'comment'                      => !empty($historyData[0]['comment']['comment_text']) ? $historyData[0]['comment']['comment_text'] : '',
//            'lead_alternate_mobile_number' => $crmData['ldm_name'],
//            'budget'                       => $crmData['ldm_name'],
//            'lead_source'                  => $crmData['ldm_source'],
//            'sub_source'                   => $crmData['ldm_sub_source'],
//            'next_follow'                  => ($crmData['ldm_follow_date'] != '0000-00-00 00:00:00' ? $crmData['ldm_follow_date'] : ''),
//            'lead_status'                  => $crmData['status_name'],
//            'locality_id'                  => $crmData['ldm_location_id'],
//            'city_id'                      => $crmData['ldm_city_id'],
//            'gaadi_verified'               => $crmData['gaadi_verified'],
//            'opt_verified'                 => $crmData['opt_verified'],
//            'is_finance'                   => $crmData['is_finance'],
//            'car_id'                       => $crmData['car_id'],
//            'only_update_flag'             => !empty($crmData['car_id'])?0:1,
//            'ldm_lead_rating'              => $crmData['ldm_lead_rating'],
//            //user preferences data
//            'makeIds'                      => $crmData['lcp_make'],
//            'modelIds'                     => $crmData['lcp_model'],
//            'fuel_type'                    => $crmData['lcp_fuel_type'],
//            'transmission'                 => $crmData['lcp_transmission_type'],
//            'uc_b_type'                    => $crmData['lcp_body_type'],
//            //'lead_created_date'            => $crmData['ldm_created_date'],
//        ];
//        if(strtolower($crmData['status_name'])=='booked'){
//           $dcData['booking_amount']=$crmData['ldm_amount'];
//        }
//        if(strtolower($crmData['status_name'])=='customer offer'){
//           $dcData['offer_amount']=$crmData['ldm_amount'];
//        }
//        if(strtolower($crmData['status_name'])=='converted'){
//           $dcData['sale_amount']=$crmData['ldm_amount'];
//        }
//        return $dcData;
//    }

}
