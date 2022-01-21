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
          console.log(newcreateDate +' > '+ newendDate);
//          if(newcreateDate > newendDate){
//              alert("Please Select Valid Date");
//              $('#imageloder').hide();
//              $('#daterange_to').val('');
//              $('#daterange_from').val('');
//              return true;
//          }
        }
        $.ajax({
            type: 'POST',
            url: base_url+"Finance/loanListing/",
            data: formDataSearch,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
            if (responseData == 1) {
                 $('#total_count').text('('+"0"+')');
            $('#imageloder').hide();
            $('#loancases').html("<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
            } else {
            $('#imageloder').hide();
            $('#loancases').html(responseData);
           
            }
             footerBottom();
            }
        });
    });
       /* $(document).ready(function(){
            $('#search').trigger('click');
            $(window).scroll(function () {
            if (parseInt($(window).scrollTop()) == (parseInt($(document).height()) - parseInt($(window).height()))) {
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
                    url: base_url+"Finance/loanListingCase",
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