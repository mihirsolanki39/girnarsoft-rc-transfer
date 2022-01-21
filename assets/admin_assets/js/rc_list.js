$('#search').click(function (event) {
       var formData=$('#searchform').serialize();
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
      }
    $('#page').val('1');
    $('#imageloder').show();
    var formDataSearch=$('#searchform').serialize();
        $.ajax({
            type: 'POST',
            url: base_url+"RcCase/ajax_getrc/3",
            data: formDataSearch,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
                $('#imageloder').hide();
                $('#buyer_list').html(responseData);
                footerBottom();
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
            url: base_url+"RcCase/ajax_getrc",
            data: formData,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
            //alert(responseData);
            var resr = responseData.split('####@@@@@');
            if (resr[1] == 1) {
            var resrtype = resr[0].split('--');
            //alert(responseData);
            $('#imageloder').hide();
             $('#total_count').text('(0)');
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
    if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
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
            url: base_url+"RcCase/ajax_getrc",
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
    });
    $(document).on('click','#Reset', function (ev) {
      location. reload(true); 
    });
    $(document).on('click', '.history-more', function (ev) {
        getHistory(ev);

    })
    
});*/
    $(document).on('click', '.history-more', function (ev) {
        getHistory(ev);

    })
    function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
function getHistory(ev){
    var ths = ev.currentTarget;
    this.rcId = $(ths).attr('data-id');
    if (this.rcId) {
        $.post(base_url+"RcCase/get_history", {
            rc_id: this.rcId,
        }, function (data) {
            if(data!='Sorry request not valid'){
            $('#rcHistory').empty();
            $('#rcHistory').append(data);
        }
        else {
            //alert('Sorry request not valid');
            snakbarAlert('Sorry request not valid');
        }
            
        }, 'html');
    } else {
        //alert('sorry view more id is blank');
        snakbarAlert('sorry view more id is blank');
    }
}
function bankList()
{
    $.ajax({
    type : 'POST',
    url : base_url + "Finance/getBankList/",
    dataType: 'html',
    success: function (response) 
    { 
       $('.abc3').attr('style','display:block;');
       $('.abc3').html(response);

    }
    });
}
function searchby(eve='',e='') {
        if(eve!='') {
               var id = $(eve).attr('id');
               $('#searchby').val(id);
               if(id=='searchbank')  {
                  $("#keyword").css("display","none");
                  $("#searchbyvalbank").css("display","block");
                   $("#agentrto").css("display","none");
                  bankList();
               }
               else if(id=='searchrtoagent')  {
                  $("#keyword").css("display","none");
                   $("#searchbyvalbank").css("display","none");
                  $("#agentrto").css("display","block");
               }
               else {
                  $("#keyword").css("display","block");
                  $("#searchbyvalbank").css("display","none");
                   $("#agentrto").css("display","none");
                  $('.abc2').removeAttr("readonly");
                  $('.abc2').val('');
               }
            }
            else {
               var id = $(e).attr('id');
               $('#createStartDate').val('');
               $('#createEndDate').val('');
               $('#searchdate').val(id);

            }
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
      function countinue(action)
      {
         window.location.href = action;
      }
     
