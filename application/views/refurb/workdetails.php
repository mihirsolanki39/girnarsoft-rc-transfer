<style>
  .nav-tabs>li a{font-size: 16px;}
    .nav-tabs>li a:hover{background: none;}
    .nav-tabs>li.active>a:hover{background: none;}
    .nav-tabs>li.active>a:focus{background: none;}
    .nav-tabs>li.active>a{background: none; font-size: 16px}
    .assigned-tag {background: #ffefd6; padding: 7px 15px; border-radius: 15px; color: #000000; font-size: 12px;margin-top: 10px; display: inline-block;}

   .label-t{padding: 5px 10px;text-transform: uppercase;display: inline-block;float: right;}
  .availabe{background: #2196F3; color: #fff;border-radius: 3px;font-size: 11px;}
  .sold{background: #00B028;color: #fff;border-radius: 3px;font-size: 11px;}
  .refurb{ background: #6A6A6A;color: #fff;border-radius: 3px;font-size: 11px;}
  .booked{background: #F0B967;color: #fff;border-radius: 3px;font-size: 11px;}
  .removed{ background: #FF0000;color: #fff;border-radius: 3px;font-size: 11px;} 
</style>
<div class="container-fluid mrg-all-20">
  <div class="row">
    <h5 class="cases mrg-B20" id="heading_page"><?php echo $w_details['name']; ?></h5>
    <ul class="nav nav-tabs">
        <li id="sh_tab" class="options <?php if(intval($type) == 2) { ?>active<?php } ?>"><a data-toggle="tab" style="cursor: pointer;" >Refurb Stock Details</a></li>
        <li id="pd_tab" class="options <?php if(intval($type) == 1) { ?>active<?php } ?>"><a data-toggle="tab" style="cursor: pointer;" > Payment History</a></li>
      
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade in active">
      <div id="stockre" style="display: none;">
      <?php 
if(!$is_search){ ?>
  <div class="cont-spc pad-all-20" id="buyer-lead">
    <form id="search_form" name="search_form" method="post">
      <input type="hidden" id="source" name="source" value="2" />
      <input type="hidden" id="page" name="page" value="1" />
      <input type="hidden" id="w_id" name="w_id" value="<?= !empty($w_id)?$w_id:""; ?>"/>
      <div class="row">
         
        <div class="col-md-2 pad-R0">
            <label for="" class="crm-label">Search By</label>
            <input type="text" class="form-control" onkeypress="return blockSpecialChar(event)" name="search_by" id="search_by" value="" placeholder="RegNo./Make/Model">
        </div>

        <div class="col-md-2 pad-R0">

          <label for="" class="crm-label">Status</label>
          <select name="stock_status" id="stock_status" class="form-control">
            <option value="">Select</option>
            <option value="1">In Refurb</option>
            <option value="2">Refurb Done</option>
          </select>
        </div>
          
          <div class="col-md-2 pad-R0">

          <label for="" class="crm-label">Payment Status</label>
          <select name="payment_status" id="payment_status" class="form-control">
            <option value="">Select</option>
            <option value="1">Paid</option>
            <option value="2">Pending</option>
          </select>
        </div>

         <div class="col-md-6 pad-R0" id="wdlabel">
                        
                         <div class="col-sm-3 pad-R0">
                               <label for="" class="crm-label">Date</label>
                                 <select name="date_status" id="date_status" class="form-control">
                                    <option value="1">Sent Date</option>
                                    <option value="2">Return Date</option>
                                  </select>
                          </div>
                          <div class="col-sm-3 pad-R0 pad-L0 mrg-T25">
                                <div class="date input-append demo" id="reservation_to" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                    <input type="text" name="daterange_to" id="daterange_to" class="form-control crm-form add-on icon-cal1 new_input" placeholder="From" readonly> 
                              </div>
                           </div>
                          <div class="col-sm-3 pad-R0 pad-L0  mrg-T25">
                              <div class="date input-append demo" id="reservation_from" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                  <input type="text" name="daterange_from" id="daterange_from" class="form-control crm-form add-on icon-cal1 new_input" placeholder="To" readonly> 
                              </div>
                           </div>
                         </div>

        <div class="col-md-2 pad-R0">
          <span>
              <a class="btn-save btn-save-new" onclick="stockSearchList();" id="searchb">SEARCH</a>
              <a onclick="stockreset();" class="mrg-L10 used__car-reset-btn">RESET</a>
          </span>
        </div>

      </div>
    </form>
  </div>
<?php } ?>
</div>
        <div id="payment_stock_div" class=""></div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="makePayment" role="dialog">
  <div class="modal-backdrop fade in" style="height:100%"></div>
  <div class="modal-dialog" style="width: 1024px; height:100vh; z-index: 9999;">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url('assets/admin_assets/images/cancel.png'); ?>"> <span class="sr-only">Close</span></button>
        <h4 class="modal-title">Make Payment</h4>
      </div>
      <div id="payment_modal"></div>
    </div>
  </div>
</div>

<div class="loaderClas" style="display:none;"><img class="resultloader" src="<?= base_url('assets/images/loading.gif') ?>" style="position: absolute;left: 0;right: 0;text-align: center;top: 0;bottom: 0;margin: auto;z-index: 9999;"></div>

<script src="<?=base_url('assets/js/bootstrap-datepicker.js')?>"></script> 
<script type="text/javascript">
  <?php if($type != ''){ ?>
    var ttype     = '<?php echo $type; ?>';
    var w_id      = '<?php echo $w_id; ?>';
    //getListHtml(ttype);
  <?php } ?>

  $(document).ready(function() {
    $('#stockre').attr('style','display:block');
    getListHtml(2);
    $('#sh_tab').addClass('active');
    $('#pd_tab').removeClass('active');
      $('.options').on('click', function() { 
        $(".options").removeClass('active');
        $(this).addClass('active');
        
        if($(this).attr('id') == 'pd_tab'){
          $('#stockre').attr('style','display:none');
          getListHtml(1);
        } else if($(this).attr('id') == 'sh_tab'){
          $('#stockre').attr('style','display:block');
          getListHtml(2);
        } 
      });
  });

  function getListHtml(source){
    $('.loaderClas').show();
    $("#payment_stock_div").html("");
    $.ajax({
      url: base_url+"refurb/ajax_getPaymentAndStock",
      type: 'post',
      dataType: 'html',
      data: {'source':source,'w_id':w_id},
      success: function(response)
      {
        $("#payment_stock_div").html(response);
        $('.loaderClas').hide();

        /*if(parseInt(source) == 1){
          $('#carStatus').SumoSelect(); 
        } else if(parseInt(source) == 2){
          
        } */
      }
    });
  }

  function searchList(){
    $("#page").val(1);
    $.ajax({
      url: base_url+"refurb/ajax_getPaymentAndStock",
      type: 'post',
      dataType: 'html',
      data: {'data':$("#search_form").serialize()},
      success: function(response)
      {
        $(".list_div").html(response);
      }
    });
  }

function stockreset()
{
  location.reload();
  setTimeout(function(){  $('#sh_tab').trigger('click'); }, 3000);
 
}

function stockSearchList(){
    $("#page").val(1);
   $.ajax({
      url: base_url+"refurb/ajax_getPaymentAndStock",
      type: 'post',
      dataType: 'html',
      data: {'data':$("#search_form").serialize()},
      success: function(response)
      {
        $("#payment_stock_div").html(response);
        $( window).scrollTop( 0 );
      }
    });
  }
  function pagination(page){
    $("#page").val(page);
    $.ajax({
      url: base_url+"refurb/ajax_getRefurb",
      type: 'post',
      dataType: 'html',
      data: {'data':$("#search_form").serialize()},
      success: function(response)
      {
        $(".list_div").html(response);
        $( window).scrollTop( 0 );
      }
    });
  }

  function stockpagination(page){
    $("#page").val(page);
    $.ajax({
      url: base_url+"refurb/ajax_getPaymentAndStock",
      type: 'post',
      dataType: 'html',
      data: {'data':$("#search_form").serialize()},
      success: function(response)
      {
        $("#payment_stock_div").html(response);
        $( window).scrollTop( 0 );
      }
    });
  }

  function getHistory(car_id){
    $.ajax({
      url: base_url+"refurb/get_history",
      type: 'post',
      dataType: 'html',
      data: {'car_id':car_id},
      success: function(response)
      {
        $("#history_details_ul").html(response);
      }
    });
  }

  function downloadFile(file){
    if(file != ''){
      location.href = base_url + 'stock/downloadRefurbPdf?file='+file;
    }
  }

  function makePayment(w_id='',workshop_id='',flag='',module_new=''){ 
    
    var type = 'edit';
    if(flag!='')
    {
      type = '';
    }
    
    $.ajax({
      url: base_url+"refurb/make_payment",
      type: 'post',
      dataType: 'html',
      data: {'w_id':w_id,type:type,'workshop_id':workshop_id,'module':module_new},
      success: function(response)
      {
        $("#payment_modal").html(response);
        $('#insdates').datepicker({
          format: 'dd-mm-yyyy',
          autoclose: true,
          todayHighlight: true   
        });

        $('#paydates').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true   
        });
      }
    });
  }

  function workDetails(workshop_id){
    location.href = base_url+"workdeatils?w_id="+workshop_id;
  }

  function saveEditData()
  {
      var instrumenttype      = $.trim($('#instrumenttypes').val());
      var amount              = $.trim($('#amounts').val().replace(/,/g,''));
      var paydates            = $.trim($('#paydates').val());
      var insno               = $.trim($('#insnos').val());
      var insdate             = $.trim($('#insdates').val());
      var payment_bank        = $.trim($('#payment_banks').val());
      var favouring           = $.trim($('#favourings').val());
      var workshop_id         = $.trim($('#workshop_id').val());
      var edit_id             = $.trim($('#edit_id').val());
      var remark             = $.trim($('#remarks').val());
      var counter = $.trim($('#counter').val());
      var tot_amt = $.trim($('#tot_amt').text().replace(/,/g,''));
      var short_amount = $.trim($('#short_amount').text().replace(/,/g,''));
     // var verified             = $('[name=verified]').val();


      var error               = 0;
      $(".error").html("");
      if(counter<1)
      {
         $("#err_counter").html("Please select atleast one stock.");
        error++;
      }
      if(instrumenttype == ''){
        $("#err_instrumenttypes").html("Please select instrument type.");
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

//      if(instrumenttype=='cheque')
//      {
//          if(insno == ''){
//            $("#err_insnos").html("Please enter instrument no.");
//            error++;
//          }
//
//          if(insdate == ''){
//            $("#err_insdates").html("Please select instrument date.");
//            error++;
//          }
//
//          if(payment_bank == ''){
//            $("#err_bank_lists").html("Please select bank name.");
//            error++;
//          }
//
//          if(favouring == ''){
//            $("#err_favourings").html("Please enter favouring.");
//            error++;
//          }
//      }
//
//      if(instrumenttype=='dd')
//      {
//          if(insno == ''){
//            $("#err_insnos").html("Please enter instrument no.");
//            error++;
//          }
//
//          if(insdate == ''){
//            $("#err_insdates").html("Please select instrument date.");
//            error++;
//          }
//
//          if(favouring == ''){
//            $("#err_favourings").html("Please enter favouring.");
//            error++;
//          }
//      }
//
//      if(instrumenttype=='online')
//      {
//          if(insno == ''){
//            $("#err_insnos").html("Please enter instrument no.");
//            error++;
//          }
//      }
      
       if(parseInt(tot_amt) < parseInt(amount)){
        $("#err_amounts").html("Paid amout should be less than total amount.");
        error++;
      } 
      
      if(error > 0){
        return false;
      } else{
        $(".loaderClas").show();
         var formData=$('#editids').serialize();
        $.ajax({
          url: base_url+"refurb/save_payment",
          type: 'post',
          dataType: 'json',
          data:formData,
          //data:{instrumenttype:instrumenttype,amount:amount,insno:insno,insdate:insdate,payment_bank:payment_bank,favouring:favouring,paydates:paydates,workshop_id:workshop_id,edit_id:edit_id,remark:remark},
          success: function(response) 
          {
            $(".loaderClas").hide();
            if(response.status == 1){
              snakbarAlert("Payment has been saved successfully.");
              setTimeout(function(){ $(".close").click(); }, 1000);
            }
            location.reload(true);
           
          }   
        });
      }
  }

  function instrumentType(e)
  {
      var id = $(e).attr('id');
      var insType = $('#'+id).val();
      var ids = id.split('_');
      if(insType=='cash')
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

      if(insType=='cheque')
      {
          $('#ins_no').show();
          $('#ins_date').show();
          $('#bnk').show();
          $('#favo').show(); 
      }

      if(insType=='dd')
      {
          $('#ins_no').show();
          $('#ins_date').show();
          $('#bnk').show();
          $('#favo').show(); 
          $('#payment_banks').val('');
      }

      if(insType=='online')
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

  function isNumberKey(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
      }
      return true;
  }

  function blockSpecialChar(e) {
      var k;
      document.all ? k = e.keyCode : k = e.which;
      return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 44 && k <= 57));
  }

  function alphaOnly(evt) {
     evt = (evt) ? evt : event;
     var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
        ((evt.which) ? evt.which : 0));
     if (charCode > 31 && (charCode < 65 || charCode > 90) &&
        (charCode < 97 || charCode > 122)) {
         return false;
     }
     return true;
  }

  function nameOnly(event)
  {
      var inputValue = event.which;
             //alert(inputValue);
      if(!(inputValue >= 65 && inputValue <= 123) && (inputValue != 32 && inputValue != 0 && inputValue != 8)) { 
          event.preventDefault(); 
          return false;
      }
             // console.log(inputValue);
  }

  function blockAllSpecialChar(e) {
      var k;
      document.all ? k = e.keyCode : k = e.which;
      alert(k);
      return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || (k >= 44 && k <= 57));
  }

  function addCommased(nStr,control,flag='',flag1 ='')
  {
      if(flag==''){
          nStr=nStr.replace(/,/g,''); 
      }else
      {
          nStr=nStr; 
      }
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{2})/;
      var len;
      var x3="";
      len=x1.length;
      if(len>3){
          var par1=len-3;
          
          x3=","+x1.substring(par1,len);
          x1=x1.substring(0,par1);
          
          //alert(x3);
      }
      len=x1.length;
      if(len>=3 && x3!=""){
      while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
      }
      if(flag1 == 1)
          return x1 +x3+x2;
      else
      document.getElementById(control).value=x1 +x3+x2;
  }
  
  $('#search_bys, #min_payment,#search_by').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
       $('#searchb').trigger('click');
        return false;
    }

});
 

</script>