<?php
echo "####@@@@@"; 
if(!empty($query['leads'])){
   // echo "<PRE>";
//print_r($query['leads']); exit;
    foreach ($query['leads'] as $key=>$val){
$link='';        
 if(empty($link)){
$link=!empty($val["paymentType"])? base_url('loanDoInfo/').base64_encode('OrderId_'.$val["orderId"]):'';
}
if(empty($link)){
$link = !empty($val["deliverySource"])? base_url('loanDoInfo/').base64_encode('OrderId_'.$val["orderId"]) :'';
}
if(empty($link)){
$link =base_url('loanDoInfo');    
}
?>
<tr class="hover-section" >
<td style="position:relative">
<div class="mrg-B5"><span class=""><?php echo (!empty($val['orderId'])) ?$val['orderId']: '';?></span></div>
</td>
            <td style="position:relative">
            <div class="mrg-B5"><b><?php echo (($val['customer_name'] != '') ? ucwords(strtolower($val['customer_name'])) : 'NA'); ?></b></div>
            <div class="font-13 text-gray-customer"><span class="font-14"><?php echo $val['customer_mobile_no']; ?></span></div>
        </td>
        <td style="position:relative">
            <?php /*if(!empty($val['makeName'])){?>
                <div class="mrg-B5"><b><?php echo (!empty($val['color'])) ? $val['color'].'  '.$val['makeName'].'  '.$val['modelName'].' '.$val['versionName'] :''?></b></div> 
                <div class="font-13 text-gray-customer"><span class="font-14"><?php echo ($val['financer_name']) ? 'HP - '.strtoupper($val['financer_name']):'';?></span></div>
               <div class="font-13 text-gray-customer"><span class="font-14"><?php //echo ($val['booking_date']) ? 'Booking Date: '.$val['booking_date']:'--';?></span></div>
            <?php }*/ ?>
             <?php $make  = !empty($val['parent_makeName'])?$val['parent_makeName']:$val['makeName'];
            $model = !empty($val['parent_modelName'])?$val['parent_modelName']:$val['modelName'];
          // echo "<pre>";print_r($val);die;
             if(!empty($make)){?>
                <div class="mrg-B5"><b><?php echo (!empty($val['color'])) ? $val['color'].'  '.$make.'  '.$model.' '.$val['versionName'] :''?></b></div> 
                <div class="font-13 text-gray-customer"><span class="font-14"><?php echo ($val['financer_name']) ? 'HP - '.strtoupper($val['financer_name']):'';?></span></div>
               <div class="font-13 text-gray-customer"><span class="font-14"><?php //echo ($val['booking_date']) ? 'Booking Date: '.$val['booking_date']:'--';?></span></div>
            <?php } ?>
        </td>

        <td style="position:relative">
          <?php if(!empty($val['source'])) {?> 
          <div class="mrg-B5"><b><?php echo (!empty($val['source'])) ? 'Source - '.$val['source']:'';?></b></div>   
          <div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['dealer_name']) && ($val['source']=='Dealer')) ? 'Dealer Name - '.$val['dealer_name']:'';?></span></div>  
          <div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['sales_exe'])) ? 'Sales Executive - '.$val['sales_exe'] : '';?></span></div>
          <?php } else {?>
          <div class="mrg-B5"><b>NA</b></div>
          <?php } ?>
        </td>


        <td style="position:relative">
          <?php if($val['dealerName']) {?>  
          <div class="mrg-B5"><b><?php echo (!empty($val['dealerName'])) ? 'Showroom - '.$val['dealerName']:'';?></b></div>  
          <div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['do_amt'])) ? 'DO Amt - <i class="fa fa-rupee"></i> '.$val['do_amt'] : '';?></span></div>
          <div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['delivery_date'])) ? 'Delivery Date-'.$val['delivery_date']: '';?></span></div>
          <?php } else {?>
          <div class="mrg-B5"><b>NA</b></div>
          <?php } ?>
        </td>
        <td style="position:relative">
         <?php
         $doStatus='';
         $doDate='';
          $dosStatus = '';
          $cancelReason =  '';
         // echo "<pre>";
         // print_r($val);
         // exit;
           if(($val['do_updated_status']=='1') && ($val['cancel_id']==0)){
            $doStatus ='DO generated'; 
          }else if($val['do_updated_status']=='2' && $val['cancel_id']==0){
            $doStatus = 'Payment Completed';
          }else if($val['cancel_id']!=0){
            $doStatus = 'Cancelled';
          }
         if($val['last_updated_status']=='1'){
             if($val['loan_taken_from']=='1' && $val['loan_filled']=='2'){
              $dosStatus='Loan Pending';
             //$doStatus='DO generated';   
             }else{
             //$doStatus='DO generated';
             }
             $doDate=$val['do_date'];
         }elseif($val['last_updated_status']=='2'){
             if($val['loan_taken_from']=='1' && $val['loan_filled']=='2'){
              $dosStatus='Loan Pending';
              //$doStatus='Payment Received';   
             }else{
            // $doStatus='Payment Received';
             }
            
             if($val['loan_taken']=='1' && $val['loan_filled']=='2'){
              //$dosStatus='Loan Pending';
              //$doStatus='Pending';   
             }
             $doDate=$val['do_date'];
         }
         if(!empty($val['cancel_id']))
         {
            $doStatus='Cancelled';
            $dosStatus ='';
            $cancelReason = $val['reason'];
            if($val['cancel_id']=='1')
            {
              $cancelReason = ucwords(strtolower($val['other_reason']));
            }
            $doDate ='';
         }
         //echo $doStatus; exit;
        ?>  
         <div class="mrg-B5"><b><?php echo (!empty($doStatus)) ? 'Status - '.$doStatus : '';?></b></div>
         <div class="font-14 text-gray-customer"><?php echo (!empty($doDate)) ? 'DO Date - '.$doDate:'';?></div>
          <div class="font-14 text-gray-customer"><?php echo (!empty($cancelReason)) ? 'Cancel Reason - '.$cancelReason:'';?></div>
         <?php if(!empty($dosStatus)){ ?>
          
          <div class="arrow-details alert-btn">
                                                            <span class="font-10"><?=$dosStatus?></span>
                                                         </div>
        <?php  } ?>

       </td>

         <td style="position:relative">  
        <a class="adownl" style="cursor: pointer;" onclick="downloadFile('<?php echo $val['orderId']; ?>')" data-toggle="tooltip" data-placement="left" title="Download Delivery Order Detailed PDF"><img src="<?php echo base_url() ?>assets/images/download.svg" /></a>
       </td>
       
        <td class="td-action" style="position:relative">
            <a href="<?php echo $link;?>" ><button data-target="#booking-done" data-toggle="tooltip" title="view detail" data-placement="top" class="btn btn-default">VIEW DETAILS</button></a>
                </br>
                <?  if(empty($val['cancel_id']))
         { ?>
            <button data-target="#booking-done" data-toggle="tooltip" title="generate do" onclick="renderpdfdo(<?php echo $val['orderId']?>,<?php echo DEALER_ID?>);" data-placement="top" class="btn btn-default">GENERATE DO</button> 
            <? } ?>  

            <input type="hidden" name="orderId" id="orderId" value="<?php echo (!empty($val['orderId'])) ? $val['orderId'] : '';?>">
       </td>
</tr>
<?php
} ?>

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

 }
?>
<script>
    var $j = jQuery.noConflict();
 $(function () {
     //
    $j(".case-followup-date").datetimepicker({timepicker: true, format: 'j M Y g:i a', constrainInput: true,minDate:0,defaultDate: new Date()});
    
}); 
 $('#total_count').text('('+"<?=$total_count?>"+')');
 
  </script>

