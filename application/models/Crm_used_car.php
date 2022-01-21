<?php

/**
 * model : Crm_used_car
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_used_car extends CI_Model {

    public function __construct() {
        
    }
    
    public function getUsedCarDetailsSql($carids)
    {
        $this->db->select('uc.id','uc.version_id,mv.db_version as carversion,mv.uc_fuel_type as fuel_type,mm.id as model_id,mm.make,mm.model');
        $this->db->from('crm_used_car as uc');
        $this->db->join('model_version  as mv', 'uc.version_id = mv.db_version_id','inner');
        $this->db->join('make_model  as mm', 'mv.model_id = mm.id','inner');
        $this->db->where_in('uc.id', $carids);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function getUsedCarImages($car_id=false)
    {
            if($car_id){
           $sql="select image_url,image_name from crm_used_car_image_mapper as im  where im.usedcar_id='".$car_id."'  and im.status='1' order by id desc limit 1" ;
            $data=$this->db->query($sql)->result_array();
            $result= !empty($data)?$data[0]['image_url']:base_url('assets/admin_assets/images/used-car-no-img.png');
                return $result;            
            }
            else {
                return '';
            }
    }
    function getDealerCar($dealerId, $searcharr, $like = false) {
        $where = '';
        if ($like && isset($searcharr['make']) && isset($searcharr['make'])) {
            $where .= " and (mm.make like '%" . $searcharr['make'] . "%'";
            $where .= " or mm.model like '%" . $searcharr['model'] . "%')";
        } else {
            if (isset($searcharr['make']) && $searcharr['make'] != '') {
                $where .= " and mm.make = '" . $searcharr['make'] . "'";
            }
            if ( isset($searcharr['make']) && $searcharr['model'] != '') {
                $where .= " and mm.id = '" . $searcharr['model'] . "'";
            }
        }
        if (isset($searcharr['km_from']) && $searcharr['km_from'] != '') {
            $where .= " and uc.km_driven >='" . $searcharr['km_from'] . "'";
        }
        if (isset($searcharr['km_to']) && $searcharr['km_to'] != '') {
            $where .= " and uc.km_driven <='" . $searcharr['km_to'] . "'";
        }
        if (isset($searcharr['transmission_type']) && $searcharr['transmission_type'] != '') {
            $where .= " and mv.uc_transmission ='" . $searcharr['transmission_type'] . "'";
        }

        if (isset($searcharr['price_min']) && $searcharr['price_min'] != '') {
            $where .= " and uc.car_price >='" . $searcharr['price_min'] . "'";
        }
        if (isset($searcharr['price_max']) && $searcharr['price_max'] != '') {
            $where .= " and uc.car_price <='" . $searcharr['price_max'] . "'";
        }

        if (isset($searcharr['keyword']) && $searcharr['keyword'] != '') {
            $where .= " and uc.reg_no ='" . $searcharr['keyword'] . "'";
        }

        if (isset($searcharr['fuel_type']) && $searcharr['fuel_type'] != '') {
            $where .= " and mv.uc_fuel_type ='" . $searcharr['fuel_type'] . "'";
        }
        $outallCars = array();

        $fields = "uc.id,uc.id AS gaadi_id,mm.make,mv.db_version AS carversion, 
        CASE 
        WHEN mm.parent_model_id>0 THEN 
          ( 
                 SELECT model 
                 FROM   make_model 
                 WHERE  id = mm.parent_model_id limit 1) 
          ELSE mm.model 
        END 
        AS model,uc.km_driven AS km,uc.car_price AS pricefrom,uc.colour,uc.make_month AS mm,uc.make_year AS myear,uc.reg_no AS regno,
        CASE 
        WHEN uc.reg_place_city_id>0 THEN 
          ( 
                 SELECT city_name 
                 FROM   city_list
                 WHERE  city_id=uc.reg_place_city_id limit 1) 
        END 
        AS regplace,owner_type AS owner,uc.insurance_type AS insurance,mv.uc_fuel_type AS fuel_type,mv.uc_transmission AS transmission,uc.created_date AS created_date,uc.last_update_date AS updated_date,uc.version_id,uc.last_inspection_date AS certification_date_by_ce,uc.city_id,
        CASE 
        WHEN uc.city_id>0 THEN 
          ( 
                 SELECT city_name 
                 FROM   city_list
                 WHERE  city_id=uc.city_id limit 1) 
        END 
        AS cityname,uc.insurance_exp_month AS month,uc.insurance_exp_year AS year";

        $outallCarsSql = " SELECT " . $fields . " FROM crm_used_car as uc
            left join model_version as mv on uc.version_id=mv.db_version_id
            left join make_model as mm on mv.model_id=mm.id
            WHERE 1 and uc.car_status='1' and uc.dealer_id=". DEALER_ID ."  $where";
        $getallCar    = $this->db->query($outallCarsSql, [])->result_object();
        $i = 0;
        if (!empty($getallCar)) {
             $carsalready ='';
            foreach ($getallCar as $key => $v) {
                $carsalready.=$v->gaadi_id . ",";
                $usedCarImage   = $this->getUsedCarImages($v->id);
                if (!empty($usedCarImage)) {
                    $img = !empty($usedCarImage)?$usedCarImage:'';
                } else {
                   $img = base_url('assets/admin_assets/images/used-car-no-img.png');
                }
               // $short_url = 'http://' . $v->domain . '/uc/' . $v->id;
                $outallCars[$i]['make']        = $v->make;
                $outallCars[$i]['model']       = $v->model;
                $outallCars[$i]['carversion']  = $v->carversion;
                $outallCars[$i]['car_id']      = $v->gaadi_id;
                $outallCars[$i]['fuel_type']   = $v->fuel_type;
                $outallCars[$i]['colour']      = $v->colour;
                $outallCars[$i]['Kms']         = number_format($v->km);
                $outallCars[$i]['price']       = number_format($v->pricefrom);
                $outallCars[$i]['myear']       = $v->myear;
                $outallCars[$i]['mm']          = $v->mm;
                //$outallCars[$i]['websiteUrl'] = $short_url;
                $outallCars[$i]['img_icon']     = $img;
                $outallCars[$i]['transmission'] = $v->transmission;
                $outallCars[$i]['regno']        = $v->regno;
                $i++;
            }
            return $outallCars;
        }
    }
    
    
    
     public function getLeadFavoriteCar($leadId,$onlyCarId=false){
                $sql="SELECT lcd.lcd_car_id,uc.insurance_exp_month,uc.insurance_exp_year,uc.insurance_type AS insurance,uc.reg_month AS month, uc.reg_year year,uc.make_month AS mmonth,uc.make_year AS myear, uc.colour AS colour, uc.km_driven AS km, uc.car_price AS pricefrom,uc.reg_no AS regno,uc.owner_type AS owner,uc.version_id,lcd.lcd_car_id  AS car_id,mv.mk_id AS makeID,mv.db_version AS version,cl.city_id,cl.city_name,
mv.uc_body_type AS body_type,mv.uc_transmission AS transmission,mv.uc_fuel_type AS fuel_type,mm.make,CASE WHEN mm.parent_model_id>0 THEN (select model from make_model where id = mm.parent_model_id limit 1) ELSE mm.model END AS model,lcd.lcd_favourite,
lcd.offer_amount,lcd.lcd_source,lcd.lcd_sub_source,uc.certification_status,ucm.car_certification,uc.car_status as active 
FROM crm_buy_lead_car_detail AS lcd 
LEFT JOIN crm_used_car AS uc ON uc.id=lcd.lcd_car_id
LEFT JOIN model_version AS mv ON mv.db_version_id=uc.version_id
LEFT JOIN make_model AS mm ON mm.id=mv.model_id
LEFT JOIN city_list cl ON uc.city_id=cl.city_id 
LEFT JOIN crm_usedcar_certification_mapper AS ucm ON ucm.car_id=uc.old_car_id
WHERE  lcd.lcd_lead_dealer_mapper_id = '".$leadId."' 
                        AND lcd.lcd_active = '1' 
                       AND uc.car_status != '9' 
                        AND lcd.lcd_favourite = '1' 
                        AND lcd.lcd_car_id > 0 
                 GROUP BY  lcd.lcd_car_id  
                 ORDER  BY lcd.lcd_id DESC";
                
               $favoriteCar = $this->db->query($sql, [])->result_object();
              // echo "<pre>";print_r($favoriteCar);exit; 
               $car_list=array();
               if($favoriteCar){
                foreach ($favoriteCar as $keyy => $values) {
                   $nooptionUnassign= $this->nooptionUnassign($values->lcd_source,$values->lcd_sub_source);
                    $car_list[$keyy]['disable_unassign'] = (intval($nooptionUnassign)==1?true:false);
                    $car_list[$keyy]['car_id'] = $values->car_id;
                    $car_list[$keyy]['is_sold']=$values->active;
                    //$car_list[$keyy]['lead_count'] =(!empty($leadcount['count'])?$leadcount['count']:'');
                    $car_list[$keyy]['offer_count'] = (!empty($offers[0]->offer)?intval($offers[0]->offer):'');
                    $car_list[$keyy]['offer'] = (!empty($values-> offer_amount)>0?true:false);
                    $car_list[$keyy]['year'] = (!empty($values->myear)?$values->myear:'');
                    $car_list[$keyy]['month'] = (!empty($values->mm)?$values->mm:'');
                    $car_list[$keyy]['version_id'] = (!empty($values->version_id)?$values->version_id:'');
                    $car_list[$keyy]['city_name'] = (!empty($values->city_name)?$values->city_name:'');
                    $car_list[$keyy]['owner'] = (!empty($values->owner)?$values->owner:'');
                    $car_list[$keyy]['insurance'] = (!empty($values->insurance)?$values->insurance:'');
                    $car_list[$keyy]['expiry_date'] = (!empty($values->expiry_date)?$values->expiry_date:'');
                    $car_list[$keyy]['city_id'] = (!empty($values->city_id)?$values->city_id:'');
                    $car_list[$keyy]['color'] = (!empty($values->colour)?$values->colour:'');
                    $car_list[$keyy]['km'] = (!empty($values->km)?$values->km:'');
                    $car_list[$keyy]['transmission'] = (!empty($values->transmission)?$values->transmission:'');
                    $car_list[$keyy]['body_type'] = (!empty($values->body_type)?$values->body_type:'');
                    $car_list[$keyy]['price'] = (!empty($values->pricefrom)?$values->pricefrom:'');
                    $car_list[$keyy]['make'] = (!empty($values->make)?$values->make:'');
                    $car_list[$keyy]['ins_month'] = (!empty($values->insurance_exp_month)?$values->insurance_exp_month:'');
                    $car_list[$keyy]['ins_year'] = (!empty($values->insurance_exp_year)?$values->insurance_exp_year:'');
                    $car_list[$keyy]['model']  = (!empty($values->model)?$values->model:'');
                    if(isset($values->parent_model_id) && $values->parent_model_id > 0){
                   // $car_list[$keyy]['model']  = $this->getparentModelByids($values->parent_model_id) ;
		    }
		    else
                    {
                    $car_list[$keyy]['model'] 	= (!empty($values->model)?$values->model:'');
                    }
                    $car_list[$keyy]['version'] = (!empty($values->version)?$values->version:'');
                    $car_list[$keyy]['regno'] = (!empty($values->regno)?$values->regno:'');
                    $car_list[$keyy]['favourite'] = (!empty($values->lcd_favourite)?$values->lcd_favourite:'');
                    $car_list[$keyy]['lead_count'] = '4';
                    $car_list[$keyy]['makeID']=(!empty($values->makeID)?$values->makeID:'');
                    $websiteUrl='';
                    if($values->car_certification==18 && $values->certification_status==1)
  		    {
                    $car_list[$keyy]['trustmarkCertified']='true';
                    }
                    else 
                    {
                    $car_list[$keyy]['trustmarkCertified']='false';
                    }
                    $car_list[$keyy]['fuel_type'] = $values->fuel_type;
                    }
               }
              
              return $car_list;
            }
            function nooptionUnassign($source,$subsource)
                {
                    $option=1; 
                    $source=  strtolower($source);
                    $subsource=strtolower($subsource);

                    if($subsource=='self' || $source=='self' || (($source=='gaadi' || $source=='') && $subsource=='mobile')){
                        $option=0;
                    }
                        return $option;
                }
        public function getModelImage($make, $model) {
        $this->db->select('img');
        $this->db->from('make_model');
        $this->db->where('make', "'$make'");
        $this->db->where('model', "'$model'");
        $this->db->where('img != ', "''");
        $this->db->limit('1');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $result = $query->row_array();
        return $result;
    }

    public function sendMailOnStockShareHtml($carId,$email) {
        $this->load->helper('range_helper');
        $this->load->helper('mail_helper');
        $this->load->model('crm_stocks');    
        $dealerId       = DEALER_ID;
        $activeStatus   = '1';
        $searchText     = '';    
        $carDealerDetail = $this->crm_stocks->getInventoryListing($dealerId,$activeStatus,$searchText,true,'','',$carId);
        $selectCarDealerDetail = !empty($carDealerDetail[0]) ? (array) $carDealerDetail[0] :'';
        if (!empty($selectCarDealerDetail['logo'])) {
            $dealerLogo = $selectCarDealerDetail['logo'];
        }
        else {
            $dealerLogo = DEALER_LOGO;
        }
        if (!empty($selectCarDealerDetail['know_v_number']) && $selectCarDealerDetail['know_v_number'] != '0') {
            $phoneNumber = $selectCarDealerDetail['know_v_number'];
        } 
        else {
            $phoneNumber = MOBILESMS;
        }
        $organisation = ORGANIZATION;
        $domain       = DOMAIN;
        $gaadiId      = !empty($selectCarDealerDetail['gaadi_id'])?$selectCarDealerDetail['gaadi_id']:'';
        if (!empty($selectCarDealerDetail['image_url'])) {
            $imageName = $selectCarDealerDetail['image_url'];
        }
        else {
            if(isset($selectCarDealerDetail['make']) && isset($selectCarDealerDetail['model'])){
            $makeModelImage = $this->getModelImage($selectCarDealerDetail['make'], $selectCarDealerDetail['model']);
            }
            $imageName = 'http://www.gaadicdn.com/model_images/resize_220x143/' . !empty($makeModelImage['img'])?$makeModelImage['img']:'';
        }
        

        $carMake    = !empty($selectCarDealerDetail['make'])?$selectCarDealerDetail['make']:'';
        $carModel   = !empty($selectCarDealerDetail['model'])?$selectCarDealerDetail['model']:'';
        $carVersion = !empty($selectCarDealerDetail['carversion'])?$selectCarDealerDetail['carversion']:'';

        if (!empty($selectCarDealerDetail) && $email != '') {
            //$db->insertQuery("insert into send_email_tracker set dealer_id=" . $_SESSION['ses_used_car_dealer_id'] . ",car_id=" . $carId . ",name='" . $_REQUEST['txtName'] . "',email_id='" . $email . "',date_time=now()");
            //dealerLogger('Inventory', 'Send_email', $_SESSION['ses_used_car_dealer_id'], 'Add', serialize($_REQUEST), 0, $_SESSION['ses_dealer_id'], 0);

                $sender = DEALER_NAME . ' <feedback@gaadi.com>';
                $address = '';
            $headerLogo = '<a href="http://' . $domain . '"><img src="' . $dealerLogo . '" width="120" height="42" alt="' . $organisation . '" style="border:none; text-align:left; vertical-align:middle; float:left;" />';
            $carDetailEmail = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Untitled Document</title>
                </head>

                <body><table style="border-bottom:#dcdcdc 1px solid;border-left:#dcdcdc 1px solid;margin:0px auto;width:100%;max-width:660px;background:#ffffff;color:#000000;border-top:#dcdcdc 1px solid;border-right:#dcdcdc 1px solid" border="0" cellspacing="0" cellpadding="0"><tbody>
                  <tr>
                    <td style=" padding:0px;">
                <table style="background-repeat:repeat-x;color:#000000" border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tbody>
                        <tr>
                          <td style="padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:10px; border-bottom: #e3e3e3 1px solid;">

                ' . $headerLogo . '
                </a>
                <a href="http://www.cardekho.com/" target="_blank" style="float:right;  margin-top:10px;"><img src="http://images.cardekho.com/images/logos/newlogo/cardekho-221X21.png" height="21" width="221" alt="CarDekho.com - Best place to buy New and Used Cars in India"></a>
                            <a href="http://www.gaadi.com/" target="_blank" style="float:right; margin-right:20px; margin-top:3px;"><img src="http://gaadicdn.com/newgaadi/images/gaadi-logo.png" alt="Gaadi.com" pagespeed_url_hash="3527299696" onload="pagespeed.CriticalImages.checkImageForCriticality(this);" height="35"> </a>
                          </td>
                        </tr>
                        </tbody>
                      </table>
                           <table style="color:#000000" border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tbody>
                       </tbody></table>
                           <table style="color:#000000" border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tbody>
                        <tr>
                          <td style=" padding:0px 10px 10px 10px;">
                            <p style="font-family:arial,helvetica,sans-serif;color:#777;font-size:16px;font-weight:bold; margin-bottom:5px;">Dear ' . (!empty($_REQUEST['txtName']) ? $_REQUEST['txtName'] : 'customer') . ',</p>
                                                        <p style="font-family:arial,helvetica,sans-serif;color:#777;font-size:14px; margin:0px; padding:0px;">
                                        Please have a look at the details of the car mentioned below
                            </p>
                          </td>
                        </tr>
		<tr>
        	<td width="100%" style="border-bottom:#e3e3e3 1px solid; border-top:#e3e3e3 1px solid; padding:10px;font-family:arial,helvetica,sans-serif;background:#f5f5f5;color:#777;font-size:24px;">
            	<table width="100%">
                	<tr>
						<td style="padding:0px 10px 10px 0px;">
                        	<table border="0" cellspacing="0" cellpadding="0" width="100%">
                        
                                <tbody>
                                <tr>
                                	<td colspan="2" style="font-size:18px; padding-bottom:10px; vertical-align:text-top"> <strong>' . $carMake . ' ' . $carModel . ' ' . $carVersion . '</strong><hr style="border:1px solid #eee;" /></td>
                                </tr>
								<tr>
                                <td style="text-align:left; vertical-align:top;" width="30%">
                               <a href="http://' . $domain . '/car_detail.php?id=' . $gaadiId . '">
                                <img src="' . $imageName . '" width="216" height="162"  title="' . $carMake . ' ' . $carModel . ' ' . $carVersion . '" alt="' . $carMake . ' ' . $carModel . ' ' . $carVersion . '" border="0" style="border-radius:4%; padding:7px; border:1px solid #e3e3e3; background:#fff; -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05); box-shadow: 0 1px 1px rgba(0, 0, 0, .05);" ></a>
                                </td>
								<td style="padding:0px 10px 10px 20px; font-size:14px; color:#666;" width="70%">
                                	<table border="0" cellspacing="0" cellpadding="3" style="float:right;" width="100%" align="left">
                                      <tbody><tr style="border-bottom:1px solid #eee;">                                       
                                      </tr>';
            if (!empty($selectCarDealerDetail['myear']) && $selectCarDealerDetail['myear'] > 0) {
                $carDetailEmail.='<tr>
                        <td width="35%">Make Year:</td>
                        <td width="65%"><strong>' . $selectCarDealerDetail['myear'] . '</strong> </td>
                      </tr>';
            }
            if ($selectCarDealerDetail['colour'] != 0 && !empty($selectCarDealerDetail['colour'])) {
                $carDetailEmail.='<tr>
                        <td width="35%">Color:</td>
                                <td><strong>' . $selectCarDealerDetail['colour'] . '</strong></td>
                  </tr>';
            }
            if (!empty($selectCarDealerDetail['km']) && $selectCarDealerDetail['km'] > 0) {
                $carDetailEmail.='<tr>
                    <td>Kilometers:</td>
                    <td><strong>' . $this->IND_money_formatss($selectCarDealerDetail['km']) . '</strong></td>
              </tr>';
            }
            if (!empty($selectCarDealerDetail['city'])) {
                $carDetailEmail.='<tr>
                <td>City:</td>
                <td><strong>' . $selectCarDealerDetail['city'] . '</strong></td>
          </tr>';
            }
            if ($selectCarDealerDetail['pricefrom'] > 0) {
                $carDetailEmail.='<tr>
                <td>Exp. Price:</td>
                <td><strong>' .$this->IND_money_formatss($selectCarDealerDetail['pricefrom']) . '</strong></td>
          </tr>';
            }
            if (!empty($selectCarDealerDetail['RegCity'])  && $selectCarDealerDetail['RegCity'] != '0') {
                $carDetailEmail.='<tr>
                <td>Reg. Place:</td>
                <td><strong>' . $selectCarDealerDetail['RegCity'] . '</strong></td>
          </tr>';
            }
            if (!empty($selectCarDealerDetail['owner'])  && $selectCarDealerDetail['owner'] != '0') {
                $carDetailEmail.='<tr>
                <td>No. of  owners:</td>
                <td><strong>' . addOrdinalNumberSuffix($selectCarDealerDetail['owner']) . '</strong></td>
          </tr>';
            }
            if (!empty($selectCarDealerDetail['fuel_type'])) {
                $carDetailEmail.='<tr>
                        <td>Fuel Type:</td>
                        <td><strong>' . $selectCarDealerDetail['fuel_type'] . '</strong></td>
                  </tr>';
            }
            if (!empty($selectCarDealerDetail['transmission'])) {
                $carDetailEmail.='<tr>
                    <td>Transmission:</td>
                    <td><strong>' . $selectCarDealerDetail['transmission'] . '</strong></td>
              </tr>';
            }
            $carDetailEmail.='</tbody>
                                    </table>
                                </td>
								
                             </tr>
                                </tbody>
                      		</table>
                      		<hr style="border:1px solid #eee;" />
                    	</td>
                      </tr>
					   <tr>
                        <td style="padding:5px 10px 15px 10px; text-align:center;" width="100%">
                        <span><a href="http://' . $domain . '/car_detail.php?id=' . $gaadiId . '" style=" border-radius:15px; padding:5px 20px; font:bold 14px Tahoma, Geneva, sans-serif; color:#fff; text-decoration:none; background-color:#0063AE;">View Full Car Details</a></span>
                        
                        </td>
                        </tr>
						</table>
            </td>
        </tr>';
        
           $carDetailEmail.='<tr>
          <td style="padding:10px;">
          <p style="font-family:arial,helvetica,sans-serif; font-size:16px; font-weight:bold;"><a href="http://' . $domain . '/car_available.php" style="color:#e66437;">View Other Cars</a></p>
            <p style="margin-top:0px;font-family:arial,helvetica,sans-serif;color:#777;font-size:16px;">If you have any queries feel free to contact us at  
            <strong>+91- ' . $phoneNumber . '</strong> / 
              visit <a href="http://' . $domain . '" style="color:#0066cc; text-decoration:none;">http://' . $domain . '</a> we will be happy to help.
            </p>
            <a href="http://' . $domain . '/showroom_list.php" style="  padding: 5px 20px;  font: bold 14px Tahoma,Geneva,sans-serif;  color: #777;  text-decoration: none;background-color: #F5F5F5;  border: 1px solid #ccc;  border-radius: 15px;" target="_blank">View Dealer Location</a>
            </td></tr>
			<tr>
          <td style=" padding:10px 10px 10px 10px; font-family:arial,helvetica,sans-serif;color:#777;font-size:14px;font-weight:normal">
            <p style="">
           Regards,<br />
            ' . $organisation . '<br />
            Email: <a href="#" style="color:#0066cc; text-decoration:none;">' . DEALER_EMAIL . '</a>' . $address . ' <br />
            +91- ' . $phoneNumber . '<br />
            </p></td>
        </tr>
		</tbody></table>
      <table style="color:#000000" border="0" cellspacing="0" cellpadding="0" width="100%">
        <tbody>
        <tr style="border-bottom:#e3e3e3 1px solid;background:#f5f5f5;border-top:#e3e3e3 1px solid">
          <td style="border-bottom:#e3e3e3 1px solid; padding:10px; font-family:arial,helvetica,sans-serif;background:#f5f5f5;color:#999;font-size:13px;border-top:#e3e3e3 1px solid;" width="50%">Copyright <a href="http://www.gaadi.com" target="_blank" style=" color:#0177c9; font-size:13px;">www.gaadi.com</a>. All Rights Reserved.</td>
        <td style="border-bottom:#e3e3e3 1px solid; padding:10px;font-family:arial,helvetica,sans-serif;background:#f5f5f5;color:#777;font-size:14px;border-top:#e3e3e3 1px solid;">&nbsp;</td></tr></tbody></table></td></tr></tbody></table>
        
        </body>
        </html>';
            $toemail = (explode(',', $email));
            $toEmailCount = count($toemail);
            for ($i = 0; $i < $toEmailCount; $i++) {
            $sendMail =  commonMailSenderNew($toemail[$i], 'Check out ' . $selectCarDealerDetail['make'] . ' ' . $selectCarDealerDetail['model'] . ' ' . $selectCarDealerDetail['carversion'] . ' details', $carDetailEmail, $sender, DEALER_NAME);
            }
            return $sendMail;
        }
    }
    function IND_money_formatss($number){        
        //$decimal = (string)($number - floor($number));
        $money = floor($number);
        $length = strlen($money);
        $delimiter = '';
        $money = strrev($money);
 
        for($i=0;$i<$length;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
                $delimiter .=',';
            }
            $delimiter .=$money[$i];
        }
 
        $result = strrev($delimiter);
       // $decimal = preg_replace("/0\./i", ".", $decimal);
       // $decimal = substr($decimal, 0, 3);
 
        //if( $decimal != '0'){
       //     $result = $result.$decimal;
       // }
 
        return $result;
    }

}

