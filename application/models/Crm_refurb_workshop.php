<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Crm_refurb_workshop extends CI_Model {

    public function __construct()
    {
        parent::__construct();       
    }

    public function getworkshoplist($id="")
    {
        $this->db->select('*');
        $this->db->from('crm_refurb_workshop');
        if(trim($id) != '' && intval($id) > 0)
            $this->db->where('id',trim($id));
        $query = $this->db->order_by('name','asc');
        $query = $this->db->get();
        $wcList = $query->result_array();
        return $wcList;
    }
    
    public function addrefurbDetails($data){
        $this->db->insert('crm_refurb_details', $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
    }
    
    public function getrefurbDetails($carid){
        $this->db->select('rd.*,rw.name');
        $this->db->from('crm_refurb_details as rd');
        $this->db->join('crm_refurb_workshop as rw', 'rw.id=rd.wc_id', 'inner');
        $this->db->where('car_id',$carid);
        $this->db->where('is_refurb_done','0');
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $refDetails = $query->result_array();
        return $refDetails;
    }
    
    public function updaterefurbDetails($id,$data){
        $this->db->where('id', $id);
        $this->db->update('crm_refurb_details', $data);
        return true;
    }

    public function leadTabCounts($requestParams,$dealerId) {
        $data = array();
        $fields = '*';
        if($requestParams['source']=='1'){
            $fields     =   'used_car.id car_id,used_car.reg_no regno,used_car.make_year,mm.model,
                            mm.id model_id,mm.make,mv.db_version as carversion,mv.db_version_id,
                            used_car.car_status active,rd.sent_to_refurb,rd.estimated_date,
                            rd.is_refurb_done,rd.estimated_amt,SUM(rd.estimated_amt) AS total_amount, COUNT(rd.id) AS total_refurbs';
        } else if($requestParams['source']=='2'){
             $fields     =   "rw.name, rw.mobile, rw.owner_name, rw.owner_mobile, (SELECT COUNT(*) FROM crm_refurb_details WHERE wc_id = rw.id AND is_refurb_done = '0') as pending, (SELECT COUNT(*) FROM crm_refurb_details WHERE wc_id = rw.id) as total, (SELECT SUM(estimated_amt) FROM crm_refurb_details WHERE wc_id = rw.id) as total_amount, (SELECT SUM(amount) FROM crm_workshop_payment WHERE wc_id = rw.id) as total_pay,(SELECT ((SELECT SUM(estimated_amt) FROM crm_refurb_details WHERE wc_id = rw.id)) - ((SELECT CASE WHEN SUM(amount) > 0 THEN SUM(amount) ELSE 0 END FROM crm_workshop_payment WHERE wc_id = rw.id))) as payment_due";
        }

        if($requestParams['source']=='1'){
            $this->db->select($fields);
            $this->db->from('crm_refurb_details as rd');
            $this->db->join('crm_used_car as used_car', 'used_car.id=rd.car_id', 'inner');
            $this->db->join('model_version as mv', 'mv.db_version_id=used_car.version_id', 'left');
            $this->db->join('make_model as mm', 'mm.id = mv.model_id', 'left');
            $this->db->where('used_car.dealer_id ',$dealerId);
        } else if($requestParams['source']=='2'){
            $this->db->select($fields);
            $this->db->from('crm_refurb_workshop as rw');
        }

        $this->db   = $this->refurbGetLeadsFilter($requestParams,$this->db);

        if($requestParams['source']=='1'){
            $this->db->group_by('used_car.id');
        }elseif($requestParams['source']=='2'){
            //$this->db->group_by('rd.wc_id'); 
        }
        
        $query  = $this->db->get();
        $data   = $query->result_array();
        return $data;
    }
    
    public function getCaseList($requestParams,$page,$limit,$dealerId){
         $requestParams['flag'] = !empty($requestParams['flag'])?$requestParams['flag']:0;
//        echo "<pre>";
//        print_r($requestParams);
//       exit;
        $responseData   = array();
        $fields         = '*';
        if($requestParams['source']== 1){
            $fields     =   'used_car.id car_id,used_car.reg_no regno,used_car.make_year,mm.model,
                            mm.id model_id,mm.make,mv.db_version as carversion,mv.db_version_id,
                            used_car.car_status active,rd.sent_to_refurb,rd.estimated_date,

                            rd.is_refurb_done,rd.estimated_amt,rd.file_name,rd.actual_amt,rd.refurb_details,wdc.workshop_detail_id as paymentId';

                        }
        else if($requestParams['source']== 2){
           // $fields     =   "rw.id, rw.name, rw.mobile, rw.owner_name, rw.owner_mobile,rw.created_at, (SELECT COUNT(*) FROM crm_refurb_details WHERE wc_id = rw.id AND is_refurb_done = '0') as pending, (SELECT COUNT(*) FROM crm_refurb_details WHERE wc_id = rw.id) as total, (SELECT SUM(estimated_amt) FROM crm_refurb_details WHERE wc_id = rw.id) as total_amount, (SELECT SUM(amount) FROM crm_workshop_payment WHERE wc_id = rw.id) as total_pay,(SELECT ((SELECT SUM(estimated_amt) FROM crm_refurb_details WHERE wc_id = rw.id)) - ((SELECT CASE WHEN SUM(amount) > 0 THEN SUM(amount) ELSE 0 END FROM crm_workshop_payment WHERE wc_id = rw.id))) as payment_due,(SELECT created_on FROM crm_refurb_details WHERE id IN (SELECT MAX(id) FROM crm_refurb_details GROUP BY wc_id) and wc_id=rw.id) as payment_on"; 
             $fields     =   "rw.id, rw.name, rw.mobile, rw.owner_name, rw.owner_mobile,rw.created_at, (SELECT max(updated_date) FROM crm_workshop_payment WHERE wc_id = rw.id) as last_up_date, 
                               (SELECT COUNT(*) FROM crm_refurb_details WHERE wc_id = rw.id AND is_refurb_done = '0') as pending, 
                               (SELECT COUNT(*) FROM crm_refurb_details WHERE wc_id = rw.id) as total, 
                               (SELECT SUM(actual_amt) FROM crm_refurb_details WHERE wc_id = rw.id) as total_amount, 
                               (SELECT SUM(amount) FROM crm_workshop_payment WHERE wc_id = rw.id) as total_pay,
                               (SELECT ((SELECT SUM(actual_amt) FROM crm_refurb_details WHERE wc_id = rw.id)) - ((SELECT CASE WHEN SUM(amount) > 0 THEN SUM(amount) ELSE 0 END FROM crm_workshop_payment WHERE wc_id = rw.id))) as payment_due,
                               (SELECT created_on FROM crm_refurb_details WHERE id IN (SELECT MAX(id) FROM crm_refurb_details GROUP BY wc_id) and wc_id=rw.id) as payment_on"; 
        }
        
        if(($requestParams['source']== 1) && (empty($requestParams['flag']) || $requestParams['flag'] == 0 ) )
        {
           $fields .= ',SUM(rd.estimated_amt) AS total_amount,
                            SUM(rd.actual_amt) AS actual_amount, 
                            COUNT(rd.id) AS total_refurbs'; 
        }
        
        if($requestParams['source']== 1){
            $this->db->select($fields);
            $this->db->from('crm_refurb_details as rd');
            $this->db->join('crm_used_car as used_car', 'used_car.id=rd.car_id', 'left');
            $this->db->join('model_version as mv', 'mv.db_version_id=used_car.version_id', 'left');
            $this->db->join('make_model as mm', 'mm.id = mv.model_id', 'left');
            $this->db->join('crm_workshop_detail_carids as wdc','wdc.refurb_case_id = rd.id','left');
            $this->db->group_by('rd.id');
//            if(!empty($requestParams['flag']) && $requestParams['flag'] == 1){
//            $this->db->where('used_car.dealer_id ',$dealerId);
//        }
        
         if (!empty($page) && !empty($limit))
                {
                    $offset     = ($page - 1) * $limit;
                    $this->db->offset((int) ($offset));
                }
                if (!empty($limit))
                {
                    $this->db->limit((int) $limit);
                }
             
        }
        
        
        
//        if(($requestParams['source']==1) && (empty($requestParams['flag'])))
//        {
//           //$this->db->join('crm_refurb_workshop as rw', 'rw.id=rd.wc_id', 'inner');
//           $this->db->where('used_car.dealer_id ',$dealerId);
//        }
         
        if($requestParams['source']==2){
            $this->db->select($fields);
            $this->db->from('crm_refurb_workshop as rw');
        }
        
        $this->db = $this->refurbGetLeadsFilter($requestParams,$this->db);

        if(($requestParams['source']==1) && (empty($requestParams['flag']))){
        $this->db->group_by('used_car.id');
        }elseif($requestParams['source']==2){
         //$this->db->group_by('rd.wc_id'); 
        }

       
        $query      = $this->db->get(); 
        $getleads   = $query->result_array();
        //echo $this->db->last_query(); exit;
        $leads = array();
        if (!empty($getleads)) {
            $i = 0;
            foreach ($getleads as $key => $val) {
                if($requestParams['source']==1){
                    $leads[$i]['car_id']            =       $val['car_id'];
                    $leads[$i]['regno']             =       $val['regno'];
                    $leads[$i]['make']              =       $val['make'];
                    $leads[$i]['model']             =       $val['model'];
                    $leads[$i]['version']           =       $val['carversion'];
                    $leads[$i]['model_id']          =       $val['model_id'];
                    $leads[$i]['db_version_id']     =       $val['db_version_id'];
                    $leads[$i]['active']            =       $val['active'];
                    $leads[$i]['sent_to_refurb']    =       $val['sent_to_refurb'];
                    $leads[$i]['estimated_date']    =       $val['estimated_date'];
                    $leads[$i]['is_refurb_done']    =       $val['is_refurb_done'];
                    $leads[$i]['file_name']    =       $val['file_name'];
                     $leads[$i]['services']    =       $val['refurb_details'];
                    $leads[$i]['estimated_amt']     =        $this->IND_money_format_model($val['estimated_amt']);
                     $leads[$i]['actual_amt']     =        $this->IND_money_format_model($val['actual_amt']);
                    $leads[$i]['make_year']         =       $val['make_year'];
                    $leads[$i]['car_status']         =       $val['car_status'];
                     $leads[$i]['is_booked']         =       $val['is_booked'];
                      $leads[$i]['in_refurb']         =       $val['in_refurb'];
                    
                    
                        $leads[$i]['total_refurbs']         =      !empty($val['total_refurbs'])? $val['total_refurbs']:0;
                        $leads[$i]['payment_id'] = !empty($val['paymentId'])?$val['paymentId']:0;
                    

                    if(isset($val['total_amount'])){
                        $leads[$i]['total_amount']         =       $this->IND_money_format_model($val['total_amount']);
                    }
                     if(isset($val['actual_amount'])){
                        $leads[$i]['actual_amount']         =       $this->IND_money_format_model($val['actual_amount']);
                    }
                } else if($requestParams['source']==2){
                    $leads[$i]['id']                =       $val['id'];
                    $leads[$i]['name']              =       $val['name'];
                    $leads[$i]['mobile']            =       $val['mobile'];
                    $leads[$i]['owner_name']        =       $val['owner_name'];
                    $leads[$i]['owner_mobile']      =       $val['owner_mobile'];
                    $leads[$i]['pending']           =       $val['pending'];
                    $leads[$i]['total']             =       $val['total'];
                    $leads[$i]['total_amount']      =       $val['total_amount'];
                    $leads[$i]['total_pay']         =       $val['total_pay'];
                    $leads[$i]['payment_due']       =        $this->IND_money_format_model($val['payment_due']);
                    $leads[$i]['payment_on'] =   !empty($val['payment_on'])?date('d M Y',strtotime($val['payment_on'])):"";
                    $leads[$i]['created_at'] = date('d M Y',strtotime($val['created_at'])); 
                    $leads[$i]['updated_payment_date'] = $val['last_up_date'];
                }
                $i++;
            }
        }

        

        return $leads;
    }
    
    public function refurbGetLeadsFilter($requestParams,$select) {
       
        if($requestParams['source']=='1'){
            
            if(isset($requestParams['payment_status']) && $requestParams['payment_status'] == 1){
                $select->where('wdc.workshop_detail_id IS NOT NULL');
            }
             if(isset($requestParams['payment_status']) && $requestParams['payment_status'] == 2){
                $select->where('wdc.workshop_detail_id IS NULL');
            }

             if(!empty($requestParams['carStatus'])){
                $select->where('used_car.car_status',$requestParams['carStatus']);
            }
             if(!empty($requestParams['w_id'])){
                $select->where('rd.wc_id',$requestParams['w_id']);
            }
            if(isset($requestParams['stock_status']) && ($requestParams['stock_status']=='1')){
                $select->where('rd.is_refurb_done','0');
            }
            if(isset($requestParams['stock_status']) && ($requestParams['stock_status']=='2')){
                $select->where('rd.is_refurb_done','1');
            }
            if(isset($requestParams['stock_status']) && isset($requestParams['date_status']) && ($requestParams['date_status']=='1') && ($requestParams['daterange_to']!='') && ($requestParams['daterange_from']!='')){
                $select->where('rd.sent_to_refurb>=',$requestParams['stock_status']);
            }
            if(isset($requestParams['date_status']) && ($requestParams['date_status']=='1') && ($requestParams['daterange_to']!='') && ($requestParams['daterange_from']!='')){
                //$select->where('rd.sent_to_refurb',$requestParams['stock_status']);
                $to = date('Y-m-d', strtotime($requestParams['daterange_to'])); 
                 $where = "DATE(sent_to_refurb)";
                 $select->where($where.'>=',$to);
                 $from = date('Y-m-d', strtotime($requestParams['daterange_from'])); 
                // $where = "DATE(sent_to_refurb)";
                 $select->where($where.'<=',$from);
            }
            if(isset($requestParams['date_status']) && ($requestParams['date_status']=='2') && ($requestParams['daterange_to']!='') && ($requestParams['daterange_from']!='')){
                //$select->where('rd.sent_to_refurb',$requestParams['stock_status']);
                $to = date('Y-m-d', strtotime($requestParams['daterange_to'])); 
                 $where = "DATE(estimated_date)";
                 $select->where($where.'>=',$to);
                 $from = date('Y-m-d', strtotime($requestParams['daterange_from'])); 
                 //$where = "DATE(estimated_date)";
                 $select->where($where.'<=',$from);
            }



            if (isset($requestParams['search_by']) && $requestParams['search_by'] != '') {
                $select->where("(used_car.reg_no like '%" .trim($requestParams['search_by']). "%' or mm.make like '%" . trim($requestParams['search_by']) . "%' or mm.model like '%" . trim($requestParams['search_by']). "%' or mv.db_version like '%" . trim($requestParams['search_by']) . "%')");
            }

        } else if($requestParams['source']=='2'){
            if (isset($requestParams['search_by']) && $requestParams['search_by'] != '') {
                $select->where("(rw.name like '%" . trim($requestParams['search_by']) . "%' or rw.owner_mobile like '%" . trim($requestParams['search_by']). "%' or rw.owner_name like '%" . trim($requestParams['search_by']). "%')");
            }

            if(isset($requestParams['min_payment']) && ($requestParams['min_payment']!='')){
                $select->having('payment_due >=',str_replace(",","",$requestParams['min_payment']));
            }
        }

        return $select;
    }

    public function getRefurbHistoryList($datapost){
        $this->db->select('rw.name,rw.id,
                            rd.refurb_details, 
                            rd.sent_to_refurb, 
                            rd.estimated_date, 
                            rd.file_name,
                            rd.id,
                            rd.estimated_amt,
                            rd.actual_amt,rd.sent_km,rd.return_km');
        $this->db->from('crm_refurb_details as rd');
        $this->db->join('crm_refurb_workshop as rw', 'rw.id=rd.wc_id', 'inner');
        $this->db->where('rd.car_id ',$datapost['car_id']);
        $this->db->order_by('rd.sent_to_refurb');
        $query      = $this->db->get(); 
        $leads      = $query->result_array();
        return $leads;
    }

    public function managePayment($datapost){
        $data = [];
        
        if(isset($datapost['workshop_id']) && trim($datapost['workshop_id']) != ''){
            $data['wc_id'] = trim($datapost['workshop_id']);
        }
        if(isset($datapost['edit_id']) && trim($datapost['edit_id']) != ''){
            $id = trim($datapost['edit_id']);
        }
        if(isset($datapost['instrumenttype']) && trim($datapost['instrumenttype']) != ''){
            $data['instrument_type'] = trim($datapost['instrumenttype']);
        }

        if(isset($datapost['insno']) && trim($datapost['insno']) != ''){
            $data['instrument_no'] = trim($datapost['insno']);
        }

        if(isset($datapost['amount']) && trim($datapost['amount']) != ''){
            $data['amount'] = str_replace(",","",trim($datapost['amount']));
        }
        if(isset($datapost['short_amount']) && trim($datapost['short_amount']) != ''){
            $data['short_amount'] = str_replace(",","",trim($datapost['short_amount']));
        }
        if(isset($datapost['total_amount']) && trim($datapost['total_amount']) != ''){
            $data['total_amount'] = str_replace(",","",trim($datapost['total_amount']));
        }

        if(isset($datapost['payment_bank']) && trim($datapost['payment_bank']) != ''){
            $data['bank_id'] = trim($datapost['payment_bank']);
        }

        if(isset($datapost['favouring']) && trim($datapost['favouring']) != ''){
            $data['favouring'] = trim($datapost['favouring']);
        }

        if(isset($datapost['insdate']) && trim($datapost['insdate']) != ''){
            $data['instrument_date'] = date("Y-m-d",strtotime($datapost['insdate']));
        }

        if(isset($datapost['paydates']) && trim($datapost['paydates']) != ''){
            $data['payment_date'] = date("Y-m-d",strtotime($datapost['paydates']));
        }
         if(isset($datapost['remark']) && trim($datapost['remark']) != ''){
            $data['remark'] = $datapost['remark'];
        }
        /* if(isset($datapost['refurb_case_id']) && trim($datapost['refurb_case_id']) != ''){
            $data['refurb_case_id'] = $datapost['refurb_case_id'];
        }*/
      //$data['total_amount'] = $datapost['totamt'];
        $data['updated_date'] = date("Y-m-d H:i:s");
        if(empty($id)){
            $data['created_date'] = date("Y-m-d H:i:s");
            $data['created_by']   = $this->session->userdata['userinfo']['id'];
            $this->db->insert('crm_workshop_payment', $data);
            $insert_id = $this->db->insert_id();
            $u = 0;
            foreach ($datapost['car_id'] as $key => $value) {
              //  echo  $datapost[0]['refurb_case_id']; exit;
               $datap['car_id'] = $value;
               $datap['workshop_detail_id'] = $insert_id;
               $datap['refurb_case_id'] = $datapost['refurb_case_id'][$u];
               $datap['status'] = '1';
               $this->db->insert('crm_workshop_detail_carids', $datap);
               $insert_ids = $this->db->insert_id();
               $u++;
            }
//exit;
            return $insert_id;
        }
        else{
            $this->db->where('id', $id);
            $this->db->update('crm_workshop_payment', $data);
            $datap['status'] = '0';
            $this->db->where('workshop_detail_id', $id);
            $this->db->update('crm_workshop_detail_carids', $datap);
             $u = 0;
            foreach ($datapost['car_id'] as $key => $value) 
            {
               $datap['car_id'] = $value;
              // $datap['refurb_case_id'] = $datapost['refurb_case_id'][$u];
               $datap['status'] = '1';
               $this->db->where('workshop_detail_id', $id);
               $this->db->update('crm_workshop_detail_carids', $datap);
               $u++;
            }
            return $id;
        }   
    }

    public function getPaymentSummary($w_id){
       //$fields     =   "rw.id, rw.name, rw.mobile, (SELECT COUNT(*) FROM crm_refurb_details WHERE wc_id = rw.id AND is_refurb_done = '0') as pending, (SELECT COUNT(*) FROM crm_refurb_details WHERE wc_id = rw.id) as total, (SELECT SUM(estimated_amt) FROM crm_refurb_details WHERE wc_id = rw.id) as total_amount, (SELECT SUM(amount) FROM crm_workshop_payment WHERE wc_id = rw.id) as total_pay,(SELECT ((SELECT SUM(estimated_amt) FROM crm_refurb_details WHERE wc_id = rw.id)) - ((SELECT CASE WHEN SUM(amount) > 0 THEN SUM(amount) ELSE 0 END FROM crm_workshop_payment WHERE wc_id = rw.id))) as payment_due"; 
        $fields     =   "rw.*,
                            rw.name, 
                            rw.mobile, 
                            (SELECT COUNT(*) FROM crm_refurb_details WHERE wc_id = rw.id AND is_refurb_done = '0') as pending, 
                            (SELECT COUNT(*) FROM crm_refurb_details WHERE wc_id = rw.id) as total, 
                            (SELECT SUM(actual_amt) FROM crm_refurb_details WHERE wc_id = rw.id) as total_amount, 
                            (SELECT SUM(amount) FROM crm_workshop_payment WHERE wc_id = rw.id) as total_pay,
                            (SELECT ((SELECT SUM(actual_amt) FROM crm_refurb_details WHERE wc_id = rw.id)) - ((SELECT CASE WHEN SUM(amount) > 0 THEN SUM(amount) ELSE 0 END FROM crm_workshop_payment WHERE wc_id = rw.id))) as payment_due"; 

        
        $this->db->select($fields);
        $this->db->from('crm_refurb_workshop as rw');
        $this->db->where('rw.id',trim($w_id));

        $query      = $this->db->get();
       // echo $this->db->last_query();die;
        $getleads   = $query->result_array();
        $leads = array();
        if (!empty($getleads)) {
            foreach ($getleads as $key => $val) {
                $leads['id']                =       $val['id'];
                $leads['name']              =       $val['name'];
                $leads['mobile']            =       $val['mobile'];
                $leads['pending']           =       $val['pending'];
                $leads['total']             =       $val['total'];
                $leads['total_amount']      =       $this->IND_money_format_model($val['total_amount']);
                $leads['total_pay']         =       $this->IND_money_format_model($val['total_pay']);
                $leads['payment_due']       =      $this->IND_money_format_model($val['payment_due']);
            }
        }
        return $leads;
    }

    public function getPaymentList($w_id='',$bankArray,$id="",$payment_id_condition='',$param = array()){
         $fields     =   "rw.*"; 
        $this->db->select($fields);
        $this->db->from('crm_workshop_payment as rw');
       
        if(!empty($id)){
            $this->db->where('rw.wc_id',trim($id));
        }
        
        if(!empty($param['searchby']) && $param['searchby'] == 'payment'){
            $this->db->where('rw.id',$param['keyword']); 
        }
        
         if(!empty($param['searchby']) && $param['searchby'] == 'instrument'){
            $this->db->where('rw.instrument_no',$param['keyword']); 
        } 
        
        if(!empty($param['startpaymentdate']) && !empty($param['endpaymentdate'])){
            $this->db->where('date(rw.payment_date)>=',date('Y-m-d', strtotime($param['startpaymentdate'])));
            $this->db->where('date(rw.payment_date)<=',date('Y-m-d', strtotime($param['endpaymentdate'])));
        }
       
        $this->db->where('rw.status','1');
        
        if(!empty($w_id)){
                $this->db->where('rw.wc_id',trim($w_id));
        }
            
        //Payment detail edit section 
         if(!empty($payment_id_condition)){
             $this->db->where('rw.id',trim($payment_id_condition));
         }   
            
         
        
        $query      = $this->db->get(); 
        $getleads   = $query->result_array();
        
        //echo $this->db->last_query();        
        $workshop_ids = $workshop_ids_deatils = $leads = $workshop_id_get = array();

        $leads = array();
        if(!empty($getleads)) {
            foreach ($getleads as $key => $val) 
            {
                $this->db->select('cr.*,mv.db_version as version,mm.make,mm.model,uc.reg_no,uc.make_year,rd.id as rdid,rd.estimated_amt,rd.actual_amt');
                $this->db->from('crm_workshop_detail_carids as cr');
                $this->db->join('crm_used_car as uc','uc.id=cr.car_id','inner');
                $this->db->join('model_version as mv','uc.version_id=mv.db_version_id','inner');
                $this->db->join('make_model as mm','mm.id=mv.model_id','inner');
                $this->db->join('crm_refurb_details as rd', 'cr.refurb_case_id=rd.id', 'inner');
                $this->db->where('cr.status','1');
                $this->db->where('cr.workshop_detail_id',$val['id']);
                
                if(!empty($param['searchby']) && $param['searchby'] == 'make'){
                $this->db->where(" mm.make like '%" . trim($param['keyword']). "%'");
                }
                if(!empty($param['searchby']) && $param['searchby'] == 'model'){
                $this->db->where("(mm.model like '%" . trim($param['keyword']). "%' or mv.db_version like '%" . trim($param['keyword']) . "%')");
                }
                if(!empty($param['searchby']) && $param['searchby'] == 'regno'){    
                $this->db->where("uc.reg_no like '%" .trim($param['keyword']). "%'");
                }
                $querys      = $this->db->get(); 
                $getcarleads   = $querys->result_array();
                //echo $this->db->last_query(); exit;
                $dn = array();
                if(!empty($getcarleads)){
                foreach ($getcarleads as $keys => $values) 
                {
                    $dn['refurb_case_id'][] = $values['refurb_case_id'];
                    $dn['car_id'][] = $values['car_id'];
                    $dn['stock'][] = $values['make'].' '.$values['model'].' '.$values['version'].'@'.$values['reg_no'].'@'.$values['make_year'].'@'.$this->IND_money_format_model($values['actual_amt']);
                }
                $leads[$key]['car_ids']           =       !empty($dn['car_id'])?$dn['car_id']:'';
                $leads[$key]['refurb_case_ids'] =           !empty($dn['refurb_case_id'])?$dn['refurb_case_id']:''; 
                $leads[$key]['stocks']            =       !empty($dn['stock'])?$dn['stock']:'';
                $leads[$key]['id']                =       $val['id'];
                $leads[$key]['wc_id']             =       $val['wc_id'];
                $leads[$key]['instrument_type']   =       $val['instrument_type'];
                $leads[$key]['workshop_detail_id'] =      $values['workshop_detail_id'];
                $leads[$key]['amount']            =       $this->IND_money_format_model($val['amount']);
                $leads[$key]['total_amount']      =       $this->IND_money_format_model($val['total_amount']);
                $leads[$key]['short_amount']      =       $this->IND_money_format_model($val['short_amount']);
                $leads[$key]['instrument_no']     =       $val['instrument_no'];
                $leads[$key]['instrument_date']   =       $val['instrument_date'];
                $leads[$key]['bank_id']           =       !empty($bankArray[$val['bank_id']])?$bankArray[$val['bank_id']]:'';
                $leads[$key]['payment_date']      =       $val['payment_date'];
                $leads[$key]['favouring']         =       $val['favouring'];
                $leads[$key]['remark']           =        $val['remark'];
                $leads[$key]['created_date']      =       $val['created_date'];
                }
            }
        }

      
        return $leads;
    }


     public function    getStocksList($requestParams,$dealerId="",$flag='',$case_ids=array()){
        $responseData   = array();
        if($flag == 'new'){
        $paymentid = !empty($requestParams['w_id'])?$requestParams['w_id']:"";
        $rr = !empty($requestParams['workshop_id'])?$requestParams['workshop_id']:"";
        }else{
        $rr = !empty($requestParams['w_id'])?$requestParams['w_id']:$requestParams['workshop_id'];    
        }
        
        $fields         = '*';
            $fields     =   'used_car.id car_id,used_car.reg_no regno,used_car.make_year,mm.model,
                            mm.id model_id,mm.make,mv.db_version as carversion,mv.db_version_id,
                            used_car.car_status active,rd.sent_to_refurb,rd.estimated_date,rd.created_on,
                            rd.is_refurb_done,rd.estimated_amt,rd.actual_amt,rd.file_name,rd.id as refurb_id,wcd.refurb_case_id';
                           
                         //   $fields     .=  ',rw.services as services';

            $this->db->select($fields);
            $this->db->from('crm_refurb_details as rd');
            $this->db->join('crm_used_car as used_car', 'used_car.id=rd.car_id', 'left');
            $this->db->join('model_version as mv', 'mv.db_version_id=used_car.version_id', 'left');
            $this->db->join('make_model as mm', 'mm.id = mv.model_id', 'left');
            //$this->db->join('crm_refurb_workshop as rw', 'rw.id=rd.wc_id', 'inner');
            //$this->db->join('crm_workshop_payment as wp', 'wp.wc_id=rd.wc_id', 'left');
            $this->db->join('crm_workshop_detail_carids as wcd', 'wcd.refurb_case_id=rd.id', 'left');
            //$this->db->where('used_car.dealer_id ',$dealerId);
           
            //$this->db->where('rd.wc_id',$requestParams['workshop_id']);
if(!empty($requestParams['type']) && strtolower($requestParams['type']) == 'edit' && $flag!= 'new'){
                $this->db->where('rd.wc_id',$rr);
                $this->db->where('rd.is_refurb_done','1');
                
                 if(!empty($case_ids)){
                     $this->db->where_not_in('rd.id',$case_ids);
                 }
               
            }elseif(empty($requestParams['type']) && !empty($requestParams['module']) && $requestParams['module'] == 'payment_details_1'){
                
                 $this->db->where('rd.wc_id',$rr);
                 $this->db->where('rd.is_refurb_done','1');
                 
                 if(!empty($case_ids)){
                     $this->db->where_not_in('rd.id',$case_ids);
                 }
            }      
           
            if($flag == 'new'){
                $this->db->where('rd.wc_id',$rr);
                $this->db->where('rd.is_refurb_done','1'); 
                $this->db->where('wcd.workshop_detail_id',$paymentid);
                //$this->db->where('rd.wc_id',$rr);
            }            
            if (isset($requestParams['search_by']) && $requestParams['search_by'] != '') {
                $select->where("(used_car.reg_no like '%" .trim($requestParams['search_by']). "%' or mm.make like '%" . trim($requestParams['search_by']) . "%' or mm.model like '%" . trim($requestParams['search_by']). "%' or mv.db_version like '%" . trim($requestParams['search_by']) . "%')");
            }
            $this->db->group_by('used_car.id');
            $this->db->order_by('rd.created_on','DESC');
            $query      = $this->db->get(); 
            $getleads   = $query->result_array();
            //echo $this->db->last_query();
            
        $leads = array();
        if (!empty($getleads)) {
            $i = 0;
            foreach ($getleads as $key => $val) {

                    $leads[$i]['car_id']            =       $val['car_id'];
                    $leads[$i]['refurb_id']         =       $val['refurb_id'];
                    $leads[$i]['regno']             =       $val['regno'];
                    $leads[$i]['make']              =       $val['make'];
                    $leads[$i]['model']             =       $val['model'];
                    $leads[$i]['version']           =       $val['carversion'];
                    $leads[$i]['model_id']          =       $val['model_id'];
                    $leads[$i]['db_version_id']     =       $val['db_version_id'];
                    $leads[$i]['active']            =       $val['active'];
                    $leads[$i]['sent_to_refurb']    =       $val['sent_to_refurb'];
                   // $leads[$i]['estimated_date']    =       $val['estimated_date'];
                    $leads[$i]['is_refurb_done']    =       $val['is_refurb_done'];
                    $leads[$i]['make_year'] = $val['make_year'];
                   // $leads[$i]['file_name']    =       $val['file_name'];
                   //  $leads[$i]['services']    =       $val['services'];
                    $leads[$i]['estimated_amt']     =        $this->IND_money_format_model($val['estimated_amt']);
                    $leads[$i]['actual_amt'] = $this->IND_money_format_model($val['actual_amt']);
                   // $leads[$i]['make_year']         =       $val['make_year'];
                   //   $leads[$i]['total_refurbs']         =       $val['total_refurbs'];
                   // if(isset($val['total_amount'])){
                        //$leads[$i]['total_amount']         =       $this->IND_money_format_model($val['total_amount']);
                    //}
                $i++;
            }
        }

        return $leads;
    }
}



