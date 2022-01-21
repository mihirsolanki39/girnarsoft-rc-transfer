 <?php //echo "<pre>";
 //print_r($_SESSION);
 //exit; 
 $sy = '' ; 
 if($CustomerInfo['tag_flag']=='4')
 {
  $sy = 'readonly="readonly"';
 }
 ?>
 <div class="container-fluid">
               <div class="row">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <h2 class="page-title">Disbursal</h2>
                     <form method="post" id="disburseLogin" action="">
                     <div class="white-section section-wh">
                        <div class="row">
                         <?php if(!empty($loanDetail)){
                          $i=0;
                          $idSelect='';
                          $bankIDs = '';
                          $counter = count($loanDetail);
                          foreach ($loanDetail as $key => $value) { 
                          $bankIDs .= $value['bank_id'].',';  
                          $case_id = $value['case_id'];
                          $decision_date = '';
                          if($value['tag_flag']=='2')
                          {
                             //$cls = 'approved';
                             $decision_date = $value['approved_date'];
                          }
                          if($value['tag_flag']=='3')
                          {
                            // $cls = 'reject';
                             $decision_date = $value['rejected_date'];
                          }
                          if($value['tag_flag']=='4')
                          {
                             //$cls = 'approved';
                             $decision_date = $value['disbursed_date'];
                          }
                          if(empty($value['disbursed_amount']))
{
 $disbur = (empty($value['approved_loan_amt'])? $value['file_loan_amount']:$value['approved_loan_amt']);
}
else
{
  $disbur = $value['disbursed_amount'];
}
$loan_amount = (empty($value['approved_loan_amt'])? $value['file_loan_amount']:$value['approved_loan_amt']);
$net_dis=(empty($value['gross_net_amount'])?$disbur:$value['gross_net_amount']);
                          $logoLink = '';
                          if(!empty($value['financer_logo']))
                          {
                            $finalogo = explode('-', $value['financer_logo']);
                            $logoLink = BANK_LOGO.$finalogo[0];
                          }
                          $i++; 
                          
                          if(!empty($value['tag_flag']) && $value['tag_flag']=='4')
                          {
                            $idSelect = $i;
                          }      
                            ?>
                         <div class="col-md-4">
                              <div class="bank-box" id="bankdiv_<?=$i?>">
                                <div class="t-head clearfix">
                                  <div class="pull-left">
                                   <img src="<?php echo $logoLink; ?>"  alt="<?=$value['bank_name']?>">    
                                  </div>
                                  <div class="pull-right">
                                    <ul class="icon-ul">
                                     <li><span class="approved <?=(!empty($value['file_tag'])?strtolower($value['file_tag']):'')?> appr_<?=$i?>"  <?php if(empty($disbural)){?> onclick="showRej(this);" <?php } ?> id="app_<?=$i?>"><?=$value['file_tag']?>
                                     <?php if(trim($value['file_tag'])!='Disbursed'){?>
                                      <i class="fa fa-caret-down down-kiki"></i></span>
                                      <?php } ?>
                                      <span class="reject mark-rej" id="reje_<?=$i?>" onclick="showRej('',this)" style="display: none" >Mark as Reject</span>
                                     </li>

                                       </ul>  
                                  </div>
                                </div>
                                  <?php // echo "<pre>";print_r($value);die;?>
                                <div class="t-body clearfix">
                                  <div class="col-50 form-group">
                                    <label class="crm-label">Gross Disb. Amt.</label> 
                                    <input type="text" class="form-control crm-form loan_amt rupee-icon" name="file_loan_amount[]" placeholder="Enter Amount" value="<?=!empty($CustomerInfo['gross_loan'])?$CustomerInfo['gross_loan']:$disbur?>" id="floanamount_<?=$i?>" maxlength="9" onkeypress="return isNumberKey(event)" onkeyup="emiCheck(this)" onkeyup="addCommas(this.value, 'floanamount_<?=$i?>');" readonly="readonly">
                                    <div class="error" id="errfloanamount_<?=$i?>"></div>
                                  </div>
                                    
                                    <div class="col-50 form-group">
                                    <label class="crm-label">Net Disb. Amt.</label> 
                                    <input type="text" class="form-control crm-form rupee-icon cr-form-read " placeholder="Enter Amount" name="net_dis_amount[] " id="grossamount_<?=$i?>" value="<?=(empty($value['gross_net_amount'])? $value['approved_loan_amt']:$value['gross_net_amount'])?>" readonly="readonly">
                                   <a style="pointer-events: initial !important;display: none;" id="sid_<?=$i?>" onclick="showInfoBox(<?=$i?>)"> <i class="fa fa-info-circle info-tool"></i></a>
                                       <div class="info-box" id="infoBox_<?=$i?>">
                                          <div class="info-details">
                                              <div class="row">
                                                  <div class="col-md-10 pull-left disb-txt-heading">
                                                      Deduction amount details
                                                  </div>
                                                  <?php if($_SESSION['userinfo']['is_admin']=='1'){?>
                                                   <div class="col-md-2 text-right edit-txt">
                                                       <a style="pointer-events: initial !important;" href="#">EDIT</a>
                                                  </div>
                                                  <?php } ?>
                                              </div>
                                             
                                              <div class="row">
                                                <div class="col-md-6 width42 mrg-R70">
                                                 
                                               <div class="row mrg-T20">
                                                  <div class="col-md-12 disb-txt-sub-heading">
                                                      Disbursement details
                                                  </div>
                                              </div>
                                               <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Loan Amount</div>
                                                  <div class="col-md-4 text-right resss" id="loan_am_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['loan_amount'])?$CustomerInfo['loan_amount']:$disbur?> </div>
                                              </div>
                                              <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Gross Loan Amount</div>
                                                  <div class="col-md-4 text-right resss" id="dis_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['gross_loan'])?$CustomerInfo['gross_loan']:$disbur?> </div>
                                              </div>
                                              <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Net Disbursed Amount</div>
                                                  <div class="col-md-4 text-right resss" id="netdis_<?=$i?>">&#x20B9;<?=$net_dis?> </div>
                                              </div>
                                         <!--  <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt"></div>
                                                  <div class="col-md-4 text-right resss" id="res_gps_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['gps_disburse'])?$CustomerInfo['gps_disburse']:0?> </div>
                                              </div>
                                               <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Laon Suraksha</div>
                                                  <div class="col-md-4 text-right resss" id="res_loan_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['loan_disburse'])?$CustomerInfo['loan_disburse']:0?> </div>
                                              </div>

                                               <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Motor Insurance</div>
                                                  <div class="col-md-4 text-right resss" id="res_motor_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['motor_disburse'])?$CustomerInfo['motor_disburse']:0?> </div>
                                              </div>
                                               <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Processing Fess</div>
                                                  <div class="col-md-4 text-right resss" id="res_fee_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['fee_disburse'])?$CustomerInfo['fee_disburse']:0?> </div>
                                              </div>
                                               <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Other Deductions</div>
                                                  <div class="col-md-4 text-right resss" id="res_other_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['other_disburse'])?$CustomerInfo['other_disburse']:0?> </div>
                                              </div>
                                               <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Existing Loan Settelment</div>
                                                  <div class="col-md-4 text-right resss" id="res_exist_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['existing_disburse'])?$CustomerInfo['existing_disburse']:0?> </div>
                                              </div>
-->
                                              
                                                </div>
                                                  <div class="col-md-6 width42">
                                                    <div class="row mrg-T20">
                                                  <div class="col-md-12 disb-txt-sub-heading">
                                                      Additional details
                                                  </div>
                                              </div>
                                               <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Loan short amount</div>
                                                  <div class="col-md-4 text-right resss" id="res_short_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['loan_short'])?$CustomerInfo['loan_short']:0?> </div>
                                              </div>
                                              <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">First EMI Date</div>
                                                  <div class="col-md-4 text-right resss" id="res_date_emi_<?=$i?>"><?=!empty($CustomerInfo['first_emi']) && ($CustomerInfo['first_emi']!='01-01-1970')?$CustomerInfo['first_emi']:''?></div>
                                              </div>
                                               <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Payout (%)</div>
                                                  <div class="col-md-4 text-right resss" id="res_payout_<?=$i?>"><?=!empty($CustomerInfo['payout']) && ($CustomerInfo['payout']!='0')?$CustomerInfo['payout']:0?></div>
                                              </div>
                                              <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Remarks</div>
                                                  <div class="col-md-4 text-right resss" id="res_remark_<?=$i?>"><?=!empty($CustomerInfo['remark'])?$CustomerInfo['remark']:''?></div>
                                              </div>
                                             
                                              
                                                  </div>
                                              </div>
                                              
                                               <div class="row">
                                                <div class="col-md-6 width42 mrg-R70">
                                                 
                                               <div class="row mrg-T20">
                                                  <div class="col-md-12 disb-txt-sub-heading">
                                                      Add ons
                                                  </div>
                                              </div>
                                               <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">GPS</div>
                                                  <div class="col-md-4 text-right resss" id="res_gps_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['gps_disburse'])?$CustomerInfo['gps_disburse']:0?> </div>
                                              </div>
                                              <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Loan Surakhsa</div>
                                                  <div class="col-md-4 text-right resss" id="res_loan_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['loan_disburse'])?$CustomerInfo['loan_disburse']:0?> </div>
                                              </div>
                                              <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Motor Insurance</div>
                                                  <div class="col-md-4 text-right resss" id="res_motor_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['motor_disburse'])?$CustomerInfo['motor_disburse']:0?> </div>
                                              </div>
                                              <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Extended Warranty</div>
                                                  <div class="col-md-4 text-right resss" id="res_ext_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['extend_warranty'])?$CustomerInfo['extend_warranty']:0?></div>
                                              </div>
                                              <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Auto Loan Credit Protect</div>
                                                  <div class="col-md-4 text-right resss" id="res_loan_credit_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['loan_credit_protect'])?$CustomerInfo['loan_credit_protect']:0?> </div>
                                              </div>
                                              <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Health Insurance</div>
                                                  <div class="col-md-4 text-right resss" id="res_health_insurance_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['health_insurance'])?$CustomerInfo['health_insurance']:0?> </div>
                                              </div>
                                              </div>
                                                  <div class="col-md-6 width42">
                                                    <div class="row mrg-T20">
                                                  <div class="col-md-12 disb-txt-sub-heading">
                                                      Deductions    
                                                  </div>
                                              </div>
                                               <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Processing Fee</div>
                                                  <div class="col-md-4 text-right resss" id="res_fee_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['fee_disburse'])?$CustomerInfo['fee_disburse']:0?> </div>
                                              </div>
                                              <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Other Deductions</div>
                                                  <div class="col-md-4 text-right resss" id="res_other_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['other_disburse'])?$CustomerInfo['other_disburse']:0?></div>
                                              </div>
                                              <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Advance EMI</div>
                                                  <div class="col-md-4 text-right resss" id="">&#x20B9;<?=!empty($CustomerInfo['total_emi'])?$CustomerInfo['total_emi']:0?></div>
                                              </div>
                                             <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Existing Loan settlement</div>
                                                  <div class="col-md-4 text-right resss" id="res_exist_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['existing_disburse'])?$CustomerInfo['existing_disburse']:0?></div>
                                              </div>
                                              
                                                  </div>
                                              </div>
                                              
                                            <!--  <div class="row mrg-T20">
                                                  <div class="col-md-12 disb-txt-sub-heading">
                                                      Dealer payment details
                                                  </div>
                                              </div>
                                              
                                          
                                          
                                          
                                               <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">Processing Fess</div>
                                                  <div class="col-md-4 text-right resss" id="res_pro_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['processing_disburse'])?$CustomerInfo['processing_disburse']:0?> </div>
                                              </div>
                                              
                                               <div class="row mrg-T10">
                                                  <div class="col-md-8 det-txt">RC Transfer Charges</div>
                                                  <div class="col-md-4 text-right resss" id="res_rc_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['rc_disburse'])?$CustomerInfo['rc_disburse']:0?> </div>
                                              </div>
                                              
                                               <div class="row mrg-T20">
                                                  <div class="bord-top">
                                                      
                                                  </div>
                                              </div>
                                              
                                            <div class="row mrg-T20  disb-txt-sub-heading">
                                                  <div class="col-md-8 disb-txt-sub-heading">Total Amount</div>
                                                  <div class="col-md-4 text-right"><strong id="res_amount_<?=$i?>">&#x20B9;<?=!empty($CustomerInfo['total_amount'])?$CustomerInfo['total_amount']:0?> </strong></div>
                                              </div>-->
                                              
                                              
                                           </div>
                                        </div>

                                  </div>
                                  <div class="col-50 form-group">
                                    <label class="crm-label">Tenure <span class="month-t">(In Month)</span></label> 
                                     <input type="text" class="form-control crm-form tenor" placeholder="Enter Tenure" value="<?=(!empty($value['disbursed_tenure'])?$value['disbursed_tenure']:(empty($value['approved_tenure'])? $value['file_tenure']:$value['approved_tenure']))?>" onkeypress="return isNumberKey(event)" name="file_tenor_amount[]" id="ftenor_<?=$i?>" onkeyup="emiCheck(this)"> 
                                     <div class="error" id="errftenor_<?=$i?>"></div>
                                  </div>
                                  <div class="col-50 form-group">
                                    <label class="crm-label">ROI <span class="month-t">(%)</span></label> 
                                     <input type="text" class="form-control crm-form number" placeholder="Enter ROI" value="<?=(!empty($value['disbursed_roi'])?$value['disbursed_roi']:(empty($value['approved_roi'])? $value['file_roi']:$value['approved_roi']))?>" name="file_roi_amount[]" id="froi_<?=$i?>"  maxlength="5"  autocomplete="off" onkeyup="emiCheck(this)" onkeypress="return isRoiNumberKey(event,this)">
                                      <div class="error" id="errfroi_<?=$i?>"></div>
                                  </div>
                                   <div class="col-50 form-group">
                                    <label class="crm-label">EMI</label> 
                                     <input type="text" class="form-control crm-form rupee-icon cr-form-read" id="femi_<?=$i?>" onkeydown="addCommas(this.value, 'femi_<?=$i?>');" placeholder="Enter EMI" value="<?php if(!empty($value['emi'])){ echo $value['emi']; } ?>" name="file_emi[]" readonly="readonly">
                                     
                                    <input type="hidden" name="abc[]" value="<?php if(!empty($value['id'])){ echo $value['id']; } ?>" id="editid_<?=$i?>">
                                    <input type="hidden" name="edit_id" value="<?php if(!empty($value['id'])){ echo $value['id']; } ?>" id="edit_<?=$i?>">
                                  </div>
                                  <div class="col-50 form-group">
                                    <label class="crm-label">Application No</label> 
                                    <input type="text" onkeypress="return isNumberKey(event)"  class="form-control crm-form cr-form-read" placeholder="Application No" maxlength="6" onkeyup="return checkRefnumber(this,<?=$value['id']?>)" value="<?=$value['ref_id']?>" name="ref_id[]" id="refid_<?=$i?>" readonly="readonly">
                                    <div class="error" id="errrefid_<?=$i?>" ></div>
                                  </div>
                                 <div class="col-50 form-group">
                                    <label class="crm-label">Loan No / LOS No</label> 
                                    <input type="text"  class="form-control crm-form cr-form-read" placeholder="Loan No / LOS No" onkeyup="return checkRefnumber(this,<?=$value['id']?>,'1')" value="<?= (!empty($value['loanno']))?$value['loanno']: ''?>" name="loanno[]" id="loanno_<?=$i?>" <?=$sy?>>
                                    <div class="error" id="errloannoid_<?=$i?>"></div>
                                  </div>
                                  <div class="col-100 form-group" style="width:98%;margin-top:5px">
                                    <label class="crm-label">Remark <span class="month-t"></span></label> 
                                    <input type="text" class="form-control rmk crm-form" placeholder="Enter Remark" value="<?=!empty($CustomerInfo['remark'])?$CustomerInfo['remark']:''?>"   name="file_rmk[]" id="frmk_<?=$i?>" autocomplete="off" <?=$sy?>>
                                   <div class="error" id="errrmk_<?=$i?>"></div>
                                  </div>

                                  <div class="col-50 form-group" style="width:98%">
                                    <label class="crm-label">Disbursal Date <span class="month-t"></span></label> 
                                   <div class="input-group date" id="dp2_<?=$i?>">
                                <input type="text" class="form-control payment_date crm-form" id="paydates_<?=$i?>" name="file_login_date[]" autocomplete="off" value="<?=(!empty($value['disbursed_date'] && ($value['disbursed_date']!='0000-00-00 00:00:00'))?date('d-m-Y',strtotime($value['disbursed_date'])):date('d-m-Y'))?>"  placeholder="Filed Date">
                                <span class="input-group-addon">
                                    <span class="">
                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                    </span>
                                </span>
                            </div>
                                   <div class="error" id="errpaydate_<?=$i?>"></div>
                                  </div>
                                    <input type="hidden" name="filedate[]" value="<?=date('d-m-Y',strtotime($decision_date))?>" id="filedate_<?=$i?>" >
                                  <!--<div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="crm-label">Select RTO Requirements</label> 
                                        </div>
                                  </div>
                                    
                              <div class="form-group row">  
                                  <div class="col-md-4">
                                      <label class="crm-label disp-in">HPT</label>
                                  </div>
                                   <div class="col-md-4">
                                      <div class="form-group">
                                        
                                          <span class="">
                                             <input type="radio" name="htptype_<?=$i?>" id="htp-y_<?=$i?>" value="1" <?php echo ($value['htp_flag'] == '1') ? 'checked="checked"' : ''; ?> class="trigger" checked="">
                                             <label for="htp-y_<?=$i?>"><span class="dt-yes"></span> Yes</label>
                                         </span>
                                       
                                      </div>
                                  </div>
                                   <div class="col-md-4">
                                      <div class="form-group">
                                       
                                         <span class="">
                                             <input type="radio" name="htptype_<?=$i?>" id="htp-n_<?=$i?>" value="0" <?php echo ($value['htp_flag'] == '0') ? 'checked="checked"' : ''; ?> class="trigger">
                                             <label for="htp-n_<?=$i?>"><span class="dt-yes"></span> No</label>
                                         </span>
                                      </div>
                                  </div>
                              </div>
                                    
                                     <div class="form-group row">  
                                  <div class="col-md-4">
                                      <label class="crm-label disp-in">TO</label>
                                  </div>
                                   <div class="col-md-4">
                                      <div class="form-group">
                                        
                                          <span class="">
                                             <input type="radio" name="totype_<?=$i?>" id="to-y_<?=$i?>" value="1" <?php echo ($value['to_flag'] == '1') ? 'checked="checked"' : ''; ?> class="trigger" checked="">
                                             <label for="to-y_<?=$i?>"><span class="dt-yes"></span> Yes</label>
                                         </span>
                                       
                                      </div>
                                  </div>
                                   <div class="col-md-4">
                                      <div class="form-group">
                                       
                                         <span class="">
                                             <input type="radio" name="totype_<?=$i?>" id="to-n_<?=$i?>" value="0" <?php echo ($value['to_flag'] == '0') ? 'checked="checked"' : ''; ?> class="trigger">
                                             <label for="to-n_<?=$i?>"><span class="dt-yes"></span> No</label>
                                         </span>
                                      </div>
                                  </div>
                              </div>
                                  
                                     <div class="form-group row">  
                                  <div class="col-md-4">
                                      <label class="crm-label disp-in">HPA</label>
                                  </div>
                                   <div class="col-md-4">
                                      <div class="form-group">
                                        
                                          <span class="">
                                             <input type="radio" name="hpatype_<?=$i?>" id="hpa-y_<?=$i?>" value="1" <?php echo ($value['hpa_flag'] == '1') ? 'checked="checked"' : ''; ?> class="trigger" checked="">
                                             <label for="hpa-y_<?=$i?>"><span class="dt-yes"></span> Yes</label>
                                         </span>
                                       
                                      </div>
                                  </div>
                                   <div class="col-md-4">
                                      <div class="form-group">
                                       
                                         <span class="">
                                             <input type="radio" name="hpatype_<?=$i?>" id="hpa-n_<?=$i?>" value="0" <?php echo ($value['hpa_flag'] == '0') ? 'checked="checked"' : ''; ?> class="trigger">
                                             <label for="hpa-n_<?=$i?>"><span class="dt-yes"></span> No</label>
                                         </span>
                                      </div>
                                  </div>
                              </div>
                                   -->
                              
                                </div>
                                <input type="hidden" name="des_id[]" value="<?=$value['tag_flag']?>" id="desid_<?=$i;?>">
                                <input type="hidden" name="loanbnk" value="<?php if(!empty($value['bank_id'])){ echo $value['bank_id']; } ?>" id="loanbnk_<?=$i?>">
                                <?php if(empty($disbural)){?>
                                <div class="">
                                  
                                  <a onclick="disburseLoan(this)" class="btn-continue disburse" id="disburse_<?=$i?>">Disburse</a>
                               </div>
                               <?php } ?>

                              </div>
                            </div>
                           
                            <?php }?>
                             </div>
                            </div>
                            <!---------Disbursed model pop-up ---------->
                              <div class="modal fade bs-example-modal-lg" id="disbusedModel" tabindex="-1" role="dialog" aria-labelledby="disbusedModelLabel" style="display:none;">
                                <div class="modal-backdrop fade in" style="height:100%"></div>
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="closeDis" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg"></button>

                                            <h4 class="modal-title" id="disbusedModelLabel">Edit Disbursement Details</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="bank-box-disburses">


                                               <div class="">
    <div class="col-md-12">
    <h2 class="sub-title mrg-T0 fnt-16">Disbursement Amount</h2>
    </div>
    <div class="col-md-4">
    <div class="form-group">
    <label for="" class="crm-label">Loan Amount</label>
    <input type="text" onkeypress="return isNumberKey(event)"  name="loan_dis_amt" id="loan_dis_amt" onkeyup="emiCheck(this,'','1')"  class="form-control crm-form rupee-icon" value="<?=!empty($CustomerInfo['loan_amount'])?$CustomerInfo['loan_amount']:$disbur?>" placeholder="0" onkeyup="addCommas(this.value, 'loan_dis_amt');">
    <span class="error" id="err_loan_dis_amt"></span>
    </div>
    </div>
    <div class="col-md-4">
    <div class="form-group">
    <label for="" class="crm-label">Gross Loan Amount</label>
    <input type="text" onkeypress="return isNumberKey(event)" name="gross_loan" id="gross_loan" maxlength="7" class="form-control crm-form rupee-icon" placeholder="0" onkeyup="addCommas(this.value, 'gross_loan');" value="<?=!empty($CustomerInfo['gross_loan'])?$CustomerInfo['gross_loan']:$disbur?>" readonly="readonly">
    <span class="error" id="err_gross_loan"></span>
    </div>
    </div>
    <div class="col-md-4">
    <div class="form-group">
    <label for="" class="crm-label">Net Disbursed Amount</label>
    <input type="text" name="net_disburse" onkeypress="return isNumberKey(event)"  id="net_disburse" maxlength="7" class="form-control rupee-icon crm-form" value="<?=$net_dis?>" placeholder="0" onkeyup="addCommas(this.value, 'net_disburse');" readonly="readonly">
    <span class="error" id="err_net_disburse"></span>
    </div>
    </div>
    <div class="col-md-12">
    <h2 class="sub-title mrg-T0 fnt-16">Add Ons</h2>
    </div>
    <div class="col-md-4">
    <div class="form-group">
    <label for="" class="crm-label">GPS</label>
    <input type="text" onkeypress="return isNumberKey(event);" onchange="chngloanamt(this.value);" name="gps_disburse" id="gps_disburse" maxlength="7" class="form-control crm-form rupee-icon" value="<?=!empty($CustomerInfo['gps_disburse'])?$CustomerInfo['gps_disburse']:''?>" placeholder="0" onkeyup="addCommas(this.value, 'gps_disburse');">
    <span class="error" id="err_gps_disburse"></span>
    </div>
    </div>
    <div class="col-md-4">
    <div class="form-group">
    <label for="" class="crm-label">Loan suraksha</label>
    <input type="text" onkeypress="return isNumberKey(event);" onchange="chngloanamt(this.value);" name="loan_disburse" id="loan_disburse" maxlength="7" class="form-control crm-form rupee-icon" value="<?=!empty($CustomerInfo['loan_disburse'])?$CustomerInfo['loan_disburse']:''?>" placeholder="0" onkeyup="addCommas(this.value, 'loan_disburse');">
    <span class="error" id="err_loan_disburse"></span>
    </div>
    </div>
    <div class="col-md-4">
    <div class="form-group">
    <label for="" class="crm-label">Motor Insurance</label>
    <input type="text" onkeypress="return isNumberKey(event);" onchange="chngloanamt(this.value);" name="motor_disburse" id="motor_disburse" maxlength="7" class="form-control rupee-icon crm-form" value="<?=!empty($CustomerInfo['motor_disburse'])?$CustomerInfo['motor_disburse']:''?>" placeholder="0" onkeyup="addCommas(this.value, 'motor_disburse');">
    <span class="error" id="err_motor_disburse"></span>
    </div>
    </div>
    <div class="col-md-4">
    <div class="form-group">
    <label for="" class="crm-label">Extended Warranty</label>
    <input type="text" onkeypress="return isNumberKey(event);" onchange="chngloanamt(this.value);" name="extend_warranty" id="extend_warranty" maxlength="7" class="form-control rupee-icon crm-form" value="<?=!empty($CustomerInfo['extend_warranty'])?$CustomerInfo['extend_warranty']:''?>" placeholder="0" onkeyup="addCommas(this.value, 'extend_warranty');">
    <span class="error" id="err_extend_warranty"></span>
    </div>
    </div>

<div class="col-md-4">
    <div class="form-group">
    <label for="" class="crm-label">Auto Loan Credit Protect</label>
    <input type="text" onkeypress="return isNumberKey(event);" onchange="chngloanamt(this.value);" name="loan_credit_protect" id="loan_credit_protect" maxlength="7" class="form-control crm-form rupee-icon" value="<?=!empty($CustomerInfo['loan_credit_protect'])?$CustomerInfo['loan_credit_protect']:''?>" placeholder="0" onkeyup="addCommas(this.value, 'loan_credit_protect');">
    <span class="error" id="err_loan_credit_protect"></span>
    </div>
    </div>
    <div class="col-md-4">
    <div class="form-group">
    <label for="" class="crm-label">Health Insurance</label>
    <input type="text" onkeypress="return isNumberKey(event);" onchange="chngloanamt(this.value);" name="health_insurance" id="health_insurance" maxlength="7" class="form-control crm-form rupee-icon" value="<?=!empty($CustomerInfo['health_insurance'])?$CustomerInfo['health_insurance']:''?>" placeholder="0" onkeyup="addCommas(this.value, 'health_insurance');">
    <span class="error" id="err_health_insurance"></span>
    </div>
    </div>


    <div class="col-md-12">
    <h2 class="sub-title mrg-T0 fnt-16">Deductions</h2>
    </div>
    <div class="col-md-4">
    <div class="form-group">
    <label for="" class="crm-label">Processing Fee</label>
    <input type="text" onkeypress="return isNumberKey(event);" onchange="chngloanamt('',this.value);" name="fee_disburse" maxlength="7" id="fee_disburse" class="rupee-icon form-control crm-form" value="<?=!empty($CustomerInfo['fee_disburse'])?$CustomerInfo['fee_disburse']:''?>" placeholder="0" onkeyup="addCommas(this.value, 'fee_disburse');">
    <span class="error" id="err_fee_disburse"></span>
    </div>
    </div>
    <div class="col-md-4">
    <div class="form-group">
    <label for="" class="crm-label">Other Deductions</label>
    <input type="text" onkeypress="return isNumberKey(event);" onchange="chngloanamt('',this.value);" name="other_disburse" maxlength="7" id="other_disburse" class="rupee-icon form-control crm-form" value="<?=!empty($CustomerInfo['other_disburse'])?$CustomerInfo['other_disburse']:''?>" placeholder="0" onkeyup="addCommas(this.value, 'other_disburse');">
    <span class="error" id="err_other_disburse"></span>
    </div>
    </div>
    <div class="col-md-4">
    <div class="form-group clearfix pos-rel">
    <label for="" class="crm-label">Advance EMI</label>
    <select class="form-control crm-form emi-drop" name="counter_emi" id="counter_emi">
    <option value="0" <?=((isset($CustomerInfo['counter_emi']) && ($CustomerInfo['counter_emi']=='0'))? 'selected':'')?>>0</option>
    <option value="1" <?=(!empty($CustomerInfo['counter_emi']) && ($CustomerInfo['counter_emi']=='1'))?'selected':''?>>1</option>
    <option value="2" <?=(!empty($CustomerInfo['counter_emi']) && ($CustomerInfo['counter_emi']=='2'))?'selected':''?>>2</option>
    <option value="3" <?=(!empty($CustomerInfo['counter_emi']) && ($CustomerInfo['counter_emi']=='3'))?'selected':''?>>3</option>
    <option value="4" <?=(!empty($CustomerInfo['counter_emi']) && ($CustomerInfo['counter_emi']=='4'))?'selected':''?>>4</option>
    </select>
    <input type="text" name="total_emi" onkeypress="return isNumberKey(event);" onchange="chngloanamt('',this.value)" maxlength="7" id="total_emi" class="rupee-icon form-control crm-form emi-value" value="<?=!empty($CustomerInfo['total_emi'])?$CustomerInfo['total_emi']:''?>" placeholder="0" onkeyup="addCommas(this.value, 'total_emi');;">
    <span class="error" id="err_total_emi"></span>
    <span class="d-arrow darw-rw"></span>
    </div>
    </div>
    <div class="col-md-4">
    <div class="form-group">
    <label for="" class="crm-label">Existing Loan Settle</label>
    <input type="text" onkeypress="return isNumberKey(event);" onchange="chngloanamt('',this.value);" name="existing_disburse" maxlength="7" id="existing_disburse" class="rupee-icon form-control crm-form" value="<?=!empty($CustomerInfo['existing_disburse'])?$CustomerInfo['existing_disburse']:''?>" placeholder="0" onkeyup="addCommas(this.value, 'existing_disburse');">
    <span class="error" id="err_existing_disburse"></span>
    </div>
    </div>
    <div class="col-md-4">
    <div class="form-group">
    <label for="" class="crm-label">Existing Loan Account Number</label>
    <input type="text" onkeypress="return isNumberKey(event)" name="existing_account_no" maxlength="16" id="existing_account_no" class="form-control crm-form" value="<?=!empty($CustomerInfo['existing_account_no'])?$CustomerInfo['existing_account_no']:''?>" placeholder="0">
    <span class="error" id="err_existing_account_no"></span>
    </div>
    </div>
    </div>
    <div class="col-md-12">
    <h2 class="sub-title mrg-T0 fnt-16">Additional Details</h2>
    </div>
<div class="col-md-4">
    <div class="form-group">
        <label for="" class="crm-label">Loan Short Amount</label>
        <input type="text" name="loan_short" onkeypress="return isNumberKey(event)" maxlength="7" id="loan_short" class="form-control rupee-icon crm-form" value="<?=!empty($CustomerInfo['loan_short'])?$CustomerInfo['loan_short']:''?>" onkeyup="addCommas(this.value, 'loan_short');" placeholder="0">
        <span class="error" id="err_loan_short"></span>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="" class="crm-label">First EMI Date</label>
        <div class="date input-append demo" id="reservation_too" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
            <input type="text" name="daterange_to" id="daterange_to" class="form-control crm-form add-on icon-cal1 new_input" placeholder="Emi Date" value="<?=(!empty($CustomerInfo['first_emi']) && (date('d-m-Y',strtotime($CustomerInfo['first_emi']))!='01-01-1970'))?date('d-m-Y',strtotime($CustomerInfo['first_emi'])):date('d-m-Y')?>" >
        </div>
        <span class="error" id="err_daterange_to"></span>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="" class="crm-label">Payout (%)</label>
        <input type="text" name="payout" onkeypress="return isRoiNumberKey(event,this)" maxlength="5" id="payout" class="form-control crm-form" value="<?=!empty($CustomerInfo['payout'])?$CustomerInfo['payout']:0?>" placeholder="0">
        <span class="error" id="err_payout"></span>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="" class="crm-label">Remarks</label>
        <input type="text" name="remark" id="remark" class="form-control crm-form" value="<?=!empty($CustomerInfo['remark'])?$CustomerInfo['remark']:''?>" placeholder="Remarks" <?=$sy?>>
        <span class="error" id="err_remark"></span>
    </div>
</div>
 <input type="hidden" name="dis_emi" value="<?=!empty($CustomerInfo['disburse_emi'])?$CustomerInfo['disburse_emi']: '0'?>" id="dis_emi">
  <input type="hidden" name="dis_ten" value="" id="dis_ten">
   <input type="hidden" name="dis_roi" value="" id="dis_roi">
</div>
</div>

<div class="modal-footer">
    <a href="javascript:void(0);" class="btn-continue btn-next-save btn-disb footer-btn">SAVE</a>
</div>
</div>
</div>
</div>
</div>
                             <!---------Disbursed model pop-up end ---------->
                             <input type="hidden" name="disdis" value="" id="disdis">
                            
                            <?
                            }
                            else
                            {

                              echo '<div class="col-md-4">Approved File is not Available.</div>';
                              } ?>
                            <div class="col-md-12">
                               <div class="btn-sec-width">
                                <input type="hidden" name="idSelected" id="idSelected" value="<?=(!empty($idSelect))?$idSelect:''?>">
                                  <input type="hidden" value="1" class="module" name="LeadDisbursalForm">
                                  <input type="hidden" name="bank_id" value="<?php if(!(empty($bankIDs))){echo trim($bankIDs,',');}?>" id="bankid">
                                   <input type="hidden" name="disbrsal" value="<?=(!empty($disbural))?$disbural:''?>" id="disbrsal">
                                  <input type="hidden" value="<?=$CustomerInfo['customer_id']?>" id="customer_id" name="customer_id">
                                  <input type="hidden" name="case_id" value="<?=$case_id?>" id="caseid">
                                  <input type="hidden" name="counterTotal" id="countTotal" value="<?=!empty($counter)?$counter:''?>">
                                  <input type="hidden" name="rolemgmt" value="<?=(!empty($rolemgmt[0]['role_name'])?$rolemgmt[0]['role_name']:'')?>" id="rolemgmt">
 <input type="hidden" name="clic" value="0" id="clic">
                                 <?php 
                                      $stylesss = 'display:block';
                                      $stylec = 'display:none';
                                      $action = '';
                                    if(((!empty($CustomerInfo['tag_flag']) && ($CustomerInfo['tag_flag']=='4')) && ($rolemgmt[0]['edit_permission']=='0') && (!empty($CustomerInfo['cust_bnk_id']))) || ($rolemgmt[0]['add_permission']=='0') || (($rolemgmt[0]['edit_permission']=='1') && (!empty($CustomerInfo['tag_flag']) && ($CustomerInfo['tag_flag']=='4'))) && (($rolemgmt[0]['role_name']!='admin')))
                                      {
                                        // echo "hiii"; exit;
                                          /*$stylesss  = 'display:none';
                                          $stylec = 'display:block';
                                          $action = base_url('uploadDocs/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]).'/dis';*/
                                          $stylesss  = 'display:none';
                                          $stylec = 'display:block';
                                          $action = base_url('paymentDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);
                                      } 

                                   if($CustomerInfo['cancel_id']=='0'){ ?>
                                   <input type="hidden" name="flg" value="0" id="flg">
                                  <a href="javascript:void(0);"  style="<?=$stylesss?>" class="btn-continue saveCont btn-next mrg-B20" id="disburseButton">SAVE AND CONTINUE</a>

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
            <script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/js/loanLogin.js" type="text/javascript"></script>
           <script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>    
           <script>
           // var d = new Date();        
     // d.setDate(date.getDate());
        $(document).ready(function(){
          var dates =  $('#daterange_to').val();      
           $('#daterange_to').datepicker({
                  format: 'dd-mm-yyyy',
                  autoclose: true,
                  todayHighlight: true
                  //endDate: d     
             });
          
         
       });
              function checkRefnumber(refids,ids,flag) {
                var refid = $(refids).attr('id');
                var id = refid.split("_");
                var refval = $('#'+refid).val();
             //   alert(refids+'-'+ids+'-'+flag);
                checkRefId(refval,id[1],ids,flag);
              }
           </script>
            <script>
             $(".info-box").hide();
             $(".btn-next-save").click(function(){
              var abb = saveDisburseDistribution();
              if(abb=='0'){
               var s_id = $('#idSelected').val();
                $(".disburse-disable").removeClass("btn-disburse");
                $("#disbusedModel").attr('style','display:none');
                $("#disbusedModel").removeClass(' in');
                $(".info-box").hide();
                $(".arrow_box").hide();
                $("#sid_"+s_id).attr('style','pointer-events: initial !important;display:block;');
                $("#sid_"+s_id+' .info-tool').show();
                location.reload();
             }
            });
           $('.closeDis').click(function(){
              $("#disbusedModel").attr('style','display:none');
              $("#disbusedModel").removeClass(' in');
              var inf = "<?=(!empty($idSelect)?'1':'')?>";
              if(inf=='1')
              {
               // alert('hi');
                $("#sid_1").attr('style','pointer-events: initial !important;display:block;');
                $("#sid_"+'1'+' .info-tool').show();
              }
           });

       </script>
       <script>
           function showInfoBox(e)
           {
            var cc = $('#clic').val();
           // alert(cc);
            var demi = $('#femi_'+e).val();
            $('#dis_emi').val(demi);
              
                if(cc=='0'){
                 $('#clic').val('1');
                 $("#infoBox_"+e).show();
               }
               else{
                $('#clic').val('0');
                $("#infoBox_"+e).hide();
              }
               /* var ress = $('#disdis').val();
                if(ress!=''){
                var rr = ress.split(",");
                if(rr[1]=='')
                {
                  rr[1] =0;
                }
                if(rr[2]=='')
                {
                  rr[2] =0;
                }
                if(rr[3]=='')
                {
                  rr[3] =0;
                }
                if(rr[4]=='')
                {
                  rr[4] =0;
                }
                if(rr[5]=='')
                {
                  rr[5] =0;
                }
                if(rr[6]=='')
                {
                  rr[6] =0;
                }
                if(rr[7]=='')
                {
                  rr[7] =0;
                }
                if(rr[8]=='')
                {
                  rr[8] =0;
                }
                var sum = parseInt(rr[1])+parseInt(rr[2])+parseInt(rr[3])+parseInt(rr[4])+parseInt(rr[5])+parseInt(rr[6])+parseInt(rr[7])+parseInt(rr[8]);
                $('.ress').html('');
                if(sum!='')
                {
                  $('#res_gps_'+e).html('&#x20B9;'+rr[1]);
                  $('#res_loan_'+e).html('&#x20B9;'+rr[2]);
                  $('#res_motor_'+e).html('&#x20B9;'+rr[3]);
                  $('#res_fee_'+e).html('&#x20B9;'+rr[4]);
                  $('#res_other_'+e).html('&#x20B9;'+rr[5]);
                  $('#res_exist_'+e).html('&#x20B9;'+rr[6]);
                  $('#res_pro_'+e).html('&#x20B9;'+rr[7]);
                  $('#res_rc_'+e).html('&#x20B9;'+rr[8]); 
                  $('#res_amount_'+e).html('&#x20B9;'+sum);
               }
             }*/
           }
           $(".edit-txt").click(function(){
            <?php if(($_SESSION['userinfo']['is_admin']=='1') && (!empty($CustomerInfo['tag_flag']) && $CustomerInfo['tag_flag']  =='4'))
            {?>
               $(".bank-box-disburses .form-group").attr('style','pointer-events:initial !important;');
            <?php }?>
               var si = $('#idSelected').val();
                $(".disburse-disable").addClass("btn-disburse");
                $("#disbusedModel").attr('style','display:block');
                $("#disbusedModel").addClass(' in');
                $('#gps_disburse').val("<?=!empty($CustomerInfo['gps_disburse'])?$CustomerInfo['gps_disburse']:''?>");
                $('#loan_disburse').val("<?=!empty($CustomerInfo['loan_disburse'])?$CustomerInfo['loan_disburse']:''?>");
                $('#motor_disburse').val("<?=!empty($CustomerInfo['motor_disburse'])?$CustomerInfo['motor_disburse']:''?>");
                $('#fee_disburse').val("<?=!empty($CustomerInfo['fee_disburse'])?$CustomerInfo['fee_disburse']:''?>");
                $('#other_disburse').val("<?=!empty($CustomerInfo['other_disburse'])?$CustomerInfo['other_disburse']:''?>");
                $('#existing_disburse').val("<?=!empty($CustomerInfo['existing_disburse'])?$CustomerInfo['existing_disburse']:''?>");
                $('#processing_disburse').val("<?=!empty($CustomerInfo['processing_disburse'])?$CustomerInfo['processing_disburse']:''?>");
                $('#rc_disburse').val("<?=!empty($CustomerInfo['rc_disburse'])?$CustomerInfo['rc_disburse']:''?>");

                $('#loan_credit_protect').val("<?=!empty($CustomerInfo['loan_credit_protect'])?$CustomerInfo['loan_credit_protect']:''?>");
                $('#health_insurance').val("<?=!empty($CustomerInfo['health_insurance'])?$CustomerInfo['health_insurance']:''?>");


                 $('#extend_warranty').val("<?=!empty($CustomerInfo['extend_warranty'])?$CustomerInfo['extend_warranty']:''?>");
                 $('#counter_emi').val("<?=isset($CustomerInfo['counter_emi'])?$CustomerInfo['counter_emi']:'0'?>");
                 $('#total_emi').val("<?=!empty($CustomerInfo['total_emi'])?$CustomerInfo['total_emi']:''?>");
                $('#existing_disburse').val("<?=!empty($CustomerInfo['existing_disburse'])?$CustomerInfo['existing_disburse']:''?>");

                $('#daterange_to').val("<?=!empty($CustomerInfo['first_emi'])&& date('d-m-Y',strtotime($CustomerInfo['first_emi']))!='01-01-1970'? date('d-m-Y',strtotime($CustomerInfo['first_emi'])):date('d-m-Y')?>");
                $('#remark').val("<?=!empty($CustomerInfo['remark'])?$CustomerInfo['remark']:''?>");
                $('#payout').val("<?=!empty($CustomerInfo['payout'])?$CustomerInfo['payout']:''?>")

                $('#loan_short').val("<?=!empty($CustomerInfo['loan_short'])?$CustomerInfo['loan_short']:''?>");

                $('#existing_account_no').val("<?=!empty($CustomerInfo['existing_account_no'])?$CustomerInfo['existing_account_no']:''?>");

                $('input[name=buyer-type][value="<?=!empty($CustomerInfo['rc_by'])?$CustomerInfo['rc_by']:''?>"]').prop("checked",true);;
                $(".info-box").hide();
                $(".arrow_box").show();
                $("#sid_"+si+" .info-tool").hide();
                $("#dis_ten").val("<?=!empty($CustomerInfo['disbursed_tenure'])?$CustomerInfo['disbursed_tenure']:''?>");
                $("#dis_roi").val("<?=!empty($CustomerInfo['disbursed_roi'])?$CustomerInfo['disbursed_roi']:''?>");
            });
           
           function saveDisburseDistribution()
           {
              var err = '';
              var error_flag = '';
              var gps_disburse = $('#gps_disburse').val();
              var loan_disburse = $('#loan_disburse').val();
              var motor_disburse = $('#motor_disburse').val();
              var fee_disburse = $('#fee_disburse').val();
              var other_disburse = $('#other_disburse').val();
              var existing_disburse = $('#existing_disburse').val();
              var processing_disburse = $('#processing_disburse').val();
              var rc_disburse = $('#rc_disburse').val();
              var buyer_type=$('input[name=buyer-type]:checked').val();
              var loan_dis_amt = $('#loan_dis_amt').val().replace(/,/g, '');
              var gross_loan = $('#gross_loan').val();
              var total_amount = $('#net_disburse').val();
              var extend_warranty = $('#extend_warranty').val();
              var counter_emi = $('#counter_emi').val();
              var total_emi = $('#total_emi').val();
              var existing_account_no = $('#existing_account_no').val();
              var loan_short = $('#loan_short').val();
              var first_emi = $('#daterange_to').val();
              var remark = $('#remark').val();
              var payout = $('#payout').val();
              var disburse_emi = $("#dis_emi").val();
              var health_insurance = $('#health_insurance').val();
              var loan_credit_protect = $('#loan_credit_protect').val();
              $('.error').html('');
               if(loan_dis_amt.length > 8)
               {
                    $('#loan_dis_amt').addClass('validClass');
                    $('#err_loan_dis_amt').html("Please Enter valid Amount");
                    error_flag=true;
               }
               if(error_flag)
                {
                  $('.error').attr('style','display:block');
                  return error_flag;
                }
              if(payout=='')
              {
                payout = 0;
              }
              if(gps_disburse=='')
              {
                gps_disburse=0;
              }
              if(loan_disburse=='')
                    {
                loan_disburse=0;
              }
              if(motor_disburse=='')
                    {
                motor_disburse=0;
              }
              if(fee_disburse=='')
                    {
                fee_disburse=0;
              }
              if(other_disburse=='')
                    {
                other_disburse=0;
              }
              if(existing_disburse=='')
                    {
                existing_disburse=0;
              }
              if(processing_disburse=='')
                    {
                processing_disburse=0;
              }
              if(rc_disburse=='')
                    {
                rc_disburse=0;
              }
              if(loan_dis_amt=='')
              {
                loan_dis_amt=0;
              }
              if(gross_loan=='')
              {
                gross_loan=0;
              }
              if(net_disburse=='')
              {
                net_disburse=0;
              }
              if(extend_warranty=='')
              {
                extend_warranty=0;
              }
              if(counter_emi=='')
              {
                counter_emi=0;
              }
              if(total_emi=='')
              {
                total_emi='';
              }
              if(existing_account_no=='')
              {
                existing_account_no='';
              }
              if(loan_short=='')
              {
                loan_short=0;
              }
              if(loan_credit_protect=='')
              {
                loan_credit_protect=0;
              }
              if(health_insurance==''){
                health_insurance = 0;
              }
              var caseid = $('#caseid').val();
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url(); ?>" +"Finance/disbursalDistribution",
                  data : {loan_dis_amt,case_id : caseid,gps_disburse:gps_disburse,loan_disburse:loan_disburse,motor_disburse:motor_disburse,fee_disburse:fee_disburse,other_disburse:other_disburse,existing_disburse:existing_disburse,processing_disburse:processing_disburse,rc_disburse:rc_disburse,buyer_type:buyer_type,first_emi,gross_loan,total_amount,extend_warranty,counter_emi,total_emi,existing_account_no,loan_short,remark, disburse_emi,payout,loan_credit_protect,health_insurance},
                    dataType: 'json',
                    async: false,
                    success: function(response){
                    if(response.status=='0')
                      {
                        if(response.res!='')
                        {
                          alert(response.res);
                        }
                        else
                        {
                          alert('Some Error Occur');
                        }
                        err = '1';
                        return false;
                      }
                      else
                      {
                        var ress = response.res;
                        $('#disdis').val(ress);
                        err ='0' ;
                        var sum = parseInt(gps_disburse)+parseInt(loan_disburse)+parseInt(motor_disburse)+parseInt(fee_disburse)+parseInt(other_disburse)+parseInt(existing_disburse)+parseInt(health_insurance)+parseInt(loan_credit_protect);
                        var aaa = $('#idSelected').val();
                        var gross = $('#floanamount_'+aaa).val();
                        var sub = parseInt(gross) - parseInt(sum);
                        <?php if (!empty($CustomerInfo['tag_flag']) && $CustomerInfo['tag_flag']!='4'){?>
                        saveDisbursal(aaa);
                        return false;
                        <?php }?>
                      }
                  }
                }); 
              return false;            
           }
       </script>
       <?php if(!empty($idSelect)){?>
       <script>
        var si = $('#idSelected').val();
        $("#sid_"+si).attr('style','display:block;');
        $("#sid_"+si+" .info-tool").show();
       </script>
       <?}
       if($_SESSION['userinfo']['is_admin']=='1'){
       ?>
        <script>
        var si = $('#idSelected').val();
        $("#sid_"+si).attr('style','pointer-events: initial !important;display:block;');
        $("#sid_"+si+" .info-tool").show();
       </script>
       <?php } ?>
       <script>
          $(document).on("click","body", function (event) {
                var id = event.target.id;
                var idd = id.split('_');
                //alert(idd[0]);
                if(idd[0]!='app')
                {
                  $('.mark-rej').attr('style','display:none');
                }
            });
          $("#counter_emi" ).change(function() {
           
           var np ="<?=(!empty($value['disbursed_tenure'])?$value['disbursed_tenure']:(empty($value['approved_tenure'])? $value['file_tenure']:$value['approved_tenure']))?>";
          var r ="<?=(!empty($value['disbursed_roi'])?$value['disbursed_roi']:(empty($value['approved_roi'])? $value['file_roi']:$value['approved_roi']))?>";
           //var pv = $('#loan_dis_amt').val();
           var pv = $('#gross_loan').val();
           //alert(pv);
      if(pv==''){
           pv ="<?=!empty($CustomerInfo['gross_loan'])?$CustomerInfo['gross_loan']:$disbur?>";
    }
           pv = pv.replace(/,/g, '');
          var ir = (r/100)/12;
         // alert(np+'-'+ir+'-'+pv);
            var cout = $("#counter_emi").val();
            if(cout=='0')
            {
             var dis_eminew = PMT(ir, np, pv,0,0);
            }
            else
            {
             var dis_eminew = PMT(ir, np, pv,0,1)
            }
            dis_eminew = parseInt(Math.abs(dis_eminew));
            var total_emi = parseInt(dis_eminew) * parseInt(cout);
           
            $("#dis_emi").val(dis_eminew);
            $('#total_emi').val(total_emi);
            $('#total_emi').trigger('onkeyup');
            $('#total_emi').trigger('onchange');
          });


          function chngloanamt(amt1='',amt2='')
          {
            
              var loan_dis_amt = $('#loan_dis_amt').val().replace(/,/g, '');
              var net_disburse = $('#net_disburse').val().replace(/,/g, '');
              var gps_disburse = $('#gps_disburse').val().replace(/,/g, '');
              var loan_disburse = $('#loan_disburse').val().replace(/,/g, '');
              var motor_disburse = $('#motor_disburse').val().replace(/,/g, '');
              var extend_warranty = $('#extend_warranty').val().replace(/,/g, '');
              var fee_disburse = $('#fee_disburse').val().replace(/,/g, '');
              var other_disburse = $('#other_disburse').val().replace(/,/g, '');
              var total_emi = $('#total_emi').val().replace(/,/g, '');
              var existing_disburse = $('#existing_disburse').val().replace(/,/g, '');

              var loan_credit_protect = $('#loan_credit_protect').val().replace(/,/g, '');
              var health_insurance = $('#health_insurance').val().replace(/,/g, '');

              if(gps_disburse=='' || isNaN(gps_disburse))
              {
                gps_disburse=0;
              }
              if(loan_disburse=='' || isNaN(loan_disburse))
                    {
                loan_disburse=0;
              }
              if(motor_disburse=='' || isNaN(motor_disburse))
                    {
                motor_disburse=0;
              }
              if(fee_disburse=='' || isNaN(fee_disburse))
                    {
                fee_disburse=0;
              }
              if(other_disburse=='' || isNaN(other_disburse))
                    {
                other_disburse=0;
              }
              if(existing_disburse==''  || isNaN(existing_disburse))
                    {
                existing_disburse=0;
              }
              
              if(extend_warranty=='' ||  isNaN(extend_warranty))
              {
                extend_warranty=0;
              }
              if(loan_dis_amt=='' ||  isNaN(loan_dis_amt))
              {
                loan_dis_amt=0;
              }
              
              if(total_emi=='' || isNaN(total_emi))
              {
                total_emi=0;
              }
             if(loan_credit_protect=='' || isNaN(loan_credit_protect))
              {
                loan_credit_protect=0;
              }
              if(health_insurance=='' || isNaN(health_insurance))
              {
                health_insurance=0;
              }
              
                
               // alert(parseInt(gps_disburse)+' - ' + parseInt(loan_disburse)+' - ' + parseInt(motor_disburse)+ ' - '  + parseInt(extend_warranty) +' - '+ parseInt(loan_dis_amt));
                 var gross_loan =  parseInt(gps_disburse) + parseInt(loan_disburse) + parseInt(motor_disburse) + parseInt(extend_warranty) + parseInt(loan_dis_amt)+ parseInt(loan_credit_protect)+ parseInt(health_insurance);
                 //alert(gross_loan);
                 $('#gross_loan').val(gross_loan);
                 $('#gross_loan').trigger('onkeyup');
                 //addCommas(gross_loan,'gross_loan');
              
                 //alert('hi2');
                var net_disburses = (parseInt(loan_dis_amt) - (parseInt(fee_disburse) + parseInt(other_disburse) + parseInt(existing_disburse) +parseInt(total_emi)));
                //alert(gross_loan);
                
                $('#net_disburse').val(net_disburses);
                $('#net_disburse').trigger('onkeyup');
                 //addCommas(gross_loan,'net_disburse');
              //}
          }
       </script>
<style>
  button.closed{
    padding: 0;
    cursor: pointer;
    background: transparent;
    border: 0;
    -webkit-appearance: none;
  }
</style>

<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>  
<script>
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