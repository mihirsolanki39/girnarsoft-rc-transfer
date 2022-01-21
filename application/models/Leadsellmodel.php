<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Leadsellmodel extends CI_Model
{
        private $dateTime='';
        private $zero = 0;
        private $date ='';
	public function __construct()
        {
            parent::__construct();
            $this->dateTime=date("Y-m-d H:i:s");
            $this->date=date('Y-m-d');
            $this->load->helpers('range_helper');
            //$this->load->model('Crm_buy_lead_customer_preferences');
            //$this->load->model('Crm_buy_lead_car_detail');
        }
        
        public function getleadsQuery($requestParams)
        {
            //,CASE WHEN scd.parent_model_id>0 THEN mm.model ELSE scd.model END AS model
                $requestParams['rpp']=10;
                $perPageRecord = $requestParams['rpp'] == 0 ? 50 : $requestParams['rpp'];
                $pageNo = (isset($requestParams['page']) && $requestParams['page'] != '') ? $requestParams['page'] : '1';
                $startLimit = ($pageNo - 1) * $perPageRecord;
            $this->db->select('scd.id as car_details_id ,sc.id,sc.total_cars,sc.name,sc.email,sc.mobile,sc.verified,scd.enquiry_date,sc.status,sc.follow_date,sc.source,scd.make,scd.model as models,scd.variant,scd.myear,scd.mmonth,scd.colour,scd.pricefrom,scd.regno,scd.enquiry_date,scd.images,scd.quote_price,scd.car_id,scd.id as sell_car_details_id,scd.latest as car_latest,scd.km,scd.fuel_type,sc.mobile,sc.dealer_id');
            $this->db->from('sell_customer as sc');
            $this->db->join('sell_customer_car_details as scd', 'sc.id=scd.sell_customer_id','inner');
            $this->db->join('make_model as mm', 'mm.id=scd.parent_model_id','left');
            $this->db->where('scd.latest', '1');
            $this->getleadsQueryFilter($requestParams);
            $this->db->where('sc.dealer_id', DEALER_ID);
            $this->db->group_by(array('sc.id'));
            //$this->db->order_by('sc.id');
            $this->orderbyGetLeadsFilter($requestParams);
              // if (empty($requestParams['export']) && $requestParams['export'] != 'export') {
                            if (isset($requestParams['page']))
                               {
                                  $this->db->offset((int) ($startLimit));
                               }
                               if (!empty($perPageRecord))
                               {
                                   $this->db->limit((int) $perPageRecord);
                               }
                       // }
                   
               $query = $this->db->get();
            return $query->result_array();
             //echo  $str = $this->db->last_query();
        }
        
        public function getSellerLeadCount($requestParams)
        {
            $this->db->select("sum(CASE WHEN (sc.status !='Closed' and sc.status!='Converted' and DATE(sc.follow_date)='0000-00-00') THEN 1 ELSE 0 END) AS no_action_taken");
            $this->db->select("sum(CASE WHEN (sc.status !='Closed' and sc.status!='Converted' and DATE(sc.follow_date)='".$this->date."') THEN 1 ELSE 0 END) AS today_follow_up");
            $this->db->select("sum(CASE WHEN (sc.status !='Closed' and sc.status!='Converted' and DATE(sc.follow_date)!='0000-00-00' and DATE(sc.follow_date)<'".$this->date."') THEN 1 ELSE 0 END) AS past_follow_up");
            $this->db->select("sum(CASE WHEN (sc.status ='Closed') THEN 1 ELSE 0 END) AS closed");
            $this->db->select("sum(CASE WHEN (sc.status ='Converted') THEN 1 ELSE 0 END) AS converted");
            $this->db->select("count(sc.id) AS alls");
            $this->db->from('sell_customer as sc');
            $this->db->join('sell_customer_car_details as scd', 'sc.id=scd.sell_customer_id','inner');
            $this->db->join('make_model as mm', 'mm.id=scd.parent_model_id','left');
            $this->db->where('scd.latest', '1');
            $this->getleadsQueryFilter($requestParams,'1');
            $this->db->where('sc.dealer_id', DEALER_ID);
            $query = $this->db->get();
            return $query->result_array();
            //echo  $str = $this->db->last_query();
        }

        public function getleadsQueryFilter($requestParams,$tabFilter='') {
            $select=$this->db;//where_not_in
            if($tabFilter!='1'){
                if (isset($requestParams['tab_value']) && $requestParams['tab_value'] == 'no_action_taken') {
                    $select->where("DATE(sc.follow_date) = " ,"0000-00-00");
                    $select->where_not_in("sc.status " ,['Closed','Converted']);
                    //$orderby = ' order by scd.enquiry_date desc, sc.id desc';
                } elseif (isset($requestParams['tab_value']) && $requestParams['tab_value'] == 'today_follow_up') {
                    $select->where("DATE(sc.follow_date) =" ,$this->date);
                    //$select->where("DATE(sc.follow_date) <" ,$this->date);
                    $select->where_not_in("sc.status " ,['Closed','Converted']);
                    //$orderby = ' order by sc.follow_date asc ';
                } elseif (isset($requestParams['tab_value']) && $requestParams['tab_value'] == 'past_follow_up') {
                    $select->where("DATE(sc.follow_date) !=" ,'0000-00-00');
                    $select->where("DATE(sc.follow_date) <" ,$this->date);
                    $select->where_not_in("sc.status" ,['Closed','Converted']);
                    //$orderby = ' order by sc.follow_date desc ';
                } elseif (isset($requestParams['tab_value']) && $requestParams['tab_value'] == 'closed') {
                    $select->where("sc.status =" ,"Closed");
                    //$orderby = ' order by sc.update_date desc ';
                } elseif (isset($requestParams['tab_value']) && $requestParams['tab_value'] == 'converted') {
                   // $orderby = ' order by sc.update_date desc ';
                    $select->where("sc.status =" ,"Converted");
                }
            }
            if (isset($requestParams['name_email_mobile']) &&  $requestParams['name_email_mobile'] != '') {
             $select->where("(sc.name like '%" . trim($requestParams['name_email_mobile']) . "%' or sc.mobile like '%" . trim($requestParams['name_email_mobile']) . "%' or sc.email like '%" . trim($requestParams['name_email_mobile']) . "%')");
            }
            if (isset($requestParams['source']) && $requestParams['source'] != '') {
                $select->where("sc.source =" ,$requestParams['source']);
            }
            if (isset($requestParams['make']) && $requestParams['make'] != '') {
                $select->where("scd.make =" ,$requestParams['make']);
            }
            if (isset($requestParams['model']) && $requestParams['model'] != '') {
                $select->where("scd.model =" ,$requestParams['model']);
            }
            if (isset($requestParams['price_min']) && $requestParams['price_min'] != '') {
                $select->where("scd.pricefrom >=" ,$requestParams['price_min']);
            }
            if (isset($requestParams['price_max']) && $requestParams['price_max'] != '') {
                $select->where("scd.pricefrom <=" ,$requestParams['price_max']);
            }
            if (isset($requestParams['enquiry_date_from']) && $requestParams['enquiry_date_from'] != '') {
                $select->where("DATE(scd.enquiry_date) >=" ,date('Y-m-d', strtotime(str_replace('/', '-', $requestParams['enquiry_date_from']))));
            }
            if (isset($requestParams['enquiry_date_to']) && $requestParams['enquiry_date_to'] != '') {
                $select->where("DATE(scd.enquiry_date) <=" ,date('Y-m-d', strtotime(str_replace('/', '-', $requestParams['enquiry_date_to']))));
            }
            if (isset($requestParams['status']) && $requestParams['status'] != '') {
                $select->where("sc.status =" ,$requestParams['status']);
            }
            if (isset($requestParams['regno']) && $requestParams['regno'] != '') {
                $select->where("replace(replace(scd.regno,' ',''),'-','') like '%" . str_replace(array(' ', '-'), '', $requestParams['regno']) . "%' ");
            }
            if (isset($requestParams['follow_date_from']) && $requestParams['follow_date_from'] != '') {
                $select->where("DATE(sc.follow_date) >=" ,date('Y-m-d', strtotime(str_replace('/', '-', $requestParams['follow_date_from']))));
            }
            if (isset($requestParams['follow_date_to']) && $requestParams['follow_date_to'] != '') {
                $select->where("DATE(sc.follow_date) <=" ,date('Y-m-d', strtotime(str_replace('/', '-', $requestParams['follow_date_to']))));
            }
            if (isset($requestParams['km_from']) && $requestParams['km_from'] != '') {
                $select->where("scd.km >=" ,$requestParams['km_from']);
            }
            if (isset($requestParams['km_to']) && $requestParams['km_to'] != '') {
                $select->where("scd.km <=" ,$requestParams['km_to']);
            }
            if (isset($requestParams['year_from']) && $requestParams['year_from'] != '') {
                $select->where("scd.myear >=" ,$requestParams['year_from']);
            }
            if (isset($requestParams['year_to']) && $requestParams['year_to'] != '') {
                $select->where("scd.myear <=" ,$requestParams['year_to']);
            }
            if (isset($requestParams['verified']) && isset($requestParams['non_verified']) && $requestParams['verified'] == 'on' && $requestParams['non_verified'] == 'on') {
                
            } elseif (isset($requestParams['verified']) && $requestParams['verified'] == 'on') {
                $select->where("sc.verified =" ,'1');
            } elseif (isset($requestParams['non_verified']) && $requestParams['non_verified'] == 'on') {
                $select->where("sc.verified =" ,'0');
                
            }
    }
    
     public function orderbyGetLeadsFilter($requestParams) {
        if (isset($requestParams['tab_value']) && $requestParams['tab_value'] == 'no_action_taken') {
                $this->db->order_by('scd.enquiry_date DESC');
                $this->db->order_by('sc.id DESC');
            } elseif (isset($requestParams['tab_value']) &&  $requestParams['tab_value'] == 'today_follow_up') {
                $this->db->order_by('sc.follow_date asc');
            } elseif (isset($requestParams['tab_value']) && $requestParams['tab_value'] == 'past_follow_up') {
                $this->db->order_by('sc.follow_date desc');
            } elseif (isset($requestParams['tab_value']) && $requestParams['tab_value'] == 'closed') {
                $this->db->order_by('sc.update_date desc');
            } elseif (isset($requestParams['tab_value']) && $requestParams['tab_value'] == 'converted') {
                $this->db->order_by('sc.update_date desc');
            }else{
                $this->db->order_by('sc.id desc');
            }

        return $this;
    }
   
    public function getColorCar()
    {
        $sql="select * from colors where status='1'";
        $getColors = $this->db->query($sql);
        return $getColors->result_array();
                                                    
    }
    
    public function getSellCustomer($mobile,$dealerId)
    {
        $query = $this->db->get_where('sell_customer', array('mobile' => $mobile,'dealer_id'=>$dealerId));
	return $query->row_array();   
    }
    
    public function setSellCustomer($datapost,$flag='')
    {
        $mobile   = $datapost['add_seller_mobile'];
        $dealerId = $datapost['dealer_id'];
        $getSellCustomer=$this->getSellCustomer($mobile,$dealerId);
        //print_r($getSellCustomer);die;

        $name = addslashes(trim($datapost['add_seller_name']));
        $email = addslashes(trim($datapost['add_seller_email']));
        $mobile = addslashes(trim($datapost['add_seller_mobile']));
        $source = (isset($datapost['add_seller_source']))?addslashes(trim($datapost['add_seller_source'])):'';
        $status = addslashes(trim($datapost['add_seller_status']));
        $datapost['follow_date']=date("Y-m-d H:i:s",strtotime($datapost['follow_date']));
        $sellCustomer=[];
        $sellDCData=[];
        
        //$sellCustomer['id']    = (!empty($datapost['id']) ? $datapost['id'] : $getSellCustomer['id']);
        $sellCustomer['name']='';
        $sellCustomer['email']='';
        $sellCustomer['mobile']='';
        if(!empty($name)){
            $sellCustomer['name']    = $name;
        }
        elseif(!empty($getSellCustomer['name'])){
             $sellCustomer['name']    = $getSellCustomer['name'];
        }
        if(!empty($email)){
            $sellCustomer['email']    = $email;
        }
        elseif(!empty($getSellCustomer['email'])){
             $sellCustomer['email']    = $getSellCustomer['email'];
        }
        if(!empty($mobile)){
            $sellCustomer['mobile']    = $mobile;
        }
        elseif(!empty($getSellCustomer['mobile'])){
             $sellCustomer['mobile']    = $getSellCustomer['mobile'];
        }
        //$sellCustomer['name']    = (!empty($name) ? $name : !empty($getSellCustomer['name'])?$getSellCustomer['name']:'');
        //$sellCustomer['email']   = (!empty($email) ? $email : !empty($getSellCustomer['email'])?$getSellCustomer['email']:'');
        //$sellCustomer['mobile']  = (!empty($mobile) ? $mobile : !empty($getSellCustomer['mobile'])?$getSellCustomer['mobile']:'');
        $sellCustomer['status'] = (!empty($status) ? $status : $getSellCustomer['status']);
        $sellCustomer['crm_customer_id'] =(!empty($datapost['crm_customer_id']))?$datapost['crm_customer_id']:'';
        $sellCustomer['follow_date'] = (!empty($datapost['follow_date']) ? $datapost['follow_date'] : $getSellCustomer['follow_date']);
        $sellCustomer['update_date'] = $this->dateTime;
        $sellCustomer['dcleadid']    = (!empty($datapost['dcleadid']) ? $datapost['dcleadid'] : 0);
        
        if($getSellCustomer){
            $sellCustomer['verified'] = (!empty($datapost['verified']) ? $datapost['verified'] : $getSellCustomer['verified']);
            $sellCustomer['change_done']=1;
            $this->db->where('id', $getSellCustomer['id']);
            $this->db->update('sell_customer',$sellCustomer);
            $leadId=$getSellCustomer['id'];
            
            $this->db->set('total_cars', 'total_cars+1', FALSE);
            $this->db->where('id', $getSellCustomer['id']);
            $this->db->update('sell_customer');
            
        }else{
            $sellCustomer['total_cars']=1;
            $sellCustomer['verified'] =0;
            $sellCustomer['source'] = (!empty($source) ? $source : $getSellCustomer['source']);
            $sellCustomer['dealer_id'] = (!empty($dealerId) ? $dealerId : $getSellCustomer['dealer_id']);
            $sellCustomer['enq_date'] = $this->dateTime;
            $this->db->insert('sell_customer',$sellCustomer);
            $leadId=$this->db->insert_id();
            
            
        }
        return $leadId;
        
    }
    
    public function setSellCustomerComments($datapost,$sellCustomerId)
    {
        $comment = addslashes(trim($datapost['add_seller_comment']));
        $lastCommentId=0;
        if($comment){
        //update for privious comment is zero
        $updateCustomerComments=[];
        $updateCustomerComments['latest']='0';
        $this->db->where('sell_customer_id', $sellCustomerId);
        $this->db->update('sell_customer_comments',$updateCustomerComments);
       
        //add seller lead comment
        $addCustomerComments=[];
        $addCustomerComments['sell_customer_id'] = $sellCustomerId;
        $addCustomerComments['comment'] = $comment;
        $addCustomerComments['latest'] = '1';
        $addCustomerComments['source'] = (isset($datapost['add_seller_source']))?$datapost['add_seller_source']:'dealerCrm';
        $addCustomerComments['added'] = $this->dateTime;
        
        $this->db->insert('sell_customer_comments',$addCustomerComments);
        $lastCommentId=$this->db->insert_id();
        }
        return $lastCommentId;
    }

    public function setSellCustomerCarDetails($datapost, $sellCustomerId) {
        //$i = 0;
        //while ($datapost['add_seller_make'][$i] != '') {
        for($i=0;$i < count($datapost['add_seller_make']);$i++){
            $make = addslashes(trim($datapost['add_seller_make'][$i]));
            $model = addslashes(trim($datapost['add_seller_model'][$i]));
            $variant = addslashes(trim($datapost['add_seller_variant'][$i]));
            $myear = addslashes(trim($datapost['add_seller_myear'][$i]));
            $mmonth = addslashes(trim($datapost['add_seller_mmonth'][$i]));

            if ($make != '' && $model != '' && $variant != '' && $myear != '' && $mmonth != '') {
                $colour = addslashes(trim($datapost['add_seller_colour'][$i]));
                $pricefrom = addslashes(trim($datapost['add_seller_price'][$i]));
                $regno = addslashes(trim($datapost['add_seller_regno'][$i]));
                $km = addslashes(trim($datapost['add_seller_km'][$i]));
                $fuel_type = addslashes(trim($datapost['add_seller_fuel_type'][$i]));
                $other_color = addslashes(trim($datapost['other_color'][$i]));
                if ($colour == 'Other') {
                    $colour = $other_color;
                }

                $mmvids = $this->getMakeModelVersionIds($make,$model,$variant);

                $make_id = $mmvids['make_id'];
        		$model_id = $mmvids['model_id'];
        		$version_id = $mmvids['version_id'];
                $parent_model_id='';
                $this->updateLatest($sellCustomerId);//update privious car latest zero
                $carDetails=[];
                $carDetails['sell_customer_id']=$sellCustomerId;
                $carDetails['make']=(!empty($make))?$make:'';
                $carDetails['model']=(!empty($model))?$model:'';
                $carDetails['variant']=(!empty($variant))?$variant:'';
                $carDetails['myear']=(!empty($myear))?$myear:'0';
                $carDetails['mmonth']=(!empty($mmonth))?$mmonth:'0';
                $carDetails['colour']=(!empty($colour))?$colour:'';
                $carDetails['pricefrom']=(!empty($pricefrom))?$pricefrom:'0';
                $carDetails['regno']=(!empty($regno))?$regno:'';
                $carDetails['enquiry_date']=$this->dateTime;
                $carDetails['source']=$datapost['add_seller_source'];
                $carDetails['km']=(!empty($km))?$km:'';
                $carDetails['fuel_type']=(!empty($fuel_type))?$fuel_type:'';
                //$carDetails['parent_model_id']='';
                $carDetails['make_id']=(!empty($make_id))?$make_id:'0';
                $carDetails['model_id']=(!empty($model_id))?$model_id:'0';;
                $carDetails['version_id']=(!empty($version_id))?$version_id:'0';;
                $carDetails['added_from']=$this->dateTime;
                //$carDetails['api_id']='';
                $carDetails['latest']='1';
                $this->db->insert('sell_customer_car_details',$carDetails);
                $lastSellercarId=$this->db->insert_id();
                //$i++;
                
                if($lastSellercarId){
                $this->db->set('total_cars', 'total_cars+1');  
                $this->db->where('id', $sellCustomerId); 
                $this->db->update('sell_customer'); 
                }
            }
        }
        return $sellCustomerId;
    }
    
    public function updateLatest($sellCustomerId)
    {
        $carDetailsLatest=[];
        $carDetailsLatest['latest']='0';
        $this->db->where('sell_customer_id', $sellCustomerId);
        $this->db->update('sell_customer_car_details',$carDetailsLatest);
        return $sellCustomerId;
    }
    
    
        
  

    public function getMakeModelVersionIds($make, $model, $variant) {
        $resultMMVids = [];
        if ($make != '' && $model != '' && $variant != '') {
            $sqlMMVids = "SELECT
                        cm.id AS make_id,
                        mm.id AS model_id,
                        mv.db_version_id AS version_id
                      FROM car_make AS cm
                      INNER JOIN make_model AS mm
                        ON cm.id = mm.make_id
                      INNER JOIN model_version AS mv
                        ON mm.id = mv.model_id
                      WHERE cm.make = '$make'
                      AND mm.model = '$model'
                      AND mv.db_version = '$variant'";
            $resultMMVids = current($this->db->query($sqlMMVids, [])->result_array());
        }
        //echo "<pre>";print_r($resultMMVids);exit;
        return $resultMMVids;
    }
    public function getSellCustomerComments($sell_customer_id)
    {
        $this->db->select('*');
        $this->db->from('sell_customer_comments as scc');
        $this->db->where('scc.sell_customer_id', $sell_customer_id);
        $this->db->order_by('scc.added','desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function saveRetailPrice($data)
    {
        $sell_customer_id=$this->getSellCustomerByCarId($data['sellCarId']);
        $carDetailsQuotePrice=[];
        $carDetailsQuotePrice['user_id']         =  $data['user_id'];
        $carDetailsQuotePrice['user_type']       =  $data['user_type'];
        $carDetailsQuotePrice['quote_price']     =  $data['quotePrice'];
        $this->db->where('id', $data['sellCarId']);
        $updateQuotePriceStatus=$this->db->update('sell_customer_car_details',$carDetailsQuotePrice);
        //echo $updateQuotePriceStatus;die;
        if($updateQuotePriceStatus){
        $updateSellCustomer=[];
        $updateSellCustomer['sync_status']='0';
        $updateSellCustomer['update_date']=$this->dateTime;
        $this->db->where('id', $sell_customer_id['sell_customer_id']);
        $this->db->update('sell_customer',$updateSellCustomer);
        echo'1';exit;
        }
        //return $sellCustomerId;
    }
    
    public function getSellCustomerByCarId($sellCarId)
    {
       $query = $this->db->get_where('sell_customer_car_details', array('id' => $sellCarId));
	return $query->row_array();   
    }
    
    public function getScMoreCars($id)
    {
        $sql = "select scd.*,CASE WHEN scd.parent_model_id>0 THEN mm.model ELSE scd.model END AS models from sell_customer_car_details as scd LEFT JOIN make_model AS mm ON mm.id=scd.parent_model_id where scd.sell_customer_id='".$id."' and scd.latest=0 order by scd.id desc ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function totalSellCar($id)
    {
        $sqlcarcount="SELECT count(id) as total_cars FROM sell_customer_car_details WHERE sell_customer_id='".$id."' ORDER BY id DESC ";
        $query = $this->db->query($sqlcarcount);
        return $query->result_array();
    }

    public function getsellerLeadQuotesToDC(){
            $this->db->select('sc.status,sc.follow_date,sc.dealer_id,sc.mobile,sc.sync_status,scd.make_id,scd.model_id,
                   scd.version_id,scd.quote_price,scd.user_type,scd.user_id');
            $this->db->from('sell_customer as sc');
            $this->db->join("'sell_customer_car_details as scd', 'sc.id=scd.sell_customer_id and sc.sync_status='0' and scd.quote_price is not null and scd.make_id !='0' and  scd.model_id!='0' and scd.version_id!='0'",'inner');
            $query = $this->db->get();
            return $query->result_array();
    }
    
    public function getsellerLeadunSyncToDC($dealerId,$perPageRecord){
            $this->db->select('sc.id as leadId,sc.*,scd.*');
            $this->db->from('sell_customer as sc');
            $this->db->join('sell_customer_car_details as scd', "sc.id=scd.sell_customer_id and sc.sync_status='0' and scd.quote_price is not null and scd.make_id !='0' and  scd.model_id!='0' and scd.version_id!='0'",'inner');
            $this->db->where('sc.sync_status', 0);
            $this->db->where('sc.dealer_id', $dealerId);
            $this->db->limit((int) $perPageRecord);
            $query = $this->db->get();
            //echo $this->db->last_query();
            return $query->result_array();
    }
    public function getsellerLeadCommentsToDC($dealerId,$perPageRecord){
            $this->db->select('sc.status,sc.follow_date,scc.id comment_id,sc.id customer_id,sc.mobile,sc.dealer_id,scc.comment,scc.added,
                  scc.sync_status sync_comment ,scc.source comment_source,scc.comented_user_id');
            $this->db->from('sell_customer as sc');
            $this->db->join('sell_customer_comments scc', 'sc.id=scc.sell_customer_id','inner');
            $this->db->where('scc.sync_status', 0);
            $this->db->where('sc.dealer_id', $dealerId);
            $this->db->order_by('sc.id');
            $this->db->limit((int) $perPageRecord);
            $query = $this->db->get();
            //echo $this->db->last_query();
            return $query->result_array();
    }
    public function syncStatus($data,$leadIds){
               $this->db->where_in('id', $leadIds);
               $this->db->update('sell_customer',$data);
               // echo $this->db->last_query();
               return true;
           }
    public function syncComments($data,$comment_ids){
              $this->db->where_in('id', $comment_ids);
               $this->db->update('sell_customer_comments',$data);
                //echo $this->db->last_query();exit;
               return true;
           }
    public function getclassifiedDealers(){
            $this->db->select('d.*');
            $this->db->from('crm_admin_dealers as d');
            $this->db->where('d.is_classified', '1');
            $this->db->where('d.status', '1');
            $query = $this->db->get();
            return $query->result_array();
    }
    public function addCrmDclogDetails($requestData,$id=''){
        if(empty($id)){
            $this->db->insert('crm_dc_sell_lead_log',$requestData);
            $lastId=$this->db->insert_id();
        }else{
            $this->db->where('id', $id);
            $this->db->update('crm_dc_sell_lead_log',$requestData);
            $lastId=$id;
        }
        return $lastId;
    }
    
    public function setSellCustomerCommentsfromDC($datapost,$sellCustomerId)
    {
        $comment = addslashes(trim($datapost['add_seller_comment']));
        $SellCustomerDC=$this->getSellCustomerByDcLeadId($sellCustomerId);
        if($SellCustomerDC){
        $lastCommentId=0;
        if($comment){
        //update for privious comment is zero
        $updateCustomerComments=[];
        $updateCustomerComments['latest']='0';
        $this->db->where('sell_customer_id', $SellCustomerDC['id']);
        $this->db->update('sell_customer_comments',$updateCustomerComments);
       
        //add seller lead comment
        $addCustomerComments=[];
        $addCustomerComments['sell_customer_id'] = $SellCustomerDC['id'];
        $addCustomerComments['comment'] = $comment;
        $addCustomerComments['latest'] = '1';
        $addCustomerComments['source'] = (isset($datapost['add_seller_source']))?$datapost['add_seller_source']:'DC';
        $addCustomerComments['added'] = $this->dateTime;
        
        $this->db->insert('sell_customer_comments',$addCustomerComments);
        $lastCommentId=$this->db->insert_id();
        }
        }
        return $lastCommentId;
    }
    
    public function setSellCustomerStatusfromDC($datapost,$sellCustomerId)
    {
        $SellCustomeridDC=$this->getSellCustomerByDcLeadId($sellCustomerId);
        if($SellCustomeridDC){
        $id=$SellCustomeridDC['id'];
        $name=$datapost['name'];
        $email=$datapost['email'];
        $status=$datapost['status'];
        $follow_date=$datapost['follow_date'];
        $SellCustomerDC=$this->getCustomerDetailsfromHis($id,$name,$email,$status,$follow_date);
	if($SellCustomerDC['id']!='')
	{
		$prev_name=$SellCustomerDC['name'];
		$prev_email=$SellCustomerDC['email'];
		$prev_status=$SellCustomerDC['status'];
		$prev_follow_date=$SellCustomerDC['follow_date'];
                $source='DC';
                $updateCustomerhistory=[];
                $updateCustomerhistory['latest']='0';
                $this->db->where('sell_customer_id', $id);
                $this->db->update('sell_customer_history',$updateCustomerhistory);
		//$db->executeQuery("update sell_customer_history set latest=0 where sell_customer_id=$id");
                $addCustomerhis=[];
                $addCustomerhis['sell_customer_id']=$id;
                $addCustomerhis['name']=$prev_name;
                $addCustomerhis['email']=$prev_email;
                $addCustomerhis['status']=$prev_status;
                $addCustomerhis['follow_date']=$prev_follow_date;
                $addCustomerhis['added_date']=date('Y-m-d H:i:s');
                $addCustomerhis['latest']='1';
                $this->db->insert('sell_customer_history',$addCustomerhis);
                $lastHisId=$this->db->insert_id();
		/*$sql = "insert into sell_customer_history(sell_customer_id,name,email,status,follow_date,added_date,latest) values"
				. " ('$id','$prev_name','$prev_email','$prev_status','$prev_follow_date',now(),1)";
		$db->executeQuery($sql);*/
                $updateSellCustomer=[];
                $updateSellCustomer['name']=$name;
                $updateSellCustomer['email']=$email;
                $updateSellCustomer['status']=$status;
                $updateSellCustomer['follow_date']=$follow_date;
                $updateSellCustomer['added_date']=date('Y-m-d H:i:s');
                $updateSellCustomer['sync_status']='0';
                $this->db->where('id', $id);
                $this->db->update('sell_customer',$updateCustomerhistory);
		$db->executeQuery("update sell_customer set name='$name',email='$email',status='$status',follow_date='$follow_date' ,sync_status='0' where id=$id");
        
        }
        }
        return $lastCommentId;
    }
    public function getSellCustomerByDcLeadId($dcleadId)
    {
        $query = $this->db->get_where('sell_customer', array('dcleadid' => $dcleadId));
	return $query->row_array();   
    }
    
    public function getCustomerDetailsfromHis($id,$name,$email,$status,$follow_date)
    {
        $this->db->select('s.*');
        $this->db->from('sell_customer as s');
        $this->db->where('s.id', $id);
        $this->db->where("( s.name!='$name' or s.email!='$email' or s.status!='$status' or s.follow_date!='$follow_date')");
        $query = $this->db->get();
        return $query->row_array();
        //$query = $this->db->get_where('sell_customer', array('dcleadid' => $dcleadId));
	//return $query->row_array();   
    }
    
    public function isClassifieddealer($dealerid)
    {
        $this->db->select('*');
        $this->db->from('crm_admin_dealers as cd');
        $this->db->where('cd.dealer_id', $dealerid);
        $this->db->where('cd.is_classified', '1');
        $this->db->where('cd.status', '1');
        $query = $this->db->get();
        return $query->result_array();
    }
   


    public function saveSellCustomerCarDetails($cardetails,$id='')
    {
        if(!empty($id))
        {
            $this->db->where('id', $id);
            $this->db->update('sell_customer_car_details',$cardetails);
            $res = $id;
           //echo $this->db->last_query(); exit;

        }
       else if(empty($id))
       {
            $this->db->trans_start();
            $this->db->insert('sell_customer_car_details', $cardetails);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $res = $insert_id;
       }
        return $res;
    }


    public function add_seller_lead_to_dc($datapost)
    {

        $dealer_id = DEALER_ID;
        $datapost['dealer_id']=$dealer_id;
        $follow_date='';
        if (trim($datapost['add_seller_follow_date'] != '')) {
            $follow_date = date('Y-m-d H:i:s', strtotime($datapost['add_seller_follow_date']));
        }
        else
        {
        $follow_date='0000-00-00 00:00:00';
        } 
        $datapost['follow_date']=$follow_date;
        $isClassified=$this->Leadsellmodel->isClassifieddealer($dealer_id);
       //if(!empty($isClassified[0]['id']) && $isClassified[0]['id'] > 0){
        $results=json_encode($datapost);
        $sellDCData['dealer_id']=$dealer_id;
        $sellDCData['info']=$results;
        $url=API_URL."api/sell_lead_verify_crm.php?method=addSellerLead&apikey=U3KqyrewdMuCotTS&info";
        $logdata['dealer_id']=$dealer_id;
        $logdata['requestdata']=$results;
        $logdata['add_date']=date("Y-m-d H:i:s");
        
        $lastLogid=$this->Leadsellmodel->addCrmDclogDetails($logdata);
        $dc_sell_customer_id=$this->sendLeadsToDCUsedcar($sellDCData, $url);
        if(!empty($dc_sell_customer_id) && $dc_sell_customer_id!=''){
        $dclogdata['responsedata']=$dc_sell_customer_id;
        $dclogdata['update_date']=date("Y-m-d H:i:s");
        $this->Leadsellmodel->addCrmDclogDetails($dclogdata,$lastLogid);    
        $datapost['dcleadid']=$dc_sell_customer_id;
        }
        $sellCustomerId=$this->Leadsellmodel->setSellCustomer($datapost);
        
        $this->Leadsellmodel->setSellCustomerComments($datapost,$sellCustomerId);
       
        $this->Leadsellmodel->setSellCustomerCarDetails($datapost, $sellCustomerId);
        //}
         
        if($sellCustomerId){
           return $sellCustomerId;
        }
    }
    public function sendLeadsToDCUsedcar($leaddata, $url) {
    if (isset($leaddata) && !empty($leaddata) > 0) {
        $vars='';
        foreach ($leaddata as $k => $v) {
            $vars .= '&' . $k . '=' . $v;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_POST, count($vars));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        $response = curl_exec($ch);
        return $response;
    }
    } 
}

