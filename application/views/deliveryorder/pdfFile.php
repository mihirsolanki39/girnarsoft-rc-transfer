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
$customer_name=strtoupper($orderinfo['customer_name']);
$color=(!empty($orderinfo['color'])) ? $orderinfo['color'] : '';
$customer_address=$orderinfo['customer_address'];
$bank_name=(!empty($orderinfo['bank_name'])) ? $orderinfo['bank_name'] : 'NA';
$make_name=(!empty($orderinfo['parentmakeName'])) ? $orderinfo['parentmakeName'] : $orderinfo['make_name'];
$model_name=(!empty($orderinfo['parentmodelName'])) ? $orderinfo['parentmodelName'] : $orderinfo['model_name'];
$version_name=(!empty($orderinfo['version_name'])) ? $orderinfo['version_name'] : '';
$do_no=(!empty($orderinfo['id'])) ? $orderinfo['id'] : '';
$do_date = date('d/m/Y',strtotime($orderinfo['do_date']));
$do_amt=(!empty($orderinfo['net_do_amt'])) ? $orderinfo['net_do_amt'] .' /-': '';
$do_amt_word=(!empty($orderinfo['do_amt_word'])) ? $orderinfo['do_amt_word'] .' Rupee Only' : '';
$createdDate=date('d/m/Y',strtotime($orderinfo['add_date']));
$delivery_date=date('d/m/Y',strtotime($orderinfo['delivery_date']));
$exp_payment_date=date('d/m/Y',strtotime($orderinfo['exp_payment_date']));
$rupeesImage=base_url('assets/images/rupee-icon.png');
$html =
  '<!doctype html>
  <html>
  
  <body>
  
  <style>
  
       body {margin: 0;padding: 0;color: #000;font-family: Arial, Helvetica, sans-serif;width: 100%; font-size:12px;} 
    @page {margin-top: 25px;margin-bottom: 25px; margin-left: 30px;margin-right: 30px;}
     .clear { clear: both; }
    img { border: 0;outline: 0;}
    .form-wrapper { width: 100%;margin: 0 auto;padding: 0;}
    .header{ margin:0 auto;}
 
</style>



<body>

<div class="form-wrapper">

<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tbody>
        <tr>
            <td  style="border-bottom:1px solid #000;padding-bottom:10px;">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td style="width:65%; text-align:left;font-size:20px; font-weight:bold; padding:bottom:5px;">'.ORGANIZATION.'</td>
                        <td style="width:35%; text-align:right;padding:bottom:5px;">
                            <div>Direct Selling Agent</div>
                            <div>Auto Loan</div>
                            <div>HDFC Bank Ltd.</div>
                        </td>
                    </tr>
                    <tr>
                    <td colspan="2" ></td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
            <td style="padding-top:10px;">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td style="width:65%; text-align:left;font-size:14px; vertical-align:top;">
                            <div>BUY AND SELL NEW AND USED CARS</div>
                            <div>(EXCHANGE FACILITY AVAILABLE)</div>
                        </td>
                        <td style="width:35%; text-align:right;padding:bottom:5px; font-style: normal;">
                            <div>B-209, 1st Floor, Mansarovar Garden,<br>New Delhi-110015</div>
                            <div>TEL:25178687, 25178687, 25178687</div>
                            <div>Email:bcspl.hdfc@gmail.com </div> 
                            <div>ccs.accounts@hotmail.com</div>
                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
            <td style="padding-top:30px;">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td style="width:65%; text-align:left;font-size:14px; vertical-align:top; line-height:22px;">
                            <div>Dealer Name : <span style="border-bottom:1px solid #000; font-weight:bold;">'.$dealerName.'</span></div>
                            <div>Sales Executive Name : <span style="border-bottom:1px solid #000; font-weight:bold;">'.$salesName.'</span></div>
                            <div>Date : <span style="border-bottom:1px solid #000; font-weight:bold;">'.$do_date.'</span></div>
                            <div>Loan Account No. : <span style="border-bottom:1px solid #000; font-weight:bold;">'.$loanId.'</span></div>
                           
                        </td>
                        <td style="width:35%; text-align:right;font-size:14px; vertical-align:top; line-height:22px;">
                              <div>DO. No. : <span style="border-bottom:1px solid #000; font-weight:bold;">'.$do_no.'</span></div>
                            <div>Insurance : '.$insurnace.'<span style="border-bottom:1px solid #000; font-weight:bold;"></span></div>
                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
          <tr>
            <td style="padding-top:25px;">
                <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                    <tr>
                        <td style="text-align:left;vertical-align:top; ">
                            <div class="">To,</div>
                            <div class="">Showroom Manager</div>
                            <div style="width:40%; font-weight:bold;"></div>
                        </td>
                     </tr>
                     <tr>
                        <td style="text-align:left;vertical-align:top; ">
                            <div style="font-weight:bold;">'.$showroomName.'</div>
                            <div style="width:40%;border-bottom:1px dashed #000; font-weight:bold;"></div>
                        </td>
                     </tr>
                      <tr>
                        <td style="text-align:left;vertical-align:top; ">
                            <div style="font-weight:bold; font-size:12px !important;">'.$showroomAddress.'</div>
                            <div style="width:40%;border-bottom:1px dashed #000; font-weight:bold;"></div>
                        </td>
                     </tr>
                     <tr>
                        <td style="padding-top:15px;">Sir/Madam,</td>
                     </tr>
                     <tr>
                        <td style="padding-top:10px;">
                            <div>Kind Attention : <span style="border-bottom:1px solid #000; font-weight:bold;">'.$kind_attn.'</span></div>
                        </td>
                     </tr>
                     <tr>
                        <td style="padding-top:10px;">
                           Please deliver the following vehicle and details of which are given below:
                        </td>
                     </tr>
                     
                     <tr>
                        <td style="padding-top:15px;">
                             <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                                <tr>
                                    <td style="width:20%;">Customer&#x27;s Name </td>
                                    <td style="width:5%;">:</td>
                                    <td style="width:75%;border-bottom:1px dashed #000; font-weight:bold;">'.$customer_name.'</td>
                                </tr>
                                
                                <tr>
                                    <td style="width:30%;padding-top:15px;">Customer&#x27;s Address </td>
                                    <td style="width:5%;padding-top:15px;">:</td>
                                    <td style="width:65%;border-bottom:1px dashed #000;  font-size:12px !important;font-weight:bold;padding-top:15px;">'.$customer_address.'</td>
                                 </tr>
                                
                                 <tr>
                                    <td style="width:20%;padding-top:15px;">Hypothecated to </td>
                                    <td style="width:5%;padding-top:15px;">:</td>
                                    <td style="width:75%;border-bottom:1px dashed #000; font-weight:bold;padding-top:15px;">'.$bank_name.'</td>
                                </tr>
                                
                                <tr>
                                    <td style="width:20%;padding-top:15px;">Vehicle Details </td>
                                    <td style="width:5%;padding-top:15px;">:</td>
                                    <td style="width:75%;border-bottom:1px dashed #000; font-weight:bold;padding-top:15px;">'.$color.' '.$make_name.' '.$model_name.' '.$version_name.'</td>
                                </tr>
                                
                                  
                                
                                 <tr>
                                    <td style="width:20%;padding-top:15px;">DO Amount (in Rs.) </td>
                                    <td style="width:5%;padding-top:15px;">:</td>
                                    <td style="width:75%;border-bottom:1px dashed #000; font-weight:bold;padding-top:15px;"><img src="'.$rupeesImage.'" style="width:11px;margin-top:5px;">&nbsp;'.$do_amt.'</td>
                                </tr>
                                
                              
                                
                                <tr>
                                    <td style="width:20%;padding-top:15px;">DO Amount (in words) </td>
                                    <td style="width:5%;padding-top:15px;">:</td>
                                    <td style="width:75%;border-bottom:1px dashed #000; font-size:12px !important; font-weight:bold;padding-top:15px;">'.$do_amt_word.'</td>
                                </tr>
                                
                                 <tr>
                                    <td style="width:20%;padding-top:15px;">Delivery Date </td>
                                    <td style="width:5%;padding-top:15px;">:</td>
                                    <td style="width:75%;border-bottom:1px dashed #000; font-weight:bold;padding-top:15px;">'.$delivery_date.'</td>
                                </tr>
                                
                                <tr>
                                    <td style="width:20%;padding-top:15px;">Expected Date of Payment </td>
                                    <td style="width:5%;padding-top:15px;">:</td>
                                    <td style="width:75%;border-bottom:1px dashed #000; font-weight:bold;padding-top:15px;">'.$exp_payment_date.'</td>
                                </tr>
                                
                             </table>
                        </td>
                     </tr>
                     
                      <tr>
                        <td style="padding-top:15px; font-size:13px; line-height:18px;">
                           Kindly mail the copy of Invoice & Insurance and please ensure that specific model will be deliver. Please confirm DO before delivery on 9210608596, 9911150911. Kindly collect the balance payment from customer & no charge whatsoever will be debited to our account before confirmation.
                        </td>
                     </tr>
                     
                      <tr>
                        <td style="padding-top:15px; font-size:13px; line-height:18px;">Thanks & Regards
                        </td>
                     </tr>
                      <tr>
                        <td style="padding-top:10px; font-size:13px; line-height:18px;">For '.ORGANIZATION.'.
                        </td>
                     </tr>
                     
                      <tr>
                        <td style="padding-top:15px; font-size:13px; line-height:18px;">Procurement Head/Authorized Signatory
                            <div class="">Manvinder Singh<span></span></div>
                             <div class="">Nisha Sharma<span></span></div>
                        </td>
                     </tr>
                     
                </table>
            </td>
        </tr>
        
        
        
        
    </tbody>
</table> <!-- main table -->
    
</div>



</body>
</html>';
}else{
  $html='File Not Available';  
}

echo $html;

