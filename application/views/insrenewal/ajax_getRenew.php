<?php
//echo intval($leadtabCount['New']) . "--" . intval($leadtabCount['follow_up']) . "--" . intval($leadtabCount['walkIn']) . "--" .intval($leadtabCount['finalized']) . "--" . intval($leadtabCount['alllead']) . "--" . intval($leadtabCount['closed']) . "--" . intval($leadtabCount['converted'])."--".intval($leadtabCount['future_follow_up']);
//}
if($ptype == 'listing'){
echo intval($renewtabCount['allcount']) . "--".intval($renewtabCount['todayfollowup']) . "--". intval($renewtabCount['pastfollowdate']) . "--" . intval($renewtabCount['futureFollowupDate']). "--" . intval($renewtabCount['breakIn']). "--" . intval($renewtabCount['lost']). "--" .intval($renewtabCount['policyexpired']);    
}else{
echo intval($renewtabCount['tot']) . "--". intval($renewtabCount['totassigned']) . "--" . intval($renewtabCount['totnotassigned']) ;    
}

//echo '15--05--10';
echo "####@@@@@";
if(!empty($query['leads'])){
    $i=0;
   
  foreach($query['leads'] as $k=>$val){?>
    <tr class="hover-section" id="tr_<?php echo $val['caseId'];?>" >
            <?php if($ptype=='assign'){?>
            <?php if($is_admin=='1' || $role_id == 2){?>
            <td>
                <input onclick="clschkassign('<?php echo $val['caseId'];?>')" class="clschkassign" name="chkassign" type="checkbox" id="chkassign_<?php echo $val['caseId'];?>" value="<?php echo $val['caseId'];?>">
               <label class="mrg-R10" for="chkassign_<?php echo $val['caseId'];?>">
                   <span></span>
                </label>
            </td>
            <?php }} ?>
            <td style="position:relative">
               <?php if($val['buyer_type']=='1'){?>    
               <div class="mrg-B5"><b><?php echo (($val['customer_name'] != '') ? ucwords(strtolower($val['customer_name'])) : 'NA'); ?></b></div>
               <?php } elseif($val['buyer_type']=='2') {?>
               <div class="mrg-B5"><b><?php echo (($val['customer_company_name'] != '') ? ucwords(strtolower($val['customer_company_name'])) : 'NA'); ?></b></div>
               <?php } ?>
               <div class="font-13 text-gray-customer"><span class="font-14"><?php echo $val['number']; ?></span><br><?php echo $val['emailID']; ?></div>
                <div><span class="text-gray-customer font-14"><?php echo $val['city_name']; ?></span></div>
                
                <div class="mrg-T10"><span class="text-gray-customer text-gray-date font-13"><?php echo $val['leadCreatedDate']; ?></span></div>
                <?php if($is_admin || $role_id == 2){ ?>
                <div class="assigned-tag">Assigned to : <?php echo $val['employeeName'];?></div>
                <?php }?>
            </td>
            <style>
                .text-all-f{color: #000 !important; opacity: .54 !important}
                input[type="checkbox"] + label span{margin: -5px 5px 0px 0px; vertical-align: bottom}
                .assigned-tag {background: #ffefd6; padding: 7px 15px; border-radius: 15px; color: #000000; font-size: 12px; margin-top: 10px; display: inline-block}
            </style>
           <td class="font-14" style="position:relative">                    
               <?php if(!empty($val['make'])){?>
               <div class="mrg-B5">
                   <b><?php 
                        echo $val['make'].' '.$val['model'].' '.$val['version'];
                        ?>
                   </b>
               </div>

            <d  iv class="font-13 text-gray-customer"><span class="font-14"><?php echo ($val['regNo']) ? strtoupper($val['regNo']).' <span class="dot-sep"></span> ':'';?><?php echo ($val['make_year']) ? $val['make_year']: '';?> Model</span></div>
               <?php if($val['ins_category']=='1'){
                   $tagname='New Car';
               }else if($val['ins_category']=='2'){
                   $tagname='USED CAR';
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
           <td>
               <?php if($val['previous_policy_no']) {?>  
                <div class="mrg-B5"><b><?php echo (!empty($val['previous_policy_no'])) ? 'Policy No - '.$val['previous_policy_no']:'';?></b></div>  
                <div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['preinsurerName'])) ? $val['preinsurerName'] : '';?></span></div>
                <div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['previous_due_date'])) ? 'Due Date - '.$val['previous_due_date']: '';?></span></div>
                <div><span class="text-gray-customer font-14"><?= !empty($val['dealerName'])?"Dealer Name - ".$val['dealerName']:"" ?></span></div>
                <div><span class="text-gray-customer font-14"><?= !empty($val['source'])?"Source - ".$val['source']:"" ?></span></div>
                <div><span class="text-gray-customer font-14"><?= !empty($val['customer_nominee_ref_name'])?"Reference - ".$val['customer_nominee_ref_name']:"" ?></span></div>
                <?php } else {?>
                <div class="mrg-B5"><b>NA</b></div>
          <?php } ?>
            </td>
            <td>
                <div>
                    <?php
                    $quotesStatus='';
                    // print_r($lead_status);
                     if($val['lead_status_id']=='6'){ 
                      $quotesStatus='<option value="Policy Pending" selected="selected">Policy Pending</option>';
                     }elseif($val['lead_status_id']=='4'){ 
                      $quotesStatus='<option value="Payment Pending" selected="selected">Payment Pending</option>';
                     }elseif($val['follow_status']=='3'){ 
                      $quotesStatus='<option value="Quotes shared" selected="selected">Quotes Shared</option>';
                     }
                     ?>
                    <input type="hidden" id="prevStatusId_<?=$val['caseId']?>" data-name="<?=$val['fstatus']?>" value="<?php echo $val['fstatus'] ?>">
                    <select data-toggle="modal" data-target="" name="status_<?=$val['caseId']?>" id="status_<?=$val['caseId']?>" class="form-control status_select" >
                    	<?php echo $quotesStatus;?>
                        <?php foreach($lead_status as $k=>$vstatus){ 
                           // $checkStatus=filterRenewStatus($vstatus->id,$val['lead_status_id']);
                           // if($checkStatus){
                            $style = "display:block";
                            if($val['follow_status'] > $vstatus->id){
                                $style = "display:none";
                            }
                            ?>
                        <option style="<?php echo $style;?>" value="<?=$vstatus->status?>" <?php if($vstatus->id==$val['follow_status']){echo "selected";} ?>><?=$vstatus->status?></option>
                            <?php //} 
                            } ?>
                    </select>
                              
                </div>
            </td>
           <td>
              <?php
              $followupDate=$val['follow_up_date'];
              if ($followupDate != '0000-00-00 00:00:00' && $followupDate != '0000-00-00 ' && $followupDate != '1970-01-01 05:30:00' && $followupDate != '1970-01-01 00:00:00' && $followupDate !=''){
                            $followupDate= date('j M Y g:i a', strtotime($followupDate));
                        }else{
                         $followupDate='';   
                        }
              ?> 
              <div class="input-append date input-group" style="width:100%" id="followdate2" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                   <input class="input-group buyer-followup-date span2 form-control add-on icon-cal1 dateTimeCalender pad-R30 font-10" size="12" type="text" id="followup_date_<?=$val['caseId']?>" name="followup_date_<?=$val['caseId']?>" value="<?=$followupDate?>" placeholder="" readonly="readonly" style="cursor:pointer;">
             </div>
             <div class="input-append date input-group mrg-T5" id="followdate_<?=$val['caseId']?>" data-date="12-02-2012" data-date-format="dd-mm-yyyy" style="display:none;">
               <input class="span2 form-control width200 add-on icon-cal1 reminder-date" size="16" type="text" id="reminder_date_<?=$val['caseId']?>" name="reminder_date_<?=$val['caseId']?>" value="" placeholder="" readonly="readonly" style="cursor:pointer;">
             </div>

           </td>
           <input type="hidden" id="duedatefo_<?=$val['caseId']?>" name="duedatefo" value="<?php echo (!empty($val['previous_due_date'])) ? date('d/m/Y',strtotime($val['previous_due_date'])): '';?>" >
           <td style="position:relative;width:180px;word-break:break-all;">
               <ul class=" list-unstyled">
                   <li>
                       <div class="font-14 ">
               <?php
                if(!empty($val['history'])){
                foreach ($val['history'] as $key=>$outerval){    
                if(!empty($outerval['status'])){
                     echo "<b>Status : </b>". $outerval['status']."<br/>";
                }
                if(!empty($outerval['activity_text']) ){
                echo "<b>Comment :</b> ". stripslashes($outerval['activity_text'])."<br/>";
                }
                }
                }
                ?>
                <?php if(count($val['history'])>0){ ?>           
                <div class="mrg-T5">
                               <a href="Javascript:void(0);" class="text-link font-13" id="comment_history">
                                   <span class="comment-v-more history-more" data-target="#timeline-new" data-toggle="modal" data-id="<?=$val['caseId']?>">VIEW ALL</span>
                               </a>
                 </div>
                <?php } ?>          
                       </div>
                   </li>
                </ul>           
                <textarea name="comment_<?=$val['caseId']?>" maxlength="200" id="comment_<?=$val['caseId']?>" maxlength="200" placeholder="Add Comment" rows="1" class="form-control add-c-textBox comment is-maxlength mrg-T15"></textarea>

               <span class="maxlength-feedback"></span>

           </td>

           <td>


               <div class="">
                <span id="save_button">
                <input type="hidden" name="clickfolow" id="clickfolow_<?php echo $val['caseId'] ?>" value="0">
                      <button data-target="" data-toggle="modal" data-toggle="tooltip" title="SAVE" data-placement="top" class="btn text-btn btn-default font-12 btn-pad-sm updatelead" data-mobile="" data-leadid="<?php echo $val['caseId'] ?>" id="saveleadupdate_<?php echo $val['caseId'] ?>">SAVE</button>
                 </span>
                   <?php if(($val['follow_status']=='3') || (in_array($val['follow_status'],array('3','4')))){?>
                   <span>
                   <a class="btn text-btn btn-default font-12 btn-pad-sm" href="<?php echo base_url()?>insFileLogin/<?php echo base64_encode('customerid_'.$val['customer_id']);?>">RENEW</a>
                   </span>
                   <?php } ?>
                   <?php if(($val['follow_status']=='') || (!in_array($val['follow_status'],array('3','4','5')))){?>
                   <a  class="btn text-btn btn-default mrg-T10 font-12 btn-pad-sm" href="<?=base_url()?>insFileLogin/<?=base64_encode('customerid_'.$val['customer_id']);?>">Share Quote</a>
                   <?php } ?>
               </div>

           </td>

       </tr>  
 <?php $i++;} ?>  
<?php $paginationData = [
  'page' =>  (!empty($query['pageNumber'])) ? $query['pageNumber'] :1,
  'limit' =>  (!empty($query['pageSize'])) ? $query['pageSize'] :0,
  'totalCount' => (!empty($total_count)) ? $total_count :0,
  'viewcolcount' => (!empty($query['viewcolcount'])) ? $query['viewcolcount'] :0,
]; 
?>
  <?php echo $this->load->view('insrenewal/pagination',$paginationData); 
      echo '<input type="hidden" id="tot_ids" value="'.$renewtabCount['tot_ids'].'"/><input type="hidden" id="totassigned_ids" value="'.$renewtabCount['totassigned_ids'].'"/><input type="hidden" id="totnotassigned_ids" value="'.$renewtabCount['totnotassigned_ids'].'"/>';
?>

<?php }else{

echo "1";exit;

 } ?>

       <script type="text/javascript">
       var $j = jQuery.noConflict();
 $(function () {
     //
    $j(".buyer-followup-date").datetimepicker({timepicker: true, format: 'j M Y g:i a', constrainInput: true,minDate:0,minDateTime: new Date(),});
}); 
       
       
       </script>   