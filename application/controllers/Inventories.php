<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Inventories extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('City');
        $this->load->model('State');
        $this->load->model('UserDashboard');
        $this->load->model('Showroom');
        $this->load->model('UsedCarImageMapper');
        $this->load->model('Make_model');
        $this->load->model('Crm_user');
        $this->load->model('Crm_stocks');
        $this->load->library('form_validation');
        $this->load->model('Crm_banks');
        $this->load->model('Crm_upload_docs_list');
        error_reporting(0) ;
    }

    public function index()
    {
        $this->loadViews('inventory/usedcar_listing');
    }

    public function add_inventories($mixed_id='')
    {
        $arr = [];
        $car_id ='';
        $arr['pageTitle'] = 'Add Inventory';
       if($mixed_id!=''){
        $car_ids = base64_decode($mixed_id);
        $car_ids = explode('_', $car_ids);
        $car_id = $car_ids[1];
        $arr['pageTitle'] = 'Edit Inventory';
        }
        $monthName = '';
        
        $regCityList           = $this->UserDashboard->getRegCityListArr();
        $getColors             = $this->UserDashboard->getColors();
        $certifiedcarlists     = $this->UserDashboard->getCertifiedList();
        $selectshowrooms       = $this->Showroom->getList('1');
        $exterior              = $this->UserDashboard->getDumpTable('usedcar_exterior');
        $interior              = $this->UserDashboard->getDumpTable('usedcar_interior');
        $bodyframe             = $this->UserDashboard->getDumpTable('usedcar_bodyframe');
        $conditionsdata        = $this->UserDashboard->getDumpTable('usedcar_overallcondition');
        $etc                   = $this->UserDashboard->getDumpTable('usedcar_etc');
        $usedcar_susste        = $this->UserDashboard->getDumpTable('usedcar_susste');
        $usedcar_acheater      = $this->UserDashboard->getDumpTable('usedcar_acheater');
        $usedcar_breaks        = $this->UserDashboard->getDumpTable('usedcar_breaks');
        $usedcar_tires         = $this->UserDashboard->getDumpTable('usedcar_tires');
        $usedcar_battery       = $this->UserDashboard->getDumpTable('usedcar_battery');
        $usedcar_electrical    = $this->UserDashboard->getDumpTable('usedcar_electrical');

        $colArr                 = array();
        foreach($getColors as $c=>$cols)
        {
             $colArr[] = $cols['name'];
        }
         $city                   = '';
        foreach($selectshowrooms as $key=>$val)
        {
            $city=$val['city'];
            break;
        }

        if(trim($car_id) == ''){
            $car_id = 0;
        }
        if(isset($_SESSION['used_car_image_mapper']) && count($_SESSION['used_car_image_mapper']) > 0){
            foreach($_SESSION['used_car_image_mapper'] as $key => $val){
                unlink($val['uplaoded_path'].$val['uplaoded_file']);
            }
            unset($_SESSION['used_car_image_mapper']);
            $_SESSION['used_car_image_mapper'] = array();
        } else {
            $_SESSION['used_car_image_mapper'] = array();
        }

        $carDeatil          = array();
        $imageMapArray      = array();
        $makeListArr        = array();
        $modelListArr       = array();
        $versionListArr     = array();
        $getZoneDetail      = array();
        $area_of_cover      = '';
        $inventory_docs     = array();

         if(intval($car_id) > 0){
            $dealer_id      = DEALER_ID; 
            $carDeatil      = $this->UserDashboard->getStockDetailsByCarId($car_id,$dealer_id);

            $checkmsg = '';
            if($carDeatil['is_gaadi']=='1')
            {
                $arr['checkmsg'] = '1'; 
            }
            $carDeatil['month'] = $carDeatil['reg_month'];
            if($carDeatil['insurance_type']!='')
            {
                $carDeatil['insurance'] = $carDeatil['insurance_type'];
            }
            $carDeatil['year'] = $carDeatil['insurance_exp_year'];
            $carDeatil['tax'] = ucfirst($carDeatil['tax_type']);
            $makeModelVersion       = $this->Make_model->getMakeModelVersionByCarId($carDeatil['version_id']);
            $carDeatil['make_id']   = $makeModelVersion[0]['make_id'];
            $carDeatil['make']      = $makeModelVersion[0]['make'];
            $carDeatil['model_id']  = $makeModelVersion[0]['model_id'];

            $monthName = date("M", mktime(0, 0, 0, $carDeatil['insurance_exp_month'], 10)); 
            
            $where          = " WHERE 1=1 ";
            $fields         = "id,make";
            $makeListArr    = $this->UserDashboard->getCarMakeList('used',$fields,$where);

            $where          = " WHERE make='".$makeModelVersion[0]['make']."'";
            $fields         = "id,make_id,make,model";
            $modelListArr   = $this->UserDashboard->getCarModelList('used',$fields,'model',$where);

            $make           = trim($carDeatil['make_id']);
            $model          = trim($carDeatil['model_id']);
            $fields         = "db_version_id,db_version,uc_fuel_type,Displacement";
            $sqlJoin        = " ";
            $where          = $sqlJoin." WHERE model_version.mk_id = '".$make."' AND model_version.model_id = '".$model."' ";
            $orderBy    = "uc_fuel_type";
            $versionListArr  = $this->UserDashboard->getCarVersionList($make,'used',$fields,$orderBy,$where);
            $versionListArrTemp = $versionListArr;
            $versionListArr = array();
            foreach($versionListArrTemp as $key => $value){
                $versionListArr[$value['uc_fuel_type']]['uc_fuel_type'] = $value['uc_fuel_type'];
                $versionListArr[$value['uc_fuel_type']]['key'] = $key;
                $versionListArr[$value['uc_fuel_type']]['data'][] = $value;
            }

            $imageMapArray  = $this->UsedCarImageMapper->getAllImagesByCarId($car_id);

            foreach($selectshowrooms as $key=>$val)
            {
                if($carDeatil['showroom_id'] == $val['id']){
                    $city                   = $val['city'];
                    $showroomId             = $carDeatil['showroom_id'];
                    $defaultShowrromName    = $val['outlet_address'];
                }
            }

            $getZoneDetail                  = $this->UserDashboard->getZoneDetail($carDeatil['locality_names']);

            $inventory_docs =  $this->UserDashboard->getDocInfo($car_id);
            
        }

        $arr['car_id']=$car_id;
        $arr['inventory_docs']=$inventory_docs;
        $arr['carDeatil'] = $carDeatil;
        $arr['imageMapArray'] = $imageMapArray;
        $arr['makeListArr'] = $makeListArr;
        $arr['modelListArr'] = $modelListArr;
        $arr['versionListArr'] = $versionListArr;
        $arr['area_of_cover'] = $area_of_cover;
        $arr['showroomId'] = $selectshowrooms[0]['id'];
        $arr['defaultShowrromName'] = $selectshowrooms[0]['outlet_address'];
        $arr['getZoneDetail'] = $getZoneDetail;
        $arr['monthInsuraanceText'] = $monthName; 
        $arr['colArr'] = $colArr;
        $arr['regCityList'] = $regCityList;
        $arr['certifiedcarlists'] = $certifiedcarlists;
        $arr['selectshowrooms'] = $selectshowrooms;
        $arr['exterior'] = $exterior;
        $arr['interior'] = $interior;
        $arr['bodyframe'] = $bodyframe;
        $arr['conditionsdata'] = $conditionsdata;
        $arr['etc'] = $etc;
        $arr['usedcar_susste'] = $usedcar_susste;
        $arr['usedcar_acheater'] = $usedcar_acheater;
        $arr['usedcar_breaks'] = $usedcar_breaks;
        $arr['usedcar_tires'] = $usedcar_tires;
        $arr['usedcar_battery'] = $usedcar_battery;
        $arr['usedcar_electrical'] = $usedcar_electrical;
        $arr['city'] = $city;
       // echo "<pre>";
        //print_r($arr);
       // exit;
        $this->loadViews('inventory/add_inventories',$arr);
    }

    public function upload_images()
    {
        $data['getImageinedit'] = '0';
        $data['selectedData'] = '';

        $this->load->view('inventory/upload_images',$data);
    }

    public function getmakemodelversionlist()
    {
        //error_reporting(E_ALL);
        $makeExistArr       = array('0'=>'Maruti','1'=>'Hyundai','2'=>'Honda','3'=>'Chevrolet');
        $types              = trim($this->input->post('type'));
        $year               = trim($this->input->post('year'));
        $launchDate         = trim($this->input->post('year'))."-01"."-01";
        
      if (isset($types) && ($types == 'model')) {
            //$make           = trim($this->input->post('make'));
            $where          = "";
            
            $fields         = "id,make_id,make,model";
            $modelListArr   =  $this->UserDashboard->getMakeModelList();
            header("Content-type: application/json");
            //print_r($modelListArr);die;
            echo json_encode($modelListArr);
            exit();    
        }
        
        if (isset($types) && ($types == 'version')) {
           // $make       = trim($this->input->post('mk_id'));
            //$makeText   = trim($this->input->post('make'));
            $model      = trim($this->input->post('model_id'));
            $sellcar    = trim($this->input->post('sellcar'));
            $fields     = "db_version_id,db_version,uc_fuel_type,Displacement";
            $sqlJoin    = " ";
            $where      = $sqlJoin." WHERE model_version.model_id = '".$model."' ";
            $orderBy    = "uc_fuel_type";
            $versionListArr =array();
            $versionListArr  = $this->UserDashboard->getCarVersionList($model,'all',$fields,$orderBy,$where);
            echo json_encode($versionListArr);
            exit();    
        }
        if (isset($types) && ($types == 'fuel')) {
            $fuel_type    = trim($this->input->post('fuel_type'));
            $getFuelTypeForVersion  = $this->UserDashboard->getFuelTypeForVersion($fuel_type);
            echo json_encode($getFuelTypeForVersion);
            exit();
        }
        if (isset($types) && ($types == 'PrefillData')) {
            $getFuelType            =   array();
            //$make                   =   trim($this->input->post('make'));
            $model                  =   trim($this->input->post('model'));
            $version                =   trim($this->input->post('version'));
            $car_id                 =   trim($this->input->post('car_id'));
           
            $getFuelType['fuelTrans']   =    $this->UserDashboard->getfuelTrans($model,$version);
            if(intval($car_id) > 0)
            $getFuelType['features']    =    $this->UserDashboard->getFeatures($car_id);
            else 
            $getFuelType['features']    =   array();
            $getColors                  =    $this->UserDashboard->getColorVariant($model,$version);
                                    
            if(empty($getColors))
            {
                $getColors=  $this->UserDashboard->getColors();
            }   
            foreach($getColors as $c=>$cols)
            {
                 $colArr[] = $cols['name'];
            }
            
            $getFuelType['colors'] = $colArr;
            echo json_encode($getFuelType);
            exit();    
        }
        exit;
    }

    public function zones_inventory(){
        $datapost   =   $this->input->post();
        $zoneId     =   '';
        //print_r($this->input->get()); exit;
        if($this->input->get('type')=='aads')
        {

            $_SESSION['lcidzones']=$this->input->get('cid');
            exit;
        }


        $selectcities       = $this->UserDashboard->getLocalitiesFromCity($this->input->get());

        if (!empty($selectcities) )
        {
            foreach($selectcities as $key=>$val)
            {
                $data[] = array(
                    'name' => trim($val['localityname']),
                    'value' => trim($val['id']),
                    'image' =>  'acl.jpg'
                );
            }
        }

        header("Content-type: application/json");
        echo json_encode($data);
        exit();
    }


   /* public function getOnRoadPrice(){
        $request            = $this->input->post();
        //$dashboardObj       = new UserDashboard();
        $version            = $this->UserDashboard->getVersionByName(['version_name' => $request['version']]);
        $regPlaceCity       = $this->UserDashboard->getCityById(['city_id' => $request['reg_city_id']]);
        echo "<pre>"; print_r($version); print_r($regPlaceCity);
        //$orpResponse        = $dashboardObj->getOnRoadPrice($regPlaceCity[0]['city_name'], $version['db_version_id']);
        echo json_encode($orpResponse);
        exit;
    }*/


    public function upload_inventory_docs(){
        header('Content-Type: application/json');
       
        $config['upload_path']   = UPLOAD_IMAGE_PATH.'uploaddoc/';
        $config['allowed_types'] = ['gif', 'png', 'jpg','jpeg'];
        $config['max_size']      = '8000';
        $config['max_width']     = '5000';
        $config['max_height']    = '5000';
        $config['min_width']     = '300';
        $config['min_height']    = '200';
        $config['encrypt_name']    = True;

       //$this->load->library('upload');
        $this->load->library('upload', $config);

        // $abc = $this->upload->do_upload('file');
         //print_r($abc);
                if($this->upload->do_upload('file'))
                {
                    $data = $this->upload->data();
                    //print_r($data); exit;
                    $success['message'] = "<span>Image uploaded successfully</span>";
                    $success['url'] = HOST_ROOT_STOCK . $data['file_name'];
                    $success['image_name'] =$data['file_name'];
                    $success['success'] = '1';
                    echo json_encode($success);
                }
                else
                {
                            $success['message'] = str_replace('_',' ', $this->upload->display_errors());
                            $success['url'] ='';
                            $success['image_name'] ='';
                            $success['success'] = '0';
                            echo json_encode($success);
                }
                //echo "dwdwe";
            exit;
    }

    public function upload_new_image(){
        $file_name_key              = key($_FILES);
        $config['upload_path']      = UPLOAD_IMAGE_PATH.'uploadcar/original/';
        $config['allowed_types']    = ['gif', 'png', 'jpg','jpeg'];
        $config['max_size']         = '8000';
        $config['max_width']        = '5000';
        $config['max_height']       = '5000';
        $config['min_width']        = '300';
        $config['min_height']       = '200';
        $config['encrypt_name']     = True;

        $this->load->library('upload', $config);
        if($this->upload->do_upload($file_name_key))
        {
            $data = $this->upload->data();
            $_SESSION['used_car_image_mapper'][$_FILES[$file_name_key]['name']] = $data;
            echo "<pre>"; print_r($_SESSION['used_car_image_mapper']); //die();
        }
        else
        {
            //$error = array('error' => $this->upload->display_errors());
            $error  = array('Invalid Request!');
            print_r($error);die;
            $result = array('error' => $error, 'status' => 400);
        }
        exit;
    }

    public function ajax_image_delete($imageId = '')
    {
       if($imageId=='')
       {
           $imageId = $this->input->post('image_id');
       }
        if($imageId == ''){
           unset($_SESSION['used_car_image_mapper'][$_REQUEST['name']]);
       } else {
           $image_name         = $this->UserDashboard->updateImgStatus($imageId);
            $Path = UPLOAD_IMAGE_PATH.'uploadcar/'.$image_name[0]['image_name'];
            chmod($Path, 777);

            if(file_exists($Path))
            {
                if (unlink($Path)) {   
                   $updateImgStatus         = $this->UserDashboard->updateImgStatus($imageId);
                   $err['success'] = "True";

                } else {  
                    $err['success'] = "False";
                    $err['msg'] = "Fail to remove image";
                }   
            } else {
                
                $err['success'] = "False";
                $err['msg'] = "Image doesnot exists";
            }
          
       }
       echo json_encode($err); exit;
    }
    public function mapCrmToCentralData($data,$car_id)
    {
        $centralStockData = Array
            (
            'make_id'          => $data['mk_id'],
            'model_id'         => $data['model_id'],
            'version_id'       => $data['version_id'],
            'reg_no'           => $data['reg'],
            'engine_no'        => $data['engineno'],
            'chassis_no'       => $data['chassisno'],
            'insurance_expire' => date('Y-m-d', strtotime($data['insdate'])),
            'cnt_id'           => $car_id,
            'mm'   => $data['month'],
            'myear'   => $data['year'],
        );
        return $centralStockData;
    }

    public function inventory_add(){
        
        
        $data               = $this->input->post();
        //echo "<pre>";print_r($data);die;
        $dealer_id          = DEALER_ID;      
        $checkInventiryExists = true;
        $car_id             = '';
        if ($checkInventiryExists)
        {
            $car_id         = $this->UserDashboard->manageInventory($data,$dealer_id);
            
            
            $res = json_decode($car_id);
            //echo  $res->carid; exit;
           //print_r($res);die;
            if($res->status=='1')
            {
                $data['car_id'] = $res->carid;
                $centralStockData=$this->mapCrmToCentralData($data,$res->carid);
                $this->crmCentralStockData($centralStockData,'Stock');
                $result= array('status'=>'True','message'=>'Inventory Added Successfully','Action'=>  base_url().'uploadcardocs/' . base64_encode(DEALER_ID.'_'. $data['caseid']));
                echo json_encode($result);exit;

            }
            else
            {
                $err = json_decode($res->error);
                $impErr = implode(', ',$err->error);
                $result= array('status'=>'False','message'=>$res->error);
                echo json_encode($result);exit;
            }
            /*if(count($_SESSION['used_car_image_mapper']) > 0 && isset($_SESSION['used_car_image_mapper'])){
                $this->UserDashboard->manageCarImages($_SESSION['used_car_image_mapper'],$car_id);
            }*/
        }
       exit;
    }

    public function getOnRoadPrice()
    {
        
        $request        = $this->input->post();
        $version        = $this->UserDashboard->getVersionByName(['version_name' => $request['version']]);
        $regPlaceCity   = $this->UserDashboard->getCityById(['city_id' => $request['reg_city_id']]);
        $orpResponse    = $this->UserDashboard->getOnRoadPrice($regPlaceCity[0]['city_name'], $version['db_version_id']);
        //print_r($orpResponse);die;
        $this->load->helper('range_helper');
        $orpResponse['data']['price']=indian_currency_form($orpResponse['data']['OnRoadprice']) ;
        echo json_encode($orpResponse); exit;
    }

    public function checkDuplicateEntry()
    {
        $request        = $this->input->post();
       // echo "<pre>";
        //print_r($request);
        $car_id = '';
        if($request['car_id']>0)
        {
            $car_id=$request['car_id'];
        }
        $result        = $this->UserDashboard->checkDuplicateEntry($request['version'],$request['km'],$request['car_price'],$car_id);
        echo  $result; exit;
    }

    public function saveCentralStock($data)
    {

                $centralStock                            = [];
                $centralStock['loan_for']         = '2';
                $centralStock['mm']         = !empty($data['month'])?$data['month']:'';
                $centralStock['km']         = !empty($data['realkm'])?$data['realkm']:'';
                $centralStock['myear']         = !empty($data['year'])?$data['year']:'';
                $centralStock['make_id']         = !empty($data['mk_id'])?$data['mk_id']:'';
                $centralStock['model_id']        = !empty($data['model_id'])?$data['model_id']:'';
                $centralStock['version_id']      = !empty($data['version_id'])?$data['version_id']:'';
                $centralStock['cnt_id']    = !empty($data['car_id'])?$data['car_id']:'';
                $centralStock['reg_no']          = !empty($data['reg'])?strtoupper($data['reg']):'';
                $centralStock['engine_no']  = !empty($data['engineno'])?strtoupper($data['engineno']):'';
                $centralStock['chassis_no'] = !empty($data['chassisno'])?strtoupper($data['chassisno']):'';
                $centralStock['insurance_expire']    = !empty($data['insdate'])?date('Y-m-d',strtotime($data['insdate'])):'';
                //$centralStock['buyer_id']  = !empty($data['buyer_id'])?strtoupper($data['buyer_id']):'';
                //$centralStock['seller_id']  = !empty($data['seller_id'])?strtoupper($data['seller_id']):'';
                $this->crmCentralStockData($centralStock,'Stock');
               // return true;
    }

/*-------------------New Used Car Code -------------------------------------*/
    public function getCompetitiveInventory()
    {
        $data         = [
            'apikey'     => 'U3KqyrewdMuCotTS',
            'method'     => 'getCompetitiveInventory',
            'version_id' => $_GET['version_id'],
            'model_id'   => $_GET['model_id'],

           // 'fuel_type'  => $_GET['fueltypein'],
           // 'city_id'    => 125,

            'fuel_type'  => $_GET['fuel'],
            'city_id'    => $_GET['regcity'],
            'km'         => $_GET['realkm'],
            'make_year'  => $_GET['year'],
            'dealer_id'  => DEALER_ID
        ];
        $url          = API_URL."api/ins/v1/getup";

        $ch           = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response     = curl_exec($ch);
        $responseData = json_decode($response,1);
        curl_close($ch);
        //print_r($responseData);die;
        $make_model_name=!empty($responseData['data'])?$responseData['data'][0]['make'].' '.$responseData['data'][0]['model']:'';
        $this->load->view('inventory/market_price',['similar_cars'=>$responseData,'make_model_name'=>$make_model_name]);
    }

  

  
    
}
