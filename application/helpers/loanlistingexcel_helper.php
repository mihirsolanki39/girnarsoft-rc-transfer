<?php

function exportLoanData($Data,$filename) {
    $objPHPExcel = new PHPExcel();
    $objPHPExcel = makeExcelHeader($objPHPExcel);
    $objPHPExcel = makeExcelRows($objPHPExcel,$Data);
    $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
    ob_end_clean();
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Cache-Control: max-age=0");
    $objWriter->save('php://output');
    exit();
}

 function makeExcelHeader($objPHPExcel){
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Serial No');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Customer Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Contact No');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Dealer Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Sales Executive');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Assigned To');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Case Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Make Model Version');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Reg No');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Bank Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'LOS No /  Application No');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Loan Amount');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'ROI');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Tenure (In months)');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'EMI');
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Disbursal Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Status');
        $objPHPExcel->getActiveSheet()->getStyle("A1:Q1")->getFont()->setBold(true);
        return $objPHPExcel;
    }
    
    function CalculateEmi($lamount,$tenor,$rate,$type='0')
    {
        //$rate = (floatval)$rate;
        $mic = ($rate/100) /12; // Monthly interest
        $fv = 0;
        if ($mic === 0)
        return -($lamount + $fv)/$tenor;

        $pvif = pow(1 + $mic, $tenor);
        $pmt = (-$mic * $lamount * ($pvif + fv) / ($pvif - 1));

        if ($type === 1)
            $pmt /= (1 + $mic);

        return abs(round($pmt));
      /*  $top = pow((1+$mic),$tenor);
        $bottom = $top - 1;
        $sp = $top / $bottom;
        $emi = (($lamount * $mic) * $sp);
        return round($emi);*/
    }
    
function makeExcelRows($objPHPExcel,$insdata){
        if(!empty($insdata)){
        $count=2;
        $insuranceBy = "";
        $loandisbusamount = 0;
        $make = "";
        $model = "";
        $casetype = '';
        $loc='';
        $roi= '';
        $tenure = '';
        $emi = '';
        $disbursed_date='';
        $status='';
        $type=0;
        foreach ($insdata as $key=>$data){
            if(!empty($data['loan_for']) && ($data['loan_for']=='2'))
            {
                $casetype = 'Used Car '.$data['loan_type'];
            }
            else
            {
                $casetype = 'New Car '.$data['loan_type'];  
            }


             if (!empty($data['tag_flag']) && $data['tag_flag'] == '4') {
                $status = 'Disbursed';
        }
        if (!empty($data['tag_flag']) && $data['tag_flag'] == '2') {
            $status = 'Approved';
        }
        if (!empty($data['tag_flag']) && $data['tag_flag'] == '3') {
            $status = 'Rejected';
        }
        if (!empty($data['tag_flag']) && $data['tag_flag'] == '1') {
            $status = 'Filed';

        }
        if ((!empty($data['tag_flag']) && ($data['tag_flag'] == '5')) || (empty($data['tag_flag']) && ($data['loan_approval_status'] == '5'))) {
            $status = 'Open';
        }
        if ((!empty($data['tag_flag']) && ($data['tag_flag'] == '6' || $data['tag_flag'] == '9' )) || ($data['loan_approval_status'] == '6' || $data['loan_approval_status'] == '9' ))  {
            if ($data['tag_flag'] == '6' || $data['loan_approval_status'] == '6') {
                $status = 'Washout on';
            }
            if ($data['tag_flag'] == '9' || $data['loan_approval_status'] == '9') {
                $status = 'Cancel on';
            }

            $reopen = '1';
        }
        if (!empty($data['loan_approval_status']) && ($data['loan_approval_status'] == '7' || $data['loan_approval_status'] == '8')) {
            if (!empty($data['upload_docs_created_at']) && $data['loan_approval_status'] == '7') {
                $status = 'Login Docs Collected';

            }
            if (!empty($data['upload_dis_created_date']) && $data['loan_approval_status'] == '8') {
                $status = 'Disbursed Docs Collected';

            }
        }
        if (!empty($data['loan_approval_status']) && ($data['loan_approval_status'] == '11')) {
            $status = 'Payment Completed';
        }

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $count, (!empty($data['sr_no'])? $data['sr_no'] : '--' ));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $count, (!empty($data['name'])? $data['name'] : '---' ));
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $count, (!empty($data['customer_mobile'])? $data['customer_mobile'] : '--' ));
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $count, (!empty($data['dealer_detail'])? $data['dealer_detail'] : '--' ));
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $count, (!empty($data['sales_exe'])? $data['sales_exe'] : '--' ));
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $count, (!empty($data['assigned_to'])? $data['assigned_to'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $count, (!empty($casetype)? $casetype : '--' )  );
            if(!empty($data['parent_makeName'])){
               $make = $data['parent_makeName']; 
            }else{
                $make = $data['make_name'];
            }
            
            if(!empty($data['parent_modelName'])){
               $model = $data['parent_modelName']; 
            }else{
               $model = $data['model_name'];
            }

            if(!empty($data['ref_id']))
            {
                $loc = $data['ref_id'];
            }
            if(!empty($data['loanno']))
            {
                $loc .= ' / '.$data['loanno'];
            }

            if(!empty($data['disbursed_amount']))
            {
                $loandisbusamount = $data['disbursed_amount'];
            }
            else if(!empty($data['approved_loan_amt']))
            {
                $loandisbusamount = $data['approved_loan_amt'];
            }
            else if(!empty($data['file_amount']))
            {
                $loandisbusamount = $data['file_amount'];
            }
            else if(!empty($data['loan_amt']))
            {
                $loandisbusamount = $data['loan_amt'];
            }

            if(!empty($data['disbursed_roi']))
            {
                $roi = $data['disbursed_roi'];
            }
            else if(!empty($data['approved_roi']))
            {
                $roi = $data['approved_roi'];
            }
            else if(!empty($data['file_roi']))
            {
                $roi = $data['file_roi'];
            }
            else if(!empty($data['roi']))
            {
                $roi = $data['roi'];
            }


            if(!empty($data['disbursed_tenure']))
            {
                $tenure = $data['disbursed_tenure'];
            }
            else if(!empty($data['approved_tenure']))
            {
                $tenure = $data['approved_tenure'];
            }
            else if(!empty($data['file_tenure']))
            {
                $tenure = $data['file_tenure'];
            }
            else if(!empty($data['tenor']))
            {
                $tenure = $data['tenor'];
            }

            if(!empty($data['counter_emi']))
            {
                $type='1';
            }
             $emi =CalculateEmi($loandisbusamount,$tenure,$roi,$type);
            if(!empty($data['disburse_emi']))
            {
                $emi = $data['disburse_emi'];
            }
            $disbursed_date = (!empty($data['disbursed_date']) && ($data['disbursed_date']!='0000-00-00 00:00:00'))?date('d M, Y',strtotime($data['disbursed_date'])):'';
           
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $count, ($make." ".$model." ".$data['version_name']));
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $count, ($data['regno']));
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $count, (!empty($data['financer_name'])?$data['financer_name']:'--'));
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $count, (!empty($loc)?$loc : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $count, 'Rs '.(!empty($loandisbusamount)? indian_currency_form($loandisbusamount).' ' : '0' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $count, (!empty($roi)) ?$roi.'%' : '--'   );
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $count, (!empty($tenure))?$tenure : '--'   );
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $count, ((!empty($emi) && ($emi!='NAN'))? indian_currency_form($emi) : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $count, ( (!empty($disbursed_date) ) ) ?$disbursed_date : '--'   );
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $count, ( (!empty($status) ) ) ?$status : 'Open'   );
            $insuranceBy = "";
            $loandisbusamount = 0;
            $make = "";
            $model = "";
            $casetype = '';
            $loc='';
            $roi= '';
            $tenure = '';
            $emi = '';
            $status='';
            $disbursed_date='';
            $type=0;
            $count++;
            $status ='';
        }
    }
    return $objPHPExcel;
}
    
