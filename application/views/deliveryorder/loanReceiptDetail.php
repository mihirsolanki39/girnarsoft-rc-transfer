<a id="gototop"></a>
<div class="container-fluid">
               <div class="row">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <h2 class="page-title">Receiving Detail</h2>
                     <div class="white-section">
                         <form  enctype="multipart/form-data" method="post"  id="receiptDetails" name="receiptDetails">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Payment Done At*</label>
                                 <select class="form-control crm-form lead_source testselect1" id="paymentBy" name="paymentBy">
                                <option value="">Please Select</option>
                                <option value="1"<?php echo (!empty($orderinfo['paymentBy']) && $orderinfo['paymentBy']=='1') ? "selected=selected":''; ?>>Dealership</option>
                                <option value="2"<?php echo (!empty($orderinfo['paymentBy']) && $orderinfo['paymentBy']=='2') ? "selected=selected":''; ?>>Showroom</option>
                            </select>
                            
                                 <div class="error" id="err_paymentBy"></div>
                              </div>
                           </div>
                            <div id="divpaymentdealer" <?php echo (!empty($orderinfo['paymentBy']) && $orderinfo['paymentBy']=='2') ? "style='display:none'" : '';?>> 
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Type Of Payment*</label>
                                 <select class="form-control crm-form lead_source testselect1" id="paymentType" name="paymentType">
                                <option value="">Please Select</option>
                                <option value="1"<?php echo (!empty($orderinfo['paymentType']) && $orderinfo['paymentType']=='1') ? "selected=selected":''; ?>>Full</option>
                                <option value="2"<?php echo (!empty($orderinfo['paymentType']) && $orderinfo['paymentType']=='2') ? "selected=selected":''; ?>>Partial</option>
                            </select>
                            
                                 <div class="error" id="err_paymentType"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Instrument Type*</label>
                                 <select class="form-control crm-form lead_source testselect1" id="instrumentType" name="instrumentType">
                                <option value="">Please Select</option>
                                <option value="1"<?php echo (!empty($orderinfo['intrumentType']) && $orderinfo['intrumentType']=='1') ? "selected=selected":''; ?>>DD</option>
                                <option value="2"<?php echo (!empty($orderinfo['intrumentType']) && $orderinfo['intrumentType']=='2') ? "selected=selected":''; ?>>Cash</option>
                                <option value="3"<?php echo (!empty($orderinfo['intrumentType']) && $orderinfo['intrumentType']=='3') ? "selected=selected":''; ?>>Cheque</option>
                            </select>
                           
                                 <div class="error" id="err_instrumentType"></div>
                              </div>
                           </div> 
                           <div class="col-md-6" id="divinstno"<?php if(!empty($orderinfo['intrumentType']) && ($orderinfo['intrumentType']=='2')){ echo "style='display:none'";}else {echo "style='display:block'";}?>>
                              <div class="form-group abb">
                                 <label for="" class="crm-label">Instrument No.*</label>
                                  <input type="text" class="form-control crm-form" placeholder="Instrument No" name="instrument_no" id="instrument_no" value="<?php echo (!empty($orderinfo['instrumentNo'])) ? $orderinfo['instrumentNo'] : ''?>">
                                   <div class="error" id="err_instrument_no"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group ">
                                 <label for="" class="crm-label">Credited Amount*</label>
                                  <input type="text" class="form-control crm-form rupee-icon" placeholder="Credited Amount" name="credited_amt" id="credited_amt" onpaste="return false;" onkeypress="return isNumberKey(event)" onkeyup="addCommas(this.value, 'credited_amt');" value="<?php echo (!empty($orderinfo['creditAmt'])) ? $orderinfo['creditAmt'] : ''?>">
                                   <div class="error" id="err_credited_amt"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Credited Date*</label>
                                 <div class="input-group date" id="dp">

                                  <input type="text" class="form-control crm-form crm-form_1" placeholder="Credited Date" id="credited_date" name="credited_date" value="<?php echo (!empty($orderinfo['creditDate']) && ($orderinfo['creditDate']!='0000-00-00 00:00:00')) ? date('d-m-Y',strtotime($orderinfo['creditDate'])) : ''?>" >

                                  <span class="input-group-addon">
                                     <span class="">
                                       <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                  </span>
                                 </div>
                                 <div class="error" id="err_credited_date"></div>
                              </div>
                           </div>
                           <div class="col-md-6 abb" <?php if(!empty($orderinfo['intrumentType']) && ($orderinfo['intrumentType']=='2')){ echo "style='display:none'";}else {echo "style='display:block'";}?>>
                              <div class="form-group">
                                 <label for="" class="crm-label">Favouring in*</label>
                                  <input type="text" class="form-control crm-form" placeholder="Favouring in" name="favouring_in" id="favouring_in" onkeypress="return nameOnly(event);" value="<?php echo (!empty($orderinfo['favouring'])) ? $orderinfo['favouring'] : ''?>">
                                   <div class="error" id="err_favouring_in"></div>
                              </div>
                           </div>  
                           <div class="col-md-6 abb " <?php if(!empty($orderinfo['intrumentType']) && ($orderinfo['intrumentType']=='2')){ echo "style='display:none'";}else {echo "style='display:block'";}?>>
                              <div class="form-group">
                                 <label for="" class="crm-label">Drawn On*</label>
                                  <select class="form-control crm-form lead_source testselect1"  id="drawn_on" name="drawn_on">
                                    <option value="">Please Select Bank</option>
                                    <?php foreach ($orderinfo['banklist'] as $key=>$value){ ?>
                                    <option value="<?=$value['bank_id']?>"  <?php echo !empty($orderinfo) && $orderinfo['drawnOn']==$value['bank_id'] ? 'selected=selected' : ''; ?>><?=$value['bank_name']?></option>
                                    <?php } ?>
                                </select>
                                     
                                 <div class="error" id="err_drawn_on"></div>
                              </div>
                           </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Receipt No.</label>
                                  <input type="text" class="form-control crm-form" placeholder="Receipt No" name="receipt_no" id="receipt_no" value="<?php echo (!empty($orderinfo['receipt_no'])) ? $orderinfo['receipt_no'] : ''?>">
                                  
                              </div>
                           </div>  
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Receipt Date</label>
                                 <div class="input-group date" id="dp">
                                  <input type="text" class="form-control crm-form crm-form_1" placeholder="Receipt Date" id="receipt_date" name="receipt_date" value="<?php echo (!empty($orderinfo['receiptDate'])) ? date('d-m-Y',strtotime($orderinfo['receiptDate'])) : ''?>">
                                  <span class="input-group-addon">
                                     <span class="">
                                       <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                  </span>
                                 </div>
                                 <div class="error" id="err_receipt_date"></div>
                              </div>
                           </div>
                            </div>
                            <div class="col-md-6" id="divpaymentshowroom" <?php echo (!empty($orderinfo['paymentBy']) && $orderinfo['paymentBy']=='2') ? '' : "style='display:none';";?>>
                              <div class="form-group">
                                 <label for="" class="crm-label">Amount*</label>
                                  <input type="text" class="form-control crm-form rupee-icon" onkeypress="return isNumberKey(event)" placeholder="Amount" name="amount" id="amount" onkeyup="addCommas(this.value, 'amount');" value="<?php echo (!empty($orderinfo['amount'])) ? $orderinfo['amount'] : ''?>">
                                   <div class="error" id="err_amount"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Payment Remark</label>
                                  <input type="text" class="form-control crm-form" placeholder="Payment Remark" name="payment_remark" id="payment_remark" value="<?php echo (!empty($orderinfo['payment_remark'])) ? $orderinfo['payment_remark'] : ''?>">
                                   <div class="error" id="err_payment_remark"></div>
                              </div>
                           </div>
                         <?php //echo "<PRE>";print_r($orderinfo);?>
                             <input type="hidden" name="receiptForm" value="1" id="receiptForm">
                             <input type="hidden" name="order_id" value="<?php echo (!empty($orderId)) ? $orderId :'';?>">
                             <input type="hidden" name="receipt_id" value="<?php echo (!empty($orderinfo['id'])) ? $orderinfo['id'] :'';?>">
                             <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <button type="button" class="btn-continue"  id="receiptDetailsButton">SAVE AND CONTINUE</button>
                               </div>
                           </div>
                        </div>
                         </form>
                     </div>
                  </div>
               </div>
            </div>
<?php $currentdate=date('Y/m/d');?>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/jquery.sumoselect.min.js"></script>   
<script>
 $('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
    $(document).ready(function() {
      $('#credited_date,#receipt_date').datepicker({
                format: 'dd-mm-yyyy',
                // /startDate: 'd',
                endDate:'+7d',
                autoclose: true,
                todayHighlight: true   
             });
    });
     </script>
<script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>