<?php
 if(!empty($insurance_listing)){
                              $i=1;
                              foreach($insurance_listing as $values){
                              ?>
                              <tr>
                                <td>
                                  
                                  <div class="font-13 text-gray-customer">
                                   <span class=""><?php echo $values['sno'];?></span>
                                  </div>
                                </td>
                                <td>
                                    <div class="mrg-B5"><b><?php echo !empty($values['customer_name'])?$values['customer_name']:$values['customer_company_name'];?></b></div>
                                    <div class="font-13 text-gray-customer"><span class=""><?php echo !empty($values['mobile'])?$values['mobile']:"";?></span><br></div>
                                    <div><span class="text-gray-customer"><?php echo $values['customer_city_name']?$values['customer_city_name']:"";?></span></div>
                                    <div class="mrg-T10"><span class="text-gray-customer text-gray-date font-13"><?php echo $values['created_date']!='0000-00-00' ? date("d M, Y",strtotime($values['created_date'])) : '00-00-0000'; ?></span></div>
                                  </td>
                                <td>
                                   <?php if (!empty($values['makeName']))
                          { ?>
                  <div class="mrg-B5">
                      <b><?php echo $values['makeName'] . ' ' . $values['modelName'] . ' ' . $values['versionName']; ?> 
                     </b>
                 </div>
                <?php } ?>
                                     <div class="font-13 text-gray-customer"><span class=""><?php echo $values['regNo'] ? strtoupper($values['regNo']) : 'Un-registered'; ?><span class="dot-sep"></span><?php echo $values['make_year'] ? $values['make_year'] : 'NA'; ?> Model</span></div>

                                       <?php if($values["ins_category"]!=''){ 
                                          $tagname = "";
                                          if($values['ins_category']=='1'){
                                                 $tagname='New Car';
                                               }else if($values['ins_category']=='2'){
                                                 $tagname='Used Car Purchase';
                                               }else if($values['ins_category']=='3'){
                                                 $tagname='Renewal';
                                               }else if($values['ins_category']=='4'){
                                                 $tagname='Policy Expired';
                                               }?>
                                    <div class="arrow-details">
                                    <span class="font-10"><?php echo $tagname;?></span>
                                    </div>
                                  <?php } ?>
                                </td>
                                <td>
                                  <div class="mrg-B5">
                                     <b>Policy No - </b>
                                                                            <b> <?php echo $values['current_policy_no'] ? $values['current_policy_no'] : 'NA'; echo"<br>";?>
                                                                              
                                                                            </b>
                                  <!--  <b>Policy Amt - </b>
                                   <b> <span class="indirupee rupee-icon"></span>1233</b> -->
                                </div>
                                <?php
                                                                            if (!empty($values['short_name']))
                                                                            {
                                                                                $company = $values['short_name'];
                                                                            }
                                                                            else
                                                                            {
                                                                                $company = !empty($values['prev_policy_insurer_name']) ? $values['prev_policy_insurer_name'] : "";
                                                                            }
                                                                            ?>
                                <div class="text-gray-customer"><?php echo $company ? $company : 'NA' ?></div>
                                <div class="text-gray-customer">
                                    IDV - <span class="indirupee rupee-icon"> <?php echo !empty($values['idv'])?indian_currency_form($values['idv']):"NA"; ?> </span> 
                                </div>
                                <div class="text-gray-customer">
                                    OD Amount -<span class="indirupee rupee-icon">  <?php echo !empty($values['own_damage'])?indian_currency_form($values['own_damage']):"NA";?></span>
                                </div>

                                <div class="text-gray-customer">
                                    Add-On -<span class="indirupee rupee-icon">  <?php echo !empty($values['addOns'])?indian_currency_form($values['addOns']):"NA";?></span>
                                </div>


                                 <div class="text-gray-customer">
                                    Premium -<span class="indirupee rupee-icon">  <?php echo !empty($values['totalpremium'])?indian_currency_form($values['totalpremium']):"NA";?></span>
                                </div>

                                
                                </td>
                                <td>
                                  <div class="mrg-T5"><b><?php echo $values['policy_status'] ? $values['policy_status'] : 'Issued';?></b></div>
                                    <div class="text-gray-customer">Added on :<?php echo date("d M, Y",strtotime($values['last_updated_date']));  ?></div>

                                      <!-- <?php
                                                                                if ($values["ins_category"] != '') {
                                                                                    $tagname = "";
                                                                                    if ($values['ins_category'] == '1') {
                                                                                        $tagname = 'New Car';
                                                                                    } else if ($values['ins_category'] == '2') {
                                                                                        $tagname = 'Used Car Purchase';
                                                                                    } else if ($values['ins_category'] == '3') {
                                                                                        $tagname = 'Renewal';
                                                                                    } else if ($values['ins_category'] == '4') {
                                                                                        $tagname = 'Policy Expired';
                                                                                    }
                                                                                    ?>
                                    <div class="arrow-details alert-btn">
                                        <span class="font-10"><?php echo $tagname;?></span>
                                        </div>
                                      <?php } ?> -->
                                </td>
                                <td>

                                  <?php  if (isset($values['payout_percentage']) && !empty($values['payout_percentage'])){
                                   if (($values['source_id'] != 1) &&($values['source_id']!= 0)) { 
                                    $payoutpercentage = $source_percentage[$values['source_id']]; ?>
                                  <div class="mrg-B5">
                                   <b>Percentage -</b>
                                   <b><input disabled type="text" value="<?php echo !empty($payoutpercentage)?$payoutpercentage."%":""; ?>" class="form-control" style="width: 50px;
                                    display: inline-block;" readonly></b><br>
                                   <?php }else{

                                    $payoutpercentage = $values['payout_percentage'];
                                    ?>
                                    <b>Percentage - </b>
                                  
                                   <b><input  disabled type="text" value="<?php echo !empty($payoutpercentage)?$payoutpercentage."%":""; ?>" class="form-control" style="width: 50px;
                                    display: inline-block;" readonly></b><br>              </div> <?php

                                     } 
                                 
                                  $payoutTotal = !empty($values['actual_payout_amount'])?$values['actual_payout_amount']:"0";
                                    ?>
                                  <div class="text-gray-customer">Payout - <span class="indirupee rupee-icon"> </span><?php echo !empty($payoutTotal)?indian_currency_form($payoutTotal)."/-":""; ?></div>

                               <?php  }?>

                                
                                </td>

                                <td>
                                    <div class="mrg-B5">
                                     <b>Percentage - </b>
                                     <b><input disabled value="<?php echo !empty($values['payout_perc_from_company'])?$values['payout_perc_from_company']."%":"NA" ?>" type="text" class="form-control" style="width: 50px;
                                      display: inline-block;""></b><br>              
                                      </div>

                                      <?php 
                                      $payout_company = 0;
                                      if(!empty($values['payout_from_company'])) {
                                       $settlediffrence = !empty($values['settlediffrence'])?$values['settlediffrence']:0;
                                       $payout_company = $values['payout_from_company'] + $settlediffrence;
                                      }?>
                                    <div class="text-gray-customer">Payout -<span class="indirupee rupee-icon"> </span>
                                      <?php echo !empty($payout_company)?indian_currency_form($payout_company)."/-":"NA"?></div>
                                </td>

                                <td>
<?php 
if($values['payout_from_company']){

    $totalActualPayout    = !empty($payoutTotal)?$payoutTotal:0;
    $totalPaidfromCompany = !empty($payout_company)?$payout_company:0;
    $differencePayout = round(($totalActualPayout - $totalPaidfromCompany));
}else{
  $differencePayout  = 0;
}

    ?>
                                  <div class="red" >
                                    <input type="hidden" name="diffPayId" id="diffPayId_<?php echo $values['current_policy_no'];?>" value="<?php echo !empty($differencePayout)?$differencePayout:0;?>">
                                      <span class="indirupee rupee-icon" ></span> <?php echo !empty($differencePayout)?indian_currency_form($differencePayout)."/-":0;?>
                                  </div>
                                </td>

                                 <td>
                                    <div class="red">
                                      <?php if($values['insStatus']=='2') { ?>
                                      <textarea class="form-control" id="comment_<?= $values['current_policy_no']?>" onblur="clearError('<?= $values['current_policy_no']; ?>')"></textarea>
                                      <div class="error_<?= $values['current_policy_no']?>"></div>
                                      <button class="btn btn-default" data-toggle="modal" data-target="#editPayout" onclick="editPayout('<?php echo !empty($values['current_policy_no'])?$values['current_policy_no']:0;?>')">Settle Difference </button>
                                    <?php } else if($values['insStatus']=='3'){ ?>
                                      <div class="red">
                                     </div>
                                   <div class="red">
                                     Status- <?php echo "Paid<br>";?>
                                   </div>
                                  <?php if(!empty($values['settleComment']) && !empty($values['comment_create_date'])){?>
                                  <div class="red">
                                     Comment- <span class="" ><?php echo $values['settleComment']."<br>";?></span>
                                  </div>
                                
                                    <div class="red">
                                     Settled Date- <?php echo  !empty($values['comment_create_date'])?date("d M, Y",strtotime($values['comment_create_date'])):"NA";?>
                                    </div> 
                               <?php  } } else{ ?>
                                <div class="red">
                                   
                                    Status- <?php echo "Pending<br>";?>
                                  </div>
                                   <?php if(!empty($values['settleComment']) && !empty($values['comment_create_date'])){?>
                                  <div class="red">
                                    Comment-
                                      <span class="" ><?php echo $values['settleComment']."<br>";?></span>
                                    </div>
                                  
                                    <div class="red">
                                      Settled Date- <?php echo  !empty($values['comment_create_date'])?date("d M, Y",strtotime($values['comment_create_date'])):"NA";?>
                                  </div>
                                      <?php }  } ?>
                                    </div>
                                  </td>

                               
                                 

                                </tr>


                       <?php
                            }
                          }?>

                         <tr><td colspan="10" style="text-align: center !important;">
                        <?php
                        if ((int) $total_count > 0) {

                        ?>
                         <div class="col-lg-12 col-md-6">
                         <nav aria-label="Page navigation">
                        <ul class="pagination" >                                             <?php
                            $total_pages = ceil($total_count / $limit);
                           // echo $limit."666"+$total_count;die;
                            $pagLink     = "";
                            
                            if ($total_pages < 1) {
                                $total_pages = 1;
                            }
                            if ($total_pages != 1) {
                                if ((int) $page > 1) {
                                    $prePage = (int) $page - 1;
                        ?>                                                                     <li onclick="pagination('<?= $prePage;?>');">
                           <a href="#" aria-label="Previous"><span aria-hidden="true">Prev</span></a>
                       </li>
                       <?php
            //this for loop will print pages which come before the current page
            for ($i = (int) $page - 6; $i < $page; $i++) {
             if ($i > 0) {
             ?>
            <li class="<?= $i ?>" onclick='pagination(<?php echo $i; ?>);'>
              <a href='#'><?php echo $i; ?>
              </a>
              </li>
              <?php
                }
             }
        }
        //this is the current page
        // if($i > $page){ ?>
          <li class="active"  onclick='pagination(<?php  echo $i; ?>);'>
            <a href='#'><?php echo $page; ?></a>
            </li>
            <?php  // }
        //this will print pages which will come after current page
        for ($i = $page + 1; $i <= $total_pages; $i++) {  ?> 
          <li class="<?= $i ?>" onclick='pagination(<?php echo $i; ?>);' >
            <a href='#'><?php echo $i; ?></a>
            </li> 
            <?php if ($i >= $page + 3) {
                break;
            }
        } 
        // this is for next button
        if ($page != $total_pages) {
          $nextPage = (int) $page + 1;  ?> 
          <li onclick="pagination('<?php echo $nextPage; ?>')">
            <a href="#" aria-label="Next"><span aria-hidden="true">Next</span></a>
          </li> <?php } }   ?> 
        </ul> 
           </nav> 
         </div> <?php  }   ?>    
         </td>

       </tr>

        <?php if (empty($insurance_listing)) {
    echo "<tr><td align='center' colspan='10'><div class='text-center pad-T30 pad-B30'><img src='" . base_url() . "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>";
}
?>
<script type="text/javascript">
    $('#total_count').text('('+"<?=$total_count?>"+')');
</script>