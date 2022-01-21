<?php

require APPPATH . '/libraries/BaseController.php';
//require_once(APPPATH.'/libraries/BuyLead.php');
class Stock extends BaseController {

    public function __construct() {
        parent::__construct();
         error_reporting(0);
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->helper('url_helper');
        $this->load->model('crm_stocks');
        $this->load->model('Make_model');
        $this->load->helper('curl');
        $this->load->helper('date');
        $this->load->helper('range_helper');
        $this->load->model('Crm_used_car');  
        $this->load->model('UsedCarImageMapper');    
        $this->load->model('UserDashboard'); 
        $this->load->model('Leadmodel');
        $this->load->model('Crm_used_car_sale_case_info');
        $this->load->model('Crm_used_car_sale_payment');
        $this->load->model('Crm_refurb_workshop');
        $this->load->model('Crm_user');
        $this->load->helpers('range_helper');
        //$this->load->library('BuyLead');
	if(!$this->session->userdata['userinfo']['id']){
             return redirect('login');
            }
    }

    public function index() {
        
    }

    public function inventoryListing($invId='') {
        $data = [];
        $dealerId = DEALER_ID;
        $activeStatus = '1';
        $allStatus = ['1','2'];
        $carRemoveStatus = ['2','3'];
        $searchText = '';
        $data['maxPriceArr'] = array('0' => 'Min', '50000' => '50,000', '100000' => '1 Lakh', '200000' => '2 Lakh', '300000' => '3 Lakh', '400000' => '4 Lakh', '500000' => '5 Lakh', '600000' => '6 Lakh', '700000' => '7 Lakh', '800000' => '8 Lakh', '900000' => '9 Lakh', '1000000' => '10 Lakh', '350000' => '3.5 Lakh', '375000' => '3.75 Lakh', '400000' => '4 Lakh', '425000' => '4.25 Lakh', '450000' => '4.5 Lakh', '475000' => '4.75 Lakh', '500000' => '5 Lakh', '550000' => '5.5 Lakh', '600000' => '6 Lakh', '650000' => '6.5 Lakh', '700000' => '7 Lakh', '750000' => '7.5 Lakh', '800000' => '8 Lakh', '850000' => '8.5 Lakh', '900000' => '9 Lakh', '950000' => '9.5 Lakh', '1000000' => '10 Lakh', '1100000' => '11 Lakh', '1200000' => '12 Lakh', '1300000' => '13 Lakh', '1400000' => '14 Lakh', '1500000' => '15 Lakh', '1600000' => '16 Lakh', '1700000' => '17 Lakh', '1800000' => '18 Lakh', '1900000' => '19 Lakh', '2000000' => '20 Lakh', '2500000' => '25 Lakh', '3000000' => '30 Lakh', '4000000' => '40 Lakh', '5000000' => '50 Lakh', '7500000' => '75 Lakh', '10000000' => '1 Crore', '30000000' => '3 Crore');
        $data['make'] = $this->Make_model->getCarMakeList();
        $data['invId']        = (!empty($invId)) ? $invId:'';

        $data['activeStock'] = count($this->crm_stocks->getInventoryListing($dealerId, $activeStatus, $searchText, true));
        $data['totStock'] = count($this->crm_stocks->getInventoryListing($dealerId, $allStatus, $searchText, true));
        $data['totRemoveStock'] = count($this->crm_stocks->getInventoryListing($dealerId, $carRemoveStatus, $searchText, true));
        $this->global['pageTitle'] = 'Inventory Listing';
        $this->loadViews("stock/inventoryList", $this->global, $data, NULL);
    }

    public function getStockList() {
        $dealerId = DEALER_ID;
        $allStatus = '1';
        $data=array();
        //$allStatus = ['0','1','2','3','4','5'];
        $searchText = [];
        $postData = $this->input->post();
        $page = $postData['page'];
        if ($page > 0) {
            $rpp = 5;
            $start = ($page - 1) * $rpp;
            //$limitStr = " LIMIT $start , $rpp";
        } else {
            $page = 1;
            $rpp = 5;
            $start = ($page - 1) * $rpp;
        }
        if ($this->input->post('key') == 'search') {
            $searchText=$this->input->post();
            if (!empty($this->input->post('model'))) {
                $modelVal = $this->Make_model->getAllModelListAll($this->input->post('model'));
                $searchText['model'] = $modelVal;
            }
            if($searchText['tab_value']==''){
              $searchText['tab_value']='';
              $allStatus=[];
            }
            if($searchText['tab_value']=='removed'){
                $searchText['tab_value']='removed';
                $allStatus=[];
            }
            if($searchText['tab_value']=='all'){
                $searchText['tab_value']='all';
                $allStatus=[];
            }
            if($searchText['tab_value']=='sold'){
                $searchText['tab_value']='sold';
                $allStatus=[];
            }
            if($searchText['tab_value']=='refurb'){
                $searchText['tab_value']='refurb';
                $allStatus=[];
            }
            if($searchText['tab_value']=='booked'){
                $searchText['tab_value']='booked';
                $allStatus=[];
            }
        }
        $data['page'] = $page;
        $data['totStock'] = count($this->crm_stocks->getInventoryListing($dealerId, $allStatus, $searchText, true));
        $stockListing = $this->crm_stocks->getInventoryListing($dealerId, $allStatus, $searchText, false, $start, $rpp);
        $data['stockData'] = $this->getstockListing($stockListing);
        $data['searchData']=$searchText;
       /* echo "<pre>";
        print_r($data);
        exit;*/
        $this->load->view('stock/inventory_ajax', $data);
    }
    
    public function getStockCount(){
        $data=[];
        $dealerId = DEALER_ID;
        $searchText=[];
        $totsearchText=[];
        $totremovesearchText=[];
        $totactivesearchText=[];
        $activeStatus = '1';
        $allStatus = ['0','1','2','3','4','6'];
        $carRemoveStatus = ['0','2'];
        $carSoldStatus = ['3'];
        $refurbStatus = ['6'];
        $bookedStatus = ['4'];
        if ($this->input->post('key') == 'search') {
            $searchText=$this->input->post();
            if (!empty($this->input->post('model'))) {
                $modelVal = $this->Make_model->getAllModelListAll($this->input->post('model'));
                $searchText['model'] = $modelVal;
            }
            //print_r($searchText);
            if($searchText['tab_value']==''){
              $totactivesearchText=$searchText;
              $totactivesearchText['tab_value']='';
              $activeStatus=[];
            }else{
                $totactivesearchText=$searchText;
                $totactivesearchText['tab_value']='';
            }
            
            if($searchText['tab_value']=='removed'){
                $totremovesearchText=$searchText;
                $totremovesearchText['tab_value']='removed';
                $carRemoveStatus=[];
            }else{
                $totremovesearchText=$searchText;
                $totremovesearchText['tab_value']='removed';
                $carRemoveStatus=[];
            }
            if($searchText['tab_value']=='all'){
                $totsearchText=$searchText;
                $totsearchText['tab_value']='all';
                $allStatus=[];
            }else{
                $totsearchText=$searchText;
                $totsearchText['tab_value']='all';
                $allStatus=[];
            }
            if($searchText['tab_value']=='refurb'){
                $totRefsearchText=$searchText;
                $totRefsearchText['tab_value']='refurb';
                $refurbStatus=[];
            }else{
                $totRefsearchText=$searchText;
                $totRefsearchText['tab_value']='refurb';
                $refurbStatus=[];
            }
            if($searchText['tab_value']=='sold'){
                $totSoldsearchText=$searchText;
                $totSoldsearchText['tab_value']='sold';
                $carSoldStatus=[];
            }else{
                $totSoldsearchText=$searchText;
                $totSoldsearchText['tab_value']='sold';
                $carSoldStatus=[];
            }
            if($searchText['tab_value']=='booked'){
                $totBookedsearchText=$searchText;
                $totBookedsearchText['tab_value']='booked';
                $bookedStatus=[];
            }else{
                $totBookedsearchText=$searchText;
                $totBookedsearchText['tab_value']='booked';
                $bookedStatus=[];
            }
        }
        //print_r($allStatus);die;
        $data['totStock'] = count($this->crm_stocks->getInventoryListing($dealerId, $allStatus, $totsearchText, true));
        $data['totSoldStock'] = count($this->crm_stocks->getInventoryListing($dealerId, $carSoldStatus, $totSoldsearchText, true));
        $data['totRemoveStock'] = count($this->crm_stocks->getInventoryListing($dealerId, $carRemoveStatus, $totremovesearchText, true));
        $data['activeStock'] = count($this->crm_stocks->getInventoryListing($dealerId, $activeStatus, $totactivesearchText, true));
        $data['refurbStock'] = count($this->crm_stocks->getInventoryListing($dealerId, $refurbStatus, $totRefsearchText, true));
        $data['bookedStock'] = count($this->crm_stocks->getInventoryListing($dealerId, $bookedStatus, $totBookedsearchText, true));
        echo json_encode($data);
    }

    public function getstockListing($stockData) {
        $this->load->helper('range_helper');
        //echo '<pre>';print_r($stockData);die;
        if (!empty($stockData) && is_array($stockData)) {
            //$dealer_id = $_SESSION['ses_dealer_id'];
            $dealer_id = DEALER_ID;
            $i = 0;
            $data=[];
            $certified_status_array = ['Not Inspected', 'Certified', 'In Process', 'Dealer Request', 'Refurbishment', 'In Process', 'Rejected', 'Expired', 'UnAvailable'];
            foreach ($stockData as $k => $v) {
                
                
                $data[$i]['id'] = $v['id'];
                $car_id = trim($v['id']);
                $data[$i]['Is_RSA'] = 0;
                $model = ($v['ParentModel']) ? $v['ParentModel'] : $v['model'];
                $data[$i]['gaadi_id'] = $v['gaadi_id'];
                $data[$i]['cardekho_id'] = $v['cardekho_id'];
                $data[$i]['cngFitted'] = $v['cngFitted'];
                $data[$i]['sell_dealer'] = $v['sell_dealer'];
                $data[$i]['inCertificationProcess'] = empty($v['inCertificationProcess']) ? '0' : '1';
                $data[$i]['certification_id'] = $v['certification_id'];
                $data[$i]['isclassified'] = $v['isclassified'];
                $data[$i]['make'] = $v['make'];
                $data[$i]['model'] = $model;
                $data[$i]['active'] = $v['active'];
                $data[$i]['version'] = $v['carversion'];
                $data[$i]['carversion'] = $v['carversion'];
                $data[$i]['regplace'] = ucwords($v['RegCity']);
                $data[$i]['ispremium'] = $v['ispremium'];
                $data[$i]['listedon'] = date("d M, Y", strtotime($v['created_date']));
                $data[$i]['colour'] = $v['colour'];
                $data[$i]['km'] = $v['km'];
                $data[$i]['min_selling_price'] = $v['min_selling_price'];
                $data[$i]['case_id'] = $v['case_id'];
                $data[$i]['sales_case_id'] = $v['sales_case_id'];
                $caseDetails = $this->crm_stocks->getFormCompletionDetails($v['case_id']);
                $data[$i]['edit_form_link'] = $this->crm_stocks->getUcPurchaseEditLink($caseDetails);
                $getWebsiteLinks = $this->crm_stocks->getWebsiteLink($v['id']);
                $salesCaseDetails = $this->Crm_used_car_sale_case_info->getSalesStatus($v['sales_case_id']);
                //print_r($salesCaseDetails);die;
                $data[$i]['sales_edit_form_link'] = $this->crm_stocks->getUcSalesEditLink($salesCaseDetails,$car_id,$v['sales_case_id']);
                if(!empty($getWebsiteLinks))
                $data[$i]['getWebsiteLinks'] = $getWebsiteLinks;
                $data[$i]['isPurCompleted'] = $this->crm_stocks->isPurchaseFormCompleted($caseDetails);
                $data[$i]['dealer_owner'] = '';
                $data[$i]['tradetype'] = $v['tradetype'];
                $data[$i]['expected_price'] = !empty($v['expected_price']) ? indian_currency_form($v['expected_price']) : '0';
                //$data[$i]['msp'] = $this->crm_stocks->getMinSellingPrice($v['id']);
                $min_selling_data = $this->crm_stocks->getMinSellingPrice($v['case_id'],$car_id);
                
                $data[$i]['msp']              = $min_selling_data['msp'];
                $data[$i]['inv_holding_cost'] = $min_selling_data['inv_holding_cost'];
                $data[$i]['pp']               = $min_selling_data['pp'];
                $data[$i]['profit']           = $min_selling_data['profit'];
                $data[$i]['purchase_cost']    = $min_selling_data['purchase_cost'];
                $data[$i]['refurb_cost']      = $min_selling_data['refurb_cost'];
                

                $statusToTabMap=['1'=>['tab'=>'active','label'=>'Available'],
                                 '2'=>['tab'=>'removed','label'=>'Removed'],
                                 '3'=>['tab'=>'sold','label'=>'Sold'],
                                 '4'=>['tab'=>'booked','label'=>'booked'],
                                 '6'=>['tab'=>'refurb','label'=>'refurb']];
                $data[$i]['tab'] = $statusToTabMap[$v['active']]['tab'];
                $data[$i]['status_label'] = $statusToTabMap[$v['active']]['label'];
                
                $data[$i]['myear'] = date('M', strtotime("2009-" . $v['mm'] . "-09")) . ' ' . $v['myear'];
                if ($v['owner'] > 0) {
                    
                        //$data[$i]['owner'] = '<span class="sprite icon-owner mrg-R5"></span><sup>' . addOrdinalNumberSuffix($v['owner']) . '</sup>';
                       $ownerIdToWord= [
                            '1'=>'First',
                            '2'=>'Second',
                            '3'=>'Third',
                            '4'=>'Fourth',
                            '5'=>'Fourth +',
                        ];
                        $data[$i]['owner'] = $ownerIdToWord[$v['owner']];
                } else {
                    $data[$i]['regplace'] = 'Unregistered car';
                    $data[$i]['owner'] = '<span class="sprite icon-owner mrg-R5"></span>None';
                }

                $data[$i]['fuel'] = $v['fuel_type'];
                $data[$i]['reg_no'] = $v['regno'] ? $v['regno'] : 'Unregistered Car';
                $data[$i]['transmission'] = $v['transmission'];
                $data[$i]['price'] = indian_currency_form($v['priceto']);
                //$data[$i]['dealer_price'] = (($v['dealer_price'] > 0 && $v['sell_dealer'] > 0) ? $v['dealer_price'] : 'NA');

                $imageFolder = '';
                $imagePath = $imageName= '';
                $imageCount = '';
                if ($v['image_folder'] == '1') {
                    $imageFolder = 'files';
                } else {
                    $imageFolder = 'files' . ($v['image_folder'] - 1);
                }
                $profileImage = $this->crm_stocks->getProfileImage($v['id']);
                
               
                if (!empty($profileImage)) {
                    if(isset($profileImage[0]['image_name'])){
                    $imageName = 'uploadcar/original/' . $profileImage[0]['image_name'];
                    $imagePath = UPLOAD_IMAGE_PATH .'uploadcar/original/' . $profileImage[0]['image_name'];
                    }
                    
                    $imageCount = $v['imageCount'];
                }
                if (!file_exists($imagePath)) {
                    //$imageName = '';
                }
                //echo $profileImage[0]['image_url'];die;
                $data[$i]['profileimage'] = !empty($profileImage[0]['image_url']) ?$profileImage[0]['image_url'] : '';
                $data[$i]['imageCount'] = $imageCount;
                $data[$i]['certifiedBY'] = '';
                if ($v['certifiedBYID'] == '18') {
                    $data[$i]['certifiedBY'] = $v['certifiedBY'];
                }
                $data[$i]['CStatus'] = '';
                if (!empty($v['CStatus'])) {
                    $data[$i]['CStatus'] = $certified_status_array[$v['CStatus']];
                }
                $data[$i]['expdate'] = '';
                /* if ($v['expdate'] && $v['expdate'] != '0000-00-00')
                  {
                  $data[$i]['expdate'] = date("d M Y", strtotime($v['expdate']));
                  } */
                $data[$i]['recommendedPackage'] = '';
                $recpack = '';

                if ($v['recommendedPackage']) {
                    $fetchrec = $this->crm_stocks->getWarrantyPackage($v['recommendedPackage']);


                    foreach ($fetchrec as $key => $val) {
                        $recpack .= $val['pack_name'] . ' (' . $val['pack_type'] . '), ';
                    }
                    $data[$i]['recommendedPackage'] = substr(trim($recpack), 0, -1);
                }
                $todaydate = date("Y-m-d");
                $date1 = new DateTime($todaydate);
                $date2 = new DateTime(date("Y-m-d", strtotime($v['created_date'])));
                $diff = $date1->diff($date2);
                $agestock = '';
                if (($diff->y) > 0) {
                    $agestock .= $diff->y . " yr.";
                }
                if (($diff->y) > 0 && ($diff->m) > 0) {
                    $agestock .= ", ";
                }
                if (($diff->m) > 0) {
                    $agestock .= $diff->m . " mo.";
                }
                if ((($diff->m) > 0 && ($diff->d) > 0) || (($diff->y) > 0 && ($diff->d) > 0 && ($diff->m) == 0)) {
                    $agestock .= ", ";
                }
                if (($diff->d) > 0) {
                    $agestock .= $diff->d . " day(s) ";
                }

                $data[$i]['ageofstock'] = $agestock;
                $fetchTotalVal = $this->crm_stocks->getDealerDetails($dealer_id);
                
                $data[$i]['domain']      = $fetchTotalVal[0]['domain'];
                
                $getClassifiedCars = $this->crm_stocks->getClassifiedCars($v['dealer_id']);

                $classified_limit = $this->crm_stocks->getDealerSku($dealer_id, '1', '8');
                $zigwheels_limit = $this->crm_stocks->getDealerSku($dealer_id, '6', '8');

                if (isset($fetchTotalVal['status']) && ($fetchTotalVal['status'] == '1')) {
                    $data[$i]['inventorytolist'] = $classified_limit['attribute_value'];
                    $data[$i]['totalclassified'] = $totalclassified['totalClassified'];
                    $data[$i]['upload_inventory_zigwheels'] = $zigwheels_limit['attribute_value']; //need to work on it
                } else {
                    $data[$i]['inventorytolist'] = 0;
                    $data[$i]['totalclassified'] = 0;
                    //$data[$i]['upload_inventory_zigwheels'] = $zigwheels_limit['attribute_value'];//need to work on it
                }
               
         $leadCount    = count($this->crm_stocks->getleadCount($v['id']));
         $data[$i]['total_leads'] = (($leadCount > 0 && $v['gaadi_id'] > 0) ? $leadCount : 0);

        
                $data[$i]['accessLevel'] = isset($_SESSION['accessLevel']) ? $_SESSION['accessLevel'] : 1;
                $data[$i]['inventorytolist'] = CLASSIFIEDLIMIT;
                $data[$i]['totalclassified'] = TOTALCLASSIFIED;

                $i++;
            }
           // echo '<pre>';print_r($data);die;
            return $data;
        }
    }

    public function getModel() {
        $make = $this->input->post('make');
        //echo $make;
        $result = $this->Make_model->getCarModelList($make,'used');
        //echo '<pre>';print_r($result);die;
        $option = "<option value='' >Select Model</option>";
        foreach ($result as $ModelKey => $ModelValue) {
            $option .= "<option value='" . $ModelValue['model'] . "' >" . $ModelValue['model'] . "</option>";
        }
        echo $option;
    }


    public function makeFeature()
    {
        $dealer_id      = DEALER_ID;
        $lastupdatedate = date('Y-m-d H:i:s');
        $type           = !empty($this->input->post('type')) ? $this->input->post('type') : '';
        $carid          = !empty($this->input->post('carId')) ? $this->input->post('carId') : '';
        if ($type == 'Add')
        {
            /* Function use to get Add Feature */
            //$featureLimit=$this->crm_stocks->getDealerSku($dealer_id,$sku_id='6',$attribute_id='8');
            //$isCapableforbringOnTop = $featureLimit['attribute_value'];
            $isCapableforbringOnTop = IS_FEATURED_LIMIT;
            $premium                = $this->crm_stocks->getFeatureCount($dealer_id);
            $alreadtInpremium       = $premium['total'];
            $restCanUpload          = $isCapableforbringOnTop - $alreadtInpremium;

            if ($restCanUpload > 0)
            {

                $dcData               = $this->crmToDcDataMapping($carid);
                $dcData['is_feature']  = '1';
                $dcData['is_gaadi']    = '1';
                $dcData['is_cardekho'] = '1';
                $res                  = $this->UserDashboard->pushInventoryToDC($dcData, $carid);
                $resArr               = json_decode($res);
                
                if ($resArr->status == 'T')
                {
                    $status = array('is_feature' => '1','is_gaadi'=>'1','is_cardekho'=>'1', 'last_update_date' => $lastupdatedate);
                    $return = $this->crm_stocks->managepremium($carid, $status);
                    //return $return;
                }
                $result = array('status' => $resArr->status, 'message' =>$resArr->msg);
            }
            else{
                $result = array('status' =>'T', 'message' =>'Premium Package Exaust');
            }
        }
        else
        {

            $dcData               = $this->crmToDcDataMapping($carid);
            $dcData['is_feature'] = '0';
            $res                  = $this->UserDashboard->pushInventoryToDC($dcData, $carid);
            $resArr               = json_decode($res);
            if ($resArr->status == 'T')
            {
                $status = array('is_feature' => '0','is_gaadi' => '0','is_cardekho' => '0', 'last_update_date' => $lastupdatedate);
                $return = $this->crm_stocks->managepremium($carid, $status);
                //return $return;
            }
            $result = array('status' => $resArr->status, 'message' =>$resArr->msg);
        }
        exit(json_encode($result));
    }

    public function getFeaturehtml(){
        $dealer_id = DEALER_ID;
        $type = !empty($this->input->post('type')) ? $this->input->post('type') : '';
        $car_id = !empty($this->input->post('carId')) ? $this->input->post('carId') : '';
        $case_id = !empty($this->input->post('case_id')) ? $this->input->post('case_id') : '';

        $HavepermissionforbringOnTop=1;
        $isCapableforbringOnTop  = IS_FEATURED_LIMIT;
        $premium          = $this->crm_stocks->getFeatureCount($dealer_id);
        $alreadtInpremium = $premium['total'];

        $restCanUpload    = $isCapableforbringOnTop - $alreadtInpremium; //allowed premium  - total premium inventory
        $TotalBringToTop  = $isCapableforbringOnTop;
        $totalAllowedInv = TOTALCLASSIFIED;
        $arrClassifiedCars=$this->crm_stocks->getClassifiedCars($dealer_id);
        $totalClassifiedInv=$arrClassifiedCars[0]['totalClassified'];
        $flagClassified=$this->crm_stocks->isClassified($car_id);
        $isClassified['isclassified']=(isset($flagClassified[0]['isclassified']) ? $flagClassified[0]['isclassified'] : 0);
        $isImg=$this->crm_stocks->isCarImageExist($car_id);
        $uploadPermission = 0;
        $featureMsg='';
        //$isImg['exitsimage']='image.jpg';
        if (isset($isImg['exitsimage']) && empty($isImg['exitsimage']) && $type != 'Remove')
                {

                   $featureMsg='Images are mandatory before making a stock as featured.';
                    $TotalBringToTop = '0';
                    $totalAllowedInv = '0';
                    $uploadPermission++;
                }
            else
                {
                   if ($restCanUpload == '0' && $type != 'Remove')
                    {

                        $featureMsg='You Have Exceeded Maximum Limit To Make Cars As Featured. Please Remove Other Cars From Featured Or Contact Your Service Executive To Increase Featured Inventory Limit.';
                    }
                    if ($totalClassifiedInv < $totalAllowedInv)
                    {
                        
                        if ($isCapableforbringOnTop != '0' && $HavepermissionforbringOnTop != 0)
                        {
                            if ($type == 'Add' && $isClassified['isclassified'] == '0')
                            {
                                $featureMsg= 'Non-Classified car cannot be made Featured. <br>Do you want to add this car to Classified Listing?';
                            }
                            else if ($type == 'Add' && $isClassified['isclassified'] == '1')
                            {
                                $confirmmsg='
                        <p class="edit-text font-14 col-black">You want to add this car in stock.</p>';
                                $percent = floor(($totalClassifiedInv / $totalAllowedInv) * 100);
                            $featureMsg= "<p style='color:green;' class='edit-text font-14  col-black'>Are You Sure Want To Add Selected Car As Featured ? <br>";
                          //  $percent . "% (" . $totalClassifiedInv . "/" . $totalAllowedInv . ") Classified Inventory Limit used</p>";
                            }
                        }
                    }
         }  
         if ($type == 'Remove')
            {
                $featureMsg= 'Are You Sure Want To Remove Selected Car From Featured.';
            }
        $this->load->helpers('classified_helper');
        if ($featureMsg) {
                echo getclassifiedHtml($car_id,$featureMsg,$uploadPermission,$totalClassifiedInv,$totalAllowedInv,$type,$case_id);
                exit;
            } 
    }
    public function getAddRemovehtml(){
        $dealer_id = DEALER_ID;
        $type = !empty($this->input->post('type')) ? $this->input->post('type') : '';
        $car_id = !empty($this->input->post('carId')) ? $this->input->post('carId') : '';
        $arrClassifiedCars=$this->crm_stocks->getClassifiedCars($dealer_id);
        $totalClassifiedInv=$arrClassifiedCars[0]['totalClassified'];
        $totalAllowedInv = TOTALCLASSIFIED;
        $uploadPermission = 0;
        if ($type == 'Add'){
          $confirmmsg='<h2 class="col-gray mrg-T0 mrg-B0">Are You sure?</h2>
            <p class="edit-text font-16">You want to add this car in stock.</p>';
           $percent = floor(($totalClassifiedInv / $totalAllowedInv) * 100);
          $featureMsg= $confirmmsg."<p style='color:green;' class='edit-text font-16'>Selected car(s) will be mark as classified inventory. <br>" .
          $percent . "% (" . $totalClassifiedInv . "/" . $totalAllowedInv . ") Classified Inventory Limit used</p>";  
        }
        $this->load->helpers('classified_helper');
        if ($featureMsg) {
                echo getclassifiedHtmlfromRemove($car_id,$featureMsg,$uploadPermission,$totalClassifiedInv,$totalAllowedInv,$type);
                exit;
            }
    }
    
    public function addtostock(){
        $dealer_id = DEALER_ID;
        $type = !empty($this->input->post('type')) ? $this->input->post('type') : '';
        $car_id = !empty($this->input->post('carId')) ? $this->input->post('carId') : '';
        $isCapableforbringOnTop = IS_FEATURED_LIMIT;
        $premium = $this->crm_stocks->getFeatureCount($dealer_id);
        $alreadtInpremium = $premium['total'];
        $restCanUpload = $isCapableforbringOnTop - $alreadtInpremium;

        $status = $restCanUpload > 0 ?array('is_feature' => '1'):[];
       
        $dcData               = $this->crmToDcDataMapping($car_id);
        $dcData['car_status']  = '1';
        $dcData['is_gaadi']   = $restCanUpload > 0 ?'1':'0';
        
        $res                  = $this->UserDashboard->pushInventoryToDC($dcData, $car_id);
        $resArr               = json_decode($res);
        if ($resArr->status == 'T'){
            $return = $this->crm_stocks->addtoAvailablestock($car_id, $status);
           //$return = $this->crm_stocks->addtoAvailablestock($car_id); 
            return $return;
        }
        return false;
    }

    public function addEditInventoryList() {
        $requestData = $this->input->post();
        if ($requestData['priceVal'] < 10000) {
            $status['msg'] = 'Price should not be less than 10,000';
            echo json_encode($status);
            exit;
        }
        if (isset($requestData['option']) && $requestData['option'] == 'addEditPrice') {
            $carId = $requestData['car_id'];
            $carDetail = $this->crm_stocks->getcarDetail($carId);
            $MMVDetails = $this->crm_stocks->getMmvDetailsByVersionId($carDetail['version_id']);
            $new_car_price = $requestData['priceVal'];
            //$car_certification_id = $requestData['car_certification_id'];
            if ($requestData['priceType'] == 'retail') {
                if (!empty($carDetail) && $carDetail['car_price'] != '') {

                    /* $checktrueprice = $this->CheckTruePrice($MMVDetails['make'], $MMVDetails['model'], $MMVDetails['carversion'], $carDetail['owner_type'], CITY_ID, $carDetail['make_year'], $carDetail['km_driven'], $new_car_price, 'Change_Price');
                      if ($checktrueprice != '1')
                      {
                      $status           = array();
                      $status['status'] = 'false';
                      $status['msg']    = "$checktrueprice";
                      exit(json_encode($status));
                      } */
                    $CarDetails = ['dealer_id' => $carDetail['dealer_id'],
                        'version_id' => $carDetail['version_id'],
                        'colour' => $carDetail['colour'],
                        'km_driven' => $carDetail['km_driven'],
                        'car_price' => $new_car_price];
                    $isDuplicate = $this->crm_stocks->CheckDuplicateInventory($CarDetails, $carId);

                    if (isset($isDuplicate['id']) && ($isDuplicate['id'] > 0)) {
                        $status = array();
                        $status['status'] = 'false';
                        $status['msg'] = 'Inventory Already Exists';
                        exit(json_encode($status));
                    }
                    if ($carDetail['car_price'] != $new_car_price) {
                        $retailPriceArray = array(
                            'dealer_id' => $carDetail['dealer_id'],
                            'retail_price' => trim($new_car_price),
                            'car_id' => $carId,
                            'date_time' => date("Y-m-d h:i:s")
                        );
                        //$db->dbInsertArray('used_car_retailprice_tracker', $retailPriceArray);
                        // $usedCarUploadObj->InventoryTrackerLog($carId, 'edit', $new_car_price, '', '', '', '1', '', '', '');
                    }
                }
            $dcData               = $this->crmToDcDataMapping($carId);
            $dcData['car_price']  = $new_car_price;
            $res                  = $this->UserDashboard->pushInventoryToDC($dcData, $carId);
            $resArr               = json_decode($res);
            if ($resArr->status == 'F'){
                 $status['msg'] = $resArr->msg;
                 exit(json_encode($status));
            }
                //$usedCarData   = ['pricefrom' => $new_car_price, 'priceto' => $new_car_price, 'dealer_id' => 69, 'car_certification_id'=>$car_certification_id];
                $usedCarData = ['car_price' => $new_car_price, 'dealer_id' => DEALER_ID];
                $update = $this->crm_stocks->getupdateRetailPrice($usedCarData, $carId);
            }
            $status = array();
            $status['status'] = 'true';
            $status['short_price_format'] =  priceFormatShortVersion($new_car_price);
            $status['msg'] = 'Price has been updated successfully. It may take up to 30 minutes to take effect on our classified platforms.';

            exit(json_encode($status));
        }
    }

    function CheckTruePrice($SourceMake, $SourceModel, $SourceVersion, $SourceOwner, $SourceCity, $SourceMakeYear, $SourceKm, $SourcePrice, $source) {
        $Parseowner = 1;
        $response = '';
        if ($SourceOwner) {
            $Parseowner = $SourceOwner;
        }
        $IpAddress = $_SERVER['REMOTE_ADDR'];
        $makemodelversionId = $this->crm_stocks->getMakeModelVersionId($SourceMake, $SourceModel, $SourceVersion);
        $MakeId = $makemodelversionId[make_id];
        $ModelId = $makemodelversionId[model_id];
        $VersionId = $makemodelversionId[db_version_id];

        //$url="http://beta.usedcarsin.in/api/Api_TrupriceCheck.php";
        $url = API_URL."api/Api_TrupriceCheck.php";

        $vars = "SourceMake=$MakeId&SourceModel=$ModelId&SourceVersion=$VersionId&SourceOwner=$SourceOwner&IpAddress=$IpAddress&SourceKm=$SourceKm&SourceMakeYear=$SourceMakeYear&SourceDealerCity=$SourceCity&SourcePrice=$SourcePrice&source=$source";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($vars));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 500); // curl request connection timeout time
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function addClassified() {
        $requestdata = $this->input->post();
        $carId = $requestdata['car_id'];
        $checkValue = $requestdata['checkValue'];
        $dealer_id = DEALER_ID;
        if ($checkValue == '0') {
            $allow_update_query = '1';
        } else {
            $Inventory = $this->crm_stocks->getClassifiedCars($dealer_id);
            $totalClassifiedInv = $Inventory[0]['totalClassified'];
            $classified_limit = CLASSIFIEDLIMIT;
            //$totalAllowedInv    = $Inventory[0]['inventorytolist'];
            $totalAllowedInv = $classified_limit;

            if ($totalClassifiedInv < $totalAllowedInv) {
                $allow_update_query = '1';
            } else {
                $allow_update_query = '0';
            }
        }

        if ($allow_update_query == '1')
        {
            //$creatorSource = $usedCarModelObj->getLoginUser();
            $checkValue  = $checkValue;
            $usedCarData = ['is_gaadi' => $checkValue];
            if ($checkValue == '0')
            {
                $usedCarData['is_feature'] = '0';
            }
            $dcData               = $this->crmToDcDataMapping($carId);
            $dcData['is_gaadi']   = $usedCarData['is_gaadi'];
            $dcData['is_feature'] = $usedCarData['is_feature'];
            $res                  = $this->UserDashboard->pushInventoryToDC($dcData, $carId);
            $resArr               = json_decode($res);
            //print_r($resArr);die;
            if ($resArr->status == 'T')
            {
                $return = $this->crm_stocks->updateClassified($usedCarData, $carId);

                if ($return)
                {
                    echo '1';
                }
            }
            else{
                echo '0';
            }
        }
        else
        {
            echo '0';
        }
    }
    public function crmToDcDataMapping($id){
        $getBasicDetails=$this->db->select('make_month,make_year,version_id,is_reg_no_show,reg_no,reg_place_city_id'
                . ',km_driven,car_status,reg_month,reg_year,owner_type,car_price,insurance_type,insurance_exp_year,'
                . 'insurance_exp_month,tax_type,colour,is_gaadi,is_feature')->from('crm_used_car')->where('id',$id)->get()->row_array();
        return $getBasicDetails;
    }

    public function getStockDelete() {
        $postData     = $this->input->post();
        $carID          = $postData['car_id'];
        $type           = $postData['type'];
        //$ajaxPost       = $postData['ajaxPost'];
        //$reason   = $_REQUEST['reason'];

        $reasons = $this->crm_stocks->getStockRemovalReasons();
        
        $data=['reasons'=>$reasons,'type'=>$type,'carID'=>$carID];
       echo $this->load->view('stock/remove_stock.php',$data,true); exit;
       // echo $rhtml;
       
        
        
        //echo $html;
    }
    
    public function marktosold(){
        $requestData=$this->input->post();
        $carID      = $this->input->post('car_id');
        $type       = $this->input->post('type');
        $ajaxPost   = $this->input->post('ajaxPost');
        $reason     = $this->input->post('reason');
        if ($ajaxPost == 'yes')
        {
            $status      = '2';
            $usedCarData['last_deactivation_date']=date('Y-m-d H:i:s');
            $usedCarData['is_gaadi']='0';
            $usedCarData['is_feature']='0';
            $usedCarData['car_status']=$status;
            $usedCarData['dealer_id']=DEALER_ID;
            
            $dcData               = $this->crmToDcDataMapping($carID);
            $dcData['is_gaadi']   = $usedCarData['is_gaadi'];
            $dcData['is_feature'] = $usedCarData['is_feature'];
            $dcData['car_status'] = $usedCarData['car_status'];
            
            $res                  = $this->UserDashboard->pushInventoryToDC($dcData, $carID);
            $resArr               = json_decode($res);
            if($resArr->status=='T'){
                $removed=$this->crm_stocks->updateMarktoSold($usedCarData, $carID);
                if($removed)
                {
                    $this->db->update('crm_used_car_other_fields',['remove_reason_id'=>$reason], array('cnt_id' => $carID));
                    exit(json_encode(['msg'=>'Stock Removed Successfully!','status'=>true]));

                }
                exit(json_encode(['msg'=>'Something Went Wrong!','status'=>false]));
            }
            exit(json_encode(['msg'=>$resArr->msg,'status'=>false]));
        }
        
    }
     
/**
     * @author : shashikant kumar
     */
    
    public function  stock_email_sms(){
        $requestParams              = $this->input->post();
        $this->load->model('Used_car_aditional_detail');
        $customermobile    = !empty($requestParams['mobile'])?$requestParams['mobile']:'';
        $requestType       = !empty($requestParams['message'])?$requestParams['message']:'';
        $type              = !empty($requestParams['type'])?$requestParams['type']:'';
        $car_id            = !empty($requestParams['car_id'])?$requestParams['car_id']:'';
        $gaadi_id          = !empty($requestParams['gaadi_id'])?$requestParams['gaadi_id']:'';
        if ($requestType == 'email') {

            /* Function use to get Email Content */
            //echo $this->Crm_stocks->getStockEmailData($car_id);
            exit;
        }else if (($requestType == 'message') && $car_id) {
            $response=$this->crm_stocks->getStockSMSData($car_id);
            if(!empty($response)){
                $flag = '0';
                if(IS_CLASSIFIED=='0'){
                    $flag='1';
                }
            $renderSmsText = $this->Used_car_aditional_detail->renderCarShareSmsText($response, $car_id, $requestType,$flag);
                echo trim($renderSmsText);
                exit;
            }
        }
    }
    
    function sms_email_send(){
        $postData  = $this->input->post();
        
        $mobile  = !empty($postData['custoMobile'])?$postData['custoMobile']:'';
        $smsText = !empty($postData['stocksmsn'])?$postData['stocksmsn']:'';
        $type    = !empty($postData['send_type']) ?$postData['send_type']:'';
        $email   = !empty($postData['txtEmail']) ?$postData['txtEmail']:'';
        $car_id  = !empty($postData['car_id'])?$postData['car_id']:'';
        
        if(!empty($email) && $type=='email'){
            $response=$this->Crm_used_car->sendMailOnStockShareHtml($car_id,$email);
            echo $response;die;
        }
        
        
        if(!empty($mobile) && $type=='sms') {
        $curlRequest = curlPostData($mobile, $smsText, 'gaadi');
        $this->db->insert('stock_sms_mapping', ['car_id'=>$postData['car_id'],'mobile_no'=>$mobile,'sms_body'=> str_replace(',', '', "'$smsText'")]);
        if($curlRequest){
            echo 'Sms sent to '.$mobile;
        }
        else{
            echo'SMS not sent to'.$mobile;
        }
        }
    }
    
    
    public function carDetails($id = Null){
        $data=[];
        $dealerId                       = DEALER_ID;
        $activeStatus                   = "1";
        $searchText                     = '';
        $editId                         = !empty($id)? explode('_',base64_decode($id)):'';
        $carId                          = end($editId);
        if(!is_numeric($carId)){
            redirect('inventoryListing');
        }
        $data['image']                  = $this->crm_stocks->getAllUsedCarImages($carId);
        $carDetail                      = $this->crm_stocks->getInventoryListing($dealerId,$activeStatus,$searchText,true,'','',$carId);
        $data['monthText']              = getMonthText($carDetail[0]['mm']);
        $data['ownerText']              = getownerAsText($carDetail[0]['owner']);
        $data['carDetail']              = !empty($carDetail[0])?$carDetail[0]:'';
        $data['CarStatus']              = $this->getCarStatus($carDetail);
        $data['feature']                = $this->getFetures($carId);
        $data['certified_status_array'] = array('Not Inspected', 'Certified', 'In Process', 'Dealer Request', 'Refurbishment', 'In Process', 'Rejected', 'Expired', 'UnAvailable');
        $data['CStatus']                = $this->getCertificationStatus($data['carDetail'],$data['certified_status_array']);
        $data['cerexpiredate']          = $this->getCertificationExpdate($carId);
        $data['certificationName']      = $this->getCertificationNameById($carDetail[0]['certification_id']);
        $data['carId']                  = $carId;

        $this->loadViews("stock/carDetails", $this->global, $data, NULL);
    }
    
    public function getCarStatus($carDetail) {
        if ( !empty($carDetail[0]) && $carDetail[0]['active'] == '1') {
            $CarStatus = 'Active';
        } else if (!empty ($carDetail[0]) && $carDetail[0]['active'] == '2') {
            $CarStatus = 'Removed';
        } else if (!empty ($carDetail[0]) && $carDetail[0]['active'] == '3') {
            $CarStatus = 'Sold';
        } else {
            $CarStatus = 'Inactive';
        }
        return $CarStatus;
    }
    
    public function getCertificationStatus($carDeatil,$certified_status_array) {
        if ($carDeatil['certification_status'] != '0' && $carDeatil['certification_status'] != '') {
            $CStatus = $certified_status_array[$carDeatil['certification_status']];
        } else {
            $CStatus = 0;
        }
        
        return $CStatus;
    }
    
    public function getCertificationExpdate($car_id){
            $this->db->select('expiry_date,recommendedPackage');
            $this->db->from('crm_used_car_certification');
            $this->db->where('car_id', $car_id);
            $this->db->where('is_latest', '1');
            $query = $this->db->get();
            $cerexpiredate= $query->row_array();
            return $cerexpiredate;
    }
    
     function getCertificationNameById($certificationId) {
            $this->db->select('name');
            $this->db->from('crm_car_certification');
            $this->db->where('id', $certificationId);
            $query = $this->db->get();
            $cerDetail= $query->row_array();
            return $cerDetail['name'];
    }
    

    public function getFetures($carId) {
        $data = [];
        $this->load->model('Used_car_model_details');
        $this->load->model('Used_car_aditional_detail');
        $this->load->model('Usedcar_condition_mapper');
        $resultModelInfo      = $this->Used_car_model_details->getModelDetail($carId);
        $resultAdditionalInfo = $this->Used_car_aditional_detail->getcarAdditionalDetail($carId);
        $resultAdditionalInfo['accessories'];

        $carConditions = $this->Usedcar_condition_mapper->getAllCondition($carId);
        $conditionName     = '';
        $heaterName        = '';
        $electricalName    = '';
        $viewexterior  = '';
        $bodyTypes     = '';
        $interiors     = '';
        $etcs          = '';
        $susstes       = '';
        $breaks        = '';
        $tires         = '';
        $batteriName   = '';

        if (!empty($carConditions)) {
            if ($carConditions['usedcar_exterior']) {
                $exteriors = explode(",", $carConditions['usedcar_exterior']);
                if (!empty($exteriors)) {
                    foreach ($exteriors as $ext => $tableid) {
                        $exteriorsName = $this->getNameFromTable('usedcar_exterior', $tableid);
                        if ($exteriorsName['exterior_name'] != '') {
                            $viewexterior .= $exteriorsName['exterior_name'] . ', ';
                        }
                    }
                }
            }
            if ($carConditions['usedcar_bodyframe']) {
                $bodyType = explode(",", $carConditions['usedcar_bodyframe']);

                if (!empty($bodyType)) {
                    foreach ($bodyType as $body => $tableid) {
                        $bodyTypeName = $this->getNameFromTable('usedcar_bodyframe', $tableid);
                        if ($bodyTypeName['bodyframe_name'] != '') {
                            $bodyTypes .= $bodyTypeName['bodyframe_name'] . ', ';
                        }
                    }
                }
            }
            if ($carConditions['usedcar_interior']) {
                $interior = explode(",", $carConditions['usedcar_interior']);
                if (!empty($interior)) {
                    foreach ($interior as $int => $tableid) {
                        $interiorName = $this->getNameFromTable('usedcar_interior', $tableid);
                        if ($interiorName['interior_name'] != '') {
                            $interiors .= $interiorName['interior_name'] . ', ';
                        }
                    }
                }
            }
            if ($carConditions['usedcar_etc']) {
                $etc = explode(",", $carConditions['usedcar_etc']);
                if (!empty($etc)) {
                    foreach ($etc as $etc => $tableid) {
                        $etcName = $this->getNameFromTable('usedcar_etc', $tableid);
                        if ($etcName['etc_name'] != '') {
                            $etcs .= $etcName['etc_name'] . ', ';
                        }
                    }
                }
            }
            if ($carConditions['usedcar_susste']) {
                $susste = explode(",", $carConditions['usedcar_susste']);
                if (!empty($susste)) {
                    foreach ($susste as $susstea => $tableid) {
                        $sussteName = $this->getNameFromTable('usedcar_susste', $tableid);
                        if ($sussteName['susste_name'] != '') {
                            $susstes .= $sussteName['susste_name'] . ', ';
                        }
                    }
                }
            }
            if ($carConditions['usedcar_breaks']) {
                $break = explode(",", $carConditions['usedcar_breaks']);
                if (!empty($break)) {
                    foreach ($break as $br => $tableid) {
                        $breakName = $this->getNameFromTable('usedcar_breaks', $tableid);
                        if ($breakName['breaks_name'] != '') {
                            $breaks .= $breakName['breaks_name'] . ', ';
                        }
                    }
                }
            }
            if ($carConditions['usedcar_tires']) {
                $tire = explode(",", $carConditions['usedcar_tires']);
                if (!empty($tire)) {
                    foreach ($tire as $ti => $tableid) {
                        $tireName = $this->getNameFromTable('usedcar_tires', $tableid);
                        if ($tireName['tires_name'] != '') {
                            $tires .= $tireName['tires_name'] . ', ';
                        }
                    }
                }
            }

            if ($carConditions['usedcar_battery']) {
                $batteris = $carConditions['usedcar_battery'];
                $batteriName = $this->getNameFromTable('usedcar_battery', $batteris);
            }

            if ($carConditions['usedcar_condition']) {
                $condition = $carConditions['usedcar_condition'];
                $conditionName = $this->getNameFromTable('usedcar_overallcondition', $condition);
            }
            if ($carConditions['usedcar_acheater']) {
                $heatershow = $carConditions['usedcar_acheater'];
                $heaterName = $this->getNameFromTable('usedcar_acheater', $heatershow);
            }
            if ($carConditions['usedcar_electrical']) {
                $usedcar_electricals = $carConditions['usedcar_electrical'];
                $electricalName = $this->getNameFromTable('usedcar_electrical', $usedcar_electricals);
            }
            
        }
            $data['resultModelInfo']        = !empty($resultModelInfo)?$resultModelInfo:'';
            $data['resultAdditionalInfo']   = !empty($resultAdditionalInfo)?$resultAdditionalInfo:'';
            $data['batteriName']            = !empty($batteriName)?$batteriName:'';
            $data['conditionName']          = !empty($conditionName)?$conditionName:'';
            $data['heaterName']             = !empty($heaterName)?$heaterName:'';
            $data['electricalName']         = !empty($electricalName)?$electricalName:'';
            $data['viewexterior']           = !empty($viewexterior)?$viewexterior:'';
            $data['bodyTypes']              = $bodyTypes;
            $data['interiors']              = $interiors;
            $data['etcs']                   = $etcs;
            $data['susstes']                = $susstes;
            $data['breaks']                 = $breaks;
            $data['tires']                 = $tires;
            return $data;
        

    }
    public function getNameFromTable($tablename, $id) {
            $this->db->select('*');
            $this->db->from($tablename);
            $this->db->where('id', $id);
            $query = $this->db->get();
            $result= $query->row_array();
            return $result;
        }

    public function tagImgViewPage()
    {
        $data=[];
        $arr=[];
        $data['car_id'] = $this->input->post('car_id');
        $data['getAllTags'] = $this->crm_stocks->getTags();
        $imageDetail = $this->crm_stocks->getAllImages($data['car_id']);
        $i =0 ;
        if (!empty($imageDetail))
        {
            foreach ($imageDetail as $key => $newImage)
            {
                $getAllImage[$i]['image_name'] = $newImage['image_name'];
                $getAllImage[$i]['image_url'] =$newImage['image_url'];
                $imageTags[$newImage['image_name']]=$newImage['tag_id'];
                $i++;
            }
        }
        if(!empty($getAllImage)){
        $data['getAllImage'] = $getAllImage;
         }
          if(!empty($imageTags)){
        $data['imageTags'] = $imageTags;
    }
        echo $datas=$this->load->view('stock/tag_view.php',$data,true); exit;
      // echo  $this->set_output($data);  exit;
    }

    public function saveTagsManageInv()
    {
        $car_id     = $this->input->post('car_id');
        $imageNames = $this->input->post('img');
        $imagaData  = [];
        foreach ($imageNames as $image)
        {
            $img    = explode('.', $image);
            $Image  = $img[0];
            $tag_id =  $this->input->post($Image);

            $this->crm_stocks->updateImgTag($tag_id,$car_id,$image);
            
        }
        echo'1';
    }

    public function viewnewEditedphotos()
    {
        $data=[];
        $data['car_id'] = $this->input->post('car_id');
        $allImageCount = $this->crm_stocks->getAllImagesCount($data['car_id']);
         
        $carDetails=$this->db->select('km_driven,make_month,make_year,reg_no')
                ->from('crm_used_car as used_car')
                ->where('used_car.id', $data['car_id'])->get()->row_array();
        $year               = $carDetails['make_year'];
        $month              = $carDetails['make_month'];
        
        $carDetails['mm_my']=date('M Y',strtotime(date("$year-$month-d")));
        $data['carDetails'] =$carDetails;
        $image_count=['active'=>0,'rejected'=>0,'flagged'=>0];
        foreach ($allImageCount as $imageCount)
        {
            $imageCount['status'] == '1' ? $image_count['active'] = $imageCount['img_count'] : '';
            $imageCount['status'] == '2' ? $image_count['rejected'] = $imageCount['img_count'] : '';
            $imageCount['status'] == '3' ? $image_count['flagged'] = $imageCount['img_count'] : '';
        }
        $data['image_count']=$image_count;
        echo $datas=$this->load->view('stock/view_image.php',$data,true); exit;
    }
    public function all_images()
    {
        $data=[];
        $data['car_id'] = $this->input->post('car_id');
        $data['status'] = $this->input->post('status');
        
        $statusMap=['active'=>'1','rejected'=>'2','flagged'=>'3'];
        $status = $statusMap[$data['status']];
        
        $imageDetail = $this->crm_stocks->getAllImages($data['car_id'],$status);
       
        $i =0 ;
        if (!empty($imageDetail))
        {
            foreach ($imageDetail as $key => $newImage)
            {
                $getAllImage[$i]['image_name'] = $newImage['image_name'];
                $getAllImage[$i]['image_url'] = $newImage['image_url'];
                $getAllImage[$i]['rejected_reason'] = $newImage['rejected_reason'];
                //$imageTags[$newImage['image_name']]=$newImage['tag_id'];
                $i++;
            }
        }
        //$data['originalpath'] = $originalpath;
         if(!empty($getAllImage)){
        $data['getAllImage'] = $getAllImage;
         }
       // echo "<pre>";
        //print_r($data);
      //  exit;
        echo $datas=$this->load->view('stock/view_active_image.php',$data,true); exit;
    }

    public function tagPhotoManageInv()
    {
        $data=[];
        $data['car_id'] = $this->input->post('car_id');
        $imageMapArray  = $this->UsedCarImageMapper->getAllImagesByCarId($data['car_id']);
        $data['imageMapArray'] = $imageMapArray;
        echo $datas=$this->load->view('stock/upload_image.php',$data,true); exit;
    }

    public function upload_new_image($car_id){
        //echo UPLOAD_IMAGE_PATH.'uploadcar/original/'; 
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
            //echo "hiiiii";
            $data = $this->upload->data();
           // $_SESSION['used_car_image_mapper'][$_FILES[$file_name_key]['name']] = $data;
            $d['used_car_image_mapper'][$_FILES[$file_name_key]['name']] = $data;
           $this->UserDashboard->manageCarImages($d['used_car_image_mapper'],$car_id);
        }
        else
        {
          //  echo "rfeerfefre";
            $error  = array('Invalid Request!');
            $result = array('error' => $error, 'status' => 400);
        }
        exit;
    }
    public function getBuyCustomer()
    {
        $keyword=$this->input->post('term');
        //echo json_encode($keyword);exit;
        $getBuyCustomer=$this->Leadmodel->getBuyCustomer($keyword);
        if($getBuyCustomer){
            $i=0;
        foreach ($getBuyCustomer as $key=>$value){
            $response[$i]['id']           =$value['lead_id'];
            $response[$i]['mobile']           =$value['mobile'];
            $response[$i]['name']           =$value['name'];
            $response[$i]['value']        =$value['name'].' ( '.$value['mobile'].' )';
            $response[$i]['html']         ='';
            $i++;
        }
            
        }else{
            $response[0]['value']        ='Sorry no lead found.';
            $response[0]['html']         ="<span>No <b>".$keyword."</b> Found </span><br/><a class='btn-block advanced-search-btn pad-L10 mrg-T5 font-18  href='javascript:void(0);' id='addbuylead'><i class='fa fa-plus-square-o down font-20 mrg-R5' data-unicode='f01a'></i>Add as Lead</a>";
        }
        echo trim(json_encode($response));exit;
    }
    
    public function updateLeadStatus($datapost)
    {
        error_reporting(0);
        $fields_string          = '';
        $dealer_id=DEALER_ID;
        $data=[];
        $data['txtname']                   = $datapost['cust_name'];
        $data['txtmobile']              = $datapost['cust_mobile'];
        $data['ucdid']                  = $dealer_id;
        $data['source']                 = 'SELF';
        $data['lead_source']            = 'SELF';
        $data['rating']                 = '';
        $data['status']                 = 'Converted';
        $data['car_id']                 = (isset($datapost['car_id']))?$datapost['car_id']:'';
        $data['follow_up']            = date('Y-m-d H:i:s');
        $data['offer']                  = $datapost['sold_price'];
        //$obj = updateStatus();
       //$objb=new BuyLead();
        
        //$this->load->controller('Lead');
        //$updateStatus=$objb->updateStatus($data,$dealer_id);
        
        foreach ($data as $keys => $values) {
            $fields_string .= $keys . '=' . $values . '&';
        }
        rtrim($fields_string, '&');
        //load_controller('Lead', 'updateStatus');
        $url=  base_url()."Lead/updateStatus";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    public function getInspectionDetails()
    {

        $car_id     = $this->input->post('car_id');
        $utm_source = $this->input->post('utm_source');
        $utm_medium = $this->input->post('utm_medium');

        $cerexpiredate = $this->db->select('id')
                        ->from('crm_used_car')
                        ->where('id', $car_id)
                        ->get()->row_array();
        
        $gaadi_id   = $cerexpiredate['id'];

        if ($utm_source == '')
        {
            $utm_source = 'dc';
        }

        if ($utm_medium == '')
        {
            $utm_medium = 'mi';
        }
        $page = 'http://www.cardekhotrustmark.com/condition-report-result.php?car_id=' . $gaadi_id . '&utm_source=' . $utm_source . '&utm_medium=' . $utm_medium;
        //$this->loadViews("stock/inspection_report", $page);
        $this->load->view('stock/inspection_report', ['page'=>$page,'car_id'=>$car_id,'utm_source'=>$utm_source,'utm_medium'=>$utm_medium]);
        
    }
    public function getMakeModelWithRegNo(){
        
        $dealer_id    = DEALER_ID;
        $search_value = $this->input->get('term');
        $result=$this->crm_stocks->getDealerStocksByMMVAndRegNo($search_value, $dealer_id);
        //print_r($result);die;
        $data =[];
        foreach ($result as $value)
        {
            $reg_no             = !empty($value['reg_no']) ? ' (' . $value['reg_no'] . ' )' : '';
            $data[] = ['key'=>$value['id'],'value'=>$value['mk_n'] . ' ' . $value['md_n'] . ' ' . $value['v_n']  . $reg_no ];
        }
        exit(json_encode($data));
    }
    public function viewQuotesForm(){
        $car_id     = $this->input->post('car_id');
        $data=$this->db->query("SELECT id,car_price,km_driven FROM crm_used_car 
                            where id=$car_id ")->result_array();
        $this->load->view('stock/quotesForm',$data[0]);
    }

    public function shareCarPriceQuotes()
    {
        require_once(APPPATH . "third_party/dompdf/dompdf_config.inc.php");
        $post_data = $this->input->post();

        $customer_name  = $post_data['customer_name'];
        $customer_email = $post_data['customer_email'];
        $km_driven      = str_replace(',', '', $post_data['km_driven']);
        $car_price      = str_replace(',', '', $post_data['car_price']);
        $car_id         = $post_data['car_id'];

        $data                       = $this->db->query("SELECT uc.id,uc.reg_no ,mv.db_version v_n,mm.model md_n,mm.id model_id,parent_model_id,
                                mm.make mk_n,uc.reg_year,uc.colour,owner_type,d.organization,
                                d.dealership_email,dealership_contact,d.owner_name dealer_owner
                                FROM crm_used_car uc 
                                left join crm_dealers d on uc.dealer_id=d.id
                            left join model_version mv on mv.db_version_id=uc.version_id
                            left join make_model mm on mm.id=mv.model_id
                            where uc.id=$car_id ")->result_array();
        $viewData                   = $data[0];
        $viewData['customer_name']  = $customer_name;
        $viewData['customer_email'] = $customer_email;
        $viewData['car_price']      = $car_price;
        $viewData['km_driven']      = $km_driven;


        if (!empty($viewData['parent_model_id']))
        {

            $parent_model     = $this->db->query("SELECT model
                                FROM  make_model
                            where id=" . $viewData['parent_model_id'])->row_array();
            $viewData['md_n'] = $parent_model['model'];
        }
        $html     = $this->load->view('stock/quotesHtml', $viewData, true);
        $time     = time();
        $filename = 'QuotesReceipt_' . $viewData['id'] . '_' . $time . '.pdf';

        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $output = $dompdf->output();
        //file_put_contents('/var/www/cdn/deliverydocs/' . $filename, $output);
        file_put_contents(UPLOAD_IMAGE_PATH_LOCAL.'deliverydocs/' . $filename, $output);
        echo json_encode(['file_name' => $filename]);
        exit;
    }

    public function downloadQuotesPdf()
    {
        $file_name = $_GET['file'];
        //$file_path='/var/www/cdn/deliverydocs/'.$file_name;
        $file_path  =UPLOAD_IMAGE_PATH_LOCAL.'deliverydocs/'.$file_name;
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        flush(); // Flush system output buffer
        readfile($file_path);
        exit;
    }
    public function bookingForm()
    {    
//        error_reporting(1);
//		ini_set('display_errors', 1);
        require_once(APPPATH . "third_party/dompdf/dompdf_config.inc.php");
        $post_data = $this->input->post();
        $car_id         = $post_data['car_id'];
        $type         = $post_data['type'];
        
        $caseData           = $this->Crm_used_car_sale_case_info->getUcSalesCaseByCarid($car_id);

        if(empty($caseData)){
           exit(json_encode(['status'=>false,'message'=>'No Data Found!','file_name'=>''])); 
        }
        $viewData           = $this->Crm_used_car_sale_case_info->getSalesCaseData($caseData['id'])[0];
/*echo "<pre>";
print_r($viewData);
exit;*/
        if ($type == 'paymentReceipt' || $type == 'salesInvoice')
        {
            $amount_paid             = $this->Crm_used_car_sale_payment->getTotalAmountPaid($caseData['id'], $admin                   = true);
            $paymentData             = $this->Crm_used_car_sale_payment->getPaymentData($caseData['id'],$_SESSION['userinfo']['role_id']);
            $viewData['paymentData'] = $paymentData;
            $viewData['amount_paid'] = $amount_paid;
        }
        if (!empty($viewData['parent_model_id']))
        {

            $parent_model     = $this->db->query("SELECT model
                                FROM  make_model
                            where id=" . $viewData['parent_model_id'])->row_array();
            $viewData['model'] = $parent_model['model'];
        }
     // echo "<pre>";  print_r($viewData); exit;
        $html     = $this->load->view('stock/'.$type.'Html', $viewData, true);;
        
        
        
        $time     = time();
        $filename = str_replace(' ','-',$viewData['seller_name']).'_'.strtolower($type).'_' . $time . '.pdf';

        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $output = $dompdf->output();
        //file_put_contents('/var/www/cdn/bookingdocs/' . $filename, $output);
        //echo UPLOAD_IMAGE_PATH_LOCAL.'bookingdocs/' . $filename;die;
        $upload_folder=UPLOAD_IMAGE_PATH_LOCAL.strtolower($type).'docs/';
        is_dir($upload_folder) || mkdir($upload_folder, 0777, true);
        
        file_put_contents($upload_folder . $filename, $output);
        echo json_encode(['file_name' => $filename,'type'=>strtolower($type),'status'=>true,'message'=>'File Downloaded Successfully']);
        exit;
    }

    public function downloadBookingPdf()
    {
        $file_name = $_GET['file'];
        $type = $_GET['type'];
        //$file_path='/var/www/cdn/deliverydocs/'.$file_name;
        $file_path  =UPLOAD_IMAGE_PATH_LOCAL.strtolower($type).'docs/'.$file_name;
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        flush(); // Flush system output buffer
        readfile($file_path);
        exit;
    }
    
    public function getRefurbhtml(){
        $carId=$this->input->post('carId');
        $type=$this->input->post('type');
        $wclist=$this->Crm_refurb_workshop->getworkshoplist();
        $empList =  $this->Crm_user->getEmployee('8','',$roleType);
        $this->load->helpers('classified_helper');
        echo getmarkRefurb($carId,$wclist,$empList);
        exit;
    }
    
    public function saveRefurb(){
        $data=[];
        $params=$this->input->post();
        $data['car_id']=(!empty($params['carId'])) ? $params['carId'] :'';
        $data['wc_id']=(!empty($params['wcName'])) ? $params['wcName'] :'';
        $data['emp_id']=(!empty($params['empName'])) ? $params['empName'] :'';
        $data['refurb_details']=(!empty($params['refurb'])) ? $params['refurb'] :'';
        $data['sent_to_refurb']=(!empty($params['refurbsentOn'])) ? date('Y-m-d H:i:s',strtotime($params['refurbsentOn'])) :'';
        $data['estimated_date']=(!empty($params['refurbestimated'])) ? date('Y-m-d H:i:s',strtotime($params['refurbestimated'])) :'';
        $data['estimated_amt']=(!empty($params['estimatedAmt'])) ? str_replace(",","",$params['estimatedAmt']) :'';
        $data['sent_km']=(!empty($params['sent_km'])) ? str_replace(",","",$params['sent_km']) :'';
        
        $data['created_on']=date('Y-m-d');
        $data['status']='1';
        $refid=$this->Crm_refurb_workshop->addrefurbDetails($data);
        if($refid > 0){
            $cardetail=array('car_status'=>'6');
            $carId=$data['car_id'];
            $this->crm_stocks->updatestockCarId($carId,$cardetail);
        }

        // For PDF generation
        $pdfData = $this->refurbPdf($refid);
        require_once(APPPATH . "third_party/dompdf/dompdf_config.inc.php");
        $time     = time();
        $filename = 'Refurb_Workorder_' . $time . '.pdf';

        $dompdf = new DOMPDF();
        $dompdf->load_html($pdfData);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents(UPLOAD_IMAGE_PATH_LOCAL.'refurbDoc/' . $filename, $output);

        $data                   = [];
        $data['file_name']      = $filename;
        $this->Crm_refurb_workshop->updaterefurbDetails($refid,$data);

        if(isset($params['is_download']) && $params['is_download'] == 'Y'){
            $returnArray['file_name']   = $filename;
        } else {
            $returnArray['file_name']   = '';
        }

        $returnArray['carId']       = $carId;
        
        print json_encode($returnArray);
        exit;
    }
    
    public function getvalidRefurbhtml(){
     $carId=$this->input->post('carId');
     $refDetails=$this->Crm_refurb_workshop->getrefurbDetails($carId);
     $type=$this->input->post('type');
     $this->load->helpers('classified_helper');
        echo getvalidmarkRefurb($carId,$refDetails);
        exit;
    }
    
    public function updateRefurb(){
        $data=[];
        $params=$this->input->post();
        $carId=(!empty($params['carId'])) ? $params['carId'] :'';
        $id=(!empty($params['caseId'])) ? $params['caseId'] :'';
        $data['refurb_details']=(!empty($params['refurb_details'])) ? $params['refurb_details'] :'';
        $data['estimated_date']=(!empty($params['return_date'])) ? $params['return_date'] :'';

        if(trim($data['estimated_date']) != ''){
            $data['estimated_date'] = date('Y-m-d H:i:s',strtotime($data['estimated_date']));
        }

        $data['actual_amt']=(!empty($params['tot_amt'])) ? $params['tot_amt'] :'';
        $data['return_km'] = (!empty($params['return_km'])) ? str_replace(",", "", $params['return_km']) :'';
        $data['is_refurb_done']='1';
        $refid=$this->Crm_refurb_workshop->updaterefurbDetails($id,$data);
        if($refid > 0){
            $cardetail=array('car_status'=>'1');
            $this->crm_stocks->updatestockCarId($carId,$cardetail);
            
        }
                // For PDF generation
        $pdfData = $this->refurbUpdatedPdf($id);
        
        require_once(APPPATH . "third_party/dompdf/dompdf_config.inc.php");
        $time     = time();
        $filename = 'Refurb_Workorder_' . $time . '.pdf';

        $dompdf = new DOMPDF();
        $dompdf->load_html($pdfData);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents(UPLOAD_IMAGE_PATH_LOCAL.'refurbDoc/' . $filename, $output);
        $filedata                   = [];
        $filedata['file_name']      = $filename;
        $this->Crm_refurb_workshop->updaterefurbDetails($id,$filedata);

        if(isset($params['is_download']) && $params['is_download'] == 'Y'){
            $returnArray['file_name']   = $filename;
        } else {
            $returnArray['file_name']   = '';
        }

        $returnArray['carId']       = $carId;
        
        print json_encode($returnArray);
        exit;
    }

    public function paymentRefurb($invId='') {
        $this->loadViews("stock/payment-refurb", $this->global, $data, NULL);
    }

    public function refurbPdf($id){
        $sql       = "SELECT uc.reg_no , mv.db_version AS version, mm.model AS model, 
                    mm.make AS make, crd.refurb_details, crd.estimated_amt,crd.actual_amt,crd.sent_km,crd.return_km,crd.estimated_date AS date_of_completetion,
                    crd.sent_to_refurb AS date_of_refurb,crd.created_on AS date_of_workorder, crw.name AS workshop_name, crw.owner_name AS workshop_manager_name, cu.name AS office_cordinator,crd.is_refurb_done
                    FROM crm_used_car AS uc 
                    INNER JOIN model_version AS mv ON mv.db_version_id=uc.version_id
                    INNER JOIN make_model AS mm ON mm.id=mv.model_id
                    LEFT JOIN crm_refurb_details AS crd ON crd.car_id=uc.id 
                    INNER JOIN crm_refurb_workshop AS crw ON crw.id=crd.wc_id
                    INNER JOIN crm_user AS cu ON cu.id = crd.emp_id
                    WHERE crd.id=$id and crd.is_refurb_done='0'";
        $data       = $this->db->query($sql)->result_array();
        
        $html       = '';
        if(isset($data[0])){
            $reg_no     = $data[0]['reg_no'];
            $model      = $data[0]['make'].' '.$data[0]['model'].' '.$data[0]['version'];

            $details    = $data[0]['refurb_details'];

            $newArray   = [];
            for($i=1;$i<100;$i++){
               $new = explode($i.'. ',$details);
               if(isset($new[1]) && trim($new[1]) != ''){
                $j = $i+1;
                $temp = explode($j.'. ',trim($new[1]));
                $newArray[] = trim($temp[0]);
               }
            }

            $subHtml = '';
            foreach($newArray as $key => $value){
                $sn = intval($key)+1;
                $act_amt = '';
                $amt = '';
                
                if($sn == 1){ $amt = '<img src="'.base_url().'assets/images/rupee-icon.png" style="width:11px; margin-top:3px;">'. indian_currency_form($data[0]['estimated_amt']); }
                if($data[0]['is_refurb_done']=='1' && $sn==1){ 
                    $act_amt = '<img src="'.base_url().'assets/images/rupee-icon.png" style="width:11px; margin-top:3px;">'.indian_currency_form($data[0]['actual_amt']);
                }
                $subHtml .= '<tr>
                            <td colspan="3" style="padding:5px;  font-weight:bold"">'.$sn.'</td>
                            <td colspan="3" style="padding:5px; font-weight:bold">'.$value.'</td>
                            <td colspan="3" style="padding:5px;  font-weight:bold"">'.$amt.'</td> 
                            <td colspan="3" style="padding:5px;  font-weight:bold"">'.$act_amt.'</td>

                        </tr>';
            }
            

            $html       = '<!doctype html>
                            <html> 
                                <head>
                                    <style>
                                        body {margin: 0;padding: 0;color: #000;font-family: Arial, Helvetica, sans-serif;width: 100%; font-size:12px;} 
                                        @page {margin-top: 25px;margin-bottom: 25px; margin-left: 30px;margin-right: 30px;}
                                        .clear { clear: both; }
                                        img { border: 0;outline: 0;}
                                        .form-wrapper { width: 100%;margin: 0 auto;padding: 0;}
                                        table, tr, td, th {border-collapse: collapse; border-spacing:0;}
                                    </style>
                                </head>
                            <body>
                                <div class="form-wrapper">
                                   <table  width="100%">
                                       <tbody>
                                            <tr>
                                               <td>
                                                   <table style="width:100%;border-bottom:1px solid #ddd;">
                                                       <tr>
                                                           <td align="left" style="width:30%; padding-bottom:10px;"><img src="'.base_url().'assets/images/logo.png" alt="" title="" style="width:150px;"></td>
                                                           <td align="center" style="width:50%;text-align:center; padding-bottom:10px;">
                                                               <span style="font-size:24px; display:block;letter-spacing:3px;">autocredits</span>
                                                                <span style="font-size:16px;display:block;font-style:italic; ">India LLP</span>
                                                               <span style="display:block;">Head Office: B-7, basement, Vardhman Rajdhani Plaza New Rajdhani Enclave Opp Pillar no 98, Main Vikas Marg, Delhi-92    </span>
                                                               <span style="display:block;">Ph.: 011-46560000</span>
                                                           </td>
                                                           <td align="right" style="width:20%; padding-bottom:10px; font-style:italic; font-size:14px; vertical-align:top;">Drive Your Dreams</td>
                                                       </tr>
                                                   </table>
                                               </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                   <table style="width:100%; padding-top:30px;font-size:14px;" border="1">
                                                     <tr>
                                                       <th colspan="4" style="background:#ddd;padding:5px; font-size:16px;">Refurbishment Workorder</th>
                                                     </tr>
                                                     <tr>
                                                       <td style="padding:5px;">Vehicle Reg. No.</td>
                                                       <td style="padding:5px; font-weight:bold">'.$reg_no.'</td>
                                                       <td style="padding:5px;">Office Cordinator</td>
                                                       <td style="padding:5px;font-weight:bold">'.$data[0]['office_cordinator'].'</td>
                                                     </tr>
                                                     
                                                     <tr>
                                                       <td style="padding:5px;">Model</td>
                                                       <td style="padding:5px; font-weight:bold">'.$model.'</td>
                                                       <td style="padding:5px;">Date of Workorder</td>
                                                       <td style="padding:5px;font-weight:bold">'.date('d-m-Y',strtotime($data[0]['date_of_workorder'])).'</td>
                                                     </tr>
                                                     
                                                       <tr>
                                                       <td style="padding:5px;">Workshop Name</td>
                                                       <td style="padding:5px; font-weight:bold">'.$data[0]['workshop_name'].'</td>
                                                       <td style="padding:5px;">Date of Refurb</td>
                                                       <td style="padding:5px;font-weight:bold">'.date('d-m-Y g:i A',strtotime($data[0]['date_of_refurb'])).'</td>
                                                     </tr>
                                                     
                                                     <tr>
                                                       <td style="padding:5px;">Workshop Manager Name</td>
                                                       <td style="padding:5px; font-weight:bold">'.$data[0]['workshop_manager_name'].'</td>
                                                       <td style="padding:5px;">Estd Date of Completion</td>
                                                       <td style="padding:5px;font-weight:bold">'.date('d-m-Y g:i A',strtotime($data[0]['date_of_completetion'])).'</td>
                                                     </tr>
                                                     <tr>
                                                       <td style="padding:5px;">KM (Before Refurb)</td>
                                                       <td style="padding:5px; font-weight:bold">'.indian_currency_form($data[0]['sent_km']).'</td>
                                                       <td style="padding:5px;">KM (After Refurb)</td>
                                                       <td style="padding:5px;font-weight:bold">'.indian_currency_form($data[0]['return_km']).'</td>
                                                     </tr>
                                                   </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                   <table style="width:100%; padding-top:30px;font-size:14px;" border="1">
                                                    <tr>
                                                        <th colspan="3" style="background:#ddd;padding:5px; font-size:16px;">No</th>
                                                        <th colspan="3" style="background:#ddd;padding:5px; font-size:16px;">Job Required</th>
                                                        <th colspan="3" style="background:#ddd;padding:5px; font-size:16px;">Estimated Amount</th>
                                                         <th colspan="3" style="background:#ddd;padding:5px; font-size:16px;">Actual Amount</th>
                                                    </tr>
                                                    '.$subHtml.'
                                                    <tr>
                                                        <td colspan="3" style="padding:5px;  font-weight:bold""></td>
                                                        <td colspan="3" style="padding:5px; font-weight:bold; font-size:16px;">Total</td>
                                                        <td colspan="3" style="padding:5px;  font-weight:bold; font-size:16px;"><img src="'.base_url().'assets/images/rupee-icon.png" style="width:11px; margin-top:3px;">'.indian_currency_form($data[0]['estimated_amt']).'</td>
                                                        <td colspan="3" style="padding:5px;  font-weight:bold; font-size:16px;">'.indian_currency_form($data[0]['actual_amt']).'</td>
                                                            
                                                    </tr>
                                                   </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                   <table style="width:100%; padding-top:30px;font-size:14px;" border="1">
                                                     <tr>
                                                       <th colspan="3" style="background:#ddd;padding:5px; font-size:16px;"></th>
                                                       <th colspan="3" style="background:#ddd;padding:5px; font-size:16px;">Signature</th>
                                                       <th colspan="3" style="background:#ddd;padding:5px; font-size:16px;">Date</th>
                                                     </tr>
                                                     <tr>
                                                       <td colspan="3" style="padding:5px;">Workshop Manager</td>
                                                       <td colspan="3" style="padding:5px; font-weight:bold"></td>
                                                       <td colspan="3" style="padding:5px;"></td>
                                                      
                                                     </tr>
                                                     
                                                      <tr>
                                                       <td colspan="3" style="padding:5px;">Office Cordinator</td>
                                                       <td colspan="3" style="padding:5px; font-weight:bold"></td>
                                                       <td colspan="3" style="padding:5px;"></td>
                                                      
                                                     </tr>
                                                     
                                                      <tr>
                                                       <td colspan="3" style="padding:5px;">HODr</td>
                                                       <td colspan="3" style="padding:5px; font-weight:bold"></td>
                                                       <td colspan="3" style="padding:5px;"></td>
                                                      
                                                     </tr>
                                                   </table>
                                                </td>
                                            </tr>   
                                       </tbody>
                                   </table>
                                <!-- main table -->
                                </div>
                            </body>
                            </html>';
        }

        return $html;
    }
    
    public function refurbUpdatedPdf($id){
        $sql       = "SELECT uc.reg_no , mv.db_version AS version, mm.model AS model, 
                    mm.make AS make, crd.refurb_details, crd.estimated_amt,crd.actual_amt,crd.sent_km,crd.return_km,crd.estimated_date AS date_of_completetion,
                    crd.sent_to_refurb AS date_of_refurb,crd.created_on AS date_of_workorder, crw.name AS workshop_name, crw.owner_name AS workshop_manager_name, cu.name AS office_cordinator,crd.is_refurb_done
                    FROM crm_used_car AS uc 
                    INNER JOIN model_version AS mv ON mv.db_version_id=uc.version_id
                    INNER JOIN make_model AS mm ON mm.id=mv.model_id
                    LEFT JOIN crm_refurb_details AS crd ON crd.car_id=uc.id 
                    INNER JOIN crm_refurb_workshop AS crw ON crw.id=crd.wc_id
                    INNER JOIN crm_user AS cu ON cu.id = crd.emp_id
                    WHERE crd.id=$id and crd.is_refurb_done='1'";

        $data       = $this->db->query($sql)->result_array();
        
        $html       = '';
        if(isset($data[0])){
            $reg_no     = $data[0]['reg_no'];
            $model      = $data[0]['make'].' '.$data[0]['model'].' '.$data[0]['version'];

            $details    = $data[0]['refurb_details'];

            $newArray   = [];
            for($i=1;$i<100;$i++){
               $new = explode($i.'. ',$details);
               if(isset($new[1]) && trim($new[1]) != ''){
                $j = $i+1;
                $temp = explode($j.'. ',trim($new[1]));
                $newArray[] = trim($temp[0]);
               }
            }

            $subHtml = '';
            foreach($newArray as $key => $value){
                $sn = intval($key)+1;
                $act_amt = '';
                $amt = '';
                
                if($sn == 1){ $amt = '<img src="'.base_url().'assets/images/rupee-icon.png" style="width:11px; margin-top:3px;">'. indian_currency_form($data[0]['estimated_amt']); }
                if($data[0]['is_refurb_done']=='1' && $sn==1){ 
                    $act_amt = '<img src="'.base_url().'assets/images/rupee-icon.png" style="width:11px; margin-top:3px;">'.indian_currency_form($data[0]['actual_amt']);
                }
                $subHtml .= '<tr>
                            <td colspan="3" style="padding:5px;  font-weight:bold"">'.$sn.'</td>
                            <td colspan="3" style="padding:5px; font-weight:bold">'.$value.'</td>
                            <td colspan="3" style="padding:5px;  font-weight:bold"">'.$amt.'</td> 
                            <td colspan="3" style="padding:5px;  font-weight:bold"">'.$act_amt.'</td>

                        </tr>';
            }
            

            $html       = '<!doctype html>
                            <html>
                                <head>
                                    <style>
                                        body {margin: 0;padding: 0;color: #000;font-family: Arial, Helvetica, sans-serif;width: 100%; font-size:12px;} 
                                        @page {margin-top: 25px;margin-bottom: 25px; margin-left: 30px;margin-right: 30px;}
                                        .clear { clear: both; }
                                        img { border: 0;outline: 0;}
                                        .form-wrapper { width: 100%;margin: 0 auto;padding: 0;}
                                        table, tr, td, th {border-collapse: collapse; border-spacing:0;}
                                    </style>
                                </head>
                            <body>
                                <div class="form-wrapper">
                                   <table  width="100%">
                                       <tbody>
                                            <tr>
                                               <td>
                                                   <table style="width:100%;border-bottom:1px solid #ddd;">
                                                       <tr>
                                                           <td align="left" style="width:30%; padding-bottom:10px;"><img src="'.base_url().'assets/images/logo.png" alt="" title="" style="width:150px;"></td>
                                                           <td align="center" style="width:50%;text-align:center; padding-bottom:10px;">
                                                               <span style="font-size:24px; display:block;letter-spacing:3px;">autocredits</span>
                                                                <span style="font-size:16px;display:block;font-style:italic; ">India LLP</span>
                                                               <span style="display:block;">Head Office: B-7, basement, Vardhman Rajdhani Plaza New Rajdhani Enclave Opp Pillar no 98, Main Vikas Marg, Delhi-92    </span>
                                                               <span style="display:block;">Ph.: 011-46560000</span>
                                                           </td>
                                                           <td align="right" style="width:20%; padding-bottom:10px; font-style:italic; font-size:14px; vertical-align:top;">Drive Your Dreams</td>
                                                       </tr>
                                                   </table>
                                               </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                   <table style="width:100%; padding-top:30px;font-size:14px;" border="1">
                                                     <tr>
                                                       <th colspan="4" style="background:#ddd;padding:5px; font-size:16px;">Refurbishment Workorder</th>
                                                     </tr>
                                                     <tr>
                                                       <td style="padding:5px;">Vehicle Reg. No.</td>
                                                       <td style="padding:5px; font-weight:bold">'.$reg_no.'</td>
                                                       <td style="padding:5px;">Office Cordinator</td>
                                                       <td style="padding:5px;font-weight:bold">'.$data[0]['office_cordinator'].'</td>
                                                     </tr>
                                                     
                                                     <tr>
                                                       <td style="padding:5px;">Model</td>
                                                       <td style="padding:5px; font-weight:bold">'.$model.'</td>
                                                       <td style="padding:5px;">Date of Workorder</td>
                                                       <td style="padding:5px;font-weight:bold">'.date('d-m-Y',strtotime($data[0]['date_of_workorder'])).'</td>
                                                     </tr>
                                                     
                                                       <tr>
                                                       <td style="padding:5px;">Workshop Name</td>
                                                       <td style="padding:5px; font-weight:bold">'.$data[0]['workshop_name'].'</td>
                                                       <td style="padding:5px;">Date of Refurb</td>
                                                       <td style="padding:5px;font-weight:bold">'.date('d-m-Y g:i A',strtotime($data[0]['date_of_refurb'])).'</td>
                                                     </tr>
                                                     
                                                     <tr>
                                                       <td style="padding:5px;">Workshop Manager Name</td>
                                                       <td style="padding:5px; font-weight:bold">'.$data[0]['workshop_manager_name'].'</td>
                                                       <td style="padding:5px;">Return Date</td>
                                                       <td style="padding:5px;font-weight:bold">'.date('d-m-Y g:i A',strtotime($data[0]['date_of_completetion'])).'</td>
                                                     </tr>
                                                     <tr>
                                                       <td style="padding:5px;">KM (Before Refurb)</td>
                                                       <td style="padding:5px; font-weight:bold">'.indian_currency_form($data[0]['sent_km']).'</td>
                                                       <td style="padding:5px;">KM (After Refurb)</td>
                                                       <td style="padding:5px;font-weight:bold">'.indian_currency_form($data[0]['return_km']).'</td>
                                                     </tr>
                                                   </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                   <table style="width:100%; padding-top:30px;font-size:14px;" border="1">
                                                    <tr>
                                                        <th colspan="3" style="background:#ddd;padding:5px; font-size:16px;">No</th>
                                                        <th colspan="3" style="background:#ddd;padding:5px; font-size:16px;">Job Required</th>
                                                        <th colspan="3" style="background:#ddd;padding:5px; font-size:16px;">Estimated Amount</th>
                                                         <th colspan="3" style="background:#ddd;padding:5px; font-size:16px;">Actual Amount</th>
                                                    </tr>
                                                    '.$subHtml.'
                                                    <tr>
                                                        <td colspan="3" style="padding:5px;  font-weight:bold""></td>
                                                        <td colspan="3" style="padding:5px; font-weight:bold; font-size:16px;">Total</td>
                                                        <td colspan="3" style="padding:5px;  font-weight:bold; font-size:16px;"><img src="'.base_url().'assets/images/rupee-icon.png" style="width:11px; margin-top:3px;">'.indian_currency_form($data[0]['estimated_amt']).'</td>
                                                        <td colspan="3" style="padding:5px;  font-weight:bold; font-size:16px;"><img src="'.base_url().'assets/images/rupee-icon.png" style="width:11px; margin-top:3px;">'.indian_currency_form($data[0]['actual_amt']).'</td>
                                                            
                                                    </tr>
                                                   </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                   <table style="width:100%; padding-top:30px;font-size:14px;" border="1">
                                                     <tr>
                                                       <th colspan="3" style="background:#ddd;padding:5px; font-size:16px;"></th>
                                                       <th colspan="3" style="background:#ddd;padding:5px; font-size:16px;">Signature</th>
                                                       <th colspan="3" style="background:#ddd;padding:5px; font-size:16px;">Date</th>
                                                     </tr>
                                                     <tr>
                                                       <td colspan="3" style="padding:5px;">Workshop Manager</td>
                                                       <td colspan="3" style="padding:5px; font-weight:bold"></td>
                                                       <td colspan="3" style="padding:5px;"></td>
                                                      
                                                     </tr>
                                                     
                                                      <tr>
                                                       <td colspan="3" style="padding:5px;">Office Cordinator</td>
                                                       <td colspan="3" style="padding:5px; font-weight:bold"></td>
                                                       <td colspan="3" style="padding:5px;"></td>
                                                      
                                                     </tr>
                                                     
                                                      <tr>
                                                       <td colspan="3" style="padding:5px;">HODr</td>
                                                       <td colspan="3" style="padding:5px; font-weight:bold"></td>
                                                       <td colspan="3" style="padding:5px;"></td>
                                                      
                                                     </tr>
                                                   </table>
                                                </td>
                                            </tr>   
                                       </tbody>
                                   </table>
                                <!-- main table -->
                                </div>
                            </body>
                            </html>';
        }

        return $html;
    }

    public function downloadRefurbPdf()
    {
        //echo UPLOAD_IMAGE_PATH_LOCAL; exit;
        $file_name = $_GET['file'];
        //$file_path='/var/www/cdn/deliverydocs/'.$file_name;
        $file_path  =UPLOAD_IMAGE_PATH_LOCAL.'refurbDoc/'.$file_name;
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        flush(); // Flush system output buffer
        readfile($file_path);
        exit;
    }
    public function markSold()
    {
        $car_id = $this->input->post('car_id');
        $edit_link = $this->input->post('edit_link');

       // $updated = $this->crm_stocks->updateMarktoSold(['car_status' => '3'], $car_id);
        $updated = true;
        if ($updated)
        {
            $result = array('status' => true, 'message' => 'Stock Marked As Sold', 'Action' => $edit_link);
        }
        else
        {
            $result = array('status' => false, 'message' => 'Something Went Wrong!');
        }
        exit(json_encode($result));
    }
    public function cancelBooking()
    {
        $car_id = $this->input->post('car_id');

        $caseData             = $this->Crm_used_car_sale_case_info->getUcSalesCaseByCarid($car_id);
        $case_id              = $caseData['id'];
        
        $caseUpdated=$this->Crm_used_car_sale_case_info->saveUpdateCaseInfo(['status'=>'0'],$case_id);
        
        $updated = $this->crm_stocks->updateMarktoSold(['car_status' => '1'], $car_id);
        
        if ($updated && $caseUpdated)
        {
            $result = array('status' => true, 'message' => 'Booking has been canceled', 'Action' => base_url('inventoryListing/'));
        }
        else
        {
            $result = array('status' => false, 'message' => 'Something Went Wrong!');
        }
        exit(json_encode($result));
    }
    public function reconcillationList(){
        
        $this->loadViews("stock/reconcillation_list", $this->global, $data=[], NULL);
    }
    public function getTallyList(){
        $filter   = $this->input->get();
        $dealer_id = DEALER_ID;
        $isExists= $this->crm_stocks->getNumOfKeysByDate($filter['filter_date'],$dealer_id);
        $data['keys']=$isExists;
        $data['filter_date']=$filter['filter_date'];
        $data['search_by']=$filter['search_by'];
        $data['status']=$filter['status'];
        
        $filter_array       = [
            'date'         => $filter['filter_date'],
            'filter_value' => $filter['search_by'],
            'dealer_id'    => $dealer_id,
            'status'       => $filter['status'],
        ];
            //print_r($temporary_stocka);die;
        if ($isExists)
        {
            $data['stock_list'] = $this->crm_stocks->getTallyRecord($filter_array);
            $temporary_stock = $this->crm_stocks->getTallyRecordForTempStocks($filter_array);
            $data['stock_list']=array_merge($data['stock_list'],$temporary_stock);
            
           // print_r($data['stock_list']);die;
        }
        else
        {
            $data['stock_list'] = $this->crm_stocks->getStockListForTally($filter_array);
            $temporary_stock = $this->crm_stocks->getTemporaryStockList($filter_array);
            //print_r($temporary_stock);
            $data['stock_list']=array_merge($data['stock_list'],$temporary_stock);
        }
        //echo '<pre>';print_r($data['stock_list']);die;
        $data['mmList']   = $this->UserDashboard->getMakeModelList();
        //echo '<pre>';print_r($mmList);die;
        //print_r($data['stock_list']);
       // print_r($_COOKIE);die;

        //print_r($data['stock_list']);die;
        echo $this->load->view('stock/tally_list', $data);
    }
    public function saveReconcillationList(){
        $tally_data          = $this->input->post('tally_status');
        $no_keys_in_showroom = $this->input->post('in_showroom');
        $no_keys_in_office   = $this->input->post('in_office');
        $date   = $this->input->get('date');
        $dealer_id           = DEALER_ID;
        
        $isExists= $this->crm_stocks->getNumOfKeysByDate($date,$dealer_id);
       // print_r($this->input->post('tally_status'));die;

        $counter_for_in=0;
        $counter_for_out=0;
        $batch_record=[];
        //print_r($tally_data);
        $batch_update=[];
        foreach($tally_data as $tally_record){
             if($tally_record['status']==1){
                 $counter_for_in++;
             }
             if($tally_record['status']==2){
                 $counter_for_out++;
             }
            $temp_stock= preg_match('/[0-9]*_T$/', $tally_record['stock']);
            
            if($temp_stock==1){
                $reco_id= preg_replace('/_T/', '',$tally_record['stock']);
                $batch_update[] = [
                    'id'     => $reco_id,
                    'status' => $tally_record['status'] == 5 ? '3' : $tally_record['status']==6?'2':1,
                ];
            }
             $batch_record[] = [
                'car_id'       => $temp_stock==0?$tally_record['stock']:null,
                'reco_car_id'  => $temp_stock==1?preg_replace('/_T/', '',$tally_record['stock']):null,
                'status'       => $tally_record['status'],
                'assigned_to'  => $tally_record['assigned_to'],
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
            ];
        }
        //print_r($batch_record);die;
        //echo $counter_for_in.' '.$counter_for_out;die;
        if($counter_for_in!=$no_keys_in_showroom){
            exit(json_encode(['status'=>false,'msg'=>'Number of keys in showroom doesn\'t match']));
        }
        if($counter_for_out!=$no_keys_in_office){
            exit(json_encode(['status'=>false,'msg'=>'Number of keys in office doesn\'t match']));
        }
        
        $key_record = [
            'dealer_id'    => $dealer_id,
            'keys_in'      => $no_keys_in_showroom,
            'keys_out'     => $no_keys_in_office,
            'created_date' => date('Y-m-d H:i:s'),
            'updated_date' => date('Y-m-d H:i:s'),
            'updated_date' => date('Y-m-d H:i:s'),
        ];
        if ($isExists)
        {
            $key_record['updated_by']=$_SESSION['userinfo']['id'];
            $key_recorded = $this->db->update('crm_stock_keys_log', $key_record, array('id' => $isExists['id']));
            //archive old record
            $this->db->update('crm_stock_tally_log',['archived'=>'1'],['archived'=>'0','date(created_date)'=>date('Y-m-d', strtotime($date))]);
        }
        else
        {
            $key_record['created_by']=$_SESSION['userinfo']['id'];
            $key_record['updated_by']=$_SESSION['userinfo']['id'];
            
            $key_recorded = $this->db->insert('crm_stock_keys_log', $key_record);
        }
       $last_id =null;
       if($key_recorded){
           $this->db->update_batch('crm_reco_stock', $batch_update, 'id');
           $last_id=$this->db->insert_batch('crm_stock_tally_log', $batch_record);           
       }
       if(!empty($last_id)){
          exit(json_encode(['status'=>true,'msg'=>'Tally Saved Successfully'])); 
       }
       else{
          exit(json_encode(['status'=>true,'msg'=>'Oops!  something went wrong']));  
       }
        //print_r($batch_record);die;
    }
    public function saveRecoStock(){
      
        $make_year      = $this->input->post('make_year');
        $make_model_ids = $this->input->post('make_model');
        $version_id     = $this->input->post('version');
        $reg_no         = $this->input->post('reg_no');
        //print_r($this->input->post(''));die;;
        $dealer_id           = DEALER_ID;
       
        
       if(empty($make_year)){
          exit(json_encode(['status'=>FALSE,'msg'=>'Please Select Make Year'])); 
       }
       elseif(empty($make_model_ids)){
          exit(json_encode(['status'=>FALSE,'msg'=>'Please Select Make Model'])); 
       }
       elseif(empty($version_id)){
          exit(json_encode(['status'=>FALSE,'msg'=>'Please Select Version'])); 
       }
       elseif(empty($reg_no)){
          exit(json_encode(['status'=>FALSE,'msg'=>'Please Enter Registration No.'])); 
       }
       
        $stock_exists      = $this->db->select('*')->from('crm_used_car')->where('reg_no', $reg_no)->get()->row_array();
        $reco_stock_exists = $this->db->select('*')->from('crm_reco_stock')->where('reg_no', $reg_no)->get()->row_array();
        if (!empty($stock_exists) || !empty($reco_stock_exists))
        {
            exit(json_encode(['status' => FALSE, 'msg' => 'This Registration No. Car Already Exists!']));
        }
        
        $insert_data  = [
            'version_id'   => $version_id,
            'make_year'    => $make_year,
            'reg_no'       => strtoupper($reg_no),
            'dealer_id'    => $dealer_id,
            'created_date' => date('Y-m-d'),
            'updated_date' => date('Y-m-d'),
            'status' => '1',
        ];
        $last_id = $this->db->insert('crm_reco_stock', $insert_data);
        if($last_id){
            exit(json_encode(['status'=>true,'msg'=>'Stock Saved Successfully!'])); 
        }
        else{
            exit(json_encode(['status'=>FALSE,'msg'=>'Something Went Wrong!'])); 
        }
        //print_r($batch_record);die;
    }
    public function incrCount(){
        //print_r($this->input->post());
        $tally_data          = $this->input->post('tally_status');
        
        $count=['in'=>0,'out'=>0,'oth'=>0,'r'=>0,'d'=>0,'rem'=>0,'t'=>0];
        foreach($tally_data as $tally_record){
             if($tally_record['status']==1){
                 $count['in']++;
             }
             if($tally_record['status']==2){
                 $count['out']++;
             }
             if($tally_record['status']==3){
                 $count['oth']++;
             }
             if($tally_record['status']==4){
                 $count['r']++;
             }
             if($tally_record['status']==5){
                 $count['d']++;
             }
             if($tally_record['status']==6){
                 $count['rem']++;
             }
             $count['t']=$count['in']+$count['out']+$count['oth']+$count['r']+$count['d']+$count['rem'];
        }

            exit(json_encode($count));
        
    }
    public function getVersion()
    {
        $make_model  = $this->input->post('mm_id');
        $mm_id       = explode('_', $make_model);
        $model_id    = $mm_id[1];
        $versionList = $this->UserDashboard->getVersionByModelId($model_id);
        $option      = '<select class="form-control testselect1 "  name="version" id="version_id" >
                        <option value="0">Select Version</option>
                        ';
        foreach ($versionList as $version)
        {
            $option .= ' <option value="' . $version['db_version_id'] . '">' . $version['db_version'] . '</option>';
        }
        $option.='</select> ';
        exit($option);
    }
    public function reco_pdf()
    {
        require_once(APPPATH . "third_party/dompdf/dompdf_config.inc.php");
        $filter              = $this->input->get();
        $dealer_id           = DEALER_ID;
        $isExists            = $this->crm_stocks->getNumOfKeysByDate($filter['filter_date'], $dealer_id);
        
        $data['updated_by']      = $this->db->select('name')->from('crm_user')->where('id', $isExists['updated_by'])->get()->row_array();
        
        $data['keys']        = $isExists;
        $data['filter_date'] = $filter['filter_date'];
        
        
        $filter_array = [
            'date'         => $filter['filter_date'],
            'filter_value' => $filter['search_by'],
            'dealer_id'    => $dealer_id,
            'status'       => $filter['status'],
        ];
        //print_r($temporary_stocka);die;
        if ($isExists)
        {
            $record = $this->crm_stocks->getTallyRecord($filter_array);
            $temporary_stock    = $this->crm_stocks->getTallyRecordForTempStocks($filter_array);
            $record = array_merge($record, $temporary_stock);

        }
$new_stock_new=[];
$i=0;$counter=1;
$data['refurb_count']=$data['delivered_count']=$data['in_count']=$data['out_count']=$data['other_count']=$data['removed_count']=0;
foreach($record as $stock_list){
    
    $new_stock_new[$i][]=$stock_list;
    $counter++;
    if($counter>27){
        $i++;
        $counter=1;
    }
    if(isset($stock_list['tally_status']) && $stock_list['tally_status']==1){
        $data['in_count']++;
    }
    elseif(isset($stock_list['tally_status']) && $stock_list['tally_status']==2){
        $data['out_count']++;
    }
    elseif(isset($stock_list['tally_status']) && $stock_list['tally_status']==3){
        $data['other_count']++;
    }
    elseif(isset($stock_list['tally_status']) && $stock_list['tally_status']==4){
        $data['refurb_count']++;
    }
    elseif(isset($stock_list['tally_status']) && $stock_list['tally_status']==6){
        $data['removed_count']++;
    }
    elseif(isset($stock_list['tally_status']) && $stock_list['tally_status']==5){
        $data['delivered_count']++;
    }
}
$data['new_stock_list']=$new_stock_new;
$data['no_pages']=count($new_stock_new);
//print_r($data);die;
        $html = $this->load->view('stock/reconcillation_pdf',$data , true);
        $time     = time();
        $filename = 'reco_'.$filter_array['date'].'_'.$time . '.pdf';
        $folder_name = 'reconcillation';
        $dompdf        = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $output        = $dompdf->output();
        
        $upload_folder = UPLOAD_IMAGE_PATH_LOCAL . $folder_name.'docs/';
        is_dir($upload_folder) || mkdir($upload_folder, 0777, true);

        file_put_contents($upload_folder . $filename, $output);
        echo json_encode(['file_name' => $filename, 'type' =>$folder_name, 'status' => true, 'msg' => 'File Downloaded Successfully']);
        exit;
    }

}
