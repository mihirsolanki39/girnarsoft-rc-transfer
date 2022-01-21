<?php
if(!empty($query)){
foreach ($query as $key=>$val){ 
  
$val['quote_add_date']=($val['quote_add_date']!='0000-00-00 00:00:00') ? date("d M,Y",strtotime($val['quote_add_date'])):'';
$val['source'] =  ucfirst(strtolower($val['source']));
$val['lead_status_id'] = $val['follow_status'];
$val['lead_status'] = $val['status_name'];
$val['leadCreatedDate'] = ($val['addDate']!='0000-00-00') ? date("d M, Y",strtotime($val['addDate'])) : '';
$val['last_updated_date'] = ($val['last_updated_date']!='0000-00-00 00:00:00') ? date("d M, Y",strtotime($val['last_updated_date'])) : '';
$val['created_date'] = ($val['created_date']!='') ? date("d M, Y",strtotime($val['created_date'])) : '';
$val['due_date'] = ( ($val['current_due_date']!='0000-00-00') && (!empty($val['current_due_date'])) ) ? date("d M, Y",strtotime($val['current_due_date'])) : '';
$val['previous_due_date'] = ($val['previous_due_date']!='0000-00-00') ? date("d M, Y",strtotime($val['previous_due_date'])) : '';
$val['payment_date']=($val['payment_date']!='0000-00-00' && !empty($val['payment_date']) ) ? date("d M, Y",strtotime($val['payment_date'])):'';    
$val['inspection_add_date']=($val['inspection_add_date']!='0000-00-00 00:00:00') ? date("d M, Y",strtotime($val['inspection_add_date'])) : '';
$val['current_issue_date'] = ($val['current_issue_date']!='0000-00-00' && !empty($val['current_issue_date'])) ? date("d M, Y",strtotime($val['current_issue_date'])) : '';
$val['in_payment_date'] = ($val['in_payment_date']!='0000-00-00 00:00:00' && !empty($val['in_payment_date'])) ? date("d M, Y",strtotime($val['in_payment_date'])) : '';
$val['inception_date']= ( ($val['inception_date']!='0000-00-00') && (!empty($val['inception_date'])) ) ? date("d M, Y",strtotime($val['inception_date'])) : '';
   
$link=''; 

if(empty($link)){
$link=!empty($val["upload_ins_doc_flag"])? base_url('insDocumentDetails/').base64_encode('CustomerId_'.$val["customer_id"]):'';
}
if(empty($link)){
$link=!empty($val["payment_by"])? base_url('insPolicyDetails/').base64_encode('CustomerId_'.$val["customer_id"]):'';
}
if((empty($link)) && ($val['mi_funding']=='2')){     
                      $link=(!empty($val["customer_address"]) && $val["customer_address"]!='') ? base_url('inspaymentDetail/').base64_encode('CustomerId_'.$val["customer_id"]):'';
                    }
if(empty($link) && (($val['ins_category']=='2') || ($val['ins_category']=='4'))){
$link=(!empty($val["inspection_add_date"]) && ($val["inspection_add_date"]!='0000-00-00 00:00:00')) ? base_url('inspersonalDetail/').base64_encode('CustomerId_'.$val["customer_id"]):'';
//$link=!empty($val["customer_address"]) ? base_url('insPolicyDetails/').base64_encode('CustomerId_'.$val["customer_id"]):'';
}

if(empty($link) && ($val["ins_category"]=='4' && $val["isexpired"]=='1')){
$link=!empty($val["quote_add_date"] && ($val["quote_add_date"]!='0000-00-00 00:00:00'))? base_url('insInspection/').base64_encode('CustomerId_'.$val["customer_id"]):'';
}elseif(empty($link) && ($val["ins_category"]=='2')){
 $link=!empty($val["quote_add_date"] && ($val["quote_add_date"]!='0000-00-00 00:00:00'))? base_url('insInspection/').base64_encode('CustomerId_'.$val["customer_id"]):'';   
}
if(empty($link) && ($val["ins_category"]=='4' && $val["isexpired"]=='0')){
$link=!empty($val["quote_add_date"] && ($val["quote_add_date"]!='0000-00-00 00:00:00')) ? base_url('insPreviousDetails/').base64_encode('CustomerId_'.$val["customer_id"]):'';
}elseif(empty($link) && ($val["ins_category"]=='3')){
$link=!empty($val["quote_add_date"] && ($val["quote_add_date"]!='0000-00-00 00:00:00')) ? base_url('insPreviousDetails/').base64_encode('CustomerId_'.$val["customer_id"]):'';    
}elseif(empty($link) && ($val["ins_category"]=='1')){
$link=!empty($val["quote_add_date"] && ($val["quote_add_date"]!='0000-00-00 00:00:00')) ? base_url('inspersonalDetail/').base64_encode('CustomerId_'.$val["customer_id"]):'';    
}
if(empty($link)){   
$link=!empty($val["make"])? base_url('insFileLogin/').base64_encode('CustomerId_'.$val["customer_id"]):'';
}
if(empty($link)){
$link= !empty($val["ins_category"])? base_url('insvehicalDetail/').base64_encode('CustomerId_'.$val["customer_id"]):'';
}

if(empty($link)){
$link =base_url('addInsurance');    
}
?>
<tr class="hover-section" >
  <td style="position:relative"><?=$val['sno']?></td>
            <td style="position:relative">
            <?php if($val['buyer_type']=='1'){?>    
            <div class="mrg-B5"><b><?php echo (($val['customer_name'] != '') ? ucwords(strtolower(preg_replace("/[^a-zA-Z\s]/", "", $val['customer_name']))) : 'NA'); ?></b></div>
            <?php } elseif($val['buyer_type']=='2') {?>
            <div class="mrg-B5"><b><?php echo (($val['customer_company_name'] != '') ? ucwords(strtolower($val['customer_company_name'])) : 'NA'); ?></b></div>
            <?php } ?>
            <div class="font-13 text-gray-customer"><span class="font-14"><?php echo  preg_replace("/[^0-9]/", "", $val['mobile']); ?></span><br><?php echo $val['customer_email']; ?></div>
            <div><span class="text-gray-customer font-14"><?php echo ucwords(strtolower(preg_replace("/[^a-zA-Z\s]/", "", $val['city_name']))); ?></span></div>
            <?php if(!empty($val['customer_nominee_ref_name'])) { ?>
            <div><span class="text-gray-customer font-14">Reference: <?php echo ucwords(strtolower(preg_replace("/[^a-zA-Z\s]/", "", $val['customer_nominee_ref_name']))); ?></span></div>
            <?php } ?>
            <div class="mrg-T10"><span class="text-gray-customer text-gray-date font-13"><?php echo $val['leadCreatedDate']; ?></span></div>
        </td>
        <td style="position:relative">
            <?php if(!empty($val['makeName'])){?>
               <div class="mrg-B5">
                   <b><?php 
                        echo $val['makeName'].' '.$val['modelName'].' '.$val['versionName'];
                        ?>
                   </b>
               </div>

            <div class="font-13 text-gray-customer"><span class="font-14"><?php echo ($val['regNo']) ? strtoupper($val['regNo']).'<span class="dot-sep"></span>':'';?><?php echo ($val['make_year']) ? $val['make_year']: '';?> Model</span></div>
               <?php if($val['ins_category']=='1'){
                   $tagname='New Car';
               }else if($val['ins_category']=='2'){
                   $tagname='Used Car Purchase';
               }else if($val['ins_category']=='3'){
                   $tagname='Renewal';
               }else if($val['ins_category']=='4'){
                   $tagname='Policy Expired';
               }
               ?>
               <a href="#" data-toggle="modal" >
                <div class="arrow-details" >
                   <span class="font-10"><?php echo $tagname;?></span>
                </div>
               </a>
               <?php } else {  ?>
               <div class="mrg-B5"><b>
               <?php echo "NA"; }?></b>
               </div>
        </td>
        <td style="position:relative">
          <?php if($val['previous_policy_no']) {?>  
          <div class="mrg-B5"><b><?php echo (!empty($val['previous_policy_no'])) ? 'Policy No - '.$val['previous_policy_no']:'';?></b></div>  
          <div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['prev_company_full_name'])) ? $val['prev_company_full_name'] : '';?></span></div>
          <div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['previous_due_date'])) ? 'Due Date - '.$val['previous_due_date']: '';?></span></div>
          <?php } else {?>
          <div class="mrg-B5"><b>NA</b></div>
          <?php } ?>
        </td>
                <?php
                if (!empty($val['insurance_company'])) {
                    $company = $val['insurance_company'];
                } else {
                    $company = !empty($val['inspect_ins_name']) ? $val['inspect_ins_name'] : "";
                }
                ?>
                 <td style="position:relative">
                    <div class="mrg-B5">
                       <b><?php echo 'Policy No - ';?></b>
                       <b> <?php  echo (!empty($val['current_policy_no']) ) ? $val['current_policy_no'] : 'NA' ;?></b>
                    </div>
                    <div class="font-14 text-gray-customer">
                        <?php  echo (!empty($company) ) ? $company : 'NA' ;?>
                    </div>
                    <div class="font-14 text-gray-customer">
                        <?php echo 'IDV - ';
                        $idv = (!empty($val['idv']) ) ? indian_currency_form($val['idv']) : '0';
                        ?>
                        
                        <span class="indirupee rupee-icon"> <?php  echo (!empty($val['insidv'])?indian_currency_form($val['insidv']):$idv);?> </span> 
                    </div>
                     <?php                     
                            $addOn = 0;
                            if ($val['road_side_assistance'] == '1') {
                                $addOn = (int) $val['road_side_assistance_txt'];
                            }
                            if ($val['loss_of_personal_belonging'] == '1') {
                                $addOn += (int) $val['loss_of_personal_belonging_txt'];
                            }
                            if ($val['emergency_transport_hotel_premium'] == '1') {
                                $addOn += (int) $val['emergency_transport_hotel_premium_txt'];
                            }

                            if ($val['driver_cover'] == '1') {
                                $driver_cover = (int) $val['paid_driver'];
                            }
                            if ($val['personal_acc_cover'] == '1') {
                                $personal_acc_cover = (int) $val['personal_acc_cover'];
                            }
                            if ($val['passenger_cover'] == '1') {
                                $passenger_cover = $val['pass_cover'];
                            }
                            if ($val['anti_theft'] == '1') {
                                $addOn -= $val['anti_theft_txt'];
                            }
                            if ($val['add_on']) {
                                $addOn += $val['add_on'];
                            }
                        ?>                    
                        <div class="font-14 text-gray-customer">
                            <?php echo 'AddOns - ';?>
                            <span class="indirupee rupee-icon"> <?php  echo (!empty($addOn) ) ? indian_currency_form($addOn) : '0' ;?></span>
                        </div>
                    <div class="font-14 text-gray-customer">
                        <?php echo 'OD Amount - ';?>
                        <span class="indirupee rupee-icon"> <?php  echo (!empty($val['own_damage']) ) ? indian_currency_form($val['own_damage']) : '0' ;?></span>
                    </div>
                                        <div class="font-14 text-gray-customer">
                        <?php echo 'Premium - ';?>
                                            <span class="indirupee rupee-icon"> <?php  echo (!empty($val['totalpremium']) ) ? indian_currency_form($val['totalpremium']) : '0' ;?> </span>
                    </div>
                    
                 </td>

        <td style="position:relative">
          <div class="font-14 text-gray-customer"><?php if($val['source']=='Dealer'){ echo 'Dealership Name - '.ucfirst($val['dealerName']); } ?></div>
          <div class="font-14 text-gray-customer">
              <?php echo (!empty($val['employeeName'])) ? 'Assigned To - '.ucfirst($val['employeeName']) : '';?> 
              </div>
       </td>
       <td style="position:relative">
         <?php
         $updateStatusDate='Updated On';
          $status_update_date = $val['last_updated_date'];
         if($val['updateStatus']=='New'){
            $updateStatusDate='Created On'; 
            $status_update_date = $val['last_updated_date'];
         }elseif($val['updateStatus']=='Quotes shared'){
            $updateStatusDate='Quotes Shared'; 
            $status_update_date = $val['quote_add_date'];
         }elseif($val['updateStatus']=='Inspection Pending'){
            $updateStatusDate='Inspection Date';            
            $status_update_date = $val['inspection_add_date'];
         }elseif($val['updateStatus']=='Inspection Completed'){
            $updateStatusDate='Inspection Date'; 
            $status_update_date = $val['inspection_add_date'];
         }elseif($val['updateStatus']=='Issued'){
            $updateStatusDate='Issue Date'; 
            $status_update_date = $val['current_issue_date'];
         }elseif($val['updateStatus']=='Policy Pending'){
            $updateStatusDate='Pending On'; 
         }elseif($val['updateStatus']=='Payment Pending'){
            $updateStatusDate='Pending On'; 
         }elseif($val['updateStatus']=='Cancelled'){
            $updateStatusDate='Cancelled Date'; 
         }elseif($val['updateStatus']=='Not Interested'){
            $updateStatusDate='Closed Date'; 
         }
         
?>  
         <div class="mrg-B5">
             <b><?php echo 'Status - ';?></b>
             <?php  
             if(!empty($val['updateStatus']) && !empty($val['inspect_ins_name']) && $val['updateStatus']=='Inspection Completed'){
             echo   '<b>'.$val['updateStatus'].'('.$val['inspect_ins_name'].')</b></br>';
             }else{
                echo   '<b>'.$val['updateStatus'].'</b></br>'; 
             }
             ?>
         </div>
           <div class="font-14 text-gray-customer"><?php echo (!empty($status_update_date)) ?  $updateStatusDate.' - '.$status_update_date:"";?></div>
       </td>
       
        <td class="td-action" style="position:relative">
            <div class="width-save">
                <?php if($val['ins_approval_status']=='6'){?>
                <button data-target="#booking-done" data-toggle="tooltip" title="reopen" onclick="reopen(<?php echo $val['customer_id']?>,'<?php echo $link?>');" data-placement="top" class="btn btn-default">REOPEN</button>
                <?php } else{?>
                <a href="<?php echo $link;?>" ><button data-target="#booking-done" data-toggle="tooltip" title="view detail" data-placement="top" class="btn btn-default">VIEW DETAILS</button></a>
                <?php } ?>
                </br>
                <div class="mrg-T5"><a href="Javascript:void(0);" class="text-link font-13" id="comment_history"><button class="btn btn-default history-more" data-target="#trackhistory" data-toggle="modal" data-id="<?php echo $val["customer_id"];?>" title="timeline">TIMELINE</button></a></div>
                <input type="hidden" name="customer_id" id="customer_id" value="<?php echo (!empty($val['customer_id'])) ? $val['customer_id'] : '';?>">
            </div>
       </td>
</tr>
<?php
} ?><tr><td colspan="8" align="center">
    <?php if (intval($leadtabCount) > 0) { ?>

                <div class="col-lg-12 col-md-6">
                    <nav aria-label="Page navigation">
                        <ul class="pagination" >
                            <?php
                            $total_pages = ceil($leadtabCount / $limit);
                            $pagLink = "";

                            if ($total_pages < 1) {
                                $total_pages = 1;
                            }

                            if ($total_pages != 1) {

                                //this is for previous button
                                if (intval($page) > 1) {
                                    $prePage = intval($page) - 1;
                                    ?>
                                    <li onclick="pagination('<?php echo $prePage ?>');"><a href="#" aria-label="Previous"><span aria-hidden="true">Prev</span></a></li>
                                    <?php
                                    //this for loop will print pages which come before the current page
                                    for ($i = $page - 6; $i < $page; $i++) {
                                        if ($i > 0) {
                                            ?>   
                                            <li onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $i; ?></a></li>
                                            <?php
                                        }
                                    }
                                }

                                //this is the current page
                                ?>
                                <li  class='active' onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $page ?></a></li> 
                                <?php
                                //this will print pages which will come after current page
                                for ($i = $page + 1; $i <= $total_pages; $i++) {
                                    ?>
                                    <li  onclick='pagination(<?php echo $i; ?>);' ><a href='#'><?php echo $i; ?></a></li> 
                                    <?php
                                    if ($i >= $page + 3) {
                                        break;
                                    }
                                }

                                // this is for next button
                                if ($page != $total_pages) {
                                    $nextPage = intval($page) + 1;
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
<?php
if (empty($query)) {
    echo "<tr><td align='center' colspan='8'><div class='text-center pad-T30 pad-B30'><img src='" . base_url() . "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>";
}
?>
<script type="text/javascript">
    $('#totcase').text('' + "<?= $leadtabCount ?>" + '');
</script>
