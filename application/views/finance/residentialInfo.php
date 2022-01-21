<?php   
    if(!empty($CustomerInfo['sameas']))
    {
        $checked = 'checked="checked"';
    }
    else
    {
       $checked = ''; 
    }
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 pad-LR-10 mrg-B40">
            <h2 class="page-title">Case Info</h2>
            <div class="white-section">
                <form  enctype="multipart/form-data" method="post"  id="residenceForm" name="residenceForm">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="sub-title mrg-T0">Residence information</h2>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Residence Type*</label>
                                <select class="form-control crm-form testselect1" id="residance_type" name="residance_type" >
                                    <option value="">Select Residence Type</option>
                                    <option value="Owned by Self/Spouse" <?php if(!empty($CustomerInfo['residance_type']) && $CustomerInfo['residance_type']=='Owned by Self/Spouse'){ echo 'selected=selected'; }else if(!empty($personelDetail['residence_type_id']) && $personelDetail['residence_type_id']=='Owned by Self/Spouse'){ echo 'selected=selected'; } else{ echo ''; }?>>Owned by Self/Spouse</option>
                                    <option value="Rented with Family" <?php /*= (!empty($CustomerInfo['residance_type']) && $CustomerInfo['residance_type']=='Rented with Family')?'selected=selected':''*/
                                     if(!empty($CustomerInfo['residance_type']) && $CustomerInfo['residance_type']=='Owned by Self/Spouse'){ echo 'selected=selected'; }else if(!empty($personelDetail['residence_type_id']) && $personelDetail['residence_type_id']=='Rented with Family'){ echo 'selected=selected'; } else{ echo ''; }
                                    ?>>Rented with Family</option>
                                    <option value="Rented with Friends" <?php /*= (!empty($CustomerInfo['residance_type']) && $CustomerInfo['residance_type']=='Rented with Friends')?'selected=selected':'' */
                                    if(!empty($CustomerInfo['residance_type']) && $CustomerInfo['residance_type']=='Rented with Friends'){ echo 'selected=selected'; }else if(!empty($personelDetail['residence_type_id']) && $personelDetail['residence_type_id']=='Rented with Friends'){ echo 'selected=selected'; } else{ echo ''; }
                                    ?>>Rented with Friends</option>
                                    <option value="Rented Alone" <?php /*= (!empty($CustomerInfo['residance_type']) && $CustomerInfo['residance_type']=='Rented Alone')?'selected=selected':''*/
                                     if(!empty($CustomerInfo['residance_type']) && $CustomerInfo['residance_type']=='Rented Alone'){ echo 'selected=selected'; }else if(!empty($personelDetail['residence_type_id']) && $personelDetail['residence_type_id']=='Rented Alone'){ echo 'selected=selected'; } else{ echo ''; }
                                    ?>>Rented Alone</option>
                                    <option value="Paying Guest" <?php /*= (!empty($CustomerInfo['residance_type']) && $CustomerInfo['residance_type']=='Paying Guest')?'selected=selected':''*/
                                     if(!empty($CustomerInfo['residance_type']) && $CustomerInfo['residance_type']=='Paying Guest'){ echo 'selected=selected'; }else if(!empty($personelDetail['residence_type_id']) && $personelDetail['residence_type_id']=='Paying Guest'){ echo 'selected=selected'; } else{ echo ''; }
                                    ?>>Paying Guest</option>
                                    <option value="Hostel" <?php /*= (!empty($CustomerInfo['residance_type']) && $CustomerInfo['residance_type']=='Hostel')?'selected=selected':''*/
                                    if(!empty($CustomerInfo['residance_type']) && $CustomerInfo['residance_type']=='Hostel'){ echo 'selected=selected'; }else if(!empty($personelDetail['residence_type_id']) && $personelDetail['residence_type_id']=='Hostel'){ echo 'selected=selected'; } else{ echo ''; }
                                    ?>>Hostel</option>
                                    <option value="Company/Government Quarters" <?/*= (!empty($CustomerInfo['residance_type']) && $CustomerInfo['residance_type']=='Company/Government Quarters')?'selected=selected':''*/
                                    if(!empty($CustomerInfo['residance_type']) && $CustomerInfo['residance_type']=='Company/Government Quarters'){ echo 'selected=selected'; }else if(!empty($personelDetail['residence_type_id']) && $personelDetail['residence_type_id']=='Company/Government Quarters'){ echo 'selected=selected'; } else{ echo ''; }
                                    ?>>Company/Government Quarters</option>
                                </select>
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_residance_type"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Length of stay*</label>
                               <!-- <input onkeypress="return isNumberKey(event)" type="text" class="form-control crm-form" value="<?= !empty($CustomerInfo['length_of_stay'])?$CustomerInfo['length_of_stay']:''?>" placeholder="Length of stay" id="length_of_stay" name="length_of_stay"> -->
                                <select class="form-control crm-form" id="length_of_stay" name="length_of_stay" >
                                    <option value="">Length of stay</option>
                                    <option value="1" <?= (!empty($CustomerInfo['length_of_stay']) && $CustomerInfo['length_of_stay']=='1')?'selected=selected':''?>>Below 1 Year</option>
                                    <option value="2" <?= (!empty($CustomerInfo['length_of_stay']) && $CustomerInfo['length_of_stay']=='2')?'selected=selected':''?>>1 Year</option>
                                    <option value="3" <?= (!empty($CustomerInfo['length_of_stay']) && $CustomerInfo['length_of_stay']=='3')?'selected=selected':''?>>Above 2 Year</option>
                                </select>
                                 <div class="error" id="err_length_of_stay"></div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Address*</label>
                                <input type="text" class="form-control crm-form" value="<?php /*= !empty($CustomerInfo['residence_address'])?$CustomerInfo['residence_address']:''*/
                                if(!empty($CustomerInfo['residence_address']))
                                {
                                    echo $CustomerInfo['residence_address']; 
                                }
                                else if(!empty($personelDetail['address']))
                                { 
                                    echo $personelDetail['address'];
                                } 
                                else
                                { 
                                    echo ''; 
                                }
                                ?>" placeholder="Address" id="residence_address" name="residence_address">
                                <div class="error" id="err_residence_address"></div>

                            </div>
                        </div>

                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Landmark</label>
                                <input type="text" class="form-control crm-form" value="<?php /*= !empty($CustomerInfo['residence_address'])?$CustomerInfo['residence_address']:''*/
                                if(!empty($CustomerInfo['landmark']))
                                {
                                    echo $CustomerInfo['landmark']; 
                                }
                                else
                                { 
                                    echo ''; 
                                }
                                ?>" placeholder="Land Mark" id="landmark" name="landmark">
                                <div class="error" id="err_landmark"></div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">State*</label>
                                <select   class=" form-control testselect1 crm-form" id="state" name="residence_state">
                                                <option value="">Select State</option>
                                                <?php foreach ($stateList as $state) { ?>
                                                        <option value="<?= $state->state_id ?>" 
                                                        <?php /* (!empty($CustomerInfo['residence_state']) && $CustomerInfo['residence_state']==$state->state_id)?'selected=selected':'' */ 
                                                        if(!empty($personelDetail['state_id']) && $personelDetail['state_id']==$state->state_id)
                                                        {
                                                           echo 'selected=selected'; 
                                                        }
                                                        else if(!empty($CustomerInfo['residence_state']) && $CustomerInfo['residence_state']==$state->state_id)
                                                        {
                                                             echo 'selected=selected';
                                                        }
                                                        else
                                                        {
                                                            echo "";
                                                        }
                                                        ?>><?= $state->state_name ?></option>
                                                <?php }
                                            ?>
                                            </select>
                                              <div class="error" id="err_state"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">City*</label>
                               <select  class=" form-control crm-form testselect1" id="residence_city" name="residence_city">
                                <option value="">Select City</option>
                                 <?php 
                                 if(!empty($cityList)){
                                 foreach ($cityList as $city) { ?>
                                                        <option value="<?= $city['city_id']; ?>" 
                                                        <?php /*= (!empty($CustomerInfo['residence_city']) && $CustomerInfo['residence_city']==$city['city_id'])?'selected=selected':''*/
                                                        if(!empty($personelDetail['city_id']) && $personelDetail['city_id']==$state->state_id)
                                                        {
                                                           echo 'selected=selected'; 
                                                        }
                                                        else if(!empty($CustomerInfo['residence_city']) && $CustomerInfo['residence_city']==$city['city_id'])
                                                        {
                                                             echo 'selected=selected';
                                                        }
                                                        else
                                                        {
                                                            echo "";
                                                        }
                                                        ?>><?= $city['city_name'] ?></option>
                                 <?php } } ?>
                               </select>
                                <div class="error" id="err_residence_city"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Pin Code*</label>
                                <input type="text" maxlength="6"  class="form-control crm-form" value="<?php
                                if(!empty($CustomerInfo['residence_pincode']))
                                {
                                    echo trim($CustomerInfo['residence_pincode']); 
                                }
                                else if(!empty($personelDetail['pincode']))
                                { 
                                    echo trim($personelDetail['pincode']);
                                } 
                                else
                                { 
                                    echo ''; 
                                }
                                ?>" placeholder="Pin Code" id="residence_pincode" onkeypress="return isNumberKey(event)" name="residence_pincode" >
                                <div class="error" id="err_residence_pincode"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Mobile*</label>
                                <input type="text" onkeypress="return isNumberKey(event)" class="form-control crm-form" placeholder="Mobile" value="<?php /*= !empty($CustomerInfo['residence_phone'])?$CustomerInfo['residence_phone']:'' */
                                 if(!empty($CustomerInfo['residence_phone']))
                                {
                                    echo $CustomerInfo['residence_phone']; 
                                }
                                else if(!empty($customerMobileNumber['mobile']))
                                {
                                    echo $customerMobileNumber['mobile']; 
                                }
                                else if(!empty($personelDetail['residence_phone']))
                                { 
                                    echo $personelDetail['residence_phone'];
                                } 
                                else
                                { 
                                    echo ''; 
                                }
                                ?>" id="residence_phone" name="residence_phone" maxlength="10" >
                            </div>
                             <div class="error" id="err_residence_phone"></div>
                        </div>
                        
                        <!--Correspondance-->
                         <div class="col-md-12  mrg-T10">
                          <div class="col-md-12">
                            <h2 class="sub-title mrg-T5">Correspondence Address</h2>
                        </div>
                             <span class="radio-btn-sec">
                                        <input name="sameas" <?=$checked?> id="sameas" value="1" class="trigger"  type="checkbox">
                                        <label for="sameas"><span class="dt-yes"></span> Same As Residence Address</label>
                                    </span>
                         </div>
                         <div id="correspon" style="display: none">
                   

                     
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Address*</label>
                                <input type="text" class="form-control crm-form" value="<?php /*= !empty($CustomerInfo['residence_address'])?$CustomerInfo['residence_address']:''*/
                                
                                 if(!empty($CustomerInfo['corres_add']))
                                {
                                    echo $CustomerInfo['corres_add']; 
                                }else if(!empty($CustomerInfo['residence_address']))
                                {
                                    echo $CustomerInfo['residence_address']; 
                                }
                                else
                                { 
                                    echo ''; 
                                }
                                ?>" placeholder="Address" id="corres_address" name="corres_address">
                                <div class="error" id="err_corres_address"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">State*</label>
                                <select   class=" form-control testselect1 crm-form" id="corres_state" name="corres_state">
                                                <option value="">Select State</option>
                                                <?php foreach ($stateList as $state) { ?>
                                                        <option value="<?= $state->state_id ?>" 
                                                        <?php 
                                                        if(!empty($CustomerInfo['corres_state']) && $CustomerInfo['corres_state']==$state->state_id)
                                                        {
                                                            echo 'selected=selected';
                                                        } 
                                                        else if(!empty($CustomerInfo['residence_state']) && $CustomerInfo['residence_state']==$state->state_id)
                                                        {
                                                             echo 'selected=selected';
                                                        }
                                                        else
                                                        {
                                                            echo "";
                                                        }
                                                        ?>><?= $state->state_name ?></option>
                                                <?php }
                                            ?>
                                            </select>
                                            <div class="error" id="err_corres_state"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">City*</label>
                               <select  class=" form-control crm-form testselect1" id="corres_city" name="corres_city">
                                <option value="">Select City</option>
                                 <?php 
                                 if(!empty($cityList)){
                                 foreach ($cityList as $city) { ?>
                                                        <option value="<?= $city['city_id']; ?>" 
                                                        <?
                                                        
                                                         if(!empty($CustomerInfo['corres_city']) && $CustomerInfo['corres_city']==$city['city_id'])
                                                        {
                                                             echo 'selected=selected';
                                                        }
                                                        else if(!empty($CustomerInfo['residence_city']) && $CustomerInfo['residence_city']==$city['city_id'])
                                                        {
                                                             echo 'selected=selected';
                                                        }
                                                        else
                                                        {
                                                            echo "";
                                                        }
                                                        ?>><?= $city['city_name'] ?></option>
                                 <?php } } ?>
                               </select>
                                <div class="error" id="err_corres_city"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Landmark</label>
                                <input type="text" class="form-control crm-form" value="<?php  if(!empty($CustomerInfo['cores_landmark']))
                                { 
                                    echo $CustomerInfo['cores_landmark'];
                                } 
                                else if(!empty($CustomerInfo['landmark']))
                                {
                                    echo $CustomerInfo['landmark']; 
                                }
                                else
                                { 
                                    echo ''; 
                                }
                                ?>" placeholder="Land Mark" id="cores_landmark" name="cores_landmark">
                                <div class="error" id="err_cores_landmark"></div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Pin Code*</label>
                                <input type="text" onkeypress="return isNumberKey(event)" class="form-control crm-form" value="<?php  if(!empty($CustomerInfo['corres_pincode']))
                                { 
                                    echo $CustomerInfo['corres_pincode'];
                                } 
                                else if(!empty($CustomerInfo['residence_pincode']))
                                {
                                    echo $CustomerInfo['residence_pincode']; 
                                }
                                else
                                { 
                                    echo ''; 
                                }
                                ?>" placeholder="Pin Code" id="corres_pincode" name="corres_pincode" maxlength="6">
                            </div>
                             <div class="error" id="err_corres_pincode"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">Phone*</label>
                                <input type="text" onkeypress="return isNumberKey(event)" class="form-control crm-form" placeholder="Phone" value="<?php /*= !empty($CustomerInfo['residence_phone'])?$CustomerInfo['residence_phone']:'' */
                                 if(!empty($CustomerInfo['corres_phone']))
                                { 
                                    echo $CustomerInfo['corres_phone'];
                                } 
                                else if(!empty($CustomerInfo['residence_phone']))
                                {
                                    echo $CustomerInfo['residence_phone']; 
                                } 
                                else
                                { 
                                    echo ''; 
                                }
                                ?>" id="corres_phone" name="corres_phone" maxlength="10" >
                                <div class="error" id="err_corres_phone"></div>
                            </div>
                        </div>
                        </div>
                         <input type="hidden" value="1" name="residenceForm">
                            <input type="hidden" value="<?= !empty($CustomerInfo['customer_id'])?$CustomerInfo['customer_id']:'' ?>" name="customerId">
                             <input type="hidden" value="<?= !empty($CustomerInfo['customer_loan_id'])?$CustomerInfo['customer_loan_id']:'' ?>" name="caseId" id="caseId">
                        <div class="col-md-12">
                            <div class="btn-sec-width">

                              <?php 
                                $stylesss = 'display:block';
                                $stylec = 'display:none';
                                $action = '';
                                /*if(!empty($CustomerInfo['tag_flag']) && ($CustomerInfo['tag_flag']=='4'))
                                {
                                    $stylesss  = 'display:none';
                                    $stylec = 'display:block';
                                    $action = base_url('refrenceDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);
                                }*/
                                if(((($rolemgmt[0]['edit_permission']=='0') && (!empty($CustomerInfo['cust_bnk_id']))) || ($rolemgmt[0]['add_permission']=='0')) || ((!empty($CustomerInfo['ref_id'])) && ($rolemgmt[0]['role_name']!='admin') && ($rolemgmt[0]['role_name']!='Loan Admin')))
                                {
                                    $stylesss  = 'display:none';
                                    $stylec = 'display:block';
                                    $action = base_url('refrenceDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);

                                }

                              if($CustomerInfo['cancel_id']=='0'){ ?> 
                                <button type="button" class="btn-continue saveCont" style="<?=$stylesss?>"  id="residenceButton">SAVE AND CONTINUE</button>
                                 <button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>    
<script>
  $('.testselect1').SumoSelect({csvDispCount: 3, search: true, searchText:'Enter here.',triggerChangeCombined: true});
$("#sameas").click(function(){
if ($("#sameas").is(":checked")) {
     $('#sameas').val('1');
  var add = $('#residence_address').val();
  var state = $('#state').val();
  var city = $('#residence_city').val();
  var pin = $('#residence_pincode').val();
  var phone = $('#residence_phone').val();
  var land = $('#landmark').val();
 $('#corres_state').trigger('change');
 $('#corres_city').trigger('change');
  var Cadd = $('#corres_address').val(add);
  var Cstate = $('#corres_state').val(state);
  $('#corres_state')[0].sumo.reload();
  var Ccity = $('#corres_city').val(city);
  $('#corres_city')[0].sumo.reload();
  var Cpin = $('#corres_pincode').val(pin);
  var Cland = $('#cores_landmark').val(land);
  var Cphone = $('#corres_phone').val(phone);
   $('#correspon').attr('style','display:none');
}
else
{
     $('#sameas').val('0');
  $('#correspon').attr('style','display:block');
  var Cadd = $('#corres_address').val('');
  var Cstate = $('#corres_state').val('');
  $('#corres_state')[0].sumo.reload();
  var Ccity = $('#corres_city').val('');
   $('#corres_city')[0].sumo.reload();
  var Cpin = $('#corres_pincode').val('');
  var Cphone = $('#corres_phone').val('');
  var Cland = $('#cores_landmark').val('');
}
});
if ($("#sameas").is(":checked")) {
    $('#sameas').val('1');
     $('#correspon').attr('style','display:none');
  var add = $('#residence_address').val();
  var state = $('#state').val();
  var city = $('#residence_city').val();
  var pin = $('#residence_pincode').val();
  var phone = $('#residence_phone').val();
  var land = $('#landmark').val();
    $('#corres_state').trigger('change');
    $('#corres_city').trigger('change');

  var Cadd = $('#corres_address').val(add);
  var Cstate = $('#corres_state').val(state);
  $('#corres_state')[0].sumo.reload();
  var Ccity = $('#corres_city').val(city);
   $('#corres_city')[0].sumo.reload();
  var Cpin = $('#corres_pincode').val(pin);
   var Cland = $('#cores_landmark').val(land);
  var Cphone = $('#corres_phone').val(phone);
}
else
{
    $('#sameas').val('0');
     $('#correspon').attr('style','display:block');
  //var Cadd = $('#corres_address').val('');
  //var Cstate = $('#corres_state').val('');
  //var Ccity = $('#corres_city').val('');
  //var Cpin = $('#corres_pincode').val('');
  //var Cphone = $('#corres_phone').val('');
}
$(document).ready(function(){
    var state = "<?=(!empty($CustomerInfo['corres_state'])?$CustomerInfo['corres_state']:$CustomerInfo['residence_state'])?>";
//alert("<?=$CustomerInfo['corres_city']?>");
    var city = "<?=(!empty($CustomerInfo['corres_city'])?$CustomerInfo['corres_city']:$CustomerInfo['residence_city'])?>";
    $('#corres_state').val(state);
    $('#corres_state')[0].sumo.reload();
    setTimeout(function(){ 
    if(state>0)
    {
      //  alert('hiiii');
     $.ajax({
        type: 'POST',
        url: "<?php echo base_url(); ?>finance/getcities",
        data: {stateId: state},
        dataType: "html",
        success: function (responseData)
        {
            $('#corres_city').html(responseData);
            $('#corres_city').val(city); 
            $('#corres_city')[0].sumo.reload();

        } 
        });
    }
    }, 300);
    
});

</script>