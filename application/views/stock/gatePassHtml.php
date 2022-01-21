<html>

    <body>

        <style>

            body {margin: 0;padding: 0;color: #000;font-family: Arial, Helvetica, sans-serif;width: 100%; font-size:12px;} 
            @page {margin-top: 15px;margin-bottom: 15px; margin-left: 30px;margin-right: 30px;}
            .clear { clear: both; }
            img { border: 0;outline: 0;}
            .form-wrapper { width: 100%;margin: 0 auto;padding: 0;}
            table, tr, td, th {border-collapse: collapse; border-spacing:0;}




        </style>


        <div class="form-wrapper">

            <table  width="100%">
                <tbody>
                    <tr>
                        <td>
                            <table style="width:100%;border-bottom:1px solid #ddd;">
                                <tr>
                                    <td align="left" style="width:30%; padding-bottom:10px;"><img src="<?=base_url()?>assets/images/logo.png" alt="" title="" style="width:150px;"></td>
                                    <td align="center" style="width:50%;text-align:center; padding-bottom:10px;">
                                        <span style="font-size:24px; display:block;letter-spacing:3px;">autocredits</span>
                                        <span style="font-size:16px;display:block;font-style:italic; ">India LLP</span>
                                        <span style="display:block;">Head Office: B-7, basement, Vardhman Rajdhani Plaza New Rajdhani Enclave Opp Pillar no 98, Main Vikas Marg, Delhi-92	</span>
                                        <span style="display:block;">Ph.: 011-46560000</span>
                                    </td>
                                    <td align="right" style="width:20%; padding-bottom:10px; font-style:italic; font-size:14px; vertical-align:top;">Drive Your Dreams</td>
                                </tr>
                            </table>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <table style="padding-top:0px; width:100%;">
                                
                                    
                                            <tr>
                                                <td align="center" style="text-align:center;font-size:18px;">Gate Pass</td>
                                            </tr>
                                       
                                
                            </table>
                        </td>
                    </tr>


                    <tr>
                        <td style="padding-top:0px;">
                            <table width="100%" style="font-size:14px;">
                                <tbody>
                                    <tr>
                                        <td width="40%" >
                                            <table width="100%">
                                                <tr>
                                                    <td style="width:15%;padding-top:10px">Date</td>
                                                    <td style="width:32%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=date('d M, Y')?></td>
                                                    <td style="width:6%;padding-top:10px"></td>
                                                    <td style="width:15%;padding-top:10px">Time</td>
                                                    <td style="width:32%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=date('g:i A')?></td>
                                                </tr>

                                            </table>
                                        </td>

                                        <td width="50%" >
                                            <table width="100%" >
                                                <tr>
                                                    <td width="40%" style="padding-top:10px">Place of Delivery</td>
                                                    <td width="60%" style="border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?='Showroom'?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>


                    <tr>
                        <td style="padding-top:5px;">
                            <table width="100%" style="font-size:14px;">
                                <tbody>
                                    <tr>
                                        <td style="padding-top:5px; font-weight:bold">Car Details:</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"  style="">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:11%;padding-top:10px">Reg. No.</td>
                                                        <td style="width:36%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=!empty($reg_no)?strtoupper($reg_no):'NA'?></td>
                                                        <td style="width:2%;">&nbsp;</td>
                                                        <td style="width:15%;padding-top:10px">Make/Model</td>
                                                        <td style="width:36%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=$make.' '.$model?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"  style="padding-top:5px;">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                                                <tbody>

                                                    <tr>
                                                        <td style=";padding-top:10px">Chasis. No.</td>
                                                        <td style="border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=!empty($chassisno)?$chassisno:'NA'?></td>
                                                        <td style="">&nbsp;</td>

                                                        <td style="padding-top:10px">Engine. No.</td>
                                                        <td style="border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=!empty($engineno)?$engineno:'NA'?></td>
                                                        <td style="">&nbsp;</td>

                                                        <td style="padding-top:10px">Odometer Reading</td>
                                                        <td style="border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=!empty($km_driven)?indian_currency_form($km_driven).' Kms':'NA'?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"  style="padding-top:5px;">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                                                <tbody>

                                                    <tr>
                                                        <td style="padding-top:10px; font-weight:bold">Buyer Details:</td>
                                                    </tr>

                                                    <tr>


                                                        <td style="width:15%;padding-top:10px">Name of Buyer</td>
                                                        <td style="width:34%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?= ucfirst($seller_name)?></td>
                                                        <td style="width:2%;">&nbsp;</td>
                                                        <td style="width:15%;padding-top:10px"><?= !empty($customer_relation)?strtoupper(substr($customer_relation,0,1)).'/'.substr($customer_relation,1,1):'S/o, D/o, W/o '?> :</td>
                                                        <td style="width:34%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?= ucfirst($customer_relation_name)?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"  style="padding-top:5px;">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:10%;padding-top:10px">Address</td>
                                                        <td style="width:90%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=$seller_address?>.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"  style="padding-top:5px;">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:15%;padding-top:10px">Contact No.</td>
                                                        <td style="width:85%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=$customer_mobile?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="padding-top:5px;">
                                            <table border="1" width="100%" style="font-size:14px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:100%; padding-left:5px; padding-top:5px; text-align:center; background-color:#dddddd;">Check List</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <table border="1" width="100%" style="font-size:12px;">
                                                <tbody>
                                                    <tr>
                                                        <th>S.No.</th>
                                                        <th>Particulars</th> 
                                                        <th>Status</th>
                                                        <th>S.No.</th>
                                                        <th>Particulars</th> 
                                                        <th>Status</th>
                                                    </tr>
                                                    <tr>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">1.</td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">2nd Key</td> 
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"></td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">6.</td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">Engine Oil</td> 
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"></td>
                                                    </tr>

                                                    <tr>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">2.</td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">Spare Wheel</td> 
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"></td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">7.</td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">Brake Oil</td> 
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"></td>
                                                    </tr>

                                                    <tr>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">3.</td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">Music System With Speaker</td> 
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"></td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">8.</td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">Coolant</td> 
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"></td>
                                                    </tr>

                                                    <tr>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">4.</td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">Wheel Caps</td> 
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"></td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">9.</td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">AC Cooling</td> 
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">5.</td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">Tool Kit</td> 
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"></td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">10.</td>
                                                         <td  style="" colspan="2">
                                                            <table width="100%" border="1">
                                                                <tr>
                                                                    <td width="30%" rowspan="2">Battery</td>
                                                                    <td width="25%">Make</td>
                                                                    <td width="45%"></td>
                                                                </tr>
                                                                <tr> 

                                                                    <td width="25%">S.No.</td>
                                                                    <td width="45%"></td>
                                                                </tr>
                                                            </table>
                                                         </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="5" style="padding-top:10px;">
                                            <table border="1" width="100%" style="font-size:14px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:100%; padding-left:5px; padding-top:5px; text-align:center; background-color:#dddddd;">Documents</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <table border="1" width="100%" style="font-size:12px;">
                                                <tbody>
                                                    <tr>
                                                        <th>S.No.</th>
                                                        <th>Particulars</th> 
                                                        <th>Status</th>
                                                        <th>S.No.</th>
                                                        <th>Particulars</th> 
                                                        <th>Status</th>
                                                    </tr>
                                                    <tr>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">1.</td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">RC</td> 
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"></td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">2.</td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">Service Booklet</td> 
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">3.</td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">Insurance</td> 
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"></td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">4.</td>
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px">PUC Certificate</td> 
                                                        <td style=" padding-left:5px; padding-top:5px; padding-bottom:5px"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" style="background:#000; color:#fff; padding-left:5px; padding-top:5px; padding-bottom:5px; font-size:12px;">Note: Insurance is to be transfer by customer him/herself. In case of miss-happening, Auto credits India LLP will not be responsible for thta. The RC transfer process will be taken care by Auto Credits India LLP.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="padding-top:5px;">
                                            <table  width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td style="text-decoration:underline; text-align:center;font-weight:bold">Declaration by Customer</td>
                                                    </tr>


                                                    <tr>
                                                        <td style="padding-top:5px;">I <span style="width:100%;border-bottom:1px solid #000; font-weight:bold;padding-top:10px"><?=$seller_name?></span> am talking this vehicle only for my personal conveyance. I have taken Test Drive of said vehicle and vehicle is in good running condition. I am fully satisfied with quality of vehicle</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="6" style="padding-top:5px;padding-bottom:100px;">
                                            <table  width="100%">
                                                <tbody>


                                                    <tr>
                                                        <td width="30%" style=""></td>
                                                        <td width="40%" style=""></td>
                                                        <td width="30%" style=" text-align:center;border-top:1px solid #000;">Customer &#x27;s Signature</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="6">
                                            <table  width="100%">
                                                <tbody>


                                                    <tr>
                                                        <td width="33%" style=" text-align:center;border-top:1px solid #000;">Delivered By</td>
                                                        <td width="2%" style="">&nbsp;</td>
                                                        <td width="33%" style=" text-align:center;border-top:1px solid #000;">Sales Content</td>
                                                        <td width="2%" style="">&nbsp;</td>
                                                        <td width="30%" style=" text-align:center;border-top:1px solid #000;">Manager</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>


                                </tbody>
                            </table>
                        </td>
                    </tr>
                            <!-- main table -->

                            
                </tbody>
            </table>
        </div>

                            </body>
                            </html>