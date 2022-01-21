$(document).ready(function() {
    setInterval(function() {
        $.ajax({
            type: "POST",
            url: "/user/ajax/ajax_count_notification.php",
            data: "",
            dataType: "html",
            success: function(responseData, status, XMLHttpRequest) {
                if (responseData != '0') {
                    $("#appendcountnotification").text(responseData);
                    $.ajax({
                        type: "POST",
                        url: "/user/ajax/ajax_notification_module.php",
                        data: "",
                        dataType: "html",
                        success: function(responseData, status, XMLHttpRequest) {
                            $("#appendDivModule").html(responseData);
                        }
                    })
                }
            }
        })
    }, 100000 * 15);
    
    $('.mark_all').bind('click', function(event) {
        var id = this.id;
        var splitId = id.split('-');
        if (splitId == 'allasread') {
            var url = 'notification_new.php';
            $('#today_inventory').attr('action', 'notification_new.php');
            var type = 'allread';
        } else {
            var type = 'singleread';
            if (splitId['2'] == '1' && ($.trim(splitId[4]) == 'buyer_lead_on_car' || $.trim(splitId[4]) ==
                    'follow_remider')) {
                var url = 'buyer_enquires.php';
                $('#today_inventory').attr('action', '/user/buyer_enquires.php');
                $('#today').attr('value', $.trim(splitId['3']));
            } else if (splitId[2] == '1' && $.trim(splitId[4]) == 'Buyer_Lead_from_UB') {
                var url = 'buyer_enquires.php';
                $('#today_inventory').attr('action', '/user/buyer_enquires.php');
                $('#today').attr('value', $.trim(splitId[3]));
            } else if (splitId['2'] == '2' && $.trim(splitId[4]) == 'Seller_Lead_posted_on_website') {
                var url = 'seller_enquiry.php';
                $('#today_inventory').attr('action', '/user/seller_enquiry.php');
                $('#today').attr('value', $.trim(splitId['3']));
            } else if (splitId['2'] == '1' && $.trim(splitId[4]) == 'finance_enquiry') {
                var url = 'manage_finance_queries_new.php';
                $('#today_inventory').attr('action', '/user/manage_finance_queries_new.php');
                $('#today').attr('value', $.trim(splitId[3]));
            } else if (splitId['2'] == '1' && $.trim(splitId[4]) == 'insurance_enquiry') {
                var url = 'manage_insurance_queries_new.php';
                $('#today_inventory').attr('action', '/user/manage_insurance_queries_new.php');
                $('#today').attr('value', $.trim(splitId[3]));
            } else if (splitId[2] == '1' && $.trim(splitId[4]) == 'Contact_form_Enquiry') {
                var url = 'contact_us_lead.php';
                $('#today_inventory').attr('action', '/user/contact_us_lead.php');
                $('#today').attr('value', $.trim(splitId[3]));
            } else if (splitId[2] == '1' && $.trim(splitId[4]) == 'On_road_price_enquiry') {
                var url = 'orp_leads.php';
                $('#today_inventory').attr('action', 'orp_leads.php');
                $('#today').attr('value', $.trim(splitId[3]));
            } else if (splitId[2] == '2' && $.trim(splitId[4]) == 'Seller_Lead_from_US') {
                var url = 'seller_enquiry.php';
                $('#today_inventory').attr('action', '/user/seller_enquiry.php');
                $('#today').attr('value', $.trim(splitId[3]));
            } else if (splitId[2] == '2' && $.trim(splitId[4]) == 'testimonial_posted_on_website') {
                var url = 'testimonial_list_new.php';
                $('#today_inventory').attr('action', '/user/testimonial_list_new.php');
                // $('#today').attr('value',$.trim(splitId[3]));
            } else if (splitId[2] == '2' && $.trim(splitId[4]) == 'Seller_Lead_posted_on_website') {
                var url = 'seller_enquiry.php';
                $('#today_inventory').attr('action', '/user/seller_enquiry.php');
                $('#today').attr('value', $.trim(splitId[3]));
            }
        }
        $.post('/user/ajax/ajax_deactivate_notification.php', {
            id: id,
            type: type
        }, function(data) {}, 'json');
        setInterval(function() {
            $('#today_inventory').submit();
        }, 1000);
    });
});