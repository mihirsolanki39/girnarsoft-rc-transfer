
   function addVal(carid,amount)
   { 
  
      var totalamt = $('#totamt').val().replace(/,/g,'');
      var count = $('#counter').val();
      var amounts = $('#amounts').val().replace(/,/g,'');
      count++;
      if(totalamt=='')
      {
          totalamt = 0;
      }      
      //alert(totalamt +'------'+amount);
      var sum =  parseInt(totalamt)+parseInt(amount);
      //alert(sum);
      if(amounts!='')
      {
          if(sum>amounts){
          var ss = parseInt(sum)-parseInt(amounts);
          $('#short_amount').val(ss);
          $('#short_amount').trigger('onkeyup');
          }
      }
      $('#totamt').val(sum);
      $('#tot_amt').text(sum);
      $('#stocksel').text(count);
      $('#counter').val(count);
   }
   function subVal(carid,amount)
   { 
      var totalamt = $('#totamt').val().replace(/,/g,'');
      var count = $('#counter').val();
      var amounts = $('#amounts').val().replace(/,/g,'');
      count--;
      
      var sub =  parseInt(totalamt)-parseInt(amount);
      if(amounts!='')
     {
      if(sub>amounts){
        var ss = parseInt(sub)-parseInt(amounts);
        $('#short_amount').val(ss);
        $('#short_amount').trigger('onkeyup');
      }
        //alert(ss);
       // addCommased(ss,'short_amount');
     }
      $('#totamt').val(sub);
      $('#tot_amt').text(sub);
      $('#stocksel').text(count);
      $('#counter').val(count);
   }
    $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
              var cdi = $(this).attr('id');
              var resId = cdi.split("_");
             // alert($('#est_amt_'+resId[1]).text());
              var est_amt = $('#est_amt_'+resId[1]).text().replace(/,/g,'');
                  //alert(est_amt);
              var car_id = $(this).val();
              var res = car_id.split("@");
              addVal(res[0],est_amt);
            }
            else if($(this).prop("checked") == false){
                
                var module   = $('#module_id').val();
                if(module!= '' && $.trim(module) == 'edit_single'){
                    alert('You have no option to uncheck checkbox');
                    return true;
                }
                var cdi = $(this).attr('id');
                var resId = cdi.split("_");
                //alert($('#est_amt_'+resId).text());
                var est_amt = $('#est_amt_'+resId[1]).text().replace(/,/g,'');
                var car_id = $(this).val();
                var res = car_id.split("@");
                subVal(res[0],est_amt);
            }
        });


    function setVal(v)
    {       
        var amt = v.replace(/,/g,'');
        var totalamt = $('#totamt').val().replace(/,/g , '');
        //alert(totalamt);
        if(totalamt =='' || totalamt == 0 )
          {
              alert('Please select stock.');
              return false;
          }
        var ss = totalamt -amt;        
        if(ss < 0){            
            alert('Short amount can-not be negative value');
            $('#amounts').val('');
            //$('#short_amount').val(addCommased(totalamt));
            return false;            
        }
        
        $('#short_amount').val(ss);
        $('#short_amount').trigger('onkeyup');
    }
 
$(document).ready(function(){
  $("#search_filter").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#search_table tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

//tabbing
 $("[data-toggle=popover]").each(function(i, obj) {

    $(this).popover({
      html: true,
      content: function() {
        $('.popover').removeClass('in');
        $('.popover').attr('style','display:none');
        var id = $(this).attr('id')
        return $('#popover-content-' + id).html();
      }
    });

    });
    
    //Reg. No./ Make/ Model and Min Payment Due input validations
    $('#search_by').keypress(function(event){
       var keycode = (event.keyCode ? event.keyCode : event.which);
       if(keycode == '13'){
          $('#search').trigger('click');
           return false;
       }

     });
     
    $('#search_bys, #min_payment').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
           $('#searchb').trigger('click');
            return false;
        }
    });    
    
        //work deatails js here

        function blockAllSpecialChar(e) {
              var k;
              document.all ? k = e.keyCode : k = e.which;
             // alert(k);
              return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || (k >= 44 && k <= 57));
          }

        function addCommased(nStr,control,flag='')
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
              document.getElementById(control).value=x1 +x3+x2;
          }
  
  function instrumentType(e)
  {
      var id = $(e).attr('id');
      var insType = $('#'+id).val();
      var ids = id.split('_');
     // alert(insType);
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
  
  function saveEditData()
  { 
      var instrumenttype      = $.trim($('#instrumenttypes').val());
      var amount              = $.trim($('#amounts').val());
      var paydates            = $.trim($('#paydates').val());
      var insno               = $.trim($('#insnos').val());
      var insdate             = $.trim($('#insdates').val());
      var payment_bank        = $.trim($('#payment_banks').val());
      var favouring           = $.trim($('#favourings').val());
      var workshop_id         = $.trim($('#workshop_id').val());
      var edit_id             = $.trim($('#edit_id').val());
      var remark             = $.trim($('#remarks').val());
      var counter = $.trim($('#counter').val());
      var tot_amt = $.trim($('#tot_amt').text());
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

      if(instrumenttype=='cheque')
      {
          if(insno == ''){
            $("#err_insnos").html("Please enter instrument no.");
            error++;
          }

          if(insdate == ''){
            $("#err_insdates").html("Please select instrument date.");
            error++;
          }

          if(payment_bank == ''){
            $("#err_bank_lists").html("Please select bank name.");
            error++;
          }

          if(favouring == ''){
            $("#err_favourings").html("Please enter favouring.");
            error++;
          }
      }

      if(instrumenttype=='dd')
      {
          if(insno == ''){
            $("#err_insnos").html("Please enter instrument no.");
            error++;
          }

          if(insdate == ''){
            $("#err_insdates").html("Please select instrument date.");
            error++;
          }

          if(favouring == ''){
            $("#err_favourings").html("Please enter favouring.");
            error++;
          }
      }

      if(instrumenttype=='online')
      {
          if(insno == ''){
            $("#err_insnos").html("Please enter instrument no.");
            error++;
          }
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
            
            setTimeout(function(){ location.href = base_url+"refurblist?type=2"; }, 3000);
          }   
        });
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
 
  function downloadFile(file){
    if(file != ''){
      location.href = base_url + 'stock/downloadRefurbPdf?file='+file;
    }
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
  
  function stockpagination(page){
    $("#page").val(page);
    $.ajax({
      url: base_url+"refurb/get_refurblist",
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

function stockreset()
{ 
  location.reload();
  setTimeout(function(){  $('#sh_tab').trigger('click'); }, 3000);
 
}

function searchList(){
    $("#page").val(1);
    $.ajax({
      url: base_url+"refurb/ajax_getRefurb",
      type: 'post',
      dataType: 'html',
      data: {'data':$("#search_form").serialize()},
      success: function(response)
      {
        $(".list_div").html(response);
      }
    });
  }
  
   function isNumberKey(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
      }
      return true;
  }  
//work deatails js ending here