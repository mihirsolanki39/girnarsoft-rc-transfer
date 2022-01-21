<?php

function exportInsData($Data,$filename,$dealerInfo = array()) {
    $objPHPExcel = new PHPExcel();
    $objPHPExcel = makeExcelHeader($objPHPExcel);
    $objPHPExcel = makeExcelRows($objPHPExcel,$Data,$dealerInfo);
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
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Customer name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Contact No');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Dealer name');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Make Model Version');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'reg No');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'CC');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Insurance category');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Policy No');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Policy Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Insurance company');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Issue Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Inception Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Due Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'IDV');
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'OD');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Premium');
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Payment to Ins Comp');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Clearance Payment');
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Subvention');
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Assigned to');
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Status');
        $objPHPExcel->getActiveSheet()->getStyle("A1:V1")->getFont()->setBold(true);
        return $objPHPExcel;
    }
    
     
    
function makeExcelRows($objPHPExcel,$insdata,$dealerInfo){
        if(!empty($insdata)){
        $count=2;
        $npaymentString = "";
        $cpaymentString = "";
        $totalInhousePayment = 0;
        $totalClearancePayment = 0;
        $tot = 0;
        foreach ($insdata as $key=>$data){
            $mi_fu = '';
            $mi_fu = ($data['mi_funding']=='1') ?'MI Funding':((!empty($data['npayment_mode']) )  ? $data['npayment_mode'] : '--' );
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $count, (!empty($data['sno'])? $data['sno'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $count, (!empty($data['customer_name'])? $data['customer_name'] : (!empty($data['customer_company_name'])? $data['customer_company_name'] : '--' ) )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $count, (!empty($data['customer_mobile'])? $data['customer_mobile'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $count, (!empty($data['dealerName'])? $data['dealerName'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $count, $data['make']." ".$data['model']." ".$data['version']  );
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $count, (!empty($data['regNo'])? $data['regNo'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $count, (!empty($data['cc'])? $data['cc'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $count, (!empty($data['insurance_category_name'])? $data['insurance_category_name'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $count, (!empty($data['current_policy_no'])? $data['current_policy_no'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $count, (!empty($data['current_policy_type'])? $data['current_policy_type'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $count, (!empty($data['prev_policy_insurer_name'])? $data['prev_policy_insurer_name'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $count, (!empty($data['current_issue_date'])? $data['current_issue_date'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $count, (!empty($data['inception_date'])? $data['inception_date'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $count, (!empty($data['due_date'])? $data['due_date'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $count, (!empty($data['idv'])? $data['idv'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $count, (!empty($data['own_damage'])? $data['own_damage'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $count, (!empty($data['premium'])? $data['premium'] : '--' )  );
            /*$objPHPExcel->getActiveSheet()->SetCellValue('P' . $count, ( ( ($data['payment_by'] == 2 ) && (!empty($data['in_payment_date']) ) ) ? $data['in_payment_date'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $count, ( ( ($data['payment_by'] == 2 ) && (!empty($data['in_payment_mode']) ) )  ? $data['in_payment_mode'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $count, ( ($data['payment_by'] == 1 || $data['payment_by'] == 2 ) && (!empty($data['payment_date'] ) )? $data['payment_date'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $count, ( ($data['payment_by'] == 1 || $data['payment_by'] == 2 ) && !empty($data['payment_mode'])? $data['payment_mode'] : '--' )  );*/
            if(count($data['npayment']) > 0){
            $i = 1;
            foreach($data['npayment'] as $npayment){
            if($npayment['payment_by'] == 2){
            $totalInhousePayment += $npayment['amount'];    
            }    
            $paymentBy = (!empty($npayment['payment_by'])? ( $npayment['payment_by']==1? 'Customer' : ( $npayment['payment_by']==2? 'Inhouse' : ( $npayment['payment_by']==3? (!empty($dealerInfo['ins_sis_comp'])?$dealerInfo['ins_sis_comp']:'') : '' ) )  ) : '');    
            $npaymentString .= $i.") ".date('d M Y', strtotime($npayment['date']))." | ".$paymentBy." | Rs.".$npayment['amount']." | ".$npayment['mode']." (".$npayment['instrument_no']." ) \n";  
            $i++;
            }    
            }
            if(count($data['cpayment']) > 0){
            $i = 1;
            foreach($data['cpayment'] as $cpayment){
            $totalClearancePayment += $cpayment['amount'];    
            $paymentBy = (!empty($cpayment['payment_by'])? ( $cpayment['payment_by']==1? 'Customer' : ( $cpayment['payment_by']==2? 'Inhouse' : ( $cpayment['payment_by']==3? (!empty($dealerInfo['ins_sis_comp'])?$dealerInfo['ins_sis_comp']:'') : '' ) )  ) : '');    
            $cpaymentString .= $i.") ".date('d M Y', strtotime($cpayment['date']))." | ".$paymentBy." | Rs.".$cpayment['amount']." | ".$cpayment['mode']." (".$cpayment['instrument_no']." ) \n";  
            $i++;
            }   
            }
            if(!empty($data['mi_funding']) && $data['mi_funding'] == 1)
                $mi_funding = "MI Funding";
            else
                $mi_funding = "--";
            
            $tot = $totalInhousePayment - $totalClearancePayment;
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $count, ( (!empty($npaymentString) ) ) ? $npaymentString : $mi_funding);
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $count, ( (!empty($cpaymentString) ) ) ? $cpaymentString : '--'   );
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $count, ( $tot != 0 )? "Rs. ".$tot : 0);
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $count, ( !empty($data['assignedto_name']))? $data['assignedto_name'] : '--'   );
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $count, (!empty($data['updateStatus'])? $data['updateStatus'] : '--' )  );
            
            $npaymentString = "";
            $cpaymentString = "";
            $totalClearancePayment = 0;
            $totalInhousePayment = 0;
            $tot = 0;
            $count++;
        }
    }
    return $objPHPExcel;
}
    
