<?php
$is_admin=$this->session->userdata['userinfo']['is_admin'];
$addPerm=isset($permission[0]['add_permission']) ? $permission[0]['add_permission'] :'' ;
$editPerm=isset($permission[0]['edit_permission']) ? $permission[0]['edit_permission']:'';
$viewPerm=isset($permission[0]['view_permission']) ? $permission[0]['view_permission'] : '';
$role_name=isset($permission[0]['role_name']) ? $permission[0]['role_name'] : '';
$mode=(!empty($CustomerInfo['mobile'])) ? 'edit' : 'add';
$stylec = 'display:block';
$action = ($mode=='edit')? base_url('insvehicalDetail/').base64_encode('CustomerId_'.$CustomerInfo["customer_id"]) :'';
?>
<div class="container-fluid">
               <div class="row">
                   <form name="caseform" id="caseform" method="post" action="">
                     <h2 class="page-title mrg-L10">Case Info</h2>
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                    
                     <div class="white-section">
                        <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0"></h2>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label class="crm-label">Buyer Type</label>
                                  <span class="radio-btn-sec">
                                     <input type="radio" name="buyer_type" id="individual" value="1" class="trigger btype" <?php echo (!empty($CustomerInfo['buyer_type'])) && $CustomerInfo['buyer_type']=='1' ? "checked='checked'" : '';?>>
                                     <label for="individual"><span class="dt-yes"></span> Individual</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="buyer_type" id="company" value="2" class="trigger btype" <?php echo (!empty($CustomerInfo['buyer_type'])) && $CustomerInfo['buyer_type']=='2' ? "checked='checked'" : '';?>>
                                     <label for="company"><span class="dt-yes"></span> Company</label>
                                 </span>
                                 <div class="error" id="buyer_type_error" ></div>
                              </div>
                                
                           </div>

                            <div class="col-md-6" id="divcustomername" <?php if(!empty($CustomerInfo['buyer_type']) && $CustomerInfo['buyer_type']=='1') { '';}else { echo "style='display:none'";}?>>
                              <div class="form-group">
                                  <label for="" class="crm-label" id="namechange">Name*</label>
                                 <input type="text" name="customer_name" id="customer_name" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['customer_name'])) ? $CustomerInfo['customer_name'] : '';?>"  onkeypress="return nameOnly(event)"  placeholder="Name">
                                 <div class="error" id="customer_name_error" ></div>
                                 </div>
                                
                            </div>
                            <div class="col-md-6" id="divcompanyname" <?php if(!empty($CustomerInfo['buyer_type']) && $CustomerInfo['buyer_type']=='2') { '';}else { echo "style='display:none'";} ?>>
                              <div class="form-group">
                                 <label for="" class="crm-label">Company Name*</label>
                                 <input type="text" name="customer_company_name" id="customer_company_name" class="form-control crm-form" placeholder="Company Name" value="<?php echo (!empty($CustomerInfo['customer_company_name'])) ? $CustomerInfo['customer_company_name'] : '';?>" onkeypress="return blockSpecialChar(event)">
                                 <div class="error" id="customer_company_name_error" ></div>
                              </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Mobile No.*</label>
                                 <input type="text" name="customer_mobile" onkeypress="return validmobileNumber(this);"  id="customer_mobile" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['mobile'])) ? $CustomerInfo['mobile'] : '';?>" placeholder="Mobile" maxlength="10">
                                 <div class="error" id="customer_mobile_error" ></div>
                                 </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Email*</label>
                                 <input type="text" name="customer_email" id="customer_email" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['customer_email'])) ? $CustomerInfo['customer_email'] : '';?>" placeholder="Email">
                                 <div class="error" id="customer_email_error" ></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Insurance Category*</label>
                                 <select class="form-control crm-form" name="ins_category" id="ins_category" onChange="showpolicyexpired();">
                                     <option value="">Please Select</option>
                                     <?php foreach($insCat as $kcat=>$vcat){?>
                                     <option value="<?=$kcat?>"<?php echo (!empty($CustomerInfo['ins_category']) && $CustomerInfo['ins_category']==$kcat) ? "selected=selected" : '';?>><?php echo $vcat ?></option>
                                     <?php } ?>
                                 </select>
                                 <div class="error" id="ins_category_error" ></div>
                                 <div class="d-arrow"></div>
                              </div>
                           </div>

                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="crm-label">MI Funding*</label>
                                  <span class="radio-btn-sec">
                                     <input type="radio" name="mi_funding" id="yesmi" value="1" class="trigger " <?php echo (!empty($CustomerInfo['mi_funding'])) && $CustomerInfo['mi_funding']=='1' ? "checked='checked'" : '';?>>
                                     <label for="yesmi"><span class="dt-yes"></span> Yes</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="mi_funding" id="nomi" value="2" class="trigger " <?php echo (((!empty($CustomerInfo['mi_funding'])) && $CustomerInfo['mi_funding']=='2') || empty($CustomerInfo['mi_funding'])) ? "checked='checked'" : '';?>>
                                     <label for="nomi"><span class="dt-yes"></span> No</label>
                                 </span>
                                 <div class="error" id="mi_funding_error" ></div>
                              </div>
                                
                           </div>
                            <div class="col-md-6" id="ncb_div" style="display:none;">
                              <div class="form-group">
                                 <label class="crm-label">NCB Transfer*</label>
                                  <span class="radio-btn-sec">
                                     <input type="radio" name="ncb_trans" id="yesncb" value="1" class="triggerncb" <?php echo (!empty($CustomerInfo['ncb_transfer'])) && $CustomerInfo['ncb_transfer']=='1' ? "checked='checked'" : '';?>>
                                     <label for="yesncb"><span class="dt-yes"></span> Yes</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="ncb_trans" id="noncb" value="2" class="triggerncb" <?php echo (((!empty($CustomerInfo['ncb_transfer'])) && $CustomerInfo['ncb_transfer']=='2') || empty($CustomerInfo['ncb_transfer'])) ? "checked='checked'" : '';?>>
                                     <label for="noncb"><span class="dt-yes"></span> No</label>
                                 </span>
                                 <div class="error" id="ncb_trans_error" ></div>
                              </div>                                
                           </div>

                           <div class="col-md-12" id="divexpired" <?php echo (!empty($CustomerInfo['ins_category']) && $CustomerInfo['ins_category']=='4') ?  '' : 'style="display:none;"';?>>
                               <div class=" form-group"> 
                                  <input type="checkbox" value="1" name="isexpired" id="isexpired" <?php echo (!empty($CustomerInfo['isexpired']) && $CustomerInfo['isexpired']=='1') ? 'checked="checked"':''; ?> /> 
                                  <label for="isexpired"><span></span> Policy Expiry Date is greater than 90 Days</label> 
                           </div>
                          </div> 
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Source*</label>
                                 <select class="form-control crm-form sou" name="source" id="source">
                                     <option value="">Please Select</option>
                                     <option value="walkin"<?php echo (!empty($CustomerInfo['source']) && $CustomerInfo['source']=='walkin') ? "selected=selected" : '';?>>Walkin</option>
                                     <option value="dealer"<?php echo (!empty($CustomerInfo['source']) && $CustomerInfo['source']=='dealer') ? "selected=selected" : '';?>>Dealer</option>
                                     <option value="callcenter"<?php echo (!empty($CustomerInfo['source']) && $CustomerInfo['source']=='callcenter') ? "selected=selected" : '';?>>Call Center</option>
                                 </select>
                                 <div class="error" id="source_error" ></div>
                              </div>
                           </div>                          
                            <div class="col-md-6" id="divdealerName" <?php echo !empty($CustomerInfo['dealer_id']) && (($CustomerInfo['dealer_id']!='') && ($CustomerInfo['source']=='dealer')) ? '' :'style="display: none;"';?> >
                              <div class="form-group">
                                 <label for="" class="crm-label">Dealer Name*</label>
                                 <select class="form-control crm-form lead_source testselect1" id="dealer_Name" onchange="return salesExecutive(this)" name="dealerName">
                                  <option value="">Please Select Dealer</option>
                                      <?php foreach ($dealerList as $key=>$value){ ?>
                                      <option value="<?=$value['id']?>"  <?php echo (!empty($CustomerInfo['dealer_id']) && ($CustomerInfo['dealer_id']==$value['id'])) ? 'selected=selected' : ''; ?>><?=$value['organization']?>
                                        
                                  </option>
                                  <?php } ?>
                                  </select>                                
                                 <div class="error" id="dealerName_error" ></div>
                                 </div>
                            </div>
                            <div class="col-md-6" id="divsales" <?php echo !empty($CustomerInfo['sales_id']) && $CustomerInfo['sales_id']!='' ? '' :'style="display: none;"';?>>
                              <div class="form-group">
                                 <label for="" class="crm-label">Sales Executive*</label>
                                 <select class="form-control crm-form" name="sales_exec" id="sales_exec">
                                     <option value="">Please Select</option>
                                     <?php foreach ($salesList as $key=>$value){ ?>
                                        <option value="<?=$value['id']?>"<?php echo !empty($CustomerInfo) && $CustomerInfo['sales_id']==$value['id'] ? 'selected=selected' : ''; ?>><?=ucfirst($value['name'])?></option>
                                     <?php } ?>
                                 </select>
                                 <div class="error" id="sales_exec_error" ></div>
                              </div>
                                
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Assign To*</label>
                                 <select class="form-control crm-form" name="assign_to" id="assign_to">
                                     <option value="">Please Select</option>
                                     <?php foreach ($employeeList as $key=>$value){ ?>
                                        <option value="<?=$value['id']?>" <?php echo !empty($CustomerInfo) && $CustomerInfo['assign_to']==$value['id'] ? 'selected=selected' : ''; ?>><?=ucfirst($value['name'])?></option>
                                     <?php } ?>
                                 </select>
                                 <div class="error" id="assign_to_error" ></div>
                              </div>
                           </div>
                            <?php //echo "<pre>";print_r($CustomerInfo);die; ?>
                            <div class="col-md-12">
                             <h2 class="sub-title mrg-T0">Reference Information</h2>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Name</label>
                                 <input type="text" name="reference_customer_name" id="reference_customer_name"  onkeypress="return nameOnly(event)" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['customer_nominee_ref_name'])) ? $CustomerInfo['customer_nominee_ref_name'] : '';?>" placeholder="Reference Name">
                                 <div class="error" id="reference_customer_name_error" ></div>
                                 </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Phone No.</label>
                                 <input type="text" name="reference_customer_mobile" id="reference_customer_mobile"  maxlength="10" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['customer_nominee_ref_phone'])) ? $CustomerInfo['customer_nominee_ref_phone'] : '';?>" placeholder="Reference Mobile" onkeypress="return isNumberKey(this);">
                                 <div class="error" id="reference_customer_mobile_error" ></div>
                                 </div>
                            </div>
                            <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <?php if(($is_admin=='1') || (($addPerm=='1') && ($mode=='add')) ||  (($editPerm=='1') && ($mode=='edit'))){?>
                                   <input  style="text-align: center" type="button" name="btnform1" id="btnform1" class="btn-continue" value="SAVE AND CONTINUE">
                                  <?php } elseif(($viewPerm=='1') && ($mode=='edit') || (!empty($CustomerInfo['make']))){ ?>
                                  <button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                                  <?php } ?>
                                  <input type="hidden" name="step1" value="true">
                                  <input type="hidden" name="roleType" id="roleType" value="<?php echo $role_name;?>">
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
<script src="<?php echo base_url(); ?>assets/js/insuranceValidation.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/insurance_process.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_assets/css/sumoselect.min.css">
<script src="<?php echo base_url(); ?>assets/js/jquery.sumoselect.min.js"></script>
<script>
$('#source').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
$('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
$('#sales_exec').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
$('#assign_to').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
function salesExecutive(ths)
{
  var saleid = $(ths).val();
  if(saleid>='1'){
    $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "DeliveryOrder/getSalesList/",
            data:{saleid:saleid},
            dataType: "json",
            success: function(response) 
            {
              if(response>=1){
                $('#sales_exec').val(response);}
                else
                {
                  $('#sales_exec').val('');
                }
                $('#sales_exec')[0].sumo.reload();
            }
            });
  }
}
</script>
   
