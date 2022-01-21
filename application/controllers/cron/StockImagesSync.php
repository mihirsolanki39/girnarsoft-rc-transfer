<?php

class StockImagesSync extends MY_Controller
{

    public function index()
    {
        
    }

    public function __construct()
    {
        parent::__construct();
        $this->dateTime               = date("Y-m-d H:i:s");
        $this->load->model('Crm_used_car_sale_case_info');
        $this->load->model('crm_stocks');
        $this->load->model('Cnt_used_car');
        $this->load->model('UsedCarImageMapper');
        $this->load->helper('curl_helper');
    }

    public function sync()
    {
        $car_ids = $this->UsedCarImageMapper->getImagesToSyncWithDC();
        
        
        $i=0;
        $c=0;
        foreach ($car_ids as $car)
        {
            $images = $this->UsedCarImageMapper->getCrmUcImages($car['car_id'],'',1);
            foreach($images as $image){
              $image_data[]=['image_url'=>AWS_PATH.$image['image_url'],'status'=>$image['status']];
            }
            $request_data=['car_id'=>$car['car_id'],'image_urls'=> serialize($image_data)];
            $response=$this->pushImagesToDC($request_data);
            echo "<pre>";
            print_r($response);
            if($response['status'] == 'T'){
               
                $this->db->where('car_id', $car['car_id']);
                $this->db->update('crm_to_dc_image_sync', [
                    'is_syncd'     => '1',
                    'data_to_sync' => json_encode($request_data),
                    'response' => json_encode($response),
                    'updated_date' => date('Y-m-d H:i:s'),
                ]);
             $c++;
            }
        }
        
        print($c.' cars have been syncd with DC'.PHP_EOL.' verify in crm_to_dc_image_sync table');
        die;
    }
    
    public function pushImagesToDC($data)
    {
        
        $request_data                   = array();
        $request_data['apikey']         = 'DEALERHrlnGed0dCRMAShyUJ54NEQ';
        $request_data['method']         = 'pushusedcarimages';
        $request_data['dealer_id']      =  DEALER_ID;
        $request_data['crmID']          = $data['car_id']; 
        $request_data['image_urls']     = $data['image_urls']; 
        echo "<pre>";
        print_r($request_data);
       
        
        
          $url                    = API_URL.'api/centralapi/CentralAdminApi.php';

           /*
             * LOG THE API REQUEST
             */
            $log_data=[
                'sync_module'   => 'stock',
                'lead_id'       => '',
                'api_url'       => $url,
                'source'        => 'crm',
                'dealer_id'     => DEALER_ID,
                //'request'       => json_encode($data_to_sync),
                //'added_by'      => $this->session->userdata['userinfo']['id'],
                'sent_time'     => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('crm_dc_sync_log',$log_data);
            $log_id=$this->db->insert_id();
          
          
            $ch       = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_POST, count($request_data));
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request_data));
            $response = curl_exec($ch);
            curl_close($ch);
            
            $result= json_decode($response,true);
            
            /*
             * LOG THE API RESPONSE
             */
            $this->db->where('id', $log_id);
            $this->db->update('crm_dc_sync_log',[
                'reference_lead_id' => 0,
                'stock_id' => $result['carid'],
                'reference_log_id'  => $result['log_id'],
                'request'           => json_encode($request_data),
                'response'          => $response,
                'status'            => strtoupper($result['status']) == 'T' ? 'T' : 'F',
                'response_time'     => date('Y-m-d H:i:s'),
            ]);
            
            
         //$this->db->insert('crm_to_dc_sync', $data_array);
         return $result;
    }
    

}
