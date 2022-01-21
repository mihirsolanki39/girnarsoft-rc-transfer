<div id="content">   
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 pad-LR-10 mrg-B40">
                <h2 class="page-title">Refurb Workshop</h2>
                <form  enctype="multipart/form-data" method="post"  id="refurb_work" name="refurb_work">
                    <div id="rc_details" class="white-section">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="sub-title mrg-T0">Workshop Details</h2>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="crm-label">Name</label>
                                    <input  type="text" class="form-control crm-form" value="<?= !empty($getBookingDetail['name'])?$getBookingDetail['name']:''?>" placeholder="Name" id="name" name="name" autocomplete="off" onkeypress="return nameOnly(event)">
                                     <div class="error" id="err_name"></div>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="crm-label">Mobile</label>
                                    <input onkeypress="return isNumberKey(event)" maxlength="10"  type="text" class="form-control crm-form" value="<?= !empty($getBookingDetail['mobile'])?$getBookingDetail['mobile']:''?>" placeholder="Mobile" id="mobile" name="mobile" autocomplete="off">
                                     <div class="error" id="err_mobile"></div>
                                </div>
                            </div>
                           <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="crm-label">Address</label>
                                    <input onkeypress="return blockSpecialChar(event)" type="text" class="form-control crm-form" value="<?= !empty($getBookingDetail['address'])?$getBookingDetail['address']:''?>" placeholder="Address" id="address" name="address" autocomplete="off">
                                     <div class="error" id="err_address"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="crm-label">Services</label>
                                    <select class="form-control crm-form" id="service" name="service">
                                    <option value="">Select Services</option>
                                        <option value="1" <?=  (!empty($getBookingDetail['services']) && $getBookingDetail['services']=='1'?'selected=selected':'')?>>Denting</option>
                                        <option value="2" <?=  (!empty($getBookingDetail['services']) && $getBookingDetail['services']=='2'?'selected=selected':'')?>>Painting</option>
                                        <option value="3" <?=  (!empty($getBookingDetail['services']) && $getBookingDetail['services']=='3'?'selected=selected':'')?>>Washing</option>
                                        <option value="4" <?=  (!empty($getBookingDetail['services']) && $getBookingDetail['services']=='4'?'selected=selected':'')?>>Engine Repair</option>
                                        <option value="5" <?=  (!empty($getBookingDetail['services']) && $getBookingDetail['services']=='5'?'selected=selected':'')?>>AC Repair</option>
                                    </select>
                                    <div class="d-arrow"></div>
                                    <div class="error" id="err_service"></div>
                                     </div>
                            </div>
                          
                            <div class="col-md-12">
                                <h2 class="sub-title mrg-T0">Owner Information</h2>
                            </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="crm-label">Owner Name</label>
                                    <input onkeypress="return alphaOnly(event)" type="text" class="form-control crm-form" value="<?= !empty($getBookingDetail['owner_name'])?$getBookingDetail['owner_name']:''?>" placeholder="Owner Name" id="owner_name" name="owner_name" autocomplete="off">
                                     <div class="error" id="err_owner_name"></div>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="crm-label">Owner Mobile</label>
                                    <input onkeypress="return isNumberKey(event)" maxlength="10"  type="text" class="form-control crm-form" value="<?= !empty($getBookingDetail['owner_mobile'])?$getBookingDetail['owner_mobile']:''?>" placeholder="Owner Mobile" id="owner_mobile" name="owner_mobile" autocomplete="off">
                                     <div class="error" id="err_owner_mobile"></div>
                                </div>
                            </div>
                                <input type="hidden" value="1" name="refurb_workshop">
                                <input type="hidden" value="<?= !empty($getBookingDetail['id'])?$getBookingDetail['id']:'' ?>" name="id">
                            <div class="col-md-12">
                                <div class="btn-sec-width">
                                     <button type="button" class="btn-continue saveCont"  id="refurbButton">SAVE</button>                             
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/loan_validation.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>    
<script>

</script>
