<?php
//echo "<pre>";print_r($result);exit;
$total_records = count($result);
if($request['export']=='0'){
foreach($result as $sell_customer){
//echo $sell_customer['id'];
                        $emailArr = explode("@",$sell_customer['email']);
			$emailArr2 = explode(".",$emailArr[1]);
			if($sell_customer['email']!='')
			{
                if (!filter_var($sell_customer['email'], FILTER_VALIDATE_EMAIL) || is_numeric($emailArr[0]) || is_numeric($emailArr2[0]) || is_numeric($emailArr2[1]))
                {
                    $sell_customer['email']='';
                }
			}
    
    
    $car_deatils_id=$sell_customer['car_details_id'];
    $imageDetails=(array)json_decode($sell_customer['images']);
    
   /* 
    $sqlcarcount="SELECT count(id) as total_cars FROM sell_customer_car_details WHERE sell_customer_id='".$sell_customer['id']."' ORDER BY id DESC ";
$carcount = $db->fetchRow($sqlcarcount); 

if(isset($_SESSION['exe_dealer_type']) AND $_SESSION['exe_dealer_type']=='DC' ){

 $sqlcomment="SELECT scc.latest as comment_latest,scc.comment,scc.source comment_source,scc.added as comment_added  from sell_customer_comments as scc WHERE scc.sell_customer_id='".$sell_customer['id']."' order by scc.id desc ";
$commentsoutput = $db->fetchRows($sqlcomment);
}else{
	 $sqlcomment="SELECT scc.latest as comment_latest,scc.comment,scc.source comment_source,scc.added as comment_added  from sell_customer_comments as scc WHERE scc.sell_customer_id='".$sell_customer['id']."' and (lower(scc.source)!='agent' or scc.source is null) order by scc.id desc ";
$commentsoutput = $db->fetchRows($sqlcomment);
}
*/
    $this->load->helpers('history_helper');
    
            
$carcount=current($Leadsellmodel->totalSellCar($sell_customer['id']));
//echo "<pre>";print_r($carcount);die;
?>
<tr>
<td width="20%">
    <div class="mrg-B5 name_email_text"><span class="name_text"><?=ucwords(strtolower($sell_customer['name']))?></span> <span class="source-icon <?php if($sell_customer['source']=='My Website'){echo 'website';}elseif(strtolower($sell_customer['source'])=='cardekho'){echo 'cdk';}elseif(strtolower($sell_customer['source'])=='gaadi'){echo 'gaadi';}elseif(strtolower($sell_customer['source'])=='walk-in'){echo 'walk-in';} ?>" title="<?=ucwords($sell_customer['source'])?>"></span><span class="source-icon <?php if($sell_customer['verified']=='1'){echo 'verified" title="Verified';}?>"></span></div>
        <div style="display:none;" class="edit_text_box">
            <input onblur="$(this).parent().prev().find('.name_text').html(this.value);" class="name_edit" value="<?=$sell_customer['name']?>"/>
            <input type="hidden" class="mobile_edit" value="<?=$sell_customer['mobile']?>"/>
            <input type="hidden" class="dealer_id_edit" value="<?=$sell_customer['dealer_id']?>"/>
        </div>
        <div class="name_email_text"><?php if(trim($sell_customer['email'])!=''){ ?><span class="email_text"><?=$sell_customer['email']?></span><br><?php }  ?><span class="text-primary"><?=$sell_customer['mobile']?></span>
      
            <a style="float:right" class="btn btn-default edit_name_email sell-btn" onclick="$(this).hide();$(this).parent().parent().siblings().find('.comment_save').css('background-color',$('#search_button').css('background-color'));" title="Edit" data-placement="top" data-toggle="tooltip" href="javascript:void(0);">
		Edit
		</a>   
      
        </div>
        <div style="display:none;margin-top:10px;" class="edit_text_box">
		<input onblur="$(this).parent().prev().find('.email_text').html(this.value);" class="email_edit" value="<?=$sell_customer['email']?>"/>
		 <a href="javascript:void(0);"  style="float:right;"   data-toggle="tooltip" data-placement="top" title="Save" class="btn btn-default edit_hidden_save sell-btn" onclick="$(this).parent().parent().siblings().find('.comment_save').click();">
                Save
        </a>
		</div>
        
     <div><span class=" text-muted font-11 text-italic"><?=date('d M Y g:ia',strtotime($sell_customer['enquiry_date']))?></span></div>
	 <div class="edit_error_message"></div>
         <?php if(!empty($sell_customer['booking_time']) && $sell_customer['booking_date'] != '0000-00-00')  {?>
     <div><span class=" text-muted font-11 text-italic">Slot:<?= $sell_customer['booking_time'];?> (<?=date('d/m/y',strtotime($sell_customer['booking_date']))?>)</span></div>
	 <div class="edit_error_message"></div>
         
<?php } ?>
     
</td>
<td width="33%">
    
    <div class="mrg-B5"><?= !empty($imageDetails)?'<a id="'.$car_deatils_id.'" onclick=showCarImages('.$car_deatils_id.') href="javascript:void(0);"  data-toggle="modal" data-target="#imageShow" >':''?><?=$sell_customer['make']?> <?=$sell_customer['models']?> <?=$sell_customer['variant']?><?=!empty($imageDetails)?'</a>':''?></div>
     <div class="row list-icon">
        <div class="col-lg-12 ">
            <span class="text-primary font-13"><i data-unicode="f156" class="fa fa-inr">&nbsp;</i> <?=$sell_customer['pricefrom']>0?formatInIndianStyle($sell_customer['pricefrom']):'N/A'?></span><span> <span class="dot-sep"></span> <?=$sell_customer['colour']!=''?ucwords($sell_customer['colour']):'N/A'?></span><span> <span class="dot-sep"></span> <?=$sell_customer['regno']!=''?$sell_customer['regno']:'N/A'?></span>


            <span> <span class="dot-sep"></span><?=$sell_customer['km']>0?$sell_customer['km'].' km':'N/A'?></span>
            
            <span> <span class="dot-sep"></span> <?=$sell_customer['fuel_type']!=''?$sell_customer['fuel_type']:'N/A'?></span>
            
            <span> <span class="dot-sep"></span> <?=(($sell_customer['myear']!=''&& $sell_customer['mmonth']!='')?date('M Y',strtotime($sell_customer['myear'].'-'.$sell_customer['mmonth'].'-22')):'N/A')?></span>

        </div>
         

     </div>
    <div class=" row mrg-T5  list-icon">
    </div>       <!-- $(this).parent().parent().next().show()-->          
        <div><span class="editretail" >My Offer : <span class="text-primary font-13 pad-L10"><span id="refreshPrice_<?=$sell_customer['sell_car_details_id']?>"> <?=$sell_customer['quote_price']>0?'<i data-unicode="f156" class="fa fa-inr">&nbsp;</i>'.formatInIndianStyle($sell_customer['quote_price']):'N/A'?></span></span>&nbsp;<a onclick="openQuoteBox(<?=$sell_customer['sell_car_details_id']?>)"id="<?=$sell_customer['sell_car_details_id']?>" href="javascript:void(0);">Edit</a></span>
        
        
        <?php if(!empty($carcount['total_cars']) && $carcount['total_cars']>1){ ?>
        <a onclick="getMoreCars('<?=$sell_customer['id']?>')"><span data-toggle="modal" data-target="#more-cars" class="comment-v-more pull-right" style="cursor:pointer;">(<?=$carcount['total_cars']-1?>) More Cars</span></a>
        <?php } ?>
        </div>

    
    <div id="div_<?=$sell_customer['sell_car_details_id']?>" class="edit-retailprice editretalPriceDiv_<?=$sell_customer['sell_car_details_id']?>" style="width:25%;">
        <div class="input-group">
            <!--return numbersonly(event); -->
            <form id="form_<?=$sell_customer['sell_car_details_id']?>">
            <input type="text" onkeypress="return numbersonly(event);" id="edit_retail_price_<?=$sell_customer['sell_car_details_id']?>" name="<?=$sell_customer['sell_car_details_id']?>" value="<?=$sell_customer['quote_price']?>" maxlength="8"  class="form-control text-primary font-13">
            </form>
            <span class="input-group-addon edit-price-span">
                <span class="fa fa-check text-success c-pointer" onclick="saveQuotePrice('<?=$sell_customer['sell_car_details_id']?>',<?=$sell_customer['pricefrom']?>)"></span>
                <img class="countloaderprice" style="position:absolute;right:20px;top:6px;width:16px;display:none;"src="<?php echo base_url('assets/admin_assets/images/loader.gif');?>">
                <!-- $(this).parent().parent().parent().hide();-->
                <span class="fa fa-close text-danger mrg-L05 c-pointer"class="cancelretail"onclick="cancelQuotePrice(<?=$sell_customer['sell_car_details_id']?>)"></span>
                    
            </span>
        </div>
    </div>
    
        
</td>
<td width="12%"><?php //echo $sell_customer['status']."==".ucfirst(strtolower($sell_customer['status'])); ?>
        <select name="status" id="status1" class="form-control comment_status" onchange="$(this).parent().siblings().find('.comment_save').css('background-color',$('#search_button').css('background-color'));">
        <option value="">Status</option>
       <option value="Hot" <?php if($sell_customer['status']=='Hot'){ echo 'selected="selected"';} ?>>Hot</option>
       <option value="Cold" <?php if($sell_customer['status']=='Cold'){ echo 'selected="selected"';} ?>>Cold</option>
       <option value="Warm" <?php if($sell_customer['status']=='Warm'){ echo 'selected="selected"';} ?>>Warm</option>
       
       <option  value="Evaluation Scheduled" <?php if($sell_customer['status']=='Evaluation Scheduled'){ echo 'selected="selected"';} ?>>Evaluation Scheduled</option>
       <option value="Walked-In" <?php if($sell_customer['status']=='Evaluation Done' || strtolower($sell_customer['status'])=='walked-in'){ echo 'selected="selected"';} ?>>Evaluation Done</option>
       <option value="Converted" <?php if($sell_customer['status']=='Converted'){ echo 'selected="selected"';} ?>>Converted</option>
       <option value="Closed" <?php if($sell_customer['status']=='Closed'){ echo 'selected="selected"';} ?>>Closed</option>
    </select>
    
</td>
<td width="10%">
  <div class="input-append date input-group "  onclick="$(this).parent().siblings().find('.comment_save').css('background-color',$('#search_button').css('background-color'));" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
    <input readonly="readonly" style="cursor:pointer;width:130px;" class="span2 form-control comment_follow_up_date calender" size="16" type="text" value="<?php if($sell_customer['follow_date']!='0000-00-00 00:00:00' && $sell_customer['follow_date']){echo date('d-m-Y H:i',strtotime($sell_customer['follow_date']));} ?>"  placeholder="">
  </div>
</td>
<td class="comment_<?=$sell_customer['id']?>" style="width:195px;word-break:break-all;">
        <textarea style="width:192px;" placeholder="Add Comment" maxlength="200" onclick="$(this).next().show();$(this).parent().siblings().find('.comment_save').css('background-color',$('#search_button').css('background-color'));$(this).next().html((200-this.value.length)+' characters remaining (200 maximum)');" onkeyup="$(this).next().html((200-this.value.length)+' characters remaining (200 maximum)');" rows="1" class="form-control add-c-textBox comment"></textarea>
		<span class="maxlength-feedback">200 characters remaining (200 maximum)</span>
    <div id="commentwraper" data-mcs-theme="dark" class="comment-wrap  mCustomScrollbar"> 
    <?php 
    $this->load->model('Leadsellmodel');
    $commentsoutput=$this->Leadsellmodel->getSellCustomerComments($sell_customer['id']);
    //$commentsoutput[0]['comment']='';;
    //$comment_source= isset($_SESSION['exe_dealer_type'])?$_SESSION['exe_dealer_type']:'Dealer';
    if(!empty($commentsoutput[0]['comment'])){ ?>        
     <ul class=" list-unstyled">
        <li>
            <div class="font-13 "><?php 
                            
                echo stripslashes($commentsoutput[0]['comment']);
            
            ?>
                <div class="text-italic small text-muted">
                        <?=date('d M Y H:i',strtotime($commentsoutput[0]['added']))?> 
                    <?php if(count($commentsoutput)>1){ ?>
                    <a onclick="getComments('<?=$sell_customer['id']?>');"><span style="cursor:pointer;" class="comment-v-more float-R" data-target="#model-comment" data-toggle="modal">View More</span></a>
                    <?php } ?>
                </div>
            </div>
        </li>
     </ul>
    <?php } ?>
        </div>

</td>
<?php //if ($_SESSION['ses_section'] != 'admin' && $_SESSION['accessLevel']==2) { ?>
<td class="comment_save_<?=$sell_customer['id']?>" style="postion:relative;">


        <div class="btn-group btn-group-sm  no-select-btn " role="group" >
        <a href="javascript:void(0);"  data-toggle="tooltip" data-placement="top" title="Save" class="btn btn-default comment_save sell-btn" onclick="save_popup=0;add_comment('<?=$sell_customer['id']?>',this);">
               SAVE
        </a>
		<div style="position: absolute; left: -610px; top:20px;display:none; " class="saveloader"><img src="<?php echo base_url('assets/admin_assets/images/loader.gif')?>" /></div>
		
		<?php if(isset($carcount['total_cars']) && $sell_customer['source']=='My Website' && $carcount['total_cars']==1 && $sell_customer['car_id']==0){ ?>
		<!--<a href="javascript:void(0);" onclick="window.location='<?php //echo BASE_HREF?>user/add_inventories.php?sell_enq_id=<?=$sell_customer['sell_car_details_id']?>';" data-toggle="tooltip" data-placement="top" title="Add Enquiry" class="btn btn-default" data-original-title="Add Enquiry">
               <span class="spritesell icon-add" ></span>
        </a>-->
		 <?php }else if(isset($carcount['total_cars']) && $sell_customer['source']=='My Website' && $carcount['total_cars']==1 && $sell_customer['car_id']>0){ ?>
		<!--<a href="javascript:void(0);" onclick="window.location='<?php //echo BASE_HREF?>user/views.php?view=detail&car_id=<?=$sell_customer['sell_car_details_id']?>';" data-toggle="tooltip" data-placement="top" title="View Enquiry" class="btn btn-default" data-original-title="View Enquiry">
               <i data-unicode="f06e" class="fa fa-eye font-16"></i>
        </a>-->
		 <?php }elseif($sell_customer['source']=='My Website'){ ?>
		 <!--<a href="javascript:void(0);" onclick="$(this).parent().parent().siblings().find('.comment-v-more').click();" data-toggle="tooltip" data-placement="top" title="Add Enquiry" class="btn btn-default" data-original-title="Add Enquiry">
               <span class="spritesell icon-add" ></span>
        </a>-->
		<?php } ?>
		 
               
        </div>
    <span class="comment_save_msg success"></span>
</td>
<?php //} ?>
</tr>

<?php } echo "###$total_records"; ?>
<?php  }else{
     $this->load->model('Leadsellmodel');
    //echo "<pre>";print_r($result);die;
    $heading='';

$heading = "Name \t Email \t Mobile \t Enquiry Date \t  Car Details \t Status \t Follow Date \t Comment "."\n";
$str1='';
foreach($result as $sell_customer)
{
  
    $commentsoutput=$this->Leadsellmodel->getSellCustomerComments($sell_customer['id']);
    $kk=0;
	//if($commentsoutput[0]['comment']!='')
    $cmntData='';
       if(isset($commentsoutput[0]['comment']) && $commentsoutput[0]['comment']!='')
	{
   $cmntData = $commentsoutput[0]['comment'];
      //$cmntData = $sell_customer['comment'];
	}
        
        if(isset($sell_customer['status']) && $sell_customer['status']=='Walked-In'){
            $sell_customer['status']='Evaluation Done';
            
        }
         if(isset($sell_customer['status']) && $sell_customer['status']=='Evaluation_Scheduled'){
            $sell_customer['status']='Evaluation Scheduled';
            
        }
    /*$data[]=array($sell_customer['name'],$sell_customer['email'],$sell_customer['mobile'],date('d M Y',strtotime($sell_customer['enquiry_date'])),$sell_customer['make'].' '.$sell_customer['model'].' '.$sell_customer['variant'].
                  ' -Rs '.$sell_customer['pricefrom'].' - '.$sell_customer['color'].' - '.
                  $sell_customer['regno'].' - '.$sell_customer['km'].' kms - '.$sell_customer['fuel_type'].' - '.date('M Y',strtotime($sell_customer['myear'].'-'.$sell_customer['mmonth'].'-22')),
                  $sell_customer['status'],$sell_customer['follow_date']!='0000-00-00 00:00:00'?date('d M Y',strtotime($sell_customer['follow_date'])):'',$cmntData);*/
				  
				  $str1.=	$sell_customer['name']."\t".$sell_customer['email']."\t".$sell_customer['mobile']."\t".date('d M Y',strtotime($sell_customer['enquiry_date']))."\t".$sell_customer['make'].' '.$sell_customer['models'].' '.$sell_customer['variant'].
                  ' -Rs '.$sell_customer['pricefrom'].' - '.$sell_customer['colour'].' - '.
                  $sell_customer['regno'].' - '.$sell_customer['km'].' kms - '.$sell_customer['fuel_type'].' - '.date('M Y',strtotime($sell_customer['myear'].'-'.$sell_customer['mmonth'].'-22'))."\t".$sell_customer['status']."\t".($sell_customer['follow_date']!='0000-00-00 00:00:00'?date('d M Y',strtotime($sell_customer['follow_date'])):'')."\t".$cmntData."\n";
}

					$str = $heading . $str1;


					header("Pragma: public");
					header("Expires: 0");
					header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
					header("Content-Type: application/force-download");
					header("Content-Type: application/octet-stream");
					header("Content-Type: application/download");;
					header("Content-Disposition: attachment;filename=seller-lead-".date('d-m-Y H:i:s').".xls");
					header("Content-Transfer-Encoding: binary ");
					echo $str;
					exit();	
    
}?>