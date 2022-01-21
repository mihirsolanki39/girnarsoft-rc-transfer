$('#save_Enquiries').click(function () {
    var txtmobile = $.trim($('#txtmobile').val());
    var followuodate = $.trim($('#follow-uo-date').val());
    var dfollowdate = $.trim($('#dfollow-uo-date').val());
    //dfollowdate
    var txtEmail = $.trim($('#txtemail').val());
    var alphanumericpattern = /^[A-Za-z\s.]+$/;
    var pincodePattern = /^[6-9][0-9]{9}$/;
    var txtname = $.trim($('#txtname').val());
    var cd_alternate_mobile = $.trim($('#cd_alternate_mobile').val());
    var errror = true;
    var followuodate2 = $.trim($('#followuodate2').val());
    var emailRegex = new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i);
    var price_min = $('#price_min').val();
    var price_max = $('#price_max').val();

    var status = $.trim($('#cusstatus').val());		//newadddedd

    if ((status != 'New') && followuodate == '')
    {
        snakbarAlert('Please select follow up date and time.');
        $('#follow-uo-date').focus();
        error = true;
        return false;
    }
    if (followuodate == '' && $.trim($('#txtcomment').val()) != '') {
        snakbarAlert('Please select follow up date and time.');
        $('#follow-uo-date').focus();
        error = true;
        return false;

    }

    if (txtname == '')
    {
        snakbarAlert('Please Enter Fullname.');
        $('#txtname').focus();
        var error = true;
        return false;
    }

    if (txtname != '')
    {

        if (txtname.length < 3) {
            snakbarAlert('Please enter Min 3 characters.');
            $('#txtname').focus();
            errror = false;
            return false;

        } else if ((!txtname.match(alphanumericpattern)))
        {
            snakbarAlert('Please Enter Valid Name.');
            $('#txtname').focus();
            errror = false;
            return false;

        }

    }
    if (followuodate != '') {


                var d = Date.parse(followuodate);
        var e = Date.parse(followuodate2);
        var f = Date.parse(dfollowdate);
        if (d == f) {
            errror = true;
        } else if (d >= e) {
            errror = true;

        } else {
            snakbarAlert('Follow up date and time cannot be in past.');
            return false;
        }

    }

    if (txtEmail != '') {
        if ((!emailRegex.test(txtEmail)))
        {
            snakbarAlert('Please Enter Valid Email.');
            $('#txtEmail').focus();
            errror = false;
            return false;
        }

    }

    if (txtmobile == '' || (txtmobile.length != 10) || (!txtmobile.match(pincodePattern)))
    {
        snakbarAlert('Please enter valid mobile number.');
        $('#txtmobile').focus();
        errror = false;
        return false;
    }
    if (status == '')
    {
        snakbarAlert('Please select status.');
        errror = false;
        return false;
    }
    if (cd_alternate_mobile != '') {
        if (cd_alternate_mobile == '' || (cd_alternate_mobile.length != 10) || (!cd_alternate_mobile.match(pincodePattern)))
        {
            snakbarAlert('Please enter valid mobile number.');
            $('#cd_alternate_mobile').focus();
            errror = false;
            return false;
        }
    }


    var txtcomment = $('#txtcomment').val();
    var alphanumericpatterncomment = /^[A-Za-z\d()-_\s]+$/;
    if (txtcomment != '') {
        if ((!txtcomment.match(alphanumericpatterncomment)))
        {
            snakbarAlert('Please Enter Vaild Text.');
            $('#txtcomment').focus();
            errror = true;
            return false;

        }
    }

    var type = $('#type').val();

    var carstype = '';
    if (type != 'custom')
    {
        var totalchecked = $("input[class='simchack']:checked").length;
        var totalcheckedvalue = $("input[class='simchack']:checked").val();
        var text = '';
        var values = '';
        if (totalchecked > 0)
        {
            $("input[class='simchack']:checkbox:checked").each(function () {
                values += $(this).val() + ',';
            });
            values = values.substring(0, values.length - 1);
            carstype = '&gaadi_id=' + values + '&type=' + type;
        }


    } else {

        var make0 = $.trim($('#make0').val());
        var model0 = $.trim($('#model0').val());
        var version0 = $.trim($('#version0').val());
        if (make0 != '') {

            if (make0 == '') {
                alert('Please select make.');
                $('#make0').focus();
                errror = false;
                return false;
            }
            if (model0 == '') {
                alert('Please select model.');
                $('#model0').focus();
                errror = false;
                return false;
            }
            if (version0 == '') {
                alert('Please select vesion.');
                $('#version0').focus();
                errror = false;
                return false;
            }


            carstype = '&' + $('#buyerenquiry_form').serialize();
        }
    }


    if (errror = true) {
        $('#save_Enquiries').attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: base_url+"lead/addNewLead",
            data: $('#editcustomer').serialize() + carstype,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
                var ress =  $.parseJSON(responseData);
                console.log(ress);
                if (ress == '1')
                {
                    snakbarAlert('Follow up date should not be less than current date.');
                    $('#save_Enquiries').removeAttr('disabled');
                    return false;
                } else if (ress.status == 'T')
                {
                    $('#model').removeAttr('disabled');
                    snakbarAlert('Lead Added successfully');
                    setTimeout(function () {
                        window.top.location.href = "lead/getLeads";
                    }, 3000);
                } else {
                    snakbarAlert('Sorry lead not added successfully');
                }
            }
        })
    }

});

$('#make').on('change', function () {
    var selected = $(this).val();
    $.ajax({
        type: 'POST',
        url: base_url+"lead/getModel",
        data: {make: selected},
        dataType: "html",
        success: function (responseData)
        {
            $('#model').html(responseData);

        }
    });
    });
$('.type').click(function () {
    $('#imageloder').show();
    $('#cartype').html('');
    var elm = $(this);
    var type = elm.attr('id');
    if (type == 'search') {
        type = $('#type').val();
    }
    $('#type').attr('value', type);
    $('#typef').attr('value', type);
    $.ajax({
        type: 'POST',
        url: base_url+"lead/ajax_edit_buyer_similar_car",
        data:$('#buyerenquiry_form').serialize() + "&" + $('#searchform').serialize(),
        dataType: 'html',
        success: function (responseData, status, XMLHttpRequest) {
            var res = responseData.split('@@###$$');
            var countcar = res[1].split('@==========@');
            if (parseInt(res[0]) == 1) {
                $('#imageloder').hide();
                $('#cartype').html('No Record Found');
                $('#spnsimilar_cars').html(countcar[0]);
                $('#spnalldealer_cars').html(countcar[1]);
                $('#model').removeAttr('disabled');
            } else {
                $('#imageloder').hide();
                $('#cartype').html(res[0]);


                $('#model').removeAttr('disabled');
                $('#spnsimilar_cars').html(countcar[0]);
                $('#spnalldealer_cars').html(countcar[1]);

            }


        }
    })

});


function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}


	
  $('#Reset').click(function () {
    $('#keyword').val('');
    $('#make').val('');
    $('#model').val('');
    $('#model').attr('disabled', 'disabled');
    $('#price_min').val('');
    $('#price_maxn').val('');

    $('#km_from').val('');
    $('#km_to').val('');
    $('#year_from').val('');
    $('#year_to').val('');
    $('#fuel_type').val('');

    $("#transmission_type").val('');
    //$('#regno').val('');


    $('select[name=budget_max] option').each(function () {
        $(this).show();
    });

    $('select[name=budget_min] option').each(function () {
        $(this).show();
    });

    $('select[name=price_max] option').each(function () {
        $(this).show();
    });

    $('select[name=price_min] option').each(function () {
        $(this).show();
    });

    $('select[name=km_to] option').each(function () {
        $(this).show();
    });

    $('select[name=km_from] option').each(function () {
        $(this).show();
    });

    $('select[name=year_to] option').each(function () {
        $(this).show();
    });

    $('select[name=year_from] option').each(function () {
        $(this).show();
    });

    $('#search').trigger("click");
});

$('select[name=budget_min]').change(function () {
    var min_val = parseInt($(this).val());
    if (parseInt(min_val) == '1500000') {

        $('select[name=budget_max]').attr('disabled', 'disabled');
        $('select[name=budget_max]').val('');
    } else {
        $('select[name=budget_max]').removeAttr('disabled');
    }
    $('select[name=budget_max] option').each(function () {
        if (parseInt($(this).attr('value')) < min_val)
        {
            $(this).hide();
        } else
        {
            $(this).show();
        }
    });
});
$('select[name=budget_max]').change(function () {
    var min_val = parseInt($(this).val());
    $('select[name=budget_min] option').each(function () {
        if (parseInt($(this).attr('value')) > min_val)
        {
            $(this).hide();
        } else
        {
            $(this).show();
        }
    });
});
$('select[name=price_min]').change(function(){
var min_val = parseInt($(this).val());
    $('select[name=price_max] option').each(function(){
        if(parseInt($(this).attr('value'))<min_val)
        {
            $(this).hide();
        }else
        {
            $(this).show();
        }
    });
});
$('select[name=price_max]').change(function(){
var min_val = parseInt($(this).val());
    $('select[name=price_min] option').each(function(){
        if(parseInt($(this).attr('value'))>min_val)
        {
            $(this).hide();
        }else
        {
            $(this).show();
        }
    });
});

$('select[name=km_from]').change(function(){
var min_val = parseInt($(this).val());
//alert(min_val);
    $('select[name=km_to] option').each(function(){
        if(parseInt($(this).attr('value'))<parseInt(min_val))
        {
			
            $(this).hide();
        }else
        {
		
            $(this).show();
        }
    });
});
$('select[name=km_to]').change(function(){
var min_val = parseInt($(this).val());
//alert(min_val);
    $('select[name=km_from] option').each(function(){
        if(parseInt($(this).attr('value'))>parseInt(min_val))
        {
			
            $(this).hide();
        }else
        {
			
            $(this).show();
        }
    });
});
$('select[name=year_from]').change(function(){
var min_val = parseInt($(this).val());
    $('select[name=year_to] option').each(function(){
        if(parseInt($(this).attr('value'))<min_val)
        {
			
            $(this).hide();
        }else
        {
			
            $(this).show();
        }
    });
});

$('select[name=year_to]').change(function(){
var min_val = parseInt($(this).val());
    $('select[name=year_from] option').each(function(){
        if(parseInt($(this).attr('value'))>min_val)
        {
			
            $(this).hide();
        }else
        {
			
            $(this).show();
        }
    });
});

 $(function () {
        var closediv = $(".multi-dropdwn").next(" .dropdown-menu");
        $(".multi-dropdwn").click(function (e) {
            $(this).next(" .dropdown-menu").toggle();
        })
        $(document).mouseup(function (e) {
            if (closediv.has(e.target).length == 0) {
                closediv.hide();
            }
        })
    });
    
$('#keyword,#make,#model,#km_from,#km_to,#transmission_type,#price_min,#price_maxn,#fuel_type').keypress(function (e) {
    if (e.which == 13) {
        $('#search').trigger("click");
        return false;
    }
}); 
$('#txtname,#txtmobile,#cd_alternate_mobile').bind("cut copy paste",function(e) {
     e.preventDefault();
 });