<?php

if (!empty($usedCarInfo))
{

    $dealership            = ORGANIZATION;
    $address               = DEALER_ADDRESS;
    $mobile                = DEALER_MOBILE;
    $regno                 = !empty($usedCarInfo['reg_no'])?strtoupper($usedCarInfo['reg_no']):"NA";
    $car_model             = ((!empty($usedCarInfo['make'])) ? $usedCarInfo['make'] . ' ' . $usedCarInfo['model'] . ' ' . $usedCarInfo['carversion'] : 'NA');
    $make                  = !empty($usedCarInfo['make'])? $usedCarInfo['make']: ' ';
    $model                 = !empty($usedCarInfo['model'])? $usedCarInfo['model']: ' ';
    $version               = !empty($usedCarInfo['carversion'])? $usedCarInfo['carversion']: ' ';
    $myear                 = !empty($usedCarInfo['make_year']) ? $usedCarInfo['make_year'] : 'NA';
    $colour                = (!empty($usedCarInfo['colour'])) ? $usedCarInfo['colour'] : '';
    $km                    = (!empty($usedCarInfo['km_driven'])) ? indian_currency_form($usedCarInfo['km_driven']) : '';
    $seller_name           = (!empty($usedCarInfo['seller_name'])) ? ucwords($usedCarInfo['seller_name']) : '';
    $seller_address        = (!empty($usedCarInfo['seller_address'])) ? $usedCarInfo['seller_address'] : '';
    $seller_mobile         = (!empty($usedCarInfo['seller_mobile'])) ? $usedCarInfo['seller_mobile'] : '';
    $engineno              = (!empty($usedCarInfo['engineno'])) ? strtoupper($usedCarInfo['engineno']) : '';
    $chassisno             = (!empty($usedCarInfo['chassisno'])) ? strtoupper($usedCarInfo['chassisno']) : '';
    $ownerIdToWord         = ['1'=>'First','2'=>'Second','3'=>'Third','4'=>'Fourth','5'=>'Fourth +',];
    $owner                 = (!empty($usedCarInfo['owner_type'])) ? $ownerIdToWord[$usedCarInfo['owner_type']] : '';
    $insurance_type        = $usedCarInfo['insurance_type'];
    $closed_by        = $usedCarInfo['closed_by'];
    $purchased_by_name        = $usedCarInfo['purchased_by_name'];
    $insuranceValidityDate = 'NA';
    if ($insurance_type != 'No Insurance')
    {
        $insuranceValidityDate = (!empty($usedCarInfo['insurance_exp_year']) && !empty($usedCarInfo['insurance_exp_month'])) ? date('M Y',strtotime($usedCarInfo['insurance_exp_year'].'-'.$usedCarInfo['insurance_exp_month'] . '-01'  )) : 'NA';
    }
    $paymentDel  = (!empty($paymentDel)) ? $paymentDel : '';
    $today       = date('d-m-Y');
//$exp_payment_date=date('d/m/Y',strtotime($usedCarInfo['exp_payment_date']));
    $rupeesImage = base_url('assets/images/rupee-icon.png');
    $logo        = ''; //base_url('assets/images/logo.png');
    if ($usedCarInfo['tradetype'] == '1')
    {
        $html = '<!doctype html>
     <html>
     
     <body>
     
     <style>
     
       body {margin: 0;padding: 0;color: #000;font-family: Arial, Helvetica, sans-serif;width: 100%; font-size:12px;} 
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
                                    <td align="left" style="width:30%; padding-bottom:10px;"><img src="'.base_url().'assets/images/logo.png'.'"  style="width:150px;"></td>
                                    <td align="center" style="width:50%;text-align:center; padding-bottom:10px;">
                                        <span style="font-size:24px; display:block;letter-spacing:3px;">autocredits</span>
                                        <span style="font-size:16px;display:block;font-style:italic; ">India LLP</span>
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
               <td align="left" style="font-size:14px;font-weight:bold;">LETTER FOR PARK & SELL AT <span style="border-bottom:1px solid #000;">' . $dealership . '</span></td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td>
         <table style="padding-top:10px; width:100%;font-size:14px;">
            <tr>
               <td style="width:18%;padding-top:10px">Name of the Owner</td>
               <td style="width:34%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px">' . $seller_name . '</td>
               <td style="width:2%;">&nbsp;</td>
               <td style="width:12%;padding-top:10px">Contact No</td>
               <td style="width:34%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px">' . $seller_mobile . '</td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td>
         <table style="padding-top:5px; width:100%;font-size:14px;">
            <tr>
               <td style="width:10%;padding-top:10px">Address</td>
               <td style="width:90%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px">' . $seller_address . '.
               </td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td>
         <table border="1" style="padding-top:20px; width:100%; font-size:12px;">
            <tr>
               <th colspan="2" style="background:#ddd;padding:5px;">VEHICLE DETAILS</th>
               <th colspan="3" style="background:#ddd;padding:5px;">DOCUMENTS DETAILS (Available)</th>
            </tr>
            <tr>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">Car Registration No. </td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-weight:bold">' . $regno . '</td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">Registration Book</td>
               <td  style="text-align:center;">Yes</td>
               <td  style="text-align:center;">No</td>
            </tr>
            <tr>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">Car Model </td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-weight:bold">' . $car_model . '</td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">OTT</td>
               <td  style="text-align:center;">Yes</td>
               <td  style="text-align:center;">No</td>
            </tr>
            <tr>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">Year of Manufacture </td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-weight:bold">' . $myear . '</td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">Hypothecation</td>
               <td  style="text-align:center;">Yes</td>
               <td  style="text-align:center;">No</td>
            </tr>
            <tr>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">Colour </td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-weight:bold">' . $colour . '</td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">PUC Validity</td>
               <td  style="text-align:center;">Yes</td>
               <td  style="text-align:center;">No</td>
            </tr>
            <tr>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">Present Kms</td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-weight:bold">' . $km . '</td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">Insurance Copy</td>
               <td  style="text-align:center;">Yes</td>
               <td  style="text-align:center;">No</td>
            </tr>
            <tr>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">Engine No</td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-weight:bold">' . $engineno . '</td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">Dealer Invoice</td>
               <td  style="text-align:center;">Yes</td>
               <td  style="text-align:center;">No</td>
            </tr>
            <tr>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">Chassis No</td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-weight:bold">' . $chassisno . '</td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">Municipal Tax Receipt</td>
               <td  style="text-align:center;">Yes</td>
               <td  style="text-align:center;">No</td>
            </tr>
            <tr>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">Ownership Detail </td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-weight:bold">' . $owner . '</td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">Insurance Type</td>
               <td  style="text-align:center;">' . $insurance_type . '</td>
               <td  style="text-align:center;"></td>
            </tr>
            <tr>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">Insurance Validity Date</td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-weight:bold">' . $insuranceValidityDate . '</td>
               <td  style="padding-left:5px; padding-top:5px; padding-bottom:5px">&nbsp;</td>
               <td  style="text-align:center;">&nbsp;</td>
               <td  style="text-align:center;">&nbsp;</td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td>
         <table style="padding-top:10px; width:100%">
            <tr>
               <td style="font-size:14px;font-weight:bold;">AUTOCREDITS INDIA LLP</td>
            </tr>
            <tr>
               <td style="font-size:13px; line-height:20px;">Undersigned, the owner of the above mentioned car undertaken to keep my car “Park & Sell” with 
                  <strong style="vertical-align:middle;"> AUTOCREDITS INDIA LLP</strong> 
                  at the agreed Price
                  <span style="border-bottom:1px solid #000;font-weight:bold;vertical-align:middle;">
                  <img src="' . $rupeesImage . '" alt="" style="width:9px; margin-top:4px;"> 
                  ' . $paymentDel . '/-</span> 
                  (all inclusive) (in words  
                  <span style="border-bottom:1px solid #000; font-weight:bold;vertical-align:middle;"> ' . ucwords($paymentWord) . ' Only.</span>) 
                  which shall be payable to me when the above mentioned car is sold and sale proceeds are realized by <strong>AUTOCREDITS INDIA LLP.</strong>
               </td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td>
         <table style="padding-top:15px; width:100%; font-size:13px;">
            <tr>
               <td  style="font-size:14px;padding-top:5px; ">Agreement of Park & Sell will be subject to the following terms and conditions:-</td>
            </tr>
            <tr>
               <td  style="padding-top:0px; ">
                  <ul>
                     <li style="margin-bottom:5px;">I have delivered the above mentioned car at AUTOCREDITS INDIA LLP at  <span style="border-bottom:1px solid #000;font-weight:bold;vertical-align:middle;">'.$address.'</span> and handed over the keys to <span style="border-bottom:1px solid #000;font-weight:bold;vertical-align:middle;">'.$closed_by.'</span>.</li>
                     <li style="margin-bottom:5px;">I ensure that above particulars regarding the car and the documents are true and correct.</li>
                     <li style="margin-bottom:5px;">I undertake to furnish the original copies of all documents mentioned above in the event of sale of above car by AUTOCREDITS INDIA LLP and payment made to me.</li>
                     <li style="margin-bottom:5px;">The car contains the following accessories( PL. specify the particulars of accessories)</li>
                     <li style="margin-bottom:5px;">The following are the details of hypothecation of the above car( PL. specify the details of applicable)</li>
                     <li style="margin-bottom:5px;">I ensure that the above car is having valid registration documents and confirm that the same is not involved in any legal proceedings and actus reus of theft.</li>
                     <li style="margin-bottom:5px;">The above car will be parked at Autocredits India LLP premises at my own risk and will not hold Autocredits India LLP liable for damage to the said car.8</li>
                  </ul>
               </td>
            </tr>
            </table>
            </td>
            </tr>
            
            
            <tr>
      <td>
         <table style="padding-top:15px; width:100%; font-size:13px;">
            <tr>
               <td  style="font-size:14px;padding-top:5px; ">Agreement of Park & Sell will be subject to the following terms and conditions:-</td>
            </tr>
            <tr>
               <td  style="padding-top:0px; ">
                  <ul>
                     <li style="margin-bottom:5px;">I will be liable to pay for the refurbishment to be done on the car, if any, after I have handed over the delivery to Autocredits India LLP as agreed, in between Autocredits India LLP  and me.(PL. specify  the details of refurbishments incl the estimated cost, to be done if any, which is agreed by the owner)</li>
                     <li style="margin-bottom:5px;">Autocredits India LLP will have the right to park the same car under park and sell at any other location within the same limits.</li>
                     <li style="margin-bottom:5px;">Autocredits India LLP will not be liable in case the registration documents of the car are not valid and amount paid to the owner for the car will be returned in such cases.</li>
                     <li style="margin-bottom:5px;">The above car will be sold on as is where is basis  by Autocredits India LLP and incase any work is carried out with the permission of the owner, amount will be deducted with the permission of the owner.</li>
                     <li style="margin-bottom:5px;">If payment has to be made to a person other than the owner, then NOC will have to to be furnished by the owner, for processing the payment for the above car, it will be subject to evaluation by evaluators of Autocredits India LLP.</li>
                     <li style="margin-bottom:5px;">Autocredits India LLP can call upon the owner to take back the car at any time till the said car is unsold and upon being called the owner shall take the car of Autocredits India LLP Premises with 12 hours of call.</li>
                     <li style="margin-bottom:5px;">All the above terms and conditions are acceptable to me.</li>
                  </ul>
               </td>
            </tr>
            </table>
            </td>
            </tr>
            
              <tr>
                                                            <td colspan="6" style="padding-top:20px;padding-bottom:100px;">
                                                                  <table  width="100%">
                                                                    <tbody>
                                                                      
                                                                        
                                                                        <tr>
                                                                            <td width="30%" style=""></td>
                                                                             <td width="40%" style=""></td>
                                                                            <td width="30%" style=" text-align:center;">For Autocredits India LLP</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        
                                                          <tr>
                                                            <td colspan="6" style="padding-top:20px;padding-bottom:100px;">
                                                                  <table  width="100%">
                                                                    <tbody>
                                                                      
                                                                        
                                                                        <tr>
                                                                          
                                                                            <td  style=" text-align:left;">Customer &#x27;s Signature</td>
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
    }
    else
    {
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
       table, tr, td, th {border-collapse: collapse; border-spacing:0;}
   
   
     
    
   </style>
   
   
   
   <body>
   
   <div class="form-wrapper">
   
       <table  width="100%">
           <tbody>
               <tr>
                   <td>
                       <table style="padding-top:10px; width:100%">
                           <tr>
                                <td align="center" style="width:50%;text-align:center;font-size:18px;">Delivery Receipt</td>
                           </tr>
                       </table>
                   </td>
               </tr>
               
                 <tr>
                   <td>
                       <table style="padding-top:10px; width:100%">
                           <tr>
                              <td align="left" style="font-size:14px;">Dated&nbsp;
                                <span style="border-bottom:1px solid #000;font-weight:bold; font-size:14px;">'.date('d/m/Y').'</span>
                               </td>
                           </tr>
                       </table>
                   </td>
               </tr>
               
               
               <tr>
                <td style="padding-top:30px;">
                     <table style="padding-top:10px; width:100%; font-size:14px;">
                         <tr>
                              <td colspan="5" style="padding-top:5px; line-height:25px;vertical-align:top">I, the undersigned 
                                <span style="width:100%;border-bottom:1px dashed #000; font-weight:bold; vertical-align:top">'.$seller_name.'</span>
                                 R/O <span style="width:100%;border-bottom:1px dashed #000; font-weight:bold; vertical-align:top">'.$seller_address.'</span> 
                                  have taken the delivery of Car
                                
                              </td>
                         </tr>
                         
                          <tr>
                                <td style="width:15%;padding-top:10px">Regd No.</td>
                                <td style="width:36%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px">'.$regno.'</td>
                               
                                <td style="width:2%;">&nbsp;</td>
                                 <td style="width:17%;padding-top:10px">Model</td>
                                <td style="width:30%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px">'.$model.' '.$version.'</td>
                               
                          </tr>
                          
                          <tr>
                                <td style="width:15%;padding-top:10px">Chasis No.</td>
                                <td style="width:36%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px">'.$chassisno.'</td>
                               
                                <td style="width:2%;">&nbsp;</td>
                                 <td style="width:17%;padding-top:10px">Engine No.</td>
                                <td style="width:30%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px">'.$engineno.'</td>
                               
                          </tr>
                          
                            <tr>
                                <td style="width:15%;padding-top:10px">Make</td>
                                <td style="width:36%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px">'.$make.'</td>
                               
                                <td style="width:2%;">&nbsp;</td>
                                 <td style="width:17%;padding-top:10px">Color</td>
                                <td style="width:30%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px">'.$colour.'</td>
                               
                          </tr>
                          
                          
                          <tr>
                              <td colspan="5" style="padding-top:20px; line-height:25px;vertical-align:top">From  
                                <span style="width:100%;border-bottom:1px dashed #000; font-weight:bold; vertical-align:top">'.$dealership.'</span>
                                R/O <span style="width:100%;border-bottom:1px dashed #000; font-weight:bold; vertical-align:top">'.$address.'</span> 
                                  have taken the delivery of Car
                                   C/O <span style="width:100%;border-bottom:1px dashed #000; font-weight:bold; vertical-align:top">'.$purchased_by_name.'</span>
                                
                              </td>
                         </tr>
                          
                    </table>
                </td>
               </tr>
               
               
               
               <tr>
                <td style="padding-top:10px;">
                     <table style="width:100%; font-size:12px;">
                         <tr>
                            <td>for my personal use complete in all rspect with registartion documents. I shall be full legally responsible for its maintenance accident, Road Tax, Police Challans after taking the delivery and also for its misuse of any kind. We do not take any responsibility regarding odometer reading any electrical fault and any malfunctioning of the vehicle. I have by promise that, I shall get the insurance (if valid) transfered in my name otherwise taken the new insurance for the date of purchase, (Have checked up the vehicle throughly and i m fully satisfied. The vehicle is sold on as is where is basis. I shall be fully responsible for any kind of declaration problems in future. Transfer of ownership process will take 60 days. I have read and understand all the terms & condition I fully satisfied)</td>
                         </tr>
                          
                    </table>
                </td>
               </tr>
               
               
                <tr>
                <td style="padding-top:10px;">
                     <table style="width:100%; font-size:14px; vertical-align:middle;">
                         <tr>
                            <td>
                                <span style="width:30%;padding-top:10px;">Date&nbsp;</span>
                                <span style="width:70%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px; display:inline-block;">'.date('dS M Y').'</span>
                            </td>
                            <td>
                                <span style="width:30%;padding-top:10px;">Time&nbsp;</span>
                                <span style="width:70%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px; display:inline-block;">'.date('g:i A').'</span>
                            </td>
                            <td>
                                <span style="width:30%;padding-top:10px;">Place&nbsp;</span>
                                <span style="width:70%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px; display:inline-block;">'.$dealer_showroom_city.'</span>
                            </td>
                         </tr>
                          
                    </table>
                </td>
               </tr>
               
                <tr>
                
                <td  style="padding-top:10px;">
                     <table style="width:100%; font-size:14px; ">
                         <tr>
                            <td  style="width:49%">
                               <table style="width:100%;">
                                    <tr >
                                        <td style="padding-top:10px;">
                                         <span style="width:50%;">Witness Signature </span>
                                         <span style="width:50%;border-bottom:1px dashed #000; font-weight:bold;padding-top:5px; display:inline-block;"> &nbsp;</span>
                                        </td>
                                    </tr>
                                     <tr>
                                        <td style="padding-top:10px;">
                                         <span style="width:30%;">Name </span>
                                         <span style="width:70%;border-bottom:1px dashed #000; font-weight:bold;padding-top:5px; display:inline-block;"> </span>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                          <td style="padding-top:15px;">
                                         <span style="width:30%;vertical-align:top;">Address </span>
                                         <span style="width:70%;border-bottom:1px dashed #000; font-weight:bold; display:inline-block; vertical-align:top;"> </span>
                                        </td>
                                    </tr>
                                    
                                         <tr>
                                        <td style="padding-top:10px;">
                                         <span style="width:40%;">Phone (Office) </span>
                                         <span style="width:60%;border-bottom:1px dashed #000; font-weight:bold;padding-top:5px; display:inline-block;"> </span>
                                        </td>
                                    </tr>
                                    
                                      <tr>
                                        <td style="padding-top:10px;">
                                         <span style="width:40%;">Phone (Res)&nbsp;&nbsp;&nbsp; </span>
                                         <span style="width:60%;border-bottom:1px dashed #000; font-weight:bold;padding-top:5px; display:inline-block;"> </span>
                                        </td>
                                    </tr>
                                    
                                   <tr>
                                        <td style="padding-top:10px;">
                                         <span style="width:30%;"> Mobile&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                         <span style="width:70%;border-bottom:1px dashed #000; font-weight:bold;padding-top:5px; display:inline-block;"> </span>
                                        </td>
                                    </tr>
                                    
                                    
                                </table>
                            </td>
                            
                             <td  style="width:2%">
                             </td>
                            
                            
                             <td  style="width:49%">
                               <table style="width:100%; ">
                                    <tr>
                                        <td style="padding-top:10px;">
                                         <span style="width:50%;">Buyers Signature </span>
                                         <span style="width:50%;border-bottom:1px dashed #000; font-weight:bold;padding-top:5px; display:inline-block;"> &nbsp;</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top:10px;">
                                         <span style="width:30%;">Name </span>
                                         <span style="width:70%;border-bottom:1px dashed #000; font-weight:bold;padding-top:5px; display:inline-block;"> '.$seller_name.'</span>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td style="padding-top:15px;">
                                         <span style="width:30%;vertical-align:top;">Address </span>
                                         <span style="width:70%;border-bottom:1px dashed #000; font-weight:bold; display:inline-block;vertical-align:top;">'.$seller_address.'</span>
                                        </td>
                                    </tr>
                                    
                                     <tr>
                                        <td style="padding-top:10px;">
                                         <span style="width:40%;">Phone (Office) </span>
                                         <span style="width:60%;border-bottom:1px dashed #000; font-weight:bold;padding-top:5px; display:inline-block;">NA</span>
                                        </td>
                                    </tr>
                                    
                                      <tr>
                                        <td style="padding-top:10px;">
                                         <span style="width:40%;">Phone (Res)&nbsp;&nbsp;&nbsp; </span>
                                         <span style="width:60%;border-bottom:1px dashed #000; font-weight:bold;padding-top:5px; display:inline-block;">NA</span>
                                        </td>
                                    </tr>
                                      <tr>
                                        <td style="padding-top:10px;">
                                         <span style="width:30%;"> Mobile&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                         <span style="width:70%;border-bottom:1px dashed #000; font-weight:bold;padding-top:5px; display:inline-block;"> '.$seller_mobile.'</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                         </tr>
                    </table>
                </td>
               </tr>
               
            
               
           </tbody>
       </table>
   
    <!-- main table -->
       
   </div>
   
   
   
   </body>
   </html>';
    }
}
else
{
    $html = 'File Not Available';
}

echo $html;

