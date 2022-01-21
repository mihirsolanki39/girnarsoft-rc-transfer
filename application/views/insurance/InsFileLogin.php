<style>
    .accepted1{background: #4caf5026; color: #0ca712d9; border: 1px solid #4caf5038;}
    .accepted1:hover{background: #4caf5026; color: #0ca712d9; border: 1px solid #4caf5038;}
    input[type="checkbox"] + label span{padding-right: 25px;}
    .sumo-s{ font-size: 14px;color: #000;  font-weight: 400;  margin-bottom: 10px;}
    #addQuotes .model-hgt { height: 380px;overflow-y: scroll; overflow-x: hidden}
    #addQuotes .modal-footer{padding:0 15px 15px;}
    #addQuotes .modal-body { padding: 15px 30px;}
</style>
<?php
$is_admin=$this->session->userdata['userinfo']['is_admin'];
$addPerm=isset($permission[0]['add_permission']) ? $permission[0]['add_permission'] :'' ;
$editPerm=isset($permission[0]['edit_permission']) ? $permission[0]['edit_permission']:'';
$viewPerm=isset($permission[0]['view_permission']) ? $permission[0]['view_permission'] : '';
$mode=(!empty($CustomerInfo['quote_shared_status']) && $CustomerInfo['quote_shared_status']=='1') ? 'edit' : 'add';
$stylec = 'display:block';
$ins_category=!empty($CustomerInfo['ins_category'])? $CustomerInfo['ins_category']:'0';
if($ins_category=='1'){
$action = base_url().'inspersonalDetail/' . base64_encode('customerId_' . $CustomerInfo["customer_id"]);   
}elseif($ins_category=='2'){
$action = base_url().'insInspection/' . base64_encode('customerId_' . $CustomerInfo["customer_id"]) ;    
}elseif($ins_category=='3'){
$action = base_url().'insPreviousDetails/' . base64_encode('customerId_' . $CustomerInfo["customer_id"]);
}elseif( ($ins_category=='4') ){
  if(($CustomerInfo["isexpired"]=='1'))
    $action = base_url().'insInspection/' . base64_encode('customerId_' . $CustomerInfo["customer_id"]);
   else $action = base_url().'insPreviousDetails/' . base64_encode('customerId_' . $CustomerInfo["customer_id"]);
}else{    
$action = base_url().'insPreviousDetails/' . base64_encode('customerId_' . $CustomerInfo["customer_id"]);
}
if(!empty($filterdata)){
    $fdata=[];
    $i=0;
    foreach($filterdata as $fkey=>$fval){
       $fdata[$i][$fkey] = $fval;
       $i++;
    }
}
?>
            <div class="container-fluid mrg-T30">
               <div class="row">
                <div class="col-lg-12 col-md-12">
                  
                     <div class="cont-spc mainFilter" id="buyer-lead">
                           <form role="form" name="searchqform" id="searchqform">
                               <input type="hidden" value="<?= !empty($filterdata['policy_type'])?$filterdata['policy_type']:''?>" id="hidden_policy_type" name="previous_policy_type">
                              <div class="row">
                                <?php if(($CustomerInfo['ins_category']=='1' && $CustomerInfo['ncb_transfer'] == 1) ||($CustomerInfo['ins_category']=='2') || ($CustomerInfo['ins_category']=='3') || ($CustomerInfo['ins_category']=='4')){?>  
                                <?php if($CustomerInfo['ins_category']!='1'){?>
                                  <div class="col-md-2 pad-R0">
                                    <?php if(!empty($quotes) && empty($filterdata['policy_type']))
                                      $filterdata['policy_type'] = 1;
                                    ?>
                                    <label for="" class="crm-label">Policy Type </label>
                                    <select type="text" name="policy_type" onchange="showClaim()" id="policy_type" class="form-control" placeholder="Search">
                                      <option value="">Please Select</option>
                                     <?php foreach (INSURANCE_POLICY_TYPE as $key=>$policy_type) { ?>
                                       <option value="<?=$key?>" <?php echo (!empty($filterdata['policy_type']) && $filterdata['policy_type']==$key) ? "selected=selected" : '';?>><?=$policy_type?></option>
                                     <?php } ?>
                                    </select>
                                    <span class="error" id="err_claimtaken"></span>
                                </div>                                   
                                <?php } ?>
                                  <div id="claim_Div" style="display:none;">
                                <div class="col-md-2 pad-R0">
                                    <label for="" class="crm-label">Claim Taken Last Year</label>
                                    <select type="text" name="claimtaken" id="claimtaken" class="form-control" placeholder="Search">
                                      <option value="">Please Select</option>
                                      <option value="1" <?php echo (!empty($filterdata['claim_taken']) && $filterdata['claim_taken']=='1') ? "selected=selected" : '';?>>Yes</option>
                                      <option value="2" <?php echo (!empty($filterdata['claim_taken']) && $filterdata['claim_taken']=='2') ? "selected=selected" : '';?>>No</option>
                                    </select>
                                    <span class="error" id="err_claimtaken"></span>
                                 </div>
                                 <div class="col-md-2 pad-R0" id="divncbprev" <?php if(!empty($filterdata['claim_taken']) && $filterdata['claim_taken']=='2') { echo ""; }else{ echo 'style="display:none;"';} ?>>
                                    <label for="" class="crm-label">NCB Discount Previous</label>
                                    <select type="text" name="ncbdiscountprev" id="ncbdiscountprev" class="form-control" placeholder="Search">
                                     <?php foreach(NCB_DISCOUNT_PREV as $key=> $prev_ncb){?>
                                       <option value="<?=$key?>" <?php echo (!empty($filterdata) && $filterdata['ncb_discount_prev']==$key) ? "selected=selected" : '';?>><?=$prev_ncb?></option>
                                     <?php } ?>
                                    </select>
                                 </div>
                                  <div class="col-md-2 pad-R0" id="divncb" <?php if(!empty($filterdata['claim_taken']) && $filterdata['claim_taken']=='2') { echo ""; }else{ echo 'style="display:none;"';} ?>>
                                    <label for="" class="crm-label">NCB Discount Current</label>
                                    <select type="text" name="ncbdiscount" id="ncbdiscount" class="form-control" placeholder="Search">
                                     <?php foreach(NCB_DISCOUNT as $k=> $ncb){ ?>                                        
                                       <option value="<?=$k?>" <?php echo (!empty($filterdata['ncb_discount']) && $filterdata['ncb_discount']==$k) ? "selected=selected" : '';?>><?=$ncb?></option>
                                     <?php } ?>
                                    </select>
                                 </div>
                                  </div>
                                  <input type="hidden" name="hidden_ncb" id="hidden_ncb" value="<?=!empty($filterdata['ncb_discount'])?$filterdata['ncb_discount']:''?>">
                                <?php } ?>
                                <?php if($CustomerInfo['ins_category']=='1'){?>   
                                <div class="col-md-2 pad-R0">
                                    <label for="" class="crm-label">Duration</label>
                                    <select type="text" name="duration" id="duration" class="form-control" placeholder="Duration">
                                      <option value="0">Please Select</option>
                                      <option value="1" <?php echo (!empty($filterdata['duration']) && $filterdata['duration']=='1') ? "selected=selected" : '';?>>1 yr OD + 3 yr TP</option>
                                      <option value="2" <?php echo (!empty($filterdata['duration']) && $filterdata['duration']=='2') ? "selected=selected" : '';?>>3 yr OD + 3 yr TP</option>
                                    </select>
                                    <span class="error" id="err_dur"></span>
                                </div>
                                <?php } ?>  
                                 <div class="col-md-3 pad-L15">
                                    <span id="spnsearch">
                                        <input type="button" class="btn-save btn-save-new" value="SUBMIT" id="filtersubmit">
                                        <input type="hidden" name="customerId" id="customer_id" value="<?php echo isset($customerId) ? $customerId :''; ?>">
                                        <input type="hidden" name="page" id="page" value="1">
                                        <input type="hidden" name="srcinscat" id="srcinscat" value="<?php echo $CustomerInfo['ins_category'];?>" >
                                        <input type="hidden" name="dodashId" id="dodashId" value="">
                                    </span>
                                 </div>
                              </div>
                           </form>
                        </div>
                  </div>
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <h2 class="page-title mrg-L0">Quotes</h2> 
                     <form method="post" id="formQuotes" action="">
                     <div class="white-section section-wh">
                        <div class="row item-to-append">
                          <!--NEW-->
                          <div id="divquotes">
                          </div>  
                          <input type="hidden" name="is_quote_added" id="is_quote_added" value="<?= !empty($quotes)?1:0?>" />
                              
                            <!--New Ends-->
                            <?php
                            $insCategory=!empty($CustomerInfo['ins_category']) ? $CustomerInfo['ins_category']:'';
                            if(!empty($quotes)){
                            if($insCategory=='1'){
                             if(!empty($filterdata['duration']) && $filterdata['duration']=='1')
                                 $duration = "1 yr OD + 3 yr TP";
                             else if(!empty($filterdata['duration']) && $filterdata['duration']=='2') 
                                 $duration = "3 yr OD + 3 yr TP";
                             else
                                 $duration ="";
                            }else{$duration='1 yr';}
                            $isscomp='';
                            $x=0;
                            foreach($quotes as $iss) {
                                $iss['idv'] = !empty($iss['idv'])?$iss['idv']:0;
                            $qsource='';    
                            $qsource=!empty($iss['qsource']) && ($iss['qsource']!='') ? '<span class="disbursed" name="qsource_'.$x.'" id="qsource_'.$x.'">'.$iss['qsource'].'</button>' : '';
                            $html='<div class="col-md-4 clscnt" id="bankdiv_0">
                              <div class="bank-box">
                                <div class="t-head clearfix add" style="">
                                  <div class="pull-left">
                                      <ul class="icon-ul">
                                          <li>
                                          <img src="'.base_url().'assets/images/insurerlogo/'.$iss['logo'].'" style="height:30px;">
                                            '.$qsource.'  
                                          </li>
                                        </ul>
                                  </div>';
                                 $updStyle=($iss["flag"]=='1')? 'style="display:none"':'style="display:inline-block"';
                                      
                                  $html.='<div class="pull-right">
                                    <ul class="icon-ul" '.$updStyle.'>
                                      <li><a href="javascript:void(0)" onclick="updInsQuotes('.$iss["quote_id"].','.$insCategory.','.$iss["ftype"].');"><img src="'.base_url().'assets/images/loanbox/edit.svg"></a></li>
                                      <li><img src="'.base_url().'assets/images/loanbox/delete.svg" class="del" alt="delete" id="delete_0#269" onclick="deleteQForm('.$iss["quote_id"].')"></li>  
                                    </ul>  
                                  </div>
                                </div>
                                <style>
                                  .crm-label{font-size: 14px; color: #000; opacity: .54}
                                  .f-tick{font-size: 13px; color: #999; margin-top: 5px}
                                </style>
                                <div class="t-body clearfix row">
                                <div class="col-lg-4 col-md-6 pad-R0">
                                    <div class="crm-label font-12">IDV</div>
                                    <div class="crm-price font-14"><i class="fa fa-inr"></i> '.indian_currency_form($iss['idv']).'</div>
                                  </div>
                                  <div class="col-lg-4 col-md-6 pad-R0 pad-L5 mrg-B15">
                                    <div class="crm-label font-12">Premium</div>
                                    <div class="crm-price font-14"><i class="fa fa-inr"></i> '.indian_currency_form($iss['totpremium']).'</div>
                                    <a class="poplink check-quotes" data-toggle="modal" data-id="'.$iss["quote_id"].'" data-target="#quote-details"><span></span><img src="'.base_url().'assets/images/info.svg"></a>
                                  </div>
                                   <div class="col-lg-4 col-md-6 padL5">
                                    <div class="crm-label font-12">Duration</div>
                                    <div class="crm-price font-14">'.$duration.'</div>
                                  </div>';
                                  $addOnOk=false;
                                  $html.='<div class="col-md-12 mrg-T15"><h6 class="t-head mrg-B10 font-13">Add Ons</h6><div class="card-scroll-ins">';
                                          if($iss['road_side_assistance']=='1'){
                                            $addOnOk=true;  
                                            $html.='<div class="f-tick">
                                            <img src="'.base_url().'assets/images/ic_check_green.svg"> Road Side Assistance</div>';
                                            }
                                           if($iss['loss_of_personal_belonging']=='1'){
                                            $addOnOk=true;   
                                            $html.='<div class="f-tick">
                                             <img src="'.base_url().'assets/images/ic_check_green.svg"> Loss Of Personal Belonging</div>';
                                           }
                                           if($iss['emergency_transport_hotel_premium']=='1'){
                                            $addOnOk=true;   
                                            $html.='<div class="f-tick">
                                             <img src="'.base_url().'assets/images/ic_check_green.svg"> Emergency Transport Hotel Premium</div>';
                                           }
                                           if($iss['invoice_cover']=='1'){
                                            $addOnOk=true;   
                                            $html.='<div class="f-tick">
                                             <img src="'.base_url().'assets/images/ic_check_green.svg"> Invoice Cover</div>';
                                           }
                                           if($iss['consumables']=='1'){
                                            $addOnOk=true;   
                                            $html.='<div class="f-tick">
                                            <img src="'.base_url().'assets/images/ic_check_green.svg"> Consumables</div>';
                                            }
                                          if($iss['engine_cover_box']=='1'){
                                            $addOnOk=true;  
                                            $html.='<div class="f-tick">
                                            <img src="'.base_url().'assets/images/ic_check_green.svg"> Engine Cover Box</div>';
                                          }
                                          if($iss['key_replacement']=='1'){
                                            $addOnOk=true;  
                                            $html.='<div class="f-tick">
                                            <img src="'.base_url().'assets/images/ic_check_green.svg"> Key Replacement</div>';
                                          }
                                          if($iss['ncb_protection_cover']=='1'){
                                            $addOnOk=true;  
                                            $html.='<div class="f-tick">
                                            <img src="'.base_url().'assets/images/ic_check_green.svg"> Ncb Protection Cover</div>';
                                          }
                                          if($iss['tyre_secure']=='1'){
                                            $addOnOk=true;  
                                            $html.='<div class="f-tick">
                                            <img src="'.base_url().'assets/images/ic_check_green.svg"> Tyre Secure</div>';
                                          }
                                         if($iss['driver_cover']=='1'){
                                            $addOnOk=true;  
                                            $html.='<div class="f-tick">
                                            <img src="'.base_url().'assets/images/ic_check_green.svg"> Driver Cover</div>';
                                         }
                                         if($iss['personal_acc_cover']=='1'){
                                            $addOnOk=true; 
                                            $html.='<div class="f-tick">
                                            <img src="'.base_url().'assets/images/ic_check_green.svg"> Personel Accident Cover</div>';
                                         }
                                         if($iss['passenger_cover']=='1'){
                                            $addOnOk=true; 
                                            $html.='<div class="f-tick">
                                            <img src="'.base_url().'assets/images/ic_check_green.svg"> Passenger Cover</div>';
                                         }
                                         if($iss['electrical_accessories']=='1'){
                                            $addOnOk=true; 
                                            $html.='<div class="f-tick">
                                            <img src="'.base_url().'assets/images/ic_check_green.svg"> Electrical Accessories</div>';
                                         }
                                         if($iss['non_electrical_accessories']=='1'){
                                            $addOnOk=true; 
                                            $html.='<div class="f-tick">
                                            <img src="'.base_url().'assets/images/ic_check_green.svg"> Non Electrical Accessories</div>';
                                         }
                                         if($iss['zero_dep']=='1'){
                                            $addOnOk=true; 
                                            $html.='<div class="f-tick">
                                            <img src="'.base_url().'assets/images/ic_check_green.svg"> Zero Dep</div>';
                                         }
                                         if($addOnOk==false){
                                            $html.='No AddOn Available';  
                                         }
                                      
                                  $html.='</div></div>';
                                  $accbtnStyle=($iss["flag"]=='1')? 'disabled="disabled";':'';
                                  $accbtnText=($iss["flag"]=='1')? 'Accepted':'Accept';
                                  $accbtnTextClass=($iss["flag"]=='1')? 'accepted1':'';
                                  $html.='<div class="col-md-12">
                                    <button type="button" class="btn-save btn-save-new '.$accbtnTextClass.'" name="acc_btn_'.$x.'" id="acc_btn_'.$x.'" onclick="return confirmQuoteSave('.$x.');" style="width: 100%; margin-top:10px" '.$accbtnStyle.' >
                                      '.$accbtnText.'
                                    </button> 
                                  </div>
                                </div>
                              </div>
                            </div>';
                            $html.='<input type="hidden" name="quot_id" id="quot_id_'.$x.'" value="'.$iss["quote_id"].'">';
                            echo $html;
                            if($iss["flag"]=='1'){ $accflag='1';};
                            if(!empty($iss['insurance_company'])){ $isscomp .=$iss['insurance_company'].","; } 
                            ?>
                            <?php $x++ ; } ?>
                            <?php $isscomp=rtrim($isscomp,","); } ?>
                            <?php if($CustomerInfo['ins_category']=='1'){
                                $insCatpop='1';
                                }else{
                                $insCatpop='2';    
                                }
                            ?>                          
                             <div class="col-md-4 wow">
                              <div class="bank-box">
                                 <div class="add-bank">
                                     <div class="add-bank-d" id="" onclick="return addInsQuotes(<?php echo $insCatpop;?>);">
                                       <img src="<?=base_url()?>assets/images/loanbox/plus.svg" alt="plus">
                                     </div> 
                                     <div class="add-txt">Add More</div>
                                 </div>
                              </div>
                            </div>
                            <div class="col-md-12">
                               <div class="btn-sec-width">
                                <?php if(!empty($quotes)){?>   
                                <button type="button" class="btn-continue mrg-R15" onclick="renderpdf(<?php echo isset($customerId) ? $customerId :''; ?>);">SHARE QUOTES PDF</button>
                                <?php } ?>
                                   <input type="hidden" name="inscatt" id="inscatt" value="<?php if(!empty($insCatpop)) echo $insCatpop;?>">
                                   <input type="hidden" name="step9" value="true">
                                   <input type="hidden" name="totcnt" value="" id="totcnt">
                                   <input type="hidden" name="edit" id="edit" value="">
                                   <input type="hidden" name="acflag" value="<?php echo !empty($accflag) ? $accflag:'';?>" id="acflag">
                                   <input type="hidden" name="customerId" id="customer_id" value="<?php echo isset($customerId) ? $customerId :''; ?>">
                                   <input type="hidden" name="edit" id="edit" value="1">
                                   <button type="button" class="btn-continue" onclick="validatecountinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                               </div>
                           </div>
                        </div>
                     </div>
                    </form>
                  </div>
               </div>
            </div>
<?php if(in_array($ins_category, array(1,2,3,4))){ ?>
      <div class="modal fade" id="addQuotes" role="dialog">
    <div class="modal-backdrop fade in" style="height:100%"></div>
         <div class="modal-dialog" style="width:900px;">
            
            <div class="modal-content">
               <div class="modal-header modal-header-custom">
                  <button type="button" class="close" data-dismiss="modal" onclick="closeBank()"><img src="<?=base_url()?>assets/images/loanbox/close-model.svg" alt=""></button>
                  <div class="row">
                     <div class="col-md-6 clearfix">
                        <h4 class="modal-title"><span id="aded"></span>Quote</h4>
                     </div>
                  </div>
               </div>
               <div class="modal-body">
                  
                   <div class="clearfix" style="height: 50px;">
                       <ul class="nav nav-tabs">
                           <li class="active" id="divcalc"><a class="clsftype" data-toggle="tab" id="calculator1" href="#calculator">Calculator</a></li>
                           <li id="divman"><a class="clsftype" data-toggle="tab" id="manual" href="#Manual">Manual</a></li>
                    </ul>
                   </div>

                    <div class="tab-content clearfix">
                      <div id="calculator" class="tab-pane fade in active model-hgt">
                       <form role="form" name="frmadd" id="frmadd">
                        <div class="row mrg-T15">
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">Quote Source</label>
                            <select class="form-control crm-form sele" id="qsource" name="qsource">
                              <?php if(!empty($qsourceList)){?>  
                              <option value="0">Select Source</option>
                              <?php foreach($qsourceList as $qval){?>
                              <option value="<?php echo $qval['id'];?>"><?php echo $qval['name'];?></option>
                              <?php }} ?>
                            </select>
                            <div class="error" id="qsource_error"></div>
                            <div class="d-arrow"></div>   
                         </div>
                        </div> 
                      <?php if(!empty($filterdata['policy_type']) && in_array($filterdata['policy_type'],array(1,3)) == TRUE) { ?>
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">Zone</label>
                            <select class="form-control crm-form sele" id="zone_list" name="zone_list">
                              <?php if(!empty($filterdata)){?>  
                              <option value="0">Select Zone</option>
                              <option value="1" <?php echo (!empty($CustomerInfo['zone']) && $CustomerInfo['zone']=='1') ? "selected=selected" : '';?>>A</option>
                              <option value="2" <?php echo (!empty($CustomerInfo['zone']) && $CustomerInfo['zone']=='2') ? "selected=selected" : '';?>>B</option>
                              <?php } ?>
                            </select>
                            <div class="error" id="zone_list_error"></div>
                            <div class="d-arrow"></div>   
                         </div>
                        </div>
                      <?php } ?>
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">Insurance Company</label>
                            <select class="form-control crm-form csearch" id="ins_detail" name="ins_detail">
                            </select>
                            <div class="error" id="ins_detail_error"></div>
                         </div>
                        </div>
                      <?php  if(!empty($filterdata['policy_type']) && in_array($filterdata['policy_type'],array(1,3)) == TRUE) { ?>      
                            
                        <div class="col-md-4"  style="height:84px;">
                         <div class="form-group">   
                         <div class="fltrSearch addicov" style="position:relative">
                                    <label for="" class="crm-label">Additional Covers</label>
                                       <div class="cover-box" id="sselcover">
                                           <span>Select Covers</span>
                                           <div class="d-arrow"></div> 
                                       </div>
                                       <div class="coverList" style="display:none;">
                                              <ul class="" id='select_cover_list'>
                                                  <?php 
                                                    if(!empty($coverlist)){
                                                    $i=0;
                                                    foreach($coverlist as $key=>$val){
                                                        $checked='';
                                                        $style='';
                                                        $txtval='';
                                                        $txtstr='';
                                                        $chkstyle='';
                                                        if(!empty($filterdata[$val['coverName']]) && ($filterdata[$val['coverName']]=='1')){
                                                        //$checked="checked='checked'";
                                                        }elseif($val['coverName']=='driver_cover'){
                                                        $checked="checked='checked'";
                                                        }
                                                        if(!empty($filterdata[$val['coverName']]) && ($filterdata[$val['coverName']]!='')){
                                                        $style="";
                                                        $txtval=(isset($filterdata[$val['coverName'].'_txt']))?$filterdata[$val['coverName'].'_txt']:'';
                                                        }elseif($val['coverName']=='driver_cover'){
                                                        $style="";
                                                        $txtval='50';
                                                        }else{
                                                          $style="style='display:none'";
                                                        }
                                                        if($val['txtflag']=='0'){
                                                            $chkstyle='clschkaddon';
                                                            $addontxtstyle="style='display:none'";
                                                        }
                                                    ?>
                                                    <li class="">
                                                          <span class="">
                                                              <input type="checkbox" name="<?php echo $val['coverName']?>" id="<?php echo $val['coverName'].'_'.$i?>" onclick="selcover(this.id,this.name,'<?php echo $val['txtflag']?>');" value="1" class="trigger <?php echo $chkstyle;?>" <?php echo $checked;?>>
                                                              <label for="<?php echo $val['coverName'].'_'.$i?>"><span class="dt-yes"></span><?php echo $val['labelName']?></label>
                                                           </span>
                                                    </li>
                                                    <?php if($val['txtflag']=='1'){?>
                                                    <li class="amount <?php echo $val['coverName']?>" <?php echo $style;?>>
                                                        <input type="text" class="form-control rupee-icon" name="<?php echo $val['coverName'].'_txt'?>" id="<?php echo $val['coverName'].'_txt'?>" value="<?php echo $txtval;?>" onkeypress="return isNumberKey(event)" onkeyup="addCommas(this.value, '<?php echo $val['coverName'].'_txt'?>');return calculatePremium('1');" placeholder="<?php echo $val['labelName']?>" maxlength="4">
                                                    </li>    
                                                    <?php $i++;}} }?>
                                              </ul>
                                       </div>
                         </div>
                         </div>
                        </div>
                     
                      <?php } ?>  
                       
                        <?php  if(!empty($filterdata['policy_type']) && in_array($filterdata['policy_type'],array(1,3)) == TRUE) { ?>  
                          <div class="col-md-4" id="bprice">
                          <style type="text/css">
                            #bprice .btn-default{}
                             #bprice .btn-default:hover {color: #e77842!important; background-color: #ffffff !important; border-color: #e77842 !important; border-bottom: 1px solid #e77842!important;}

                          </style>
                            <div class="form-group">
                            <label class="crm-label">Bundled Add On</label>
                            <div class="input-group">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 60px"><span id="bundled_id">%</span> <span class="caret"></span></button>
                              <ul class="dropdown-menu" role="menu">
                                <li><a href="#" onclick="quotesby(this)" id="quotesperc">% </a></li>
                                <li><a href="#" onclick="quotesby(this)" id="quotesamt">₹ </a></li>
                              </ul>
                            </div><!-- /btn-group -->
                            <div id="dropD">
                            <input type="text" class="form-control bund" onpaste="return false;" value="" name="add_on_txt" id="add_on_txt" onkeypress="return isNumberKey(event)" onkeyup="addCommas(this.value, 'add_on_txt');return calculatePremium('1');" autocomplete="off" maxlength="7" readonly="readonly" style="display: none;">
                            <input type="text" class="form-control bund1" onpaste="return false;" value="" name="add_on_perc" pattern="^\d*(\.\d{0,2})?$" id="add_on_perc" autocomplete="off" maxlength="5" readonly="readonly" onblur="return calculatePremium('1');" style="display: block;">
                            </div>
                            </div>
                            <div class="error" id="add_on_txt_error"></div>
                         </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                            <label class="crm-label">OD Discount(%)</label>
                            <input type="text" class="form-control sele" placeholder="Enter OD Discount" onkeypress="return isNumberKey(event)" onkeyup="return calculatePremium('1');" onpaste="return false;" value="" name="od_disc" id="od_disc" autocomplete="off" maxlength="2">
                            <div class="error" id="od_discount_error"></div>
                        </div>
                        </div>
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">IDV</label>
                            <input type="text" class="form-control crm-form rupee-icon" placeholder="Enter IDV" onkeyup="addCommas(this.value, 'idv'); return calculatePremium('1');" onpaste="return false;" value="" maxlength="12" name="idv" id="idv" autocomplete="off" onkeypress="return isNumberKey(event)">
                            <div class="error" id="idv_error"></div>
                         </div>
                        </div>
                        <?php } ?>     
                        </div>    
                      
                        <div class="row">
                             <?php 
                         if(!empty($filterdata['policy_type']) && in_array($filterdata['policy_type'],array(1,2)) == TRUE) {?>
                        <div class="col-md-12"><h4 class="sumo-s">Third Party</h4></div>   
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">Basic Third Party</label>
                            <input type="text" class="form-control crm-form rupee-icon" placeholder="Basic Third Party" onkeyup="addCommas(this.value, 'third_party'); return calculatePremium('1');" onpaste="return false;" value="" maxlength="12" name="third_party" id="third_party" autocomplete="off" onkeypress="return isNumberKey(event)">
                            <div class="error" id="idv_error"></div>
                         </div>
                        </div>
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">Personal Accident Cover</label>
                            <input type="text" class="form-control crm-form rupee-icon" placeholder="Personal Accident Cover" onkeyup="addCommas(this.value, 'per_acc_cover'); return calculatePremium('1');" onpaste="return false;" value="" maxlength="12" name="per_acc_cover" id="per_acc_cover" autocomplete="off" onkeypress="return isNumberKey(event)">
                            <div class="error" id="idv_error"></div>
                         </div>
                        </div>
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">Liability Paid To Driver</label>
                            <input type="text" class="form-control crm-form rupee-icon" placeholder="Liability Paid To Driver" onkeyup="addCommas(this.value, 'paid_driver'); return calculatePremium('1');" onpaste="return false;" value="" maxlength="12" name="paid_driver" id="paid_driver" autocomplete="off" onkeypress="return isNumberKey(event)">
                            <div class="error" id="idv_error"></div>
                         </div>
                        </div>
                        <div class="col-md-4">
                         <div class="form-group">
                             <label class="crm-label">Passenger Cover</label>
                            <input type="text" class="form-control crm-form rupee-icon" placeholder="Passenger Cover" onkeyup="addCommas(this.value, 'pass_cover'); return calculatePremium('1');" onpaste="return false;" value="" maxlength="12" name="pass_cover" id="pass_cover" autocomplete="off" onkeypress="return isNumberKey(event)">
                            <div class="error" id="idv_error"></div>
                         </div>
                        </div> 
                     <?php } ?>
                            <div class="col-md-4 form-group">
                                <label class="crm-label">Quote Date <span class="month-t"></span></label> 
                                <div class="input-group date" id="dp2">
                                    <input type="text" class="form-control payment_date crm-form" id="quote_date" name="quote_date" autocomplete="off" value="<?= ((!empty($value['quote_date']) && ($value['quote_date'] != '0000-00-00 00:00:00')) ? date('d-m-Y', strtotime($value['quote_date'])) : date('d-m-Y')) ?>"  placeholder="Quote Date">
                                    <span class="input-group-addon">
                                        <span class="">
                                            <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                        </span>
                                    </span>
                                </div>
                                <div class="error" id="errquote_date"></div>
                            </div>
                        <div class="col-md-12 mrg-T20" style="height:34px;">Total Premium : <i class="fa fa-inr"></i><span id="divpremium"></span></div>
                        <div class="col-md-12  text-center">
                          <div class="row">
                             <div class="col-md-3">
                                 <a class="btn btn-continue addnewQuotes_class" data-dismiss="modal" id="addnewQuotes" onclick="addnewQuotes('1')">Proceed Now</a>
                                 <input type="hidden" name="customer_idd" id="customer_idd" value="<?php echo isset($customerId) ? $customerId :''; ?>">
                                 <input type="hidden" name="quote_id" id="quotee_id" value="">
                                 <input type="hidden" name="edit" id="edit" value="">
                                  <input type="hidden" name="inscat" id="inscat" value="<?php echo $insCategory;?>">
                                  <input type="hidden" name="ftype" id="ftype" value="1">
                            </div>
                          </div>
                        </div>
                      </div>
                           </form>

                          </div>
                        
                      <div id="Manual" class="tab-pane fade model-hgt">
                         <form role="form" name="mfrmadd" id="mfrmadd"> 
                        <div class="row mrg-T15">
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">Quote Source</label>
                            <select class="form-control crm-form sele" id="mqsource"  name="qsource">
                              <?php if(!empty($qsourceList)){?>  
                              <option value="0">Select Source</option>
                              <?php foreach($qsourceList as $qval){?>
                              <option value="<?php echo $qval['id'];?>"><?php echo $qval['name'];?></option>
                              <?php }} ?>
                            </select>
                            <div class="error" id="qmsource_error"></div>
                            <div class="d-arrow"></div>   
                         </div>
                        </div> 
                       <?php  if(!empty($filterdata['policy_type']) && in_array($filterdata['policy_type'],array(1,3)) == TRUE) { ?>  
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">1st Year IDV</label>
                            <input type="text" class="form-control filterInput rupee-icon" value="" onkeypress="return isNumberKey(event)" name="midv" id="midv" placeholder="Enter 1st Year IDV" onkeyup="addCommas(this.value, 'midv');return calculatePremium('2');" maxlength="10">
                            <div class="error" id="midv_error"></div>
                         </div>
                        </div>
                        <?php if(!empty($filterdata['duration']) && $filterdata['duration']=='2') { ?>
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">2nd Year IDV</label>
                            <input type="text" class="form-control filterInput rupee-icon" value="" onkeypress="return isNumberKey(event)" name="midv2" id="midv2" placeholder="Enter 2nd Year IDV" onkeyup="addCommas(this.value, 'midv2');" maxlength="10">
                            <div class="error" id="midv2_error"></div>
                         </div>
                        </div> 
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">3rd Year IDV</label>
                            <input type="text" class="form-control filterInput rupee-icon" value="" onkeypress="return isNumberKey(event)" name="midv3" id="midv3" placeholder="Enter 3rd Year IDV" onkeyup="addCommas(this.value, 'midv3');" maxlength="10">
                            <div class="error" id="midv3_error"></div>
                         </div>
                        </div> 
                        <?php }}?>
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">Insurance Company</label>
                            <?php
                            $ins_ids=[];
                            $customer_id = $this->input->post('customer_id');
                            $currinsurerIds = $this->Crm_insurance->getcurrentInsurerId($customer_id);
                            if(!empty($currinsurerIds)){
                                foreach($currinsurerIds as $val){
                                    $ins_ids[]=$val['cid'];
                                }
                            }
                            $insStr='';
                            $insurerList = $this->Crm_previous_insurer->getInsurerList();

                            $insStr  = "<option value=''>Select Company</option>";
                            foreach ($insurerList as $dkey => $dval) 
                            {
                                if(!in_array($dval['prev_policy_insurer_slug'], $ins_ids)){
                                    $selected=($dval['prev_policy_insurer_slug']==$insurer) ? "selected='selected'":'';
                                $insStr .="<option value='" .$dval['prev_policy_insurer_slug']."#".$dval['logo']. "' $selected>" . $dval['short_name'] . "</option>";
                                }
                            }
                            ?>
                            <select class="form-control crm-form msearch1" id="mins_detail" name="mins_detail">
                            <?php echo $insStr;?>
                            </select>
                            <div class="error" id="mins_detail_error"></div>
                         </div>
                        </div>
                      </div>
                    <?php  if(!empty($filterdata['policy_type']) && in_array($filterdata['policy_type'],array(1,3)) == TRUE) { ?>  
                      <div class="row">
                      <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">Add Ons</label>
                            <select class="mcoverbox" name="madd_on[]" id="madd_on" multiple="multiple">
                                <?php
                               
                                if(!empty($mcoverlist)){
                                    $x=0;
                                    foreach($mcoverlist as $key=>$val){
                                        echo "<option class='' value='".$val['coverName']."'>".$val['labelName']."</option>";
                                    }
                                }                  
                                ?>
                             </select>
                         </div>
                        </div>
                        <div class="col-md-4 form-group">
                              <label for="" class="liteLabel">Add Ons Price</label>
                              <input type="text" class="form-control filterInput rupee-icon" value="" onkeypress="return isNumberKey(event)" name="maddon_price" id="maddon_price" placeholder="Add Ons Price" onkeyup="addCommas(this.value, 'maddon_price');return calculatePremium('2');" maxlength="8">
                              <div class="error" id="maddon_price_error"></div>
                         </div>
                      </div>    
                        <div class="row">
                          <div class="col-md-12"><h4 class="sumo-s">Own Damage</h4></div>
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">Basic OD amount</label>
                            <input type="text" class="form-control filterInput rupee-icon" value="" onkeypress="return isNumberKey(event)" name="mbasic_od_amt" id="mbasic_od_amt" placeholder="Enter Basic Od Amt" onkeyup="addCommas(this.value, 'mbasic_od_amt');return calculatePremium('2');" maxlength="8">
                            <div class="error" id="mbasic_od_amt_error"></div>
                         </div>
                        </div>
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">NCB Discount </label>
                            <input type="text" class="form-control filterInput rupee-icon" value="" onkeypress="return isNumberKey(event)" name="mncb_discount" id="mncb_discount" placeholder="Enter NCB Discount" onkeyup="addCommas(this.value, 'mncb_discount');return calculatePremium('2');" maxlength="8">
                            <div class="error" id="mncb_discount_error"></div>
                         </div>
                        </div>
                        <div class="col-md-4">
                         <div class="form-group">   
                         <div>
                              <label class="crm-label">OD Discount</label>
                              <input type="text" class="form-control filterInput rupee-icon" value="" onkeypress="return isNumberKey(event)" name="mod_discount" id="mod_discount" placeholder="Enter OD Discount" onkeyup="addCommas(this.value, 'mod_discount');return calculatePremium('2');" maxlength="8">
                              <div class="error" id="mod_discount_error"></div>
                         </div>
                         </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">Electrical</label>
                            <input type="text" class="form-control filterInput rupee-icon" value="" onkeypress="return isNumberKey(event)" name="melectrical" id="melectrical" placeholder="Electrical" onkeyup="addCommas(this.value, 'melectrical');return calculatePremium('2');" maxlength="8">
                            <div class="error" id="melectrical_error"></div>
                         </div>
                        </div>
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">Non Electrical</label>
                            <input type="text" class="form-control filterInput rupee-icon" value="" onkeypress="return isNumberKey(event)" name="mnonelectrical" id="mnonelectrical" placeholder="NonElectrical" onkeyup="addCommas(this.value, 'mnonelectrical');return calculatePremium('2');" maxlength="8">
                            <div class="error" id="mnonelectrical_error"></div>
                         </div>
                        </div>    
                        
                      </div>
                    <?php } ?>
                     <?php if(!empty($filterdata['policy_type']) && in_array($filterdata['policy_type'],array(1,2)) == TRUE) {?>
                      <div class="row">
                      <div class="col-md-12"><h4 class="sumo-s">Third Party</h4></div>
                      <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">Basic Third Party</label>
                            <input type="text" class="form-control crm-form rupee-icon" placeholder="Basic Third Party" onkeyup="addCommas(this.value, 'mthird_party'); return calculatePremium('1');" onpaste="return false;" value="" maxlength="12" name="mthird_party" id="mthird_party" autocomplete="off" onkeypress="return isNumberKey(event)">
                            <div class="error" id="idv_error"></div>
                         </div>
                        </div>
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">Personal Accidental Cover</label>
                            <input type="text" class="form-control filterInput rupee-icon" value="" onkeypress="return isNumberKey(event)" name="mper_acc_cover" id="mper_acc_cover" placeholder="Enter Personal Acc Cover" onkeyup="addCommas(this.value, 'mper_acc_cover');return calculatePremium('2');" maxlength="8">
                            <div class="error" id="mper_acc_cover_error"></div>
                         </div>
                        </div>
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">Liability to Paid Driver</label>
                            <input type="text" class="form-control filterInput rupee-icon" value="" onkeypress="return isNumberKey(event)" name="mpaid_driver" id="mpaid_driver" placeholder="Enter Paid Driver" onkeyup="addCommas(this.value, 'mpaid_driver');return calculatePremium('2');" maxlength="8">
                            <div class="error" id="mpaid_driver_error"></div>
                         </div>
                        </div>
                        <div class="col-md-4">
                         <div class="form-group">
                            <label class="crm-label">Passenger cover</label>
                            <input type="text" class="form-control filterInput rupee-icon" value="" onkeypress="return isNumberKey(event)" name="mpass_cover" id="mpass_cover" placeholder="Enter Passenger Cover" onkeyup="addCommas(this.value, 'mpass_cover');return calculatePremium('2');" maxlength="8">
                            <div class="error" id="mpaid_driver_error"></div>
                         </div>                           
                        </div>
                       </div>
                      <?php } ?>
                             <div class="row">
                             <div class="col-md-4 form-group">
                                     <label class="crm-label">Quote Date <span class="month-t"></span></label> 
                                     <div class="input-group date" id="mdp2">
                                         <input type="text" class="form-control payment_date crm-form" id="mquote_date" name="quote_date" autocomplete="off" value="<?= ((!empty($value['quote_date']) && ($value['quote_date'] != '0000-00-00 00:00:00')) ? date('d-m-Y', strtotime($value['quote_date'])) : date('d-m-Y')) ?>"  placeholder="Quote Date">
                                         <span class="input-group-addon">
                                             <span class="">
                                                 <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                             </span>
                                         </span>
                                     </div>
                                     <div class="error" id="errmquote_date"></div>
                                 </div>
                             </div>
                      <div class="row">
                      <div class="col-md-3 mrg-T15" style="height:34px;">Total Premium : <i class="fa fa-inr"></i><span id="mdivpremium"></span></div>
                        <input type="hidden" name="customer_idd" id="customer_idd" value="<?php echo isset($customerId) ? $customerId :''; ?>">
                        <input type="hidden" name="quote_id" id="quote_id" value="">
                        <input type="hidden" name="inscat" id="inscat" value="<?php echo $insCategory;?>">
                        <input type="hidden" name="ftype" id="fftype" value="2">
                        <input type="hidden" name="mzone" id="mzone" value="<?php echo (!empty($CustomerInfo['zone'])) ? $CustomerInfo['zone']:'';?>">

                         </div>
                         </form>
                          </div>
                        
                      </div>
                      
                    </div>

                   <div class="modal-footer" style="display:none;">
                          <div class="row">
                             <div class="col-md-3">
                                 <a class="btn btn-continue addnewQuotes_class" data-dismiss="modal" id="addnewQuotes" onclick="addnewQuotes('2')">Proceed Now</a>
                            </div>
                          </div>
                    </div>

                    </div>
         
               </div>
            </div>
         </div>
      </div>
<?php } ?>
<div class="modal fade" id="quote-details" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-sm modal-wd" role="document" id="quote-details">
     <div class="modal-content access_modal"  id="quote-details-content">
     </div>
    </div>
</div>
      <?php
      $flag =0; 
      if($CustomerInfo['ins_category']=='1' && $CustomerInfo['ncb_transfer'] == 1){
         $flag =1; 
      } 
      ?>
      
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_assets/css/sumoselect.min.css">
<script src="<?php echo base_url(); ?>assets/js/jquery.sumoselect.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/insurance_process.js" type="text/javascript"></script>
      <script type="text/javascript">
      function renderpdf(orderId){
         $('.loaderClas').attr('style','display:block;');
            setTimeout(function () {
            $('.loaderClas').attr('style','display:none;');
           }, 10000);
            $.ajax({
              type: 'POST',
              url: base_url+"insurance/getinspdf/",
              data: {orderId:orderId},
              dataType:'json',
              beforeSend:function(){
                  $('.searchresultloader').show();
                   snakbarAlert('Please Wait While PDF Is Getting Downloaded');
              },
              success: function (responseData, status, XMLHttpRequest) {
                console.log(responseData);
                  $('#quotes_form_error').text('');
                   $('.searchresultloader').hide();
                  snakbarAlert(responseData.message);
                   if(responseData.status){
                     window.location=base_url+"insurance/downloadInsurance/?file="+responseData.file_name;
                   }
                  }
              });
          //window.top.location.href =  base_url+"insurance/getinspdf/"+ orderId;
                
     }  
         $(document).ready(function () {
             var flag = "<?= $flag ?>";
             showClaim(flag);
             setNCBOption();  
             //More Filter
             $('.moreFltrBrn a').click(function(){
                 $('.moreFltrBg').slideToggle();
                 $('.mainFilter').toggleClass('moreFltr');
                 $('.hideFltr').toggle();
                 $('li.find').addClass('afterMoreBtn');
                 
                 //$( "ul li:nth-last-child(2)" )
                 
                 if($(this).text() == '+ MORE(4)')
                    {
                        $(this).text('LESS');
                    }
                    else
                    {
                        $(this).text('+ MORE(4)');
                    }
             });
             
              $(".pop-icon").click(function(){
                 $(".pop-box").toggle();
             });
         
             $(document).on('click', function (e) {
                if ($(e.target).closest(".pop-icon").length === 0) {
                    $(".pop-box").hide();
                }
             });
             
               $(document).on('click', function (e) {
                if ($(e.target).closest(".addicov").length === 0) {
                    $(".coverList").hide();
                }
             });
             
             
               $(document).on('click', function (e) {
                if ($(e.target).closest(".addicov1").length === 0) {
                    $(".coverList1").hide();
                }
             });
                         
             // Cover Box dropdown
             
             $('.cover-box').click(function(){
                 
                 $('.coverList').slideToggle();
             });
             
               $('.cover-box1').click(function(){
                 
                 $('.coverList1').slideToggle();
             });
             
             // checked
             
             $(".passenger").click(function () {
            if ($(this).is(":checked")) {
                $(".amount").show();
            } else {
                $(".amount").hide();
            }
        });
             
             
              $(".coverList1 li").click(function () {
                if ($(this).find('input.choose').is(":checked")) {
                  //alert($(this).find('input').is(":checked"));
                    
                    $(".own").show();
                } else {
                    $(".own").hide();
                }
        });
             
         });
      </script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#quote_date').datepicker({
                format: 'dd-mm-yyyy',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
             $('#mquote_date').datepicker({
                format: 'dd-mm-yyyy',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
             
        $('#select_cover_list').trigger('click'); 
        $('#mselect_cover_list').trigger('click');
          });
          
            $('.dropdown-menu li a').click(function(){
                var getText = $(this).text();
                $(this).parents('.dropdown-menu').prev().html(getText + '<span class="d-arrow d-arrow-new"></span>');
            });  
        function selcover(cid,cName,flag){
           // alert(cid+">>>"+cName+">>>"+flag);
            
                if(flag=='1'){
                if ($('#'+cid).is(":checked")) {
                //console.log('#'+cName+'_txt');    
                $('.'+cName).show();
                } else {
                    $('#'+cName+'_txt').val('');
                    $('.'+cName).hide();
                }
                }else{
                    var chkArr = [];
                    $.each($(".clschkaddon:checked"), function(){            
                        chkArr.push($(this).val());
                    });
                     chkArr.join(", ");
                    console.log(chkArr); 
                    if (chkArr.length > 0) {
                     $("#add_on_txt").attr("readonly", false);
                     $("#add_on_perc").attr("readonly", false);
                    }else{
                     $("#add_on_txt").attr("readonly", true);
                     $("#add_on_perc").attr("readonly", true);
                     $("#add_on_txt").val('');
                     $("#add_on_perc").val('');
                    }
                }
             }   
        function addInsQuotes(catId)
          {
            $('.error').html('');
            $("#quotee_id").val('');
            $("#quote_id").val('');
            $("#edit").val('');  
            var zone_new = "<?=$CustomerInfo['zone']?>";
                if(catId=='1'){
                $('#err_dur').html('');
                  var dur = $('#duration').val();
                  if(dur=='0')
                  {
                    $('#duration').focus();
                      $('#err_dur').html("Please Select Duration");
                      return false;
                  }
              }  
                if((catId=='2' || catId=='3' || catId=='4') && $("#policy_type").val() != 2){  
                var claimtaken=$('#claimtaken').val();
                if(claimtaken==''){
                   $('#claimtaken').focus();
                   $('#err_claimtaken').html("Please Select Claim Taken");
                   return false; 
                }
            }
                $.each($(".clschkaddon:checked"), function(){            
                   $(this).prop('checked', false);
                }); 
                $('#zone_list').val(0);
                var customer_id = $('#customer_id').val();
                $('.error').val('');
                $('#aded').html('Add ');
                $('#addQuotes').attr('style','display: block; padding-right: 15px;');
                $('#addQuotes').attr('class','modal fade in');
                $('#divman').removeClass('active');  
                $('#divcalc').addClass('active');
                $("#add_on_txt").attr("readonly", true);
                $('#calculator').attr('class','tab-pane fade in active model-hgt');
                $("#ftype").val('1');
                $('#Manual').removeClass('in active');
                $('#frmadd').trigger("reset");
                $('#mfrmadd').trigger("reset");
                $('#idv').val('');
                $('#divpremium').html('');
                $('#mdivpremium').html('');
                $("#ins_detail").prop("selected", false);
                $("#od_disc").val('');
                $('.modal-footer').hide();
                //$("#madd_on").html('');
                $('#select_cover_list').trigger('click');
                jQuery.ajax({
                type: "POST",
                url: base_url+"insurance/getInsurerSearchList",
                data: {catId:catId,customer_id:customer_id},
                dataType: 'json',
                success: function(data){
                     
                        $("#zone_list").val(zone_new);
                        $("#mper_acc_cover").val(data.insData.personal_acc_cover);
                        $("#mpaid_driver").val(data.insData.paid_driver);
                        $("#third_party").val(data.insData.basic_third_party);
                        $("#mthird_party").val(data.insData.basic_third_party);
                        $("#per_acc_cover").val(data.insData.personal_acc_cover);
                        $("#paid_driver").val(data.insData.paid_driver);
                        $("#ins_detail").html("");
                        $("#ins_detail").html(data.compony);
                        $("#mins_detail").html(data.compony);                        
                        $("#madd_on").html(data.strCover);
                        $("#bundled_id").html("%");
                     if($("#policy_type").val() != 2){
                        $('.csearch').SumoSelect({ csvDispCount: 3, search: true,  searchText:'Enter here.' });
                        $('.csearch')[0].sumo.reload(); 
                        $('.msearch1').SumoSelect({ csvDispCount: 3, search: true,  searchText:'Enter here.' }); 
                        $('.msearch1')[0].sumo.reload();
                        $('.mcoverbox').SumoSelect({ csvDispCount: 3, search: true,  triggerChangeCombined: true,searchText:'Enter here.' })
                        $('.mcoverbox')[0].sumo.reload();
                     }
                       $('#idv').keyup();
                        calculatePremium(1);
                 }
              });
            //}
              
          }
        function updInsQuotes(qid,catid,ftype)
          {
                $('.error').html('');
                $('#quote_id').val(qid);
                $('#quotee_id').val(qid);
                $('#edit').val('1');
                $('#aded').html('Edit ');
                $('#addQuotes').attr('style','display: block; padding-right: 15px;');
                $('#addQuotes').attr('class','modal fade in');
                if(ftype=='1'){
                  $('#divman').removeClass('active');  
                  $('#divcalc').addClass('active');
                  $('#calculator').attr('class','tab-pane fade in active model-hgt');
                  $('.modal-footer').hide();
                  $('#Manual').removeClass('in active');
                  $('#ftype').val('1');
                }else{
                   $('#divcalc').removeClass('active');  
                   $('#divman').addClass('active');
                   $('#calculator').removeClass('in active');
                   $('#Manual').attr('class','tab-pane fade in active model-hgt');
                   $('.modal-footer').show();
                   $('#fftype').val('2');
                }
                jQuery.ajax({
                type: "POST",
                url: base_url+"insurance/getQuoteInsurerData",
                data: {quote_id:qid},
                dataType: 'json',
                success: function(data){ 
                    var qsource = data.insData.qsource;
                    $("#third_party").val(data.insData.basic_third_party);
                    if(ftype=='1'){
                      $("#quote_date").val(data.insData.quote_date);
                      var cover_list = data.insData;
                      $("#qsource").val(qsource);
                      $("#zone_list").val(data.insData.zone);
                      $("#ins_detail").html(data.compony);   
                      $("#select_cover_list").find(':input').each(function(){
                       var cover_id = $(this).attr('id');
                       var name_cover = $(this).attr('name');     
                       var name_cover_txt = name_cover+"_txt";     
                       var namenewcover = cover_list[name_cover];
                       var namenewcovertxt = cover_list[name_cover_txt];
                      if(namenewcover == 1){
                           $("input[name='"+name_cover+"']").prop('checked', true);
                           $("."+name_cover).show();
                           $("#"+name_cover+"_txt").val(namenewcovertxt);
                       }else{
                           $("input[name='"+name_cover+"']").prop('checked', false);
                           $("#"+name_cover+"_txt").val("");
                       }
                      });
                      $("#divpremium").html(data.insData.totpremium);
                      $("#od_disc").val(data.insData.od_disc_perc);
                      $("#idv").val(data.insData.idv);
                      $("#per_acc_cover").val(data.insData.personal_acc_cover_txt);
                      $("#paid_driver").val(data.insData.paid_driver);
                      $("#add_on_txt").val(data.insData.add_on)
                      if(data.insData.add_on != ""){
                        $("#add_on_txt").css("display","block"); 
                        $("#add_on_perc").css("display","none");
                        $("#bundled_id").html("₹");
                        $("#add_on_txt").attr("readonly",false);  
                      }
                      $("#pass_cover").val(data.insData.pass_cover);
                    }else{
                        $("#mthird_party").val(data.insData.basic_third_party);
                        $("#mins_detail").html(data.compony);                    
                        $("#mqsource").val(qsource); 
                        $("#mquote_date").val(data.insData.quote_date);
                        $("#midv2").val(data.insData.idv_2);
                        $("#midv3").val(data.insData.idv_3);
                        $("#midv").val(data.insData.idv);
                        $("#maddon_price").val(data.insData.add_on);
                        $("#mbasic_od_amt").val(data.insData.basic_own_damage);
                        $("#mncb_discount").val(data.insData.ncb);
                        $("#mod_discount").val(data.insData.od_discount);
                        $("#melectrical").val(data.insData.electrical_accessories_txt);
                        $("#mnonelectrical").val(data.insData.non_electrical_accessories_txt);

                        $("#mpaid_driver").val(data.insData.paid_driver);
                        $("#mpass_cover").val(data.insData.passenger_cover_txt);
                        $("#mper_acc_cover").val(data.insData.personal_acc_cover_txt);
                        $("#madd_on").html(data.strCover);                        
                        $('.msearch1').SumoSelect({search: true, triggerChangeCombined: true, searchText:'Enter here.' });
                        $('.msearch1')[0].sumo.reload();//                      
                    }  
                   $('.csearch').SumoSelect({ csvDispCount: 3, search: true, searchText:'Enter here.' });
                   $('.csearch')[0].sumo.reload();
                   $('#select_cover_list').trigger('click');
                   $("#mdivpremium").html(data.insData.totpremium);
                   $('.mcoverbox').SumoSelect({ csvDispCount: 3, search: true,  triggerChangeCombined: true,searchText:'Enter here.' }); 
                 }
              });
            
          }  
        function closeBank(divid)
        {
          $('#addQuotes').attr('style','display: none; padding-right: 15px;');
          $('#addQuotes').attr('class','modal fade');
        }
        function closenewBank(divid)
        {
          $('#addcnewQuotes').attr('style','display: none; padding-right: 15px;');
          $('#addcnewQuotes').attr('class','modal fade');
        }
        function closeMore(id)
        {
            $('#bankdiv_'+id).remove();
        }
        function calculatePremium(ftype){
            var catid=$("#inscat").val();
            if(ftype=='1'){
            $("#divpremium").html('');
            var customer_id=$("#customer_id").val();
            var zone=$('#zone_list').val();
            var od_disc=$("#od_disc").val();
            var idv=$("#idv").val();
            var formdata = $('#frmadd').serialize()+'&customer_id='+customer_id;
            }else{
            $("#mdivpremium").html('');
            var customer_id=$("#customer_id").val();
            var zone=$('#mzone').val();
            var od_disc=$("#mod_discount").val();
            var idv=$("#midv").val();
            var formdata = $('#mfrmadd').serialize()+'&customer_id='+customer_id;    
            }
            if(zone!=''){
                
                jQuery.ajax({
                type: "POST",
                url: base_url+"insurance/calInsQuotePremium",
                data: formdata,
                dataType: 'html',
                success: function(data){
                    if($("#policy_type").val() ==2)
                    {
                        $("#divpremium").html(data);
                        $("#mdivpremium").html(data);  
                    }else{
                       if(ftype=='2'){
                        //   alert(data);
                       $("#mdivpremium").html(data);    
                       }else{ 
                       $("#divpremium").html(data);
                        }
                    }
                 }
              });
            }
        }
        $('#select_cover_list').click(function () {
           var selected = 0;
           $("#sselcover span").html('');
           $(':checked', this).each(function () {
               selected++;
           });
           if (selected > 0)
           {
            $("#sselcover span").text('');
            $("#sselcover span").text(selected + " selected");
           } else if (selected == 0) {
               $("#sselcover span").text('Select Covers');
           }
       });
       $(document).on('keydown', 'input[pattern]', function(e){
        var input = $(this);
        var oldVal = input.val();
        var regex = new RegExp(input.attr('pattern'), 'g');

        setTimeout(function(){
          var newVal = input.val();
          if(!regex.test(newVal)){
            input.val(oldVal); 
          }
        }, 0);
      });
      function quotesby(eve='',e='')
        {
        if(eve!='')
            {
               var id = $(eve).attr('id');
               //$('#searchby').val(id);
               if(id=='quotesamt')
               {
                  $('.bund').attr('style','display:block;');
                  $('.bund1').attr('style','display:none;');
                  $('#add_on_perc').val('');
                  
               }
               else if(id=='quotesperc')
               {
                  $('.bund').attr('style','display:none;');
                  $('.bund1').attr('style','display:block;');
                  $('#add_on_txt').val('');
               }
               else
               {
                  $('.bund').attr('style','display:block;');
                  $('.bund1').attr('style','display:none;');
               }
               
               
            }
        }
        $('.clsftype').on('click', function() { 
        $(this).addClass('active');
        if($(this).attr('id') == 'calculator1'){
          $('#ftype').val('1');
          $('.modal-footer').hide();
        } else if($(this).attr('id') == 'manual'){
          $('#fftype').val('2');
          $('.modal-footer').show();
        } 
      });
</script>