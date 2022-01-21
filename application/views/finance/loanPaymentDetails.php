<?php //echo "<pre>"; print_r($CustomerInfo['name']); exit;?>
<!--<div class="container-fluid">-->
              
                   
                     <div class="white-section class-scroll1">
                         <form  enctype="multipart/form-data" method="post"  id="paymentDetails" name="paymentDetails">
                        <div class="row"> 
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Instrument Type *</label>
                                  <select class="form-control crm-form" id="instrument_type" name="instrument_type">
                                      <option value="">Please Select</option>    
                                  <option value="1" <?php echo (!empty($postInfo['instrument_type']) && ($postInfo['instrument_type']=='1')) ? "selected=selected" : ''?>>Cheque</option>
                                  <option value="2" <?php echo (!empty($postInfo['instrument_type']) &&  ($postInfo['instrument_type']=='2')) ? "selected=selected" : ''?>>ECS</option>
                                  <option value="3" <?php echo (!empty($postInfo['instrument_type']) && ($postInfo['instrument_type']=='3')) ? "selected=selected" : ''?>>SI</option>
                                   <option value="4" <?php echo (!empty($postInfo['instrument_type']) && ($postInfo['instrument_type']=='4')) ? "selected=selected" : ''?>>Cancelled Cheque</option>
                                    <option value="5" <?php echo (!empty($postInfo['instrument_type']) && ($postInfo['instrument_type']=='5')) ? "selected=selected" : ''?>>Security</option>
                                </select>
                                <div class="d-arrow"></div>
                                 <div class="error" id="err_instrument_type"></div>
                                 </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="normalEntry">
                                <label for="" class="crm-label">Entry Type *</label>
                                    <span style="width: 49%" class="radio-btn-sec nor" <?php echo (!empty($postInfo['entry']) && $postInfo['entry']=='normal') ? '' : 'style="display:none"'?>>
                                        <input type="radio" name="entry" id="normal" value="normal" class="trigger" <?= !empty($postInfo && $postInfo['entry']=='normal')?'checked=checked':''?>>
                                        <label for="normal"><span class="dt-yes"></span> Normal Entry</label>
                                    </span>
                                    <span  style="width: 49%"  class="radio-btn-sec bat" <?php echo (!empty($postInfo['entry']) && $postInfo['entry']=='batch') ? '' : 'style="display:none"'?>>
                                        <input type="radio" name="entry" id="batch" value="batch" class="trigger" <?= !empty($postInfo && $postInfo['entry']=='batch')?'checked=checked':''?>>
                                        <label for="batch"><span class="dt-yes"></span> Batch Entry</label>
                                    </span>
                                    <div class="error" id="err_entry"></div>
                                </div>    
                            </div>
                           <div class="col-md-6" style="display: none;">
                              <div class="form-group">
                                 <label for="" class="crm-label">Instrument No.<span class="hidestar">*</span></label>
                                 <input type="text" class="form-control crm-form" onkeypress="return blockSpecialChar(event)" name="instrument_no" id="instrument_no" value="<?php echo (!empty($postInfo['instrument_no'])) ? $postInfo['instrument_no'] : ''?>" placeholder="Instrument No">
                                 <div class="error" id="err_instrument_no"></div>
                              </div>
                           </div>
                            <div class="col-md-6" id="divfcheque" <?php echo (!empty($postInfo['cheque_from'])) ? '' : 'style="display:none"'?>>
                              <div class="form-group">
                                 <label for="" class="crm-label ceckfrom"><?php echo (!empty($postInfo['entry']) && $postInfo['entry']=='normal') ? 'Cheque Number' : 'Cheque From'?></label>
                                   <input type="text" class="form-control crm-form" name="cheque_from" id="cheque_from" value="<?php echo (!empty($postInfo['cheque_from'])) ? $postInfo['cheque_from'] : ''?>" placeholder="Cheque From" maxlength="20">
                                   <div class="error" id="err_cheque_from"></div>
                              </div>
                           </div>
                            <div class="col-md-6" id="divtcheque" <?php echo (!empty($postInfo['cheque_to'])) ? '' : 'style="display:none"'?>>
                              <div class="form-group">
                                 <label for="" class="crm-label ceckto">Cheque To</label>
                                  <input type="text" class="form-control crm-form" name="cheque_to" id="cheque_to" value="<?php echo (!empty($postInfo['cheque_to'])) ? $postInfo['cheque_to'] : ''?>" placeholder="Cheque To" maxlength="20">
                                  <div class="error" id="err_cheque_to"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Drawn On Bank<span class="hidestar">*</span></label>
                                 <select class="form-control testselect1 crm-form" id="drawn_bank" name="drawn_bank">
                                     <option value="">Select Bank</option>    
                                  <?php foreach($banklist as $bk=>$bv){?>   
                                  <option value="<?php echo $bv['bank_id'];?>" <?php echo (!empty($postInfo['drawn_bank']) && ($postInfo['drawn_bank']==$bv['bank_id'])) ? "selected=selected" : ''?>><?php echo $bv['bank_name'];?></option>
                                  <?php } ?>
                                </select>
                                <!--<div class="d-arrow"></div>-->
                                 <div class="error" id="err_drawn_bank"></div>
                                 </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Account No.<span class="hidestar">*</span></label>
                                  <input type="text" class="form-control crm-form" maxlength="20"  placeholder="Account No" onkeypress="return isNumberKey(event)" name="account_no" id="account_no" value="<?php echo (!empty($postInfo['account_no'])) ? $postInfo['account_no'] : (!empty($CustomerInfo['custacc'])?$CustomerInfo['custacc']:'')?>">
                                   <div class="error" id="err_account_no"></div>
                              </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Instrument Date<span class="hidestar">*</span></label>
                                 <div class="input-group date" id="dp">
                                 <input type="text" class="form-control crm-form" placeholder="Instrument Date" name="instrument_date" id="instrument_date" value="<?php echo (!empty($postInfo['instrument_date']) && ($postInfo['instrument_date']!='0000-00-00')) ? date('d-m-Y',strtotime($postInfo['instrument_date'])) : ''?>">
                                 <span class="input-group-addon">
                                     <span class="">
                                       <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                  </span>
                                 </div>
                                 <div class="error" id="err_instrument_date"></div>
                              </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Amount<span class="hidestar">*</span></label>
                                 <input type="text" class="form-control rupee-icon crm-form" placeholder="Amount" onkeypress="return isNumberKey(event)" onkeyup="addCommas(this.value,'amount');" name="amount" id="amount" value="<?php echo (!empty($postInfo['amount'])) ? $postInfo['amount'] : !empty($CustomerInfo['disburse_emi'])?$CustomerInfo['disburse_emi']:''?>"  >
                                 <div class="error" id="err_amount"></div>
                              </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Favouring<span class="hidestar">*</span></label>
                                  <input type="text" class="form-control crm-form" placeholder="Favouring" name="favouring" id="favouring" value="<?php echo (!empty($postInfo['favouring'])) ? $postInfo['favouring'] :$CustomerInfo['financer_name']?>" readonly="readonly" style="margin-top:0px">
                                   <div class="error" id="err_favouring"></div>
                              </div>
                           </div>
                            <div class="col-md-6">
                                <div class="form-group" id="signEntry">
                                <label for="" class="crm-label">Signed By *</label>
                                    <span style="width: 49%" class="radio-btn-sec">
                                        <input type="radio" name="signed_by_opt" id="yesn" value="1" class="trigger" <?= !empty($postInfo && $postInfo['signed_by_opt']=='1')?'checked=checked':''?>>
                                        <label for="yesn"><span class="dt-yes"></span>Applicant</label>
                                    </span>
                                    <span  style="width: 49%"  class="radio-btn-sec">
                                        <input type="radio" name="signed_by_opt" id="non" value="2" class="trigger" <?= !empty($postInfo && $postInfo['signed_by_opt']=='2')?'checked=checked':''?>>
                                        <label for="non"><span class="dt-yes"></span>Co Applicant</label>
                                    </span>
                                    <div class="error" id="err_signed_by_opt"></div>
                                </div>    
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Signed Name<span class="hidestar">*</span></label>
                                  <input type="text" class="form-control crm-form" placeholder="Signed By" name="signed_by" id="signed_by" value="<?php echo (!empty($postInfo['signed_by'])) ? $postInfo['signed_by'] : (!empty($CustomerInfo['name'])?$CustomerInfo['name']:'')?>">
                                  <div class="error" id="err_signed_by"></div>
                              </div>
                            </div>
                            
                           <input type="hidden" name="paymentForm" value="1" id="paymentForm">
                            <input type="hidden" name="rolemgmt" value="<?=(!empty($rolemgmt[0]['role_name'])?$rolemgmt[0]['role_name']:'')?>" id="rolemgmt">
                             <input type="hidden" value="<?= !empty($CustomerInfo['customer_id'])?$CustomerInfo['customer_id']:'' ?>" name="customerId">
                            <input type="hidden" name="edit_id" value="<?=(!empty($postInfo['id']))?$postInfo['id']:''?>" id="edit_id"> 
                             <input type="hidden" name="case_id" value="<?=(!empty($CustomerInfo['customer_loan_id']))?$CustomerInfo['customer_loan_id']:''?>" id="case_id"> 
                          <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <?php 
                                      $stylesss = 'display:block';
                                      $stylec = 'display:none';
                                      $action = '';
                                    if(((!empty($CustomerInfo['instrument_type'])) && ($rolemgmt[0]['edit_permission']=='0') && (!empty($CustomerInfo['cust_bnk_id'])))|| ($rolemgmt[0]['add_permission']=='0'))
                                      {
                                          $stylesss  = 'display:none';
                                          $stylec = 'display:block';
                                         // $action = base_url('postDeliveryDetails/');

                                      } 
                                       if($CustomerInfo['cancel_id']=='0'){ ?>
                                  <button type="button" class="btn-continue saveCont" style="<?=$stylesss?>" id="paymentDetailsButton">SAVE</button>
                                   <button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                                <?php } ?>
                               </div>
                           </div>
                        </div>
                        </form>
                     </div>
                   <!--</div>
               </div>
           </div>-->
<?php $currentdate=date('Y/m/d');?>
<script>
  /*  $(document).ready(function() {
     StartDate =  '<?=date('Y/m/d',  strtotime($currentdate));?>';
      now      = '<?= date('Y-m-d') ?>';
       $('#instrument_date').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        startDate: StartDate,
        maxDate:new Date(now),
        constrainInput: true,
        scrollMonth: false,
        scrollTime: false,
        scrollInput: false,
    });
    });*/
     </script>
     <script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/jquery.sumoselect.min.js"></script> 
<script>
  $('.testselect1').SumoSelect({csvDispCount: 3, search: true, searchText:'Enter here.',triggerChangeCombined: true});
    $(document).ready(function() {

        /*$('#invoice_date,#invoice_received_on').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: '',
                endDate:'+7d',
                autoclose: true,
                todayHighlight: true   
             });*/
         $('#instrument_date').datepicker({
                format: 'dd-mm-yyyy',
                //endDate:'+1d',
                autoclose: true,
                todayHighlight: true   
             });
    });
     </script>
<script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>
<script>
 var instrument_type =  "<?=!empty($CustomerInfo['instrument_type'])?$CustomerInfo['instrument_type']:''?>";
    if(instrument_type=='1'){
        $("#divfcheque").show();
        $("#divtcheque").show();
        $(".bat").show();
        $(".hidestar").attr('style','display:inline-block;');
        $(".nor").show();
        $("#normalEntry").addClass('mrg-T10');
        $('#normalEntry').show();
        $("#batch").prop("checked", true);
    }else if((instrument_type=='4') || (instrument_type=='5') ){
        $("#divfcheque").hide();
        $("#divtcheque").hide();
        $("#batch").prop("checked", false);
        $(".bat").hide();
        $(".nor").hide();
         $(".hidestar").attr('style','display:none;');
        $("#normalEntry").removeClass('mrg-T10');
        $('#normalEntry').hide();
    }
    else{
        $("#divfcheque").hide();
        $("#divtcheque").hide();
        $("#batch").prop("checked", false);
        $(".bat").hide();
        $(".nor").hide();
        $('#normalEntry').hide();
        $(".hidestar").attr('style','display:inline-block;');
        $("#normalEntry").removeClass('mrg-T10');
    }


</script>