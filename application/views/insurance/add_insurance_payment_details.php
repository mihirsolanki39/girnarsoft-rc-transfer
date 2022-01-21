<?php 
$is_admin=$this->session->userdata['userinfo']['is_admin'];
// echo "<pre>"; print_r($this->session->userdata);die;
$addPerm=isset($permission[0]['add_permission']) ? $permission[0]['add_permission'] :'' ;
$editPerm=isset($permission[0]['edit_permission']) ? $permission[0]['edit_permission']:'';
$viewPerm=isset($permission[0]['view_permission']) ? $permission[0]['view_permission'] : '';
$role_name=isset($permission[0]['role_name']) ? $permission[0]['role_name'] : '';
$mode=(!empty($CustomerInfo['payment_by'])) ? 'edit' : 'add';
$stylec = 'display:block';
$action = ($mode=='edit')? base_url().'insPolicyDetails/' . base64_encode('customerId_' . $CustomerInfo["customer_id"]) : '';
$fhse=(!empty($CustomerInfo['payment_by']) && $CustomerInfo['payment_by']=='2') ? 'inhse' : '';
if(!empty($CustomerInfo['amount'])){
   $totpremium=$CustomerInfo['amount'];
}else{
    $totpremium=$totpremium;
}
if(!empty($CustomerInfo['in_amount'])){
    echo $totinpremium=indian_currency_form($CustomerInfo['in_amount']);
}else{
    $totinpremium=$totpremium;
}
?>

<div class="container-fluid">
               <div class="row">
                   <form name="paymentform" id="paymentform" method="post" action="">
                    <h2 class="page-title mrg-L10">Payment Details</h2>
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <div class="white-section">
                        <div class="row">

                           <div class="col-md-12">
                             
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label class="crm-label">Payment By</label>
                                 <?php if($fhse!='inhse'){?>
                                 <span class="radio-btn-sec" style="width:32%">
                                     <input type="radio" name="payment_by" id="customer" value="1" onclick="return showreason('1');" class="trigger" <?php echo (!empty($CustomerInfo['payment_by']) && $CustomerInfo['payment_by']=='1') ? "checked=checked" : '';?>>
                                     <label for="customer"><span class="dt-yes"></span> Customer</label>
                                 </span>
                                 <?php } ?>
                                 <span class="radio-btn-sec" style="width:32%">
                                     <input type="radio" name="payment_by" id="inhouse" value="2" onclick="return showreason('2');" class="trigger"<?php echo (!empty($CustomerInfo['payment_by']) && $CustomerInfo['payment_by']=='2') ? "checked=checked" : '';?>>
                                     <label for="inhouse"><span class="dt-yes"></span> In House</label>
                                 </span>
                                 <?php if(!empty($siscomp) && ($fhse!='inhse')){?>
                                 <span class="radio-btn-sec" style="width:32%">
                                     <input type="radio" name="payment_by" id="sis" value="3" onclick="return showreason('3');" class="trigger"<?php echo (!empty($CustomerInfo['payment_by']) && $CustomerInfo['payment_by']=='3') ? "checked=checked" : '';?>>
                                     <label for="sis"><span class="dt-yes"></span> <?php echo $siscomp;?></label>
                                 </span>
                                 <?php } ?>
                                 <div class="error" id="payment_by_error" ></div>
                              </div>
                           </div>
                            <?php if($fhse=='inhse' || $fhse==''){ ?>
                            <div class="col-md-6" id="divreason" <?php if(!empty($CustomerInfo['payment_by']) && $CustomerInfo['payment_by']=='2') { } else {?> style="display:none;" <?php }?>>
                              <div class="form-group">
                                 <label for="" class="crm-label">Payment Reason</label>
                                 <select class="form-control crm-form search_test" name="pay_reason" id="pay_reason">
                                    <option selected="selected" value="">Select Reason</option>
                                    <?php if(!empty($payreason)){?>
                                    <?php foreach($payreason as $rs){?>
                                    <option value="<?php echo $rs['reasonId'];?>"<?php echo (!empty($CustomerInfo['reasonId']) && $CustomerInfo['reasonId']==$rs['reasonId']) ? "selected=selected" : '';?>><?php echo ucfirst($rs['reason']);?></option>
                                    <?php }} ?>
                                 </select>
                                 <div class="error" id="pay_reason_error" ></div>
                              </div>
                           </div>
                            <?php } ?>
                            <?php if($fhse!='inhse'){ ?>
                            <div class="col-md-6 divsisreason" <?php if(!empty($CustomerInfo['payment_by']) && $CustomerInfo['payment_by']=='3') { } else {?> style="display:none;" <?php }?>>
                              <div class="form-group">
                                 <label for="" class="crm-label">Payment Reason</label>
                                 <select class="form-control crm-form search_test" name="pay_sis_reason" id="pay_sis_reason">
                                    <option selected="selected" value="">Select Reason</option>
                                    <?php if(!empty($paysisreason)){?>
                                    <?php foreach($paysisreason as $rs){?>
                                    <option value="<?php echo $rs['reasonId'];?>"<?php echo (!empty($CustomerInfo['sisreasonId']) && $CustomerInfo['sisreasonId']==$rs['reasonId']) ? "selected=selected" : '';?>><?php echo ucfirst($rs['reason']);?></option>
                                    <?php }} ?>
                                 </select>
                                 <div class="error" id="pay_sis_reason_error" ></div>
                              </div>
                           </div>
                            <?php } ?>
                            <div class="col-md-6 divinhouse" <?php if(!empty($CustomerInfo['payment_by']) && $CustomerInfo['payment_by']=='2') { } else {?> style="display:none;" <?php }?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Payment Mode*</label>
                                    <select class="form-control crm-form testselect1" name="in_payment_mode" id="in_payment_mode">
                                     <option value="1" <?php echo (!empty($CustomerInfo['in_payment_mode']) && $CustomerInfo['in_payment_mode']=='1') ? "selected=selected": '';?>>Cheque</option>
                                     <option value="2" <?php echo (!empty($CustomerInfo['in_payment_mode']) && $CustomerInfo['in_payment_mode']=='2') ? "selected=selected": '';?>>Online</option>
                                    </select>
                                    <div class="error" id="in_payment_mode_error" ></div>
                             </div>
                            </div>
                            <?php if($fhse!='inhse'){?>
                            <div class="col-md-6 divpayment" <?php if(!empty($CustomerInfo['payment_by']) && in_array($CustomerInfo['payment_by'],array(1,3))) { } else {?> style="display:none;" <?php }?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Payment Mode*</label>
                                    <select class="form-control crm-form testselect1" name="payment_mode" id="payment_mode">
                                        <option value="1" <?php echo (!empty($CustomerInfo['payment_mode']) && $CustomerInfo['payment_mode']=='1') ? "selected=selected": '';?>>Cheque</option>
                                     <option value="2" <?php echo (!empty($CustomerInfo['payment_mode']) && $CustomerInfo['payment_mode']=='2') ? "selected=selected": '';?>>Online</option>
                                     <option value="3" <?php echo (!empty($CustomerInfo['payment_mode']) && $CustomerInfo['payment_mode']=='3') ? "selected=selected": '';?>>Cash</option>
                                     <option value="4" <?php echo (!empty($CustomerInfo['payment_mode']) && $CustomerInfo['payment_mode']=='4') ? "selected=selected": '';?>>DD</option>
                                    </select>
                                    <div class="error" id="payment_mode_error" ></div>
                             </div>
                            </div>
                            <?php } ?>   
                           <div class="col-md-6 divinhouse" <?php echo (!empty($CustomerInfo['payment_by']) && in_array($CustomerInfo['payment_by'],array(2))) ? '' : 'style="display:none;"'; ?>>
                                <div class="form-group">
                                    <label for="" class="crm-label">Payment Date*</label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1" id="in_payment_date" name="in_payment_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CustomerInfo['in_payment_date']) && $CustomerInfo['in_payment_date']!='0000-00-00') ? date('d-m-Y',strtotime($CustomerInfo['in_payment_date'] )): '';?>">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="in_payment_date_error" ></div>
                                </div>
                            </div>
                            <?php if($fhse!='inhse'){?>
                            <div class="col-md-6 divpayment" <?php echo (!empty($CustomerInfo['payment_by']) && in_array($CustomerInfo['payment_by'],array(1,3))) ? '' : 'style="display:none;"'; ?>>
                                <div class="form-group">
                                    <label for="" class="crm-label">Payment Date*</label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1" id="payment_date" name="payment_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CustomerInfo['payment_date']) && $CustomerInfo['payment_date']!='0000-00-00') ? date('d-m-Y',strtotime($CustomerInfo['payment_date'] )): '';?>">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="payment_date_error" ></div>
                                </div>
                            </div>
                            <div class="col-md-6 divpayment" <?php echo (!empty($CustomerInfo['payment_by']) && in_array($CustomerInfo['payment_by'],array(1,3))) ? '' : 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Amount Drawn*</label>
                                    <input type="text" onkeypress="return isNumberKey(event)" name="policy_amt"  id="policy_amt" class="form-control crm-form rupee-icon" value="<?php echo (!empty($totpremium)) ? $totpremium : 0;?>" onkeyup="addCommas(this.value, 'policy_amt');return calAmtdrawn(this.id,'<?php echo $totpremium; ?>',this.value);" placeholder="Amount" maxlength="10">
                                    <div class="error" id="policy_amt_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6 divpayment" <?php echo (!empty($CustomerInfo['payment_by']) && in_array($CustomerInfo['payment_by'],array(1,3))) ? '' : 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Subvention Amount</label>
                                    <input type="text" onkeypress="return isNumberKey(event)" name="subvention_amt"  id="subvention_amt" class="form-control crm-form rupee-icon" value="<?php echo (!empty($CustomerInfo['subvention_amt'])) ? indian_currency_form($CustomerInfo['subvention_amt']) : 0;?>" onkeyup="addCommas(this.value, 'subvention_amt');" placeholder="Subvention Amount" maxlength="10" readonly="readonly">
                                    <div class="error" id="policy_amt_error" ></div>
                             </div>
                            </div>
                            <?php } ?>
                            <div class="col-md-6 divinpayment" <?php echo (!empty($CustomerInfo['payment_by']) && in_array($CustomerInfo['payment_by'],array(2))) ? '' : 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Amount Drawn*</label>
                                    <input type="text" onkeypress="return isNumberKey(event)" name="in_policy_amt"  id="in_policy_amt" class="form-control crm-form rupee-icon" value="<?php echo (!empty($totinpremium)) ? $totinpremium : '';?>" onkeyup="addCommas(this.value, 'in_policy_amt');return calAmtdrawn(this.id,'<?php echo $totinpremium; ?>',this.value);" placeholder="Amount" maxlength="10">
                                    <div class="error" id="in_policy_amt_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6 divinpayment" <?php echo (!empty($CustomerInfo['payment_by']) && in_array($CustomerInfo['payment_by'],array(2))) ? '' : 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Subvention Amount</label>
                                    <input type="text" onkeypress="return isNumberKey(event)" name="in_subvention_amt"  id="in_subvention_amt" class="form-control crm-form rupee-icon" value="<?php echo (!empty($CustomerInfo['in_subvention_amt'])) ? indian_currency_form($CustomerInfo['in_subvention_amt']) : 0;?>" onkeyup="addCommas(this.value, 'in_subvention_amt');" placeholder="Subvention Amount" maxlength="10" readonly="readonly">
                                    <div class="error" id="in_policy_amt_error" ></div>
                             </div>
                            </div>
                            <?php if($fhse!='inhse'){?>
                            <div class="col-md-6 divinstrumentno" <?php echo (!empty($CustomerInfo['payment_mode']) && in_array($CustomerInfo['payment_mode'],array(1,2,4))) ? '': 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Instrument No</label>
                                    <input type="text" maxlength="30" onkeypress="return blockSpecialChar(event)" name="instrument_no"  id="instrument_no" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['instrument_no'])) ? $CustomerInfo['instrument_no'] : '';?>" placeholder="Instrument No">
                                    <div class="error" id="cheque_favour_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6 divinstrumentdate" <?php echo (!empty($CustomerInfo['payment_mode']) && in_array($CustomerInfo['payment_mode'],array(1,4))) ? '': 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Instrument Date</label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1" id="instrument_date" name="instrument_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CustomerInfo['instrument_date']) && $CustomerInfo['instrument_date']!='0000-00-00') ? date('d-m-Y',strtotime($CustomerInfo['instrument_date'] )): '';?>">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="instrument_date_error" ></div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="col-md-6 divIninstrumentno" <?php echo (!empty($CustomerInfo['in_payment_mode']) && in_array($CustomerInfo['in_payment_mode'],array(1,2))) ? '': 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Instrument No</label>
                                    <input type="text" maxlength="30" onkeypress="return blockSpecialChar(event)" name="in_instrument_no"  id="in_instrument_no" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['in_instrument_no'])) ? $CustomerInfo['in_instrument_no'] : '';?>" placeholder="Instrument No">
                                    <div class="error" id="in_instrument_no_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6 divIninstrumentdate" <?php echo (!empty($CustomerInfo['in_payment_mode']) && in_array($CustomerInfo['in_payment_mode'],array(1,2))) ? '': 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Instrument Date</label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1" id="in_instrument_date" name="in_instrument_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CustomerInfo['in_instrument_date']) && $CustomerInfo['in_instrument_date']!='0000-00-00') ? date('d-m-Y',strtotime($CustomerInfo['in_instrument_date'] )): '';?>">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="in_instrument_date_error" ></div>
                                </div>
                            </div>
                            <?php if($fhse!='inhse'){?>
                            <div class="col-md-6 divbank" <?php if(!empty($CustomerInfo['payment_by']) && (in_array($CustomerInfo['payment_by'],array(1,3)) && ($CustomerInfo['payment_mode']=='1'))) { ''; }else { echo 'style="display:none;"'; } ?>>
                              <div class="form-group">
                                 <label for="" class="crm-label">Bank Name </label>
                                 <select class="form-control crm-form search_test" name="bank_name" id="bank_name">
                                    <option selected="selected" value="">Please Select Bank</option>
                                    <?php if(!empty($banklist)){?>
                                    <?php foreach($banklist as $bnk){?>
                                    <option value="<?php echo $bnk['bank_id'];?>"<?php echo (!empty($CustomerInfo['bank_name']) && $CustomerInfo['bank_name']==$bnk['bank_id']) ? "selected=selected" : '';?>><?php echo ucfirst($bnk['bank_name']);?></option>
                                    <?php }} ?>
                                 </select>
                                 <div class="error" id="bank_name_error" ></div>
                                 <div class="d-arrow"></div>
                              </div>
                           </div>
                            <?php } ?>
                            <div class="col-md-6 divinbank" <?php if(!empty($CustomerInfo['payment_by']) && $CustomerInfo['payment_by']=='2' && $CustomerInfo['in_payment_mode']=='1') { }else{ ?> style="display:none;" <?php } ?>>
                              <div class="form-group">
                                 <label for="" class="crm-label">Bank Name</label>
                                 <select class="form-control crm-form search_test" name="in_bank_name" id="in_bank_name">
                                    <option selected="selected" value="">Please Select Bank</option>
                                    <?php if(!empty($banklist)){?>
                                    <?php foreach($banklist as $bnk){?>
                                    <option value="<?php echo $bnk['bank_id'];?>"<?php echo (!empty($CustomerInfo['in_bank_name']) && $CustomerInfo['in_bank_name']==$bnk['bank_id']) ? "selected=selected" : '';?>><?php echo ucfirst($bnk['bank_name']);?></option>
                                    <?php }} ?>
                                 </select>
                                 <div class="error" id="bank_name_error" ></div>
                              </div>
                           </div>
                          <?php if($fhse!='inhse'){?>  
                           <div class="col-md-6 divcheque" <?php echo (!empty($CustomerInfo['payment_mode']) && !empty($CustomerInfo['payment_by']) && (in_array($CustomerInfo['payment_by'],array(1,3))) && in_array($CustomerInfo['payment_mode'],array(1,4))) ? '': 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Favouring </label>
                                    <input type="text" onkeypress="return blockSpecialChar(event)" name="cheque_favour"  id="cheque_favour" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['favouring_to'])) ? $CustomerInfo['favouring_to'] : '';?>" placeholder="Favouring">
                                    <div class="error" id="cheque_favour_error" ></div>
                             </div>
                            </div>
                          <?php } ?>
                            <div class="col-md-6 divincheque" <?php echo (!empty($CustomerInfo['in_payment_mode']) && !empty($CustomerInfo['payment_by']) && ($CustomerInfo['payment_by']=='2') && in_array($CustomerInfo['in_payment_mode'],array(1,4))) ? '': 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Favouring </label>
                                    <input type="text" onkeypress="return blockSpecialChar(event)" name="in_cheque_favour"  id="in_cheque_favour" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['in_favouring_to'])) ? $CustomerInfo['in_favouring_to'] : '';?>" placeholder="Favouring">
                                    <div class="error" id="cheque_favour_error" ></div>
                             </div>
                            </div>
                            <?php if($fhse!='inhse'){?>
                            <div class="col-md-6 divreceipt" <?php echo (!empty($CustomerInfo['payment_by']) && in_array($CustomerInfo['payment_by'],array(1))) ? '' : 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Receipt No</label>
                                    <input type="text" onkeypress="return blockSpecialChar(event)" name="receipt_no"  id="receipt_no" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['receipt_no'])) ? $CustomerInfo['receipt_no'] : '';?>" placeholder="Receipt No">
                                    <div class="error" id="receipt_no_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6 divreceipt" <?php echo (!empty($CustomerInfo['payment_by']) && in_array($CustomerInfo['payment_by'],array(1))) ? '' : 'style="display:none;"'; ?>>
                                <div class="form-group">
                                    <label for="" class="crm-label">Receipt Date</label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1" id="receipt_date" name="receipt_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CustomerInfo['receipt_date']) && $CustomerInfo['receipt_date']!='0000-00-00') ? date('d-m-Y',strtotime($CustomerInfo['receipt_date'] )): '';?>">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="payment_date_error" ></div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="col-md-6 divremark" <?php echo (!empty($CustomerInfo['payment_by']) && in_array($CustomerInfo['payment_by'],array(1))) ? '' : 'style="display:none;"'; ?>>
                                <div class="form-group">
                                    <label for="" class="crm-label">Payment Remark</label>
                                    <input type="text" name="pay_remark"  id="pay_remark" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['pay_remark'])) ? $CustomerInfo['pay_remark'] : '';?>" placeholder="Remarks">
                                    <div class="error" id="pay_remark_error" ></div>
                                </div>
                            </div>
                            <div class="col-md-6 divinremark" <?php echo (!empty($CustomerInfo['payment_by']) && in_array($CustomerInfo['payment_by'],array(2))) ? '' : 'style="display:none;"'; ?>>
                                <div class="form-group">
                                    <label for="" class="crm-label">Payment Remark</label>
                                    <input type="text" name="pay_in_remark"  id="pay_in_remark" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['pay_in_remark'])) ? $CustomerInfo['pay_in_remark'] : '';?>" placeholder="Remarks">
                                    <div class="error" id="pay_in_remark_error" ></div>
                                </div>
                            </div>
                            <?php if($fhse=='inhse' && ($is_admin || (!$is_admin && $viewPerm ) ) ){?>
                            <?php $ispermitted = ($is_admin==true) ? '' : ( (!$is_admin && ( ($mode == 'add' && $addPerm) || ( $mode == 'edit' && $editPerm) )) ? '' : 'disabled="disabled"' ) ; ?>
                            <div class="col-md-12">
                             <h2 class="sub-title mrg-T0">Payment Clearance Details</h2>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label class="crm-label">Payment By</label>
                                 
                                 <span class="radio-btn-sec" style="width:32%">
                                     <input type="radio" name="cpayment_by" id="customer" value="1" onclick="return cshowreason('1');" class="trigger" <?php echo (!empty($CustomerInfo['cpayment_by']) && $CustomerInfo['cpayment_by']=='1') ? "checked=checked" : '';?> <?php echo $ispermitted; ?> >
                                     <label for="customer"><span class="dt-yes"></span> Customer</label>
                                 </span>
                                 <?php if(!empty($siscomp)){?>
                                 <span class="radio-btn-sec" style="width:32%">
                                     <input type="radio" name="cpayment_by" id="sis" value="3" onclick="return cshowreason('3');" class="trigger"<?php echo (!empty($CustomerInfo['cpayment_by']) && $CustomerInfo['cpayment_by']=='3') ? "checked=checked" : '';?> <?php echo $ispermitted; ?> >
                                     <label for="sis"><span class="dt-yes"></span> <?php echo $siscomp;?></label>
                                 </span>
                                 <?php } ?>
                                 <div class="error" id="payment_by_error" ></div>
                              </div>
                           </div>
                            <div class="col-md-6 cdivsisreason" <?php if(!empty($CustomerInfo['cpayment_by']) && $CustomerInfo['cpayment_by']=='3') { } else {?> style="display:none;" <?php }?>>
                              <div class="form-group">
                                 <label for="" class="crm-label">Payment Reason</label>
                                 <select <?php echo $ispermitted; ?> class="form-control crm-form" name="pay_sis_reason" id="pay_sis_reason">
                                    <option selected="selected" value="">Select Reason</option>
                                    <?php if(!empty($paysisreason)){?>
                                    <?php foreach($paysisreason as $rs){?>
                                    <option value="<?php echo $rs['reasonId'];?>"<?php echo (!empty($CustomerInfo['sisreasonId']) && $CustomerInfo['sisreasonId']==$rs['reasonId']) ? "selected=selected" : '';?>><?php echo ucfirst($rs['reason']);?></option>
                                    <?php }} ?>
                                 </select>
                                 <div class="error" id="cpay_reason_error" ></div>
                                 <div class="d-arrow"></div>
                              </div>
                           </div>
                           <div class="col-md-6 cdivpayment" <?php if(!empty($CustomerInfo['cpayment_by']) && in_array($CustomerInfo['cpayment_by'],array(1,3))) { } else {?> style="display:none;" <?php }?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Payment Mode*</label>
                                    <select <?php echo $ispermitted; ?> class="form-control crm-form" name="payment_mode" id="cpayment_mode">
                                        <option value="1" <?php echo (!empty($CustomerInfo['payment_mode']) && $CustomerInfo['payment_mode']=='1') ? "selected=selected": '';?>>Cheque</option>
                                     <option value="2" <?php echo (!empty($CustomerInfo['payment_mode']) && $CustomerInfo['payment_mode']=='2') ? "selected=selected": '';?>>Online</option>
                                     <option value="3" <?php echo (!empty($CustomerInfo['payment_mode']) && $CustomerInfo['payment_mode']=='3') ? "selected=selected": '';?>>Cash</option>
                                     <option value="4" <?php echo (!empty($CustomerInfo['payment_mode']) && $CustomerInfo['payment_mode']=='4') ? "selected=selected": '';?>>DD</option>
                                    </select>
                                    <div class="error" id="cpayment_mode_error" ></div>
                                    <div class="d-arrow"></div>
                             </div>
                            </div>
                           <div class="col-md-6 cdivpayment" <?php echo (!empty($CustomerInfo['cpayment_by']) && in_array($CustomerInfo['cpayment_by'],array(1,3))) ? '' : 'style="display:none;"'; ?>>
                                <div class="form-group">
                                    <label for="" class="crm-label">Payment Date*</label>
                                    <div class="input-group date" id="dp">
                                        <input <?php echo $ispermitted; ?> type="text" class="form-control crm-form crm-form_1" id="payment_date" name="payment_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CustomerInfo['payment_date']) && $CustomerInfo['payment_date']!='0000-00-00') ? date('d-m-Y',strtotime($CustomerInfo['payment_date'] )): '';?>">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="cpayment_date_error" ></div>
                                </div>
                            </div>
                            <div class="col-md-6 cdivpayment" <?php echo (!empty($CustomerInfo['cpayment_by']) && in_array($CustomerInfo['cpayment_by'],array(1,3))) ? '' : 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Amount Drawn*</label>
                                    <input <?php echo $ispermitted; ?> type="text" onkeypress="return isNumberKey(event)" name="policy_amt"  id="cpolicy_amt" class="form-control crm-form rupee-icon" value="<?php echo (!empty($totpremium)) ? $totpremium : '';?>" onkeyup="addCommas(this.value, 'cpolicy_amt');return calAmtdrawn(this.id,'<?php echo $totpremium; ?>',this.value);" placeholder="Amount" maxlength="10">
                                    <div class="error" id="cpolicy_amt_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6 cdivpayment" <?php echo (!empty($CustomerInfo['cpayment_by']) && in_array($CustomerInfo['cpayment_by'],array(1,3))) ? '' : 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Subvention Amount</label>
                                    <input <?php echo $ispermitted; ?> type="text" onkeypress="return isNumberKey(event)" name="subvention_amt"  id="csubvention_amt" class="form-control crm-form rupee-icon" value="<?php echo (!empty($CustomerInfo['subvention_amt'])) ? indian_currency_form($CustomerInfo['subvention_amt']): 0;?>" onkeyup="addCommas(this.value, 'subvention_amt');" placeholder="Subvention Amount" maxlength="10" readonly="readonly">
                                    <div class="error" id="cpolicy_amt_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6 cdivinstrumentno" <?php echo (!empty($CustomerInfo['payment_mode']) && in_array($CustomerInfo['payment_mode'],array(1,2,4))) ? '': 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Instrument No</label>
                                    <input <?php echo $ispermitted; ?> type="text" maxlength="30" onkeypress="return blockSpecialChar(event)" name="instrument_no"  id="instrument_no" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['instrument_no'])) ? $CustomerInfo['instrument_no'] : '';?>" placeholder="Instrument No">
                                    <div class="error" id="cheque_favour_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6 cdivinstrumentdate" <?php echo (!empty($CustomerInfo['payment_mode']) && in_array($CustomerInfo['payment_mode'],array(1,4))) ? '': 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Instrument Date </label>
                                    <div class="input-group date" id="dp">
                                        <input <?php echo $ispermitted; ?> type="text" class="form-control crm-form crm-form_1" id="instrument_date" name="instrument_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CustomerInfo['instrument_date']) && $CustomerInfo['instrument_date']!='0000-00-00') ? date('d-m-Y',strtotime($CustomerInfo['instrument_date'])): '';?>">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="instrument_date_error" ></div>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-6 cdivbank" <?php if(!empty($CustomerInfo['cpayment_by']) && (in_array($CustomerInfo['cpayment_by'],array(1,3)) && ($CustomerInfo['payment_mode']=='1'))) { ''; }else { echo 'style="display:none;"'; } ?>>
                              <div class="form-group">
                                 <label for="" class="crm-label">Bank Name </label>
                                 <select <?php echo $ispermitted; ?> class="form-control crm-form" name="bank_name" id="bank_name">
                                    <option selected="selected" value="">Please Select Bank</option>
                                    <?php if(!empty($banklist)){?>
                                    <?php foreach($banklist as $bnk){?>
                                    <option value="<?php echo $bnk['bank_id'];?>"<?php echo (!empty($CustomerInfo['bank_name']) && $CustomerInfo['bank_name']==$bnk['bank_id']) ? "selected=selected" : '';?>><?php echo ucfirst($bnk['bank_name']);?></option>
                                    <?php }} ?>
                                 </select>
                                 <div class="error" id="cbank_name_error" ></div>
                                 <div class="d-arrow"></div>
                              </div>
                           </div>
                            
                           <div class="col-md-6 cdivcheque" <?php echo (!empty($CustomerInfo['payment_mode']) && !empty($CustomerInfo['cpayment_by']) && (in_array($CustomerInfo['cpayment_by'],array(1,3))) && in_array($CustomerInfo['payment_mode'],array(1,4))) ? '': 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Favouring </label>
                                    <input <?php echo $ispermitted; ?> type="text" onkeypress="return blockSpecialChar(event)" name="cheque_favour"  id="cheque_favour" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['favouring_to'])) ? $CustomerInfo['favouring_to'] : '';?>" placeholder="Favouring">
                                    <div class="error" id="cheque_favour_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6 cdivreceipt" <?php echo (!empty($CustomerInfo['cpayment_by']) && in_array($CustomerInfo['cpayment_by'],array(1))) ? '' : 'style="display:none;"'; ?>>
                            <div class="form-group">
                                    <label for="" class="crm-label">Receipt No</label>
                                    <input <?php echo $ispermitted; ?> type="text" onkeypress="return blockSpecialChar(event)" name="receipt_no"  id="receipt_no" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['receipt_no'])) ? $CustomerInfo['receipt_no'] : '';?>" placeholder="Receipt No">
                                    <div class="error" id="receipt_no_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6 cdivreceipt" <?php echo (!empty($CustomerInfo['cpayment_by']) && in_array($CustomerInfo['cpayment_by'],array(1))) ? '' : 'style="display:none;"'; ?>>
                                <div class="form-group">
                                    <label for="" class="crm-label">Receipt Date </label>
                                    <div class="input-group date" id="dp">
                                        <input <?php echo $ispermitted; ?> type="text" class="form-control crm-form crm-form_1" id="receipt_date" name="receipt_date" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CustomerInfo['receipt_date']) && $CustomerInfo['receipt_date']!='0000-00-00') ? date('d-m-Y',strtotime($CustomerInfo['receipt_date'] )): '';?>">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="cpayment_date_error" ></div>
                                </div>
                            </div>
                            <div class="col-md-6 cdivremark" <?php echo (!empty($CustomerInfo['cpayment_by']) && in_array($CustomerInfo['cpayment_by'],array(1,3))) ? '' : 'style="display:none;"'; ?>>
                                <div class="form-group">
                                    <label for="" class="crm-label">Payment Remark</label>
                                    <input <?php echo $ispermitted; ?>type="text" name="pay_remark"  id="pay_remark" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['pay_remark'])) ? $CustomerInfo['pay_remark'] : '';?>" placeholder="Remarks">
                                    <div class="error" id="cpay_remark_error" ></div>
                                </div>
                            </div>
                           <?php } ?>
                         
                           <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <?php if(($is_admin=='1') || (($addPerm=='1') && ($mode=='add')) ||  (($editPerm=='1') && ($mode=='edit'))){?>
                                   <input  style="text-align: center" type="button" class="btn-continue" name="btnform8" id="btnform8" value="SAVE AND CONTINUE">
                                  <?php } elseif(($viewPerm=='1') && ($mode=='edit') || (!empty($CustomerInfo['payment_by']))){ ?>
                                  <button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                                  <?php } ?>
                                  <input type="hidden" name="step8" value="true">
                                  <input type="hidden" name="totprem" id="totprem" value="<?php echo (!empty($totpremium)) ? $totpremium : '';?>">
                                  <input type="hidden" name="totinprem" id="totinprem" value="<?php echo (!empty($totinpremium)) ? $totinpremium : '';?>">
                                  <input type="hidden" name="insfrm8" id="insfrm8" value="">
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
         <?php $currentdate=date('d/m/Y');?>
<script>
       
    $(document).ready(function() {
        $('#payment_date').datepicker({
        format:"dd-mm-yyyy",   
        startDate: '-1000y',
        endDate:'y',
        autoclose: true,
        todayHighlight: true
    });
    $('#s_payment_date').datepicker({
        format:"dd-mm-yyyy",   
        startDate: '-1000y',
        endDate:'y',
        autoclose: true,
        todayHighlight: true
    });
    $('#in_payment_date').datepicker({
        format:"dd-mm-yyyy",   
        startDate: '-1000y',
        endDate:'y',
        autoclose: true,
        todayHighlight: true
    });
    $('#instrument_date').datepicker({
        format:"dd-mm-yyyy",   
        startDate: '-1000y',
        endDate:'+100y',
        autoclose: true,
        todayHighlight: true
    });
    $('#receipt_date').datepicker({
        format:"dd-mm-yyyy",   
        startDate: '-1000y',
        endDate:'y',
        autoclose: true,
        todayHighlight: true
    });
    $('#in_instrument_date').datepicker({
        format:"dd-mm-yyyy",   
        startDate: '-1000y',
        endDate:'+100y',
        autoclose: true,
        todayHighlight: true
    });
    });
    function calAmtdrawn(id,totamt,val){
        totamt = totamt.replace( /,/g, "" );
        val = val.replace( /,/g, "" );
        if(id=='policy_amt'){
           if(totamt > 0){
               var totprem=$('#totprem').val();
               totprem = totprem.replace( /,/g, "" );
               var svamt=parseInt(totprem)-parseInt(val);
               if(!isNaN(svamt)){
               //svamt=addCommas(svamt, 'policy_amt');
                $('#subvention_amt').val(svamt);
                }
            }
         }else if(id=='in_policy_amt'){
             if(totamt >0){
               var totprem=$('#totinprem').val();
               totprem = totprem.replace( /,/g, "" );
               var svamt=parseInt(totprem)-parseInt(val);
               if(!isNaN(svamt)){
               //svamt=addCommas(svamt, 'in_policy_amt');
                $('#in_subvention_amt').val(svamt);
                }
                }
         }else if(id=='cpolicy_amt'){
             if(totamt >0){
               var totprem=$('#totprem').val();
               totprem = totprem.replace( /,/g, "" );
               var svamt=parseInt(totprem)-parseInt(val);
               if(!isNaN(svamt)){
               //svamt=addCommas(svamt, 'cpolicy_amt');
                $('#csubvention_amt').val(svamt);
                }
                }
         }
    }
     </script>
<script src="<?php echo base_url(); ?>assets/js/insurance_process.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/insuranceValidation.js" type="text/javascript"></script>