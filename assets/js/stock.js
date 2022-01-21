  /* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var statusObj =function () {this.dealerId='';};
var statusObjInit = new statusObj();


statusObj.prototype.getStockMoreData= function (pageNo){
   
      if(pageNo=="" || typeof(pageNo)=='undefined'){
          pageNo=1;
      }
      var rowcount=$('.rowcount:last').val();
      var data ="key=search&page="+pageNo+"&totcnt="+rowcount+"&"+$('#searchform').serialize();
      
     $.ajax({
        type: 'POST',
        url: base_url+"stock/getStockList",
        data: data,
        dataType: "html",
        beforeSend:function(){
            //alert(3)
            $('.searchresultloader').show();
            //$('#inventoryList').text('Loading...');
        },
        success: function (responseData)
        {
             $('.searchresultloader').hide();
            if(jQuery.trim(responseData)){
                $('#inventoryList').append(responseData);
            }else{
             $('div#loadmoreajaxloader').show();   
             $('#loadmoreajaxloader').text('No More Results');   
            }

        }
    });
}


    
$(window).scroll(function() {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {
           // ajax call get data from server and append to the div
           var pagenum=jQuery.trim($(".pagenum:last").val());
           //var rowcount=jQuery.trim($(".rowcount").val());
           //if(pagenum <= rowcount) {
           
           if(pagenum!=''){
            var pageNo=parseInt(pagenum) + 1;
            
            statusObjInit.getStockMoreData(pageNo);
           }
       //}
    }
});


function getStockResult() {
    var pagee=0;
    var ajax_doner = 0;
    var rlast=0;
    var ckhd = $('#car-Eligible').prop('checked');
    var ckhdd = $('#car-Premium').prop('checked');


    if (ckhd == true || ckhdd == true) {
        $('#removed,#all').hide();
        if (flag_elibring == 0) {
            flag_elibring = 1;
            $('#gaadi').click();

        }
    }
    else {
        $('#removed,#all').show();
        flag_elibring = 0;
    }
    if($('#tab_value').val()==''){
        $('#gaadi').addClass('active');
    }else if($('#tab_value').val()=='removed'){
        $('#removed').addClass('active');
    }else if($('#tab_value').val()=='all'){
        $('#all').addClass('active');
    }
    

    if ((ajax_doner == 0 && rlast == 0) || pagee == 0) {
        pagee++;
        
        if(pageNo=="" || typeof(pageNo)=='undefined'){
          var pageNo=1;
        }
        
        var rowcount=$('.rowcount:last').val();
        var data ="key=search&page="+pageNo+"&totcnt="+rowcount+"&"+$('#searchform').serialize();
        $('#checkall').prop('checked', false);
        $('.searchresultloader').show();
        $('#inventoryList').text('Loading...');
        $.ajax({
            type: 'POST',
            //async:false,
            url: base_url+"stock/getStockList",
            data: data,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
               
                getCounts(1);
                ajax_doner = 0;
                if (jQuery.trim(responseData)) {
                    $('.searchresultloader').hide();
                    $('div#loadmoreajaxloader').hide();
                    $('#inventoryList').html(responseData);
                    rlast = 0;
                }
                else if (pagee == 1) {
                    $('#inventoryList').html('');
                    $('#inventoryList').html("<div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div>");
                    //$('#checkactionbar').hide();
                    rlast = 1;
                    pagee = pagee - 1;
                }
                else {
                    $('#inventoryList').text('No More Results');
                    rlast = 1;
                    pagee = pagee - 1;
                }
                //alert('ww');
                $('.searchresultloader').hide();

                $('.tips').click(function () {

                    //alert(ids[1]);
                    //getToolTip(this.id);
                });
                

                
            }

        });

    }

    ajax_doner = 1;

}

var prev_ref='';
function getCounts(thsref)
{
var pagee=1;    
var data ="key=search&page="+pagee+"&"+$('#searchform').serialize();
$('.countloader').show();
$.ajax({
          type: 'POST',
          url: base_url+"stock/getStockCount",
          data: data,
          dataType: "json",
          success: function( result ) {
              //alert(result);
		  
		  if(prev_ref!='' && thsref!=1 && prev_ref!=result && $('#tab_value').val()!='all')
		  {
		  $(thsref).parent().parent().parent().hide();
		  }
		  prev_ref = result;
		  
           //var statsArr = result.split('||');
           
           $('.type_btn').eq(0).find('.badge').html(result['activeStock']);
           $('.type_btn').eq(1).find('.badge').html(result['refurbStock']);
           $('.type_btn').eq(2).find('.badge').html(result['bookedStock']);
           $('.type_btn').eq(3).find('.badge').html(result['totSoldStock']);
           $('.type_btn').eq(4).find('.badge').html(result['totRemoveStock']);
           $('.type_btn').eq(5).find('.badge').html(result['totStock']);
	   $('.countloader').hide();
		   }
		   });
}

$('#make').on('change', function () {
    var selected = $(this).val();
    $.ajax({
        type: 'POST',
        url: base_url+"stock/getModel",
        data: {make: selected},
        dataType: "html",
        success: function (responseData)
        {
            $('#model').html(responseData);
            $('#model').prop('disabled', false);

        }
    });
    });
  
  
  function sendSmsNewVersion(id, type = '',send_via='',customer_email,refresh='',car_id='')
    { 
           $('#success_stock').text('');
           $('#error_stock').text('');
           if(refresh=='refresh'){
        //alert();
           $('#li_car_details').addClass('active');
           $('#li_quotes').removeClass('active');
           $('#car_details_tab').addClass('active in');
           $('#quotes_tab').attr('class','tab-pane fade');
           
           $('#liemail').addClass('active');
           $('#stock_email').prop('checked',true);
           $('#lisms').removeClass('active');
           $('#email').addClass('active in');
           $('#sms').removeAttr('class');
           $('#sms').attr('class','tab-pane fade');
           }
           
           if(send_via=='message'){
           $('#lisms').addClass('active');    
           $('#liemail').removeClass('active');
           $('div#email').removeClass('active in');
           $('div#sms').addClass('active in');
           $('#email').removeAttr('class');
           $('#email').attr('class','tab-pane fade');   
           }
           if(send_via=='email'){
           $('.email-address').val('');
           $('#liemail').addClass('active');    
           $('#lisms').removeClass('active');
           $('div#sms').removeClass('active in');
           $('div#email').addClass('active in');
           $('#email').removeAttr('class');
           $('#email').attr('class','tab-pane fade');   
           }
           if(car_id){
            $('#car_id').val(car_id);
            }
            car_id=$('#car_id').val();
           $.ajax({
            type: 'POST',
            url: base_url+"stock/stock_email_sms",
            data: "mobile=" + id + "&message="+send_via+"&type=" + type+'&car_id='+car_id,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
               $('#stocksmsn').text(responseData);  
               
               
            }
        });
    }
    function sendSmsEmail(){
        
        var custoMobile       = $('#customer_Mobile').val();
        var custoEmail        = $('#emailId').val();
        var shareType         = $('.share_type').val();
        var regEmail          = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if(shareType =='sms'){
        if ((custoMobile) == "" || (custoMobile) == "Enter Mobile Number") {
         $('#error_stock').text('Please Enter Mobile Number');
         return false;
        }else if(!(/^[6-9]{1}[0-9]{9}$/.test($('.custoMobile').val()))){
            $('#error_stock').text('Please Enter Valid Mobile Number');
            return false;  
        }else{
            $('#error_stock').text('');
        }
        }
        if(shareType =='email'){
            
            if ((custoEmail) == "") {
             $('#error_stock').text('Please Enter Email Address');
             return false;
            }else if (!(regEmail.test($('.email-address').val()))) {
                $('#error_stock').text('Please Enter Valid Email Address');
                return false;
            }

            else{
                $('#error_stock').text('');
                //$('.close').trigger('click');
            }
        }
    
        
        $.ajax({
        type: 'POST',
        url: base_url+"stock/sms_email_send",
        data: $('#stocksms_form').serialize(),
        dataType: 'html',
        success: function (responseData, status, XMLHttpRequest) {
        if(responseData){
           snakbarAlert(responseData);
           $('#stocksmsEmail').modal('hide');
        }
        }
});
    };
    
    function loadQuotesModal()
    { 
       
        
        var car_id=$('#car_id').val();
          $.ajax({
            type: 'POST',
            url: base_url+"stock/viewQuotesForm",
            data: {'car_id':car_id},
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
               $('#quotes_tab').html(responseData);                 
               
            }
          });
    }
    function shareCarPriceQuotes(){
        
        var regEmail          = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        var regName          = /^[A-Za-z ]{3,30}$/;
        var cus_name = $('#quotes_cus_name').val();
        var cus_email = $('#quotes_cus_email').val();
        var km        = $('#quotes_km_driven').val();
        var price = $('#quotes_car_price').val();
        if(cus_name==''){
           $('#quotes_form_error').text('Please Enter Customer Name'); 
           return false;
        }
        if(!(regName.test(cus_name))){
           $('#quotes_form_error').text('Please Enter Valid Customer Name'); 
           return false;
        }
        else if(cus_email==''){
           $('#quotes_form_error').text('Please Enter Customer Email'); 
           return false;
        }
        else if(!(regEmail.test(cus_email))){
           $('#quotes_form_error').text('Please Enter Valid Customer Email'); 
           return false;
        }
        else if(km=='' || km==0){
           $('#quotes_form_error').text('Please Enter Km Driven'); 
           return false;
        }
        else if(price=='' || km==0){
           $('#quotes_form_error').text('Please Enter Car Price'); 
           return false;
        }
        $.ajax({
        type: 'POST',
        url: base_url+"stock/shareCarPriceQuotes",
        data: $('#price_quotes_form').serialize(),
        dataType:'json',
        success: function (responseData, status, XMLHttpRequest) {
            $('#quotes_form_error').text('');
             window.location=base_url+"stock/downloadQuotesPdf/?file="+responseData.file_name;
            }
        });
    };
    function downloadBookingForm(car_id,type){
        $.ajax({
        type: 'POST',
        url: base_url+"stock/bookingForm",
        data: {car_id,type},
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
               window.location=base_url+"stock/downloadBookingPdf/?file="+responseData.file_name+"&type="+responseData.type;
             }
            }
        });
    }

 
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
 function makeFeature (id,type,carId){
         $.ajax({
                type: "POST",
                url: base_url+"stock/getFeaturehtml",
                data: {carId:carId,type:type},
                dataType: "html",
                success: function (responseData) {
                    //alert(responseData);
                   $('#featurediv').html(responseData); 
                }
                    
                })
    }
    
function addRemoveFeature (id,type,carId){
         $.ajax({
                type: "POST",
                url: base_url+"stock/getAddRemovehtml",
                data: {carId:carId,type:type},
                dataType: "html",
                success: function (responseData) {
                    //alert(responseData);h
                   $('#featurediv').html(responseData); 
                }
                    
                })
    }    
function make_premium() {
        var sold_price = $.trim($('#sold_price').val());
        var type = $.trim($('#type').val());
        if (type == 'sold') {
            if (isNaN(sold_price) && sold_price != '')
            {
                // $('#spnDealerPrice').text('Please enter a valid Price.');
                alert('Please enter a valid Price.');
                //$('#spnDealerPrice').css('display','block');
                var eerror = true;
            } else
            {
                // $('#spnDealerPrice').css('display','none');
                var eerror = false;
            }
        } else {
            var eerror = false;
        }


        if (eerror == false)
        {
            var formData=$('#blukpremium').serialize();
          // $('.makepremiumcancel').prev().html('Please Wait...').css('color','red');
          $('.searchresultloader').show();
            $.ajax({
                type: "POST",
                url: base_url+"stock/makeFeature",
                data: formData,
                dataType: 'json',
                success: function (responseData, status, XMLHttpRequest) {
                    //$('.premiumloader').hide();
                    $('.searchresultloader').hide();
                    snakbarAlert(responseData.message);
                    //$('.makepremiumcancel').prev().html('Action performed successfully - Thank You!');
                    var t = setTimeout(function () {
                        $('.makepremiumcancel').click();
                        $('#stockFeature').hide();
                        getStockResult();
                    }, 2000);
                }
            })
        }
    }
    
    function addStock(){
       var formData=$('#stockfeature_form').serialize();
            $('.premiumloader').show();
            $.ajax({
                type: "POST",
                url: base_url+"stock/addtostock",
                data: formData,
                dataType: "html",
                success: function (responseData, status, XMLHttpRequest) {
                    $('.premiumloader').hide();

                    $('.makepremiumcancel').prev().html('Action performed successfully - Thank You!');
                    var t = setTimeout(function () {
                        $('.makepremiumcancel').click();
                        $('#stockFeature').hide();
                        getStockResult();
                    }, 2000);
                }
            }) 
    }
    
    function saveRetailPrice(id){
        
        var textBoxValue = $("#edit_retail_price_"+id).val().replace(/,/g, '');
        var textBoxValueNew=$("#edit_retail_price_"+id).val();
        //dealerPrice = parseInt($("#edit_dealer_price_"+id).val());
        if(textBoxValue==''){
            snakbarAlert('Please Enter a Value');
        }else if(isNaN(textBoxValue) || textBoxValue <10000){
            snakbarAlert('Price Should not be less than Rs 10,000');
        }
        /*else if(dealerPrice>=textBoxValue){
           // alert('Retail Price Should Be Greater Than Dealer Price');
        }*/
        else{
            $.ajax({
                type: "POST",
                url: base_url+"stock/addEditInventoryList",
                data: {option:'addEditPrice',priceType:'retail','car_id':id,'priceVal':textBoxValue},
                dataType:"html",
                success:function (responseData) {
                     
                    var myObject = eval('(' + responseData + ')');     
                    if(myObject.status=='true'){
                       $('.pricetag').show();
                       $('#search').trigger('click');
                        snakbarAlert(myObject.msg);
                        $("#edit_retail_price_"+id).val(textBoxValueNew);
                        $(".editretalPriceDiv_"+id).hide();
                        $("#show_retail_price_"+id).html(myObject.short_price_format);
                    }else{
                        snakbarAlert(myObject.msg);
                        
                    }                 
                    
                }
            });
        }
    }
    function addCommasdealer(nStr)
        {
            //nStr=nStr.replace(/,/g,''); 
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{2})/;
            var len;
            var x3 = "";
            len = x1.length;
            if (len > 3) {
                var par1 = len - 3;

                x3 = "," + x1.substring(par1, len);
                x1 = x1.substring(0, par1);

                //alert(x3);
            }
            len = x1.length;
            if (len >= 3 && x3 != "") {
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');

                }
            }
            return '<i class="fa fa-inr"></i> ' + x1 + x3 + x2;
        }
        function addCommas(nStr,control,flag='')
{
 // alert(nStr);
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
  $('#'+control).val(x1 +x3+x2);
       // document.getElementById(control).value=x1 +x3+x2;
}
    function popupMsgShow($car_id){
       $("#hoverCID"+$car_id).show();
    }
    function popupMsgHide($car_id){
        $("#hoverCID"+$car_id).hide();
    }
    
    function changeCheckboxVal(car_id, checkValue,totalClassified,inventoryToList,featured)
    { 
        
     $('#clss_modal').html('<button name="btnSubmit" type="button" id="classifiedList_'+car_id+'" class="btn btn-primary" >Submit</button> ');
       $('#model-classified').modal('show');
        $("#classifiedList_"+car_id).show();
        $(".limitExausted").html('');
        $("#sureMsg").html('');
        $("#showMsg").html('');
        
        if (checkValue == '1')
        {   
            var Value = '0';
            //$("#sureMsg").html('<span class="col-gray mrg-T0 font-16 mrg-B0">Are You sure?</span>');
			if(featured=="1")
			{
				$("#showMsg").html('<p  class="col-b font-14">You want to remove this car from classified list.<br>This car will be removed from featured list as well.</p>');
			}
			else
			{
				$("#showMsg").html('<p  class="col-b font-14">You want to remove this car from classified list</p>');
			}
        } else
        {
            if(inventoryToList=='0')
                {
                    $(".limitExausted").html("<p class='edit-text font-16'>You are not subscribed to Classified Listing package. <br>Please contact your sales executive to get it activated.</p>");
                    $("#classifiedList_"+car_id).hide();

                }
             else if(totalClassified==inventoryToList && inventoryToList>'0')
            {
                
                
                    $(".limitExausted").html("<p class='edit-text font-16'>Classified inventory upload limit exhausted <br>"+" To add more inventory remove some Classified inventory by unchecking.</p>");
                
                    $("#classifiedList_"+car_id).hide();
            }
            else{
            var Value = '1';
            //$("#sureMsg").html('<h2 class="col-gray mrg-T0 mrg-B0">Are You sure?</h2>');
            $("#showMsg").html('<p  class="edit-text font-14">You want to add this car to classified list</p>');
            }
        }

        $('#cancelCheckBox,#xClose').click(function () {
            if (checkValue == '1')
            {
                $("#classified" + car_id).prop("checked", true);
            } else
            {
                $("#classified" + car_id).prop("checked", false);
            }

        });
        
        //var session_token='<?=$_SESSION["Auth-Token"]?>';
        $('#classifiedList_'+car_id).click(function () {
            $.ajax({
                type: "POST",
                url: base_url+"stock/addClassified" ,
                data: {checkValue: Value,car_id:car_id},
                dataType: "html",
                success: function (responseData) {
                    if (responseData == 1) {
                        $(".success").text('Action Performed successfully');
                        var t = setTimeout(
                                function () {
                                    //pagee = 0;
                                    getStockResult();
                                }, 1000);

                        setTimeout(
                                function () {
                                    $(".success").html('');
                                    $('#model-classified').modal('hide');
                                }, 2000);
                    }
                    if(responseData == 0){
                         $(".err-classified").text('Classified limit Exausted!');
                         setTimeout(
                                function () {
                                    $(".err-classified").html('');
                                    $('#model-classified').modal('hide');
                                }, 1800);
                    }
                    
                }
            });
        });

        /*}*/
    }
    
    function deleteStock(car_id){
        var type='sold';
        $.ajax({
                type: "POST",
                url: base_url+"stock/getStockDelete",
                data: {type: type,car_id:car_id},
                dataType:"html",
                success:function (responseData) {
                     jQuery('#model-mark_as_Sold').modal('show');
                     $('#soldmodal').html(responseData);
                    //alert(responseData);
                                  
                    
                }
            });
    }
    
    
    
    function mark_as_sold() {
        var sold_price = $.trim($('#sold_price').val());
        var type = $.trim($('#type').val());
        var reson=$.trim($('input[name="reason"]:checked').val());
        
	
	var mobile=$.trim($('#cust_mobile').val());
        var name=$.trim($('#cust_name').val());
        var sold_price=$.trim($('#sold_price').val());
        $('.soldcancel').prev().prev().html(''); 
        var eerror = false;
        if(reson == '')
        {
                snakbarAlert('Please Select A Reason To Remove The Car');
                var eerror = true;
        }
            
            
        if (eerror == false)
        {
         var formData=$('#bluk_new').serialize();
            //$('.soldloader').show();
            $.ajax({
                type: "POST",
                url: base_url+"stock/marktosold",
                data: formData,
                dataType: 'json',
                success: function (responseData, status, XMLHttpRequest) {
                    //$('.soldloader').hide();
                    $('#model-mark_as_Sold').modal('hide');
                    snakbarAlert(responseData.msg);
                        getStockResult();
                    
                }
            })
        }
    }
    
    function forceNumber(event) {
        var keyCode = event.keyCode ? event.keyCode : event.charCode;
        if ((keyCode < 48 || keyCode > 58) && keyCode != 188 && keyCode != 8 && keyCode != 127 && keyCode != 13 && keyCode != 0 && !event.ctrlKey)
            return false;
    }
    
    
   
  function hideshowshowDiv(elem){
      $('#leadinfo_name').hide();
      $('#leadinfo_mobile').hide();
   if(elem.value == 1)
   {
      $('#submitbluk').hide();
      $("#sold_price_div").hide();
      $('#soldpricediv').show();
      $('#searchdiv').show();
      document.getElementById("changetitle").innerHTML = "Select the person who bought the car";
      
      
  }
  else
  {
          $('#search_customer').val('');
          $('#soldpricediv').hide();
          $('#nofound').hide();
	  //document.getElementById('soldpricediv').style.display = "none";
	  document.getElementById("changetitle").innerHTML = "Select a reason for removing the car";
	 // document.getElementById('changetitle').val("Select Reason of car remove") ;
         $('#submitbluk').show();
  }
}

$("#car_id_reg_no").autocomplete({
    source: function (request, response) {
        // alert('ok test');return false;
        $.ajax({
            url: base_url+"stock/getMakeModelWithRegNo",
            dataType: "json",
            data: {
                term: request.term,
                //	sid: jQuery('#car_id_reg_no').val(),                  
            },
            //alert(data);return false;
            success: function (data) {
                console.log(data);
                response(data);
            }
        });
    },
    minLength: 2,
    select: function (event, ui) {
        //console.log(ui.item.key);
        
       $('#selected_mmv_car_id').val(ui.item.key);  
    }
});
$('#car_id_reg_no').keyup(function(e){
   if(e.keyCode==8 && this.value==''){
       $('#selected_mmv_car_id').val('');
   }
});
   
   
$('#imageuploadFeature').click(function () {
                $('#stockFeature').hide();
        });

 $(document).ready(function () {
    

 getStockResult();   
 

 });
 

 jQuery(document).on('click','#addbuylead',function(event){
          $('#leadinfo_name').show();
          $('#leadinfo_mobile').show();
          $('#search_customer').val('');
          $('#searchdiv').hide();
          //$('#soldpricediv').hide();
          $('#nofound').hide();
          $('#sold_price_div').show();
          $('#submitbluk').show();
	 
     
  });
     
     (function ($) {
    jQuery(document).on('keyup','#search_customer',function(event){
                
                $('#submitbluk').hide();
                
      $('#search_customer').autocomplete({
        // minChars: 1,
        source: function( request, response ) {
        $.ajax({
          type:"POST",
          url: base_url+"stock/getBuyCustomer",
          dataType: "json",
          data: {
            term: request.term
          },
          success: function( data ) {
               $('#cust_mobile').val('');
               $('#cust_name').val('');
            //response( data );
            response($.map(data, function (item) {
                if(item.id){
                $("#sold_price_div").show();
                $('#submitbluk').show();
                $('#nofound').hide();
           //$('#stockHtml').empty().append(ui.item.html);
            }
            if(item.html){
            $("#sold_price_div").hide();
            $('#nofound').show();
            $("#sold_price_div").hide();
            $('#nofound').empty().append(item.html);
            }
            return {
                //label: item.name,
                id: item.id,
                value: item.value,
                html: item.html,
                mobile: item.mobile,
                name: item.name
                
                };
            }));
          }
        });
      },
       // source: base_url+"stock/getBuyCustomer",
        minLength: 2,
        select: function (event, ui) {
             console.log(ui);
           if(ui.item.id){
                $("#sold_price_div").show();
                $('#submitbluk').show();
                $('#cust_mobile').val(ui.item.mobile);
                $('#cust_name').val(ui.item.name);
                $('#nofound').hide();
           //$('#stockHtml').empty().append(ui.item.html);
            }
            if(ui.item.html){
            $("#sold_price_div").hide();
            $('#nofound').show();
            $("#sold_price_div").hide();
            $('#nofound').empty().append(ui.item.html);
            }
            //sold_price_div
          
         },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
      });

  });

 })(jQuery);
 
 
 