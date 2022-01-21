<?php

  $dealership = ORGANIZATION;
  $address = DEALER_ADDRESS;
  $mobile = (MOBILESMS!='MOBILESMS')?MOBILESMS:'';
//$exp_payment_date=date('d/m/Y',strtotime($usedCarInfo['exp_payment_date']));
$rupeesImage=base_url('assets/images/rupee-icon.png');
$off_add = !empty($office_address)?$office_address.' ,'.$office_city.' ,'.$office_pincode:'';
//$logo=base_url('assets/images/logo.png');
//if($usedCarInfo['tradetype']=='1'){

$resi_info = !empty($residence_address)?($residence_address.', '.$residence_city.' - '.$residence_pincode):'';
$cores_info = !empty($corres_add)?($corres_add.', '.$corres_city.' - '.$corres_pincode):'';

if($Buyer_Type=='1')
{
   $resi_info  = '';  
   $cores_info = '';
   $corres_add = '';
            $corres_state= '';
            $corres_city =  '';
            $corres_pincode = '';
            $corres_phone = '';

            $landmark = '';
            $cores_landmark = '';
            $residence_state = '';
            $residence_city = '';
            $residence_pincode = '';
            $residence_phone = '';
            $length_of_stay = '';
}
$html ='<!doctype html>
<html>
   <body>
      <style>
         body {margin: 0;padding: 0;color: #000;font-family: Arial, Helvetica, sans-serif;width: 100%; font-size:12px;} 
         @page {margin-top: 10px;margin-bottom: 10px; margin-left: 30px;margin-right: 30px;}
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
                     <td  style="border-bottom:1px solid #000;padding-bottom:10px;">
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                           <tr>
                              <td style="width:65%; text-align:left;font-size:20px; font-weight:bold; padding:bottom:5px;">'.$dealership.'</td>
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
                                 <div>'.$address.'</div>
                                 <div>'.$mobile.'</div>';
                                 if($dealer_id=='69'){
                                $html .= '<div>Email:bcspl.hdfc@gmail.com </div>
                                 <div>ccs.accounts@hotmail.com</div>';
                        }
                            $html .=  '</td>
                           </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <table style="padding-top:15px; width:100%;font-size:12px;">
                           <tr>
                              <td align="left" style="">Date
                                 <span style="border-bottom:1px solid #000;font-weight:bold;">'.date('d/m/Y').'</span>
                              </td>
                              <td align="right" style="">PAN NO.
                                 <span style="border-bottom:1px solid #000;font-weight:bold;">'.$pan_number.'</span>
                              </td>
                           </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <table style="width:100%; padding-top:5px;font-size:12px;" border="1">
                           <tr>
                              <th colspan="4" style="background:#ddd;padding:2px; font-size:14px;">CASE TYPE</th>
                           </tr>
                           <tr>
                              <td style="padding:5px;">DSA NAME</td>
                              <td style="padding:5px; font-weight:bold"></td>
                              <td style="padding:5px;">DSA CODE</td>
                              <td style="padding:5px;font-weight:bold"></td>
                           </tr>
                           <tr>
                              <td style="padding:5px;">NAME</td>
                              <td style="padding:5px; font-weight:bold">'.$customer_name.'</td>
                              <td style="padding:5px;">GENDER</td>
                              <td style="padding:5px;font-weight:bold"><span>'.$gender.'</span> </td>
                           </tr>
                           <tr>
                              <td style="padding:5px;">DOB</td>
                              <td style="padding:5px; font-weight:bold">'.$dob.'</td>
                              <td style="padding:5px;">MOTHERS NAME</td>
                              <td style="padding:5px;font-weight:bold">'.$mother_name.'</td>
                           </tr>
                           <tr>
                              <td style="padding:5px;">EXISTING CUST(Y/N)</td>
                              <td style="padding:5px; font-weight:bold"></td>
                              <td style="padding:5px;">LOAN AMT</td>
                              <td style="padding:5px;font-weight:bold"><img src="'.$rupeesImage.'" style="width:10px; margin-top:3px;"> '.$loan_amt.'</td>
                           </tr>
                           <tr>
                              <td style="padding:5px;">BANK A/C NO</td>
                              <td style="padding:5px; font-weight:bold">'.$custacc.'</td>
                              <td style="padding:5px;">CUST ID</td>
                              <td style="padding:5px;font-weight:bold">'.$customer_id.'</td>
                           </tr>
                           <tr>
                              <td style="padding:5px;">EX SHOWRROM</td>
                              <td style="padding:5px; font-weight:bold"></td>
                              <td style="padding:5px;"></td>
                              <td style="padding:5px;font-weight:bold"></td>
                           </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <table style="width:100%; padding-top:5px;font-size:12px;" border="1">
                           <tr>
                              <th colspan="4" style="background:#ddd;padding:2px; font-size:14px;">RESIDENCE ADDRESS</th>
                           </tr>
                           <tr>
                              <td style="padding:5px;">PRESENT ADD</td>
                              <td style="padding:5px; font-weight:bold">'.$resi_info.'</td>
                              <td style="padding:5px;">LANDMARK</td>
                              <td style="padding:5px;font-weight:bold">'.$landmark.'</td>
                           </tr>
                           <tr>
                              <td style="padding:5px;">CITY/STATE</td>
                              <td style="padding:5px; font-weight:bold">'.$residence_city.'</td>
                              <td style="padding:5px;">PIN CODE</td>
                              <td style="padding:5px;font-weight:bold">'.$residence_pincode.'</td>
                           </tr>
                           <tr>
                              <td style="padding:5px;">CONTACT NO</td>
                              <td style="padding:5px; font-weight:bold">'.$residence_phone.'</td>
                              <td style="padding:5px;">LANDLINE NO</td>
                              <td style="padding:5px;font-weight:bold"></td>
                           </tr>
                           <tr>
                              <td style="padding:5px;">STD CODE</td>
                              <td style="padding:5px; font-weight:bold"></td>
                              <td style="padding:5px;">E-MAIL ID</td>
                              <td style="padding:5px;font-weight:bold"></td>
                           </tr>
                           <tr>
                              <td style="padding:5px;">YR AT CURRENT CITY</td>
                              <td style="padding:5px; font-weight:bold">'.$length_of_stay.'</td>
                              <td style="padding:5px;"></td>
                              <td style="padding:5px;font-weight:bold"></td>
                           </tr>
                           <tr>
                              <th colspan="4" style="border:1px solid #ddd;padding:0px; font-size:14px;"></th>
                           </tr>
                           <tr>
                              <td style="padding:5px;">PERMANENT ADD</td>
                              <td style="padding:5px; font-weight:bold">'.$cores_info.'</td>
                              <td style="padding:5px;">LANDMARK</td>
                              <td style="padding:5px;font-weight:bold">'.$cores_landmark.'</td>
                           </tr>
                           <tr>
                              <td style="padding:5px;">CITY/STATE</td>
                              <td style="padding:5px; font-weight:bold">'.$corres_city.'</td>
                              <td style="padding:5px;">PIN CODE</td>
                              <td style="padding:5px;font-weight:bold">'.$corres_pincode.'</td>
                           </tr>
                           <tr>
                              <td style="padding:5px;">CONTACT NO</td>
                              <td style="padding:5px; font-weight:bold">'.$corres_phone.'</td>
                              <td style="padding:5px;">LANDLINE NO</td>
                              <td style="padding:5px;font-weight:bold"></td>
                           </tr>
                           <tr>
                              <td style="padding:5px;">STD CODE</td>
                              <td style="padding:5px; font-weight:bold"></td>
                              <td style="padding:5px;">E-MAIL ID</td>
                              <td style="padding:5px;font-weight:bold"></td>
                           </tr>
                        </table>
                     </td>
                  </tr>
                   
                   
                     <tr>
                     <td>
                        <table style="width:100%; padding-top:5px;font-size:12px;" border="1">
                           <tr>
                              <th colspan="4" style="background:#ddd;padding:2px; font-size:14px;">OFFICE ADDRESS</th>
                           </tr>
                           <tr>
                              <td style="padding:5px;">DESIGNATION</td>
                              <td style="padding:5px; font-weight:bold"></td>
                              <td style="padding:5px;">OFFICE NAME</td>
                              <td style="padding:5px;font-weight:bold"></td>
                           </tr>
                           
                          <tr>
                              <td style="padding:5px;">ADDRESS</td>
                              <td style="padding:5px; font-weight:bold">'.$off_add.'</td>
                              <td style="padding:5px;">LANDMARK</td>
                              <td style="padding:5px;font-weight:bold">'.$office_landmark.'</td>
                           </tr>
                           
                           <tr>
                              <td style="padding:5px;">CITY/STATE</td>
                              <td style="padding:5px; font-weight:bold">'.$office_city.'</td>
                              <td style="padding:5px;">PIN CODE</td>
                              <td style="padding:5px;font-weight:bold">'.$office_pincode.'</td>
                           </tr>
                           <tr>
                              <td style="padding:5px;">CONTACT NO</td>
                              <td style="padding:5px; font-weight:bold">'.$office_mobile.' </td>
                              <td style="padding:5px;">LANDLINE NO</td>
                              <td style="padding:5px;font-weight:bold">'.$office_phone.'</td>
                           </tr>
                           <tr>
                              <td style="padding:5px;">STD CODE</td>
                              <td style="padding:5px; font-weight:bold"></td>
                              <td style="padding:5px;">E-MAIL ID</td>
                              <td style="padding:5px;font-weight:bold">'.$office_email.'</td>
                           </tr>
                           <tr>
                              <td style="padding:5px;">YR AT CURRENT CITY</td>
                              <td style="padding:5px; font-weight:bold"></td>
                              <td style="padding:5px;"></td>
                              <td style="padding:5px;font-weight:bold"></td>
                           </tr>
                        </table>
                     </td>
                  </tr>
                  
                  
                  
                  
                  
                  
                   <tr>
                     <td>
                        <table style="width:100%; padding-top:5px;font-size:12px;" border="1">
                           <tr>
                              <th colspan="4" style="background:#ddd;padding:2px; font-size:14px;">REFERENCES</th>
                           </tr>
                           <tr>
                              <td style="padding:5px;">REF 1 (NAME)</td>
                              <td style="padding:5px; font-weight:bold">'.$ref_name_one.'</td>
                              <td style="padding:5px;">REF 2 (NAME)</td>
                              <td style="padding:5px;font-weight:bold">'.$ref_name_two.'</td>
                           </tr>
                           
                          <tr>
                              <td style="padding:5px;">ADDRESS</td>
                              <td style="padding:5px; font-weight:bold">'.$ref_address_one.'</td>
                              <td style="padding:5px;">ADDRESS</td>
                              <td style="padding:5px;font-weight:bold">'.$ref_address_two.'</td>
                           </tr>
                           
                           <tr>
                              <td style="padding:5px;">MOBILE</td>
                              <td style="padding:5px; font-weight:bold">'.$ref_phone_one.'</td>
                              <td style="padding:5px;">MOBILE</td>
                              <td style="padding:5px; font-weight:bold">'.$ref_phone_two.'</td>
                           </tr>
                        
                        </table>
                     </td>
                  </tr>
                   
            </table>
           
            <!-- main table -->
         </div>
   </body>
</html>';
   


echo $html;

