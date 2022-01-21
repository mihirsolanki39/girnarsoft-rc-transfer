<? //echo "<pre>"; print_r($CustomerInfo); exit;?>
<div class="wrapper center-block col-md-12 mrg-T20">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <h5 class="cases font-24"> Net Disbursal Amount : <i class="fa fa-rupee"></i>
                            <span class="resss gnat"><?=$CustomerInfo['gross_net_amount']?></span>
                        </h5>
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mrg-B0" style="height:85px">
                                <label class="crm-label">Loan Amount</label>
                                <input readonly="true" type="text" onkeypress="return isNumberKey(event)"  name="loan_dis_amt" id="loan_dis_amt" onkeyup="emiCheck(this, '', '1')" maxlength="9" class="form-control crm-form rupee-icon" value="<?= !empty($CustomerInfo['loan_amount']) ? $CustomerInfo['loan_amount'] : 0 ?>" placeholder="0" onkeyup="addCommas(this.value, 'loan_dis_amt');">
                                <!--<div class="d-arrow"></div>-->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mrg-B0" style="height:85px">
                                <label class="crm-label">Loan Gross Amount</label>
                                <input type="text" onkeypress="return isNumberKey(event)" name="gross_loan" id="gross_loan" maxlength="7" class="form-control crm-form rupee-icon" placeholder="0" onkeyup="addCommas(this.value, 'gross_loan');" value="<?= !empty($CustomerInfo['gross_loan']) ? $CustomerInfo['gross_loan'] : $disbur ?>" readonly="readonly">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12"><h2 class="sub-title mrg-T0">Add Ons</h2></div>
                        <div class="col-md-4">
                            <div class="form-group mrg-B0" style="height:85px">
                                <label class="crm-label">GPS</label>
                                <input type="text" onkeypress="return isNumberKey(event);" onchange="chngloanamt(this.value);" name="gps_disburse" id="gps_disburse" maxlength="7" class="form-control crm-form rupee-icon" value="<?= !empty($CustomerInfo['gps_disburse']) ? $CustomerInfo['gps_disburse'] : 0 ?>" placeholder="0" onkeyup="addCommas(this.value, 'gps_disburse');" readonly="readonly">
                                <span class="error" id="err_gps_disburse"></span> 
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mrg-B0" style="height:85px">
                                <label class="crm-label">Loan Suraksha</label>
                                <input type="text" onkeypress="return isNumberKey(event);" onchange="chngloanamt(this.value);" name="loan_disburse" id="loan_disburse" maxlength="7" class="form-control crm-form rupee-icon" value="<?= !empty($CustomerInfo['loan_disburse']) ? $CustomerInfo['loan_disburse'] : 0 ?>" placeholder="0" onkeyup="addCommas(this.value, 'loan_disburse');" readonly="readonly">
                                <span class="error" id="err_loan_disburse"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mrg-B0" style="height:85px">
                                <label class="crm-label">Motor Insurance</label>
                                <input type="text" onkeypress="return isNumberKey(event);" onchange="chngloanamt(this.value);" name="motor_disburse" id="motor_disburse" maxlength="7" class="form-control rupee-icon crm-form" value="<?= !empty($CustomerInfo['motor_disburse']) ? $CustomerInfo['motor_disburse'] : 0 ?>" placeholder="0" onkeyup="addCommas(this.value, 'motor_disburse');" readonly="readonly">
                                <span class="error" id="err_motor_disburse"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mrg-B0" style="height:85px">
                                <label class="crm-label">Extended Warranty</label>
                                <input type="text" onkeypress="return isNumberKey(event);" onchange="chngloanamt(this.value);" name="extend_warranty" id="extend_warranty" maxlength="7" class="form-control rupee-icon crm-form" value="<?= !empty($CustomerInfo['extend_warranty']) ? $CustomerInfo['extend_warranty'] : 0 ?>" placeholder="0" onkeyup="addCommas(this.value, 'extend_warranty');" readonly="readonly">
                                <span class="error" id="err_extend_warranty"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12"><h2 class="sub-title mrg-T0">Deductions</h2></div>
                        <div class="col-md-4">
                            <div class="form-group mrg-B0" style="height:85px">
                                <label class="crm-label">Processing Fee</label>
                                <input type="text" onkeypress="return isNumberKey(event);" onchange="chngloanamt('', this.value);" name="fee_disburse" maxlength="7" id="fee_disburse" class="rupee-icon form-control crm-form" value="<?= !empty($CustomerInfo['fee_disburse']) ? $CustomerInfo['fee_disburse'] : 0 ?>" placeholder="0" onkeyup="addCommas(this.value, 'fee_disburse');" readonly="readonly">
                                <span class="error" id="err_fee_disburse"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mrg-B0" style="height:85px">
                                <label class="crm-label">Other Deductions</label>
                                <input type="text" onkeypress="return isNumberKey(event);" onchange="chngloanamt('', this.value);" name="other_disburse" maxlength="7" id="other_disburse" class="rupee-icon form-control crm-form" value="<?= !empty($CustomerInfo['other_disburse']) ? $CustomerInfo['other_disburse'] : 0 ?>" placeholder="0" onkeyup="addCommas(this.value, 'other_disburse');" readonly="readonly">
                                <span class="error" id="err_other_disburse"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mrg-B0 clearfix pos-rel" style="height:85px">
                                <label class="crm-label">Advance EMI</label>
                                <select class="form-control crm-form emi-drop" name="counter_emi" id="counter_emi" readonly="readonly">
                                    <option value="<?= $CustomerInfo['counter_emi'] ?>" <?= ((isset($CustomerInfo['counter_emi']) && ($CustomerInfo['counter_emi'] == '0')) ? 'selected' : '') ?>><?= $CustomerInfo['counter_emi'] ?></option>
                                </select>
                                <input type="text" name="total_emi" onkeypress="return isNumberKey(event);" onchange="chngloanamt('', this.value)" maxlength="7" id="total_emi" class="rupee-icon form-control crm-form emi-value" value="<?= !empty($CustomerInfo['total_emi']) ? $CustomerInfo['total_emi'] : 0 ?>" placeholder="0" onkeyup="addCommas(this.value, 'total_emi');" readonly="readonly">
                                <span class="error" id="err_total_emi"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mrg-B0" style="height:85px">
                                <label class="crm-label">Existing Loan Settle</label>
                                <input type="text" onkeypress="return isNumberKey(event);" onchange="chngloanamt('', this.value);" name="existing_disburse" maxlength="7" id="existing_disburse" class="rupee-icon form-control crm-form" value="<?= !empty($CustomerInfo['existing_disburse']) ? $CustomerInfo['existing_disburse'] : '' ?>" placeholder="0" onkeyup="addCommas(this.value, 'existing_disburse');" readonly="readonly">
                                <span class="error" id="err_existing_disburse"></span>
                            </div>
                        </div>
                    </div>
<?php //echo "<pre>";print_R($CustomerInfo);die;?>

                    <div class="row">
                        <div class="col-md-12"><h2 class="sub-title mrg-T0">Additional Details</h2></div>
                        <div class="col-md-4">
                            <div class="form-group mrg-B0" style="height:85px">
                                <label class="crm-label">Loan Short Amount</label>
                                <input type="text" name="loan_short" onkeypress="return isNumberKey(event)" maxlength="7" id="loan_short" class="form-control rupee-icon crm-form" value="<?= !empty($CustomerInfo['loan_short']) ? $CustomerInfo['loan_short'] : '' ?>" onkeyup="addCommas(this.value, 'loan_short');" placeholder="0" readonly="readonly">
                                <span class="error" id="err_loan_short"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mrg-B0" style="height:85px">
                                <label class="crm-label">First EMI Date</label>
                                <input type="text" name="daterange_to" id="daterange_to" class="form-control crm-form add-on icon-cal1 new_input" placeholder="Emi Date" value="<?= (!empty($CustomerInfo['first_emi']) && (date('d-m-Y', strtotime($CustomerInfo['first_emi'])) != '01-01-1970')) ? date('d-m-Y', strtotime($CustomerInfo['first_emi'])) : date('d-m-Y') ?>" readonly="readonly">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mrg-B0" style="height:85px">
                                <label class="crm-label">Payout(%)</label>
                                <input type="text" name="payout" onkeypress="return isRoiNumberKey(event, this)" maxlength="5" id="payout" class="form-control crm-form" value="<?= !empty($CustomerInfo['payout']) ? $CustomerInfo['payout'] : 0 ?>" placeholder="0" readonly="readonly">
                                <span class="error" id="err_payout"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mrg-B0" style="height:85px">
                                <label class="crm-label">Remarks</label>
                                <input type="text" name="remark" id="remark" class="form-control crm-form" value="<?= !empty($CustomerInfo['remark']) ? $CustomerInfo['remark'] : '' ?>" placeholder="Remarks" readonly="readonly">
                                <span class="error" id="err_remark"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>