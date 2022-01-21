
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
                                    <td align="right" style="font-size:12px;">Original GST No.
                                        <span style="border-bottom:1px solid #000;font-weight:bold; font-size:12px;">07ABDFA1535A1Z7</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table style="padding-top:10px; width:100%">
                                <tr>
                                    <td align="center" style="width:50%;text-align:center;font-size:18px;">Retail Invoice</td>
                                </tr>
                            </table>
                        </td>
                    </tr>





                    <tr>
                        <td>
                            <table style="width:100%; padding-top:5px;font-size:12px;" border="1">

                                <tr>
                                    <td style="padding:5px;">Customer Name</td>
                                    <td style="padding:5px; font-weight:bold"><?= ucfirst($seller_name)?></td>
                                    <td style="padding:5px;">Invoice No.</td>
                                    <td style="padding:5px;font-weight:bold">ACI/<?=date('Y').'-'.(date('y')+1).'/'.$delivery_id?></td>
                                </tr>

                                <tr>
                                    <td style="padding:5px;">Address</td>
                                    <td style="padding:5px; font-weight:bold"><?=$seller_address?></td>
                                    <td style="padding:5px;">Invoice Date</td>
                                    <td style="padding:5px;font-weight:bold"><?=!empty($sold_invoice_date)?date('d M, Y', strtotime($sold_invoice_date)):'NA'?></td>
                                </tr>

                                <tr>
                                    <td style="padding:5px;">Contact No.</td>
                                    <td style="padding:5px; font-weight:bold"><?=$customer_mobile?></td>
                                    <td style="padding:5px;">Our Reference No.</td>
                                    <td style="padding:5px;font-weight:bold">ACILLP/<?=date('Y').'-'.(date('y')+1).'/'.$booking_id?></td>
                                </tr>

                                <tr>
                                    <td style="padding:5px;">Email Id.</td>
                                    <td style="padding:5px; font-weight:bold"><?=$seller_email?></td>
                                    <td style="padding:5px; font-weight:bold"></td>
                                    <td style="padding:5px; font-weight:bold"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <table style="width:100%; padding-top:5px;font-size:12px;" border="1">
                                <tr>
                                    <th  style="background:#ddd;padding:5px; font-size:14px;">Make & Model</th>
                                    <th  style="background:#ddd;padding:5px; font-size:14px;">Year</th>
                                    <th  style="background:#ddd;padding:5px; font-size:14px;">File No.</th>
                                    <th  style="background:#ddd;padding:5px; font-size:14px;">Reg. No.</th>
                                    <th  style="background:#ddd;padding:5px; font-size:14px;">Chasis No.</th>
                                    <th  style="background:#ddd;padding:5px; font-size:14px;">Engine No.</th>
                                </tr>
                                <tr>
                                    <td style="padding:5px; text-align:center;font-weight:bold;"><?=$make.' '.$model?></td>
                                    <td style="padding:5px; font-weight:bold;text-align:center;"><?=$make_year?></td>
                                    <td style="padding:5px;font-weight:bold;text-align:center;"><?=''?></td>
                                    <td style="padding:5px;font-weight:bold;text-align:center;"><?=!empty($reg_no)?strtoupper($reg_no):'NA'?></td>
                                    <td style="padding:5px;font-weight:bold;text-align:center;"><?=!empty($chassisno)?$chassisno:'NA'?></td>
                                    <td style="padding:5px;font-weight:bold;text-align:center;"><?=!empty($engineno)?$engineno:'NA'?></td>
                                </tr>


                            </table>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <table style="width:100%; padding-top:5px;font-size:12px;" border="1">
                                <tr>
                                    <th  style="background:#ddd;padding:5px; font-size:14px;">Sr. No</th>
                                    <th  style="background:#ddd;padding:5px; font-size:14px;">Particulars</th>
                                    <th  style="background:#ddd;padding:5px; font-size:14px;">Amount (Rs.)</th>
                                </tr>

                                <tr>
                                    <td  style="padding:5px;  font-weight:bold">1</td>
                                    <td  style="padding:5px; font-weight:bold"><?=$make.' '.$model.' '.$version.' '.$make_year.' '.strtoupper($reg_no).'<br> '.'(inclusive GST)'?></td>
                                    <td  style="padding:5px;  font-weight:bold"><img src="<?=base_url()?>assets/images/rupee-icon.png" style="width:11px; margin-top:3px;"> <?= indian_currency_form($amount).'/-'?></td>
                                </tr>
 
                            </table>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <table style="width:100%;font-size:12px;" border="1">
                                <tr>
                                    <td style="padding:5px;">Amount In Words:</td>
                                    <td style="font-weight:bold;padding:5px;">Rupees <?= convertToIndianCurrency($amount,'') ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:10px;" >
                            <table width="100%" style="font-size:12px;">
                                <tbody>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px; padding-bottom:5px;text-align:left; background-color:#dddddd;">Terms & Conditions</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">1. Prices & Statutory Levies prevailing at the time of delivery would be applicable.					</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">2. All payment would be accepted favouring “AUTOTCREDITS INDIA LLP” payable at New Delhi.					</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">3. Interest @ 24% will be charged if not paid within 30 days.												</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">4. No payment will be valid unless receipts duly counter signed by the authorized signatories.			</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">5. Change of Ownership of the vehicle and issue of new registration certificate is at the sole discretion of Delhi Transport Authority.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">6. The delivery would be make only after realization of cheques/DD/PO and Transfer of Ownership of the vehicle.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">7. Goods once sold will not be taken back.																</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:5px;padding-bottom:5px;">8. All disputed are subject to Jurisdiction of Delhi Courts only.											</td>
                                    </tr>

                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:15px;padding-bottom:5px;">For XYZ</td>
                                    </tr>

                                    <tr>
                                        <td style="width:100%; padding-left:5px; padding-top:20px;padding-bottom:5px;">Authorised Signatory</td>
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