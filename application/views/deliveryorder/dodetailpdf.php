<?php
if(!empty($orderinfo)){

$CI =& get_instance();
$rupeesImage=base_url('assets/images/rupee-icon.png');
$orderId      = $orderinfo['orderId'];
$dealerName   = (!empty($orderinfo['dealerOrganiser']) && ($orderinfo['deliverySource']=='1')) ? strtoupper($orderinfo['dealerOrganiser']) : '';
$salesName    = strtoupper($orderinfo['employeeName']);
#####Financial Details start
$loanId             = (!empty($orderinfo['application_no'])) ? $orderinfo['application_no'] : 'NA';
$bankName           = (!empty($loanDetail['financer_name'])) ? $loanDetail['financer_name'] : 'NA';
$loanAmount         = (!empty($loanDetail['loan_amount'])) ? $loanDetail['loan_amount'] :0;
$loan_deductions    = (!empty($orderinfo['dedu_loan'])) ? $orderinfo['dedu_loan'] : 0;
$loan_emi           = (!empty($loanDetail['disburse_emi'])) ? $CI->IND_money_format($loanDetail['disburse_emi']) : 0;
$roi_percent        = (!empty($loanDetail['disbursed_roi'])) ? $loanDetail['disbursed_roi'].'%' : 'NA';
$tenure             = (!empty($loanDetail['disbursed_tenure'])) ? $loanDetail['disbursed_tenure'].' m' : 'NA';
#####Financial Details end 
$showroomName = (!empty($orderinfo['organization'])) ? $orderinfo['organization'] : 'NA';
//$showroomAddress=(!empty($orderinfo['showroomAddress'])) ? $orderinfo['showroomAddress'] : 'NA';
if((!empty($orderinfo['insurance']) && $orderinfo['insurance']=='1'))
{
  $insurnace = 'Showroom';
}
if((!empty($orderinfo['insurance']) && $orderinfo['insurance']=='2'))
{
  $insurnace = 'Inhouse';
}
else
{
  $insurnace = 'Dealer';
}
$customer_name        = strtoupper($orderinfo['customer_name']);
$customer_mobile      = !empty($orderinfo['customer_mobile_no'])?$orderinfo['customer_mobile_no']:"NA";
$customer_kindattention =!empty($orderinfo['kind_attn'])?$orderinfo['kind_attn']:"NA"; 

$make_name    =  (!empty($orderinfo['parentmakeName'])) ? $orderinfo['parentmakeName'] : $orderinfo['makeName'];
$model_name   =  (!empty($orderinfo['parentmodelName'])) ? $orderinfo['parentmodelName'] : $orderinfo['modelName'];
$version_name =  (!empty($orderinfo['versionName'])) ? $orderinfo['versionName'] : '';
$do_no        =  (!empty($orderinfo['orderId'])) ? $orderinfo['orderId'] : '';
$gross_do_amt = !empty($orderinfo['gross_do_amt'])? $CI->IND_money_format($orderinfo['gross_do_amt']):0;
$netDoAmount  = !empty($orderinfo['net_do_amt'])? $CI->IND_money_format($orderinfo['net_do_amt']):0;
$ex_show      = !empty($orderinfo['ex_show'])? $CI->IND_money_format($orderinfo['ex_show']):0;
$tcs          = !empty($orderinfo['tcs'])? $CI->IND_money_format($orderinfo['tcs']):0;

$ins_premium          = !empty($orderinfo['do_insu_premium'])? $CI->IND_money_format($orderinfo['do_insu_premium']):0;
$do_external_warranty = !empty($orderinfo['do_external_warranty'])? indian_currency_form($orderinfo['do_external_warranty']):0;

$epc          = !empty($orderinfo['epc'])? $CI->IND_money_format($orderinfo['epc']):0;
$road_tax     = !empty($orderinfo['road_tax'])? $CI->IND_money_format($orderinfo['road_tax']):0;
//$createdDate  = date('d M, Y',strtotime($orderinfo['add_date']));
$do_date      = date('d M, Y',strtotime($orderinfo['do_date']));


$netDisbursalAmount = $CI->IND_money_format(($loanAmount -$loan_deductions));
$customer_discount  = (!empty($orderinfo['scheme_disc'])) ? $CI->IND_money_format($orderinfo['scheme_disc']) : 0;
$showroom_discount  = (!empty($orderinfo['total_showroom_discount'])) ? $CI->IND_money_format($orderinfo['total_showroom_discount']) : 0;
$insurance          = (!empty($orderinfo['insu_premium'])) ? $CI->IND_money_format($orderinfo['insu_premium']): 0;
$paymentbyCustomer  =  !empty($paymentbyCustomer['sum_amount'])? $CI->IND_money_format($paymentbyCustomer['sum_amount']):0; 
$paymentbyshowroom  =  !empty($paymentshow['sum_amount'])? $CI->IND_money_format($paymentshow['sum_amount']):0; 
$showroomBalance    =  !empty($showroom_total_balance)?$showroom_total_balance:0;
$customerBalance    =  !empty($inhouse_total_balance)? $inhouse_total_balance:0;
$html ='<!doctype html>
     <html>
     
     <body>
     
     <style>
     
       body {margin: 0;padding: 0;color: #000;font-family: Arial, Helvetica, sans-serif;width: 100%; font-size:12px;} 
       @page {margin-top: 25px;margin-bottom: 25px; margin-left: 25px;margin-right: 25px;}
        .clear { clear: both; }
       img { border: 0;outline: 0;}
       .form-wrapper { width: 100%;margin: 0 auto;padding: 0;}
       table, tr, td, {border-collapse: collapse; border-spacing:0; text-align:left;vertical-align:top;page-break-inside:avoid}
       .table td { border:1px solid #333; padding:2px 5px;}
       .table tr { border:1px solid #333;}
       .table th { border:1px solid #333;padding:2px 5px;text-align:left;vertical-align:middle; color: #000;background:#f3f3f3;}
       
       .table-new td { border:1px solid #333; padding:3px 5px; font-size:10px;}
       .table-new tr { border:1px solid #333;}
       .table-new th { border:1px solid #333;padding:3px 5px;text-align:left;vertical-align:middle; color: #000;background:#f3f3f3;font-size:11px;}
     
   </style>
   <body>
   <div class="form-wrapper">
      <table style="width: 100%">
         <tbody>
            <tr>
               <td>
                   <table style="width: 100%;border-bottom:1px solid #ddd;">
                     <tbody>
                        <tr>
                           <td style="padding-bottom:10px; font-weight:bold; font-size:24px;">
                            <strong>'.ORGANIZATION.'</strong>
                           </td>
                           <td style="text-align:right; padding-bottom:10px;">
                              <span style="display:block;font-weight:bold;">Direct Selling Agent <span style="color:#979797"> | </span> Auto Loan</span>
                              <span style="display:block;"></span>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
             <tr>
               <td>
                   <table style="width: 100%;padding-top:10px;">
                     <tbody>
                        <tr>
                           <td style="font-size:14px; font-weight:bold;">New Car delivery Statement</td>
                        </tr>
                        <tr>
                           <td style="padding-top:10px;">
                              <table cellpadding="3" cellspacing="3" style="width: 100%;  font-size:12px; border:1px solid #333">
                                 <tr>
                                    <td><strong>DO Number</strong></td>
                                    <td>: &nbsp; '.$do_no.'</td>
                                    <td><strong>DO Date</strong></td>
                                    <td>: &nbsp; '.$do_date.'</td>
                                 </tr>
                                 <tr>
                                    <td><strong>Customer Name</strong></td>
                                    <td>: &nbsp; '.$customer_name.'</td>';

                                    if($dealerName !=''){
                                   $html .=  '<td><strong>Dealer</strong></td>
                                    <td>: &nbsp; '.$dealerName.'</td>';
                                     }

                                 $html .= '</tr>
                                 <tr>
                                    <td><strong>Showroom</strong></td>
                                    <td>: &nbsp;'.$showroomName.'</td>
                                    <td><strong>Sales Executive</strong></td>
                                    <td>: &nbsp; '.$salesName.'</td>
                                 </tr>
                                  <tr>
                                    <td><strong>Car</strong></td>
                                    <td>: &nbsp; '.$make_name.' '.$model_name.' '.$version_name.'</td>
                                    <td><strong>DO Amount</strong></td>
                                    <td>: &nbsp; <img src="'.$rupeesImage.'" alt="" title="" style="width:8px; margin-top:3px;">'.$netDoAmount.'</td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
            
             <tr>
               <td>
                   <table style="width: 100%;padding-top:5px;">
                     <tbody>
                         <tr>
                           <td>
                            <table style="width: 100%;padding-top:5px;" >
                              <tbody>
                                 <tr>
                                       <td style="font-size:14px; font-weight:bold;background:#f3f3f3;padding:10px;">Delivery Order Break-Up
</td>
                                 </tr>
                             </tbody>
                            </table>
                           </td>
                        </tr>
                        
                        <tr>
                           <td>
                              <table cellpadding="8"  style="width: 100%;padding-top:5px;">
                                 <tr>
                                    <td style="width:50%">
                                       <table style="width:100%" class="table">
                                          <tbody>
                                             <tr>
                                                <th>Gross DO.</th>
                                                <th style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$gross_do_amt.'</th>
                                             </tr>
                                                <tr>
                                                   <td>Ex- Showroom</td>
                                                   <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$ex_show.'</td>
                                                </tr>
                                                <tr>
                                                   <td>Road Tax</td>
                                                   <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$road_tax.'</td>
                                                </tr>';                                              
                                                if($ins_premium != 0){
                                               $html .= '<tr>
                                                   <td>Insurance Premium</td>
                                                   <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$ins_premium.'</td>
                                                </tr>';
                                                }if($do_external_warranty != 0){
                                                
                                               $html .= '<tr>
                                                <td>Ext Warranty</td>
                                                   <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$do_external_warranty.'</td>
                                                </tr>';
                                                }
                                               $html .= '<tr>
                                                   <td>TCS</td>
                                                   <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$tcs.'</td>
                                                </tr>

                                                <tr>
                                                   <td>EPC</td>
                                                   <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$epc.'</td>
                                                </tr>';
                                                if(!empty($priceBreakup)){
                                                foreach($priceBreakup as $k => $v)
                                                {
                                                  $pname  = $v['p_name'];
                                                  $pvalue = !empty($v['p_price'])? $CI->IND_money_format($v['p_price']):0;//indian format
                                                  $html  .= '<tr>
                                                   <td>'.$pname.'</td>
                                                   <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$pvalue.'</td>
                                                </tr>'; 
                                                }
                                              }
                                         $html .= '</tbody>
                                       </table>
                                    </td>
                                    
                                    <td style="width:50%">
                                       <table cellpadding="8" style="width:100%" class="table">
                                          <tbody>
                                             <tr>
                                                <th colspan="2">Financial Details</th>
                                               
                                              
                                             </tr>
                                                <tr>
                                                   <td>Bank</td>
                                                   <td style="text-align:right">'.$bankName.'</td>
                                                </tr>
                                                <tr>
                                                   <td>Application No.</td>
                                                   <td style="text-align:right">'.$loanId.'</td>
                                                </tr>
                                                <tr>
                                                   <td>Loan Amount</td>
                                                   <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$CI->IND_money_format($loanAmount).'</td>
                                                </tr>
                                                <tr>
                                                   <td>Deductions</td>
                                                   <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$CI->IND_money_format($loan_deductions).'</td>
                                                </tr>
                                                 <tr>
                                                   <td>EMI</td>
                                                   <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$loan_emi.'</td>
                                                </tr>
                                                 <tr>
                                                   <td>ROI</td>
                                                   <td style="text-align:right">'.$roi_percent.'</td>
                                                </tr>
                                                <tr>
                                                   <td>Tenure</td>
                                                   <td style="text-align:right">'.$tenure.'</td>
                                                </tr>
                                          </tbody>
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
            <tr>
               <td>
                   <table style="width: 100%;padding-top:5px;">
                     <tbody>
                        <tr>
                           <td style="font-size:14px; font-weight:bold;">Balance Statement</td>
                        </tr>
                        
                        <tr>
                           <td>
                              <table  style="width: 100%;padding-top:5px;">
                                 <tr>
                                    <td>
                                       <table style="width:100%" class="table">
                                          <tbody>
                                             <tr>
                                                <th style="width:30%">&nbsp;</th>
                                                <th style="width:35%">Customer</th>
                                                <th style="width:35%">Showroom</th>
                                             </tr>
                                                 <tr>
                                                    <th>Gross Do.</th>
                                                    <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$gross_do_amt.'</td>
                                                    <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$gross_do_amt.'</td>
                                                  </tr>

                                                   <tr>
                                                    <th>Discount</th>
                                                    <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$customer_discount.'</td>
                                                    <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$showroom_discount.'</td>
                                                  </tr>

                                                  <tr>
                                                    <th>Net Disbursal Amount</th>
                                                    <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$netDisbursalAmount.'</td>
                                                    <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$netDisbursalAmount.'</td>
                                                  </tr>';
                          if(!empty($orderinfo['insurance']) && ($orderinfo['insurance']=='2')){

                              $html .= '<tr>
                                                    <th>Insurance</th>
                                                    <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$insurance.'</td>
                                                    <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">0</td>
                                                  </tr>';}
                                              
                                  
    
                                               $html .=    '<tr>
                                                    <th>Payment By Customer</th>
                                                    <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$paymentbyCustomer.'</td>
                                                    <td style="text-align:right">-</td>
                                                  </tr> 
                                                  <tr>
                                                    <th>Payment To Showroom</th>
                                                    <td style="text-align:right">-</td>
                                                    <td style="text-align:right"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;">'.$paymentbyshowroom.'</td>
                                                    
                                                  </tr>
                                                  <tr>
                                                    <th>Balance</th>
                                                    <td style="background:#f3f3f3; text-align:right;"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px; text-align:right;"><b>'.$customerBalance.'</b></td>
                                                    <td style="background:#f3f3f3;text-align:right;"><img src="'.$rupeesImage.'" alt="" title="" style="width:9px; margin-top:2px;"><b>'.$showroomBalance.'</b></td>
                                                  </tr>
                                          </tbody>
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
    
              <tr>
               <td>
                <table style="width: 100%;padding-top:15px;" >
                  <tbody>
                     <tr>
                           <td style="font-size:14px; font-weight:bold;background:#f3f3f3;padding:10px;">Payment Summary</td>
                     </tr>
                 </tbody>
                </table>
               </td>
            </tr>
             
            <tr>
            
               <td>
                   <table style="width: 100%;padding-top:5px;" >
                     <tbody>
                          <tr>
                           <td style="font-size:14px; font-weight:bold;">Payment To Showroom</td>
                        </tr>
                           <tr>
                              <td>
                                <table  style="width: 100%;padding-top:5px;" class="table-new">
                                 <tr>
                              <th>Payment By</th>
                              <th>Amt. Paid</th>
                              <th>Date of Payment</th>
                              <th>Payment Mode</th>
                              <th>Instrument Date</th>
                              <th>Instrument No.</th>
                              <th>Bank Name</th>
                              <th>Remark</th>
                           </tr>';
                           if(!empty($paymentshowroom)){
                           foreach($paymentshowroom as $k=>$showVal){
                             $showpaymentBy = "";
                            if($showVal['payment_by']=='1')
                                       {
                                          $showpaymentBy = "Customer";
                                        }else if($showVal['payment_by']=='2')
                                        {
                                           $showpaymentBy = "Inhouse";
                                        }
                                        else if($showVal['payment_by']=='3')
                                        {
                                            $showpaymentBy = "Bank";
                                        }
                            
                            $showPaidmount   = !empty($showVal['amount'])? $CI->IND_money_format($showVal['amount']):0;
                            $showPaymentdate = !empty($showVal['payment_date'])? date('d M, Y',strtotime($showVal['payment_date'])):0;
                            $showpayment_mode = "";
                            if($showVal['payment_mode']=='1')
                                       {
                                          $showpayment_mode = "Cash";
                                        }else if($showVal['payment_mode']=='2')
                                        {
                                            $showpayment_mode = "Cheque";
                                        }
                                        else if($showVal['payment_mode']=='3')
                                        {
                                            $showpayment_mode = "DD";
                                        }
                                        else if($showVal['payment_mode']=='4')
                                        {
                                            $showpayment_mode = "Online";
                                        }

                                        $showinstumentdate = "";
                                        if(!empty($showVal['instrument_date']) && $showVal['instrument_date'] != "0000-00-00"){
                                          if(($showVal['payment_mode'] != 1) && ($showVal['payment_mode'] != 4)){
                                            $showinstumentdate = date('d M, Y',strtotime($showVal['instrument_date']));
                                            }
                                          }
                                          $showInstrumentNo = "";
                                          if($showVal['payment_mode']!='1'){
                                           $showInstrumentNo = $showVal['instrument_no'];
                                          }
                                           $showPaymentbank_name = "";
                                          if(($showVal['payment_mode']=='2') || ($showVal['payment_mode']=='3')){
                                           $showPaymentbank_name = $showVal['bank_name'];
                                          }
                                         $showPaymentRemark =  !empty($showVal['pay_remark'])?$showVal['pay_remark']:"";
                                          
                          $html .=  '<tr>
                           <td>'.$showpaymentBy.'</td>
                           <td><img src="'.$rupeesImage.'" alt="" title="" style="width:8px; margin-top:2px;">'.$showPaidmount .'</td>
                           <td>'.$showPaymentdate.'</td>
                           <td>'.$showpayment_mode.'</td>
                           <td>'.$showinstumentdate.'</td>
                           <td>'.$showInstrumentNo.'</td>
                           <td>'.$showPaymentbank_name.'</td>
                           <td>'.$showPaymentRemark.'</td>
                          </tr>';
                         }
                          }

                          $html .='</table>
                              </td>
                           </tr>
                           
                     </tbody>
                  </table>
               </td>
            </tr>
            <tr>
            
               <td>
                   <table style="width: 100%;padding-top:5px;" >
                     <tbody>
                          <tr>
                           <td style="font-size:14px; font-weight:bold;">Payment To Inhouse</td>
                        </tr>
                           <tr>
                              <td>
                                <table  style="width: 100%;padding-top:5px;" class="table-new">
                                 <tr>
                              <th>Payment By</th>
                              <th>Amt. Paid</th>
                              <th>Date of Payment</th>
                              <th>Payment Mode</th>
                              <th>Instrument Date</th>
                              <th>Instrument No.</th>
                              <th>Bank Name</th>
                              <th>Remark</th>
                           </tr>';
                           if(!empty($paymentInhouse)){
                           foreach($paymentInhouse as $key=>$inVal){
                           $inhousePaymentBy = "";
                            if($inVal['payment_by']=='1')
                                       {
                                         $inhousePaymentBy =  "Customer";
                                        }else if($inVal['payment_by']=='2')
                                        {
                                           $inhousePaymentBy = "Bank";
                                        }
                                        else if($inVal['payment_by']=='3')
                                        {
                                           $inhousePaymentBy = "Showroom";
                                        }
                            $inhousePaymentAmount = !empty($inVal['amount'])? $CI->IND_money_format($inVal['amount']):0;
                            $inhousePaymentDate = !empty($inVal['payment_date'])?(date('d M, Y',strtotime($inVal['payment_date']))):"";
                             $inhousePaymentMode = ""; 
                            if($inVal['payment_mode']=='1')
                                       {
                                         $inhousePaymentMode = "Cash";
                                        }else if($inVal['payment_mode']=='2')
                                        {
                                            $inhousePaymentMode = "Cheque";
                                        }
                                        else if($inVal['payment_mode']=='3')
                                        {
                                            $inhousePaymentMode ="DD";
                                        }
                                        else if($inVal['payment_mode']=='4')
                                        {
                                            $inhousePaymentMode = "Online";
                                        }
                            $inhouseInstrumentDate = "";
                            if(!empty($inVal['instrument_date']) && $inVal['instrument_date'] != "0000-00-00"){
                              if($inVal['payment_mode'] != 1 && $inVal['payment_mode'] != 4){
                              $inhouseInstrumentDate = date('d M, Y',strtotime($inVal['instrument_date']));
                              }

                            }
                            $inhouseInstrumentno = !empty($inVal['instrument_no'])?$inVal['instrument_no']:"";
                           $inhousePaymentBank = "";
                            if(($inVal['payment_mode']=='2') ||($inVal['payment_mode']=='3') ){
                             $inhousePaymentBank =  $inVal['bank_name'];
                            }
                            $inhousePaymentRemark = !empty($inVal['pay_remark'])?$inVal['pay_remark']:"";
                            $html .='<tr>
                           <td>'.$inhousePaymentBy.'</td>
                           <td><img src="'.$rupeesImage.'" alt="" title="" style="width:8px; margin-top:2px;">'.$inhousePaymentAmount.'</td>
                           <td>'.$inhousePaymentDate.'</td>
                           <td>'.$inhousePaymentMode.'</td>
                           <td>'.$inhouseInstrumentDate.'</td>
                           <td>'.$inhouseInstrumentno.'</td>
                           <td>'.$inhousePaymentBank.'</td>
                           <td>'.$inhousePaymentRemark.'</td>
                          </tr>';
                           }

                           }
                         $html.= '</table>
                              </td>
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
}else{
  $html='File Not Available';  
}
echo $html;

