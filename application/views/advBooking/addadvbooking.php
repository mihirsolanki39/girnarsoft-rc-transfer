<div class="container-fluid">
<a id="gototop"></a>
    <div class="row">
        <div class="col-md-12 pad-LR-10 mrg-B40">
            <h2 class="page-title">Advance Booking</h2>
            <form  enctype="multipart/form-data" method="post"  id="adv_booking" name="adv_booking">
                <div id="rc_details" class="white-section">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="sub-title mrg-T0">Booking Information</h2>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Source*</label>
                                <select class="form-control crm-form" id="source" name="source">
                                <option value="">Select</option>
                                    <option value="1" <?=  (!empty($getBookingDetail['source']) && $getBookingDetail['source']=='1'?'selected=selected':'')?>>Dealer</option>
                                    <option value="2" <?=  (!empty($getBookingDetail['source']) && $getBookingDetail['source']=='2'?'selected=selected':'')?>>Inhouse</option>
                                </select>
                                <div class="d-arrow"></div>
                                <div class="error" id="err_source"></div>
                            </div>
                        </div>
                        <div class="col-md-6" id="dealership" style="display: none">
                            <div class="form-group">
                                <label for="" class="crm-label">Dealership Name*</label>
                                <select class="form-control crm-form destselect2" id="dealer_name" name="dealer_name">
                                <option value="">Select</option>
                                <?php foreach($dealerList as $key => $val){?>
                                    <option value="<?=$val['id']?>" <?=  (!empty($getBookingDetail['dealer_id']) && $getBookingDetail['dealer_id']==$val['id']?'selected=selected':'')?>><?=$val['organization']?></option>
                                    <?php } ?>
                                </select>
                                <div class="d-arrow"></div>
                                <div class="error" id="err_dealer_name"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Sales Executive*</label>
                                <select class="form-control crm-form testselect1" id="emp_id" name="emp_id">
                                <option value="">Select</option>
                                <?php foreach($employeeSalesList as $ekey => $eval){?>
                                    <option value="<?=$eval['id']?>" <?=  (!empty($getBookingDetail['emp_id']) && $getBookingDetail['emp_id']==$eval['id']?'selected=selected':'')?>><?=$eval['name']?></option>
                                    <?php } ?>
                                </select>
                                <div class="error" id="err_emp_id"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form-group rcstatus trans">
                                    <label for="" class="crm-label">Booking Date</label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1" id="booking_date" name="booking_date" autocomplete="off" value="<?php 
                                                if(!empty($getBookingDetail['booking_date']) && ($getBookingDetail['booking_date']>'0000-00-00 00:00:00'))
                                                { 
                                                    $dob = date('d-m-Y',strtotime($getBookingDetail['booking_date'])) ;
                                                } 
                                               
                                                else 
                                                { 
                                                    $dob = '';
                                                } 

                                            echo $dob ;
                                            ?>" >
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="err_on"></div>
                                </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group rcstatus abc">
                                <label for="" class="crm-label">Booking Slip No.</label>
                                <input onkeypress="return blockSpecialChar(event)" type="text" class="form-control crm-form" value="<?= !empty($getBookingDetail['booking_slip_no'])?$getBookingDetail['booking_slip_no']:''?>" placeholder="Booking Slip No" id="booking_slip_no" name="booking_slip_no" autocomplete="off">
                                 <div class="error" id="err_booking_slip_no"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group rcstatus abc">
                                <label for="" class="crm-label">Booking Amount</label>
                                <input onkeypress="return isNumberKey(event)" type="text" class="form-control crm-form rupee-icon"  value="<?= !empty($getBookingDetail['booking_amount'])?$getBookingDetail['booking_amount']:''?>" placeholder="Booking Amount" onkeyup="addCommas(this.value,'booking_amount');" maxlength="8" id="booking_amount" name="booking_amount" autocomplete="off">
                                 <div class="error" id="err_booking_amount"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Amount Paid To*</label>
                                <select class="form-control crm-form" id="amount_paid_to" name="amount_paid_to">
                                    <option value="">Select</option>
                                    <option value="1" <?=  (!empty($getBookingDetail['amount_paid_to']) && $getBookingDetail['amount_paid_to']=='1'?'selected=selected':'')?>>Showroom</option>
                                    <option value="2" <?=  (!empty($getBookingDetail['amount_paid_to']) && $getBookingDetail['amount_paid_to']=='2'?'selected=selected':'')?>>Inhouse</option>
                                </select>
                                <div class="d-arrow"></div>
                                <div class="error" id="err_amount_paid_to"></div>
                            </div>
                        </div>
                        <a id="gotoshow"></a>
                        <div class="col-md-12">
                            <h2 class="sub-title mrg-T0">Showroom Information</h2>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Showroom*</label>
                                <select class="form-control crm-form destselect3" id="showroom" name="showroom">
                                <option value="">Select</option>
                                <?php foreach($showroomList as $skey => $sval){?>
                                    <option value="<?=$sval['id']?>" <?=  (!empty($getBookingDetail['showroom_id']) && $getBookingDetail['showroom_id']==$sval['id']?'selected=selected':'')?>><?=$sval['organization']?></option>
                                    <?php } ?>
                                </select>
                                <!-- <div class="d-arrow"></div> -->
                                <div class="error" id="err_showroom"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Address</label>
                                <input type="text" placeholder="Showroom Address" class="form-control crm-form" id="address" name="address" value="<?=(!empty($getBookingDetail['showroom_id'])?ucwords($getBookingDetail['showroom_add']):'')?>" readonly="readonly">
                                <div class="error" id="err_add"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Kind attn</label>
                                <input type="text" class="form-control crm-form" id="kind_attn" name="kind_attn" value="<?=(!empty($getBookingDetail['showroom_id'])?ucwords($getBookingDetail['kind_attn']):'')?>"  placeholder="Kind Attn" onkeypress="return nameOnly(event)">
                                <div class="error" id="err_kind_attn"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Showroom Booking No.</label>
                                <input type="text" class="form-control crm-form" id="showroom_booking_no" name="showroom_booking_no" onkeypress="return blockSpecialChar(event)"  value="<?=(!empty($getBookingDetail['showroom_booking_no'])?$getBookingDetail['showroom_booking_no']:'')?>" maxlength="8"  placeholder="Showroom Booking No.">
                                <div class="error" id="err_showroom_booking_no"></div>
                            </div>
                        </div>
                        <a id="gotocust"></a>
                        <div class="col-md-12">
                            <h2 class="sub-title mrg-T0">Customer Information</h2>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Mobile No.*</label>
                                <input type="text" onkeypress="return isNumberKey(event)" maxlength="10" class="form-control crm-form" placeholder="Customer Mobile" id="mobile" name="mobile" value="<?=(!empty($getBookingDetail['customer_mobile'])?$getBookingDetail['customer_mobile']:'')?>">
                                    <div class="error" id="err_customer_mobile"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Name*</label>
                                <input type="text" placeholder="Customer Name" class="form-control crm-form" id="customer_name" name="customer_name" maxlength="20" onkeypress="return nameOnly(event)" value="<?=(!empty($getBookingDetail['customer_name'])?ucwords($getBookingDetail['customer_name']):'')?>">
                                <div class="error" id="err_customer_name"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Address</label>
                                <input type="text" class="form-control crm-form" id="customer_address" name="customer_address" placeholder="Customer Address" value="<?=(!empty($getBookingDetail['customer_address'])?ucwords($getBookingDetail['customer_address']):'')?>">
                              <div class="error" id="err_customer_address"></div>
                            </div>
                        </div>
                        <a id="gotoveh"></a>
                        <div class="col-md-12">
                            <h2 class="sub-title mrg-T0">Vehicle Information</h2>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Color</label>
                            <select  class="form-control crm-form colorselect" name="color" id="color" >
                                <option  value="">Select Color</option>
                                <?php
                                foreach ($getColors as $rses => $va) {
                                    ?>
                                <option value="<?= $va['id']; ?>" <?= (!empty($getBookingDetail['color']) && $getBookingDetail['color']== $va['id'])?'selected=selected':''?>>
                                        <?=  $va['name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <!-- <div class="d-arrow"></div> -->
                            <div class="error" id="err_color"></div>
                        </div>
                    </div>
                       <!-- <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Make *</label>
                                 <select class="form-control crm-form" name="makeId" id="make">
                                    <option selected="selected" value="">Select Make</option>
                                    <?php if(!empty($makeList)){ ?>
                                    <?php foreach($makeList as $makeData){?>
                                    <option value="<?php echo $makeData->id;?>"<?php echo ((!empty($getBookingDetail['make_id'])) && $getBookingDetail['make_id']==$makeData->id) ? "selected=selected" : '';?>><?php echo $makeData->make;?></option>
                                    <?php }} ?> 
                                 </select>
                                 <div class="error" id="err_make" ></div>
                                 <div class="d-arrow"></div>
                                 </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Model *</label>
                                 <select class="form-control crm-form crm-form_read_only" name="modelId" id="model" <?php if(!empty($getBookingDetail['model_id'])) { echo ''; }else{ ?>readonly="readonly" <?php } ?>>
                                     <option value="">Please Select</option>
                                     <?php if(!empty($getBookingDetail['model_id']) && !empty($model)) {
                                    foreach ($model as $key =>$value) {
                                   ?>
                                   <option  value="<?= $value['id'];?>" <?= (!empty($getBookingDetail['model']) && $getBookingDetail['model_id']==$value['id'])?'selected=selected':''?>><?= $value['model']?></option>
                                     <?php  } } ?>
                                 </select>
                                 <div class="error" id="err_model" ></div>
                                 <div class="d-arrow"></div>
                              </div>
                           </div>-->
                            <input type="hidden" value="<?=$getBookingDetail['make_id'];?>" id="make" name="makeId">
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Make Model *</label>
                                 <select class="form-control crm-form crm-form_read_only makemodelselect" name="modelId" id="model" <?php if(!empty($getBookingDetail['model_id'])) { echo ''; }else{ ?>readonly="readonly" <?php } ?>>
                                     <option value="">Please Select</option>
                                     <?php if(!empty($makeList)) {
                                    foreach ($makeList as $key =>$value) {
                                   ?>
                                   <!--<option  value="<?= $value['id'];?>" <?= (!empty($getBookingDetail['model']) && $getBookingDetail['model_id']==$value['id'])?'selected=selected':''?>><?= $value['model']?></option>-->
                                   <option rel="<?= $value['make_id'];?>"  value="<?= $value['model_id'];?>" <?= (!empty($getBookingDetail['model_id']) && $getBookingDetail['model_id']==$value['model_id'])?'selected=selected':''?>><?=$value['make'] .' '.$value['model']?></option>
                                     <?php  } } ?>
                                 </select>
                                 <div class="error" id="err_model" ></div>
                                 <!-- <div class="d-arrow"></div> -->
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Version *</label>
                                 <select class="form-control crm-form crm-form_read_only destselect4" name="versionId" id="versionId" <?php if(!empty($getBookingDetail['version_id'])) { echo ''; }else{ ?>readonly="readonly" <?php } ?>>
                                     <option value="">Please Select</option>
                                     <?php if(!empty($version)) {
                                    foreach ($version as $key =>$value) {?>
                                   <option  value="<?= $value['db_version_id'];?>" <?= (!empty($getBookingDetail['version_id']) && $getBookingDetail['version_id']==$value['db_version_id'])?'selected=selected':''?>><?= $value['db_version']?></option>
                                  <?php  } } ?>
                                 </select>
                                 <div class="error" id="err_variant" ></div>
                                 <!-- <div class="d-arrow"></div> -->
                              </div>
                           </div>

                    <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Registration Type*</label>
                                <select class="form-control crm-form" id="registration" name="registration">
                                    <option value="">Select</option>
                                    <option value="1" <?=  (!empty($getBookingDetail['registration']) && $getBookingDetail['registration']=='1'?'selected=selected':'')?>>Private Number</option>
                                    <option value="2" <?=  (!empty($getBookingDetail['registration']) && $getBookingDetail['registration']=='2'?'selected=selected':'')?>>Commercial Number</option>
                                </select>
                                <div class="d-arrow"></div>
                                <div class="error" id="err_registration"></div>
                            </div>
                    </div>
                            <input type="hidden" value="1" name="adv_bookings">
                            <input type="hidden" value="<?= !empty($getBookingDetail['booking_id'])?$getBookingDetail['booking_id']:'' ?>" name="id">
                        <div class="col-md-12">
                            <div class="btn-sec-width">
                                 <button type="button" class="btn-continue saveCont"  id="advbookingButton">SAVE</button>                             
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
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>    
<!--add sumo select start -->
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script>
    $('.testselect1').SumoSelect({triggerChangeCombined: true, search: true, searchText: 'Search here.'});

    $('.destselect2').SumoSelect({triggerChangeCombined: true, search: true, searchText: 'Search here.'});

     $('.destselect3').SumoSelect({triggerChangeCombined: true, search: true, searchText: 'Search here.'});
     $('.makemodelselect').SumoSelect({triggerChangeCombined: true, search: true, searchText: 'Search here.'});

      $('.destselect4').SumoSelect({triggerChangeCombined: true, search: true, searchText: 'Search here.'});

     $('.colorselect').SumoSelect({triggerChangeCombined: true, search: true, searchText: 'Search here.'});
</script>
<!--add sumo select end   -->
<script>

var mak = "<?=$getBookingDetail['make_id']?>";
if(mak>0)
{
    $('#model')
    .val("<?=$getBookingDetail['model_id']?>")
    .trigger('change');
    $('#versionId')
    .val("<?=$getBookingDetail['version_id']?>")
    .trigger('change');
    setTimeout(function(){ $("#model").trigger('change'); }, 300);
   
}
$('#make').on('change', function () {
    var selected = $(this).val();
    $.ajax({
        type: 'POST',
        url: "<?php echo base_url(); ?>" +"finance/getModel",
        data: {make: selected},
        dataType: "html",
        success: function (responseData)
        {
            $('#model').html(responseData);
            $('#versionId').html('<option value="">Select Version</option>');

        }
    });
    });
    
    $('#model').on('change', function () {
//alert('hii');
    var selected = $(this).val();
    var make     = $("option:selected", this).attr("rel");
      //alert(make);
      $('#make').val(make);
    //var make     = $('#make').val();
    $.ajax({
        type: 'POST',
        url: "<?php echo base_url(); ?>" +"finance/getVersion",
        data: {model: selected,make:make,flag:'1'},
        dataType: "html",
        success: function (responseData)
        {
            $('#versionId').html(responseData);
            $('#versionId')[0].sumo.reload();

        }
    });
    });  
    var d = '<?=date('d-m-Y')?>';
$('#booking_date').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: '<?=date('Y')?>',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });

  var source = $('#source').val();
  if(source=='1')
  {
    $('#dealership').attr('style','display:block');
  }
  else
  {
    $('#dealership').attr('style','display:none');
  }

$("#source").change(function() {
  var source = $('#source').val();
  if(source=='1')
  {
    $('#dealership').attr('style','display:block');
  }
  else
  {
    $('#dealership').attr('style','display:none');
  }
});

$("#showroom").change(function() {
    var showroom_id = $('#showroom').val();
    $.ajax({
           type : 'POST',
           url : "<?php echo base_url(); ?>" + "DeliveryOrder/getShowroomDetails/",
           data:{showroom_id:showroom_id},
          // dataType: 'json',
           success: function (response) 
           { 
              var data = $.parseJSON(response);
              $('#address').val(data.add);
              $('#kind_attn').val(data.attn);
           }
    });
});

</script>
