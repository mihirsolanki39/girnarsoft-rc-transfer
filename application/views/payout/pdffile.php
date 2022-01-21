<?php

  $dealership = ORGANIZATION;
  $address = DEALER_ADDRESS;
  $mobile = MOBILESMS;
//$exp_payment_date=date('d/m/Y',strtotime($usedCarInfo['exp_payment_date']));
$rupeesImage=base_url('assets/images/rupee-icon.png');
$CI =& get_instance();
//$CI->Payout_cases->method_name();
$payout_Detail['payment_date'] = !empty($payout_Detail['payment_date']) ?  date('d M, Y', strtotime($payout_Detail['payment_date'])): "";

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
                              <td>: &nbsp; '.$payout_Detail["organization"].'</td>
                              <td><strong>Payment Mode</strong></td>
                              <td>:  &nbsp; '.PAYMENT_MODE[$payout_Detail["payment_mode"]].'</td>
                           </tr>
                           <tr>
                              <td><strong>Sales Exec.</strong></td>
                              <td>: &nbsp;  '.ucwords(strtolower($payout_Detail["name"])).'</td>
                              <td><strong>Bank</strong></td>
                              <td>: &nbsp; '.$payout_Detail["customer_bank"].'</td>
                           </tr>
                           <tr>
                              <td><strong>Date</strong></td>
                              <td>: &nbsp; '.$payout_Detail["payment_date"].'</td>
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
                        <th style="width:14%">Disb. Date</th>
                        <th style="width:23%">Customer &amp; Car Details</th>
                        <th style="width:24%">Loan Details</th>
                        <th style="width:26%">Disbursment Details</th>
                        <th style="width:5%">Payout %</th>
                        <th style="width:13%">Payout Amt.</th>
                     </tr>';
                     foreach($case_details as $case_detail) {
                     $loan_for = ($case_detail['loan_for']=='2')?'Used Car':'New Car';
                     if(empty($case_detail['disbursed_amount'])){
                        $disbur = (empty($case_detail['approved_loan_amt'])? $case_detail['file_loan_amount']:$case_detail['approved_loan_amt']);
                    }else{
                        $disbur = $case_detail['disbursed_amount'];
                    }
                    $disbur = !empty($case_detail['loan_amount'])?$case_detail['loan_amount']:$disbur;
                    $case_detail["payment_amount"] = !empty($case_detail["payment_amount"])?$case_detail["payment_amount"]:"0";
                    $case_detail["approved_emi"] = !empty($case_detail["approved_emi"])?$case_detail["approved_emi"]:"0"; 
                    $case_detail['disbursed_date'] = !empty($case_detail['disbursed_date']) ?  date('d M, Y', strtotime($case_detail['disbursed_date'])): "";
                        
                    $html .= '<tr>
                        <td>'.$case_detail["disbursed_date"].'</td>
                        <td>
                          '.ucwords(strtolower($case_detail["name"])).'
                           <div><strong>'. $case_detail["make_name"].' '. $case_detail["model_name"].' '.$case_detail["version_name"].'</strong></div>'; 
                           if(!empty($case_detail["regno"])){
                    $html .= '<div>'.strtoupper($case_detail["regno"]).'</div>';
                           }
                    $html .= '</td>
                       
                        <td>
                           <div><strong>'.$case_detail["financer_name"].'</strong></div>
                           <div><span style="">Application No</span><span style="">: '.$case_detail["ref_id"].'</span></div>
                           <div>'.$loan_for ." ". $case_detail["loan_type"].'</div>
                          
                        </td>
                        <td>
                           <div><span style="">Loan Amount</span><span style="">: <img src="'.$rupeesImage.'"  alt="" title="" style="width:8px; margin-top:4px;">'.$CI->IND_money_format($disbur).'</span></div>
                           <div><span style="">Rate</span><span style="">:'.$case_detail["approved_roi"].'%</span><span style="">&nbsp; Tenure:</span><span style="">'.$CI->IND_money_format($case_detail["approved_tenure"]).'</span></div>
                          ';
                            if($case_detail["approved_emi"] > 0){                        
                                 $html .= '<div>Adv. EMI</div>
                                   <div><span style="">EMI</span><span style=""> <img src="'.$rupeesImage.'"  alt="" title="" style="width:8px; margin-top:4px;">'.$CI->IND_money_format($case_detail["approved_emi"]).'
                                       </span></div>';                   
                            }
                       $html .= '</td>
                        <td>'.$case_detail["final_payout"].'%</td>
                        <td><img src="'.$rupeesImage.'"  alt="" title="" style="width:8px; margin-top:3px;">'.$CI->IND_money_format($case_detail["payment_amount"]).'</td>
                     </tr>';

                     }
                  
                  $html .= '</tbody>
               </table>
            </td>
         </tr>

         <tr>
            <td>
               <table  style="width: 100%;padding-top:20px;">
                 
                  <tr>
                     <td>
                        <table style="width: 100%; font-size:14px;border-bottom:2px dashed #ddd">
                                                
                        <tr>                 
                          <td style="text-align:right;width:80%;">Subtotal</td>
                          <td style="text-align:right;width:20%;padding-bottom:10px;"><strong><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:4px;">'.$CI->IND_money_format($payout_Detail["total_amount"]).'</strong>';
                          if($payout_Detail['gst_type'] == 2){
                               $html .= ' <span style="display:block; font-size:12px;">(Including GST)</span>';
                          }
                          $html .= '  </td>
                        </tr>
                        
                          
                        </table>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>







     <tr>
            <td>
               <table align="right"  style="width:50%;padding-top:30px;">
                  <tbody>
                  <tr>
                       <td style="text-align:right">&nbsp;</td>
                       <td style="text-align:right">Price Breakup</td>
                     </tr>
                     
                    
                     <tr>
                       <td style="text-align:right;padding-top:10; width:60%;">Total</td>
                       <td style="text-align:right;padding-top:10;width:40%;"><strong><img src="'.$rupeesImage.'"  alt="" title="" style="width:8px; margin-top:3px;">'.$CI->IND_money_format($payout_Detail["gst_excluded_amount"]).'</strong></td>
                     </tr>';
                    if($payout_Detail['gst_type'] == 2){
                    $html .= '<tr>
                       <td style="text-align:right;padding-top:5; width:60%;">GST</td>
                       <td style="text-align:right;padding-top:5;width:40%;"><strong>+<img src="'.$rupeesImage.'"  alt="" title="" style="width:8px; margin-top:3px;">'.$CI->IND_money_format($payout_Detail["gst_amount"]).'</strong></td>
                     </tr>';
                    }
                    if($payout_Detail['tds_type'] == 2){
                     $html .= '<tr>
                       <td style="text-align:right;padding-top:5; width:60%;">TDS</td>
                       <td style="text-align:right;padding-top:5;width:40%;"><strong>-<img src="'.$rupeesImage.'"  alt="" title="" style="width:8px; margin-top:3px;">'.$CI->IND_money_format($payout_Detail["tds_amount"]).'</strong></td>
                     </tr>';
                    }
                      $html .= '<tr>
                       <td style="text-align:right;padding-top:5; width:60%;">PDD Charges</td>
                       <td style="text-align:right;padding-top:5;width:40%;"><strong>-<img src="'.$rupeesImage.'"  alt="" title="" style="width:8px; margin-top:3px;">'.$CI->IND_money_format($payout_Detail["pdd_charge_total"]).'</strong></td>
                     </tr>

                     <tr>
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

