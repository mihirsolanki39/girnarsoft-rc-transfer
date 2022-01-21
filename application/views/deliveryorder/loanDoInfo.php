<?php //echo "<pre>"; print_r($orderinfo['application_no']); exit;?>
<a id="gototop"></a>
<div class="container-fluid">
               <div class="row">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <h2 class="page-title">Add Delivery Order</h2>
                     <div class="white-section">
                         
                         <form  method="post"  id="deliveryDetails" name="deliveryDetails">
                        <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0">Delivery Order Details</h2>
                            </div>

                           <!--  <div class="col-md-6" style="height:80px;">
                            <div class="form-group">
                                <label class="crm-label">Delivery Against *</label>
                                <span class="radio-btn-sec">
                                    <input type="radio" name="do_status" id="doy" value="1" class="trigger" <?= (!empty($orderinfo) && $orderinfo['do_status']=='1') ?'checked=checked':''?>>
                                    <label for="doy"><span class="dt-yes"></span> DO</label>
                                </span>
                                <span class="radio-btn-sec">
                                    <input type="radio" name="do_status" id="don" value="2" class="trigger" <?= (!empty($orderinfo) && $orderinfo['do_status']=='2') ?'checked=checked':''?>>
                                    <label for="don"><span class="dt-yes"></span> Non-DO</label>
                                </span>
                                 <div class="error" id="err_do_status"></div>
                            </div>
                           </div> -->

                           <div class="col-md-9" style="height:80px;">
                            <div class="form-group">
                                <label class="crm-label">Advance Booking Done *</label>
                                <span class="radio-btn-sec">
                                    <input type="radio" name="booking_done" id="bookyes" value="1" class="trigger" <?= (!empty($orderinfo) && $orderinfo['booking_done']=='1') ?'checked=checked':''?>>
                                    <label for="bookyes"><span class="dt-yes"></span> Yes</label>
                                </span>
                                <span class="radio-btn-sec">
                                    <input type="radio" name="booking_done" id="bookno" value="2" class="trigger" <?= (!empty($orderinfo) && $orderinfo['booking_done']=='2') ?'checked=checked':(empty($orderinfo)?'checked=checked':"")?>>
                                    <label for="bookno"><span class="dt-yes"></span> No</label>
                                </span>
                                 <div class="error" id="err_booking_done"></div>
                            </div>
                           </div>
                            <div class="col-md-6 divbooking" <?php if((!empty($orderinfo) && $orderinfo['booking_done']=='2') || empty($orderinfo)) { echo "style='display:none'";} else { }?>>
                              <div class="form-group">
                                 <label for="" class="crm-label">Booking Slip No *</label>
                                 <input type="text" class="form-control crm-form" placeholder="Booking Slip No" name="booking_slip_no" id="booking_slip_no" onkeyup="return getbookingDetails();"  maxlength="20" value="<?php echo (!empty($orderinfo['booking_slip_no'])) ? $orderinfo['booking_slip_no'] : ''?>">
                                   <div class="error" id="err_booking_slip_no"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Source *</label>
                                 <select class="form-control crm-form lead_source testselect1" id="deliverySource" name="deliverySource">
                                <option value="">Select Source</option>
                                <option value="1"<?php echo (!empty($orderinfo['deliverySource']) && $orderinfo['deliverySource']=='1') ? "selected=selected" : '';?>>Dealer</option>
                                <option value="2"<?php echo (!empty($orderinfo['deliverySource']) && $orderinfo['deliverySource']=='2') ? "selected=selected" : '';?>>Inhouse</option>
                            </select>
                           
                                 <div class="error" id="err_deliverySource"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Delivery Arranged By *</label>
                                 <select class="form-control crm-form testselect1" id="deliveryArg" name="deliveryArg">
                                 <option value="">Please Select</option>
                                <?php foreach ($employeeList as $key=>$value){ ?>
                                <option value="<?=$value['id']?>" <?php echo !empty($orderinfo) && $orderinfo['deliverySales']==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['name']?></option>
                                <?php } ?>
                            </select>
                                 <div class="error" id="err_deliveryArg"></div>
                              </div>
                           </div> 
                            <div class="col-md-6" id="divdealerName" <?php echo !empty($orderinfo['dealer_id']) && (($orderinfo['dealer_id']!='') && ($orderinfo['deliverySource']=='1')) ? '' :'style="display: none;"';?> >
                              <div class="form-group">
                                 <label for="" class="crm-label">Dealer Name</label>
                            <select class="form-control crm-form lead_source testselect1" onchange="return salesExecutive(this)" id="dealerName" name="dealerName">
                            <option value="">Please Select Dealer</option>
                                <?php foreach ($dealerList as $key=>$value){ ?>
                                <option value="<?=$value['id']?>"  <?php echo (!empty($orderinfo['dealer_id']) && ($orderinfo['dealer_id']==$value['id'])) ? 'selected=selected' : ''; ?>><?=$value['organization']?></option>
                            <?php } ?>
                            </select>
                                
                                 <div class="error" id="dealerName_error" ></div>
                                 </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Sales Executive *</label>
                                 <select class="form-control crm-form testselect1" id="deliveryTeam" name="deliveryTeam">
                                 <option value="">Please Select</option>
                                <?php foreach ($employeeSalesList as $key=>$value){ ?>
                                <option value="<?=$value['id']?>" <?php echo !empty($orderinfo) && $orderinfo['deliveryTeam']==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['name']?></option>
                                <?php } ?>
                            </select>
                            
                                 <div class="error" id="err_deliverySales"></div>
                              </div>
                           </div> 
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Delivery Order Date *</label>
                                 <div class="input-group date" id="dp">
                                  <input type="text" class="form-control crm-form crm-form_1" name="do_date" onclick="return changeDate()" id="do_date" value="<?php echo (!empty($orderinfo['do_date']) && ($orderinfo['do_date']!='0000-00-00')) ? date('d-m-Y',strtotime($orderinfo['do_date'])) : ''?>" autocomplete="off"  placeholder="Delivery Order Date" >
                                  <span class="input-group-addon">
                                     <span class="">
                                       <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                  </span>
                                 </div>
                                 <div class="error" id="err_do_date"></div>
                              </div>
                           </div>
                            <div class="col-md-6" style="height:84px;">

                            <div class="form-group">
                                <label class="crm-label">Loan Taken *</label>
                                <span class="radio-btn-sec">
                                    <input type="radio" name="loan_taken" id="yes" value="1" class="trigger" <?= (!empty($orderinfo) && $orderinfo['loan_taken']=='1') ?'checked=checked':(empty($orderinfo)?'checked=checked':"")?>>
                                    <label for="yes"><span class="dt-yes"></span> Yes</label>
                                </span>
                                <span class="radio-btn-sec">
                                    <input type="radio" name="loan_taken" id="no" value="2" class="trigger" <?= (!empty($orderinfo) && $orderinfo['loan_taken']=='2') ?'checked=checked':''?>>
                                    <label for="no"><span class="dt-yes"></span> No</label>
                                </span>
                                 <div class="error" id="err_loan_taken"></div>
                            </div>
                           </div>

                           <div class="col-md-6 divfillloan" style="height:84px; <?php echo (!empty($orderinfo) && $orderinfo['loan_taken']=='1') ? 'display:block;' : 'display:none;'?>">
                            <div class="form-group">
                                <label class="crm-label">Loan Taken From*</label>       
                                <span class="radio-btn-sec">
                                    <input type="radio" name="loan_taken_from" id="other" value="2" class="trigger" <?= (!empty($orderinfo) && $orderinfo['loan_taken_from']=='2') ?'checked=checked':''?>>
                                    <label for="other"><span class="dt-yes"></span> Other</label>
                                </span>
                                <span class="radio-btn-sec">
                                    <input type="radio" name="loan_taken_from" id="inho" value="1" class="trigger " <?= (!empty($orderinfo) && $orderinfo['loan_taken_from']=='1') ?'checked=checked':(empty($orderinfo)?'checked=checked':"")?>>
                                    <label for="inho"><span class="dt-yes"></span> Inhouse</label>
                                </span>
                                 <div class="error" id="err_loan_taken_from"></div>
                            </div>
                           </div>
                           <div class="col-md-6 divfill" style="height:84px; <?php echo (!empty($orderinfo) && ($orderinfo['loan_taken_from']=='1') && ($orderinfo['loan_taken']=='1')) ? '' : 'display:block;'?>">

                            <div class="form-group">
                                <label class="crm-label">Loan Filed *</label>
                                <span class="radio-btn-sec">
                                    <input type="radio" name="loan_filled" id="fillyes" value="1" class="trigger" <?= (!empty($orderinfo) && $orderinfo['loan_filled']=='1')?'checked=checked':''?>>
                                    <label for="fillyes"><span class="dt-yes"></span> Yes</label>
                                </span>
                                <span class="radio-btn-sec">
                                    <input type="radio" name="loan_filled" id="fillno" value="2" class="trigger" <?= (!empty($orderinfo) && $orderinfo['loan_filled']=='2')?'checked=checked':(empty($orderinfo)?'checked=checked':"")?>>
                                    <label for="fillno"><span class="dt-yes"></span> Not Yet</label>
                                </span>
                                 <div class="error" id="err_loan_filled"></div>
                            </div>
                           </div> 
                           <?php

                           ?>
                           <div class="col-md-6 divloan" style="<?php echo (!empty($orderinfo) && ($orderinfo['loan_taken_from']=='1') && ($orderinfo['loan_taken']=='1') && ($orderinfo['loan_filled']=='1')) ? 'display:block;' : 'display:none !important;'?>">
                              <div class="form-group">
                                 <label for="" class="crm-label">Loan application No *</label>
                                 <input type="text" class="form-control crm-form" placeholder="Loan Application No" name="application_no" id="application_no" onkeypress="return loanReceiptNoValidate(event)" onkeyup="return getloanDetails();" maxlength="10" value="<?php echo (!empty($orderinfo['application_no'])) ? $orderinfo['application_no'] : ''?>">
                                   <div class="error" id="err_application_no"></div>
                              </div>
                           </div>

                                                     <!--  <div class="col-md-6" style="display:none;">
                              <div class="form-group">
                                 <label for="" class="crm-label">Delivery Order No *</label>
                                  <input type="text" class="form-control crm-form" onkeypress="return blockSpecialChar(event)" placeholder="Delivery Order No" name="do_no" id="do_no" maxlength="10" value="<?php echo (!empty($orderinfo['do_no'])) ? $orderinfo['do_no'] : ''?>" >
                                   <div class="error" id="err_do_no"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Delivery Order Amount *</label>
                                  <input type="text" class="form-control crm-form rupee-icon" onkeypress="return isNumberKey(event);" onpaste="return false;" autocomplete="off" onkeyup="addCommas(this.value, 'do_amt');convertNumberToWords(this.value);" 
          
                                  placeholder="Delivery Order Amount" name="do_amt" id="do_amt" maxlength="10" value="<?php echo (!empty($orderinfo['do_amt'])) ? $orderinfo['do_amt'] : ''?>">
                                   <div class="error" id="err_do_amt"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Delivery Order Amount(In words) *</label>
                                 <input type="text" class="form-control crm-form" onkeypress="return nameOnly(event);" onpaste="return false;" placeholder="Delivery Order Amount" name="do_amt_word" id="do_amt_word" value="<?php echo (!empty($orderinfo['do_amt_word'])) ? $orderinfo['do_amt_word'] : ''?>" readonly="readonly">
                                   <div class="error" id="err_do_amt_word"></div>
                              </div>
                           </div>  
                        </div>-->
                        <a id="gotoshow"></a>
                         <div class="">
                           <div class="col-md-12">
                             <h2 class="sub-title">Showroom Information</h2>
                            </div>
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="crm-label">Showroom *</label>
                                        <select class="form-control crm-form lead_source search-box sroom search_test"  onchange="return getDealerDetails();" id="showroomName" name="showroomName">
                                        <option value="">Please Select</option>
                                            <?php foreach ($showroomList as $key=>$value){ ?>
                                            <option value="<?=$value['id']?>"  <?php echo !empty($orderinfo) && $orderinfo['showroomName']==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['organization']?></option>
                                        <?php } ?>
                                        </select>
                                       
                                          <div class="error" id="err_showroomName"></div>
                                    </div>
                                </div>
                           <div class="col-md-6" style="height:85px;">
                              <div class="form-group">
                                 <label for="" class="crm-label">Address </label>
                                  <input type="text" class="form-control crm-form form-read" placeholder="address" name="showroom_address" id="showroom_address" value="<?php echo (!empty($orderinfo['showroomAddress'])) ? ucwords($orderinfo['showroomAddress']) :'';?>">
                                   <div class="error" id="err_showroom_address"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Kind Attention *</label>
                                  <input type="text" class="form-control crm-form" onkeypress="return nameOnly(event);" placeholder="Kind Attention" name="kind_attn" id="kind_attn"  value="<?php echo (!empty($orderinfo['kind_attn'])) ? ucwords($orderinfo['kind_attn']) : '';?>">
                                  <div class="error" id="err_kind_attn"></div>
                                 </div>
                            </div>
                         
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Delivery Date *</label>
                                 <div class="input-group date" id="dp">
                                  <input type="text" autocomplete="off" class="form-control crm-form crm-form_1" placeholder="Delivery Date" id="delivery_date" name="delivery_date" value="<?php echo (!empty($orderinfo['delivery_date']) && ($orderinfo['delivery_date']!='0000-00-00')) ? date('d-m-Y',strtotime($orderinfo['delivery_date'])) : ''?>" >
                                  <span class="input-group-addon">
                                     <span class="">
                                       <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                  </span>
                                 </div>
                                 <div class="error" id="err_delivery_date"></div>
                              </div>
                           </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Expected Payment Date *</label>
                                 <div class="input-group date" id="dp">

                                  <input type="text" autocomplete="off" class="form-control crm-form crm-form_1" placeholder="Expected Payment Date" id="exp_payment_date" name="exp_payment_date" value="<?php echo (!empty($orderinfo['exp_payment_date']) && ($orderinfo['exp_payment_date']!='0000-00-00')) ? date('d-m-Y',strtotime($orderinfo['exp_payment_date'])) : ''?>">

                                  <span class="input-group-addon">
                                     <span class="">
                                       <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                  </span>
                                 </div>
                                 <div class="error" id="err_exp_payment_date"></div>
                              </div>
                           </div>
                             
                        </div>
                        <a id="gotocustomer"></a>
                         <div class="">
                           <div class="col-md-12">
                             <h2 class="sub-title">Customer Information</h2>
                            </div>
                           
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Mobile No *</label>
                                  <input type="text" class="form-control crm-form" onkeypress="return isNumberKey(event);" placeholder="Mobile No" onpaste="return false;" name="customer_mobile_no" maxlength="10" id="customer_mobile_no" value="<?php echo (!empty($orderinfo['customer_mobile_no'])) ? $orderinfo['customer_mobile_no'] : '';?>">
                                  <div class="error" id="err_customer_mobile_no"></div>
                                 </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Name *</label>
                                  <input type="text" class="form-control crm-form" onpaste="return false;" onkeypress="return nameOnly(event);" placeholder="Name" id="customer_name" name="customer_name" value="<?php echo (!empty($orderinfo['customer_name'])) ? ucwords($orderinfo['customer_name']) : ''?>">
                                   <div class="error" id="err_customer_name"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Address *</label>
                                  <input type="text" class="form-control crm-form" placeholder="Address" onkeypress="return blockSpecialChar(event)" id="customer_address" name="customer_address" value="<?php echo (!empty($orderinfo['customer_address'])) ? ucwords($orderinfo['customer_address']) : ''?>">
                                   <div class="error" id="err_customer_address"></div>
                                 </div>
                            </div>
                         </div>
                         <a id="gotovehi"></a>
                            <div class="">
                           <div class="col-md-12">
                             <h2 class="sub-title">Vehicle Information</h2>
                            </div>
                           <!--<div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Make *</label>
                                 <select class="form-control crm-form search_test" name="make" id="make">
                                    <option selected="selected" value="">Select Make</option>
                                    <?php if(!empty($makeList)){ ?>
                                    <?php foreach($makeList as $makeData){?>
                                    <option value="<?php echo $makeData->id;?>"<?php echo ((!empty($orderinfo['make'])) && $orderinfo['make']==$makeData->id) ? "selected=selected" : '';?>><?php echo $makeData->make;?></option>
                                    <?php }} ?> 
                                 </select>
                                 <div class="error" id="err_make" ></div>
                                 
                                 </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Model *</label>
                                 <select class="form-control crm-form crm-form_read_only search_test" name="model" id="model" <?php if(!empty($orderinfo['model'])) { echo ''; }else{ ?>readonly="readonly" <?php } ?>>
                                     <option value="">Please Select</option>
                                     <?php if(!empty($orderinfo['model']) && !empty($model)) {
                                    foreach ($model as $key =>$value) {
                                   ?>
                                   <option  value="<?= $value['id'];?>" <?= (!empty($orderinfo['model']) && $orderinfo['model']==$value['id'])?'selected=selected':''?>><?= $value['model']?></option>
                                     <?php  } } ?>
                                 </select>
                                 <div class="error" id="err_model" ></div>
                                
                              </div>
                           </div>-->
                           <input type="hidden" value="<?=$orderinfo['make'];?>" id="make" name="make">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Make Model *</label>
                                 <select class="form-control crm-form crm-form_read_only search_test" name="model" id="model">
                                     <option value="">Please Select</option>
                                     <?php if(!empty($makeList)) {
                                    foreach ($makeList as $key =>$value) {
                                   ?>
                                   <option rel="<?= $value['make_id'];?>"  value="<?= $value['model_id'];?>" <?= (!empty($orderinfo['model']) && $orderinfo['model']==$value['model_id'])?'selected=selected':''?>><?=$value['make'] .' '.$value['model']?></option>
                                     <?php  } } ?>
                                 </select>
                                 <div class="error" id="err_model" ></div>
                                 
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Version *</label>
                                 <select class="form-control crm-form crm-form_read_only search_test" name="variant" id="versionId" <?php if(!empty($orderinfo['variant'])) { echo ''; }else{ ?>readonly="readonly" <?php } ?>>
                                     <option value="">Please Select</option>
                                     <?php if(!empty($version)) {
                                    foreach ($version as $key =>$value) {?>
                                   <option  value="<?= $value['db_version_id'];?>" <?= (!empty($orderinfo['variant']) && $orderinfo['variant']==$value['db_version_id'])?'selected=selected':''?>><?= $value['db_version']?></option>
                                  <?php  } } ?>
                                 </select>
                                 <div class="error" id="err_variant" ></div>
                                 
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Color *</label>
                                  <select class="form-control crm-form reg_reqq search_test" id="color" name="color">
                                    <option value="">Select</option> 
                                    <?php 
                                    foreach ($colArr as $col) 
                                    { 
                                    ?> 
                                        <option class="col" value="<?php echo $col; ?>" <?php echo (!empty($orderinfo['color']) && $orderinfo['color'] == $col) ? "selected" : ''; ?>><?php echo $col; ?></option> 
                                    <?php 
                                    } 
                                    ?>
                                </select>
                                
                                <div class="error" id="err_color"></div>
                              </div>
                           </div>
                          
                           <!-- <div class="col-md-6">
                              <div class="form-group">
                                  <label for="" class="crm-label">New Car Price (Ex-Showroom) *</label>
                                 <input type="text" class="form-control crm-form rupee-icon" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'new_car_price');" autocomplete="off" onpaste="return false;" placeholder="New Car Price" id="new_car_price" name="new_car_price" value="<?php echo (!empty($orderinfo['new_car_price'])) ? $orderinfo['new_car_price'] : ''?>">
                                   <div class="error" id="err_new_car_price"></div>
                              </div>
                           </div>-->
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Insurance By*</label>
                                 <select class="form-control crm-form lead_source testselect1" id="insurance" name="insurance">
                                <option value="">Select Insurance</option>
                                <option value="1"<?php echo (!empty($orderinfo['insurance']) && $orderinfo['insurance']=='1') ? "selected=selected" : '';?>>Showroom</option>
                                <option value="2"<?php echo (!empty($orderinfo['insurance']) && $orderinfo['insurance']=='2') ? "selected=selected" : '';?>>Inhouse</option>
                                <option value="3"<?php echo (!empty($orderinfo['insurance']) && $orderinfo['insurance']=='3') ? "selected=selected" : '';?>>Dealer</option>

                            </select>
                            
                                 <div class="error" id="err_insurance"></div>
                              </div>
                           </div> 
                           
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Registration Type</label>
                                 <select class="form-control crm-form lead_source testselect1" id="reg_type" name="reg_type">
                                <option value="">Select Registration Type</option>
                                <option value="1"<?php echo (!empty($orderinfo['reg_type']) && $orderinfo['reg_type']=='1') ? "selected=selected" : '';?>>Private Number</option>
                                <option value="2"<?php echo (!empty($orderinfo['reg_type']) && $orderinfo['reg_type']=='2') ? "selected=selected" : '';?>>Commercial Number</option>

                            </select>
                            
                                 <div class="error" id="err_reg_type"></div>
                              </div>
                           </div> 
                           </div>
                        <a id="gotoprice"></a>
                            <div class="">
                           <div class="col-md-12">
                             <h2 class="sub-title">Price Details</h2>
                              </div>   
                               <div class="col-md-12 row mrg-B20">
                                 <div class="col-md-6">
                                <div class="form-group">
                                   <label for="" class="crm-label">Gross DO Amount*</label>
                                    <input type="text" class="form-control crm-form rupee-icon" placeholder="Gross DO Amount" id="gross_do_amt" name="gross_do_amt" value="<?php echo (!empty($orderinfo['gross_do_amt'])) ? $orderinfo['gross_do_amt'] : ''?>" readonly="readonly">
                                     <div class="error" id="err_gross_do_amt"></div>
                                   </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group">
                                   <label for="" class="crm-label">Showroom Discount</label>
                                    <input type="text" class="form-control crm-form rupee-icon" placeholder="Showroom Discount" name="showroom_disc" maxlength="10" id="showroom_disc" autocomplete="off" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'showroom_disc');" value="<?php echo (!empty($orderinfo['showroom_disc'])) ? $orderinfo['showroom_disc'] : '';?>" readonly="readonly">
                                    <div class="error" id="err_showroom_disc"></div>
                                   </div>
                                    
                                      <span class="">
                                          <input name="sameas" <?php echo (!empty($orderinfo['sameas']) && $orderinfo['sameas']==1)?'checked=checked':''?> id="sameas" value="1" class="trigger"  type="checkbox">
                                          <label for="sameas"><span class="dt-yes"></span> Deduct Discount from Net DO Amount</label>
                                      </span>
                          
                              </div>
                             </div>

                             <div class="col-md-12 row mrg-B20">

                                <div class="col-md-6">
                                  <div class="form-group">
                                     <label for="" class="crm-label">Discount Shared</label>
                                      <input type="text" class="form-control crm-form rupee-icon" placeholder=" Discount Shared" name="scheme_disc" maxlength="10" id="scheme_disc" autocomplete="off" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'scheme_disc');" value="<?php echo (!empty($orderinfo['scheme_disc'])) ? $orderinfo['scheme_disc'] : '';?>" readonly="readonly">
                                      <div class="error" id="err_scheme_disc"></div>
                                     </div>
                                    <span class="">
                                            <input name="include_dis_shared" <?php echo (!empty($orderinfo['include_dis_shared']) && $orderinfo['include_dis_shared']==1)?'checked=checked':''?> id="include_dis_shared" value="1" class="trigger"  type="checkbox">
                                            <label for="include_dis_shared"><span class="dt-yes"></span> Deduct Discount from Net DO Amount</label>
                                    </span>
                                </div>
                                
                              <div class="col-md-6" id="divfinance" <?php echo (!empty($orderinfo) && $orderinfo['loan_taken']=='1') ? '' : 'style="display:none;"'?>>
                                  <div class="form-group" id="hp_inhouse" <?php echo (!empty($orderinfo) && $orderinfo['loan_taken_from']=='1') ? 'style="display:block;"' : 'style="display:none;"'?>>
                                     <label for="" class="crm-label">HP to *</label>
                                      <select class="form-control crm-form reg_reqq search_test" name="hp_tos" id="hp_tos">
                                         <option value="">Please Select</option>
                                         <?php if(!empty($banklist)) {
                                        foreach ($banklist as $key =>$value) {?>
                                       <option  value="<?= $value['id'];?>" <?= (!empty($orderinfo['hp_to']) && $orderinfo['hp_to']==$value['id'])?'selected=selected':''?>><?= $value['bank_name']?></option>
                                      <?php  } } ?>
                                     </select>  
                                  </div>
                
                                  <?php // echo "<pre>";print_r($cusbanklist); die; ?>
                                   <div class="form-group" id="hp_other" <?php echo (!empty($orderinfo) && $orderinfo['loan_taken_from']=='2') ? 'style="display:block;"' : 'style="display:none;"'?> >
                                     <label for="" class="crm-label">HP to *</label>
                                      <select class="form-control crm-form reg_reqq search_test" name="hp_to" id="hp_to">
                                         <option value="">Please Select</option>
                                         <?php if(!empty($cusbanklist)) {
                                        foreach ($cusbanklist as $key =>$value) {?>
                                       <option  value="<?= $value['bank_id'];?>" <?= (!empty($orderinfo['hp_to']) && $orderinfo['hp_to']==$value['bank_id'])?'selected=selected':''?>><?= $value['bank_name']?></option>
                                      <?php  } } ?>
                                     </select>
                                  </div>
                                  <div class="error" id="err_hp_to"></div>
                                  <input type="hidden" name="hp_tos_hidden" id="hp_tos_hidden" value="" style='display:none;'>
                               </div>

                             </div>

                              <div class="col-md-12 row mrg-B20">

                               <div class="col-md-6 divloanamount" <?php echo (!empty($orderinfo) && $orderinfo['loan_taken']=='1') ? 'display:block;' : 'display:none;'?>">
                                  <div class="form-group">
                                     <label for="" class="crm-label">Loan Amount</label>
                                      <input type="text" class="form-control crm-form rupee-icon" placeholder="Loan Amount" name="loan_amt" maxlength="10" id="loan_amt" autocomplete="off" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'loan_amt');" value="<?php echo (!empty($orderinfo['loan_amt'])) ? $orderinfo['loan_amt'] : '';?>">
                                      <div class="error" id="err_loan_amt"></div>
                                     </div>
                                     
                                        <span class="">
                                            <input name="sameasloan"  <?php echo (!empty($orderinfo['sameasloan']) && $orderinfo['sameasloan']==1)?'checked=checked':''?>  id="sameasloan" value="1" class="trigger"  type="checkbox">
                                            <label for="sameasloan"><span class="dt-yes"></span> Deduct Loan from Net DO Amount</label>
                                        </span>
                            
                                </div>
                                <div class="col-md-6 deductfromloandiv" <?php echo (!empty($orderinfo) && $orderinfo['loan_taken']=='1') ? 'display:block;' : 'display:none;'?>">
                                  <div class="form-group">
                                      <label for="" class="crm-label">Deduction from Loan</label>
                                     <input type="text" class="form-control crm-form rupee-icon" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'dedu_loan');" autocomplete="off" onpaste="return false;" placeholder="Deduction from Loan" id="dedu_loan" name="dedu_loan" value="<?php echo (!empty($orderinfo['dedu_loan'])) ? $orderinfo['dedu_loan'] : ''?>" maxlength="8">
                                       <div class="error" id="err_dedu_loan"></div>
                                  </div>
                               </div>
                              </div>

                               <div class="col-md-12 row mrg-B20">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="crm-label">Margin Money from Customer</label>
                                       <input type="text" class="form-control crm-form rupee-icon" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'margin_money');" autocomplete="off" onpaste="return false;" placeholder="Margin Money From Customer" id="margin_money" name="margin_money" value="<?php echo (!empty($orderinfo['margin_money'])) ? $orderinfo['margin_money'] : '0'?>" maxlength="9">
                                         <div class="error" id="err_margin_money"></div>
                                    </div>
                                      <span class="">
                                              <input name="include_margin_money_cus"  <?php echo (!empty($orderinfo['include_margin_money_cus']) && $orderinfo['include_margin_money_cus']==1)?'checked=checked':(empty($orderinfo)?'checked=checked':'')?>  id="include_margin_money_cus" value="1" class="trigger"  type="checkbox">
                                              <label for="include_margin_money_cus"><span class="dt-yes"></span> Deduct Margin Money from Net DO Amount</label>
                                      </span> 
                                 </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="crm-label">Margin Money from Inhouse</label>
                                       <input type="text" class="form-control crm-form rupee-icon" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'margin_money_inhouse');" autocomplete="off" onpaste="return false;" placeholder="Margin Money From Inhouse" id="margin_money_inhouse" name="margin_money_inhouse" value="<?php echo (!empty($orderinfo['margin_money_inhouse'])) ? $orderinfo['margin_money_inhouse'] : '0'?>"  maxlength="9">
                                         <div class="error" id="err_margin_money"></div>
                                    </div>
                                      <span class="">
                                              <input name="include_margin_money_in"  <?php echo (!empty($orderinfo['include_margin_money_in']) && $orderinfo['include_margin_money_in']==1)?'checked=checked':''?>  id="include_margin_money_in" value="1" class="trigger"  type="checkbox">
                                              <label for="include_margin_money_in"><span class="dt-yes"></span> Deduct Margin Money Inhouse from Net DO Amount</label>
                                      </span>
                                 </div>
                                      <input type="hidden" class="form-control crm-form rupee-icon"  autocomplete="off"  id="hiden_margin_money" value="<?php echo (!empty($orderinfo['margin_money'])) ? $orderinfo['margin_money'] : '0'?>">
                                </div>

                                 <div class="col-md-12 row">
                                   <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="" class="crm-label">Net DO Amount</label>
                                         <input type="text" class="form-control crm-form rupee-icon" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'net_do_amt');" autocomplete="off" onpaste="return false;" placeholder="New Car Price" id="net_do_amt" name="net_do_amt" value="<?php echo (!empty($orderinfo['net_do_amt'])) ? $orderinfo['net_do_amt'] : ''?>" readonly="readonly">
                                           <div class="error" id="err_net_do_amt"></div>
                                      </div>
                                   </div>
                                        
                                    <div class="col-md-6" id="insu_premium_div">
                                      <div class="form-group">
                                         <label for="" class="crm-label">Insurance Premium*</label>
                                          <input type="text" class="form-control crm-form rupee-icon" placeholder="Insurance Premium" id="insu_premium" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'insu_premium');" name="insu_premium" value="<?php echo (!empty($orderinfo['insu_premium'])) ? $orderinfo['insu_premium'] : ''?>" maxlength="9">
                                           <div class="error" id="err_insu_premium"></div>
                                         </div>
                                    </div>

                                  </div>
                           <input type="hidden" name="do_amt" value="<?php echo (!empty($orderinfo['do_amt'])) ? $orderinfo['do_amt'] : ''?>" id="do_amt">
                            <input type="hidden" name="deliveryForm" value="1" id="deliveryForm">
                             <input type="hidden" name="hypoto" value="0" id="hypoto">
                             <input type="hidden" value="<?= !empty($order_id)? $order_id:'' ?>" name="order_id">



                              <!---->
                              <input type="hidden" name="disn[]" id="disn_dis" value="">
                              <input type="hidden" name="disp[]" id="disp_dis" value="">
                              <input type="hidden" name="showroom_dis" id="showroom_dis" value="<?=!empty($orderinfo['dshowroom_dis'])?$orderinfo['dshowroom_dis']:''?>">
                              <input type="hidden" name="schemes_dis" id="schemes_dis" value="<?=!empty($orderinfo['dscheme_dis'])?$orderinfo['dscheme_dis']:''?>">

                              <!-- added params start by Masawwar Ali -->
                               <input type="hidden" name="ex_disc_dis" id="ex_disc_dis" value="<?=!empty($orderinfo['dis_ex_disc'])?$orderinfo['dis_ex_disc']:''?>">
                               <input type="hidden" name="loyalty_dis" id="loyalty_dis" value="<?=!empty($orderinfo['dis_loyalty'])?$orderinfo['dis_loyalty']:''?>">
                               <input type="hidden" name="corporate_dis" id="corporate_dis" value="<?=!empty($orderinfo['dis_corporate'])?$orderinfo['dis_corporate']:''?>">
                              <!--added params end   by Masawwar Ali-->
                                     
                              <input type="hidden" name="distotal_dis" id="distotal_dis" value="<?=!empty($orderinfo['total_dis_amount'])?$orderinfo['total_dis_amount']:''?>">
                              
                              <input type="hidden" name="disn2[]" id="disn_show" value="">
                              <input type="hidden" name="disp2[]" id="disp_show" value="">
                              <input type="hidden" name="showroom_show" id="showroom_show" value="<?=!empty($orderinfo['showroom_discount'])?$orderinfo['showroom_discount']:''?>">
                              <input type="hidden" name="schemes_show" id="schemes_show" value="<?=!empty($orderinfo['scheme'])?$orderinfo['scheme']:''?>">
                             
                              <!--additional param added  start by Masawwar Ali-->
                              <input type="hidden" name="ex_disc_show" id="ex_disc_show" value="<?=!empty($orderinfo['show_ex_disc'])?$orderinfo['show_ex_disc']:''?>">

                              <input type="hidden" name="loyalty_show" id="loyalty_show" value="<?=!empty($orderinfo['show_loyalty'])?$orderinfo['show_loyalty']:''?>">

                              <input type="hidden" name="corporate_show" id="corporate_show" value="<?=!empty($orderinfo['show_corporate'])?$orderinfo['show_corporate']:''?>">


                              
                              <!--additional param added   end  by Masawwar Ali-->

                              <input type="hidden" name="distotal_show" id="distotal_show" value="<?=!empty($orderinfo['total_showroom_discount'])?$orderinfo['total_showroom_discount']:''?>">
                              <!---->

                               <!---->
                              <input type="hidden" name="disn1[]" id="disn_in" value="">
                              <input type="hidden" name="disp1[]" id="disp_in" value="">
                              <input type="hidden" name="grs_amts" id="grs_amt_in" value="<?=!empty($orderinfo['gross_do_amt'])?$orderinfo['gross_do_amt']:''?>">
                              <input type="hidden" name="ex_shows" id="ex_show_in" value="<?=!empty($orderinfo['ex_show'])?$orderinfo['ex_show']:''?>">
                              <input type="hidden" name="tcss" id="tcs_in" value="<?=!empty($orderinfo['tcs'])?$orderinfo['tcs']:''?>">
                              <input type="hidden" name="epcs" id="epc_in" value="<?=!empty($orderinfo['epc'])?$orderinfo['epc']:''?>">
                              <input type="hidden" name="road_taxs" id="road_tax_in" value="<?=!empty($orderinfo['road_tax'])?$orderinfo['road_tax']:''?>">

                              <input type="hidden" name="insu_premium_dos" id="insu_premium_do_in" value="<?=!empty($orderinfo['do_insu_premium'])?$orderinfo['do_insu_premium']:''?>">
                              <input type="hidden" name="external_warrantys" id="external_warranty_in" value="<?=!empty($orderinfo['do_external_warranty'])?$orderinfo['do_external_warranty']:''?>">
                              <!---->


                          <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <button type="button" class="btn-continue"  id="deliveryDetailsButton">SAVE AND CONTINUE</button>
                               </div>
                           </div>
                        

                            </div>
                         </form>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="my ModalLabel" aria-hidden="true" id="pricebreakup">
              <div class="modal-backdrop fade in" style="height: 100%;"></div>
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header bg-gray">
                  <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg"><span class="sr-only">Close</span></button>
                  <h4 class="modal-title">Price Breakup</h4>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-6">
                        Ex-Showroom Price
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <input type="text" maxlength="10" autocomplete="off" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'ex_show');" value="<?php echo (!empty($orderinfo['ex_show'])) ? $orderinfo['ex_show'] : '';?>" name="ex_show" id="ex_show" class="form-control crm-form rupee-icon">
                        </div>
                     </div>

                      <div class="col-md-6">
                        Road Tax
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                          <input type="text" maxlength="10" autocomplete="off"  onblur="saveGrossAmt()" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'road_tax');" value="<?php echo (!empty($orderinfo['road_tax'])) ? $orderinfo['road_tax'] : '';?>" name="road_tax" id="road_tax" class="form-control crm-form rupee-icon">
                        </div>
                     </div>


                     <!-- extra additional fields added start-->
                      <div id="insu_premium_div_on_do">
                       <div class="col-md-6" >
                        Insurance Premium
                       </div>
                       <div class="col-md-6" >
                          <div class="form-group" >
                            <input type="text" maxlength="10" autocomplete="off"  onblur="saveGrossAmt()" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'insu_premium_do');" value="<?php echo (!empty($orderinfo['do_insu_premium'])) ? $orderinfo['do_insu_premium'] : '';?>" name="insu_premium_do" id="insu_premium_do" class="form-control crm-form rupee-icon">
                          </div>
                       </div>
                     </div>

                     <div class="col-md-6" >
                        Ext. Warranty
                     </div>
                     <div class="col-md-6" >
                        <div class="form-group">
                          <input type="text" maxlength="10" autocomplete="off"  onblur="saveGrossAmt()" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'external_warranty');" value="<?php echo (!empty($orderinfo['do_external_warranty'])) ? $orderinfo['do_external_warranty'] : '';?>" name="external_warranty" id="external_warranty" class="form-control crm-form rupee-icon">
                        </div>
                     </div>
                 
                     <!-- extra additional fields added ends -->

                      <div class="col-md-6">
                        EPC
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" maxlength="10" autocomplete="off"  onblur="saveGrossAmt()" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'epc');" value="<?php echo (!empty($orderinfo['epc'])) ? $orderinfo['epc'] : '';?>" name="epc" id="epc" class="form-control crm-form rupee-icon">
                        </div>
                     </div>

                     <div class="col-md-6">
                        TCS
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" maxlength="10" autocomplete="off" onblur="saveGrossAmt()" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'tcs');" value="<?php echo (!empty($orderinfo['tcs'])) ? $orderinfo['tcs'] : '';?>" name="tcs" id="tcs" class="form-control crm-form rupee-icon">
                        </div>
                     </div>

                  </div>
                  <div class="row">
                     <div class="col-md-12 mrg-B10"><h4>Add Ons</h4></div>
                     <div class="row inputAppend1">
                      <?php  if(empty($priceBreakup)) {?>
                        <div class="col-md-12 appendItem">
                            <div class="">
                                <div class="col-md-5">
                                          <div class="form-group">
                                              <input name="discountname1[]"  onkeypress="return alphaOnly(event);" type="text" class="form-control disn1">
                                          </div>
                                      </div>
                                      <div class="col-md-5">
                                          <div class="form-group">
                                              <input name="discountprice1[]"  onblur="saveGrossAmt()" onkeypress="return isNumberKey(event);"  type="text" class="form-control disp1 rupee-icon">
                                          </div>
                                      </div>
                                <div class="col-md-1 pad-L5 plusMinus">
                                    <a href="javascript:void(0);" class="pluss added" onclick="plusabc(this,'inputAppend1')"></a>
                                </div>
                            </div>
                        </div>
                        <?php } else{
                          $i =0;
                          foreach ($priceBreakup as $pk => $pv) {?>
                            <div class="col-md-12 appendItem">
                            <div class="">
                                <div class="col-md-5">
                                          <div class="form-group">
                                              <input name="discountname1[]" onkeypress="return alphaOnly(event);" value="<?php echo (!empty($pv['p_name'])) ? $pv['p_name'] : '';?>" type="text" class="form-control disn1">
                                          </div>
                                      </div>
                                      <div class="col-md-5">
                                          <div class="form-group">
                                              <input name="discountprice1[]" onkeypress="return isNumberKey(event);" value="<?php echo (!empty($pv['p_price'])) ? indian_currency_form($pv['p_price']) : '';?>"  type="text" class="form-control disp1">
                                          </div>
                                      </div>
                                <div class="col-md-1 pad-L5 plusMinus">
                                  <?php if($i!=0){ ?>
                                    <a href="javascript:void(0);" class="pluss added minus"></a>
                                  <?php  }else{?>
                                     <a href="javascript:void(0);" class="pluss added" onclick="plusabc(this,'inputAppend1')"></a>
                                   <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?  $i++;}

                          }?>
                    </div>
                  </div>
                   <div class="row">
                       <div class="col-md-6">
                        Gross DO Amount
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <input type="text" onkeyup="addCommas(this.value, 'grs_amt');" value="<?php echo (!empty($orderinfo['gross_do_amt'])) ? $orderinfo['gross_do_amt'] : '';?>" name="grs_amt" id="grs_amt" class="form-control crm-form rupee-icon" readonly="readonly">
                        </div>
                     </div>
                   </div>
               </div>
               <div class="modal-footer">
                  
                  <button type="button" onclick="saveGrossAmt(1);" class="btn btn-primary">SAVE</button>
               </div>
            </div>
            <!-- /.modal-comment -->
         </div>
      </div>


       <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="my ModalLabel" aria-hidden="true" id="showroombreakup">
        <div class="modal-backdrop fade in" style="height: 100%;"></div>
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header bg-gray">
                  <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg"><span class="sr-only">Close</span></button>
                  <h4 class="modal-title"> Showroom Discount Breakup</h4>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-6">
                        Showroom Discount
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <input type="text" maxlength="10" onblur="saveShowAmt1()" autocomplete="off" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'showroom_discount');" value="<?php echo (!empty($orderinfo['showroom_discount'])) ? $orderinfo['showroom_discount'] : '';?>" name="showroom_discount" id="showroom_discount" class="form-control crm-form rupee-icon">
                        </div>
                     </div>

                
                     <div class="col-md-6">
                         Scheme Discount
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <input type="text" maxlength="10" onblur="saveShowAmt1()" autocomplete="off" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'schemes');" value="<?php echo (!empty($orderinfo['scheme'])) ? $orderinfo['scheme'] : '';?>" name="scheme" id="schemes" class="form-control crm-form rupee-icon">
                        </div>
                     </div>

                     <!-- extra added start by Masawwar Ali-->
                      <div class="col-md-6">
                        Exchange Discount
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <input type="text" maxlength="10" onblur="saveShowAmt1()" autocomplete="off" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'show_ex_disc');" value="<?php echo (!empty($orderinfo['show_ex_disc'])) ? $orderinfo['show_ex_disc'] : '';?>" name="show_ex_disc" id="show_ex_disc" class="form-control crm-form rupee-icon">
                        </div>
                     </div>

                      <div class="col-md-6">
                        Loyalty
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <input type="text" maxlength="10" onblur="saveShowAmt1()" autocomplete="off" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'show_loyalty');" value="<?php echo (!empty($orderinfo['show_loyalty'])) ? $orderinfo['show_loyalty'] : '';?>" name="show_loyalty" id="show_loyalty" class="form-control crm-form rupee-icon">
                        </div>
                     </div>

                     <div class="col-md-6">
                        Corporate
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <input type="text" maxlength="10" onblur="saveShowAmt1()" autocomplete="off" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'show_corporate');" value="<?php echo (!empty($orderinfo['show_corporate'])) ? $orderinfo['show_corporate'] : '';?>" name="show_corporate" id="show_corporate" class="form-control crm-form rupee-icon">
                        </div>
                     </div>

                    
                      <!-- extra added end   by Masawwar Ali-->
</div>

                    
                  <div class="row">
                     <div class="col-md-12 mrg-B10"><h4>Additional Discounts</h4></div>
                     <div class="0 inputAppend2">
                     <?php  if(empty($showroomDiscount)) {?>
                        <div class="col-md-12 appendItem">
                            <div class="0">
                               <div class="col-md-5">
                                          <div class="form-group">
                                              <input name="discountname2[]"  onkeypress="return alphaOnly(event);" type="text" class="form-control disn2">
                                          </div>
                                      </div>
                                      <div class="col-md-5">
                                          <div class="form-group">
                                              <input name="discountprice2[]" onblur="saveShowAmt1()" onkeypress="return isNumberKey(event);"  type="text" class="form-control disp2 rupee-icon">
                                          </div>
                                      </div>
                                <div class="col-md-1 pad-L5 plusMinus">
                                    <a href="javascript:void(0);" class="pluss added" onclick="plusabc(this,'inputAppend2')"></a>
                                </div>
                            </div>
                        </div>
                        <? } else{
                          $j = 0;
                          foreach ($showroomDiscount as $sk => $sv) {?>
                            <div class="col-md-12 appendItem">
                            <div class="">
                                <div class="col-md-5">
                                          <div class="form-group">
                                              <input name="discountname2[]" onkeypress="return alphaOnly(event);" value="<?php echo (!empty($sv['s_name'])) ? $sv['s_name'] : '';?>" type="text" class="form-control disn2">
                                          </div>
                                      </div>
                                      <div class="col-md-5">
                                          <div class="form-group">
                                              <input name="discountprice2[]" onkeypress="return isNumberKey(event);" value="<?php echo (!empty($sv['s_price'])) ? indian_currency_form($sv['s_price']) : '';?>"  type="text" class="form-control disp2 ">
                                          </div>
                                      </div>
                                <div class="col-md-1 pad-L5 plusMinus">
                                    <?php if($j!=0){ ?>
                                    <a href="javascript:void(0);" class="pluss added minus"></a>
                                  <?php  }else{?>
                                     <a href="javascript:void(0);" class="pluss added" onclick="plusabc(this,'inputAppend2')"></a>
                                   <?php } ?>

                                </div>
                            </div>
                        </div>
                        <?  $j++;}

                          }?>
                    </div>
                  </div>
                   <div class="row">
                       <div class="col-md-6">
                       Total Discount
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <input type="text" value="<?php echo (!empty($orderinfo['total_showroom_discount'])) ? $orderinfo['total_showroom_discount'] : '';?>" onkeyup="addCommas(this.value, 'total_dis');" name="total_dis" id="total_dis" class="form-control crm-form rupee-icon" readonly="readonly">
                        </div>
                     </div>
                   </div>
               </div>
               <div class="modal-footer">
                  
                  <button type="button" onclick="saveShowAmt1(1);" class="btn btn-primary">SAVE</button>
               </div>
            </div>
            <!-- /.modal-comment -->
         </div>
      </div>
</div>
<?php // echo "<pre>";print_r($orderinfo);die; ?>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="my ModalLabel" aria-hidden="true" id="discountbreakup">
  <div class="modal-backdrop fade in" style="height: 100%;"></div>
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header bg-gray">
                  <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg"><span class="sr-only">Close</span></button>
                  <h4 class="modal-title">Discount Price Breakup</h4>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-6">
                        Showroom Discount
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" onblur="saveShowAmt()" maxlength="10" autocomplete="off" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'dshowroom_discount');" value="<?php echo (!empty($orderinfo['dshowroom_dis'])) ? $orderinfo['dshowroom_dis'] : '';?>" name="dshowroom_discount" id="dshowroom_discount" class="form-control crm-form rupee-icon">
                        </div>
                     </div>

                     <div class="col-md-6">
                         Scheme Discount
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <input type="text"  onblur="saveShowAmt()" maxlength="10" autocomplete="off" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'dscheme');" value="<?php echo (!empty($orderinfo['dscheme_dis'])) ? $orderinfo['dscheme_dis'] : '';?>" name="dscheme" id="dscheme" class="form-control crm-form rupee-icon">
                        </div>
                     </div>

                     <!-- extra added start by Masawwar Ali-->
                      <div class="col-md-6">
                      Exchange Discount
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <input type="text" maxlength="10" onblur="saveShowAmt()" autocomplete="off" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'dis_ex_disc');" value="<?php echo (!empty($orderinfo['dis_ex_disc'])) ? $orderinfo['dis_ex_disc'] : '';?>" name="dis_ex_disc" id="dis_ex_disc" class="form-control crm-form rupee-icon">
                        </div>
                     </div>

                      <div class="col-md-6">
                        Loyalty
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <input type="text" maxlength="10" onblur="saveShowAmt()" autocomplete="off" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'dis_loyalty');" value="<?php echo (!empty($orderinfo['dis_loyalty'])) ? $orderinfo['dis_loyalty'] : '';?>" name="dis_loyalty" id="dis_loyalty" class="form-control crm-form rupee-icon">
                        </div>
                     </div>

                     <div class="col-md-6">
                        Corporate
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <input type="text" maxlength="10" onblur="saveShowAmt()" autocomplete="off" onkeypress="return isNumberKey(event);" onkeyup="addCommas(this.value, 'dis_corporate');" value="<?php echo (!empty($orderinfo['dis_corporate'])) ? $orderinfo['dis_corporate'] : '';?>" name="dis_corporate" id="dis_corporate" class="form-control crm-form rupee-icon">
                        </div>
                     </div>

                    
                      <!-- extra added end   by Masawwar Ali-->

</div>
                    
                  <div class="row">
                     <div class="col-md-12 mrg-B10"><h4>Additional Discounts</h4></div>
                        <div class=" inputAppend3">
                         <?php  if(empty($discountShared)) {?>
                              <div class="col-md-12 appendItem">
                                  <div class="">
                                      <div class="col-md-5">
                                          <div class="form-group">
                                              <input name="discountname[]" onkeypress="return alphaOnly(event);" type="text" class="form-control disn">
                                          </div>
                                      </div>
                                      <div class="col-md-5">
                                          <div class="form-group">
                                              <input name="discountprice[]"  onblur="saveShowAmt()" onkeypress="return isNumberKey(event);" type="text" class="form-control disp rupee-icon">
                                          </div>
                                      </div>
                                      <div class="col-md-1 pad-L5 plusMinus">
                                          <a href="javascript:void(0);" class="pluss added" onclick="plusabc(this,'inputAppend3')"></a>
                                      </div>
                                  </div>

                              </div>
                              <? } else{
                                $k=0;
                          foreach ($discountShared as $dk => $dv) {?>
                          <div class="col-md-12 appendItem">
                                  <div class="">
                                      <div class="col-md-5">
                                          <div class="form-group">
                                              <input name="discountname[]" onkeypress="return alphaOnly(event);" value="<?php echo (!empty($dv['dis_name'])) ? $dv['dis_name'] : '';?>" type="text" class="form-control disn">
                                          </div>
                                      </div>
                                      <div class="col-md-5">
                                          <div class="form-group">
                                              <input name="discountprice[]" onkeypress="return isNumberKey(event);" value="<?php echo (!empty($dv['dis_price'])) ? indian_currency_form($dv['dis_price']) : '';?>" type="text" class="form-control disp">
                                          </div>
                                      </div>
                                      <div class="col-md-1 pad-L5 plusMinus">
                            <?php if($k!=0){ ?>
                                    <a href="javascript:void(0);" class="pluss added minus"></a>
                            <?php  }else{?>
                                     <a href="javascript:void(0);" class="pluss added" onclick="plusabc(this,'inputAppend3')"></a>
                            <?php } ?>

                                      </div>
                                  </div>

                              </div>
                          <?  $k++;} } ?>
                          </div>
                      
                  </div>
                   <div class="row">
                       <div class="col-md-6">
                       Total Discount
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <input type="text" value="<?php echo (!empty($orderinfo['total_dis_amount'])) ? $orderinfo['total_dis_amount'] : '';?>" onkeyup="addCommas(this.value, 'dtotal_dis');" name="dtotal_dis" id="dtotal_dis" class="form-control crm-form rupee-icon" readonly="readonly">
                        </div>
                     </div>
                   </div>
               </div>
               <div class="modal-footer">
                  
                  <button type="button" onclick="saveShowAmt(1);" class="btn btn-primary">SAVE</button>
               </div>
            </div>
            <!-- /.modal-comment -->
         </div>
      </div>
      

<style type="text/css">
    .plusMinus {
        line-height: 0;
        display: inline-block;
    }

    .pluss,
    .minuss {
        font-size: 30px;
    }

    .pluss:before {
        content: "+";
        display: inline-block;
        font-size: 30px;
        line-height: 0;
        margin-top: 19px;
    }

    .minus:before {
        content: "-";
        display: inline-block;
        font-size: 50px;
        line-height: 0;
        margin-top: 19px;
        margin-left: 2px;
    }

    .modal-body {
        height: 430px;
        overflow: auto;
    }

</style>
<?php $currentdate=date('Y/m/d');?>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>    
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script>

  $('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
  $('.testselect2').SumoSelect({triggerChangeCombined:true});
  $('.optgroup_test').SumoSelect({triggerChangeCombined:true});
  $('.search_test').SumoSelect({search: true, searchText: 'Search here.',triggerChangeCombined:true });
  $('.testselect3').SumoSelect({placeholder: 'This is a placeholder',triggerChangeCombined:true});
   $('#model').on('change', function () {
      var selected = $(this).val();
      var make     = $("option:selected", this).attr("rel");
      //alert(make);
      $('#make').val(make);
      $.ajax({
          type: 'POST',
          url: "<?php echo base_url(); ?>" +"finance/getVersion",
          data: {model: selected,make:make,flag:'1'},
          dataType: "html",
          success: function (responseData)
          {
              $('#versionId').html(responseData);
              $('#versionId')[0].sumo.reload();
          }
      });
    });
   $('#deliverySource').on('change', function () {
      if($('#deliverySource').val()=='1'){
        $('#divdealerName').show();
    }else{
        $('#divdealerName').hide();
        $('#deliveryTeam').val('');
        $('#deliveryTeam')[0].sumo.reload();
    }
  });

   $('#gross_do_amt').click(function(){
      var version = $('#versionId').val();
      var exshow = "<?=!empty($orderinfo['ex_show'])?$orderinfo['ex_show']:''?>";
      $('#pricebreakup').addClass(' in');
      $('#pricebreakup').attr('style','display:block;');
      $.ajax({
              type: 'POST',
              url : "<?php echo base_url(); ?>" + "DeliveryOrder/getexshowprice/",
              data:{version:version},
              dataType: "json",
              success: function(response) 
              {
                  //alert(response);
                if(exshow==''){
                 $('#ex_show').val(response);
                }
                 $('#ex_show').trigger('onkeyup');
              }
            }); 
   });

   $('#showroom_disc').click(function(){
     $('#showroombreakup').addClass(' in');
    $('#showroombreakup').attr('style','display:block;');
    
   });

   $('#scheme_disc').click(function(){
     $('#discountbreakup').addClass(' in');
    $('#discountbreakup').attr('style','display:block;');
    
   });
function salesExecutive(ths)
{
  var saleid = $(ths).val();
  if(saleid>='1'){
    $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "DeliveryOrder/getSalesList/",
            data:{saleid:saleid},
            dataType: "json",
            success: function(response) 
            {
              console.log(response);


              if(response>=1){
                $('#deliveryTeam').val(response);}
                else
                {
                  $('#deliveryTeam').val('');
                }
                $('#deliveryTeam')[0].sumo.reload();
            }
            });
  }
  else{
     $('#deliveryTeam').val('');
     $('#deliveryTeam')[0].sumo.reload();
  }
}


 $(document).ready(function() {
 DoLoanChange(1);
 $('#do_date').datepicker({
                format: 'dd-mm-yyyy',
                startDate: '-365d',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             }); 
             var dates =  $('#do_date').val();       
 $('#exp_payment_date').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: dates,
               // endDate:'+60d',
                autoclose: true,
                todayHighlight: true   
             });
 $('#delivery_date').datepicker({
                format: 'dd-mm-yyyy',
               // startDate: dates,
                //endDate:'+60d',
                autoclose: true,
                todayHighlight: true   
             });

     var checkedLoanfilled= document.querySelector('input[name="loan_filled"]:checked').value;
    if(checkedLoanfilled=='1'){
          $('#loan_amt').attr('readonly','readonly');
          $('#hp_tos').attr('disabled','disabled');
          $('#dedu_loan').attr('readonly','readonly');
         }else if(checkedLoanfilled=='2'){
              $('#loan_amt').removeAttr('readonly');
              $('#hp_tos').prop('disabled', false);
              $('.sumo_hp_tos').removeClass(' disabled');
              $('#dedu_loan').removeAttr('readonly');
          }

    });
function changeDate()
{
  $('#exp_payment_date').val('');
  $('#delivery_date').val('');
}


function convertNumberToWords(amounts) {
 // alert(amounts);
    var amount = amounts.replace(/,/g,''); 
  //  alert(amount);
    var words = new Array();
    words[0] = '';
    words[1] = 'One';
    words[2] = 'Two';
    words[3] = 'Three';
    words[4] = 'Four';
    words[5] = 'Five';
    words[6] = 'Six';
    words[7] = 'Seven';
    words[8] = 'Eight';
    words[9] = 'Nine';
    words[10] = 'Ten';
    words[11] = 'Eleven';
    words[12] = 'Twelve';
    words[13] = 'Thirteen';
    words[14] = 'Fourteen';
    words[15] = 'Fifteen';
    words[16] = 'Sixteen';
    words[17] = 'Seventeen';
    words[18] = 'Eighteen';
    words[19] = 'Nineteen';
    words[20] = 'Twenty';
    words[30] = 'Thirty';
    words[40] = 'Forty';
    words[50] = 'Fifty';
    words[60] = 'Sixty';
    words[70] = 'Seventy';
    words[80] = 'Eighty';
    words[90] = 'Ninety';
    amount = amount.toString();
    var atemp = amount.split(".");
    var number = atemp[0].split(",").join("");
    var n_length = number.length;
    var words_string = "";
    if (n_length <= 9) {
        var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        var received_n_array = new Array();
        for (var i = 0; i < n_length; i++) {
            received_n_array[i] = number.substr(i, 1);
        }
        for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
            n_array[i] = received_n_array[j];
        }
        for (var i = 0, j = 1; i < 9; i++, j++) {
            if (i == 0 || i == 2 || i == 4 || i == 7) {
                if (n_array[i] == 1) {
                    n_array[j] = 10 + parseInt(n_array[j]);
                    n_array[i] = 0;
                }
            }
        }
        value = "";
        for (var i = 0; i < 9; i++) {
            if (i == 0 || i == 2 || i == 4 || i == 7) {
                value = n_array[i] * 10;
            } else {
                value = n_array[i];
            }
            if (value != 0) {
                words_string += words[value] + " ";
            }
            if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Crores ";
            }
            if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Lakhs ";
            }
            if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Thousand ";
            }
            if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                words_string += "Hundred and ";
            } else if (i == 6 && value != 0) {
                words_string += "Hundred ";
            }
        }
        words_string = words_string.split("  ").join(" ");
    }
    $('#do_amt_word').val(words_string) ;
    return true;
}
/*$('#make').on('change', function () {
    var selected = $(this).val();
    $.ajax({
        type: 'POST',
        url: "<?php echo base_url(); ?>" +"finance/getModel",
        data: {make: selected},
        dataType: "html",
        success: function (responseData)
        {
            $('#model').html(responseData);
            $('#versionId').html('<option value="">Select Version</option>');
        }
    });
    });*/
    
    /*$('#model').on('change', function () {
      var selected = $(this).val();
      var make     = $("option:selected", this).attr("rel");
      //alert(make);
      $('#make').val(make);
      $.ajax({
          type: 'POST',
          url: "<?php echo base_url(); ?>" +"finance/getVersion",
          data: {model: selected,make:make,flag:'1'},
          dataType: "html",
          success: function (responseData)
          {
              $('#versionId').html(responseData);
          }
      });
    }); */

    function saveGrossAmt(flag = "")
    {
      var tcs = 0; var ex_show = 0;var epc = 0;var road_tax = 0; var insu_premium_do = 0; var external_warranty = 0;       
        ex_show = $('#ex_show').val().replace(/,/g,'');
        if($('#tcs').val() != "")
           tcs = $('#tcs').val().replace(/,/g,'');
       if($('#epc').val() != "")
           epc = $('#epc').val().replace(/,/g,'');
       if($('#road_tax').val() != "")
           road_tax = $('#road_tax').val().replace(/,/g,'');
         if($('#insu_premium_do').val() != "")
           insu_premium_do = $('#insu_premium_do').val().replace(/,/g,'');
         if($('#external_warranty').val() != "")
           external_warranty = $('#external_warranty').val().replace(/,/g,'');
        var sum = 0;
        var price = [];
        var name = [];
        var inps = document.getElementsByName('discountprice1[]');
          for (var i = 0; i <inps.length; i++) {
          var inp=inps[i];    
          var str = 0;
          if(inp.value){
           str =  inp.value;
              str =  str.replace(',','');
              if(str != "")
                 price.push(str);
              sum = parseInt(sum) + parseInt(str);
          }
          }
          var inns = document.getElementsByName('discountname1[]');
          for (var i = 0; i <inns.length; i++) {
          var inn=inns[i];
            name.push(inn.value);
          }
        var gross = parseInt(ex_show)+parseInt(tcs)+parseInt(epc)+parseInt(road_tax)+parseInt(insu_premium_do)+parseInt(external_warranty)+parseInt(sum);
        $('#grs_amt').val(gross);        
        $('#grs_amt').trigger('onkeyup');
        if(flag == 1){
 setTimeout(function(){
        var grs_amts = $('#grs_amt').val();
        var ex_shows = $('#ex_show').val();
        var tcss = $('#tcs').val();
        var epcs = $('#epc').val();
        var road_taxs = $('#road_tax').val();

        var insu_premium_dos   = $('#insu_premium_do').val();
        var external_warrantys = $('#external_warranty').val();

        var disn1s = name;
        var disp1s = price;

        $('#disp_in').val(disp1s);
        $('#disn_in').val(disn1s);
        $('#grs_amt_in').val(grs_amts);
        $('#ex_show_in').val(ex_shows);
        $('#tcs_in').val(tcss);
        $('#epc_in').val(epcs);
        $('#road_tax_in').val(road_taxs);

        $('#insu_premium_do_in').val(insu_premium_dos);
        $('#external_warranty_in').val(external_warrantys);

        $('#gross_do_amt').val(grs_amts);
        $('#net_do_amt').val(grs_amts);
        $('#net_do_amt').trigger('onkeyup');
        calculateNetAmount();
        setTimeout(function(){ $('.close').trigger('click'); }, 500);
        }, 500);
    }  
    }

    function saveShowAmt(flag = '')
    {
        var dshowroom_discount = $('#dshowroom_discount').val().replace(/,/g,'');
        var dscheme = $('#dscheme').val().replace(/,/g,'');
        var dis_ex_disc = $('#dis_ex_disc').val().replace(/,/g,'');
        var dis_loyalty = $('#dis_loyalty').val().replace(/,/g,'');
        var dis_corporate = $('#dis_corporate').val().replace(/,/g,'');
        
        
        var sum = 0;
        var price = [];
        var name = [];
        var inps = document.getElementsByName('discountprice[]');
          for (var i = 0; i <inps.length; i++) {
          var inp=inps[i];
           var str =  inp.value;
           if(str !=""){
              str =  str.replace(',','');
              price.push(str);
              sum = parseInt(sum) + parseInt(str);
           }
          }
          var inns = document.getElementsByName('discountname[]');
          for (var i = 0; i <inns.length; i++) {
          var inn=inns[i];
            name.push(inn.value);
          }
          if(dshowroom_discount == "")
              dshowroom_discount = 0;
          if(dscheme == "")
              dscheme = 0;

            if(dis_ex_disc == "")
              dis_ex_disc = 0;
            if(dis_loyalty == "")
              dis_loyalty = 0;
            if(dis_corporate == "")
              dis_corporate = 0;
            

            
            
        var gross = parseInt(dshowroom_discount)+parseInt(dscheme)+parseInt(dis_ex_disc)+parseInt(dis_loyalty)+parseInt(dis_corporate)+parseInt(sum);
        $('#dtotal_dis').val(gross);
        $('#dtotal_dis').trigger('onkeyup');
        if(flag == 1){
            setTimeout(function(){
            var dtotal_diss = $('#dtotal_dis').val();
            var dshowroom_discounts = $('#dshowroom_discount').val();
            var dschemes = $('#dscheme').val();
             var dis_ex_discs = $('#dis_ex_disc').val();
             var dis_loyaltys = $('#dis_loyalty').val();
             var dis_corporates = $('#dis_corporate').val();
             

            $('#disp_dis').val(price);
            $('#disn_dis').val(name);
            $('#showroom_dis').val(dshowroom_discounts);
            $('#schemes_dis').val(dschemes);
            $('#ex_disc_dis').val(dis_ex_discs);
            $('#loyalty_dis').val(dis_loyaltys);
            $('#corporate_dis').val(dis_corporates);
              
             
            
            $('#scheme_disc').val(dtotal_diss);
            $('#distotal_dis').val(dtotal_diss);
             setTimeout(function(){ $('.close').trigger('click'); }, 500);
              }, 500);
        }
    }

     function saveShowAmt1(flag = "")
    {

        var showroom_discount = $('#showroom_discount').val().replace(/,/g,'');
        var schemes           = $('#schemes').val().replace(/,/g,'');
        var show_ex_disc      = $('#show_ex_disc').val().replace(/,/g,'');
        var show_loyalty      = $('#show_loyalty').val().replace(/,/g,'');
        var show_corporate      = $('#show_corporate').val().replace(/,/g,'');
        
        
        
        var sum = 0;
        var price = [];
        var name = [];
        var inps = document.getElementsByName('discountprice2[]');
          for (var i = 0; i <inps.length; i++) {
              var inp=inps[i];
              var str =  inp.value;
              if(str != ""){
                    str =  str.replace(',','');
                    price.push(str);
                    sum = parseInt(sum) + parseInt(str);
              }
          }
          var inns = document.getElementsByName('discountname2[]');
          for (var i = 0; i <inns.length; i++) {
          var inn=inns[i];
            name.push(inn.value);
          }
          if(showroom_discount =="")
              showroom_discount = 0;
          if(schemes == "")
              schemes = 0;
            if(show_ex_disc == "")
              show_ex_disc = 0;
            if(show_loyalty == "")
              show_loyalty = 0;
            if(show_corporate == "")
              show_corporate = 0;

            
            
            
        var gross = parseInt(showroom_discount)+parseInt(schemes)+parseInt(show_ex_disc)+parseInt(show_loyalty)+parseInt(show_corporate)+parseInt(sum);
        $('#total_dis').val(gross);
        $('#total_dis').trigger('onkeyup');
          if(flag == 1){
        setTimeout(function(){ 

      var total_diss = $('#total_dis').val();
      var showroom_discounts = $('#showroom_discount').val();
      var schemess = $('#schemes').val();
      var show_ex_discs = $('#show_ex_disc').val();
       var show_loyaltys = $('#show_loyalty').val();
        var show_corporates = $('#show_corporate').val();
      
      $('#disp_show').val(price);
      $('#disn_show').val(name);
      $('#showroom_show').val(showroom_discounts);
      $('#schemes_show').val(schemess);
      $('#ex_disc_show').val(show_ex_discs);
      $('#loyalty_show').val(show_loyaltys);
      $('#corporate_show').val(show_corporates);
      
      

      $('#distotal_show').val(total_diss);
      $('#showroom_disc').val(total_diss);
            setTimeout(function(){ $('.close').trigger('click'); }, 500);
            }, 500);
        }

  }
    

    $('.close').click(function(){
      $('#pricebreakup').removeClass(' in');
      $('#pricebreakup').attr('style','display:none;');
       $('#showroombreakup').removeClass(' in');
      $('#showroombreakup').attr('style','display:none;');
       $('#discountbreakup').removeClass(' in');
      $('#discountbreakup').attr('style','display:none;');
    });
</script>
<script type="text/javascript">
    function plusabc(e,clas) {

      //alert(clas);
        if(clas=='inputAppend1')
        {
          var cl = 'disn1';
          var pl = 'disp1';
          var namen = 'discountname1[]';
          var namep = 'discountprice1[]';
          var funname = 'onblur="saveGrossAmt()"';
          var onkptext    = 'onkeypress="return alphaOnly(event)"';
          var onkpprice    = 'onkeypress="return isNumberKey(event)"';

        }
        if(clas=='inputAppend2')
        {
          var cl = 'disn2';
          var pl = 'disp2';
          var namen = 'discountname2[]';
          var namep = 'discountprice2[]';
          var funname = 'onblur="saveShowAmt1()"';
          var onkptext    = 'onkeypress="return alphaOnly(event)"';
          var onkpprice    = 'onkeypress="return isNumberKey(event)"';
        }
        if(clas=='inputAppend3')
        {
          var cl = 'disn';
          var pl = 'disp';
          var namen = 'discountname[]';
          var namep = 'discountprice[]';
          var funname = ' onblur="saveShowAmt()"';
          var onkptext    = 'onkeypress="return alphaOnly(event)"';
          var onkpprice    = 'onkeypress="return isNumberKey(event)"';
        }
        /*var oncl = "plusabc(this, '"+clas+"')";
        $('.' + clas).append('<div class="col-md-12 appendItem"><div class=""><div class="col-md-5"><div class="form-group"><input name="'+namen+'" '+onkptext+' value="" type="text" class="form-control '+cl+' "></div></div><div class="col-md-5"><div class="form-group"><input '+ funname +' name="'+namep+'" value="" type="text" '+onkpprice+' class="form-control '+pl+' rupee-icon"></div></div><div class="col-md-1 pad-L5 class="plusMinus"><a href="javascript:void(0);" class="pluss added" onclick="' + oncl + '"></a></div></div></div>');*/

        var oncl = "plusabc(this, '"+clas+"')";
        $('.' + clas).append('<div class="col-md-12 appendItem"><div class=""><div class="col-md-5"><div class="form-group"><input name="'+namen+'" '+onkptext+' value="" type="text" class="form-control '+cl+' "></div></div><div class="col-md-5"><div class="form-group"><input '+ funname +' name="'+namep+'" value="" type="text" '+onkpprice+' class="form-control '+pl+' rupee-icon"></div></div><div class="col-md-1 pad-L5 class="plusMinus"><a href="javascript:void(0);" class="pluss added minus"></a></div></div></div>');
        setTimeout(function(){ 
        }, 10);
    }
    $(document).ready(function(){
        $('body').on('click', '.minus', function() {
            $(this).parents('.appendItem').remove();
        });
          var insu = $('#insurance').val();

            if(insu=='1'){
                $('#insu_premium_div_on_do').attr('style','display:block');
              }else{
                //alert('dsfsf')
                $('#insu_premium_div_on_do').attr('style','display:none');
              }

          if(insu=='2')
          {
            $('#insu_premium_div').attr('style','display:block');
          }
          else
          {
             $('#insu_premium_div').attr('style','display:none');
          }
    });


$("#sameas").click(function(){
  var net_do_amt = $('#net_do_amt').val().replace(/,/g,'');
  var showroom_disc = $('#showroom_disc').val().replace(/,/g,'');
    if(net_do_amt == "")
  net_do_amt = 0;
  if(showroom_disc == "")
      showroom_disc = 0;
if ($("#sameas").is(":checked")) {
     $('#sameas').val('1');
     var su = parseInt(net_do_amt)-parseInt(showroom_disc);
     $('#net_do_amt').val(su);

}
else
{
     $('#sameas').val('0');
     var su = parseInt(net_do_amt)+parseInt(showroom_disc);
     $('#net_do_amt').val(su);
}
 $('#net_do_amt').trigger('onkeyup');
});

$("#sameasloan").click(function(){
    calculateNetAmount();
//  var net_do_amt = $('#net_do_amt').val().replace(/,/g,'');
//  var loan_amt = $('#loan_amt').val().replace(/,/g,'');
//  var dedu_loan = $("#dedu_loan").val().replace(/,/g,'');
//  var laon = parseInt(loan_amt)- parseInt(dedu_loan);
//if ($("#sameasloan").is(":checked")) {
//     $('#sameasloan').val('1');
//     if(loan_amt>=1){       
//     var su = parseInt(net_do_amt)-parseInt(laon);
//     $('#net_do_amt').val(su);
//    }
//}
//else
//{
//     $('#sameasloan').val('0');
//      if(loan_amt>=1){
//     var su = parseInt(net_do_amt)+parseInt(laon);
//     $('#net_do_amt').val(su);
//   }
//}
// $('#net_do_amt').trigger('onkeyup');
});

$("#margin_money").blur(function(){
calculateNetAmount();
});

$("#margin_money_inhouse").blur(function(){
calculateNetAmount();
});
$("#include_margin_money_cus").click(function(){
    calculateNetAmount();
});
$("#include_margin_money_in").click(function(){
    calculateNetAmount();
});
$("#include_dis_shared").click(function(){
    calculateNetAmount();
});
function calculateNetAmount(){    
    //alert("a");
    var gross_do_amt = $("#gross_do_amt").val().replace(/,/g,'');
if(gross_do_amt != ""){
    var showroom_disc = $('#showroom_disc').val().replace(/,/g,'');
    $('#net_do_amt').val(gross_do_amt);
if ($("#sameas").is(":checked")) {
     $('#sameas').val('1');
     var su = parseInt(gross_do_amt)-parseInt(showroom_disc);
     $('#net_do_amt').val(su);
}
if ($("#include_dis_shared").is(":checked")) {
     $('#include_dis_shared').val('1');
     var scheme_disc = $("#scheme_disc").val().replace(/,/g,'');
     var net_do_amt = $('#net_do_amt').val().replace(/,/g,'');
     var net_do_amt_sd = parseInt(net_do_amt)-parseInt(scheme_disc);
     $('#net_do_amt').val(net_do_amt_sd);
}
    var net_do_amt = $('#net_do_amt').val().replace(/,/g,'');
    var loan_amt = $('#loan_amt').val().replace(/,/g,'');
    var dedu_loan = $("#dedu_loan").val().replace(/,/g,'');
    if(dedu_loan == "")
        dedu_loan = 0;
if ($("#sameasloan").is(":checked")) {
     $('#sameasloan').val('1');
     if(loan_amt>=1){
        // alert(loan_amt);alert(dedu_loan);         
         var laon = parseInt(loan_amt)- parseInt(dedu_loan);
         //alert(laon);
         var su = parseInt(net_do_amt)-parseInt(laon);
           //alert(su)
         $('#net_do_amt').val(su);
    }
}
var net_do_amt = $('#net_do_amt').val().replace(/,/g,'');
var margin_money = 0;
var margin_money_inhouse = 0;
var margin_money_customer = 0;
if ($("#include_margin_money_cus").is(":checked") && $("#margin_money").val() != "") {
 margin_money_customer = $("#margin_money").val().replace(/,/g,'');
}
if ($("#include_margin_money_in").is(":checked") && $("#margin_money_inhouse").val() != "") {
 margin_money_inhouse = $("#margin_money_inhouse").val().replace(/,/g,'');
}
var margin_money = parseInt(margin_money_customer) + parseInt(margin_money_inhouse);
    if(margin_money>=1){
         var su = parseInt(net_do_amt)-parseInt(margin_money);
         $('#net_do_amt').val(su);
    }
    else
         $('#net_do_amt').val(net_do_amt);
}
$('#net_do_amt').trigger('onkeyup');
}

$('#insurance').change(function(){
  //alert('hi');
  var insu = $('#insurance').val();

  if(insu=='1'){
    $('#insu_premium_div_on_do').attr('style','display:block');
  }else{
    $('#insu_premium_div_on_do').attr('style','display:none');
  }
  
  if(insu=='2')
  {
    $('#insu_premium_div').attr('style','display:block');
  }
  else
  {
     $('#insu_premium_div').attr('style','display:none');
  }
});




</script>

<script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/loan_validation.js" type="text/javascript"></script>
