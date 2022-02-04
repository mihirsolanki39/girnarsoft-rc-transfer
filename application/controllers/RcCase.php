<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class : RC (RcController)
 * User Class to control all RC related operations.
 * @author : rakesh kumar
 */
class RcCase extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Crm_user');
        $this->load->model('Loan_customer_info');
        $this->load->model('Loan_customer_case');
        $this->load->library('form_validation');
        $this->load->model('Leadmodel');
        $this->load->model('Crm_dealers');
        $this->load->model('Make_model');
        $this->load->model('UserDashboard');
        $this->load->model('Loan_customer_reference_info');
        $this->load->model('City');
        $this->load->model('state_list');
        $this->load->model('Crm_rc');
        $this->load->model('Crm_banks');
        $this->load->model('Crm_upload_docs_list');
        if (!$this->session->userdata['userinfo']['id']) {
            return redirect('login');
        }
    }

    public function rcListing($type = '')
    {   
        $data = [];
        $data['pageTitle']        = 'RC Listing';
        if ($type == 3  || $type == 4) {
            $data['type']  = "";
            $data['source'] = $type;
        } else {
            $data['type']        = $type;
            $data['source']        = 3;
        }
        // echo "<pre>";print_r($data);die;
        $this->loadViews("RcCase/rcTab", $data);
    }



    public function ajax_getrc($type = null)
    {
        $data = [];
        $dealerId = DEALER_ID;
        $page                  =   1;
        $limit                 =   PAGE_LIMIT_RENEW_CASE;
        $datapost = $this->input->post();
        $data['rcId'] = (!empty($datapost['rc_id'])) ? $datapost['rc_id'] : '';
        $page                   =  trim($this->input->post('page'));
        $tab =  trim($this->input->post('source'));
        $tab = !empty($tab) ? $tab : "3";
        $data['rtoList']   =  $this->Crm_user->getEmployeeByTeam('RTO');
        $data['dealerlist'] = $this->Crm_dealers->getDealers('', '0,1,2', '', 1);
        //  echo  $data['rcId'];die;
        if ($tab == 3) {
            $datapost['rcdashId'] = $data['rcId'];
            $getLeads = $this->Crm_rc->getRcList($datapost, $dealerId, '', $page, $limit);
            $getLeadsCount = $this->Crm_rc->getRcListCount($datapost, $dealerId, '1');
            $datapost['type'] = '';
            $data['query'] = $getLeads;
            $data['limit'] = (!empty($limit)) ? $limit : 0;
            $data['page'] = (!empty($page)) ? $page : 1;
            $data['total_count'] = count($getLeadsCount['leads']);
            if ($type == 3) {
                echo $datas = $this->load->view('RcCase/ajax_getrc', $data, true);
                exit;
            } else {
                echo $datas = $this->load->view('RcCase/rcListing', $data, true);
                exit;
            }
        } else if ($tab == 4) {
            $params['is_count'] = 0;
            $params['pages'] = (!empty($page)) ? $page : 1;
            $params['searchby'] = trim($this->input->post('searchby'));
            $params['agentrto'] = trim($this->input->post('agentrto'));
            $params['daterange_to'] = trim($this->input->post('daterange_to'));
            $params['daterange_from'] = trim($this->input->post('daterange_from'));
            $params['keyword'] = trim($this->input->post('keyword'));

            $rcPayment   =  $this->Crm_rc->getRCPaymentList($params);
            $params['is_count'] = 1;
            $rcPaymentCount  =  $this->Crm_rc->getRCPaymentList($params);
            $data['page'] = (!empty($page)) ? $page : 1;
            $data['limit'] = (!empty($limit)) ? $limit : 0;
            $data['rcPayment'] = $rcPayment;
            $data['total_count'] = $rcPaymentCount;
            if ($type == 3) {
                echo $datas = $this->load->view('RcCase/ajax_rcPayment', $data, true);
                exit;
            } else
                echo $datas = $this->load->view('RcCase/rcPayment', $data, true);
            exit;
        }
    }

    public function get_history()
    {
        $rc_id = $this->input->post('rc_id');
        $this->load->helpers('history_helper');
        $usertype = '';
        if ($rc_id) {
            $historyData = $this->Crm_rc->getRchistory($rc_id, $total = '');
            if ($historyData) {
                echo renderHistoryHTMLRCFinal($historyData);
                exit;
            } else {
                echo '<div class="col-sm-12" style="text-align:center">No history available</div>';
                exit;
            }
        } else {
            echo 'Sorry request not valid';
            exit;
        }
    }


    public function uploadRcDocs($rc_id)
    {
        $data = [];
        $editId      = !empty($rc_id) ? explode('_', base64_decode($rc_id)) : '';
        $rcId        = !empty($editId) ? end($editId) : '';
        $getRcDetail = $this->Crm_rc->getRcFullCarDetail($rcId);
        $data['getRcDetail'] = $getRcDetail;
        $data['rc_id'] = $getRcDetail['rcid'];
        $data['rcId'] = $getRcDetail['rcid'];
        $data['customer_id'] = $getRcDetail['customer_id'];
        $data['rolemgmt'] = $this->UserMgmtRole();
        $bnkId = '';
        $uploadDocList = [];
        $data['pageTitle']      = 'RC Upload Documents';
        $data['pageType']       = 'rcdetail';
        $this->loadViews("RcCase/upload_rc_doc_frame", $data);
    }
    
    public function logindoc()
    {
        $data = [];
        $imgListArr = [];
        $tagIds = '';
        $loanCaseId = '';
        $csId = '';
        $rcid = $this->input->post('rc_id');
        $getRcDetail = $this->Crm_rc->getRcFullCarDetail($rcid);
        $data['getRcDetail'] = $getRcDetail;
        $data['rc_id'] = $getRcDetail['rcid'];
        $data['rcId'] = $getRcDetail['rcid'];
        $data['customer_id'] = $getRcDetail['customer_id'];
        $data['rolemgmt'] = $this->UserMgmtRole();
        $flag = 1;
        //$csId = $data['rc_id'];
        if (!empty($getRcDetail['loan_ref_id'])) {
            $loanCaseId = $this->Crm_rc->getLoanDetailByRefId($getRcDetail['loan_ref_id']);
            $csId = $loanCaseId['case_id'];
            $data['rc_id'] = $loanCaseId['case_id'];
            $flag = '';
        }

        $docList = $this->Crm_upload_docs_list->getDocList('', '4');
        foreach ($docList as $key => $val) {
            $uploadDocList[$val['parent_id']]['name'] = $val['parent_name'];
            $uploadDocList[$val['parent_id']]['is_require'] = $val['is_require'];
            //echo $data['CustomerInfo']['loan_for'].'-'.$val['id'];
            $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'], '4');
            foreach ($sublist as $skey => $sval) {
                $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['name'] = $sval['name'];
                $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['sub_category_id'] = $sval['sub_category_id'];
                $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = $sval['is_require'];
            }
        }

        $data['uploadDocList'] = (!empty($uploadDocList)) ? $uploadDocList : '';
        $tagIdd = rtrim($tagIds, ',');

        $data['pendencyDoc'] = $this->Crm_upload_docs_list->getPendencyDetail($data['rcId'], 4);
        $imgListUpdated = $this->Crm_upload_docs_list->getImageList($data['customer_id'], '', '', '', '4', $data['rcId'], $flag);
        if (!empty($imgListUpdated)) {
            $i = 0;
            foreach ($imgListUpdated as $imgK => $imgV) {
                $name = '';
                $bank_name = '';
                $imgListArr[$i]['id']           =   $imgV['id'];
                $imgListArr[$i]['doc_name']     =   $imgV['doc_name'];
                $imgListArr[$i]['doc_url']      =   (($imgV['sent_to_aws'] == '1') ? AWS_PATH : UPLOAD_IMAGE_URL) . $imgV['doc_url'];
                $imgListArr[$i]['doc_type']     =   $imgV['doc_type'];
                $imgListArr[$i]['customer_id']  =   $imgV['customer_id'];
                $imgListArr[$i]['case_id']      =   $imgV['case_id'];
                $imgListArr[$i]['status']       =   $imgV['status'];
                $imgListArr[$i]['created_on']   =   $imgV['created_on'];
                $imgListArr[$i]['updated_on']   =   $imgV['updated_on'];
                $imgListArr[$i]['tag_id']       =   $imgV['parent_tag_id'];
                $imgListArr[$i]['sub_id']       =   $imgV['sub_id'];
                $imgListArr[$i]['image_id']     =   $imgV['image_id'];
                $imgListArr[$i]['imgID']        =   $imgV['imgID'];
                $imgListArr[$i]['bank_id']      =   $imgV['bank_id'];
                $imgListArr[$i]['name']         =   $imgV['name'];
                $imgListArr[$i]['parent_id']    =   $imgV['parent_id'];
                $imgListArr[$i]['err']          =   $imgV['err'];
                $i++;
            }
        }
        $data['imageList'] =  $imgListArr;
        echo $datas = $this->load->view('RcCase/upload_rc_docs', $data, true);
        exit;
        //  $this->loadViews('RcCase/upload_rc_docs',$data);

    }

    public function uploadLoginDocs()
    {   
        // echo '<pre>';
        // print_r($_FILES['file']['name']);
        // exit;

        // echo FCPATH.'upload_rc_doc/'; exit;
        // echo UPLOAD_IMAGE_PATH_LOCAL.'upload_rc_doc/'; exit;
        // echo base_url() . 'upload_rc_doc/';
        // exit;

        $arr = $this->uri->segment(3);        

        $ar  = explode('-', $arr);
        $data = [];
        $file_name_key              = key($_FILES);
        $name = $_FILES['name'];
        $config['upload_path']      = 'upload_rc_doc/';
        $config['allowed_types']    = ['gif', 'png', 'jpg', 'jpeg', 'pdf', 'tif'];
        $config['max_size']         = '8000';
        $config['max_width']        = '7000';
        $config['max_height']       = '7000';        
        $config['encrypt_name']     = True;

        // echo '<pre>';
        // print_r($_FILES);
        // exit;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($file_name_key)) {
            // echo $this->response = $this->upload->display_errors();
            // exit;
            $error  = array('Invalid Request!');
            echo $result = array('error' => $error, 'status' => 400);
            exit;
        } else {
            // echo '1231';
            // exit;
            $datas = $this->upload->data();
            $data['doc_name'] = $datas['file_name'];
            $data['doc_url'] = 'upload_rc_doc/' . $datas['file_name'];
            $data['customer_id'] = $ar['1'];
            $data['case_id'] = $ar['0'];
            $data['doc_type'] = '4';
            if (!empty($ar['2'])) {
                $data['doc_type'] = '5';
            }          

            $result = $this->Crm_upload_docs_list->insertLoginDocs($data);
            echo trim($result);
            exit;
            
        }
    }

    public function showImagesToTag()
    {
        $customer_id = $this->input->post('customer_id');
        $case_id = $this->input->post('case_id');
        $doctype = $this->input->post('doctype');
        // $doctype= $this->input->post('doctype');
        $data = [];
        $i = 0;
        $doc = 4;
        if (!empty($doctype)) {
            $doc = 5;
        }

        $imageList = $this->Crm_upload_docs_list->getImageList($customer_id, '', '', '', $doc, $case_id);
        $str = '[';
        foreach ($imageList as $key => $val) {
            $image_type = end(explode('.', $val['doc_name']));
            $data[$i]['id'] = $val['id'];
            $data[$i]['small'] = (($val['sent_to_aws'] == '1') ? AWS_PATH : UPLOAD_IMAGE_URL) . $val['doc_url'];
            $data[$i]['big'] = (($val['sent_to_aws'] == '1') ? AWS_PATH : UPLOAD_IMAGE_URL) . $val['doc_url'];
            $data[$i]['image_type'] = $image_type;
            $data[$i]['tag_id'] = $val['tag_id'];
            $i++;
        }
        echo json_encode($data);
        exit;
    }

    public function getTagName()
    {
        //$arr        = ['8','9','10','11','12','13'];
        $tagid      = $this->input->post('tagid');
        $caseid     = $this->input->post('case_id');
        $imag_id    = $this->input->post('imag_id');
        $doctype = $this->input->post('doctype');
        if (empty($doctype)) {
            $doctype    = '4';
        }
        $errImg = "";
        if (!empty($imag_id)) {
            $imageTags = $this->Crm_upload_docs_list->getImageList('', $imag_id, '', '', $doctype, $caseid);
            if (!empty($imageTags)) {
                if ($imageTags[0]['err'] > 0) {
                    $errImg = ($imageTags[0]['err'] == 1) ? 'Incorrect Doc' : 'Unclear Image';
                    echo json_encode($errImg);
                    exit;
                }

                echo json_encode($imageTags[0]['name']);
                exit;
            }
        } else if ($tagid > 0) {
            $tagName = $this->Crm_upload_docs_list->getTagNameById($tagid);
            $imTag = $this->Crm_upload_docs_list->getImageList('', '', $tagid, '', $doctype, $caseid);
            /*echo "<pre>";
            print_r($imTag);
            exit;*/
            if (!empty($imTag)) {
                echo json_encode($tagName[0]['name']);
                exit;
            }
        }
        echo json_encode('');
        exit;
    }

    public function loanTagMapping()
    {
        $data = [];
        $err = [];
        $doc = '5';
        $doctype = $this->input->post('doctype');
        if (empty($doctype)) {
            $doc = '4';
        }
        $id = $this->input->post('id');
        $customer_id = $this->input->post('customer_id');
        $case_id = $this->input->post('case_id');
        $img =  $this->input->post('ImgID');
        $tag = $this->input->post('taggID');
        $bank = $this->input->post('bank');
        $type = $this->input->post('type');
        $reason_id = $this->input->post('reason_id');
        $subcat = $this->input->post('subcat');
        if (!empty($img)) {
            $data['image_id'] = $img;
        }
        if (!empty($tag)) {
            $data['parent_tag_id'] = $tag;
        }
        if (!empty($subcat)) {
            $data['tag_id'] = $subcat;
        }
        if ((!empty($bank)) && empty($doctype)) {
            $data['bank_id'] = $bank;
        }

        $img_detail = $this->Crm_upload_docs_list->getImageList($customer_id, $img, '', '', $doc);
        if (($type == 'add') || ($type == 'bank')) {
            //echo "erfwerw"; exit;
            $data['created_on'] = date('Y-m-d H:i:s');
            $data['created_by'] = !empty($_SESSION['userinfo']['id']) ? $_SESSION['userinfo']['id'] : '';
            if ((empty($img_detail)) && (!empty($data['tag_id']))) {
                //echo "sdfsgsegewg";
                $checkPendency = $this->Crm_upload_docs_list->getPendencyDetail($case_id, $doc, $data['tag_id']);
                $imageList = $this->Crm_upload_docs_list->insertTagMapping($data);
                if (!empty($checkPendency)) {
                    // echo "dserf";
                    $datass['pendency_status'] = 'Resolved';
                    $datass['status'] = '0';
                    $datass['image_id'] = $imageList;
                    $checkPendency = $this->Crm_upload_docs_list->insertPendencyMapping($datass, $checkPendency[0]['id']);
                }
                // echo "sdfsgsggdsgsgegewg";
                $err['msg'] = "Image Tagged Successfully";
                $err['status'] = "1";
                echo json_encode($err);
                exit;
            } else if ((!empty($img_detail)) && ($img_detail[0]['err'] == '1')) {
                $err['msg'] = "Image Marked Incorrect";
                $err['status'] = "0";
                echo json_encode($err);
                exit;
            } else {
                $err['msg'] = "Already Tagged";
                $err['status'] = "0";
                echo json_encode($err);
                exit;  //echo $msg = "Already Tagged"; exit;
            }
        } else if ($type == 'remove') {
            $data['status'] = '0';
            $data['updated_by'] = !empty($_SESSION['userinfo']['id']) ? $_SESSION['userinfo']['id'] : '';
            if (!empty($img_detail)) {
                $imageList = $this->Crm_upload_docs_list->insertTagMapping($data, $img_detail[0]['imgID']);
                $err['msg'] = "Tagged Removed Successfully";
                $err['status'] = "1";
                $err['tag_id'] = $img_detail[0]['tag_id'];
                $err['parent_tag_id'] = $img_detail[0]['parent_tag_id'];
                echo json_encode($err);
                exit;
            } else {
                $err['msg'] = "Image is not Tagged";
                $err['status'] = "0";
                echo json_encode($err);
                exit;
            }
        } else if (($type == 'markincorrect') && (!empty($reason_id))) {
            $update_img_detail = $this->Crm_upload_docs_list->getImageList($customer_id, $img, '', '', $doc);
            $data['mark_incorrect'] = $reason_id;
            $data['tag_id'] = '';
            $data['updated_by'] = !empty($_SESSION['userinfo']['id']) ? $_SESSION['userinfo']['id'] : '';
            $imageList = $this->Crm_upload_docs_list->insertTagMapping($data, $update_img_detail[0]['imgID']);
            $err['msg'] = "Image Mark Incorrect";
            $err['status'] = "0";
            echo json_encode($err);
            exit;
        } else if ((empty($img_detail)) && (empty($data['tag_id']))) {
            // echo $msg = "Image is not Tagged"; exit;
            $err['msg'] = "Image is not Tagged";
            $err['status'] = "0";
            echo json_encode($err);
            exit;
        } else if ((!empty($data['tag_id'])) && (!empty($img_detail))) {
            //echo  $msg = "Cann't Tag Image"; exit;
            $err['msg'] = "Cann't Tag Image";
            $err['status'] = "0";
            echo json_encode($err);
            exit;
        }
    }

    public function deleteImg()
    {
        $data = [];
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $data['status'] = '0';
        if (!empty($type)) {
            $arr = explode(',', $id);
            foreach ($arr as $key => $value) {
                $this->Crm_upload_docs_list->insertLoginDocs($data, $value);
            }
        } else {
            $this->Crm_upload_docs_list->insertLoginDocs($data, $id);
        }
        return true;
    }

    public function saveLoginDocs()
    {
        // echo '<pre>';
        // print_r($this->input->post());
        // exit;

        $err = [];
        $bank = [];
        $req_id = [];
        $req = [];
        $caseInfo = [];
        $tagArr = [];
        $req_sid = [];
        $rc_id = $this->input->post('rc_id');
        $doctype = $this->input->post('doctype');
        $ec = '2';
        if ($doctype == '4') {
            $ec = '1';
        }
        $case_id = $this->input->post('case_id');
        $customer_id = $this->input->post('customer_id');
        $checkImg = $this->Crm_rc->getRcFullCarDetail($rc_id);
        $imageList = $this->Crm_upload_docs_list->getImageList($customer_id, "", "", "", $doctype, $case_id);
        $checkPendency = $this->Crm_upload_docs_list->getPendencyDetail($case_id, $doctype);
        $docList = $this->Crm_upload_docs_list->getDocList('0', $doctype, '', $ec);
        $data = [];
        if (!empty($checkPendency)) {
            foreach ($checkPendency as $pkey => $pval) {
                $penTagId[] = $pval['pendency_doc_id'];
            }
        }
        foreach ($imageList as $imgk => $imgv) {
            if ($imgv['err'] == '1') {
                $results = array('status' => 'False', 'message' => 'Please Resolve Incorrect Docs');
                echo json_encode($results);
                exit;
            }
            $tagArr[] = $imgv['tag_id'];
            $bank[] = $imgv['bank_id'];
        }
        if (!empty($penTagId)) {
            foreach ($penTagId as $pk => $pv) {
                if (!empty($tagArr)) {
                    array_push($tagArr, $pv);
                } else {
                    $tagArr[] = $pv;
                }
            }
        }

        foreach ($docList as $key => $val) {
            if (($val['is_required'] == 0)) {
                $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'], $doctype, '', $ec);

                foreach ($sublist as $skey => $sval) {
                    $uploadDocList['name'] = $sval['name'];
                    if ($sval['is_required'] > 0) {
                        $req_sid[$val['parent_id']][] = $sval['sub_category_id'];
                    }
                }
            }
        }
        // echo "<pre>";print_r($req_sid);die;
        foreach ($req_sid as $rkey => $rval) {
            foreach ($rval as $kr) {
                if (!in_array($kr, $tagArr)) {
                    $results = array('status' => 'False', 'message' => 'Please upload all required Doc');
                    echo json_encode($results);
                    exit;
                }
            }
        }
        $action = '2';

        if ((!empty($doctype)) && ($doctype == 4)) {
            if ($checkImg['upload_rc_docs'] == 0) {
                $data['upload_doc_date']  = date('Y-m-d h:i:s');
                $action = '1';
            }
            $data['upload_rc_docs'] = '1';
            $urlaction =  base_url() . 'uploadRcDocs/' . base64_encode('RcId_' . $rc_id) . '/transferred';
        } else {
            if ($checkImg['rc_transferred_docs'] == 0) {
                $data['rc_transferred_docs_date']  = date('Y-m-d h:i:s');
                $action = '1';
            }
            $data['rc_transferred_docs'] = '1';
            $urlaction =  base_url() . 'rcListing';
        }
        $this->Crm_rc->updateRcInfoTable($data, $rc_id);
        $this->addHistoryLog($rc_id, '', 'Rc Docs Uploaded', $this->session->userdata['userinfo']['id'], $action);
        if ($action == '1') {
            // $this->addRcTimeline($rc_id,'Rc Docs Uploaded',$this->session->userdata['userinfo']['id']);
        }
        $results = array('status' => 'True', 'message' => 'Docs uploaded Successfully', 'Action' => $urlaction);
        echo json_encode($results);
        exit;
    }

    public function rcDetail($rc_id)
    {
        $data = [];
        $imgListArr = [];
        $data['pageTitle']      = 'RC Upload Documents';
        $data['pageType']       = 'rcdetail';
        $tagIds = '';
        $loanCaseId = '';
        $csId = '';
        $editId      = !empty($rc_id) ? explode('_', base64_decode($rc_id)) : '';
        $rcId        = !empty($editId) ? end($editId) : '';
        $getRcDetail = $this->Crm_rc->getRcFullCarDetail($rcId);
        $data['rtoTeam'] = $this->Crm_user->getEmployeeByTeam('RC Transfer');
        $data['rolemgmt'] = $this->UserMgmtRole();
        $getRcDetail['rto_charges'] = $this->IND_money_format(!empty($getRcDetail['rto_charges']) ? $getRcDetail['rto_charges'] : '');
        $data['getRcDetail'] = $getRcDetail;
        //  echo "<pre>";print_r($data);die;
        $this->loadViews('RcCase/rc_detail', $data);
    }

    public function saveUpdateRcData()
    {
        $params = $this->input->post();
        $rcid  = $params['rcid'];
        $data = [];
        $action = '2';
        $remark = '';
        $activity = 'RC Detail Updated';
        $checkImg = $this->Crm_rc->getRcFullCarDetail($rcid);
        if ($checkImg['in_process_date'] == "0000-00-00" &&  $params['rc_status'] == 2) {
            $data['in_process_date'] = date('Y-m-d');
        }
        $data['rc_status'] = $params['rc_status'];
        $data['pending_from'] = $params['rc_transfered'];
        $data['rto_slip_no'] =  !empty($params['rto_slip_no']) ? $params['rto_slip_no'] : '';
        $data['rto_agent']  = !empty($params['assign_to']) ? $params['assign_to'] : '';
        $data['rto_work']  = !empty($params['rto_work']) ? $params['rto_work'] : '';
        $data['rto_work'] = implode(',', $data['rto_work']);
        $data['rto_charges']  = !empty($params['rto_charges']) ? str_replace(',', '', $params['rto_charges']) : '';
        if (!empty($data['rto_agent'])) {
            $rto_agent_name_arr = $this->Crm_user->getEmployee('', $data['rto_agent']);
            $rto_agent_name  = ucwords($rto_agent_name_arr[0]['name']);
            $data['assigned_on']  = date('Y-m-d', strtotime($params['assigned_on']));
        }
        $data['rc_detail_form_update'] = '1';

        if ($data['rc_status'] != $checkImg['rc_status']) {
            $action = '1';

            if ($data['rc_status'] == '1') {
                $this->addRcTimeline($rcid, 'Pending', $this->session->userdata['userinfo']['id'], 'Pending');
            }
            if ($data['rc_status'] == '2') {
                if (!empty($rto_agent_name)) {
                    $name = "(" . $rto_agent_name . ")";
                }
                $this->addRcTimeline($rcid, 'In-Process ' . (!empty($name) ? $name : ''), $this->session->userdata['userinfo']['id'], 'In-Process');
            }
            if ($data['rc_status'] == '3') {
                $loan_ref_id = $checkImg['loan_sno'];
                $bank_id_loan = $checkImg['bank_id_loan'];
                if (!empty($loan_ref_id))
                    $this->crmEmpAmountLog($loan_ref_id, $bank_id_loan);
                $this->addRcTimeline($rcid, 'Transferred', $this->session->userdata['userinfo']['id'], 'Transferred');
                $data['rc_transferred_date'] = date('Y-m-d h:i:s');
            }
        }
        if ($data['rto_slip_no'] != $checkImg['rto_slip_no']) {            
            $activity = 'RTO Slip No Updated';
            $actions = '2';
        }
        if ($data['rto_agent'] != $checkImg['rto_agent']) {            
            $activity = 'RTO Agent Updated';
            $actions = '2';
        }
        if (!empty($data['assigned_on']) && ($data['assigned_on'] != $checkImg['assigned_on'])) {            
            $activity = 'Rc Assigned On Date Updated';
            $actions = '2';
            $remark  = date('d-m-Y', strtotime($data['assigned_on']));
        }
        
        // echo "<pre>";print_r($data);die;
        $this->Crm_rc->updateRcInfoTable($data, $rcid);
        $this->Crm_rc->updateLoanNetPaymentTable($data, $rcid);
        
        if (empty($actions))
            $actions = 1;
            $this->addHistoryLog($rcid, serialize($data), $activity, $this->session->userdata['userinfo']['id'], $actions);

        if ((($data['rc_status'] == '2') || ($data['rc_status'] == '3')) && ($data['pending_from'] == '1')) {
            $result = array('status' => 'True', 'message' => 'Rc details Updated Successfully', 'Action' =>  base_url() . 'uploadRcDocs/' . base64_encode('RcId_' . $rcid) . '/transferred');
        } else if ($data['rc_status'] != '1') {            
            $result = array('status' => 'True', 'message' => 'Rc details Updated Successfully', 'Action' =>  base_url() . 'uploadRcDocs/' . base64_encode('RcId_' . $rcid));           
        }else{
            $result = array('status' => 'True', 'message' => 'Rc details Updated Successfully', 'Action' =>  base_url() . 'uploadRcDocs/' . base64_encode('RcId_' . $rcid));
        }
        
        echo json_encode($result);
        exit;
    }

    public function addHistoryLog($rcid, $updated_field, $activity, $created_by, $action = '1')
    {
        $data = [];
        $data['rc_id'] = $rcid;
        $data['updated_field'] = $updated_field;
        $data['activity'] = $activity;
        $data['created_by'] = $created_by;
        $data['status'] = $action;

        $this->Crm_rc->insertHistoryLog($data);
    }

    public function addRcTimeline($rcid, $activity, $created_by, $remark = '')
    {
        $data = [];
        $data['rc_id'] = $rcid;
        $data['activity'] = $activity;
        $data['created_by'] = $created_by;
        $data['remark'] = $remark;
        $data['status'] = '1';
        $this->Crm_rc->insertRcTimeLine($data);
    }

    public function crmEmpAmountLog($ref_id, $bank_id)
    {

        //check this functionality and update rc_flag in loan_file table
        $data = [];
        $loan_data = $this->Loan_customer_info->checkRefIdForRC($ref_id, '4');
        $data['case_id'] = $loan_data[0]['case_id'];
        $dis_amount = $loan_data[0]['disbursed_amount'];
        $custInfo       = $this->Loan_customer_case->getCaseInfoByCaseId($data['case_id']);
        $data['bank_id'] = $bank_id;
        $emp_id = $custInfo[0]['meet_the_customer'];
        $amount_assigned = $this->Loan_customer_info->getAssignedLimitByBankEmp($emp_id, $bank_id);
        $remain = $this->Loan_customer_info->getRemainingLimitByBankEmp($emp_id, $bank_id);
        $getRemaining = (int)$amount_assigned - (int)(!empty($remain) ? $remain : 0);
        $data['amount_credit'] = $dis_amount;
        $data['amount_assigned'] = $getRemaining;
        $data['amount_debit'] = 0;
        $data['amount_remaining'] = (int)$getRemaining + (int)$dis_amount;
        $data['action'] = '2';
        $data['created_by'] = $this->session->userdata['userinfo']['id'];
        $data['emp_id'] = $emp_id;
        $this->Loan_customer_info->crmEmpAmountLog($data);
        $caseInfo['rc_status'] = '2';
        $this->Loan_customer_case->saveCaseFileLogin($caseInfo, $loan_data[0]['id']);
    }

    public function rctransferreddoc()
    {
        $data = [];
        $imgListArr = [];
        $tagIds = '';
        $loanCaseId = '';
        $csId = '';
        $rcid = $this->input->post('rc_id');
        $getRcDetail = $this->Crm_rc->getRcFullCarDetail($rcid);
        $data['getRcDetail'] = $getRcDetail;
        $data['rc_id'] = $getRcDetail['rcid'];
        $data['rcId'] = $getRcDetail['rcid'];
        $data['customer_id'] = $getRcDetail['customer_id'];
        $data['rolemgmt'] = $this->UserMgmtRole();
        $flag = 1;
        //$csId = $data['rc_id'];
        if (!empty($getRcDetail['loan_ref_id'])) {
            $loanCaseId = $this->Crm_rc->getLoanDetailByRefId($getRcDetail['loan_ref_id']);
            $csId = $loanCaseId['case_id'];
            $data['rc_id'] = $loanCaseId['case_id'];
            $flag = '';
        }

        $docList = $this->Crm_upload_docs_list->getDocList('', '5');
        foreach ($docList as $key => $val) {
            $uploadDocList[$val['parent_id']]['name'] = $val['parent_name'];
            $uploadDocList[$val['parent_id']]['is_require'] = $val['is_require'];
            //echo $data['CustomerInfo']['loan_for'].'-'.$val['id'];
            $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'], '5');
            foreach ($sublist as $skey => $sval) {
                $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['name'] = $sval['name'];
                $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['sub_category_id'] = $sval['sub_category_id'];
                $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = $sval['is_require'];
            }
        }

        $data['uploadDocList'] = (!empty($uploadDocList)) ? $uploadDocList : '';
        $tagIdd = rtrim($tagIds, ',');

        $imgListUpdated = $this->Crm_upload_docs_list->getImageList($data['customer_id'], '', '', '', '5', $data['rcId'], $flag);
        if (!empty($imgListUpdated)) {
            $i = 0;
            foreach ($imgListUpdated as $imgK => $imgV) {
                $name = '';
                $bank_name = '';
                $imgListArr[$i]['id']           =   $imgV['id'];
                $imgListArr[$i]['doc_name']     =   $imgV['doc_name'];
                $imgListArr[$i]['doc_url']      =   (($imgV['sent_to_aws'] == '1') ? AWS_PATH : UPLOAD_IMAGE_URL) . $imgV['doc_url'];
                $imgListArr[$i]['doc_type']     =   $imgV['doc_type'];
                $imgListArr[$i]['customer_id']  =   $imgV['customer_id'];
                $imgListArr[$i]['case_id']      =   $imgV['case_id'];
                $imgListArr[$i]['status']       =   $imgV['status'];
                $imgListArr[$i]['created_on']   =   $imgV['created_on'];
                $imgListArr[$i]['updated_on']   =   $imgV['updated_on'];
                $imgListArr[$i]['tag_id']       =   $imgV['parent_tag_id'];
                $imgListArr[$i]['sub_id']       =   $imgV['sub_id'];
                $imgListArr[$i]['image_id']     =   $imgV['image_id'];
                $imgListArr[$i]['imgID']        =   $imgV['imgID'];
                $imgListArr[$i]['bank_id']      =   $imgV['bank_id'];
                $imgListArr[$i]['name']         =   $imgV['name'];
                $imgListArr[$i]['parent_id']    =   $imgV['parent_id'];
                $imgListArr[$i]['err']          =   $imgV['err'];
                $i++;
            }
        }
        $data['imageList'] =  $imgListArr;
        $data['pendencyDoc'] = $this->Crm_upload_docs_list->getPendencyDetail($data['rcId'], 5);
        echo $datas = $this->load->view('RcCase/upload_rc_tranferred_doc', $data, true);
        exit;
        //  $this->loadViews('RcCase/upload_rc_docs',$data);
    }

    public function pendencyByCatId()
    {
        //$parent = [];
        $ids = [];
        $catID = $this->input->post('catId');
        $case_id = $this->input->post('case_id');
        $doctype = $this->input->post('doctype');
        $type = $this->input->post('type');
        $rcid = $this->input->post('rcid');
        if (empty($rcid)) {
            $rcid = '1';
        }
        $sublist = '';
        $imggg = $this->Crm_upload_docs_list->getImageList('', '', '', '', $doctype, $case_id);
        $update_img_detail = $this->Crm_upload_docs_list->getPendencyDetail($case_id, $doctype);
        /* echo "<pre>";
        print_r($update_img_detail);
        exit;*/
        foreach ($update_img_detail as $key => $value) {
            if ($value['doc_id'] > 0) {
                $ids[] = $value['doc_id'];
            }
        }
        if (!empty($imggg)) {
            foreach ($imggg as $k => $v) {
                if (!empty($v['tag_id'])) {
                    $ids[] = $v['tag_id'];
                }
            }
        }
        if ($type == 'getcategoryId') {
            if (!empty($imggg)) {

                foreach ($imggg as $k => $v) {
                    if (!empty($v['tag_id'])) {
                        $ids[] = $v['tag_id'];
                    }
                }
            }
            $sublist = $this->Crm_upload_docs_list->getCategoryList($ids, $doctype);

            //$sublist = $this->Crm_upload_docs_list->getDocList('0','4','',$rcid); 
            $str = "<option value=''>Select Category</option>";
            foreach ($sublist as $key => $val) {
                if ($val['is_required'] == '1') {
                    $prntName = $val['parent_name'] . ' *';
                } else {
                    $prntName = $val['parent_name'];
                }
                $str .= "<option value=" . $val['id'] . ">$prntName</option>";
            }
            echo $str;
            exit;
        } else {
            /*if(!empty($imggg))
            {              
                foreach ($imggg as $k => $v) {
                    if(!empty($v['tagid'])){
                     $ids[] = $v['tagid'];
                    }
                }

            }*/
            $sublist = $this->Crm_upload_docs_list->getSubCategoryList($catID, $ids);
            $str = "<option value=''>Select Pendency Doc</option>";
            foreach ($sublist as $key => $val) {
                if ($val['is_require'] == '1') {
                    $sName = $val['name'] . ' *';
                } else {
                    $sName = $val['name'];
                }
                $str .= "<option value=" . $val['sub_category_id'] . ">$sName</option>";
            }
            echo $str;
            exit;
        }
    }

    public function addPendencyDoc()
    {
        $data = [];
        $datas = [];
        $case_id = $this->input->post('case_id');
        $doctype = $this->input->post('doctype');
        $pendencyId = $this->input->post('pendencyId');
        $category_id = $this->input->post('category_id');
        //$pendencyName = $this->input->post('pendencyName');
        $update_img_detail = $this->Crm_upload_docs_list->getImageList('', '', $pendencyId, '', $doctype, $case_id);
        if (!empty($update_img_detail)) {
            $datas['is_pendency'] = '1';
            $imageList = $this->Crm_upload_docs_list->insertTagMapping($datas, $update_img_detail[0]['imgID']);
        }
        $checkPendency = $this->Crm_upload_docs_list->getPendencyDetail($case_id, $doctype, $pendencyId);
        if (empty($checkPendency)) {

            $data['case_id'] = $case_id;
            $data['doc_type'] = $doctype;
            $data['pendency_doc_id'] = $pendencyId;
            $data['pendency_status'] = 'Active';
            $checkPendency = $this->Crm_upload_docs_list->insertPendencyMapping($data);
            if (!empty($checkPendency)) {
                $err['msg'] = $category_id;
                $err['status'] = '1';
            }
        } else {
            $err['msg'] = 'Already Exists.';
            $err['status'] = '0';
        }
        echo json_encode($err);
        exit;
    }

    public function getImagedownload($caseId, $doc = '1')
    {
        $this->load->library('zip');
        $data = [];
        // $doc = 1;
        $imageList = $this->Crm_upload_docs_list->getImageList('', '', '', '', $doc, $caseId);

        if (!empty($imageList)) {
            $id = '';
            foreach ($imageList as $key => $val) {
                $id .= $val['id'] . ',';
            }
            $newid = rtrim($id, ",");
        }
        $id = $newid;
        $type = 'all';
        $data['status'] = '0';
        $data['updated_by'] = !empty($_SESSION['userinfo']['id']) ? $_SESSION['userinfo']['id'] : '';
        if (!empty($type)) {
            $id = trim($id, ',');
            $arr = explode(',', $id);
            $imageName = $this->Crm_upload_docs_list->getImageList('', '', '', '', '', '', '', '', $arr);

            $imgdata = array();
            $i = 1;
            foreach ($imageName as $key => $value) {
                if (!empty($value)) {
                    $newfname = '';
                    $imgContet = '';
                    $newfname = UPLOAD_IMAGE_PATH_LOCAL . 'upload_rc_doc/' . $value['doc_name'];
                    if (!empty($value['aws_url'])) {
                        $newfname = $value['aws_url'];
                    }
                    $imgContet = file_get_contents($newfname);
                    if (!empty($value['name'])) {
                        $a = explode('.', $value['doc_name']);
                        $nam = $value['name'] . '-' . $i . '.' . $a[1];
                    } else {
                        $nam = $value['doc_name'];
                    }
                    $imgdata[$nam] = $imgContet;
                } else {
                    echo "error";
                    exit;
                }
                $i++;
            }

            if (!empty($imgdata)) {
                $time = time();
                $filename = 'files_backup_' . $time;
                $this->zip->add_data($imgdata);
                $this->zip->archive('upload_rc_doc/' . $filename . '.zip');
                $this->zip->download($filename);
            } else {
                echo "error";
                exit;
            }
        }

        $this->uploadRcDocs($caseId);
    }

    public function rc_make_payment($id = '')
    {
        $data = [];
        $editId      = !empty($id) ? explode('_', base64_decode($id)) : '';
        $pay_id        = !empty($editId) ? end($editId) : '';
        $data['rtoList']   =  $this->Crm_user->getEmployeeByTeam('RTO');
        $data['banklist']        =  $this->Crm_banks->getBanklist();
        $data['cusbanklist']     =  $this->Crm_banks->getcustomerBankList();
        $datapost['payid'] = $pay_id;
        if (!empty($pay_id)) {
            $data['rc_case_details'] = $this->Crm_rc->getRcleadsQuery($datapost);
        }
        $data['total_rc_amt'] = $this->IND_money_format(!empty($data['rc_case_details'][0]['rc_amt']) ? $data['rc_case_details'][0]['rc_amt'] : '');
        //echo "<pre>";print_r($data);die;
        $this->loadViews("RcCase/rc_make_payment", $data);
    }

    public function ajax_getrtocaselist()
    {
        $datapost = [];
        $datapost['agentrto'] = $this->input->post('rtoagent');
        $flag = $this->input->post('flag');
        $datapost['search'] = $this->input->post('search');
        $datapost['rcStatus'] = '3';

        if (empty($flag)) {
            $datapost['payid'] = '0';
        } else {
            $datapost['payid'] = $flag;
        }
        $data['case_details'] = $this->Crm_rc->getRcleadsQuery($datapost);
        //echo "<pre>";print_r($data);die
        echo $datas = $this->load->view('RcCase/ajax_getrtocaselist', $data, true);
        exit;
    }

    function random_strings($length_of_string)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(
            str_shuffle($str_result),
            0,
            $length_of_string
        );
    }

    public function save_rcpay_details()
    {
        $datapost = $this->input->post();
        $insertData = [];
        $insertData['payment_mode'] = !empty($datapost['payment_mode']) ? $datapost['payment_mode'] : '';
        $insertData['amount'] = !empty($datapost['rc_amt']) ? str_replace(',', '', $datapost['rc_amt']) : '';
        $insertData['paydates'] = !empty($datapost['paydates']) ? date('Y-m-d', strtotime($datapost['paydates'])) : '';
        $insertData['instrument_no'] = !empty($datapost['instrument_no']) ? $datapost['instrument_no'] : '';
        $insertData['instrument_date'] = !empty($datapost['instrument_date']) ? date('Y-m-d', strtotime($datapost['instrument_date'])) : '';
        $insertData['favouring'] = !empty($datapost['favouring']) ? $datapost['favouring'] : '';
        $insertData['payment_banks'] = !empty($datapost['payment_banks']) ? $datapost['payment_banks'] : '0';
        $insertData['remark'] = !empty($datapost['remark']) ? $datapost['remark'] : '';
        $all_rc_ids = $datapost['all_rc_ids'];
        $totalrccase = !empty($datapost['totalrccase']) ? $datapost['totalrccase'] : '';
        $totalrcamt = !empty($datapost['totalrcamt']) ? $datapost['totalrcamt'] : '';
        $newamt = $datapost['newamt'];
        $amount_ids = explode(',', $newamt);
        $pay_id = $datapost['pay_id'];
        if (empty($pay_id)) {
            $insertData['payment_rnd_id'] = 'RC' . $this->random_strings(4);
        }
        $payid = $this->Crm_rc->insertRcPaymentDetails($insertData, $pay_id);
        $j = 0;
        if (empty($pay_id)) {
            for ($i = 1; $i <= $totalrccase; $i++) {
                $arr = explode(':', $amount_ids[$j]);
                $updateData['rto_actual_charges'] = $arr[1];
                $updateData['payment_id'] = $payid;
                $updateAmt = $this->Crm_rc->updateRcInfoTable($updateData, $arr[0]);
                $j++;
            }
        }
        if (!empty($payid)) {
            echo json_encode(array('status' => '1'));
            exit;
        } else {
            echo json_encode(array('status' => '0'));
            exit;
        }
    }

    function getcities(){
        $stateId   = $this->input->post('stateId');
        $this->db->select('city_id,city_name');
        $this->db->from('city_list');
        $this->db->where('state_id', $stateId);
        $query = $this->db->get();
        $result = $query->result_array();
        $option= "<option value='' >Select City</option>";
        foreach ($result as $cityKey => $cityValue) {
             $option .="<option value='" . $cityValue['city_id'] . "' >" . $cityValue['city_name'] . "</option>";
        }
        echo $option;
    }


    public function add_rc_transfer(){
        $data = [];
        $imgListArr = [];
        $data['pageTitle']      = 'Add Rc Transfer Case';
        $data['pageType']       = 'rcCase';
        
        // $tagIds = '';
        // $loanCaseId = '';
        // $csId = '';
        // $editId      = !empty($rc_id) ? explode('_', base64_decode($rc_id)) : '';
        // $rcId        = !empty($editId) ? end($editId) : '';
        // $getRcDetail = $this->Crm_rc->getRcFullCarDetail($rcId);
        // $data['rtoTeam'] = $this->Crm_user->getEmployeeByTeam('RC Transfer');
        // $data['rolemgmt'] = $this->UserMgmtRole();
        // $getRcDetail['rto_charges'] = $this->IND_money_format(!empty($getRcDetail['rto_charges']) ? $getRcDetail['rto_charges'] : '');
        // $data['getRcDetail'] = $getRcDetail;
        
        $data['stateList']  =  $this->state_list->getStateList();
        $data['userList']   =  $this->Crm_user->getEmployeeByTeam('Sales');
        //  echo "<pre>";print_r($data);die;
        $this->loadViews('RcCase/add_rc_transfer', $data);
    }


    public function saveRcInfo() {
        $datapost = $this->input->post();

        $chkValidateRcCase= $this->chkValidateRcCase($datapost);
        if($chkValidateRcCase){
            echo json_encode($chkValidateRcCase);
            // echo $chkValidateRcCase;
            exit;
        }

        $dealerId = DEALER_ID;
        $insertData = [];
        $insertData['customer_name'] = !empty($datapost['add_rc_customer_name']) ? $datapost['add_rc_customer_name'] : '';
        $insertData['customer_email'] = !empty($datapost['add_rc_customer_email']) ? $datapost['add_rc_customer_email'] : '';
        $insertData['customer_mobile'] = !empty($datapost['add_rc_customer_mobile']) ? $datapost['add_rc_customer_mobile'] : '';
        $insertData['rc_status'] = !empty($datapost['add_rc_transfer_status']) ? $datapost['add_rc_transfer_status'] : '';
        $insertData['reg_no'] = !empty($datapost['add_rc_customer_regno']) ? $datapost['add_rc_customer_regno'] : '';
        $insertData['rto_agent'] = !empty($datapost['rto_agent']) ? $datapost['rto_agent'] : '';
        $insertData['pending_from'] = !empty($datapost['pending_from']) ? $datapost['pending_from'] : '';
        $insertData['updated_by'] = !empty($datapost['updated_by']) ? $datapost['updated_by'] : '';
        $insertData['aadhar_no'] = !empty($datapost['add_rc_aadhar_number']) ? $datapost['add_rc_aadhar_number'] : '';
        $insertData['rto_type'] = !empty($datapost['rto_type']) ? $datapost['rto_type'] : '';
        $insertData['from_state'] = !empty($datapost['from_state']) ? $datapost['from_state'] : '';
        $insertData['to_state'] = !empty($datapost['to_state']) ? $datapost['to_state'] : '';
        $insertData['from_city'] = !empty($datapost['from_city']) ? $datapost['from_city'] : '';
        $insertData['to_city'] = !empty($datapost['to_city']) ? $datapost['to_city'] : '';

        $results = $this->Crm_rc->setRcTransferDetail($insertData);

        if ($results['rc_status'] != '1') {
            $resultData = array('status' => 'True', 'message' => 'Rc details Inserted Successfully', 'Action' =>  base_url() . 'rcUploadDoc/' . base64_encode('RcId_' . $results['rc_ids']));
        }else{
            $resultData = array('status' => 'True', 'message' => 'Rc details Inserted Successfully', 'Action' =>  base_url() . 'rcUploadDoc/' . base64_encode('RcId_' . $results['rc_ids']));
        }
        echo json_encode($resultData);
        exit;
    }

    public function chkValidateRcCase($datapost) {
        $name = addslashes(trim($datapost['add_rc_customer_name']));
        if ($name == '') {
            return '<span class="error">Please Enter Name</span>';
            die;
        }
        if (preg_match('/([^a-zA-Z.\s])/', $name)) {
            return '<span class="error">Special Characters or Digits are Not Allowed in Name</span>';
            die;
        }
        $email = !empty($datapost['add_rc_customer_email'])?addslashes(trim($datapost['add_rc_customer_email'])):'';

        $mobile = addslashes(trim($datapost['add_rc_customer_mobile']));

        if ($mobile == '' || strlen($mobile) < 10 || !is_numeric($mobile) || !($mobile[0] == '6' || $mobile[0] == '7' || $mobile[0] == '8' || $mobile[0] == '9')) {
            return '<span>Please Enter a Valid Mobile Number</span>';
            die;
        }

        if(!empty($email)) {
            if (preg_match('/([^a-zA-Z0-9._@])/', $email)) {
                return '<span class="error">Special Characters are Not Allowed in Email</span>';
                die;
            }
            $emailArr = explode("@", $email);
            $emailArr2 = explode(".", $emailArr[1]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || is_numeric($emailArr[0]) || is_numeric($emailArr2[0]) || is_numeric($emailArr2[1])) {
                return '<span class="error">Please Enter Valid Email Address</span>';
                die;
            }
        }

        // if ($datapost['add_rc_customer_regno'] == '' ) {
        //     echo '<span class="error">Please Enter Reg No</span>';
        //     die;
        // }
    }

    

    public function rcTransferUploadDoc($rc_id){
        $data = [];
        $imgListArr = [];
        $data['pageTitle']      = 'Add Rc Transfer Case';
        $data['pageType']       = 'rcCase';
        
        $tagIds = '';
        $loanCaseId = '';
        $csId = '';
        $editId      = !empty($rc_id) ? explode('_', base64_decode($rc_id)) : '';
        $rcId        = !empty($editId) ? end($editId) : '';
        $getRcDetail = $this->Crm_rc->getRcFullCarDetail($rcId);
        $data['customer_id'] = $getRcDetail['customer_id'];
        $data['rtoTeam'] = $this->Crm_user->getEmployeeByTeam('RC Transfer');
        $data['rolemgmt'] = $this->UserMgmtRole();
        $getRcDetail['rto_charges'] = $this->IND_money_format(!empty($getRcDetail['rto_charges']) ? $getRcDetail['rto_charges'] : '');
        $data['getRcDetail'] = $getRcDetail;
        
        $data['stateList']  =  $this->state_list->getStateList();
        $data['userList']   =  $this->Crm_user->getEmployeeByTeam('Sales');
        //  echo "<pre>";print_r($data);die;
        $this->loadViews('RcCase/add_rc_frame', $data);
        // $this->loadViews('RcCase/add_new_rc_upload_doc', $data);
    }


    public function addRCLogindoc()
    {
        $data = [];
        $imgListArr = [];
        $tagIds = '';
        $loanCaseId = '';
        $csId = '';
        $rcid = $this->input->post('rc_id');
        $getRcDetail = $this->Crm_rc->getRcFullCarDetail($rcid);
        $data['getRcDetail'] = $getRcDetail;
        $data['rc_id'] = $getRcDetail['rcid'];
        $data['rcId'] = $getRcDetail['rcid'];
        $data['customer_id'] = $getRcDetail['customer_id'];
        $data['rolemgmt'] = $this->UserMgmtRole();
        $flag = 1;
        //$csId = $data['rc_id'];
        if (!empty($getRcDetail['loan_ref_id'])) {
            $loanCaseId = $this->Crm_rc->getLoanDetailByRefId($getRcDetail['loan_ref_id']);
            $csId = $loanCaseId['case_id'];
            $data['rc_id'] = $loanCaseId['case_id'];
            $flag = '';
        }

        $docList = $this->Crm_upload_docs_list->getDocList('', '4');
        foreach ($docList as $key => $val) {
            $uploadDocList[$val['parent_id']]['name'] = $val['parent_name'];
            $uploadDocList[$val['parent_id']]['is_require'] = $val['is_require'];
            //echo $data['CustomerInfo']['loan_for'].'-'.$val['id'];
            $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'], '4');
            foreach ($sublist as $skey => $sval) {
                $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['name'] = $sval['name'];
                $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['sub_category_id'] = $sval['sub_category_id'];
                $uploadDocList[$val['parent_id']]['subList'][$sval['id']]['is_require'] = $sval['is_require'];
            }
        }

        $data['uploadDocList'] = (!empty($uploadDocList)) ? $uploadDocList : '';
        $tagIdd = rtrim($tagIds, ',');

        $data['pendencyDoc'] = $this->Crm_upload_docs_list->getPendencyDetail($data['rcId'], 4);
        $imgListUpdated = $this->Crm_upload_docs_list->getImageList($data['customer_id'], '', '', '', '4', $data['rcId'], $flag);
        if (!empty($imgListUpdated)) {
            $i = 0;
            foreach ($imgListUpdated as $imgK => $imgV) {
                $name = '';
                $bank_name = '';
                $imgListArr[$i]['id']           =   $imgV['id'];
                $imgListArr[$i]['doc_name']     =   $imgV['doc_name'];
                $imgListArr[$i]['doc_url']      =   (($imgV['sent_to_aws'] == '1') ? AWS_PATH : UPLOAD_IMAGE_URL) . $imgV['doc_url'];
                $imgListArr[$i]['doc_type']     =   $imgV['doc_type'];
                $imgListArr[$i]['customer_id']  =   $imgV['customer_id'];
                $imgListArr[$i]['case_id']      =   $imgV['case_id'];
                $imgListArr[$i]['status']       =   $imgV['status'];
                $imgListArr[$i]['created_on']   =   $imgV['created_on'];
                $imgListArr[$i]['updated_on']   =   $imgV['updated_on'];
                $imgListArr[$i]['tag_id']       =   $imgV['parent_tag_id'];
                $imgListArr[$i]['sub_id']       =   $imgV['sub_id'];
                $imgListArr[$i]['image_id']     =   $imgV['image_id'];
                $imgListArr[$i]['imgID']        =   $imgV['imgID'];
                $imgListArr[$i]['bank_id']      =   $imgV['bank_id'];
                $imgListArr[$i]['name']         =   $imgV['name'];
                $imgListArr[$i]['parent_id']    =   $imgV['parent_id'];
                $imgListArr[$i]['err']          =   $imgV['err'];
                $i++;
            }
        }
        $data['imageList'] =  $imgListArr;
        echo $datas = $this->load->view('RcCase/add_new_rc_upload_doc', $data, true);
        exit;
        //  $this->loadViews('RcCase/upload_rc_docs',$data);
    }
    
    public function saveRcCaseLoginDocs()
    {
        // echo '<pre>';
        // print_r($this->input->post());
        // exit;

        $err = [];
        $bank = [];
        $req_id = [];
        $req = [];
        $caseInfo = [];
        $tagArr = [];
        $req_sid = [];
        $rc_id = $this->input->post('rc_id');
        $doctype = $this->input->post('doctype');
        $ec = '2';
        if ($doctype == '4') {
            $ec = '1';
        }
        $case_id = $this->input->post('case_id');
        $customer_id = $this->input->post('customer_id');
        $checkImg = $this->Crm_rc->getRcFullCarDetail($rc_id);
        $imageList = $this->Crm_upload_docs_list->getImageList($customer_id, "", "", "", $doctype, $case_id);
        $checkPendency = $this->Crm_upload_docs_list->getPendencyDetail($case_id, $doctype);
        $docList = $this->Crm_upload_docs_list->getDocList('0', $doctype, '', $ec);
        $data = [];
        if (!empty($checkPendency)) {
            foreach ($checkPendency as $pkey => $pval) {
                $penTagId[] = $pval['pendency_doc_id'];
            }
        }
        foreach ($imageList as $imgk => $imgv) {
            if ($imgv['err'] == '1') {
                $results = array('status' => 'False', 'message' => 'Please Resolve Incorrect Docs');
                echo json_encode($results);
                exit;
            }
            $tagArr[] = $imgv['tag_id'];
            $bank[] = $imgv['bank_id'];
        }
        if (!empty($penTagId)) {
            foreach ($penTagId as $pk => $pv) {
                if (!empty($tagArr)) {
                    array_push($tagArr, $pv);
                } else {
                    $tagArr[] = $pv;
                }
            }
        }

        foreach ($docList as $key => $val) {
            if (($val['is_required'] == 0)) {
                $sublist = $this->Crm_upload_docs_list->getDocList($val['parent_id'], $doctype, '', $ec);

                foreach ($sublist as $skey => $sval) {
                    $uploadDocList['name'] = $sval['name'];
                    if ($sval['is_required'] > 0) {
                        $req_sid[$val['parent_id']][] = $sval['sub_category_id'];
                    }
                }
            }
        }
        // echo "<pre>";print_r($req_sid);die;
        foreach ($req_sid as $rkey => $rval) {
            foreach ($rval as $kr) {
                if (!in_array($kr, $tagArr)) {
                    $results = array('status' => 'False', 'message' => 'Please upload all required Doc');
                    echo json_encode($results);
                    exit;
                }
            }
        }
        $action = '2';

        
        $data['rc_transferred_docs'] = '1';
        $urlaction =  base_url() . 'rcListing';
    
        $this->Crm_rc->updateRcInfoTable($data, $rc_id);
        $this->addHistoryLog($rc_id, '', 'Rc Docs Uploaded', $this->session->userdata['userinfo']['id'], $action);
        if ($action == '1') {
            // $this->addRcTimeline($rc_id,'Rc Docs Uploaded',$this->session->userdata['userinfo']['id']);
        }
        $results = array('status' => 'True', 'message' => 'Docs uploaded Successfully', 'Action' => $urlaction);
        echo json_encode($results);
        exit;
    }

}
