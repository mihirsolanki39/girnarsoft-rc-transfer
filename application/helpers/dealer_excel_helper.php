<?php

function exportDealerData($leadData) {
    $objPHPExcel = new PHPExcel();
    $filename = "Dealer-list-" . date('d-F-Y') . ".xls";
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel = makeExcelHeader($objPHPExcel);
    $objPHPExcel = makeExcelRows($objPHPExcel, $leadData);
    $objPHPExcel->getActiveSheet();
    $objPHPExcel->getActiveSheet()->setTitle('Dealer List Report');
    $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
    ob_end_clean();
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Cache-Control: max-age=0");
    $objWriter->save('php://output');
    exit();
}

 function makeExcelHeader($objPHPExcel){
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Dealership Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Dealership Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Owner Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Category');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Sales Executive');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Status');
        $objPHPExcel->getActiveSheet()->getStyle("A1:F1")->getFont()->setBold(true);
        return $objPHPExcel;
    }
    
     
    
function makeExcelRows($objPHPExcel,$data){
            $count=2;
            foreach ($data as $key=>$value){
            $dealerName=($value['organization'])?$value['organization']:'NA';
            $dealerMobile=($value['mobile'])?$value['mobile']:'NA';
            $ownerName=($value['owner_name'])?$value['owner_name']:'NA';
            if(isset($value['dealer_type'])){
                if($value['dealer_type']=='0') {
                   $dealerType='Used car'; 
                }elseif($value['dealer_type']=='1') {
                   $dealerType='New Car'; 
                }elseif($value['dealer_type']=='2') {
                   $dealerType='Both'; 
                }
            }
            
            if($value['role_name']=='Executive'){    
            $assignUser=($value['assignuser'])?$value['assignuser']:'NA';
            }else{
             $assignUser='NA';   
            }
            if($value['status']=='1') {
                $dealerStatus='Active'; 
            }else{
               $dealerStatus='Inactive'; 
            }
            
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $count, $dealerName);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $count, $dealerMobile);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $count, $ownerName);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $count, $dealerType);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $count, $assignUser);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $count, $dealerStatus);
            $count++;
            }
        return $objPHPExcel;
    }
    
