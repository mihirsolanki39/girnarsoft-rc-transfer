<link href="<?= base_url('/assets/css/dealer.css') ?>" rel="stylesheet">
<!--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->
<style>
   .saleex .btn-default {color: #444!important; background-color: #fff!important; border-color: #ddd!important; outline: none !important;  text-transform: uppercase!important;}
    .saleex .dropdown-toggle:hover { border-bottom: 1px solid #ddd !important;}
    .saleex .btn-default:hover { color: #444!important; background-color: #fff !important; border-color: #ddd !important;}
    </style>

<div id="content">
<div class="tab-pane active" id="tab1">
    <div class="container-fluid">
        <div class="row background-color box-S">
            <div class="col-lg-12 col-md-12 bsd-sec">
                <h4 class="basic-detail-heading mrg-all-0"><?= !empty($dealerInfo[0]->id)? 'Edit Partner Dealer':'Add Partner Dealer' ?></h4>
            </div>
        </div>
    </div> 

    <div class="container-fluid mrg-all-20 pad-all-0 mrg8">
        <div class="col-md-4">
            <?php
            $service = !empty($dealerInfo) ? explode(',', $dealerInfo[0]->services) : [];
            $this->load->helper('form');
            $error = $this->session->flashdata('error');
            if ($error) {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
            <?php } ?>
            <?php
            $add = $this->session->flashdata('add');
            $update = $this->session->flashdata('update');
            //echo '<pre>';print_r($this->session->flashdata);die;
            if ($add) {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('add'); ?>
                </div>
            <?php } ?>
            <?php if ($update) {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('update'); ?>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 bsi-sec">
                <div class="error-box">
                </div>
                <span class="error-message"></span>
                <div class="background-color">
                    <div class="row mrg-B20">
                        <div class="success-box padLR23 clearfix">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="padLR23 clearfix border-B">
                                <h4 class="section-heading mrg-all-0">Basic Information</h4>
                            </div>
                        </div>
                    </div>
                    <?php $this->load->helper("form"); ?>
                    <!--<form role="form" id="addDealer" action="<?php echo base_url() ?>addDealer" method="post">-->
                    <?php if (empty($dealerInfo)) { ?>
                        <form role="form" id="addDealer" name="addDealer"  action="<?php echo base_url() ?>saveDealer"  method="post">
                        <?php } else { ?>
                            <form role="form" id="addDealer" name="addDealer"  action="<?php echo base_url() . 'saveDealer/' . $dealerInfo[0]->id; ?>"  method="post">
                            <?php } ?>
                             <a id="gototop"></a> 
                            <div class="padLR23 clearfix">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="form-group">
                                            <label for="Dname" class="customize-label">Dealership Name*</label>
                                            <input type="text" maxlength="100"  value="<?= set_value('organization', !empty($dealerInfo[0]) ? $dealerInfo[0]->organization : '') ?>" name="organization" id="organization" class="form-control customize-form" onkeypress="return alpha1only(event);" placeholder="Enter Dealership Name" autocomplete="off">
                                            <input type="hidden" value="<?= isset($dealerInfo[0]->id) ? $dealerInfo[0]->id : ''; ?>" name="updateId" id="updateId" />
                                            <div class="error" id="name_error" ></div>
                                            <?php echo form_error('organization'); ?>

                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="form-group">
                                            <label for="Demail" class="customize-label">Dealership Email*</label>
                                            <input type="email"  value="<?= set_value('dealership_email', !empty($dealerInfo[0]) ? $dealerInfo[0]->dealership_email : '') ?>" name="dealership_email" id="dealership_email" class="form-control customize-form" placeholder="Enter Dealership Email"  autocomplete="off">
                                            <div class="error" id="email_error" ></div>
                                            <?php echo form_error('dealership_email'); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="form-group">
                                            <label for="Dcontact" class="customize-label">Dealership Contact No.*</label>
                                            <input onkeypress="return isNumberKey(event)" type="tel" maxlength="10" value="<?= set_value('dealership_contact_number', !empty($dealerInfo[0]) ? $dealerInfo[0]->dealership_contact : '') ?>" name="dealership_contact_number" id="dealership_contact_number" class="form-control customize-form" placeholder="Enter Dealership Contact No."  autocomplete="off">
                                            <div class="error" id="phone_error" ></div>
                                            <?php echo form_error('dealership_contact_number'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <label for="Demail" class="customize-label">Dealer Type*</label>
                                                 <select name="dealer_type" id="dealer_type" class=" form-control customize-form dealer_type" >
                                                <option value="1" <?php if (!empty($dealerInfo[0]) && 1 == $dealerInfo[0]->dealer_type) { echo "selected=selected"; } ?>>New</option>
                                                <option value="0" <?php if (!empty($dealerInfo[0]) && 0 == $dealerInfo[0]->dealer_type) { echo "selected=selected"; } ?>>Used</option>
                                                 <option value="2" <?php if (!empty($dealerInfo[0]) && 2 == $dealerInfo[0]->dealer_type) { echo "selected=selected"; } ?>>Both</option>
                                                 </select>
                                                <div class="error" id="account_type_error" ></div>
                                            <?php echo form_error('account_type'); ?>
                                            </div>
                                        </div>
                                </div>
                                <div class="row">

                                    <div class="col-lg-3 col-md-3 col-sm-6 saleex">

                                        <div class="form-group">
                                            <label for="Demail" class="customize-label">Services*</label>
                                            <select name="services[]" style="" id="services" class=" form-control customize-form" multiple="multiple">
                                                <?php foreach ($services as $key => $value) { ?>
                                                <option value="<?= $key ?>"<?php echo in_array($key, $service) ? 'selected=selected' : ''; ?> ><?= ucwords(str_replace('_', ' ', $value)) ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="error" id="services_error" ></div>
                                            <?php echo form_error('services'); ?>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class=" clearfix">
                                            <a id="outlettop"></a> 
                                            <h4 class="section-heading mrg-all-0">Outlet Details</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="form-group">
                                            <label for="Dname" class="customize-label">Outlet Address*</label>
                                            <input type="text"  value="<?= set_value('outlet_address', !empty($dealerInfo[0]) ? $dealerInfo[0]->user_address : '') ?>" name="outlet_address" id="outlet_address" class="form-control customize-form" placeholder="Enter Outlet address" autocomplete="off">
                                            <div class="error" id="outlet_address_error" ></div>
                                            <?php echo form_error('outlet_address'); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="form-group">
                                            <label for="Demail" class="customize-label">State*</label>
                                            <select name="state" id="state" class=" form-control customize-form dstate" >
                                                <option value="">Select State</option>
                                                <?php foreach ($stateList as $state) { ?>
                                                    <?php if (isset($dealerInfo)) { ?>
                                                        <option value="<?= $state->state_id ?>" <?php if ($state->state_id == $dealerInfo[0]->state) {
                                                    echo "selected=selected";
                                                } ?>><?= $state->state_name ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?= $state->state_id ?>" ><?= $state->state_name ?></option>
                                                <?php }
                                            } ?>
                                            </select>
                                            <div class="error" id="state_error" ></div>
                                                <?php echo form_error('state'); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="form-group">
                                            <label for="Dname" class="customize-label">City*</label>
                                            <select name="city" id="city" class=" form-control customize-form dcity" >
                                                <option value="">Select City</option>
                                                <?php foreach ($cityList as $city) { ?>
                                                    <option value="<?php echo $city['city_id']; ?>" <?php if ($city['city_id'] == $dealerInfo[0]->city) {
                                                    echo "selected=selected";
                                                } ?>><?php echo $city['city_name'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <div class="error" id="city_error" ></div>
                                        <?php echo form_error('city'); ?>
                                        </div>
                                    </div>
                                </div>


                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class=" clearfix">
                                                <h4 class="section-heading mrg-all-0">Owner Information</h4>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <label for="Dcontact" class="customize-label">Owner Name*</label>
                                                <input type="text"   value="<?= set_value('owner_name', !empty($dealerInfo[0]) ? $dealerInfo[0]->owner_name : '') ?>" name="owner_name" id="owner_name" class="form-control customize-form" placeholder="Enter Owner name" autocomplete="off">
                                                <div class="error" id="owner_name_error" ></div>
                                        <?php echo form_error('owner_name'); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <label for="Dcontact" class="customize-label">Contact No.*</label>
                                                <input onkeypress="return isNumberKey(event)" type="tel" maxlength="10" value="<?= set_value('owner_contact_number', !empty($dealerInfo[0]) ? $dealerInfo[0]->owner_mobile : '') ?>" name="owner_contact_number" id="owner_contact_number" class="form-control customize-form" placeholder="Enter Owner Contact No."  autocomplete="off">
                                                <div class="error" id="owner_mobile_error" ></div>
                                    <?php echo form_error('owner_contact_number'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="saleex">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class=" clearfix">
                                            <a id="salestop"></a> 
                                                <h4 class="section-heading mrg-all-0">Assigned Sales Executive</h4>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <label for="Dcontact" class="customize-label">Assigned Sales Executive*</label>
                                                <select name="assignUser" id="assignUser" class=" form-control customize-form" >
                                                    <option value="">Assigned Sales Executive</option>
                                                    <?php foreach ($userList as $user) { ?>
                                                  <?php if (!empty($dealerInfo)) { ?>
                                                            <option value="<?php echo $user['id']; ?>"  <?php if ($user['id'] == $dealerInfo[0]->user_id) {
                                                        echo "selected=selected";
                                                    } ?>><?php echo $user['name'] ?></option>
                                                <?php } else { ?>
                                                            <option value="<?php echo $user['id']; ?>" ><?php echo $user['name'] ?></option>
                                                        <?php } } ?>
                                                </select>
                                                <div class="error" id="assign_error" ></div>
                                            </div>
                                        </div>

                                    </div>



                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class=" clearfix">
                                             <a id="paymenttop"></a> 
                                                <h4 class="section-heading mrg-all-0">Payments</h4>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <label for="Dname" class="customize-label">Payment Favoring</label>
                                                <input type="text"  value="<?= set_value('payment_favoring', !empty($dealerInfo[0]) ? $dealerInfo[0]->payment_favoring : '') ?>" name="payment_favoring" id="payment_favoring" class="form-control customize-form" onkeypress="return blockSpecialChar(event);" placeholder="Enter Payment favoring"  autocomplete="off">
                                                <div class="error" id="payment_favoring_error" ></div>
                                                <?php echo form_error('payment_favoring'); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <label for="Demail" class="customize-label">GST No</label>
                                                <input type="text"  value="<?= set_value('gst_number', !empty($dealerInfo[0]) ? $dealerInfo[0]->gst_number : '') ?>" name="gst_number" id="gst_number" class="form-control customize-form" placeholder="Enter GST No" onkeypress="return blockSpecialChar(event);"   autocomplete="off" maxlength="15">
                                                <div class="error" id="gst_number_error" ></div>
                                            <?php echo form_error('gst_number'); ?>
                                            </div>
                                        </div>


                                    </div>
                                     <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class=" clearfix">
                                                <h4 class="section-heading mrg-all-0">Bank Info</h4>
                                            </div>
                                        </div>
                                         <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <label for="Demail" class="customize-label">Banks</label>
                                                <?php  //echo "<pre>";print_r($bankName); ?>
                                                <select  name="dealer_banks" id="dealer_banks" class=" form-control customize-form dbank" >
                                                    <option value="">Select Bank</option>
                                                    <?php foreach ($bankName as $bank) { ?>
                                                    <option value="<?= $bank['bank_id'] ?>" <?php if(!empty($dealerInfo[0]) &&  $bank['bank_id'] == $dealerInfo[0]->dealer_banks) {echo "selected=selected";} ?>><?= $bank['bank_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div class="error" id="dealer_banks_error" ></div>
                                            <?php echo form_error('dealer_banks'); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <label for="Dname" class="customize-label">Account Number</label>
                                                <input type="text"  value="<?= set_value('account_number', !empty($dealerInfo[0]) ? $dealerInfo[0]->account_number : '') ?>" name="account_number" id="account_number" class="form-control customize-form" placeholder="Enter Account Number"  autocomplete="off" maxlength="16">
                                                <div class="error" id="account_number_error" ></div>
                                                <?php echo form_error('account_number'); ?>
                                            </div>
                                        </div>

                                         <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <label for="Demail" class="customize-label">Ifsc Code</label>
                                                <input type="text"  value="<?= set_value('ifsc_code', !empty($dealerInfo[0]) ? $dealerInfo[0]->ifsc_code : '') ?>" name="ifsc_code" id="ifsc_code" class="form-control customize-form" placeholder="eg. SBIN0015916" onkeypress="return blockSpecialChar(event);" autocomplete="off" maxlength="11">
                                                <div class="error" id="ifsc_code_error" ></div>
                                            <?php echo form_error('ifsc_code'); ?>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-6">
                                                <div class="form-group">
                                                    <label for="Demail" class="customize-label">Account Type</label>
                                                     <select name="account_type" id="account_type" class=" form-control customize-form" >
                                                    <option value="1" <?php if (!empty($dealerInfo[0]) && 1 == $dealerInfo[0]->account_type) { echo "selected=selected"; } ?>>Savings</option>
                                                    <option value="0" <?php if (!empty($dealerInfo[0]) && 0 == $dealerInfo[0]->account_type) { echo "selected=selected"; } ?>>Current</option>
                                                     </select>
                                                    <div class="error" id="account_type_error" ></div>
                                                <?php echo form_error('account_type'); ?>
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
                                                                <input  style="text-align: center" type="submit" class="btn btn-lg btn-save-editable" name="submit" id="submit" value="<?= (!empty($dealerInfo[0])) ? 'Update' : 'Save' ?>" onclick="return checkDealer(this);">
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
</div>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_assets/css/sumoselect.min.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery.sumoselect.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jQuery.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>
   <script>
       
     $("#addDealer").submit(function(){
         $("#submit").attr("disabled",true);  
     });
    $(document).ready(function()
    {
       $('#services').SumoSelect({ search: false,  searchText:'Enter here.' });

        var dealer_type = $('#dealer_type').val();
        if(dealer_type=='1')
        {
            $('.saleex').attr('style','display:none;');
        }
        else
        {
            $('.saleex').attr('style','display:block;');
        }
        
       $('.dbank').SumoSelect({ csvDispCount: 3, search: true,  searchText:'Enter here.' }); 
       $('.dbank')[0].sumo.reload();
       $('.dstate').SumoSelect({ search: true,  searchText:'Enter here.',triggerChangeCombined:true });
       $('#assignUser').SumoSelect({ search: true,  searchText:'Enter here.',triggerChangeCombined:true });
       //$('.dstate')[0].sumo.reload();
       $('#state').on('change', function () {
            var selected = $(this).val();
            $.ajax({
                type: 'POST',
                url: base_url+"Dealer/getcities",
                data: {stateId: selected},
                dataType: "html",
                success: function (responseData)
                {
                    //$('#city').html('');
                    $('#city').html(responseData);
                    $('#city')[0].sumo.reload();

                }
            });
        });
       $('.dcity').SumoSelect({ csvDispCount: 3, search: true,  searchText:'Enter here.' });
       $('.dcity')[0].sumo.reload();
       $('.dealer_type').SumoSelect({});
       $('#account_type').SumoSelect({});
       $("#dealer_type").change(function(){
            var dealer_type = $('#dealer_type').val();
            if(dealer_type=='1')
            {
                $('.saleex').attr('style','display:none;');
                //$('#services').val('2');
            }
            else
            {
                $('.saleex').attr('style','display:block;');
            }
        }); 
    });
    </script>

