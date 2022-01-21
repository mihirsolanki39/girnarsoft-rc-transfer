<?php
//class buyer_excel_helper extends CI_Controller {
//    
//    public function __construct() {
//    parent::__construct();
//    }   
function exportBuyerLeadData($leadData, $type) {
    $fileType=array('futurefollow'=>'Finalized','pastfollow'=>'Walk-Ins','todayfollow'=>'Follow-UP','noaction'=>'New','all'=>'All','closed'=>'Closed','converted'=>'Converted',);
    $objPHPExcel = new PHPExcel();
    $filename = "Buy-Leads-" ;//. $fileType[$type] . '-' . date('d-F-Y') . ".xls";
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel = makeExcelHeader($objPHPExcel);
    $objPHPExcel = makeExcelRows($objPHPExcel, $leadData);
    $objPHPExcel->getActiveSheet();
    $objPHPExcel->getActiveSheet()->setTitle('Buyer Enquiery Report');
    $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
    ob_end_clean();
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Cache-Control: max-age=0");
    $objWriter->save('php://output');
    exit();
}

 function makeExcelHeader($objPHPExcel){
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Customer Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Mobile Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Alt Mobile Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Customer Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Creation Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Car Details');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Requirements');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Follow up Date ');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Comment');
        //$objPHPExcel->getActiveSheet()->getColumnDimension('F1')->setWidth(200);
       // $objPHPExcel->getActiveSheet()->getColumnDimension('G1')->setWidth(200);
        $objPHPExcel->getActiveSheet()->getStyle("A1:J1")->getFont()->setBold(true);
        return $objPHPExcel;
    }
    
     
    
    function makeExcelRows($objPHPExcel,$data){
            $count=2;
            foreach ($data as $key=>$value){
            $customerName=($value['name'])?$value['name']:'NA';
            if(!empty($value['history']))
            {
            $comment     = getCommentText($value['history']);
            }else{
            $comment     = '';    
            }
            if(!empty($value['preferences']))
            {
            $requirement = getRequirement($value['preferences']);
            }
            else
            {
            $requirement ='';
            }
            $followUpDate='';
            if(isset($value['followDate']) && $value['followDate']!='' && $value['followDate']!='0000-00-00 00:00:00'){
             $followUpDate=date('d-m-Y',strtotime($value['followDate']));
            }
            $leadCreatedDate=date('d-m-Y',strtotime($value['leadCreatedDate']));
            $carList=getCarList($value['car_list']);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $count, $customerName);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $count, $value['number']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $count, $value['alt_number']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $count, $value['emailID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $count, $leadCreatedDate);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $count, $carList);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $count, $requirement);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $count, $value['lead_status']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $count, $followUpDate); //
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $count, $comment);
            
            $count++;
            }
        return $objPHPExcel;
    }
    
    function getCommentText($data){
           if( !empty($data) && $data[0]['comment']){
             $comment=$data[0]['comment']['comment_text'];
            }else if (!empty($data) &&  $data[0]['feedback']){
                $comment=$data[0]['feedback'];
            }
            else if (!empty($data) &&  $data[1]['comment']){
                $comment=$data[1]['comment']['comment_text'];
            }
            else if (!empty($data) &&  $data[1]['feedback']){
                $comment=$data[1]['feedback'];
            }else {
                $comment='NA';
            }
            return $comment;
    }
    
    function getRequirement($data){
        $requirement='';
        if($data['budget']){
            $requirement.= no_to_words($data['budget']).'|';
        }
        if($data['bodyType']){
            $requirement.=implode(",",$data['bodyType']).'|';
        }
        if($data['fuelType']){
            $requirement.=$data['fuelType'].'|';
        }
        if($data['transmission']){
            $requirement.=$data['transmission'].'|';
        }
        if($data['makeIds']){
            $requirement.=  $this->Make_model->getMakeName(implode(',',$data['makeIds'])).'|';
        }
         if($data['modelIds']){
            $requirement.=  $this->Make_model->getMakeModelName(implode(',',$data['modelIds'])).'|';
        }
        $requirement=substr($requirement,0,-1);
        if(!$requirement){
            $requirement='';
        }
        return $requirement;
    }
    
    function getCarList($car){
      $carData='';
      if(!empty($car[0])){
          $carData .=$car[0]['make']."|".$car[0]['model']."|".$car[0]['version']."| ";
          $price=$car[0]['price'];
          $regno=$car[0]['regno'];
          $km=$car[0]['km'];
           if($regno){
             $carData .= $regno.'|';
         }
          if(!empty($price)){
              if($price >= 100000)
                {
                    if(($price%100000) == 0) {
                         $carData .= ($price/100000);
                    } else {
                         $carData .= number_format(($price/100000),2);
                    }
                }
              else {
              $carData .=$price;
              }
              $carData .=' Lakh | ';
          }
        
         if($km){
             $carData .= $km.' kms | ';
         }
         if(!empty($car[0]['month']) || !empty($car[0]['year'])){
             $carData .= $car[0]['month'].$car[0]['year'].' |';
         }
         $carData=substr($carData,0,-1);
      }else {
          $carData='';
      }
      return $carData;
  }
//}