<?php
class Loginmodel extends CI_Model
{
        private $dateTime='';
	public function __construct()
        {
                parent::__construct();
                $this->dateTime=date("Y-m-d H:i:s");
        }
        
        public function get_mysqli() { 
		$db = (array)get_instance()->db;
		return mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
	}
        
	public function validate_login($username,$password)
	{
              //ini_set('display_errors','1');error_reporting(E_ALL);
		$username = mysqli_real_escape_string($this->get_mysqli(),$username);
		$password = mysqli_real_escape_string($this->get_mysqli(),$password);
		//$username = $this->db->escape($username);
		//$password = $this->db->escape($password);
                
		$this->db->select('u.id,u.name,u.email,u.password,u.mobile,u.dob,u.doj,u.role_id,u.team_id,u.dealer_id,u.user_code,u.status,u.is_admin,u.created_date,u.updated_date,t.team_name,r.role_name,d.is_classified,d.mobile as dealer_mobile,d.organization,d.address,d.default_showroom_id,d.email as dealer_email');
                $this->db->from('crm_user u');
                //$query = $this->db->get_where('crm_user u', array('email' => $username,'password' => md5($password),'status'=>'1'));
                $this->db->join('crm_admin_dealers d', 'd.dealer_id=u.dealer_id and d.status="1"','left');
                $this->db->join('crm_team_type t', 't.id=u.team_id and t.status="1"','left');
                $this->db->join('crm_role r', 'r.id=u.role_id and r.status="1"','left');
                $pass =md5($password);
                $whereadmin = "(d.user_name= '".$username."' AND d.password= '".$pass."')";
                $whereuser = "(u.email= '".$username."' AND u.password='".$pass."')";
                $this->db->where($whereadmin);
                $this->db->or_where($whereuser);
                $this->db->group_by(array('u.id'));
                $query = $this->db->get();
                //echo $this->db->last_query();exit;

		//$query = $this->db->get_where('crm_user', array('email' => $username,'password' => md5($password)));

		return $query->row_array();
               
	}
        
        public function chkUserByMobile($mobile)
        {
                $this->db->select('u.id,u.name,u.email,u.password,u.mobile,u.dob,u.doj,u.role_id,u.team_id,u.dealer_id,u.user_code,u.status,u.is_admin,u.created_date,u.updated_date,t.team_name,r.role_name,d.is_classified,d.mobile as dealer_mobile,d.organization,d.address,d.default_showroom_id,d.email as dealer_email');
                $this->db->from('crm_user u');
                $this->db->join('crm_admin_dealers d', 'd.dealer_id=u.dealer_id and d.status="1"','left');
                $this->db->join('crm_team_type t', 't.id=u.team_id and t.status="1"','left');
                $this->db->join('crm_role r', 'r.id=u.role_id and r.status="1"','left');
                //$this->db->where('d.mobile', $mobile);
                $this->db->where('u.mobile', $mobile);
                
                $this->db->group_by(array('u.id'));
                $query = $this->db->get();
              return $query->row_array();
        }
        
        public function ChkUserOtpId($mobile)
            {
                $query = $this->db->get_where('crm_otp_login', array('mobile' => $mobile,'status'=>'1'));
                return $query->row_array();
            
            }
            
            
        public function saveOtpData($userdata,$code,$userOtpId)
        {
            $saveData=[
                        'user_id'       => $userdata['id'],
                        'mobile'        => $userdata['mobile'],
                        'otp'           => $code,
                        'status'        => '1',
                        'expiry_time'   => date('Y-m-d H:i:s',strtotime('+10 minutes',strtotime($this->dateTime))),
                        'created_date'  => !($userOtpId['id'])?$this->dateTime:$userOtpId['created_date'],
                        'updated_date'  =>  $this->dateTime,                    
                        ];
                 if (!$userOtpId) {
                        $userOtpId =  $this->db->insert('crm_otp_login',$saveData);
                    } else {
                                   $this->db->where('id', $userOtpId['id']);
                        $userOtpId=$this->db->update('crm_otp_login',$saveData);
                    }
                return $userOtpId;    
        }
       public function otpVerify($mobile,$otp)
       {
        $query = $this->db->get_where('crm_otp_login', array('mobile' => $mobile,'otp'=>$otp,'status'=>'1'));
                return $query->row_array();
       }

       public function getCrmSystemByUrl($keyword)
       {
            $this->db->select('*');
            $this->db->from('crm_admin_dealers as m');
            $this->db->where("m.domain LIKE '%$keyword%'");
            $query = $this->db->get();
            $res=$query->result_array();
            echo "<pre>";
            print_r($res);
            exit;
            return $res ; 

       }  
}

?>
