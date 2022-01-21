                <?php //echo '<pre>';print_r($CustomerInfo);die;?>
<!--<div class="col-crm-right">-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 pad-LR-10 mrg-B40">
                <h2 class="page-title">Case Info</h2>
                <div class="white-section">
                    <form  enctype="multipart/form-data" method="post"  id="CaseInfoForm" name="CaseInfoForm">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="sub-title mrg-T0">Personal Details</h2>
                            </div>
                            <?php
                                $dobIn = 'Date Of Incorporation*';
                                $idDob = 'doi';
                             if($CustomerInfo['Buyer_Type']==2){
                                $dobIn = 'Date of Birth*';
                                $idDob = 'dob';
                                ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="crm-label">Gender*</label>
                                    <span class="radio-btn-sec">
                                        <input type="radio" name="gender" id="male" value="1" class="trigger" 
                                        <?php if(!empty($CustomerInfo && $CustomerInfo['gender']=='male'))
                                                {
                                                    echo 'checked=checked';
                                                }
                                                else if(!empty($CustomerPerDetail && $CustomerPerDetail['customer_gender']=='1'))
                                                {
                                                    echo 'checked=checked';
                                                }
                                                else 
                                                {
                                                    echo "";
                                                }
                                                ?>>
                                        <label for="male"><span class="dt-yes"></span> Male</label>
                                    </span>
                                    <span class="radio-btn-sec">
                                        <input type="radio" name="gender" id="female" value="2" class="trigger" 
                                        <?php /*= !empty($CustomerInfo && $CustomerInfo['gender']=='female')?'checked=checked':''*/
                                         if(!empty($CustomerInfo && $CustomerInfo['gender']=='female'))
                                                {
                                                    echo 'checked=checked';
                                                }
                                                else if(!empty($CustomerPerDetail && $CustomerPerDetail['customer_gender']=='2'))
                                                {
                                                    echo 'checked=checked';
                                                }
                                                else 
                                                {
                                                    echo "";
                                                }
                                                ?>
                                        >
                                        <label for="female"><span class="dt-yes"></span> Female</label>
                                    </span>
                                    <div class="error" id="err_gender"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="crm-label">Maritial Status*</label>
                                    <span class="radio-btn-sec">
                                        <input type="radio" name="martial_status" id="married" value="married" class="trigger" <?php /* !empty($CustomerInfo && $CustomerInfo['martial_status']=='married')?'checked=checked':'' */
                                         if(!empty($CustomerInfo && $CustomerInfo['martial_status']=='married'))
                                                {
                                                    echo 'checked=checked';
                                                }
                                                else if(!empty($CustomerPerDetail && $CustomerPerDetail['customer_martial_status']=='married'))
                                                {
                                                    echo 'checked=checked';
                                                }
                                                else 
                                                {
                                                    echo "checked=checked";
                                                }
                                            
                                        ?> >
                                        <label for="married"><span class="dt-yes"></span> Married</label>
                                    </span>
                                    <span class="radio-btn-sec">
                                        <input type="radio" name="martial_status" id="unmarried" value="unmarried" class="trigger" <?php /* !empty($CustomerInfo && $CustomerInfo['martial_status']=='unmarried')?'checked=checked':''*/
                                         if(!empty($CustomerInfo && $CustomerInfo['martial_status']=='unmarried'))
                                                {
                                                    echo 'checked=checked';
                                                }
                                                else if(!empty($CustomerPerDetail && $CustomerPerDetail['customer_martial_status']=='unmarried'))
                                                {
                                                    echo 'checked=checked';
                                                }
                                                else 
                                                {
                                                     echo '';
                                                }

                                        ?>>
                                        <label for="unmarried"><span class="dt-yes"></span> Unmarried</label>
                                    </span>
                                    <div class="error" id="err_martial_status"></div>
                                </div>    
                            </div>
                            <?php } ?>
                            <div class="col-md-6" style="height:84px;">
                                <div class="form-group">
                                    <label for="" class="crm-label"><?=$dobIn?></label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1" id="<?=$idDob?>" name="dob" autocomplete="off" value="<?php 
                                            if(!empty($CustomerInfo && $CustomerInfo['Buyer_Type']=='2'))
                                            {
                                                if(!empty($CustomerInfo['dob']) && ($CustomerInfo['dob']>'0000-00-00'))
                                                { 
                                                    $dob = date('d-m-Y',strtotime($CustomerInfo['dob'])) ;
                                                } 
                                                else if(!empty($CustomerPerDetail['customer_dob']) && ($CustomerPerDetail['customer_dob']>'0000-00-00') && ($CustomerPerDetail['customer_dob']!='1970-01-01'))
                                                { 
                                                    $dob = date('d-m-Y',strtotime($CustomerPerDetail['customer_dob'])) ;
                                                } 
                                                else 
                                                { 
                                                    $dob = '' ;
                                                } 
                                            }
                                            else if(!empty($CustomerInfo['date_of_incorporation']) && ($CustomerInfo['date_of_incorporation']>'0000-00-00'))
                                            {
                                                $dob = date('d-m-Y',strtotime($CustomerInfo['date_of_incorporation'])) ;
                                            }
                                            else
                                            {
                                                $dob = '';
                                            }
                                            echo $dob ;
                                            ?><?/*= !empty($CustomerInfo && $CustomerInfo['Buyer_Type']=='2') ?(!empty($CustomerInfo['dob']) && ($CustomerInfo['dob']!='0000-00-00'))?$CustomerInfo['dob']:'':(!empty($CustomerInfo['date_of_incorporation']) && ($CustomerInfo['date_of_incorporation']!='0000-00-00'))?$CustomerInfo['date_of_incorporation']:''*/ ?>" >
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="err_dp"></div>
                                </div>
                            </div>
                            <?php if($CustomerInfo['Buyer_Type']==2){?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="crm-label">No of dependents*</label>
                                    <input type="text" onkeypress="return isNumberKey(event)" id="no_of_dependent" name="no_of_dependent" class="form-control crm-form" placeholder="No of dependents" value="<?= !empty($CustomerInfo['no_of_dependent'])?$CustomerInfo['no_of_dependent']:''?>" autocomplete="off" maxlength="2">
                                     <div class="error" id="err_no_of_dependent"></div>
                                </div>
                            </div>
                            <?php  } ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="crm-label">PAN No.*</label>
                                    <input type="text" name="pan_number" id="pan_number" class="form-control upperCaseLoan crm-form" value="<?php 
                                        if(!empty($CustomerInfo['pan_number'])) 
                                        { 
                                            echo $CustomerInfo['pan_number']; 
                                        } 
                                        else if(!empty($CustomerPerDetail['customer_pan_no']))
                                        {
                                            echo $CustomerPerDetail['customer_pan_no']; 
                                        }
                                        else
                                        {
                                            echo "";
                                        }
                                        ?>" placeholder="AAAPL1234C" autocomplete="off" maxlength="10">
                                        <div class="error" id="err_pan_number"></div>
                                </div>
                            </div>
                             <?php if($CustomerInfo['Buyer_Type']==2){?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="crm-label">Aadhar/Passport/Voter Id No.</label>
                                    <input onkeypress="return blockSpecialChar(event)" type="text" id="aadhar_no" name="aadhar_no" class="form-control crm-form" placeholder="Aadhar No." value="<?php 
                                        if(!empty($CustomerInfo['aadhar_no'])) 
                                        { 
                                            echo $CustomerInfo['aadhar_no']; 
                                        } 
                                        else if(!empty($CustomerPerDetail['customer_aadhar_no']))
                                        {
                                            echo $CustomerPerDetail['customer_aadhar_no']; 
                                        }
                                        else
                                        {
                                            echo "";
                                        }
                                        ?>" maxlength="25" >
                                        <div class="error" id="err_aadhar_no"></div>
                                </div>
                            </div>
                          <?php //if($CustomerInfo['Buyer_Type']==2){ ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="crm-label">Father/Husband Name*</label>
                                    <input onkeypress="return nameOnly(event)" type="text" id="father_name" name="father_name" class="form-control crm-form nameCaseLoan" placeholder="Father/Husband Name" value="<?php 
                                        if(!empty($CustomerInfo['father_name'])) 
                                        { 
                                            echo ucwords($CustomerInfo['father_name']); 
                                        } 
                                        else if(!empty($CustomerPerDetail['customer_father_name']))
                                        {
                                            echo ucwords($CustomerPerDetail['customer_father_name']); 
                                        }
                                        else
                                        {
                                            echo "";
                                        }
                                        ?>">
                                        <div class="error" id="err_father_name"></div>
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""  class="crm-label">Mother’s Maiden Name*</label>
                                    <input onkeypress="return nameOnly(event)" type="text" id="mother_name" name="mother_name" class="form-control crm-form nameCaseLoan" value="<?php 
                                        if(!empty($CustomerInfo['mother_name'])) 
                                        { 
                                            echo ucwords($CustomerInfo['mother_name']); 
                                        } 
                                        else if(!empty($CustomerPerDetail['customer_mother_name']))
                                        {
                                            echo ucwords($CustomerPerDetail['customer_mother_name']); 
                                        }
                                        else
                                        {
                                            echo "";
                                        }
                                        ?>" placeholder="Mother’s Maiden Name">
                                        <div class="error" id="err_mother_name"></div>
                                </div>
                            </div>
                            <?php }
                            if($CustomerInfo['Buyer_Type']==1){?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""  class="crm-label">GST Number</label>
                                    <input onkeypress="return blockSpecialChar(event)" type="text" id="gst_number" name="gst_number" class="form-control crm-form upperCaseLoan" maxlength="16" value="<?php 
                                        if(!empty($CustomerInfo['gst_number'])) 
                                        { 
                                            echo $CustomerInfo['gst_number']; 
                                        } 
                                        else
                                        {
                                            echo "";
                                        }
                                        ?>" placeholder="GST Number">
                                        <div class="error" id="err_gst_number"></div>
                                </div>
                            </div>
                            <?}
                            ?>
                            <input type="hidden" value="1" name="CaseInfoForm">
                            <input type="hidden" value="<?= !empty($CustomerInfo['customer_id'])?$CustomerInfo['customer_id']:'' ?>" name="customerId">
                             <input type="hidden" value="<?= !empty($CustomerInfo['customer_loan_id'])?$CustomerInfo['customer_loan_id']:'' ?>" name="caseId" id="caseId">
                              <input type="hidden" value="<?= !empty($CustomerInfo['Buyer_Type'])?$CustomerInfo['Buyer_Type']:'' ?>" name="buyerType" id="buyerType">
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
                                        $action = base_url('financeAcedmic/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);
                                    }*/
                                    if(((($rolemgmt[0]['edit_permission']=='0') && (!empty($CustomerInfo['cust_bnk_id']))) || ($rolemgmt[0]['add_permission']=='0')) || ((!empty($CustomerInfo['ref_id'])) && ($rolemgmt[0]['role_name']!='admin') && ($rolemgmt[0]['role_name']!='Loan Admin')))
                                        {
                                            $stylesss  = 'display:none';
                                            $stylec = 'display:block';
                                            $action = base_url('financeAcedmic/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);

                                        }

                                    if($CustomerInfo['cancel_id']=='0'){ ?>
                                    <button type="button" class="btn-continue saveCont" style="<?=$stylesss?>"  id="personalDetails">SAVE AND CONTINUE</button>
                                     <button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                                    <?php } ?>
                                    <!--<a href="finance-and-acedmic.html" class="btn-continue">SAVE AND CONTINUE</a>-->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--</div>-->
<?php $currentdate=date('d/m/Y');
   // echo $today = date("F j, Y, g:i a T");
?>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>    
<script>
    $(document).ready(function() {

         $('#dob').datepicker({
                format: 'dd-mm-yyyy',
                startDate: '-1000y',
                endDate:'-18y',
                autoclose: true,
                todayHighlight: true   
             });
         $('#doi').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: '-1000y',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
    });
     </script>
<script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>