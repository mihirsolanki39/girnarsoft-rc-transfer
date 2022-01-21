<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * model : Crm_dealers
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
class Crm_dealers extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function dealerListingCount($searchText = '')
    {
        $this->db->select('d.*,');
        $this->db->from('crm_dealers as d');
        if(!empty($searchText)) {
            $likeCriteria = "(d.organization  LIKE '%".$searchText."%'
                            OR  d.dealership_email  LIKE '%".$searchText."%'
                            OR  d.dealership_contact  LIKE '%".$searchText."%'
                            OR  d.owner_name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function dealerListing($dealerId='',$searchText='',$page, $segment)
    {
        $this->db->select('d.*,co.outlet_address as user_address,co.city,co.state');
        $this->db->from('crm_dealers as d');
        $this->db->join('crm_outlet  as co', 'co.dealer_id=d.id and co.status="1"','left');
        if(!empty($dealerId)){
        $this->db->where('d.id', $dealerId);
        $this->db->where('d.status', '1');
        }
        //$this->db->where('co.status', '1');
        if(!empty($searchText)) {
            $likeCriteria = "(d.organization  LIKE '%".$searchText."%'
                            OR  d.dealership_email  LIKE '%".$searchText."%'
                            OR  d.dealership_contact  LIKE '%".$searchText."%'
                            OR  d.owner_name  LIKE '%".$searchText."%'
                            OR  co.outlet_address  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();  
        //echo $this->db->last_query();die;
        return $result;
    }
    
    function getDealerById($dealerId)
    {
        $this->db->select('dealership_contact as mobile');
        $this->db->from('crm_dealers');
        $this->db->where('id', $dealerId);
        $query = $this->db->get();
        $result= $query->row_array();
        return $result;
    }
    
     
    function checkOwnerNumberExists($mobile, $userId = 0) {
        
        $this->db->select('owner_mobile');
        $this->db->from('crm_dealers');
        $this->db->where('owner_mobile', $mobile);
        if($userId != 0){
            $this->db->where("id !=", $userId);
        }
        $this->db->where('status', '1');
        $query = $this->db->get();
        $result= $query->row_array();
        if($result){
        $result     = ['status'=>'true','data'=>$result];
        }else{
            $result =  ['status'=>'false','data'=>''];
        }
        return $result;
        //echo $this->db->last_query();die;
        }
   

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0) {
        
        $this->db->select('dealership_email');
        $this->db->from('crm_dealers');
        $this->db->where('dealership_email', $email);
        if($userId != 0){
            $this->db->where("id !=", $userId);
        }
        $this->db->where('status', '1');
        $query = $this->db->get();
        $result= $query->row_array();
        if($result){
        return ['status'=>'true','data'=>$result];
        }else{
            return ['status'=>'false','data'=>''];
        }
        }
    /**
     * This function is used to check whether mobile is already exist or not
     * @param {string} $mobile : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkMobileExists($mobile, $userId = 0) {
        
        $this->db->select('dealership_contact');
        $this->db->from('crm_dealers');
        $this->db->where('dealership_contact', $mobile);
        if($userId != 0){
            $this->db->where("id !=", $userId);
        }
        $this->db->where('status', '1');
        $query = $this->db->get();
        $result= $query->row_array();
       // echo $this->db->last_query();die;
        if($result){
        return ['status'=>'true','data'=>$result];
        }else{
            return ['status'=>'false','data'=>''];
        }
        }
   

    /**
     * This function is used to add new dealer to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewDealer($userInfo, $updateId = '') {
        if (empty($updateId)) {
            $this->db->trans_start();
            $this->db->insert('crm_dealers', $userInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $result= $insert_id;
        } else {
            $this->db->where('id', $updateId);
            $this->db->update('crm_dealers', $userInfo);
            return $updateId;
        }
        return $result;
    }

    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }


    

    

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfoById($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    function updateDealerStatus($dealerInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('crm_dealers', $dealerInfo);
        return TRUE;
    }
    
    public function getDealers($id="",$type='0',$flag='',$status=''){
       $this->db->select('id,owner_name as name,dealership_email as email,organization,payment_favoring');
       $this->db->from('crm_dealers');
       $arr = explode(',',$type);
       if(empty($status)){
             $this->db->where('status', '1');
        }
       if($id>0)
       {
            $this->db->where('id',$id);
       }
       if(empty($arr[1])){
           if($type != 0)
             $this->db->where('dealer_type',$type);
        }
        else
        {
            $this->db->where_in('dealer_type',$arr);
        }
       if(!empty($flag))
       {
            $this->db->or_where('dealer_type','2');
       }
       
       //}
       $query = $this->db->get();
       $result = $query->result_array();
      // echo $this->db->last_query(); exit;
       return  $result;     

    }
    
    public function getDealerShowroom($id='')
    {
        $this->db->select('d.*,co.outlet_address as user_address,co.city,co.state');
        $this->db->from('crm_dealers as d');
        $this->db->join('crm_outlet  as co', 'co.dealer_id=d.id and co.status="1"','left');
        $this->db->where('d.status', '1');
        if(!empty($id))
        {
            $this->db->where('d.id', $id);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        // echo $this->db->last_query(); exit;
        return  $result; 
    }

    public function getDealerAdmin($dealer_id){
        $this->db->select('d.*');
        $this->db->from('crm_admin_dealers as d');
        $this->db->join('crm_dealer_module  as dm', 'd.dealer_id=dm.dealer_id','left');
        $this->db->join('crm_dealer_whitelist  as dw', 'd.dealer_id=dw.dealer_id','left');
        $this->db->where('d.status', '1');
        if(!empty($dealer_id))
        {
            $this->db->where('d.dealer_id', $dealer_id);
        }
        $query = $this->db->get();
       // echo $this->db->last_query(); exit;
        return $result = $query->result_array();
    }

    public function addUpdateAdminDealer($requestData)
    {
        $module_id = [];

        $result = $this->getDealerAdmin($requestData['data']['dealer_id']);
       
        $dealerInfo['dealer_id'] = $requestData['data']['dealer_id'];
        $dealerInfo['dealer_status'] = $requestData['data']['dealer_status'];
        $dealerInfo['organization'] = $requestData['data']['organization'];
        $dealerInfo['address'] = $requestData['data']['address'];
        $dealerInfo['default_showroom_id'] = $requestData['data']['showroom_id'];  
        $dealerInfo['domain'] = $requestData['data']['page_url'];
        $dealerInfo['whitelist_ip'] = $requestData['data']['whitelist_ip'];
        $dealerInfo['user_name'] = trim($requestData['data']['username']);
        $dealerInfo['password'] = md5(trim($requestData['data']['password_text']));
        $dealerInfo['mobile'] = $requestData['data']['admin_mobile'];
        $dealerInfo['email'] = $requestData['data']['admin_email'];
        $dealerInfo['gcd_code'] = $requestData['data']['gcd_code'];
        //$dealerInfo['loan_bank_limit'] = $requestData['data']['loan_bank_limit'];
        //$dealerInfo['ins_done_by'] = $requestData['data']['ins_done_by'];
        //$dealerInfo['ins_sis_comp'] = $requestData['data']['ins_sis_comp'];
        $dealerInfo['sms_sender'] = $requestData['data']['sms_sender'];
        $dealerInfo['email_sender'] = $requestData['data']['email_sender'];
        $dealerInfo['normalp'] = $requestData['data']['password_text'];
        $dealerInfo['city_id'] = $requestData['data']['city_id'];
        $dealerInfo['locality_id'] = $requestData['data']['locality_id'];
        $dealerInfo['showroom_id'] = $requestData['data']['showroom_id'];
        $dealerInfo['is_feature'] = $requestData['data']['is_feature'];
        $dealerInfo['feature_car'] = $requestData['data']['feature_count'];
        $dealerInfo['is_classified'] = $requestData['data']['is_classified'];
        $dealerInfo['classified_luxury_count'] = $requestData['data']['classified_luxury_count'];
        foreach ($requestData['data']['modules'] as $ky => $vl) 
        {
            if($vl['module_name']=='Loan')
            {
                $da = json_decode($vl['module_data']);
                $dealerInfo['loan_bank_limit'] = ($da->bank_limit=='employee_wise')?'2':'1';
            }
            if($vl['module_name']=='Insurance')
            {
                $da = json_decode($vl['module_data']);
                $dealerInfo['ins_done_by'] = ($da->ins_done_by=='sis_comp')?'2':'1';
                $dealerInfo['ins_sis_comp'] = $da->sis_company_name;
            }
            $module_id[$vl['module_id']] = $vl['module_id'];
        }
        $this->updateHeaderModules($module_id);
        $dealerInfo['classified_limit'] = $requestData['data']['classified_count'];
        if($requestData['data']['whitelist_ip']=='1')
        {
            $this->db->where('dealer_id', $requestData['data']['dealer_id']);
            $this->db->update('crm_dealer_whitelist', array('status'=>'0'));
            $yy = explode(',', $requestData['data']['iplist']);
               foreach ($yy as $key)
               {
                    $r['dealer_id'] = $requestData['data']['dealer_id'];
                    $r['whiteip'] = $key['whiteip'];
                    $r['status'] = '1';
                    $r['created_on'] = date('Y-m-d H:i:s');
                    $this->db->insert('crm_dealer_whitelist', $r);
                    $insert_id = $this->db->insert_id();   
               }
            
        }
        if(empty($result))
        {
            $this->db->insert('crm_admin_dealers', $dealerInfo);
            $insert_id = $this->db->insert_id();
        }
        else
        {
            $this->db->where('dealer_id', $requestData['data']['dealer_id']);
            $this->db->update('crm_admin_dealers', $dealerInfo);
        }

        return true;
    }

    public function updateHeaderModules($module_id)
    {
        $header['statue'] = '0';
        $this->db->update('crm_header_role', $header);
        foreach ($module_id as $key) 
        {
            $header['statue'] = '1';
            $this->db->where('parent_module_id', $key);
            $this->db->update('crm_header_role', $header);
        }
    }
    
    public function getDealersByType($type=['0','1','2'])
    {
        $this->db->select('*,d.organization cat_name');
        $this->db->from('crm_dealers as d');
        $this->db->where_in('dealer_type', $type);
        $query = $this->db->get();
        return $result = $query->result_array();
    }
    
    public function getdealerListingNew($params,$page='',$limit=0)
    {
        $perPageRecord = $limit == 0 ? 1 : $limit;
        $pageNo = (isset($page) && $page != '') ? $page : '1';
        $startLimit = ($pageNo - 1) * $perPageRecord;
        $this->db->select('d.*,us.name as assignuser,u.name as uname,cu.name as uuname,cr.role_name');
        $this->db->from('crm_dealers as d');
        $this->db->join('crm_user  as us', 'us.id=d.user_id','left');
        $this->db->join('crm_role as cr','cr.id=us.role_id','left');
        $this->db->join('crm_user  as u', 'd.created_by=u.id','left');
        $this->db->join('crm_user  as cu', 'd.updated_by=cu.id','left');
        //$this->db->where('cr.role_name', 'Executive');
        //$this->db->where('cr.status', '1');
        $this->db->where_in('d.dealer_type', ['0','1','2']);
        //$this->db->where('d.status', '1');
        if($limit!=0){
        $this->db->offset((int) ($startLimit));
        $this->db->limit((int) $perPageRecord);
        }
        $this->getDealerFilter($params);
        $this->db->order_by('d.id', 'DESC');
        $this->db->last_query();
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    public function getdealerexportListing($params){
        $this->db->select('d.organization,d.dealership_contact as mobile,d.owner_name,d.dealer_type,d.status,us.name as assignuser,u.name as uname,cu.name as uuname,cr.role_name');
        $this->db->from('crm_dealers as d');
        $this->db->join('crm_user  as us', 'us.id=d.user_id','left');
        $this->db->join('crm_role as cr','cr.id=us.role_id','left');
        $this->db->join('crm_user  as u', 'd.created_by=u.id','left');
        $this->db->join('crm_user  as cu', 'd.updated_by=cu.id','left');
        $this->db->where_in('d.dealer_type', ['0','1','2']);
        $this->getDealerFilter($params);
        $this->db->order_by('d.id', 'DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $result = $query->result_array();
        return $result;
    }
    
    public function getDealerFilter($params){
        $select=$this->db;
        if (isset($params['keyword']) && $params['keyword'] != '') {
            $select->where("(d.organization like '%" . trim($params['keyword']) . "%' or d.dealership_contact like '%" . trim($params['keyword']). "%' or d.owner_name like '%" .trim($params['keyword']). "%')");
        }
        if (isset($params['category']) && $params['category'] != '') {
            $this->db->where('d.dealer_type', $params['category']);
        }
        if (isset($params['status']) && $params['status'] != '') {
            $this->db->where('d.status', $params['status']);
        }
        if (isset($params['dealtby']) && $params['dealtby'] != '') {
            
                $select->where("us.id='" . $params['dealtby'] . "'");
        }
    }

    public function dealerSmsLog($ownerMobile,$content,$dealer_id)
    {
      $caseInfo = [];
      $caseInfo['dealer_mobile'] = (!empty($ownerMobile)?$ownerMobile:'');
      $caseInfo['dealer_id'] = (!empty($dealer_id)?$dealer_id:'');
      $caseInfo['sms_text'] = (!empty($content)?$content:'');
      //$caseInfo['response'] = (!empty($response)?$response:'');
      $this->db->trans_start();
      $this->db->insert('dealer_onboarding_sms', $caseInfo);
      $insert_id = $this->db->insert_id();
      $this->db->trans_complete();
      $result = $insert_id;
      return $result;
    }

}
