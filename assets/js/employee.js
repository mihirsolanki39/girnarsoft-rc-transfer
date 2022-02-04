$(document).ready(function () {
    var max_bank_limit = $("#max_bank_limit").val();
    max_bank_limit = addCommasinnum(max_bank_limit, 'max_bank_limit', '', 1);
    $("#max_bank_limit").val(max_bank_limit);
    $('#dob').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-1000y',
        endDate: '-18y',
        autoclose: true,
        todayHighlight: true
    });
    $('#doj').datepicker({
        format: 'dd-mm-yyyy',
        //startDate: '-1000y',
        endDate: '+7d',
        autoclose: true,
        todayHighlight: true
    });
    var teamId = $("#team_id").val();
    if (teamId > 0)
        getRoleByTeam();
    var em = $("#role_id").val();
    var chek = $("#loanlimitadmin").val();
    if ((teamId > 0) && (chek == '2')) {
        if ((teamId == '3') || (teamId == '3')) {
            $('#showAddLimit').attr('style', 'margin-top:30px !important;' + 'margin-bottom:20px !important');
            $('.showtotalLimit').attr('style', 'margin-top:32px !important');
        } else {
            $('.showtotalLimit').attr('style', 'display:none; !important');
            $('#showAddLimit').attr('style', 'display:none; !important');
            $(".bank_limit_div").html("");
        }
    }
    var max_fields = $("#bank_count").val();
    var wrapper = $(".input_fields_wrap");
    var add_button = $(".add_field_button");

    var x = 0;
    var bnkcount = $('#bankidcount').val();
    if (bnkcount > 0) {
        x = bnkcount;
    }
    //    $(document).on("click",".add_field_button",function() {
    //    alert("click");
    //});
    $(document).on("click", ".add_field_button", function () {
        if (parseInt(x) < parseInt(max_fields)) {
            var tb = $('#totalbnk').val();
            var ab = checkBankLimit();
            if (ab == '1') {
                return false;
            }
            x++;
            var limitid = 'limitid_' + x;
            $(wrapper).append('<div class="col-md-12 bank_limit_div mrg-T15"><div class="row"><div class="col-lg-3 col-md-3 addlist" ><label for="Udob" class="customize-label">Bank Name*</label><select onchange=bankLi(this,"",1); data-field-name="Bank Name" class="form-control customize-form bankl testselect1"  name=bank[] id=bank_' + x + '></select><span class="e text-danger" id=errb_' + x + '></span></div><div class="col-lg-3 col-md-3 addlist" ><label for="Dname" class="customize-label">Assign Limit*</label><input data-field-name="Assign Limit" type="text" autocomplete="off" id=limitid_' + x + '  name=limit[] onkeyup="addCommasinnum(this.value,' + "'" + limitid + "'" + ');"   onkeypress="return isNumberKey(event)" class="form-control customize-form limitset rupee-icon" onchange=limitSet(this) /><span class="e text-danger" id=errl_' + x + '></span><div class="text-danger" id=error_' + x + '></div> </div><div class="col-lg-3 col-md-3 mrg-T30" id="showAddLimit"><button type="button" class=" btn btn-default remove_field" id=remove_' + x + '>Remove</button></div></div>').find('#bank_' + x).SumoSelect({ triggerChangeCombined: true, search: true, searchText: 'Search here.' });
            jQuery.ajax({
                type: "POST",
                url: base_url + "user/getBankOptions/",
                dataType: 'html',
                data: $('#add_user').serialize(),
                success: function (data) {

                    var id = $('#id').val();
                    $('#bank_' + x).append('<option>Select</option>');
                    $('#bank_' + x).html(data);
                    $('#totalbnk').val(x);
                    $('#bank_' + x)[0].sumo.reload();
                }

            });
        }
        return false;
    });

    $(wrapper).on("click", ".remove_field", function (e) {
        var rm_id = $(this).attr('id');
        var ids = rm_id.split("_");
        var limit = $('#limitid_' + ids[1]).val();
        var tb = $('#totalbnk').val();
        var y = parseInt(tb) - 1;
        var abnkcount = $('#bank_count').val();
        $('#totalbnk').val(y);
        sub(limit);
        $(this).parent('div').parent('div').parent('.bank_limit_div').remove();
        //  return false;
        var next = parseInt(ids[1]) + 1;
        if (tb > 0) {
            for (var a = ids[1]; a <= tb; a++) {
                if (a <= abnkcount) {
                    $('#bank_' + next).attr('id', 'bank_' + a);
                    $('#limitid_' + next).attr('id', 'limitid_' + a);
                    $('#remove_' + next).attr('id', 'remove_' + a);
                    $('#errl_' + next).attr('id', 'remove_' + a);
                    $('#errb_' + next).attr('id', 'remove_' + a);
                    next++;
                }
            }
        }
        x--;
    });
    $('#dealerPass').click(function (e) {
        $('#password').attr('type', 'text');
    });
});

$(".submit_emp").click(function () {
    $(".loaderClas").css("display", "block");
    $(".submit_emp").attr("disabled", true);
    var validateBankLimit = checkBankLimit();
    var form_validation = checkFormValidation();

    // console.log(validateBankLimit);
    // console.log(form_validation);
    // return false;

    if (validateBankLimit == 1 || form_validation == 1) {
        $(".loaderClas").css("display", "none");
        $(".submit_emp").attr("disabled", false);
        return false;
    } else {
        saveEmployee();
    }
});

function saveEmployee() {
    var hidden_edit_id = $("#hidden_edit_id").val();
    if (hidden_edit_id != "")
        var url = base_url + "addUser" + "/" + hidden_edit_id;
    else
        var url = base_url + "addUser";
    var formData = $('#add_user').serialize();
    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        dataType: 'json',
        success: function (data) {
            if (data.status == '1') {

                setTimeout(function () {
                    window.location.href = base_url + "userList";
                }, 2500);
                return true;
            } else {
                $(".loaderClas").css("display", "none");
                $(".submit_emp").attr("disabled", false);
                snakbarAlert(data.message);
                return false;
            }
        }
    });
}
function checkFormValidation() {
    var err = '0';
    $("#add_user").find("input,select").each(function () {
        var field_name = $(this).data('field-name');
        var input_id = $(this).attr('id');
        $(this).parent('div').parent('div').find('.error_' + input_id).html('');
        if ($(this).val() == "" && field_name != undefined & field_name != "") {
            $(this).parent('div').parent('div').find('.error_' + input_id).html('The ' + field_name + ' field is required.');
            err = '1';
        }
    });
    return err;
}
$("#team_id").change(function () {
    //    var teamId = $("#team_id").val();
    //    var chek = $("#loanlimitadmin").val();
    //    if (((teamId == '3') || (teamId == '3')) && (chek == '2'))
    //    {
    //        $('#showAddLimit').attr('style', 'margin-top:32px !important');
    //        $('.showtotalLimit').attr('style', 'margin-top:32px !important');
    //    } else
    //    {
    //        $('.showtotalLimit').attr('style', 'display:none; !important');
    //        $('#showAddLimit').attr('style', 'display:none; !important');
    //    }
    getRoleByTeam();
    //    if(teamId != 3)
    //       $(".bank_limit_div").html("");
});

$("#role_id").change(function () {
    var teamId = $("#team_id").val();
    var chek = $("#loanlimitadmin").val();
    if (((teamId == '3') || (teamId == '3')) && (chek == '2')) {
        $('#showAddLimit').attr('style', 'margin-top:32px !important');
        $('.showtotalLimit').attr('style', 'margin-top:32px !important');
    } else {
        $('.showtotalLimit').attr('style', 'display:none; !important');
        $('#showAddLimit').attr('style', 'display:none; !important');
    }
    if (teamId != 3)
        $(".bank_limit_div").html("");
});

function bankLi(bn, id = '', flag = "", bank_id = "") {
    if (bank_id == "") {
        var text = bn.options[bn.selectedIndex].value;
        var bank = text;
        var id = bn.id;
        var ids = id.split("_");
        if (flag == 1) {
            $("#limitid_" + ids['1']).val("");
            addLimit();
        }
    } else {
        var bank = bank_id;
        addLimit();
    }
    jQuery.ajax({
        type: "POST",
        url: base_url + "user/getBankLimit/",
        data: { "bank_id": bank, edit_id: $("#hidden_edit_id").val() },
        async: false,
        dataType: 'json',
        success: function (data) {
            $('#bank_limit_max').val(data);
        }
    });
}
function limitSet(limit, k = '') {
    var aaa = $('#totalbnk').val();
    var limits = limit.value;
    limits = limits.replace(/,/g, '');
    var limit_id = limit.id;
    var ids = limit_id.split("_");
    var bank_id = $('#bank_' + ids[1]).val();
    var data = $('#bank_limit_max').val();
    if (limits.length > 9) {
        $('#error_' + ids[1]).html("Please enter a valid Assign Limit");
        $('#limitid_' + ids[1]).val("");
        return false;
    }
    if (data == '') {
        bankLi("", "", "", bank_id);
        var data = $('#bank_limit_max').val();
    }
    if (data != '') {
        if (parseInt(limits) > parseInt(data)) {
            $('#error_' + ids[1]).html("Limit cannot be added as limit left " + parseInt(data));
            $('#limitid_' + ids[1]).val("");
            return false;
        } else {
            addLimit();
            $('#error_' + ids[1]).html("");
        }
    }
    return false;
}
function add(argument) {
    var s = $('#max_bank_limit').val();
    s = (s * 100 + argument * 100) / 100;
    $('#max_bank_limit').val(s);
}
function addLimit() {
    var sum = '0';
    $(".bank_limit_div").each(function () {
        $(this).find("input.limitset").each(function () {
            var limit_val = $(this).val().replace(/,/g, '');
            if (limit_val != "") {
                sum = parseInt(sum) + parseInt(limit_val);
            }
        });
    });
    sum = addCommasinnum(sum, max_bank_limit, 1, 1)
    $('#max_bank_limit').val(sum);
}
function sub(argument) {
    argument = argument.replace(/,/g, '');

    var s = $('#max_bank_limit').val().replace(/,/g, '');
    s = (s * 100 - argument * 100) / 100;
    s = addCommasinnum(s, max_bank_limit, 1, 1);
    $('#max_bank_limit').val(s);
}
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
$('#name').keypress(function (event) {
    var inputValue = event.which;
    //alert(inputValue);
    if (!(inputValue >= 65 && inputValue <= 123) && (inputValue != 32 && inputValue != 0 && inputValue != 8)) {
        event.preventDefault();
        return false;
    }
});

function checkBankLimit() {
    var err = '0';
    $(".bank_limit_div").each(function () {
        $(this).find("input,select").each(function () {
            var field_name = "";
            var field_name = $(this).data('field-name');
            if ($(this).val() == "" && field_name != undefined & field_name != "") {
                if (field_name == "Bank Name") {
                    $(this).parent('div').parent('div').find('.e').html("The Bank Name is required.");
                } else {
                    $(this).parent('div').find('.e').html("The Assign Limit is required.");
                }
                err = '1';
            } else {
                $(this).parent('div').parent('div').find('.e').html("");
                $(this).parent('div').find('.e').html('');
            }
        });
    });
    return 0;
    return err;
}
$('#role_id').change(function () {
    var text = $(this).find("option:selected").text();
    $('#dealerList').attr('style', 'display:none');
    if (text.toLowerCase() == 'field') {
        $('#dealerList').attr('style', 'display:block');
    }
});
function addCommasinnum(nStr, control, flag = '', flag1 = '') {
    if (flag == '') {
        nStr = nStr.replace(/,/g, '');
    } else {
        nStr = nStr;
    }
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
    }
    len = x1.length;
    if (len >= 3 && x3 != "") {
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
    }
    if (flag1 == 1)
        return x1 + x3 + x2;
    else
        document.getElementById(control).value = x1 + x3 + x2;
}

function getRoleByTeam() {
    var teamID = $("#team_id").val();
    jQuery.ajax({
        type: "POST",
        url: base_url + "user/getRole/",
        dataType: 'json',
        data: { teamId: teamID },
        success: function (data) {
            // console.log(data);
            // return false;
            $('#role_id').empty();
            $('#role_id').append('<option value="">Select Role</option>');
            $.each(data, function (key, value) {
                var sel = '';
                if (role_id == value.id) {
                    sel = 'selected=selected';
                }
                $('#role_id').append('<option value="' + value.role_id  + '-' + value.team_id + '" ' + sel + ' >' + value.team_name + ' - ' +value.role_name + '</option>');
            });
            $('#role_id')[0].sumo.reload();
        }
    });
}