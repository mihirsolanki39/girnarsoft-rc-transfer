<?php

class Admin extends MY_Controller
{
	public function index()
	{
            
            $this->load->view('dashboard');
	}

	public function dashboard()
	{
            //$this->load->view('dashboard');
            $this->global['pageTitle'] = 'Dashboard';
            $this->loadViews("dashboard", $this->global, NULL, NULL);
	}

	 public function logout()
            {
                $this->session->sess_destroy();
                return redirect('login');
            }
        public function __construct()
            {
                    parent::__construct();
                    
                    if(!$this->session->userdata['userinfo']['id']){
                            return redirect('login');
                    }

            }
}