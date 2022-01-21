<?php

//print_r($ucSalesCaseInfo);die;

?>
<div class="container-fluid">
               <div class="row">
                   <form name="deliveryForm" id="deliveryForm" method="post" action="">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <h2 class="page-title">Delivery Details</h2>
                     <div class="white-section">
                        <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0"></h2>
                            </div>
                            <?php if(false){ ?>
                              <div class="col-md-6">
                              <div class="form-group">
                                 <label class="crm-label">Delivered</label>
                                  <span class="radio-btn-sec">
                                      <input  type="radio" name="is_delivered" id="delivered_yes" value="yes" class="trigger" <?php echo isset($deliveryData['is_delivered']) && $deliveryData['is_delivered']==1 ? "checked='checked'" : '';?>>
                                     <label for="delivered_yes"><span class="dt-yes"></span> Yes</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input  type="radio" name="is_delivered" id="delivered_no" value="no" class="trigger " <?php echo isset($deliveryData['is_delivered']) && $deliveryData['is_delivered']==0 ? "checked='checked'" : '';?>>
                                     <label for="delivered_no"><span class="dt-yes"></span> No</label>
                                 </span>
                                 <div class="error" id="is_delivered_error" >Please Select One Option</div>
                              </div>
                           </div
                           <?php }?>
                            <div class="col-md-6" id="divcustomername" >
                              <div class="form-group">
                                <label for="" class="crm-label" >Delivery Date*</label>
                                <div class="input-group date" id="dp7">
                                    <input required type="text" class="form-control crm-form insdate crm-form_1" id="delivery_date" name="delivery_date" autocomplete="off" value="<?=!empty($deliveryData['delivery_date'])?date('d-m-Y', strtotime($deliveryData['delivery_date'])):'';?>"  placeholder="Delivery Date">
                                    <span class="input-group-addon">
                                        <span class="">
                                            <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                        </span>
                                    </span>
                                </div>
                                <div class="error" id="delivery_date_error" >Please Select Delivery Date</div>
                               </div>
                                
                            </div>
                            <div class="col-md-6" id="divcustomername" >
                              <div class="form-group">
                                <label for="" class="crm-label" >Invoice Date*</label>
                                <div class="input-group date" id="dp8">
                                    <input required type="text" class="form-control crm-form insdate crm-form_1" id="sold_invoice_date" name="sold_invoice_date" autocomplete="off" value="<?=!empty($deliveryData['sold_invoice_date'])?date('d-m-Y', strtotime($deliveryData['sold_invoice_date'])):'';?>"  placeholder="Invoice Date">
                                    <span class="input-group-addon">
                                        <span class="">
                                            <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                        </span>
                                    </span>
                                </div>
                                 <div class="error" id="sold_invoice_date_error" >Please Select Invoice Date</div>
                               </div>
                                
                            </div>
                            <div class="col-md-6" id="divcustomername" >
                              <div class="form-group">
                                  <label for="sold_invoice_no" class="crm-label" >Invoice no.*</label>
                                  <input required type="text" name="sold_invoice_no" id="sold_invoice_no" class="form-control crm-form" value="<?php echo (!empty($deliveryData['sold_invoice_no'])) ? $deliveryData['sold_invoice_no'] : '';?>"    placeholder="Invoice No." maxlength="15">
                                 <div class="error" id="sold_invoice_no_error" >Please Select Invoice No.</div>
                                 </div>
                                
                            </div>
                            <div class="col-md-6" id="divcustomername" >
                              <div class="form-group">
                                  <label for="gate_pass_no" class="crm-label" >GatePass no.*</label>
                                 <input required type="text" name="gate_pass_no" id="gate_pass_no" class="form-control crm-form" value="<?php echo (!empty($deliveryData['gate_pass_no'])) ? $deliveryData['gate_pass_no'] : '';?>"    placeholder="Gate Pass No."  maxlength="15">
                                 <div class="error" id="gate_pass_no_error" >Please Select GatePass No.</div>
                                 </div>
                                
                            </div>
                            
                            <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <input  style="text-align: center" type="button" name="saveDeliveryForm" id="saveDeliveryForm" class="btn-continue" value="SAVE AND CONTINUE">
                                 <input type="hidden" name="step7" value="true">
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
<style>
    .error{display:none}
</style>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/usedcarsale_process.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/usedcarsaleValidation.js" type="text/javascript"></script>
   
