<style>
    .hide{ display: none!important; }
</style>

<?php 

$Clearance = !empty($CustomerInfo['customerPartPayments']['4'])? $CustomerInfo['customerPartPayments']['4'] : [] ;
$subamt  = $CustomerInfo['customerPartPayments'][2];
$sum = 0;
$sum1 = 0;
foreach($subamt as $k =>$v)
{
  if($v['payment_by']=='2')
  {
     $sum = (int)$sum + (int)str_replace(',', '', $v['amount']);
  }
}
foreach($Clearance as $ck =>$cv)
{
  if($cv['entry_type']=='4')
  {
     $sum1 = (int)$sum1 + (int)str_replace(',', '', $cv['amount']);
  }
}
$subVent = $sum - $sum1;

$tote = $CustomerInfo['PartPaymentDetails'][0]['totalpremium'];
  $leftam = $CustomerInfo['PartPaymentDetails'][0]['total_amount_paid']; 
  $savem = (int)$tote - (int)$leftam;
$CustomerInfo  = (!empty($change_mode) && $change_mode == 'edit')?  $CustomerInfo  : '' ; 
$CurrentPartPaymentDetails = !empty($CurrentPartPaymentDetails)? current($CurrentPartPaymentDetails): [];
$is_admin=$this->session->userdata['userinfo']['is_admin'];
$addPerm=isset($permission[0]['add_permission']) ? $permission[0]['add_permission'] :'' ;
$editPerm=isset($permission[0]['edit_permission']) ? $permission[0]['edit_permission']:'';
$viewPerm=isset($permission[0]['view_permission']) ? $permission[0]['view_permission'] : '';
$role_name=isset($permission[0]['role_name']) ? $permission[0]['role_name'] : '';
$mode=(!empty($CurrentPartPaymentDetails['payment_by'])) ? 'edit' : 'add';
$stylec = 'display:block';
$action = ($mode=='edit')? base_url().'insPolicyDetails/' . base64_encode('customerId_' . $CurrentPartPaymentDetails["customer_id"]) : '';
$fhse=(!empty($CustomerInfo['customerPartPayments'][2]) ) ? 'inhse' : '';
// die($fhse);
if(!empty($CurrentPartPaymentDetails['amount'])){
   $totpremium=$CurrentPartPaymentDetails['amount'];
}else{
    $totpremium=$totpremium;
}
if(!empty($CurrentPartPaymentDetails['amount'])){
     $totinpremium=$CurrentPartPaymentDetails['amount'];
}else{
    $totinpremium=$totpremium;
}
?>
 <form name="paymentform" id="paymentform" method="post" action="">
                    <!-- <h2 class="page-title mrg-L10">Payment Details</h2> -->
                  <div class="col-md-12">
                     <div id="white-section pad-all-0">
                        <div class="row">

                           <div class="col-md-12">
                             <input type="hidden" name="leftm" id="leftm" value="<?=$leftam?>">
                             <input type="hidden" name="savem" id="savem" value="<?=$savem?>">
                            </div>
                            <?php
                            /*echo "<pre>";
                            print_r($CurrentPartPaymentDetails);
                            exit;*/

                             if( !empty($entrytype) && $entrytype !='4' ){ ?>
                            <div class="col-md-6"  style="height:84px;">
                              <div class="form-group">
                                 <label class="crm-label">Payment By</label>
                                 <!-- <select class="form-control crm-form search_test" name="payment_by" id="customer">
                                    <option selected="selected" value="">Select Payment By</option>
                                    <?php if(!empty(PAYMENT_BY)){?>
                                    <?php foreach(PAYMENT_BY as $pbk => $pbval){?>
                                    <option value="<?php echo $pbk;?>"<?php echo (!empty($CurrentPartPaymentDetails['payment_by']) && $CurrentPartPaymentDetails['payment_by']==$pbk) ? "selected=selected" : '';?>><?php echo ucfirst($pbval);?></option>
                                    <?php }} ?>
                                 </select> -->

                                <?php //if($fhse!='inhse'){?>
                                 <span class="radio-btn-sec" style="width:32%">
                                     <input type="radio" name="payment_by" id="customer" value="1" onclick="return showreason('1');" class="trigger" <?php echo ((!empty($CurrentPartPaymentDetails['payment_by'])) && ($CurrentPartPaymentDetails['payment_by']=='1')) ? "checked=checked" : '';?>>
                                     <label for="customer"><span class="dt-yes"></span> Customer</label>
                                 </span>
                                 <?php //} ?>
                                 <span class="radio-btn-sec" style="width:32%">
                                     <input type="radio" name="payment_by" id="inhouse" value="2" onclick="return showreason('2');" class="trigger"v<?php echo ((!empty($CurrentPartPaymentDetails['payment_by'])) && ($CurrentPartPaymentDetails['payment_by']=='2')) ? "checked=checked" : '';?>>
                                     <label for="inhouse"><span class="dt-yes"></span> In House</label>
                                 </span> 
                                 <?php if(!empty($siscomp)){?>
                                 <span class="radio-btn-sec" style="width:32%">
                                     <input type="radio" name="payment_by" id="sis" value="3" onclick="return showreason('3');" class="trigger" <?php echo ((!empty($CurrentPartPaymentDetails['payment_by'])) && ($CurrentPartPaymentDetails['payment_by']=='3')) ? "checked=checked" : '';?>>
                                     <label for="sis"><span class="dt-yes"></span> <?php echo $siscomp;?></label>
                                 </span>
                                 <?php } ?>
                                 <div class="error" id="payment_by_error" ></div>
                              </div>
                           </div>
                            <?php if($fhse=='inhse' || $fhse==''){ ?>
                            <div class="col-md-6" id="divreason" style="height:84px;">
                              <div class="form-group">
                                 <label for="" class="crm-label">Payment Reason</label>
                                 <select class="form-control crm-form search_test" name="pay_reason" id="pay_reason">
                                    <option selected="selected" value="">Select Reason</option>
                                    <?php if(!empty($payreason)){?>
                                    <?php foreach($payreason as $rs){?>
                                    <option value="<?php echo $rs['reasonId'];?>"<?php echo (!empty($CurrentPartPaymentDetails['reasonId']) && $CurrentPartPaymentDetails['reasonId']==$rs['reasonId']) ? "selected=selected" : '';?>><?php echo ucfirst($rs['reason']);?></option>
                                    <?php }} ?>
                                 </select>
                                 
                              </div>
                              <div class="error" id="pay_reason_error" ></div>
                           </div>
                            <?php } ?>
                            <?php //if($fhse!='inhse'){ ?>
                            <div class="col-md-6 divsisreason" style="height:84px;">
                              <div class="form-group">
                                 <label for="" class="crm-label">Payment Reason</label>
                                 <select class="form-control crm-form search_test" name="pay_sis_reason" id="pay_sis_reason">
                                    <option selected="selected" value="">Select Reason</option>
                                    <?php if(!empty($paysisreason)){?>
                                    <?php foreach($paysisreason as $rs){?>
                                    <option value="<?php echo $rs['reasonId'];?>"<?php echo (!empty($CurrentPartPaymentDetails['sisreasonId']) && ($CurrentPartPaymentDetails['sisreasonId']==$rs['reasonId'])) ? "selected=selected" : '';?>><?php echo ucfirst($rs['reason']);?></option>
                                    <?php }} ?>
                                 </select>
                                 <div class="error" id="pay_sis_reason_error" ></div>
                              </div>
                           </div>
                            <?php //} ?>
                            <div class="col-md-6 divinhouse" style="height:84px;">
                            <div class="form-group">
                                    <label for="" class="crm-label">Payment Mode*</label>
                                    <select class="form-control crm-form " name="in_payment_mode" id="in_payment_mode">
                                        <option value="0">Select</option>
                                        <option value="1" <?php echo (!empty($CurrentPartPaymentDetails['payment_mode']) && $CurrentPartPaymentDetails['payment_mode']=='1') ? "selected=selected": '';?>>Cheque</option>
                                        <option value="2" <?php echo (!empty($CurrentPartPaymentDetails['payment_mode']) && $CurrentPartPaymentDetails['payment_mode']=='2') ? "selected=selected": '';?>>Online</option>
                                        <option value="3" <?php echo (!empty($CurrentPartPaymentDetails['payment_mode']) && $CurrentPartPaymentDetails['payment_mode']=='3') ? "selected=selected": '';?>>Cash</option>
                                        <option value="4" <?php echo (!empty($CurrentPartPaymentDetails['payment_mode']) && $CurrentPartPaymentDetails['payment_mode']=='4') ? "selected=selected": '';?>>DD</option>
  
                                    </select>
                                    <div class="error" id="in_payment_mode_error" ></div>
                             </div>
                            </div>
                            <?php //if($fhse!='inhse'){?>
                            <div class="col-md-6 divpayment" style="height:84px;">
                            <div class="form-group">
                                    <label for="" class="crm-label">Payment Mode*</label>
                                    <select class="form-control crm-form " name="payment_mode" id="payment_mode">
                                      <option value="0">Select</option>
                                        <option value="1" <?php echo (!empty($CurrentPartPaymentDetails['payment_mode']) && $CurrentPartPaymentDetails['payment_mode']=='1') ? "selected=selected": '';?>>Cheque</option>
                                     <option value="2" <?php echo (!empty($CurrentPartPaymentDetails['payment_mode']) && $CurrentPartPaymentDetails['payment_mode']=='2') ? "selected=selected": '';?>>Online</option>
                                     <option value="3" <?php echo (!empty($CurrentPartPaymentDetails['payment_mode']) && $CurrentPartPaymentDetails['payment_mode']=='3') ? "selected=selected": '';?>>Cash</option>
                                     <option value="4" <?php echo (!empty($CurrentPartPaymentDetails['payment_mode']) && $CurrentPartPaymentDetails['payment_mode']=='4') ? "selected=selected": '';?>>DD</option>
                                    </select>
                                    <div class="error" id="payment_mode_error" ></div>
                             </div>
                            </div>
                            <?php //} ?>   
                           <div class="col-md-6 divinhouse" style="height:84px;">
                                <div class="form-group">
                                    <label for="" class="crm-label">Payment Date*</label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1 payment_date" id="in_payment_date" name="in_payment_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CurrentPartPaymentDetails['payment_date']) && $CurrentPartPaymentDetails['payment_date']!='0000-00-00') ? date('d-m-Y',strtotime($CurrentPartPaymentDetails['payment_date'] )): '';?>">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                     </div>
                                    <div class="error" id="in_payment_date_error" ></div>
                               
                            </div>
                            <input type="hidden" name="fhse" id="fhse" value="<?=$fhse?>">
                            <?php //if($fhse!='inhse'){?>
                            <div class="col-md-6 divpayment" style="height:84px;">
                                <div class="form-group">
                                    <label for="" class="crm-label">Payment Date*</label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1 payment_date" id="payment_date" name="payment_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CurrentPartPaymentDetails['payment_date']) && $CurrentPartPaymentDetails['payment_date']!='0000-00-00') ? date('d-m-Y',strtotime($CurrentPartPaymentDetails['payment_date'] )): '';?>">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    </div>
                                    <div class="error" id="payment_date_error" ></div>
                                
                            </div>

                            <div class="col-md-6 divpayment" style="height:84px;">
                            <div class="form-group">
                                    <label for="" class="crm-label">Amount Drawn*</label>
                                    <input type="text" onkeypress="return isNumberKey(event)" name="policy_amt"  id="policy_amt" class="form-control crm-form rupee-icon" value="<?php echo (!empty($totpremium)) ? $totpremium : 0;?>" onkeyup="addCommas(this.value, 'policy_amt');return calAmtdrawn(this.id,'<?php echo $totpremium; ?>',this.value);" placeholder="Amount" maxlength="10">
                                    <input type="hidden"  name="policy_amt_h"  id="policy_amt_h"  value="<?php echo (!empty($totpremium)) ? $totpremium : 0;?>" >
                                    <div class="error" id="policy_amt_error" ></div>
                             </div>
                            </div>


                           <div class="col-md-6 divpayments" style="height:84px;">

                                    <input type="hidden" onkeypress="return isNumberKey(event)" name="subvention_amt"  id="subvention_amt" class="form-control crm-form rupee-icon" value="<?php echo (!empty($CurrentPartPaymentDetails['subvention_amt'])) ? indian_currency_form($CurrentPartPaymentDetails['subvention_amt']) : 0;?>" onkeyup="addCommas(this.value, 'subvention_amt');" placeholder="Subvention Amount" maxlength="10" readonly="readonly">
                            </div>
                            <?php //echo (!empty($CurrentPartPaymentDetails['payment_by']) && ($CurrentPartPaymentDetails['payment_by']=='2')) ? 'style="display:block;"' : 'style="display:none;"';exit; ?>
                            <div class="col-md-6 divinpayment" style="height:84px;">
                            <div class="form-group">
                                    <label for="" class="crm-label">Amount Drawn*</label>
                                    <input type="text" onkeypress="return isNumberKey(event)" name="in_policy_amt"  id="in_policy_amt" class="form-control crm-form rupee-icon" value="<?php echo (!empty($totinpremium)) ? $totinpremium : '';?>" onkeyup="addCommas(this.value, 'in_policy_amt');return calAmtdrawn(this.id,'<?php echo $totinpremium; ?>',this.value);" placeholder="Amount" maxlength="10">
                                    <input type="hidden"  name="in_policy_amt_h"  id="in_policy_amt_h"  value="<?php echo (!empty($totpremium)) ? $totpremium : 0;?>" >
                                   
                                    <div class="error" id="in_policy_amt_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6 divinpayment" style="height:84px;">
                                    <input type="hidden" onkeypress="return isNumberKey(event)" name="subvention_amt"  id="subvention_amt" class="form-control crm-form rupee-icon" value="<?php echo (!empty($CurrentPartPaymentDetails['subvention_amt'])) ? indian_currency_form($CurrentPartPaymentDetails['subvention_amt']) : 0;?>" onkeyup="addCommas(this.value, 'subvention_amt');" placeholder="Subvention Amount" maxlength="10" readonly="readonly">

                             <?php //if($fhse!='inhse'){?>
</div>
                            <div class="col-md-6 divinstrumentno" style="height:84px;">


                            <div class="form-group">
                                    <label for="" class="crm-label">Instrument No</label>
                                    <input type="text" maxlength="30" onkeypress="return blockSpecialChar(event)" name="instrument_no"  id="instrument_no" class="form-control crm-form" value="<?php echo (!empty($CurrentPartPaymentDetails['instrument_no'])) ? $CurrentPartPaymentDetails['instrument_no'] : '';?>" placeholder="Instrument No">
                                    <div class="error" id="cheque_favour_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6 divinstrumentdate" style="height:84px;">
                            <div class="form-group">
                                    <label for="" class="crm-label">Instrument Date</label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1 instrument_date" id="instrument_date" name="instrument_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CurrentPartPaymentDetails['instrument_date']) && $CurrentPartPaymentDetails['instrument_date']!='0000-00-00') ? date('d-m-Y',strtotime($CurrentPartPaymentDetails['instrument_date'] )): '';?>">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="instrument_date_error" ></div>
                                </div>
                            </div>
                            <?php //} ?>


                            <div class="col-md-6 divIninstrumentno" style="height:84px;">


                            <div class="form-group">
                                    <label for="" class="crm-label">Instrument No</label>
                                    <input type="text" maxlength="30" onkeypress="return blockSpecialChar(event)" name="in_instrument_no"  id="in_instrument_no" class="form-control crm-form" value="<?php echo (!empty($CurrentPartPaymentDetails['instrument_no'])) ? $CurrentPartPaymentDetails['instrument_no'] : '';?>" placeholder="Instrument No">
                                    <div class="error" id="in_instrument_no_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6 divIninstrumentdate" style="height:84px;">
                            <div class="form-group">
                                    <label for="" class="crm-label">Instrument Date</label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1 instrument_date in_instrument_date" id="instrument_date" name="in_instrument_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CurrentPartPaymentDetails['instrument_date']) && $CurrentPartPaymentDetails['instrument_date']!='0000-00-00') ? date('d-m-Y',strtotime($CurrentPartPaymentDetails['instrument_date'] )): '';?>">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="instrument_date_error" ></div>
                                </div>
                            </div>
                            <?php //if($fhse!='inhse'){?>
                            <div class="col-md-6 divbank" id="divbank" style="height:84px;">
                              <div class="form-group">
                                 <label for="" class="crm-label">Bank Name </label>
                                 <select class="form-control crm-form search_test testselect1" name="bank_name" id="bank_name">
                                    <option selected="selected" value="">Please Select Bank</option>
                                    <?php if(!empty($banklist)){?>
                                    <?php foreach($banklist as $bnk){?>
                                    <option value="<?php echo $bnk['bank_id'];?>"<?php echo (!empty($CurrentPartPaymentDetails['bank_name']) && $CurrentPartPaymentDetails['bank_name']==$bnk['bank_id']) ? "selected=selected" : '';?>><?php echo ucfirst($bnk['bank_name']);?></option>
                                    <?php }} ?>
                                 </select>
                                 <div class="error" id="bank_name_error" ></div>
                              </div>
                           </div>
                            <?php //} ?>
                            <div class="col-md-6 divinbank" style="height:84px;">
                              <div class="form-group">
                                 <label for="" class="crm-label">Bank Name</label>
                                 <select class="form-control crm-form search_test testselect1" name="in_bank_name" id="in_bank_name">
                                    <option selected="selected" value="">Please Select Bank</option>
                                    <?php if(!empty($banklist)){?>
                                    <?php foreach($banklist as $bnk){?>
                                    <option value="<?php echo $bnk['bank_id'];?>"<?php echo (!empty($CurrentPartPaymentDetails['bank_name']) && $CurrentPartPaymentDetails['bank_name']==$bnk['bank_id']) ? "selected=selected" : '';?>><?php echo ucfirst($bnk['bank_name']);?></option>
                                    <?php }} ?>
                                 </select>
                                 <div class="error" id="bank_name_error" ></div>
                              </div>
                           </div>
                          <?php //if($fhse!='inhse'){?>  
                           <div class="col-md-6 divcheque" style="height:84px;">
                            <div class="form-group">
                                    <label for="" class="crm-label">Favouring </label>
                                    <input type="text" onkeypress="return blockSpecialChar(event)" name="cheque_favour"  id="cheque_favour" class="form-control crm-form" value="<?php echo (!empty($CurrentPartPaymentDetails['favouring_to'])) ? $CurrentPartPaymentDetails['favouring_to'] : (!empty($favouring)? $favouring : '' ) ;?>" placeholder="Favouring">
                                    <div class="error" id="cheque_favour_error" ></div>
                             </div>
                            </div>
                          <?php //} ?>
                            <div class="col-md-6 divincheque" style="height:84px;">
                            <div class="form-group">
                                    <label for="" class="crm-label">Favouring </label>
                                    <input type="text" onkeypress="return blockSpecialChar(event)" name="in_cheque_favour"  id="in_cheque_favour" class="form-control crm-form" value="<?php echo (!empty($CurrentPartPaymentDetails['favouring_to'])) ? $CurrentPartPaymentDetails['favouring_to'] : (!empty($favouring)? $favouring : '' ) ;?> " placeholder="Favouring">
                                    <div class="error" id="cheque_favour_error" ></div>
                             </div>
                            </div>
                            <?php //if($fhse!='inhse'){?>
                            <div class="col-md-6 divreceipt" style="height:84px;">
                            <div class="form-group">
                                    <label for="" class="crm-label">Receipt No</label>
                                    <input type="text" onkeypress="return blockSpecialChar(event)" name="receipt_no"  id="receipt_no" class="form-control crm-form" value="<?php echo (!empty($CurrentPartPaymentDetails['receipt_no'])) ? $CurrentPartPaymentDetails['receipt_no'] : '';?>" placeholder="Receipt No">
                                    <div class="error" id="receipt_no_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6 divreceipt" style="height:84px;">
                                <div class="form-group">
                                    <label for="" class="crm-label">Receipt Date</label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1" id="receipt_date" name="receipt_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CurrentPartPaymentDetails['receipt_date']) && $CurrentPartPaymentDetails['receipt_date']!='0000-00-00') ? date('d-m-Y',strtotime($CurrentPartPaymentDetails['receipt_date'] )): '';?>">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    </div>
                                    <div class="error" id="receipt_date_error" ></div>
                                
                            </div>
                            <?php //} ?>
                            <div class="col-md-6 divremark" style="height:84px;">
                                <div class="form-group">
                                    <label for="" class="crm-label">Payment Remark</label>
                                    <input type="text" name="pay_remark"  id="pay_remark" class="form-control crm-form" value="<?php echo (!empty($CurrentPartPaymentDetails['pay_remark'])) ? $CurrentPartPaymentDetails['pay_remark'] : '';?>" placeholder="Remarks">
                                    <div class="error" id="pay_remark_error" ></div>
                                </div>
                            </div>
                            <div class="col-md-6 divinremark" style="height:84px;">
                                <div class="form-group">
                                    <label for="" class="crm-label">Payment Remark</label>
                                    <input type="text" name="pay_in_remark"  id="pay_in_remark" class="form-control crm-form" value="<?php echo (!empty($CurrentPartPaymentDetails['pay_remark'])) ? $CurrentPartPaymentDetails['pay_remark'] : '';?>" placeholder="Remarks">
                                    <div class="error" id="pay_in_remark_error" ></div>
                                </div>
                            </div>
                            <?php }?>
                         
                           <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <?php //if(($is_admin=='1') || (($addPerm=='1') && ($mode=='add')) ||  (($editPerm=='1') && ($mode=='edit'))){?>
                                   <input  style="text-align: center" type="button" class="btn-continue mrg-B15" name="btnform8" id="btnform8" value="SAVE AND CONTINUE">
                                  <?php// } elseif(($viewPerm=='1') && ($mode=='edit') || (!empty($CurrentPartPaymentDetails['payment_by']))){ ?>
                                  <!--<button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>-->
                                  <?php //} ?>
                                  <input type="hidden" name="step8" value="true">
                                  <input type="hidden" name="totprem" id="totprem" value="<?php echo (!empty($totpremium)) ? $totpremium : '';?>">
                                  <input type="hidden" name="totinprem" id="totinprem" value="<?php echo (!empty($totinpremium)) ? $totinpremium : '';?>">
                                  <input type="hidden" name="insfrm8" id="insfrm8" value="">
                                  <input type="hidden" name="roleType" id="roleType" value="<?php echo $role_name;?>">
                                  <input type="hidden" name="partpaymentid" id="partpaymentid" value="<?php echo $partpaymentid;?>">
                                  <input type="hidden" name="customerId" id="customer_id" value="<?php echo isset($customerId) ? $customerId :''; ?>">
                               </div>
                           </div>
                        </div>
                     </div>
                   
                      
                  </div>
                   </form>
<script src="<?php echo base_url(); ?>assets/js/insurance_process.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/sumoselect.css">
<script src="<?= base_url() ?>assets/js/sumoselect.js"></script>
<script>
   $('.testselect1').SumoSelect({triggerChangeCombined: true, search: true, searchText: 'Search here.'});
</script>
<script type="text/javascript">     
    $(document).ready(function(){
        if($('input[name="payment_by"]').prop('checked') == true){
            $('radio[value="<?php echo $CurrentPartPaymentDetails['payment_by']; ?>"]').click();
         }else{
          $('input[name="payment_by"]').click();
         }
        var id = "<?php echo (!empty($CurrentPartPaymentDetails['payment_by'])) ? $CurrentPartPaymentDetails['payment_by']: '';?>";
        var paymode = "<?php echo (!empty($CurrentPartPaymentDetails['payment_mode'])) ? $CurrentPartPaymentDetails['payment_mode']: '';?>";
        var pmode=$('#payment_mode').val();
        var pimode=$('#in_payment_mode').val();
        var fhse = $('#fhse').val();
        if((paymode!='') && (id=='2')){
            $('#in_payment_mode').val(paymode);
        }else if((paymode!='') && (id!='2')){
            $('#payment_mode').val(paymode);
        }
       if(id=='1'){
        $('.divinhouse').hide(); 
        $('.divinremark').hide(); 
        $('.divIninstrumentno').hide();
        $('.divIninstrumentdate').hide();
        $('.divincheque').hide();
        $('#divreason').hide();
        $('#divsisreason').hide();
        $('.divsisreason').hide();
        $('.divinpayment').hide();
        $('.divinbank').hide();
        $('.divreceipt').show();
        $('.divremark').show();
        $('.divinremark').hide();
        $('.divpayments').hide();
        $('.divpayment').show();
        $('.divreason').hide();
        $('.divpayment').show();

        if(paymode=='1'){           
            $('.divbank').show();
            $('.divbank').removeClass('hide');
            $('.divcheque').show();
            $('.divinstrumentno').show();
            $('.divinstrumentdate').show();
        }
        if(paymode=='2'){           
           $('.divbank').hide();
           $('.divcheque').hide();
           $('.divinstrumentno').show();
           $('.divinstrumentdate').hide();
        }
        if(paymode=='3'){      
          $('.divbank').hide();
          $('.divcheque').hide();
          $('.divinstrumentno').hide();
          $('.divinstrumentdate').hide();
        }
        if(paymode=='4'){
          $('.divbank').show();
          $('.divbank').removeClass('hide');
          $('.divcheque').show();
          $('.divinstrumentno').show();
          $('.divinstrumentdate').show();
        } 
   }
   if(id=='2'){
       $('#divreason').show();
        $('.divreceipt').hide();
        $('.divremark').hide();
        $('.divpayments').hide();
        $('.divpayment').hide();
        $('.divinhouse').show();
        $('.divinpayment').show();
        $('.divinremark').show();
        $('#divbank').attr('style','display:none !important;');
        $('.divinstrumentno').hide();
        $('.divinstrumentdate').hide();
        $('.divbank').attr('style','display:none !important;');
        $('.divbank').addClass('hide');
        if(paymode=='1' || paymode=='4'){
            $('.divinbank').show();
            $('.divbank').hide();
            $('.divcheque').hide();
            $('.divincheque').show();
            $('.divIninstrumentno').show();
            $('.divIninstrumentdate').show();
        }
        if(paymode=='2' || paymode=='3') //online
        {
            $('.divinbank').hide();
            $('.divbank').hide();
            $('.divcheque').hide();
            $('.divincheque').hide();
            $(".in_instrument_date").val("");
            $("#in_bank_name").val("");
            $('#in_bank_name')[0].sumo.reload();
            $('.divIninstrumentno').show();
            $('.divIninstrumentdate').hide();
        }        
   }
   if(id=='3'){
        $('.divinhouse').hide(); 
        $('.divinremark').hide(); 
        $('.divIninstrumentno').hide();
        $('.divIninstrumentdate').hide();
        $('.divincheque').hide();
        $('#divreason').show();
        $('#divsisreason').hide();
        $('.divsisreason').hide();
        $('.divinpayment').hide();
        $('.divinbank').hide();
        $('.divreceipt').hide();
        $('.divremark').show();
        $('.divinremark').hide();
        $('.divpayments').hide();
        $('.divpayment').show();
        $('.divreason').hide();
        $('.divpayment').show();
        
        if(paymode=='1') {           
            $('.divbank').show();
            $('.divcheque').show();
            $('.divinstrumentno').show();
            $('.divinstrumentdate').show();
            $('.divbank').removeClass('hide');
        }
        if(paymode=='2') //online
        {           
           $('.divbank').hide();
           $('.divcheque').hide();
           $('.divinstrumentno').show();
           $('.divinstrumentdate').hide();
        }
        if(paymode=='3') //cash
        {        
          $('.divbank').hide();
          $('.divcheque').hide();
          $('.divinstrumentno').hide();
          $('.divinstrumentdate').hide();
        }
        if(paymode=='4') //dd
        {
          $('.divbank').show();
          $('.divcheque').show();
          $('.divinstrumentno').show();
          $('.divinstrumentdate').show();
          $('.divbank').removeClass('hide');
        }
    }        
    $('[name="payment_by"]').removeAttr('checked');
        if(id != ''){
            $("input[name=payment_by][value=" + id + "]").prop('checked', true);
        }
        $('#payment_by').trigger('click');
    });
</script>
