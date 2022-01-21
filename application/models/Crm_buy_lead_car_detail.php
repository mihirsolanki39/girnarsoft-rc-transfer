<?php

/**
 * model : Crm_buy_lead_car_detail
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_buy_lead_car_detail extends CI_Model {

    public function __construct() {
        $this->load->model('Crm_buy_lead_customer_preferences');
        $this->load->model('Make_model');
        $this->load->model('Leadmodel');
        
    }
    public function getLeadCarDetail($lead_id)
    {
        $this->db->select('uc.car_price AS pricefrom,uc.id as gaadi_id,uc.old_car_id as carid,mv.db_version_model,mm.make_id,mm.id as model_id');
        $this->db->from('crm_buy_lead_car_detail as blcd');
        $this->db->join('crm_used_car  as uc', 'uc.id=blcd.lcd_car_id','left');
        $this->db->join('model_version  as mv', 'mv.db_version_id =uc.version_id','left');
        $this->db->join('make_model  as mm', 'mm.id=mv.model_id','left');
        $this->db->where('blcd.lcd_lead_dealer_mapper_id', $lead_id);
        $this->db->where('blcd.lcd_favourite', '1');
        $this->db->where('blcd.lcd_active', '1');
        $this->db->where('blcd.lcd_active >', '0');
        $this->db->group_by("blcd.lcd_car_id");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    public function getLeadEmailData($lead_id) {
        $newSql = "SELECT blc.mobile,lcm.ldm_customer_id,lcm.ldm_name,lcm.ldm_email,lcd.lcd_car_id,uc.reg_month AS month, uc.reg_year year,uc.make_month AS mmonth,uc.make_year AS myear, uc.colour AS colour, uc.km_driven AS km, uc.car_price AS pricefrom,uc.reg_no AS regno,uc.version_id,lcd.lcd_car_id  AS caroid,mv.db_version AS version,mv.uc_fuel_type AS fuel_type,mm.make,CASE WHEN mm.parent_model_id>0 THEN (select model from make_model where id = mm.parent_model_id limit 1) ELSE mm.model END AS model,uc.id as gaadi_id
        FROM crm_buy_lead_car_detail AS lcd 
        LEFT JOIN crm_used_car AS uc ON uc.id=lcd.lcd_car_id
        LEFT JOIN model_version AS mv ON mv.db_version_id=uc.version_id
        LEFT JOIN make_model AS mm ON mm.id=mv.model_id
        LEFT JOIN crm_buy_lead_dealer_mapper as lcm on lcm.ldm_id=lcd.lcd_lead_dealer_mapper_id 
        LEFT JOIN crm_buy_lead_customer as blc on blc.id=lcm.ldm_customer_id
        WHERE lcd.lcd_lead_dealer_mapper_id='" . $lead_id . "' and uc.car_status not in ('0') AND lcd.lcd_car_id>0 AND lcd.lcd_favourite='1' group by lcd.lcd_car_id";

       $result    = $this->db->query($newSql, [])->result_array();
        if ($result) {
            echo $emailHtml = $this->makeAssignCarHtml($result);
            exit;
        } else {
            $emailHtml = 'email_break';
            echo $emailHtml .='@#$%*';
            exit;
        }
    }
    
    public function makeAssignCarHtml($result) {
        $emailHtml = 'email_break';
        $emailHtml .='@#$%*';
        $count = count($result);
        if ($count > 0) {
            if ($count == 2) {
                $emailHtml .='<div style="overflow-y:scroll; overflow-x:hidden; height:225px;">';
            }
            if ($count >= 3) {
                $emailHtml.='<div style="overflow-y:scroll; overflow-x:hidden; height:225px;">';
            }
            $i = 1;
            foreach ($result as $key => $car_details) {
                //echo '<pre>';print_r($car_details);die;
                $border = 'padding-top: 15px;';
                if ($i == $count) {
                    $border = '';
                }
                $block = ($count > 1) ? 'block;' : 'none;';
                $checked = $count == 1 ? 'checked' : '';
                $price = explode('.', money_format('%!i', str_replace(",", "", $car_details['pricefrom'])));
                $km = explode('.', money_format('%!i', $car_details['km']));
                $makeYear = date("M", mktime(0, 0, 0, $car_details['mmonth'])) . " " . $car_details['myear'];
                $emailHtml .='<div class="input-group" style="display:' . $block . $border . '">';
                $emailHtml .='<div class="input-group"><ul  id="serviceList" class="col-sm-12 mrg-B0 mrg-T15" style="list-style-type: none;">';
                $emailHtml .='<li><input name="gaadi_id[]" type="checkbox" ' . $checked . '   id="' . $car_details['gaadi_id'] . '"  value="' . $car_details['gaadi_id'] . '"  /><label for="' . $car_details['gaadi_id'] . '"><span></span>' . $car_details['make'] . ' ' . $car_details['model'] . ' ' . $car_details['version'] . '</label> </li>';
                $emailHtml .='</ul></div> <div class="list-icon text-left">';
                $emailHtml .='<input type="hidden" name="customer_name" id="customer_name" value=' . $car_details['ldm_name'] . ' />';
                $emailHtml .='<input type="hidden" name="customer_id" id="customer_id" value=' . $car_details['ldm_customer_id'] . ' />';
                $emailHtml .='<input type="hidden" name="customer_mobile_number" id="customer_mobile_number" value=' . $car_details['mobile'] . ' />';
                $emailHtml .='<div class="col-sm-4"><span class="text-primary font-14 pad-L5"><i data-unicode="f156" class="fa fa-inr">&nbsp;</i>' . $price[0] . '</span></div>';
                $emailHtml .='<div class="col-sm-4"><span class="sprite icon-color mrg-R5"></span>' . $car_details['colour'] . '</div>';
                $emailHtml .='<div class="col-sm-4"><span class="sprite icon-fuel mrg-R5"></span>' . $car_details['fuel_type'] . '</div>  </div>';
                $emailHtml .=' <div class="list-icon text-left">';
                $emailHtml .='<div class="col-sm-4"><span class="sprite icon-klm mrg-R5"></span>' . $km[0] . '</div> ';
                $emailHtml .='<div class="col-sm-4"><span class="sprite icon-regno mrg-R5"></span>' . $car_details['regno'] . '</div>';
                $emailHtml .='<div class="col-sm-4"><span class="sprite icon-date mrg-R5"></span>' . $makeYear . '</div> ';
                $emailHtml .='</div>';
                $i ++;
            }
            $closeDiv = ($count > 1) ? '</div>' : '';
            $emailHtml .=$closeDiv;
        }
        return $emailHtml;
    }
    
     public function renderCarListSmsData($lead_id, $result, $userData) {
        $sql = "SELECT blc.mobile,lcm.ldm_customer_id,lcm.ldm_name,lcm.ldm_email,lcd.lcd_car_id,uc.reg_month AS month, uc.reg_year year,uc.make_month AS mmonth,uc.make_year AS myear, uc.colour AS colour, uc.km_driven AS km, uc.car_price AS pricefrom,uc.reg_no AS regno,uc.version_id,lcd.lcd_car_id  AS caroid,mv.db_version AS version,mv.uc_fuel_type AS fuel_type,mm.make,CASE WHEN mm.parent_model_id>0 THEN (select model from make_model where id = mm.parent_model_id limit 1) ELSE mm.model END AS model,uc.id as gaadi_id,lcm.ldm_id
        FROM crm_buy_lead_car_detail AS lcd 
        LEFT JOIN crm_used_car AS uc ON uc.id=lcd.lcd_car_id
        LEFT JOIN model_version AS mv ON mv.db_version_id=uc.version_id
        LEFT JOIN make_model AS mm ON mm.id=mv.model_id
        LEFT JOIN crm_buy_lead_dealer_mapper as lcm on lcm.ldm_id=lcd.lcd_lead_dealer_mapper_id 
        LEFT JOIN crm_buy_lead_customer as blc on blc.id=lcm.ldm_customer_id
        WHERE lcd.lcd_lead_dealer_mapper_id='" . $lead_id . "' and uc.car_status='1' AND lcd.lcd_car_id>0 AND lcd.lcd_favourite='1' group by lcd.lcd_car_id";

        $carDetailsList    = $this->db->query($sql, [])->result_array();
        $count = count($carDetailsList);
        $car_list = '';
        if ($count > 1) {
            $car_list ='';
            $car_list.='<div style="overflow-y:scroll; overflow-x:hidden; height:113px;">';
        }
        $checked = $count == 1 ? 'checked' : '';
        $display = $count > 1 ? 'flow-root ;' : 'none';
        $gaadi_id = !empty($carDetailsList[0]['gaadi_id'])?$carDetailsList[0]['gaadi_id']:'';
        $i = 1;
        foreach ($carDetailsList as $key => $car_details) {
            $border = 'border-bottom: 1px solid #ddd;padding-bottom: 15px;';
            if ($i == $count) {
                $border = '';
            }
            //echo '<pre>';print_r($car_details);die;
            $kms = explode('.', money_format('%!i', $car_details['km']));
            $price_from = explode('.', money_format('%!i', $car_details['pricefrom']));
            $car_list.= ' <div class="input-group mrg-T15 text-left" style="display:' . $display . $border . ' " >
                    <div class="input-group">
                        <ul  id="carList" style="list-style-type: none;" class="pad-L0 mrg-B0">    
                              <li><input name="sms_gaadi_id[]" ' . $checked . ' onclick="runNewVersion(this.id,this.value,' . $car_details['ldm_id'] . ')" type="radio" id="g_' . $car_details['gaadi_id'] . '"  value="' . $car_details['gaadi_id'] . '"  /><label for="g_' . $car_details['gaadi_id'] . '"><span></span>' . $car_details['make'] . " " . $car_details['model'] . " " . $car_details['version'] . '</label> </li>   
                        </ul>
                    </div> 
                    <div class="list-icon">

                                 <div class="col-sm-4"><span class="text-primary font-14 pad-L5"><i data-unicode="f156" class="fa fa-inr">&nbsp;</i>' . $price_from[0] . '</span></div>
                                 <div class="col-sm-4"><span class="sprite icon-color mrg-R5"></span>' . $car_details['colour'] . '</div>
                                 <div class="col-sm-4"><span class="sprite icon-fuel mrg-R5"></span>' . $car_details['fuel_type'] . '</div>  
                    </div>
                    <div class="list-icon">
                                <div class="col-sm-4"><span class="sprite icon-klm mrg-R5"></span>' . $kms[0] . '</div>                   
                                <div class="col-sm-4"><span class="sprite icon-regno mrg-R5"></span>' . $car_details['regno'] . '</div>
                                <div class="col-sm-4"><span class="sprite icon-date mrg-R5"></span>' . date("M", mktime(0, 0, 0, $car_details['mmonth'])) . " " . $car_details['myear'] . '</div>                             	
                    </div>  
                </div>';
            $i ++;
        }
        $car_list.= $count > 1 ? '</div>' : '';
        $car_list .="@#$%*";
        // This condtion for if only one record in cars then show default in text area 
        if ($count == 1) {
            $car_list .= $this->renderSingleCarMessage($gaadi_id, $result, $userData);
        } else {
            $car_list .="@#$%*";
        }
        return $car_list;
    }
    
    public function renderSingleCarMessage($gaadi_id, $result, $userData) {
        $this->load->helpers('urls');
        $this->load->helpers('range');
        $sql = "SELECT uc.make_month AS mm,uc.make_year AS myear, uc.colour AS colour, uc.km_driven AS km, uc.car_price AS pricefrom,uc.reg_no AS regno,uc.version_id,mv.db_version AS carversion,mv.uc_fuel_type AS fuel_type,mm.make,CASE WHEN mm.parent_model_id>0 THEN (select model from make_model where id = mm.parent_model_id limit 1) ELSE mm.model END AS model,uc.id as gaadi_id FROM crm_used_car AS uc 
            LEFT JOIN model_version AS mv ON mv.db_version_id=uc.version_id
            LEFT JOIN make_model AS mm ON mm.id=mv.model_id
            WHERE uc.car_status='1' AND uc.id='" . $gaadi_id . "'";
        $gaadiDetail    = $this->db->query($sql, [])->result_array();
        //echo '<pre>';print_r($gaadiDetail);die;
        if ($gaadiDetail) {
            $month = date("M", mktime(0, 0, 0, $gaadiDetail[0]['mm'])) . " " . $gaadiDetail[0]['myear'];
            $cleanUrl = getCleanUrl(DOMAIN, $gaadiDetail[0]['make'], $gaadiDetail[0]['model'], $gaadiDetail[0]['carversion'], $gaadiDetail[0]['gaadi_id']);
            $smatext='';
            $smatext.="Hi " . $result['ldm_name'] . ", 

            Please have a look at " . $gaadiDetail[0]['make'] . " " . $gaadiDetail[0]['model'] . " " . $gaadiDetail[0]['carversion'] . "[" . $gaadiDetail[0]['fuel_type'] . "], " . $gaadiDetail[0]['colour'] . " color, " . $month . " , " . $this->formatInIndianStyle($gaadiDetail[0]['km']) . " kms driven @ Rs. " . no_to_words($gaadiDetail[0]['pricefrom']) . " - " . $cleanUrl . "     " . PHP_EOL . " " . PHP_EOL;

            if (!empty($result['android_app_link']) || !empty($result['ios_app_link'])) {
                $smatext.="Download our APP now to view latest offers " . PHP_EOL;
            }
            if (!empty($result['android_app_link'])) {
                $smatext.="Android App: " . $result['android_app_link'] . PHP_EOL;
            }
            if (!empty($result['ios_app_link'])) {
                $smatext.="iOS App: " . $result['ios_app_link'] . PHP_EOL;
            }
                    $smatext.=PHP_EOL;
                    $smatext.="Regards, 
                    " . $result['organization'] . " 
                    " . $userData['mobile'];

                    $smatext .="@#$%*";
                } else {
                    $smatext .="@#$%*";
                }
                return $smatext;
    }
    
     public function renderLocationSmsText($result, $userData) {
        $smstext= '';
         $smstext .="@#$%*";
        $smstext.="Hi " . $result['ldm_name'] . ", 

        I am " . $userData['name'] . " from " . $userData['organization'] . ". My dealership location is ". (!empty($userData['address'])?$userData['address']." .":''); //. "  http://maps.google.com/maps?q=" . !empty($result['lat'])?$result['lat']:'' . "," . !empty($result['lang'])?$result['lang']:'' . "     " . PHP_EOL . " " . PHP_EOL;

        if (!empty($result['android_app_link']) || !empty($result['ios_app_link'])) {
            $smstext.="Download our APP now to view latest offers " . PHP_EOL;
        }
        if (!empty($result['android_app_link'])) {
            $smstext.="Android App: " . $result['android_app_link'] . PHP_EOL;
        }
        if (!empty($result['ios_app_link'])) {
            $smstext.="iOS App: " . $result['ios_app_link'] . PHP_EOL;
        }
        $smstext.=PHP_EOL;
        $smstext.="Regards, 
        " . $result['organization'] . " 
        " . $userData['mobile'] . PHP_EOL;

        $smstext .="@#$%*";
        return $smstext;
    }
    
     public function renderReminderSmsText($result, $userData) {
        $smstext = '';
        if (!empty($result['last_make_model'])) {
            $mm = $result['last_make_model'];
        } else {
            $mm = 'a used car';
        }
        $smstext .="@#$%*";
        $smstext.="Hi " . $result['ldm_name'] . ", 
    
            I am " . $userData['name'] . " from ".$_SESSION['userinfo']['organization'].". You were interested in buying " . $mm . ". Please suggest suitable time to get in touch with you or call me @ " . $userData['mobile'] . "     " . PHP_EOL . " " . PHP_EOL;

       if (!empty($result['android_app_link']) || !empty($result['ios_app_link'])) {
            $smstext.="Download our APP now to view latest offers " . PHP_EOL;
        }
        if (!empty($result['android_app_link'])) {
            $smstext.="Android App: " . $result['android_app_link'] . PHP_EOL;
        }
        if (!empty($result['ios_app_link'])) {
            $smstext.="iOS App: " . $result['ios_app_link'] . PHP_EOL;
        }
        $smstext.=PHP_EOL;
        $smstext.="Regards,
        ".$_SESSION['userinfo']['organization']."
        " . $userData['mobile'] . PHP_EOL;

        $smstext .="@#$%*";
        return $smstext;
    }
    
    
    public function renderRadioButtonWhatsup($result,$checktab='1')
    {
        $response    = array();
        $msgtype     = '';
        $checkedtab  = '';
        $checked_tab = ['send_reminder' => '0', 'car_details' => '0', 'dealer_location' => '0'];
        $sendvia          ="'whatsup'";
        $checkedRemider   = '';
        $checkedCarDetail = '';
        $checkedLocation  = '';
        if($checktab==1){
            $checkedRemider="checked";
        }else if($checktab==2){
            $checkedCarDetail="checked";
        }else if($checktab==3){
            $checkedLocation="checked";
        }
            $checkedtab.='1,';
            $checked_tab['send_reminder'] = '1';

            $msgtype.='<span class="mrg-R10 mrg-T10 mob-xs"><input type="radio" onclick="sendSmsNewVersion(this.id,this.value,'.$sendvia.');" '.$checkedRemider.' value="1" name="whatsuptype" id="whatsuptype1" class="whatsuptype" '.$checkedCarDetail.'><label for="whatsuptype1"><span></span>Reminder</label></span>';
        
            $checkedtab.='2,';
            $checked_tab['car_details'] = '1';
            $msgtype.='<span class="mrg-R10 mob-xs"><input type="radio" onclick="sendSmsNewVersion(this.id,this.value,'.$sendvia.');" value="2" name="whatsuptype" id="whatsuptype2" class="whatsuptype"><label for="whatsuptype2"><span></span>Car Details</label></span>';
            $checkedtab.='3,';
            $checked_tab['dealer_location'] = '1';
            $msgtype.='<span class="mrg-R10 mob-xs"><input type="radio" onclick="sendSmsNewVersion(this.id,this.value,'.$sendvia.');" value="3" '.$checkedLocation.' name="whatsuptype" id="whatsuptype3" class="whatsuptype"><label for="whatsuptype3"><span></span> Dealer Location</label></span>';

        $msgtype.="@#$%*";
        
        $response['msgtype']     = $msgtype;
        $response['checkedtab']  = $checkedtab;
        $response['checked_tab'] = $checked_tab;
        
        
        return $response;
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
            $formatted = makecomma($numexceptlastdigits);
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
function getcaroffercount($carid)
    {
        global $DB;
        $offer=0;
        $sqloffercount="select count(DISTINCT lcd_lead_dealer_mapper_id) as offer,max(offer_amount) as offer_amount  from crm_buy_lead_car_detail where lcd_car_id='".$carid."' and offer_amount>0 ";
        $result = $this->db->query($sqloffercount, [])->result_object();
        //$offer=intval($result[0]->offer);
        return $result;
    }
    
    
    public function getOnlyFavortieCarIds($leadId){
        //LEFT JOIN usedcar_certification_mapper AS ucm ON ucm.car_id=uc.old_car_id
                $sql=" SELECT GROUP_CONCAT(DISTINCT(lcd.lcd_car_id))  AS car_id
                 FROM crm_buy_lead_car_detail AS lcd 
                 LEFT JOIN crm_used_car AS uc ON uc.id=lcd.lcd_car_id
                 LEFT JOIN model_version AS mv ON mv.db_version_id=uc.version_id
                 LEFT JOIN make_model AS mm ON mm.id=mv.model_id
                 LEFT JOIN city_list cl ON uc.city_id=cl.city_id 
                 WHERE  lcd.lcd_lead_dealer_mapper_id = '".$leadId."' 
                        AND lcd_active = '1' 
                        AND uc.car_status != 9 
                        AND lcd.lcd_favourite = '1' 
                        AND lcd.lcd_car_id > 0 
                 ORDER  BY lcd.lcd_id DESC ";
               $favoriteCar = $this->db->query($sql, [])->result_object();
               if($favoriteCar){
                    return $favoriteCar[0]->car_id;
               }
               else {
                   return '';
               }
    }
    
    
    
    //Function to get recom car
    public function getRecommCar($arr,$arrPreference) {
        $maxPriceArr=$this->Crm_buy_lead_customer_preferences->getbudgetList();
        $bodyTypeStr = '';
        $bodyTypeArr = [];
        $srh_budget_min = '';
        $srh_budget_max = '';
        $sql = '';
        $caseMake = '';
        $caseModel = '';
        $secCaseSql = '';
        if(isset($arr['srh_body_type']) && !empty($arr['srh_body_type'])) {
            $bodyTypeArr = $arr['srh_body_type']; 
            $arrPreference['body_type'] = implode(',', $arr['srh_body_type']);
            //$bodyTypeStr = $this->formatString($arr['srh_body_type']);
        }
      // echo "<pre>";print_r($arr);exit;
        if(isset($arr['srh_model']) && !empty($arr['srh_model'])){//debug($srh_model);
            $srh_model = $arr['srh_model'];
             $srhModel =''; $srhMake =''; $arrParams = [];
            if(!empty($srh_model) && is_array($srh_model)) {
               
                foreach($srh_model as $key => $val) {
                    $pos = strpos($val, 'mk');
                    if($pos===false){ $val='mk_'.$val ;}
                    $explodeModel = explode('_', $val);
                    if($explodeModel[0] == 'mk') {
                        $srhMake .= $explodeModel[1].',';
                        $caseMake .= 'mv.mk_id = '.$explodeModel[1].' OR ';                        
                    } else {
                        $srhModel .= $explodeModel[0].',';
                        $caseModel .= 'mv.model_id = '.$explodeModel[0].' OR '; 
                    }
                }
                //$srh_model = implode(',', $srh_model);
                if(!empty($srhModel)) {
                    $srhModel = substr($srhModel, 0, -1);
                    $arrPreference['modelIds'] = $srhModel;
                    $srhModel = $this->Make_model->getChildModel($srhModel);
                    $arrParams['model_ids'] = $srhModel;
                }                
            }
            if(!empty($srhMake)) {
                $srhMake = substr($srhMake, 0, -1);
                $arrPreference['makeIds'] = $srhMake;
                //echo $srhMake;
                $arrParams['make_ids'] = $srhMake;                
            }
            if(!empty($arrParams)) {                  
                $carBodyType = $this->getCarBodyType($arrParams);
                if(!empty($carBodyType)) {
                    $carBodyTypeArr = explode(',', $carBodyType); 
                    foreach($carBodyTypeArr as $key => $val) {
                        $bodyTypeArr[] = $val;
                    }                 
                }
            }
        }
        if(isset($arr['existCarIds']) && !empty($arr['existCarIds'])) {
            $sql .= " and uc.id NOT IN(".$arr['existCarIds'].")";
        }
        if(!empty($bodyTypeArr)) {
            $bodyTypeStr = $this->formatString($bodyTypeArr);
            $sql .= " and mv.uc_body_type IN(".$bodyTypeStr.")";
        }
        if(isset($arr['srh_budget']) && !empty($arr['srh_budget'])) {
           //print_r($maxPriceArr);
            $arrPreference['budget'] = $arr['srh_budget'];
            $srh_budget_min = $this->getPrice($arr['srh_budget'], $maxPriceArr, 1);
            $srh_budget_max = $this->getPrice($arr['srh_budget'], $maxPriceArr, 3);
            $secCaseSql .= ' (uc.car_price - '.$arr['srh_budget'].') + ';
        }
        if(isset($srh_budget_min) && $srh_budget_min != '-1' && (!empty($srh_budget_min) || $srh_budget_min == '0')){  
            $sql .= " and uc.car_price >= '".$srh_budget_min."' ";
        }
        if(isset($srh_budget_max) && $srh_budget_max != '-1' && (!empty($srh_budget_max) || $srh_budget_max == '0')){  
            $sql .= " and uc.car_price <= '".$srh_budget_max."'";
        }
       
        //$selField = "mm.make,mm.model,mv.mk_id as makeID,mv.db_version as version ,lcd.lcd_car_id  as car_id,mv.uc_fuel_type as fuel_type,mv.uc_body_type as body_type,mv.uc_transmission as transmission,uc.active,uc.certification_status,ucm.car_certification,uc.parent_model_id,MONTHNAME(STR_TO_DATE(uc.mm, '%m')) as mm,uc.owner,uc.insurance,uc.version_id,cl.city_name,uc." . $createUsedcarArray[myear] . " as myear, uc." . $createUsedcarArray[colour] . " as colour, uc." . $createUsedcarArray[km] . " as km,uc." . $createUsedcarArray[pricefrom] . " as pricefrom,uc." . $createUsedcarArray[regno] . " as regno ";
        $caseSql = '';
        if(!empty($caseMake) || !empty($caseModel) || !empty($arr['srh_fuel']) || !empty($arr['srh_transmission'])) {
           
            if(!empty($caseMake)) {
                $caseMake = 'CASE WHEN ('.substr($caseMake,0,-4).')';
                $caseSql .= $caseMake." THEN 1 ELSE 0 END + ";
            }
            if(!empty($caseModel)) {
                $caseModel = 'CASE WHEN ('.substr($caseModel,0,-4).')';
                $caseSql .= $caseModel." THEN 1 ELSE 0 END + ";
            }
            if(!empty($arr['srh_fuel'])) {
                $arrPreference['fuel_type'] = $arr['srh_fuel'];
                $caseSql .= "CASE WHEN mv.uc_fuel_type = '".$arr['srh_fuel']."' THEN 1 ELSE 0 END + ";
            }
            if(!empty($arr['srh_transmission'])) {
                $arrPreference['transmission'] = $arr['srh_transmission'];
                $caseSql .= "CASE WHEN mv.uc_transmission = '".$arr['srh_transmission']."' THEN 1 ELSE 0 END + ";
            }
            
        }
        $caseSql .= "1 as rank";
        $secCaseSql .= "1 ";
        //$dealer_id = $_SESSION[ses_used_car_dealer_id];
        $dealer_id = DEALER_ID;
        //,uc.certification_status,ucm.car_certification
        //LEFT JOIN usedcar_certification_mapper AS ucm ON ucm.car_id=uc.old_car_id
        $sqlcar_list="SELECT ".$caseSql.",abs(".$secCaseSql.") as secRank,lcd.lcd_car_id as carId,uc.insurance_exp_month,uc.insurance_exp_year,uc.insurance_type AS insurance,uc.reg_month AS month, uc.reg_year year,uc.make_month AS mmonth,uc.make_year AS myear, uc.colour AS colour, uc.km_driven AS km, uc.car_price AS pricefrom,uc.reg_no AS regno,uc.owner_type AS owner,uc.version_id,lcd.lcd_car_id  AS car_id,mv.mk_id AS makeID,mv.db_version AS version,cl.city_id,cl.city_name,
mv.uc_body_type AS body_type,mv.uc_transmission AS transmission,mv.uc_fuel_type AS fuel_type,mm.make,CASE WHEN mm.parent_model_id>0 THEN (select model from make_model where id = mm.parent_model_id limit 1) ELSE mm.model END AS model,lcd.lcd_favourite,
lcd.offer_amount,lcd.lcd_source,lcd.lcd_sub_source,uc.car_status as active 
FROM crm_buy_lead_car_detail AS lcd 
LEFT JOIN crm_used_car AS uc ON uc.id=lcd.lcd_car_id
LEFT JOIN model_version AS mv ON mv.db_version_id=uc.version_id
LEFT JOIN make_model AS mm ON mm.id=mv.model_id
LEFT JOIN city_list cl ON uc.city_id=cl.city_id 
";
        $sqlcar_list .= " where 1 = 1 and uc.car_status = '1' and uc.id !=0 and uc.dealer_id = '".$dealer_id."' ".$sql;  
        $sqlcar_list .= "group by carId order by rank DESC,secRank ASC limit 0,5 ";
        //print_r($bodyTypeArr);
        //echo $sqlcar_list;die;
        
        //exit;
        $result = $favoriteCar = $this->db->query($sqlcar_list, [])->result_object();
        /*Save Preference*/
        $arrPreference['lead_id'] = $arr['leadId'];
        //print_r($arrPreference);exit;
        if($arr['type'] != 2) {
            //$this->addEditpreference($arrPreference); //old
            $this->Leadmodel->addEditpreferences($arrPreference);//to be used
        }
        return $result;
    }
    
    
    
     public function getCarBodyType($arr) {
        global $DB;
        
        $sqlcar_list = "SELECT group_concat(distinct mv.uc_body_type) as bodyStyles FROM crm_used_car as uc  LEFT JOIN model_version as mv on mv.db_version_id=uc.version_id ";
        $sqlcar_list .= "where mv.uc_body_type != '' and mv.uc_body_type IS NOT NULL ";
        if(isset($arr['model_ids']) && !empty($arr['model_ids']) && isset($arr['make_ids']) && !empty($arr['make_ids'])) {
            $sqlcar_list .= " and (mv.model_id IN (".$arr['model_ids'].") OR mv.mk_id IN (".$arr['make_ids']."))";
        } else {
            if(isset($arr['model_ids']) && !empty($arr['model_ids'])) {
                $sqlcar_list .= " and mv.model_id IN (".$arr['model_ids'].")";
            }
            if(isset($arr['make_ids']) && !empty($arr['make_ids'])) {
                $sqlcar_list .= " and mv.mk_id IN (".$arr['make_ids'].")";
            }
        }
        $bodyRes = $this->db->query($sqlcar_list, [])->result_object();
        $result = '';
        if(isset($bodyRes) && !empty($bodyRes)){ 
            $result = $bodyRes['0']->bodyStyles;
        }
        //echo '<pre>';print_r($bodyRes);exit;
        return $result;
    }
    
    public function formatString($arr){
        $str = '';
        if(isset($arr) && !empty($arr)){ 
            foreach ($arr as $key => $val) {
               $str .= "'".$val."',";
            }
        }
        if(!empty($str)) {
            $str = substr($str, 0, -1);
        }
        return $str;
    }
    
    
    public function getPrice($price, $arr, $type) {
        $return = '';
        if($type == '1') {
            $prevMinSel = 0;            
            foreach($arr as $key => $val){            
                if((!empty($price) && ($price > $val['key']))){
                    $return = $prevMinSel;
                }
                $prevMinSel = $val['key'];
            }
        } else if($type == '2') {
            $prevMinSel = 0;
            $keySelBudgetMax = 1;
            foreach($arr as $key => $val){
               
                if(!empty($price) && ($price < $val['key'] && $price >= $prevMinSel)){                                                           
                    $return = $val['key'];  
                    break;                                                               
                }    
                $prevMinSel = $return = $val['key'];
            }
        } else if($type == '3') {
            $sel = 0;
            $keySelBudgetMax = 1;
            foreach($arr as $key => $val){
//                if($keySelBudgetMax == '2') {
//                    $return = $key;  
//                    break;
//                }
                if(!empty($price) && ($price < $val['key'])){                                                           
//                    if($keySelBudgetMax == '1') {
//                        $keySelBudgetMax = '2';
//                    }                                                                   
                    $return = $val['key'];  
                    break;
                } 
            }
        } else if($type == '4') {
            $prevMinSel = 0;           
            foreach($arr as $key => $val){   
                if($prevMinSel == -1) {
                    $prevMinSel = $val['key'];
                }        
                if((!empty($price) && ($price == $val['key']))){
                    $return = $prevMinSel;
                    break;
                }                 
                $prevMinSel = $val['key'];
            }
        }//echo $price.'__'.$return;exit;
        return $return;
    }
    
    
    public function getleadsByCarId($carId,$viewtype='')
        {
            $carId=intval($carId);
            $currdate=date('Y-m-d');
            $response=[];
            if($carId>0){
                $where="";
                if($viewtype=='pendingleads'){
                    $where.=" AND DATE(ldm.ldm_follow_date) < '".$currdate."' AND ldm.ldm_status_id NOT IN ('12', '13')  AND lcd.lcd_active = '1'";
                }
                
                
             $sql = "SELECT GROUP_CONCAT(DISTINCT ldm.ldm_id) AS leadsID FROM crm_buy_lead_car_detail AS lcd LEFT JOIN crm_buy_lead_dealer_mapper AS ldm 
ON ldm.ldm_id=lcd.lcd_lead_dealer_mapper_id WHERE lcd.lcd_car_id='".$carId."' $where ";
                $response = current($this->db->query($sql, [])->result_array());
             }
            //echo "<pre>";print_r($response);exit;
            return $response;
        }
}

