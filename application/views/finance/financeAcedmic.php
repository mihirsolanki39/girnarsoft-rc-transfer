<div class="container-fluid">
    <style>
        .error {top: auto !important;}
    </style>
    <div class="row">
        <div class="col-md-12 pad-LR-10 mrg-B40">
            <h2 class="page-title">Case Info</h2>
            <div class="white-section">
            <form  enctype="multipart/form-data" method="post"  id="financeAcedmic" name="financeAcedmic">    
                <div class="row">
                <?php if(!empty($CustomerInfo['Buyer_Type']) && $CustomerInfo['Buyer_Type']=='2'){?>
                    <div class="col-md-12">
                        <h2 class="sub-title mrg-T0">Financial &amp; Academic Status</h2>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Education*</label>
                            <select class="form-control crm-form testselect1" name="highest_education" id="highest_education">
                               <?php foreach ($edicationType as $key=>$value){ ?>
                                <option value="<?=$key;?>"<?php echo (!empty($CustomerInfo['highest_education']) && $CustomerInfo['highest_education']==$key) ? "selected=selected" : '';?>><?=$value;?></option>
                                <?php } ?>
                            </select>
                           <!-- <div class="d-arrow"></div>-->
                            <div class="error" id="err_highest_education"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Employment Type*</label>
                            <select class="form-control crm-form testselect1" id="employment_type" name="employment_type">
                                <option value="">Please Select</option>
                                <?php foreach($employmentType as $ek=>$ev){?>
                                <option value="<?php echo $ek ?>"<?php echo (!empty($CustomerInfo['employment_type']) && $CustomerInfo['employment_type']==$ek) ? "selected=selected" : '';?>><?php echo $ev ?></option>
                                <?php } ?>
                            </select>
                            <!--<div class="d-arrow"></div>-->
                            <div class="error" id="err_employment_type"></div>
                        </div>
                    </div>
                    <div id='divsalaried' <?php echo (!empty($CustomerInfo['employment_type']) && $CustomerInfo['employment_type']=='1') ? '' : 'style="display:none"'?>>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Employer Name*</label>
                            <input type="text"   class="form-control crm-form" id="employer_name" name="employer_name" value="<?php echo (!empty($CustomerInfo['employer_name'])) ? $CustomerInfo['employer_name'] : '';?>" placeholder="Employer Name">
                            <div class="error" id="err_employer_name"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Date of Joining*</label>
                            <div class="input-group date" id="dp">
                            <input type="text" class="form-control crm-form" id="date_of_joining" name="date_of_joining" value="<?php echo ((!empty($CustomerInfo['employee_doj'])) && ($CustomerInfo['employee_doj']!='')) ? date('d-m-Y',strtotime($CustomerInfo['employee_doj'])) : '';?>" placeholder="Date of Joining">
                            <span class="input-group-addon">
                                <span class="">
                                  <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                            </span>
                            </div>
                            <div class="error" id="err_dp"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Total Work Experience (in Years)*</label>
                            <input type="text" onkeypress="return isNumberKey(event)" class="form-control crm-form" id="total_experience" name="total_experience" maxlength="2" value="<?php echo (!empty($CustomerInfo['totalexp'])) ? $CustomerInfo['totalexp'] : '';?>" placeholder="Total Work Experience">
                            <div class="error" id="err_total_experience"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Gross Monthly Income*</label>
                            <input type="text" onkeypress="return isNumberKey(event)" class="form-control rupee-icon crm-form" id="monthly_income" name="monthly_income" value="<?php echo (!empty($CustomerInfo['gross_mon_income'])) ? $CustomerInfo['gross_mon_income'] : '';?>" onkeyup="addCommas(this.value, 'monthly_income');" maxlength="7" placeholder="Gross Monthly Income">
                            <div class="error" id="err_monthly_income"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Serving Notice Period*</label>
                            <select class="form-control crm-form testselect1" id="notice_period" name="notice_period">
                                <option value="">Please Select</option>
                                <option value="yes"<?php echo (!empty($CustomerInfo['is_notice_period']) && $CustomerInfo['is_notice_period']=='yes') ? "selected=selected" : '';?>>Yes</option>
                                <option value="no"<?php echo (!empty($CustomerInfo['is_notice_period']) && $CustomerInfo['is_notice_period']=='no') ? "selected=selected" : '';?>>No</option>
                            </select>
                            <!--<div class="d-arrow"></div>-->
                            <div class="error" id="err_notice_period"></div>
                        </div>
                    </div>
                    </div>
                    
                    <div id='divbusiness' <?php echo (!empty($CustomerInfo['employment_type']) && $CustomerInfo['employment_type']=='2') ? '' : 'style="display:none"'?>>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Applicant Type*</label>
                            <select class="form-control crm-form testselect1" id="bus_applicant_type" name="bus_applicant_type">
                            <option value="">Select Application Type</option>
                                <?php foreach($bus_applicantList as $ak=>$av){?>
                                <option value="<?php echo $av->id ?>"<?php echo (!empty($CustomerInfo['bus_applicant_type']) && $CustomerInfo['bus_applicant_type']==$av->id) ? "selected=selected" : '';?>><?php echo $av->type_values ?></option>
                                <?php } ?>
                            </select>
                            <!--<div class="d-arrow"></div>-->
                            <div class="error" id="err_bus_applicant_type"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Industry Type*</label>
                            <select class="form-control testselect1 crm-form testselect1" id="bus_industry_type" name="bus_industry_type">
                             <option value="">Select Industry Type</option>
                                <?php foreach($bus_industryList as $ik=>$iv){?>
                                <option value="<?php echo $iv->id; ?>"<?php echo (!empty($CustomerInfo['bus_industry_type']) && $CustomerInfo['bus_industry_type']==$iv->id) ? "selected=selected" : '';?>><?php echo $iv->type_values; ?></option>
                                <?php } ?>
                            </select>
                            <!--<div class="d-arrow"></div>-->
                            <div class="error" id="err_bus_industry_type"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Business Name*</label>
                            <input type="text" class="form-control crm-form" id="bus_business_name" name="bus_business_name" value="<?php echo (!empty($CustomerInfo['bus_business_name'])) ? $CustomerInfo['bus_business_name'] : '';?>" placeholder="Business Name">
                            <div class="error" id="err_bus_business_name"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Office Setup Type</label>
                            <select class="form-control crm-form testselect1" id="bus_office_setup_type" name="bus_office_setup_type">
                                <option value="">Please Select</option>
                                <option value="1"<?php echo (!empty($CustomerInfo['bus_off_set_up']) && $CustomerInfo['bus_off_set_up']=='1') ? "selected=selected" : '';?>>Resi-cum Office</option>
                                <option value="2"<?php echo (!empty($CustomerInfo['bus_off_set_up']) && $CustomerInfo['bus_off_set_up']=='2') ? "selected=selected" : '';?>>Own Office</option>
                                <option value="3"<?php echo (!empty($CustomerInfo['bus_off_set_up']) && $CustomerInfo['bus_off_set_up']=='3') ? "selected=selected" : '';?>>Out of Client Site</option>
                                 <option value="4"<?php echo (!empty($CustomerInfo['bus_off_set_up']) && $CustomerInfo['bus_off_set_up']=='4') ? "selected=selected" : '';?>> Rented Office</option>
                                  <option value="5"<?php echo (!empty($CustomerInfo['bus_off_set_up']) && $CustomerInfo['bus_off_set_up']=='5') ? "selected=selected" : '';?>>Co-Working Office</option>
                            </select>
                           <!-- <div class="d-arrow"></div>-->
                            <div class="error" id="err_bus_office_setup_type"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group">
                             <label for="" class="crm-label">Start Date Of Business</label>
                             <input type="text" name="bus_start_business_date" class="form-control form-control-2 icon-cal1 to" placeholder="Selet Month Year" value="<?=(!empty($CustomerInfo['bus_start_business_date']))?$CustomerInfo['bus_start_business_date']:''?>" >
                         </div>
                    </div>
               
                    <div class="col-md-6" id="lstItr">
                           <div class="form-group">
                              <label for="" class="crm-label">Last 2 ITRs </label>
                              <div class="row">
                                <div class="col-md-6">
                                    <!--<label for="" class="crm-label">Year <?=date("Y",strtotime("-1 year"));?></label>-->
                                    <input type="text" onkeypress="return isNumberKey(event)" class="form-control rupee-icon crm-form" id="bus_itr_income1" name="bus_itr_income1" value="<?php echo (!empty($CustomerInfo['bus_itr_income1'])) ? $CustomerInfo['bus_itr_income1'] : '';?>" placeholder="Gross Income <?=date("Y",strtotime("-1 year"));?>" onkeyup="addCommas(this.value, 'bus_itr_income1');" maxlength="9">
                                    <div class="error" id="err_bus_itr_income1"></div>
                              </div>
                              <div class="col-md-6">
                                    <!--<label for="" class="crm-label">Year  <?=date("Y",strtotime("-2 year"));?></label>-->
                                    <input type="text" onkeypress="return isNumberKey(event)" class="form-control rupee-icon crm-form" id="bus_itr_income2" name="bus_itr_income2" value="<?php echo (!empty($CustomerInfo['bus_itr_income2'])) ? $CustomerInfo['bus_itr_income2'] : '';?>" placeholder="Gross Income <?=date("Y",strtotime("-2 year"));?>" onkeyup="addCommas(this.value, 'bus_itr_income2');" maxlength="9">
                                    <div class="error" id="err_bus_itr_income2"></div>
                              </div> 
                              </div>
                           </div>
                        </div>   
                    </div>
                    <div id='divprofession' <?php echo (!empty($CustomerInfo['employment_type']) && $CustomerInfo['employment_type']=='3') ? '' : 'style="display:none"'?>>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Office Setup Type</label>
                            <select class="form-control crm-form testselect1" id="pro_office_setup_type" name="pro_office_setup_type">
                                <option value="">Please Select</option>
                                <option value="1"<?php echo (!empty($CustomerInfo['pro_off_set_up']) && $CustomerInfo['pro_off_set_up']=='1') ? "selected=selected" : '';?>>Resi-cum Office</option>
                                <option value="2"<?php echo (!empty($CustomerInfo['pro_off_set_up']) && $CustomerInfo['pro_off_set_up']=='2') ? "selected=selected" : '';?>>Own Office</option>
                                <option value="3"<?php echo (!empty($CustomerInfo['pro_off_set_up']) && $CustomerInfo['pro_off_set_up']=='3') ? "selected=selected" : '';?>>Out of Client Site</option>
                                <option value="4"<?php echo (!empty($CustomerInfo['pro_off_set_up']) && $CustomerInfo['pro_off_set_up']=='4') ? "selected=selected" : '';?>>Rented Office</option>
                                <option value="5"<?php echo (!empty($CustomerInfo['pro_off_set_up']) && $CustomerInfo['pro_off_set_up']=='5') ? "selected=selected" : '';?>>Co-Working Office</option>
                            </select>
                           <!-- <div class="d-arrow"></div>-->
                            <div class="error" id="err_pro_office_setup_type"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group">
                          <label for="" class="crm-label">Last 2 ITRs</label>
                          <div class="row">
                            <div class="col-md-6">
                                <input type="text" onkeypress="return isNumberKey(event)" class="form-control crm-form rupee-icon" id="pro_itr_income1" name="pro_itr_income1" value="<?php echo (!empty($CustomerInfo['pro_itr_income1'])) ? $CustomerInfo['pro_itr_income1'] : '';?>" placeholder="Gross Income Year <?=date("Y",strtotime("-1 year"));?>" onkeyup="addCommas(this.value, 'pro_itr_income1');" maxlength="9">
                                <div class="error" id="err_pro_itr_income1"></div>
                          </div>
                          <div class="col-md-6">
                                <input type="text" onkeypress="return isNumberKey(event)" class="form-control rupee-icon crm-form" id="pro_itr_income2" name="pro_itr_income2" value="<?php echo (!empty($CustomerInfo['pro_itr_income2'])) ? $CustomerInfo['pro_itr_income2'] : '';?>" placeholder="Gross Income Year <?=date("Y",strtotime("-2 year"));?>" onkeyup="addCommas(this.value, 'pro_itr_income2');" maxlength="9">
                                <div class="error" id="err_pro_itr_income2"></div>
                          </div> 
                          </div>
                       </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Profession Type*</label>
                            <select class="form-control testselect1 crm-form" id="pro_industry_type" name="pro_industry_type">
                              <option value="">Select Profession Type</option>
                                <?php foreach($professionList as $ik=>$iv){?>
                                <option value="<?php echo $iv->id; ?>"<?php echo (!empty($CustomerInfo['pro_industry_type']) && $CustomerInfo['pro_industry_type']==$iv->id) ? "selected=selected" : '';?>><?php echo $iv->type_values; ?></option>
                                <?php } ?>
                            </select>
                            <!--<div class="d-arrow"></div>-->
                            <div class="error" id="err_pro_industry_type"></div>
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Start Date Of Profession</label>
                            <div class="row">
                               <div class="col-md-6">
                               <!-- <input type="text" onkeypress="return isNumberKey(event)"  class="form-control crm-form" id="pro_start_date_month" name="pro_start_date_month" maxlength="2" value="<?php echo (!empty($CustomerInfo['pro_start_date_mon'])) ? $CustomerInfo['pro_start_date_mon'] : '';?>" placeholder="Start Month Of Business">-->
                               <select class="form-control crm-form testselect1" id="pro_start_date_month" name="pro_start_date_month">
                               <option value="">Start Month Of Profession</option>
                              <option value="1" <?php echo (!empty($CustomerInfo['pro_start_date_mon']) && ($CustomerInfo['pro_start_date_mon']=='1'))?'selected': '';?>>Jan</option>
                               <option value="2" <?php echo (!empty($CustomerInfo['pro_start_date_mon']) && ($CustomerInfo['pro_start_date_mon']=='2'))?'selected': '';?>>Feb</option>
                                <option value="3" <?php echo (!empty($CustomerInfo['pro_start_date_mon']) && ($CustomerInfo['pro_start_date_mon']=='3'))?'selected': '';?>>Mar</option>
                                 <option value="4" <?php echo (!empty($CustomerInfo['pro_start_date_mon']) && ($CustomerInfo['pro_start_date_mon']=='4'))?'selected': '';?>>Apr</option>
                               <option value="5" <?php echo (!empty($CustomerInfo['pro_start_date_mon']) && ($CustomerInfo['pro_start_date_mon']=='5'))?'selected': '';?>>May</option>
                                <option value="6" <?php echo (!empty($CustomerInfo['pro_start_date_mon']) && ($CustomerInfo['pro_start_date_mon']=='6'))?'selected': '';?>>Jun</option>
                                <option value="7" <?php echo (!empty($CustomerInfo['pro_start_date_mon']) && ($CustomerInfo['pro_start_date_mon']=='7'))?'selected': '';?>>Jul</option>
                               <option value="8" <?php echo (!empty($CustomerInfo['pro_start_date_mon']) && ($CustomerInfo['pro_start_date_mon']=='8'))?'selected': '';?>>Aug</option>
                                <option value="9" <?php echo (!empty($CustomerInfo['pro_start_date_mon']) && ($CustomerInfo['pro_start_date_mon']=='9'))?'selected': '';?>>Sep</option>
                                 <option value="10" <?php echo (!empty($CustomerInfo['pro_start_date_mon']) && ($CustomerInfo['pro_start_date_mon']=='10'))?'selected': '';?>>Oct</option>
                               <option value="11" <?php echo (!empty($CustomerInfo['pro_start_date_mon']) && ($CustomerInfo['pro_start_date_mon']=='11'))?'selected': '';?>>Nov</option>
                                <option value="12" <?php echo (!empty($CustomerInfo['pro_start_date_mon']) && ($CustomerInfo['pro_start_date_mon']=='12'))?'selected': '';?>>Dec</option>
                               </select>
                               <div class="error" id="err_pro_start_date_month"></div>
                              </div>
                            
                              <div class="col-md-6">
                                <!--<input type="text" onkeypress="return isNumberKey(event)" class="form-control crm-form" id="bus_start_date_year" name="bus_start_date_year" maxlength="4" value="<?php echo (!empty($CustomerInfo['bus_start_business_year'])) ? $CustomerInfo['bus_start_business_year'] : '';?>" placeholder="Start Year Of Business">-->

                                <select class="form-control crm-form testselect1" id="pro_start_date_year" name="pro_start_date_year">
                               <option value="">Start Year Of Profession</option>
                               <?php                               
                                for($i=1950; $i<=date(Y); $i++)
                                { ?>
                                    <option value="<?=$i?>" <?php echo (!empty($CustomerInfo['pro_start_date_year']) && ($CustomerInfo['pro_start_date_year']==$i)) ? 'selected' : '';?>><?=$i?></option>
                               <?php } ?>
                               </select>
                                <div class="error" id="err_pro_start_date_year"></div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="col-md-6">
                       <div class="form-group">
                          <label for="" class="crm-label">Start Date Of Profession</label>
                          <div class="row">
                             <div class="col-md-6">
                             <div class="form-group">
                                <input type="text" onkeypress="return isNumberKey(event)" class="form-control crm-form" id="pro_start_date_month" name="pro_start_date_month" value="<?php echo (!empty($CustomerInfo['pro_start_date_mon'])) ? date('d-m-Y',strtotime($CustomerInfo['pro_start_date_mon'])) : '';?>" placeholder="Start Month Of Business">
                             </div>
                          </div>
                          <div class="col-md-6">
                             <div class="form-group"><input type="text" onkeypress="return isNumberKey(event)" class="form-control crm-form" id="pro_start_date_year" name="pro_start_date_year" value="<?php echo (!empty($CustomerInfo['pro_start_date_year'])) ?  date('d-m-Y',strtotime($CustomerInfo['pro_start_date_year'])) : '';?>" placeholder="Start Year Of Business">
                             </div>
                          </div> 
                          </div>
                       </div>
                    </div> -->  
                    </div>
                    <div id='divothers' <?php echo (!empty($CustomerInfo['employment_type']) && $CustomerInfo['employment_type']=='4') ? '' : 'style="display:none"'?>>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Other Type</label>
                            <select class="form-control crm-form testselect1" id="oth_type" name="oth_type">
                                <option value="">Please Select</option>
                                <?php foreach($oth_industryList as $ok=>$ov){?>
                                <option value="<?php echo $ov->id; ?>"<?php echo (!empty($CustomerInfo['oth_type']) && $CustomerInfo['oth_type']==$ov->id) ? "selected=selected" : '';?>><?php echo $ov->type_values; ?></option>
                                <?php } ?>
                            </select>
                            <!--<div class="d-arrow"></div>-->
                              <div class="error" id="err_oth_type"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Does the customer own a house/commercial property?</label>
                            <span class="radio-btn-sec">
                                <input type="radio" name="others_followup" id="others_is_residence_owner_Yes" value="yes" class="trigger" <?php echo (!empty($CustomerInfo['oth_customer_own']) && $CustomerInfo['oth_customer_own']=='yes') ? "checked=checked" : '';?>>
                                <label for="others_is_residence_owner_Yes"><span class="dt-yes"></span> Yes</label>
                            </span>
                            <span class="radio-btn-sec bat" >
                                <input type="radio" name="others_followup" id="others_is_residence_owner_No" value="no" class="trigger" <?php echo (!empty($CustomerInfo['oth_customer_own']) && $CustomerInfo['oth_customer_own']=='no') ? "checked=checked" : '';?>>
                                <label for="others_is_residence_owner_No"><span class="dt-yes"></span> No</label>
                            </span>
                             <div class="error" id="err_others_followup"></div>
                        </div>    
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Has the Customer taken a loan before?</label>
                            <span class="radio-btn-sec">
                                <input type="radio" name="others_loan" id="others_previous_loan_Yes" value="yes" class="trigger" <?php echo (!empty($CustomerInfo['oth_customer_taken_loan']) && $CustomerInfo['oth_customer_taken_loan']=='yes') ? "checked=checked" : '';?>>
                                <label for="others_previous_loan_Yes"><span class="dt-yes"></span> Yes</label>
                            </span>
                            <span class="radio-btn-sec bat" >
                                <input type="radio" name="others_loan" id="others_previous_loan_No" value="no" class="trigger" <?php echo (!empty($CustomerInfo['oth_customer_taken_loan']) && $CustomerInfo['oth_customer_taken_loan']=='no') ? "checked=checked" : '';?>>
                                <label for="others_previous_loan_No"><span class="dt-yes"></span> No</label>
                            </span>
                             <div class="error" id="err_others_loan"></div>
                        </div>    
                    </div>    
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Type Of Vehicle Owned*</label>
                            <select class="form-control crm-form testselect1"  name="type_of_vehicle_owned" id="type_of_vehicle_owned">
                                 <option value="">Select Vehicle Type </option>
                                 <option value="1" <?php echo (!empty($CustomerInfo['type_of_vehicle_owned']) && $CustomerInfo['type_of_vehicle_owned']=='1') ? "selected=selected" : '';?> >None</option>
                                <option value="2" <?php echo (!empty($CustomerInfo['type_of_vehicle_owned']) && $CustomerInfo['type_of_vehicle_owned']=='2') ? "selected=selected" : '';?> >Car</option>
                                <option value="3" <?php echo (!empty($CustomerInfo['type_of_vehicle_owned']) && $CustomerInfo['type_of_vehicle_owned']=='3') ? "selected=selected" : '';?> >Two Wheeler</option>    
                            </select>
                            <!--<div class="d-arrow"></div>-->
                            <div class="error" id="err_type_of_vehicle_owned"></div>
                        </div>
                    </div>
                   <!--  <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Type Of Vehicle Owned*</label>
                            <input type="text" onkeypress="return blockSpecialChar(event)" class="form-control crm-form" placeholder="Type Of Vehicle Owned" value="<?php echo (!empty($CustomerInfo['type_of_vehicle_owned'])) ? $CustomerInfo['type_of_vehicle_owned'] : '';?>" id="type_of_vehicle_owned" name="type_of_vehicle_owned">
                        </div>
                    </div>
                   <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Vehicle Ownership*</label>
                            <!--<input type="text" onkeypress="return isNumberKey(event)" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['vehicle_ownership'])) ? $CustomerInfo['vehicle_ownership'] : '';?>" placeholder="Vehicle Ownership" id="vehicle_ownership" name="vehicle_ownership"> 
                            <select lass="form-control crm-form" name="vehicle_ownership" id="vehicle_ownership">
                                <option value="">Owner Type</option>
                                <option value="1" <?php echo (!empty($CustomerInfo['vehicle_ownership']) && $CustomerInfo['vehicle_ownership']=='1') ? "selected=selected" : '';?> >First</option>
                                <option value="2" <?php echo (!empty($CustomerInfo['vehicle_ownership']) && $CustomerInfo['vehicle_ownership']=='2') ? "selected=selected" : '';?> >Second</option>
                                <option value="3" <?php echo (!empty($CustomerInfo['vehicle_ownership']) && $CustomerInfo['vehicle_ownership']=='3') ? "selected=selected" : '';?> >Third</option>
                                <option value="4" <?php echo (!empty($CustomerInfo['vehicle_ownership']) && $CustomerInfo['vehicle_ownership']=='4') ? "selected=selected" : '';?> >Fourth</option>
                                <option value="5" <?php echo (!empty($CustomerInfo['vehicle_ownership']) && $CustomerInfo['vehicle_ownership']=='5') ? "selected=selected" : '';?> >More than Four</option>
                            </select>
                             <div class="d-arrow"></div>
                        </div>
                    </div>-->
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Vehicle Ownership*</label>
                            <select class="form-control crm-form testselect1"  name="vehicle_ownership" id="vehicle_ownership">
                                 <option value="">Owner Type</option>
                                 <option value="1" <?php echo (!empty($CustomerInfo['vehicle_ownership']) && $CustomerInfo['vehicle_ownership']=='1') ? "selected=selected" : '';?> >None</option>
                                <option value="2" <?php echo (!empty($CustomerInfo['vehicle_ownership']) && $CustomerInfo['vehicle_ownership']=='2') ? "selected=selected" : '';?> >Self</option>
                                <option value="3" <?php echo (!empty($CustomerInfo['vehicle_ownership']) && $CustomerInfo['vehicle_ownership']=='3') ? "selected=selected" : '';?> >Co. provided</option>
                                <option value="4" <?php echo (!empty($CustomerInfo['vehicle_ownership']) && $CustomerInfo['vehicle_ownership']=='4') ? "selected=selected" : '';?> >Finance</option>
                            </select>
                           <!-- <div class="d-arrow"></div>-->
                            <div class="error" id="err_vehicle_ownership"></div>
                        </div>
                    </div>
                    <?php } ?>
                    <div id="offcdetail">
                    <div class="col-md-12">
                         <h2 class="sub-title first-title">Office Details</h2>
                    </div>
                   <!-- <div class="col-md-6">
                        <div class="form-group">
                            <h2 class="sub-title first-title">Buyer Information</h2>
                            <input type="text" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['office'])) ? $CustomerInfo['office'] : '';?>" placeholder="Office" id="office" name="office">
                        </div>
                    </div>-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Office Address*</label>
                            <input type="text" class="form-control crm-form" placeholder="Office Address" value="<?php echo (!empty($CustomerInfo['office_address'])) ? $CustomerInfo['office_address'] : '';?>" id="office_address" name="office_address">
                            <div class="error" id="err_office_address"></div>
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Landmark</label>
                            <input type="text" class="form-control crm-form" placeholder="Landmark" value="<?php echo (!empty($CustomerInfo['office_landmark'])) ? $CustomerInfo['office_landmark'] : '';?>" id="office_landmark" name="office_landmark">
                            <div class="error" id="err_office_address"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Office City*</label>
                            <select class="form-control testselect1 crm-form search-box" name="office_cityList" id="office_cityList">
                                <option value="">Select City</option>
                                <?php foreach($cityList as $kcity=>$city){?>
                                <option value="<?php echo $city['city_id']; ?>"<?php echo (!empty($CustomerInfo['office_city']) && $CustomerInfo['office_city']==$city['city_id']) ? "selected=selected" : '';?>><?php echo $city['city_name']; ?></option>
                                <?php } ?>
                            </select>
                            
                            <div class="error" id="err_office_cityList"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Office Pin Code*</label>
                            <input type="text" onkeypress="return isNumberKey(event)" maxlength="6" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['office_pincode'])) ? $CustomerInfo['office_pincode'] : '';?>" placeholder="Office Pin Code" id="office_pincode" name="office_pincode" maxlength="6">
                            <div class="error" id="err_office_pincode"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Phone</label>
                            <input type="text" class="form-control crm-form" placeholder="Phone No." onkeypress="return isNumberKey(event)" value="<?php echo (!empty($CustomerInfo['office_phone'])) ? $CustomerInfo['office_phone'] : '';?>" id="office_phone" name="office_phone" maxlength="10">
                            <div class="error" id="err_office_phone"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Mobile</label>
                            <input type="text" class="form-control crm-form" placeholder="Mobile No." onkeypress="return isNumberKey(event)" value="<?php echo (!empty($CustomerInfo['office_mobile'])) ? $CustomerInfo['office_mobile'] : '';?>" id="office_mobile" name="office_mobile" maxlength="10">
                            <div class="error" id="err_office_mobile"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Email</label>
                            <input type="text" class="form-control crm-form" placeholder="Email Address." value="<?php echo (!empty($CustomerInfo['office_email'])) ? $CustomerInfo['office_email'] : '';?>" name="office_email" id="office_email">
                            <div class="error" id="err_office_email"></div>
                        </div>
                    </div>
                    </div>
                    <input type="hidden" value="<?= !empty($CustomerInfo['customer_id'])?$CustomerInfo['customer_id']:'' ?>" name="customerId">
                    <input type="hidden" value="<?= !empty($CustomerInfo['customer_loan_id'])?$CustomerInfo['customer_loan_id']:'' ?>" name="caseId" id="caseId">
                    <input type="hidden" name="financeAcedmicForm" value="1">
                    <input type="hidden" name="empType" id="empType" value="<?php echo (!empty($CustomerInfo['employment_type'])) ? $CustomerInfo['employment_type']:'';?>">
                    <input type="hidden" name="buyerType" id="buyerType" value="<?php echo (!empty($CustomerInfo['Buyer_Type'])) ? $CustomerInfo['Buyer_Type']:'';?>">
                    <div class="col-md-12">
                        <div class="btn-sec-width">
                        <?php 
                        $stylesss = 'display:block';
                        $stylec = 'display:none';
                        $action = '';
                        /*if(!empty($CustomerInfo['tag_flag']) && ($CustomerInfo['tag_flag']=='4'))
                        {
                            $stylesss  = 'display:none';
                            $stylec = 'display:block';
                            $action = base_url('loanExpected/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);
                        }*/

                         if(((($rolemgmt[0]['edit_permission']=='0') && (!empty($CustomerInfo['cust_bnk_id']))) || ($rolemgmt[0]['add_permission']=='0')) || ((!empty($CustomerInfo['ref_id'])) && ($rolemgmt[0]['role_name']!='admin') && ($rolemgmt[0]['role_name']!='Loan Admin')))
                            {
                                //echo "kkkkk"; exit;
                                $stylesss  = 'display:none';
                                $stylec = 'display:block';
                                $action = base_url('loanExpected/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);

                            }
                        if($CustomerInfo['cancel_id']=='0'){ ?>
                            <button type="button" class="btn-continue saveCont"  style="<?=$stylesss?>"  id="financeAcedmicButton">SAVE AND CONTINUE</button>
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
<?php $currentdate=date('d/m/Y');?>
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script>
  $('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
  </script>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>
<script>
    $(document).ready(function() {
     StartDate =  '<?=date('d/m/Y',  strtotime($currentdate));?>';
      now      = '<?= date('d-m-Y') ?>';
      $('#date_of_joining').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: '-1000y',
                endDate:'1d',
                autoclose: true,
                todayHighlight: true   
             });
      /*$('#date_of_joining').datetimepicker({
        timepicker: false,
        format: 'd-m-Y',
        startDate: StartDate,
        maxDate:'<?= date('d-m-Y') ?>',
        constrainInput: true,
        scrollMonth: false,
        scrollTime: false,
        scrollInput: false,
    });*/
    
    
    var customer_type = "<?php echo (!empty($CustomerInfo['Buyer_Type'])) ? $CustomerInfo['Buyer_Type'] : '';?>";
    if(customer_type=='1') 
    {
        $('#offcdetail').attr('style','display:block');
    }
        var off_type ='';
        var employment_type ="<?php echo (!empty($CustomerInfo['employment_type'])) ? $CustomerInfo['employment_type'] : '';?>";
        if(employment_type=='2'){
            var off_type = "<?php echo  (!empty($CustomerInfo['bus_off_set_up']) ) ? $CustomerInfo['bus_off_set_up']: ''?>";
         }
         else if(employment_type=='3'){
            var off_type = "<?php echo  (!empty($CustomerInfo['pro_off_set_up']) ) ? $CustomerInfo['pro_off_set_up']: ''?>";
        }
            if((off_type=='2') && ((employment_type=='2') || (employment_type=='3')))
            {
                $('#offcdetail').attr('style','display:block');
            }
            else if((customer_type=='2'))
            {
                $('#offcdetail').attr('style','display:none');
            }
    });
    $( "#bus_start_date_year" ).change(function() {
        var start_year = $('#bus_start_date_year').val();
       // alert(start_year);
        $('#lstItr').attr('style','display:block;');
        if(start_year=="<?=date('Y')?>")
        {
          //  alert('hiiiiii');
            $('#lstItr').attr('style','display:none;');
        }
        });

        var start_year = $('#bus_start_date_year').val();
        $('#lstItr').attr('style','display:block;');
        if(start_year=="<?=date('Y')?>")
        {
            $('#lstItr').attr('style','display:none;');
        }


         $( "#bus_office_setup_type" ).change(function() {
            var off_type = $('#bus_office_setup_type').val();
            var employment_type = $('#employment_type').val();
            if((off_type=='2') && ((employment_type=='2') || (employment_type=='3')))
            {
                $('#offcdetail').attr('style','display:block');
            }
            else
            {
                $('#offcdetail').attr('style','display:none');
            }

        
        });

         $( "#pro_office_setup_type" ).change(function() {
            var off_types = $('#pro_office_setup_type').val();
            var employment_type = $('#employment_type').val();
            if((off_types=='2') && ((employment_type=='2') || (employment_type=='3')))
            {
                $('#offcdetail').attr('style','display:block');
            }
            else
            {
                $('#offcdetail').attr('style','display:none');
            }

        
        });
         
           //bus_start_date_year
     </script>

     <script type="text/javascript">
        var ToEndDate = new Date();
        console.log(ToEndDate);

        $('.to').datepicker({
            autoclose: true,
            minViewMode: 1,
            format: 'mm-yyyy'
        }).on('changeDate', function(selected){
                FromEndDate = new Date(selected.date.valueOf());
                FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
                $('.from').datepicker('setEndDate', FromEndDate);
            });
        </script>
<script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>
