
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
         var createDate= $('#daterange_to').val();
         var endDate= $('#daterange_from').val();
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
            url: base_url+"payout/ajax_PayoutList/1",
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
//          console.log(newcreateDate +' > '+ newendDate);
//          if(newcreateDate > newendDate){
//              alert("Please Select Valid Date");
//              return true;
//          }
        }
        $.ajax({
            type: 'POST',
            url: base_url+"payout/ajax_PayoutList/1",
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
      
   function getPendingPayoutCases(dealer_id,case_type_id="",editId=""){
    $('#imageloder').show();
    $.ajax({
      url: base_url+"payout/getPendingPayout",
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
     var payout = $("#payout_per_"+id).val()/parseInt(100);
     var amount = $("#hidden_amount_"+id).val().replace(/,/g,''); 
     var emi = $("#hidden_emi_"+id).val().replace(/,/g,''); 
      $(".payout_amount_"+id).html("");
     if(payout > 0){
        var amount_subtracted = (parseInt(amount)-parseInt(emi));
        var payout_amount = amount_subtracted*payout;
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
        var total_payout = 0;
          $("#payout_table input[type=checkbox]:checked").each(function () { 
            var sr_no = $(this).val();
            var hidden_payment_amount = $("#hidden_payment_amount_"+sr_no).val().replace(/,/g,'');
            if(hidden_payment_amount != '')
            {
              total_payout = parseInt(total_payout)+ parseInt(hidden_payment_amount); 
            }
        });
          var total_amount = gst_amount = tds_amount = 0;
          
           if($("input[name='gst_type']:checked").val() == 2){
              var gst_excluded_amount = (parseInt(total_payout) * 100) / 118;
              gst_excluded_amount = gst_excluded_amount.toFixed(2);
              var gst_amount = 0.18 * gst_excluded_amount;
              gst_amount = gst_amount.toFixed(2);
              $("#gst_excluded_amount").html("");
              $("#gst_excluded_amount").html(gst_excluded_amount);
              $("#gst_excluded_amount_txt").val(gst_excluded_amount);
              
              $("#tot_gst_amt").html("");
              $("#total_amt_text").val(gst_amount);
              var gst_amount1 = addCommased(gst_amount,'tot_gst_amt','','1');
              $("#tot_gst_amt").html(gst_amount1);
           }else if($("input[name='gst_type']:checked").val() == 1){
              var gst_excluded_amount = total_payout;
              $("#gst_excluded_amount").html("");
              $("#gst_excluded_amount_txt").val(gst_excluded_amount);  
              
               $("#tot_gst_amt").html("");
              $("#total_amt_text").val("0");
              $("#tot_gst_amt").html("0");
           }
            
           var tds_amount = 0;
            if($("input[name='tds_type']:checked").val() == 2){
              tds_amount = 0.05 * parseFloat(gst_excluded_amount);
              tds_amount = Math.round(tds_amount);
              $("#tot_tds_amt").html("");
              $("#tot_tds_amt").html(tds_amount);
              $("#tds_amount_text").val(tds_amount);
           }else{
              $("#tot_tds_amt").html("");
              $("#tot_tds_amt").html("0");
              $("#tds_amount_text").val("0");  
           }
            var pdd_amount = $("#pdd_charges").val().replace(/,/g,'');
            if(pdd_amount != ""){
                var cases_selected = $("#cases_selected").val();
                var total_pdd_amount = pdd_amount * cases_selected;
                $("#pdd_amount_text").val(total_pdd_amount);
                $("#pdd_amt").html("");
                var pdd_amt = addCommased(total_pdd_amount,'pdd_amt','','1');
                $("#pdd_amt").html(pdd_amt);
           }
           total_amount = total_payout;
           $("#total_amount").val(total_amount);
           var total_net_amt = parseFloat(gst_excluded_amount) + parseFloat(gst_amount) - tds_amount - parseInt(total_pdd_amount);
           total_net_amt = Math.round(total_net_amt);
           
           $("#net_amount_text").val(total_net_amt); 
           
           gst_excluded_amount = addCommased(gst_excluded_amount,'gst_excluded_amount','','1');
           $("#gst_excluded_amount").html(gst_excluded_amount);
           
           tds_amount = addCommased(tds_amount,'tot_tds_amt','','1');
           $("#tot_tds_amt").html(tds_amount);
           
        if(total_net_amt >0 || total_amount >0){
            total_net_amt = addCommased(total_net_amt,'total_net_amt','','1');
            $("#tot_net_amt").html(total_net_amt); 
            total_amount = addCommased(total_amount,'total_amount','','1');
            $("#tot_amt").html("");
            $("#tot_amt").html(total_amount);
            $("#amounts").val(total_net_amt);           
            $(".payment_details").css("display","block");
        }else{
            $("#tot_amt").text("");
            $("#total_amount").val("0");
            $(".payment_details").css("display","none");
        }
    }
  
  function instrumentType(e)
  {
      var id = $(e).attr('id');
      var insType = $('#'+id).val();
      var ids = id.split('_');

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
          $('#bnk').hide();
          $('#favo').show(); 
          $('#payment_banks').val('');
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
function getCheckedCasesCount(flag = "") {
    var count = 0;
    var new_car_count = 0;
    if (flag != 1) {
        setTimeout(function () {
            $("#payout_table input[type=checkbox]:checked").each(function () {
                count++;
                if($(this).data('loan-for') == 1)
                    new_car_count++;
            });
            $("#case_checked_count").html(count + " case selected");
           
             $("#cases_selected").val(new_car_count);
        }, 3000);
    } else {
        $("#payout_table input[type=checkbox]:checked").each(function () {
            count++;
            if($(this).data('loan-for') == 1)
                    new_car_count++;
        });
        $("#case_checked_count").html(count + " case selected");
        $("#cases_selected").val(new_car_count);
         checkPayout();
         
}

}
$("#payout_table input[type=checkbox]").click(function () {
    getCheckedCasesCount(1);
   
}) 
function reset()
{
    location.reload(true);
} 
/*function downloadFile(id){
    window.top.location.href = base_url+"payout/printpdf/" + id; 
}*/  
function downloadFile(id){
        $.ajax({
        type: 'POST',
        url: base_url+"payout/printpdf",
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
               window.location=base_url+"payout/downloadBookingPdf/?file="+responseData.file_name;
             }
            }
        });
    }