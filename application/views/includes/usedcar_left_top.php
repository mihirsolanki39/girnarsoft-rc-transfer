<?php 
//print_r($salesStatus);
?>
<section class="all_details sticky">
        <div class="container-fluid">
            <div class="row">
               <div class="col-dc <?php echo (!empty($headerData['make'])) ? 'col-dc-width-auto' : '';?>">
                  <h3 class="subheading">Car details</h3>
                  <ul class="sub-value-list">
                        <li><?php if(!empty($headerData['make'])) { echo $headerData['make']; } if(!empty($headerData['model'])) { echo ' '.$headerData['model']; } if(!empty($headerData['version'])) { echo ' '.$headerData['version']; } else{ echo "NA" ;}?></li>
                        <?php if(!empty($headerData['reg_no'])) { echo '<li>'.$headerData['reg_no'].'</li>'; }?>
                        
                </ul>
               </div>
                <div class="col-dc <?php echo (!empty($headerData['customer_name'])) ? 'col-dc-width-auto' : '';?>">
                  <h3 class="subheading">Buyer details</h3>
                  <ul class="sub-value-list">
                        <?php if(!empty($headerData['customer_name'])) { echo '<li>'.$headerData['customer_name'].'</li>'; }?><li><?php if(!empty($headerData['customer_mobile'])) { echo ' '.$headerData['customer_mobile']; }else{ echo "NA" ;} ?></li>
                             
                </ul>
               </div>
                
               <div class="col-dc <?php echo (!empty($headerData['booking_amount'])) ? 'col-dc-width-auto' : '';?>">
                  <h3 class="subheading">Booking Amount</h3>
                  <ul class="sub-value-list">
                        <?php if(!empty($headerData['booking_amount'])) { echo '<li class="indirupee rupee-icon">'.indian_currency_form($headerData['booking_amount']); }else{ echo '<li>'."NA";} ?></li>
                             
                </ul>
               </div>
                
                
               <div class="col-dc <?php echo (!empty($headerData['sale_amount'])) ? 'col-dc-width-auto' : '';?>">
                  <h3 class="subheading">Sale Amount</h3>
                  <ul class="sub-value-list">
                        <?php if(!empty($headerData['sale_amount'])) { echo '<li class="indirupee rupee-icon">'.indian_currency_form($headerData['sale_amount']); }else{ echo '<li>'."NA";} ?></li>
                             
                </ul>
               </div>
                

            </div>    
         </div>
      </section>
<div class="row mrg-all-0">
            <div class="col-crm-left sidenav sidebar-ins" id="sidebar">
            <ul class="par-ul">
               <li class="side_nav"><a href="<?= base_url('addUcBuyerLead/' . base64_encode($car_id.'_'.$case_id))?>" class="sidenav-a <?= !empty($salesStatus["case_id"])? 'completed':''?> <?=$form=='buyer_details'?'active':''?>">
                        <span class="img-type"></span>Buyer Details</a>
               </li>
               <li class="side_nav"><a href="<?= !empty($salesStatus["case_id"])?base_url('ucSalesTxnDetails/' . base64_encode($car_id.'_'.$case_id)):'javascript:void(0)'?>" class="sidenav-a <?= !empty($salesStatus["trnx_id"])? 'completed':''?> <?=$form=='tranx_details'?'active':''?>">
                        <span class="img-type"></span>Transaction details</a>
               </li>
               <li class="side_nav"><a href="<?= !empty($salesStatus["trnx_id"])?base_url('ucSalesBookingDetails/' . base64_encode($car_id.'_'.$case_id)):'javascript:void(0)'?>" class="sidenav-a <?= !empty($salesStatus["booking_id"])? 'completed':''?> <?=$form=='booking_details'?'active':''?>">
                        <span class="img-type"></span>Booking Details</a>
               </li>
               <?php if($salesStatus["booking_id"]==1){ ?>
               <li class="side_nav buyer-docs"><a href="<?= !empty($salesStatus["booking_id"])?base_url('uploadUcSalesDocument/' . base64_encode($car_id.'_'.$case_id)):'javascript:void(0)'?>" class="sidenav-a <?= !empty($salesStatus["is_buyer_docs_uploaded"])? 'completed':''?> <?=$form=='doc_details'?'active':''?>">
                        <span class="img-type"></span>Documents</a>
               </li>
               
               <li class="side_nav"><a href="<?= !empty($salesStatus["is_buyer_docs_uploaded"])?base_url('ucSalesPaymentDetails/' . base64_encode($car_id.'_'.$case_id)):'javascript:void(0)'?>" class="sidenav-a <?= !empty($salesStatus["payment_id"])? 'completed':''?> <?=$form=='payment_details'?'active':''?>">
                        <span class="img-type"></span>Payment Details</a>
               </li>
               <li class="side_nav"><a onclick="getUcSalesDeliveryDetails()" href="javascript:void(0)" class="sidenav-a <?= !empty($salesStatus["delivery_id"])? 'completed':''?> <?=$form=='delivery_details'?'active':''?>">
                        <span class="img-type"></span>Delivery Details</a>
               </li>
               <li class="side_nav vehicle-docs"><a href="<?= !empty($salesStatus["delivery_id"])?base_url('uploadUcSalesDocument/' . base64_encode($car_id.'_'.$case_id)).'/diss':'javascript:void(0)'?>" class="sidenav-a <?= !empty($salesStatus["is_vehicle_images_uploaded"])? 'completed':''?> <?=$form=='vehicle_details'?'active':''?>">
                        <span class="img-type"></span>Vehicle Delivery Pics</a>
               </li>
               <?php } ?>
            </ul>
         </div>
     <div class="col-crm-right">
         <div class="loaderClas" style="display:none;"><img class="resultloader" src="<?php echo base_url()?>/assets/images/loading.gif" style="position: absolute;left: 0;right: 0;text-align: center;top: 0;bottom: 0;margin: auto;z-index: 9999;"></div>
      <div class="loaderoverlay loaderClas"></div>
      <script>
          $('.loaderClas').attr('style','display:none;');
          
        function getUcSalesDeliveryDetails(){
            $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "UsedCarSale/paymentStatus/",
            data:{car_id:'<?=$car_id?>',case_id:'<?=$case_id?>'},
            dataType: "json",
            success: function(response) 
            {
                var data =response;
                if (data.status == true) {
                    window.location.href =data.Action;
                } else {
                  snakbarAlert(data.message);
                  return false;
               }
            }   
        });
              
        }
      </script>    
      <style type="text/css">
           .loaderoverlay{position: fixed;left: 0;right: 0;top: 0;bottom: 0; background: rgba(0,0,0,0.5); z-index: 999;}
           .loaderClas{position: fixed; left:0; top: 0;right: 0; bottom: 0; margin:auto;z-index: 9999;}
          .side_nav a.sidenav-a.active {color: #e46536;}
         </style>        