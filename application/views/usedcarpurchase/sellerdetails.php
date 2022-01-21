<?php  //echo '<pre>';print_r($CustomerInfo['id']);die;?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 pad-LR-10 mrg-B40">
            <h2 class="page-title">Seller Details</h2>
            <div class="white-section">
                <div class="row">
                    <form  enctype="multipart/form-data" method="post"  id="sellinfo" name="sellinfo">                  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Seller Type*</label>
                             <select class="form-control crm-form lead_source" id="seller_type" name="seller_type">
                                <option value="">Select lead type</option>
                                <option <?= !empty($usedCarInfo['seller_type']) && $usedCarInfo['seller_type']==1 ?'selected':'' ?> value="1">Individual</option>
                                <option <?= !empty($usedCarInfo['seller_type']) && $usedCarInfo['seller_type']==2?'selected':'' ?> value="2">Company</option>
                            </select>
                            <div class="error" id="err_seller_type"></div>
                        </div>
                       
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label" id="nm">Name*</label>
                            <label class="crm-label" id="cmpnm">Company Name*</label>
                            <input type="text" id="name" onkeypress="return blockSpecialChar(event)" name="name"  class="form-control crm-form" placeholder="Name" value="<?= !empty($usedCarInfo['seller_name'])?ucwords($usedCarInfo['seller_name']):'' ?>" >
                            <!--<div class="d-arrow"></div>-->
                            <div class="error" id="err_name"></div>
                        </div>
                       
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Mobile*</label>
                            <input type="text" id="mobile"  name="mobile"  class="form-control crm-form" placeholder="Mobile" value="<?= !empty($usedCarInfo['seller_mobile'])?ucwords($usedCarInfo['seller_mobile']):'' ?>"  maxlength="10">
                            <!--<div class="d-arrow"></div>-->
                            <div class="error" id="err_mobile"></div>
                        </div>
                       
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Email*</label>
                            <input type="text" id="email"  name="email"  class="form-control crm-form" placeholder="Email" value="<?= !empty($usedCarInfo['seller_email'])?ucwords($usedCarInfo['seller_email']):'' ?>" >
                            <!--<div class="d-arrow"></div>-->
                            <div class="error" id="err_email"></div>
                        </div>
                       
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Address</label>
                            <input type="text" id="address"  name="address"  class="form-control crm-form" placeholder="Address" value="<?= !empty($usedCarInfo['seller_address'])?ucwords($usedCarInfo['seller_address']):'' ?>" >
                            <!--<div class="d-arrow"></div>-->
                            <div class="error" id="err_address"></div>
                        </div>
                       
                    </div>
                        <input type="hidden"  name="sellinfo" value="1" id="sellinfo">
                        <input type="hidden"  name="category_id" value="<?=$usedCarInfo['cat_id']?>" id="category_id">
                         <input type="hidden" name="case_id" value="<?=!empty($usedCarInfo['case_id'])?$usedCarInfo['case_id']:''?>" id="case_id">
                        <input type="hidden"  name="car_id" value="<?= !empty($usedCarInfo['car_id'])?$usedCarInfo['car_id']:'' ?>" id="car_id">
                        <input type="hidden"  name="customer_id" value="<?= !empty($usedCarInfo['customer_id'])?$usedCarInfo['customer_id']:'' ?>" id="customer_id">
                        <div class="col-md-12">
                            <div class="btn-sec-width">
                                <a href="javascript:void(0);" class="btn-continue"  id="saveSeller">SAVE AND CONTINUE</a>
                                <!--<a href="" class="btn-continue">SAVE AND CONTINUE</a>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/inv_stock.js" type="text/javascript"></script>      
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>    
<script>
    $('#seller_type').change(function(){
        var vl = $('#seller_type').val();
         $('#cmpnm').attr('style','display:none;');
         $('#nm').attr('style','display:block;');
        if(vl=='2')
        {
            $('#cmpnm').attr('style','display:block;');
            $('#nm').attr('style','display:none;');
        }
    });

        var vl = $('#seller_type').val();
        $('#cmpnm').attr('style','display:none;');
        $('#nm').attr('style','display:block;');
        if(vl=='2')
        {
            $('#cmpnm').attr('style','display:block;');
            $('#nm').attr('style','display:none;');
        }
</script>

    