<?php
class Login extends MY_Controller
{
    private $options = [
        'source'   => 'dealerCentral',
        'priority' => 5,
        'NDNC'     => 1,
        'sender'   => 'iGAADI',
        'send_response' => 'Yes',
    ];

    function __construct()
    {
        parent::__construct();
        $this->load->model('Loginmodel');
        $this->load->model('Rolemodel');
        $this->load->helper('form');
    }

    public function index()
    {
        if (isset($this->session->userdata['userinfo']['id'])) {
            //return redirect('dashboardDetails');
            return redirect('dashboard');
        }
        return $this->load->view('login');
    }

    public function sign_in_login()
    {
        // echo "<pre>";print_r($this->input->post());exit;

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if ($this->input->post('form_type') == '1') { //for otp login
            $userInfo = $this->session->set_userdata('postdata', $this->input->post('form_type'));
            $this->form_validation->set_rules('mobile', 'mobile', array('required', 'trim', 'min_length[10]', 'max_length[10]', 'regex_match[/^[6-9][0-9]{9}$/]'));
            $this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
            $this->form_validation->set_message('max_length', '%s: the maximum of characters is %s');
            $this->form_validation->set_message('regex_match', 'mobile number starting with eg.[6-9]');
        } else {   //for email and password login
            $this->form_validation->set_rules('username', 'Username', array('required', 'trim'));
            $this->form_validation->set_rules('upass', 'Password', 'required');
        }
        //array('required','trim')
        //echo "login form submit here.";
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('form_type', $this->input->post('form_type'));
            $this->load->view('login');
        } else {
            if ($this->input->post('form_type') == '0') { //for email and password login
                $this->session->set_flashdata('form_type', $this->input->post('form_type'));
                $username = $this->input->post('username');
                $upass = $this->input->post('upass');
                $userdatas = array();
                $userdatas = $this->Loginmodel->validate_login($username, $upass);
                $userRoles  = $this->Loginmodel->getUserRole($userdatas['id']);
                foreach ($userRoles as $key => $roles) {
                    $userdatas['team_ids'][$key] = $roles['team_id'];
                    $userdatas['role_ids'][$key] = $roles['role_id'];
                }
                // echo '<pre>';
                // print_r($userdatas);
                // exit;

            } else { //for otp login
                $this->session->set_flashdata('form_type', '2');
                $this->session->set_flashdata('mobile', $this->input->post('mobile'));
                if ($this->input->post('sign_in_otp') == 'SIGN IN') { //sign via otp
                    $otp = $this->input->post('inp-1') . $this->input->post('inp-2') . $this->input->post('inp-3') . $this->input->post('inp-4');
                    $loginViaOtp = $this->loginViaOtp($this->input->post('mobile'), $otp);
                    if ($loginViaOtp['status'] == 'T') {
                        $userdatas = $loginViaOtp['userDatas'];
                    } else {
                        $this->session->set_flashdata('otp_failed', array('status' => 'T', 'msg' => 'OTP not Vaild..'));
                    }
                } else {
                    $otpFaildMsg = $this->sendOtp($this->input->post('mobile'));
                    //print_r($otpFaildMsg);exit;
                    $this->session->set_flashdata('otp_failed', $otpFaildMsg);
                }
            }
            if (!empty($userdatas)) {

                if ($userdatas['status'] == '0') {
                    $this->session->set_flashdata('login_failed', 'User Not Active.');
                    redirect('login');
                } else {
                    // echo "<pre>";print_r($userdatas);die;
                    if ($userdatas['id'] == '1') {
                        $userdatas['is_admin'] = '1';
                    }
                    if (strtolower($userdatas['team_name']) == 'insurance') {
                        $userdatas['role_type'] = $userdatas['role_name'];
                    } else {
                        $userdatas['role_type'] = '';
                    }

                    $userInfo = $this->session->set_userdata('userinfo', $userdatas);
                    // echo "user login sucessfully.";exit;
                    // echo "<pre>";
                    // print_r($this->session->userdata['userinfo']);
                    // exit;
                    if (trim($this->session->userdata['userinfo']['role_name']) == 'Prelogin') {
                        return redirect('loanListing');
                    } else {
                        //return redirect('dashboardDetails');
                        return redirect('dashboard');
                    }
                }
            } else {
                if ($this->input->post('form_type') == '0') {
                    $this->session->set_flashdata('login_failed', 'Invaild UserName and Password.');
                }
                redirect('login');
            }
        }
    }

    public function sendOtp($mobile)
    {
        $userData = $this->Loginmodel->chkUserByMobile($mobile);
        $mobileCheck = $this->checkMobileNumber($userData, $mobile);
        if ($mobileCheck) {
            return $mobileCheck;
            exit;
        }
        $ChkUserOtpId = $this->Loginmodel->ChkUserOtpId($mobile);

        $response = $this->sendUserOTP($mobile, $ChkUserOtpId, $userData);
        if ($response['status'] == 'T') {
            $result = [
                'status'  => 'T',
                'msg' => 'OTP send successfully...',
            ];
        } else {
            $result = [
                'status'  => 'F',
                'msg' => $response['msg'],
            ];
        }
        return $result;
        //return $response;
    }

    public function checkMobileNumber($userdata, $mobile)
    {
        //echo "<pre>".count($userdata,1);print_r($userdata);exit;
        $result = array();
        if (empty($mobile)) {
            $result = array('status' => 'F', 'msg' => 'Mobile number can not be empty', 'error' => 'Mobile number can not be empty');
        } else if (!empty($userdata) && $userdata['status'] == '0') {
            $result = array('status' => 'F', 'msg' => 'User Not Active', 'error' => 'User Not Active');
        } else if (empty($userdata)) {
            $result = array('status' => 'F', 'msg' => 'Mobile number is not registered with us', 'error' => 'Mobile number is not registered with us');
        }
        /*else if (!empty($userdata) && count($userdata) > 1) 
        {
            $result = array('status' => 'F', 'msg' => 'Mobile number mapped with multiple Users', 'error' => 'Mobile number mapped with multiple Users');
        }*/

        return $result;
    }

    private function _sendOTP($mobile, $code, $message)
    {
        $this->options['mobile'] = $mobile;
        if ($message == 'login') {
            $this->options['message'] = 'Use %s as one time password (OTP) to login to your User. Do not share this OTP with anyone for security reasons. Valid for 15 minutes';
        }
        $this->options['message'] = sprintf($this->options['message'], $code);

        $url    = SMS_URL;
        $ch     = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($this->options));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->options));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        //	echo "<pre>";
        //print_r($result);
        //exit;
        return $result;
    }


    public function sendUserOTP($mobile, $userOtpId = null, $userdata = '')
    {
        //echo "<pre>".$mobile;print_r($userOtpId);exit;
        //$this->options['sender']   ='GCLOUD';
        if (empty($mobile) || strlen($mobile) != '10') {
            return [
                'status' => 'F',
                'msg' => 'mobile number is not valid'
            ];
        }
        // $ChkUserOtp= $this->Loginmodel->chkUserByMobile($mobile);
        //echo "<pre>";print_r($userOtpId);exit;
        $code = substr(mt_rand(100000, 999999), -4);
        $message = 'login';
        $return = $this->_sendOTP($mobile, $code, $message);
        $this->Loginmodel->saveOtpData($userdata, $code, $userOtpId);
        if (empty($userdata)) {
            return [
                'status' => 'F',
                'msg' => 'message could not be sent to ' . trim($mobile)
            ];
        } else {
            return [
                'status' => 'T',
                'msg' => 'message successfully sent to ' . trim($mobile)
            ];
        }
    }

    public function ajaxOtp()
    {
        //print_r($this->input->post());
        $otpFaildMsg = $this->sendOtp($this->input->post('mobile'));
        //print_r($otpFaildMsg);
        echo  $_GET['callback'] . '(' . json_encode($otpFaildMsg) . ')';
        exit;
    }


    public function loginViaOtp($mobile, $otp)
    {
        $otpVerify = $this->Loginmodel->otpVerify($mobile, $otp);
        if (!empty($otpVerify)) {
            $userData = $this->Loginmodel->chkUserByMobile($mobile);
            return [
                'status' => 'T',
                'msg' => 'OTP Verified',
                'userDatas' => $userData
            ];
        } else {
            return [
                'status' => 'F',
                'msg' => 'OTP Not Verified',
                'userDatas' => ''
            ];
        }
    }
}
