          <div class="white-section">
              <form enctype="multipart/form-data" method="post" id="CaseInfoForm" name="CaseInfoForm">
                  <div class="row">
                      <div class="col-md-12">
                          <h2 class="sub-title mrg-T0">Payment Details</h2>
                      </div>
                         <div class="col-md-6 bank" style="height:84px;">
                          <div class="form-group">
                              <label class="crm-label">Payment To*</label>
                              <select class="form-control" name="payment_by" id="payment_by">
                                <option value="0">Select</option>
                                <option value="1" <?=(!empty($paymentDetails['payment_by']) && ($paymentDetails['payment_by']=='1'))?'selected="selected"':''?>> Customer</option>
                                <option value="2" <?=(!empty($paymentDetails['payment_by']) && ($paymentDetails['payment_by']=='2'))?'selected="selected"':''?>> Inhouse</option>
                                <option value="3" <?=(!empty($paymentDetails['payment_by']) && ($paymentDetails['payment_by']=='3'))?'selected="selected"':''?>> Showroom</option>

                              </select>
                          </div>  
                          <div class="error" id="err_payment_by"></div>  
                      </div>
                       <div class="col-md-6 inhouse" style="height:84px;" >
                          <div class="form-group">
                              <label class="crm-label">Payment To*</label>
                              <select class="form-control" name="inpayment_by" id="inpayment_by">
                                <option value="0">Select</option>
                                <?php foreach(PAYMENT_BY_INHOUSE as $key=>$paymentby){?>
                                 <option value="<?= $key ?>" <?=(!empty($paymentDetails['payment_by']) && ($paymentDetails['payment_by']==$key))?'selected="selected"':''?>> <?=$paymentby?></option>
                                <?php  }?>
<!--                                <option value="2" <?=(!empty($paymentDetails['payment_by']) && ($paymentDetails['payment_by']=='2'))?'selected="selected"':''?>> Dealer</option>
                                <option value="3" <?=(!empty($paymentDetails['payment_by']) && ($paymentDetails['payment_by']=='3'))?'selected="selected"':''?>> Showroom</option>
                                <option value="4" <?=(!empty($paymentDetails['payment_by']) && ($paymentDetails['payment_by']=='4'))?'selected="selected"':''?>> Financier</option>
                                <option value="5" <?=(!empty($paymentDetails['payment_by']) && ($paymentDetails['payment_by']=='5'))?'selected="selected"':''?>> Third Party</option>-->
                              </select>
                          </div>  
                          <div class="error" id="err_inpayment_by"></div>  
                      </div>
                      <div class="col-md-6" style="height:84px;">
                          <div class="form-group">
                              <label class="crm-label">Payment Mode*</label>
                              <select class="form-control" name="payment_mode" id="payment_mode">
                                <option value="0">Select</option>
                                <option value="1" <?=(!empty($paymentDetails['payment_mode']) && ($paymentDetails['payment_mode']=='1'))?'selected="selected"':''?>> Cash</option>
                                <option value="2" <?=(!empty($paymentDetails['payment_mode']) && ($paymentDetails['payment_mode']=='2'))?'selected="selected"':''?>> Cheque</option>
                                <option value="3" <?=(!empty($paymentDetails['payment_mode']) && ($paymentDetails['payment_mode']=='3'))?'selected="selected"':''?>> DD</option>
                                <option value="4" <?=(!empty($paymentDetails['payment_mode']) && ($paymentDetails['payment_mode']=='4'))?'selected="selected"':''?>> Online</option>
                              </select>
                          </div>  
                          <div class="error" id="err_instrumenttypes"></div>  
                      </div>
                      <div class="col-md-6" style="height:84px;">
                          <div class="form-group">
                              <label for="" class="crm-label">Payment Date*</label>
                              <div class="input-group date" id="dp2">
                                <input type="text" class="form-control payment_date crm-form crm-form_1" id="paydates" name="paydate" autocomplete="off" value="<?=(!empty($paymentDetails['payment_date'])?date('d-m-Y',strtotime($paymentDetails['payment_date'])):'')?>" placeholder="Payment Date">
                                <span class="input-group-addon">
                                    <span class="">
                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                    </span>
                                </span>
                            </div>
                          </div>
                          <div class="error" id="err_paydate"></div>  
                      </div>
                      <div class="col-md-6" style="height:84px;" id="div_amount">
                          <div class="form-group">
                              <label for="" class="crm-label">Amount*</label>
                              <input type="text" name="amount" id="amount" onkeypress="return isNumberKey(event)" onkeyup="addCommased(this.value,'amount')" value="<?=!empty($paymentDetails['amount'])?$paymentDetails['amount']:''?>"  class="form-control crm-form rupee-icon" placeholder="Enter Amount">
                              
                          </div>
                          <div class="error" id="err_amounts"></div> 
                      </div>
                      <?php //echo "<pre>";print_r($paymentDetails);die;?>
                       <div class="col-md-6"  style="height: 84px" id="bnk">
                          <div class="form-group">
                              <label class="crm-label">Bank Name</label>
                               <select class="form-control crm-form lead_source testselect1" id="payment_banks" name="payment_bank">
                              <option value="">Select Bank</option>
                               <?php
                               $bank_id = !empty($paymentDetails['bank_id'])?$paymentDetails['bank_id']:"";
                              if(!empty($banklist)){
                                   foreach($banklist as $ckey => $cval){ ?>
                                   <option value="<?=$cval['bank_id']?>" <?=((!empty($bank_id) && ($bank_id==$cval['bank_id']))?'selected="selected"':'')?>><?=$cval['bank_name']?></option>
                                 <?php } }?>
                          </select>
                              <input type="hidden" id="payment_banks_name" value="<?=!empty($paymentDetails['bank_name'])?$paymentDetails['bank_name']:""?>" name="payment_banks_name">
                        
                              <div class="error" id="err_bank_lists"></div>
                          </div>
                      </div>

                      <div class="col-md-6"  style="height: 84px" id="favo">
                          <div class="form-group">
                              <label class="crm-label">Favouring</label>
                              <input type="text" id="favourings"  onkeypress="return blockSpecialChar(event)" name="favouring"  class="form-control crm-form" placeholder="Favouring" value="<?=(!empty($paymentDetails['favouring_to'])?$paymentDetails['favouring_to']:'')?>" >
                              <div class="error" id="err_favourings"></div>
                          </div>
                      </div>
                      <div class="col-md-6" style="height:84px;" id="div_ins">
                          <div class="form-group">
                              <label for="" class="crm-label">Instrument No</label>
                              <input type="text" name="instrument_no" id="instrument_no" value="<?=!empty($paymentDetails['instrument_no'])?$paymentDetails['instrument_no']:''?>" class="form-control upperCaseLoan crm-form">
                                  
                          </div>
                           <div class="error" id="err_insnos"></div>
                      </div>
                      <div class="col-md-6" style="height:84px;" id="div_insdate">
                          <div class="form-group">
                              <label for="" class="crm-label">Instrument Date</label>
                              <div class="input-group date" id="dp3">
                                <input type="text" class="form-control instrument_date crm-form crm-form_1" id="instrument_date" name="instrument_date" autocomplete="off" value="<?=((!empty($paymentDetails['instrument_date']) && ($paymentDetails['instrument_date']!='0000-00-00'))?date('d-m-Y',strtotime($paymentDetails['instrument_date'])):'')?>" placeholder="Instrument Date">
                                <span class="input-group-addon">
                                    <span class="">
                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                    </span>
                                </span>
                            </div>
                          </div>
                           <div class="error" id="err_insdates"></div>
                      </div>

                      <div class="col-md-6" style="height:84px;" id="div_pay">
                          <div class="form-group">
                              <label for="" class="crm-label">Payment Remark</label>
                              <input type="text" value="<?=!empty($paymentDetails['pay_remark'])?$paymentDetails['pay_remark']:''?>" name="remark" id="remark" class="form-control crm-form">
                               
                          </div>
                                          </div>
                      <div class="col-md-12">
                          <div class="btn-sec-width">
                          <input type="hidden" name="type" id="type" value="">
                          <input type="hidden" name="edit_id" id="edit_id" value="<?=!empty($paymentDetails['id'])?$paymentDetails['id']:''?>">
                          <input type="hidden" name="tp" id="tp" value="<?=!empty($paymentDetails['entry_type'])?$paymentDetails['entry_type']:''?>">
                           <input type="hidden" name="customer_id" id="customer_id" value="<?=$customerDetail[0]['customer_id']?>">
                            <input type="hidden" name="case_id" id="case_id" value="<?=$customerDetail[0]['customer_loan_id']?>">
                            <input type="hidden" name="cust" id="cust" value="<?=base64_encode('CustomerId_'.$customerDetail[0]["customer_loan_id"])?>">
                            <input type="hidden" name="financer" id="financer" value="<?=((!empty($customerDetail[0]['financer_name']))?$customerDetail[0]['financer_name']:'')?>">
                            <input type="hidden" name="financer_id" id="financer_id" value="<?=((!empty($customerDetail[0]['financer']))?$customerDetail[0]['financer']:'')?>">
                              <button type="button" class="btn-continue saveCont" style="display:block" id="paymentdetails" onclick="saveEditData()">SAVE</button>
                               <button type="button" class="btn-continue" onclick="countinue('')" style="display:none">CONTINUE</button>
                                                                  <!--<a href="finance-and-acedmic.html" class="btn-continue">SAVE AND CONTINUE</a>-->
                          </div>
                      </div>
                  </div>
              </form>
          </div>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script> 
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script>
  $('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
  </script>
<script>

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
  $("#payment_banks").change(function(){
      var val = $('#payment_banks option:selected').val();
      var payment_bank_name = $('#payment_banks option:selected').text();
      if(val == ""){
          payment_bank_name = "";
      }
        $("#payment_banks_name").val(payment_bank_name);
      
  });
  $('#payment_by').change(function(){
     var amout = "<?=$CustomerInfo['gross_net_amount']?>";
     var eid = "<?=!empty($paymentDetails['id'])?$paymentDetails['id']:''?>";
     var payment_by = $('#payment_by').val();
     if(eid==''){
     if(payment_by!='2')
     {
        addCommased(amout,'amount')
      //  $('#amount').val(amout);
     }
     else
     {
         $('#amount').val('');
     }
   }
  });
  $('#payment_mode').change(function(){

  var inst = $('#payment_mode').val();
  if(inst=='1')
  {
      $('#div_insdate').attr('style','display:none;');
      $('#bnk').attr('style','display:none;');
      $('#favo').attr('style','display:none;');
      $('#div_ins').attr('style','display:none;');
  }
  if(inst=='2')
  {
      $('#div_insdate').attr('style','display:block;');
      $('#bnk').attr('style','display:block;');
      $('#favo').attr('style','display:block;');
      $('#div_ins').attr('style','display:block;');
  }
  if(inst=='3')
  {
      $('#div_insdate').attr('style','display:block;');
      $('#bnk').attr('style','display:block;');
      $('#favo').attr('style','display:block;');
      $('#div_ins').attr('style','display:block;');
  }
  if(inst=='4')
  {
      $('#div_insdate').attr('style','display:none;');
      $('#bnk').attr('style','display:none;');
      $('#favo').attr('style','display:none;');
      $('#div_ins').attr('style','display:block;');
  }
});
  var paym = "<?=(!empty($paymentDetails['payment_mode']))?$paymentDetails['payment_mode']:''?>";
  if(paym!='')
  { 
    if(paym=='1')
  {
      $('#div_insdate').attr('style','display:none;');
      $('#bnk').attr('style','display:none;');
      $('#favo').attr('style','display:none;');
      $('#div_ins').attr('style','display:none;');
  }
  if(paym=='2')
  {
      $('#div_insdate').attr('style','display:block;');
      $('#bnk').attr('style','display:block;');
      $('#favo').attr('style','display:block;');
      $('#div_ins').attr('style','display:block;');
  }
  if(paym=='3')
  {
      $('#div_insdate').attr('style','display:block;');
      $('#bnk').attr('style','display:block;');
      $('#favo').attr('style','display:block;');
      $('#div_ins').attr('style','display:block;');
  }
  if(paym=='4')
  {
      $('#div_insdate').attr('style','display:none;');
      $('#bnk').attr('style','display:none;');
      $('#favo').attr('style','display:none;');
      $('#div_ins').attr('style','display:block;');
  }

  }

  var tpp = $('#tp').val();
if(tpp=='1')
{
  $('.bank').attr('style','display:block;');
  $('.inhouse').attr('style','display:none;');
}
else
{
  $('.bank').attr('style','display:none;');
  $('.inhouse').attr('style','display:block;');

}
</script>

