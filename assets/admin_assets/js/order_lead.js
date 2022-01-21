$('#search').click(function (event) {
 // alert('hi');
       var formData=$('#searchform').serialize();
       //alert(formData);
       //var clickenter= $('#type').val();
      var srchdate=$('#searchdate').val(); 
      if(srchdate!=''){
         var createDate= $('#createStartDate').val();
         var endDate= $('#createEndDate').val();
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
          if(newcreateDate > newendDate){
              alert("Please Select Valid Date");
              return true;
          }
      }
     $("#all").trigger('click');
    $('#page').val('1');
    $('#imageloder').show();
    var formDataSearch=$('#searchform').serialize();
       //alert(formData);
        $.ajax({
            type: 'POST',
            url: base_url+"DeliveryOrder/ajax_getdelivery",
            data: formDataSearch,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
            //alert(responseData);
            var resr = responseData.split('####@@@@@');
            //alert(resr[0]);
            if (resr[1] == 1) {
            var resrtype = resr[0].split('--');
            //alert(responseData);
            $('#imageloder').hide();
            $('#total_count').text('('+"0"+')');
 
            $('#buyer_list').html("<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
            } else {

            var resrtype = resr[0].split('--');
            //alert(responseData);
            $('#imageloder').hide();
            $('#buyer_list').html(resr[1]);
            }
          
            }
    });
    });
    
      
    
 $(".typeq").click(function () {
     $('#searchtype').val('search');
    $('#imageloder').show();
    var elm = $(this);
    var type = elm.attr('id');
    $('#type').attr('value', type);
    $('#page').val('1');
    var formData=$('#searchform').serialize();
    //alert(formData);
    $.ajax({
    type: 'POST',
            url: base_url+"DeliveryOrder/ajax_getdelivery",
            data: formData,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
            //alert(responseData);
            var resr = responseData.split('####@@@@@');
            if (resr[1] == 1) {
            var resrtype = resr[0].split('--');
            //alert(responseData);
            $('#imageloder').hide();
            $('#buyer_list').html("<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
            } else {
            var resrtype = resr[0].split('--');
            //alert(responseData);
            $('#imageloder').hide();
            $('#buyer_list').html(resr[1]);
            }
            }
    });
    });

jQuery(function(){
 jQuery('#crateddate_from').datetimepicker({
  format:'d/m/Y',
  onShow:function( ct ){
   this.setOptions({
    maxDate:jQuery('#crateddate_to').val()?jQuery('#crateddate_to').val():false
   });
  },
  timepicker:false,
  scrollMonth:false,
  scrollTime:false,
  scrollInput:false
 });
 jQuery('#crateddate_to').datetimepicker({
  format:'d/m/Y',
  onShow:function( ct ){
   this.setOptions({
    minDate:jQuery('#crateddate_from').val()?jQuery('#crateddate_from').val():false
   })
  },
  timepicker:false,
  scrollMonth:false,
  scrollTime:false,
  scrollInput:false
 });
});


/*$(document).ready(function () {
   $('#search').trigger('click'); 
   $(window).scroll(function () {
    if (parseInt($(window).scrollTop()) == (parseInt($(document).height()) - parseInt($(window).height()))) {
    start = $('#page').val();
    start++;
    if (jQuery.trim(jQuery('.jtdtext').text()) != 'No record found.')
    {
    $('#loadmoreajaxloader').text('Loading...');
    $('div#loadmoreajaxloader').show();
    }
    $('#page').attr('value', start);
    var formDataload=$('#searchform').serialize();
    $.ajax({
    type: 'POST',
            url: base_url+"DeliveryOrder/ajax_getdelivery",
            data: formDataload,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {

            $('#page').attr('value', start);
            var html = $.trim(responseData);
            var resr = html.split('####@@@@@');
            if (parseInt(resr[1]) != 1) {

            $('table.mytbl  tr:last').after(resr[1]);
            }
            else if (parseInt(resr[1]) == 1) {

            start--;
            $('#page').attr('value', start);
            $('#loadmoreajaxloader').text('No More Results');
            }
            }
    });
    }
    });*/
    $(document).on('click','#Reset', function (ev) {
      location. reload(true); 
    });
    $(document).on('click','.updateleadinquiry', function (ev) {
        var buttinId= $(this).attr('id');
        var splitbid=buttinId.split("_");
        var id=splitbid[1]; 
        var customer_id     =id;
        var status          =$('#status_'+id).val();
        var comment         =$('#comment_'+id).val();
        var follow_up       =$('#follow_up_'+id).val();
        var mobile          =$('#'+buttinId).attr('data-mobile');
        var prevStatusId     =$('#prevStatusId_'+id).val();
        var prevFollowup     =$('#prevFollowup_'+id).val();
        
        var oldFollowUP = new Date(follow_up);
       $newFollowUp = new Date();
       $newFollowUp.setDate($newFollowUp.getDate());
       checkFollowUP=true;
       if(oldFollowUP < $newFollowUp){
       checkFollowUP=false;
       }
       if(oldFollowUP == prevFollowup){
        checkFollowUP=false;
       }
       if(!follow_up){
           snakbarAlert('please select followup date.');
           return false;
       } 
       else if (checkFollowUP==false && (status !=1)){
            snakbarAlert('please select future followup date and time.');
              return false;
       }
         var typered=$('#type').val();
            $.post(base_url+"insurance/ajax_save_inquiry", {
            customer_id           : customer_id, 
            mobile                : mobile,
            follow_up             : follow_up,
            comment               : comment,
            status                : status,
            type                  : typered,
            update                : 'update' 
            
            }, function (data) {
               if(parseInt(data)>0){
               snakbarAlert('User Data Added Sucessfully');
               $('#search').trigger('click');
            }
            else {
                snakbarAlert('Sorry request not valid');
            }

            }, 'html');
            
        //inqObj.getSearchData();
        
       
    })
//});


function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
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
function searchby(eve='',e='')
        {
          //alert(eve);
          $('#keyword').val('');
        if(eve!='')
            {
               var id = $(eve).attr('id');
              // alert(id);
               $('#searchby').val(id);
               $('.abcs').attr('style','display:none !important;');
               if(id=='searchdealername')
               {
                  $('.abc1').attr('style','display:block;');
                   dealerList();
               }
               else if(id=='searchcustname')
               {
                  $('#keyword').attr('onkeypress','return nameOnly(event)');
                  $('#keyword').attr('maxlength','50');
                  $('.abcs').attr('style','display:block;');
                  $('.abc1').attr('style','display:none;');
                  $('.abc2').attr('style','display:none;');
               }
               else
               {
                  $('#keyword').attr('onkeypress','return isNumberKey(event)');
                  $('#keyword').attr('maxlength','10');
                  $('.abcs').attr('style','display:block;');
                  $('.abc1').attr('style','display:none;');
                  $('.abc2').attr('style','display:none;');
               }
               
               
            }
            else
            {
               var id = $(e).attr('id');
               $('#searchdate').val(id);
               $('.new_input').prop("disabled", false);
            }
        }
        function dealerList()
        {
           $.ajax({
           type : 'POST',
           url : base_url+"Insurance/getDealerList",
           dataType: 'html',
           success: function (response) 
           { 
              $('.abcs').attr('style','display:none !important;');
              $('.abc1').attr('style','display:block;');
              $('.abc1').html(response);

           }
           });
        }
        function insurerList()
        {
           $.ajax({
           type : 'POST',
           url : base_url+"Insurance/getInsurerSearchList",
           dataType: 'html',
           success: function (response) 
           { 
              $('.abc2').attr('style','display:block;');
              $('.abc2').html(response);

           }
           });
        }
        
        function reopen(customerId,link){
         var r = confirm("Do You Want to Reopen this Case?");
            if (r == true)
            {
                $.ajax({
                  type : 'POST',
                  url : base_url+"Insurance/reopenCase",
                  data : {customerId:customerId},
                  dataType: 'html',
                  success: function (response) 
                  { 
                     setTimeout(function(){ window.location.href = link; }, 3000);
                  }
               });
            } 
         }
   /* function renderpdfdo(orderId,dealerid){
       
         window.top.location.href = base_url+"DeliveryOrder/getpdf/" + orderId+'/'+dealerid; 
        
     }*/
 function renderpdfdo(orderId,dealerid){
$.ajax({
        type: 'POST',
        url: base_url+"DeliveryOrder/getpdf",
        data: {orderId:orderId,dealerid:dealerid},
        dataType:'json',
        beforeSend:function(){
            $('.searchresultloader').show();
             snakbarAlert('Please Wait While PDF Is Getting Downloaded');
        },
        success: function (responseData, status, XMLHttpRequest) {
          console.log(responseData);
            $('#quotes_form_error').text('');
             $('.searchresultloader').hide();
            snakbarAlert(responseData.message);
             if(responseData.status){
               window.location=base_url+"DeliveryOrder/downloadBookingPdf?file="+responseData.file_name; 
             }
            }
        });
}