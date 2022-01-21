 //$('#search').click(function (event) {
     $(document).on('click','#search',function(event){
         
       var formData=$('#searchform').serialize();
       //alert(formData);
        //$('#type').attr('value', 'all');
        var clickenter= $('#type').val();
        $('#btn_lead_assign').hide();
        if(clickenter=='all'){ 
                //alert( 'human' );
                jQuery("#all").trigger('click');
                
               // return false;
                
            } 
         else if ( event.originalEvent === undefined) 
            {
               // alert( 'not human' )
            }
       
        else {
               // alert( 'human' );
                jQuery("#all").trigger('click');
               // return false;
            }
        
           // $("#all").trigger('click');
    
    $('#page').val('1');
    $('#imageloder').show();
    var formDataSearch=$('#searchform').serialize();
       var lasturl = $('#lasturl').val();
       var today = new Date();
      var dd = String(today.getDate()).padStart(2, '0');
      var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
      var yyyy = today.getFullYear();

      today = dd + '/' + mm + '/' + yyyy;
      daystart = '01/'+mm+'/'+yyyy;
      //document.write(today);
       if(lasturl=='1')
       {
          $('#crateddate_from').val(daystart);
          $('#crateddate_to').val(today);
         // $('#search').trigger('click');
       }
       if(lasturl==2)
       {
        $('#todayworks').attr('Checked','Checked');
       }
          $.ajax({
            type: 'POST',
            url: base_url+"lead/ajax_getLeads",
            data: formDataSearch,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
            //alert(responseData);
            $('#btn_lead_assign').show();
            if(lasturl==2)
             {
             // alert('ggg');
              $('#todayworks').attr('Checked','');
             }
            var resr = responseData.split('####@@@@@');
            if (resr[1] == 1) {
            var resrtype = resr[0].split('--');
            //alert(responseData);
            $('#noactionnew').text($.trim(resrtype[0]));
            $('#todayfollownew').text(resrtype[1]);
            $('#pastfollownew').text(resrtype[2]);
            $('#futurefollownew').text(resrtype[3]);
            $('#allnew').text(resrtype[4]);
            $('#closednew').text(resrtype[5]);
            $('#convertednew').text(resrtype[6]);
            $('#futuredatefollownew').text(resrtype[7]);
            $('#imageloder').hide();
            $('#buyer_list').html("<tr><td align='center' colspan='6'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
            } else {

            var resrtype = resr[0].split('--');
            //alert(responseData);

            $('#noactionnew').text($.trim(resrtype[0]));
            $('#todayfollownew').text(resrtype[1]);
            $('#pastfollownew').text(resrtype[2]);
            $('#futurefollownew').text(resrtype[3]);
            $('#allnew').text(resrtype[4]);
            $('#closednew').text(resrtype[5]);
            $('#convertednew').text(resrtype[6]);
            $('#futuredatefollownew').text(resrtype[7]);
            //$('#type_count').html(resr[0]);
            $('#imageloder').hide();
            $('#buyer_list').html(resr[1]);
            }
           var tabtype=$('#filter_data_type').val();
            
                    if(tabtype=='allleads'){
                        $('#closed').css("display","block");
                        $('#converted').css("display","block");
                        $('#followfuturedate').css("display","block");
                    }else{
                        $('#closed').css("display","none");
                        $('#converted').css("display","none");
                        $('#followfuturedate').css("display","none");
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
            url: base_url+"lead/ajax_getLeads",
            data: formData,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
            //alert(responseData);
            var resr = responseData.split('####@@@@@');
            if (resr[1] == 1) {
            var resrtype = resr[0].split('--');
            //alert(responseData);

            $('#noactionnew').text($.trim(resrtype[0]));
            $('#todayfollownew').text(resrtype[1]);
            $('#pastfollownew').text(resrtype[2]);
            $('#futurefollownew').text(resrtype[3]);
            $('#allnew').text(resrtype[4]);
            $('#closednew').text(resrtype[5]);
            $('#convertednew').text(resrtype[6]);
            $('#futuredatefollownew').text(resrtype[7]);
            $('#imageloder').hide();
            $('#buyer_list').html("<tr><td align='center' colspan='6'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
            } else {
            var resrtype = resr[0].split('--');
            //alert(responseData);

            $('#noactionnew').text($.trim(resrtype[0]));
            $('#todayfollownew').text(resrtype[1]);
            $('#pastfollownew').text(resrtype[2]);
            $('#futurefollownew').text(resrtype[3]);
            $('#allnew').text(resrtype[4]);
            $('#closednew').text(resrtype[5]);
            $('#convertednew').text(resrtype[6]);
            $('#futuredatefollownew').text(resrtype[7]);
            //$('#type_count').html(resr[0]);
            $('#imageloder').hide();
            $('#buyer_list').html(resr[1]);
            }
                var tabtype=$('#filter_data_type').val();
            
                    if(tabtype=='allleads'){
                        $('#closed').css("display","block");
                        $('#converted').css("display","block");
                        $('#followfuturedate').css("display","block");
                    }else{
                        $('#closed').css("display","none");
                        $('#converted').css("display","none");
                        $('#followfuturedate').css("display","none");
                    }
            
            }
    });
    });
 $(".used__car-advancesrch").click(function(){
    $(this).parents(".advnce").next().toggleClass("hidden");
    $(this).find('i').toggleClass("fa-angle-down fa-angle-up");   
    });
    
     
jQuery(function(){
 jQuery('#crateddate_from').datetimepicker({
  format:'d/m/Y',
  onShow:function( ct ){
   this.setOptions({
     maxDate:'today',
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
     maxDate:'today',
    //minDate:jQuery('#crateddate_from').val()?jQuery('#crateddate_from').val():false
   })
  },
  timepicker:false,
  scrollMonth:false,
  scrollTime:false,
  scrollInput:false
 });
});

jQuery(function(){
 jQuery('#updatedaterange_follow_from').datetimepicker({
  format:'d-m-Y',
  onShow:function( ct ){
   this.setOptions({
   //  maxDate:'today',
    //maxDate:jQuery('#updatedaterange_follow_to').val()?jQuery('#updatedaterange_follow_to').val():false
   })
  },
  timepicker:false
 });
 jQuery('#updatedaterange_follow_to').datetimepicker({
  format:'d-m-Y',
  onShow:function( ct ){
   this.setOptions({
    // maxDate:'today',
   // minDate:jQuery('#updatedaterange_follow_from').val()?jQuery('#updatedaterange_follow_from').val():false
   })
  },
  timepicker:false,
  scrollMonth:false,
  scrollTime:false,
  scrollInput:false
 });
});

jQuery(function(){
 jQuery('#updatedaterange_from').datetimepicker({
  format:'d/m/Y',
  onShow:function( ct ){
   this.setOptions({
    maxDate:jQuery('#updatedaterange_to').val()?jQuery('#updatedaterange_to').val():'today',
   })
  },
  timepicker:false,
  scrollMonth:false,
  scrollTime:false,
  scrollInput:false
 });
 jQuery('#updatedaterange_to').datetimepicker({
  format:'d/m/Y',
  onShow:function( ct ){
   this.setOptions({
    minDate:jQuery('#updatedaterange_from').val()?jQuery('#updatedaterange_from').val():'today',
   });
  },
  timepicker:false,
  scrollMonth:false,
  scrollTime:false,
  scrollInput:false
 });
});


 

        $(document).ready(function(){
        $('#search').trigger('click');
        
        var start = 1;
    $('#keyword,#lead_source,#make,#budget_min,budget_max,#startdate,#enddate,#status,#regno,#follow_from,#follow_to,#km_from,#km_to,#year_from,#year_to,#price_min,#price_max,#car-withoutPhotos,#car-withPhotos,#crateddate_from,#crateddate_to,#updatedaterange_from,#updatedaterange_to,#updatedaterange_follow_from,#updatedaterange_follow_to,#todayworks,#otp_verified').keypress(function (e) {
    if (e.which == 13) {
    //$("#search_button").trigger('click');
    $('#type').val('all');
    $("#all").trigger('click');
    $('#search').trigger('click'); 
    
    }
    });
       $(document).on('click', '#preferences-colmn', function (ev) {
                $("#preferences-col").slideToggle();
                $("#new-fav").hide();
        });
        
        //$('#flip-down').css('cursor', 'pointer');
        $('.favrt-icon').css('cursor', 'pointer');
        
        $(document).on('click', '.flip-down', function (ev) {
        $(".status_select").css("background-color","rgb(247, 248, 249)");
         $(".add-c-textBox").css("background-color","rgb(247, 248, 249)");
     });
     // $('[data-toggle="tooltip"]').tooltip();
      $(document).on('click', '.flip-down,.tablinks', function (ev) {
        $('.carlists_buyer').slideUp("slow");
        // $('.carlists_buyer').hide();
        var spanid = this.id;
        
        var spanids = spanid.split("_");
        console.log('#tr_' + spanids[1]);
        $('tr.hover-section').css('background-color', '#ffffff');
        $('#tr_' + spanids[1]).css('background-color', '#f7f8f9');
        //alert(spanids[1]);
        var visibilityLog = $("#spnleadtr_" + spanids[1]).is(":visible");
        var visibilityflip = $("#flip-up_" + spanids[1]).is(":visible");
        if ((visibilityLog == false || visibilityflip == false) || spanids[0] == 'favourites' || spanids[0] == 'similar' || spanids[0] == 'editpreferences') {
// $("#flip-up").slideToggle();
            $('#spnleadtr_' + spanids[1]).slideDown('slow');
            $('#flip-up_' + spanids[1]).slideDown('slow');
            var favouriteCars = $('#favouriteCars_' + spanids[1]).val();
            var makeIds = $('#makeIds_' + spanids[1]).val();
            var modelIds = $('#modelIds_' + spanids[1]).val();
            var budget = $('#budget_' + spanids[1]).val();
            var bodyType = $('#bodyType_' + spanids[1]).val();
            var fuelType = $('#fuelType_' + spanids[1]).val();
            var transmission = $('#transmission_' + spanids[1]).val();
            var leadId = $('#leadId_' + spanids[1]).val();
            var carIds = $('#carIds_' + spanids[1]).val();
            var dataStr = "favouriteCars=" + favouriteCars + "&makeIds=" + makeIds + "&modelIds=" + modelIds + "&budget=" + budget + "&bodyType=" + bodyType + "&fuelType=" + fuelType + "&transmission=" + transmission + "&leadId=" + leadId + "&existCarIds=" + carIds+"&number=" + spanids[1] + "&type=" + spanids[0];
            //alert(spanids[0]);
            // $('#carlistdetail_'+spanids[1]).html('<img src="<?= ASSET_PATH ?>boot_origin_asset_new/images/loader.gif">');
            $.ajax({type: 'POST', url: base_url+"lead/ajax_carlist", data: dataStr, dataType: 'html', success: function (responseData, status, XMLHttpRequest) {                                                                      //alert(responseData);                                                                $('#carlistdetail_'+spanids[1]).html('<img src="<?= ASSET_PATH ?>boot_origin_asset_new/images/loader.gif">');
                    $('#carlistdetail_' + spanids[1]).html(responseData);
                    if (spanids[0] == 'editpreferences' || spanids[0] == 'similar') {
                        $('#favourites_' + spanids[1]).removeAttr('class');
                        $('#favourites_' + spanids[1]).attr('class', 'tablinks flip-down');
                        $('#similar_' + spanids[1]).attr('class', 'tablinks flip-down active');
                        getRecomCar();
                    } else {
                        $('#similar_' + spanids[1]).removeAttr('class');
                        $('#similar_' + spanids[1]).attr('class', 'tablinks flip-down');
                        $('#favourites_' + spanids[1]).attr('class', 'tablinks flip-down active');
                        var dataStr = "favouriteCars=" + favouriteCars + "&makeIds=" + makeIds + "&modelIds=" + modelIds + "&srh_budget=" + budget + "&srh_body_type=" + bodyType + "&srh_fuel=" + fuelType + "&srh_transmission=" + transmission + "&leadId=" + leadId + "&existCarIds=" + carIds;
                        $.ajax({
                            type: "POST",
                            url: base_url+'lead/ajax_recomm_car',
                            data: dataStr + '&type=2',
                            success: function (response) {
                                $('#recomCarTotalCount_' + spanids[1]).html(response);
                            }
                        });
                        var totalFavourities = parseInt($('#totalFavourities_' + spanids[1]).html());
                        if (totalFavourities == 0) {
                            $('#similar_' + spanids[1]).trigger('click');
                        }

                    }
                }
            });
        } else {
//alert('a');
            $('#spnleadtr_' + spanids[1]).slideUp("slow");
            $('#flip-up_' + spanids[1]).slideUp("slow");
        }

    });
    
    
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
            url: base_url+"lead/ajax_getLeads",
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
    
    
});





$('body').on('click','.selectoffercar',function(){ 
    $('#amount_'+$(this).attr('id')).focus();
       
 });


function forceNumber(event){
    var keyCode = event.keyCode ? event.keyCode : event.charCode;
    if((keyCode < 48 || keyCode > 58) && keyCode != 188 && keyCode != 8 && keyCode != 127 && keyCode != 13 && keyCode != 0 && !event.ctrlKey)
        return false;
}
function convertNumberToWords(amount) {
    
    var words = new Array();
    words[0] = '';
    words[1] = 'One';
    words[2] = 'Two';
    words[3] = 'Three';
    words[4] = 'Four';
    words[5] = 'Five';
    words[6] = 'Six';
    words[7] = 'Seven';
    words[8] = 'Eight';
    words[9] = 'Nine';
    words[10] = 'Ten';
    words[11] = 'Eleven';
    words[12] = 'Twelve';
    words[13] = 'Thirteen';
    words[14] = 'Fourteen';
    words[15] = 'Fifteen';
    words[16] = 'Sixteen';
    words[17] = 'Seventeen';
    words[18] = 'Eighteen';
    words[19] = 'Nineteen';
    words[20] = 'Twenty';
    words[30] = 'Thirty';
    words[40] = 'Forty';
    words[50] = 'Fifty';
    words[60] = 'Sixty';
    words[70] = 'Seventy';
    words[80] = 'Eighty';
    words[90] = 'Ninety';
    amount = amount.toString();
    var atemp = amount.split(".");
    var number = atemp[0].split(",").join("");
    var n_length = number.length;
    var words_string = "";
    if (n_length <= 9) {
        var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        var received_n_array = new Array();
        for (var i = 0; i < n_length; i++) {
            received_n_array[i] = number.substr(i, 1);
        }
        for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
            n_array[i] = received_n_array[j];
        }
        for (var i = 0, j = 1; i < 9; i++, j++) {
            if (i == 0 || i == 2 || i == 4 || i == 7) {
                if (n_array[i] == 1) {
                    n_array[j] = 10 + parseInt(n_array[j]);
                    n_array[i] = 0;
                }
            }
        }
        value = "";
        for (var i = 0; i < 9; i++) {
            if (i == 0 || i == 2 || i == 4 || i == 7) {
                value = n_array[i] * 10;
            } else {
                value = n_array[i];
            }
            if (value != 0) {
                words_string += words[value] + " ";
            }
            if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Crores ";
            }
            if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Lakhs ";
            }
            if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Thousand ";
            }
            if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                words_string += "Hundred and ";
            } else if (i == 6 && value != 0) {
                words_string += "Hundred ";
            }
        }
        words_string = words_string.split("  ").join(" ");
    }
    addCommasle(amount);
    //alert(words_string);
    return words_string;
}


/* Send email And Sms New version Request */
 $(document).ready(function () {
                $('#buyersms_sub_v2').click(function () {

                    var send_type = $("#send_type").val();
                    
                    if (send_type == 'sms' || send_type == 'whatsup') {
                        if(send_type == 'sms'){
                        var check_tab = $('input[name="smstype"]:checked').val();    
                        var buyersmsn = $.trim($("#buyersmsn").val());
                            }else{
                          var check_tab = $('input[name="whatsuptype"]:checked').val();       
                          var buyersmsn = $.trim($("#buyerwhatsupn").val());       
                            }
                        var totalchecked = $('input[name="sms_gaadi_id[]"]:checked').length;
                        if (buyersmsn.length <= 0) {

                            $("#error_message").text('Please Select A Car');
                            setTimeout(function () {
                                $("#error_message").text('');
                            }, 2500);
                            return false;
                        }
                        var alphanumericpatterncomment = /^[A-Za-z\d()-_\s]+$/;
                        if (parseInt(buyersmsn.length) > 500) {

                            $("#error_message").text('Message Size Should Be Below 320 Characters');
                            setTimeout(function () {
                                $("#error_message").text('');
                            }, 2500);
                            return false;
                        }
                        if (check_tab == '2' && totalchecked != 1) {

                            $("#error_message").text('Please Select A Car');
                            setTimeout(function () {
                                $("#error_message").text('');
                            }, 2500);
                            return false;
                        }
                        if(send_type == 'whatsup'){
                            var custoMobile=$('#custoMobile').val();
                            var customerMobile=custoMobile.substr(custoMobile.length - 10);
                           
                            var url = "https://api.whatsapp.com/send?phone=91"+customerMobile+"&text="+encodeURIComponent(buyersmsn);
                            window.open(url,'_blank');
                            
                        }
                           
                        $.ajax({  
                            type: 'POST',
                            url: base_url+"lead/buyer_email_sms",
                            data: $('#buyersms_form').serialize(),
                            dataType: 'html',
                            success: function (responseData, status, XMLHttpRequest) {
                                //alert(responseData);
                                if ($.trim(responseData) == 'sucess') {
                                    //alert(responseData);

                                    $("#buyersms_return").css({
                                        "font-size": "100%",
                                        "align": "center",
                                        "color": "green"
                                    });
                                    $('#buyersms_return').text("SMS Sent Successfully.");
                                    $('#buyersms_sub').hide();

                                    setTimeout(function () {
                                        $("#buyersms_return").text("");
                                            $('#' + $('#type').val()).trigger('click');
                                            $('#buyersms_cancel').trigger('click');
                                            $("#buyersms_sub").show();
                                        //location.reload();
                                    }, 2000);
                                } else {
                                    //window.location.href='/user/log_out.php?exe=0';
                                    return false;
                                }
                            }

                        });
                    } else if (send_type == 'email') {

                        var values = '';
                        $('input[name="gaadi_id[]"]:checkbox:checked').each(function () {
                            values += $(this).val() + ',';
                        });
                        var customer_id = $("#customer_id").val();
                        var cd_customer_name = $("#customer_name").val();
                        var gaadi_id = values;
                        var mobile = $("#customer_mobile_number").val();

                        var totalchecked = $('input[name="gaadi_id[]"]:checked').length;
                        var txtEmail = $.trim($('#email_id').val());
                        var emailRegex = new RegExp(/^.+@.+\..{2,3}$/);
                        var error = false;
                        if (txtEmail == '')
                        {
                            var error = true;
                            $("#error_message").text('Please Enter Email Address');
                            $("#email_id").focus();
                            setTimeout(function () {
                                $("#error_message").text('');
                            }, 2500);
                        } else if (!emailRegex.test(txtEmail))
                        {
                            var error = true;
                            $("#error_message").text('Please Enter Valid Email Address');
                            $('#email_id').focus();
                            setTimeout(function () {
                                $("#error_message").text('');
                            }, 2500);
                        } else if (totalchecked <= 0) {
                            var error = true;
                            $("#error_message").text('Please Select Atleast One Car');

                            setTimeout(function () {
                                $("#error_message").text('');
                            }, 2500);
                        }
                        if (error == false) {
                            var lead_id=$('#lead_id').val();
                           // var url1 = 'ajax/buyer_sms_text_v2.php?id=' + values + '&customerid=' + customer_id + '&mobile=' + mobile + '&name=' + cd_customer_name + '&email_id=' + txtEmail + '&no_of_cars=' + totalchecked+'&type=emailsend'+'&lead_id='+lead_id;

                            $.ajax({
                                type: "POST",
                                url: base_url+"lead/buyer_email_sms",
                                data: 'id=' + values + '&customerid=' + customer_id + '&mobile=' + mobile + '&name=' + cd_customer_name + '&email_id=' + txtEmail + '&no_of_cars=' + totalchecked+'&type=emailsend'+'&lead_id='+lead_id,
                                dataType: "html",
                                success: function (responseData) {
                                    //alert(responseData);
                                   var resp=responseData.trim();

                                    if (resp == '1') {
                                        $("#success_message").text("Mail Sent Sucessfully");
                                        $("#buyersms_sub").hide();
                                        setTimeout(function () {
                                            $("#success_message").text("");
                                            $('#' + $('#type').val()).trigger('click');
                                            $('#buyersms_cancel').trigger('click');
                                            $("#buyersms_sub").show();
                                            //location.reload(); 
                                        }
                                        , 2500);
                                        //$('#actionbar').hide();

                                    }
                                }
                            });
                        }

                    }
                });
       });
       
       
       function runNewVersion(id, value, lead_id) {
        var totalchecked = $('input[name="sms_gaadi_id[]"]:checked').length;
        if (totalchecked == 1) {
        $.ajax({
            type: 'POST',
            url: base_url+"lead/buyer_email_sms",
            data : "lead_id=" + lead_id + "&message=message&type=2&gaadi_id=" + value,
            dataType: 'html',
            success: function (data) {
                var response = data.split('@#$%*');
                $('textarea#buyersmsn').val(response[2]);
                $('textarea#buyerwhatsupn').val(response[2]);
            }
        });

    } else if (totalchecked > 1) {

        $('#' + id).attr('checked', false);
        $("#error_message").text('Only 1 Car Can Be Shared Through SMS');
        setTimeout(function () {
            $("#error_message").text('');
        }, 2500);
    } else {
        $('textarea#buyersmsn').val('');
    }
}

 function sendSmsNewVersion(id, type = '',send_via='',customer_email,refresh='',lead_id='')
    { 
       if(refresh=='refresh'){
           $('#buyer_lead_cars').html('');
           $('#lead_cars_list_whatsup').html('');
           $('#buyersms_return').html('');
           //$('#email').html('');
           
           $('#lisms').removeClass('active');
           $('#liemail').removeClass('active');
           $('#liwhatsup').addClass('active');
           $('#whatsup').addClass('active in');
           $('#email,#sms').removeAttr('class');
           $('#email,#sms').attr('class','tab-pane fade');
           
           
           //$("#send_type").val('email'); 
           $("#send_type").val('whatsup');
           //$("#li_whatsup").trigger('click');
           
            //$("#email_id").val('');
       }
        if(customer_email!='' && customer_email!=null){
           $("#email_id").val(customer_email);
       }
       else{
          // $("#email_id").val('');
       }
        $('#buyersms_sub_v2').show();
       
       if(send_via==''){
           send_via='message';
       }
       if(send_via=='whatsup'){
           send_via='whatsup';
           $('#whatsupcustoMobile').val(id);
       }
       
        if (type == '') {
            $('#custoMobile').val('');
            $('#custoMobile').val(id);
            $('#whatsupcustoMobile').val(id);
        } else {
           
            var id = $('#custoMobile').val();
            

        }
        if(lead_id){
        $('#lead_id').val(lead_id);
        }
        lead_id=$('#lead_id').val();
      //alert(id+'----'+customer_email+'---'+lead_id+'---sendvia-'+send_via+'---type-'+type);
        $.ajax({
            type: 'POST',
            url: base_url+"lead/buyer_email_sms",
            data: "mobile=" + id + "&message="+send_via+"&type=" + type+'&lead_id='+lead_id,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
               
                var res = responseData.split('@#$%*');
                 
                if($.trim(res[0])!=='email_break'){
                console.log(res);
                
               if(send_via=='whatsup'){
                   $('#buyersms_return').html('');
                   $("#buyerwhatsup_return").css({"font-size": "100%", "align": "center"});
                $('#buyerwhatsup_return').html('<div class="form-group"><div class="form-group text-left"><input id="custoMobile" class="form-control search-form-select-box" type="text" maxlength="10" name="custoMobile" value="' + id + '" placeholder="Enter Mobile Number" readonly="readonly"></div> <div class="form-group text-left" style="color:green;" id="msgtypes"></div> <div id="lead_cars_list_whatsup" ></div>  <div class="form-group text-left"><textarea class="form-control search-form-select-box feedBack" name="buyerwhatsupn" id="buyerwhatsupn" placeholder="Select A Car From The Above List"></textarea></div></div>');
                $('textarea#buyerwhatsupn').val('');
                $('#msgtypes').html('');
                $('#msgtypes').html(res[0]);
                $('#lead_cars_list_whatsup').html(res[1]);
                $('textarea#buyerwhatsupn').val(res[2]);
               }else{
                   $('#buyerwhatsup_return').html('');
                   $("#buyersms_return").css({"font-size": "100%", "align": "center"});
                $('#buyersms_return').html('<div class="form-group"><div class="form-group text-left"><input id="custoMobile" class="form-control search-form-select-box" type="text" maxlength="10" name="custoMobile" value="' + id + '" placeholder="Enter Mobile Number" readonly="readonly"></div> <div class="form-group text-left" style="color:green;" id="msgtypes"></div> <div id="lead_cars_list" ></div>  <div class="form-group text-left"><textarea class="form-control search-form-select-box feedBack" name="buyersmsn" id="buyersmsn" placeholder="Select A Car From The Above List"></textarea></div></div>');
                $('textarea#buyersmsn').val('');
                $('#msgtypes').html('');
                $('#msgtypes').html(res[0]);
                $('#lead_cars_list').html(res[1]);
                $('textarea#buyersmsn').val(res[2]);
            }
                if ($.trim(res[1]) == 'sent') {
                    //alert(responseData);
                    $("#buyersms_return").css({"font-size": "100%", "align": "center"});
                    $('#buyersms_return').html('<div class="form-group" style="display:none"><div class="form-group text-left"><input id="custoMobile" class="form-control search-form-select-box" type="text" maxlength="10" name="custoMobile" value="' + id + '" placeholder="Enter Mobile Number" readonly="readonly"></div> <div class="form-group text-left" style="color:green;" id="msgtypes"></div><div class="form-group text-left"><textarea class="form-control search-form-select-box feedBack" name="buyersmsn" id="buyersmsn" placeholder="Type Here..."></textarea></div></div><div style="color:red;"id="sms_exaust_text"></div>');
                    
                    $('#sms_exaust_text').text("Sorry !! SMS limit is exhausted. You cannot send more SMS to this phone number.");
                    $('#buyersms_sub_v2').hide();
                } else {
                if(send_via=='whatsup'){
                    $('#msgtypes').html('');
                    $('#msgtypes').html(res[0]);
                    $('textarea#buyerwhatsupn').val('');
                    $('#lead_cars_list_whatsup').html(res[1]);
                    $('textarea#buyerwhatsupn').val(res[2]);
                    var tab = res[3].split(',');
                    console.log(tab[0]+'---'+type)
                    //alert(tab[0]+'---'+type);
                    if (parseInt(type) > 0) {
                            
                        var $radios = $('input:radio[name=whatsuptype]');
                        $radios.filter('[value=' + type + ']').attr('checked', true);
                    } else {
                        var $radios = $('input:radio[name=whatsuptype]');
                        $radios.filter('[value=' + tab[0] + ']').attr('checked', true);

                    }
               }else{
                    $('#msgtypes').html('');
                    $('#msgtypes').html(res[0]);
                    $('textarea#buyersmsn').val('');
                    $('#lead_cars_list').html(res[1]);
                    $('textarea#buyersmsn').val(res[2]);
                    //alert(type);
                    var tab = res[3].split(',');
                    console.log(tab[0]+'---'+type)
                    if (parseInt(type) > 0) {
                            
                        var $radios = $('input:radio[name=smstype]');
                        $radios.filter('[value=' + type + ']').attr('checked', true);
                    } else {
                        var $radios = $('input:radio[name=smstype]');
                        $radios.filter('[value=' + tab[0] + ']').attr('checked', true);

                    }
                }
                    


                }
            }
            else{
                    if(send_via=='whatsup'){
                    $('div#sms').removeClass('active in');
                    $('div#whatsup').addClass('active in');
                    $('div#email').removeClass('active in');
                    $('#lead_cars_list_whatsup').html(res[1]);
                    }else{
                    $('div#sms').removeClass('active in');
                    $('div#whatsup').removeClass('active in');
                    $('div#email').addClass('active in');
                    $('#buyer_lead_cars').html(res[1]);
                }
            }
            }//success
        });

    }
    
    
  function getCustomerPopup(mobile) {
    var customerName = $('#customer_name_hidden_' + mobile).val();
    var customerEmail = $('#customer_email_hidden_' + mobile).val();
    var customerAltNo = $('#customer_alt_no_hidden_' + mobile).val();
    var customerLocation = $('#customer_location_hidden_' + mobile).val();
    $('#name').val(customerName);
    $('#email_lead').val(customerEmail);
    $('#mobile').val(mobile);
    $('#lead_alternate_mobile_number').val(customerAltNo); //alert(customerLocation);
    $('#location').val(customerLocation);
    $("#location option[value='" + customerLocation + "']").attr('selected', 'selected');
    var locName = $('#location').find(":selected").text();
    $('.custom-combobox > .ui-autocomplete-input').val(locName);
    $('#customerDetailCtr').show();
}

$(document).ready(function () {
    $("#lead_alternate_mobile_number").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
    $("#name").keypress(function (e) {
        if (e.which != 8 && !((e.which >= 65 && e.which <= 90) || (e.which >= 97 && e.which <= 122) || (e.which == 32))) {
            return false;
        }
    });
    $('#saveCustomerBtn').bind('click', function () {
        var customerName = $('#name').val();
        var customerEmail = $('#email_lead').val();
        var customerAltNo = $('#lead_alternate_mobile_number').val();
        var customerLocation = $('#location').val();
        var customerLocationText = $("#location option:selected").text();
        var mobile = $('#mobile').val();
        var customerLocCity = $('#cust_loc_city').val();
        var flag = 1;
        var msg = "Sorry, your request cann't be completed due to below reasons :\n\n";
        var emailPattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
        if (customerEmail != '') {
            if (!emailPattern.test(customerEmail)) {
                msg += '\t- Please enter vaild email.\n';
                flag = 2;
            }
        }
        var mob = /^[1-9]{1}[0-9]{9}$/;
        if (customerAltNo != '') {
            var firstCharMobile = customerAltNo.charAt(0);
            if (mob.test(customerAltNo) == false) {
                msg += '\t- Please enter valid alternate mobile number.\n';
                flag = 2;
            } else if (!(firstCharMobile == '6' || firstCharMobile == '7' || firstCharMobile == '8' || firstCharMobile == '9')) {
                msg += '\t- Please enter valid alternate mobile number.\n';
                flag = 2;
            }
        }
        if (flag == 2) {
            snakbarAlert(msg);
            return false;
        }
        var data_qry = $('#customerDetailFrm').serialize() + '&mobile=' + mobile; //alert(data_qry);
        $.ajax({
            type: "POST",
            url: base_url+'lead/addEditLeadsOnListing',
            data: data_qry,
            success: function (response) {
                //alert(response);
                $('#success-message').css('display', 'block');
                setTimeout(function () {
                    $('#success-message').css('display', 'none');
                    jQuery('#update-details').modal('hide');
                    $('#search').trigger('click');
                }, 1500);
            }
        });
    });
});

function addCommasle(nStr,control,flag='')
{
  //alert('gggg');
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
 // alert(value=x1 +x3+x2);
  $('.rsicon').val(x1 +x3+x2);
       // document.getElementsByClassName('rsicon').value=x1 +x3+x2;
}

function numDifferentiation(val) {
    if(val >= 10000000) val = (val/10000000).toFixed(2) + ' Crore';
    else if(val >= 100000) val = (val/100000).toFixed(2) + ' Lakh';
    else if(val >= 1000) val = (val/1000).toFixed(2) + ' Thousand';
    return val;
}
function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}


function changeFavourites(carId) {
    
	//var confirmMsg = "Do you really want to remove this car from your favourites?";
	//if (confirm(confirmMsg)) {
		//var leadId = <?php echo $requestData['leadId']; ?>;
		//var mobile = <?php echo $requestData['number']; ?>;
		var favouriteCars = $('#favouriteCars_'+mobile).val();
		var saveData = 'favouriteCars='+favouriteCars+'&carid='+carId+'&lead_id='+leadId+'&type=2';
		$.ajax({
	        type: "POST",
	        url: base_url+'lead/ajax_assign_car',
	        data: saveData,
	        success: function(response){ 
                    //alert(response);
	        	$('#favouriteCars_'+mobile).val(response);
	        	var totalFavourities = parseInt($('#totalFavourities_'+mobile).html());//alert(totalFavourities);
	        	totalFavourities = totalFavourities - 1;
	        	if(isNaN(totalFavourities) || totalFavourities == 0) {
	        		totalFavourities = 0;
	        	}	        	
	        	$('#totalFavourities_'+mobile).html(totalFavourities);
	        	response = $.parseJSON(response);
	        	//alert(response);
	        	$.each(response, function(key,value) {
	        	  //alert(key);
				  //alert(value.car_id);
				  if(key == 0) {
				  	var mmvStr = '';
		        	if(value.make != '') {
		        		mmvStr += value.make+ ' ';
		        	}
		        	if(value.model != '') {
		        		mmvStr += value.model+ ' ';
		        	}
		        	if(value.version != '') {
		        		mmvStr += value.version;
		        	}
		        	if(mmvStr != '') {
		        		$('#fav_mmv_'+mobile).html('<strong>'+mmvStr+'</strong>');
		        	} else {
		        		$('#fav_mmv_'+mobile).html('');
		        	}
		        	var favCount = 0;
					var comma = '';
					if(value.price != '') {
						price = numDifferentiation(value.price);
                                                var res='<i class="fa fa-inr" aria-hidden="true"></i>';
						$('#fav_price_'+mobile).html(res+price);
						favCount = favCount+1;
					} else {
						$('#fav_price_'+mobile).html('');
					}
					if(favCount > 0) {
						comma = ',';
					}
					if(value.regno != '') {
						$('#fav_regno_'+mobile).html(comma+value.regno);
						favCount = favCount+1;
					} else {
						$('#fav_regno_'+mobile).html('');
					}
					if(favCount > 0) {
						comma = ',';
					}
					if(value.month != '' || value.year != '') {
						$('#fav_date_'+mobile).html(comma+value.month+' '+value.year);
						favCount = favCount+1;
					} else {
						$('#fav_date_'+mobile).html('');
					}
					if(favCount > 0) {
						comma = ',';
					}
					if(value.km != '') {
                                                km=addCommas(value.km);
						$('#fav_km_'+mobile).html(comma+km+' kms');		
					} else {
						$('#fav_km_'+mobile).html('');
					}
				  }

				}); 
				if(totalFavourities == 0) {
					$('#fav_mmv_'+mobile).html('');
					$('#fav_price_'+mobile).html('');
					$('#fav_regno_'+mobile).html('');
					$('#fav_date_'+mobile).html('');
					$('#fav_km_'+mobile).html('');
					$('#similar_'+mobile).trigger('click');
				} else {	        	
	        		$('#favourites_'+mobile).trigger('click');
	        	}
                  snakbarAlert('Car successfully removed from your favourite.');
	        }
	    });
}

    
   // $('#flip-down').css('cursor', 'pointer');
$('.favrt-icon').css('cursor', 'pointer');
    
    
    //$('.selectbudrp').change(function(){
   function selectbudrp(id)
   {
       
       //alert(id);
    var count = 0;
    var selecteddata = '';
     $('.selectbudrp_'+id+':checked').each(function(){
          selecteddata = $(this).val();
          count++;
      });
      //alert(count);
     if(count>1)
        $('#lebeltxt_'+id).html(count+' Selected');
      else
        $('#lebeltxt_'+id).html(selecteddata);
    if(count<1)
       $('#lebeltxt_'+id).html('Body Type');
   // });
}

        //$('#drpdwn_block').click(function () {
        function showbodytype()
        {
            var id=this.id;
            var ids=id.split('_');
           //alert('hiii');
            $("#bodytype_"+ids[1]).css({display: "block"});
        }   
        //})
        //$("ul.out")
            //.mouseleave(function () {
            function showbodytype()
            {
                $("#select_body_type").css({display: "none"});
            }
            //});

function getRecomCar(check) {
	//var mobile = <?php echo $requestData['number']; ?>;//alert(mobile);
	//var leadId = <?php echo $requestData['leadId']; ?>;
	var data_recom = $('.recommFrm_'+mobile).serialize();
	data_recom = data_recom+'&lead_id='+leadId+'&mobile='+mobile+'&leadId='+leadId+'&type=1';		
    //alert(data_recom);	
    $.ajax({
        type: "POST",
        url: base_url+'lead/ajax_recomm_car',
        data: data_recom,
        success: function(response){ 
            $('#carousel-example-generic_'+mobile).html(response); 
            var totalRecomCar = $('#totalRecomCar').val();
            if(!totalRecomCar){totalRecomCar=0;}
            $('#recomCarTotalCount_'+mobile).html(totalRecomCar);
            var srh_budget = $('#srh_budget_'+mobile).val();
            var srh_budget_text = $('#srh_budget_'+mobile+' option:selected').text();
            var srh_fuel = $('#srh_fuel_'+mobile).val();
            var srh_transmission = $('#srh_transmission_'+mobile).val();
            var body_type_Select = $('#body_type_Select_'+mobile).val();
            var model_Select = $('#model_Select_'+mobile).val();//alert(model_Select);
            var recomModelStr = '';
            var recomMakeStr = '';
            var makeModelStr = '';
            if(model_Select != '' && model_Select != null) {
            	//modelRecom = model_Select;
            	for (i = 0; i < model_Select.length; i++) {
            		makeModelStr += $('#model_Select_'+mobile+' option[value='+model_Select[i]+']').text()+',';
                    modelRecomArr = model_Select[i].split('_');//alert(modelRecomArr['0']);
                    if(modelRecomArr['0'] != 'mk' && modelRecomArr['0'] != '' && modelRecomArr['0'] !== null) {
                        recomModelStr += modelRecomArr['0'] + ','; 
                    } else if(modelRecomArr['0'] == 'mk' && modelRecomArr['1'] != '' && modelRecomArr['1'] !== null) {
                        recomMakeStr += modelRecomArr['1'] + ','; 
                    }
                }  
                if(recomModelStr != '') {
                    recomModelStr = recomModelStr.slice(0,-1);//alert(recomModelStr);                        
                }
                if(recomMakeStr != '') {
                    recomMakeStr = recomMakeStr.slice(0,-1);//alert(recomMakeStr);                        
                }
                if(makeModelStr != '') {
                	makeModelStr = makeModelStr.slice(0,-1);
                }
            }
            var rsSign = '';
            var i=0;
            var comma='';            
            if(srh_budget != '' && srh_budget != '0') {
            	i=i+1; 
            	rsSign = '<i class="fa fa-inr" aria-hidden="true"></i> ';
            	$('#req_budget_'+mobile).html(rsSign+srh_budget_text);
            	$('#budget_'+mobile).val(srh_budget);
            } else {
            	$('#req_budget_'+mobile).html('');
            	$('#budget_'+mobile).val('');
            }
            if(i > 0) {
            	comma=', ';
            }
            if(body_type_Select != '' && body_type_Select != null) {
            	i=i+1;
            	$('#req_bodyType_'+mobile).html(comma+body_type_Select); 
            	$('#bodyType_'+mobile).val(body_type_Select);
            } else {
            	$('#req_bodyType_'+mobile).html(''); 
            	$('#bodyType_'+mobile).val('');
            }
            if(i > 0) {
            	comma=', ';
            }            
            if(srh_fuel != '') {
            	i=i+1;
            	$('#req_fuelType_'+mobile).html(comma+srh_fuel); 
            	$('#fuelType_'+mobile).val(srh_fuel); 
            } else {
            	$('#req_fuelType_'+mobile).html(''); 
            	$('#fuelType_'+mobile).val(''); 
            } 
            if(i > 0) {
            	comma=', ';
            }
            
            if(srh_transmission != '') {
            	i=i+1;
            	$('#req_transmission_'+mobile).html(comma+srh_transmission);
            	$('#transmission_'+mobile).val(srh_transmission);
            } else {
            	$('#req_transmission_'+mobile).html('');
            	$('#transmission_'+mobile).val('');
            }
            if(i > 0) {
            	comma=', ';
            }
            
            if(recomMakeStr != '') {
            	i=i+1;
            	$('#makeIds_'+mobile).val(recomMakeStr);
            	$('#modelIds_'+mobile).val(recomModelStr);  
            	$('#req_model_name_'+mobile).html(comma+makeModelStr);
            } else {
            	$('#makeIds_'+mobile).val('');
            	$('#modelIds_'+mobile).val('');  
            	$('#req_model_name_'+mobile).html('');
            }
            if(srh_budget || srh_fuel || srh_transmission || body_type_Select || model_Select){
            $('#revoveblank_'+mobile).text('');
            $('#editpreferences_'+mobile).text('EDIT');
            }
            else {
                $('#editpreferences_'+mobile).text('ADD');
                $('#revoveblank_'+mobile).text('Click on add to enter requirements.');
            }
            if(check =='test'){
            snakbarAlert('Requirement(s) updated successfully.');
            //$('#search').trigger('click');
        }
             } 
    });
    return false;
}

function saveCarInfo(carId) {
        //alert(mobile);
	//var mobile = <?php echo $requestData['number']; ?>;
	var suffix = mobile+'_'+carId;
	var recomYear = $('#recom_year_'+suffix).val();
	var recomMonth = $('#recom_month_'+suffix).val();
	var recomVersionId = $('#recom_version_id_'+suffix).val();
	var recomCityName = $('#recom_city_name_'+suffix).val();
	var recomCityId = $('#recom_city_id_'+suffix).val();
	var recomColor = $('#recom_color_'+suffix).val();
	var recomKm = $('#recom_km_'+suffix).val();
	var recomPrice = $('#recom_price_'+suffix).val();
	var recomMake = $('#recom_make_'+suffix).val();
	var recomModel = $('#recom_model_'+suffix).val();
	var recomVersion = $('#recom_version_'+suffix).val();
	var recomRegno = $('#recom_regno_'+suffix).val();
	var recomMakeId = $('#recom_makeID_'+suffix).val();
	var recomFuelType = $('#recom_fuel_type_'+suffix).val();
	var recomOwner = $('#recom_owner_'+suffix).val();
	var recomInsurance = $('#recom_insurance_'+suffix).val();
	var recomExpiryDate = $('#recom_expiry_date_'+suffix).val();
        var recomExpiryInsuranceYear = $('#recom_expiry_insurance_year_'+suffix).val();
        var recomExpiryInsuranceMonth = $('#recom_expiry_insurance_month_'+suffix).val();
        var recomTransmission         =$('#recom_transmission'+suffix).val();
	//var leadId = <?php echo $requestData['leadId'] ?>;	
	var favouriteCars = $('#favouriteCars_'+mobile).val();
        //alert(favouriteCars);
	saveData = "lead_id="+leadId+"&carid="+carId+'&favouriteCars='+favouriteCars+'&recomYear='+recomYear+'&recomMonth='+recomMonth+'&recomVersionId='+recomVersionId+'&recomCityName='+recomCityName+'&recomCityId='+recomCityId+'&recomColor='+recomColor+'&recomKm='+recomKm+'&recomPrice='+recomPrice+'&recomMake='+recomMake+'&recomModel='+recomModel+'&recomVersion='+recomVersion+'&recomRegno='+recomRegno+'&recomMakeId='+recomMakeId+'&recomFuelType='+recomFuelType+'&recomOwner='+recomOwner+'&recomInsurance='+recomInsurance+'&recomExpiryDate='+recomExpiryDate+'&recomExpiryInsuranceYear='+recomExpiryInsuranceYear+'&recomExpiryInsuranceMonth='+recomExpiryInsuranceMonth+'&recomTransmission='+recomTransmission+'&type=1';
	$.ajax({
        type: "POST",
        url: base_url+'lead/ajax_assign_car',
        data: saveData,
        success: function(response){ 
        	//console.log(response);
        	$('#favouriteCars_'+mobile).val(response);
        	var totalFavourities = parseInt($('#totalFavourities_'+mobile).html());//alert(totalFavourities);
        	if(isNaN(totalFavourities)) {
        		totalFavourities = 0;
        	}
        	totalFavourities = totalFavourities + 1;
        	$('#totalFavourities_'+mobile).html(totalFavourities);
        	var mmvStr = '';
        	if(recomMake !=null) {
        		mmvStr += recomMake+ ' ';
        	}
        	if(recomModel != '') {
        		mmvStr += recomModel+ ' ';
        	}
        	if(recomVersion != '') {
        		mmvStr += recomVersion;
        	}
        	if(mmvStr != '') {
        		$('#fav_mmv_'+mobile).html('<strong>'+mmvStr+'</strong>');
        	}
        	var favCount = 0;
			var comma = '';
			if(recomPrice != '') {
				price = numDifferentiation(recomPrice);
                                var res='<i class="fa fa-inr" aria-hidden="true"></i>';
				$('#fav_price_'+mobile).html(res+price);
				favCount = favCount+1;
			} else {
				$('#fav_price_'+mobile).html('');
			}
			if(favCount > 0) {
				comma = ', ';
			}
			if(recomRegno != '') {
				$('#fav_regno_'+mobile).html(comma+recomRegno);
				favCount = favCount+1;
			} else {
				$('#fav_regno_'+mobile).html('');
			}
			if(favCount > 0) {
				comma = ', ';
			}
			if(recomMonth != '' || recomYear != '') {
				$('#fav_date_'+mobile).html(comma+recomMonth+' '+recomYear);
				favCount = favCount+1;
			} else {
				$('#fav_date_'+mobile).html('');
			}
			if(favCount > 0) {
				comma = ', ';
			}
			if(recomKm != '') {
                                km=addCommas(recomKm);
				$('#fav_km_'+mobile).html(comma+km+' kms');		
			} else {
				$('#fav_km_'+mobile).html('');
			}
                 snakbarAlert('Car added to favorites successfully.');
        	getRecomCar();
        }
    });
}
            
function multiSelectCheck(id,str) {  
    //alert(id);
    var strArr = str.split(',');
    $("#"+id).val(strArr);
    $('#'+id).multiselect('rebuild');
} 
  $(document).on('click','#spnsearch',function(event){
//$('#spnsearch').click(function () {
    $('#searchtype').val('search');
   $('#type').val('all');
    $("#all").trigger('click');
   // $('#search').trigger('click');
});
$('#Reset').click(function () {
var viewlead= $('#viewlead').val();
    if(viewlead=='viewlead'){
    window.top.location.href = base_url+"lead/getLeads";
    }
    $('#keyword').val('');
    $('#lead_source').val('');
    $('#lead_source')[0].sumo.reload();
    $('#startdate').val('');
    $('#enddate').val('');
    $('#status').val('');
    $('#status')[0].sumo.reload();
    $('#follow_from').val('');
    $('#follow_to').val('');
    $('#km_from').val('');
    $('#km_to').val('');
    $('#year_from').val('');
    $('#year_to').val('');
    $('#regno').val('');
    $('#budget_min').val('');
    $('#budget_max').val('');
    $("input[name=verified]").removeAttr("checked");
    $("input[name=otp_verified]").removeAttr("checked");
    if($('#todayworks').is(':checked')==true){
    $("#todayworks").trigger("click");
    }
    $('#recievedLeadFilter').val('');
    $('#filter_data_type').val('allleads');
    
    //$('#todayworks').val('');
    $('#upcoming-follow-ups').removeAttr("checked");
    $('#daterange').val('');
    $('#updatedaterange').val('');
    $('#recievedLeadFilter').val('');
    
    $('#crateddate_from').val('');
    $('#crateddate_to').val('');
    $('#updatedaterange_from').val('');
    $('#updatedaterange_to').val('');
    $('#updatedaterange_follow_from').val('');
    $('#updatedaterange_follow_to').val('');
    
    $('#search').trigger("click");
    });

    $('#idexportexcel').click(function () {
    $('#export').val('export');
    window.top.location.href = "exportExcel?" + $('#searchform').serialize();
//    $.ajax({
//        type: "POST",
//        url: "exportExcel?" + $('#searchform').serialize(),
//        //data: $('#searchform').serialize(),
//        success: function (response) {
//            $('#export').val('');
//            // window.open('http://crm.local/lead/getLeads','_blank' );
//        }
//
//    });
});

 $('#name,#lead_alternate_mobile_number').bind("cut copy paste",function(e) {
     e.preventDefault();
 });