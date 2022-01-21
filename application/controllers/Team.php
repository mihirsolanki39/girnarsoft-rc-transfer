<?php
class Team extends MY_Controller
{
    public function __construct()
        {
                parent::__construct();
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->load->helper('url_helper');
                $this->load->model('Teammodel');
                 if(!$this->session->userdata['userinfo']['id']){
             return redirect('login');
            }

                
        }
    public function team()
        {
            $this->load->library('pagination');
            $count   = $this->Teammodel->teamListingCount();
            $returns = $this->paginationCompress("team/", $count, 5);
            $data['teams'] = $this->Teammodel->getTeam($id=FALSE,$returns["page"], $returns["segment"]);
            $this->loadViews('team/team',$data);
                
        }    
     public function view($id = NULL)
        {
              //  $data['team_item'] = $this->Teammodel->getTeam($id);
        }
    public function edit(){
        $data = array();
                    
        if(!empty($this->input->post('teamTypeId'))){
        $ids=$this->input->post();
        if(is_array($ids['teamId']) && $ids['teamTypeId']){
            foreach ($ids['teamId'] as $key=>$val):
                if($val==$ids['teamTypeId']){
                   $id=$ids['teamTypeId'] ;
                }
            endforeach;
        }
        }
        else {
            $id=$this->input->post('id');
        }
        $postData = $this->Teammodel->getTeam($id);       
        //if update request is submitted
        if($this->input->post('teamSubmit')){
        $this->load->helper('form');
        $this->load->library('form_validation');
        //$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('team_name','Team name' ,'required');
        $this->form_validation->set_message('team_name', 'Team Name field is required.');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        
        //print_r($this->input->post());exit;
        if ($this->form_validation->run() === true)
        {
            //prepare cms page data
            $postData = array(
                'team_name' => $this->input->post('team_name'),
                'status' => $this->input->post('status'),
                'updated_date' => date('Y-m-d h:i:s')
            );
            $check= $this->checkDuplicateTeam($postData['team_name']);
             if(empty($check)){
            $update=$this->Teammodel->update($id,$postData);
            if($update){
                    //$this->session->set_flashdata('update', 'Team has been updated successfully.');
                    redirect('/team');
                }else{
                    $this->session->set_flashdata('error','Some problems occurred, please try again');
                    //redirect('/team/edit');
                }
            }
             else
                {
                    $this->session->set_flashdata('Team name already exists.');
                }
            
        }
        }
        $data['data'] = $postData;
        $data['title'] = 'Update Team';
        $data['action'] = 'edit';
                
        $this->loadViews('team/teamAddEdit',$data);
        

    }
    
    public function add(){
        $data = array();
        $postData = array();
        //if add request is submitted
        if($this->input->post('teamSubmit')){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('team_name', 'Name', 'required');
        //prepare post data
            $postData = array(
                'team_name' => $this->input->post('team_name'),
                'status' => $this->input->post('status'),
                'created_date' => date('Y-m-d h:i:s')
            );
        if ($this->form_validation->run() === true)
        {

               $check= $this->checkDuplicateTeam($postData['team_name']);
               //echo "<pre>";
              // print_r($check);
               if(empty($check)){
                 $insert = $this->Teammodel->insert($postData);
                    if($insert){
                       // $this->session->set_flashdata('add', 'Team has been added successfully.');
                        redirect('/team');
                    }
                    else{
                        $this->session->set_flashdata('Some problems occurred, please try again');
                        //redirect('/team/edit');
                    }
                }
                else
                {
                   $data['error'] = 'Team name already exists.';
                    $this->session->set_flashdata('Team name already exists.');
                }
            
        }
        }
        
        $data['data'] = $postData;
        $data['title'] = 'Create Team';
        $data['action'] = 'Add';
        
        //load the add page view
        $this->loadViews('team/teamAddEdit',$data);
        
    }
    /*
     * Delete team data
     */
    public function delete($id){
        //check whether team id is not empty
        if($id){
            //delete team
            $delete = $this->Teammodel->delete($id);
            
            if($delete){
                $this->session->set_userdata('success_msg', 'Team has been removed successfully.');
            }else{
                $this->session->set_userdata('error_msg', 'Some problems occurred, please try again.');
            }
        }

        redirect('/team');
    }
    
    public function activeInactiveTeam() {
        $error = array();
        $postData = $this->input->post();
        $postedData =array(
            'status' => $postData['status'],
            'updated_date' => date('Y-m-d h:i:s')
        );
        $id=$this->input->post('id');
        if (!empty($postData)) {
            $teamData = $this->Teammodel->updateTeamStatus($postedData,$id);
            return $teamData;
        } else {
            $error[] = "Team Not Updated!";
        }
        return $error;
    }

    public function checkDuplicateTeam($team)
    {
        //$err = [];
        //$postData = $this->input->post();
       // $team = $postData['team']; 
        $teamname = trim($team);
       return $exists = $this->Teammodel->getTeamNameByName($teamname);
        /*if(empty($exists))
        {
            $err['status']='1';
        }
        else
        {
            $err['status']='0';
        }
        echo json_encode($err); exit;*/
    }
    
}

