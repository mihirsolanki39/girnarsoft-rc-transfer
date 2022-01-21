<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class UserDashboard extends CI_Model
{

    public $activity_mapping    = array('status' => '1', 'comment' => '2', 'followup' => 3, 'call' => 4, 'share' => 5, 'feedback' => 6,'walkindate'=>7);
    
    
    public function __construct()
    {
        parent::__construct();
    }

    public function updateCarStatus($car_id)        
    {       
        $data['car_status'] = '6';      
        $this->db->where('id', $car_id);        
        $this->db->update('crm_used_car', $data);       
        
    }
    public function formatInIndianStyle($num) {
        $pos = strpos((string) $num, ".");
        if ($pos === false) {
            $decimalpart = "";
        } else {
            $decimalpart = "." . substr($num, $pos + 1, 2);
            $num = substr($num, 0, $pos);
        }

        if (strlen($num) > 3 & strlen($num) <= 12) {
            $last3digits = substr($num, -3);
            $numexceptlastdigits = substr($num, 0, -3);
            $formatted = $this->makecomma($numexceptlastdigits);
            $stringtoreturn = $formatted . "," . $last3digits . $decimalpart;
        } elseif (strlen($num) <= 3) {
            $stringtoreturn = $num . $decimalpart;
        } elseif (strlen($num) > 12) {
            $stringtoreturn = number_format($num, 2);
        }

        if (substr($stringtoreturn, 0, 2) == "-,") {
            $stringtoreturn = "-" . substr($stringtoreturn, 2);
        }

        return $stringtoreturn;
    }

    public function makecomma($input) {
        if (strlen($input) <= 2) {
            return $input;
        }
        $length = substr($input, 0, strlen($input) - 2);
        $formatted_input = $this->makecomma($length) . "," . substr($input, -2);
        return $formatted_input;
    }
    public function getRegCityListArr()
    {
        $this->load->database();
       // $qry = "SELECT * from  ".CENTRAL_CITY_LIST."  where con_id=1 ORDER BY order_by,city_name  ASC";
        $this->db->order_by('order_by','asc');
        $this->db->order_by('city_name','asc');
       $qrys = $this->db->get_where(CENTRAL_CITY_LIST,array('con_id'=>'1'));
        return $qrys      = $qrys->result_array();
    }

    public function getCarMakeList($car_type = 'new', $fields = '*', $where = 'WHERE 1=1',$orderBy=null,$orderFlag=null) {
        $this->load->database();
        if ($car_type == 'new')
            $where.= " AND dis_cont=0";
        if ($car_type == 'used')
            $where.= " AND dis_cont not in(2)";
        if ($car_type == 'upcoming')
            $where.= " AND dis_cont in(0,2)";
        if ($car_type == 'all')
            $where.= " AND dis_cont in(0,1,2)";
        if ($orderBy != '')
            $orderBy = " ORDER BY " . $orderBy . " " . $orderFlag . ",make asc";
        else
            $orderBy = " ORDER BY make asc";
        $sql = "SELECT $fields FROM ".CAR_MAKE." " . $where . $orderBy;
        $res = $this->db->query($sql);
        return  $res->result_array();
    }

    public function getCarModelList($car_type = 'new', $fields = '*', $orderby = 'model', $where = 'where 1=1', $flag = 'asc', $offset = 0, $limit = 0) {
         $this->load->database();
        if ($limit > 0) {
            $limitStr = " LIMIT $offset,$limit";
        }
        if ($car_type == 'new')
            $sql = "select  $fields from " . MAKE_MODEL . " $where AND dis_cont=0 order by $orderby $flag";
        elseif ($car_type == 'used')
            $sql = "select  $fields from " . MAKE_MODEL . " $where AND dis_cont in ('0','1') order by $orderby $flag";
        elseif ($car_type == 'upcoming')
            $sql = "select  $fields from " . MAKE_MODEL . " $where AND dis_cont = 2 order by $orderby $flag $limitStr";
        elseif ($car_type == 'new_upcoming')
            $sql = "select  $fields from " . MAKE_MODEL . " $where AND dis_cont in (0,2) order by $orderby $flag";
        else
            $sql = "select  $fields from " . MAKE_MODEL . " $where order by dis_cont,$orderby $flag";

       $res = $this->db->query($sql);
        return  $res->result_array();
       // $str = $this->db->last_query(); 
    }
    public function getCarModelListNew($car_type = 'new', $fields = '*', $orderby = 'model', $where = 'where 1=1', $flag = 'asc', $offset = 0, $limit = 0) {
         $this->load->database();
         $sql = "select  $fields from " . MAKE_MODEL . " $where AND dis_cont in (0,1,2) order by $orderby $flag";
         $res = $this->db->query($sql);
        return  $res->result_array();
    }

    public function getCarVersionList($model, $car_type = 'new',$fields = '*', $orderby = 'uc_fuel_type,db_version', $where = 'WHERE 1=1',$year='') {
         $this->load->database();
        if ($car_type == 'new')
            $sql = "select  $fields from " . MODEL_VERSION . " $where  AND dis_cont=0 ORDER BY $orderby desc";
        elseif ($car_type == 'used')
            $sql = "select  $fields from " . MODEL_VERSION . "  $where AND dis_cont in ('0','1') order by $orderby desc";
        elseif ($car_type == 'sell')
             $sql = "select  * from " . MODEL_VERSION . " WHERE db_version_model='".$model."' order by db_version";
        elseif ($car_type == 'all')
            $sql = "select  $fields from " . MODEL_VERSION . " $where ORDER BY $orderby desc";
        else
            $sql = "select  $fields from " . MODEL_VERSION . " $where AND dis_cont in ('0','1') ORDER BY $orderby desc";

        $res = $this->db->query($sql);
        return  $res->result_array();
    }
    public function getCarVersionListNew($fields = '*',  $where = 'WHERE 1=1',$myear,$model) {
         $this->load->database();
         $sql = "select  $fields from " . MAKE_MODEL . " $where  AND dis_cont in (0,1,2) ";
         $res = $this->db->query($sql);
         $versionData= $res->result_array();
         if($model>='1'){
            $model_ids=$model.',';
        }
         $vers=[];
         if(!empty($versionData)){
             foreach($versionData as $vdata){
                 $model_ids.=$vdata['id'].",";
             } 
            $model_ids=rtrim($model_ids,',');
         }else{
             $model_ids=rtrim($model_ids,',');
         }
         if(!empty($model_ids)){
 //$sqlv = "select  db_version_id,db_version,Displacement,uc_fuel_type from " . MODEL_VERSION . " where model_id in(".$model_ids.") AND s_year <='".$myear."' AND (e_year >='".$myear."' OR  e_year ='0') AND dis_cont in (0,1) ";
      $sqlv = "select  db_version_id,db_version,Displacement,uc_fuel_type from " . MODEL_VERSION . " where model_id in(".$model_ids.")  AND dis_cont in (0,1,2) ";
    
        $resv = $this->db->query($sqlv);
         $vers= $resv->result_array();
         }
         return $vers;
    }    
 
    function getFuelTypeForVersion($version)
        {
                    $query = 'SELECT distinct(uc_fuel_type) FROM `model_version` WHERE db_version="'.$version.'" limit 1';
                    $fuelType = $this->db->query($query);
                    return $fuelType->result_array();
        }
    public function getColors(){
          $this->load->database();
         //$sql = "select * from ".COLORS." where status='1'";
         $res = $this->db->get_where(COLORS,array('status','1'));
         $abc = $res->result_array();
        //echo "<pre>";
        // print_r($abc); exit;
         return $abc;
    }

    public function getfuelTrans($model,$version){
         $this->load->database();
         $where = " mm.id = mv.model_id and mm.id='".$model."' and mv.db_version='". $version."'";
       /// $sql = "SELECT mv.uc_fuel_type as FuelType,mv.uc_transmission as TransmissionType,mv.uc_body_type as body_style FROM " . MODEL_VERSION . " AS mv LEFT JOIN " . MAKE_MODEL . " AS mm ON mm.make_id = mv.mk_id WHERE mm.id = mv.model_id and mm.make='".$make."' and mm.model='".$model."' and mv.db_version='". $version."'";
            $this->db->select(' mv.uc_fuel_type as FuelType,mv.uc_transmission as TransmissionType,mv.uc_body_type as body_style');
            $this->db->from(MODEL_VERSION.' as mv');
            $this->db->join(MAKE_MODEL.' as mm',' mm.make_id = mv.mk_id','left');
            $this->db->where($where);
         $res = $this->db->get();
        return  $res->result_array();
       // return $this->db->query($sql);
    }

    public function getFeatures($car_id){
        $this->load->database();
        $sql = $this->db->get_where(USED_CAR_MODEL_DETAILS,array('carID' => $car_id));
       return  $sql->result_array();
    }

    public function getColorVariant($model,$version){
        $this->load->database();
        $where =" c.model='".$model."' and c.version='".$version."'";
        //$sql = "select ColorName as name from ".COLORVARIANT." as c left join  ".CARCOLOR." as cc on cc.ColorId=c.ColorId where c.make='".$make."' and c.model='".$model."' and c.version='".$version."'";
        $this->db->select(' ColorName as name');
            $this->db->from(COLORVARIANT.' as c');
            $this->db->join(CARCOLOR.' as cc',' cc.ColorId=c.ColorId ','left');
            $this->db->where($where);
         $res = $this->db->get();
        return  $res->result_array();
    }

    public function getCertifiedList() {
         $this->load->database();
        $getCertiFication = $this->db->get_where('dc_dealer_certifications',array('status' => '1' ));
      // $res = $this->db->query($sql);
        return  $getCertiFication->result_array();
    }

    /*public function getShowRooms() {
        $this->load->database();
        $selectshowrooms = $this->db->query("select * from dc_showrooms where dealer_id=" . $_SESSION['ses_dealer_id'] . " and status='1'");
        return $selectshowrooms->result_array();
    }

    public function getOffersAll() {
        $this->load->database();
        $getOffers = $this->db->query("select * from usedcar_offers where  status='1'");
        return $getOffers->result_array();
    }

    public function getd2dmobile($dealerid) {
         $this->load->database();
        $getdealermobile = $this->db->query("select dealer_mobile from dealer where  id=" . $dealerid);
        $getdealermobile = $getdealermobile->result_array();
        return $getdealermobile[0]['dealer_mobile'];
    }
    
    public function getcardekhoid($dealerid) {
         $this->load->database();
        $cardekhoid = $this->db->query("select upload_inventory_on_cardekho from dealer where  id=" . $dealerid);
         $cardekhoid = $cardekhoid->result_array();
        return $cardekhoid[0]['upload_inventory_on_cardekho'];
    }
*/
    public function getDumpTable($tableName) {
         $this->load->database();
        $tableDump = $this->db->get($tableName);
         $tableDump = $tableDump->result_array();
        return $tableDump;
    }

    /*public function getLocalitiesFromCity($get) {
         $this->load->database();
        $tableDump = $this->db->query("select * from locality where cid=".$get['cityid']." and status='1'  and localityname LIKE '%".$get['q']."%'  limit 0,10");
        $tableDump = $tableDump->result_array();

        return $tableDump;
    }*/

    public function getVersionByName($req)
    {
            $this->load->database();
            $dis_cont = array('0','1');
            $this->db->where_in('dis_cont',$dis_cont);
            $mmv = $this->db->get_where(MODEL_VERSION,array('db_version' => $req['version_name']));
            $mmv = $mmv->result_array();
            return $mmv[0];
    }

    public function getCityById($req)
    {
        $this->load->database();
        $this->db->order_by('order_by asc, city_name asc');
       
        $data = $this->db->get_where(CENTRAL_CITY_LIST,array('city_id'=>$req['city_id'],'con_id'=>'1'));
        $data = $data->result_array();
        return $data;
    }

    public function getOnRoadPrice($city_name, $version_id)
    {
        $this->load->database();
        $this->db->select('t.id,opa.ex_showroom,opa.registration,opa.insurance,opa.logistic');
        $this->db->from(ORP_ACTUAL_PRICE.' as opa');
        $this->db->join(TECHNICAL_SPECIFICATION.'  as t', 't.id=opa.technical_specification_id','inner');
        $this->db->where(array('opa.city' => $city_name, 't.version_id' => $version_id));
        $query = $this->db->get();
        $res = $query->result_array();
        $orp = !empty($res) ? $res[0]['ex_showroom'] + $res[0]['registration'] + $res[0]['insurance'] + $res[0]['logistic'] : '';
        if (!empty($orp))
        {
            return ['data'     => [
                    'OnRoadprice' => $orp,
                ],
                'metaData' => [
                    'message' => 'success',
                    'status'  => 'true'
                ]
            ];
        }
        else
        {
            return ['data'     => [
                    'OnRoadprice' => '',
                ],
                'metaData' => [
                    'message' => 'no data found',
                    'status'  => 'true'
                ]
            ];
        }
    }

    public function getMakeModelVersionId($make, $model, $version)
    {
            $this->load->database();
            $dis_cont = array('0','1');
            $this->db->where_in('mm.dis_cont',$dis_cont);
            $this->db->where_in('mv.dis_cont',$dis_cont);
            $this->db->where(array('mm.make'=>$make,'mm.model'=>$model,'mv.db_version'=>$version));
            $this->db->select('mm.make_id,mv.model_id,mv.db_version_id,mv.uc_fuel_type,mv.uc_body_type,mv.uc_transmission');
            $this->db->from(MAKE_MODEL . ' as mm');
            $this->db->join(MODEL_VERSION . ' as mv','mm.id=mv.model_id');
            $mmv = $this->db->get();
            $mmv = $mmv->result_array();
            return $mmv;
    }

   /* public function getDealerDetails($dealer_id=0)
    {
          $this->load->database();
        if(intval($dealer_id) > 0){
            $sql = 'select d.id,d.status,du.name,du.user_name,du.email,du.mobile,cl.city_name ,ds.attribute_value classified_limit,'
                . ' s.city_id,ts.domain from ' . DC_DEALERS . ' d '
                . ' inner join '.DC_DEALER_USER_MAPPING.' dum  on d.id=dum.dealer_id and dum.status="1"  '
                . ' inner join '.DC_DEALER_USER.' du on dum.user_id=du.id  and du.status="1"  '
                . ' inner join '.DC_DEALER_TEMPLATE_SETTINGS.' ts on ts.dealer_id=d.id    '
                . ' left join '.DC_SHOWROOMS.' s on s.dealer_id=d.id and s.is_primary="1" and s.status="1" '
                . ' left join '. CENTRAL_CITY_LIST.' cl on cl.city_id=s.city_id '
                . ' left join '.DC_DEALERS_SERVICES.' ds on ds.dealer_id=d.id and ds.status="1" and ds.sku_id="1" and ds.attribute_id="8" '
                    . ' where d.id='. $dealer_id;
            $data = $this->db->query($sql);
            $data = $data->result_array();
            return $data[0];
        } else {
            return array();
        }
    }
*/
    public function checkDuplicateEntry($version='',$km='',$pricefrom='',$car_id='')
    {
        $err = [];
        $this->load->database();
        //$car_id             = "";
        if($car_id>0)
        {
            $this->db->where('id!=',$car_id);
        }
        
        $selectInventory    =  array();
        $selectInventory = $this->db->get_where(CENTRAL_USED_CAR,array('version_id'=>$version,'km_driven'=>$km,'car_price'=>$pricefrom,'dealer_id'=>DEALER_ID));
        $selectInventory = $selectInventory->result_array();

        if(empty($selectInventory))
        {           
            return $err='1';
        }
        else
        {
            return $err='0';
        }
    }

    public function manageInventory($data,$dealer_id){
       $resul = [];
        $this->load->database();
       
        $usedcarother = [];
        $colour   = $data['color'];
        if ($data['color'] == 'Other')
        {
            $data['color'] = $data['othercolor'];
        }
        $purchase_case_id = $data['caseid'];
        $dataArray         =   array();
        if(intval($data['carid']) == 0)
        $dataArray['dealer_id']                 = $dealer_id;

        $dataArray['version_id']                = $data['version_id'];
        $selectShowrooms = $this->db->get_where(CRM_OUTLET,array('dealer_id'=>$dealer_id,'status'=>'1'));
        $selectShowrooms = $selectShowrooms->result_array();
        $dataArray['showroom_id'] = $selectShowrooms[0]['id'];
        $dataArray['city_id']                   = $data['regcity'];
        $dataArray['reg_place_city_id']         = $data['regcity'];
        //$dataArray['domain_id']                 = $data['version_id'];
        $dataArray['car_status']                = '1';
        $dataArray['km_driven']                 = $data['realkm'];
        $dataArray['car_price']                 = !empty($data['realprice'])?str_replace(',','',$data['realprice']):str_replace(',','',$data['pricegaadi']);
        $dataArray['colour']                    = $data['color'];
        $dataArray['owner_type']                = (isset($data['owner']))?$data['owner']:'0';
        $dataArray['make_month']                = $data['month'];
        $dataArray['make_year']                 = $data['year'];
        $dataArray['min_selling_price'] = str_replace(',','',$data['min_selling_price']);

        if(trim($data['insurance']) == '0')
            $dataArray['insurance_type']        = 'No Insurance';
        else if(trim($data['insurance']) == '1')
            $dataArray['insurance_type']        = 'Comprehensive';
        else if(trim($data['insurance']) == '2')
            $dataArray['insurance_type']        = 'Third Party';

        $jiyear = explode('-',$data['insdate']);
        if($data['insurance']!='No Insurance'){
        $dataArray['insurance_exp_year']        = $jiyear[2];
        $dataArray['insurance_exp_month']       = $jiyear[1];
        $dataArray['insurer_id']                = $data['insurer_id'];
        $dataArray['insurance_policy_no']       = $data['insurance_pol_no'];
    }
        $regNo=preg_replace('/[^A-Za-z0-9\-]/', '', $data['reg']);
        $dataArray['insurance_type'] = $data['insurance'];
        $dataArray['reg_no']                    = strtoupper($regNo);
         $dd = [];
        if(!empty($data['reg_year']) && ($data['reg_year']!='0000-00-00'))
        {
           $dd = explode('-', $data['reg_year']);
      
        }
            $dataArray['reg_month']                 = (!empty($dd[1]))?$dd[1]:'0';
            $dataArray['reg_year']                  = (!empty($dd[2]))?$dd[2]:'0';
          if(isset($data['showsite']))
            $dataArray['is_reg_no_show']        = '1';
        else
            $dataArray['is_reg_no_show']        = '0'; 

        $dataArray['reg_rto_city']              ='0' ;//$data['regcityrto'];

        if(isset($data['cngfitment']) && $data['cngfitment'] == 'yes')
            $dataArray['is_cng_fitted']         = '1';
        else
            $dataArray['is_cng_fitted']         = '0';   

        if($data['tax'] == '1') 
        $dataArray['tax_type']                  = 'Corporate';
        else
        $dataArray['tax_type']                  = 'Individual';

        if($data['as-values-cid'] != '') 
        $dataArray['locality_names']            = $data['as-values-cid'];
        else
        $dataArray['locality_names']            = 'A F Rajokari';

        $dataArray['user_type']                 = 'dealer';
        $dataArray['car_description']           = !empty($data['additionaldetail'])?addslashes($data['additionaldetail']):'NA';
        $dataArray['special_offer']             = !empty($data['offer'])?$data['offer']:'NA';
        if(intval($data['carid']) == 0)
        $dataArray['created_date']              = date('Y-m-d H:i:s');
        $dataArray['last_update_date']          = date('Y-m-d H:i:s');
        //$dataArray['source']                    = $data['version_id'];
        $dataArray['ip_address']                = $this->getClientIp();      
        if(isset($data['isclassified']) && ($data['isclassified']=='1'))
        {
            $dataArray['is_gaadi']  = '1';
            $dataArray['is_cardekho']  = '1';
        }
         $usedcarother['listing_price']                 = str_replace(',','',$data['realprice']);
         //$usedcarother['tradetype'] = $data['tradetype'];
         $usedcarother['engineno'] = $data['engineno'];
         $usedcarother['chassisno'] = $data['chassisno'];
         $usedcarother['rto'] = !empty($data['rto'])?$data['rto']:'0';
         $usedcarother['rtostate'] = !empty($data['rto_state'])?$data['rto_state']:'0';
         //$usedcarother['refurb'] = $data['refurb'];
         $usedcarother['hypo'] = $data['hypo'];
         $usedcarother['reg_date'] = date('Y-m-d',strtotime($data['reg_year']));
         $usedcarother['bank_id'] = !empty($data['bank_list'])?$data['bank_list']:'';
         $usedcarother['paidoff'] = $data['paidoff'];
         $usedcarother['case_id'] = $data['caseid'];
         $usedcarother['insurance_date'] = date('Y-m-d',strtotime($data['insdate']));
         $usedcarother['commission'] = str_replace(',','',$data['commission']);
         $usedcarother['rent'] = str_replace(',','',$data['rent']);
         $usedcarother['refurb_cost'] = str_replace(',','',$data['refurb_cost']);
         $usedcarother['misc_exp'] = str_replace(',','',$data['misc_exp']);
         $usedcarother['insurance'] = str_replace(',','',$data['insurance_add']);
         $usedcarother['permit'] = $data['permit'];
         $usedcarother['permitvalid'] = ($data['permit']=='2')?date('Y-m-d',strtotime($data['permitvalid'])):'';
         $usedcarother['road_tx'] = $data['road_tx'];
         $usedcarother['road_txvalid'] =($data['road_tx']=='2')?date('Y-m-d',strtotime($data['road_txvalid'])):'';
         $usedcarother['fitness_certi'] = $data['fitness_certi'];
         $usedcarother['fitvalid'] = ($data['fitness_certi']=='2')?date('Y-m-d',strtotime($data['fitvalid'])):'';
          $usedcarother['reg_type'] = $data['reg_type'];
        $car_id         = '';

        //////////////$checkDuplicate = $this->checkDuplicateEntry($data['version_id'],$data['realkm'],$data['realprice'],$data['carid']);
        //$res = $this->crmToDcUsedcarSyn($dataArray);
      
       $dcData                  = $dataArray;
       $dcData['registeredcar'] = $data['registeredcar'];
       
      
        $getClassifiedStatus=$this->db->select('is_gaadi,is_feature')->from('crm_used_car')->where('id',$data['carid'])->get()->row_array();
        $dcData['is_gaadi']   = !empty($getClassifiedStatus['is_gaadi']) ? $getClassifiedStatus['is_gaadi'] : '0';
        $dcData['is_feature']       = !empty($getClassifiedStatus['is_feature'])?$getClassifiedStatus['is_feature']:'0';
        $dcData['purchase_case_id']       = $purchase_case_id;
       
        $res = $this->pushInventoryToDC($dcData,$data['carid']);
        $resArr = json_decode($res);
        //print_r($resArr);die;
        
        $dataArray['id'] = $resArr->carid;
        $dataArray['car_price']                 = !empty($data['realprice'])?str_replace(',', '', $data['realprice']):str_replace(',', '', $data['pricegaadi']);
        $dataArray['reg_date'] = date("Y-m-d", strtotime($data['reg_year']));
        $purchase_amount = str_replace(",","",$data['purchase_amt']);
        if($data['tradetype'] == 1){
        $updatearray['purchaseprice'] =  $purchase_amount;    
        }else{
        $updatearray['expected_price'] =  $purchase_amount;    
        }
        
        $this->db->where('case_id', $data['caseid']);
        $this->db->update('usedcar_payment_details',$updatearray);
       
        //add pricebreakup
         if(!empty($data['disn1'][0]))
        {
          // echo $data['carid'];die;
           $name = explode(',', $data['disn1'][0]);
           $price = explode(',', $data['disp1'][0]);
           $record = array_combine($name, $price);
           
           $this->db->delete('usedcar_price_breakup', array('car_id' => $data['carid'],'case_id' => $data['caseid']));
          
        
           foreach ($record as $key => $value) {
               $abc['price_name'] = $key;
               $abc['price_value'] = $value;
               $abc['status'] = 1;
               $abc['car_id'] = $data['carid'];
               $abc['case_id'] = $data['caseid'];
              
               $this->manageUsedCarPriceBreakUp($abc);
           }
        }
        
        if(!empty($data['weblink'][0]))
        {
           $name = explode(',', $data['webname'][0]);
           $link = explode(',', $data['weblink'][0]);
           $rec = array_combine($name, $link);
           $this->db->delete('usedcar_website_link', array('car_id' => $data['carid'],'case_id' => $data['caseid']));  // Produces: // DELETE FROM mytable  // WHERE id = $id

           foreach ($rec as $key => $value) {
               $xyz['website_name'] = $key;
               $xyz['website_link'] = $value;
               $xyz['status'] = 1;
               $xyz['car_id'] = $data['carid'];
               $xyz['case_id'] = $data['caseid'];
              
               $this->manageUsedCarLink($xyz);
           }
        }
        
        
        
        //if($checkDuplicate=='1')
        if($resArr->status=='T')
        {
        
            if(intval($data['carid']) > 0){
                $dataArray['id']  = $data['carid'];
                $this->db->where('id', $data['carid']);
                $this->db->update(CENTRAL_USED_CAR, $dataArray);
                $car_id = $data['carid'];
                if(!empty($car_id))
                {
                    $usedcarother['cnt_id']=$car_id;
                    $this->db->where('case_id', $data['caseid']);
                    $this->db->update('crm_used_car_other_fields', $usedcarother);
                }
            } else 
            {               
                $this->db->insert(CENTRAL_USED_CAR, $dataArray);
                $car_id = $this->db->insert_id();

            
                if(!empty($car_id))
                {
                    /*$usedcarother['cnt_id'] = $car_id;
                    $this->db->insert('crm_used_car_other_fields', $usedcarother);
                    $cid = $this->db->insert_id();*/
                    $usedcarother['cnt_id']=$car_id;
                    $this->db->where('case_id', $data['caseid']);
                    $this->db->update('crm_used_car_other_fields', $usedcarother);
                }
            }

            $resul['carid'] = $car_id;
            $resul['status'] = '1';
        }

        else
        {
            $resul['error'] = $resArr->msg;
            $resul['status'] = '0';

        }
   /* }else
    {
        $resul['error'] = $res;
        $resul['status'] = '0';
    }*/
    return json_encode($resul); 

        
    }

    public function manageRcDocs($data,$car_id){
          $this->load->database();
        $dataArray                                          = array();
        if(isset($data['rc_img_url']) && trim($data['rc_img_url']) != '')
            $dataArray['rc_img_url']                        = $data['rc_img_url'];
        else
            $dataArray['rc_img_url']                        = '';

        if(isset($data['supporting_doc_1_url']) && trim($data['supporting_doc_1_url']) != '')
            $dataArray['supporting_doc_1_url']              = $data['supporting_doc_1_url'];
        else
            $dataArray['supporting_doc_1_url']              = '';

        if(isset($data['supporting_doc_2_url']) && trim($data['supporting_doc_2_url']) != '')
            $dataArray['supporting_doc_2_url']              = $data['supporting_doc_2_url'];
        else
            $dataArray['supporting_doc_2_url']              = '';

        $dataArray['created_date']                          = date('Y-m-d H:i:s');
        $dataArray['updated_date']                          = date('Y-m-d H:i:s');
        $dataArray['car_id']                                = $car_id;
        
        $selectDocs    =  $this->db->get_where(CNT_USED_CAR_DOCS,array('car_id'=>$car_id));
        //("select id from ".CNT_USED_CAR_DOCS." where car_id = '".$car_id."'");
        $selectDocs = $selectDocs->result_array();
        if(isset($selectDocs[0]['id']) && intval($selectDocs[0]['id']) > 0){
            $this->db->where('id', $selectDocs[0]['id']);
            $this->db->update(CNT_USED_CAR_DOCS, $dataArray);
            return $selectDocs[0]['id'];
        } else {
             return $car_id = $this->db->insert(CNT_USED_CAR_DOCS, $dataArray);
        }
    }

    public function manageCarImages($value,$car_id){
        //echo "serfse"; exit;
        $this->load->database();
       // foreach($imageArray as $key => $value){
         $dataArray                                          = array();
            $dataArray['image_name']                            = $value['file_name'];
            $dataArray['image_url']                             = UPLOAD_IMAGE_URL.'uploadcar/original/'.$value['file_name'];
            $dataArray['status']                                = '1';
            $dataArray['created_on']                            = date('Y-m-d H:i:s');
            $dataArray['usedcar_id']                            = $car_id;
            $selectDocs    =  array();
            if(isset($selectDocs[0]['id']) && intval($selectDocs[0]['id']) > 0)
            {
                    $this->db->where('id', $selectDocs[0]['id']);
                   $result = $this->db->update(USED_CAR_IMAGE_MAPPER, $dataArray);
                    $selectDocs[0]['id'];
            } else {
                   $result = $this->db->insert(USED_CAR_IMAGE_MAPPER, $dataArray);
            }
           // echo $this->db->last_query(); exit;
      //   }
       return $result;
        
    }

    /*public function updateTagImageMapper($car_id='',$image_id='',$tag_id='0',$status='1',$err='',$da=[])
    {
        $data = [];
        if($tag_id>0)
        {
            $data['tag_id'] = $tag_id;   
        }
        if($status<'1')
        {
           $data['status'] = $status;  
        }
        if(!empty($err))
        {
           $data['incorrect_image'] = $err;  
        }
        $this->db->where('id', $image_id);
        $result = $this->db->update(USED_CAR_IMAGE_MAPPER, $data);
       // echo $this->db->last_query();  exit;

    }*/
    
     public function updateTagImageMapper($car_id='',$image_id='',$tag_id='0',$status='1',$err='',$parent_id='0',$re='')
    {
        $data = [];
        if($tag_id>0)
        {
            $data['tag_id'] = $tag_id;   
        }
        if($status<'1')
        {
           $data['status'] = $status;  
        }
        if(!empty($err))
        {
           $data['incorrect_image'] = $err;  
        }
        if(!empty($parent_id))
        {
          $data['parent_tag_id'] = $parent_id;  
        }
        if(!empty($re))
        {
            $data['tag_id'] = '';
            $data['parent_tag_id'] = '0';
            //$data['mark_incorrect'] = '0';  
        }
        $this->db->where('id', $image_id);
        $this->db->update(USED_CAR_IMAGE_MAPPER, $data);
      // echo $this->db->last_query();  exit;

    }


    public function updateOtherUploads($data,$case_id)
    {
        $this->db->where('case_id', $case_id);
        $this->db->update('crm_used_car_other_fields', $data);
        $result = $case_id;
        return $result;
    }

    public function manageCarFeature($data,$car_id){
        $this->load->database();
        $usedCarModelDetails = array(
            "cupHolders" => $data['mod_cupHolders'],
            "foldingRearSeat" => $data['mod_foldingRearSeat'],
            "tachometer" => $data['mod_tachometer'],
            "leatherSeats" => $data['mod_leatherSeats'],
            "tubelessTyres" => $data['mod_tubelessTyres'],
            "sunRoof" => $data['mod_sunRoof'],
            "fogLights" => $data['mod_fogLights'],
            "washWiper" => $data['mod_washWiper'],
            "defogger" => $data['mod_defogger'],
            "antiLockBrakingSystem" => $data['mod_antiLockBrakingSystem'],
            "driverAirBags" => $data['mod_driverAirBags'],
            "pssengerAirBags" => $data['mod_pssengerAirBags'],
            "immobilizer" => $data['mod_immobilizer'],
            "tractionControl" => $data['mod_tractionControl'],
            "childSafetyLocks" => $data['mod_childSafetyLocks'],
            "centralLocking" => $data['mod_centralLocking'],
            "remoteBootFuelLid" => $data['mod_remoteBootFuelLid'],
            "powerWindows" => $data['mod_powerWindows'],
            "powerSteering" => $data['mod_powerSteering'],
            "powerDoorLocks" => $data['mod_powerDoorLocks'],
            "powerSeats" => $data['mod_powerSeats'],
            "steeringAdjustment" => $data['mod_steeringAdjustment'],
            "carStereo" => $data['mod_carStereo'],
            "displayScreen" => $data['mod_displayScreen'],
            "additional_feature" => addslashes($data['additionaldetail']),
            "carID" => $car_id
        );

        foreach($usedCarModelDetails as $index => $val){
            if($index != 'carID' && $index != 'additional_feature'){
                if(intval($val) != 1){
                    $usedCarModelDetails[$index] = 0;
                }
            }
        }

        $keys = array_keys($usedCarModelDetails);
        $values = array_values($usedCarModelDetails);
        $add_query = array();
        foreach($keys as $index => $field_name){
            $add_query[] = $field_name.'=?';
        }
        $add_query = implode(', ',$add_query);
        $selectDocs  = $this->db->get_where(USED_CAR_MODEL_DETAILS,array('carID'=>$car_id));
       // $selectDocs    =  $this->db->query("select id from ".USED_CAR_MODEL_DETAILS." where carID = '".$car_id."'");
        $selectDocs = $selectDocs->result_array();
        if(isset($selectDocs[0]['id']) && intval($selectDocs[0]['id']) > 0){
            $values[]   = $selectDocs[0]['id'];
                    $this->db->where('id', $selectDocs[0]['id']);
                    $this->db->update(USED_CAR_MODEL_DETAILS, $usedCarModelDetails);
        } else {
                    $this->db->insert(USED_CAR_MODEL_DETAILS, $usedCarModelDetails);
        }
    }

    public function manageCarCondition($data,$car_id){
        $this->load->database();
        $exterior = 0;
        if ($data['exterior']) {
            $exterior = implode(",", $data['exterior']);
        }
        $bodyframe = 0;
        if ($data['bodyframe']) {
            $bodyframe = implode(",", $data['bodyframe']);
        }
        $interior = 0;
        if ($data['interior']) {
            $interior = implode(",", $data['interior']);
        }
        $etc = 0;
        if ($data['etc']) {
            $etc = implode(",", $data['etc']);
        }
        $susste = 0;
        if ($data['susste']) {
            $susste = implode(",", $data['susste']);
        }
        $heater = 0;
        if ($data['heater']) {
            $heater = $data['heater'];
        }
        $breaks = 0;
        if ($data['breaks']) {
            $breaks = implode(",", $data['breaks']);
        }
        $tires = 0;
        if ($data['tires']) {
            $tires = implode(",", $data['tires']);
        }
        $battery = 0;
        if ($data['battery']) {
            $battery = $data['battery'];
        }
        $overcondition = 0;
        if ($data['overcondition']) {
            $overcondition = $data['overcondition'];
        }
        $ee = 0;
        if ($data['ee']) {
            $ee = $data['ee'];
        }

        $keys       = array('usedcar_exterior','usedcar_bodyframe','usedcar_interior','usedcar_etc','usedcar_susste','usedcar_acheater','usedcar_breaks','usedcar_tires','usedcar_battery','usedcar_condition','usedcar_electrical','car_id');
        $values     = array($exterior,$bodyframe,$interior,$etc,$susste,$heater,$breaks,$tires,$battery,$overcondition,$ee,$car_id);
        $add_query  = array();
        $add_query = array_combine($keys, $values);
        /*foreach($keys as $index => $field_name){
            $add_query[] = $field_name.'=?';
        }
        $add_query = implode(', ',$add_query);
*/
        $selectDocs    =  $this->db->get_where(USEDCAR_CONDITION_MAPPER,array('car_id'=>$car_id));
        //$this->db->query("select id from ".USEDCAR_CONDITION_MAPPER." where car_id = '".$car_id."'");
        $selectDocs = $selectDocs->result_array();
        if(isset($selectDocs[0]['id']) && intval($selectDocs[0]['id']) > 0){
            $values[]   = $selectDocs[0]['id'];
             $this->db->where('id', $selectDocs[0]['id']);
            //$statements = "Update usedcar_condition_mapper SET ".$add_query." WHERE id=?";
            $this->db->update(USEDCAR_CONDITION_MAPPER, $add_query);
        } else {
            //$statements = "Insert INTO usedcar_condition_mapper SET ".$add_query;
            $this->db->insert(USEDCAR_CONDITION_MAPPER, $add_query);
        }
    }

    public function getClientIp()
    {
        if (isset($_SERVER['HTTP_TRUE_CLIENT_IP']))
        {
            $alt_ip = $_SERVER['HTTP_TRUE_CLIENT_IP'];
        }

        else if (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $alt_ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches))
        {
            // make sure we dont pick up an internal IP defined by RFC1918
            foreach ($matches[0] AS $ip)
            {
                    $alt_ip = $ip;
            }
        }
        else if (isset($_SERVER['HTTP_FROM']))
        {
            $alt_ip = $_SERVER['HTTP_FROM'];
        }
        
        $headers = apache_request_headers(); 
        $alt_ip  = $headers["X-Forwarded-For"]; 
        return $alt_ip;
    }

    public function getZoneDetail($localites=''){
        $this->load->database();
        $localitesTemp = explode(',',$localites);
        $localites = array();
        foreach($localitesTemp as $k => $v){
            if(intval($v) > 0)
            $localites[] = $v;
        }

        //$localities = $this->db->query("select id,localityname from locality where id IN (" . implode(',',$localites).")");
        //$localities = $localities->result_array();   
       // return $localities;
        return true;

    }

    public function getDocInfo($car_id)
    {
        $selectDocs    = $this->db->get_where(CNT_USED_CAR_DOCS,array('car_id'=>$car_id));
        // $this->db->query("select * from ".CNT_USED_CAR_DOCS." where car_id = '".$car_id."'");
        $selectDocs = $selectDocs->result_array();
        $result = [];
        $result['rc_img_url'] = $selectDocs[0]['rc_img_url'];
        $result['supporting_doc_1_url'] = $selectDocs[0]['supporting_doc_1_url'];
        $result['supporting_doc_2_url'] = $selectDocs[0]['supporting_doc_2_url'];
        $result['supporting_doc_3_url'] = $selectDocs[0]['supporting_doc_3_url'];
        $result['supporting_doc_4_url'] = $selectDocs[0]['supporting_doc_4_url'];

        return $result;

    }


    public function deleteCarImages($img_id)
    {
        $selectDocs    = $this->db->get_where(USED_CAR_IMAGE_MAPPER,array('id'=>$img_id));
        // $this->db->query("select image_name from ".USED_CAR_IMAGE_MAPPER." where id = '".$img_id."'");
       return $selectDocs = $selectDocs->result_array();
    }

    public function updateImgStatus($img_id)
    {
        $this->db->where('id', $img_id);
        $this->db->update(USED_CAR_IMAGE_MAPPER, array('status'=>'0'));
        return true;
    }

     public function getStockDetailsByCarId($car_id,$dealer_id) {
        //$sql = "SELECT * from ".CENTRAL_USED_CAR." where id='".$car_id."' and dealer_id='1' ";
        $result    = $this->db->get_where(CENTRAL_USED_CAR,array('id'=>$car_id,'dealer_id'=>DEALER_ID));
        $result    =  $result->result_array();
        return  $result[0];
    }

   public function crmToDcUsedcarSyn($data,$id='')
    {
        $sms_data = array();
        $key= 'Uh9vBqeiwsojTSecOXFLbPiZ40fGJGqsM';
        $source = 'dealerCentral';   
        $sms_data['dealer_id']   = $data['dealer_id'];
        $sms_data['version_id']   = $data['version_id'];
        $sms_data['showroom_id']   = '8515';
        $sms_data['city_id']   = '125';
        $sms_data['locality_id']   = '250';
        $sms_data['locality_names']   = 'delhi';
        $sms_data['reg_place_city_id']   = $data['reg_place_city_id'];
        $sms_data['reference_id']   = $data['reference_id'];
        $sms_data['domain_id']   = '1';
        $sms_data['user_mobile']   = MOBILESMS;
        $sms_data['user_email']   = DEALER_EMAIL;
        $sms_data['user_id']   = $data['user_id'];
        $sms_data['car_status']   = $data['car_status'];
        $sms_data['is_feature']   = $data['is_feature'];
        $sms_data['is_gaadi']   = !empty($data['is_gaadi'])?$data['is_gaadi']:'0';
        $sms_data['is_cardekho']   = !empty($data['is_cardekho'])?$data['is_cardekho']:'0';
        $sms_data['is_zigwheels']   = !empty($data['is_zigwheels'])?$data['is_zigwheels']:'0';
        $sms_data['km_driven']   = $data['km_driven'];
        $sms_data['car_price']   = $data['car_price'];
        $sms_data['sold_price']   = $data['sold_price'];
        $sms_data['owner_type']   = $data['owner_type'];
        $sms_data['make_month']   = $data['make_month'];
        $sms_data['make_year']   = $data['make_year'];
        $sms_data['insurance_type']   = $data['insurance_type'];
        $sms_data['insurance_exp_year']   = $data['insurance_exp_year'];
        $sms_data['insurance_exp_month']   = $data['insurance_exp_month'];
        $sms_data['reg_no']   = $data['reg_no'];
        $sms_data['reg_date']   = $data['reg_date'];
        $sms_data['reg_month']   = $data['reg_month'];
        $sms_data['reg_year']   = $data['reg_year'];
        $sms_data['is_reg_no_show']   = $data['is_reg_no_show'];
        $sms_data['reg_rto_city']   = $data['reg_rto_city'];
        $sms_data['is_cng_fitted']   = $data['is_cng_fitted'];
        $sms_data['tax_type']   = strtolower($data['tax_type']);
        $sms_data['user_type']   = $data['user_type'];
        $sms_data['listing_type']   = $data['listing_type'];
        $sms_data['car_description']   = $data['car_description'];
        $sms_data['special_offer']   = $data['special_offer'];
        $sms_data['city_covered']   = $data['city_covered'];
        $sms_data['otp_verified']   = $data['otp_verified'];
        $sms_data['created_date']   = $data['created_date'];
        $sms_data['last_deactivation_date']   = $data['last_deactivation_date'];
        $sms_data['last_update_date']   = $data['last_update_date'];
        $sms_data['last_inspection_date']   = $data['last_inspection_date'];
        $sms_data['source']   = $data['source'];
        $sms_data['ip_address']   = $this->input->ip_address();
        $sms_data['locality_names']   = $data['locality_names'];
        $sms_data['buyer_leads_count']   = $data['buyer_leads_count'];
        $sms_data['creator_source']   = 'dealer';
        $sms_data['creator_id']   = DEALER_ID;
        $sms_data['car_source'] = 'gaadi-website';
        $sms_data['colour'] = $data['colour'];
        $url                    = 'http://beta.priceindex.gaadi.com/central-admin-api/v1/usedcar/add';
        if(!empty($id))
        {
            $url                    = 'http://beta.priceindex.gaadi.com/central-admin-api/v1/usedcar/update/'.$id;
        }
        $datas                  = $sms_data;
        $fields_string          = '';
        foreach ($datas as $keys => $values) {
            $fields_string .= $keys . '=' . $values . '&';
        }
            rtrim($fields_string, '&');
            //$url      = URL_PUSH_LEADS_TO_GAADI;
            $ch       = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_POST, count($sms_data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("key:" . $key, "source:" . $source));
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sms_data));
            $response = curl_exec($ch);
            curl_close($ch);
            // $response;
            $data_array['crm_to_dc_data'] = serialize($sms_data);
            $data_array['created_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
            $data_array['response'] = $response;
        if(!empty($id))
        {
            $data_array['car_id'] = $id;
            $data_array['type'] = '2';
                   
        } 
        else 
        {
            $data_array['type'] = '1';
                  
        }
         $this->db->insert('crm_to_dc_sync', $data_array);
         return $response;
    }


 public function addUsedCarApi($data){
        $this->load->database();
        $selectDocs    = $this->db->get_where(CENTRAL_USED_CAR,array('id'=>$data['id']));
        // $this->db->query("select image_name from ".USED_CAR_IMAGE_MAPPER." where id = '".$img_id."'");
        $selectDocs = $selectDocs->result_array();
          //exit;
        $usedcarother = [];
        $caseInfo = [];
        $dataArray         =   array();
        $dataArray['dealer_id']                 = '69';//!empty($data['dealer_id'])?$data['dealer_id']:DEALER_ID;
        $dataArray['version_id']                = $data['version_id'];
        $dataArray['showroom_id']               = $data['showroomid'];
        $dataArray['city_id']                   = $data['city_id'];
        $dataArray['reg_place_city_id']         = $data['regplace_city_id'];
        $dataArray['domain_id']                 = !empty($data['domain_id'])?$data['domain_id']:'0';
        $dataArray['car_status']                = $data['active'];
        $dataArray['km_driven']                 = $data['km'];
        $dataArray['car_price']                 = $data['car_price'];
        $dataArray['colour']                    = $data['colour'];
        $dataArray['owner_type']                = $data['owner'];
        $dataArray['make_month']                = $data['mm'];
        $dataArray['make_year']                 = $data['myear'];
        $dataArray['insurance_type']            = $data['insurance'];
        $dataArray['insurance_exp_year']        = !empty($data['insurance_exp_year'])?$data['insurance_exp_year']:'';
        $dataArray['insurance_exp_month']       = !empty($data['insurance_exp_month'])?$data['insurance_exp_month']:'';//$data['insurance_exp_month'];
        //$regNo=preg_replace('/[^A-Za-z0-9\-]/', '', $data['reg']);
        $dataArray['reg_no']                    = strtoupper($data['regno']);
        $dataArray['reg_month']                 = $data['reg_month'];
        $dataArray['reg_year']                  = $data['reg_year'];
        $dataArray['is_reg_no_show']            = $data['showreg'];
        $dataArray['reg_rto_city']              = $data['regcityrto'];
        $dataArray['is_cng_fitted']             = $data['cngFitted'];
        $dataArray['tax_type']                  = $data['tax'];
        //$dataArray['locality_names']            = $data['locality_names'];
        $dataArray['locality_id']               = $data['locality'];
        $dataArray['user_type']                 = $data['user_type'];
         $dataArray['user_name']                 = $data['username'];
        $dataArray['car_description']           = !empty($data['car_description'])?addslashes($data['car_description']):'NA';
        $dataArray['special_offer']             = !empty($data['special_offer'])?addslashes($data['special_offer']):'NA';//$data['special_offer'];
       // if(intval($data['carid']) == 0)
        $dataArray['created_date']              = $data['created_date'];
       // $dataArray['last_update_date']          = $data['last_update_date'] ;
        $dataArray['source']                    = $data['creator_source'];
        $dataArray['ip_address']                = $data['ip'];  
        $class='0' ; 
        if($data['isclassified']=='1')
        {
            $class = '1';
        }
        $dataArray['is_gaadi']                  =$class;
        $dataArray['is_cardekho']               = $class;
        $usedcarother['listing_price']          = $data['pricefrom'];
        $usedcarother['cnt_id']  = $data['id'];
        $usedcarother['rto'] = $data['regcityrto'];
        $car_id         = '';
        $caseInfo['cat_id'] = '1';
        $caseInfo['evaluation_date'] = date('Y-m-d');
        $caseInfo['overall_condition'] = '2';
        $caseInfo['evaluation_remark'] = 'Pending Details';
        $caseInfo['created_date'] = date('Y-m-d H:i:s');
        $caseInfo['status'] = '1';
        $response  = '';
            if(!empty($selectDocs)){
                $this->db->where('id', $data['id']);
                $this->db->update(CENTRAL_USED_CAR, $dataArray);
                $car_id = $data['id'];
                if(!empty($car_id))
                {
                    $this->db->where('cnt_id', $data['id']);
                    $this->db->update('crm_used_car_other_fields', $usedcarother);
                    $response = 'updated successfully';
                }
                else
                {
                    $response = 'not updated error occur';
                }
                
            }
            else 
            {      
                $dataArray['id'] = $data['id'];
                $this->db->insert(CENTRAL_USED_CAR, $dataArray);
                $car_id = $this->db->insert_id();
            
                if(!empty($car_id))
                {
                    $this->db->insert('crm_usedcar_purchase_caseinfo', $caseInfo);
                    $caseid = $this->db->insert_id(); 
                    $usedcarother['case_id'] = $caseid;
                    $usedcarother['cnt_id'] = $car_id;
                    $this->db->insert('crm_used_car_other_fields', $usedcarother);
                    $cid = $this->db->insert_id();
                    $response = 'inserted successfully';
                }
                else
                {
                    $response = 'not inserted error occur';
                }
            }
            $data_array['crm_to_dc_data'] = serialize($data);
            $data_array['created_by'] = !empty($_SESSION['userinfo']['id'])?$_SESSION['userinfo']['id']:'';
            $data_array['response'] = $response;
            $data_array['car_id'] = $data['id'];
            $data_array['type'] = '2';
                   
       
         $this->db->insert('crm_to_dc_sync', $data_array);
            return $car_id;
        }
        
    public function pushInventoryToDC($data,$id='')
    {

        $request_data                   = array();
        //$key                        = 'Uh9vBqeiwsojTSecOXFLbPiZ40fGJGqsM';
        //$source                     = 'dealerCentral';
        //echo "<pre>"; print_r($data);die;
        if(($data['insurance_type']=='No Insurance') || ($data['insurance_type']=='no insurance')){
            $insurance_type =  1;
        }
        else{
            $insurance_type=(strtolower($data['insurance_type'])=='comprehensive')?2:3;
        }
        
        $mmvData=$this->getMMVDetailByVersionId($data['version_id']);
        $purchaseCaseData=$this->db->select('liquid_mode')->from('crm_usedcar_purchase_caseinfo')->where('id',$data['purchase_case_id'])->get()->row_array();
        
        //$getClassifiedStatus=$this->db->select('is_gaadi,is_feature')->from('crm_used_car')->where('id',$id)->get()->row_array();
        //print_r($data);die;
        $request_data['apikey']         = 'DEALERHrlnGed0dCRMAShyUJ54NEQ';
        $request_data['method']         = 'centralpushinventory';
        $request_data['dealer_id']      =  DEALER_ID;//$data['dealer_id'];
        $request_data['showroom']       = 8596;
        //$request_data['showroom']       = (DEALER_ID=='6953')?5891:15571;
        //$request_data['showroom']       = APPLICATION_ENV=='local' || APPLICATION_ENV=='development'?8596:5891;
        $request_data['crmID']          = !empty($id)?$id:''; ///
        $request_data['makemonth']      = $data['make_month'];
        $request_data['makeyear']       = $data['make_year'];
        $request_data['make_id']        = $mmvData['make_id']; 
        $request_data['model_id']       = $mmvData['model_id']; 
        $request_data['version_id']     = $data['version_id'];
        $request_data['registeredcar']  = $data['registeredcar'] == 1 ? 'yes' : 'no';
        $request_data['regno']          = $data['reg_no'];
        $request_data['regplace']       = $data['reg_place_city_id'];
        $request_data['km']             = $data['km_driven'];
        $request_data['carstatus']      = $data['car_status'];
        //only d2d inventory
        if($purchaseCaseData['liquid_mode']=='2'){
            $request_data['carstatus']='9';
        }
        $request_data['isclassified']   = !empty($data['is_gaadi']) ? $data['is_gaadi'] : '0';
        $request_data['featured']       = !empty($data['is_feature'])?$data['is_feature']:'0';
        $request_data['color']          = $data['colour'];
        $request_data['regmonth']       = date('m', strtotime($data['reg_year']));
        $request_data['regyear']        = date('Y', strtotime($data['reg_year']));
        $request_data['owner']          = $data['owner_type'];
        $request_data['price']          = $data['car_price'];
        $request_data['car_price']          = $data['car_price'];
        $request_data['insurance']      = $insurance_type;
        $request_data['insuranceyear']  = $data['insurance_exp_year'];
        $request_data['insurancemonth'] = $data['insurance_exp_month'];
        $request_data['tax']            = strtolower($data['tax_type'])=='individual'?1:2;

//        $request_data['city_id']   = '125';
//        $request_data['locality_id']   = '250';
//        $request_data['locality_names']   = 'delhi';
//        $request_data['reference_id']   = $data['reference_id'];
//        $request_data['domain_id']   = '1';
//        $request_data['user_mobile']   = MOBILESMS;
//        $request_data['user_email']   = DEALER_EMAIL;
//        $request_data['user_id']   = $data['user_id'];
//        $request_data['is_cardekho']   = !empty($data['is_cardekho'])?$data['is_cardekho']:'0';
//        $request_data['is_zigwheels']   = !empty($data['is_zigwheels'])?$data['is_zigwheels']:'0';
//        $request_data['sold_price']   = $data['sold_price'];
//        $request_data['reg_date']   = $data['reg_date'];
//        $request_data['reg_rto_city']   = $data['reg_rto_city'];
//        $request_data['is_cng_fitted']   = $data['is_cng_fitted'];
//        $request_data['user_type']   = $data['user_type'];
//        $request_data['listing_type']   = $data['listing_type'];
//        $request_data['car_description']   = $data['car_description'];
//        $request_data['special_offer']   = $data['special_offer'];
//        $request_data['city_covered']   = $data['city_covered'];
//        $request_data['otp_verified']   = $data['otp_verified'];
//        $request_data['created_date']   = $data['created_date'];
//        $request_data['last_deactivation_date']   = $data['last_deactivation_date'];
//        $request_data['last_update_date']   = $data['last_update_date'];
//        $request_data['last_inspection_date']   = $data['last_inspection_date'];
//        $request_data['source']   = $data['source'];
//        $request_data['ip_address']   = $this->input->ip_address();
//        $request_data['locality_names']   = $data['locality_names'];
//        $request_data['buyer_leads_count']   = $data['buyer_leads_count'];
//        $request_data['creator_source']   = 'dealer';
//        $request_data['creator_id']   = DEALER_ID;
//        $request_data['car_source'] = 'gaadi-website';
        
          $url                    = API_URL.'api/centralapi/CentralAdminApi.php';

        // echo "<pre>"; print_r($request_data);die;
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
                'added_by'      => $this->session->userdata['userinfo']['id'],
                'sent_time'     => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('crm_dc_sync_log',$log_data);
            $log_id=$this->db->insert_id();
          
         /* echo "<pre>";
          print_r($request_data);*/
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
         return $response;
    }
//    public function pushImagesToDC($data)
//    {
//        
//        $request_data                   = array();
//       
//        $request_data['apikey']         = 'DEALERHrlnGed0dCRMAShyUJ54NEQ';
//        $request_data['method']         = 'pushusedcarimages';
//        $request_data['dealer_id']      =  DEALER_ID;
//        $request_data['crmID']          = $data['car_id']; 
//        $request_data['image_urls']     = $data['image_urls']; 
//        
//        
//        
//          $url                    = API_URL.'api/centralapi/CentralAdminApi.php';
//
//           /*
//             * LOG THE API REQUEST
//             */
//            $log_data=[
//                'sync_module'   => 'stock',
//                'lead_id'       => '',
//                'api_url'       => $url,
//                'source'        => 'crm',
//                'dealer_id'     => DEALER_ID,
//                
//                //'request'       => json_encode($data_to_sync),
//                'added_by'      => $this->session->userdata['userinfo']['id'],
//                'sent_time'     => date('Y-m-d H:i:s'),
//            ];
//            $this->db->insert('crm_dc_sync_log',$log_data);
//            $log_id=$this->db->insert_id();
//          
//          
//            $ch       = curl_init();
//            curl_setopt($ch, CURLOPT_URL, $url);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//            curl_setopt($ch, CURLOPT_POST, count($request_data));
//            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request_data));
//            $response = curl_exec($ch);
//            curl_close($ch);
//            
//            $result= json_decode($response,true);
//            
//            /*
//             * LOG THE API RESPONSE
//             */
//            $this->db->where('id', $log_id);
//            $this->db->update('crm_dc_sync_log',[
//                'reference_lead_id' => 0,
//                'stock_id' => $result['carid'],
//                'reference_log_id'  => $result['log_id'],
//                'request'           => json_encode($request_data),
//                'response'          => $response,
//                'status'            => strtoupper($result['status']) == 'T' ? 'T' : 'F',
//                'response_time'     => date('Y-m-d H:i:s'),
//            ]);
//            
//            
//         //$this->db->insert('crm_to_dc_sync', $data_array);
//         return $response;
//    }
//    
    public function getMMVDetailByVersionId($version_id)
    {
            $dis_cont = array('0','1');
            $this->db->where_in('mm.dis_cont',$dis_cont);
            $this->db->where_in('mv.dis_cont',$dis_cont);
            $this->db->where(array('mv.db_version_id'=>$version_id));
            $this->db->select('mm.make_id,mv.model_id,mv.db_version_id,mv.uc_fuel_type,mv.uc_body_type,mv.uc_transmission');
            $this->db->from(MAKE_MODEL . ' as mm');
            $this->db->join(MODEL_VERSION . ' as mv','mm.id=mv.model_id');
            $mmv = $this->db->get();
            return $mmv->row_array();
            
    }
    
    public function updateNewImageFlag($data)
    {

        $this->db->where('car_id', $data['car_id']);
        $this->db->select('id');
        $this->db->from('crm_to_dc_image_sync');
        $exist         = $this->db->get();
        $checkIfExists = $exist->row_array();

        if (empty($checkIfExists))
        {
            $this->db->insert('crm_to_dc_image_sync', ['car_id' => $data['car_id'], 'is_syncd' => '0','created_date'=>date('Y-m-d H:i:s'),'updated_date'=>date('Y-m-d H:i:s')]);
        }
        else
        {
            $this->db->where('car_id', $data['car_id']);
            $this->db->update('crm_to_dc_image_sync', ['is_syncd' => '0','updated_date'=>date('Y-m-d H:i:s')]);
        }
    }
    
     public function getMakeModelList() {
        $this->load->database();
       
        $sql = "SELECT cm.id make_id,cm.make,mm.id model_id,mm.model FROM ".CAR_MAKE." cm inner join ".MAKE_MODEL." mm on mm.make_id=cm.id "
               . " where mm.dis_cont in ('0','1') and cm.dis_cont not in(2) ORDER BY cm.make asc,mm.model asc";
        $res = $this->db->query($sql);
        return  $res->result_array();
    }
    public function getVersionByModelId($model_id) {
         $this->load->database();
       
        $sql = "select db_version_id,db_version from " . MODEL_VERSION . " where model_id=$model_id AND dis_cont in ('0','1') order by uc_fuel_type desc";

        $res = $this->db->query($sql);
        return  $res->result_array();
    }
    
    public function manageUsedCarPriceBreakUp($data){
          $this->db->trans_start();
          $this->db->insert('usedcar_price_breakup', $data);
          $insert_id = $this->db->insert_id();
          $this->db->trans_complete();
          $result = $insert_id;
          return $result;
    }
    
    public function manageUsedCarLink($data){
        $this->db->trans_start();
        $this->db->insert('usedcar_website_link', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        $result = $insert_id;
        return $result;
    }

}

