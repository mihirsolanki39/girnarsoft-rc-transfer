<?php
$is_admin=$this->session->userdata['userinfo']['is_admin'];
$addPerm=isset($permission[0]['add_permission']) ? $permission[0]['add_permission'] :'' ;
$editPerm=isset($permission[0]['edit_permission']) ? $permission[0]['edit_permission']:'';
$viewPerm=isset($permission[0]['view_permission']) ? $permission[0]['view_permission'] : '';
$role_name=isset($permission[0]['role_name']) ? $permission[0]['role_name'] : '';
$mode=(!empty($CustomerInfo['engineNo'])) ? 'edit' : 'add';
$stylec = 'display:block';
$action = ($mode=='edit')? base_url('insFileLogin/').base64_encode('CustomerId_'.$CustomerInfo["customer_id"]) :'';
?>
<div class="container-fluid">
               <div class="row">
                   <form name="vehicleform" id="vehicleform" method="post" action="">
                    <h2 class="page-title mrg-L10">Vehicle Details</h2>
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <div class="white-section">
                        <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0">Vehicle Details</h2>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Engine No.</label>
                                 <input type="text" maxlength="17" name="engine_no" id="engine_no" onkeyup="return getUpper(this.value,'engine_no');" onkeypress="return blockSpecialChar(event);" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['engineNo'])) ? $CustomerInfo['engineNo'] : '';?>" placeholder="Engine No">
                                 <div class="error" id="engine_no_error" ></div>
                              </div>
                           </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                 <label for="" class="crm-label">Chassis No.</label>
                                 <input type="text" maxlength="17" name="chassis_no"  id="chassis_no" onkeyup="return getUpper(this.value,'chassis_no');" onkeypress="return blockSpecialChar(event);" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['chasisNo'])) ? $CustomerInfo['chasisNo'] : '';?>" placeholder="Chassis No">
                                 <div class="error" id="chassis_no_error" ></div>
                            </div>
                            </div>
                            <?php if(!empty($CustomerInfo['ins_category']) && ($CustomerInfo['ins_category']=='2' || $CustomerInfo['ins_category']=='3' || $CustomerInfo['ins_category']=='4')){?>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Registration No*</label>
                                 <input type="text" name="regNo" maxlength="11" id="regNo" onkeypress="return blockSpecialChar(event);" onkeyup="return getUpper(this.value,'regNo');" class="form-control crm-form" value="<?php echo (!empty($CustomerInfo['regNo'])) ? $CustomerInfo['regNo'] : '';?>" placeholder="Registration No">
                                 <div class="error" id="regNo_error" ></div>
                              </div>
                            </div>
                            <?php }elseif(!empty($CustomerInfo['ins_category']) && ($CustomerInfo['ins_category']=='1')){ ?>
                             <!--<div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">City*</label>
                                 <select class="form-control crm-form" name="car_city" id="car_city">
                                    <option selected="selected" value="">Select City</option>
                                    <?php //if(!empty($citylist)){?>
                                    <?php //foreach($citylist as $city){?>
                                    <option value="<?php echo $city['city_id'];?>"<?php echo (!empty($CustomerInfo['car_city']) && $CustomerInfo['car_city']==$city['city_id']) ? "selected=selected" : '';?>><?php echo $city['city_name'];?></option>
                                    <?php //}} ?>
                                 </select>
                                 <div class="error" id="car_city_error" ></div>
                                 <div class="d-arrow"></div>
                              </div>
                           </div>-->
                            <?php } ?>
                           <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">City*</label>
                                <select class="form-control crm-form search-box" name="car_city" id="car_city" onkeypress="return blockSpecialChar(event)">
                                    <option value="">Please Select</option>
                                    <?php foreach($citylist as $city){?>
                                    <option value="<?php echo $city['city_id'];?>"<?php echo (!empty($CustomerInfo['car_city']) && $CustomerInfo['car_city']==$city['city_id']) ? "selected=selected" : '';?>><?php echo $city['city_name'];?></option>
                                    <?php } ?>
                                </select>
                                <div class="error" id="car_city_error"></div>

                            </div>
                        </div> 
                            <div class="col-md-6">
                           <div class="form-group">
                                 <label for="" class="crm-label">Make Month*</label>
                                 <select class="form-control crm-form" id="makemonth" name="makemonth">
                                    <option value=''>Select Month</option>
                                    <?php
                                            for($m=1;count($monthlist)>= $m;$m++){
                                            ?> 
                                            <option value='<?=$m?>'<?php echo ((!empty($CustomerInfo['make_month'])) && $CustomerInfo['make_month']==$m) ? "selected=selected" : '';?>><?=$monthlist[$m]?></option>
                                            <?php
                                            }
                                    ?> 
                                  </select>
                                 <div class="error" id="makemonth_error" ></div>
                                 <div class="d-arrow"></div>
                                 </div>
                            </div>
                            <?php $cyear=date('Y');?>
                            <div class="col-md-6">
                           <div class="form-group">
                                 <label for="" class="crm-label">Make Year*</label>
                                 <select class="form-control crm-form" id="myear" name="myear">
                                    <option value=''>Select Year</option>
                                    <?php
                                            for($y=2000;$y<=$cyear;$y++){
                                            ?> 
                                            <option value='<?=$y?>'<?php echo ((!empty($CustomerInfo['make_year'])) && $CustomerInfo['make_year']==$y) ? "selected=selected" : '';?>><?=$y?></option>
                                            <?php
                                            }
                                    ?> 
                                  </select>
                                 <div class="error" id="myear_error" ></div>
                                 <div class="d-arrow"></div>
                                 </div>
                            </div>

                            <input type="hidden" value="<?=$CustomerInfo['make'];?>" id="make" name="make">
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Make Model *</label>
                                 <select class="form-control crm-form crm-form_read_only search_test makemodel" name="model" id="model">
                                     <option value="">Please Select</option>
                                     <?php if(!empty($makeList)) {
                                    foreach ($makeList as $key =>$value) {
                                   ?>
                                   <option rel="<?= $value['make_id'];?>"  value="<?= $value['model_id'];?>" <?= (!empty($CustomerInfo['model']) && $CustomerInfo['model']==$value['model_id'])?'selected=selected':''?>><?=$value['make'] .' '.$value['model']?></option>
                                     <?php  } } ?>
                                 </select>
                                 <div class="error" id="err_model" ></div>
                                 
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Version *</label>
                                 <select class="form-control crm-form crm-form_read_only search_test" name="variant" id="versionId" <?php if(!empty($CustomerInfo['variantId'])) { echo ''; }else{ ?>readonly="readonly" <?php } ?>>
                                     <option value="">Please Select</option>
                                     <?php if(!empty($version)) {
                                    foreach ($version as $key =>$value) {?>
                                   <option  value="<?= $value['db_version_id'];?>" <?= (!empty($CustomerInfo['variantId']) && $CustomerInfo['variantId']==$value['db_version_id'])?'selected=selected':''?>><?= $value['db_version']?></option>
                                  <?php  } } ?>
                                 </select>
                                 <div class="error" id="err_variant" ></div>
                                 
                              </div>
                           </div>

                            <!-- <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Make*</label>
                                 <select class="form-control crm-form make"  onchange="return getModel(this.value)"   name="make" id="make">
                                    <option selected="selected" value="">Select Make</option>
                                    <?php if(!empty($make)){ ?>
                                    <?php foreach($make as $key => $makeArray){ ?>
                                    <option value="<?php echo $makeArray->id;?>"<?php echo ((!empty($CustomerInfo['make'])) && $CustomerInfo['make']==$makeArray->id) ? "selected=selected" : '';?>><?php echo $makeArray->make;?></option>
                                    <?php }} ?> 
                                 </select>
                                 <div class="error" id="make_error" ></div>
                                 </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Model*</label>
                                 <select class="form-control crm-form crm-form_read_only model" onchange="return getVersion(this.value)" name="model" id="model" <?php if(!empty($CustomerInfo['model'])) { echo ''; }else{ ?>readonly="readonly" <?php } ?>>
                                     <option value="">Please Select</option>
                                     <?php if(!empty($model)) {
                                    foreach ($model as $key =>$value) {
                                   ?>
                                   <option  value="<?= $value['id'];?>" <?= (!empty($CustomerInfo['model']) && $CustomerInfo['model']==$value['id'])?'selected=selected':''?>><?= $value['model']?></option>
                                     <?php  } } ?>
                                 </select>
                                 <div class="error" id="model_error" ></div>
                                 <div class="d-arrow"></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Variant*</label>
                                 <select class="form-control crm-form crm-form_read_only variant" name="variant" id="variant" <?php if(!empty($CustomerInfo['variantId'])) { echo ''; }else{ ?>readonly="readonly" <?php } ?>>
                                     <option value="">Please Select</option>
                                     <?php if(!empty($version)) {
                                 foreach ($version as $key =>$value) {?>
                                <option  value="<?= $value['db_version_id'];?>" <?= (!empty($CustomerInfo['variantId']) && $CustomerInfo['variantId']==$value['db_version_id'])?'selected=selected':''?>><?php echo $value['db_version']?>(<?php echo $value['uc_fuel_type']?>-<?php echo $value['Displacement']?> cc)</option>
                                  <?php  } } ?>
                                 </select>
                                 <div class="error" id="variant_error" ></div>
                                 <div class="d-arrow"></div>
                              </div>
                           </div> -->
                           
                         <?php if(!empty($CustomerInfo['ins_category']) && ($CustomerInfo['ins_category']=='2' || $CustomerInfo['ins_category']=='3' || $CustomerInfo['ins_category']=='4')){?> 
                            <div class="col-md-6" style="height:84px;">
                                <div class="form-group">
                                    <label for="" class="crm-label">Registration Date* </label>
                                   <div class="input-group date" id="dp">
                                    <input type="text" name="reg_date" id="reg_date" class="form-control crm-form add-on icon-cal1 new_input" placeholder="DD-MM-YYYY" autocomplete="off" value="<?php echo (!empty($CustomerInfo['reg_date']) && $CustomerInfo['reg_date']!='0000-00-00') ?date('d-m-Y',strtotime($CustomerInfo['reg_date'])) : '';?>"> 
                                    <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                    </span>
                                    </div>
                                    <div class="error" id="reg_date_error" ></div>
                                </div>
                            </div> 
                           <?php } ?>
                           <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <?php if(($is_admin=='1') || (($addPerm=='1') && ($mode=='add')) ||  (($editPerm=='1') && ($mode=='edit'))){?>
                                  <input  style="text-align: center" type="button" class="btn-continue" name="btnform3" id="btnform3" value="SAVE AND CONTINUE">
                                  <?php } elseif(($viewPerm=='1') && ($mode=='edit') || (!empty($CustomerInfo['make']))){ ?>
                                  <button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                                  <?php } ?>
                                  <input type="hidden" name="inscat" id="inscat" value="<?php echo !empty($CustomerInfo['ins_category']) ? $CustomerInfo['ins_category']:'';?>">
                                  <input type="hidden" name="step3" value="true">
                                  <input type="hidden" name="insfrm3" id="insfrm3" value="">
                                  <input type="hidden" name="roleType" id="roleType" value="<?php echo $role_name;?>">
                                  <input type="hidden" name="customerId" id="customer_id" value="<?php echo isset($customerId) ? $customerId :''; ?>">
                                  <input type="hidden" name="mk_id" id="mk_id" value='<?php echo $CustomerInfo['make']; ?>'>
                               </div>
                           </div>
                        </div>
                     </div>
                   
                      
                  </div>
                   </form>
               </div>
            </div>
         </div>
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
         <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_assets/css/sumoselect.min.css">
         <script src="<?php echo base_url(); ?>assets/js/jquery.sumoselect.min.js"></script>
         <script src="<?php echo base_url(); ?>assets/js/insurance_process.js" type="text/javascript"></script>
         <script src="<?php echo base_url(); ?>assets/js/insuranceValidation.js" type="text/javascript"></script>
         <script>
           $('.makemodel').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
           $('#versionId').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
         </script>
         <script language="javascript">
         $(document).ready(function () {    
         window.Search = $('.search-box').SumoSelect({ csvDispCount: 3, search: true, okCancelInMulti:true, searchText:'Enter here.' }); 
         var d = new Date();
            $('#reg_date').datepicker({
             format:"dd-mm-yyyy",   
             startDate: '-1000y',
             endDate:'y',
             autoclose: true,
             todayHighlight: true
         });
         });
          $('#engine_no').keyup(function() {
            // alert(1);
        var mob = $('#engine_no').val();
            $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "Finance/prefillcar/",
            data:{engno:mob},
            dataType: "json",
            success: function(response) 
            {
     //   alert(response);
                if(response.status=='1')
                {
          
                  $('#chassis_no').val(response.result[0].chassis_no);
                    $('#regNo').val(response.result[0].reg_no);
                    $('#makemonth').val(response.result[0].mm);
                    $('#myear').val(response.result[0].myear);
                    $('#make').val(response.result[0].make_id);
                    $('#model').val(response.result[0].model_id);
                     $('#model')[0].sumo.reload();
                      $('#model').trigger('change');
                      modelChnage(response.result[0].make_id,response.result[0].model_id,response.result[0].version_id);
                    // $('#model').trigger()
                    //getModel(response.result[0].make_id,response.result[0].model_id);
                    //setTimeout(function(){ getVersion(response.result[0].model_id,response.result[0].version_id); }, 30);
                    
                }
                else
                {
                   // alert('ffff');
                    $('#chassis_no').val('');
                    $('#makemonth').val('');
                    $('#myear').val('');

                }
            }   
            });
        //}
        
    });
      $('#chassis_no').keyup(function() {
        var mob = $('#chassis_no').val();
             $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "Finance/prefillcar/",
            data:{chasno:mob},
            dataType: "json",
            success: function(response) 
            {
                if(response.status=='1')
                {
                    $('#engine_no').val(response.result[0].engine_number);
                    $('#makemonth').val(response.result[0].mm);
                    $('#regNo').val(response.result[0].reg_no);
                    $('#myear').val(response.result[0].myear);
                    $('#make').val(response.result[0].make_id);
                    $('#model').val(response.result[0].model_id);
                     $('#model')[0].sumo.reload();
                      $('#model').trigger('change');
                      modelChnage(response.result[0].make_id,response.result[0].model_id,response.result[0].version_id);
                   // getModel(response.result[0].make_id,response.result[0].model_id);
                    //setTimeout(function(){ getVersion(response.result[0].model_id,response.result[0].version_id); }, 30);
                }
                else
                {
                   // alert('ffff');
                    $('#engine_number').val('');
                    $('#makemonth').val('');
                    $('#myear').val('');

                }
            }   
            });
      //  }
    });   
          $("#model").change(function() {
           // alert('hi');
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

          function modelChnage(make,model,version)
          {
               $.ajax({
                type: 'POST',
                url: "<?php echo base_url(); ?>" +"finance/getVersion",
                data: {model: model,make:make,flag:'1'},
                dataType: "html",
                success: function (responseData)
                {
                    $('#versionId').html(responseData);
                    $('#versionId').val(version);
                    $('#versionId')[0].sumo.reload();
                }
            });
          }
         </script>
         
         
   
