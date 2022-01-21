<?php
class Usermodel extends CI_Model
{

	private $table = 'crm_user';
	public function __construct()
        {
                
        }
	public function add_user($data,$id='')
    {
    	$dataArr =[];
        $dataArr['name']      = !empty($data['name'])?ucwords($data['name']):'';
        $dataArr['email']     = !empty($data['email'])?strtolower($data['email']):'';
        $dataArr['mobile']    = !empty($data['mobile'])?$data['mobile']:'';
        $dataArr['password']  = !empty($data['password'])? md5($data['password']):'';
        $dataArr['user_code'] = !empty($data['password'])?$data['password']:'';
        $dataArr['dob']       = !empty($data['dob'])? date('Y-m-d',strtotime($data['dob'])):'';
        $dataArr['doj']       = !empty($data['doj'])?date('Y-m-d',strtotime($data['doj'])):'';
        $dataArr['team_id']   = !empty($data['team_id'])?$data['team_id']:'';
        $dataArr['role_id']   = !empty($data['role_id'])?$data['role_id']:'';
        $dataArr['dealer_id']   = !empty($data['dealer_id'])?$data['dealer_id']:'';
        $dataArr['status']    = !empty($data['status'])?$data['status']:'';
        if($data['id']=='')
        {
            $dataArr['created_by']= '';
            $dataArr['created_date'] = date('Y-m-d H:i:s');
            $this->db->insert($this->table, $dataArr);
            $id = $this->db->insert_id();
            $this->saveEmpBankLimit($data,$id);
            return $id;
        }
        else{
            $dataArr['updated_by']= '';
            $this->db->where('id', $data['id']);
            $this->db->update(CRM_USER, $dataArr);
            $this->saveEmpBankLimit($data,$id,1);
            return $data['id'];
   	}
       
    }
	public function view_user()
	{
    $this->load->database();
    $this->db->select('u.*,t.team_name as team,r.role_name as role,b.bank_id as bank,b.id as bank_id');
    $this->db->from(CRM_USER .' as u');
    $this->db->join(BANK_EMP_LIMIT_MAPPING .' as bm', 'bm.emp_id=u.id','left');
    $this->db->join(CRM_BANK .' as b', 'bm.bank_id=b.id','left');
    $this->db->join(CRM_TEAM .'  as t', 't.id=u.team_id','inner');
    $this->db->join(CRM_ROLE .' as r', 'r.id=u.role_id','inner');
		$this->db->where_not_in('u.status','2');
     $this->db->where('bm.status','1');
    $this->db->order_by('id','desc');
    $query = $this->db->get();
    $result = $query->result_array();
    //$array = json_decode(json_encode($result),true);
		return $result;
	}
	public function role($teamid)
  	{
        $this->load->database(); 
        $query = $this->db->get_where(CRM_ROLE, array('status' => '1','team_id'=>$teamid));
        return $row = $query->result();
   }
   	public	function team()
  	{
       $this->load->database(); 
        $query = $this->db->get_where(CRM_TEAM, array('status' => '1'));
        return $query->result();
   }
    public  function dealer()
    {
       $this->load->database(); 
        $query = $this->db->get_where('crm_dealers', array('status' => '1'));
        return $query->result();
   }
   function getEditUser($userId)
    {
    $this->load->database();
    $this->db->select('u.*,t.team_name as team,r.role_name as role');
    $this->db->from(CRM_USER .' as u');
    $this->db->join(CRM_TEAM .' as t', 't.id=u.team_id','inner');
    $this->db->join(CRM_ROLE .' as r', 'r.id=u.role_id','inner');
    $this->db->where('u.id',$userId);
    $query = $this->db->get();
    $result = $query->result();
    $array = json_decode(json_encode($result),true);

    $this->db->select('bm.emp_limit,bm.bank_id,b.bank_id');
    $this->db->from(CRM_BANK .' as b');
    $this->db->join(BANK_EMP_LIMIT_MAPPING.'  as bm', 'bm.bank_id=b.bank_id','inner');
    $this->db->where('bm.emp_id',$userId);
    $this->db->where('bm.status','1');
    $this->db->group_by('b.bank_id');
    $query2 = $this->db->get();
    //echo $this->db->last_query();die;
    $result2 = $query2->result();
    $array[0]['bank'] = json_decode(json_encode($result2),true);
    return $array;
    }
   function editUser($userInfo, $userId)
    {
        $this->db->where('id', $userId);
        $this->db->update(CRM_USER, $userInfo);
        
        return TRUE;
    }
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('id', $userId);
        $this->db->update(CRM_USER, $userInfo);
        
        return $this->db->affected_rows();
    }

    function getBank($getSelectedBank=[])
    {
        $this->db->select('b.*');
        $this->db->from(CRM_BANK .' as b');
        $this->db->where('b.status','1');
        if(!empty($getSelectedBank)){
        $this->db->where_not_in('b.bank_id',$getSelectedBank);
        }
       $query = $this->db->get();
       //echo $this->db->last_query(); exit;
       $result = $query->result_object();
      return $result;
    }

    function saveEmpBankLimit($data,$empId,$flag='0')
    {
     $checkRecord = $this->db->get_where('bank_employee_limit_mapping', array('emp_id' => $empId,'status'=>'1'));
     $emplyeeCheck= $checkRecord->num_rows(); 
        $dataArr = [];
        if($emplyeeCheck !='0'){
            $this->db->where(array('emp_id' => $empId));
            $this->db->update(BANK_EMP_LIMIT_MAPPING, array('status'=>'0'));
        }
        if(!empty($data['bank']) && !empty($data['limit'])){
        $banks = array_combine ($data['bank']  , $data['limit']);
        foreach($banks as $k => $v){      
        $check = $this->db->get_where('bank_employee_limit_mapping', array('emp_id' => $empId,'bank_id'=>$k,'status'=>'1'));
        $emplyeeCheckForBank= $check->num_rows(); 
        $this->load->database();  
         if($emplyeeCheckForBank > '0')
         {
            $dataArr['emp_limit'] = str_replace(',','',$v);
            $dataArr['status']    = '1';
            $this->db->where(array('emp_id' => $empId,'bank_id'=>$k));
            $this->db->update(BANK_EMP_LIMIT_MAPPING, $dataArr);
         }
         else
         {
            $dataArr['bank_id']       = $k;
            $dataArr['emp_limit']     =  str_replace(',','',$v);
            $dataArr['emp_id']        = $empId;
            $dataArr['created_on']    = date('Y-m-d H:i:s');
            $this->db->insert(BANK_EMP_LIMIT_MAPPING, $dataArr);
          //  echo $this->db->last_query();
         }
      }
    }
        return TRUE;
    }

    function updateEmpStatus($empInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(CRM_USER, $empInfo);
        if($empInfo['status'] != 1){
            $this->db->where('emp_id', $id);
            $this->db->update(BANK_EMP_LIMIT_MAPPING,array('emp_limit'=>0));
        }
        return TRUE;
    }

    function viewusercount()
    {
      $this->load->database();
      $this->db->select('u.*,t.team_name as team,r.role_name as role,b.bank_id as bank,b.id as bank_id');
      $this->db->from(CRM_USER .' as u');
      $this->db->join(BANK_EMP_LIMIT_MAPPING.'  as bm', 'bm.emp_id=u.id','left');
      $this->db->join(CRM_BANK .' as b', 'bm.bank_id=b.id','left');
      $this->db->join(CRM_TEAM .' as t', 't.id=u.team_id','inner');
      $this->db->join(CRM_ROLE .' as r', 'r.id=u.role_id','inner');
      $this->db->where('u.status','1');
      $this->db->where('bm.status','1');

      $query = $this->db->get();
     //echo $this->db->last_query(); exit;
      $result = $query->num_rows();
      return $result;
    }
   function checkSearchEmpty($requestParams){
       $isempty = 0;
        if (isset($requestParams['search_by']) && $requestParams['search_by'] != '') {
            $isempty = 1;
        }
        if(isset($requestParams['employee_team']) && $requestParams['employee_team'] != ''){
               $isempty = 1;
        }
        if(isset($requestParams['employee_role']) && $requestParams['employee_role'] != ''){
                $isempty = 1;
        }
        if(isset($requestParams['sale_emp']) && $requestParams['sale_emp'] != ''){
               $isempty = 1;
        }
        return   $isempty;
     }

    public function get_current_page_records($dealerId='',$requestParams='',$pages="",$is_count="") 
    { 
       // $isempty = $this->checkSearchEmpty($requestParams);
        $rpp=10;
        $perPageRecord = $rpp == 0 ? 10 : $rpp;
        $pageNo = (isset($pages) && $pages != '') ? $pages : '1';
        $startLimit = ($pageNo - 1) * $perPageRecord;
        
        $this->load->database();
        $this->db->select('u.*,t.team_name as team,r.role_name as role');
        $this->db->from(CRM_USER .' as u');
        $this->db->join(CRM_TEAM .' as t', 't.id=u.team_id','inner');
        $this->db->join(CRM_ROLE .' as r', 'r.id=u.role_id','inner');
        $this->db->where_not_in('u.status','2');
        $this->db->where_not_in('u.role_id',array(24,23));
        $this->SearchQuery($requestParams); 
        $this->db->order_by('u.id','desc');
        if($is_count != 1){
            if (isset($pages))
            {
               $this->db->offset((int) ($startLimit));
            }
            if (!empty($perPageRecord))
            {
                $this->db->limit((int) $perPageRecord);
            }
        }
         $query = $this->db->get();
        // echo $this->db->last_query(); exit;  
         $result = $query->result();
        if ($query->num_rows() > 0) 
        {
            foreach ($result   as $row) 
            {
                $data[] = $row;
            }
            if ($is_count == 1) {
                $data = count($result);
            }

            return $data;
        }
 
        return false;
    }
     public function SearchQuery($requestParams) {
        $select=$this->db;
        if (isset($requestParams['search_by']) && $requestParams['search_by'] != '') {
              $likeCriteria = "(u.name  LIKE '%".$requestParams['search_by']."%'
                            OR  u.mobile  LIKE '%".$requestParams['search_by']."%')";
            $select->where($likeCriteria);
        }
        if(isset($requestParams['employee_team']) && $requestParams['employee_team'] != ''){
               $select->where('u.team_id',$requestParams['employee_team']);
        }
        if(isset($requestParams['employee_role']) && $requestParams['employee_role'] != ''){
               $select->where('u.role_id',$requestParams['employee_role']);
        }
        if(isset($requestParams['sale_emp']) && $requestParams['sale_emp'] != ''){
               $select->where('u.status',$requestParams['sale_emp']);
        }
     }
 public function getBankLimit($id,$editid= null)
    {
      $this->load->database(); 
      $query = $this->db->get_where(CRM_BANK, array('status' => '1','bank_id'=>$id));
      $array = $query->result_array();
      //echo $this->db->last_query();
     // print_r($array);die;
    if(!empty($array)){
      $totalLimit = $array[0]['amount_limit'];
    }      
        $this->db->select('b.*');
        $this->db->from(BANK_EMP_LIMIT_MAPPING.' as b');
        $this->db->join('crm_user  as u', 'b.emp_id=u.id','inner'); 
        $this->db->where('b.status','1');
        $this->db->where('u.status','1');
        $this->db->where('u.id != '.$editid);
        $this->db->where('b.bank_id',$id);
        $query = $this->db->get();
       // echo $this->db->last_query();die;
        $empResult = $query->result();
      $usedLimit = 0;
    if(!empty($empResult)){
        foreach ($empResult as $key => $value) {
          $empLimi = 0;
          if($value->emp_limit>0)
          {
            $empLimi = $value->emp_limit;
          }
        $usedLimit = $usedLimit+$empLimi;
        }
    }
     // echo $totalLimit.' - '.$usedLimit; exit;
      $resultLimit = $totalLimit-$usedLimit;
      if($resultLimit>0)
      { 
        echo $resultLimit; exit;
      }
      else
      {
        echo 0; exit;
      }
    }

  /*  public function getBankLimit($id)
    {
      $this->load->database(); 
      $query = $this->db->get_where(CRM_BANK, array('status' => '1','id'=>$id));
      $array = $query->result_array();
      $totalLimit = $array[0]['amount_limit'];
      $limitQuery = $this->db->get_where(BANK_EMP_LIMIT_MAPPING, array('status' => '1','bank_id'=>$id));
      $empResult = $limitQuery->result();
      $usedLimit = 0;
      foreach ($empResult as $key => $value) {
        $usedLimit = $usedLimit+$value->emp_limit;
      }
      //echo $totalLimit.' - '.$usedLimit; exit;
      $resultLimit = $totalLimit-$usedLimit;
      if($resultLimit>0)
      { 
        echo $resultLimit; exit;
      }
      else
      {
        echo 0; exit;
      }
    }
    */
    function checkEmailExists($email, $userId = 0) {
        
        $this->db->select('email');
        $this->db->from(CRM_USER);
        $this->db->where('email', $email);
        if($userId != 0){
            $this->db->where("id !=", $userId);
        }
        $this->db->where('status', '1');
        $query = $this->db->get();
       // echo $this->db->last_query();die;
        $result= $query->row_array();
        if($result){
        return ['status'=>'true','data'=>$result];
        }else{
            return ['status'=>'false','data'=>''];
        }
        }
        
        function checkMobileExists($mobile, $userId = 0) {
        
        $this->db->select('mobile');
        $this->db->from(CRM_USER);
        $this->db->where('mobile', $mobile);
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
    function getTeams() {
            $this->db->select('id,team_name');
            $this->db->from("crm_team_type");
            $this->db->where('status', '1');
            $query = $this->db->get();
            $result = $query->result_array();
            return $result;
    }
    function getRoleByTeamID($id) {
            $this->db->select('id,role_name,team_id');
            $this->db->from("crm_role");
            $this->db->where('status', '1');
            $this->db->where_not_in('id', array(24,23));
            $this->db->where('team_id', $id);
            $query = $this->db->get();
            $result = $query->result_array();
            return $result;
    }

}

