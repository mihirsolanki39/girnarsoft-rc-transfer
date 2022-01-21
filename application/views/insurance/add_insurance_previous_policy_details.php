<?php
$is_admin=$this->session->userdata['userinfo']['is_admin'];
$addPerm=isset($permission[0]['add_permission']) ? $permission[0]['add_permission'] :'' ;
$editPerm=isset($permission[0]['edit_permission']) ? $permission[0]['edit_permission']:'';
$viewPerm=isset($permission[0]['view_permission']) ? $permission[0]['view_permission'] : '';
$mode=(!empty($CustomerInfo['previous_policy_no'])) ? 'edit' : 'add';
$stylec = 'display:block';
$ins_category=!empty($CustomerInfo['ins_category'])? $CustomerInfo['ins_category']:'0';
if($ins_category=='1'){
$action = ($mode=='edit')? base_url().'inspersonalDetail/' . base64_encode('customerId_' . $CustomerInfo["customer_id"]) : '';       
}elseif($ins_category=='2'){
$action = ($mode=='edit')? base_url().'insInspection/' . base64_encode('customerId_' . $CustomerInfo["customer_id"]) : '';       
}elseif($ins_category=='3'){
$action = ($mode=='edit')? base_url().'inspersonalDetail/' . base64_encode('customerId_' . $CustomerInfo["customer_id"]) : '';   
}else{
$action = ($mode=='edit')? base_url().'inspersonalDetail/' . base64_encode('customerId_' . $CustomerInfo["customer_id"]) : '';       
}
?>
<div class="container-fluid">
               <div class="row">
                   <form name="previousform" id="previousform" method="post" action="">
                    <h2 class="page-title">Previous Policy Details</h2>
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <div class="white-section">
                        <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0">Previous Policy Details</h2>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label for="" class="crm-label">Insurance Company*</label>
                                    <select class="form-control crm-form" name="ins_company" id="ins_company">
                                     <option value="">Please Select</option>
                                     <?php foreach($insurerList as $kcom=>$vcom){?>
                                     <option value="<?=$vcom['prev_policy_insurer_slug']?>"<?php echo (!empty($CustomerInfo['previous_insurance_company']) && $CustomerInfo['previous_insurance_company']==$vcom['prev_policy_insurer_slug']) ? "selected=selected" : '';?>><?php echo $vcom['short_name'] ?></option>
                                     <?php } ?>
                                 </select>
                                    <div class="error" id="ins_company_error" ></div>
                                    <div class="d-arrow"></div>
                             </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label for="" class="crm-label">Policy No.*</label>
                                    <input maxlength="30" type="text" name="previous_policy_no"  id="previous_policy_no" onkeypress="return alpha1only(event);" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['previous_policy_no'])) ? $CustomerInfo['previous_policy_no']:'';?>" placeholder="Policy No">
                                    <div class="error" id="previous_policy_no_error"></div>
                             </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label class="crm-label">Policy Type</label>
                                  <span class="radio-btn-sec">
                                     <input type="radio" name="previous_policy_type" id="comprehensive" value="1" class="trigger" <?php echo (!empty($CustomerInfo['previous_policy_type']) && $CustomerInfo['previous_policy_type']=='1') ? "checked=checked" : '';?> checked="">
                                     <label for="comprehensive"><span class="dt-yes"></span> Comprehensive</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="previous_policy_type" id="third_party" value="2" class="trigger"<?php echo (!empty($CustomerInfo['previous_policy_type']) && $CustomerInfo['previous_policy_type']=='2') ? "checked=checked" : '';?>>
                                     <label for="third_party"><span class="dt-yes"></span> Third Party</label>
                                 </span>
                              </div>
                           </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="crm-label">Inception Date*</label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1" id="previous_issue_date" name="previous_issue_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CustomerInfo['previous_issue_date']) && $CustomerInfo['previous_issue_date']<>'0000-00-00') ? date('d-m-Y',strtotime($CustomerInfo['previous_issue_date'])): '';?>">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="previous_issue_date_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6" style="height:84px;">
                                <div class="form-group">
                                    <label for="" class="crm-label">Due Date*</label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1" id="previous_due_date" name="previous_due_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CustomerInfo['previous_due_date']) && $CustomerInfo['previous_due_date']<>'0000-00-00') ? date('d-m-Y',strtotime($CustomerInfo['previous_due_date'])):'';?>" readonly="readonly">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="previous_due_date_error"></div>
                                </div>
                            </div>
                            <?php if(!empty($qfiterList['claim_taken'])){                                
                                      $tclaim_taken = $qfiterList['claim_taken'];                              
                            }else if(empty($qfiterList['claim_taken']) && !empty($CustomerInfo['previous_claim_taken']))
                                       $tclaim_taken = $CustomerInfo['previous_claim_taken'];
                                ?>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label class="crm-label">Claim Taken in the last Year</label>
                                  <span class="radio-btn-sec">
                                     <input  <?php echo (!empty($tclaim_taken) && $tclaim_taken=='2') ? "disabled=disabled" : '';?> type="radio" name="previous_claim_taken" id="taken" value="1" class="trigger tclaim" <?php echo (!empty($tclaim_taken) && $tclaim_taken=='1') ? "checked=checked" : '';?>>
                                     <label for="taken"><span class="dt-yes"></span> Taken</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input <?php echo (!empty($tclaim_taken) && $tclaim_taken=='1') ? "disabled=disabled" : '';?> type="radio" name="previous_claim_taken" id="notTaken" value="2" class="trigger tclaim" <?php echo (!empty($tclaim_taken) && $tclaim_taken=='2') ? "checked=checked" : '';?>>
                                     <label for="notTaken"><span class="dt-yes"></span> Not Taken</label>
                                 </span>
                                 <div class="error" id="previous_claim_taken_error"></div>
                              </div>
                           </div>

                            <div class="col-md-6" id="divncb" style="<?php echo (!empty($qfiterList['claim_taken']) && $qfiterList['claim_taken']=='2') ? 'display: block' : 'display: none';?>">
                            <div class="form-group">
                                    <label for="" class="crm-label">NCB Discount(%)*</label>
                                    <input type="text" name="previous_ncb_discount"  id="previous_ncb_discount" onkeypress="return isNumberKey(event);" onchange="if(this.value.length > 1) this.value=this.value+'%';" class="form-control crm-form" value="<?php echo (!empty($qfiterList['ncb_discount_prev'])) ? $qfiterList['ncb_discount_prev'].'%':'0%';?>" placeholder="NCB Discount" maxlength="2" readonly="true">
                                    <div class="error" id="previous_ncb_discount_error"></div>
                             </div>
                            </div>
                            
                            
                           <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <?php if(($is_admin=='1') || (($addPerm=='1') && ($mode=='add')) ||  (($editPerm=='1') && ($mode=='edit'))){?>
                                  <input  style="text-align: center" type="button" class="btn-continue" name="btnform4" id="btnform4" value="SAVE AND CONTINUE">
                                  <?php } elseif(($viewPerm=='1') && ($mode=='edit') || (!empty($CustomerInfo['idv']))){ ?>
                                  <button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                                  <?php } ?>
                                  <input type="hidden" name="step4" value="true">
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
         <?php $currentdate=date('d/m/Y');?>
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
         <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_assets/css/sumoselect.min.css">
         <script src="<?php echo base_url(); ?>assets/js/jquery.sumoselect.min.js"></script>
         <script>
           $('#ins_company').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
         </script>
<script>
    $(document).ready(function() {
     StartDate =  '<?=date('d/m/Y',  strtotime($currentdate.' -18 year'));?>';
      now      = '<?= date('d-m-Y') ?>';
       $('#previous_issue_date').datepicker({
        timepicker: false,
        format: 'dd-mm-yyyy',
        startDate: '-1000y',
        endDate:'-305d',
        autoclose: true,
        todayHighlight: true
    });
    });
    
    $(document).ready(function() {

     StartDate =  '<?=date('d/m/Y',  strtotime($currentdate.' -18 year'));?>';
      now      = '<?= date('d-m-Y') ?>';
    $('input[name=previous_issue_date]').change(function() {
    var issueDate=$('#previous_issue_date').val();
    var parts = issueDate.split("-");
    var day = parts[0] && parseInt( parts[0], 10 );
    var month = parts[1] && parseInt( parts[1], 10 );
    var year = parts[2] && parseInt( parts[2], 10 );
    var duration = 1;
    var expiryDate = new Date( year, month - 1, day-1 );
    expiryDate.setFullYear( expiryDate.getFullYear() + duration );
    var day = ( '0' + expiryDate.getDate() ).slice( -2 );
    var month = ( '0' + ( expiryDate.getMonth() + 1 ) ).slice( -2 );
    var year = expiryDate.getFullYear();
    $("#previous_due_date").val( day + "-" + month + "-" + year );
    });
    });
     </script>
    <script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/insurance_process.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/insuranceValidation.js" type="text/javascript"></script>