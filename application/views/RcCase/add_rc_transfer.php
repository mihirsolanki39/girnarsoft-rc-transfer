<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 pad-LR-10 mrg-B40">
            <h2 class="page-title">RC Details</h2>
            <form enctype="multipart/form-data" method="post" id="rc_detail" name="rc_detail">
                <div id="rc_details" class="white-section">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="sub-title mrg-T0"></h2>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="control-label search-form-label">Customer Full Name *</label>
                                <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box">
                                        <input type="text" placeholder="Enter Customer Name" name="add_rc_customer_name" id="add_rc_customer_name" class="form-control search-form-select-box">
                                    </div>
                                </div>
                                <!-- <div class="d-arrow"></div> -->
                                <div class="error" id="err_rc_customer_name"></div>
                            </div>
                        </div>

                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label ">RC to be transfered by*</label>
                                <select class="form-control crm-form testselect1" id="pndingfrm" name="rc_transfered">
                                    <option value="1" <?= (!empty($getRcDetail['pending_from']) && $getRcDetail['pending_from'] == '1' ? 'selected=selected' : '') ?>>Dealer</option>
                                    <option value="2" <?= (!empty($getRcDetail['pending_from']) && $getRcDetail['pending_from'] == '2' ? 'selected=selected' : '') ?>>In-house</option>
                                </select>
                                <div class="d-arrow"></div>
                                <div class="error" id="err_rc_transfered"></div>
                            </div>
                        </div> -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="control-label search-form-label">Contact Number *</label>
                                <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box">
                                        <input type="text" placeholder="Enter Mobile Number" onkeypress="return numbersonly(event)" maxlength="10" name="add_rc_customer_mobile" id="add_rc_customer_mobile" class="form-control search-form-select-box">
                                    </div>
                                </div>
                                <!-- <div class="d-arrow"></div> -->
                                <div class="error" id="err_rc_customer_mobile"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="control-label search-form-label">Email *</label>
                                <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box">
                                        <input type="text" placeholder="Enter Email" name="add_rc_customer_email" id="add_rc_customer_email" class="form-control search-form-select-box">
                                    </div>
                                </div>
                                <!-- <div class="d-arrow"></div> -->
                                <div class="error" id="err_rc_customer_email"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="control-label search-form-label">Aadhar Number *</label>
                                <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box">
                                        <input type="text" placeholder="Enter Aadhar Number" name="add_rc_aadhar_number" id="add_rc_aadhar_number" class="form-control search-form-select-box">
                                    </div>
                                </div>
                                <!-- <div class="d-arrow"></div> -->
                                <div class="error" id="err_rc_aadhar_num"></div>
                            </div>
                        </div>

                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="control-label search-form-label">Assigned to*</label>
                                <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box">
                                        <select class="form-control crm-form testselect1" id="assign_to" name="assign_to">
                                            <option value="">Assigned To</option>
                                            <?php //foreach ($rtoTeam as $team => $rel) { 
                                            ?>
                                                <option value="<?php //echo $rel['id']; 
                                                                ?>" <?php //(!empty($getRcDetail['rto_agent']) && $getRcDetail['rto_agent'] == $rel['id'] ? 'selected=selected' : '') 
                                                                    ?>> <?php //echo $rel['name']; 
                                                                                                ?></option>
                                            <?php //} 
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-arrow"></div>
                                <div class="error" id="err_rc_assigned"></div>
                            </div>
                        </div> -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="control-label search-form-label">Source</label>
                                <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box">
                                        <select id="status" class="form-control search-form-select-box" name="add_rc_customer_source">
                                            <option value="Walk-In">Walk-In</option>
                                            <option value="Gaadi">Gaadi</option>
                                            <option value="Cardekho">Cardekho</option>
                                            <option value="My Website">My Website</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="error" id="err_customer_source"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="control-label search-form-label">Reg No* (RC Number)</label>
                                <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box">
                                        <input type="text" placeholder="Reg No" name="add_rc_customer_regno" id="add_rc_customer_regno" onkeyup="$(this).val(this.value.toUpperCase());" class="form-control search-form-select-box">
                                    </div>
                                </div>
                                <div class="error" id="err_rc_customer_regno"></div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="Demail" class="control-label search-form-label" style="padding-top: 25px;"><strong> From </strong></label>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="Demail" class="control-label search-form-label">State</label>
                                <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box">
                                        <select name="from_state" id="state" class=" form-control customize-form dstate">
                                            <option value="">Select State</option>
                                            <?php foreach ($stateList as $state) { ?>
                                                <?php if (isset($dealerInfo)) { ?>
                                                    <option value="<?= $state->state_id ?>" <?php if ($state->state_id == $dealerInfo[0]->state) {
                                                                                                echo "selected=selected";
                                                                                            } ?>><?= $state->state_name ?></option>
                                                <?php } else { ?>
                                                    <option value="<?= $state->state_id ?>"><?= $state->state_name ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="error" id="state_error"></div>
                            <?php echo form_error('state'); ?>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="Dname" class="customize-label">City</label>
                                <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box">
                                        <select name="from_city" id="city" class=" form-control customize-form dcity">
                                            <option value="">Select City</option>
                                            <?php foreach ($cityList as $city) { ?>
                                                <option value="<?php echo $city['city_id']; ?>" <?php if ($city['city_id'] == $dealerInfo[0]->city) {
                                                                                                    echo "selected=selected";
                                                                                                } ?>><?php echo $city['city_name'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="error" id="city_error"></div>
                                <?php echo form_error('city'); ?>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="Demail" class="control-label search-form-label" style="padding-top: 25px;"><strong> To </strong></label>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="Demail" class="control-label search-form-label">State</label>
                                <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box">
                                        <select name="to_state" id="to_state" class=" form-control customize-form dstate">
                                            <option value="">Select State</option>
                                            <?php foreach ($stateList as $state) { ?>
                                                <?php if (isset($dealerInfo)) { ?>
                                                    <option value="<?= $state->state_id ?>" <?php if ($state->state_id == $dealerInfo[0]->state) {
                                                                                                echo "selected=selected";
                                                                                            } ?>><?= $state->state_name ?></option>
                                                <?php } else { ?>
                                                    <option value="<?= $state->state_id ?>"><?= $state->state_name ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="error" id="state_error"></div>
                            <?php echo form_error('state'); ?>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="Dname" class="customize-label">City</label>
                                <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box">
                                        <select name="to_city" id="to_city" class=" form-control customize-form dcity">
                                            <option value="">Select City</option>
                                            <?php foreach ($cityList as $city) { ?>
                                                <option value="<?php echo $city['city_id']; ?>" <?php if ($city['city_id'] == $dealerInfo[0]->city) {
                                                                                                    echo "selected=selected";
                                                                                                } ?>><?php echo $city['city_name'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="error" id="city_error"></div>
                                <?php echo form_error('city'); ?>
                            </div>
                        </div>

                        <input type="hidden" value="1" name="rc_details">
                        <input type="hidden" value="<?php //!empty($getRcDetail['customer_id']) ? $getRcDetail['customer_id'] : '' 
                                                    ?>" name="customerId">
                        <input type="hidden" value="<?php //!empty($getRcDetail['rcid']) ? $getRcDetail['rcid'] : '' 
                                                    ?>" name="rcid" id="rcid">
                        <!--<input type="hidden" value="<?php //!empty($getRcDetail['pending_from']) ? $getRcDetail['pending_from'] : '' 
                                                        ?>" name="pndingfrm" id="pndingfrm">
                            -->
                        <div class="col-md-12">
                            <div class="btn-sec-width">
                                <?php
                                $stylesss = 'display:block';
                                $stylec = 'display:none';
                                $action = '';
                                /* if((($rolemgmt[0]['edit_permission']=='0') || ($rolemgmt[0]['add_permission']=='0'))  || ($rolemgmt[0]['role_name']!='admin'))
                                        {
                                          $stylesss  = 'display:none';
                                          $stylec = 'display:block';
                                          $action = base_url('uploadRcDocs/').base64_encode('RcId_'.$getRcDetail['rc_id']).'/transferred';

                                        }*/
                                ?>

                                <button type="button" class="btn-continue saveCont" style="<?= $stylesss ?>" id="rcTransferDetailButton">SAVE AND CONTINUE</button>

                                <a class="btn-continue" onclick="countinue('<?= $action ?>')" style="<?= $stylec ?>">CONTINUE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/loan_validation.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/jquery.sumoselect.min.js"></script>


<script>
    $(document).ready(function() {
        var pendingfrom = "<?= !empty($getRcDetail['pending_from']) ? $getRcDetail['pending_from'] : '' ?>";
        var rcstatus = $('#rc_status').val();
        if (pendingfrom == '2') {
            $('.trans').attr('style', 'display:block !important');
        } else if (pendingfrom == '1') {
            $('.trans').attr('style', 'display:none !important');
        } else {
            $('.trans').attr('style', 'display:block !important');
        }
        if ((rcstatus != '1') && (pendingfrom != '1')) {
            $(".RTO_changes").attr('style', 'display:block !important');
        } else {
            $(".RTO_changes").attr('style', 'display:none !important');
        }
        if (rcstatus == '2') {
            $('.rcstatus').attr('style', 'display:block !important');
            $('.xyz').attr('style', 'display:block !important');
        }
        if (rcstatus == '1') {
            $(".RTO_changes").attr('style', 'display:none !important');
            $('.rcstatus').attr('style', 'display:none !important');
            $('.xyz').attr('style', 'display:none !important');
        }
        if (rcstatus == '3') {
            //$('.trans').attr('style','display:block !important');
            $('.xyz').attr('style', 'display:block !important');
        }
        $('#assigned_on').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });
    });
    $('#rc_status').change(function() {
        var rcstatus = $('#rc_status').val();
        var pndingfrm = $('#pndingfrm').val();

        if ((rcstatus != '1') && (pndingfrm != '1')) {
            $(".RTO_changes").attr('style', 'display:block !important');
        }
        if ((rcstatus == '2') && (pndingfrm == '2')) {
            $('.rcstatus').attr('style', 'display:block !important');
            $('.trans').attr('style', 'display:block !important');
        }
        if ((rcstatus == '2') && (pndingfrm != '2')) {
            $('.rcstatus').attr('style', 'display:block !important');
            $('.trans').attr('style', 'display:none !important');
        } else if (rcstatus == '1') {
            $(".RTO_changes").attr('style', 'display:none !important');
            $('.rcstatus').attr('style', 'display:none !important');
            $('.trans').attr('style', 'display:none !important');
            $('.xyz').attr('style', 'display:none !important');
        }
        if (rcstatus == '3') {
            if (pndingfrm != '2') {
                $('.trans').attr('style', 'display:none !important');
            }
            $('.xyz').attr('style', 'display:block !important');
        }
    });
    $('#pndingfrm').change(function() {
        var pndingfrm = $('#pndingfrm').val();
        var rcstatus = $('#rc_status').val();
        if ((rcstatus != '1') && (pndingfrm != '1')) {
            $(".RTO_changes").attr('style', 'display:block !important');
        } else {
            $(".RTO_changes").attr('style', 'display:none !important');
        }
        if ((pndingfrm == '2') && (rcstatus != '1')) {
            $('.trans').attr('style', 'display:block !important');
            // $('.abc').attr('style','display:block !important');
        } else {
            $('.trans').attr('style', 'display:none !important');
            // $('.abc').attr('style','display:block !important');
        }
    });
    $('.testselect1').SumoSelect({
        triggerChangeCombined: true,
        search: true,
        searchText: 'Search here.'
    });
</script>

<script>
    jQuery(function() {
        var dd = "<?php echo date('d-m-Y H:00', strtotime(date('Y-m-d H:00')) + (3600));  ?>";
        var ddd = "<?php echo date('d-m-Y');  ?>";
        var dy = "<?php echo date('Y');  ?>";
        var cm = "<?php echo date('m');  ?>";
        var dm = "<?php echo date('H', strtotime(date('Y-m-d H:00')) + (3600));  ?>";
        var md = "<?php echo date('d-m-Y H:00', strtotime(date('Y-m-d H:00')) + (3600 * 25));  ?>";
        var search_calender_open = 0;

        jQuery('input[name=add_rc_transfer_follow_date]').datetimepicker({
            timepicker: true,
            format: 'd-m-Y H:i',
            minDate: dd ? dd : false,
            minTime: 0,
            onShow: function(ct) {
                search_calender_open = 1;
            },
            onClose: function(ct) {
                search_calender_open = 0;
            },
            onChangeDateTime: function() {
                var valArr = $('input[name=add_rctransfer_follow_date]').val().split(' ');
                if (valArr[0] == ddd) {
                    this.setOptions({
                        minTime: dm + ':00'
                    });
                    $('input[name=add_rctransfer_follow_date]').val(valArr[0] + ' ' + dm + ':00');

                } else {
                    this.setOptions({
                        minTime: '00:00'
                    });
                }
                var yArr = valArr[0].split('-');
                if (yArr[2] < dy || (yArr[1] < cm && yArr[2] == dy)) {
                    $('input[name=add_rctransfer_follow_date]').val(ddd + ' ' + dm + ':00');
                }
            }
        });
    });

    function numbersonly(e) {
        var unicode = e.charCode ? e.charCode : e.keyCode
        if (unicode != 8) { //if the key isn't the backspace key (which we should allow)
            if (unicode < 48 || unicode > 57) //if not a number
                return false //disable key press
        }
    }

    $('#state').on('change', function() {
        var selected = $(this).val();
        $.ajax({
            type: 'POST',
            url: base_url + "RcCase/getcities",
            data: {
                stateId: selected
            },
            dataType: "html",
            success: function(responseData) {
                $('#city').html(responseData);
                // $('#city')[0].sumo.reload();
            }
        });
    });

    $('#to_state').on('change', function() {
        var selected = $(this).val();
        $.ajax({
            type: 'POST',
            url: base_url + "RcCase/getcities",
            data: {
                stateId: selected
            },
            dataType: "html",
            success: function(responseData) {
                $('#to_city').html(responseData);
                // $('#city')[0].sumo.reload();
            }
        });
    });

    function rcTransferDetailErr() {
        error_flag = false;
        $('.error').html('');
        var rc_customer_name = $('#add_rc_customer_name').val();
        var rc_customer_mobile = $('#add_rc_customer_mobile').val();
        var rc_customer_email = $('#add_rc_customer_email').val();
        var rc_aadhar_number = $('#add_rc_aadhar_number').val();
        var rc_customer_regno = $('#add_rc_customer_regno').val();
        var assigned_on = $('#assigned_on').val();

        if (rc_customer_name == '') {
            $('#err_rc_customer_name').html('Enter Customer Name.');
            error_flag = true;
        }
        if (rc_customer_mobile == '') {
            $('#err_rc_customer_mobile').html('Enter Contact Number.');
            error_flag = true;
        }
        if (rc_customer_email == '') {
            $('#err_rc_customer_email').html('Enter email Name.');
            error_flag = true;
        }
        if (rc_aadhar_number == '') {
            $('#err_rc_aadhar_num').html('Enter Aadhar Number.');
            error_flag = true;
        }
        if (rc_customer_regno == '') {
            $('#err_rc_customer_regno').html('Enter RC Number.');
            error_flag = true;
        }
        return error_flag;
    }

    $('#rcTransferDetailButton').click(function() {
        var formData = $('#rc_detail').serialize();
        var err = rcTransferDetailErr();
        if (err) {
            $('.error').attr('style', 'display:block');
            return err;
        }
        saveRcTransferInfo(formData);
    });

    function saveRcTransferInfo(formData) {
        // console.log('2123564456');
        // return false;
        $.ajax({
            type: "POST",
            // url: base_url + "RcCase/saveUpdateRcData",
            url: base_url + "RcCase/saveRcInfo",
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status == 'True') {
                    snakbarAlert(response.message);
                    $('.loaderClas').attr('style', 'display:block;');
                    setTimeout(function() {
                        window.location.href = response.Action;
                    }, 2500);
                    return true;
                } else {
                    snakbarAlert(data.message);
                    return false;
                }
            }
        });
    }
</script>