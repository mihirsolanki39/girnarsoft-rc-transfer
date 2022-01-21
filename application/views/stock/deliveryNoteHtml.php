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
                            <table style="padding-top:10px; width:100%">
                                <tr>
                                    <td align="left" style="width:30%;">S. No.&nbsp;
                                        <span style="border-bottom:1px solid #000;font-weight:bold; font-size:14px;"><?=$delivery_id+1000?></span>
                                    </td>
                                    <td align="center" style="width:50%;text-align:center;font-size:18px;">Delivery Note</td>
                                    <td align="right" style="width:20%; font-size:14px;">Date&nbsp;
                                        <span style="border-bottom:1px solid #000;font-weight:bold; font-size:14px;"><?=date('d M, Y')?></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:25px;">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                                <tbody>
                                    <tr>
                                        <td colspan="2" style="padding-bottom:10px;font-weight:bold">The following car is delivered today to</td>
                                    </tr>
                                    <tr>
                                        <td style="width:15%;padding-top:10px">Mr./Mrs./M/s</td>
                                        <td style="width:85%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?= ucfirst($seller_name)?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:15%;padding-top:10px">R/o.</td>
                                        <td style="width:85%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=$seller_address?>.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="padding-top:5px;">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding-bottom:1px; font-weight:bold">Car Details:</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:15%;padding-top:10px">Make/Model</td>
                                                        <td style="width:85%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=$make.' '.$model?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:15%;padding-top:10px">Vehicle Reg. No.</td>
                                                        <td style="width:85%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=!empty($reg_no)?strtoupper($reg_no):'NA'?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td  style="padding-top:5px;">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                                <tbody>
                                    <tr>
                                        <td style="width:15%;padding-top:10px">Engine No.</td>
                                        <td style="width:35%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=!empty($engineno)?strtoupper($engineno):'NA'?></td>
                                        <td style="width:2%;">&nbsp;</td>
                                        <td style="width:12%;padding-top:10px">Chasis No.</td>
                                        <td style="width:36%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=!empty($chassisno)?strtoupper($chassisno):'NA'?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td  style="padding-top:5px;">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                                <tbody>
                                    <tr>
                                        <td style="width:15%;padding-top:10px">Colour</td>
                                        <td style="width:85%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?= ucfirst($colour)?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:5px;">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                                <tbody>
                                    <tr>
                                        <td style="width:15%;padding-top:10px">
                                            <p>I am taking delivery of the above said vehicle on this day <span style="border-bottom:1px solid #000; font-weight:bold;"><?=date('l d M', strtotime($date_of_delivery))?></span> for my personal conveyance only. The said vehicle has been duly approved by me and found to my entire satisfaction. I am from today onwards responsible to pay all type of traffic offence. Police Legal Litigation, accident and R.T.O. taxes and premium of insurance of the said vehicle.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:10px;">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                                <tbody>
                                    <tr>
                                        <td style="width:40%;padding-top:10px; vertical-align:middle;">For Personal use only <br> Yours faithfully<br><br><br><br><br><br><br>(CUSTOMERS SIGNATURE)</td>
                                        <td style="width:10%;padding-top:10px">&nbsp;</td>
                                        <td style="width:17%;border:1px solid #000; font-weight:bold;padding-top:10px; height:200px;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td  style="padding-top:10px;">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                                <tbody>
                                    <tr>
                                        <td style="width:12%;padding-top:10px">Date & Time</td>
                                        <td style="width:35%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><span><?=date('dS M, Y, g:i A')?></span> </td>
                                        <td style="width:5%;">&nbsp;</td>
                                        <td style="width:8%;padding-top:10px">Ph. No.</td>
                                        <td style="width:35%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=$customer_mobile?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td  style="padding-top:10px;">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                                <tbody>
                                    <tr>
                                        <td style="width:8%;padding-top:10px">Email.</td>
                                        <td style="width:37%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=$seller_email?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td  style="padding-top:5px;">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                                <tbody>
                                    <tr>
                                        <td style="width:20%;padding-top:10px">Reference & Name</td>
                                        <td style="width:80%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?= ucfirst($seller_name)?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td  style="padding-top:5px;">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px; line-height:22px;">
                                <tbody>
                                    <tr>
                                        <td style="width:10%;padding-top:10px">Address</td>
                                        <td style="width:90%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"> <?=$seller_address?>.   </td>
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
