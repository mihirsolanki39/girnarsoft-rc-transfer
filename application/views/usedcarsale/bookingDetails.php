<?php

//print_r($bookingData);die;

?>
<div class="container-fluid">
               <div class="row">
                   <form name="bookingForm" id="bookingForm" method="post" action="">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <h2 class="page-title">Booking Details</h2>
                     <div class="white-section">
                        <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0"></h2>
                            </div>
                            <div class="col-md-6" >
                                <div class="form-group">
                                <label for="" class="crm-label" id="additional_accessories">Booking Date</label>
                                <div class="input-group date" id="dp1">
                                    <input type="text" class="form-control crm-form insdate crm-form_1" id="booking_date" name="booking_date" autocomplete="off" value="<?=!empty($bookingData['booking_date'])?date('d-m-Y', strtotime($bookingData['booking_date'])):date('d-m-Y');?>"  placeholder="Booking Date">
                                    <span class="input-group-addon">
                                        <span class="">
                                            <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                        </span>
                                    </span>
                                </div>
                                 <div class="error" id="customer_name_error" ></div>
                               </div>
                                
                            </div>
                            <div class="col-md-6"  >
                              <div class="form-group">
                                <label for="" class="crm-label" id="additional_accessories">Preferred Date of delivery</label>
                                <div class="input-group date" id="dp2">
                                    <input type="text" class="form-control crm-form insdate crm-form_1" id="date_of_delivery" name="date_of_delivery" autocomplete="off" value="<?=!empty($bookingData['date_of_delivery'])?date('d-m-Y', strtotime($bookingData['date_of_delivery'])):'';?>"  placeholder="Date Of Delivery">
                                    <span class="input-group-addon">
                                        <span class="">
                                            <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                        </span>
                                    </span>
                                </div>
                                <div class="error" id="customer_name_error" ></div>
                              </div>
                                
                            </div>
                            <div class="col-md-6"  >
                              <div class="form-group">
                                  <label for="booking_amount" class="crm-label" >Booking Amount</label>
                                  <input type="text" name="booking_amount" id="booking_amount" class="form-control crm-form rupee-icon" value="<?php echo !empty($advance_payment) ?indian_currency_form($advance_payment) : '';?>"  readonly placeholder="Booking Amount">
                                 <div class="error" id="customer_name_error" ></div>
                                 </div>
                            </div>
                            <?php if(false){ ?>
                            <div class="col-md-6"  >
                              <div class="form-group">
                                  <label for="booking_form_no" class="crm-label" >Booking Form No.</label>
                                  <input  type="text" name="booking_form_no" id="booking_form_no" class="form-control crm-form" value="<?php echo (!empty($bookingData['booking_form_no'])) ? $bookingData['booking_form_no'] : '';?>"    placeholder="Booking Form No.">
                                 <div class="error" id="booking_form_no_error" >Please Enter Booking Form No</div>
                              </div>
                                
                            </div>
                            <?php } ?>
                            <div class="col-md-6"  >
                              <div class="form-group">
                                 <label for="" class="crm-label">Instrument Type*</label>
                                 <select id="instrument_type" required name="instrument_type" onchange="instrumentTypeValidation()" class="form-control crm-form ins-type">
                                        <option value="">Select</option>
                                        <option <?=$bookingData['instrument_type']=='cash'?'selected':'' ?>  value="cash" >Cash</option>
                                        <option <?=$bookingData['instrument_type']=='cheque'?'selected':'' ?> value="cheque" >Cheque</option>
                                        <option <?=$bookingData['instrument_type']=='dd'?'selected':'' ?> value="dd" >Demand Draft</option>
                                        <option <?=$bookingData['instrument_type']=='online'?'selected':'' ?> value="online" >Online Transaction</option>
                                    </select>
                                 <div class="error" id="instrument_type_error" >Please Select Instrument Type</div>
                              </div>
                                
                            </div>
                            <div class="col-md-6 shhow"  >
                                <div class="form-group">
                                    <label for="instrument_no" class="crm-label" >Instrument No.</label>
                                    <input type="text" name="instrument_no" id="instrument_no" class="form-control crm-form" value="<?php echo (!empty($bookingData['instrument_no'])) ? $bookingData['instrument_no'] : ''; ?>"    placeholder="Instrument No.">
                                    <div class="error" id="instrument_no_error" >Please Enter Instrument No.</div>
                                </div>
                                
                            </div>
                            <div class="col-md-6 showhide" >
                                <div class="form-group">
                                <label for="" class="crm-label" >Instrument Date</label>
                                <div class="input-group date" id="dp4">
                                    <input type="text" class="form-control crm-form insdate crm-form_1" id="instrument_date" name="instrument_date" autocomplete="off" value="<?=(!empty($bookingData['instrument_date']) && (date('Y-m-d', strtotime($bookingData['instrument_date']))!='1970-01-01'))?date('d-m-Y', strtotime($bookingData['instrument_date'])):'';?>"  placeholder="Instrument Date">
                                    <span class="input-group-addon">
                                        <span class="">
                                            <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                        </span>
                                    </span>
                                </div>
                                 <div class="error" id="instrument_date_error" >Please Enter Instrument Date</div>
                               </div>
                                
                            </div>
                            <div class="col-md-6 showhide"  >
                                <div class="form-group">
                                 <label for="" class="crm-label">Select Bank</label>
                                    <select id="bank_id" name="bank_id" class="form-control testselect1 crm-form">
                                         <option  value="" >Select Bank Name</option>
                                        <?php foreach($bankList as $bankList){ ?>
                                        <option <?=$bookingData['bank_id']==$bankList['id']?'selected':'' ?> value="<?=$bankList['id']?>" ><?=$bankList['bank_name']?></option>
                                        <?php  } ?>
                                    </select>
                                 <div class="error" id="bank_id_error" >Please Select Bank</div>
                              </div>
                            </div>
                            <div class="col-md-6 showhide"  >
                                <div class="form-group">
                                    <label for="favouring" class="crm-label" >Favouring</label>
                                    <input type="text" name="favouring" id="favouring" class="form-control crm-form" value="<?php echo (!empty($bookingData['favouring'])) ? $bookingData['favouring'] : ''; ?>"    placeholder="favouring">
                                    <div class="error" id="favouring_error" >Please Enter Favouring</div>
                                </div>
                            </div>
                            <div class="col-md-6" >
                                <div class="form-group">
                                <label for="" class="crm-label" >Payment Date*</label>
                                <div class="input-group date" id="dp3">
                                    <input type="text" required class="form-control crm-form insdate crm-form_1" id="payment_date" name="payment_date" autocomplete="off" value="<?=!empty($bookingData['payment_date'])?date('d-m-Y', strtotime($bookingData['payment_date'])):'';?>"  placeholder="Payment Date">
                                    <span class="input-group-addon">
                                        <span class="">
                                            <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                        </span>
                                    </span>
                                </div>
                                 <div class="error" id="payment_date_error" >Please Enter Payment Date</div>
                               </div>
                                
                            </div>
                            <div class="col-md-6"  >
                                <div class="form-group">
                                    <label for="receipt_no" class="crm-label" >Receipt No</label>
                                    <input  type="text" name="receipt_no" id="receipt_no" class="form-control crm-form" value="<?php echo (!empty($bookingData['receipt_no'])) ? $bookingData['receipt_no'] : ''; ?>"    placeholder="Rceipt No.">
                                    <div class="error" id="receipt_no_error" >Please Enter Receipt No.</div>
                                </div>
                            </div>
                            <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <input  style="text-align: center" type="button" name="saveBookingForm" id="saveBookingForm" class="btn-continue" value="SAVE AND CONTINUE">
                                  <input type="hidden" name="step3" value="true">
                                  <input type="hidden" name="car_id" id="car_id" value="<?php echo isset($car_id) ? $car_id :0; ?>">
                                  <input type="hidden" name="caseId" id="caseId" value="<?php echo isset($case_id) ? $case_id :0; ?>">

                               </div>
                           </div>
                             </div>

                         
                        
                          
                     </div>
                  </div>
                   </form>
               </div>
            </div>
</div>
<style>
    .error{display:none}
</style>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>    
<script src="<?php echo base_url(); ?>assets/js/usedcarsale_process.js?<?=time()?>" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/usedcarsaleValidation.js?<?=time()?>" type="text/javascript"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script>
  $('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
</script>
   
