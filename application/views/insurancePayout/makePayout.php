<style>
    .process-step .btn:focus{outline:none}
    .process{display:table;width:70%;position:relative; margin-bottom: 20px}
    .process-row{display:table-row}
    .process-step button[disabled]{opacity:1 !important;filter: alpha(opacity=100) !important}
    .process-row:before {top: 21px; bottom: 0; position: absolute; content: " "; width: 15%;height: 2px;border-bottom: 2px dashed #a0a0a0;left: 28%;}
    .process-step{display:table-cell;text-align:left;position:relative; padding-left: 20px;}
    .process-step p{margin-top:4px}
    .btn-circle{width:40px;height:40px;text-align:center;font-size:16px;border-radius:50%}
    .process-step .btn:focus {border-radius:50%;background-color: #e86335 !important; border: none; padding:8px; text-align: center;color: #fff !important;}
    .process-step .text-heading{font-size: 20px;display: inline-block; vertical-align: sub; margin-left: 10px}
    .process-step .btn { padding: 8px;background-color: #ffffff;color: #ec6140; border: 1px solid #ec6140;}
    #payout-total .bg-box{background: #fff; margin-top: 60px;padding: 15px;}
    #payout-total .bg-box table{border:none;}
    #payout-total .bg-box .table-bordered>tbody>tr>td{border:none; padding: 10px 0px;}
    #payout-total .bg-box .table-bordered>tbody>tr>td .cases{font-size: 18px; color: #000000; opacity: 0.87; padding: 0px}
    #payout-total .bg-box .table-bordered>tbody>tr>td .cases1{font-size: 18px; color: #000000; opacity: 0.87; text-align: right}
    #payout-total .table-hover>tbody>tr:nth-child(even):hover, #payout-total .table-hover>tbody>tr:nth-child(odd):hover {background-color: #ffffff !important;}
    .mrg-B20 { margin-bottom: 20px !important;}
    .spacers-t{border-top:1px solid #ddd; padding: 10px 0px}
    .netpayout-t td{color:#000000;}
    .select-color { color: #e46536;}
    #payoutTable .arrow-details{display: block; margin-bottom: 10px; text-transform: none; padding: 0px 7px 2px;}
</style>
<style>
  .dot-sep { content: ""; height: 4px; width: 4px; background: rgba(0,0,0,0.3); border-radius: 15px; display: inline-block; margin: 3px 7px;}
</style>
<style type="text/css">
           .loaderoverlay{position: fixed;left: 0;right: 0;top: 0;bottom: 0; background: rgba(0,0,0,0.5); z-index: 999;}
           .loaderClas{position: fixed; left:0; top: 0;right: 0; bottom: 0; margin:auto;z-index: 9999;}
</style>
     <div class="loaderClas" style="display:none;"><img class="resultloader" src="<?php echo base_url()?>/assets/images/loading.gif" style="position: absolute;left: 0;right: 0;text-align: center;top: 0;bottom: 0;margin: auto;z-index: 9999;"></div>
      <div class="loaderoverlay loaderClas"></div>
    
<div class="container-fluid pad-T20 bg-container-new mrg-T70" id="maincontainer">
   <form id="make_payout_form" name="make_payout_form">
    <div class="row">
        <div id="payment_stock_div" class="">
            <div class="col-md-9">
                <div class="row">
                    <div class="process">
                        <div class="process-row nav nav-tabs">
                            <div class="process-step">
                                <button type="button" class="btn btn-info btn-circle case_Details" data-toggle="tab" href="#menu1">1</button>
                                <p class="text-heading select-color">Select Case</p>
                            </div>
                            <div class="process-step">
                                <button type="button" class="btn btn-default btn-circle pay_Details" data-toggle="tab" href="<?= (!empty($paymentDetails['id']) ? "#menu2" : '#') ?>">2</button>
                                <p class="text-heading">Payments Details</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="menu1" class="tab-pane fade active in">
                            <div class="col-md-12">
                                <div class="cont-spc pad-all-20" id="buyer-lead">
                                     <input type="hidden" name="edit_id" value="<?= (!empty($paymentDetails['id']) ? $paymentDetails['id'] : '') ?>" id="edit_id">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="crm-label">Dealership name</label>
                                                <select class="form-control testselect1" name="makedealerSearch" id="makedealerSearch">
                                                    <option value="0">Select Dealership</option>
                                                    <?php
                                                    foreach ($dealerList as $key => $value) {
                                                        if ($value['id'] == $paymentDetails['dealer_id']) {
                                                            ?>
                                                            <option value="<?= $value['id'] ?>" data-favoring="<?= !empty($value['payment_favoring']) ? $value['payment_favoring'] : '' ?>"  <?php echo (!empty($paymentDetails['dealer_id']) && ($paymentDetails['dealer_id'] == $value['id'])) ? 'selected=selected':''; ?>><?= $value['organization'] ?>
                                                            </option>
                                                        <?php } else { ?>
                                                            <option value="<?= $value['id'] ?>" data-favoring="<?= !empty($value['payment_favoring']) ? $value['payment_favoring'] : '' ?>"><?= $value['organization'] ?>
                                                            </option>
                                                      <?php }} ?>
                                                </select>
                                            </div>
                                            <div class="searchcases" style="display:none;">
                                            <div class="col-md-3">
                                                <label>Search</label>
                                                <input class="form-control" placeholder="Customer/Reg No./Policy No." id="search" name="search" value="">
                                            </div> 
                                            <div class="col-md-5 pad-L10 pad-R10">
                                                <label class="crm-label">Date</label>
                                                <div class="row">
                                                    <div class="col-md-4 pad-R0 mrg-R0">
                                                        <div class="select-box">Issue Date <span class="d-arrow d-arrow-new"></span></div>
                                                    </div>
                                                    <div class="col-md-4 new_lead pad-all-0">
                                                        <input type="hidden" name="searchdate" id="searchdate" value=""> 
                                                        <div class="date input-append demo" id="reservation_to" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                                            <input type="text" name="createStartDate" id="createStartDate" class="form-control crm-form add-on icon-cal1 new_input" placeholder="From"> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 new_lead pad-all-0">
                                                        <div class="date input-append demo" id="reservation_from" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                                            <input type="text" name="createEndDate" id="createEndDate" class="form-control crm-form add-on icon-cal1 new_input" placeholder="To"> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                </div>
                                <div class="col-lg-12 col-md-12" id="payoutTable">
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table id= "payout_table" class="table table-bordered table-striped table-hover enquiry-table mytbl border-T mrg-B20 font-13">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">Select</th>
                                                        <th width="12%">Customer Details</th>
                                                        <th width="15%">Car Details</th>
                                                        <th width="15%">New Policy Details</th>
                                                        <th width="15%">Policy Source</th>
                                                        <th width="13%">Overdue</th>
                                                        <th width="10%">Payout %</th>
                                                        <th width="10%">Payout Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody  id="casedetails"> 
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="menu2" class="tab-pane fade">
                            <div class="col-md-12 mrg-B40">
                                <div class="white-section">
                                     <div class="row">
                               <div class="col-md-12">
                                 <h2 class="sub-title mrg-T0">Payments Details</h2>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                     <label for="" class="crm-label">Payment Mode*</label>
                                     <select name="payment_mode" id="payment_mode" onchange="instrumentType(this)" class="form-control crm-form">
                                         <option value="">Select Payment Mode</option>
                                         <?php foreach (PAYMENT_MODE as $key => $payment) { ?>
                                             <option value="<?= $key ?>" <?= (((!empty($paymentDetails['payment_mode']) && ($paymentDetails['payment_mode'] == $key)) || ($key == 2 && empty($paymentDetails['payment_mode']))) ? 'selected="selected"' : '') ?>><?= $payment ?></option>
                                         <?php } ?>
                                     </select>
                                     <div class="d-arrow"></div>
                                     <div class="error" id="err_instrumenttypes"></div>
                                  </div>
                               </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                     <label for="" class="crm-label">Amount*</label>
                                     <input type="text" id="amounts" onkeypress="return isNumberKey(event)" onkeyup="addCommased(this.value,'amounts');setVal(this.value)" name="amount"  class="form-control crm-form rupee-icon" placeholder="Amount" value="<?= !empty($paymentDetails['amount']) ? $paymentDetails['amount'] : "" ?>" readonly="true" >
                                     <div class="error" id="err_amounts"></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
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
                                <div class="col-md-6">
                                    <div class="form-group" id="ins_no" <?= (((!empty($paymentDetails['instrument_type']) && (($paymentDetails['instrument_type'] != 'cash'))) || empty($paymentDetails)) ? 'style="height: 84px;display: block;"' : 'style="height: 84px;display: none;"') ?>>
                                     <label for="" class="crm-label">Instrument Number</label>
                                      <input type="text" id="insnos" onkeypress="return blockSpecialChar(event)"  name="insno"  class="form-control crm-form" placeholder="Instrument No." value="<?= (!empty($paymentDetails['instrument_no']) ? $paymentDetails['instrument_no'] : '') ?>">
                                      <div class="error" id="err_insnos"></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6" id="ins_date"  <?= (((!empty($paymentDetails['instrument_type']) && (($paymentDetails['instrument_type'] != 'cash')))|| empty($paymentDetails)) ? 'style="height:84px;display: block;"' : 'style="height:84px;display: none;"') ?> >
                                  <div class="form-group">
                                     <label for="" class="crm-label">Instument Date</label>
                                     <div class="input-group date" id="dp" style="width:100%">
                                         <div class="input-group date" id="dp1">
                                             <input type="text" class="form-control crm-form insdate crm-form_1" id="insdates" name="insdate" autocomplete="off" value="<?= ((!empty($paymentDetails['instrument_date']) && $paymentDetails['instrument_date'] != "0000-00-00") ? date('d-m-Y', strtotime($paymentDetails['instrument_date'])) : '') ?>"  placeholder="Instrument Date">
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
                                <div class="col-md-6" id="bnk" <?= (((!empty($paymentDetails['instrument_type']) && (($paymentDetails['instrument_type'] != 'cash') && ($paymentDetails['instrument_type'] != 'online'))) || empty($paymentDetails)) ? 'style="height: 84px;display: block;"' : 'style="height: 84px;display: none;"') ?>>
                                    <div class="form-group">
                                        <label for="" class="crm-label">Bank</label>
                                        <select class="form-control crm-form lead_source testselect1" id="payment_banks" name="payment_bank">
                                            <!-- <option value="">Select Bank</option> -->
                                            <?php if (!empty($banklist)) {
                                                 $selected_bank = "";
                                                foreach ($banklist as $ckey => $cval) {
                                                    if(empty($selected_bank) && !empty($paymentDetails['bank_id']) && ($paymentDetails['bank_id'] == $cval['bank_id'])){
                                                        $selected_bank = $paymentDetails['bank_id'];
                                                    }
                                                    if(empty($selected_bank) && empty($paymentDetails['bank_id']) && $cval['bank_id'] == DEFAULT_BANK){
                                                        $selected_bank = DEFAULT_BANK;
                                                    }
                                                    ?>
                                                    <option value="<?= $cval['bank_id'] ?>" <?= ((!empty($selected_bank) && ($selected_bank == $cval['bank_id']))) ? 'selected="selected"' : '' ?>><?= $cval['bank_name'] ?></option>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="error" id="err_bank_lists"></div>
                                    </div>
                                </div>
                                <input type="hidden" name="bank_name" id="bank_name" value="" >
                                <div class="col-md-6" id="favo" <?= (((!empty($paymentDetails['instrument_type']) && (($paymentDetails['instrument_type'] != 'cash') && ($paymentDetails['instrument_type'] != 'online'))) || empty($paymentDetails)) ? 'style="height: 84px;display: block;"' : 'style="height: 84px;display: none;"') ?>>
                                  <div class="form-group">
                                     <label for="" class="crm-label">Favouring</label>
                                     <input type="text" id="favourings"  onkeypress="return blockSpecialChar(event)" name="favouring"  class="form-control crm-form" placeholder="Favouring" value="<?= (!empty($paymentDetails['favouring_to']) ? $paymentDetails['favouring_to']:"") ?>" >
                                     <div class="error" id="err_favourings"></div>
                                  </div>
                               </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                     <label for="" class="crm-label">Remark</label>
                                     <input type="text" id="remarks" name="remark"  class="form-control crm-form" placeholder="Remark" value="<?= (!empty($paymentDetails['pay_remark']) ? $paymentDetails['pay_remark'] : '') ?>">
                                     <div class="error" id="err_remark"></div>
                                    </div>
                                </div>
                                <div id="snackbar" style="bottom:120px !important;"></div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-4">
                                            <button type="button" class="btn-continue width100" onclick="saveEditData()">SAVE DETAILS</button>
                                        </div>
                                    </div>
                                </div>
                             </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
              
          
            <?php //echo "<pre>";print_r($paymentDetails);die;?>
            <div class="col-md-3 pad-L5" id="payout-total" style="right:0px">
                <div class="">
                    <div class="bg-box">
                        <table class="table table-bordered table-striped table-hover enquiry-table mytbl border-T font-13">
                            <tbody>
                                <tr>
                                    <input type="hidden" name="cases_selected" class="cases_selected" id="cases_selected" value="">
                                    <td style="width:60%"><div class="cases" id="case_checked_count">Cases (0)</div></td>
                                    <td style="width:40%"><div class="cases1"></div></td>
                                </tr>
                                <tr>
                                    <td>Total Amount</td>
                                    <td style="width:40%"><div class="text-right tot_amt"><i class="fa fa-rupee"  style="padding-right:2px;"></i><span id="tot_amt"><?= !empty($paymentDetails['total_amount'])?$paymentDetails['total_amount']:"0" ?></span></div>
                                       <input type="hidden" value="<?= !empty($paymentDetails['total_amount'])?$paymentDetails['total_amount']:"0" ?>" name="total_amount" id="total_amount">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Due Amount</td>
                                    <td style="width:40%"><div class="text-right"><i class="fa fa-rupee"  style="padding-right:2px;"></i><span id="total_due_amt"><?= !empty($paymentDetails['total_due_amt'])?indian_currency_form($paymentDetails['total_due_amt']):"0" ?></span></div>
                                       <input type="hidden" value="<?= !empty($paymentDetails['total_due_amt'])?$paymentDetails['total_due_amt']:"0" ?>" name="total_due_amt" id="total_due_amt_text">
                                    </td>
                                </tr>
                             <tr class="spacers-t netpayout-t">
                                 <td>Net Amount</td>
                                 <td><div class="text-right"> <i class="fa fa-rupee" style="padding-right:2px;"></i><span id="tot_net_amt"><?= !empty($paymentDetails['amount'])?$paymentDetails['amount']:"0"; ?></span></div>
                                   <input placeholder="Enter Amount" onkeypress="return isNumberKey(event);" class="form-control rupee-icon" id="net_amount_text" type="hidden" name="net_amount" value="<?= !empty($paymentDetails['amount'])?$paymentDetails['amount']:"0" ?>" onkeyup="addCommased(this.value, 'net_amount_text','1');">
                                 </td>
                             </tr>                             
                                <tr>
                                   <td colspan="2"><button type="button" class="btn-continue" id="deliveryDetailsButton" data-toggle="tab" href="#<?=!empty($paymentDetails)?'menu2':''?>">PROCEED</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
     
   </form>

</div>
<script type="text/javascript">
     $('.loaderClas').attr('style','display:none;');
    $(document).ready(function () {
        var elementPosition = $('#payout-total').offset();
        $(window).scroll(function () {
            if ($(window).scrollTop() > elementPosition.top) {
                $('#payout-total').css('position', 'fixed').css('top', '0');
            } else {
                $('#payout-total').css('position', 'static');
            }
        });
    });
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script> 
<link rel="stylesheet" href="<?= base_url() ?>assets/css/sumoselect.css">
<script src="<?= base_url() ?>assets/js/sumoselect.js"></script>
<script src="<?php echo base_url('assets/admin_assets/js/insurancepayoutlisting.js'); ?>"></script>
<script>
    $('.testselect1').SumoSelect({triggerChangeCombined: true, search: true, searchText: 'Search here.'});
</script>

<script type="text/javascript">
     var favouring_to = "<?=!empty($paymentDetails['favouring_to'])?$paymentDetails['favouring_to']:""?>";
    $('#deliveryDetailsButton').click(function () {
        $('.case_Details').next('.text-heading').removeClass('select-color');
        $('.pay_Details').next('.text-heading').addClass('select-color');
        var cases_selected = $("#cases_selected").val();
        if($("#total_amount").val() != 0 && cases_selected > 0){
           $("#deliveryDetailsButton").css("display","none");
        }         
         if (cases_selected >= 1){
             $('#deliveryDetailsButton').attr('href', '#menu2');
         }else{
              $('#deliveryDetailsButton').attr('href','#');
         }
    });
    $(".case_Details").click(function(){
        $('.pay_Details').next('.text-heading').removeClass('select-color');
        $('.case_Details').next('.text-heading').addClass('select-color');
        $("#deliveryDetailsButton").css("display","block");
        
    })
    $(".pay_Details").click(function(){
         var edit_id = $("#edit_id").val();
         if(edit_id != ""){
            $('.pay_Details').next('.text-heading').addClass('select-color');
            $('.case_Details').next('.text-heading').removeClass('select-color');       
            $("#deliveryDetailsButton").css("display","none");
        }
    })
        var date = new Date();
        var d = new Date();        
        d.setDate(date.getDate());
        $('#paydates').datepicker({
            format: 'dd-mm-yyyy',
            endDate: d,
            autoclose: true,
            todayHighlight: true   
          });

          $('#insdates').datepicker({
              format: 'dd-mm-yyyy',
              autoclose: true,
              todayHighlight: true   
          });
        $('.icon-cal1').datepicker('destroy');
//        $("#createStartDate").datepicker({
//            format: 'dd-mm-yyyy',
//            endDate: d,
//            autoclose: true,
//        }).on('changeDate', function (selected) {
//            var startDate = new Date(selected.date.valueOf());
//            $('#createEndDate').datepicker({
//            format: 'dd-mm-yyyy',
//            startDate:startDate,
//            endDate: d,
//            autoclose: true,
//        }).on('changeDate', function (selected) { 
//            var formDataSearch = $('#make_payout_form').serialize();
//             confirmBox(formDataSearch);
//        }).on('clearDate', function (selected) {
//            $('#createEndDate').datepicker('setStartDate', null);
//        });            
//        });
    $(document).ready(function () { 
                var dates = $('#createStartDate').val();
                $("#createStartDate").datepicker({
                    format: 'dd-mm-yyyy',
                    endDate: d,
                    autoclose: true,
                }).on('changeDate', function (selected) {
                    var startDate = new Date(selected.date.valueOf());
                    $('#createEndDate').datepicker('setStartDate', startDate);
                }).on('clearDate', function (selected) {
                    $('#createEndDate').datepicker('setStartDate', null);
                });
                $("#createEndDate ").datepicker({
                    format: 'dd-mm-yyyy',
                    endDate: d
                }).on('changeDate', function (selected) { 
                    var formDataSearch = $('#make_payout_form').serialize();
                     confirmBox(formDataSearch);
                });
        var dealer_id = $("#makedealerSearch").val();
        var edit_id = $("#edit_id").val();
        if(edit_id >0){
            var error  = 0;
            $(".error").html("");    
            if(dealer_id == ''){
              $("#err_dealer").html("Please select Dealership");
              error++;
            }
            if(error > 0){
              return false;
            } else{              
                 var bank_name =  $("#payment_banks option:selected").text();
                 instrumentType($("#payment_mode").val(),1);
                  $("#bank_name").val(bank_name);
                 var favoring = $("#org option:selected").data('favoring');
                 if(favouring_to == '')
                        $("#favourings").val(favoring);
                var formDataSearch = $('#make_payout_form').serialize();                
                DealerWiseIns(formDataSearch); 
                getCheckedCasesCount();
           }
        }
     
        var bank_name =  $("#payment_banks option:selected").text();
        $("#bank_name").val(bank_name);
        // Initialize Tooltip
        $('[data-toggle="tooltip"]').tooltip();
        // Add smooth scrolling to all links in navbar + footer link
        $(".navbar a, footer a[href='#myPage']").on('click', function (event) {
            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();
                // Store hash
                var hash = this.hash;
                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 900, function () {

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            }

        });

    });
    $("#payment_banks").change(function(){
         var bank_name =  $("#payment_banks option:selected").text();
         $("#bank_name").val(bank_name);
    });
    $("#search").on("keyup", function() {
         var value = $(this).val().toLowerCase();
         $("#casedetails tr").filter(function() {
           $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
         });
      });
    /*GET DATA  SELECTED DEALER WISE START*/
    $('#makedealerSearch').change(function () {
         var dealerId = $('#makedealerSearch').val();
        if (dealerId == '0')
        {
            $('#casedetails').html('');
            $("#search").val("");
            $(".searchcases").css("display", "none");
        } else{    
            var formDataSearch = $('#make_payout_form').serialize();
            DealerWiseIns(formDataSearch); 
        }
    });
    function DealerWiseIns(formDataSearch){ 
         $('.loaderClas').attr('style','display:block;');
        $.ajax({
                url: base_url + "PayoutInsurance/ajax_getdealerwise_insurance",
                type: 'post',
                dataType: 'html',
                data: formDataSearch,
                success: function (responseData, status, XMLHttpRequest) {
                    $('#casedetails').html(responseData);
                    $(".searchcases").css("display", "block");
                     $('.loaderClas').attr('style','display:none;');
                }
            });
    }
       function confirmBox(formDataSearch){
           var existing_seleced_count = $("#existing_cases_count").val();
           var new_cases_selected = $("#cases_selected").val();
           if(existing_seleced_count  != new_cases_selected && new_cases_selected >0 ){
            var msg =  "Heads Up! <br /><hr>Selected cases will be removed on changing dates. Do you want to Continue ? ";                        
            bootbox.confirm({                
                message: msg,
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-primary'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-secondary'
                    }
                },
                callback: function (result) {
                    if (result == false) {
                    } else {
                        DealerWiseIns(formDataSearch); 
                    }
                }
            });
        }else{
            DealerWiseIns(formDataSearch); 
        }
        $(".bootbox-close-button").attr("style","display:none !important");
    }
</script>