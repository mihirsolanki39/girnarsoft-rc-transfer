<?php
require APPPATH . '/libraries/BaseController.php';
class Role extends BaseController
{
    public function __construct()
        {
                parent::__construct();
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->load->library('pagination');
                $this->load->helper('url_helper');
                $this->load->model('Rolemodel');
                $this->load->model('teamlist');
                 if(!$this->session->userdata['userinfo']['id']){
             return redirect('login');
            }

        }
    /**
     * This function is used to load the add new form
     */
    function addNew($roleId=null)
    {
            $this->load->model('rolemodel');
            $data['teamList']  =  $this->teamlist->getTeamlist();
            $data['pageTitle'] = 'Add New Role';
            $this->loadViews("role/roleAddEdit",$data);
    }
    
    function addNewRole($updateId='')
    {
        $submit=$this->input->post('submit');
        if($submit=='Update'){
         $id=base64_decode($updateId);   
        }else{
        $id=base64_decode($updateId);
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('teamName','Team Name','trim|required');
        $this->form_validation->set_rules('role_name','Role Name','trim|required');
        if($this->form_validation->run() == FALSE && !empty($id)&& empty($submit))
            {
                $this->editOld($id);
             
            }
            else if($this->form_validation->run() == FALSE && empty($id)){
                $this->addNew();
            }
            else 
            {
                $roleName = ucwords(strtolower($this->security->xss_clean($this->input->post('role_name'))));
                $teamId              = $this->input->post('teamName');
                $status              = $this->input->post('status');
                $roleInfo = array(
                    'role_name'     =>  $roleName,
                    'team_id'       =>  $teamId,
                    'status'        =>  $status,
                    'created_date'  => date('Y-m-d H:i:s'),
                    'created_by'    => DEALER_ID
                    );
                
                if($roleInfo){
                    if($id){
                      $roleInfo['updated_date'] =  date('Y-m-d H:i:s');
                    }
                $this->load->model('rolemodel');
                $basicResult = $this->rolemodel->addNewRole($roleInfo,$id);
                }
                if($basicResult > 0)
                { 
                    if(empty($id))
                    {
                       $this->session->set_flashdata('add', 'New Role created successfully');
                    }
                    else
                    {
                    $this->session->set_flashdata('update', 'Role updated successfully');
                    }
                }
                else
                {
                    $this->session->set_flashdata('error', 'Role creation failed');
                }
                if(!empty($updateId)){
                redirect('addRole/'.$updateId);
                }else{
                    redirect('addRole');
                }
            }
    }
    
    /**
     * This function is used load role edit information
     * @param number $roleId : Optional : This is dealer id
     */
    function editOld($roleId = NULL)
    {
        if($roleId == null)
            {
                redirect('role');
            }
            $data['roleInfo'] = $this->Rolemodel->getRole($roleId);
            $data['teamList']  =  $this->teamlist->getTeamlist();
            $this->global['pageTitle'] = 'Edit Role';
            $this->loadViews("role/roleAddEdit", $this->global, $data, NULL);
    }
    
    public function index()
        {
            $data['roles'] = $this->Rolemodel->getRole($id=FALSE);
            $this->loadViews('role/role',$data);
                            
        }   
     public function view($id = NULL)
        {
              //  $data['roleItem'] = $this->Rolemodel->geRole($id);
        }
    
    /*
     * Delete team data
     */
    public function delete($id){
        //check whether team id is not empty
        if($id){
            //delete team
            $delete = $this->Rolemodel->delete($id);
            
            if($delete){
                $this->session->set_flashdata('success_msg', 'Team has been removed successfully.');
            }else{
                $this->session->set_flashdata('error_msg', 'Some problems occurred, please try again.');
            }
        }

        redirect('/role');
    }
    
    public function activeInactiveRole() {
        $error = array();
        $postData = $this->input->post();
        $postedData =array(
            'status' => $postData['status'],
            'updated_date' => date('Y-m-d h:i:s')
        );
        $id=$this->input->post('id');
        if (!empty($postData)) {
            $roleData = $this->Rolemodel->updateRoleStatus($postedData,$id);
            return $roleData;
        } else {
            $error[] = "Role Not Updated!";
        }
        return $error;
    }
    
}

