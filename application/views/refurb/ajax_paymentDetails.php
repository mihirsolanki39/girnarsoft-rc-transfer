

        <div class="container-fluid ">
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="row">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                     <thead>
                        <tr>
                           <th>Payment ID</th>
                           <th>Stock</th>
                           <th>Amount</th>
                          <!-- <th>Date of Purchase</th>-->
                           <th>Instrument No.</th>
                           <th>Instrument Date</th>
                           <th>Payment Mode</th>
                           <th>Payment Date</th>
                           <th>Bank Name</th>
                           <!--<th>Favouring</th>-->
                           <th>Remark</th>
                           <th>Action</th>
                           
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        /*echo "<pre>";
                        print_r($paymentDetails);
                        exit;*/
                          if(count($paymentDetails) > 0) { 
                            $o=1;?>
                        <?php foreach($paymentDetails as $index => $indexItem){ $counter = intval($index)+1; ?>
                        <tr>
                          <td>
                            
                            <div class="font-13 text-gray-customer">
                             <span class="font-14"><?php echo $indexItem['workshop_detail_id'];?></span>
                            </div>
                          </td>
                           <td>
                            <div class="font-13 text-gray-customer">
                             <span class="font-14">
                               <?php 
                              $id =  "logout_$o";
                               //$id =  "logout";
                                $b = count($indexItem['car_ids']);
                               $co = ($b>0)?"<a data-toggle='popover' data-container='body' data-placement='right' type='button' data-html='true' href='javascript:void(0);' id=$id>".'+'.(($b>=2)?(int)$b-1:'')."</a>":'';
                               $arr = explode('@', $indexItem['stocks'][0]);
                               echo $arr[0] .' '.$co;?> 
                              </span>
                            </div>
                            <div id="popover-content-logout_<?=$o?>" class="hide popov">
                                          <div class="table mrg-B0">
                                              <table class="table table-striped-bordered table-striped table-hover enquiry-table mytbl border-T ">
                                                  <thead>
                                                     <tr>
                                                        <th width="80%">Car Details</th>
                                                        <th width="20%">Amount</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                  <?php 

                                                  foreach($indexItem['stocks'] as $k => $v){
                                                       $arrs = explode('@', $v);
                                                    ?>
                                                    <tr>
                                                      <td>
                                                          <div class="mrg-B5">
                                                            <?=$arrs[0]?>
                                                          </div>
                                                          <div class="font-13 text-gray-customer">
                                                            <span><?=$arrs[1]?><span class="dot-sep"></span> | <?=$arrs[2]?> Model</span>
                                                            </div>
                                                      </td>
                                                      <td>
                                                          <div class="font-13 text-gray-customer">
                                                              <i class="fa fa-rupee"></i>
                                                              <?=$arrs[3]?>
                                                          </div>
                                                      </td>
                                                    </tr>
                                                    <? } ?>
                                                    
                                                   <tr>
                                                       <td>
                                                       <div class="font-13 text-gray-customer">Total Amount
                                                              <i class="fa fa-rupee"></i>
                                                              <?=$indexItem['total_amount'];?>
                                                          </div>
                                                       </td>
                                                    </tr>
                                                    
                                                  </tbody>
                                                </table>
                                          </div>
                                        </div>
                          </td>
                          <td>
                            <div class="font-13 text-gray-customer">
                             <span class="font-14">
                               <?php echo '<i class="fa fa-rupee"></i> '.$indexItem['amount']; ?> 
                              </span>
                            </div>
                          </td>
                          <!--<td>
                            <div class="font-13 text-gray-customer">
                             <span class="font-14">
                               <?php echo $indexItem['created_date']; ?> 
                              </span>
                            </div>
                          </td>-->
                          <td>
                            <div class="font-13 text-gray-customer">
                             <span class="font-14">
                               <?php echo $indexItem['instrument_no']; ?> 
                              </span>
                            </div>
                          </td>
                          <td>
                            <div class="font-13 text-gray-customer">
                             <span class="font-14">
                               <?php echo ($indexItem['instrument_date'] != "")?date("d M, Y",strtotime($indexItem['instrument_date'])):""; ?> 
                              </span>
                            </div>
                          </td>
                          <td>
                            <div class="font-13 text-gray-customer">
                             <span class="font-14">
                               <?php echo $indexItem['instrument_type']; ?> 
                              </span>
                            </div>
                          </td>
                          <td>
                            <div class="font-13 text-gray-customer">
                             <span class="font-14">
                               <?php echo ($indexItem['payment_date'] != "0000-00-00 00:00:00")?date("d M, Y",strtotime($indexItem['payment_date'])):""; ?> 
                              </span>
                            </div>
                          </td>
                          <td>
                            <div class="font-13 text-gray-customer">
                             <span class="font-14">
                               <?php echo $indexItem['bank_id']; ?> 
                              </span>
                            </div>
                          </td>
                          <!--<td>
                            <div class="font-13 text-gray-customer">
                             <span class="font-14">
                               <?php echo $indexItem['favouring']; ?> 
                              </span>
                            </div>
                          </td>-->
                           <td>
                            <div class="font-13 text-gray-customer">
                             <span class="font-14">
                               <?php echo $indexItem['remark']; ?> 
                              </span>
                            </div>
                          </td>
                          <td>
                            
                            <button class="btn btn-default" data-toggle="modal" data-target="#makePayment" onclick="makePayment(<?php echo $indexItem['id'];?>,<?php echo $indexItem['wc_id'];?>,'','edit_single')" >Edit Payment</button>
                            
                          </td>
                        </tr>
                        <?php $o++; } ?>
                        <?php } else { ?>
                          <tr>
                            <td align='center' colspan='10'><div class='text-center pad-T30 pad-B30'><img src='<?php echo base_url('assets/admin_assets/images/NoRecordFound.png'); ?>'></div>
                            </td>
                          </tr>
                        <?php } ?>
                     </tbody>
                  </table>
                </div>
               </div>
            </div>
          </div>
        </div>
<script>
  $("[data-toggle=popover]").each(function(i, obj) {

    $(this).popover({
      html: true,
      content: function() {
        $('.popover').removeClass('in');
        $('.popover').attr('style','display:none');
        var id = $(this).attr('id')
        return $('#popover-content-' + id).html();
      }
    });

    });
    
         
       
</script>