$('#search').click(function (event) {
        var formData=$('#searchform').serialize();
        $('#page').val('1');
        $('#imageloder').show();
        var start = $('#daterange_to').val();
        var end = $('#daterange_from').val();
        var formDataSearch=$('#searchform').serialize();
        var srchdate=$('#searchdate').val(); 
        if(srchdate!=''){
           // alert('dfdf');
         var createDate= $('#createStartDate').val();
         var endDate= $('#createEndDate').val();
          if(createDate==''){
              $('#imageloder').hide();
              alert("Please Select From Date");
              return true;
          }
          if(endDate==''){
              $('#imageloder').hide();
              alert("Please Select End Date");
              return true;
          }
          var d=createDate.split("/");
          var newcreateDate=d[2]+"/"+d[1]+"/"+d[0];
          var d1=endDate.split("/");
          var newendDate=d1[2]+"/"+d1[1]+"/"+d1[0];
//          console.log(newcreateDate +' > '+ newendDate);
//          if(newcreateDate > newendDate){
//              alert("Please Select Valid Date");
//              return true;
//          }
        }
        $.ajax({
            type: 'POST',
            url: base_url+"PayoutInsurance/ajax_PayoutList/1",
            data: formDataSearch,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
            if (responseData == 1) {
                 $('#total_count').text('('+"0"+')');
            $('#imageloder').hide();
            $('#payoutcases').html("<tr><td align='center' colspan='6'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
            } else {
            $('#imageloder').hide();
            $('#payoutcases').html(responseData);
            }
            addCommasToListing();
            }
        });
    });

    $('#payouthistorysearch').click(function (event) {
        var formData=$('#payout_search_form').serialize();
        $('#page').val('1');
        $('#imageloder').show();
        var start = $('#daterange_to').val();
        var end = $('#daterange_from').val();
        var formDataSearch=$('#payout_search_form').serialize();
        var srchdate=$('#searchdate').val(); 
        if(srchdate!=''){
           // alert('dfdf');
         var createDate= $('#daterange_to').val();
         var endDate= $('#daterange_from').val();
          if(createDate==''){
              alert("Please Select From Date");
              return true;
          }
          if(endDate==''){
              alert("Please Select End Date");
              return true;
          }
          var d=createDate.split("/");
          var newcreateDate=d[2]+"/"+d[1]+"/"+d[0];
          var d1=endDate.split("/");
          var newendDate=d1[2]+"/"+d1[1]+"/"+d1[0];
        }
        $.ajax({
            type: 'POST',
            url: base_url+"PayoutInsurance/ajax_PayoutList/1",
            data: formDataSearch,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
            if (responseData == 1) {
            $('#total_count').text('('+"0"+')');
            $('#imageloder').hide();
            $('#payouthistory').html("<tr><td align='center' colspan='6'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
            } else {
            $('#imageloder').hide();
            $('#payouthistory').html(responseData);
            
            }
            addCommastoList();
            }
        });
    });
      
   function getPendingPayoutCases(dealer_id,case_type_id,editId){
    $('#imageloder').show();
    $.ajax({
      url: base_url+"PayoutInsurance/getPendingPayout",
      type: 'post',
      dataType: 'json',
      data: {'source':dealer_id,'case_type_id':case_type_id,'editId':editId},
      success: function(response)
      {
          $('#imageloder').hide();
           $('#payout_table > tbody').html("");          
          $('#payout_table > tbody').html(response.html);
        
      }
    });
  }
   function calculatePayout(id){
     $("#hidden_case_id_"+id).prop("disabled", false);
     $("#payout_per_"+id).prop("disabled", false);
     var payout = $("#payout_per_"+id).val()/parseInt(100);
     var amount = $("#hidden_amount_"+id).val().replace(/,/g,''); 
     var addon = $("#hidden_addon_"+id).val().replace(/,/g,''); 
      $(".payout_amount_"+id).html("");
     if(payout > 0){
        var amount_added = (parseInt(amount) + parseInt(addon));
        var payout_amount = amount_added*payout;
        payout_amount = payout_amount.toFixed(2);
        payout_amount = Math.round(payout_amount);
        $("#hidden_payment_amount_"+id).val(payout_amount);
        payout_amount = addCommased(payout_amount,'a','','1');       
        $(".payout_amount_"+id).html("<i class='fa fa-rupee'></i> "+payout_amount);       
     }else{
          $(".payout_amount_"+id).html("<i class='fa fa-rupee'></i> "+0);
          $("#hidden_payment_amount_"+id).val(0);         
     }
     $("#car_"+id).prop( "checked", true );
     getCheckedCasesCount(1);
     checkPayout();
    }
    function checkPayout(){
        var total_payout = total_amount = total_due = total_net_amt = 0;
          $("#payout_table input:checkbox.srno:checked").each(function () { 
            var sr_no = $(this).val();
            var hidden_payment_amount = $("#hidden_payment_amount_"+sr_no).val().replace(/,/g,'');
            if(hidden_payment_amount != '')
            {
              total_payout = parseInt(total_payout)+ parseInt(hidden_payment_amount); 
            }
             if($("#settle_due_"+sr_no+":checked").prop("checked") == true){
                 $("#hidden_settle_due_"+sr_no).prop("disabled", false);
                 var due = $("#due_amount_"+sr_no).text().replace(/,/g,'');
                 if(due != ""){
                    total_due = parseInt(total_due)+ parseInt(due); 
                 }
               }else{
                 $("#hidden_settle_due_"+sr_no).prop("disabled", true);   
               }
            });           
            $("#total_due_amt_text").val(total_due);
            var due_amount = addCommased(total_due,'total_due_amt','','1');
            $("#total_due_amt").html(due_amount);
            $("#total_amount").val(total_payout);
            total_amount = total_payout;
            var cases_selected = $("#cases_selected").val();
            if (cases_selected >= 1)
             {
                 $('#deliveryDetailsButton').attr('href', '#menu2');
                 $('.select-color').removeClass(' select-color');
                 $('.pay_Details').addClass(' select-color');
             }else{
                  $('#deliveryDetailsButton').attr('href','#');
                  $('.pay_Details').removeClass(' select-color');
             }
             
           if(parseInt(total_amount) > 0){
               total_net_amt = parseInt(total_amount) - parseInt(total_due);
           }
            $('#deliveryDetailsButton').prop('disabled', true); 
           if(total_net_amt > 0  && cases_selected >= 1){
              $('#deliveryDetailsButton').prop('disabled', false); 
           }
           
           $("#net_amount_text").val(total_net_amt); 
         if(total_net_amt >0 || total_amount >0){
            total_net_amt = addCommased(total_net_amt,'total_net_amt','','1');
            $("#tot_net_amt").html(""); 
            $("#tot_net_amt").html(total_net_amt); 
            total_amount = addCommased(total_amount,'total_amount','','1');
            
            $("#tot_amt").html("");
            $("#tot_amt").html(total_amount);
            $("#amounts").val(total_net_amt);           
            $(".payment_details").css("display","block");
        }else{
            $("#tot_net_amt").html("0"); 
            $("#tot_amt").text("0");
            $("#total_amount").val("0");
            $(".payment_details").css("display","none");
        }
    }
  
  function instrumentType(e,flag="")
  {
      if(flag == 1){
          var insType = e;
      }else{
        var id = $(e).attr('id');
        var insType = $('#'+id).val();
        var ids = id.split('_');
      }

      if(insType=='1')
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

      if(insType=='2')
      {
          $('#ins_no').show();
          $('#ins_date').show();
          $('#bnk').show();
          $('#favo').show(); 
      }

      if(insType=='3')
      {
          $('#ins_no').show();
          $('#ins_date').show();
          $('#bnk').show();
          $('#favo').show(); 
      }
      if(insType=='4')
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
      var instrumenttype      = $.trim($('#payment_mode').val());
      var amount              = $.trim($('#amounts').val());
      var paydates            = $.trim($('#paydates').val());
      var insno               = $.trim($('#instrument_no').val());
      var insdate             = $.trim($('#insdates').val());
      var payment_bank        = $.trim($('#payment_banks').val());
      var favouring           = $.trim($('#favourings').val());
      var remark             = $.trim($('#remark').val());
      var cust             = $.trim($('#cust').val());    
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
          url: base_url+"PayoutInsurance/save_payment",
          type: 'post',
          dataType: 'json',
          data:formData,
          success: function(response) 
          {
                if ($("#edit_id").val() != "") {
                    $('#snackbar').html('Payment Details updated successfully.');
                } else {
                    $('#snackbar').html('Payment Details saved successfully.');
                }            
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 30000);
            setTimeout(function(){ location.href = base_url+"insurancePayout"; }, 3000);
          }   
        });
      }

 }
   function addCommased(nStr,control,flag='',flag1 ='')
  {
      if(flag==1){
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
function getCheckedCasesCount(flag = "",srn = "") {
    if ($("#car_" + srn + ":checked").prop("checked") == true && srn != "") {
        $("#payout_per_" + srn).prop("disabled", false);
        $("#hidden_payment_amount_" + srn).prop("disabled", false);
        $("#ins_customer_id_" + srn).prop("disabled", false);
    } else {
        if (srn != "") {
            $("#payout_per_" + srn).prop("disabled", true);
            $("#hidden_payment_amount_" + srn).prop("disabled", true);
            $("#hidden_settle_due_"+srn).prop("disabled", true);  
            $("#ins_customer_id_" + srn).prop("disabled", false);
        }
    }
    var count = 0;
    var new_car_count = count;
    if (flag != 1) {
        setTimeout(function () {
            count = $("#existing_cases_count").val();
            new_car_count = count;
            $("#payout_table input:checkbox.srno:checked").each(function () { 
                if($(this).prop('readonly') == false){   
                    count++;                
                    new_car_count = count;
               } 
            });
            $("#case_checked_count").html("Cases ("+count + ")");
             $("#cases_selected").val(new_car_count);
        }, 3000);
    } else {
        count = $("#existing_cases_count").val();
        new_car_count = count;
        $("#payout_table input:checkbox.srno:checked").each(function () {
            if($(this).prop('readonly') == false){           
                count++;
                new_car_count = count;
            }
        });
        $("#case_checked_count").html("Cases ("+count + ")");
        $("#cases_selected").val(new_car_count); 
         checkPayout();   
    }
}
function reset(flag = ""){
    if(flag == 1){
       window.location.href= base_url+"insurancePayout/2";
    }else
       location.reload(true);
} 
/*function downloadFile(id){
    window.top.location.href = base_url+"payout/printpdf/" + id; 
} */ 
function downloadFile(id){
        $.ajax({
        type: 'POST',
        url: base_url+"PayoutInsurance/printPayoutpdf",
        data: {id:id},
        dataType:'json',
        beforeSend:function(){
            $('.searchresultloader').show();
             snakbarAlert('Please Wait While PDF Is Getting Downloaded');
        },
        success: function (responseData, status, XMLHttpRequest) {
            $('#quotes_form_error').text('');
             $('.searchresultloader').hide();
            snakbarAlert(responseData.message);
             if(responseData.status){
               window.location=base_url+"PayoutInsurance/downloadBookingPdf/?file="+responseData.file_name;
             }
            }
        });
    }

 $('#makesearch').click(function (event) {

        var formData=$('#payout_search_form').serialize();
        $('#imageloder').show();
        var start = $('#makedealerSearch').val();
        var end = $('#make_polic_type').val();
        var formDataSearch=$('#payout_search_form').serialize();
        
        $.ajax({
            type: 'POST',
            url: base_url+"insurancePayout/getPendingPayout",
            data: formDataSearch,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
            if (responseData == 1) {
            $('#total_count').text('('+"0"+')');
            $('#imageloder').hide();
            $('#payouthistory').html("<tr><td align='center' colspan='6'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
            } else {
            $('#imageloder').hide();
            $('#payouthistory').html(responseData);
            
            }
            //addCommastoList();
            }
        });
    });
    
      function isRoiNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) && (charCode!=46))
            return false;
        return true;
    } 