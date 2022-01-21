<?php
$is_admin=$this->session->userdata['userinfo']['is_admin'];
$addPerm=isset($permission[0]['add_permission']) ? $permission[0]['add_permission'] :'' ;
$editPerm=isset($permission[0]['edit_permission']) ? $permission[0]['edit_permission']:'';
$viewPerm=isset($permission[0]['view_permission']) ? $permission[0]['view_permission'] : '';
$mode=(!empty($CustomerInfo['customer_dob']) && ($CustomerInfo['customer_dob']!='0000-00-00')) ? 'edit' : 'add';
$stylec = 'display:block';
$action = ($mode=='edit')? base_url().'inspaymentDetail/' . base64_encode('customerId_' . $CustomerInfo["customer_id"]) : '';

?>
<div class="container-fluid  ">
               <div class="row">
                   <form name="personalform" id="personalform" method="post" action="">
                    <h2 class="page-title mrg-L10">Customer Details</h2>
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <div class="white-section">
                        <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0"><?php //echo $pageName;?> Details</h2>
                            </div>
                             <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Address*</label>
                                 <input type="text" name="customer_address"  id="customer_address" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['customer_address'])) ? $CustomerInfo['customer_address'] : '';?>" placeholder="Address">
                                 <div class="error" id="customer_address_error" ></div>
                              </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">City*</label>
                                 <select class="form-control crm-form" name="customer_city" id="customer_city">
                                    <option selected="selected" value="">Select City</option>
                                    <?php if(!empty($citylist)){?>
                                    <?php foreach($citylist as $city){?>
                                    <option value="<?php echo $city['city_id'];?>"<?php echo (!empty($CustomerInfo['customer_city_id']) && $CustomerInfo['customer_city_id']==$city['city_id']) ? "selected=selected" : '';?>><?php echo $city['city_name'];?></option>
                                    <?php }} ?>
                                 </select>
                                 <div class="error" id="customer_city_error" ></div>
                              </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Pincode*</label>
                                 <input type="text" name="customer_pincode"  id="customer_pincode" onkeypress="return isNumberKey(event);" onpaste="return false;" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['customer_pincode'])) ? $CustomerInfo['customer_pincode'] : '';?>" placeholder="Pincode" maxlength="6">
                                 <div class="error" id="customer_pincode_error" ></div>
                                 </div>
                            </div>
                            <?php if($CustomerInfo['buyer_type']=='1'){?>
                           <div class="col-md-6"> 
                           <div class="form-group">
                                 <label class="crm-label">Gender</label>
                                  <span class="radio-btn-sec">
                                     <input type="radio" name="customer_gender" id="male" value="1" class="trigger gen" <?php echo (!empty($CustomerInfo['customer_gender'])) && $CustomerInfo['customer_gender']=='1' ? "checked='checked'" : '';?>>
                                     <label for="male"><span class="dt-yes"></span> Male</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="customer_gender" id="female" value="2" class="trigger gen" <?php echo (!empty($CustomerInfo['customer_gender'])) && $CustomerInfo['customer_gender']=='2' ? "checked='checked'" : '';?>>
                                     <label for="female"><span class="dt-yes"></span> Female</label>
                                 </span>
                                <div class="error" id="customer_gender_error" ></div> 
                              </div>
                             </div>
                            <div class="col-md-6">
                             <div class="form-group">
                                 <label class="crm-label">Marital Status</label>
                                  <span class="radio-btn-sec">
                                     <input type="radio" name="customer_marital" id="single" value="1" class="trigger" <?php echo (!empty($CustomerInfo['customer_marital'])) && $CustomerInfo['customer_marital']=='1' ? "checked='checked'" : '';?>>
                                     <label for="single"><span class="dt-yes"></span> Single</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="customer_marital" id="married" value="2" class="trigger" <?php echo (!empty($CustomerInfo['customer_marital'])) && $CustomerInfo['customer_marital']=='2' ? "checked='checked'" : '';?>>
                                     <label for="married"><span class="dt-yes"></span> Married</label>
                                 </span>
                                 <div class="error" id="customer_marital_error" ></div>
                              </div>
                            </div>
                            <?php } ?>
                            <div class="col-md-6" style="height:84px;">
                                <div class="form-group">
                                    <label for="" class="crm-label"> <?php if($CustomerInfo['buyer_type']=='1'){ echo 'DOB'; } else { echo 'Date of incorporation'; } ?></label>
                                   <div class="input-group date" id="dp">
                                    <input type="text" name="customer_dob" id="customer_dob" class="form-control crm-form add-on icon-cal1 new_input" placeholder="DOB" autocomplete="off" value="<?php echo (!empty($CustomerInfo['customer_dob']) && ((date('Y-m-d',strtotime($CustomerInfo['customer_dob']))!='1970-01-01') && ($CustomerInfo['customer_dob']!='0000-00-00'))) ? date('d-m-Y',strtotime($CustomerInfo['customer_dob'])) : '';?>"> 
                                    <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                    </span>
                                    </div>
                                    <div class="error" id="customer_dob_error" ></div>
                                </div>
                            </div>
                           <?php if($CustomerInfo['buyer_type']=='1'){?>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Occupation</label>
                                 <select class="form-control crm-form" name="customer_occupation" id="customer_occupation">
                                    <option selected="selected" value="">Select Occupation</option>
                                    <?php if(!empty($occupation)){?>
                                    <?php foreach($occupation as $occ){?>
                                    <option value="<?php echo $occ->id;?>"<?php echo (!empty($CustomerInfo['customer_occupation']) && $CustomerInfo['customer_occupation']==$occ->id) ? "selected=selected" : '';?>><?php echo $occ->occval;?></option>
                                    <?php }} ?>
                                 </select>
                                 <div class="error" id="customer_occupation_error" ></div>
                                 <div class="d-arrow"></div>
                              </div>
                           </div>
                            <?php } ?>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">PAN No.</label>
                                 <input type="text" name="customer_pan" id="customer_pan" onkeypress="return blockSpecialChar(event)" onkeyup="return getUpper(this.value,'customer_pan')"class="form-control upperCaseLoan crm-form" value="<?php echo (!empty($CustomerInfo['customer_pan_no'])) ? $CustomerInfo['customer_pan_no'] : '';?>" placeholder="Pancard No." maxlength="10">
                                 <div class="error" id="customer_pan_error" ></div>
                              </div>
                           </div>
                            <?php if($CustomerInfo['buyer_type']=='1'){?>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Aadhar No.</label>
                                 <input type="text" name="customer_aadhar" id="customer_aadhar" onkeypress="return isNumberKey(event)"  class="form-control crm-form" placeholder="Aadhar No" value="<?php echo (!empty($CustomerInfo['customer_aadhaar'])) ? $CustomerInfo['customer_aadhaar'] : '';?>" maxlength="12">
                                 <div class="error" id="customer_aadhar_error" ></div>
                              </div>
                           </div>
                            <?php } ?>
                            <?php if($CustomerInfo['buyer_type']=='2'){?>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">GSTIN</label>
                                 <input type="text" name="customer_gst" id="customer_gst" class="form-control crm-form" placeholder="GST NO" value="<?php echo (!empty($CustomerInfo['customer_gst'])) ? $CustomerInfo['customer_gst'] : '';?>" maxlength="15">
                                 <div class="error" id="customer_gst_error" ></div>
                              </div>
                           </div>
                           <?php } ?>
                            <?php if($CustomerInfo['buyer_type']=='1'){ 
                                $checked='';
                                if(!empty($CustomerInfo['iscustomerAddress']) && $CustomerInfo['iscustomerAddress']=='1'){
                                   $checked="checked=checked"; 
                                }
                                if(!empty($CustomerInfo['iscustomerAddress']) && $CustomerInfo['iscustomerAddress']=='2'){
                                   $checked=""; 
                                }
                                ?>
                            <div class="col-md-12">
                                <h2 class="sub-title mrg-T5">Correspondence Address</h2>
                            <div class=" form-group"> 
                                 <input type="checkbox" value="1" name="isaddress" id="isaddress" onclick="showAddress();" <?php echo $checked;?> /> 
                                  <label for="isaddress"><span></span> Same As Residence Address </label> 
                           </div>
                                
                                
                          </div>
                            
                           <div id="divnomAdd" <?php if($checked!=''){ echo "style='display:none'";}?>>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Address*</label>
                                 <input type="text" name="nominee_customer_address"  id="nominee_customer_address" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['customer_nominee_address'])) ? $CustomerInfo['customer_nominee_address'] : '';?>" placeholder="Address">
                                 <div class="error" id="nominee_customer_address_error" ></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">City*</label>
                                 <select class="form-control crm-form" name="nominee_customer_city" id="nominee_customer_city">
                                    <option selected="selected" value="">Select City</option>
                                    <?php if(!empty($citylist)){?>
                                    <?php foreach($citylist as $city){?>
                                    <option value="<?php echo $city['city_id'];?>"<?php echo (!empty($CustomerInfo['customer_nominee_city']) && $CustomerInfo['customer_nominee_city']==$city['city_id']) ? "selected=selected" : '';?>><?php echo $city['city_name'];?></option>
                                    <?php }} ?>
                                 </select>
                                 <div class="error" id="nominee_customer_city_error" ></div>
                              </div>
                           </div>   
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Pincode*</label>
                                 <input type="text" name="nominee_customer_pincode"  id="nominee_customer_pincode" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['customer_nominee_pincode'])) ? $CustomerInfo['customer_nominee_pincode'] : '';?>" placeholder="Pincode" maxlength="6">
                                 <div class="error" id="nominee_customer_pincode_error" ></div>
                              </div>
                            </div>
                           
                            </div>     
                                 
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0">Nominee Information</h2>
                            </div>
                                 
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Name*</label>
                                 <input type="text" name="nominee_customer_name" id="nominee_customer_name" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['customer_nominee_name'])) ? $CustomerInfo['customer_nominee_name'] : '';?>" onkeypress="return nameOnly(event)" placeholder="Nominee Name">
                                 <div class="error" id="nominee_customer_name_error" ></div>
                                 </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Relation*</label>
                                 <select class="form-control crm-form" name="nominee_customer_relation" id="nominee_customer_relation">
                                     <option value="">Please Select</option>
                                     <option value="father"<?php echo (!empty($CustomerInfo['customer_nominee_relation']) && $CustomerInfo['customer_nominee_relation']=='father') ? "selected=selected" : '';?>>Father</option>
                                     <option value="mother"<?php echo (!empty($CustomerInfo['customer_nominee_relation']) && $CustomerInfo['customer_nominee_relation']=='mother') ? "selected=selected" : '';?>>Mother</option>
                                     <option value="brother"<?php echo (!empty($CustomerInfo['customer_nominee_relation']) && $CustomerInfo['customer_nominee_relation']=='brother') ? "selected=selected" : '';?>>Brother</option>
                                     <option value="wife"<?php echo (!empty($CustomerInfo['customer_nominee_relation']) && $CustomerInfo['customer_nominee_relation']=='wife') ? "selected=selected" : '';?>>Wife</option>
                                      <option value="husband"<?php echo (!empty($CustomerInfo['customer_nominee_relation']) && $CustomerInfo['customer_nominee_relation']=='husband') ? "selected=selected" : '';?>>Husband</option>
                                      <option value="sibling"<?php echo (!empty($CustomerInfo['customer_nominee_relation']) && $CustomerInfo['customer_nominee_relation']=='sibling') ? "selected=selected" : '';?>>Sibling</option>
                                      <option value="daughter"<?php echo (!empty($CustomerInfo['customer_nominee_relation']) && $CustomerInfo['customer_nominee_relation']=='daughter') ? "selected=selected" : '';?>>Daughter</option>
                                      <option value="guardian"<?php echo (!empty($CustomerInfo['customer_nominee_relation']) && $CustomerInfo['customer_nominee_relation']=='guardian') ? "selected=selected" : '';?>>Guardian</option>
                                      <option value="son"<?php echo (!empty($CustomerInfo['customer_nominee_relation']) && $CustomerInfo['customer_nominee_relation']=='son') ? "selected=selected" : '';?>>Son</option>

                                 </select>
                                 <div class="error" id="nominee_customer_relation_error" ></div>
                                 <div class="d-arrow"></div>
                                 </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="crm-label">Nominee Age*</label>
                                    <select class="form-control crm-form" name="nominee_customer_age" id="nominee_customer_age">
                                     <option value="">Please Select</option>
                                     <?php for($i=18;$i < 80;$i++){  ?>
                                     <option value="<?php echo $i;?>" <?php echo (!empty($CustomerInfo['customer_nominee_age']) && $CustomerInfo['customer_nominee_age']==$i) ? "selected=selected" : '';?>><?php echo $i;?></option>
                                     
                                     <?php } ?>
                                    </select>
                                    <div class="error" id="nominee_customer_age_error" ></div>
                                </div>
                            </div>
                            <?php } ?>
                           <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <?php if(($is_admin=='1') || (($addPerm=='1') && ($mode=='add')) ||  (($editPerm=='1') && ($mode=='edit'))){?>
                                  <input  style="text-align: center" type="button" name="btnform2" id="btnform2" class="btn-continue" value="SAVE AND CONTINUE">
                                  <?php } elseif(($viewPerm=='1') && ($mode=='edit') || (!empty($CustomerInfo['make']))){ ?>
                                  <button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                                  <?php } ?>
                                  <input type="hidden" name="step2" value="true">
                                  <input type="hidden" name="btype" id="btype" value="<?php echo (!empty($CustomerInfo['buyer_type'])) ? $CustomerInfo['buyer_type'] : '';?>">
                                  <input type="hidden" name="customerId" id="customer_id" value="<?php echo isset($customerId) ? $customerId :''; ?>">
                               </div>
                           </div>
                        </div>
                     </div>
                  </div>
                   </form>  
               </div>
            </div>
         </div>
<script>
    $(document).ready(function() {
    <?php if($CustomerInfo['buyer_type']=='1'){ ?>
    CusStartDate =  '-18y';
    <?php } else {?>
    CusStartDate =  'y';    
    <?php } ?>    
    now      = '<?= date('d-m-Y') ?>';
    var d = new Date();
       $('#customer_dob').datepicker({
        format:"dd-mm-yyyy",   
        startDate: '-1000y',
        endDate:CusStartDate,
        autoclose: true,
        todayHighlight: true
    });
    });
    var ani;
    
     </script>
     <script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>
     <script src="<?php echo base_url(); ?>assets/js/insurance_process.js" type="text/javascript"></script>
     <script src="<?php echo base_url(); ?>assets/js/insuranceValidation.js" type="text/javascript"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
     <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_assets/css/sumoselect.min.css">
     <script src="<?php echo base_url(); ?>assets/js/jquery.sumoselect.min.js"></script>
     <script>
           $('#customer_city').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
           $('#nominee_customer_city').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
     </script>