<!doctype html>
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
                            <table style="padding-top:15px; width:100%; font-size:18px;">
                                <tr>
                                    <td align="center" style="font-size:14px; font-weight:bold">Stock Reconcilation:

                                    </td>


                                </tr>
                            </table>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <table style="padding-top:15px; width:100%; font-size:14px;">
                                <tr>
                                    <td align="left" style="font-size:12px;">Date:
                                        <span style="font-weight:bold;"><?= date('d/m/Y', strtotime($keys['created_date']))?></span>
                                    </td>

                                    <td align="center" style="font-size:12px;">Keys in Showroom:
                                        <span style="font-weight:bold;"><?=$keys['keys_in']?></span>
                                    </td>

                                    <td align="right" style="font-size:12px;">Keys in Office:
                                        <span style="font-weight:bold;"><?=$keys['keys_out']?></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <?php $table_no=1;$i=0; foreach($new_stock_list as $stock_list){ ?>
                            <table style="width:100%; padding-top:30px;font-size:13px; <?= $table_no!=$no_pages?'page-break-after: always;':'' ?> " border="1">
                                <tr>
                                    <th style="background:#ddd;padding:5px; font-size:16px;">Sl.No</th>
                                    <th  style="background:#ddd;padding:5px; font-size:16px;">Stock Details</th>
                                    <th  style="background:#ddd;padding:5px; font-size:16px;">Status</th>
                                </tr>

                             <?php $status_map=[1=>'In',2=>'Out',3=>'Other',4=>'Refurb',5=>'Delivered',6=>'Removed'];
                             
                             foreach($stock_list as $list){
                                 
                                 $name='';
                                 if($list['tally_status']==3 || $list['tally_status']==4){
                                    $name= isset($list['assigned_to'])?'- '.$list['assigned_to']:'';
                                 }
                                 
                              ?>
                                <tr style="">
                                    <td style="padding:5px;  font-weight:bold"><?= ++$i ?></td>
                                    <td style="padding:5px; font-weight:bold"><?=$list['make'].' '.$list['model'].' '.$list['version'].' '.$list['reg_no'].' '.$list['make_year']?> Model</td>
                                    <td style="padding:5px;  font-weight:bold"><?=$status_map[$list['tally_status']].' '.$name?> </td>
                                </tr>
                             <?php 
                             
                              
                             }
                              
                             ?>
                            </table>
                            <?php $table_no++ ; } ?>
                        </td>
                    </tr>





                    <tr>
                        <td>
                            <table style="padding-top:15px; width:100%; font-size:14px;">
                                <tr>
                                    <td align="left" style="">TOTAL STOCK :
                                        <span style="font-weight:bold;"><?=$i?></span>
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>



                    <tr>
                        <td>
                            <table style="padding-top:15px; width:100%; font-size:14px;">
                                <tr>
                                    <td align="left"  style="vertical-align:top; width:35%">
                                        <table style="width:100%">
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td style="width:30%">IN :</td>
                                                            <td style="width:70%;font-weight:bold;"><?=$in_count?></td>

                                                        </tr>

                                                        <tr>
                                                            <td style="width:30%">OUT :</td>
                                                            <td style="width:70%;font-weight:bold;"><?=$out_count?></td>

                                                        </tr>

                                                        <tr>
                                                            <td style="width:30%">REFURB :</td>
                                                            <td style="width:70%;font-weight:bold;"><?=$refurb_count?></td>

                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                    </td>


                                    <td align="center" style="vertical-align:top;width:35%">
                                        <table style="width:100%">
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td style="width:30%">DELIVERED :</td>
                                                            <td style="width:70%;font-weight:bold;"> <?=$delivered_count?></td>

                                                        </tr>

                                                        <tr>
                                                            <td style="width:30%">OTHER :</td>
                                                            <td style="width:70%;font-weight:bold;"> <?=$other_count?></td>

                                                        </tr>
                                                        <tr>
                                                            <td style="width:30%">REMOVED :</td>
                                                            <td style="width:70%;font-weight:bold;"> <?=$removed_count?></td>

                                                        </tr>


                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                    <td align="right" style="width:30%" >
                                        <table style="width:100%">
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td style="width:30%">UPDATED BY :</td>
                                                            <td style="width:70%; font-weight:bold;"><?=$updated_by['name']?></td>

                                                        </tr>

                                                        <tr>
                                                            <td style="width:30%">DATE :</td>
                                                            <td style="width:70%;font-weight:bold;"><?=date('d/m/Y', strtotime($keys['created_date']))?></td>

                                                        </tr>

                                                        <tr>
                                                            <td style="width:30%">TIME :</td>
                                                            <td style="width:70%;font-weight:bold;"><?=date('g:i A', strtotime($keys['created_date']))?></td>

                                                        </tr>
                                                    </table>
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
</html>