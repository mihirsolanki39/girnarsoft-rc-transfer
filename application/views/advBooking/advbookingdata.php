         <?php 
         echo "####@@@@@";
           if(!empty($loan_listing))
           {
               $countArr = array_count_values($loan_list_id);
               $dateLable = '';
               foreach($loan_listing as $key => $value)
               {
                  $linkk =$value['link'];
                  $datetime = '';
                  if (!empty($value['loanid'])) 
                  {
                     $countmore = (int)$countArr[$value['loanid']]-1;
                  }
                  
                ?>
             <tr>
                                                   <td style="position:relative">
                                                      <div class="mrg-B5"><b><?=$value['customer_name']?></b></div>
                                                      <div class="font-13 text-gray-customer"><span class="font-13"><?=$value['customer_mobile']?></span><br><?=$value['customer_email']?></div>
                                                      <div><span class="text-gray-customer font-13">Added On : <?=$value['created_on']?></span></div>
                                                   </td>
                                                   <td style="position:relative">
                                                      <div class="mrg-B5"><b>
                                                      <?php 
                                                         if(!empty($value['make'])){
                                                         echo (!empty($value['color'])?$value['color'].', ':''). $value['make'].' '.$value['model'].' '.$value['version'];
                                                         }
                                                         else
                                                         {  
                                                            echo "NA";

                                                            }?></b></div>
                                                     <!-- <div class="font-10 text-gray-customer"><span class="font-10">
                                                      <?if(!empty($value['color'])) { echo $value['color']; } ?> </span></div>-->

                                                      <a href="#" data-toggle="modal">
                                                         <div class="arrow-details" >
                                                            <span class="font-10"><?=$value['registration']?></span>
                                                         </div>
                                                      </a>
                                                   </td>
                                                   <td style="position:relative">
                                                   <?php if(!empty($value['showroom'])){?>
                                                      <div class="mrg-B5"><b>Showroom - <?=(!empty($value['showroom'])?$value['showroom']:'NA');?></b></div>
                                                      <div class="font-13 text-gray-customer">Booking Amount  <i class="fa fa-rupee"></i><?=$value['booking_amount']?></div>
                                                      <div ><span class="text-gray-customer font-13">Paid To - <?=$value['amount_paid_to']?></span></div>
                                                      <div><span class="text-gray-customer font-13">Showroom Booking No - <?=(!empty($value['showroom_booking_no'])?$value['showroom_booking_no']:'NA')?></span></div>
                                                       <div><span class="text-gray-customer font-13">Booking Slip No - <?=(!empty($value['booking_slip_no'])?$value['booking_slip_no']:'NA')?></span></div>
                                                      <div><span class="text-gray-customer font-13">Booking Date- <?=(!empty($value['booking_date'])?$value['booking_date']:'NA');?> </span></div><br>
                                                      <?php } else{
                                                         echo "NA";
                                                         }?>
                                                   </td>
                                                   <td style="position:relative">
                                                      <div class="mrg-B5"><b>Source - <?=$value['source']?></b></div>
                                                      <?php if($value['source']=='Dealer'){?>
                                                      <div class="font-13 text-gray-customer"><span class="font-13">Dealer Organization - <?=(!empty($value['dealer_name'])?$value['dealer_name']:'NA');?></span></div><?php } ?>
                                                      <div><span class="text-gray-customer font-13">Sales Executive - <?=$value['emp_name']?></span></div>
                                                   </td>
                                                   <td>
                                                      <div >
                                                        <a href="<?=$linkk?>" ><button data-target="#booking-done" data-toggle="tooltip" title="view detail" data-placement="top" class="btn btn-default">VIEW DETAILS</button></a>
                                                      </div>
                                                   </td></tr>
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
                                    <li class="<?=$i?>" onclick="pagination('<?php echo $prePage ?>');"><a href="#" aria-label="Previous"><span aria-hidden="true">Prev</span></a></li>
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
                                ?>
                               <!-- <?php echo $page ?></a></li>  -->
                               <li class="active" onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $page ?></a></li> 
                                <?php
                                //this will print pages which will come after current page
                                for ($i = $page + 1; $i <= $total_pages; $i++) {
                                    ?>
                                    <li class="<?=$i?>"  onclick='pagination(<?php echo $i; ?>);' ><a href='#'><?php echo $i; ?></a></li> 
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
<?php }else{

echo "1";exit;

 }?>

<script type="text/javascript">
    $('#total_count').text('('+"<?=$total_count?>"+')');
</script>


      


                                               
