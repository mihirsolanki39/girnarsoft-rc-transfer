    <?php 

        $showbank =  !empty($paymentDetails['entry_type']=='1')?'Bank':'Showroom';
        $inbank =  !empty($paymentDetails['entry_type']=='2')?'Bank':'Inhouse';


    ?>
          <div class="white-section">
              <form enctype="multipart/form-data" method="post" id="CaseInfoForm" name="CaseInfoForm">
                  <div class="row">
                      <div class="col-md-12">
                          <h2 class="sub-title mrg-T0">Payment Details</h2>
                      </div>
                         <div class="col-md-6" style="height:84px;">
                          <div class="form-group">
                              <label class="crm-label">Payment By* showroom</label>
                              <select class="form-control" name="payment_by" id="payment_by">
                                <option value="0">Select</option>
                                <option value="1" <?=(!empty($paymentDetails['payment_by']) && ($paymentDetails['payment_by']=='1'))?'selected="selected"':''?>> Customer</option>
                                <option value="2" <?=(!empty($paymentDetails['payment_by']) && ($paymentDetails['payment_by']=='2'))?'selected="selected"':''?>> <?=$inbank?></option>
                                <option value="3" <?=(!empty($paymentDetails['payment_by']) && ($paymentDetails['payment_by']=='3'))?'selected="selected"':''?>> <?php echo $showbank;?></option>

                              </select>
                          </div>  
                          <div class="error" id="err_instrumenttypes"></div>  
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
                          <div class="error" id="err_paymentmode"></div>  
                      </div>
                      <div class="col-md-6" style="height:84px;">
                          <div class="form-group">
                              <label for="" class="crm-label">Payment Date*</label>
                              <div class="input-group date" id="dp2">
                                <input type="text" class="form-control payment_date crm-form crm-form_1" id="paydates" name="paydate" autocomplete="off" value="<?=(!empty($paymentDetails['payment_date'])?date('d-m-Y',strtotime($paymentDetails['payment_date'])):'')?>"  placeholder="Payment Date">
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
                              <label for="" class="crm-label">Amount Paid*</label>
                              <input type="text" name="amount" id="amount" onkeypress="return isNumberKey(event)"  value="<?=!empty($paymentDetails['amount'])?$paymentDetails['amount']:''?>" onkeyup="addCommased(this.value,'amount')" class="form-control crm-form rupee-icon" placeholder="Enter Amount">
                              
                          </div>
                          <div class="error" id="err_amounts"></div> 
                      </div>
                       <div class="col-md-6"  style="height: 84px" id="bnk">
                          <div class="form-group">
                              <label class="crm-label">Bank Name</label>
                               <select class="form-control crm-form lead_source" id="payment_banks" name="payment_bank">
                              <option value="">Select Bank</option>
                               <?php
                              if(!empty($banklist)){
                                   foreach($banklist as $ckey => $cval){ ?>
                                   <option value="<?=$cval['bank_id']?>" rel="<?=$cval['bank_name']?>" <?=((!empty($paymentDetails['bank_id']) && ($paymentDetails['bank_id']==$cval['bank_id']))?'selected="selected"':'')?>><?=$cval['bank_name']?></option>
                                 <?php } }?>
                          </select>
                          <!-- <div class="d-arrow"></div> -->
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
                                <input type="text" class="form-control instrument_date crm-form crm-form_1" id="instrument_date" name="instrument_date" autocomplete="off" value="<?=((!empty($paymentDetails['instrument_date']) && ($paymentDetails['instrument_date']!='0000-00-00'))?date('d-m-Y',strtotime($paymentDetails['instrument_date'])):'')?>"  placeholder="Instrument Date">
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
                            <input type="hidden" name="case_id" id="case_id" value="<?=$orderinfo['orderId']?>">
                            <input type="hidden" name="cust" id="cust" value="<?=base64_encode('OrderId_'.$orderinfo['orderId'])?>">
                            <input type="hidden" name="financer" id="financer" value="<?=((!empty($paymentDetails['financer_name']))?$paymentDetails['financer_name']:'')?>">
                            <input type="hidden" name="financer_id" id="financer_id" value="<?=((!empty($paymentDetails['financer']))?$paymentDetails['financer']:'')?>">
                              <button type="button" class="btn-continue saveCont" style="display:block" id="paymentdetails" onclick="saveEditData()">SAVE</button>
                               <button type="button" class="btn-continue" onclick="countinue('')" style="display:none">CONTINUE</button>
                                                                  <!--<a href="finance-and-acedmic.html" class="btn-continue">SAVE AND CONTINUE</a>-->
                          </div>
                      </div>
                  </div>
              </form>
          </div>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script> 
<script>
     function convertToIndianCurrency(nStr,control,flag='',flag1 ='')
  {
        if(flag==1){
            nStr=nStr.replace(/,/g,''); 
        }else
        {
            nStr=nStr; 
        }     
        x=nStr.toString();
        var afterPoint = '';
        if(x.indexOf('.') > 0)
           afterPoint = x.substring(x.indexOf('.'),x.length);
        x = Math.floor(x);
        x=x.toString();
        var lastThree = x.substring(x.length-3);
        var otherNumbers = x.substring(0,x.length-3);
        if(otherNumbers != '')
            lastThree = ',' + lastThree;
        var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
         if(flag1 == 1)
            return res;
        else
            document.getElementById(control).value=res;
  }
      $(document).ready(function(){
        $('.req').attr('style','display:none;');
        $('.reqc').attr('style','display:none;');
                var val = $("#amount").val();               
               var val_Comma = convertToIndianCurrency(val,'','1','1');  
               if(val_Comma!='0'){ 
                $("#amount").val(val_Comma); 
              }
                setTimeout(function(){
                  var entrytp = $('#tp').val();

                  if(entrytp=='1')
                  {
                      var $newest = $('select option:contains("Showroom")');
                      $('select option:contains("Showroom")').text('Bank');
                      $newest.text('Bank');
                  }
                  else
                  {
                     var $newest = $('select option:contains("Inhouse")');
                      $('select option:contains("Inhouse")').text('Bank');
                      $newest.text('Bank');
                  }

                 }, 300);
                var payment_mode = $('#payment_mode').val();
                if(payment_mode=='3')
                {
                   $('.req').attr('style','display:inline-block;');
                }
                else if(payment_mode=='4')
                {
                   $('.req').attr('style','display:none;');
                   $('.reqc').attr('style','display:inline-block;');
                }
        })
$('#payment_banks').change(function(){
       var payment_banks = $(this).children("option:selected").attr('rel');
       $('#financer').val(payment_banks);

});
  $('#payment_by').change(function(){
     var amout = "<?=$CustomerInfo['gross_net_amount']?>";
     var eid = "<?=!empty($paymentDetails['id'])?$paymentDetails['id']:''?>";
     var payment_by = $('#payment_by').val();
     if(eid==''){
     if(payment_by!='2')
     {
        $('#amount').val(amout);
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
      $('.req').attr('style','display:none;');
      $('.reqc').attr('style','display:none;');
  }
  if(inst=='2')
  {
      $('#div_insdate').attr('style','display:block;');
      $('#bnk').attr('style','display:block;');
      $('#favo').attr('style','display:block;');
      $('#div_ins').attr('style','display:block;');
      $('.req').attr('style','display:none;');
      $('.reqc').attr('style','display:none;');
  }
  if(inst=='3')
  {
      $('#div_insdate').attr('style','display:block;');
      $('#bnk').attr('style','display:block;');
      $('#favo').attr('style','display:block;');
      $('#div_ins').attr('style','display:inline-block;');
      $('.req').attr('style','display:inline-block;');
  }
  if(inst=='4')
  {
      $('#div_insdate').attr('style','display:none;');
      $('#bnk').attr('style','display:none;');
      $('#favo').attr('style','display:none;');
      $('#div_ins').attr('style','display:block;');
      $('.req').attr('style','display:none;');
      $('.reqc').attr('style','display:inline-block;');
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
</script>

<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js">
</script>

<script>
  $('.lead_source').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
</script>
