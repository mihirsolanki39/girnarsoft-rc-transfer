<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />
<link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />
<div class="tab-content">
    <style>
        .error-message {
            color: #F00;
        }

        .success-box {
            color: #F00;
        }
    </style>
    <style type="text/css">
        .loaderoverlay {
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .loaderClas {
            position: fixed;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            z-index: 9999;
        }
    </style>
    <div class="loaderClas" style="display:none;"><img class="resultloader" src="<?php echo base_url() ?>/assets/images/loading.gif" style="position: absolute;left: 0;right: 0;text-align: center;top: 0;bottom: 0;margin: auto;z-index: 9999;"></div>
    <div class="loaderoverlay loaderClas"></div>
    <div class="tab-pane active" id="tab1">
        <div class="container-fluid">
            <div class="row background-color box-S">
                <div class="col-lg-12 col-md-12 bsd-sec">
                    <h4 class="basic-detail-heading mrg-all-0"><?= (!empty($empInfo)) ? 'Edit Employee Details' : 'Add Employee'; ?></h4>
                </div>
            </div>
        </div>
        <div class="container-fluid mrg-all-20 pad-all-0 mrg8">
            <div class="white-section">
                <div class="col-md-4">
                    <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if ($error) {
                    ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $this->session->flashdata('error'); ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="tab-pane active" id="tab1">
                    <?php
                    if (empty($empInfo)) {
                        $attributes = array('name' => 'add_user', 'id' => 'add_user');
                        echo form_open('', $attributes);
                    } else {
                        $attributes = array('name' => 'add_user', 'id' => 'add_user');
                        echo form_open('', $attributes);
                    } ?>
                    <input type="hidden" name="hidden_edit_id" value="<?php echo !empty($empInfo[0]['id']) ? base64_encode(DEALER_ID . '_' . $empInfo[0]['id']) : "" ?>" id="hidden_edit_id">
                    <div class="container-fluid pad-all-0 mrg8">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 bsi-sec">
                                <div class="error-box">
                                </div>
                                <span class="error-message"></span>
                                <div class="background-color">
                                    <div class="row">
                                        <div class="success-box padLR23 clearfix">
                                        </div>
                                    </div>
                                    <div class="padLR23 clearfix">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-6">
                                                <div class="form-group mrg-B29">
                                                    <label for="Dname" class="customize-label">Name*</label>
                                                    <?php
                                                    $data = array(
                                                        'name'          => 'name',
                                                        'id'            => 'name',
                                                        'value'         => set_value('name', !empty($empInfo[0]) ? $empInfo[0]['name'] : ''),
                                                        'type'          => 'text',
                                                        'data-field-name' => 'Name',
                                                        'placeholder'   => 'Enter Name',
                                                        'autocomplete'  => 'off',
                                                        'class'         => 'form-control nameCaseLoan customize-form'
                                                    );
                                                    echo form_input($data);
                                                    echo form_error('name');
                                                    ?>
                                                    <div class="error_name text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6">
                                                <div class="form-group mrg-B29">
                                                    <label for="Demail" class="customize-label">Email*</label>
                                                    <!--<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="" name="dealership_email" id="Demail" class="form-control customize-form" placeholder="Enter Email" required />-->
                                                    <?php
                                                    $data = array(
                                                        'name'          => 'email',
                                                        'id'            => 'email',
                                                        'value'         => set_value('email', !empty($empInfo[0]) ? $empInfo[0]['email'] : ''),
                                                        'type'          => 'text',
                                                        'data-field-name' => 'Email',
                                                        'placeholder'   => 'Enter Email',
                                                        'autocomplete'  => 'off',
                                                        'class'         => 'form-control customize-form'
                                                    );
                                                    echo form_input($data);
                                                    echo form_error('email');
                                                    ?>
                                                    <div class="error_email text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6">
                                                <div class="form-group mrg-B29">
                                                    <label for="Dcontact" class="customize-label">Contact No.*</label>
                                                    <!-- <input onkeypress="return isNumberKey(event)" type="tel" pattern="[6789][0-9]{9}" maxlength="10" value="" name="dealership_contact_number" id="Dcontact" class="form-control customize-form" placeholder="Enter Contact No." required/>-->
                                                    <?php
                                                    $data = array(
                                                        'name'          => 'mobile',
                                                        'id'            => 'mobile',
                                                        'value'         => set_value('mobile', !empty($empInfo[0]) ? $empInfo[0]['mobile'] : ''),
                                                        'type'          => 'text',
                                                        'data-field-name' => 'Mobile',
                                                        'placeholder'   => 'Enter Contact No.',
                                                        'maxlength'     => '10',
                                                        'autocomplete'  => 'off',
                                                        'onkeypress'    => 'return isNumberKey(event)',
                                                        'class'         => 'form-control customize-form'
                                                    );
                                                    echo form_input($data);
                                                    echo form_error('mobile');
                                                    ?>
                                                    <div class="error_mobile text-danger"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-3 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="Dname" class="customize-label">Password* <i class="fa fa-info-circle" data-toggle="tooltip" title="AlphaNumeric and min 8 chars" style="cursor:pointer;"></i></label>
                                                        <div class="input-group">
                                                            <?php
                                                            $data = array(
                                                                'name'          => 'password',
                                                                'id'            => 'password',
                                                                'value'         => set_value('password', ((!empty($empInfo[0])) ? $empInfo[0]['user_code'] : '')),
                                                                'type'          => 'password',
                                                                'data-field-name' => 'Password',
                                                                'placeholder'   => 'Enter Password.',
                                                                'autocomplete'  => 'off',
                                                                'class'         => 'form-control customize-form'
                                                            );
                                                            echo form_input($data);
                                                            ?>
                                                            <span id="dealerPass" class="input-group-addon inupt-group-addon-customize showp"><i class="fa fa-eye celender-icon"></i></span>
                                                        </div>
                                                        <?= form_error('password'); ?>
                                                        <div class="error_password text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-6">
                                                    <div class="form-group mrg-B29">
                                                        <label for="Udob" class="customize-label">Date Of Birth</label>
                                                        <div class="input-group date input-append " id="sandbox-container" data-date-format="d-m-Y">
                                                            <span class="input-group-addon inupt-group-addon-customize add-on"><i class="fa fa-calendar-o celender-icon dob-icon"></i></span>
                                                            <?php
                                                            $data = array(
                                                                'name'          => 'dob',
                                                                'id'            => 'dob',
                                                                'value'         => set_value('dob', (!empty($empInfo[0]['dob']) && $empInfo[0]['dob'] != "0000-00-00") ? date('d-m-Y', strtotime($empInfo[0]['dob'])) : ''),
                                                                'type'          => 'text',
                                                                'placeholder'   => 'Enter Date of Birth.',
                                                                'autocomplete'  => 'off',
                                                                'class'         => 'form-control date customize-form',
                                                                'readOnly' => 'readonly'
                                                            );
                                                            echo form_input($data);
                                                            ?>
                                                        </div>
                                                        <?= form_error('dob'); ?>
                                                        <div class="error_dob text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-6">
                                                    <div class="form-group mrg-B29">
                                                        <label for="Udob" class="customize-label">Date Of Joining</label>
                                                        <div class="input-group date input-append doj-icon" id="sandbox-container" data-date-format="d-m-Y">
                                                            <span class="input-group-addon inupt-group-addon-customize add-on"><i class="fa fa-calendar-o celender-icon"></i></span>
                                                            <!--<input type="text"  value="" name="owner[date_of_birth]" id="Udob" class="form-control customize-form add-on"  placeholder="Enter Date Of Birth"  readonly/>-->
                                                            <?php
                                                            $data = array(
                                                                'name'          => 'doj',
                                                                'id'            => 'doj',
                                                                'value'         => set_value('doj', (!empty($empInfo[0]['doj']) && $empInfo[0]['doj'] != "0000-00-00") ? date('d-m-Y', strtotime($empInfo[0]['doj'])) : ''),
                                                                'type'          => 'text',
                                                                'placeholder'   => 'Enter Date of Joining.',
                                                                'autocomplete'  => 'off',
                                                                'class'         => 'form-control date customize-form',
                                                                'readOnly' => 'readonly'
                                                            );
                                                            echo form_input($data);
                                                            ?>
                                                        </div>
                                                        <?= form_error('doj'); ?>
                                                        <div class="error_doj text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-6">
                                                <div class="form-group mrg-B29">
                                                    <label for="Udob" class="customize-label">Team Assigned</label>
                                                    <?php
                                                    $b[''] = 'Select Team';
                                                    foreach ($team as $key => $val) {
                                                        $b[$val->id] = $val->team_name;
                                                    }
                                                    $team_id = $b;
                                                    echo form_dropdown('team_id[]', $team_id, set_value('team_id', !empty($empInfo[0]) ? $empInfo[0]['team_id'] : ''), 'class="form-control testselect1 selectpicker", multiple="multiple", data-live-search="true", data-field-name="Team", id="team_id"');
                                                    echo form_error('team_id');
                                                    ?>
                                                    <div class="error_team_id text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6">
                                                <div class="form-group">
                                                    <label for="Udob" class="customize-label">Role Assigned</label>
                                                    <select class="form-control customize-form role_select selectpicker" data-field-name='Role Assignment' name="role_id[]" id="role_id" multiple="multiple" data-live-search="true">
                                                        <option value=""> Select Role </option>
                                                        <?php if (isset($role['0'])) { ?>
                                                            <option value="<?= !empty($role['0']->id) ? $role['0']->id : ''; ?>" selected='selected'>
                                                                <?php echo $role['0']['role_name']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <?php echo form_error('role_type'); ?>
                                                    <div class="error_role_id text-danger"></div>
                                                </div>
                                            </div>

                                            <?php if($this->session->userdata['userinfo']['is_admin'] == 2) { ?>
                                                <div class="col-lg-3 col-md-3 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="Udob" class="customize-label">Role Type</label>
                                                        <select class="form-control customize-form role_select" data-field-name='Role Assignment' name="role_type" id="role_type" disabled>
                                                            <option value="0" selected='selected'> Agent </option>                                                            
                                                        </select>
                                                        <?php echo form_error('role_id'); ?>
                                                        <div class="error_role_id text-danger"></div>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="col-lg-3 col-md-3 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="Udob" class="customize-label">Role Type</label>
                                                        <select class="form-control customize-form role_select" data-field-name='Role Assignment' name="role_type" id="role_type">
                                                            <option value=" "> Select Team Type </option>
                                                            <option value="2"> Supervisor </option>
                                                            <option value="0"> Agent </option>
                                                        </select>
                                                        <?php echo form_error('role_id'); ?>
                                                        <div class="error_role_id text-danger"></div>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            

                                            <div class="col-lg-3 col-md-3 col-sm-6" id="supervisorList" style="display: none">
                                                <div class="form-group">
                                                    <label for="Udob" class="customize-label">SuperVisor</label>
                                                    <select class="form-control customize-form role_select" data-field-name='Role Assignment' name="supervisor" id="supervisor">
                                                        <option value=""> Select SuperVisor </option>
                                                    </select>
                                                    <?php echo form_error('supervisor'); ?>
                                                    <div class="error_role_id text-danger"></div>
                                                </div>
                                            </div>

                                            <!-- <div class="col-lg-3 col-md-3 col-sm-6">
                                                <div class="box">
                                                    <div class="col-sm-10">
                                                        <select class="form-control selectpicker" id="select-country lstFruits" multiple="multiple" data-live-search="true">
                                                            <option data-tokens="china">China</option>
                                                            <option data-tokens="malayasia">Malayasia</option>
                                                            <option data-tokens="singapore">Singapore</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>  -->

                                        </div>
                                        <?php
                                        if ($loan_bank_limit == 2) { ?>
                                            <div id="showAddLimit" style="display: none;">
                                                <div class="row" id="add_field_button">
                                                    <div class="col-md-3">
                                                        <h4 class="mrg-B20">Assign Bank Limit</h4>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="button" class="add_field_button btn btn-primary">ADD LIMIT</button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php
                                        $data = array(
                                            'name' => 'id',
                                            'id' => 'id',
                                            'value' => set_value('id', !empty($empInfo[0]) ? $empInfo[0]['id'] : ''),
                                            'type' => 'hidden'
                                        );
                                        echo form_input($data);
                                        ?>
                                        <?php if (!empty($adminDealer[0]['loan_bank_limit']) && ($adminDealer[0]['loan_bank_limit'] == '2')) { ?>
                                            <div class="row">
                                                <div class="input_fields_wrap">
                                                    <?php
                                                    $bankIdsE = '';
                                                    $limitsE = '';
                                                    $sum = 0;
                                                    if (!empty($empInfo[0]['bank'])) {
                                                        $i = 0;
                                                        foreach ($empInfo[0]['bank'] as $ke => $va) {
                                                            $bankIdsE .= $va['bank_id'] . ',';
                                                            $limitsE  .= $va['emp_limit'] . ',';
                                                            $i++;
                                                    ?>
                                                            <div class="col-md-12 bank_limit_div">
                                                                <div class="row">
                                                                    <div class="col-lg-3 col-md-3 addlist">
                                                                        <label for="Udob" class="customize-label">Bank Name*</label>
                                                                        <select name="bank[]" data-field-name="Bank Name" class="form-control customize-form bank testselect1" id="bank_<?= $i ?>" onchange="bankLi(this,'',1)">
                                                                            <option value="">Select Bank</option>
                                                                            <?php foreach ($banksname as $bkey => $bval) {
                                                                                $bankName  = $this->Crm_banks_List->crmBankName($bval->bank_id);
                                                                                if (!empty($bankName[0]->bank_name)) {
                                                                            ?>
                                                                                    <option value="<?= $bval->bank_id ?>" <?php if (!empty($bankName[0]) && $va['bank_id'] == $bankName[0]->id) {
                                                                                                                                echo 'selected';
                                                                                                                            } ?>><?= $bankName[0]->bank_name ?></option>
                                                                            <?php }
                                                                            } ?>
                                                                        </select>
                                                                    </div>
                                                                    <?php $CI = &get_instance();
                                                                    $va['emp_limit'] = $CI->IND_money_format($va['emp_limit']);
                                                                    ?>
                                                                    <div class="col-lg-3 col-md-3  addlist">
                                                                        <label for="Dname" class="customize-label">Assign Limit*</label>
                                                                        <input type="text" data-field-name="Assign Limit" id="limitid_<?= $i ?>" name=limit[] onkeypress="return isNumberKey(event)" class="form-control customize-form limitset rupee-icon" style="margin-top:5px; " autocomplete="off" value="<?= $va['emp_limit'] ?>" onkeyup="addCommasinnum(this.value, 'limitid_'+<?= $i ?>);" onchange="limitSet(this,<?= $i ?>)" />
                                                                        <div class="text-danger e" id="error_<?= $i ?>"></div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 mrg-T30" id="showAddLimit"><button type="button" class=" btn btn-default remove_field" id="remove_<?= $i ?>">Remove</button></div>
                                                                </div>
                                                            </div>

                                                        <?php
                                                            $sum = str_replace(',', '', $va['emp_limit']) + $sum;
                                                        }
                                                        ?>
                                                    <?php } ?>

                                                </div>
                                                <input type="hidden" value="<?= !empty($i) ? $i : '' ?>" name="bankidcount" id="bankidcount">
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3  showtotalLimit" style="margin-top:32px !important;display: none;">
                                            <label for="Dname" class="customize-label">Total Limit</label>
                                            <input type="text" id="max_bank_limit" name="max_bank_limit" value="<?php if ($sum != '') {
                                                                                                                    echo $sum;
                                                                                                                } ?>" class="form-control customize-form rupee-icon" placeholder="Total Limit" disabled="disabled">
                                            <input type="hidden" id="bank_limit_max" name="bank_limit_max" value="" class="form-control customize-form">
                                        </div>
                                    </div>
                                <?php } ?>
                                <input type="hidden" name="loanlimitadmin" id="loanlimitadmin" value="<?= !empty($adminDealer[0]['loan_bank_limit']) ? $adminDealer[0]['loan_bank_limit'] : '' ?>">
                                <input name="banks" value="<?= !empty($bankIdsE) ? $bankIdsE : '' ?>" type="hidden">
                                <input name="limits" value="<?= !empty($limitsE) ? $limitsE : '' ?>" type="hidden">
                                <div class="container-fluid mrg-all-20 pad-all-0 mrg8">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 bsi-sec">
                                            <div class="background-color">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 footer-button-edit">
                                                        <div class="sava-and-continue-button text-center">
                                                            <input type="hidden" name="bank_count" id="bank_count" value="<?= ($bank_count == '') ? '' : $bank_count ?>">
                                                            <input type="hidden" name="totalbnk" id="totalbnk" value="<?= (!empty($empInfo) ? count($empInfo[0]['bank']) : '') ?>">
                                                            <input type="hidden" name="status" value="<?= !empty($empInfo[0]) ? $empInfo[0]['status'] : '' ?>">
                                                            <?php echo form_button(['name' => 'submit', 'content' => 'Save', 'class' => 'btn-save-editable submit_emp source btn btn-lg primaryBtn']); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close();  ?>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/sumoselect.css">
    <script src="<?= base_url() ?>assets/js/sumoselect.js"></script>
    <script src="<?= base_url() ?>assets/js/employee.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js" type="text/javascript"></script>

    <script>
        $(function() {
            $('#team_id').multiselect({
                includeSelectAllOption: true
            });

            $('#role_id').multiselect({
                includeSelectAllOption: true
            });

        });
    </script>

    <script type="text/javascript">
        $('.testselect1').SumoSelect({
            triggerChangeCombined: true,
            search: true,
            searchText: 'Search here.'
        });
        $('#role_id').SumoSelect({
            triggerChangeCombined: true,
            search: true,
            searchText: 'Search here.'
        });
        $('#total_cases').text('(' + "<?= $total_count ?>" + ')');
        var loanlimitadmin = $("#loanlimitadmin").val();
        var teamID = $("#team_id").val();
        var role_id = "<?= $empInfo[0]['role_id'] ?>";
        if (teamID == 3 && loanlimitadmin == 2) {
            $('#showAddLimit').attr('style', 'margin-top:30px !important;');
            $('#showAddLimit').attr('style', 'margin-bottom:20px !important');
            $('.showtotalLimit').attr('style', 'margin-top:32px !important');
        }
        $('.loaderClas').attr('style', 'display:none;');

        $('#supervisorList').hide();

        if ($.trim($('#role_type').val()) === ' ') {
            $('#supervisorList').hide();
            $('#supervisor').html('');
        }

        $("#role_type").change(function() {
            var selectBoxValue = this.value;
            // console.log(selectBoxValue);
            // return false;
            // var firstDropVal = $('#role_type').val();

            if (selectBoxValue == 0) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "User/getSuperVisor",
                    dataType: 'html',
                    data: {
                        role_type: 2
                    },
                    success: function(data) {
                        $('#supervisorList').show();
                        $('#supervisor').html(data);
                    }
                });
                return false;
            } else {
                $('#supervisorList').hide();
                $('#supervisor').html('');
            }
        });
    </script>

    <?php $currentdate = date('Y/m/d'); ?>