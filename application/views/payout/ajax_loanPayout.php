                                        <?php 
           if(!empty($loan_listing))
           {
               $countArr = array_count_values($loan_list_id);
               $dateLable = '';
               foreach($loan_listing as $key => $value)
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
             <tr class="hover-section">
              <td style="position:relative">
                                                      <div class="mrg-B5"><b><?=$value['sr_no']?></b></div>
                                                     
                                                   </td>
                                                   <td style="position:relative">
                                                      <div class="mrg-B5"><b><?=ucwords(strtolower($value['name']))?></b></div>
                                                      <div class="font-13 text-gray-customer"><span class="font-13"><?=$value['customer_mobile']?></span><br><?=$value['customer_email']?></div>
                                                      <?php if(!empty($value['residence_address'])){?>
                                                      <div><span class="text-gray-customer font-13"><?=$value['residence_address']?> <?=(!empty($value['customer_city'])?(' ,'.$value['customer_city']):'')?></span></div><?php } ?>
                                                      <div><span class="text-gray-customer font-13"><?=date('d M, Y',strtotime($value['customer_created_on']))?></span></div>
                                                   </td>
                                                   <td style="position:relative">
                                                      <div class="mrg-B5"><b>
                                                      <?php 
                                                         if(!empty($value['make_name'])){
                                                         echo $value['make_name'].' '.$value['model_name'].' '.$value['version_name'];
                                                         }
                                                         else
                                                         {  
                                                            echo "NA";

                                                            }?></b></div>
                                                      <div class="font-13 text-gray-customer"><span class="font-13"><?if(!empty($value['reg_year'])) { echo strtoupper($value['regno']) .' '.$value['reg_year']; ?>    Model <?php } ?></span></div>
                                                      <a href="#" data-toggle="modal">
                                                         <div class="arrow-details" >
                                                            <span class="font-10"><?php $loan_for = ($value['loan_for']=='2')?'Used Car':'New Car';
                                                           echo  $loan_for.' - '.ucwords($value['loan_type']);
                                                              ?></span>
                                                         </div>
                                                      </a>
                                                   </td>
                                                   <td style="position:relative">
                                                   <?php if(!empty($value['file_loan_amount'])){?>
                                                       <div class="mrg-B5 payout_amount_commas" id="<?=$value['sr_no'] ?>"><b>Loan Amount - <i class="fa fa-rupee"></i><span class="<?=$value['sr_no'] ?>">  <?=(!empty($value['disbursed_amount'])?$value['disbursed_amount']:(!empty($value['approved_loan_amt'])?$value['approved_loan_amt']:$value['file_loan_amount']))?></span></b></div>

                                                       <div class="font-13 text-gray-customer"><span class="font-13"><?=$value['financer_name']?></span></div>
                                                      <div ><span class="text-gray-customer font-13">Ref. Id - <?=!empty($value['ref_id'])?$value['ref_id']:'NA'?></span></div>
                                                      <div><span class="text-gray-customer font-13">Interest Rate - <?=(!empty($value['approved_roi'])?$value['approved_roi']:(!empty($value['file_roi'])?$value['file_roi']:'NA'))?>%</span></div>
                                                      <div><span class="text-gray-customer font-13">Loan Tenure - <?=(!empty($value['approved_tenure'])?$value['approved_tenure']:(!empty($value['file_tenure'])?$value['file_tenure']:'NA'))?> Months</span></div><br>
                                                     <?php } else{
                                                         echo "NA";
                                                         }?>
                                                   </td>
                                                   <td style="position:relative">
                                                   <?php $source=($value['source_type']=='1')?'Dealer':'InHouse';?>
                                                      <div class="mrg-B5"><b>Source - <?=$source?></b></div>
                                                      <?php if($source=='Dealer'){?>
                                                      <div class="font-13 text-gray-customer"><span class="font-13">Dealer Organization - <?=$value['organization']?></span></div>
                                                      <div><span class="text-gray-customer font-13">Assigned to - <?=$value['assigned_to']?></span></div>
                                                      <?php } ?>
                                                      <div><span class="text-gray-customer font-13">Sales Executive - <?=$value['sales_executive']?></span></div>
                                            
                                                   </td>
                                                   <td style="position:relative">
                                                      <div class="mrg-B5"><b>Status - <?=$value['file_tag']?></b></div>
                                                      <div class="font-13 text-gray-customer"><span class="font-13"><?=$dateLable?> - <?=$datetime?></span></div>
                                                   </td>
                                                   <?php //echo "<pre>";print_r($value);die;?>
                                                     <td style="position:relative">
                                                     <?php 
                                                      $payout_status = "Pending";
                                                      $dateLable = $datetime = "";
                                                      if(!empty($value['payout_id'])){
                                                          $payout_status = "Paid";
                                                          $dateLable = "Payout On";
                                                          $Payout_datetime = date('d M, Y', strtotime($value['payout_date']));

                                                      }
                                                      ?>                                                                                              
                                                      <div class="mrg-B5"><b>Status - <?=$payout_status?></b></div>
                                                      <?php if(!empty($value['payout_id'])){ ?>
                                                      <div class="font-13 text-gray-customer"><span class="font-13"><?=$dateLable?> - <?=$Payout_datetime?></span></div>
                                                      <div class="font-13 text-gray-customer"><span class="font-13">Payment ID - <?=$value['payout_id']?></span></div>
                                                      <?php }?>
                                                     </td>
                                                </tr>
                                                <?php } ?>

   <tr><td colspan="7" style="text-align: center !important;">
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
             <?php if(empty($loan_listing))
           { echo "<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='".base_url()."assets/admin_assets/images/NoRecordFound.png'></div></td></tr>"; }?>
                                       <span id="imageloder" style="display:none; position:absolute;left: 50%;border-radius: 50%;z-index:999; ">
                                    <img src="<?=base_url('assets/admin_assets/images/loader.gif')?>"></span>    
<script type="text/javascript">
    $('#total_count').text('('+"<?=$total_count?>"+')');
</script>           