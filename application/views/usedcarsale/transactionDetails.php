<?php



?>
<div class="container-fluid">
               <div class="row">
                   <form name="trnxForm" id="trnxForm" method="post" action="">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <h2 class="page-title">Transaction Details</h2>
                    
                     <div class="white-section">
                        <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0"></h2>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Sales executive name*</label>
                                 <select id="sales_exec_id" name="sales_exec_id" class="form-control crm-form" required>
                                        
                                     <option  value="" >Select Sales Executive</option>
                                     <?php foreach($ucSalesExecList as $uc_sales_exec){ ?>
                                     <option  value="<?=$uc_sales_exec['id']?>"  <?= !empty($tranxData['uc_sales_exe_id']) && $tranxData['uc_sales_exe_id']==$uc_sales_exec['id'] ?'selected':'' ?> ><?=$uc_sales_exec['name']?></option>
                                     <?php } ?>
                                    </select>
                                 <div class="error" id="sales_exec_id_error" >Please Select Executive</div>
                                 <div class="d-arrow"></div>
                              </div>
                           </div>
<!--                            <div class="col-md-6">
                              <div class="form-group">
                                 <label class="crm-label">Current Status</label>
                                  <span class="radio-btn-sec">
                                     <input type="radio" name="current_trxn_status" id="booked" value="1" class="trigger " <?php echo !empty($car_status) && $car_status==4 ? "checked='checked'" : '';?>>
                                     <label for="booked"><span class="dt-yes"></span> Booked</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="current_trxn_status" id="sold" value="2" class="trigger" <?php echo !empty($car_status) && $car_status==3 ? "checked='checked'" : '';?>>
                                     <label for="sold"><span class="dt-yes"></span> Sold</label>
                                 </span>
                                 <div class="error" id="buyer_type_error" ></div>
                              </div>
                                
                           </div>-->
                            <div class="col-md-6"  >
                              <div class="form-group">
                                  <label for="" class="crm-label" id="additional_accessories">Additional Accessories*</label>
                                 <input required type="text" name="additional_accessories" id="additional_accessories" class="form-control crm-form" value="<?php echo (!empty($tranxData['additional_accessories'])) ? $tranxData['additional_accessories'] : '';?>" maxlength="20"   placeholder="Additional Accessories">

                                 <div class="error" id="additional_accessories_error" >Please Enter Additional Accessories</div>
                                 </div>
                                
                            </div>
                             </div>
                         <div class="row ">
                             <h2 class="page-title">Insurance Details</h2>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label class="crm-label">Insurance*</label>
                                  <span class="radio-btn-sec">
                                      <input required type="radio" name="issue_new_insurance" id="old_ins_trans" value="no" class="trigger" <?php echo isset($tranxData['new_insurance_req']) && $tranxData['new_insurance_req']==0 ? "checked='checked'" : '';?>>
                                     <label for="old_ins_trans"><span class="dt-yes"></span> Transferring Old </label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="issue_new_insurance" id="new_ins" value="yes" class="trigger" <?php echo isset($tranxData['new_insurance_req']) && $tranxData['new_insurance_req']==1 ? "checked='checked'" : '';?>>
                                     <label required for="new_ins"><span class="dt-yes"></span> Issuing new</label>
                                 </span>
                                 <div class="error" id="issue_new_insurance_error" >Please Choose One Option</div>
                              </div>
                                
                           </div>
                             <?php $display_ins_charges = empty($tranxData['new_insurance_req'])?'display:none;':'display:block;' ?>
                             <div class="col-md-6 ins_req_yes" style="<?=$display_ins_charges?>" >
                              <div class="form-group">
                                  <label for="insurance_charges" class="crm-label" >Insurance Charges*</label>
                                  <!--onkeyup="addCommasdd(this.value, this.id);" onkeypress="return forceNumber(event);"-->
                                  <input onkeyup="addCommasdd(this.value, this.id);" onkeypress="return forceNumber(event);"  type="text" name="insurance_charges" id="insurance_charges" class="form-control crm-form  amount-charges ins-req-yes rupee-icon" value="<?php echo (!empty($tranxData['insurance_charges'])) ? indian_currency_form($tranxData['insurance_charges']) : '';?>"  maxlength="9"  placeholder="Insurance Charges">
                                  <div class="error" id="insurance_charges_error" >Please Enter Insurance Charges</div>
                                 </div>
                           </div>
                            
                         </div>
                         <div class="row">
                            <h2 class="page-title">Loan Details</h2>
                            <div class="col-md-12">
                              <div class="form-group">
                                 <label class="crm-label">Loan Required*</label>
                                  <span class="radio-btn-sec">
                                      <input required type="radio" name="is_loan_req" id="loan_req_yes" value="yes" class="trigger" <?php echo isset($tranxData['loan_req']) && $tranxData['loan_req']==1 ? "checked='checked'" : '';?> >
                                     <label for="loan_req_yes"><span class="dt-yes"></span> Yes</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input required type="radio" name="is_loan_req" id="loan_req_no" value="no" class="trigger " <?php echo isset($tranxData['loan_req']) && $tranxData['loan_req']==0 ? "checked='checked'" : '';?>>
                                     <label for="loan_req_no"><span class="dt-yes"></span> No</label>
                                 </span>
                                 <div class="error" id="is_loan_req_error"  >Please Choose One Option</div>
                              </div>
                           </div>
                            <?php $display_loan= empty($tranxData['loan_req']) ? "none" : 'block';?>
                            <div id="for_loan" style="display:<?=$display_loan?>;">
                             <div class="col-md-6"  >
                              <div class="form-group">
                                  <label for="loan_amount" class="crm-label" >Loan amount</label>
                                  <input onkeyup="addCommasdd(this.value, this.id);" onkeypress="return forceNumber(event);"  type="text" name="loan_amount" id="loan_amount" class="form-control crm-form loan_req_yes rupee-icon" value="<?php echo (!empty($tranxData['loan_amount'])) ? indian_currency_form($tranxData['loan_amount']) : '';?>" maxlength="9"   placeholder="Loan Amount">
                                  <div class="error" id="loan_amount_error" >Please Enter Loan Amount</div>
                                 </div>
                           </div>
                             <div class="col-md-6"  >
                                <div class="form-group">
                                 <label for="" class="crm-label">Select Bank*</label>
                                 <select  id="bank_id" name="bank_id" class="form-control bnkspec crm-form loan_req_yes">
                                         <option  value="" >Select Bank Name</option>
                                        <?php foreach($bankList as $bankList){ ?>
                                        <option <?=$tranxData['bank_id']==$bankList['id']?'selected':'' ?> value="<?=$bankList['id']?>" ><?=$bankList['bank_name']?></option>
                                        <?php  } ?>
                                    </select>
                                 <div class="error" id="bank_id_error" >Please Select Bank</div>
                              </div>
                            </div>
                             <div class="col-md-6"  >
                              <div class="form-group">
                                  <label for="roi" class="crm-label" >ROI (%)*</label>
                                 <input type="text" name="roi" id="roi" class="form-control crm-form loan_req_yes" value="<?php echo (!empty($tranxData['roi'])) ? $tranxData['roi'] : '';?>"  maxlength="5"  placeholder="ROI">
                                 <div class="error" id="roi_error" >Please Enter ROI</div>
                                 </div>
                           </div>
                           <div class="col-md-6"  >
                              <div class="form-group">
                                  <label for="tenure" class="crm-label" >Tenure (years)*</label>
                                 <input type="text" name="tenure" id="tenure" class="form-control crm-form loan_req_yes" value="<?php echo (!empty($tranxData['tenure'])) ? $tranxData['tenure'] : '';?>" maxlength="2"   placeholder="Tenure">
                                <div class="error" id="tenure_error" >Please Enter Tenure</div>
                                 </div>
                           </div>
                             <div class="col-md-6"  >
                              <div class="form-group">
                                  <label for="valuaton_charges" class="crm-label" >Valuation Charges*</label>
                                 <input onkeyup="addCommasdd(this.value, this.id);" onkeypress="return forceNumber(event);" type="text" name="valuaton_charges" id="valuaton_charges" class="form-control crm-form  amount-charges loan_req_yes rupee-icon" value="<?php echo (!empty($tranxData['valuaton_charges'])) ? indian_currency_form($tranxData['valuaton_charges']) : '';?>"  maxlength="9"  placeholder="Valuation Charges">
                                 <div class="error" id="valuaton_charges_error" >Please Enter Valuation Charges</div>
                                 </div>
                           </div>
                             <div class="col-md-6"  >
                              <div class="form-group">
                                  <label for="hypothecation" class="crm-label " >Hypothecation Charges*</label>
                                 <input onkeyup="addCommasdd(this.value, this.id);" onkeypress="return forceNumber(event);" type="text" name="hypothecation" id="hypothecation" class="form-control crm-form amount-charges loan_req_yes rupee-icon" value="<?php echo (!empty($tranxData['hypothecation'])) ? indian_currency_form($tranxData['hypothecation']) : '';?>"    placeholder="Hypothecation" maxlength="9">
                                 <div class="error" id="hypothecation_error" >Please Enter Hypothecation Charges</div>
                                 </div>
                           </div>
                             <div class="col-md-6"  >
                              <div class="form-group">
                                  <label for="processing_fee" class="crm-label " >Processing Fee*</label>
                                 <input onkeyup="addCommasdd(this.value, this.id);" onkeypress="return forceNumber(event);" type="text" name="processing_fee" id="processing_fee" class="form-control crm-form amount-charges loan_req_yes rupee-icon" value="<?php echo (!empty($tranxData['processing_fee'])) ? indian_currency_form($tranxData['processing_fee']) : '';?>"    placeholder="Processing Fee" maxlength="9">
                                 <div class="error" id="processing_fee_error" >Please Enter Processing Fee</div>
                                 </div>
                           </div>
                         </div>
                          
                        </div>
                        <div class="row">
                        <h2 class="page-title">Price Breakup</h2>
                            <div class="col-md-6"  >
                                  <div class="form-group">
                                      <label for="base_vehicle_price" class="crm-label" >Base Vehicle Price*</label>
                                      <input onkeyup="addCommasdd(this.value, this.id);" onkeypress="return forceNumber(event);" required type="text" name="base_vehicle_price" id="base_vehicle_price" class="form-control crm-form  amount-charges rupee-icon" value="<?php echo (!empty($tranxData['base_vehicle_price'])) ? indian_currency_form($tranxData['base_vehicle_price']) : '';?>" maxlength="9"   placeholder="Base Vehicle Price">
                                     <div class="error" id="base_vehicle_price_error" >Please Enter Base Vehicle Price</div>
                                  </div>

                            </div>
                            <div class="col-md-6"  >
                                  <div class="form-group">
                                      <label for="tcs" class="crm-label" >TCS*</label>
                                     <input onkeyup="addCommasdd(this.value, this.id);" onkeypress="return forceNumber(event);" required type="text" name="tcs" id="tcs" class="form-control crm-form  amount-charges rupee-icon" value="<?php echo (!empty($tranxData['tcs'])) ? indian_currency_form($tranxData['tcs']) : '';?>" maxlength="9"   placeholder="TCS Charges">
                                     <div class="error" id="tcs_error" >Please Enter TCS</div>
                                  </div>

                            </div>
                            
                            <div class="col-md-6"  >
                                  <div class="form-group">
                                      <label for="rto" class="crm-label" >RTO Charges*</label>
                                     <input onkeyup="addCommasdd(this.value, this.id);" onkeypress="return forceNumber(event);" required type="text" name="rto" id="rto" class="form-control crm-form  amount-charges rupee-icon" value="<?php echo (!empty($tranxData['rto_charges'])) ? indian_currency_form($tranxData['rto_charges']) : '';?>"   maxlength="9" placeholder="RTO Charges">
                                     <div  class="error" id="rto_error" >Please Enter RTO Charges</div>
                                  </div>

                            </div>
                          
                            <div class="col-md-6"  >
                                  <div class="form-group">
                                      <label for="total_amt" class="crm-label" >Total Amount*</label>
                                     <input required type="text" name="total_amt" id="total_amt" class="form-control crm-form rupee-icon" value="<?php echo (!empty($tranxData['amount'])) ? indian_currency_form($tranxData['amount']) : '';?>"    placeholder="Total Amount" readonly >
                                     <div class="error" id="total_amt_error" >Please Enter Total Amount</div>
                                  </div>

                            </div>
                            <input type="hidden" name="rolename" value="<?=$_SESSION['userinfo']['role_id']?>" id="rolename">
                        <?php $display_actual_sale_amt=($_SESSION['userinfo']['role_id']==24)?'display:block;':'display:none;'?>
                        <div class="col-md-6" style="<?=$display_actual_sale_amt?>" >
                                  <div class="form-group">
                                      <label for="actual_sales_amount" class="crm-label" >Actual Sale amount*</label>
                                     <input onkeyup="addCommasdd(this.value, this.id);" onkeypress="return forceNumber(event);" <?=($_SESSION['userinfo']['role_id']==25)?'required':'';?> type="text" name="actual_sales_amount" id="actual_sales_amount" class="form-control crm-form rupee-icon" value="<?php echo (!empty($tranxData['actual_amount'])) ? indian_currency_form($tranxData['actual_amount']) : '';?>"   placeholder="Actual Sales Amount" maxlength="9">
                                     <div class="error" id="actual_sales_amount_error" >PLease Enter Actual Sale amount</div>
                                  </div>

                            </div>
                        
                            <div class="col-md-6"  >
                                  <div class="form-group">
                                      <label for="advance_payment" class="crm-label" >Advance Payment / Token</label>
                                      <input onkeyup="addCommasdd(this.value, this.id);" onkeypress="return forceNumber(event);"  type="text" name="advance_payment" id="advance_payment" class="form-control crm-form rupee-icon" value="<?php echo (!empty($tranxData['advance_payment'])) ? indian_currency_form($tranxData['advance_payment']) : '';?>"    placeholder="Advance Payment" maxlength="9">
                                     <div class="error" id="advance_payment_error" >Please Enter Advance Payment</div>
                                  </div>

                            </div>
                            <div class="col-md-6"  >
                                  <div class="form-group">
                                      <label for="bal_amount" class="crm-label" >Balance amount</label>
                                      <input type="text" name="bal_amount" id="bal_amount" class="form-control crm-form rupee-icon" value="<?php echo indian_currency_form(($tranxData['amount']-$tranxData['advance_payment'])) ?>" maxlength="9"   placeholder="Balance Amount" readonly>
                                     <div class="error" id="customer_name_error" ></div>
                                  </div>

                            </div>
                            <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <input  style="text-align: center" type="button" name="saveTrnsForm" id="saveTrnsForm" class="btn-continue" value="SAVE AND CONTINUE">
                                  <input type="hidden" name="step2" value="true">
                                  <input type="hidden" name="caseId" id="caseId" value="<?php echo isset($case_id) ? $case_id :0; ?>">
                                  <input type="hidden" name="car_id" id="car_id" value="<?php echo isset($car_id) ? $car_id :0; ?>">
                               </div>
                           </div>
                        </div>
                         
                        
                          
                     </div>
                  </div>
                   </form>
               </div>
            </div>
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script src="<?php echo base_url(); ?>assets/js/usedcarsale_process.js?t=<?=time()?>" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/usedcarsaleValidation.js?t=<?=time()?>" type="text/javascript"></script>
<style>
    .error{display:none}
</style>
<script>
 $('.bnkspec').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
    $("input[name='is_loan_req']").click(function(e){
    var id=e.target.id;
    if(id==='loan_req_yes'){
        $('#for_loan').show();
        isReqfinanceDetails(true);
    }
    else {
        isReqfinanceDetails(false);
        $('#for_loan').hide();
    }
   });
  function calculateTotalAmount(){
  var total_amount = 0;
    $('.amount-charges').each(function(){
        
        var amount=this.value.replace(/,/g,'');
        total_amount+= (amount!='' && amount!=null && typeof amount !='undefined')?parseInt(amount):0;
    });
    var advance_payment= $('#advance_payment').val().replace(/,/g,'');
   // onkeyup="addCommasdd(this.value, this.id);" onkeypress="return forceNumber(event);"
    //addCommasdd(total_amount.toString(),'actual_sales_amount');
    addCommasdd(total_amount.toString(),'total_amt');
    addCommasdd((total_amount-advance_payment).toString(),'bal_amount');
    //alert(total_amount);
  }
  //calculateTotalAmount();
   $('.amount-charges').on('keyup',function(){
       calculateTotalAmount();
   });
   $('#roi').on('keyup',function(e){
       var code = e.keyCode || e.which;
//      / alert(code);
       var val= this.value;
       if(code >=48 && code <=57){
        var new_val=val.replace("%", "");
        $(this).val(new_val+'%');
        return true;
       }
       if(code==8){
         $(this).val('');  
         return true;
       }
       return false;
   });
   $('#advance_payment').on('keyup',function(){
       var total_amount=parseInt($('#total_amt').val().replace(/,/g,''));
       var amount= $(this).val().replace(/,/g,'');
       var adv_payment =(amount!='' && amount!=null && typeof amount !='undefined')?parseInt(amount):0;;
               //alert(total_amount);
       if(adv_payment>total_amount){
            snakbarAlert('Advance Payment Can\'t Be Greater Than Total Amount');
            $("#advance_payment").val("");
          $('#bal_amount').val(0);
       }
       else{
           
           addCommasdd((total_amount-adv_payment).toString(),'bal_amount');
           //$('#bal_amount').val(parseInt(total_amount-adv_payment));
       }
   });
   
   //insurance validation
   $('input[name="issue_new_insurance"]:checked').val()=='yes'? insuranceValidate(true): insuranceValidate(false);
   
   
   $('input[name="issue_new_insurance"]').change(function(){
       var required=$(this).val()=='yes'?true:false;
        insuranceValidate(required);
   });
   function insuranceValidate(required){
       
       $('.ins-req-yes').prop('required',required);
       required ? $('.ins_req_yes').show():$('.ins_req_yes').hide();
   }
   
   $('input[name="is_loan_req"]:checked').val()=='yes'? isReqfinanceDetails(true): isReqfinanceDetails(false);

   function isReqfinanceDetails(required){
       
       $('.loan_req_yes').prop('required',required);
   }
</script>
