<!---form1 section start-->
<div id="form1">
<div class="container-fluid">
               <div class="row">
                   <form name="frm1" id="frm2" method="post" action="">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <div class="white-section">
                        <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0">Personal Details</h2>
                            </div>
                             <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Address</label>
                                 <input type="text" name="customer_address"  id="customer_address" class="form-control crm-form" value="" placeholder="Address">
                                 <div class="error" id="customer_address_error" ></div>
                                 </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Pincode</label>
                                 <input type="text" name="customer_pincode"  id="customer_pincode" class="form-control crm-form" value="" placeholder="Pincode" maxlength="10">
                                 <div class="error" id="customer_pincode_error" ></div>
                                 </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">City</label>
                                 <select class="form-control crm-form" name="customer_city" id="customer_city">
                                    <option selected="selected" value="">Select City</option>
                                    <?php if(!empty($citylist)){?>
                                    <?php foreach($citylist as $city){?>
                                    <option value="<?php echo $city['city_id'];?>"><?php echo $city['city_name'];?></option>
                                    <?php }} ?>
                                 </select>
                                 <div class="d-arrow"></div>
                                 <div class="error" id="customer_city_error" ></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Email</label>
                                 <input type="text" name="customer_email" id="customer_email" class="form-control crm-form" placeholder="Email">
                                 <div class="error" id="customer_email_error" ></div>
                              </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Aadhar No.</label>
                                 <input type="text" name="customer_aadhar" id="customer_aadhar" class="form-control crm-form" placeholder="Aadhar No" maxlength="12">
                                 <div class="error" id="customer_aadhar_error" ></div>
                              </div>
                           </div> 
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Pan No.</label>
                                 <input type="text" name="customer_pan" id="customer_pan" class="form-control crm-form" placeholder="Pancard No." maxlength="12">
                                 <div class="error" id="customer_pan_error" ></div>
                              </div>
                           </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                 <input type="checkbox" name="isaddress" id="isaddress" class="form-control crm-form">
                                 <label for="" class="crm-label">Is the customer address same as above.</label>
                              </div>
                           </div>
                            <div class="col-md-12">
                             <h2 class="sub-title mrg-T0">Nominee Information</h2>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Name</label>
                                 <input type="text" name="nominee_customer_name" id="nominee_customer_name" class="form-control crm-form" value="" placeholder="Nominee Name">
                                 <div class="error" id="nominee_customer_name_error" ></div>
                                 </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Relation</label>
                                 <select class="form-control crm-form" name="nominee_customer_relation" id="nominee_customer_relation">
                                     <option value="">Please Select</option>
                                     <option value="father">Father</option>
                                     <option value="mother">Mother</option>
                                     <option value="brother">Brother</option>
                                     <option value="wife">Wife</option>
                                 </select>
                                 <div class="d-arrow"></div>
                                 <div class="error" id="nominee_customer_relation_error" ></div>
                                 </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Nominee DOB</label>
                                 <input type="text" name="nominee_customer_dob" id="nominee_customer_dob" class="form-control crm-form" value="" placeholder="Nominee DOB">
                                 <div class="error" id="nominee_customer_dob_error" ></div>
                                 </div>
                            </div>
                            <div class="col-md-12">
                             <h2 class="sub-title mrg-T0">Reference Information</h2>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Name</label>
                                 <input type="text" name="reference_customer_name" id="reference_customer_name" class="form-control crm-form" value="" placeholder="Reference Name">
                                 <div class="error" id="reference_customer_name_error" ></div>
                                 </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Phone No.</label>
                                 <input type="text" name="reference_customer_mobile" id="reference_customer_mobile" class="form-control crm-form" value="" placeholder="Reference Mobile">
                                 <div class="error" id="reference_customer_mobile_error" ></div>
                                 </div>
                            </div>
                           <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <input  style="text-align: center" type="button" name="btnform1" id="btnform1" class="btn-continue" value="<?= (!empty($data[0])) ? 'UPDATE AND CONTINUE' : 'SAVE AND CONTINUE' ?>" onclick="getShowForm('form2','frm1','form1');">
                                  <input type="hidden" name="step1" value="true">
                                  <input type="hidden" name="caseid" id="caseid" value="">
                               </div>
                           </div>
                        </div>
                     </div>
                  </div>
                   </form>  
               </div>
            </div>
         </div>
<!----form1 section end-->
<!----form2 section start--->
<div id="form2" style="display: none;">
<div class="container-fluid">
               <div class="row">
                   <form name="frm2" id="frm1" method="post" action="">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <h2 class="page-title">Case Info</h2>
                     <div class="white-section">
                        <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0"></h2>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label class="crm-label">Buyer Type</label>
                                  <span class="radio-btn-sec">
                                     <input type="radio" name="buyer_type" id="individual" value="1" class="trigger" checked="">
                                     <label for="individual"><span class="dt-yes"></span> Individual</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="buyer_type" id="company" value="2" class="trigger">
                                     <label for="company"><span class="dt-yes"></span> Company</label>
                                 </span>
                              </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Insurance Category</label>
                                 <select class="form-control crm-form" name="ins_category" id="ins_category">
                                     <option value="">Please Select</option>
                                     <option value="1">New</option>
                                     <option value="2">Used Car</option>
                                     <option value="3">RenewL</option>
                                     <option value="4">policy already Expired</option>
                                 </select>
                                 <div class="d-arrow"></div>
                                 <div class="error" id="ins_category_error" ></div>
                                 <?php echo form_error('ins_category'); ?>
                              </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Status</label>
                                 <select class="form-control crm-form" name="case_status" id="case_status">
                                     <option value="">Please Select</option>
                                     <option value="1">New</option>
                                     <option value="2">Interested</option>
                                     <option value="3">Follow Up</option>
                                     <option value="4">Quotes Given</option>
                                     <option value="5">Inspection Scheduled</option>
                                     <option value="6">Policy Punched</option>
                                 </select>
                                 <div class="d-arrow"></div>
                                 <div class="error" id="case_status_error" ></div>
                                 <?php echo form_error('case_status'); ?>
                              </div>
                           </div>
                            <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <!--<a href="#" class="btn-continue">SAVE AND CONTINUE</a>-->
                                  <input  style="text-align: center" type="button" name="btnform1" id="btnform1" class="btn-continue" value="<?= (!empty($data[0])) ? 'UPDATE AND CONTINUE' : 'SAVE AND CONTINUE' ?>" onclick="getShowForm('form3','frm2','form2');">
                                  <input type="hidden" name="step1" value="true">
                               </div>
                           </div>
                        </div>
                     </div>
                  </div>
                   </form>
               </div>
            </div>
         </div>
<!---form2 section end-->
<!--form3 section start -->
<div id="form3" style="display:none">
<div class="container-fluid">
               <div class="row">
                   <form name="frm3" id="frm3" method="post" action="">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <div class="white-section">
                        <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0">Vehicle Details</h2>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Make</label>
                                 <select class="form-control crm-form" name="make" id="make">
                                    <option>Delhi</option>
                                    <option>Gurgaon</option>
                                 </select>
                                 <div class="error" id="make_error" ></div>
                                 </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Make Year</label>
                                 <input type="text" name="make_year"  id="make_year" class="form-control crm-form" value="" placeholder="Make Year">
                                 <div class="error" id="make_year_error" ></div>
                                 </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Chassis No.</label>
                                 <input type="text" maxlength="17" name="chassis_no"  id="chassis_no" class="form-control crm-form" value="" placeholder="Chassis No">
                                 <div class="error" id="chassis_no_error" ></div>
                                 </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Registration No</label>
                                 <input type="text" name="regNo"  id="regNo" class="form-control crm-form" value="" placeholder="regNo">
                                 <div class="error" id="regNo_error" ></div>
                                 </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Model</label>
                                 <select class="form-control crm-form" name="model" id="model">
                                    <option>Delhi</option>
                                    <option>Gurgaon</option>
                                 </select>
                                 <div class="d-arrow"></div>
                                 <div class="error" id="model_error" ></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Variant</label>
                                 <select class="form-control crm-form" name="variant" id="variant">
                                    <option>Delhi</option>
                                    <option>Gurgaon</option>
                                 </select>
                                 <div class="d-arrow"></div>
                                 <div class="error" id="variant_error" ></div>
                              </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Engine No.</label>
                                 <input type="text" name="engine_no" class="form-control crm-form" maxlength="17" placeholder="engine_no">
                                 <div class="error" id="engine_no_error" ></div>
                              </div>
                           </div> 
                           <div class="form-group">
                                 <label class="crm-label">Car Type</label>
                                  <span class="radio-btn-sec">
                                     <input type="radio" name="car_type" id="new" value="1" class="trigger" checked="">
                                     <label for="new"><span class="dt-yes"></span> New</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="car_type" id="company" value="2" class="trigger">
                                     <label for="used"><span class="dt-yes"></span> Used</label>
                                 </span>
                              </div>
                           <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <input  style="text-align: center" type="submit" class="btn-continue" name="btnSubmit" id="btnSubmit" value="<?= (!empty($data[0])) ? 'UPDATE AND CONTINUE' : 'SAVE AND CONTINUE' ?>" onclick="return validateAddInsCase(this);">
                                  <input type="hidden" name="step3" value="true">
                               </div>
                           </div>
                        </div>
                     </div>
                  </div>
                   </form>     
               </div>
            </div>
        </div>
         </div>
<script src="<?php echo base_url(); ?>assets/js/insurance_process.js" type="text/javascript"></script>