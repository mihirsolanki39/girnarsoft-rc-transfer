



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Vikas" >
        <link rel="icon" href="../images/favicon.ico">
        <title>Manage Stock</title>
        <!-- Bootstrap core CSS -->
        <link href="http://rakesh.com/origin-assets/boot_origin_asset_new/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="http://rakesh.com/origin-assets/boot_origin_asset_new/css/common-advance.css" rel="stylesheet">
        <link href="http://rakesh.com/origin-assets/boot_origin_asset_new/css/bootstrap-select.css" rel="stylesheet">
                    <link href="http://rakesh.com/origin-assets/boot_origin_asset_new/css/dashboard.css?t=342" rel="stylesheet">
                <!-- Common styles for this template -->
        <link href="http://rakesh.com/origin-assets/boot_origin_asset_new/css/common.css" rel="stylesheet">
        <!-- Common styles for this template -->
        <link href="http://rakesh.com/origin-assets/boot_origin_asset_new/css/font-awesome.css" rel="stylesheet">
        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="js/assets/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="http://rakesh.com/origin-assets/boot_origin_asset_new/js/assets/ie-emulation-modes-warning.js"></script>
        <link href="http://rakesh.com/origin-assets/boot_origin_asset_new/css/progressbar.css" rel="stylesheet">
        <link href="http://rakesh.com/origin-assets/boot_origin_asset_new/css/bootstrap-select.css" rel="stylesheet">
        <link href="http://rakesh.com/origin-assets/boot_origin_asset_new/css/cropper.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="http://rakesh.com/origin-assets/boot_origin_asset_new/js/jquery.min.js"></script>
        <script src="http://rakesh.com/origin-assets/boot_origin_asset_new/js/cropper.js"></script>
        
        <style>
            #newNav .nav>li>a {
            position: relative;
            display: block;
            padding: 20px 10px;
            margin-right: 5px !important;
            }
        </style>
      <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push(
        {'gtm.start': new Date().getTime(),event:'gtm.js'}

        );var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5HL99N5');</script>
        <!-- End Google Tag Manager -->
        <script>
            
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
                    //var seesid = '1217';
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
        </script>
    </head>
    
    <body>
        <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5HL99N5"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
        <style>
            .ui-helper-hidden-accessible{display:none !important;}
        
        </style>
                        <nav role="navigation" class="navbar mrg-all-20 mrg-T0 mrg-B0 welcome-zindex nav321"  >
            <div class="navbar-header top-navigation float-L">
                                    <a class="navbar-brand pad-all-0 pad-R10  pad-T10 gaadi-cardekho" href="/user/dash_dealer.php">
                        <img src="http://rakesh.com/origin-assets/boot_origin_asset_new/images/dealer-central.png" alt="Dealer Central" title="Dealer Central" class="img-responsive cd-logo" />
                    </a>
                                                                        
                     <a class="navbar-brand pad-all-0 pad-L0" >
                         <img src="http://static10.usedcarsin.in/dealer_site/-dlr70-309982_10150863934644878_645816086_n_1350889060.jpg" alt="Dealer Wedsite Logo" title="Saroj Sahoo Test1" class="img-responsive" style="height:60px !important"/>
                        </a>
                       
                                                </div>
                                                <div id="login-btn-mob">
                        <ul class="nav navbar-nav navbar-right mob-login-hide">
                                                       
                            
                                                            <!-- <li class="dropdown login-btn-mob border-R">
                                    <a href="/user/notification_new.php" class="dropdown-toggle pad-T10 pad-B10 border-none wel-dealer">
                                        <span class="bg-edit pos-rel"> <img src="http://rakesh.com/origin-assets/boot_origin_asset_new/images/svg/notification.svg" alt="Dealer" title="Dealer"></span>
                                        <span class="badge notification font-9 " id="appendcountnotification"><span class=""></span></span>
                                    </a> 
                                    <div id="appendDivModule">
                                                                                    <ul role="menu" class="dropdown-menu welcome-dropdown notification_width" role="menu" style="display: none;">
                                                <div class="notification_list  notification-scroll " style="max-height:300px;">
                                                                                                             <li> 
                                                            <a style="cursor:pointer;" id="row-h-h-h-h "  target="_top" class="mark_all" style="background: transparent none repeat scroll 0% 0%;">h</a>
                                                        </li>
                                                                                                    </div>
                                                <li class="ddr_t"> 
                                                    <button id="allasread" class="btn btn btn-primary notification-btn mrg-L5 mark_all"  type="button">Mark as all read</button>
                                                    <button id="viewall" class="btn btn btn-primary notification-btn mrg-L5" onclick="location.href = '/user/notification_new.php';"  type="button">View all</button>  
                                                </li>
                                            </ul>
                                                                            </div>-->
                                </li>                            <li class="dropdown login-btn-mob border-R">
                                                                    <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle border-none wel-dealer" href="#">
                                    
                                    <span class="bg-edit"> <img src="http://rakesh.com/origin-assets/boot_origin_asset_new/images/svg/support.svg" alt="Dealer" title="Dealer">
                                    </span>   
                        <span class="text"> Support</span> <i class="fa fa-chevron-down down-arrow"></i> 
                        

                                    </a>
                                                                <ul role="menu" class="dropdown-menu welcome-dropdown">
                                    <li class="text-center">
                                        <div class="support-detail">
                                            <h4>DEALER HELPLINE</h4>
                                            <div class="support-dashed"></div>
                                            <span class="support-no"><i class="fa fa-phone font-20 pad-R10" data-unicode="f095"></i><strong>+91-9069138803</strong></span><br>
                                            <span class="support-small-txt">(10:00AM - 7:00PM)</span><br>
                                            <span class="support-small-txt"><a href="mailto:dealersupport@gaadi.com?Subject=Dealer Central Feedback" target="_top">dealersupport@gaadi.com</a></span>
                                            <!-- <h5><a href="/user/tutorials.php">FAQ</a></h5>-->
                                            <button type="button" class="btn btn-primary mrg-T10"  data-target="#feedBack" data-toggle="modal">Feedback</button>
                                    </li>
                                </ul>
                            </li>
                            <!--<li class="nav-border-right  pad-T10 pad-L10">
                                Expiry Date:
                                        <div class="highlight-color">01 January 1970</div>
                                                                    </li>-->
                                                            <!--<li class="dropdown login-btn-mob float-R">
                                    <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle border-none" href="#">
                                        <span class=""><img src="http://rakesh.com/origin-assets/boot_origin_asset_new/images/user.png" alt="Dealer" title="Dealer"> 
                                            Welcome </span>Saroj Sahoo Test1 <span class="caret"></span>
                                    </a>
                                </li>-->
                                                                
                                
                                
                                
                                
                                <li class="dropdown login-btn-mob float-R">
                                    <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle border-none" href="#">
                                        <span class=""><img src="http://rakesh.com/origin-assets/boot_origin_asset_new/images/user.png" alt="Dealer" title="Dealer"><i class="fa fa-chevron-down down-arrow font-12 mrg-L5"></i></span> 
                                        
                                           
                                        <span class="float-L text-right pad-R10">
                                            <div style="color:rgba(0, 0, 0, 0.54);">Hi Saroj Sahoo</span></div>
                                            <div> Saroj Sahoo ...   <b>[GCD1069]</b> </div>
                                        </span> 
                                    </a>
                                    <ul role="menu" class="dropdown-menu welcome-dropdown">
                                        <li><a href="http://abha.gaadi.com" target="_blank">My Website</a></li>
                                                                           <li   ><a href="/admin/dealer">My Account</a></li>
                                         <li   ><a href="/user/dealer_change_password.php?back=back">Change Password</a></li>
                                                                                                    <li  ><a  href="/admin/dealeruser" >User Manager</a></li>
                                                       
                                           
                                            <li><a href="/user/log_out.php?exe=0"><i class="fa fa-power-off pad-R5" data-unicode="f011"></i>Logout</a></li>

                                                      </ul>
                                </li>
                                                                        </ul>
            </div><!--/.nav-collapse -->
        </nav>
        <!--/Top Header -->
        <nav role="navigation" class="navbar navbar-default b-radius-zero nav-main" id="newNav" >
            <div class="navbar-header">
                                    <ul class="nav navbar-nav navbar-right pull-left pad-L20 mrg-T0 mrg-B0 text-left" id="login-mobile">
                        <li class="nav-border-left dropdown user-info">
                            <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle border-none font-14" href="#">
                                <img src="http://rakesh.com/origin-assets/boot_origin_asset_new/images/user.png" alt="Dealer" title="Dealer"> 
                                Welcome <span class="caret login-btn-mob">Saroj Sahoo Test1</span>
                            </a>
                            <ul role="menu" class="dropdown-menu welcome-dropdown welcome-zindex">
                                                                    <li><a href="/user/http://abha.gaadi.com"><i class="fa fa-link pad-R5" data-unicode="f0c1"></i> My website</a></li>

                                  

                                    <li><a href="/admin/dealer/"> <i class="fa fa-unlock-alt pad-R5" data-unicode="f13e"></i>My Account</a></li>
                                                                        <li><a href="/dealer_change_password.php"> <i class="fa fa-unlock-alt pad-R5" data-unicode="f13e"></i>Change Password</a></li>

                                    <li><a href="/user/log_out.php?exe=0"> <i class="fa fa-power-off pad-R5" data-unicode="f011"></i>Logout</a></li>
                                                            </ul>
                        </li>
                    </ul>
                                <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed mrg-T15" type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse pad-all-0 mrg-L20" id="navbar" >
                <ul class="nav navbar-nav mrg-all-0" id="new-header-list">
                    <li class="dropdown   " >
                        <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-hover " href="#">
                             Dashboard <i class="fa fa-chevron-down pad-L10 font-14"></i>               
                        </a>
                        <ul role="menu" class="dropdown-menu">
                                                            <li  ><a href="/user/dash_dealer.php" >Dashboard</a></li>
                                <!--<li><a href="/admin/dealeruser/">User Manager</a></li>-->
                                                                                                                                                        
                                    
                                            <!--<li  onclick="_gaq.push(['_trackEvent','69', 'click', 'Change Password'])"><a href="/user/dealer_change_password.php">Change Password</a></li>-->
                                                                                                                                            </ul>
                    </li>
                                                                        <li class="dropdown active" >
                                <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle " href="#">Stock Manager <i class="fa fa-chevron-down pad-L10 font-14"></i>  </a>
                                <ul role="menu" class="dropdown-menu">
                                    <li class="selected" ><a href="/user/manage_inventory_inquiries_new.php?listType=gaadi" >Manage Stock</a></li>
                                    <li  ><a href="/user/add_inventories.php" >Add Stock</a></li>
                                                                            <li ><a href="/user/manage_inventory_certification_new.php?listType=certified" >Manage Certification</a></li>
                                                                                                        </ul>
                            </li>
                                                    
                                                    <li class="dropdown " >
                                <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle " href="#">Accessory Manager <i class="fa fa-chevron-down pad-L10 font-14"></i>  </a>
                                <ul role="menu" class="dropdown-menu">
                                    <li  ><a href="/user/manage_accessories.php" >Manage Accessories</a></li>
                                    <li  ><a href="/user/add_accessory.php" >Add Accessory</a></li>
                                </ul>
                            </li>
                                                    
                            
                                              
                                                                        <li class="dropdown "  >
                                <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">Enquiry Manager <i class="fa fa-chevron-down pad-L10 font-14"></i></a>
                                <ul role="menu" class="dropdown-menu">
                                    <li  ><a href="/user/buyer_leads.php" >Buyer Enquiry</a></li>
                                    <li  ><a href="/user/seller_enquiry.php" >Seller Enquiry</a></li>
                                                        <!--<li  onclick="_gaq.push(['_trackEvent', '69', 'click', 'Service enquiry'])"><a href="/user/dealer_service_manager.php" >Service Enquiry</a></li>-->
                                                                                                    <!--<li ><a href="/user/orpleads.php" >ORP Leads</a></li>
                                                                <li ><a href="/user/reqirement.php" >Post Requirement Leads</a></li>-->
                                    
                                                                                                                    <li  ><a href="/user/kwl_datas.php" >Call Tracker</a></li>
                                                                                
                                                                                                                                <!--<li  onclick="_gaq.push(['_trackEvent','69', 'click', 'Call Tracker'])"><a href="/user/kwl_datas.php" >Call Tracker</a></li>-->
                                                                                                                                                  
                                                                                                                <!--<li ><a href="/user/manage_finance_queries.php" >Finance Query Manager</a></li>
                                            <li ><a href="/user/manage_insurance_queries.php" >Insurance Query Manager</a></li>-->
                                                                                                                <li ><a href="/user/inquiry.php?type=finance" >Finance Query Manager</a></li>
                                                                                                                <li ><a href="/user/inquiry.php?type=insurance" >Insurance Query Manager</a></li>
                                                                                                                <li ><a href="/user/contact_us_lead.php" >Contact Us Enquiry</a></li>
                                                                                                                    <!-- <li ><a href="/user/services.php" >Services Enquiry</a></li> -->                                                                          </ul>
                                </li>
                                                                                                                                                                                <li class="dropdown single-dropdown "   >
                                            <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle " href="#">Website Manager <i class="fa fa-chevron-down pad-L10 font-14"></i></a>
                                            <ul role="menu" class="dropdown-menu">
                                                                                                                                                                                                                        <li ><a href="/user/template_manager.php" >Template Manager</a></li>
                                                                                                                                                                                <li ><a href="/admin/showroom" >Showroom Manager</a></li>
                                                            <li ><a href="/user/tab_new.php" >Tab Manager</a></li>
                                                            <li ><a href="/user/cms_list_new.php" >Page Manager</a></li>
                                                                                                                            <!--<li ><a href="/user/dealer_blog_list_new.php" >Blog Manager</a></li>-->
                                                               
                                                            <li ><a href="/user/testimonial_list_new.php" >Testimonial</a></li>
                                                                                                                 
                                                                                               
                                                                                                                        <!--<li  onclick="_gaq.push(['_trackEvent','69', 'click', 'User Manager'])"><a  href="/user/user_management.php" >User Manager</a></li>-->
                                                                                                                                                                                                                                                   
                                            </ul>
                                        </li>
                                                                                                                                                                                                                <li class="dropdown"  >
                                <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">Tools <i class="fa fa-chevron-down pad-L10 font-14"></i></a>
                                <ul role="menu" class="dropdown-menu">
                                    <li  ><a href="/user/chckcarstolen_new.php?type=swc" >Check Stolen Car</a></li>
                                    <li  ><a href="/user/rto_check_new.php" >Vahan Check</a></li>
                                    <!--<li  ><a href="/user/photo_doc_locker.php" >Document/Image Locker</a></li>-->
                                                                        <li  ><a href="/user/document_locker.php" >Document Locker</a></li>
                                                                        <li  ><a href="/user/used_car_valuation_new.php" >Used Car Valuation</a></li>
                                                                        <li  ><a href="/user/advance/notification.php?type=dHJ1ZQ==" >Notification</a></li>
                                                                    </ul>
                            </li>

                            <button type="button" name="paynow" id="paynow" class="btn btn-primary btn-md mrg-T10 mrg-L10" data-toggle="modal" data-target="#myModal">
                                  PAY NOW
                            </button>
                           
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Payment</h4>
                                  </div>
                                  <div class="modal-body">
                                    <form method="post">
                                    <input type="text" class="form-control" name="amount" onkeypress="return isNumberKey(event)" value="" placeholder="Enter Amount" id="amount">
                                    <div class="err_amount" style="color:red"></div>
                                    <input type="hidden" name="dealer_id" value="69">
                                    <input name="submit_paynow" id="submit_paynow" value="submit" type="submit" class="btn btn-primary mrg-T10">
                                    </form>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                   </div>
                                </div>
                              </div>
                            </div>
                                                                            
                                                                                                                                   
                                                                                                                                                                                   
                           
                            
                                                            <!--<li ><a href="/user/manage_ba.php" >Manage BA</a></li>-->
                                                            
                                           </ul>
                </div>
                <!--/.nav-collapse -->
            </nav>
                                    <form method="post" name="today_inventory" id="today_inventory"  action="" >
                <input type="hidden" name="keyword" id="today" value="">
                <input id="leadby" type="hidden" value="notification" name="leadby">
                <input style="display:none; " type="submit" name="autosubmit" value="Inventry today" />   
            </form>
            <!-- Bootstrap core JavaScript
                ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <!-- Bootstrap core JavaScript
                ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->

            <script src="http://rakesh.com/origin-assets/boot_origin_asset_new/js/notification_new.js?323"></script>
                         <script src="http://rakesh.com/origin-assets/boot_origin_asset_new/js/bootstrap.min.js"></script>
                         <script src="http://rakesh.com/origin-assets/boot_origin_asset_new/js/assets/docs.min.js"></script>
            <script src="http://rakesh.com/origin-assets/boot_origin_asset_new/js/assets/ie10-viewport-bug-workaround.js"></script>
            <script src="http://rakesh.com/origin-assets/boot_origin_asset_new/js/assets/ie-emulation-modes-warning.js"></script>
            <script src="http://rakesh.com/origin-assets/boot_origin_asset_new/js/bootstrap-datepicker.js"></script>
            <script src="http://rakesh.com/origin-assets/boot_origin_asset_new/js/bootstrap-select.js"></script>
            <script type="text/javascript" src="http://rakesh.com/origin-assets/boot_origin_asset_new/js/jquery-asPieProgress.js"></script>
            
            <script>
                $(document).ready(function(){
                  $('.dropdown-submenu a.test').on("click", function(e){
                    $(this).next('ul').toggle();
                    e.stopPropagation();
                    e.preventDefault();
                  });
                });
                </script>

<script>
                function isNumberKey(evt){
                                var charCode = (evt.which) ? evt.which : event.keyCode
                                if (charCode > 31 && (charCode < 48 || charCode > 57))
                                    return false;
                                return true;
                            }
                $( "#submit_paynow" ).click(function() {
                       var amount = $("#amount").val();
                       if(amount==''){
                        $('.err_amount').html("please enter amount");
                        return false;
                       }
                       if(length.amount<=3){
                        $('.err_amount').html("please enter valid amount");
                        return false;
                       }
                       if(length.amount>=8){
                        $('.err_amount').html("please enter valid amount");
                        return false;
                       }
                       return true;
                });
                $(".myModals").click(function(){
                    $("#myModals").attr("style","display:none");
                }); 
                </script>
                <script src="http://rakesh.com/origin-assets/js/pager.js"></script>
<script>var BASE_HREF = 'http://rakesh.com/';
    var event_type = '69';</script>
<!-- Common styles for this template -->
<style>
    .ic-Gaadi-cardekho-zigwheels { width: 130px; height: 18px; background-position: -72px -145px; text-indent: -9999px;}
</style>
<style>
    .classified-icon-div { display:none; position:absolute; height:115px; font-size: 12px; width:194px !important; margin:auto; background:#fff; color:#444;  z-index: 9; border-radius:4px; padding: 11px; font-weight: normal; border: 1px solid #ddd; margin-top: 1px; box-shadow: 3px 6px 10px #ddd;}
    .classified-icon-div ul{padding-left: 0px}
    .classified-icon-div ul li{list-style: none}
    .classified-icon-div:after, .classified-icon-div:before {
        bottom: 100%;
        left:65px;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
    }

    .classified-icon-div:after {
        border-color: rgba(241, 241, 241, 0);
        border-bottom-color: #fff;
        border-width: 10px;
        margin-left: -16px;
    }
    .classified-icon-div:before {
        border-color: rgba(221, 221, 221, 0);
        border-bottom-color: #DDDDDD;
        border-width: 11px;
        margin-left: -17px;
    }

    .table-responsive {
        min-height: 350px !important;
    }
</style>
<link href="http://rakesh.com/origin-assets//inventory_all_assets/css/progressbar.css" rel="stylesheet">
<link href="http://rakesh.com/origin-assets//inventory_all_assets/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://rakesh.com/origin-assets//inventory_all_assets/js/jquery-asPieProgress.js"></script>
<script type="text/javascript" src="http://rakesh.com/origin-assets//js/inventory_responsive.js?code=147473336"></script>
<script src="http://rakesh.com/origin-assets/jquery-ui/jquery.datetimepicker.js"></script>
<link href="http://rakesh.com/origin-assets/jquery-ui/jquery.datetimepicker.css" rel="stylesheet">
<script src="http://rakesh.com/origin-assets/jquery-ui/jquery-ui.js"></script>
<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="js/assets/ie8-responsive-file-warning.js"></script><![endif]-->
<script>
$('#popoverData123').popover();
//$('#popoverOption').popover({ trigger: "hover" });
</script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

</script>
<script>
    var start = 2;



    $(document).ready(function () {

        $(function () {
            $(".showAlltab").modal('hide');
            $("#uploadmanagePhtos").click(function () {
                //alert('hello');return false;
                var myModal = $('.showAlltab');
                //alert(myModal);
                var modalBody = myModal.find('.modal-body');
                modalBody.load('http://rakesh.com/user/ajax/tagPhotoManageInv.php?car_id=' + $(this).attr('name'));
                //alert('sss');
                //myModal.modal('show');

                $('#uploadmanagePhtos').addClass('active');
                $('#TagneweditedPhotos').removeClass('active');
                $('#vieweditedphotos').removeClass('active');
                $('#rejectedPhotos').removeClass('active');
                $('#flagedPhotos').removeClass('active');


            });
        });


        $(function () {
            $(".showAlltab").modal('hide');
            $("#TagneweditedPhotos").click(function () {
                //alert('hello');return false;
                var myModal = $('.showAlltab');
                //alert(myModal);
                var modalBody = myModal.find('.modal-body');
                modalBody.load('http://rakesh.com/user/ajax/tagnewEditedphotos.php?car_id=' + $(this).attr('name'));
                //alert('sss');
                //myModal.modal('show');
                $('#TagneweditedPhotos').addClass('active');
                $('#uploadmanagePhtos').removeClass('active');
                $('#vieweditedphotos').removeClass('active');
                $('#rejectedPhotos').removeClass('active');

                $('#flagedPhotos').removeClass('active');

            });
        });

        $(function () {
            $(".showAlltab").modal('hide');
            $("#vieweditedphotos").click(function () {
                //alert('hello');return false;
                var myModal = $('.showAlltab');
                //alert(myModal);
                var modalBody = myModal.find('.modal-body');
                modalBody.load('http://rakesh.com/user/ajax/viewnewEditedphotos.php?car_id=' + $(this).attr('name'));
                //alert('sss');
                //myModal.modal('show');
                $('#vieweditedphotos').addClass('active');
                $('#TagneweditedPhotos').removeClass('active');
                $('#uploadmanagePhtos').removeClass('active');
                $('#rejectedPhotos').removeClass('active');

                $('#flagedPhotos').removeClass('active');

            });
        });
        
         $(function () {
            $(".showAlltab").modal('hide');
            $("#rejectedPhotos").click(function () {
                var myModal = $('.showAlltab');
                var modalBody = myModal.find('.modal-body');
                modalBody.load('http://rakesh.com/user/ajax/getRejectedPhotos.php?car_id=' + $(this).attr('name'));
                $('#rejectedPhotos').addClass('active');
                $('#uploadmanagePhtos').removeClass('active');
                $('#TagneweditedPhotos').removeClass('active');
                $('#vieweditedphotos').removeClass('active');

                $('#flagedPhotos').removeClass('active');
            });
        });
         $(function () {
            $(".showAlltab").modal('hide');
            $("#flagedPhotos").click(function () {
                var myModal = $('.showAlltab');
                var modalBody = myModal.find('.modal-body');
                modalBody.load('http://rakesh.com/user/ajax/getFlagedPhotos.php?car_id=' + $(this).attr('name'));
                $('#flagedPhotos').addClass('active');
                $('#rejectedPhotos').removeClass('active');
                $('#uploadmanagePhtos').removeClass('active');
                $('#TagneweditedPhotos').removeClass('active');
                $('#vieweditedphotos').removeClass('active');
            });
        });
        
        
        

    });


    function submitPagination(pageno) {
        $("#page").val(pageno);
        // $("#searchform").submit();
        window.top.location.href = "http://rakesh.com/user/buyer_enquiry.php?" + $('#searchform').serialize();
    }
</script>
<script>

    function checkallchk(ths)
    {
        var t = setTimeout(function () {
            if ($("#checkactionbar input:checked").length == 0)
            {
                $('#mydynamic_ul input').prop('checked', false);
            } else
            {
                $('#mydynamic_ul input').prop('checked', true);
            }
        }, 100);
    }
</script>
<div class="container-fluid" id="maincontainer">
    <h1 class="main-heading clearfix tophead ">Stock Manager<div id="filterbtn" class="pull-right"><button class="btn btn-primary" id="searchbtn" name="sechicon" type="button">
                <span class="fa fa-search"></span> Search</button></div></h1>
    <style>
    .min_height_100{ min-height:100px;}
    .min_height_235{ min-height:235px!important;}

    .ui-autocomplete{
        list-style:none;
        margin:0px !important;
        width:205px !important;
        border-bottom: 1px solid #E9E9E9 !important;
        box-shadow: 0px 7px 7px #A3A3A3;
        padding:0px !important;
        position:absolute !important;
        top:135px;
        border-bottom:4px solid #e66437 !important;
        background:#fff;
        height:150px;
        overflow-y:scroll;

    }
    .ui-autocomplete li{line-height: 32px; border-bottom: 1px solid #ddd; padding-left:15px; padding-right:15px;}
    .ui-autocomplete li:hover{background:#f6f6f6;}



    .heightcontrol{
        min-height:500px;
    }

    .height-100{
        height:100px;
    }
    .height-160{
        height:159px!important;
    }
</style>
<div id="serch-wrapper" class="min_height_100">
    <script type="text/javascript">
        $(document).ready(function () {

            //setSearchFormValue();     

            $('.gaadipopup').click(function () {
                $('.popup-black-window-send-email').show();
            });
            $("input[name^='cs']").click(function () {
                if ($(this).is(':checked')) {
                    $(this).parent().parent().parent().addClass('change-cardetailboxcolor');
                } else {
                    $(this).parent().parent().parent().removeClass('change-cardetailboxcolor');
                }

            });
            $("#checkAll").click(function () {
                if ($("#checkAll").is(':checked')) {
                    $(".car-detail-box").addClass('change-cardetailboxcolor');
                    $("input[name^='cs']").attr("checked", true);
                } else {
                    $(".car-detail-box").removeClass('change-cardetailboxcolor');
                    $("input[name^='cs']").attr("checked", false);
                }
            });
            $('.search-icon').click(function () {
                $("#cardid_searchform").submit();
            });
            /*
             $('#select_owner_list li').click(function(){
             $("#owner").val($(this).html());
             $("#select_owner").text($(this).html());
             });
             */
            $('#select_km_max_list li').click(function () {
                $("#km_max").val($(this).html());
                $("#select_km_max").text($(this).html());
            });

            $('#select_km_min_list li').click(function () {
                $("#km_min").val($(this).html());
                $("#select_km_min").text($(this).html());
            });

            $('#select_myear_from_list li').click(function () {
                myyearIdArr = this.id;
                year = myyearIdArr.split("_");
                selMyyearFrom = year[1];
                curYear = '2018';
                var MyYearToDD = '';
                for (i = curYear; i >= selMyyearFrom; i--) {
                    MyYearToDD += '<li id="myyearto_' + i + '">' + i + '</li>';
                }
                $("#select_myear_to").html('Year-To');
                $("#select_myear_to_list").html(MyYearToDD);
                $("#myear_from").val($(this).html());
                $("#select_myear_from").text($(this).html());
            });

            //$('#select_myear_to_list li').click(function(){
            /*$("#select_myear_to_list li").live("click",function(){
             $("#myear_to").val($(this).html());
             $("#select_myear_to").text($(this).html());
             });*/

            $('#select_price_min_list li').click(function () {
                var minpriceArr = this.id;
                minPrice = minpriceArr.split("_");
                selminPrice = minPrice[1];
                $("#price_min").val(selminPrice);
                $("#select_price_min").text($(this).html());
            });

            $('#select_price_max_list li').click(function () {
                var maxpriceArr = this.id;
                maxPrice = maxpriceArr.split("_");
                selmaxPrice = maxPrice[1];
                $("#price_max").val(selmaxPrice);
                $("#select_price_max").text($(this).html());
            });

            $('#select_age_inventory_list li').click(function () {
                $("#age_inventory").val($(this).html());
                $("#select_age_inventory").text($(this).html());
            });

            $("#select_make_list li").click(function () {
                var getMakedata = this.id;

                var getMakeImg = $(this).find('img').attr("src");
                if (getMakeImg == 'http://rakesh.com/origin-assets/images/checkbox.png') {
                    $(this).find('img').attr("src", 'http://rakesh.com/origin-assets/images/checked-icon.png');
                    if ($("#make").val() == '') {
                        newValString = getMakedata;
                    } else {
                        newValString = $("#make").val() + ',' + getMakedata;
                    }
                    $("#make").val(newValString);
                } else {
                    $(this).find('img').attr("src", 'http://rakesh.com/origin-assets/images/checkbox.png');
                    varString = $("#make").val();
                    newValString = removeValue(varString, getMakedata);
                    $("#make").val(newValString);
                }
                if ($("#make").val() != '') {
                    var makeCount = $('#make').val().split(',');
                    makeCount = makeCount.length;
                    $("#span_select_make").text(makeCount + ' Selected');
                } else {
                    $("#span_select_make").text('Select Model');
                }
            });

            $("#advanced_search_link").click(function () {
                if ($("#advanced_search_option").val() == 'yes') {
                    $("#advanced_search_option").val('no')
                } else {
                    $("#advanced_search_option").val('yes')
                }
            });

            jQuery('.select-all-dropdown-text').click(function (event) {

                event.preventDefault();
                var elm = jQuery(this);
                var text = elm.text();
                $('.car-detail-box input:checkbox').attr('checked', false);
                $(".car-detail-box").removeClass('change-cardetailboxcolor');
                $('#checkAll').attr('checked', false);
                $('#dynamic_image_label').remove();
                $("input[name^='cs']").attr("checked", false);
                if (text == 'All') {

                    $('.car-detail-box input:checkbox').attr('checked', 'checked');
                    $('#checkAll').attr('checked', 'checked');
                    $(".car-detail-box").addClass('change-cardetailboxcolor');
                }
                if (text == 'Starred') {
                    var StarCount = 0;
                    $(".car-detail-box input:checkbox").each(function () {
                        var checkValue = parseInt($.trim(this.value));
                        if (checkValue != 'undefined' && checkValue > 0)
                        {
                            var hiddenStar = $('.star_checkbox_' + checkValue).attr('value');
                            if (hiddenStar > '0')
                            { //alert(StarCount);
                                if (StarCount == 0) {
                                    var img = $('<img id="dynamic_image_label" class="image_label" OnClick="calculateImageLabel()">');
                                    img.attr('src', 'http://rakesh.com/origin-assets/images/checkmark-partial.png');
                                    $(".short-by-filter").children().append(img);
                                }
                                //$(".short-by-filter").children().append(img);
                                $('.star_checkbox_' + checkValue).parent().parent().parent().addClass('change-cardetailboxcolor');
                                ;
                                $('input[type=checkbox][value=' + checkValue + ']').attr('checked', 'checked');
                                hiddenStar = '';
                                StarCount++;
                            }
                        }
                    });
                }
                if (text == 'Unstarred') {
                    var unStarCount = 0;
                    $(".car-detail-box input:checkbox").each(function () {
                        var checkValue = parseInt($.trim(this.value));
                        if (checkValue != 'undefined' && checkValue > 0)
                        {
                            var hiddenStar = $('.star_checkbox_' + checkValue).attr('value');
                            if (hiddenStar == '0')
                            {
                                if (unStarCount == 0) {
                                    var img = $('<img id="dynamic_image_label" class="image_label" OnClick="calculateImageLabel()">');
                                    img.attr('src', 'http://rakesh.com/origin-assets/images/checkmark-partial.png');
                                    $(".short-by-filter").children().append(img);
                                }
                                $('.star_checkbox_' + checkValue).parent().parent().parent().addClass('change-cardetailboxcolor');
                                ;
                                $('input[type=checkbox][value=' + checkValue + ']').attr('checked', 'checked');
                                hiddenStar = '';
                                unStarCount++;
                            }
                        }
                    });
                }
                if (text == 'cars with photos') {
                    var carWithPhotoCount = 0;
                    $(".car-detail-box input:checkbox").each(function () {
                        var checkValue = parseInt($.trim(this.value));
                        if (checkValue != 'undefined' && checkValue > 0)
                        {
                            var hiddenStar = $('.car_photo_' + checkValue).attr('value');
                            if (hiddenStar > '0')
                            {
                                if (carWithPhotoCount == 0) {
                                    var img = $('<img id="dynamic_image_label" class="image_label" OnClick="calculateImageLabel()">');
                                    img.attr('src', 'http://rakesh.com/origin-assets/images/checkmark-partial.png');
                                    $(".short-by-filter").children().append(img);
                                }
                                $('.car_photo_' + checkValue).parent().parent().parent().addClass('change-cardetailboxcolor');
                                ;
                                $('input[type=checkbox][value=' + checkValue + ']').attr('checked', 'checked');
                                hiddenStar = '';
                                carWithPhotoCount++;
                            }
                        }
                    });
                }
                if (text == 'cars without photos') {
                    var carWithoutPhotoCount = 0;
                    $(".car-detail-box input:checkbox").each(function () {
                        var checkValue = parseInt($.trim(this.value));
                        if (checkValue != 'undefined' && checkValue > 0)
                        {
                            var hiddenStar = $('.car_photo_' + checkValue).attr('value');
                            if (hiddenStar == '0')
                            {
                                if (carWithoutPhotoCount == 0) {
                                    var img = $('<img id="dynamic_image_label" class="image_label" OnClick="calculateImageLabel()">');
                                    img.attr('src', 'http://rakesh.com/origin-assets/images/checkmark-partial.png');
                                    $(".short-by-filter").children().append(img);
                                }
                                $('.car_photo_' + checkValue).parent().parent().parent().addClass('change-cardetailboxcolor');
                                ;
                                $('input[type=checkbox][value=' + checkValue + ']').attr('checked', 'checked');
                                hiddenStar = '';
                                carWithoutPhotoCount++;
                            }
                        }
                    });
                }
            });
            jQuery('.tools-click').click(function (event) {
                var totalchecked = $(".check-caraction input:checked").length;
                var totalcheckedvalue = $(".check-caraction input:checked").val();
                event.preventDefault();
                var elm = jQuery(this);
                var text = elm.text();//alert(text);
                //alert(elm.attr('rel'));
                values = '';
                if (totalchecked <= 0)
                {
                    alert('Please slect atleast one inventory');
                    //jQuery('#blukaction').attr('value',0);
                    return false;
                } else {
                    $(".check-caraction input:checked").each(function () {
                        values += $(this).val() + ',';
                    });

                }
                //alert(values);return false;
                if (text != '0')
                {

                    if (text == 'Make Featured')
                    {
                        var test = '<div data-target="#model-makePremium" id="dynamic_makepremium" data-toggle="modal" role="group"  class="btn-group btn-group-sm "></div>';
                        $('#autopopulate_content').html(test);
                        $('#dynamic_makepremium').trigger('click');
                        var myModal = $('#model-makePremium');
                        var modalBody = myModal.find('.modal-body');
                        modalBody.load('http://rakesh.com/user/ajax/makepremium_new.php?t=m&type=Add&car_id=' + values);

                    }

                    if (text == 'Mark as sold')
                    {

                        var test = '<div data-target="#model-mark_as_Sold" id="dynamic_markassold" data-toggle="modal" role="group"  class="btn-group btn-group-sm "></div>';
                        $('#autopopulate_content').html(test);
                        $('#dynamic_markassold').trigger('click');
                        var myModal = $('#model-mark_as_Sold');
                        var modalBody = myModal.find('.modal-body');
                        modalBody.load('http://rakesh.com/user/ajax/addremove_used_car_sold_new.php?car_id=' + values + '&type=sold&multiselect=yes');

                    }
                    //$.colorbox({href:url,iframe:true,width:"100%", height:"100%", scrolling:true,onClosed:function(){ jQuery('#blukaction').attr('value',0);}}); 
                }
            });


            jQuery('#add_to_list').click(function (event) {
                var totalchecked = $(".check-caraction input:checked").length;
                var totalcheckedvalue = $(".check-caraction input:checked").val();
                event.preventDefault();
                values = '';
                if (totalchecked <= 0)
                {
                    alert('Please slect atleast one inventory');
                    return false;
                } else {
                    $(".check-caraction input:checked").each(function () {
                        values += $(this).val() + ',';
                    });

                }

                var test = '<div data-target="#model-removestock" id="dynamic_remove" data-toggle="modal" role="group"  class="btn-group btn-group-sm "></div>';
                //alert(test);
                $('#autopopulate_content').html(test);
                $('#dynamic_remove').trigger('click');
                var myModal = $('#model-removestock');
                var modalBody = myModal.find('.modal-body');

                modalBody.load('http://rakesh.com/user/ajax/addremove_used_car_new.php?car_id=' + values + '&type=add&multiselect=yes');



            });


            jQuery('#remove_to_list').click(function (event) {
                var totalchecked = $(".check-caraction input:checked").length;
                var totalcheckedvalue = $(".check-caraction input:checked").val();
                event.preventDefault();
                values = '';
                if (totalchecked <= 0)
                {
                    alert('Please slect atleast one inventory');
                    return false;
                } else {
                    $(".check-caraction input:checked").each(function () {
                        values += $(this).val() + ',';
                    });

                }

                var test = '<div data-target="#model-removestock" id="dynamic_remove" data-toggle="modal" role="group"  class="btn-group btn-group-sm "></div>';
                //alert(test);
                $('#autopopulate_content').html(test);
                $('#dynamic_remove').trigger('click');
                var myModal = $('#model-removestock');
                var modalBody = myModal.find('.modal-body');
                //alert($('span',this).eq(1).text());
                if ($('span', this).eq(1).text() == "Add to Stock")
                {
                    modalBody.load('http://rakesh.com/user/ajax/addremove_used_car_new.php?car_id=' + values + '&type=add&multiselect=yes');
                    //alert('ok');

                } else {
                    //alert('not ok');
                    modalBody.load('http://rakesh.com/user/ajax/addremove_used_car_new.php?car_id=' + values + '&type=remove&multiselect=yes');
                }


            });



        });
        function removeValue(list, value) {
            list = list.split(',');
            list.splice(list.indexOf(value), 1);
            return list.join(',');
        }

        function calculateImageLabel() {
            $('#dynamic_image_label').remove();
            $("input[name^='cs']").attr("checked", false);
        }
        function setSearchFormValue() {
            if ($("#advanced_search_option").val() == 'yes') {
                $('.advanced-filter-open').toggle();
            }
            if ($('#make').val() != '') {
                var makeCount = $('#make').val().split(',');
                makeCount = makeCount.length;
                $("#span_select_make").text(makeCount + ' Selected');
            }
            if ($('#body_style').val() != '') {
                var bodyStyleCount = $('#body_style').val().split(',');
                bodyStyleCount = bodyStyleCount.length;
                $("#select_bodytype").text(bodyStyleCount + ' Selected');
            }
            if ($('#fuel_type').val() != '') {
                var fuelTypeCount = $('#fuel_type').val().split(',');
                fuelTypeCount = fuelTypeCount.length;
                $("#span_fuel_type").text(fuelTypeCount + ' Selected');
            }
            if ($('#owner').val() != '') {
                var ownerCount = $('#owner').val().split(',');
                ownerCount = ownerCount.length;
                $("#select_owner").text(ownerCount + ' Selected');
            }

            if ($('#transmission').val() != '') {
                var transmissionCount = $('#transmission').val().split(',');
                transmissionCount = transmissionCount.length;
                //$("#span_transmission_type").text(transmissionCount+' Selected');             
            }
            if ($('#age_inventory').val() != '') {
                $("#select_age_inventory").text($('#age_inventory').val());
            }
            if ($('#km_min').val() != '') {
                $("#select_km_min").text($('#km_min').val());
            }
            if ($('#km_max').val() != '') {
                $("#select_km_max").text($('#km_max').val());
            }
            if ($('#myear_from').val() != '') {
                $("#select_myear_from").text($('#myear_from').val());
            }
            if ($('#myear_to').val() != '') {
                $("#select_myear_to").text($('#myear_to').val());
            }
            if ($('#price_min').val() != '') {
                var getMinPriceHtmlVal = "#minprice_" + $('#price_min').val()
                $("#select_price_min").text($(getMinPriceHtmlVal).text());
            }
            if ($('#price_max').val() != '') {
                var getMaxPriceHtmlVal = "#maxprice_" + $('#price_max').val()
                $("#select_price_max").text($(getMaxPriceHtmlVal).text());
            }

            if ($('#sortByField').val() != '' && $('#sortByValue').val() != '') {
                if ($('#sortByField').val() == 'pricefrom' && $('#sortByValue').val() == 'DESC') {
                    $("#sortby_order_list").text('Price:Highest');
                }
                if ($('#sortByField').val() == 'pricefrom' && $('#sortByValue').val() == 'ASC') {
                    $("#sortby_order_list").text('Price: Lowest');
                }
                if ($('#sortByField').val() == 'myear' && $('#sortByValue').val() == 'DESC') {
                    $("#sortby_order_list").text('Year: Newest');
                }
                if ($('#sortByField').val() == 'myear' && $('#sortByValue').val() == 'ASC') {
                    $("#sortby_order_list").text('Year: Oldest');
                }
                if ($('#sortByField').val() == 'make' && $('#sortByValue').val() == 'DESC') {
                    $("#sortby_order_list").text('Vehicles: A to Z');
                }
                if ($('#sortByField').val() == 'make' && $('#sortByValue').val() == 'ASC') {
                    $("#sortby_order_list").text('Vehicles: Z to A');
                }
                if ($('#sortByField').val() == 'km' && $('#sortByValue').val() == 'DESC') {
                    $("#sortby_order_list").text('Km:Highest');
                }
                if ($('#sortByField').val() == 'km' && $('#sortByValue').val() == 'ASC') {
                    $("#sortby_order_list").text('KM:Lowest');
                }
                if ($('#sortByField').val() == 'profile' && $('#sortByValue').val() == 'ASC') {
                    $("#sortby_order_list").text('% Complete:Lowest');
                }
                if ($('#sortByField').val() == 'profile' && $('#sortByValue').val() == 'DESC') {
                    $("#sortby_order_list").text('% Complete:Highest');
                }
            }
        }
        function downloadExcel() {
            $("#download_excel").val('yes');
            $('#searchform').attr('action', 'inventory_ajax.php');
            $("#searchform").submit();
            $("#download_excel").val('');
            $('#searchform').attr('action', '');

        }
        function sortCarListing(field, value) {
            $("#sortByField").val(field);
            $("#sortByValue").val(value);
            $("#searchform").submit();
        }


        function sortCarListing_new() {
            var sortval = $("#sortby").val();
            if (sortval)
            {
                var arr = sortval.split('-');
                //alert(arr[1]);
                $("#sortByField").val(arr[0]);
                $("#sortByValue").val(arr[1]);
                $("#searchform").submit();
            }
        }


        function resetFormValue(fieldValue) {
            if (fieldValue == 'make') {
                $("#make").val('');
            }
            if (fieldValue == 'owner') {
                $("#owner").val('');
            }
            if (fieldValue == 'body_style') {
                $("#body_style").val('');
            }
            if (fieldValue == 'fuel_type') {
                $("#fuel_type").val('');
            }
            if (fieldValue == 'transmission') {
                $("#transmission").val('');
            }
            $("#searchform").submit();
        }

        function submitPagination(pageno) {
            $("#page").val(pageno);
            $("#searchform").submit();
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

        function saveDealerPrice(id) {
            textBoxValue = parseInt($("#edit_dealer_price_" + id).val());
            retailPrice = parseInt($("#edit_retail_price_" + id).val());
            if (textBoxValue == '') {
                alert('Please Enter a Value');
            } else if (isNaN(textBoxValue)) {
                alert('Please Enter a Valid Value');
            } else if (textBoxValue <= 1000) {
                alert('Dealer Price Should Be greater Than 1000');
            } else if (retailPrice < textBoxValue) {
                alert('Dealer Price should be equal to or less than retail price');
            } else {
                $('.countloaderdealerprice').show();
                $.ajax({
                    type: "POST",
                    url: "http://rakesh.com/user/ajax/addEditInventoryList.php?car_id=" + id,
                    data: {option: 'addEditPrice', priceType: 'dealer', 'priceVal': textBoxValue},
                    dataType: "html",
                    success: function (responseData) {
                        var myObject = eval('(' + responseData + ')');
                        if (myObject.status == 'true') {
                            //alert(myObject.msg);
                            alert('Dealer price updated successfully and Inventory added to dealer platform.');
                            $("#edit_dealer_price_" + id).val(textBoxValue);
                            $(".editdealerPriceDiv_" + id).hide();
                            $("#show_dealer_price_" + id).html(addCommasdealer(textBoxValue));

                            pagee = pagee - 1;
                            getResults();
                        } else {
                            alert(myObject.msg);
                        }
                        $('.countloaderdealerprice').hide();
                    }
                });
            }
        }

        function saveRetailPrice(id) {
            var textBoxValue = parseInt($("#edit_retail_price_" + id).val());
            var dealerPrice = parseInt($("#edit_dealer_price_" + id).val());
            var session_token = '99e0d5b68e1382090eeafa5f21c07a1e';
            //alert(dealerPrice);
            if (textBoxValue == '') {
                //alert('Please Enter a Value');
                snakbarAlert('Please Enter a Value');
            } else if (isNaN(textBoxValue)) {
                //alert('Please Enter a Valid Value');
                snakbarAlert('Please Enter a Valid Value');
            } else if (textBoxValue <= 20000) {
                //alert('Retail price should be grater than 20,000');
                snakbarAlert('Retail price should be grater than 20,000');
            }
            //else if(dealerPrice>=textBoxValue){
            //  alert('Retail Price Should Be Greater Than Dealer Price');
            //}
            else {
                $('.countloaderprice').show();
                $.ajax({
                    type: "POST",
                    url: "http://rakesh.com/user/ajax/addEditInventoryList.php?car_id=" + id,
                    data: {option: 'addEditPrice', priceType: 'retail', 'priceVal': textBoxValue,'token':session_token},
                    dataType: "html",
                    success: function (responseData) {
                        var myObject = eval('(' + responseData + ')');
                        if (myObject.status == 'true') {
                            //alert(myObject.msg);
                             snakbarAlert(myObject.msg);
                            var dealerPrice123 = parseInt($("#edit_dealer_price_" + id).val());
                            //alert(dealerPrice123);
                            $("#edit_retail_price_" + id).val(textBoxValue);
                            $(".editretalPriceDiv_" + id).hide();
                            $("#show_retail_price_" + id).html(addCommasdealer(textBoxValue));
                            if (dealerPrice123 > textBoxValue)
                            {
                                $("#show_dealer_price_" + id).html(addCommasdealer(textBoxValue));
                                $("#edit_dealer_price_" + id).val(textBoxValue);
                            }
                        } else {
                            //alert(myObject.msg);
                            snakbarAlert(myObject.msg);
                        }
                        $('.countloaderprice').hide();
                    }
                });
            }
        }

        function addCommasdealer(nStr)
        {

            //nStr=nStr.replace(/,/g,''); 
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

                //alert(x3);
            }
            len = x1.length;
            if (len >= 3 && x3 != "") {
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');

                }
            }
            return '<i class="fa fa-inr"></i> ' + x1 + x3 + x2;
        }
    </script>
    <form method="get" name="searchform" id="searchform"   onsubmit="return false;">
        <input type="hidden" name="search_form" value=''>
        <input type="hidden" name="listType" id="listType" value="gaadi">
        <input type="hidden" name="download_excel" id="download_excel" value="">

        <div class=" clearfix " id="search-wraper">
            <div class="well well-filter" style="position:relative;">
                <img class="resultloader" src="http://rakesh.com/origin-assets/boot_origin_asset_new/images/loader.gif" style="position: absolute; left:630px; top: 180px; width: 50px;display:none; ">
                <div class="row ">


                    <div class="col-md-2 col-sm-6 pad-LR tabpading">

                        <label for="exampleInputPassword1" class="form-label">Search :</label>
                        <div class="row row-text-box">
                            <div class="col-xs-12 mrg-all-0 sm-text-box"> 
                                <input type="text" id="car_id_reg_no" name="car_id_reg_no" style="font-size:10.5px; text-transform:uppercase;"  placeholder="Search by Reg No." class="form-control pad-L10" onkeydown="Javascript: if (event.keyCode == 13) {
                                                                    $('#inventory_search').click(); }" >                       	

                            </div>

                        </div>

                    </div>



                    <div class="col-md-2 col-sm-6 pad-LR tabpading">

                        <label for="exampleInputPassword1" class="form-label">Select a Car :</label>
                        <div class="row row-text-box">
                            <div class="col-xs-6 mrg-all-0 sm-text-box">                        	
                                <select  class="form-control" name="make" id="make" >
                                    <option selected="selected" value="">Select Make</option>
                                                                            <option value="Ashok Leyland" >
                                        Ashok Leyland                                        </option>
                                                                      <option value="Aston Martin" >
                                        Aston Martin                                        </option>
                                                                      <option value="Audi" >
                                        Audi                                        </option>
                                                                      <option value="Austin" >
                                        Austin                                        </option>
                                                                      <option value="Bentley" >
                                        Bentley                                        </option>
                                                                      <option value="BMW" >
                                        BMW                                        </option>
                                                                      <option value="Bugatti" >
                                        Bugatti                                        </option>
                                                                      <option value="Cadillac" >
                                        Cadillac                                        </option>
                                                                      <option value="Caterham" >
                                        Caterham                                        </option>
                                                                      <option value="Chevrolet" >
                                        Chevrolet                                        </option>
                                                                      <option value="Chrysler" >
                                        Chrysler                                        </option>
                                                                      <option value="Conquest" >
                                        Conquest                                        </option>
                                                                      <option value="Daewoo" >
                                        Daewoo                                        </option>
                                                                      <option value="Datsun" >
                                        Datsun                                        </option>
                                                                      <option value="DC" >
                                        DC                                        </option>
                                                                      <option value="Dodge" >
                                        Dodge                                        </option>
                                                                      <option value="Ferrari" >
                                        Ferrari                                        </option>
                                                                      <option value="Fiat" >
                                        Fiat                                        </option>
                                                                      <option value="Force" >
                                        Force                                        </option>
                                                                      <option value="Ford" >
                                        Ford                                        </option>
                                                                      <option value="Hindustan Motors" >
                                        Hindustan Motors                                        </option>
                                                                      <option value="Honda" >
                                        Honda                                        </option>
                                                                      <option value="Hummer" >
                                        Hummer                                        </option>
                                                                      <option value="Hyundai" >
                                        Hyundai                                        </option>
                                                                      <option value="ICML" >
                                        ICML                                        </option>
                                                                      <option value="Infiniti" >
                                        Infiniti                                        </option>
                                                                      <option value="Isuzu" >
                                        Isuzu                                        </option>
                                                                      <option value="Jaguar" >
                                        Jaguar                                        </option>
                                                                      <option value="Lamborghini" >
                                        Lamborghini                                        </option>
                                                                      <option value="Land Rover" >
                                        Land Rover                                        </option>
                                                                      <option value="Lexus" >
                                        Lexus                                        </option>
                                                                      <option value="Mahindra" >
                                        Mahindra                                        </option>
                                                                      <option value="Mahindra Renault" >
                                        Mahindra Renault                                        </option>
                                                                      <option value="Maruti" >
                                        Maruti                                        </option>
                                                                      <option value="Maybach" >
                                        Maybach                                        </option>
                                                                      <option value="Mercedes-Benz" >
                                        Mercedes-Benz                                        </option>
                                                                      <option value="Mini" >
                                        Mini                                        </option>
                                                                      <option value="Mitsubishi" >
                                        Mitsubishi                                        </option>
                                                                      <option value="Nissan" >
                                        Nissan                                        </option>
                                                                      <option value="Opel" >
                                        Opel                                        </option>
                                                                      <option value="Polaris" >
                                        Polaris                                        </option>
                                                                      <option value="Porsche" >
                                        Porsche                                        </option>
                                                                      <option value="Renault" >
                                        Renault                                        </option>
                                                                      <option value="Reva" >
                                        Reva                                        </option>
                                                                      <option value="Rolls-Royce" >
                                        Rolls-Royce                                        </option>
                                                                      <option value="San Motors" >
                                        San Motors                                        </option>
                                                                      <option value="Skoda" >
                                        Skoda                                        </option>
                                                                      <option value="Tata" >
                                        Tata                                        </option>
                                                                      <option value="Toyota" >
                                        Toyota                                        </option>
                                                                      <option value="Volkswagen" >
                                        Volkswagen                                        </option>
                                                                      <option value="Volvo" >
                                        Volvo                                        </option>
                                                              </select>
                            </div>
                            <div class="col-xs-6 pad-all-0 mrg-B0 form-group">
                                <div class="posrelative text-left">
                                    <select  class="form-control" name="model" id="model" disabled="disabled" >
                                        <option selected="selected" value="">Model</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-2  col-sm-6 pad-LR tabpading">
                        <label for="exampleInputPassword1" class="form-label">Price Range :</label>
                        <div class="row row-text-box">
                            <div class="col-xs-6 mrg-all-0 sm-text-box">                        	
                                <select class="form-control" id='select_price_min_list' name='select_price_min_list'>
                                    <option value=''>Min</option>
                                                                            <option value="50000">50,000</option>
                                        <option value="100000">1 Lakh</option>
                                        <option value="200000">2 Lakh</option>
                                        <option value="300000">3 Lakh</option>
                                        <option value="400000">4 Lakh</option>
                                        <option value="500000">5 Lakh</option>
                                        <option value="600000">6 Lakh</option>
                                        <option value="700000">7 Lakh</option>
                                        <option value="800000">8 Lakh</option>
                                        <option value="900000">9 Lakh</option>
                                        <option value="1000000">10 Lakh</option>
                                        <option value="1500000">15 Lakh</option>
                                        <option value="2000000">20 Lakh</option>
                                        <option value="2500000">25 Lakh</option>
                                        <option value="3000000">30 Lakh</option>
                                </select>
                            </div>
                            <div class="col-xs-6 mrg-all-0 sm-text-box">
                                <select class="form-control" id="select_price_max_list" name="select_price_max_list">
                                    <option value=''>Max</option>
                                                                            <option value="50000">50,000</option>
                                        <option value="100000">1 Lakh</option>
                                        <option value="200000">2 Lakh</option>
                                        <option value="300000">3 Lakh</option>
                                        <option value="400000">4 Lakh</option>
                                        <option value="500000">5 Lakh</option>
                                        <option value="600000">6 Lakh</option>
                                        <option value="700000">7 Lakh</option>
                                        <option value="800000">8 Lakh</option>
                                        <option value="900000">9 Lakh</option>
                                        <option value="1000000">10 Lakh</option>
                                        <option value="1500000">15 Lakh</option>
                                        <option value="2000000">20 Lakh</option>
                                        <option value="2500000">25 Lakh</option>
                                        <option value="3000000">30 Lakh</option>
                                        <option value="4000000">40 Lakh</option>
                                        <option value="5000000">50 Lakh</option>
                                        <option value="6000000">60 Lakh</option>
                                        <option value="7000000">70 Lakh</option>
                                        <option value="8000000">80 Lakh</option>
                                        <option value="9000000">90 Lakh</option>
                                        <option value="10000000">1 Crore</option>
                                        <option value="">No Max</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 pad-LR tabpading">
                        <label for="exampleInputPassword1" class="form-label">Year Range :</label>
                        <div class="row row-text-box">
                            <div class="col-xs-6 mrg-all-0 sm-text-box">                        	
                                <select class="form-control" id='select_myear_from_list' name="select_myear_from_list">
                                    <option value=''>From</option>
                                        <option value="2018">2018</option>
                                                                            <option value="2017">2017</option>
                                                                            <option value="2016">2016</option>
                                                                            <option value="2015">2015</option>
                                                                            <option value="2014">2014</option>
                                                                            <option value="2013">2013</option>
                                                                            <option value="2012">2012</option>
                                                                            <option value="2011">2011</option>
                                                                            <option value="2010">2010</option>
                                                                            <option value="2009">2009</option>
                                                                            <option value="2008">2008</option>
                                                                            <option value="2007">2007</option>
                                                                            <option value="2006">2006</option>
                                                                            <option value="2005">2005</option>
                                                                            <option value="2004">2004</option>
                                                                            <option value="2003">2003</option>
                                                                            <option value="2002">2002</option>
                                                                            <option value="2001">2001</option>
                                                                            <option value="2000">2000</option>
                                                                            <option value="1999">1999</option>
                                                                            <option value="1998">1998</option>
                                                                            <option value="1997">1997</option>
                                                                            <option value="1996">1996</option>
                                                                            <option value="1995">1995</option>
                                                                            <option value="1994">1994</option>
                                                                            <option value="1993">1993</option>
                                                                            <option value="1992">1992</option>
                                                                            <option value="1991">1991</option>
                                                                            <option value="1990">1990</option>
                                                                            <option value="1989">1989</option>
                                                                            <option value="1988">1988</option>
                                                                            <option value="1987">1987</option>
                                                                            <option value="1986">1986</option>
                                                                            <option value="1985">1985</option>
                                                                            <option value="1984">1984</option>
                                                                            <option value="1983">1983</option>
                                                                            <option value="1982">1982</option>
                                                                            <option value="1981">1981</option>
                                                                            <option value="1980">1980</option>
                                                                            <option value="1979">1979</option>
                                                                            <option value="1978">1978</option>
                                                                            <option value="1977">1977</option>
                                                                            <option value="1976">1976</option>
                                                                            <option value="1975">1975</option>
                                                                            <option value="1974">1974</option>
                                                                            <option value="1973">1973</option>
                                                                            <option value="1972">1972</option>
                                                                            <option value="1971">1971</option>
                                                                            <option value="1970">1970</option>
                                                                    </select>
                            </div>
                            <div class="col-xs-6 mrg-all-0 sm-text-box">
                                <select class="form-control" id='select_myear_to_list' name='select_myear_to_list'>
                                    <option value=''>To</option>
                                        <option value="2018">2018</option>
                                        <option value="2017">2017</option>
                                        <option value="2016">2016</option>
                                        <option value="2015">2015</option>
                                        <option value="2014">2014</option>
                                        <option value="2013">2013</option>
                                        <option value="2012">2012</option>
                                        <option value="2011">2011</option>
                                        <option value="2010">2010</option>
                                        <option value="2009">2009</option>
                                        <option value="2008">2008</option>
                                        <option value="2007">2007</option>
                                        <option value="2006">2006</option>
                                        <option value="2005">2005</option>
                                        <option value="2004">2004</option>
                                        <option value="2003">2003</option>
                                        <option value="2002">2002</option>
                                        <option value="2001">2001</option>
                                        <option value="2000">2000</option>
                                        <option value="1999">1999</option>
                                        <option value="1998">1998</option>
                                        <option value="1997">1997</option>
                                        <option value="1996">1996</option>
                                        <option value="1995">1995</option>
                                        <option value="1994">1994</option>
                                        <option value="1993">1993</option>
                                        <option value="1992">1992</option>
                                        <option value="1991">1991</option>
                                        <option value="1990">1990</option>
                                        <option value="1989">1989</option>
                                        <option value="1988">1988</option>
                                        <option value="1987">1987</option>
                                        <option value="1986">1986</option>
                                        <option value="1985">1985</option>
                                        <option value="1984">1984</option>
                                        <option value="1983">1983</option>
                                        <option value="1982">1982</option>
                                        <option value="1981">1981</option>
                                        <option value="1980">1980</option>
                                        <option value="1979">1979</option>
                                        <option value="1978">1978</option>
                                        <option value="1977">1977</option>
                                        <option value="1976">1976</option>
                                        <option value="1975">1975</option>
                                        <option value="1974">1974</option>
                                        <option value="1973">1973</option>
                                        <option value="1972">1972</option>
                                        <option value="1971">1971</option>
                                        <option value="1970">1970</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 pad-LR tabpading">
                        <label for="exampleInputPassword1" class="form-label">KM. Range :</label>
                        <div class="row row-text-box">
                            <div class="col-xs-6 mrg-all-0 sm-text-box">                        
                                <select class="form-control" id="select_km_max_list" name='select_km_min_list'>
                                    <option value=''>From</option>
                                        <option value="10000">10,000</option>
                                                                                <option value="20000">20,000</option>
                                                                                <option value="30000">30,000</option>
                                                                                <option value="40000">40,000</option>
                                                                                <option value="50000">50,000</option>
                                                                                <option value="60000">60,000</option>
                                                                                <option value="70000">70,000</option>
                                                                                <option value="80000">80,000</option>
                                                                                <option value="90000">90,000</option>
                                                                                <option value="100000">1,00,000</option>
                                          
                                </select>
                            </div>
                            <div class="col-xs-6 mrg-all-0 sm-text-box">
                                <select class="form-control" id='select_km_min_list' name='select_km_max_list'>
                                    <option value=''>To</option>
                                        <option value="10000">10,000</option>
                                            <option value="20000">20,000</option>
                                            <option value="30000">30,000</option>
                                            <option value="40000">40,000</option>
                                            <option value="50000">50,000</option>
                                            <option value="60000">60,000</option>
                                            <option value="70000">70,000</option>
                                            <option value="80000">80,000</option>
                                            <option value="90000">90,000</option>
                                            <option value="100000">1,00,000</option>
      
                                </select>
                            </div>
                        </div>
                    </div> 

                    <div class="col-md-2 col-sm-6 pad-LR tabpading">
                        <label for="exampleInputPassword1" class="form-label">Fuel Type:</label>
                        <div class="row row-text-box">

                            <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                <div class="posrelative text-left">
                                    <div class="multi-dropdwn form-control">
                                        <span>Fuel Type</span><span></span> <span class="pull-right caret"></span>
                                    </div>
                                    <ul class="dropdown-menu" role="menu" id='select_fuel_type_list'>   
                                                                                

                                                 
                                                <li class="pad-L5">
                                                    <input type="checkbox" name="fuel_type[]" id="Petrol" value="Petrol"  >
                                                    <label for="Petrol"><span></span> Petrol</label>
                                                </li>

                                                

                                                 
                                                <li class="pad-L5">
                                                    <input type="checkbox" name="fuel_type[]" id="Diesel" value="Diesel"  >
                                                    <label for="Diesel"><span></span> Diesel</label>
                                                </li>

                                                

                                                 
                                                <li class="pad-L5">
                                                    <input type="checkbox" name="fuel_type[]" id="CNG" value="CNG"  >
                                                    <label for="CNG"><span></span> CNG</label>
                                                </li>

                                                

                                                 
                                                <li class="pad-L5">
                                                    <input type="checkbox" name="fuel_type[]" id="LPG" value="LPG"  >
                                                    <label for="LPG"><span></span> LPG</label>
                                                </li>

                                                

                                                 
                                                <li class="pad-L5">
                                                    <input type="checkbox" name="fuel_type[]" id="Hybrid" value="Hybrid"  >
                                                    <label for="Hybrid"><span></span> Hybrid</label>
                                                </li>

                                                

                                                 
                                                <li class="pad-L5">
                                                    <input type="checkbox" name="fuel_type[]" id="Electric" value="Electric"  >
                                                    <label for="Electric"><span></span> Electric</label>
                                                </li>

        
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
				<input type="hidden" name="old_stock" id="old_stock" value ="" />
                    <div class="col-md-2 col-sm-6 mrg-T10 tabpading pad-LR display-n advance-search">
                        <label for="exampleInputPassword1" class="form-label">Age Of Inventory :</label>
                        <div class="row row-text-box">
                            <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                <div class="posrelative text-left">
                                    <div class="multi-dropdwn form-control">
                                        <span>Age Of Inventory</span><span></span><span class="pull-right caret"></span>
                                    </div>
                                    <ul class="dropdown-menu" role="menu" id='select_age_inventory_list'>                                       
                                        <li class="pad-L5">
                                            <input type="checkbox" name="age_inventory[]" id="lastmonth" value="30_days" >
                                            <label for="lastmonth"><span></span>Within 30 days</label>
                                        </li>
                                        <li class="pad-L5">
                                            <input type="checkbox" name="age_inventory[]" id="lastweek" value="btw_31_60_days" >
                                            <label for="lastweek"><span></span>Between 31 to 60 days</label>
                                        </li>

                                        <li class="pad-L5">
                                            <input type="checkbox" name="age_inventory[]" id="last3month" value="btw_61_90_days" >
                                            <label for="last3month"><span></span>Between 61 to 90 days</label>
                                        </li>
                                        <li class="pad-L5">
                                            <input type="checkbox" name="age_inventory[]" id="lastsixmonth" value="above_90_days" >
                                            <label for="lastsixmonth"><span></span>Above 90 days</label>
                                        </li>

                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-1  col-sm-6 tabpading pad-LR display-n advance-search mrg-T10">
                        <label for="exampleInputPassword1" class="form-label">Select Owner :</label>
                        <div class="row row-text-box">
                            <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                <div class="posrelative text-left">
                                    <div class="multi-dropdwn form-control">
                                        <span>Select Owner</span><span></span><span class="pull-right caret"></span>
                                    </div>
                                    <ul class="dropdown-menu" role="menu" id="select_owner_list"> 
                                        
      
                                            <li class="pad-L5">
                                                <input type="checkbox" name="owner[]" id="1" value="1" >
                                                <label for="1"><span></span> 1</label>
                                            </li>

                        
      
                                            <li class="pad-L5">
                                                <input type="checkbox" name="owner[]" id="2" value="2" >
                                                <label for="2"><span></span> 2</label>
                                            </li>

                        
      
                                            <li class="pad-L5">
                                                <input type="checkbox" name="owner[]" id="3" value="3" >
                                                <label for="3"><span></span> 3</label>
                                            </li>

                        
      
                                            <li class="pad-L5">
                                                <input type="checkbox" name="owner[]" id="4" value="4" >
                                                <label for="4"><span></span> 4</label>
                                            </li>

                        
      
                                            <li class="pad-L5">
                                                <input type="checkbox" name="owner[]" id="Above 4" value="Above 4" >
                                                <label for="Above 4"><span></span> Above 4</label>
                                            </li>

                        

                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- <div class="col-md-1 col-sm-6 tabpading pad-LR display-n advance-search mrg-T10">
                     <label for="exampleInputPassword1" class="form-label">Body Type :</label>
                             <div class="row row-text-box">
                             <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                  <div class="posrelative text-left">
                                     <div class="multi-dropdwn form-control">
                                         <span>Body Type</span><span></span><span class="pull-right caret"></span>
                                     </div>
                                       <ul class="dropdown-menu" role="menu" id="select_bodytype_list">
             
                                                             
          
                                                                                                                     <li class="pad-L5">
                                                                                                                     <input type="checkbox" name="body_type[]" id="Convertible" value="Convertible" >
                                                                                                                     <label for="Convertible"><span></span> Convertible</label>
                                                                                                               </li>
                                                                
                                                             
                                                             
          
                                                                                                                     <li class="pad-L5">
                                                                                                                     <input type="checkbox" name="body_type[]" id="Hatchback" value="Hatchback" >
                                                                                                                     <label for="Hatchback"><span></span> Hatchback</label>
                                                                                                               </li>
                                                                
                                                             
                                                             
          
                                                                                                                     <li class="pad-L5">
                                                                                                                     <input type="checkbox" name="body_type[]" id="MUV/Minivan" value="MUV/Minivan" >
                                                                                                                     <label for="MUV/Minivan"><span></span> MUV/Minivan</label>
                                                                                                               </li>
                                                                
                                                             
                                                             
          
                                                                                                                     <li class="pad-L5">
                                                                                                                     <input type="checkbox" name="body_type[]" id="Sedan" value="Sedan" >
                                                                                                                     <label for="Sedan"><span></span> Sedan</label>
                                                                                                               </li>
                                                                
                                                             
                                                             
          
                                                                                                                     <li class="pad-L5">
                                                                                                                     <input type="checkbox" name="body_type[]" id="SUV" value="SUV" >
                                                                                                                     <label for="SUV"><span></span> SUV</label>
                                                                                                               </li>
                                                                
                                                             
                                                             
          
                                                                                                                     <li class="pad-L5">
                                                                                                                     <input type="checkbox" name="body_type[]" id="Two-Door" value="Two-Door" >
                                                                                                                     <label for="Two-Door"><span></span> Two-Door</label>
                                                                                                               </li>
                                                                
                                                                                         
                                       </ul>
                                  </div>
                             </div>
                      
                         </div>
                     </div>  -->
	
                        <div class="col-md-2  col-sm-6 tabpading pad-LR display-n advance-search mrg-T10">
                            <label for="exampleInputPassword1" class="form-label">Inspection Status :</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                    <div class="posrelative text-left">
                                        <div class="multi-dropdwn form-control">
                                            <span>Inspection Status</span><span></span><span class="pull-right caret"></span>
                                        </div>
                                        <ul class="dropdown-menu" role="menu" id="select_owner_list"> 
    
          
                                                <li class="pad-L5">
                                                    <input type="checkbox" name="inspection_status[]" id="Not Inspected" value="0" >
                                                    <label for="Not Inspected"><span></span> Not Inspected</label>
                                                </li>

                                                
          
                                                <li class="pad-L5">
                                                    <input type="checkbox" name="inspection_status[]" id="Certified" value="1" >
                                                    <label for="Certified"><span></span> Certified</label>
                                                </li>

                                                
          
                                                <li class="pad-L5">
                                                    <input type="checkbox" name="inspection_status[]" id="In Process" value="2" >
                                                    <label for="In Process"><span></span> In Process</label>
                                                </li>

                                                
          
                                                <li class="pad-L5">
                                                    <input type="checkbox" name="inspection_status[]" id="Refurbishment" value="4" >
                                                    <label for="Refurbishment"><span></span> Refurbishment</label>
                                                </li>

                                                
          
                                                <li class="pad-L5">
                                                    <input type="checkbox" name="inspection_status[]" id="Rejected" value="6" >
                                                    <label for="Rejected"><span></span> Rejected</label>
                                                </li>

                                                
          
                                                <li class="pad-L5">
                                                    <input type="checkbox" name="inspection_status[]" id="Expired" value="7" >
                                                    <label for="Expired"><span></span> Expired</label>
                                                </li>

                                                

                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div> 
                                                            <div class="col-md-1 col-sm-6 pad-LR tabpading display-n advance-search mrg-T10">
                        <label for="exampleInputPassword1" class="form-label">Transmission :</label>
                        <div class="row row-text-box">
                            <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                <div class="posrelative text-left">
                                    <div class="multi-dropdwn form-control">
                                        <span>Transmission</span><span></span><span class="pull-right caret"></span>
                                    </div>
                                    <ul class="dropdown-menu" role="menu" id="select_transmission_list">


                              
                                                <li class="pad-L5">
                                                    <input type="checkbox" name="transmission_type[]" id="Automatic " value="Automatic" >
                                                    <label for="Automatic "><span></span> Automatic </label>
                                                </li>

        

                              
                                                <li class="pad-L5">
                                                    <input type="checkbox" name="transmission_type[]" id="Manual " value="Manual" >
                                                    <label for="Manual "><span></span> Manual </label>
                                                </li>

        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2  col-sm-6 pad-LR tabpading display-n advance-search">
                        <div class="row row-text-box">
                            <div class="col-xs-12 mrg-all-0 sm-text-box mrg-T20">                        	
                                <input   type="checkbox" id="car-withoutPhotos" name="car-withoutPhotos" ><label for="car-withoutPhotos"><span></span>
                                    Car Without Photos</label><br>
                                <input   type="checkbox" id="car-withPhotos" name="car-withPhotos" ><label for="car-withPhotos"><span></span>
                                    Car With Photos</label>
                            </div>
                        </div>
                    </div>
                                
                                                                        <div class="col-md-2  col-sm-6 pad-LR tabpading display-n advance-search">
                                <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box mrg-T20">                        	

                                        <input   type="checkbox" id="isclassified_tab" name="isclassified_tab"  ><label for="isclassified_tab"><span></span>
                                            Classified Cars</label> <br>
                                             <input   type="checkbox" id="nonclassified_tab" name="nonclassified_tab"  ><label for="nonclassified_tab"><span></span>
                             Non Classified Cars</label>
                                        
                                             <!--<input  onclick="" type="checkbox" id="car-Eligible" name="bringontop" ><label for="car-Eligible"><span></span>
                                               Eligible for bring to top</label>-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2  col-sm-6 pad-LR tabpading display-n advance-search">
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box mrg-T20">                        	
                                    <input  onclick="" type="checkbox" id="car-Premium" name="ispremium" ><label for="car-Premium"><span></span>
                                        Featured Cars</label>
                                        <input   type="checkbox" id="trustmark-certified" name="trustmark-certified" ><label for="trustmark-certified"><span></span>
                                            Trustmark Certified</label>
                                        <!--<br>
                                         <input   type="checkbox" id="is_rsa" name="is_rsa"  ><label for="is_rsa"><span></span>
                                        Eligible for RSA</label>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2  col-sm-6 pad-LR tabpading display-n advance-search">
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box mrg-T20">                        	
                                    <input  onclick="" type="checkbox" id="car_with_issues" name="car_with_issues" ><label for="car_with_issues"><span></span>Cars With Issues</label>
                                </div>
                            </div>
                        </div>
	
	

                    <div class="col-md-2 pad-LR pull-right">
                        <div class="row row-text-box">
                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                <label for="exampleInputPassword1" class="form-label"></label>
                                <button type="button" id="inventory_search" class="btn btn-primary mrg-T20" onclick="pagee = 0;getResults();">Search</button>
                                <button type="button" class="btn btn-default mrg-T20" onClick="document.searchform.reset();
                                    $('option:selected').removeAttr('selected');
                                    $('input:checkbox').removeAttr('checked');
                                    $('#car-Premium').attr('checked', false);
                                    $('#is_rsa').attr('checked', false);$('#car-withPhotos').attr('checked', false);$('#car_id_reg_no').val('');
                                    $('#select_fuel_type_list,#select_age_inventory_list,#select_owner_list,#select_bodytype_list,#select_transmission_list,#select_flag_list').trigger('click');
                                    $('#carid').val('');
                                    pagee = 0;
                                    getResults();
                                    $('select[name=select_price_min_list] option,select[name=select_price_max_list] option,select[name=select_km_min_list] option,select[name=select_km_max_list] option,select[name=select_myear_from_list] option,select[name=select_myear_to_list] option').show();$('#model').attr('disabled', 'disabled');">Reset</button><br>
                                <a class="btn-block advanced-search-btn pad-L10 mrg-T5 font-12" onclick="$('#serch-wrapper').toggleClass('min_height_235');" href="javascript:void(0);">
                                    <i class="fa fa-plus-square-o down font-14 mrg-R5" data-unicode="f01a"></i><i class="fa fa-minus-square-o up font-14 mrg-R5" data-unicode="f01b" style="display:none;"></i>Advanced Search</a>
                            </div>

                        </div>
                    </div>

                </div>
                <input type="hidden" value="" name="tab_value" id="tab_value" />
                <input type="hidden" value="" name="sort_by" id="sort_by" />
                <input type="hidden" name="issue_old_stock" id="issue_old_stock" value ="" >
                <input type="hidden" name="issue_year_km" id="issue_year_km" value ="" >
                <input type="hidden" name="pending_leads" id="pending_leads" value ="" >
                <input type="hidden" name="total_active_leads" id="total_active_leads" value ="" >
                <input type="hidden" name="doubtfull_inventory" id="doubtfull_inventory" value ="" >
                </form>

            </div>
        </div><!-- /End Search Filter -->
    </form>

    <script>
        $(document).ready(function () {

            $('#make').change(function () {
                $.ajax({
                    url: "http://rakesh.com/user/ajax/get_car_model_list.php?type=make&make=" + $(this).val(),
                    success: function (data) {
                        $('#model').html(data);
                        if ($.trim(data.length) < 40)
                        {
                            $('#model').attr('disabled', 'disabled');
                        } else {
                            $('#model').attr('disabled', false);
                        }
                    }
                });
            });

            $('select[name=select_price_min_list]').change(function () {
                var min_val = parseInt($(this).val());
                $('select[name=select_price_max_list] option').each(function () {
                    if (parseInt($(this).attr('value')) < min_val)
                    {
                        $(this).hide();
                    } else
                    {
                        $(this).show();
                    }
                });
            });
            $('select[name=select_price_max_list]').change(function () {
                var min_val = parseInt($(this).val());
                $('select[name=select_price_min_list] option').each(function () {
                    if (parseInt($(this).attr('value')) > min_val)
                    {
                        $(this).hide();
                    } else
                    {
                        $(this).show();
                    }
                });
            });

            $('select[name=select_km_min_list]').change(function () {
                var min_val = parseInt($(this).val());
                $('select[name=select_km_max_list] option').each(function () {
                    if (parseInt($(this).attr('value')) < min_val)
                    {
                        $(this).hide();
                    } else
                    {
                        $(this).show();
                    }
                });
            });
            $('select[name=select_km_max_list]').change(function () {
                var min_val = parseInt($(this).val());
                $('select[name=select_km_min_list] option').each(function () {
                    if (parseInt($(this).attr('value')) > min_val)
                    {
                        $(this).hide();
                    } else
                    {
                        $(this).show();
                    }
                });
            });

            $('select[name=select_myear_from_list]').change(function () {
                var min_val = parseInt($(this).val());
                $('select[name=select_myear_to_list] option').each(function () {
                    if (parseInt($(this).attr('value')) < min_val)
                    {
                        $(this).hide();
                    } else
                    {
                        $(this).show();
                    }
                });
            });

            $('select[name=select_myear_to_list]').change(function () {
                var min_val = parseInt($(this).val());
                $('select[name=select_myear_from_list] option').each(function () {
                    if (parseInt($(this).attr('value')) > min_val)
                    {
                        $(this).hide();
                    } else
                    {
                        $(this).show();
                    }
                });
            });

            $('#select_fuel_type_list,#select_age_inventory_list,#select_owner_list,#select_bodytype_list,#select_transmission_list,#select_flag_list').click(function () {
                var ths = this;
                var selected = 0;
                $(':checked', this).each(function () {
                    selected++;
                    $(ths).prev().find('span').eq(0).hide();
                    $(ths).prev().find('span').eq(1).html($(this).next().text());

                });
                if (selected > 1)
                {
                    $(ths).prev().find('span').eq(1).html(selected + " selected");
                } else if (selected == 0) {
                    $(ths).prev().find('span').eq(0).show();
                    $(ths).prev().find('span').eq(1).html('');
                }
            });

            $('.tabs_sell button').click(function () {
                $(this).siblings().removeClass('active');
                $(this).addClass('active');
            });


        });
        $("#car_id_reg_no").autocomplete({
            source: function (request, response) {
                // alert('ok test');return false;
                $.ajax({
                    url: "http://rakesh.com/user/ajax/autocomplete_regno.php",
                    dataType: "json",
                    data: {
                        term: request.term,
                        dealerid: "69",
                        //	sid: jQuery('#car_id_reg_no').val(),                  
                    },
                    //alert(data);return false;
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function (event, ui) {
                // AutoCompleteSelectHandler(event, ui)		  
            }
        });


        $("#car_id_reg_no").change(function () {
            $('.ui-helper-hidden-accessible').css('display', 'none');
        });
    </script>
</div>
    <div class="row mrg-B20 tabs_sell">
        <div class="col-sm-8 col-md-9">
            <button style="position:relative;" type="button" id="gaadi" onclick="$('#tab_value').val('');
                pagee = 0;
                getResults();
                $('#remove_to_list').hide();
                $('#remove_to_list span').eq(0).removeClass('icon-add');
                $('#remove_to_list span').eq(1).html('Remove');$('#all-actions-multiple').show();
                $('#all-actions-multiple-more').show();$('label[for=car-Premium],label[for=car-Eligible]').show();"  class="btn btn-default tab-btn active type_btn">
                Available <span class="badge" id="available_tab">

                </span>
                <img class="countloader" src="http://rakesh.com/origin-assets/boot_origin_asset_new/images/loader.gif" style="position: absolute; right: 20px; top: 6px; width: 16px; display: none;">
            </button>
                            <button style="position:relative;" type="button" id="removed" onclick="$('#tab_value').val('removed');
                    pagee = 0;
                    getResults();
                    $('#remove_to_list span').eq(0).addClass('icon-add').removeClass('icon-delete');
                    $('#remove_to_list span').eq(1).html('Add to Stock');
                    $('#remove_to_list').show();
                    $('#all-actions-multiple').show();
                    $('#all-actions-multiple-more').hide();
                    $('label[for=car-Premium],label[for=car-Eligible]').hide();"  class="btn btn-default tab-btn type_btn">
                    Removed <span class="badge bg-w" id="removed_tab">

                    </span>
                    <img class="countloader" src="http://rakesh.com/origin-assets/boot_origin_asset_new/images/loader.gif" style="position: absolute; right: 20px; top: 6px; width: 16px; display: none;">
                </button>
                        <button style="position:relative;" type="button" id='all'  onclick="$('#tab_value').val('all');pagee = 0;getResults();
                $('#all-actions-multiple').hide();
                $('label[for=car-Premium],label[for=car-Eligible]').show();" class="btn btn-default tab-btn type_btn">
                All <span class="badge" id="all_tab">

                </span>
                <img class="countloader" src="http://rakesh.com/origin-assets/boot_origin_asset_new/images/loader.gif" style="position: absolute; right: 20px; top: 6px; width: 16px; display: none;">
            </button>
                        <img style="display: none;left: 50%;position: fixed;top: 50%;z-index: 1002;border-radius:30px;" src="http://rakesh.com/origin-assets/boot_origin_asset_new/images/loader.gif" class="searchresultloader">
        </div>
<div class="" style="float:right;">
                <div class="form-group pull-left mrg-B0" style="padding-right:15px;">                    <label for="exampleInputName2" class="pull-left" style="line-height: 28px; padding-right:15px;"><b>Sort By : </b></label>
                    <select class="form-control shortby pull-left" id="sortby" name="sortby" onchange="$('#sort_by').val(this.value);pagee = 0;
                                                getResults();" style="width:140px;" >
                        <option value="">  Select  </option>
                        <option value="pricefrom-DESC">Price:Highest</option>
                        <option value="pricefrom-ASC">Price: Lowest</option>
                        <option value="myear-DESC">Year: Newest</option>
                        <option value="myear-ASC">Year: Oldest</option>
                        <option value="km-DESC">Km:Highest</option>
                        <option value="km-ASC">Km:Lowest</option>
                        <!--<option value="profile-DESC">% Complete:Highest</option>
                        <option value="profile-ASC">% Complete:Lowest</option>-->
                        <option value="make-ASC">Vehicles: A to Z</option>
                        <option value="make-DESC">Vehicles: Z to A</option>
                    </select>
                </div>

            </div>
        

    </div>

    <style>
		.lead-circle .lead-circle1{width: 90px; height: 90px; border: solid 7px #e3e3e3; background: #ffffff; border-radius: 50%; position: relative; display: inline-block; color: #444; transition: all 0.3s;}
		.lead-circle1:hover{border: solid 7px #e3e3e3; background: #ffffff;color: #444;}
	</style>
    <ul class="list-unstyled car-list" id="mydynamic_ul">
        <span id="imageloder" style="display:none;position: absolute;left: 50%;border-radius: 50%;">    <img src="http://rakesh.com/origin-assets/boot_origin_asset_new/images/loader.gif"></span> 
    </ul>
    <div id="loadmoreajaxloader"  style="text-align:center;margin-bottom:20px;font-size:10px;cursor:pointer;"><img src="ajax/loading.gif" title="Click for more" />Loading...</div>
    <div style="margin: 5px 0px 20px 0px; float: right;">
            </div> 
    <div id="loadmoreajaxloader"  style="display:none;text-align:center;margin-bottom:20px;font-size:10px;cursor:pointer;"><img src="ajax/loading.gif" title="Click for more" />Click for more</div>
</div>
<!-- Popups Start -->
<div id='autopopulate_content' class="autopopulate_content">
</div>
<!-- REMOVE STOCK modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-removestock">
    <div class="modal-body text-center">

    </div>
</div>


<!-- ADD STOCK modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-addtostock">
    <div class="modal-body text-center">

        <div class="modal-dialog">
            <div class="modal-content">

            </div><!-- /.modal-content -->
        </div>
    </div>
</div>

<!-- Make Premium modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-makePremium">
    <div class="modal-body text-center">

    </div>
</div>
<!-- Bring to top modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-brintTOtop">
    <div class="modal-body text-center">

    </div>
</div>
<!-- Add Lead modal -->

<!-- Add Buyer Lead modal -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-add-buyer" style="background: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-lg" style="width:77%">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close cross_close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Add Buyer Lead</h4>
            </div>

            <div class="modal-body" >

                <iframe id="add-buyer-lead-iframe" src="" width="100%"  height="266" frameborder="0"></iframe>


<!--<button type="button" class="btn btn-default  cross_close" data-dismiss="modal" ><span class="close"></span>Cancel</button>-->
                <button class="btn btn-default" data-dismiss="modal" type="button" style=" bottom: 90px;float: right;position: relative;right: 87px; -webkit-margin-before: -19px; ">Close</button>





            </div>



        </div>
    </div>


</div><!-- /.modal-content -->
<!-- Send as Email modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-seadASemail">
    <div class="modal-body">

    </div>
</div>

<!-- Issue Warranty modal -->
<div class="modal fade bs-example-modal-lg in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-issuewarrenty">
    <div class="modal-body">

    </div>
</div>

<!-- add to dealer platform -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-addToDealerPlatform">
    <div class="modal-body">

    </div>
</div>

<!-- Mark as Sold modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-mark_as_Sold">
    <div class="modal-body text-center">

    </div>
</div>
<!----sdsdfasdfasdf-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" id="model-classified" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content" >
            <div class="modal-header bg-gray">
                <button type="button" id="xClose" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" align="center">CLASSIFIED INVENTORY</h4>
            </div>
            <div class="modal-body">
                <div class="modal-body text-center">
                    <i class="fa info-circle col-gray font-60" data-unicode="f05a"></i>
                    <span id="sureMsg"></span>
                    <span id="showMsg"></span>
                    <span class="limitExausted"></span>
                </div>
            </div>
            <div class="modal-footer">


                <span class="success" style="color:green;"></span>
                <span class="err-classified" style="color:red;"></span>
                <button type="button" id="cancelCheckBox" class="btn btn-default dialogcancel" data-dismiss="modal">Close</button>
                <span id="clss_modal"></span>                

            </div>
        </div>

    </div>
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-alert-message">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" align="center">STOCK UPDATE WARNING </h4>
            </div>
            <div class="modal-body">
                <i data-unicode="f05a" class="fa info-circle col-gray font-60"></i>
                <h2 class="col-gray mrg-T0 mrg-B0"><p class="edit-text font-15 pad-L20 pad-R20 rearrange_message">

                    </p></h2>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

            </div>
        </div><!-- /.modal-content -->
    </div>
</div>

<!-- Upload Photo modal -->
<div class="modal fade bs-example-modal-lg viewphotos"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-uploadPhoto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" onclick="pagee = pagee - 1;rlast = 0;getResults();" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">VIEW PHOTOS  </h4>
            </div>
            <!--<div class="modal-body">-->
            <div class="row">
                <div class="col-sm-12">
                    <div class="tabbable mrg-B20">
                        <div class="row mrg-B5">
                            <div class="col-sm-12 col-md-12">
                                <div class="btn-group float-ini mrg-T20 mrg-L20" role="group" aria-label="First group">
                                    <a aria-expanded="true" class="btn btn-default active" aria-controls="home" data-toggle="tab" role="tab" id="uploadmanagePhtos" href=".showAlltab">Upload Photos</a>
                                    <a href=".showAlltab" role="tab" class="btn btn-default" id="TagneweditedPhotos" data-toggle="tab" aria-controls="profile" aria-expanded="false">Tag Photos</a>
                                    <a  href=".showAlltab" role="tab" class="btn btn-default" id="vieweditedphotos" data-toggle="tab" aria-controls="profile" aria-expanded="false">View Photos<span class="badge" id="available_active_img"></span></a>
                                                                        <a  href=".showAlltab" role="tab" class="btn btn-default" id="flagedPhotos" data-toggle="tab" aria-controls="profile" aria-expanded="false">Flaged Photos<span class="badge" id="available_flaged_img"></span></a>
                                                                        <a  href=".showAlltab" role="tab" class="btn btn-default" id="rejectedPhotos" data-toggle="tab" aria-controls="profile" aria-expanded="false">Rejected Photos<span class="badge" id="available_rejected_img"></span></a>
                                </div>
                            </div>
                        </div>     
                        <div class="tab-content mrg-T0 showAlltab">
                            <div class="modal-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--</div>-->
<!--            <div class="modal-footer">
                <button type="button" onclick="pagee = pagee - 1;rlast = 0;getResults();" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>-->
        </div><!-- /.modal-content -->
    </div>
</div>

<!-- Tool tip div modal-->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="my ModalLabel" aria-hidden="true" id="tooltip-modified">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-body customized-modal-body" id="customized-modal-body">  
            </div>
        </div>
        <!-- /.modal-comment -->
    </div>
</div>

<!-- Tool tip div modal-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="tips-popup">
   
</div>

<!-- Croped image Popup -->
<div id="showPreview" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button  type="button" class="close" id='closePreview' data-dismiss="modal" aria-label="Close">X</button>
                <h4 class="modal-title" style='width: 80%;float: left;'>Image Preview</h4>
            </div>
            <div class="modal-body preview">
            </div>
            <div>
                <div class="modal-footer">
                    <span id='crop_img_success_msg' ></span>
                    <span class="loader-wait" style="display:none">    <img src="http://rakesh.com/origin-assets/boot_origin_asset_new/images/loader.gif"></span> 
                    <span><button type="button" id='crop_image' class="btn btn-success pull-right">Save</button></span>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
 
 //$('#tooltip-modified').modal('show');
       $('#crop_image').click(()=>cropImage());
    const cropImage=()=>{
        $.ajax({
            type: "POST",
            url: "ajax/save_rotate_crop.php?t=crop",
            data: $('#crop_data').serialize(),
            dataType: "json",
            beforeSend: function ()
            {
                $('#crop_image').css('display','none');
                $('.loader-wait').css('display','block');
                
            },
            success: function (responseData, status, XMLHttpRequest)
            {
                $('.loader-wait').css('display','none');
                $(".strip li:nth-child(3)").trigger('click');
                if(responseData.status=='T'){
                let image_name=responseData.image_name;
                let image_url=responseData.image_url;
                let thumb_image_url=responseData.thumb_image_url;
                let image_element='<img style="min-height:400px" img_name="'+image_name+'" src="'+image_url+'">';
                let thumb_image_element='<img  src="'+thumb_image_url+'" class="img-responsive" >';
                $active_item_id=$('#carousel_inner').children('div.active').attr('id');
                $nth_image=$active_item_id.split('_');
                $('#carousel_inner').children('div.active').html(image_element);
                $('#carousel-thumb-img').find('li#carousel-selector-'+$nth_image[1]).html(thumb_image_element);
                
                //$('#closePreview').trigger('click');
                $('#crop_img_success_msg').css('color','green');
                $('#crop_img_success_msg').html(responseData.msg);
                }
                else{
                    $('#crop_img_success_msg').css('color','#d04437');
                    $('#crop_img_success_msg').html(responseData.msg);
                    
                }
                setTimeout(()=>{
                    $('#crop_img_success_msg').html('');
                    $('#closePreview').trigger('click');
                },2500);
               
            }

        });
    }
    const rotateImage =()=>{
        var image_name=$('#carousel_inner').children('.active').children('img').attr('img_name');
        $.ajax({
            type: "POST",
            url: "ajax/save_rotate_crop.php?t=rotate",
            data: $('#rotate_data').serialize()+'&image_name='+image_name,
            dataType: "json",
            beforeSend: function ()
            {
                $('.loader-for-rotate').css('display','block');
            },
            success: function (responseData, status, XMLHttpRequest)
            {
                $('.loader-for-rotate').css('display','none');
                if(responseData.status=='T'){
                let image_name=responseData.image_name;
                let image_url=responseData.image_url;
                let thumb_image_url=responseData.thumb_image_url;
                let image_element='<img style="min-height:400px" img_name="'+image_name+'" src="'+image_url+'">';
                let thumb_image_element='<img  src="'+thumb_image_url+'" class="img-responsive" >';
                $active_item_id=$('#carousel_inner').children('div.active').attr('id');
                $nth_image=$active_item_id.split('_');
                $('#carousel_inner').children('div.active').html(image_element);
                $('#carousel-thumb-img').find('li#carousel-selector-'+$nth_image[1]).html(thumb_image_element);
                }
                else{
                    
                }
            }

        });
    }
    function popupMsgShow($car_id){
       $("#hoverCID"+$car_id).show();
    }
    function popupMsgHide($car_id){
        $("#hoverCID"+$car_id).hide();
    }

    $("#classifiedcheckuncheck").change(function () {

        //alert(34343245);
    });
        dealer_id =69;
        gcd=+dealer_id + 1000;
        gcdCode ='GCD'+gcd;
    function GAViewOnWebsite(){
        //alert(gcdCode);
         _gaq.push(['_trackEvent', 'Manage Inventory', 'Website',gcdCode]);
    }
    function GAViewOnGaadi(){
        //alert(gcdCode);
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Website',gcdCode]);
    }
    function GAViewOnCardekho(){
        //alert(gcdCode);
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Website',gcdCode]);
    }
  

    function forceNumber(event) {
        var keyCode = event.keyCode ? event.keyCode : event.charCode;
        if ((keyCode < 48 || keyCode > 58) && keyCode != 188 && keyCode != 8 && keyCode != 127 && keyCode != 13 && keyCode != 0 && !event.ctrlKey)
            return false;
    }



    /* jQuery(document).ready(function($){
     $('.pie_progress').asPieProgress({
     'namespace': 'pie_progress'
     });
           
     $('.pie_progress').asPieProgress('go', '50%');
           
     });*/
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    /*function issue_certification_warranty(certification_id)
     {
     var myModal = $('#model-mark_as_Sold');
     var modalBody = myModal.find('.modal-body');
     modalBody.load(BASE_HREF+'user/ajax/issue_certification_warranty_new.php?car_id='+certification_id);
     }*/
    function issue_certification_warranty(certification_id)
    {
        var myModal = $('#model-mark_as_Sold');
        $('.model-body').html('');
        var modalBody = myModal.find('.modal-body');
        modalBody.load(BASE_HREF + 'user/ajax/issue_certification_warranty_new.php?page_from=manage_inventory&car_id=' + certification_id, function () {

            $('#model-mark_as_Sold #vechicle_sale_date').datetimepicker({timepicker: false, format: 'd-m-Y'});


            $('#model-mark_as_Sold #txtEmail').keydown(function (e) {
                if (e.which == 13)
                {

                    $('#model-mark_as_Sold #btnSubmit').trigger('click');
                    return false;
                }

            })

            $('#model-mark_as_Sold #warranty_type').change(function () {
                //alert($('#warranty_type').val());
                $.ajax({
                    type: "POST",
                    url: "http://rakesh.com/user/ajax/issue_certification_warranty_new.php?type=warranty&pack=" + $('#model-mark_as_Sold #warranty_type').val(),
                    data: "",
                    dataType: "html",
                    success: function (responseData, status, XMLHttpRequest) {
                        //alert(responseData);
                        $('#model-mark_as_Sold #warrenty_expires_on').val(responseData);
                        //jQuery('#susM').text('Done');
                        //setTimeout('parent.$.colorbox.close()','900');




                    }

                })

            });


            $('#model-mark_as_Sold .issue_warranty_btn').click(function () {


                var custname = $.trim($('#model-mark_as_Sold #custname').val());
                var mobile = $.trim($('#model-mark_as_Sold #mobile').val());
                var phone = $.trim($('#model-mark_as_Sold #phone').val());
                var address = $.trim($('#model-mark_as_Sold #address').val());
                // alert(address);
                var warranty_type = $.trim($('#model-mark_as_Sold #warranty_type').val());

                var price = $.trim($('#model-mark_as_Sold #txtPrice').val());
                var odometer = $.trim($('#model-mark_as_Sold #txtOdometerReading').val());
                var city = $.trim($('#model-mark_as_Sold #txtCity').val());


                var txtEmail = $.trim($('#model-mark_as_Sold #txtEmail').val());
                var emailRegex = new RegExp(/^.+@.+\..{2,3}$/);
                var alphanumericpattern = /^[A-Za-z\d\s]+$/;
                var regMobile = /^[7-9][0-9]{9}$/;
                var numeric = /^\d*$/;
                var eerror = false;
                var namepattern = /^[A-Za-z\s]+$/;
                // var emailRegex = new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i);
                var updateIdCheck = '';
                //alert(odometer);exit;


                if (!(parseInt(warranty_type) > 0))
                {
                    $('#model-mark_as_Sold #spnwarranty_type').text('Select Warranty Type.');
                    //$('#spnEmail').css('display','block');
                    eerror = true;
                    return false;
                } else {
                    $('#model-mark_as_Sold #spnwarranty_type').text('');
                    //$('#spnEmail').css('display','block');
                    eerror = false;
                }


                //|| (!numeric.test(price))
                if (price == '' || (!numeric.test(price))) {
                    $('#model-mark_as_Sold .spnPrice').text('Enter a Valid Price.');
                    //$('#spnEmail').css('display','block');
                    eerror = true;
                    return false;
                } else {
                    $('#model-mark_as_Sold .spnPrice').text('');
                    eerror = false;//
                }

                if (odometer == '' || (!numeric.test(odometer))) {
                    $('#model-mark_as_Sold .spnOdometer').text('Enter a Valid Reading.');
                    //$('#spnEmail').css('display','block');
                    eerror = true;
                    return false;
                } else if (odometer != '') {
                    var odometerVal = parseInt($('#model-mark_as_Sold .kmhidden').val());
                    //alert(odometer);
                    //alert(odometerVal);
                    //console.log(0);
                    //odometerVal = parseInt('200');
                    //var maxInc = 500;
                    //  var odometerFinal = parseInt( odometerVal + maxInc);
//                alert(parseInt(odometer));
//                alert(parseInt(odometerVal));
                    //if( (odometer > odometerFinal) || (parseInt(odometer) < parseInt(odometerVal)) ){
                    if (parseInt(odometer) < parseInt(odometerVal)) {
                        $('.spnOdometer').text('Odometer reading should not be less than actual Kms Driven.');
                        eerror = true;
                        return false;

                    } else {
                        $('#model-mark_as_Sold .spnOdometer').text('');
                        eerror = false;//spnOdometer
                    }
                } else {
                    $('#model-mark_as_Sold .spnOdometer').text('');
                    eerror = false;//spnOdometer
                }

                if (custname == '')
                {
                    $('#model-mark_as_Sold #spncustname').text('Enter Valid Name.');
                    //$('#spnEmail').css('display','block');
                    eerror = true;
                    return false;
                } else {
                    $('#model-mark_as_Sold #spncustname').text('');
                    //$('#spnEmail').css('display','block');
                    eerror = false;
                }
                if (custname != '')
                {
                    if ((!custname.match(namepattern)))
                    {
                        $('#model-mark_as_Sold #spncustname').text('Enter Valid Name.');
                        //$('#spnEmail').css('display','block');
                        eerror = true;
                        return false;
                    } else {
                        $('#model-mark_as_Sold #spncustname').text('');
                        //$('#spnEmail').css('display','block');
                        eerror = false;
                    }

                }
                if (txtEmail == '' || (!emailRegex.test(txtEmail)))
                {
                    $('#model-mark_as_Sold #spnEmail').text('Enter a Valid Email.');
                    //$('#spnEmail').css('display','block');
                    eerror = true;
                    return false;
                } else {
                    $('#model-mark_as_Sold #spnEmail').text('');
                    //$('#spnEmail').css('display','block');
                    eerror = false;
                }
                if (mobile == '' || (!regMobile.test(mobile)))
                {
                    $('#model-mark_as_Sold #spnmobile').text('Enter Valid Mobile.');
                    //$('#spnEmail').css('display','block');
                    eerror = true;
                    return false;
                } else {
                    $('#model-mark_as_Sold #spnmobile').text('');
                    //$('#spnEmail').css('display','block');
                    eerror = false;
                }

                if (city == '')
                {
                    //alert('hello');
                    $('#spncity').text('Please select city.');
                    //$('#spnEmail').css('display','block');
                    eerror = true;
                    return false;
                } else {
                    $('#spncity').text('');
                    //$('#spnEmail').css('display','block');
                    eerror = false;
                }
                if (address == '')
                {
                    //alert('hello');
                    $('#spnaddress').text('Enter valid address.');
                    //$('#spnEmail').css('display','block');
                    eerror = true;
                    return false;
                } else {
                    $('#spnaddress').text('');
                    //$('#spnEmail').css('display','block');
                    eerror = false;
                }




                /*if(phone=='')
                 {
                 $('#spnphone').text('Enter valid phone.');
                 //$('#spnEmail').css('display','block');
                 eerror=true;
                 }else{
                 $('#spnphone').text('');
                 //$('#spnEmail').css('display','block');
                 eerror=false;
                 }*/




//alert(eerror);

//alert(eerror);
                if (eerror == false)
                {
                    //$('#btnSubmit').attr('disabled','disabled');
                    //cboxOverlay
                    $('#model-mark_as_Sold #cboxOverlay').show();
                    $.ajax({
                        type: "POST",
                        url: "http://rakesh.com/user/ajax/issue_certification_warranty_new.php?" + $('#model-mark_as_Sold #issuewarrantyform').serialize(),
                        data: "",
                        dataType: "html",
                        success: function (responseData, status, XMLHttpRequest) {
                            //alert(responseData);
                            var myObject = eval('(' + responseData + ')');
                            //alert(myObject.status);   
                            if (myObject.status == 'T') {
                                //alert('WarrantyId:'+myObject.warrantyID);
                                var car_id = $('#model-mark_as_Sold #car_id').val();
//                                $.ajax({
//                                    type: "POST",
//                                    url: "issue_certification_warranty.php?submit=update&car_id="+car_id,
//                                    data: "",
//                                    dataType:"html",
//                                    success:function (responseData, status, XMLHttpRequest) { 
//                                       //alert('test'); 
//                                    }
//                                });
                                $('#model-mark_as_Sold #formshow').hide();
                                $('#model-mark_as_Sold #warrantyid').text(myObject.warrantyID);
                                $('#model-mark_as_Sold #hide').show();
                                $('#model-mark_as_Sold #btnSubmit').hide();
                                $('#model-mark_as_Sold #search').trigger('click');
                                var t = setTimeout(function () {
                                    pagee = pagee - 1;
                                    rlast = 0;
                                    getResults();
                                }, 1000);

                                //window.top.location.href = ""; 
                            } else
                            {


                                $('#model-mark_as_Sold #msg_new').text(myObject.msg);

                                //alert(myObject.msg);
                            }
                            $('#model-mark_as_Sold #cboxOverlay').hide();
                            //jQuery('#susM').text('Done');
                            //setTimeout('parent.$.colorbox.close()','900');




                        }

                    })

                }


            });



        });
    }

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
    function checkEditForm(val1, val2, val3, val4, val5)
    {
        if (val1 == '0' && val2 == "" && val3 == "1" && val5 == '')
        {
            window.location.href = 'add_inventories.php?car_id=' + val4;
            return false;
        } else
        {
            var myModal = $('#model-alert-message');
            $(".rearrange_message").html('');
            if (val1 == '1' || val5 != 'Not Inspected')
            {
                $(".rearrange_message").html('This car has been Inspected, so only its Price can be edited.');
            }

            if (val2 != '')
            {
                $(".rearrange_message").html('This stock has been marked as Trustmark Certified and cannot be edited. You can however update the price.');
            }
            if (val3 != '1')
            {
                $(".rearrange_message").html('You can not edit your remove stock. You can however update the price.');
            }

            //modalBody = myModal.find('.modal-body');

            // myModal.modal('show');

            //var myModal = $('.showAlltab');
            //alert(myModal);
            var myModal = $('#model-brintTOtop');
            var modalBody = myModal.find('.modal-body');
            modalBody.html('');
            //var modalBody = myModal.find('.modal-body');
            modalBody.load('http://beta.usedcarsin.in/user/ajax/bringtop_new.php?t=s&car_id=500125');


        }
    }

function send_sms(){
       
       var sms    = $.trim($('#sms_text').val());
       var mobile = $.trim($('#mobile_no').val());
       var MobileReg = new RegExp(/^[789]\d{9}$/);
       
       if(mobile==''){
           //alert('Mobile field can not be empty');
           $('.emailcancel').prev().prev().html('Please Enter Mobile Number');
           $('#mobile_no').focus();
            var t = setTimeout(function () {
            $('.emailcancel').prev().prev().html('');
                }, 1700);
           return false;
       }
       else if(mobile.length<10){
           //alert('Enter 10 digit mobile no.');
           $('.emailcancel').prev().prev().html('Please Enter 10 Digit Mobile Number');
           $('#mobile_no').focus();
            var t = setTimeout(function () {
            $('.emailcancel').prev().prev().html('');
                }, 1700);
           return false;
       }
       else if(MobileReg.test(mobile)==false){
           //alert('Enter valid mobile no.');
           $('.emailcancel').prev().prev().html('Please Enter Valid Mobile Number');
           $('#mobile_no').focus();
            var t = setTimeout(function () {
            $('.emailcancel').prev().prev().html('');
                }, 1700);
           return false;
       }
       else if(sms=='' || sms==null){
           //alert('SMS field can not be empty');
           $('.emailcancel').prev().prev().html('Please Enter Message');
           $('#sms_text').focus();
            var t = setTimeout(function () {
            $('.emailcancel').prev().prev().html('');
                }, 1700);
           return false;
       }
                   $.ajax({
                type: "POST",
                url: "ajax/send_sms_ajax.php?" + $('#adduser').serialize(),
                data: "",
                dataType: "html",
                success: function (responseData, status, XMLHttpRequest) {
                    if(responseData=='1'){
                    $('.emailcancel').prev().html('SMS Sent Successfully ');
                    var t = setTimeout(function () {
                        $('.emailcancel').click();
                    }, 1700);
                    }
                    else{
                      $('.emailcancel').prev().prev().html('SMS Already Sent To This Mobile Number');
                       var t = setTimeout(function () {
                        $('.emailcancel').prev().prev().html('');
                       }, 3900);
                   }



                }

            });
       
       
       
   }

    function send_email()
    {
        var txtEmail = $.trim($('#txtEmail').val());
        var emailRegex = new RegExp(/^.+@.+\..{2,3}$/);


        // var emailRegex = new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i);
        var updateIdCheck = '';

        if (txtEmail == '' || (!emailRegex.test(txtEmail)))
        {
            $('.emailcancel').prev().prev().html('Please enter valid email id');
            $('#txtEmail').focus();
            var t = setTimeout(function () {
            $('.emailcancel').prev().prev().html('');
                }, 1700);
            var eerror = true;
        } else
        {
            $('.emailcancel').prev().prev().html('');
            var eerror = false;
        }
        if (eerror == false)
        {
            $('.emailloader').show();
            $.ajax({
                type: "POST",
                url: "ajax/send_emailajax.php?" + $('#adduser').serialize(),
                data: "",
                dataType: "html",
                success: function (responseData, status, XMLHttpRequest) {
                    $('.emailloader').hide();
                    // jQuery('#susM').text('Done');
                    // setTimeout('parent.$.colorbox.close()','900');

                    $('.emailcancel').prev().html('Action performed successfully - Thank You!');
                    var t = setTimeout(function () {
                        $('.emailcancel').click();

                    }, 1700);



                }

            });

        }



    }





    function make_premium() {
        var sold_price = $.trim($('#sold_price').val());
        var type = $.trim($('#type').val());

        if (type == 'sold') {
            if (isNaN(sold_price) && sold_price != '')
            {
                // $('#spnDealerPrice').text('Please enter a valid Price.');
                alert('Please enter a valid Price.');
                //$('#spnDealerPrice').css('display','block');
                var eerror = true;
            } else
            {
                // $('#spnDealerPrice').css('display','none');
                var eerror = false;
            }
        } else {
            var eerror = false;
        }


        if (eerror == false)
        {
            $('.premiumloader').show();
            $.ajax({
                type: "POST",
                url: "http://rakesh.com/user/ajax/makepremiumaction.php?" + $('#blukpremium').serialize(),
                data: "",
                dataType: "html",
                success: function (responseData, status, XMLHttpRequest) {
                    $('.premiumloader').hide();

                    $('.makepremiumcancel').prev().html('Action performed successfully - Thank You!');
                    var t = setTimeout(function () {
                        $('.makepremiumcancel').click();

                        pagee = 0;
                        //rlast=0;
                        getResults();
                    }, 2000);
                }
            })
        }
    }


    function bring_top() {
        var sold_price = $.trim($('#sold_price').val());
        var type = $.trim($('#type').val());

        if (type == 'sold') {
            if (isNaN(sold_price) && sold_price != '')
            {
                alert("Please enter a valid Price.");
                //  $('#spnDealerPrice').text('Please enter a valid Price.');
                //  $('#spnDealerPrice').css('display','block');
                var eerror = true;
            } else
            {
                // $('#spnDealerPrice').css('display','none');
                var eerror = false;
            }
        } else {
            var eerror = false;
        }


        if (eerror == false)
        {
            $('.bringloader').show();
            $.ajax({
                type: "POST",
                url: "http://rakesh.com/user/ajax/bringtopaction.php?" + $('#bluk').serialize(),
                data: "",
                dataType: "html",
                success: function (responseData, status, XMLHttpRequest) {
                    $('.bringloader').hide();

                    $('.bringtopcancel').prev().html('Action performed successfully - Thank You!');
                    var t = setTimeout(function () {
                        $('.bringtopcancel').click();
                        pagee = 0;
                        getResults();
                    }, 2000);

                }
            })
        }
    }



    function mark_as_sold() {
        var sold_price = $.trim($('#sold_price').val());
        var type = $.trim($('#type').val());
		var reson=$.trim($('#reason').val());
		//alert(reson);die;
		
            $('.soldcancel').prev().prev().html(''); 
        if (type == 'sold') {
            if (isNaN(sold_price) && sold_price != '')
            {
                $('.soldcancel').prev().prev().html('Please enter a valid Price.');
                var eerror = true;
            } else
            {
                $('.soldcancel').prev().prev().html('');
                var eerror = false;
            }
        } else {
            var eerror = false;
        }
        if(reson == '')
            {
                alert('Please select reason of car remove.');
                var eerror = true;
            }


        if (eerror == false)
        {
         //alert( $('#bluk_new').serialize());die;
            $('.soldloader').show();
            $.ajax({
                type: "POST",
                url: "http://rakesh.com/user/ajax/addremove_used_car_sold_new.php?" + $('#bluk_new').serialize(),
                data: "",
                dataType: "html",
                success: function (responseData, status, XMLHttpRequest) {
                    $('.soldloader').hide();
                    $('.soldcancel').prev().html('Action performed successfully - Thank You!');
                    var t = setTimeout(function () {
                        $('.soldcancel').click();
                        $(responseData).hide();
                        pagee = 0;
                        getResults();
                    }, 2000);
                }
            })
        }
    }



    function add_remove() {
        var sold_price = $.trim($('#sold_price').val());
        var type = $.trim($('#type').val());
        //alert($('#token').val());
        var session_token='99e0d5b68e1382090eeafa5f21c07a1e';
        var form_token=$('#token').val();
        var dealer_owner='Gaadi';
        //alert(dealer_owner);
        if(dealer_owner==='Ford')
        {
            if(session_token!==form_token)
            {
                alert('Unauthorized Access!');
                return false;
            }
            
        }
        var eerror = false;
        if (eerror == false)
        {
            $('.removeloader').show();
            $.ajax({
                type: "POST",
                url: "http://rakesh.com/user/ajax/addremove_used_car_new.php?" + $('#bluk').serialize(),
                data: "",
                dataType: "json",
                success: function (responseData, status, XMLHttpRequest) {
                    $('.removeloader').hide();
                    if (type == 'remove')
                        $('.remove-cancel').prev().html('Selected record(s) removed successfully');
                    else if (type == 'add') {
                        if(responseData.status==false){
                         alert(responseData.message);   
                        }
                        else{
                            $('.remove-cancel').prev().html('Selected record(s) added in stock successfully');
                        }
                        
                    }
                    var t = setTimeout(function () {
                        $('.remove-cancel').click();
                        $(responseData).hide();
                        pagee = 0;
                        getResults();
                    }, 2000);

                }
            });
        }
    }

    function issue_rsa_submit()
    {
        var cust_name = '';
        var email_address = '';
        var mobile_no = '';
        var city = '';
        var pincode = '';
        var address = '';
        var eerror = false;
        cust_name = $.trim($('#cust_name').val());
        email_address = $.trim($('#email_address').val());
        mobile_no = $.trim($('#mobile_no').val());
        city = $.trim($('#city').val());
        pincode = $.trim($('#pincode').val());
        address = $.trim($('#address').val());
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var regMobile = /^[7-9][0-9]{9}$/;
        var namepattern = /^[A-Za-z\s]+$/;



        //var emailRegex = new RegExp(/^.+@.+\..{2,3}$/);


        // var emailRegex = new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i);
        //var updateIdCheck='';
        if (cust_name == '')
        {
            alert("please enter customer name.");
            document.feedback_api.cust_name.focus();
            var eerror = true;
            return false;

        }
        if (cust_name != '')
        {
            if ((!cust_name.match(namepattern)))
            {
                alert("please enter a valid customer name.");
                document.feedback_api.cust_name.focus();
                var eerror = true;
                return false;
            }
        }

        if (email_address == '' || (!filter.test(email_address)))
        {
            alert("please enter valid email address.");
            document.feedback_api.email_address.focus();
            var eerror = true;
            return false;

        }
        if (mobile_no == '')
        {
            alert("please enter valid mobile number.");
            document.feedback_api.mobile_no.focus();
            var eerror = true;
            return false;

        }
        if (mobile_no != '')
        {
            if ((mobile_no.length < 10) || (!mobile_no.match(regMobile)))
            {
                alert("please enter valid mobile number.");
                document.feedback_api.mobile_no.focus();
                var eerror = true;
                return false;
            }
        }
        if (city == '0')
        {
            alert("please select city.");
            document.feedback_api.city.focus();
            var eerror = true;
            return false;

        }
        if (address == '')
        {
            alert("please enter address.");
            document.feedback_api.address.focus();
            var eerror = true;
            return false;

        }

        if (eerror == false)
        {
            var result = confirm("Issue FREE Cardekho RSA to customer? Please be sure that the car is sold. Issuing RSA will mark this inventory as sold and same will be removed from dealer system.");
            if (result) {
                //exit;
                $('.removeloader').show();
                $.ajax({
                    type: "POST",
                    url: "ajax/addremove_used_car_new.php?" + $('#feedback_api').serialize(),
                    data: "",
                    dataType: "html",
                    success: function (responseData, status, XMLHttpRequest) {
                        $('.removeloader').hide();
                        var res1 = responseData.split("~~");
                        if (res1[0] == '2')
                        {
                            $('#modalbody_hideshow1').html(res1[1]);
                            $('#bttn_showonly1').show();
                            $('#bttn_blockonly1').hide();
                            $('#again_bttn_blockonly1').hide();
                            $('#success_hide1').hide();
                            //alert(responseData);exit;
                            //if(type=='remove')
                            // $('.remove_cancelAPI').prev().html('Free Cardekho RSA has been Issued to the customer. Stock removed successfully.');
                            //else if(type=='add'){
                            //$('.remove-cancel').prev().html('Selected record(s) added in stock successfully');
                            //}
                            var t = setTimeout(function () {

                                pagee = 0;
                                getResults();
                            }, 1000);

                        } else
                        {
                            $('.remove_cancelAPI').prev().html(responseData);
                        }
                    }

                });

            }
        }



    }



    function issue_rsa_submit_sold()
    {
        var eerror = false;


        var cust_name1 = $.trim($('#cust_name1').val());
        var email_address1 = $.trim($('#email_address1').val());
        var mobile_no1 = $.trim($('#mobile_no1').val());
        var city1 = $.trim($('#city1').val());
        var pincode1 = $.trim($('#pincode1').val());
        var address1 = $.trim($('#address1').val());
        var regMobile = /^[7-9][0-9]{9}$/;
        var namepattern = /^[A-Za-z\s]+$/;
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        //$('#modalbody_hideshow').text('Free Cardekho RSA has been Issued to the customer.&#010; Please note RSA Membership Id is 456456');
//	   return false;   
        //var emailRegex = new RegExp(/^.+@.+\..{2,3}$/);


        // var emailRegex = new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i);
        //var updateIdCheck='';
        if (cust_name1 == '')
        {
            alert("please enter customer name.");
            document.feedback_api1.cust_name1.focus();
            var eerror = true;
            return false;

        }
        if (cust_name1 != '')
        {
            if ((!cust_name1.match(namepattern)))
            {
                alert("please enter a valid customer name.");
                document.feedback_api1.cust_name1.focus();
                var eerror = true;
                return false;
            }
        }

        if (email_address1 == '' || (!filter.test(email_address1)))
        {
            alert("please enter valid email address.");
            document.feedback_api1.email_address1.focus();
            var eerror = true;
            return false;

        }
        if (mobile_no1 == '')
        {
            alert("please enter valid mobile number.");
            document.feedback_api1.mobile_no1.focus();
            var eerror = true;
            return false;

        }
        if (mobile_no1 != '')
        {
            if ((mobile_no1.length < 10) || (!mobile_no1.match(regMobile)))
            {
                alert("please enter valid mobile number.");
                document.feedback_api1.mobile_no1.focus();
                var eerror = true;
                return false;
            }
        }

        if (city1 == '0')
        {
            alert("please select city.");
            document.feedback_api1.city1.focus();
            var eerror = true;
            return false;

        }
        if (address1 == '')
        {
            alert("please enter address.");
            document.feedback_api1.address1.focus();
            var eerror = true;
            return false;

        }
        //if(pincode=='')
        // {
        //	alert("please enter valid pin code.");
        //	document.feedback_api1.pincode.focus();
        //	var eerror=true;
        //	return false;

        // }
        //if(pincode.length<6)
        // {
        //	alert("please enter valid pin code.");
        //	document.feedback_api1.pincode.focus();
        //	var eerror=true;
        //	return false;

        // }

        if (eerror == false)
        {

            //return false;
            var result = confirm("Issue FREE Cardekho RSA to customer? Please be sure that the car is sold. Issuing RSA will mark this inventory as sold and same will be removed from dealer system.");
            if (result) {
                //exit;
                $('.soldloader').show();
                $.ajax({
                    type: "POST",
                    url: "http://rakesh.com/user/ajax/addremove_used_car_sold_new.php?" + $('#feedback_api1').serialize(),
                    data: "",
                    dataType: "html",
                    success: function (responseData, status, XMLHttpRequest) {
                        $('.soldloader').hide();
                        var res = responseData.split("~~");
                        if (res[0] == '1')
                        {
                            $('#modalbody_hideshow').html(res[1]);
                            $('#bttn_showonly').show();
                            $('#bttn_blockonly').hide();
                            $('#again_bttn_blockonly').hide();
                            $('#success_hide').hide();
                            //alert(responseData);exit;
                            //if(type=='remove')
                            //  $('.remove_cancelAPI').prev().html('Free Cardekho RSA has been Issued to the customer. Stock removed successfully.');
                            //else if(type=='add'){.
                            //$('.remove-cancel').prev().html('Selected record(s) added in stock successfully');
                            //}
                            var t = setTimeout(function () {

                                pagee = 0;
                                getResults();
                            }, 1000);

                        } else
                        {
                            $('.remove_cancelAPI').prev().html(responseData);
                        }
                    }

                });

            }
        }

    }



    function add_to_dealer_platform() {

        var type = $.trim($('#type').val());
        if (type == 'add') {
            var dealer_price = parseInt($('#dealer_price').val());
            var retail_price = parseInt($('#rprice').val());
            if (isNaN(dealer_price) || dealer_price == '')
            {
                $('#spnDealerPrice').text('Please enter a valid Price.');
                $('#spnDealerPrice').css('display', 'block');
                var eerror = true;
            } else if (retail_price <= dealer_price) {
                $('#spnDealerPrice').text('Dealer price should be equal to or less than retail price.');
                $('#spnDealerPrice').css('display', 'block');
                var eerror = true;
            } else
            {
                $('#spnDealerPrice').css('display', 'none');
                var eerror = false;
            }
        } else {
            eerror = false
        }
        if (eerror == false)
        {
            $('.platformloader').show();
            $.ajax({
                type: "POST",
                url: "http://rakesh.com/user/ajax/addremove_dealer_platform_new.php?" + $('#bluk').serialize(),
                data: "",
                dataType: "html",
                success: function (responseData, status, XMLHttpRequest) {
                    $('.platformcancel').prev().html('Action performed successfully - Thank You!');
                    var t = setTimeout(function () {
                        $('.platformcancel').click();
                        pagee = pagee - 1;
                        rlast = 0;
                        getResults();
                    }, 2000);
                    $('.platformloader').hide();
                }
            })
        }
    }

    function price_edit() {
        var edit_price = $.trim($('#carprice').val());
        var id = $.trim($('#car_id').val());
        var car_certification_id = $.trim($('#car_certification_id').val())?$.trim($('#car_certification_id').val()):0;
        var session_token='99e0d5b68e1382090eeafa5f21c07a1e';
        // var type=$.trim($('#type').val());
        //alert(edit_price);return false;

        $('.soldcancel').prev().prev().html('');
        var eerror = false;
        if (edit_price == '')
        {
            $('#price_error').html('Please Enter a valid Price');
            var eerror = true;
            return true;
        }

        if (eerror == false)
        {
            //alert($('#feedback_api').serialize());return false;
            $('.removeloader').show();
            $.ajax({
                type: "POST",
                url: "http://rakesh.com/user/ajax/addEditInventoryList.php?car_id=" + id,
                data: {option: 'addEditPrice', priceType: 'retail', 'priceVal': edit_price,token:session_token,car_certification_id:car_certification_id},
                dataType: "html",
                success: function (responseData) {
                    var myObject = eval('(' + responseData + ')');
                    // success:function (responseData, status, XMLHttpRequest) { 
                    if (myObject.status == 'true') {
                        $('#price_error').html('');
                        $('.removeloader').hide();
                        if(car_certification_id !='' && car_certification_id!=0){
                         $('.soldcancel').prev().html('Certification updated successfully.');
                        }
                        else{
                            $('.soldcancel').prev().html('Price updated successfully.');
                        }
                        
                        var t = setTimeout(function () {
                            $('.soldcancel').click();
                            //$(responseData).hide();
                            pagee = 0;
                            getResults();
                        }, 2000);
                    } else {
                        alert(myObject.msg);
                        $('.removeloader').hide();
                    }
                }
            })
        }
    }

    function changeCheckboxVal(car_id, checkValue,totalClassified,inventoryToList,$featured)
    { 
     $('#clss_modal').html('<button name="btnSubmit" type="button" id="classifiedList_'+car_id+'" class="btn btn-primary" >Yes</button> ');
       $('#model-classified').modal('show');
        $("#classifiedList_"+car_id).show();
        $(".limitExausted").html('');
        $("#sureMsg").html('');
        $("#showMsg").html('');
        
        if (checkValue == '1')
        {   
            var Value = '0';
            $("#sureMsg").html('<h2 class="col-gray mrg-T0 mrg-B0">Are You sure?</h2>');
			if($featured=="1")
			{
				$("#showMsg").html('<p  class="edit-text font-14 pad-L20 pad-R20">You want to remove this car from classified list.<br>This car will be removed from featured list as well.</p>');
			}
			else
			{
				$("#showMsg").html('<p  class="edit-text font-14 pad-L20 pad-R20">You want to remove this car from classified list</p>');
			}
        } else
        {
            if(inventoryToList=='0')
                {
                    $(".limitExausted").html("<p class='edit-text font-16'>You are not subscribed to Classified Listing package. <br>Please contact your sales executive to get it activated.</p>");
                    $("#classifiedList_"+car_id).hide();

                }
             else if(totalClassified==inventoryToList && inventoryToList>'0')
            {
                
                
                    $(".limitExausted").html("<p class='edit-text font-16'>Classified inventory upload limit exhausted <br>"+" To add more inventory remove some Classified inventory by unchecking.</p>");
                
                    $("#classifiedList_"+car_id).hide();
            }
            else{
            var Value = '1';
            $("#sureMsg").html('<h2 class="col-gray mrg-T0 mrg-B0">Are You sure?</h2>');
            $("#showMsg").html('<p  class="edit-text font-14 pad-L20 pad-R20">You want to add this car to classified list</p>');
            }
        }

        $('#cancelCheckBox,#xClose').click(function () {
            if (checkValue == '1')
            {
                $("#classified" + car_id).prop("checked", true);
            } else
            {
                $("#classified" + car_id).prop("checked", false);
            }

        });

        var session_token='99e0d5b68e1382090eeafa5f21c07a1e';
        $('#classifiedList_'+car_id).click(function () {
            $.ajax({
                type: "POST",
                url: "http://rakesh.com/user/ajax/addClassifed_ajax.php?car_id=" + car_id,
                data: {checkValue: Value,token:session_token},
                dataType: "html",
                success: function (responseData) {
                    
                    if (responseData == '1') {
                        $(".success").text('Action Performed successfully');
                        var t = setTimeout(
                                function () {
                                    pagee = 0;
                                    getResults();
                                }, 1000);

                        setTimeout(
                                function () {
                                    $(".success").html('');
                                    $('#model-classified').modal('hide');
                                }, 2000);
                    }
                    if(responseData == '0'){
                         $(".err-classified").text('Classified limit Exausted!');
                         setTimeout(
                                function () {
                                    $(".err-classified").html('');
                                    //$('#model-classified').modal('hide');
                                }, 1800);
                    }
                    
                }
            });
        });

        /*}*/
    }
    var application_env='local';
    if(application_env!='local'){
    $('.advanced-search-btn').click(function () {
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Advance Search', '69']);
    });
    $("#car_id_reg_no").on('blur',function(){
        
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Search by Registration No',$("#car_id_reg_no").val()]);
    });

    $('#make').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Select Make', '69']);
    });
    $('#model').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Select Model', '69']);
    });
    $('#select_price_min_list').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Price Range Min', '69']);
    });
    $('#select_price_max_list').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Price Range Max', '69']);
    });
    $('#select_myear_from_list').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Year Range Min', '69']);
    });
    $('#select_myear_to_list').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Year Range Max', '69']);
    });
    $('#select_km_max_list').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'K.M. Range Min', '69']);
    });
    $('#select_km_min_list').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'K.M. Range Max', '69']);
    });
    $('#select_fuel_type_list').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Fuel type', '69']);
    });
//    $('#select_age_inventory_list').click(function () { //alert('aqa');
//        _gaq.push(['_trackEvent', 'Manage Inventory', 'Age Of Inventory', '69']);
//    });
   }
    $('#inventory_search').click(function (){
        var stock_age='';
        var pipe =' | ';
        if($("#lastmonth").is(":checked")){
            stock_age+=(stock_age !=='')?pipe+'stock age with in 30 days':'stock age with in 30 days';
        }
        if($("#lastweek").is(":checked")){
            stock_age+=(stock_age !=='')?pipe+'stock age between 31 to 60 days':'stock age between 31 to 60 days';
        }
        if($("#last3month").is(":checked")){
            stock_age+=(stock_age !=='')?pipe+'stock age between 61 to 90 days':'stock age between 61 to 90 days';
        }
        if($("#lastsixmonth").is(":checked")){
            stock_age+=(stock_age !=='')?pipe+'stock age above 90 days':'stock age above 90 days';
        }
        
        if(stock_age!==''){
            
             _gaq.push(['_trackEvent', 'Manage Inventory',stock_age, '69']);
        }
    });
          
    
   if(application_env!='local'){
    $('#select_owner_list').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Select Owner', '69']);
    });
    $('#select_bodytype_list').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Body Type', '69']);
    });
    $('#select_transmission_list').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Transmission Type', '69']);
    });
    $('#car-withoutPhotos').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Car Without Photos', '69']);
    });
    $('#car-withPhotos').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Car With Photos', '69']);
    });
    $('#car-Premium').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Premium cars', '69']);
    });
    $('#car-Eligible').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Eligible for bring to top', '69']);
    });
    $('#trustmark-certified').click(function () { //alert('aqa');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Trustmark Certified', '69']);
    });
    $('#gaadi').click(function () { //alert('okok');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Available Tab', '69']);
    });
    $('#removed').click(function () { //alert('okok');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Removed Tab', '69']);
    });
    $('#all').click(function () { //alert('okok');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'All Tab', '69']);
    });
    $('#carid').click(function () { //alert('okok');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Search by Profile Id / Reg No', '69']);
    });
    $('#sortby').click(function () { //alert('okok');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Sort', '69']);
    });
    $('#mark_as_sold_multiple').click(function () { //alert('okok');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Mark As Sold_top', '69']);
    });
    $('#make_premium_multiple').click(function () { //alert('okok');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'Make Premium_top', '69']);
    });
    $('#remove_to_list').click(function () { //alert('okok');
        _gaq.push(['_trackEvent', 'Manage Inventory', 'RemoveTab_Add to Stock_top', '69']);
    });
    }

    $('#model-uploadPhoto').on('hidden.bs.modal', function (e) {
     $('#inventory_search').trigger('click');
    });




</script>



</body>


 <div class="vspace"></div>
    <div class="right">
	</div><form method="post" name="validRSAfirsttime" id="validRSAfirsttime"  action="manage_inventory_inquiries_new.php" >
<input type="hidden" name="is_rsa" id="is_rsa" value="1" />
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="memberModal">
       <div class="modal-body">
	   <div class="modal-dialog">
    <div class="modal-content" id="cardekho_validity_popup">
      <div class="modal-header bg-gray">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
        <h4 class="modal-title">Free Cardekho Road-Side Assistance</h4>
      </div>
      <div class="modal-body">
      <div class="pull-left">
	  <a href="http://www.cardekho.com/free-rsa.htm" target="_blank"><img src="/images/rsa2.png" title="Road-Side Assistance" alt="Road-Side Assistance" class="img-responsive mrg-B15"></a>
	  </div>
        <h2 class="mrg-T10 mrg-B5 font-18 text-primary">Give Your Customer Free Cardekho Road-Side Assistance (RSA).</h2>
        <span class="col-gray font-16">You can issue Free CarDekho Road-Side Assistance to the customer buying inspected car from you.</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default remove-cancel" data-dismiss="modal" >Close</button>
        <button type="button" class="btn btn-primary issueRSA" onclick="document.validRSAfirsttime.submit()"  >Cars Eligible For RSA</button>
      </div>
    </div>
	   
      </div>
	  </div>
    </div>
	</form>

  <footer class="font-12">
     <div class="container-fluid mrg-T0 pad-all-20 pad-B15 pad-T15 footer-container bg-color">
                <div class="pull-left  -s1">
           <ul class="footer-dealerC mrg-all-0 pad-all-0">
              <li><i class="fa fa-copyright" aria-hidden="true"></i> gaadi.com. All Rights Reserved.</li>
              <span class="pad-L5 pad-R5">|</span>
                            <li><a href="https://www.gaadi.com/dealer-tnc">Terms and Conditions</a></li>
              <span class="pad-L5 pad-R5">|</span>
              <li><a href="Javascript:void(0)" data-target="#feedBack" data-toggle="modal">Feedback</a></li>
                         </ul>
        </div>
                <div class="pull-right  -s2 " >
           <span class="f-image"><img src="http://rakesh.com/origin-assets/boot_origin_asset_new/images/svg/phone.svg" alt="call-img"><span class="font-12 pad-L5">18004192277</span><span class="pad-L5 pad-R5">|</span></span>
           <span class="f-image"><img src="http://rakesh.com/origin-assets/boot_origin_asset_new/images/svg/email.svg" alt="mail-img"> <a href="mailto:dealersupport@gaadi.com?Subject=Dealer Central Feedback" target="_top" style="background: transparent;font-size:12px;">dealersupport@gaadi.com</a></span> 
        </div>
        
     </div>
  </footer>
 <footer>

      
	


	

 <script src="http://rakesh.com/origin-assets/boot_origin_asset_new/js/tooltip.js"></script>
	 <script src="http://rakesh.com/origin-assets/boot_origin_asset_new/js/transition.js"></script>
	 
	 <script src="http://rakesh.com/origin-assets/boot_origin_asset_new/js/my.js"></script>



<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-5667080-25']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

 <!--<link href="http://rakesh.com/origin-assets/boot_origin_asset_new/css/notiny.css" rel="stylesheet" type="text/css">
        <script src="http://rakesh.com/origin-assets/boot_origin_asset_new/js/notiny.js"></script>-->
<script>
function snakbarAlert(mesage) {
    $('#snakbarAlert').html(mesage);
    $('#snakbarAlert').addClass('show');
    setTimeout(function(){  $('#snakbarAlert').removeClass('show'); }, 2000);
}
</script>
<script>
    
/*$(document).ready(function() {
     $('.notiny-container').removeAttr('style');
  
});

function snakbarAlert(text)
                    {
                        
                        $('.notiny-container').html('');
                        $('.notiny-container').removeAttr('style');
                        $.notiny({ text: text,position: 'left-bottom',delay: 1500,background: true,width: '400' });
                    }
*/
</script>
<style>
    
   /*.notiny-container {
        
        color: #fff !important;;
        text-align: center !important;;
        border-radius: 2px !important; 
        position: fixed !important;
        left: 40% !important;
        bottom: 80px !important;
        font-size: 17px !important;
        
        
    }*/
   
    #snakbarAlert {
        visibility: hidden; 
        width: 500px; margin-left: -125px;
        background-color: #2A3F54;
        color: #fff;
        text-align: center; 
        border-radius: 2px;
        padding: 16px;
        position: fixed; 
        left: 40%; 
        bottom: 30px;
        font-size: 17px;
        z-index: 9999;
        text-transform: capitalize;
        
     
    }
    
    #snakbarAlert.show { 
        visibility: visible;
        -webkit-animation: fadein 0.5s, fadeout 0.5s 1.5s !important; 
        animation: fadein 0.5s, fadeout 0.5s 1.5s !important; 
        z-index: 9999;
        text-transform: capitalize;
 
    }

</style>

<!-- Feedback modal -->

<div id="snakbarAlert"></div>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="feedBack">
    <div class="modal-dialog">
        <form name="feedback_form" id="feedback_form">
            <div class="modal-content" >
                <div class="modal-header bg-gray">
                    <button type="button" id="feedback_cancel" class="close feedback_cancel" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Feedback</h4>
                </div>
                <div class="modal-body" id="feedback_return" style="text-align:center">

                    <div class="form-group">
                        <div class="form-group text-left">
                            <label class="control-label search-form-label" for="inputSuccess2">Please Enter Your Feedback:</label>
                            <textarea class="form-control search-form-select-box feedBack" name="feedback" id="feedback" placeholder="Type Here..."></textarea>
                        </div>
                    </div>
                    <div class="panel-body text-center profile-panel dealership_upload_box">
                        <span id="screen">

                        </span>
                    </div>
                    <div class="panel-footer text-center">
                        <input type="file" class="filestyle logo-file" data-input="false" id="filestyle-0" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);" >
                        <div class="bootstrap-filestyle input-group" >
                            <div class="group-span-filestyle" id="upload_screen">
                                <input type="hidden" name="screen_screen" id="screen_screen" value=""/>
                                <label for="filestyle-0" class="btn-sm btn-primary">
                                    Upload Screenshot </label></div>


                        </div>      
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default feedback_cancel" data-dismiss="modal" id="feedback_cancel">Close</button>
                    <button type="button" class="btn btn-primary" id="feedback_sub" name="feedback_sub">Submit</button>
                </div>
            </div><!-- /.modal-comment -->
        </form>
    </div>
</div>
<!-- send Buyer SMS -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="buyersms">
<div class="modal-dialog">
<form name="buyersms_form" id="buyersms_form">
<div class="modal-content" >
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal"><img src="http://rakesh.com/images/cancel.png"> <span class="sr-only">Close</span></button>
            <h4 class="modal-title">Share with Lead</h4>
        </div>
   <div class="modal-body text-center pad-all-15" >
              
       <ul class="nav nav-tabs" id="navbar">
            <li class="active"><a id='li_email'  data-toggle="tab" href="#email" onclick="sendsms($('#custoMobile').val(),'','email',$('#email_id').val())">Email</a></li>
             <li ><a id='li_sms'data-toggle="tab" href="#sms" onclick="sendsms($('#custoMobile').val(),'','message',$('#email_id').val())">SMS</a></li>        
                 <input type="hidden" name="lead_id" value='' id='lead_id' />
             </ul>
             <div class="tab-content" >
         <div id="email" class="tab-pane fade">
            <div class="input-group mrg-T15">
            <div class="input-group-addon "><i class="fa envelope" data-unicode="f0e0"></i></div>
                <input name="txtEmail" type="email" onkeydown="" maxlength="100" placeholder="Enter Email" id="email_id" class="form-control search-form-select-box" value="">
            </div>
            <div id="buyer_lead_cars">
           
            </div> 
         </div>  
          
          <div id="whatsup" class="tab-pane fade active in">
                <div class="modal-body pad-all-15 pad-B0 pad-R0 pad-L0" id="buyerwhatsup_return" style="text-align:center">
      
                    <div class="form-group">

                        <div class="form-group text-left">

                            <input id="whatsupcustoMobile" class="form-control search-form-select-box" type="text" maxlength="10" name="whatsupcustoMobile" value="" placeholder="Enter Mobile Number" readonly='readonly'>
                        </div>
                        <div class="form-group text-left">
                            <span class="mrg-R10 mob-xs">
                                <input type="radio" onclick="sendSmsNewVersion(this.id, this.value,'whatsup');" value="1" name="whatsuptype" id="whatsuptype1" class="smstype">
                                <label for="whatsuptype1"><span></span>Send Reminder</label>
                            </span>
                            <span class="mrg-R10 mob-xs">
                                <input type="radio" onclick="sendSmsNewVersion(this.id, this.value,'whatsup');"  value="2" name="whatsuptype" id="whatsuptype2" class="smstype">
                                <label for="whatsuptype2"><span></span>Car Details</label>
                            </span>
                            <span class="mrg-R10 mob-xs">
                                <input type="radio" onclick="sendSmsNewVersion(this.id, this.value,'whatsup');" value="3" name="whatsuptype" id="whatsuptype3" class="smstype">
                                <label for="whatsuptype3"><span></span> Dealer Location</label>
                            </span>
                        </div>
                        <div class="form-group text-left">

                            <textarea class="form-control search-form-select-box feedBack" name="buyerwhatsupn" id="buyerwhatsupn" placeholder="Type Here ..."></textarea>
                        </div>
                    </div>
                    

                </div>
          </div>
         <div id="sms" class="tab-pane fade">
                <div class="modal-body pad-all-15 pad-B0 pad-R0 pad-L0" id="buyersms_return" style="text-align:center">
      
                    <div class="form-group">

                        <div class="form-group text-left">

                            <input id="custoMobile" class="form-control search-form-select-box" type="text" maxlength="10" name="custoMobile" value="" placeholder="Enter Mobile Number" readonly='readonly'>
                        </div>
                        <div class="form-group text-left">
                            <span class="mrg-R10 mob-xs">
                                <input type="radio" onclick="sendSmsNewVersion(this.id, this.value);" value="1" name="smstype" id="smstype1" class="smstype">
                                <label for="smstype1"><span></span>Send Reminder</label>
                            </span>
                            <span class="mrg-R10 mob-xs">
                                <input type="radio" onclick="sendSmsNewVersion(this.id, this.value);"  value="2" name="smstype" id="smstype2" class="smstype">
                                <label for="smstype2"><span></span>Car Details</label>
                            </span>
                            <span class="mrg-R10 mob-xs">
                                <input type="radio" onclick="sendSmsNewVersion(this.id, this.value);" value="3" name="smstype" id="smstype3" class="smstype">
                                <label for="smstype3"><span></span> Dealer Location</label>
                            </span>
                        </div>
                        <div class="form-group text-left">

                            <textarea class="form-control search-form-select-box feedBack" name="buyersmsn" id="buyersmsn" placeholder="Type Here ..."></textarea>
                        </div>
                    </div>
                    

                </div>
          </div>
      </div>    
                <div class="modal-footer pad-B0 pad-T0 pad-L15 pad-R15">
                    <span  id="success_message" style="color:green;font-family:Arial;font-size:14px"></span>
                    <span  id="error_message" style="color:red;font-family:Arial;font-size:14px"></span>
                <input type="hidden" name="send_type" id="send_type" value="email"/>
                    <button type="button" class="btn btn-default buyersms_cancel" data-dismiss="modal" id="buyersms_cancel">Cancel</button>
                                          <button type="button" class="btn btn-primary" id="buyersms_sub" name="buyersms_sub">Send</button>
                                                
                </div>
   </div>
 </div><!-- /.modal-comment -->
</form>
</div>
</div>

<!-- More Cars modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="more-cars" style="background: rgba(0, 0, 0, 0.5);">

</div>


<!-- Popups Start -->
<!-- Add Seller Lead modal -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-add-seller" >
    <form id="add_seller_lead_form">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gray">
                    <button type="button" class="close"  onclick="$('#add_seller_reset').click();$('#add_seller_lead_msg').html('');" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Add Seller Lead</h4>
                </div>

                <div class="modal-body">
                    <div class="row mrg-all-0 mrg-B0 mrg-T0">
                        <div class="col-md-3  col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Customer Name *</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                    <input type="text" placeholder="Enter Customer Name" name="add_seller_name" class="form-control search-form-select-box">
                                </div>                       
                            </div>
                        </div>

                        <div class="col-md-3  col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Mobile Number *</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                    <input type="text" placeholder="Enter Mobile Number" onkeypress="return numbersonly(event)" maxlength="10" name="add_seller_mobile" class="form-control search-form-select-box">
                                </div>                       
                            </div>
                        </div>
                        <div class="col-md-3  col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Email </label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                    <input type="text" placeholder="Enter Email" name="add_seller_email" class="form-control search-form-select-box">
                                </div>                       
                            </div>
                        </div>

                        <div class="col-md-3  col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Source</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                    <select id="status" class="form-control search-form-select-box" name="add_seller_source">
                                        <option>Walk-In</option>  
                                        <option>Gaadi</option>
                                        <option>Cardekho</option>
                                        <option>My Website</option>

                                    </select>
                                </div>                       
                            </div>
                        </div>

                    </div>
                    <div class="clearfix mrg-T15"></div>
                    <div class="row mrg-all-0 mrg-B0 mrg-T0">
                        <div class="col-md-3  col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Status</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                    <select class="form-control" name="add_seller_status">
                                        <option value="">Status</option>
                                        <option value="Hot">Hot</option>
                                        <option value="Cold">Cold</option>
                                        <option value="Warm">Warm</option>
                                        <option value="Evaluation_Scheduled">Evaluation Scheduled</option>
                                        <option value="Walked-In">Evaluation Done</option>
                                        <option value="Converted">Converted</option>
                                        <option value="Closed">Closed</option>

                                    </select>
                                </div>                       
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Follow-up Date</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">                        
                                    <div>
                                        <div class="input-append date input-group" id="dp5" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                            <input style="cursor:pointer;" readonly="readonly" class="span2 form-control calender" size="16" type="text" value="" placeholder="" name="add_seller_follow_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6  col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Comment</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                    <textarea class="form-control add-c-textBox" name="add_seller_comment" placeholder="Comment"></textarea>
                                </div>                       
                            </div>
                        </div>

                    </div>
                    <div class="comment-wrap  mCustomScrollbar scrolldivaddsell"  data-mcs-theme="dark">
                        <div id="add_seller_car_details" >
                            <div class="clearfix mrg-T15"></div>
                            <div class="firstt">
                                <div class="row mrg-all-0 mrg-B0 mrg-T0 appended-div2" style="border-top:10px solid #fff;padding-top:10px;padding-top:20px;padding-bottom:20px;background-color: #ccc;" >
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Make Year *</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                                <select class="form-control search-form-select-box add_seller_myear" name="add_seller_myear[]">
                                                    <option value="">Make Year</option>
                                                                                                            <option value="2018">2018</option>
                                                                                                            <option value="2017">2017</option>
                                                                                                            <option value="2016">2016</option>
                                                                                                            <option value="2015">2015</option>
                                                                                                            <option value="2014">2014</option>
                                                                                                            <option value="2013">2013</option>
                                                                                                            <option value="2012">2012</option>
                                                                                                            <option value="2011">2011</option>
                                                                                                            <option value="2010">2010</option>
                                                                                                            <option value="2009">2009</option>
                                                                                                            <option value="2008">2008</option>
                                                                                                            <option value="2007">2007</option>
                                                                                                            <option value="2006">2006</option>
                                                                                                            <option value="2005">2005</option>
                                                                                                            <option value="2004">2004</option>
                                                                                                            <option value="2003">2003</option>
                                                                                                            <option value="2002">2002</option>
                                                                                                            <option value="2001">2001</option>
                                                                                                            <option value="2000">2000</option>
                                                                                                            <option value="1999">1999</option>
                                                                                                            <option value="1998">1998</option>
                                                                                                            <option value="1997">1997</option>
                                                                                                            <option value="1996">1996</option>
                                                                                                            <option value="1995">1995</option>
                                                                                                            <option value="1994">1994</option>
                                                                                                            <option value="1993">1993</option>
                                                                                                            <option value="1992">1992</option>
                                                                                                            <option value="1991">1991</option>
                                                                                                            <option value="1990">1990</option>
                                                                                                            <option value="1989">1989</option>
                                                                                                            <option value="1988">1988</option>
                                                                                                            <option value="1987">1987</option>
                                                                                                            <option value="1986">1986</option>
                                                                                                            <option value="1985">1985</option>
                                                                                                            <option value="1984">1984</option>
                                                                                                            <option value="1983">1983</option>
                                                                                                            <option value="1982">1982</option>
                                                                                                            <option value="1981">1981</option>
                                                                                                            <option value="1980">1980</option>
                                                                                                            <option value="1979">1979</option>
                                                                                                            <option value="1978">1978</option>
                                                                                                            <option value="1977">1977</option>
                                                                                                            <option value="1976">1976</option>
                                                                                                            <option value="1975">1975</option>
                                                                                                            <option value="1974">1974</option>
                                                                                                            <option value="1973">1973</option>
                                                                                                            <option value="1972">1972</option>
                                                                                                            <option value="1971">1971</option>
                                                                                                            <option value="1970">1970</option>
                                                           
                                                </select>
                                            </div>                       
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Month *</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                                <select class="form-control search-form-select-box add_seller_month" name="add_seller_mmonth[]">
                                                    <option value="">Month</option>
                                                                                                            <option name="1">Jan</option>
                                                                                                            <option name="2">Feb</option>
                                                                                                            <option name="3">Mar</option>
                                                                                                            <option name="4">Apr</option>
                                                                                                            <option name="5">May</option>
                                                                                                            <option name="6">Jun</option>
                                                                                                            <option name="7">Jul</option>
                                                                                                            <option name="8">Aug</option>
                                                                                                            <option name="9">Sep</option>
                                                                                                            <option name="10">Oct</option>
                                                                                                            <option name="11">Nov</option>
                                                                                                            <option name="12">Dec</option>
                                                           
                                                </select>
                                            </div>                       
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Make *</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                                <select class="form-control search-form-select-box add_seller_make" onchange="get_model_list(this)" name="add_seller_make[]" >
                                                    <option value="">Make</option>

                                                </select>
                                            </div>                       
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Modelsadsaddsa *</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                                <select class="form-control search-form-select-box add_seller_model" onchange="get_variant_list(this)" name="add_seller_model[]" >
                                                    <option value="">Model</option>   
                                                </select>
                                            </div>                       
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Version *</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                                <select class="form-control search-form-select-box add_seller_variant" onchange="get_fuel_list(this)" name="add_seller_variant[]"  >
                                                    <option value="">Version</option>   
                                                </select>
                                            </div>                       
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Price</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                                <input type="text" maxlength="9" placeholder="Price" onkeypress="return numbersonly(event)" name="add_seller_price[]" class="form-control search-form-select-box">
                                            </div>                       
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Reg No</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                                <input type="text" placeholder="Reg No" name="add_seller_regno[]" onkeyup="$(this).val(this.value.toUpperCase());" class="form-control search-form-select-box">
                                            </div>                       
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Kms</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                                <input type="text" maxlength="7" onkeypress="return numbersonly(event)" placeholder="Kms" name="add_seller_km[]" class="form-control search-form-select-box">
                                            </div>                       
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading">
                                        <label for="exampleInputPassword1" class="control-label search-form-label ">Fuel Type</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                                <select name="add_seller_fuel_type[]" class="form-control add_seller_fuel_type">
                                                    <option value="">Select</option>
                                                    <option class="fuel" value="Petrol">Petrol</option>
                                                    <option class="fuel" value="Diesel">Diesel</option>
                                                    <option class="fuel" value="CNG">CNG</option>
                                                    <option class="fuel" value="LPG">LPG</option>
                                                    <option class="fuel" value="Hybrid">Hybrid</option>
                                                    <option class="fuel" value="Electric">Electric</option>

                                                </select> 
                                            </div>                       
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Colour</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                                <select name="add_seller_colour[]" class="form-control othercoloroption" onchange="get_other_color(this)">
                                                    <option value="">Select</option>
                                                    <option>Black</option><option>Blue</option><option>Bright Green</option><option>Red</option><option>Green</option><option>Grey</option><option>Orange</option><option>Silver</option><option>White</option><option>Yellow</option><option>Golden</option>                                                    <option class="col" value="Other">Other</option>
                                                </select> 

                                            </div>                       
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading othercolors">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Please Enter Other Color</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                                <input type="text" autocomplete="off" name="other_color[]" class="form-control search-form-select-box">
                                            </div>                       
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                                <div class="row mrg-all-0 mrg-B0 mrg-T0">
                    <div class="col-md-12">
                        <div class="form-group text-right" style="margin-bottom:-5px;">
                            <input type="reset" id="add_seller_reset" style="display:none;" />
                            <label for="inputSuccess2" class="control-label search-form-label"></label>
                            <a style="display:none;" href="javascript:void(0);" onclick="if ($('.appended-div2').size() == 2) {
                                  $(this).hide();
                              }
                              " class="btn btn-default search-btn mrg-B10 mrg-R10 remove-append2" role="button"><i class="fa minus-circle" data-unicode="f056"></i> Remove</a>
                            <a href="javascript:void(0);" onclick="add_more();$(this).prev().show();" class="btn btn-default btn-sm search-btn mrg-B10 mrg-R10" role="button"><i data-unicode="f055" class="fa plus-circle font-16"></i> Add More</a>
                        </div>	
                    </div>
                </div> 
                    
                <div class="modal-footer">
                    <span id="add_seller_lead_msg"></span>
                    <button type="button" class="btn btn-default add_lead_cancel" onclick="$('#add_seller_reset').click();
            $('#add_seller_lead_msg').html('');" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="add_seller_lead()">Submit</button>
                </div>
            </div><!-- /.modal-content -->
        </div>

    </form>
</div>       
<!-- end Popups Start -->
<!-- end Add Seller Lead modal -->  

<div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="false" id="changedealerpopup"">
      <div class="modal-dialog">
       <div class="modal-content" id="walkinfeedback1" style="width:570px; margin:0px auto;">
       <div class="modal-header bg-gray">
        <button type="button" class="close" data-dismiss="modal"><img src="http://rakesh.com/images/cancel.png"><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Change Dealer</h4>
      </div>
      <style>
        .modal label {
            margin-bottom: 10px !important;
            color: #000;
            opacity: 0.87;
            font-size: 14px;
            font-weight: 500 !important;
        }

         .mrg-B15 {margin-bottom: 15px !important;}
        
        .text-999{ color: #999;}
        /*.btn-primary { padding: 9px 45px !important; font-size: 16px;}*/
        .modal-footer .btn+.btn {margin-left: 5px;margin-bottom: 0; padding: 8px 45px; font-size: 16px}
      </style>
      <div class="modal-body pad-all-30 pad-T20 pad-B0">
       <!--  <form name="changedealer" action="executive_auth.php" id="changedealer" method="post"> -->
             <form name="changedealer" action="/admin/dealeruser/direct_login/" id="changedealer" method="post"> 
      <div class="col-md-12 clearfix">
         <div class="row pad-B15 font-14 text-999">
            Select Dealer
         </div>
         <div class="row">
                       
         </div>
        </div>
              </form>
        <div class="clearfix pad-T5">
         
        </div>         
      </div>
      <div class="modal-footer text-left pad-L30 pad-R30" id="editpopup1">
      <button type="button" class="btn btn-primary pull-left" id="" onclick="document.changedealer.submit();">SUBMIT</button>
      </div>
    </div><!-- /.modal-comment -->
      </div>
    </div>






<script src="http://rakesh.com/origin-assets/jquery-ui/ajaxupload.3.5.js"></script>
<script>
 $("#li_sms").click(function(){
     $("#send_type").val('sms');
     
 });
 $("#li_email").click(function(){
     $("#send_type").val('email');   
 });
 $("#li_whatsup").click(function(){
     $("#send_type").val('whatsup');   
 });

    inilizeajaxupload('upload_screen');

    function inilizeajaxupload(id)
    {
        var imageposition = id.split('_');
        var btnUpload = $('#' + id);
        var qstring = '';
        var path = '';

        if (imageposition[1] == 'screen') {
            qstring = '&screen=screen';
            path = 'http://localhost/' + 'feedback_image/thumb/';
        }

        //alert(btnUpload);
        var status = $('#' + imageposition[1]);
        //status.text('Uploading...');
        new AjaxUpload(btnUpload, {
            action: 'upload_feedback_file.php?q=q' + qstring,
            name: 'imagepath',
            onSubmit: function (file, ext) {
                if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
                    // extension is not allowed 
                    status.text('Only JPG,JPEG, PNG or GIF files are allowed');
                    return false;
                }
                status.text('Uploading...');
            },
            onComplete: function (file, response) {
                var ress = new Array();
                // ress=response.split('@@@');
                //
                var filename = response.split('@@@@');
                // alert(filename[0]);
//alert(response);
                status.text('');

                //Add uploaded file to list
                if ($.trim(filename[0]) == "done") {
                    $('#screen').html('<img src="' + path + filename[1] + '" alt="" />').addClass('success');
                    $("#screen_screen").val(filename[1]);
                } else {
                    alert('File was not uploaded');
                    //$('#'+imageposition[1]).text(file).addClass('error');
                }
            }
        });

    }
    function run(id,value,mobile){

         var totalchecked=$('input[name="sms_gaadi_id[]"]:checked').length;
         
         if(totalchecked==1){
             $.ajax({  
                        type: 'POST',
                        url: "ajax/buyer_sms_text.php?mobile=" + mobile + "&message=message&type=2&gaadi_id="+value,
                        dataType: 'html',
                        success: function (data) {
                            var response = data.split('@#$%*');
                            $('textarea#buyersmsn').val(response[2]);
                        }
                    });
          
         }else if(totalchecked>1){
           
            $('#'+id).attr('checked', false);
            //alert("Only 1 Car Can Be Shared Through SMS");
            $("#error_message").text('Only 1 Car Can Be Shared Through SMS');
            setTimeout(function(){ $("#error_message").text(''); }, 2500);
         }
         else{
             $('textarea#buyersmsn').val('');
         }
    }
    
    function runNewVersion(id,value,lead_id){

         var totalchecked=$('input[name="sms_gaadi_id[]"]:checked').length;
         
         if(totalchecked==1){
             $.ajax({  
                        type: 'POST',
                        url: "ajax/buyer_sms_text_v2.php?lead_id=" + lead_id + "&message=message&type=2&gaadi_id="+value,
                        dataType: 'html',
                        success: function (data) {
                            var response = data.split('@#$%*');
                            $('textarea#buyersmsn').val(response[2]);
                            $('textarea#buyerwhatsupn').val(response[2]);
                        }
                    });
          
         }else if(totalchecked>1){
           
            $('#'+id).attr('checked', false);
            //alert("Only 1 Car Can Be Shared Through SMS");
            $("#error_message").text('Only 1 Car Can Be Shared Through SMS');
            setTimeout(function(){ $("#error_message").text(''); }, 2500);
         }
         else{
             $('textarea#buyersmsn').val('');
         }
    }
    
    function sendsms(id, type = '',send_via='',customer_email,refresh='')
    { 
       if(refresh=='refresh'){
          $('#buyer_lead_cars').html('');
           $('ul#navbar > li').first().addClass('active');
           $('#email').addClass('active in');
           $('ul#navbar > li').last().removeClass('active');
           $('#sms').removeClass('active in');
           $("#send_type").val('email');  
            $("#email_id").val('');
       }
        if(customer_email!='' && customer_email!=null){
           $("#email_id").val(customer_email);
       }
       else{
          //  $("#email_id").val('');
       }
        $('#buyersms_sub_v2').show();
       
       if(send_via==''){
           send_via='message';
       }
        if (type == '') {
            $('#custoMobile').val('');
            $('#custoMobile').val(id);
        } else {
            var id = $('#custoMobile').val();

        }

        $.ajax({
            type: 'POST',
            url: "ajax/buyer_sms_text.php?mobile=" + id + "&message="+send_via+"&type=" + type,
            data: "",
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
                //alert(responseData);
                var res = responseData.split('@#$%*');
                
                if($.trim(res[0])!=='email_break'){
                
                $("#buyersms_return").css({"font-size": "100%", "align": "center"});
                $('#buyersms_return').html('<div class="form-group"><div class="form-group text-left"><input id="custoMobile" class="form-control search-form-select-box" type="text" maxlength="10" name="custoMobile" value="' + id + '" placeholder="Enter Mobile Number" readonly="readonly"></div> <div class="form-group text-left" style="color:green;" id="msgtypes"></div> <div id="lead_cars_list" ></div>  <div class="form-group text-left"><textarea class="form-control search-form-select-box feedBack" name="buyersmsn" id="buyersmsn" placeholder="Select A Car From The Above List"></textarea></div></div>');
               
                $('textarea#buyersmsn').val('');
                $('#msgtypes').html('');
                $('#msgtypes').html(res[0]);
                $('#lead_cars_list').html(res[1]);
                $('textarea#buyersmsn').val(res[2]);
                if ($.trim(res[1]) == 'sent') {
                    //alert(responseData);
                    $("#buyersms_return").css({"font-size": "100%", "align": "center"});
                    $('#buyersms_return').html('<div class="form-group" style="display:none"><div class="form-group text-left"><input id="custoMobile" class="form-control search-form-select-box" type="text" maxlength="10" name="custoMobile" value="' + id + '" placeholder="Enter Mobile Number" readonly="readonly"></div> <div class="form-group text-left" style="color:green;" id="msgtypes"></div><div class="form-group text-left"><textarea class="form-control search-form-select-box feedBack" name="buyersmsn" id="buyersmsn" placeholder="Type Here..."></textarea></div></div><div style="color:red;"id="sms_exaust_text"></div>');
                    
                    $('#sms_exaust_text').text("Sorry !! SMS limit is exhausted. You cannot send more SMS to this phone number.");
                    $('#buyersms_sub_v2').hide();
                } else {
                    //alert(responseData);
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

                        $radios.filter('[value=' + type + ']').prop('checked', true);
                    } else {
                        var $radios = $('input:radio[name=smstype]');
                        $radios.filter('[value=' + tab[0] + ']').prop('checked', true);

                    }


                }
            }
            else{

                $('#buyer_lead_cars').html(res[1]);
            }
            }//success
        });

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
            url: "ajax/buyer_sms_text_v2.php?mobile=" + id + "&message="+send_via+"&type=" + type+'&lead_id='+lead_id,
            data: "",
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
                        
                        //alert(buyersmsn);
                        if (buyersmsn.length <= 0) {

                            $("#error_message").text('Please Select A Car');
                            setTimeout(function () {
                                $("#error_message").text('');
                            }, 2500);
                            return false;
                        }
                        var alphanumericpatterncomment = /^[A-Za-z\d()-_\s]+$/;
                      /*  if (buyersmsn.length > 0) {
                            if ((!buyersmsn.match(alphanumericpatterncomment))) {

                                $("#error_message").text('Please Only Use Standard Alphanumerics');
                                setTimeout(function () {
                                    $("#error_message").text('');
                                }, 2500);
                                return false;
                            }
                        }*/
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
                            url: "ajax/buyer_sms_text_v2.php?" + $('#buyersms_form').serialize(),
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
                            var lead_id=$('#lead_id').val();
                            var url1 = 'ajax/buyer_sms_text_v2.php?id=' + values + '&customerid=' + customer_id + '&mobile=' + mobile + '&name=' + cd_customer_name + '&email_id=' + txtEmail + '&no_of_cars=' + totalchecked+'&type=emailsend'+'&lead_id='+lead_id;

                            $.ajax({
                                type: "POST",
                                url: url1,
                                data: "",
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


</script>
	</body>
	</html>
	
