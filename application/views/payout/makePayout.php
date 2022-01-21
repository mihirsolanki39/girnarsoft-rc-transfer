
<form id="make_payout_form" name="make_payout_form">
      <div class="modal-body" style="height: 660px; overflow-y: scroll;">
        <div class="clearfix">
          <div class="row">
              <div class="col-md-3">
                  <div class="form-group">                
                      <label for="" class="crm-label">Dealership</label>
                      <select class="form-control crm-form testselect1" name="dealer" id="dealer">
                          <option value="">Select Dealership</option>
                          <?php foreach ($dealerList as $key=>$value){ ?>
                              <option value="<?=$value['id']?>" data-favoring="<?=!empty($value['payment_favoring'])?$value['payment_favoring']:''?>"  <?php echo (!empty($CustomerInfo['dealer_id']) && ($CustomerInfo['dealer_id']==$value['id'])) ? 'selected=selected' : ''; ?>><?=$value['organization']?>
                              </option>
                          <?php } ?>
                      </select>  
                      <div class="error" id="err_dealer"></div>
                  </div></div>
                   <div class="col-md-3">
                  <div class="form-group">                
                      <label for="" class="crm-label">Loan Case Type</label>
                      <select class="form-control crm-form testselect1" name="case_type" id="case_type">
                          <option value="">Select loan case type</option>
                          <?php foreach (CASE_TYPE as $key => $case) { ?>
                              <option value="<?= $key ?>"><?= $case ?></option>
                          <?php } ?>
                      </select>              
                  </div>
                </div>
              <div class="col-md-3">
                  <input type="button" class="btn-save btn-save-new" value="Search" id="searchCases">
              </div>
          </div>
        </div>
        <div class="clearfix">
          <style>
            .table-of{height: 200px; overflow-y: scroll;}
            .text-right{text-align: right;}
          </style>
          <div class="table-of">
            <table id= "payout_table" class="table table-bordered table-striped table-hover enquiry-table mytbl mrg-B0">
                       <thead>
                          <tr>
                             <th width="5%">Select</th>
                             <th width="12%">Customer Details</th>
                             <th width="20%">Car Details</th>
                             <th width="17%">Loan Details</th>
                             <th width="15%">RC Status</th>
                             <th width="15%">Payout%</th>
                             <th width="30%">Payout Amount</th>
                          </tr>
                       </thead>
                       <tbody>
                           <tr>
                               <td colspan="7">
                                   No data found.
                               </td>
                           </tr>
                       </tbody>
            </table>

          </div>
          </div>
          
           <div class="clearfix" style="padding-top:10px">
            <?php
            $checked = "checked";
            $checked1 = "";
            $style = 'style="display:none;"';
            if ($paymentDetails['tds_type'] == 1) {
                $style = 'style="display:none;"';
                $checked = "checked";
            } else if ($paymentDetails['tds_type'] == 2) {
                $style = 'style="display:block;"';
                $checked1 = "checked";
            }
            ?>
               <input type="hidden" name="cases_selected" class="cases_selected" id="cases_selected" value="">
            <div class="row">
                 <div class="col-md-3 text-left" id="case_checked_count"></div>
                 <div class="col-md-3 pull-right text-right">Total Amount : <i class="fa fa-rupee"></i><span id="tot_amt"><?= !empty($paymentDetails['total_amount'])?$paymentDetails['total_amount']:"0"; ?></span></div>
                <input type="hidden" value="<?= $paymentDetails['amount'] ?>" name="total_amount" id="total_amount">
                <div id="err_counter" style="color:#900505;font-size:10px"></div>
            </div>
            <div class="row border-T mrg-T20 pad-T15">
                <div class="col-md-2">
                    <label>GST Reg</label></div>
                <div class="col-md-2">
                    <input type="radio" name="gst_type" id="gst2" <?= $checked1 ?>  value="2"><label class="mrg-R10" for="gst2"><span></span>Yes</label> 
                    <input type="radio" name="gst_type" id="gst1" <?= $checked ?> value="1"><label class="mrg-R10" for="gst1"><span></span>No</label>
               </div>
                
                 <div class="col-md-8 text-right">
                     Amount : <i class="fa fa-rupee"></i><span id="gst_excluded_amount"><?= !empty($paymentDetails['gst_excluded_amount'])?$paymentDetails['gst_excluded_amount']:"0"; ?></span>
                    <input placeholder="Enter Amount" onkeypress="return isNumberKey(event);" class="form-control rupee-icon" id="gst_excluded_amount_txt" type="hidden" name="gst_excluded_amount" value="<?= $paymentDetails['gst_excluded_amount'] ?>" onkeyup="addCommased(this.value, 'gst_excluded_amount_txt','1');">
                </div> 
            </div>
            <div class="row mrg-T10">
                <div class="col-md-12 text-right">
                    GST Amount : <i class="fa fa-rupee"></i><span id="tot_gst_amt"><?= !empty($paymentDetails['gst_amount'])?$paymentDetails['gst_amount']:"0"; ?></span>
                    <input placeholder="Enter Amount" onkeypress="return isNumberKey(event);" class="form-control rupee-icon" id="total_amt_text" type="hidden" name="gst_amount" value="<?= $paymentDetails['gst_amount'] ?>" onkeyup="addCommased(this.value, 'total_amt_text','1');">
                </div>               
            </div>
            <div class="row mrg-T10">
                <div class="col-md-2">
                    <label>TDS</label></div>
                <div class="col-md-2">
                    <input type="radio" name="tds_type" id="tds2" value="2" checked><label class="mrg-R10" for="tds2"><span></span>Yes</label>
                    <input type="radio" name="tds_type" id="tds1" value="1"><label class="mrg-R10" for="tds1"><span></span>No</label>
                
                </div>
                </div>
            <div class="row mrg-T10">
                
                <div class="col-md-12 text-right">
                    TDS Amount : <i class="fa fa-rupee"></i><span id="tot_tds_amt"><?= !empty($paymentDetails['tds_amount'])?$paymentDetails['tds_amount']:"0"; ?></span>
                    <input placeholder="Enter Amount" onkeypress="return isNumberKey(event);" class="form-control rupee-icon" id="tds_amount_text" type="hidden" name="tds_amount" value="<?= $paymentDetails['tds_amount'] ?>" onkeyup="addCommased(this.value, 'tds_amount_text','1');">
                </div>               
            </div>
                <div class="row mrg-T10">
                <div class="col-md-2">
                    <label>PDD Charges  (Per case)</label></div>
                <div class="col-md-2">
                    <input type="text" onblur="checkPayout()" placeholder="Enter Amount" class="form-control col-md-2 rupee-icon" name="pdd_charges" id="pdd_charges" value="<?=!empty($paymentDetails['pdd_charges'])?$paymentDetails['pdd_charges']:"250"?> " onkeyup="addCommased(this.value, 'pdd_charges','1')">
                </div>
            </div>
            <div class="row mrg-T10">                
                <div class="col-md-12 text-right">
                    PDD Charges : <i class="fa fa-rupee"></i><span id="pdd_amt"><?= !empty($paymentDetails['pdd_charge_total'])?$paymentDetails['pdd_charge_total']:"250"; ?></span>
                  <input class="form-control rupee-icon" id="pdd_amount_text" type="hidden" name="pdd_amount_total" value="<?= $paymentDetails['pdd_charge_total'] ?>" onkeyup="addCommased(this.value, 'pdd_amount_total','1');">

                </div>               
            </div>
            <div class="row mrg-T10 border-T pad-T15">
                  <div class="col-md-3 pull-right text-right" id="net_payable_amount">
                    Net Payable Amount : <i class="fa fa-rupee"></i><span id="tot_net_amt"><?= !empty($paymentDetails['amount'])?$paymentDetails['amount']:"0"; ?>
                    <input placeholder="Enter Amount" onkeypress="return isNumberKey(event);" class="form-control rupee-icon" id="net_amount_text" type="hidden" name="net_amount" value="<?= $paymentDetails['amount'] ?>" onkeyup="addCommased(this.value, 'net_amount_text','1');">
                </div>  
            </div>
        </div>
              <?php $paymentDetails['instrument_type'] =2; ?>
          <div class="clearfix">
              <div class="payment_details" style="display:none">
                  <div class="row">
                      <div class="col-md-12">
                          <h2 class="sub-title mrg-T0">Payment Details</h2>
                      </div>
                      <input type="hidden" id="totamt" name="totamt" value="<?= $paymentDetails['total_amount'] ?>">
                      <input type="hidden" id="counter" name="counter" value="<?= count($paymentDetails['car_ids']) ?>">
                      <input type="hidden" id="estimat_amt" name="estimat_amt[]" value="">


                      <div class="col-md-3" style="height:84px">
                          <div class="form-group">
                              <label for="" class="crm-label">Payment Mode*</label>
                              <select name="payment_mode" id="payment_mode" onchange="instrumentType(this)" class="form-control crm-form">
                                  <option value="">Select Payment Mode</option>
                                  <?php foreach (PAYMENT_MODE as $key => $payment){ ?>
                                  <option value="<?=$key?>" <?= (((!empty($paymentDetails['instrument_type']) && ($paymentDetails['instrument_type'] == $key)) || $key == 2) ? 'selected="selected"' : '') ?>><?=$payment?></option>
                                  <?php } ?>
                              </select>
                              <div class="d-arrow"></div>
                              <div class="error" id="err_instrumenttypes"></div>
                          </div>
                      </div>
                      <div class="col-md-3" style="height:84px">
                          <div class="form-group">
                              <label for="" class="crm-label">Amount*</label>
                              <input type="text" id="amounts" onkeypress="return isNumberKey(event)" onkeyup="addCommased(this.value,'amounts');setVal(this.value)" name="amount"  class="form-control crm-form rupee-icon" placeholder="Amount" value="" readonly="true" >
                              <div class="error" id="err_amounts"></div>
                          </div>
                      </div>                     
                      <div class="col-md-3" style="height:84px">
                          <div class="form-group">
                              <label for="" class="crm-label">Payment Date*</label>
                              <div class="input-group date" id="dp2">
                                  <input type="text" class="form-control payment_date crm-form crm-form_1" id="paydates" name="paydate" autocomplete="off" value="<?= (!empty($paymentDetails['payment_date']) ? date('d-m-Y', strtotime($paymentDetails['payment_date'])) : '') ?>"  placeholder="Payment Date">
                                  <span class="input-group-addon">
                                      <span class="">
                                          <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                      </span>
                                  </span>
                              </div>
                              <div class="error" id="err_paydate"></div>
                          </div>
                      </div>

                      <div class="col-md-3" id="ins_no" <?= ((!empty($paymentDetails['instrument_type']) && (($paymentDetails['instrument_type'] != 'cash'))) ? 'style="height: 84px;display: block;"' : 'style="height: 84px;display: none;"') ?>>
                          <div class="form-group">
                              <label for="" class="crm-label">Instrument No</label>
                              <input type="text" id="insnos" onkeypress="return blockSpecialChar(event)"  name="insno"  class="form-control crm-form" placeholder="Instrument No." value="<?= (!empty($paymentDetails['instrument_no']) ? $paymentDetails['instrument_no'] : '') ?>">
                              <div class="error" id="err_insnos"></div>
                          </div>
                      </div>

                      <div class="col-md-3" id="ins_date"  <?= ((!empty($paymentDetails['instrument_type']) && (($paymentDetails['instrument_type'] != 'cash'))) ? 'style="height:84px;display: block;"' : 'style="height:84px;display: none;"') ?> >
                          <div class="form-group">
                              <label for="" class="crm-label">Instrument Date</label>
                              <div class="input-group date" id="dp" style="width:100%">
                                  <div class="input-group date" id="dp1">
                                      <input type="text" class="form-control crm-form insdate crm-form_1" id="insdates" name="insdate" autocomplete="off" value="<?= (!empty($paymentDetails['instrument_date']) ? date('d-m-Y', strtotime($paymentDetails['instrument_date'])) : '') ?>"  placeholder="Instrument Date">
                                      <span class="input-group-addon">
                                          <span class="">
                                              <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                          </span>
                                      </span>
                                  </div>
                                  <div class="error" id="err_insdates"></div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-3"  id="bnk" <?= ((!empty($paymentDetails['instrument_type']) && (($paymentDetails['instrument_type'] != 'cash') && ($paymentDetails['instrument_type'] != 'online'))) ? 'style="height: 84px;display: block;"' : 'style="height: 84px;display: none;"') ?>>
                          <div class="form-group">
                              <label class="crm-label">Bank Name</label>
                              <select class="form-control crm-form lead_source testselect1" id="payment_banks" name="payment_bank">
                                  <option value="">Select Bank</option>
                                  <?php
                                  if (!empty($banklist)) {
                                      foreach ($banklist as $ckey => $cval) {
                                          ?>
                                      <option value="<?= $cval['bank_id'] ?>" <?= ((!empty($paymentDetails['bank_id']) && ($paymentDetails['bank_id'] == $cval['bank_name']))  || ($cval['bank_id'] == DEFAULT_BANK)) ? 'selected="selected"' : '' ?>><?= $cval['bank_name'] ?></option>
                                      <?php }
                                  }
                                  ?>
                              </select>
                              <!--<div class="d-arrow"></div>-->
                              <div class="error" id="err_bank_lists"></div>
                          </div>
                      </div>
                      <input type="hidden" name="bank_name" id="bank_name" value="" >
                      <div class="col-md-3" id="favo" <?= ((!empty($paymentDetails['instrument_type']) && (($paymentDetails['instrument_type'] != 'cash') && ($paymentDetails['instrument_type'] != 'online'))) ? 'style="height: 84px;display: block;"' : 'style="height: 84px;display: none;"') ?>>
                          <div class="form-group">
                              <label class="crm-label">Favouring</label>
                              <input type="text" id="favourings"  onkeypress="return blockSpecialChar(event)" name="favouring"  class="form-control crm-form" placeholder="Favouring" value="<?= (!empty($paymentDetails['favouring']) ? $paymentDetails['favouring']:"") ?>" >
                              <div class="error" id="err_favourings"></div>
                          </div>
                      </div>
                      <div class="col-md-3"  style="height: 84px">
                          <div class="form-group">
                              <label class="crm-label">Remark</label>
                              <input type="text" id="remarks" name="remark"  class="form-control crm-form" placeholder="Remark" value="<?= (!empty($paymentDetails['remark']) ? $paymentDetails['remark'] : '') ?>">
                              <div class="error" id="err_remark"></div>
                          </div>
                      </div>
                  </div>
              
              <input type="hidden" name="edit_id" value="<?= (!empty($paymentDetails['id']) ? $paymentDetails['id'] : '') ?>" id="edit_id">
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" onclick="saveEditData()">Pay</button>
          </div>
        </div>
        </div>
          
 </form><script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script> 
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script>
  $('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
  </script>
 <script>
    $(document).ready(function(){
         var bank_name =  $("#payment_banks option:selected").text();  
         $("#bank_name").val(bank_name);
       $("#payment_banks").change(function(){
        var bank_name =  $("#payment_banks option:selected").text();  
         $("#bank_name").val(bank_name);
       });
       $("input[name='gst_type']").click(function(){
          if($("input[name='gst_type']:checked").val() == 2){
              $("#gst_amount").css("display","block");
              checkPayout();
          }else{
             $("#gst_amount").css("display","none"); 
             checkPayout();
          }  
         // checkPayout();
       }) 
       $("input[name='tds_type']").click(function(){
          if($("input[name='tds_type']:checked").val() == 2){
              $("#tds_amount").css("display","block");
          }else{
             $("#tds_amount").css("display","none");              
          }  
         checkPayout();
       }) 
       $("#tds_amount_text").blur(function(){
          checkPayout();
       })
       $("#searchCases").click(function(){
           var favoring = $("#dealer option:selected").data('favoring');
               $("#favourings").val(favoring);
           
           var dealer_id = $("#dealer option:selected").val();
           var case_type_id = $("#case_type option:selected").val();
           var error  = 0;
           $(".error").html("");    
           if(dealer_id == ''){
                $("#err_dealer").html("Please select Dealership");
                error++;
           }
           if(error > 0){
                return false;
           } else{
                getPendingPayoutCases(dealer_id,case_type_id); 
           }
       })
    });
    
   function saveEditData()
    {
      var instrumenttype      = $.trim($('#payment_mode').val());
      var amount              = $.trim($('#amounts').val());
      var paydates            = $.trim($('#paydates').val());
      var insno               = $.trim($('#instrument_no').val());
      var insdate             = $.trim($('#insdates').val());
      var payment_bank        = $.trim($('#payment_banks').val());
      var favouring           = $.trim($('#favourings').val());
      var remark             = $.trim($('#remark').val());
      var cust             = $.trim($('#cust').val());
//alert(cust);
    
      var error               = 0;
      $(".error").html("");    
      if(instrumenttype == '0' || instrumenttype == ''){
           $("#err_instrumenttypes").html("Please select Payment mode.");
           error++;
      }
      if(amount == ''){
            $("#err_amounts").html("Please enter amount.");
            error++;
      }
      if(paydates == ''){
            $("#err_paydate").html("Please select payment date.");
            error++;
      }
      
      if(error > 0){
        return false;
      } else{
        $(".loaderClas").show();
         var formData=$('#make_payout_form').serialize();
        $.ajax({
          url: base_url+"Payout/save_payment",
          type: 'post',
          dataType: 'json',
          data:formData,
          //data:{instrumenttype:instrumenttype,amount:amount,insno:insno,insdate:insdate,payment_bank:payment_bank,favouring:favouring,paydates:paydates,workshop_id:workshop_id,edit_id:edit_id,remark:remark},
          success: function(response) 
          {
            $(".loaderClas").hide();
            setTimeout(function(){ location.href = base_url+"loanPayout"; }, 300);
          }   
        });
      }

    }
   
    
 </script>