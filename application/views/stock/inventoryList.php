<script src="<?=base_url('assets/admin_assets/js/jquery-ui/jquery.js')?>"></script>
<script src="<?=base_url('assets/admin_assets/js/jquery-ui/jquery-ui.js')?>"></script>
<script src="<?=base_url('assets/admin_assets/js/jquery-ui/jquery.datetimepicker.js')?>"></script>
<link href="<?=base_url('assets/admin_assets/js/jquery-ui/jquery.datetimepicker.css')?>" rel="stylesheet">


<?php $this->load->helper('range_helper');?>
<div class="container-fluid" id="stock-manager-new">
   <div class="row">
      <div class="col-md-12 mrg-B40" id="content">
         
         <div>
            <form method="get" name="searchform" id="searchform"   onsubmit="return false;">
               <div class=" " id="maincontainer">
                  <!--<h4 class="main-heading clearfix tophead ">
                     <div id="filterbtn" class="pull-right"><button class="btn btn-primary" id="searchbtn" name="sechicon" type="button">
                        <span class="fa fa-search"></span> Search</button>
                     </div>
                  </h4>-->
                   
                  <div id="serch-wrapper" class="min_height_100">
                     <input type="hidden" value="" name="tab_value" id="tab_value" />
                     <input type="hidden" name="search_form" value=''>
                     <input type="hidden" name="selected_mmv_car_id" id="selected_mmv_car_id" >
                     <input type="hidden" name="listType" id="listType" value="gaadi">
                     <input type="hidden" name="download_excel" id="download_excel" value="">
                     <input type="hidden" name="invdashId" id="invdashId" value="<?php echo (!empty($invId)) ? $invId:'';?>">
                     <div class="clearfix">
                        <div class="bg-container-new pad-all-20 bg-white mrg-T20" style="position:relative;">
                            <div class="row">
                                <h4 style="padding: 0 15px; display:inline-block" class="col-black-o fw-B mrg-T10 mrg-B0"><strong>Stock Manager</strong></h4>
                            <?php /* if( !($_SESSION['userinfo']['team_id']==7 && $_SESSION['userinfo']['role_id']==15)) { ?> 
                                <a class="btn add-stock-bt pull-right mrg-R15" href="<?php echo base_url(); ?>usedcarpurchase/add">ADD STOCK</a>
                            <?php }*/ ?>
             <?php if( ($_SESSION['userinfo']['team_id']==7 && $_SESSION['userinfo']['role_id']==15 && $_SESSION['userinfo']['role_id']==19)) { ?>
                               <a class="btn add-stock-bt pull-right mrg-R15" href="<?php echo base_url(); ?>usedcarpurchase/add">ADD STOCK</a>
                           <?php } ?>
                            </div>
                            <div class="border-T mrg-T20 mrg-B20"></div>
                           <img class="resultloader" src="<?php echo base_url(); ?>assets/images/loader.gif" style="position: absolute; left:630px; top: 180px; width: 50px;display:none; ">
                           <div class="row ">
                              <div class="col-md-2 col-sm-6 pad-R5 tabpading">
                                 <label for="exampleInputPassword1" class="form-label">Search</label>
                                 <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box"> 
                                       <input type="text" id="car_id_reg_no"  style="font-size:10.5px; text-transform:uppercase;"  placeholder=" Reg No. | Make Model Version " class="form-control pad-L10" onkeydown="Javascript: if (event.keyCode == 13) {
                                          $('#inventory_search').click(); }" >                        
                                    </div>
                                 </div>
                              </div>
                              <!--<div class="col-md-3 col-sm-6 pad-LR tabpading">
                                 <label for="exampleInputPassword1" class="form-label">Select a Car :</label>
                                 <div class="row row-text-box">
                                    <div class="col-xs-6 mrg-all-0 sm-text-box">
                                       <select  class="form-control" name="make" id="make" >
                                          <option selected="selected" value="">Select Make</option>
                                          <?php if(!empty($make)){?>
                                          <?php foreach($make as $makeData){?>
                                          <option value="<?php echo $makeData['make'];?>"><?php echo $makeData['make'];?></option>
                                          <?php }} ?>
                                       </select>
                                    </div>
                                    <div class="col-xs-6 pad-all-0 mrg-B0 form-group">
                                       <div class="posrelative text-left">
                                          <select  class="form-control" name="model" id="model" disabled="disabled" >
                                             <option selected="selected" value="">Model</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>-->
                              <div class="col-md-3  col-sm-6 pad-LR tabpading">
                                 
                                 <div class="row row-text-box">
                                    <!--<div class="col-xs-6 mrg-all-0 sm-text-box">
                                       <select class="form-control" id='select_price_min_list' name='select_price_min_list'>
                                          <option value=''>Min</option>
                                          <//?php
                                             $minPriceArr = array('50000' => '50,000', '100000' => '1 Lakh', '200000' => '2 Lakh', '300000' => '3 Lakh', '400000' => '4 Lakh', '500000' => '5 Lakh', '600000' => '6 Lakh', '700000' => '7 Lakh', '800000' => '8 Lakh', '900000' => '9 Lakh', '1000000' => '10 Lakh', '1500000' => '15 Lakh', '2000000' => '20 Lakh', '2500000' => '25 Lakh', '3000000' => '30 Lakh');
                                             foreach ($minPriceArr as $minkey => $val)
                                             {
                                                 ?>
                                          <option value="<//?php echo $minkey; ?>"><//?php echo $val; ?></option>
                                          <//?php }
                                             ?>
                                       </select>
                                    </div>-->
                                    <div class="col-xs-6 mrg-all-0 sm-text-box">
                                      <label for="exampleInputPassword1" class="form-label">Max Price </label>
                                       <select class="form-control" id="select_price_max_list" name="select_price_max_list">
                                          <option value=''>Max</option>
                                          <?php
                                             $maxPriceArr = array('50000' => '50,000', '100000' => '1 Lakh', '200000' => '2 Lakh', '300000' => '3 Lakh', '400000' => '4 Lakh', '500000' => '5 Lakh', '600000' => '6 Lakh', '700000' => '7 Lakh', '800000' => '8 Lakh', '900000' => '9 Lakh', '1000000' => '10 Lakh', '1500000' => '15 Lakh', '2000000' => '20 Lakh', '2500000' => '25 Lakh', '3000000' => '30 Lakh', '4000000' => '40 Lakh', '5000000' => '50 Lakh', '6000000' => '60 Lakh', '7000000' => '70 Lakh', '8000000' => '80 Lakh', '9000000' => '90 Lakh', '10000000' => '1 Crore', '' => 'No Max');
                                             foreach ($maxPriceArr as $maxkey => $val)
                                             {
                                                 ?>
                                          <option value="<?php echo $maxkey; ?>"><?php echo $val; ?></option>
                                          <?php 
                                             }
                                             ?> 
                                       </select>
                                    </div>
                                    <div class="col-md-6 col-sm-12 pad-LR tabpading">
                                 <label for="exampleInputPassword1" class="form-label">Select Make Year</label>
                                 <div class="row row-text-box">
                                    <!--<div class="col-xs-6 mrg-all-0 sm-text-box">
                                       <select class="form-control" id='select_myear_from_list' name="select_myear_from_list">
                                          <option value=''>From</option>
                                          <//?php for ($i = date("Y"); $i >= 1970; $i--)
                                             { ?>
                                          <option value="<//?php echo $i; ?>"><//?php echo $i; ?></option>
                                          <//?php } ?>
                                       </select>
                                    </div>-->
                                    <div class="col-xs-12 mrg-all-0 sm-text-box">
                                       <select class="form-control" id='select_myear_to_list' name='select_myear_to_list'>
                                          <option value=''>Make Year</option>
                                          <?php for ($i = date("Y"); $i >= 1970; $i--)
                                             { ?>
                                          <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                          <?php } ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                                 </div>
                              </div>
                              <!--<div class="col-md-2 col-sm-6 pad-LR tabpading">
                                 <label for="exampleInputPassword1" class="form-label">KM. Range :</label>
                                 <div class="row row-text-box">
                                    <div class="col-xs-6 mrg-all-0 sm-text-box">
                                       <select class="form-control" id="select_km_max_list" name='select_km_min_list'>
                                          <option value=''>From</option>
                                          <?php
                                             for ($i = 10000; $i <= 100000; $i += 10000)
                                             {
                                                 ?>
                                          <option value="<?php echo $i; ?>"><?php echo indian_currency_form($i); ?></option>
                                          <?php
                                             }
                                             ?>  
                                       </select>
                                    </div>
                                    <div class="col-xs-6 mrg-all-0 sm-text-box">
                                       <select class="form-control" id='select_km_min_list' name='select_km_max_list'>
                                          <option value=''>To</option>
                                          <?php
                                             for ($i = 10000; $i <= 100000; $i += 10000)
                                             {
                                                 ?>
                                          <option value="<?php echo $i; ?>"><?php echo indian_currency_form($i); ?></option>
                                          <?php
                                             }
                                             ?>  
                                       </select>
                                    </div>
                                 </div>
                              </div>-->
                              <div class="col-md-3">
                                <div class="row">
                                  <div class="col-md-5 col-sm-6 pad-LR tabpading">
                                     <label for="exampleInputPassword1" class="form-label">Fuel Type</label>
                                     <div class="row row-text-box">
                                        <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                           <div class="posrelative text-left">
                                              <div class="multi-dropdwn form-control">
                                                 <span>Fuel Type</span><span></span> <span class="pull-right caret"></span>
                                              </div>
                                              <ul class="dropdown-menu" role="menu" id='select_fuel_type_list'>
                                                 <?php
                                                    $getDeatCarFuelArr = array("Petrol","Diesel","CNG");
                                                      if (isset($getDeatCarFuelArr) && count($getDeatCarFuelArr) > 0)
                                                      {
                                                          foreach ($getDeatCarFuelArr as $fuelVal)
                                                          {
                                                              ?>                                        
                                                 <?php
                                                    if (isset($fuel_type) && $fuel_type != '')
                                                    {
                                                        $fuelArr = explode(",", $fuel_type);
                                                        if (in_array($fuelVal, $fuelArr))
                                                        {
                                                            $sel = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $sel = '';
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $sel = '';
                                                    }
                                                    ?> 
                                                 <li class="pad-L5">
                                                    <input type="checkbox" name="fuel_type[]" id="<?php echo $fuelVal; ?>" value="<?php echo $fuelVal; ?>" <?php echo $sel; ?> >
                                                    <label for="<?php echo $fuelVal; ?>"><span></span> <?php echo $fuelVal; ?></label>
                                                 </li>
                                                 <?php
                                                    }
                                                    }
                                                    ?>
                                              </ul>
                                           </div>
                                        </div>
                                     </div>
                                  </div>
                                  <div class="col-md-7 col-sm-6 tabpading pad-LR tabpading">
                                     <label for="exampleInputPassword1" class="form-label">Age Of Inventory</label>
                                     <div class="row row-text-box">
                                        <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                           <div class="posrelative text-left">
                                              <div class="multi-dropdwn form-control">
                                                 <span>Age Of Inventory</span><span></span><span class="pull-right caret"></span>
                                              </div>
                                              <ul class="dropdown-menu" role="menu" id='select_age_inventory_list'>
                                                 <li class="pad-L5">
                                                    <input type="checkbox" name="age_inventory[]" id="lastmonth" value="30_days" <?php echo $ageinventory = (isset($age_inventory) && $age_inventory == '30_days') ? "checked=checked" : ''; ?>>
                                                    <label for="lastmonth"><span></span>Within 30 days</label>
                                                 </li>
                                                 <li class="pad-L5">
                                                    <input type="checkbox" name="age_inventory[]" id="lastweek" value="btw_31_60_days" <?php echo $ageinventory = (isset($age_inventory) && $age_inventory == 'btw_31_60_days') ? "checked=checked" : ''; ?>>
                                                    <label for="lastweek"><span></span>Between 31 to 60 days</label>
                                                 </li>
                                                 <li class="pad-L5">
                                                    <input type="checkbox" name="age_inventory[]" id="last3month" value="btw_61_90_days" <?php echo $ageinventory = (isset($age_inventory) && $age_inventory == 'btw_61_90_days') ? "checked=checked" : ''; ?>>
                                                    <label for="last3month"><span></span>Between 61 to 90 days</label>
                                                 </li>
                                                 <li class="pad-L5">
                                                    <input type="checkbox" name="age_inventory[]" id="lastsixmonth" value="above_90_days" <?php echo $ageinventory = (isset($age_inventory) && $age_inventory == 'above_90_days') ? "checked=checked" : ''; ?>>
                                                    <label for="lastsixmonth"><span></span>Above 90 days</label>
                                                 </li>
                                              </ul>
                                           </div>
                                        </div>
                                     </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-2  col-sm-6 tabpading pad-LR display-n advance-search">
                                 <label for="exampleInputPassword1" class="form-label">Select Owner</label>
                                 <div class="row row-text-box">
                                    <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                       <div class="posrelative text-left">
                                          <div class="multi-dropdwn form-control">
                                             <span>Select</span><span></span><span class="pull-right caret"></span>
                                          </div>
                                          <ul class="dropdown-menu" role="menu" id="select_owner_list">
                                             <?php
                                                $ownerArr     = array(1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => 'Above 4');
                                                foreach ($ownerArr as $ownerVal)
                                                {
                                                    ?>
                                             <?php
                                                if (isset($owner) && $owner != '')
                                                {
                                                    $ownerSelArr = explode(",", $owner);
                                                    if (in_array($ownerVal, $ownerSelArr))
                                                    {
                                                        $sel = 'checked';
                                                    }
                                                    else
                                                    {
                                                        $sel = '';
                                                    }
                                                }
                                                else
                                                {
                                                    $sel = '';
                                                }
                                                ?>  
                                             <li class="pad-L5">
                                                <input type="checkbox" name="owner[]" id="<?php echo $ownerVal; ?>" value="<?php echo $ownerVal; ?>" <?php echo $sel; ?>>
                                                <label for="<?php echo $ownerVal; ?>"><span></span> <?php echo $ownerVal; ?></label>
                                             </li>
                                             <?php
                                                }
                                                ?> 
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-2  col-sm-6 tabpading pad-L5 display-n advance-search">
                                 <label for="exampleInputPassword1" class="form-label">Inspection Status</label>
                                 <div class="row row-text-box">
                                    <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                       <div class="posrelative text-left">
                                          <div class="multi-dropdwn form-control">
                                             <span>Inspection Status</span><span></span><span class="pull-right caret"></span>
                                          </div>
                                          <ul class="dropdown-menu" role="menu" id="select_owner_list">
                                             <?php
                                                $inspectedSelArr = array(0 => 'Not Inspected', 1 => 'Certified', 2 => 'In Process', 4 => 'Refurbishment', 6 => 'Rejected', 7 => 'Expired');
                                                foreach ($inspectedSelArr as $inskey => $insval)
                                                {
                                                    ?>
                                             <?php
                                                if (isset($inspection_status) && $inspection_status != '')
                                                {
                                                    $ownerSelArr = explode(",", $inspection_status);
                                                    if (in_array($insval, $inspectedSelArr))
                                                    {
                                                        $sel = 'checked';
                                                    }
                                                    else
                                                    {
                                                        $sel = '';
                                                    }
                                                }
                                                else
                                                {
                                                    $sel = '';
                                                }
                                                ?>  
                                             <li class="pad-L5">
                                                <input type="checkbox" name="inspection_status[]" id="<?php echo $insval; ?>" value="<?php echo $inskey; ?>" <?php echo $sel; ?>>
                                                <label for="<?php echo $insval; ?>"><span></span> <?php echo $insval; ?></label>
                                             </li>
                                             <?php
                                                }
                                                ?>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-6 pad-R5 tabpading display-n advance-search mrg-T10">
                                 <label for="exampleInputPassword1" class="form-label">Transmission</label>
                                 <div class="row row-text-box">
                                    <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                       <div class="posrelative text-left">
                                          <div class="multi-dropdwn form-control">
                                             <span>Transmission</span><span></span><span class="pull-right caret"></span>
                                          </div>
                                          <ul class="dropdown-menu" role="menu" id="select_transmission_list">
                                             <?php
                                                $getDeatCarTransmissionArr = array('Automatic','Manual');
                                                if (isset($getDeatCarTransmissionArr) && count($getDeatCarTransmissionArr) > 0)
                                                {
                                                    foreach ($getDeatCarTransmissionArr as $transmissionVal)
                                                    {
                                                        ?>
                                             <?php
                                                if (isset($transmission) && $transmission != '')
                                                {
                                                    $transmissionArr = explode(",", $transmission);
                                                    if (in_array($transmissionVal, $transmissionArr))
                                                    {
                                                        $sel = 'checked';
                                                    }
                                                    else
                                                    {
                                                        $sel = '';
                                                    }
                                                }
                                                else
                                                {
                                                    $sel = '';
                                                }
                                                ?> 
                                             <li class="pad-L5">
                                                <input type="checkbox" name="transmission_type[]" id="<?php echo $transmissionVal; ?> " value="<?php echo $transmissionVal; ?>" <?php echo $sel; ?>>
                                                <label for="<?php echo $transmissionVal; ?> "><span></span> <?php echo $transmissionVal; ?> </label>
                                             </li>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-2  col-sm-6 pad-LR tabpading display-n advance-search">
                                 <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box mrg-T30">                         
                                       <input   type="checkbox" id="car_withoutPhotos" name="car_withoutPhotos" <?php echo $carWithphotos1 = ((isset($car_withoutPhotos) && $car_withoutPhotos == 'on'))  ? "checked=checked" : ''; ?>><label for="car_withoutPhotos"><span></span>
                                       Car Without Photos</label>
                                       <br>
                                       <input   type="checkbox" id="car_withPhotos" name="car_withPhotos" <?php echo $carWithphotos1 = (isset($image) && $image == 1) ? "checked=checked" : ''; ?> ><label for="car_withPhotos"><span></span>
                                       Car With Photos</label>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-2  col-sm-6 pad-LR tabpading display-n advance-search">
                                 <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box mrg-T30">                         
                                       <input   type="checkbox" id="isclassified_tab" name="isclassified_tab" <?php echo $clstab = (isset($isclassified_tab) && $isclassified_tab == 1) ? "checked=checked" : ''; ?> ><label for="isclassified_tab"><span></span>
                                       Classified Cars</label> <br>
                                       <input   type="checkbox" id="nonclassified_tab" name="nonclassified_tab" <?php echo $clstab = (isset($nonclassified_tab) && $nonclassified_tab==1) ? "checked=checked" : ''; ?> ><label for="nonclassified_tab"><span></span>
                                       Non Classified Cars</label>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-2  col-sm-6 pad-LR tabpading display-n advance-search">
                                 <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box mrg-T30">                         
                                       <input  onclick="" type="checkbox" id="car-Premium" name="ispremium" <?php echo $carWithphotos = ((isset($ispremium) && $ispremium == 'on') || (isset($ispremium) && $premium == 1)) ? "checked=checked" : ''; ?>><label for="car-Premium"><span></span>
                                       Featured Cars</label>
                                       <input   type="checkbox" id="trustmark-certified" name="trustmark-certified" ><label for="trustmark-certified"><span></span>
                                       Trustmark Certified</label>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3 pad-LR">
                                 <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box">
                                       <label for="exampleInputPassword1" class="form-label"></label>
                                       <button type="button" id="inventory_search" class="btn btn-primary mrg-T20" onclick="pagee = 0;getStockResult();">SEARCH</button>
                                       <a type="button" style="vertical-align: middle; display: inline-block; margin-left: 15px;" class="mrg-T20" onClick="document.searchform.reset();
                                          $('option:selected').removeAttr('selected');
                                          $('input:checkbox').removeAttr('checked');
                                          $('#car-Premium').attr('checked', false);
                                          $('#is_rsa').attr('checked', false);$('#car-withPhotos').attr('checked', false);$('#car_id_reg_no').val('');$('#selected_mmv_car_id').val('');
                                          $('#select_fuel_type_list,#select_age_inventory_list,#select_owner_list,#select_bodytype_list,#select_transmission_list,#select_flag_list').trigger('click');
                                          $('#carid').val('');
                                          pagee = 0;
                                          getStockResult();
                                          
                                          $('select[name=select_price_min_list] option,select[name=select_price_max_list] option,select[name=select_km_min_list] option,select[name=select_km_max_list] option,select[name=select_myear_from_list] option,select[name=select_myear_to_list] option').show();$('#model').attr('disabled', 'disabled');">RESET</a>
                                          <br>
                                       <a class="btn-block advanced-search-btn pad-L10 mrg-T5 font-12" onclick="$('#serch-wrapper').toggleClass('min_height_235');" href="javascript:void(0);">
                                       <i class="fa fa-plus-square-o down font-14 mrg-R5" data-unicode="f01a"></i><i class="fa fa-minus-square-o up font-14 mrg-R5" data-unicode="f01b" style="display:none;"></i>Advanced Search</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="clearfix border-B pad-all-15 pad-B0 mrg-T20 bg-white tabs_sell">
                     <div class="col-sm-8 col-md-9 stockmanager-new">
                        <button style="position:relative;" type="button" id="gaadi" onclick="$('#tab_value').val('');
                           pagee = 0;
                           getStockResult();
                           $('#remove_to_list').hide();
                           $('#remove_to_list span').eq(0).removeClass('icon-add');
                           $('#remove_to_list span').eq(1).html('Remove');$('#all-actions-multiple').show();
                           $('#all-actions-multiple-more').show();$('label[for=car-Premium],label[for=car-Eligible]').show();"  class="btn active type_btn">
                        Available (<span class="badge" id="available_tab">
                        </span>)
                        <img class="countloader" src="<?php echo base_url(); ?>assets/images/loader.gif" style="position: absolute; right: 20px; top: 6px; width: 16px; display: none;">
                        </button>
                        <button style="position:relative;" type="button" id="refurb" onclick="$('#tab_value').val('refurb');
                           pagee = 0;
                           getStockResult();
                           $('#remove_to_list span').eq(0).addClass('icon-add').removeClass('icon-delete');
                           $('#remove_to_list span').eq(1).html('Add to Stock');
                           $('#remove_to_list').show();
                           $('#all-actions-multiple').show();
                           $('#all-actions-multiple-more').hide();
                           $('label[for=car-Premium],label[for=car-Eligible]').hide();"  class="btn type_btn">
                        In Refurb (<span class="badge bg-w" id="refurb_tab">
                        </span>)
                        <img class="countloader" src="<?php echo base_url(); ?>assets/images/loader.gif" style="position: absolute; right: 20px; top: 6px; width: 16px; display: none;">
                        </button>
                        <button style="position:relative;" type="button" id="booked" onclick="$('#tab_value').val('booked');
                           pagee = 0;
                           getStockResult();
                           $('#remove_to_list span').eq(0).addClass('icon-add').removeClass('icon-delete');
                           $('#remove_to_list span').eq(1).html('Add to Stock');
                           $('#remove_to_list').show();
                           $('#all-actions-multiple').show();
                           $('#all-actions-multiple-more').hide();
                           $('label[for=car-Premium],label[for=car-Eligible]').hide();"  class="btn type_btn">
                        Booked (<span class="badge bg-w" id="booked_tab">
                        </span>)
                        <img class="countloader" src="<?php echo base_url(); ?>assets/images/loader.gif" style="position: absolute; right: 20px; top: 6px; width: 16px; display: none;">
                        </button>
                        <button style="position:relative;" type="button" id="sold" onclick="$('#tab_value').val('sold');
                           pagee = 0;
                           getStockResult();
                           $('#remove_to_list span').eq(0).addClass('icon-add').removeClass('icon-delete');
                           $('#remove_to_list span').eq(1).html('Add to Stock');
                           $('#remove_to_list').show();
                           $('#all-actions-multiple').show();
                           $('#all-actions-multiple-more').hide();
                           $('label[for=car-Premium],label[for=car-Eligible]').hide();"  class="btn type_btn">
                        Sold (<span class="badge bg-w" id="sold_tab">
                        </span>)
                        <img class="countloader" src="<?php echo base_url(); ?>assets/images/loader.gif" style="position: absolute; right: 20px; top: 6px; width: 16px; display: none;">
                        </button>
                        <button style="position:relative;" type="button" id="removed" onclick="$('#tab_value').val('removed');
                           pagee = 0;
                           getStockResult();
                           $('#remove_to_list span').eq(0).addClass('icon-add').removeClass('icon-delete');
                           $('#remove_to_list span').eq(1).html('Add to Stock');
                           $('#remove_to_list').show();
                           $('#all-actions-multiple').show();
                           $('#all-actions-multiple-more').hide();
                           $('label[for=car-Premium],label[for=car-Eligible]').hide();"  class="btn type_btn">
                        Removed (<span class="badge bg-w" id="removed_tab">
                        </span>)
                        <img class="countloader" src="<?php echo base_url(); ?>assets/images/loader.gif" style="position: absolute; right: 20px; top: 6px; width: 16px; display: none;">
                        </button>
                        <button style="position:relative;" type="button" id='all'  onclick="$('#tab_value').val('all');pagee = 0;getStockResult();
                           $('#all-actions-multiple').hide();
                           $('label[for=car-Premium],label[for=car-Eligible]').show();" class="btn type_btn">
                        All (<span class="badge" id="all_tab"></span>)
                        <img class="countloader" src="<?php echo base_url(); ?>assets/images/loader.gif" style="position: absolute; right: 20px; top: 6px; width: 16px; display: none;">
                        </button>
                        <img style="display: none;left: 50%;position: fixed;top: 50%;z-index: 1002;border-radius:30px;" src="<?php echo base_url(); ?>assets/images/loader.gif" class="searchresultloader">
                     </div>
                     <div class="" style="float:right;">
                        <div class="form-group pull-left mrg-B0" style="padding-right:15px;">
                           <label for="exampleInputName2" class="pull-left" style="line-height: 28px; padding-right:15px;"><b>Sort By : </b></label>
                           <select class="form-control shortby pull-left" id="sortby" name="sortby" onchange="$('#sort_by').val(this.value);pagee = 0;
                              getStockResult();" style="width:140px; height:38px;" >
                              <option value="">  Select  </option>
                              <option value="pricefrom-DESC">Price:Highest</option>
                              <option value="pricefrom-ASC">Price: Lowest</option>
                              <option value="myear-DESC">Year: Newest</option>
                              <option value="myear-ASC">Year: Oldest</option>
                              <option value="km-DESC">Km:Highest</option>
                              <option value="km-ASC">Km:Lowest</option>
                              <!--<option value="profile-DESC">% Complete:Highest</option>
                                 <option value="profile-ASC">% Complete:Lowest</option>-->
                              <option value="make-ASC">Vehicles: A to Z</option>
                              <option value="make-DESC">Vehicles: Z to A</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <style>
                     .lead-circle .lead-circle1{width: 90px; height: 90px; border: solid 7px #e3e3e3; background: #ffffff; border-radius: 50%; position: relative; display: inline-block; color: #444; transition: all 0.3s;}
                     .lead-circle1:hover{border: solid 7px #e3e3e3; background: #ffffff;color: #444;}
                     .col-b{color: #444 !important}
                     .list-h{ background:#ffffff; }
                  </style>
               </div>
            </form>
            <div id="inventoryList" class="list-h"></div>
            <div id="loadmoreajaxloader"  style="display:none;text-align:center;margin-bottom:20px;font-size:10px;"></div>
            <!-- Make Premium modal -->
            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-makePremium">
               <div class="modal-body text-center">
               </div>
            </div>
            <!-- Mark as Sold modal -->
            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-mark_as_Sold">
               <div class="modal-body text-center">
                  <div id="soldmodal"></div>
               </div>
            </div>
            <!----sdsdfasdfasdf-->
            <div class="modal fade bs-example-modal-sm" tabindex="-1" id="model-classified" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
               <div class="modal-dialog ">
                  <!-- Modal content-->
                  <div class="modal-content" >
                     <!--<div class="modal-header bg-gray">
                        <button type="button" id="xClose" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" align="center">CLASSIFIED INVENTORY</h4>
                     </div>-->
                     <div class="modal-body">
                      <h4 class="modal-title mrg-B15" >Confirmation</h4>
                        
                           <span id="sureMsg"></span>
                           <span id="showMsg"></span>
                           <span class="limitExausted"></span>
                       
                     </div>
                     <div class="modal-footer">
                        <span class="success" style="color:green;"></span>
                        <span class="err-classified" style="color:red;"></span>
                        <a type="button" id="cancelCheckBox" class="mrg-R10 dialogcancel" data-dismiss="modal">CLOSE</a>
                        <span id="clss_modal"></span>                
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Add Buyer Lead modal -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-add-buyer" style="background: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content" style="width: 440px; margin: auto;">
            <div class="modal-header bg-gray">
                <button type="button" class="close cross_close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Add Buyer Lead</h4>
            </div>
            <div class="modal-body">
                <form name="buyer_lead_form" id="buyer_lead_form" method="post">
                    <div class="row mrg-all-0 mrg-B0 mrg-T0">
                        <div class="col-md-6  col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Customer Name *</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">                         
                                    <input type="text" placeholder="Enter Customer Name" class="form-control search-form-select-box" value="" name="txtcustName" id="txtcustName">
                                    <label class="control-label add_lead_err" id="txtcustName_err" style="display:none;font-size: 10px;color: red;"></label> 
                                </div>                       
                            </div>
                        </div>

                        <div class="col-md-6  col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Mobile Number *</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">                         
                                    <input type="text" placeholder="Enter Mobile Number" class="form-control search-form-select-box" value="" name="txtMobile" id="txtMobile" maxlength="10">
                                    <label class="control-label add_lead_err" id="txtMobile_err" style="display:none;font-size: 10px;color: red;"></label> 
                                </div>                       
                            </div>
                        </div>
                       
                    </div>
                    <div class="clearfix mrg-T15"></div>
                    <div class="row mrg-all-0 mrg-B0 mrg-T0">

                        <div class="col-md-6  col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Status*</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">                         
                                    <select class="form-control search-form-select-box" name="status" id="lead_status">
                                        <option value="">Status</option>
                                        <option value="3">Interested</option>
                                        <option value="4">Walk-in Scheduled</option>
                                        <option value="9">Walk-in Done</option>
                                        <option value="10">Customer Offer</option>
                                        <option value="11">Booked</option>
                                    </select>
                                   <label class="control-label add_lead_err" id="lead_status_err" style="display:none;font-size: 10px;color: red;"></label> 
                                </div>                       
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Follow-up Date*</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">                        
                                    <div>
                                        <div class="input-append date input-group" id="dp5" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                            <input id="follow-uo-date" type="text" class="span2 form-control calender" name="followup_date" style="cursor:pointer; width:180px;">
                                            <label class="control-label add_lead_err" id="followup_status_err" style="display:none;font-size: 10px;color: red;"></label> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden"  value="WALK-IN" name="lead_source" id="lead_source">
                    <input type="hidden" id="lead_car_id" name="car_id" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="submit_buyer_lead()" >Submit</button>
                    </div>
                </form>
                <a class="" data-dismiss="modal" type="button" style=" bottom: 24px;float: right;position: relative;right: 118px; -webkit-margin-before: -19px; ">CLOSE</a>
            </div>
        </div>
    </div>
</div>
<div class="loaderClas" style="display:none;"><img class="resultloader" src="/assets/images/loading.gif" style="position: absolute;left: 0;right: 0;text-align: center;top: 0;bottom: 0;margin: auto;z-index: 9999;"></div>
<script>
   $(document).ready(function () {
       
   var car_status='<?php echo isset($_GET['status'])?$_GET['status']:''?>';
   if(car_status=='booked'){
       $('#gaadi').removeClass('active');
       $('#booked').addClass('active');
       $('#booked').trigger('click');
   }
   if(car_status=='sold'){
       $('#gaadi').removeClass('active');
       $('#sold').addClass('active');
       $('#sold').trigger('click');
   }
    
       $('#follow-uo-date').datetimepicker({timepicker:true,format:'j M Y g:i a',minDate:'today'});
    
    
    $('select[name=select_price_min_list]').change(function () {
           var min_val = parseInt($(this).val());
           $('select[name=select_price_max_list] option').each(function () {
               if (parseInt($(this).attr('value')) < min_val)
               {
                   $(this).hide();
               } else
               {
                   $(this).show();
               }
           });
       });
       $('select[name=select_price_max_list]').change(function () {
           var min_val = parseInt($(this).val());
           $('select[name=select_price_min_list] option').each(function () {
               if (parseInt($(this).attr('value')) > min_val)
               {
                   $(this).hide();
               } else
               {
                   $(this).show();
               }
           });
       });
   
       $('select[name=select_km_min_list]').change(function () {
           var min_val = parseInt($(this).val());
           $('select[name=select_km_max_list] option').each(function () {
               if (parseInt($(this).attr('value')) < min_val)
               {
                   $(this).hide();
               } else
               {
                   $(this).show();
               }
           });
       });
       $('select[name=select_km_max_list]').change(function () {
           var min_val = parseInt($(this).val());
           $('select[name=select_km_min_list] option').each(function () {
               if (parseInt($(this).attr('value')) > min_val)
               {
                   $(this).hide();
               } else
               {
                   $(this).show();
               }
           });
       });
       $('select[name=select_myear_from_list]').change(function () {
           var min_val = parseInt($(this).val());
           $('select[name=select_myear_to_list] option').each(function () {
               if (parseInt($(this).attr('value')) < min_val)
               {
                   $(this).hide();
               } else
               {
                   $(this).show();
               }
           });
       });
   
       $('select[name=select_myear_to_list]').change(function () {
           var min_val = parseInt($(this).val());
           $('select[name=select_myear_from_list] option').each(function () {
               if (parseInt($(this).attr('value')) > min_val)
               {
                   $(this).hide();
               } else
               {
                   $(this).show();
               }
           });
       });
   
       $('#select_fuel_type_list,#select_age_inventory_list,#select_owner_list,#select_bodytype_list,#select_transmission_list,#select_flag_list').click(function () {
           var ths = this;
           var selected = 0;
           $(':checked', this).each(function () {
               selected++;
               $(ths).prev().find('span').eq(0).hide();
               $(ths).prev().find('span').eq(1).html($(this).next().text());
   
           });
           if (selected > 1)
           {
               $(ths).prev().find('span').eq(1).html(selected + " selected");
           } else if (selected == 0) {
               $(ths).prev().find('span').eq(0).show();
               $(ths).prev().find('span').eq(1).html('');
           }
       });
   
       $('.tabs_sell button').click(function () {
           $(this).siblings().removeClass('active');
           $(this).addClass('active');
       });
   
   
   });
   
   $(function () {
   var closediv = $(".multi-dropdwn").next(" .dropdown-menu");
   $(".multi-dropdwn").click(function (e) {
       $(this).next(" .dropdown-menu").toggle();
   })
   $(document).mouseup(function (e) {
       if (closediv.has(e.target).length == 0) {
           closediv.hide();
       }
   })
   });
   
   function viewImgModel(car_id,img_count,flags=''){
   alert();
   $('#model-uploadPhoto').attr('class','modal fade in');
   $('#model-uploadPhoto').attr('style','display:block');
   $('#carImgId').val(car_id);
   $('#available_active_img').html('');
   $('#available_active_img').html(img_count);  
   if(flags=='1'){
       viewImgListStock();
   //tagnew();
   }
   else{
       $('#stockFeature').attr('style','display:none;');
       uploadmanagePhtos();
       //$('#uploadmanagePhtos').trigger('click');
   }
   }
   
   function tagnew()
   {
       $('#uploadmanagePhtos').attr('class','btn btn-default ');
       $('#TagneweditedPhotos').attr('class','btn btn-default active');
       $('#vieweditedphotos').attr('class','btn btn-default');
       var car_id = $('#carImgId').val();
   //alert(car_id);
   $.ajax({
       type: "POST",
       url: "<?php echo base_url(); ?>" + "stock/tagImgViewPage",
       dataType: 'html',
       data: {car_id: car_id},
       success: function(data){
        $('.shoImgg').html(data);
       }
   });
   }
   function addrefurb(){
            $('.error').html("");
            var carId = $("#carId").val();
            var wcName = $("#wcName").val();
            var empName = $("#empName").val();
            var refurb = $("#txtrefurb").val();
            var refurbsentOn = $("#refurbsentOn").val();
            var refurbestimated = $("#refurbestimated").val();
            var estimatedAmt = $("#estimatedAmt").val();
            var kmdriven = $("#km").val();
            var refurbValid = $.trim(refurb).replace("1.","");
            
         if(refurbsentOn != "" && refurbestimated != ""){
             var createDate= $('#refurbsentOn').val();
            var endDate= $('#refurbestimated').val();
           var dtime=createDate.split(" ");
            var d=dtime[0].split("-");
          var newcreateDate=d[2]+"/"+d[1]+"/"+d[0];
          var dtime1=endDate.split(" ");
            var d1=dtime1[0].split("-");
          var newendDate=d1[2]+"/"+d1[1]+"/"+d1[0];
          if(newcreateDate > newendDate){
              alert("Please Select Valid Date");
              return true;
          }
          
        
    }
            
            if(refurbsentOn==''){
               $("#refurbsentOn_error").html("Please select Sent to Reurb on");
               return false;
            }else if(refurbestimated==''){
               $("#refurbestimated_error").html("Please select Estimated Date of Return");
               return false;
            }else if(estimatedAmt==''){
               $("#estimatedAmt_error").html("Please enter Estimated Amt");
               return false;
            }else if(refurbValid == ""){
               $("#txtrefurb_error").html("Please enter Refurb Details");
               return false;
            }
            else{

              var is_download = $('input[name="checkprint"]:checked').val();

              if(is_download == 'todayworks'){
                is_download = 'Y';
              } else {
                is_download = 'N';
              }
            $(".loaderClas").show();
            $("#addrefurbDetails").hide();
            $("#addrefurbCancle").hide();
            $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "stock/saveRefurb",
            dataType: 'json',
            data: {carId:carId,wcName: wcName,empName: empName,refurb: refurb,refurbsentOn: refurbsentOn,refurbestimated: refurbestimated,estimatedAmt: estimatedAmt,is_download:is_download,sent_km:kmdriven},
            success: function(data){
              $(".loaderClas").hide();
              if (parseInt(data.carId) > 0){
                  snakbarAlert("Refurb Details Added");

                  if(data.file_name != ''){
                    location.href = base_url + 'stock/downloadRefurbPdf?file='+data.file_name;
                  }

                  setTimeout(function () {
                   window.location.href = base_url + "inventoryListing";  
                  }, 2500);
                  $('#make-refurb').modal('hide');
                  return true;
              } else {
                  snakbarAlert("Refurb Details Not Added");
                  return false;
              } 
            }
        });
            }
   }
   function updaterefurb(){
            $('.error').html("");
            var carId = $("#carId").val();
            var caseId = $("#caseId").val();
            var refurb_details = $("#refurb_details").val();
            var return_date = $("#return_date").val();
            var tot_amt = $("#tot_amt").val().replace(/,/g,'');
            var is_download = $('input[name="checkprint"]:checked').val();
             var kmdriven = $("#km").val();
              var refurb = $.trim($("#refurb_details").val());
              
             
             if(return_date == ""){
              $("#returndate_error").text("please provide return date");
              return false;
             }
             
             if(tot_amt == ""){
               $("#totalamount_error").text("please provide actual amount");
              return false;   
             }
             
             if(refurb == ""){
              $("#refurb_details_error").text("Please provide refurb Details");
              return false;
             }
             
             

              if(is_download == 'todayworks'){
                is_download = 'Y';
              } else {
                is_download = 'N';
              }
            if(tot_amt==''){
               $("#tot_amt_error").html("Please enter Amount"); 
            }else{
              $(".loaderClas").show();
            $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "stock/updateRefurb",
            dataType: 'json',
            data: {carId:carId,caseId:caseId,refurb_details: refurb_details,return_date: return_date,tot_amt: tot_amt,return_km:kmdriven,is_download:is_download},
            success: function(data){
              $(".loaderClas").hide();
              $("#refub_up_button").hide();
              $("#refub_up_cancle").hide();
             if (data) {
                        snakbarAlert("Refurb Details Updated");
                        console.log(data);
                        if(data.file_name != ''){
                    location.href = base_url + 'stock/downloadRefurbPdf?file='+data.file_name;
                  }
                        
                        setTimeout(function () {
                         window.location.href = base_url + "inventoryListing";  
                        }, 2500);
                        $('#valid-refurb').modal('hide');
                        return true;
                    } else {
                        snakbarAlert("Refurb Details Not Updated");
                        return false;
                    } 
            }
        });
            }
   }
   function viewImgListStock(car_id,case_id,img_count,flaged_img_count=0,rej_img_count=0){

       if((img_count=='' || img_count==0) && flaged_img_count ==0 && rej_img_count ==0){
           window.location.href='<?php echo base_url() . 'cardetails/' ?>'+case_id;
           return false;
       }
        $('#model-uploadPhoto').modal('show');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "stock/viewnewEditedphotos",
            dataType: 'html',
            data: {car_id: car_id},
            success: function(data){
             $('#image-list').html(data);
            }
        });
   }
   function viewPremiumData(car_id,type, case_id){

        $('#make-premium').modal('show');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "stock/getFeaturehtml",
            dataType: 'html',
            data: {carId: car_id,type:type,case_id:case_id},
            success: function(data){
             $('#premium-modal-data').html(data);
            }
        });
   }
   function viewInspectionDetails(car_id){

        $('#model-issuewarrenty').modal('show');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "stock/getInspectionDetails",
            dataType: 'html',
            data: {car_id: car_id},
            success: function(data){
             $('#inspection_report').html(data);
            }
        });
   }
   function openAddLeadModal(car_id){
       document.getElementById("buyer_lead_form").reset();
        $('#model-add-buyer').modal('show');
        $('#lead_car_id').val(car_id);
   }
   function submit_buyer_lead(){
       $('.add_lead_err').html('');
       if($('#txtcustName').val().length<3){
           $('#txtcustName_err').show().html('Customer Name Should Have Min 3 characters');
           return true;
       }
       if(/^[6789][0-9]{9}$/.test($('#txtMobile').val())==false){
           $('#txtMobile_err').show().html('Invalid Mobile no.');
           return true;
       }
       if($('#lead_status').val()==''){
           $('#lead_status_err').show().html('Please Select Lead Status');
           return true;
       }
       if($('#follow-uo-date').val()==''){
           $('#followup_status_err').show().html('Please Select Follow-up Date');
           return true;
       }
       var car_id = $('#lead_car_id').val();
     //  alert('#leadcnt_'+car_id);
        var leadcnt = $('#leadcnt_'+car_id).html();
       // alert(leadcnt);
       $.ajax({
            type: "POST",
            url: "lead/addLead",
            dataType: 'json',
            data: $('#buyer_lead_form').serialize(),
            success: function(data){
                 $('#model-add-buyer').modal('hide');
                 snakbarAlert(data.msg);
                 if(data.status=='T'){
                 var c = parseInt(leadcnt)+1;
               //  alert(c);
                  $('#leadcnt_'+car_id).text(c);

                 }

            }
        });
   }

   function uploadmanagePhtos(){
   //$(document).on('click','#uploadmanagePhtos',function(ev){
       $('#uploadmanagePhtos').attr('class','btn btn-default active');
       $('#TagneweditedPhotos').attr('class','btn btn-default');
       $('#vieweditedphotos').attr('class','btn btn-default');
       var car_id = $('#carImgId').val();
   //alert(car_id);
   $.ajax({
       type: "POST",
       url: "<?php echo base_url(); ?>" + "stock/tagPhotoManageInv",
       dataType: 'html',
       data: {car_id: car_id},
       success: function(data){
        $('.shoImgg').html(data);
        var myDropzone = new Dropzone("form#stock-upload", { url: '<?php echo base_url(); ?>stock/upload_new_image/'+car_id});
   }
   });
   
   // });
   }
   
  function viewRefurbdata(car_id,type){

        $('#make-refurb').modal('show');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "stock/getRefurbhtml",
            dataType: 'html',
            data: {carId: car_id,type:type},
            success: function(data){
             $('#refurb-modal-data').html(data);
            }
        });
   } 
function viewRefurbvalid(car_id,type){
    $('#valid-refurb').modal('show');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "stock/getvalidRefurbhtml",
            dataType: 'html',
            data: {carId: car_id,type:type},
            success: function(data){
             $('#valid-refurb-modal-data').html(data);
            }
        });
    }    
function markAvailable(){
            var carId = $("#carId").val();
            var wcName = $("#wcName").val();
            var empName = $("#empName").val();
            var refurb = $("#txtrefurb").val();
            var refurbsentOn = $("#refurbsentOn").val();
            var refurbestimated = $("#refurbestimated").val();
            var estimatedAmt = $("#estimatedAmt").val();
            $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "stock/saveRefurb",
            //dataType: 'html',
            data: {carId:carId,wcName: wcName,empName: empName,refurb: refurb,refurbsentOn: refurbsentOn,refurbestimated: refurbestimated,estimatedAmt: estimatedAmt,},
            success: function(data){
             if (data) {
                        snakbarAlert("Refurb Details Added");
                        setTimeout(function () {
                         window.location.href = base_url + "inventoryListing";  
                        }, 2500);
                        $('#make-refurb').modal('hide');
                        return true;
                    } else {
                        snakbarAlert("Refurb Details Not Added");
                        return false;
                    } 
            }
        });
   }  


function processrefurb(e) {
    let code = (e.keyCode ? e.keyCode : e.which);
    let lines = $('#txtrefurb').val().split('\n');

    if (code == 13) { 
      realLength = parseInt(lines.length)-1;
      nextLength = parseInt(lines.length)+1;
      let data = '';
      let counter = 1;
      for(i=0;i<lines.length;i++){
        str = lines[i];
        str = str.replace(counter+'. ', "");
        str = counter+'. '+str;
        data += str;

        if(i!=realLength){
          data += '\n';
        }
        counter++;
      }
      document.getElementById('txtrefurb').value    =   data+'\n'+nextLength+'. ';
      
    } 
}

function processrefurbNew(e) {
    let code = (e.keyCode ? e.keyCode : e.which);
    let lines = $('#refurb_details').val().split('\n');
    if (code == 13) { 
      realLength = parseInt(lines.length)-1;
      nextLength = parseInt(lines.length)+1;
      let data = '';
      let counter = 1;
      for(i=0;i<lines.length;i++){
        str = lines[i];
        str = str.replace(counter+'. ', "");
        str = counter+'. '+str;
        data += str;

        if(i!=realLength){
          data += '\n';
        }
        counter++;
      }
      document.getElementById('refurb_details').value    =   data+'\n'+nextLength+'. ';;
    } 
}
 
</script>

<script src="<?=base_url('assets/admin_assets/js/jquery-ui/jquery-ui.js')?>"></script>
<script src="<?php echo base_url(); ?>assets/js/stock.js?t=<?=time();?>" type="text/javascript"></script>



