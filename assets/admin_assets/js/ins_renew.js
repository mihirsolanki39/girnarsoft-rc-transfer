var start = 1;
$(document).on('click', 'form#searchform #search', function (event) {
    start = 1;
    $('#page').val('1');
    $('#searchtype').val('search');
    var startfollowdate = $("#startfollowdate").val();
    var endfollowdate = $("#endfollowdate").val();
    if(startfollowdate != undefined && endfollowdate != undefined){
    if(endfollowdate != "" && startfollowdate != ""){
          var d=startfollowdate.split("-");
          var newcreateDate=d[2]+"/"+d[1]+"/"+d[0];
          var d1=endfollowdate.split("-");
          var newendDate=d1[2]+"/"+d1[1]+"/"+d1[0];
          console.log(newcreateDate +' > '+ newendDate);
          if(newcreateDate > newendDate){
              alert("Please Select Valid Date");
              return false;
          }
    }
}
    getRenewalData($('#searchform').serialize());
});
function getRenewalData(postData) {
    try {
        var ptype = $("#ptype").val();
        $.ajax({
            type: 'POST',
            url: base_url + "insrenewal/ajax_getRenew",
            data: postData,
            dataType: 'html',
            beforeSend: function () {
                $('#imageloder').show();
            },
            complete: function () {
                $('#imageloder').hide();
            },
            success: function (responseData) {
                if (start > 1) {
                    paginationHtml(responseData);
                    return false;
                }
                var resr = responseData.split('####@@@@@');
                console.log(resr);
                if (resr[1] == 1) {
                    var resrtype = resr[0].split('--');
                    $('#allnew').text($.trim(resrtype[0]));
                    $('#noactionnew').text($.trim(resrtype[1]));
                    $('#assignednew').text(resrtype[2]);
                    $('#notassignednew').text(resrtype[3]);
                    $("#breakinnew").text(resrtype[4]);
                    $("#lostnew").text(resrtype[5]);
                    $("#policyexpirednew").text(resrtype[6]);
                    $('#allfollownew').text($.trim(resrtype[1]));
                    $('#pastfollownew').text(resrtype[2]);
                    $('#upcomingfollownew').text(resrtype[3]);
                     var total = parseInt($.trim(resrtype[6]))+parseInt($.trim(resrtype[5]))+parseInt($.trim(resrtype[1]))+parseInt($.trim(resrtype[2]))+parseInt($.trim(resrtype[3]))+parseInt($.trim(resrtype[4]));
                    $('#totcase').text(total);
                    $('#buyer_list').html("<tr><td align='center' colspan='8'><div class='text-center pad-T30 pad-B30'><img src='" + base_url + "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
                } else {
                    var resrtype = resr[0].split('--');
                    //alert(responseData);
                if(ptype == "listing"){
                $('#allnew').text($.trim(resrtype[0]));
                $('#allfollownew').text($.trim(resrtype[1]));
                $('#pastfollownew').text(resrtype[2]);
                $('#upcomingfollownew').text(resrtype[3]);
                $("#breakinnew").text(resrtype[4]);
                $("#lostnew").text(resrtype[5]);
                $("#policyexpirednew").text(resrtype[6]);
                var total = parseInt($.trim(resrtype[6]))+parseInt($.trim(resrtype[5]))+parseInt($.trim(resrtype[1]))+parseInt($.trim(resrtype[2]))+parseInt($.trim(resrtype[3]))+parseInt($.trim(resrtype[4]));
                $('#totcase').text(total);    
                }else{
                $('#noactionnew').text($.trim(resrtype[0]));
                $('#assignednew').text(resrtype[1]);
                $('#notassignednew').text(resrtype[2]);
                $('#totcase').text($.trim(resrtype[0]));    
                 }
                    $('#buyer_list').html(resr[1]);
                    $("#all_checked_header #total_page_recods").text($("#buyer_list tr").length - 1);
                    $("#all_checked_header #total_recods").text($.trim(resrtype[0]));
                    try {
                        $(".buyer-followup-date").datetimepicker({timepicker: false, format: 'j M Y', constrainInput: true, minDate: 0, defaultDate: new Date()});
                        $(".reminder-date").datetimepicker({timepicker: false, format: 'j M Y', constrainInput: true, minDate: 0, defaultDate: new Date()});
                    } catch (e) {
                    }
                }
                clear_selection();
                var tabtype = $('#filter_data_type').val();
                if (tabtype == 'allleads') {
                    $('#closed').css("display", "block");
                    $('#converted').css("display", "block");
                    $('#followfuturedate').css("display", "block");
                } else {
                    $('#closed').css("display", "none");
                    $('#converted').css("display", "none");
                    $('#followfuturedate').css("display", "none");
                }
            }
        });
    } catch (e) {
        //console.log("error" + e);
    }
}

function paginationHtml(responseData) {
    $('#page').attr('value', start);
    var html = $.trim(responseData);
    var resr = html.split('####@@@@@');
    if (parseInt(resr[1]) != 1) {
        $('table tbody#buyer_list').html(resr[1]).promise().done(function () {
            //check all data if selectAll = true
            if (selectAll) {
                $("#allcheck").attr('checked', true);
                $('.clschkassign').prop('checked', true);
            } else {
                $("#allcheck").attr('checked', false);
                clear_selection();
            }
        });
    } else if (parseInt(resr[1]) == 1) {
        start--;
        $('#page').attr('value', start);
        $('#loadmoreajaxloader').text('No More Results');
    }
}
$(document).on('click', 'a.typeq', function () {
    $('#searchtype').val('search');
    $('#imageloder').show();
    $('#type').attr('value', $(this).attr('id'));
    $('#page').val('1');
    var formData = $('#searchform').serialize();
    start = 1;
    //alert(formData);
    getRenewalData(formData);
    //uncheck checkbox
});

$(".used__car-advancesrch").click(function () {
    $(this).parents(".advnce").next().toggleClass("hidden");
    $(this).find('i').toggleClass("fa-angle-down fa-angle-up");
});


jQuery(function () {
    jQuery('#crateddate_from').datetimepicker({
        format: 'd/m/Y',
        onShow: function (ct) {
            this.setOptions({
                maxDate: jQuery('#crateddate_to').val() ? jQuery('#crateddate_to').val() : false
            });
        },
        timepicker: false,
        scrollMonth: false,
        scrollTime: false,
        scrollInput: false
    });
    jQuery('#crateddate_to').datetimepicker({
        format: 'd/m/Y',
        onShow: function (ct) {
            this.setOptions({
                minDate: jQuery('#crateddate_from').val() ? jQuery('#crateddate_from').val() : false
            })
        },
        timepicker: false,
        scrollMonth: false,
        scrollTime: false,
        scrollInput: false
    });
});

jQuery(function () {
    jQuery('#startfollowdate').datetimepicker({
        format: 'd-m-Y',
        onSelect:function(selected){
          jQuery("#endfollowdate").datetimepicker("option","minDate", selected)  
        },
        timepicker: false
    });
    jQuery('#endfollowdate').datetimepicker({
        format: 'd-m-Y',
        onSelect: function(selected) {
           jQuery("#startfollowdate").datetimepicker("option","maxDate", selected)
        },
        timepicker: false,
        scrollMonth: false,
        scrollTime: false,
        scrollInput: false
    });
    
});

jQuery(function () {
    jQuery('#updatedaterange_from').datetimepicker({
        format: 'd/m/Y',
        onShow: function (ct) {
            this.setOptions({
                maxDate: jQuery('#updatedaterange_to').val() ? jQuery('#updatedaterange_to').val() : false
            })
        },
        timepicker: false,
        scrollMonth: false,
        scrollTime: false,
        scrollInput: false
    });
    jQuery('#updatedaterange_to').datetimepicker({
        format: 'd/m/Y',
        onShow: function (ct) {
            this.setOptions({
                minDate: jQuery('#updatedaterange_from').val() ? jQuery('#updatedaterange_from').val() : false
            });
        },
        timepicker: false,
        scrollMonth: false,
        scrollTime: false,
        scrollInput: false
    });
});


$(document).ready(function () {
    $('#search').trigger('click');
    $('#search,#keyword,#lead_source,#make,#budget_min,budget_max,#startdate,#enddate,#status,#regno,#follow_from,#follow_to,#km_from,#km_to,#year_from,#year_to,#price_min,#price_max,#car-withoutPhotos,#car-withPhotos,#crateddate_from,#crateddate_to,#updatedaterange_from,#updatedaterange_to,#startfollowdate,#endfollowdate,#todayworks,#otp_verified').keypress(function (e) {
        if (e.which == 13) {
            //$("#search_button").trigger('click')
            $("#all").trigger('click');
            $('#search').trigger('click');
            e.preventDefault();
        }
    });

    //  $(window).scroll(function () {
    // if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
    // start = $('#page').val();
    // start++;
    // if (jQuery.trim(jQuery('.jtdtext').text()) != 'No record found.')
    // {
    // $('#loadmoreajaxloader').text('Loading...');
    // $('div#loadmoreajaxloader').show();
    // }
    // $('#page').attr('value', start);
    // var formDataload=$('#searchform').serialize();
    // $.ajax({
    // type: 'POST',
    //         url: base_url+"insrenewal/ajax_getRenew",
    //         data: formDataload,
    //         dataType: 'html',
    //         success: function (responseData, status, XMLHttpRequest) {

});
$('body').on('click', '.selectoffercar', function () {
    $('#amount_' + $(this).attr('id')).focus();
});


function pagination(page) {
    $("#page").val(page);
    $('#imageloder').show();
    //  alert(page);
    start = page;
    $('#page').attr('value', page);
    var formDataload = $('#searchform').serialize();
    getRenewalData(formDataload);
}



function forceNumber(event) {
    var keyCode = event.keyCode ? event.keyCode : event.charCode;
    if ((keyCode < 48 || keyCode > 58) && keyCode != 188 && keyCode != 8 && keyCode != 127 && keyCode != 13 && keyCode != 0 && !event.ctrlKey)
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
    //alert(words_string);
    return words_string;
}

function getCustomerPopupnew() {
    var AssignArr = [];
    if (selectAll && all_ids) {
        var all_ids_arr = all_ids.split(",");
        if (all_ids_arr.length > 0) {
            for (var j = 0; j < all_ids_arr.length; j++) {
                AssignArr[j] = all_ids_arr[j];
            }
        }
    } else {
        var totalchecked = $('input.clschkassign:checked').length;
        if (totalchecked > 0) {
            $.each($("input[name='chkassign']:checked"), function () {
                AssignArr.push($(this).val());
            });
        }
    }
    console.log(AssignArr);
    if (AssignArr.length > 0) {
        AssignArr.join(", ");
        jQuery('#customerDetailCtralert').hide();
        $('#customerDetailCtr').show();
        $.ajax({
            type: 'POST',
            url: base_url + "insrenewal/getEmplist",
            data: {chkassign: AssignArr},
            dataType: 'html',
            success: function (data) {
               // alert('hh');
                $('#cnttask').html(AssignArr.length);
                $('#divassign').html(data);
            }
        });
    } else {
        $('#customerDetailCtr').hide();
        jQuery('#customerDetailCtralert').show();
        return false;
    }
}
function getassignCase(id) {
    var list = [];
    var totalchecked = $('input[name="chkassign[]"]:checked').length;
    if (totalchecked > 0) {
        var assignedCases = $('#assigncaseId').val();
        var checkedval = $('#chkassign_' + id + ':checked').val();
        var uncheckedval = $('#chkassign_' + id + ':not(checked)').val();
        //alert(uncheckedval);
        if (checkedval != undefined) {
            var caseIds = assignedCases;
            caseIds += checkedval + ',';
            list.push(checkedval);
            var list1 = unique(list);
            //caseIds = caseIds.substring(1,caseIds.lastIndexOf(","));
            //console.log(list1);
            $('#assigncaseId').val(caseIds);
        } else {
            list = jQuery.grep(list, function (value) {
                return value != uncheckedval;
            });
        }

    }
}
function unique(array) {
    //alert(array);
    return array.filter(function (el, index, arr) {
        return index == arr.indexOf(el);
    });
}

$(document).ready(function () {
    $("#srchassign").on('keyup paste', function () {
        var txtsrch = $("#srchassign").val();
        var assignval = $("#assigntxt").val();
        $.ajax({
            type: 'POST',
            url: base_url + "insrenewal/getEmplist",
            data: {txtsrch:txtsrch,assignedCases:assignval},
            dataType: 'html',
            success: function (data) {
                $('#divassign').html(data);
              //  alert('h')
            }
        });
    });
    $(".clsassign").click(function (e) {
        var assignval = $('.clsoptassign:checked').length
        if (assignval == 0) {
            $('#assign_error').show();
            $('#assign_error').html("Please Select at least One Executive");
            return false;
        } else {
            var formdata = $('#customerDetailFrm').serialize();
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: base_url + "insrenewal/getAssignCases",
                data: formdata,
                dataType: 'html',
                success: function (response) {
                    var data = $.parseJSON(response);
                    //console.log(data);
                    if (data.status == 'True') {
                        snakbarAlert(data.message);
                        setTimeout(function () {
                            window.location.href = data.Action;
                        }, 2500);

                        return true;
                    } else {
                        snakbarAlert(data.message);
                        return false;
                    }
                    return false;
                }
            });
        }

    });

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

    });
});

function clschkassign(case_id) {
    if ($("#chkassign_" + case_id).is(":checked")) {
        console.log("checked");
    } else {
        console.log("unchecked");
        if ($("#allcheck").is(":checked")) {
            $("#allcheck").attr('checked', false);
        }
        if (selectAll) {
            clear_selection();
        }
    }
}

function numDifferentiation(val) {
    if (val >= 10000000)
        val = (val / 10000000).toFixed(2) + ' Crore';
    else if (val >= 100000)
        val = (val / 100000).toFixed(2) + ' Lakh';
    else if (val >= 1000)
        val = (val / 1000).toFixed(2) + ' Thousand';
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
    var favouriteCars = $('#favouriteCars_' + mobile).val();
    var saveData = 'favouriteCars=' + favouriteCars + '&carid=' + carId + '&lead_id=' + leadId + '&type=2';
    $.ajax({
        type: "POST",
        url: base_url + 'lead/ajax_assign_car',
        data: saveData,
        success: function (response) {
            //alert(response);
            $('#favouriteCars_' + mobile).val(response);
            var totalFavourities = parseInt($('#totalFavourities_' + mobile).html());//alert(totalFavourities);
            totalFavourities = totalFavourities - 1;
            if (isNaN(totalFavourities) || totalFavourities == 0) {
                totalFavourities = 0;
            }
            $('#totalFavourities_' + mobile).html(totalFavourities);
            response = $.parseJSON(response);
            //alert(response);
            $.each(response, function (key, value) {
                //alert(key);
                //alert(value.car_id);
                if (key == 0) {
                    var mmvStr = '';
                    if (value.make != '') {
                        mmvStr += value.make + ' ';
                    }
                    if (value.model != '') {
                        mmvStr += value.model + ' ';
                    }
                    if (value.version != '') {
                        mmvStr += value.version;
                    }
                    if (mmvStr != '') {
                        $('#fav_mmv_' + mobile).html('<strong>' + mmvStr + '</strong>');
                    } else {
                        $('#fav_mmv_' + mobile).html('');
                    }
                    var favCount = 0;
                    var comma = '';
                    if (value.price != '') {
                        price = numDifferentiation(value.price);
                        var res = '<i class="fa fa-inr" aria-hidden="true"></i>';
                        $('#fav_price_' + mobile).html(res + price);
                        favCount = favCount + 1;
                    } else {
                        $('#fav_price_' + mobile).html('');
                    }
                    if (favCount > 0) {
                        comma = ',';
                    }
                    if (value.regno != '') {
                        $('#fav_regno_' + mobile).html(comma + value.regno);
                        favCount = favCount + 1;
                    } else {
                        $('#fav_regno_' + mobile).html('');
                    }
                    if (favCount > 0) {
                        comma = ',';
                    }
                    if (value.month != '' || value.year != '') {
                        $('#fav_date_' + mobile).html(comma + value.month + ' ' + value.year);
                        favCount = favCount + 1;
                    } else {
                        $('#fav_date_' + mobile).html('');
                    }
                    if (favCount > 0) {
                        comma = ',';
                    }
                    if (value.km != '') {
                        km = addCommas(value.km);
                        $('#fav_km_' + mobile).html(comma + km + ' kms');
                    } else {
                        $('#fav_km_' + mobile).html('');
                    }
                }

            });
            if (totalFavourities == 0) {
                $('#fav_mmv_' + mobile).html('');
                $('#fav_price_' + mobile).html('');
                $('#fav_regno_' + mobile).html('');
                $('#fav_date_' + mobile).html('');
                $('#fav_km_' + mobile).html('');
                $('#similar_' + mobile).trigger('click');
            } else {
                $('#favourites_' + mobile).trigger('click');
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
    $('.selectbudrp_' + id + ':checked').each(function () {
        selecteddata = $(this).val();
        count++;
    });
    //alert(count);
    if (count > 1)
        $('#lebeltxt_' + id).html(count + ' Selected');
    else
        $('#lebeltxt_' + id).html(selecteddata);
    if (count < 1)
        $('#lebeltxt_' + id).html('Body Type');
    // });
}

//$('#drpdwn_block').click(function () {
function showbodytype()
{
    var id = this.id;
    var ids = id.split('_');
    //alert('hiii');
    $("#bodytype_" + ids[1]).css({display: "block"});
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
    var data_recom = $('.recommFrm_' + mobile).serialize();
    data_recom = data_recom + '&lead_id=' + leadId + '&mobile=' + mobile + '&leadId=' + leadId + '&type=1';
    //alert(data_recom);	
    $.ajax({
        type: "POST",
        url: base_url + 'lead/ajax_recomm_car',
        data: data_recom,
        success: function (response) {
            $('#carousel-example-generic_' + mobile).html(response);
            var totalRecomCar = $('#totalRecomCar').val();
            if (!totalRecomCar) {
                totalRecomCar = 0;
            }
            $('#recomCarTotalCount_' + mobile).html(totalRecomCar);
            var srh_budget = $('#srh_budget_' + mobile).val();
            var srh_budget_text = $('#srh_budget_' + mobile + ' option:selected').text();
            var srh_fuel = $('#srh_fuel_' + mobile).val();
            var srh_transmission = $('#srh_transmission_' + mobile).val();
            var body_type_Select = $('#body_type_Select_' + mobile).val();
            var model_Select = $('#model_Select_' + mobile).val();//alert(model_Select);
            var recomModelStr = '';
            var recomMakeStr = '';
            var makeModelStr = '';
            if (model_Select != '' && model_Select != null) {
                //modelRecom = model_Select;
                for (i = 0; i < model_Select.length; i++) {
                    makeModelStr += $('#model_Select_' + mobile + ' option[value=' + model_Select[i] + ']').text() + ',';
                    modelRecomArr = model_Select[i].split('_');//alert(modelRecomArr['0']);
                    if (modelRecomArr['0'] != 'mk' && modelRecomArr['0'] != '' && modelRecomArr['0'] !== null) {
                        recomModelStr += modelRecomArr['0'] + ',';
                    } else if (modelRecomArr['0'] == 'mk' && modelRecomArr['1'] != '' && modelRecomArr['1'] !== null) {
                        recomMakeStr += modelRecomArr['1'] + ',';
                    }
                }
                if (recomModelStr != '') {
                    recomModelStr = recomModelStr.slice(0, -1);//alert(recomModelStr);                        
                }
                if (recomMakeStr != '') {
                    recomMakeStr = recomMakeStr.slice(0, -1);//alert(recomMakeStr);                        
                }
                if (makeModelStr != '') {
                    makeModelStr = makeModelStr.slice(0, -1);
                }
            }
            var rsSign = '';
            var i = 0;
            var comma = '';
            if (srh_budget != '' && srh_budget != '0') {
                i = i + 1;
                rsSign = '<i class="fa fa-inr" aria-hidden="true"></i> ';
                $('#req_budget_' + mobile).html(rsSign + srh_budget_text);
                $('#budget_' + mobile).val(srh_budget);
            } else {
                $('#req_budget_' + mobile).html('');
                $('#budget_' + mobile).val('');
            }
            if (i > 0) {
                comma = ', ';
            }
            if (body_type_Select != '' && body_type_Select != null) {
                i = i + 1;
                $('#req_bodyType_' + mobile).html(comma + body_type_Select);
                $('#bodyType_' + mobile).val(body_type_Select);
            } else {
                $('#req_bodyType_' + mobile).html('');
                $('#bodyType_' + mobile).val('');
            }
            if (i > 0) {
                comma = ', ';
            }
            if (srh_fuel != '') {
                i = i + 1;
                $('#req_fuelType_' + mobile).html(comma + srh_fuel);
                $('#fuelType_' + mobile).val(srh_fuel);
            } else {
                $('#req_fuelType_' + mobile).html('');
                $('#fuelType_' + mobile).val('');
            }
            if (i > 0) {
                comma = ', ';
            }

            if (srh_transmission != '') {
                i = i + 1;
                $('#req_transmission_' + mobile).html(comma + srh_transmission);
                $('#transmission_' + mobile).val(srh_transmission);
            } else {
                $('#req_transmission_' + mobile).html('');
                $('#transmission_' + mobile).val('');
            }
            if (i > 0) {
                comma = ', ';
            }

            if (recomMakeStr != '') {
                i = i + 1;
                $('#makeIds_' + mobile).val(recomMakeStr);
                $('#modelIds_' + mobile).val(recomModelStr);
                $('#req_model_name_' + mobile).html(comma + makeModelStr);
            } else {
                $('#makeIds_' + mobile).val('');
                $('#modelIds_' + mobile).val('');
                $('#req_model_name_' + mobile).html('');
            }
            if (srh_budget || srh_fuel || srh_transmission || body_type_Select || model_Select) {
                $('#revoveblank_' + mobile).text('');
                $('#editpreferences_' + mobile).text('EDIT');
            } else {
                $('#editpreferences_' + mobile).text('ADD');
                $('#revoveblank_' + mobile).text('Click on add to enter requirements.');
            }
            if (check == 'test') {
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
    var suffix = mobile + '_' + carId;
    var recomYear = $('#recom_year_' + suffix).val();
    var recomMonth = $('#recom_month_' + suffix).val();
    var recomVersionId = $('#recom_version_id_' + suffix).val();
    var recomCityName = $('#recom_city_name_' + suffix).val();
    var recomCityId = $('#recom_city_id_' + suffix).val();
    var recomColor = $('#recom_color_' + suffix).val();
    var recomKm = $('#recom_km_' + suffix).val();
    var recomPrice = $('#recom_price_' + suffix).val();
    var recomMake = $('#recom_make_' + suffix).val();
    var recomModel = $('#recom_model_' + suffix).val();
    var recomVersion = $('#recom_version_' + suffix).val();
    var recomRegno = $('#recom_regno_' + suffix).val();
    var recomMakeId = $('#recom_makeID_' + suffix).val();
    var recomFuelType = $('#recom_fuel_type_' + suffix).val();
    var recomOwner = $('#recom_owner_' + suffix).val();
    var recomInsurance = $('#recom_insurance_' + suffix).val();
    var recomExpiryDate = $('#recom_expiry_date_' + suffix).val();
    var recomExpiryInsuranceYear = $('#recom_expiry_insurance_year_' + suffix).val();
    var recomExpiryInsuranceMonth = $('#recom_expiry_insurance_month_' + suffix).val();
    var recomTransmission = $('#recom_transmission' + suffix).val();
    //var leadId = <?php echo $requestData['leadId'] ?>;	
    var favouriteCars = $('#favouriteCars_' + mobile).val();
    //alert(favouriteCars);
    saveData = "lead_id=" + leadId + "&carid=" + carId + '&favouriteCars=' + favouriteCars + '&recomYear=' + recomYear + '&recomMonth=' + recomMonth + '&recomVersionId=' + recomVersionId + '&recomCityName=' + recomCityName + '&recomCityId=' + recomCityId + '&recomColor=' + recomColor + '&recomKm=' + recomKm + '&recomPrice=' + recomPrice + '&recomMake=' + recomMake + '&recomModel=' + recomModel + '&recomVersion=' + recomVersion + '&recomRegno=' + recomRegno + '&recomMakeId=' + recomMakeId + '&recomFuelType=' + recomFuelType + '&recomOwner=' + recomOwner + '&recomInsurance=' + recomInsurance + '&recomExpiryDate=' + recomExpiryDate + '&recomExpiryInsuranceYear=' + recomExpiryInsuranceYear + '&recomExpiryInsuranceMonth=' + recomExpiryInsuranceMonth + '&recomTransmission=' + recomTransmission + '&type=1';
    $.ajax({
        type: "POST",
        url: base_url + 'lead/ajax_assign_car',
        data: saveData,
        success: function (response) {
            //console.log(response);
            $('#favouriteCars_' + mobile).val(response);
            var totalFavourities = parseInt($('#totalFavourities_' + mobile).html());//alert(totalFavourities);
            if (isNaN(totalFavourities)) {
                totalFavourities = 0;
            }
            totalFavourities = totalFavourities + 1;
            $('#totalFavourities_' + mobile).html(totalFavourities);
            var mmvStr = '';
            if (recomMake != null) {
                mmvStr += recomMake + ' ';
            }
            if (recomModel != '') {
                mmvStr += recomModel + ' ';
            }
            if (recomVersion != '') {
                mmvStr += recomVersion;
            }
            if (mmvStr != '') {
                $('#fav_mmv_' + mobile).html('<strong>' + mmvStr + '</strong>');
            }
            var favCount = 0;
            var comma = '';
            if (recomPrice != '') {
                price = numDifferentiation(recomPrice);
                var res = '<i class="fa fa-inr" aria-hidden="true"></i>';
                $('#fav_price_' + mobile).html(res + price);
                favCount = favCount + 1;
            } else {
                $('#fav_price_' + mobile).html('');
            }
            if (favCount > 0) {
                comma = ', ';
            }
            if (recomRegno != '') {
                $('#fav_regno_' + mobile).html(comma + recomRegno);
                favCount = favCount + 1;
            } else {
                $('#fav_regno_' + mobile).html('');
            }
            if (favCount > 0) {
                comma = ', ';
            }
            if (recomMonth != '' || recomYear != '') {
                $('#fav_date_' + mobile).html(comma + recomMonth + ' ' + recomYear);
                favCount = favCount + 1;
            } else {
                $('#fav_date_' + mobile).html('');
            }
            if (favCount > 0) {
                comma = ', ';
            }
            if (recomKm != '') {
                km = addCommas(recomKm);
                $('#fav_km_' + mobile).html(comma + km + ' kms');
            } else {
                $('#fav_km_' + mobile).html('');
            }
            snakbarAlert('Car added to favorites successfully.');
            getRecomCar();
        }
    });
}

function multiSelectCheck(id, str) {
    //alert(id);
    var strArr = str.split(',');
    $("#" + id).val(strArr);
    $('#' + id).multiselect('rebuild');
}
//$(document).on('click', '#spnsearch', function (event) {
////$('#spnsearch').click(function () {
//    $('#searchtype').val('search');
//    $('#type').val('all');
//    $("#all").trigger('click');
//    // $('#search').trigger('click');
//});
$('#Reset').click(function () {
    //console.log("reset clicked");
    
    start = 1;
    var viewlead = $('#viewlead').val();
    if (viewlead == 'viewlead') {
        window.top.location.href = base_url + "lead/getLeads";
    }
    $('#keyword').val('');
    $("#keyword").attr("readonly", true);
    $('#lead_source').val('');
    $('#startdate').val('');
    $('#enddate').val('');
    $('#status').val('');
    $('#follow_from').val('');
    $('#follow_to').val('');
    $('#km_from').val('');
    $('#km_to').val('');
    $('#year_from').val('');
    $('#year_to').val('');
    $('#regno').val('');
    $('#budget_min').val('');
    $('#policy_status').val('');
    $('#budget_max').val('');
    $("input[name=verified]").removeAttr("checked");
    $("input[name=otp_verified]").removeAttr("checked");
    if ($('#todayworks').is(':checked') == true) {
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
    if ($("#policy_status").length > 0)
        $("#policy_status").val('');
    if ($("#assign_to").length > 0)
        $("#assign_to").val('');
    if ($("#odAmt").length > 0)
        $("#odAmt").val('');
    if ($("#startfollowdate").length > 0)
        $("#startfollowdate").val('');
    if ($("#endfollowdate").length > 0)
        $("#endfollowdate").val('');
    if ($("#lead_status").length > 0)
        $("#lead_status").val('');
    if ($(".select-box").length > 0)
        $(".select-box").html(' Select <span class="d-arrow d-arrow-new"></span>');
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

$('#name,#lead_alternate_mobile_number').bind("cut copy paste", function (e) {
    e.preventDefault();
});
var selectAll = false;
var all_ids = false;
var all_records = 0;
function checkAll() {
    console.log("check all ");
    //if (allcheck.checked && ($("#buyer_list tr").length - 1) > 0) {
    if ($("#allcheck").is(':checked')) {
        $('.clschkassign').prop('checked', true); // Checks it
        manupulateHtml();
        //here add div 
    } else {
        $('.clschkassign').prop('checked', false); // Unchecks it    
        clear_selection();
    }
}

function manupulateHtml() {
    all_records = 0;
    var tab_id = $(".workingdetials li.active a").attr('id');
    if (tab_id == "all") {
        all_records = $("#noactionnew").text();
        all_ids = $("#tot_ids").val();
    } else if (tab_id == "assigned") {
        all_records = $("#assignednew").text();
        all_ids = $("#totassigned_ids").val();
    } else if (tab_id == "notassigned") {
        all_records = $("#notassignednew").text();
        all_ids = $("#totnotassigned_ids").val();
    }
    if (all_records > parseInt($("#page_limit_renew_case").val())) {
        $("#all_checked_header").show();
        $(".after_container").hide();
        $(".before_container").show();
    }
    $("#total_records").text(all_records);
}
function select_all_records() {
    $("#total_selected_records").text(all_records);
    $(".after_container").show();
    $(".before_container").hide();
    selectAll = true;
}
function clear_selection() {
    console.log("clear selection");
    selectAll = false;
    $(".after_container").hide();
    $(".before_container").hide();
    if ($("#allcheck").is(':checked')) {
        $("#allcheck").trigger('click');
    }
}

function searchby(searchByValue = '')
{
   
    if (searchByValue != '')
    {
        $('#searchby').val(searchByValue);
        if (searchByValue == 'name')
        {
            $('#keyword').attr('readonly', false);
            $('#keyword').attr('onkeypress', 'return alphabhetsOnly(event)');
            $('#keyword').attr('maxlength', '50');
            $('#keyword').removeAttr('disabled');
        } else if (searchByValue == 'mobile')
        {
             $('#keyword').attr('readonly', false);
            $('#keyword').attr('onkeypress', 'return isNumberKey(event)');
            $('#keyword').attr('maxlength', '10');
            $('#keyword').removeAttr('disabled');

        } else if (searchByValue == 'regno')
        {
            $('#keyword').attr('readonly', false);
            $('#keyword').attr('onkeypress', '');
            $('#keyword').attr('maxlength', '10');
            $('#keyword').removeAttr('disabled');
        }
        else if (searchByValue == 'followupdate')
        {
           $('#searchdateby').val('followupdate');
           $('#startfollowdate').val('');
           $('#endfollowdate').val('');
           $('#startfollowdate').removeAttr('disabled');
           $('#endfollowdate').removeAttr('disabled');
        }
        else if (searchByValue == 'duedate')
        {
            $('#searchdateby').val('duedate');
            $('#startfollowdate').val('');
            $('#endfollowdate').val('');
            $('#startfollowdate').removeAttr('disabled');
            $('#endfollowdate').removeAttr('disabled');
        }

        
}
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
function alphabhetsOnly(event)
{
    var inputValue = event.which;
    //alert(inputValue);
    if (!(inputValue >= 65 && inputValue <= 123) && (inputValue != 32 && inputValue != 0 && inputValue != 8)) {
        event.preventDefault();
        return false;
    }
    // console.log(inputValue);
}
