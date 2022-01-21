<?php
if(!empty($CustomerInfo)){
    $addOn = 0;
    $car_detail = $CustomerInfo;
    $case_type = ($car_detail['ins_category']=='2')?'Used Car':(($car_detail['ins_category']=='1')?'New Car':'');
    $customerName = (!empty($caseData['customer_name']))?$caseData['customer_name']:$caseData['customer_company_name'];
    $reg_no = !empty($car_detail['regNo'])?strtoupper($car_detail['regNo']):'NA';
    $make = $car_detail['makeName'];
    $model = $car_detail['modelName'];
    $version = $car_detail['versionName'];
    $fuel_type = $car_detail['uc_fuel_type'];
    $reg_year = $car_detail['reg_year'];
    $regdate = (!empty($car_detail['reg_date']) && $car_detail['reg_date']!='0000-00-00') ? date("F, Y", strtotime($car_detail['reg_date'])) :'NA';
    //$reg_month = (($car_detail['reg_month']!='') && ($car_detail['reg_year']!='')) ? date("F, Y", strtotime($date)) : 'NA';
    $date = '01-' . $car_detail['make_month'] . '-' . $car_detail['make_year'];
    $mm = date("F, Y", strtotime($date));
    $quoteDatetime=$car_detail[0]['added_on'];
    $quoteNcbPercentage=(!empty($car_detail['ncb_disc']))? $car_detail['ncb_disc'].'%':'NA' ;
    $quoteDateArr=explode(" ",$quoteDatetime);
    $quoteDate=date('d M Y',strtotime($quoteDateArr[0]));
    $quoteTime=date('H:i:s',strtotime($quoteDateArr[1]));
    $policy_type=$car_detail['policy_type'];
    $rupeesImage=base_url('assets/images/rupee-icon.png');
    $banner = base_url('assets/images/banner1.jpg');
    $logos = base_url('assets/images/logo.png');

    $html = '<!doctype html><html>
 
    <style>
    body {
        margin: 0;
        padding: 0;
        color: #000;
        font-family: Arial, Helvetica, sans-serif;
        width: 660px;
        font-size:14px;
        opacity:.87;
    }
    @page { size: 660px 930px; margin: 0px;}
    
    .clear {
        clear: both;
    }
    
    img {
        border: 0;
        outline: 0;
    }
    
    .form-wrapper {
        width: 100%;
        margin: 0 auto;
        padding: 0;
    }
    
    .articles-cls {
        width: 100%;
        padding: 0px
    }
    .blank {
        page-break-after: always
    }
   footer{position:fixed; bottom:50px;left:30px; width:100%;}
    .pbrk{page-break-inside:avoid;}
   
    
    
   
   </style>
    <body style="font-family:Arial, Helvetica, sans-serif;">';
/*$html .= '    <footer>
    <table>
                   <tr>
                       <td class="list-label">Powered By</td>
                       <td class=" align-r"><img src="'.$logos.'" style="width:150px; alt="" class="footerlogo"/></td>
                   </tr>   
               </table>
       
      </footer>';*/
         $html.='<div class="form-wrapper">
                <table border="0" cellpadding="0" cellspacing="0" style="background:#ffffff;margin:0px auto; width:100%; max-width:630px; page-break-inside:avoid;">
                    <tbody>
                        <tr>
                            <td style="">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td style="">
                                                <a style="text-decoration:none;" href="#">
                                                    <img src="'.$banner.'" title="Axis Bank" alt="Axis Bank" style="width:660px; height:205px;"/>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 20px;">
                             <table>
                                    <tbody>
                                        <tr>
                                            <td style="font-size:14px; color:#000; opacity:.87; font-weight: 500;">Dear '.ucwords($customerName).',</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:14px;color:#000; opacity:.87;  padding-top: 5px;">Secure your 
                                                <b>'.$make . ' ' . $model . ' ' . $version.'</b> with one of the following plans provided by insurers
                                            </td>
                                        </tr>
                                    </tbody>
                             </table>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
                                    <tbody>
                                       <tr>
                                           <td style="padding-top:20px;">
                                                 <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                         <td width="45%">
                                                         <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tr>
                                                                <td  width="40%" style="color:#000; opacity:.87; font-size:12px;">Registration Number</td>
                                                                <td  width="60%" style="color:#000; opacity:.87;  font-size:12px;font-weight:bold; padding-left:35px;">'.$reg_no.'</td>
                                                            </tr>
                                                             <tr>
                                                                <td  width="40%" style="color:#000; opacity:.87; font-size:12px; padding-top:7px;">Registered In</td>
                                                                <td  width="60%" style="color:#000; opacity:.87;  font-size:12px;font-weight:bold; padding-top:7px; padding-left:35px;">'.$regdate.'</td>
                                                            </tr>
                                                          
                                                        </table>
   
                                                    </td>
   
                                                    <td width="55%">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tr>
                                                                <td  width="40%" style="color:#000; opacity:.87; font-size:12px;">Fuel Type</td>
                                                                <td  width="60%" style="color:#000; opacity:.87; font-weight:bold; font-size:12px;">'.$fuel_type.'</td>
                                                            </tr>
                                                             <tr>
                                                                <td  width="40%" style="color:#000; opacity:.87; font-size:12px; font-size:12px;padding-top:7px;">Manufactured In</td>
                                                                <td  width="60%" style="color:#000; opacity:.87;  font-size:12px;font-weight:bold; padding-top:7px;">'.$mm.'</td>
                                                            </tr>
                                                             <tr>
                                                                <td  width="40%" style="color:#000; opacity:.87; font-size:12px; font-size:12px;padding-top:7px;">NCB Provided</td>
                                                                <td  width="60%" style="color:#000; opacity:.87;  font-size:12px;font-weight:bold; padding-top:7px;">'.$quoteNcbPercentage.'</td>
                                                            </tr>
                                                        </table>
   
                                                    </td>
                                                    </tr>
                                                </table>
                                           </td>
                                       </tr>
                                    </tbody>
                                </table>   
                            </td>
                        </tr>
                        
                        
                    </tbody>
                </table>
                        
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style=" border: solid 1px #dcdee0;padding-top:8px">
                        <tr>
                            <td width="24%;" align="center" style=" border: solid 1px #dcdee0; background-color: #e4e9ed;height:30px;">INSURER</td>
                            <td width="46%;" align="left" style=" border: solid 1px #dcdee0; background-color: #e4e9ed;height:30px;"><span style="padding-left: 10px;"> IDV & Add Ons</span></td> 
                            <td width="30%;" align="left" style=" border: solid 1px #dcdee0; background-color: #e4e9ed;height:30px;"><span style="padding-left: 10px;">PREMIUM</span></td>
                        </tr>
                    </table>
';
                        foreach($allQuotesDetails as $key => $value)
                        {
                          $i=0;  
                          $insurer_name_trimmed = $value['insurer_name_trimmed'];
                          $img = $value['img']; 
                          $emailImg = $value['emailImg']; 
                          $idv = $value['idv'];
                          $zeroDap = $value['zeroDap'];
                          $totpremium = $value['totpremium'];
                          $final_od = $value['final_od'];
                          $addOn=$value['addOn'];
                          $third = $value['thirdParty'];
                          $gsts = $value['gsts'];
                          

                               $html .='<table border="0" cellpadding="0" cellspacing="0" width="100%" style=" background-color: #fbfdff;">
                    <tbody>
                    <tr>
                        <td width="24%;" align="center" style=" border: solid 1px #dcdee0; ">'.$img.'
                        <div class="" style="font-size:12px; text-align:center; margin-top:10px; font-weight:bold;">'.$insurer_name_trimmed.'</div>
                        </td>
                        <td  width="46%;" valign="top" style=" border: solid 1px #dcdee0;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding-top: 7px;padding-left: 10px;">
                                                       
                                                        <tr>
                                                            <td align="left" style="text-align: left; font-size: 12px; padding-top:5px;">
                                                                <div><span> IDV: </span>
                                                                <span><img src="'.$emailImg.'" style="padding-top:3px; width:10px; height:10px;"> </span>
                                                                <span style="vertical-align:top">'.$idv.'</span></div>
                                                            </td>
                                                        </tr>
                                                           <tr>
                                                            <td align="left" style="text-align: left; font-size: 12px; font-weight:bold; opacity:.87;padding-top:20px;">
                                                              Add Ons
                                                            </td>
                                                        </tr>
                                                      
                                                         <tr>
                                                            <td align="left" style="text-align: left; font-size: 12px; opacity:.54;padding-top:5px;padding-bottom:5px;">
                                                              '.$zeroDap.'
                                                            </td>
                                                        </tr>
                                                       
                                                    </table>
                                                </td> 
                                                <td  width="30%;" valign="top" style=" border: solid 1px #dcdee0;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding-top: 7px;padding-left: 10px;">
                                                        
                                                    
                                                        <tr>
                                                            <td>
                                                                 <table width="100%" cellpadding="0" cellspacing="0" border="0" style="">
                                                                    <tr>
                                                                        <td>
                                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="">
                                                                             <tr>
                                                                                <th align="left">Total</th>
                                                                                <th align="left"><img src="'.$emailImg.'" style="padding-top:3px; width:10px; height:10px;">'.$totpremium.'</th> 
                                                                              </tr>
                                                                              
                                                                              <tr>
                                                                                <td style="font-size:12px; opacity:.6; padding-top:10px;">Own Damage</td>
                                                                                 <td style="font-size:12px; opacity:.6;padding-top:10px;"><img src="'.$emailImg.'" style="padding-top:3px; width:8px; height:8px;">'.$final_od.'</td>
                                                                              </tr>
                                                                               <tr>
                                                                                <td style="font-size:12px; opacity:.6; padding-top:2px;">Add-ons</td>
                                                                                 <td style="font-size:12px; opacity:.6;padding-top:2px;"><img src="'.$emailImg.'"style="padding-top:3px; width:8px; height:8px;">'.$addOn.'</td>
                                                                              </tr>
                                                                             
                                                                               <tr>
                                                                                <td style="font-size:12px; opacity:.6; padding-top:2px;">Third Party</td>
                                                                                 <td style="font-size:12px; opacity:.6;padding-top:2px;"><img src="'.$emailImg.'" style="padding-top:3px; width:8px; height:8px;">'.$third.'</td>
                                                                              </tr>
                                                                               <tr>
                                                                                <td style="font-size:12px; opacity:.6; padding-top:2px;">GST</td>
                                                                                 <td style="font-size:12px; opacity:.6;padding-top:2px;"><img src="'.$emailImg.'" style="padding-top:3px; width:8px; height:8px;">'.$gsts.'</td>
                                                                              </tr>
                                                                              
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        ';
                                        $i++; 
                                        if($i==4 || $i==11){
                                       $html .='<tbody><tr><td style="height:5px;"></td></tr>';
                                     }
                                     $html .='</table>';
                        }
                                                  
                                                          
}else{
  $html='File Not Available';  
}

echo $html;

