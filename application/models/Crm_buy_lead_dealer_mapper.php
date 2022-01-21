<?php

/**
 * model : Crm_buy_lead_dealer_mapper
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_buy_lead_dealer_mapper extends CI_Model {
   public $table = 'crm_buy_lead_dealer_mapper';
    public function __construct() {
        
    }
    
    public function getBuyLeadDealerMapper($leadid, $dealerid)
        {
        
           $query = $this->db->get_where('crm_buy_lead_customer', array($this->table . ".ldm_customer_id" =>$leadid));
            return $query->row_array();
        }
        
        public function checkLeadMessageStatus($lead_id) {
        $this->db->select('ldm_is_sms,ldm_is_sms_cardetail,ldm_is_sms_location ,ldm_name,d.organization');
        $this->db->from('crm_buy_lead_dealer_mapper as ldm');
        $this->db->join('crm_dealers  as d', 'd.id=ldm.ldm_dealer_id ','left');
        $this->db->where_in('ldm.ldm_id', $lead_id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
    
    public function sendEmail($request){
                global $db;
            $carLeadIds     =explode(",",substr($request['id'],0,-1));
                $leadString     =$request['id'];
                $name           =$request['name'];
                $lead_id        =$request['lead_id'];
                $mobile         =$request['mobile'];
                if($carLeadIds){
                    $customerId=$request['customerid'];
                    $customerEmail=$this->getCustomerEmailId($customerId);
                    $requestEmail= $request['email_id'];
                    if($customerEmail !=$requestEmail){
                        $this->updateEmailId($customerId,$requestEmail);
                    }
                    $this->db->select('d.organization,d.domain');
                    $this->db->from('crm_admin_dealers as d');
                    $this->db->where_in('d.dealer_id', DEALER_ID);
                    $query = $this->db->get();
                    $dealerDetail = $query->row_array();
                    $logEmailCars=$this->logEmailCarLeads($carLeadIds,$request,$customerId,$lead_id,$mobile);
                    echo $response=$this->sendEmailToMember($leadString,$dealerDetail,$requestEmail,$carLeadIds,$name);exit;

                }
    }
    
    public function getCustomerEmailId($customerId){
        $this->db->select('ldm_email');
        $this->db->from('crm_buy_lead_dealer_mapper');
        $this->db->where_in('ldm_customer_id', $customerId);
        $query = $this->db->get();
        $customerData = $query->row_array();
        return $customerData['ldm_email'];
    }
    
    public function updateEmailId($customerId,$requestEmail){
        $data =['ldm_email'=>$requestEmail,];
        $this->db->where('ldm_customer_id', $customerId);
        $this->db->update('crm_buy_lead_dealer_mapper', $data);
    }
    
    public function logEmailCarLeads($carLeadIds,$request,$customerId,$lead_id,$mobile){
        global $db;
        foreach($carLeadIds as $k=>$v)
    {
            $data =[
                'lead_mobile'    =>$request['mobile'],
                'lead_car_id'    =>$v,
                'lead_dealer_id' =>DEALER_ID,
                'lead_date'      =>date("Y-m-d"),
                'lead_customerid'=>$customerId];
            $this->db->insert('lead_mail_log_customer', $data);
         
    }
      
       $this->saveHistory('Car Details Sent','Email',$mobile,$lead_id);
    }
    
    public function saveHistory($shared_item,$shared_by,$mobile,$lead_id){
        $this->load->model('Crm_buy_lead_history_track');
        $data['userid']                     = DEALER_ID;
        $data['car_id']                     = '';
        $data['shared_item']                = $shared_item;
        $data['shared_by']                  = $shared_by;
        $data['lc_lead_dealer_mapper_id']   = $lead_id;
        $data['mobile']                     = $mobile;
        $data['ldm_dealer_id']              = DEALER_ID;
        $this->Crm_buy_lead_history_track->trackAllHistory($data,1);
    }
    
    public function sendEmailToMember($carLeadString, $dealerDetail, $email_id, $carLeadIds, $name) {
        $sql = "SELECT cof.case_id as caseid,mm.model as models,uc.make_month AS mm,uc.make_year AS myear, uc.colour AS colour, uc.km_driven AS km, uc.car_price AS pricefrom,uc.reg_no AS regno,uc.version_id,mv.db_version AS carversion,mv.uc_fuel_type AS fuel_type,mm.make,CASE WHEN mm.parent_model_id>0 THEN (select model from make_model where id = mm.parent_model_id limit 1) ELSE mm.model END AS model,uc.id as gaadi_id,uc.id as caroid,cl.city_name as city,ucim.image_url FROM crm_used_car AS uc 
        LEFT JOIN model_version AS mv ON mv.db_version_id=uc.version_id
        LEFT JOIN make_model AS mm ON mm.id=mv.model_id
        LEFT JOIN city_list cl ON uc.city_id=cl.city_id
        inner JOIN crm_used_car_other_fields cof ON cof.cnt_id=uc.id
        LEFT JOIN crm_used_car_image_mapper as ucim on ucim.usedcar_id=uc.id and ucim.status='1' and ucim.order='1'    
        WHERE uc.car_status not in ('0') and uc.dealer_id='" . DEALER_ID . "' AND uc.id in (" . substr($carLeadString, 0, -1) . ")";
        $select_sendcar_cars    = $this->db->query($sql, [])->result_array();
        //$dealer_logo = $dealerDetail['logo'];
//        $logo_url = ASSET_BASE_PATH . 'dealer_site/' . $dealer_logo;
//        if (is_file($logo_url)) {
//            $logo_url = ASSET_PATH . 'dealer_site/' . $dealer_logo;
//        } else {
//            $logo_url = ASSET_PATH . 'images/logo.png';
//        }
        $logo_url = '';//ASSET_PATH . 'images/logo.png';
        $domaindealer = !empty($dealerDetail['domain'])?$dealerDetail['domain']:'';
        $domainorg    = !empty($dealerDetail['organization'])?$dealerDetail['organization']:'';
        if (count($carLeadIds) > 1) {
            $no_of_cars = 'some used cars';
        } else {
            $no_of_cars = 'a used car';
        }
        $message ='';
        $message.='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Gaadi.com - 2 used cars found matching your serach</title>
            </head>

            <body style="margin:0; padding:0;">
                <div style="width:100%; background:#f4f4f4; position:relative; padding:20px 0">
                    <table width="560" border="0" cellspacing="0" cellpadding="0" style="background:#ffffff;border:solid 1px #dcdcdc; margin:0px auto;-webkit-box-shadow: 0px 0px 3px 1px rgba(0, 0, 0, .25);-moz-box-shadow: 0px 0px 3px 1px rgba(0, 0, 0, .25);-o-box-shadow: 0px 0px 3px 1px rgba(0, 0, 0, .25);box-shadow: 0px 0px 3px 1px rgba(0, 0, 0, .25);">
                      <tr>
                        <td style="padding:20px;">
                        <table width="560" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                              <td><a href="' . $domaindealer . '" target="_blank"><img src="' . $logo_url . '" width="124" height="48" alt="' . $domainorg . '" longdesc="http://www.gaadi.com/" style="border:none; display:block;" title="' . $domainorg . '"/></a></td>
                          </tr>
                          <tr>
                            <td style="font-family: Arial, Helvetica, sans-serif; font-size:12px; color:#444444; padding:15px 0 10px 0; line-height:26px;">Dear ' . ucwords($name) . ',
                                <br>We found ' . $no_of_cars . ' for you that match your preference.
                            </td>
                          </tr>
                          <tr>
                            <td>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px; border:solid 1px #e1e1e1; background:#f6f6f6;">
                                  <tr>
                                    <td width="72%"  colspan="2" style="border-bottom:solid 1px #e1e1e1; background:#3e4349;-webkit-border-radius: 5px 0px 0 0;-moz-border-radius:  5px 0px 0 0;border-radius:  5px 0px 0 0; padding:12px 20px;font-family: Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; color:#FFFFFF;"> ' . count($carLeadIds) . ' Used cars found matching your search</td>
                                </tr>
                                <tr><td style="height:20px;"></td></tr>';



        foreach ($select_sendcar_cars as $keysimilar => $valuesimilar) {
            //echo '<pre>';print_r($valuesimilar);die;
            $subjectmake   ='';
            $subjectmodel  ='';
            $subjectyear   ='';
            $subjectkm     ='';
            $subjectprice  ='';
            $car_id        ='';
            $subjectmake   .= $valuesimilar['make'] . ',';
            $subjectmodel  .= $valuesimilar['model'] . ',';
            $subjectyear   .= $valuesimilar['myear'] . ',';
            $subjectkm     .= $valuesimilar['km'] . ',';
            $subjectprice  .= $valuesimilar['pricefrom'] . ',';
            $name           = !empty($valuesimilar['username'])?$valuesimilar['username']:'';
            $make           = !empty($valuesimilar['make'])?$valuesimilar['make']:'';
            $model          = !empty($valuesimilar['model'])?$valuesimilar['model']:'';
            $year           = !empty($valuesimilar['myear'])?$valuesimilar['myear']:'';
            $mm             = !empty($valuesimilar['mm'])?$valuesimilar['mm']:'';
            $km             = !empty($valuesimilar['km'])?$valuesimilar['km']:'';
            $fuel           = !empty($valuesimilar['fuel_type'])?$valuesimilar['fuel_type']:'';
            $car_id        .= $valuesimilar['gaadi_id'] . ',';
            $price          = !empty($valuesimilar['pricefrom'])?$valuesimilar['pricefrom']:'';
            $color          = !empty($valuesimilar['colour'])?$valuesimilar['colour']:'';
            $city           = !empty($valuesimilar['city'])?$valuesimilar['city']:'';
            $version        = !empty($valuesimilar['carversion'])?$valuesimilar['carversion']:'';

            if (!empty($valuesimilar['image_url'])) {
                $img = $valuesimilar['image_url'];
            } else {
                $img = '';//ASSET_PATH . "images/used-car-no-img.png";
            }
            $basencode = base64_encode(DEALER_ID.'_'.$valuesimilar['caseid']);
            $urlcardetail =   $domaindealer . '/cardetails/' . $basencode;
            $message = '';
            $message.='
                        <tr>
                        <td colspan="2" style="padding:0 20px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="111px" valign="top"><a href="' . $urlcardetail . '" target="_blank"><img src=' . $img . ' style="border:solid 1px #666666; display:block;" width="109" height="80"  alt="' . $make . ' ' . $model . '" title="' . $make . ' ' . $model . '" /></a></td>
                            <td width="278px" valign="top" style="padding-left:20px;">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td style="padding-bottom:5px;"><a href="#" target="_blank" style="font-family: Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; color:#00a9f8; text-decoration:none;">' . $make . ' ' . $model . ' ' . $version . '<span style="color:#444444;font-weight:normal;">';
            if ($fuel != '') {
                $message.=' (' . $fuel . ')';
            } else {
                
            } $message.='</span></a></td>
                          </tr>
                          <tr>
                                <td style="padding-bottom:4px;"><span style="font-family: Arial, Helvetica, sans-serif; font-size:12px; color:#444444; text-decoration:none;">';
            if ($mm != '') {
                $message.= date("M", mktime(0, 0, 0, $mm));
            } else {
                $message.= '-';
            }$message.= '&nbsp;&nbsp;';
            if ($year != '') {
                $message.= $year;
            } else {
                $message.= '-';
            } $message.= '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;';
            if ($color != '') {
                $message.= $color;
            } else {
                $message.= '-';
            } $message.='&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;';
            if ($km != '') {
                $message.= substr(money_format('%!i', $km), 0, -3);
            } else {
                $message.= '-';
            } $message.= ' Kms</span></td>
                          </tr>
                          <tr>
                            <td style="padding-bottom:4px;"><span style="font-family: Arial, Helvetica, sans-serif; font-size:12px; color:#444444; text-decoration:none;">Rs. ';
            if ($price != '') {
                $message.= substr(money_format('%!i', $price), 0, -3);
            } else {
                $message.= '-';
            } $message.= '</span></td>
                          </tr>
                          <tr>
                            <td><span style="font-family: Arial, Helvetica, sans-serif; font-size:12px; color:#444444; text-decoration:none;"><strong>';
            if ($city != '') {
                $message.= $city;
            } else {
                $message.= '-';
            } $message.= '</strong></span></td>
                          </tr>
                        </table>
                                </td>
                            <td align="center"><a href="' . $urlcardetail . '" target="_blank"><img src="http://usedcarsin.in/origin-assets/css_images/cla.png" width="77" height="29" border="0" style="border:none !important; display:inline-block;" alt="view car"></a></td>
                          </tr>
                          <tr>
                            <td colspan="3"><hr style="color: #d5d5d5;background-color: #d5d5d5; height: 1px;border: 0; width:100%;  margin:10px 0 10px 0; padding:0;" /></td>
                          </tr>
                                                                
                        </table>

                        </td>';
        }
        $message.='</tr>
                    </table>
                </td>
              </tr>
              <tr>
                 <td  align="center" style="padding:20px 0;"></td>
              </tr>
             <tr><td></td></tr>
             <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#444444; line-height:19px;">Regards,<br /><a href="' . $domaindealer . '" target="_blank">' . $domainorg . '</a></td>
             </tr>
            </table>
            </td>
          </tr>
        </table>
      </div>
   </body>
</html>';


        $carcount = count($select_sendcar_cars);
        if ($carcount >= 2) {
            $carcountsubject = $carcount - 1;
            $subject = "We have found some cars for you";
        } else {
            $subject = "Check out " . $make . " " . $model . " " . $version . " details";
            $carcountsubject = $carcount;
        }
        $msubject = explode(",", substr($subjectmake, 0, -1));
        $modelsubject = explode(",", substr($subjectmodel, 0, -1));
        $yrsubject = explode(",", substr($subjectyear, 0, -1));
        $kmsubject = explode(",", substr($subjectkm, 0, -1));
        $psubject = explode(",", substr($subjectprice, 0, -1));

        $makesubject = ($msubject[0]) ? $msubject[0] : '';
        $model_subject = ($modelsubject[0]) ? $modelsubject[0] : '';
        $yearsubject = ($yrsubject[0]) ? $yrsubject[0] . ',' : '-';
        $ksubject = ($kmsubject[0]) ? $kmsubject[0] . ' Km,' : '-';
        $pricesubject = ($psubject[0]) ? ' @ ' . ' Rs ' . $psubject[0] . ',' : '-';
        $makesubject = ($msubject[0]) ? $msubject[0] : '-';
        //$makeWiseCount = count($select_similar_cars);
        $to = $email_id;
        $from = 'usedcars@gaadi.com';
        $headers = "From: " . $domainorg . "<usedcars@gaadi.com> \r\n";
        $headers .= "Reply-To: usedcars@gaadi.com \r\n";
        $headers .= "CC: shashikant.kumar@girnarsoft.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        //echo $message;die;
        $response = mail($to, $subject, $message, $headers);
        if(!empty($response)){
        return $response;
        }else{
            echo 'mail not sent';die;
        }
    }
    
    function SMS_Report($mobile_sms, $smsText, $source) {
        $sms_data = array();
        $sms_data['mobile']     = $mobile_sms;
        //$sms_data['mobile']   = '9910578589';
        $sms_data['message']    = $smsText;
        $sms_data['source']     = 'USDCAR';
        $sms_data['priority']   = 5;
        $sms_data['NDNC']       = 1;
        $sms_data['sender']     = 'USDCAR';
        $sms_data['send_via']   = 'PINNACLE';

        $url                    = SMS_URL;
        $datas                  = $sms_data;
        $fields_string          = '';
        foreach ($datas as $keys => $values) {
            $fields_string .= $keys . '=' . $values . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}

