<?php
  $dealership = ORGANIZATION;
  $address    = DEALER_ADDRESS;
  $mobile     = MOBILESMS;
  $rupeesImage = base_url('assets/images/rupee-icon.png');
  $CI          = & get_instance();
//$CI->Payout_cases->method_name();
  $payout_Detail['payment_date'] = !empty($payout_Detail['payment_date']) ?  date('d M, Y', strtotime($payout_Detail['payment_date'])): "";

  $salesExecutive = !empty($case_details[0]['salesExecutive'])?ucwords(strtolower($case_details[0]['salesExecutive'])):"NA";
  
  $html =
     '<!doctype html>
     <html>
     <body>
     <style>
       body {margin: 0;padding: 0;color: #000;font-family: Arial, Helvetica, sans-serif;width: 100%; font-size:12px;} 
       @page {margin-top: 25px;margin-bottom: 25px; margin-left: 25px;margin-right: 25px;}
        .clear { clear: both; }
       img { border: 0;outline: 0;}
       .form-wrapper { width: 100%;margin: 0 auto;padding: 0;}
       table, tr, td, {border-collapse: collapse; border-spacing:0; text-align:left;vertical-align:top;page-break-inside:avoid}
       .table td { border:1px solid #ddd; padding:5px 10px;}
       .table tr { border:1px solid #ddd;}
       .table th { border:1px solid #ddd;padding:5px 10px;text-align:left;vertical-align:middle; color: #8b8d8f;}
   </style>
   <body>
   <div class="form-wrapper">
   <table style="width: 100%">
      <tbody>
         <tr>
            <td>
               <table style="width: 100%;border-bottom:1px solid #ddd;">
                  <tr>
                     <td style="padding-bottom:10px; FONT-WEIGHT:BOLD; FONT-SIZE:30PX;">
                      <strong>'.$dealership.'</strong>
                     </td>
                     <td style="text-align:right; padding-bottom:10px;">
                        <span style="display:block;font-weight:bold;">Direct Selling Agent <span style="color:#979797"> | </span> Auto Loan</span>
                        <span style="display:block;line-height:1.47;padding-top:5px;">bcspl.hdfc@gmail.com</span>
                        <span style="display:block;">css.accounts@hotmail.com</span>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
         <tr>
            <td>
               <table  style="width: 100%;padding-top:20px;">
                  <tr>
                     <td style="font-size:14px; font-weight:bold;">Payout Statement <span style="font-size:12px; font-weight:normal">(Invoice No. '.$payout_Detail["id"].')</span></td>
                  </tr>
                  <tr>
                     <td>
                        <table cellpadding="0" cellspacing="5" style="width: 100%; padding-top: 10px; font-size:12px;">
                           <tr>
                              <td><strong>Dealership</strong></td>
                              <td>: &nbsp; '.$case_details[0]["dealerName"].'</td>
                              <td><strong>Payment Mode</strong></td>
                              <td>:  &nbsp; '.PAYMENT_MODE[$payout_Detail["payment_mode"]].'</td>
                           </tr>
                           <tr>
                              <td><strong>Sales Exec.</strong></td>
                              <td>: &nbsp;  '.$salesExecutive.'</td>
                              <td><strong>Bank</strong></td>
                              <td>: &nbsp; '.$payout_Detail["bank_name"].'</td>
                           </tr>
                           <tr>
                              <td><strong>Date</strong></td>
                              <td>: &nbsp; '.date('d M, Y', strtotime($payout_Detail["payment_date"])).'</td>
                              <td><strong>Instrument No.</strong></td>
                              <td>: &nbsp; '.$payout_Detail["instrument_no"].'</td>
                           </tr>
                        </table>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
         <tr>
            <td>
               <table  style="width:100%;padding-top:30px;" class="table table-condensed">
                  <tbody>
                     <tr>
                        <th style="width:14%">Issued Date</th>
                        <th style="width:23%">Customer &amp; Car Details</th>
                        <th style="width:29%">Policy Details</th>
                        <th style="width:11%">Payout %</th>
                        <th style="width:10%">Payout Amt.</th>
                        <th style="width:10%">Overdue Settled</th>
                     </tr>';
                     foreach($case_details as $case_detail) {

            $addOn = 0;
            if ($case_detail['road_side_assistance'] == '1') {
                $addOn = (int) $case_detail['road_side_assistance_txt'];
            }
            if ($case_detail['loss_of_personal_belonging'] == '1') {
                $addOn += (int) $case_detail['loss_of_personal_belonging_txt'];
            }
            if ($case_detail['emergency_transport_hotel_premium'] == '1') {
                $addOn += (int) $case_detail['emergency_transport_hotel_premium_txt'];
            }

            if ($case_detail['driver_cover'] == '1') {
                $driver_cover = (int) $case_detail['paid_driver'];
            }
            if ($case_detail['personal_acc_cover'] == '1') {
                $personal_acc_cover = (int) $case_detail['personal_acc_cover'];
            }
            if ($case_detail['passenger_cover'] == '1') {
                $passenger_cover = $case_detail['pass_cover'];
            }
            if ($case_detail['anti_theft'] == '1') {
                $addOn -= $case_detail['anti_theft_txt'];
            }
            if ($case_detail['add_on']) {
                $addOn += $case_detail['add_on'];
            }

                     $odamount = !empty($case_detail['own_damage'])?$case_detail['own_damage']:0;
                     $totalODandADONamount = ($odamount+$addOn);
                   


                    $case_detail['disbursed_date'] = !empty($case_detail['disbursed_date']) ?  date('d M, Y', strtotime($case_detail['disbursed_date'])): "";
                     
                     $name = '';
                     if($case_detail['buyer_type']==1){
                     $name =  $case_detail["customer_name"];
                     }else if($case_detail['buyer_type']==2){
                      $name = $case_detail["customer_company_name"];
                     }else{
                      $name ='NA';
                     }


                    $html .= '<tr>
                        <td>'.date('d M, Y', strtotime($case_detail["current_issue_date"])).'</td>
                        <td>

                          '.ucwords(strtolower($name)).'
                           <div><strong>'. $case_detail["makeName"].' '. $case_detail["modelName"].' '.$case_detail["versionName"].'</strong></div>'; 
                           if(!empty($case_detail["regNo"])){
                    $html .= '<div>'.strtoupper($case_detail["regNo"]).'</div>';
                           }
                    $html .= '</td>
                       
                        <td>
                           <div><strong>'.$case_detail["short_name"].'</strong></div>
                           <div>Policy No - '.$case_detail["current_policy_no"].'</div>
                           <div>IDV - <img src="'.$rupeesImage.'" alt="" title="" style="width:8px; margin-top:3px;"> '.$CI->IND_money_format($case_detail["insidv"]).'</div>

                           <div>OD + Add Ons - <img src="'.$rupeesImage.'" alt="" title="" style="width:8px; margin-top:3px;"> '.$CI->IND_money_format($totalODandADONamount).'</div>
                           <div>Premium - <img src="'.$rupeesImage.'" alt="" title="" style="width:8px; margin-top:3px;"> '.$CI->IND_money_format($case_detail["totalpremium"]).'</div>
                          
                        </td>
                        <td>'.$case_detail["final_payout"].'%</td>
                        <td><img src="'.$rupeesImage.'" alt="" title="" style="width:8px; margin-top:3px;">'.$CI->IND_money_format($case_detail["payment_amount"]).'</td>
                        <td><img src="'.$rupeesImage.'" alt="" title="" style="width:8px; margin-top:3px;">'.$CI->IND_money_format($case_detail["due_amount"]).'</td>
                     </tr>';

                     }

                     $html .=  ' <tr>
                        <td style="border:0"></td>
                        <td style="border:0"> </td>
                        <td style="border:0"></td>          
                         <td style="background:#f1f1f1">Sub Total</td>
                        <td style="background:#f1f1f1"><img src="'.$rupeesImage.'" alt="" title="" style="width:8px; margin-top:3px;">'.$CI->IND_money_format($payout_Detail["total_amount"]).'</td>
                        <td style="background:#f1f1f1"><img src="'.$rupeesImage.'" alt="" title="" style="width:8px; margin-top:3px;">'.$CI->IND_money_format($payout_Detail["total_due_amt"]).'</td>
                     </tr>';
                  
                  $html .= '</tbody>
               </table>
            </td>
         </tr>

         <tr>
            <td>
             
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
     <tr>
            <td>
               <table align="right"  style="width:50%;padding-top:30px;">
                  <tbody>';
                    $html .= '<tr>
                       <td style="text-align:right;padding-top:5; width:60%;"><strong>Net Payable Amount</strong></td>
                       <td style="text-align:right;padding-top:5;width:40%;"><strong><img src="'.$rupeesImage.'"  alt="" title="" style="width:8px; margin-top:3px;">'.$CI->IND_money_format($payout_Detail["amount"]).'</strong></td>
                     </tr> 
                  </tbody>
               </table>
            </td>
         </tr>



























       

      
      </tbody>
   </table>
</div>
   
   
   
   </body>
   </html>';
 


echo $html;

