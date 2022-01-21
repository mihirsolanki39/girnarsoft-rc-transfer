<?php 
           if(!empty($insurance_listing))
           {
               $countArr = array_count_values($loan_list_id);
               $dateLable = '';
               foreach($insurance_listing as $key => $value)
               {
                  $reopen  = '';
                  $datetime = '';
                  $tagStatus =  $value['file_tag'];
                  if (!empty($value['loanid'])) 
                  {
                     $countmore = (int)$countArr[$value['loanid']]-1;
                  }
                  if(!empty($value['tag_flag']) && $value['tag_flag']=='4')
                  {
                     $dateLable = 'Disbursed on';
                     if($value['disbursed_date']!='0000-00-00 00:00:00')
                     {
                        $datetime = date('d M, Y', strtotime($value['disbursed_date']));
                     }
                  }                 
                  if(!empty($value['loan_approval_status']) && ($value['loan_approval_status']=='7' || $value['loan_approval_status']=='8'))
                  {
                     if(!empty($value['upload_docs_created_at']) && $value['loan_approval_status']=='7')
                     {
                        $dateLable = 'Login Docs Collected';
                        $datetime = date('d M, Y', strtotime($value['upload_docs_created_at']));
                     }
                     if(!empty($value['upload_dis_created_date']) && $value['loan_approval_status']=='8')
                     {
                        $dateLable = 'Disbursed Docs Collected';
                        $datetime = date('d M, Y', strtotime($value['upload_dis_created_date']));
                     }
                  }
                ?>
             <tr>
                    <td>
                     <div class="font-13 text-gray-customer">
                     <span class=""><?php echo $value['sno']; ?></span>
                     </div>
                    </td>

                     <td>
                      <?php if($value['buyer_type']=='1'){?>    
                        <div class="mrg-B5"><b><?php echo (($value['customer_name'] != '') ? ucwords(strtolower($value['customer_name'])) : 'NA'); ?></b></div>
                      <?php } elseif ($value['buyer_type'] == '2') { ?>
                         <div class="mrg-B5"><b><?php echo (($value['customer_company_name'] != '') ? ucwords(strtolower($value['customer_company_name'])) : 'NA'); ?></b></div>
                      <?php } ?>
                     <div class="font-13 text-gray-customer"><span class=""><?php echo $value['mobile']; ?></span><br></div>
                     <div><span class="text-gray-customer"><?php echo $value['customer_city_name']; ?></span></div>
                     <div class="mrg-T10"><span class="text-gray-customer text-gray-date font-13"><?php echo $value['created_date']!='0000-00-00' ? date("d M, Y",strtotime($value['created_date'])) : '00-00-0000'; ?></span></div>
                    </td>
                    
                    <td>
                    <?php if (!empty($value['makeName']))
                          { ?>
                  <div class="mrg-B5">
                      <b><?php echo $value['makeName'] . ' ' . $value['modelName'] . ' ' . $value['versionName']; ?> 
                     </b>
                 </div>
                <?php } ?>
                  <div class="font-13 text-gray-customer"><span class=""><?php echo $value['regNo'] ? strtoupper($value['regNo']) : 'Un-registered'; ?><span class="dot-sep"></span><?php echo $value['make_year'] ? $value['make_year'] : 'NA'; ?> Model</span></div>
                <a href="#" data-toggle="modal">
                <?php if($value["ins_category"]!=''){ 
                $tagname = "";
                if($value['ins_category']=='1'){
                       $tagname='New Car';
                     }else if($value['ins_category']=='2'){
                       $tagname='Used Car Purchase';
                     }else if($value['ins_category']=='3'){
                       $tagname='Renewal';
                     }else if($value['ins_category']=='4'){
                       $tagname='Policy Expired';
                     }?>
                 <div class="arrow-details">
                 <span class="font-10"><?php echo $tagname;?> </span>
                 </div> <?php } ?>
                  </td>



                   <td><div class="mrg-B5">
                                                                            <b>Policy No - </b>
                                                                            <b> <?php echo $value['current_policy_no'] ? $value['current_policy_no'] : 'NA'; ?></b>
                                                                        </div>
                                                                        <?php
                                                                            if (!empty($value['short_name']))
                                                                            {
                                                                                $company = $value['short_name'];
                                                                            }
                                                                            else
                                                                            {
                                                                                $company = !empty($value['prev_policy_insurer_name']) ? $value['prev_policy_insurer_name'] : "";
                                                                            }
                                                                            ?>
                                                                        
                                                                        <div class="text-gray-customer"><?php echo $company ? $company : 'NA' ?></div>
                                                                        <div class="text-gray-customer">
                                                                            IDV - <span class="indirupee rupee-icon"><?php echo $value['idv'] ? indian_currency_form($value['idv']) : '0' ?></span> 
                                                                        </div>
                                                                       

                                                                        <div class="text-gray-customer">
                                                                            OD Amount - <span class="indirupee rupee-icon"> <?php echo $value['own_damage'] ? $value['own_damage'] : '0'; ?></span>
                                                                        </div>
                                                                         <?php
                                                                                $addOn = 0;
                                                                                if ($value['road_side_assistance'] == '1') {
                                                                                    $addOn = (int) $value['road_side_assistance_txt'];
                                                                                }
                                                                                if ($value['loss_of_personal_belonging'] == '1') {
                                                                                    $addOn += (int) $value['loss_of_personal_belonging_txt'];
                                                                                }
                                                                                if ($value['emergency_transport_hotel_premium'] == '1') {
                                                                                    $addOn += (int) $value['emergency_transport_hotel_premium_txt'];
                                                                                }

                                                                                if ($value['driver_cover'] == '1') {
                                                                                    $driver_cover = (int) $value['paid_driver'];
                                                                                }
                                                                                if ($value['personal_acc_cover'] == '1') {
                                                                                    $personal_acc_cover = (int) $value['personal_acc_cover'];
                                                                                }
                                                                                if ($value['passenger_cover'] == '1') {
                                                                                    $passenger_cover = $value['pass_cover'];
                                                                                }
                                                                                if ($value['anti_theft'] == '1') {
                                                                                    $addOn -= $value['anti_theft_txt'];
                                                                                }
                                                                                if ($value['add_on']) {
                                                                                    $addOn += $value['add_on'];
                                                                                }
                                                                                ?>     
                                                                                <div class="font-14 text-gray-customer">
                                                                                    <?php echo 'AddOns - '; ?>
                                                                                    <span class="indirupee rupee-icon"> <?php echo (!empty($addOn) ) ? indian_currency_form($addOn) : '0'; ?></span>
                                                                                </div>
                                                                        <div class="text-gray-customer">
                                                                            Premium - <span class="indirupee rupee-icon"> <?php echo $value['totalpremium'] ? indian_currency_form($value['totalpremium']) : '0'; ?> </span>
                                                                        </div>
                                                                    </td>
                                                                    
                                                                    <td>
                                                                        <div class="mrg-T5"><b>Source -<?php if($value['source']=='dealer') echo 'Dealer'; else echo $value['source'];?></b></div>
                                                                        <div class="font-14 text-gray-customer"><?php if($value['source']=='dealer'){ echo 'Dealership Name - '.ucfirst($value['dealerName']); } ?></div>
                                                                        <div class="font-14 text-gray-customer">
                                                                          <?php echo (!empty($value['employeeName'])) ? 'Assigned To - '.ucfirst($value['employeeName']) : '';?> 
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="mrg-B5">
                                                                            <b>Status - </b>
                                                                             <b><?php echo !empty($value['updateStatus']) ? $value['updateStatus'] : 'Issued'; ?></b><br></div>
                                                                        <div class="text-gray-customer">Issue Date - <?php echo date("d M, Y",strtotime($value['current_issue_date']));  ?></div>
                                                                    </td>

                                                                    <td>
                                                                        <div class="font-13 text-gray-customer">
                                                                                    <?php
                                                                                    $payout_status = "Pending";
                                                                                    $dateLable = $datetime = "";
                                                                                    if (!empty($value['payout_id'])) {
                                                                                        $payout_status = "Paid";
                                                                                        $dateLable = "Payout On";
                                                                                        $Payout_datetime = date('d M, Y', strtotime($value['payout_date']));
                                                                                    }
                                                                                    ?>                                                                                              
                                                                                    <div class="mrg-B5"><b>Status - <?= $payout_status ?></b></div>
                                                                                    <?php if (!empty($value['payout_id'])) { ?>
                                                                                        <div class="font-13 text-gray-customer"><span class="font-13"><?= $dateLable ?> - <?= $Payout_datetime ?></span></div>
                                                                                        <div class="font-13 text-gray-customer"><span class="font-13" style="cursor: pointer;" onclick='getPaymentHistory("<?=$value['payout_id']?>")'>Payment ID - <?= $value['payout_id'] ?></span></div>
                                                                                    <?php } ?>
                                                                                </div>
                                                                    </td>
                                                                </tr>
                                                <?php } ?>

   <tr>
       <td colspan="7" style="text-align: center !important;">
    <?php if ((int)$total_count > 0) { ?>

                <div class="col-lg-12 col-md-6">
                    <nav aria-label="Page navigation">
                        <ul class="pagination" >
                            <?php
                            $total_pages = ceil($total_count / $limit);
                            $pagLink = "";

                            if ($total_pages < 1) {
                                $total_pages = 1;
                            }

                            if ($total_pages != 1) {

                                //this is for previous button
                                if ((int)$page > 1) {
                                    $prePage = (int)$page - 1;
                                    ?>
                                    <li onclick="pagination('<?php echo $prePage ?>');"><a href="#" aria-label="Previous"><span aria-hidden="true">Prev</span></a></li>
                                    <?php
                                    //this for loop will print pages which come before the current page
                                    for ($i = (int)$page - 6; $i < $page; $i++) {
                                        if ($i > 0) {
                                            ?>   
                                            <li class="<?=$i?>" onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $i; ?></a></li>
                                            <?php
                                        }
                                    }
                                }

                                //this is the current page
                                // if($i > $page){ ?>
                                <li class="active"  onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $page ?></a></li>
                               
                                <?php
                             // }
                                //this will print pages which will come after current page
                                for ($i = $page + 1; $i <= $total_pages; $i++) {
                                    ?>
                                    <li class="<?=$i?>" onclick='pagination(<?php echo $i; ?>);' ><a href='#'><?php echo $i; ?></a></li> 
                                    <?php
                                    if ($i >= $page + 3) {
                                       break;
                                    }
                                }

                                // this is for next button
                                if ($page != $total_pages) {
                                    $nextPage = (int)$page + 1;
                                    ?> 
                                    <li onclick="pagination('<?php echo $nextPage; ?>')"><a href="#" aria-label="Next"><span aria-hidden="true">Next</span></a></li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
                        <?php } ?>     
        </td></tr>
   <?php } ?>
             <?php if(empty($insurance_listing))
           { echo "<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='".base_url()."assets/admin_assets/images/NoRecordFound.png'></div></td></tr>"; }?>
                                       <span id="imageloder" style="display:none; position:absolute;left: 50%;border-radius: 50%;z-index:999; ">
                                    <img src="<?=base_url('assets/admin_assets/images/loader.gif')?>"></span>    
<script type="text/javascript">
    $('#total_count').text('('+"<?=$total_count?>"+')');
</script>           