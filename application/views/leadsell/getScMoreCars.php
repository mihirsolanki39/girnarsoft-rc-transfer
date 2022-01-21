<?php 
//$number_format = new NumberFormat();
  $this->load->helpers('history_helper');
foreach($result as $sell_customer){	 ?> 
<div class="mrg-B5"><?=$sell_customer['make']?> <?=$sell_customer['models']?> <?=$sell_customer['variant']?></div>
        <div class="row list-icon">
            <div class="col-md-12">
                <span class="text-primary">
                    <i data-unicode="f156" class="fa fa-inr"></i> <?=$sell_customer['pricefrom']>0?formatInIndianStyle($sell_customer['pricefrom']):'N/A'?></span>
                    <span><span class="dot-sep"></span> <?=$sell_customer['colour']!=''?$sell_customer['colour']:'N/A'?></span>
                    <span><span class="dot-sep"></span> <?=$sell_customer['regno']!=''?$sell_customer['regno']:'N/A'?></span>

                    <span><span class="dot-sep"></span> <?=$sell_customer['km']>0?formatInIndianStyle($sell_customer['km']).' km':'N/A'?></span>

                    <span><span class="dot-sep"></span> <?=$sell_customer['fuel_type']!=''?$sell_customer['fuel_type']:'N/A'?></span>

                    <span><span class="dot-sep"></span> <?=$sell_customer['myear']!=''?date('M Y',strtotime($sell_customer['myear'].'-'.$sell_customer['mmonth'].'-22')):'N/A'?></span>
                    

                </div>
        </div>
        
        <div><span class="small editretail" ><strong>My Offer</strong><span class="text-primary font-14 pad-L10"><span id="refreshPrice_<?=$sell_customer['id']?>"> <?=$sell_customer['quote_price']>0?'<i data-unicode="f156" class="fa fa-inr">&nbsp;&nbsp;</i>'.formatInIndianStyle($sell_customer['quote_price']):'N/A'?></span></span>&nbsp;&nbsp;<a onclick="openQuoteBox(<?=$sell_customer['id']?>)"id="<?=$sell_customer['id']?>" href="javascript:void(0);">Edit</a></span></div>
    
        <div id="div_<?=$sell_customer['id']?>" class="edit-retailprice editretalPriceDiv_<?=$sell_customer['id']?>" style="width:25%;">
            <div class="input-group">
                <!--return numbersonly(event); -->
                <form id="form_<?=$sell_customer['id']?>">
                <input type="text" onkeypress="return numbersonly(event);" id="edit_retail_price_<?=$sell_customer['id']?>" name="<?=$sell_customer['id']?>" value="<?=$sell_customer['quote_price']?>" maxlength="8"  class="form-control text-primary font-13">
                </form>
                <span class="input-group-addon edit-price-span">
                    <span class="fa fa-check text-success c-pointer" onclick="saveQuotePrice('<?=$sell_customer['id']?>',<?=$sell_customer['pricefrom']?>)"></span>
                    <img class="countloaderprice" style="position:absolute;right:20px;top:6px;width:16px;display:none;"src="<?php base_url('assets/admin_assets/images/loader.gif'); ?>">
                    <!-- $(this).parent().parent().parent().hide();-->
                    <span class="fa fa-close text-danger mrg-L05 c-pointer"class="cancelretail"onclick="cancelQuotePrice(<?=$sell_customer['id']?>)"></span>

                </span>
            </div>
        </div>
        
        <div>
            <?php if($sell_customer['source']=='My Website'){ ?>
           <!-- <input class="btn btn-primary" style="width:140px;margin-top:5px;" value="<?php if($sell_customer['car_id']>0){ echo 'View Inventory'; }else{ echo 'Add to Inventory'; } ?>" onclick="<?php if($sell_customer['car_id']==0){ ?>window.location=base_url+'inventories/add_inventories?sell_enq_id=<?=$sell_customer['id']?>';<?php }else{ ?>window.location='<?=BASE_HREF?>user/views.php?view=detail&car_id=<?=$sell_customer['id']?>';<?php } ?>" />-->
            <?php } ?>
			<div class="row list-icon text-right text-muted font-11 text-italic pad-R10 pad-B10"><?php echo date( 'jS M Y g:ia',strtotime($sell_customer['enquiry_date']));  ?></div>
        </div>
		
        <hr class="list-seprator" style="margin: 5px 0px;">
<?php  } ?>

