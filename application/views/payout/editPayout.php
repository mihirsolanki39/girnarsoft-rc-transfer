<form id="edit_payout_form" name="edit_payout_form">
    <div class="modal-body" style="height: 660px; overflow-y: scroll;">
        <div class="clearfix">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">                
                        <label for="" class="crm-label">Dealership Type</label>
                        <select class="form-control crm-form testselect1" name="org" id="org">
                            <option value="">Select Dealerships</option>
                            <?php foreach ($dealerList as $key => $value) { 
                             if($value['id'] ==  $paymentDetails['dealer_id']){?>
                                <option value="<?= $value['id'] ?>" data-favoring="<?=!empty($value['payment_favoring'])?$value['payment_favoring']:''?>"  <?php echo (!empty($paymentDetails['dealer_id']) && ($paymentDetails['dealer_id'] == $value['id'])) ? 'selected=selected' : ''; ?>><?= $value['organization'] ?>
                                </option>
                             <?php }} ?>
                        </select>  
                        <input type="hidden" class="form-control" id="dealer_name" name="dealer_name" value="<?= $paymentDetails['dealer_id'] ?>">
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
        <input type="hidden" name="cases_selected" class="cases_selected" id="cases_selected" value="">
        <div class="clearfix" style="padding-top:10px">
            <div class="row">
                  <div class="col-md-3 text-left" id="case_checked_count"></div>
                  <div class="col-md-3 pull-right text-right">Total Amount : <i class="fa fa-rupee"></i><span id="tot_amt"><?= indian_currency_form($paymentDetails['total_amount']) ?></span></div>
                <input type="hidden" value="<?= $paymentDetails['total_amount'] ?>" name="total_amount" id="total_amount">
                <div id="err_counter" style="color:#900505;font-size:10px"></div>
            </div>
            <div class="row border-T mrg-T20 pad-T15">
                <div class="col-md-2">
                    <label>GST Reg</label></div>
                <div class="col-md-2">
                    <input type="radio" name="gst_type" id="gst2" <?= (!empty($paymentDetails['gst_type']) && $paymentDetails['gst_type'] == 2)?"checked":""  ?>  value="2"><label class="mrg-R10" for="gst2"><span></span>Yes</label> 
                    <input type="radio" name="gst_type" id="gst1" <?= (!empty($paymentDetails['gst_type']) && $paymentDetails['gst_type'] ==1)?"checked":""  ?> value="1"><label class="mrg-R10" for="gst1"><span></span>No</label>
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
                    <input type="radio" name="tds_type" id="tds2" <?= (!empty($paymentDetails['tds_type']) && $paymentDetails['tds_type'] == 2)?"checked":""  ?>   value="2"><label class="mrg-R10" for="tds2"><span></span>Yes</label>
                    <input type="radio" name="tds_type" id="tds1" <?= (!empty($paymentDetails['tds_type']) && $paymentDetails['tds_type'] == 1)?"checked":""  ?>  value="1"><label class="mrg-R10" for="tds1"><span></span>No</label>
                
                </div>
                </div>
            

            <div class="row mrg-T10">
                
                <div class="col-md-12 text-right">
                    TDS Amount : <i class="fa fa-rupee"></i><span id="tot_tds_amt"><?= !empty($paymentDetails['tds_amount'])?$paymentDetails['tds_amount']:"0"; ?></span>
                    <input placeholder="Enter Amount"  onkeypress="return isNumberKey(event);" class="form-control rupee-icon" id="tds_amount_text" type="hidden" name="tds_amount" value="<?= $paymentDetails['tds_amount'] ?>" onkeyup="addCommased(this.value, 'tds_amount_text','1');">
                </div>               
            </div>
            <div class="row mrg-T10">
                <div class="col-md-2">
                    <label>PDD Charges</label></div>
                <div class="col-md-2">
                    <input type="text" onblur="checkPayout()" placeholder="Enter Amount" class="form-control col-md-2" name="pdd_charges" id="pdd_charges" value="<?=!empty($paymentDetails['pdd_charges'])?$paymentDetails['pdd_charges']:"250"?> " onkeyup="addCommased(this.value, 'pdd_charges','1')">
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
        <div class="clearfix" style="padding-top:10px">
            <div class="payment_details">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="sub-title mrg-T0">Payment Details</h2>
                    </div>
                    <input type="hidden" id="dealer" name="dealer" value="<?= $paymentDetails['dealer_id'] ?>">

                    <div class="col-md-3" style="height:84px">
                        <div class="form-group">
                            <label for="" class="crm-label">Payment Mode*</label>
                            <select name="payment_mode" id="payment_mode" onchange="instrumentType(this)" class="form-control crm-form">
                                <option value="">Select Instrument</option>
                                <?php foreach (PAYMENT_MODE as $key => $payment) { ?>
                                    <option value="<?= $key ?>" <?= ((!empty($paymentDetails['payment_mode']) && ($paymentDetails['payment_mode'] == $key)) ? 'selected="selected"' : '') ?>><?= $payment ?></option>
                                <?php } ?>
                            </select>
                            <div class="d-arrow"></div>
                            <div class="error" id="err_instrumenttypes"></div>
                        </div>
                    </div>
                    <div class="col-md-3" style="height:84px">
                        <div class="form-group">
                            <label for="" class="crm-label">Amount*</label>
                            <input type="text" id="amounts" onkeypress="return isNumberKey(event)" onkeyup="addCommased(this.value, 'amounts');setVal(this.value)" name="amount"  class="form-control crm-form rupee-icon" placeholder="Amount" value="<?= !empty($paymentDetails['amount']) ? $paymentDetails['amount'] : "" ?>" readonly="true" >
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

                    <div class="col-md-3" id="ins_no" <?= ((!empty($paymentDetails['payment_mode']) && (($paymentDetails['payment_mode'] != '1'))) ? 'style="height: 84px;display: block;"' : 'style="height: 84px;display: none;"') ?>>
                        <div class="form-group">
                            <label for="" class="crm-label">Instrument No</label>
                            <input type="text" id="insnos" onkeypress="return blockSpecialChar(event)"  name="insno"  class="form-control crm-form" placeholder="Instrument No." value="<?= (!empty($paymentDetails['instrument_no']) ? $paymentDetails['instrument_no'] : '') ?>">
                            <div class="error" id="err_insnos"></div>
                        </div>
                    </div>

                    <div class="col-md-3" id="ins_date"  <?= ((!empty($paymentDetails['payment_mode']) && (($paymentDetails['payment_mode'] != '1'))) ? 'style="height:84px;display: block;"' : 'style="height:84px;display: none;"') ?> >
                        <div class="form-group">
                            <label for="" class="crm-label">Instrument Date</label>
                            <div class="input-group date" id="dp" style="width:100%">
                                <div class="input-group date" id="dp1">
                                    <?php
                                    if (!empty($paymentDetails['instrument_date']) && $paymentDetails['instrument_date'] != "0000-00-00") {
                                        $instrument_date = date('d-m-Y', strtotime($paymentDetails['instrument_date']));
                                    } else {
                                        $instrument_date = "";
                                    }
                                    ?>
                                    <input type="text" class="form-control crm-form insdate crm-form_1" id="insdates" name="insdate" autocomplete="off" value="<?= $instrument_date ?>"  placeholder="Instrument Date">
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
                    <div class="col-md-3"  id="bnk" <?= ((!empty($paymentDetails['payment_mode']) && (($paymentDetails['payment_mode'] != '1') && ($paymentDetails['instrument_type'] != 'online'))) ? 'style="height: 84px;display: block;"' : 'style="height: 84px;display: none;"') ?>>
                        <div class="form-group">
                            <label class="crm-label">Bank Name</label>
                            <select class="form-control crm-form lead_source testselect1" id="payment_banks" name="payment_bank">
                                <option value="">Select Bank</option>
                                <?php
                                if (!empty($banklist)) {
                                    foreach ($banklist as $ckey => $cval) {
                                        if(!empty($paymentDetails['bank_id'])){
                                        ?>
                                        <option value="<?= $cval['bank_id'] ?>" <?= ((!empty($paymentDetails['bank_id']) && ($paymentDetails['bank_id'] == $cval['bank_id'])) ? 'selected="selected"' : '') ?>><?= $cval['bank_name'] ?></option>
                                        <?php
                                        }else{?>
                                        <option value="<?= $cval['bank_id'] ?>" <?= (!empty($cval['bank_id']) && ($cval['bank_id'] == DEFAULT_BANK))? 'selected="selected"' : ''; ?>><?= $cval['bank_name'] ?></option>
                                     <?php }
                                    }
                                }
                                ?>
                            </select>
                            <!--<div class="d-arrow"></div>-->
                            <div class="error" id="err_bank_lists"></div>
                        </div>
                    </div>
                    <input type="hidden" name="bank_name" id="bank_name" value="<?= $paymentDetails['bank_name'] ?>" >
                    <div class="col-md-3" id="favo" <?= ((!empty($paymentDetails['payment_mode']) && (($paymentDetails['payment_mode'] != '1') && ($paymentDetails['payment_mode'] != 'online'))) ? 'style="height: 84px;display: block;"' : 'style="height: 84px;display: none;"') ?>>
                        <div class="form-group">
                            <label class="crm-label">Favouring</label>
                            <input type="text" id="favourings"  onkeypress="return blockSpecialChar(event)" name="favouring"  class="form-control crm-form" placeholder="Favouring" value="<?= (!empty($paymentDetails['favouring_to']) ? $paymentDetails['favouring_to'] : '') ?>" >
                            <div class="error" id="err_favourings"></div>
                        </div>
                    </div>
                    <div class="col-md-3"  style="height: 84px">
                        <div class="form-group">
                            <label class="crm-label">Remark</label>
                            <input type="text" id="remarks" name="remark"  class="form-control crm-form" placeholder="Remark" value="<?= (!empty($paymentDetails['pay_remark']) ? $paymentDetails['pay_remark'] : '') ?>">
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
    </div>
</form><script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script> 
<link rel="stylesheet" href="<?= base_url() ?>assets/css/sumoselect.css">
<script src="<?= base_url() ?>assets/js/sumoselect.js"></script>
<script>
    $('.testselect1').SumoSelect({triggerChangeCombined: true, search: true, searchText: 'Search here.'});
</script>
<script>
    var favouring_to = "<?=$paymentDetails['favouring_to']?>"; 
    $('document').ready(function(){
       var gst_excluded_amount = $("#gst_excluded_amount").text();
       gst_excluded_amount = convertToIndianCurrency(gst_excluded_amount,'gst_excluded_amount','',1);
       $("#gst_excluded_amount").html(gst_excluded_amount);       
       
       var tot_gst_amt = $("#tot_gst_amt").text();
       tot_gst_amt = convertToIndianCurrency(tot_gst_amt,'tot_gst_amt','',1);
       $("#tot_gst_amt").html(tot_gst_amt);
        var bank_name =  $("#payment_banks option:selected").text();  
         $("#bank_name").val(bank_name);
        var favoring = $("#org option:selected").data('favoring');
        if(favouring_to == '')
               $("#favourings").val(favoring);
    })
       $("input[name='gst_type']").click(function(){
          if($("input[name='gst_type']:checked").val() == 2){
              $("#gst_amount").css("display","block");
              checkPayout();
          }else{
             $("#gst_amount").css("display","none"); 
             checkPayout();
          }  
       }) 
     $("input[name='tds_type']").click(function(){
          if($("input[name='tds_type']:checked").val() == 2){
              $("#tds_amount").css("display","block");
              checkPayout();
          }else{
             $("#tds_amount").css("display","none"); 
             checkPayout();
          }  
         // checkPayout();
       }) 
    $("#searchCases").click(function(){
          var favoring = $("#org option:selected").data('favoring');
          if(favouring_to == '')
               $("#favourings").val(favoring);
           
           var dealer_id = $("#dealer").val();
           var case_type_id = $("#case_type option:selected").val();
           var edit_id = $("#edit_id").val();
           var error  = 0;
           $(".error").html("");    
           if(dealer_id == ''){
                $("#err_dealer").html("Please select Dealership");
                error++;
           }
           if(error > 0){
                return false;
           } else{
                getPendingPayoutCases(dealer_id,case_type_id,edit_id); 
           }
       })
        $("#tds_amount_text").blur(function(){
          checkPayout();
       })
    $("#payment_banks").change(function () {
        var payment_bank_name = $('#payment_banks option:selected').text();
        $("#bank_name").val(payment_bank_name);
    });
    function instrumentType(e)
    {
        var id = $(e).attr('id');
        var insType = $('#' + id).val();
        var ids = id.split('_');

        if (insType == '1')
        {
            $('#ins_no').hide();
            $('#ins_date').hide();
            $('#bnk').hide();
            $('#favo').hide();
            $('#insnos').val('');
            $('#insdates').val('');
            $('#payment_banks').val('');
            $('#favourings').val('');
        }

        if (insType == '2')
        {
            $('#ins_no').show();
            $('#ins_date').show();
            $('#bnk').show();
            $('#favo').show();
        }

        if (insType == '3')
        {
            $('#ins_no').show();
            $('#ins_date').show();
            $('#bnk').hide();
            $('#favo').show();
            $('#payment_banks').val('');
        }

        if (insType == '4')
        {
            $('#ins_no').show();
            $('#ins_date').hide();
            $('#bnk').hide();
            $('#favo').hide();
            $('#insdates').val('');
            $('#payment_banks').val('');
            $('#favourings').val('');
        }
    }
    function saveEditData()
    {
        var instrumenttype = $.trim($('#payment_mode').val());
        var amount = $.trim($('#amounts').val());
        var paydates = $.trim($('#paydates').val());
        var insno = $.trim($('#instrument_no').val());
        var insdate = $.trim($('#insdates').val());
        var payment_bank = $.trim($('#payment_banks').val());
        var favouring = $.trim($('#favourings').val());
        var remark = $.trim($('#remarks').val());

        var error = 0;
        $(".error").html("");
        if (instrumenttype == '0' || instrumenttype == '') {
            $("#err_instrumenttypes").html("Please select Payment mode.");
            error++;
        }
        if (amount == '') {
            $("#err_amounts").html("Please enter amount.");
            error++;
        }
        if (paydates == '') {
            $("#err_paydate").html("Please select payment date.");
            error++;
        }

        if (error > 0) {
            return false;
        } else {
            $(".loaderClas").show();
            var formData = $('#edit_payout_form').serialize();
            $.ajax({
                url: base_url + "Payout/save_payment",
                type: 'post',
                dataType: 'json',
                data: formData,
                //data:{instrumenttype:instrumenttype,amount:amount,insno:insno,insdate:insdate,payment_bank:payment_bank,favouring:favouring,paydates:paydates,workshop_id:workshop_id,edit_id:edit_id,remark:remark},
                success: function (response)
                {
                    $(".loaderClas").hide();
                    setTimeout(function () {
                        location.href = base_url + "loanPayout/2";
                    }, 300);
                }
            });
        }

    }
   </script>