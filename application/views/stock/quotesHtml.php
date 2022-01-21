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
                                    <td align="center" style="width:50%;text-align:center;font-size:18px;">Price Quotation</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table style="padding-top:10px; width:100%">
                                <tr>
                                    <td align="left" style="font-size:14px;">Date&nbsp;
                                        <span style="border-bottom:1px solid #000;font-weight:bold; font-size:14px;"><?=date('d M Y')?></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table style="padding-top:15px; width:100%">
                                <tr>
                                    <td  style="font-size:14px;">To, </td>
                                </tr>

                                <tr>
                                    <td  style="font-size:14px; font-weight:bold;padding-top:5px;">Mr. <?=$customer_name?>,</td>
                                </tr>
                                <tr>
                                    <td  style="font-size:14px; font-weight:bold;padding-top:15px;">Sub: Quotation for Vehicle <?=$mk_n.' '.$md_n.' '.$v_n ?> </td>
                                </tr>

                                <tr>
                                    <td  style="font-size:14px;padding-top:15px;">Sir, </td>
                                </tr>

                                <tr>
                                    <td  style="font-size:14px; padding-top:5px;">Please find below the quotation as discussed.</td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table border="1" style="padding-top:15px; width:100%; font-size:14px; ">
                                <tr>
                                    <th style="background:#ddd;padding:5px;">Make – Model</th>
                                    <th style="background:#ddd;padding:5px;"><?=$mk_n.' '.$md_n.' '.$v_n ?></th> 

                                </tr>
                                <tr>
                                    <td style="padding-left:5px; padding-top:5px; padding-bottom:5px">Regn. Year</td>
                                    <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><?=!empty($reg_year)?$reg_year:'NA' ?></td> 

                                </tr>
                                <tr>
                                    <td style="padding-left:5px; padding-top:5px; padding-bottom:5px">Colour</td>
                                    <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><?=$colour ?></td> 

                                </tr>


                                <tr>
                                    <td style="padding-left:5px; padding-top:5px; padding-bottom:5px">Regn. Number</td>
                                    <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><?=!empty($reg_no)?$reg_no:'NA' ?></td> 

                                </tr>
                                <tr>
                                    <td style="padding-left:5px; padding-top:5px; padding-bottom:5px">KMS Driven</td>
                                    <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><?=indian_currency_form($km_driven) ?> Kms Approx.</td> 

                                </tr>

                                <tr>
                                    <td style="padding-left:5px; padding-top:5px; padding-bottom:5px">Ownership Srl.</td>
                                    <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;font-weight:bold;"><?=!empty($owner_type)?addOrdinalNumberSuffix($owner_type):'NA' ?></td> 

                                </tr>
                                <tr>
                                    <td style="padding-left:5px; padding-top:5px; padding-bottom:5px;background:#ddd;">Price Quoted*</td>
                                    <td style="padding-left:5px; padding-top:5px; padding-bottom:5px; font-weight:bold;background:#ddd;"><img src="<?=base_url()?>assets/images/rupee-icon.png" alt="" style="width:9px; margin-top:4px;"> <?=indian_currency_form($car_price) ?>/- <br><span>(<?= convertToIndianCurrency($car_price)?>.)</span> </td> 

                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table style="padding-top:10px; width:100%">
                                <tr>

                                    <td style="font-size:14px;">*The above quoted price excludes RTO, Insurance and other charges as applicable.</td>

                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                      <table style="padding-top:15px; width:100%">
                         
                        
                           <tr>
                              <td  style="font-size:14px;padding-top:15px;">For <span style="font-weight:bold;">Autocredits India LLP</span> </td>
                           </tr>
                           
                            <tr>
                              <td  style="font-size:14px;padding-top:15px;">Gaurav Grover</td>
                           </tr>
                           
                           <tr>
                              <td  style="font-size:14px; padding-top:5px;">(Authorised Signatory)</td>
                           </tr>
                           
                       </table>
                        </td>
                    </tr>



                    <tr>
                        <td>
                        <table style="padding-top:15px; width:100%">
                         
                        
                           <tr>
                              <td  style="font-size:14px;padding-top:15px; font-weight:bold;">Terms and conditions:</td>
                           </tr>
                           
                            <tr>
                              <td  style="font-size:14px;padding-top:0px; ">
                                <ul>
                                    <li style="margin-bottom:5px;">The Vehicle will be delivered only after receiving the full and final payment.</li>
                                     <li style="margin-bottom:5px;">The payment must be made in favour of “Autocredits India LLP”</li>
                                      <li style="margin-bottom:5px;">Subjected to Delhi Jurisdiction. </li>
                                </ul>
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
</html>