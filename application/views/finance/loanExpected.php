<?php 
//echo exit;

//echo "<pre>"; print_r($CustomerInfo); exit;?>
<div class="container-fluid">
    <div class="row">
     <a id="gototop"></a>
        <div class="col-md-12 pad-LR-10 mrg-B40">
            <h2 class="page-title">Case Info</h2>
            <div class="white-section">
             <form  enctype="multipart/form-data" method="post"  id="loanExForm" name="loanExForm">    
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="sub-title mrg-T0">Required Loan Details</h2>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Loan Amount*</label>
                            <input type="text" class="form-control crm-form rupee-icon" onkeypress="return isNumberKey(event)" value="<?= !empty($CustomerInfo['loan_expected'])?$CustomerInfo['loan_expected']:''?>" placeholder="Loan Amount" id="loan_amt" name="loan_amt" onkeyup="addCommas(this.value, 'loan_amt');"   autocomplete="off" maxlength="10">
                             <div class="error" id="err_loan_amt"></div>
                        </div>
                        
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">ROI* <span class="month-t">(%)</span></label>
                            <input type="text" class="form-control crm-form " value="<?= !empty($CustomerInfo['roi_expected'])?$CustomerInfo['roi_expected']:''?>" placeholder="ROI" id="roi" name="roi" autocomplete="off"  maxlength="5" onkeypress="return isRoiKey(event)"" >
                            <div class="error" id="err_roi"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Tenure* <span class="month-t">(In Month)</span></label>

                            <input type="text" class="form-control crm-form" value="<?= !empty($CustomerInfo['tenor_expected'])?$CustomerInfo['tenor_expected']:''?>" placeholder="Tenure (In months)" id="tenor" name="tenor" autocomplete="off" onkeypress="return isNumberKey(event)" maxlength="2">
                            <div class="error" id="err_tenor"></div>
                        </div>
                    </div>
                   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Bank/Financer*</label>
                            <select  class="form-control crm-form testselect1" id="financer" name="financer" >
                                <option  value="">Select Bank</option>
                                <?php
                                foreach ($bankname as $res) {
                                    ?>
                                <option value="<?= $res['id']; ?>" <?= (!empty($CustomerInfo['bank_expected']) && $CustomerInfo['bank_expected']==$res['id'])?'selected=selected':''?>>
                                        <?= $res['bank_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <!--<div class="d-arrow"></div>
                            <input type="text" onkeypress="return blockSpecialChar(event)" class="form-control crm-form" value="<?= !empty($CustomerInfo['financer'])?$CustomerInfo['financer']:''?>" placeholder="Bank/Financer" id="financer" name="financer" autocomplete="off">-->
                            <div class="error" id="err_financer"></div>
                        </div>
                    </div>
                   
                    <?php if($CustomerInfo['loan_type']=='refinance'){?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Outstanding Loan Amount</label>
                            <input type="text" class="form-control crm-form rupee-icon" onkeypress="return isNumberKey(event)" value="<?= !empty($CustomerInfo['ex_loan_expected'])?$CustomerInfo['ex_loan_expected']:''?>" placeholder="Outstanding Loan Amount" id="ex_loan_amt" name="ex_loan_amt" onkeyup="addCommas(this.value, 'ex_loan_amt');"   autocomplete="off" maxlength="10">
                             <div class="error" id="err_ex_loan_amt"></div>
                        </div>
                        
                    </div>

                     <div class="col-md-6">
                     
                                 <label for="" class="crm-label">HP To</label>

                                <select class="form-control crm-form testselect1" id="hpto" name="hpto">
                               <option value="">Select Bank</option>
                              <?php
                                foreach ($allbank as $va=> $res) {
                                    ?>
                                <option value="<?=$res['bank_id']; ?>" <?= (!empty($CustomerInfo['hpto']) && $CustomerInfo['hpto']==$res['bank_id'])?'selected=selected':''?>>
                                        <?= $res['bank_name']; ?>
                                    </option>
                                <?php } ?>
                               </select>
                               <div class="error" id="err_hpto"></div>
                              </div>
        
                    <? } ?>
                    
                     <a id="gototop1"></a>
                    <div class="col-md-12">
                        <h2 class="sub-title">Car Details</h2>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Engine Number</label>
                            <input type="text" maxlength="17" onkeypress="return blockSpecialChar(event)" class="form-control upperCaseLoan crm-form" value="<?= !empty($CustomerInfo['engine_number'])?$CustomerInfo['engine_number']:''?>" placeholder="Engine Number" id="engine_number" name="engine_number">
                            <div class="error" id="err_engine_number"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Chassis Number</label>
                            <input type="text" maxlength="17" onkeypress="return blockSpecialChar(event)" class="form-control upperCaseLoan crm-form" placeholder="Chassis Number" value="<?= !empty($CustomerInfo['chassis_number'])?$CustomerInfo['chassis_number']:''?>" id="chassis_number" name="chassis_number">
                             <div class="error"  id="err_chassis_number"></div>
                        </div>
                    </div>
                   
                   <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Make*</label>
                            <select  class="form-control crm-form" name="makeId" id="make" >
                                <option  value="">Select Make</option>
                                <?php
                                foreach ($makeList as $res) {
                                    ?>
                                <option value="<?= $res->id; ?>" <?= (!empty($CustomerInfo['makeId']) && $CustomerInfo['makeId']==$res->id)?'selected=selected':''?>>
                                        <?= $res->make; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <div class="d-arrow"></div>
                            <div class="error" id="err_make"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Model*</label>
                            <select class="form-control crm-form" id="model" name="modelId">
                                <option  value="" >Select Model</option>
                                <?php if(!empty($model)) {
                                 foreach ($model as $key =>$value) {
                                ?>
                                <option  value="<?= $value['id'];?>" <?= (!empty($CustomerInfo['modelId']) && $CustomerInfo['modelId']==$value['id'])?'selected=selected':''?>><?= $value['model']?></option>
                                  <?php  } } ?>
                            </select>
                            <div class="d-arrow"></div>
                            <div class="error" id="err_model"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Version*</label>
                            <select class="form-control crm-form" name="versionId" id="versionId">
                                <option  value="" >Select Version</option>
                            <?php if(!empty($version)) {
                                 foreach ($version as $key =>$value) {
                                ?>
                                <option  value="<?= $value['db_version_id'];?>" <?= (!empty($CustomerInfo['versionId']) && $CustomerInfo['versionId']==$value['db_version_id'])?'selected=selected':''?>><?= $value['db_version']?></option>
                                  <?php  } } ?>
                            </select>
                            <div class="d-arrow"></div>
                             <div class="error" id="err_versionId"></div>
                        </div>
                    </div>-->
                    <div class="col-md-6">
                       <div class="form-group">
                             <label for="" class="crm-label">Make Month Year</label>
                             <input type="text" id="mmyear" name="mmyear" value="<?=(!empty($CustomerInfo['mmyear']))?$CustomerInfo['mmyear']:''?>" class="form-control form-control-2 icon-cal1 to" placeholder="Select Month Year">
                         </div>
                    </div>
                    <!--<div class="col-md-6">
                           <div class="form-group">
                                 <label for="" class="crm-label">Make Month</label>
                                 <select class="form-control crm-form" id="makemonth" name="makemonth">
                                    <option value=''>Select Month</option>
                                    <?php
                                            for($m=1;count($monthlist)>= $m;$m++){
                                            ?> 
                                            <option value='<?=$m?>'<?php echo ((!empty($CustomerInfo['mm'])) && $CustomerInfo['mm']==$m) ? "selected=selected" : '';?>><?=$monthlist[$m]?></option>
                                            <?php
                                            }
                                    ?> 
                                  </select>
                                
                                 <div class="d-arrow"></div>
                                 </div>
                                  <div class="error" id="makemonth_error" ></div>
                            </div>
                            <?php $cyear=date('Y');?>
                            <div class="col-md-6">
                           <div class="form-group">
                                 <label for="" class="crm-label">Make Year</label>
                                 <select class="form-control crm-form" id="myear" name="myear">
                                    <option value=''>Select Year</option>
                                    <?php
                                            for($y=2000;$y<=$cyear;$y++){
                                            ?> 
                                            <option value='<?=$y?>'<?php echo ((!empty($CustomerInfo['myear'])) && $CustomerInfo['myear']==$y) ? "selected=selected" : '';?>><?=$y?></option>
                                            <?php
                                            }
                                    ?> 
                                  </select>
                                
                                 <div class="d-arrow"></div>
                                 </div>
                                  <div class="error" id="myear_error" ></div>
                            </div>-->
                            <input type="hidden" value="<?=$CustomerInfo['makeId'];?>" id="make" name="makeId">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Make Model *</label>
                                 <select class="form-control crm-form crm-form_read_only search_test" name="modelId" id="model">
                                     <option value="">Please Select</option>
                                     <?php if(!empty($makeList)) {
                                    foreach ($makeList as $key =>$value) {
                                   ?>
                                   <option rel="<?= $value['make_id'];?>"  value="<?= $value['model_id'];?>" <?= (!empty($CustomerInfo['modelId']) && $CustomerInfo['modelId']==$value['model_id'])?'selected=selected':''?>><?=$value['make'] .' '.$value['model']?></option>
                                     <?php  } } ?>
                                 </select>
                                 <div class="error" id="err_model" ></div>
                                 
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Version *</label>
                                 <select class="form-control crm-form crm-form_read_only search_test" name="versionId" id="versionId" <?php if(!empty($CustomerInfo['versionId'])) { echo ''; }else{ ?>readonly="readonly" <?php } ?>>
                                     <option value="">Please Select</option>
                                     <?php if(!empty($version)) {
                                    foreach ($version as $key =>$value) {?>
                                   <option  value="<?= $value['db_version_id'];?>" <?= (!empty($CustomerInfo['versionId']) && $CustomerInfo['versionId']==$value['db_version_id'])?'selected=selected':''?>><?= $value['db_version']?>(<?php echo $value['uc_fuel_type']?>-<?php echo $value['Displacement']?> cc)</option>
                                  <?php  } } ?>
                                 </select>
                                 <div class="error" id="err_versionId" ></div>
                                 
                              </div>
                           </div>
                            <!--<div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Make*</label>
                                 <select class="form-control crm-form" onchange="return getModel(this.value)" name="makeId" id="make">
                                    <option selected="selected" value="">Select Make</option>
                                    <?php if(!empty($makeList)){ ?>
                                    <?php foreach($makeList as $key => $makeArray){ ?>
                                    <option value="<?php echo $makeArray->id;?>"<?php echo ((!empty($CustomerInfo['makeId'])) && $CustomerInfo['makeId']==$makeArray->id) ? "selected=selected" : '';?>><?php echo $makeArray->make;?></option>
                                    <?php }} ?> 
                                 </select>
                                 <div class="error" id="err_make" ></div>
                                 <div class="d-arrow"></div>
                                 </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Model*</label>
                                 <select class="form-control crm-form crm-form_read_only" onchange="return getVersion(this.value)" name="modelId" id="model" <?php if(!empty($CustomerInfo['model'])) { echo ''; }else{ ?>readonly="readonly" <?php } ?>>
                                     <option value="">Please Select</option>
                                     <?php if(!empty($model)) {
                                    foreach ($model as $key =>$value) {
                                   ?>
                                   <option  value="<?= $value['id'];?>" <?= (!empty($CustomerInfo['modelId']) && $CustomerInfo['modelId']==$value['id'])?'selected=selected':''?>><?= $value['model']?></option>
                                     <?php  } } ?>
                                 </select>
                                 <div class="error" id="err_model" ></div>
                                 <div class="d-arrow"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Version*</label>
                                 <select class="form-control crm-form crm-form_read_only" name="versionId" id="versionId" <?php if(!empty($CustomerInfo['versionId'])) { echo ''; }else{ ?>readonly="readonly" <?php } ?>>
                                     <option value="">Please Select</option>
                                     <?php if(!empty($version)) {
                                 foreach ($version as $key =>$value) {?>
                                <option  value="<?= $value['db_version_id'];?>" <?= (!empty($CustomerInfo['versionId']) && $CustomerInfo['versionId']==$value['db_version_id'])?'selected=selected':''?>><?php echo $value['db_version']?>(<?php echo $value['uc_fuel_type']?>-<?php echo $value['Displacement']?> cc)</option>
                                  <?php  } } ?>
                                 </select>
                                  <div class="d-arrow"></div>
                                 <div class="error" id="err_versionId" ></div>
                                

                              </div>
                           </div>-->
                            
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Registration Date<?=($CustomerInfo['loan_for']=='1'?'':'*')?></label>
                            <!--<select  class="form-control crm-form search-box" id="reg_year" name="reg_year">
                                <option selected="selected" value="">Year</option>

                                <?php
                                for ($year = date('Y'); $year >= date('Y') - 20; $year--) {
                                    ?>
                                    <option value="<?php echo $year; ?>"<?php echo (!empty($CustomerInfo['reg_year']) && $CustomerInfo['reg_year'] == $year) ? 'selected' : ''; ?>><?php echo $year; ?></option>
                                <?php } ?>
                            </select>-->
                             <div class="input-group date" id="dp">
                              <input type="text" class="form-control crm-form crm-form_1" placeholder="Registration Date" id="reg_year" name="reg_year" value="<?php echo (!empty($CustomerInfo['reg_year']) && ($CustomerInfo['reg_year'] != '0000-00-00')) ? date('d-m-Y',strtotime($CustomerInfo['reg_year'])) : ''?>">
                                  <span class="input-group-addon">
                                     <span class="">
                                       <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                  </span>
                                  </div>
                            <div class="error" id="err_reg_year"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">Registration No <?=($CustomerInfo['loan_for']=='1'?'':'*')?></label>
                            <input type="text" onkeypress="return blockSpecialChar(event)" class="form-control upperCaseLoan crm-form" value="<?= !empty($CustomerInfo['regno'])?$CustomerInfo['regno']:''?>" placeholder="AP 19 AK 2804" onkeyup="return selectRto(this)" id="regno" name="regno">
                            <div class="error" id="err_regno"></div>
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">RTO <?=($CustomerInfo['loan_for']=='1'?'':'*')?></label>
                            <select class="form-control crm-form rto" onchange="test(this);" id="rto" name="rto" readonly="readonly">
                            <option value="">Please Select RTO</option>
                                <?php foreach ($rto as $key=>$value){ ?>
                                <option value="<?=$value['id']?>"  <?php echo !empty($CustomerInfo) && $CustomerInfo['rto_id']==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['Registration_Index'].' '.$value['Place_of_Registration']?></option>
                            <?php } ?>
                            </select>
                            <!--<input type="text" onkeypress="return blockSpecialChar(event)" class="form-control upperCaseLoan crm-form" value="<?= !empty($CustomerInfo['regno'])?$CustomerInfo['regno']:''?>" placeholder="HR29" id="rto" name="rto">-->
                            <div class="error" id="err_rto"></div>
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="crm-label">RTO State <?=($CustomerInfo['loan_for']=='1'?'':'*')?></label>
                            <input type="text" class="form-control upperCaseLoan crm-form" value="<?= !empty($CustomerInfo['rto_state'])?$CustomerInfo['rto_state']:''?>" placeholder="RTO State" id="rto_state" name="rto_state" disabled="disabled">
                            <div class="error" id="err_rtostate"></div>
                        </div>
                    </div>
<?php if($CustomerInfo['loan_for']=='2'){?>
                    <div class="col-sm-6" style="height: 84px"> 
                            <div class="mrg-T25">
                              <span class="mrg-R20"> 
                                  <a class="btn btn-default" onclick="copyRegNo()" data-clipboard-target="#reg" href="javascript:void(0)">Check RC Status</a>
                              </span> 

                              <span class="mrg-R20" id="errhypodiv"> 
                                  <a class="btn btn-default" onclick="challanStatus()" data-clipboard-target="#reg" href="javascript:void(0)">Check E-Challan</a>
                              </span>
                              
                          </div>
                   </div>
                   <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Challan Exists</label>
                           <span class="radio-btn-sec">
                                <input type="radio" name="challanexist" id="yesex" value="1" class="trigger case_ty" <?= !empty($CustomerInfo)  && $CustomerInfo['challanexist']=='1'?'checked=checked':'checked=checked'?>>
                                <label for="yesex"><span class="dt-yes"></span> Yes</label>
                            </span>
                             <span class="radio-btn-sec">
                                <input type="radio" name="challanexist" id="noex" value="2" class="trigger case_ty" <?= !empty($CustomerInfo) && $CustomerInfo['challanexist']=='2'?'checked=checked':''?>>
                                <label for="noex"><span class="dt-yes"></span> No</label>
                            </span>
                            <div class="error" id="err_challan"></div>
                        </div>
                    </div>
                    <?php } ?>
                    <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="crm-label">Showroom </label>
                                        <select class="form-control crm-form testselect1 search-box sroom search_test"  onchange="return getDealerDetails();" id="showroomName" name="showroomName">
                                        <option value="">Please Select</option>
                                            <?php foreach ($showroomList as $key=>$value){ ?>
                                            <option value="<?=$value['id']?>"  <?php echo !empty($CustomerInfo) && $CustomerInfo['showroomName']==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['organization']?></option>
                                        <?php } ?>
                                        </select>
                                       
                                          <div class="error" id="err_showroomName"></div>
                                    </div>
                                </div>
                           <div class="col-md-6" style="height:85px;">
                              <div class="form-group">
                                 <label for="" class="crm-label">Address </label>
                                  <input type="text" class="form-control crm-form form-read" placeholder="Address" name="showroom_address" readonly="readonly" id="showroom_address" value="<?php echo (!empty($CustomerInfo['showroomAddress'])) ? ucwords($CustomerInfo['showroomAddress']) :'';?>">
                                   <div class="error" id="err_showroom_address"></div>
                              </div>
                           </div>
-->
                   
                     <input type="hidden" value="<?= !empty($CustomerInfo['customer_id'])?$CustomerInfo['customer_id']:'' ?>" name="customerId">
                      <input type="hidden" value="<?= !empty($CustomerInfo['customer_loan_id'])?$CustomerInfo['customer_loan_id']:'' ?>" name="caseId" id="case_id">
                       <input type="hidden" value="<?= !empty($CustomerInfo['loan_for'])?$CustomerInfo['loan_for']:'' ?>" name="loanFor" id="loanFor">
                    <input type="hidden" name="loanExpectedForm" value="1">
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
                            $action = base_url('residentialInfo/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);
                        }*/
                        if(((($rolemgmt[0]['edit_permission']=='0') && (!empty($CustomerInfo['cust_bnk_id']))) || ($rolemgmt[0]['add_permission']=='0')) || ((!empty($CustomerInfo['ref_id'])) && ($rolemgmt[0]['role_name']!='admin') && ($rolemgmt[0]['role_name']!='Loan Admin')))
                        {
                            $stylesss  = 'display:none';
                            $stylec = 'display:block';
                             $action = base_url('residentialInfo/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);

                        }

                        if($CustomerInfo['cancel_id']=='0'){ ?>
                            <button type="button" class="btn-continue saveCont" style="<?=$stylesss?>"  id="loanExpectedButton">SAVE AND CONTINUE</button>
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
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>

<script>
  $(document).ready(function() {

       $('#reg_year').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: 'd',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
    });
  $('.testselect1,.search_test').SumoSelect({csvDispCount: 3, search: true, searchText:'Enter here.',triggerChangeCombined: true});

    function test(sel)
    {
      var rto = sel.value;
      if(rto>0){
      $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "Finance/getRtoState/",
            data:{rto:rto},
            dataType: "json",
            success: function(response) 
            {
                $('#rto_state').val(response.rto_state);
            }
            });
        }
        else
        {
            $('#rto_state').val('');
        }
    }
    function selectRto(v)
    {
        var regg = v.value.replace(/ /g, '');
        if(regg.length<=4)
        {
           var regno = regg;
        }
        else
        {
             var regno = regg.substring(0, 4);
        }
        $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "Finance/getRtoState/",
            data:{regno:regno},
            dataType: "html",
            success: function(response) 
            {
                //$('#rto_state').val(response.rto_state);
                //$('[name=rto]').val(response.rto);
                $('#rto').html(response);
                $('#rto').trigger('change');
            }
            });
    }
     $('#engine_number').keyup(function() {
        var mob = $('#engine_number').val();
       // alert(mob);
            //alert("<?php echo base_url(); ?>" + "Finance/getCustomerDetails/");
            if(mob.length==17)
        {
            $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "Finance/prefillcar/",
            data:{engno:mob},
            dataType: "json",
            success: function(response) 
            {
                //alert(response[0].chassis_no);
                if(response)
                {
                   // alert('hi');
                    
                    $('#makemonth').val(response[0].mm);
                    $('#myear').val(response[0].myear);
                    $('#make').val(response[0].make_id);
                    getModel(response[0].make_id,response[0].model_id);

                    setTimeout(function(){ getVersion(response[0].model_id,response[0].version_id); }, 300);
                     $('#chassis_number').val(response[0].chassis_no);
                     $('#regno').val(response[0].reg_no);
                     $('#regno').keyup();
                     //setTimeout(function(){ selectRto(response[0].reg_no);}, 300);
                }
                else
                {
                   // alert('ffff');
                    $('#chassis_number').val('');
                    $('#makemonth').val('');
                    $('#myear').val('');
                    $('#make').val('');
                    $('#model').val('');
                    $('#versionId').val('');

                }
            }   
            });
        }
        
    });
      $('#chassis_number').keyup(function() {
        var mob = $('#chassis_number').val();
        if(mob.length==17)
        {
            $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "Finance/prefillcar/",
            data:{chasno:mob},
            dataType: "json",
            success: function(response) 
            {
                if(response)
                {
                   // alert('hi');
                    $('#engine_number').val(response[0].engine_number);
                    $('#makemonth').val(response[0].mm);
                    $('#regno').val(response[0].reg_no);
                    $('#myear').val(response[0].myear);
                    $('#make').val(response[0].make_id);
                    //getModel(response[0].make_id,response[0].model_id);
                    getModel(response[0].make_id,response[0].model_id);
                    setTimeout(function(){ getVersion(response[0].model_id,response[0].version_id); }, 30);
                    selectRto(response[0].reg_no);
                }
                else
                {
                   // alert('ffff');
                    $('#engine_number').val('');
                    $('#makemonth').val('');
                    $('#myear').val('');
                    $('#make').val('');
                    $('#model').val('');
                    $('#versionId').val('');

                }
            }   
            });
        }
    });
    $('#myear').on('change', function () {
    var selected = $(this).val();
    $.ajax({
        type: 'POST',
        url: base_url+"Finance/getMakeModelNameByYear",
        data: {type:'make',year: selected},
        dataType: "html",
        success: function (responseData)
        {
           // $('#make').html(responseData);
            $('#model').prop('disabled', false);
            $('#model').val('');
            $('#versionId').val('');
            $('#model')[0].sumo.reload();
            $('#versionId')[0].sumo.reload();

        }
    });
    });
    
    $('#model').on('change', function () {
      var selected = $(this).val();
      var year = $('#myear').val();
      var make     = $("option:selected", this).attr("rel");
      //alert(make);
      $('#make').val(make);
      $.ajax({
          type: 'POST',
          url: "<?php echo base_url(); ?>" +"finance/getVersion",
          data: {model: selected,make:make,flag:'1',year:year},
          dataType: "html",
          success: function (responseData)
          {
              $('#versionId').html(responseData);
              $('#versionId')[0].sumo.reload();
          }
      });
    });

   /* function getModel(make_id,model_id)
    {
        var selected = make_id;
        var myear=$('#myear').val();
        $.ajax({
            type: 'POST',
            url: base_url+"Insurance/getmakemodelversionlist",
            data: {type:'model',make:selected,year: myear},
            dataType: "html",
            success: function (responseData)
            {
                $('#model').html(responseData);
                if(model_id>='1')
                {
                    $('#model').val(model_id);
                }
                $('#model').prop('disabled', false);
                $('#model').removeAttr('readonly');

                $('#versionId').html('<option value="">Select Version</option>');

            }
        });
    }

    function getVersion(model_id,version_id)
    {
        var model_id = $('#model').val();
        if(version_id>='1')
                {
                  var model_id = model_id;
                }
               // alert(model_id);
        var make=$('#make').val();
        var myear=$('#myear').val();
        $.ajax({
            type: 'POST',
            url: base_url+"Insurance/getmakemodelversionlist",
            data: {type:'version',make:make,model_id: model_id,year: myear},
            dataType: "html",
            success: function (responseData)
            {
                $('#versionId').html(responseData);
                $('#versionId').prop('disabled', false);
                 $('#versionId').removeAttr('readonly');

                if(version_id>='1')
                {
                  $('#versionId').val(version_id);
                }
            }
        });
    }*/
/*$('#make').on('change', function () {
   // alert('ddd');
    var selected = $(this).val();
    var myear=$('#myear').val();
    $.ajax({
        type: 'POST',
        url: base_url+"Insurance/getmakemodelversionlist",
        data: {type:'model',make:selected,year: myear},
        //async:false,
        dataType: "html",
        success: function (responseData)
        {
            $('#model').html(responseData);
            $('#model').prop('disabled', false);
            $('#versionId').html('<option value="">Select Version</option>');

        }
    });
    });
$('#model').on('change', function () {
    var model_id = $('#model').val();
    var make=$('#make').val();
    var myear=$('#myear').val();
    $.ajax({
        type: 'POST',
        url: base_url+"Insurance/getmakemodelversionlist",
        data: {type:'version',make:make,model_id: model_id,year: myear},
        dataType: "html",
        success: function (responseData)
        {
            $('#versionId').html(responseData);
            $('#versionId').prop('disabled', false);

        }
    });
    });  */  
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

  function copyRegNo(){
        
       setTimeout(function(){
        window.open("https://vahan.nic.in/nrservices/faces/user/searchstatus.xhtml", "_blank");
    },100);
    }
    
    function challanStatus(){
       setTimeout(function(){
        window.open(" https://echallan.parivahan.gov.in/index/accused-challan", "_blank");
    },100);
    }
</script>
