<?php //echo "<pre>"; print_r($CustomerInfo); exit;?>
<div class="container-fluid">
               <div class="row">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <h2 class="page-title">Post Delivery Info</h2>
                     <div class="white-section">
                         <form  enctype="multipart/form-data" method="post"  id="deliveryDetails" name="deliveryDetails">
                          <?php if($CustomerInfo['loan_for']=='1'){?>
                        <div class="row">
                       
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0">Invoice Details</h2>
                            </div>
                           
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Invoice No.*</label>
                                 <input type="text" onkeypress="return blockSpecialChar(event)" name="invoice_no" id="invoice_no" value="<?php echo (!empty($postInfo['invoice_no'])) ? $postInfo['invoice_no'] : ''?>" class="form-control crm-form">
                                 <div class="error" id="err_invoice_no"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Invoice Date*</label>
                                 <div class="input-group date" id="dp">
                                  <input type="text" class="form-control crm-form crm-form_1" name="invoice_date" id="invoice_date" value="<?php echo (!empty($postInfo['invoice_date'])) ? date('d-m-Y',strtotime($postInfo['invoice_date'])) : ''?>" placeholder="Invoice Date" >
                                  <span class="input-group-addon">
                                     <span class="">
                                       <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                  </span>
                                 </div>
                                 <div class="error" id="err_invoice_date"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Received As*</label>
                                  <select class="form-control testselect1 crm-form" id="invoice_received_as" name="invoice_received_as">
                                  <option value="1" <?php echo (!empty($postInfo['invoice_received_as']) && ($postInfo['invoice_received_as']=='1')) ? "selected=selected" : ''?>>Original</option>
                                  <option value="2" <?php echo (!empty($postInfo['invoice_received_as']) &&  ($postInfo['invoice_received_as']=='2')) ? "selected=selected" : ''?>>Scan</option>
                                  <option value="3" <?php echo (!empty($postInfo['invoice_received_as']) && ($postInfo['invoice_received_as']=='3')) ? "selected=selected" : ''?>>Photo Copy</option>
                                </select>
                               <!-- <div class="d-arrow"></div>-->
                                <div class="error" id="err_invoice_received_as"></div>
                                 </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Received By*</label>   
                                  <input type="text" class="form-control crm-form" placeholder="Received By" id="invoice_received_from" name="invoice_received_from" value="<?php echo (!empty($postInfo['invoice_received_from'])) ? $postInfo['invoice_received_from'] : ''?>">  
                                 <div class="error" id="err_rc_lein_mark"></div>                          
                                  <!--<select class="form-control crm-form testselect1" id="invoice_received_from" name="invoice_received_from">
                                  <option value="">Select</option>
                                  <?php 
                                 foreach ($employeeList as $key=>$value){ ?>
                                <option value="<?=$value['id']?>" <?php echo !empty($postInfo) && $postInfo['invoice_received_from'] ==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['name']?></option>
                                  <?php  
                                  }  ?>
                                </select>-->
                                   <div class="error" id="err_invoice_received_from"></div>
                              </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Received On*</label>
                                 <div class="input-group date" id="dp">
                                 <input type="text" class="form-control crm-form crm-form_1" placeholder="Received On" name="invoice_received_on" id="invoice_received_on" value="<?php echo (!empty($postInfo['invoice_received_on'])) ? date('d-m-Y',strtotime($postInfo['invoice_received_on'])) : ''?>" >
                                 <span class="input-group-addon">
                                     <span class="">
                                       <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                  </span>
                                 </div>
                              </div>
                              <div class="error" id="err_invoice_received_on"></div>
                           </div>
                        </div>
                        <?php } ?>
                         <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title">RC Details</h2>
                            </div>
                           
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Registration No.<?=!empty($CustomerInfo['loan_for']) && $CustomerInfo['loan_for']=='1'?'':'*'?></label>
                                 <input type="text" class="form-control upperCaseLoan crm-form" onkeypress="return blockSpecialChar(event)" name="rc_regNo" id="rc_regNo" value="<?php echo (!empty($postInfo['rc_regNo'])) ? $postInfo['rc_regNo'] : (!empty($CustomerInfo['regno'])?$CustomerInfo['regno']:'')?>">
                                 <div class="error" id="err_rc_regNo"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Chassis No.*</label>
                                  <input type="text" class="form-control upperCaseLoan crm-form" placeholder="Chasis No." name="rc_chassis_no" maxlength="17" id="rc_chassis_no" value="<?php echo (!empty($postInfo['rc_chassis_no'])) ? $postInfo['rc_chassis_no'] : (!empty($CustomerInfo['chassis_number'])?$CustomerInfo['chassis_number']:'')?>">
                                   <div class="error" id="err_rc_chassis_no"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Engine No.*</label>
                                  <input type="text" class="form-control upperCaseLoan crm-form" placeholder="Engine No." maxlength="17" name="rc_engine_no" id="rc_engine_no" value="<?php echo (!empty($postInfo['rc_engine_no'])) ? $postInfo['rc_engine_no'] : (!empty($CustomerInfo['engine_number'])?$CustomerInfo['engine_number']:'')?>">
                                  <div class="error" id="err_rc_engine_no"></div>
                                 </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Registration Date<?=!empty($CustomerInfo['loan_for']=='1')?'':'*'?></label>
                                 <div class="input-group date" id="dp">
                                  <input type="text" class="form-control crm-form crm-form_1" placeholder="Registration Date" name="rc_regDate" id="rc_regDate" value="<?php echo ((!empty($postInfo['rc_reg_date'])) && ($postInfo['rc_reg_date']!='0000-00-00') )? date('d-m-Y',strtotime($postInfo['rc_reg_date'])) : (!empty($CustomerInfo['reg_year']) && ($CustomerInfo['reg_year']!='0000-00-00')?date('d-m-Y',strtotime($CustomerInfo['reg_year'])):'')?>" >
                                  <span class="input-group-addon">
                                     <span class="">
                                       <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                  </span>
                                 </div>
                                 <div class="error" id="err_rc_regDate"></div>
                              </div>
                           </div>
                            <div class="col-md-6" style="display: none">
                             <div class="form-group">
                                <label class="crm-label">Lien Mark</label>
                                <input type="text" class="form-control crm-form" placeholder="Lien Mark" id="rc_lein_mark" name="rc_lein_mark" value="<?php echo (!empty($postInfo['rc_lein_mark'])) ? $postInfo['rc_lein_mark'] : ''?>">  
                                 <div class="error" id="err_rc_lein_mark"></div>
                             </div>
                            </div>
                             <?php if($CustomerInfo['loan_for']=='1'){?>
                            <div class="col-md-6">
                             <div class="form-group">
                                <label class="crm-label">Received As</label>
                                <select class="form-control crm-form" id="rc_received_as" name="rc_received_as" value="<?php echo (!empty($postInfo['rc_received_as'])) ? $postInfo['rc_received_as'] : ''?>">
                                  <option value="1" <?php echo (!empty($postInfo['rc_received_as']) && ($postInfo['rc_received_as']=='1')) ? "selected=selected" : ''?>>Original</option>
                                  <option value="2" <?php echo (!empty($postInfo['rc_received_as']) && ($postInfo['rc_received_as']=='2')) ? "selected=selected" : ''?>>Scan</option>
                                  <option value="3" <?php echo (!empty($postInfo['rc_received_as']) && ($postInfo['rc_received_as']=='3')) ? "selected=selected" : ''?>>Photo Copy</option>
                                </select>
                                <div class="d-arrow"></div>   
                                 <div class="error" id="err_rc_received_as"></div>
                             </div>
                            </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Received By</label>
                                  <input type="text" class="form-control crm-form" placeholder="Received From" id="rc_registration_from" name="rc_registration_from" value="<?php echo (!empty($postInfo['rc_registration_from'])) ? $postInfo['rc_registration_from'] : ''?>">
                                  <div class="error" id="err_rc_registration_from"></div>
                              </div>
                           </div>                             
                                 
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Received On</label>
                                 <div class="input-group date" id="dp">
                                  <input type="text" class="form-control crm-form crm-form_1" placeholder="Received On" id="rc_received_on" name="rc_received_on" value="<?php echo (!empty($postInfo['rc_received_on'])) ? date('d-m-Y',strtotime($postInfo['rc_received_on'])) : ''?>">
                                  <span class="input-group-addon">
                                     <span class="">
                                       <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                  </span>
                                 </div>
                                 <div class="error" id="err_rc_received_on"></div>
                              </div>
                           </div>

                             <div class="">
                           <div class="col-md-12">
                             <h2 class="sub-title">Service Booklet Details</h2>
                            </div>
                           
                          
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Received By</label>
                                 <!-- <input type="text" class="form-control crm-form" placeholder="Received From" name="invoice_received_from" id="invoice_received_from" value="<?php echo (!empty($postInfo['rc_registration_from'])) ? $postInfo['rc_registration_from'] : ''?>">-->
                               
                                  <select class="form-control crm-form testselect1" id="service_received_from" name="service_received_from">
                                  <option value="">Select</option>
                                  <?php 
                                 foreach ($allemployeeList as $key=>$value){ ?>
                                <option value="<?=$value['id']?>" <?php echo !empty($postInfo) && $postInfo['service_received_from'] ==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['name']?></option>
                                  <?php  
                                  }  ?>
                                </select>
                                   <div class="error" id="err_service_received_from"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Received On</label>
                                 <div class="input-group date" id="dp">
                                  <input type="text" class="form-control crm-form crm-form_1" placeholder="Received On" id="service_received_on" name="service_received_on" value="<?php echo (!empty($postInfo['service_received_on']) && ($postInfo['service_received_on']!='0000-00-00 00:00:00')) ? date('d-m-Y',strtotime($postInfo['service_received_on'])) : ''?>">
                                  <span class="input-group-addon">
                                     <span class="">
                                       <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                  </span>
                                 </div>
                                 <div class="error" id="err_service_received_on"></div>
                              </div>
                           </div>
                           </div>

                            <div class="">
                           <div class="col-md-12">
                             <h2 class="sub-title">Number Plate Details</h2>
                            </div>
                           
                          
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Received By</label>
                                 <!-- <input type="text" class="form-control crm-form" placeholder="Received From" name="invoice_received_from" id="invoice_received_from" value="<?php echo (!empty($postInfo['rc_registration_from'])) ? $postInfo['rc_registration_from'] : ''?>">-->
                               
                                  <select class="form-control crm-form testselect1" id="noplate_received_from" name="noplate_received_from">
                                  <option value="">Select</option>
                                  <?php 
                                 foreach ($allemployeeList as $key=>$value){ ?>
                                <option value="<?=$value['id']?>" <?php echo !empty($postInfo) && $postInfo['noplate_received_from'] ==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['name']?></option>
                                  <?php  
                                  }  ?>
                                </select>
                                   <div class="error" id="err_noplate_received_from"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Received On</label>
                                 <div class="input-group date" id="dp">
                                  <input type="text" class="form-control crm-form crm-form_1" placeholder="Received On" id="noplate_received_ons" name="noplate_received_on" value="<?php echo (!empty($postInfo['noplate_received_on']) && ($postInfo['noplate_received_on']!='0000-00-00 00:00:00')) ? date('d-m-Y',strtotime($postInfo['noplate_received_on'])) : ''?>">
                                  <span class="input-group-addon">
                                     <span class="">
                                       <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                  </span>
                                 </div>
                                 <div class="error" id="err_noplate_received_on"></div>
                              </div>
                           </div>
                           </div>
                           </div>
                            <?php }else{?> </div><?} ?>  
                          
                         <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title">Insurance Details</h2>
                            </div>
                           
                           <div class="col-md-6">
                              <div class="form-group">
                                  <label for="" class="crm-label">Insurance Company*</label>
                                 <select class="form-control testselect1 crm-form" id="insurance_company" name="insurance_company">
                                  <option value="">Select</option>
                                  <?php foreach($insurerList as $insurer){?>
                                  <option value="<?php echo $insurer->insurer_id;?>"<?php echo (!empty($postInfo['insurance_company']) && ($postInfo['insurance_company']==$insurer->insurer_id)) ? "selected=selected" : ''?>><?php echo $insurer->insurer_name;?></option>
                                  <?php } ?>
                                </select>
                               
                                 <div class="error" id="err_insurance_company"></div>
                              </div>
                           </div>
                           <div class="col-md-6" style="display: none;">
                              <div class="form-group">
                                 <label for="" class="crm-label">Insurance by*</label>
                                  <input type="text" class="form-control crm-form" placeholder="Insurance by" id="insurance_by" name="insurance_by" value="<?php echo (!empty($postInfo['insurance_by'])) ? $postInfo['insurance_by'] : ''?>">
                                   <div class="error" id="err_insurance_by"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">ICN No.*</label>
                                  <input type="text" class="form-control crm-form" placeholder="ICN No." onkeypress="return blockSpecialChar(event)" id="icn_no" name="icn_no" value="<?php echo (!empty($postInfo['icn_no'])) ? $postInfo['icn_no'] : ''?>">
                                   <div class="error" id="err_icn_no"></div>
                                 </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Insurance Expiry*</label>
                                 <div class="input-group date" id="dp">
                                  <input type="text" class="form-control crm-form crm-form_1" placeholder="Insurance Expiry" id="insurance_expiry" name="insurance_expiry" value="<?php echo (!empty($postInfo['insurance_expiry'])) ? date('d-m-Y',strtotime($postInfo['insurance_expiry'])) : ''?>" >
                                  <span class="input-group-addon">
                                     <span class="">
                                       <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                  </span>
                                 </div>
                                  <div class="error" id="err_insurance_expiry"></div>
                              </div>
                           </div>
                           <?php if($CustomerInfo['loan_for']=='1'){?>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Third Party Expiry Date</label>
                                 <div class="input-group date" id="dp">
                                  <input type="text" class="form-control crm-form crm-form_1" placeholder="Third Party Expiry Date" name="rc_thirdex" id="rc_thirdex" value="<?php echo ((!empty($postInfo['rc_thirdex'])) && ($postInfo['rc_thirdex']!='0000-00-00') )? date('d-m-Y',strtotime($postInfo['rc_thirdex'])) :''?>" >
                                  <span class="input-group-addon">
                                     <span class="">
                                       <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                  </span>
                                 </div>
                                 <div class="error" id="err_rc_regDate"></div>
                              </div>
                           </div>
                           <? } ?>
                           </div>
                           <div class="row">
                           <?php if(($CustomerInfo['loan_for']=='1') || (($CustomerInfo['loan_for']=='2') && ($CustomerInfo['loan_type']=='Purchase'))){?>
                            <div class="col-md-12">
                             <h2 class="sub-title">Delivery Details</h2>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Delivery Date</label>
                                 <div class="input-group date" id="dp">
                                  <input type="text" class="form-control crm-form crm-form_1" placeholder="Delivery Date" id="delivery_date" name="delivery_date" value="<?php echo (!empty($postInfo['delivery_date'])) ? date('d-m-Y',strtotime($postInfo['delivery_date'])) : ''?>"  >
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
                                 <label for="" class="crm-label">File By</label>
                                  <input type="text" class="form-control crm-form" placeholder="File By" onkeypress="return blockSpecialChar(event)" id="file_by" name="file_by" value="<?php echo (!empty($postInfo['file_by'])) ? $postInfo['file_by'] : ''?>">
                                   <div class="error" id="err_file_by"></div>
                              </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">File No</label>
                                  <input type="text" class="form-control crm-form" placeholder="Filing No" onkeypress="return blockSpecialChar(event)" id="filling_no" name="filling_no" value="<?php echo (!empty($postInfo['filling_no'])) ? $postInfo['filling_no'] : ''?>">
                                   <div class="error" id="err_filling_no"></div>
                              </div>
                           </div>
                           <? } if($CustomerInfo['loan_for']=='1'){ ?>
                              <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="crm-label">Showroom Name </label>
                                        <select class="form-control crm-form testselect1 search-box sroom search_test"  onchange="return getDealerDetails();" id="showroomName" name="showroomName">
                                        <option value="">Showroom Name</option>
                                            <?php foreach ($showroomList as $key=>$value){ ?>
                                            <option value="<?=$value['id']?>"  <?php echo !empty($postInfo) && $postInfo['showroomName']==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['organization']?></option>
                                        <?php } ?>
                                        </select>
                                       
                                          <div class="error" id="err_showroomName"></div>
                                    </div>
                                </div>
                           <div class="col-md-6" style="height:85px;">
                              <div class="form-group">
                                 <label for="" class="crm-label">Address </label>
                                  <input type="text" class="form-control crm-form form-read" placeholder="Address" name="showroom_address" readonly="readonly" id="showroom_address" value="<?php echo (!empty($postInfo['showroomAddress'])) ? ucwords($postInfo['showroomAddress']) :'';?>">
                                   <div class="error" id="err_showroom_address"></div>
                              </div>
                           </div>
                         <? } ?>
                             <input type="hidden" name="deliveryForm" value="1" id="deliveryForm">
                             <input type="hidden" value="<?= !empty($CustomerInfo['customer_id'])?$CustomerInfo['customer_id']:'' ?>" name="customerId">
                             <input type="hidden" name="case_id" value="<?=(!empty($CustomerInfo['customer_loan_id']))?$CustomerInfo['customer_loan_id']:''?>" id="case_id"> 
                             <input type="hidden" name="loan_for" value="<?=(!empty($CustomerInfo['loan_for']))?$CustomerInfo['loan_for']:''?>" id="loan_for"> 
                          <div class="col-md-12">
                               <div class="btn-sec-width">
                                 <?php 
                                      $stylesss = 'display:block';
                                      $stylec = 'display:none';
                                      $action = '';
                                    if(((!empty($CustomerInfo['instrument_type'])) && ($rolemgmt[0]['edit_permission']=='0') && (!empty($CustomerInfo['cust_bnk_id']))) || ($rolemgmt[0]['add_permission']=='0'))
                                      {
                                          $stylesss  = 'display:none';
                                          $stylec = 'display:block';
                                          if($CustomerInfo['loan_for']=='1')
                                          {
                                            $action = base_url('uploadDocs/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"].'/post');
                                          }
                                          else{
                                            $action = base_url('loanListing/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);
                                        }

                                      } 
                                       if($CustomerInfo['cancel_id']=='0'){ ?>
                                  <button type="button" class="btn-continue saveCont" style="<?=$stylesss?>"  id="postDetailsButton">SAVE AND CONTINUE</button>
                                  <button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                                  <?php } ?>
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
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
   
<script>
  $('.testselect1').SumoSelect({csvDispCount: 3, search: true, searchText:'Enter here.',triggerChangeCombined: true});

    $(document).ready(function() {

       $('#insurance_expiry,#rc_thirdex').datepicker({
                format: 'dd-mm-yyyy',
                startDate: 'd',
               // endDate:'+7d',
                autoclose: true,
                todayHighlight: true   
             });
         $('#invoice_date,#invoice_received_on,#rc_regDate,#rc_received_on,#delivery_date,#service_received_on,#noplate_received_ons').datepicker({
                format: 'dd-mm-yyyy',
                // /startDate: 'd',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
    });
     </script>
<script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>