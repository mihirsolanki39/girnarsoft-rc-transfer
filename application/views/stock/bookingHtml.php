
<html>    
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
                                    <td align="left" style="width:30%; padding-bottom:10px;"><img src="<?=base_url()?>assets/images/logo.png"  style="width:150px;"></td>
                                    <td align="center" style="width:50%;text-align:center; padding-bottom:10px;">
                                        <span style="font-size:24px; display:block;letter-spacing:3px;">autocredits</span>
                                        <span style="font-size:16px;display:block;font-style:italic; ">India LLP</span>
                                        <span style="display:block;">Head Office: B-7, basement, Vardhman Rajdhani Plaza New Rajdhani Enclave Opp Pillar no 98, Main Vikas Marg, Delhi-92   </span>
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
                                    <td align="center" style="text-align:center;font-size:18px;">Vehicle Booking Form</td>
                                </tr>
                            </table>
                        </td>
                    </tr>





                    <tr>
                        <td style="padding-top:25px;">
                            <table border="1" width="100%" style="font-size:12px;">
                                <tbody>
                                    <tr>
                                        <td style="width:70%; padding-left:5px; padding-top:5px;">Customer Name : <span style="font-weight:bold;"><?= ucfirst($seller_name)?></span></td>
                                        <td style="width:30%;padding-left:5px; padding-top:5px;">Sr No. : <span  style="font-weight:bold;">ACILLP/<?=date('Y').'-'.(date('y')+1).'/'.$booking_id?> </span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:70%; padding-left:5px; padding-top:5px;"><?= !empty($customer_relation)?strtoupper(substr($customer_relation,0,1)).'/'.substr($customer_relation,1,1):'S/o, D/o, W/o '?> : <span  style="font-weight:bold;"><?=!empty($customer_relation_name)?ucfirst($customer_relation_name):'NA'?></span></td>
                                        <td style="width:30%;padding-left:5px; padding-top:5px;">Booking Date : <span  style="font-weight:bold;"> <?=date('d M, Y', strtotime($booking_date))?> </span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:70%; padding-left:5px; padding-top:5px;">Email Address : <span  style="font-weight:bold;"><?=$seller_email?></span></td>
                                        <td style="width:30%;padding-left:5px; padding-top:5px;">Contact No. : <span  style="font-weight:bold;"><?=$customer_mobile?></span></td>
                                    </tr>
                                    <tr>
                                        <td   style="width:70%; padding-left:5px; padding-top:5px;">Customer Address : <span  style="font-weight:bold;"><?=$seller_address?></span></td>
                                        <td style="width:30%;padding-left:5px; padding-top:5px;"><span  style="font-weight:bold;"></span></td>
                                    </tr>
                                   
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:15px;padding-bottom:15px;">
                            <table border="1" width="100%" style="font-size:12px;">
                                <tbody>

                                    <tr><th colspan="6" style="background-color:#dddddd;padding-top:5px; padding-bottom:5px;">Vehicle Details</th></tr>
                                    <tr>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"> Make/Model</td>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><?=$make.' '.$model?></td>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"> Year of Manufacture</td>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><?=$make_year?></td>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px;"> Owner Serial No. </td>
                                        <?php 
                                        $ownerIdToWord= [
                                            '1'=>'First',
                                            '2'=>'Second',
                                            '3'=>'Third',
                                            '4'=>'Fourth',
                                            '5'=>'Fourth +',
                                        ];
                                        ?>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><?=!empty($owner_type)?$ownerIdToWord[$owner_type]:'NA'?></td>
                                    </tr>
                                    <tr>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"> Colour</td>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><?= ucfirst($colour)?></td>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"> Registration Dt.</td>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><?=!empty($reg_date)?date('d M, Y',strtotime($reg_date)):'NA'?></td>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"> Engine No.</td>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><?=!empty($engineno)?strtoupper($engineno):'NA'?></td>
                                    </tr>
                                    <tr>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"> Odometer Reading (Km)</td>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><?=indian_currency_form($km_driven)?></td>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"> Registration No.</td>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><?=!empty($reg_no)?strtoupper($reg_no):'NA'?></td>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"> Chasis No.</td>
                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><?=!empty($chassisno)?strtoupper($chassisno):'NA'?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>




                    <tr>
                        <td width="60%">
                            <table width="100%"  style="font-size:12px;" >
                                <tbody>
                                    <tr>
                                        <?php //if($new_insurance_req==1){ ?>
                                        <td>
                                            <table width="100%" border="1">
                                                <tr><th colspan="4" style="background-color:#dddddd;padding-top:5px; padding-bottom:5px;">Insurance</th></tr>
                                                <tr>
                                                    <td style="padding-left:5px; padding-top:10px; padding-bottom:10px;">Type</td>
                                                    <td style="padding-left:5px; padding-top:10px; padding-bottom:10px;font-weight:bold;"><?=$insurance_type?></td>
                                                    <td style="padding-left:5px;">Insurance Offer</td>
                                                    <td style="padding-left:5px;font-weight:bold;"><?=$new_insurance_req==1?'Issuing new ins':'Transferring Old ins'?>.</td>
                                                </tr>

                                                <tr>
                                                    <td style="padding-left:5px; padding-top:10px; padding-bottom:10px;">Insurance Co.</td>
                                                    <td style="padding-left:5px; padding-top:10px; padding-bottom:10px;font-weight:bold;"><?=$insurance_type!='No Insurance'?$insurer_name:''?></td>
                                                    <td style="padding-left:5px;">Valid Till</td>
                                                    <td style="padding-left:5px;font-weight:bold;"><?= $insurance_type!='No Insurance'?date('M Y',strtotime('01-'.$insurance_exp_month.'-'.$insurance_exp_year)):'NA'?></td>
                                                </tr>

                                            </table>
                                        </td>
                                        <?php // } ?>
                                        <td width="40%" valign="top">
                                            <table width="100%" border="1">
                                                <tr><th colspan="2" style="background-color:#dddddd;padding-top:5px; padding-bottom:5px;">Road Tax</th></tr>
                                                <tr>
                                                    <td style="padding-left:5px; padding-top:10px; padding-bottom:10px;">Type</td>
                                                    <td style="padding-left:5px; padding-top:10px; padding-bottom:10px;font-weight:bold;">NA</td>

                                                </tr>

                                                <tr>

                                                    <td style="padding-left:5px;padding-top:10px; padding-bottom:10px;">Valid Till</td>
                                                    <td style="padding-left:5px;padding-top:10px; padding-bottom:10px;font-weight:bold;">NA</td>
                                                </tr>


                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>






                    <tr>
                        <td style="padding-top:15px;">
                            <table  width="100%" style="font-size:12px;">
                                <tbody>

                                    <tr>
                                        <td width="50%">
                                            <table width="100%" border="1">
                                                <tbody>
                                                    <tr><th colspan="2" style="background-color:#dddddd;padding-top:5px; padding-bottom:5px;">Price Details</th></tr>
                                                    <tr>
                                                        <td width="50%" style="padding-left:5px; padding-top:5px; padding-bottom:5px;">Basic Vehicle Price</td>
                                                        <td  width="50%"  style="padding-left:5px; padding-top:5px; padding-bottom:5px;"><span><img src="<?=base_url()?>assets/images/rupee-icon.png" style="width:9px; margin-top:3px;"> <?=indian_currency_form($base_vehicle_price)?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;">TCS</td>
                                                        <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><img src="<?=base_url()?>assets/images/rupee-icon.png" style="width:9px; margin-top:3px;"> <?=indian_currency_form($tcs)?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;">Vat / Sales Tax</td>
                                                        <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;">NA</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;">Insurance</td>
                                                        <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><?=$new_insurance_req==1?'<img src="'.base_url().'assets/images/rupee-icon.png" style="width:9px; margin-top:3px;">'.indian_currency_form($insurance_charges):'NA'?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;">Charges For RTO Formalities</td>
                                                        <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><img src="<?=base_url()?>assets/images/rupee-icon.png" style="width:9px; margin-top:3px;"> <?=indian_currency_form($rto_charges)?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;">Warranty (if any)</td>
                                                        <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;">NA</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;">Total Amount</td>
                                                        <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><img src="<?=base_url()?>assets/images/rupee-icon.png" style="width:9px; margin-top:3px;"><?=indian_currency_form($amount)?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;">Advance Recived</td>
                                                        <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><img src="<?=base_url()?>assets/images/rupee-icon.png" style="width:9px; margin-top:3px;"> <?=indian_currency_form($advance_payment)?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;">Balance Amount</td>
                                                        <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><img src="<?=base_url()?>assets/images/rupee-icon.png" style="width:9px; margin-top:3px;"> <?=indian_currency_form($amount-$advance_payment)?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td valign="top" width="50%">
                                            <table width="100%" border="1">
                                                <tbody>
                                                    <tr><th colspan="4" style="background-color:#dddddd;padding-top:5px; padding-bottom:5px;">Delivery Schedule</th></tr>
                                                    <tr>
                                                        <td colspan="2" style="padding-left:5px; padding-top:5px; padding-bottom:5px;">Preferred Date and Time</td>
                                                        <td  colspan="2"style="padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><?=date('d M, Y', strtotime($date_of_delivery))?></td>
                                                    </tr>
                                                    <?php //if($loan_req==1){ ?>
                                                    <tr>
                                                        <td colspan="4" style="background-color:#dddddd; text-align:center; padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold">Finance Details</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-size:12px;">Loan Amount</td>
                                                        <td colspan="2" style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-size:12px;font-weight:bold;"> <?=!empty($loan_req)?'<img src="'.base_url().'assets/images/rupee-icon.png" style="width:9px; margin-top:3px;">'.indian_currency_form($loan_amount):'NA' ?></td>

                                                    </tr>

                                                    <tr>

                                                        <td colspan="2" style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-size:12px;">Bank Name</td>
                                                        <td colspan="2" style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-size:12px;font-weight:bold;"><?=!empty($loan_req)?$bank_name:'NA' ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2" style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-size:12px;">Tenure</td>
                                                        <td colspan="2" style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-size:12px;font-weight:bold;"><?= !empty($loan_req)?$tenure.' Years':'NA' ?></td>

                                                    </tr>

                                                    <tr>

                                                        <td  colspan="2" style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-size:12px;">Rate of interest</td>
                                                        <td colspan="2" style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-size:12px;font-weight:bold;"><?=!empty($loan_req)?$roi.'%':'NA'?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" style="background-color:#dddddd; text-align:center; padding-left:5px; padding-top:5px; padding-bottom:5px; font-size:10px;">*Finance scheme, terms & condition etc are subject to approval by financier only</td>
                                                    </tr>
                                                    <?php //} ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="1" width="100%" style="font-size:12px;">
                                <tbody>
                                    <tr>
                                        <td valign="top" style="width:100%; padding-left:5px; padding-top:5px; padding-bottom:5px;" height="50"> <span style="text-decoration:underline"> Customer Demanded RF / Accessories Fitment:</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:25px;" >
                            <table border="1" width="100%" style="font-size:12px;">
                                <tbody>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px; padding-bottom:5px;text-align:center; background-color:#dddddd;"> Booking/Sales Terms & Conditions</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">1. The vehicle is booked and sold on " <b> As-is-where-is basis"</b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">2. The offer, is valid for <b> seven days</b> from the date of booking will automatically stand cancelled, if we do not hear from you with in stipulated date time.</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">3. Complete downpayment in case of finance or 25% of the sales value in case of cash should be received within 3 days of booking else the booking will be treated as cancelled and amount will be forfeited</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">4. Delivery date is subjected tp <b>" Force Majeure"</b>.</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">5. The present vehicle condition and price is acceptable to me, any other hob required to be done has been recorded on this form as above.</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">6. I have taken test drive of vehicle. It is in perfect running condition and quality of vehicle is acceptable to me.</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">7. Odometer reading is just an indicator of mileage. Autocredits India LLP does no take any responsibility regarding correctness of kilometer reading in odmeter.</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">8. RC transfer may takes <b>45 to 90 days </b> after submission of documents to RTO</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">9. Autocredits India LLP will not be responsible for any malfunctioning of the vehicle from improper use of the vehicle or claim arising there from</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">10. I have been explained the warranty terms and condition application on vehicle (If any)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="1" width="100%" style="font-size:12px;">
                                <tbody>
                                    <tr>
                                        <td height="50"></td>
                                        <td height="50"></td>
                                        <td height="50"></td>
                                    </tr>
                                    <tr>
                                        <td align="center">Customer Signature</td>
                                        <td align="center">Sale Consulltant Signature</td>
                                        <td align="center">HOD - Used Cars</td>
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
</html>
