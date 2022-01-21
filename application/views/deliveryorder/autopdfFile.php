 <?php

if(!empty($orderinfo)){
 // echo ORGANIZATION; exit;

$orderId=$orderinfo['id'];
$dealerName=(!empty($orderinfo['dealerName']) && ($orderinfo['deliverySource']=='1')) ? strtoupper($orderinfo['dealerName']) : 'NA';
$salesName=strtoupper($orderinfo['dName']);
$loanId=(!empty($orderinfo['application_no'])) ? $orderinfo['application_no'] : 'NA';

$showroomName=(!empty($orderinfo['organization'])) ? $orderinfo['organization'] : '';
$showroomAddress=(!empty($orderinfo['showroomAddress'])) ? $orderinfo['showroomAddress'] : '';
if((!empty($orderinfo['insurnace']) && $orderinfo['insurnace']=='1'))
{
  $insurnace = 'Showroom';
}
if((!empty($orderinfo['insurnace']) && $orderinfo['insurnace']=='2'))
{
  $insurnace = 'Inhouse';
}
else
{
  $insurnace = 'Dealer';
}
//$insurnace=(!empty($orderinfo['insurnace']) && $orderinfo['insurnace']=='1') ? 'Showroom' : 'Inhouse';
$kind_attn=$orderinfo['kind_attn'];
$kind_attn_mobile= !empty($orderinfo['owner_mobile'])?$orderinfo['owner_mobile']:'NA';

$customer_name=strtoupper($orderinfo['customer_name']);
$color=(!empty($orderinfo['color'])) ? $orderinfo['color'] : '';
$customer_address=$orderinfo['customer_address'];
$bank_name=(!empty($orderinfo['bank_name'])) ? $orderinfo['bank_name'] : 'NA';
$make_name=(!empty($orderinfo['parentmakeName'])) ? $orderinfo['parentmakeName'] : $orderinfo['make_name'];
$model_name=(!empty($orderinfo['parentmodelName'])) ? $orderinfo['parentmodelName'] : $orderinfo['model_name'];
$version_name=(!empty($orderinfo['version_name'])) ? $orderinfo['version_name'] : '';
$do_no=(!empty($orderinfo['id'])) ? $orderinfo['id'] : '';
$do_amt=(!empty($orderinfo['do_amt'])) ? $orderinfo['do_amt'] .' /-': '';
$do_amt_word=(!empty($orderinfo['do_amt_word'])) ? $orderinfo['do_amt_word'] .' Rupees Only' : '';
$createdDate=date('d/m/Y',strtotime($orderinfo['add_date']));
$delivery_date=date('d/m/Y',strtotime($orderinfo['delivery_date']));
$exp_payment_date=date('d/m/Y',strtotime($orderinfo['exp_payment_date']));
$do_date = date('d M, Y',strtotime($orderinfo['do_date']));
$rupeesImage=base_url('assets/images/rupee-icon.png');
$gross_do_amt = !empty($orderinfo['gross_do_amt'])?$orderinfo['gross_do_amt']:'0';
$showroom_disc = !empty($orderinfo['showroom_disc'])?$orderinfo['showroom_disc']:'0';
$loan_amt = !empty($orderinfo['loan_amt'])?$orderinfo['loan_amt']:'0';
$margin_money = !empty($orderinfo['margin_money'])?$orderinfo['margin_money']:'0';
$net_do_amt = !empty($orderinfo['net_do_amt'])?$orderinfo['net_do_amt']:'';

$ex_show = !empty($orderinfo['ex_show'])?$orderinfo['ex_show']:'0';
$tcs = !empty($orderinfo['tcs'])?$orderinfo['tcs']:'0';
$epc = !empty($orderinfo['epc'])?$orderinfo['epc']:'0';
$road_tax = !empty($orderinfo['road_tax'])?$orderinfo['road_tax']:'0';
$hpto =!empty($orderinfo['bank_name'])?$orderinfo['bank_name']:'';
$regType = $orderinfo['registration_type'];
$hptose = '';
if(!empty($hpto)){
$hptose = ', as the vehicle is being financed by <span class="">'.$hpto.'</span>';
}
$vehicle = $make_name.' '.$model_name.'  '.$version_name;
$insurancePremium = !empty($orderinfo['do_insu_premium'])?$orderinfo['do_insu_premium']:0;
$extWarranty = !empty($orderinfo['do_external_warranty'])?$orderinfo['do_external_warranty']:0;

$marginMoneyInhouse = !empty($orderinfo['margin_money_inhouse'])?indian_currency_form($orderinfo['margin_money_inhouse']):0;

 

 $html =
     '<!doctype html>
     <html>
     
     <body>
     
     <style>
     
       body {margin: 0;padding: 0;color: #000;font-family: Arial, Helvetica, sans-serif;width: 100%; font-size:13px;} 
       @page {margin-top: 25px;margin-bottom: 25px; margin-left: 30px;margin-right: 30px;}
        .clear { clear: both; }
       img { border: 0;outline: 0;}
       .form-wrapper { width: 100%;margin: 0 auto;padding: 0;}
       table, tr, td, th {border-collapse: collapse; border-spacing:0;}
   
   
     
    
   </style>
   
   
   
   <body>
   
   <div class="form-wrapper">
   
       <table  width="100%">
           <tbody>
               <tr>
                   <td>
                       <table style="width:100%;border-bottom:1px solid #ddd;">
                           <tr>
                               <td align="left" style="width:30%; padding-bottom:10px;"><img src="'.base_url().'assets/images/logo.png" alt="" title="" style="width:150px;"></td>
                               <td align="center" style="width:50%;text-align:center; padding-bottom:10px;">
                                   <span style="font-size:24px; display:block;letter-spacing:3px;">autocredits</span>
                                    <span style="font-size:14px;display:block;font-style:italic; ">India LLP</span>
                                   <span style="display:block;">Head Office: B-7, basement, Vardhman Rajdhani Plaza New Rajdhani Enclave Opp Pillar no 98, Main Vikas Marg, Delhi-92	</span>
                                   <span style="display:block;">Ph.: 011-46560000</span>
                               </td>
                               <td align="right" style="width:20%; padding-bottom:10px; font-style:italic; font-size:12px; vertical-align:top;">Drive Your Dreams</td>
                           </tr>
                       </table>
                   </td>
               </tr>
               
               
              
               
                 <tr>
                   <td>
                       <table style="padding-top:10px; width:100%">
                           <tr>
                              <td align="left" style="font-size:12px;">REF. No.
                                <span style="font-weight:bold; font-size:12px;letter-spacing:1px;">&nbsp; </span>
                               </td>
                               
                                <td align="right" style="font-size:12px;">Date
                                <span style="font-weight:bold; font-size:12px;">&nbsp;'.$do_date.'</span>
                               </td>
                           </tr>
                       </table>
                   </td>
               </tr>
               
                <tr>
                   <td>
                       <table style="padding-top:10px;  width:100%;">
                           <tr>
                               <td style="font-size:14px;"><B>'.$showroomName.'</B></td>
                           </tr>
                            <tr>
                               <td>'.$showroomAddress.'</td>
                           </tr>
                       </table>
                   </td>
               </tr>
               
                <tr>
                   <td>
                       <table style="padding-top:10px; width:100%; line-height:20px;">
                           <tr>
                               <td width="10%" style="">Kind Attn:</td>
                                <td width="80%" style="font-weight:bold;">'.$kind_attn.' (Mobile: '.$kind_attn_mobile.')</td>
                           </tr>
                           
                           <tr>
                               <td width="10%" style="">Subject:</td>
                                <td width="80%" style="font-weight:bold;">DELIVERY ORDER</td>
                           </tr>
                      </table>
                   </td>
               </tr>
               
                <tr>
                   <td>
                       <table style="padding-top:10px; width:100%; font-size:13px">
                           <tr>
                               <td style="">Dear Sir,</td>
                           </tr>
                           
                           <tr>
                               
                                <td>Kindly deliver the vehicle to the customer as per the details given below:</td>
                           </tr>
                      </table>
                   </td>
               </tr>
               
               
            
                 <tr>
                   <td>
                       <table style="padding-top:10px; width:100%; line-height:20px;">
                           <tr>
                               <td width="15%" style="">NAME:</td>
                                <td width="85%" style="font-weight:bold;">'.$customer_name.'</td>
                           </tr>
                           
                           <tr>
                               <td width="15%" style="vertical-align:top">ADDRESS:</td>
                                <td width="85%" style="font-weight:bold;vertical-align:top">'.$customer_address.'</td>
                           </tr>
                           
                           <tr>
                               <td width="15%" style="">VEHICLE:</td>
                                <td width="85%" style="font-weight:bold;">'.$vehicle.'</td>
                           </tr>
                           <tr>
                               <td width="15%" style="">COLOUR:</td>
                                <td width="85%" style="font-weight:bold;">'.$color.'</td>
                           </tr>
                           
                           <tr>
                               <td width="15%" style="">HP TO:</td>
                                <td width="85%" style="font-weight:bold;">'.$hpto.'</td>
                           </tr>
                            <tr>
                               <td width="15%" style="">REGN. REQD.:</td>
                                <td width="85%" style="font-weight:bold;">'.$regType.'</td>
                           </tr>
                      </table>
                   </td>
               </tr>
               
               
               
               <tr>
                    <td>
                       <table style="width:100%; padding-top:5px;font-size:13px;" border="1">
                         <tr>
                           <th colspan="2" style="background:#ddd;padding:5px; font-size:13px; text-align:center">Price Breakup</th>
                          </tr>
                       
                         
                         <tr>
                           <td style="padding:2px;  font-weight:bold">Gross DO Amount</td>
                           <td style="padding:2px; font-weight:bold"><img src="'.$rupeesImage.'" style="width:10px; margin-top:3px;">'.$gross_do_amt.'</td>
                         </tr>
                         
                          <tr>
                           <td style="padding:2px;">Ex-Showroom Price</td>
                           <td style="padding:2px;"><img src="'.$rupeesImage.'" style="width:10px; margin-top:3px;">'.$ex_show.'</td>
                         </tr>';
                         if($tcs>0){
                          $html.='<tr>
                                 <td style="padding:2px;">TCS</td>
                                 <td style="padding:2px;"><img src="'.$rupeesImage.'" style="width:10px; margin-top:3px;">'.$tcs.'</td>
                                  </tr>';
                          }
                        if($road_tax>0){
                               $html.='<tr>
                                       <td style="padding:2px;">Road Tax</td>
                                       <td style="padding:2px;"><img src="'.$rupeesImage.'" style="width:10px; margin-top:3px;">'.$road_tax.'</td>
                                       </tr>';
                          }
                       if($epc>0){
                              $html.='<tr>
                               <td style="padding:2px;">EPC</td>
                               <td style="padding:2px;"><img src="'.$rupeesImage.'" style="width:10px; margin-top:3px;">'.$epc.'</td>
                             </tr>';
                         }
                       if($insurancePremium>0){
                         $html.='<tr>
                               <td style="padding:2px;">Insurance Premium</td>
                               <td style="padding:2px;"><img src="'.$rupeesImage.'" style="width:10px; margin-top:3px;">'.$insurancePremium.'</td>
                             </tr>';
                         }
                         if($extWarranty>0){
                          $html.='<tr>
                               <td style="padding:2px;">Ext. Warranty</td>
                               <td style="padding:2px;"><img src="'.$rupeesImage.'" style="width:10px; margin-top:3px;">'.$extWarranty.'</td>
                             </tr>';
                         }
                        if(!empty($priceBreakup)){
                          foreach($priceBreakup as $val){
                           $html.='<tr>
                               <td style="padding:2px;">'.$val["p_name"].'</td>
                               <td style="padding:2px;"><img src="'.$rupeesImage.'" style="width:10px; margin-top:3px;">'.indian_currency_form($val["p_price"]).'</td>
                             </tr>';
                          }
                        }
                      
                       $html.='<tr>
                           <td style="padding:2px; font-weight:bold">Showroom Discount</td>
                           <td style="padding:2px;font-weight:bold"><img src="'.$rupeesImage.'" style="width:10px; margin-top:3px;">'.$showroom_disc.'</td>
                         </tr>';
                         if($loan_amt>0){
                             $html .='<tr>
                                      <td style="padding:2px; font-weight:bold">Loan</td>
                                      <td style="padding:2px;font-weight:bold"><img src="'.$rupeesImage.'" style="width:10px; margin-top:3px;">'.$loan_amt.'</td>
                                     </tr>';
                           }
                        if($margin_money>0){
                             $html.= '<tr>
                               <td style="padding:2px; font-weight:bold">Margin Money Paid from Customer</td>
                               <td style="padding:2px;font-weight:bold"><img src="'.$rupeesImage.'" style="width:10px; margin-top:3px;">'.$margin_money.'</td>
                             </tr>';
                        }
                        if($marginMoneyInhouse>0){
                          $html.= '<tr>
                               <td style="padding:2px; font-weight:bold">Margin Money Paid from Inhouse</td>
                               <td style="padding:2px;font-weight:bold"><img src="'.$rupeesImage.'" style="width:10px; margin-top:3px;">'.$marginMoneyInhouse.'</td>
                             </tr>';
                        }
                         $html.= '<tr>
                           <td style="padding:2px;">&nbsp;</td>
                           <td style="padding:2px;">&nbsp;</td>
                         </tr>
                            <tr>
                           <td style="padding:2px; font-weight:bold; background:#ddd;">Net DO Amount</td>
                           <td style="padding:2px;font-weight:bold;background:#ddd;"><img src="'.$rupeesImage.'" style="width:10px; margin-top:3px;">'.$net_do_amt.'</td>
                         </tr>
                        
                       
                       </table>
                    </td>
                </tr>
               
               
               
               <tr>
                   <td>
                       <table style="padding-top:5px; width:100%; line-height:15px;">
                           <tr>
                               <td style="font-weight:bold">Subject to the below mentioned terms &amp; conditions, we will remit the sum of RS. <span class="" style="vertical-align:top">'.$net_do_amt.'/-</span> <span class="">('.$do_amt_word.')</span>'.$hptose.'. The sum includes all charges and expenses, i.e, road Tax etc. (discount if any, to be deducted). Please recieve the balance payment and deliver the car. Any discrepancy will entitled us for refund of any sum paid to you for the above vehicle.</td>
                           </tr>
                         
                      </table>
                   </td>
               </tr>
               
                <tr>
                   <td>
                       <table style="padding-top:5px; width:100%;">
                           <tr>
                              <td style="">
                                <table style="padding-top:10px; width:100%;">
                                    <tr>
                                        <td>Thanking You</td>
                                    </tr>
                                    
                                    <tr>
                                        <td style="padding-top:10px; font-weight:bold">For Autocredits India LLP</td>
                                    </tr>
                                    
                                     <tr>
                                        <td style="padding-top:40px;">Authorised Signatory</td>
                                    </tr>
                                </table>
                              </td>
                          
                           </tr>
                         
                      </table>
                   </td>
               </tr>
                
             <tr>
                   <td>
                       <table style="padding-top:10px; width:100%; line-height:20px; font-size:12px">
                           <tr>
                               <td width="5%" style="font-weight:bold;vertical-align:top">P.S:</td>
                                <td width="95%" style="font-weight:bold;vertical-align:top">PLEASE COMPLETE THE DOCUMENTS AS REQUIRED FOR REGISTRATION PURPOSES FROM THE CUSTOMER i.e, FORM 20/ADDRESS PROOF, INSURANCE COVER NOTE ETC.</td>
                           </tr>
                      </table>
                   </td>
               </tr>
              
               
            
            
                
               
                                       
                      <tr>
                        <td style="padding-top:5px;" >
                           <table width="100%" style="font-size:12px;">
                              <tbody>
                                 <tr>
                                    <td style="width:100%; padding-left:5px; padding-top:5px; padding-bottom:3px;text-align:left; background-color:#dddddd;">Terms & Conditions</td>
                                 </tr>
                                 <tr>
                                    <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:3px;">A. Vehicle must be delivered to above customer or his duly authorised reprentative only after verification of identity.</td>
                                 </tr>
                                 <tr>
                                    <td style="width:100%; padding-left:5px; padding-top:2px;padding-bottom:3px;">B. Hypothecation must be in favour of above stated bank/company.				</td>
                                 </tr>
                                 <tr>
                                    <td style="width:100%; padding-left:5px; padding-top:2px;padding-bottom:3px;">C. Original Invoice &amp; registration Copy/Book must be delivered to us only within 15 days.												</td>
                                 </tr>
                                 
                                  <tr>
                                    <td style="width:100%; padding-left:5px; padding-top:2px;padding-bottom:3px;">D. Above details of customer and model of vehicle must be strictly adhered to.</td>
                                 </tr>
                               
                              
                              </tbody>
                           </table>
                        </td>
                     </tr>                
               
           </tbody>
       </table>
   
    <!-- main table -->
       
   </div>
   
   
   
   </body>
   </html>';
}else{
  $html='File Not Available';  
}

echo $html;