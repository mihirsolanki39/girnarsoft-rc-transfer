<link href="<?= base_url('/assets/css/dealer.css') ?>" rel="stylesheet">
<div class="tab-pane active" id="tab1">
<div class="container-fluid">
        <div class="row background-color box-S">
            <div class="col-lg-12 col-md-12 bsd-sec">
                <h4 class="basic-detail-heading mrg-all-0">Edit Bank</h4>
            </div>
        </div>
    </div> 
<?php //echo '<pre>';print_r($bankInfo[0]);die;?>
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
                            <div class="padLR23 clearfix">
                                <h4 class="section-heading mrg-all-0">Basic Information</h4>
                            </div>
                        </div>
                    </div>
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="updateBank" name="updateBank"  action="<?php echo base_url() . 'bank/updateBank/'; ?>"  method="post">
                        <div class="padLR23 clearfix">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group mrg-B29">
                                        <label for="Dname" class="customize-label">Bank Name*</label>
                                        <!--<input type="text"   name="bank_name" id="bank_name" value="<?= set_value('bank_name', !empty($bankInfo[0]) ? $bankInfo[0]->bank_name : '') ?>" class="form-control customize-form" placeholder="Enter Bank Name" autocomplete="off">-->
                                       <select  name="bank_name" id="bank_name" class=" form-control customize-form" >
                                            <option value="">Select Bank</option>
                                            <?php foreach ($bankName as $bank) { ?>
                                            <option value="<?= $bank->id ?>" <?php if(!empty($bankInfo[0]) &&  $bank->id == $bankInfo[0]['bank_id']) {echo "selected=selected";} ?>><?= $bank->bank_name ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="error" id="name_error" ></div>
                                        <?php echo form_error('bank_name'); ?>

                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group mrg-B29">
                                        <label for="Demail" class="customize-label">Address</label>
                                        <input type="text"  value="<?= set_value('address', !empty($bankInfo[0]) ? $bankInfo[0]['address'] : '') ?>" name="address" id="address" class="form-control nameCaseLoan customize-form" placeholder="Enter Address"  autocomplete="off">
                                        <div class="error" id="address_error" ></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group mrg-B29">
                                        <label for="Dname" class="customize-label">Branch*</label>
                                        <input type="text" value="<?= set_value('branch', !empty($bankInfo[0]) ? $bankInfo[0]['branch_name'] : '') ?>"   name="branch" id="branch" class="form-control nameCaseLoan customize-form" placeholder="Enter Branch" autocomplete="off">
                                        <div class="error" id="Branch_error" ></div>
                                        <?php echo form_error('branch'); ?>

                                    </div>
                                </div>
                                <input type="hidden" name="updateId" id="updateId" value="<?=$bankInfo[0]['id']?>">
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group mrg-B29">
                                        <label for="Demail" class="customize-label">Pincode</label>
                                        <input type="text" onkeypress="return isNumberKey(event)" value="<?= set_value('pincode', !empty($bankInfo[0]) ? $bankInfo[0]['pin_code'] : '') ?>" maxlength="6"   name="pincode" id="pincode" class="form-control customize-form" placeholder="Enter pincode"  autocomplete="off">
                                        <div class="error" id="pincode_error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group mrg-B29">
                                        <label for="Demail" class="customize-label">State*</label>
                                        <select name="state" id="state" class=" form-control customize-form cstate" >
                                            <option value="">Select State*</option>
                                            <?php foreach ($stateList as $state) { ?>
                                                <option value="<?= $state->state_id ?>" <?php if($bankInfo[0]['state'] == $state->state_id) {echo "selected=selected";} ?>><?= $state->state_name ?></option>
                                            <?php } ?>
                                        </select>
                                    <div class="error" id="state_error" ></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group mrg-B29">
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
                                    <div class="form-group mrg-B29">
                                        <label for="Dname" class="customize-label">MICR Code*</label>
                                        <input type="text" value="<?= set_value('micr_code', !empty($bankInfo[0]) ? $bankInfo[0]['micr_code'] : '') ?>" onkeypress="return isNumberKey(event)"  name="micr_code" id="micr_code" class="form-control customize-form" placeholder="Enter MICR code"  autocomplete="off">
                                        <div class="error" id="micr_error" ></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group mrg-B29">
                                        <label for="Demail" class="customize-label">IFSC Code*</label>
                                        <input type="text" value="<?= set_value('ifsc_code', !empty($bankInfo[0]) ? $bankInfo[0]['ifsc_code'] : '') ?>"  name="ifsc_code" id="ifsc_code" class="form-control upperCaseLoan customize-form" placeholder="Enter IFSC Code"  autocomplete="off" onkeypress="return blockSpecialChar(event)" maxlength="11">
                                        
                                    </div>
                                    <div class="error" id="ifsc_error" ></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group mrg-B29">
                                        <label for="Dname" class="customize-label">Loan Limit*</label>
                                        <input type="text" value="<?= set_value('amount_limit', !empty($bankInfo[0]) ? $bankInfo[0]['amount_limit'] : '') ?>" onkeypress="return isNumberKey(event)"    name="amount_limit" id="amount_limit" onkeyup="addCommasBank(this.value, 'amount_limit');" class="form-control customize-form rupee-icon" placeholder="Enter Loan Limit"  autocomplete="off">
                                        <div class="error" id="limit_error"></div>
                                        <input type="hidden" name="definedLimit" id="definedLimit" value="<?= !empty($bankInfo[0]['amount_limit']) ? $bankInfo[0]['amount_limit'] :'' ?>">
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
    <script src="<?php echo base_url(); ?>assets/js/jQuery.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/bank.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_assets/css/sumoselect.min.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery.sumoselect.min.js"></script>