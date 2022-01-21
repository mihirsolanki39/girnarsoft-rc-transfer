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
                                    <td align="left" style="width:30%; padding-bottom:10px;"><img src="<?=base_url().LOGO?>" alt="" title="" style="width:150px;"></td>
                                    <td align="center" style="width:50%;text-align:center; padding-bottom:10px;">
                                        <span style="font-size:24px; display:block;letter-spacing:3px;"><?=ORGANIZATION?></span>
                                        
                                        <span style="display:block;"><?=DEALER_ADDRESS?>	</span>
                                        <span style="display:block;">Ph.: <?=DEALER_MOBILE?></span>
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
                                    <td align="center" style="width:50%;text-align:center;font-size:18px;">Payment Receipt</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table style="padding-top:10px; width:100%">
                                <tr>
                                    <td align="left" style="font-size:14px;">Dated&nbsp;
                                        <span style="border-bottom:1px solid #000;font-weight:bold; font-size:14px;"><?=date('d M, Y')?></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>


                    <tr>
                        <td style="padding-top:30px;">
                            <table style="padding-top:10px; width:100%; font-size:16px;">
                                <tr>
                                    <td colspan="5" style="padding-top:5px; line-height:30px;vertical-align:top">Received with thanks from 
                                        <span style="width:100%;border-bottom:1px solid #000; font-weight:bold; vertical-align:top">Mr. <?= ucfirst($seller_name)?> <?= !empty($customer_relation)?strtoupper(substr($customer_relation,0,1)).'/'.strtoupper(substr($customer_relation,1,1)):''?> <?=!empty($customer_relation_name)?ucfirst($customer_relation_name):''?> R/o <?=$seller_address?></span>
                                        the sum of <span style="width:100%;border-bottom:1px solid #000; font-weight:bold;vertical-align:top"><img src="<?=base_url()?>assets/images/rupee-icon.png" style="width:11px; margin-top:3px;">&nbsp;<?=indian_currency_form($amount)?></span>  (in words) <span style="width:100%;border-bottom:1px solid #000; font-weight:bold;vertical-align:top">Rupees <?= convertToIndianCurrency($amount,'')?></span> (detailed below) as full & final payment / Margin Money/ Booking amount towards Used Car 
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:15%;padding-top:10px">Make/Model</td>
                                    <td style="width:36%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=$make.' '.$model?></td>

                                    <td style="width:2%;">&nbsp;</td>
                                    <td style="width:11%;padding-top:10px">Reg. No.</td>
                                    <td style="width:36%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=!empty($reg_no)?strtoupper($reg_no):''?></td>

                                </tr>

                                <tr>
                                    <td style="width:15%;padding-top:10px">Engine No.</td>
                                    <td style="width:36%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=$engineno?></td>

                                    <td style="width:2%;">&nbsp;</td>
                                    <td style="width:11%;padding-top:10px">Chasis No.</td>
                                    <td style="width:36%;border-bottom:1px dashed #000; font-weight:bold;padding-top:10px"><?=$chassisno?></td>

                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size:16px;padding-top:30px;">Payment Details</td>
                    </tr>

                    <tr>
                        <td>
                            <table style="width:100%; padding-top:15px;font-size:14px;" border="1">




                                <tr>
                                    <th  style="background:#ddd;padding:5px; font-size:14px;width:10%">Sr. No.</th>
                                    <th  style="background:#ddd;padding:5px; font-size:14px;width:10%">Payment Mode</th>
                                    <th  style="background:#ddd;padding:5px; font-size:14px;width:25%">Cheque/ DD No./Ref.No</th>
                                    <th  style="background:#ddd;padding:5px; font-size:14px;width:20%">Drawn On</th>
                                    <th  style="background:#ddd;padding:5px; font-size:14px;width:15%">Dated</th>
                                    <th  style="background:#ddd;padding:5px; font-size:14px;width:30%">Amount </th>
                                </tr>
                              <?php $i=1;$total_paid=0 ;
                             
                                    foreach($paymentData as $k=> $payment){ 
                                  if($payment['amount']>0){
                                   // echo date('Y-m-d', strtotime($payment['instrument_date']));
                                    $insdate = '';
                                   // echo $payment['instrument_date']; 
                                    if((!empty($payment['instrument_date'])) && ((date('Y-m-d', strtotime($payment['instrument_date']))!='1970-01-01') && ($payment['instrument_date']!='0000-00-00 00:00:00')))
                                    {

                                         $insdate =date('d M, Y', strtotime($payment['instrument_date']));
                                    }
                                   
                                    ?>
                                <tr>
                                    <td  style="padding:5px;width:10%"><?=$i?></td>
                                    <td  style="padding:5px;width:10%"><?= $payment['instrument_type']?></td>
                                    <td  style="padding:5px;width:25%"><?=(!empty($payment['instrument_no']) && ($payment['instrument_no']!=0))?$payment['instrument_no']:''?></td>
                                    <td  style="padding:5px;width:20%"><?=$payment['bank_name']?></td>
                                    <td  style="padding:5px;width:15%"><?=$insdate?></td>
                                    <td style="padding:5px;width:30%"><span style="width:9px;"><img src="<?=base_url()?>assets/images/rupee-icon.png" style="width:11px; margin-top:3px;"><?=indian_currency_form($payment['amount']).'/-'?></span></td>

                                </tr>
                                  <?php $total_paid+=$payment['amount']; $i++; } }  ?>
                                <tr><td style="padding-left:650px;font-weight:bold" colspan="5">Total</td><td style="padding:5px;"><span style="width:9px;"><img src="<?=base_url()?>assets/images/rupee-icon.png" style="width:11px; margin-top:3px;"><?=indian_currency_form($total_paid).'/-'?></span></td></tr>
                            </table>
                        </td>
                    </tr>   











                </tbody>
            </table>

            <!-- main table -->

        </div>



    </body>
</html>