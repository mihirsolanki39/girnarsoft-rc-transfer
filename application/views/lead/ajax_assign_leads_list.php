
<?php //echo "<pre>";print_r($leadTabCount);exit;
//if(!empty($leadtabCount)){
echo intval($leadtabCount['New']) . "--" . intval($leadtabCount['follow_up']) . "--" . intval($leadtabCount['walkIn']) . "--" .intval($leadtabCount['finalized']) . "--" . intval($leadtabCount['alllead']) . "--" . intval($leadtabCount['closed']) . "--" . intval($leadtabCount['converted'])."--".intval($leadtabCount['future_follow_up'])."--".intval($leadtabCount['assigned_leads'])."--".intval($leadtabCount['un_assigned_leads']);
//}
echo "####@@@@@"; 
if(!empty($query['leads'])){
  //echo "<pre>";print_r($query['leads']);  exit;
    $this->load->helpers('history_helper');
foreach ($query['leads'] as $key=>$val){ ?>
<tr class="hover-section" id="tr_<?=$val['number']?>" >
    <td>
         <input name="lead_assigned"  type="checkbox" id="<?= 'assign_'.$val['leadID']; ?>" value="<?= $val['leadID']; ?>">
         <label class="mrg-R10" for="<?= 'assign_'.$val['leadID']; ?>"><span></span> </label>
    </td>
            	<td style="position:relative">
                    <input type="hidden" id="customer_name_hidden_<?php echo $val['number']; ?>" value="<?php echo $val['name']; ?>">
                    <input type="hidden" id="customer_email_hidden_<?php echo $val['number']; ?>" value="<?php echo $val['emailID']; ?>">
                    <input type="hidden" id="customer_alt_no_hidden_<?php echo $val['number']; ?>" value="<?php echo $val['alt_number']; ?>">
                    <input type="hidden" id="customer_location_hidden_<?php echo $val['number']; ?>" value="<?php echo $val['location']; ?>">
                    <input type="hidden" id="customer_location_name_hidden_<?php echo $val['number']; ?>" value="<?php echo $val['localityname']; ?>">
                     <input type="hidden" id="lead_id_hidden_<?php echo $val['number']; ?>" value="<?php echo $val['leadID']; ?>">
                	<div class="mrg-B5" id="customer_name_<?php echo $val['number']; ?>"><b><?php echo (($val['name'] != '') ? ucwords(strtolower($val['name'])) : 'NA'); ?></b>
                            
                            <?php if (trim(strtoupper($val['source'])) == 'CARDEKHO'){ ?>
                                <span class="source-icon cdk" data-original-title="Car Dekho"  data-toggle="tooltip" data-placement="top" title="Car Dekho"></span>
                            <?php }
                            elseif ((trim(strtoupper($val['source'])) == 'GAADI') || (trim($val['source']) == '')){ ?>
                                <span class="test source-icon gaadi" data-original-title="Gaadi"  data-toggle="tooltip" data-placement="top" title="Gaadi"></span>
                            <?php }
                            elseif (trim(strtoupper($val['source'])) == 'QUIKR'){ ?>
                            <span >|<b> Quikr</b></span>
                    <?php }
                    elseif (trim(strtoupper($val['source'])) == 'OLX'){ ?>
                            <span >|<b> OLX</b></span>
                            <?php }
                            elseif (trim(strtoupper($val['source'])) == 'Walk-In')
                            { ?>
                                <span class="source-icon walk-in" data-original-title="Walk-In"  data-toggle="tooltip" data-placement="top" title="WALK-IN"></span>
                <?php }
                elseif (trim(strtoupper($val['source'])) == 'CARWALE')
            { ?>
                            <span class="source-icon carwale" data-original-title="Carwale" data-toggle="tooltip" data-placement="top" title="Carwale"></span>
                        <?php }
                        elseif (trim(strtoupper($val['source'])) == 'CALL TRACKER')
                        { ?>
                            <span class="source-icon cardekho_knowlarity" data-original-title="Customer Called" data-toggle="tooltip" data-placement="top" title="Call Tracker"></span>

                        <?php }
                        elseif (trim(strtoupper($val['source'])) == 'CARTRADE')
                        { ?>
                            <span class="source-icon car-trade" data-original-title="Car Trade" data-toggle="tooltip" data-placement="top" title="Car Trade"></span>

                            &nbsp;<?php }
                        elseif (trim(strtoupper($val['source'])) == 'WEBSITE')
                        { ?><span class="source-icon website" data-original-title="My Website" href="#" data-toggle="tooltip" data-placement="top" title="Website"></span>
                            <?php }
                        elseif (trim(strtoupper($val['source'])) == 'DEALERAPP') { ?>
                            <span class="source-icon website" data-original-title="Dealer App" data-toggle="tooltip" data-placement="top" title="DealerApp"></span>
                        <?php } elseif (trim(strtoupper($val['source'])) == 'FACEBOOK') { ?>
                            <span data-original-title="Facebook" data-toggle="tooltip" data-placement="top" title=""><img src="<?php echo BASE_HREF;?>images/fb-icon.png"/></span>
                        <?php } elseif (trim(strtoupper($val['source'])) == 'CARDEKHO_KNOWLARITY')
                                { ?>
                            <span class="source-icon cardekho_knowlarity" data-original-title="Customer Called" data-toggle="tooltip" data-placement="top" title=""></span>
                            <?php }
                                elseif ((trim(strtolower($val['source'])) == 'zigwheels'))
                                { ?>
                            <span class="source-icon gw" data-original-title="Zigwheels"  data-toggle="tooltip" data-placement="top" title="Zigwheels"></span>
            <?php }
            elseif (trim(strtoupper($val['source'])) == 'QUIKR')
            { ?>
                            <span > |<b> Quikr</b></span>
                    <?php }
                    elseif (trim(strtoupper($val['source'])) == 'OLX')
                    { ?>
                          <span > |<b> OLX</b></span>
                    <?php } ?>
                          
                          
                        
                      <?php  if ($val['verified'] == '1' && $val['otp_verified']=='1') { ?>
                        <span class="source-icon verified" style="width: 25px !important;" data-original-title="Call Verified" data-toggle="tooltip" data-placement="top" title=""></span>
                             <?php }else if($val['otp_verified']=='1'){?>
                                 <span class="source-icon otp-Verified" data-original-title="OTP Verified" data-toggle="tooltip" data-placement="top" title=""></span>
                                 
                             <?php }else if($val['verified']=='1'){?>
                                 <span class="source-icon verified" style="width: 25px !important;" data-original-title="Call Verified" data-toggle="tooltip" data-placement="top" title=""></span>
                                 
                            <?php }  ?>


                        </div>
                    <div class="font-14 text-gray-customer"  id="customer_email_<?php echo $val['number']; ?>"><span class="font-14"><?=$val['number']?></span><br><?=$val['emailID']?>
                    </div>
                    <div class="text-gray-customer font-14" id="customer_loc_<?php echo $val['number']; ?>">
                    <?php //if(!empty($val[location])) { ?>                   
                         <!--<span class="text-gray-customer font-14"><?php //echo $objbuyer->getBuyerLocality($val[location]); ?></span> -->                  
                    <?php //} ?>
                     </div>
                    <div class="mrg-T10"><span class="text-gray-customer text-gray-date font-12"><?php $enq_date  = $val['leadCreatedDate'];
                        if(!empty($enq_date)) {
        echo $new_date  = date('j M Y g:i a ', strtotime($enq_date)); } ?></span></div>
                     <a style="display:none" data-toggle="modal" data-target="#update-details" onclick="getEmployeeList(<?php echo $val['number']; ?>)">
					
                    <div class="mrg-T10">
                        
                     <span class="font-12 text-link comment-v-more">EDIT</span>
                     
                    </div>
                                   <!--<?php if(strtolower($val['rating'])=='hot'){?>
					<div class="icons-hwc">
                                        <img src="<?php echo BASE_HREF;?>images/hot_icon.png">
					</div>
                                   <?php } else if(strtolower($val['rating'])=='cold'){?>
					<div class="icons-hwc">
                                        <img src="<?php echo BASE_HREF;?>images/cold.png">
					</div>
                                   <?php } else if(strtolower($val['rating'])=='warm'){?>
					<div class="icons-hwc">
                                        <img src="<?php echo BASE_HREF;?>images/warm.png">
					</div>
                                   <?php } ?>-->
		    </a>
                    <?php if(!empty($val['assigned_to_user'])){ ?> <div class="assigned-tag">assigned to:<?=$val['assigned_to_user']?></div> <?php } ?>
                </td>
            	<td class="font-14" style="position:relative">                    
                     
                    <div>
                     
                    <input type="hidden" id="leadId_<?php echo $val['number']; ?>" value="<?php echo $val['leadID']; ?>">
                     <?php
                     //print_r($val['preferences']);
                     //if(isset($val['preferences'])){  ?> 
                    <input type="hidden" id="makeIds_<?php echo $val['number']; ?>" value=<?php if(!empty($val['preferences']['makeIds'])) { echo implode(',',$val['preferences']['makeIds']); } ?>>
                    <input type="hidden" id="modelIds_<?php echo $val['number']; ?>" value=<?php if(!empty($val['preferences']['modelIds'])) { echo implode(',',$val['preferences']['modelIds']); } ?>>
                    <input type="hidden" id="budget_<?php echo $val['number']; ?>" value=<?php if(!empty($val['preferences']['budget'])) { echo $val['preferences']['budget']; } ?>>
                    <input type="hidden" id="bodyType_<?php echo $val['number']; ?>" value=<?php if(!empty($val['preferences']['bodyType'])) { echo implode(",",$val['preferences']['bodyType']); } ?>>
                    <input type="hidden" id="fuelType_<?php echo $val['number']; ?>" value=<?php if(!empty($val['preferences']['fuelType'])) { echo $val['preferences']['fuelType']; } ?>>
                    <input type="hidden" id="transmission_<?php echo $val['number']; ?>" value=<?php if(!empty($val['preferences']['transmission'])) { echo $val['preferences']['transmission']; } ?>>
                    
                    <span id="req_budget_<?php echo $val['number']; ?>"><?php $comma=0;//if(!empty($val[preferences])){  ?>
                         <?php if(!empty($val['preferences']['budget']) && ($val['preferences']['budget']>0)){ ?><i class="fa fa-inr" aria-hidden="true"></i> <?=no_to_words($val['preferences']['budget']);?><?php } ?></span>
                         <span id="req_bodyType_<?php echo $val['number']; ?>"><?php if(!empty($val['preferences']['bodyType'])){ ?><?php if($val['preferences']['budget']) {echo ', ';} ?><?=implode(",",$val['preferences']['bodyType']);?> <?php } ?></span>
                         <span id="req_fuelType_<?php echo $val['number']; ?>"><?php if(!empty($val['preferences']['fuelType'])) {?><?php if(!empty($val['preferences']['bodyType'])) {echo ', ';} ?><?=$val['preferences']['fuelType'];?><?php } ?></span> 
                        <span id="req_transmission_<?php echo $val['number']; ?>">
                        <?php if(!empty($val['preferences']['transmission'])){ ?> <?php if($val['preferences']['fuelType']) {echo ', ';} ?><?=$val['preferences']['transmission'];?> <?php } ?>
                       </span>                        
                        <span id="req_model_name_<?php echo $val['number']; ?>">
                            <?php if((!empty($val['preferences']['makeIds'])) && (!empty($val['preferences']['transmission'])) && ($val['preferences']['transmission']) && ($val['preferences']['makeIds'])) {echo ',';} ?>
                            <?php
                            $this->load->model('Leadmodel');
                            if(!empty($val['preferences']['makeIds'])) { 
                               echo $this->Leadmodel->getMakeName(implode(',',$val['preferences']['makeIds']));
                            } 
                            if(!empty($val['preferences']['makeIds']) && !empty($val['preferences']['modelIds'])) { 
                                echo ',';
                            }
                            if(!empty($val['preferences']['modelIds'])) { 
                                echo $this->Leadmodel->getMakeModelName(implode(',',$val['preferences']['modelIds']));
                            }
                            ?>
                        </span>  
                            <?php if(empty($val['preferences'])){ ?>
                         <span id='revoveblank_<?php echo $val['number']; ?>'><?php if(!empty($val['preferences'])){ ?> Click on add to enter requirements.<?php } ?></span> 
                     <?php } ?>
                    </div>
                    
			<?php  if(!empty($val['car_list']) && isset($val['car_list'])){ ?>		<!--<span class="holder-under">&nbsp;</span>-->
                        <div class="pad-T15">
							<!--<div  class="font-13 titleborder">Available Option</div>-->
							<!--<span class="holder-under">&nbsp;</span>-->
                                                        
                                                                <div class="" id="fav_mmv_<?php echo $val['number']; ?>"><strong><?php echo $val['car_list'][0]['make']." ".$val['car_list'][0]['model']." ".$val['car_list'][0]['version'];  ?></strong><?php if($val['car_list'][0]['is_sold']==true){?><span style="color: #fff;background-color: #777;font-size: 11px;padding: 2px 5px;display:inline-block; text-align: center; width: 34px;margin-left: 5px;border-radius: 2px;line-height: 13px;"><b>Sold  </b></span><?php }  ?></div>
								 <div class="">
									<div class="car-specs">
											<div class="row list-icon"  id="pref-avail">
												<uL>
													<li>
                                                        <span id="fav_price_<?php echo $val['number']; ?>">
                                                        <?php $fav=0; if(isset($val['car_list'][0]['price'])&& !empty($val['car_list'][0]['price'])) { ?>
                                                         <i class="fa fa-inr" aria-hidden="true"></i><?php   echo no_to_words($val['car_list'][0]['price']); ?>
                                                            <?php echo ',';//if($fav > 0) {  echo ',';} ?>
                                                       
                                                        <?php $fav++;} ?>
                                                    </span>
                                                    <span id="fav_regno_<?php echo $val['number']; ?>">
                                                        <?php if(isset($val['car_list'][0]['regno'])&& !empty($val['car_list'][0]['regno'])) { ?>
                                                        
                                                            <?=$val['car_list'][0]['regno']?><?php  echo ',';//if($fav > 0) {  echo ',';} ?>
                                                         
                                                        <?php $fav++;} ?>
                                                        </span>
                                                        <span id="fav_date_<?php echo $val['number']; ?>">
                                                        <?php if((isset($val['car_list'][0]['month'])&& !empty($val['car_list'][0]['month'])) || (isset($val['car_list'][0]['year'])&& !empty($val['car_list'][0]['year']))) { ?>
                                                        
                                                            <?php echo $val['car_list'][0]['month'].' '.$val['car_list'][0]['year']; ?><?php  echo ',';//if($fav > 0) {  echo ',';} ?>
                                                        
                                                        <?php $fav++;} ?>
                                                        </span>
                                                        <span id="fav_km_<?php echo $val['number']; ?>">
                                                        <?php 
                                                        if(isset($val['car_list'][0]['km'])&& !empty($val['car_list'][0]['km'])) { ?> 
                                                        <?= formatInIndianStyle($val['car_list'][0]['km'])?> km
                                                        
                                                        <?php $fav++;} ?>
                                                        </span>
                                                    </li>
												</ul>
												 
												</div>
										</div>
									
								  
									</div>
                    </div>
<?php  } ?>
					<div class="favrt-icon">
						<!--<span><a><i class="fa fa-heart-o font-16 col-gray" aria-hidden="true"></i></a></span>-->
						<!--<span><a id=""><i class="fa fa-heart font-16 col-gray" aria-hidden="true"></i></a></span>-->
					</div>
                    <?php $existCarIds = '';
                    if(count($val['car_list']) > 0) { 
                            foreach($val['car_list'] as $carKey=>$carVal) {
                                $existCarIds .= $carVal['car_id'].',';
                            }
                            if(!empty($existCarIds)) {
                                $existCarIds = substr($existCarIds, 0,-1);
                            }
                     } ?>
                    <input type="hidden" id="carIds_<?=$val['number']?>" value="<?php echo $existCarIds; ?>">
   
                </td>
            	<td>
                	<div>
                    <input type="hidden" id="prevStatusId_<?=$val['leadID']?>" data-name="<?=$val['lead_status']?>" value="<?php echo $val['lead_status'] ?>">
                    <select disabled data-toggle="modal" data-target="" name="status_<?=$val['leadID']?>" id="status_<?=$val['leadID']?>" class="form-control status_select" >
                    	<!--<option value="">Status</option>-->
                    	<?php foreach($lead_status as $k=>$vstatus){ 
                             // $checkStatus=filterStatus($vstatus->status_name,$val['lead_status']);
                              $checkStatus=filterStatus($vstatus->id,$val['lead_status_id']);
                            if($checkStatus){?>
                                    <option value="<?=$vstatus->status_name?>" <?php if($vstatus->id==$val['lead_status_id']){echo "selected";} ?>><?=$vstatus->status_name?></option>
                            <?php  }} ?>
                    </select>
                    
                    <?php 
                    $amount='';
                    $amountText='';
                    if(isset($val['sellAmount']) && $val['sellAmount']){
                        $val['saleAmount']=$val['sellAmount'];
                    }
                    if( isset($val['sellAmount']) && $val['saleAmount'] && $val['lead_status']=='Converted'){
                        $amount=formatInIndianStyle($val['saleAmount']);
                        $amountText='Sale Amount';
                    }elseif(isset($val['offerAmount']) && $val['offerAmount'] && $val['lead_status']=='Customer Offer'){
                        $amount=formatInIndianStyle($val['offerAmount']);
                        $amountText='Offer Amount';
                    }
                    elseif( isset($val['bookingAmount']) && $val['bookingAmount'] && $val['lead_status']=='Booked'){
                        $amount=formatInIndianStyle($val['bookingAmount']);
                        $amountText='Booking Amount';
                    }
                    if($amount){
                    ?>
                    <div class="mrg-T10" style="font-size:12px;"><?php echo $amountText;?> : </div>
                    <div style="font-size:12px;"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $amount;?></div>
                    </div>
                    <?php } ?>
            	    <div class="mrg-T10">
                    <select disabled name="rating_<?=$val['leadID']?>" id="rating_<?=$val['leadID']?>" class="form-control" style="<?php if(strtolower($val['lead_status'])!='interested'){echo 'display:none';}?>">
                        <option value="">Rating</option>
                        <option value="Hot" <?php if($val['rating']=='Hot'){ echo "selected";}?>>Hot</option>
                        <option value="Cold" <?php if($val['rating']=='Cold'){ echo "selected";}?>>Cold</option>
                    	<option value="Warm" <?php if($val['rating']=='Warm'){ echo "selected";}?>>Warm</option>
                    	
                    </select>
					</div>
                </td>
            	<td>
                    
                   <div class="input-append date input-group" style="width:100%" id="followdate2" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                    <?php $followupDate = '';
                        if(isset($val['lead_status_id']) && $val['lead_status_id'] == 4) {
                            $followupDate = $val['walkinDate'];
                            $walkinDate=$val['reminderDate'];
                        } else {
                            $followupDate = $val['followDate'];
                            $walkinDate='';
                        }
                        if ($followupDate != '0000-00-00, 00:00:00' && $followupDate != '0000-00-00 ' && $followupDate != '1970-01-01 05:30:00' && $followupDate !=''){
                            $followupDate= date('j M Y g:i a', strtotime($followupDate));
                        }
                        if ($walkinDate != '0000-00-00, 00:00:00' && $walkinDate != '0000-00-00 ' && $walkinDate != '1970-01-01 05:30:00' && $walkinDate !=''){
                            $walkinDate= date('j M Y g:i a', strtotime($walkinDate));
                        }
      
                    ?>
                       <input disabled class="input-group buyer-followup-date span2 form-control add-on icon-cal2 dateTimeCalender pad-R30 font-10" size="12" type="text" id="followup_date_<?=$val['leadID']?>" name="followup_date_<?=$val['leadID']?>" value="<?php echo $followupDate; ?>"  placeholder="" readonly="readonly" style="cursor:pointer;">
                    <!--<span class="add-on input-group-addon"><span class="sprite icon-calander"></span></span>-->
                  </div>
				  <div class="check-box-rm mrg-T15" id="Reminderdiv_<?=$val['leadID']?>"<?php if($val['lead_status_id'] != 4) { ?> style="display:none;"<?php } ?>>
				  	<label for="Reminder_<?=$val['leadID']?>"><span></span> View Reminder</label>
				  </div>

		<div class="input-append date input-group mrg-T5" id="followdate_<?=$val['leadID']?>" data-date="12-02-2012" data-date-format="dd-mm-yyyy" <?php if($val['lead_status_id'] != 4) { ?> style="display:none;"<?php } ?>>
                    <input disabled class="span2 form-control width200 add-on icon-cal2 reminder-date" size="16" type="text" id="reminder_date_<?=$val['leadID']?>" name="reminder_date_<?=$val['leadID']?>" value="<?php echo $walkinDate;?>"  placeholder="" readonly="readonly" style="cursor:pointer;">
                    <!--<span class="add-on input-group-addon"><span class="sprite icon-calander"></span></span>-->
                  </div>
                </td>
            	<td style="position:relative;width:180px;word-break:break-all;">               	
                    
                     <ul class=" list-unstyled">
                        <li>
                            <div class="font-14 ">
                                
                                          <?php
                                          //echo "<pre>";
                                          //print_r($val['history']);  
                                          if(!empty($val['history'])){
                                          foreach ($val['history'] as $key=>$outerval){
                                              if(!empty($outerval['call']) && $outerval['call']){
                                                  echo "<b>".ucwords($outerval['call']['type'])." : </b>". $outerval['call']['duration']."<br/>";
                                              }
                                              if(!empty($outerval['status_change']) && $outerval['status_change']['status_text']){
                                                  echo "<b>Status : </b>". $outerval['status_change']['status_text']."<br/>";
                                              }
                                              if(!empty($outerval['feedback']) && $outerval['feedback']){
                                                  echo "<b>Feedback :</b> ". stripslashes($outerval['feedback'])."<br/>";
                                              }
                                              if(!empty($outerval['comment']) && $outerval['comment']['comment_text']){
                                                  echo "<b>Comment :</b> ". stripslashes($outerval['comment']['comment_text'])."<br/>";
                                              }
                                              if(!empty($outerval['share']) && $outerval['share']['shared_item']){
                                                  echo "<b>".$outerval['share']['shared_by'].":</b> ". $outerval['share']['shared_item']."<br/>";
                                              }
                                              
                                          ?>
                                          <div class="font-14 mrg-T5">
                                              <span class="text-gray-customer text-gray-date font-12">
                                    <?php if(isset($outerval['datetime']) && $outerval['datetime']){  ?>
                                	<?=date('d M Y', strtotime($outerval['datetime']))?>
                                          <?php } ?>
                                     </span>
                                </div>
                               
                                          <?php break;} }?>
                                 
                                <?php if(count($val['history'])>0){ ?>
								 <div class="mrg-T5"><a href="Javascript:void(0);" class="text-link font-13" id="comment_history"><span class="comment-v-more history-more" data-target="#timeline-new" data-toggle="modal" data-id="<?=$val['leadID']?>">VIEW ALL</span></a></div>
                                <?php  } ?>
                            </div>
                        </li>
                     </ul>
              
                
                    <span class="maxlength-feedback"></span>

                </td>
               

                
            </tr>
            
            <tr id="flip-up_<?=$val['number']?>" style="display:none;background-color: #f1f1f1 !imprtant;" class="carlists_buyer">
				<td colspan="7" id="spnleadtr_<?=$val['number']?>" class="border-table-1" align="center">					
					<span id="carlistdetail_<?=$val['number']?>" style=" ">
                <img src="<?=base_url('assets/admin_assets/images/loader.gif')?>"></span>
				</td>
			</tr> 
<?php }
}else{

echo "1";exit;

 } ?>
<style>.assigned-tag {background: #ffefd6; padding: 7px 15px; border-radius: 15px; color: #000000; font-size: 12px; margin-top: 10px; display: inline-block}</style>                 
<script>
    var $j = jQuery.noConflict();
 $(function () {
     //
    $j(".buyer-followup-date").datetimepicker({timepicker: true, format: 'j M Y g:i a', constrainInput: true,minDate:0,defaultDate: new Date()});
    $j(".reminder-date").datetimepicker({timepicker: true, format: 'j M Y g:i a', constrainInput: true,minDate:0,defaultDate: new Date()});
}); 
$('#assign_to_all').click(function(){
    
    $("input[name='lead_assigned']").prop('checked',$(this).prop('checked'));
});
  
  </script>
  
  