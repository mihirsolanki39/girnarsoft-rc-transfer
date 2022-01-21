<?php

class StockSync extends MY_Controller
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

    public function dcToCrmStockSync($filter_data=[])
    {
        $car_id=!empty($filter_data['car_id'])?$filter_data['car_id']:0;
        $cntUcData = $this->Cnt_used_car->getCntUsedCarData($car_id);

        //echo 'asdfsd';die;


        $response = [];
        foreach ($cntUcData as $cntData)
        {
            $crmUsedCarData = $this->Cnt_used_car->DcToCrmMapping($cntData);

            //update
            $crm_used_car = $this->db->query('select * from crm_used_car where id=' . $cntData['id'])->result_array();
            //print_r($crm_used_car);die;
            if (!empty($crm_used_car))
            {
                $cnt_car_id = $this->crm_stocks->save_crm_used_car($crmUsedCarData, $cntData['id']);
                $otherData  = $this->db->query('select * from crm_used_car_other_fields where cnt_id=' . $cntData['id'])->row_array();
                $case_id    = $otherData['case_id'];
                
                $usedcarother=[];
                $usedcarother['tradetype']      = '2';
                $usedcarother['hypo']           = '2';
                $usedcarother['insurance_date'] = $crmUsedCarData['insurance_type'] != 'no insurance' ? $crmUsedCarData['insurance_exp_year'] . '-' . $crmUsedCarData['insurance_exp_month'] . '-' . '1' : '0000-00-00';
                $this->db->where('case_id', $case_id);
                $this->db->update('crm_used_car_other_fields', $usedcarother);
            }
            //insert
            else
            {
                $cnt_car_id = $this->crm_stocks->save_crm_used_car($crmUsedCarData);
                //'tradetype' => '2',
                $case_id    = $this->crm_stocks->addCrmUsedcarPurchaseCaseinfo(['created_date' => date('Y-m-d H:i:s'), 'updated_date' => date('Y-m-d H:i:s')]);

                $usedcarother=[];
                $usedcarother['cnt_id']         = $cnt_car_id;
                $usedcarother['case_id']        = $case_id;
                $usedcarother['tradetype']      = '2';
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
            $response[]       = ['cnt_id' => $cnt_car_id, 'case_id' => $case_id, 'central_stock_id' => $central_stock_id];
        }
        //echo base_url.'cron/dcToCrmImageSync';
        print(json_encode($response));
        die;
    }

    public function dcToCrmImageSync()
    {
        $imageData = $this->Cnt_used_car->getCntUsedImages();
        //print_r($imageData);
       // die;
        //echo 'asdfsd';die;

        $response=[];
        foreach ($imageData as $image)
        {
            $crm_image = $this->UsedCarImageMapper->getCrmUcImages($image['usedcar_id'], $image['image_name']);
            if (empty($crm_image))
            {
                $this->db->insert(USED_CAR_IMAGE_MAPPER, $image);
                $last_id=$this->db->insert_id();
                $response[]=['image_id'=>$last_id];
            }
        }
        print(json_encode($response));
        die;
    }

}
