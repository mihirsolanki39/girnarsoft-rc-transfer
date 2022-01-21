<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class : Docmanager (DeliveryOrderController)
 * User Class to control all doOrder related operations.
 * @author : apoorva
 */
class Docmanager extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Crm_user');
        $this->load->model('Loan_customer_info');
        $this->load->model('Loan_customer_case');
        $this->load->model('Crm_adv_booking');
        $this->load->library('form_validation');
        $this->load->model('Leadmodel');
        $this->load->model('Crm_dealers');
        $this->load->model('Make_model');
        $this->load->model('UserDashboard');
        $this->load->model('Loan_customer_reference_info');
        $this->load->model('City');
        $this->load->model('state_list');
        $this->load->model('Crm_banks');
        $this->load->model('Loan_post_delivery_info');
        $this->load->model('Crm_insurance_company');
        $this->load->model('Loan_payment_info');
        $this->load->model('Crm_applicant_type');
        $this->load->model('Crm_upload_docs_list');
        //$this->load->library('Pdf');
        if (!$this->session->userdata['userinfo']['id'])
        {
            return redirect('login');
        }
    }

    public function docManager()
    {
        $data['pageTitle']      = 'Document Manager';
        $data['pageType']       = 'docmanager';
        $this->loadViews("docmanager/doc_manager", $data);
    }

    public function getdocpage()
    {
        $pageid = $this->input->post('pageId');
        $data = [];
        switch ($pageid) 
        {
            case "7":               
                $data['uploadDocList'] = $this->getDocInfo(3,1,1);
                echo $datas=$this->load->view('docmanager/insurance_doc_manager',$data,true); exit;
                break;
            case "8":               
                $data['uploadDocList'] = $this->getDocInfo(3,2,1);
                echo $datas=$this->load->view('docmanager/insurance_doc_manager',$data,true); exit;
                break;
            case "9":               
                $data['uploadDocList'] = $this->getDocInfo(3,3,1);
                echo $datas=$this->load->view('docmanager/insurance_doc_manager',$data,true); exit;
                break;
            case "10":               
                $data['uploadDocList'] = $this->getDocInfo(3,4,1);
                echo $datas=$this->load->view('docmanager/insurance_doc_manager',$data,true); exit;
                break;
            case "11":               
                $data['uploadDocList'] = $this->getDocInfo(3,5,1);
                echo $datas=$this->load->view('docmanager/insurance_doc_manager',$data,true); exit;
                break;
            case "3":
                $data['uploadDocList'] = $this->getDocInfo(1);
                echo $datas=$this->load->view('docmanager/loan_doc_manager',$data,true); exit;
                break;
            case "4":
                $data['uploadDocList'] = $this->getDocInfo(1);
                echo $datas=$this->load->view('docmanager/loan_doc_manager',$data,true); exit;
                break;
            case "5":
                $data['uploadDocList'] = $this->getDocInfo($pageid);
                echo $datas=$this->load->view('docmanager/stock_doc_manager',$data,true); exit;
                break;
            case "6":
                $data['uploadDocList'] = $this->getDocInfo(4);
                echo $datas=$this->load->view('docmanager/rc_doc_manager',$data,true); exit;
                break;
        }

    }

    public function getDocInfo($doc_type='',$ins_category='',$flag='')
    {
        if(empty($doc_type))
        {
            $doc_type = $this->input->post('doctype');
        }
        if(empty($ins_category))
        {
             $ins_category = $this->input->post('instype');        }
        if(empty($flag))
        {
            $flag =  $this->input->post('flag');
        }
      //  echo $doc_type; exit;
        $docList = $this->Crm_upload_docs_list->getDocList('',$doc_type,'','',$ins_category);
        //echo "<pre>";print_r($docList);die;
        $subcat = array();
        //$i = 0;
         foreach($docList as $key => $val)
        {   
            $subcat = array();
            $uploadDocList[$val['parent_id']]['name']= $val['parent_name'];
            $uploadDocList[$val['parent_id']]['is_require']= $val['is_require'];
            $uploadDocList[$val['parent_id']]['list_id']= $val['id'];
            $uploadDocList[$val['parent_id']]['substatus']= $val['liststatus'];
            $uploadDocList[$val['parent_id']]['subisrequire']= $val['listreq'];
            $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'],$doc_type,'','',$ins_category);
            //$i = 0;
            foreach ($sublist as $skey => $sval)
            {
                   
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['name'] = $sval['name'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['sub_category_id'] = $sval['sub_category_id'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = $sval['listreq'];
                   $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['status'] = $sval['liststatus'];
                   $subcat[$i] = $sval['liststatus'];
                   
            //$i++;   
            } 
            
            
        
        }
        
        if(!empty($flag))
        {

            $data['uploadDocList'] = $uploadDocList;
            $data['doctype'] = $doc_type;
            $data['ins_type'] = $ins_category;
            echo $datas=$this->load->view('docmanager/doc_tab_pages',$data,true); exit;
        }
        else
        {
            return $uploadDocList;  
        }
    }

    public function saveDocsInfo()
    {
        $formData = $this->input->post();
       
        $status = '1';
        $isRequired = '1';
        //echo "<pre>";print_r($formData);die;
        $docList = $this->Crm_upload_docs_list->getDocList('',$formData['doctype'],'','',$formData['ins_type']); 
        
        foreach($docList as $key => $doc){
            if(array_key_exists('onoff_'.$doc['parent_id'], $formData)){
                if(array_key_exists('bk_'.$doc['id'], $formData)){
                    $updatedsubcat = 'bk_'.$doc['id'];
                    $flag = $formData[$updatedsubcat];
                    if($flag == 1){
                       $status = '0';
                       $isRequired = '0';
                    }else if($flag == 2){
                       $status = '1';
                       $isRequired = '0';
                    }else if($flag == 3){
                        $status = '1';
                        $isRequired = '1';
                    }
                    //echo $doc['id']."\n".$status."\n".$isRequired;
                    $this->Crm_upload_docs_list->updateUploadDocListMapping($doc['parent_id'],$doc['id'],$status,$isRequired); 
                }
                   
            }else{
                $this->Crm_upload_docs_list->updateUploadDocListMapping($doc['parent_id']);   
            }
        }
        
       echo true;
        
    }
}