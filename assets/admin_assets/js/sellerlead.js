$('#make').on('change', function () {
    var selected = $(this).val();
    $.ajax({
        type: 'POST',
        url: base_url + "stock/getModel",
        data: {make: selected},
        dataType: "html",
        success: function (responseData)
        {
            $('#model').html(responseData);
            $('#model').prop('disabled', false);

        }
    });
});


var page = 1;
function getResults()
{
    //alert($('#sell_search_form').serialize());
     $('#page').attr('value', '1');
    $('.loader').show();
    $('#imageloder').show();
    $('#sell_search_form #export').val('0');
    var formData = $('#sell_search_form').serialize();
    $.ajax({
        type: 'POST',
        url: base_url + "LeadSell/ajaxSellLead?page=" + page,
        data: formData,
        dataType: 'html',
        success: function (result) {

            var resultArr = result.split('###');
            var data = resultArr[0];
            var total_records = resultArr[1];

            if (total_records < 20)
            {
                $('#load_more').hide();
            } else {
                $('#load_more').show();
            }

            if (page == 1)
            {

                $('#sell_customer_ajax_result').html(data);
            } else
            {
                $('#sell_customer_ajax_result').append(data);
            }


            if ($.trim(data) == '')
            {
                $('#sell_customer_ajax_result').html("<tr><td align='center' colspan='6'><div class='text-center pad-T30 pad-B30'><img src='" + base_url + "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
                $('#load_more').html("No More Results").attr('disabled', true);
            } else
            {
                $('#load_more').html('Load More').attr('disabled', false);
            }
            $('#sell_customer_ajax_result').find('.calender').datetimepicker({timepicker: true, format: 'd-m-Y H:i', minDate: dd ? dd : false});
            $('#sell_customer_ajax_result').find('[data-toggle="tooltip"],.source-icon').tooltip();
            $('#sell_customer_ajax_result').find('.edit_name_email').click(function () {
                $(this).parent().parent().find('.edit_text_box').show();
                $(this).parent().parent().find('.name_email_text').hide();

            });
            $('.loader').hide();
            $('#imageloder').hide();
            $('.edit_hidden_save').css('background-color', $('#search_button').css('background-color'));



        }
    });

    getCounts(1);

}
var prev_ref = '';
function getCounts(thsref)
{
    $('.countloader').show();
    var formData = $('#sell_search_form').serialize();
    $.ajax({
        type: 'POST',
        url: base_url + "LeadSell/sellEnquiryRecordsCount",
        data: formData,
        dataType: 'html',
        success: function (result) {
            if (prev_ref != '' && thsref != 1 && prev_ref != result && $('#tab_value').val() != 'all')
            {
                $(thsref).parent().parent().parent().hide();
            }
            prev_ref = result;

            var statsArr = result.split('||');

           /* $('.tabs_sell .btn').eq(0).find('.badge').html(statsArr[0]);
            $('.tabs_sell .btn').eq(1).find('.badge').html(statsArr[1]);
            $('.tabs_sell .btn').eq(2).find('.badge').html(statsArr[2]);
            $('.tabs_sell .btn').eq(3).find('.badge').html(statsArr[3]);
            $('.tabs_sell .btn').eq(4).find('.badge').html(statsArr[4]);
            $('.tabs_sell .btn').eq(5).find('.badge').html(statsArr[5]);
            */
             $('#noactionnew').text($.trim(statsArr[0]));
            $('#todayfollownew').text(statsArr[1]);
            $('#pastfollownew').text(statsArr[2]);
            $('#allnew').text(statsArr[3]);
            $('#closednew').text(statsArr[4]);
            $('#convertednew').text(statsArr[5]);
            $('.countloader').hide();
        }
    });
}
getResults();

var save_popup = 0;
var add_commentt = 0;
function add_comment(id, ths)
{
    if (add_commentt == 0) {
        var status = $(ths).parent().parent().siblings().find('.comment_status').val();
        var follow_up_date = $(ths).parent().parent().siblings().find('.comment_follow_up_date').val();
        var comment = $(ths).parent().parent().siblings().find('.comment').val();
        var name = $(ths).parent().parent().siblings().find('.name_edit').val();
        var email = $(ths).parent().parent().siblings().find('.email_edit').val();
        var mobile =$(ths).parent().parent().siblings().find('.mobile_edit').val();
        var dealerid =$(ths).parent().parent().siblings().find('.dealer_id_edit').val();;


        if ((status == 'Hot' || status == 'Warm' || status == 'Walked-In' || status == 'Cold' || status == 'Evaluation Scheduled') && follow_up_date == '')
        {
            //$(ths).parent().parent().siblings().find('.edit_error_message').html('<span class="error">Follow up date should be mandatory.</span>');
            //alert('Follow up date should be mandatory.');
            //alert("Please Select Follow Up Date and Time");
            snakbarAlert('Please Select Follow Up Date and Time');
            $(ths).parent().parent().siblings().find('.comment_follow_up_date').focus();
            //error=true;
            return false;
        } else {
            $(ths).parent().find('.saveloader').show();
        }


        $.ajax({
            type: 'POST',
            url: base_url + "LeadSell/sellEnqAddComment",
            jsonp: "callback",
                        // tell jQuery we're expecting JSONP
            data: {id:id,add_seller_status:status,add_seller_name:name,add_seller_email:email,follow_date:follow_up_date,save_popup:save_popup,add_seller_comment:comment,add_seller_mobile:mobile,dealer_id:dealerid},
            dataType: 'html',
            success: function (data) {
                
                var tt = setTimeout(function () {
                    $(ths).parent().find('.saveloader').hide();
                }, 1000);
                add_commentt = 0;
                var dataArr = data.split('error');
                if (dataArr[1] == '' || dataArr[1] == undefined) {
                    if ($.trim(data) != '' && $.trim(data) != '1') {
                        $(ths).parent().parent().siblings().find('#commentwraper').html(data);
                    }
                } else {
                    //$(ths).parent().parent().siblings().find('.edit_error_message').html(data);
                    var rstring = '<span class="error">';
                    var msgg = data.replace(rstring, '');
                    var msggg = msgg.replace('</span>', '');
                    //alert(msggg);
                    snakbarAlert(msggg);
                    return;
                }
                if (save_popup != '1')
                {
                    $(ths).css('background-color', '');
                }
                if ($.trim(data) != '')
                {
                    $(ths).parent().next().html('Saved');
                    var t = setTimeout(function () {
                        $(ths).parent().next().html('');
                        getCounts(ths);
                    }, 1000);

                }

                $('.cmnt-cancel').click();
                if (save_popup == 0) {
                    $(ths).parent().parent().siblings().find('.edit_text_box').hide();
                    $(ths).parent().parent().siblings().find('.name_email_text').show();
                    $(ths).parent().parent().siblings().find('.edit_name_email').show();
                    $(ths).parent().parent().siblings().find('.edit_error_message').html('');
                    $(ths).parent().parent().siblings().find('.maxlength-feedback').hide();
                }
                $(ths).parent().parent().siblings().find('.comment').val('');


            }
        });

    }
    add_commentt = 1;


}

function getMoreCars(id)
{
    $.ajax({
        type:'POST',
        jsonp: "callback",
        url: base_url + "LeadSell/getScMoreCars",
        data:{id:id},
        dataType:'html',
        success: function (data) {
            $('#more_cars').html(data);
            _gaq.push(['_trackEvent', 'Seller Enquiry', 'View More Cars', '<?=$event_type?>']);
        }
    });
}
var comment_id = '';
function getComments(id, ths)
{
    comment_id = id;
    $.ajax({
        type:'POST',
        jsonp: "callback",
        url: base_url + "LeadSell/getScComments",
        data:{id:id},
        dataType:'html',
        success: function (data) {
            $('#comment_popup').html(data);
            //$("#add_Comment").mCustomScrollbar({theme:"dark-thin",setHeight:300});
        }
    });
    $('.textarea_comment_popup').val('');
}


$('select[name=price_min]').change(function () {
    var min_val = parseInt($(this).val());
    $('select[name=price_max] option').each(function () {
        if (parseInt($(this).attr('value')) < min_val)
        {
            $(this).hide();
        } else
        {
            $(this).show();
        }
    });
});
$('select[name=price_max]').change(function () {
    var min_val = parseInt($(this).val());
    $('select[name=price_min] option').each(function () {
        if (parseInt($(this).attr('value')) > min_val)
        {
            $(this).hide();
        } else
        {
            $(this).show();
        }
    });
});

$('select[name=km_from]').change(function () {
    var min_val = parseInt($(this).val());
    $('select[name=km_to] option').each(function () {
        if (parseInt($(this).attr('value')) < min_val)
        {
            $(this).hide();
        } else
        {
            $(this).show();
        }
    });
});
$('select[name=km_to]').change(function () {
    var min_val = parseInt($(this).val());
    $('select[name=km_from] option').each(function () {
        if (parseInt($(this).attr('value')) > min_val)
        {
            $(this).hide();
        } else
        {
            $(this).show();
        }
    });
});
$('select[name=year_from]').change(function () {
    var min_val = parseInt($(this).val());
    $('select[name=year_to] option').each(function () {
        if (parseInt($(this).attr('value')) < min_val)
        {
            $(this).hide();
        } else
        {
            $(this).show();
        }
    });
});

$('select[name=year_to]').change(function () {
    var min_val = parseInt($(this).val());
    $('select[name=year_from] option').each(function () {
        if (parseInt($(this).attr('value')) > min_val)
        {
            $(this).hide();
        } else
        {
            $(this).show();
        }
    });
});

$(window).scroll(function () {
    if (search_calender_open == 1)
    {
        $('.xdsoft_datetimepicker').hide();
    }
});
/*$('.modal-dialog').mousewheel(function(){
 if(search_calender_open==1)
 {
 $('.xdsoft_datetimepicker').hide();
 }
 });*/

function openQuoteBox(id) {
    $("#div_" + id).show();
}

function saveQuotePrice(sell_car_id, asking_price) {

    sellCarId = sell_car_id;
    quotePrice = $('#edit_retail_price_' + sell_car_id).val();
    //alert(sellCarId+' '+sellCarPrice);
    if (quotePrice < 10000) {
        //alert('Please Enter Quote Price Greater Than 10,000.');
        snakbarAlert('Please Enter Quote Price Greater Than 10,000.');
        return false;
    }
    if (quotePrice > asking_price) {
        //alert('Quote Price Should Be Less Than '+indianCurrencyFormat(asking_price));
        snakbarAlert('Quote Price Should Be Less Than ' + indianCurrencyFormat(asking_price));
        return false;
    }
    $.ajax({
        type: "POST",
        url: base_url + "LeadSell/saveRetailPrice",
        data: {sellCarId: sellCarId, quotePrice: quotePrice},
        //beforeSend:function(){$('.countloaderprice').css('display','block');},
        //complete: function () {$('.countloaderprice').css('display','none');},
        success: function (responseData, status, XMLHttpRequest) {
            //alert(responseData);
            if ($.trim(responseData) == '1') {
                snakbarAlert("Quote Price has been saved");
                //$("#search_button").trigger('click');
                INR = indianCurrencyFormat(quotePrice);
                $("#refreshPrice_" + sell_car_id).html('<i data-unicode="f156" class="fa fa-inr">&nbsp;&nbsp;</i>' + INR);
                $("#div_" + sell_car_id).hide();

            } else {//alert("Quote Price has not been saved");
                snakbarAlert("Quote Price has not been saved");
            }
        }
    });
    // }
    // else{alert("Quote price should not be less than 10,000 and more than Asking Price");}
}

function cancelQuotePrice(divId) {

    $("#form_" + divId).trigger('reset');
    $("#div_" + divId).hide();

}
function indianCurrencyFormat(price) {
    var x = '';
    x = price.toString();
    var lastThree = x.substring(x.length - 3);
    var otherNumbers = x.substring(0, x.length - 3);
    if (otherNumbers != '')
        lastThree = ',' + lastThree;
    var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;

    return res;

}

function showCarImages(car_detail_id) {

    $.ajax({
        url: base_url + "LeadSell/show_mmv_images?car_detail_id=" + car_detail_id,
        type: 'POST',
        dataType: 'html',
        success: function (responseData) {
            $('#show_mmv_images').html(responseData);
        }
    });
}


var add_lead = 0;

function add_seller_lead()
{
    //alert($('#add_seller_lead_form').serialize());
    if (add_lead == 0)
    {
        $(this).prop('disabled', true); 
        var formdata=$('#add_seller_lead_form').serialize();
        $.ajax({
            url: base_url + "LeadSell/add_seller_lead",
            type: 'POST',
            data :formdata,
            dataType: 'html',
            success: function (data) {
               // alert(data);
                $('#add_seller_lead_msg').html(data);
                $(this).prop('disabled', false); 
                if (data.trim() == '<span class="success">Lead Added Successfully</span>')
                {
                    //alert(data);
                    var t = setTimeout(function () {
                        $('.sell_form_reset').click();
                        $('.add_lead_cancel').click();
                    }, 1000);

                    

                }
                add_lead = 0;
            }
        });
    }
    add_lead = 1;

}
function add_more() {
    $('#add_seller_car_details').append($('#add_seller_car_details .firstt').html());
    $("select[name='add_seller_fuel_type[]']").last().prop('value', '');
    $("input[name='other_color[]']").last().prop('value', '');
    $(".othercolors").last().hide();
}




$(function () {

    $(document).ready(function () {
        $('#make').on('change', function () {
            var selected = $(this).val();
            $.ajax({
                type: 'POST',
                url: base_url + "stock/getModel",
                data: {make: selected},
                dataType: "html",
                success: function (responseData)
                {
                    $('#model').html(responseData);
                    $('#model').prop('disabled', false);

                }
            });
        });

        $('.tabs_sell button').click(function () {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
        });



        $('.add_seller_myear').change(function () {
            //alert('asadsds');
            yearVal = this.value;
            if (yearVal == '') {
               htmlMake = '<option value="">Make</option>';
                $('.add_seller_make').html(htmlMake);
                htmlModel = '<option value="">Model</option>';
                $('.add_seller_model').html(htmlModel);
                htmlVersion = '<option value="">Version</option>';
                $('.add_seller_variant').html(htmlVersion);
                htmlFuel = '<option value="">Select</option>';
                $('.add_seller_fuel_type').html(htmlFuel);
                return false;
            } else {

                $.ajax({
                    type: "POST",
                    url: base_url +"inventories/getmakemodelversionlist",
                    data: {type: 'make', year: yearVal},
                    dataType: "html",
                    success: function (responseData, status, XMLHttpRequest) {
                        data = $.parseJSON(responseData);
                        var makeHtml = '';
                        makeHtml += '<option value="">Select</option>';
                        $.each(data, function (i, item) {
                            makeHtml += '<option class="'+item.id+'" value="' + item.make + '">' + item.make + '</option>';
                        });
                        $('.add_seller_make').html(makeHtml);
                        htmlModel = '<option value="">Model</option>';
                        $('.add_seller_model').html(htmlModel);
                        htmlVersion = '<option value="">Version</option>';
                        $('.add_seller_variant').html(htmlVersion);
                    }
                });
            }
        });




    });
});


 function get_model_list(ths) {
                var htmlVersion = '<option value="">Version</option>';
            $(ths).parent().parent().parent().next().find('.add_seller_model').html(htmlVersion);
            $(ths).parent().parent().parent().next().next().find('.add_seller_variant').html(htmlVersion);

            var htmlFuel = '<option value="">Select</option>';
            makeVal = $(ths).val(); 
            year = $("#year").val(); 
            $(ths).parent().parent().parent().next().next().next().next().next().next().find('.add_seller_fuel_type').html(htmlFuel);
            $.ajax({
                type: "POST",
                url: base_url +"inventories/getmakemodelversionlist",
                data: {make: makeVal, type: 'model'}, 
                dataType: "html", 
                success: function (responseData) {
                     data = $.parseJSON(responseData); 
                    var modelHtml = ''; 
                    modelHtml += '<option class="jmodel" value="">Model</option>'; 
                    $.each(data, function (i, item) { 
                        modelHtml += '<option class="jmodel_' + item.id + '" value="' + item.model + '">' + item.model + '</option>'; 
                    });
                    $(ths).parent().parent().parent().next().find('.add_seller_model').html(modelHtml);
                }
            });
        }
        function get_variant_list(ths) {
            
            var htmlFuel = '<option value="">Select</option>';
            $(ths).parent().parent().parent().next().next().next().next().next().find('.add_seller_fuel_type').html(htmlFuel);

            $.ajax({
                type: "POST",
                url: base_url +"inventories/getmakemodelversionlist",
                 data: {model_id: $(ths).val(), type: 'version',sellcar:'1'}, 
                dataType: "html", 
                success: function (responseData) {
                    //alert(responseData);
                    data = $.parseJSON(responseData); 
                    var versionHtml = ''; 
                    versionHtml += '<option class="jversion" value="">Variant</option>'; 
                    $.each(data, function (i, item) { 

                        //versionHtml += '<optgroup id="fueltype' + i + '" label="' + item.uc_fuel_type + '" style="background:#eee;">'; 
                        //versionHtml += '</optgroup>'; 
                        if(item.Displacement>0)
                        {
                        versionHtml += '<option class="jversion_' + item.db_version_id + '" value="' + item.db_version + '">' + item.db_version + ' (' + item.Displacement + ' CC)</option>'; 
                        }
                        else
                        {
                           versionHtml += '<option class="jversion_' + item.db_version_id + '" value="' + item.db_version + '">' + item.db_version ; 
                        }
                       
                    });
                    $(ths).parent().parent().parent().next().find('.add_seller_variant').html(versionHtml);
                }
            });
        }
 
function get_fuel_list(ths)
{

    var fuelVal = $(ths).val();
    //alert(fuelVal);
    if (fuelVal == '') {
        var htmlFuel = '<option value="">Select</option>';
        $(ths).parent().parent().parent().next().next().next().next().find('.add_seller_fuel_type').html(htmlFuel);
        return false;
    } else {
        $.ajax({
            type: "POST",
            url: base_url + "inventories/getmakemodelversionlist",
            data: {fuel_type: fuelVal, type: 'fuel'},
            dataType: "html",
            success: function (responseData) {
               // alert(responseData);
                data = $.parseJSON(responseData);
                var fuelHtml = '';
                //fuelHtml += '<option class="jfuel" value="">Select</option>';
                $.each(data, function (i, item) {
                    fuelHtml += '<option  value="' + item.uc_fuel_type + '">' + item.uc_fuel_type + '</option>';
                });
                //$('.add_seller_fuel_type').html(data);
                $('.add_seller_fuel_type').css('pointer-events', 'none');
                $(ths).parent().parent().parent().next().next().next().next().find('.add_seller_fuel_type').html(fuelHtml);
            }
        });
    }

}

function numbersonly(e)
{
    var unicode = e.charCode ? e.charCode : e.keyCode
    if (unicode != 8)
    { //if the key isn't the backspace key (which we should allow)
        if (unicode < 48 || unicode > 57) //if not a number
            return false //disable key press
    }
}

function get_other_color(th) {

    if ($.trim($(th).val()) == 'Other') {
        $(th).parent().parent().parent().next().show();
        //$('.othercolors').show();
    } else {
        //$('.othercolors').hide();
        $(th).parent().parent().parent().next().hide();
    }
}
 var start = 1;

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
    $('#sell_search_form #export').val('0')
    //var formDataload=$('#searchform').serialize();
    
    var formData = $('#sell_search_form').serialize();
            $.ajax({
                type: 'POST',
                url: base_url + "LeadSell/ajaxSellLead?page=" + $('#page').val(),
                data: formData,
                dataType: 'html',
                success: function (result) {
                    var resultArr = result.split('###');
                    var data = resultArr[0];
                    var total_records = resultArr[1];

                    if ($.trim(data) == '')
                    {
                        start--;
                        $('#page').attr('value', start);
                        $('#loadmoreajaxloader').text('No More Results');

                    } else
                    {
                        $('table.mytbl  tr:last').after(data);
                        //$('#load_more').html('Load More').attr('disabled', false);
                    }
                    $('#sell_customer_ajax_result').find('.calender').datetimepicker({timepicker: true, format: 'd-m-Y H:i', minDate: dd ? dd : false});
                    $('#sell_customer_ajax_result').find('[data-toggle="tooltip"],.source-icon').tooltip();
                    $('#sell_customer_ajax_result').find('.edit_name_email').click(function () {
                        $(this).parent().parent().find('.edit_text_box').show();
                        $(this).parent().parent().find('.name_email_text').hide();

                    });
                    $('.loader').hide();
                    $('#imageloder').hide();
                    $('.edit_hidden_save').css('background-color', $('#search_button').css('background-color'));



                }
            });
   
    }
    });