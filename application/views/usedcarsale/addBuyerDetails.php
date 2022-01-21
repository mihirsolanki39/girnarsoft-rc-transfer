
<div class="container-fluid">
               <div class="row">
                   <form name="caseform" id="caseform" method="post" action="">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <h2 class="page-title">Buyer Info</h2>
                     <div class="white-section">
                        <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0"></h2>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label class="crm-label">Buyer Type*</label>
                                  <span class="radio-btn-sec">
                                      <input required="true" type="radio" name="buyer_type" id="individual" value="1" class="trigger btype" <?php echo !empty($ucSalesCaseInfo['buyer_type']) && $ucSalesCaseInfo['buyer_type']==1 ? "checked='checked'" : '';?>>
                                     <label for="individual"><span class="dt-yes"></span> Individual</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input required="true" type="radio" name="buyer_type" id="company" value="2" class="trigger btype" <?php echo !empty($ucSalesCaseInfo['buyer_type']) && $ucSalesCaseInfo['buyer_type']==2 ? "checked='checked'" : '';?>>
                                     <label for="company"><span class="dt-yes"></span> Company</label>
                                 </span>
                                 <div class="error" id="buyer_type_error" ></div>
                              </div>
                                
                           </div>
                           
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Mobile No.*</label>
                                 <input required="true" type="text" name="customer_mobile" onkeypress="return validmobileNumber(this);"  id="customer_mobile" class="form-control crm-form" value="<?php echo (!empty($ucSalesCaseInfo['customer_mobile'])) ? $ucSalesCaseInfo['customer_mobile'] : '';?>" placeholder="Mobile" maxlength="10">
                                 <div class="error" id="customer_mobile_error" ></div>
                                 </div>
                            </div>
                             <div class="col-md-6" id="divcustomername" <?php if(!empty($ucSalesCaseInfo['buyer_type']) && $ucSalesCaseInfo['buyer_type']==1) { '';}else { echo "style='display:none'";}?>>
                              <div class="form-group">
                                  <label for="" class="crm-label" id="namechange">Name*</label>
                                 <input required="true" type="text" name="customer_name" id="customer_name" class="form-control crm-form" value="<?php echo (!empty($ucSalesCaseInfo['customer_name'])) ? $ucSalesCaseInfo['customer_name'] : '';?>"  onkeypress="return nameOnly(event)"  placeholder="Name">
                                 <div class="error" id="customer_name_error" ></div>
                                 </div>
                                
                            </div>
                            <div class="col-md-6" id="divcompanyname" <?php if(!empty($ucSalesCaseInfo['buyer_type']) && $ucSalesCaseInfo['buyer_type']==2) { '';}else { echo "style='display:none'";} ?>>
                              <div class="form-group">
                                 <label for="" class="crm-label">Company Name*</label>
                                 <input required="true" type="text" name="customer_company_name" id="customer_company_name" class="form-control crm-form" placeholder="Company Name" value="<?php echo (!empty($ucSalesCaseInfo['company_name'])) ? $ucSalesCaseInfo['company_name'] : '';?>" onkeypress="return blockSpecialChar(event)">
                                 <div class="error" id="customer_company_name_error" ></div>
                              </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Email Id*</label>
                                 <input required="true" type="text" name="customer_email"  id="customer_email" class="form-control crm-form" value="<?php echo (!empty($ucSalesCaseInfo['customer_email'])) ? $ucSalesCaseInfo['customer_email'] : '';?>" placeholder="Email" maxlength="100">
                                 <div class="error" id="customer_email_error" ></div>
                                 </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Address*</label>
                                 <input required="true" type="text" name="customer_address"  id="customer_address" class="form-control crm-form" value="<?php echo (!empty($ucSalesCaseInfo['customer_address'])) ? $ucSalesCaseInfo['customer_address'] : '';?>" placeholder="Address">
                                 <div class="error" id="customer_address_error" ></div>
                              </div>
                            </div>
<!--                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Driving License No</label>
                                 <input type="text" name="driving_license_no"  id="driving_license_no" class="form-control crm-form" value="<?php echo (!empty($ucSalesCaseInfo['customer_driving_lic_no'])) ? $ucSalesCaseInfo['customer_driving_lic_no'] : '';?>" placeholder="Driving License No">
                                 <div class="error" id="driving_license_no_error" ></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Reference Of</label>
                                 <input type="text" name="reference_of"  id="reference_of" class="form-control crm-form" value="<?php echo (!empty($ucSalesCaseInfo['customer_reference'])) ? $ucSalesCaseInfo['customer_reference'] : '';?>" placeholder="Reference Of">
                                 <div class="error" id="reference_of_error" ></div>
                              </div>
                            </div>-->
                    <div class="col-md-12">
                        <h2 class="sub-title first-title">Source</h2>
                    </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Source*</label>
                                 <select required="true" id="lead_source" name="category_source_id" class="form-control crm-form lead_source">
                                       <option value="">Select Category</option>
                                        <?php
                                          if(!empty($category)){
                                            foreach($category as $ckey => $cval){?>
                                            <option value="<?=$cval['id']?>"  <?= !empty($ucSalesCaseInfo) && $ucSalesCaseInfo['source_category_id']==$cval['id']?'selected=selected':''?>><?=$cval['cat_name']?></option>
                                          <?php } }?>
                                    </select>
                                 <div class="error" id="lead_source_error" ></div>
                                
                              </div>
                           </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                 <label class="crm-label">Name</label>
                                     <select class="form-control crm-form lead_source" id="source_name" name="source_id">
                                        <option value="0">Select Name</option>
                                    </select>
                                   
                                     <div class="error" id="err_source_name"></div>
                                </div>
                            </div>
                    <div class="col-md-12">
                        <h2 class="sub-title first-title">Relation</h2>
                    </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Relation</label>
                                 <select class="form-control crm-form" name="customer_relation" id="customer_relation">
                                     <option value="">Please Select</option>
                                     <option value="so"<?php echo (!empty($ucSalesCaseInfo['customer_relation']) && $ucSalesCaseInfo['customer_relation']=='so') ? "selected=selected" : '';?>>Son Of</option>
                                     <option value="do"<?php echo (!empty($ucSalesCaseInfo['customer_relation']) && $ucSalesCaseInfo['customer_relation']=='do') ? "selected=selected" : '';?>>Daughter Of</option>
                                     <option value="wo"<?php echo (!empty($ucSalesCaseInfo['customer_relation']) && $ucSalesCaseInfo['customer_relation']=='wo') ? "selected=selected" : '';?>>Wife Of</option>
                                 </select>
                                 <div class="error" id="customer_relation_error" ></div>
                                 <div class="d-arrow"></div>
                                 </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Relation Name</label>
                                 <input type="text" name="relation_name"  id="relation_name" class="form-control crm-form" value="<?php echo (!empty($ucSalesCaseInfo['customer_relation_name'])) ? $ucSalesCaseInfo['customer_relation_name'] : '';?>" placeholder="Relation Name">
                                 <div class="error" id="relation_name_error" ></div>
                              </div>
                            </div>
<!--                             <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Relation Address</label>
                                 <input type="text" name="relation_address"  id="relation_address" class="form-control crm-form" value="<?php echo (!empty($ucSalesCaseInfo['customer_relation_address'])) ? $ucSalesCaseInfo['customer_relation_address'] : '';?>" placeholder="Relation Address">
                                 <div class="error" id="relation_address_error" ></div>
                              </div>
                            </div>-->
                            <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <input  style="text-align: center" type="button" name="btnform1" id="btnform1" class="btn-continue" value="SAVE AND CONTINUE">
                                  <input type="hidden" name="step1" value="true">
                                  <input type="hidden" name="caseId" id="caseId" value="<?php echo isset($ucSalesCaseInfo['id']) ? $ucSalesCaseInfo['id'] :0; ?>">
                                  <input type="hidden" name="car_id" id="caseId" value="<?php echo isset($ucSalesCaseInfo['car_id']) ? $ucSalesCaseInfo['car_id'] :0; ?>">
                               </div>
                           </div>
                        </div>
                     </div>
                  </div>
                   </form>
               </div>
            </div>
</div></div>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>    
<script src="<?php echo base_url(); ?>assets/js/usedcarsale_process.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/usedcarsaleValidation.js" type="text/javascript"></script>
<?php

if(empty($ucSalesCaseInfo['buyer_type']) && !empty($leadData)){
?>

<script>
$("#individual").prop("checked", true);
$("#customer_mobile").val('<?php echo $leadData['mobile']; ?>');
$("#divcustomername").show();
$("#customer_name").val('<?php echo $leadData['ldm_name']; ?>');



</script>

<?php
}

?>
<script>
    
        $('#lead_source').change(function() {
        var cat_id = $('#lead_source').val();
        
            
        var sel = "<?=(!empty($ucSalesCaseInfo['source_id']))?$ucSalesCaseInfo['source_id']:''?>"
        if(cat_id>0)
        {
            //alert("<?php echo base_url(); ?>" + "Finance/getCustomerDetails/");
            $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "UsedcarPurchase/getSubCatergory/",
            data:{cat_id:cat_id,sel:sel},
            dataType: "html",
            success: function(response) 
            {
                $('#source_name').html(response);
                $('#source_name')[0].sumo.reload();
            }   
            });
        }
        else{
                $('#source_name').html('<option value="0">Select Name</option>');
                $('#source_name')[0].sumo.reload();
        
        }
    });
    $('#lead_source').trigger('change');
    
    $("#customer_mobile").blur(function(){
       var customer_mobile = $(this).val();
       if(customer_mobile != ""){
           
           $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "UsedcarPurchase/getCustomerLeadDetails",
            data:{customer_mobile:customer_mobile},
            dataType: "json",
            success: function(response) 
            {
              $("#customer_name").val(response.ldm_name);
              $("#customer_email").val(response.ldm_email);
            }   
            });
           
       }
       
    })
    
    
</script>
   <link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script>
 $('.lead_source').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
</script>
