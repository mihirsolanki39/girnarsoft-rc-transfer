
$(document).ready(function () {
    $('.notiny-container').removeAttr('style');
    $('#buyersms_sub').click(function () {

        var send_type = $("#send_type").val();
        var check_tab = $('input[name="smstype"]:checked').val();
        if (send_type == 'sms') {
            var buyersmsn = $.trim($("#buyersmsn").val());
            var totalchecked = $('input[name="sms_gaadi_id[]"]:checked').length;
            //alert(buyersmsn);
            if (buyersmsn.length <= 0) {

                $("#error_message").text('Please Select A Car');
                setTimeout(function () {
                    $("#error_message").text('');
                }, 2500);
                return false;
            }
            var alphanumericpatterncomment = /^[A-Za-z\d()-_\s]+$/;
            if (buyersmsn.length > 0) {
                if ((!buyersmsn.match(alphanumericpatterncomment))) {

                    $("#error_message").text('Please Only Use Standard Alphanumerics');
                    setTimeout(function () {
                        $("#error_message").text('');
                    }, 2500);
                    return false;
                }
            }
            if (parseInt(buyersmsn.length) > 320) {

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

            $.ajax({
                type: 'POST',
                url: "ajax/buyer_sms_text.php?" + $('#buyersms_form').serialize(),
                data: "",
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
                            location.reload();
                        }, 2000);
                    } else {
                        //window.location.href='/user/log_out.php?exe=0';
                        return false;
                    }
                }

            });
        } else if (send_type == 'email') {
            // alert(232323);

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
                var url1 = 'ajax/send_car_details.php?id=' + values + '&customerid=' + customer_id + '&mobile=' + mobile + '&name=' + cd_customer_name + '&email_id=' + txtEmail + '&no_of_cars=' + totalchecked;

                $.ajax({
                    type: "POST",
                    url: url1,
                    data: "",
                    dataType: "html",
                    success: function (responseData) {
                        //alert(responseData);


                        if (responseData == '1') {
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


    $('#feedback_sub').click(function () {
        //var seesid = '<?= $_SESSION[ses_used_car_dealer_id] ?>';
        var feedback = $("#feedback").val();

        if (feedback.length <= 0) {
            alert('Please Fill Some Text');
            return false;
        }
        var alphanumericpatterncomment = /^[A-Za-z\d()-_\s]+$/;
        //var comment=$.trim($('#comment').val());
        if (feedback.length > 0) {
            if ((!feedback.match(alphanumericpatterncomment))) {
                alert("Please only use standard alphanumerics");
                return false;
            }
        }
        $.ajax({
            type: 'POST',
            url: "ajax/feedback_post.php?" + $('#feedback_form').serialize(),
            data: "",
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
                if (parseInt(responseData) > 0) {
                    $("#feedback_return").css({
                        "font-size": "100%",
                        "align": "center",
                        "color": "green"
                    });
                    $('#feedback_return').text("Thank You For Your feedback.");
                    $('#feedback_sub').hide();
                    $('.feedback_cancel').click(function () {
                        location.reload();
                    });
                } else {
                    return false;
                }
            }

        });
    });
});