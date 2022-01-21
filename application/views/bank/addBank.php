<link href="<?= base_url('/assets/css/dealer.css') ?>" rel="stylesheet">
<div id="content">
<div class="tab-pane active" id="tab1">
<div class="container-fluid">
        <div class="row background-color box-S">
            <div class="col-lg-12 col-md-12 bsd-sec">
                <h4 class="basic-detail-heading mrg-all-0"><?php if($bankid!=''){?> Update <?php }else{ ?>Add <?php } ?>Bank</h4>
            </div>
        </div>
    </div> 
    <style>
        .select2-container { margin-bottom: 0px !important;}
        .error{top: 70px}
    </style>

   <div class="container-fluid mrg-all-20 pad-all-0 mrg8">
        <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
            </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 bsi-sec">
                <div class="error-box">
                </div>
                <span class="error-message"></span>
                <div class="background-color">
                    <div class="row">
                        <div class="success-box padLR23 clearfix">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="padLR23 clearfix border-B">
                                <h4 class="section-heading">Basic Information</h4>

                            </div>
                        </div>
                    </div>
                    <style type="text/css">
                        .select2-container{width: 100% !important}
                    </style>
                    <?php $this->load->helper("form"); ?>
                    <?php if($bankid!=''){?>
                    <form role="form" id="updateBank" name="updateBank"  action="<?php echo base_url() . 'bank/updateBank/'; ?>"  method="post">
                    <?php }else{?>
                    <form role="form" id="addBank" name="addBank"  action="<?php echo base_url() . 'addNewBank/'; ?>"  method="post">
                    <?php } ?>
                        <div class="pad-all-20 clearfix">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="Dname" class="mrg-B10">Bank Name*</label>
                                        <input type="text"   name="bank_name" id="bank_name" value="<?= set_value('bank_name', !empty($bank[0]) ? $bank[0]['bank_name'] : '') ?>" class="form-control customize-form nameCaseLoan" placeholder="Enter Bank Name" autocomplete="off">
                                        <!--<select  name="bank_name" id="bank_name" class="form-control customize-form" style="width: 100% !important">
                                            <option value="">Select Bank</option>
                                            <?php foreach ($banks as $bank) { ?>
                                                <option value="<?= $bank->id ?>" ><?= $bank->bank_name ?></option>
                                            <?php } ?>
                                        </select>-->
                                        <div class="error" id="name_error" ></div>
                                        <?php echo form_error('bank_name'); ?>

                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="Demail" class="customize-label">Address</label>
                                        <input type="text"   name="address" id="address" value="<?= set_value('address', !empty($bankInfo[0]) ? $bankInfo[0]['address'] : '') ?>" class="form-control customize-form nameCaseLoan" placeholder="Enter Address"  autocomplete="off">
                                        <div class="error" id="address_error" ></div>
                                         <?php echo form_error('address'); ?>
                                    </div>
                                </div>
                            
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="Dname" class="customize-label">Branch*</label>
                                        <input type="text"   name="branch" id="branch" value="<?= set_value('branch', !empty($bankInfo[0]) ? $bankInfo[0]['branch_name'] : '') ?>" class="form-control customize-form nameCaseLoan" placeholder="Enter Branch" autocomplete="off">
                                        <div class="error" id="Branch_error" ></div>
                                        <?php echo form_error('branch'); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="Demail" class="customize-label">Pincode</label>
                                        <input type="text" onkeypress="return isNumberKey(event)" maxlength="6"  name="pincode" id="pincode" value="<?= set_value('pincode', !empty($bankInfo[0]) ? $bankInfo[0]['pin_code'] : '') ?>" class="form-control customize-form" placeholder="Enter pincode"  autocomplete="off">
                                        <div class="error" id="pincode_error"></div>
                                        <?php echo form_error('pincode'); ?>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="Demail" class="customize-label">State*</label>
                                        <select name="state" id="state" class="form-control customize-form cstate" >
                                            <option value="">Select State*</option>
                                            <?php foreach ($stateList as $state) { ?>
                                                <option value="<?= $state->state_id ?>" <?php if($bankInfo[0]['state'] == $state->state_id) {echo "selected=selected";} ?>><?= $state->state_name ?></option>
                                            <?php } ?>
                                        </select>
                                     <div class="error" id="state_error" ></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="Dname" class="customize-label">City*</label>
                                        <select name="city" id="city" class=" form-control customize-form scity" >
                                            <option value="">Select City*</option>
                                            <?php foreach ($cityList as $city) { ?>
                                                    <option value="<?php echo $city['city_id']; ?>" <?php if ($city['city_id'] == $bankInfo[0]['city']) {
                                                    echo "selected=selected";
                                                } ?>><?php echo $city['city_name'] ?>
                                                    </option>
                                            <?php } ?>
                                        </select>
                                        <div class="error" id="city_error" ></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class=" clearfix">
                                        <h4 class="section-heading mrg-all-0">Other Details</h4>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="Dname" class="customize-label">MICR Code</label>
                                        <input type="text" onkeypress="return isNumberKey(event)"  name="micr_code" id="micr_code" value="<?= set_value('micr_code', !empty($bankInfo[0]) ? $bankInfo[0]['micr_code'] : '') ?>" class="form-control customize-form" placeholder="Enter MICR code"  autocomplete="off" maxlength="11">
                                        <div class="error" id="micr_error" ></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="Demail" class="customize-label">IFSC Code</label>
                                        <input type="text"   name="ifsc_code" id="ifsc_code" value="<?= set_value('ifsc_code', !empty($bankInfo[0]) ? $bankInfo[0]['ifsc_code'] : '') ?>" class="form-control customize-form upperCaseLoan" maxlength="11" placeholder="Enter IFSC Code"  autocomplete="off" onkeypress="return blockSpecialChar(event)">
                                        <div class="error" id="ifsc_error" ></div>
                                    </div>
                                </div>
                            
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="Dname" class="customize-label">Loan Limit*</label>
                                        <input type="text" onkeypress="return isNumberKey(event)"   name="amount_limit" id="amount_limit" value="<?= set_value('amount_limit', !empty($bankInfo[0]) ? $bankInfo[0]['amount_limit'] : '') ?>" onkeyup="addCommasBank(this.value, 'amount_limit');validate_amount_limit(this.value)"  class="form-control customize-form rupee-icon" placeholder="Enter Loan Limit" maxlength='12' autocomplete="off" >
                                        <div class="error" id="limit_error"></div>
                                        <?php echo form_error('amount_limit'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid mrg-all-20 pad-all-0 mrg8">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 bsi-sec">
                                                <div class="background-color">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 footer-button-edit">
                                                            <div class="sava-and-continue-button text-center">
                                                                <input  style="text-align: center" type="submit" class="btn btn-lg btn-save-editable" name="submit" id="submit" value="Save" onclick="return checkBank(this);">
                                                                <input type="hidden" name="updateId" id="updateId" value="<?=$bankInfo[0]['id']?>">
                                                                <input type="hidden" name="definedLimit" id="definedLimit" value="<?=(!empty($bankInfo[0]) ? $bankInfo[0]['amount_limit'] : 0) ?>">
                                                                <input type="hidden" name="bank_id" id="bank_id" value="<?=(!empty($bankInfo[0]) ? $bankInfo[0]['bank_id'] : 0) ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
        </div>
    </div>
 <style type="text/css">
           .loaderoverlay{position: fixed;left: 0;right: 0;top: 0;bottom: 0; background: rgba(0,0,0,0.5); z-index: 999;}
           .loaderClas{position: fixed; left:0; top: 0;right: 0; bottom: 0; margin:auto;z-index: 9999;}
</style>
     <div class="loaderClas" style="display:none;"><img class="resultloader" src="<?php echo base_url()?>/assets/images/loading.gif" style="position: absolute;left: 0;right: 0;text-align: center;top: 0;bottom: 0;margin: auto;z-index: 9999;"></div>
      <div class="loaderoverlay loaderClas"></div>
    <script src="<?php echo base_url(); ?>assets/js/jQuery.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/bank.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_assets/css/sumoselect.min.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery.sumoselect.min.js"></script>
    <script>
          $('.loaderClas').attr('style','display:none;');
         function validate_amount_limit(amount_limits){
           //alert('hii');
        var amount_limit = amount_limits.replace(/,/g,'');

        var updateId = $('#updateId').val();
        if(updateId != "" && updateId != undefined){
        var bankId = $('#bank_id').val();
        var definedLimit = $('#definedLimit').val();       
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>"+"bank/ajax_validate_limit",
            data: {limit: amount_limit,definedLimit:definedLimit, updateId: updateId,bankId:bankId},
            success: function (response) {
                var data = $.parseJSON(response);
                if (data.status == 'false') {
                     $('#limit_error').text('');
                    $('#limit_error').text(data.msg);
                    limit = false;
                    return false;
                } else {
                    limit = true;
                    return true;
                }
            }
        });
        }
}
        </script>
        