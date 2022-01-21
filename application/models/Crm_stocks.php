<?php

/**
 * model : Crm_outlets
 * User Class to Control all role related Operations .
 * @author : Rakesh kumar
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm_stocks extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->dateTime = date("Y-m-d H:i:s");
        $this->gaadi = '1';
        $this->webSite = ['1'];
        $this->removed = ['0','2'];
        $this->sold = ['3'];
        $this->all = ['0','1','2','3','4','6'];
        $this->refurb = ['6'];
        $this->booked = ['4'];
    }

    /**
     * This function is used to get the stock listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function stockListingCount($searchText = '') {
        $this->db->select('s.*,');
        $this->db->from('crm_stocks as s');
        $this->db->where('s.status', '1');

        $query = $this->db->get();
        return $query->num_rows();
    }

    function getTotStockCount($dealerId = '', $carStatus = '', $searchText = '') {
        return $this->db->select('used_car.id id,used_car.dealer_id,used_car.is_cng_fitted cngFitted,used_car.is_gaadi isclassified,mm.model ,mm.id model_id,mm.make,mv.db_version carversion,mv.db_version_id,
                    used_car.car_status active ,clist.city_name as RegCity ,used_car.is_feature ispremium,used_car.colour,used_car.km_driven as km,
                    used_car.make_year myear,used_car.make_month mm,used_car.owner_type owner,mv.uc_fuel_type fuel_type,mv.uc_transmission transmission,used_car.reg_no regno,used_car.id gaadi_id,ucm.cardekho_id,ucm.sell_dealer,ucm.inCertificationProcess,ucm.image_folder,
                    used_car.car_price pricefrom, used_car.car_price priceto, car_certification.name as certifiedBY,usedcar_certification_mapper.car_certification  as certifiedBYID,ucm.certification_id,ucm.recommended_package recommendedPackage,
                    used_car.certification_status as CStatus,mm.model as ParentModel,clist.city_name as RegCity,COUNT(distinct CASE WHEN uim.status IN(1) THEN uim.id ELSE null END )imageCount,COUNT(distinct CASE WHEN uim.status IN(2,3) THEN uim.id ELSE null END )imgWithIssueCount,
                    COUNT(distinct CASE WHEN lcd_active = "1"  THEN lcd.lcd_id ELSE null END )total_active_leads,COUNT(distinct CASE WHEN lcd_active = "1" AND DATE(ldm_follow_date) > "2018-07-31" AND ldm_status_id NOT IN (12, 13) THEN ldm_id ELSE null END )pending_leads,
                    (DATEDIFF(CURDATE(), STR_TO_DATE(CONCAT(make_year,"-",make_month,"-1"), "%Y-%m-%d"))/365 )*5000 target_km,used_car.city_id')
                        ->from('crm_used_car as used_car')
                        ->join('crm_usedcar_certification_mapper as usedcar_certification_mapper', 'usedcar_certification_mapper.car_id = used_car.old_car_id', 'left')
                        ->join('crm_car_certification as car_certification', 'usedcar_certification_mapper.car_certification = car_certification.id', 'left')
                        ->join('crm_used_car_image_mapper as uim', 'uim.usedcar_id = used_car.id and uim.status in("1","3","2")', 'left')
                        ->join('crm_used_car_miscellaneous as ucm', 'ucm.usedcar_id = used_car.id', 'left')
                        ->join('city_list as clist', 'clist.city_id = used_car.reg_place_city_id', 'left')
                        ->join('model_version as mv', 'mv.db_version_id=used_car.version_id', 'left')
                        ->join('make_model as mm', 'mm.id = mv.model_id', 'left')
                        ->join('crm_buy_lead_car_detail as lcd', 'lcd.lcd_car_id =used_car.id', 'left')
                        ->join('crm_buy_lead_dealer_mapper as ldm', 'ldm.ldm_id =lcd.lcd_lead_dealer_mapper_id', 'left')
                        ->join('crm_stock_renew_date_log as snl', 'used_car.id=snl.car_id AND snl.is_latest ="1"', 'left')
                        ->where('1', '1')
                        ->where('used_car.dealer_id', $dealerId)
                        ->where_in('used_car.car_status', $carStatus)
                        ->group_by('used_car.id')
                        ->get()
                        //echo $this->db->last_query();die;
                        ->num_rows();
    }

    function getInventoryListing($dealerId = '', $carStatus = '', $searchArray = array(), $totcnt = '', $page = '', $segment = '',$carId='') {
        //print_r($searchArray);die;
        $this->db->where('1', '1');
        if (!empty($searchArray)) {
            $this->getInventoryListingSearch($searchArray);
        }
        $currentDate = date('Y-m-d');
        $ldm_status = "'12', '13'";
        $lcd_active = "'1'";
        $uimStatus = "'1'";
        $uimStatusIn = "'2','3'";
        $this->db->select('used_car.id id,used_car.dealer_id,used_car.is_cng_fitted cngFitted,used_car.is_gaadi isclassified,
                    mm.model,mm.id model_id,mm.make,mv.db_version as carversion,mv.db_version_id,
                    used_car.car_status active,clist.city_name as RegCity,used_car.is_feature ispremium,
                    used_car.colour,used_car.insurance_type as insurance,used_car.special_offer as offers,used_car.tax_type as tax,used_car.km_driven km,
                    used_car.make_year myear,used_car.make_month mm,used_car.owner_type owner,mv.uc_fuel_type fuel_type,mv.uc_transmission transmission,used_car.reg_no regno,
                   used_car.id gaadi_id,ucm.cardekho_id,ucm.sell_dealer,ucm.inCertificationProcess,ucm.image_folder,ucm.warranty_id,used_car.certification_status,ucm.certification_id,
                    used_car.car_price pricefrom,used_car.car_price priceto,car_certification.name as certifiedBY,
                    usedcar_certification_mapper.car_certification  as certifiedBYID,uim.image_url,uim.image_name as profileimage, ucm.certification_id,
                   ucm.recommended_package recommendedPackage, used_car.certification_status as CStatus, mm.model as ParentModel, clist.city_name as RegCity,
                   COUNT(distinct CASE WHEN uim.status IN(' . $uimStatus . ') THEN uim.id ELSE null END )imageCount,COUNT(distinct CASE WHEN uim.status IN(' . $uimStatusIn . ') THEN uim.id ELSE null END )imgWithIssueCount,
                   COUNT(distinct CASE WHEN lcd_active = ' . $lcd_active . '  THEN lcd.lcd_id ELSE null END )total_active_leads,COUNT(distinct CASE WHEN lcd_active = ' . $lcd_active . ' AND DATE(ldm_follow_date) < ' . $currentDate . ' 
                AND ldm_status_id NOT IN (' . $ldm_status . ') THEN ldm.ldm_id ELSE null END )pending_leads,
                   (DATEDIFF(CURDATE(), STR_TO_DATE(CONCAT(make_year,"-",make_month,"-1"), "%Y-%m-%d"))/365 )*5000 target_km,used_car.city_id,used_car.created_date,
                    uco.case_id,up.expected_price,sci.id sales_case_id,uco.tradetype,used_car.min_selling_price,uco.permit,uco.permitvalid,uco.road_tx,uco.road_txvalid,uco.fitness_certi,uco.fitvalid,uco.reg_type');
        $this->db->from('crm_used_car as used_car');
        $this->db->join('crm_usedcar_certification_mapper as usedcar_certification_mapper', 'usedcar_certification_mapper.car_id = used_car.old_car_id', 'left');
        $this->db->join('crm_car_certification as car_certification', 'usedcar_certification_mapper.car_certification = car_certification.id', 'left');
        $this->db->join('crm_used_car_image_mapper as uim', 'uim.usedcar_id = used_car.id and uim.status in("1","3","2")', 'left');
        $this->db->join('crm_used_car_miscellaneous as ucm', 'ucm.usedcar_id = used_car.id', 'left');
        $this->db->join('crm_used_car_other_fields as uco', 'uco.cnt_id = used_car.id', 'left');
        $this->db->join('crm_usedcar_purchase_caseinfo as uci', 'uco.case_id=uci.id', 'left');
        $this->db->join('usedcar_payment_details as up', 'up.case_id = uco.case_id', 'left');
        $this->db->join('city_list as clist', 'clist.city_id = used_car.reg_place_city_id', 'left');
        $this->db->join('model_version as mv', 'mv.db_version_id=used_car.version_id', 'left');
        $this->db->join('make_model as mm', 'mm.id = mv.model_id', 'left');
        $this->db->join('crm_buy_lead_car_detail as lcd', 'lcd.lcd_car_id =used_car.id', 'left');
        $this->db->join('crm_buy_lead_dealer_mapper as ldm', 'ldm.ldm_id =lcd.lcd_lead_dealer_mapper_id', 'left');
        $this->db->join('crm_used_car_sale_case_info as sci', 'sci.car_id =used_car.id and sci.status="1" ', 'left');
        $this->db->where('used_car.dealer_id', $dealerId);
        if(!empty($carStatus)){
        $this->db->where_in('used_car.car_status', $carStatus);
        }
        $this->db->group_by('used_car.id');
        if (!empty($searchArray)) {
           // $this->getInventoryListingHavingSearch($searchArray);
        }
        if(!empty($carId)){
            $this->db->where('used_car.id', $carId);
        }
        $this->getInventoryOrderBy($searchArray);
        $this->db->limit($segment, $page);
        $query = $this->db->get();
       // echo $this->db->last_query(); exit;
       if(!empty($query)){
        return $query->result_array();
        }
        else{
            return true;
            }
    }

    public function getInventoryListingSearch($searchArray = array()) {
        $select = $this->db;
        $searchStr = '';
        if (isset($searchArray['invdashId']) && $searchArray['invdashId'] == '1') {
            $value = $this->all;
            $select->where_in('used_car.car_status', '1'); 
        }elseif(isset($searchArray['invdashId']) && $searchArray['invdashId'] == '2'){
            $select->where("   date(used_car.created_date) > DATE_ADD(CURDATE(), INTERVAL -45 DAY)");
        }
        if (isset($searchArray['tab_value']) && $searchArray['tab_value'] != '') {
            
            if ($searchArray['tab_value'] == 'all') {
                $value = $this->all;
                $select->where_in('used_car.car_status', $value);
            } elseif ($searchArray['tab_value'] == 'website') {
                $value = $this->webSite;
                $select->where_in('used_car.car_status', $value);
            } elseif ($searchArray['tab_value'] == 'removed') {
                $value = $this->removed;
                $select->where_in('used_car.car_status', $value);
            } elseif ($searchArray['tab_value'] == 'sold') {
                $value = $this->sold;
                $select->where_in('used_car.car_status', $value);
            }
            elseif ($searchArray['tab_value'] == 'refurb') {
                $value = $this->refurb;
                $select->where_in('used_car.car_status', $value);
            }
            elseif ($searchArray['tab_value'] == 'booked') {
                $value = $this->booked;
                $select->where_in('used_car.car_status', $value);
            }
            else {
                $value = '1';
                $select->where_in('used_car.car_status', $value);
            }
        } else {
            $value = '1';
            $select->where_in('used_car.car_status', $value);
        }

        if (isset($searchArray['duration']) && $searchArray['duration'] != '' && empty($searchArray['age_inventory'])) {
            if ($searchArray['duration'] == 5)
            //$searchStr .= "  (DATE(used_car.date5) > DATE_SUB(NOW(), INTERVAL 5 DAY))";
                $select->where(' (DATE(used_car.date5) > DATE_SUB(NOW(), INTERVAL 5 DAY))');
            if ($searchArray['duration'] == 10)
            //$searchStr .= "  (DATE(used_car.date5) BETWEEN DATE_SUB(NOW(), INTERVAL 10 DAY) AND DATE_SUB(NOW(), INTERVAL 5 DAY))";
                $select->where(' (DATE(used_car.date5) BETWEEN DATE_SUB(NOW(), INTERVAL 10 DAY) AND DATE_SUB(NOW(), INTERVAL 5 DAY))');
            if ($searchArray['duration'] == 20)
            //$searchStr .= "  (DATE(used_car.date5) BETWEEN DATE_SUB(NOW(), INTERVAL 20 DAY) AND DATE_SUB(NOW(), INTERVAL 10 DAY))";
                $select->where(' (DATE(used_car.date5) BETWEEN DATE_SUB(NOW(), INTERVAL 20 DAY) AND DATE_SUB(NOW(), INTERVAL 10 DAY))');
            if ($searchArray['duration'] == 30)
            //$searchStr .= "  (DATE(used_car.date5) BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND DATE_SUB(NOW(), INTERVAL 20 DAY))";
                $select->where(' (DATE(used_car.date5) BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND DATE_SUB(NOW(), INTERVAL 20 DAY))');
            if ($searchArray['duration'] == 40)
            //$searchStr .= "  (DATE(used_car.date5) < DATE_SUB(NOW(), INTERVAL 30 DAY))";
                $select->where(' (DATE(used_car.date5) < DATE_SUB(NOW(), INTERVAL 30 DAY))');
        }
        if (isset($searchArray['car_id_reg_no']) && $searchArray['car_id_reg_no'] != '') {
            $idRegNo = str_replace(array('-', '_', ' '), '', $searchArray['car_id_reg_no']);
            $select->where("replace(replace(replace(used_car.reg_no,' ',''),'-',''),'_','')=" . '"' . $idRegNo . '"');
        }
        if (!empty($searchArray['selected_mmv_car_id'])) {
            
            $select->where('used_car.id',$searchArray['selected_mmv_car_id']);
        }

        if (isset($searchArray['sell_dealer'])) {
            $where['ucm.sell_dealer'] = $searchArray['sell_dealer'];
            $select->where($where);
        }

        if (isset($searchArray['make']) && $searchArray['make'] != '') {
            $makeVal = explode(",", $searchArray['make']);
            $makeVal =  implode("','", $makeVal);
            $select->where_in('mm.make', $makeVal);
        }

        if (isset($searchArray['model']) && $searchArray['model'] != '') {
            $modelVal = $searchArray['model'];
            $select->where_in('mm.model', array_map('stripslashes',$modelVal));
        }

        if (isset($searchArray['fuel_type']) && $searchArray['fuel_type'] != '') {
            //print_r($searchArray['fuel_type']);die;
            $fuelType = $searchArray['fuel_type'];
            $fuelType = "'" . implode("','", $fuelType) . "'";
            if (stripos($fuelType, 'CNG') !== false) {
                $cngfitted = " OR used_car.is_cng_fitted='1' ";
            }
            if(isset($cngfitted)){
               $fuelCngSql = " ( upper(mv.uc_fuel_type) IN (" . $fuelType . ") $cngfitted ) "; 
            }else{
                $fuelCngSql = " ( upper(mv.uc_fuel_type) IN (" . $fuelType . ") ) ";
            }
            $select->where($fuelCngSql);
        }

        if (isset($searchArray['body_type']) && $searchArray['body_type'] != '') {
            $bodyval = $searchArray['body_type'];
            $bodyVal = "'" . implode("','", $bodyval) . "'";
            $select->where_in('upper(mv.uc_body_type)', $bodyVal);
        }

        if (isset($searchArray['owner']) && $searchArray['owner'] != '') {
            $getOwnerArr = $searchArray['owner'];
            $getOwnerStringArr = array_diff($getOwnerArr, array('Above 4'));
            if (in_array('Above 4', $getOwnerArr)) {
                if (count($getOwnerArr) > 1) {
                    $ownerString = $searchArray['owner'];
                    $ownerString = "'" . implode("','", $getOwnerStringArr) . "'";
                    $select->where(" (used_car.owner_type > '4' OR used_car.owner_type IN (" . $ownerString . "))");
                } else {
                    $select->where(" used_car.owner_type > '4' ");
                }
            } else {
                $ownerString = $searchArray['owner'];
                $ownerString = "'" . implode("','", $ownerString) . "'";
                $select->where(" used_car.owner_type IN (" . $ownerString . ") ");
            }
        }

        if (isset($searchArray['ispremium']) && $searchArray['ispremium'] != '') {
            $select->where("  used_car.is_feature", '1');
        }
        if (isset($searchArray['isclassified_tab']) && $searchArray['isclassified_tab'] != '' && isset($searchArray['nonclassified_tab']) && $searchArray['nonclassified_tab'] != '') {
            
        } else {
            if (isset($searchArray['isclassified_tab']) && $searchArray['isclassified_tab'] != '') {
                $select->where("  used_car.is_gaadi", '1');
            }
            if (isset($searchArray['nonclassified_tab']) && $searchArray['nonclassified_tab'] != '') {
                $select->where("  used_car.is_gaadi", '0');
            }
        }

        if (isset($searchArray['bringontop']) && $searchArray['bringontop'] != '') {
            $timelesstean = date("Y-m-d H:i:s", time() - 172800);
            $select->where("  used_car.last_bring_top_time <= '" . $timelesstean . "' ");
        }
        
        if (isset($searchArray['car_withPhotos']) && $searchArray['car_withPhotos'] != '' && isset($searchArray['car_withoutPhotos']) && $searchArray['car_withoutPhotos'] != '') {
            //array_push();
        } else {
            if (isset($searchArray['car_withPhotos']) && $searchArray['car_withPhotos'] != '') {
                $select->where("  uim.id IS NOT NULL");
            }
            if (isset($searchArray['car_withoutPhotos']) && $searchArray['car_withoutPhotos'] != '') {
                $select->where("   uim.id IS  NULL  ");
            }
        }

        if (isset($searchArray['trustmark-certified']) && $searchArray['trustmark-certified'] != '' && isset($searchArray['trustmark-uncertified']) && $searchArray['trustmark-uncertified'] != '') {
            
        } else {
            if (isset($searchArray['trustmark-certified']) && $searchArray['trustmark-certified'] != '') {
                $select->where("  car_certification.id='18' ");
            }
            if (isset($searchArray['trustmark-uncertified']) && $searchArray['trustmark-uncertified'] != '') {
                $select->where("  car_certification.id!='18' ");
            }
        }
        if (!empty($searchArray['inspection_status'])) {

            $inspectionval = $searchArray['inspection_status'];

            if (in_array('2', $inspectionval)) {

                array_push($inspectionval, '5');
            }
            //$inspectionval = "'" . implode("','", $inspectionval) . "'";
            //$searchStr     .= " used_car.certification_status IN (" . $inspectionval . ") ";
            $select->where_in(' used_car.certification_status', $inspectionval);
        }
        if (isset($searchArray['transmission_type']) && $searchArray['transmission_type'] != '') {
            $transmissionval = $searchArray['transmission_type'];
            $select->where_in(' mv.uc_transmission', $transmissionval);
        }
        if (isset($searchArray['old_stock']) && $searchArray['old_stock'] == '45_days') {
            //$searchStr .= " ( DATE(used_car.created_date) <= DATE_SUB(CURDATE(), INTERVAL 45 DAY)) ";
            $select->where(" ( DATE(used_car.created_date) <= DATE_SUB(CURDATE(), INTERVAL 45 DAY)) ");
        }

        if (isset($searchArray['select_km_min_list']) && $searchArray['select_km_min_list'] != '') {
            $select->where(" used_car.km_driven >=  '$searchArray[select_km_min_list]'");
        }
        if (isset($searchArray['select_km_max_list']) && $searchArray['select_km_max_list'] != '') {
            $select->where(" used_car.km_driven <=  '$searchArray[select_km_max_list]' ");
        }

        if (isset($searchArray['manage_dealer_inventory']) && $searchArray['manage_dealer_inventory'] == 1) {

            if (isset($searchArray['select_price_min_list']) && $searchArray['select_price_min_list'] != '') {
                //$searchStr .= " used_car.dealer_price >=  '$searchArray[select_price_min_list]'";
                $select->where(" used_car.dealer_price >=  '$searchArray[select_price_min_list]'");
            }
            if (isset($searchArray['select_price_max_list']) && $searchArray['select_price_max_list'] != '') {
                //$searchStr .= " used_car.dealer_price <=  '$searchArray[select_price_max_list]' ";
                $select->where(" used_car.dealer_price <=  '$searchArray[select_price_max_list]' ");
            }
        } else {

            if (isset($searchArray['select_price_min_list']) && $searchArray['select_price_min_list'] != '') {
                //$searchStr .= " used_car.car_price >=  '$searchArray[select_price_min_list]'";
                $select->where(" used_car.car_price >=  '$searchArray[select_price_min_list]'");
            }
            if (isset($searchArray['select_price_max_list']) && $searchArray['select_price_max_list'] != '') {
                //$searchStr .= " used_car.car_price <=  '$searchArray[select_price_max_list]' ";
                $select->where(" used_car.car_price <=  '$searchArray[select_price_max_list]' ");
            }
        }




        if (isset($searchArray['select_myear_from_list']) && $searchArray['select_myear_from_list'] != '') {
            //$searchStr .= " used_car.make_year >=  '$searchArray[select_myear_from_list]'";
            $select->where(" used_car.make_year >=  '".$searchArray['select_myear_from_list']."'");
        }
        if (isset($searchArray['select_myear_to_list']) && $searchArray['select_myear_to_list'] != '') {
            $searchStr .= " used_car.make_year =  '$searchArray[select_myear_to_list]' ";
            $select->where(" used_car.make_year =  '$searchArray[select_myear_to_list]' ");
        }


        if (isset($searchArray['is_rsa']) && $searchArray['is_rsa'] != '') {
            //$searchStr .= "   used_car.make_year > YEAR(DATE_SUB(CURDATE(), INTERVAL 10 YEAR)) and used_car.certification_status in ('1','4','5','6','7') and rcvd.rsa_id IS NULL ";
            $select->where("   used_car.make_year > YEAR(DATE_SUB(CURDATE(), INTERVAL 10 YEAR)) and used_car.certification_status in ('1','4','5','6','7') and rcvd.rsa_id IS NULL ");
            if ($listType == 'removed') {
                $value = 19769863;
            }
            if ($listType == 'all') {
                $value = '1';
            }
        }
        /*
         *  Tips section for DA
         */
        if (isset($searchArray['issue_old_stock']) && $searchArray['issue_old_stock'] == 1) {
            //$searchStr .= "   date(used_car.created_date) < DATE_ADD(CURDATE(), INTERVAL -45 DAY)";
            $select->where("   date(used_car.created_date) < DATE_ADD(CURDATE(), INTERVAL -45 DAY)");
        }
        if (isset($searchArray['issue_year_km']) && $searchArray['issue_year_km'] == 1) {
            //$searchStr .= "  used_car.make_year < YEAR(DATE_SUB(CURDATE(), INTERVAL 5 YEAR)) and used_car.km_driven>80000";
            $select->where("  used_car.make_year < YEAR(DATE_SUB(CURDATE(), INTERVAL 5 YEAR)) and used_car.km_driven>80000");
        }
        if (isset($searchArray['age_inventory']) && $searchArray['age_inventory'] != '') {
            //$havingStr .= " AND( ";
            //Within 30 days
            if (in_array('30_days', $searchArray['age_inventory'])) {
                $select->where(" DATE(used_car.created_date) >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) ");
            }
            //Between 31 to 60 days
            if (in_array('btw_31_60_days', $searchArray['age_inventory'])) {
                $select->or_where(" (DATE(used_car.created_date) >= DATE_SUB(CURDATE(), INTERVAL 2 MONTH) AND DATE(used_car.created_date) < DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) ");
            }
            //Between 61 to 90 days
            if (in_array('btw_61_90_days', $searchArray['age_inventory'])) {
                $select->or_where(" (DATE(used_car.created_date) >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND DATE(used_car.created_date) < DATE_SUB(CURDATE(), INTERVAL 2 MONTH)) ");
            }
            //Above 90 days
            if (in_array('above_90_days', $searchArray['age_inventory'])) {
                $select->or_where(" (DATE(used_car.created_date) < DATE_SUB(CURDATE(), INTERVAL 3 MONTH)) ");
            }

            //$havingStr = $havingStr . " 1=2 ) ";
        }
        
        
        return $select;
    }
    
    public function getInventoryOrderBy($searchArray = array()){
        $select = $this->db;
        if (isset($searchArray['sortby']) && $searchArray['sortby'] == 'pricefrom-DESC')
        {
            //$orderBY = ' ORDER BY used_car.dealer_price desc ';
            $select->order_by('used_car.car_price','desc');
        }
        elseif (isset($searchArray['sortby']) && $searchArray['sortby'] == 'pricefrom-ASC')
        {
            //$orderBY = ' ORDER BY used_car.dealer_price ';
            $select->order_by('used_car.car_price','asc');
        }
        elseif (isset($searchArray['sortby']) && $searchArray['sortby'] == 'myear-DESC')
        {
            //$orderBY = ' ORDER BY used_car.myear desc,CAST(used_car.month as SIGNED INTEGER) desc ';
            $select->order_by('used_car.make_year,used_car.make_month','desc');
        }
        elseif (isset($searchArray['sortby']) && $searchArray['sortby'] == 'myear-ASC')
        {
            //$orderBY = ' ORDER BY used_car.myear,CAST(used_car.month as SIGNED INTEGER) ';
            $select->order_by('used_car.make_year,used_car.make_month','asc');
        }
        elseif (isset($searchArray['sortby']) && $searchArray['sortby'] == 'km-DESC')
        {
            //$orderBY = ' ORDER BY used_car.km desc ';
            $select->order_by('used_car.km_driven','desc');
        }
        elseif (isset($searchArray['sortby']) && $searchArray['sortby'] == 'km-ASC')
        {
            //$orderBY = ' ORDER BY used_car.km ';
            $select->order_by('used_car.km_driven','asc');
        }
        elseif (isset($searchArray['sortby']) && $searchArray['sortby'] == 'profile-DESC')
        {
            //$orderBY = ' ORDER BY used_car.profile_complete desc ';
            $select->order_by('used_car.profile_complete','desc');
        }
        elseif (isset($searchArray['sortby']) && $searchArray['sortby'] == 'profile-ASC')
        {
            //$orderBY = ' ORDER BY used_car.profile_complete ';
             $select->order_by('used_car.profile_complete','asc');
        }
        elseif (isset($searchArray['sortby']) && $searchArray['sortby'] == 'make-DESC')
        {
            //$orderBY = ' ORDER BY used_car.make desc,used_car.model desc ';
            $select->order_by('mm.make,mm.model','desc');
        }
        elseif (isset($searchArray['sortby']) && $searchArray['sortby'] == 'make-ASC')
        {
            //$orderBY = ' ORDER BY used_car.make,used_car.model ';
            $select->order_by('mm.make,mm.model','asc');
        }
        else
        {
            //$orderBY = ' ORDER BY `used_car`.updated_date DESC ';
            $select->order_by('used_car.last_update_date','desc');
        }
        
        //$select->order_by($orderBY);
        return $select;
    }

    public function getInventoryListingHavingSearch($searchArray = array()) {
        $select = $this->db;
        $havingStr = ' 1=1 ';
        if (isset($searchArray['car_with_issues'])) {
            $havingStr .= " and  imgWithIssueCount >0 ";
        }
        /**
         * @Filter age of inventory
         */
       /* if (isset($searchArray['age_inventory']) && $searchArray['age_inventory'] != '') {
            $havingStr .= " AND( ";
            //Within 30 days
            if (in_array('30_days', $searchArray['age_inventory'])) {
                $havingStr .= " DATE(used_car.created_date) >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) OR ";
            }
            //Between 31 to 60 days
            if (in_array('btw_31_60_days', $searchArray['age_inventory'])) {
                $havingStr .= " (DATE(used_car.created_date) >= DATE_SUB(CURDATE(), INTERVAL 2 MONTH) AND DATE(used_car.created_date) < DATE_SUB(CURDATE(), INTERVAL 1 MONTH))  OR ";
            }
            //Between 61 to 90 days
            if (in_array('btw_61_90_days', $searchArray['age_inventory'])) {
                $havingStr .= " (DATE(used_car.created_date) >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND DATE(used_car.created_date) < DATE_SUB(CURDATE(), INTERVAL 2 MONTH)) OR ";
            }
            //Above 90 days
            if (in_array('above_90_days', $searchArray['age_inventory'])) {
                $havingStr .= " (DATE(used_car.created_date) < DATE_SUB(CURDATE(), INTERVAL 3 MONTH)) OR ";
            }

            $havingStr = $havingStr . " 1=2 ) ";
        }*/

        if (isset($searchArray['pending_leads']) && $searchArray['pending_leads'] == 1) {
            $havingStr .= " AND pending_leads>5 ";
        }

        if (isset($searchArray['total_active_leads']) && $searchArray['total_active_leads'] == 1) {
            $havingStr .= " AND total_active_leads>50 ";
        }
        if (isset($searchArray['doubtfull_inventory']) && $searchArray['doubtfull_inventory'] == 1) {
            $havingStr .= "AND  km_driven < target_km ";
        }
        $select->having($havingStr);
        return $select;
    }

    function getStockSMSData($car_id){
           
           $this->db->select('used_car.id gaadi_id,
           mm.make, mm.model,used_car.make_year, mv.db_version carversion, 
           mv.uc_fuel_type fuel_type,km_driven km, car_price pricefrom, colour,used_car.owner_type as owner');
           $this->db->from('crm_used_car as used_car');
           //$this->db->join('crm_dealers','used_car.dealer_id=crm_dealers.id','inner');
           //$this->db->join('crm_dealers_template_settings ts','ts.dealer_id=dc_dealers.id','inner');
           $this->db->join('model_version mv','used_car.version_id=mv.db_version_id','inner');
           $this->db->join('make_model mm','mm.id=mv.model_id','inner');
           $this->db->where('used_car.id', $car_id);
           $query=$this->db->get();
           //echo $this->db->last_query();die;
           return $query->row_array();
       } 
       
        function getAllUsedCarImages($car_id = false) {
        $data = [];
        //echo $car_id; exit;
        if ($car_id) {
            $sql = "select  id,image_url,image_name,tag_id from crm_used_car_image_mapper as im  where im.usedcar_id='" . $car_id . "'  and im.status='1'";
            $data = $this->db->query($sql, [])->result_array();
            if(!empty($data)){
                return $data;
            }else{
                
               $data[0]['image_url']=base_url('assets/admin_assets/images/used-car-no-img.png'); 
               return $data;
            }
        } else {
            return [];
        }
    }

    public function getDealerSku($dealer_id, $skuId, $attributeId) {
        $sql = "SELECT * FROM crm_dealers_services AS dc WHERE dc.status='1' and dc.dealer_id='" . $dealer_id . "' AND sku_id ='" . $skuId . "' AND attribute_id ='" . $attributeId . "'";
        $data = $this->db->query($sql, [])->result_array();
        return $data;
    }

    public function getFeatureCount($dealer_id) {

        $sql = "Select count(*) as total from crm_used_car where is_feature='1' and car_status='1' and dealer_id='" . $dealer_id . "'";
        $data = $this->db->query($sql, [])->result_array();
        return $data[0];
    }
    
    public function getCrmStockDetails($case_id){
        
    }

    public function managepremium($carid, $status) {
        if (!empty($status) && !empty($carid)) {
             $update = $this->db->update('crm_used_car', $status, array('id' => $carid));
            //echo $this->db->last_query();die;
            return $update ? true : false;
        } else {
            return false;
        }
    }
    public function addtoAvailablestock($carid, $status='') {
        $lastupdatedate=date('Y-m-d H:i:s');
        if (!empty($status) && !empty($carid)) {
            //$premiumupdate = $this->db->update('crm_used_car', $status, array('id' => $carid));
            if ($status['is_feature'] == '1') {
                $update = $this->db->update('crm_used_car', array('is_gaadi' => '1','car_status' => '1','last_update_date' => $lastupdatedate), array('id' => $carid));
            }
            return $update ? true : false;
        } else {
            $update = $this->db->update('crm_used_car', array('car_status' => '1'), array('id' => $carid));
            return true;
        }
    }
    public function updateClassified($data,$carId){
       if (!empty($data) && !empty($carId)) {
            $update = $this->db->update('crm_used_car', $data, array('id' => $carId)); 
            return $update ? true : false;
       }
       return $update ? true : false;
    }

    public function getcarDetail($carId, $fields = '') {
        if (!empty($fields)) {
            $fields = implode(',', $fields);
        } else {
            $fields = '*';
        }
        $sql = "select " . $fields . " from crm_used_car where id=" . $carId . "";
        $carDetail = $this->db->query($sql, [])->result_array();
        $carDetail=$carDetail[0];
        return $carDetail;
    }

    public function getMmvDetailsByVersionId($version_id = '') {
        $sql="select mm.id model_id,mm.model,mm.make_id,mm.make,mv.db_version_id version_id,mv.db_version_model carversion,mv.uc_fuel_type fuel_type,mv.uc_body_type body_style,mv.uc_transmission transmission from make_model as mm JOIN  model_version as mv ON mm.id=mv.model_id where  mv.db_version_id='" . $version_id . "' and mv.dis_cont IN('0','1') and mm.dis_cont IN('0','1') ";
        $data = $this->db->query($sql, [])->result_array();
        $data=$data[0];
        return $data;
    }
    public function getMakeModelVersionId($SourceMake,$SourceModel,$SourceVersion){
        echo $sql="select mm.make_id,mv.model_id,mv.db_version_id from make_model as mm JOIN model_version as mv ON mm.id=mv.model_id where mm.make='" . trim($SourceMake) . "' and mm.model='" . trim($SourceModel) . "' and mv.db_version='" . trim($SourceVersion) . "'";
        $data = $this->db->query($sql, [])->result_array();
        return $data;      
    }
    
    public function CheckDuplicateInventory($data = [], $car_id)
    {
        global $db;
        $version_id = $data['version_id'];
        $colour     = $data['colour'];
        $km_driven  = $data['km_driven'];
        $car_price  = $data['car_price'];
        $dealer_id  = $data['dealer_id'];
        $AND        = '';
        if (!empty($car_id))
        {
            $AND .= ' AND id !=' . $car_id;
        }
        $sql        = "SELECT id FROM crm_used_car WHERE car_status='1' AND version_id='$version_id' "
                . "AND colour='$colour' AND km_driven='$km_driven' AND car_price='$car_price'  AND dealer_id='$dealer_id' " . $AND;
        $data = $this->db->query($sql, [])->result_array();
        $returnData=(!empty($data[0])) ? $data[0] : '';
        return $returnData;
    }
    
    public function getupdateRetailPrice($data,$carId){
        if (!empty($data) && !empty($carId)) {
            $priceupdate = $this->db->update('crm_used_car', $data, array('id' => $carId));
            return $priceupdate ? true : false;
        } else {
            return false;
        }
    }
    
    public function getProfileImage($carId){
        $sql        = "SELECT image_name,image_url,is_on_cdn,sent_to_aws FROM crm_used_car_image_mapper WHERE usedcar_id='$carId' AND status='1' order by `order` asc ";
        $returnData = $this->db->query($sql, [])->result_array();
        return $returnData;
    }
    
    public function getWarrantyPackage($recommendedPackage){
        $sql        = "SELECT pack_name, pack_type, pack_short_name, pack_short_type FROM crm_used_car_warranty_package WHERE pack_id IN(" . $recommendedPackage . ")";
        $returnData = $this->db->query($sql, [])->result_array();
        return $returnData;
    }
    
    public function getClassifiedCars($dealer_id){
        $sql        = "SELECT count(uc.is_gaadi) as totalClassified FROM crm_used_car uc WHERE uc.dealer_id ='" . $dealer_id . "' and uc.is_gaadi='1' and uc.car_status='1'";
        $returnData = $this->db->query($sql, [])->result_array();
        return $returnData;
    }
    
    public function getDealerDetails($dealer_id=0)
    {
        $sql = 'select d.id,d.status,du.name,du.email,du.mobile,cl.city_name ,ds.attribute_value classified_limit,'
                . ' s.city_id,ts.domain from crm_dealers d '
                . ' left join crm_dealer_user_mapping dum  on d.id=dum.dealer_id and dum.status="1"  '
                . ' left join crm_user du on dum.user_id=du.id  and du.status="1"  '
                . ' left join crm_admin_dealers ts on ts.dealer_id=d.id    '
                . ' left join crm_showrooms s on s.dealer_id=d.id and s.is_primary="1" and s.status="1" '
                . ' left join city_list cl on cl.city_id=s.city_id '
                . ' left join crm_dealers_services ds on ds.dealer_id=d.id and ds.status="1" and ds.sku_id="1" and ds.attribute_id="8" '
                . ' where d.id='. $dealer_id;
        $returnData = $this->db->query($sql, [])->result_array();
        return $returnData;
    }
    
    public function getStockRemovalReasons(){
        $sql        = "select  * from  stock_removal_reason where status='1'";
        $returnData = $this->db->query($sql, [])->result_array();
        return $returnData;
        
    }
    public function getCityList(){
       $sql        = "select  * from  city_list where con_id=1 order by order_by,city_name asc";
       $returnData = $this->db->query($sql, [])->result_array();
       return $returnData; 
    }
    
    public function updateMarktoSold($data,$carId){
        if (!empty($data) && !empty($carId)) {
            $soldupdate = $this->db->update('crm_used_car', $data, array('id' => $carId));
     
            //echo $this->db->last_query();die;
            return $soldupdate ? true : false;
        } else {
            return false;
        }
    }
    
    public function getleadCount($carId){
       $sql        = "select  * from  crm_buy_lead_car_detail where lcd_car_id=".$carId." and lcd_active='1' group by lcd_lead_dealer_mapper_id";
       $returnData = $this->db->query($sql, [])->result_array();
       return $returnData; 
    }

    public function getAllImages($car_id,$status=1)
    {
        $this->db->select('image_name,tag_id,image_url,is_on_cdn,sent_to_aws,rejected_reason');
        $this->db->order_by('order','asc');
        $selectParents =  $this->db->get_where(USED_CAR_IMAGE_MAPPER,array('usedcar_id'=>$car_id,'status'=>$status));
        return $selectParents = $selectParents->result_array();
    }
    public function getAllImagesCount($car_id)
    {
        $this->db->select('count(id)img_count,status');
        $this->db->group_by('status');
        $selectParents =  $this->db->get_where(USED_CAR_IMAGE_MAPPER,array('usedcar_id'=>$car_id));
        return $selectParents = $selectParents->result_array();
    }

   public function getTags() {
        $selectParents =  $this->db->get_where(USEDCAR_TAGS,array('parent'=>'0'));
        $selectParents = $selectParents->result_array();
            if(!empty($selectParents))
                {
                    $i=0;
                    foreach($selectParents as $key=>$val)
                        {
                            $selectParents[$i]['id']=$val['id'];
                            $selectParents[$i]['tag_name']=$val['tag_name'];
                            $selectParents[$i]['parent']=$val['parent'];
                            $selectChilds =  $this->db->get_where(USEDCAR_TAGS,array('parent',$val['id']));
                            $selectChilds = $selectChilds->result_array();
                             //$selectChilds = $db->fetchRows("select * from usedcar_tags where parent=".$val[id]);
                             foreach($selectChilds as $keys=>$vals)
                            {
                            $i++;
                                $selectParents[$i]['id']=$vals['id'];
                                $selectParents[$i]['tag_name']=$vals['tag_name'];
                                $selectParents[$i]['parent']=$vals['parent'];
                            }
                            
                        $i++;}
                }
        return $selectParents;
    }

    public function updateImgTag($tag_id,$carId,$image)
    {
        //print_r($image);
        $data = [];
        $data['tag_id'] = $tag_id;
        $this->db->where('image_name',$image);
        $soldupdate = $this->db->update(USED_CAR_IMAGE_MAPPER, $data, array('usedcar_id' => $carId));
        //echo $this->db->last_query();
       return $soldupdate ? true : false;
    }

    public function upload_new_image(){
        $file_name_key              = key($_FILES);
        $config['upload_path']      = UPLOAD_IMAGE_PATH.'uploaddoc/';
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
            $error  = array('Invalid Request!');
            $result = array('error' => $error, 'status' => 400);
        }
        exit;
    }
   // manageCarImages($imageArray,$car_id)
    
    public function isCarImageExist($car_id)
    {
        $this->db->select('count(id) as exitsimage');
        $selectParents =  $this->db->get_where(USED_CAR_IMAGE_MAPPER,array('usedcar_id'=>$car_id,'status'=>'1'));
        $selectParents = $selectParents->result_array();
        return $selectParents[0];
    }
    
    public function isClassified($car_id) {

        $sql = "Select is_gaadi as isclassified from crm_used_car where is_gaadi='1' and id='" . $car_id . "'";
        $data = $this->db->query($sql, [])->result_array();
        return $data;
    }

    public function usedCarPurchaseCat($parent_id='0',$id='')
    {
        $this->db->select('*');
        $this->db->from('crm_usedcar_purchase_category');
        $this->db->where('status', '1');
        $this->db->where('parent_id', $parent_id);
        if(!empty($id))
        {
          $this->db->where('id', $id);
        }
         $this->db->order_by('order_no', 'asc');
        $query = $this->db->get();
       // echo $this->db->last_query(); exit;
        $result = $query->result_array();
        return  $result; 
    }

    public function addCrmUsedcarPurchaseCaseinfo($data,$id='')
    {
        if(empty($id))
        {
            $this->db->trans_start();
            $this->db->insert('crm_usedcar_purchase_caseinfo', $data);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
            
        }
        else
        {
            $this->db->where('id', $id);
            $this->db->update('crm_usedcar_purchase_caseinfo', $data);
            $result = $id;
        }
        //echo $this->db->last_query(); exit;
        return $result;
    }


    public function getPaymentInfo($caseId='',$id='',$car_id='')
    {
        $this->db->select('*');
        $this->db->from('usedcar_payment_details');
        if(!empty($caseId))
        {
            $this->db->where('case_id', $caseId);
        }
        if(!empty($id))
        {
             $this->db->where('id', $id);
        }
        if(!empty($car_id))
        {
             $this->db->where('car_id', $car_id);
        }
        $this->db->where('status', '1');
        $query = $this->db->get();
      //echo $this->db->last_query(); exit;
        $result = $query->result_array();
        return  $result; 

    }

    public function getUsedcarInfo($id)
    {
       // echo "erfer"; exit;
        $this->db->select('uci.id as case_id,uci.is_case_details_completed,uci.cat_id,uci.name_id,uci.evaluation_date,uci.evaluated_by,uci.overall_condition,uci.evaluation_remark,uci.purchased_by,uci.closed_by,uci.purchase_date,uci.delivery_date,uci.created_by,uci.updated_by,uci.created_date,uci.updated_date,uci.status,uci.liquid_mode,uc.id as car_id,uc.dealer_id,uc.version_id,uc.showroom_id,uc.city_id,uc.locality_id,uc.reg_place_city_id,uc.reference_id,uc.domain_id,uc.car_status,uc.km_driven,uc.sold_price,
           , uc.car_price,uc.colour,uc.owner_type,uc.make_month,uc.make_year,uc.insurance_type,uc.insurance_exp_year,uc.insurance_exp_month,uc.insurer_id,uc.insurance_policy_no,uc.reg_no,uc.reg_date,uc.reg_month,uc.reg_year,uc.is_reg_no_show,uc.reg_rto_city,uc.is_cng_fitted,mv.uc_fuel_type as fuel_type,uco.sell_cust_car_id,
            uc.tax_type,uc.user_type,uc.listing_type,uc.car_description,uc.car_emi,uc.special_offer,uc.otp_verified,uco.id as cnt_other_id,uco.tradetype,uco.refurb,uco.hypo,uco.hypo,uco.paidoff,uco.35noc,uco.listing_price,uco.customer_id,uco.seller_type,uco.seller_name,uco.seller_mobile,uco.seller_email,uco.seller_address, mm.model,mm.id model_id,mm.make,mm.make_id,mv.db_version as carversion,mv.db_version_id,clist.city_name as RegCity,uco.bank_id,uco.upload_car_photos,uco.car_photo_uploaded_at,uco.car_photo_updated_at,uco.car_photo_created_by,up.id as purchasepriceid,up.purchaseprice,up.expected_price,uco.upload_car_docs,uco.upload_car_docs_created_by,uco.print_docs,uco.upload_car_docs_created_on,upload_car_docs_updated_on,uco.engineno,uco.chassisno,uco.rtostate,uco.rto,uco.insurance_date,uco.refurbdetail,uco.paymentdetail,uco.commission,uco.insurance as ins_pri,uco.rent,uco.refurb_cost,uco.misc_exp,uc.min_selling_price,uco.permit,uco.permitvalid,uco.road_txvalid,uco.road_tx,uco.fitvalid,uco.fitness_certi,uco.reg_type,uco.reg_date');
        $this->db->from('crm_usedcar_purchase_caseinfo as uci');
        $this->db->join('crm_used_car_other_fields as uco','uco.case_id=uci.id','left');
        $this->db->join('crm_used_car as uc','uco.cnt_id=uc.id','left');
        $this->db->join('crm_used_car_image_mapper as uim', 'uim.usedcar_id = uc.id and uim.status in("1","3","2")', 'left');
        $this->db->join('city_list as clist', 'clist.city_id = uc.reg_place_city_id', 'left');
        $this->db->join('model_version as mv', 'mv.db_version_id=uc.version_id', 'left');
        $this->db->join('make_model as mm', 'mm.id = mv.model_id', 'left');
         $this->db->join('usedcar_payment_details as up', 'up.case_id = uci.id', 'left');
        $this->db->where('uci.status', '1');
        if(!empty($id))
        {
          $this->db->where('uci.id', $id);
        }
        $query = $this->db->get();
      //echo $this->db->last_query(); exit;
      if(!empty($query)){
        return $query->result_array();
        }
        else{
            return true;
            }
       // $result = $query->result_array();
       // return  $result; 
    }
    
    
    public function getPriceBreakUp($car_id,$case_id){
        $this->db->select('*');
        $this->db->from('usedcar_price_breakup');
        $this->db->where('case_id',$case_id);
        $this->db->where('car_id',$car_id);
        $query = $this->db->get();
        if(!empty($query)){
        return $query->result_array();
        }
        else{
            return true;
            }
       // $result = $query->result_array();
        //return $result;
    }
    
    
   public function getWebsiteLink($car_id,$case_id=''){
        $this->db->select('*');
        $this->db->from('usedcar_website_link');
        if(!empty($case_id))
        $this->db->where('case_id',$case_id);
        $this->db->where('car_id',$car_id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

        function getAllTagUsedCarImages($car_id = false,$img='',$tag_id='') 
        {
            $data = [];
            $this->db->select('uci.*,cdm.is_required,cat.id as parent_id,cat.parent_name,scat.id as sub_category_id,scat.name as sub_name');
            $this->db->from('crm_used_car_image_mapper as uci');
            $this->db->join('crm_upload_doc_list_mapping as cdm','cdm.sub_category_id=uci.tag_id','left');
            $this->db->join('upload_doc_category_list as cat','cat.id=cdm.parent_id','left');
            $this->db->join('upload_doc_sub_category_list as scat','scat.id=cdm.sub_category_id','left');
            if(!empty($car_id))
            {
                $this->db->where('uci.usedcar_id', $car_id);
            }
            if(!empty($img))
            {
                $this->db->where('uci.id', $img);  
            }
            if(!empty($tag_id))
            {
                $this->db->where('uci.tag_id', $tag_id);  
            }
            //need to review this line
            $this->db->group_by('uci.id');  
            $this->db->where('uci.status', '1');  
            $query = $this->db->get();
            $result = $query->result_array();
           // echo $this->db->last_query(); exit;
            return  $result; 
       
        }
    function addUsedcarPersonnel($data,$id=''){
    if(empty($id))
        {
            $this->db->trans_start();
            $this->db->insert('usedcar_payment_details', $data);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
            
        }
        else
        {
            $this->db->where('id', $id);
            $this->db->update('usedcar_payment_details', $data);
            $result = $id;
        }
        //echo $this->db->last_query(); exit;
        return $result;
}
    public function getPaymentDoneByCash($case_id,$id=0)
    {
        $this->db->select('sum(amount) paid');
        $this->db->from('usedcar_payment_details');
        $this->db->where('status', '1');
        $this->db->where('case_id', $case_id);
        $this->db->where('instrumenttype', '1');
        if(!empty($id)){
           $this->db->where('id !=', $id); 
        }
        $this->db->group_by('case_id');
        $query = $this->db->get();
        
        return $query->row_array();
    }
    public function getAmountPaid($case_id,$id)
    {
        $this->db->select('sum(amount) paid');
        $this->db->from('usedcar_payment_details');
        $this->db->where('status', '1');
        $this->db->where('case_id', $case_id);
        if(!empty($id)){
           $this->db->where('id !=', $id); 
        }
        $this->db->group_by('case_id');
        $query = $this->db->get();
        
        return $query->row_array();
    }

    function addUsedcarRefurb($data,$id='')
 {
    if(empty($id))
        {
            $this->db->trans_start();
            $this->db->insert('usedcar_refurb_details', $data);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result = $insert_id;
            
        }
        else
        {
            $this->db->where('id', $id);
            $this->db->update('usedcar_refurb_details', $data);
            $result = $id;
        }
        //echo $this->db->last_query(); exit;
        return $result;
}
   public function getRefurbInfo($caseId='',$id='',$car_id='')
    {
        $this->db->select('*');
        $this->db->from('usedcar_refurb_details');
        if(!empty($caseId))
        {
            $this->db->where('case_id', $caseId);
        }
        if(!empty($id))
        {
             $this->db->where('id', $id);
        }
        if(!empty($car_id))
        {
             $this->db->where('car_id', $car_id);
        }
        $this->db->where('status', '1');
        $query = $this->db->get();
      //echo $this->db->last_query(); exit;
        $result = $query->result_array();
        return  $result; 

    }
    public function isPurchaseFormCompleted($result){
      
        if(!empty($result[0]['case_id']) //case info 
            && !empty($result[0]['car_id']) //car details
            && !empty($result[0]['upload_car_photos']) //car photos
            && !empty($result[0]['customer_id']) //seller details
            && !empty($result[0]['upload_car_docs']) //documents
            && !empty($result[0]['purchasepriceid'])) //payments
        {
            return true;
        }
        return  false; 
    }
    public function getUcPurchaseEditLink($result){
        //print_r($result);die;
        if(empty($result[0]['case_id'])){
            return base_url().'usedcarpurchase/'.base64_encode(DEALER_ID.'_'.$result[0]['case_id']);
        }
        if(empty($result[0]['car_id'])){
            return base_url().'cardetails/'.base64_encode(DEALER_ID.'_'.$result[0]['case_id']);
        }
        if(empty($result[0]['upload_car_photos'])){
            return base_url().'uploadcardocs/'.base64_encode(DEALER_ID.'_'.$result[0]['case_id']);
        }
        if(empty($result[0]['customer_id'])){
            return base_url().'sellerdetails/'.base64_encode(DEALER_ID.'_'.$result[0]['case_id']);
        }
        if(empty($result[0]['upload_car_docs'])){
            return base_url().'uploadcardocs/'.base64_encode(DEALER_ID.'_'.$result[0]['case_id']).'/dis';
        }
        if(empty($result[0]['purchasepriceid'])){
            return base_url().'paymentdetails/'.base64_encode(DEALER_ID.'_'.$result[0]['case_id']);
        }
        return base_url().'usedcarpurchase/'.base64_encode(DEALER_ID.'_'.$result[0]['case_id']);
        
        
    }
    public function getUcSalesEditLink($result,$car_id,$sales_case_id){
        //print_r($result);die;
        if(empty($result[0]['case_id'])){
            return base_url() . 'addUcBuyerLead/'.base64_encode($car_id.'_'.$sales_case_id);
        }
        if(empty($result[0]['trnx_id'])){
            return base_url() . 'ucSalesTxnDetails/'.base64_encode($car_id.'_'.$sales_case_id);
        }
        if(empty($result[0]['booking_id'])){
            return base_url() . 'ucSalesBookingDetails/'.base64_encode($car_id.'_'.$sales_case_id);
        }
        if(empty($result[0]['is_buyer_docs_uploaded'])){
            return base_url() . 'uploadUcSalesDocument/'.base64_encode($car_id.'_'.$sales_case_id);
        }
        if(empty($result[0]['is_vehicle_images_uploaded'])){
            return base_url() . 'uploadUcSalesDocument/'.base64_encode($car_id.'_'.$sales_case_id).'/diss';
        }
        if(empty($result[0]['payment_id'])){
            return base_url() . 'ucSalesPaymentDetails/'.base64_encode($car_id.'_'.$sales_case_id);
        }
        if(empty($result[0]['delivery_id'])){
            return base_url() . 'ucSalesDeliveryDetails/'.base64_encode($car_id.'_'.$sales_case_id);
        }
        return base_url() . 'addUcBuyerLead/'.base64_encode($car_id.'_'.$sales_case_id);
        
        
    }
    public function getFormCompletionDetails($case_id){
        $this->db->select('uci.id case_id,uc.id car_id,uco.upload_car_photos,uco.customer_id,uco.upload_car_docs,up.id purchasepriceid ');
        $this->db->from('crm_usedcar_purchase_caseinfo as uci');
        $this->db->join('crm_used_car_other_fields as uco','uco.case_id=uci.id','left');
        $this->db->join('crm_used_car as uc','uco.cnt_id=uc.id','left');
        $this->db->join('usedcar_payment_details as up', 'up.case_id = uci.id', 'left');
        $this->db->where('uci.status', '1');
        $this->db->where('uci.id', $case_id);
        $this->db->group_by('uci.id');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        return $query->result_array();
    }
    public function getMinSellingPrice($case_id,$car_id)
    {
       // echo 'gg'.$case_id.'--';
        //$getRefurbCost   = $this->db->select('sum(refurb_cost) refurb_cost ')->from('usedcar_refurb_details')->where('car_id', $car_id)->get()->result_array();
         $getRefurbCost   = $this->db->select('sum(actual_amt) refurb_cost ')->from('crm_refurb_details')->where('car_id', $car_id)->get()->result_array();
        $getPurchaseDetails = $this->db->select('purchaseprice,purchasedate')->from('usedcar_payment_details')->where('case_id', $case_id)->get()->result_array();
        $getSalesDetails = $this->db->select('id')->from('crm_used_car_sale_case_info')->where('car_id', $car_id)->get()->result_array();
       
        $booking_date  = date('Y-m-d');
        if (!empty($getSalesDetails))
        {

            $getBookingDetails = $this->db->select('booking_date')
                    ->from('crm_uc_sales_booking')->where('uc_sales_case_id',$getSalesDetails[0]['id'])->get()->result_array();
            $booking_date  = !empty($getBookingDetails[0]['booking_date'])?date('Y-m-d',strtotime($getBookingDetails[0]['booking_date'])):date('Y-m-d');
        }

        $refurb_cost   = !empty($getRefurbCost[0]['refurb_cost']) ? $getRefurbCost[0]['refurb_cost'] : 0;
        $purchase_cost = !empty($getPurchaseDetails[0]['purchaseprice']) ? $getPurchaseDetails[0]['purchaseprice'] : 0;
        
        $purchase_date = !empty($getPurchaseDetails[0]['purchasedate']) ? $getPurchaseDetails[0]['purchasedate'] : '';
        //[
        // TODO  BOOKING DATE WILL BE BOOKING DATE OF THE CAR IF CAR IS BOOKED
        //]
        $date1          = date_create($purchase_date.' 00:00:00');
        $date2          = date_create($booking_date.' 00:00:00');
        $diff           = date_diff($date1, $date2);
        $holding_period = $diff->format("%a");
 //echo 'gg'.'  - ' .$purchase_date.'  - '.$booking_date.'   -'.$holding_period.'--';
        $total_cost             = $refurb_cost + $purchase_cost;
        $inventory_holding_cost = ($total_cost * 10 * $holding_period) / (100 * 365);
        $profit                 = 0;
        
        if ($total_cost <= 500000)
        {
            $pp=10;
            $profit = (10 * $total_cost) / 100;
        }
        else if ($total_cost <= 750000)
        {
            $pp=7.5;
            $profit = (7.5 * $total_cost) / 100;
        }
        else
        {
            $pp=7;
            $profit = (7 * $total_cost) / 100;
        }
        return $dats = [
            'msp'              =>$total_cost + $inventory_holding_cost + $profit,
            'inv_holding_cost' => $inventory_holding_cost,
            'pp'               => $pp,
            'profit'           => $profit,
            'purchase_cost'    => $purchase_cost,
            'refurb_cost'      => $refurb_cost];
           // echo "<pre>";
           //// print_r($dats); exit;
    }
    public function getDealerStocksByMMVAndRegNo($search_value, $dealer_id)
    {
        $mmv=explode(' ', $search_value);
        //p($mmv);
        $or='';
        if(count($mmv)==2){
           $or=" or ( make like '%".$mmv['0']."%' and model like '%".$mmv['1']."%' )"; 
        }
        else if(count($mmv)==3){
           $or=" or ( make like '%".$mmv['0']."%' and model like '%".$mmv['1']."%' and  db_version like '%".$mmv['2']."%')"; 
        }
        
        $data=$this->db->query("SELECT uc.id,uc.reg_no ,mv.db_version v_n,mm.model md_n,mm.make mk_n FROM crm_used_car uc 
                            inner join model_version mv on mv.db_version_id=uc.version_id
                            inner join make_model mm on mm.id=mv.model_id
                            where uc.dealer_id=$dealer_id and (uc.reg_no like '%$search_value%' or db_version like '%$search_value%' or make like '%$search_value%'
                            or model like '%$search_value%') $or ;")->result_array();
        return $data;
    }


    public function getCrmCentralStock($data,$flag=false)
    {
        $reg_no = !empty($data['reg_no'])?$data['reg_no']:'';
        $engine_no = !empty($data['engine_no'])?$data['engine_no']:'';
        $chassis_no = !empty($data['chassis_no'])?$data['chassis_no']:'';
        $loan_case_id = !empty($data['loan_case_id'])?$data['loan_case_id']:'';
        $insurance_case_id = !empty($data['insurance_case_id'])?$data['insurance_case_id']:'';
        $loan_customer_id = !empty($data['loan_customer_id'])?$data['loan_customer_id']:'';
        $insurance_customer_id = !empty($data['insurance_customer_id'])?$data['insurance_customer_id']:'';
        $make_id = !empty($data['make_id'])?$data['make_id']:'';
        $model_id = !empty($data['model_id'])?$data['model_id']:'';
        $version_id = !empty($data['version_id'])?$data['version_id']:'';
        $insurance_expire = !empty($data['insurance_expire'])?date('Y-m-d',$data['insurance_expire']):'';

        $this->db->select('*');
        $this->db->from('crm_central_stock');
        if(!empty($reg_no))
        {
            $this->db->where('reg_no',$reg_no);
        }
        if(!empty($engine_no))
        {
            $this->db->where('engine_no', $engine_no);
        }
        if(!empty($chassis_no))
        {
            $this->db->where('chassis_no', $chassis_no);
        }
        if(!empty($loan_case_id))
        {
            $this->db->where('loan_case_id', $loan_case_id);
        }
        if(!empty($insurance_case_id))
        {
            $this->db->where('insurance_case_id', $insurance_case_id);
        }
        if(!empty($loan_customer_id))
        {
            $this->db->where('loan_customer_id', $loan_customer_id);
        }
        if(!empty($insurance_customer_id))
        {
            $this->db->where('insurance_customer_id', $insurance_customer_id);
        }
        if(!empty($make_id))
        {
            $this->db->where('make_id', $make_id);
        }
        if(!empty($model_id))
        {
            $this->db->where('model_id', $model_id);
        }
        if(!empty($version_id))
        {
            $this->db->where('version_id', $version_id);
        }
        if(!empty($insurance_expire))
        {
            $this->db->where('insurance_expire',$insurance_expire);
        }
        if($flag){
            $this->db->where('cnt_id',0);
        }
        $this->db->where('status', '1');
        $query = $this->db->get();
      //echo $this->db->last_query(); exit;
        $result = $query->result_array();
        return  $result; 
    }

    public function crmCentralStock($data)
    {

        $searchCentral = [];
        if(strtolower($data['module'])=='seller')
        {
            $searchCentral['reg_no'] = !empty($data['reg_no'])?$data['reg_no']:'';   
        }
        else
        {
            $searchCentral['chassis_no'] = !empty($data['chassis_no'])?$data['chassis_no']:'';
            $searchCentral['engine_no'] = !empty($data['engine_no'])?$data['engine_no']:'';
        }
        $exitsCentral = $this->getCrmCentralStock($searchCentral);
        if(empty($exitsCentral))
        {
            $data['stock_added_on'] = date('Y-m-d H:i:s');
            $data['first_car_type'] = !empty($data['loan_for'])?$data['loan_for']:'';
            $data['stock_added_by'] = !empty($this->session->userdata['userinfo']['id'])?$this->session->userdata['userinfo']['id']:"1";

            $data['stock_added_module'] = !empty($data['module'])?$data['module']:'';
            unset($data['module']);
            unset($data['loan_for']);
            $this->db->trans_start();
            $this->db->insert('crm_central_stock', $data);
            $insert_id = $this->db->insert_id();
           // echo $this->db->last_query(); exit;
            $this->db->trans_complete();
            $result = $insert_id;
        }
        else
        {
            $data['stock_updated_on'] = date('Y-m-d H:i:s');
            $data['stock_last_updated_by'] = $this->session->userdata['userinfo']['id'];
            $data['stock_last_updated_module'] = !empty($data['module'])?$data['module']:'';
            $data['insurance_expire'] = !empty($data['insurance_expire'])?$data['insurance_expire']:'';
            $data['processed'] = '0';
            unset($data['module']);
            unset($data['loan_for']);
            $this->db->where('id', $exitsCentral[0]['id']);
            $this->db->update('crm_central_stock', $data);
            $result = $exitsCentral[0]['id'];


        }

        return $result;

    }
    
    function updatestockCarId($carid,$data){
        $this->db->where('id', $carid);
        $this->db->update('crm_used_car', $data);
        
        //$last_id = $this->Crm_used_car_sale_transaction->SaveTransactionData($tranxData_new,$tranx_id);
        return true;
    }
    public function getPaymentDetails($case_id=0)
    {
       $case_id= !empty($case_id)?$case_id:0;
       return $this->db->query("SELECT purchaseprice purchase_amount,expected_price,sum(amount) paid FROM usedcar_payment_details 
                               where case_id=$case_id group by case_id")->row_array();
       
    }
    public function save_crm_used_car($data,$id='')
    {
        if(empty($id))
        {
            $this->db->insert('crm_used_car', $data);
            $insert_id = $this->db->insert_id();
            $result = $insert_id;
            
        }
        else
        {
            $this->db->where('id', $id);
            $this->db->update('crm_used_car', $data);
            $result = $id;
        }
        return $result;
    }
    
    function getStockListForTally($filter=[]) {
        //print_r($searchArray);die;

        $this->db->select('concat(mm.make," ",mm.model," ",mv.db_version," ",reg_no) filter,used_car.id id,car_status,delivery_date,used_car.km_driven,reg_no,used_car.make_year,mm.model ,mm.make,mv.db_version as version,rw.name refb_workshop_name');
        $this->db->from('crm_used_car as used_car');
        $this->db->join('crm_refurb_details as rd', 'rd.car_id=used_car.id and rd.is_refurb_done="0"', 'left');
        $this->db->join('crm_refurb_workshop as rw', 'rd.wc_id=rw.id', 'left');
        $this->db->join('model_version as mv', 'mv.db_version_id=used_car.version_id', 'left');
        $this->db->join('make_model as mm', 'mm.id = mv.model_id', 'left');
        $this->db->join('crm_used_car_sale_case_info as sale_info', 'sale_info.car_id = used_car.id', 'left');
        $this->db->join('crm_uc_sales_delivery as sale_delivery', 'sale_delivery.uc_sales_case_id = sale_info.id and date(delivery_date)=current_date', 'left');
        $this->db->where('used_car.dealer_id', $filter['dealer_id']);
        $this->db->where('mv.db_version_id !=',0);
        $this->db->group_start();
        $this->db->where_in('used_car.car_status',['1','4','6']);       
        $this->db->or_group_start();
        $this->db->where('used_car.car_status','3');
        $this->db->where('date(delivery_date)',date('Y-m-d'));
        $this->db->group_end();
        $this->db->group_end();
       
        $this->db->group_by('used_car.id');
        $this->db->having(' filter like "%'.$filter['filter_value'].'%" ');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        return $query->result_array();
    }
    function getTallyRecord($filter=[]) {
        //print_r($searchArray);die;
       
        $this->db->select('concat(mm.make," ",mm.model," ",mv.db_version," ",reg_no) filter, used_car.id id,car_status,delivery_date,used_car.km_driven,reg_no,used_car.make_year,mm.model ,'
                . 'mm.make,mv.db_version as version,tally.status tally_status,tally.assigned_to,rw.name refb_workshop_name');
        $this->db->from('crm_used_car as used_car');
         $this->db->join('crm_refurb_details as rd', 'rd.car_id=used_car.id and rd.is_refurb_done="0"', 'left');
        $this->db->join('crm_refurb_workshop as rw', 'rd.wc_id=rw.id', 'left');
        $this->db->join('model_version as mv', 'mv.db_version_id=used_car.version_id', 'left');
        $this->db->join('make_model as mm', 'mm.id = mv.model_id', 'left');
        $this->db->join('crm_used_car_sale_case_info as sale_info', 'sale_info.car_id = used_car.id', 'left');
        $this->db->join('crm_uc_sales_delivery as sale_delivery', 'sale_delivery.uc_sales_case_id = sale_info.id', 'left');
        $this->db->join('crm_stock_tally_log as tally', 'tally.car_id = used_car.id', 'inner');
        $this->db->where('used_car.dealer_id', $filter['dealer_id']);
        $this->db->where('mv.db_version_id !=',0);
//        $this->db->where_in('used_car.car_status',['1','4']);
//        $this->db->or_where('used_car.car_status','3');
        $this->db->where('date(tally.created_date)',date('Y-m-d', strtotime($filter['date'])));
        if(!empty($filter['status'])){
           $this->db->where('tally.status',$filter['status']);
        }
        
        $this->db->where('tally.archived','0');
        $this->db->group_by('used_car.id');
        $this->db->having(' filter like "%'.$filter['filter_value'].'%" ');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        return $query->result_array();
    }
    function getTemporaryStockList($filter=[]) {
        //print_r($searchArray);die;

        $this->db->select('concat(mm.make," ",mm.model," ",mv.db_version," ",reg_no) filter, concat(used_car.id,"_T") id,"temp_stock","" delivery_date,0 km_driven ,used_car.status car_status,used_car.reg_no,used_car.make_year,mm.model ,mm.make,mv.db_version as version');
        $this->db->from('crm_reco_stock as used_car');
        $this->db->join('model_version as mv', 'mv.db_version_id=used_car.version_id', 'left');
        $this->db->join('make_model as mm', 'mm.id = mv.model_id', 'left');
        $this->db->where('used_car.dealer_id', $filter['dealer_id']);
        $this->db->where_in('used_car.status',['1']);       
        $this->db->where('mv.db_version_id !=',0);
        $this->db->group_by('used_car.id');
        $this->db->having(' filter like "%'.$filter['filter_value'].'%" ');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        return $query->result_array();
    }
    function getTallyRecordForTempStocks($filter=[]) {
        //print_r($searchArray);die;
       
        $this->db->select('concat(mm.make," ",mm.model," ",mv.db_version," ",reg_no) filter, concat(used_car.id,"_T") id,"temp_stock",used_car.status car_status,reg_no,used_car.make_year,mm.model,mm.make,mv.db_version as version,tally.status tally_status,tally.assigned_to');
        $this->db->from('crm_stock_tally_log as tally');
        $this->db->join('crm_reco_stock as used_car', 'tally.reco_car_id = used_car.id', 'inner');
        $this->db->join('model_version as mv', 'mv.db_version_id=used_car.version_id', 'left');
        $this->db->join('make_model as mm', 'mm.id = mv.model_id', 'left');
        $this->db->where('used_car.dealer_id', $filter['dealer_id']);
        $this->db->where('date(tally.created_date)',date('Y-m-d', strtotime($filter['date'])));
        $this->db->where('mv.db_version_id !=',0);
        if(!empty($filter['status'])){
           $this->db->where('tally.status',$filter['status']);
        }
        
        $this->db->where('tally.archived','0');
        $this->db->group_by('used_car.id');
        $this->db->having(' filter like "%'.$filter['filter_value'].'%" ');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        return $query->result_array();
    }
    public function getNumOfKeysByDate($date,$dealer_id){
        
        $this->db->select('*');
        $this->db->from('crm_stock_keys_log');
        $this->db->where('dealer_Id',$dealer_id);
        $this->db->where('date(created_date)', date('Y-m-d', strtotime($date)));
        $query  = $this->db->get();
        return $query->row_array();
    }
    public function getStockByDealerId($dealer_id)
    {
        $this->db->select('*');
        $this->db->from('crm_used_car');
        $this->db->where('dealer_Id',$dealer_id);
        $query  = $this->db->get();
        return $query->result_array();

    }
    public function  getDealersMiscellTableData($table_name,$car_id){
        $this->dealers = $this->load->database('dealers', TRUE);
        $this->dealers->from($table_name);
        if(!empty($car_id))
        $this->dealers->where('usedcar_id',$car_id);
        $query  = $this->dealers->get();
        return $query->result_array();
    }
    public function  getMiscellTableData($id){
        $this->db->select('*');
        $this->db->from('crm_used_car_miscellaneous');
        $this->db->where('id',$id);
        $query  = $this->db->get();
        return $query->result_array();
    }
    public function updateMiscellaneousTableCrm($data,$id)
    {
         if (empty($id)) {
            $this->db->trans_start();
            $this->db->insert('crm_used_car_miscellaneous', $data);

            $insert_id = $this->db->insert_id();

            $this->db->trans_complete();

            return $insert_id;
        } else {
            $this->db->where('id', $id);
            $this->db->update('crm_used_car_miscellaneous', $data);
            return $this->db->affected_rows();
        }
    }

    public function updateotherTableCrm($data,$id)
    {
            $this->db->where('id', $id);
            $this->db->update('crm_used_car_other_fields', $data);
            return $this->db->affected_rows();
    }

    public function getStockOtherDetailsByDealerId($dealer_id)
    {
        $this->db->select('uco.permitvalid,uco.road_txvalid,uco.fitvalid,uco.id,c.insurance_type,c.insurance_exp_year,c.insurance_exp_month,uco.insurance_date,c.id as carid');
        $this->db->from('crm_used_car AS c');
        $this->db->join('crm_used_car_other_fields AS uco','c.id=uco.cnt_id','inner');
        $this->db->where('dealer_Id',$dealer_id);
        $query  = $this->db->get();
        return $query->result_array();

    }
}
