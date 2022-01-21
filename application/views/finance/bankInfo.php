<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 pad-LR-10 mrg-B40">
            <h2 class="page-title">Case Info</h2>
            <div class="white-section">
             <form  enctype="multipart/form-data" method="post"  id="bankForm" name="bankForm">    
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="sub-title mrg-T0">Customer Bank Information</h2>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Bank Name*</label>
                            <select  class="form-control testselect1 crm-form" id="bank_name" name="bank_name" >
                                <option  value="">Select Bank</option>
                                <?php
                                foreach ($bankname as $res) {
                                    ?>
                                <option value="<?= $res['bank_id']; ?>" <?= (!empty($CustomerInfo['custbank']) && $CustomerInfo['custbank']==$res['bank_id'])?'selected=selected':''?>>
                                        <?= $res['bank_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <!--<div class="d-arrow"></div>-->
                             <div class="error" id="err_bank_name"></div>
                        </div>
                        
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Branch Name*</label>
                            <input type="text" class="form-control crm-form" value="<?= !empty($CustomerInfo['custbranch'])?$CustomerInfo['custbranch']:''?>" onkeypress="return blockSpecialChar(event)"  placeholder="Branch Name" id="bank_branch" name="bank_branch" autocomplete="off" >
                            <div class="error" id="err_bank_branch"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Account No.*</label>

                            <input type="text" class="form-control crm-form" value="<?= !empty($CustomerInfo['custacc'])?$CustomerInfo['custacc']:''?>" placeholder="Account No." id="account_no" name="account_no" autocomplete="off" onkeypress="return isNumberKey(event)" maxlength="18">
                            <div class="error" id="err_account_no"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">IFSC Code*</label>
                            <input type="text" onkeypress="return blockSpecialChar(event)" maxlength="11" class="form-control crm-form upperCaseLoan" value="<?= !empty($CustomerInfo['custifci'])?$CustomerInfo['custifci']:''?>" placeholder="UTIB0000007" id="ifsc_code" name="ifsc_code">
                            <div class="error" id="err_ifsc_code"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Account type</label>
                                  <span class="radio-btn-sec">
                                     <input type="radio" name="account_type" id="saving" value="1"  <?php echo (!empty($CustomerInfo['account_type']) && $CustomerInfo['account_type'] == '1') ? 'checked="checked"' : ''; ?>  class="trigger" checked="">
                                     <label for="saving"><span class="dt-yes"></span> Saving</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="account_type" id="current" value="2" <?php echo (!empty($CustomerInfo['account_type']) && $CustomerInfo['account_type'] == '2') ? 'checked="checked"' : ''; ?> class="trigger">
                                     <label for="current"><span class="dt-yes"></span> Current</label>
                                 </span>
                                 <div class="error" id="err_account_type"></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <h2 class="sub-title mrg-T0">Second Account Information</h2>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Bank Name</label>
                            <select  class="form-control testselect2 crm-form" id="bank_name_two" name="bank_name_two" >
                                <option  value="">Select Bank</option>
                                <?php
                                foreach ($bankname as $res) {
                                    ?>
                                <option value="<?= $res['bank_id']; ?>" <?= (!empty($CustomerInfo['custbanktwo']) && $CustomerInfo['custbanktwo']==$res['bank_id'])?'selected=selected':''?>>
                                        <?= $res['bank_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <!--<div class="d-arrow"></div>-->
                             <div class="error" id="err_bank_name_two"></div>
                        </div>
                        
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Branch Name</label>
                            <input type="text" class="form-control crm-form" value="<?= !empty($CustomerInfo['custbranchtwo'])?$CustomerInfo['custbranchtwo']:''?>" onkeypress="return blockSpecialChar(event)"  placeholder="Branch Name" id="bank_branch_two" name="bank_branch_two" autocomplete="off" >
                            <div class="error" id="err_bank_branch_two"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Account No.</label>

                            <input type="text" class="form-control crm-form" value="<?= !empty($CustomerInfo['custacctwo'])?$CustomerInfo['custacctwo']:''?>" placeholder="Account No." id="account_no_two" name="account_no_two" autocomplete="off" onkeypress="return isNumberKey(event)" maxlength="18">
                            <div class="error" id="err_account_no_two"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">IFSC Code</label>
                            <input type="text" onkeypress="return blockSpecialChar(event)" maxlength="11" class="form-control crm-form upperCaseLoan" value="<?= !empty($CustomerInfo['custifcitwo'])?$CustomerInfo['custifcitwo']:''?>" placeholder="UTIB0000007" id="ifsc_code_two" name="ifsc_code_two">
                            <div class="error" id="err_ifsc_code_two"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Account type</label>
                                  <span class="radio-btn-sec">
                                     <input type="radio" name="account_type_two" id="saving_two" value="1"  <?php echo (!empty($CustomerInfo['account_type_two']) && $CustomerInfo['account_type_two'] == '1') ? 'checked="checked"' : ''; ?>  class="trigger" checked="">
                                     <label for="saving_two"><span class="dt-yes"></span> Saving</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="account_type_two" id="current_two" value="2" <?php echo (!empty($CustomerInfo['account_type_two']) && $CustomerInfo['account_type_two'] == '2') ? 'checked="checked"' : ''; ?> class="trigger">
                                     <label for="current_two"><span class="dt-yes"></span> Current</label>
                                 </span>
                                 <div class="error" id="err_account_type_two"></div>
                        </div>
                    </div>
                     <input type="hidden" value="<?= !empty($CustomerInfo['customer_id'])?$CustomerInfo['customer_id']:'' ?>" name="customerId">
                     <input type="hidden" value="<?= !empty($CustomerInfo['cust_bnk_id'])?$CustomerInfo['cust_bnk_id']:'' ?>" name="cust_bnk_id">
                      <input type="hidden" value="<?= !empty($CustomerInfo['customer_loan_id'])?$CustomerInfo['customer_loan_id']:'' ?>" name="caseId" id="case_id">
                    <input type="hidden" name="bankInfoForm" value="1">
                    <input type="hidden" name="rolemgmt" value="<?=(!empty($rolemgmt[0]['role_name'])?$rolemgmt[0]['role_name']:'')?>" id="rolemgmt">
                    <input type="hidden" id='buyertype' name="buyertype" value="<?=!empty($CustomerInfo['Buyer_Type'])?$CustomerInfo['Buyer_Type']:''?>">

                     <input type="hidden" name="is_guaranter" value="<?= !empty($CustomerInfo['guaranter_case'])?$CustomerInfo['guaranter_case']:'' ?>">
                      <input type="hidden" name="is_coapplicant" value="<?= !empty($CustomerInfo['co_applicant'])?$CustomerInfo['co_applicant']:'' ?>">
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
                            $action = base_url('loanFileLogin/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);
                        }*/
                        if(((($rolemgmt[0]['edit_permission']=='0') && (!empty($CustomerInfo['cust_bnk_id']))) || ($rolemgmt[0]['add_permission']=='0')) || ((!empty($CustomerInfo['ref_id'])) && ($rolemgmt[0]['role_name']!='admin') && ($rolemgmt[0]['role_name']!='Loan Admin')))
                            {
                                //echo "kkkkk"; exit;
                                $stylesss  = 'display:none';
                                $stylec = 'display:block';
                                if(!empty($CustomerInfo['co_applicant']) && ($CustomerInfo['co_applicant']=='1')){
                                   $action = base_url('coapplicantDetail/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);
                                }
                                else if(($CustomerInfo['guaranter_case']!='1') && ($CustomerInfo['guaranter_case']=='1')){
                                   $action = base_url('guaranterDetail/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);
                                }
                                else{
                                $action = base_url('uploadDocs/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);
                              }

                            }
                           
                        if(empty($CustomerInfo['cancel_id']) || (!empty($CustomerInfo['cancel_id']) && $CustomerInfo['cancel_id']=='0')){ ?>
                        <button type="button"  class="btn-continue" style="<?=$stylesss?>"  id="bankInfoButton">SAVE AND CONTINUE</button>
                            
                        <button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                        <?php }  ?>
                            
                        </div>
                    </div>
                </div>
             </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-sm" id="chooseRadio" style="display: none;" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-backdrop fade in" style="height: 100%"></div>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header-custom">
            <button type="button" onclick="xclose();" class="close" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg" alt=""></button>
            <h5 class="modal-title" id="exampleModalLabel">Download QDE Sheet</h5>
              
        </div>
      <div class="modal-body">
      <p>Do you wish to download QDE Sheet now?</p>
       </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default stocksms_cancel" data-dismiss="modal" onclick="renderpdfs();" id="ins_cancel">Cancel</button>
    <button type="button" class="btn btn-primary" id="ins_ok" onclick="renderpdfs(<?=$CustomerInfo["customer_loan_id"]?>)" name="ins_ok">Ok</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/jquery.sumoselect.min.js"></script>
<script>
  $('.testselect1').SumoSelect({csvDispCount: 3, search: true, searchText:'Enter here.',triggerChangeCombined: true});  
  $('.testselect2').SumoSelect({csvDispCount: 3, search: true,  searchText:'Enter here.',triggerChangeCombined: true});  
   function xclose()
    {
        $('#chooseRadio').removeClass(' in');
        $('#chooseRadio').attr('style','display:none');
    }

</script>

