<?php

function exportDoData($Data,$filename) {
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
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Do No');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'DO DATE');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'DATE OF DELIVERY');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'CUSTOMER NAME');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'CONTACT NO. OF CUSTOMER');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'DEALER NAME');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'SALES EXECUTIVES');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'ARRANGE BY');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'VEHICLE DETAIL');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'SHOWROOM NAME');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Loan Reference No');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'HYPOTHECATION');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Showroom Discount');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Discount Shared');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Net DO AMT. ');
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'INSURANCE DONE BY');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Showroom Balance');
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Customer Balance');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Do Status');
        $objPHPExcel->getActiveSheet()->getStyle("A1:S1")->getFont()->setBold(true);
        return $objPHPExcel;
    }
    
     
    
function makeExcelRows($objPHPExcel,$insdata){
        if(!empty($insdata)){
        $count=2;
        $insuranceBy = "";
        $sumshow1 = 0;
        $loandisbusamount = 0;
        $sumshow2 = 0;
        $showroomSum = 0;
        $customerSum = 0;
        $make = "";
        $model = "";
        $sumshtoInhouse = 0;
        foreach ($insdata as $key=>$data){
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $count, (!empty($data['orderId'])? $data['orderId'] : '--' ));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $count, (!empty($data['do_date'])? $data['do_date'] : '---' ));
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $count, (!empty($data['delivery_date'])? $data['delivery_date'] : '--' ));
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $count, (!empty($data['customer_name'])? $data['customer_name'] : '--' ));
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $count, (!empty($data['customer_mobile_no'])? $data['customer_mobile_no'] : '--' ));
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $count, (!empty($data['dealer_name'])? $data['dealer_name'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $count, (!empty($data['sales_exe'])? $data['sales_exe'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $count, (!empty($data['employeeName'])? $data['employeeName'] : '--' )  );
            if(!empty($data['parent_makeName'])){
               $make = $data['parent_makeName']; 
            }else{
                $make = $data['makeName'];
            }
            
            if(!empty($data['parent_modelName'])){
               $model = $data['parent_modelName']; 
            }else{
               $model = $data['modelName'];
            }
            
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $count, ($make." ".$model." ".$data['versionName']));
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $count, (!empty($data['dealerName'])? $data['dealerName'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $count, (!empty($data['application_no'])? $data['application_no'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $count, (!empty($data['financer_name'])? $data['financer_name'] : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $count, (!empty($data['showroom_disc'])? indian_currency_form($data['showroom_disc']) : '--' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $count, (!empty($data['scheme_disc'])? indian_currency_form($data['scheme_disc']) : '0' )  );
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $count, ( (!empty($data['do_amt']) ) ) ?$data['do_amt'] : '--'   );
            if(!empty($data['insurance']) && $data['insurance'] > 0){
               if($data['insurance'] == 1){
                 $insuranceBy = "Showroom";  
               }else if($data['insurance'] == 2){
                 $insuranceBy = "Inhouse";  
               }else if($data['insurance'] == 3){
                 $insuranceBy = "Dealer";  
               }else{
                 $insuranceBy = "---";  
               } 
               
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $count, ($insuranceBy));
            
            
            if(!empty($data['payment_1']) && count($data['payment_1']) > 0){
                foreach($data['payment_1'] as $x => $pay1){
                 $sumshow1 += $pay1['amount'];    
                }
            }
            if(isset($data['loanDetail']) && !empty($data['loanDetail'])){
                 if(!empty($data['loanDetail']['gross_net_amount']))
            {
                $loandisbusamount = $data['loanDetail']['gross_net_amount'];
            }
            else if(!empty($data['loanDetail']['disbursed_amount']))
            {
                $loandisbusamount = $data['loanDetail']['disbursed_amount'];
            }
            else if(!empty($data['loanDetail']['approved_loan_amt']))
            {
                $loandisbusamount = $data['loanDetail']['approved_loan_amt'];
            }
            else if(!empty($data['loanDetail']['file_amount']))
            {
                $loandisbusamount = $data['loanDetail']['file_amount'];
            }
            }
             if(!empty($data['payment_2']) && count($data['payment_2']) > 0){
                foreach($data['payment_2'] as $y => $pay2){
                    if($pay2['payment_by'] == '1')
            {
                $sumshow2 = $sumshow2 + $pay2['amount'];
            }
          ########added in showroom balance start By Masawwar ali
            if(($pay2['payment_by'] =='3') && $pay2['entry_type']=='2'){
              $sumshtoInhouse = $sumshtoInhouse + $pay2['amount'];
            }
          ########added in showroom balance end   By Masawwar ali 
                }
            }
            $showroomSum = (int)$data['gross_do_amt'] - ((int)$data['showroom_disc'] + (int)$loandisbusamount + (int)$sumshow1) + (int)$sumshtoInhouse;
            $customerSum = ((int)$data['gross_do_amt'] - ((int)$data['scheme_disc'] + (int)$loandisbusamount + $sumshow2)) + $data['insu_premium'];
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $count, (indian_currency_form($showroomSum)));
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $count, (indian_currency_form($customerSum)));
            $status = '';
            if($data['do_updated_status']=='1' && $data['cancel_id']==0){
              $status = 'Do Generated';
            }else if($data['do_updated_status']=='2' && $data['cancel_id']==0){
              $status = 'Completed Payment';
            }else if($data['cancel_id']!=0){
              $status = 'Cancelled';
            }else{
              $status = 'NA';  
            } 
             $objPHPExcel->getActiveSheet()->SetCellValue('S' . $count, $status);
            $customerSum = 0;
            $showroomSum = 0;
            $sumshow1 = 0;
            $sumshow2 = 0;
            $loandisbusamount = 0;
            $insuranceBy = "";
            $make = "";
            $model = "";
            $sumshtoInhouse = 0;
            $count++;
        }
    }
    return $objPHPExcel;
}
    
