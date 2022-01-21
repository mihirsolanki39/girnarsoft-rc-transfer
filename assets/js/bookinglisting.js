/*$('#search').click(function (event) {
        var formData=$('#searchform').serialize();
        $('#page').val('1');
        $('#imageloder').show();
        var formDataSearch=$('#searchform').serialize();
        $.ajax({
            type: 'POST',
            url: base_url+"DeliveryOrder/bookingListingCase",
            data: formDataSearch,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
            if (responseData == 1) {
            $('#imageloder').hide();
            $('#loancases').html("<tr><td align='center' colspan='6'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
            } else {
            $('#imageloder').hide();
            $('#loancases').html(responseData);
            }
            }
        });
    });*/

$('#search').click(function (event) {

        $('#page').val('1');
       var formData=$('#searchform').serialize();
       var srchdate=$('#searchdate').val(); 

         var createDate = $('#daterange_to').val();
         var endDate    = $('#daterange_from').val();
         
          var d=createDate.split("-");
          var newcreateDate=d[2]+"-"+d[1]+"-"+d[0];

          var d1=endDate.split("-");
          var newendDate=d1[2]+"-"+d1[1]+"-"+d1[0];

          if(newcreateDate > newendDate){
              alert("Please Select Valid Date");
              return true;
          }
         
       /*if(srchdate!=''){
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
          if(newcreateDate > newendDate){
              alert("Please Select Valid Date");
              return true;
          }
      }*/



     $("#all").trigger('click');
    $('#page').val('1');
    $('#imageloder').show();
    var formDataSearch=$('#searchform').serialize();
       //alert(formData);
        $.ajax({
            type: 'POST',
            url: base_url+"DeliveryOrder/bookingListingCase",
            data: formDataSearch,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
            //alert(responseData);
            var resr = responseData.split('####@@@@@');
           // alert(resr[0]);
            if (resr[1] == 1) {
            var resrtype = resr[0].split('--');
            //alert(responseData);
            $('#total_count').text('('+"0"+')');
 
            $('#loancases').html("<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
            } else {

            var resrtype = resr[0].split('--');
            $('#loancases').html(resr[1]);
            }
          
            }
    });
    });

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
       /* $(document).ready(function(){
            $('#search').trigger('click');
            $(window).scroll(function () {
            if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
            start = $('#page').val();
            start++;
            //alert("sss");
            if (jQuery.trim(jQuery('.jtdtext').text()) != 'No record found.')
            {
            $('#loadmoreajaxloader').text('Loading...');
            $('div#loadmoreajaxloader').show();
            }
            $('#page').attr('value', start);
            var formDataload=$('#searchform').serialize();
            $.ajax({
            type: 'POST',
                    url: base_url+"DeliveryOrder/bookingListingCase",
                    data: formDataload,
                    dataType: 'html',
                    success: function (responseData, status, XMLHttpRequest) {

                    $('#page').attr('value', start);
                    var html = $.trim(responseData);
                    if (parseInt(html) != 1) {

                    $('table.myLoantbl  tr:last').after(html);
                    }
                    else if (parseInt(html) == 1) {

                    start--;
                    $('#page').attr('value', start);
                    $('#loadmoreajaxloader').text('No More Results');
                    }
                    }
            });
            }
    });
        });*/