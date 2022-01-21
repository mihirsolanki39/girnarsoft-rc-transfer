<form method="get" name="searchform" id="searchform"   onsubmit="return false;">
        <input type="hidden" name="search_form" value=''>
        <input type="hidden" name="listType" id="listType" value="gaadi">
        <input type="hidden" name="download_excel" id="download_excel" value="">

        <div class=" clearfix " id="search-wraper">
            <div class="well well-filter" style="position:relative;">
                <img class="resultloader" src="<?php echo base_url(); ?>origin-assets/boot_origin_asset_new/images/loader.gif" style="position: absolute; left:630px; top: 180px; width: 50px;display:none; ">
                <div class="row ">


                    <div class="col-md-2 col-sm-6 pad-R5 tabpading">
                        <label for="exampleInputPassword1" class="form-label">Search :</label>
                        <div class="row row-text-box">
                            <div class="col-xs-12 mrg-all-0 sm-text-box"> 
                                <input type="text" id="car_id_reg_no" name="car_id_reg_no" style="font-size:10.5px; text-transform:uppercase;"  placeholder="Search by Reg No." class="form-control pad-L10" onkeydown="Javascript: if (event.keyCode == 13) {
                                                                    $('#inventory_search').click(); }" >                       	

                            </div>

                        </div>

                    </div>



                    <div class="col-md-3 col-sm-6 pad-LR tabpading">

                        <label for="exampleInputPassword1" class="form-label">Select a Car :</label>
                        <div class="row row-text-box">
                            <div class="col-xs-6 mrg-all-0 sm-text-box pad-LR">                        	
                                <select  class="form-control" name="make" id="make" >
                                    <option selected="selected" value="">Select Make</option>
                                    
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

                    </div>
                    <div class="col-md-2  col-sm-6 pad-LR tabpading">
                        <label for="exampleInputPassword1" class="form-label">Price Range :</label>
<?php if ($manage_dealer_inventory == 1)
{ ?><input type="hidden" name="manage_dealer_inventory" value="1" /><?php } ?>
                        <div class="row row-text-box">
                            <div class="col-xs-6 mrg-all-0 sm-text-box">                        	
                                <select class="form-control" id='select_price_min_list' name='select_price_min_list'>
                                    <option value=''>Min</option>
                                    <?php
                                    $minPriceArr = array('50000' => '50,000', '100000' => '1 Lakh', '200000' => '2 Lakh', '300000' => '3 Lakh', '400000' => '4 Lakh', '500000' => '5 Lakh', '600000' => '6 Lakh', '700000' => '7 Lakh', '800000' => '8 Lakh', '900000' => '9 Lakh', '1000000' => '10 Lakh', '1500000' => '15 Lakh', '2000000' => '20 Lakh', '2500000' => '25 Lakh', '3000000' => '30 Lakh');
                                    foreach ($minPriceArr as $minkey => $val)
                                    {
                                        ?>
                                        <option value="<?php echo $minkey; ?>"><?php echo $val; ?></option>
<?php }
?>
                                </select>
                            </div>
                            <div class="col-xs-6 mrg-all-0 sm-text-box">
                                <select class="form-control" id="select_price_max_list" name="select_price_max_list">
                                    <option value=''>Max</option>
                                    <?php
                                    $maxPriceArr = array('50000' => '50,000', '100000' => '1 Lakh', '200000' => '2 Lakh', '300000' => '3 Lakh', '400000' => '4 Lakh', '500000' => '5 Lakh', '600000' => '6 Lakh', '700000' => '7 Lakh', '800000' => '8 Lakh', '900000' => '9 Lakh', '1000000' => '10 Lakh', '1500000' => '15 Lakh', '2000000' => '20 Lakh', '2500000' => '25 Lakh', '3000000' => '30 Lakh', '4000000' => '40 Lakh', '5000000' => '50 Lakh', '6000000' => '60 Lakh', '7000000' => '70 Lakh', '8000000' => '80 Lakh', '9000000' => '90 Lakh', '10000000' => '1 Crore', '' => 'No Max');
                                    foreach ($maxPriceArr as $maxkey => $val)
                                    {
                                        ?>
                                        <option value="<?php echo $maxkey; ?>"><?php echo $val; ?></option>
<?php }
?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 pad-LR tabpading">
                        <label for="exampleInputPassword1" class="form-label">Year Range :</label>
                        <div class="row row-text-box">
                            <div class="col-xs-6 mrg-all-0 sm-text-box">                        	
                                <select class="form-control" id='select_myear_from_list' name="select_myear_from_list">
                                    <option value=''>From</option>
<?php for ($i = date("Y"); $i >= 1970; $i--)
{ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-xs-6 mrg-all-0 sm-text-box">
                                <select class="form-control" id='select_myear_to_list' name='select_myear_to_list'>
                                    <option value=''>To</option>
<?php for ($i = date("Y"); $i >= 1970; $i--)
{ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 pad-LR tabpading">
                        <label for="exampleInputPassword1" class="form-label">KM. Range :</label>
                        <div class="row row-text-box">
                            <div class="col-xs-6 mrg-all-0 sm-text-box">                        
                                <select class="form-control" id="select_km_max_list" name='select_km_min_list'>
                                    <option value=''>From</option>
<?php
for ($i = 10000; $i <= 100000; $i += 10000)
{
    ?>
                                        <option value="<?php echo $i; ?>"><?= $objInventory->indian_currency_form($i) ?></option>
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
                                        <option value="<?php echo $i; ?>"><?= $objInventory->indian_currency_form($i) ?></option>
    <?php
}
?>  
                                </select>
                            </div>
                        </div>
                    </div> 

                    <div class="col-md-2 col-sm-6 pad-LR tabpading">
                        <label for="exampleInputPassword1" class="form-label">Fuel Type:</label>
                        <div class="row row-text-box">

                            <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                <div class="posrelative text-left">
                                    <div class="multi-dropdwn form-control">
                                        <span>Fuel Type</span><span></span> <span class="pull-right caret"></span>
                                    </div>
                                    <ul class="dropdown-menu" role="menu" id='select_fuel_type_list'>   
                                        <?php
                                        if (isset($getDeatCarFuelArr) && count($getDeatCarFuelArr) > 0)
                                        {
                                            foreach ($getDeatCarFuelArr as $fuelVal)
                                            {
                                                ?>                                        

                                                <?php
                                                if (isset($postedData['fuel_type']) && $postedData['fuel_type'] != '')
                                                {
                                                    $fuelArr = explode(",", $postedData['fuel_type']);
                                                    if (in_array($fuelVal, $fuelArr))
                                                    {
                                                        $sel = 'checked';
                                                        // $imageName = "checked-icon.png";
                                                    }
                                                    else
                                                    {
                                                        $sel = '';
                                                        //$imageName = "checkbox.png";
                                                    }
                                                }
                                                else
                                                {
                                                    $sel = '';
                                                    //$imageName = "checkbox.png";
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
				<input type="hidden" name="old_stock" id="old_stock" value ="<?php echo $_GET['age_inventory'] ?>" />
                    <div class="col-md-2 col-sm-6 mrg-T10 tabpading pad-LR display-n advance-search">
                        <label for="exampleInputPassword1" class="form-label">Age Of Inventory :</label>
                        <div class="row row-text-box">
                            <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                <div class="posrelative text-left">
                                    <div class="multi-dropdwn form-control">
                                        <span>Age Of Inventory</span><span></span><span class="pull-right caret"></span>
                                    </div>
                                    <ul class="dropdown-menu" role="menu" id='select_age_inventory_list'>                                       
                                        <li class="pad-L5">
                                            <input type="checkbox" name="age_inventory[]" id="lastmonth" value="30_days" <?php echo $ageinventory = ($_POST['age_inventory'] == '30_days') ? "checked=checked" : ''; ?>>
                                            <label for="lastmonth"><span></span>Within 30 days</label>
                                        </li>
                                        <li class="pad-L5">
                                            <input type="checkbox" name="age_inventory[]" id="lastweek" value="btw_31_60_days" <?php echo $ageinventory = ($_POST['age_inventory'] == 'btw_31_60_days') ? "checked=checked" : ''; ?>>
                                            <label for="lastweek"><span></span>Between 31 to 60 days</label>
                                        </li>

                                        <li class="pad-L5">
                                            <input type="checkbox" name="age_inventory[]" id="last3month" value="btw_61_90_days" <?php echo $ageinventory = ($_POST['age_inventory'] == 'btw_61_90_days') ? "checked=checked" : ''; ?>>
                                            <label for="last3month"><span></span>Between 61 to 90 days</label>
                                        </li>
                                        <li class="pad-L5">
                                            <input type="checkbox" name="age_inventory[]" id="lastsixmonth" value="above_90_days" <?php echo $ageinventory = ($_POST['age_inventory'] == 'above_90_days') ? "checked=checked" : ''; ?>>
                                            <label for="lastsixmonth"><span></span>Above 90 days</label>
                                        </li>

                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-1  col-sm-6 tabpading pad-LR display-n advance-search mrg-T10">
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
    if (isset($postedData['owner']) && $postedData['owner'] != '')
    {
        $ownerSelArr = explode(",", $postedData['owner']);
        if (in_array($ownerVal, $ownerSelArr))
        {
            //$imageName = "checked-icon.png";
            $sel = 'checked';
        }
        else
        {
            //$imageName = "checkbox.png";
            $sel = '';
        }
    }
    else
    {
        //$imageName = "checkbox.png";
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
                    <!-- <div class="col-md-1 col-sm-6 tabpading pad-LR display-n advance-search mrg-T10">
                     <label for="exampleInputPassword1" class="form-label">Body Type :</label>
                             <div class="row row-text-box">
                             <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                  <div class="posrelative text-left">
                                     <div class="multi-dropdwn form-control">
                                         <span>Body Type</span><span></span><span class="pull-right caret"></span>
                                     </div>
                                       <ul class="dropdown-menu" role="menu" id="select_bodytype_list">
<?php
if (isset($getDeatCarBodyStyleArr) && count($getDeatCarBodyStyleArr) > 0)
{
    foreach ($getDeatCarBodyStyleArr as $bodyVal)
    {
        ?>
             
                                                             
        <?php
        if (isset($postedData['body_style']) && $postedData['body_style'] != '')
        {
            $bodySyleArr = explode(",", $postedData['body_style']);
            if (in_array($bodyVal, $bodySyleArr))
            {
                //$imageName = "checked-icon.png";
                $sel = 'checked';
            }
            else
            {
                //$imageName = "checkbox.png";
                $sel = '';
            }
        }
        else
        {
            //$imageName = "checkbox.png";
            $sel = '';
        }
        ?>  
                                                                                                                     <li class="pad-L5">
                                                                                                                     <input type="checkbox" name="body_type[]" id="<?php echo $bodyVal; ?>" value="<?php echo $bodyVal; ?>" <?php echo $sel; ?>>
                                                                                                                     <label for="<?php echo $bodyVal; ?>"><span></span> <?php echo $bodyVal; ?></label>
                                                                                                               </li>
                                                                
                                                <?php
                                            }
                                        }
                                        ?>
                                         
                                       </ul>
                                  </div>
                             </div>
                      
                         </div>
                     </div>  -->
<?php if ($_SESSION[dealer_owner] != 'Ford')
{ ?>	
                        <div class="col-md-2  col-sm-6 tabpading pad-LR display-n advance-search mrg-T10">
                            <label for="exampleInputPassword1" class="form-label">Inspection Status :</label>
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
                                                if (isset($postedData['inspection_status']) && $postedData['inspection_status'] != '')
                                                {
                                                    $ownerSelArr = explode(",", $postedData['inspection_status']);
                                                    if (in_array($insval, $inspectedSelArr))
                                                    {
                                                        //$imageName = "checked-icon.png";
                                                        $sel = 'checked';
                                                    }
                                                    else
                                                    {
                                                        //$imageName = "checkbox.png";
                                                        $sel = '';
                                                    }
                                                }
                                                else
                                                {
                                                    //$imageName = "checkbox.png";
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
                                        <?php } ?>
                    <!--<div class="col-md-1 col-sm-6 pad-LR tabpading display-n advance-search mrg-T10">
                        <label for="exampleInputPassword1" class="form-label">Transmission :</label>
                        <div class="row row-text-box">
                            <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                <div class="posrelative text-left">
                                    <div class="multi-dropdwn form-control">
                                        <span>Transmission</span><span></span><span class="pull-right caret"></span>
                                    </div>
                                    <ul class="dropdown-menu" role="menu" id="select_transmission_list">
<?php
/*if (isset($getDeatCarTransmissionArr) && count($getDeatCarTransmissionArr) > 0)
{
    foreach ($getDeatCarTransmissionArr as $transmissionVal)
    {*/
        ?>


                            <?php
                            /*if (isset($postedData['transmission']) && $postedData['transmission'] != '')
                            {
                                $transmissionArr = explode(",", $postedData['transmission']);
                                if (in_array($transmissionVal, $transmissionArr))
                                {
                                    //$imageName = "checked-icon.png";
                                    $sel = 'checked';
                                }
                                else
                                {
                                    //$imageName = "checkbox.png";
                                    $sel = '';
                                }
                            }
                            else
                            {
                                // $imageName = "checkbox.png";
                                $sel = '';
                            }*/
                            ?>  
                                                <li class="pad-L5">
                                                    <input type="checkbox" name="transmission_type[]" id="<?php echo $transmissionVal; ?> " value="<?php echo $transmissionVal; ?>" <?php echo $sel; ?>>
                                                    <label for="<?php //echo $transmissionVal; ?> "><span></span> <?php echo $transmissionVal; ?> </label>
                                                </li>

        <?php
    /*}
}*/
?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>-->

                    <div class="col-md-2  col-sm-6 pad-LR tabpading display-n advance-search">
                        <div class="row row-text-box">
                            <div class="col-xs-12 mrg-all-0 sm-text-box mrg-T20">                        	
                                <input   type="checkbox" id="car-withoutPhotos" name="car-withoutPhotos" <?php echo $carWithphotos1 = ($_REQUEST['car-withoutPhotos'] == 1) ? "checked=checked" : ''; ?>><label for="car-withoutPhotos"><span></span>
                                    Car Without Photos</label><br>
                                <input   type="checkbox" id="car-withPhotos" name="car-withPhotos" <?php echo $carWithphotos1 = ($_REQUEST['image'] == 1) ? "checked=checked" : ''; ?>><label for="car-withPhotos"><span></span>
                                    Car With Photos</label>
                            </div>
                        </div>
                    </div>
                                <?php if ($_SESSION[dealer_owner] != 'Ford')
                                { ?>

                                            <?php if ($manage_dealer_inventory != 1)
                                            { ?>
                            <div class="col-md-2  col-sm-6 pad-LR tabpading display-n advance-search">
                                <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box mrg-T20">                        	

                                        <input   type="checkbox" id="isclassified_tab" name="isclassified_tab" <?php echo $clstab        = ($_POST['isclassified_tab'] == 1) ? "checked=checked" : ''; ?> ><label for="isclassified_tab"><span></span>
                                            Classified Cars</label> <br>
                                             <input   type="checkbox" id="nonclassified_tab" name="nonclassified_tab" <?php echo $clstab = ($_REQUEST['nonclassified_tab']==1) ? "checked=checked" : ''; ?> ><label for="nonclassified_tab"><span></span>
                             Non Classified Cars</label>
                                        
                                             <!--<input  onclick="" type="checkbox" id="car-Eligible" name="bringontop" <?php echo $carWithphotos = (isset($postedData['bringontop']) && $postedData['bringontop'] == 'on') ? "checked=checked" : ''; ?>><label for="car-Eligible"><span></span>
                                               Eligible for bring to top</label>-->
                                    </div>
                                </div>
                            </div>
    <?php }
} ?>
<?php if ($_SESSION[dealer_owner] != 'Ford')
{ ?>
                        <div class="col-md-2  col-sm-6 pad-LR tabpading display-n advance-search">
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box mrg-T20">                        	
                                    <input  onclick="" type="checkbox" id="car-Premium" name="ispremium" <?php echo $carWithphotos = ((isset($_REQUEST['ispremium']) && $_REQUEST['ispremium'] == 'on') || ($_REQUEST['premium'] == 1)) ? "checked=checked" : ''; ?>><label for="car-Premium"><span></span>
                                        Featured Cars</label>
                                        <input   type="checkbox" id="trustmark-certified" name="trustmark-certified" ><label for="trustmark-certified"><span></span>
                                            Trustmark Certified</label>
                                        <!--<br>
                                         <input   type="checkbox" id="is_rsa" name="is_rsa" <?php echo ($_REQUEST['is_rsa'] == 1) ? "checked=checked" : ''; ?> ><label for="is_rsa"><span></span>
                                        Eligible for RSA</label>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2  col-sm-6 pad-LR tabpading display-n advance-search">
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box mrg-T20">                        	
                                    <input  onclick="" type="checkbox" id="car_with_issues" name="car_with_issues" <?php echo ($_REQUEST['photo_issue'] == 1) ? "checked=checked" : ''; ?>><label for="car_with_issues"><span></span>Cars With Issues</label>
                                </div>
                            </div>
                        </div>
<?php } ?>	
<?php if ($_SESSION[dealer_owner] == 'Ford')
{ ?>
                        <div  class="col-md-2 col-sm-6 pad-LR tabpading display-n advance-search mrg-T10">
                            <label for="exampleInputPassword1" class="form-label">Search Stock</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                    <div class="posrelative text-left">
                                        <div class="multi-dropdwn form-control">
                                            <span>QC State</span><span></span><span class="pull-right caret"></span>
                                        </div>
                                        <ul class="dropdown-menu" role="menu" id="select_flag_list" >
                                                    <li class="pad-L5">
                                                        <input type="checkbox" name="qc_state[]" id="need_qc" value="need_qc">
                                                        <label for="need_qc"><span></span>Need QC</label>
                                                    </li>
                                                    <li class="pad-L5">
                                                        <input type="checkbox" name="qc_state[]" id="redo_qc" value="redo_qc">
                                                        <label for="redo_qc"><span></span>Redo QC</label>
                                                    </li>
                                                    <li class="pad-L5">
                                                        <input type="checkbox" name="qc_state[]" id="approved" value="approved">
                                                        <label for="approved"><span></span>Approved</label>
                                                    </li>
                                                    <li class="pad-L5">
                                                        <input type="checkbox" name="qc_state[]" id="delisted" value="delisted">
                                                        <label for="delisted"><span></span>Rejected</label>
                                                    </li>
                                                    <li class="pad-L5">
                                                        <input type="checkbox" name="qc_state[]" id="hold" value="hold">
                                                        <label for="hold"><span></span>Partially Approved</label>
                                                    </li>
                                                   
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>      
<?php } ?>	

                    <div class="col-md-2 pad-LR pull-right">
                        <div class="row row-text-box">
                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                <label for="exampleInputPassword1" class="form-label"></label>
                                <button type="button" id="inventory_search" class="btn btn-primary mrg-T20" onclick="pagee = 0;getResults();">Search</button>
                                <button type="button" class="btn btn-default mrg-T20" onClick="document.searchform.reset();
                                    $('option:selected').removeAttr('selected');
                                    $('input:checkbox').removeAttr('checked');
                                    $('#car-Premium').attr('checked', false);
                                    $('#is_rsa').attr('checked', false);$('#car-withPhotos').attr('checked', false);$('#car_id_reg_no').val('');
                                    $('#select_fuel_type_list,#select_age_inventory_list,#select_owner_list,#select_bodytype_list,#select_transmission_list,#select_flag_list').trigger('click');
                                    $('#carid').val('');
                                    pagee = 0;
                                    getResults();
                                    $('select[name=select_price_min_list] option,select[name=select_price_max_list] option,select[name=select_km_min_list] option,select[name=select_km_max_list] option,select[name=select_myear_from_list] option,select[name=select_myear_to_list] option').show();$('#model').attr('disabled', 'disabled');">Reset</button><br>
                                <a class="btn-block advanced-search-btn pad-L10 mrg-T5 font-12" onclick="$('#serch-wrapper').toggleClass('min_height_235');" href="javascript:void(0);">
                                    <i class="fa fa-plus-square-o down font-14 mrg-R5" data-unicode="f01a"></i><i class="fa fa-minus-square-o up font-14 mrg-R5" data-unicode="f01b" style="display:none;"></i>Advanced Search</a>
                            </div>

                        </div>
                    </div>

                </div>
                <input type="hidden" value="<?php if ($manage_dealer_inventory == 1)
{
    echo 'dealer_platform';
} ?>" name="tab_value" id="tab_value" />
                <input type="hidden" value="" name="sort_by" id="sort_by" />
                <input type="hidden" name="issue_old_stock" id="issue_old_stock" value ="<?php echo $_GET['issueOldStock'] ?>" >
                <input type="hidden" name="issue_year_km" id="issue_year_km" value ="<?php echo $_GET['issueMYKm'] ?>" >
                <input type="hidden" name="pending_leads" id="pending_leads" value ="<?php echo $_GET['issuePendingLeads'] ?>" >
                <input type="hidden" name="total_active_leads" id="total_active_leads" value ="<?php echo $_GET['issueTooManyLeads'] ?>" >
                <input type="hidden" name="doubtfull_inventory" id="doubtfull_inventory" value ="<?php echo $_GET['doubtfull_inventory'] ?>" >
                </form>

            </div>
        </div><!-- /End Search Filter -->
    </form>