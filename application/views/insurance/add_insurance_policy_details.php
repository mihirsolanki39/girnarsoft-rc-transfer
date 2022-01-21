<?php
$is_admin=$this->session->userdata['userinfo']['is_admin'];
$addPerm=isset($permission[0]['add_permission']) ? $permission[0]['add_permission'] :'' ;
$editPerm=isset($permission[0]['edit_permission']) ? $permission[0]['edit_permission']:'';
$viewPerm=isset($permission[0]['view_permission']) ? $permission[0]['view_permission'] : '';
$mode=(!empty($CustomerInfo['current_insurance_company'])) ? 'edit' : 'add';
$stylec = 'display:block';
$action = ($mode=='edit')? base_url('insDocumentDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_id"]) :'';
?>
<div class="container-fluid">
               <div class="row">
                   <form name="policyform" id="policyform" method="post" action="">
                    <h2 class="page-title mrg-L10">New Policy Details</h2>
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <div class="white-section">
                        <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0">New Policy Details</h2>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label class="crm-label">Policy Issued*</label>
                                  <span class="radio-btn-sec">
                                      <input type="radio" name="policy_issued" id="issuedYes" value="1" onclick="return showpolicyIssue('1');" class="trigger" <?php echo (!empty($CustomerInfo['current_policy_issued']) && $CustomerInfo['current_policy_issued']=='1') ? "checked=checked" : '';?>>
                                     <label for="issuedYes"><span class="dt-yes"></span> Yes</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="policy_issued" id="issuedNo" value="2" onclick="return showpolicyIssue('2');" class="trigger"<?php echo (!empty($CustomerInfo['current_policy_issued']) && $CustomerInfo['current_policy_issued']=='2') ? "checked=checked" : '';?>>
                                     <label for="issuedNo"><span class="dt-yes"></span> No</label>
                                 </span>
                                 <div class="error" id="policy_issued_error"></div>
                              </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label class="crm-label">Policy Type*</label>
                                  <select class="form-control crm-form" name="policy_type" id="policy_type" style="pointer-events:none;" readonly="readonly">
                                     <option value="">Please Select</option>
                                     <?php foreach(INSURANCE_POLICY_TYPE as $k=>$policy){?>
                                     <option value="<?=$k?>"<?php echo ((!empty($CustomerInfo['current_policy_type'])) && $CustomerInfo['current_policy_type']==$k)? "selected=selected" : '';?>><?php echo $policy; ?></option>
                                     <?php } ?>
                                 </select>
                                   
<!--                                  <span class="radio-btn-sec">
                                     <input type="radio" name="policy_type" id="comprehensive" value="1" class="trigger" checked="checked" <?php echo ((!empty($CustomerInfo['current_policy_type'])) && $CustomerInfo['current_policy_type']=='1') ? "checked=checked" : '';?>>
                                     <label for="comprehensive"><span class="dt-yes"></span> Comprehensive</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="policy_type" id="third_party" value="2" class="trigger"<?php echo (!empty($CustomerInfo['current_policy_type']) && $CustomerInfo['current_policy_type']=='2') ? "checked=checked" : '';?>>
                                     <label for="third_party"><span class="dt-yes"></span> Third Party</label>
                                 </span>-->
                                 <div class="error" id="policy_type_error" ></div>
                                  <div class="d-arrow"></div>
                              </div>
                           </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label for="" class="crm-label">Insurance Company*</label>
                                    <select class="form-control crm-form" name="ins_company" id="ins_company" style="pointer-events:none;" readonly="readonly">
                                     <option value="">Please Select</option>
                                     <?php foreach($insurerList as $kcom=>$vcom){?>
                                     <option value="<?=$vcom['prev_policy_insurer_slug']?>"<?php echo (!empty($quoteData['insurance_company']) && $quoteData['insurance_company']==$vcom['prev_policy_insurer_slug']) ? "selected=selected" : '';?>><?php echo $vcom['short_name'] ?></option>
                                     <?php } ?>
                                 </select>
                                    <div class="error" id="ins_company_error" ></div>
                                    <div class="d-arrow"></div>
                             </div>
                            </div>
                            <div class="col-md-6" id="divpolicyno" <?php echo (!empty($CustomerInfo['current_policy_issued']) && $CustomerInfo['current_policy_issued']=='1') ? '' : 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Policy No.*</label>
                                    <input type="text" name="policy_no"  id="policy_no" onkeypress="return alpha1only(event);" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['current_policy_no'])) ? $CustomerInfo['current_policy_no']:'';?>" placeholder="Policy No" maxlength="30">
                                    <div class="error" id="policy_no_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6" id="divcovernoteno" <?php echo (!empty($CustomerInfo['current_policy_issued']) && $CustomerInfo['current_policy_issued']=='2') ? '' : 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Covernote No.*</label>
                                    <input type="text" name="covernote_no"  id="covernote_no" onkeypress="return isNumberKey(event);" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['current_covernote_no'])) ? $CustomerInfo['current_covernote_no']:'';?> " placeholder="Covernote No" maxlength="15">
                                    <div class="error" id="covernote_no_error"></div>
                             </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="crm-label">Issue Date*</label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1" id="issue_date" name="issue_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CustomerInfo['current_issue_date']) && $CustomerInfo['current_issue_date']<>'0000-00-00') ? date('d-m-Y',strtotime($CustomerInfo['current_issue_date'])) : '';?>">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="issue_date_error" ></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="crm-label">Inception Date*</label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1" id="inception_date" name="inception_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CustomerInfo['inception_date']) && $CustomerInfo['inception_date']<>'0000-00-00') ? date('d-m-Y',strtotime($CustomerInfo['inception_date'])) : '';?>">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="inception_date_error" ></div>
                                </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                  <label for="" class="crm-label">Due Date*</label>
                                  <div class="input-group date" id="dp">
                                      <input type="text" class="form-control crm-form crm-form_1" id="due_date" name="due_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CustomerInfo['current_due_date']) && $CustomerInfo['current_due_date']<>'0000-00-00') ?date('d-m-Y',strtotime($CustomerInfo['current_due_date'])): '';?>" readonly="readonly">
                                      <span class="input-group-addon">
                                          <span class="">
                                              <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                      </span>
                                  </div>
                                  <div class="error" id="due_date_error" ></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label for="" class="crm-label">NCB Discount(%)</label>
                                    <input type="text" name="ncb_discount"  id="ncb_discount" onkeypress="return isNumberKey(event);" onchange="if(this.value.length > 1) this.value=this.value+'%';" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['current_ncb_discount'])) ? $CustomerInfo['current_ncb_discount'].'%':(!empty($ncbData['ncb_discount'])) ? $ncbData['ncb_discount'].'%':'';?>" placeholder="NCB Discount" maxlength="2" readonly="true" >
                                    <div class="error" id="ncb_discount_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <?php // echo "<pre>";print_r($CustomerInfo['current_ins_duration']);die; ?>
                                    <label for="" class="crm-label">Insurance Duration*</label>
                                     <?php if(!empty($CustomerInfo['ins_category']) && $CustomerInfo['ins_category']=='1'){?>
                                    <select class="form-control crm-form" name="ins_duration" id="ins_duration" style="pointer-events:none;" readonly="readonly">
                                     <option value="1"<?php echo (!empty($CustomerInfo['current_ins_duration']) && $CustomerInfo['current_ins_duration']=='1') ? "selected=selected" : '';?>>1 yr OD+3 yr TP</option>
                                     <option value="2"<?php echo (!empty($CustomerInfo['current_ins_duration']) && $CustomerInfo['current_ins_duration']=='2') ? "selected=selected" : '';?>>3 yr OD+3 yr TP</option>
                                    </select>
                                    <div class="error" id="ins_duration_error" ></div>
                                    <div class="d-arrow"></div>
                                     <?php } else{?>
                                    <input type="text" name="ins_duration" id="ins_duration" value="1" class="form-control" readonly="readonly">
                                     <?php } ?>                                     
                             </div>
                            </div>
                            <?php if(($CustomerInfo['current_policy_type']) != 2) { ?>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label for="" class="crm-label">IDV*</label>
                                    <input type="text" name="idv" onkeypress="return isNumberKey(event)"  id="idv" class="form-control crm-form rupee-icon" onpaste="return false;" onkeyup="addCommas(this.value, 'idv');" value="<?php echo (!empty($quoteData['idv'])) ? indian_currency_form($quoteData['idv']) : '';?>" placeholder="IDV" maxlength="10" readonly="readonly">
                                    <div class="error" id="idv_error" ></div>
                             </div>
                            </div>
                            <?php } ?>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label for="" class="crm-label">Total premium<a class="mrg-L5 check-quotes" data-toggle="modal" data-id="<?php echo !empty($quoteData["id"]) ? $quoteData["id"]:'';?>" data-target="#quote-details"><span></span><img src="<?php echo base_url()?>assets/images/info.svg"></a></label>
                                    <input type="text" name="premium" onkeypress="return isNumberKey(event)" id="premium" class="form-control crm-form rupee-icon" onpaste="return false;" onkeyup="addCommas(this.value, 'premium');" value="<?php echo (!empty($quoteData['totpremium'])) ? indian_currency_form($quoteData['totpremium']) : '';?>" placeholder="Total Premium" maxlength="10" readonly="readonly">
                                    <div class="error" id="premium_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label class="crm-label">Existing Loan On Car</label>
                                  <span class="radio-btn-sec">
                                     <input type="radio" name="loan_taken" id="lyes" value="1" class="trigger loanyes" <?php echo (!empty($CustomerInfo['current_loan_taken'])) && $CustomerInfo['current_loan_taken']=='1' ? "checked='checked'" : '';?>>
                                     <label for="lyes"><span class="dt-yes"></span> Yes</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="loan_taken" id="lno" value="2" class="trigger loanyes" <?php echo (!empty($CustomerInfo['current_loan_taken'])) && $CustomerInfo['current_loan_taken']=='2' ? "checked='checked'" : '';?>>
                                     <label for="lno"><span class="dt-yes"></span> No</label>
                                 </span>
                                 <div class="error" id="loan_taken_error" ></div>
                              </div>
                           </div>
                           <div class="col-md-6" id="divfinance" <?php echo (!empty($CustomerInfo) && $CustomerInfo['current_loan_taken']=='1') ? '' : 'style="display:none;"'?>>
                              <div class="form-group">
                                 <label for="" class="crm-label">HP to *</label>
                                  <select class="form-control crm-form reg_reqq" name="hp_to" id="hp_to">
                                     <option value="">Please Select</option>
                                     <?php if(!empty($banklist)) {
                                    foreach ($banklist as $key =>$value) {?>
                                   <option  value="<?= $value['bank_id'];?>" <?= (!empty($CustomerInfo['current_hp_to']) && $CustomerInfo['current_hp_to']==$value['bank_id'])?'selected=selected':''?>><?= $value['bank_name']?></option>
                                  <?php  } } ?>
                                 </select>
                                <div class="d-arrow"></div>
                                <div class="error" id="err_hp_to"></div>
                              </div>
                           </div> 
                            <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <?php if(($is_admin=='1') || (($addPerm=='1') && ($mode=='add')) ||  (($editPerm=='1') && ($mode=='edit'))){?>
                                   <input  style="text-align: center" type="button" class="btn-continue" name="btnform5" id="btnform5" value="SAVE AND CONTINUE">
                                  <?php } elseif(($viewPerm=='1') && ($mode=='edit') || (!empty($CustomerInfo['idv']))){ ?>
                                  <button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                                  <?php } ?>
                                  <input type="hidden" name="carDet" id="carDet" value="<?=((!empty($CustomerInfo['engineNo'])) && (!empty($CustomerInfo['chasisNo'])))?'1':'0'?>">
                                  <input type="hidden" name="step5" value="true">
                                  <input type="hidden" name="customerId" id="customer_id" value="<?php echo isset($customerId) ? $customerId :''; ?>">
                               </div>
                           </div>
                        </div>
                     </div>
                   
                      
                  </div>
                   </form>
               </div>
            </div>
         </div>
<div class="modal fade" id="quote-details" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-sm modal-wd" role="document" id="quote-details">
     <div class="modal-content access_modal"  id="quote-details-content">
     </div>
    </div>
</div>

<div class="modal fade bs-example-modal-md" id="saveCardetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header bg-gray">
          <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png')?>"> <span class="sr-only">Close</span></button>
                <h4 class="modal-title">Complete Car Details</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                    
                    <div class="col-md-6">
                      <div class="form-group">
                         <label for="" class="crm-label">Engine No</label>
                         <input type="text" maxlength="17" name="engineno" id="engineno" class="form-control crm-form" value="<?=(!empty($CustomerInfo['engineNo'])?strtoupper($CustomerInfo['engineNo']):'')?>" placeholder="Engine No">
                         <div class="error" id="engineno_err"></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                         <label for="" class="crm-label">Chassis No</label>
                         <input type="text" maxlength="17" name="chassisno" id="chassisno" class="form-control crm-form" value="<?=(!empty($CustomerInfo['chasisNo'])?strtoupper($CustomerInfo['chasisNo']):'')?>" placeholder="Chassis No">
                         <div class="error" id="chassisno_err"></div>
                      </div>
                    </div>


                  
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="saveCarDetails" class="btn btn-primary">SAVE</button>
            </div>
          </div>
        </div>
      </div>

         <?php $currentdate=date('d/m/Y');?>
<script>
    $(document).ready(function() {
        $('#issue_date').datepicker({
        timepicker: false,
        format: 'dd-mm-yyyy',
        startDate: '-47d',
        endDate:'+45d',
        autoclose: true,
        todayHighlight: true
    });
    });
    
    $(document).ready(function() {
    $('#inception_date').datepicker({
    timepicker: false,
    format: 'dd-mm-yyyy',
    startDate: '-47d',
    endDate:'+45y',
    autoclose: true,
    todayHighlight: true
    });
    $('input[name=inception_date]').change(function() {
    var issueDate=$('#inception_date').val();
    if(issueDate!=''){
    var parts = issueDate.split("-");
    var day = parts[0] && parseInt( parts[0], 10 );
    var month = parts[1] && parseInt( parts[1], 10 );
    var year = parts[2] && parseInt( parts[2], 10 );
    var filter_sel = "<?= !empty($ncbData['duration'])?$ncbData['duration']:1; ?>";
    if(filter_sel == 2)
       var duration =3;
    else
       var duration =1; 
    var expiryDate = new Date( year, month - 1, day-1 );
    expiryDate.setFullYear( expiryDate.getFullYear() + duration );
    var day = ( '0' + expiryDate.getDate() ).slice( -2 );
    var month = ( '0' + ( expiryDate.getMonth() + 1 ) ).slice( -2 );
    var year = expiryDate.getFullYear();
    if(day!='' && day!='aN' && month!='' && month!='aN' && year!='' && year!='NaN'){
    $("#due_date").val( day + "-" + month + "-" + year );
    }
    }else{
     $("#due_date").val('');   
    }
    });
    });
    </script>
   <script src="<?php echo base_url(); ?>assets/js/insurance_process.js" type="text/javascript"></script>
   <script src="<?php echo base_url(); ?>assets/js/insuranceValidation.js" type="text/javascript"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
   <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_assets/css/sumoselect.min.css">
   <script src="<?php echo base_url(); ?>assets/js/jquery.sumoselect.min.js"></script>
   <script>
    $('#divfinance').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
   </script>