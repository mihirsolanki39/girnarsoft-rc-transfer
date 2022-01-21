<div id="content">
<div class="container-fluid">
               <div class="row">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <h2 class="page-title">Decision</h2>
                     <form method="post" id="decisionLogin" action="">
                     <div class="white-section section-wh">
                        <div class="row item-to-append">
                        <?php
                          if(!empty($loanDetail)){
                          $countTotal = count($loanDetail);
                          if(!empty($CustomerInfo['tag_flag'])){
                            $disf = "2";
                            if($CustomerInfo['tag_flag']=='4')
                            {
                              $disf = "1";
                            }
                          }
                          $i=0;
                          $bankIDs = '';
                          
                          foreach ($loanDetail as $key => $value) { 
                            $decision_date = '';
                          $case_id = $value['case_id'];
                          $logoLink  = '';
                          if(!empty($value['financer_logo']))
                          {
                            $finalogo = explode('-', $value['financer_logo']);
                            $logoLink = BANK_LOGO.$finalogo[0];
                          }
                          $cls = 'filled';
                          if($value['tag_flag']=='2')
                          {
                             $cls = 'approved';
                             $decision_date = $value['approved_date'];
                          }
                          if($value['tag_flag']=='4')
                          {
                             $cls = 'disbursed';
                             $decision_date = $value['approved_date'];
                          }
                          if($value['tag_flag']=='3')
                          {
                             $cls = 'reject';
                             $decision_date = $value['rejected_date'];
                          }
                       
                          $bankIDs .= $value['bank_id'].',';  
                          $i++;                     
                            ?>
                            <div class="col-md-4" id="bankdiv_<?=$i?>">
                              <div class="bank-box">
                                <div class="t-head clearfix add">
                                  <div class="pull-left">
                                    <img src="<?php echo $logoLink;  ?>"  alt="<?=$value['bank_name']?>">  
                                  </div>
                                  <div class="pull-right">
                                 
                                    <ul class="icon-ul">
                                   
                                      <li><span class="xyz_<?=$i?> <?=$cls?> abc_<?=$i?>" <?php if(($value['tag_flag']=='2') && (empty($disbural)) ){ ?> id="approve_<?=$value['id']?>" onclick="showRej(this)" <?php } else if($value['tag_flag']=='3') { ?> id="reject_<?=$value['id']?>" onclick="reloginStatus(this)" <?} ?>  >
                                        <?php if(!empty($value['file_tag'])){ echo $value['file_tag']; } ?>
                                        
                                      </span>
                                      <?php if($disf=='2'){?>
                                      <span class="reject mark-rej" id="rej_<?=$i?>" onclick="relogin(this)" style="display: none" >Re-Login</span>
                                      <span class="reject mark-rej" id="reje_<?=$i?>" onclick="showRej('',this)" style="display: none" >Mark as Reject</span>
                                      <?php } ?>
                                      </li>
                                      <?php //} ?>
                                    </ul>  
                                   
                                  </div>
                                </div>
                                  <div class="t-body clearfix">
                                  <div class="col-50 form-group">
                                    <label class="crm-label">Loan Amount</label> 
                                    <input type="text" class="form-control crm-form loan_amt rupee-icon" name="file_loan_amount[]" id="floanamount_<?=$i?>" placeholder="Enter Amount" value="<?=(empty($value['approved_loan_amt'])? $value['file_loan_amount']:$value['approved_loan_amt'])?>" onkeypress="return isNumberKey(event)" onkeyup="emiCheck(this)" onkeydown="addCommas(this.value, 'floanamount_<?=$i?>');">
                                    <div class="error" id="errfloanamount_<?=$i?>"></div>
                                  </div>
                                  <div class="col-50 form-group">
                                    <label class="crm-label">Tenure <span class="month-t">(In Month)</span></label> 
                                    <input type="text" class="form-control crm-form tenor" placeholder="Enter Tenure" value="<?=(empty($value['approved_tenure'])? $value['file_tenure']:$value['approved_tenure'])?>" name="file_tenor_amount[]" onkeypress="return isNumberKey(event)" id="ftenor_<?=$i?>" onkeyup="emiCheck(this)">
                                        <div class="error" id="errftenor_<?=$i?>"></div>  
                                  </div>
                                  <div class="col-50 form-group">
                                    <label class="crm-label">ROI <span class="month-t">(%)</span></label> 
                                    <input type="text" class="form-control crm-form roi number" placeholder="Enter ROI" value="<?=(empty($value['approved_roi'])? $value['file_roi']:$value['approved_roi'])?>" name="file_roi_amount[]" id="froi_<?=$i?>" maxlength="5"  autocomplete="off" onkeyup="emiCheck(this)" onkeypress="return isRoiNumberKey(event,this)">
                                    <div class="error" id="errfroi_<?=$i?>"></div>
                                  </div>
                                   <div class="col-50 form-group">
                                    <label class="crm-label">EMI</label> 
                                    <input type="text" class="form-control crm-form rupee-icon cr-form-read " id="femi_<?=$i?>" onkeydown="addCommas(this.value, 'femi_<?=$i?>');" placeholder="Enter EMI" value="<?php if(!empty($value['emi'])){ echo $value['emi']; } ?> " readonly="readonly">
                                    <input type="hidden" name="abc[]" value="<?php if(!empty($value['id'])){ echo $value['id']; } ?>" id="editid_<?=$i?>">
                                    <input type="hidden" name="edit_id" value="<?php if(!empty($value['id'])){ echo $value['id']; } ?>" id="edit_<?=$i?>">
                                  </div>
                                  <div class="col-50 form-group" style="width:98%">
                                    <label class="crm-label">Application No<span class="month-t"></span></label> 
                                    <input type="text" class="form-control cr-form-read reff crm-form" placeholder="Enter Application No" value="<?=$value['ref_id']?>" maxlength="5" name="file_ref_id[]" id="fref_<?=$i?>" autocomplete="off" onkeyup="return checkRefnumber(this,<?=$value['id']?>)" onkeypress="return isNumberKey(event)" readonly="readonly">
                                   <div class="error" id="errrefid_<?=$i?>"></div>
                                  </div>
                                  <div class="col-100 form-group" style="width:98%">
                                    <label class="crm-label">Remark <span class="month-t"></span></label> 
                                    <input type="text" class="form-control rmk crm-form" placeholder="Enter Remark" value="<?=$value['decision_remark']?>"   name="file_rmk[]" id="frmk_<?=$i?>" autocomplete="off">
                                   <div class="error" id="errrmk_<?=$i?>"></div>
                                  </div>

                                  <div class="col-50 form-group" style="width:98%">
                                    <label class="crm-label">Decision Date <span class="month-t"></span></label> 
                                   <div class="input-group date" id="dp2_<?=$i?>">
                                <input type="text" class="form-control payment_date crm-form" id="paydates_<?=$i?>" name="file_login_date[]" autocomplete="off" value="<?=(!empty($decision_date)?date('d-m-Y',strtotime($decision_date)):date('d-m-Y'))?>"  placeholder="Filed Date">
                                <span class="input-group-addon">
                                    <span class="">
                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                    </span>
                                </span>
                            </div>
                                   <div class="error" id="errpaydate_<?=$i?>"></div>
                                  </div>

                                   <input type="hidden" name="filedate[]" value="<?=date('d-m-Y',strtotime($value['file_login_date']))?>" id="filedate_<?=$i?>" >
                                  <!-- <div class="col-100 form-group clearfix">
                                         <label class="crm-label">Bank User Remarks</label> 
                                          <textarea class="form-control crm-form" name="cpvremark_<?=$i?>" placeholder="Hello"><?php echo $value['bank_remark']; ?></textarea>
                                         


                                    </div>-->
                                     <input type="hidden" name="mappid_<?=$i?>" value="<?=$value['id']?>" id="mappid_<?=$i?>" >
                                          <input type="hidden" name="mapp_id[]" value="<?=$value['id']?>">
                                          <input type="hidden" id="rejcase_<?=$i?>" name="case_id" value="<?=$value['case_id']?>" >

                                           <input type="hidden" value="<?=$value['tag_flag']?>" name="filetag[]" id="filetag_<?=$i?>">
                                            <input type="hidden" value="" name="remark[]" id="remark_<?=$i?>">
                                            <input type="hidden" value="" name="remark_id[]" id="remarkid_<?=$i?>">
                                            <input type="hidden" name="bnkid" value="<?=$value['bank_id']?>" id="bnkid_<?=$i?>">
                                          <input type="hidden" name="loanbnk" value="<?php if(!empty($value['bank_id'])){ echo $value['bank_id']; } ?>" id="loanbnk_<?=$i?>">
                               <?php if($value['tag_flag']<='1'){ ?>
                                <div class="col-50 form-group">
                                      <a href="javascript:void(0);" id="reject_<?=$value['id']?>" onclick="updateStatus(this)" class="btn-continue abc_<?=$i?>  mrg-R5 btn-reject hidee_<?=$i?>">REJECT</a>
                                  </div>
                                  <div class="col-50 form-group">
                                      <a href="javascript:void(0);" id="approve_<?=$value['id']?>" onclick="updateStatus(this)" class="btn-continue abc_<?=$i?> btn-approved hidee_<?=$i?>">APPROVE</a>
                                  </div>
                                  <?php } ?>
                              </div> </div>
                            </div>
                            <?php  } } ?>                          
                            <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <input type="hidden" name="bank_id" value="<?=((!empty($bankIDs))?trim($bankIDs,','):'');?>" id="bankid">
                                  <input type="hidden" value="1" class="module" name="LeadDecisionForm">
                                   <input type="hidden" name="disbrsal" value="<?=(!empty($disbural))?$disbural:''?>" id="disbrsal">
                                  <input type="hidden" value="<?=$CustomerInfo['customer_id']?>" id="customer_id" name="customer_id">
                                    <input type="hidden" name="case_id" value="<?=$case_id?>" id="caseid">
                                    <input type="hidden" name="countTotal" value="<?=((!empty($countTotal))?$countTotal:'');?>" id="countTotal">

                                  <?php 
                                      $stylesss = 'display:block';
                                      $stylec = 'display:none';
                                      $action = '';
                                    if(((!empty($CustomerInfo['tag_flag']) && ($CustomerInfo['tag_flag']=='4')) && ($rolemgmt[0]['edit_permission']=='0') && (!empty($CustomerInfo['cust_bnk_id']))) || ($rolemgmt[0]['add_permission']=='0') || (($rolemgmt[0]['edit_permission']=='1') && (!empty($CustomerInfo['tag_flag']) && ($CustomerInfo['tag_flag']=='4'))) && (($rolemgmt[0]['role_name']!='admin')))
                                      {
                                        $stylesss  = 'display:none';
                                          $stylec = 'display:block';
                                          $action = base_url('uploadDocs/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]).'/dis';
                                          /*$stylesss  = 'display:none';
                                          $stylec = 'display:block';
                                          $action = base_url('disbursalDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);*/

                                      }
                                      if($CustomerInfo['cancel_id']=='0'){ ?>
                                    <a href="javascript:void(0);" style="<?=$stylesss?>" class="btn-continue saveCont btn-next" id="decisionfile">SAVE AND CONTINUE</a>

                                     <a class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</a>
                                <?php } ?>
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
            <script src="<?php echo base_url(); ?>assets/js/loanLogin.js" type="text/javascript"></script>
      
            <script>
            $(document).on("click","body", function (event) {
                var id = event.target.id;
                var idd = id.split('_');
                //alert(idd[0]);
                if((idd[0]!='approve') && (idd[0]!='reject'))
                {
                 // alert('hiiii');
                  $('.mark-rej').attr('style','display:none');
                }
            });
            </script>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>  
<script>
function checkRefnumber(refids,fileid) {
                var refid = $(refids).attr('id');
                var id = refid.split("_");
                var refval = $('#'+refid).val();
                var sv = $.trim(refval);
                if(sv!=''){
                  checkRefId(sv,id[1],fileid);
                 }
              }
    $(document).ready(function() {

<? $u = 1;
  foreach ($loanDetail as $key => $value) {
  ?>  


         $('#paydates_<?=$u?>').datepicker({
                format: 'dd-mm-yyyy',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
        
 
    
     <? $u++; } ?>
        });
      </script>