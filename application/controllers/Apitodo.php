<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class : Crontodo (CrontodoController)
 * User Class to control all Cron related operations.
 * @author : rakesh kumar
 */
class Apitodo extends MY_Controller
{
    public $activity_mapping = array('1' => 'status', '2' => 'comment', '3' => 'followup', '4' => 'call', '5' => 'share', '6' => 'feedback', '7' => 'walkindate');
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Leadmodel');
        $this->load->model('Leadsellmodel');
        $this->load->model('Crm_dealers');
        $this->load->model('Leadmodel');
        $this->load->model('Cnt_used_car');
        $this->load->model('crm_stocks');
        $this->load->model('UsedCarImageMapper');
        $this->load->model('Crm_rc');
        //$this->load->library('input');

        /*if (!$this->session->userdata['userinfo']['id'])
        {
            return redirect('login');
        }*/
    }
    //api to push updated Lead from CRM to Lead Table    
    public function buyerupdatedLeadsfromDC()
    {
        $requestParams     = $this->input->post();
        $apikey = $requestParams['apikey'];
        $dataarr = array();
        $leaddata = array();
        if ($apikey == 'p3zW7WLsni08WqoeQ=') {
            if (!empty($requestParams['data'])) {
                $jsondata = $requestParams['data'];
                $datas = json_decode($jsondata, true);
                $jsonError = json_last_error();
                if (!is_array($datas) || ($jsonError != JSON_ERROR_NONE)) {
                    array_push($dataarr, 'json parse error.');
                    $sub = 'CRM verify lead Could not decode';
                    mail('k.rakesh@girnarsoft.com', $sub, $jsondata);
                } else {
                    array_push($dataarr, 'Success');
                }
            } else {
                array_push($dataarr, 'Invalid Api Key');
            }
            $leaddata['requestdata'] = $jsondata;
            $leaddata['responsedata'] = json_encode($dataarr);
            $leaddata['processed'] = 0;
            $leaddata['api_name'] = 'status_only';
            $leaddata['date_time'] = date('Y-m-d H:i:s');
            $this->Leadmodel->addlogbuyerupdatedLeadsfromDC($leaddata);
            echo json_encode($dataarr);
        } else {
            echo "Invalid Api key";
        }
    }

    //api to push updated Lead from DC to Lead Table    
    public function sellerupdatedLeadsfromDC($apikey)
    {
        $requestParams     = $this->input->post();
        $apikey = $apikey;
        $datapost = array();
        $leaddata = array();
        if ($apikey == 'p3zW7WLsni08WqoeQ=') {
            $datapost = json_decode($requestParams['info'], true);
            $sellCustomerId = $this->Leadsellmodel->setSellCustomer($datapost);
            $this->Leadsellmodel->setSellCustomerComments($datapost, $sellCustomerId);
            $this->Leadsellmodel->setSellCustomerCarDetails($datapost, $sellCustomerId);
        } else {
            echo "Invalid API Key";
        }
    }
    public function sellerupdatedCommentsLeadsfromDC($apikey)
    {
        $requestParams     = $this->input->post();
        $apikey = $apikey;
        $datapost = array();
        $leaddata = array();
        if ($apikey == 'p3zW7WLsni08WqoeQ=') {
            $datapost = json_decode($requestParams['info'], true);
            $this->Leadsellmodel->setSellCustomerCommentsfromDC($datapost, $sellCustomerId);
        } else {
            echo "Invalid API Key";
        }
    }

    //public function addUsedCarDetailsApi($apikey)
    //{
    //    // echo "dfsefr4r"; exit;
    //    $requestParams     = $this->input->post();
    //    $apikey=$apikey;
    //    $datapost=array();
    //    $leaddata=array();
    //    if($apikey== 'p3zW7WLsni08WqoeQ=') 
    //    {
    //       //$datapost=json_decode($requestParams,true);
    //        $this->UserDashboard->addUsedCarApi($requestParams);
    //        
    //    }else{
    //        echo "Invalid API Key";
    //    }
    //}

    public function addDealerAdminDetailsApi($apikey)
    {
        // echo "dfsefr4r"; exit;
        $requestParams     = $this->input->post();
        $apikey = $apikey;
        $datapost = array();
        $leaddata = array();
        if ($apikey == 'p3zW7WLsni08WqoeQ=') {
            $this->Crm_dealers->addUpdateAdminDealer($requestParams);
        } else {
            echo "Invalid API Key";
        }
    }

    public function addUsedCarDetailsApi($apikey)
    {
        $requestParams     = $this->input->post();
        $car_id = !empty($requestParams['id']) ? $requestParams['id'] : 0;

        // $cntUcData = $this->Cnt_used_car->getCntUsedCarData($car_id);
        //echo 'asdfsd';die;

        //$response = [];
        //        foreach ($cntUcData as $cntData)
        //        {
        if ($requestParams['dealer_id'] != 6359) {
            $response       = ['cnt_id' => 0, 'error' => 'not valid dealer', 'status' => 'T'];
            //echo json_encode($response);die;
        }

        $rawData = $this->Cnt_used_car->DcToCrmMapping($requestParams);
        $crmUsedCarData = array_filter($rawData, function ($value) {
            return trim($value) !== '';
        });
        //update
        $crm_used_car = $this->db->query('select * from crm_used_car where id=' . $car_id)->result_array();
        //print_r($crm_used_car);die;
        if (!empty($crm_used_car)) {
            $cnt_car_id = $this->crm_stocks->save_crm_used_car($crmUsedCarData, $car_id);
            $otherData  = $this->db->query('select * from crm_used_car_other_fields where cnt_id=' . $cnt_car_id)->row_array();
            $case_id    = $otherData['case_id'];

            $usedcarother = [];
            $usedcarother['tradetype']      = '2';
            $usedcarother['hypo']           = '2';
            $usedcarother['reg_date']       = $rawData['reg_date'];
            $usedcarother['insurance_date'] = $crmUsedCarData['insurance_type'] != 'no insurance' ? $crmUsedCarData['insurance_exp_year'] . '-' . $crmUsedCarData['insurance_exp_month'] . '-' . '1' : '0000-00-00';
            $this->db->where('case_id', $case_id);
            $this->db->update('crm_used_car_other_fields', $usedcarother);
        }
        //insert
        else {

            $cnt_car_id = $this->crm_stocks->save_crm_used_car($crmUsedCarData);
            //'tradetype' => '2',
            $case_id    = $this->crm_stocks->addCrmUsedcarPurchaseCaseinfo(['created_date' => date('Y-m-d H:i:s'), 'updated_date' => date('Y-m-d H:i:s')]);

            $usedcarother = [];
            $usedcarother['cnt_id']         = $cnt_car_id;
            $usedcarother['case_id']        = $case_id;
            $usedcarother['tradetype']      = '2';
            $usedcarother['reg_date']           = $rawData['reg_date'];
            $usedcarother['insurance_date'] = $crmUsedCarData['insurance_type'] != 'no insurance' ? $crmUsedCarData['insurance_exp_year'] . '-' . $crmUsedCarData['insurance_exp_month'] . '-' . '1' : '0000-00-00';

            $this->db->insert('crm_used_car_other_fields', $usedcarother);
            $this->db->insert_id();
        }
        $central_stock_id = $this->crm_stocks->crmCentralStock([
            'reg_no'           => $crmUsedCarData['reg_no'],
            'version_id'       => $crmUsedCarData['version_id'],
            'mm'               => $crmUsedCarData['make_month'],
            'myear'            => $crmUsedCarData['make_year'],
            'km'               => $crmUsedCarData['km_driven'],
            'cnt_id'           => $cnt_car_id,
            'insurance_expire' => $crmUsedCarData['insurance_type'] != 'no insurance' ? $crmUsedCarData['insurance_exp_year'] . '-' . $crmUsedCarData['insurance_exp_month'] . '-' . '1' : '0000-00-00',
            'module'           => 'seller',
        ]);
        $response       = ['cnt_id' => $cnt_car_id, 'error' => '', 'status' => !empty($cnt_car_id) ? 'T' : 'F'];

        $log_data = [
            'sync_module'   => 'stock',
            'stock_id'      => $cnt_car_id,
            'lead_id'       => '',
            'api_url'       => '',
            'source'        => 'dc',
            'dealer_id'     => $requestParams['dealer_id'],
            'reference_lead_id' => '',
            'reference_log_id'  => $requestParams['ref_log_id'],
            'request'           => json_encode($requestParams),
            'status'            => $response['status'],
            'response_time'     => date('Y-m-d H:i:s'),
            'added_by'          => $requestParams['dealer_id'],
            'sent_time'         => date('Y-m-d H:i:s'),
        ];
        $log_id = $this->Leadmodel->api_log($log_data);
        $response['ref_log_id'] = $log_id;

        $this->Leadmodel->api_log(['response' => json_encode($response)], $log_id);

        //}
        //echo base_url.'cron/dcToCrmImageSync';
        echo json_encode($response);
        die;
    }

    public function dcToCrmImageSync()
    {
        $requestParams = $this->input->post();

        $image_urls              = unserialize($requestParams['image_urls']);
        $imageData               = $requestParams;
        $imageData['image_urls'] = $image_urls;

        $image_array             = $this->createImageArray($imageData);
        $no_of_input_images      = count($image_urls);
        foreach ($image_array as $image) {
            $crm_image = $this->UsedCarImageMapper->getCrmUcImages($image['usedcar_id'], $image['image_name']);
            if (empty($crm_image)) {
                $this->db->insert(USED_CAR_IMAGE_MAPPER, $image);
                $last_id             = $this->db->insert_id();
                $inserted_id_array[] = $last_id;
            } else {
                $this->db->where('id', $crm_image[0]['id']);
                $this->db->update(USED_CAR_IMAGE_MAPPER, $image);
                $last_id             = $crm_image[0]['id'];
                $inserted_id_array[] = $last_id;
            }
        }

        $no_images_inserted = count($inserted_id_array);

        $response = ['cnt_id' => $requestParams['usedcar_id'], 'error' => '', 'message' => $no_images_inserted . ' img(s) inserted out of ' . $no_of_input_images, 'status' => ($no_of_input_images == $no_images_inserted) ? 'T' : 'F'];

        $log_data = [
            'sync_module'   => 'stock_image',
            'stock_id'      => $requestParams['usedcar_id'],
            'lead_id'       => '',
            'api_url'       => '',
            'source'        => 'dc',
            'dealer_id'     => $requestParams['dealer_id'],
            'reference_lead_id' => '',
            'reference_log_id'  => $requestParams['ref_log_id'],
            'request'           => json_encode($requestParams),
            'status'            => $response['status'],
            'response_time'     => date('Y-m-d H:i:s'),
            'added_by'          => $requestParams['dealer_id'],
            'sent_time'         => date('Y-m-d H:i:s'),
        ];
        $log_id = $this->Leadmodel->api_log($log_data);
        $response['ref_log_id'] = $log_id;

        $this->Leadmodel->api_log(['response' => json_encode($response)], $log_id);

        print(json_encode($response));
        die;
    }

    public function createImageArray($data = [])
    {
        $imageData = [];
        if (!empty($data['image_urls'])) {
            $i = 1;
            foreach ($data['image_urls'] as $key => $url) {
                $img_name = trim(end(explode('/', $url['image_url'])));
                $imageData[$img_name] = [
                    "image_name" => $img_name,
                    'created_on' => date("Y-m-d H:i:s"),
                    "source"     => 'dealerCentral',
                    'image_url'  => trim($url['image_url']),
                    //'image_url'  => 'https://images10.gaadicdn.com/usedcar_image/original/'.$img_name,
                    'status'     => trim($url['status']),
                    'usedcar_id' => trim($data['usedcar_id']),
                    'is_on_cdn'  => trim($url['is_on_cdn']),
                    'order'      => $i
                ];
                $i++;
            }
        }
        return $imageData;
    }

    function checkCityExist($str)
    {
        $this->db->select('city_id,state_id,city_name');
        $this->db->where('city_name', $str);
        $this->db->from('city_list');
        $query = $this->db->get();
        $result = $query->row_array();
        // print_r($result);
        if ($result) {
            return $result;
        } else {
            return false;
        }
        return false;
    }

    public function addRcCaseTransfer($apikey)
    {
        $requestParams = $this->input->post();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('customer_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('customer_email', 'Email', 'trim|required|valid_email|is_unique[crm_rc_info.customer_email]');
        $this->form_validation->set_rules('customer_mobile', 'Mobile', 'trim|required|numeric|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('aadhar_no', 'Adhaar Number', 'trim|required|min_length[12]|max_length[12]');

        $message = [];

        if (!empty($this->input->post('from_city')) || !empty($this->input->post('to_city'))) {
            if (empty($this->checkCityExist($this->input->post('from_city')))) {
                $message['from_city'] = 'From city does not exists';
            }
            if (empty($this->checkCityExist($this->input->post('to_city')))) {
                $message['to_city'] = 'From city does not exists';
            }

            $result = $this->checkCityExist($this->input->post('from_city'));
            $result2 = $this->checkCityExist($this->input->post('to_city'));
            if (empty($result) || empty($result2))
                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => $message
                ];
            echo json_encode($response);
        }

        if ($this->form_validation->run() == FALSE) {
            // $data = strip_tags($this->form_validation->error_string());
            $errors = $this->form_validation->error_array();
            $response = [
                'status' => 500,
                'error' => true,
                'message' => $errors
            ];
            echo json_encode($response);
        } else {
            $rcListing = [
                'customer_name'         => $requestParams['customer_name'],
                'customer_mobile'       => $requestParams['customer_mobile'],
                'customer_email'        => $requestParams['customer_email'],
                'reg_no'                => $requestParams['reg_no'],
                'status'                => '1',
                'rc_status'             => '1',
                'aadhar_no'             => $requestParams['aadhar_no'],
                'rto_type'              => $requestParams['rto_type'],
                'from_state'            => $requestParams['from_state'],
                'to_state'              => $requestParams['to_state'],
                'from_city'             => $result['city_id'],
                'to_city'               => $result2['city_id'],
                'generated_date'        => $requestParams['generated_date'],
            ];

            $results = $this->Crm_rc->setRcTransferDetail($rcListing);

            $files = $_FILES;
            $config['upload_path']      = 'upload_rc_doc/';
            $config['allowed_types']    = ['gif', 'png', 'jpg', 'jpeg', 'pdf', 'tif'];
            $config['max_size']         = '8000';
            $config['max_width']        = '7000';
            $config['max_height']       = '7000';
            $config['encrypt_name']     = True;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            foreach ($files as $key => $image) {
                // $fileName = key($image['name']);
                if (!$this->upload->do_upload($key)) {
                    $error = array('Invalid Request!');
                    $result = array('error' => $error, 'status' => 400);
                    echo json_encode($result);
                } else {
                    $datas = $this->upload->data();
                    $data['doc_name'] = $datas['file_name'];
                    $data['doc_url'] = 'upload_rc_doc/' . $datas['file_name'];
                    $data['customer_id'] = $results['customer_id'];
                    $data['case_id'] = $results['case'];
                    $data['doc_type'] = '4';
                    if (!empty($ar['2'])) {
                        $data['doc_type'] = '5';
                    }
                    $result = $this->Crm_upload_docs_list->insertLoginDocs($data);
                    // echo trim($result);
                }
            }

            if ($result)
                $response = array('status' => 'True', 'case_id' => $results['case'], 'message' => 'Rc details added Successfully');
            echo json_encode($response);
            exit;
        }
    }
}
