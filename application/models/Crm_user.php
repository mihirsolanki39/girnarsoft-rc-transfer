<?php

/**
 * model : Crm_outlets
 * User Class to control all dealer related operations.
 * @author : shashikant kumar
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Crm_user extends CI_Model
{

	public function __construct()
	{
	}

	/**
	 * This function is used to add new dealer to system
	 * @return number $insert_id : This is last inserted id
	 */
	function addOwner($userInfo, $updateId = '')
	{
		if (empty($updateId)) {
			$this->db->trans_start();
			$this->db->insert('crm_user', $userInfo);

			$insert_id = $this->db->insert_id();

			$this->db->trans_complete();

			return $insert_id;
		} else {
			$this->db->where('dealer_id', $updateId);
			$this->db->update('crm_user', $userInfo);
			return $this->db->affected_rows();
		}
	}

	public function getLoginUserDetails()
	{
		$this->load->model('Crm_dealers');
		$userId = DEALER_ID;
		if (isset($_SESSION['id'])) {
			$userId = $_SESSION['id'];
		}
		$this->db->select('u.address,u.default_showroom_id as showroom_id,u.dealer_id as id,u.email as email,u.organization,u.mobile');
		$this->db->from('crm_admin_dealers as u');
		$this->db->where('u.dealer_id', $userId);
		$query = $this->db->get();
		$result = $query->row_array();
		//echo $this->db->last_query(); exit;
		return $result;
	}


	public function getEmployee($type = "", $id = '', $role = '', $rolenotin = '')
	{
		if ($type == '') {
			$this->db->select('id,name,email,mobile');
			$this->db->from('crm_user');
			$this->db->where('status', '1');
			if ($id != '') {
				$this->db->where('id', $id);
			}
			$query = $this->db->get();
		} else if ($type == '1') {
			$this->db->select('DISTINCT(e.id),e.name,e.email');
			$this->db->from('crm_user as e');
			//$this->db->join('bank_employee_limit_mapping as bm','bm.emp_id=e.id','inner');
			//$this->db->join('crm_banks as b','b.bank_id=bm.bank_id','inner');
			$this->db->join('crm_role as cr', 'cr.id=e.role_id', 'inner');
			$this->db->join('crm_team_type as ct', 'ct.id=cr.team_id', 'inner');
			$this->db->where('e.status', '1');
			//$this->db->where('bm.status', '1');
			//$this->db->where('b.status', '1');
			$this->db->where('cr.status', '1');
			$this->db->where('ct.status', '1');
			$this->db->where('ct.team_name', 'Sales');
			//$this->db->where('e.id >=', '1');
			if ($id != '') {
				$this->db->where('id', $id);
			}
			$query = $this->db->get();
		} else if ($type == '2') {
			$this->db->select('DISTINCT(e.id),e.name,e.email');
			$this->db->from('crm_user as e');
			$this->db->join('crm_team_type as ct', 'ct.id=e.team_id', 'inner');
			if ($role != '') {
				$this->db->join('crm_role as cr', 'cr.id=e.role_id', 'inner');
				$this->db->where('cr.role_name', $role);
				$this->db->where('cr.status', '1');
			}
			$this->db->where('e.status', '1');
			$this->db->where('ct.status', '1');
			$this->db->where('ct.team_name', 'Loan');
			$this->db->where('e.id >=', '1');
			if ($id != '') {
				$this->db->where('id', $id);
			}
			$query = $this->db->get();
			//echo $this->db->last_query(); exit;
		} else if ($type == '3') {
			$this->db->select('DISTINCT(e.id),e.name,e.email');
			$this->db->from('crm_user as e');
			$this->db->join('crm_team_type as ct', 'ct.id=e.team_id', 'inner');
			if ($role != '') {
				$this->db->join('crm_role as cr', 'cr.id=e.role_id', 'inner');
				$this->db->where_in('cr.role_name', $role);
				$this->db->where('cr.status', '1');
			}
			$this->db->where('e.status', '1');
			$this->db->where('ct.status', '1');
			$this->db->where('ct.team_name', 'Insurance');

			$this->db->where('e.id >=', '1');
			if ($id != '') {
				$this->db->where('id', $id);
			}
			$query = $this->db->get();
			// echo $this->db->last_query(); 
		} else if ($type == '4') {
			$this->db->select('DISTINCT(e.id),e.name,e.email');
			$this->db->from('crm_user as e');
			$this->db->join('crm_team_type as ct', 'ct.id=e.team_id', 'inner');
			if ($role != '') {
				$this->db->join('crm_role as cr', 'cr.id=e.role_id', 'inner');
				$this->db->where('cr.role_name', $role);
				$this->db->where('cr.status', '1');
			}
			$this->db->where('e.status', '1');
			$this->db->where('ct.status', '1');
			$this->db->where('ct.team_name', 'Delivery');

			$this->db->where('e.id >=', '1');
			if ($id != '') {
				$this->db->where('id', $id);
			}
			$query = $this->db->get();
			//echo $this->db->last_query(); exit;
		} else if ($type == '5') {
			$this->db->select('DISTINCT(e.id),e.name,e.email,d.id as dealerId');
			$this->db->from('crm_user as e');
			$this->db->join('crm_dealers as d', 'd.user_id=e.id', 'left');
			$this->db->where('e.status', '1');
			$this->db->where('d.status', '1');
			$this->db->group_by('e.id');
			$query = $this->db->get();
		} else if ($type == '6') {
			$this->db->select('DISTINCT(e.id),e.name,e.email,d.id as dealerId');
			$this->db->from('crm_user as e');
			$this->db->join('crm_dealers as d', 'd.user_id=e.id', 'left');
			$this->db->join('crm_team_type as ct', 'ct.id=e.team_id', 'inner');
			$this->db->join('crm_role as cr', 'cr.id=e.role_id', 'inner');
			//$this->db->where('e.status', '1');
			$this->db->where('ct.team_name', 'Sales');
			$this->db->where_in('cr.role_name', $role);
			$this->db->group_by('e.id');
			$query = $this->db->get();
		} else if ($type == '7') {
			$this->db->select('DISTINCT(e.id),e.name,e.email');
			$this->db->from('crm_user as e');
			$this->db->join('crm_team_type as ct', 'ct.id=e.team_id', 'inner');
			if ($role != '') {
				$this->db->join('crm_role as cr', 'cr.id=e.role_id', 'inner');
				$this->db->where('cr.role_name', $role);
				$this->db->where('cr.status', '1');
			}
			if ($rolenotin != '') {
				$this->db->join('crm_role as cr', 'cr.id=e.role_id', 'inner');
				$this->db->where("cr.id not in (22)");
				$this->db->where('cr.status', '1');
			}
			$this->db->where('e.status', '1');
			$this->db->where('ct.status', '1');
			$this->db->where('ct.team_name', 'Loan');
			$this->db->where('e.id >=', '1');
			if ($id != '') {
				$this->db->where('id', $id);
			}
			$query = $this->db->get();
			//echo $this->db->last_query(); exit;
		} else if ($type == '8') {
			$this->db->select('DISTINCT(e.id),e.name,e.email');
			$this->db->from('crm_user as e');
			$this->db->join('crm_team_type as ct', 'ct.id=e.team_id', 'inner');
			if ($role != '') {
				$this->db->join('crm_role as cr', 'cr.id=e.role_id', 'inner');
				$this->db->where('cr.role_name', $role);
				$this->db->where('cr.status', '1');
			}
			if ($rolenotin != '') {
				$this->db->join('crm_role as cr', 'cr.id=e.role_id', 'inner');
				$this->db->where("cr.id not in (22)");
				$this->db->where('cr.status', '1');
			}
			$this->db->where('e.status', '1');
			$this->db->where('ct.status', '1');
			$this->db->where('ct.team_name', 'Used Car');
			$this->db->where('e.id >=', '1');
			if ($id != '') {
				$this->db->where('id', $id);
			}
			$query = $this->db->get();
			//echo $this->db->last_query(); exit;
		}
		$result = $query->result_array();
		//echo "<pre>";print_r($result);die;
		// echo $this->db->last_query(); //exit;
		return  $result;
	}

	public function getExecutive($type = '')
	{
		$this->db->select('id,name,email');
		$this->db->from('crm_user');
		$this->db->where('status', '1');
		$this->db->where('role_id', '21');
		$this->db->where('is_admin', '0');
		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query(); exit;
		return  $result;
	}
	public function getEmployeeByRoleAndTeam($team_id = '', $role_id = '', $user_name = '')
	{
		$this->db->select('id,name,email');
		$this->db->from('crm_user');
		$this->db->where('status', '1');
		$this->db->where('is_admin', '0');
		if (!empty($team_id)) {
			$this->db->where('team_id', $team_id);
		}
		if (!empty($role_id)) {
			$this->db->where('role_id', $role_id);
		}
		if (!empty($user_name)) {
			$this->db->where('name like', '%' . $user_name . '%');
		}
		$query = $this->db->get();
		$result = $query->result_array();
		// echo $this->db->last_query(); exit;
		return  $result;
	}


	public function getEmployeeByTeam($team)
	{
		$this->db->select('e.id,e.name,e.email');
		$this->db->from('crm_user as e');
		$this->db->join('crm_team_type as ct', 'ct.id=e.team_id', 'inner');
		$this->db->where('e.status', '1');
		$this->db->where('ct.status', '1');
		$this->db->where('e.is_admin', '0');
		$this->db->where('ct.team_name', $team);

		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query(); exit;
		return  $result;
	}

	public function getHeaderByRole($role, $flag = 0)
	{
		//$role ='3';
		$this->db->select('*,h.id as headerid');
		$this->db->from('crm_header_role as h');
		if ($role > '0') {
			$this->db->join('crm_header_role_mapping as hm', 'hm.menu_id=h.id', 'inner');
			$this->db->join('crm_role as r', 'r.id=hm.role_id', 'left');
			//$this->db->where('r.status','1');
			$this->db->where('hm.status', '1');
			$this->db->where('hm.role_id', $role);
		}
		$this->db->where('h.statue', '1');
		if ($flag == 0) {
			$this->db->where('h.parent_id', '0');
		} else if ($flag > 0) {
			$this->db->where('h.parent_id', $flag);
		}
		$this->db->order_by('h.order_no asc');
		$query = $this->db->get();
		$result = $query->result_array();
		//   echo $this->db->last_query(); die;
		return  $result;
	}
	public function getRightsByRole($role, $flag = 0)
	{
		// echo $flag;
		$this->db->select(' *,r.id as moduleid');
		$this->db->from('crm_right_management as r');
		if ($role > '0') {
			$this->db->join('crm_right_management_mapping as rm', 'rm.module_id=r.id', 'inner');
			$this->db->join('crm_role as cr', 'cr.id=rm.role_id', 'left');
			$this->db->join('crm_team_type as t', 't.id=rm.team_id', 'left');
			$this->db->where('cr.status', '1');
			$this->db->where('rm.role_id', $role);
		}
		if (!empty($flag)) {
			$this->db->where('r.module', trim($flag));
		}
		$this->db->where('r.status', '1');
		$query = $this->db->get();
		$result = $query->result_array();
		// echo $this->db->last_query();  exit;
		return  $result;
	}

	public function getEmployeeByRole($emp_id = '', $teamname = '', $rolename = '')
	{
		$this->db->select('DISTINCT(e.id),e.name,e.email');
		$this->db->from('crm_user as e');
		$this->db->join('crm_team_type as ct', 'ct.id=e.team_id', 'inner');
		if ($rolename != '') {
			$this->db->join('crm_role as cr', 'cr.id=e.role_id', 'inner');
			$this->db->where('cr.role_name', $rolename);
			$this->db->where('cr.status', '1');
		}
		$this->db->where('e.status', '1');
		$this->db->where('ct.status', '1');
		if (!empty($teamname)) {
			$this->db->where('ct.team_name', $teamname);
		}
		$this->db->where('e.id >', '1');
		if (!empty($emp_id)) {
			$this->db->where('id', $emp_id);
		}
		$query = $this->db->get();
		// echo $this->db->last_query(); exit;
		$result = $query->result_array();
		return  $result;
	}
	public function getEmployeeByName($name, $role = '')
	{
		$this->db->select('DISTINCT(e.id),e.name,e.email');
		$this->db->from('crm_user as e');
		$this->db->join('crm_team_type as ct', 'ct.id=e.team_id', 'inner');
		if ($name != '') {
			$this->db->where('e.name like', '%' . $name . '%');
		}
		if ($role != '') {
			$this->db->join('crm_role as cr', 'cr.id=e.role_id', 'inner');
			$this->db->where_in('cr.role_name', $role);
			$this->db->where('cr.status', '1');
		}
		$this->db->where('e.status', '1');
		$this->db->where('ct.status', '1');
		$this->db->where('ct.team_name', 'Insurance');
		$this->db->where('e.id >=', '1');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$result = $query->result_array();
		return  $result;
	}

	public function getEmpByDealer($id)
	{
		$this->db->select('ct.id');
		$this->db->from('crm_dealers as d');
		$this->db->join('crm_user as ct', 'ct.id=d.user_id', 'inner');
		$this->db->where('ct.status', '1');
		$this->db->where('d.id', $id);

		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query(); exit;
		return  $result;
	}

	public function getAdminDealerDetails($dealer_id)
	{
		$this->db->select('d.*');
		$this->db->from('crm_admin_dealers as d');
		$this->db->join('crm_user as ct', 'ct.dealer_id=d.dealer_id', 'inner');
		$this->db->where('ct.status', '1');
		$this->db->where('d.dealer_id', $dealer_id);

		$query = $this->db->get();
		$result = $query->result_array();
		//echo $this->db->last_query(); exit;
		return  $result;
	}
}
