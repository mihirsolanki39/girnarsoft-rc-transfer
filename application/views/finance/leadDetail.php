<?php  //echo '<pre>';print_r($CustomerInfo['id']);die;?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 pad-LR-10 mrg-B40">
            <h2 class="page-title">Lead Details</h2>
            <div class="white-section">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="sub-title first-title">Buyer Information</h2>
                    </div>
                    <form  enctype="multipart/form-data" method="post"  id="leadDetails" name="leadDetails">
                    <div class="loan_read_only">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Buyer Type*</label>
                           <span class="radio-btn-sec">
                                <input type="radio" name="buyer_type" id="individual" value="2" class="trigger btype" <?= !empty($CustomerInfo)  && $CustomerInfo['Buyer_Type']=='2'?'checked=checked':'checked=checked'?>>
                                <label for="individual"><span class="dt-yes"></span> Individual</label>
                            </span>
                             <span class="radio-btn-sec">
                                <input type="radio" name="buyer_type" id="company" value="1" class="trigger btype" <?= !empty($CustomerInfo) && $CustomerInfo['Buyer_Type']=='1'?'checked=checked':''?>>
                                <label for="company"><span class="dt-yes"></span> Company</label>
                            </span>
                            <div class="error" id="err_buyer_type"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Loan For*</label>
                            <span class="radio-btn-sec">
                                <input type="radio" name="loan_for" id="new" value="1" class="trigger loanfor" <?= !empty($CustomerInfo) && $CustomerInfo['loan_for']=='1'?'checked=checked':'checked=checked'?>>
                                <label for="new"><span class="dt-yes"></span> New Car</label>
                            </span>
                            <span class="radio-btn-sec">
                                <input type="radio" name="loan_for" id="used" value="2" class="trigger loanfor" <?= !empty($CustomerInfo) && $CustomerInfo['loan_for']=='2'?'checked=checked':''?>>
                                <label for="used"><span class="dt-yes"></span> Used Car</label>
                            </span>
                             <div class="error" id="err_loan_for"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Loan Type*</label>
                            <span class="radio-btn-sec ">
                                <input type="radio" id="purchase" name="loan_type" class="loan_type" value="Purchase" class="trigger" <?= !empty($CustomerInfo) && $CustomerInfo['loan_type']=='Purchase'?'checked=checked':'checked=checked'?>>
                                <label for="purchase"><span class="dt-yes"></span> Purchase</label>
                            </span>
                            <span class="radio-btn-sec loanpur">
                                <input type="radio" id="refinance" name="loan_type" class="loan_type" value="refinance" class="trigger" <?= !empty($CustomerInfo) && $CustomerInfo['loan_type']=='refinance'?'checked=checked':''?>>
                                <label for="refinance"><span class="dt-yes"></span> Refinance</label>
                            </span>
                            <span class="radio-btn-sec loantop">
                                <input type="radio" id="topup" name="loan_type" class="loan_type" value="topup" class="trigger" <?= !empty($CustomerInfo) && $CustomerInfo['loan_type']=='topup'?'checked=checked':''?>>
                                <label for="topup"><span class="dt-yes"></span>Internal Top Up</label>
                            </span>
                            
                             <div class="error" id="err_loan_type"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Loan Offer</label>
                           <span class="radio-btn-sec">
                                <input type="radio" name="case_ty" id="normal" value="1" class="trigger case_ty" <?= !empty($CustomerInfo)  && $CustomerInfo['case_field']=='1'?'checked=checked':'checked=checked'?>>
                                <label for="normal"><span class="dt-yes"></span> Normal</label>
                            </span>
                             <span class="radio-btn-sec">
                                <input type="radio" name="case_ty" id="lop" value="2" class="trigger case_ty" <?= !empty($CustomerInfo) && $CustomerInfo['case_field']=='2'?'checked=checked':''?>>
                                <label for="lop"><span class="dt-yes"></span> LOP</label>
                            </span>
                            <span class="radio-btn-sec">
                                <input type="radio" name="case_ty" id="nip" value="3" class="trigger case_ty" <?= !empty($CustomerInfo) && $CustomerInfo['case_field']=='3'?'checked=checked':''?>>
                                <label for="nip"><span class="dt-yes"></span> NIP</label>
                            </span>
                            <div class="error" id="err_case_ty"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Guaranter Case</label>
                            <span class="radio-btn-sec">
                                <input type="radio" name="guaranter_case" id="gyes" value="1" class="trigger" <?= !empty($CustomerInfo) && $CustomerInfo['guaranter_case']=='1'?'checked=checked':'checked=checked'?>>
                                <label for="gyes"><span class="dt-yes"></span> Yes</label>
                            </span>
                            <span class="radio-btn-sec">
                                <input type="radio" name="guaranter_case" id="gno" value="0" class="trigger" <?= !empty($CustomerInfo) && $CustomerInfo['guaranter_case']=='0'?'checked=checked':''?>>
                                <label for="gno"><span class="dt-yes"></span> No</label>
                            </span>
                             <div class="error" id="err_guaranter_case"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Co-applicant</label>
                            <span class="radio-btn-sec">
                                <input type="radio" name="co_app" id="cyes" value="1" class="trigger " <?= !empty($CustomerInfo) && $CustomerInfo['co_applicant']=='0'?'checked=checked':'checked=checked'?>>
                                <label for="cyes"><span class="dt-yes"></span> Yes</label>
                            </span>
                            <span class="radio-btn-sec">
                                <input type="radio" name="co_app" id="cno" value="0" class="trigger " <?= !empty($CustomerInfo) && $CustomerInfo['co_applicant']=='0'?'checked=checked':''?>>
                                <label for="cno"><span class="dt-yes"></span> No</label>
                            </span>
                             <div class="error" id="err_co_app"></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <h2 class="sub-title">Contact Information</h2>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Mobile*</label>
                            <input type="text" onkeypress="return isNumberKey(event)" class="form-control crm-form" id="Cmobile" name="mobile" maxlength="10" placeholder="Mobile" value="<?= !empty($customerMobileNumber['mobile'])?$customerMobileNumber['mobile']:'' ?>">
                             <div class="error" id="err_mobile"></div>
                        </div>
                       
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Additional Mobile</label>
                            <input type="text" onkeypress="return isNumberKey(event)" class="form-control crm-form" id="Camobile" name="Camobile" maxlength="10" placeholder="Additional Mobile" value="<?= !empty($CustomerInfo['addmobile'])?$CustomerInfo['addmobile']:'' ?>">
                             <div class="error" id="err_camobile"></div>
                        </div>
                       
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label" id="nameChange">Full Name*</label>
                            <input type="text" class="form-control crm-form" id="Cname" name="Cname" onkeypress="return blockSpecialChar(event)" placeholder="Full Name" value="<?= !empty($CustomerInfo['name'])?$CustomerInfo['name']:''?>" >
                            <div class="error" id="err_name"></div>
                        </div>
                        
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Email*</label>
                            <input type="text" class="form-control crm-form" id="CEmail" name="Cemail" placeholder="Email" value="<?= !empty($CustomerInfo['email'])?$CustomerInfo['email']:''?>">
                            <div class="error" id="err_email"></div>
                        </div>
                       
                    </div>
                    <div class="col-md-12">
                        <h2 class="sub-title">Source*</h2>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Source of loan?</label>
                            <select class="form-control crm-form testselect1 lead_source" id="" name="lead_source">
                                <option value="">Select Source</option>
                                <option value="1" <?= !empty($CustomerInfo) && $CustomerInfo['source_type']=='1'?'selected=selected':''?>>Dealer</option>
                                <option value="2" <?= !empty($CustomerInfo) && $CustomerInfo['source_type']=='2'?'selected=selected':''?>>Inhouse</option>
                            </select>
                           
                            <div class="error" id="err_lead_source"></div>
                        </div>
                        
                    </div>
                    <div class="col-md-6 showDealerBox" style="display:none">
                        <div class="form-group">
                            <label class="crm-label">Dealership Name*</label>
                            <select class="form-control testselect1 crm-form lead_source leaddealer"  id="dealerName" onchange="return salesExecutive(this)" name="dealerName">
                            <option value="">Please Select Dealership</option>
                                <?php foreach ($dealerList as $key=>$value){ ?>
                                <option value="<?=$value['id']?>"  <?php echo !empty($CustomerInfo) && $CustomerInfo['dealer_id']==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['organization']?></option>
                            <?php } ?>
                            </select>
                              <div class="error" id="err_dealerName"></div>
                            <!--<div class="d-arrow"></div>-->
                        </div>
                        
                    </div>
                        <!--<div class="col-md-6 showDealerBox" style="display:none">
                        <div class="form-group">
                            <label class="crm-label">Rc transfer to be done by*</label>
                            <select class="form-control crm-form" id="RctransferdoneBy" name="RctransferdoneBy">
                                <option value="">Please Select </option>
                                <option value="1" <?php echo !empty($CustomerInfo) && $CustomerInfo['rc_transfer_by']=='1'? 'selected=selected' : ''; ?>>Dealer</option>
                                <option value="2" <?php echo !empty($CustomerInfo) && $CustomerInfo['rc_transfer_by']=='2'? 'selected=selected' : ''; ?>>Inhouse</option>
                            </select>
                            //<input type="text" id="RctransferdoneBy" name="RctransferdoneBy" class="form-control crm-form" placeholder="Dealer Name" value="shashiSingh">
                            <div class="d-arrow"></div>
                             <div class="error" id="err_RctransferdoneBy"></div>
                        </div>
                        
                    </div>    -->
                        
                        
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Sales Executive</label>
                            <select class="form-control testselect1 crm-form meet_the_customer aaaa " id="meet_the_customer" name="meet_the_customer">
                                <option value="0">Please Select</option>
                                <option value="1" <?php echo !empty($CustomerInfo) && $CustomerInfo['meet_the_customer']=='1' ? 'selected=selected' : ''; ?>>Self</option>
                                <?php 
                                 foreach ($employeeList as $key=>$value){ ?>
                                <option value="<?=$value['id']?>" <?php echo !empty($CustomerInfo) && $CustomerInfo['meet_the_customer']==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['name']?></option>
                                <?php  
                                }  ?>
                            </select>
                              <select class="form-control crm-form meet_the_customer bbbb" id="meet_the_customer" style="display: none;">
                                <option value="0">Please Select</option>
                                <option value="1" <?php echo !empty($CustomerInfo) && $CustomerInfo['meet_the_customer']=='1' ? 'selected=selected' : ''; ?>>Self</option>
                            </select>
                            <div class="error" id="err_meet_the_customer"></div>
                            <!--<div class="d-arrow"></div>-->
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="height:85px">
                            <label class="crm-label">Where was customer met?</label>
                            <input type="text" id="meeting_customer_place" onkeypress="return blockSpecialChar(event)" name="meeting_customer_place"  class="form-control crm-form" placeholder="Meeting Customer Place" value="<?= !empty($CustomerInfo['meeting_customer_place'])?$CustomerInfo['meeting_customer_place']:'' ?>" >
                           
                            <!--<div class="d-arrow"></div>-->
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Document Verified by?</label>
                            <select class="form-control testselect1 crm-form search-box" name="seen_customer_doc" id="seen_customer_doc" onkeypress="return blockSpecialChar(event)">
                                <option value="">Please Select</option>
                                <?php foreach ($employeeListByTeam as $key=>$value){ ?>
                                <option value="<?=$value['id']?>" <?php echo !empty($CustomerInfo) && $CustomerInfo['seen_customer_doc']==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['name']?></option>
                                <?php } ?>
                            </select>
                             
                             <div class="error" id="err_seen_customer_doc"></div>
                       
                        </div>
                        
                    </div>
                    <!--<div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Is case discussed with Relationship Manager?</label>
                            <span class="radio-btn-sec">
                                <input type="radio" name="case_discussed" id="ckd1" value="yes"  class="trigger" <?= !empty($CustomerInfo) && $CustomerInfo['discussed_manager']=='yes'?'checked=checked':''?>>
                                <label for="ckd1"><span class="dt-yes"></span> Yes</label>
                            </span>
                            <span class="radio-btn-sec">
                                <input type="radio" name="case_discussed" id="ckd2" value="no" class="trigger" <?= !empty($CustomerInfo) && $CustomerInfo['discussed_manager']=='no'?'checked=checked':''?>>
                                <label for="ckd2"><span class="dt-yes"></span> No</label>
                            </span>
                             <div class="error" id="err_case_discussed"></div>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Reason for Recommendation</label>
                            <input type="text" id="reasonRecommendation" name="reasonRecommendation" class="form-control crm-form" onkeypress="return blockSpecialChar(event)" placeholder="Reason for Recommendation" value="<?= !empty($CustomerInfo['reason_recommendation'])?$CustomerInfo['reason_recommendation']:'' ?>">
                            <div class="d-arrow"></div>-->
                        <!--</div>
                        
                    </div>-->
                    <div class="col-md-12">
                        <h2 class="sub-title">Status</h2>
                    </div>
                   <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Lead Status</label>
                            <select class="form-control crm-form lead_status" id="lead_status" name="lead_status">
                                <option value="" >Please Select</option>
                                <option value="1" <?= !empty($CustomerInfo) && $CustomerInfo['lead_status']=='1'?'selected=selected':''?>>Open</option>
                                <option value="2" <?= !empty($CustomerInfo) && $CustomerInfo['lead_status']=='2'?'selected=selected':''?>>Documents Collected</option>
                                <option value="3" <?= !empty($CustomerInfo) && $CustomerInfo['lead_status']=='3'?'selected=selected':''?>>File Login</option>
                            </select>
                            <div class="d-arrow"></div>
                        </div>
                    </div>-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Dealt By</label>
                            <select class="form-control testselect1 crm-form search-box" id="dealt_by" name="dealt_by">
                                <option value="">Please Select</option>
                                <?php foreach ($employeeListByTeam as $key=>$value){ ?>
                                <option value="<?=$value['id']?>" <?php echo !empty($CustomerInfo) && $CustomerInfo['dealt_by']==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['name']?></option>
                                <?php } ?>
                            </select>
                           <!-- <div class="d-arrow"></div>-->
                             <div class="error" id="err_dealt_by"></div>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Assign Case to</label>
                            <select class="form-control testselect1 crm-form" id="assign_case_to" name="assign_case_to">
                                 <option value="">Please Select</option>

                                <?php foreach ($employeeListByTeam as $keys=>$values){ ?>
                                <option value="<?=$values['id']?>" <?php echo !empty($CustomerInfo) && $CustomerInfo['assign_case_to']==$values['id'] ? 'selected=selected' : ''; ?>><?=$values['name']?></option>


                                <?php } ?>
                            </select>
                            <div class="d-arrow"></div>
                            <div class="error" id="err_assign_case_to"></div>
                        </div>
                        
                    </div>
                    </div>
                        <input type="hidden" name="leadForm" value="1" id="leadForm">
                        <input type="hidden" name="precustomer" value="" id="precustomer">
                        <input type="hidden" name="caseId" value="<?= !empty($CustomerInfo['customer_loan_id'])?$CustomerInfo['customer_loan_id']:'' ?>" id="caseId">
                        <input type="hidden" name="actionType" value="<?=(!empty($add)?$add:'')?>" id="leadForm">
                    <div class="col-md-12">
                        <div class="btn-sec-width">
                        <?php 
                        $stylesss = 'display:block';
                        $stylec = 'display:none';
                        $action = '';
                       /* if(!empty($CustomerInfo['tag_flag']) && ($CustomerInfo['tag_flag']=='4'))
                        {
                            $stylesss  = 'display:none';
                            $stylec = 'display:block';
                            $action = base_url('uploadDocs/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);
                        }*/
                        if(((($rolemgmt[0]['edit_permission']=='0') && (!empty($CustomerInfo['cust_bnk_id']))) || ($rolemgmt[0]['add_permission']=='0')) || ((!empty($CustomerInfo['ref_id'])) && ($rolemgmt[0]['role_name']!='admin') && ($rolemgmt[0]['role_name']!='Loan Admin')))
                        {
                            $cid = (!empty($CustomerInfo["customer_loan_id"])?$CustomerInfo["customer_loan_id"]:'');
                            $stylesss  = 'display:none';
                            $stylec = 'display:block';
                            $action = base_url('personalDetail/').base64_encode('CustomerId_'.$cid);

                        }
                        if(empty($CustomerInfo['cancel_id']) || (!empty($CustomerInfo['cancel_id']) && $CustomerInfo['cancel_id']=='0')){ ?>
                            <a href="#err_loan_type" class="btn-continue saveCont" style="<?=$stylesss?>" id="leadDetailsButton">SAVE AND CONTINUE</a>
                            <button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                        <?php } ?>
                            <!--<a href="" class="btn-continue">SAVE AND CONTINUE</a>-->
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script>
  $('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
  </script>
<script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>
<script>
$('.bbbb').change(function () {
 var th = $(this).val();
 $('#meet_the_customer').val(th);
 //alert(th);
});

    $('#Cmobile').keyup(function() {
        var mob = $('#Cmobile').val();
        if(mob.length==10)
        {
            //alert("<?php echo base_url(); ?>" + "Finance/getCustomerDetails/");
            $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "Finance/getCustomerDetails/",
            data:{mobile:mob},
            dataType: "json",
            success: function(response) 
            {
                if(response!='')
                {
                    $('#Cname').val(response.customer_name);
                    $('#CEmail').val(response.customer_email);
                    $('#precustomer').val('1');
                }
                else
                {
                    $('#Cname').val('');
                    $('#CEmail').val('');
                }
            }   
            });
        }
    });
    $('.btype').click(function()
    {
        var selValue = $('input[name=buyer_type]:checked').val();
        if(selValue == 1)
        {
            $('#nameChange').text('Company Name *');
            $('#Cname').attr('onkeypress','return blockSpecialChar(event)');
        }
        else if(selValue == 2)
        {
            $('#nameChange').text('Full Name *');
            $('#Cname').attr('onkeypress','return nameOnly(event)');
        }
    });
    var selValue = $('input[name=buyer_type]:checked').val(); 
    if(selValue == 1)
        {
            $('#nameChange').text('Company Name *');
            $('#Cname').attr('onkeypress','return blockSpecialChar(event)');
        }
        else if(selValue == 2)
        {
            $('#nameChange').text('Full Name *');
            $('#Cname').attr('onkeypress','return nameOnly(event)');
        }
    $('.loanfor').click(function()
    {
        var loanshow = $('input[name=loan_for]:checked').val();
        getAssignedToList(loanshow);
        if(loanshow == 1)
        {
            $('.loantop , .loanpur').attr('style','display:none;');
        }
        else if(loanshow == 2)
        {
           $('.loantop , .loanpur').attr('style','');
        }
    });
    var loanshow = $('input[name=loan_for]:checked').val(); 
    if(loanshow == 1)
        {
            var assign_case_to = "<?php echo !empty($CustomerInfo)?$CustomerInfo['assign_case_to']:'' ?>";
           
            getAssignedToList(loanshow,assign_case_to);
            $('#assign_case_to').val(assign_case_to);
            $('#assign_case_to')[0].sumo.reload();;
           $('.loantop , .loanpur').attr('style','display:none;');
        }
        else if(loanshow == 2)
        {
             var assign_case_to = "<?php echo !empty($CustomerInfo)?$CustomerInfo['assign_case_to']:'' ?>";
            getAssignedToList(loanshow,assign_case_to);
            $('#assign_case_to').val(assign_case_to);
            $('#assign_case_to')[0].sumo.reload();;
            //getAssignedToList(loanshow);
             $('.loantop , .loanpur').attr('style','');
        }

function getAssignedToList(loanshow,assignedto='')
{
    $.ajax({
    
        type : 'POST',
        url : "<?php echo base_url(); ?>" + "Finance/getAssignedToList/",
        data : {loanshow:loanshow,assignedto:assignedto},
        dataType: 'html',
        success: function (img) { 
            $('#assign_case_to').html(img);
             $('#assign_case_to')[0].sumo.reload();;
        }
    });
}
function salesExecutive(ths)
{
   // alert('hiii');
    $('#meet_the_customer').val('');
    $('#meet_the_customer')[0].sumo.reload();;
  var saleid = $(ths).val();
  if(saleid>='1'){
    $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "DeliveryOrder/getSalesList/",
            data:{saleid:saleid},
            dataType: "json",
            success: function(response) 
            {
              //  alert('fdfff');
                $('#meet_the_customer').val('');
                $('#meet_the_customer')[0].sumo.reload();;
              if(response>=1){
                $('#meet_the_customer').val(response);}
                $('#meet_the_customer')[0].sumo.reload();;
            }
            });
  }
}
</script>
