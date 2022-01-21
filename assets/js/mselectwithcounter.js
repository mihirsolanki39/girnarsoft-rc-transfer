$(document).ready(function () {
    var counter = 0;
    $('.heading').each(function (index, item) {
        var getId = $(this).attr('id');
        var getCounnt = $('#' + getId).next('ul[data-rel="' + getId + '"]').find('input:checkbox:checked').length;
        //alert(getCounnt);
        var id = $("#" + getId + " > input").attr('id');
        //alert(id);
        if (getCounnt > 0) {
            counter++;
            if (counter == 1) {
                $('.select-dd-btn').text('');
            }
            $('#' + id).prop('checked', true);
            $('.select-dd-btn').append('<span class="dd-data" data-span="' + getId + '">' + $("#" + getId + " > label").text() + '(' + getCounnt + ') <span class="close-dd">X</span> </span>');
            $('#dealer_type_check').val(getCounnt);
        }

    });

    // CLICK ON BUTTON
    $('#Dealershiptoggle').on('click', function () {
        $('.select-dd-dropdown').slideDown();
    });
    $("div#Dealershiptoggle")
            .mouseleave(function () {
                $('.select-dd-dropdown').slideUp();
            });
//$(document).click(function() {
//   $('.select-dd-dropdown').slideUp();
//});
//$("#Dealershiptoggle").click(function(event) {
//   $('.select-dd-dropdown').slideDown();
//   // event.stopPropagation();
//});
    // CLICK ON MAIN OPTION (OPTIONGROUP)
    $(document).on('click', '.heading input', function () {
        var chkAttrStatus = $(this).prop('checked');
        var getDataID = $(this).parent().attr('id');
        var numberOfChecked = $('input:checkbox:checked').length;
        var getClickedCounnt = $(this).parent().next('ul[data-rel="' + getDataID + '"]').find('input').length;
        if (chkAttrStatus == false) {
            $(this).parent().next().find('input').prop('checked', false);
            $('span[data-span="' + $(this).parent().attr('id') + '"]').remove();
            if ($('.select-dd-btn span').length < 1) {
                $('.select-dd-btn').text('Select Type');
                $('#dealer_type_check').val('');
            }
        } else {
            $(this).parent().next('ul[data-rel="' + getDataID + '"]').find('input').prop('checked', true);
            if ($('.select-dd-btn').text() == 'Select Type') {
                $('.select-dd-btn').text('');
                $('#dealer_type_check').val('');
            }
            if (getClickedCounnt < 1) {
                var dispCount = '';
            } else {
                var dispCount = '(' + getClickedCounnt + ')';
            }
            $('.select-dd-btn').append('<span class="dd-data" data-span="' + getDataID + '">' + $(this).next('label').text() + dispCount + ' <span class="close-dd">X</span> </span>');
            if (getClickedCounnt > 1) {
                $('#dealer_type_check').val(getClickedCounnt);
            }
        }
    });

    // CLICK ON IN DIVISUAL OPTIONgetClickedCounnt
    $(document).on('click', '.option-dd input', function () {
        var chkAttrStatus = $(this).parents('ul').find('input:checked').length;
        var getMainTxt = $(this).parents('ul').attr('data-rel');
        if (chkAttrStatus < 1) {
            $(this).parents('ul').prev().find('input').prop('checked', false);
            $('span[data-span="' + getMainTxt + '"]').remove();
            if ($('.select-dd-btn span').length < 1) {
                $('.select-dd-btn').text('Select Type');
            }
        } else {
            $(this).parents('ul').prev().find('input').prop('checked', true);
            if ($('.select-dd-btn').text() == 'Select Type') {
                $('.select-dd-btn').text('');
            }
            $('span[data-span="' + getMainTxt + '"]').remove();
            $('.select-dd-btn').append('<span class="dd-data" data-span="' + getMainTxt + '">' + $.trim($('#' + getMainTxt).text()) + '(' + $(this).parents('ul').find('input:checked').length + ') <span class="close-dd">X</span></span>');
            $('#dealer_type_check').val(chkAttrStatus);


        }
    });

    $(document).on('click', '.close-dd', function () {
        var getPdaSp = $(this).parent().attr('data-span');
        $('#' + getPdaSp).find('input').prop('checked', false);
        $('ul[data-rel="' + getPdaSp + '"]').find('input').prop('checked', false);
        $(this).parent().remove();
        if ($('.select-dd-btn span').length < 1) {
            $('.select-dd-btn').text('Select Type');
            $('#dealer_type_check').val('');
        }

    });
})